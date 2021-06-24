<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class fiche_collection_donnee_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_collection_donnee_ebe_model', 'Fiche_collection_donnee_ebeManager');
        $this->load->model('outils_utilise_sensibilisation_model', 'Outils_utilise_sensibilisationManager');
        $this->load->model('theme_sensibilisation_model', 'Theme_sensibilisationManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_realisation_ebe = $this->get('id_realisation_ebe');
		if ($menu=='getfiche_collection_donnee_ebeByrealisation') 
        {
			$tmp = $this->Fiche_collection_donnee_ebeManager->getfiche_collection_donnee_ebeByrealisation($id_realisation_ebe);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $outils_utilise = $this->Outils_utilise_sensibilisationManager->findById($value->id_outils_utilise);
                    $theme_sensibilisation = $this->Theme_sensibilisationManager->findById($value->id_theme_sensibilisation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['outils_utilise'] = $outils_utilise;
                    $data[$key]['theme_sensibilisation']     = $theme_sensibilisation;
                    $data[$key]['date']= $value->date;
                    $data[$key]['localite']        = $value->localite;
                    $data[$key]['nbr_femme']  = $value->nbr_femme;
                    $data[$key]['nbr_homme']  = $value->nbr_homme;
                    $data[$key]['nbr_enfant']  = $value->nbr_enfant;
                    $data[$key]['animateur']    = $value->animateur;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['id_realisation_ebe']    = $value->id_realisation_ebe;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Fiche_collection_donnee_ebeManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Fiche_collection_donnee_ebeManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $outils_utilise = $this->Outils_utilise_sensibilisationManager->findById($value->id_outils_utilise);
                    $theme_sensibilisation = $this->Theme_sensibilisationManager->findById($value->id_theme_sensibilisation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['outils_utilise'] = $outils_utilise;
                    $data[$key]['theme_sensibilisation']     = $theme_sensibilisation;
                    $data[$key]['date']= $value->date;
                    $data[$key]['localite']        = $value->localite;
                    $data[$key]['nbr_femme']  = $value->nbr_femme;
                    $data[$key]['nbr_homme']  = $value->nbr_homme;
                    $data[$key]['nbr_enfant']  = $value->nbr_enfant;
                    $data[$key]['animateur']    = $value->animateur;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['id_realisation_ebe']    = $value->id_realisation_ebe;
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
            'id_outils_utilise'     => $this->post('id_outils_utilise'),
            'date'=> $this->post('date'),
            'localite'        => $this->post('localite'),
            'nbr_femme'  => $this->post('nbr_femme'),
            'nbr_homme'  => $this->post('nbr_homme'),
            'nbr_enfant'  => $this->post('nbr_enfant'),
            'animateur'    => $this->post('animateur'),
            'observation'    => $this->post('observation'),
            'id_realisation_ebe'    => $this->post('id_realisation_ebe')
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
                $dataId = $this->Fiche_collection_donnee_ebeManager->add($data);              
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
                $update = $this->Fiche_collection_donnee_ebeManager->update($id, $data);              
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

            $delete = $this->Fiche_collection_donnee_ebeManager->delete($id);   

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