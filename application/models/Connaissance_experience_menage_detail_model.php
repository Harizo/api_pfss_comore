<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Connaissance_experience_menage_detail_model extends CI_Model {
    protected $table = 'connaissance_experience_menage_detail';

   /* public function getAll(controller) {                               
            $this->db->set($this)

        } */

    public function add($Connaissance_experience_menage_detail)  {
        $this->db->set($this->_set($Connaissance_experience_menage_detail))

                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $Connaissance_experience_menage_detail)  {
        $this->db->set($this->_set($Connaissance_experience_menage_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($Connaissance_experience_menage_detail) { 
        return array(             
            'id_activite_realise_auparavant' => $Connaissance_experience_menage_detail['id_activite_realise_auparavant'],
            'id_fiche_profilage_orientation' => $Connaissance_experience_menage_detail['id_fiche_profilage_orientation'],
            'difficulte_rencontre' => $Connaissance_experience_menage_detail['difficulte_rencontre'],
            'nbr_annee_activite' => $Connaissance_experience_menage_detail['nbr_annee_activite'],
            'formation_acquise' => $Connaissance_experience_menage_detail['formation_acquise']
        );
    }
    
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findByficheprofilage($cle_etrangere)
    {
        $this->db->select("
                            activite_realise_auparavant.description as activite_realise_auparavant_description,
                            activite_realise_auparavant.id as id_activite_realise_auparavant_prevu");
    
            $this->db ->select("(select connaissance_detail.id 
                                 from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                          and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as id",FALSE);

            $this->db ->select("(select connaissance_detail.id_activite_realise_auparavant 
                                                            
                                 from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                          and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as id_activite_realise_auparavant",FALSE);
            $this->db ->select("(select connaissance_detail.autre_activite_realise_auparavant 
                                        
                                from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                            and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as autre_activite_realise_auparavant",FALSE);

            $this->db ->select("(select connaissance_detail.difficulte_rencontre 
                                        
                                from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                            and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as difficulte_rencontre",FALSE);

            $this->db ->select("(select connaissance_detail.nbr_annee_activite 
                                        
                                from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                            and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as nbr_annee_activite",FALSE);

            $this->db ->select("(select connaissance_detail.formation_acquise 
                                        
                                from connaissance_experience_menage_detail as connaissance_detail 
                                    inner join activite_realise_auparavant as activite_auparavant on activite_auparavant.id=connaissance_detail.id_activite_realise_auparavant
                                    where connaissance_detail.id_activite_realise_auparavant=id_activite_realise_auparavant_prevu   
                                            and connaissance_detail.id_fiche_profilage_orientation='".$cle_etrangere."'
                                ) as formation_acquise",FALSE);
                
    
        $result =  $this->db->from('activite_realise_auparavant')
                            //->join('pv_consta_rubrique_phase_mob','pv_consta_rubrique_designation_mob.id_rubrique_phase=pv_consta_rubrique_phase_mob.id')
                          
                            ->order_by('activite_realise_auparavant.id')
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
        }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        //->order_by('niveau_formation')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
}
?>