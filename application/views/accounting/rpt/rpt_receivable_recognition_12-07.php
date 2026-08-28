<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Invoice';
        $this->Image('assets/PSG.png', 10, 10, 35, 0, 'PNG');
        $this->setFont('Arial', 'B', 20);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(50, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(40, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(40, 6, '19 Tanglin Road, #11-01/02, Tanglin Shopping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(40, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(40, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 45, 250 - 50, 45);

        $this->Ln(10);
        $this->setFont('Arial', 'B', 22);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(40, 6, $this->he, 0, 1, 'C', 1);
    }

    function Content($get_data_detail, $nota) {
        $this->Ln(5);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $alamat1 = '';
        foreach ($nota as $s) {
            $str = $s->address;
            $alamat = explode("<br />", $str);

            if (isset($alamat[0])) {
                $str = $s->address;
                $alamat = explode(",", $str);
                $alamat1 = (isset($alamat[1]) ? $alamat[1] : '') ;
            } else {
                $alamat1 = (isset($alamat[1]) ? $alamat[1] : '') ;
            }

            $this->cell(15, 6, 'To : ', 0, 0, 'L', 1);
            $this->cell(60, 6, strtoupper($s->namacustomer), 0, 0, 'L', 1);

            $this->cell(65, 6, 'Date : ', 0, 0, 'R', 1);
            $this->cell(0, 6, date_format(New DateTime($s->tanggal_invoice), 'M, d-Y'), 0, 1, '', 1);

            $this->cell(15, 6, 'Address : ', 0, 0, '', 1);
            $this->cell(80, 6, $alamat[0], 0, 0, 'L', 1);

            $this->cell(45, 6, 'Debit Note Number : ', 0, 0, 'R', 1);
            $this->cell(0, 6, $s->nofaktur, 0, 1, 'L', 1);

            $this->cell(15, 6, '', 0, 0, '', 1);
            $this->cell(60, 6, $alamat1, 0, 0, 'L', 1);

            $this->cell(65, 6, 'Due Date : ', 0, 0, 'R', 1);
            $this->cell(0, 6, date_format(New DateTime($s->tanggal_tempo), 'M, d-Y'), 0, 1, 'L', 1);

            $this->cell(15, 6, 'Attn :', 0, 0, '', 1);
            $this->cell(110, 6, $s->contactperson, 0, 0, 'L', 1);

            $this->cell(15, 6, 'Payment Term : ', 0, 0, 'R', 1);
            $this->cell(0, 6, $s->term, 0, 1, 'L', 1);
        }

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 90, 250 - 50, 90);
        $this->cell(20, 6, 'No.', 0, 0, 'C', 1);
        $this->cell(120, 6, 'Description', 0, 0, 'C', 1);
        $this->cell(0, 6, 'Amount ('.$_GET['cur'].')', 0, 1, 'R', 1);
        // $this->Line(10, 98, 250 - 50, $this->GetY());

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 10);
        $this->setFillColor(255, 255, 255);
        $w = 140;
        $h = 5;
        $total1 = 0;
        $totalgst = 0;
        if (!empty($get_data_detail)) {
            foreach ($get_data_detail as $key) {
                $x = $this->GetX();
                $y = $this->GetY();
                
                //$this->SetXY($x + 0, $y);
                $this->cell(20, 6, $NO, 0, 0, 'C');
                $col2 = $key->Items . "   ";
                $this->SetXY($x + 20, $y);
                $this->MultiCell($w, 6, $col2. "", 0, 'L', true);
                
                //masalhnya terletak di x
                $this->SetXY($x + 160, $y);
                if ($key->Qty * $key->Harga == 0){
                    $col3 = $key->total_inv;
                }else{
                    $col3 = $key->Qty * $key->Harga;
                }
                $this->Cell(32, 6, number_format($col3, 2), 0, 1, 'R');
                
                $total1 += $col3;
                $totalgst += $key->gst_value;

              
                $NO ++;
            }
        }

        if($totalgst != 0){
            $this->he = "TAX INVOICE";
        }
        else{
            $this->he = "INVOICE";
        }

        foreach ($nota as $v) {
            $this->SetY(-90);
            //buat garis horizontal
            $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());

            if($totalgst == 0){
                $this->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
                $this->Cell(0, 6, number_format($v->piutang, 2, '.', ','), 0, 1, 'R', 1);
            }
            else{
                $this->cell(160, 6, 'SUB TOTAL', 0, 0, 'R', 1);
                $this->Cell(0, 6, number_format($total1, 2, '.', ','), 0, 1, 'R', 1);

                $this->cell(160, 6, 'GST 7%', 0, 0, 'R', 1);
                $this->Cell(0, 6, number_format($totalgst, 2, '.', ','), 0, 1, 'R', 1);
    
                $this->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
                $this->Cell(0, 6, number_format($v->piutang, 2, '.', ','), 0, 1, 'R', 1);
            }
            

            

            $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());
        }
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-60);
        //nomor halaman
        $kurs = $_GET['cur'];
        $tanda_tangan = $_GET['signature'];
        if ($kurs == 'USD') {
            $titel = 'USD Account : 666002845301';
        } elseif ($kurs == 'SGD') {
            $titel = 'SGD Account : 617876255001';
        }
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $this->Cell(90, 5, 'All remittances must be made payable to :', 0, 0, 'L');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(100, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'R');
        $this->setFont('Arial', '', 8);
        $this->Cell(10, 5, 'Pulau Sambu Singapore PTE LTD', 0, 1, 'l');
        $this->Cell(10, 5, 'Overseas Chinese Banking Corporation Ltd, Singapore', 0, 1, 'l');
        $this->Cell(10, 5, 'Swift Code : OCBCSGSG', 0, 1, 'l');

        $this->Cell(90, 5, $titel, 0, 0, 'L');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(100, 5, $tanda_tangan, 0, 1, 'R');

        $this->setFont('Arial', '', 8);
        $this->Cell(10, 5, 'For Intermediary Bank : JPMorgan Chase Bank, New York', 0, 1, 'l');
        $this->Cell(10, 5, 'Swift Code : CHASUS33', 0, 1, 'l');

        $this->Cell(0, 20, '', 0, 0, 'R');
    }

}

$pdf = new PDF();
$pdf->he = $judul;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail, $nota);
$pdf->Output();
