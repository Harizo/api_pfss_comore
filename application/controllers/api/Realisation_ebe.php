<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class realisation_ebe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('realisation_ebe_model', 'Realisation_ebeManager');
        $this->load->model('contrat_consultant_ong_model', 'Contrat_consultant_ongManager');
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
                    $contrat_consultant_ong = $this->Contrat_consultant_ongManager->findByIdwithcle($value->id_contrat_consultant_ong);
                    $data[$key]['id']         = $value->id;
                    $data[$key]['numero']     = $value->numero;
                    $data[$key]['but_regroupement']= $value->but_regroupement;
                    $data[$key]['lieu']        = $value->lieu;
                    $data[$key]['date_regroupement']  = $value->date_regroupement;
                    $data[$key]['materiel']    = $value->materiel;
                    $data[$key]['id_groupe_ml_pl']     = $value->id_groupe_ml_pl;
                    $data[$key]['contrat_consultant_ong'] = $contrat_consultant_ong;
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
                    $data[$key]['numero']     = $value->numero;
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
			
            'numero'     => $this->post('numero'),
            'id_groupe_ml_pl'   => $this->post('id_groupe_ml_pl'),
            'id_contrat_consultant_ong'=> $this->post('id_contrat_consultant_ong'),
            'but_regroupement'      => $this->post('but_regroupement'),
            'lieu'       => $this->post('lieu'),
            'date_regroupement'     => $this->post('date_regroupement'),
            'materiel'   => $this->post('materiel')
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