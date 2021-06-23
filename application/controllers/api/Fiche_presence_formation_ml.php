<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fiche_presence_formation_ml extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_presence_formation_ml_model', 'Fiche_presence_formation_mlManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('groupe_mlpl_model', 'Groupe_mlplManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_formation_ml = $this->get('id_formation_ml');
        $id_village = $this->get('id_village');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="getgroupe_mlplByvillage") {
			// Selection par id
			$tmp = $this->Groupe_mlplManager->findAllByVillage($id_village);
			if($tmp)
            {				
                $data=$tmp;
			}
		} elseif ($menu=="getprensenceByformation") {
			// Selection par id
			$tmp = $this->Fiche_presence_formation_mlManager->findById_formation_ml($id_formation_ml);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $groupe_ml_pl = $this->Groupe_mlplManager->findByIdandmenage($value->id_groupe_ml_pl);
                    $village = $this->VillageManager->findById($value->id_village);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_formation_ml']  = $value->id_formation_ml;
                    $data[$key]['groupe_ml_pl'] = $groupe_ml_pl;
                    $data[$key]['village'] = $village;
                }
                //$data=$tmp;
			}
		} elseif ($id) {
			// Selection par id
			$temporaire = $this->Fiche_presence_formation_mlManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Fiche_presence_formation_mlManager->findAll();
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
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			'id_groupe_ml_pl' => $this->post('id_groupe_ml_pl'),
			'id_village' => $this->post('id_village'),
			'id_formation_ml' => $this->post('id_formation_ml')
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
				// Ajout d'un enregitrement
                $dataId = $this->Fiche_presence_formation_mlManager->add($data);              
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
                $update = $this->Fiche_presence_formation_mlManager->update($id, $data);              
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
			// Suppression d'un enregitrement
            $delete = $this->Fiche_presence_formation_mlManager->delete($id);          
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