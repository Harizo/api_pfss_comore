<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_travaux_model', 'Sous_projet_travauxManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet_localisation = $this->get('id_sous_projet_localisation');
        if ($menu=="getsous_projet_travauxbysousprojet_localisation") {
               
            $sous_projet_travaux = $this->Sous_projet_travauxManager->getsous_projet_travauxbysousprojet_localisation($id_sous_projet_localisation);
                if ($sous_projet_travaux) {
                    $data = $sous_projet_travaux;
                    /*foreach ($sous_projet_travaux as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['activites'] = $value->activites;
                        $data[$key]['unite'] = $value->unite;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Sous_projet_travauxManager->findById($id);
                /*$data['id'] = $sous_projet_travaux->id;
                $data['activites'] = $sous_projet_travaux->activites;
                $data['unite'] = $sous_projet_travaux->unite;*/
                
            } else 
            {
               /* $sous_projet_travaux = $this->Sous_projet_travauxManager->findAll();
                if ($sous_projet_travaux) {
                    $data = $sous_projet_travaux;

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
                    'activites' => $this->post('activites'),
                    'unite' => $this->post('unite'),
                    'quantite' => $this->post('quantite'),
                    'observation' => $this->post('observation'),
                    'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sous_projet_travauxManager->add($data);              
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
                        'activites' => $this->post('activites'),
                        'unite' => $this->post('unite'),
                        'quantite' => $this->post('quantite'),
                        'observation' => $this->post('observation'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Sous_projet_travauxManager->add_down($data, $id);              
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
                        'activites' => $this->post('activites'),
                        'unite' => $this->post('unite'),
                        'quantite' => $this->post('quantite'),
                        'observation' => $this->post('observation'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Sous_projet_travauxManager->update($id, $data);              
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
            $delete = $this->Sous_projet_travauxManager->delete($id);          
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