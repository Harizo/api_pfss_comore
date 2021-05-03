<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_materiels_model extends CI_Model
{
    protected $table = 'sous_projet_materiels';


    public function add($sous_projet_materiels)
    {
        $this->db->set($this->_set($sous_projet_materiels))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_materiels)
    {
        $this->db->set($this->_set($sous_projet_materiels))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_materiels)
    {
        return array(
            'designation'    =>      $sous_projet_materiels['designation'],
            'unite' =>      $sous_projet_materiels['unite'],
            'quantite'    =>      $sous_projet_materiels['quantite'],
            'prix_unitaire' =>      $sous_projet_materiels['prix_unitaire'],
            'prix_total' =>      $sous_projet_materiels['prix_total'],
            'id_sous_projet_localisation' =>      $sous_projet_materiels['id_sous_projet_localisation']                      
        );
    }

    public function add_down($sous_projet_materiels, $id)  {
        $this->db->set($this->_set_down($sous_projet_materiels, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_materiels, $id)
    {
        return array(
            'id' => $id,
            'designation'    =>      $sous_projet_materiels['designation'],
            'unite' =>      $sous_projet_materiels['unite'],
            'quantite'    =>      $sous_projet_materiels['quantite'],
            'prix_unitaire' =>      $sous_projet_materiels['prix_unitaire'],
            'prix_total' =>      $sous_projet_materiels['prix_total'],
            'id_sous_projet_localisation' =>      $sous_projet_materiels['id_sous_projet_localisation'] 
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
                        ->order_by('designation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsous_projet_materielsbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
                        ->order_by('designation')
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
