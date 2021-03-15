<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_consultant_ong_model extends CI_Model {
    protected $table = 'contrat_consultant_ong';

    public function add($contrat)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($contrat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($contrat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat) {
		// Affectation des valeurs
        return array(
            'id_sous_projet' =>  $contrat['id_sous_projet'],
            'reference'  =>  $contrat['reference'],                       
            'date_contrat'    =>  $contrat['date_contrat'],                       
            'objet'    =>  $contrat['objet'],                       
         );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
 		$requete="select ct.id,ct.id_sous_projet, ct.reference,m.date_contrat,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		." from contrat_consultant_ong as ct"
		." left outer join sous_projet as sp on sp.id=ct.id_sous_projet"
		." order by ct.id";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
   }
    public function findById($id) {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>