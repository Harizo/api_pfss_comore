<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phaseexection_model extends CI_Model
{
    protected $table = 'see_phaseexection';


    public function add($phaseexection)
    {
        $this->db->set($this->_set($phaseexection))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $phaseexection)
    {
        $this->db->set($this->_set($phaseexection))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($phaseexection)
    {
        return array(
            'Code' => $phaseexection['Code'],
            'Phase' => $phaseexection['Phase'],
            'montantalloue' => $phaseexection['montantalloue'],
            'indemnite'     => $phaseexection['indemnite'],
            'datedebut'     => $phaseexection['datedebut'],
            'datefin'       => $phaseexection['datefin']                    
        );
    }

    public function add_down($phaseexection, $id)  {
        $this->db->set($this->_set_down($phaseexection, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($phaseexection, $id)
    {
        return array(
            'Code' => $phaseexection['Code'],
            'Phase' => $phaseexection['Phase'],
            'montantalloue' => $phaseexection['montantalloue'],
            'indemnite'     => $phaseexection['indemnite'],
            'datedebut'     => $phaseexection['datedebut'],
            'datefin'       => $phaseexection['datefin']
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
                        ->order_by('datedebut')
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
