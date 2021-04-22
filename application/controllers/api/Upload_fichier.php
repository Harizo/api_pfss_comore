<?php
define ('SITE_ROOT', realpath(dirname(__FILE__)));
defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . '/libraries/REST_Controller.php';
class Upload_fichier extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
    }
	// Download canevas fichier fichier bénéficiaire et suivi intervention
	public function prendre_fichier()  {
		$filename = $_POST["nom_fichier"]; 
		$rep = $_POST["repertoire"];
		$data=$rep.$filename;    
		$this->load->helper('download');
		$name = 'h'.$filename;
		force_download($name, $data);
        echo json_encode($data);
	}  		
	// Fonction qui récupère le fichier rempli
	public function upload_file() {	
		$erreur="aucun";
		$replace=array('e','e','e','a','o','c','_','_','_');
		$search= array('é','è','ê','à','ö','ç',' ','&','°');
		$repertoire= $_POST['repertoire'];
		$id_ile= $_POST['id_ile'];
		$id_region= $_POST['id_region'];
		$id_commune= $_POST['id_commune'];
		$village_id= $_POST['village_id'];
		$ile = $this->IleManager->findById($id_ile);
		$nom_ile = $ile->Ile;
		$reg = $this->RegionManager->findById($id_region);
		$region = $reg->Region;
		$comm = $this->CommuneManager->findById($id_commune);
		$commune = $comm->Commune;
		$vill = $this->VillageManager->findById($village_id);
		$village = $vill->Village;	
		$repertoire=str_replace($search,$replace,$repertoire);
		
		$village_tmp=$village;	
		$village_tmp=str_replace ( "é" , "e" ,  $village_tmp );
		$village_tmp=str_replace ( "ô" , "o" ,  $village_tmp );
		$village_tmp=str_replace ( "Ô" , "o" ,  $village_tmp );
		$village_tmp=str_replace ( "î" , "i" ,  $village_tmp );
		$village_tmp=str_replace ( "Î" , "i" ,  $village_tmp );
		$village_tmp=str_replace ( "è" , "e" ,  $village_tmp );
		$village_tmp=str_replace ( "à" , "a" ,  $village_tmp );
		$village_tmp=str_replace ( "ç" , "c" ,  $village_tmp );
		$village_tmp=str_replace ( "'" , "" ,  $village_tmp );
		$ile_tmp = $nom_ile;
		$ile_tmp=str_replace ( "é" , "e" ,  $ile_tmp );
		$ile_tmp=str_replace ( "ô" , "o" ,  $ile_tmp );
		$ile_tmp=str_replace ( "Ô" , "o" ,  $ile_tmp );
		$ile_tmp=str_replace ( "î" , "i" ,  $ile_tmp );
		$ile_tmp=str_replace ( "Î" , "i" ,  $ile_tmp );
		$ile_tmp=str_replace ( "è" , "e" ,  $ile_tmp );
		$ile_tmp=str_replace ( "à" , "a" ,  $ile_tmp );
		$ile_tmp=str_replace ( "ç" , "c" ,  $ile_tmp );
		$ile_tmp=str_replace ( "'" , "" ,  $ile_tmp );
		$region_tmp = $region;
		$region_tmp=str_replace ( "é" , "e" ,  $region_tmp );
		$region_tmp=str_replace ( "ô" , "o" ,  $region_tmp );
		$region_tmp=str_replace ( "Ô" , "o" ,  $region_tmp );
		$region_tmp=str_replace ( "î" , "i" ,  $region_tmp );
		$region_tmp=str_replace ( "Î" , "i" ,  $region_tmp );
		$region_tmp=str_replace ( "è" , "e" ,  $region_tmp );
		$region_tmp=str_replace ( "à" , "a" ,  $region_tmp );
		$region_tmp=str_replace ( "ç" , "c" ,  $region_tmp );
		$region_tmp=str_replace ( "'" , "" ,  $region_tmp );
		$commune_tmp=$commune;
		$commune_tmp=str_replace ( "é" , "e" ,  $commune_tmp );
		$commune_tmp=str_replace ( "ô" , "o" ,  $commune_tmp );
		$commune_tmp=str_replace ( "Ô" , "o" ,  $commune_tmp );
		$commune_tmp=str_replace ( "î" , "i" ,  $commune_tmp );
		$commune_tmp=str_replace ( "Î" , "i" ,  $commune_tmp );
		$commune_tmp=str_replace ( "è" , "e" ,  $commune_tmp );
		$commune_tmp=str_replace ( "à" , "a" ,  $commune_tmp );
		$commune_tmp=str_replace ( "ç" , "c" ,  $commune_tmp );
		$commune_tmp=str_replace ( "'" , "" ,  $commune_tmp );
		$ile_tmp = strtolower($ile_tmp);
		$region_tmp = strtolower($region_tmp);
		$commune_tmp = strtolower($commune_tmp);
		$village_tmp = strtolower($village_tmp);
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../" .$repertoire.$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}				

		$emplacement=array();
		$emplacement[0]=dirname(__FILE__) ."/../../../../" .$repertoire;
		$config['upload_path']          = dirname(__FILE__) ."/../../../../".$repertoire.$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|doc|docx|pdf|txt';
		$config['max_size'] = 222048;
		$config['overwrite'] = TRUE;
		$retour =$emplacement;
		if (isset($_FILES['file']['tmp_name'])) {
			$name=$_FILES['file']['name'];
			$name1=str_replace($search,$replace,$name);
			$emplacement[1]=$name1;
			$emplacement[2]=$repertoire.$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			$config['file_name'] = $name1;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$ff=$this->upload->do_upload('file');
			// UNE FOIS LE FICHIER ENREGISTRE DANS LE SERVEUR => Controler les données
			// Contrôler les données envoyés par l'acteur
			$valeur_retour=array();
			$valeur_retour["nom_fichier"] = $emplacement[1];
			$valeur_retour["repertoire"] = $emplacement[2];
			$valeur_retour["reponse"] = "OK";
			
		} else {
			$valeur_retour=array();
			$valeur_retour["nom_fichier"] = "inexistant";
			$valeur_retour["repertoire"] = "introuvable";
			$valeur_retour["reponse"] = "ERREUR";
			echo json_encode($valeur_retour);
            // echo 'File upload not found';
		} 
		echo json_encode($valeur_retour);
	}  
	public function upload_fichier() {	
		$erreur="aucun";
		$replace=array('e','e','e','a','o','c','_','_','_');
		$search= array('é','è','ê','à','ö','ç',' ','&','°');
		$repertoire= $_POST['repertoire'];
		$repertoire=str_replace($search,$replace,$repertoire);
		
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../" .$repertoire."/";
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}				

		$emplacement=array();
		$emplacement[0]=dirname(__FILE__) ."/../../../../" .$repertoire;
		$config['upload_path']          = dirname(__FILE__) ."/../../../../".$repertoire."/";
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|doc|docx|pdf|txt';
		$config['max_size'] = 222048;
		$config['overwrite'] = TRUE;
		$retour =$emplacement;
		if (isset($_FILES['file']['tmp_name'])) {
			$name=$_FILES['file']['name'];
			$name1=str_replace($search,$replace,$name);
			$emplacement[1]=$name1;
			$emplacement[2]=$repertoire."/";
			$config['file_name'] = $name1;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$ff=$this->upload->do_upload('file');
			// UNE FOIS LE FICHIER ENREGISTRE DANS LE SERVEUR => Controler les données
			// Contrôler les données envoyés par l'acteur
			$valeur_retour=array();
			$valeur_retour["nom_fichier"] = $emplacement[1];
			$valeur_retour["repertoire"] = $emplacement[2];
			$valeur_retour["reponse"] = "OK";
			
		} else {
			$valeur_retour=array();
			$valeur_retour["nom_fichier"] = "inexistant";
			$valeur_retour["repertoire"] = "introuvable";
			$valeur_retour["reponse"] = "ERREUR";
			echo json_encode($valeur_retour);
            // echo 'File upload not found';
		} 
		echo json_encode($valeur_retour);
	}  

} ?>	
