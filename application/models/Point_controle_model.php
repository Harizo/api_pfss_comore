<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_controle_mode extends CI_Model {
    protected $table = 'point_controle';

    public function add($pointc)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($pointc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pointc)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($pointc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pointc) {
		// Affectation des valeurs
        return array(
            'id_livrable'=>  $pointc['id_livrable'],
            'intitule'   =>  $pointc['intitule'],                       
            'resultat'   =>  $pointc['resultat'],                       
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