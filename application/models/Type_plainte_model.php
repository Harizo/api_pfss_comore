<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_plainte_model extends CI_Model {
    protected $table = 'see_typeplainte';

    public function add($typeplainte)  {
        $this->db->set($this->_set($typeplainte))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($typeplainte, $id)  {
        $this->db->set($this->_set_down($typeplainte, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $typeplainte)  {
        $this->db->set($this->_set($typeplainte))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($typeplainte) {
        return array(
            'Code'             => $typeplainte['Code'],
            'TypePlainte'      => $typeplainte['TypePlainte'],
            'programme_id'     => $typeplainte['programme_id'],
            'a_ete_modifie'    => $typeplainte['a_ete_modifie'],
            'supprime'         => $typeplainte['supprime'],
            'userid'           => $typeplainte['userid'],
            'datemodification' => $typeplainte['datemodification'],
        );
    }

    public function _set_down($typeplainte, $id) {
        return array(
            'id'               => $id,
            'Code'             => $typeplainte['Code'],
            'TypePlainte'      => $typeplainte['TypePlainte'],
            'programme_id'     => $typeplainte['programme_id'],
            'a_ete_modifie'    => $typeplainte['a_ete_modifie'],
            'supprime'         => $typeplainte['supprime'],
            'userid'           => $typeplainte['userid'],
            'datemodification' => $typeplainte['datemodification'],
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
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('Code')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
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