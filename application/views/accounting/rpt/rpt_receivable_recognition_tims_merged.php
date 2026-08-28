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

    $this->Ln();

    $this->SetXY(10, 50);

    $this->SetFont('Times', 'B', 11);
    $this->Cell(40, 5, $this->customer_name, 0, 1, 'L', 0);

    $this->SetFont('Times', '', 10);
    $this->MultiCell(70, 5, $this->Address, 0, 'L');

    $this->SetXY(120, 50);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, $this->jenisJurnal, 0, 0, 'R', 0);
    $this->Cell(8, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, $this->Noinv, 0, 1, 'L', 0);

    $this->SetXY(115, 55);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'DATE', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, date("d F Y",  strtotime($this->Invoice_date)), 0, 1, 'L', 0);

    $this->SetXY(115, 60);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'TERMS', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->Term, 0, 0, 'L', 0);


    $this->SetXY(115, 65);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'VESSEL', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->Vessel, 0, 0, 'L', 0);

    $this->SetXY(115, 70);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'YOUR REF', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->Reff, 0, 0, 'L', 0);

    $this->SetXY(115, 75);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'PO NUMBER', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, 5, $this->po_number, 0, 0, 'L', 0);

    $this->SetXY(115, 80);
    $this->SetFont('Times', '', 10);
    $this->Cell(20, 5, 'DELIVERY DATE', 0, 0, 'L', 0);
    $this->Cell(13, 5, ':', 0, 0, 'R', 0);
    $this->SetFont('Times', '', 10);
    if($this->Delivery_date == "1970-01-01" || empty($this->Delivery_date)){
      $this->Cell(40, 5, '', 0, 1, 'L', 0);
    }else{
      $this->Cell(40, 5, date("d F Y",  strtotime($this->Delivery_date)), 0, 1, 'L', 0);
    }


    $this->SetXY(115, 85);
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

  }


  function Content($piutang, $get_data_detail, $get_data_header)
  {
    
    $symbol = '$';
    $this->AddPage();
    $w = 90;
    $totalgst = 0;
    $total1 = 0;
    $_ttlGst = 0;
    $_ttlZero = 0;
    foreach ($get_data_detail as $key) {

      $totalgst += $key->gst_value;

      $x = $this->GetX();
      $y = $this->GetY();
      $this->SetFont('Times', '', 10);
      $this->SetXY($x + 73, $y);
      
      if (($key->Qty * $key->Harga) == 0) {
        $col3 = '';
        $col = '';
        $col2 = '';
      } else {
        $col3 = $symbol . number_format($key->Qty * $key->Harga, 2);
        $col = number_format($key->Qty, 2);
        $col2 = $symbol . number_format($key->Harga, 2);
      }
      $this->MultiCell(47, 2, $col, 0, 'R');
      $this->SetXY($x + 93, $y);
      $this->MultiCell(47, 2, $col2, 0, 'R');
      $this->SetXY($x + 120, $y);
      $this->MultiCell(47, 2, $col3, 0, 'R');
      

      if (($key->Qty * $key->Harga) == 0) {
        $this->SetXY($x + 162, $y);
      $this->MultiCell(30, 2, '', 0, 'R');
        $des = strtoupper($key->Items);
        $this->SetXY($x, $y);
        $this->MultiCell($w, 4, $des, 0, 'L');
        $this->ln();
      }else{
        $this->SetXY($x + 162, $y);
      $this->MultiCell(30, 2, number_format($key->gst_value,2), 0, 'R');
        $des = strtoupper($key->Items);
        $this->SetXY($x, $y);
        $this->MultiCell($w, 4, $des, 0, 'L');
      }
      // $this->ln();

      $y6 = $this->GetY();
      if ($y6 > 200) {
        $this->AddPage();
      }

      $total1 += $key->Qty * $key->Harga;

      if($key->gst_type == 'GST'){
        $_ttlGst += $key->Qty * $key->Harga;
      }else{
        $_ttlZero += ($key->Qty * $key->Harga) + $key->gst_value;
      }
    }

    $this->SetY(-90); // + 10
    $this->Line(10, $this->GetY() - 2, 250 - 50, $this->GetY() - 2);
    $this->SetFont('Times', '', 10);
    $this->SetX(143);
    $this->Cell(36, 4, 'TOTAL ');
    $this->Cell(2, 4, ':');
    $this->Cell(20, 4, $symbol . number_format($total1, 2), 0, 0, 'R');
    
    $this->SetX(10);
    $this->Cell(36, 4, 'Non-Taxable ');
    $this->SetX(70);
    $this->Cell(20, 4, $symbol . number_format(0, 2), 0, 0, 'L');
    $this->Ln();

    $this->SetX(143);
    $this->Cell(36, 4, 'GST');
    $this->Cell(2, 4, ':');
    $this->Cell(20, 4, $symbol . number_format($totalgst, 2), 0, 0, 'R');

    $this->SetX(10);
    $this->Cell(36, 4, 'Standard-rated supplies - 9% ');
    $this->SetX(70);
    $this->Cell(20, 4, $symbol . number_format($_ttlGst, 2), 0, 0, 'L');
    $this->Ln();

    $this->SetX(143);
    $this->Cell(36, 4, 'TOTAL INCL GST ');
    $this->Cell(2, 4, ':');
    $putangfinal = $total1 + $totalgst;
    $this->Cell(20, 4, $symbol . number_format($putangfinal, 2), 0, 0, 'R');

    
    $this->SetX(10);
    $this->Cell(36, 4, 'Zero-rated supplies ');
    $this->SetX(70);
    $this->Cell(20, 4, $symbol . number_format($_ttlZero, 2), 0, 0, 'L');
    $this->Ln();

    $this->SetY(-72);// + 10
    $this->SetFont('Times', '', 11);
    $to_word = number_format($putangfinal, 2, '.', '');
    $this->SetY($this->GetY() - 4.5);
    $this->SetX(10);
    $panjang_text = $this->GetStringWidth(convert_number_to_words_2($to_word));
    if($panjang_text > 100){
      $this->MultiCell(200, 4, convert_number_to_words_2($to_word), 0, 'L');
      $this->Cell(100, 1, '', 0, 1, 'L');
    }else{
      $this->MultiCell(200, 4, convert_number_to_words_2($to_word), 0, 'L');
      $this->Cell(100, 1, '', 0, 1, 'L');
    }
    
    $this->Line(10, $this->GetY() + 1, 250 - 50, $this->GetY() + 1);

    $sig = $_GET['signature'];

    $this->SetY(231); // -10
    $this->setFont('Arial', 'B', 8);
    $this->setFillColor(255, 255, 255);
    $this->Cell(90, 5, 'Bank Details :', 0, 1, 'l');
    $this->setFont('Arial', 'i', 8);


    $this->Cell(10, 5, 'CIMB BANK', 0, 1, 'l');
    $this->Cell(10, 5, 'Swift Code : CIBBSGSG', 0, 1, 'l');
    $this->Cell(10, 5, 'SGD Acct No. 2000913566', 0, 1, 'l');
    $this->Cell(10, 5, 'This is a computer generated document and no signature is required', 0, 1, 'l');
    $this->setFont('Arial', 'I', 7);
    $this->MultiCell(190, 5, 'All cheques and postal orders should be crossed and made payable to "ZHENGHE LOGISTICS PTE LTD." Your prompt settlement would be appreciated. In the event of any discrepancy, kindly notify our accounts department within 7 days. Interest charge at 2% per month will be levied on any amount outstanding for more than 30 days form date of this invoice. ', 0, 1, 'l');
    $this->setFont('Arial', 'B', 11);
    
    $this->SetY(-32);
    $this->setFont('Arial', 'I', 7);
    $this->multicell(120, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request. ', 0, 1, 'L');
  }
 }

