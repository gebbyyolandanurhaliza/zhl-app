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
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 6);
        $this->Cell(80);
        $this->cell(25, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(25, 10, 'www.sambugroup.com', 0, 1, 'C', 1);

    }

    function Content($get_invoice, $get_cust_det, $get_rrg, $get_ccn, $get_umum) {
        // $cur = $_GET['cur'];
         $cur = '';
        
        
        foreach ($get_invoice as $s) {
            $tanggal = date("d/m/Y", strtotime($s->tanggal));
            $tanggal_tempo = date("d/m/Y", strtotime($s->tanggal_tempo));
            $tanggal_invoice = date("d/m/Y", strtotime($s->tanggal_invoice));
            $nofaktur = $s->nofaktur;
            $jenis_trans = $s->jenis_trans;
        }
        if($jenis_trans == 'CCN'){
            $titel = 'CREDIT NOTE';
        }elseif ($jenis_trans == 'CDN') {
            $titel = 'DEBIT NOTE';
        }  else {
            $titel = 'Commercial Invoice';
        }
        $this->setFont('Times', 'B', 16);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(28, 6, $titel, 0, 1, 'C', 1);
        
        $this->Ln(8);
        $this->SetFont('Times', '', 10);
        $this->setFillColor(255, 255, 255);
        //0654/10/2016
        if (!empty($get_cust_det)) {
            foreach ($get_cust_det as $v) {
                $cust = $v->customer_company_name;
                $alamat = $v->customer_address;
            }
        } else {
            $cust = '';
            $alamat = '';
        }
        
        $this->SetFont('Times', 'I', 8);
        $this->SetXY(155, 42);
        $this->Cell(49, 4, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->Ln(5);
        $y = $this->GetY();
        $this->line(11, $y, 199, $y);
        $this->Ln(1);
        $this->SetFont('Times', 'B', 10);
        $this->SetX(11);
        $this->Cell(94, 4, 'Bill To :', 0, 0, 'L');

        $this->SetX(126);
        $this->Cell(20, 4, 'Date');
        $this->SetFont('Times', '', 10);
        $this->SetX(146);
        $this->SetFont('Times', '', 10);
        $this->setFillColor(255, 255, 255);
        $this->Cell(20, 4, ': ' . $tanggal);
        $this->Ln();
        $this->SetFont('Times', '', 10);
        $this->SetX(11);
        $this->Cell(94, 4, $cust);
        $this->SetFont('Times', 'B', 10);
        $this->SetX(126);
        $this->Cell(20, 4, 'Invoice No');
        $this->SetFont('Times', '', 10);
        $this->SetX(146);
        $this->Cell(20, 4, ': ' . $nofaktur);
        $this->Ln();
        $y1 = $this->GetY();
        $this->SetFont('Times', '', 10);
        $this->SetX(11);
        $this->MultiCell(94, 4, str_replace("<br />", " ", $alamat));
        $this->SetFont('Times', 'B', 10);
        $this->SetXY(126, $y1);
        $this->Cell(20, 4, 'Invoice Date');
        $this->SetFont('Times', '', 10);
        $this->SetXY(146, $y1);
        $this->Cell(20, 4, ': ' . $tanggal_invoice);
        $this->SetFont('Times', 'B', 10);
        $this->SetXY(126, $y1 + 4);
        $this->Cell(20, 4, 'Due Date');
        $this->SetFont('Times', '', 10);
        $this->SetXY(146, $y1 + 4);
        $this->Cell(20, 4, ': ' . $tanggal_tempo);
        $this->Ln(10);
        $y2 = $this->GetY();
        $y3 = $this->GetY();

        $total = 0;
        $NO = 1;
        if ($jenis_trans == 'CCN' or $jenis_trans == 'CDN') {
            $this->SetFont('Times', 'B', 10);
            $this->line(11, $y3, 199, $y3);
            $this->cell(10, 5, 'No.', 0, 0, 'L', 1);
            $this->cell(155, 5, 'Description', 0, 0, 'C', 1);
            $this->cell(0, 5, 'Amount (' . $cur . ')', 0, 1, 'C', 1);
            $y4 = $this->GetY();
            $this->line(11, $y4, 199, $y4);

            $this->Ln(2);

            $this->SetFont('Times', '', 10);
            foreach ($get_ccn as $ccn) {
                $total += $ccn->Total;

                $NA = number_format($ccn->Total, 2, '.', ',');

                $this->SetX(10);
                $col1 = $NO++;
                $this->Cell(5, 6, $col1, 0, 0, 'L', 0);

                $this->SetX(172);
                $this->Cell(25, 6, $NA, 0, 0, 'R', 0);

                $this->SetX(20);
                $col3 = $ccn->Uraian;
                $this->MultiCell(155, 6, $col3 . "   ", 0, 1, 'R', 0);
            }
        } else if  ($jenis_trans == 'RRG'){

            $this->line(11, $y2, 199, $y2);
            $this->line(126, $y, 126, $y2);
            $this->Ln(5);
            $this->line(11, $y3, 199, $y3);
            $this->Ln(2);
            $this->SetFont('Times', 'B', 10);
            $this->SetX(13);
            $this->Cell(30, 4, "Description", 0, 0, 'C');
            $this->SetX(121);
            $this->Cell(34, 4, 'Quantity', 0, 0, 'C');
            $this->SetX(145);
            $this->Cell(30, 4, 'Unit Price', 0, 0, 'C');
            $this->SetX(165);
            $this->Cell(44, 4, 'Amount', 0, 0, 'C');
            $this->Ln(6);
            $y4 = $this->GetY();
            $this->line(11, $y4, 199, $y4);
            $this->Ln();

            $this->SetFont('Times', '', 10);
            foreach ($get_rrg as $rrg) {
                $total += $rrg->Qty * $rrg->Harga;
                $this->SetX(10);
                $this->Cell(120, 5, $rrg->no_po, 0, 0, 'L');
                $this->SetX(120);
                $this->Cell(28, 5, number_format($rrg->Qty, 2, '.', ','), 0, 0, 'R');
                $this->SetX(148);
                $this->Cell(22, 5, number_format($rrg->Harga, 2, '.', ','), 10, 0, 'R');
                $this->SetX(170);
                $this->Cell(28, 5, number_format($rrg->Qty * $rrg->Harga, 2, '.', ','), 0, 1, 'R');
            }
        }  else {
            $this->SetFont('Times', 'B', 10);
            $this->line(11, $y3, 199, $y3);
            $this->cell(10, 5, 'No.', 0, 0, 'L', 1);
            $this->cell(155, 5, 'Description', 0, 0, 'C', 1);
            $this->cell(0, 5, 'Amount (' . $cur . ')', 0, 1, 'C', 1);
            $y4 = $this->GetY();
            $this->line(11, $y4, 199, $y4);

            $this->Ln(2);

            $this->SetFont('Times', '', 10);
            foreach ($get_umum as $ccn) {
                $total += $ccn->Total_usd;

                $NA = number_format($ccn->Total_usd, 2, '.', ',');

                $this->SetX(10);
                $col1 = $NO++;
                $this->Cell(5, 6, $col1, 0, 0, 'L', 0);

                $this->SetX(172);
                $this->Cell(25, 6, $NA, 0, 0, 'R', 0);

                $this->SetX(20);
                $col3 = $ccn->Uraian;
                $this->MultiCell(155, 6, $col3 . "   ", 0, 1, 'R', 0);
            }
        }

        $this->SetFont('Times', 'B', 10);
        $this->Ln(2);
        $y4 = $this->GetY();
        $this->line(11, $y4, 199, $y4);
        $this->SetX(148);
        $this->Cell(22, 5, 'Total', 10, 0, 'R');
        $this->SetX(170);
        $this->Cell(28, 5, number_format($total, 2, '.', ','), 0, 1, 'R');
        $this->Ln();



        $NO = 1;
        $this->SetFont('Times', '', 8);
        $this->setFillColor(255, 255, 255);
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-60);
        //nomor halaman
        $kurs = $_GET['cur'];
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
        $this->setFont('Arial', 'B', 8);
        $this->Cell(100, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'R');
        $this->setFont('Arial', '', 8);
        $this->Cell(10, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'l');
        $this->Cell(10, 5, 'Oversea - Chinese Banking Corporation Ltd, Singapore', 0, 1, 'l');
        $this->Cell(10, 5, 'Swift Code : OCBCSGSG', 0, 1, 'l');

        $this->Cell(90, 5, $titel, 0, 0, 'L');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(95, 5, 'Mr. FOK YEW HON HENRY', 0, 1, 'R');

        $this->setFont('Arial', '', 8);
        $this->Cell(10, 5, $titel1, 0, 1, 'l');
        $this->Cell(10, 5, $titel2, 0, 1, 'l');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_invoice, $get_cust_det, $get_rrg, $get_ccn, $get_umum);
$pdf->Output();
