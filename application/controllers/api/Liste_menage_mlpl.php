<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Liste_menage_mlpl extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('liste_menage_mlpl_model', 'ListemenagemlplManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $data = array() ;
		if($id) {
			$data = $this->ListemenagemlplManager->findById($id);
            if (!$data)
                $data = array();
		} else if ($cle_etrangere)  {
            $data = $this->ListemenagemlplManager->findAllByGroupemlpl($cle_etrangere);
            if (!$data)
                $data = array();
        } else  {
			$data = $this->ListemenagemlplManager->findAll();
            if (!$data)
                $data = array();
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
        $id_groupe_ml_pl = $this->post('id_groupe_ml_pl') ;
        $nombre_menage_membre = $this->post('nombre_menage_membre') ;
        $supprimer = $this->post('supprimer') ;
		if ($nombre_menage_membre > 0) {
			// Supprimer d'abord les enreg déjà présent
			$del=$this->ListemenagemlplManager->deleteByGroupemlpl($id_groupe_ml_pl);
			// Insertion  membre ménage groupe ML/PL
			$donnees_retour = array();
			$nombre_menage_membre =$this->post('nombre_menage_membre');
			if($nombre_menage_membre >0) {
				$data=array();
				for($i=1;$i <=$nombre_menage_membre;$i++) {
					$data=array(
							'id_groupe_ml_pl' => $id_groupe_ml_pl,
							'menage_id' => $this->post('id_menage_'.$i)
							);
					$ret=$this->ListemenagemlplManager->add($data);		
				} 
				$donnees_retour = $this->ListemenagemlplManager->findAllByGroupemlpl($id_groupe_ml_pl);
			}
			if (!is_null($donnees_retour)) {
				$this->response([
					'status' => TRUE,
					'response' => $donnees_retour,
					'message' => 'Data insert success'
						], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => FALSE,
					'response' => array(),
					'message' => 'No request found'
						], REST_Controller::HTTP_OK);
			}
		} else {
			// Suppression détail ménage membre groupe ML/PL : aucune séléctiob et il vaut mieux supprimer 
			// si par malheur tout est deselectionné
			$del1=$this->ListemenagemlplManager->deleteByGroupemlpl($id_groupe_ml_pl);
			$donnees_retour = $this->ListemenagemlplManager->findAllByGroupemlpl($id_groupe_ml_pl);
			if(!is_null($donnees_retour)){
				$this->response([
					'status' => TRUE, 
					'response' => $donnees_retour,
					'message' => 'Update data success'
						], REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => FALSE,
					'response' => array(),
					'message' => 'No request found'
						], REST_Controller::HTTP_OK);
			}
		}
    }
}
?>