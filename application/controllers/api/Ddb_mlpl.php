<?php

/*Les CRUD des tables : raison_visite_domicile,resolution_visite_domicile,theme_sensibilisation,
projet_groupe,probleme_rencontres,resolution_ml_pl
 sont gérer par cette controller et sont model*/

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Ddb_mlpl extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ddb_mlpl_model', 'DdbmlplManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $nom_table = $this->get('nom_table');	
		$data = array();
		if ($id) {
			$tmp = $this->DdbmlplManager->findById($nom_table);
			if($tmp) {
				$data=$tmp;
			}
		} else {			
			$tmp = $this->DdbmlplManager->findAll($nom_table);
			if ($tmp) {
				$data=$tmp;
			}
		}
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } 
        else {
            $this->response([
                'status' => TRUE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
        $nom_table = $this->post('nom_table') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			'description' => $this->post('description'),
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
                $dataId = $this->DdbmlplManager->add($data,$nom_table);  
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
                $update = $this->DdbmlplManager->update($id, $data,$nom_table); 
                if(!is_null($update)) {
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
            $delete = $this->DdbmlplManager->delete($id,$nom_table);  
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