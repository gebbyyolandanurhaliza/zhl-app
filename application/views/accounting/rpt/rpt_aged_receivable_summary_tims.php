<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Aged Receivable Summary';
        $this->SetX(10);
        $this->Cell(190,30,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);
        $this->SetY(40);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Aged Receivable Summary ZHT For Period '.date('d-m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln();

        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        $this->cell(50, 6, 'Customer', 'BTRL', 0, 'C', 1);
        $this->cell(25, 6, 'Outstanding Amount', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Current ', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, '0 - 30 Days', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, '31 - 60 Days', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, '61 - 91 Days', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, '> 91 Days', 'BTRL', 0, 'C', 1);
        $this->cell(20, 6, 'Total ('.$this->cur.')', 'BTRL', 1, 'C', 1);
    }

    function Content($get_data_detail, $GroupSupplierID) {        
        $NO = 1;
        $this->setFont('Arial', '', 6);
        $this->setFillColor(255, 255, 255);

        $totgt = 0;
        $totduedate = 0;
        $totsd30 = 0;
        $totsd60 = 0;
        $totsd90 = 0;
        $totsd120 = 0; 

        foreach ($GroupSupplierID as $m) {
        // $this->cell(280, 6, $m->suppliercompany, 'BTRL', 1, 'L', 1);
            $duedate = 0;
            $sd30 = 0;
            $sd60 = 0;
            $sd90 = 0;
            $sd120 = 0;
            $grand_total = 0;
            $gt = 0;

            foreach ($get_data_detail as $key) {
                if ($key->tmp_kodesup == $m->kode_sup) {
                    $total = $key->tmp_not_due_date + $key->tmp_0sd30 + $key->tmp_31sd60 + $key->tmp_61sd90 + $key->tmp_91sd120 + $key->tmp_more120;
                    $gt += $key->tmp_not_due_date + $key->tmp_0sd30 + $key->tmp_31sd60 + $key->tmp_61sd90 + $key->tmp_91sd120 + $key->tmp_more120;
                    $duedate += $key->tmp_not_due_date;
                    $sd30 += $key->tmp_0sd30;
                    $sd60 += $key->tmp_31sd60;
                    $sd90 += $key->tmp_61sd90;
                    $sd120 += $key->tmp_91sd120 + $key->tmp_more120;
                    $grand_total += $key->tmp_91sd120 + $key->tmp_more120;
                }
            }
            $this->cell(50, 6, $m->suppliercompany, 'BTRL', 0, 'L', 1);
            $this->cell(25, 6, number_format($gt, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($duedate, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($sd30, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($sd60, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($sd90, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($sd120, 2), 'BTRL', 0, 'R', 1);
            $this->cell(20, 6, number_format($gt, 2), 'BTRL', 1, 'R', 1);
            $totgt += $gt;
            $totduedate += $duedate;
            $totsd30 += $sd30;
            $totsd60 += $sd60;
            $totsd90 += $sd90;
            $totsd120 += $sd120;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 6);
        $this->setFillColor(255, 255, 255);

        
        $this->cell(50, 6, "Grand Total", 'BTRL', 0, 'R', 1);
        $this->cell(25, 6, number_format($totgt, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totduedate, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totsd30, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totsd60, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totsd90, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totsd120, 2), 'BTRL', 0, 'R', 1);
        $this->cell(20, 6, number_format($totgt, 2), 'BTRL', 1, 'R', 1);

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-20);
        $this->setFont('Arial', 'i', 6);

        $this->setFont('Arial', '', 6);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(),202, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->periode=$periode;
$pdf->cur=$cur;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail, $GroupSupplierID);
$pdf->Output();
