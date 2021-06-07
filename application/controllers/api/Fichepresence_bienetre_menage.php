<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fichepresence_bienetre_menage extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fichepresence_bienetre_menage_model', 'FichepresencebienetremenageManager');
        $this->load->model('menage_model', 'MenageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_fiche_presence_bienetre = $this->get('id_fiche_presence_bienetre');
        $id_seulement = $this->get('id_seulement');
        $menu = $this->get('menu');
        $data = array() ;
		if($cle_etrangere) {
			$data = $this->FichepresencebienetremenageManager->findByfichepresence($cle_etrangere);
			if($id_seulement && $data) {
				$temporaire=$data;
				$data=array();
				$data['tab_reponse_presence_bienetre']=array();
				foreach($temporaire as $k=>$v) {
					$data['tab_reponse_presence_bienetre'][$k] = $v->id_menage;
				}
			}	
            if (!$data)
                $data = array();
		} elseif($id)
        {
			$data = $this->FichepresencebienetremenageManager->findById($id);
            if (!$data)
                $data = array();
		} else  {
			$data = $this->FichepresencebienetremenageManager->findAll();
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
        $supprimer = $this->post('supprimer') ;
		// Affectation des valeurs des colonnes de la table
		$data = array(
			'id_fiche_presence_bienetre'      => $this->post('id_fiche_presence_bienetre'),
			'id_menage' => $this->post('id_menage')
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
                $dataId = $this->FichepresencebienetremenageManager->add($data);
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
                $update = $this->FichepresencebienetremenageManager->update($id, $data);              
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
            $delete = $this->FichepresencebienetremenageManager->delete($id);          
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