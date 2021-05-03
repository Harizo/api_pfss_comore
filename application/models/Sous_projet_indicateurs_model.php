<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_indicateurs_model extends CI_Model
{
    protected $table = 'sous_projet_indicateurs';


    public function add($sous_projet_indicateurs)
    {
        $this->db->set($this->_set($sous_projet_indicateurs))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_indicateurs)
    {
        $this->db->set($this->_set($sous_projet_indicateurs))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_indicateurs)
    {
        return array(
            'personne'    =>      $sous_projet_indicateurs['personne'],
            'nombre' =>      $sous_projet_indicateurs['nombre'],
            'id_sous_projet_localisation' =>      $sous_projet_indicateurs['id_sous_projet_localisation']                      
        );
    }

    public function add_down($sous_projet_indicateurs, $id)  {
        $this->db->set($this->_set_down($sous_projet_indicateurs, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_indicateurs, $id)
    {
        return array(
            'id' => $id,
            'personne' => $sous_projet_indicateurs['personne'],
            'nombre' => $sous_projet_indicateurs['nombre'],
            'id_sous_projet_localisation' =>      $sous_projet_indicateurs['id_sous_projet_localisation'] 
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
                        ->order_by('personne')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsous_projet_indicateursbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
                        ->order_by('personne')
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