$pdf = new PDF();
$pdf->SetAutoPageBreak(true, 10);

foreach ($listInvoice as $inv) {
    $nota = $this->M_Receivable_recognition_tims->nota($inv->nofaktur);
    $get_data_header = $this->M_Receivable_recognition_tims->get_data_header($inv->nofaktur);
    $get_data_detail = $this->M_Receivable_recognition_tims->get_data_detail($inv->nofaktur);
    
    foreach ($nota as $s) { 
        $namacustomer     = $s->namacustomer;
        $tanggal_invoice = $s->tanggal_invoice;
        $address         = str_replace("<br />", "", $s->address);
        $nofaktur        = $s->nofaktur;
        $term_val        = ($s->term == '0') ? 'COD' : $s->term . ' days';
        $bargevoy        = $s->voyage;
        $ctrno           = $s->ctrno;
        $shipmentdate    = $s->shipmentdate;
        $piutang         = $s->piutang;
        $contact         = $s->contactperson;
        $blno            = $s->blno;
        $currency        = $s->currency;
    }

    foreach ($get_data_header as $hdr) {
        $shipper = $hdr->shipper;
        $_jenis  = $hdr->jenisjurnalid;

        if ($_jenis == 'CCN') {
            $jenisJurnal = "CREDIT NOTE";
        } elseif ($_jenis == 'CDN') {
            $jenisJurnal = "DEBIT NOTE";
        } else {
            $jenisJurnal = "TAX INVOICE";
        }
    }

    $pdf->jenisJurnal    = $jenisJurnal;
    $pdf->customer_name = $namacustomer;
    $pdf->Address       = $address;
    $pdf->Noinv         = $nofaktur;
    $pdf->Invoice_date  = $tanggal_invoice;
    $pdf->Term          = $term_val;
    $pdf->Vessel        = $bargevoy;
    $pdf->Reff          = $ctrno;
    $pdf->Delivery_date = $shipmentdate;
    $pdf->contact       = $contact;
    $pdf->phone         = '';
    $pdf->Currency      = $currency;
    $pdf->Shipper       = $shipper;
    $pdf->po_number     = $blno;

    $pdf->Content($piutang, $get_data_detail, $get_data_header);
}
$pdf->Output('BATCH PRINTRING INVOICE '. $p_dari. ' - ' . $p_sampai . '.pdf', 'I');
exit;
