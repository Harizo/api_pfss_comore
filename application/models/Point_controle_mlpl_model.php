<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_controle_mlpl_model extends CI_Model {
    protected $table = 'point_controle_mlpl';

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
            'id_livrable_mlpl' => $fiche['id_livrable_mlpl'],
			'intitule'     => $fiche['intitule'],
			'resultat'      => $fiche['resultat']                     
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
    public function getpoint_controlebylivrable($id_livrable_mlpl) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_livrable_mlpl' ,$id_livrable_mlpl )
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