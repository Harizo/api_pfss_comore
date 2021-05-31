<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('menage_model', 'menageManager');
        $this->load->model('menage_beneficiaire_model', 'MenageBeneficiaireManager');
    }

    public function index_get() {
        $id = $this->get('id');

        $cle_etrangere = $this->get('cle_etrangere');
        $statut = $this->get('statut');
        $id_sous_projet = $this->get('id_sous_projet');
        $beneficiaire = $this->get('beneficiaire');
        $tous = $this->get('tous');
		$id_groupe_ml_pl = $this->get('id_groupe_ml_pl');
        $max_id = $this->get('max_id');
		$data=array();
		if($id_groupe_ml_pl)
		{	
			$data = $this->menageManager->findmenageBygroupe($id_groupe_ml_pl);
	   } else if($cle_etrangere && $tous && $id_sous_projet) {
			 $data = $this->menageManager->findAllByVillageAndSousProjet($cle_etrangere,$id_sous_projet);
		} else if ($max_id == 1) {
            $data = $this->menageManager->find_max_id();
        } else if ($cle_etrangere && $statut && $statut=="PRESELECTIONNE" && $id_sous_projet && $beneficiaire) {
        }  else if ($cle_etrangere && $statut && $id_sous_projet && $beneficiaire) {
			$data = $this->menageManager->findAllByVillageAndBeneficiaireStatutAndSousProjet($cle_etrangere,$statut,$id_sous_projet);
        } else if ($cle_etrangere && $statut && $id_sous_projet) {
			if($statut=="PRESELECTIONNE") {
				$data = $this->menageManager->findAllByVillageAndPreselectionnneStatutAndSousProjet($cle_etrangere,$statut,$id_sous_projet);
			} else {
				$data = $this->menageManager->findAllByVillageAndStatutAndSousProjet($cle_etrangere,$statut,$id_sous_projet);
			}	
        }else if ($cle_etrangere && $statut) {
			$data = $this->menageManager->findAllByVillageAndStatut($cle_etrangere,$statut);
        } else if($cle_etrangere) {
			$data = $this->menageManager->findAllByVillage($cle_etrangere);	
		} else if ($id) {                 
			$data = $this->menageManager->findById($id);
		} else {
			$data = $this->menageManager->findAll();
		}  
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        $mise_a_jour_statut = $this->post('mise_a_jour_statut') ;
        $mise_a_jour_photo = $this->post('mise_a_jour_photo') ;
		$data = array(
			'id_serveur_centrale' => null,
			'DateInscription' => $this->post('DateInscription'),
			'village_id' => $this->post('village_id'),
			'NumeroEnregistrement' => $this->post('NumeroEnregistrement'),
			'identifiant_menage' => $this->post('identifiant_menage'),
			'nomchefmenage' => $this->post('nomchefmenage'),
			'PersonneInscription' => $this->post('PersonneInscription'),
			'agechefdemenage' => $this->post('agechefdemenage'),
			'SexeChefMenage' => $this->post('SexeChefMenage'),
			'Addresse' => $this->post('Addresse'),
			'NumeroCIN' => $this->post('NumeroCIN'),
			'NumeroCarteElectorale' => $this->post('NumeroCarteElectorale'),
			'datedenaissancechefdemenage' => $this->post('datedenaissancechefdemenage'),
			'chef_frequente_ecole' => $this->post('chef_frequente_ecole'),
			'conjoint_frequente_ecole' => $this->post('conjoint_frequente_ecole'),
			'point_inscription' => $this->post('point_inscription'),
			'niveau_instruction_chef' => $this->post('niveau_instruction_chef'),
			'niveau_instruction_conjoint' => $this->post('niveau_instruction_conjoint'),
			'chef_menage_travail' => $this->post('chef_menage_travail'),
			'conjoint_travail' => $this->post('conjoint_travail'),
			'activite_chef_menage' => $this->post('activite_chef_menage'),
			'activite_conjoint' => $this->post('activite_conjoint'),
			'id_sous_projet' => $this->post('id_sous_projet'),
			'nom_conjoint' => $this->post('nom_conjoint'),
			'sexe_conjoint' => $this->post('sexe_conjoint'),
			'age_conjoint' => $this->post('age_conjoint'),
			'nin_conjoint' => $this->post('nin_conjoint'),
			'carte_electorale_conjoint' => $this->post('carte_electorale_conjoint'),
			'telephone_chef_menage' => $this->post('telephone_chef_menage'),
			'telephone_conjoint' => $this->post('telephone_conjoint'),
			'nombre_personne_plus_soixantedixans' => $this->post('nombre_personne_plus_soixantedixans'),
			'taille_menage' => $this->post('taille_menage'),
			'nombre_enfant_moins_quinze_ans' => $this->post('nombre_enfant_moins_quinze_ans'),
			'nombre_enfant_non_scolarise' => $this->post('nombre_enfant_non_scolarise'),
			'nombre_enfant_scolarise' => $this->post('nombre_enfant_scolarise'),
			'nombre_enfant_moins_six_ans' => $this->post('nombre_enfant_moins_six_ans'),
			'nombre_personne_handicape' => $this->post('nombre_personne_handicape'),
			'nombre_adulte_travail' => $this->post('nombre_adulte_travail'),
			'nombre_membre_a_etranger' => $this->post('nombre_membre_a_etranger'),
			'maison_non_dure' => $this->post('maison_non_dure'),
			'acces_electricite' => $this->post('acces_electricite'),
			'acces_eau_robinet' => $this->post('acces_eau_robinet'),
			'logement_endommage' => $this->post('logement_endommage'),
			'niveau_degat_logement' => $this->post('niveau_degat_logement'),
			'rehabilitation' => $this->post('rehabilitation'),
			'beneficiaire_autre_programme' => $this->post('beneficiaire_autre_programme'),
			'membre_fonctionnaire' => $this->post('membre_fonctionnaire'),
			'antenne_parabolique' => $this->post('antenne_parabolique'),
			'possede_frigo' => $this->post('possede_frigo'),
			'score_obtenu' => $this->post('score_obtenu'),
			'rang_obtenu' => $this->post('rang_obtenu'),
			'NomTravailleur' => $this->post('NomTravailleur'),
			'SexeTravailleur' => $this->post('SexeTravailleur'),
			'datedenaissancetravailleur' => $this->post('datedenaissancetravailleur'),
			'agetravailleur' => $this->post('agetravailleur'),
			'NomTravailleurSuppliant' => $this->post('NomTravailleurSuppliant'),
			'SexeTravailleurSuppliant' => $this->post('SexeTravailleurSuppliant'),
			'datedenaissancesuppliant' => $this->post('datedenaissancesuppliant'),
			'agesuppliant' => $this->post('agesuppliant'),
			'statut' => $this->post('statut'),
			'inapte' => $this->post('inapte'),
			'id_sous_projet' => $this->post('id_sous_projet'),
			'quartier' => $this->post('quartier'),
			'milieu' => $this->post('milieu'),
			'zip' => $this->post('zip'),
			'photo' => $this->post('photo'),
			'phototravailleur' => $this->post('phototravailleur'),
			'phototravailleursuppliant' => $this->post('phototravailleursuppliant'),
			'inscrit' => $this->post('inscrit'),
			'preselectionne' => $this->post('preselectionne'),
			'beneficiaire' => $this->post('beneficiaire'),
			'taille_menage_enquete' => $this->post('taille_menage_enquete'),
			'nombre_personne_plus_soixantedixans_enquete' => $this->post('nombre_personne_plus_soixantedixans_enquete'),
			'nombre_enfant_moins_six_ans_enquete'  => $this->post('nombre_enfant_moins_six_ans_enquete'),
			'nombre_enfant_scolarise_enquete' => $this->post('nombre_enfant_scolarise_enquete'),
			'nombre_enfant_moins_quinze_ans_enquete' => $this->post('nombre_enfant_moins_quinze_ans_enquete'),
			'nombre_enfant_non_scolarise_enquete' => $this->post('nombre_enfant_non_scolarise_enquete'),
			'nombre_personne_handicape_enquete' => $this->post('nombre_personne_handicape_enquete'),
			'nombre_adulte_travail_enquete' => $this->post('nombre_adulte_travail_enquete'),
			'nombre_membre_a_etranger_enquete' => $this->post('nombre_membre_a_etranger_enquete'),
			'maison_non_dure_enquete' => $this->post('maison_non_dure_enquete'),
			'acces_electricite_enquete' => $this->post('acces_electricite_enquete'),
			'acces_eau_robinet_enquete' => $this->post('acces_eau_robinet_enquete'),
			'logement_endommage_enquete' => $this->post('logement_endommage_enquete'),
			'niveau_degat_logement_enquete' => $this->post('niveau_degat_logement_enquete'),
			'rehabilitation_enquete' => $this->post('rehabilitation_enquete'),
			'beneficiaire_autre_programme_enquete' => $this->post('beneficiaire_autre_programme_enquete'),
			'membre_fonctionnaire_enquete' => $this->post('membre_fonctionnaire_enquete'),
			'possede_frigo_enquete' => $this->post('possede_frigo_enquete'),
			'antenne_parabolique_enquete' => $this->post('antenne_parabolique_enquete'),
		);   
        if ($supprimer == 0) {
            if ($id == 0) {
               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->menageManager->add($data);              
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				if($mise_a_jour_statut) {
					$data = array(
						'statut' => $this->post('statut'),
						'identifiant_menage' => $this->post('identifiant_menage'),
						'inscrit' => $this->post('inscrit'),
						'preselectionne' => $this->post('preselectionne'),
						'beneficiaire' => $this->post('beneficiaire'),
						);
					$update = $this->menageManager->update_statut($id, $data);	
					if($this->post('statut')=='BENEFICIAIRE') {
						// ajout menage bénéficiaire si $nombre==null;
						$nombre = $this->MenageBeneficiaireManager->findAllByMenageSousprojet($this->post('menage_id'),$this->post('id_sous_projet'));	
						if(!$nombre) {
							$data = array(
								'date_inscription' => $this->post('DateInscription'),
								'date_sortie' => null,
								'id_menage' => $this->post('menage_id'),
								'id_sous_projet' => $this->post('id_sous_projet'),
							);
							$ajout = $this->MenageBeneficiaireManager->add($data);	
						} 
					}else {
						// Enlever dans ménage bénéficiaire  retour PRESELECTIONNE
						$del = $this->MenageBeneficiaireManager->deleteByMenageSousprojet($this->post('menage_id'),$this->post('id_sous_projet'));	
					}						
				} else if($mise_a_jour_photo) {
					$data = array(
						'photo' => $this->post('photo'),
						'phototravailleur' => $this->post('phototravailleur'),
						'phototravailleursuppliant' => $this->post('phototravailleursuppliant'),
					);
					$update = $this->menageManager->update_photo($id, $data);	
				} else {		
					$update = $this->menageManager->update($id, $data); 
				}		
                if(!is_null($update)){
                    $this->response([
                        'status' => TRUE, 
                        'response' => $id,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            if (!$id) {
            $this->response([
            'status' => FALSE,
            'response' => 0,
            'message' => 'No request found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->menageManager->delete($id);          
            if (!is_null($delete)) {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_OK);
            }
        }   
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */