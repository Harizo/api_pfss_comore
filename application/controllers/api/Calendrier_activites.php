<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Calendrier_activites extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('calendrier_activites_model', 'Calendrier_activitesManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $id_pac = $this->get('id_pac');
        $menu = $this->get('menu');
        if ($menu=="getcalendrier_activitesbypac")
        {
            $calendrier_activites = $this->Calendrier_activitesManager->getcalendrier_activitesbypac($id_pac );
                if ($calendrier_activites)
                {
                    $data = $calendrier_activites;

                } else
                    $data = array();
            
        } 
        elseif ($id) 
        {
               
                $data = $this->Calendrier_activitesManager->findById($id);
                /*$data['id'] = $calendrier_activites->id;
                $data['code'] = $calendrier_activites->code;
                $data['description'] = $calendrier_activites->description;*/
                
            } 
            else 
            {
               $calendrier_activites = $this->Calendrier_activitesManager->findAll();
                if ($calendrier_activites)
                {
                    $data = $calendrier_activites;

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
                    'mois'       => $this->post('mois'),
                    'activite'  => $this->post('activite'),
                    'duree'  => $this->post('duree'),      
                    'id_pac'    => $this->post('id_pac')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Calendrier_activitesManager->add($data);              
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
                        'mois'       => $this->post('mois'),
                        'activite'  => $this->post('activite'),
                        'duree'  => $this->post('duree'),      
                        'id_pac'    => $this->post('id_pac')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Calendrier_activitesManager->add_down($data, $id);              
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
                        'mois'       => $this->post('mois'),
                        'activite'  => $this->post('activite'),
                        'duree'  => $this->post('duree'),      
                        'id_pac'    => $this->post('id_pac')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Calendrier_activitesManager->update($id, $data);              
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
            $delete = $this->Calendrier_activitesManager->delete($id);          
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