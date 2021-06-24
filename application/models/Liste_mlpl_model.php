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
            'menage_id'       =>  $liste_mlpl['menage_id'],
            'nom_prenom'      =>  $liste_mlpl['nom_prenom'],                       
            'adresse'         =>  $liste_mlpl['adresse'],                       
            'contact'         =>  $liste_mlpl['contact'],                       
            'fonction'        =>  $liste_mlpl['fonction'],                       
            'sexe'            =>  $liste_mlpl['sexe'],                       
            'age'             =>  $liste_mlpl['age'],                       
            'lien_de_parente' =>  $liste_mlpl['lien_de_parente'],                       
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
		$requete="select grpm.id_groupe_ml_pl,grpm.menage_id, grpm.id,m.NumeroEnregistrement,m.nomchefmenage,m.nom_conjoint,m.Addresse,"
		."m.nombre_enfant_non_scolarise,m.nombre_enfant_moins_six_ans,m.nombre_enfant_scolarise,m.identifiant_menage,"
		."grpm.nom_prenom,grpm.adresse,grpm.contact,grpm.fonction,grpm.sexe,grpm.age,grpm.lien_de_parente,"
		."lp.description  as lienparental"
		." from liste_ml_pl as grpm"
		." left outer join menage as m on m.id=grpm.menage_id"
		." left outer join liendeparente as lp on lp.id=grpm.lien_de_parente"
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