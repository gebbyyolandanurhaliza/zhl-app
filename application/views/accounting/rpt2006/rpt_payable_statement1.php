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

        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 204, 42);
        $this->cell(15, 6, 'Invoice Date', 0, 0, 'C', 1);
        $this->cell(15, 6, 'Inv. Number', 0, 0, 'C', 1);
        $this->cell(15, 6, 'Due Date', 0, 0, 'C', 1);
        $this->cell(17, 6, 'Amount', 0, 0, 'C', 1);
        $this->cell(17, 6, 'Payment', 0, 0, 'C', 1);
        $this->cell(15, 6, 'Payment Date ', 0, 0, 'C', 1);
        $this->cell(17, 6, 'Balance', 0, 0, 'C', 1);
        $this->cell(17, 6, 'Current', 0, 0, 'C', 1);
        $this->cell(17, 6, '1 - 30 Days', 0, 0, 'C', 1);
        $this->cell(17, 6, '31 - 60 Days', 0, 0, 'C', 1);
        $this->cell(17, 6, '61 - 91 Days', 0, 0, 'C', 1);
        $this->cell(17, 6, '> 90 Days', 0, 1, 'C', 1);

        $this->Line(10, 48, 204, 48);
        $this->Ln(1);
    }

    function Content($get_agings) {        
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

        foreach ($get_agings as $key) {
            if ($key->tmp_payment == 0){
                $balance = $key->tmp_hutang;
                $tanggal = "-";
            }  else {
                $balance = 0;
                $tanggal = date('d-M', strtotime($key->tmp_realisasi_date));
            }
            $this->cell(15, 6, $key->tmp_inv_date, 0, 0, 'C', 1);
            $this->cell(15, 6, $key->tmp_invno, 0, 0, 'C', 1);
            $this->cell(15, 6, $tanggal, 0, 0, 'C', 1);        
            $this->cell(17, 6, number_format($key->tmp_hutang, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_payment,2), 0, 0, 'R', 1);
            $this->cell(15, 6, $tanggal, 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($balance, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_not_due_date, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_0sd30, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_31sd60, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_61sd90, 2), 0, 0, 'R', 1);
            $this->cell(17, 6, number_format($key->tmp_91sd120 + $key->tmp_more120, 2), 0, 1, 'R', 1);
            $NO ++;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);
        $current = 0;
        $tiga = 0;
        $enam = 0;
        $sembilan = 0;
        $lebih = 0;
        $piutang = 0;
        $bayari= 0;
        $t_balance = 0;
        $yx = 0;

        foreach ($get_agings as $x) {
            $currency = $x->tmp_currency;
            $current += $x->tmp_not_due_date;
            $piutang += $x->tmp_hutang;
            $bayari += $x->tmp_payment;
            $tiga += $x->tmp_0sd30;
            $enam += $x->tmp_31sd60;
            $sembilan += $x->tmp_61sd90;
            $lebih += $x->tmp_91sd120 + $x->tmp_more120;
            $yx += $x->tmp_more120;
        }

        $this->cell(45, 6, "TOTAL", 'BT', 0, 'L', 1);
        $this->cell(17, 6, number_format($piutang, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($bayari, 2), 'BT', 0, 'R', 1);
        $this->cell(15, 6, "", 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($piutang-$bayari, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($current, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($tiga, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($enam, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($sembilan, 2), 'BT', 0, 'R', 1);
        $this->cell(17, 6, number_format($lebih, 2), 'BT', 1, 'R', 1);

        

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
$pdf->Content($get_agings);
$pdf->Output();
