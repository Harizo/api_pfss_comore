<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Etat_paiement_agep extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('etat_paiement_agep_model', 'Etat_paiement_agepManager');
        $this->load->model('menage_model', 'MenageManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('zip_model', 'ZipManager');
        //$this->load->model('communaute_model', 'CommunauteManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $id_contrat_agep = $this->get('id_contrat_agep');
        $menu = $this->get('menu');
        $data = array() ;
       
        if ($menu=="getetatBycontrat")
        {
            $tmp = $this->Etat_paiement_agepManager->getetatBycontrat($id_contrat_agep);          
            if ($tmp)
            {
                foreach ($tmp as $key => $value) 
                {   
                    $menage = $this->MenageManager->findById($value->id_menage);
                    $ile= $this->IleManager->findById($value->id_ile);
                    $region= $this->RegionManager->findById($value->id_region);
                    $commune= $this->CommuneManager->findById($value->id_commune);
                    //$communaute= $this->CommunauteManager->findById($value->id_communaute);
                    $village= $this->VillageManager->findById($value->id_village);
                    $zip= $this->ZipManager->findById($village->id_zip);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero_ordre_paiement'] = $value->numero_ordre_paiement;
                    $data[$key]['activite_concerne'] = $value->activite_concerne;
                    $data[$key]['menage'] = $menage;
                    $data[$key]['tranche'] = $value->tranche;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    //$data[$key]['montant_total_prevu'] = $value->montant_total_prevu;
                    $data[$key]['montant_percu'] = $value->montant_percu;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['moyen_transfert'] = $value->moyen_transfert;
                    $data[$key]['situation_paiement'] = $value->situation_paiement;
                    $data[$key]['ile']= $ile;
                    $data[$key]['region']= $region;
                    $data[$key]['commune']= $commune;
                    $data[$key]['commune']= $commune;
                    $data[$key]['village']= $village;
                    $data[$key]['zip']= $zip;
                    //$data[$key]['communaute']= $communaute;
                }               
            }
        } 
        elseif ($id)
        {
            
            $data = $this->Etat_paiement_agepManager->findById($id);
        }
        else
        {
            
            $data = $this->Etat_paiement_agepManager->findAll();                   
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
        $id_sous_projet = $this->post('id_sous_projet') ;
        $data = array(
            'numero_ordre_paiement'=> $this->post('numero_ordre_paiement'),
            'activite_concerne'=> $this->post('activite_concerne'),
            'id_menage'=> $this->post('id_menage'),
            'id_contrat_agep'=> $this->post('id_contrat_agep'),
            'tranche'=> $this->post('tranche'),
            'pourcentage'=> $this->post('pourcentage'),
            //'montant_total_prevu'=> $this->post('montant_total_prevu'),
            'montant_percu'=> $this->post('montant_percu'),
            'date_paiement'=> $this->post('date_paiement'),
            'moyen_transfert'=> $this->post('moyen_transfert'),
            'situation_paiement'=> $this->post('situation_paiement'),
            'id_ile' => $this->post('id_ile') ,
            'id_region' => $this->post('id_region') ,
            'id_commune' => $this->post('id_commune') ,
            'id_village' => $this->post('id_village') ,
            //'id_communaute' => null 
        );
        /*if ($this->post('activite_concerne')=='IDB')
        {
            $data = array(
                'numero_ordre_paiement'=> $this->post('numero_ordre_paiement'),
                'activite_concerne'=> $this->post('activite_concerne'),
                'id_menage'=> $this->post('id_menage'),
                'id_contrat_agep'=> $this->post('id_contrat_agep'),
                'tranche'=> $this->post('tranche'),
                'pourcentage'=> $this->post('pourcentage'),
                //'montant_total_prevu'=> $this->post('montant_total_prevu'),
                'montant_percu'=> $this->post('montant_percu'),
                'date_paiement'=> $this->post('date_paiement'),
                'moyen_transfert'=> $this->post('moyen_transfert'),
                'situation_paiement'=> $this->post('situation_paiement'),
                'id_ile' => $this->post('id_ile') ,
                'id_region' => $this->post('id_region') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => null ,
                //'id_communaute' => $this->post('id_communaute') 
            );
        }
        else
        {
            $data = array(
                'numero_ordre_paiement'=> $this->post('numero_ordre_paiement'),
                'activite_concerne'=> $this->post('activite_concerne'),
                'id_menage'=> $this->post('id_menage'),
                'id_contrat_agep'=> $this->post('id_contrat_agep'),
                'tranche'=> $this->post('tranche'),
                'pourcentage'=> $this->post('pourcentage'),
                //'montant_total_prevu'=> $this->post('montant_total_prevu'),
                'montant_percu'=> $this->post('montant_percu'),
                'date_paiement'=> $this->post('date_paiement'),
                'moyen_transfert'=> $this->post('moyen_transfert'),
                'situation_paiement'=> $this->post('situation_paiement'),
                'id_ile' => $this->post('id_ile') ,
                'id_region' => $this->post('id_region') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => $this->post('id_village') ,
                //'id_communaute' => null 
            );
        }*/
		               
        if ($supprimer == 0) {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->Etat_paiement_agepManager->add($data);
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
            } else {
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Mise à jour d'un enregistrement
                $update = $this->Etat_paiement_agepManager->update($id, $data);              
                if(!is_null($update)){
                    $this->response([
                        'status' => TRUE, 
                        'response' => $id,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
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
			// Suppression d'un enregistrement
            $delete = $this->Etat_paiement_agepManager->delete($id);          
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
?>