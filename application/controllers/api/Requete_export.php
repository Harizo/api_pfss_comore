<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Requete_export extends REST_Controller {

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
        $this->load->model('fiche_presence_model', 'FichEpresenceManager');
        $this->load->model('agence_p_model', 'AgencepaiementManager');
        $this->load->model('menage_model', 'MenageManager');
        $this->load->model('individu_model', 'IndividuManager');
        $this->load->model('requete_export_model', 'RequeteexportManager');
    }

    public function index_get() 
    {
		// Les différentx choix
		$export = $this->get('export'); 
        $fiche_presence= $this->get('fiche_presence');
        $fiche_paiement= $this->get('fiche_paiement');
        $fiche_recepteur= $this->get('fiche_recepteur');
        $fiche_paiement_arse= $this->get('fiche_paiement_arse');
        $liste_etat_presence= $this->get('liste_etat_presence');
        $liste_etat_paiement= $this->get('liste_etat_paiement');
        $detail_etat_presence= $this->get('detail_etat_presence');
        $carte_beneficiaire= $this->get('carte_beneficiaire');
		// Les différentx choix
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
        $id_fichepresence= $this->get('id_fichepresence');
        $fichepresence_id= $this->get('id_fichepresence');        				
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
				$id_zip="";
				$vague="";
				if($vill) {
					$village = $vill->Village;
					$villageois = $vill->Village;
					$zone_id = $vill->id_zip;
					$id_zip = $vill->id_zip;
					$vague = $vill->vague;
					if(intval($zone_id) >0) {
						$zip = $this->ZipManager->findById($zone_id);
						if($zip) {							
							$code_zip=$zip->code;
						}	
					}	
				}									
		// DEBUT PREPARATION DIFFERENT PARAMETRE EN JEU
		// FIN PREPARATION DIFFERENT PARAMETRE EN JEU
		if($export) {
			if($fiche_presence) {
				$agex = $this->AgexManager->findById($agex_id);
				$nom_agex = $agex->Nom;
				$phase = $this->PhaseexecutionManager->findById($etape_id);
				$etape = $phase->Phase;
				$an = $this->AnneeManager->findById($annee_id);
				$annee = $an->annee;
				$micro = $this->SousprojetManager->findById($id_sous_projet);
				$microprojet = $micro->description;
				$menages=$this->RequeteexportManager->Fiche_etat_de_presence($id_sous_projet,$village_id);
				$this->exportlisteficheetatpresence($menages, $nom_ile, $region, $commune, $village_id, $id_village, $village, $agex_id, $nom_agex, $etape_id,$etape,$annee_id,$annee,$code_zip,$microprojet_id,$microprojet);
			} else if($detail_etat_presence) {
				$indemnite= $this->get('indemnite');
				$agep_id= $this->get('agep_id');
				$info_fiche_presence=$this->FichEpresenceManager->findById($id_fichepresence);
					$agex_id =null;
					$etape_id =null;
					$id_annee =null;
					$inapte =0;					
					$nombrejourdetravail=0;
					$datedu="";
					$datefin="";								
					$id_sous_projet =null;
				if(count($info_fiche_presence) >0) {
					foreach($info_fiche_presence as $k=>$v) {
						$agex_id =$v->agex_id;
						$etape_id =$v->etape_id;
						$id_annee =$v->annee;
						$inapte =$v->inapte;
						
						$nombrejourdetravail=$v->nombrejourdetravail;
						$datedu=$v->datedu;
						$datefin=$v->datefin;								
						$id_sous_projet =$v->microprojet_id;
						$microprojet_id =$v->microprojet_id;
					}	
				}
				$ag = $this->AgencepaiementManager->findByIdArray($agep_id);
				$nom_agep="";
				if(count($ag) >0) {
					foreach($ag as $k=>$v) {
						$nom_agep=$v->raison_social;
					}
				}
				$agex = $this->AgexManager->findById($agex_id);
				$nom_agex = $agex->Nom;
				$phase = $this->PhaseexecutionManager->findById($etape_id);
				$etape = $phase->Phase;
				$an = $this->AnneeManager->findById($id_annee);
				$annee_id = $id_annee;
				$annee = $an->annee;
				$micro = $this->SousprojetManager->findById($id_sous_projet);
				$microprojet = $micro->description;
				$detail=$this->RequeteexportManager->Detail_fiche_etat_de_paiement($id_fichepresence);
				$this->exportlisteficheetatdepaiement($detail, $nom_ile, $region, $commune, $village_id, $id_village, $village, $agex_id, $nom_agex, $etape_id,$etape,$annee_id,$annee,$code_zip,$microprojet_id,$microprojet,$id_fichepresence,$fichepresence_id,$indemnite,$agep_id,$nom_agep,$nombrejourdetravail,$inapte,$datedu,$datefin);
			} else if($carte_beneficiaire) {				
				$ile_id=$id_ile;
				$region_id=$id_region;
				$commune_id=$id_commune;
				$village_id=$id_village;
				$apiUrlbase= $this->get('apiUrlbase');
				$micro = $this->SousprojetManager->findById($id_sous_projet);
				$z=$this->VillageManager->findById($village_id);
				$microprojet = $micro->description;
				$menages=$this->MenageManager->findAllByVillageAndStatutAndSousProjet($village_id,"BENEFICIAIRE",$id_sous_projet);
				// Solution Provisoire : id_sous_projet ARSE =2 les autres carte bénéficiaire par défaut
				if(intval($id_sous_projet)==2) {
					$this->exportcartebeneficiaireARSE($apiUrlbase,$menages,$nom_ile,$region,$commune,$village,$zone_id,$zip,$code_zip,$microprojet,$ile_id,$region_id,$commune_id,$village_id,$id_zip);
				} else {
					$this->exportcartebeneficiaire($apiUrlbase,$menages,$nom_ile,$region,$commune,$village,$zone_id,$zip,$code_zip,$microprojet,$ile_id,$region_id,$commune_id,$village_id);
				}	
			} else if($fiche_recepteur || $fiche_paiement_arse) {
					$nombre_menage_beneficiaire=0;
					$nombre_travailleur_homme=0;
					$nombre_travailleur_femme=0;
					$nombre_suppleant_homme=0;
					$nombre_suppleant_femme=0;					
					$titre= $this->get('titre');
					$numero_tranche= $this->get('numero_tranche');
					$montant_a_payer= $this->get('montant_a_payer');
					$pourcentage= $this->get('pourcentage');
					$agep_id= $this->get('agep_id');
					$ag = $this->AgencepaiementManager->findByIdArray($agep_id);
					$nom_agep="";
					if(count($ag) >0) {
						foreach($ag as $k=>$v) {
							$nom_agep=$v->raison_social;
						}
					}					
				$menages=$this->RequeteexportManager->Etat_recepteur($id_sous_projet,$village_id);
				$ret = $this->RequeteexportManager->Nombre_travailleur_par_sexe($id_sous_projet,$village_id);
				if($ret) {
					foreach($ret as $k=>$v) {
						$nombre_menage_beneficiaire=$v->nombre_menage_beneficiaire;
						$nombre_travailleur_homme=$v->nombre_travailleur_homme;
						$nombre_travailleur_femme=$v->nombre_travailleur_femme;
						$nombre_suppleant_homme=$v->nombre_suppleant_homme;
						$nombre_suppleant_femme=$v->nombre_suppleant_femme;	
					}		
				}
				if($fiche_recepteur) {
					$this->exportficherecepteur($menages,$nom_ile,$region,$commune,$village,$nombre_menage_beneficiaire,$nombre_travailleur_homme,$nombre_travailleur_femme,$nombre_suppleant_homme,$nombre_suppleant_femme,$pourcentage,$montant_a_payer,$titre,$village_id,$numero_tranche,$nom_agep,$id_zip,$vague,$agep_id);
				} else {
				   $this->exportetatpaiementarse($menages,$nom_ile,$region,$commune,$village,$nombre_menage_beneficiaire,$nombre_travailleur_homme,$nombre_travailleur_femme,$nombre_suppleant_homme,$nombre_suppleant_femme,$pourcentage,$montant_a_payer,$titre,$village_id,$numero_tranche,$nom_agep,$id_zip,$vague,$agep_id);
				}	
			}
		} else {
			if($fiche_presence) {
				$data=$this->RequeteexportManager->Fiche_etat_de_presence($id_sous_projet,$village_id);
			} else if($liste_etat_presence) {
				$requeteplus="";
				if($id_sous_projet && intval($id_sous_projet) >0) {
					$requeteplus=$requeteplus." and fp.microprojet_id=".$id_sous_projet;
				}
				if($agex_id && intval($agex_id) >0) {
					$requeteplus=$requeteplus." and fp.agex_id=".$agex_id;
				}
				if($id_annee && intval($id_annee) >0) {
					$requeteplus=$requeteplus." and fp.annee=".$id_annee;
				}
				if($etape_id && intval($etape_id) >0) {
					$requeteplus=$requeteplus." and fp.etape_id=".$etape_id;
				}
				$data=$this->RequeteexportManager->Liste_etat_presence($village_id,$requeteplus);
			} else if($liste_etat_paiement) {
				$requeteplus="";
				if($id_sous_projet && intval($id_sous_projet) >0) {
					$requeteplus=$requeteplus." and fp.microprojet_id=".$id_sous_projet;
				}
				$agep_id= $this->get('agep_id');
				if($agep_id && intval($agep_id) >0) {
					$requeteplus=$requeteplus." and fp.agep_id=".$agep_id;
				}
				if($id_annee && intval($id_annee) >0) {
					$requeteplus=$requeteplus." and fp.id_annee=".$id_annee;
				}
				if($etape_id && intval($etape_id) >0) {
					$requeteplus=$requeteplus." and fp.etape_id=".$etape_id;
				}
				$data=$this->RequeteexportManager->Liste_etat_paiement($village_id,$requeteplus);
			} else if($fiche_paiement) {
				$data=$this->RequeteexportManager->Fiche_etat_de_paiement($village_id);
			} else if($detail_etat_presence) {
				$data=$this->RequeteexportManager->Detail_fiche_etat_de_paiement($id_fichepresence);
			} else if($fiche_paiement_arse || $fiche_recepteur) {
				$data=$this->RequeteexportManager->Etat_recepteur($id_sous_projet,$village_id);
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
// EXPORT FICHE ETET DE PRESENCE
	public function exportlisteficheetatpresence($menages, $nom_ile, $region, $commune, $village_id, $id_village, $village, $agex_id, $nom_agex, $etape_id,$etape,$annee_id,$annee,$code_zip,$microprojet_id,$microprojet) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		if(count($menages) >0) {
			// EXISTENCE BENEFICIAIRES
			/////////////////Correction////////////////
			$ile=$nom_ile;	
			$village_id=$id_village;
			$nom_village=$village;	
			/////////////////Correction////////////////	
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
			$ile_tmp = $ile;
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
			
			$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			if(!is_dir($directoryName)) {
				mkdir($directoryName, 0777,true);
			}
			$directoryName2 = dirname(__FILE__) . "/../../../../importexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
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
			$activite = "";		
			$nom_activite = "";		
			$activite_id = null;	
			// if(isset($activite_id) && intval($activite_id) >0) {	
				// $requete_act ="select Detail as nom_activite from see_activite where id=".$activite_id;
					// $xx = $conn->query($requete_act);
					// while ($row = $xx->fetch()) {
						// $nom_activite= $row['nom_activite'];
					// }
			// }		
			$nom_village=str_replace ( "é" , "e" ,  $nom_village );
			$nom_village=str_replace ( "ô" , "o" ,  $nom_village );
			$nom_village=str_replace ( "Ô" , "o" ,  $nom_village );
			$nom_village=str_replace ( "î" , "i" ,  $nom_village );
			$nom_village=str_replace ( "Î" , "i" ,  $nom_village );
			$nom_village=str_replace ( "è" , "e" ,  $nom_village );
			$nom_village=str_replace ( "à" , "a" ,  $nom_village );
			$nom_village=str_replace ( "ç" , "c" ,  $nom_village );
			$nom_village=str_replace ( "'" , "" ,  $nom_village );
			$nom_village=strtoupper($nom_village);
			$ile_encours = "";
			$region_encours = "";
			$commune_encours = "";
			$village_encours = "";
			// DEBUT FICHE DE PRESENCE MENAGE APTE	
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de présence")
									 ->setSubject("Liste Fiche de présence")
									 ->setDescription("Liste Fiche de présence")
									 ->setKeywords("Liste Fiche de présence")
									 ->setCategory("Liste Fiche de présence");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de présence');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)	;		
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 11);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFirstPageNumber(1);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenHeader('&C&16&BFADC');
				// &L/&C/&R : left/center/righr &F ==> nom du fichier	&P numéro page &N : nombre de page ; &chiffre : font-size;&B : bold
				// Left taille police 16 Bold + ACT PFSS ;centre : nom du fichier; Right : Page N° / total page
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
			   $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');			
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(17);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);			
				$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(17);
				$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setSize(16);			
				$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
				$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
				$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
				$objPHPExcel->getActiveSheet()->getStyle('A1:G11')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3:G11')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A4:G11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
				$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
				$objPHPExcel->getActiveSheet()->mergeCells('A10:A11');
				$objPHPExcel->getActiveSheet()->mergeCells('B10:B11');
				$objPHPExcel->getActiveSheet()->mergeCells('C10:D10');
				$objPHPExcel->getActiveSheet()->mergeCells('E10:E11');
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setWrapText(true);						
				$objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
				$objPHPExcel->getActiveSheet()->setCellValue('C11',"Début journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('D11',"Fin journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('F11',"Début journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('G11',"Fin journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$nom_village);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A4:G5')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PRESENCE DES BENEFICIAIRES')
							->setCellValue('A10', 'N° identification')
							->setCellValue('B10', 'Nom et prénom travailleur principal')
							->setCellValue('C10', 'Signature')
							->setCellValue('E10', 'Nom et prénom du remplaçant')
							->setCellValue('F10', 'Signature')
							->setCellValue('A3', 'SER DE :')
							->setCellValue('C3', $nom_ile)
							->setCellValue('A7', "Nom de l'AGEX :")
							->setCellValue('C7', $nom_agex)
							->setCellValue('A8', "ZIP N° :")
							->setCellValue('C8', $code_zip)
							// ->setCellValue('A7', "SA N° :")
							->setCellValue('A9', 'Journée du :');
				if(isset($activite_id) && intval($activite_id) >0) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Intitulé du sous-projet :')->setCellValue('C4', $nom_activite);				
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Etape :')->setCellValue('C6', $etape);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Année :')->setCellValue('C5', $annee);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Sous-projet :')->setCellValue('C4', $microprojet);
				}			
				$objPHPExcel->getActiveSheet()->getStyle('C3:C8')->getFont()->setItalic(true);
			$nombreenregistrement = count($menages);				
			if(isset($menages)) {	
				$i=7;
				$nombreligne=0;
				$combien =1;
				$premier=0;
				foreach ($menages as $ii => $d) {
					if(intval($d->inapte)==0) {				
						$menage= $d->menage;
						$nomChefMenage =$d->nomchefmenage;
						$nomTravailleur = $d->nomTravailleur;
						$nomTravailleurSuppliant = $d->nomTravailleurSuppliant;
						if($premier==0) {
							$ile_encours = $ile;
							$region_encours = $region;
							$commune_encours = $commune;
							$village_encours = $village;
							$premier=1;
						}
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(25);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':G' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($menage) ? $menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue("B" . ($i + 5),isset($nomTravailleur) ? $nomTravailleur : "");			
						$objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($nomTravailleurSuppliant) ? $nomTravailleurSuppliant : "");		
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':H'.($i + 5))->getAlignment()->setWrapText(true);			
						$i = $i + 1;
						$nombreligne=$nombreligne + 1;					
						if($nombreligne==20 || $nombreenregistrement < $combien) {
							$nombreligne=0;
							$objPHPExcel->getActiveSheet()->mergeCells('A'.($i + 5).':B'.($i + 5));
							$objPHPExcel->getActiveSheet()->mergeCells('F'.($i + 5).':G'.($i + 5));
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':G'. ($i + 5))->getFont()->setName('Calibri')->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':G'. ($i + 5))->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->setCellValue("A" . ($i + 5),"Le Chef de chantier");	
							$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"Le socio organisateur");				
							// Saut de page AUTO
							$objPHPExcel->getActiveSheet()->setBreak('A'.($i + 5), PHPExcel_Worksheet::BREAK_ROW);
							$i = $i + 1;
						}	
						$combien = $combien  + 1;
					}	
				}
			}
			$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
			$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
			$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
			$region_encours=str_replace ( "é" , "e" ,  $region_encours );
			$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "è" , "e" ,  $region_encours );
			$region_encours=str_replace ( "à" , "a" ,  $region_encours );
			$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
			$region_encours=str_replace ( "'" , "" ,  $region_encours );		
			$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
			$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
			$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
			$village_encours=str_replace ( "é" , "e" ,  $village_encours );
			$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "è" , "e" ,  $village_encours );
			$village_encours=str_replace ( "à" , "a" ,  $village_encours );
			$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
			$village_encours=str_replace ( "'" , "" ,  $village_encours );
			$village_encours=strtolower ($village_encours);
			$nom_agex=str_replace ( "é" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "Ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "Î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "è" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "à" , "a" ,  $nom_agex );
			$nom_agex=str_replace ( "ç" , "c" ,  $nom_agex );
			$nom_agex=str_replace ( "'" , "" ,  $nom_agex );
			$date_edition=date('d-m-Y');
			$fichier1="NON";
			$Filename1 ="";
			if($premier==1) {
				$Filename1 = "Fiche de presence ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." "." edition du ".$date_edition.".xlsx";
				//Check if the directory already exists.
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName.$Filename1);
				$fichier1="OK";				
			}
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de présence")
									 ->setSubject("Liste Fiche de présence")
									 ->setDescription("Liste Fiche de présence")
									 ->setKeywords("Liste Fiche de présence")
									 ->setCategory("Liste Fiche de présence");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de présence');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:F6')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
			   $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFirstPageNumber(1);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PRESENCE')
							->setCellValue('G1', '0')
							->setCellValue('A6', 'Ménage')
							->setCellValue('B6', 'Chef ménage')
							->setCellValue('C6', 'Travailleur principal')
							->setCellValue('D6', 'Nb j Ppal')
							->setCellValue('E6', 'Travailleur suppléant')
							->setCellValue('F6', 'Nb j Suppl')
							->setCellValue('C2', 'Du :   ')
							->setCellValue('E2', 'Au :   ')
							->setCellValue('A5', 'AGEX :')
							->setCellValue('B5', $nom_agex)
							->setCellValue('G3', $agex_id)
							->setCellValue('H1', '0')
							->setCellValue('C3', 'Nb jour travail :  ');
				if(isset($activite_id) && intval($activite_id) >0) {
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A2', 'Activité :')
							->setCellValue('B2', $nom_activite)
							->setCellValue('G2', $activite_id);				
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A4', 'Etape :')
							->setCellValue('B4', $etape)
							->setCellValue('A2', 'Sous-projet : ')
							->setCellValue('B2', $microprojet)
							->setCellValue('A3', 'Année : ')
							->setCellValue('B3', $annee)
							->setCellValue('H2', $etape_id)
							->setCellValue('H3', $microprojet_id)
							->setCellValue('H4', $annee_id);
				}			
				$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('C2:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('D2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->getStyle('F2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->getStyle('D3')->getNumberFormat()->setFormatCode("##0");				
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);			
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(false);			
			if(isset($menages)) {	
				$i=2;
				$premier=0;
				foreach ($menages as $ii => $d) {
					if(intval($d->inapte)==0) {
						$id=$d->id;
						$menage= $d->menage	;
						$nomChefMenage =$d->nomchefmenage;
						$nomTravailleur = $d->nomTravailleur;
						$nomTravailleurSuppliant = $d->nomTravailleurSuppliant;
						$id_menage = $d->id_menage;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':F' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"ETAT DE PRESENCE VILLAGE   :  ".$village);	
							$ile_encours = $ile;
							$region_encours = $region;
							$commune_encours = $commune;
							$village_encours = $village;	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', $village_id);
							$premier=1;
						}				
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":C".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle("E" .($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
						$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($menage) ? $menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),isset($nomChefMenage) ? $nomChefMenage : "");			
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($nomTravailleur) ? $nomTravailleur : "");			
						$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($nomTravailleurSuppliant) ? $nomTravailleurSuppliant : "");		
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),$id_menage);	
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':H'.($i + 5))->getAlignment()->setWrapText(true);			
						$i = $i + 1;
					}		
				}
			}			
			$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
			$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
			$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
			$region_encours=str_replace ( "é" , "e" ,  $region_encours );
			$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "è" , "e" ,  $region_encours );
			$region_encours=str_replace ( "à" , "a" ,  $region_encours );
			$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
			$region_encours=str_replace ( "'" , "" ,  $region_encours );		
			$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
			$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
			$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
			$village_encours=str_replace ( "é" , "e" ,  $village_encours );
			$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "è" , "e" ,  $village_encours );
			$village_encours=str_replace ( "à" , "a" ,  $village_encours );
			$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
			$village_encours=str_replace ( "'" , "" ,  $village_encours );
			$village_encours=strtolower ($village_encours);
			$nom_agex=str_replace ( "é" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "Ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "Î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "è" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "à" , "a" ,  $nom_agex );
			$nom_agex=str_replace ( "ç" , "c" ,  $nom_agex );
			$nom_agex=str_replace ( "'" , "" ,  $nom_agex );
			$fichier2="NON";
			$Filename2 ="";
			if($premier==1) {
				$Filename2 = "Etat de presence ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." "." edition du ".$date_edition.".xlsx";
				//Check if the directory already exists.
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName2.$Filename2);
				$fichier2="OK";
			}	
			// FIN FICHE ETAT DE PRESENCE  MENAGE APTE		
			// DEBUT FICHE ETAT DE PRESENCE  MENAGE INAPTE	
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de présence")
									 ->setSubject("Liste Fiche de présence")
									 ->setDescription("Liste Fiche de présence")
									 ->setKeywords("Liste Fiche de présence")
									 ->setCategory("Liste Fiche de présence");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de présence');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)	;		
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 11);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFirstPageNumber(1);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');			
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(17);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);			
				$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(17);
				$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setSize(16);			
				$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
				$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');
				$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
				$objPHPExcel->getActiveSheet()->getStyle('A1:G10')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A3:G10')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A9:G10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A4:G10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
				$objPHPExcel->getActiveSheet()->mergeCells('A5:B5');
				$objPHPExcel->getActiveSheet()->mergeCells('A10:A11');
				$objPHPExcel->getActiveSheet()->mergeCells('B10:B11');
				$objPHPExcel->getActiveSheet()->mergeCells('C10:D10');
				$objPHPExcel->getActiveSheet()->mergeCells('E10:E11');
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
				$objPHPExcel->getActiveSheet()->setCellValue('C11',"Début journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('D11',"Fin journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('F11',"Début journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('G11',"Fin journée");			
				$objPHPExcel->getActiveSheet()->setCellValue('A2',$nom_village);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A10:G11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A4:G5')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PRESENCE DES BENEFICIAIRES (MENAGE INAPTE)')
							->setCellValue('A10', 'N° identification')
							->setCellValue('B10', 'Nom et prénom travailleur principal')
							->setCellValue('C10', 'Signature')
							->setCellValue('E10', 'Nom et prénom du remplaçant')
							->setCellValue('F10', 'Signature')
							->setCellValue('A3', 'SER DE :')
							->setCellValue('C3', $nom_ile)
							->setCellValue('A7', "Nom de l'AGEX :")
							->setCellValue('C7', $nom_agex)
							->setCellValue('A8', "ZIP N° :")
							->setCellValue('C8', $code_zip)
							// ->setCellValue('A7', "SA N° :")
							->setCellValue('A9', 'Journée du :');
				if(isset($activite_id) && intval($activite_id) >0) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Intitulé du sous-projet :')->setCellValue('C4', $nom_activite);				
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Etape :')->setCellValue('C6', $etape);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Année :')->setCellValue('C5', $annee);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Sous-projet :')->setCellValue('C4', $microprojet);
				}			
				$objPHPExcel->getActiveSheet()->getStyle('C3:C8')->getFont()->setItalic(true);
							
			$nombreenregistrement = count($menages);				
			if(isset($menages)) {	
				$i=7;
				$nombreligne=0;
				$combien =1;
				$premier=0;
				$existe_inapte=0;
				foreach ($menages as $ii => $d) {
					if(intval($d->inapte)==1) {				
						$menage= $d->menage	;
						$nomChefMenage =$d->nomchefmenage;
						$nomTravailleur = $d->nomTravailleur;
						$nomTravailleurSuppliant = $d->nomTravailleurSuppliant;
						if($premier==0) {
							$ile_encours = $ile;
							$region_encours = $region;
							$commune_encours = $commune;
							$village_encours = $village;
							$premier=1;
							$existe_inapte=1;
						}
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(25);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':G' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($menage) ? $menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue("B" . ($i + 5),isset($nomTravailleur) ? $nomTravailleur : "");			
						$objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($nomTravailleurSuppliant) ? $nomTravailleurSuppliant : "");		
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':H'.($i + 5))->getAlignment()->setWrapText(true);			
						$i = $i + 1;
						$nombreligne=$nombreligne + 1;
						if($nombreligne==20 || $nombreenregistrement < $combien) {
							$nombreligne=0;
							$objPHPExcel->getActiveSheet()->mergeCells('A'.($i + 5).':B'.($i + 5));
							$objPHPExcel->getActiveSheet()->mergeCells('F'.($i + 5).':G'.($i + 5));
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':G'. ($i + 5))->getFont()->setName('Calibri')->setSize(12);
							$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':G'. ($i + 5))->getFont()->setBold(true);
							$objPHPExcel->getActiveSheet()->setCellValue("A" . ($i + 5),"Le Chef de chantier");	
							$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"Le socio organisateur");				
							// Saut de page AUTO
							$objPHPExcel->getActiveSheet()->setBreak('A'.($i + 5), PHPExcel_Worksheet::BREAK_ROW);
							$i = $i + 1;
						}	
						$combien = $combien  + 1;
					}	
				}
			}
			$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
			$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
			$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
			$region_encours=str_replace ( "é" , "e" ,  $region_encours );
			$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "è" , "e" ,  $region_encours );
			$region_encours=str_replace ( "à" , "a" ,  $region_encours );
			$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
			$region_encours=str_replace ( "'" , "" ,  $region_encours );		
			$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
			$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
			$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
			$village_encours=str_replace ( "é" , "e" ,  $village_encours );
			$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "è" , "e" ,  $village_encours );
			$village_encours=str_replace ( "à" , "a" ,  $village_encours );
			$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
			$village_encours=str_replace ( "'" , "" ,  $village_encours );
			$village_encours=strtolower ($village_encours);
			$nom_agex=str_replace ( "é" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "Ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "Î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "è" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "à" , "a" ,  $nom_agex );
			$nom_agex=str_replace ( "ç" , "c" ,  $nom_agex );
			$nom_agex=str_replace ( "'" , "" ,  $nom_agex );
			$date_edition=date('d-m-Y');
			$fichier3="NON";
			$Filename3 ="";
			if($premier==1) {
				$Filename3 = "Fiche de presence INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." "." edition du ".$date_edition.".xlsx";
				//Check if the directory already exists.
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName.$Filename3);
				$fichier3="OK";
			}
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de présence")
									 ->setSubject("Liste Fiche de présence")
									 ->setDescription("Liste Fiche de présence")
									 ->setKeywords("Liste Fiche de présence")
									 ->setCategory("Liste Fiche de présence");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de présence');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:F6')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenHeader('&C&16&BFADC');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
			   $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A3:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:F6')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(21);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setFirstPageNumber(1);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PRESENCE')
							->setCellValue('G1', '0')
							->setCellValue('A6', 'Ménage')
							->setCellValue('B6', 'Chef ménage')
							->setCellValue('C6', 'Travailleur principal')
							->setCellValue('D6', 'Nb j Ppal')
							->setCellValue('E6', 'Travailleur suppléant')
							->setCellValue('F6', 'Nb j Suppl')
							->setCellValue('C2', 'Du :   ')
							->setCellValue('E2', 'Au :   ')
							->setCellValue('A5', 'AGEX :')
							->setCellValue('B5', $nom_agex)
							->setCellValue('G3', $agex_id)
							->setCellValue('H1', '1')
							->setCellValue('C3', 'Nb jour travail :  ');
				if(isset($activite_id) && intval($activite_id) >0) {
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A2', 'Activité :')
							->setCellValue('B2', $nom_activite)
							->setCellValue('G2', $activite_id);				
				} else {	
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A4', 'Etape :')
							->setCellValue('B4', $etape)
							->setCellValue('A2', 'Sous-projet : ')
							->setCellValue('B2', $microprojet)
							->setCellValue('A3', 'Année : ')
							->setCellValue('B3', $annee)
							->setCellValue('H2', $etape_id)
							->setCellValue('H3', $microprojet_id)
							->setCellValue('H4', $annee_id);
				}			
				$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A3:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('C2:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('D2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->getStyle('F2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->getStyle('D3')->getNumberFormat()->setFormatCode("##0");				
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(false);
			if(isset($menages)) {	
				$i=2;
				$premier=0;
				$existe_inapte=0;
				foreach ($menages as $ii => $d) {
					if(intval($d->inapte)==1) {
						$id=$d->id;
						$menage= $d->menage	;
						$nomChefMenage =$d->nomchefmenage;
						$nomTravailleur = $d->nomTravailleur;
						$nomTravailleurSuppliant = $d->nomTravailleurSuppliant;
						$id_menage = $d->id_menage;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':F' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"ETAT DE PRESENCE VILLAGE   :  ".$village." (MENAGE INAPTE)");	
							$ile_encours = $ile;
							$region_encours = $region;
							$commune_encours = $commune;
							$village_encours = $village;	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', $village_id);
							$premier=1;
							$existe_inapte=1;
						}				
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":C".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle("E" .($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
						$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($menage) ? $menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),isset($nomChefMenage) ? $nomChefMenage : "");			
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($nomTravailleur) ? $nomTravailleur : "");			
						$objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($nomTravailleurSuppliant) ? $nomTravailleurSuppliant : "");		
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),$id_menage);	
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':H'.($i + 5))->getAlignment()->setWrapText(true);			
						$i = $i + 1;
					}		
				}
			}			
			$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
			$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
			$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
			$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
			$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
			$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
			$region_encours=str_replace ( "é" , "e" ,  $region_encours );
			$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
			$region_encours=str_replace ( "î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
			$region_encours=str_replace ( "è" , "e" ,  $region_encours );
			$region_encours=str_replace ( "à" , "a" ,  $region_encours );
			$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
			$region_encours=str_replace ( "'" , "" ,  $region_encours );		
			$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
			$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
			$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
			$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
			$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
			$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
			$village_encours=str_replace ( "é" , "e" ,  $village_encours );
			$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
			$village_encours=str_replace ( "î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
			$village_encours=str_replace ( "è" , "e" ,  $village_encours );
			$village_encours=str_replace ( "à" , "a" ,  $village_encours );
			$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
			$village_encours=str_replace ( "'" , "" ,  $village_encours );
			$village_encours=strtolower ($village_encours);
			$nom_agex=str_replace ( "é" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "Ô" , "o" ,  $nom_agex );
			$nom_agex=str_replace ( "î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "Î" , "i" ,  $nom_agex );
			$nom_agex=str_replace ( "è" , "e" ,  $nom_agex );
			$nom_agex=str_replace ( "à" , "a" ,  $nom_agex );
			$nom_agex=str_replace ( "ç" , "c" ,  $nom_agex );
			$nom_agex=str_replace ( "'" , "" ,  $nom_agex );
			// FIN MENAGE INAPTE	
			$fichier4="NON";
			$Filename4 ="";
			if($premier==1) {
				$Filename4 = "Etat de presence INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." "." edition du ".$date_edition.".xlsx";
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName2.$Filename4);
				$fichier4="OK";
			}	  
			//ETAT DE RETOUR
			try
			{
				$this->response([
					'status' => TRUE,
					'retour' =>	     "OK",
					'ile' =>	     $ile_encours,
					'region' =>	     $region_encours,
					'commune' =>	 $commune_encours,
					'village' =>	 $village_encours,
					'nom_ile' =>	 $nom_ile,
					'microprojet' => $microprojet,
					'nom_agex' =>	 $nom_agex,
					'date_edition'=> $date_edition,	
					'fichier3' => $fichier3,
					'fichier4' => $fichier4,
					'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
					'name_file1' => $Filename1,
					'name_file2' => $Filename2,
					'name_file3' => $Filename3,
					'name_file4' => $Filename4,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);
			  
			} 
			catch (PHPExcel_Writer_Exception $e)
			{
				$this->response([
					  'status' => FALSE,
					   'nom_file' => array(),
					   'message' => "Something went wrong: ". $e->getMessage(),
					], REST_Controller::HTTP_OK);
			}
		} else {
			$this->response([
				  'status' => FALSE,
				   'retour' => "NON",
				   'message' => "Aucun ménage bénéficiaire pour le filtre choisi !.'",
				], REST_Controller::HTTP_OK);		
		}
        //ETAT DE RETOUR
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////:

	public function exportlisteficheetatdepaiement($detail, $nom_ile, $region, $commune, $village_id, $id_village, $village, $agex_id, $nom_agex, $etape_id,$etape,$annee_id,$annee,$code_zip,$microprojet_id,$microprojet,$id_fichepresence,$fichepresence_id,$indemnite,$agep_id,$nom_agep,$nombrejourdetravail,$inapte,$datedu,$datefin) {	 
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$fichier3="NON";
		$Filename3 ="";
		$fichier4="NON";
		$Filename4 ="";
		/////////////////Correction////////////////	
		$ile=$nom_ile;	
		$village_id=$id_village;
		$nom_village=$village;	
		/////////////////Correction////////////////			
		$ile_encours = $ile;
		$region_encours = $region;
		$commune_encours = $commune;
		$village_encours = $village;	
		
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
		$ile_tmp = $ile;
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
		
		$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
		if(!is_dir($directoryName)) {
			mkdir($directoryName, 0777,true);
		}
		$directoryName2 = dirname(__FILE__) . "/../../../../importexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
		if(!is_dir($directoryName2)) {
			mkdir($directoryName2, 0777,true);
		}
		$menages = array();
		$inapte_ou_apte = $inapte;	
		$datedebut=date_create($datedu);
		$datefinal=date_create($datefin);
		$date_fichierexcel="(présence du ".date_format($datedebut,'d/m/y')." au ".date_format($datefinal,'d/m/y');
		$datedu_nomfichier=date_format($datedebut,'d m y');
		$datefin_nomfichier=date_format($datefinal,'d m y');
		$zone = $code_zip;	
		$activite_id = null;
		$activite =null;
		if($nom_ile=="Moheli") {
			$nom_ile="MWL";
		} else if($nom_ile=="Anjouan"){
			$nom_ile="NDZ";
		} else {
			$nom_ile="NGZ";
		}		
		$nom_agex=str_replace ( "é" , "e" ,  $nom_agex );
		$nom_agex=str_replace ( "ô" , "o" ,  $nom_agex );
		$nom_agex=str_replace ( "Ô" , "o" ,  $nom_agex );
		$nom_agex=str_replace ( "î" , "i" ,  $nom_agex );
		$nom_agex=str_replace ( "Î" , "i" ,  $nom_agex );
		$nom_agex=str_replace ( "è" , "e" ,  $nom_agex );
		$nom_agex=str_replace ( "à" , "a" ,  $nom_agex );
		$nom_agex=str_replace ( "ç" , "c" ,  $nom_agex );
		$nom_agex=str_replace ( "'" , "" ,  $nom_agex );
		if($inapte_ou_apte==0) {
			// DEBUT MENAGE APTE	// Fiche de paiement MENAGE APTE
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de paiement")
									 ->setSubject("Liste Fiche de paiement")
									 ->setDescription("Liste Fiche de paiement")
									 ->setKeywords("Liste Fiche de paiement")
									 ->setCategory("Liste Fiche de paiement");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de paiement');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:K7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(97); // % impression : 10% à 400%
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.4);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6:K7')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A5:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A5:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PAIEMENT')
							->setCellValue('A7', 'Ménage')
							->setCellValue('B7', 'Chef ménage')
							->setCellValue('C7', 'Montant total à payer')
							->setCellValue('D7', 'Nom & Prénom')
							->setCellValue('E7', 'Somme à payer')
							->setCellValue('F7', 'Montant reçu')
							->setCellValue('G7', 'Signature')
							->setCellValue('H7', 'Nom & Prénom')
							->setCellValue('I7', 'Somme à payer')
							->setCellValue('J7', 'Montant reçu')
							->setCellValue('K7', 'Signature')
							->setCellValue('D2', 'Du :');
				if(isset($etape_id) && intval($etape_id)) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Sous-projet :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Année :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Etape :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'AGEP :');
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Activité');
				}	
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
				$objPHPExcel->getActiveSheet()->mergeCells('D6:G6');
				$objPHPExcel->getActiveSheet()->mergeCells('H6:K6');
				$objPHPExcel->getActiveSheet()->mergeCells('B5:K5');
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
				$objPHPExcel->getActiveSheet()->getStyle('A6:C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6:G6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H6:K6')->applyFromArray($styleArray);
				unset($styleArray);	
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Ménages");			
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Travailleur Principal");			
				$objPHPExcel->getActiveSheet()->setCellValue('H6',"Travailleur Suppléant");	
				$contient_menage=0;	
			if(isset($detail)) {	
				$i=3;
				$premier=0;
				foreach ($detail as $ii => $d) {
					if(intval($d->inapte)==0) {
						$NumeroEnregistrement= $d->NumeroEnregistrement;
						$village_id = $d->village_id;
						$menage_id = $d->menage_id;
						$nomchefmenage = $d->nomchefmenage;
						$nomtravailleur = $d->nomtravailleur;
						$nomtravailleursuppliant = $d->nomtravailleursuppliant;
						$nombrejourdetravail = $d->nombrejourdetravail;
						$travailleurpresent = $d->travailleurpresent;
						$montantapayertravailleur = ($d->travailleurpresent * $indemnite);
						$suppliantpresent = $d->suppliantpresent;
						$montantapayersuppliant = ($d->suppliantpresent * $indemnite);	
						$montanttotalapayer =($d->travailleurpresent * $indemnite) + ($d->suppliantpresent * $indemnite);	
						$sexeChefMenage= $d->sexeChefMenage;
						$sexeTravailleur= $d->sexeTravailleur;
						$sexeTravailleurSuppliant= $d->sexeTravailleurSuppliant;
						// $montanttotalapayer = $montantapayertravailleur + $montantapayersuppliant;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':K' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"FICHE DE PAIEMENT VILLAGE   :  ".$village);	
							if(isset($etape_id) && intval($etape_id) >0) {
								$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
								$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);			
								$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$microprojet);	
								$objPHPExcel->getActiveSheet()->setCellValue("B3" ,$annee);	
								$objPHPExcel->getActiveSheet()->setCellValue("B4" ,$etape);	
								$objPHPExcel->getActiveSheet()->setCellValue("B5" ,$nom_agep);	
							} else {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$activite);	
							}	
							$id_village = $village_id;
							$contient_menage=1;
							$premier=1;
						}						
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($NumeroEnregistrement) ? $NumeroEnregistrement : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),isset($nomchefmenage) && $nomchefmenage >"" ? $nomchefmenage." (".$sexeChefMenage.")" : "");			
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($montanttotalapayer) ? $montanttotalapayer : "0");			
						$objPHPExcel->getActiveSheet()->setCellValue("D" . ($i + 5),isset($nomtravailleur) && $nomtravailleur >"" ? $nomtravailleur." (".$sexeTravailleur.")" : "");		
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($montantapayertravailleur) ? $montantapayertravailleur : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("H" . ($i + 5),isset($nomtravailleursuppliant) && $nomtravailleursuppliant >"" ? $nomtravailleursuppliant." (".$sexeTravailleurSuppliant.")" : "");		
						$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5).':F'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5).':J'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('I' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("I" . ($i + 5),isset($montantapayersuppliant) ? $montantapayersuppliant : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue("J" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("K" . ($i + 5),"");	
						if($nomtravailleur=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
							$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						if($nomtravailleursuppliant=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );
							$objPHPExcel->getActiveSheet()->getStyle('H'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}						
						$i = $i + 1;
					}		
				}		
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
					$objPHPExcel->getActiveSheet()->getStyle('C'. ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'. ($i + 5) .':F' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('I'. ($i + 5) .':J' . ($i + 5))->applyFromArray($styleArray);
					unset($styleArray);			
					$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5).':F'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5).':J'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->setCellValue('C'. ($i + 5),'=SUM(C5:C'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('E'. ($i + 5),'=SUM(E5:E'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('F'. ($i + 5),'=SUM(F5:F'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('I'. ($i + 5),'=SUM(I5:I'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('J'. ($i + 5),'=SUM(J5:J'.($i + 4).')');						
			}	
			if($contient_menage==1) {	
				$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
				$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
				$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
				$region_encours=str_replace ( "é" , "e" ,  $region_encours );
				$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "è" , "e" ,  $region_encours );
				$region_encours=str_replace ( "à" , "a" ,  $region_encours );
				$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
				$region_encours=str_replace ( "'" , "" ,  $region_encours );		
				$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
				$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
				$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
				$village_encours=str_replace ( "é" , "e" ,  $village_encours );
				$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "è" , "e" ,  $village_encours );
				$village_encours=str_replace ( "à" , "a" ,  $village_encours );
				$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
				$village_encours=str_replace ( "'" , "" ,  $village_encours );
				$village_encours=strtolower ($village_encours );
				$date_edition=date('d-m-Y');
				$fichier1="NON";
				$Filename1 ="";
				if($premier==1) {					
					// $Filename1 = "Fiche de paiement ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." du ".$datedu_nomfichier." au ".$datefin_nomfichier." "." edition du ".$date_edition.".xlsx";
					$Filename1 = "Fiche de paiement ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." edition du ".$date_edition.".xlsx";
					//Check if the directory already exists.
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$fichier1="OK";
				}	
			}	
		}	
		if($inapte_ou_apte==0) {
			// Etat de paiement	// ETAT de paiement MENAGE APTE
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Etat de paiement")
									 ->setSubject("Etat de paiement")
									 ->setDescription("Etat de paiement")
									 ->setKeywords("Etat de paiement")
									 ->setCategory("Etat de paiement");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Etat de paiement');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:M7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
				$objPHPExcel->getActiveSheet()->mergeCells('K2:M2');
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getAlignment()->setWrapText(true);	
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setName('Calibri')->setSize(8);	
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(98); // % impression : 10% à 400%
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.4);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6:M7')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A6:M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setVisible(false);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setVisible(false);			
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'ETAT DE PAIEMENT')
							->setCellValue('N1', '0')
							->setCellValue('A7', 'Ménage')
							->setCellValue('B7', 'Chef ménage')
							->setCellValue('C7', 'Montant total à payer')
							->setCellValue('D7', 'Montant total payé')
							->setCellValue('E7', 'Reste à payer')
							->setCellValue('F7', 'Nom & Prénom')
							->setCellValue('G7', 'Nb jours')
							->setCellValue('H7', 'Montant à payer')
							->setCellValue('I7', 'Montant payé')
							->setCellValue('J7', 'Nom & Prénom')
							->setCellValue('K7', 'Nb jours')
							->setCellValue('L7', 'Montant à payer')
							->setCellValue('M7', 'Montant payé')
							->setCellValue('D2', 'Du :')
							->setCellValue('A5', 'AGEP :')
							->setCellValue('H2', 'Nb jour :');
				if(isset($etape_id) && intval($etape_id)) {
					$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
					$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);			
					$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Sous-projet :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Année :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Etape :');
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Activité');
				}	
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(27);
				$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->mergeCells('A6:E6');
				$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->mergeCells('F6:I6');
				$objPHPExcel->getActiveSheet()->mergeCells('J6:M6');
				$objPHPExcel->getActiveSheet()->mergeCells('B5:M5');
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
				$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6:I6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J6:M6')->applyFromArray($styleArray);
				unset($styleArray);	
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Ménages");			
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Travailleur Principal");			
				$objPHPExcel->getActiveSheet()->setCellValue('J6',"Travailleur Suppléant");					
				$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getStyle('I2')->getNumberFormat()->setFormatCode("# ##0");
				$objPHPExcel->getActiveSheet()->getStyle('I2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$contient_menage=0;	
			if(isset($detail)) {	
				$i=3;
				$premier=0;
				foreach ($detail as $ii => $d) {
					if(intval($d->inapte)==0) {	
						$NumeroEnregistrement= $d->NumeroEnregistrement;
						$village_id = $d->village_id;
						$menage_id = $d->menage_id;
						$nomchefmenage = $d->nomchefmenage;
						$nomtravailleur = $d->nomtravailleur;
						$nomtravailleursuppliant = $d->nomtravailleursuppliant;
						$nombrejourdetravail = $d->nombrejourdetravail;
						$travailleurpresent = $d->travailleurpresent;
						$montantapayertravailleur = ($d->travailleurpresent * $indemnite);
						$suppliantpresent = $d->suppliantpresent;
						$montantapayersuppliant = ($d->suppliantpresent * $indemnite);	
						$montanttotalapayer =($d->travailleurpresent * $indemnite) + ($d->suppliantpresent * $indemnite);	
						$sexeChefMenage= $d->sexeChefMenage;
						$sexeTravailleur= $d->sexeTravailleur;
						$sexeTravailleurSuppliant= $d->sexeTravailleurSuppliant;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':M' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"ETAT DE PAIEMENT VILLAGE   :  ".$village);								
							if(isset($etape_id) && intval($etape_id) >0) {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$microprojet);	
								$objPHPExcel->getActiveSheet()->setCellValue("B3" ,$annee);	
								$objPHPExcel->getActiveSheet()->setCellValue("B4" ,$etape);	
								$objPHPExcel->getActiveSheet()->setCellValue("O3",$etape_id);	
								$objPHPExcel->getActiveSheet()->setCellValue("O4",$microprojet_id);	
								$objPHPExcel->getActiveSheet()->setCellValue("O5",$annee_id);	
								$objPHPExcel->getActiveSheet()->setCellValue("O6",$indemnite);	
							} else {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$activite);	
								$objPHPExcel->getActiveSheet()->setCellValue("N2",$activite_id);	
							}	
							$objPHPExcel->getActiveSheet()->setCellValue("O2",$agep_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("N3",$village_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("O1",$fichepresence_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("I2",$nombrejourdetravail);	
							$objPHPExcel->getActiveSheet()->setCellValue("K2",$date_fichierexcel);	
							$objPHPExcel->getActiveSheet()->setCellValue("B5",$nom_agep);	
							$id_village = $village_id;	
							$contient_menage=1;
							$premier=1;
						}						
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($NumeroEnregistrement) ? $NumeroEnregistrement : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),$nomchefmenage >'' ? $nomchefmenage.' ('.$sexeChefMenage.')' : "");			
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($montanttotalapayer) ? $montanttotalapayer : "0");				
						$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('D' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("D" . ($i + 5),'=(I'.($i + 5).' + '.'M'.($i + 5).')');				
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),'=(C'.($i + 5).' - '.'D'.($i + 5).')');							
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),$nomtravailleur >'' ? $nomtravailleur.' ('.$sexeTravailleur.')' : "");		
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),isset($travailleurpresent) ? $travailleurpresent : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 5),isset($montantapayertravailleur) ? $montantapayertravailleur : "0");			
						$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("J" . ($i + 5),$nomtravailleursuppliant >'' ? $nomtravailleursuppliant.' ('.$sexeTravailleurSuppliant.')' : "");		
						$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5).':E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5).':I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5).':M'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5).':E'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('H' .($i + 5).':I'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('L' .($i + 5).':M'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->setCellValue("K" . ($i + 5),isset($suppliantpresent) ? $suppliantpresent : "0");	
						$objPHPExcel->getActiveSheet()->setCellValue("L" . ($i + 5),isset($montantapayersuppliant) ? $montantapayersuppliant : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue("M" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("N" . ($i + 5),$menage_id);	
						if($nomtravailleur=='' || $sexeTravailleur=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );
							$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						if($nomtravailleursuppliant =='' || $sexeTravailleurSuppliant=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );
							$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						$i = $i + 1;	
					}	
				}		
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
					$objPHPExcel->getActiveSheet()->getStyle('C'. ($i + 5) .':E' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('G'. ($i + 5) .':I' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('K'. ($i + 5) .':M' . ($i + 5))->applyFromArray($styleArray);
					unset($styleArray);			
					$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5).':E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5).':I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5).':M'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5).':E'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('H' .($i + 5).':I'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('L' .($i + 5).':M'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('K' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->setCellValue('C'. ($i + 5),'=SUM(C5:C'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('D'. ($i + 5),'=SUM(D5:D'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('E'. ($i + 5),'=SUM(E5:E'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('G'. ($i + 5),'=SUM(G5:G'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('H'. ($i + 5),'=SUM(H5:H'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('I'. ($i + 5),'=SUM(I5:I'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('K'. ($i + 5),'=SUM(K5:K'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('L'. ($i + 5),'=SUM(L5:L'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('M'. ($i + 5),'=SUM(M5:M'.($i + 4).')');	
			}	
			if($contient_menage==1) {	
				$i = $i + 2;
				$date_edit=date('d/m/Y');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),"Etabli le : " .$date_edit);			
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 7),"Signature");
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 9),"Nom et prénom :");
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 11),"Titre :");
				$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
				$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
				$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
				$region_encours=str_replace ( "é" , "e" ,  $region_encours );
				$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "è" , "e" ,  $region_encours );
				$region_encours=str_replace ( "à" , "a" ,  $region_encours );
				$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
				$region_encours=str_replace ( "'" , "" ,  $region_encours );		
				$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
				$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
				$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
				$village_encours=str_replace ( "é" , "e" ,  $village_encours );
				$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "è" , "e" ,  $village_encours );
				$village_encours=str_replace ( "à" , "a" ,  $village_encours );
				$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
				$village_encours=str_replace ( "'" , "" ,  $village_encours );
				$village_encours=strtolower ($village_encours );
				$fichier2="NON";
				$Filename2 ="";
				if($premier==1) {	
					$Filename2 = "Etat de paiement ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." edition ".$date_edition.".xlsx";
					// $Filename2 = "Etat de paiement ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." du ".$datedu_nomfichier." au ".$datefin_nomfichier." edition ".$date_edition.".xlsx";
					//Check if the directory already exists.
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save($directoryName2.$Filename2);
					$fichier2="OK";
				}	
			}	
			// FIN MENAGE APTE
		}
		if($inapte_ou_apte==1) {	
			// DEBUT MENAGE INAPTE
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Liste Fiche de paiement")
									 ->setSubject("Liste Fiche de paiement")
									 ->setDescription("Liste Fiche de paiement")
									 ->setKeywords("Liste Fiche de paiement")
									 ->setCategory("Liste Fiche de paiement");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Liste Fiche de paiement');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:K7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(97); // % impression : 10% à 400%
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.4);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A6:K7')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A5:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('A5:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:K7')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'FICHE DE PAIEMENT')
							->setCellValue('A7', 'Ménage')
							->setCellValue('B7', 'Chef ménage')
							->setCellValue('C7', 'Montant total à payer')
							->setCellValue('D7', 'Nom & Prénom')
							->setCellValue('E7', 'Somme à payer')
							->setCellValue('F7', 'Montant reçu')
							->setCellValue('G7', 'Signature')
							->setCellValue('H7', 'Nom & Prénom')
							->setCellValue('I7', 'Somme à payer')
							->setCellValue('J7', 'Montant reçu')
							->setCellValue('K7', 'Signature')
							->setCellValue('A5', 'AGEP :')
							->setCellValue('D2', 'Du :');
				if(isset($etape_id) && intval($etape_id)) {
					$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
					$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);			
					$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Sous-projet :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Année :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Etape :');
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Activité');
				}	
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->mergeCells('A6:C6');
				$objPHPExcel->getActiveSheet()->mergeCells('D6:G6');
				$objPHPExcel->getActiveSheet()->mergeCells('H6:K6');
				$objPHPExcel->getActiveSheet()->mergeCells('B5:K5');
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
				$objPHPExcel->getActiveSheet()->getStyle('A6:C6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('D6:G6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('H6:K6')->applyFromArray($styleArray);
				unset($styleArray);	
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Ménages");			
				$objPHPExcel->getActiveSheet()->setCellValue('D6',"Travailleur Principal");			
				$objPHPExcel->getActiveSheet()->setCellValue('H6',"Travailleur Suppléant");	
			$contient_menage=0;		
			if(isset($detail)) {	
				$i=3;
				$premier =0;
				$existe_inapte=0;
				foreach ($detail as $ii => $d) {
					if(intval($d->inapte)==1) {
						$NumeroEnregistrement= $d->NumeroEnregistrement;
						$village_id = $d->village_id;
						$menage_id = $d->menage_id;
						$nomchefmenage = $d->nomchefmenage;
						$nomtravailleur = $d->nomtravailleur;
						$nomtravailleursuppliant = $d->nomtravailleursuppliant;
						$nombrejourdetravail = $d->nombrejourdetravail;
						$travailleurpresent = $d->travailleurpresent;
						$montantapayertravailleur = ($d->travailleurpresent * $indemnite);
						$suppliantpresent = $d->suppliantpresent;
						$montantapayersuppliant = ($d->suppliantpresent * $indemnite);	
						$montanttotalapayer =($d->travailleurpresent * $indemnite) + ($d->suppliantpresent * $indemnite);	
						$sexeChefMenage= $d->sexeChefMenage;
						$sexeTravailleur= $d->sexeTravailleur;
						$sexeTravailleurSuppliant= $d->sexeTravailleurSuppliant;
						$village_id = $d->village_id;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':K' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"FICHE DE PAIEMENT VILLAGE   :  ".$village ." (MENAGE INAPTE)");	
							if(isset($etape_id) && intval($etape_id) >0) {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$microprojet);	
								$objPHPExcel->getActiveSheet()->setCellValue("B3" ,$annee);	
								$objPHPExcel->getActiveSheet()->setCellValue("B4" ,$etape);	
								$objPHPExcel->getActiveSheet()->setCellValue("B5" ,$nom_agep);	
							} else {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$activite);	
							}	
							$id_village = $village_id;		
							$existe_inapte=1;
							$contient_menage=1;
							$premier=1;
						}						
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($NumeroEnregistrement) ? $NumeroEnregistrement : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),isset($nomchefmenage) && $nomchefmenage >"" ? $nomchefmenage." (".$sexeChefMenage.")" : "");			
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($montanttotalapayer) ? $montanttotalapayer : "0");			
						$objPHPExcel->getActiveSheet()->setCellValue("D" . ($i + 5),isset($nomtravailleur) && $nomtravailleur >"" ? $nomtravailleur." (".$sexeTravailleur.")" : "");		
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),isset($montantapayertravailleur) ? $montantapayertravailleur : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("H" . ($i + 5),isset($nomtravailleursuppliant) && $nomtravailleursuppliant >"" ? $nomtravailleursuppliant." (".$sexeTravailleurSuppliant.")" : "");	
						$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5).':F'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5).':J'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('I' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("I" . ($i + 5),isset($montantapayersuppliant) ? $montantapayersuppliant : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue("J" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("K" . ($i + 5),"");
						if($nomtravailleur=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
							$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						$i = $i + 1;
					}		
				}		
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
					$objPHPExcel->getActiveSheet()->getStyle('C'. ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('E'. ($i + 5) .':F' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('I'. ($i + 5) .':J' . ($i + 5))->applyFromArray($styleArray);
					unset($styleArray);			
					$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5).':F'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('I'.($i + 5).':J'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->setCellValue('C'. ($i + 5),'=SUM(C5:C'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('E'. ($i + 5),'=SUM(E5:E'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('F'. ($i + 5),'=SUM(F5:F'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('I'. ($i + 5),'=SUM(I5:I'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('J'. ($i + 5),'=SUM(J5:J'.($i + 4).')');						
			}
			if($contient_menage==1) {	
				$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
				$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
				$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
				$region_encours=str_replace ( "é" , "e" ,  $region_encours );
				$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "è" , "e" ,  $region_encours );
				$region_encours=str_replace ( "à" , "a" ,  $region_encours );
				$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
				$region_encours=str_replace ( "'" , "" ,  $region_encours );		
				$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
				$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
				$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
				$village_encours=str_replace ( "é" , "e" ,  $village_encours );
				$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "è" , "e" ,  $village_encours );
				$village_encours=str_replace ( "à" , "a" ,  $village_encours );
				$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
				$village_encours=str_replace ( "'" , "" ,  $village_encours );
				$village_encours=strtolower ($village_encours );
				$date_edition=date('d-m-Y');
				$fichier3="NON";
				$Filename3 ="";
				if($premier==1) {
					$Filename3 = "Fiche de paiement INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." edition ".$date_edition.".xlsx";
					// $Filename3 = "Fiche de paiement INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." du ".$datedu_nomfichier." au ".$datefin_nomfichier." edition ".$date_edition.".xlsx";
					//Check if the directory already exists.
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save($directoryName.$Filename3);
					$fichier3="OK";
				}
			}	
		}
		if($inapte_ou_apte==1) {	
			// Etat de paiement MENAGE INAPTE	
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("PFSS")
									 ->setLastModifiedBy("PFSS")
									 ->setTitle("Etat de paiement")
									 ->setSubject("Etat de paiement")
									 ->setDescription("Etat de paiement")
									 ->setKeywords("Etat de paiement")
									 ->setCategory("Etat de paiement");
				$objRichText = new PHPExcel_RichText();
				$objRichText->createText('Etat de paiement');
				$objPHPExcel->setActiveSheetIndex(0);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);			
				$objPHPExcel->getActiveSheet()->getStyle('A1:M7')->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getFont()->setName('Calibri')->setSize(10);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
				$objPHPExcel->getActiveSheet()->mergeCells('K2:M2');
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:R2')->getAlignment()->setWrapText(true);	
				$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setName('Calibri')->setSize(8);	
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&L&16&B ACT P PFSS&R&11&B Page &P / &N');
				$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 7);
				$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(98); // % impression : 10% à 400%
				$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.4);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.2);
				$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);			
				$styleArray = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
				);
				$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A7:M7')->applyFromArray($styleArray);
				unset($styleArray);			
				$objPHPExcel->getActiveSheet()->getStyle('A6:M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A6:M7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A2:M7')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(19);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
				$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setVisible(false);			
				$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setVisible(false);			
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', 'ETAT DE PAIEMENT')
							->setCellValue('N1', '1')
							->setCellValue('A7', 'Ménage')
							->setCellValue('B7', 'Chef ménage')
							->setCellValue('C7', 'Montant total à payer')
							->setCellValue('D7', 'Montant total payé')
							->setCellValue('E7', 'Reste à payer')
							->setCellValue('F7', 'Nom & Prénom')
							->setCellValue('G7', 'Nb jours')
							->setCellValue('H7', 'Montant à payer')
							->setCellValue('I7', 'Montant payé')
							->setCellValue('J7', 'Nom & Prénom')
							->setCellValue('K7', 'Nb jours')
							->setCellValue('L7', 'Montant à payer')
							->setCellValue('M7', 'Montant payé')
							->setCellValue('D2', 'Du :')
							->setCellValue('A5', 'AGEP :')
							->setCellValue('H2', 'Nb jour :');
				if(isset($etape_id) && intval($etape_id)) {
					$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
					$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);			
					$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Sous-projet :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Année :');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Etape :');
				} else {			
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Activité');
				}	
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(27);
				$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
				$objPHPExcel->getActiveSheet()->mergeCells('A6:E6');
				$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
				$objPHPExcel->getActiveSheet()->mergeCells('F6:I6');
				$objPHPExcel->getActiveSheet()->mergeCells('J6:M6');
				$objPHPExcel->getActiveSheet()->mergeCells('B5:M5');
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
				$objPHPExcel->getActiveSheet()->getStyle('A6:E6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('F6:I6')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('J6:M6')->applyFromArray($styleArray);
				unset($styleArray);	
				$objPHPExcel->getActiveSheet()->setCellValue('A6',"Ménages");			
				$objPHPExcel->getActiveSheet()->setCellValue('F6',"Travailleur Principal");			
				$objPHPExcel->getActiveSheet()->setCellValue('J6',"Travailleur Suppléant");					
				$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setWrapText(true);			
				$objPHPExcel->getActiveSheet()->getStyle('I2')->getNumberFormat()->setFormatCode("# ##0");
				$objPHPExcel->getActiveSheet()->getStyle('I2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$contient_menage=0;
			if(isset($detail)) {	
				$i=3;
				$existe_inapte=0;
				$premier=0;
				foreach ($detail as $ii => $d) {
					if(intval($d->inapte)==1) {				
						$NumeroEnregistrement= $d->NumeroEnregistrement;
						$village_id = $d->village_id;
						$menage_id = $d->menage_id;
						$nomchefmenage = $d->nomchefmenage;
						$nomtravailleur = $d->nomtravailleur;
						$nomtravailleursuppliant = $d->nomtravailleursuppliant;
						$nombrejourdetravail = $d->nombrejourdetravail;
						$travailleurpresent = $d->travailleurpresent;
						$montantapayertravailleur = ($d->travailleurpresent * $indemnite);
						$suppliantpresent = $d->suppliantpresent;
						$montantapayersuppliant = ($d->suppliantpresent * $indemnite);	
						$montanttotalapayer =($d->travailleurpresent * $indemnite) + ($d->suppliantpresent * $indemnite);	
						$sexeChefMenage= $d->sexeChefMenage;
						$sexeTravailleur= $d->sexeTravailleur;
						$sexeTravailleurSuppliant= $d->sexeTravailleurSuppliant;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getRowDimension(($i + 5))->setRowHeight(30);
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5) .':M' . ($i + 5))->applyFromArray($styleArray);
						unset($styleArray);	
						if($premier==0) {
							$objPHPExcel->getActiveSheet()->setCellValue("A1" ,"ETAT DE PAIEMENT VILLAGE   :  ".$village ." (MENAGE INAPTE)");	
							if(isset($etape_id) && intval($etape_id) >0) {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$microprojet);	
								$objPHPExcel->getActiveSheet()->setCellValue("B3" ,$annee);	
								$objPHPExcel->getActiveSheet()->setCellValue("B4" ,$etape);	
								$objPHPExcel->getActiveSheet()->setCellValue("O3",$etape_id);	
								$objPHPExcel->getActiveSheet()->setCellValue("O4",$microprojet_id);	
								$objPHPExcel->getActiveSheet()->setCellValue("O5",$annee_id);
								$objPHPExcel->getActiveSheet()->setCellValue("O6",$indemnite);									
							} else {
								$objPHPExcel->getActiveSheet()->setCellValue("B2" ,$activite);	
								$objPHPExcel->getActiveSheet()->setCellValue("N2",$activite_id);	
							}	
							$objPHPExcel->getActiveSheet()->setCellValue("O2",$agep_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("N3",$village_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("O1",$fichepresence_id);	
							$objPHPExcel->getActiveSheet()->setCellValue("I2",$nombrejourdetravail);	
							$objPHPExcel->getActiveSheet()->setCellValue("K2",$date_fichierexcel);	
							$objPHPExcel->getActiveSheet()->setCellValue("B5",$nom_agep);	
							$ile_encours = $ile;
							$region_encours = $region;
							$commune_encours = $commune;
							$village_encours = $village;
							$id_village = $village_id;
							$existe_inapte=1;
							$contient_menage=1;	
							$premier=1;						
						}						
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('A'. ($i + 5).':R'. ($i + 5))->getFont()->setName('Calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle("A" . ($i + 5).":F".($i + 5))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
						$objPHPExcel->getActiveSheet()->getStyle('A' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5).':Z'.($i + 5))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);				
						$objPHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 5),isset($NumeroEnregistrement) ? $NumeroEnregistrement : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),$nomchefmenage >'' ? $nomchefmenage.' ('.$sexeChefMenage.')' : "");			
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("C" . ($i + 5),isset($montanttotalapayer) ? $montanttotalapayer : "0");				
						$objPHPExcel->getActiveSheet()->getStyle('D'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('D' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("D" . ($i + 5),'=(I'.($i + 5).' + '.'M'.($i + 5).')');				
						$objPHPExcel->getActiveSheet()->getStyle('E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('E' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("E" . ($i + 5),'=(C'.($i + 5).' - '.'D'.($i + 5).')');							
						$objPHPExcel->getActiveSheet()->setCellValue("F" . ($i + 5),$nomtravailleur >'' ? $nomtravailleur.' ('.$sexeTravailleur.')' : "");		
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),isset($travailleurpresent) ? $travailleurpresent : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 5),isset($montantapayertravailleur) ? $montantapayertravailleur : "0");			
						$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 5),"");			
						$objPHPExcel->getActiveSheet()->setCellValue("J" . ($i + 5),$nomtravailleursuppliant >'' ? $nomtravailleursuppliant.' ('.$sexeTravailleurSuppliant.')' : "");		
						$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5).':E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5).':I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5).':M'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");				
						$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5).':E'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('H' .($i + 5).':I'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('L' .($i + 5).':M'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->setCellValue("K" . ($i + 5),isset($suppliantpresent) ? $suppliantpresent : "0");	
						$objPHPExcel->getActiveSheet()->setCellValue("L" . ($i + 5),isset($montantapayersuppliant) ? $montantapayersuppliant : "0");						
						$objPHPExcel->getActiveSheet()->setCellValue("M" . ($i + 5),"");	
						$objPHPExcel->getActiveSheet()->setCellValue("N" . ($i + 5),$menage_id);	
						if($nomtravailleur=='' || $sexeTravailleur=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );
							$objPHPExcel->getActiveSheet()->getStyle('F'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						if($nomtravailleursuppliant >'' && $sexeTravailleurSuppliant=='') {
							$objPHPExcel->getActiveSheet()->getStyle('A'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );
							$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 5))->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'FF0000'),
										 'endcolor'   => array('argb' => 'FF0000')
									 )
							 );						
						}
						$i = $i + 1;	
					}	
				}		
					$styleArray = array(
					  'borders' => array(
						'allborders' => array(
						  'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					  )
					);
					$objPHPExcel->getActiveSheet()->getStyle('C'. ($i + 5) .':E' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('G'. ($i + 5) .':I' . ($i + 5))->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->getStyle('K'. ($i + 5) .':M' . ($i + 5))->applyFromArray($styleArray);
					unset($styleArray);			
					$objPHPExcel->getActiveSheet()->getStyle('C'.($i + 5).':E'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 5).':I'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('K'.($i + 5).':M'.($i + 5))->getNumberFormat()->setFormatCode("### ### ##0");
					$objPHPExcel->getActiveSheet()->getStyle('C' .($i + 5).':E'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('H' .($i + 5).':I'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('L' .($i + 5).':M'.($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->getStyle('G' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('K' .($i + 5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->setCellValue('C'. ($i + 5),'=SUM(C5:C'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('D'. ($i + 5),'=SUM(D5:D'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('E'. ($i + 5),'=SUM(E5:E'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('G'. ($i + 5),'=SUM(G5:G'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('H'. ($i + 5),'=SUM(H5:H'.($i + 4).')');				
					$objPHPExcel->getActiveSheet()->setCellValue('I'. ($i + 5),'=SUM(I5:I'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('K'. ($i + 5),'=SUM(K5:K'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('L'. ($i + 5),'=SUM(L5:L'.($i + 4).')');						
					$objPHPExcel->getActiveSheet()->setCellValue('M'. ($i + 5),'=SUM(M5:M'.($i + 4).')');						
			}
			if($contient_menage==1) {
				$i = $i + 2;
				$date_edit=date('d/m/Y');
				$objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 5),"Etabli le : " .$date_edit);			
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 7),"Signature");
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 9),"Nom et prénom :");
				$objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 11),"Titre :");
				$ile_encours=str_replace ( "é" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "Ô" , "o" ,  $ile_encours );
				$ile_encours=str_replace ( "î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "Î" , "i" ,  $ile_encours );
				$ile_encours=str_replace ( "è" , "e" ,  $ile_encours );
				$ile_encours=str_replace ( "à" , "a" ,  $ile_encours );
				$ile_encours=str_replace ( "ç" , "c" ,  $ile_encours );
				$ile_encours=str_replace ( "'" , "" ,  $ile_encours );
				$region_encours=str_replace ( "é" , "e" ,  $region_encours );
				$region_encours=str_replace ( "ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "Ô" , "o" ,  $region_encours );
				$region_encours=str_replace ( "î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "Î" , "i" ,  $region_encours );
				$region_encours=str_replace ( "è" , "e" ,  $region_encours );
				$region_encours=str_replace ( "à" , "a" ,  $region_encours );
				$region_encours=str_replace ( "ç" , "c" ,  $region_encours );
				$region_encours=str_replace ( "'" , "" ,  $region_encours );		
				$commune_encours=str_replace ( "é" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "Ô" , "o" ,  $commune_encours );
				$commune_encours=str_replace ( "î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "Î" , "i" ,  $commune_encours );
				$commune_encours=str_replace ( "è" , "e" ,  $commune_encours );
				$commune_encours=str_replace ( "à" , "a" ,  $commune_encours );
				$commune_encours=str_replace ( "ç" , "c" ,  $commune_encours );
				$commune_encours=str_replace ( "'" , "" ,  $commune_encours );
				$village_encours=str_replace ( "é" , "e" ,  $village_encours );
				$village_encours=str_replace ( "ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "Ô" , "o" ,  $village_encours );
				$village_encours=str_replace ( "î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "Î" , "i" ,  $village_encours );
				$village_encours=str_replace ( "è" , "e" ,  $village_encours );
				$village_encours=str_replace ( "à" , "a" ,  $village_encours );
				$village_encours=str_replace ( "ç" , "c" ,  $village_encours );
				$village_encours=str_replace ( "'" , "" ,  $village_encours );
				$village_encours=strtolower ($village_encours );
				$fichier4="NON";
				$Filename4 ="";
				if($premier==1) {
					$Filename4 = "Etat de paiement INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." edition ".$date_edition.".xlsx";
					// $Filename4 = "Etat de paiement INAPTE ".$village_encours." ".$nom_ile." ".$microprojet." ".$nom_agex." du ".$datedu_nomfichier." au ".$datefin_nomfichier." edition ".$date_edition.".xlsx";
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save($directoryName2.$Filename4);
					$fichier4="OK";
				}	  
			}	
			// FIN MENAGE INAPTE
			//ETAT DE RETOUR
		}		
				$this->response([
					'status' => TRUE,
					'retour' =>	     "OK",
					'ile' =>	     $ile_encours,
					'region' =>	     $region_encours,
					'commune' =>	 $commune_encours,
					'village' =>	 $village_encours,
					'nom_ile' =>	 $nom_ile,
					'microprojet' => $microprojet,
					'nom_agex' =>	 $nom_agex,
					'date_edition'=> $date_edition,	
					'fichier1' => $fichier1,
					'fichier2' => $fichier2,
					'fichier3' => $fichier3,
					'fichier4' => $fichier4,
					'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
					'name_file1' => $Filename1,
					'name_file2' => $Filename2,
					'name_file3' => $Filename3,
					'name_file4' => $Filename4,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);			  
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////:
	public function exportcartebeneficiaire($apiUrlbase,$menages,$ile,$region,$commune,$village,$zone_id,$zip,$code_zip,$microprojet,$ile_id,$region_id,$commune_id,$village_id) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$nomdefichierapte="";		
		$nomdefichierinapte="";		
		$filtreile = $ile;
		$filtreregion = $region;
		$filtrecommune = $commune;
		$filtrevillage = $village;
		$filtrezone = $code_zip;
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
			$ile_tmp = $ile;
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
			
			$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			if(!is_dir($directoryName)) {
				mkdir($directoryName, 0777,true);
			}
		
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Carte bénéficiaire")
								 ->setSubject("Carte bénéficiaire")
								 ->setDescription("Carte bénéficiaire")
								 ->setKeywords("Carte bénéficiaire")
								 ->setCategory("Carte bénéficiaire");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Carte bénéficiaire');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(1);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A5);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);			
		if(isset($menages)) {	
			$i=1;
			$premier=0;
			foreach ($menages as $ii => $d) {
				if(intval($d->inapte)==0) {
					$menage=$d->NumeroEnregistrement;
					$identifiant_menage=$d->identifiant_menage;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$phototravailleur=$d->phototravailleur;
					$pos_jpg_trav =0;		
					$pos_jpg_trav =strpos($phototravailleur,".jpg");		
					$phototravailleursuppliant=$d->phototravailleursuppliant;
					$pos_jpg_supp =0;		
					$pos_jpg_supp =strpos($phototravailleursuppliant,".jpg");		
					if($premier==0) {
						$ile_encours = $ile;
						$region_encours = $region;
						$commune_encours = $commune;
						$village_encours = $village;
						$ile_encours=strtolower ($ile_encours);
						$ile_encours=str_replace ('é','e',$ile_encours);
						$ile_encours=str_replace ('ô','o',$ile_encours);
						$ile_encours=str_replace ('î','i',$ile_encours);
						$ile_encours=str_replace ('è','e',$ile_encours);
						$ile_encours=str_replace ('à','a',$ile_encours);
						$ile_encours=str_replace ('ç','c',$ile_encours);
						$region_encours=strtolower ($region_encours );		
						$region_encours=str_replace ('é','e',$region_encours);
						$region_encours=str_replace ('ô','o',$region_encours);
						$region_encours=str_replace ('î','i',$region_encours);
						$region_encours=str_replace ('è','e',$region_encours);
						$region_encours=str_replace ('à','a',$region_encours);
						$region_encours=str_replace ('ç','c',$region_encours);
						$commune_encours=strtolower ($commune_encours );
						$commune_encours=str_replace ('é','e',$commune_encours);
						$commune_encours=str_replace ('ô','o',$commune_encours);
						$commune_encours=str_replace ('î','i',$commune_encours);
						$commune_encours=str_replace ('è','e',$commune_encours);
						$commune_encours=str_replace ('à','a',$commune_encours);
						$commune_encours=str_replace ('ç','c',$commune_encours);
						$village_encours=strtolower ($village_encours);
						$village_encours=str_replace ('é','e',$village_encours);
						$village_encours=str_replace ('ô','o',$village_encours);
						$village_encours=str_replace ('î','i',$village_encours);
						$village_encours=str_replace ('è','e',$village_encours);
						$village_encours=str_replace ('à','a',$village_encours);
						$village_encours=str_replace ('ç','c',$village_encours);
						if($filtreile >"") {
							$ile_encours=strtolower($filtreile);
						}
						if($filtreregion >"") {
							$region_encours=strtolower($filtreregion);
						}
						if($filtrecommune >"") {
							$commune_encours=strtolower($filtrecommune);
						}
						if($filtrevillage >"") {
							$village_encours=strtolower($filtrevillage);
						}
						$premier=1;
					}
					if($phototravailleur>"") {	
						$phototravailleur=dirname(__FILE__) . "/../../../../".$phototravailleur;
					}
					if($phototravailleursuppliant>"") {
						$phototravailleursuppliant=dirname(__FILE__) . "/../../../../".$phototravailleursuppliant;
					}
					for($j=1;$j<=2;$j++) {
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':AB'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'PROJET DE FILETS SOCIAUX DE SECURITE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':AB'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'CARTE DE BENEFICIAIRE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':AB'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° D'INSCRIPTION DU MENAGE:");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$i, "(doit être le même que celui du cahier d'enregistrement)");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFont()->setName('calibri')->setSize(8);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
						// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, $menage);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K" . $i,isset($identifiant_menage) ? $identifiant_menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Adresse");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':X'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $Addresse);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "Quartier");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Village");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':X'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $village);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$i, $zip);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "ZIP");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$i=$i + 2;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "INFORMATIONS SUR LE CHEF DE MENAGE");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':T'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':V'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Homme");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "Femme");
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Nom et prénoms");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);				
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':Q'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, $nomchefmenage);
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i.':U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('S'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('U'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						if($SexeChefMenage=="M") {
							$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
						} else if($SexeChefMenage=="F") {
							$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
						}
						$objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':AC'.($i + 6));
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i.':AC'.($i + 6))->applyFromArray($styleArray);
						unset($styleArray);							
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i .':AC'.($i + 6))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i .':AC'.($i + 6))->getFill()->getStartColor()->setRGB('CCCCCC');
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "PHOTO DE LA PERSONNE QUI VA PERCEVOIR LES FONDS");
						if ($j==1 && $phototravailleur>"" && $pos_jpg_trav >0) {
							if(file_exists($phototravailleur)) {
								$gdImage = imagecreatefromjpeg($phototravailleur);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur principal');
								$objDrawing->setDescription('Travailleur principal');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								// $objDrawing->setWidth(125)->setHeight(125);
								$objDrawing->setCoordinates('W'.$i);
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						if ($j==2 && $phototravailleursuppliant>"" && $pos_jpg_supp >0) {
							if(file_exists($phototravailleursuppliant)) {
								$gdImage = imagecreatefromjpeg($phototravailleursuppliant);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur suppliant');
								$objDrawing->setDescription('Travailleur suppliant');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								$objDrawing->setCoordinates('W'.$i);
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "REPRESENTANT POUR MENAGE INAPTE");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "TRAVAILLEUR PRINCIPAL");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(12);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, "X");
						}	
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFont()->setBold(true);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		

						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "TRAVAILLEUR SUPPLEANT");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(12);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==2) {
							$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, "X");
						}	
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Nom et prénoms");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':S'.$i);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $NomTravailleur);
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $NomTravailleurSuppliant);
						}	
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleArray);				
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "Age");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Date de naissance (mm aaaa)");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Homme");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "Femme");
						$i=$i + 1;
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $agetravailleur);
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $agesuppliant);
						}	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':L'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $moistravailleur);				
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $anneetravailleur);				
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $moissuppliant);				
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $anneesuppliant);				
						}	
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('C'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'. $i.':H'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('I'. $i.':L'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('S'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('U'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i.':U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==1) {
							if($SexeTravailleur=="M") {
								$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
							} else if($SexeTravailleur=="F") {
								$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
							}
						}	else {
							if($SexeTravailleurSuppliant=="M") {
								$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
							} else if($SexeTravailleurSuppliant=="F") {
								$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
							}
						}	
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° NIN");				
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':P'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocintravailleur);				
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocinsuppliant);				
						}	
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° Carte éléctorale");				
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':P'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocarteelectoraletravailleur);				
						} else {	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocarteelectoralesuppliant);				
						}	
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Autres pièces");				
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':M'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':AC'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AB'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AB'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Signature ou empreintes de la personne qui perçoit");				
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Signature ou empreintes du chef de menage");				
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(10);
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':AC'.($i + 2));
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AC'.($i + 2))->applyFromArray($styleArray);
						unset($styleArray);	
						// Saut de page AUTO
						$objPHPExcel->getActiveSheet()->setBreak('A'.($i + 5), PHPExcel_Worksheet::BREAK_ROW);
						$i=$i + 6;
					}
				}	
			}			
		}			
		$ile_encours=strtolower ($ile_encours);
		$ile_encours=str_replace ('é','e',$ile_encours);
		$ile_encours=str_replace ('ô','o',$ile_encours);
		$ile_encours=str_replace ('î','i',$ile_encours);
		$ile_encours=str_replace ('è','e',$ile_encours);
		$ile_encours=str_replace ('à','a',$ile_encours);
		$ile_encours=str_replace ('ç','c',$ile_encours);
		$region_encours=strtolower ($region_encours );		
		$region_encours=str_replace ('é','e',$region_encours);
		$region_encours=str_replace ('ô','o',$region_encours);
		$region_encours=str_replace ('î','i',$region_encours);
		$region_encours=str_replace ('è','e',$region_encours);
		$region_encours=str_replace ('à','a',$region_encours);
		$region_encours=str_replace ('ç','c',$region_encours);
		$commune_encours=strtolower ($commune_encours );
		$commune_encours=str_replace ('é','e',$commune_encours);
		$commune_encours=str_replace ('ô','o',$commune_encours);
		$commune_encours=str_replace ('î','i',$commune_encours);
		$commune_encours=str_replace ('è','e',$commune_encours);
		$commune_encours=str_replace ('à','a',$commune_encours);
		$commune_encours=str_replace ('ç','c',$commune_encours);
		$village_encours=strtolower ($village_encours);
		$village_encours=str_replace ('é','e',$village_encours);
		$village_encours=str_replace ('ô','o',$village_encours);
		$village_encours=str_replace ('î','i',$village_encours);
		$village_encours=str_replace ('è','e',$village_encours);
		$village_encours=str_replace ('à','a',$village_encours);
		$village_encours=str_replace ('ç','c',$village_encours);
		if($filtreile >"") {
			$ile_encours=strtolower($filtreile);
		}
		if($filtreregion >"") {
			$region_encours=strtolower($filtreregion);
		}
		if($filtrecommune >"") {
			$commune_encours=strtolower($filtrecommune);
		}
		if($filtrevillage >"") {
			$village_encours=strtolower($filtrevillage);
		}
		$date_edition = date("d-m-Y");		
		$fichier1="NON";
		$Filename1 ="";
		if($premier==1) {
			$Filename1 = "Carte beneficiaire "." village " .$village_encours." edition du ".$date_edition.".xlsx";
			//Check if the directory already exists.
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($directoryName.$Filename1);
			$fichier1="OK";	
			// unset($objPHPExcel);	
		}		
		// CARTE INAPTE
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Carte bénéficiaire menage inapte")
								 ->setSubject("Carte bénéficiaire menage inapte")
								 ->setDescription("Carte bénéficiaire menage inapte")
								 ->setKeywords("Carte bénéficiaire menage inapte")
								 ->setCategory("Carte bénéficiaire menage inapte");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Carte bénéficiaire menage inapte');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(1);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(5, 8);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(90);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A5);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);			
		if(isset($menages)) {	
			$i=1;
			$premier=0;
			$existe_menage_inapte=0;
			foreach ($menages as $ii => $d)	{
				if(intval($d->inapte)>0) {
					$menage=$d->NumeroEnregistrement;
					$identifiant_menage=$d->identifiant_menage;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$photo=$d->photo;		
					$pos_jpg=strpos($photo,".jpg");						
					$phototravailleur=$d->phototravailleur;				
					$phototravailleursuppliant=$d->phototravailleursuppliant;
					if($premier==0) {
						$existe_menage_inapte=1;
						$ile_encours = $ile;
						$region_encours = $region;
						$commune_encours = $commune;
						$village_encours = $village;
						$ile_encours=strtolower ($ile_encours);
						$ile_encours=str_replace ('é','e',$ile_encours);
						$ile_encours=str_replace ('ô','o',$ile_encours);
						$ile_encours=str_replace ('î','i',$ile_encours);
						$ile_encours=str_replace ('è','e',$ile_encours);
						$ile_encours=str_replace ('à','a',$ile_encours);
						$ile_encours=str_replace ('ç','c',$ile_encours);
						$region_encours=strtolower ($region_encours );		
						$region_encours=str_replace ('é','e',$region_encours);
						$region_encours=str_replace ('ô','o',$region_encours);
						$region_encours=str_replace ('î','i',$region_encours);
						$region_encours=str_replace ('è','e',$region_encours);
						$region_encours=str_replace ('à','a',$region_encours);
						$region_encours=str_replace ('ç','c',$region_encours);
						$commune_encours=strtolower ($commune_encours );
						$commune_encours=str_replace ('é','e',$commune_encours);
						$commune_encours=str_replace ('ô','o',$commune_encours);
						$commune_encours=str_replace ('î','i',$commune_encours);
						$commune_encours=str_replace ('è','e',$commune_encours);
						$commune_encours=str_replace ('à','a',$commune_encours);
						$commune_encours=str_replace ('ç','c',$commune_encours);
						$village_encours=strtolower ($village_encours);
						$village_encours=str_replace ('é','e',$village_encours);
						$village_encours=str_replace ('ô','o',$village_encours);
						$village_encours=str_replace ('î','i',$village_encours);
						$village_encours=str_replace ('è','e',$village_encours);
						$village_encours=str_replace ('à','a',$village_encours);
						$village_encours=str_replace ('ç','c',$village_encours);
						if($filtreile >"") {
							$ile_encours=strtolower($filtreile);
						}
						if($filtreregion >"") {
							$region_encours=strtolower($filtreregion);
						}
						if($filtrecommune >"") {
							$commune_encours=strtolower($filtrecommune);
						}
						if($filtrevillage >"") {
							$village_encours=strtolower($filtrevillage);
						}
						$premier=1;
					}
					if($photo>"") {	
						$photo=dirname(__FILE__) . "/../../../../".$photo;
					}
					if($phototravailleur>"") {		
						$phototravailleur=dirname(__FILE__) . "/../../../../".$phototravailleur;
					}
					if($phototravailleursuppliant>"") {
						$phototravailleursuppliant=dirname(__FILE__) . "/../../../../".$phototravailleursuppliant;
					}
					for($j=1;$j<=1;$j++) {
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':AB'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'PROJET DE FILETS SOCIAUX DE SECURITE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':AB'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'CARTE DE BENEFICIAIRE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':P'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':AB'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° D'INSCRIPTION DU MENAGE:");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$i, "(doit être le même que celui du cahier d'enregistrement)");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFont()->setName('calibri')->setSize(8);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
						// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, $menage);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K" . $i,isset($identifiant_menage) ? $identifiant_menage : "", PHPExcel_Cell_DataType::TYPE_STRING);			
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Adresse");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':X'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $Addresse);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "Quartier");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Village");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->mergeCells('E'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('Q'.$i.':X'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $village);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$i, $zip);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "ZIP");
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$i=$i + 2;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "INFORMATIONS SUR LE CHEF DE MENAGE");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':T'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('U'.$i.':V'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Homme");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "Femme");
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Nom et prénoms");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);				
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':Q'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, $nomchefmenage);
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($styleArray);
						unset($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i.':U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('S'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('U'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						if($SexeChefMenage=="M") {
							$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
						} else if($SexeChefMenage=="F") {
							$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
						}
						$objPHPExcel->getActiveSheet()->mergeCells('W'.$i.':AC'.($i + 6));
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i.':AC'.($i + 6))->applyFromArray($styleArray);
						unset($styleArray);							
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i .':AC'.($i + 6))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i .':AC'.($i + 6))->getFill()->getStartColor()->setRGB('CCCCCC');
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setWrapText(true);			
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "PHOTO DE LA PERSONNE QUI VA PERCEVOIR LES FONDS");
						if ($j==1 && $photo>"" && $pos_jpg >0) {
							if(file_exists($photo)) {
								$gdImage = imagecreatefromjpeg($photo);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Chef menage');
								$objDrawing->setDescription('Chef menage');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								$objDrawing->setCoordinates('W'.$i);
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						if ($j==2 && $phototravailleursuppliant>"") {
							if(file_exists($phototravailleursuppliant)) {
								$gdImage = imagecreatefromjpeg($phototravailleursuppliant);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Sample image');
								$objDrawing->setDescription('Sample image');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								$objDrawing->setCoordinates('W'.$i);
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "REPRESENTANT POUR MENAGE INAPTE");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, "X");
						}	
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFont()->setBold(true);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "TRAVAILLEUR PRINCIPAL");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(12);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "TRAVAILLEUR SUPPLEANT");
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(12);				
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==2) {
							$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFont()->setBold(true);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$i, "X");
						}	
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('N'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Nom et prénoms");
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':S'.$i);
						$styleArray = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleArray);				
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setName('calibri')->setSize(9);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, "Age");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Date de naissance (mm aaaa)");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Homme");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "Femme");
						$i=$i + 1;
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $agetravailleur);
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $agesuppliant);
						}	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':L'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $moistravailleur);				
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $anneetravailleur);				
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $moissuppliant);				
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $anneesuppliant);				
						}	
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('C'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'. $i.':H'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('I'. $i.':L'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('S'. $i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('U'. $i)->applyFromArray($styleArray);
						unset($styleArray);		
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i.':U'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($j==1) {
							if($SexeTravailleur=="M") {
								$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
							} else if($SexeTravailleur=="F") {
								$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
							}
						}	else {
							if($SexeTravailleurSuppliant=="M") {
								$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "X");
							} else if($SexeTravailleurSuppliant=="F") {
								$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFont()->setBold(true);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$i, "X");
							}
						}	
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° NIN");				
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':P'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocintravailleur);				
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocinsuppliant);				
						}	
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 1;
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "N° Carte éléctorale");				
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':P'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);
						if($j==1) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocarteelectoraletravailleur);				
						} else {	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $numerocarteelectoralesuppliant);				
						}	
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':P'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Autres pièces");				
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':M'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('S'.$i.':AC'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AB'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AB'.$i)->getFont()->setName('calibri')->setSize(11);				
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, "Signature ou empreintes de la personne qui perçoit");				
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$i, "Signature ou empreintes du chef de menage");				
						$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFont()->setName('calibri')->setSize(10);
						$i=$i + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('B'.$i.':AC'.($i + 2));
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':AC'.($i + 2))->applyFromArray($styleArray);
						unset($styleArray);	
						// Saut de page AUTO
						$objPHPExcel->getActiveSheet()->setBreak('A'.($i + 5), PHPExcel_Worksheet::BREAK_ROW);
						$i=$i + 6;
					}
				}	
			}			
		}			
		$ile_encours=strtolower ($ile_encours);
		$ile_encours=str_replace ('é','e',$ile_encours);
		$ile_encours=str_replace ('ô','o',$ile_encours);
		$ile_encours=str_replace ('î','i',$ile_encours);
		$ile_encours=str_replace ('è','e',$ile_encours);
		$ile_encours=str_replace ('à','a',$ile_encours);
		$ile_encours=str_replace ('ç','c',$ile_encours);
		$region_encours=strtolower ($region_encours );		
		$region_encours=str_replace ('é','e',$region_encours);
		$region_encours=str_replace ('ô','o',$region_encours);
		$region_encours=str_replace ('î','i',$region_encours);
		$region_encours=str_replace ('è','e',$region_encours);
		$region_encours=str_replace ('à','a',$region_encours);
		$region_encours=str_replace ('ç','c',$region_encours);
		$commune_encours=strtolower ($commune_encours );
		$commune_encours=str_replace ('é','e',$commune_encours);
		$commune_encours=str_replace ('ô','o',$commune_encours);
		$commune_encours=str_replace ('î','i',$commune_encours);
		$commune_encours=str_replace ('è','e',$commune_encours);
		$commune_encours=str_replace ('à','a',$commune_encours);
		$commune_encours=str_replace ('ç','c',$commune_encours);
		$village_encours=strtolower ($village_encours);
		$village_encours=str_replace ('é','e',$village_encours);
		$village_encours=str_replace ('ô','o',$village_encours);
		$village_encours=str_replace ('î','i',$village_encours);
		$village_encours=str_replace ('è','e',$village_encours);
		$village_encours=str_replace ('à','a',$village_encours);
		$village_encours=str_replace ('ç','c',$village_encours);
		if($filtreile >"") {
			$ile_encours=strtolower($filtreile);
		}
		if($filtreregion >"") {
			$region_encours=strtolower($filtreregion);
		}
		if($filtrecommune >"") {
			$commune_encours=strtolower($filtrecommune);
		}
		if($filtrevillage >"") {
			$village_encours=strtolower($filtrevillage);
		}
		$date_edition = date("d-m-Y");	
		$fichier2="NON";
		$Filename2 ="";
		if($premier==1) {
			$Filename2 ="Carte beneficiaire "."village " .$village_encours." edition du ".$date_edition." (MENAGE INAPTE)".".xlsx";
			//Check if the directory already exists.
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($directoryName.$Filename2);
			$fichier2="OK";				
		}		
				$this->response([
					'status' => TRUE,
					'retour' =>	     "OK",
					'ile' =>	     $ile_encours,
					'region' =>	     $region_encours,
					'commune' =>	 $commune_encours,
					'village' =>	 $village_encours,
					'nom_ile' =>	 $ile,
					'microprojet' => $microprojet,
					'date_edition'=> $date_edition,	
					'fichier1' => $fichier1,
					'fichier2' => $fichier2,
					'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
					'name_file1' => $Filename1,
					'name_file2' => $Filename2,
					'message' => 'Get file success',
				], REST_Controller::HTTP_OK);		
	}	
	// 'style' => PHPExcel_Style_Border::BORDER_DASHDOT,

	public function exportcartebeneficiaireARSE($apiUrlbase,$menages,$ile,$region,$commune,$village,$zone_id,$zip,$code_zip,$microprojet,$ile_id,$region_id,$commune_id,$village_id,$id_zip) {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$ile_original = $ile;
		$region_original = $region;
		$commune_original = $commune;
		$village_original = $village;
		$ile_tmp = $ile;
		$region_tmp = $region;
		$commune_tmp=$commune;		
		$village_tmp=$village;	
		$ile_tmp=str_replace ($search,$replace,$ile_tmp );
		$region_tmp=str_replace ($search,$replace,$region_tmp );
		$commune_tmp=str_replace ($search,$replace,$commune_tmp );
		$village_tmp=str_replace ($search,$replace,$village_tmp );	
		
		$nomdefichierapte="";		
		$nomdefichierinapte="";		
		$filtreile = $ile;
		$filtreregion = $region;
		$filtrecommune = $commune;
		$filtrevillage = $village;
		$filtrezone = $code_zip;
		if($filtreile >"") {
			$ile_encours=strtolower($filtreile);
		}
		if($filtreregion >"") {
			$region_encours=strtolower($filtreregion);
		}
		if($filtrecommune >"") {
			$commune_encours=strtolower($filtrecommune);
		}
		if($filtrevillage >"") {
			$village_encours=strtolower($filtrevillage);
		}
		$village_encours=str_replace ($search,$replace,$village_encours);
			$ile_tmp = strtolower($ile_tmp);
			$region_tmp = strtolower($region_tmp);
			$commune_tmp = strtolower($commune_tmp);
			$village_tmp = strtolower($village_tmp);
			
			$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			if(!is_dir($directoryName)) {
				mkdir($directoryName, 0777,true);
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Carte bénéficiaire ARSE")
								 ->setSubject("Carte bénéficiaire ARSE")
								 ->setDescription("Carte bénéficiaire ARSE")
								 ->setKeywords("Carte bénéficiaire ARSE")
								 ->setCategory("Carte bénéficiaire ARSE");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Carte bénéficiaire');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);	
		$sans_menage=0; // au cas où il n'y a pas de bénéficiaire	
		if(isset($menages)) {	
			$i=1;
			$premier=0;			
			foreach ($menages as $ii => $d) {
				if(intval($d->inapte)==0) {					
					$id_menage=$d->id;
					$menage=$d->NumeroEnregistrement;
					$identifiant_menage=$d->identifiant_menage;
					$NumeroEnregistrement=$d->NumeroEnregistrement;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$zip=$id_zip;
					$phototravailleur=$d->phototravailleur;
					$pos_jpg_trav =0;		
					$pos_jpg_trav =strpos($phototravailleur,".jpg");		
					$phototravailleursuppliant=$d->phototravailleursuppliant;
					$pos_jpg_supp =0;		
					$pos_jpg_supp =strpos($phototravailleursuppliant,".jpg");		
					if($premier==0) {
						$ile_encours = $ile;
						$region_encours = $region;
						$commune_encours = $commune;
						$ile_encours=strtolower ($ile_encours);
						$ile_encours=str_replace ($search,$replace,$ile_encours);
						$region_encours=strtolower ($region_encours );		
						$region_encours=str_replace ($search,$replace,$region_encours);
						$commune_encours=strtolower ($commune_encours );
						$commune_encours=str_replace ($search,$replace,$commune_encours);
						$premier=1;
					}
					if($phototravailleur>"") {	
						$phototravailleur=dirname(__FILE__) . "/../../../../".$phototravailleur;
					}
					if($phototravailleursuppliant>"") {
						$phototravailleursuppliant=dirname(__FILE__) . "/../../../../".$phototravailleursuppliant;
					}
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.($i + 2));
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'CARTE DES BENEFICIAIRES ARSE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(14);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$logo_arse = dirname(__FILE__) . "/../../../../app/src/".'logo_arse.png';
						if(file_exists($logo_arse)) {
							$gdImage = imagecreatefrompng($logo_arse);
							// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
							$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
							$objDrawing->setName('Logo carte bénéficiaire');
							$objDrawing->setDescription('Logo carte bénéficiaire');
							$objDrawing->setImageResource($gdImage);
							$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
							$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
							// $objDrawing->setWidth(125)->setHeight(125);
							$objDrawing->setCoordinates('J'.$i);
							$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						}	
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'PROJET MAYENDELEYO');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						// Light Blue
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0033FF'),
									 'endcolor'   => array('argb' => '0033FF')
								 )
						 );							
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);						
						$i=$i + 1 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(23);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'PROJET DE FILETS SOCIAUX DE SECURITE');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(10);
						// Light Blue
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0033FF'),
									 'endcolor'   => array('argb' => '0033FF')
								 )
						 );							
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);						
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'CARTE DES BENEFICIAIRES');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);	
						$objPHPExcel->getActiveSheet()->mergeCells('B'.($i+5).':F'.($i + 16));
						$logo_carte_beneficiaire_arse = dirname(__FILE__) . "/../../../../app/src/".'logo_carte_beneficiaire_arse.jpg';
						if(file_exists($logo_carte_beneficiaire_arse)) {
							$gdImage = imagecreatefromjpeg($logo_carte_beneficiaire_arse);
							// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
							$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
							$objDrawing->setName('Logo carte bénéficiaire');
							$objDrawing->setDescription('Logo carte bénéficiaire');
							$objDrawing->setImageResource($gdImage);
							$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
							$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
							// $objDrawing->setWidth(125)->setHeight(125);
							$objDrawing->setCoordinates('B'.$i);
							$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						}						
						$objPHPExcel->getActiveSheet()->mergeCells('G'.($i - 5).':I'.($i + 1));
						$objPHPExcel->getActiveSheet()->mergeCells('L'.($i - 5).':N'.($i + 1));
						if ( $phototravailleur>"" && $pos_jpg_trav >0) {
							if(file_exists($phototravailleur)) {
								$gdImage = imagecreatefromjpeg($phototravailleur);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur principal');
								$objDrawing->setDescription('Travailleur principal');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								// $objDrawing->setWidth(125)->setHeight(125);
								$objDrawing->setCoordinates('G'.($i - 5));
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.($i - 5))->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						if ($phototravailleursuppliant>"" && $pos_jpg_supp >0) {
							if(file_exists($phototravailleursuppliant)) {
								$gdImage = imagecreatefromjpeg($phototravailleursuppliant);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur suppliant');
								$objDrawing->setDescription('Travailleur suppliant');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								$objDrawing->setCoordinates('L'.($i - 5));
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.($i - 5))->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						$i=$i+3;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "CODE MENAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$identifiant_menage, PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "CHEF DE MENAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($nomchefmenage) ? $nomchefmenage : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "RECEPTEUR PRINCIPAL ");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($NomTravailleur) ? $NomTravailleur : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						// $objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "STATUT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);	
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,"Apte", PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':H'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "NIN");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$NumeroCIN, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':J'.$i)->getFont()->setItalic(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "DATE DE NAISSANCE");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("M" . $i,$moistravailleur."/".$anneetravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':M'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Ou CARTE ELECTORALE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$numerocarteelectoraletravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':J'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "REMPLACANT");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($NomTravailleurSuppliant) ? $NomTravailleurSuppliant : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "STATUT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,"Apte", PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':H'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "NIN");
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "DATE DE NAISSANCE");
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Ou CARTE ELECTORALE");
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "ADRESSE RESPECTIF");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$Addresse, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "ILE DE");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':J'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,$ile_original, PHPExcel_Cell_DataType::TYPE_STRING);
						
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "PREFECTURE");
						$objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("L" . $i,$region_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "COMMUNE");
						$objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i.':K'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("I" . $i,$commune_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "ZIP");
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':M'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("M" . $i,$zip, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "LOT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "VILLAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K" . $i,$village_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "DATE DE SIGNATURE DU CONTRAT :");
						$i=$i + 1 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'SIGNATURES');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(13);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);	
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 1).':G'.($i + 3))->getBorders()->getLeft()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 1).':J'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('N'.($i + 1).':N'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);																								
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'Récepteur');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, 'Remplaçant');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':J'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 1).':G'.($i + 3))->getBorders()->getLeft()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 1).':J'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('N'.($i + 1).':N'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);																								
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setItalic(true);						
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'Représentant du Comité de Protection Sociale');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, 'Directeur Régional');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':J'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setItalic(true);						
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 2 ;	
						// $objPHPExcel->getActiveSheet()->setBreak('A'.($i), PHPExcel_Worksheet::BREAK_ROW); enlevé car crée page vide
						// DEUXIEME PAGE  
						$i=$i + 2 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'LISTE DES ENFANTS A CHARGE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'ETATS DE PAIEMENT DES FONDS DE RELEVEMENT');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('calibri')->setSize(14);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setWrapText(true);
						$i=$i + 2 ;	
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'N°');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'NOMS DES ENFANTS');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'SEXE (M/F)');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, 'DATE DE NAISSANCE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, 'AGE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, 'SCOLARISES (O/N)');
						// Blue
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0000FF'),
									 'endcolor'   => array('argb' => '0000FF')
								 )
						 );													
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($styleArray);
						
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':L'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':L'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, 'TRANCHE DE PAIEMENT');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'EMARGEMENTS BENEFICIAIRES');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$i, 'EMARGEMENTS ET CACHET AGENCE DE PAIEMENT');
						$styleUnderline = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						// TABLEAU A DROITE DEUXIEME PAGE
						$i = $i + 1;
						$k = $i;
						$l = $i; // $l : Pour lister les enfants à charge
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						// Bleu clair
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '33B8FF'),
									 'endcolor'   => array('argb' => '33B8FF')
								 )
						 );													
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'PREMIERE TRANCHE  10%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						// Bleu foncé
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '164F99'),
									 'endcolor'   => array('argb' => '164F99')
								 )
						 );							
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'DEUXIEME TRANCHE  70%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
								 )
						);						
						// Bleu
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 4))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0000FF'),
									 'endcolor'   => array('argb' => '0000FF')
								 )
						 );							
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'TROISIEME TRANCHE  20%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$i=$k;
						// Début Lister les enfants à charge
						$les_individus=$this->IndividuManager->findByMenage($id_menage);
						if($les_individus) {
							foreach($les_individus as $key=>$value) {
								$sexe="";
								if($value->sexe) {
									if(intval($value->sexe)==0) {
										$sexe="F";
									} else if(intval($value->sexe)==1){
										$sexe="M";
									}
								}
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':F'.$l)->applyFromArray($styleArray);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("A" . $l,($key + 1), PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("B" . $l,$value->nom, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("C" . $l,$sexe, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D" . $l,$value->date_naissance, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E" . $l,($value->age >0 ? $value->age : ''), PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("F" . $l,$value->scolarise, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':A'.$l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':A'.$l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$l.':F'.$l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$l.':F'.$l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$l=$l + 1;
							}
						}
						// Fin Lister les enfants à charge
						$objPHPExcel->getActiveSheet()->setBreak('A'.($i), PHPExcel_Worksheet::BREAK_ROW);
						$i=$i + 1; // C'EST UNE MISE EN PAGE SUIVANTE
				}	
			}	
			$date_edition = date("d-m-Y");		
			$fichier1="NON";
			$Filename1 ="";
			if($premier==1) {
				$Filename1 = "Carte beneficiaire "." village " .$village_tmp." edition du ".$date_edition.".xlsx";
				//Check if the directory already exists.
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName.$Filename1);
				$fichier1="OK";	
				// unset($objPHPExcel);	
			}		
			
		} else {
			// SANS ENREGISTREMENT
			$sans_menage=$sans_menage + 1;
		}			
		// CARTE INAPTE
		$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Carte bénéficiaire menage inapte")
								 ->setSubject("Carte bénéficiaire menage inapte")
								 ->setDescription("Carte bénéficiaire menage inapte")
								 ->setKeywords("Carte bénéficiaire menage inapte")
								 ->setCategory("Carte bénéficiaire menage inapte");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Carte bénéficiaire menage inapte');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);		
		if(isset($menages)) {	
			$i=1;
			$premier=0;
			$existe_menage_inapte=0;
			foreach ($menages as $ii => $d)	{
				if(intval($d->inapte)>0) {
					$id_menage=$d->id;
					$menage=$d->NumeroEnregistrement;
					$identifiant_menage=$d->identifiant_menage;
					$NumeroEnregistrement=$d->NumeroEnregistrement;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$zip=$id_zip;
					$photo=$d->photo;
					$pos_jpg_chef =0;		
					$pos_jpg_chef =strpos($photo,".jpg");		
					$phototravailleur=$d->phototravailleur;
					$pos_jpg_trav =0;		
					$pos_jpg_trav =strpos($phototravailleur,".jpg");		
					$phototravailleursuppliant=$d->phototravailleursuppliant;
					$pos_jpg_supp =0;		
					$pos_jpg_supp =strpos($phototravailleursuppliant,".jpg");		
					if($premier==0) {
						$ile_encours = $ile;
						$region_encours = $region;
						$commune_encours = $commune;
						$ile_encours=strtolower ($ile_encours);
						$ile_encours=str_replace ($search,$replace,$ile_encours);
						$region_encours=strtolower ($region_encours );		
						$region_encours=str_replace ($search,$replace,$region_encours);
						$commune_encours=strtolower ($commune_encours );
						$commune_encours=str_replace ($search,$replace,$commune_encours);
						$premier=1;
					}
					if($phototravailleur>"") {	
						$phototravailleur=dirname(__FILE__) . "/../../../../".$phototravailleur;
					}
					if($phototravailleursuppliant>"") {
						$phototravailleursuppliant=dirname(__FILE__) . "/../../../../".$phototravailleursuppliant;
					}
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.($i + 2));
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AB'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'CARTE DES BENEFICIAIRES ARSE');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setName('calibri')->setSize(14);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(true);
						$logo_arse = dirname(__FILE__) . "/../../../../app/src/".'logo_arse.png';
						if(file_exists($logo_arse)) {
							$gdImage = imagecreatefrompng($logo_arse);
							// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
							$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
							$objDrawing->setName('Logo carte bénéficiaire');
							$objDrawing->setDescription('Logo carte bénéficiaire');
							$objDrawing->setImageResource($gdImage);
							$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
							$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
							// $objDrawing->setWidth(125)->setHeight(125);
							$objDrawing->setCoordinates('J'.$i);
							$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						}	
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'PROJET MAYENDELEYO');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						// Light Blue
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0033FF'),
									 'endcolor'   => array('argb' => '0033FF')
								 )
						 );							
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);						
						$i=$i + 1 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(23);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'PROJET DE FILETS SOCIAUX DE SECURITE');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(10);
						// Light Blue
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0033FF'),
									 'endcolor'   => array('argb' => '0033FF')
								 )
						 );							
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);						
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':K'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'CARTE DES BENEFICIAIRES');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFont()->setBold(true);	
						$objPHPExcel->getActiveSheet()->mergeCells('B'.($i+5).':F'.($i + 16));
						$logo_carte_beneficiaire_arse = dirname(__FILE__) . "/../../../../app/src/".'logo_carte_beneficiaire_arse.jpg';
						if(file_exists($logo_carte_beneficiaire_arse)) {
							$gdImage = imagecreatefromjpeg($logo_carte_beneficiaire_arse);
							// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
							$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
							$objDrawing->setName('Logo carte bénéficiaire');
							$objDrawing->setDescription('Logo carte bénéficiaire');
							$objDrawing->setImageResource($gdImage);
							$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
							$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
							// $objDrawing->setWidth(125)->setHeight(125);
							$objDrawing->setCoordinates('B'.$i);
							$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
						}						
						$objPHPExcel->getActiveSheet()->mergeCells('G'.($i - 5).':I'.($i + 1));
						$objPHPExcel->getActiveSheet()->mergeCells('L'.($i - 5).':N'.($i + 1));
						if ( $phototravailleur>"" && $pos_jpg_trav >0) {
							if(file_exists($phototravailleur)) {
								$gdImage = imagecreatefromjpeg($phototravailleur);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur principal');
								$objDrawing->setDescription('Travailleur principal');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								// $objDrawing->setWidth(125)->setHeight(125);
								$objDrawing->setCoordinates('G'.($i - 5));
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('G'.($i - 5))->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						if ($phototravailleursuppliant>"" && $pos_jpg_supp >0) {
							if(file_exists($phototravailleursuppliant)) {
								$gdImage = imagecreatefromjpeg($phototravailleursuppliant);
								// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
								$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
								$objDrawing->setName('Travailleur suppliant');
								$objDrawing->setDescription('Travailleur suppliant');
								$objDrawing->setImageResource($gdImage);
								$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
								$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
								$objDrawing->setCoordinates('L'.($i - 5));
								$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
							} else {
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('L'.($i - 5))->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'FF0000'),
											 'endcolor'   => array('argb' => 'FF0000')
										 )
								 );		
								$objPHPExcel->setActiveSheetIndex(0)->getStyle('W'.$i)->applyFromArray(array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 11,
										'name'  => 'Verdana'
									))
								);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$i, "VERIFIER LA PRESENCE DU PHOTO DANS LE REPERTOIRE");
							}	
						}	
						$i=$i+3;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "CODE MENAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$identifiant_menage, PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':H'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "CHEF DE MENAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($nomchefmenage) ? $nomchefmenage : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "RECEPTEUR PRINCIPAL ");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($NomTravailleur) ? $NomTravailleur : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						// $objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "STATUT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);	
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,"Apte", PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':H'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "NIN");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$NumeroCIN, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':J'.$i)->getFont()->setItalic(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "DATE DE NAISSANCE");
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("M" . $i,$moistravailleur."/".$anneetravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':M'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Ou CARTE ELECTORALE");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$numerocarteelectoraletravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':J'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "REMPLACANT");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,isset($NomTravailleurSuppliant) ? $NomTravailleurSuppliant : "", PHPExcel_Cell_DataType::TYPE_STRING);	
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "STATUT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,"Apte", PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':H'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "NIN");
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "DATE DE NAISSANCE");
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "Ou CARTE ELECTORALE");
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "ADRESSE RESPECTIF");
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J" . $i,$Addresse, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':N'.$i)->getFont()->setItalic(true);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "ILE DE");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':J'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H" . $i,$ile_original, PHPExcel_Cell_DataType::TYPE_STRING);
						
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, "PREFECTURE");
						$objPHPExcel->getActiveSheet()->mergeCells('L'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("L" . $i,$region_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "COMMUNE");
						$objPHPExcel->getActiveSheet()->mergeCells('I'.$i.':K'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i.':K'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("I" . $i,$commune_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$i, "ZIP");
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':M'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("M" . $i,$zip, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "LOT");
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$i, "VILLAGE");
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->getFont()->setItalic(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K" . $i,$village_original, PHPExcel_Cell_DataType::TYPE_STRING);
						$i=$i+1;
						$styleArray = array(
						  'borders' => array(
							'allborders' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						  )
						);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(11);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);						
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, "DATE DE SIGNATURE DU CONTRAT :");
						$i=$i + 1 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'SIGNATURES');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setName('calibri')->setSize(13);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setBold(true);	
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 1).':G'.($i + 3))->getBorders()->getLeft()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 1).':J'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('N'.($i + 1).':N'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);																								
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'Récepteur');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, 'Remplaçant');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':J'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.($i + 1).':G'.($i + 3))->getBorders()->getLeft()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('J'.($i + 1).':J'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						$objPHPExcel->getActiveSheet()->getStyle('N'.($i + 1).':N'.($i + 3))->getBorders()->getRight()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);																								
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setItalic(true);						
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 4 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':J'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('K'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'Représentant du Comité de Protection Sociale');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$i, 'Directeur Régional');
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':J'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getFont()->setItalic(true);						
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$i=$i + 2 ;	
						// $objPHPExcel->getActiveSheet()->setBreak('A'.($i), PHPExcel_Worksheet::BREAK_ROW); enlevé car crée page vide
						// DEUXIEME PAGE  
						$i=$i + 2 ;	
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('G'.$i.':N'.$i);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'LISTE DES ENFANTS A CHARGE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, 'ETATS DE PAIEMENT DES FONDS DE RELEVEMENT');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('calibri')->setSize(14);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setWrapText(true);
						$i=$i + 2 ;	
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'N°');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'NOMS DES ENFANTS');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'SEXE (M/F)');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, 'DATE DE NAISSANCE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, 'AGE');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, 'SCOLARISES (O/N)');
						// Blue
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0000FF'),
									 'endcolor'   => array('argb' => '0000FF')
								 )
						 );													
						$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->applyFromArray($styleArray);
						
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$i.':L'.$i);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$i.':N'.$i);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$i.':L'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('M'.$i.':N'.$i)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$i.':N'.$i)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, 'TRANCHE DE PAIEMENT');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, 'EMARGEMENTS BENEFICIAIRES');
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$i, 'EMARGEMENTS ET CACHET AGENCE DE PAIEMENT');
						$styleUnderline = array(
						  'font' => array('underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE)
						);
						// TABLEAU A DROITE DEUXIEME PAGE
						$i = $i + 1;
						$k = $i;
						$l = $i; // $l : Pour lister les enfants à charge
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						// Bleu clair
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '33B8FF'),
									 'endcolor'   => array('argb' => '33B8FF')
								 )
						 );													
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'PREMIERE TRANCHE  10%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN
								 )
						);						
						// Bleu foncé
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '164F99'),
									 'endcolor'   => array('argb' => '164F99')
								 )
						 );							
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'DEUXIEME TRANCHE  70%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$objPHPExcel->getActiveSheet()->mergeCells('H'.$k.':I'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('M'.$k.':N'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('M'.$k.':N'.($k + 8))->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.($k + 8).':L'.($k + 8));
						$objPHPExcel->getActiveSheet()->getStyle('J'.($k + 8).':L'.($k + 8))->getBorders()->getBottom()->applyFromArray(
								 array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
								 )
						);						
						// Bleu
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.($k + 4))->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => '0000FF'),
									 'endcolor'   => array('argb' => '0000FF')
								 )
						 );							
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$k, 'TROISIEME TRANCHE  20%');
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setName('calibri')->setSize(12);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$objPHPExcel->getActiveSheet()->getStyle('H'.$k.':I'.$k)->getAlignment()->setWrapText(true);
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Date :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 1;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Montant reçu (KMF) : ');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 2;
						$objPHPExcel->getActiveSheet()->mergeCells('J'.$k.':L'.$k);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setName('calibri')->setSize(10);
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k.':L'.$k)->getFont()->setBold(true);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$k, 'Emargement du récepteur :');
						$objPHPExcel->getActiveSheet()->getStyle('J'.$k)->applyFromArray($styleUnderline);
						$k=$k + 6;
						$i=$k;
						// Début Lister les enfants à charge
						$les_individus=$this->IndividuManager->findByMenage($id_menage);
						if($les_individus) {
							foreach($les_individus as $key=>$value) {
								$sexe="";
								if($value->sexe) {
									if(intval($value->sexe)==0) {
										$sexe="F";
									} else if(intval($value->sexe)==1){
										$sexe="M";
									}
								}
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':F'.$l)->applyFromArray($styleArray);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("A" . $l,($key + 1), PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("B" . $l,$value->nom, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("C" . $l,$sexe, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D" . $l,$value->date_naissance, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E" . $l,($value->age >0 ? $value->age : ''), PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("F" . $l,$value->scolarise, PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':A'.$l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('A'.$l.':A'.$l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$l.':F'.$l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
								$objPHPExcel->getActiveSheet()->getStyle('C'.$l.':F'.$l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
								$l=$l + 1;
							}
						}
						// Fin Lister les enfants à charge
						$objPHPExcel->getActiveSheet()->setBreak('A'.($i), PHPExcel_Worksheet::BREAK_ROW);
						$i=$i + 1; // C'EST UNE MISE EN PAGE SUIVANTE
				}	
			}			
			$date_edition = date("d-m-Y");	
			$fichier2="NON";
			$Filename2 ="";
			if($premier==1) {
				$Filename2 ="Carte beneficiaire "."village " .$village_tmp." edition du ".$date_edition." (MENAGE INAPTE)".".xlsx";
				//Check if the directory already exists.
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($directoryName.$Filename2);
				$fichier2="OK";				
			}	
		} else {
			// SANS ENREGISTREMENT
			$sans_menage=$sans_menage + 1;
		}	
		if($sans_menage==2) {
			$this->response([
				'status' => FALSE,
				'retour' =>	     "NON",
				'ile' =>	     $ile,
				'region' =>	     $region,
				'commune' =>	 $commune,
				'village' =>	 $village,
				'nom_ile' =>	 $ile,
				'microprojet' => $microprojet,
				'date_edition'=> $date_edition,	
				'fichier1' => $fichier1,
				'fichier2' => $fichier2,
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'name_file1' => $Filename1,
				'name_file2' => $Filename2,
				'message' => 'Aucun ménage bénéficiaire pour le filtre choisi !. Merci',
			], REST_Controller::HTTP_OK);				
		} else {	
			$this->response([
				'status' => TRUE,
				'retour' =>	     "OK",
				'ile' =>	     $ile,
				'region' =>	     $region,
				'commune' =>	 $commune,
				'village' =>	 $village,
				'nom_ile' =>	 $ile,
				'microprojet' => $microprojet,
				'date_edition'=> $date_edition,	
				'fichier1' => $fichier1,
				'fichier2' => $fichier2,
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'name_file1' => $Filename1,
				'name_file2' => $Filename2,
				'menages' => $menages,
				'message' => 'Get file success',
			], REST_Controller::HTTP_OK);	
		}	
	}	
	public function exportficherecepteur($menages,$nom_ile,$region,$commune,$village,$nombre_menage_beneficiaire,$nombre_travailleur_homme,$nombre_travailleur_femme,$nombre_suppleant_homme,$nombre_suppleant_femme,$pourcentage,$montant_a_payer,$titre,$village_id,$numero_tranche,$nom_agep,$id_zip,$vague,$agep_id) {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$ile_original = $nom_ile;
		$region_original = $region;
		$commune_original = $commune;
		$village_original = $village;
		$ile_tmp = $nom_ile;
		$region_tmp = $region;
		$commune_tmp=$commune;		
		$village_tmp=$village;	
		$ile_tmp=str_replace ($search,$replace,$ile_tmp );
		$region_tmp=str_replace ($search,$replace,$region_tmp );
		$commune_tmp=str_replace ($search,$replace,$commune_tmp );
		$village_tmp=str_replace ($search,$replace,$village_tmp );	
		
			$ile_tmp = strtolower($ile_tmp);
			$region_tmp = strtolower($region_tmp);
			$commune_tmp = strtolower($commune_tmp);
			$village_tmp = strtolower($village_tmp);
			
			$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			if(!is_dir($directoryName)) {
				mkdir($directoryName, 0777,true);
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Fiche recepteur ARSE")
								 ->setSubject("Fiche recepteur ARSE")
								 ->setDescription("Fiche recepteur ARSE")
								 ->setKeywords("Fiche recepteur ARSE")
								 ->setCategory("Fiche recepteur ARSE");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Fiche recepteur');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(11);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(11);
			$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(11);
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);	
		$sans_menage=0; // au cas où il n'y a pas de bénéficiaire	
		$ligne=13;
		if(isset($menages)) {	
			$i=1;
			$premier=0;		
			$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');	
			$objPHPExcel->getActiveSheet()->mergeCells('A2:O2');	
			$objPHPExcel->getActiveSheet()->mergeCells('A3:O3');	
			$objPHPExcel->getActiveSheet()->mergeCells('A4:O4');	
			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'UNION DES COMORES');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Unité – Solidarité – Développement');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'LISTE DES RECEPTEURS PRINCIPAUX ET SUPPLEANTS DU PROJET FSS');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'IDENTIFICATION DE LA LOCALITE');
			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setName('calibri')->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D5:D7')->getFont()->setName('calibri')->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('J5:J7')->getFont()->setName('calibri')->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);						
			$logo1_fiche_arse = dirname(__FILE__) . "/../../../../app/src/".'logo1_fiche_arse.png';
			if(file_exists($logo1_fiche_arse)) {
				$gdImage = imagecreatefrompng($logo1_fiche_arse);
				// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo fiche recepteur ARSE');
				$objDrawing->setDescription('Logo fiche recepteur ARSE');
				$objDrawing->setImageResource($gdImage);
				$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
				// $objDrawing->setWidth(125)->setHeight(125);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}	
			$logo2_fiche_arse = dirname(__FILE__) . "/../../../../app/src/".'logo2_fiche_arse.png';
			if(file_exists($logo2_fiche_arse)) {
				$gdImage = imagecreatefrompng($logo2_fiche_arse);
				// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo fiche recepteur ARSE');
				$objDrawing->setDescription('Logo fiche recepteur ARSE');
				$objDrawing->setImageResource($gdImage);
				$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
				// $objDrawing->setWidth(125)->setHeight(125);
				$objDrawing->setCoordinates('O1');
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}	
			$styleArray = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			  )
			);
			$objPHPExcel->getActiveSheet()->mergeCells('A5:C5');	
			$objPHPExcel->getActiveSheet()->mergeCells('A6:C6');	
			$objPHPExcel->getActiveSheet()->mergeCells('A7:C7');	
			$objPHPExcel->getActiveSheet()->mergeCells('A8:C8');	
			$objPHPExcel->getActiveSheet()->mergeCells('A9:C9');	
			$objPHPExcel->getActiveSheet()->mergeCells('A10:C10');	
			$objPHPExcel->getActiveSheet()->mergeCells('H9:J9');	
			$objPHPExcel->getActiveSheet()->mergeCells('H10:J10');	
			$objPHPExcel->getActiveSheet()->getStyle('A5:C10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A5:A10')->getFont()->setName('calibri')->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('A5:A10')->getFont()->setBold(true);						
			$objPHPExcel->getActiveSheet()->getStyle('H5:H10')->getFont()->setName('calibri')->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('H5:H10')->getFont()->setBold(true);						
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', 'Ile :');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Commune :');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Point d'inscription :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Nombre de ménages bénéficiaires :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', "Nombre de recepteurs principaux Femmes :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "Nombre de recepteurs suppléants Femmes :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "Nombre de recepteurs principaux Hommes :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Nombre de recepteurs suppléants Hommes :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', "Lot :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6', "Village :");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', "Milieu");
			$objPHPExcel->getActiveSheet()->mergeCells('D11:I11');	
			$objPHPExcel->getActiveSheet()->mergeCells('D11:I11');	
			$objPHPExcel->getActiveSheet()->mergeCells('J11:O11');	
			$objPHPExcel->getActiveSheet()->mergeCells('J11:O11');	
			$objPHPExcel->getActiveSheet()->mergeCells('A11:A12');	
			$objPHPExcel->getActiveSheet()->mergeCells('B11:B12');	
			$objPHPExcel->getActiveSheet()->mergeCells('C11:C12');	
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A11', 'N°');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B11', 'Code ID ménage');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C11', 'Chef de ménage');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', 'Recepteur principal');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11', 'Recepteur suppléant');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', 'Nom et prénoms');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E12', 'Statut ou lien de parenté');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F12', 'Sexe  H/F');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G12', 'Date de Naissance');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H12', "N°Pièces d'identité");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I12', 'N°carte éléctorale');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J12', 'Nom et prénoms');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K12', 'Statut ou lien de parenté');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L12', 'Sexe  H/F');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M12', 'Date de Naissance');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N12', "N°Pièces d'identité");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O12', 'N°carte éléctorale');
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->getFont()->setName('calibri')->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->getFont()->setBold(true);						
			$objPHPExcel->getActiveSheet()->getStyle('A11:O12')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A5:O12')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('D8:D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('K8:K10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D8",$nombre_menage_beneficiaire, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D9",$nombre_travailleur_femme, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D10",$nombre_suppleant_femme, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K9",$nombre_travailleur_homme, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("K10",$nombre_suppleant_homme, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D5",$ile_original, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D6",$commune_original, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("J6",$village_original, PHPExcel_Cell_DataType::TYPE_STRING);
			foreach ($menages as $ii => $d) {
				// if(intval($d->inapte)==0) {					
					$identifiant_menage=$d->identifiant_menage;
					$menage=$d->NumeroEnregistrement;
					$NumeroEnregistrement=$d->NumeroEnregistrement;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($ligne)->setRowHeight(32);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':O'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, ($ii +1));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $identifiant_menage);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $nomchefmenage);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $NomTravailleur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $SexeTravailleur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $datedenaissancetravailleur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("H".$ligne,$numerocintravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("I".$ligne,$numerocarteelectoraletravailleur, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $NomTravailleurSuppliant);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $SexeTravailleurSuppliant);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $datedenaissancesuppliant);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("N".$ligne,$numerocinsuppliant, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("O".$ligne,$numerocarteelectoralesuppliant, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':B'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':B'.$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ligne.':O'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ligne.':I'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$ligne.':I'.$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('L'.$ligne.':O'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('L'.$ligne.':O'.$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':O'.$ligne)->applyFromArray($styleArray);
					 if ($ligne%2 == 0) {
						 // Ligne paire => colorée
						$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'D8D8C6'),
									 'endcolor'   => array('argb' => 'D8D8C6')
								 )
						 );							 
					 }	
						$i=$i + 1; // C'EST UNE MISE EN PAGE SUIVANTE
					$ligne=$ligne + 1;	
				// }	
				$fichier1="OK";	
				// unset($objPHPExcel);	
			}		
			
		} else {
			// SANS ENREGISTREMENT
			$sans_menage=$sans_menage + 1;
		}
			$fichier="NON";
			$date_edition = date("d-m-Y");	
		if($sans_menage=$sans_menage==0) {
			$Filename ="";
			$Filename ="fiche recepteur "."village " .$village_tmp.".xlsx";
			//Check if the directory already exists.
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($directoryName.$Filename);
			$fichier="OK";				
			
			$this->response([
				'status' => TRUE,
				'retour' =>	     "OK",
				'date_edition'=> $date_edition,	
				'fichier' => $fichier,
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'name_file' => $Filename,
				'menages' => $menages,
				'message' => 'Get file success',
			], REST_Controller::HTTP_OK);	
			
		} else {
			$this->response([
				'status' => FALSE,
				'retour' =>	     "OK",
				'date_edition'=> $date_edition,	
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'message' => 'Aucun ménage bénéficiaire pour le filtre seléctinné!.',
			], REST_Controller::HTTP_OK);	
			
		}
	}
	public function exportetatpaiementarse($menages,$nom_ile,$region,$commune,$village,$nombre_menage_beneficiaire,$nombre_travailleur_homme,$nombre_travailleur_femme,$nombre_suppleant_homme,$nombre_suppleant_femme,$pourcentage,$montant_a_payer,$titre,$village_id,$numero_tranche,$nom_agep,$id_zip,$vague,$agep_id) {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';
        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
		$search= array('é','ô','Ô','î','Î','è','ê','à','ö','ç','&','°',"'");
		$replace=array('e','o','o','i','i','e','e','a','o','c','_','_','');
		$ile_original = $nom_ile;
		$region_original = $region;
		$commune_original = $commune;
		$village_original = $village;
		$ile_tmp = $nom_ile;
		$region_tmp = $region;
		$commune_tmp=$commune;		
		$village_tmp=$village;	
		$ile_tmp=str_replace ($search,$replace,$ile_tmp );
		$region_tmp=str_replace ($search,$replace,$region_tmp );
		$commune_tmp=str_replace ($search,$replace,$commune_tmp );
		$village_tmp=str_replace ($search,$replace,$village_tmp );	
		
			$ile_tmp = strtolower($ile_tmp);
			$region_tmp = strtolower($region_tmp);
			$commune_tmp = strtolower($commune_tmp);
			$village_tmp = strtolower($village_tmp);
			
			$directoryName = dirname(__FILE__) . "/../../../../exportexcel/".$ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/";
			if(!is_dir($directoryName)) {
				mkdir($directoryName, 0777,true);
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("PFSS")
								 ->setLastModifiedBy("PFSS")
								 ->setTitle("Etat paiement ARSE")
								 ->setSubject("Etat paiement ARSE")
								 ->setDescription("Etat paiement ARSE")
								 ->setKeywords("Etat paiement ARSE")
								 ->setCategory("Etat paiement ARSE");
			$objRichText = new PHPExcel_RichText();
			$objRichText->createText('Fiche recepteur');
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(34);
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(34);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
			
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)	;		
			$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(.2);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(.40);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(.17);
			$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(.17);	
		$sans_menage=0; // au cas où il n'y a pas de bénéficiaire	
		$ligne=10;
		if(isset($menages)) {	
			// Debut Ecriture ligne 1 = village_id;2=tranche;3=poucentage;4=montant à payer pour importation après
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', $village_id);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', $numero_tranche);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', $pourcentage);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', $montant_a_payer);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I5', $agep_id);
			// Fin Ecriture ligne 1 = village_id;2=tranche;3=poucentage;4=montant à payer pour importation après
			$i=1;
			$premier=0;		
			$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Unité de Gestion du PFSS');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Bureau Régional de Ngazidja');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'TEL 773 28 89');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', 'Mbouéni, Moroni');
			$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', 'ETAT DE PAIEMENT VILLAGE : '.strtoupper($village_original));
			$objPHPExcel->getActiveSheet()->getStyle('C1:C4')->getFont()->setName('calibri')->setSize(14);
			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setName('calibri')->setSize(16);
			$objPHPExcel->getActiveSheet()->getStyle('C4:C5')->getFont()->setBold(true);	
			$objPHPExcel->getActiveSheet()->mergeCells('A6:B6');
			$objPHPExcel->getActiveSheet()->mergeCells('F6:H6');
			$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
			$objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
			$objPHPExcel->getActiveSheet()->mergeCells('C6:D6');
			$objPHPExcel->getActiveSheet()->mergeCells('C7:D7');
			$objPHPExcel->setActiveSheetIndex(0)->getRowDimension(6)->setRowHeight(32);
			$objPHPExcel->getActiveSheet()->getStyle('A6:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A6:B7')->getFont()->setName('calibri')->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('A6:B7')->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'Microprojet:');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', 'Agence de Paiement -AGP- :');	
			$objPHPExcel->getActiveSheet()->getStyle('A8:B8')->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', 'Date de paiement :');	
			// Couleur C8 FORMAT_DATE_DMYSLASH 
			$objPHPExcel->getActiveSheet()->getStyle("C8")->getFill()->applyFromArray(
					 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
						 'startcolor' => array('rgb' => 'D8D8C6'),
						 'endcolor'   => array('argb' => 'D8D8C6')
					 )
			 );							 
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', 'Activités de redressement et de réinsertion socio-économique à '.$ile_original);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', strtoupper($nom_agep));	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', 'Date de la liste : '.date("d/m/Y"));	
			$objPHPExcel->getActiveSheet()->getStyle('E6:E7')->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', 'ZIP : '.$id_zip);	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', 'Vague : '.$vague);	
			$objPHPExcel->getActiveSheet()->getStyle('C6:E7')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('C6:E7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$logo1_paiement_arse = dirname(__FILE__) . "/../../../../app/src/".'logo1_paiement_arse.png';
			if(file_exists($logo1_paiement_arse)) {
				$gdImage = imagecreatefrompng($logo1_paiement_arse);
				// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo fiche recepteur ARSE');
				$objDrawing->setDescription('Logo fiche recepteur ARSE');
				$objDrawing->setImageResource($gdImage);
				$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
				// $objDrawing->setWidth(125)->setHeight(125);
				$objDrawing->setCoordinates('A1');
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}	
			$logo2_paiement_arse = dirname(__FILE__) . "/../../../../app/src/".'logo2_paiement_arse.png';
			if(file_exists($logo2_paiement_arse)) {
				$gdImage = imagecreatefrompng($logo2_paiement_arse);
				// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setName('Logo fiche paiement ARSE');
				$objDrawing->setDescription('Logo fiche paiement ARSE');
				$objDrawing->setImageResource($gdImage);
				$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
				// $objDrawing->setWidth(125)->setHeight(125);
				$objDrawing->setCoordinates('G1');
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}	
			$styleArray = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			  )
			);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', 'Etape : ');
			$objPHPExcel->getActiveSheet()->mergeCells('G7:H7');
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("G7",$titre.  " de ".$pourcentage."%", PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle('F7:H7')->getFont()->setName('calibri')->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('F7:H7')->getFont()->setBold(true);						
			$objPHPExcel->getActiveSheet()->getStyle('F7:H7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9', 'N°');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', 'Code ID ménage');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C9', 'Recepteur principal');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9', 'Montant payé');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E9', 'Recepteur suppléant');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', 'Montant payé');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', 'Montant total à payer');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', 'Emargement');
			$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->getFont()->setName('calibri')->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->getFont()->setBold(true);						
			$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A5:H9')->getAlignment()->setWrapText(true);
			foreach ($menages as $ii => $d) {
				// if(intval($d->inapte)==0) {					
					$id=$d->id;
					$identifiant_menage=$d->identifiant_menage;
					$menage=$d->NumeroEnregistrement;
					$NumeroEnregistrement=$d->NumeroEnregistrement;
					$nomchefmenage=$d->nomchefmenage;
					$Addresse=$d->Addresse;
					$SexeChefMenage=$d->SexeChefMenage;
					$NomTravailleur=$d->NomTravailleur;
					$SexeTravailleur=$d->SexeTravailleur;
					$NomTravailleurSuppliant=$d->NomTravailleurSuppliant;
					$SexeTravailleurSuppliant=$d->SexeTravailleurSuppliant;
					$datedenaissancetravailleur=$d->datedenaissancetravailleur;
					$moistravailleur=substr($datedenaissancetravailleur,5,2);
					$anneetravailleur=substr($datedenaissancetravailleur,0,4);
					$agetravailleur=$d->agetravailleur;
					$datedenaissancesuppliant=$d->datedenaissancesuppliant;
					$moissuppliant=substr($datedenaissancesuppliant,5,2);
					$anneesuppliant=substr($datedenaissancesuppliant,0,4);
					$agesuppliant=$d->agesuppliant;
					$NumeroCIN=$d->NumeroCIN;
					$NumeroCarteElectorale=$d->NumeroCarteElectorale;
					$numerocintravailleur=$d->numerocintravailleur;
					$numerocarteelectoraletravailleur=$d->numerocarteelectoraletravailleur;
					$numerocinsuppliant=$d->numerocinsuppliant;
					$numerocarteelectoralesuppliant=$d->numerocarteelectoralesuppliant;
					$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($ligne)->setRowHeight(32);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':H'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, ($ii +1));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $identifiant_menage);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $NomTravailleur);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $NomTravailleurSuppliant);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($ligne))->getNumberFormat()->setFormatCode("### ### ##0");					
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $montant_a_payer);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $id);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':B'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':B'.$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ligne.':H'.$ligne)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$ligne.':H'.$ligne)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$ligne.':H'.$ligne)->applyFromArray($styleArray);
					 if ($ligne%2 == 0) {
						 // Ligne paire => colorée
						$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'D8D8C6'),
									 'endcolor'   => array('argb' => 'D8D8C6')
								 )
						 );							 
					 }	
						$i=$i + 1; // C'EST UNE MISE EN PAGE SUIVANTE
					$ligne=$ligne + 1;	
				// }	
				$fichier1="OK";	
				// unset($objPHPExcel);	
			}	
			// Cacher la colonne I	
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(false);			
		} else {
			// SANS ENREGISTREMENT
			$sans_menage=$sans_menage + 1;
		}
			$fichier="NON";
		if($sans_menage=$sans_menage==0) {
			$date_edition = date("d-m-Y");	
			$Filename ="";
			$Filename ="Etat de paiement ARSE "."village " .$village_tmp.".xlsx";
			//Check if the directory already exists.
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($directoryName.$Filename);
			$fichier="OK";				
			
			$this->response([
				'status' => TRUE,
				'retour' =>	     "OK",
				'date_edition'=> $date_edition,	
				'fichier' => $fichier,
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'name_file' => $Filename,
				'menages' => $menages,
				'message' => 'Get file success',
			], REST_Controller::HTTP_OK);	
			
		} else {
			$this->response([
				'status' => FALSE,
				'retour' =>	     "OK",
				'date_edition'=> $date_edition,	
				'chemin' => $ile_tmp."/".$region_tmp."/".$commune_tmp."/".$village_tmp."/",
				'message' => 'Aucun ménage bénéficiaire pour le filtre seléctinné!.',
			], REST_Controller::HTTP_OK);	
			
		}
	}	
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */