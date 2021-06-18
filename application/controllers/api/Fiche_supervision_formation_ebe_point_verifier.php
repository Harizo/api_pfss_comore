<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fiche_supervision_formation_ebe_point_verifier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_supervision_formation_ebe_point_verifier_model', 'Fiche_supervision_formation_ebe_point_verifierManager');
        
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_fiche_supervision = $this->get('id_fiche_supervision');
		if ($menu=='get_point_verifierbyfiche') 
        {
			$tmp = $this->Fiche_supervision_formation_ebe_point_verifierManager->get_point_verifierbyfiche($id_fiche_supervision);
			if ($tmp) 
            {   
				$data=$tmp;
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Fiche_supervision_formation_ebe_point_verifierManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Fiche_supervision_formation_ebe_point_verifierManager->findAll();
			if ($tmp) 
            {   
                
				$data=$tmp;
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

    public function index_post() 
    {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        $etat_download = $this->post('etat_download') ;

		$data = array(
			
            'id_fiche_supervision'     => $this->post('id_fiche_supervision'),
            'point_verifier'      => $this->post('point_verifier'),
            'appreciation'       => $this->post('appreciation'),
            'solution'       => $this->post('solution'),
            'observation'       => $this->post('observation')
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
                $dataId = $this->Fiche_supervision_formation_ebe_point_verifierManager->add($data);              
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
            } 
            else 
            {
                
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Fiche_supervision_formation_ebe_point_verifierManager->update($id, $data);              
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
        } 
        else 
        {
            if (!$id) 
            {
                $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
            }

            $delete = $this->Fiche_supervision_formation_ebe_point_verifierManager->delete($id);   

            if (!is_null($delete)) 
            {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            }
            else 
            {
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