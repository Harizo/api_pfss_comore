<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Fiche_paiement extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_paiment_model', 'FichEpaiementManager');
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
			$data = $this->FichEpaiementManager->findById($id);
		} else {
			// Selection de tous les ménages
			$data = $this->FichEpaiementManager->findAll();                   
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
			'activite_id' => $this->post('activite_id'),
			'village_id' => ($this->post('village_id')),
			'id_annee' => ($this->post('id_annee')),
			'id_sous_projet' => ($this->post('id_sous_projet')),
			'etape_id' => ($this->post('date_sortie')),
			'fichepresence_id' => ($this->post('fichepresence_id')),
			'agep_id' => ($this->post('agep_id')),
			'inapte' => ($this->post('inapte')),
			'datepaiement' => ($this->post('datepaiement')),
			'nombrejourdetravail' => ($this->post('nombrejourdetravail')),
			'montanttotalapayer' => ($this->post('montanttotalapayer')),
			'montanttotalpaye' => ($this->post('montanttotalpaye')),
			'montantapayertravailleur' => ($this->post('montantapayertravailleur')),
			'montantpayetravailleur' => ($this->post('montantpayetravailleur')),
			'montantapayersuppliant' => ($this->post('montantapayersuppliant')),
			'montantpayesuppliant' => ($this->post('montantpayesuppliant')),
			'indemnite' => ($this->post('indemnite')),
			'observation' => ($this->post('observation')),
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
                $dataId = $this->FichEpaiementManager->add($data);
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
                $update = $this->FichEpaiementManager->update($id, $data);              
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
            $delete = $this->FichEpaiementManager->delete($id);          
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