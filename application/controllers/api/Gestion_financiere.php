<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Gestion_financiere extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gestion_financiere_model', 'GfmManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $date_debut = $this->get('date_debut');
        $date_fin = $this->get('date_fin');
        $id_village = $this->get('id_village');
        $etat_sortie = $this->get('etat_sortie');
        $etat_choisis = $this->get('etat_choisis');
        $id = $this->get('id');
		$data = array();
        

		if ($etat_sortie) 
        {
			if ($etat_choisis == 'situtation_composante') 
            {
                $data = $this->GfmManager->situtation_composante($date_debut, $date_fin);
            }

            if ($etat_choisis == 'situtation_activite_global') 
            {
                $data = $this->GfmManager->situtation_activite_global($date_debut, $date_fin);
            }

            if ($etat_choisis == 'situtation_activite') 
            {
                $data = $this->GfmManager->situtation_activite($date_debut, $date_fin, $id_village);
            }
		} 
        else 
        {			
			$tmp = $this->GfmManager->findAll_detail($date_debut, $date_fin);
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
			

            'date'                  => $this->post('date'),
            'id_composante'         => $this->post('id_composante'),
            'zip'         => $this->post('zip'),
            'vague'         => $this->post('vague'),
            'id_sous_rubrique'        => $this->post('id_sous_rubrique'),
            'id_village'            => $this->post('id_village'),
            'montant_engage'        => $this->post('montant_engage'),
            'montant_paye'          => $this->post('montant_paye')
		);               
        if ($supprimer == 0) 
        {
            if ($id == 0) 
            {
                if (!$data) 
                {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->GfmManager->add($data);              
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
                $update = $this->GfmManager->update($id, $data);              
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
        } else {
            if (!$id) {
            $this->response([
            'status' => FALSE,
            'response' => 0,
            'message' => 'No request found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->GfmManager->delete($id);          
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
?>