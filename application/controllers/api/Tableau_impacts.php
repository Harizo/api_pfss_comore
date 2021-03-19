<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tableau_impacts extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tableau_impacts_model', 'Tableau_impatcsManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_etude_env = $this->get('id_etude_env');
        if ($menu=="gettableau_impactsbyetude") {
               
            $tableau_impacts = $this->Tableau_impatcsManager->gettableau_impactsbyetude($id_etude_env);
                if ($tableau_impacts) {
                    $data = $tableau_impacts;
                    /*foreach ($tableau_impacts as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        
                    };*/

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->Tableau_impatcsManager->findById($id);
                /*$data['id'] = $tableau_impacts->id;
                $data['code'] = $tableau_impacts->code;
                $data['description'] = $tableau_impacts->description;*/
                
            } else 
            {
               /* $tableau_impacts = $this->Tableau_impatcsManager->findAll();
                if ($tableau_impacts) {
                    $data = $tableau_impacts;

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
                    'sources_sousprojets' => $this->post('sources_sousprojets'),
                    'localisation' => $this->post('localisation'),
                    'nature_recepteur' => $this->post('nature_recepteur'),
                    'composante_recepteur' => $this->post('composante_recepteur'),
                    'impacts' => $this->post('impacts'),
                    'nature_impact' => $this->post('nature_impact'),
                    'degre_impact' => $this->post('degre_impact'),
                    'effet_impact' => $this->post('effet_impact'),
                    'id_etude_env' => $this->post('id_etude_env')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Tableau_impatcsManager->add($data);              
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
                        'sources_sousprojets' => $this->post('sources_sousprojets'),
                        'localisation' => $this->post('localisation'),
                        'nature_recepteur' => $this->post('nature_recepteur'),
                        'composante_recepteur' => $this->post('composante_recepteur'),
                        'impacts' => $this->post('impacts'),
                        'nature_impact' => $this->post('nature_impact'),
                        'degre_impact' => $this->post('degre_impact'),
                        'effet_impact' => $this->post('effet_impact'),
                        'id_etude_env' => $this->post('id_etude_env')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->Tableau_impatcsManager->add_down($data, $id);              
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
                        'sources_sousprojets' => $this->post('sources_sousprojets'),
                        'localisation' => $this->post('localisation'),
                        'nature_recepteur' => $this->post('nature_recepteur'),
                        'composante_recepteur' => $this->post('composante_recepteur'),
                        'impacts' => $this->post('impacts'),
                        'nature_impact' => $this->post('nature_impact'),
                        'degre_impact' => $this->post('degre_impact'),
                        'effet_impact' => $this->post('effet_impact'),
                        'id_etude_env' => $this->post('id_etude_env')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->Tableau_impatcsManager->update($id, $data);              
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
            $delete = $this->Tableau_impatcsManager->delete($id);          
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