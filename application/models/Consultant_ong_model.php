<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consultant_ong_model extends CI_Model {
    protected $table = 'consultant_ong';

    public function add($cons_ong)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($cons_ong))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
     public function add_down($agent_ex, $id)  {
        $this->db->set($this->_set_down($agent_ex, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
   public function update($id, $cons_ong)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($cons_ong))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($cons_ong) {
		// Affectation des valeurs
        return array(
            'code' =>  $cons_ong['code'],
            'nom_consultant'  =>  $cons_ong['nom_consultant'],
            'raison_social'  =>  $cons_ong['raison_social'],                       
            'contact'    =>  $cons_ong['contact'],                       
            'fonction_contact'    =>  $cons_ong['fonction_contact'],                       
            'telephone_contact'    =>  $cons_ong['telephone_contact'],                       
            'adresse'    =>  $cons_ong['adresse'],                       
            'ile_id'    =>  $cons_ong['ile_id'] ,                       
            'id_region'    =>  $cons_ong['id_region'],                       
            'id_commune'    =>  $cons_ong['id_commune'] ,                       
            'id_village'    =>  $cons_ong['id_village']                        
        );
    }
    public function _set_down($cons_ong) {
		// Affectation des valeurs
        return array(
            'code' =>  $cons_ong['code'],
            'nom_consultant'  =>  $cons_ong['nom_consultant'],
            'raison_social'  =>  $cons_ong['raison_social'],                       
            'contact'    =>  $cons_ong['contact'],                       
            'fonction_contact'    =>  $cons_ong['fonction_contact'],                       
            'telephone_contact'    =>  $cons_ong['telephone_contact'],                       
            'adresse'    =>  $cons_ong['adresse'],                       
            'ile_id'    =>  $cons_ong['ile_id'],                       
            'id_region'    =>  $cons_ong['id_region'],                       
            'id_commune'    =>  $cons_ong['id_commune'] ,                       
            'id_village'    =>  $cons_ong['id_village']                       
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
    
    public function getconsultantbyile($cle_etrangere) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("ile_id", $cle_etrangere)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
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