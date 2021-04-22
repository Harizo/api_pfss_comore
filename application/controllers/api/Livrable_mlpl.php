<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Livrable_mlpl extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('livrable_mlpl_model', 'Livrable_mlplManager');
        $this->load->model('contrat_consultant_ong_model', 'Contrat_consultant_ongManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $data = array() ;
		if($id) {
			$data = $this->Livrable_mlplManager->findById($id);
            if (!$data)
                $data = array();
		}  else  if($cle_etrangere) {
			$tmp = $this->Livrable_mlplManager->findByGoupemlpl($cle_etrangere);
            if ($tmp)
            {
                foreach ($tmp as $key => $value)
                {
                    $contrat_consultant = $this->Contrat_consultant_ongManager->findById($value->id_contrat_consultant);
                    $data[$key]['contrat_consultant']        = $contrat_consultant;
                    $data[$key]['id']                        = $value->id;
                    $data[$key]['id_groupemlpl']             = $value->id_groupemlpl;
                    $data[$key]['activite_concernee']        = $value->activite_concernee;
                    $data[$key]['intitule_livrable']         = $value->intitule_livrable;
                    $data[$key]['date_prevue_remise']        = $value->date_prevue_remise;
                    $data[$key]['date_effective_reception']  = $value->date_effective_reception;
                    $data[$key]['intervenant']               = $value->intervenant;
                    $data[$key]['nbr_commune_touchee']       = $value->nbr_commune_touchee;
                    $data[$key]['nbr_village_touchee']       = $value->nbr_village_touchee;
                    $data[$key]['observation']               = $value->observation;
                }
            }
            else
                $data = array();
		} else {	
			$data = $this->Livrable_mlplManager->findAll();
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
			'id_contrat_consultant'     => $this->post('id_contrat_consultant'),
			'id_groupemlpl'             => $this->post('id_groupemlpl'),
			'activite_concernee'        => $this->post('activite_concernee'),
			'intitule_livrable'         => $this->post('intitule_livrable'),
			'date_prevue_remise'        => $this->post('date_prevue_remise'),
			'date_effective_reception'  => $this->post('date_effective_reception'),
			'intervenant'               => $this->post('intervenant'),
			'nbr_commune_touchee'       => $this->post('nbr_commune_touchee'),
			'nbr_village_touchee'       => $this->post('nbr_village_touchee'),
			'observation'               => $this->post('observation')
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
                $dataId = $this->Livrable_mlplManager->add($data);
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
                $update = $this->Livrable_mlplManager->update($id, $data);              
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
            $delete = $this->Livrable_mlplManager->delete($id);          
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