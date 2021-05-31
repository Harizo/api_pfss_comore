<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Theme_formation_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('theme_formation_ebe_model', 'Theme_formation_ebeManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_realisation_ebe = $this->get('id_realisation_ebe');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="theme_sensibilisation") {
			// Selection par id
			$tmp = $this->Theme_formation_ebeManager->findAlltheme_sensibilisation();
			if($tmp)
            {
                $data=$tmp;
			}
		} elseif ($cle_etrangere) {
			// Selection par id
			$tmp = $this->Theme_formation_ebeManager->findById_realisation_ebe($cle_etrangere);
			if($tmp)
            {
				/*foreach ($tmp as $key => $value)
                {   
                    $data[$key]['id']         = $value->id;
                    $data[$key]['activite']     = $value->activite;
                    $data[$key]['id_realisation_ebe']  = $value->id_realisation_ebe;
                    $data[$key]['theme_sensibilisation'] = $value->$theme_sensibilisation;
                }*/
                $data=$tmp;
			}
		} elseif ($id) {
			// Selection par id
			$temporaire = $this->Theme_formation_ebeManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Theme_formation_ebeManager->findAll();
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
			'theme_sensibilisation' => $this->post('theme_sensibilisation'),
			'activite' => $this->post('activite'),
			'id_realisation_ebe' => $this->post('id_realisation_ebe'),
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
                $dataId = $this->Theme_formation_ebeManager->add($data);              
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
                $update = $this->Theme_formation_ebeManager->update($id, $data);              
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
            $delete = $this->Theme_formation_ebeManager->delete($id);          
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