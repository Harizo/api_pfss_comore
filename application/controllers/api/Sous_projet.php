<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Sous_projet extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_model', 'SousprojetManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('communaute_model', 'CommunauteManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_par = $this->get('id_par');
        $menu = $this->get('menu');
		$data = array();
		if ($menu=="getsousprojetbypar") {
			$act = $this->SousprojetManager->getsousprojetbypar($id_par);
			if($act)
            {
				//$data = $act;
                foreach ($act as $key => $value)
                {
                    $commune= $this->CommuneManager->findById($value->id_commune);
                    $communaute= $this->CommunauteManager->findById($value->id_communaute);
                    $village= $this->VillageManager->findById($value->id_village);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['nature'] = $value->nature;
                    $data[$key]['code']= $value->code;
                    $data[$key]['type']= $value->type;
                    $data[$key]['description']= $value->description;
                    $data[$key]['description_activite']= $value->description_activite;
                    $data[$key]['presentantion_communaute']= $value->presentantion_communaute;
                    $data[$key]['ref_dgsc']= $value->ref_dgsc;
                    $data[$key]['nbr_menage_participant']= $value->nbr_menage_participant;
                    $data[$key]['nbr_menage_nonparticipant']= $value->nbr_menage_nonparticipant;
                    $data[$key]['population_total']= $value->population_total;
                    $data[$key]['objectif']= $value->objectif;
                    $data[$key]['duree']= $value->duree;
                    $data[$key]['commune']= $commune;
                    $data[$key]['village']= $village;
                    $data[$key]['communaute']= $communaute;
                }
			}
		}
        elseif ($id) {
			$act = $this->SousprojetManager->findById($id);
			if($act) {
				$data = $act;
			}
		}
        elseif($cle_etrangere)
        {
			$act = $this->SousprojetManager->findByIdpar($cle_etrangere);
			if($act)
            {
				$data = $act;
			}
		}
        else
        {	
			$act = $this->SousprojetManager->findAll();
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
        if ($type=="ACT")
        {
            $data = array(
                'code' => $this->post('code'),
                'intitule' => $this->post('intitule') ,
                'nature' => $this->post('nature') ,
                'type' => $this->post('type') ,
                'description' => $this->post('description') ,
                'description_activite' => $this->post('description_activite') ,
                'presentantion_communaute' => $this->post('presentantion_communaute') ,
                'ref_dgsc' => $this->post('ref_dgsc') ,
                'nbr_menage_participant' => $this->post('nbr_menage_participant') ,
                'nbr_menage_nonparticipant' => $this->post('nbr_menage_nonparticipant') ,
                'population_total' => $this->post('population_total') ,
                'objectif' => $this->post('objectif') ,
                'duree' => $this->post('duree') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => $this->post('id_village') ,
                'id_communaute' => null ,
                'id_par' => $this->post('id_par'),
            ); 
        }
        else
        {
            $data = array(
                'code' => $this->post('code'),
                'intitule' => $this->post('intitule') ,
                'nature' => $this->post('nature') ,
                'type' => $this->post('type') ,
                'description' => $this->post('description') ,
                'description_activite' => $this->post('description_activite') ,
                'presentantion_communaute' => $this->post('presentantion_communaute') ,
                'ref_dgsc' => $this->post('ref_dgsc') ,
                'nbr_menage_participant' => $this->post('nbr_menage_participant') ,
                'nbr_menage_nonparticipant' => $this->post('nbr_menage_nonparticipant') ,
                'population_total' => $this->post('population_total') ,
                'objectif' => $this->post('objectif') ,
                'duree' => $this->post('duree') ,
                'id_commune' => $this->post('id_commune') ,
                'id_village' => null ,
                'id_communaute' => $this->post('id_communaute') ,
                'id_par' => $this->post('id_par'),
            ); 
        }	
		              
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
                $dataId = $this->SousprojetManager->add($data);              
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
                $dataId = $this->SousprojetManager->add_down($data, $id);              
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
                $update = $this->SousprojetManager->update($id, $data);              
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
            $delete = $this->SousprojetManager->delete($id);          
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