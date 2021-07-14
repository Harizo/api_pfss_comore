<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Formation_thematique_agex_activite extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('formation_thematique_agex_activite_model', 'Formation_thematique_agex_activiteManager');
        $this->load->model('contrat_ugp_agex_model', 'Contrat_ugp_agexManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_theme_formation = $this->get('id_theme_formation');
        //$id_sous_projet = $this->get('id_sous_projet');
		if ($menu=='gettheme_formation_datailBytheme') 
        {
			$tmp = $this->Formation_thematique_agex_activiteManager->gettheme_formation_datailBytheme($id_theme_formation);
			if ($tmp) 
            {   
				$data=$tmp;
			}
		} 
        elseif ($menu=='getformation_thematique_agex') 
        {
			$tmp = $this->Formation_thematique_agex_activiteManager->getformation_thematique_agex();
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $contrat_ugp_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $theme_formation = $this->Formation_thematique_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                    $theme_formation_detail = $this->Formation_thematique_agex_activiteManager->findTheme_formation_detailById($value->id_theme_formation_detail);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['theme_formation']    = $theme_formation;
                    $data[$key]['theme_formation_detail']    = $theme_formation_detail;
                    $data[$key]['contenu']         = $value->contenu;
                    $data[$key]['objectif']           = $value->objectif;
                    $data[$key]['methodologie']   = $value->methodologie;
                    $data[$key]['materiel']     = $value->materiel;
                    $data[$key]['date']  = $value->date;
                    $data[$key]['duree']  = $value->duree;
                    $data[$key]['contrat_agex'] = $contrat_ugp_agex;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Formation_thematique_agex_activiteManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Formation_thematique_agex_activiteManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $contrat_ugp_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $theme_formation = $this->Formation_thematique_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                   // $nbr = $this->Formation_thematique_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['theme_formation']    = $theme_formation;
                    $data[$key]['contenu']         = $value->contenu;
                    $data[$key]['objectif']           = $value->objectif;
                    $data[$key]['methodologie']   = $value->methodologie;
                    $data[$key]['materiel']     = $value->materiel;
                    $data[$key]['date']  = $value->date;
                    $data[$key]['duree']  = $value->duree;
                    $data[$key]['contrat_agex'] = $contrat_ugp_agex;
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
			
            'id_theme_formation'    => $this->post('id_theme_formation'),
            'id_theme_formation_detail'    => $this->post('id_theme_formation_detail'),
            'contenu'         => $this->post('contenu'),
            'objectif'           => $this->post('objectif'),
            'methodologie'   => $this->post('methodologie'),
            'materiel'     => $this->post('materiel'),
            'date'         => $this->post('date'),
            'duree'         => $this->post('duree'),
            'id_contrat_agex'   => $this->post('id_contrat_agex')
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
                $dataId = $this->Formation_thematique_agex_activiteManager->add($data);              
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
                $update = $this->Formation_thematique_agex_activiteManager->update($id, $data);              
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

            $delete = $this->Formation_thematique_agex_activiteManager->delete($id);   

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