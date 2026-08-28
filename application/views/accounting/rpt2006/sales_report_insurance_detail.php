<?php

class PDF extends FPDF {

    //Page header
    function Header() {

        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(80);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
        $this->Ln(5);
    }

    function Content($_tampil_item) {
        $this->setFont('Arial', 'B', 14);
        $this->setFillColor(255, 255, 255);
        $this->cell(190, 5, 'PRODUCT LIABILITY INSURANCE', 0, 1, 'C', 1);

        $this->Line(10, 58, 250 - 50, 58);
        //$this->Line(10, 42, 325 - 40, 42);
        $y=$this->GetY()+10;
        $this->SetY($y);
        $this->setFont('Arial', 'B', 8);

        $this->cell(20, 6, 'No. Invoice', 0, 0, 'C', 1);
        $this->cell(50, 6, 'PRODUCT', 0, 0, 'C', 1);
        $this->cell(60, 6, 'USA AND AUSTRALIA', 0, 0, 'C', 1);
        $this->cell(60, 6, 'REST OF THE WORLD', 0, 1, 'C', 1);

        $this->Line(80, 65, 240 - 40, 65);


        $this->cell(20, 6, '', 0, 0, 'C', 1);
        $this->cell(50, 6, '', 0, 0, 'C', 1);
        $this->cell(30, 6, 'CWP 1', 0, 0, 'C', 1);
        $this->cell(30, 6, 'CWP 2', 0, 0, 'C', 1);
        $this->cell(30, 6, 'CWP 1', 0, 0, 'C', 1);
        $this->cell(30, 6, 'CWP 2', 0, 1, 'C', 1);

        $this->Line(10, 72, 250 - 50, 72);
        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $cwp1_USA = 0;
        $cwp2_USA = 0;
        $a_cwp1_USA = 0;
        $a_cwp2_USA = 0;
       foreach ($_tampil_item as $data) {
            $cwp1_USA += $data->tmp_total_cwp1_USA_AUS;
            $cwp2_USA += $data->tmp_total_cwp2_USA_AUS;
            $a_cwp1_USA += $data->tmp_total_cwp1_OTHER;
            $a_cwp2_USA += $data->tmp_total_cwp2_OTHER;

            $this->cell(20, 6, $data->tmp_invoice, 0, 0, 'L', 1);
            $this->cell(50, 6, $data->tmp_product_category, 0, 0, 'L', 1);
            $this->cell(30, 6, number_format($data->tmp_total_cwp1_USA_AUS, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->tmp_total_cwp2_USA_AUS, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->tmp_total_cwp1_OTHER, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->tmp_total_cwp2_OTHER, 2 , '.',','), 0, 1, 'R', 1);
            $this->Ln(0);
            $NO++;
        }

        $this->setFont('Arial', 'B', 8);
        $this->cell(70, 6, 'TOTAL', 0, 0, 'C', 1);
        $this->cell(30, 6, number_format($cwp1_USA, 2 , '.',','), 0, 0, 'R', 1);
        $this->cell(30, 6, number_format($cwp2_USA, 2 , '.',','), 0, 0, 'R', 1);
        $this->cell(30, 6, number_format($a_cwp1_USA, 2 , '.',','), 0, 0, 'R', 1);
        $this->cell(30, 6, number_format($a_cwp2_USA, 2 , '.',','), 0, 1, 'R', 1);
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 285, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of   {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil_item);
$pdf->Output();
