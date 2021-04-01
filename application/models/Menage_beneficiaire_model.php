<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menage_beneficiaire_model extends CI_Model {
    protected $table = 'menage_beneficiaire';

    public function add($menage_benef)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($menage_benef))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $menage_benef)   {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($menage_benef))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($menage_benef)  {
		// Affectation des valeurs
        return array(
            'id_menage'        => $menage_benef['id_menage'],
            'id_sous_projet'  => $menage_benef['id_sous_projet'],                      
            'date_sortie'      => $menage_benef['date_sortie'],                      
            'date_inscription' => $menage_benef['date_inscription'],                      
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
    public function deleteByMenageSousprojet($id_menage,$id_sous_projet)  {
		// Suppression d'un enregitrement
        $this->db->where('id_menage', (int) $id_menage)
		->where('id_sous_projet', (int) $id_sous_projet)
		->delete($this->table);
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
            return null;
        }                 
    }
    public function findAllByProgramme($id_sous_projet)   {
		// Selection par intervention
        $result =  $this->db->select('menage.id as id_menage,
                                        menage_benef.id as id,
                                        menage.NomInscrire as NomInscrire,
                                        menage.PersonneInscription as PersonneInscription,
                                        menage.AgeInscrire as AgeInscrire,
                                        menage.Addresse as Addresse,
                                        menage.NumeroEnregistrement as NumeroEnregistrement
                                        ')
                        ->from($this->table)
                        ->join('menage', 'menage.id = menage_benef.id_menage')
                        ->like('id_sous_projet', $id_sous_projet)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                  
    }
    public function getmenageBysous_projet($id_sous_projet)   {
		// Selection par intervention
        $result =  $this->db->select('menage.id as id,
                                        menage.NumeroEnregistrement as NumeroEnregistrement,
                                        menage.NomTravailleurSuppliant as NomTravailleurSuppliant,
                                        menage.AgeInscrire as AgeInscrire,
                                        menage.SexeTravailleurSuppliant as SexeTravailleurSuppliant
                                        ')
                        ->from($this->table)
                        ->join('menage', 'menage.id = menage_beneficiaire.id_menage')
                        ->like('menage_beneficiaire.id_sous_projet', $id_sous_projet)
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllByMenage($id_menage) {
        // Selection par id_menage
        $this->db->where("id_menage", $id_menage);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;  
    }
    public function findAllByMenageSousprojet($id_menage,$id_sous_projet) {
        // Selection par id_sous_projet
        $this->db->where("id_menage", $id_menage)->where("id_sous_projet", $id_sous_projet);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;  
    }
    public function findById($id)  {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findAllByProgrammeAndVillage($id_sous_projet,$village_id)  {
		// Selection par intervention et par fokontany
		$requete="select mp.id,mp.id_menage,m.nom,m.prenom,m.date_naissance,m.cin,m.profession,m.date_inscription,mp.id_sous_projet"
				." from menage_beneficiaire as mp"
				." left outer join menage as m on m.id=mp.id_menage"
				." left outer join see_village as v on v.id=m.village_id"
                ." where mp.id_sous_projet like ".$id_sous_projet
				." and v.id=".$village_id;	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllBySousprojetAndVillage($id_sous_projet,$village_id)  {
		// Selection par intervention et par fokontany
		$requete="select m.inapte,m.NumeroEnregistrement as numeroenregistrement,m.nomchefmenage,mp.id,mp.id_menage,mp.id_sous_projet,"
				."m.NomTravailleur as nomtravailleur,m.SexeTravailleur as sexetravailleur,m.NomTravailleurSuppliant as nomtravailleursuppleant,"
				."m.SexeTravailleurSuppliant as sexetravailleursuppliant"
				." from menage_beneficiaire as mp"
				." left outer join menage as m on m.id=mp.id_menage"
				." left outer join see_village as v on v.id=m.village_id"
                ." where mp.id_sous_projet=".$id_sous_projet
				." and v.id=".$village_id." and m.statut='BENEFICIAIRE'";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
}
?>