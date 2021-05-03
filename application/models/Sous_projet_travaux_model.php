<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_travaux_model extends CI_Model
{
    protected $table = 'sous_projet_travaux';


    public function add($sous_projet_travaux)
    {
        $this->db->set($this->_set($sous_projet_travaux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_travaux)
    {
        $this->db->set($this->_set($sous_projet_travaux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_travaux)
    {
        return array(
            'activites'    =>      $sous_projet_travaux['activites'],
            'unite' =>      $sous_projet_travaux['unite'],
            'quantite'    =>      $sous_projet_travaux['quantite'],
            'observation' =>      $sous_projet_travaux['observation'],
            'id_sous_projet_localisation' =>      $sous_projet_travaux['id_sous_projet_localisation']                      
        );
    }

    public function add_down($sous_projet_travaux, $id)  {
        $this->db->set($this->_set_down($sous_projet_travaux, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_travaux, $id)
    {
        return array(
            'id' => $id,
            'activites'    =>      $sous_projet_travaux['activites'],
            'unite' =>      $sous_projet_travaux['unite'],
            'quantite'    =>      $sous_projet_travaux['quantite'],
            'observation' =>      $sous_projet_travaux['observation'],
            'id_sous_projet_localisation' =>      $sous_projet_travaux['id_sous_projet_localisation'] 
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
                        ->order_by('activites')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsous_projet_travauxbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
                        ->order_by('activites')
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
