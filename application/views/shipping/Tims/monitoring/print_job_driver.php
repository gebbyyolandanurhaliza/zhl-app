<?php

class PDF extends TFPDF
{

  public $totamount;

  public function __construct()
  {
    parent::__construct();
    $this->totamount = 0; // Initialize total amount

  }
  public function getTotAmount()
  {
    return $this->totamount;
  }

  function Header()
  {
    $this->SetX(10);
    $this->Cell(190, 25, '', 0, 0);
    $this->Image('assets/zhlkop.PNG', 12, 3, 200, 35);
  }

  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }

  // Override the AcceptPageBreak method
  // function AcceptPageBreak()
  // {
  //   // Add a page break only if the remaining space is less than 20 mm
  //   if ($this->GetY() > 100) {
  //     $this->AddPage();
  //   }
  //   return false; // Return false to disable the automatic page break
  // }
}





// Instantiation of inherited class
$pdf = new PDF();
$pdf->SetTitle('Driver Job -' . $driver_name . ' (' . $vehicle_no . ')');


$pdf->AliasNbPages();
$pdf->Header();
$pdf->AddPage();

$pdf->SetXY(10, 40);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 5, 'EMPLOYEE\'S NAME ', 0, 0);
$pdf->Cell(2, 5, ':', 0, 0, 'L', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 5, $driver_name, 0, 0, 'L', 0);
$pdf->SetXY(134, 40);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 5, 'VEHICLE NO', 0, 0, 'R', 0);
$pdf->Cell(2, 5, ':', 0, 0, 'L', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 5, $vehicle_no, 0, 0, 'L', 0);

$pdf->SetXY(10, 50);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 5, 'NRIC / FIN NO', 0, 0, 'L', 0);
$pdf->Cell(2, 5, ':', 0, 0, 'L', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(70, 5, '', 0, 'L');
$pdf->SetXY(148, 50);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 5, 'FROM _______ TO _______', 0, 0, 'R', 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 5, '', 0, 1, 'L', 0);
$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'DATE', 1, 0, 'C');
$pdf->Cell(50, 10, 'CLIENTS', 1, 0, 'C');
$pdf->Cell(40, 10, 'CONTAINER NO.', 1, 0, 'C');
$pdf->Cell(40, 10, 'CHASSIS/STATUS', 1, 0, 'C');
$pdf->Cell(30, 10, 'AMOUNT', 1, 1, 'C');

