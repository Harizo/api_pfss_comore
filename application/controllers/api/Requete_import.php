<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Requete_import extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('agent_ex_model', 'AgexManager');
        $this->load->model('sous_projet_model', 'SousprojetManager');
        $this->load->model('phaseexecution_model', 'PhaseexecutionManager');
        $this->load->model('annee_model', 'AnneeManager');
        $this->load->model('zip_model', 'ZipManager');
        $this->load->model('requete_export_model', 'RequeteexportManager');
        $this->load->model('requete_import_model', 'RequeteimportManager');
        $this->load->model('fiche_presence_model', 'FichepresenceManager');
        $this->load->model('fiche_presencemenage_model', 'FichepresencemenageManager');
        $this->load->model('fiche_paiement_model', 'FichepaiementManager');
        $this->load->model('fiche_paiementmenage_model', 'FichepaiementmenageManager');
    }

    public function index_get() 
    {
		$importation = $this->get('importation'); 
        $etat_presence= $this->get('etat_presence');
        $etat_paiement= $this->get('etat_paiement');
        $liste_fiche_presence= $this->get('liste_fiche_presence');

		$chemin = $this->get('chemin'); 
		$nomfichier = $this->get('nomfichier'); 
		$observation = $this->get('observation'); 
		$repertoire = $this->get('repertoire'); 
        $id_ile= $this->get('id_ile'); 
        $id_region= $this->get('id_region'); 
        $id_commune= $this->get('id_commune');
        $id_sous_projet= $this->get('id_sous_projet');
        $microprojet_id= $this->get('id_sous_projet');
        $agex_id= $this->get('agex_id');
        $village_id= $this->get('village_id');
        $id_village= $this->get('village_id');
        $id_annee= $this->get('id_annee');
        $etape_id= $this->get('etape_id');
        $annee_id= $this->get('id_annee');
		if($importation) {
			$ile = $this->IleManager->findById($id_ile);
			$nom_ile="";
			if($ile) {
				$nom_ile = $ile->Ile;
			}				
			$reg = $this->RegionManager->findByIdArray($id_region);
			$region="";
			if($reg) {
				foreach($reg as $k=>$v) {
					$region = $v->Region;
				}
			}				
			$comm = $this->CommuneManager->findById($id_commune);
			$commune="";
			if($comm) {					
				$commune = $comm->Commune;
			}				
			$vill = $this->VillageManager->findById($village_id);
			$village="";
			$villageois="";
			$zone_id=null;
			$code_zip="";
			if($vill) {
				$village = $vill->Village;
				$villageois = $vill->Village;
				$zone_id = $vill->zone_id;
				if(intval($zone_id) >0) {
					$zip = $this->ZipManager->findById($zone_id);
					if($zip) {							
						$code_zip=$zip->code;
					}	
				}	
			}
			if($etat_presence) {
				// IMPORT ETAT DE PRESENCE	
				$this->importer_etat_presence($chemin,$nomfichier,$observation,$nom_ile, $region, $commune, $village_id, $id_village, $village);
			} else if($etat_paiement) {
				// IMPORT ETAT DE PAIEMENT
				$fichepresence_id = $this->get('fichepresence_id'); 
				$info_fiche_presence =$this->FichepresenceManager->findById($fichepresence_id);
				$microprojet_id=null;
				$agex_id=null;
				$fichepaiement_id=null;
				$fiche_paiement_id=null;
				$etape_id=null;
				$datedu=null;
				$datefin=null;
				$nombrejourdetravail=0;
				$datepaiement=null;
				if($info_fiche_presence) {
					foreach($info_fiche_presence as $k=>$v) {
						$microprojet_id=$v->microprojet_id;
						$agex_id=$v->agex_id;						
						$fichepaiement_id=$v->fichepaiement_id;						
						$fiche_paiement_id=$v->fichepaiement_id;						
						$etape_id=$v->etape_id;						
						$datedu=$v->datedu;						
						$datefin=$v->datefin;						
						$nombrejourdetravail=$v->nombrejourdetravail;						
					} 
					$etp=$this->PhaseexecutionManager->findById($etape_id);
					$etape=$etp->Phase;
					$mic=$this->SousprojetManager->findById($microprojet_id);
					$microprojet=null;
					if($mic) {
						$microprojet=$mic->description;
					}	
					if($fichepaiement_id) {
						$info_paie=$this->FichepaiementManager->findById($fichepaiement_id);
						if($info_paie) {
							$datepaiement=$info_paie->datepaiement;
						}
					}
				}
				$this->importer_etat_paiement($chemin,$nomfichier,$observation,$nom_ile, $region, $commune, $village_id, $id_village, $village,$fichepresence_id,$microprojet,$microprojet_id,$agex_id,$fichepaiement_id,$nombrejourdetravail,$fiche_paiement_id,$etape,$etape_id,$datedu,$datefin,$datepaiement);
			}
		} else {
			if($etat_presence) {
				$data=$this->RequeteexportManager->Fiche_etat_de_presence($id_sous_projet,$village_id);
			} else if($liste_fiche_presence) {
				$data=$this->RequeteexportManager->Liste_fiche_presence();
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
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////:
	public function importer_etat_presence($chemin,$nomfichier,$observation,$nom_ile, $region, $commune, $village_id, $id_village, $village) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		// EXISTENCE BENEFICIAIRES
		/////////////////Correction////////////////
		$ile=$nom_ile;	
		$village_id=$id_village;
		$nom_village=$village;	
		/////////////////Correction////////////////			
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$ile_tmp = $ile;
		$region_tmp = $region;
		$commune_tmp=$commune;		
		$village_tmp=$village;	
		$ile_tmp=str_replace ($search,$replace,$ile_tmp );
		$region_tmp=str_replace ($search,$replace,$region_tmp );
		$commune_tmp=str_replace ($search,$replace,$commune_tmp );
		$village_tmp=str_replace ($search,$replace,$village_tmp );
		$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$chemin;
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$directoryName2 = dirname(__FILE__) . "/../../../../importexcel/".$chemin;
		if(!is_dir($directoryName2)) {
			mkdir($directoryName2, 0777,true);
		}
		if($nom_ile=="Moheli") {
			$nom_ile="MWL";
		} else if($nom_ile=="Anjouan"){
			$nom_ile="NDZ";
		} else {
			$nom_ile="NGZ";
		}	

		$id_fiche_presence= 0;
		$microprojet_id= 0;
		$a_ete_modifie= 0;
		$ile_encours= $ile;
		$id_fiche_presence_temp='id_temp';
		$id_a_remplacer = true;		
		$ile_encours=$ile_tmp;
		$region_encours=$region_tmp;		
		$commune_encours=$commune_tmp;
		$village_encours=$village_tmp;

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
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();
		$numeroligne=0;
		$erreur_date="";
		$erreur_nbjour="";
		$erreur_annee="";
		$erreur_activite="";
		$erreur_microprojet="";
		$erreur_etape="";
		$deja_importe="";
		$requete =" ";		
		$depart_ligne_lecture=5;
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			 // Lecture a partir de la ligne 5
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('G' == $cell->getColumn()) {
							$id_village =$cell->getValue();
					 }
					 if('H' == $cell->getColumn()) {
							$apte_inapte =$cell->getValue();
					 }
				}				 
			} else 	if($ligne ==2) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('D' == $cell->getColumn()) {
						$date_debut =$cell->getValue();
						if(isset($date_debut) && $date_debut>"") {
							if(PHPExcel_Shared_Date::isDateTime($cell)) {
								 $date_debut = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_debut)); 
							} else {
								$erreur_date=$erreur_date." Format date incorrect (date début)";
							}
						}	
					 }	else if('F' == $cell->getColumn()) {
						$date_fin =$cell->getValue();
						if(isset($date_fin) && $date_fin >"") {
							if(PHPExcel_Shared_Date::isDateTime($cell)) {
								 $date_fin = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_fin)); 
							} else {
								$erreur_date=$erreur_date." Format date incorrect (date fin)";
							}	
						}		
					 }	else if('G' == $cell->getColumn()) {
						$id_activite =$cell->getValue();
					 } 	else if('H' == $cell->getColumn()) {
						$etape_id =$cell->getValue();
					 } 
				}
				if($id_activite=="") {
					$erreur_activite="Activité invalide ! . Veuillez corriger le fichier EXCEL à importer s'il vous plait. Merci !";
				}
				if($etape_id=="") {
					$erreur_etape="Etape invalide ! . Veuillez corriger la cellule H2 du fichier EXCEL à importer s'il vous plait. Merci !";
				}
				$daty="";
				if($date_debut=="" || $date_fin=="") {					
					$erreur_date="Date invalide ! . Veuillez corriger le fichier EXCEL à importer s'il vous plait. Merci !";
				} else {
					$datedujour = date("Y-m-d");
					$datedujourmess = date("d/m/Y");
					$time = strtotime('01/01/2016');
					$dateminimum = date('Y-m-d',$time);					
					if($date_fin > $datedujour || $date_debut < $dateminimum) {
						if($date_fin > $datedujour && $date_debut >= $dateminimum) {
							$erreur_date="ERREUR ! : Date fin supérieure à la date du jour (Corriger le fichier EXCEL s'il vous plait !)";
						} else if($date_debut < $dateminimum && $date_fin <= $datedujour) {
							$erreur_date="ERREUR ! : La date début doit être supérieure à 01/01/2016 (Corriger le fichier EXCEL s'il vous plait !)";							
						} else {
							$erreur_date="ERREUR ! : Interval de date invalide; les dates doivent être comprise entre à 01/01/2016 et ".$datedujourmess." (Corriger le fichier EXCEL s'il vous plait !)";			
						}
					}	
					// $daty=$date_paiement;
					$daty=$date_debut;
				}
			} else 	if($ligne ==3) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				foreach ($cellIterator as $cell) {
					 if('D' == $cell->getColumn()) {
							$nombre_jour_travail =$cell->getValue();
					 }  else if('G' == $cell->getColumn()) {
							$id_agex =$cell->getValue();
					 } else  if('H' == $cell->getColumn()) {
						 // microprojet
						 $microprojet_id =$cell->getValue();
					 }	 
				}				 
				if($microprojet_id=="") {
					$erreur_microprojet="Micro-projet invalide ! . Veuillez corriger la cellule H3 du fichier EXCEL à importer s'il vous plait. Merci !";
				}
				if($nombre_jour_travail=="" || $nombre_jour_travail==0) {
					$erreur_nbjour="Nombre jour de travail invalide";
				}	
			} else if($ligne==4) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('G' == $cell->getColumn()) {
						 // indicateur si déjà importé => valeur positive
							$id_fiche =$cell->getValue();
					 }else  if('H' == $cell->getColumn()) {
						 // année
						 $annee_id =$cell->getValue();
					 }	 
				}
				if($annee_id=="") {
					$erreur_annee="Année invalide ! . Veuillez corriger la cellule H4 du fichier EXCEL à importer s'il vous plait. Merci !";
				}
				if($id_fiche=="" || $id_fiche==0) {
					if($id_fiche_presence >0) {
						// Ecraser les détails à partir du fichier non importé
						$sheet->setCellValue('E3', "DÉJÀ IMPORTÉ");	
						$sheet->getStyle('E3')->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );		
						$sheet->getStyle('E3')->applyFromArray(array(
							'font'  => array(
								'bold'  => true,
								'color' => array('rgb' => 'FFFFFF'),
								'size'  => 11,
								'name'  => 'Verdana'
							))
						);
						$sheet->setCellValue('G4', $id_fiche_presence);	
						$id_fiche_presence_temp=$id_fiche_presence;		

					}		
				} else if($id_fiche >0) {
					$deja_importe="fichier deja importe";	
				} 
				if(isset($microprojet_id) && intval($microprojet_id) >0) {
					$depart_ligne_lecture=7;	
				}
			} 
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				 foreach ($cellIterator as $cell) {
					 if('D' == $cell->getColumn()) {
							$travailleurpresent =$cell->getValue();
					 } else if('F' == $cell->getColumn()) {
							$suppliantpresent =$cell->getValue();	
					 } else if('G' == $cell->getColumn()) {
						$menage_id = $cell->getValue();
					 }
				}
				 if($menage_id >0) {
					$a_inserer=1;
				 }
				if($ligne==$depart_ligne_lecture) {
					$id_activite= 0;
					$id_village=$village_id;
					$fiche_presence_id=$id_fiche_presence;
					if($id_fiche_presence_temp=='id_temp' && intval($id_fiche_presence) >0) {
						$id_fiche_presence_temp=$id_fiche_presence;
						$id_a_remplacer = false;		
					} else {
						$id_fiche_presence=$id_fiche_presence_temp;
						$id_a_remplacer = true;								
					}					
				}
				if($a_inserer==1) {
					// stocker dans $requete les enregistrements à insérer; puis une seule instruction suffit pour les injecter dans see_fichepresencemenage
					$requete .="('".$travailleurpresent."','";
					$requete .= $suppliantpresent."','";					
					$requete .= $id_fiche_presence."','";					
					$requete .= $village_id."','";					
					$requete .= $nombre_jour_travail."','";					
					$requete .= $menage_id."'),";
				}	
				if($a_inserer==1) {
					$a_inserer=0;
				}							
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		$val_ret["erreur_date"] = $erreur_date;
		$val_ret["erreur_nbjour"] = $erreur_nbjour;
		$val_ret["erreur_annee"] = $erreur_annee;
		$val_ret["erreur_activite"] = $erreur_activite;
		if($erreur_activite >"" && $erreur_microprojet=="") {
			$val_ret["erreur_activite"] = "";
			$erreur_activite="";
		}	
		$val_ret["erreur_etape"] = $erreur_etape;
		$val_ret["erreur_microprojet"] = $erreur_microprojet;
		$val_ret["deja_importe"] = $deja_importe;
		$val_ret["daty"] = $daty;
		$val_ret["date_debut"] = $date_debut;
		$val_ret["date_fin"] = $date_fin;
		$val_ret["id_village"] = $id_village;
		$val_ret["nombre_jour_travail"] = $nombre_jour_travail;
		$val_ret["id_agex"] = $id_agex;
		$val_ret["id_activite"] = $id_activite;
		$val_ret["etape_id"] = $etape_id;
		$val_ret["annee_id"] = $annee_id;
		$val_ret["microprojet_id"] = $microprojet_id;
