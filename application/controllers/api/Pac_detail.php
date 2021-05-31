<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pac_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pac_detail_model', 'Pac_detailManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $id_pac = $this->get('id_pac');
        $menu = $this->get('menu');
        if ($menu=="getpac_detailbypac")
        {
            $pac_detail = $this->Pac_detailManager->getpac_detailbypac($id_pac );
                if ($pac_detail)
                {
                    $data = $pac_detail;

                } else
                    $data = array();
            
        } 
        elseif ($id) 
        {
               
                $data = $this->Pac_detailManager->findById($id);
                /*$data['id'] = $pac_detail->id;
                $data['code'] = $pac_detail->code;
                $data['description'] = $pac_detail->description;*/
                
            } 
            else 
            {
               $pac_detail = $this->Pac_detailManager->findAll();
                if ($pac_detail)
                {
                    $data = $pac_detail;

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
                    'numero'       => $this->post('numero'),
                    'besoin'       => $this->post('besoin'),
                    'cout'  => $this->post('cout'),
                    'duree'  => $this->post('duree'),      
                    'id_pac'    => $this->post('id_pac'),      
                    'calendrier_activite'    => $this->post('calendrier_activite')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pac_detailManager->add($data);              
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
                        'numero'       => $this->post('numero'),
                        'besoin'       => $this->post('besoin'),
                        'cout'  => $this->post('cout'),
                        'duree'  => $this->post('duree'),      
                        'id_pac'    => $this->post('id_pac'),      
                        'calendrier_activite'    => $this->post('calendrier_activite')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Pac_detailManager->add_down($data, $id);              
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
                        'numero'       => $this->post('numero'),
                        'besoin'       => $this->post('besoin'),
                        'cout'  => $this->post('cout'),
                        'duree'  => $this->post('duree'),      
                        'id_pac'    => $this->post('id_pac'),      
                        'calendrier_activite'    => $this->post('calendrier_activite')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Pac_detailManager->update($id, $data);              
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
            $delete = $this->Pac_detailManager->delete($id);          
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