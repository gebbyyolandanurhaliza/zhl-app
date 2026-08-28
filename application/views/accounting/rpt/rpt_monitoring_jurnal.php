<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->SetX(10);
        $this->Cell(190,30,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);

        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);

        // $this->Line(10, 42, 195, 42);
        $this->cell(15, 6, 'Date', 'BTRL', 0, 'C', 1);        
        $this->cell(20, 6, 'No Reference', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'No COA', 'BTRL', 0, 'C', 1);
        $this->cell(100, 6, 'Remark', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Debet', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Credit', 'BTRL', 1, 'C', 1);
        // $this->cell(25, 6, 'Debet SGD', 'BTRL', 0, 'C', 1);
        // $this->cell(25, 6, 'Credit SGD', 'BTRL', 1, 'C', 1);


    }

    function Content($tampil_item) {        

        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

        foreach ($tampil_item as $key) {
            $this->cell(15, 6, date("d-m-Y",strtotime($key->Tanggal)), 'BTRL', 0, 'C', 1);                        
            $this->cell(20, 6, $key->NoJurnal, 'BTRL', 0, 'C', 1);
            $this->cell(15, 6, $key->NoCOA, 'BTRL', 0, 'L', 1);
            $this->cell(100, 6, $key->Uraian, 'BTRL', 0, 'L', 1);            
            $this->cell(20, 6, number_format($key->Debet, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($key->Kredit, 2), 'BTRL',  1, 'R', 1);
            // $this->cell(25, 6, number_format($key->Debet_SGD, 2), 'BTRL', 0, 'R', 1);
            // $this->cell(25, 6, number_format($key->Kredit_SGD, 2), 'BTRL',  1, 'R', 1);
            $NO ++;
        }

        $total_debet = 0;
        $total_credit = 0;
        $total_debetSGD = 0;
        $total_creditSGD = 0;

        foreach ($tampil_item as $v) {
            $total_debet  += $v->Debet;
            $total_credit += $v->Kredit;
            $total_debetSGD  += $v->Debet_SGD;
            $total_creditSGD += $v->Kredit_SGD;
        }

        $this->setFont('Arial', 'B', 6);
        $this->cell(150, 6, "Grand Total", 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($total_debet , 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($total_credit, 2), 'BTRL', 1, 'R', 1);
        // $this->cell(25, 6, number_format($total_debetSGD , 2), 'BTRL', 0, 'R', 1);
        // $this->cell(25, 6, number_format($total_creditSGD, 2), 'BTRL', 1, 'R', 1);

    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($tampil_item);
$pdf->Output();
