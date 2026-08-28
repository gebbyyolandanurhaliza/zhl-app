<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Comercial Invoice';
        $y_axis_initial = 10;
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image(base_url().'assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);
        $this->SetY(40);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Accounts Receivable Invoice '.date('m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln();

       
    }

    function Content($get_data_detail, $supu) {
        foreach ($supu as $l) {
            $prepaid = 0;
            $total = 0;
            $currency = "-";
            $rate = "-";
            $total_usd = 0;
            $ending_rate= "-";
            $ending_total = 0;
            $NO = 1;
            $this->setFont('Arial', 'B', 10);
            $this->setFillColor(255, 255, 255);
            $this->cell(45, 6, $l->customer_name , 0, 1, 'L', 1);
            $this->setFont('Arial', 'B', 6);
            $this->setFillColor(255, 255, 255);

            $this->cell(7, 6, 'NO', 'BTRL', 0, 'C', 1);
            $this->cell(25, 6, 'Inv. Number', 'BTRL', 0, 'C', 1);
            $this->cell(15, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
            $this->cell(15, 6, 'Due Date', 'BTRL', 0, 'C', 1);
            $this->cell(13, 6, 'Currency', 'BTRL', 0, 'C', 1);
            $this->cell(28, 6, 'Total', 'BTRL', 0, 'C', 1);
            $this->cell(13, 6, 'Rate', 'BTRL', 0, 'C', 1);
            $this->cell(28, 6, 'Total USD', 'BTRL', 0, 'C', 1);
            $this->cell(49, 6, 'PO', 'BTRL', 1, 'C', 1);
            foreach ($get_data_detail as $key) {
                if($l->customer_code == $key->customer_code)
                {
                    $this->cell(7, 6, $NO, 'BTRL', 0, 'L', 1);
                    $this->cell(25, 6, $key->nofaktur, 'BTRL', 0, 'L', 1);
                    $this->cell(15, 6, $key->tanggal_invoice, 'BTRL', 0, 'C', 1);
                    $this->cell(15, 6, $key->tanggal_tempo, 'BTRL', 0, 'C', 1);
                    $this->cell(13, 6, $key->currency_id, 'BTRL', 0, 'C', 1);
                    $this->cell(28, 6, number_format($key->piutang, 2), 'BTRL', 0, 'R', 1);
                    $this->cell(13, 6, $key->rate, 'BTRL', 0, 'R', 1);
                    $this->cell(28, 6, number_format($key->Total_usd, 2), 'BTRL', 0, 'R', 1);
                    $this->cell(49, 6, substr($key->PO,0,24), 'BTRL', 1, 'L', 1);
                    $NO ++;

                    $total += $key->piutang;
                    $total_usd += $key->Total_usd;
                }
            }

            $this->cell(75, 6, "Grand Total", 'BTRL', 0, 'R', 1);
            $this->cell(28, 6, number_format($total, 2), 'BTRL', 0, 'R', 1);
            $this->cell(13, 6, '', 'BTRL', 0, 'R', 1);
            $this->cell(28, 6, number_format($total_usd, 2), 'BTRL', 0, 'R', 1);
            $this->cell(49, 6, '', 'BTRL', 1, 'R', 1);
            $this->ln(2);
        }
        

        // $NO = 1;
        // $this->setFont('Arial', 'B', 6);
        // $this->setFillColor(255, 255, 255);
       

        // foreach ($get_data_detail as $v) {
            

        //  }

         

        

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
$pdf->Content($get_data_detail, $supu);
$pdf->Output();
