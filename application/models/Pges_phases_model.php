<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pges_phases_model extends CI_Model
{
    protected $table = 'pges_phases';


    public function add($pges_phases)
    {
        $this->db->set($this->_set($pges_phases))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $pges_phases)
    {
        $this->db->set($this->_set($pges_phases))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($pges_phases)
    {
        return array(            
            'description'=> $pges_phases['description'],            
            'impacts'=> $pges_phases['impacts'],      
            'mesures'=> $pges_phases['mesures'],      
            'responsable'=> $pges_phases['responsable'],
            'calendrier_execution'=> $pges_phases['calendrier_execution'],      
            'cout_estimatif'=> $pges_phases['cout_estimatif'],      
            'id_pges'=> $pges_phases['id_pges']
        );
    }

    public function add_down($pges_phases, $id)  {
        $this->db->set($this->_set_down($pges_phases, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($pges_phases, $id)
    {
        return array(            
            'description'=> $pges_phases['description'],
            'impacts'=> $pges_phases['impacts'],      
            'mesures'=> $pges_phases['mesures'],      
            'responsable'=> $pges_phases['responsable'],
            'calendrier_execution'=> $pges_phases['calendrier_execution'],      
            'cout_estimatif'=> $pges_phases['cout_estimatif'],      
            'id_pges'=> $pges_phases['id_pges']
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
                        ->order_by('id_pges')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function getphasesbypges($id_pges)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_pges',$id_pges)
                        ->order_by('id_pges')
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
