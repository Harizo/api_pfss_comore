<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_infrastructure_model extends CI_Model
{
    protected $table = 'type_infrastructure';


    public function add($type_infrastructure)
    {
        $this->db->set($this->_set($type_infrastructure))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $type_infrastructure)
    {
        $this->db->set($this->_set($type_infrastructure))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($type_infrastructure)
    {
        return array(
            'code'    =>      $type_infrastructure['code'],
            'libelle' =>      $type_infrastructure['libelle']                       
        );
    }
    public function add_down($type_infrastructure, $id)  {
        $this->db->set($this->_set_down($type_infrastructure, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($type_infrastructure, $id) {
        return array(
            'id' => $id,
            'code' => $type_infrastructure['code'],
            'libelle' => $type_infrastructure['libelle']
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
                        ->order_by('code')
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