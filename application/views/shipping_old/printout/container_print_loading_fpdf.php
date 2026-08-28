<?php

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Times','B',15);
        $this->Image(base_url().'assets/ps.png',25,5,30);
        $this->SetX(11);
        $this->Cell(0,10,'PULAU SAMBU SINGAPORE PTE LTD',0,0,'C');
        $this->Ln(30);
        $this->SetFont('Times','',8);
        $this->SetX(11);
        $this->Cell(30,4,'DATE');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->date);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30,4,'TO');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->to);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30,4,'ATTN');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->attn);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30,4,'FROM');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->from);
        $this->Ln(10);
        $this->SetFont('Times','B',8);
        $this->SetX(11);
        $this->Cell(20,4,'RE :');
        $this->SetX(46);
        $this->Cell(75,4,'LOADING CONFIRMATION');
        $this->Ln();
        $this->SetX(126);
        $this->Cell(75,4,'PORTNET DECLARATION',1,0,'C');
        $this->Ln();
        $this->SetFont('Times','',8);
        $this->SetX(11);
        $this->Cell(35,4,'CONTAINER NO','LTB',0,'C');
        $this->SetX(46);
        $this->Cell(35,4,'BOOKING REF','LTB',0,'C');
        $this->SetX(81);
        $this->Cell(45,4,'VESSEL / VOYAGE','LTB',0,'C');
        $this->SetX(126);
        $this->Cell(35,4,'PORT OF DISCH','LB',0,'C');
        $this->SetX(161);
        $this->Cell(40,4,'DESTINATION','LBR',0,'C');
        $this->ln();
        
    }
    
    function Footer() {
        $this->SetY(-70);
        $this->SetX(11);
        $this->Cell(30,4,'1st Carrier');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->carrier);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30,4,'Voyage');
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->voyage);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(30,4,'ETA Sin');
        $this->SetFont('Times','B',8);
        $this->SetX(46);
        $this->Cell(40,4,': '.$this->eta);
        $this->Ln(10);
        $this->SetX(11);
        $this->Cell(70,4,'PLS CONFIRM ALL DETAILS ARE CORRECT BEFORE 1ST CARRIER ARRIVAL');
        $this->Ln();
        $this->SetFont('Times','',8);
        $this->SetX(11);
        $this->Cell(70,4,'CONTAINER MUST BE STOWE "UNDER DECK AWAY BOILER"');
        $this->Ln();
        $this->SetX(11);
        $this->Cell(70,4,'CONTAINERS ARE DECLARED UNDER TRANSSHIPMENT');
        $this->Ln();
        $this->SetX(11);
        $this->Cell(70,4,'PLS INFORM US IMMEDIATELY OF ANY DISCREPANCY BEFORE 1st CARRIER ARRIVAL');
        $this->Ln();
    }
}

foreach ($_getcont as $r){
    $date=date("d/m/Y",  strtotime($r->docdate));
    $to=$r->to;
    $attn=$r->attn;
    $from=$r->from;
    $carrier=$r->carrier;
    $voyage=$r->voyage;
    $eta= date("d/m/Y",  strtotime($r->etasin));
}

$pdf = new PDF('P','mm','A4');
$pdf->date=$date;
$pdf->to=$to;
$pdf->attn=$attn;
$pdf->from=$from;
$pdf->carrier=$carrier;
$pdf->voyage=$voyage;
$pdf->eta=$eta;


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
$yawal = $pdf->GetY();

foreach ($_getcont as $r){
    $y = $pdf->GetY();
    
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(35, 4, $r->container);
    $pdf->SetXY(46, $y);
    $pdf->MultiCell(35, 4, $r->reff);
    $pdf->SetXY(81, $y);
    $pdf->MultiCell(45, 4, $r->vessel);
    $pdf->SetXY(126, $y);
    $pdf->MultiCell(35, 4, $r->port);
    $pdf->SetXY(161, $y);
    $pdf->MultiCell(40, 4, $r->destination);
    $pdf->Ln();
    
    $y1 = $pdf->GetY() - 5;
    if($y1 > 250){
        $pdf->AddPage();
    }
}
$y2=$pdf->GetY();
$pdf->Line(11, $yawal, 11, $y2);
$pdf->Line(46, $yawal, 46, $y2);
$pdf->Line(81, $yawal, 81, $y2);
$pdf->Line(126, $yawal, 126, $y2);
$pdf->Line(161, $yawal, 161, $y2);
$pdf->Line(201, $yawal, 201, $y2);
$pdf->Line(11, $y2, 201, $y2);

$pdf->Output('Loading Confirmation '.date('dmy').'pdf','I');