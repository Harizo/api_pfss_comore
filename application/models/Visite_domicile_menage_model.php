<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visite_domicile_menage_model extends CI_Model {
    protected $table = 'visite_domicile_menage';
	// Ajout d'un enregistrement
    public function add($visite_domicile) {
        $this->db->set($this->_set($visite_domicile))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function addgroupe($visite_domicile) {
        $this->db->set($visite_domicile)
                            ->insert($this->table);
        if($this->db->affected_rows() >= 1) {
            return true;
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $visite_domicile) {
        $this->db->set($this->_set($visite_domicile))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($visite_domicile) {
        return array(
            'id_visite' => $visite_domicile['id_visite'],                      
            'id_menage'       => $visite_domicile['id_menage'],
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
	// Suppression des enregistrements par id_visite
    public function deleteByIdvisite($id_visite) {
        $this->db->where('id_visite', (int) $id_visite)->delete($this->table);
		// Valeur en retour = nombre d'enregistrement supprimé
		return $this->db->affected_rows();
    }
	// Récupération de tous les enregistrements de la table
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id_raison_visite_domicile')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
	// Récupération par id_visite : clé étrangère
    public function findAllByIdvisite($id_visite) {
		$requete="select v.id,v.id_visite,v.id_menage,"
				."m.identifiant_menage,m.nomchefmenage"
				." from ".$this->table." as v "
				." left join menage as m on m.id=v.id_menage"
				." where v.id_visite=".$id_visite
				." order by m.identifiant_menage";
		$query = $this->db->query($requete);
        $result= $query->result();								
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