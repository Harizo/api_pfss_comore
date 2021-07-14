<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Export_excel_profilage_orientation extends REST_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('fiche_profilage_orientation_entete_model', 'Fiche_profilage_orientation_enteteManager');
        $this->load->model('ile_model', 'IleManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('village_model', 'VillageManager');
        $this->load->model('zip_model', 'ZipManager');
        $this->load->model('connaissance_experiance_menage_entete_model', 'Connaissance_experiance_menage_enteteManager');
        $this->load->model('connaissance_experience_menage_detail_model', 'Connaissance_experience_menage_detailManager');
        $this->load->model('fiche_profilage_ressource_model', 'Fiche_profilage_ressourceManager');
        $this->load->model('fiche_profilage_orientation_model', 'Fiche_profilage_orientationManager');
        $this->load->model('fiche_profilage_besoin_formation_model', 'Fiche_profilage_besoin_formationManager');
        $this->load->model('theme_formation_model', 'Theme_formationManager');
        
    }
   
    public function index_get() 
    {   
        set_time_limit(0);
        ini_set ('memory_limit', '4000M');
        $menu = $this->get('menu');
        
        $id_village = $this->get('id_village');
        $repertoire = $this->get('repertoire');
        $data_tete = $this->get('data_entete');
        $decoupage = $this->get('decoupage');

        $data = array() ;
        $decoupages=json_decode($decoupage, false); 
       $data_entete=json_decode($data_tete, false);      
       $ile = $this->IleManager->findById($decoupages->id_ile);  
       $region = $this->RegionManager->findById($decoupages->id_region);  
       $commune = $this->CommuneManager->findById($decoupages->id_commune);  
       $village = $this->VillageManager->findById($decoupages->id_village);  
       $zip = $this->ZipManager->findById($decoupages->id_zip);

       $connaissance_experiance_menage_entete = $this->Connaissance_experiance_menage_enteteManager->findByprofilage_objet($data_entete->id);

       $connaissance_experience_menage_detail = $this->Connaissance_experience_menage_detailManager->findByficheprofilage($data_entete->id);             
       $fiche_profilage_ressource = $this->Fiche_profilage_ressourceManager->getfiche_profilage_ressourceByentete($data_entete->id);     
       $fiche_profilage_orientation = $this->Fiche_profilage_orientationManager->getfiche_profilage_orientationByentete($data_entete->id);
       $tmp_besoin = $this->Fiche_profilage_besoin_formationManager->getfiche_profilage_besoin_formationByentete($data_entete->id);
       $type_formation=array();
       if ($tmp_besoin) 
       {   
           foreach ($tmp_besoin as $key => $value)
           {   
               $type_formation = $this->Theme_formationManager->findByIdobj($value->id_type_formation);
               $fiche_profilage_besoin[$key]['id']         = $value->id;
               $fiche_profilage_besoin[$key]['profile']= $value->profile;
               $fiche_profilage_besoin[$key]['objectif']= $value->objectif;
               $fiche_profilage_besoin[$key]['duree']= $value->duree;
               $fiche_profilage_besoin[$key]['type_formation'] = $type_formation;
           }
       }		 
        
        //********************************* fin Nombre echantillon *****************************
        if ($menu=='getdonneeexporter') //mande       
        {   
            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
            if ($tmp) 
            {
                $data =$tmp;
            } 
            else
            {
                    $data = array();
            }

        }
        $export=$this->export_excel($repertoire,$data_entete,$ile,$commune,$region,$village,$zip,$connaissance_experiance_menage_entete,$connaissance_experience_menage_detail,$fiche_profilage_ressource,$fiche_profilage_orientation,$fiche_profilage_besoin);
       /* $this->response([
            'status' => TRUE,
            'response' => $repertoire,
            'message' => 'No data were found'
        ], REST_Controller::HTTP_OK);
        if (count($data)>0) 
        {
        
            $export=$this->export_excel($repertoire,$data);

        } else {
            $this->response([
                'status' => FALSE,
                'response' => $repertoire,
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }*/
    }

   
    public function export_excel($repertoire,$data_entete,$ile,$commune,$region,$village,$zip,$connaissance_experiance_menage_entete,$connaissance_experience_menage_detail,$fiche_profilage_ressource,$fiche_profilage_orientation,$fiche_profilage_besoin)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';      

        $nom_file='fiche_profilage_orientation';
        $directoryName = dirname(__FILE__) ."/../../../../exportexcel/".$repertoire;
            
            //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
            
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Myexcel")
                    ->setLastModifiedBy("Me")
                    ->setTitle("FICHE DE PROFILAGE ET ORIENTATION ")
                    ->setSubject("FICHE DE PROFILAGE ET ORIENTATION ")
                    ->setDescription("FICHE DE PROFILAGE ET ORIENTATION ")
                    ->setKeywords("FICHE DE PROFILAGE ET ORIENTATION ")
                    ->setCategory("FICHE DE PROFILAGE ET ORIENTATION ");

        $ligne=5;           
            // Set Orientation, size and scaling
            // Set Orientation, size and scaling
            
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            
        //$objPHPExcel->getActiveSheet()->setTitle("FICHE DE PROFILAGE ET ORIENTATION ");

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

        $styleGras = array
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
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 12
            ),
        );
        $styleTitre = array
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
                'name'  => 'Calibri',
                'bold'  => true,
                'size'  => 11
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
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
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
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            ),
        );
        
        $stylecontenu_bordertopright = array
        (
            'borders' => array
            (
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );
   
        $stylecontenu_borderright = array
        (
            'borders' => array
            (                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );
            
        $styletitre_bordertopright = array
        (
            'borders' => array
            (
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                'bold'  => true,
                'size'  => 11
            )
        );
   
        $styletitre_borderright = array
        (
            'borders' => array
            (                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                'bold'  => true,
                'size'  => 11
            )
        );
        $styletitre_borderbottom = array
        (
            'borders' => array
            (                
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 11
            )
        );
        $styletitre_borderbottomright = array
        (
            'borders' => array
            (                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                'bold'  => true,
                'size'  => 11
            )
        );
        $stylecontenu_borderbottomright = array
        (
            'borders' => array
            (                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 11
            )
        );
        $styletitre_borderbottomleft = array
        (
            'borders' => array
            (                
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                'bold'  => true,
                'size'  => 11
            )
        );
        $stylecontenu_borderbottomleft = array
        (
            'borders' => array
            (                
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 11
            )
        );
        
        $stylecontenu_bordertopleftbottom = array
        (
            'borders' => array
            (
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );
        
        $stylecontenu_bordertoprightbottom = array
        (
            'borders' => array
            (                
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),                
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );
        $stylecontenu_bordertopbottom = array
        (
            'borders' => array
            (                
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),               
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );
        $stylecontenu_bordertopbottomalignleft = array
        (
            'borders' => array
            (                
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),               
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$ligne, "FICHE DE PROFILAGE ET ORIENTATION ");
//entete
        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "1.AGEX");

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_bordertopright);
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Date du remplissage :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $data_entete->date_remplissage);

        $ligne++;
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleTitre);        
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nom AGEX :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $data_entete->agex->Nom);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Nom de l'ADC :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $data_entete->agex->nom_contact_agex);
        
        $ligne++;       
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "ZIP :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $zip->libelle);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Contact :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $data_entete->agex->numero_phone_contact);

 //localisation       
        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "2. LOCALISATION DU MENAGE");

        
        $ligne++;        
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_bordertopright);
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Ile:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $ile->Ile);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Village:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $village->Village);

        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Préfécture :");
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $region->Region);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Quartier :");
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, '');
        
        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Commune :");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $commune->Commune);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Code du ménage :");
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $data_entete->menage->identifiant_menage);

 //situation famillial      
        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "3. SITUATION FAMILIALE");

        
        $ligne++;        
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_bordertopright);
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nom et prénom du chef de ménage:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $data_entete->menage->nomchefmenage);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Age:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $data_entete->menage->agechefdemenage);

        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Catégorie du ménage :");
        
        $categorie = '';
        if ($data_entete->menage->inapte)
        {
            switch (intval($data_entete->menage->inapte))
            {
                case 1:
                    $categorie = 'Apte';
                    break;
                case 2:                    
                    $categorie = 'Inapte';
                    break;
                default:
                    $categorie = '';
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $categorie);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Situation matrimoniale:");

        $situation_matri = '';
        if ($data_entete->menage->situation_matrimoniale)
        {
            switch (intval($data_entete->menage->situation_matrimoniale))
            {
                case 1:
                    $situation_matri = 'Célibataire';
                    break;
                case 2:                    
                    $situation_matri = 'marié(e)';
                    break;
                case 3:
                    $situation_matri = 'veuf(ve)';
                    break;
                case 4:                    
                    $situation_matri = 'divorcé(e)';
                    break;
                default:
                    $situation_matri = '';
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $situation_matri);
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, '');
        
        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu_borderright);   
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Composition du ménage:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, 'Féminin '.$data_entete->menage->nbr_feminin.' Féminin '.$data_entete->menage->nbr_masculin);

