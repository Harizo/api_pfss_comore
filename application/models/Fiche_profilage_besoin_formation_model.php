<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_profilage_besoin_formation_model extends CI_Model {
    protected $table = 'fiche_profilage_besoin_formation';

    public function add($fiche_profilage_besoin_formation)  {
        $this->db->set($this->_set($fiche_profilage_besoin_formation))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_profilage_besoin_formation)  {
        $this->db->set($this->_set($fiche_profilage_besoin_formation))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_profilage_besoin_formation) 
    {
        return array
        (
            'id_type_formation'       => $fiche_profilage_besoin_formation['id_type_formation'],
            'objectif'     => $fiche_profilage_besoin_formation['objectif'],
            'profile'  => $fiche_profilage_besoin_formation['profile'],
            'duree'  => $fiche_profilage_besoin_formation['duree'],
            'id_fiche_profilage_orientation'     => $fiche_profilage_besoin_formation['id_fiche_profilage_orientation']
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
    
    
    public function getfiche_profilage_besoin_formationByentete($id_fiche_profilage_orientation)  {
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