<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Axe_strategique_model extends CI_Model {
    protected $table = 'axe_strategique';

    public function add($axestrategique)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($axestrategique))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $axestrategique)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($axestrategique))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($axestrategique) {
		// Affectation des valeurs
        return array(
            'objectif'  => $axestrategique['objectif'],
            'axe'  => $axestrategique['axe'],
            'code'         => $axestrategique['code'],
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('axe')
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