<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme_formation_detail_model extends CI_Model {
    protected $table = 'theme_formation_detail';

    public function add($theme_formation_detail) {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($theme_formation_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $theme_formation_detail) {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($theme_formation_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($theme_formation_detail) {
		// Affectation des valeurs
        return array(
            'id'                 => $theme_formation_detail['id'],
            'id_theme_formation' => $theme_formation_detail['id_theme_formation'],
            'description'        => $theme_formation_detail['description'],
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
    public function deleteByParentId($id) {
		// Suppression par id_theme_formation
        $this->db->where('id_theme_formation', (int) $id)->delete($this->table);
        if($this->db->affected_rows() >= 1) {
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
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByIdParent($id_theme_formation) {
		// Selection par id_theme_formation
        $result =  $this->db->select('*')
                        ->from($this->table)
						->where("id_theme_formation", $id_theme_formation)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
		// Selection par id
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