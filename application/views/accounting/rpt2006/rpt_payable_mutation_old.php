<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
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

    function Content($get_data_detail) {        
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 41, 325 - 40, 41);
        $this->cell(15, 6, 'Supplier ID', 0, 0, 'C', 1);
        $this->cell(65, 6, 'Supplier Name', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Bagening Balance', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Purchase', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Down Payment', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Payment', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Debit Note', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Credit Note', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Balance', 0, 0, 'C', 1);
        $this->cell(23, 6, 'Ending Rate', 0, 1, 'C', 1);

        $this->Line(10, 50, 325 - 40, 50);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($get_data_detail as $key) {
            $this->cell(15, 6, $key->kode_sup, 0, 0, 'C', 1);
            $this->cell(65, 6, $key->suppliercompany, 0, 0, 'C', 1);
            $this->cell(30, 6, number_format($key->begining_balance, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->purchase, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->down_payment, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->payment, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->debet_note, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->kredit_note, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->balance, 2), 0, 0, 'R', 1);
            $this->cell(23, 6, number_format($key->balance_rateakhir, 2), 0, 1, 'R', 1);
            $NO ++;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $b_balance = 0;
        $purchase = 0;
        $d_payment = 0;
        $payment = 0;
        $d_note = 0;
        $c_note= 0;
        $balance= 0;
        $e_rate= 0;

        foreach ($get_data_detail as $v) {
            $b_balance += $v->begining_balance;
            $purchase += $v->purchase;
            $d_payment += $v->down_payment;
            $payment += $v->payment;
            $d_note += $v->debet_note;
            $c_note += $v->kredit_note;
            $balance += $v->balance;
            $e_rate += $v->balance_rateakhir;
        }

        $this->cell(80, 6, "Grand Total", 0, 0, 'R', 1);
        $this->cell(30, 6, number_format($b_balance, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($purchase, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($d_payment, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($payment, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($d_note, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($c_note, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($balance, 2), 0, 0, 'R', 1);
        $this->cell(23, 6, number_format($e_rate, 2), 0, 1, 'R', 1);

       

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 8);
        $this->Cell(30, 4, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 4, 'We Reserve the right to charge interest at 1.5% per month & to hold future', 0, 1, 'L');
        $this->Cell(20, 4, 'deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 4, 'Thank you for your kind co-operation.', 0, 1, 'L');
        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail);
$pdf->Output();
