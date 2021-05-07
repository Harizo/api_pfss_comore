<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zip_model extends CI_Model
{
    protected $table = 'zip';


    public function add($zip)
    {
        $this->db->set($this->_set($zip))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $zip)
    {
        $this->db->set($this->_set($zip))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($zip)
    {
        return array(
            'code'    =>      $zip['code'],
            'libelle' =>      $zip['libelle']                       
        );
    }
    public function add_down($zip, $id)  {
        $this->db->set($this->_set_down($zip, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($zip, $id) {
        return array(
            'id' => $id,
            'code' => $zip['code'],
            'libelle' => $zip['libelle']
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
    public function findByCode($code)
    {
        $this->db->where("code", $code);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

}
