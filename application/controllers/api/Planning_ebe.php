<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Planning_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('planning_ebe_model', 'Planning_ebeManager');
        $this->load->model('groupe_mlpl_model', 'Groupe_ml_plManager');
        $this->load->model('theme_sensibilisation_model', 'Theme_sensibilisationManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_village = $this->get('id_village');
		if ($menu=='getgroupeByvillagewithnbr_membre') 
        {
			$tmp = $this->Groupe_ml_plManager->getgroupeByvillagewithnbr_membre($id_village);
			if ($tmp) 
            {   
				$data=$tmp;
			}
		} 
        elseif ($menu=='getplanning_ebeByvillage') 
        {
			$tmp = $this->Planning_ebeManager->getplanning_ebeByvillage($id_village);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $groupe_ml_pl = $this->Groupe_ml_plManager->findByIdwithnbr_membre($value->id_groupe_ml_pl);
                    $theme_sensibilisation = $this->Theme_sensibilisationManager->findById($value->id_theme_sensibilisation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['groupe_ml_pl'] = $groupe_ml_pl;
                    $data[$key]['theme_sensibilisation']     = $theme_sensibilisation;
                    $data[$key]['numero']= $value->numero;
                    $data[$key]['duree']        = $value->duree;
                    $data[$key]['date_ebe']  = $value->date_ebe;
                    $data[$key]['lieu']    = $value->lieu;
                    $data[$key]['id_village']    = $value->id_village;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Planning_ebeManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Planning_ebeManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $groupe_ml_pl = $this->Groupe_ml_plManager->findByIdwithnbr_membre($value->id_groupe_ml_pl);
                    $theme_sensibilisation = $this->Theme_sensibilisationManager->findById($value->id_theme_sensibilisation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['groupe_ml_pl'] = $groupe_ml_pl;
                    $data[$key]['theme_sensibilisation']     = $theme_sensibilisation;
                    $data[$key]['numero']= $value->numero;
                    $data[$key]['duree']        = $value->duree;
                    $data[$key]['date_ebe']  = $value->date_ebe;
                    $data[$key]['lieu']    = $value->lieu;
                    $data[$key]['id_village']    = $value->id_village;
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
			
            'id_theme_sensibilisation'     => $this->post('id_theme_sensibilisation'),
            'id_groupe_ml_pl'   => $this->post('id_groupe_ml_pl'),
            'numero'=> $this->post('numero'),
            'date_ebe'      => $this->post('date_ebe'),
            'duree'       => $this->post('duree'),
            'lieu'     => $this->post('lieu'),
            'id_village'     => $this->post('id_village')
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
                $dataId = $this->Planning_ebeManager->add($data);              
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
                $update = $this->Planning_ebeManager->update($id, $data);              
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

            $delete = $this->Planning_ebeManager->delete($id);   

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