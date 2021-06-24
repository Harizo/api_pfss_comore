<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Probleme_solution_propose_model extends CI_Model {
    protected $table = 'probleme_solution_propose';

    public function add($probleme)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($probleme))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $probleme)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($probleme))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($probleme) {
		// Affectation des valeurs
        return array(
            'id_fiche_supervision' =>  $probleme['id_fiche_supervision'],
            'probleme_constate'    =>  $probleme['probleme_constate'],                       
            'solution_proposee'    =>  $probleme['solution_proposee'],                       
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
            return array();
        }                 
    }
    public function findByFicheSupervision($id_fiche_supervision) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_fiche_supervision' ,$id_fiche_supervision )
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findById($id) {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return array();
    }
}
?>