<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Receivable Invoice';
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

    function Content($hdr) {
        $this->Ln(5);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $str = $hdr->customer_address;
        $alamat = explode("<br />", $str);
        if(strchr($hdr->customer_address,'<br />',true)){
            $alamat1 = $alamat[1];
        }else{
            $alamat1 = '';
        }

        $this->cell(15, 6, 'To : ', 0, 0, 'L', 1);
        $this->cell(60, 6, $hdr->customer_company_name, 0, 0, 'L', 1);

        $this->cell(65, 6, 'Date : ', 0, 0, 'R', 1);
        $this->cell(0, 6, date_format(New DateTime($hdr->dp_date_inv), 'd M Y'), 0, 1, '', 1);

        $this->cell(15, 6, 'Address : ', 0, 0, '', 1);
        $this->cell(80, 6, $alamat[0], 0, 0, 'L', 1);

        $this->cell(45, 6, 'Debit Note Number : ', 0, 0, 'R', 1);
        $this->cell(0, 6, $hdr->no_reff, 0, 1, 'L', 1);

        $this->cell(15, 6, '', 0, 0, '', 1);
        $this->cell(60, 6, $alamat1, 0, 0, 'L', 1);

        $this->cell(65, 6, 'Due Date : ', 0, 0, 'R', 1);
        $this->cell(0, 6, date_format(New DateTime($hdr->dp_due_date), 'd M Y'), 0, 1, 'L', 1);

        $this->cell(15, 6, 'Attn :', 0, 0, '', 1);
        $this->cell(110, 6, $hdr->customer_contact_name, 0, 0, 'L', 1);

        $this->cell(15, 6, 'Payment Term : ', 0, 0, 'R', 1);
        $this->cell(0, 6, $hdr->dp_term, 0, 1, 'L', 1);
        

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 90, 260 - 50, 90);
        $this->cell(30, 6, 'Ref', 0, 0, 'C', 1);
        $this->cell(110, 6, 'Description', 0, 0, 'C', 1);
        $this->cell(55, 6, 'Amount (USD)', 0, 1, 'C', 1);
        $this->Line(10, 98, 260 - 50, 98);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 10);
        $this->setFillColor(255, 255, 255);

        $this->Ln(2);

        $this->cell(30, 6, $hdr->no_reff, 0, 0, 'C', 1);
        $this->cell(100, 6, $hdr->trans_description, 0, 0, 'L', 1);
        
        $this->Cell(55, 6, number_format($hdr->dp_total,2), 0, 1, 'R');
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
$pdf->Content($_selectHeader);
$pdf->Output();
