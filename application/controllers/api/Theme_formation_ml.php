<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Theme_formation_ml extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('theme_formation_ml_model', 'Theme_formation_mlManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_formation_ml = $this->get('id_formation_ml');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="theme_sensibilisation") {
			// Selection par id
			$tmp = $this->Theme_formation_mlManager->findAlltheme_sensibilisation();
			if($tmp)
            {
                $data=$tmp;
			}
		} elseif ($cle_etrangere) {
			// Selection par id
			$tmp = $this->Theme_formation_mlManager->findById_formation_ml($cle_etrangere);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $theme_sensibilisation = $this->Theme_formation_mlManager->findTheme_sensibilisationById($value->id_theme_sensibilisation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['numero']     = $value->numero;
                    $data[$key]['date_formation']  = $value->date_formation;
                    $data[$key]['id_formation_ml']  = $value->id_formation_ml;
                    $data[$key]['theme_sensibilisation'] = $theme_sensibilisation;
                    $data[$key]['ok']  = $cle_etrangere;
                }
                //$data=$tmp;
			}
		} elseif ($id) {
			// Selection par id
			$temporaire = $this->Theme_formation_mlManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Theme_formation_mlManager->findAll();
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
			'id_theme_sensibilisation' => $this->post('id_theme_sensibilisation'),
			'numero' => $this->post('numero'),
			'date_formation' => $this->post('date_formation'),
			'id_formation_ml' => $this->post('id_formation_ml'),
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
                $dataId = $this->Theme_formation_mlManager->add($data);              
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
                $update = $this->Theme_formation_mlManager->update($id, $data);              
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
            $delete = $this->Theme_formation_mlManager->delete($id);          
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