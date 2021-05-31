<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phaseexecution_model extends CI_Model
{
    protected $table = 'see_phaseexecution';


    public function add($phaseexecution)
    {
        $this->db->set($this->_set($phaseexecution))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $phaseexecution)
    {
        $this->db->set($this->_set($phaseexecution))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($phaseexecution)
    {
        return array(
            'Code' => $phaseexecution['Code'],
            'Phase' => $phaseexecution['Phase'],
            'id_sous_projet' => $phaseexecution['id_sous_projet'],
            'indemnite'     => $phaseexecution['indemnite'],
            'pourcentage'     => $phaseexecution['pourcentage']                   
        );
    }

    public function add_down($phaseexecution, $id)  {
        $this->db->set($this->_set_down($phaseexecution, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($phaseexecution, $id)
    {
        return array(
            'Code' => $phaseexecution['Code'],
            'Phase' => $phaseexecution['Phase'],
            'id_sous_projet' => $phaseexecution['id_sous_projet'],
            'indemnite'     => $phaseexecution['indemnite'],
            'pourcentage'   => $phaseexecution['pourcentage']
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
                        ->order_by('id_sous_projet','asc')
                        ->order_by('Code','asc')
                        ->order_by('id','asc')
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
