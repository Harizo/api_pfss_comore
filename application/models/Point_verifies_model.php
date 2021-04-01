<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_verifies_model extends CI_Model {
    protected $table = 'point_verifies';

    public function add($point)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($point))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $point)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($point))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($point) {
		// Affectation des valeurs
        return array(
            'id_fiche_supervision' =>  $point['id_fiche_supervision'],
            'theme_activite'  =>  $point['theme_activite'],                       
            'intitule_verifie'    =>  $point['intitule_verifie'],                       
            'prevision'    =>  $point['prevision'],                       
            'reelle'    =>  $point['reelle'],                       
            'observation'    =>  $point['observation'],                       
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