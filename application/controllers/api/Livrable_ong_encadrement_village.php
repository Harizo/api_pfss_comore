<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Livrable_ong_encadrement_village extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('livrable_ong_encadrement_village_model', 'Livrable_ong_encadrement_villageManager');
        $this->load->model('village_model', 'VillageManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $id_commune = $this->get('id_commune');
        $id_livrable_ong_encadrement = $this->get('id_livrable_ong_encadrement');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="get_repartition_villageBylivrable") {
			// Selection par id
			$tmp = $this->Livrable_ong_encadrement_villageManager->get_repartition_villageBylivrable($id_livrable_ong_encadrement);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $village = $this->VillageManager->findById($value->id_village);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_livrable_ong_encadrement']  = $value->id_livrable_ong_encadrement;
                    $data[$key]['village']  = $village;
                }
                //$data=$tmp;
			}
		} elseif ($id) {
			// Selection par id
			$temporaire = $this->Livrable_ong_encadrement_villageManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Livrable_ong_encadrement_villageManager->findAll();
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
			'id_livrable_ong_encadrement' => $this->post('id_livrable_ong_encadrement')
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
                $dataId = $this->Livrable_ong_encadrement_villageManager->add($data);              
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
                $update = $this->Livrable_ong_encadrement_villageManager->update($id, $data);              
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
            $delete = $this->Livrable_ong_encadrement_villageManager->delete($id);          
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