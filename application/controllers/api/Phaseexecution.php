<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Phaseexecution extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('phaseexecution_model', 'PhaseexecutionManager');
        $this->load->model('sous_projet_model', 'Sous_projetManager');
    }

    public function index_get() {
        $id = $this->get('id');
        if ($id) {
               
                $data = $this->PhaseexecutionManager->findById($id);
                /*$data['id'] = $phaseexecution->id;
                $data['code'] = $phaseexecution->code;
                $data['description'] = $phaseexecution->description;*/
                
            } else 
            {
               $phaseexecution = $this->PhaseexecutionManager->findAll();
                if ($phaseexecution)
                {   
                    foreach ($phaseexecution as $key => $value)
                    {
                        $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                        $data[$key]['id']=$value->id;
                        $data[$key]['Code']=$value->Code;
                        $data[$key]['Phase']=$value->Phase;
                        $data[$key]['sous_projet']=$sous_projet;
                        $data[$key]['indemnite']=$value->indemnite;
                        $data[$key]['pourcentage']=$value->pourcentage;
                    }
                    //$data = $phaseexecution;

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
                    'Code' => $this->post('Code'),
                    'Phase' => $this->post('Phase'),
                    'id_sous_projet' => $this->post('id_sous_projet'),
                    'indemnite' => $this->post('indemnite'),
                    'pourcentage' => $this->post('pourcentage')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->PhaseexecutionManager->add($data);              
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
                        'Code' => $this->post('Code'),
                        'Phase' => $this->post('Phase'),
                        'id_sous_projet' => $this->post('id_sous_projet'),
                        'indemnite' => $this->post('indemnite'),
                        'pourcentage' => $this->post('pourcentage')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->PhaseexecutionManager->add_down($data, $id);              
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
                        'Code' => $this->post('Code'),
                        'Phase' => $this->post('Phase'),
                        'id_sous_projet' => $this->post('id_sous_projet'),
                        'indemnite' => $this->post('indemnite'),
                        'pourcentage' => $this->post('pourcentage')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->PhaseexecutionManager->update($id, $data);              
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
            $delete = $this->PhaseexecutionManager->delete($id);          
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