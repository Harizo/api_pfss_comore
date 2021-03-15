<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activite_act_model extends CI_Model
{
    protected $table = 'activite_act';


    public function add($activite_act)
    {
        $this->db->set($this->_set($activite_act))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $activite_act)
    {
        $this->db->set($this->_set($activite_act))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($activite_act)
    {
        return array(
            'code'    =>      $activite_act['code'],
            'libelle' =>      $activite_act['libelle'],
            'id_type_activite_act' =>      $activite_act['id_type_activite_act']                      
        );
    }

    public function add_down($activite_act, $id)  {
        $this->db->set($this->_set_down($activite_act, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($activite_act, $id)
    {
        return array(
            'id' => $id,
            'code' => $activite_act['code'],
            'libelle' => $activite_act['libelle'],
            'id_type_activite_act' =>      $activite_act['id_type_activite_act'] 
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

    public function getactivite_actbytype($id_type_activite_act)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_activite_act',$id_type_activite_act)
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
