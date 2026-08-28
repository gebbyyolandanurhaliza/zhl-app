<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
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
        $this->Ln(2);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Accounts Payable Invoice '.date('m-Y', strtotime($this->periode)), 0, 1, 'C', 0);
        $this->Ln();
        
       
    }

    function Content($get_data_detail, $get_supply) {        
        
        // $this->SetTextColor(0, 0, 0);
        // $this->setFillColor(255, 255, 255);
        // // $this->Cell(90);
        // $this->setFont('Arial', 'B', 6);
        // $this->cell(7, 6, 'NO',  'BTRL', 0, 'C', 1);
        // // $this->cell(45, 6, 'Supplier Name', 'BTRL', 0, 'C', 1);
        // $this->cell(25, 6, 'Inv. Number', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Due Date', 'BTRL', 0, 'C', 1);
        // $this->cell(13, 6, 'Currency', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Total', 'BTRL', 0, 'C', 1);
        // $this->cell(13, 6, 'Rate', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Total '.$this->cur, 'BTRL',1, 'C', 1);
        // $this->cell(30, 6, 'PO', 'BTRL', 1, 'C', 1);
        foreach ($get_supply as $l) {
            $NO = 1;
            $this->setFont('Arial', 'B', 8);
            $this->setFillColor(255, 255, 255);
            $this->SetTextColor(0, 0, 0);
            $this->setFillColor(255, 255, 255);
            // $this->Cell(90);
            $this->cell(90, 6, $l->suppliercompany,  0, 1, 'L', 1);
            $this->setFont('Arial', 'B', 6);
            $this->cell(7, 6, 'NO',  'BTRL', 0, 'C', 1);
            // $this->cell(45, 6, 'Supplier Name', 'BTRL', 0, 'C', 1);
            $this->cell(35, 6, 'Inv. Number', 'BTRL', 0, 'C', 1);
            $this->cell(25, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
            $this->cell(25, 6, 'Due Date', 'BTRL', 0, 'C', 1);
            $this->cell(23, 6, 'Currency', 'BTRL', 0, 'C', 1);
            $this->cell(25, 6, 'Total', 'BTRL', 0, 'C', 1);
            $this->cell(23, 6, 'Rate', 'BTRL', 0, 'C', 1);
            $this->cell(25, 6, 'Total '.$this->cur, 'BTRL',1, 'C', 1);
            //  $NO = 1;
            // $this->setFont('Arial', 'B', 6);
            // $this->setFillColor(255, 255, 255);
            $prepaid = 0;
            $total = 0;
            $currency = "-";
            $rate = "-";
            $total_usd = 0;
            $ending_rate= "-";
            $ending_total = 0;
            // $this->cell(7, 6, $l->kode_sup, 'BTRL', 1, 'L', 1); 
            foreach ($get_data_detail as $key) {
                if($l->kode_sup == $key->kode_sup){
                    $this->setFont('Arial', '', 8);
                    $this->cell(7, 6, $NO, 'BTRL', 0, 'L', 1);
                    // $this->cell(45, 6, $key->suppliercompany , 'BTRL', 0, 'L', 1);
                    $this->cell(35, 6, $key->nofaktur, 'BTRL', 0, 'L', 1);
                    $this->cell(25, 6, $key->tanggal_invoice, 'BTRL', 0, 'C', 1);
                    $this->cell(25, 6, $key->tanggal_tempo, 'BTRL', 0, 'C', 1);
                    $this->cell(23, 6, $key->currency_id, 'BTRL', 0, 'C', 1);
                    $this->cell(25, 6, number_format($key->hutang, 2), 'BTRL', 0, 'R', 1);
                    $this->cell(23, 6, number_format($key->rate_awal, 6, ',', '.'), 'BTRL', 0, 'R', 1);
                    $this->cell(25, 6, number_format($key->Total_usd, 2), 'BTRL', 1, 'R', 1);
                    // $this->cell(30, 6, $key->PO, 'BTRL', 1, 'L', 1);
                    $total += $key->hutang;
                    $total_usd += $key->Total_usd;
                    $NO ++;    
                }
            }
                $this->cell(115, 6, "Grand Total", 'BTRL', 0, 'R', 0);
                $this->cell(25, 6, number_format($total, 2), 'BTRL', 0, 'R', 0);
                $this->cell(23, 6, '-', 'BTRL', 0, 'C', 1);
                $this->cell(25, 6, number_format($total_usd, 2), 'BTRL', 1, 'R', 0);
                $this->ln(2);
                // $this->cell(30, 6, '', 'BTRL', 1, 'R', 0);

        }

       

        foreach ($get_data_detail as $v) {


        }

    

        

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 7);
      /*  $this->Cell(30, 4, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 4, 'We Reserve the right to charge interest at 1.5% per month & to hold future', 0, 1, 'L');
        $this->Cell(20, 4, 'deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 4, 'Thank you for your kind co-operation.', 0, 1, 'L');
      */  $this->setFont('Arial', '', 7);
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
$pdf->Content($get_data_detail, $get_supply);
$pdf->Output();
