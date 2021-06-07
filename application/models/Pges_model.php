<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pges_model extends CI_Model
{
    protected $table = 'pges';


    public function add($pges)
    {
        $this->db->set($this->_set($pges))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $pges)
    {
        $this->db->set($this->_set($pges))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($pges)
    {
        return array(                
            'bureau_etude'=> $pges['bureau_etude'],      
            'ref_contrat'=> $pges['ref_contrat'],     
            'description_env'=> $pges['description_env'],       
            'composante_zone_susce'=> $pges['composante_zone_susce'],      
            'probleme_env'=> $pges['probleme_env'],      
            'mesure_envisage'=> $pges['mesure_envisage'],         
            'observation'=> $pges['observation'],      
            'nom_prenom_etablissement'=> $pges['nom_prenom_etablissement'],     
            'nom_prenom_validation'=> $pges['nom_prenom_validation'],     
            'date_etablissement'=> $pges['date_etablissement'],    
            'date_visa_ugp'=> $pges['date_visa_ugp'],    
            'nom_prenom_ugp'=> $pges['nom_prenom_ugp'],   
            'id_sous_projet' => $pges['id_sous_projet'],   
            'id_village' => $pges['id_village'],   
            'id_infrastructure' => $pges['id_infrastructure'],   
            'montant_total' => $pges['montant_total']  
        );
    }

    public function add_down($pges, $id)  {
        $this->db->set($this->_set_down($pges, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($pges, $id)
    {
        return array(    
            'bureau_etude'=> $pges['bureau_etude'],      
            'ref_contrat'=> $pges['ref_contrat'],     
            'description_env'=> $pges['description_env'],       
            'composante_zone_susce'=> $pges['composante_zone_susce'],      
            'probleme_env'=> $pges['probleme_env'],      
            'mesure_envisage'=> $pges['mesure_envisage'],         
            'observation'=> $pges['observation'],      
            'nom_prenom_etablissement'=> $pges['nom_prenom_etablissement'],     
            'nom_prenom_validation'=> $pges['nom_prenom_validation'],     
            'date_etablissement'=> $pges['date_etablissement'],    
            'date_visa_ugp'=> $pges['date_visa_ugp'],    
            'nom_prenom_ugp'=> $pges['nom_prenom_ugp'],   
            'id_sous_projet' => $pges['id_sous_projet'],   
            'id_village' => $pges['id_village'],   
            'id_infrastructure' => $pges['id_infrastructure'],   
            'montant_total' => $pges['montant_total'] 
        );
    }

    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }


    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function getpgesbysousprojet($id_sous_projet)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_sous_projet',$id_sous_projet)
                        ->order_by('id_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

    public function getpgesBysousprojetvillage($id_sous_projet,$id_village)
    {
        $requete= "select pges.*
                    from pges where pges.id_sous_projet='".$id_sous_projet."' 
                        and pges.id_village='".$id_village."'";
		$query = $this->db->query($requete);
        $result= $query->result();				
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function get_pges_montant_differant()
    {
        $requete= "select detail.*
                        from

                        (select pges.*, 
                                pges.id as id_pge,
                                (select sum(pges_phases.cout_estimatif) from pges_phases 
                                    where pges_phases.id_pges=id_pge) as montant_phase,
                                sous_projet.type as type_sous_projet,
                                infrastructure.code_passation as code_infrastructure,
                                infrastructure.libelle as libelle_infrastructure,
                                see_village.Village as nom_village,
                                see_commune.Commune as nom_commune,
                                see_region.Region as nom_region,
                                see_ile.Ile as nom_ile
                        from pges 
                                inner join sous_projet on sous_projet.id = pges.id_sous_projet
                                inner join infrastructure on infrastructure.id= pges.id_infrastructure
                                inner join see_village on see_village.id= pges.id_village
                                inner join see_commune on see_commune.id=see_village.commune_id
                                inner join see_region on see_region.id=see_commune.region_id
                                inner join see_ile on see_ile.id = see_region.ile_id
                                    GROUP BY pges.id) as detail
                            WHERE detail.montant_total<>detail.montant_phase OR detail.montant_phase is null
                                GROUP BY detail.id
                        
                    ";
		$query = $this->db->query($requete);
        $result= $query->result();				
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }

}