//CONNAISSANCE ET D'EXPERIENCE DU MENAGE      
       $ligne++;
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "4. CONNAISSANCE ET D'EXPERIENCE DU MENAGE");

       
       $ligne++;        
       $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":L".$ligne)->applyFromArray($styleTitre);
       //$objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($styletitre_borderright);
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":c".$ligne)->applyFromArray($stylecontenu_bordertopleftbottom);
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Niveau de formation du ménage:");
       $niveau_format = '';
        if ($connaissance_experiance_menage_entete->niveau_formation)
        {
            switch (intval($connaissance_experiance_menage_entete->niveau_formation))
            {
                case 1:
                    $niveau_format = 'Primaire';
                    break;
                case 2:                    
                    $niveau_format = 'Secondaire';
                    break;
                case 3:
                    $niveau_format = 'Universitaire';
                    break;
                case 4:                    
                    $niveau_format = $connaissance_experiance_menage_entete->autre_niveau_formation;
                    break;
                default:
                    $niveau_format = '';
            }
        }
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_bordertoprightbottom);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $niveau_format);
       $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Activités rélisées auparavant:");
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Difficultés rencontrées:");
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Nombre d'années d'actvités:");
       $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":L".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Formation acquise:");
       //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $data_entete[]);

       $ligne++;
      /* $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":H".$ligne)->applyFromArray($stylecontenu_borderright);   
       $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu_borderright);
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Catégorie du ménage :");*/
        


       // $ligne++;
        $ligne_con = $ligne + 11;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne_con);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":D".$ligne_con)->applyFromArray($styleTitre);
        $connaissance_experience_menage_agriculture=array();        
        $connaissance_experience_menage_elevage=array();       
        $connaissance_experience_menage_peche=array();        
        $connaissance_experience_menage_petitcommerce=array();        
        $connaissance_experience_menage_restauration=array();       
        $connaissance_experience_menage_artisanat=array();        
        $connaissance_experience_menage_autres=array();        
        $connaissance_experience_menage_neant=array();

        foreach ($connaissance_experience_menage_detail as $value)
        {
            if ($value->id_activite_realise_auparavant_prevu =='1')
            {
                $connaissance_experience_menage_agriculture=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='2')
            {
                $connaissance_experience_menage_elevage=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='3')
            {
                $connaissance_experience_menage_peche=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='4')
            {
                $connaissance_experience_menage_petitcommerce=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='5')
            {
                $connaissance_experience_menage_restauration=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='6')
            {
                $connaissance_experience_menage_artisanat=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='7')
            {
                $connaissance_experience_menage_autres=$value;
            }
            if ($value->id_activite_realise_auparavant_prevu =='8')
            {
                $connaissance_experience_menage_neant=$value;
            }
        }
    
    //agricuture
        $ligne_agri = $ligne+2;   
        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne_agri)->applyFromArray($stylecontenu_bordertopbottom);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_agriculture->activite_realise_auparavant_description); 
        
        
        if ($connaissance_experience_menage_agriculture->id)
        {   
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
        }  
        
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne_agri)->applyFromArray($stylecontenu_borderbottomleft);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_agriculture->difficulte_rencontre);
        $nbr_annee_activi = '';
        if ($connaissance_experience_menage_agriculture->nbr_annee_activite)
        {
            switch (intval($connaissance_experience_menage_agriculture->nbr_annee_activite))
            {
                case 1:
                    $nbr_annee_activi = 'Moins 1 an';
                    break;
                case 2:                    
                    $nbr_annee_activi = '1 an';
                    break;
                case 3:
                    $nbr_annee_activi = '2 ans';
                    break;
                case 4:                    
                    $nbr_annee_activi = 'Plus 3 ans';
                    break;
                default:
                    $nbr_annee_activi = '';
            }
        } 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".$ligne_agri)->applyFromArray($stylecontenu_borderbottomleft);
        $formation_agric = array();
        if ($connaissance_experience_menage_agriculture->formation_acquise)
        {            
            $formation_agric=unserialize($connaissance_experience_menage_agriculture->formation_acquise);
        }

        
        //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylecontenu_bordertopbottomalignleft);        
        //$objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu_bordertoprightbottom);
        $formation_mar =in_array('mar',$formation_agric);
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".$ligne_agri)->applyFromArray($stylecontenu_borderbottomleft);
        if ($formation_mar==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Maraichage');

        $formation_pep =in_array('pep',$formation_agric);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright);
        if ($formation_pep==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Pépinière');

        $ligne++;
        $formation_cul =in_array('cul',$formation_agric);
        if ($formation_cul==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Culture vivrière');

        $formation_tra_act1 =in_array('tra_act1',$formation_agric);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright);
        if ($formation_tra_act1==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Transformation');
        
        $ligne++;
        $formation_aut_act1 =in_array('aut_act1',$formation_agric);
        if ($formation_aut_act1==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Autres');        
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);
        
        $ligne++;
    //elevage
        $ligne_elev = $ligne+1;   
        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne_elev)->applyFromArray($stylecontenu_bordertopbottom);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_elevage->activite_realise_auparavant_description); 
        
        
        if ($connaissance_experience_menage_elevage->id)
        {   
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
        }  
        
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne_elev)->applyFromArray($stylecontenu_borderbottomleft);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_elevage->difficulte_rencontre);
        $nbr_annee_activi = '';
        if ($connaissance_experience_menage_elevage->nbr_annee_activite)
        {
            switch (intval($connaissance_experience_menage_elevage->nbr_annee_activite))
            {
                case 1:
                    $nbr_annee_activi = 'Moins 1 an';
                    break;
                case 2:                    
                    $nbr_annee_activi = '1 an';
                    break;
                case 3:
                    $nbr_annee_activi = '2 ans';
                    break;
                case 4:                    
                    $nbr_annee_activi = 'Plus 3 ans';
                    break;
                default:
                    $nbr_annee_activi = '';
            }
        } 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".$ligne_elev)->applyFromArray($stylecontenu_borderbottomleft);
        $formation_elev = array();
        if ($connaissance_experience_menage_elevage->formation_acquise)
        {         
            $formation_elev=unserialize($connaissance_experience_menage_elevage->formation_acquise);
        }
        
        //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylecontenu_bordertopbottomalignleft);        
        //$objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu_bordertoprightbottom);
        $formation_cap =in_array('cap',$formation_elev);
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".$ligne_elev)->applyFromArray($stylecontenu_borderbottomleft);
        if ($formation_mar==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Caprin');

        $formation_avi =in_array('avi',$formation_elev);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright);
        if ($formation_avi==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Aviculture');

        $ligne++;
        $formation_bov =in_array('bov',$formation_elev);
        if ($formation_cul==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Bovin');

        $formation_aut_act2 =in_array('aut_act2',$formation_elev);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright);
        if ($formation_aut_act2==true)
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('R');
            $checkbox->getFont()->setName('Wingdings 2');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }
        else
        {
            $objRichText = new PHPExcel_RichText();
            $checkbox = $objRichText->createTextRun('☐');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
        }        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Autres');
               
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);
    

        $ligne++;
