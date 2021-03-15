<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_activite_act_model extends CI_Model
{
    protected $table = 'type_activite_act';


    public function add($type_activite_act)
    {
        $this->db->set($this->_set($type_activite_act))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $type_activite_act)
    {
        $this->db->set($this->_set($type_activite_act))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($type_activite_act)
    {
        return array(
            'code'    =>      $type_activite_act['code'],
            'libelle' =>      $type_activite_act['libelle']                       
        );
    }
    public function add_down($type_activite_act, $id)  {
        $this->db->set($this->_set_down($type_activite_act, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($type_activite_act, $id) {
        return array(
            'id' => $id,
            'code' => $type_activite_act['code'],
            'libelle' => $type_activite_act['libelle']
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
