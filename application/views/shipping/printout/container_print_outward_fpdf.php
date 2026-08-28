<?php

class PDF2 extends FPDF
{
    function Header()
    {
        $this->SetFont('Times', 'B', 15);
        $this->Image('assets/ZHL-Report.png', 100, 5, 20, 20);
        $this->Cell(15);
        $this->Cell(0, 10, 'ZHENGHE LOGISTIC PTE LTD', 0, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(40, 5, 'Vessel(Barge)');
        $this->Cell(70, 5, ': ' . strtoupper($this->barge));
        $this->Cell(50, 5, 'CONTAINER OUTWARD LIST');
        $this->Cell(50, 5, '');
        $this->Cell(20, 5, 'TO');
        $this->Cell(30, 5, ': ' . strtoupper($this->to));
        $this->Ln();
        $this->Cell(40, 5, 'Voyage');
        $this->Cell(70, 5, ': ' . $this->voyage);
        $this->Cell(35, 5, 'SHIPMENT DATE');
        $this->Cell(65, 5, ' : ' . $this->shipment);
        $this->Cell(20, 5, 'FROM');
        $this->Cell(30, 5, ': ' . $this->createdby);
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
        $this->Cell(30, 5, 'Shipper/Carrier', 1, 0, 'C', 1);
        $this->SetX(50);
        $this->Cell(40, 5, 'Vessel/Voyage', 1, 0, 'C', 1);
        $this->SetX(90);
        $this->Cell(10, 5, "20'", 1, 0, 'C', 1);
        $this->SetX(100);
        $this->Cell(10, 5, "40'", 1, 0, 'C', 1);
        $this->SetX(110);
        $this->Cell(10, 5, 'CT', 1, 0, 'C', 1);
        $this->SetX(120);
        $this->Cell(35, 5, 'Booking Ref', 1, 0, 'C', 1);
        $this->SetX(155);
        $this->Cell(20, 5, 'Depot', 1, 0, 'C', 1);
        $this->SetX(175);
        $this->Cell(25, 5, 'POD', 1, 0, 'C', 1);
        $this->SetX(200);
        $this->Cell(30, 5, 'Destination', 1, 0, 'C', 1);
        $this->SetX(230);
        $this->Cell(20, 5, 'OP Code', 1, 0, 'C', 1);
        $this->SetX(250);
        $this->Cell(20, 5, 'ETD SIN', 1, 0, 'C', 1);
        $this->SetX(270);
        $this->Cell(15, 5, 'Stuffing', 1, 0, 'C', 1);
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
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
    $createdby = $r->createdby;
    $stuffing = $r->stuffing;

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

$pdf = new PDF2('L', 'mm', 'A4');
$pdf->barge = $barge;
$pdf->voyage = $voyage;
$pdf->etd = $etd;
$pdf->etddate = $etddate;
$pdf->eta = $eta;
$pdf->etadate = $etadate;
$pdf->shipment = $shipment;
$pdf->from = $from;
$pdf->to = $to;
$pdf->createdby = $createdby;
$pdf->stuffing = $stuffing;

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
    $y = $pdf->GetY() + $ytemp;
    $pdf->Line(10, $y, 285, $y);

    $pdf->SetXY(10, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(20, $y);
    $pdf->MultiCell(30, 5, $r->shipping_liner, 0, 'C');
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(40, 5, $r->vessel, 0, 'C');
    $pdf->SetXY(90, $y);
    $pdf->MultiCell(10, 5, $r->c20, 0, 'C');
    $pdf->SetXY(100, $y);
    $pdf->MultiCell(10, 5, $r->c40, 0, 'C');
    $pdf->SetXY(110, $y);
    $pdf->MultiCell(10, 5, $r->container_abbr, 0, 'C');
    $pdf->SetXY(120, $y);
    $pdf->MultiCell(35, 5, $r->reff, 0, 'C');
    $pdf->SetXY(155, $y);
    $pdf->MultiCell(20, 5, $r->depot_name, 0, 'C');
    $pdf->SetXY(175, $y);
    $pdf->MultiCell(25, 5, $r->pod, 0, 'C');
    $pdf->SetXY(200, $y);
    $pdf->MultiCell(30, 5, $r->destination, 0, 'C');
    $pdf->SetXY(230, $y);
    $pdf->MultiCell(20, 5, $r->opcode, 0, 'C');
    $pdf->SetXY(250, $y);
    $pdf->MultiCell(20, 5, $r->etdsin, 0, 'C');
    $pdf->SetXY(270, $y);
    $pdf->MultiCell(15, 5, $r->stuffing, 0, 'C');
    $pdf->Ln();

    $y2 = $pdf->GetY();
    $pdf->Line(10, $yawal, 10, $y2);
    $pdf->Line(20, $yawal, 20, $y2);
    $pdf->Line(50, $yawal, 50, $y2);
    $pdf->Line(90, $yawal, 90, $y2);
    $pdf->Line(100, $yawal, 100, $y2);
    $pdf->Line(110, $yawal, 110, $y2);
    $pdf->Line(120, $yawal, 120, $y2);
    $pdf->Line(155, $yawal, 155, $y2);
    $pdf->Line(175, $yawal, 175, $y2);
    $pdf->Line(200, $yawal, 200, $y2);
    $pdf->Line(230, $yawal, 230, $y2);
    $pdf->Line(250, $yawal, 250, $y2);
    $pdf->Line(270, $yawal, 270, $y2);
    $pdf->Line(285, $yawal, 285, $y2);

    $max = $pdf->NbLines(20, $r->depot) - 1;

    if ($max > 1) {
        $ytemp = $max * 4;
    } else {
        $ytemp = 0;
    }

    if ($y > 170) {
        $y3 = $pdf->GetY();
        $pdf->Line(10, $y3, 285, $y3);
        $pdf->AddPage();
    }

    $totc20 = $totc20 + $r->c20;
    $totc40 = $totc40 + $r->c40;
    $i++;
}

$y4 = $pdf->GetY();
$pdf->Line(10, $y4, 285, $y4);

$pdf->SetX(100);
$pdf->Cell(10, 5, $totc20, 1, 0, 'C', 1);
$pdf->SetX(110);
$pdf->Cell(10, 5, $totc40, 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30, 5, 'Remarks');
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(150, 5, str_replace("<br />", "", $remarks));
$pdf->Ln();



$pdf->Output('outward-' . date("dmy") . '.pdf', 'I');
