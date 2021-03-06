<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Realisation_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('realisation_ebe_model', 'Realisation_ebeManager');
        $this->load->model('contrat_ugp_agex_model', 'Contrat_ugp_agexManager');
        $this->load->model('Espace_bien_etre_model', 'Espace_bien_etreManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
        $id_groupe_ml_pl = $this->get('id_groupe_ml_pl');
		if ($menu=='getrealisation_ebeBysousprojetml_pl') 
        {
			$tmp = $this->Realisation_ebeManager->getrealisation_ebeBysousprojetml_pl($id_sous_projet,$id_groupe_ml_pl);
			if ($tmp) 
            {   
				foreach ($tmp as $key => $value)
                {   
                    $contrat_agex = $this->Contrat_ugp_agexManager->findByIdobjet($value->id_contrat_agex);
                    $espace_bien_etre = $this->Espace_bien_etreManager->findByIdobjet($value->id_espace_bien_etre);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['espace_bien_etre']     = $espace_bien_etre;
                    $data[$key]['but_regroupement']= $value->but_regroupement;
                    $data[$key]['lieu']        = $value->lieu;
                    $data[$key]['date_regroupement']  = $value->date_regroupement;
                    $data[$key]['date_edition']  = $value->date_edition;
                    $data[$key]['materiel']    = $value->materiel;
                    $data[$key]['id_groupe_ml_pl']     = $value->id_groupe_ml_pl;
                    $data[$key]['contrat_agex'] = $contrat_agex;
                }
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Realisation_ebeManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Realisation_ebeManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                    $data[$key]['id']                 = $value->id;
                    $data[$key]['id_espace_bien_etre']     = $value->id_espace_bien_etre;
                    $data[$key]['but_regroupement']      = $value->but_regroupement;
                    $data[$key]['lieu']    = $value->lieu;
                    $data[$key]['date_regroupement']     = $value->date_regroupement;
                    $data[$key]['materiel']     = $value->materiel;
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
			
            'id_espace_bien_etre'     => $this->post('id_espace_bien_etre'),
            'id_groupe_ml_pl'   => $this->post('id_groupe_ml_pl'),
            'id_contrat_agex'=> $this->post('id_contrat_agex'),
            'but_regroupement'      => $this->post('but_regroupement'),
            'lieu'       => $this->post('lieu'),
            'date_regroupement'     => $this->post('date_regroupement'),
            'materiel'   => $this->post('materiel'),
            'date_edition'   => $this->post('date_edition')
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
                $dataId = $this->Realisation_ebeManager->add($data);              
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
                $update = $this->Realisation_ebeManager->update($id, $data);              
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

            $delete = $this->Realisation_ebeManager->delete($id);   

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