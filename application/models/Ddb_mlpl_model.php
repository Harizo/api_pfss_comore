<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ddb_mlpl_model extends CI_Model {

    public function add($ddbmlpl,$nom_table)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($ddbmlpl))
                            ->insert($nom_table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function add_table($nom_table,$id_rapport,$nom_cle_etrangere,$valeur_cle_etrangere,$menage_sensibilise)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set_table($id_rapport,$nom_cle_etrangere,$valeur_cle_etrangere,$menage_sensibilise))
                            ->insert($nom_table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $ddbmlpl,$nom_table)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($ddbmlpl))
                            ->where('id', (int) $id)
                            ->update($nom_table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function update_table($nom_table,$id_table_fille,$id_rapport,$nom_cle_etrangere,$valeur_cle_etrangere,$menage_sensibilise)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set_update_table($menage_sensibilise))
                            // ->where('id', (int) $id_table_fille)
                            ->where('id_rapport', (int) $id_rapport)
                            ->where($nom_cle_etrangere, (int) $valeur_cle_etrangere)
                            ->update($nom_table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($ddbmlpl) {
		// Affectation des valeurs
        return array(
            'description' => $ddbmlpl['description'],
        );
    }
    public function _set_table($id_rapport,$nom_cle_etrangere,$valeur_cle_etrangere,$menage_sensibilise) {
		// Affectation des valeurs
        return array(
            'id_rapport' => $id_rapport,
            $nom_cle_etrangere => $valeur_cle_etrangere,
            'menage_sensibilise' => $menage_sensibilise,
        );
    }
    public function _set_update_table($menage_sensibilise) {
		// Affectation des valeurs
        return array(
            'menage_sensibilise' => $menage_sensibilise,
        );
    }
    public function delete($id,$nom_table) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($nom_table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function delete_table_rapport_choix_multiple($nom_table,$id_rapport) {
		// Suppression d'un enregitrement
        $this->db->where('id_rapport', (int) $id_rapport)->delete($nom_table);
        if($this->db->affected_rows() >= 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll($nom_table) {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($nom_table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findById($id,$nom_table) {
		// Selection par id
        $result =  $this->db->select('*')
                        ->from($nom_table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findByIdrapportNomcleEtrangere($nom_table,$nom_table_rapport,$id_rapport,$nom_cle_etrangere) {
		// Selection par id_rapport et selon nom_table,nom_table_rapport,nom_cle_etrangere en parametre
		//Exemple nom_table=raison_visite_domicile (table mère)
		// nom_table_rapport = rapport_raison_visite_domicile(table fille)
		// nom_cle_etrangere = id_raison_visite_domicile (clé étrangère) EGAL A LA clé primaire de la table mère (id)
		// nom_table possible = raison_visite_domicile;resolution_viste_domicile;theme_sensibilisation
		// probleme_rencontres;projet_groupe;resolution_ml_pl (au totaal 6 tables)
		$requete="select un.id,un.".$nom_cle_etrangere.",un.id_table_fille,un.description,un.id_rapport,"
		."sum(un.menage_sensibilise) as menage_sensibilise "
		." from " 
		."(select tm.id,tf.".$nom_cle_etrangere.",tf.id as id_table_fille,tm.description,tf.id_rapport,"
		."tf.menage_sensibilise from ".$nom_table." as tm "
		." join ".$nom_table_rapport." as tf on tm.id=tf.".$nom_cle_etrangere
		." union " 
		."select tmm.id,null as ".$nom_cle_etrangere.",null as id_table_fille,tmm.description,".$id_rapport." as id_rapport,null as menage_sensibilise"
		." from ".$nom_table." as tmm) as un"
		." where un.id_rapport=".$id_rapport
		." group by un.id,un.description,un.id_rapport";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return array();
        }  
    }
    public function findByIdrapportReponseChoixMultiple($nom_table_rapport,$id_rapport,$nom_cle_etrangere) {
		// Selection par id_rapport et selon nom_table,nom_table_rapport,nom_cle_etrangere en parametre
		//Exemple nom_table=raison_visite_domicile (table mère)
		// nom_table_rapport = rapport_raison_visite_domicile(table fille)
		// nom_cle_etrangere = id_raison_visite_domicile (clé étrangère) EGAL A LA clé primaire de la table mère (id)
		// nom_table possible = raison_visite_domicile;resolution_viste_domicile;theme_sensibilisation
		// probleme_rencontres;projet_groupe;resolution_ml_pl (au totaal 6 tables)
		$requete="select ".$nom_cle_etrangere." as id from ".$nom_table_rapport." where id_rapport=".$id_rapport;
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return array();
        }  
    }
}
?>