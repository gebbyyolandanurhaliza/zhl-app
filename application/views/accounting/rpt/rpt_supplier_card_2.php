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

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Vendor Card For Period '.date('d-m-Y', strtotime($this->from)).' to '.date('d-m-Y', strtotime($this->to)), 0, 0, 'C', 1);
        $this->Ln();

        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 46, 204, 46);
        $this->cell(15, 6, 'Supplier ID', 0, 0, 'C', 1);
        $this->cell(35, 6, 'Supplier Name', 0, 0, 'C', 1);
        $this->cell(12, 6, 'Date', 0, 0, 'C', 1);
        $this->cell(47, 6, 'Dercription', 0, 0, 'C', 1);
        $this->cell(15, 6, 'Reference', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Debet', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Credit ', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Balance', 0, 0, 'C', 1);
        $this->cell(8, 6, 'Status', 0, 1, 'C', 1);

        $this->Line(10, 52, 204, 52);
    }

    function Content($get_data) {        
        
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

	$Balance = 0;

        foreach ($get_data as $key) {
            if($key->tmp_balance < 0){
                $str = str_replace("-", '', $key->tmp_balance);
                $Balance = "(". number_format($str, 2, ",", ".") .")";
            } else {
                $Balance=number_format($key->tmp_balance, 2, ",", ".");
            }
            $this->cell(15, 6, $key->tmp_kodesup, 0, 0, 'L', 1);
            $this->cell(35, 6, $key->tmp_supplier_name, 0, 0, 'C', 1);
            $this->cell(12, 6, $key->tmp_tanggal, 0, 0, 'C', 1);            
            $this->cell(47, 6, $key->tmp_uraian, 0, 0, 'L', 1);
            $this->cell(15, 6, $key->tmp_nojurnal, 0, 0, 'L', 1);
            $this->cell(20, 6, number_format($key->tmp_debet, 2), 0, 0, 'R', 1);
            $this->cell(20, 6, number_format($key->tmp_kredit, 2), 0, 0, 'R', 1);
            $this->cell(20, 6, $Balance, 0, 0, 'R', 1);
            $huruf = $key->tmp_jenis_trans;
            if( $huruf == 'AP'){
                $this->cell(8, 6, 'PAID', 0, 1, 'C', 1);
            } else if($huruf == 'PDP'){
                $this->cell(8, 6, 'DEPOSIT', 0, 1, 'C', 1);
            }else{
                $this->cell(8, 6, '', 0, 1, 'C', 1);
            }
            $NO ++;
        }

       

    }

    function Footer() {
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 204, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->from=$from;
$pdf->to=$to;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data);
$pdf->Output();
