<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Plan_gestion_env extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('plan_gestion_env_model', 'Plan_gestion_envManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_fiche_env = $this->get('id_fiche_env');
        if ($menu=="getplan_gestion_envbyfiche") {
               
            $plan_gestion_env = $this->Plan_gestion_envManager->getplan_gestion_envbyfiche($id_fiche_env);
                if ($plan_gestion_env) {
                    $data = $plan_gestion_env;
                    /*foreach ($plan_gestion_env as $key => $value)
                    {
                        $ile = $this->IleManager->findById($value->calendrier_execution);
                        $region = $this->RegionManager->findById($value->cout_estimatif);
                        $commune = $this->CommuneManager->findById($value->id_commune);

                        $data[$key]['id'] = $value->id;
                        $data[$key]['impacts'] = $value-> impacts;      
                        $data[$key]['mesures'] = $value-> mesures;      
                        $data[$key]['responsable'] = $value-> responsable;
                        $data[$key]['id_fiche_env'] = $value->id_fiche_env;                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Plan_gestion_envManager->findById($id);
                /*$data['id'] = $plan_gestion_env->id;
                $data['code'] = $plan_gestion_env->code;
                $data['description'] = $plan_gestion_env->description;*/
                
            } else 
            {
               /* $plan_gestion_env = $this->Plan_gestion_envManager->findAll();
                if ($plan_gestion_env) {
                    $data = $plan_gestion_env;

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
                    'impacts'=> $this->post( 'impacts'),      
                    'mesures'=> $this->post( 'mesures'),      
                    'responsable'=> $this->post( 'responsable'),
                    'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                    'cout_estimatif'=> $this->post( 'cout_estimatif'), 
                    'id_fiche_env' => $this->post('id_fiche_env')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Plan_gestion_envManager->add($data);              
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
                        'impacts'=> $this->post( 'impacts'),      
                        'mesures'=> $this->post( 'mesures'),      
                        'responsable'=> $this->post( 'responsable'),
                        'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                        'cout_estimatif'=> $this->post( 'cout_estimatif'), 
                        'id_fiche_env' => $this->post('id_fiche_env')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Plan_gestion_envManager->add_down($data, $id);              
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
                        'impacts'=> $this->post( 'impacts'),      
                        'mesures'=> $this->post( 'mesures'),      
                        'responsable'=> $this->post( 'responsable'),
                        'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                        'cout_estimatif'=> $this->post( 'cout_estimatif'),
                        'id_fiche_env' => $this->post('id_fiche_env')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Plan_gestion_envManager->update($id, $data);              
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
            $delete = $this->Plan_gestion_envManager->delete($id);          
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