<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Infrastructure extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('infrastructure_model', 'InfrastructureManager');
        $this->load->model('type_infrastructure_model', 'Type_infrastructureManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_type_infrastructure = $this->get('id_type_infrastructure');
        $id_village = $this->get('id_village');
        if ($menu=="getinfrastructurebyvillageandchoisitype") {
               
            $infrastructure = $this->InfrastructureManager->getinfrastructurebyvillageandchoisitype($id_village);
                if ($infrastructure) {
                    $data = $infrastructure;
                    /*foreach ($infrastructure as $key => $value)
                    {
                        $type_infrastructure = $this->Type_infrastructureManager->findById($value->id_type_infrastructure);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code_numero'] = $value->code_numero;
                        $data[$key]['code_passation'] = $value->code_passation;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['statu'] = $value->statu;
                        $data[$key]['id_village'] = $value->id_village;
                        $data[$key]['type_infrastructure'] = $type_infrastructure;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($menu=="getinfrastructurebyvillageandchoisi") {
               
            $infrastructure = $this->InfrastructureManager->getinfrastructurebyvillageandchoisi($id_village);
                if ($infrastructure) {
                    //$data = $infrastructure;
                    foreach ($infrastructure as $key => $value)
                    {
                        $type_infrastructure = $this->Type_infrastructureManager->findById($value->id_type_infrastructure);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code_numero'] = $value->code_numero;
                        $data[$key]['code_passation'] = $value->code_passation;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['statu'] = $value->statu;
                        $data[$key]['id_village'] = $value->id_village;
                        $data[$key]['type_infrastructure'] = $type_infrastructure;
                        
                    };

                } else
                    $data = array();
            
        } elseif ($menu=="getinfrastructurebyvillageandeligible") {
               
            $infrastructure = $this->InfrastructureManager->getinfrastructurebyvillageandeligible($id_village);
                if ($infrastructure) {
                    //$data = $infrastructure;
                    foreach ($infrastructure as $key => $value)
                    {
                        $type_infrastructure = $this->Type_infrastructureManager->findById($value->id_type_infrastructure);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code_numero'] = $value->code_numero;
                        $data[$key]['code_passation'] = $value->code_passation;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['statu'] = $value->statu;
                        $data[$key]['id_village'] = $value->id_village;
                        $data[$key]['type_infrastructure'] = $type_infrastructure;
                        
                    };

                } else
                    $data = array();
            
        } elseif ($menu=="getinfrastructurebytype") {
               
            $infrastructure = $this->InfrastructureManager->getinfrastructurebytype($id_type_infrastructure);
                if ($infrastructure) {
                    $data = $infrastructure;
                    /*foreach ($infrastructure as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code_numero'] = $value->code_numero;
                        $data[$key]['libelle'] = $value->libelle;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->InfrastructureManager->findById($id);
                /*$data['id'] = $infrastructure->id;
                $data['code_numero'] = $infrastructure->code_numero;
                $data['libelle'] = $infrastructure->libelle;*/
                
            } else {
                $infrastructure = $this->InfrastructureManager->findAll();
                if ($infrastructure) {
                    $data = $infrastructure;
                    /*foreach ($infrastructure as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code_numero'] = $value->code_numero;
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
        if ($this->post('statu')=='ELIGIBLE')
        {
            $data = array(
                'code_numero' => $this->post('code_numero'),
                'code_passation' => null,
                'libelle' => $this->post('libelle'),
                'id_type_infrastructure' => $this->post('id_type_infrastructure'),
                'id_village' => $this->post('id_village'),
                'statu' => $this->post('statu')
            );
        }
        else
        {
            $data = array(
                'code_numero' => $this->post('code_numero'),
                'code_passation' => $this->post('code_passation'),
                'libelle' => $this->post('libelle'),
                'id_type_infrastructure' => $this->post('id_type_infrastructure'),
                'id_village' => $this->post('id_village'),
                'statu' => $this->post('statu')
            );
        }
        if ($supprimer == 0) {
            if ($id == 0) {
               /* $data = array(
                    'code_numero' => $this->post('code_numero'),
                    'libelle' => $this->post('libelle'),
                    'id_type_infrastructure' => $this->post('id_type_infrastructure'),
                    'id_village' => $this->post('id_village'),
                    'statu' => $this->post('statu')
                ); */              
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->InfrastructureManager->add($data);              
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
                    /*$data = array(
                        'code_numero' => $this->post('code_numero'),
                        'libelle' => $this->post('libelle'),
                        'id_type_infrastructure' => $this->post('id_type_infrastructure'),
                        'id_village' => $this->post('id_village'),
                        'statu' => $this->post('statu')
                    );*/
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->InfrastructureManager->add_down($data, $id);              
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
                    /*$data = array(
                        'code_numero' => $this->post('code_numero'),
                        'libelle' => $this->post('libelle'),
                        'id_type_infrastructure' => $this->post('id_type_infrastructure'),
                        'id_village' => $this->post('id_village'),
                        'statu' => $this->post('statu')
                    ); */             
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->InfrastructureManager->update($id, $data);              
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
            $delete = $this->InfrastructureManager->delete($id);          
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