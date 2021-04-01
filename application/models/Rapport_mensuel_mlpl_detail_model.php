<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport_mensuel_mlpl_detail_model extends CI_Model {
    protected $table = 'rapport_mensuel_mlpl_detail';

    public function add($rapport_mlpl)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($rapport_mlpl))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rapport_mlpl)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($rapport_mlpl))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rapport_mlpl) {
		// Affectation des valeurs
        return array(
            'id_rapport'    =>  $rapport_mlpl['id_rapport'],
            'id_ddb_visite' =>  $rapport_mlpl['id_ddb_visite'],
            'date_theme'    =>  $rapport_mlpl['date_theme'],                       
            'menage_visite' =>  $rapport_mlpl['menage_visite'],                       
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
		$requete="select v.id_groupe_ml_pl,v.menage_id, v.id,m.NumeroEnregistrement,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		."m.nombre_enfant_non_scolarise,m.nombre_enfant_moins_six_ans,m.nombre_enfant_scolarise, "
		."v.numero,v.date_visite1,v.objet_visite,v.nom_prenom_mlpl,v.date_visite2,v.resultat_visite,v.recommandation"
		." from visite_domicile as v"
		." left outer join menage as m on m.id=v.menage_id"
		." where v.id_groupe_ml_pl =".$id_groupe_ml_pl
		." order by m.NumeroEnregistrement";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
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