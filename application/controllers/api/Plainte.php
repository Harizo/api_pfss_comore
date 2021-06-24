<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Plainte extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('plainte_model', 'PlainteManager');
        $this->load->model('ile_model', 'ileManager');
        $this->load->model('programme_model', 'ProgrammeManager');
    }

    public function index_get() {
        $id = $this->get('id');
		$cle_etrangere= $this->get('cle_etrangere');
		$nombre_plainte= $this->get('nombre_plainte');
		$data = array();
		if ($id) {
			$tmp = $this->PlainteManager->findById($id);
			if($tmp) {
				$data=$tmp;
			}
		} else if($cle_etrangere && $nombre_plainte) {
			$data=$this->PlainteManager->NombrePlainteParVillage($cle_etrangere);
		} else if($cle_etrangere) {
			$data=$this->PlainteManager->findByVillage($cle_etrangere);
		} else {		
			$tmp = $this->PlainteManager->findAll();
			if ($tmp) {
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
        $tempo = $this->post('menage_id') ;
        $etat_download = $this->post('etat_download') ; 
		$menage_id=null;
		if($tempo && intval($tempo) >0) {
			$menage_id=$tempo;
		}
		$datedepot=null;
		if($this->post('datedepot')) {
			$datedepot=$this->post('datedepot');
		}
		$dateresolution=null;
		if($this->post('dateresolution')) {
			$dateresolution=$this->post('dateresolution');
		}
		$datemodification=null;
		if($this->post('datemodification')) {
			$datemodification=$this->post('datemodification');
		}
		$activite_id=null;
		$temporaire=$this->post('activite_id');
		if($temporaire && intval($temporaire) >0) {
			$activite_id=$temporaire;
		}
		$cellulederecours_id=null;
		$temporaire=$this->post('cellulederecours_id');
		if($temporaire && intval($temporaire) >0) {
			$cellulederecours_id=$temporaire;
		}
		$solution_id=null;
		$temporaire=$this->post('solution_id');
		if($temporaire && intval($temporaire) >0) {
			$solution_id=$temporaire;
		}
		$tranche_id=null;
		$temporaire=$this->post('tranche_id');
		if($temporaire && intval($temporaire) >0) {
			$tranche_id=$temporaire;
		}
		$data = array(
            'menage_id'                 => $menage_id,
            'activite_id'               => $activite_id,
            'id_sous_projet'            => $this->post('id_sous_projet'),
            'cellulederecours_id'       => $cellulederecours_id,
            'typeplainte_id'            => $this->post('typeplainte_id'),
            'solution_id'               => $solution_id,
            'village_id'                => $this->post('village_id'),
            'programme_id'              => $this->post('programme_id'),
            'Objet'                     => $this->post('Objet'),
            'datedepot'                 => $datedepot,
            'reference'                 => $this->post('reference'),
            'nomplaignant'              => $this->post('nomplaignant'),
            'adresseplaignant'          => $this->post('adresseplaignant'),
            'responsableenregistrement' => $this->post('responsableenregistrement'),
            'mesureprise'               => $this->post('mesureprise'),
            'dateresolution'            => $dateresolution,
            'statut'                    => $this->post('statut'),
            'telephone'                 => $this->post('telephone'),
            'a_ete_modifie'             => $this->post('a_ete_modifie'),
            'supprime'                  => $this->post('supprime'),
            'userid'                    => $this->post('userid'),
            'datemodification'          => $datemodification,
            'tranche_id'                => $tranche_id,
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
                $dataId = $this->PlainteManager->add($data);              
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
                if ($etat_download) 
                {
                    if (!$data) {
                        $this->response([
                            'status' => FALSE,
                            'response' => 0,
                            'message' => 'No request found'
                                ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                    $dataId = $this->PlainteManager->add_down($data, $id);              
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
                    $update = $this->PlainteManager->update($id, $data);              
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
        } else {
            if (!$id) {
            $this->response([
            'status' => FALSE,
            'response' => 0,
            'message' => 'No request found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->PlainteManager->delete($id);          
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