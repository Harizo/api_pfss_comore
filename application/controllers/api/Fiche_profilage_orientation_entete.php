<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class fiche_profilage_orientation_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_profilage_orientation_entete_model', 'Fiche_profilage_orientation_enteteManager');
        $this->load->model('agent_ex_model', 'Agent_exManager');
        $this->load->model('menage_model', 'MenageManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_village = $this->get('id_village');
		if ($menu=='getfiche_profilage_orientation_enteteByvillage') 
        {
			$tmp = $this->Fiche_profilage_orientation_enteteManager->getfiche_profilage_orientation_enteteByvillage($id_village);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $menage = $this->MenageManager->findByIdComposition($value->id_menage);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['date_remplissage']= $value->date_remplissage;
                    $data[$key]['id_village']= $value->id_village;
                    $data[$key]['agex'] = $agex;
                    $data[$key]['menage'] = $menage;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Fiche_profilage_orientation_enteteManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Fiche_profilage_orientation_enteteManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $menage = $this->MenageManager->findById($value->id_menage);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['date_remplissage']= $value->date_remplissage;
                    $data[$key]['id_village']= $value->id_village;
                    $data[$key]['agex'] = $agex;
                    $data[$key]['menage'] = $menage;
                }
				//$data=$tmp;
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

    public function index_post() 
    {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        $etat_download = $this->post('etat_download') ;

		$data = array(
			
            'id_menage'     => $this->post('id_menage'),
            'date_remplissage'   => $this->post('date_remplissage'),
            'id_agex'=> $this->post('id_agex'),
            'id_village'      => $this->post('id_village')
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
                $dataId = $this->Fiche_profilage_orientation_enteteManager->add($data);              
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
            } 
            else 
            {
                
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Fiche_profilage_orientation_enteteManager->update($id, $data);              
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
        } 
        else 
        {
            if (!$id) 
            {
                $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
            }

            $delete = $this->Fiche_profilage_orientation_enteteManager->delete($id);   

            if (!is_null($delete)) 
            {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            }
            else 
            {
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