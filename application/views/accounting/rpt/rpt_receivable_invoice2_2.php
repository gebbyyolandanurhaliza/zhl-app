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
        $this->Cell(80);
        $this->cell(130, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(130, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(130, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(80);
        $this->cell(130, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(130, 10, 'www.sambugroup.com', 0, 1, 'C', 1);
    }

    function Content($get_data_detail) {        
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 41, 325 - 40, 41);
        $this->cell(16, 6, 'CustomerID', 'BTRL', 0, 'C', 1);
        $this->cell(55, 6, 'Customer Name', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Inv. Number', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Date of Journal', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Due Date', 'BTRL', 0, 'C', 1);
        $this->cell(17, 6, 'Prepaid', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Total', 'BTRL', 0, 'C', 1);
        $this->cell(17, 6, 'Currency', 'BTRL', 0, 'C', 1);
        $this->cell(17, 6, 'Rate', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Total USD', 'BTRL', 0, 'C', 1);
        $this->cell(18, 6, 'Ending Rate', 'BTRL', 0, 'C', 1);
        $this->cell(18, 6, 'Ending Total', 'BTRL', 1, 'C', 1);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($get_data_detail as $key) {
            $this->cell(16, 6, $key->customer_code, 'BTRL', 0, 'L', 1);
            $this->cell(55, 6, $key->customer_name , 'BTRL', 0, 'L', 1);
            $this->cell(20, 6, $key->nofaktur, 'BTRL', 0, 'C', 1);            
            $this->cell(20, 6, $key->tanggal_invoice, 'BTRL', 0, 'C', 1);
            $this->cell(20, 6, $key->tanggal, 'BTRL', 0, 'C', 1);
            $this->cell(20, 6, $key->tanggal_tempo, 'BTRL', 0, 'C', 1);
            $this->cell(17, 6, number_format($key->uang_muka, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($key->sisa_piutang, 2), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, $key->currency_id, 'BTRL', 0, 'C', 1);
            $this->cell(17, 6, $key->rate, 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($key->Total_usd, 2), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, number_format($key->rate_akhir, 6, ',', '.'), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, number_format($key->Total_usd_rateakhir, 2), 'BTRL', 1, 'R', 1);
            $NO ++;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $prepaid = 0;
        $total = 0;
        $currency = "-";
        $rate = "-";
        $total_usd = 0;
        $ending_rate= "-";
        $ending_total = 0;

        foreach ($get_data_detail as $v) {
            $prepaid += $v->uang_muka;
             $total += $v->sisa_piutang;
             $total_usd += $v->Total_usd;
             $ending_total += $v->Total_usd_rateakhir;
         }

         $this->cell(150, 6, "Grand Total", 'BTRL', 0, 'R', 1);
         $this->cell(17, 6, number_format($prepaid, 2), 'BTRL', 0, 'R', 1);
         $this->cell(20, 6, number_format($total, 2), 'BTRL', 0, 'R', 1);
         $this->cell(17, 6, '', 'BTRL', 0, 'C', 1);
         $this->cell(17, 6, '', 'BTRL', 0, 'R', 1);
         $this->cell(20, 6, number_format($total_usd, 2), 'BTRL', 0, 'R', 1);
         $this->cell(17, 6, '', 'BTRL', 0, 'R', 1);
         $this->cell(17, 6, number_format($ending_total, 2), 'BTRL', 1, 'R', 1);

        

    }

    

}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail);
$pdf->Output();
