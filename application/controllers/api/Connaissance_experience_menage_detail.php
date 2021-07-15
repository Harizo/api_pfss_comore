<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Connaissance_experience_menage_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('connaissance_experience_menage_detail_model', 'Connaissance_experience_menage_detailManager');
    }

    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
		$data = array();
        

		if ($cle_etrangere) 
        {
			$tmp = $this->Connaissance_experience_menage_detailManager->findByficheprofilage($cle_etrangere);
			if($tmp) 
            {
				foreach ($tmp as $key => $value)
                {
                    $activite_realise_auparavant = false;
                    
                    $formation_mar = false;
                    $formation_pep = false;
                    $formation_cul = false;
                    $formation_tra_act1 = false;
                    $formation_tra_act3 = false;
                    $formation_cap = false;
                    $formation_avi = false;
                    $formation_bov = false;
                    $formation_tec = false;
                    $formation_aut_act1 = false;
                    $formation_aut_act2 = false;
                    $formation_aut_act3 = false;

                    $data[$key]['id'] = $value->id;
                    $data[$key]['activite_realise_auparavant_description'] = $value->activite_realise_auparavant_description;
                    $data[$key]['id_activite_realise_auparavant_prevu'] = $value->id_activite_realise_auparavant_prevu;
                    $data[$key]['id_activite_realise_auparavant'] = $value->id_activite_realise_auparavant;
                    $data[$key]['autre_activite_realise_auparavant'] = $value->autre_activite_realise_auparavant;
                    $data[$key]['difficulte_rencontre'] = $value->difficulte_rencontre;
                    $data[$key]['nbr_annee_activite'] = $value->nbr_annee_activite;
                    $data[$key]['autre_activite_realise_auparavant'] = $value->autre_activite_realise_auparavant;
                    $data[$key]['formation_acquise'] = unserialize($value->formation_acquise);
                    if ($value->id_activite_realise_auparavant)
                    {
                        $activite_realise_auparavant = true;
                    }                    
                    $data[$key]['activite_realise_auparavant'] = $activite_realise_auparavant;
                    $formation=unserialize($value->formation_acquise);
                    if ($formation)
                    {   
                        foreach ($formation as $value)
                        {
                            if ($value=='mar')
                            {
                                $formation_mar = true;
                            }
                            if ($value=='pep')
                            {                         
                                $formation_pep = true;
                            }
                            if ($value=='cul')
                            {                         
                                $formation_cul = true;                            
                            }
                            if ($value=='tra_act1')
                            {
                                $formation_tra_act1 = true;                            
                            }
                            if ($value=='tra_act3')
                            {
                                $formation_tra_act3 = true;                            
                            }
                            if ($value=='cap')
                            {
                                $formation_cap = true;                            
                            }
                            if ($value=='avi')
                            {
                                $formation_avi = true;                            
                            }
                            if ($value=='bov')
                            {
                                $formation_bov = true;                            
                            }
                            if ($value=='tec')
                            {
                                $formation_tec = true;
                            }
                            if ($value=='aut_act1')
                            {
                                $formation_aut_act1 = true;                            
                            }
                            if ($value=='aut_act2')
                            {
                                $formation_aut_act2 = true;                            
                            }
                            if ($value=='aut_act3')
                            {
                                $formation_aut_act3 = true;                            
                            }
                        }
                    }
                    
                    $data[$key]['formation_acquise_mar'] = $formation_mar;
                    $data[$key]['formation_acquise_pep'] = $formation_pep;
                    $data[$key]['formation_acquise_cul'] = $formation_cul;
                    $data[$key]['formation_acquise_tra_act1'] = $formation_tra_act1;
                    $data[$key]['formation_acquise_tra_act3'] = $formation_tra_act3;
                    $data[$key]['formation_acquise_cap'] = $formation_cap;
                    $data[$key]['formation_acquise_avi'] = $formation_avi;
                    $data[$key]['formation_acquise_bov'] = $formation_bov;
                    $data[$key]['formation_acquise_tec'] = $formation_tec;
                    $data[$key]['formation_acquise_aut_act1'] = $formation_aut_act1;
                    $data[$key]['formation_acquise_aut_act2'] = $formation_aut_act2;
                    $data[$key]['formation_acquise_aut_act3'] = $formation_aut_act3;
                    
                    
                }
                //$data=$tmp;
			}
		} 
        elseif ($id) 
        {
			$tmp = $this->Connaissance_experience_menage_detailManager->findById($id);
			if($tmp) 
            {
				$data=$tmp;
			}
		} 
        else 
        {			
			$tmp = $this->Connaissance_experience_menage_detailManager->findAll();
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

    
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;        
        $getformation_acquise = $this->post('formation_acquise');
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_activite_realise_auparavant' => $this->post('id_activite_realise_auparavant'),
                    'id_fiche_profilage_orientation' => $this->post('id_fiche_profilage_orientation'),
                    'difficulte_rencontre' => $this->post('difficulte_rencontre'),
                    'nbr_annee_activite' => $this->post('nbr_annee_activite'),
                    'autre_activite_realise_auparavant' => $this->post('autre_activite_realise_auparavant'),
                    'formation_acquise' => serialize($getformation_acquise)
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Connaissance_experience_menage_detailManager->add($data);
                
                if (intval($this->post('id_activite_realise_auparavant'))==8)
                {
                    $delete_autreque_neant = $this->Connaissance_experience_menage_detailManager->delete_autreque_neant($this->post('id_fiche_profilage_orientation'));
                }
                if (intval($this->post('id_activite_realise_auparavant'))!=8)
                {
                    $delete_neant = $this->Connaissance_experience_menage_detailManager->delete_neant($this->post('id_fiche_profilage_orientation'));
                }
                if (!is_null($dataId))  {
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
            } else {
                $data = array(
                    'id_activite_realise_auparavant' => $this->post('id_activite_realise_auparavant'),
                    'id_fiche_profilage_orientation' => $this->post('id_fiche_profilage_orientation'),
                    'difficulte_rencontre' => $this->post('difficulte_rencontre'),
                    'nbr_annee_activite' => $this->post('nbr_annee_activite'),
                    'autre_activite_realise_auparavant' => $this->post('autre_activite_realise_auparavant'),
                    'formation_acquise' => serialize($getformation_acquise)
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Connaissance_experience_menage_detailManager->update($id, $data);
                if(!is_null($update)) {
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
            $delete = $this->Connaissance_experience_menage_detailManager->delete($id);
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