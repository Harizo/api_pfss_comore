<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_idb extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_idb_model', 'Convention_idbManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet_localisation = $this->get('id_sous_projet_localisation');
        if ($menu=="getconvention_idbbysousprojet_localisation") {
               
            $convention_idb = $this->Convention_idbManager->getconvention_idbbysousprojet_localisation($id_sous_projet_localisation);
                if ($convention_idb) {
                    $data = $convention_idb;
                    /*foreach ($convention_idb as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Convention_idbManager->findById($id);
                /*$data['id'] = $convention_idb->id;
                $data['code'] = $convention_idb->code;
                $data['description'] = $convention_idb->description;*/
                
            } else 
            {
               /* $convention_idb = $this->Convention_idbManager->findAll();
                if ($convention_idb) {
                    $data = $convention_idb;

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
                    'deux_parti_concernee' => $this->post('deux_parti_concernee'),
                    'objet' => $this->post('objet'),
                    'montant_financement' => $this->post('montant_financement'),
                    'nom_signataire' => $this->post('nom_signataire'),
                    'date_signature' => $this->post('date_signature'),
                    'litige_conclusion' => $this->post('litige_conclusion'),
                    'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_idbManager->add($data);              
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
                        'deux_parti_concernee' => $this->post('deux_parti_concernee'),
                        'objet' => $this->post('objet'),
                        'montant_financement' => $this->post('montant_financement'),
                        'nom_signataire' => $this->post('nom_signataire'),
                        'date_signature' => $this->post('date_signature'),
                        'litige_conclusion' => $this->post('litige_conclusion'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Convention_idbManager->add_down($data, $id);              
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
                        'deux_parti_concernee' => $this->post('deux_parti_concernee'),
                        'objet' => $this->post('objet'),
                        'montant_financement' => $this->post('montant_financement'),
                        'nom_signataire' => $this->post('nom_signataire'),
                        'date_signature' => $this->post('date_signature'),
                        'litige_conclusion' => $this->post('litige_conclusion'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Convention_idbManager->update($id, $data);              
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
            $delete = $this->Convention_idbManager->delete($id);          
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