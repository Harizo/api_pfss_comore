<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_a_verifier_mlpl_model extends CI_Model {
    protected $table = 'point_a_verifier_mlpl';

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
            'id_fiche_supervision_mlpl'         => $fiche['id_fiche_supervision_mlpl'],
			'intitule_verifie'     => $fiche['intitule_verifie'],
			'appreciation'      => $fiche['appreciation'],
			'solution'      => $fiche['solution'],
			'observation'    => $fiche['observation']                      
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
    public function getpoint_a_verifierbyfichesupervision($id_fiche_supervision_mlpl) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_fiche_supervision_mlpl' ,$id_fiche_supervision_mlpl )
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