<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ddb_mlpl_model extends CI_Model {

    public function add($ddbmlpl,$nom_table)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($ddbmlpl))
                            ->insert($nom_table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $ddbmlpl,$nom_table)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($ddbmlpl))
                            ->where('id', (int) $id)
                            ->update($nom_table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($ddbmlpl) {
		// Affectation des valeurs
        return array(
            'description' => $ddbmlpl['description'],
        );
    }
    public function delete($id,$nom_table) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($nom_table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll($nom_table) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($nom_table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id,$nom_table) {
		// Selection par id
        $result =  $this->db->select('*')
                        ->from($nom_table)
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