<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Recognition';
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
        $this->cell(40, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(40, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(40, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 45, 250 - 50, 45);

        $this->Ln(10);
        $this->setFont('Arial', 'B', 22);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(40, 6, $titel, 0, 1, 'C', 1);
    }

    function Content($get_data_detail, $nota) {
        $this->Ln(5);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($nota as $s) {
            $str = $s->address;
            $alamat = explode("," or "#", $str);

            $this->cell(15, 6, 'To : ' , 0, 0, 'L', 1);
            $this->cell(60, 6, $s->namavendor, 0, 0, 'L', 1);
            
            $this->cell(65, 6, 'Date : ' , 0, 0, 'R', 1);
            $this->cell(0, 6, date_format(New DateTime($s->tanggal_invoice), 'M, d-Y'), 0, 1, '', 1);

            $this->cell(15, 6, 'Address : ', 0, 0, '', 1);
            $this->cell(60, 6, $alamat[0], 0, 0, 'L', 1);
            
            $this->cell(65, 6, 'Debit Note Number : ' , 0, 0, 'R', 1);
            $this->cell(0, 6, $s->nofaktur, 0, 1, 'L', 1);

            $this->cell(15, 6, '', 0, 0, '', 1);
            $this->cell(60, 6, $alamat[1], 0, 0, 'L', 1);
            
            $this->cell(65, 6, 'Due Date : ' , 0, 0, 'R', 1);
            $this->cell(0, 6, date_format(New DateTime($s->tanggal_tempo), 'M, d-Y'), 0, 1, 'L', 1);

            $this->cell(15, 6, 'Attn :', 0, 0, '', 1);
            $this->cell(110, 6, $s->contactperson, 0, 0, 'L', 1);
            
            $this->cell(15, 6, 'Payment Term : ' , 0, 0, 'R', 1);
            $this->cell(0, 6, $s->term, 0, 1, 'L', 1);
        }

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 90, 260 - 50, 90);
        $this->cell(20, 6, 'Ref', 0, 0, 'C', 1);
        $this->cell(120, 6, 'Description', 0, 0, 'C', 1);
        $this->cell(0, 6, 'Amount (USD)', 0, 1, 'C', 1);
        $this->Line(10, 98, 260 - 50, 98);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 10);
        $this->setFillColor(255, 255, 255);

        foreach ($get_data_detail as $key) {
            $this->cell(20, 6, '', 0, 0, 'C', 1);
            $col2 = $NO . ". " . $key->Items . "\n    " . $key->HeaderID . "\n    " . $key->Qty . "packs @ US$ " . $key->Harga . " = US$" . $key->Harga * $key->Qty;
            $this->MultiCell(120, 6, $col2, 0, 1, 'R', 1);
            $NO ++;
        }
        foreach ($nota as $v) {
            $this->SetY(99);
            $this->Cell(0, 6, $v->hutang . "\n", 0, 1, 'R');
        }
    }

  
    function Footer() {
        //atur posisi 1.5 cm dari bawah
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
$pdf->Content($get_data_detail, $nota);
$pdf->Output();
