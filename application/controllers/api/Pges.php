<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pges extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pges_model', 'PgesManager');
        $this->load->model('sous_projet_model', 'Sous_projetManager');
        $this->load->model('infrastructure_model', 'InfrastrctureManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        $id_village = $this->get('id_village');
        if ($menu=='getpgesBysousprojetvillage')
        {
               
            $tmp = $this->PgesManager->getpgesBysousprojetvillage($id_sous_projet,$id_village);
            if ($tmp)
            {
                foreach ($tmp as $key => $value)
                    {
                        
                        $infrastructure = $this->InfrastrctureManager->findByIdwithtype($value->id_infrastructure);
                        $data[$key]['id'] = $value->id;    
                        $data[$key]['bureau_etude'] = $value-> bureau_etude;      
                        $data[$key]['ref_contrat'] = $value-> ref_contrat;
                            
                        $data[$key]['description_env'] = $value-> description_env;         
                        $data[$key]['composante_zone_susce'] = $value-> composante_zone_susce;      
                        $data[$key]['probleme_env'] = $value-> probleme_env;      
                        $data[$key]['mesure_envisage'] = $value-> mesure_envisage;        
                        $data[$key]['observation'] = $value-> observation;      
                        $data[$key]['nom_prenom_etablissement'] = $value-> nom_prenom_etablissement;     
                        $data[$key]['nom_prenom_validation'] = $value-> nom_prenom_validation;     
                        $data[$key]['date_etablissement'] = $value-> date_etablissement;
                          
                        $data[$key]['date_visa_ugp'] = $value-> date_visa_ugp;      
                        $data[$key]['nom_prenom_ugp'] = $value-> nom_prenom_ugp; 
                        $data[$key]['infrastructure'] = $infrastructure;       
                        $data[$key]['montant_total'] = $value-> montant_total;      
                        $data[$key]['id_village'] = $value-> id_village;                       
                    };
                //$data=$tmp;
            }
            else {
                $data=array();
            }
            
            
        } 
        elseif ($menu=='getpgesBysousprojet')
        {
               
            $tmp = $this->PgesManager->getpgesBysousprojet($id_sous_projet);
            if ($tmp)
            {
                $data=$tmp;
            }
            else {
                $data=array();
            }
            
            
        } 
        elseif ($id)
        {
               
                $data = $this->PgesManager->findById($id);
                /*$data['id'] = $pges->id;
                $data['code'] = $pges->code;
                $data['description'] = $pges->description;*/
                
            } else 
            {
                $pges = $this->PgesManager->findAll();
                if ($pges) {
                    foreach ($pges as $key => $value)
                    {
                        
                        $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                        $data[$key]['id'] = $value->id;    
                        $data[$key]['bureau_etude'] = $value-> bureau_etude;      
                        $data[$key]['ref_contrat'] = $value-> ref_contrat;
                            
                        $data[$key]['description_env'] = $value-> description_env;         
                        $data[$key]['composante_zone_susce'] = $value-> composante_zone_susce;      
                        $data[$key]['probleme_env'] = $value-> probleme_env;      
                        $data[$key]['mesure_envisage'] = $value-> mesure_envisage;        
                        $data[$key]['observation'] = $value-> observation;      
                        $data[$key]['nom_prenom_etablissement'] = $value-> nom_prenom_etablissement;     
                        $data[$key]['nom_prenom_validation'] = $value-> nom_prenom_validation;     
                        $data[$key]['date_etablissement'] = $value-> date_etablissement;
                          
                        $data[$key]['date_visa_ugp'] = $value-> date_visa_ugp;      
                        $data[$key]['nom_prenom_ugp'] = $value-> nom_prenom_ugp; 
                        $data[$key]['sous_projet'] = $sous_projet;     
                        $data[$key]['montant_total'] = $value-> montant_total;                         
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
        $etat_download = $this->post('etat_download') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(      
                    'bureau_etude'=> $this->post( 'bureau_etude'),      
                    'ref_contrat'=> $this->post( 'ref_contrat'),      
                    'description_env'=> $this->post( 'description_env'),     
                    'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                    'probleme_env'=> $this->post( 'probleme_env'),      
                    'mesure_envisage'=> $this->post( 'mesure_envisage'),       
                    'observation'=> $this->post( 'observation'),      
                    'nom_prenom_etablissement'=> $this->post( 'nom_prenom_etablissement'),     
                    'nom_prenom_validation'=> $this->post( 'nom_prenom_validation'),     
                    'date_etablissement'=> $this->post( 'date_etablissement'),     
                    'date_visa_ugp'=> $this->post( 'date_visa_ugp'),      
                    'nom_prenom_ugp'=> $this->post( 'nom_prenom_ugp'), 
                    'id_sous_projet' => $this->post('id_sous_projet'), 
                    'id_village' => $this->post('id_village'), 
                    'id_infrastructure' => $this->post('id_infrastructure'), 
                    'montant_total' => $this->post('montant_total')
                );               
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->PgesManager->add($data);              
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
                        'bureau_etude'=> $this->post( 'bureau_etude'),      
                        'ref_contrat'=> $this->post( 'ref_contrat'),      
                        'description_env'=> $this->post( 'description_env'),     
                        'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                        'probleme_env'=> $this->post( 'probleme_env'),      
                        'mesure_envisage'=> $this->post( 'mesure_envisage'),         
                        'observation'=> $this->post( 'observation'),      
                        'nom_prenom_etablissement'=> $this->post( 'nom_prenom_etablissement'),     
                        'nom_prenom_validation'=> $this->post( 'nom_prenom_validation'),     
                        'date_etablissement'=> $this->post( 'date_etablissement'),     
                        'date_visa_ugp'=> $this->post( 'date_visa_ugp'),      
                        'nom_prenom_ugp'=> $this->post( 'nom_prenom_ugp'), 
                        'id_sous_projet' => $this->post('id_sous_projet'), 
                        'id_village' => $this->post('id_village'), 
                        'id_infrastructure' => $this->post('id_infrastructure'), 
                        'montant_total' => $this->post('montant_total')
                    );
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->PgesManager->add_down($data, $id);              
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
                        'bureau_etude'=> $this->post( 'bureau_etude'),      
                        'ref_contrat'=> $this->post( 'ref_contrat'),      
                        'description_env'=> $this->post( 'description_env'),     
                        'composante_zone_susce'=> $this->post( 'composante_zone_susce'),      
                        'probleme_env'=> $this->post( 'probleme_env'),      
                        'mesure_envisage'=> $this->post( 'mesure_envisage'),        
                        'observation'=> $this->post( 'observation'),      
                        'nom_prenom_etablissement'=> $this->post( 'nom_prenom_etablissement'),     
                        'nom_prenom_validation'=> $this->post( 'nom_prenom_validation'),     
                        'date_etablissement'=> $this->post( 'date_etablissement'),     
                        'date_visa_ugp'=> $this->post( 'date_visa_ugp'),      
                        'nom_prenom_ugp'=> $this->post( 'nom_prenom_ugp'), 
                        'id_sous_projet' => $this->post('id_sous_projet'), 
                        'id_village' => $this->post('id_village'), 
                        'id_infrastructure' => $this->post('id_infrastructure'), 
                        'montant_total' => $this->post('montant_total')
                    );              
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->PgesManager->update($id, $data);              
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
            $delete = $this->PgesManager->delete($id);          
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