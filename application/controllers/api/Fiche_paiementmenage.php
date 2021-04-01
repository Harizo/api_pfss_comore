<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Fiche_paiementmenage extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_paiementmenage_model', 'FichEpaiementmenageManager');
        $this->load->model('menage_model', 'menageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_sous_projet = $this->get('id_sous_projet');
        $village_id = $this->get('village_id');
        $data = array() ;
		if ($id) {
			// Selection ménage par id (id=clé primaire)
			$data = $this->FichEpaiementmenageManager->findById($id);
		} else {
			// Selection de tous les ménages
			$data = $this->FichEpaiementmenageManager->findAll();                   
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
			'fiche_paiement_id' => $this->post('fiche_paiement_id'),
			'menage_id' => ($this->post('menage_id')),
			'village_id' => ($this->post('village_id')),
			'fiche_presence_id' => ($this->post('fiche_presence_id')),
			'microprojet_id' => ($this->post('microprojet_id')),
			'travailleurpresent' => ($this->post('travailleurpresent')),
			'suppliantpresent' => ($this->post('suppliantpresent')),
			'montanttotalapayer' => ($this->post('montanttotalapayer')),
			'montanttotalpaye' => ($this->post('montanttotalpaye')),
			'montantapayertravailleur' => ($this->post('montantapayertravailleur')),
			'montantpayetravailleur' => ($this->post('montantpayetravailleur')),
			'montantapayersuppliant' => ($this->post('montantapayersuppliant')),
			'montantpayesuppliant' => ($this->post('montantpayesuppliant')),
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
				// Ajout d'un enregistrement
                $dataId = $this->FichEpaiementmenageManager->add($data);
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
                $update = $this->FichEpaiementmenageManager->update($id, $data);              
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
            $delete = $this->FichEpaiementmenageManager->delete($id);          
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