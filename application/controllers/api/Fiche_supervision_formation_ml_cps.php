<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Fiche_supervision_formation_ml_cps extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_supervision_formation_ml_cps_model', 'Fiche_supervision_formation_ml_cpsManager');
        $this->load->model('agent_ex_model', 'Agent_exManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_village = $this->get('id_village');
		if ($menu=='get_supervision_formationbyvillage') 
        {
			$tmp = $this->Fiche_supervision_formation_ml_cpsManager->get_supervision_formationbyvillage($id_village);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_village']= $value->id_village;
                    $data[$key]['date_supervision']        = $value->date_supervision;
                    $data[$key]['nom_missionaire']     = $value->nom_missionaire;
                    $data[$key]['nom_ml_cps'] = $value->nom_ml_cps;
                    $data[$key]['agex'] = $agex;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Fiche_supervision_formation_ml_cpsManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Fiche_supervision_formation_ml_cpsManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $agex = $this->Agent_exManager->findById($value->id_agex);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['id_village']= $value->id_village;
                    $data[$key]['date_supervision']        = $value->date_supervision;
                    $data[$key]['nom_missionaire']     = $value->nom_missionaire;
                    $data[$key]['nom_ml_cps'] = $value->nom_ml_cps;
                    $data[$key]['agex'] = $agex;;
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
			
            'id_village'     => $this->post('id_village'),
            'date_supervision'   => $this->post('date_supervision'),
            'nom_missionaire'       => $this->post('nom_missionaire'),
            'id_agex'     => $this->post('id_agex'),
            'nom_ml_cps'   => $this->post('nom_ml_cps')
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
                $dataId = $this->Fiche_supervision_formation_ml_cpsManager->add($data);              
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
                $update = $this->Fiche_supervision_formation_ml_cpsManager->update($id, $data);              
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

            $delete = $this->Fiche_supervision_formation_ml_cpsManager->delete($id);   

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