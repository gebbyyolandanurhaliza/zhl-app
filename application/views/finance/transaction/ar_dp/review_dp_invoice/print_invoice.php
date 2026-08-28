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
        $this->cell(40, 6, '19 Tanglin Road, #11-01/02, Tanglin Shopping Centre, Singapore 247909', 0, 1, 'C', 1);

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
        $this->cell(40, 6, $titel, 0, 1, 'C', 1);
    }

    function Content($get_data_detail, $nota) {
        $this->Ln(5);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $str = $nota->cust_address;
        $alamat = explode("<br />", $str);

        /*if (isset($alamat[0])) {
            $str = $nota->cust_address;
            $alamat = explode(",", $str);
            $alamat1 = $alamat[1];
        }  else {
            $alamat1 = $alamat[1];
        }*/

        $this->cell(15, 6, 'To : ', 0, 0, 'L', 1);
        $this->cell(60, 6, $nota->cust_name, 0, 0, 'L', 1);

        $this->cell(65, 6, 'Date : ', 0, 0, 'R', 1);
        $this->cell(0, 6, date_format(New DateTime($nota->dp_date_inv), 'd M Y'), 0, 1, '', 1);

        $this->cell(15, 6, 'Address : ', 0, 0, '', 1);
        $this->cell(80, 6, $str, 0, 0, 'L', 1);

        $this->cell(45, 6, 'Invoice No. : ', 0, 0, 'R', 1);
        $this->cell(0, 6, $nota->no_reff, 0, 1, 'L', 1);

        $this->cell(15, 6, '', 0, 0, '', 1);
        $this->cell(60, 6, '', 0, 0, 'L', 1);

        $this->cell(65, 6, 'Due Date : ', 0, 0, 'R', 1);
        $this->cell(0, 6, date_format(New DateTime($nota->dp_due_date), 'd M Y'), 0, 1, 'L', 1);

        $this->cell(15, 6, 'Attn :', 0, 0, '', 1);
        $this->cell(110, 6, $nota->cust_contact, 0, 0, 'L', 1);

        $this->cell(15, 6, 'Payment Term : ', 0, 0, 'R', 1);
        $this->cell(0, 6, $nota->dp_term, 0, 1, 'L', 1);

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 90, 260 - 50, 90);
        $this->cell(20, 6, 'No', 0, 0, 'C', 1);
        $this->cell(120, 6, 'Description', 0, 0, 'C', 1);
        $this->cell(0, 6, 'Amount ('.$_GET['cur'].')', 0, 1, 'C', 1);
        $this->Line(10, 98, 260 - 50, 98);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 10);
        $this->setFillColor(255, 255, 255);

        $this->cell(20, 6, '', 0, 0, 'C', 1);
        $col2 =  $nota->trans_description . "\n    ";
        $this->MultiCell(120, 6, $col2, 0, 1, 'R', 1);


        $this->SetY(99);
        $this->Cell(0, 6, number_format($nota->dp_total, 2) . "\n", 0, 1, 'R');

        $this->SetY(-90);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());

        $this->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
        $this->Cell(0, 6, number_format($nota->dp_total, 2, '.', ',') . "\n", 0, 1, 'R');

        $this->Line(10, $this->GetY(), 270 - 70, $this->GetY());
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
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_selectHeader, $_selectHeader);
$pdf->Output();
