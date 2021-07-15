<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Fiche_plan_relevement_identification extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_plan_relevement_identification_model', 'fpriManager');
        $this->load->model('menage_model', 'menageManager');

        $this->load->model('fiche_plan_relevement_objdesc_un_deux_model', 'fproaMng');
        $this->load->model('fiche_plan_relevement_objdesc_trois_model', 'partieMng');
        $this->load->model('fiche_plan_relevement_objdesc_quatre_model', 'riskMng');
        $this->load->model('fiche_plan_relevement_plan_production_un_model', 'planMng');
        $this->load->model('fiche_plan_relevement_plan_production_deux_model', 'deprodMng');
        $this->load->model('fiche_plan_relevement_plan_production_trois_model', 'etudeMng');
     
      
    }
    public function index_get() {
        $id = $this->get('id');
        $id_village = $this->get('id_village');
        $id_menage = $this->get('id_menage');
        $export_excel = $this->get('export_excel');
        $repertoire = $this->get('repertoire');
        $data = array() ;
   
		if ($id && $export_excel) 
        {
            $nom_file = "ficheplanrelevement"; 
			
			$fp = $this->fpriManager->findById($id);

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
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "FICHE PLAN DE RELEVEMENT");
            $ligne++;


            //IDENTIFICATION
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "1. IDENTIFICATION");
                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Date de remplissage : ".$fp[0]->date_remplissage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Ile : ".$fp[0]->Ile);


                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Code ménage : ".$fp[0]->identifiant_menage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Préfecture : ".$fp[0]->Region);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Chef ménage : ".$fp[0]->nom_chef_menage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Commune : ".$fp[0]->Commune);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Age Chef ménage : ".$fp[0]->agechefdemenage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Village : ".$fp[0]->Village);
                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nbr enfant -15 ans : ".$fp[0]->nombre_enfant_moins_quinze_ans);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "ZIP : ".$fp[0]->zip);

                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Composition du ménage : ".$fp[0]->composition_menage);

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Vague : ".$fp[0]->vague);
                $ligne++;

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "AGEX : ".$fp[0]->nom_agex);
                $ligne++;

            //FIN IDENTIFICATION

            //OBJECTIF ET DESCRIPTION DE ARSE
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2. OBJECTIF ET DESCRIPTION DE ARSE");
                $ligne++;
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2.1. Objectif (Que souhaitez-vous faire):");
                $ligne++;


                //GET TEXTE OBJECTIF
                $objectif = $this->fproaMng->findBy_id_identification($id);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".($ligne+2));
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $objectif[0]->objectif);
                $ligne+=3;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2.2. Caracéristiques");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Cycle");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Faisabilité technique");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".($ligne+1));
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".($ligne+1))->applyFromArray($stylesousTitre);

                if ($objectif[0]->cycle == "9") 
                {
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3 à 6 Mois");
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "6 à 12 Mois");
                }

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Disponibilité en intrants");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Disponible du terrain");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Capacité technique");


                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);

                if ($objectif[0]->disponibilite_intrant == "0") 
                {
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Non");
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Oui");
                }


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);

                if ($objectif[0]->disponibilite_terrain == "0") 
                {
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Non");
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Oui");
                }


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);

                if ($objectif[0]->capacite_technique == "0") 
                {
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Non");
                }
                else
                {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Oui");
                }

                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2.3. Parties prenantes");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Formation");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Encadrement");


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Suivi");

                $ligne++;

                $partie = $this->partieMng->findBy_id_identification($id);
                

                foreach ($partie as $key => $value) 
                {
                    
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->formation);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->encadrement);


                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->suivi);

                    $ligne++;
                }

                $risque = $this->riskMng->findBy_id_identification($id);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2.4. Risques éventuelle et solutions prévues");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Risques éventuelles");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Solutions prévues");
                $ligne++;

                foreach ($risque as $key => $value) 
                {
                    
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->risque_eventuelle);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->solution_prevu);



                    $ligne++;
                }

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe3);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3. PLAN DE PRODUCTION");
                $ligne++;

                

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3.1. Les ressources nécessaires à la mise en place de l'activité");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "N°");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":D".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("B".$ligne.":D".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, "Matériels et entrants");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Unité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Disponible");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "A chercher");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Acheter où");

                $ligne++;

                $plan = $this->planMng->findBy_id_identification($id);

                foreach ($plan as $key => $value) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->numero);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":D".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("B".$ligne.":D".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $value->materiel_entrant);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->unite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->disponible);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->achercher);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->acheter_ou);

                    $ligne++;
                }

            //FIN OBJECTIF ET DESCRIPTION DE ARSE

            //DEPENSE PRODUCTION
                $depense = $this->deprodMng->findBy_id_identification($id, "depense");
                $produit = $this->deprodMng->findBy_id_identification($id, "produit");

                $total_depense = $this->deprodMng->get_total($id, "depense");
                $total_produit = $this->deprodMng->get_total($id, "produit");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3.2. Compte provisionnel pour un cycle de production");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Dépense");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Désignation");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Unité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Quantité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Prix unitaire");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":M".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Montant");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "N°(Numéro matériels à chercher)");
                $ligne++;

                foreach ($depense as $key => $value) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->designation);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->unite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->quantite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->prix_unitaire);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":M".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->montant);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->numero_materiel);
                    $ligne++;
                }

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Total Dépense = ".$total_depense[0]->total);

                $ligne++;
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Produit");
                $ligne++;

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Désignation");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Unité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Quantité");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Prix unitaire");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":M".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Montant");

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "N°(Numéro matériels à chercher)");
                $ligne++;

                foreach ($produit as $key => $value) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->designation);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->unite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":G".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":G".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->quantite);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":J".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":J".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->prix_unitaire);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":M".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":M".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->montant);

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->numero_materiel);
                    $ligne++;
                }

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Total produit = ".$total_produit[0]->total);
                $ligne++;
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Bénéfices = ".(intval($total_produit[0]->total) - intval($total_depense[0]->total)));
                $ligne++;
            //FIN DEPENSE PRODUCTION

            //ETUDE DE MARCHE
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($titrebe4);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3.3.Etude du marché");
                $ligne++;


                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Activités");
           

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Lieu de production");
               

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Lieu d'approvisionnement d'intrant");
               

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Lieu d'écoulement des produits");
                $ligne++;

                $etude_marche = $this->etudeMng->findBy_id_identification($id);

                foreach ($etude_marche as $key => $value) 
                {
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->activite);
               

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":H".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":H".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->lieu_production);
                   

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":K".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":K".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->lieu_approvisionnement_intrant);
                   

                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":N".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->lieu_ecoulement_produit);
                    $ligne++;
                }
            //FIN ETUDE DE MARCHE

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":E".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Signature ou empreintes du membre de ménage");
           

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":J".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":J".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Le representant du comité de protection sociale");
               

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Le représentant de l'AGEX");

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
                    'risque' => $risque,
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
            'date_remplissage'                            => $this->post('date_remplissage'),
            'id_menage'                             => $this->post('id_menage'),                      
            'id_agex'                               => $this->post('id_agex'),                         
            'composition_menage'                    => $this->post('composition_menage'),                   
            'representant_comite_protection_social' => $this->post('representant_comite_protection_social'),                      
            'representant_agex'                     => $this->post('representant_agex')  
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