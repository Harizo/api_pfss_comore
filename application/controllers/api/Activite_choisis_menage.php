<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Activite_choisis_menage extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('activite_choisis_menage_model', 'fpriManager');
        $this->load->model('menage_model', 'menageManager');

        $this->load->model('ile_model', 'ileManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('village_model', 'villageManager');
        $this->load->model('theme_formation_model', 'ThemeformationManager');
        $this->load->model('zip_model', 'ZipManager');
      
    }
    public function index_get() {

        $id_theme_formation_detail = $this->get('id_theme_formation_detail');
        $id_theme_formation = $this->get('id_theme_formation');

        $get_menage_beneficiaire = $this->get('get_menage_beneficiaire');

        $id_ile = $this->get('id_ile');
        $id_region = $this->get('id_region');
        $id_commune = $this->get('id_commune');
        $id_village = $this->get('id_village');




        $etat_export_excel = $this->get('etat_export_excel');
        $repertoire = $this->get('repertoire');

        $nom_file = "activitemenage"; 

        $data = array() ;
   
		if ($id_theme_formation && $id_village) 
        {
			
			$data = $this->fpriManager->get_all_by_theme_formation($id_theme_formation, $id_village);

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
                $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
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

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "LISTE DES MENAGES PAR ACTIVITES");

                $ligne+=2;

                $ile = $this->ileManager->findById($id_ile);
                $region = $this->RegionManager->findById($id_region);
                $commune = $this->CommuneManager->findById($id_commune);
                $village = $this->villageManager->findById($id_village);

                $zip = $this->ZipManager->findById($village->id_zip);

                $tf = $this->ThemeformationManager->findByIdobj($id_theme_formation);

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
                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre2);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "ACTIVITE : ".$tf->description);

                $ligne++;
                $reps = $this->fpriManager->get_nbr_menage($id_theme_formation, $id_village);

                $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->applyFromArray($titre1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Nombres des ménages : ".$reps[0]->nbr_menage);

                $ligne+=2;

                

                $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Identifiant");

                $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Chef du ménage");

                $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":I".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Nom du groupe");

                $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":L".$ligne);
                $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":L".$ligne)->applyFromArray($stylesousTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Sous-activité");

                $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);

                foreach ($data as $key => $value) 
                {
                    $ligne++;
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":L".$ligne)->getAlignment()->setWrapText(true);
                     $objPHPExcel->getActiveSheet()->getRowDimension($ligne)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":C".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":C".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->identifiant_menage);

                    $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":F".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":F".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nomchefmenage);

                    $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":I".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":I".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->groupe);

                    $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":L".$ligne);
                    $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":L".$ligne)->applyFromArray($stylecontenu);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->description_theme_formation_detail);
                }
                
               

            }
		} 

        if ($id_theme_formation_detail && $id_village) 
        {
            
            $data = $this->fpriManager->get_all_by_theme_formation_detail($id_theme_formation_detail, $id_village);
        } 


        if ($get_menage_beneficiaire && $id_village)
        {
            
            $data = $this->menageManager->get_menage_beneficiaire_par_village($id_village);                   
        }

        if ($etat_export_excel) 
        {
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
        $etat_save_all = $this->post('etat_save_all') ;
		$data = array(
			

            'id_theme_formation'             => $this->post('id_theme_formation'),
            'id_menage'                             => $this->post('id_menage')
		);   

        if ($etat_save_all) 
        {
            $all_menage =  json_decode($this->post('all_menage'));

            foreach ($all_menage as $key => $value) 
            {
                $data = array(

                    'id_theme_formation'             => $this->post('id_theme_formation'),
                    'id_menage'                             => $value->id_menage
                );  

                $dataId = $this->fpriManager->add($data);

                if (count($all_menage) == ($key+1)) 
                {
                    $this->response([
                            'status' => TRUE,
                            'response' => $all_menage,
                            'message' => 'Data insert success'
                                ], REST_Controller::HTTP_OK);
                }
            }
        }    
        else
        {

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
            } 
            else 
            {
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
}
?>