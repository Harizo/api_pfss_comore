<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reponse_menage_model extends CI_Model {
    protected $table = 'reponse_menage';
	// Ajout d'un enregistrement
    public function add($reponse_menage) {
        $this->db->set($this->_set($reponse_menage))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $reponse_menage) {
        $this->db->set($this->_set($reponse_menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($reponse_menage) {
        return array(
            'id_liste_variable'                => $reponse_menage['id_liste_variable'],                      
            'id_variable'                      => $reponse_menage['id_variable'],
            'id_menage'                  => $reponse_menage['id_menage'],
        );
    }
	// Suppression d'un enregistrement
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
	// Suppression des enregistrements par id_menage
    public function deleteByMenage($id_menage) {
        $this->db->where('id_menage', (int) $id_menage)->delete($this->table);
		// Valeur en retour = nombre d'enregistrement supprimé
		return $this->db->affected_rows();
    }
	// Récupération de tous les enregistrements de la table
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id_variable')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
	// Récupération par id_menage : clé étrangère
    public function findAllByIdMenage($id_menage) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_menage", $id_menage)
                        ->order_by('id_menage')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }
    }
	// Récupération par id (clé primaire)
    public function findById($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }		
}
?>