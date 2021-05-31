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
    public function update_sortie($id, $menage)
    {
        $this->db->set($this->_set_sortie($menage))
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
            'identifiant_menage'    =>      $menage['identifiant_menage'],                       
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
			'lien_travailleur' => $menage['lien_travailleur'],
			'NomTravailleurSuppliant' => $menage['NomTravailleurSuppliant'],
			'SexeTravailleurSuppliant' => $menage['SexeTravailleurSuppliant'],
			'datedenaissancesuppliant' => $menage['datedenaissancesuppliant'],
			'agesuppliant' => $menage['agesuppliant'],
			'lien_suppleant' => $menage['lien_suppleant'],
			'statut' => $menage['statut'],			
			'inapte' => $menage['inapte'],			
			'id_sous_projet' => $menage['id_sous_projet'],			
			'quartier' => $menage['quartier'],			
			'milieu' => $menage['milieu'],			
			'zip' => $menage['zip'],			
			'inscrit' => $menage['inscrit'],			
			'preselectionne' => $menage['preselectionne'],			
			'beneficiaire' => $menage['beneficiaire'],			
			'taille_menage_enquete' => $menage['taille_menage_enquete'],
			'nombre_personne_plus_soixantedixans_enquete' => $menage['nombre_personne_plus_soixantedixans_enquete'],
			'nombre_enfant_moins_six_ans_enquete' =>  $menage['nombre_enfant_moins_six_ans_enquete'],
			'nombre_enfant_scolarise_enquete' => $menage['nombre_enfant_scolarise_enquete'],
			'nombre_enfant_moins_quinze_ans_enquete' => $menage['nombre_enfant_moins_quinze_ans_enquete'],
			'nombre_enfant_non_scolarise_enquete' => $menage['nombre_enfant_non_scolarise_enquete'],
			'nombre_personne_handicape_enquete' => $menage['nombre_personne_handicape_enquete'],
			'nombre_adulte_travail_enquete' => $menage['nombre_adulte_travail_enquete'],
			'nombre_membre_a_etranger_enquete' => $menage['nombre_membre_a_etranger_enquete'],
			'maison_non_dure_enquete' => $menage['maison_non_dure_enquete'],
			'acces_electricite_enquete' => $menage['acces_electricite_enquete'],
			'acces_eau_robinet_enquete' => $menage['acces_eau_robinet_enquete'],
			'logement_endommage_enquete' => $menage['logement_endommage_enquete'],
			'niveau_degat_logement_enquete' => $menage['niveau_degat_logement_enquete'],
			'rehabilitation_enquete' => $menage['rehabilitation_enquete'],
			'beneficiaire_autre_programme_enquete' => $menage['beneficiaire_autre_programme_enquete'],
			'membre_fonctionnaire_enquete' => $menage['membre_fonctionnaire_enquete'],
			'possede_frigo_enquete' => $menage['possede_frigo_enquete'],
			'antenne_parabolique_enquete' => $menage['antenne_parabolique_enquete'],
			'motif_non_selection' => $menage['motif_non_selection'],
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
			'taille_menage_enquete' => $menage['taille_menage_enquete'],
			'nombre_personne_plus_soixantedixans_enquete' => $menage['nombre_personne_plus_soixantedixans_enquete'],
			'nombre_enfant_moins_six_ans_enquete'  => $menage['nombre_enfant_moins_six_ans_enquete'],
			'nombre_enfant_scolarise_enquete' => $menage['nombre_enfant_scolarise_enquete'],
			'nombre_enfant_moins_quinze_ans_enquete' => $menage['nombre_enfant_moins_quinze_ans_enquete'],
			'nombre_enfant_non_scolarise_enquete' => $menage['nombre_enfant_non_scolarise_enquete'],
			'nombre_personne_handicape_enquete' => $menage['nombre_personne_handicape_enquete'],
			'nombre_adulte_travail_enquete' => $menage['nombre_adulte_travail_enquete'],
			'nombre_membre_a_etranger_enquete' => $menage['nombre_membre_a_etranger_enquete'],
			'maison_non_dure_enquete' => $menage['maison_non_dure_enquete'],
			'acces_electricite_enquete' => $menage['acces_electricite_enquete'],
			'acces_eau_robinet_enquete' => $menage['acces_eau_robinet_enquete'],
			'logement_endommage_enquete' => $menage['logement_endommage_enquete'],
			'niveau_degat_logement_enquete' => $menage['niveau_degat_logement_enquete'],
			'rehabilitation_enquete' => $menage['rehabilitation_enquete'],
			'beneficiaire_autre_programme_enquete' => $menage['beneficiaire_autre_programme_enquete'],
			'membre_fonctionnaire_enquete' => $menage['membre_fonctionnaire_enquete'],
			'possede_frigo_enquete' => $menage['possede_frigo_enquete'],
			'antenne_parabolique_enquete' => $menage['antenne_parabolique_enquete'],
			'motif_non_selection' => $menage['motif_non_selection'],
        );
    }
    public function _set_statut($menage)
    {
        return array(
			'statut'             => $menage['statut'],
			'identifiant_menage' => $menage['identifiant_menage'],
			'inscrit'            => $menage['inscrit'],
			'preselectionne'     => $menage['preselectionne'],
			'beneficiaire'       => $menage['beneficiaire'],
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
    public function _set_sortie($menage)
    {
        return array(
			'statut'                     => $menage['statut'],
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
    public function findAllByVillageAndPreselectionnneStatutAndSousProjet($village_id,$statut,$id_sous_projet)
    {
		$requete="select * from menage as m"
                ." where m.id_sous_projet=".$id_sous_projet." and m.village_id=".$village_id." and statut in('PRESELECTIONNE','BENEFICIAIRE')"
				." and m.village_id=".$village_id;	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllByVillageAndBeneficiaireStatutAndSousProjet($village_id,$statut,$id_sous_projet)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->join('menage_beneficiaire', 'menage_beneficiaire.id_menage = menage.id')
                        // ->join('see_village', 'menage.village_id = see_village.id')
                        // ->join('zip', 'zip.id = see_village.id_zip')
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
    }
    public function findAllByVillageAndSousProjet($village_id,$id_sous_projet)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('menage.id_sous_projet', $id_sous_projet)
                        ->where('menage.village_id', $village_id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllByVillageAndEtatstatut($village_id,$id_sous_projet,$etat_statut)
    {
		$requete="select menage.*,lp1.description as lien_parente_travailleur,"
				."lp2.description as lien_parente_suppleant"
				." from menage"
				." left join liendeparente as lp1 on lp1.id="."menage.lien_travailleur"
				." left join liendeparente as lp2 on lp2.id="."menage.lien_suppleant"
				." where  village_id=".$village_id
				." and statut!='SORTI' and ".$etat_statut."=1".($id_sous_projet>0 ? " and id_sous_projet=".$id_sous_projet : "");
		$result = $this->db->query($requete)->result();		
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function findAllByVillageAndMenagemlpl($village_id,$id_groupe_ml_pl)
    {	// Liste ménage bénéficiaire par village avec statut<>SORTI et beneficiaire=1
		// En outre il faut enlever les ménages qui ppartiennent déjà dans un autre groupe ML/PL
		$requete="select * from menage as m where m.beneficiaire =1 and m.statut <> 'SORTI' and m.village_id =".$village_id
				." and m.id not in "
				." (select distinct lmplp.menage_id from liste_menage_ml_pl as lmplp"
				." left join menage as m1 on m1.id=lmplp.menage_id "
				." where lmplp.id_groupe_ml_pl<>".$id_groupe_ml_pl.")";
		$result = $this->db->query($requete)->result();		
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
                        ->where('menage.statut', $statut)
                        ->where('menage.village_id', $village_id)
                        ->where('menage.id_sous_projet', $id_sous_projet)
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
