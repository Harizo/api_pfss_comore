<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Variable_individu extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('variable_individu_model', 'VariableindividuManager');
        $this->load->model('liste_variable_individu_model', 'ListevariableindividuManager');
    }
    //recuperation détail variable
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        if ($cle_etrangere){
            $data = array();
			// Selection liste variable
            $temporaire = $this->VariableindividuManager->findAllByIdlistevariable($cle_etrangere);
            if ($temporaire) {
                foreach ($temporaire as $key => $value) {
                    $listevariable = array();
					// Selection détail liste variable
                    $listevariable = $this->ListevariableindividuManager->findById($value->id_liste_variable);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['listevariable'] = $listevariable;
                }
            }           
        } else {
            if ($id) {
				// Selection par id
                $data = array();
                $data = $this->VariableindividuManager->findById($id);
            } else {
				// Selection de tous les enregistrements
                $menu = $this->VariableindividuManager->findAll();
                if ($menu) {
                    foreach ($menu as $key => $value) {
                        $listevariable = array();
                        $listevariable = $this->ListevariableindividuManager->findById($value->id_liste_variable);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['description'] = $value->description;
                        $data[$key]['id_liste_variable'] = $value->id_liste_variable;
                        $data[$key]['listevariable'] = $listevariable;
                    }
                } else
                    $data = array();
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
    //insertion,modification,suppression détail variable
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        if ($supprimer == 0) {
            if ($id == 0) {
				// Nouvel enregistrement
                $data = array(
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_liste_variable' => $this->post('id_liste_variable')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->VariableindividuManager->add($data);
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
                $data = array(
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_liste_variable' => $this->post('id_liste_variable')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->VariableindividuManager->update($id, $data);
                if(!is_null($update)) {
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
            $delete = $this->VariableindividuManager->delete($id);         
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