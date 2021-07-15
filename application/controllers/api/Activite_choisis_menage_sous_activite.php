<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Activite_choisis_menage_sous_activite extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('activite_choisis_menage_sous_activite_model', 'fpriManager');
        $this->load->model('menage_model', 'menageManager');

        $this->load->model('ile_model', 'ileManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'villageManager');
        $this->load->model('theme_formation_model', 'ThemeformationManager');
        $this->load->model('zip_model', 'ZipManager');
      
    }
    public function index_get() {

        $id_menage = $this->get('id_menage');
        $id_theme_formation = $this->get('id_theme_formation');
    

        $data = array() ;
   
		if ($id_theme_formation && $id_menage) 
        {
			
			$data = $this->fpriManager->get_all_by_menage($id_theme_formation, $id_menage);

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
        $etat_save_all = $this->post('etat_save_all') ;
		$data = array(
			

            'id_theme_formation_detail'             => $this->post('id_theme_formation_detail'),
            'id_menage'                             => $this->post('id_menage')
		);   

        if ($etat_save_all) 
        {
            $all_menage =  json_decode($this->post('all_menage'));

            foreach ($all_menage as $key => $value) 
            {
                $data = array(

                    'id_theme_formation_detail'             => $this->post('id_theme_formation_detail'),
                    'id_menage'                             => $value->id_menage
                );  

                $dataId = $this->fpriManager->add($data);

                if (count($all_menage) == ($key+1)) 
                {
                    $this->response([
                            'status' => TRUE,
                            'response' => $all_menage,
                            'message' => 'Data insert success'
                                ], REST_Controller::HTTP_OK);
                }
            }
        }    
        else
        {

            if ($supprimer == 0) {
                if ($id == 0) {
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
    				// Ajout d'un enregistrement
                    $dataId = $this->fpriManager->add($data);
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
    				// Mise à jour d'un enregistrement
                    $update = $this->fpriManager->update($id, $data);              
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
            } 
            else 
            {
                if (!$id) {
                $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
    			// Suppression d'un enregistrement
                $delete = $this->fpriManager->delete($id);          
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
}
?>