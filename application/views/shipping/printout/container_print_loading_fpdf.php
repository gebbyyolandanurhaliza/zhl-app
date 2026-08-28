<?php

class PDF extends FPDF
{
    function Header()
    {
        $this->SetX(10);
        $this->Cell(190, 25, '', 0, 0);
        $this->Image('assets/zhlkop.PNG', 16, 3, 180, 33);
        $this->Line(10, 35, 250 - 50, 35);
        // $this->Image(base_url().'assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);
        $this->Ln(7);
        $this->SetFont('Times', '', 8);
        $this->SetX(11);
        $this->Cell(30, 4, 'DATE');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->date);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30, 4, 'TO');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->to);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30, 4, 'ATTN');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->attn);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30, 4, 'FROM');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->from);
        $this->Ln(10);
        $this->SetFont('Times', 'B', 8);
        $this->SetX(11);
        $this->Cell(20, 4, 'RE :');
        $this->SetX(46);
        $this->Cell(75, 4, 'LOADING CONFIRMATION');
        $this->Ln();
        $this->SetX(135);
        $this->Cell(66, 4, 'PORTNET DECLARATION', 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', '', 8);
        $this->SetX(11);
        $this->Cell(35, 4, 'CONTAINER NO', 'LTB', 0, 'L');
        $this->SetX(36);
        $this->Cell(45, 4, 'SEAL', 'LTB', 0, 'L');
        $this->SetX(55);
        $this->Cell(35, 4, 'BOOKING REF', 'LTB', 0, 'L');
        $this->SetX(85);
        $this->Cell(35, 4, 'VESSEL / VOYAGE', 'LTB', 0, 'L');
        $this->SetX(120);
        $this->Cell(45, 4, 'OP CODE', 'LTB', 0, 'L');
        $this->SetX(135);
        $this->Cell(35, 4, 'PORT OF DISCH', 'LB', 0, 'L');
        $this->SetX(161);
        $this->Cell(40, 4, 'DESTINATION', 'LBR', 0, 'L');
        $this->ln();
    }

    function Footer()
    {
        $this->SetY(-70);
        $this->SetX(11);
        $this->Cell(30, 4, '1st Carrier');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->carrier);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30, 4, 'Voyage');
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->voyage);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30, 4, 'ETA Sin');
        $this->SetFont('Times', 'B', 8);
        $this->SetX(46);
        $this->Cell(40, 4, ': ' . $this->eta);
        $this->Ln(10);
        $this->SetX(11);
        $this->Cell(70, 4, 'PLS CONFIRM ALL DETAILS ARE CORRECT BEFORE 1ST CARRIER ARRIVAL');
        $this->Ln();
        $this->SetFont('Times', '', 8);
        $this->SetX(11);
        $this->Cell(70, 4, 'CONTAINER MUST BE STOWE "UNDER DECK AWAY BOILER"');
        $this->Ln();
        $this->SetX(11);
        $this->Cell(70, 4, 'CONTAINERS ARE DECLARED UNDER TRANSSHIPMENT');
        $this->Ln();
        $this->SetX(11);
        $this->Cell(70, 4, 'PLS INFORM US IMMEDIATELY OF ANY DISCREPANCY BEFORE 1st CARRIER ARRIVAL');
        $this->Ln();
    }
}

foreach ($_getcont as $r) {
    $date = date("d/m/Y",  strtotime($r->docdate));
    $to = $r->to;
    $attn = $r->attn;
    $from = $r->from;
    $carrier = $r->carrier;
    $voyage = $r->voyage;
    $eta = date("d/m/Y",  strtotime($r->etasin));
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->date = $date;
$pdf->to = $to;
$pdf->attn = $attn;
$pdf->from = $from;
$pdf->carrier = $carrier;
$pdf->voyage = $voyage;
$pdf->eta = $eta;


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$yawal = $pdf->GetY();

foreach ($_getcont as $r) {
    $y = $pdf->GetY();

    $pdf->SetXY(11, $y);
    $pdf->MultiCell(35, 4, $r->container);
    $pdf->SetXY(36, $y);
    $pdf->MultiCell(29, 4, $r->seal);
    $pdf->SetXY(55, $y);
    $pdf->MultiCell(30, 4, $r->reff);
    $pdf->SetXY(85, $y);
    $pdf->MultiCell(35, 4, $r->vessel);
    $pdf->SetXY(120, $y);
    $pdf->MultiCell(15, 4, $r->opcode);
    $pdf->SetXY(135, $y);
    $pdf->MultiCell(26, 4, $r->port);
    $pdf->SetXY(161, $y);
    $pdf->MultiCell(40, 4, $r->destination);
    $pdf->Ln();

    $y1 = $pdf->GetY() - 5;
    if ($y1 > 250) {
        $pdf->AddPage();
    }
}
$y2 = $pdf->GetY();
$pdf->Line(11, $yawal, 11, $y2);
$pdf->Line(36, $yawal, 36, $y2);
$pdf->Line(55, $yawal, 55, $y2);
$pdf->Line(85, $yawal, 85, $y2);
$pdf->Line(120, $yawal, 120, $y2);
$pdf->Line(135, $yawal, 135, $y2);
$pdf->Line(161, $yawal, 161, $y2);
$pdf->Line(201, $yawal, 201, $y2);
$pdf->Line(11, $y2, 201, $y2);

$pdf->Output('Loading Confirmation ' . date('dmy') . 'pdf', 'I');
