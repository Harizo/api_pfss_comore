<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_model extends CI_Model {
    protected $table = 'fiche_supervision';

    public function add($fiche)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($fiche))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fiche)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($fiche))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche) {
		// Affectation des valeurs
        return array(
            'id_contrat' =>  $fiche['id_contrat'],
            'date_supervision'  =>  $fiche['date_supervision'],                       
            'type_supervision'    =>  $fiche['type_supervision'],                       
            'milieu'    =>  $fiche['milieu'],                       
            'personne_rencontree'    =>  $fiche['personne_rencontree'],                       
            'planning_activite'    =>  $fiche['planning_activite'],                       
            'date_prevue_debut'    =>  $fiche['date_prevue_debut'],                       
            'date_fin'    =>  $fiche['date_fin'],                       
            'nom_missionnaire'    =>  $fiche['nom_missionnaire'],                       
            'nom_consultant'    =>  $fiche['nom_consultant'],                       
            'representant_cps'    =>  $fiche['representant_cps'],                       
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
    public function findByContrat($id_contrat) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat' ,$id_contrat )
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