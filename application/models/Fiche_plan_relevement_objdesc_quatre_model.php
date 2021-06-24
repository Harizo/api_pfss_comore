<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_objdesc_quatre_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_objdesc_quatre';

    public function add($fiche_plan_relevement_objdesc_quatre)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_quatre))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_objdesc_quatre)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_quatre))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_objdesc_quatre) 
    {
        return array
        (
            'id_identification'             => $fiche_plan_relevement_objdesc_quatre['id_identification'],
            'risque_eventuelle'             => $fiche_plan_relevement_objdesc_quatre['risque_eventuelle'],
            'solution_prevu'                => $fiche_plan_relevement_objdesc_quatre['solution_prevu']
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
            return null;
        }                 
    }

}
?>