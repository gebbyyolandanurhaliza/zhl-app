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
    'font'      => array(
        'bold' => FALSE,
        'name' => 'Times New Roman',
        'size' => '9'
    ), // Set font nya jadi bold  
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'wrap' => true, // Set text jadi ditengah secara horizontal (center)    
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top'   => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis   
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
        'left'  => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
    )
);

// // Add some data
// //PENGATURAN LEBAR
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);




// //PENGATURAN TINGGI
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(4);
$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(5);
$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(19.5);
$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(28);
$objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(22);

// //PENGATURAN MERGE CELL          

for ($i = 1; $i < 6; $i++) {
    $objPHPExcel->getActiveSheet()->mergeCells('C' . $i . ':N' . $i);
    $objPHPExcel->getActiveSheet()->freezePane('A13');
}
$objPHPExcel->getActiveSheet()->mergeCells('C10:N10');

//     // Apply style header yang telah kita buat tadi ke masing-masing kolom header
$header1 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => true, 'name' => 'Times New Roman', 'size' => '12'),

);
$header2 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => false, 'name' => 'Times New Roman', 'size' => '10'),
);
$header3 = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), // Set text jadi di tengah secara horizontal (middle)  ), 
    'font' => array('bold' => true, 'name' => 'Times New Roman', 'size' => '14'),
);
$garisheader1 = array(
    'borders' => array(
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border top dengan garis tipis      
    )
);
$garisheader2 = array(
    'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_MEDIUM) // Set border top dengan garis tipis      
    )
);
$objPHPExcel->getActiveSheet()->getStyle('C1:N1')->applyFromArray($header1);
for ($i = 2; $i < 6; $i++) {
    $objPHPExcel->getActiveSheet()->getStyle('C' . $i . ':N' . $i)->applyFromArray($header2);
}
$objPHPExcel->getActiveSheet()->getStyle('A6:R6')->applyFromArray($garisheader1);
$objPHPExcel->getActiveSheet()->getStyle('A8:R8')->applyFromArray($garisheader2);
$objPHPExcel->getActiveSheet()->getStyle('A10:N10')->applyFromArray($header3);
$objPHPExcel->getActiveSheet()->getStyle('B12:N12')->applyFromArray($style_col);
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



$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C1', 'ZHENGHE LOGISTICS PTE LTD')
    ->setCellValue('C2', 'Reg. Number : 201734570K')
    ->setCellValue('C3', '75 Bukit Timah Road, #05-01 Boon Siew Building, Singapore 229833')
    ->setCellValue('C4', 'Phone: 6955 8292- Fax: 6980 2095 ')
    ->setCellValue('C5', 'www.sambugroup.com')
    ->setCellValue('C10', 'MONITORING WAREHOUSE')
    ->setCellValue('A12', '')
    ->setCellValue('B12', 'NO')
    ->setCellValue('C12', 'Main Po')
    ->setCellValue('D12', 'PO Date')
    ->setCellValue('E12', 'Main GR')
    ->setCellValue('F12', 'GR Date')
    ->setCellValue('G12', 'No So')
    ->setCellValue('H12', 'So Delivery Date')
    ->setCellValue('I12', 'Vendor Company')
    ->setCellValue('J12', 'Item ID')
    ->setCellValue('K12', 'Item Name')
    ->setCellValue('L12', 'Uom')
    ->setCellValue('M12', 'QTY Out')
    ->setCellValue('N12', 'Customer');
//menampilkan content dari data excel
$counter = 13;
$no = 1;


foreach ($record as $r) {


    $objPHPExcel->getActiveSheet()->getStyle('B' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('M' . $counter)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('N' . $counter)->applyFromArray($style_col);
  


    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B' . $counter, $no++)
        ->setCellValue('C' . $counter, $r->mainpo)
        ->setCellValue('D' . $counter, $r->docdate)
        ->setCellValue('E' . $counter, $r->id_gr)
        ->setCellValue('F' . $counter, $r->docdate)
        ->setCellValue('G' . $counter, $r->sono)
        ->setCellValue('H' . $counter, $r->outdate)
        ->setCellValue('I' . $counter, $r->vendorcompany)
        ->setCellValue('J' . $counter, $r->itemid)
        ->setCellValue('K' . $counter, $r->itemname)
        ->setCellValue('L' . $counter, $r->uomname)
       // ->setCellValue('M' . $counter, $r->qtywhs)
      //  ->setCellValue('N' . $counter,  number_format(((($r->tqtywhs) > '0') ? ($r->qtywhs + $r->tqtywhs) - $r->qtypo : $r->qty_outstanding), 0, '.', ''))
        ->setCellValue('M' . $counter, $r->qty_out)
       // ->setCellValue('P' . $counter, $r->qty_outstanding_so)
        ->setCellValue('N' . $counter, $r->custcompany);
    $counter++;
}
$a = $counter + 1;
$objPHPExcel->getActiveSheet()->mergeCells('B' . $a . ':N' . $a);
$objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray(array('font' => array('bold' => false, 'italic' => true, 'name' => 'Times New Roman', 'size' => '11')));
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B' . $a, 'Print_by : ');

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('assets/zhl.png');
$objDrawing->setCoordinates('F1');
$objDrawing->setOffsetX(50);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(160);
$objDrawing->setHeight(90);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Simple');
header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
header('Chace-Control: no-store, no-cache, must-revalation');
header('Chace-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Monitoring_warehouse.xlsx"');
// Save Excel 2007 file
//  " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');



// Echo done
// echo date('H:i:s') . " Done writing file.\r\n";