/*		if($ligne==$depart_ligne_lecture) {*/
			if($erreur_date=="" && $erreur_nbjour=="" && $deja_importe =="" && $erreur_activite=="" && $erreur_annee=="" && $erreur_etape=="" && $erreur_microprojet=="") {
				$test_non_insere = true; 
				if(intval($id_fiche_presence) > 0) {
					$test_non_insere = false; 
					$query = "delete from see_fichepresencemenage where fiche_presence_id=".$id_fiche_presence;
					$count_update = $this->RequeteimportManager->Execution_requete($query);
					if($erreur_date=="" && $erreur_nbjour=="") {
						if(isset($microprojet_id) && intval($microprojet_id) >0) {
							$query_update = "update see_fichepresence set " 
							. ( isset($id_activite) && intval($id_activite) >0 ? " microprojet_id='".$id_activite."'," : " etape_id='".$etape_id."',")
							."datedu='".$date_debut."',datefin='".$date_fin
							."',nombrejourdetravail='".$nombre_jour_travail."',Observation='".$observation.
							"',village_id='".$id_village."',agex_id='". $id_agex ."',inapte='".$apte_inapte."',a_ete_modifie='".$a_ete_modifie."',annee='".$annee_id."',microprojet_id='".$microprojet_id."' where id=".$id_fiche_presence;
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						} else {	
							$query_update = "update see_fichepresence set " 
							. ( isset($id_activite) && intval($id_activite) >0 ? " microprojet_id='".$id_activite."'," : " etape_id='".$etape_id."',")
							."datedu='".$date_debut."',datefin='".$date_fin
							."',nombrejourdetravail='".$nombre_jour_travail."',Observation='".$observation.
							"',village_id='".$id_village."',agex_id='". $id_agex ."',inapte='".$apte_inapte."',a_ete_modifie='".$a_ete_modifie."' where id=".$id_fiche_presence;
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						}	
					}	
				} else {
					if(isset($id_activite) && intval($id_activite) >0) {
						$test_non_insere = false; 
						$query = "insert into see_fichepresence (annee,microprojet_id,datedu,datefin,nombrejourdetravail,Observation,village_id,agex_id,inapte,a_ete_modifie) values ('1','".$id_activite."','".$date_debut."','".$date_fin."','".$nombre_jour_travail."','".$observation."','".$id_village."','".$id_agex."','".$apte_inapte."','".$a_ete_modifie. "')";
						$id_fiche_presence = $this->RequeteimportManager->Requete_insertion($query);
					} else if(isset($microprojet_id) && intval($microprojet_id) >0) {
						$test_non_insere = false; 
							$query = "insert into see_fichepresence (etape_id,datedu,datefin,nombrejourdetravail,Observation,village_id,agex_id,inapte,a_ete_modifie,annee,microprojet_id) values ('".$etape_id."','".$date_debut."','".$date_fin."','".$nombre_jour_travail."','".$observation."','".$id_village."','".$id_agex."','".$apte_inapte."','".$a_ete_modifie. "','".$annee_id."','".$microprojet_id."')";
							$id_fiche_presence = $this->RequeteimportManager->Requete_insertion($query);
						/*} else {		
							$query = "insert into see_fichepresence (etape_id,datedu,datefin,nombrejourdetravail,Observation,village_id,agex_id,inapte,a_ete_modifie) values ('".$etape_id."','".$date_debut."','".$date_fin."','".$nombre_jour_travail."','".$observation."','".$id_village."','".$id_agex."','".$apte_inapte."','".$a_ete_modifie. "')";
							$id_fiche_presence = $this->RequeteimportManager->Requete_insertion($query);
						}*/		
					}	
						// $id_fiche_presence = $conn->lastInsertId();		
				}
				if($test_non_insere == false) {
					$val_ret["id_fiche_presence"] = $id_fiche_presence;				
					$sheet->setCellValue('E3', "DÉJÀ IMPORTÉ");	
					$sheet->getStyle('E3')->getFill()->applyFromArray(
							 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
								 'startcolor' => array('rgb' => 'FF0000'),
								 'endcolor'   => array('argb' => 'FF0000')
							 )
					 );		
					$sheet->getStyle('E3')->applyFromArray(array(
						'font'  => array(
							'bold'  => true,
							'color' => array('rgb' => 'FFFFFF'),
							'size'  => 11,
							'name'  => 'Verdana'
						))
					);
					// MARQUAGE DEJA IMPORTE
					$sheet->setCellValue('G4', $id_fiche_presence);	
				}		
			}			
