<?php
class PDF extends TFPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);
        
        $this->SetTextColor(0, 0, 0);
        $new_awal = date('F jS, Y', strtotime($_GET['dari']));  
        $new_akhir = date('F jS, Y', strtotime($_GET['sampai']));  
        $this->Ln(5);
        $this->setFont('Arial', 'B', 12);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(25, 5, 'BALANCE SHEET DETAIL FOR THE PERIOD '.$new_awal.' - '.$new_akhir.'', 0, 1, 'C', 1);

        $this->Ln(5);
        $this->setFont('Arial', 'B', 10);
        $this->cell(20, 5, 'NO COA', 'B', 0, 'L', 1);
        $this->cell(40, 5, 'COA NAME', 'B', 0, 'C', 1);
        $this->cell(30, 5, 'COST', 'B', 0, 'C', 1);
        $this->cell(50, 5, 'ACCUMULATED DEP', 'B', 0, 'C', 1);
        $this->cell(40, 5, 'NET BOOK VALUE ', 'B', 1, 'C', 1);


        // $this->Ln(7);
    }

    function Content($data_balance) {
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);
        $this->cell(180, 5, 'ASSET', '', 1, 'L', 1);
        $this->Ln(1);

        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);

        $ta = 0;   $tb = 0;   $tc = 0;
        if(!empty($data_balance)){
            foreach ($data_balance as $r) {
                if($r->id_sub_group == 1 ){
                    $ta +=  $r->COSTT; $tb += $r->ACCM; $tc += ($r->COSTT-$r->ACCM);
                    $this->cell(20, 6, $r->no_coa, 0, 0, 'L', 1);
                    $this->cell(40, 6, $r->AccountName, 0, 0, 'L', 1);
                    $this->cell(30, 6, formatuang($r->COSTT), 0, 0, 'R', 1);
                    $this->cell(50, 6, formatuang($r->ACCM), 0, 0, 'R', 1);
                    $this->cell(40, 6, formatuang(($r->COSTT-$r->ACCM)), 0, 1, 'R', 1);    
                }                
            }
        }
        $this->cell(180, 1, '', 'B', 1, 'L', 1);

        $this->setFont('Arial', 'B', 10);
        $this->cell(180, 5, 'CURRENT ASSET', '', 1, 'L', 1);
        $this->Ln(1);

        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);

        if(!empty($data_balance)){
            foreach ($data_balance as $r) {
                if($r->id_sub_group == 2 ){
                    $ta +=  $r->COSTT; $tb += $r->ACCM; $tc += ($r->COSTT-$r->ACCM);
                    $this->cell(20, 5, $r->no_coa, 0, 0, 'L', 1);
                    $this->cell(40, 5, $r->AccountName, 0, 0, 'L', 1);
                    $this->cell(30, 6, formatuang($r->COSTT), 0, 0, 'R', 1);
                    $this->cell(50, 6, formatuang($r->ACCM), 0, 0, 'R', 1);
                    $this->cell(40, 6, formatuang(($r->COSTT-$r->ACCM)), 0, 1, 'R', 1); 
                }                
            }
        }
        $this->cell(180, 1, '', 'B', 1, 'L', 1);

        $this->setFont('Arial', 'B', 9);
        $this->cell(60, 5, 'TOTAL ASSET', '', 0, 'L', 1);
        $this->cell(30, 5, formatuang($ta), 0, 0, 'R', 1);
        $this->cell(50, 5, formatuang($tb), 0, 0, 'R', 1);
        $this->cell(40, 5, formatuang($tc), 0, 1, 'R', 1);
        $this->Ln(1);
        

        $this->cell(180, 1, '', 'B', 1, 'L', 1);

        $this->setFont('Arial', 'B', 10);
        $this->cell(180, 5, 'CURRENT LIABILITIES', '', 1, 'L', 1);
        $this->Ln(1);

        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);
        $ta = 0; $tb = 0; $tc = 0;
        if(!empty($data_balance)){
            foreach ($data_balance as $r) {
                if($r->id_sub_group == 3 ){
                    $ta +=  $r->COSTT; $tb += $r->ACCM; $tc += ($r->COSTT-$r->ACCM);
                    $this->cell(20, 5, $r->no_coa, 0, 0, 'L', 1);
                    $this->cell(40, 5, $r->AccountName, 0, 0, 'L', 1);
                    $this->cell(30, 6, formatuang($r->COSTT), 0, 0, 'R', 1);
                    $this->cell(50, 6, formatuang($r->ACCM), 0, 0, 'R', 1);
                    $this->cell(40, 6, formatuang(($r->COSTT-$r->ACCM)), 0, 1, 'R', 1);     
                }                
            }
        }
        $this->cell(180, 1, '', 'B', 1, 'L', 1);
        $this->setFont('Arial', 'B', 9);
        $this->cell(60, 5, 'Working Kapital', '', 0, 'L', 1);
        $this->cell(30, 5, formatuang($ta), 0, 0, 'R', 1);
        $this->cell(50, 5, formatuang($tb), 0, 0, 'R', 1);
        $this->cell(40, 5, formatuang($tc), 0, 1, 'R', 1);
        $this->Ln(1);

        $this->cell(180, 1, '', 'B', 1, 'L', 1);

        $this->setFont('Arial', 'B', 10);
        $this->cell(180, 5, 'EQUITY & LIABILITIES', '', 1, 'L', 1);
        $this->Ln(1);

        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);
        // $ta = 0; $tb = 0; $tc = 0;
        if(!empty($data_balance)){
            foreach ($data_balance as $r) {
                if($r->id_sub_group == 4 ){
                    $ta +=  $r->COSTT; $tb += $r->ACCM; $tc += ($r->COSTT-$r->ACCM);
                    $this->cell(20, 5, $r->no_coa, 0, 0, 'L', 1);
                    $this->cell(40, 5, $r->AccountName, 0, 0, 'L', 1);
                    $this->cell(30, 6, formatuang($r->COSTT), 0, 0, 'R', 1);
                    $this->cell(50, 6, formatuang($r->ACCM), 0, 0, 'R', 1);
                    $this->cell(40, 6, formatuang(($r->COSTT-$r->ACCM)), 0, 1, 'R', 1);  
                }                
            }
        }

        $this->cell(180, 1, '', 'B', 1, 'L', 1);
        $this->setFont('Arial', 'B', 9);
        $this->cell(60, 5, 'Retained Profits/(Loss) brought forward', '', 0, 'L', 1);
        $this->cell(30, 5, '', 0, 0, 'R', 1);
        $this->cell(50, 5, '', 0, 0, 'R', 1);
        $this->cell(40, 5, '', 0, 1, 'R', 1);
        $this->Ln(1);

        $this->cell(180, 1, '', 'B', 1, 'L', 1);
        $this->setFont('Arial', 'B', 9);
        $this->cell(60, 5, 'Retained Profits/(Loss) for the period', '', 0, 'L', 1);
        $this->cell(30, 5, '', 0, 0, 'R', 1);
        $this->cell(50, 5, '', 0, 0, 'R', 1);
        $this->cell(40, 5, '', 0, 1, 'R', 1);
        $this->Ln(1);

        $this->cell(180, 1, '', 'B', 1, 'L', 1);
        $this->setFont('Arial', 'B', 9);
        $this->cell(60, 5, 'Total', '', 0, 'L', 1);
        $this->cell(30, 5, formatuang($ta), 0, 0, 'R', 1);
        $this->cell(50, 5, formatuang($tb), 0, 0, 'R', 1);
        $this->cell(40, 5, formatuang($tc), 0, 1, 'R', 1);
        $this->Ln(1);


    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-10);
        $this->setFont('Arial', 'i', 8);

        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, 290,203, 290);
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }
}

$pdf = new PDF();
// $pdf->dari=$dari;
// $pdf->sampai=$sampai;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($data_balance);
$pdf->Output();
