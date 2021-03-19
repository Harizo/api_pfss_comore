<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_planning_activite_model extends CI_Model
{
    protected $table = 'sous_projet_planning_activite';


    public function add($sous_projet_planning_activite)
    {
        $this->db->set($this->_set($sous_projet_planning_activite))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_planning_activite)
    {
        $this->db->set($this->_set($sous_projet_planning_activite))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_planning_activite)
    {
        return array(
            'semaine'    =>      $sous_projet_planning_activite['semaine'],
            'description' =>      $sous_projet_planning_activite['description'],
            'id_planning' =>      $sous_projet_planning_activite['id_planning']                      
        );
    }

    public function add_down($sous_projet_planning_activite, $id)  {
        $this->db->set($this->_set_down($sous_projet_planning_activite, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_planning_activite, $id)
    {
        return array(
            'id' => $id,
            'semaine'    =>      $sous_projet_planning_activite['semaine'],
            'description' =>      $sous_projet_planning_activite['description'],
            'id_planning' =>      $sous_projet_planning_activite['id_planning'] 
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
                        ->order_by('semaine')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getplanning_activitebyplanning($id_planning)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_planning',$id_planning)
                        ->order_by('semaine')
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
