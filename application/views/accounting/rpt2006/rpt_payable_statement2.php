<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(80);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
    }

    function Content($get_data_detail, $SupplierID, $get_total, $get_data_footer) {
        $this->Ln(5);
        $this->setFont('arial', '', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($SupplierID as $s) {
            $this->setFont('arial', 'B', 8);
            $this->cell(180, 5, 'Statement Of Account', 0, 1, 'C', 1);
            $this->cell(180, 5, 'As at ' . date("d F Y"), 0, 1, 'C', 1);
        $this->Ln();
            $this->setFont('arial', '', 8);
            $this->cell(60, 5, $s->suppliercompany, 0, 1, 'L', 1);
            $this->cell(60, 5, $s->address, 0, 1, 'L', 1);
            $this->cell(60, 5, "Phone  : " . $s->telephone, 0, 1, 'L', 1);
            $this->cell(60, 5, "Website  : " . strtolower($s->website), 0, 1, 'L', 1);
        }
        $this->Ln();
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 80, 240 - 40, 80);
        $this->cell(35, 6, 'Invoice', 0, 0, 'L', 1);
        $this->cell(25, 6, 'Invoice Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Due Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Currency', 0, 0, 'C', 1);
        $this->cell(40, 6, 'Invoice Amount', 0, 0, 'R', 1);
        $this->cell(40, 6, 'Open Amount', 0, 1, 'R', 1);
        $this->Line(10, 86, 240 - 40, 86);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($get_data_detail as $key) {
            $this->cell(35, 6, $key->nofaktur, 0, 0, 'L', 1);
            $this->cell(25, 6, date('d/m/Y', strtotime($key->tanggal)), 0, 0, 'C', 1);
            $this->cell(25, 6, date('d/m/Y', strtotime($key->tanggal_tempo)), 0, 0, 'C', 1);
            $this->cell(25, 6, $key->currency_id, 0, 0, 'C', 1);
            $this->cell(40, 6, number_format($key->hutang, 2), 0, 0, 'R', 1);
            $this->cell(40, 6, number_format($key->hutang * $key->rate_awal, 2), 0, 1, 'R', 1);
            $NO ++;
        }


        foreach ($get_total as $v) {
            $this->Ln(2);
            $this->cell(70, 0, '', 0, 0, 'L', 10);
            $this->cell(120, 0, '', 1, 1, 'L', 1);

            $this->setFont('Arial', 'B', 8);
            $this->cell(80, 6, 'Total', 0, 0, 'R', 1);
            $this->cell(22, 6, $v->currency_id, 0, 0, 'R', 1);
            $this->cell(49, 6, '', 0, 0, 'R', 1);
            $this->cell(40, 6, number_format($v->hutang, 2), 0, 1, 'R', 1);
        }
        $this->setFont('Arial', '', 8);
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
        foreach ($get_data_footer as $x) {
            $currency = $x->tmp_currency;
            $current += $x->tmp_not_due_date;
            $tiga += $x->tmp_0sd30;
            $enam += $x->tmp_31sd60;
            $sembilan += $x->tmp_61sd90;
            $lebih += $x->tmp_91sd120;
        }
        $this->cell(15, 6, $currency, 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($current, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($tiga, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($enam, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($sembilan, 2), 0, 0, 'R', 1);
        $this->cell(35, 6, number_format($lebih, 2), 0, 1, 'R', 1);
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-30);
        $this->setFont('Arial', 'i', 8);
        $this->Cell(30, 5, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 5, 'We Reserve the right to charge interest at 1.5% per month & to hold future', 0, 1, 'L');
        $this->Cell(20, 5, 'deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 5, 'Thank you for your kind co-operation.', 0, 1, 'L');
        $this->setFont('Arial', '', 8);
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail, $SupplierID, $get_total, $get_data_footer);
$pdf->Output();
