<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Formation_tech_base_menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('formation_tech_base_menage_model', 'cuaMng');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_theme_formation = $this->get('id_theme_formation');
        $id_village = $this->get('id_village');
        $get_all = $this->get('get_all');
        
        $data =array();
		
        

		if ($id_village && $id_theme_formation) 
        {
			$tmp = $this->cuaMng->findBy_theme_and_village($id_village ,$id_theme_formation);
			if($tmp) 
            {
				$data=$tmp;
                $taiza='taoid';
			}
		} 

        

        if($get_all) 
        {			
			$tmp = $this->cuaMng->findAll();
			if ($tmp) 
            {
				$data=$tmp;
          

			}
		}
        
		
        if ($data) 
        {
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


            'id_theme_formation_detail'             => $this->post('id_theme_formation_detail'),
            'id_village'                            => $this->post('id_village'),
            'date'                                  => $this->post('date'),
            'contenu'                               => $this->post('contenu'),
            'objectifs'                             => $this->post('objectifs'),
            'methodologies'                         => $this->post('methodologies'),
            'materiel'                              => $this->post('materiel'),
            'duree'                                 => $this->post('duree')
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
                $dataId = $this->cuaMng->add($data);              
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
                $update = $this->cuaMng->update($id, $data);              
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

            $delete = $this->cuaMng->delete($id);   

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