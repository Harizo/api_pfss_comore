<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_objdesc_trois_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_objdesc_trois';

    public function add($fiche_plan_relevement_objdesc_trois)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_trois))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_objdesc_trois)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_trois))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_objdesc_trois) 
    {
        return array
        (
            'id_identification'             => $fiche_plan_relevement_objdesc_trois['id_identification'],
            'formation'                     => $fiche_plan_relevement_objdesc_trois['formation'],
            'encadrement'                   => $fiche_plan_relevement_objdesc_trois['encadrement'],
            'suivi'                         => $fiche_plan_relevement_objdesc_trois['suivi']
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