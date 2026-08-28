<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $dari = $_GET['dari'];
        $sampai = $_GET['sampai'];

        $titel = 'GENERAL LEDGER FOR THE PERIOD AT ' . $dari . ' TO ' . $sampai;
        $this->setFont('Times', 'BI', 10);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->cell(280, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->cell(280, 6, $titel, 0, 1, 'C', 1);
    }

    function Content($akun_gl, $_tampil_item) {
        $this->Ln(5);
        $this->setFont('times', '', 10);
        $this->setFillColor(255, 255, 255);
        $dari = $_GET['dari'];


        if ($_GET['currency'] == 'USD') {
            $cur = 'US$';
        } else {
            $cur = 'SGD$';
        }

        $this->Cell(160, 5, $dari, 0, 0, 'L', 0);
        $this->Cell(40, 5, 'DR', 0, 0, 'C', 0);
        $this->Cell(40, 5, 'CR', 0, 0, 'C', 0);
        $this->Cell(40, 5, 'BAL', 0, 1, 'C', 0);
        $this->Cell(160, 5, '', 'T', 0, 'C', 0);
        $this->Cell(40, 5, $cur, 'T', 0, 'C', 0);
        $this->Cell(40, 5, $cur, 'T', 0, 'C', 0);
        $this->Cell(40, 5, $cur, 'T', 1, 'C', 0);

        foreach ($akun_gl as $s) {
            $this->setFont('times', 'B', 10);
            $this->setFillColor(255, 255, 255);
            $this->cell(160, 5, $s->nama_group, 'T', 0, 'C', 1);
            $this->Cell(40, 5, '', 'T', 0, 'C', 0);
            $this->Cell(40, 5, '', 'T', 0, 'C', 0);
            $this->Cell(40, 5, '', 'T', 1, 'C', 0);
            $totaldebit = 0;
            $totalkredit = 0;
            $totalnet = 0;
            $totalng = 0;
            $BalanceD = 0;
            $BalanceK = 0;
            $totalbegining = 0;

            $this->setFont('times', '', 10);
            $this->setFillColor(255, 255, 255);
            foreach ($_tampil_item as $v) {
                if ($v->NoCOA == $s->NoCOA) {
                    $totaldebit += $v->Debet;
                    $totalkredit += $v->Kredit;
                    $BalanceD += $v->Debet;
                    $BalanceK += $v->Kredit;

                    $totalbegining += $BalanceD - $BalanceK;

                    if ($v->Debet == '0') {
                        $debet = '';
                    } elseif ($v->Debet < 0) {
                        $debet = "(" . number_format(0 - $v->Debet, 2, '.', ',') . ")";
                    } else {
                        $debet = number_format($v->Debet, 2, '.', ',');
                    }

                    if ($v->Kredit == '0') {
                        $kredit = '';
                    } elseif ($v->Kredit < 0) {
                        $kredit = "(" . number_format(0 - $v->Kredit, 2, '.', ',') . ")";
                    } else {
                        $kredit = number_format($v->Kredit, 2, '.', ',');
                    }

                    if ($totalbegining < 0) {
                        $totalbegining1 = "(" . number_format(0 - $totalbegining, 2, '.', ',') . ")";
                    } else {
                        $totalbegining1 = number_format($totalbegining, 2, '.', ',');
                    }
                    
                    $tanggal = date('d-m-Y', strtotime($v->Tanggal));
                    
                    if ($v->JenisJurnalID == ''){
                        $jenis = '';
                    }  else {
                        $jenis = " - " . $v->JenisJurnalID;
                    }
                    
                    if(!empty($v->Uraian)){
                        $uraian = " - ".$v->Uraian;
                    }  else {
                        $uraian = '';
                    }
                    
                    $this->Cell(20, 6, $tanggal,  0, 0, 'L', 1);
                    $this->Cell(140, 5, $v->NoJurnal . $jenis. $uraian, 0, 0, 'L', 0);
                    $this->Cell(40, 5, $debet, 0, 0, 'R', 0);
                    $this->Cell(40, 5, $kredit, 0, 0, 'R', 0);
                    $this->Cell(40, 5, $totalbegining1, 0, 1, 'R', 0);
                }
            }

            $this->Cell(20, 6, '', 'T', 0, 'L', 1);
            $this->Cell(140, 6, '', 'T', 0, 'L', 1);
            $this->Cell(40, 6, number_format($totaldebit, 2, '.', ','), 'T', 0, 'R', 1);
            $this->Cell(40, 6, number_format($totalkredit, 2, '.', ','), 'T', 0, 'R', 1);
            $this->Cell(40, 6, number_format($totalbegining, 2, '.', ','), 'T', 1, 'R', 1);
            $this->Cell(20, 6, '31-12-'.date("Y"), 'T', 0, 'L', 1);
            $this->Cell(140, 6, 'BAL C/F', 'T', 0, 'L', 1);
            $this->Cell(40, 6, '', 'T', 0, 'R', 1);
            $this->Cell(40, 6, '', 'T', 0, 'R', 1);
            $this->Cell(40, 6, number_format($totalbegining, 2, '.', ','), 'T', 1, 'R', 1);
        }
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-20);
        //buat garis horizontal
        //$this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        //$this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L");
$pdf->Content($akun_gl, $_tampil_item);
$pdf->Output();
