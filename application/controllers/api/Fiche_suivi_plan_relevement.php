<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Fiche_suivi_plan_relevement extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_suivi_plan_relevement_model', 'fpriManager');
        $this->load->model('menage_model', 'menageManager');

        $this->load->model('fiche_suivi_plan_relevement_intervenants_model', 'intervenantMng');
        $this->load->model('fiche_suivi_plan_relevement_presentation_model', 'presMng');
        $this->load->model('fiche_suivi_plan_relevement_materiel_model', 'materMng');
        $this->load->model('fiche_suivi_prelevement_probleme_model', 'blmMng');
        $this->load->model('fiche_suivi_prelevement_payement_model', 'paieMng');
        $this->load->model('fiche_suivi_prelevement_obligation_model', 'obligMng');
      
    }
    public function index_get() {
        $id = $this->get('id');
        $id_village = $this->get('id_village');
        $id_menage = $this->get('id_menage');
        $export_excel = $this->get('export_excel');
        $repertoire = $this->get('repertoire');
        $identifiant_menage = $this->get('identifiant_menage');
        $nomchefmenage = $this->get('nomchefmenage');
        $nomTravailleur = $this->get('NomTravailleur');
        $nomTravailleurSuppliant = $this->get('NomTravailleurSuppliant');
        $data = array() ;
   
		if ($id && $export_excel) 
        {
			$nom_file = "suivificheplanrelevement"; 
			$sfp = $this->fpriManager->findById($id);

            require_once 'Classes/PHPExcel.php';
            require_once 'Classes/PHPExcel/IOFactory.php';

            
            $directoryName = dirname(__FILE__) ."/../../../../exportexcel/".$repertoire;
            
            //Check if the directory already exists.
            if(!is_dir($directoryName))
            {
                mkdir($directoryName, 0777,true);
            }
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("App WEB MIS")
                        ->setLastModifiedBy("App WEB MIS")
                        ->setTitle("App WEB MIS")
                        ->setSubject("App WEB MIS")
                        ->setDescription("App WEB MIS")
                        ->setKeywords("App WEB MIS")
                        ->setCategory("App WEB MIS");

            $ligne=1; 

            // Set Orientation, size and scaling
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
                $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
                $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite
            // Set Orientation, size and scaling

            $titrebe1 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 12
                ),
            );

            $titrebe2 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 11
                ),
            );

            $titrebe3 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 10
                ),
            );

            $titrebe4 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 9
                ),
            );

            $titre1 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 8
                ),
            );

            $titre2 = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 8
                ),
            );

            $stylesousTitre = array
            (   
                'borders' => array
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
                    'name'  => 'Times New Roman',
                    'bold'  => true,
                    'size'  => 8
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
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'size'  => 8
                )
            );

            $contenusansbordure = array
            (
                'alignment' => array
                (
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
                ),
                'font' => array
                (
                    'name'  => 'Times New Roman',
                    'size'  => 8
                ),
            );


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

            $objPHPExcel->getActiveSheet()->setTitle("Fiche plan relevement");

            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
            $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

            $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "UNION DES COMORES");
            $ligne++;

            $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe2);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Unité – Solidarité – Développement");
            $ligne+=2;

            $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe2);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "FICHE DE SUIVI DES PLANS DE RELEVEMENTS");
            $ligne++;


            //PRESENTATION BENEFICIAIRE
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "1. Présentation du Bénéficiaire");
                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Code ménage : ".$sfp[0]->identifiant_menage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Ile : ".$sfp[0]->Ile);


                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Chef ménage : ".$sfp[0]->nom_chef_menage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Préfecture : ".$sfp[0]->Region);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Travailleur principale : ".$sfp[0]->NomTravailleur);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Commune : ".$sfp[0]->Commune);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Travailleur suppléant : ".$sfp[0]->NomTravailleurSuppliant);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Village : ".$sfp[0]->Village);
                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "");

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "ZIP : ".$sfp[0]->zip);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "");

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Vague : ".$sfp[0]->vague);
                $ligne++;

                /*$objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "AGEX : ".$sfp[0]->nom_agex);
                $ligne++;*/
            //FIN PRESENTATION BENEFICIAIRE

            //INTEVENANTS
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2. Présentation des intervenants et participants ");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Bureau régional");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "CPS");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "AGEX");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "ADC");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":L".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Mère / Père leader");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Autres");
                $ligne++;

                $interv = $this->intervenantMng->findBy_id_fspr($id);

                if (count($interv) > 0) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $interv[0]->bureau_regional);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $interv[0]->cps);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":H".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $sfp[0]->nom_agex);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $interv[0]->adc);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":L".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $interv[0]->nom_prenom_ml_pl);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $interv[0]->autres);
                }


                
                $ligne++;
            //FIN INTEVENANTS

            //PRESENTATION
                
                $pres = $this->presMng->findBy_id_fspr($id);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3. Présentation du plan de relèvement ");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Activité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Date de démarrage de l’activité  ");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Objectif");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Date de suivi");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Stade  de réalisation de l'activité");

                /*$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Autres");
                $ligne++;*/
                $ligne++;

                if (count($pres) > 0) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $pres[0]->activite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylecontenu);

                    $tab_date_demarage_activite = explode("-",$pres[0]->date_demarage_activite);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $tab_date_demarage_activite[2]."-".$tab_date_demarage_activite[1]."-".$tab_date_demarage_activite[0]);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":H".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":H".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $pres[0]->objectif);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":J".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylecontenu);

                    $tab_date_suivi = explode("-",$pres[0]->date_suivi);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $tab_date_suivi[2]."-".$tab_date_suivi[1]."-".$tab_date_suivi[0]);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $pres[0]->stade_realisation_activite);

                    /*$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $pres[0]->autres);*/
                }
           


                
                $ligne++;
            //FIN PRESENTATION

            //MATERIEL
                $mater = $this->materMng->findBy_id_fspr($id);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "4. Présentation des matériels et intrants achetés");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":D".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Désignation");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Quantité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Prix unitaire");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Observation");
                $ligne++;

                if (count($mater) > 0) 
                {
                    foreach ($mater as $key => $value) 
                    {
                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":D".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->designation);

                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->quantite);

                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->prix_unitaire." KMF");

                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->observation);
                        $ligne++;
                    }
                }

                
            //FIN MATERIEL
            //PROBLEME
                $blm = $this->blmMng->findBy_id_fspr($id);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "5. Problèmes rencontrés et solutions");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Problèmes");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Solutions apportées");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Observations");
                $ligne++;

                if (count($blm) > 0) 
                {
                    foreach ($blm as $key => $value) 
                    {
                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->probleme);

                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->solution);

                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->observation);
                        $ligne++;
                    }
                }

                

            //FIN PROBLEME
            //PAIE
                $paie = $this->paieMng->findBy_id_fspr($id);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "6. Payement déjà perçu ");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":D".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "N° tranches");


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Etat de paiement");


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Date de paiement");

                /*$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Observation");*/

                $ligne++;

                if (count($paie) > 0) 
                {
                    foreach ($paie as $key => $value) 
                    {
                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":D".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->numero_tranche);


                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->etat_paiement);


                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":J".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":J".$ligne)->applyFromArray($stylecontenu);

                        $tab_date_paiement = explode("-",$value->date_paiement);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $tab_date_paiement[2]."-".$tab_date_paiement[1]."-".$tab_date_paiement[0]);

                        /*$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->);*/

                        $ligne++;
                    }
                }

                
            //FIN PAIE
            //OBLIGATION
                $oblig = $this->obligMng->findBy_id_fspr($id);

                $paie = $this->paieMng->findBy_id_fspr($id);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "7. Obligation de respecter les engagements");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Désignation");


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":I".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":I".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Respect obligation");


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Obsevation");
                $ligne++;

                if (count($oblig) > 0) 
                {
                    foreach ($oblig as $key => $value) 
                    {
                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->designation);


                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":I".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":I".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->respect_obligation);


                        $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                        $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":N".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->observation);
                        $ligne++;
                    }
                }
                

            //FIN OBLIGATION
                $ligne++;
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Signatures des participants");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "AGEX");
           

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "BENEFICIAIRE");
               

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "CPS");

                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".($ligne+5));
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".($ligne+5))->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "");
           

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".($ligne+5));
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".($ligne+5))->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "");
               

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".($ligne+5));
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".($ligne+5))->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "");

































		} 

        if ($id_village)
        {
			
			$data = $this->fpriManager->findAllby_id_village($id_village);                   
		}

        if ($id_menage)
        {
            
            $data = $this->menageManager->get_composition_menage($id_menage);                   
        }



        if ($export_excel) 
        {
            try
            {
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
               // $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
                $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
                
                $this->response([
                    'mater' => $mater,
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
        }
        else
        {

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
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			
            'id_village'                            => $this->post('id_village'),
            'id_menage'                             => $this->post('id_menage'),                      
            'id_agex'                               => $this->post('id_agex')
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
                $dataId = $this->fpriManager->add($data);
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
                $update = $this->fpriManager->update($id, $data);              
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
            $delete = $this->fpriManager->delete($id);          
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