<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pges_phases extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pges_phases_model', 'Pges_phasesManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_pges = $this->get('id_pges');
        if ($menu=="getphasesbypges") {
               
            $pges_phases = $this->Pges_phasesManager->getphasesbypges($id_pges);
                if ($pges_phases) {
                    $data = $pges_phases;
                    /*foreach ($pges_phases as $key => $value)
                    {
                        $ile = $this->IleManager->findById($value->calendrier_execution);
                        $region = $this->RegionManager->findById($value->cout_estimatif);
                        $commune = $this->CommuneManager->findById($value->id_commune);

                        $data[$key]['id'] = $value->id;
                        $data[$key]['impacts'] = $value-> impacts;      
                        $data[$key]['mesures'] = $value-> mesures;      
                        $data[$key]['responsable'] = $value-> responsable;
                        $data[$key]['id_pges'] = $value->id_pges;                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Pges_phasesManager->findById($id);
                /*$data['id'] = $pges_phases->id;
                $data['code'] = $pges_phases->code;
                $data['description'] = $pges_phases->description;*/
                
            } else 
            {
               /* $pges_phases = $this->Pges_phasesManager->findAll();
                if ($pges_phases) {
                    $data = $pges_phases;

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
                    //'description'=> $this->post( 'description'), 
                    'impacts'=> $this->post( 'impacts'),      
                    'mesures'=> $this->post( 'mesures'),      
                    'responsable'=> $this->post( 'responsable'),
                    'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                    'cout_estimatif'=> $this->post( 'cout_estimatif'), 
                    'id_pges' => $this->post('id_pges'), 
                    'phase' => $this->post('phase')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pges_phasesManager->add($data);              
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
                        //'description'=> $this->post( 'description'),
                        'impacts'=> $this->post( 'impacts'),      
                        'mesures'=> $this->post( 'mesures'),      
                        'responsable'=> $this->post( 'responsable'),
                        'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                        'cout_estimatif'=> $this->post( 'cout_estimatif'), 
                        'id_pges' => $this->post('id_pges'), 
                        'phase' => $this->post('phase')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Pges_phasesManager->add_down($data, $id);              
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
                        //'description'=> $this->post( 'description'),
                        'impacts'=> $this->post( 'impacts'),      
                        'mesures'=> $this->post( 'mesures'),      
                        'responsable'=> $this->post( 'responsable'),
                        'calendrier_execution'=> $this->post( 'calendrier_execution'),      
                        'cout_estimatif'=> $this->post( 'cout_estimatif'),
                        'id_pges' => $this->post('id_pges'), 
                        'phase' => $this->post('phase')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Pges_phasesManager->update($id, $data);              
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
            $delete = $this->Pges_phasesManager->delete($id);          
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