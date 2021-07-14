<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Formation_thematique_suivi_agex_activite extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('formation_thematique_suivi_agex_activite_model', 'Formation_thematique_suivi_agex_activiteManager');
        $this->load->model('contrat_ugp_agex_model', 'Contrat_ugp_agexManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        //$id_sous_projet = $this->get('id_sous_projet');
		if ($menu=='getformation_thematique_suivi_agex_activite') 
        {
			$tmp = $this->Formation_thematique_suivi_agex_activiteManager->getformation_thematique_suivi_agex_activite();
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $contrat_ugp_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $theme_formation = $this->Formation_thematique_suivi_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['nbr_participant']         = $value->nbr_participant;
                    $data[$key]['nbr_femme']         = $value->nbr_femme;
                    $data[$key]['theme_formation']    = $theme_formation;
                    $data[$key]['periode_prevu']         = $value->periode_prevu;
                    $data[$key]['periode_realisation']   = $value->periode_realisation;
                    $data[$key]['beneficiaire']     = $value->beneficiaire;
                    $data[$key]['nbr_beneficiaire_cible']  = $value->nbr_beneficiaire_cible;
                    $data[$key]['formateur']    = $value->formateur;
                    $data[$key]['observation']  = $value->observation;
                    $data[$key]['contrat_agex'] = $contrat_ugp_agex;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Formation_thematique_suivi_agex_activiteManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Formation_thematique_suivi_agex_activiteManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $contrat_ugp_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $theme_formation = $this->Formation_thematique_suivi_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                   // $nbr = $this->Formation_thematique_suivi_agex_activiteManager->findTheme_formationById($value->id_theme_formation);
                   $data[$key]['id']         = $value->id;
                    $data[$key]['nbr_participant']         = $value->nbr_participant;
                    $data[$key]['nbr_femme']         = $value->nbr_femme;
                    $data[$key]['theme_formation']    = $theme_formation;
                    $data[$key]['periode_prevu']         = $value->periode_prevu;
                    $data[$key]['periode_realisation']   = $value->periode_realisation;
                    $data[$key]['beneficiaire']     = $value->beneficiaire;
                    $data[$key]['nbr_beneficiaire_cible']  = $value->nbr_beneficiaire_cible;
                    $data[$key]['formateur']    = $value->formateur;
                    $data[$key]['observation']  = $value->observation;
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
            'periode_prevu'         => $this->post('periode_prevu'),
            'periode_realisation'   => $this->post('periode_realisation'),
            'beneficiaire'     => $this->post('beneficiaire'),
            'nbr_beneficiaire_cible'         => $this->post('nbr_beneficiaire_cible'),
            'nbr_participant'         => $this->post('nbr_participant'),
            'nbr_femme'         => $this->post('nbr_femme'),
            'formateur'         => $this->post('formateur'),
            'observation'       => $this->post('observation'),
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
                $dataId = $this->Formation_thematique_suivi_agex_activiteManager->add($data);              
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
                $update = $this->Formation_thematique_suivi_agex_activiteManager->update($id, $data);              
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

            $delete = $this->Formation_thematique_suivi_agex_activiteManager->delete($id);   

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