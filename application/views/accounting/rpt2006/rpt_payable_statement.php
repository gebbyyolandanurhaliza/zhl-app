<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(90);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);
	
		$this->Line(10, 41, 250 - 50, 41);
        $this->Ln(2);
    }

    function Content($SupplierID, $get_agings) {
		$this->setFont('arial', 'B', 12);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 5, 'Payable Statement Of Account', 0, 1, 'C', 1);
		
		foreach($SupplierID as $row_SupplierID){
			$alamat = $row_SupplierID->address;
			$address =str_replace('<br />','', $alamat);
			
			$this->setFont('arial', '', 6);
            $this->cell(60, 5, $row_SupplierID->suppliercompany, 0, 1, 'L', 1);
            $this->MultiCell(2500,5,$address,0,'L',1);
            $this->cell(60, 5, "Phone  : " . $row_SupplierID->telephone, 0, 1, 'L', 1);
            $this->cell(60, 5, "email  : " . strtolower($row_SupplierID->email), 0, 1, 'L', 1);
            $this->cell(60, 5, "Contact Person  : " . $row_SupplierID->contactperson, 0, 1, 'L', 1);
		}
        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        //$this->Line(10, 84, 240 - 40, 84);
        $this->cell(55, 6, 'Invoice', 'BT', 0, 'L', 1);
        $this->cell(25, 6, 'Invoice Date', 'BT', 0, 'C', 1);
        $this->cell(25, 6, 'Due Date', 'BT', 0, 'C', 1);
        $this->cell(25, 6, 'Currency', 'BT', 0, 'C', 1);
        $this->cell(30, 6, 'Invoice Amount', 'BT', 0, 'R', 1);
        $this->cell(30, 6, 'Open Amount', 'BT', 1, 'R', 1);
        //$this->Line(10, 90, 240 - 40, 90);

        $this->Ln(2);
		
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);
		$total_inv_amount = 0;
		$total_open_amount = 0;
		foreach ($get_agings as $row_agings) {
			$total_inv_amount += $row_agings->tmp_hutang;
			$total_open_amount += $row_agings->tmp_hutang * $row_agings->tmp_rate - $row_agings->tmp_payment;
			$this->cell(55, 6, $row_agings->tmp_invno, 0, 0, 'L', 1);
            $this->cell(25, 6, date('d/m/Y', strtotime($row_agings->tmp_inv_date)), 0, 0, 'C', 1);
            $this->cell(25, 6, date('d/m/Y', strtotime($row_agings->tmp_due_date)), 0, 0, 'C', 1);
            $this->cell(25, 6, $row_agings->tmp_currency, 0, 0, 'C', 1);
            $this->cell(30, 6, number_format($row_agings->tmp_hutang, 2), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($row_agings->tmp_hutang * $row_agings->tmp_rate - $row_agings->tmp_payment, 2), 0, 1, 'R', 1);
            $NO ++;
		}
		
		$this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->cell(105, 6, 'TOTAL', 'BT', 0, 'L', 1);
        $this->cell(25, 6, '', 'BT', 0, 'R', 1);
        $this->cell(30, 6, number_format($total_inv_amount, 2), 'BT', 0, 'R', 1);
        $this->cell(30, 6, number_format($total_open_amount, 2), 'BT', 1, 'R', 1);
		
		//$this->SetY(-80);
        $this->setFont('Arial', '', 6);
        $this->Ln(4);
        $this->cell(38, 5, 'AGING ANALYSIS IN DAYS:', 0, 1, 'L', 1);
        $this->cell(38, 5, 'Aging On :', 0, 1, 'L', 1);
		
		$this->cell(15, 6, '', 0, 0, 'L', 1);
        $this->cell(35, 6, 'Current', 0, 0, 'R', 1);
        $this->cell(35, 6, '1 to 30 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, '31 to 60 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, '61 to 90 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, 'Over 90 Days', 0, 1, 'R', 1);
        $this->cell(190, 0, '', 1, 1, 'L', 1);
		
		
        $current = 0;
        $tiga = 0;
        $enam = 0;
        $sembilan = 0;
        $lebih = 0;
		foreach($get_agings as $footer_agings){
			$current += $footer_agings->tmp_not_due_date;
			$tiga += $footer_agings->tmp_0sd30;
			$enam += $footer_agings->tmp_31sd60;
			$sembilan += $footer_agings->tmp_61sd90;
			$lebih += $footer_agings->tmp_91sd120 + $footer_agings->tmp_more120;
		}
		
		$this->cell(15, 6, '', 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($current, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($tiga, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($enam, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($sembilan, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($lebih, 2), 0, 1, 'R', 1);
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 6);
        $this->Cell(30, 4, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 4, 'We Reserve the right to charge interest at 1.5% per month & to hold future', 0, 1, 'L');
        $this->Cell(20, 4, 'deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 4, 'Thank you for your kind co-operation.', 0, 1, 'L');
        $this->setFont('Arial', '', 6);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 204, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($SupplierID, $get_agings);
$pdf->Output();
