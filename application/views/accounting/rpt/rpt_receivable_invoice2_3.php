<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Comercial Invoice';
        $y_axis_initial = 10;
        $this->SetXY(8, $y_axis_initial);
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(90);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(90);
        $this->cell(25, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(90);
        $this->cell(25, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(90);
        $this->cell(25, 10, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Accounts Receivable Invoice '.date('m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln();

        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        $this->cell(7, 6, 'NO', 'BTRL', 0, 'C', 1);
        $this->cell(45, 6, 'Customer Name', 'BTRL', 0, 'C', 1);
        $this->cell(25, 6, 'Inv. Number', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Due Date', 'BTRL', 0, 'C', 1);
        $this->cell(13, 6, 'Currency', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Total', 'BTRL', 0, 'C', 1);
        $this->cell(13, 6, 'Rate', 'BTRL', 0, 'C', 1);
        $this->cell(15, 6, 'Total '.$this->cur, 'BTRL', 0, 'C', 1);
        $this->cell(30, 6, 'PO', 'BTRL', 1, 'C', 1);
    }

    function Content($get_data_detail) {        
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

        foreach ($get_data_detail as $key) {
            $this->cell(7, 6, $NO, 'BTRL', 0, 'L', 1);
            $this->cell(45, 6, $key->customer_name , 'BTRL', 0, 'L', 1);
            $this->cell(25, 6, $key->nofaktur, 'BTRL', 0, 'L', 1);
            $this->cell(15, 6, $key->tanggal_invoice, 'BTRL', 0, 'C', 1);
            $this->cell(15, 6, $key->tanggal_tempo, 'BTRL', 0, 'C', 1);
            $this->cell(13, 6, $key->currency_id, 'BTRL', 0, 'C', 1);
            $this->cell(15, 6, number_format($key->piutang, 2), 'BTRL', 0, 'R', 1);
            $this->cell(13, 6, $key->rate, 'BTRL', 0, 'R', 1);
            $this->cell(15, 6, number_format($key->Total_usd, 2), 'BTRL', 0, 'R', 1);
            $this->cell(30, 6, substr($key->PO,0,24), 'BTRL', 1, 'L', 1);
            $NO ++;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);
        $prepaid = 0;
        $total = 0;
        $currency = "-";
        $rate = "-";
        $total_usd = 0;
        $ending_rate= "-";
        $ending_total = 0;

        foreach ($get_data_detail as $v) {
             $total += $v->piutang;
             $total_usd += $v->Total_usd;

         }

         $this->cell(120, 6, "Grand Total", 'BTRL', 0, 'R', 1);
         $this->cell(15, 6, number_format($total, 2), 'BTRL', 0, 'R', 1);
        $this->cell(13, 6, '', 'BTRL', 0, 'R', 1);
         $this->cell(15, 6, number_format($total_usd, 2), 'BTRL', 0, 'R', 1);
        $this->cell(30, 6, '', 'BTRL', 0, 'R', 1);

        

    }

    function Footer() {
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 8);
        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 202, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

    

}

$pdf = new PDF('P','mm','A4');
$pdf->cur=$cur;
$pdf->periode=$periode;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail);
$pdf->Output();
