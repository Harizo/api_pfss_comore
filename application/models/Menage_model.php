<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menage_model extends CI_Model
{
    protected $table = 'menage';


    public function add($menage)
    {
        $this->db->set($this->_set($menage))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $menage)
    {
        $this->db->set($this->_set($menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function update_reponse($id, $menage)
    {
        $this->db->set($this->_set_reponse($menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function update_statut($id, $menage)
    {
        $this->db->set($this->_set_statut($menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function update_photo($id, $menage)
    {
        $this->db->set($this->_set_photo($menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($menage)
    {
        return array(
            'id_serveur_centrale'   =>      $menage['id_serveur_centrale'],
            'DateInscription'       =>      $menage['DateInscription'],
            'village_id'            =>      $menage['village_id'],                       
            'NumeroEnregistrement'  =>      $menage['NumeroEnregistrement'],                       
            'nomchefmenage'         =>      $menage['nomchefmenage'],                       
            'PersonneInscription'   =>      $menage['PersonneInscription'],                       
            'agechefdemenage'       =>      $menage['agechefdemenage'],                       
            'SexeChefMenage'        =>      $menage['SexeChefMenage'],                       
            'Addresse'               =>      $menage['Addresse'],
			'NumeroCIN' => $menage['NumeroCIN'],
			'NumeroCarteElectorale' => $menage['NumeroCarteElectorale'],
			'datedenaissancechefdemenage' => $menage['datedenaissancechefdemenage'],
			'chef_frequente_ecole' => $menage['chef_frequente_ecole'],
			'conjoint_frequente_ecole' => $menage['conjoint_frequente_ecole'],
			'point_inscription' => $menage['point_inscription'],
			'niveau_instruction_chef' => $menage['niveau_instruction_chef'],
			'niveau_instruction_conjoint' => $menage['niveau_instruction_conjoint'],
			'chef_menage_travail' => $menage['chef_menage_travail'],
			'conjoint_travail' => $menage['conjoint_travail'],
			'activite_chef_menage' => $menage['activite_chef_menage'],
			'activite_conjoint' => $menage['activite_conjoint'],
			'id_sous_projet' => $menage['id_sous_projet'],
			'nom_conjoint' => $menage['nom_conjoint'],
			'sexe_conjoint' => $menage['sexe_conjoint'],
			'age_conjoint' => $menage['age_conjoint'],
			'nin_conjoint' => $menage['nin_conjoint'],
			'carte_electorale_conjoint' => $menage['carte_electorale_conjoint'],
			'telephone_chef_menage' => $menage['telephone_chef_menage'],
			'telephone_conjoint' => $menage['telephone_conjoint'],
			'nombre_personne_plus_soixantedixans' => $menage['nombre_personne_plus_soixantedixans'],
			'taille_menage' => $menage['taille_menage'],
			'nombre_enfant_moins_quinze_ans' => $menage['nombre_enfant_moins_quinze_ans'],
			'nombre_enfant_non_scolarise' => $menage['nombre_enfant_non_scolarise'],
			'nombre_enfant_scolarise' => $menage['nombre_enfant_scolarise'],
			'nombre_enfant_moins_six_ans' => $menage['nombre_enfant_moins_six_ans'],			
			'nombre_personne_handicape' => $menage['nombre_personne_handicape'],
			'nombre_adulte_travail' => $menage['nombre_adulte_travail'],
			'nombre_membre_a_etranger' => $menage['nombre_membre_a_etranger'],
			'maison_non_dure' => $menage['maison_non_dure'],
			'acces_electricite' => $menage['acces_electricite'],
			'acces_eau_robinet' => $menage['acces_eau_robinet'],
			'logement_endommage' => $menage['logement_endommage'],
			'niveau_degat_logement' => $menage['niveau_degat_logement'],
			'rehabilitation' => $menage['rehabilitation'],
			'beneficiaire_autre_programme' => $menage['beneficiaire_autre_programme'],
			'membre_fonctionnaire' => $menage['membre_fonctionnaire'],
			'antenne_parabolique' => $menage['antenne_parabolique'],
			'possede_frigo' => $menage['possede_frigo'],
			'score_obtenu' => $menage['score_obtenu'],
			'rang_obtenu' => $menage['rang_obtenu'],			
			'NomTravailleur' => $menage['NomTravailleur'],
			'SexeTravailleur' => $menage['SexeTravailleur'],
			'datedenaissancetravailleur' => $menage['datedenaissancetravailleur'],
			'agetravailleur' => $menage['agetravailleur'],
			'NomTravailleurSuppliant' => $menage['NomTravailleurSuppliant'],
			'SexeTravailleurSuppliant' => $menage['SexeTravailleurSuppliant'],
			'datedenaissancesuppliant' => $menage['datedenaissancesuppliant'],
			'agesuppliant' => $menage['agesuppliant'],
			'statut' => $menage['statut'],			
			'inapte' => $menage['inapte'],			
			'id_sous_projet' => $menage['id_sous_projet'],			
			'quartier' => $menage['quartier'],			
			'milieu' => $menage['milieu'],			
			'zip' => $menage['zip'],			
        );
    }
    public function _set_reponse($menage)
    {
        return array(
			'nombre_personne_plus_soixantedixans' => $menage['nombre_personne_plus_soixantedixans'],
			'taille_menage' => $menage['taille_menage'],
			'nombre_enfant_moins_quinze_ans' => $menage['nombre_enfant_moins_quinze_ans'],
			'nombre_enfant_non_scolarise' => $menage['nombre_enfant_non_scolarise'],
			'nombre_enfant_scolarise' => $menage['nombre_enfant_scolarise'],
			'nombre_enfant_moins_six_ans' => $menage['nombre_enfant_moins_six_ans'],
			'nombre_personne_handicape' => $menage['nombre_personne_handicape'],
			'nombre_adulte_travail' => $menage['nombre_adulte_travail'],
			'nombre_membre_a_etranger' => $menage['nombre_membre_a_etranger'],
			'maison_non_dure' => $menage['maison_non_dure'],
			'acces_electricite' => $menage['acces_electricite'],
			'acces_eau_robinet' => $menage['acces_eau_robinet'],
			'logement_endommage' => $menage['logement_endommage'],
			'niveau_degat_logement' => $menage['niveau_degat_logement'],
			'rehabilitation' => $menage['rehabilitation'],
			'beneficiaire_autre_programme' => $menage['beneficiaire_autre_programme'],
			'membre_fonctionnaire' => $menage['membre_fonctionnaire'],
			'antenne_parabolique' => $menage['antenne_parabolique'],
			'possede_frigo' => $menage['possede_frigo'],
			'score_obtenu' => $menage['score_obtenu'],
			'rang_obtenu' => $menage['rang_obtenu'],			
        );
    }
    public function _set_statut($menage)
    {
        return array(
			'statut'             => $menage['statut'],
			'identifiant_menage' => $menage['identifiant_menage'],
        );
    }
    public function _set_photo($menage)
    {
        return array(
			'photo'                     => $menage['photo'],
			'phototravailleur'          => $menage['phototravailleur'],
			'phototravailleursuppliant' => $menage['phototravailleursuppliant'],
        );
    }


    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }

    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllByVillage($village_id)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->where("village_id", $village_id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllByVillageAndStatut($village_id,$statut)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->where("village_id", $village_id)
                        ->where("statut", $statut)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllByVillageAndStatutAndSousProjet($village_id,$statut,$id_sous_projet)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->join('menage_beneficiaire', 'menage_beneficiaire.id_menage = menage.id')
                        ->where('menage.statut', $statut)
                        ->where('menage.village_id', $village_id)
                        ->where('menage_beneficiaire.id_sous_projet', $id_sous_projet)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
		
		
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->where("village_id", $village_id)
                        ->where("statut", $statut)
                        ->where("statut", $statut)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function find_max_id()
    {
        $q =  $this->db->select_max('id')
                        ->from($this->table)
                        ->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;              
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

}
