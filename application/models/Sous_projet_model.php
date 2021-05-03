<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_model extends CI_Model
{
    protected $table = 'sous_projet';

	// Ajout d'un enregistrement
    public function add($sous_projet) {
        $this->db->set($this->_set($sous_projet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function add_down($sous_projet, $id)  {
        $this->db->set($this->_set_down($sous_projet, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $sous_projet)  {
        $this->db->set($this->_set($sous_projet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($sous_projet)  {
        return array(
            'code'         => $sous_projet['code'],
            //'intitule' => $sous_projet['intitule'],
            'nature' => $sous_projet['nature'],
            'type' => $sous_projet['type'],
            'description' => $sous_projet['description'],
            'objectif' => $sous_projet['objectif'],
            'duree' => $sous_projet['duree'],
           /* 'description_activite' => $sous_projet['description_activite'],
            'presentantion_communaute' => $sous_projet['presentantion_communaute'],
            'ref_dgsc' => $sous_projet['ref_dgsc'],
            'nbr_menage_participant' => $sous_projet['nbr_menage_participant'],
            'nbr_menage_nonparticipant' => $sous_projet['nbr_menage_nonparticipant'],
            'population_total' => $sous_projet['population_total'],
            'id_commune' => $sous_projet['id_commune'],
            'id_village' => $sous_projet['id_village'],
            'id_communaute' => $sous_projet['id_communaute'],*/
            'id_par'  => $sous_projet['id_par'],
        );
    }
    public function _set_down($sous_projet, $id) {
        return array(
            'id' => $id,
            'code' => $sous_projet['code'],
            'intitule' => $sous_projet['intitule'],
            'nature' => $sous_projet['nature'],
            'type' => $sous_projet['type'],
            'description' => $sous_projet['description'],
            'objectif' => $sous_projet['objectif'],
            'duree' => $sous_projet['duree'],
            /*'description_activite' => $sous_projet['description_activite'],
            'presentantion_communaute' => $sous_projet['presentantion_communaute'],
            'ref_dgsc' => $sous_projet['ref_dgsc'],
            'nbr_menage_participant' => $sous_projet['nbr_menage_participant'],
            'nbr_menage_nonparticipant' => $sous_projet['nbr_menage_nonparticipant'],
            'population_total' => $sous_projet['population_total'],
            'id_commune' => $sous_projet['id_commune'],
            'id_village' => $sous_projet['id_village'],
            'id_communaute' => $sous_projet['id_communaute'],*/
            'id_par' => $sous_projet['id_par'],
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
    public function findAll()
    {
		$requete='select sp.id,sp.code,sp.description as description,sp.id_par,par.intitule as plan_action_reinstallation'
				.' from sous_projet as sp'
				.' left outer join plan_action_reinstallation as par on par.id=sp.id_par'
				.' order by sp.id	';				
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
    }
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
    public function findByIdpar($code)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("code", $code)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getsousprojetbypar($id_par) 
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_par", $id_par)
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