<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Filtration_env extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('filtration_env_model', 'FiltrationManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet_localisation = $this->get('id_sous_projet_localisation');
        if ($menu=="getfiltration_envbysousprojet_localisation") {
               
            $filtration_env = $this->FiltrationManager->getfiltration_envbysousprojet_localisation($id_sous_projet_localisation);
                if ($filtration_env) {
                    $data = $filtration_env;
                    /*foreach ($filtration_env as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->FiltrationManager->findById($id);
                /*$data['id'] = $filtration_env->id;
                $data['code'] = $filtration_env->code;
                $data['description'] = $filtration_env->description;*/
                
            } else 
            {
               /* $filtration_env = $this->FiltrationManager->findAll();
                if ($filtration_env) {
                    $data = $filtration_env;

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
                    //'nature_sous_projet' => $this->post('nature_sous_projet'),
                    'secretariat' => $this->post('secretariat'),
                    //'intitule_sous_projet' => $this->post('intitule_sous_projet'),
                    //'type_sous_projet' => $this->post('type_sous_projet'),
                    //'localisation' => $this->post('localisation'),
                    //'objectif_sous_projet' => $this->post('objectif_sous_projet'),
                    //'activite_sous_projet' => $this->post('activite_sous_projet'),
                    'cout_estime_sous_projet' => $this->post('cout_estime_sous_projet'),
                    'envergure_sous_projet' => $this->post('envergure_sous_projet'),
                    'ouvrage_prevu' => $this->post('ouvrage_prevu'),
                    //'description_sous_projet' => $this->post('description_sous_projet'),
                    'environnement_naturel' => $this->post('environnement_naturel'),
                    'date_visa_rt_ibd' => $this->post('date_visa_rt_ibd'),
                    'date_visa_res' => $this->post('date_visa_res'),
                    'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->FiltrationManager->add($data);              
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
                        //'nature_sous_projet' => $this->post('nature_sous_projet'),
                        'secretariat' => $this->post('secretariat'),
                        //'intitule_sous_projet' => $this->post('intitule_sous_projet'),
                        //'type_sous_projet' => $this->post('type_sous_projet'),
                        //'localisation' => $this->post('localisation'),
                        //'objectif_sous_projet' => $this->post('objectif_sous_projet'),
                        //'activite_sous_projet' => $this->post('activite_sous_projet'),
                        'cout_estime_sous_projet' => $this->post('cout_estime_sous_projet'),
                        'envergure_sous_projet' => $this->post('envergure_sous_projet'),
                        'ouvrage_prevu' => $this->post('ouvrage_prevu'),
                        //'description_sous_projet' => $this->post('description_sous_projet'),
                        'environnement_naturel' => $this->post('environnement_naturel'),
                        'date_visa_rt_ibd' => $this->post('date_visa_rt_ibd'),
                        'date_visa_res' => $this->post('date_visa_res'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->FiltrationManager->add_down($data, $id);              
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
                        //'nature_sous_projet' => $this->post('nature_sous_projet'),
                        'secretariat' => $this->post('secretariat'),
                        //'intitule_sous_projet' => $this->post('intitule_sous_projet'),
                        //'type_sous_projet' => $this->post('type_sous_projet'),
                        //'localisation' => $this->post('localisation'),
                        //'objectif_sous_projet' => $this->post('objectif_sous_projet'),
                        //'activite_sous_projet' => $this->post('activite_sous_projet'),
                        'cout_estime_sous_projet' => $this->post('cout_estime_sous_projet'),
                        'envergure_sous_projet' => $this->post('envergure_sous_projet'),
                        'ouvrage_prevu' => $this->post('ouvrage_prevu'),
                        //'description_sous_projet' => $this->post('description_sous_projet'),
                        'environnement_naturel' => $this->post('environnement_naturel'),
                        'date_visa_rt_ibd' => $this->post('date_visa_rt_ibd'),
                        'date_visa_res' => $this->post('date_visa_res'),
                        'id_sous_projet_localisation' => $this->post('id_sous_projet_localisation')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->FiltrationManager->update($id, $data);              
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
            $delete = $this->FiltrationManager->delete($id);          
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