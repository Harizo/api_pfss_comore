<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importation_menage_model extends CI_Model
{
    protected $table = 'see_ile';

	// Selection région par nom
	public function selectionile($nom) {
		$requete="select id,ile,code from see_ile where lower(ile)='".$nom."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection région par id
	public function selectionileparid($id) {
		$requete="select id,ile,code from see_ile where id='".$id."'";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection région par nom
	public function selectionile_avec_espace($nom1,$nom2) {
		$requete="select id,ile,code from see_ile where lower(ile) like '%".$nom1."%' and lower(ile) like '%".$nom2."%' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection region par nom et ile_id
	public function selectionileprefecture($region,$ile_id) {
		$requete="select id,region,code from see_region where lower(region)='".$region."' and ile_id ='".$ile_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection region par id
	public function selectionprefectureparid($id) {
			$requete="select id,region,code, from see_region where id ='".$id."'";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection region par nom et ile_id
	public function selectionprefecture_avec_espace($nom1,$nom2,$ile_id) {
		$requete="select id,region,code from see_region where lower(region) like '%".$nom1."%' and lower(region) like'%".$nom2."%' and ile_id ='".$ile_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection commune par nom et region_id
	public function selectioncommune($nom,$region_id) {
		$requete="select id,commune,code from see_commune where lower(commune) like '%".$nom."%' and region_id ='".$region_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection commune par id
	public function selectioncommuneparid($id) {
		$requete="select id,commune,code,region_id from see_commune where id='".$id."'";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection commune par nom et region_id
	public function selectioncommune_avec_espace($nom1,$nom2,$region_id) {
		$requete="select id,commune,code from see_commune where lower(commune) like '%".$nom1."%' and lower(commune) like'%".$nom2."%' and region_id ='".$region_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection village par nom et id_commune
	public function selectionvillage($nom,$commune_id) {
		$requete="select id,village,code from see_village where lower(village) like '%".$nom."%' and commune_id ='".$commune_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection village par id
	public function selectionvillageparid($id) {
		$requete="select id,village,code from see_village where id='".$id."'";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	// Selection village par nom et commune_id
	public function selectionvillage_avec_espace($nom1,$nom2,$commune_id) {
		$requete="select id,village,code from see_village where lower(village) like '%".$nom1."%' and lower(village) like'%".$nom2."%' and commune_id ='".$commune_id."' limit 1";
		$query = $this->db->query($requete);
        return $query->result();
	}	
	public function selectionsous_projet($code) {
		$requete="select id,description,code from sous_projet where lower(code) like '%".$code."%'";
		$query = $this->db->query($requete);
        return $query->result();
	}	
	public function selection_identifiant_menage($identifiant) {
		$requete="select count(*) as nombre from menage where identifiant_menage='".$identifiant."'";
		$query = $this->db->query($requete);
        return $query->result();
	}
	
    public function addARSE($arse) {
        $this->db->set($this->_setARSE($arse))
                            ->insert("menage");
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _setARSE($arse) {
        return array(
			'statut'                        	    => $arse['statut'],
			'village_id'                        	=> $arse['village_id'],
			'point_inscription'                 	=> $arse['point_inscription'],
			'NumeroEnregistrement'	                =>	$arse['numeroenregistrement'],
			'DateInscription'                   	=>	$arse['date_inscription'],
			'milieu'                            	=>	$arse['milieu'],
			'zip'	                                =>	$arse['zip'],
			'Addresse'	                            =>	$arse['adresse'],
			'nomchefmenage'                      	=>	$arse['nomchefmenage'],
			'SexeChefMenage'	                    =>	$arse['SexeChefMenage'],
			'chef_frequente_ecole'              	=>	$arse['chef_frequente_ecole'],
			'niveau_instruction_chef'	            =>	$arse['niveau_instruction_chef'],
			'chef_menage_travail'               	=>	$arse['chef_menage_travail'],
			'activite_chef_menage'	                =>	$arse['activite_chef_menage'],
			'NumeroCIN'	                            =>	$arse['NumeroCIN'],
			'NumeroCarteElectorale'                	=>	$arse['NumeroCarteElectorale'],
			'telephone_chef_menage'	                =>	$arse['telephone_chef_menage'],
			'nom_conjoint'	                        =>	$arse['nom_conjoint'],
			'sexe_conjoint'	                        =>	$arse['sexe_conjoint'],
			'conjoint_frequente_ecole'	            =>	$arse['conjoint_frequente_ecole'],
			'niveau_instruction_conjoint'	        =>	$arse['niveau_instruction_conjoint'],
			'conjoint_travail'                    	=>	$arse['conjoint_travail'],
			'activite_conjoint'	                    =>	$arse['activite_conjoint'],
			'nin_conjoint'	                        =>	$arse['nin_conjoint'],
			'carte_electorale_conjoint'	            =>	$arse['carte_electorale_conjoint'],
			'telephone_conjoint'	                =>	$arse['telephone_conjoint'],
			'taille_menage'	                        =>	$arse['taille_menage'],
			'nombre_personne_plus_soixantedixans'	=>	$arse['nombre_personne_plus_soixantedixans'],
			'nombre_enfant_moins_quinze_ans'	    =>	$arse['nombre_enfant_moins_quinze_ans'],
			'nombre_enfant_non_scolarise'	        =>	$arse['nombre_enfant_non_scolarise'],
			'nombre_personne_handicape'	            =>	$arse['nombre_personne_handicape'],
			'nombre_adulte_travail'             	=>	$arse['adulte_travail'],
			'nombre_membre_a_etranger'	            =>	$arse['nombre_membre_a_etranger'],
			'maison_non_dure'                   	=>	$arse['maison_non_dure'],
			'acces_electricite'                 	=>	$arse['acces_electricite'],
			'acces_eau_robinet'	                    =>	$arse['acces_eau_robinet'],
			'logement_endommage'	                =>	$arse['logement_endommage'],
			'niveau_degat_logement'	                =>	$arse['niveau_degat_logement'],
			'rehabilitation'	                    =>	$arse['rehabilitation'],
			'beneficiaire_autre_programme'	        =>	$arse['beneficiaire_autre_programme'],
			'membre_fonctionnaire'	                =>	$arse['membre_fonctionnaire'],
			'antenne_parabolique'	                =>	$arse['antenne_parabolique'],
			'possede_frigo'                     	=>	$arse['possede_frigo'],
			'identifiant_menage'	                =>	$arse['identifiant_menage'],
			'score_obtenu'	                        =>	$arse['score_obtenu'],
			'rang_obtenu'	                        =>	$arse['rang_obtenu'],
			'id_sous_projet'	                    =>  $arse['id_sous_projet'],
        );
    }
	
    public function MiseajourStatut($statut,$liste_menage_id) {
		$this->db->trans_begin();
		$this->table="menage";
		$requete = "update " .$this->table ." set statut='".$statut."' where id in ".$liste_menage_id;
		$query= $this->db->query($requete);		
			
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
			return "NON";
        } else {
            $this->db->trans_commit();
			return "OK";
		}
	}
    public function MiseajourHistoriqueStatut($etat_statut,$liste_menage_id) {
		// M.A.J 3 champs ou colonnes table menage : inscrit,preselecionne,beneficiaire
		// il se peut qu'un ménage passe directement au statut de bénéficiaire sans passer par insrit et preselecionne
		$this->db->trans_begin();
		$this->table="menage";
		$requete = "update " .$this->table ." set ".$etat_statut."=1 where id in ".$liste_menage_id;
		$query= $this->db->query($requete);		
			
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
			return "NON";
        } else {
            $this->db->trans_commit();
			return "OK";
		}
	}
	public function selectionMenage_Par_Identifiant($identifiant_menage) {
		$this->table="menage";
		$requete="select id,village_id,DateInscription from ".$this->table ." where identifiant_menage='".$identifiant_menage."'";
		$query = $this->db->query($requete);
        return $query->result();
	}	
	public function getIdMaxMenage() {
		$this->table="menage";
		$requete="select ifnull(max(id),0) as id from ".$this->table;
		$query = $this->db->query($requete);
        return $query->result();
	}	
	public function MenageInseresDernierement($id_max_menage) {
		$this->table="menage";
		$requete="select * from ".$this->table ." where id >=".$id_max_menage;
		$query = $this->db->query($requete);
        return $query->result();
	}	
	public function selectionzipparcode($code) {
		$requete="select id,libelle,code from zip where code='".$code."'";
		$query = $this->db->query($requete);
        return $query->result();				
	}
	
} ?>
