<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liste_mlpl_model extends CI_Model {
    protected $table = 'liste_ml_pl';

    public function add($liste_mlpl)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($liste_mlpl))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $liste_mlpl)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($liste_mlpl))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($liste_mlpl) {
		// Affectation des valeurs
        return array(
            'id_groupe_ml_pl' =>  $liste_mlpl['id_groupe_ml_pl'],
            'nom_prenom'      =>  $liste_mlpl['nom_prenom'],                       
            'adresse'         =>  $liste_mlpl['adresse'],                       
            'contact'         =>  $liste_mlpl['contact'],                       
            'fonction'        =>  $liste_mlpl['fonction'],                       
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
    public function findAllByGroupemlpl($id_groupe_ml_pl)  {     
		// Selection par id_groupe_ml_pl
        $result =  $this->db->select('*')
                        ->from($this->table)
						->where("id_groupe_ml_pl", $id_groupe_ml_pl)
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