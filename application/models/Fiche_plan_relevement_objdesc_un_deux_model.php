<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_plan_relevement_objdesc_un_deux_model extends CI_Model {
    protected $table = 'fiche_plan_relevement_objdesc_un_deux';

    public function add($fiche_plan_relevement_objdesc_un_deux)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_un_deux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_plan_relevement_objdesc_un_deux)  {
        $this->db->set($this->_set($fiche_plan_relevement_objdesc_un_deux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_plan_relevement_objdesc_un_deux) 
    {
        return array
        (
            'id_identification'             => $fiche_plan_relevement_objdesc_un_deux['id_identification'],
            'objectif'                      => $fiche_plan_relevement_objdesc_un_deux['objectif'],
            'cycle'                         => $fiche_plan_relevement_objdesc_un_deux['cycle'],
            'disponibilite_intrant'         => $fiche_plan_relevement_objdesc_un_deux['disponibilite_intrant'],
            'disponibilite_terrain'         => $fiche_plan_relevement_objdesc_un_deux['disponibilite_terrain'],
            'capacite_technique'            => $fiche_plan_relevement_objdesc_un_deux['capacite_technique']
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