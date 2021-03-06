<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liste_menage_mlpl_model extends CI_Model {
    protected $table = 'liste_menage_ml_pl';

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
            'menage_id'       =>  $liste_mlpl['menage_id'],                       
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
    public function deleteByGroupemlpl($id_groupe_ml_pl) {
		// Suppression d'un enregitrement
        $this->db->where('id_groupe_ml_pl', (int) $id_groupe_ml_pl)->delete($this->table);
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
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findAllByGroupemlpl($id_groupe_ml_pl)  {   
		$requete="select grpm.id_groupe_ml_pl,grpm.menage_id, grpm.id,m.NumeroEnregistrement,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		."m.nombre_enfant_non_scolarise,m.nombre_enfant_moins_six_ans,m.nombre_enfant_scolarise,m.identifiant_menage "
		." from liste_menage_ml_pl as grpm"
		." left outer join menage as m on m.id=grpm.menage_id"
		." where grpm.id_groupe_ml_pl =".$id_groupe_ml_pl
		." order by m.NumeroEnregistrement";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
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