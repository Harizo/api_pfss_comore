<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Visite_domicile extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('visite_domicile_model', 'VisitedomicileManager');
        $this->load->model('visite_domicile_raison_model', 'VisitedomicileraisonManager');
        $this->load->model('visite_domicile_menage_model', 'VisitedomicilemenageManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $data = array() ;
		if($id) {
			$data = $this->VisitedomicileManager->findById($id);
		} else if ($cle_etrangere)  {
            $temporaire = $this->VisitedomicileManager->findAllByGroupemlpl($cle_etrangere);
			if($temporaire) {
				$data = array() ;
				foreach($temporaire as $key =>$value) {
					$tmp=array();
					$tmp_raison_visite = $this->VisitedomicileraisonManager->findAllByIdvisite($value->id);
					$tmp_menage_visite = $this->VisitedomicilemenageManager->findAllByIdvisite($value->id);
					$tmp["id"] =$value->id;
					$tmp["id_groupe_ml_pl"] =$value->id_groupe_ml_pl;
					$tmp["numero"] =$value->numero;
					$tmp["date_visite1"] =$value->date_visite1;
					$tmp["raison_visite"] =$tmp_raison_visite;
					$tmp["menage_visite"] =$tmp_menage_visite;
					$tmp["objet_visite"] =$value->objet_visite;
					$tmp["nom_prenom_mlpl"] =$value->nom_prenom_mlpl;
					$tmp["date_visite2"] =$value->date_visite2;
					$tmp["resultat_visite"] =$value->resultat_visite;
					$tmp["recommandation"] =$value->recommandation;
					$data[] = $tmp;					
				}
			}
            if (!$data)
                $data = array();
        } else  {
			$data = $this->VisitedomicileManager->findAll();
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
		// Affectation des valeurs des colonnes de la table
		$data = array(
			'id_groupe_ml_pl' => $this->post('id_groupe_ml_pl'),
			'numero'          => $this->post('numero'),
			'date_visite1'    => $this->post('date_visite1'),
			'objet_visite'    => $this->post('objet_visite'),
			'nom_prenom_mlpl' => $this->post('nom_prenom_mlpl'),
			'date_visite2'    => $this->post('date_visite2'),
			'resultat_visite' => $this->post('resultat_visite'),
			'recommandation'  => $this->post('recommandation'),
		);               
         if ($supprimer == 0)  {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->VisitedomicileManager->add($data);
				$donnees_retour['menage_visite']=array();
				$donnees_retour['raison_visite']=array();
				// Insertion raison visite domicile et liste ménage visité
				$nombre_menage_visite =$this->post('nombre_menage_visite');
				$nombre_raison_visite =$this->post('nombre_raison_visite');
				if($nombre_menage_visite >0) {
					$data=array();
					for($i=1;$i <=$nombre_menage_visite;$i++) {
						$data=array(
								'id_visite' => $dataId,
								'id_menage' => $this->post('id_menage_'.$i)
								);
						$ret=$this->VisitedomicilemenageManager->add($data);		
					} 
					$tmp_menage_visite = $this->VisitedomicilemenageManager->findAllByIdvisite($dataId);
					$donnees_retour['menage_visite']=$tmp_menage_visite;
				}
				if($nombre_raison_visite >0) {
					$data=array();
					for($i=1;$i <=$nombre_raison_visite;$i++) {
						$data=array(
								'id_visite' => $dataId,
								'id_raison_visite_domicile' => $this->post('id_raison_visite_domicile_'.$i)
								);
						$ret1=$this->VisitedomicileraisonManager->add($data);
					} 
					$tmp_raison_visite = $this->VisitedomicileraisonManager->findAllByIdvisite($dataId);
					$donnees_retour['raison_visite']=$tmp_raison_visite;
				}
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'donnees_retour' => $donnees_retour,
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
                $update = $this->VisitedomicileManager->update($id, $data);   
				// Suppression détail ménage visité et détail raison visite d"abord APRES"
				$del1=$this->VisitedomicilemenageManager->deleteByIdvisite($id);
				$del2=$this->VisitedomicileraisonManager->deleteByIdvisite($id);
				$donnees_retour['menage_visite']=array();
				$donnees_retour['raison_visite']=array();
				// Insertion raison visite domicile et liste ménage visité
				$nombre_menage_visite =$this->post('nombre_menage_visite');
				$nombre_raison_visite =$this->post('nombre_raison_visite');
				if($nombre_menage_visite >0) {
					$data=array();
					for($i=1;$i <=$nombre_menage_visite;$i++) {
						$data=array(
								'id_visite' => $id,
								'id_menage' => $this->post('id_menage_'.$i)
								);
						$ret=$this->VisitedomicilemenageManager->add($data);		
					} 					
					$tmp_menage_visite = $this->VisitedomicilemenageManager->findAllByIdvisite($id);
					$donnees_retour['menage_visite']=$tmp_menage_visite;
				}
				if($nombre_raison_visite >0) {
					$data=array();
					for($i=1;$i <=$nombre_raison_visite;$i++) {
						$data=array(
								'id_visite' => $id,
								'id_raison_visite_domicile' => $this->post('id_raison_visite_domicile_'.$i)
								);
						$ret1=$this->VisitedomicileraisonManager->add($data);
					} 				
					$tmp_raison_visite = $this->VisitedomicileraisonManager->findAllByIdvisite($id);
					$donnees_retour['raison_visite']=$tmp_raison_visite;
				}
				
                if(!is_null($update)){
                    $this->response([
                        'status' => TRUE, 
                        'response' => $id,
                        'donnees_retour' => $donnees_retour,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => $id,
                        'donnees_retour' => $donnees_retour,
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
			// Suppression fils
			$del1=$this->VisitedomicilemenageManager->deleteByIdvisite($id);
			$del2=$this->VisitedomicileraisonManager->deleteByIdvisite($id);			
			// Suppression d'un enregistrement
            $delete = $this->VisitedomicileManager->delete($id);          
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