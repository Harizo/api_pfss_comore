<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class outils_communication_model extends CI_Model
{
    protected $table = 'outils_communication_ml';


    public function add($outils_communication)
    {
        $this->db->set($this->_set($outils_communication))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $outils_communication)
    {
        $this->db->set($this->_set($outils_communication))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($outils_communication)
    {
        return array(
            'outils_communication'    =>      $outils_communication['outils_communication'],
            'id_formation_ml' =>      $outils_communication['id_formation_ml']                      
        );
    }

    public function add_down($outils_communication, $id)  {
        $this->db->set($this->_set_down($outils_communication, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($outils_communication, $id)
    {
        return array(
            'id' => $id,
            'outils_communication' => $outils_communication['outils_communication'],
            'id_formation_ml' =>      $outils_communication['id_formation_ml'] 
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
                        ->order_by('outils_communication')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getoutils_communicationbyformation($id_formation_ml)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_formation_ml',$id_formation_ml)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    /*public function getoutils_communicationbyformation($id)
    {
        $this->db->where("id_formation_ml", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }*/
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
