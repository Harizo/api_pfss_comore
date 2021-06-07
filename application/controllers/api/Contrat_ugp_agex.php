<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contrat_ugp_agex extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_ugp_agex_model', 'cuaMng');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $get_mdp_en_retard = $this->get('get_mdp_en_retard');
        $get_all = $this->get('get_all');
        $id_sous_projet = $this->get('id_sous_projet');
        $data =array();
		
        if ($id_sous_projet) 
        {
			$tmp = $this->cuaMng->findById_sous_projet($id_sous_projet);
			if($tmp) 
            {
				$data=$tmp;
                $taiza='taoid';
			}
		}

		if ($id) 
        {
			$tmp = $this->cuaMng->findById($id);
			if($tmp) 
            {
				$data=$tmp;
                $taiza='taoid';
			}
		} 

        if($get_mdp_en_retard) 
        {           
            $tmp = $this->cuaMng->get_mdp_en_retard();
            if ($tmp) 
            {
                $data=$tmp;
          

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
			
            'numero_contrat'            => $this->post('numero_contrat'),
            'id_agex'                   => $this->post('id_agex'),
            'id_sous_projet'            => $this->post('id_sous_projet'),
            'objet_contrat'             => $this->post('objet_contrat'),
            'montant_contrat'           => $this->post('montant_contrat'),
            'date_signature'            => $this->post('date_signature'),
            'date_prevu_fin_contrat'    => $this->post('date_prevu_fin_contrat'),
            'status_contrat'            => $this->post('status_contrat'),
            'note_resiliation'          => $this->post('note_resiliation'),
            'etat_validation'           => $this->post('etat_validation')
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