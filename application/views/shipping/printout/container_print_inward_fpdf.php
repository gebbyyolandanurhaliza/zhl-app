<?php

class PDF1 extends FPDF
{
    function Header()
    {
        $this->SetFont('Times', 'B', 15);
        $this->SetTextColor(0, 0, 0);
        $this->Image('assets/ZHL-Report.png', 100, 5, 20, 20);
        //  $this->Image(base_url().'assets/ZHL-Report.png',100,10,20); 
        $this->Cell(15);
        $this->Cell(0, 10, 'ZHENGHE LOGISTIC PTE LTD', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(40, 5, 'Vessel(Barge)');
        $this->Cell(70, 5, ': ' . strtoupper($this->barge));
        $this->Cell(50, 5, 'CONTAINER INWARD LIST');
        $this->Cell(40, 5, '');
        $this->Cell(35, 5, 'SHIPMENT FROM');
        $this->Cell(30, 5, '  : ' . strtoupper($this->from));
        $this->Ln();
        $this->Cell(40, 5, 'Voyage');
        $this->Cell(70, 5, ': ' . $this->voyage);
        $this->Cell(35, 5, 'SHIPMENT DATE');
        $this->Cell(55, 5, ' : ' . $this->shipment);
        $this->Cell(20, 5, 'TO');
        $this->Cell(30, 5, ': ' . strtoupper($this->to));
        $this->Ln();
        $this->Cell(40, 5, 'ETD ' . $this->etd);
        $this->Cell(50, 5, ': ' . $this->etddate);
        $this->Ln();
        $this->Cell(40, 5, 'ETA ' . $this->eta);
        $this->Cell(50, 5, ': ' . $this->etadate);
        $this->Ln(10);

        $this->SetFillColor(192, 192, 192);
        $this->SetFont('Times', '', 10);
        $this->SetX(10);
        $this->Cell(10, 5, 'No', 1, 0, 'C', 1);
        $this->SetX(20);
        $this->Cell(30, 5, 'Container No', 1, 0, 'C', 1);
        $this->SetX(50);
        $this->Cell(20, 5, 'Seal No', 1, 0, 'C', 1);
        $this->SetX(70);
        $this->Cell(10, 5, "20'", 1, 0, 'C', 1);
        $this->SetX(80);
        $this->Cell(10, 5, "40'", 1, 0, 'C', 1);
        $this->SetX(90);
        $this->Cell(10, 5, 'CT', 1, 0, 'C', 1);
        $this->SetX(100);
        $this->Cell(30, 5, 'Vessel Voyage', 1, 0, 'C', 1);
        $this->SetX(130);
        $this->Cell(20, 5, 'ETA SIN', 1, 0, 'C', 1);
        $this->SetX(150);
        $this->Cell(25, 5, 'POD', 1, 0, 'C', 1);
        $this->SetX(175);
        $this->Cell(35, 5, 'Destination', 1, 0, 'C', 1);
        $this->SetX(210);
        $this->Cell(20, 5, 'OP/SO', 1, 0, 'C', 1);
        $this->SetX(230);
        $this->Cell(30, 5, 'Carrier', 1, 0, 'C', 1);
        $this->SetX(258);
        $this->Cell(15, 5, 'Weight', 1, 0, 'C', 1);
        // $this->SetX(273);
        // $this->Cell(15,5,'Stuffing',1,0,'C',1);
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

foreach ($_getcont as $r) {
    $barge = $r->barge;
    $voyage = $r->voyage;
    $etd = $r->etd;
    $eta = $r->eta;
    $etddateTemp = $r->etddate;
    $etadateTemp = $r->etadate;
    $shipment = date("d M Y",  strtotime($r->shipmentdate));
    $from = $r->from;
    $to = $r->to;
    $remarks = $r->remarks;
    //        $stuffing=$r->stuffing;

    if ($etddateTemp != '0000-00-00') {
        $etddate = date("d/m/Y",  strtotime($etddateTemp));
    } else {
        $etddate = '';
    }

    if ($etadateTemp != '0000-00-00') {
        $etadate = date("d/m/Y",  strtotime($etadateTemp));
    } else {
        $etadate = '';
    }
}

$pdf = new PDF1('L', 'mm', 'A4');
$pdf->barge = $barge;
$pdf->voyage = $voyage;
$pdf->etd = $etd;
$pdf->etddate = $etddate;
$pdf->eta = $eta;
$pdf->etadate = $etadate;
$pdf->shipment = $shipment;
$pdf->from = $from;
$pdf->to = $to;
//    $pdf->stuffing=$stuffing;

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 7);
$totc20 = 0;
$totc40 = 0;
$i = 1;
$yawal = $pdf->GetY();
$ytemp = 0;
foreach ($_getcont as $r) {
    $y = $pdf->GetY() - $ytemp;
    //        $pdf->Line(10, $y, 288, $y);
    $pdf->Line(10, $y, 273, $y);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(10, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(20, $y);
    $pdf->MultiCell(30, 5, $r->container, 0, 'C');
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(20, 5, $r->actual_seal, 0, 'C');
    $pdf->SetXY(70, $y);
    $pdf->MultiCell(10, 5, $r->c20, 0, 'C');
    $pdf->SetXY(80, $y);
    $pdf->MultiCell(10, 5, $r->c40, 0, 'C');
    $pdf->SetXY(90, $y);
    $pdf->MultiCell(10, 5, $r->container_abbr, 0, 'C');
    $pdf->SetXY(100, $y);
    $pdf->MultiCell(30, 5, $r->vessel, 0, 'C');
    $pdf->SetXY(130, $y);
    $pdf->MultiCell(20, 5, $r->etdsin, 0, 'C');
    $pdf->SetXY(150, $y);
    $pdf->MultiCell(25, 5, $r->pod, 0, 'C');
    $pdf->SetXY(175, $y);
    $pdf->MultiCell(35, 5, $r->destination, 0, 'C');
    $pdf->SetXY(205, $y);
    $pdf->MultiCell(30, 5, $r->opcode, 0, 'C');
    $pdf->SetXY(235, $y);
    $pdf->MultiCell(20, 5, $r->shipping_liner, 0, 'C');
    $pdf->SetXY(260, $y);
    $pdf->MultiCell(10, 5,  number_format($r->total_gross_weight + $r->tare_weight, 4), 0, 'C');
    $pdf->Ln();
    $pdf->SetXY(50, $y + 5);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->MultiCell(20, 5, $r->actual_seal, 0, 'C');

    $y2 = $pdf->GetY();
    $pdf->Line(10, $yawal, 10, $y2);
    $pdf->Line(20, $yawal, 20, $y2);
    $pdf->Line(50, $yawal, 50, $y2);
    $pdf->Line(70, $yawal, 70, $y2);
    $pdf->Line(80, $yawal, 80, $y2);
    $pdf->Line(90, $yawal, 90, $y2);
    $pdf->Line(100, $yawal, 100, $y2);
    $pdf->Line(130, $yawal, 130, $y2);
    $pdf->Line(150, $yawal, 150, $y2);
    $pdf->Line(175, $yawal, 175, $y2);
    $pdf->Line(210, $yawal, 210, $y2);
    $pdf->Line(230, $yawal, 230, $y2);
    $pdf->Line(258, $yawal, 258, $y2);
    $pdf->Line(273, $yawal, 273, $y2);
    // $pdf->Line(288, $yawal, 288, $y2);

    if ($y > 170) {
        $y3 = $pdf->GetY();
        $pdf->Line(10, $y3, 288, $y3);
        $pdf->AddPage();
    }

    $totc20 = $totc20 + $r->c20;
    $totc40 = $totc40 + $r->c40;
    $i++;
}

$y4 = $pdf->GetY();
//    $pdf->Line(10, $y4, 288, $y4);
$pdf->Line(10, $y4, 273, $y4);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(70);
$pdf->Cell(10, 5, $totc20, 1, 0, 'C', 1);
$pdf->SetX(80);
$pdf->Cell(10, 5, $totc40, 1, 0, 'C', 1);
$pdf->Ln(10);

$pdf->SetFont('Times', '', 12);
//    $pdf->Cell(10);
//    $pdf->Cell(30,5,'All Shipment will Be Stow Under Deck Away Boiler (UDAB),Unless Otherwise Secify');
$y5 = $pdf->GetY();
$pdf->SetXY(20, $y5);
$pdf->MultiCell(250, 5, str_replace("<br />", "", $remarks));
$pdf->Ln(20);
$pdf->Cell(10);
$pdf->Cell(30, 5, 'Return Container');
$pdf->Ln();


$pdf->SetFillColor(192, 192, 192);
$pdf->SetFont('Times', '', 10);
$pdf->SetX(10);
$pdf->Cell(10, 5, 'No', 1, 0, 'C', 1);
$pdf->SetX(20);
$pdf->Cell(30, 5, 'Container No', 1, 0, 'C', 1);
$pdf->SetX(50);
$pdf->Cell(20, 5, "20'", 1, 0, 'C', 1);
$pdf->SetX(70);
$pdf->Cell(10, 5, "40'", 1, 0, 'C', 1);
$pdf->SetX(80);
$pdf->Cell(10, 5, 'CT', 1, 0, 'C', 1);
$pdf->SetX(90);
$pdf->Cell(60, 5, 'Remark', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 10);
$pdf->SetX(10);
$pdf->Cell(10, 15, '', 1, 0, 'C', 1);
$pdf->SetX(20);
$pdf->Cell(30, 15, '', 1, 0, 'C', 1);
$pdf->SetX(50);
$pdf->Cell(20, 15, '', 1, 0, 'C', 1);
$pdf->SetX(70);
$pdf->Cell(10, 15, '', 1, 0, 'C', 1);
$pdf->SetX(80);
$pdf->Cell(10, 15, '', 1, 0, 'C', 1);
$pdf->SetX(90);
$pdf->Cell(60, 15, '', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->Output('inward-' . date("dmy") . '.pdf', 'I');
