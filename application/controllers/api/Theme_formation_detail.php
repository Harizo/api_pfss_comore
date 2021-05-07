<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Theme_formation_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('theme_formation_detail_model', 'ThemeformationdetailManager');
    }
    public function index_get() {
        $id = $this->get('id');
		$data = array();
		$cle_etrangere=$this->get('cle_etrangere');
        if ($cle_etrangere) {
			$data = $this->ThemeformationdetailManager->findByIdParent($cle_etrangere);
		} else if ($id) {
			// Selection par id
            $data = $this->ThemeformationdetailManager->findById($id);
        } else {
			// Selection de tous les enregitrements de la table
			$data = $this->ThemeformationdetailManager->findAll();	
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
			'id'                 => $this->post('id'),
			'id_theme_formation' => $this->post('id_theme_formation'),
			'description'        => $this->post('description'),
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
                $dataId = $this->ThemeformationdetailManager->add($data);
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
				// Mise à jour d'un enregitrement
                $update = $this->ThemeformationdetailManager->update($id, $data);
                if(!is_null($update)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                } else  {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
        } else  {
            if (!$id) {
            $this->response([
                'status' => TRUE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
            }
			// Suppression d'un enregitrement
            $delete = $this->ThemeformationdetailManager->delete($id);
            if (!is_null($delete)) {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => TRUE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
} 
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>