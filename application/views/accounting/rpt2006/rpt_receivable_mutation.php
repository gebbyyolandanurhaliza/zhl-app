<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Aged Receivable Summary';
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
        $this->cell(25, 6, 'Account Receivable Outstanding Report '.date('d-m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln(10);

        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);
        $this->cell(130, 6, 'Customer', 'BTRL', 0, 'C', 1);
        $this->cell(60, 6, 'Total ('.$this->cur.')', 'BTRL', 1, 'C', 1);
    }

    function Content($Get_aging, $GroupSupplierID) {        
        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $totgt = 0;

        foreach ($GroupSupplierID as $m) {
            $gt = 0;

            foreach ($Get_aging as $key) {
                if ($key->tmp_kodesup == $m->kode_sup) {
                    $gt += $key->tmp_not_due_date + $key->tmp_0sd30 + $key->tmp_31sd60 + $key->tmp_61sd90 + $key->tmp_91sd120 + $key->tmp_more120;
                }
            }
            $this->cell(130, 6, $m->suppliercompany, 'BTRL', 0, 'L', 1);
            $this->cell(60, 6, number_format($gt, 2), 'BTRL', 1, 'R', 1);
            $totgt += $gt;
        }

        $NO = 1;
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        
        $this->cell(130, 6, "Grand Total", 'BTRL', 0, 'R', 1);
        $this->cell(60, 6, number_format($totgt, 2), 'BTRL', 1, 'R', 1);

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-20);
        $this->setFont('Arial', 'i', 8);

        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(),199, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->periode=$periode;
$pdf->cur=$cur;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($Get_aging, $GroupSupplierID);
$pdf->Output();
