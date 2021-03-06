<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Individu_beneficiaire_model extends CI_Model {
    protected $table = 'individu_beneficiaire';
    public function add($individu_beneficiaire)    {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($individu_beneficiaire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $individu_beneficiaire)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($individu_beneficiaire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($individu_beneficiaire)  {
		// Affectation des valeurs
        return array(
            'id_individu'       =>  $individu_beneficiaire['id_individu'],
            'id_intervention'   =>  $individu_beneficiaire['id_intervention'],                      
            'date_sortie'       =>  $individu_beneficiaire['date_sortie'],                      
            'date_inscription'  =>  $individu_beneficiaire['date_inscription'],                      
        );
    }
    public function delete($id)  {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll()  {
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
    public function findAllByProgramme($id_interventions)  {
		// Selection par iintervention
        $result =  $this->db->select('individu.id as id_individu,
                                        individu_beneficiaire.id as id,
                                        individu.Nom as Nom,
                                        individu.DateNaissance as DateNaissance,
                                        individu.Activite as Activite,
                                        individu.aptitude as aptitude,
                                        individu.travailleur as travailleur
                                        ')
                        ->from($this->table)
                        ->join('individu', 'individu.id = individu_beneficiaire.id_individu')
                        ->like('id_intervention', $id_interventions)
                        ->get()
                        ->result();
        if($result)  {
            return $result;
        }else{
            return array();
        }                  
    }
    public function findAllByindividu($id_individu)   {
        // Selection par id_individu
        $this->db->where("id_individu", $id_individu);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return array();  
    }
    public function findById($id)    {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return array();
    }
    public function findAllByProgrammeAndVillage($id_interventions,$id_fokontany)    {
		// Selection individu bénéficiaire par intervention et par 
		$requete="select mp.id,mp.id_individu,i.nom,i.prenom,i.date_naissance,i.id_menage,m.adresse"
				." from individu_beneficiaire as mp"
				." left outer join individu as i on i.id=mp.id_individu"
				." left outer join menage as m on m.id=i.id_menage"
				." left outer join fokontany as v on v.id=m.id_fokontany"
                ." where mp.id_intervention like ".$id_interventions
				." and v.id=".$id_fokontany;	
				$result = $this->db->query($requete)->result();
        if($result)  {
            return $result;
        }else{
            return array();
        }                  
    }
}
?>