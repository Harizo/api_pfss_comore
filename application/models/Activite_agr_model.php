<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activite_agr_model extends CI_Model
{
    protected $table = 'activite_agr';


    public function add($activite_agr)
    {
        $this->db->set($this->_set($activite_agr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $activite_agr)
    {
        $this->db->set($this->_set($activite_agr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($activite_agr)
    {
        return array(
            'code'    =>      $activite_agr['code'],
            'libelle' =>      $activite_agr['libelle'],
            'id_type_agr' =>      $activite_agr['id_type_agr']                      
        );
    }

    public function add_down($activite_agr, $id)  {
        $this->db->set($this->_set_down($activite_agr, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($activite_agr, $id)
    {
        return array(
            'id' => $id,
            'code' => $activite_agr['code'],
            'libelle' => $activite_agr['libelle'],
            'id_type_agr' =>      $activite_agr['id_type_agr'] 
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

    public function getactivite_agrbytype($id_type_agr)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_type_agr',$id_type_agr)
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
