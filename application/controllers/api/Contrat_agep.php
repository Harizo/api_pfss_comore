<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Contrat_agep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_agep_model', 'Contrat_agepManager');
        $this->load->model('sous_projet_model', 'Sous_projetManager');
        $this->load->model('agence_p_model', 'Agence_pManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$data = array();
        $menu = $this->get('menu');
        $id_sous_projet = $this->get('id_sous_projet');
		if ($menu=='getallcontrat_alert') 
        {
			$tmp = $this->Contrat_agepManager->getallcontrat_alert();
			if ($tmp) 
            {  
                $data=array();
                $i=0;
				foreach ($tmp as $key => $value)
                {   
                    if ($value->id_avenant_presence)
                    {
                        if ($value->id_avenant_retard)
                        {
                            $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                            $agep = $this->Agence_pManager->findById($value->id_agep);
                            $data[$i]['id']                 = $value->id;
                            $data[$i]['numero_contrat']     = $value->numero_contrat;
                            $data[$i]['agep']               = $agep;
                            $data[$i]['sous_projet']        = $sous_projet;
                            //$data[$i]['nbr_jour_restant']      = $value->nbr_jour_restant;
                            //$data[$i]['objet_contrat']      = $value->objet_contrat;
                            $data[$i]['montant_contrat']    = $value->montant_contrat;
                            $data[$i]['montant_a_effectue_prevu']    = $value->montant_a_effectue_prevu;
                            //$data[$i]['modalite_contrat']   = $value->modalite_contrat;
                            //$data[$i]['date_signature']     = $value->date_signature;
                            $data[$i]['date_prevu_fin']     = $value->date_prevu_fin;
                            //$data[$i]['noms_signataires']   = $value->noms_signataires;
                            //$data[$i]['id_sous_projet']        = $id_sous_projet;
                            //$data[$i]['statu']             = $value->statu;
                            $i++;
                        }
                    }
                    else
                    {
                        $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                        $agep = $this->Agence_pManager->findById($value->id_agep);
                        $data[$i]['id']                 = $value->id;
                        $data[$i]['numero_contrat']     = $value->numero_contrat;
                        $data[$i]['agep']               = $agep;
                        $data[$i]['sous_projet']        = $sous_projet;
                        //$data[$i]['nbr_jour_restant']      = $value->nbr_jour_restant;
                        //$data[$i]['objet_contrat']      = $value->objet_contrat;
                        $data[$i]['montant_contrat']    = $value->montant_contrat;
                        $data[$i]['montant_a_effectue_prevu']    = $value->montant_a_effectue_prevu;
                        //$data[$i]['modalite_contrat']   = $value->modalite_contrat;
                        //$data[$i]['date_signature']     = $value->date_signature;
                        $data[$i]['date_prevu_fin']     = $value->date_prevu_fin;
                        //$data[$i]['noms_signataires']   = $value->noms_signataires;
                        //$data[$i]['id_sous_projet']        = $id_sous_projet;
                        //$data[$i]['statu']             = $value->statu;
                        $i++;
                    }
                    
                }
                //$data=$data;
			}
		} 
        elseif ($menu=='getcontrat_agepBysousprojet') 
        {
			$tmp = $this->Contrat_agepManager->getcontrat_agepBysousprojet($id_sous_projet);
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    if ($value->statu=='EN COURS')
                    {
                        if ($value->nbr_jour_restant<=5)
                        {
                            if ($value->id_avenant_presence)
                            {   
                                if ($value->id_avenant_retard)
                                {
                                    $data[$key]['retard'] = true;
                                }
                                else
                                {
                                    $data[$key]['retard'] = false;
                                }
                            }
                            else
                            {
                                $data[$key]['retard'] = true;
                            }
                        }
                        else
                        {
                            $data[$key]['retard'] = false;
                        }
                    }
                    else
                    {
                        $data[$key]['retard'] = false;
                    }
                    

                    //$sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                    $agep = $this->Agence_pManager->findById($value->id_agep);
                    $data[$key]['id']                 = $value->id;
                    $data[$key]['numero_contrat']     = $value->numero_contrat;
                    $data[$key]['agep']               = $agep;
                    //$data[$key]['sous_projet']        = $sous_projet;
                    $data[$key]['nbr_jour_restant']      = $value->nbr_jour_restant;
                    $data[$key]['objet_contrat']      = $value->objet_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['montant_a_effectue_prevu']    = $value->montant_a_effectue_prevu;
                    $data[$key]['modalite_contrat']   = $value->modalite_contrat;
                    $data[$key]['date_signature']     = $value->date_signature;
                    $data[$key]['date_prevu_fin']     = $value->date_prevu_fin;
                    $data[$key]['noms_signataires']   = $value->noms_signataires;
                    $data[$key]['id_sous_projet']        = $id_sous_projet;
                    $data[$key]['statu']             = $value->statu;
                }
				//$data=$tmp;
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Contrat_agepManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Contrat_agepManager->findAll();
			if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   
                    $sous_projet = $this->Sous_projetManager->findById($value->id_sous_projet);
                    $agep = $this->Agence_pManager->findById($value->id_agep);
                    $data[$key]['id']                 = $value->id;
                    $data[$key]['numero_contrat']     = $value->numero_contrat;
                    $data[$key]['agep']               = $agep;
                    $data[$key]['sous_projet']        = $sous_projet;
                    $data[$key]['objet_contrat']      = $value->objet_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['montant_a_effectue_prevu']    = $value->montant_a_effectue_prevu;
                    $data[$key]['modalite_contrat']   = $value->modalite_contrat;
                    $data[$key]['date_signature']     = $value->date_signature;
                    $data[$key]['date_prevu_fin']     = $value->date_prevu_fin;
                    $data[$key]['noms_signataires']   = $value->noms_signataires;
                    $data[$key]['statu']             = $value->statu;
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
			
            'numero_contrat'     => $this->post('numero_contrat'),
            'id_agep'            => $this->post('id_agep'),
            'id_sous_projet'     => $this->post('id_sous_projet'),
            'objet_contrat'      => $this->post('objet_contrat'),
            'montant_contrat'      => $this->post('montant_contrat'),
            'montant_a_effectue_prevu'      => $this->post('montant_a_effectue_prevu'),
            'modalite_contrat'   => $this->post('modalite_contrat'),
            'date_signature'     => $this->post('date_signature'),
            'date_prevu_fin'    => $this->post('date_prevu_fin'),
            'noms_signataires'   => $this->post('noms_signataires'),
            'statu'             => $this->post('statu')
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
                $dataId = $this->Contrat_agepManager->add($data);              
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
                $update = $this->Contrat_agepManager->update($id, $data);              
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

            $delete = $this->Contrat_agepManager->delete($id);   

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