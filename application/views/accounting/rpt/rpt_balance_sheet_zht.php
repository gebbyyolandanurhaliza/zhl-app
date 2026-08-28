<?php
$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$new_awal = date('F jS, Y', strtotime($dari));
$new_akhir = date('F jS, Y', strtotime($sampai));
class PDF extends FPDF {

  //Page header
  function Header() {
      $titel = 'Payable Statement Of Account';
      $this->SetX(10);
      $this->Cell(190,25,'',0,0);
      $this->Image('assets/zhlkop.PNG',16,8,180,33);
      $this->Ln();
      $this->SetX(10);
      
  }

  function Content($_balance, $dari, $sampai) {      
    $new_awal = date('F jS, Y', strtotime($dari));  
    $new_akhir = date('F jS, Y', strtotime($sampai));  
    $this->Ln(6);
    $this->setFont('Arial', 'B', 12);
    $this->setFillColor(255, 255, 255);
    $this->Cell(80);
    $this->cell(25, 5, 'BALANCE SHEET FOR THE PERIOD '.$new_awal.' - '.$new_akhir.'', 0, 1, 'C', 1);
    // echo "<pre>";
    // print_r($_balance);
    // echo "</pre>";
    // die;

    $this->setFont('Arial', 'B', 10);
    $this->cell(100, 5, 'Group Name', 'BTLR', 0, 'C', 1);
    $this->cell(80, 5, 'Amount ', 'BTLR', 1, 'R', 1);

    $this->Ln(1);

    $NO = 1;
    $this->setFont('Arial', '', 8);
    $this->setFillColor(255, 255, 255);

    $ttl_asset = 0;
    $ttl_other = 0;
    $ttl_equity = 0;
    $current_group = null;

    $headerIds = [1, 13];
    $boldIds = [12, 23];
    foreach ($_balance as $value) {

      if ($current_group !== $value->id_group) {
          $current_group = $value->id_group;
          $this->setFont('Arial', 'B', 8);
          $this->setFillColor(230, 230, 250);
          $this->cell(180, 5, strtoupper($value->t_coaname), 'BTLR', 1, 'L', 1); 
      }

      if (in_array($value->t_coaid, $headerIds)) {
          $this->setFont('Arial', 'B', 8);
          $this->setFillColor(127, 255, 212); 
          $this->cell(180, 5, $value->t_coaname, 'BTLR', 1, 'L', 1); 
          continue; 
      }
  
      if (in_array($value->t_coaid, $boldIds)) {
          $this->setFont('Arial', 'B', 8);
          $this->setFillColor(192, 192, 192);
      } else {
          $this->setFont('Arial', '', 8);
          $this->setFillColor(255, 255, 255);
      }

      $this->cell(100, 5, $value->t_coaname, 'BTLR', 0, 'L', 1);
      $this->cell(80, 5, number_format($value->t_balance, 2, ',', '.'), 'BTLR', 1, 'R', 1);
    }
  }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_balance, $dari, $sampai);
$pdf->Output();
