<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pac_detail_model extends CI_Model
{
    protected $table = 'pac_detail';


    public function add($pac_detail)
    {
        $this->db->set($this->_set($pac_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $pac_detail)
    {
        $this->db->set($this->_set($pac_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($pac_detail)
    {
        return array(            
            'numero'       => $pac_detail['numero'],            
            'besoin'       => $pac_detail['besoin'],
            'cout'  => $pac_detail['cout'],
            'duree'  => $pac_detail['duree'],      
            'calendrier_activite'    => $pac_detail['calendrier_activite'],      
            'id_pac'    => $pac_detail['id_pac']
        );
    }

    public function add_down($pac_detail, $id)  {
        $this->db->set($this->_set_down($pac_detail, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($pac_detail, $id)
    {
        return array(           
            'numero'       => $pac_detail['numero'],            
            'besoin'       => $pac_detail['besoin'],
            'cout'  => $pac_detail['cout'],
            'duree'  => $pac_detail['duree'],      
            'calendrier_activite'    => $pac_detail['calendrier_activite'],     
            'id_pac'    => $pac_detail['id_pac']
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
    public function getpac_detailbypac($id_pac)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_pac',$id_pac)
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
