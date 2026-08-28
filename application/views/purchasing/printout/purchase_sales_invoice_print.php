<?php

class PDF2 extends FPDF
{
	function Header()
	{
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('Times', 'B', 10);
		$this->SetX(140);
		$this->Cell(30, 4, 'SALES INVOICE LIST', 0, 0, 'C');
		$this->Image('assets/ZHL-Report.png', 210, 10, 15);
		$this->Ln();
		$this->SetX(130);
		$this->Cell(30, 5, 'ZHENGHE LOGISTIC PTE LTD');
		$this->Ln(10);

		$this->SetFillColor(192, 192, 192);
		$this->SetFont('Times', '', 10);
		$this->SetX(10);
		$this->Cell(10, 5, 'No', 1, 0, 'C', 1);
		$this->SetX(20);
		$this->Cell(30, 5, 'Invoice no', 1, 0, 'C', 1);
		$this->SetX(50);
		$this->Cell(20, 5, 'Doc Date', 1, 0, 'C', 1);
		$this->SetX(70);
		$this->Cell(35, 5, 'Customer Company', 1, 0, 'C', 1);
		$this->SetX(105);
		$this->Cell(25, 5, 'Main SO', 1, 0, 'C', 1);
		$this->SetX(130);
		$this->Cell(20, 5, 'Tax Code', 1, 0, 'C', 1);
		// $this->SetX(115);
		// $this->Cell(30, 5, 'Currency', 1, 0, 'C', 1);
		// $this->SetX(145);
		// $this->Cell(45, 5, 'Rate', 1, 0, 'C', 1);
		// $this->SetX(190);
		// $this->Cell(20, 5, 'Total FC', 1, 0, 'C', 1);
		// $this->SetX(210);
		// $this->Cell(65, 5, 'Total LC', 1, 0, 'C', 1);
		// $this->SetX(275);
		// $this->Cell(15, 5, 'Total FC / LC', 1, 0, 'C', 1);
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


foreach ($_Getinv as $r) {
	$invno = $r->invno;
	$mainso = $r->mainso;
	$custcompany = $r->custcompany;
	$taxcode = $r->taxcode;
	$currency = $r->currency;
	$total = $r->total;
	$docdate = date("d M Y",  strtotime($r->docdate));
	$item = $r->item;
}

$pdf = new PDF2('L', 'mm', 'A4');
$pdf->invno = $invno;
$pdf->mainso = $mainso;
$pdf->custcompany = $custcompany;
$pdf->taxcode = $taxcode;
$pdf->currency = $currency;
$pdf->total = $total;
$pdf->shidocdatepment = $docdate;
$pdf->item = $item;

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 8);
$totc20 = 0;
$totc40 = 0;
$i = 1;
$x = 0;
$br = 0;
$maxpc = 0;
$yawal = $pdf->GetY();
$ytemp = 0;
$po_temp = '';
foreach ($_Getinv as $r) {
	$y = $pdf->GetY();
	if ($po_temp != $r->invno) {
		$maxpc = 0;
		$x = 0;
		$br = 0;
		$pdf->Line(10, $y, 290, $y);
		$pdf->SetXY(10, $y);
		$pdf->MultiCell(10, 5, $i, 0, 'C');
		$pdf->SetXY(20, $y);
		$pdf->MultiCell(30, 5, $r->invno, 0, 'C');
		// $pdf->SetXY(20, $y);
		// $pdf->SetTextColor(194, 8, 8);
		// $pdf->MultiCell(30, 15, $r->docdate, 0, 'C');
		// $pdf->SetXY(50, $y);
		// $pdf->SetTextColor(0, 0, 0);
		// $pdf->MultiCell(10, 5, $r->custcompany, 0, 'C');
		// $pdf->SetXY(60, $y);
		// $pdf->MultiCell(10, 5, $r->mainso, 0, 'C');
		// $pdf->SetXY(70, $y);
		// $pdf->MultiCell(10, 5, $r->taxcode, 0, 'C');
		// $pdf->SetXY(80, $y);
		// $pdf->MultiCell(35, 5, $r->currency, 0, 'C');
		// $pdf->SetXY(115, $y);
		// $pdf->MultiCell(30, 5, $r->rate, 0, 'C');
		// $pdf->SetXY(276, $y);
		// $pdf->MultiCell(15, 5, $r->item, 0, 'C');
	}


	if ($x > 0) {
		$x = 0;
		$maxpc = 0;
	}


	$pdf->Ln();

	$maxcont = $pdf->NbLines(35, $r->container) - 1;
	$maxpc = $pdf->NbLines(45, ($r->productitem_name)) - 1;

	$y5 = $pdf->GetY() - 5;
	if ($po_temp != $r->po_number) {
		$pdf->SetXY(80, $y5 + ($maxcont * 5));
		$pdf->MultiCell(35, 5, $r->seal, 0, 'C');
		$pdf->SetTextColor(194, 8, 8);
		$pdf->SetXY(80, $y5 + ($maxcont * 5) + 5);
		$pdf->MultiCell(35, 5, $r->actual_seal, 0, 'C');
		$pdf->SetTextColor(0, 0, 0);
	}

	if ($po_temp != $r->po_number) {
		$br = $br + 1;
		$pdf->SetXY(210, $y5);
		$pdf->MultiCell(80, 5, 'VESL/VOY : ' . $r->vessel);
	}
	$pdf->Ln();

	if ($po_temp != $r->po_number) {
		if ($r->convessel != '' && strtoupper($r->convessel) != 'X') {
			$br = $br + 1;
			$y6 = $pdf->GetY() - 5;
			$pdf->SetXY(210, $y6);
			$pdf->MultiCell(80, 5, 'Connecting Vessel : ' . $r->convessel);
			$pdf->Ln();
		}
		$br = $br + 1;
		$y7 = $pdf->GetY() - 5;
		$pdf->SetXY(210, $y7);
		$pdf->MultiCell(80, 5, 'BKG REF : ' . $r->reff);
		$pdf->Ln();

		if ($r->shipping != '' && isset($r->shipping)) {
			$br = $br + 1;
			$y8 = $pdf->GetY() - 5;
			$pdf->SetXY(210, $y8);
			$pdf->MultiCell(80, 5, 'CARRIER : ' . $r->shipping);
			$pdf->Ln();
		}

		$totc20 = $totc20 + $r->c20;
		$totc40 = $totc40 + $r->c40;
		$i++;

		if ($br == 2) {
			$pdf->Ln();
		}
	}

	$po_temp = $r->po_number;


	$y2 = $pdf->GetY();
	$pdf->Line(10, $yawal, 10, $y2);
	$pdf->Line(20, $yawal, 20, $y2);
	$pdf->Line(50, $yawal, 50, $y2);
	$pdf->Line(60, $yawal, 60, $y2);
	$pdf->Line(70, $yawal, 70, $y2);
	$pdf->Line(80, $yawal, 80, $y2);
	$pdf->Line(115, $yawal, 115, $y2);
	$pdf->Line(145, $yawal, 145, $y2);
	$pdf->Line(190, $yawal, 190, $y2);
	$pdf->Line(210, $yawal, 210, $y2);
	$pdf->Line(275, $yawal, 275, $y2);
	$pdf->Line(290, $yawal, 290, $y2);


	if ($y > 140) {
		$x = 1;
		$y3 = $pdf->GetY();
		$pdf->Line(10, $y3, 290, $y3);
		$pdf->AddPage();
	}
}

$y4 = $pdf->GetY();
$pdf->Line(10, $y4, 290, $y4);

$pdf->SetX(50);
$pdf->Cell(10, 5, $totc20, 1, 0, 'C', 1);
$pdf->SetX(60);
$pdf->Cell(10, 5, $totc40, 1, 0, 'C', 1);



$pdf->Output('outward-' . date("dmy") . '.pdf', 'I');
