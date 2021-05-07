<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Importation_menage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sous_projet_model', 'SousprojetManager');
        $this->load->model('menage_beneficiaire_model', 'MenagebeneficiaireManager');
        $this->load->model('menage_model', 'MenageManager');
        $this->load->model('individu_model', 'IndividuManager');
        $this->load->model('requete_import_model', 'RequeteimportManager');
        $this->load->model('importation_menage_model', 'ImportationmenageManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('zip_model', 'ZipManager');
    }

    public function index_get() 
    {   
		// L'importation se fait en 2 étapes : Controler les données puis importer (ex controle : nom chef ménage VIDE)
		// Les fichiers excel à importer sont différents : à 2 feuilles pour ACT et 3 feuilles pour ARSE et COVID
		// c'est pour cela que les fonctions à appeler sont différentes
		$chemin = $this->get('chemin'); 
		$nomfichier = $this->get('nomfichier'); 
		$id_sous_projet=$this->get('id_sous_projet'); 
		$controle=$this->get('controle'); 
		$vague=$this->get('vague'); 
		if($controle) {
			if($vague) {
				$retour=$this->controler_vague_zip();		
			} else {
				// id_sous_projet=2 : ARSE et 4 : COVID
				if(intval($id_sous_projet)==2 || intval($id_sous_projet)==4) {
					$retour=$this->controler_menage_arse_covid($chemin,$nomfichier);
				} else {
					$retour=$this->controler_menage_act($chemin,$nomfichier);				
				}	
			}	
		} else {
			if($vague) {
				// Mise à jour vague et zip à partir fichier excel
				$retour=$this->importer_vague_zip();
			} else {
				// IMPORTATION vers BDD apprè controle
				// id_sous_projet=2 : ARSE et 4 : COVID
				if(intval($id_sous_projet)==2 || intval($id_sous_projet)==4) {
					$retour=$this->importer_menage_arse_covid($chemin,$nomfichier);
				} else {
					$retour=$this->importer_menage_act($chemin,$nomfichier);
				}	
			}	
		}	
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////:
	public function controler_menage_arse_covid($chemin,$nomfichier) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		// EXISTENCE BENEFICIAIRES
		/////////////////Correction////////////////
		/////////////////Correction////////////////			
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$directoryName = dirname(__FILE__) . "/../../../../importmenage/".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_date_inscription=0;
		$erreur_nom_chef_menage=0;
		$erreur_sexechefmenage=0;
		$erreur_identifiant_menage=0;
		$erreur_sexe_conjoint=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$erreur_nbjour="";
		$erreur_annee="";
		$erreur_activite="";
		$erreur_etape="";
		$deja_importe="";
		$requete =" ";		
		$depart_ligne_lecture=4;
		$array_numero =array();
		$indice=0;
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 5
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('B' == $cell->getColumn()) {
							$sous_projet_activite =$cell->getValue();
					 }
				}	
				$id_sous_projet=null;
				if($sous_projet_activite=="") {
					// Pas de sous projet : 
					$sheet->getStyle("B1")->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sous_projet = $erreur_sous_projet + 1;						
				} else {
					$sous_projet_activite =strtolower($sous_projet_activite);
					$ssprj = $this->ImportationmenageManager->selectionsous_projet($sous_projet_activite);
					if(count($ssprj) >0) {
						foreach($ssprj as $indice=>$v) {
							$id_sous_projet = $v->id;
							$code_sous_projet=$v->code;
						} 						
					} else {
						// Pas de sous projet : 
						$sheet->getStyle("B1")->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_sous_projet = $erreur_sous_projet + 1;	
					}	
				}					
			} 
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$point_inscription =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
							$numeroenregistrement =$cell->getValue();	
							$array_numero[] = $numeroenregistrement;
							$indice=$indice +1;
					} else if('C' == $cell->getColumn()) {
							$date_inscription = $cell->getValue();
							if(isset($date_inscription) && $date_inscription>"") {
								if(PHPExcel_Shared_Date::isDateTime($cell)) {
									 $date_inscription = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_inscription)); 
									 $date_inscription = $date_inscription; 
								} else {
									$date_inscription=null;
								}
							} else {
								$date_inscription=null;
							}	
					} else if('D' == $cell->getColumn()) {
						$ile = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('G' == $cell->getColumn()) {
						$milieu = $cell->getValue();
					} else if('H' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('I' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('J' == $cell->getColumn()) {
						$adresse = $cell->getValue();
					} else if('K' == $cell->getColumn()) {
						$nomchefmenage = $cell->getValue();
					} else if('L' == $cell->getColumn()) {
						$SexeChefMenage = $cell->getValue();
					} else if('M' == $cell->getColumn()) {
						$chef_frequente_ecole = $cell->getValue();
					} else if('N' == $cell->getColumn()) {
						$niveau_instruction_chef = $cell->getValue();
					} else if('O' == $cell->getColumn()) {
						$chef_menage_travail = $cell->getValue();
					} else if('P' == $cell->getColumn()) {
						$activite_chef_menage = $cell->getValue();
					} else if('Q' == $cell->getColumn()) {
						$NumeroCIN = $cell->getValue();
					} else if('R' == $cell->getColumn()) {
						$NumeroCarteElectorale = $cell->getValue();
					} else if('S' == $cell->getColumn()) {
						$telephone_chef_menage = $cell->getValue();
					} else if('T' == $cell->getColumn()) {
						$nom_conjoint = $cell->getValue();
					} else if('U' == $cell->getColumn()) {
						$sexe_conjoint = $cell->getValue();
					} else if('V' == $cell->getColumn()) {
						$conjoint_frequente_ecole = $cell->getValue();
					} else if('W' == $cell->getColumn()) {
						$niveau_instruction_conjoint = $cell->getValue();
					} else if('X' == $cell->getColumn()) {
						$conjoint_travail = $cell->getValue();
					} else if('Y' == $cell->getColumn()) {
						$activite_conjoint = $cell->getValue();
					} else if('Z' == $cell->getColumn()) {
						$nin_conjoint = $cell->getValue();
					} else if('AA' == $cell->getColumn()) {
						$carte_electorale_conjoint = $cell->getValue();
					} else if('AB' == $cell->getColumn()) {
						$telephone_conjoint = $cell->getValue();
					} else if('AC' == $cell->getColumn()) {
						$taille_menage = $cell->getValue();
					} else if('AD' == $cell->getColumn()) {
						$nombre_personne_plus_soixantedixans = $cell->getValue();
					} else if('AE' == $cell->getColumn()) {
						$nombre_enfant_moins_quinze_ans = $cell->getValue();
					} else if('AF' == $cell->getColumn()) {
						$nombre_enfant_non_scolarise = $cell->getValue();
					} else if('AG' == $cell->getColumn()) {
						$nombre_personne_handicape = $cell->getValue();
					} else if('AH' == $cell->getColumn()) {
						$adulte_travail = $cell->getValue();
					} else if('AI' == $cell->getColumn()) {
						$nombre_membre_a_etranger = $cell->getValue();
					} else if('AJ' == $cell->getColumn()) {
						$maison_non_dure = $cell->getValue();
					} else if('AK' == $cell->getColumn()) {
						$acces_electricite = $cell->getValue();
					} else if('AL' == $cell->getColumn()) {
						$acces_eau_robinet = $cell->getValue();
					} else if('AM' == $cell->getColumn()) {
						$logement_endommage = $cell->getValue();
					} else if('AN' == $cell->getColumn()) {
						$niveau_degat_logement = $cell->getValue();
					} else if('AO' == $cell->getColumn()) {
						$rehabilitation = $cell->getValue();
					} else if('AP' == $cell->getColumn()) {
						$beneficiaire_autre_programme = $cell->getValue();
					} else if('AQ' == $cell->getColumn()) {
						$membre_fonctionnaire = $cell->getValue();
					} else if('AR' == $cell->getColumn()) {
						$antenne_parabolique = $cell->getValue();
					} else if('AS' == $cell->getColumn()) {
						$possede_frigo = $cell->getValue();
					} else if('AZ' == $cell->getColumn()) {
						$identifiant_menage = $cell->getValue();
					} else if('BA' == $cell->getColumn()) {
						$score_obtenu = $cell->getValue();
					} else if('BB' == $cell->getColumn()) {
						$rang_obtenu = $cell->getValue();
					}
				}
				// Formatage valeur
				if(intval($SexeChefMenage)==1) {
					$SexeChefMenage="H";
				} else {
					$SexeChefMenage="F";
				}
				if(intval($chef_frequente_ecole)==2) {
					$chef_frequente_ecole=0;
				}
				if(intval($chef_menage_travail)==2) {
					$chef_menage_travail=0;
				}
				if(intval($sexe_conjoint)==1) {
					$sexe_conjoint="H";
				} else {
					$sexe_conjoint="F";
				}
				if(intval($conjoint_frequente_ecole)==2) {
					$conjoint_frequente_ecole=0;
				}
				if(intval($conjoint_travail)==2) {
					$conjoint_travail=0;
				}
				if(intval($maison_non_dure)==2) {
					$maison_non_dure=0;
				}
				if(intval($acces_electricite)==2) {
					$acces_electricite=0;
				}
				if(intval($acces_eau_robinet)==2) {
					$acces_eau_robinet=0;
				}
				if(intval($logement_endommage)==2) {
					$logement_endommage=0;
				}
				if(intval($beneficiaire_autre_programme)==2) {
					$beneficiaire_autre_programme=0;
				}
				if(intval($membre_fonctionnaire)==2) {
					$membre_fonctionnaire=0;
				}
				if(intval($antenne_parabolique)==2) {
					$antenne_parabolique=0;
				}
				if(intval($possede_frigo)==2) {
					$possede_frigo=0;
				}
				// Formatage valeur
				// Controle info erronnée
				if(!$date_inscription) {
					$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_date_inscription = $erreur_date_inscription + 1;						
				}
				if($nomchefmenage=="") {
					$sheet->getStyle("K".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_chef_menage = $erreur_nom_chef_menage + 1;						
				}
				if($SexeChefMenage=="") {
					$sheet->getStyle("L".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sexechefmenage = $erreur_sexechefmenage + 1;						
				}
				if($identifiant_menage=="") {
					$sheet->getStyle("AZ".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
				} else {
					// TEST DOUBLON
					$identifiant_menage =strtoupper($identifiant_menage);
					$ret=$this->ImportationmenageManager->selection_identifiant_menage($identifiant_menage);
					$nombre=0;
					foreach($ret as $k=>$v) {
						$nombre=$v->nombre;
					}
					if($nombre >0) {
						$sheet->getStyle("AZ".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("BC".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						 $sheet->setCellValue("BC".$ligne, "Identifiant DOUBLON");
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					}
				}
				if($nom_conjoint>"" && $sexe_conjoint=="") {
					$sheet->getStyle("U".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sexe_conjoint = $erreur_sexe_conjoint + 1;						
				}
////////////////////////////////////////////////////////////////////				
				$ile_id=null;
				$region_id=null;
				$commune_id=null;
				$village_id = null;
				$code_village = "";
				$code_commune='';
				$reg=array();
				$place_espace = strpos($ile," ");
				$place_apostrophe = strpos($ile,"'");
				$ile=strtolower($ile);
				if($ile >'') {
					if($place_espace >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_espace - 1));
						$region_temporaire2 = substr ( $ile , ($place_espace + 1));
						$reg = $this->ImportationmenageManager->selectionile_avec_espace($region_temporaire1,$region_temporaire2);
					} else if($place_apostrophe >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_apostrophe - 1));
						$region_temporaire2 = substr ( $ile , ($place_apostrophe + 1));
					} else {	
						$reg = $this->ImportationmenageManager->selectionile($ile);
					}	
					if(count($reg) >0) {
						foreach($reg as $indice=>$v) {
							$ile_id = $v->id;
							$code_ile=$v->code;
						} 						
					} else {
						// Pas de ile : marquer tous les découpages administratif 
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_nom_ile = $erreur_nom_ile + 1;	
					}	
					if(intval($ile_id) >0) {
						if($prefecture >'') {
							$region_ok = true;
							$place_espace = strpos($prefecture," ");
							$place_apostrophe = strpos($prefecture,"'"); 	
							if($place_espace >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_espace - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_espace + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else if($place_apostrophe >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_apostrophe - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_apostrophe + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else {
								$dis = $this->ImportationmenageManager->selectionileprefecture($prefecture,$ile_id);
							}	
							if(count($dis) >0) {
								foreach($dis as $indice=>$v) {
									$region_id = $v->id;
									$codeprefecture= $v->code;
								}
							} else {
								// Pas de prefecture : marquer prefecture,commune,village 
								$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$nombre_erreur = $nombre_erreur + 1;	
								$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
							}
							if(intval($region_id) >0) {
								if($commune >'') {
									$district_ok = true;
									$place_espace = strpos($commune," ");
									$place_apostrophe = strpos($commune,"'");
									if($place_espace >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_espace - 1));
										$commune_temporaire2 = substr ( $commune , ($place_espace + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else if($place_apostrophe >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_apostrophe - 1));
										$commune_temporaire2 = substr ( $commune , ($place_apostrophe + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else {
										$comm = $this->ImportationmenageManager->selectioncommune($commune,$region_id);
									}	
									if(count($comm) >0) {
										foreach($comm as $indice=>$v) {
											$commune_id = $v->id;
											$code_commune = $v->code;
										}
									} else {
										// Pas de commune : marquer commune,village 
										$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$nombre_erreur = $nombre_erreur + 1;
										$erreur_nom_commune = $erreur_nom_commune + 1;	
									}	
									if(intval($commune_id) >0) {
										if($village >'') {
											$place_espace = strpos($village," ");
											$place_apostrophe = strpos($village,"'");
											if($place_espace >0) {
												$village_temporaire1 = substr ( $village , 0 ,($place_espace - 1));
												$village_temporaire2 = substr ( $village , ($place_espace + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else if($place_apostrophe >0){
												$village_temporaire1 = substr ( $village , 0 ,($place_apostrophe - 1));
												$village_temporaire2 = substr ( $village , ($place_apostrophe + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else {
												$fkt = $this->ImportationmenageManager->selectionvillage($village,$commune_id);
											}	
											if(count($fkt) >0) {
												foreach($fkt as $indice=>$v) {
													// A utliser ultérieurement lors de la deuxième vérification : village_id
													$village_id = $v->id;
													$code_village = $v->code;
												}
												$sheet->setCellValue("J3", $village_id);
											} else {													
												// Pas de village : marquer village 
												$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
														 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
															 'startcolor' => array('rgb' => 'FF0000'),
															 'endcolor'   => array('argb' => 'FF0000')
														 )
												 );	
												$nombre_erreur = $nombre_erreur + 1;
												$erreur_nom_village = $erreur_nom_village + 1;	
											}												
										} else {
											// Pas de village : marquer village 
											$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_village = $erreur_nom_village + 1;	
										}
									} 
								} else {										
									// Pas de commune : marquer commune,village 
									$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$nombre_erreur = $nombre_erreur + 1;
									$erreur_nom_commune = $erreur_nom_commune + 1;	
								}		
							}
						} else {
							// Pas de prefecture : marquer prefecture,commune,village 
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	

							 $sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$nombre_erreur = $nombre_erreur + 1;
							$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
						}		
					}
				} else {
					// Pas de région : marquer tous les découpages administratif 
					$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_ile = $erreur_nom_ile + 1;	
				}
////////////////////////////////////////////////////////////////////				
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_sous_projet"] = $erreur_sous_projet;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_date_inscription"] = $erreur_date_inscription;
		$val_ret["erreur_nom_chef_menage"] = $erreur_nom_chef_menage;
		$val_ret["erreur_sexechefmenage"] = $erreur_sexechefmenage;
		$val_ret["erreur_identifiant_menage"] = $erreur_identifiant_menage;
		$val_ret["erreur_sexe_conjoint"] = $erreur_sexe_conjoint;
		if($nombre_erreur==0) {
			$status=TRUE;
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'numeroenregistrement'  =>$array_numero,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);			  
	}	
	public function importer_menage_arse_covid($chemin,$nomfichier) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$trouvez =array("'");
		$remplacez =array(" ");
		$directoryName = dirname(__FILE__) . "/../../../../importmenage/".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_date_inscription=0;
		$erreur_nom_chef_menage=0;
		$erreur_sexechefmenage=0;
		$erreur_identifiant_menage=0;
		$erreur_sexe_conjoint=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$erreur_nbjour="";
		$erreur_annee="";
		$erreur_activite="";
		$erreur_etape="";
		$deja_importe="";
		$requete =" ";		
		$nombre_insere=0;
		$array_insere=array();
		$array_retour=array();
		$depart_ligne_lecture=4;
		$nom_ile="";
		$nom_prefecture="";
		$nom_commune="";
		$nom_village="";
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 5
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('B' == $cell->getColumn()) {
							$sous_projet_activite =$cell->getValue();
					 }
				}	
				if($sous_projet_activite=="") {
					// Pas de sous projet : 
					$sheet->getStyle("B1")->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sous_projet = $erreur_sous_projet + 1;						
				} else {
					$sous_projet_activite =strtolower($sous_projet_activite);
					$ssprj = $this->ImportationmenageManager->selectionsous_projet($sous_projet_activite);
					if(count($ssprj) >0) {
						foreach($ssprj as $indice=>$v) {
							$id_sous_projet = $v->id;
							$code_sous_projet=$v->code;
						} 						
					} else {
						// Pas de sous projet : 
						$sheet->getStyle("B1")->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_sous_projet = $erreur_sous_projet + 1;	
					}	
				}					
			} 
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$point_inscription =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
							$numeroenregistrement =$cell->getValue();	
					} else if('C' == $cell->getColumn()) {
							$date_inscription = $cell->getValue();
							if(isset($date_inscription) && $date_inscription>"") {
								if(PHPExcel_Shared_Date::isDateTime($cell)) {
									 $date_inscription = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_inscription)); 
									 $date_inscription = $date_inscription; 
								} else {
									$date_inscription=null;
								}
							} else {
								$date_inscription=null;
							}	
					} else if('D' == $cell->getColumn()) {
						$ile = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('G' == $cell->getColumn()) {
						$milieu = $cell->getValue();
					} else if('H' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('I' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('J' == $cell->getColumn()) {
						$adresse = $cell->getValue();
					} else if('K' == $cell->getColumn()) {
						$nomchefmenage = $cell->getValue();
					} else if('L' == $cell->getColumn()) {
						$SexeChefMenage = $cell->getValue();
					} else if('M' == $cell->getColumn()) {
						$chef_frequente_ecole = $cell->getValue();
					} else if('N' == $cell->getColumn()) {
						$niveau_instruction_chef = $cell->getValue();
					} else if('O' == $cell->getColumn()) {
						$chef_menage_travail = $cell->getValue();
					} else if('P' == $cell->getColumn()) {
						$activite_chef_menage = $cell->getValue();
					} else if('Q' == $cell->getColumn()) {
						$NumeroCIN = $cell->getValue();
					} else if('R' == $cell->getColumn()) {
						$NumeroCarteElectorale = $cell->getValue();
					} else if('S' == $cell->getColumn()) {
						$telephone_chef_menage = $cell->getValue();
					} else if('T' == $cell->getColumn()) {
						$nom_conjoint = $cell->getValue();
					} else if('U' == $cell->getColumn()) {
						$sexe_conjoint = $cell->getValue();
					} else if('V' == $cell->getColumn()) {
						$conjoint_frequente_ecole = $cell->getValue();
					} else if('W' == $cell->getColumn()) {
						$niveau_instruction_conjoint = $cell->getValue();
					} else if('X' == $cell->getColumn()) {
						$conjoint_travail = $cell->getValue();
					} else if('Y' == $cell->getColumn()) {
						$activite_conjoint = $cell->getValue();
					} else if('Z' == $cell->getColumn()) {
						$nin_conjoint = $cell->getValue();
					} else if('AA' == $cell->getColumn()) {
						$carte_electorale_conjoint = $cell->getValue();
					} else if('AB' == $cell->getColumn()) {
						$telephone_conjoint = $cell->getValue();
					} else if('AC' == $cell->getColumn()) {
						$taille_menage = $cell->getValue();
					} else if('AD' == $cell->getColumn()) {
						$nombre_personne_plus_soixantedixans = $cell->getValue();
					} else if('AE' == $cell->getColumn()) {
						$nombre_enfant_moins_quinze_ans = $cell->getValue();
					} else if('AF' == $cell->getColumn()) {
						$nombre_enfant_non_scolarise = $cell->getValue();
					} else if('AG' == $cell->getColumn()) {
						$nombre_personne_handicape = $cell->getValue();
					} else if('AH' == $cell->getColumn()) {
						$adulte_travail = $cell->getValue();
					} else if('AI' == $cell->getColumn()) {
						$nombre_membre_a_etranger = $cell->getValue();
					} else if('AJ' == $cell->getColumn()) {
						$maison_non_dure = $cell->getValue();
					} else if('AK' == $cell->getColumn()) {
						$acces_electricite = $cell->getValue();
					} else if('AL' == $cell->getColumn()) {
						$acces_eau_robinet = $cell->getValue();
					} else if('AM' == $cell->getColumn()) {
						$logement_endommage = $cell->getValue();
					} else if('AN' == $cell->getColumn()) {
						$niveau_degat_logement = $cell->getValue();
					} else if('AO' == $cell->getColumn()) {
						$rehabilitation = $cell->getValue();
					} else if('AP' == $cell->getColumn()) {
						$beneficiaire_autre_programme = $cell->getValue();
					} else if('AQ' == $cell->getColumn()) {
						$membre_fonctionnaire = $cell->getValue();
					} else if('AR' == $cell->getColumn()) {
						$antenne_parabolique = $cell->getValue();
					} else if('AS' == $cell->getColumn()) {
						$possede_frigo = $cell->getValue();
					} else if('AT' == $cell->getColumn()) {
						$chef_menage_femme = $cell->getValue();
					} else if('AU' == $cell->getColumn()) {
						$chef_menage_auplus_primaire = $cell->getValue();
					} else if('AV' == $cell->getColumn()) {
						$chef_menage_auplus_primaire = $cell->getValue();
					} else if('AZ' == $cell->getColumn()) {
						$identifiant_menage = $cell->getValue();
					} else if('BA' == $cell->getColumn()) {
						$score_obtenu = $cell->getValue();
					} else if('BB' == $cell->getColumn()) {
						$rang_obtenu = $cell->getValue();
					} else if('BD' == $cell->getColumn()) {
						$quartier = $cell->getValue();
					} else if('BE' == $cell->getColumn()) {
						$agechefdemenage = $cell->getValue();
					} else if('BF' == $cell->getColumn()) {
						$age_conjoint = $cell->getValue();
					}
				}
				// Formatage valeur
				if(intval($SexeChefMenage)==1) {
					$SexeChefMenage="H";
				} else {
					$SexeChefMenage="F";
				}
				if(intval($chef_frequente_ecole)==2) {
					$chef_frequente_ecole=0;
				}
				if(intval($chef_menage_travail)==2) {
					$chef_menage_travail=0;
				}
				if(intval($sexe_conjoint)==1) {
					$sexe_conjoint="H";
				} else {
					$sexe_conjoint="F";
				}
				if(intval($conjoint_frequente_ecole)==2) {
					$conjoint_frequente_ecole=0;
				}
				if(intval($conjoint_travail)==2) {
					$conjoint_travail=0;
				}
				if(intval($maison_non_dure)==2) {
					$maison_non_dure=0;
				}
				if(intval($acces_electricite)==2) {
					$acces_electricite=0;
				}
				if(intval($acces_eau_robinet)==2) {
					$acces_eau_robinet=0;
				}
				if(intval($logement_endommage)==2) {
					$logement_endommage=0;
				}
				if(intval($beneficiaire_autre_programme)==2) {
					$beneficiaire_autre_programme=0;
				}
				if(intval($membre_fonctionnaire)==2) {
					$membre_fonctionnaire=0;
				}
				if(intval($antenne_parabolique)==2) {
					$antenne_parabolique=0;
				}
				if(intval($possede_frigo)==2) {
					$possede_frigo=0;
				}
				if(intval($id_sous_projet) ==1 || intval($id_sous_projet) ==2) {
					// 1 : ACT , 2 : ARSE
					$agechefdemenage=null;
					$age_conjoint=null;
					$quartier = null;
				} else {
					if($agechefdemenage=="") {
						$agechefdemenage=null;
					}
					if($age_conjoint=="") {
						$age_conjoint=null;
					}
				}	
				// Formatage valeur
				// Controle info erronnée
				if(!$date_inscription) {
					$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_date_inscription = $erreur_date_inscription + 1;						
				}
				if($nomchefmenage=="") {
					$sheet->getStyle("K".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_chef_menage = $erreur_nom_chef_menage + 1;						
				}
				if($SexeChefMenage=="") {
					$sheet->getStyle("L".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sexechefmenage = $erreur_sexechefmenage + 1;						
				}
				if($identifiant_menage=="") {
					$sheet->getStyle("AZ".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
				} else {
					// TEST DOUBLON
					$identifiant_menage =strtoupper($identifiant_menage);
					$ret=$this->ImportationmenageManager->selection_identifiant_menage($identifiant_menage);
					$nombre=0;
					foreach($ret as $k=>$v) {
						$nombre=$v->nombre;
					}
					if($nombre >0) {
						$sheet->getStyle("AZ".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("BC".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						 $sheet->setCellValue("BC".$ligne, "Identifiant DOUBLON");
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					}
				}
				if($nom_conjoint>"" && $sexe_conjoint=="") {
					$sheet->getStyle("U".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sexe_conjoint = $erreur_sexe_conjoint + 1;						
				}
				$ile_id=null;
				$region_id=null;
				$commune_id=null;
				$village_id = null;
				$code_village = "";
				$code_commune='';
				$reg=array();
				$place_espace = strpos($ile," ");
				$place_apostrophe = strpos($ile,"'");
				$ile=strtolower($ile);
				if($ile >'') {
					if($place_espace >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_espace - 1));
						$region_temporaire2 = substr ( $ile , ($place_espace + 1));
						$reg = $this->ImportationmenageManager->selectionile_avec_espace($region_temporaire1,$region_temporaire2);
					} else if($place_apostrophe >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_apostrophe - 1));
						$region_temporaire2 = substr ( $ile , ($place_apostrophe + 1));
					} else {	
						$reg = $this->ImportationmenageManager->selectionile($ile);
					}	
					if(count($reg) >0) {
						foreach($reg as $indice=>$v) {
							$ile_id = $v->id;
							$code_ile=$v->code;
							$nom_ile=$v->ile;
						} 						
					} else {
						// Pas de ile : marquer tous les découpages administratif 
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_nom_ile = $erreur_nom_ile + 1;	
					}	
					if(intval($ile_id) >0) {
						if($prefecture >'') {
							$region_ok = true;
							$place_espace = strpos($prefecture," ");
							$place_apostrophe = strpos($prefecture,"'"); 	
							if($place_espace >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_espace - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_espace + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else if($place_apostrophe >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_apostrophe - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_apostrophe + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else {
								$dis = $this->ImportationmenageManager->selectionileprefecture($prefecture,$ile_id);
							}	
							if(count($dis) >0) {
								foreach($dis as $indice=>$v) {
									$region_id = $v->id;
									$codeprefecture= $v->code;
									$nom_prefecture= $v->region;
								}
							} else {
								// Pas de prefecture : marquer prefecture,commune,village 
								$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$nombre_erreur = $nombre_erreur + 1;	
								$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
							}
							if(intval($region_id) >0) {
								if($commune >'') {
									$district_ok = true;
									$place_espace = strpos($commune," ");
									$place_apostrophe = strpos($commune,"'");
									if($place_espace >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_espace - 1));
										$commune_temporaire2 = substr ( $commune , ($place_espace + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else if($place_apostrophe >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_apostrophe - 1));
										$commune_temporaire2 = substr ( $commune , ($place_apostrophe + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else {
										$comm = $this->ImportationmenageManager->selectioncommune($commune,$region_id);
									}	
									if(count($comm) >0) {
										foreach($comm as $indice=>$v) {
											$commune_id = $v->id;
											$code_commune = $v->code;
											$nom_commune = $v->commune;
										}
									} else {
										// Pas de commune : marquer commune,village 
										$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$nombre_erreur = $nombre_erreur + 1;
										$erreur_nom_commune = $erreur_nom_commune + 1;	
									}	
									if(intval($commune_id) >0) {
										if($village >'') {
											$place_espace = strpos($village," ");
											$place_apostrophe = strpos($village,"'");
											if($place_espace >0) {
												$village_temporaire1 = substr ( $village , 0 ,($place_espace - 1));
												$village_temporaire2 = substr ( $village , ($place_espace + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else if($place_apostrophe >0){
												$village_temporaire1 = substr ( $village , 0 ,($place_apostrophe - 1));
												$village_temporaire2 = substr ( $village , ($place_apostrophe + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else {
												$fkt = $this->ImportationmenageManager->selectionvillage($village,$commune_id);
											}	
											if(count($fkt) >0) {
												foreach($fkt as $indice=>$v) {
													// A utliser ultérieurement lors de la deuxième vérification : village_id
													$village_id = $v->id;
													$code_village = $v->code;
													$nom_village = $v->village;
												}
												$sheet->setCellValue("J3", $village_id);
											} else {													
												// Pas de village : marquer village 
												$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
														 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
															 'startcolor' => array('rgb' => 'FF0000'),
															 'endcolor'   => array('argb' => 'FF0000')
														 )
												 );	
												$nombre_erreur = $nombre_erreur + 1;
												$erreur_nom_village = $erreur_nom_village + 1;	
											}												
										} else {
											// Pas de village : marquer village 
											$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_village = $erreur_nom_village + 1;	
										}
									} 
								} else {										
									// Pas de commune : marquer commune,village 
									$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$nombre_erreur = $nombre_erreur + 1;
									$erreur_nom_commune = $erreur_nom_commune + 1;	
								}		
							}
						} else {
							// Pas de prefecture : marquer prefecture,commune,village 
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	

							 $sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$nombre_erreur = $nombre_erreur + 1;
							$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
						}		
					}
				} else {
					// Pas de région : marquer tous les découpages administratif 
					$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_ile = $erreur_nom_ile + 1;	
				}
				// DEBUT INSERTION BDD
					$data=array();
						$a_inserer =TRUE;	
						$nombre_insere=$nombre_insere + 1;
						$identifiant_menage =strtoupper($identifiant_menage);
						$data = array(
							'statut'                        	    => "INSCRIT",
							'village_id'                        	=> $village_id,
							'point_inscription'                 	=> $point_inscription,
							'NumeroEnregistrement'	                =>	$numeroenregistrement,
							'DateInscription'                   	=>	$date_inscription,
							'milieu'                            	=>	$milieu,
							'zip'	                                =>	$zip,
							'Addresse'	                            =>	$adresse,
							'nomchefmenage'                      	=>	$nomchefmenage,
							'SexeChefMenage'	                    =>	$SexeChefMenage,
							'chef_frequente_ecole'              	=>	$chef_frequente_ecole,
							'niveau_instruction_chef'	            =>	$niveau_instruction_chef,
							'chef_menage_travail'               	=>	$chef_menage_travail,
							'activite_chef_menage'	                =>	$activite_chef_menage,
							'NumeroCIN'	                            =>	$NumeroCIN,
							'NumeroCarteElectorale'                	=>	$NumeroCarteElectorale,
							'telephone_chef_menage'	                =>	$telephone_chef_menage,
							'nom_conjoint'	                        =>	$nom_conjoint,
							'sexe_conjoint'	                        =>	$sexe_conjoint,
							'conjoint_frequente_ecole'	            =>	$conjoint_frequente_ecole,
							'niveau_instruction_conjoint'	        =>	$niveau_instruction_conjoint,
							'conjoint_travail'                    	=>	$conjoint_travail,
							'activite_conjoint'	                    =>	$activite_conjoint,
							'nin_conjoint'	                        =>	$nin_conjoint,
							'carte_electorale_conjoint'	            =>	$carte_electorale_conjoint,
							'telephone_conjoint'	                =>	$telephone_conjoint,
							'taille_menage'	                        =>	$taille_menage,
							'nombre_personne_plus_soixantedixans'	=>	$nombre_personne_plus_soixantedixans,
							'nombre_enfant_moins_quinze_ans'	    =>	$nombre_enfant_moins_quinze_ans,
							'nombre_enfant_non_scolarise'	        =>	$nombre_enfant_non_scolarise,
							'nombre_personne_handicape'	            =>	$nombre_personne_handicape,
							'nombre_adulte_travail'             	=>	$adulte_travail,
							'nombre_membre_a_etranger'	            =>	$nombre_membre_a_etranger,
							'maison_non_dure'                   	=>	$maison_non_dure,
							'acces_electricite'                 	=>	$acces_electricite,
							'acces_eau_robinet'	                    =>	$acces_eau_robinet,
							'logement_endommage'	                =>	$logement_endommage,
							'niveau_degat_logement'	                =>	$niveau_degat_logement,
							'rehabilitation'	                    =>	$rehabilitation,
							'beneficiaire_autre_programme'	        =>	$beneficiaire_autre_programme,
							'membre_fonctionnaire'	                =>	$membre_fonctionnaire,
							'antenne_parabolique'	                =>	$antenne_parabolique,
							'possede_frigo'                     	=>	$possede_frigo,
							'identifiant_menage'	                =>	$identifiant_menage,
							'score_obtenu'	                        =>	$score_obtenu,
							'rang_obtenu'	                        =>	$rang_obtenu,
							'id_sous_projet'	                    => $id_sous_projet,
						); 
					// Remplacer le caractère simple cote par espace : provoque erreur lors de l'insertion
					$nomchefmenage=str_replace($search,$replace,$nomchefmenage);
					$nom_conjoint=str_replace($search,$replace,$nom_conjoint);
					$activite_chef_menage=str_replace($search,$replace,$activite_chef_menage);
					$activite_conjoint=str_replace($search,$replace,$activite_conjoint);
					// Ajout 3 champs historique de passage statut INSCRIT,PRESELECTIONNE,BENEFICIAIRE
					$inscrit=1;
					$preselectionne=0;
					$beneficiaire=0;					
					$array_retour[] =$data;
					$requete .="('INSCRIT','";
					$requete .= $village_id."','";					
					$requete .= $point_inscription."','";					
					$requete .= $numeroenregistrement."','";					
					$requete .= $date_inscription."','";					
					$requete .= $milieu."','";					
					$requete .= $zip."','";					
					$requete .= $adresse."','";					
					$requete .= $nomchefmenage."','";					
					$requete .= $SexeChefMenage."','";					
					$requete .= $chef_frequente_ecole."','";					
					$requete .= $niveau_instruction_chef."','";					
					$requete .= $chef_menage_travail."','";					
					$requete .= $activite_chef_menage."','";					
					$requete .= $NumeroCIN."','";					
					$requete .= $NumeroCarteElectorale."','";					
					$requete .= $telephone_chef_menage."','";					
					$requete .= $nom_conjoint."','";					
					$requete .= $sexe_conjoint."','";					
					$requete .= $conjoint_frequente_ecole."','";					
					$requete .= $niveau_instruction_conjoint."','";					
					$requete .= $conjoint_travail."','";					
					$requete .= $activite_conjoint."','";					
					$requete .= $nin_conjoint."','";					
					$requete .= $carte_electorale_conjoint."','";					
					$requete .= $telephone_conjoint."','";					
					$requete .= $taille_menage."','";					
					$requete .= $nombre_personne_plus_soixantedixans."','";					
					$requete .= $nombre_enfant_moins_quinze_ans."','";					
					$requete .= $nombre_enfant_non_scolarise."','";					
					$requete .= $nombre_personne_handicape."','";					
					$requete .= $adulte_travail."','";					
					$requete .= $nombre_membre_a_etranger."','";					
					$requete .= $maison_non_dure."','";					
					$requete .= $acces_electricite."','";					
					$requete .= $acces_eau_robinet."','";					
					$requete .= $logement_endommage."','";					
					$requete .= $niveau_degat_logement."','";					
					$requete .= $rehabilitation."','";					
					$requete .= $beneficiaire_autre_programme."','";					
					$requete .= $membre_fonctionnaire."','";					
					$requete .= $antenne_parabolique."','";					
					$requete .= $possede_frigo."','";					
					$requete .= $identifiant_menage."','";					
					$requete .= $score_obtenu."','";					
					$requete .= $rang_obtenu."','";					
					$requete .= $quartier."','";					
					$requete .= $agechefdemenage."','";					
					$requete .= $age_conjoint."','";					
					$requete .= $inscrit."','";					
					$requete .= $preselectionne."','";					
					$requete .= $beneficiaire."','";					
					$requete .= $id_sous_projet."'),";
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_sous_projet"] = $erreur_sous_projet;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_date_inscription"] = $erreur_date_inscription;
		$val_ret["erreur_nom_chef_menage"] = $erreur_nom_chef_menage;
		$val_ret["erreur_sexechefmenage"] = $erreur_sexechefmenage;
		$val_ret["erreur_identifiant_menage"] = $erreur_identifiant_menage;
		$val_ret["erreur_sexe_conjoint"] = $erreur_sexe_conjoint;
		$enregistrement_insere=array(); // Valeur retourné pour affichage après insertion
		$sous_projet=array(); // Valeur retourné pour affichage après insertion
		if($erreur_sous_projet==0 && $erreur_nom_ile==0 && $erreur_nom_prefecture==0 && $erreur_nom_commune==0 && $erreur_nom_village==0 && $erreur_date_inscription==0 && $erreur_nom_chef_menage==0 && $erreur_sexechefmenage==0 && $erreur_identifiant_menage==0 && $erreur_sexe_conjoint==0) {
			// SANS ERREUR APRES CONTROLE
					$sheet->setCellValue('C1', "DÉJÀ IMPORTÉ");	
					$sheet->getStyle('C1')->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );		
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			// Avant insertion dans la table menage par insert into ..... values
			// il faut récupérer id MAX de table pour savoir les enregistrements insérés dernièrement
			$mng = $this->ImportationmenageManager->getIdMaxMenage();
			foreach($mng as $k=>$v) {
				$id_max_menage = intval($v->id) + 1;
			}
			// INSERTION DANS TABLE MENAGE
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into menage(statut ,village_id,point_inscription,NumeroEnregistrement,DateInscription,milieu,zip,Addresse,nomchefmenage,SexeChefMenage,chef_frequente_ecole,niveau_instruction_chef,chef_menage_travail,activite_chef_menage,NumeroCIN,NumeroCarteElectorale,telephone_chef_menage,nom_conjoint,sexe_conjoint,conjoint_frequente_ecole,niveau_instruction_conjoint,conjoint_travail,activite_conjoint,nin_conjoint,carte_electorale_conjoint,telephone_conjoint,taille_menage,nombre_personne_plus_soixantedixans,nombre_enfant_moins_quinze_ans,nombre_enfant_non_scolarise,nombre_personne_handicape,nombre_adulte_travail,nombre_membre_a_etranger,maison_non_dure,acces_electricite,acces_eau_robinet,logement_endommage,niveau_degat_logement,rehabilitation,beneficiaire_autre_programme,membre_fonctionnaire,antenne_parabolique,possede_frigo,identifiant_menage,score_obtenu,rang_obtenu,quartier,agechefdemenage,age_conjoint,inscrit,preselectionne,beneficiaire,id_sous_projet) values ".$requete;
			$count_update = $this->RequeteimportManager->Execution_requete($requete);
			
			//////////////////////////////////////////////////////////////////////////////////////
			// DEBUT LECTURE FEUILLE 2 : PRESELECTIONNE
			//////////////////////////////////////////////////////////////////////////////////////
			$sheet2 = $Excel->setActiveSheetIndex(1);
			$rowIterator = $sheet2->getRowIterator();
			// DEBUT A CONTROLER
			$erreur_identifiant_menage=0;
			// FIN A CONTROLER
			$nombre_erreur_preselectionne=0;
			$requete =" ";	
			$liste_menage_id="(";	
			foreach($rowIterator as $row) {
				 $ligne = $row->getRowIndex ();
				 // Lecture a partir de la ligne 2
				if($ligne >=2) {
					 $cellIterator = $row->getCellIterator();
					 // Loop all cells, even if it is not set
					 $cellIterator->setIterateOnlyExistingCells(false);
					 $rowIndex = $row->getRowIndex ();
					 foreach ($cellIterator as $cell) {
						 if('A' == $cell->getColumn()) {
								$identifiant_menage =strtoupper($cell->getValue());
						 }
					}	
					$menage_id=0;
					$village_id=0;
					if($identifiant_menage=="") {
						// Pas d'identifiant ménage : 
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					} else {
						$ret = $this->ImportationmenageManager->selectionMenage_Par_Identifiant($identifiant_menage);
						if(count($ret) >0) {
							foreach($ret as $indice=>$v) {
								$menage_id = $v->id;
								$village_id = $v->village_id;
							} 						
						} else {
							// Pas d'identifiant ménage : 
							$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							 $sheet->setCellValue("J".$ligne, "Identifiant INTROUVABLE");
							$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
							$erreur_identifiant_menage = $erreur_identifiant_menage + 1;	
						}	
					}
					if($menage_id >0) {
						$liste_menage_id = $liste_menage_id .$menage_id.",";
					}	
				} 
			
			}
			// PREPARATION ET MISE A JOUR STATUT	
			$ou = strrpos($liste_menage_id,",");
			$liste_menage_id = substr($liste_menage_id,0,$ou);
			$liste_menage_id = $liste_menage_id.")";
			$ret1 = $this->ImportationmenageManager->MiseajourStatut("PRESELECTIONNE",$liste_menage_id);
			$ret2 = $this->ImportationmenageManager->MiseajourHistoriqueStatut("preselectionne",$liste_menage_id);
			//////////////////////////////////////////////////////////////////////////////////////
			// FIN LECTURE FEUILLE 2 : PRESELECTIONNE
			//////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////
			// DEBUT LECTURE FEUILLE 3 : BENEFICIAIRE
			//////////////////////////////////////////////////////////////////////////////////////
			$sheet3 = $Excel->setActiveSheetIndex(2);
			$rowIterator = $sheet3->getRowIterator();
			// DEBUT A CONTROLER
			$erreur_identifiant_menage=0;
			// FIN A CONTROLER
			$nombre_erreur_preselectionne=0;
			$requete =" ";	
			$liste_menage_id="(";	
			foreach($rowIterator as $row) {
				 $ligne = $row->getRowIndex ();
				 // Lecture a partir de la ligne 2
				if($ligne >=2) {
					 $cellIterator = $row->getCellIterator();
					 // Loop all cells, even if it is not set
					 $cellIterator->setIterateOnlyExistingCells(false);
					 $rowIndex = $row->getRowIndex ();
					 foreach ($cellIterator as $cell) {
						 if('A' == $cell->getColumn()) {
								$identifiant_menage =strtoupper($cell->getValue());
						 }
					}	
					$menage_id=0;
					$village_id=9999;
					$date_inscription_menage=null;
					if($identifiant_menage=="") {
						// Pas d'identifiant ménage : 
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					} else {
						$ret = $this->ImportationmenageManager->selectionMenage_Par_Identifiant($identifiant_menage);
						if(count($ret) >0) {
							foreach($ret as $indice=>$v) {
								$menage_id = $v->id;
								$village_id = $v->village_id;
								$date_inscription_menage = $v->DateInscription;
							} 						
						} else {
							// Pas d'identifiant ménage : 
							$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							 $sheet->setCellValue("J".$ligne, "Identifiant INTROUVABLE");
							$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
							$erreur_identifiant_menage = $erreur_identifiant_menage + 1;	
						}	
					}
					if($menage_id >0) {
						$liste_menage_id = $liste_menage_id .$menage_id.",";
						$requete .="('".$menage_id."','";
						$requete .= $id_sous_projet."','";					
						$requete .= $date_inscription_menage."'),";
					}	
				} 
			
			}
			// PREPARATION ET MISE A JOUR STATUT	
			$ou = strrpos($liste_menage_id,",");
			$liste_menage_id = substr($liste_menage_id,0,$ou);
			$liste_menage_id = $liste_menage_id.")";
			$ret1 = $this->ImportationmenageManager->MiseajourStatut("BENEFICIAIRE",$liste_menage_id);
			$ret2 = $this->ImportationmenageManager->MiseajourHistoriqueStatut("beneficiaire",$liste_menage_id);
			// ET INSERTION DANS MENAGE BENEFICIAIRE
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into menage_beneficiaire(id_menage ,id_sous_projet,date_inscription) values ".$requete;
			$count_update = $this->RequeteimportManager->Execution_requete($requete);			
			//////////////////////////////////////////////////////////////////////////////////////
			// FIN LECTURE FEUILLE 3 : BENEFICIAIRE
			//////////////////////////////////////////////////////////////////////////////////////
			
			// RECUPERATION ENREGISTRMENT INSERES
			$enregistrement_insere = $this->ImportationmenageManager->MenageInseresDernierement($id_max_menage);
			$sous_projet = $this->SousprojetManager->findById($id_sous_projet);
			unset($objet_read_write,$excel,$Excel);	
		}			
		if($nombre_erreur==0) {
			$status=TRUE;
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'menage'  => $enregistrement_insere,
			'sous_projet'  => $sous_projet,
			'nom_ile'  => $nom_ile,
			'nom_prefecture'  => $nom_prefecture,
			'nom_commune'  => $nom_commune,
			'nom_village'  => $nom_village,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);		  
	}	
	public function controler_menage_act($chemin,$nomfichier) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$directoryName = dirname(__FILE__) . "/../../../../importmenage/".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_date_inscription=0;
		$erreur_nom_chef_menage=0;
		$erreur_sexechefmenage=0;
		$erreur_identifiant_menage=0;
		$erreur_sexe_conjoint=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$erreur_nbjour="";
		$erreur_annee="";
		$erreur_activite="";
		$erreur_etape="";
		$deja_importe="";
		$requete =" ";		
		$nombre_insere=0;
		$array_insere=array();
		$depart_ligne_lecture=3;
		$nom_ile="";
		$nom_prefecture="";
		$nom_commune="";
		$nom_village="";
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 5
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('B' == $cell->getColumn()) {
							$sous_projet_activite =$cell->getValue();
					 }
				}	
				if($sous_projet_activite=="") {
					// Pas de sous projet : 
					$sheet->getStyle("B1")->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sous_projet = $erreur_sous_projet + 1;						
				} else {
					$sous_projet_activite =strtolower($sous_projet_activite);
					$ssprj = $this->ImportationmenageManager->selectionsous_projet($sous_projet_activite);
					if(count($ssprj) >0) {
						foreach($ssprj as $indice=>$v) {
							$id_sous_projet = $v->id;
							$code_sous_projet=$v->code;
						} 						
					} else {
						// Pas de sous projet : 
						$sheet->getStyle("B1")->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_sous_projet = $erreur_sous_projet + 1;	
					}	
				}					
			} 
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$identifiant_menage =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
						$ile = $cell->getValue();
					} else if('C' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('D' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$milieu = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('G' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('H' == $cell->getColumn()) {
						$adresse = $cell->getValue();
					} else if('I' == $cell->getColumn()) {
						$nomchefmenage = $cell->getValue();
					} else if('J' == $cell->getColumn()) {
						$NumeroCIN = $cell->getValue();
					} else if('K' == $cell->getColumn()) {
						$NumeroCarteElectorale = $cell->getValue();
					} else if('L' == $cell->getColumn()) {
						$telephone_chef_menage = $cell->getValue();
					} else if('M' == $cell->getColumn()) {
						$score_obtenu = $cell->getValue();
					} else if('N' == $cell->getColumn()) {
						$rang_obtenu = $cell->getValue();
					}
				}
				// Controle info erronnée
				if($nomchefmenage=="") {
					$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_chef_menage = $erreur_nom_chef_menage + 1;						
				}
				if($identifiant_menage=="") {
					$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
				} else {
					// TEST DOUBLON
					$identifiant_menage =strtoupper($identifiant_menage);
					$ret=$this->ImportationmenageManager->selection_identifiant_menage($identifiant_menage);
					$nombre=0;
					foreach($ret as $k=>$v) {
						$nombre=$v->nombre;
					}
					if($nombre >0) {
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("O".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						 $sheet->setCellValue("O".$ligne, "Identifiant DOUBLON");
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					}
				}
				$ile_id=null;
				$region_id=null;
				$commune_id=null;
				$village_id = null;
				$code_village = "";
				$code_commune='';
				$reg=array();
				$place_espace = strpos($ile," ");
				$place_apostrophe = strpos($ile,"'");
				$ile=strtolower($ile);
				if($ile >'') {
					if($place_espace >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_espace - 1));
						$region_temporaire2 = substr ( $ile , ($place_espace + 1));
						$reg = $this->ImportationmenageManager->selectionile_avec_espace($region_temporaire1,$region_temporaire2);
					} else if($place_apostrophe >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_apostrophe - 1));
						$region_temporaire2 = substr ( $ile , ($place_apostrophe + 1));
					} else {	
						$reg = $this->ImportationmenageManager->selectionile($ile);
					}	
					if(count($reg) >0) {
						foreach($reg as $indice=>$v) {
							$ile_id = $v->id;
							$code_ile=$v->code;
							$nom_ile=$v->ile;
						} 						
					} else {
						// Pas de ile : marquer tous les découpages administratif 
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_nom_ile = $erreur_nom_ile + 1;	
					}	
					if(intval($ile_id) >0) {
						if($prefecture >'') {
							$region_ok = true;
							$place_espace = strpos($prefecture," ");
							$place_apostrophe = strpos($prefecture,"'"); 	
							if($place_espace >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_espace - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_espace + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else if($place_apostrophe >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_apostrophe - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_apostrophe + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else {
								$dis = $this->ImportationmenageManager->selectionileprefecture($prefecture,$ile_id);
							}	
							if(count($dis) >0) {
								foreach($dis as $indice=>$v) {
									$region_id = $v->id;
									$codeprefecture= $v->code;
									$nom_prefecture= $v->region;
								}
							} else {
								// Pas de prefecture : marquer prefecture,commune,village 
								$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$nombre_erreur = $nombre_erreur + 1;	
								$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
							}
							if(intval($region_id) >0) {
								if($commune >'') {
									$district_ok = true;
									$place_espace = strpos($commune," ");
									$place_apostrophe = strpos($commune,"'");
									if($place_espace >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_espace - 1));
										$commune_temporaire2 = substr ( $commune , ($place_espace + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else if($place_apostrophe >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_apostrophe - 1));
										$commune_temporaire2 = substr ( $commune , ($place_apostrophe + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else {
										$comm = $this->ImportationmenageManager->selectioncommune($commune,$region_id);
									}	
									if(count($comm) >0) {
										foreach($comm as $indice=>$v) {
											$commune_id = $v->id;
											$code_commune = $v->code;
											$nom_commune = $v->commune;
										}
									} else {
										// Pas de commune : marquer commune,village 
										$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$nombre_erreur = $nombre_erreur + 1;
										$erreur_nom_commune = $erreur_nom_commune + 1;	
									}	
									if(intval($commune_id) >0) {
										if($village >'') {
											$place_espace = strpos($village," ");
											$place_apostrophe = strpos($village,"'");
											if($place_espace >0) {
												$village_temporaire1 = substr ( $village , 0 ,($place_espace - 1));
												$village_temporaire2 = substr ( $village , ($place_espace + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else if($place_apostrophe >0){
												$village_temporaire1 = substr ( $village , 0 ,($place_apostrophe - 1));
												$village_temporaire2 = substr ( $village , ($place_apostrophe + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else {
												$fkt = $this->ImportationmenageManager->selectionvillage($village,$commune_id);
											}	
											if(count($fkt) >0) {
												foreach($fkt as $indice=>$v) {
													// A utliser ultérieurement lors de la deuxième vérification : village_id
													$village_id = $v->id;
													$code_village = $v->code;
													$nom_village = $v->village;
												}
												$sheet->setCellValue("J1", $village_id);
											} else {													
												// Pas de village : marquer village 
												$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
														 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
															 'startcolor' => array('rgb' => 'FF0000'),
															 'endcolor'   => array('argb' => 'FF0000')
														 )
												 );	
												$nombre_erreur = $nombre_erreur + 1;
												$erreur_nom_village = $erreur_nom_village + 1;	
											}												
										} else {
											// Pas de village : marquer village 
											$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_village = $erreur_nom_village + 1;	
										}
									} 
								} else {										
									// Pas de commune : marquer commune,village 
									$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$nombre_erreur = $nombre_erreur + 1;
									$erreur_nom_commune = $erreur_nom_commune + 1;	
								}		
							}
						} else {
							// Pas de prefecture : marquer prefecture,commune,village 
							$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	

							 $sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$nombre_erreur = $nombre_erreur + 1;
							$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
						}		
					}
				} else {
					// Pas de région : marquer tous les découpages administratif 
					$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_ile = $erreur_nom_ile + 1;	
				}
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_sous_projet"] = $erreur_sous_projet;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_nom_chef_menage"] = $erreur_nom_chef_menage;
		$val_ret["erreur_identifiant_menage"] = $erreur_identifiant_menage;
		if($nombre_erreur==0) {
			$status=TRUE;
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);			  
	}	
	public function importer_menage_act($chemin,$nomfichier) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$trouvez =array("'");
		$remplacez =array(" ");
		$directoryName = dirname(__FILE__) . "/../../../../importmenage/".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_date_inscription=0;
		$erreur_nom_chef_menage=0;
		$erreur_sexechefmenage=0;
		$erreur_identifiant_menage=0;
		$erreur_sexe_conjoint=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$erreur_nbjour="";
		$erreur_annee="";
		$erreur_activite="";
		$erreur_etape="";
		$deja_importe="";
		$requete =" ";		
		$nombre_insere=0;
		$array_insere=array();
		$depart_ligne_lecture=3;
		$nom_ile="";
		$nom_prefecture="";
		$nom_commune="";
		$nom_village="";
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 5
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('B' == $cell->getColumn()) {
							$sous_projet_activite =$cell->getValue();
					 }
				}	
				if($sous_projet_activite=="") {
					// Pas de sous projet : 
					$sheet->getStyle("B1")->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_sous_projet = $erreur_sous_projet + 1;						
				} else {
					$sous_projet_activite =strtolower($sous_projet_activite);
					$ssprj = $this->ImportationmenageManager->selectionsous_projet($sous_projet_activite);
					if(count($ssprj) >0) {
						foreach($ssprj as $indice=>$v) {
							$id_sous_projet = $v->id;
							$code_sous_projet=$v->code;
						} 						
					} else {
						// Pas de sous projet : 
						$sheet->getStyle("B1")->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_sous_projet = $erreur_sous_projet + 1;	
					}	
				}					
			} 
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$identifiant_menage =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
						$ile = $cell->getValue();
					} else if('C' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('D' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$milieu = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('G' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('H' == $cell->getColumn()) {
						$adresse = $cell->getValue();
					} else if('I' == $cell->getColumn()) {
						$nomchefmenage = $cell->getValue();
					} else if('J' == $cell->getColumn()) {
						$NumeroCIN = $cell->getValue();
					} else if('K' == $cell->getColumn()) {
						$NumeroCarteElectorale = $cell->getValue();
					} else if('L' == $cell->getColumn()) {
						$telephone_chef_menage = $cell->getValue();
					} else if('M' == $cell->getColumn()) {
						$score_obtenu = $cell->getValue();
					} else if('N' == $cell->getColumn()) {
						$rang_obtenu = $cell->getValue();
					}
				}
				// Controle info erronnée
				if($nomchefmenage=="") {
					$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_chef_menage = $erreur_nom_chef_menage + 1;						
				}
				if($identifiant_menage=="") {
					$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
				} else {
					// TEST DOUBLON
					$identifiant_menage =strtoupper($identifiant_menage);
					$ret=$this->ImportationmenageManager->selection_identifiant_menage($identifiant_menage);
					$nombre=0;
					foreach($ret as $k=>$v) {
						$nombre=$v->nombre;
					}
					if($nombre >0) {
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("O".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						 $sheet->setCellValue("O".$ligne, "Identifiant DOUBLON");
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					}
				}
				$ile_id=null;
				$region_id=null;
				$commune_id=null;
				$village_id = null;
				$code_village = "";
				$code_commune='';
				$reg=array();
				$place_espace = strpos($ile," ");
				$place_apostrophe = strpos($ile,"'");
				$ile=strtolower($ile);
				if($ile >'') {
					if($place_espace >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_espace - 1));
						$region_temporaire2 = substr ( $ile , ($place_espace + 1));
						$reg = $this->ImportationmenageManager->selectionile_avec_espace($region_temporaire1,$region_temporaire2);
					} else if($place_apostrophe >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_apostrophe - 1));
						$region_temporaire2 = substr ( $ile , ($place_apostrophe + 1));
					} else {	
						$reg = $this->ImportationmenageManager->selectionile($ile);
					}	
					if(count($reg) >0) {
						foreach($reg as $indice=>$v) {
							$ile_id = $v->id;
							$code_ile=$v->code;
							$nom_ile=$v->ile;
						} 						
					} else {
						// Pas de ile : marquer tous les découpages administratif 
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_nom_ile = $erreur_nom_ile + 1;	
					}	
					if(intval($ile_id) >0) {
						if($prefecture >'') {
							$region_ok = true;
							$place_espace = strpos($prefecture," ");
							$place_apostrophe = strpos($prefecture,"'"); 	
							if($place_espace >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_espace - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_espace + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else if($place_apostrophe >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_apostrophe - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_apostrophe + 1));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else {
								$dis = $this->ImportationmenageManager->selectionileprefecture($prefecture,$ile_id);
							}	
							if(count($dis) >0) {
								foreach($dis as $indice=>$v) {
									$region_id = $v->id;
									$codeprefecture= $v->code;
									$nom_prefecture= $v->region;
								}
							} else {
								// Pas de prefecture : marquer prefecture,commune,village 
								$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$nombre_erreur = $nombre_erreur + 1;	
								$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
							}
							if(intval($region_id) >0) {
								if($commune >'') {
									$district_ok = true;
									$place_espace = strpos($commune," ");
									$place_apostrophe = strpos($commune,"'");
									if($place_espace >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_espace - 1));
										$commune_temporaire2 = substr ( $commune , ($place_espace + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else if($place_apostrophe >0) {
										$commune_temporaire1 = substr ( $commune , 0 ,($place_apostrophe - 1));
										$commune_temporaire2 = substr ( $commune , ($place_apostrophe + 1));
										$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
									} else {
										$comm = $this->ImportationmenageManager->selectioncommune($commune,$region_id);
									}	
									if(count($comm) >0) {
										foreach($comm as $indice=>$v) {
											$commune_id = $v->id;
											$code_commune = $v->code;
											$nom_commune = $v->commune;
										}
									} else {
										// Pas de commune : marquer commune,village 
										$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
												 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
													 'startcolor' => array('rgb' => 'FF0000'),
													 'endcolor'   => array('argb' => 'FF0000')
												 )
										 );	
										$nombre_erreur = $nombre_erreur + 1;
										$erreur_nom_commune = $erreur_nom_commune + 1;	
									}	
									if(intval($commune_id) >0) {
										if($village >'') {
											$place_espace = strpos($village," ");
											$place_apostrophe = strpos($village,"'");
											if($place_espace >0) {
												$village_temporaire1 = substr ( $village , 0 ,($place_espace - 1));
												$village_temporaire2 = substr ( $village , ($place_espace + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else if($place_apostrophe >0){
												$village_temporaire1 = substr ( $village , 0 ,($place_apostrophe - 1));
												$village_temporaire2 = substr ( $village , ($place_apostrophe + 1));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else {
												$fkt = $this->ImportationmenageManager->selectionvillage($village,$commune_id);
											}	
											if(count($fkt) >0) {
												foreach($fkt as $indice=>$v) {
													// A utliser ultérieurement lors de la deuxième vérification : village_id
													$village_id = $v->id;
													$code_village = $v->code;
													$nom_village = $v->village;
												}
												$sheet->setCellValue("J1", $village_id);
											} else {													
												// Pas de village : marquer village 
												$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
														 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
															 'startcolor' => array('rgb' => 'FF0000'),
															 'endcolor'   => array('argb' => 'FF0000')
														 )
												 );	
												$nombre_erreur = $nombre_erreur + 1;
												$erreur_nom_village = $erreur_nom_village + 1;	
											}												
										} else {
											// Pas de village : marquer village 
											$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_village = $erreur_nom_village + 1;	
										}
									} 
								} else {										
									// Pas de commune : marquer commune,village 
									$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$nombre_erreur = $nombre_erreur + 1;
									$erreur_nom_commune = $erreur_nom_commune + 1;	
								}		
							}
						} else {
							// Pas de prefecture : marquer prefecture,commune,village 
							$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	

							 $sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$nombre_erreur = $nombre_erreur + 1;
							$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
						}		
					}
				} else {
					// Pas de région : marquer tous les découpages administratif 
					$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_ile = $erreur_nom_ile + 1;	
				}
				// DEBUT INSERTION BDD
					// Remplacer le caractère simple cote par espace : provoque erreur lors de l'insertion
					$nomchefmenage=str_replace($search,$replace,$nomchefmenage);
					$inscrit=1;
					$preselectionne=1;
					$beneficiaire=0;					
					$requete .="('PRESELECTIONNE','";
					$requete .= $village_id."','";					
					$requete .= $milieu."','";					
					$requete .= $zip."','";					
					$requete .= $adresse."','";					
					$requete .= $nomchefmenage."','";					
					$requete .= $NumeroCIN."','";					
					$requete .= $NumeroCarteElectorale."','";					
					$requete .= $telephone_chef_menage."','";					
					$requete .= $identifiant_menage."','";					
					$requete .= $score_obtenu."','";					
					$requete .= $rang_obtenu."','";					
					$requete .= $inscrit."','";					
					$requete .= $preselectionne."','";					
					$requete .= $beneficiaire."','";					
					$requete .= $id_sous_projet."'),";
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_sous_projet"] = $erreur_sous_projet;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_nom_chef_menage"] = $erreur_nom_chef_menage;
		$val_ret["erreur_identifiant_menage"] = $erreur_identifiant_menage;
		$enregistrement_insere=array(); // Valeur retourné pour affichage après insertion
		$sous_projet=array(); // Valeur retourné pour affichage après insertion
		if($erreur_sous_projet==0 && $erreur_nom_ile==0 && $erreur_nom_prefecture==0 && $erreur_nom_commune==0 && $erreur_nom_village==0 && $erreur_nom_chef_menage==0 && $erreur_identifiant_menage==0) {
			// SANS ERREUR APRES CONTROLE
					$sheet->setCellValue('C1', "DÉJÀ IMPORTÉ");	
					$sheet->getStyle('C1')->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );		
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			// Avant insertion dans la table menage par insert into ..... values
			// il faut récupérer id MAX de table pour savoir les enregistrements insérés dernièrement
			$mng = $this->ImportationmenageManager->getIdMaxMenage();
			foreach($mng as $k=>$v) {
				$id_max_menage = intval($v->id) + 1;
			}
			// INSERTION DANS TABLE MENAGE
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into menage(statut ,village_id,milieu,zip,Addresse,nomchefmenage,NumeroCIN,NumeroCarteElectorale,telephone_chef_menage,identifiant_menage,score_obtenu,rang_obtenu,inscrit,preselectionne,beneficiaire,id_sous_projet) values ".$requete;
			$count_update = $this->RequeteimportManager->Execution_requete($requete);
			
			//////////////////////////////////////////////////////////////////////////////////////
			// DEBUT LECTURE FEUILLE 2 : BENEFICIAIRE
			//////////////////////////////////////////////////////////////////////////////////////
			$sheet2 = $Excel->setActiveSheetIndex(1);
			$rowIterator = $sheet2->getRowIterator();
			// DEBUT A CONTROLER
			$erreur_identifiant_menage=0;
			// FIN A CONTROLER
			$nombre_erreur_preselectionne=0;
			$requete =" ";	
			$liste_menage_id="(";	
			foreach($rowIterator as $row) {
				 $ligne = $row->getRowIndex ();
				 // Lecture a partir de la ligne 2
				if($ligne >=2) {
					 $cellIterator = $row->getCellIterator();
					 // Loop all cells, even if it is not set
					 $cellIterator->setIterateOnlyExistingCells(false);
					 $rowIndex = $row->getRowIndex ();
					 foreach ($cellIterator as $cell) {
						 if('A' == $cell->getColumn()) {
								$identifiant_menage =strtoupper($cell->getValue());
						 }
					}	
					$menage_id=0;
					$village_id=9999;
					$date_inscription_menage=null;
					if($identifiant_menage=="") {
						// Pas d'identifiant ménage : 
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
						$erreur_identifiant_menage = $erreur_identifiant_menage + 1;						
					} else {
						$ret = $this->ImportationmenageManager->selectionMenage_Par_Identifiant($identifiant_menage);
						if(count($ret) >0) {
							foreach($ret as $indice=>$v) {
								$menage_id = $v->id;
								$village_id = $v->village_id;
								$date_inscription_menage = $v->DateInscription;
							} 						
						} else {
							// Pas d'identifiant ménage : 
							$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							 $sheet->setCellValue("J".$ligne, "Identifiant INTROUVABLE");
							$nombre_erreur_preselectionne = $nombre_erreur_preselectionne + 1;
							$erreur_identifiant_menage = $erreur_identifiant_menage + 1;	
						}	
					}
					if($menage_id >0) {
						$liste_menage_id = $liste_menage_id .$menage_id.",";
						$requete .="('".$menage_id."','";
						$requete .= $id_sous_projet."'),";
					}	
				} 
			
			}
			// PREPARATION ET MISE A JOUR STATUT	
			$ou = strrpos($liste_menage_id,",");
			$liste_menage_id = substr($liste_menage_id,0,$ou);
			$liste_menage_id = $liste_menage_id.")";
			$ret = $this->ImportationmenageManager->MiseajourStatut("BENEFICIAIRE",$liste_menage_id);
			$ret = $this->ImportationmenageManager->MiseajourHistoriqueStatut("beneficiaire",$liste_menage_id);
			// INSERTION DANS MENAGE BENEFICIAIRE
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into menage_beneficiaire(id_menage ,id_sous_projet) values ".$requete;
			$count_update = $this->RequeteimportManager->Execution_requete($requete);			
			//////////////////////////////////////////////////////////////////////////////////////
			// FIN LECTURE FEUILLE 2 : BENEFICIAIRE
			//////////////////////////////////////////////////////////////////////////////////////
			
			// RECUPERATION ENREGISTRMENT INSERES
			$enregistrement_insere = $this->ImportationmenageManager->MenageInseresDernierement($id_max_menage);
			$sous_projet = $this->SousprojetManager->findById($id_sous_projet);
			unset($objet_read_write,$excel,$Excel);	
		}			
		if($nombre_erreur==0) {
			$status=TRUE;
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'menage'  => $enregistrement_insere,
			'sous_projet'  => $sous_projet,
			'nom_ile'  => $nom_ile,
			'nom_prefecture'  => $nom_prefecture,
			'nom_commune'  => $nom_commune,
			'nom_village'  => $nom_village,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);		  
	}	
	public function controler_vague_zip() {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$nomfichier="vague_zip.xlsx";
		$chemin="vague/";
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$directoryName = dirname(__FILE__) . "/../../../../".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$nomfichier="vague_zip.xlsx";
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_zip=0;
		$erreur_vague=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$deja_importe="";
		$requete =" ";		
		$nombre_insere=0;
		$array_insere=array();
		$depart_ligne_lecture=2;
		$nom_ile="";
		$nom_prefecture="";
		$nom_commune="";
		$nom_village="";
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 2
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$ile =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('C' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('D' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$vague = $cell->getValue();
					}
				}
				// Controle info erronnée
				$ile=ltrim(rtrim($ile));
				$prefecture=ltrim(rtrim($prefecture));
				$commune=ltrim(rtrim($commune));
				$village=ltrim(rtrim($village));
				if($zip=="") {
					$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$erreur_zip=$erreur_zip + 1;	
					$nombre_erreur = $nombre_erreur + 1; 
				} else {
					$retour=$this->ImportationmenageManager->selectionzipparcode($zip);
					if($retour) {
						foreach($retour as $k=>$v) {
							$id_zip =$v->id;
						}
						$sheet->setCellValue("H".$ligne, $id_zip);
					} else {
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$erreur_zip=$erreur_zip + 1;	
						$nombre_erreur = $nombre_erreur + 1; 						
					}
				}
				if($vague=="") {
					$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );		
					$nombre_erreur = $nombre_erreur + 1;	
					$erreur_vague = $erreur_vague + 1;	
				}
				$ile_id=null;
				$region_id=null;
				$commune_id=null;
				$village_id = null;
				$code_village = "";
				$code_commune='';
				$reg=array();
				$place_espace = strpos($ile," ");
				$place_apostrophe = strpos($ile,"'");
				$ile=strtolower($ile);
				if($ile >'') {
					if($place_espace >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_espace - 1));
						$region_temporaire2 = substr ( $ile , ($place_espace + 1));
						$region_temporaire1 =ltrim(rtrim($region_temporaire1));
						$region_temporaire2 =ltrim(rtrim($region_temporaire2));
						$reg = $this->ImportationmenageManager->selectionile_avec_espace($region_temporaire1,$region_temporaire2);
					} else if($place_apostrophe >0) {
						$region_temporaire1 = substr ( $ile , 0 ,($place_apostrophe - 1));
						$region_temporaire2 = substr ( $ile , ($place_apostrophe + 1));
						$region_temporaire1 =ltrim(rtrim($region_temporaire1));
						$region_temporaire2 =ltrim(rtrim($region_temporaire2));
					} else {	
						$reg = $this->ImportationmenageManager->selectionile($ile);
					}	
					if(count($reg) >0) {
						foreach($reg as $indice=>$v) {
							$ile_id = $v->id;
							$code_ile=$v->code;
							$nom_ile=$v->ile;
						} 	
						$sheet->setCellValue("J".$ligne, $ile_id);	
					} else {
						// Pas de ile : marquer tous les découpages administratif 
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );	
						$nombre_erreur = $nombre_erreur + 1;
						$erreur_nom_ile = $erreur_nom_ile + 1;	
					}	
					if(intval($ile_id) >0) {
						if($prefecture >'') {
							$prefecture=strtolower($prefecture);
							$region_ok = true;
							$place_espace = strpos($prefecture," ");
							$place_apostrophe = strpos($prefecture,"'"); 	
							if($place_espace >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_espace - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_espace + 1));
								$prefecture_temporaire1 =ltrim(rtrim($prefecture_temporaire1));
								$prefecture_temporaire2 =ltrim(rtrim($prefecture_temporaire2));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else if($place_apostrophe >0) {
								$prefecture_temporaire1 = substr ( $prefecture , 0 ,($place_apostrophe - 1));
								$prefecture_temporaire2 = substr ( $prefecture , ($place_apostrophe + 1));
								$prefecture_temporaire1 =ltrim(rtrim($prefecture_temporaire1));
								$prefecture_temporaire2 =ltrim(rtrim($prefecture_temporaire2));
								$dis = $this->ImportationmenageManager->selectionprefecture_avec_espace($prefecture_temporaire1,$prefecture_temporaire2,$ile_id);
							} else {
								$dis = $this->ImportationmenageManager->selectionileprefecture($prefecture,$ile_id);
							}	
							if(count($dis) >0) {
								foreach($dis as $indice=>$v) {
									$region_id = $v->id;
									$codeprefecture= $v->code;
									$nom_prefecture= $v->region;
								}
								$sheet->setCellValue("K".$ligne, $region_id);
							} else {
								// Pas de prefecture : marquer prefecture,commune,village 
								$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );	
								$nombre_erreur = $nombre_erreur + 1;	
								$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
							}
							if(intval($region_id) >0) {
								if($commune >'') {
									$commune=strtolower($commune);
									if($commune=='pimba' || $commune=='itsahidi' || $commune=='domba') {
										if($commune=='itsahidi') {
											$commune_id ='18';
										}
										if($commune=='domba') {
											$commune_id ='19';
										}
										if($commune=='pimba') {
											$commune_id ='20';
										}
									} else {
										$district_ok = true;
										$place_espace = strpos($commune," ");
										$place_apostrophe = strpos($commune,"'");
										if($place_espace >0) {
											$commune_temporaire1 = substr ( $commune , 0 ,($place_espace - 1));
											$commune_temporaire2 = substr ( $commune , ($place_espace + 1));
											$commune_temporaire1 =ltrim(rtrim($commune_temporaire1));
											$commune_temporaire2 =ltrim(rtrim($commune_temporaire2));
											$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
										} else if($place_apostrophe >0) {
											$commune_temporaire1 = substr ( $commune , 0 ,($place_apostrophe - 1));
											$commune_temporaire2 = substr ( $commune , ($place_apostrophe + 1));
											$commune_temporaire1 =ltrim(rtrim($commune_temporaire1));
											$commune_temporaire2 =ltrim(rtrim($commune_temporaire2));
											$comm = $this->ImportationmenageManager->selectioncommune_avec_espace($commune_temporaire1,$commune_temporaire2,$region_id);
										} else {
											$comm = $this->ImportationmenageManager->selectioncommune($commune,$region_id);
										}	
										if(count($comm) >0) {
											foreach($comm as $indice=>$v) {
												$commune_id = $v->id;
												$code_commune = $v->code;
												$nom_commune = $v->commune;
											}
											$sheet->setCellValue("L".$ligne, $commune_id);
										} else {
											// Pas de commune : marquer commune,village 
											$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_commune = $erreur_nom_commune + 1;	
										}	
									}	
									if(intval($commune_id) >0) {
										if($village >'') {
											$place_espace = strpos($village," ");
											$place_apostrophe = strpos($village,"'");
											if($place_espace >0) {
												$village_temporaire1 = substr ( $village , 0 ,($place_espace - 1));
												$village_temporaire2 = substr ( $village , ($place_espace + 1));
												$village_temporaire1 =ltrim(rtrim($village_temporaire1));
												$village_temporaire2 =ltrim(rtrim($village_temporaire2));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else if($place_apostrophe >0){
												$village_temporaire1 = substr ( $village , 0 ,($place_apostrophe - 1));
												$village_temporaire2 = substr ( $village , ($place_apostrophe + 1));
												$village_temporaire1 =ltrim(rtrim($village_temporaire1));
												$village_temporaire2 =ltrim(rtrim($village_temporaire2));
												$fkt = $this->ImportationmenageManager->selectionvillage_avec_espace($village_temporaire1,$village_temporaire2,$commune_id);
											} else {
												$fkt = $this->ImportationmenageManager->selectionvillage($village,$commune_id);
											}	
											if(count($fkt) >0) {
												foreach($fkt as $indice=>$v) {
													// A utliser ultérieurement lors de la deuxième vérification : village_id
													$village_id = $v->id;
													$code_village = $v->code;
													$nom_village = $v->village;
												}
												$sheet->setCellValue("G".$ligne, $village_id);
											} else {													
												// Pas de village : marquer village 
												$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
														 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
															 'startcolor' => array('rgb' => 'FF0000'),
															 'endcolor'   => array('argb' => 'FF0000')
														 )
												 );	
												$nombre_erreur = $nombre_erreur + 1;
												$erreur_nom_village = $erreur_nom_village + 1;	
											}												
										} else {
											// Pas de village : marquer village 
											$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
													 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
														 'startcolor' => array('rgb' => 'FF0000'),
														 'endcolor'   => array('argb' => 'FF0000')
													 )
											 );	
											$nombre_erreur = $nombre_erreur + 1;
											$erreur_nom_village = $erreur_nom_village + 1;	
										}
									} 
								} else {										
									// Pas de commune : marquer commune,village 
									$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
											 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												 'startcolor' => array('rgb' => 'FF0000'),
												 'endcolor'   => array('argb' => 'FF0000')
											 )
									 );	
									$nombre_erreur = $nombre_erreur + 1;
									$erreur_nom_commune = $erreur_nom_commune + 1;	
								}		
							}
						} else {
							// Pas de prefecture : marquer prefecture,commune,village 
							$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	

							 $sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );	
							$nombre_erreur = $nombre_erreur + 1;
							$erreur_nom_prefecture = $erreur_nom_prefecture + 1;	
						}		
					}
				} else {
					// Pas de région : marquer tous les découpages administratif 
					$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );	
					$nombre_erreur = $nombre_erreur + 1;
					$erreur_nom_ile = $erreur_nom_ile + 1;	
				}
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_zip"] = $erreur_zip;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_vague"] = $erreur_vague;
		if($nombre_erreur==0) {
			$status=TRUE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);			  
	}		
	public function importer_vague_zip() {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$nomfichier="vague_zip.xlsx";
		$chemin="vague/";
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$directoryName = dirname(__FILE__) . "/../../../../".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$nomfichier="vague_zip.xlsx";
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_presence <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel5');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet(0)->getRowIterator();
		$numeroligne=0;
		// DEBUT A CONTROLER
		$erreur_sous_projet=0;
		$erreur_nom_ile=0;
		$erreur_nom_prefecture=0;
		$erreur_nom_commune=0;
		$erreur_nom_village=0;
		$erreur_zip=0;
		$erreur_vague=0;
		// FIN A CONTROLER
		$nombre_erreur=0;
		$deja_importe="";
		$requete =" ";		
		$nombre_insere=0;
		$array_insere=array();
		$depart_ligne_lecture=2;
		$nom_ile="";
		$nom_prefecture="";
		$nom_commune="";
		$nom_village="";
		$nombre_maj=0;
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 2
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				 $id_zip=null;
				foreach ($cellIterator as $cell) {
					if('A' == $cell->getColumn()) {
							$ile =$cell->getValue();
					} else if('B' == $cell->getColumn()) {
						$prefecture = $cell->getValue();
					} else if('C' == $cell->getColumn()) {
						$commune = $cell->getValue();
					} else if('D' == $cell->getColumn()) {
						$village = $cell->getValue();
					} else if('E' == $cell->getColumn()) {
						$zip = $cell->getValue();
					} else if('F' == $cell->getColumn()) {
						$vague = $cell->getValue();
					} else if('G' == $cell->getColumn()) {
						$village_id = $cell->getValue();
					} else if('H' == $cell->getColumn()) {
						$id_zip = $cell->getValue();
					}
				}
				if(intval($village_id) >0 && intval($id_zip) >0) {
					$data = array(
						'id_zip' => $id_zip,
						'vague' => $vague,
					);
					$ret =$this->VillageManager->update_zip_vague($village_id, $data);
					if($ret) {
						$nombre_maj = $nombre_maj + 1;
						$sheet->setCellValue("I".$ligne, "OK");
					}
				}
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_zip"] = $erreur_zip;
		$val_ret["erreur_nom_ile"] = $erreur_nom_ile;
		$val_ret["erreur_nom_prefecture"] = $erreur_nom_prefecture;
		$val_ret["erreur_nom_commune"] = $erreur_nom_commune;
		$val_ret["erreur_nom_village"] = $erreur_nom_village;
		$val_ret["erreur_vague"] = $erreur_vague;
		if($nombre_erreur==0) {
			$status=TRUE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		} else {
			$status=FALSE;
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../" .$chemin. $nomfichier);
			unset($objet_read_write,$excel,$Excel);				
		}
		$this->response([
			'status' => $status,
			'retour'  => $val_ret,
			'message' => 'Get file success',
		], REST_Controller::HTTP_OK);			  
	}		
} 
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */