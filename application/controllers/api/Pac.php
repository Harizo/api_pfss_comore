<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pac extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pac_model', 'PacManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('zip_model', 'ZipManager');
    }

    public function index_get() {
        $id = $this->get('id');
        if ($id) {
               
                $data = $this->PacManager->findById($id);
                /*$data['id'] = $pac->id;
                $data['code'] = $pac->code;
                $data['description'] = $pac->description;*/
                
            } else 
            {
               $pac = $this->PacManager->findAll();
                if ($pac)
                {
                    //$data = $pac;
                    foreach ($pac as $key => $value)
                    {
                        $ile = $this->IleManager->findById($value->id_ile);
                        $region = $this->RegionManager->findById($value->id_region);
                        $commune = $this->CommuneManager->findById($value->id_commune);
                        $zip = $this->ZipManager->findById($value->id_zip);
                        $data[$key]['id']       = $value->id;
                        $data[$key]['milieu_physique']       = $value->milieu_physique;
                        $data[$key]['condition_climatique']  = $value->condition_climatique;
                        $data[$key]['diffi_socio_eco']       = $value->diffi_socio_eco;      
                        $data[$key]['infra_pub_soc']         = $value->infra_pub_soc;      
                        $data[$key]['analyse_pro']           = $value->analyse_pro;
                        $data[$key]['identi_prio_arse']      = $value->identi_prio_arse;
                        $data[$key]['marche_loc_reg_arse']  = $value->marche_loc_reg_arse;
                        $data[$key]['description_activite'] = $value->description_activite;      
                        $data[$key]['estimation_besoin']    = $value->estimation_besoin;      
                        $data[$key]['etude_eco']       = $value->etude_eco;
                        $data[$key]['structure_appui'] = $value->structure_appui;
                        $data[$key]['impact_env']      = $value->impact_env;
                        $data[$key]['impact_sociau']   = $value->impact_sociau;
                        $data[$key]['ile']   = $ile;
                        $data[$key]['region']   = $region;
                        $data[$key]['commune']   = $commune;
                        $data[$key]['zip']   = $zip;
                    }

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
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'milieu_physique'       => $this->post('milieu_physique'),
                    'condition_climatique'  => $this->post('condition_climatique'),
                    'diffi_socio_eco'  => $this->post('diffi_socio_eco'),      
                    'infra_pub_soc'    => $this->post('infra_pub_soc'),      
                    'analyse_pro'  => $this->post('analyse_pro'),
                    'identi_prio_arse' => $this->post('identi_prio_arse'),
                    'marche_loc_reg_arse'  => $this->post('marche_loc_reg_arse'),
                    'description_activite' => $this->post('description_activite'),      
                    'estimation_besoin'    => $this->post('estimation_besoin'),      
                    'etude_eco'  => $this->post('etude_eco'),
                    'structure_appui' => $this->post('structure_appui'),
                    'impact_env'      => $this->post('impact_env'),
                    'impact_sociau'  => $this->post('impact_sociau'),      
                    'id_ile'    => $this->post('id_ile'),      
                    'id_region'  => $this->post('id_region'),
                    'id_commune' => $this->post('id_commune'),
                    'id_zip'     => $this->post('id_zip')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->PacManager->add($data);              
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
                        'milieu_physique'       => $this->post('milieu_physique'),
                        'condition_climatique'  => $this->post('condition_climatique'),
                        'diffi_socio_eco'  => $this->post('diffi_socio_eco'),      
                        'infra_pub_soc'    => $this->post('infra_pub_soc'),      
                        'analyse_pro'  => $this->post('analyse_pro'),
                        'identi_prio_arse' => $this->post('identi_prio_arse'),
                        'marche_loc_reg_arse'  => $this->post('marche_loc_reg_arse'),
                        'description_activite' => $this->post('description_activite'),      
                        'estimation_besoin'    => $this->post('estimation_besoin'),      
                        'etude_eco'  => $this->post('etude_eco'),
                        'structure_appui' => $this->post('structure_appui'),
                        'impact_env'      => $this->post('impact_env'),
                        'impact_sociau'  => $this->post('impact_sociau'),      
                        'id_ile'    => $this->post('id_ile'),      
                        'id_region'  => $this->post('id_region'),
                        'id_commune' => $this->post('id_commune'),
                        'id_zip'     => $this->post('id_zip')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->PacManager->add_down($data, $id);              
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
                        'milieu_physique'       => $this->post('milieu_physique'),
                        'condition_climatique'  => $this->post('condition_climatique'),
                        'diffi_socio_eco'  => $this->post('diffi_socio_eco'),      
                        'infra_pub_soc'    => $this->post('infra_pub_soc'),      
                        'analyse_pro'  => $this->post('analyse_pro'),
                        'identi_prio_arse' => $this->post('identi_prio_arse'),
                        'marche_loc_reg_arse'  => $this->post('marche_loc_reg_arse'),
                        'description_activite' => $this->post('description_activite'),      
                        'estimation_besoin'    => $this->post('estimation_besoin'),      
                        'etude_eco'  => $this->post('etude_eco'),
                        'structure_appui' => $this->post('structure_appui'),
                        'impact_env'      => $this->post('impact_env'),
                        'impact_sociau'  => $this->post('impact_sociau'),      
                        'id_ile'    => $this->post('id_ile'),      
                        'id_region'  => $this->post('id_region'),
                        'id_commune' => $this->post('id_commune'),
                        'id_zip'     => $this->post('id_zip')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->PacManager->update($id, $data);              
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
            $delete = $this->PacManager->delete($id);          
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