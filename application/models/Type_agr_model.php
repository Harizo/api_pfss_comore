<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_agr_model extends CI_Model
{
    protected $table = 'type_agr';


    public function add($type_agr)
    {
        $this->db->set($this->_set($type_agr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $type_agr)
    {
        $this->db->set($this->_set($type_agr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($type_agr)
    {
        return array(
            'code'    =>      $type_agr['code'],
            'libelle' =>      $type_agr['libelle']                       
        );
    }
    public function add_down($type_agr, $id)  {
        $this->db->set($this->_set_down($type_agr, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($type_agr, $id) {
        return array(
            'id' => $id,
            'code' => $type_agr['code'],
            'libelle' => $type_agr['libelle']
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
