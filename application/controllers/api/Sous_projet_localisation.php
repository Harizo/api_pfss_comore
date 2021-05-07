<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet_localisation extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_localisation_model', 'Sousprojet_localisationManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
        //$this->load->model('communaute_model', 'CommunauteManager');
        $this->load->model('zip_model', 'ZipManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_sous_projet = $this->get('id_sous_projet');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="getlocalisationbysousprojet") {
			$act = $this->Sousprojet_localisationManager->getlocalisationbysousprojet($id_sous_projet);
			if($act)
            {
				//$data = $act;
                foreach ($act as $key => $value)
                {   
                    $ile= $this->IleManager->findById($value->id_ile);
                    $region= $this->RegionManager->findById($value->id_region);
                    $commune= $this->CommuneManager->findById($value->id_commune);
                    //$communaute= $this->CommunauteManager->findById($value->id_communaute);
                    $village= $this->VillageManager->findById($value->id_village);
                    $zip= $this->ZipManager->findById($village->id_zip);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['presentantion_communaute']= $value->presentantion_communaute;
                    $data[$key]['ref_dgsc']= $value->ref_dgsc;
                    $data[$key]['nbr_menage_beneficiaire']= $value->nbr_menage_beneficiaire;
                    $data[$key]['nbr_menage_participant']= $value->nbr_menage_participant;
                    $data[$key]['nbr_menage_nonparticipant']= $value->nbr_menage_nonparticipant;
                    $data[$key]['population_total']= $value->population_total;
                    $data[$key]['ile']= $ile;
                    $data[$key]['region']= $region;
                    $data[$key]['commune']= $commune;
                    $data[$key]['commune']= $commune;
                    $data[$key]['village']= $village;
                    $data[$key]['zip']= $zip;
                }
			}
		}
        elseif ($id) {
			$act = $this->Sousprojet_localisationManager->findById($id);
			if($act) {
				$data = $act;
			}
		}
        elseif($cle_etrangere)
        {
			$act = $this->Sousprojet_localisationManager->findByIdpar($cle_etrangere);
			if($act)
            {
				$data = $act;
			}
		}
        else
        {	
			$act = $this->Sousprojet_localisationManager->findAll();
			if($act)
            {
				$data = $act;
			}
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
    //insertion,modification,suppression liste variable
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        $etat_download = $this->post('etat_download') ; 
        $type= $this->post('type');
        $data = array(
            'presentantion_communaute' => $this->post('presentantion_communaute') ,
            'ref_dgsc' => $this->post('ref_dgsc') ,
            'nbr_menage_beneficiaire' => $this->post('nbr_menage_beneficiaire') ,
            'nbr_menage_participant' => $this->post('nbr_menage_participant') ,
            'nbr_menage_nonparticipant' => $this->post('nbr_menage_nonparticipant') ,
            'population_total' => $this->post('population_total') ,
            'id_ile' => $this->post('id_ile') ,
            'id_region' => $this->post('id_region') ,
            'id_commune' => $this->post('id_commune') ,
            'id_village' => $this->post('id_village') ,
            'id_sous_projet' => $this->post('id_sous_projet'),
        );
       /* if ($type=="ACT" || $type=="ARSE" || $type=="COVID-19")
        {
            $data = array(
                'presentantion_communaute' => $this->post('presentantion_communaute') ,
                'ref_dgsc' => $this->post('ref_dgsc') ,
                'nbr_menage_beneficiaire' => $this->post('nbr_menage_beneficiaire') ,
                'nbr_menage_participant' => $this->post('nbr_menage_participant') ,
                'nbr_menage_nonparticipant' => $this->post('nbr_menage_nonparticipant') ,
                'population_total' => $this->post('population_total') ,
                'id_ile' => $this->post('id_ile') ,
                'id_region' => $this->post('id_region') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => $this->post('id_village') ,
                'id_communaute' => null ,
                'id_sous_projet' => $this->post('id_sous_projet'),
            ); 
        }
        else
        {
            $data = array(
                'presentantion_communaute' => $this->post('presentantion_communaute') ,
                'ref_dgsc' => $this->post('ref_dgsc') ,
                'nbr_menage_beneficiaire' => $this->post('nbr_menage_beneficiaire') ,
                'nbr_menage_participant' => $this->post('nbr_menage_participant') ,
                'nbr_menage_nonparticipant' => $this->post('nbr_menage_nonparticipant') ,
                'population_total' => $this->post('population_total') ,
                'id_ile' => $this->post('id_ile') ,
                'id_region' => $this->post('id_region') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => null ,
                'id_communaute' => $this->post('id_communaute') ,
                'id_sous_projet' => $this->post('id_sous_projet'),
            ); 
        }	*/
		              
        if ($supprimer == 0) {
            if ($id == 0) {
				// Nouvel enregistrement
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sousprojet_localisationManager->add($data);              
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
            } else if($etat_download) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Sousprojet_localisationManager->add_down($data, $id);              
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
				// Mise à jour d'un enregistrement
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Sousprojet_localisationManager->update($id, $data);              
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
        } else {
            if (!$id) {
            $this->response([
            'status' => FALSE,
            'response' => 0,
            'message' => 'No request found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
			// Suppression d'un enregistrement
            $delete = $this->Sousprojet_localisationManager->delete($id);          
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
?>