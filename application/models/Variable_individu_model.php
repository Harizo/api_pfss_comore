<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variable_individu_model extends CI_Model {
    protected $table = 'variable_individu';
	// Ajout d'un enregistrement
    public function add($variable_individu) {
        $this->db->set($this->_set($variable_individu))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $variable_individu) {
        $this->db->set($this->_set($variable_individu))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($variable_individu) {
        return array(
            'code'              => $variable_individu['code'],
            'description'       => $variable_individu['description'],
            'id_liste_variable_individu' => $variable_individu['id_liste_variable_individu']                       
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
	// Récupération de tous les enregistrements de la table
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
	// Récupération pa id_liste_variable_individu : clé étrangère
    public function findAllByIdlistevariable($id_liste_variable_individu) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code')
                        ->where("id_liste_variable_individu", $id_liste_variable_individu)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
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
            return null;
        }                 
    }		
}
?>