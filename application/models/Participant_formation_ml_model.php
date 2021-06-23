<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_formation_ml_model extends CI_Model {
    protected $table = 'participant_formation_ml';

    public function add($tutelle)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tutelle)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tutelle) {
		// Affectation des valeurs
        return array(
            'nom' => $tutelle['nom'],
            'fonction' => $tutelle['fonction'],
            'id_formation_ml' => $tutelle['id_formation_ml'],
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
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
    public function findById_formation_ml($id_formation_ml) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_formation_ml",$id_formation_ml)
                        //->order_by('id_village')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
		// Selection par id
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
}
?>