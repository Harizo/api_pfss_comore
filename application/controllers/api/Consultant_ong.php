<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Consultant_ong extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('consultant_ong_model', 'ConsultantongManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $data = array() ;
		if($id) {
			$data = $this->ConsultantongManager->findById($id);
            if (!$data)
                $data = array();
		}  
        elseif($cle_etrangere)
        {
			$tmp = $this->ConsultantongManager->getconsultantbyile($cle_etrangere);
            if ($tmp)
            {
                foreach ($tmp as $key => $value)
                {
                    $ile = $this->IleManager->findById($value->ile_id);
                    $region = $this->RegionManager->findById($value->id_region);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $village = $this->VillageManager->findById($value->id_village);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom_consultant']    = $value->nom_consultant;
                    $data[$key]['raison_social']  = $value->raison_social;
                    $data[$key]['contact']    = $value->contact;
                    $data[$key]['fonction_contact']    = $value->fonction_contact;
                    $data[$key]['telephone_contact']    = $value->telephone_contact;
                    $data[$key]['adresse']    = $value->adresse;
                    $data[$key]['ile']    = $ile;
                    $data[$key]['region']    = $region;
                    $data[$key]['commune']    = $commune;
                    $data[$key]['village']    = $village;
                }
            }
            else
                $data = array();
		} 
        else
        {
			$tmp = $this->ConsultantongManager->findAll();
            if ($tmp)
            {
                foreach ($tmp as $key => $value)
                {
                    $ile = $this->IleManager->findById($value->ile_id);
                    $region = $this->RegionManager->findById($value->id_region);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $village = $this->VillageManager->findById($value->id_village);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom_consultant']    = $value->nom_consultant;
                    $data[$key]['raison_social']  = $value->raison_social;
                    $data[$key]['contact']    = $value->contact;
                    $data[$key]['fonction_contact']    = $value->fonction_contact;
                    $data[$key]['telephone_contact']    = $value->telephone_contact;
                    $data[$key]['adresse']    = $value->adresse;
                    $data[$key]['ile']    = $ile;
                    $data[$key]['region']    = $region;
                    $data[$key]['commune']    = $commune;
                    $data[$key]['village']    = $village;
                }
            }
            else
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
		// Affectation des valeurs des colonnes de la table
		$data = array(
			'code' => $this->post('code'),
			'nom_consultant'    => $this->post('nom_consultant'),
			'raison_social'  => $this->post('raison_social'),
			'contact'    => $this->post('contact'),
			'fonction_contact'    => $this->post('fonction_contact'),
			'telephone_contact'    => $this->post('telephone_contact'),
			'adresse'    => $this->post('adresse'),
			'ile_id'    => $this->post('ile_id'),
			'id_region'    => $this->post('id_region'),
			'id_commune'    => $this->post('id_commune'),
			'id_village'    => $this->post('id_village')
		);               
         if ($supprimer == 0)  {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->ConsultantongManager->add($data);
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
                if ($etat_download) 
                {
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->ConsultantongManager->add_down($data, $id);              
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
                    if (!$data || !$id) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $update = $this->ConsultantongManager->update($id, $data);              
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
			// Suppression d'un enregistrement
            $delete = $this->ConsultantongManager->delete($id);          
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