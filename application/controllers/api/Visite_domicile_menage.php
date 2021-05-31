<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Visite_domicile_menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('visite_domicile_raison_model', 'VisitedomicileraisonManager');
        $this->load->model('visite_domicile_menage_model', 'VisitedomicilemenageManager');
    }
    //recuperation détail variable intervention
    public function index_get() {
        $id = $this->get('id');
		$data=array();
        $data["raison_visite"] = array();
        $data["menage_visite"] = array();
        $cle_etrangere = $this->get('cle_etrangere');
        if ($cle_etrangere){
			$indice_choix_multiple=0;
			// Selection liste variable
            $temporaire = $this->VisitedomicileraisonManager->findAllByIdgroupemlpl($cle_etrangere);
			$data_temp=array();
            if ($temporaire) {
				// Variable utile pour controler la saisie des nombres prévu d'individu/ménage/groupe
				// Le champ est actif si la variable correspondante = 1
				foreach ($temporaire as $key => $value) {
					// Affectation des valeurs des id_raison_visite_domicile dans un tableau : seul les id_raison_visite_domicile nous interesse
					// pour être selectionné dans des choix multiple 
					$data_temp[$key] = $value->id_raison_visite_domicile;
                }
				$data["raison_visite"] = $data_temp;
            }           
            $temporaire = $this->VisitedomicilemenageManager->findAllByIdgroupemlpl($cle_etrangere);
			$data_temp=array();
            if ($temporaire) {
				// Variable utile pour controler la saisie des nombres prévu d'individu/ménage/groupe
				// Le champ est actif si la variable correspondante = 1
				foreach ($temporaire as $key => $value) {
					// Affectation des valeurs des id_menage dans un tableau : seul les id_menage nous interesse
					// pour être selectionné dans des choix multiple 
					$data_temp[$key] = $value->id_menage;
                }
				$data["menage_visite"] = $data_temp;
            }           
        } else {
            if ($id) {
                $data = array();
				// Selection par id
                $data = $this->VisitedomicilemenageManager->findById($id);
            } else {
				// Selection de tous les enregistrements
                $data = $this->VisitedomicilemenageManager->findAll();
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
    //insertion,modification,suppression détail variable intervention
    public function index_post() {
			$id_groupe_ml_pl=$this->post('id_groupe_ml_pl');
		$id_menage = $this->post('id_menage');
		$intitule_intervention = $this->post('intitule_intervention');
		$nombre_reponse_menage_choix_multiple = $this->post('nombre_reponse_menage_choix_multiple');
		$nombre_reponse_menage_choix_unique = $this->post('nombre_reponse_menage_choix_unique');
		$id_liste_validation_beneficiaire=null;
		$temporaire=$this->post('id_liste_validation_beneficiaire');
		if(isset($temporaire) && $temporaire !="" && intval($temporaire) >0) {
			$id_liste_validation_beneficiaire=$temporaire;
		}
		// Supprimer d'abord les variables existantes dans la table; puis réinsérer après
		$nombre_enregistrement_supprime= $this->VisitedomicilemenageManager->deleteBygroupemlpl($id_menage);
		if($nombre_reponse_menage_choix_multiple >0) {
			// Ajout détail liste variable à choix multiple
			for($i=1;$i<=$nombre_reponse_menage_choix_multiple;$i++) {
				$id_menage = $this->post('id_variable_'.$i);
				$id_groupe_ml_pl =null;
				// Récupération id_groupe_ml_pl correspondant à id_menage
				$retour= $this->VariableManager->findById($id_menage);
				foreach($retour as $k=>$v) {
					$id_groupe_ml_pl = $v->id_groupe_ml_pl;
				}
				$data = array(
					'id_menage' => $id_menage,
					'id_groupe_ml_pl' => $id_groupe_ml_pl,
					'id_groupe_ml_pl' => $id_groupe_ml_pl ,
				);
				$retour = $this->VisitedomicilemenageManager->add($data);     
			}
		}
		if($nombre_reponse_menage_choix_unique >0) {
			// Ajout détail liste variable à choix multiple
			for($i=1;$i<=$nombre_reponse_menage_choix_unique;$i++) {
				$id_menage = $this->post('id_variable_unique_'.$i);
				$id_groupe_ml_pl =$this->post('id_liste_variable_'.$i);
				$data = array(
					'id_menage' => $id_menage,
					'id_groupe_ml_pl' => $id_groupe_ml_pl,
					'id_groupe_ml_pl' => $id_groupe_ml_pl ,
				);
				$retour = $this->VisitedomicilemenageManager->add($data);     
			}
		}	
			$data=array();
			$data["variable_choix_multiple"] =  array();
            $data_choix_multiple = array();
			$indice_choix_multiple=0;
			// Selection liste variable
            $temporaire = $this->VisitedomicilemenageManager->findAllByIdgroupemlpl($id_menage);
            if ($temporaire) {
				// Variable utile pour controler la saisie des nombres prévu d'individu/ménage/groupe
				// Le champ est actif si la variable correspondante = 1
				$individu_prevu=0;
				$menage_prevu=0;
				$groupe_prevu=0;
               foreach ($temporaire as $key => $value) {
					// Affectation des valeurs des id_menage dans un tableau : seul les id_menage nous interesse
					// pour être selectionné dans des choix multiple 
					// Si choix unique
					$si_choix_unique=$this->ListeVariableManager->findByIdArray($value->id_groupe_ml_pl);
					$choix_unique=0;
					foreach($si_choix_unique as $k=>$v) {
						$choix_unique=$v->choix_unique;
					}
					if(intval($choix_unique)==0) {
						$data_choix_multiple[$indice_choix_multiple] = $value->id_menage;
						$indice_choix_multiple=$indice_choix_multiple + 1;
					} else {
						if(intval($value->id_groupe_ml_pl)==1) {
							if(intval($value->id_menage)==1) {
								$menage_prevu=1;
							} else if(intval($value->id_menage)==2) {
								$individu_prevu=1;
							} else {
								$groupe_prevu=1;
							}
						}
					}	
                }
				$data["variable_choix_multiple"] = $data_choix_multiple;
            }           		
		$message_retour=" dans Réponse ménage :".$intitule_intervention; 
		if($nombre_enregistrement_supprime > 0 && ($nombre_reponse_menage_choix_multiple > 0 || $nombre_reponse_menage_choix_unique > 0 ) ) {
			$message_retour = "Modification".$message_retour;
		} else {
			$message_retour = "Ajout".$message_retour;
		} 
		$data["message_retour"]=$message_retour;
		$this->response([
			'status' => TRUE,
			'response' => $data,
			'message' => 'Data insert success'
				], REST_Controller::HTTP_OK);			
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>