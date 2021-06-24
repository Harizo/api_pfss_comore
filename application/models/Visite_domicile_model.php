<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visite_domicile_model extends CI_Model {
    protected $table = 'visite_domicile';

    public function add($visite_mlpl)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($visite_mlpl))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $visite_mlpl)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($visite_mlpl))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($visite_mlpl) {
		// Affectation des valeurs
        return array(
            'id_groupe_ml_pl' =>  $visite_mlpl['id_groupe_ml_pl'],
            'numero'          =>  $visite_mlpl['numero'],                       
            'date_visite1'    =>  $visite_mlpl['date_visite1'],                       
            'objet_visite'    =>  $visite_mlpl['objet_visite'],                       
            'nom_prenom_mlpl' =>  $visite_mlpl['nom_prenom_mlpl'],                       
            'date_visite2'    =>  $visite_mlpl['date_visite2'],                       
            'resultat_visite' =>  $visite_mlpl['resultat_visite'],                       
            'recommandation'  =>  $visite_mlpl['recommandation'],                       
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
    public function findAllByGroupemlpl($id_groupe_ml_pl)  {     
		// Selection par id_groupe_ml_pl
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_groupe_ml_pl", $id_groupe_ml_pl)
                        ->order_by('id', 'asc')
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