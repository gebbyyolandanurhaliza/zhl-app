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
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(45);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);


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
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':R'.$i);
        $objPHPExcel->getActiveSheet()->freezePane('A14');
    }
     $objPHPExcel->getActiveSheet()->mergeCells('C10:R10');

    $objPHPExcel->getActiveSheet()->mergeCells('B12:B13');
    $objPHPExcel->getActiveSheet()->mergeCells('C12:C13');
    $objPHPExcel->getActiveSheet()->mergeCells('D12:D13');
    $objPHPExcel->getActiveSheet()->mergeCells('E12:E13');
    $objPHPExcel->getActiveSheet()->mergeCells('F12:F13');
    $objPHPExcel->getActiveSheet()->mergeCells('G12:G13');
    $objPHPExcel->getActiveSheet()->mergeCells('H12:H13');
    $objPHPExcel->getActiveSheet()->mergeCells('I12:I13');
    $objPHPExcel->getActiveSheet()->mergeCells('J12:J13');
    $objPHPExcel->getActiveSheet()->mergeCells('K12:P12');
    $objPHPExcel->getActiveSheet()->mergeCells('P12:Q12');
    $objPHPExcel->getActiveSheet()->mergeCells('Q12:R12');

//     // Apply style header yang telah kita buat tadi ke masing-masing kolom header
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
    $objPHPExcel->getActiveSheet()->getStyle('C1:R1')->applyFromArray($header1);
    for($i=2;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->getStyle('C'.$i.':R'.$i)->applyFromArray($header2);

    }
    $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($garisheader1);
    $objPHPExcel->getActiveSheet()->getStyle('A8:R8')->applyFromArray($garisheader2);
    $objPHPExcel->getActiveSheet()->getStyle('A10:R10')->applyFromArray($header3);
    $objPHPExcel->getActiveSheet()->getStyle('B12:R12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('B12:B13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C12:C13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D12:D13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E12:E13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F12:F13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G12:G13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H12:H13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I12:I13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J12:J13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('O13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('P13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q13')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('R13')->applyFromArray($style_col);

     $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1','ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('C2','Reg. Number : 201537276N')
                ->setCellValue('C3','39 WOODLANDS CLOSE #02-07/08 MEGA@WOODLANDS, SINGAPORE 737856')
                ->setCellValue('C4','E-mail : booking@zhenghe.com.sg / shipping@zhenghe.com.sg')
                ->setCellValue('C5', '')
                ->setCellValue('C10', 'MASTER FREIGHT CHARGES')
                ->setCellValue('A12', '')
                ->setCellValue('B12', 'No')
                ->setCellValue('C12', 'Countdown Expiry')
                ->setCellValue('D12', 'Notification')
                ->setCellValue('E12', 'Container Number')
                ->setCellValue('F12', 'Port Name')
                ->setCellValue('G12', 'Country Name')
                ->setCellValue('H12', 'Trading Term')
                ->setCellValue('I12', 'Validity From')
                ->setCellValue('J12', 'Validity Untill')
                ->setCellValue('K12', 'Vendor Prices')
                ->setCellValue('K13', 'Shipping Line 1')
                ->setCellValue('L13', 'Rate 1')
                ->setCellValue('M13', 'Shipping Line 2')
                ->setCellValue('N13', 'Rate 2')
                ->setCellValue('O13', 'Shipping Line 3')
                ->setCellValue('P13', 'Rate 3')
                ->setCellValue('Q12', 'Customer Prices')
                ->setCellValue('Q13', 'Consignee (Link Marketing)')
                ->setCellValue('R13', 'Rate 1 (Link Marketing)');


                
                ;
        //menampilkan content dari data excel
        $counter = 14;
        $no = 1;
        foreach ($freight as $r) {
            if ($r->kadaluarsa <= '7'){
                $exp = 'Please Update Rate and Validity...!';
            }else{
                $exp = '';
            }
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
                $objPHPExcel->getActiveSheet()->getStyle('O'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$counter)->applyFromArray($style_col);
                $objPHPExcel->getActiveSheet()->getStyle('R'.$counter)->applyFromArray($style_col);

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$counter, $no) 
                ->setCellValue('C'.$counter, $r->kadaluarsa) 
                ->setCellValue('D'.$counter, $exp) 
                ->setCellValue('E'.$counter, $r->container_name) 
                ->setCellValue('F'.$counter, $r->port_name) 
                ->setCellValue('G'.$counter, $r->container_name)
                ->setCellValue('H'.$counter, $r->trading_term_name.'('.$r->trading_term_remark.')') 
                ->setCellValue('I'.$counter, date('d-m-Y', strtotime($r->validity_from))) 
                ->setCellValue('J'.$counter, date('d-m-Y', strtotime($r->validity_till))) 
                ->setCellValue('K'.$counter, $r->shipping_line1)
                ->setCellValue('L'.$counter, $r->vendor_rates) 
                ->setCellValue('M'.$counter, $r->shipping_line2) 
                ->setCellValue('N'.$counter, $r->vendor_rates2)
                ->setCellValue('O'.$counter, $r->shipping_line3)
                ->setCellValue('P'.$counter, $r->vendor_rates3)
                ->setCellValue('Q'.$counter, $r->customer_name)
                ->setCellValue('R'.$counter, $r->cust_rates);
                $counter++;$no++;
        }
            

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('test_img');
    $objDrawing->setDescription('test_img');
    $objDrawing->setPath('assets/ZHL-Report.png');
    $objDrawing->setCoordinates('H1');                      
    $objDrawing->setOffsetX(150); 
    $objDrawing->setOffsetY(5);                
    //set width, height
    $objDrawing->setWidth(160); 
    $objDrawing->setHeight(90); 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Simple');
header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="master_freight.xlsx"');        
// Save Excel 2007 file
//  " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save('php://output');



// Echo done
// echo date('H:i:s') . " Done writing file.\r\n";
