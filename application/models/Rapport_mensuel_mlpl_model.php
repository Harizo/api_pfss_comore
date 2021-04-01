<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport_mensuel_mlpl_model extends CI_Model {
    protected $table = 'rapport_mensuel_mlpl';

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
            'date_rapport'     =>  $rapport_mlpl['date_rapport'],
            'id_groupe_ml_pl'  =>  $rapport_mlpl['id_groupe_ml_pl'],
            'menage_id'         =>  $rapport_mlpl['menage_id'],                       
            'representant_cps' =>  $rapport_mlpl['representant_cps'],                       
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
		$requete="select rpm.id,rpm.id_groupe_ml_pl,grp.nom_groupe,rpm.date_rapport, rpm.menage_id,rpm.representant_cps,"
		." m.NumeroEnregistrement,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		." m.nombre_enfant_non_scolarise,m.nombre_enfant_moins_six_ans,m.nombre_enfant_scolarise "
		."  from rapport_mensuel_mlpl as rpm"
		."  left outer join groupe_ml_pl as grp on grp.id=rpm.id_groupe_ml_pl"
		."  left outer join menage as m on m.id=rpm.menage_id"
		."  where rpm.id_groupe_ml_pl =".$id_groupe_ml_pl
		."  order by m.NumeroEnregistrement";		
		
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