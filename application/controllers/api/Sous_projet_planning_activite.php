<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet_planning_activite extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_planning_activite_model', 'Sous_projet_planning_activiteManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_planning = $this->get('id_planning');
        if ($menu=="getplanning_activitebyplanning") {
               
            $sous_projet_planning_activite = $this->Sous_projet_planning_activiteManager->getplanning_activitebyplanning($id_planning);
                if ($sous_projet_planning_activite) {
                    $data = $sous_projet_planning_activite;
                    /*foreach ($sous_projet_planning_activite as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['semaine'] = $value->semaine;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Sous_projet_planning_activiteManager->findById($id);
                /*$data['id'] = $sous_projet_planning_activite->id;
                $data['semaine'] = $sous_projet_planning_activite->semaine;
                $data['description'] = $sous_projet_planning_activite->description;*/
                
            } else 
            {
               /* $sous_projet_planning_activite = $this->Sous_projet_planning_activiteManager->findAll();
                if ($sous_projet_planning_activite) {
                    $data = $sous_projet_planning_activite;

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
                    'semaine' => $this->post('semaine'),
                    'description' => $this->post('description'),
                    'id_planning' => $this->post('id_planning')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sous_projet_planning_activiteManager->add($data);              
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
                        'semaine' => $this->post('semaine'),
                        'description' => $this->post('description'),
                        'id_planning' => $this->post('id_planning')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Sous_projet_planning_activiteManager->add_down($data, $id);              
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
                        'semaine' => $this->post('semaine'),
                        'description' => $this->post('description'),
                        'id_planning' => $this->post('id_planning')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Sous_projet_planning_activiteManager->update($id, $data);              
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
            $delete = $this->Sous_projet_planning_activiteManager->delete($id);          
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