<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendrier_activites_model extends CI_Model
{
    protected $table = 'calendrier_activites';


    public function add($calendrier_activites)
    {
        $this->db->set($this->_set($calendrier_activites))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $calendrier_activites)
    {
        $this->db->set($this->_set($calendrier_activites))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($calendrier_activites)
    {
        return array(            
            'mois'       => $calendrier_activites['mois'],
            'activite'  => $calendrier_activites['activite'],
            'duree'  => $calendrier_activites['duree'],      
            'id_pac'    => $calendrier_activites['id_pac']
        );
    }

    public function add_down($calendrier_activites, $id)  {
        $this->db->set($this->_set_down($calendrier_activites, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($calendrier_activites, $id)
    {
        return array(
            'mois'       => $calendrier_activites['mois'],
            'activite'  => $calendrier_activites['activite'],
            'duree'  => $calendrier_activites['duree'],      
            'id_pac'    => $calendrier_activites['id_pac']
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
    public function getcalendrier_activitesbypac($id_pac)
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
