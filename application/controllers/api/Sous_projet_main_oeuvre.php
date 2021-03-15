<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet_main_oeuvre extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_main_oeuvre_model', 'Sous_projet_main_oeuvreManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        if ($menu=="getsous_projet_main_oeuvrebysousprojet") {
               
            $sous_projet_main_oeuvre = $this->Sous_projet_main_oeuvreManager->getsous_projet_main_oeuvrebysousprojet($id_sous_projet);
                if ($sous_projet_main_oeuvre) {
                    $data = $sous_projet_main_oeuvre;
                    /*foreach ($sous_projet_main_oeuvre as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Sous_projet_main_oeuvreManager->findById($id);
                /*$data['id'] = $sous_projet_main_oeuvre->id;
                $data['code'] = $sous_projet_main_oeuvre->code;
                $data['description'] = $sous_projet_main_oeuvre->description;*/
                
            } else 
            {
               /* $sous_projet_main_oeuvre = $this->Sous_projet_main_oeuvreManager->findAll();
                if ($sous_projet_main_oeuvre) {
                    $data = $sous_projet_main_oeuvre;

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
                    'activite' => $this->post('activite'),
                        'main_oeuvre' => $this->post('main_oeuvre'),
                        'post_travail' => $this->post('post_travail'),
                        'remuneration_jour' => $this->post('remuneration_jour'),                        
                        'nbr_jour' => $this->post('nbr_jour'),
                        'remuneration_total' => $this->post('remuneration_total'),
                    'id_sous_projet' => $this->post('id_sous_projet')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sous_projet_main_oeuvreManager->add($data);              
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
                        'activite' => $this->post('activite'),
                        'main_oeuvre' => $this->post('main_oeuvre'),
                        'post_travail' => $this->post('post_travail'),
                        'remuneration_jour' => $this->post('remuneration_jour'),                        
                        'nbr_jour' => $this->post('nbr_jour'),
                        'remuneration_total' => $this->post('remuneration_total'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Sous_projet_main_oeuvreManager->add_down($data, $id);              
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
                        'activite' => $this->post('activite'),
                        'main_oeuvre' => $this->post('main_oeuvre'),
                        'post_travail' => $this->post('post_travail'),
                        'remuneration_jour' => $this->post('remuneration_jour'),                        
                        'nbr_jour' => $this->post('nbr_jour'),
                        'remuneration_total' => $this->post('remuneration_total'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Sous_projet_main_oeuvreManager->update($id, $data);              
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
            $delete = $this->Sous_projet_main_oeuvreManager->delete($id);          
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