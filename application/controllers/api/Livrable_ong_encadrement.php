<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Livrable_ong_encadrement extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('livrable_ong_encadrement_model', 'Livrable_ong_encadrementManager');
        $this->load->model('agent_ex_model', 'Agent_exManager');
        $this->load->model('contrat_ugp_agex_model', 'Contrat_ugp_agexManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_commune = $this->get('id_commune');
		if ($menu=='getlivrable_ong_encadrementBycommune') 
        {
			$tmp = $this->Livrable_ong_encadrementManager->getlivrable_ong_encadrementBycommune($id_commune);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $contrat_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['agex'] = $agex;
                    $data[$key]['contrat_agex']     = $contrat_agex;
                    $data[$key]['date_edition']  = $value->date_edition;
                    $data[$key]['mission']= $value->mission;
                    $data[$key]['outil_travail']        = $value->outil_travail;
                    $data[$key]['methodologie']    = $value->methodologie;
                    $data[$key]['planning']    = $value->planning;
                    $data[$key]['id_commune']  = $value->id_commune;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Livrable_ong_encadrementManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Livrable_ong_encadrementManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $contrat_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['agex'] = $agex;
                    $data[$key]['contrat_agex']     = $contrat_agex;
                    $data[$key]['date_edition']  = $value->date_edition;
                    $data[$key]['mission']= $value->mission;
                    $data[$key]['outil_travail']        = $value->outil_travail;
                    $data[$key]['methodologie']    = $value->methodologie;
                    $data[$key]['planning']    = $value->planning;
                    $data[$key]['id_commune']  = $value->id_commune;
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
			
            'id_contrat_agex'     => $this->post('id_contrat_agex'),
            'id_agex'   => $this->post('id_agex'),
            'mission'=> $this->post('mission'),
            'date_edition'      => $this->post('date_edition'),
            'outil_travail'       => $this->post('outil_travail'),
            'methodologie'     => $this->post('methodologie'),
            'planning'     => $this->post('planning'),
            'id_commune'     => $this->post('id_commune')
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
                $dataId = $this->Livrable_ong_encadrementManager->add($data);              
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
                $update = $this->Livrable_ong_encadrementManager->update($id, $data);              
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

            $delete = $this->Livrable_ong_encadrementManager->delete($id);   

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