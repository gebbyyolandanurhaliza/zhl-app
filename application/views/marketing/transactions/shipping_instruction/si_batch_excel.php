<?php
/** PHPExcel_Writer_Excel2007 */


// Create new PHPExcel object
// echo date('H:i:s') . " Create new PHPExcel object\n";

$objPHPExcel    = new PHPExcel();

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

// // Add some data
// //PENGATURAN LEBAR
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(3.5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);


// //PENGATURAN TINGGI
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
    $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(5);
    $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(4);
    $objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(5);
    $objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(19.5); 
    $objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(28); 
    $objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(22); 

// //PENGATURAN MERGE CELL          

    for($i=1;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':L'.$i);
        $objPHPExcel->getActiveSheet()->freezePane('A13');
    }
     $objPHPExcel->getActiveSheet()->mergeCells('C10:Q10');

    $header1= array(
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ),// Set text jadi di tengah secara horizontal (middle)  ), 
        'font'=> array('bold'=> true,'name' => 'Times New Roman','size' => '12'), 

        );
    $header2= array(
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
    $objPHPExcel->getActiveSheet()->getStyle('C1:L1')->applyFromArray($header1);
    for($i=2;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->getStyle('C'.$i.':L'.$i)->applyFromArray($header2);

    }
    $objPHPExcel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($garisheader1);
    $objPHPExcel->getActiveSheet()->getStyle('A8:L8')->applyFromArray($garisheader2);
    $objPHPExcel->getActiveSheet()->getStyle('A10:L10')->applyFromArray($header3);
    $objPHPExcel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K12')->applyFromArray($style_col);

//     //ISI HEADER CELL  
    
     $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1','ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('C2','Reg. Number : 201434570K')
                ->setCellValue('C3','75 Bukit Timah Road, #05-01 Boon Siew Building, Singapore 229833')
                ->setCellValue('C4', 'T: 6955 8298 F: 6980 2095')
                
               
                ->setCellValue('B12', 'Schedule Shipment Date')
	            ->setCellValue('C12', 'Sequence Num.')
	            ->setCellValue('D12', "Buyer Ref")
	            ->setCellValue('E12', "Po Number ")
	            ->setCellValue('F12', 'S. Contract No')
	            ->setCellValue('G12', 'S. Contract No')
	            ->setCellValue('H12', 'Customer')
	            ->setCellValue('I12', 'Ocean Freight')
	            ->setCellValue('J12', 'SBL Fee')
	            ->setCellValue('K12', 'PSS`s Invoice No');

                
                ;
        //menampilkan content dari data excel
        $counter = 13;
        $no = 1;
        
        foreach ($record as $r) {
                

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
                    ->setCellValue('B' . $counter, tgl_ind($r->schedule_date))
                    ->setCellValue('C' . $counter, $r->urut_container)
                    ->setCellValue('D' . $counter, $r->reff)
                    ->setCellValue('E' . $counter, $r->po_number)
                    ->setCellValue('F' . $counter, $r->contract_no)
                    ->setCellValue('G' . $counter, $r->factory_abbr)
                    ->setCellValue('H' . $counter, $r->customer_company_name)
                    ->setCellValue('I' . $counter, $r->prices_freight)
                    ->setCellValue('J' . $counter, '')
                    ->setCellValue('K' . $counter, $r->invno);
                 $counter++;
        }
        
            

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('KOP');
    $objDrawing->setDescription('KOP');
    $objDrawing->setPath('assets/ZHL-Report.png');
    $objDrawing->setCoordinates('D1');                      
    $objDrawing->setOffsetX(150); 
    $objDrawing->setOffsetY(1);  
    $objDrawing->setWidth(160); 
    $objDrawing->setHeight(90); 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->setTitle('Simple');
header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SI Monitoring().xlsx"');        
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');
