<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Participant_realisation_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_realisation_ebe_model', 'Participant_realisation_ebeManager');
        $this->load->model('menage_model', 'MenageManager');
    }

    public function index_get() {
        $id = $this->get('id');
        //$cle_etrangere = $this->get('cle_etrangere');        
        $menu = $this->get('menu');
        $id_realisation_ebe = $this->get('id_realisation_ebe');
        $id_groupe_ml_pl = $this->get('id_groupe_ml_pl');
		$data = array();
        /*$id_realisation_ebe = $this->get('id_realisation_ebe');
		$data = array();
		if ($cle_etrangere) {
			// Selection par id
			$tmp = $this->Participant_realisation_ebeManager->findById_realisation_ebe($cle_etrangere);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $menage = $this->MenageManager->findById($value->id_menage);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_realisation_ebe']  = $value->id_realisation_ebe;
                    $data[$key]['menage'] = $menage;
                }
                //$data=$tmp;
			}
		}*/
		if ($menu=="get_participantByrealisationgroupe") {
			// Selection par id
			$tmp = $this->Participant_realisation_ebeManager->get_participantByrealisationgroupe($id_realisation_ebe,$id_groupe_ml_pl);
			if($tmp)
            {
				foreach ($tmp as $key => $value)
                {   
                    $menage = $this->MenageManager->findById($value->id_menage);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_realisation_ebe']  = $value->id_realisation_ebe;
                    $data[$key]['nombre_enfant_moins_six_ans']  = $value->nombre_enfant_moins_six_ans;
                    $data[$key]['id_menage_prevu']  = $value->id_menage_prevu;
                    $data[$key]['id_menage']  = $value->id_menage;
                    $data[$key]['date_presence']  = $value->date_presence;
                    $data[$key]['identifiant_menage']  = $value->identifiant_menage;
                    $data[$key]['nomchefmenage']  = $value->nomchefmenage;
                    if ($value->id_menage)
                    {                        
                        $data[$key]['checkbox_menage']  = true;
                    }
                    $data[$key]['id_realisation_ebe']  = $value->id_realisation_ebe;
                    //$data[$key]['menage'] = $menage;
                }
                //$data=$tmp;
			}
		} 
        elseif ($id) {
			// Selection par id
			$temporaire = $this->Participant_realisation_ebeManager->findById($id);
			if($temporaire) {
				$data=$temporaire;
			}
		} else {
			// Selection de tous les enregistrements	
			$temporaire = $this->Participant_realisation_ebeManager->findAll();
			if ($temporaire) {
				$data=$temporaire;
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
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			'id_menage' => $this->post('id_menage'),
			'id_realisation_ebe' => $this->post('id_realisation_ebe'),
			'date_presence' => $this->post('date_presence')
		);               
        if ($supprimer == 0) {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregitrement
                $dataId = $this->Participant_realisation_ebeManager->add($data);              
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
                $update = $this->Participant_realisation_ebeManager->update($id, $data);              
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
			// Suppression d'un enregitrement
            $delete = $this->Participant_realisation_ebeManager->delete($id);          
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