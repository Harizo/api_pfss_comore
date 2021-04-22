<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Fiche_env extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_env_model', 'FicheManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        if ($menu=="getfiche_envbysousprojet") {
               
            $fiche_env = $this->FicheManager->getfiche_envbysousprojet($id_sous_projet);
                if ($fiche_env) {
                    //$data = $fiche_env;
                    foreach ($fiche_env as $key => $value)
                    {
                        //$ile = $this->IleManager->findById($value->id_ile);
                        //$region = $this->RegionManager->findById($value->id_region);
                        //$commune = $this->CommuneManager->findById($value->id_commune);

                        $data[$key]['id'] = $value->id;
                        //$data[$key]['intitule_sousprojet'] = $value-> intitule_sousprojet;      
                        $data[$key]['bureau_etude'] = $value-> bureau_etude;      
                        $data[$key]['ref_contrat'] = $value-> ref_contrat;
                        //$data[$key]['ile'] = $ile;      
                        //$data[$key]['region'] = $region;      
                        //$data[$key]['commune'] = $commune;       
                        $data[$key]['composante_sousprojet'] = $value-> composante_sousprojet;      
                        //$data[$key]['localisation_sousprojet'] = $value-> localisation_sousprojet;      
                       // $data[$key]['localisation_geo'] = $value-> localisation_geo;      
                        $data[$key]['composante_zone_susce'] = $value-> composante_zone_susce;      
                        $data[$key]['probleme_env'] = $value-> probleme_env;      
                        $data[$key]['mesure_envisage'] = $value-> mesure_envisage;    
                        $data[$key]['justification_classe_env'] = $value-> justification_classe_env;     
                        $data[$key]['observation'] = $value-> observation;      
                        $data[$key]['date_visa_rt'] = $value-> date_visa_rt;     
                        $data[$key]['date_visa_ugp'] = $value-> date_visa_ugp;     
                        $data[$key]['date_visa_be'] = $value-> date_visa_be;
                        $data[$key]['id_sous_projet'] = $value->id_sous_projet;                        
                    };

                } else
                    $data = array();
            
        } elseif ($id) {
               
                $data = $this->FicheManager->findById($id);
                /*$data['id'] = $fiche_env->id;
                $data['code'] = $fiche_env->code;
                $data['description'] = $fiche_env->description;*/
                
            } else 
            {
               /* $fiche_env = $this->FicheManager->findAll();
                if ($fiche_env) {
                    $data = $fiche_env;

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
                    //'intitule_sousprojet'=> $this->post( 'intitule_sousprojet'),      
                    'bureau_etude'=> $this->post( 'bureau_etude'),      
                    'ref_contrat'=> $this->post( 'ref_contrat'),
                    //'id_ile'=> $this->post( 'id_ile'),      
                    //'id_region'=> $this->post( 'id_region'),      
                    //'id_commune'=> $this->post( 'id_commune'),       
                    'composante_sousprojet'=> $this->post( 'composante_sousprojet'),      
                    //'localisation_sousprojet'=> $this->post( 'localisation_sousprojet'),      
                    //'localisation_geo'=> $this->post( 'localisation_geo'),      
                    'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                    'probleme_env'=> $this->post( 'probleme_env'),      
                    'mesure_envisage'=> $this->post( 'mesure_envisage'),    
                    'justification_classe_env'=> $this->post( 'justification_classe_env'),     
                    'observation'=> $this->post( 'observation'),      
                    'date_visa_rt'=> $this->post( 'date_visa_rt'),     
                    'date_visa_ugp'=> $this->post( 'date_visa_ugp'),     
                    'date_visa_be'=> $this->post( 'date_visa_be'),
                    'id_sous_projet' => $this->post('id_sous_projet')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->FicheManager->add($data);              
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
                        //'intitule_sousprojet'=> $this->post( 'intitule_sousprojet'),      
                        'bureau_etude'=> $this->post( 'bureau_etude'),      
                        'ref_contrat'=> $this->post( 'ref_contrat'),
                        //'id_ile'=> $this->post( 'id_ile'),      
                        //'id_region'=> $this->post( 'id_region'),      
                        //'id_commune'=> $this->post( 'id_commune'),       
                        'composante_sousprojet'=> $this->post( 'composante_sousprojet'),      
                        //'localisation_sousprojet'=> $this->post( 'localisation_sousprojet'),      
                        //'localisation_geo'=> $this->post( 'localisation_geo'),      
                        'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                        'probleme_env'=> $this->post( 'probleme_env'),      
                        'mesure_envisage'=> $this->post( 'mesure_envisage'),    
                        'justification_classe_env'=> $this->post( 'justification_classe_env'),     
                        'observation'=> $this->post( 'observation'),      
                        'date_visa_rt'=> $this->post( 'date_visa_rt'),     
                        'date_visa_ugp'=> $this->post( 'date_visa_ugp'),     
                        'date_visa_be'=> $this->post( 'date_visa_be'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->FicheManager->add_down($data, $id);              
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
                        //'intitule_sousprojet'=> $this->post( 'intitule_sousprojet'),      
                        'bureau_etude'=> $this->post( 'bureau_etude'),      
                        'ref_contrat'=> $this->post( 'ref_contrat'),
                        //'id_ile'=> $this->post( 'id_ile'),      
                        //'id_region'=> $this->post( 'id_region'),      
                        //'id_commune'=> $this->post( 'id_commune'),       
                        'composante_sousprojet'=> $this->post( 'composante_sousprojet'),      
                        //'localisation_sousprojet'=> $this->post( 'localisation_sousprojet'),      
                        //'localisation_geo'=> $this->post( 'localisation_geo'),      
                        'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                        'probleme_env'=> $this->post( 'probleme_env'),      
                        'mesure_envisage'=> $this->post( 'mesure_envisage'),    
                        'justification_classe_env'=> $this->post( 'justification_classe_env'),     
                        'observation'=> $this->post( 'observation'),      
                        'date_visa_rt'=> $this->post( 'date_visa_rt'),     
                        'date_visa_ugp'=> $this->post( 'date_visa_ugp'),     
                        'date_visa_be'=> $this->post( 'date_visa_be'),
                        'id_sous_projet' => $this->post('id_sous_projet')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->FicheManager->update($id, $data);              
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
            $delete = $this->FicheManager->delete($id);          
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