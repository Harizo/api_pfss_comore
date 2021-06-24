<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_plan_relevement_materiel_model extends CI_Model {
    protected $table = 'fiche_suivi_plan_relevement_materiel';

    public function add($fiche_suivi_plan_relevement_materiel)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_materiel))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_plan_relevement_materiel)  {
        $this->db->set($this->_set($fiche_suivi_plan_relevement_materiel))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_plan_relevement_materiel) 
    {
        return array
        (
            

            'id_fspr'             => $fiche_suivi_plan_relevement_materiel['id_fspr'],
            'designation'         => $fiche_suivi_plan_relevement_materiel['designation'],
            'quantite'            => $fiche_suivi_plan_relevement_materiel['quantite'],
            'prix_unitaire'       => $fiche_suivi_plan_relevement_materiel['prix_unitaire'],
            'observation'         => $fiche_suivi_plan_relevement_materiel['observation']
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
    
 
    public function findBy_id_fspr($id_fspr)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fspr", $id_fspr)
                      
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