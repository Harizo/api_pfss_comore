<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_localisation_model extends CI_Model
{
    protected $table = 'sous_projet_localisation';

	// Ajout d'un enregistrement
    public function add($sous_projet_localisation) {
        $this->db->set($this->_set($sous_projet_localisation))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function add_down($sous_projet_localisation, $id)  {
        $this->db->set($this->_set_down($sous_projet_localisation, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $sous_projet_localisation)  {
        $this->db->set($this->_set($sous_projet_localisation))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($sous_projet_localisation)  {
        return array(
            'presentantion_communaute' => $sous_projet_localisation['presentantion_communaute'],
            'ref_dgsc' => $sous_projet_localisation['ref_dgsc'],
            'nbr_menage_beneficiaire' => $sous_projet_localisation['nbr_menage_beneficiaire'],
            'nbr_menage_participant' => $sous_projet_localisation['nbr_menage_participant'],
            'nbr_menage_nonparticipant' => $sous_projet_localisation['nbr_menage_nonparticipant'],
            'population_total' => $sous_projet_localisation['population_total'],
            'id_ile' => $sous_projet_localisation['id_ile'],
            'id_region' => $sous_projet_localisation['id_region'],
            'id_commune' => $sous_projet_localisation['id_commune'],
            'id_village' => $sous_projet_localisation['id_village'],
            //'id_communaute' => $sous_projet_localisation['id_communaute'],
            'id_sous_projet'  => $sous_projet_localisation['id_sous_projet'],
        );
    }
    public function _set_down($sous_projet_localisation, $id) {
        return array(
            'id' => $id,
            'presentantion_communaute' => $sous_projet_localisation['presentantion_communaute'],
            'ref_dgsc' => $sous_projet_localisation['ref_dgsc'],
            'nbr_menage_beneficiaire' => $sous_projet_localisation['nbr_menage_beneficiaire'],
            'nbr_menage_participant' => $sous_projet_localisation['nbr_menage_participant'],
            'nbr_menage_nonparticipant' => $sous_projet_localisation['nbr_menage_nonparticipant'],
            'population_total' => $sous_projet_localisation['population_total'],
            'id_ile' => $sous_projet_localisation['id_ile'],
            'id_region' => $sous_projet_localisation['id_region'],
            'id_commune' => $sous_projet_localisation['id_commune'],
            'id_village' => $sous_projet_localisation['id_village'],
            //'id_communaute' => $sous_projet_localisation['id_communaute'],
            'id_sous_projet'  => $sous_projet_localisation['id_sous_projet'],
        );
    }
	// Suppression d'un enregistrement
    public function delete($id)  {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    
	// Récupération de tous les enregistrements de la table
    public function findAll()  {
        $result =  $this->db->select('*')
                        ->from($this->table)
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
    /*public function findAll()
    {
		$requete='select sp.id,sp.code,sp.description as description,sp.id_sous_projet,par.intitule as plan_action_reinstallation'
				.' from sous_projet_localisation as sp'
				.' left outer join plan_action_reinstallation as par on par.id=sp.id_sous_projet'
				.' order by sp.id	';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
    }*/
	// Récupération par id (clé primaire)
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
	// Récupération par id (clé primaire) : réponse : tableau
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
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
 
    public function getlocalisationbysousprojet($id_sous_projet) 
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_sous_projet", $id_sous_projet)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
}
?>