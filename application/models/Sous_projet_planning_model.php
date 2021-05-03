<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_planning_model extends CI_Model
{
    protected $table = 'sous_projet_planning';


    public function add($sous_projet_planning)
    {
        $this->db->set($this->_set($sous_projet_planning))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_planning)
    {
        $this->db->set($this->_set($sous_projet_planning))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_planning)
    {
        return array(
            'code'    =>      $sous_projet_planning['code'],
            'phase_activite' =>      $sous_projet_planning['phase_activite'],
            'numero_phase'    =>      $sous_projet_planning['numero_phase'],
            'id_sous_projet_localisation' =>      $sous_projet_planning['id_sous_projet_localisation']                      
        );
    }

    public function add_down($sous_projet_planning, $id)  {
        $this->db->set($this->_set_down($sous_projet_planning, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_planning, $id)
    {
        return array(
            'id' => $id,
            'code'    =>      $sous_projet_planning['code'],
            'phase_activite' =>      $sous_projet_planning['phase_activite'],
            'numero_phase'    =>      $sous_projet_planning['numero_phase'],
            'id_sous_projet_localisation' =>      $sous_projet_planning['id_sous_projet_localisation'] 
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

    public function getsous_projet_planningbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
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
