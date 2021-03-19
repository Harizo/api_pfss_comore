<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tableau_mesure_pges extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tableau_mesure_pges_model', 'Tableau_mesure_pgesManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_etude_env = $this->get('id_etude_env');
        if ($menu=="gettableau_mesure_pgesbyetude") {
               
            $tableau_mesure_pges = $this->Tableau_mesure_pgesManager->gettableau_mesure_pgesbyetude($id_etude_env);
                if ($tableau_mesure_pges) {
                    $data = $tableau_mesure_pges;
                    /*foreach ($tableau_mesure_pges as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Tableau_mesure_pgesManager->findById($id);
                /*$data['id'] = $tableau_mesure_pges->id;
                $data['code'] = $tableau_mesure_pges->code;
                $data['description'] = $tableau_mesure_pges->description;*/
                
            } else 
            {
               /* $tableau_mesure_pges = $this->Tableau_mesure_pgesManager->findAll();
                if ($tableau_mesure_pges) {
                    $data = $tableau_mesure_pges;

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
                    'activites_sousprojets' => $this->post('activites_sousprojets'),
                    'mesure' => $this->post('mesure'),
                    'responsables' => $this->post('responsables'),
                    'estimation_cout' => $this->post('estimation_cout'),
                    'impacts' => $this->post('impacts'),
                    'timing' => $this->post('timing'),
                    'id_etude_env' => $this->post('id_etude_env')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Tableau_mesure_pgesManager->add($data);              
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
                        'activites_sousprojets' => $this->post('activites_sousprojets'),
                        'mesure' => $this->post('mesure'),
                        'responsables' => $this->post('responsables'),
                        'estimation_cout' => $this->post('estimation_cout'),
                        'impacts' => $this->post('impacts'),
                        'timing' => $this->post('timing'),
                        'id_etude_env' => $this->post('id_etude_env')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Tableau_mesure_pgesManager->add_down($data, $id);              
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
                        'activites_sousprojets' => $this->post('activites_sousprojets'),
                        'mesure' => $this->post('mesure'),
                        'responsables' => $this->post('responsables'),
                        'estimation_cout' => $this->post('estimation_cout'),
                        'impacts' => $this->post('impacts'),
                        'timing' => $this->post('timing'),
                        'id_etude_env' => $this->post('id_etude_env')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Tableau_mesure_pgesManager->update($id, $data);              
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
            $delete = $this->Tableau_mesure_pgesManager->delete($id);          
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