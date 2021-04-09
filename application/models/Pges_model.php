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
            'id_sous_projet' => $pges['id_sous_projet'] 
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
            'id_sous_projet' => $pges['id_sous_projet'] 
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

}
