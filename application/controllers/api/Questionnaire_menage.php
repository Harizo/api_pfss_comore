<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Questionnaire_menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('questionnaire_menage_model', 'QuestionnairemenageManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
		if ($id) {
			// Récupération par id (id=clé primaire)
			$temporaire = $this->QuestionnairemenageManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Récupération de tous les enregistrements	
			$temporaire = $this->QuestionnairemenageManager->findAll();
			if ($temporaire) {
				$data=$temporaire;
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
                'status' => TRUE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		// Affectation des valeurs de chaque colonne de la table
		$data = array(
			'id_menage'                    => $this->post('id_menage'),
			'type_logement'                => $this->post('type_logement'),
			'occupation_logement'          => $this->post('occupation_logement'),
			'revetement_toit'              => $this->post('revetement_toit'),
			'revetement_sol'               => $this->post('revetement_sol'),
			'revetement_mur'               => $this->post('revetement_mur'),
			'eclairage'                    => $this->post('eclairage'),
			'combustible'                  => $this->post('combustible'),
			'toilette'                     => $this->post('toilette'),
			'source_eau'                   => $this->post('source_eau'),
			'type_bien_equipement'         => $this->post('type_bien_equipement'),
			'moyen_production'             => $this->post('moyen_production'),
			'source_revenu'                => $this->post('source_revenu'),
			'type_elevage'                 => $this->post('type_elevage'),
			'type_culture'                 => $this->post('type_culture'),
			'type_aliment'                 => $this->post('type_aliment'),
			'type_difficulte_alimentaire'  => $this->post('type_difficulte_alimentaire'),
			'type_strategie_face_probleme' => $this->post('type_strategie_face_probleme'),
			'type_engagement_activite'     => $this->post('type_engagement_activite'),
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
				// Ajout d'un enregistrement
                $dataId = $this->QuestionnairemenageManager->add($data);              
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
				// Mise à jour d'un enregistrement
                $update = $this->QuestionnairemenageManager->update($id, $data);              
                if(!is_null($update)){
                    $this->response([
                        'status' => TRUE, 
                        'response' => 1,
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
			// Suppression d'un enregistrement
            $delete = $this->QuestionnairemenageManager->delete($id);          
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
?>