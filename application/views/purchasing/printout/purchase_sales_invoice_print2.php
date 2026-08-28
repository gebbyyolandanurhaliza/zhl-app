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
        $this->cell(110, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(110, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(110, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(85);
        $this->cell(110, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(110, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

	    $this->setFont('Arial', 'B', 9);
	    $this->SetTextColor(0, 0, 0);
	    $this->setFillColor(255, 255, 255);
	    $this->Cell(90);
	    $this->cell(100, 6, 'Sales Invoice '.date('d-m-Y', strtotime($this->from)).' to '.date('d-m-Y', strtotime($this->to)), 0, 0, 'C', 1);
	    $this->Ln();

	    $this->setFont('Arial', 'B', 6);
	    $this->setFillColor(255, 255, 255);

		$this->cell(22,6, 'Invoice no', 1, 0,'C',1);
		$this->cell(22,6, 'Doc Date', 1, 0,'C',1);
		$this->cell(42,6, 'Customer Company', 1, 0,'C',1);
		$this->cell(22,6, 'Main PO', 1, 0,'C',1);
		$this->cell(22,6, 'Tax Code', 1, 0,'C',1);
		$this->cell(22,6, 'Currency', 1, 0,'C',1);
		$this->cell(21,6, 'Rate', 1, 0,'C',1);
		$this->cell(21,6, 'Total FC', 1, 0,'C',1);
		$this->cell(21,6, 'Total LC', 1, 0,'C',1);
		$this->cell(21,6, 'Total FC / LC', 1, 0,'C',1);
		$this->cell(40,6, 'Vendor', 1, 1,'C',1);
	}

	function Content($_Getinv){
		foreach ($_Getinv as $m) {
			$this->setFont('Arial', '', 6);
			$this->setFillColor(255, 255, 255);
			$this->SetTextColor(0, 0, 0);
			$this->setFillColor(255, 255, 255);
			$this->cell(22, 6, $m->invno,  1, 0, 'C', 1);
			$this->cell(22, 6, $m->docdate,  1, 0, 'C', 1);
			$this->cell(42, 6, $m->custcompany, 1, 0, 'L', 1);
			$this->cell(22, 6, $m->mainpo, 1, 0, 'C', 1);
			$this->cell(22, 6, $m->taxcode, 1, 0, 'C', 1);
			$this->cell(22, 6, $m->currency, 1, 0, 'C', 1);
			$this->cell(21, 6, $m->rate, 1, 0, 'C', 1);
			if($m->currency == 'SGD'){
				$this->cell(21, 6, $m->total, 1, 0, 'C', 1);
			}else{
				$this->cell(21, 6, ' ', 1, 0, 'C', 1);
			}
			if($m->currency == 'USD'){
				$this->cell(21, 6, $m->total, 1, 0, 'C', 1);
			}else{
				$this->cell(21, 6, ' ', 1, 0, 'C', 1);
			}
			if($m->currency == 'SGD'){
				$this->cell(21, 6, ($m->rate * $m->total), 1, 0, 'C', 1);
			}else{
				$this->cell(21, 6, ($m->rate * $m->total), 1, 0, 'C', 1);
			}
			$this->cell(40, 6, '',  1, 1, 'L', 1);
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

$pdf = new PDF('L','mm','A4');
$pdf->from=$_GET['from'];
$pdf->to=$_GET['to'];;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_Getinv);
$pdf->Output();


?>