<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_collection_donnee_ebe_model extends CI_Model {
    protected $table = 'fiche_collection_donnee_ebe';

    public function add($fiche_collection_donnee_ebe)  {
        $this->db->set($this->_set($fiche_collection_donnee_ebe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_collection_donnee_ebe)  {
        $this->db->set($this->_set($fiche_collection_donnee_ebe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_collection_donnee_ebe) 
    {
        return array
        (
            'id_theme_sensibilisation'     => $fiche_collection_donnee_ebe['id_theme_sensibilisation'],
            'id_outils_utilise'     => $fiche_collection_donnee_ebe['id_outils_utilise'],
            'date'=> $fiche_collection_donnee_ebe['date'],
            'localite'        => $fiche_collection_donnee_ebe['localite'],
            'nbr_femme'  => $fiche_collection_donnee_ebe['nbr_femme'],
            'nbr_homme'  => $fiche_collection_donnee_ebe['nbr_homme'],
            'nbr_enfant'  => $fiche_collection_donnee_ebe['nbr_enfant'],
            'animateur'    => $fiche_collection_donnee_ebe['animateur'],
            'observation'    => $fiche_collection_donnee_ebe['observation'],
            'id_realisation_ebe'    => $fiche_collection_donnee_ebe['id_realisation_ebe']
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
    
    
    public function getfiche_collection_donnee_ebeByrealisation($id_realisation_ebe)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_realisation_ebe", $id_realisation_ebe)
                        ->order_by('date', 'asc')
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