<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Sauvegarde_env extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sauvegarde_env_model', 'Sauvegarde_envManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        if ($menu=="getsauvegarde_envbysousprojet") {
               
            $sauvegarde_env = $this->Sauvegarde_envManager->getsauvegarde_envbysousprojet($id_sous_projet);
                if ($sauvegarde_env) {
                    $data = $sauvegarde_env;
                    /*foreach ($sauvegarde_env as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Sauvegarde_envManager->findById($id);
                /*$data['id'] = $sauvegarde_env->id;
                $data['code'] = $sauvegarde_env->code;
                $data['description'] = $sauvegarde_env->description;*/
                
            } else 
            {
               /* $sauvegarde_env = $this->Sauvegarde_envManager->findAll();
                if ($sauvegarde_env) {
                    $data = $sauvegarde_env;

                } else*/
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
                    'info_evaluation_pre' => $this->post('info_evaluation_pre'),
                    'checklist_evaluation_pre' => $this->post('checklist_evaluation_pre'),
                    'resultats' => $this->post('resultats'),
                    'methodologie' => $this->post('methodologie'),
                    'mesures_environnement' => $this->post('mesures_environnement'),
                    'id_sous_projet' => $this->post('id_sous_projet')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sauvegarde_envManager->add($data);              
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
                        'info_evaluation_pre' => $this->post('info_evaluation_pre'),
                        'checklist_evaluation_pre' => $this->post('checklist_evaluation_pre'),
                        'resultats' => $this->post('resultats'),
                        'methodologie' => $this->post('methodologie'),
                        'mesures_environnement' => $this->post('mesures_environnement'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Sauvegarde_envManager->add_down($data, $id);              
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
                        'info_evaluation_pre' => $this->post('info_evaluation_pre'),
                        'checklist_evaluation_pre' => $this->post('checklist_evaluation_pre'),
                        'resultats' => $this->post('resultats'),
                        'methodologie' => $this->post('methodologie'),
                        'mesures_environnement' => $this->post('mesures_environnement'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Sauvegarde_envManager->update($id, $data);              
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
            $delete = $this->Sauvegarde_envManager->delete($id);          
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