 <?php 

/**
* Create By   : Fandy Chaniago ( ITD 16 )
* Create Date : 17 November 2017
*/
class PDF extends FPDF
{
	//Page Header
	function header(){
		$title1 = 'Salest Invoice List';
		$this->Image('assets/PSG.png', 12, 10, 25, 0, 'PNG');
        $this->setFont('Arial', 'B', 12);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(85);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(85);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

	    $this->setFont('Arial', 'B', 9);
	    $this->SetTextColor(0, 0, 0);
	    $this->setFillColor(255, 255, 255);
	    $this->Cell(90);
	    $this->cell(20, 6, 'Sales Invoice List '.date('M-Y', strtotime($this->from)), 0, 0, 'C', 1);
	    $this->Ln();

	    $this->setFont('Arial', 'B', 5);
	    $this->setFillColor(255, 255, 255);

		$this->cell(12,6, 'Invoice Date', 1, 0,'C',1);
		$this->cell(12,6, 'Invoice No', 1, 0,'C',1);
		$this->cell(39,6, 'PO', 1, 0,'C',1);
		$this->cell(40,6, 'Customer', 1, 0,'C',1);
		// $this->cell(12,6, 'Currency', 1, 0,'C',1);
		$this->cell(15,6, 'Amount(USD)', 1, 0,'C',1);
		$this->cell(15,6, 'Frt/Others(USD)', 1, 0,'C',1);
		$this->cell(10,6, 'GST(USD)', 1, 0,'C',1);
		$this->cell(14,6, 'Total(USD)', 1, 0,'C',1);
		$this->cell(13,6, 'Amount(SGD)', 1, 0,'C',1);
		$this->cell(10,6, 'GST(SGD)', 1, 0,'C',1);
		$this->cell(10,6, 'Total(SGD)', 1, 1,'C',1);
	}

	//function Content($inv){
	//	$NO = 1;
    //    $this->setFont('Arial', '', 6);
    //    $this->setFillColor(255, 255, 255);
	//	foreach($inv AS $m){
	//		$this->cell(20,6 $m->invno, 0, 0,'D',1);
	//	}
	//}
	function Content($_getInv){
		foreach($_getInv AS $m)
		{
			$NO=1;
			$this->setFont('Arial', 'B', 5);
            $this->setFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $this->setFillColor(255, 255, 255);
			$this->cell(12, 6, $m->docdate,  1, 0, 'L', 1);
			$this->cell(12, 6, $m->invno,  1, 0, 'L', 1);
			$this->cell(39, 6, $m->ponumber, 1, 0, 'L', 1);
			$this->cell(40, 6, $m->custcompany, 1, 0, 'L', 1);
			// $this->cell(12, 6, $m->currency, 1, 0, 'L', 1);
			if($m->currency == 'USD'){
				$this->cell(15, 6, number_format($m->total, 2), 1, 0, 'R', 1);
			}else{
				$this->cell(15, 6, ' ', 1, 0, 'R', 1);
			}

			if($m->currency == 'USD'){
				$this->cell(15, 6, number_format($m->freight, 2), 1, 0, 'R', 1);
			}else{
				$this->cell(15, 6, '', 1, 0, 'R', 1);
			}

			if($m->currency == 'USD'){
				$this->cell(10, 6, $m->tax, 1, 0, 'R', 1);
			}else{
				$this->cell(10, 6, ' ', 1, 0, 'R', 1);
			}

			if($m->currency == 'USD'){
				$this->cell(14, 6, number_format($m->totaldue, 2), 1, 0, 'R', 1);
			}else{
				$this->cell(14, 6, '-', 1, 0, 'R', 1);
			}

			if($m->currency == 'SGD'){
				$this->cell(13, 6, number_format($m->total, 2), 1, 0, 'R', 1);
			}else{
				$this->cell(13, 6, '-', 1, 0, 'R', 1);
			}

			if($m->currency == 'SGD'){
				$this->cell(10, 6, $m->gst, 1, 0, 'R', 1);
			}else{
				$this->cell(10, 6, '-', 1, 0, 'R', 1);
			}

			if($m->currency == 'SGD'){
				$this->cell(10, 6, number_format($m->totaldue, 2), 1, 1, 'R', 1);
			}else{
				$this->cell(10, 6, '-', 1, 1, 'R', 1);
			}

		}
	}

	function Footer(){
		$this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
	}
	
	
	
}

$pdf = new PDF('P','mm','A4');
$pdf->from=$_GET['from'];
$pdf->to=$_GET['to'];;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_getInv);
$pdf->Output();


?>