<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Groupe_mlpl extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('groupe_mlpl_model', 'GroupemlplManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $data = array() ;
		if($id) {
			$data = $this->GroupemlplManager->findById($id);
            if (!$data)
                $data = array();
		} else if ($cle_etrangere)  {
            $data = $this->GroupemlplManager->findAllByVillage($cle_etrangere);
            if (!$data)
                $data = array();
        } else  {
			$data = $this->GroupemlplManager->findAll();
            if (!$data)
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
        $id_menage = null ;
		if($this->post('id_menage') && intval($this->post('id_menage')) >0) {
			$id_menage = $this->post('id_menage') ;
		}	
        $supprimer = $this->post('supprimer') ;
		// Affectation des valeurs des colonnes de la table
		$data = array(
			'date_creation'    => $this->post('date_creation'),
			'chef_village'     => $this->post('chef_village'),
			'id_menage'        => $id_menage,
			'nom_prenom_ml_pl' => $this->post('nom_prenom_ml_pl'),
			'nom_groupe'       => $this->post('nom_groupe'),
			'village_id'       => $this->post('village_id'),
			'sexe'             => $this->post('sexe'),
			'age'              => $this->post('age'),
			'lien_de_parente'  => $this->post('lien_de_parente'),
			'telephone'        => $this->post('telephone'),
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
                $dataId = $this->GroupemlplManager->add($data);
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
				// Mise � jour d'un enregistrement
                $update = $this->GroupemlplManager->update($id, $data);              
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
            $delete = $this->GroupemlplManager->delete($id);          
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