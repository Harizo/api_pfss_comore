<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_contrat_agep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_agep_model', 'Contrat_agepManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_sous_projet = $this->get('id_sous_projet');
        $data=array();
        if ($id_sous_projet)
        {
           $contrat_agep = $this->Contrat_agepManager->countAllById_sous_projet_encours($id_sous_projet);          
            $data = $contrat_agep;
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
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
