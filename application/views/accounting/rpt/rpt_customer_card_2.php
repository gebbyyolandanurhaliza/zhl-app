<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Down Payment';
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
        $this->cell(25, 6, 'Customer Card For Period '.date('d-m-Y', strtotime($this->from)).' to '.date('d-m-Y', strtotime($this->to)), 0, 0, 'C', 1);
        $this->Ln();

        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 46, 204, 46);
        $this->cell(15, 6, 'Customer ID', 0, 0, 'C', 1);
        $this->cell(35, 6, 'Customer Name', 0, 0, 'C', 1);
        $this->cell(12, 6, 'Date', 0, 0, 'C', 1);
        $this->cell(47, 6, 'Description', 0, 0, 'C', 1);
        $this->cell(15, 6, 'Reference', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Debit', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Credit', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Balance', 0, 0, 'C', 1);
        $this->cell(8, 6, 'Status', 0, 1, 'C', 1);

        $this->Line(10, 52, 204, 52);
    }

    function Content($Get_aging) {
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);


        foreach ($Get_aging as $data) {

            if($data->tmp_balance < 0){
                $str = str_replace("-", '', $data->tmp_balance);
                $Balance = "(". number_format($str, 2, ",", ".") .")";
            } else {
                $Balance=number_format($data->tmp_balance, 2, ",", ".");
            }
            $this->cell(15, 6, $data->tmp_kodecus, 0, 0, 'C', 1);
            $this->cell(35, 6, $data->tmp_customer_name, 0, 0, 'C', 1);
            $this->cell(12, 6,  date('d-m-Y',strtotime(($data->tmp_tanggal))), 0, 0, 'C', 1);
            $this->cell(47, 6, $data->tmp_uraian, 0, 0, 'L', 1);
            $this->cell(15, 6,$data->tmp_nojurnal , 0, 0, 'C', 1);
            $this->cell(20, 6, number_format($data->tmp_debet, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(20, 6, number_format($data->tmp_kredit, 2 , '.',','), 0, 0, 'R', 1);
            $this->cell(20, 6, $Balance, 0, 0, 'R', 1);

            $huruf = $data->tmp_jenis_trans;
            if( $huruf == 'AR'){
                $this->cell(8, 6, 'Paid', 0, 1, 'R', 1);
            } else if($huruf == 'RDP'){
                $this->cell(8, 6, 'Deposit', 0, 1, 'R', 1);
            }else{
                $this->cell(8, 6, '', 0, 1, 'R', 1);;
            }
            $NO++;
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
$pdf->Content($Get_aging);
$pdf->Output();