//peche
            $ligne_pec = $ligne+1;   
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne_pec)->applyFromArray($stylecontenu_bordertopbottom);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_peche->activite_realise_auparavant_description); 
            
            
            if ($connaissance_experience_menage_peche->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne_pec)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_peche->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_peche->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_peche->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".$ligne_pec)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_peche->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_peche->formation_acquise);
            }
            
            //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":J".$ligne)->applyFromArray($stylecontenu_bordertopbottomalignleft);        
            //$objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu_bordertoprightbottom);
            $formation_tec =in_array('tec',$formation_pech);
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".$ligne_pec)->applyFromArray($stylecontenu_borderbottomleft);
            if ($formation_tec==true)
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
            }        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Technique de pêche');
    
            $formation_tra_act3 =in_array('tra_act3',$formation_pech);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright);
            if ($formation_tra_act3==true)
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $objRichText);
            }        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, 'Transformation');
    
            $ligne++;
            $formation_aut_act3 =in_array('aut_act3',$formation_pech);
            if ($formation_aut_act3==true)
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $objRichText);
            }        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, 'Autres');    
                   
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);

            $ligne++;
//petite commerce  
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu_bordertopbottom);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_petitcommerce->activite_realise_auparavant_description); 
            
            
            if ($connaissance_experience_menage_petitcommerce->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_petitcommerce->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_petitcommerce->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_petitcommerce->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_petitcommerce->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_petitcommerce->formation_acquise);
            }            
           
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright); 
                   
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);


            $ligne++;