for ($i = 0; $i < $total_si; $i++) {
  $rec_hdr  = $data_job[$i];

  $y = $pdf->GetY();

  if ($pdf->GetY() > 240) {
    $pdf->AddPage();
    $y = $pdf->GetY() + 25;
     $pdf->Line(10, $y, 200, $y);
  }

  $amountDetails = json_decode($rec_hdr->amount_details, true);

  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(10, $y);
  $pdf->MultiCell(30, 5, $rec_hdr->curr_date, 0, 'C');
  
  $pdf->SetXY(90, $y);

  $pdf->MultiCell(40, 5, $rec_hdr->job, 0, 'C');
  $pdf->SetXY(130, $y);

  $pdf->MultiCell(40, 5, $rec_hdr->chasis, 0, 'C');
  $pdf->SetXY(40, $y);
  
  $pdf->MultiCell(50, 5, $rec_hdr->send_to, 0, 'C');
  
  $pdf->Ln();
  if (str_word_count($rec_hdr->job) >= 4) {
    $pdf->Ln();
  }
  $y5 = $pdf->GetY();
  $pdf->Line(10, $y, 10, $y5);
  $pdf->Line(40, $y, 40, $y5);
  $pdf->Line(90, $y, 90, $y5);
  $pdf->Line(130, $y, 130, $y5);
  $pdf->Line(170, $y, 170, $y5);
  $pdf->Line(200, $y, 200, $y5);
  $pdf->Line(10, $y5, 200, $y5);
  if ($amountDetails) {

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(120, 10, 'Job Detail', 1, 0, 'L');
    $pdf->Cell(40, 10, 'Qty', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Price Trip', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Extra', 1, 1, 'C');


    $pdf->AddFont('MSJH', '', 'msjh.ttf', true);
    $pdf->SetFont('MSJH', '', 8);
    // $pdf->SetFont('arial', '', 14);

    foreach ($amountDetails as $key => $detail) {

      if ($detail['job_price_id'] == 21) {
        $dtl = $detail['driver_wages'];
      } elseif ($detail['job_price_id'] == 29) {
        $standby_from = $detail['time_standby']['time_from'];
        $standby_to = $detail['time_standby']['time_to'];
        $dtl = $detail['driver_wages'] .  ' ' . $standby_from . '-' . $standby_to;
      } else {
        $dtl = $detail['driver_wages'];
      }

      if ($rec_hdr->driver_type == 'local') {
        $price = $detail['local_pertrip'];
        $extra = $detail['extra_trip'];
      } else {
        $price = $detail['prc_pertrip'];
        $extra = $detail['extra_trip'];
      }
      $y2 = $pdf->GetY();
      if ($pdf->GetY() > 240) {
        $pdf->AddPage();
        $y2 = $pdf->GetY()+25;
        $pdf->Line(10, $y2, 200, $y2);
      }

      $container_items = $detail['container_items'];
      
      $pdf->SetXY(130, $y2);
      $pdf->MultiCell(40, 5, $detail['qty'], 0, 'C');
      $pdf->SetXY(170, $y2);
      $pdf->MultiCell(20, 5, $price, 0, 'C');
      $pdf->SetXY(190, $y2);
      $pdf->MultiCell(10, 5, $extra, 0, 'C');
      $pdf->SetXY(10, $y2);
      $pdf->MultiCell(120, 5, $dtl, 0, 'L');
      $y6 = $pdf->GetY();
      $pdf->Line(10, $y2, 10, $y6);
      $pdf->Line(130, $y2, 130, $y6);
      $pdf->Line(170, $y2, 170, $y6);
      $pdf->Line(190, $y2, 190, $y6);
      $pdf->Line(200, $y2, 200, $y6);
      $pdf->Line(10, $y6, 200, $y6);

      foreach ($container_items as $item) {
        $container_value = $item['container'];
        
        if ($container_value!='x') {
          $y10 = $pdf->GetY();
          if ($pdf->GetY() > 240) {
            $pdf->AddPage();
            $y10 = $pdf->GetY()+25;
            $pdf->Line(10, $y10, 200, $y10);
          }
          $pdf->SetXY(10, $y10);
          $pdf->MultiCell(120, 5, $container_value, 0, 'L');
          $y11 = $pdf->GetY();
          $pdf->Line(10, $y10, 10, $y11);
          $pdf->Line(130, $y10, 130, $y11);
          $pdf->Line(170, $y10, 170, $y11);
          $pdf->Line(190, $y10, 190, $y11);
          $pdf->Line(200, $y10, 200, $y11);
          $pdf->Line(10, $y11, 200, $y11);
        }
         
      }
      

    }

  }
$pdf->SetFont('Arial', 'B', 10);
  $y_ = $pdf->GetY();
  $pdf->SetXY(10, $y_);
  $pdf->MultiCell(160, 10,'Amount', 0, 'C');
  $pdf->SetXY(170, $y_);
  $pdf->MultiCell(30, 10, $rec_hdr->amount, 0, 'C');

  $y61 = $pdf->GetY();
  $pdf->Line(10, $y_, 10, $y61);
  // $pdf->Line(130, $y_, 130, $y61);
  $pdf->Line(170, $y_, 170, $y61);
  $pdf->Line(200, $y_, 200, $y61);
  $pdf->Line(10, $y61, 200, $y61);

  $count = count($amountDetails);


  $pdf->totamount += $rec_hdr->amount;
}

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(160, 10, 'TOTAL AMOUNT', 1, 0, 'R');
$pdf->Cell(30, 10, number_format($pdf->getTotAmount(), 2), 1, 1, 'C');
$pdf->Output();
