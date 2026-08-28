<?php

class PDF extends TFPDF {

    //Page header
    function Header() {
        $Jenis = $_GET['jenis'];
        if ($Jenis == 'CCN') {
            $titel = 'CREDIT NOTE';
        } elseif ($Jenis == 'CDN') {
            $titel = 'DEBIT NOTE';
        }
        $y_axis_initial = 10;
        $this->SetXY(8, $y_axis_initial);
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
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shopping Centre, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
        $this->Line(10, 44, 250 - 50, 44);

        $this->Ln(10);
        $this->setFont('times', 'B', 16);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(28, 6, $titel, 0, 1, 'C', 1);
    }

    function Content($nota, $get_gst, $detail_print, $detail_sgd) {

        $this->Ln(5);
        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);
        $Jns = $_GET['jenis'];
        if ($Jns == 'CCN') {
            $ttel = 'Credit';
        } elseif ($Jns == 'CDN') {
            $ttel = 'Debit';
        }

        foreach ($nota as $s) {

            $cur = $_GET['cur'];
            $str = $s->address;

            $this->setFont('Arial', 'B', 10);
            $this->cell(120, 5, $ttel . ' the account of', 0, 0, 'L', 1);

            $this->setFont('times', '', 10);
            $this->cell(70, 5, $ttel . ' Note Number : ' . $s->no_reff, 0, 1, 'l', 1);


            $this->SetFont('NotoSans-Regular', '', 10);
            // $this->setFont('Arial', '', 10);
            $this->cell(120, 5, $s->customer_name, 0, 0, 'L', 1);

            // $this->setFont('times', '', 10);
            $this->SetFont('NotoSans-Regular', '', 10);
            $this->cell(70, 5, 'Date : ' . date_format(New DateTime($s->tanggal), 'd M Y'), 0, 1, 'l', 1);
            $this->SetX(10);
            $this->MultiCell(120, 5, str_replace("<br />", " ", $s->address), 0, 1, '', 1);
            $this->SetXY(130, 71);

            $this->cell(120, 5, 'Due Date : ' . date_format(New DateTime($s->tanggal_tempo), 'd M Y'), 0, 1, 'l', 1);

            $this->SetXY(130, 76);

            $this->cell(70, 5, 'Currency : ' . $s->currency, 0, 1, 'l', 1);
            $this->SetXY(130, 81);
            $this->cell(70, 5, 'Acct No. : ', 0, 1, 'l', 1);

            $this->cell(60, 5, 'Tel : ' . $s->customer_phone, 0, 0, '', 1);
            $this->cell(60, 5, 'Fax : ' . $s->customer_fax, 0, 0, '', 1);
            $this->cell(70, 5, 'Invoice No. : ' . $s->no_nota, 0, 1, 'l', 1);
        }

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 95, 250 - 50, 95);
        $this->cell(10, 5, 'No.', 0, 0, 'L', 1);
        $this->cell(155, 5, 'Description', 0, 0, 'C', 1);
        $this->cell(0, 5, 'Amount (' . $cur . ')', 0, 1, 'C', 1);
        $this->Line(10, 102, 250 - 50, 102);

        $this->Ln(2);

        //$NO = 1;
        $this->setFont('times', '', 10);
        $this->setFillColor(255, 255, 255);




        $this->SetXY(20, 104);
        foreach ($nota as $key) {
            $col2 = $key->keterangan;
            $this->MultiCell(155, 6, "" . $col2 . "", 0, 1, 'R', 0);
        }

        $this->SetX(20);
        $NO = 1;

        if (!empty($detail_print)) {
            foreach ($detail_print as $value) {

                $NA = (number_format(abs($value->Total), 2, '.', ','));

                $this->SetX(10);
                $col1 = $NO++;
                $this->Cell(5, 6, $col1, 0, 0, 'L', 0);

                $this->SetX(175);
                $this->Cell(25, 6, $NA, 0, 0, 'R', 0);

                $this->SetX(20);
                $col3 = $value->Uraian;
                $this->MultiCell(155, 6, $col3 . "   ", 0, 1, 'R', 0);
            }
        }

        
        foreach ($get_gst as $x) {
            $totalGST = $x->gst_value;
            if ($totalGST > '0') {
                $jenis = 'GST 7%';
                $totalGST = $x->gst_value;
            } else {
                $jenis = 'TAX';
                $totalGST = 0;
            }
        }


        foreach ($nota as $v) {
            $this->SetY(-70);
            //buat garis horizontal
            $this->Line(10, $this->GetY()-1, 250 - 50, $this->GetY()-1);
            $total = 0;
            $total += $v->total - $totalGST;
            $this->cell(160, 6, 'SUB TOTAL', 0, 0, 'R', 1);

            $this->Cell(0, 6, (number_format(abs($total), 2, '.', ',')) . "\n", 0, 1, 'R');
        }

        $this->cell(160, 6, $jenis, 0, 0, 'R', 1);
        $this->Cell(0, 6, (number_format(abs($totalGST), 2, '.', ',')) . "\n", 0, 1, 'R');

        foreach ($nota as $v) {
            $this->setFont('times', 'B', 10);

            $total = $v->total;
            $this->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
            $this->Cell(0, 6, (number_format(abs($total), 2, '.', ',')) . "\n", 0, 1, 'R');
        }
        $this->SetY(-70);
        $this->setFont('times', 'i', 8);
        $this->setFont('times', 'B', 8);
        $cur = $_GET['cur'];
        if ($cur == 'USD') {
            // foreach ($detail_sgd as $ve) {
            //     if ($ve->gst_value <> 0) {
            //         $this->Cell(60, 6, 'Before GST = SGD ' . number_format($ve->Total, 2, '.', ','), 0);
            //         $this->Cell(40, 6, 'USD 1 = SGD ' . $ve->rate_sgd, 0, 1);
            //         $this->Cell(80, 6, 'GST 7% = SGD' . number_format($ve->Total * $ve->rate_sgd * 0.07, 2, '.', ','), 0, 1);
            //         $this->Cell(80, 6, 'After GST = SGD ' . number_format($ve->Total - ($ve->Total * $ve->rate_sgd * 0.07), 2, '.', ','), 0, 1);
            //     }
            // }
        }
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-40);
        //nomor halaman
        $kurs = $_GET['cur'];
        $tanda_tangan = $_GET['signature'];
        if ($kurs == 'USD') {
            $titel = 'USD Account : 666002845301';
            $titel1 = 'For Intermediary Bank : JP Morgan Chase Bank, New York';
            $titel2 = 'Swift Code : CHASUS33';
        } elseif ($kurs == 'SGD') {
            $titel = 'SGD Account : 617876255001';
            $titel1 = '';
            $titel2 = '';
        }
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $this->Cell(90, 5, 'All remittances must be made payable to :', 0, 0, 'L');
        $this->setFont('Arial', 'B', 10);
        $this->Cell(100, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'R');
        $this->setFont('Arial', 'i', 8);
        $this->Cell(10, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'l');
        $this->Cell(10, 5, 'Oversea - Chinese Banking Corporation Ltd, Singapore', 0, 1, 'l');
        $this->Cell(10, 5, 'Swift Code : OCBCSGSG', 0, 1, 'l');

        $this->Cell(90, 5, $titel, 0, 0, 'L');
        $this->setFont('Arial', 'B', 10);
        $this->Cell(95, 5, $tanda_tangan, 0, 1, 'R');

        $this->setFont('Arial', '', 8);
        $this->Cell(10, 5, $titel1, 0, 1, 'l');
        $this->Cell(10, 5, $titel2, 0, 1, 'l');
    }

}

$pdf = new PDF();
// $pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);
// $pdf->AddFont('NotoSans-Regular', '', 'NotoSans-Regular.ttf', true);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($nota, $get_gst, $detail_print, $detail_sgd);
$pdf->Output();
