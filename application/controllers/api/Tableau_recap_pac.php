<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tableau_recap_pac extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tableau_recap_pac_model', 'Tableau_recap_pacManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $id_pac = $this->get('id_pac');
        $menu = $this->get('menu');
        if ($menu=="gettableau_recap_pacbypac")
        {
            $tableau_recap_pac = $this->Tableau_recap_pacManager->gettableau_recap_pacbypac($id_pac );
                if ($tableau_recap_pac)
                {
                    $data = $tableau_recap_pac;

                } else
                    $data = array();
            
        } 
        elseif ($id) 
        {
               
                $data = $this->Tableau_recap_pacManager->findById($id);
                /*$data['id'] = $tableau_recap_pac->id;
                $data['code'] = $tableau_recap_pac->code;
                $data['description'] = $tableau_recap_pac->description;*/
                
            } 
            else 
            {
               $tableau_recap_pac = $this->Tableau_recap_pacManager->findAll();
                if ($tableau_recap_pac)
                {
                    $data = $tableau_recap_pac;

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
                    'besoin'       => $this->post('besoin'),
                    'cout'  => $this->post('cout'),
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
                $dataId = $this->Tableau_recap_pacManager->add($data);              
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
                        'besoin'       => $this->post('besoin'),
                        'cout'  => $this->post('cout'),
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
                    $dataId = $this->Tableau_recap_pacManager->add_down($data, $id);              
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
                        'besoin'       => $this->post('besoin'),
                        'cout'  => $this->post('cout'),
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
                    $update = $this->Tableau_recap_pacManager->update($id, $data);              
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
            $delete = $this->Tableau_recap_pacManager->delete($id);          
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