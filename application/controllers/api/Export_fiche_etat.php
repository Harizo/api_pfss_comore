<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Export_excel extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'VillageManager');
    }

    public function index_get() 
    {

        set_time_limit(0);
        ini_set ('memory_limit', '2048M');
        
        $menu = $this->get('menu'); 
        $repertoire = $this->get('repertoire'); 
        $nom_file = $this->get('nom_file'); 
        $id_region= $this->get('id_region'); 
        $id_district= $this->get('id_district');
        $id_commune= $this->get('id_commune');
        $id_intervention= $this->get('id_intervention');

        //CODE HARIZO
        $id_type_transfert= $this->get('id_type_transfert');
        $date_debut= $this->get('date_debut');
        $date_fin= $this->get('date_fin');
        //FIN CODE HARIZO
        $now = date('Y-m-d');

        $scolaire_max = date('Y-m-d', strtotime($now. ' -18 years +1 days'));
        $scolaire_min = date('Y-m-d', strtotime($now. ' -7 years')); 
        $agee = date('Y-m-d', strtotime($now. ' -60 years'));

        $travail_max = date('Y-m-d', strtotime($now. ' -60 years +1 days'));
        $travail_min = date('Y-m-d', strtotime($now. ' -18 years'));
        $enfant = date('Y-m-d', strtotime($now. ' -7 years +1 days'));

        
        
        

       

        //CODE HARIZO
            if ($menu == 'req41_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->beneficiare_sortie_programme() ;
            }

            if ($menu == 'req40_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->nombre_beneficiaire_handicap() ;
            }

            if ($menu == 'req42_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->Moyenne_transfert($id_type_transfert, $date_debut, $date_fin) ;
            }

            if ($menu == 'req43_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->total_transfert($id_type_transfert, $date_debut, $date_fin) ;
            }

            if ($menu == 'req10_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->decaissement_par_programme() ;
            }
            if ($menu == 'req11_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->decaissement_par_tutelle() ;
            }
            if ($menu == 'req12_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->decaissement_par_agence_execution() ;
            }
            if ($menu == 'req37_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->montant_budget_non_consommee_par_programme() ;
            }
            if ($menu == 'req36_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->taux_de_decaissement_par_programme() ;
            }
            if ($menu == 'req18_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->proportion_des_intervention_par_type_de_cible() ;
            }

            if ($menu=='req14_theme2')
            {
                $tmp = $this->Systeme_protection_socialManager->req14theme2_interven_nbrinter_budgetinit_peffectif_pcout_region_district();
                if($tmp)
                {
                    $data=$tmp;
                }
                else 
                    $data = array();

            }

            if($menu=='req20_theme2')
            {
                $data = $this->Systeme_protection_socialManager->proportion_des_intervention_avec_critere_sexe() ;
            }

            if ($menu == 'req19_theme2') //Age par rapport à la date de suivi de l'intervention
            {
                $data = $this->Systeme_protection_socialManager->proportion_des_intervention_avec_critere_age() ;
            }

            if ($menu == 'req32_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->nbr_nouveau_beneficiaire($date_debut, $date_fin) ;
            }


            if ($menu == 'req_multiple_21_to_30_theme2') 
            {
                $data = $this->Systeme_protection_socialManager->req_multiple_21_to_30() ;
            }


            if ($menu == 'liste_beneficiaire_intevention') 
            {
                $data = $this->Systeme_protection_socialManager->liste_beneficiaire_intevention($this->generer_requete_filtre($id_region,$id_district,$id_commune,$id_intervention)) ;   
            }


            

            


        //FIN CODE HARIZO


        //CODE CORRIGER Par Harizo
        if ($menu =='req1_theme1') //Age par rapport à la date du jour 
        {
            $data = $this->Environment_demo_socioManager->effectif_par_age_sexe_population($enfant,$scolaire_min,$scolaire_max,$travail_min,$travail_max,$agee);
           
        }
        if ($menu == 'req34_theme2') //Age par rapport à la date d'inscription
        {
            $data = $this->Systeme_protection_socialManager->taux_atteinte_resultat() ;
        }
        if ($menu =='req3_theme1')
        {            
            $data = $this->Environment_demo_socioManager->menage_ayant_efant($enfant,$scolaire_min,$scolaire_max);      
           
        }

        if ($menu == 'req6_theme2') 
        {
            $data = $this->Systeme_protection_socialManager->req6_theme2() ;
        }

        if ($menu=='req7_theme2')//situtation(en cours ou new) par rapport à la debut et fin du programme
        {
            $tmp = $this->Systeme_protection_socialManager->repartition_financement_programme();
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();
        }

        if ($menu=='req8_theme2')//situtation(en cours ou new) par rapport à la debut et fin du programme
        {
            $tmp = $this->Systeme_protection_socialManager->repartition_financement_source_financement();
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();
        }

        if ($menu=='req9_theme2')//situtation(en cours ou new) par rapport à la debut et fin du programme
        {
            $tmp = $this->Systeme_protection_socialManager->repartition_financement_tutelle();
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();
        }

        if ($menu =='req38_theme2')
        {
            $data = $this->Systeme_protection_socialManager->repartition_par_age_sexe_beneficiaire();
            
            
        }
        //fin CODE CORRIGER Par Harizo

        

       

        if ($menu=='req31theme2_interven_nbrinter_program_beneparan_beneprevu_region')
        {
            $tmp = $this->Systeme_protection_socialManager->req31theme2_interven_nbrinter_program_beneparan_beneprevu_region($this->generer_requete_sql($id_region,'*','*',$id_intervention));
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();

        }

        if ($menu=='req34theme2_program_interven_nbrbene_nbrinter_tauxinter_region')
        {
            $tmp = $this->Systeme_protection_socialManager->req34theme2_program_interven_nbrbene_nbrinter_tauxinter_region($this->generer_requete_sql($id_region,'*','*',$id_intervention));
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();

        }



        if ($menu=='req20theme2_interven_pourcenfille_pourcenhomme_pcout')
        {
            $tmp = $this->Systeme_protection_socialManager->req20theme2_interven_pourcenfille_pourcenhomme_pcout();
            if($tmp)
            {
                $data=$tmp;
            }else $data = array();

        }
        


        //Export excel
        $this->export($data, $repertoire, $nom_file, $menu, $date_debut, $date_fin);
        //fin Export excel

    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////:
	public function exportlisteficheetatpresence() {	
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';

        
        $directoryName = dirname(__FILE__) ."/../../../../exportexcel/".$repertoire;
        
        //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
		$menages = array();
		$menages = $request->request->get('donnees');				
		$id_village = $request->request->get('id_village');	
		$nom_ile = $request->request->get('nom_ile');
		if($nom_ile=="Moheli") {
			$nom_ile="MWL";
		} else if($nom_ile=="Anjouan"){
			$nom_ile="NDZ";
		} else {
			$nom_ile="NGZ";
		}		
		$agex_id = $request->request->get('agex_id');		
		$nom_agex = "";		
		$conn = $this->get('database_connection');
		$requete_agex ="select code as nom_agex from see_agex where id=".$agex_id;
			$xx = $conn->query($requete_agex);
			while ($row = $xx->fetch()) {
				$nom_agex= $row['nom_agex'];
			}
		$code_zip = $request->request->get('code_zip');		
		$nom_activite = "";		
		$activite_id = $request->request->get('activite_id');	
		$nom_activite='';
		if(isset($activite_id) && intval($activite_id) >0) {	
			$requete_act ="select Detail as nom_activite from see_activite where id=".$activite_id;
				$xx = $conn->query($requete_act);
				while ($row = $xx->fetch()) {
					$nom_activite= $row['nom_activite'];
				}
		}		
		$nom_village = $request->request->get('nom_village');		
		$etape_id = $request->request->get('etape_id');		
		$etape = $request->request->get('etape');		
		$annee = $request->request->get('annee');		
		$annee_id = $request->request->get('annee_id');		
		$microprojet = $request->request->get('microprojet');		
		$microprojet_id = $request->request->get('microprojet_id');		
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
			$objPHPExcel->getProperties()->setCreator("OGACD")
								 ->setLastModifiedBy("OGADC")
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Microprojet :')->setCellValue('C4', $microprojet);
			}			
			$objPHPExcel->getActiveSheet()->getStyle('C3:C8')->getFont()->setItalic(true);
		$nombreenregistrement = count($menages);				
		if(isset($menages)) {	
			$i=7;
			$nombreligne=0;
			$combien =1;
			$premier=0;
			foreach ($menages as $ii => $d) {
				if(intval($d["inapte"])==0) {				
					$ile=$d["ile"];
					$region=$d["region"];
					$commune=$d["commune"];
					$village = $d["village"];
					$menage= $d["menage"]	;
					$nomChefMenage =$d["nomChefMenage"];
					$nomTravailleur = $d["nomTravailleur"];
					$nomTravailleurSuppliant = $d["nomTravailleurSuppliant"];
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
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(dirname(__FILE__) . "/../../../exportexcel/".$ile_encours."/".$region_encours."/".$commune_encours."/".$village_encours."/" ."Fiche de presence ".$village_encours." ".$nom_ile." ".$nom_activite." ".$nom_agex." ".$code_zip." edition du ".$date_edition.".xlsx");		
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("OGACD")
								 ->setLastModifiedBy("OGADC")
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
						->setCellValue('A2', 'Microprojet : ')
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
				if(intval($d["inapte"])==0) {
					$id=$d["id"];
					$ile=$d["ile"];
					$region=$d["region"];
					$commune=$d["commune"];
					$village = $d["village"];
					$village_id = $d["village_id"];
					$menage= $d["menage"]	;
					$nomChefMenage =$d["nomChefMenage"];
					$nomTravailleur = $d["nomTravailleur"];
					$nomTravailleurSuppliant = $d["nomTravailleurSuppliant"];
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
					$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),$id);	
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
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(dirname(__FILE__) . "/../../../importexcel/".$ile_encours."/".$region_encours."/".$commune_encours."/".$village_encours."/" ."Etat de presence ".$village_encours." ".$nom_ile." ".$nom_activite." ".$nom_agex." ".$code_zip." edition du ".$date_edition.".xlsx");
		// FIN FICHE ETAT DE PRESENCE  MENAGE APTE		
		// DEBUT FICHE ETAT DE PRESENCE  MENAGE INAPTE	
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("OGACD")
								 ->setLastModifiedBy("OGADC")
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
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Microprojet :')->setCellValue('C4', $microprojet);
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
				if(intval($d["inapte"])==1) {				
					$ile=$d["ile"];
					$region=$d["region"];
					$commune=$d["commune"];
					$village = $d["village"];
					$menage= $d["menage"]	;
					$nomChefMenage =$d["nomChefMenage"];
					$nomTravailleur = $d["nomTravailleur"];
					$nomTravailleurSuppliant = $d["nomTravailleurSuppliant"];
					$annee = $request->request->get('annee');		
					$microprojet = $request->request->get('microprojet');		
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
		if($existe_inapte==1) {
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save(dirname(__FILE__) . "/../../../exportexcel/".$ile_encours."/".$region_encours."/".$commune_encours."/".$village_encours."/" ."Fiche de presence INAPTE ".$village_encours." ".$nom_ile." ".$nom_activite." ".$nom_agex." ".$code_zip." edition du ".$date_edition.".xlsx");
		}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("OGACD")
								 ->setLastModifiedBy("OGADC")
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
						->setCellValue('A2', 'Microprojet : ')
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
				if(intval($d["inapte"])==1) {
					$id=$d["id"];
					$ile=$d["ile"];
					$region=$d["region"];
					$commune=$d["commune"];
					$village = $d["village"];
					$village_id = $d["village_id"];
					$menage= $d["menage"]	;
					$nomChefMenage =$d["nomChefMenage"];
					$nomTravailleur = $d["nomTravailleur"];
					$nomTravailleurSuppliant = $d["nomTravailleurSuppliant"];
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
					$objPHPExcel->getActiveSheet()->setCellValue("G" . ($i + 5),$id);	
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
        //ETAT DE RETOUR
        try
        {
			if($existe_inapte==1) {
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save(dirname(__FILE__) . "/../../../importexcel/".$ile_encours."/".$region_encours."/".$commune_encours."/".$village_encours."/" ."Etat de presence INAPTE ".$village_encours." ".$nom_ile." ".$nom_activite." ".$nom_agex." ".$code_zip." edition du ".$date_edition.".xlsx");
			}	            
            $this->response([
                'status' => TRUE,
                'nom_file' => $nom_file.".xlsx",
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

        //ETAT DE RETOUR
	}	
//////////////////////////////////////////////////////////////////////////////////////////////////////////:
    public function export($data, $repertoire, $nom_file, $menu, $date_debut, $date_fin)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';

        
        $directoryName = dirname(__FILE__) ."/../../../../exportexcel/".$repertoire;
        
        //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("App WEB MPPSPF")
                    ->setLastModifiedBy("App WEB MPPSPF")
                    ->setTitle("App WEB MPPSPF")
                    ->setSubject("App WEB MPPSPF")
                    ->setDescription("App WEB MPPSPF")
                    ->setKeywords("App WEB MPPSPF")
                    ->setCategory("App WEB MPPSPF");

        $ligne=1;            

        $date_debut = date("d-m-Y", strtotime($date_debut));
        $date_fin = date("d-m-Y", strtotime($date_fin));


        // Set Orientation, size and scaling
        // Set Orientation, size and scaling
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite

        




        $styleTitre = array
        (
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                
            ),
        'font' => array
            (
                //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 16
            ),
        );

        $stylesousTitre = array
        ('borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                
            ),
        'font' => array
            (
                //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 12
            ),
        );

        $Titre1 = array
        (
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                
            ),
        'font' => array
            (
                //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 12
            ),
        );

        $stylecontenu = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );


        //CONTENU
            
            if ($menu == 'req1_theme1') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Région");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'District');
                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Commune');
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Enfant');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'En âge scolaire');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'En âge de travailler');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Âgées');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($ligne+1), 'Femme');

                



                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".($ligne+1))->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".($ligne+1))->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

               $ligne = $ligne + 2 ;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_region);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_dist);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->nom_com);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nbr_enfant_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->nbr_enfant_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nbr_agescolaire_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->nbr_agescolaire_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->nbr_agetravaille_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->nbr_agetravaille_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $value->nbr_agee_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->nbr_agee_fille);
                  

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                    $ligne++;
                }
            }

            if ($menu == 'req3_theme1')//OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Région");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'District');
                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Commune');
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Effectif des ménages ayant des enfant de 0 - 6 ans');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Effectif des ménages ayant des enfant en âge scolaire');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_reg);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_dist);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->nom_com);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nbr_ayant_enfant);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nbr_ayant_enfant_age_scolaire);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $ligne++;
                }
            }


            if ($menu == 'req7_theme2')
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":O".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Situation');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Montant initial');
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":M".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, 'Montant modifier');
                $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $this->etat_nouveau($value->etat_nouveau));
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, number_format($this->affichage_budget_initial($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":M".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, number_format($this->affichage_budget_modifie($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":O".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }


            }

            if ($menu == 'req8_theme2')
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":R".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Situation');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Source de financement');
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, 'Montant initial');
                $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, 'Montant modifier');
                $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":R".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $this->etat_nouveau($value->etat_nouveau));
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->nom_source_financement);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, number_format($this->affichage_budget_initial($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, number_format($this->affichage_budget_modifie($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":R".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }


            }

            if ($menu == 'req9_theme2')
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":R".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Situation');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Tutelle');
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, 'Montant initial');
                $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, 'Montant modifier');
                $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":R".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    /*$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $this->etat_nouveau($value->etat_nouveau));
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->ministere_tutelle);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, number_format($this->affichage_budget_initial($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":M".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, number_format($this->affichage_budget_modifie($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".$ligne);*/

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $this->etat_nouveau($value->etat_nouveau));
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->ministere_tutelle);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, number_format($this->affichage_budget_initial($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, number_format($this->affichage_budget_modifie($value),0,","," ")." ".$value->description_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":R".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":R".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);


                   
                    $ligne++;
                }


            }

            if ($menu == 'req10_theme2') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Montant initial');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Montant révisé');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format($value->montant_init,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format($value->montant_revise,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }
            if ($menu == 'req11_theme2') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Tutelle");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Montant initial');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Montant révisé');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->tutelle);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format($value->montant_init,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format($value->montant_revise,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }
            if ($menu == 'req12_theme2') //OK
            {
               $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Tutelle");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Agence d'éxécution");
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nom_acteur);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }
            
            

            if ($menu=='req14_theme2')//OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Région');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'District');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Effectif');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Coût');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_inter);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nom_reg);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nom_dist);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format($value->effectif_intervention,2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, number_format((int)(($value->total_cout_district * 100)/$value->total_cout_menage),2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $ligne++;
                }

            }

            if ($menu == 'req18_theme2') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Ménage');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($ligne+1), 'Coût');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Individu');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($ligne+1), 'Coût');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Groupe');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($ligne+1), 'Coût');



                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".($ligne+1))->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".($ligne+1))->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

               $ligne = $ligne + 2 ;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, number_format($value->stat_menage,2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, number_format($value->stat_montant_menage,2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format($value->stat_individu,2,","," "));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, number_format($value->stat_montant_individu,2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format($value->stat_groupe,2,","," "));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, number_format($value->stat_montant_groupe,2,","," ")." %");
                  

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                    $ligne++;
                }



            }

            if ($menu == 'req19_theme2')//OK 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Enfant');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($ligne+1), 'Coût');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Âge scolaire');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($ligne+1), 'Coût');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Âge de travailler');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($ligne+1), 'Coût');


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Personne âgées');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($ligne+1), 'Coût');



                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".($ligne+1))->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".($ligne+1))->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

               $ligne = $ligne + 2 ;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, number_format((($value->nbr_enfant * 100)/$value->nbr_total_benaficiare),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, number_format((($value->cout_enfant * 100)/$value->total_cout),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format((($value->nbr_age_scolaire * 100)/$value->nbr_total_benaficiare),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, number_format((($value->cout_age_scolaire * 100)/$value->total_cout),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format((($value->nbr_age_travail * 100)/$value->nbr_total_benaficiare),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, number_format((($value->cout_age_travail * 100)/$value->total_cout),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, number_format((($value->nbr_agee * 100)/$value->nbr_total_benaficiare),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, number_format((($value->cout_agee * 100)/$value->total_cout),2,","," ")." %");
                  

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                    $ligne++;
                }
            }

            if($menu=='req20_theme2')//OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Homme');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($ligne+1), 'Coût');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Femme');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".($ligne));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($ligne+1), 'Effectif');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($ligne+1), 'Coût');



                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".($ligne+1))->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".($ligne+1))->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

               $ligne = $ligne + 2 ;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_interv);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, number_format((($value->nbr_total_homme * 100)/$value->total_beneficiaire),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, number_format((($value->cout_total_intervention_h * 100)/$value->total_cout_menage),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format((($value->nbr_total_femme * 100)/$value->total_beneficiaire),2,","," ")." %");
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, number_format((($value->cout_total_intervention_f * 100)/$value->total_cout_menage),2,","," ")." %");
                  

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->getAlignment()->setWrapText(true);
                    $ligne++;
                }
            }

            

            if ($menu == 'req32_theme2')//OK 
            {
               $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Du: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $date_debut);
                $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":D".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Au: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $date_fin);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($Titre1);

                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Région');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);
             

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Nombre de nouveaux bénéficiaires');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_interv);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);


                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nom_reg);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nbr_total_benaficiaire);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $ligne++;
                }
            }

            if ($menu == 'req34_theme2')//OK 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Région');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Taux ménage');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Taux individu');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nom_region);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format((($value->nbr_menage_beneficiaire * 100)/$value->nbr_menage_prevu),2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, number_format((($value->nbr_individu_beneficiaire * 100)/$value->nbr_individu_prevu),2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            
            if ($menu == 'req36_theme2') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Budget prévu');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Décaissement');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Taux de décaissement');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, number_format($value->sum_financement_par_intervention_par_programme,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, number_format($value->sum_decaissement,0,","," ")." ".$value->devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, number_format($value->prop,3,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                    $ligne++;
                }
                
            }

            if ($menu == 'req37_theme2') //OK
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Programme");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Budget prévu');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, 'Décaissement');
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":G".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, 'Budget non consommé');
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":I".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Taux de décaissement');
                $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->intitule_programme);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, number_format($value->budget_prevu,0,","," ")." ".$value->desc_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":E".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, number_format($value->somme_decaissement,0,","," ")." ".$value->desc_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":G".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, number_format($value->budget_non_comnsommee,0,","," ")." ".$value->desc_devise);
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":I".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, number_format($value->prop,2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            if ($menu == 'req38_theme2') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":S".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":S".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Région");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'District');
                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Commune');
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Nomenclature');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".($ligne+1));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Enfant');
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":M".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, 'En âge scolaire');
                $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, 'En âge de travailler');
                $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":Q".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.($ligne+1), 'Femme');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, 'Âgées');
                $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":S".($ligne));

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.($ligne+1), 'Homme');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($ligne+1), 'Femme');

                



                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":S".($ligne+1))->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":S".($ligne+1))->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

               $ligne = $ligne + 2 ;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_region);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_dist);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->nom_com);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->nbr_enfant_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $value->nbr_enfant_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->nbr_agescolaire_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, $value->nbr_agescolaire_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, $value->nbr_agetravaille_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, $value->nbr_agetravaille_fille);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, $value->nbr_agee_homme);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$ligne, $value->nbr_agee_fille);
                  

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":S".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":S".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            

            if ($menu == 'req40_theme2') //OK
            {

                /*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);*/

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":P".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":P".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Bénéficiaire avec handicap visuel');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Bénéficiaire avec handicap de la parole');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Bénéficiaire avec handicap auditif');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, 'Bénéficiaire avec handicap mentale');
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, 'Bénéficiaire avec handicap moteur');
                $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":P".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":P".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nbr_hand_visu);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nbr_hand_paro);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->nbr_hand_audi);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $value->nbr_hand_ment);
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, $value->nbr_hand_mote);
                    $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":P".$ligne);

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":P".$ligne)->applyFromArray($stylecontenu);
                    $ligne++;
                }
                
            }

            if ($menu == 'req41_theme2') 
            {

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Sexe');
              
             

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, 'Nombre ménage');
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":I".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Nombre individu');
                $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".$ligne);


                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->sexe);
                    

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->nombre_menage);
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":I".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->nombre_individu);
                    $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":K".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylecontenu);
                    $ligne++;
                }
            }

            if ($menu == 'req42_theme2') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":I".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Du: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $date_debut);
                $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Au: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $date_fin);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".$ligne)->applyFromArray($Titre1);

                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Détail');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                   

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->detail_type_transfert.": ".number_format($value->moyenne,0,","," ")." ".$value->unite_mesure);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            if ($menu == 'req43_theme2') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":I".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Du: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $date_debut);
                $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Au: ");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $date_fin);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".$ligne)->applyFromArray($Titre1);

                $ligne = $ligne + 2 ;


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Intervention");
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Détail');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                   

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->detail_type_transfert.": ".number_format($value->quantite,0,","," ")." ".$value->unite_mesure);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":I".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            if ($menu == 'req_multiple_21_to_30_theme2') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":Q".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

          

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nomenclature");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Variable');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Détails');
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, 'Effectif');
                $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, 'Coût');
                $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":Q".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nomenclature_description);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->liste_variable);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->variable);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, number_format($value->effectif,2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":O".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, number_format($value->stat_cout,2,","," ")." %");
                    $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":Q".$ligne);



                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }


            if ($menu == 'req6_theme2') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Région");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'District');
                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Niveau de vulnérabilité');
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Nombre');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_region);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_district);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                   

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->description_vulnerabilite." (".$value->code_vulnerabilite.")");
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nbr);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);


                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            if ($menu == 'liste_beneficiaire_intevention') 
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                
                $objPHPExcel->getActiveSheet()->setTitle("Tableau de bord");

                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
                $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $nom_file);


                $ligne = $ligne + 2 ;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Région: ".$data[0]->nom_region);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);

                $ligne++;

                


                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "District");
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, 'Commune');
                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, 'Fokontany');
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, 'Intervention');
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, 'Bénéficiaire');
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, 'Type Bénéficiaire');


                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);

                $ligne++;

                foreach ($data as $key => $value) 
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_district);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_commune);
                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);

                   

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->nom_fokontany);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->intitule_intervention);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, strtoupper($value->nom)." ".$value->prenom);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->type);

                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":K".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(30);
                    $ligne++;
                }
            }

            


        //FIN CONTENU
       
        //ETAT DE RETOUR
        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
           // $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
            $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' => $nom_file.".xlsx",
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

        //ETAT DE RETOUR
    } 
    //misy amboarina le intervention
    public function generer_requete_filtre($id_region,$id_district,$id_commune,$id_intervention)
    {
        $requete = " region.id='".$id_region."'";
       /* if ($date_debut!=$date_debut) 
        {
            $requete = $requete."date_naissance BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        }else{
            $requete = $requete."date_naissance ='".$date_debut."'";
        }*/
        if (($id_district!='*')&&($id_district!='undefined')) 
        {
            $requete = $requete." AND district.id='".$id_district."'" ;
        }
        if (($id_commune!='*')&&($id_commune!='undefined')) 
        {
            $requete = $requete." AND commune.id='".$id_commune."'" ;
        }
        if (($id_intervention!='*')&&($id_intervention!='undefined')) 
        {
            $requete = $requete." AND intervention.id='".$id_intervention."'" ;
        }

        return $requete;
    }
    
    public function generer_requete_sql($id_region,$id_district,$id_commune,$id_intervention)
    {
        $requete = " reg.id='".$id_region."'";
        if (($id_intervention!='*')&&($id_intervention!='undefined')) 
        {
            $requete = $requete." AND interven.id='".$id_intervention."'" ;
        }

        return $requete;
    }

    private function etat_nouveau($new)
    {
        if (((int)$new) > 0) 
        {
            return "Nouveau" ;
        }
        else
            return "En cours" ;
    }

    private function affichage_budget_initial($data)
    {
        if ($data->etat_nouveau > 0) 
        {
            return $data->budget_initial_nouveau ;
        }
        else
            return $data->budget_initial_en_cours ;
    }

    private function affichage_budget_modifie($data)
    {
        if ($data->etat_nouveau > 0) 
        {
            return $data->budget_modifie_nouveau ;
        }
        else
            return $data->budget_modifie_en_cours ;
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */