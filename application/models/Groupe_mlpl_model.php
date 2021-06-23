<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupe_mlpl_model extends CI_Model {
    protected $table = 'groupe_ml_pl';

    public function add($groupe_mlpl)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($groupe_mlpl))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $groupe_mlpl)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($groupe_mlpl))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($groupe_mlpl) {
		// Affectation des valeurs
        return array(
            'date_creation'     =>  $groupe_mlpl['date_creation'],
            'chef_village'      =>  $groupe_mlpl['chef_village'],                       
            'id_menage'         =>  $groupe_mlpl['id_menage'],                       
            'nom_prenom_ml_pl'  =>  $groupe_mlpl['nom_prenom_ml_pl'],                       
            'nom_groupe'        =>  $groupe_mlpl['nom_groupe'],                       
            'village_id'        =>  $groupe_mlpl['village_id'],                       
            'sexe'              =>  $groupe_mlpl['sexe'],                       
            'age'               =>  $groupe_mlpl['age'],                       
            'lien_de_parente'   =>  $groupe_mlpl['lien_de_parente'],                       
            'telephone'         =>  $groupe_mlpl['telephone'],                       
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
    
    public function findById($id) {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findAllByVillage($village_id)  {     
		// Selection par village_id
		$requete ="select gp.id,gp.date_creation,gp.id_menage,gp.nom_prenom_ml_pl,gp.chef_village,gp.nom_groupe,gp.village_id,"
					."m.identifiant_menage,m.nomchefmenage,gp.sexe,gp.age,gp.lien_de_parente,gp.telephone,m.Addresse,"
					."lp.description as lienparental"
					." from groupe_ml_pl as gp"
					." left join menage as m on m.id=gp.id_menage"
					." left join liendeparente as lp on lp.id=gp.lien_de_parente"
					." where gp.village_id=".$village_id
					." order by id";
		$query = $this->db->query($requete);
        $result= $query->result();				
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function getgroupeByvillagewithnbr_membre($id_village) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('groupe_ml_pl.*,groupe_ml_pl.id as id_group,
                                        (select count(liste_menage_ml_pl.id) from liste_menage_ml_pl where liste_menage_ml_pl.id_groupe_ml_pl=id_group)as nbr_menage_membre')
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
    
    public function findByIdwithnbr_membre($id) {
		// Selection par id
        $this->db->select('groupe_ml_pl.*,groupe_ml_pl.id as id_group,(select count(liste_menage_ml_pl.id) from liste_menage_ml_pl where liste_menage_ml_pl.id_groupe_ml_pl=id_group)as nbr_menage_membre')
        ->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
    public function findByIdandmenage($id) {
		// Selection par id
        $this->db->select("groupe_ml_pl.id,
                            groupe_ml_pl.date_creation,
                            groupe_ml_pl.id_menage,
                            groupe_ml_pl.nom_prenom_ml_pl,
                            groupe_ml_pl.chef_village,
                            groupe_ml_pl.nom_groupe,
                            groupe_ml_pl.village_id,
                            menage.identifiant_menage,
                            menage.nomchefmenage,
                            groupe_ml_pl.sexe,
                            groupe_ml_pl.age,
                            groupe_ml_pl.lien_de_parente,
                            groupe_ml_pl.telephone,
                            menage.Addresse")
                ->join('menage','menage.id=groupe_ml_pl.id_menage','left')
        ->where("groupe_ml_pl.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
}
?>