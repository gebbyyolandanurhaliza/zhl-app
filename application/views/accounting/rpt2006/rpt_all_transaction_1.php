<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Aged Payable Summary';
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

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Payable Invoice Transaction For Period '.date('d-m-Y', strtotime($this->dari)).' to '.date('d-m-Y', strtotime($this->sampai)), 0, 0, 'C', 1);
        $this->Ln();

        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);

        $this->cell(5, 6, 'No', 'BTRL', 0, 'C', 1);
        $this->cell(13, 6, 'Date', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'No. Reff', 'BTRL', 0, 'C', 1);
        $this->cell(37, 6, 'Vendor', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Currency', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Rate', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Tax ', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Discount', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Add Cost', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Deposit', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Debit note', 'BTRL', 0, 'C', 1);
        $this->cell(11, 6, 'Credit Note', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Total', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Payment', 'BTRL', 1, 'C', 1);

    }

    function Content($_tampil_item) {        
        

        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

        $no = 1;
        $totalpajak = 0;
        $totaldiskon = 0;
        $totalbiayalain = 0;
        $totaluang_muka = 0;
        $totalnota_debet = 0;
        $totalnota_kredit = 0;
        $total_hutang = 0;
        $total_bayar = 0;

        foreach ($_tampil_item as $m) {
            $this->cell(5, 6, $no, 'BTRL', 0, 'L', 1);
            $this->cell(13, 6, $m->tanggal, 'BTRL', 0, 'L', 1);
            $this->cell(20, 6, $m->nofaktur, 'BTRL', 0, 'L', 1);
            $this->cell(37, 6, $m->namavendor, 'BTRL', 0, 'L', 1);
            $this->cell(11, 6, $m->currency_id, 'BTRL', 0, 'L', 1);
            $this->cell(11, 6, $m->rate, 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->pajak, 2), 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->diskon, 2), 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->biaya_lain, 2), 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->uang_muka, 2), 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->nota_debet, 2), 'BTRL', 0, 'R', 1);
            $this->cell(11, 6, number_format($m->nota_kredit, 2), 'BTRL', 0, 'R', 1);
            $this->cell(15, 6, number_format($m->hutang, 2), 'BTRL', 0, 'R', 1);
            $this->cell(15, 6, number_format($m->bayar, 2), 'BTRL', 0, 'R', 1);

            $totalpajak += $m->pajak;
            $totaldiskon+= $m->diskon;
            $totalbiayalain+= $m->biaya_lain;
            $totaluang_muka+= $m->uang_muka;
            $totalnota_debet += $m->nota_debet;
            $totalnota_kredit += $m->nota_kredit;
            $total_hutang += $m->hutang;
            $total_bayar += $m->bayar;
            $no++;
            $this->ln();
        }


        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        
        $this->cell(97, 6, "Grand Total", 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totalpajak, 2), 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totaldiskon, 2), 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totalbiayalain, 2), 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totaluang_muka, 2), 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totalnota_debet, 2), 'BTRL', 0, 'R', 1);
        $this->cell(11, 6, number_format($totalnota_kredit, 2), 'BTRL', 0, 'R', 1);
        $this->cell(15, 6, number_format($total_hutang, 2), 'BTRL', 0, 'R', 1);
        $this->cell(15, 6, number_format($total_bayar, 2), 'BTRL', 0, 'R', 1);

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-20);
        $this->setFont('Arial', 'i', 6);

        $this->setFont('Arial', '', 6);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(),202, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->dari = $dari;
$pdf->sampai = $sampai;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil_item);
$pdf->Output();
