<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_profilage_ressource_model extends CI_Model {
    protected $table = 'fiche_profilage_ressource';

    public function add($fiche_profilage_ressource)  {
        $this->db->set($this->_set($fiche_profilage_ressource))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_profilage_ressource)  {
        $this->db->set($this->_set($fiche_profilage_ressource))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_profilage_ressource) 
    {
        return array
        (
            'designation'       => $fiche_profilage_ressource['designation'],
            'quantite'     => $fiche_profilage_ressource['quantite'],
            'etat'  => $fiche_profilage_ressource['etat'],
            'id_fiche_profilage_orientation'     => $fiche_profilage_ressource['id_fiche_profilage_orientation']
        );
    }


    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }    
    
    
    public function getfiche_profilage_ressourceByentete($id_fiche_profilage_orientation)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fiche_profilage_orientation", $id_fiche_profilage_orientation)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
}
?>