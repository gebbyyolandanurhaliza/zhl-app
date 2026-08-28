<?php

class PDF extends TFPDF {
    
    // ✅ TAMBAH PROPERTY INI
    public $is_last_page = false;

    //Page header
    function Header() {
        $Jenis = $_GET['jenis'];
        if ($Jenis == 'CCN') {
            $titel = 'CREDIT NOTE';
        } elseif ($Jenis == 'CDN') {
            $titel = 'DEBIT NOTE';
        }
        $y_axis_initial = 10;
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);

        $this->Ln();
        $this->SetX(10);
        $this->Cell(190,243,'',0,0);
        $this->SetFont('Times','B',20);
        $this->SetX(10);
        $this->Cell(0,10, $titel ,0,1,'C');
    }

    function Content($nota, $get_gst, $detail_print, $detail_sgd, $get_currency) {

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


            $this->SetFont('times', '', 10);
            $this->SetX(10);
            $this->MultiCell(110, 5, $s->customer_name, 0, 1, '');

            $this->SetXY(130, 55);
            $this->SetFont('times', '', 10);
            $this->cell(60, 5, 'Date : ' . date_format(New DateTime($s->tanggal), 'd M Y'), 0, 1, 'l', 1);
            $this->SetXY(10,65);
            $this->MultiCell(110, 5, str_replace("<br />", " ", $s->address), 0, 1, '', 1);
            $this->SetXY(130, 60);
            $this->cell(60, 5, 'Due Date : ' . date_format(New DateTime($s->tanggal_tempo), 'd M Y'), 0, 1, 'l', 1);

            $this->SetXY(130, 65);

            $this->cell(70, 5, 'Currency : ' . $s->currency, 0, 1, 'l', 1);
            $this->SetXY(130, 70);
            $this->cell(70, 5, 'Acct No. : ', 0, 1, 'l', 1);
            $this->SetXY(130, 75);
            $this->cell(70, 5, 'Prepared By : ' . strtoupper($s->prepared_by), 0, 1, 'l', 1);

            $this->SetXY(10, 86);
            $this->cell(60, 5, 'Tel : ' . $s->customer_phone, 0, 0, '', 1);
            $this->cell(60, 5, 'Fax : ' . $s->customer_fax, 0, 0, '', 1);
            $this->cell(70, 5, 'Invoice No. : ' . $s->no_nota, 0, 1, 'l', 1);
            $this->paymentto = $s->paymentto;
        }

        foreach($get_currency as $curr){
            $this->bankName = $curr->bank_name;
            $this->bankSwift = $curr->bank_swift;
            $this->bankAccountNumber = $curr->bank_account_number;
            $this->bankCurrencyId = $curr->bank_currency_id;
            $this->bankAccountNumber2 = $curr->bank_account_number_2;
            $this->bankCurrency2 = $curr->bank_currency_id_2;
        }

        $this->Ln();
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 93, 250 - 50, 93);
        $this->cell(10, 5, 'No.', 0, 0, 'L', 1);
        $this->cell(155, 5, 'Description', 0, 0, 'C', 1);
        $this->cell(0, 5, 'Amount (' . $cur . ')', 0, 1, 'C', 1);
        $this->Line(10, 101, 250 - 50, 101);

        $this->Ln(2);

        $this->setFont('times', '', 10);
        $this->setFillColor(255, 255, 255);

        $this->SetXY(20, 102);
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
                $this->Cell(5, 6, "$col1", 0, 0, 'L', 0);

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
                if(date_format(New DateTime($s->tanggal_tempo), 'Y') > 2024){
                    $jenis = 'GST 9%';
                } else {
                    $jenis = 'GST 8%';
                }
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

            $this->Cell(0, 6, (number_format(abs($total), 2, '.', ',')), 0, 1, 'R');
        }

        $this->cell(160, 6, $jenis, 0, 0, 'R', 1);
        $this->Cell(0, 6, (number_format(abs($totalGST), 2, '.', ',')), 0, 1, 'R');

        foreach ($nota as $v) {
            $this->setFont('times', 'B', 10);

            $total = $v->total;
            $this->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
            $this->Cell(0, 6, (number_format(abs($total), 2, '.', ',')), 0, 1, 'R');
        }
        $this->SetY(-70);
        $this->setFont('Times', '', 8);
        $this->setFont('Times', '', 8);
        $cur = $_GET['cur'];
        if ($cur == 'USD') {
            foreach ($detail_sgd as $ve) {
                $total_before = $ve->Total - $totalGST;
                $gst_before = $ve->rate_sgd * $totalGST;
                $total_amount = ($total_before * $ve->rate_sgd) + $gst_before;
                if ($ve->gst_value !== 0 && $ve->gst_value !== "0") {
                    $this->Cell(36, 4, 'GST in SGD');
                    $this->Cell(8, 4, ':');
                    $this->Cell(36, 4, 'Exchange Rate @ ' . number_format($ve->rate_sgd, 6), 0, 0, 'R');
                    $this->Ln();
                    $this->Cell(36, 4, 'Total Before GST in SGD');
                    $this->Cell(8, 4, ':');
                    $this->Cell(36, 4, number_format($total_before * $ve->rate_sgd, 2), 0, 0, 'R');
                    $this->Ln();
                    $this->Cell(36, 4, 'GST Amount in SGD');
                    $this->Cell(2, 4, ':');
                    $this->Cell(42, 4, number_format($gst_before, 2), 0, 0, 'R');
                    $this->Ln();
                    $this->Cell(36, 4, 'Total Amount to SGD');
                    $this->Cell(2, 4, ':');
                    $this->Cell(42, 4, number_format($total_amount, 2), 0, 0, 'R');
                    $this->Ln(10);
                }
            }
        }
    }

    // ✅ UPDATE METHOD FOOTER
    function Footer() {
        // ✅ CEK: Hanya render footer di halaman terakhir
        if (!$this->is_last_page) {
            return; // Skip footer jika bukan halaman terakhir
        }
        
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-40);
        //nomor halaman
        $kurs = $_GET['cur'];
        $payment_to = $this->paymentto;
        
        
        $tanda_tangan = $_GET['signature'];
        if ($kurs == 'USD') {
            // $titel = 'USD Account : 666002845301';
            // $titel1 = 'For Intermediary Bank : JP Morgan Chase Bank, New York';
            // $titel2 = 'Swift Code : CHASUS33';
        } elseif ($kurs == 'SGD') {
            //$titel = 'SGD Acct No. 357-309-956-5';
            //$titel = 'SGD Account : 617876255001';
            $titel1 = '';
            $titel2 = '';
        }
        if ($payment_to =='') {
            $this->setFont('Arial', 'B', 10);
            $this->setFillColor(255, 255, 255);

            $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
            $this->setFont('Arial', 'B', 10);
            $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
            $this->setFont('Arial', 'i', 8);
            $this->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
            $this->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
            $this->Cell(10, 5, 'Swift Code : UOVBSGSG', 0, 1, 'l');
            $this->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');
            $this->Cell(10, 5, 'USD Acct No. 357-907-139-5', 0, 1, 'l');

            $this->Cell(90, 5, '', 0, 0, 'L');
            $this->Line(135, $this->GetY(), 250 - 50, $this->GetY());
            $this->setFont('Arial', 'B', 11);
            $this->Cell(84, 5, $tanda_tangan, 0, 1, 'R');
        }else{
            $_bankName = $this->bankName;
            $_bankSwift = $this->bankSwift;
            $_bankAccount1 = $this->bankAccountNumber;
            $_bankCurrency = $this->bankCurrencyId;
            $_bankAccount2 = $this->bankAccountNumber2;
            $_bankCurrency2 = $this->bankCurrency2;
            
            $this->setFont('Arial', 'B', 10);
            $this->setFillColor(255, 255, 255);
            $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
            $this->setFont('Arial', 'B', 10);
            $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
            $this->setFont('Arial', 'i', 8);
            $this->Cell(24, 5, 'Beneficiary Name ', 0, 0, 'l');
            $this->Cell(5, 5, ': Zhenghe Logistics Pte Ltd', 0, 1, 'L'); 
            $this->Cell(24, 5, 'Bank Name ', 0, 0, 'l');
            $this->Cell(5, 5, ': ' . $_bankName, 0, 1, 'L'); 
            $this->Cell(26, 5, 'Bank Account No. :  ', 0, 0, 'L');
            $this->Cell(5, 5, $_bankAccount1 . ' (' . $_bankCurrency . ')', 0, 1, 'L'); 
            $this->Cell(26, 5, '', 0, 0, 'L');
            $this->Cell(5, 5, $_bankAccount2 . ' (' . $_bankCurrency2 . ')', 0, 1, 'L');
            $this->Cell(22, 5, 'Swift Code ', 0, 0, 'l');
            $this->Cell(115, 5, ' : ' . $_bankSwift , 0, 1, 'L');
            
            $this->Cell(90, 5, '', 0, 0, 'L');
            $this->Line(135, $this->GetY(), 250 - 50, $this->GetY());
            $this->setFont('Arial', 'B', 11);
            $this->Cell(84, 5, $tanda_tangan, 0, 1, 'R');
        }
    }

}

$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($nota, $get_gst, $detail_print, $detail_sgd, $get_currency);

// ✅ SET FLAG: Ini halaman terakhir
$pdf->is_last_page = true;

$pdf->Output();