<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_mlpl_model extends CI_Model {
    protected $table = 'fiche_supervision_mlpl';

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
            'id_groupemlpl'         => $fiche['id_groupemlpl'],
			'id_consultant_ong'     => $fiche['id_consultant_ong'],
			'date_supervision'      => $fiche['date_supervision'],
			'type_supervision'      => $fiche['type_supervision'],
			'personne_rencontree'    => $fiche['personne_rencontree'],
			'organisation_consultant'      => $fiche['organisation_consultant'],
			'planning_activite_consultant' => $fiche['planning_activite_consultant'],
			'date_prevue_debut'     => $fiche['date_prevue_debut'],
			'date_prevue_fin'       => $fiche['date_prevue_fin'],
			'nom_missionnaire'      => $fiche['nom_missionnaire'],
			'nom_representant_mlpl' => $fiche['nom_representant_mlpl']                      
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
    public function getfiche_previsionbygroupe($id_groupemlpl) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_groupemlpl' ,$id_groupemlpl )
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