//restauration  
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu_bordertopbottom);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_restauration->activite_realise_auparavant_description); 
            
            
            if ($connaissance_experience_menage_restauration->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_restauration->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_restauration->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_restauration->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_restauration->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_restauration->formation_acquise);
            }            
           
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright); 
                   
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);

            $ligne++;
//artisanat  
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu_bordertopbottom);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_artisanat->activite_realise_auparavant_description); 
            
            
            if ($connaissance_experience_menage_artisanat->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_artisanat->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_artisanat->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_artisanat->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_artisanat->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_artisanat->formation_acquise);
            }            
           
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright); 
                   
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);
    

            $ligne++;
//autre  
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu_bordertopbottom); 
            
            
            if ($connaissance_experience_menage_autres->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_autres->activite_realise_auparavant_description.': '.$connaissance_experience_menage_autres->autre_activite_realise_auparavant);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_autres->activite_realise_auparavant_description);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_autres->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_autres->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_autres->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_autres->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_autres->formation_acquise);
            }            
           
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright); 
                   
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);


            $ligne++;
//neant  
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":F".$ligne)->applyFromArray($stylecontenu_bordertopbottom);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $connaissance_experience_menage_neant->activite_realise_auparavant_description); 
            
            
            if ($connaissance_experience_menage_neant->id)
            {   
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('R');
                $checkbox->getFont()->setName('Wingdings 2');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }
            else
            {
                $objRichText = new PHPExcel_RichText();
                $checkbox = $objRichText->createTextRun('☐');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $objRichText);
            }  
            
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $connaissance_experience_menage_neant->difficulte_rencontre);
            $nbr_annee_activi = '';
            if ($connaissance_experience_menage_neant->nbr_annee_activite)
            {
                switch (intval($connaissance_experience_menage_neant->nbr_annee_activite))
                {
                    case 1:
                        $nbr_annee_activi = 'Moins 1 an';
                        break;
                    case 2:                    
                        $nbr_annee_activi = '1 an';
                        break;
                    case 3:
                        $nbr_annee_activi = '2 ans';
                        break;
                    case 4:                    
                        $nbr_annee_activi = 'Plus 3 ans';
                        break;
                    default:
                        $nbr_annee_activi = '';
                }
            } 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $nbr_annee_activi);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            $formation_pech = array();
            if ($connaissance_experience_menage_neant->formation_acquise)
            {
                $formation_pech=unserialize($connaissance_experience_menage_neant->formation_acquise);
            }            
           
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu_borderbottomleft);
            
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderright); 
                   
            $objPHPExcel->getActiveSheet()->getStyle("j".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styletitre_borderbottom);
            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu_borderbottomright);


