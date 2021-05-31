<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contrat_consultant_ong extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_consultant_ong_model', 'ContratconsultantManager');
        $this->load->model('livrable_consultant_model', 'LivrableconsultantManager');
        $this->load->model('point_controle_model', 'PoincontroleManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_sous_projet = $this->get('id_sous_projet');
        $menu = $this->get('menu');
        $data = array() ;
		if($menu=="getcontratbysousprojet")
        {
			$tmp = $this->ContratconsultantManager->getcontratbysousprojet($id_sous_projet);
            if ($tmp)
            {
                $data = $tmp;
            }
                
		}  
        elseif($id) {
			$data = $this->ContratconsultantManager->findById($id);
            if (!$data)
                $data = array();
		}  else  {
			$data = $this->ContratconsultantManager->findAll();
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
			'id_consultant' => $this->post('id_consultant'),
			'id_sous_projet' => $this->post('id_sous_projet'),
			'reference'  => $this->post('reference'),
			'date_contrat'    => $this->post('date_contrat'),
			'objet'    => $this->post('objet'),
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
                $dataId = $this->ContratconsultantManager->add($data);
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
                $update = $this->ContratconsultantManager->update($id, $data);              
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
			$detail_livrable =$this->LivrableconsultantManager->findByContrat($id);
			foreach($detail_livrable as $k=>$v) {
				$detail_point_controle=$this->PoincontroleManager->findByIdlivrable($v->id);
				foreach($detail_point_controle as $kk=>$vv) {
					$delete = $this->PoincontroleManager->delete($vv->id);
				}
				$delete1 = $this->LivrableconsultantManager->delete($v->id);
			}
            $delete = $this->ContratconsultantManager->delete($id);          
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