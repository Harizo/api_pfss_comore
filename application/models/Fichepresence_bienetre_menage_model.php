<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fichepresence_bienetre_menage_model extends CI_Model {
    protected $table = 'fichepresence_bienetre_menage';

    public function add($fiche_presence)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($fiche_presence))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fiche_presence)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($fiche_presence))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_presence) {
		// Affectation des valeurs
        return array(
            'id_menage'      => $fiche_presence['id_menage'],
            'id_fiche_presence_bienetre' => $fiche_presence['id_fiche_presence_bienetre'],                      
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
    public function deleteByFichepresence($id_fiche_presence_bienetre) {
		// Suppression d'un enregitrement
        $this->db->where('id_fiche_presence_bienetre', (int) $id_fiche_presence_bienetre)->delete($this->table);
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
    public function findByfichepresence($id_fiche_presence_bienetre) {
		$requete="select fpm.id_fiche_presence_bienetre,fpm.id_menage, fpm.id,m.NumeroEnregistrement,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		."m.nombre_enfant_non_scolarise,m.nombre_enfant_moins_six_ans,m.nombre_enfant_scolarise,m.identifiant_menage "
		." from fichepresence_bienetre_menage as fpm"
		." left outer join menage as m on m.id=fpm.id_menage"
		." where fpm.id_fiche_presence_bienetre =".$id_fiche_presence_bienetre
		." order by m.identifiant_menage";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
    }
    public function findAllByGroupemlpl($id_fiche_presence_bienetre)  {     
		// Selection par id_fiche_presence_bienetre
        $this->db->where("id_fiche_presence_bienetre", $id_fiche_presence_bienetre);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;  
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