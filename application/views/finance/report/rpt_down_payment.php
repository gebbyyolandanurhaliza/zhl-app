<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Down Payment';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(120);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Centre, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(120);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
    }

    function Content($_hasil) {
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(10, 6, 'No', 0, 0, 'C', 1);
        $this->cell(20, 6, 'ID', 0, 0, 'C', 1);
        $this->cell(70, 6, 'Supplier / Customer', 0, 0, 'C', 1);
        $this->cell(40, 6, 'Reff. No', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Date', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Currency ', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Amount', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Rate', 0, 0, 'C', 1);
        $this->cell(30, 6, 'USD Equivalent', 0, 0, 'C', 1);

        $this->Line(10, 48, 325 - 40, 48);
        $this->Ln(6);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $total_amount=0;
        $total_usd_equivalent=0;
        foreach ($_hasil as $data) {
            $currency=$data->currency_id;
            $total_amount+=$data->uang_muka;
            $total_usd_equivalent+=$data->uang_muka*$data->currency_rate;

            $this->cell(10, 6, $NO, 0, 0, 'C', 1);
            $this->cell(20, 6, $data->supp_code, 0, 0, 'C', 1);
            $this->cell(70, 6, $data->cust_supp_name, 0, 0, 'C', 1);
            $this->cell(40, 6, $data->no_reff, 0, 0, 'C', 1);
            $this->cell(30, 6, $data->date, 0, 0, 'C', 1);
            $this->cell(20, 6,$data->currency_id , 0, 0, 'C', 1);
            $this->cell(30, 6, number_format($data->uang_muka, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(20, 6, number_format($data->currency_rate, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->uang_muka*$data->currency_rate, 2 , '.',','), 0, 1, 'R', 1);

            $NO++;
        }

        $this->Ln(2);
        $this->cell(140, 0, '', 0, 0, 'L', 10);
        $this->cell(130, 0, '', 1, 1, 'L', 1);

        $this->setFont('Arial', 'B', 8);
        $this->cell(160, 6, 'Total', 0, 0, 'R', 1);
        $this->cell(24, 6, $currency, 0, 0, 'R', 1);
        //$this->cell(36, 6, number_format($total_amount, 2), 0, 0, 'R', 1);
        $this->cell(86, 6, number_format($total_usd_equivalent, 2), 0, 1, 'R', 1);



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

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_hasil);
$pdf->Output();
