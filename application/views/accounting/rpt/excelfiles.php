<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_po". date('dmY_His').".xls" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
 
$workbook = new Workbook();
$worksheet1 =& $workbook->add_worksheet(date('dmY_His'));
 
$header =& $workbook->add_format();
$header->set_color('black'); // set warna huruf
$header->set_border_color('black'); // set warna border
 
$header->set_size(10); // Set ukuran font 
 
$header->set_align("center"); // set align rata tengah
 
$header->set_top(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_bottom(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_left(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$header->set_right(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
 

$worksheet1->write_string(0,0,'No.',$header);  // Set Nama kolom
$worksheet1->set_column(0,0,5); // Set lebar kolom
$worksheet1->write_string(0,1,'PO LOCAL',$header);  // Set Nama kolom
$worksheet1->set_column(0,1,15); // Set lebar kolom 
$worksheet1->write_string(0,2,'SPESIFIKASI',$header);  // Set Nama kolom
$worksheet1->set_column(0,2,15); // Set lebar kolom
$worksheet1->write_string(0,3,'BUYER',$header);  // Set Nama kolom
$worksheet1->set_column(0,3,20); // Set lebar kolom
$worksheet1->write_string(0,4,'PRODUCT ITEM',$header);  // Set Nama kolom
$worksheet1->set_column(0,4,20); // Set lebar kolom
$worksheet1->write_string(0,5,'PRODUCT DATE',$header);  // Set Nama kolom
$worksheet1->set_column(0,5,15); // Set lebar kolom
$worksheet1->write_string(0,6,'EXP. DATE',$header);  // Set Nama kolom
$worksheet1->set_column(0,6,15); // Set lebar kolom
$worksheet1->write_string(0,7,'FILER',$header);  // Set Nama kolom
$worksheet1->set_column(0,7,15); // Set lebar kolom
$worksheet1->write_string(0,8,'QUANTITY',$header);  // Set Nama kolom
$worksheet1->set_column(0,8,15); // Set lebar kolom
$worksheet1->write_string(0,9,'PALLET',$header);  // Set Nama kolom
$worksheet1->set_column(0,9,15); // Set lebar kolom
$worksheet1->write_string(0,10,'STATUS',$header);  // Set Nama kolom
$worksheet1->set_column(0,10,15); // Set lebar kolom
$worksheet1->write_string(0,11,'LOCATE',$header);  // Set Nama kolom
$worksheet1->set_column(0,11,15); // Set lebar kolom

 
$content =& $workbook->add_format();
$content->set_size(10);
 
$content->set_top(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_bottom(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_left(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
$content->set_right(1); // set ketebalan border bagian atas cell 0 = border tidak tampil
 
$row = 1;
foreach ($data as $key) {
    $worksheet1->write_string($row,0,  $row ,$content);
    $worksheet1->write_string($row,1,  $key->NoPO ,$content);
    $worksheet1->write_string($row,2,  $key->CategoryID ,$content);
    $worksheet1->write_string($row,3,  $key->CustomerName ,$content);
    $worksheet1->write_string($row,4,  $key->ProductID ,$content);
    $worksheet1->write_string($row,5,  $key->ProdDate ,$content);
    $worksheet1->write_string($row,6,  $key->ExpDate ,$content);
    $worksheet1->write_string($row,7,  $key->Machine ,$content);
    $worksheet1->write_string($row,8,  $key->Qty ,$content);
    $worksheet1->write_string($row,9,  $key->Pallet ,$content);
    $worksheet1->write_string($row,10,  $key->Status ,$content);
    $worksheet1->write_string($row,11,  $key->NoRak ,$content);
    $row++;
}
 
$workbook->close();
 