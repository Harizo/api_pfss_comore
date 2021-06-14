<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class fiche_profilage_besoin_formation extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_profilage_besoin_formation_model', 'Fiche_profilage_besoin_formationManager');
        $this->load->model('theme_formation_model', 'Theme_formationManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_fiche_profilage_orientation = $this->get('id_fiche_profilage_orientation');
		if ($menu=='getfiche_profilage_besoin_formationByentete') 
        {
			$tmp = $this->Fiche_profilage_besoin_formationManager->getfiche_profilage_besoin_formationByentete($id_fiche_profilage_orientation);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $type_formation = $this->Theme_formationManager->findById($value->id_type_formation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['profile']= $value->profile;
                    $data[$key]['objectif']= $value->objectif;
                    $data[$key]['duree']= $value->duree;
                    $data[$key]['type_formation'] = $type_formation;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Fiche_profilage_besoin_formationManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Fiche_profilage_besoin_formationManager->findAll();
			if ($tmp) 
            {   
				$data=$tmp;
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
            'id_type_formation'     => $this->post('id_type_formation'),
            'profile'   => $this->post('profile'),
            'objectif'=> $this->post('objectif'),
            'duree'=> $this->post('duree'),
            'id_fiche_profilage_orientation'      => $this->post('id_fiche_profilage_orientation')
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
                $dataId = $this->Fiche_profilage_besoin_formationManager->add($data);              
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
                $update = $this->Fiche_profilage_besoin_formationManager->update($id, $data);              
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

            $delete = $this->Fiche_profilage_besoin_formationManager->delete($id);   

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