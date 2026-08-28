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
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(23.8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);


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
        $objPHPExcel->getActiveSheet()->mergeCells('C'.$i.':Q'.$i);
        $objPHPExcel->getActiveSheet()->freezePane('A13');
    }
     $objPHPExcel->getActiveSheet()->mergeCells('C10:Q10');

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
    $objPHPExcel->getActiveSheet()->getStyle('C1:Q1')->applyFromArray($header1);
    for($i=2;$i<6;$i++){
        $objPHPExcel->getActiveSheet()->getStyle('C'.$i.':Q'.$i)->applyFromArray($header2);

    }
    $objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->applyFromArray($garisheader1);
    $objPHPExcel->getActiveSheet()->getStyle('A8:Q8')->applyFromArray($garisheader2);
    $objPHPExcel->getActiveSheet()->getStyle('A10:Q10')->applyFromArray($header3);
    $objPHPExcel->getActiveSheet()->getStyle('B12:Q12')->applyFromArray($style_col);
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
    $objPHPExcel->getActiveSheet()->getStyle('L12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('O12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('P12')->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('Q12')->applyFromArray($style_col);

//     //ISI HEADER CELL  
    foreach ($tampil_cont as $as) {
            $cont_view = $as->container_name;
    }
     $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C1','ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('C2','Reg. Number : 201537276N')
                ->setCellValue('C3','39 WOODLANDS CLOSE #02-07/08 MEGA@WOODLANDS, SINGAPORE 737856')
                ->setCellValue('C4', 'E-mail : booking@zhenghe.com.sg / shipping@zhenghe.com.sg')
                //->setCellValue('C5', '')
                //->setCellValue('C10', 'LIFTING VOLUME YEAR'.$tahun'CONTAINER TYPE'.$cont)
                // ->setCellValue('C10', 'LIFTING VOLUME YEAR   '.$tahun.'   CONTAINER TYPE    '.$cont_view)
                ->setCellValue('A12', '')
                ->setCellValue('B12', 'NO')
                ->setCellValue('C12', 'Shipping Line')
                ->setCellValue('D12', 'Destination')
                ->setCellValue('E12', 'Total Amount(Year)')
                ->setCellValue('F12', 'January')
                ->setCellValue('G12', 'February')
                ->setCellValue('H12', 'March')
                ->setCellValue('I12', 'April')
                ->setCellValue('J12', 'May')
                ->setCellValue('K12', 'June')
                ->setCellValue('L12', 'July')
                ->setCellValue('M12', 'August')
                ->setCellValue('N12', 'September')
                ->setCellValue('O12', 'October')
                ->setCellValue('P12', 'November')
                ->setCellValue('Q12', 'December')

                
                ;
        //menampilkan content dari data excel
        $counter = 13;
        $no = 1;
        $sum_tt_tahun=0;$sum_tt_1=0;$sum_tt_2=0;$sum_tt_3=0;$sum_tt_4=0;$sum_tt_5=0;$sum_tt_6=0;$sum_tt_7=0;$sum_tt_8=0;$sum_tt_9=0;$sum_tt_10=0;$sum_tt_11=0;$sum_tt_12=0;
        foreach ($_total as $r) {
                if($r->t_position == 1){
                    $sum_tt_tahun += $r->tt_tahun;
                    $sum_tt_1 += $r->tt_1;
                    $sum_tt_2 += $r->tt_2;
                    $sum_tt_3 += $r->tt_3;
                    $sum_tt_4 += $r->tt_4;
                    $sum_tt_5 += $r->tt_5;
                    $sum_tt_6 += $r->tt_6;
                    $sum_tt_7 += $r->tt_7;
                    $sum_tt_8 += $r->tt_8;
                    $sum_tt_9 += $r->tt_9;
                    $sum_tt_10 += $r->tt_10;
                    $sum_tt_11 += $r->tt_11;
                    $sum_tt_12 += $r->tt_12;
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$counter)->applyFromArray($style_col);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':Q'.$counter)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('A9A9A9');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$counter, $no);  
                   $no++;  
                }else{
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$counter)->applyFromArray($style_col);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$counter, ' ');
                }
                //$objPHPExcel->getActiveSheet()

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
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C'.$counter, $r->t_shiplineri) 
                ->setCellValue('D'.$counter, $r->t_destinationi) 
                ->setCellValue('E'.$counter, $r->tt_tahun) 
                ->setCellValue('F'.$counter, $r->tt_1)     
                ->setCellValue('G'.$counter, $r->tt_2) 
                ->setCellValue('H'.$counter, $r->tt_3) 
                ->setCellValue('I'.$counter, $r->tt_4) 
                ->setCellValue('J'.$counter, $r->tt_5) 
                ->setCellValue('K'.$counter, $r->tt_6) 
                ->setCellValue('L'.$counter, $r->tt_7) 
                ->setCellValue('M'.$counter, $r->tt_8) 
                ->setCellValue('N'.$counter, $r->tt_9) 
                ->setCellValue('O'.$counter, $r->tt_10) 
                ->setCellValue('P'.$counter, $r->tt_11) 
                ->setCellValue('Q'.$counter, $r->tt_12);
                 $counter++;
        }
        $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':D' . $counter);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':D' . $counter)->applyFromArray($style_col); 
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
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$counter, 'Grand Total')
                ->setCellValue('E'.$counter, $sum_tt_tahun)
                ->setCellValue('F'.$counter, $sum_tt_1)     
                ->setCellValue('G'.$counter, $sum_tt_2) 
                ->setCellValue('H'.$counter, $sum_tt_3) 
                ->setCellValue('I'.$counter, $sum_tt_4) 
                ->setCellValue('J'.$counter, $sum_tt_5) 
                ->setCellValue('K'.$counter, $sum_tt_6) 
                ->setCellValue('L'.$counter, $sum_tt_7) 
                ->setCellValue('M'.$counter, $sum_tt_8) 
                ->setCellValue('N'.$counter, $sum_tt_9) 
                ->setCellValue('O'.$counter, $sum_tt_10) 
                ->setCellValue('P'.$counter, $sum_tt_11) 
                ->setCellValue('Q'.$counter, $sum_tt_12);
            

//     $objDrawing = new PHPExcel_Worksheet_Drawing();
//     $objDrawing->setName('test_img');
//     $objDrawing->setDescription('test_img');
//     //$objDrawing->setPath('assets/img/logobpjs.png');
//     $objDrawing->setCoordinates('A1');                      
//     //setOffsetX works properly
//     $objDrawing->setOffsetX(5); 
//     $objDrawing->setOffsetY(5);                
//     //set width, height
//     $objDrawing->setWidth(80); 
//     $objDrawing->setHeight(90); 
//     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// // Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Simple');
header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan().xlsx"');        
// Save Excel 2007 file
//  " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save('php://output');



// Echo done
// echo date('H:i:s') . " Done writing file.\r\n";
