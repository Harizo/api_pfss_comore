<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Mdp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mdp_model', 'mdpMng');
    }

    public function index_get() {
        $id = $this->get('id');
        $type = $this->get('type');
		$data = array();
        

		if ($id) 
        {
			$tmp = $this->mdpMng->findById($id);
			if($tmp) 
            {
				$data=$tmp;
                
			}
		} 

        if($type)
        {			
			$tmp = $this->mdpMng->findAll($type);
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
		

            'type'                                      => $this->post('type'),
            'intitule_micro_projet'                     => $this->post('intitule_micro_projet'),
            'numero_vague_zip'                          => $this->post('numero_vague_zip'),
            'cout_total_sous_projet'                    => $this->post('cout_total_sous_projet'),
            'cout_total_agr'                            => $this->post('cout_total_agr'),
            'renumeration_enex'                         => $this->post('renumeration_enex'),
            'date_approbation_ser_deg'                  => $this->post('date_approbation_ser_deg'),
            'objectif_micro_projet'                     => $this->post('objectif_micro_projet'),
            'description_sous_projet'                   => $this->post('description_sous_projet'),
            'context_justification'                     => $this->post('context_justification'),
            'mdp_cout_investissement_agr'               => $this->post('mdp_cout_investissement_agr'),
            'mdp_cout_investissement_agr_formation'     => $this->post('mdp_cout_investissement_agr_formation')
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
                $dataId = $this->mdpMng->add($data);              
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
                $update = $this->mdpMng->update($id, $data);              
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

            $delete = $this->mdpMng->delete($id);   

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