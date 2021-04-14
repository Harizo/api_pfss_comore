<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fiche_supervision_mlpl extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_supervision_mlpl_model', 'Fichesupervision_mlplManager');
        $this->load->model('Consultant_ong_model', 'Consultant_ongManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $menu = $this->get('menu');
        $id_groupemlpl = $this->get('id_groupemlpl');
        $data = array() ;
		if($menu=="getfiche_previsionbygroupe") {
			$tmp = $this->Fichesupervision_mlplManager->getfiche_previsionbygroupe($id_groupemlpl);
            if ($tmp)
            {
                foreach ($tmp as $key => $value)
                {
                    $consultant_ong = $this->Consultant_ongManager->findById($value->id_consultant_ong);
                    $data[$key]['id']                   = $value->id;
                    $data[$key]['id_groupemlpl']        = $value->id_groupemlpl;
                    $data[$key]['consultant_ong']       = $consultant_ong;
                    $data[$key]['date_supervision']     = $value->date_supervision;
                    $data[$key]['type_supervision']     = $value->type_supervision;
                    $data[$key]['personne_rencontree']  = $value->personne_rencontree;
                    $data[$key]['organisation_consultant']      = $value->organisation_consultant;
                    $data[$key]['planning_activite_consultant'] = $value->planning_activite_consultant;
                    $data[$key]['date_prevue_debut']    = $value->date_prevue_debut;
                    $data[$key]['date_prevue_fin']      = $value->date_prevue_fin;
                    $data[$key]['nom_missionnaire']     = $value->nom_missionnaire;
                    $data[$key]['nom_representant_mlpl'] = $value->nom_representant_mlpl;
                }
            }
            else
                $data = array();
		}  elseif($id) {
			$data = $this->Fichesupervision_mlplManager->findById($id);
            if (!$data)
                $data = array();
		}  else if($cle_etrangere) {
			$data = $this->Fichesupervision_mlplManager->getfiche_previsionbygroupe($cle_etrangere);
            if (!$data)
                $data = array();
		} else {	
			$data = $this->Fichesupervision_mlplManager->findAll();
            if (!$data)
                $data = array();
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
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		// Affectation des valeurs des colonnes de la table
		$data = array(
			'id_groupemlpl' => $this->post('id_groupemlpl'),
			'id_consultant_ong' => $this->post('id_consultant_ong'),
			'date_supervision'  => $this->post('date_supervision'),
			'type_supervision'    => $this->post('type_supervision'),
			'personne_rencontree'    => $this->post('personne_rencontree'),
			'organisation_consultant'    => $this->post('organisation_consultant'),
			'planning_activite_consultant'    => $this->post('planning_activite_consultant'),
			'date_prevue_debut'    => $this->post('date_prevue_debut'),
			'date_prevue_fin'    => $this->post('date_prevue_fin'),
			'nom_missionnaire'    => $this->post('nom_missionnaire'),
			'nom_representant_mlpl'    => $this->post('nom_representant_mlpl')
		);               
         if ($supprimer == 0)  {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->Fichesupervision_mlplManager->add($data);
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
				// Mise � jour d'un enregistrement
                $update = $this->Fichesupervision_mlplManager->update($id, $data);              
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
			// Suppression d'un enregistrement
            $delete = $this->Fichesupervision_mlplManager->delete($id);          
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