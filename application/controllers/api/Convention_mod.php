<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_mod extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_mod_model', 'Convention_modManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet_localisation = $this->get('id_sous_projet_localisation');
        if ($menu=="getconvention_modbysousprojet_localisation") {
               
            $convention_mod = $this->Convention_modManager->getconvention_modbysousprojet_localisation($id_sous_projet_localisation);
                if ($convention_mod) {
                    $data = $convention_mod;
                    /*foreach ($convention_mod as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Convention_modManager->findById($id);
                /*$data['id'] = $convention_mod->id;
                $data['code'] = $convention_mod->code;
                $data['description'] = $convention_mod->description;*/
                
            } else 
            {
               /* $convention_mod = $this->Convention_modManager->findAll();
                if ($convention_mod) {
                    $data = $convention_mod;

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
                    'montant_travaux' => $this->post('montant_travaux'),
                    'nom_signataire' => $this->post('nom_signataire'),
                    'date_signature' => $this->post('date_signature'),
                    'date_prevu_recep' => $this->post('date_prevu_recep'),
                    'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_modManager->add($data);              
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
                        'montant_travaux' => $this->post('montant_travaux'),
                        'nom_signataire' => $this->post('nom_signataire'),
                        'date_signature' => $this->post('date_signature'),
                        'date_prevu_recep' => $this->post('date_prevu_recep'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Convention_modManager->add_down($data, $id);              
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
                        'montant_travaux' => $this->post('montant_travaux'),
                        'nom_signataire' => $this->post('nom_signataire'),
                        'date_signature' => $this->post('date_signature'),
                        'date_prevu_recep' => $this->post('date_prevu_recep'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Convention_modManager->update($id, $data);              
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
            $delete = $this->Convention_modManager->delete($id);          
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