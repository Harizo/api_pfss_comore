<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Communaute extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('communaute_model', 'CommunauteManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('zip_model', 'ZipManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        if ($menu=="getcommunautepreselection") {
               
            $communaute = $this->CommunauteManager->getcommunautepreselection();
                if ($communaute) {
                    //$data = $communaute;
                    foreach ($communaute as $key => $value)
                    {
                        $commune = $this->CommuneManager->findById_row($value->id_commune);
                        $zip = $this->ZipManager->findById($value->id_zip);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['nbr_personne'] = $value->nbr_personne;
                        $data[$key]['representant'] = $value->representant;
                        $data[$key]['telephone'] = $value->telephone;
                        $data[$key]['statut'] = $value->statut;
                        $data[$key]['zip'] = $zip;
                        $data[$key]['commune'] = $commune;
                        
                    };

                } else
                    $data = array();
            
        } elseif ($menu=="getcommunauteinscrit") {
               
            $communaute = $this->CommunauteManager->getcommunauteinscrit();
                if ($communaute) {
                    //$data = $communaute;
                    foreach ($communaute as $key => $value)
                    {
                        $commune = $this->CommuneManager->findById_row($value->id_commune);
                        $zip = $this->ZipManager->findById($value->id_zip);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['nbr_personne'] = $value->nbr_personne;
                        $data[$key]['representant'] = $value->representant;
                        $data[$key]['telephone'] = $value->telephone;
                        $data[$key]['statut'] = $value->statut;
                        $data[$key]['zip'] = $zip;
                        $data[$key]['commune'] = $commune;
                        
                    };

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->CommunauteManager->findById($id);
                /*$data['id'] = $communaute->id;
                $data['code'] = $communaute->code;
                $data['libelle'] = $communaute->libelle;*/
                
            } else {
                $communaute = $this->CommunauteManager->findAll();
                if ($communaute) {
                    foreach ($communaute as $key => $value)
                    {
                        $commune = $this->CommuneManager->findById($value->id_commune);
                        $zip = $this->ZipManager->findById($value->id_zip);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['nbr_personne'] = $value->nbr_personne;
                        $data[$key]['representant'] = $value->representant;
                        $data[$key]['telephone'] = $value->telephone;
                        $data[$key]['statut'] = $value->statut;
                        $data[$key]['zip'] = $zip;
                        $data[$key]['commune'] = $commune;
                        
                    };

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
        $maj_statu = $this->post('maj_statu') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'nbr_personne' => $this->post('nbr_personne'),
                    'representant' => $this->post('representant'),
                    'telephone' => $this->post('telephone'),
                    'statut' => $this->post('statut'),
                    'id_zip' => $this->post('id_zip'),
                    'id_commune' => $this->post('id_commune')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->CommunauteManager->add($data);              
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
                if ($maj_statu==0)
                {   
                    $data = array(
                        'code' => $this->post('code'),
                        'libelle' => $this->post('libelle'),
                        'nbr_personne' => $this->post('nbr_personne'),
                        'representant' => $this->post('representant'),
                        'telephone' => $this->post('telephone'),
                        'statut' => $this->post('statut'),
                        'id_zip' => $this->post('id_zip'),
                        'id_commune' => $this->post('id_commune')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->CommunauteManager->update( $id,$data);              
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
                        'statut' => $this->post('statut')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->CommunauteManager->update_statu($id, $data);              
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
            $delete = $this->CommunauteManager->delete($id);          
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