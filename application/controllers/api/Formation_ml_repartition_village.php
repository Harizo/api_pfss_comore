<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Formation_ml_repartition_village extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('formation_ml_repartition_village_model', 'Formation_ml_repartition_villageManager');
        $this->load->model('village_model', 'VillageManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $id_commune = $this->get('id_commune');
        $id_formation_ml_repartition = $this->get('id_formation_ml_repartition');
        $menu = $this->get('menu');
		$data = array();
		
		if ($menu=="get_villageBycommune") {
			// Selection par id
			$tmp = $this->VillageManager->get_villageBycommuneWithnbr_ml($id_commune);
			if($tmp)
            {
                $data=$tmp;
			}
		} elseif ($menu=="get_repartition_villageByrepartition") {
			// Selection par id
			$tmp = $this->Formation_ml_repartition_villageManager->get_repartition_villageByrepartition($id_formation_ml_repartition);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $village = $this->VillageManager->get_villageByidWithnbr_ml($value->id_village);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_formation_ml_repartition']  = $value->id_formation_ml_repartition;
                    $data[$key]['village']  = $village;
                }
                //$data=$tmp;
			}
		} elseif ($id) {
			// Selection par id
			$temporaire = $this->Formation_ml_repartition_villageManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Formation_ml_repartition_villageManager->findAll();
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
			'id_village' => $this->post('id_village'),
			'id_formation_ml_repartition' => $this->post('id_formation_ml_repartition')
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
                $dataId = $this->Formation_ml_repartition_villageManager->add($data);              
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
                $update = $this->Formation_ml_repartition_villageManager->update($id, $data);              
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
            $delete = $this->Formation_ml_repartition_villageManager->delete($id);          
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