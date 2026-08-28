<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $tgal = $_GET['dari'];
        $tgal2 = $_GET['sampai'];
        $str = date_create($tgal);
        $str2 = date_create($tgal2);
        $periode = date_format($str,"d F Y");
        $periode2 = date_format($str2,"d F Y");
        
        $titel = 'TRIAL BALANCE AT ' . strtoupper($periode).' - '. strtoupper($periode2);
        $this->setFont('Times', 'B', 14);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->cell(200, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->cell(200, 6, $titel, 0, 1, 'C', 1);

        $this->Ln(1);
        $this->setFont('times', 'B', 8);
        $this->setFillColor(255, 255, 255);
        
        if($_GET['type'] == 'USD')
        {
            $cur = 'US$';
        }  else {
            $cur ='SGD$';
        }
        
        $this->Cell(14, 5, 'No COA', 'LTR', 0, 'C', 0);
        $this->Cell(100, 5, 'Account Name', 'LTR', 0, 'C', 0); 
        $this->Cell(20, 5, 'Debet', 1, 0, 'C', 0);
        $this->Cell(20, 5, 'Credit', 1, 0, 'C', 0);
        $this->Cell(20, 5, 'YTD Debet', 1, 0, 'C', 0);
        $this->Cell(20, 5, 'YTD Credit', 1, 1, 'C', 0);
        $this->Cell(14, 5, '', 'LBR', 0, 'C', 0);
        $this->Cell(100, 5, '', 'LBR', 0, 'C', 0); 
        $this->Cell(20, 5, $cur, 1, 0, 'C', 0);
        $this->Cell(20, 5, $cur, 1, 0, 'C', 0);
        $this->Cell(20, 5, $cur, 1, 0, 'C', 0);
        $this->Cell(20, 5, $cur, 1, 1, 'C', 0);
    }

    function Content($get_data_detail) {
        

        $this->setFont('times', '', 8);
        $this->setFillColor(255, 255, 255);
        $TDR = 0;
        $TCR = 0;
        $TSDR = 0;
        $TSCR = 0;
        foreach ($get_data_detail as $v) {
                    //$begining = $v->saldo_awal_debet - $v->saldo_awal_kredit;
                                    $DR = $v->MTDebet;
                                    $CR = $v->MTKredit;

                                    $TDR += $v->MTDebet;
                                    $TCR += $v->MTKredit;
                                    $TSDR += $v->EBDebet;
                                    $TSCR += $v->EBKredit;

                                    //$mutasi = $v->mutasi_debet - $v->mutasi_kredit;
                                    if ($DR < 0) {
                                        $b = str_replace("-", "", $DR);
                                        $DR = "" . number_format($b, 2, '.', ',') . "";
                                    } elseif ($DR == 0) {
                                        $DR = '-';
                                    } else {
                                        $DR = number_format($DR, 2, '.', ',');
                                    }

                                    if ($CR < 0) {
                                        $b = str_replace("-", "", $CR);
                                        $CR = "" . number_format($b, 2, '.', ',') . "";
                                    } elseif ($CR == 0) {
                                        $CR = '-';
                                    } else {
                                        $CR = number_format($CR, 2, '.', ',');
                                    }
                $this->Cell(14, 6, $v->no_coa, 1, 0, 'R', 1);
                $this->Cell(100, 6, strtoupper($v->nama_akun), 1, 0, 'L', 1);
                $this->Cell(20, 6, number_format(abs($v->MTDebet), 2), 1, 0, 'R', 1);
                $this->Cell(20, 6, number_format(abs($v->MTKredit), 2), 1, 0, 'R', 1);
                $this->Cell(20, 6, number_format(abs($v->EBDebet), 2), 1, 0, 'R', 1);
                $this->Cell(20, 6, number_format(abs($v->EBKredit), 2), 1, 1, 'R', 1);
            
        }
        $this->setFont('times', 'B', 8);
        $this->Cell(114, 6, 'TOTAL', 1, 0, 'C', 1);
        $this->Cell(20, 6, number_format(abs($TDR), 2, '.', ','), 1, 0, 'R', 1);
        $this->Cell(20, 6, number_format(abs($TCR), 2, '.', ','), 1, 0, 'R', 1);
        $this->Cell(20, 6, number_format(abs($TSDR), 2, '.', ','), 1, 0, 'R', 1);
        $this->Cell(20, 6, number_format(abs($TSCR), 2, '.', ','), 1, 1, 'R', 1);
    }

     
}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail);
$pdf->Output();