//RESSOURCES DISPONIBLES     
       $ligne++;
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "5. RESSOURCES DISPONIBLES");

       
       $ligne++;        
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Désignation");

       $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Quantité");

       $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Etat");
       
       $ligne++;
       foreach ($fiche_profilage_ressource as $key => $value)
       {
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":D".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->designation);
    
            $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->quantite);
    
            $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->etat);
            $ligne++;
       }

//6. ORIENTATION (à remplir l'AGEX)     
$ligne++;
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "6. ORIENTATION (à remplir l'AGEX)");

       
       $ligne++;        
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Activités");

       $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "Types d'activités choisies");

       $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Secteur");

       $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Groupe");
       
       $ligne++;
       foreach ($fiche_profilage_orientation as $key => $value)
       {    
           $type_acti='';
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->activite);
            if (intval($value->type_activite)==1)
            {
                $type_acti='Acivités productives';
            }
            if (intval($value->type_activite)==2)
            {
                $type_acti='Formation';
            }
            $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $type_acti);
    
            $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->secteur);
    
            $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->groupe);
            $ligne++;
       }

//BESOIN EN FORMATION     
       $ligne++;
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleGras);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "7. BESOIN EN FORMATION");

       
       $ligne++;        
       $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
       $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Type de formation");

       $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "Profile du bénéficiaire");

       $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Objectif de la formation");

       $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
       $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Durée de la formation");
       
       $ligne++;
       foreach ($fiche_profilage_besoin as $key => $value)
       {
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value['type_formation']->description);
    
            $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":D".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value['profile']);
    
            $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":F".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value['objectif']);
    
            $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":L".$ligne);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value['duree']);
            $ligne++;
       }
        /*        
            $ligne++;*/
        
        
    

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) ."/../../../../exportexcel/fiche_profilage_orientation/".$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' =>$nom_file.".xlsx",
                'response' =>$fiche_profilage_besoin,
                'message' => 'Get file success',
            ], REST_Controller::HTTP_OK);
          
        } 
        catch (PHPExcel_Writer_Exception $e)
        {
            $this->response([
                  'status' => FALSE,
                   'nom_file' => $key,
                   'message' => "Something went wrong: ". $e->getMessage(),
                ], REST_Controller::HTTP_OK);
        }

    }   
    


}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>