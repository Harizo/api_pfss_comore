<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_contrat_agep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_agep_model', 'Contrat_agepManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_sous_projet = $this->get('id_sous_projet');
        $menu = $this->get('menu');
        $id_sous_p = $this->get('id_sous_p');
        $data=array();
        if ($id_sous_projet)
        {
           $contrat_agep = $this->Contrat_agepManager->countAllById_sous_projet_encours($id_sous_projet);          
            $data = $contrat_agep;
            
        }
        if ($menu=="count_by_sp")
        {
           $contrat_agep = $this->Contrat_agepManager->countAllById_sous_projet_encours_avenant($id_sous_p);          
           // $data = $contrat_agep;
            if ($contrat_agep) 
            {  
                $data_retard=array();
                $data=array();
                $i=0;
				foreach ($contrat_agep as $key => $value)
                {   
                    if ($value->id_avenant_presence)
                    {
                        if ($value->id_avenant_retard)
                        {
                            $data[$i]['id'] = $value->id;
                            $i++;
                        }
                    }
                    else
                    {
                        $data[$i]['id'] = $value->id;
                        $i++;
                    }  
                }
                //$data=$data_retard;
			}
            else {
                $data=array();
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
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
