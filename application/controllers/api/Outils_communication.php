<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Outils_communication extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('outils_communication_model', 'Outils_communicationManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_formation_ml = $this->get('id_formation_ml');
        if ($menu=="getoutils_communicationbyformation") {
               
            $outils_communication = $this->Outils_communicationManager->getoutils_communicationbyformation($id_formation_ml);
                if ($outils_communication) {
                    //$data = $outils_communication;
                    foreach ($outils_communication as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['outils_communication'] = unserialize($value->outils_communication);
                        $data[$key]['id_formation_ml'] = $value->id_formation_ml;
                        
                    };

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Outils_communicationManager->findById($id);
                /*$data['id'] = $outils_communication->id;
                $data['outils_communication'] = $outils_communication->outils_communication;
                $data['libelle'] = $outils_communication->libelle;*/
                
            } else {
                $outils_communication = $this->Outils_communicationManager->findAll();
                if ($outils_communication) {
                    $data = $outils_communication;
                    /*foreach ($outils_communication as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['outils_communication'] = $value->outils_communication;
                        $data[$key]['libelle'] = $value->libelle;
                        
                    };*/

                } else
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
        $etat_download = $this->post('etat_download') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'outils_communication' => serialize($this->post('outils_communication')),
                    'id_formation_ml' => $this->post('id_formation_ml')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Outils_communicationManager->add($data);              
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
                if ($etat_download)
                {   
                    $data = array(
                        'outils_communication' => serialize($this->post('outils_communication')),
                        'id_formation_ml' => $this->post('id_formation_ml')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Outils_communicationManager->add_down($data, $id);              
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
                    $data = array(
                        'outils_communication' => serialize($this->post('outils_communication')),
                        'id_formation_ml' => $this->post('id_formation_ml')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Outils_communicationManager->update($id, $data);              
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
        } else {
            if (!$id) {
            $this->response([
            'status' => FALSE,
            'response' => 0,
            'message' => 'No request found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Outils_communicationManager->delete($id);          
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
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */