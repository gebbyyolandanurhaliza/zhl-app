<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(120);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(120);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
    }

    function Content($_tampil, $_begining, $_begin) {        
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(35, 6, 'Name', 0, 0, 'C', 1);
        $this->cell(80, 6, 'Remark', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Number Reference', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Debit', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Kredit', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Balance', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Created By', 0, 0, 'C', 1);
        $this->cell(40, 6, 'Created Date', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Date', 0, 1, 'C', 1);

        $this->Line(10, 48, 325 - 40, 48);

        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);
        $totalbegining=0;
        $totalcredit= 0;
        $totaldebit = 0;

        if(!empty($_begining)){
            $begin = $_begining->saldo_awal;
        }
        else
        {
            $begin = 0;
        }

        if(!empty($_begin)){
        $bein = $_begin->jumlah1;
        }
        else{
            $bein = 0;
        }
        $totalbegining = $begin + $bein;
        $totalcredit = 0;
        $totaldebit = 0;

        $this->cell(175, 6, "Begininng Balance...", 0, 0, 'C', 1);
        $this->cell(20, 6, number_format($totalbegining, 2), 0, 1, 'R', 1);

        foreach ($_tampil as $key) {
                $totalbegining = $totalbegining + $key->jumlah;
                $totalcredit += $key->credit;
                $totaldebit += $key->debit;

            $this->cell(35, 6, $key->coa_description, 0, 0, 'L', 1);
            $this->cell(80, 6, $key->trans_description, 0, 0, 'L', 1);
            $this->cell(20, 6, $key->no_facture, 0, 0, 'C', 1); 
            $this->cell(20, 6, number_format($key->debit, 2), 0, 0, 'R', 1);
            $this->cell(20, 6, number_format($key->credit, 2), 0, 0, 'R', 1);   
            $this->cell(20, 6, number_format($totalbegining, 2), 0, 0, 'R', 1);
            $this->cell(20, 6, $key->created_by, 0, 0, 'C', 1);
            $this->cell(40, 6, $key->created_date, 0, 0, 'C', 1);
            $this->cell(20, 6, $key->date1, 0, 1, 'C', 1);
            $NO ++;
        }
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $this->cell(135, 6, "Total", 0, 0, 'R', 1);
        $this->cell(20, 6, number_format($totaldebit, 2), 0, 0, 'R', 1);
        $this->cell(20, 6, number_format($totalcredit, 2), 0, 1, 'R', 1);
    }


    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 8);
        $this->Cell(30, 4, 'Kindly settle all overdue amounts soonest possible.', 0, 1, 'L');
        $this->Cell(20, 4, 'We Reserve the right to charge interest at 1.5% per month & to hold future', 0, 1, 'L');
        $this->Cell(20, 4, 'deliveries if amounts due are not settled on time.', 0, 1, 'L');
        $this->Cell(20, 4, 'Thank you for your kind co-operation.', 0, 1, 'L');
        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil, $_begining, $_begin);
$pdf->Output();
