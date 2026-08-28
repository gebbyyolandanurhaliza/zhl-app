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
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(120);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
    }

    function Content($_tampil) {
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(25, 6, 'Name', 0, 0, 'L', 1);
        $this->cell(20, 6, 'Account', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Amount(USD)', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Pending Cash', 0, 0, 'C', 1);
        $this->cell(30, 6, 'NET', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Amount (OTHER CUR)', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Pending Cash', 0, 0, 'C', 1);
        $this->cell(30, 6, 'NET (OTHER CUR)', 0, 0, 'C', 1);
        $this->cell(35, 6, 'TOTAL USD Equivalent', 0, 0, 'C', 1);
        $this->cell(30, 6, 'AVERAGE RATE', 0, 0, 'C', 1);

        $this->Line(10, 48, 325 - 40, 48);
        $this->Ln(6);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $totalusd = 0;
        $totalusdnet = 0;
        $totalcur = 0;
        $totalcurnet = 0;
        $totalsel = 0;
        foreach ($_tampil as $data) {
            $totalusd += $data->jumlah_usd;
            $totalusdnet += $data->jumlah_usd;
            $totalcur += $data->jumlah_notusd;
            $totalcurnet += $data->jumlah_notusd;

            $total = $data->jumlah_usd + $data->jumlah_notusd;
            $totalsel += $total;

            $this->cell(25, 6, $data->AccountName, 0, 0, 'L', 1);
            $this->cell(20, 6, $data->no_coa, 0, 0, 'C', 1);
            $this->cell(20, 6, number_format($data->jumlah_usd, 2, '.',','), 0, 0, 'R', 1);
            $this->cell(20, 6, '', 0, 0, 'C', 1);
            $this->cell(30, 6, number_format($data->jumlah_usd, 2, '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6,number_format($data->jumlah_notusd, 2, '.',',') , 0, 0, 'R', 1);
            $this->cell(25, 6, '', 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->jumlah_notusd, 2, '.',','), 0, 0, 'R', 1);
            $this->cell(35, 6, number_format($total, 2, '.',','), 0, 0, 'R', 1);
            $this->cell(30, 6, number_format($data->average_rate, 2, '.',','), 0, 1, 'R', 1);

            $NO++;
        }

       $this->Ln(2);
        $this->cell(1, 0, '', 0, 0, 'L', 10);
        $this->cell(275, 0, '', 1, 1, 'L', 1);

        $this->setFont('Arial', 'B', 8);
        $this->cell(25, 6, 'GRAND TOTAL', 0, 0, 'R', 1);
        $this->cell(40, 6, number_format($totalusd, 2), 0, 0, 'R', 1);
        $this->cell(50, 6, number_format($totalusdnet, 2), 0, 0, 'R', 1);
        $this->cell(30, 6, number_format($totalcur, 2), 0, 0, 'R', 1);
        $this->cell(55, 6, number_format($totalcurnet, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($totalsel, 2), 0, 0, 'R', 1);
       /*
        $this->cell(24, 6, $currency, 0, 0, 'R', 1);
        //$this->cell(36, 6, number_format($total_amount, 2), 0, 0, 'R', 1);
        $this->cell(86, 6, number_format($total_usd_equivalent, 2), 0, 1, 'R', 1);*/



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
$pdf->Content($_tampil);
$pdf->Output();
