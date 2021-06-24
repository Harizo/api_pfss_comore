<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Fiche_travailleur extends REST_Controller {
    public function __construct() {
        parent::__construct();
       
        $this->load->model('menage_model', 'menageManager');
        $this->load->model('requete_export_model', 'remManager');

        $this->load->model('ile_model', 'ileManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'villageManager');
        $this->load->model('zip_model', 'ZipManager');
      
    }
    public function index_get() {

 

        $id_ile = $this->get('id_ile');
        $id_region = $this->get('id_region');
        $id_commune = $this->get('id_commune');
        $id_village = $this->get('id_village');




        $etat_export_excel = $this->get('etat_export_excel');
        $repertoire = $this->get('repertoire');

        $nom_file = "fichetravailleur"; 

        $data = array() ;
   
		
			
			$data = $this->menageManager->get_travailleur($id_village);
			

            if ($etat_export_excel) 
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
                $objPHPExcel->getProperties()->setCreator("App WEB MIS")
                            ->setLastModifiedBy("App WEB MIS")
                            ->setTitle("App WEB MIS")
                            ->setSubject("App WEB MIS")
                            ->setDescription("App WEB MIS")
                            ->setKeywords("App WEB MIS")
                            ->setCategory("App WEB MIS");

                $ligne=1; 

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
                        'name'  => 'Times New Roman',
                        'bold'  => true,
                        'size'  => 14
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
                        'size'  => 12
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
                        'size'  => 12
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
                        'size'  => 12
                    ),
                );

                $stylesousTitreleft = array
                (   
                    'borders' => array
                    (
                        'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                    ),
                    'alignment' => array
                    (
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        
                    ),
                    'font' => array
                    (
                        'name'  => 'Times New Roman',
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


                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
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

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "LISTE DES TRAVAILLEURS PRINCIPAUX ET SUPLEANTS (ACT)");

                $ligne+=2;

                $ile = $this->ileManager->findById($id_ile);
                $region = $this->RegionManager->findById($id_region);
                $commune = $this->CommuneManager->findById($id_commune);
                $village = $this->villageManager->findById($id_village);

                $zip = $this->ZipManager->findById($village->id_zip);


                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Ile : ".$ile->Ile);

                $ligne++;
                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Préfecture : ".$region->Region);

                $ligne++;
                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Commune : ".$commune->Commune);

                $ligne++;
                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Village : ".$village->Village);

                $ligne++;
                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "ZIP : ".$zip->libelle);

                $ligne++;
                //$objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Vague : ".$village->vague);

                $ligne++;

                $nbr_beneficiaire = $this->menageManager->get_nbr_menage_beneficiaire_by_village_sousprojet($id_village);

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($stylesousTitreleft);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nombre de ménage bénéficiaire: ".$nbr_beneficiaire[0]->nbr);

                

                $ligne++;

                $nbr_travalleur_par_sexe = $this->remManager->Nombre_travailleur_par_sexe(2,$id_village);

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($stylesousTitreleft);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nombre de travailleurs principaux femmes: ".$nbr_travalleur_par_sexe[0]->nombre_travailleur_femme);

                

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":N".$ligne)->applyFromArray($stylesousTitreleft);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Nombre de travailleurs principaux hommes: ".$nbr_travalleur_par_sexe[0]->nombre_travailleur_homme);

                $ligne++;

                $nbr_travalleur_par_sexe = $this->remManager->Nombre_travailleur_par_sexe(2,$id_village);

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":G".$ligne)->applyFromArray($stylesousTitreleft);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nombre de travailleurs supléant femmes: ".$nbr_travalleur_par_sexe[0]->nombre_suppleant_femme);

                

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":N".$ligne)->applyFromArray($stylesousTitreleft);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Nombre de travailleurs supléant hommes: ".$nbr_travalleur_par_sexe[0]->nombre_suppleant_homme);

                $ligne+=2;

                

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "");

                $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":G".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("C".$ligne.":G".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "Travailleur Principal");

                $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":N".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":N".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Travailleur Supléant");

                $ligne++;
                //principal
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Identifiant de ménage");

                    $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":E".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("C".$ligne.":E".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "Nom et prénom");

                    
                    $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Sexe");

                    $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "CIN");
                //fin principal

                //suppleant
                    $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Nom et prénom");



                    
                    $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Sexe");

                    $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylesousTitre);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "CIN");
                //fin suppleant

               // $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":N".$ligne)->getAlignment()->setWrapText(true)

                foreach ($data as $key => $value) 
                {
                    $ligne++;
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);

                    //principal
                        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->identifiant_menage);

                        $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":E".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("C".$ligne.":E".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->NomTravailleur);

                        
                        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, ($value->SexeTravailleur));

                        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->numerocintravailleur);
                    //fin principal

                    //suppleant
                        $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":L".$ligne);
                        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->NomTravailleurSuppliant);



                        
                        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, ($value->SexeTravailleurSuppliant));

                        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->numerocinsuppliant);
                    //fin suppleant

                   
                }
                
               

            }
		 


   
        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
           // $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
            $objWriter->save(dirname(__FILE__) . "/../../../../exportexcel/".$repertoire.$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nbr_beneficiaire' => $nbr_beneficiaire,
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

 

   
}
?>