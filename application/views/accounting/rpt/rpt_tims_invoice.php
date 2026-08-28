<?php
class PDF extends FPDF
{

  function Header()
  {
    $titel = 'Invoice';
    $this->SetX(10);
    $this->Cell(190, 25, '', 0, 0);
    $this->Image('assets/zhl-kop.PNG', 3, 8, 205, 33);
    $this->Ln();
    $this->SetX(10);
    $this->Ln(10);

    // Outputting data from $this->detailData
    $this->Ln();

    $this->SetXY(10, 50);

    $this->SetFont('Times', 'B', 11);
    $this->Cell(40, 5, $this->customer_name, 0, 1, 'L', 0);

    $this->SetFont('Times', '', 10);
    $this->MultiCell(70, 5, $this->Address, 0, 'L');

    $this->SetXY(132, 50);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, 'TAX INVOICE', 0, 0, 'R', 0);
    $this->Cell(8, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, $this->Noinv, 0, 1, 'L', 0);

    $this->SetXY(127, 55);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'DATE', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, date("d F Y",  strtotime($this->Invoice_date)), 0, 1, 'L', 0);

    $this->SetXY(127, 60);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'TERMS', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, ($this->Term !== '0' ? $this->Term . ' Days' : 'COD'), 0, 0, 'L', 0);


    $this->SetXY(127, 65);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'VESSEL', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->Vessel, 0, 0, 'L', 0);

    $this->SetXY(127, 70);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'YOUR REF', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->Reff, 0, 0, 'L', 0);

    $this->SetXY(127, 75);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'PO NUMBER', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->po_number, 0, 0, 'L', 0);

    $this->SetXY(127, 80);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'DELIVERY DATE', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, date("d F Y",  strtotime($this->Delivery_date)), 0, 1, 'L', 0);


    $this->SetXY(127, 85);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'SHIPPER', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->MultiCell(60, 5, $this->Shipper, 0, 'L');


    $this->SetXY(10, 81);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'Attn', 0, 0, 'L', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);

    $this->SetFont('Times', '', 10);
    $this->Cell(80, 5, $this->contact, 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);

    $this->SetXY(70, 81);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'Phone', 0, 0, 'L', 0);
    $this->Cell(1, 5, ':', 0, 0, 'R', 0);

    $this->SetFont('Times', '', 10);
    $this->Cell(80, 5, $this->phone, 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);

    $this->ln(15);
    $this->SetFont('Times', 'B', 11);
    $this->Cell(20, 5, 'Description', 'BT', 0, 'C');
    $this->Cell(98, 5, 'Qty', 'BT', 0, 'R');
    $this->Cell(22, 5, 'Price', 'BT', 0, 'R');
    $this->Cell(32, 5, 'Amount (' . $this->Currency . ')', 'BT', 0, 'R');
    $this->Cell(20, 5, 'GST', 'BT', 0, 'R');
    $this->ln(10);
  }

  function Footer()
  {
    //atur posisi 1.5 cm dari bawah
    // $sig = $_GET['signature'];

  }


  function Content($rec_hdr, $dtl)
  {
    $symbol = '$';
    $this->AddPage();
    $w = 90;
    foreach ($dtl as $key) {

      $x = $this->GetX();
      $y = $this->GetY();
      $this->SetFont('Times', '', 10);
      $this->SetXY($x + 73, $y);
      if (($key->Qty * $key->Price) == 0) {
        $col3 = '';
        $col = '';
        $col2 = '';
      } else {
        $col3 = $symbol . number_format($key->Qty * $key->Price, 2);
        $col = number_format($key->Qty, 2);
        $col2 = $symbol . number_format($key->Price, 2);
      }
      $this->MultiCell(47, 2, $col, 0, 'R');
      $this->SetXY($x + 93, $y);
      $this->MultiCell(47, 2, $col2, 0, 'R');
      $this->SetXY($x + 120, $y);
      $this->MultiCell(47, 2, $col3, 0, 'R');
      $this->SetXY($x + 162, $y);
      $this->MultiCell(30, 2, $key->Tax_type, 0, 'R');
      $des = strtoupper($key->Item_desc);
      $this->SetXY($x, $y);
      $this->MultiCell($w, 4, $des, 0, 'L');
      $this->ln();

      $y6 = $this->GetY();
      if ($y6 > 250) {
        $this->AddPage();
      }
    }

    $this->SetY(-95);
    $this->Line(10, $this->GetY() - 2, 250 - 50, $this->GetY() - 2);
    $this->SetFont('Times', '', 10);
    $this->SetX(120);
    $this->Cell(36, 4, 'TOTAL ');
    $this->Cell(2, 4, ':');
    $this->Cell(20, 4, $symbol . number_format($rec_hdr->Total, 2), 0, 0, 'R');
    $this->Ln();
    $this->SetX(120);
    $this->Cell(36, 4, 'GST');
    $this->Cell(2, 4, ':');
    $this->Cell(20, 4, $symbol . number_format($rec_hdr->Tax, 2), 0, 0, 'R');
    $this->Ln();
    $this->SetX(120);
    $this->Cell(36, 4, 'TOTAL INCL GST ');
    $this->Cell(2, 4, ':');
    $this->Cell(20, 4, $symbol . number_format($rec_hdr->Total_amount, 2), 0, 1, 'R');
    $this->SetFont('Times', '', 11);
    $to_word = number_format($rec_hdr->Total_amount, 2, '.', '');
    $this->Cell(100, 10, convert_number_to_words_2($to_word), 0, 1, 'L');
    $this->Line(10, $this->GetY() + 1, 250 - 50, $this->GetY() + 1);

    $this->SetY(231);
    $this->setFont('Arial', 'B', 8);
    $this->setFillColor(255, 255, 255);
    $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
    $this->setFont('Arial', 'B', 10);
    $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
    $this->setFont('Arial', 'i', 8);
    $this->Cell(10, 5, 'CIMB BANK', 0, 1, 'l');
    $this->Cell(10, 5, 'Swift Code : CIBBSGSG', 0, 1, 'l');
    $this->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');
    $this->Cell(10, 5, 'ANY DISCREPANCY IN THIS INVOICE, PLEASE INFORM US IN', 0, 1, 'l');
    $this->Cell(10, 5, 'WRITING WITHIN SEVEN (7) DAYS', 0, 1, 'l');
    $this->setFont('Arial', 'B', 11);
    $this->Line(145, $this->GetY(), 250 - 50, $this->GetY());

    // // $this->Cell(70, 5, $sig, 0, 1, 'L');
    $this->SetY(-30);
    $this->setFont('Arial', 'I', 7);
    $this->multicell(170, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request. ', 0, 1, 'L');
  }
}
$pdf = new PDF();
$pdf->customer_name = $rec_hdr->customer_name;
$pdf->Address       = $rec_hdr->Address;
$pdf->Noinv         = $rec_hdr->Noinv;
$pdf->Invoice_date  = $rec_hdr->Invoice_date;
$pdf->Term          = $rec_hdr->Term;
$pdf->Vessel        = $rec_hdr->Vessel;
$pdf->Reff          = $rec_hdr->Reff;
$pdf->Delivery_date = $rec_hdr->Delivery_date;
$pdf->contact       = $rec_hdr->contact;
$pdf->phone         = $rec_hdr->phone;
$pdf->Currency      = $rec_hdr->Currency;
$pdf->Shipper       = $rec_hdr->Shipper;
$pdf->po_number       = $rec_hdr->po_number;

$pdf->Content($rec_hdr, $dtl);
$pdf->Output();
