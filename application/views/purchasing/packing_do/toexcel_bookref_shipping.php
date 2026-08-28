<?php
/** PHPExcel_Writer_Excel2007 */


// Create new PHPExcel object
// echo date('H:i:s') . " Create new PHPExcel object\n";

$objPHPExcel    = new PHPExcel();

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
// Set properties
// echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


$style_col = array(  
    'font'      => array('bold' => FALSE,
                         'name' => 'Times New Roman',
                         'size' => '9'
                        ), // Set font nya jadi bold  
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' =>true, // Set text jadi ditengah secara horizontal (center)    
    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
 ),
'borders' => array(    
    'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
    'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
    'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

$WHS = array(  
    'font'      => array('bold' => TRUE,
                         'name' => 'Times New Roman',
                         'size' => '9'
                        ), // Set font nya jadi bold  
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'wrap' =>true, // Set text jadi ditengah secara horizontal (center)    
    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
 ),
'borders' => array(    
    'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
    'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
    'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);


$style_red = array(  
    'font'      => array('bold' => FALSE,
                         'name' => 'Times New Roman',
                         'color' => array('rgb' => 'FF0000'),
                         'size' => '9'
                        )
);

$fontt = array(  
    'font'      => array('bold' => true,
                         'name' => 'Times New Roman',
                         'color' => array('rgb' => '1b00e7'),
                         'size' => '14'
                        ),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'wrap' =>true, // Set text jadi ditengah secara horizontal (center)    
    'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
 ),
);



// // Add some data
// //PENGATURAN LEBAR
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


// //PENGATURAN TINGGI
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);

// //PENGATURAN MERGE CELL
$objPHPExcel->getActiveSheet()->mergeCells('B5:N5');          

    $objPHPExcel->getActiveSheet()->freezePane('A13');

//     // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $header1= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true, 'color' => array('rgb' => 'FF0000'),'name' => 'Times New Roman','size' => '12'), 

        );
    $header2= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true,'name' => 'Times New Roman','size' => '10'), 
        );
    $footer= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> false,'name' => 'Times New Roman','size' => '10'), 
        );
     $header3= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true,'name' => 'Times New Roman','size' => '14'), 
        );
    $garisheader1=array(
        'borders' => array(
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border top dengan garis tipis      
        )
    );
    $garisheader2=array(
        'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_MEDIUM) // Set border top dengan garis tipis      
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_red);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($header1);
    $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($header2);
    $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_red);
    $objPHPExcel->getActiveSheet()->getStyle('B5:N5')->applyFromArray($fontt);
    $objPHPExcel->getActiveSheet()->getStyle('B6:N6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);  
    $objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M6')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N6')->applyFromArray($style_col);

    $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('H1');
        $objDrawing->setHeight(80);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

    // $cust = $_GET['cust'];
    foreach ($book as $r) {
        $voyage= $r->voyage;
        $etdsin= $r->etdsin;
    }

     $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1','')
                ->setCellValue('B2','VOY '.$voyage)
                ->setCellValue('B3','ETD SIN : '.$etdsin)
                ->setCellValue('D2', '**RSUP**')
                ->setCellValue('D3', 'STUFFING')
                ->setCellValue('B5', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('A12', '')
                ->setCellValue('B6', 'CARRIER/SHIPPER')
                ->setCellValue('C6', 'C')
                ->setCellValue('D6', 'VESSEL/VOY')
                ->setCellValue('E6', 'ETA SIN')
                ->setCellValue('F6', '20')
                ->setCellValue('G6', '40')
                ->setCellValue('H6', 'BKG REF')
                ->setCellValue('I6', 'COLLECTION YD')
                ->setCellValue('J6', 'POD')
                ->setCellValue('K6', 'DESTINATION')
                ->setCellValue('L6', 'COLLECT DATE')
                ->setCellValue('M6', 'FACTORY/SHPMT DATE')
                ->setCellValue('N6', 'REMARKS');
                ;

    
        $counter = 7;
        $no = 1;
        foreach ($whs as $rr){
            $objPHPExcel->getActiveSheet()->getStyle('B'. $counter.':E' . $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('F'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('G'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('H'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('I'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('J'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('K'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('L'. $counter)->applyFromArray($WHS);
            $objPHPExcel->getActiveSheet()->getStyle('M'. $counter)->applyFromArray($WHS);  
            $objPHPExcel->getActiveSheet()->getStyle('N'. $counter)->applyFromArray($WHS);  
            $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':E' . $counter);          
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $counter,'Warehouse: '.$rr->name);
            $counter++;
            foreach ($book as $r) {
                $shipmentdate= $r->shipmentdate;
                $objPHPExcel->getActiveSheet()->getStyle('B'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$counter)->applyFromArray($style_col);

                if ($r->name==$rr->name) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$counter, $r->shipping_liner) 
                    ->setCellValue('C'.$counter, '') 
                    ->setCellValue('D'.$counter, $r->vessel)
                    ->setCellValue('E'.$counter, $r->etasin) 
                    ->setCellValue('F'.$counter, $r->c20)     
                    ->setCellValue('G'.$counter, $r->c40) 
                    ->setCellValue('H'.$counter, $r->reff) 
                    ->setCellValue('I'.$counter, $r->depot)
                    ->setCellValue('J'.$counter, $r->pod)
                    ->setCellValue('K'.$counter, $r->destination)
                    ->setCellValue('L'.$counter, $r->date_reqd)
                    ->setCellValue('M'.$counter, $r->date)
                    ->setCellValue('N'.$counter, $r->remarks)
                    ;
                     $counter++;
                }
            }
        }
        // $a=$counter+1;
        // $objPHPExcel->getActiveSheet()->getStyle('B'.$a)->applyFromArray($footer);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a,'BARGE');
        // $objPHPExcel->getActiveSheet()->getStyle('C'.$a)->applyFromArray($style_col);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a,$barge);
        // $objPHPExcel->getActiveSheet()->mergeCells('D'.$a.':E'.$a);
        // $objPHPExcel->getActiveSheet()->getStyle('D'.$a)->applyFromArray($footer);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a,'ETD');
        // $objPHPExcel->getActiveSheet()->mergeCells('F'.$a.':G'.$a);
        // $objPHPExcel->getActiveSheet()->getStyle('F'.$a.':G'.$a)->applyFromArray($style_col);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a,$etd);
        // $b=$a+1;
        // $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->applyFromArray($footer);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$b,'VOYAGE');
        // $objPHPExcel->getActiveSheet()->getStyle('C'.$b)->applyFromArray($style_col);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$b,$voyage);
        // $objPHPExcel->getActiveSheet()->mergeCells('D'.$b.':E'.$b);
        // $objPHPExcel->getActiveSheet()->getStyle('D'.$b)->applyFromArray($footer);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$b,'SHIPMENT DATE');
        // $objPHPExcel->getActiveSheet()->mergeCells('F'.$b.':G'.$b);
        // $objPHPExcel->getActiveSheet()->getStyle('F'.$b.':G'.$b)->applyFromArray($style_col);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$b,$date);
        

    // $objDrawing = new PHPExcel_Worksheet_Drawing();
    // $objDrawing->setName('test_img');
    // $objDrawing->setDescription('test_img');
    // $objDrawing->setPath('assets/ps.png');
    // $objDrawing->setCoordinates('D1');                      
    // $objDrawing->setOffsetX(50); 
    // $objDrawing->setOffsetY(5);                
    // //set width, height
    // $objDrawing->setWidth(160); 
    // $objDrawing->setHeight(90); 
    // $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Simple');
header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="BOOK ORDER '.$shipmentdate.'.xlsx"');        
// Save Excel 2007 file
//  " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save('php://output');



// Echo done
// echo date('H:i:s') . " Done writing file.\r\n";
