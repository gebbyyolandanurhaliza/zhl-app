<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $this->Image('assets/PSG.png', 10, 10, 35, 0, 'PNG');
        $this->setFont('Arial', 'B', 20);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(50, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', '', 8);
        $this->Cell(90);
        $this->cell(40, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', '', 12);
        $this->Cell(90);
        $this->cell(40, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', '', 10);
        $this->Cell(90);
        $this->cell(40, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', '', 12);
        $this->Cell(90);
        $this->cell(40, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 55, 260 - 50, 55);
        $this->Line(10, 55, 260 - 50, 55);

        $this->Ln(20);
        $this->setFont('Arial', 'B', 22);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(90);
        $this->cell(40, 6, 'Payable Recognition', 0, 1, 'C', 1);
       
        $this->Ln(5);
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);
        $this->cell(20, 6, 'Ref', 1, 0, 'C', 1);
        $this->cell(150, 6, 'Description', 1, 0, 'C', 1);
        $this->cell(30, 6, 'Amount (USD)', 1, 1, 'C', 1);
    }

    function Content($get_data_detail) {
        $ya = 46;
        $rw = 6;
        $NO = 1;
        foreach ($get_data_detail as $key) {
            $this->setFont('Arial', '', 10);
            $this->setFillColor(255, 255, 255);
            $this->cell(20, 6, '', 0, 0, 'L', 1);
            $this->cell(150, 6, $NO . ' ' .$key->Items . ''  , 0, 0, 'L', 1);
            $this->cell(30, 6, number_format($key->Qty * $key->Harga, 2, '.', ''), 0, 1, 'R', 1);
            $ya = $ya + $rw;
            $NO ++;
        }
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        $this->setFont('Arial', 'B', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail);
$pdf->Output();
