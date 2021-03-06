<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Menage_beneficiaire extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('menage_beneficiaire_model', 'MenagebeficiaireManager');
        $this->load->model('menage_model', 'menageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $id_sous_projet = $this->get('id_sous_projet');
        $village_id = $this->get('village_id');
        $menu = $this->get('menu');
        $id_sous_projet_2 = $this->get('id_sous_projet_2');
        $data = array() ;
        if ($menu=="getmenageBysous_projet")
        {
            $menage = $this->MenagebeficiaireManager->getmenageBysous_projet($id_sous_projet_2);          
            if ($menage) {
                $data = $menage;               
            }
        } elseif ($cle_etrangere) {
			// Selection des enregistrements par ménage
            $menage_programme = $this->MenagebeficiaireManager->findAllByMenage($cle_etrangere);          
            if ($menage_programme) {
                $data['id'] = ($menage_programme->id);
                $data['id_menage'] = ($menage_programme->id_menage);
                $data['id_sous_projet'] = ($menage_programme->id_sous_projet);                
                $data['date_sortie'] = ($menage_programme->date_sortie);                
                $data['motif_sortie'] = ($menage_programme->motif_sortie);                
                $data['date_inscription'] = ($menage_programme->date_inscription);                
            }
        } else {
            if ($id_sous_projet && $village_id) {  
                $id_prog = "'%".'"'.$id_sous_projet.'"'."%'" ;
				// Selection des ménage par programme et par fokontany
                $list_menage = $this->MenagebeficiaireManager->findAllBySousprojetAndVillage($id_sous_projet,$village_id);
                if ($list_menage)  {
                    foreach ($list_menage as $key => $value)  {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['id_menage'] = ($value->id_menage);
                        $data[$key]['nom'] = ($value->nom);
                        $data[$key]['prenom'] = ($value->prenom);
                        $data[$key]['date_naissance'] = ($value->date_naissance);
                        $data[$key]['cin'] = ($value->cin);
                        $data[$key]['profession'] = ($value->profession);
                        $data[$key]['date_inscription'] = ($value->date_inscription);
                        $data[$key]['id_sous_projet'] = ($value->id_sous_projet);
                        $data[$key]['date_sortie'] = $value->date_sortie;
                        $data[$key]['motif_sortie'] = $value->motif_sortie;
                        $data[$key]['date_inscription'] = ($value->date_inscription);
                        $data[$key]['detail_suivi_menage'] = array();
                        $data[$key]['detail_charge'] = 0;
                    }
                }				
			} else	if ($id_sous_projet) {
                $id_prog = '"'.$id_sous_projet.'"' ;
				// Selection ménage par programme
                $list_menage_programme = $this->MenagebeficiaireManager->findAllByProgramme($id_prog);
                if ($list_menage_programme) {
                    foreach ($list_menage_programme as $key => $value) {
                        $data[$key]['id'] = $value->id;
                        $data[$key]['NomInscrire'] = ($value->NomInscrire);
                        $data[$key]['PersonneInscription'] = ($value->PersonneInscription);
                        $data[$key]['AgeInscrire'] = ($value->AgeInscrire);
                        $data[$key]['Addresse'] = ($value->Addresse);
                        $data[$key]['NumeroEnregistrement'] = ($value->NumeroEnregistrement);
                        $data[$key]['id_sous_projet'] = ($id_sous_projet);
                        $data[$key]['date_sortie'] = ($value->date_sortie);
                        $data[$key]['motif_sortie'] = ($value->motif_sortie);
                        $data[$key]['date_inscription'] = ($value->date_inscription);
                    }
                }
            } else {
                if ($id) {
					// Selection ménage par id (id=clé primaire)
                    $data = $this->MenagebeficiaireManager->findById($id);
                } else {
					// Selection de tous les ménages
                    $data = $this->MenagebeficiaireManager->findAll();                   
                }
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
        $sortie_programme = $this->post('sortie_programme') ;
		$data = array(
			'id_menage' => $this->post('id_menage'),
			'id_sous_projet' => ($this->post('id_sous_projet')),
			'date_sortie' => ($this->post('date_sortie')),
			'date_inscription' => ($this->post('date_inscription')),
			'motif_sortie' => ($this->post('motif_sortie')),
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
				// Ajout d'un enregistrement
                $dataId = $this->MenagebeficiaireManager->add($data);
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
            } else {
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Mise à jour d'un enregistrement
				if($sortie_programme) {
					$data = array(
						'statut' => ('SORTI'),
					);               
					$updates = $this->menageManager->update_sortie($this->post('id_menage'), $data);
					$data = array(
						'date_sortie' => ($this->post('date_sortie')),
						'motif_sortie' => ($this->post('motif_sortie')),
					);               
					$update = $this->MenagebeficiaireManager->update_sortie($this->post('id_menage'),$this->post('id_sous_projet'), $data);
				} else {
					$update = $this->MenagebeficiaireManager->update($id, $data);
				}		
                if(!is_null($update)){
                    $this->response([
                        'status' => TRUE, 
                        'response' => $id,
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
			// Suppression d'un enregistrement
            $delete = $this->MenagebeficiaireManager->delete($id);          
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