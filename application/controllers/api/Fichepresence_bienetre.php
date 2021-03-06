<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fichepresence_bienetre extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fichepresence_bienetre_model', 'FichepresencebienetreManager');
        $this->load->model('fichepresence_bienetre_menage_model', 'FichepresencebienetremenageManager');
        $this->load->model('menage_model', 'MenageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_groupe_ml_pl = $this->get('id_groupe_ml_pl');
        $numeroligne = $this->get('numeroligne');
        $menu = $this->get('menu');
        $data = array() ;
		if($menu=="getfichepresencebygroupe") {
			$data = $this->FichepresencebienetreManager->getfichepresencebygroupe($id_groupe_ml_pl);
            if (!$data)
                $data = array();
		} 
        elseif($id)
        {
			$data = $this->FichepresencebienetreManager->findById($id);
            if (!$data)
                $data = array();
		} else if ($cle_etrangere && $numeroligne)  {
            $data = $this->FichepresencebienetreManager->NumeroligneParGroupemlpl($cle_etrangere);
            if (!$data)
                $data = array();
		} else if($cle_etrangere) { 
            $data = $this->FichepresencebienetreManager->findAllByGroupemlpl($cle_etrangere);
            if (!$data)
                $data = array();			
        } else  {
			$data = $this->FichepresencebienetreManager->findAll();
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
			'id_groupe_ml_pl'      => $this->post('id_groupe_ml_pl'),
			'date_presence'        => $this->post('date_presence'),
			'numero_ligne' => $this->post('numero_ligne'),
			'id_espace_bienetre' => $this->post('id_espace_bienetre'),
			'nombre_menage_present' => $this->post('nombre_menage_present'),
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
                $dataId = $this->FichepresencebienetreManager->add($data);
				$nombre_menage_present=$this->post('nombre_menage_present') ;
				if(intval($nombre_menage_present) >0) {
					for($i=1;$i<=$nombre_menage_present;$i++) {
						$data = array(
							'id_fiche_presence_bienetre'      => $dataId,
							'id_menage'        => $this->post('id_menage_'.$i),
						);               
						$ret=$this->FichepresencebienetremenageManager->add($data);
					}	
				}
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
                $update = $this->FichepresencebienetreManager->update($id, $data);              
				// Supprimer les dtails dans la table puis reinsérer après
				$del=$this->FichepresencebienetremenageManager->deleteByFichepresence($id);
				$nombre_menage_present=$this->post('nombre_menage_present') ;
				if(intval($nombre_menage_present) >0) {
					for($i=1;$i<=$nombre_menage_present;$i++) {
						$data = array(
							'id_fiche_presence_bienetre'      => $id,
							'id_menage'        => $this->post('id_menage_'.$i),
						);               
						$ret=$this->FichepresencebienetremenageManager->add($data);
					}	
				}
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
            $delete = $this->FichepresencebienetreManager->delete($id);          
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