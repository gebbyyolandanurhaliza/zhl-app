<?php

class PDF extends TFPDF {

    //Page header
    function Header() {
        $titel = 'Receivable Statement Of Account';
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
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(90);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(90);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 41, 250 - 50, 41);
        $this->ln(2);
    }

    function Content( $SupplierID, $get_agings) {

        $this->setFont('arial', 'B', 12);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 5, 'Receivable Statement Of Account', 0, 1, 'C', 1);
        

        foreach ($SupplierID as $s) {
            $alamat = $s->customer_address;
            $address =str_replace('<br />','', $alamat);

            // $this->setFont('arial', '', 6);
            $this->SetFont('NotoSans-Regular', '', 6);
            $this->cell(60, 5, $s->customer_company_name, 0, 1, 'L', 1);
            $this->MultiCell(2500,5,$address,0,'L',1);
            $this->cell(60, 5, "Phone  : " . $s->customer_phone, 0, 1, 'L', 1);
            $this->cell(60, 5, "email  : " . strtolower($s->customer_email), 0, 1, 'L', 1);
            $this->cell(60, 5, "Contact Person  : " . $s->customer_contact_name, 0, 1, 'L', 1);
        }
        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 84, 240 - 40, 84);
        $this->cell(55, 6, 'Invoice', 0, 0, 'L', 1);
        $this->cell(25, 6, 'Invoice Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Due Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Currency', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Invoice Amount', 0, 0, 'R', 1);
        $this->cell(30, 6, 'Open Amount', 0, 1, 'R', 1);
        $this->Line(10, 90, 240 - 40, 90);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);
        $total_inv_amount=0;
        $total_open_amount=0;
        foreach ($get_agings as $key) {
            if(!empty($key->tmp_invno)){
                $currency=$key->tmp_currency;
                $total_inv_amount+=$key->tmp_piutang;
                $total_open_amount+=$key->tmp_piutang - $key->tmp_payment;
                $this->cell(55, 6, $key->tmp_invno, 0, 0, 'L', 1);
                $this->cell(25, 6, date('d/m/Y', strtotime($key->tmp_inv_date)), 0, 0, 'C', 1);
                $this->cell(25, 6, date('d/m/Y', strtotime($key->tmp_due_date)), 0, 0, 'C', 1);
                $this->cell(25, 6, $key->tmp_currency, 0, 0, 'C', 1);
                $this->cell(30, 6, number_format($key->tmp_piutang, 2), 0, 0, 'R', 1);
                $this->cell(30, 6, number_format($key->tmp_piutang - $key->tmp_payment, 2), 0, 1, 'R', 1);
                $NO ++;    
            }
        }

        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->cell(105, 6, 'TOTAL', 'BT', 0, 'L', 1);
        // $this->cell(22, 6, $currency, 0, 0, 'R', 1);
        $this->cell(25, 6, '', 'BT', 0, 'R', 1);
        $this->cell(30, 6, number_format($total_inv_amount, 2), 'BT', 0, 'R', 1);
        $this->cell(30, 6, number_format($total_open_amount, 2), 'BT', 1, 'R', 1);

        /*foreach ($get_total as $v) {
            $this->Ln(2);
            $this->cell(70, 0, '', 0, 0, 'L', 10);
            $this->cell(120, 0, '', 1, 1, 'L', 1);

            $this->setFont('Arial', 'B', 8);
            $this->cell(80, 6, 'Total', 0, 0, 'R', 1);
            $this->cell(22, 6, $v->tmp_currency, 0, 0, 'R', 1);
            $this->cell(49, 6, '', 0, 0, 'R', 1);
            $this->cell(40, 6, number_format($v->tmp_piutang - $v->tmp_payment, 2), 0, 1, 'R', 1);
        }*/



        $this->SetY(-80);
        $this->setFont('Arial', '', 6);
        $this->Ln(4);
        $this->cell(38, 5, 'AGING ANALYSIS IN DAYS:', 0, 1, 'L', 1);
        $this->cell(38, 5, 'Aging On :', 0, 1, 'L', 1);



        $this->cell(15, 6, '', 0, 0, 'L', 1);
        $this->cell(35, 6, 'Current', 0, 0, 'R', 1);
        $this->cell(35, 6, '1 to 30 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, '31 to 60 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, '61 to 90 Days', 0, 0, 'R', 1);
        $this->cell(35, 6, 'Over 90 Days', 0, 1, 'R', 1);
        $this->cell(190, 0, '', 1, 1, 'L', 1);

        $current = 0;
        $tiga = 0;
        $enam = 0;
        $sembilan = 0;
        $lebih = 0;
        foreach ($get_agings as $x) {
            $currency = $x->tmp_currency;
            $current += $x->tmp_not_due_date;
            $tiga += $x->tmp_0sd30;
            $enam += $x->tmp_31sd60;
            $sembilan += $x->tmp_61sd90;
            $lebih += $x->tmp_91sd120 + $x->tmp_more120;
        }
        // $this->cell(15, 6, $currency, 0, 0, 'R', 1);
        $this->cell(15, 6, '', 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($current, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($tiga, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($enam, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($sembilan, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($lebih, 2), 0, 1, 'R', 1);
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-23);
        $this->setFont('Arial', 'i', 6);
        $this->Cell(30, 5, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 5, 'We Reserve the right to charge interest at 1.5% per month & to hold future deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 5, 'Thank you for your kind co-operation.', 0, 1, 'L');
        $this->setFont('Arial', '', 6);
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, 290, 250-50, 290);
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('NotoSans-Bold', '', 'NotoSans-Bold.ttf', true);
$pdf->AddFont('NotoSans-Regular', '', 'NotoSans-Regular.ttf', true);
$pdf->Content( $SupplierID, $get_agings);
$pdf->Output();
