<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fichepresence_bienetre_model extends CI_Model {
    protected $table = 'fichepresence_bienetre';

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
            'id_groupe_ml_pl'      => $fiche_presence['id_groupe_ml_pl'],
            'date_presence'        => $fiche_presence['date_presence'],                       
            'numero_ligne'         => $fiche_presence['numero_ligne'],                       
            'id_espace_bienetre' => $fiche_presence['id_espace_bienetre'],                      
            'nombre_menage_present' => $fiche_presence['nombre_menage_present'],                      
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
    public function getfichepresencebygroupe($id_groupe_ml_pl) {
		// Selection de tous les enregitrements
		$requete="select fichepresence_bienetre.*,esp.description as espace_bien_etre"
				." from fichepresence_bienetre"
				." left join espace_bien_etre as esp on esp.id="."fichepresence_bienetre.id_espace_bienetre"
				." where  fichepresence_bienetre.id_groupe_ml_pl=".$id_groupe_ml_pl;
		$result = $this->db->query($requete)->result();		
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllByGroupemlpl($id_groupe_ml_pl)  {     
		// Selection par id_groupe_ml_pl
        $this->db->where("id_groupe_ml_pl", $id_groupe_ml_pl);
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
	public function NumeroligneParGroupemlpl($id_groupe_ml_pl) {
		$requete="select (ifnull(count(*),0) + 1) as nombre from fichepresence_bienetre where id_groupe_ml_pl=".$id_groupe_ml_pl;
		$query = $this->db->query($requete);
		return $query->result();						
	}
}
?>