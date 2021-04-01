<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupe_mlpl_model extends CI_Model {
    protected $table = 'groupe_ml_pl';

    public function add($groupe_mlpl)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($groupe_mlpl))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $groupe_mlpl)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($groupe_mlpl))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($groupe_mlpl) {
		// Affectation des valeurs
        return array(
            'date_creation' =>  $groupe_mlpl['date_creation'],
            'chef_village'  =>  $groupe_mlpl['chef_village'],                       
            'nom_groupe'    =>  $groupe_mlpl['nom_groupe'],                       
            'village_id'    =>  $groupe_mlpl['village_id'],                       
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
    public function findAllByVillage($village_id)  {     
		// Selection par village_id
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('village_id', $village_id)
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