<?php


class PDF extends TFPDF {

    //Page header
     function Header() {
        $titel = 'Receivable Aging';
        $this->Image('assets/PSG.png', 12, 10, 25, 0, 'PNG');
        $this->setFont('Arial', 'B', 12);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(85);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(85);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(85);
        $this->cell(25, 6, 'AR Aging For Period '.date('d-m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln(10);
        
        $this->setFont('Arial', 'B', 6);
        $this->Line(10, 47, 203, 47);
        // $this->cell(50, 6, 'Customer', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, 'Inv Number', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, 'Due Date', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, '0-30 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, '31-60 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, '61-91 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, '91-120 D', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, '> 120 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(16, 6, 'Total', 'BTRL', 1, 'C', 1);
    }

    function Content($get_data, $SupplierID, $GroupSupplierID, $periode) {        

        $this->setFillColor(255, 255, 255);
        $NO = 1;

        
        if (!empty($get_data)) {
            foreach ($GroupSupplierID as $m){
                $total = 0;
                $gt = 0;
                $duedate = 0;
                $sd30 = 0;
                $sd60 = 0;
                $sd90 = 0;
                $sd120 = 0;
                $grand_total = 0;
                $gt = 0;
                // $this->setFont('Arial', 'B', 6);
                $this->SetFont('NotoSans-Regular', '', 8);
                $this->cell(194, 6, $m->suppliercompany, 0, 1, 'L', 1);
                $this->cell(194, 6, $m->customer_address, 'B', 1, 'L', 1);
                $this->setFont('Arial', '', 6);

                // $this->cell(50, 6, 'Customer', 'BTRL', 0, 'C', 1);
                $this->cell(18, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
                $this->cell(25, 6, 'Inv Number', 'BTRL', 0, 'C', 1);
                $this->cell(18, 6, 'Due Date', 'BTRL', 0, 'C', 1);
                $this->cell(11, 6, 'Currency', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, 'Amount', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, 'current', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, '0-30 Days', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, '31-60 Days', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, '61-90 Days', 'BTRL', 0, 'C', 1);
                $this->cell(21, 6, '> 91 D', 'BTRL', 1, 'C', 1);
                
                

                foreach ($get_data as $v) {
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($v->tmp_kodesup == $m->kode_sup) {
                        // $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                        // $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                        // $duedate += $v->tmp_not_due_date;
                        // $sd30 += $v->tmp_0sd30;
                        // $sd60 += $v->tmp_31sd60;
                        // $sd90 += $v->tmp_61sd90;
                        // $sd120 += $v->tmp_91sd120;
                        // $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                        $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                        $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                        $duedate += $v->tmp_not_due_date;
                        $sd30 += $v->tmp_0sd30;
                        $sd60 += $v->tmp_31sd60;
                        $sd90 += $v->tmp_61sd90;
                        $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                        $grand_total += $v->tmp_91sd120 + $v->tmp_more120;

                        // $this->cell(50, 6, "", 'LR', 0, 'C', 1);
                        $this->cell(18, 6, date('d-m-Y', strtotime($v->tmp_inv_date)), 'BTRL', 0, 'R', 1);
                        $this->cell(25, 6, $v->tmp_invno, 'BTRL', 0, 'L', 1); 
                        $this->cell(18, 6, date('d-m-Y', strtotime($v->tmp_due_date)), 'BTRL', 0, 'C', 1); 
                        $this->cell(11, 6, $v->tmp_currency, 'BTRL', 0, 'C', 1);
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $total)), 'BTLR', 0, 'R', 1);   
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $v->tmp_not_due_date)), 'BTLR', 0, 'R', 1);
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $v->tmp_0sd30)), 'BTLR', 0, 'R', 1);
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $v->tmp_31sd60)), 'BTLR', 0, 'R', 1);
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $v->tmp_61sd90)), 'BTLR', 0, 'R', 1);
                        $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $v->tmp_91sd120+$v->tmp_more120)), 'BTLR', 1, 'R', 1);
                        
                        $NO ++;

                        // if($this->SetY() == 100){
                        //     $this->Line(10, 290,204, 290);
                        // }
                    }
                }

                $this->cell(72, 6, "Grand Total", 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $gt)), 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, number_format($duedate, 2), 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $sd30)), 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $sd60)), 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $sd90)), 'BTRL', 0, 'R', 1);
                $this->cell(21, 6, str_replace("$", "", money_format('%(#8n', $sd120)), 'BTRL', 1, 'R', 1);
                $this->ln(2);
            }
            
        }

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-10);
        $this->setFont('Arial', 'i', 8);

        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, 290,204, 290);
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo(). ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->periode=$periode;
$pdf->AliasNbPages();
$pdf->AddFont('NotoSans-Bold', '', 'NotoSans-Bold.ttf', true);
$pdf->AddFont('NotoSans-Regular', '', 'NotoSans-Regular.ttf', true);
$pdf->AddPage();
$pdf->Content($get_data, $SupplierID, $GroupSupplierID, $periode);
$pdf->Output();
