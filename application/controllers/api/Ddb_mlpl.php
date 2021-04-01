<?php

/*Les CRUD des tables : raison_visite_domicile,resolution_visite_domicile,theme_sensibilisation,
projet_groupe,probleme_rencontres,resolution_ml_pl
 sont gérer par cette controller et sont model*/

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Ddb_mlpl extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ddb_mlpl_model', 'DdbmlplManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $nom_table = $this->get('nom_table');	
        $nom_table_rapport = $this->get('nom_table_rapport');	
        $id_rapport = $this->get('id_rapport');	
        $nom_cle_etrangere = $this->get('nom_cle_etrangere');	
		$data = array();
		$tab_reponse = array();
		if ($id) {
			$tmp = $this->DdbmlplManager->findById($nom_table);
			if($tmp) {
				$data=$tmp;
			}
		} else if($id_rapport && $nom_cle_etrangere) {
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere($nom_table,$nom_table_rapport,$id_rapport,$nom_cle_etrangere);
			if($nom_table_rapport!='rapport_raison_visite_domicile' && $nom_table_rapport!='rapport_resolution_visite_domicile') {
				$tableau_reponse = $this->DdbmlplManager->findByIdrapportReponseChoixMultiple($nom_table_rapport,$id_rapport,$nom_cle_etrangere);
				$tab_reponse=array();
				if($tableau_reponse) {
					foreach($tableau_reponse as $k=>$v) {
						$tab_reponse[$k] = $v->id;
					}
				} 
				if ($tmp) {
					$data["liste_choix"] =$tmp;
				} 
				$data["tab_reponse"]=$tab_reponse;
				/*if (count($data)>0) {
					$this->response([
						'status' => TRUE,
						'response' => $data,
						'message' => 'Get data success',
					], REST_Controller::HTTP_OK);
				} 
				else {
					$this->response([
						'status' => TRUE,
						'response' => array(),
						'message' => 'No data were found'
					], REST_Controller::HTTP_OK);
				}*/
			} else {
				if ($tmp) {
					$data=$tmp;
				}
			}				
		} else {		
			$tmp = $this->DdbmlplManager->findAll($nom_table);
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
		} 
		else {
			$this->response([
				'status' => TRUE,
				'response' => array(),
				'message' => 'No data were found'
			], REST_Controller::HTTP_OK);
		}
    }
    public function index_post() {
        $id = $this->post('id') ;
        $nom_table = $this->post('nom_table') ;
        $rapport = $this->post('rapport') ;
        $supprimer = $this->post('supprimer') ;
        $mise_a_jour_rapport = $this->post('mise_a_jour_rapport') ;
		if(!$mise_a_jour_rapport) {
			// Mise a jour table simplement
			$data = array(
				'description' => $this->post('description'),
			);         
		} else {
			// Mise a jour détail table rapport mensuel ML/PL
			
		}		
		if(!$mise_a_jour_rapport) {
			// DDB
			if ($supprimer == 0) {
				if ($id == 0) {
					if (!$data) {
						$this->response([
							'status' => FALSE,
							'response' => 0,
							'message' => 'No request found'
								], REST_Controller::HTTP_BAD_REQUEST);
					}
					$dataId = $this->DdbmlplManager->add($data,$nom_table);  
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
					$update = $this->DdbmlplManager->update($id, $data,$nom_table); 
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
				$delete = $this->DdbmlplManager->delete($id,$nom_table);  
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
		} else {
			$id_rapport=$this->post('id_rapport') ;
			$nombre_detail_raison_visite_domicile=$this->post('nombre_detail_raison_visite_domicile') ;
			$nombre_detail_resolution_visite_domicile=$this->post('nombre_detail_resolution_visite_domicile') ;
			$nombre_detail_theme_sensibilisation=$this->post('nombre_detail_theme_sensibilisation') ;
			$nombre_detail_projet_de_groupe=$this->post('nombre_detail_projet_de_groupe') ;
			$nombre_detail_probleme_rencontre=$this->post('nombre_detail_probleme_rencontre') ;
			$nombre_detail_resolution_mlpl=$this->post('nombre_detail_resolution_mlpl') ;
			
			$nombre_reponse_theme_sensibilisation=$this->post('nombre_reponse_theme_sensibilisation') ;
			$nombre_reponse_projet_de_groupe=$this->post('nombre_reponse_projet_de_groupe') ;
			$nombre_reponse_probleme_rencontre=$this->post('nombre_reponse_probleme_rencontre') ;
			$nombre_reponse_resolution_mlpl=$this->post('nombre_reponse_resolution_mlpl') ;
			for($i=1;$i <=$nombre_detail_raison_visite_domicile;$i++) {
				$id=$this->post('id_1_'.$i) ;
				$id_raison_visite_domicile=$this->post('id_raison_visite_domicile_1_'.$i) ;
				$id_table_fille=$this->post('id_table_fille_1_'.$i) ;
				$menage_sensibilise=$this->post('menage_sensibilise_1_'.$i) ;
				if(intval($id_raison_visite_domicile) >0) {
					// update
					$id_tf=$this->DdbmlplManager->update_table('rapport_raison_visite_domicile',$id_table_fille,$id_rapport,'id_raison_visite_domicile',$id_raison_visite_domicile,$menage_sensibilise);
				} else {
					// nouveau
					$id_raison_visite_domicile=$id;
					$id_tf=$this->DdbmlplManager->add_table('rapport_raison_visite_domicile',$id_rapport,'id_raison_visite_domicile',$id_raison_visite_domicile,$menage_sensibilise);
				}
			}
			for($i=1;$i <=$nombre_detail_resolution_visite_domicile;$i++) {
				$id=$this->post('id_2_'.$i) ;
				$id_resolution_visite_domicile=$this->post('id_resolution_visite_domicile_2_'.$i) ;
				$id_table_fille=$this->post('id_table_fille_2_'.$i) ;
				$menage_sensibilise=$this->post('menage_sensibilise_2_'.$i) ;
				if(intval($id_resolution_visite_domicile) >0) {
					// update
					$id_tf=$this->DdbmlplManager->update_table('rapport_resolution_visite_domicile',$id_table_fille,$id_rapport,'id_resolution_visite_domicile',$id_resolution_visite_domicile,$menage_sensibilise);
				} else {
					// nouveau
					$id_resolution_visite_domicile=$id;
					$id_tf=$this->DdbmlplManager->add_table('rapport_resolution_visite_domicile',$id_rapport,'id_resolution_visite_domicile',$id_resolution_visite_domicile,$menage_sensibilise);
				}
			}
			// pour les 4 tables restante : supprimer tout et après inseré tout les réponses choix multiple
			$del =$this->DdbmlplManager->delete_table_rapport_choix_multiple('rapport_probleme_rencontres',$id_rapport);
			$del =$this->DdbmlplManager->delete_table_rapport_choix_multiple('rapport_projet_groupe',$id_rapport);
			$del =$this->DdbmlplManager->delete_table_rapport_choix_multiple('rapport_resolution_ml_pl',$id_rapport);
			$del =$this->DdbmlplManager->delete_table_rapport_choix_multiple('rapport_theme_sensibilisation',$id_rapport);
			for($i=1;$i <=$nombre_reponse_theme_sensibilisation;$i++) {
				$id=$this->post('id_reponse_3_'.$i) ;
				$menage_sensibilise=null ;
				$id_theme_sensibilisation=$id;
				$id_tf=$this->DdbmlplManager->add_table('rapport_theme_sensibilisation',$id_rapport,'id_theme_sensibilisation',$id_theme_sensibilisation,$menage_sensibilise);
			}
			for($i=1;$i <=$nombre_reponse_projet_de_groupe;$i++) {
				$id=$this->post('id_reponse_4_'.$i) ;
				$menage_sensibilise=null ;
				$id_projet_groupe=$id;
				$id_tf=$this->DdbmlplManager->add_table('rapport_projet_groupe',$id_rapport,'id_projet_groupe',$id_projet_groupe,$menage_sensibilise);
			}
			for($i=1;$i <=$nombre_reponse_probleme_rencontre;$i++) {
				$id=$this->post('id_reponse_5_'.$i) ;
				$menage_sensibilise=null ;
				$id_probleme_rencontres=$id;
				$id_tf=$this->DdbmlplManager->add_table('rapport_probleme_rencontres',$id_rapport,'id_probleme_rencontres',$id_probleme_rencontres,$menage_sensibilise);
			}
			for($i=1;$i <=$nombre_reponse_resolution_mlpl;$i++) {
				$id=$this->post('id_reponse_6_'.$i) ;
				$menage_sensibilise=null ;
				$id_resolution_ml_pl=$id;
				$id_tf=$this->DdbmlplManager->add_table('rapport_resolution_ml_pl',$id_rapport,'id_resolution_ml_pl',$id_resolution_ml_pl,$menage_sensibilise);
			}
			// RECUPERATION DE TOUT : 6 tables	
			$data=array();
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('raison_visite_domicile','rapport_raison_visite_domicile',$id_rapport,'id_raison_visite_domicile');
			if($tmp) {
				$data["rapport_raison_visite_domicile"] =$tmp;
			} else {
				$data["rapport_raison_visite_domicile"] =array();
			}
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('resolution_visite_domicile','rapport_resolution_visite_domicile',$id_rapport,'id_resolution_visite_domicile');
			if($tmp) {
				$data["rapport_resolution_visite_domicile"] =$tmp;
			} else {
				$data["rapport_resolution_visite_domicile"] =array();
			}
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('theme_sensibilisation','rapport_theme_sensibilisation',$id_rapport,'id_theme_sensibilisation');
			if($tmp) {
				$data["rapport_theme_sensibilisation"] =$tmp;
			} else {
				$data["rapport_theme_sensibilisation"] =array();
			}
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('projet_groupe','rapport_projet_groupe',$id_rapport,'id_projet_groupe');
			if($tmp) {
				$data["rapport_projet_groupe"] =$tmp;
			} else {
				$data["rapport_projet_groupe"] =array();
			}
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('probleme_rencontres','rapport_probleme_rencontres',$id_rapport,'id_probleme_rencontres');
			if($tmp) {
				$data["rapport_probleme_rencontres"] =$tmp;
			} else {
				$data["rapport_probleme_rencontres"] =array();
			}
			$tmp = $this->DdbmlplManager->findByIdrapportNomcleEtrangere('resolution_ml_pl','rapport_resolution_ml_pl',$id_rapport,'id_resolution_ml_pl');
			if($tmp) {
				$data["rapport_resolution_ml_pl"] =$tmp;
			} else {
				$data["rapport_resolution_ml_pl"] =array();
			}
			$tableau_reponse = $this->DdbmlplManager->findByIdrapportReponseChoixMultiple('rapport_theme_sensibilisation',$id_rapport,'id_theme_sensibilisation');
			$tab_reponse=array();
			if($tableau_reponse) {
				foreach($tableau_reponse as $k=>$value) {
					$tab_reponse[$k] = $value->id;
				}
			} 
			$data["tab_reponse_theme_sensibilisation"] =$tab_reponse;
			$tableau_reponse = $this->DdbmlplManager->findByIdrapportReponseChoixMultiple('rapport_projet_groupe',$id_rapport,'id_projet_groupe');
			$tab_reponse=array();
			if($tableau_reponse) {
				foreach($tableau_reponse as $k=>$value) {
					$tab_reponse[$k] = $value->id;
				}
			} 
			$data["tab_reponse_projet_de_groupe"] =$tab_reponse;
			$tableau_reponse = $this->DdbmlplManager->findByIdrapportReponseChoixMultiple('rapport_probleme_rencontres',$id_rapport,'id_probleme_rencontres');
			$tab_reponse=array();
			if($tableau_reponse) {
				foreach($tableau_reponse as $k=>$value) {
					$tab_reponse[$k] = $value->id;
				}
			} 
			$data["tab_reponse_probleme_rencontres"] =$tab_reponse;
			$tableau_reponse = $this->DdbmlplManager->findByIdrapportReponseChoixMultiple('rapport_resolution_ml_pl',$id_rapport,'id_resolution_ml_pl');
			$tab_reponse=array();
			if($tableau_reponse) {
				foreach($tableau_reponse as $k=>$value) {
					$tab_reponse[$k] = $value->id;
				}
			} 
			$data["tab_reponse_solution_prise"] =$tab_reponse;
						$this->response([
							'status' => TRUE,
							'response' => $data,
							'message' => 'Data insert success'
								], REST_Controller::HTTP_OK);
			
		}		
    }
}
?>