<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Formation_ml extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('formation_ml_model', 'Formation_mlManager');
        $this->load->model('contrat_ugp_agex_model', 'Contrat_ugp_agexManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        $id_commune = $this->get('id_commune');
		if ($menu=='getformation_mlBysousprojetcommune') 
        {
			$tmp = $this->Formation_mlManager->getformation_mlBysousprojetcommune($id_sous_projet,$id_commune);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $contrat_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['numero']     = $value->numero;
                    $data[$key]['description']= $value->description;
                    $data[$key]['lieu']        = $value->lieu;
                    $data[$key]['date_debut']  = $value->date_debut;
                    $data[$key]['date_fin']    = $value->date_fin;
                    $data[$key]['id_commune']     = $value->id_commune;
                    $data[$key]['formateur']     = $value->formateur;
                    $data[$key]['date_edition']     = $value->date_edition;
                    $data[$key]['outils_didactique']     = $value->outils_didactique;
                    $data[$key]['probleme']     = $value->probleme;
                    $data[$key]['solution']     = $value->solution;
                    $data[$key]['contrat_agex'] = $contrat_agex;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Formation_mlManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Formation_mlManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                    $data[$key]['id']                 = $value->id;
                    $data[$key]['numero']     = $value->numero;
                    $data[$key]['description']      = $value->description;
                    $data[$key]['lieu']    = $value->lieu;
                    $data[$key]['date_debut']     = $value->date_debut;
                    $data[$key]['date_fin']     = $value->date_fin;
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
			
            'numero'     => $this->post('numero'),
            'id_commune'            => $this->post('id_commune'),
            'id_contrat_agex'     => $this->post('id_contrat_agex'),
            'description'      => $this->post('description'),
            'lieu'      => $this->post('lieu'),
            'date_debut'     => $this->post('date_debut'),
            'date_fin'    => $this->post('date_fin'),            
            'formateur'     => $this->post('formateur'),
            'date_edition'     => $this->post('date_edition'),
            'outils_didactique'     => $this->post('outils_didactique'),
            'probleme'     => $this->post('probleme'),
            'solution'     => $this->post('solution')
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
                $dataId = $this->Formation_mlManager->add($data);              
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
                $update = $this->Formation_mlManager->update($id, $data);              
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

            $delete = $this->Formation_mlManager->delete($id);   

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