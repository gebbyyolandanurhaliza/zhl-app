<?php

class PDF extends FPDF {

    public function setData($data){
        $this->data=$data;
    }

    //Page header
    function Header() {
        $titel = 'Transaction Journal';
        $this->Image('assets/PSG.png', 10, 10, 35, 0, 'PNG');
        $this->setFont('Arial', 'B', 20);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(50, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(40, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(40, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(40, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(40, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 45, 250 - 50, 45);

        $this->Ln(10);
        $this->setFont('Arial', 'B', 14);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(40, 6, $titel, 0, 1, 'C', 1);
    }

    function multiexplode($delimiters, $string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    function Content($get_jurnal,$get_header) {
        $this->Ln(1);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($get_header as $s) {
           $reff= $s->no_reff;
           $tgl= $s->tanggal;
           $cur=$s->currency;
           $rate=$s->rate;
           $ratesgd=$s->rate_sgd;


        }
        $this->cell(25, 6, 'Reff. Number  ', 0, 0, 'L', 1);
        $this->cell(25, 6,': '.$reff, 0, 1, 'L', 1);



        $this->cell(25, 6, 'Date ', 0, 0, 'L', 1);
        $this->cell(25, 6, ': '.date_format(New DateTime($tgl), 'M, d-Y'), 0, 1, 'L', 1);

        $this->cell(25, 6, 'Currency', 0, 0, '', 1);
        $this->cell(25, 6, ': '.$cur, 0, 0, 'L', 1);
        $this->cell(25, 6, 'Rate', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$rate, 0, 0, 'L', 1);
        $this->cell(25, 6, 'Rate SGD', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$ratesgd, 0, 1, 'L', 1);

        $this->Ln();
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 90, 250 - 50, 90);
        $this->cell(20, 6, 'Date', 'BTRL', 0, 'C', 1);
        $this->cell(25, 6, 'Account Numb.', 'BTRL', 0, 'C', 1);
        $this->cell(35, 6, 'Account Name', 'BTRL', 0, 'C', 1);
        $this->cell(60, 6, 'Details', 'BTRL', 0, 'C', 1);
        $this->cell(25, 6, 'Debet', 'BTRL', 0, 'C', 1);
        $this->cell(25, 6, 'Credit', 'BTRL', 1, 'C', 1);


        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);


        foreach ($get_jurnal as $key) {
            $this->cell(20, 6, $key->tanggal, 'BTRL', 0, 'L', 1);
            $this->cell(25, 6, $key->no_coa, 'BTRL', 0, 'L', 1);
            $this->cell(35, 6, $key->JenisJurnalID, 'BTRL', 0, 'L', 1);
            $this->cell(60, 6, $key->description, 'BTRL', 0, 'L', 1);
            $this->cell(25, 6, number_format($key->debet, 2), 'BTRL', 0, 'R', 1);
            $this->cell(25, 6, number_format($key->credit, 2), 'BTRL', 1, 'R', 1);

        }
        //  $total = 0;
        // foreach ($get_jurnal as $v) {
        //     $total += $v->debet;
        //     $this->SetY(99);
        //     //$this->Cell(0, 6, $v->hutang . "\n", 0, 1, 'R');

        //     $this->SetY(-100);
        //     //buat garis horizontal
        //     $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());

        //     $this->cell(160, 6, 'TOTAL AMOUNT', 0, 0, 'R', 1);
        //     $this->cell(30, 6, number_format($total, 2), 'BTRL', 1, 'R', 1);
        // }
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-70);
        //nomor halaman
         // $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());
        $this->cell(130, 6, '', 'T', 0, 'R');
        $this->cell(30, 6, 'TOTAL AMOUNT', 'T', 0, 'R', 1);
        $this->cell(30, 6, number_format($this->data['totals'], 2), 'BTRL', 1, 'R', 1);
        $this->ln(15);
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $this->Cell(0, 10, 'FOR PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'R');
        $this->Cell(0, 20, '', 0, 0, 'R');
        $this->Cell(0, 50, '..........................................................................', 0, 0, 'R');
    }

}

$pdf = new PDF();
$pdf->setData($ini);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_jurnal,$get_header);
$pdf->Output();
