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

    function Content($dari, $_tampil) {        
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(20, 6, 'DOC. No.', 0, 0, 'C', 1);
        $this->cell(35, 6, 'Post. Date', 0, 0, 'C', 1);
        $this->cell(35, 6, 'Due Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Details', 0, 0, 'C', 1);
        $this->cell(65, 6, 'Account / Customer / Vendor Name', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Amount', 0, 0, 'C', 1);
        $this->cell(20, 6, 'LC ', 0, 0, 'C', 1);
        $this->cell(20, 6, 'FC', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Total (LC)', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Total (FC)', 0, 1, 'C', 1);

        $this->Line(10, 48, 325 - 40, 48);

        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

            $tgl = $dari;
            $bln = explode('-', $tgl);
            if ($bln[1] == 01) {
                $tbln = 'January';
            } elseif ($bln[1] == 02) {
                $tbln = 'February';
            } elseif ($bln[1] == 03) {
                $tbln = 'March';
            } elseif ($bln[1] == 04) {
                $tbln = 'April';
            } elseif ($bln[1] == 05) {
                $tbln = 'May';
            } elseif ($bln[1] == 06) {
                $tbln = 'June';
            } elseif ($bln[1] == 07) {
                $tbln = 'July';
            } elseif ($bln[1] == 08) {
                $tbln = 'August';
            } elseif ($bln[1] == 09) {
                $tbln = 'September';
            } elseif ($bln[1] == 10) {
                $tbln = 'October';
            } elseif ($bln[1] == 11) {
                $tbln = 'November';
            } elseif ($bln[1] == 12) {
                $tbln = 'December';
            }
        
            $garis1 = 0;
            $saldo = 0;
            $debit2 = 0;
            $subtotlfc = 0;
            $subtotllc = 0;

            $NO = 1;
            $this->setFont('Arial', '', 8);
            $this->setFillColor(255, 255, 255);
            
            foreach ($_tampil as $value) {
                if ($value->gst_value == 0) {
                    $nlc = '';
                    $nfc = '';
                    $ntlc = '';
                    $ntfc = '';
                } else {
                    $lc = $value->gst_value;
                    $fc = $value->gst_value * $value->Rate;
                    $saldo += $value->gst_value;
                    $debit2 += $value->gst_value* $value->Rate ;
                    
                    $nlc = number_format($lc, 2, ',', '.');
                    $nfc = 'SGD ' . number_format($fc, 2, ',', '.');
                    $ntlc = number_format($saldo, 2, ',', '.');
                    $ntfc = 'SGD ' . number_format($debit2, 2, ',', '.');
                    
                    $subtotlfc += $saldo;
                    $subtotllc += $debit2;
                }
                if($value->Kredit > 0){
                    $total = $value->Kredit;
                }else{
                    $total = $value->Debet;
                }
            $this->cell(20, 6, $value->DetailID, 0, 0, 'L', 1);
            $this->cell(35, 6, $value->Tanggal, 0, 0, 'C', 1);
            $this->cell(35, 6, $value->Tanggal, 0, 0, 'C', 1);            
            $this->cell(25, 6, $value->NoJurnal, 0, 0, 'C', 1);
            $this->cell(65, 6, $value->nama_sup, 0, 0, 'L', 1);
            $this->cell(20, 6, number_format($total,2), 0, 0, 'R', 1);
            $this->cell(20, 6, $nlc, 0, 0, 'C', 1);
            $this->cell(20, 6, $nfc, 0, 0, 'C', 1);
            $this->cell(20, 6, $ntlc, 0, 0, 'C', 1);
            $this->cell(20, 6, $ntfc, 0, 1, 'C', 1);
            $NO ++;
        }
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->cell(220, 6, "Grand Total", 0, 0, 'R', 1);
        $this->cell(20, 6, number_format($subtotlfc, 2), 0, 0, 'R', 1);
        $this->cell(20, 6, number_format($subtotllc, 2), 0, 0, 'R', 1);

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
$pdf->Content($dari, $_tampil);
$pdf->Output();
