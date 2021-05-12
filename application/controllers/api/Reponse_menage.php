<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Reponse_menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reponse_menage_model', 'ReponseMenageManager');
        $this->load->model('liste_variable_model', 'ListeVariableManager');
		$this->load->model('variable_model', 'VariableManager');
		$this->load->model('menage_model', 'MenageManager');
    }
    //recuperation détail variable intervention
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        if ($cle_etrangere){
			$data=array();
			$data["variable_choix_unique"] =  array();
			$data["variable_choix_multiple"] =  array();
            $data_choix_multiple = array();
            $data_choix_unique = array();
			$indice_choix_unique=0;
			$indice_choix_multiple=0;
			// Selection liste variable
            $temporaire = $this->ReponseMenageManager->findAllByIdMenage($cle_etrangere);
            if ($temporaire) {
				// Variable utile pour controler la saisie des nombres prévu d'individu/ménage/groupe
				// Le champ est actif si la variable correspondante = 1
				$individu_prevu=0;
				$menage_prevu=0;
				$groupe_prevu=0;
               foreach ($temporaire as $key => $value) {
					// Affectation des valeurs des id_intervention dans un tableau : seul les id_intervention nous interesse
					// pour être selectionné dans des choix multiple 
					// Si choix unique
					$si_choix_unique=$this->ListeVariableManager->findByIdArray($value->id_liste_variable);
					$choix_unique=0;
					foreach($si_choix_unique as $k=>$v) {
						$choix_unique=$v->choix_unique;
					}
					if(intval($choix_unique)==0) {
						$data_choix_multiple[$indice_choix_multiple] = $value->id_variable;
						$indice_choix_multiple=$indice_choix_multiple + 1;
					} else {
						$data_choix_unique[$value->id_liste_variable] = $value->id_variable;
						if(intval($value->id_liste_variable)==1) {
							if(intval($value->id_variable)==1) {
								$menage_prevu=1;
							} else if(intval($value->id_variable)==2) {
								$individu_prevu=1;
							} else {
								$groupe_prevu=1;
							}
						}
					}	
                }
				$data["variable_choix_unique"] = $data_choix_unique;
				$data["variable_choix_multiple"] = $data_choix_multiple;
				$data["menage_prevu"] = $menage_prevu;
				$data["individu_prevu"] = $individu_prevu;
				$data["groupe_prevu"] = $groupe_prevu;
            }           
        } else {
            if ($id) {
                $data = array();
				// Selection par id
                $data = $this->ReponseMenageManager->findById($id);
            } else {
				// Selection de tous les enregistrements
                $menu = $this->ReponseMenageManager->findAll();
                if ($menu) {
                    foreach ($menu as $key => $value) {
						// Affectation des valeurs dans un tableau
                        $listevariable = array();
						$variable=array();
                        $listevariable = $this->ListeVariableManager->findById($value->id_liste_variable);
                        $variable = $this->VariableManager->findById($value->id_variable);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['id_variable'] = $value->id_variable;
                        $data[$key]['id_liste_validation_beneficiaire'] = $value->id_liste_validation_beneficiaire;
                        $data[$key]['id_liste_variable'] = $value->id_liste_variable;
                        $data[$key]['listevariable'] = $listevariable;
                        $data[$key]['ng_model'] = $variable;
                    }
                } else
                    $data = array();
            }
        }
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    //insertion,modification,suppression détail variable intervention
    public function index_post() {
		// Mise à jour réponse ménage d'abord
			$id_menage=$this->post('id_menage');
			$reponse_menage = array(
				'nombre_personne_plus_soixantedixans' => $this->post('nombre_personne_plus_soixantedixans'),
				'taille_menage' => $this->post('taille_menage'),
				'nombre_enfant_moins_six_ans' => $this->post('nombre_enfant_moins_six_ans'),
				'nombre_enfant_moins_quinze_ans' => $this->post('nombre_enfant_moins_quinze_ans'),
				'nombre_enfant_scolarise' => $this->post('nombre_enfant_scolarise'),
				'nombre_enfant_non_scolarise' => $this->post('nombre_enfant_non_scolarise'),
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
				'taille_menage_enquete' => $this->post('taille_menage_enquete'),
				'nombre_personne_plus_soixantedixans_enquete' => $this->post('nombre_personne_plus_soixantedixans_enquete'),
				'nombre_enfant_moins_six_ans_enquete' => $this->post('nombre_enfant_moins_six_ans_enquete'),
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
			$retour = $this->MenageManager->update_reponse($id_menage, $reponse_menage);
		// Mise à jour réponse ménage d'abord
		$id_intervention = $this->post('id_intervention');
		$intitule_intervention = $this->post('intitule_intervention');
		$nombre_reponse_menage_choix_multiple = $this->post('nombre_reponse_menage_choix_multiple');
		$nombre_reponse_menage_choix_unique = $this->post('nombre_reponse_menage_choix_unique');
		$id_liste_validation_beneficiaire=null;
		$temporaire=$this->post('id_liste_validation_beneficiaire');
		if(isset($temporaire) && $temporaire !="" && intval($temporaire) >0) {
			$id_liste_validation_beneficiaire=$temporaire;
		}
		// Supprimer d'abord les variables existantes dans la table; puis réinsérer après
		$nombre_enregistrement_supprime= $this->ReponseMenageManager->deleteByMenage($id_intervention);
		if($nombre_reponse_menage_choix_multiple >0) {
			// Ajout détail liste variable à choix multiple
			for($i=1;$i<=$nombre_reponse_menage_choix_multiple;$i++) {
				$id_variable = $this->post('id_variable_'.$i);
				$id_liste_variable =null;
				// Récupération id_liste_variable correspondant à id_variable
				$retour= $this->VariableManager->findById($id_variable);
				foreach($retour as $k=>$v) {
					$id_liste_variable = $v->id_liste_variable;
				}
				$data = array(
					'id_variable' => $id_variable,
					'id_liste_variable' => $id_liste_variable,
					'id_menage' => $id_menage ,
				);
				$retour = $this->ReponseMenageManager->add($data);     
			}
		}
		if($nombre_reponse_menage_choix_unique >0) {
			// Ajout détail liste variable à choix multiple
			for($i=1;$i<=$nombre_reponse_menage_choix_unique;$i++) {
				$id_variable = $this->post('id_variable_unique_'.$i);
				$id_liste_variable =$this->post('id_liste_variable_'.$i);
				$data = array(
					'id_variable' => $id_variable,
					'id_liste_variable' => $id_liste_variable,
					'id_menage' => $id_menage ,
				);
				$retour = $this->ReponseMenageManager->add($data);     
			}
		}	
			$data=array();
			$data["variable_choix_unique"] =  array();
			$data["variable_choix_multiple"] =  array();
            $data_choix_multiple = array();
            $data_choix_unique = array();
			$indice_choix_multiple=0;
			// Selection liste variable
            $temporaire = $this->ReponseMenageManager->findAllByIdMenage($id_intervention);
            if ($temporaire) {
				// Variable utile pour controler la saisie des nombres prévu d'individu/ménage/groupe
				// Le champ est actif si la variable correspondante = 1
				$individu_prevu=0;
				$menage_prevu=0;
				$groupe_prevu=0;
               foreach ($temporaire as $key => $value) {
					// Affectation des valeurs des id_intervention dans un tableau : seul les id_intervention nous interesse
					// pour être selectionné dans des choix multiple 
					// Si choix unique
					$si_choix_unique=$this->ListeVariableManager->findByIdArray($value->id_liste_variable);
					$choix_unique=0;
					foreach($si_choix_unique as $k=>$v) {
						$choix_unique=$v->choix_unique;
					}
					if(intval($choix_unique)==0) {
						$data_choix_multiple[$indice_choix_multiple] = $value->id_variable;
						$indice_choix_multiple=$indice_choix_multiple + 1;
					} else {
						$data_choix_unique[$value->id_liste_variable] = $value->id_variable;
						if(intval($value->id_liste_variable)==1) {
							if(intval($value->id_variable)==1) {
								$menage_prevu=1;
							} else if(intval($value->id_variable)==2) {
								$individu_prevu=1;
							} else {
								$groupe_prevu=1;
							}
						}
					}	
                }
				$data["variable_choix_unique"] = $data_choix_unique;
				$data["variable_choix_multiple"] = $data_choix_multiple;
				$data["menage_prevu"] = $menage_prevu;
				$data["individu_prevu"] = $individu_prevu;
				$data["groupe_prevu"] = $groupe_prevu;
            }           		
		$message_retour=" dans Réponse ménage :".$intitule_intervention; 
		if($nombre_enregistrement_supprime > 0 && ($nombre_reponse_menage_choix_multiple > 0 || $nombre_reponse_menage_choix_unique > 0 ) ) {
			$message_retour = "Modification".$message_retour;
		} else {
			$message_retour = "Ajout".$message_retour;
		} 
		$data["message_retour"]=$message_retour;
		$this->response([
			'status' => TRUE,
			'response' => $data,
			'message' => 'Data insert success'
				], REST_Controller::HTTP_OK);			
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>