/*		}*/
		if($erreur_date=="" && $erreur_nbjour=="" && $deja_importe =="" && $erreur_activite=="" && $erreur_annee=="" && $erreur_etape=="" && $erreur_microprojet=="") {
			// enlever le dernier virgule "," qui provoque une erreur lors de l'execution de la requete
			if($id_a_remplacer == true) {
				$replace=array($id_fiche_presence);
				$search= array('id_temp');
				$requete=str_replace($search,$replace,$requete);				
			}
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into see_fichepresencemenage(travailleurpresent,suppliantpresent,fiche_presence_id,village_id,NbreDeJoursDeTravail,menage_id) values " . $requete;		
			$count_update = $this->RequeteimportManager->Execution_requete($requete);
			// sauvegarder fichier Excel original après avoir écrit 'DEJA IMPORTÉ' et le id N° Fiche présence correspondant
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../". $chemin.$nomfichier);
			$val_ret["reponse"] = "OK";	
			// RECUPERATION VALEUR INSERE en-tete, détails	
			$fiche_presence=$this->FichepresenceManager->findById($id_fiche_presence);
			$fiche_presencemenage=$this->FichepresencemenageManager->findByFiche_presence_id($id_fiche_presence);
		} else {
			$val_ret["reponse"] = "ERREUR";
			$fiche_presence=array();	
			$fiche_presencemenage=array();	
		}	
			if($val_ret['reponse']=="OK") {
				$status=TRUE;
			} else {
				$status=FALSE;
			}
				$this->response([
					'status' => $status,
					'retour'               => $val_ret,
					'fiche_presence'       => $fiche_presence,
					'fiche_presencemenage' => $fiche_presencemenage,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);
			  
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////:
	public function importer_etat_paiement($chemin,$nomfichier,$observation,$nom_ile, $region, $commune, $village_id, $id_village, $village,$fichepresence_id,$microprojet,$microprojet_id,$agex_id,$fichepaiement_id,$nombrejourdetravail,$fiche_paiement_id,$etape,$etape_id,$datedu,$datefin,$datepaiement) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		/////////////////Correction////////////////
		$ile=$nom_ile;	
		$village_id=$id_village;
		$nom_village=$village;	
		///////////////////////////
		$id_fiche_paiement= $fiche_paiement_id;
		$a_ete_modifie= 0;
		$ile_encours= $ile;
		$region_encours= $region;
		$commune_encours= $commune;
		$village_encours= $village;		
		$time = strtotime('01/01/2020');
		$dateminimum_paiement = date('Y-m-d',$time);
		$datefinmessage = $dateminimum_paiement;		
		$requete_datefin = "select datefin,ifnull(date_format(datefin,'%d/%m/%Y'),'') as datefinmessage from see_fichepresence where id=".$fichepresence_id;
		$retour=$this->RequeteimportManager->Requete_datefin_date_paiement($requete_datefin);
		if ($retour) {
			foreach($retour as $k=>$v) {
				$dateminimum_paiement= $v->datefin;
				$datefinmessage =$v->datefinmessage;
			}	
		}						
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$ile_tmp = $ile;
		$region_tmp = $region;
		$commune_tmp=$commune;		
		$village_tmp=$village;	
		$ile_tmp=str_replace ($search,$replace,$ile_tmp );
		$region_tmp=str_replace ($search,$replace,$region_tmp );
		$commune_tmp=str_replace ($search,$replace,$commune_tmp );
		$village_tmp=str_replace ($search,$replace,$village_tmp );
		
		$ile_encours=str_replace ($search,$replace,$ile_encours );
		$region_encours=str_replace ($search,$replace,$region_encours );
		$commune_encours=str_replace ($search,$replace,$commune_encours );
		$village_encours=str_replace ($search,$replace,$village_encours );		
		$lien_vers_mon_document_excel = dirname(__FILE__) . "/../../../../".$chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_paiement <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();
		$numeroligne=0;
		$tot_montanttotalapayer=0;
		$tot_montanttotalpaye=0;
		$tot_montantapayertravailleur=0;
		$tot_montantpayetravailleur=0;
		$tot_montantapayersuppliant=0;
		$tot_montantpayesuppliant=0;	
		$requete =" ";	
		$erreur_date="";		
		$erreur_nbjour="";		
		$deja_importe="";
		$erreur_fichier="";	
		$erreur_montant="";	
		$erreur_nombrejour="";	
		$erreur_etape="";	
		$erreur_annee="";	
		$erreur_microprojet="";	
		$nombreerreurmontant=0;
		$nombreerreurjour=0;
		$depart_ligne_lecture =6;
		foreach($rowIterator as $row) {
			 $ligne = $row->getRowIndex ();
			if($ligne ==1) {
				 $cellIterator = $row->getCellIterator();
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('N' == $cell->getColumn()) {
							$apte_inapte =$cell->getValue();
					 }
					 if('O' == $cell->getColumn()) {
							$fichepresence_id_ficExcel =$cell->getValue();
					 }
				}				 
				if($fichepresence_id_ficExcel<>$fichepresence_id) {
					$erreur_fichier="Fichier incompatible avec l'état de présence selectionné";
				}	
			} else 	if($ligne ==2) {
				 $cellIterator = $row->getCellIterator();
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('E' == $cell->getColumn()) {
						$date_paiement =$cell->getValue();
						if(isset($date_paiement) && $date_paiement>"") {
							if(PHPExcel_Shared_Date::isDateTime($cell)) {
								 $date_paiement = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_paiement)); 
							}
						}	
					 }	else if('I' == $cell->getColumn()) {
						$nombre_jour_travail =$cell->getValue();
					 } else if('N' == $cell->getColumn()) {
						$id_activite =$cell->getValue();
					 } 	else if('O' == $cell->getColumn()) {
						$agep_id =$cell->getValue();
					 } 					 
				}	
				if($nombre_jour_travail=="" || $nombre_jour_travail==0) {
					$erreur_nbjour="Nombre jour de travail invalide";
				}	
				$daty="";
				$datedujour = date("Y-m-d");
				$time = strtotime('01/01/2016');
				$dateminimum = date('Y-m-d',$time);					
				if($date_paiement=="") {					
					$erreur_date="Date de paiement invalide ! . Veuillez corriger le fichier EXCEL à importer s'il vous plait. Merci !";
				} else {
					if($date_paiement > $datedujour || $date_paiement < $dateminimum_paiement) {
						if($date_paiement > $datedujour) {
							$erreur_date="ERREUR ! : Date Paiement supérieure à la date du jour (Corriger le fichier EXCEL s'il vous plait !)";
						} else if($date_paiement < $dateminimum_paiement) {
							$erreur_date="ERREUR ! : La date de Paiement doit être supérieure à ".$datefinmessage." qui correspond à la date fin du fiche de présence (Corriger le fichier EXCEL s'il vous plait !)";							
						}
					}	
					$daty=$date_paiement;
				}
			} else 	if($ligne ==3) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('N' == $cell->getColumn()) {
							$id_village =$cell->getValue();
					 } else if('O' == $cell->getColumn()) {
						$id_etape =$cell->getValue();
					 } 
				}				 
			/*	$indemnite=0;
				if(isset($etape_id) && intval($etape_id) >0) {
					$requete_indemnite = "select indemnite from see_phaseexecution where id=".$id_etape;
					$yy = $conn->query($requete_indemnite);
					while ($row = $yy->fetch())
					{
						$indemnite= $row['indemnite'];
					}						
				} else {
					$requete_indemnite = "select indemnite from see_activite where id=".$id_activite;
					$yy = $conn->query($requete_indemnite);
					while ($row = $yy->fetch())
					{
						$indemnite= $row['indemnite'];
					}	
				} */
				if($id_etape=="") {
					$erreur_etape="Etape invalide ! . Veuillez corriger la cellule O3 du fichier EXCEL à importer s'il vous plait. Merci !";					
				}
			} 
			if($ligne==4) {
				$deja_importe="";
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					 if('N' == $cell->getColumn()) {
						 // indicateur si déjà importé => valeur positive
							$id_fiche =$cell->getValue();
					 }else if('O' == $cell->getColumn()) {
						$microprojet_id =$cell->getValue();
					 } 
				}
				if($id_fiche=="" || $id_fiche==0) {
					if($id_fiche_paiement >0) {
						$sheet->setCellValue('J2', "DÉJÀ IMPORTÉ");	
						$sheet->getStyle('J2')->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'FF0000'),
									 'endcolor'   => array('argb' => 'FF0000')
								 )
						 );		
						$sheet->getStyle('J2')->applyFromArray(array(
							'font'  => array(
								'bold'  => true,
								'color' => array('rgb' => 'FFFFFF'),
								'size'  => 11,
								'name'  => 'Verdana'
							))
						);
						$sheet->setCellValue('N4', $id_fiche_paiement);	
					}		
				} else if($id_fiche >0) {
					$deja_importe="fichier deja importe";	
				}	
				if($microprojet_id=="") {
					$erreur_microprojet="Sous-projet invalide ! . Veuillez corriger la cellule O4 du fichier EXCEL à importer. Merci !";
				}
			} 		 
			if($ligne==5) {
					 $cellIterator = $row->getCellIterator();
					 // Loop all cells, even if it is not set
					 $cellIterator->setIterateOnlyExistingCells(false);
					 $rowIndex = $row->getRowIndex ();
					 foreach ($cellIterator as $cell) {
						if('O' == $cell->getColumn()) {
							$annee_id =$cell->getValue();
						} 
					}
					if($annee_id=="" || !isset($annee_id)) {
						$erreur_annee="Année invalide ! . Veuillez corriger la cellule O5 du fichier EXCEL à importer s'il vous plait. Merci !";
					}							
				if(isset($microprojet_id) && intval($microprojet_id) >0) {
					$depart_ligne_lecture =8;
				} else if(intval($id_etape) >0 && (!isset($microprojet_id) || intval($microprojet_id) ==0)) {
					// $annee_id=1;
					// lécture microprojet_id dans la table see_fichepresence // Mail du 25/09/2017 ERREUR IMPORT
					$requete_micro = "select microprojet_id from see_fichepresence where id=".$fichepresence_id;
					$yy = $conn->query($requete_micro);
					while ($row = $yy->fetch())
					{
						$microprojet_id= $row['microprojet_id'];
					}						
					if($microprojet_id=="" || !isset($microprojet_id)) {
						$erreur_microprojet="Sous-projet invalide ! . Veuillez corriger la cellule O4 du fichier EXCEL à importer. Merci !";
					}
				}
			}	
			if($ligne==6) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 foreach ($cellIterator as $cell) {
					if('O' == $cell->getColumn()) {
						$indemnite =$cell->getValue();
					} 
				}
			}	
			// Lecture a partir de la ligne 6 ou 8
			if($ligne >=$depart_ligne_lecture) {
				 $cellIterator = $row->getCellIterator();
				 // Loop all cells, even if it is not set
				 $cellIterator->setIterateOnlyExistingCells(false);
				 $rowIndex = $row->getRowIndex ();
				 $a_inserer =0;
				foreach ($cellIterator as $cell) {
					 if('G' == $cell->getColumn()) {
							$travailleurpresent =$cell->getValue();
					 } else if('K' == $cell->getColumn()) {
							$suppliantpresent =$cell->getValue();	
					 } else if('N' == $cell->getColumn()) {
						$menage_id = $cell->getValue();
					 } else if('C' == $cell->getColumn()) {
						$montanttotalapayer = $cell->getValue();
					 } else if('D' == $cell->getColumn()) {
						$montanttotalpaye = $cell->getValue();
					 } else if('H' == $cell->getColumn()) {
						$montantapayertravailleur = $cell->getValue();
					 } else if('I' == $cell->getColumn()) {
						$montantpayetravailleur = $cell->getValue();
					 } else if('L' == $cell->getColumn()) {
						$montantapayersuppliant	 = $cell->getValue();
					 } else if('M' == $cell->getColumn()) {
						$montantpayesuppliant = $cell->getValue();
					 }
				}
				// Controle somme jour trav ppal et trav suppléant
				if((intval($travailleurpresent) + intval($suppliantpresent)) > intval($nombre_jour_travail)) {
					if($nombreerreurjour==0) {
						$erreur_nombrejour = "ERREUR SUR TOTAL NOMBRE DE JOURS à la ligne : ".$ligne;	
					} else {
						$erreur_nombrejour = $erreur_nombrejour.', '.$ligne;							
					}	
					$nombreerreurjour = $nombreerreurjour + 1;	
				}
				// Contrôle montant payé si trop perçu
				$mont_trav = intval($travailleurpresent) * intval($indemnite);
				$mont_suppl = intval($suppliantpresent) * intval($indemnite);
				if(intval($montantpayetravailleur) > $mont_trav) {
					if($nombreerreurmontant==0) {
						$erreur_montant = "ERREUR SUR VALEUR MONTANT PAYE : Trop percu à la ligne ".$ligne;	
					} else {
						$erreur_montant = $erreur_montant.', '.$ligne;							
					}
					$nombreerreurmontant=$nombreerreurmontant + 1;
				}
				if(intval($montantpayesuppliant) > $mont_suppl) {
					if($nombreerreurmontant==0) {
						$erreur_montant = "ERREUR SUR VALEUR MONTANT PAYE : Trop percu à la ligne ".$ligne;	
					} else {
						$erreur_montant = $erreur_montant.', '.$ligne;							
					}
					$nombreerreurmontant=$nombreerreurmontant + 1;
				}
				if($menage_id >0)  {
					$a_inserer=1;
				}
				if($a_inserer==1) {
					// stocker dans $requete les enregistrements à insérer; puis une seule instruction suffit pour les injecter dans see_fichepresencemenage
					$montanttotalpaye = $montantpayetravailleur + $montantpayesuppliant;
					$requete .="('".$travailleurpresent."','";
					$requete .= $suppliantpresent."','";					
					$requete .= $id_fiche_paiement."','";					
					$requete .= $village_id."','";					
					$requete .= $nombrejourdetravail."','";					
					$requete .= $montanttotalapayer."','";		
					$requete .= $montanttotalpaye."','";					
					$requete .= $montantapayertravailleur."','";					
					$requete .= $montantpayetravailleur."','";					
					$requete .= $montantapayersuppliant."','";					
					$requete .= $montantpayesuppliant."','";					
					$requete .= $microprojet_id."','";					
					$requete .= $menage_id."'),";
					$tot_montanttotalapayer=$tot_montanttotalapayer + $montanttotalapayer;
					$tot_montanttotalpaye=$tot_montanttotalpaye + $montanttotalpaye;
					$tot_montantapayertravailleur=$tot_montantapayertravailleur + $montantapayertravailleur;
					$tot_montantpayetravailleur=$tot_montantpayetravailleur + $montantpayetravailleur;
					$tot_montantapayersuppliant=$tot_montantapayersuppliant + $montantapayersuppliant;
					$tot_montantpayesuppliant=$tot_montantpayesuppliant + $montantpayesuppliant;
				}	
				if($a_inserer==1) {
					$a_inserer=0;
				}							
				$numeroligne = $numeroligne + 1;
			}		
		}	
		$val_ret = array();
		// $val_ret["id_fiche_paiement"] = $id_fiche_paiement;
		$val_ret["erreur_date"] = $erreur_date;
		$val_ret["erreur_nbjour"] = $erreur_nbjour;
		$val_ret["erreur_nombrejour"] = $erreur_nombrejour;
		$val_ret["erreur_fichier"] = $erreur_fichier;
		$val_ret["erreur_montant"] = $erreur_montant;
		$val_ret["erreur_annee"] = $erreur_annee;
		$val_ret["erreur_etape"] = $erreur_etape;
		$val_ret["erreur_microprojet"] = $erreur_microprojet;
		$val_ret["deja_importe"] = $deja_importe;
		$val_ret["date_paiement"] = $date_paiement;
		$val_ret["id_village"] = $id_village;
		$val_ret["nombre_jour_travail"] = $nombre_jour_travail;
		$val_ret["id_activite"] = $id_activite;
		$val_ret["inapte"] = $apte_inapte;
		$val_ret["datedujour"] = $datedujour;
		$val_ret["dateminimum"] = $dateminimum;
		// Sans erreur ==> Insert or Update
	/*	if($ligne==$depart_ligne_lecture) {*/
			if($erreur_date=="" && $erreur_nbjour=="" && $erreur_fichier=="" && $deja_importe=="" && $erreur_montant=="" && $erreur_nombrejour=="" && $erreur_annee=="" && $erreur_etape=="" && $erreur_microprojet=="") {
				if($id_fiche_paiement>0) {
					$query = "delete from see_fichepaiementmenage where fiche_paiement_id=".$id_fiche_paiement;
					$count_update = $this->RequeteimportManager->Execution_requete($query);
					// RAZ id_fiche_paiement dans see_fichepresence <==> il se peut que le fichier change fichepresence_id
					$query_presence= "update see_fichepresence set fichepaiement_id=null where fichepaiement_id='".$id_fiche_paiement."'";
					$count_update = $this->RequeteimportManager->Execution_requete($query_presence);
					
					if(isset($etape_id) && intval($etape_id) >0) {
						if(isset($agep_id) && intval($agep_id) >0) {
							$query_update="update see_fichepaiement set etape_id='".$etape_id."',datepaiement='".$date_paiement."',nombrejourdetravail='"
							.$nombre_jour_travail."',Observation='".$observation."',microprojet_id='".$microprojet_id."',id_annee='".$annee_id."',agep_id='".$agep_id
							."',village_id='".$id_village."',indemnite='".$indemnite."',inapte='".$apte_inapte."',fichepresence_id='".$fichepresence_id."',a_ete_modifie='".$a_ete_modifie."' where id='".$id_fiche_paiement."'";
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						} else {
							$query_update="update see_fichepaiement set etape_id='".$etape_id."',datepaiement='".$date_paiement."',nombrejourdetravail='"
							.$nombre_jour_travail."',Observation='".$observation."',microprojet_id='".$microprojet_id."',id_annee='".$annee_id
							."',village_id='".$id_village."',indemnite='".$indemnite."',inapte='".$apte_inapte."',fichepresence_id='".$fichepresence_id."',a_ete_modifie='".$a_ete_modifie."' where id='".$id_fiche_paiement."'";
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						}	
					} else {
						if(isset($agep_id) && intval($agep_id) >0) {
							$query_update="update see_fichepaiement set microprojet_id='".$microprojet_id."',datepaiement='".$date_paiement."',nombrejourdetravail='"."',agep_id='".$agep_id
							.$nombre_jour_travail."',Observation='".$observation
							."',village_id='".$id_village."',indemnite='".$indemnite."',inapte='".$apte_inapte."',fichepresence_id='".$fichepresence_id."',a_ete_modifie='".$a_ete_modifie."' where id='".$id_fiche_paiement."'";
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						} else {
							$query_update="update see_fichepaiement set microprojet_id='".$microprojet_id."',datepaiement='".$date_paiement."',nombrejourdetravail='"
							.$nombre_jour_travail."',Observation='".$observation
							."',village_id='".$id_village."',indemnite='".$indemnite."',inapte='".$apte_inapte."',fichepresence_id='".$fichepresence_id."',a_ete_modifie='".$a_ete_modifie."' where id='".$id_fiche_paiement."'";
							$count_update = $this->RequeteimportManager->Execution_requete($query_update);
						}	
					}	
				} else {
					if(isset($etape_id) && intval($etape_id) >0) {
						if(isset($agep_id) && intval($agep_id) >0) {
							$query = "insert into see_fichepaiement (etape_id,datepaiement,nombrejourdetravail,observation,village_id,indemnite,inapte,fichepresence_id,a_ete_modifie,microprojet_id,id_annee,agep_id) values ('"
							.$etape_id."','".$date_paiement."','".$nombre_jour_travail."','".$observation."','".$id_village."','"
							.$indemnite."','".$apte_inapte."','".$fichepresence_id."','".$a_ete_modifie."','".$microprojet_id."','".$annee_id."','".$agep_id."')";
							$id_fiche_paiement = $this->RequeteimportManager->Requete_insertion($query);
						} else {
							$query = "insert into see_fichepaiement (etape_id,datepaiement,nombrejourdetravail,observation,village_id,indemnite,inapte,fichepresence_id,a_ete_modifie,microprojet_id,id_annee) values ('"
							.$etape_id."','".$date_paiement."','".$nombre_jour_travail."','".$observation."','".$id_village."','"
							.$indemnite."','".$apte_inapte."','".$fichepresence_id."','".$a_ete_modifie."','".$microprojet_id."','".$annee_id."')";
							$id_fiche_paiement = $this->RequeteimportManager->Requete_insertion($query);
						}		
					} else {
						if(isset($agep_id) && intval($agep_id) >0) {
							$query = "insert into see_fichepaiement (microprojet_id,datepaiement,nombrejourdetravail,observation,village_id,indemnite,inapte,fichepresence_id,agep_id) values ('".$id_activite."','".$date_paiement."','".$nombre_jour_travail."','".$observation."','".$id_village."','".$indemnite."','".$apte_inapte."','".$fichepresence_id."','".$agep_id."')";
							$id_fiche_paiement = $this->RequeteimportManager->Requete_insertion($query);
						} else {
							$query = "insert into see_fichepaiement (microprojet_id,datepaiement,nombrejourdetravail,observation,village_id,indemnite,inapte,fichepresence_id) values ('".$id_activite."','".$date_paiement."','".$nombre_jour_travail."','".$observation."','".$id_village."','".$indemnite."','".$apte_inapte."','".$fichepresence_id."')";
							$id_fiche_paiement = $this->RequeteimportManager->Requete_insertion($query);
						}	
					}		
				}	
				// Mise à jour fiche de présence
				$query_presence= "update see_fichepresence set fichepaiement_id='".$id_fiche_paiement."' where id='".$fichepresence_id."'";
				$count_update = $this->RequeteimportManager->Execution_requete($query_presence);
				$id_activite= $microprojet_id;
				$id_village=$village_id;
				$fiche_paiement_id=$id_fiche_paiement;	
				$sheet->setCellValue('J2', "DÉJÀ IMPORTÉ");	
				$sheet->getStyle('J2')->getFill()->applyFromArray(
						 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
							 'startcolor' => array('rgb' => 'FF0000'),
							 'endcolor'   => array('argb' => 'FF0000')
						 )
				 );	
				$sheet->getStyle('J2')->applyFromArray(array(
					'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => 'FFFFFF'),
						'size'  => 11,
						'name'  => 'Verdana'
					))
				);
				$val_ret["id_fiche_paiement"] = $id_fiche_paiement;
				$sheet->setCellValue('N4', $id_fiche_paiement);	
			}	
	/*	}*/		
		if($erreur_date>"" || $erreur_nbjour>"" || $deja_importe >"" || $erreur_fichier >"" || $erreur_montant >"" || $erreur_nombrejour >"" || $erreur_annee >"" || $erreur_etape >"" || $erreur_microprojet >"") {
			$fiche_paiement=array();
			$fiche_paiementmenage=array();
			$val_ret["reponse"] = "ERREUR";
				$this->response([
					'status' => FALSE,
					'retour'               => $val_ret,
					'fiche_presence'       => $fiche_paiement,
					'fiche_presencemenage' => $fiche_paiementmenage,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);
		} else {
			// enlever le dernier "," qui provoque une erreur lors de l'execution de la requete
			$ou = strrpos($requete,",");
			$requete = substr($requete,0,$ou);
			$requete = "insert into see_fichepaiementmenage(travailleurpresent,suppliantpresent,fiche_paiement_id,village_id,nombrejourdetravail,"
			."montanttotalapayer,montanttotalpaye,montantapayertravailleur,montantpayetravailleur,montantapayersuppliant,montantpayesuppliant,microprojet_id,menage_id) values " . $requete;		
			$count_update = $this->RequeteimportManager->Execution_requete($requete);
			$requete_paie = "update see_fichepaiement set montanttotalapayer=".$tot_montanttotalapayer.",montanttotalpaye=".$tot_montanttotalpaye
							.",montantapayertravailleur=".$tot_montantapayertravailleur.",montantpayetravailleur=".$tot_montantpayetravailleur
							.",montantapayersuppliant=".$tot_montantapayersuppliant.",montantpayesuppliant=".$tot_montantpayesuppliant
							." where id=".$id_fiche_paiement;
			$count_update = $this->RequeteimportManager->Execution_requete($requete_paie);
			$requete_paiemenage = "update see_fichepaiementmenage set fiche_paiement_id='".$id_fiche_paiement."' where fiche_paiement_id=0";  
			$count_update = $this->RequeteimportManager->Execution_requete($requete_paiemenage);
			// SAUVEGARDE FICHIER EXCEL IMPORTE
			$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../../". $chemin.$nomfichier);
			// SAUVEGARDE FICHIER EXCEL IMPORTE
			$fiche_paiement=$this->FichepaiementManager->findById($id_fiche_paiement);
			$fiche_paiementmenage=$this->FichepaiementmenageManager->findByFiche_paiement_id($id_fiche_paiement);
			$val_ret["reponse"] = "OK";	
				$this->response([
					'status' => TRUE,
					'retour'               => $val_ret,
					'fiche_paiement'       => $fiche_paiement,
					'fiche_paiementmenage' => $fiche_paiementmenage,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);
		}	
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////:
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */