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

  $style_col1 = array(  
    'font'      => array('bold' => FALSE,
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



// // Add some data
// //PENGATURAN LEBAR
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


// //PENGATURAN TINGGI
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
    $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(5);
    $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(4);
    $objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(5);
    $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(19.5); 

// //PENGATURAN MERGE CELL          

    for($i=1;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':K'.$i);
        $objPHPExcel->getActiveSheet()->freezePane('A14');
    }


    $objPHPExcel->getActiveSheet()->mergeCells('C10:I10');
    $objPHPExcel->getActiveSheet()->mergeCells('B11:B13');
    $objPHPExcel->getActiveSheet()->mergeCells('C11:C13');
    $objPHPExcel->getActiveSheet()->mergeCells('D11:D13');
    $objPHPExcel->getActiveSheet()->mergeCells('E11:E13');
    $objPHPExcel->getActiveSheet()->mergeCells('F11:J11');
    $objPHPExcel->getActiveSheet()->mergeCells('F12:F13');
    $objPHPExcel->getActiveSheet()->mergeCells('G12:I12');
    $objPHPExcel->getActiveSheet()->mergeCells('J12:J13');
    $objPHPExcel->getActiveSheet()->mergeCells('K11:K13');

//     // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $header1= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true,'name' => 'Times New Roman','size' => '12'), 

        );
    $header2= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> false,'name' => 'Times New Roman','size' => '10'), 
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
    $objPHPExcel->getActiveSheet()->getStyle('C1:K1')->applyFromArray($header1);
    for($i=2;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->getStyle('C'.$i.':K'.$i)->applyFromArray($header2);

    }
    $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($garisheader1);
    $objPHPExcel->getActiveSheet()->getStyle('A8:K8')->applyFromArray($garisheader2);
    $objPHPExcel->getActiveSheet()->getStyle('A10:K10')->applyFromArray($header3);
    $objPHPExcel->getActiveSheet()->getStyle('B12:K12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B13:K13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B11:B13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C11:C13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D11:D13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E11:E13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F11:J11')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F12:F13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G12:I12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J12:J13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K11:K13')->applyFromArray($style_col);
    $cust = $_GET['cust'];

     $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1','PULAU SAMBU SINGAPORE PTE LTD')
                ->setCellValue('C2','Reg. Number : 201537276N')
                ->setCellValue('C3','19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909')
                ->setCellValue('C4', 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com')
                ->setCellValue('C5', 'www.sambugroup.com')
                ->setCellValue('C10', 'EMPTY CONTAINERS FOR EXPORT DEPARTMENT- '.$cust.' SHIPMENT')
                ->setCellValue('A11', '')
                ->setCellValue('B11', 'SUPPLIER')
                ->setCellValue('C11', 'ADDRESS')
                ->setCellValue('D11', 'DATE REQD')
                ->setCellValue('E11', 'TIME REQD')
                ->setCellValue('F11', 'CONTAINERS REQUIRED')
                ->setCellValue('F12', 'MAIN PO')
                ->setCellValue('G12', 'QTY')
                ->setCellValue('G13', '20`')
                ->setCellValue('H13', '40`')
                ->setCellValue('I13', '40 HC')
                ->setCellValue('J12', 'TYPE OF CARGO')
                ->setCellValue('K11', 'REMARKS');

                
                ;
        $sum_20 = 0;
        $sum_40 = 0;
        $sum_40HC = 0;
        foreach ($book as $r){ 
            $sum_20 += $r->sum_20_reqd;;
            $sum_40 += $r->sum_40_reqd;;
            $sum_40HC += $r->sum_40hc_reqd;;
            $cust=  $r->custid;
            $name=  $r->customercompany;
            $contact=  $r->contactperson;
            $bookref_no=  $r->bookref_no;
            $etd=  date("d-m-Y",  strtotime($r->etd));  
            $date=  date("d-m-Y",  strtotime($r->date));
            $barge=  $r->barge;
            $voyage=  $r->voyage;
            $ammend=  $r->ammend;
        }
        //menampilkan content dari data excel
        $counter = 14;
        $no = 1;
        foreach ($book as $r) {
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

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$counter, $r->vendorcompany) 
                ->setCellValue('C'.$counter, str_replace("<br />", "",$r->vendoraddress)) 
                ->setCellValue('D'.$counter, $r->date_reqd)
                ->setCellValue('E'.$counter, $r->time_reqd) 
                ->setCellValue('F'.$counter, $r->mainpo)     
                ->setCellValue('G'.$counter, $r->sum_20_reqd) 
                ->setCellValue('H'.$counter, $r->sum_40_reqd) 
                ->setCellValue('I'.$counter, $r->sum_40hc_reqd)
                ->setCellValue('J'.$counter, $r->description) 
                ->setCellValue('K'.$counter, $r->remarks) 
                ;
                 $counter++;
        }

        $z=$counter;

        if ($sum_20==0) {$sum_20='';}else{$sum_20=$sum_20.' X 20`';}
        if ($sum_40==0) {$sum_40='';}else{$sum_40=$sum_40.' X 40`';}
        if ($sum_40HC==0) {$sum_40HC='';}else{$sum_40HC=$sum_40HC.' X 40 HC';}

        $objPHPExcel->getActiveSheet()->mergeCells('F'.$z.':J'.$z);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$z.':J'.$z)->applyFromArray($style_col1);
        $objPHPExcel->setActiveSheetIndex(0)                
                ->setCellValue('F'.$z,'TOTAL CONTAINERS '.$sum_20.' '.$sum_40.' '.$sum_40HC);

        $objPHPExcel->getActiveSheet()->getStyle('K'.$z)->applyFromArray($style_col1);
        $objPHPExcel->setActiveSheetIndex(0)                
                ->setCellValue('K'.$z,'');

        $a=$z+2;
        $objPHPExcel->getActiveSheet()->getStyle('B'.$a)->applyFromArray($footer);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a,'BARGE');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$a)->applyFromArray($style_col);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a,$barge);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$a.':E'.$a);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$a)->applyFromArray($footer);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a,'ETD');
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$a.':G'.$a);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$a.':G'.$a)->applyFromArray($style_col);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a,$etd);
        $b=$a+1;
        $objPHPExcel->getActiveSheet()->getStyle('B'.$b)->applyFromArray($footer);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$b,'VOYAGE');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$b)->applyFromArray($style_col);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$b,$voyage);
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$b.':E'.$b);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$b)->applyFromArray($footer);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$b,'SHIPMENT DATE');
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$b.':G'.$b);
        $objPHPExcel->getActiveSheet()->getStyle('F'.$b.':G'.$b)->applyFromArray($style_col);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$b,$date);
        

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
header('Content-Disposition: attachment;filename="BOOKING '.$bookref_no.'.xlsx"');        
// Save Excel 2007 file
//  " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save('php://output');



// Echo done
// echo date('H:i:s') . " Done writing file.\r\n";
