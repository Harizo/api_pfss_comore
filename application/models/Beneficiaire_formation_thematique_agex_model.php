<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beneficiaire_formation_thematique_agex_model extends CI_Model {
    protected $table = 'beneficiaire_formation_thematique_agex';

    public function add($tutelle)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tutelle)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tutelle) {
		// Affectation des valeurs
        return array(
            'id_groupe_ml_pl' => $tutelle['id_groupe_ml_pl'],
            'id_village' => $tutelle['id_village'],
            'id_formation_thematique_agex' => $tutelle['id_formation_thematique_agex'],
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
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById_formation_thematique_agexcommune($id_formation_thematique_agex,$id_commune) {
        $result =  $this->db->select('beneficiaire_formation_thematique_agex.*')
                        ->from($this->table)
                        ->join("see_village",'see_village.id=beneficiaire_formation_thematique_agex.id_village')
                        ->where("id_formation_thematique_agex",$id_formation_thematique_agex)
                        ->where("commune_id",$id_commune)
                        //->order_by('id')
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