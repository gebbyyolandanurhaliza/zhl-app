<?php

/** PHPExcel_Writer_Excel2007 */


// Create new PHPExcel object
// echo date('H:i:s') . " Create new PHPExcel object\n";

$objPHPExcel    = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

$style_col = array(
    'font'      => array(
        'bold' => false,
        'name' => 'Calibri Light',
        'size' => '11'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
    ),
);
$style_col_right = array(
    'font'      => array(
        'bold' => True,
        'name' => 'Calibri Light',
        'size' => '11'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
    ),
);
$style_col_angka = array(
    'font'      => array(
        'bold' => false,
        'name' => 'Calibri Light',
        'size' => '11'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
    ),
);
$style_col_bold = array(
    'font'      => array(
        'bold' => True,
        'name' => 'Calibri Light',
        'size' => '11'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
    ),
);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells('G6:H6');
$objPHPExcel->getActiveSheet()->mergeCells('B2:D2');

$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col_bold);


$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B2', $hdr->eta . ' - Barge Billing (Round Trip)')
    ->setCellValue('B3', 'FTY - ' . $hdr->shipmentdate)
    ->setCellValue('B6', 'Type Of Services')
    ->setCellValue('C6', "20'")
    ->setCellValue('D6', "40'")
    ->setCellValue('E6', 'CT')
    ->setCellValue('F6', 'Barge Cost Per ')
    ->setCellValue('F7', "20'/40'")
    ->setCellValue('G6', 'Trucking Cost')
    ->setCellValue('G7', "20'")
    ->setCellValue('H7', "40'")
    ->setCellValue('I6', 'Total Barge Cost')
    ->setCellValue('J6', 'Total Trucking Cost');


$no = 1;
$counter = 8;
$c20 = 0;
$c40 = 0;
$totbargecost = 0;
$totbargecost40 = 0;
$tottruckingcost = 0;
$tottruckingcost40 = 0;
$amountbarge=0;
$amounttrucking=0;

foreach ($billing  as $v) :
    if ($v->container_size == 20) {
        $totbargecost = $v->c20 * $v->barge_cost;
        $tottruckingcost = $v->c20 * $v->trucking_cost_20;
    } else {
        $totbargecost = 0;
        $tottruckingcost = 0;
    }
      if ($v->container_size == 40){
        $totbargecost40 = $v->c40 * $v->barge_cost;
        $tottruckingcost40 = $v->c40 * $v->trucking_cost_40;
    }else{
        $totbargecost40 = 0;
        $tottruckingcost40 = 0 ;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->applyFromArray($style_col_angka);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $counter)->applyFromArray($style_col_angka);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $counter)->applyFromArray($style_col_angka);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->applyFromArray($style_col_angka);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $counter)->applyFromArray($style_col_angka);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B' . $counter, $v->type)
        ->setCellValue('C' . $counter, $v->c20)
        ->setCellValue('D' . $counter, $v->c40)
        ->setCellValue('E' . $counter, $v->container_abbr)
        ->setCellValue('F' . $counter, '$ '. number_format($v->barge_cost, 2, ',', '.').'')
        ->setCellValue('G' . $counter, '$ '. number_format($v->trucking_cost_20, 2, ',', '.').'')       
        ->setCellValue('H' . $counter, '$ '. number_format($v->trucking_cost_40, 2, ',', '.'))
        ->setCellValue('I' . $counter,  $v->container_size == 20 ? '$ '. number_format($totbargecost, 2, ',', '.').'' : '$ '. number_format($totbargecost40, 2, ',', '.').'')
        ->setCellValue('J' . $counter,  $v->container_size == 20 ? '$ '. number_format($tottruckingcost, 2, ',', '.') .'': '$ '. number_format($tottruckingcost40, 2, ',', '.').'');
    $totbar = $totbargecost + $totbargecost40;
    $counter++;

   $objPHPExcel->getActiveSheet()->getStyle('B' . $counter)->applyFromArray($style_col_bold);
    $objPHPExcel->setActiveSheetIndex(0)   
        ->setCellValue('B' . $counter, 'SUB TOTAL');
       
    $c20 += $v->c20;
    $c40 += $v->c40;

    $amountbarge +=  ($v->c20 * $v->barge_cost) + ($v->c40 * $v->barge_cost);
    $amounttrucking += ($v->c20 * $v->trucking_cost_20) + ($v->c40 * $v->trucking_cost_40);

endforeach;
$objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->applyFromArray($style_col);
$objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->applyFromArray($style_col_right);
$objPHPExcel->getActiveSheet()->getStyle('J' . $counter)->applyFromArray($style_col_right);
$objPHPExcel->getActiveSheet()->mergeCells('E' . $counter . ':H' . $counter);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C' . $counter, $c20)
    ->setCellValue('D' . $counter, $c40)
    ->setCellValue('I' . $counter, '$ '.number_format($amountbarge, 2, ',', '.').'')
    ->setCellValue('J' . $counter, '$ '.number_format($amounttrucking, 2, ',', '.').'')

    
    ;

$objPHPExcel->getActiveSheet()->getStyle('B6:J6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('B6:J7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('B6:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('B6:B' . $counter)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('C6:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('D6:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('E6:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('F6:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('G6:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('H6:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('I6:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('J6:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('B' . $counter . ':J' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    ->getActiveSheet()->getStyle('B' . $counter . ':J' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$counter++;
$gst=8/100;
$gstamounttrucking= $amounttrucking * $gst;
$objPHPExcel->getActiveSheet()->getStyle('H' . $counter)->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->applyFromArray($style_col_right);
$objPHPExcel->getActiveSheet()->getStyle('J' . $counter)->applyFromArray($style_col_right);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('H' . $counter, 'GST')
    ->setCellValue('I' . $counter, '8%')
    ->setCellValue('J' . $counter, '$ '.number_format($gstamounttrucking, 2, ',', '.').'')

    ;
$x=$counter+1;
$amount=$amountbarge + $amounttrucking + $gstamounttrucking;
$objPHPExcel->getActiveSheet()->getStyle('H' . $x)->applyFromArray($style_col_bold);
$objPHPExcel->getActiveSheet()->getStyle('J' . $x)->applyFromArray($style_col_right);

    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('H' . $x, 'Amount Due')
    // ->setCellValue('J' . $x,'$ '. $amount)
    ->setCellValue('J' . $x, '$ '.number_format($amount, 2, ',', '.').'')

    ; 

    
$objPHPExcel->getActiveSheet()->setTitle('ROUNDTRIP EXPORT');
header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ROUNDTRIP-EXPORT ' . $hdr->shipmentdate . '.xlsx"');



$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');
