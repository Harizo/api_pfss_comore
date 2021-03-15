<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet_materiels extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_materiels_model', 'Sous_projet_materielsManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        if ($menu=="getsous_projet_materielsbysousprojet") {
               
            $sous_projet_materiels = $this->Sous_projet_materielsManager->getsous_projet_materielsbysousprojet($id_sous_projet);
                if ($sous_projet_materiels) {
                    $data = $sous_projet_materiels;
                    /*foreach ($sous_projet_materiels as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['designation'] = $value->designation;
                        $data[$key]['unite'] = $value->unite;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Sous_projet_materielsManager->findById($id);
                /*$data['id'] = $sous_projet_materiels->id;
                $data['designation'] = $sous_projet_materiels->designation;
                $data['unite'] = $sous_projet_materiels->unite;*/
                
            } else 
            {
               /* $sous_projet_materiels = $this->Sous_projet_materielsManager->findAll();
                if ($sous_projet_materiels) {
                    $data = $sous_projet_materiels;

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
                    'designation' => $this->post('designation'),
                    'unite' => $this->post('unite'),
                    'quantite' => $this->post('quantite'),
                    'prix_unitaire' => $this->post('prix_unitaire'),
                    'prix_total' => $this->post('prix_total'),
                    'id_sous_projet' => $this->post('id_sous_projet')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sous_projet_materielsManager->add($data);              
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
                        'designation' => $this->post('designation'),
                        'unite' => $this->post('unite'),
                        'quantite' => $this->post('quantite'),
                        'prix_unitaire' => $this->post('prix_unitaire'),
                        'prix_total' => $this->post('prix_total'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Sous_projet_materielsManager->add_down($data, $id);              
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
                        'designation' => $this->post('designation'),
                        'unite' => $this->post('unite'),
                        'quantite' => $this->post('quantite'),
                        'prix_unitaire' => $this->post('prix_unitaire'),
                        'prix_total' => $this->post('prix_total'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Sous_projet_materielsManager->update($id, $data);              
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
            $delete = $this->Sous_projet_materielsManager->delete($id);          
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