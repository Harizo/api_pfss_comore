<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_plan_production_trois_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_plan_production_trois';

    public function add($fiche_plan_relevement_plan_production_trois)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_trois))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_plan_production_trois)  {
        $this->db->set($this->_set($fiche_plan_relevement_plan_production_trois))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_plan_production_trois) 
    {
        return array
        (
            'id_identification'                          => $fiche_plan_relevement_plan_production_trois['id_identification'],
            'activite'                                   => $fiche_plan_relevement_plan_production_trois['activite'],
            'lieu_production'                            => $fiche_plan_relevement_plan_production_trois['lieu_production'],
            'lieu_approvisionnement_intrant'             => $fiche_plan_relevement_plan_production_trois['lieu_approvisionnement_intrant'],
            'lieu_ecoulement_produit'                    => $fiche_plan_relevement_plan_production_trois['lieu_ecoulement_produit']
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
    
 
    public function findBy_id_identification($id_identification)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_identification", $id_identification)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }

}
?>