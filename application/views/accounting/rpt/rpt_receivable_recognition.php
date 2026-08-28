<?php

class PDF extends FPDF
{

    //Page header
    function Header()
    {
        $titel = 'Invoice';
        $this->SetX(10);
        $this->Cell(190, 25, '', 0, 0);
        $this->Image('assets/zhlkop.PNG', 11, 3, 200, 35);
        $this->Line(10, 35, 250 - 50, 35);
        $this->Ln();
        $this->SetX(10);
        $this->Cell(190, 243, '', 0, 0);
        $this->SetFont('Times', 'B', 20);
        $this->SetX(10);
        $this->Cell(0, 10, 'Tax Invoice', 0, 1, 'C');


        $this->Ln();
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'To', 0, 0, 'L', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);

        $this->SetFont('Times', '', 10);
        $this->Cell(80, 5, $this->namacustomer, 0, 0, 'L', 0);


        $this->SetFont('Times', 'B', 10);
        $this->Cell(40, 5, 'Date', 0, 0, 'R', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);
        $this->SetFont('Times', '', 10);
        $this->Cell(40, 5, date("d F Y",  strtotime($this->tanggal_invoice)), 0, 1, 'L', 0);

        $this->SetXY(10, 61);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Address', 0, 0, 'L', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);

        // $this->SetXY(32, 61);
        $this->SetFont('Times', '', 10);
        $this->MultiCell(75, 5, str_replace("<br />", "", $this->address), 0, 'L');

        $this->SetXY(132, 61);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Invoice No.', 0, 0, 'R', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);
        $this->SetFont('Times', '', 10);
        $this->Cell(40, 5, $this->nofaktur, 0, 1, 'L', 0);

        $this->SetXY(132, 65);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Invoice Type', 0, 0, 'R', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);
        $this->SetFont('Times', '', 10);
        $this->Cell(40, 5, $this->jenis_inv, 0, 1, 'L', 0);

        $this->SetXY(132, 70);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Payment Terms', 0, 0, 'R', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);
        $this->SetFont('Times', '', 10);

        $this->Cell(3, 5, $this->term, 0, 0, 'L', 0);
        // $this->Cell(10, 5, ' days', 0, 1, 'L', 0);

        // if($this->kode_sup=='E00087' || $this->kode_sup=='K00017'){
        // $this->Cell(3, 5, 'COD', 0, 0, 'L', 0);
        // $this->Cell(10, 5, '', 0, 1, 'L', 0);
        // }else{
        // }


        $this->SetXY(10, 85);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Attn', 0, 0, 'L', 0);
        $this->Cell(2, 5, ':', 0, 0, 'L', 0);

        $this->SetFont('Times', '', 10);
        $this->Cell(80, 5, 'Accounts Dept', 0, 0, 'L', 0);

        if ($this->jenis_inv == 'bar') {
            $this->SetXY(132, 75);
            $this->SetFont('Times', 'B', 10);
            $this->Cell(20, 5, 'Vessel/Voyage No.', 0, 0, 'R', 0);
            $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            $this->SetFont('Times', '', 10);
            $this->Cell(40, 5, $this->voyage, 0, 1, 'L', 0);

            if ($this->etddate == '1970-01-01') {
            } else {
                $this->SetXY(112, 80);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETD', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etddate)), 0, 1, 'L', 0);
            }

            if ($this->etadate == Null || $this->etadate == '1970-01-01') {
            } else {
                $this->SetXY(112, 85);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETA', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etadate)), 0, 1, 'L', 0);
            }

            if ($this->shipmentdate == Null || $this->shipmentdate == '1970-01-01') {
            } else {
                $this->SetXY(112, 90);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'Shipment Date', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->shipmentdate)), 0, 1, 'L', 0);
            }
        } elseif ($this->jenis_inv == 'fre') {
            // $this->SetXY(132, 90);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(20, 5, 'B/L No.', 0, 0, 'L', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->blno, 0, 1, 'L', 0);

            if ($this->etadate == Null || $this->etadate == '1970-01-01') {
            } else {
                $this->SetXY(112, 80);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETA', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etadate)), 0, 1, 'L', 0);
            }

            // $this->SetXY(112, 85);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(40, 5, 'CNTR No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->ctrno, 0, 1, 'L', 0);
        } elseif ($this->jenis_inv == 'imp') {
            // $this->SetXY(132, 95);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(20, 5, 'B/L No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->blno, 0, 1, 'L', 0);

            if ($this->etddate == Null || $this->etddate == '1970-01-01') {
            } else {
                $this->SetXY(112, 75);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETD', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etddate)), 0, 1, 'L', 0);
            }

            if ($this->etadate == Null || $this->etadate == '1970-01-01') {
            } else {
                $this->SetXY(112, 80);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETA', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etadate)), 0, 1, 'L', 0);
            }

            if ($this->shipmentdate == Null || $this->shipmentdate == '1970-01-01') {
            } else {
                $this->SetXY(112, 85);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'Shipment Date', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->shipmentdate)), 0, 1, 'L', 0);
            }

            // $this->SetXY(112, 90);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(40, 5, 'CNTR No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->ctrno, 0, 1, 'L', 0);
        } elseif ($this->jenis_inv == 'trn') {
            $this->SetXY(132, 75);
            $this->SetFont('Times', 'B', 10);
            $this->Cell(20, 5, 'Barge/Voyage No.', 0, 0, 'R', 0);
            $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            $this->SetFont('Times', '', 10);
            $this->Cell(40, 5, $this->voyage, 0, 1, 'L', 0);

            // $this->SetXY(132, 80);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(20, 5, 'B/L No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->blno, 0, 1, 'L', 0);
        } elseif ($this->jenis_inv == 'det') {
            // $this->SetXY(132, 85);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(20, 5, 'B/L No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->blno, 0, 1, 'L', 0);

            if ($this->etadate == Null || $this->etadate == '1970-01-01') {
            } else {
                $this->SetXY(112, 75);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETA', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etadate)), 0, 1, 'L', 0);
            }

            // $this->SetXY(112, 80);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(40, 5, 'CNTR No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->ctrno, 0, 1, 'L', 0);
        } else {
            // $this->SetXY(132, 85);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(20, 5, 'B/L No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->blno, 0, 1, 'L', 0);

            if ($this->etadate == Null || $this->etadate == '1970-01-01') {
            } else {
                $this->SetXY(112, 75);
                $this->SetFont('Times', 'B', 10);
                $this->Cell(40, 5, 'ETA', 0, 0, 'R', 0);
                $this->Cell(2, 5, ':', 0, 0, 'L', 0);
                $this->SetFont('Times', '', 10);
                $this->Cell(40, 5, date("d F Y",  strtotime($this->etadate)), 0, 1, 'L', 0);
            }

            // $this->SetXY(112, 80);
            // $this->SetFont('Times', 'B', 10);
            // $this->Cell(40, 5, 'CNTR No.', 0, 0, 'R', 0);
            // $this->Cell(2, 5, ':', 0, 0, 'L', 0);
            // $this->SetFont('Times', '', 10);
            // $this->Cell(40, 5, $this->ctrno, 0, 1, 'L', 0);
        }


        $this->ln(10);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(20, 5, 'Items.', 'BT', 0, 'C');
        $this->Cell(110, 5, 'Description', 'BT', 0, 'C');
        $this->Cell(15, 5, 'Quantity', 'BT', 0, 'C');
        $this->Cell(20, 5, 'Price', 'BT', 0, 'C');
        $this->Cell(25, 5, 'Amount (' . $this->currency . ')', 'BT', 0, 'R');
        $this->ln();
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }



    function Footer()
    {
        //atur posisi 1.5 cm dari bawah

    }
}

foreach ($nota as $s) {
    $str = $s->address;
    $alamat = explode("<br />", $str);

    if ($s->jenis_inv == 'bar') {
        $jenis_inv = 'Barge Charges';
    } elseif ($s->jenis_inv == 'fre') {
        $jenis_inv = 'Freight Charges';
    } elseif ($s->jenis_inv == 'trn') {
        $jenis_inv = 'Transport Charges';
    } elseif ($s->jenis_inv == 'imp') {
        $jenis_inv = 'Import Charges';
    } elseif ($s->jenis_inv == 'det') {
        $jenis_inv = 'Detention';
    } elseif ($s->jenis_inv == 'oth') {
        $jenis_inv = 'Other';
    } elseif ($s->jenis_inv == 'casa') {
        $jenis_inv = 'Cash Sales';
    }

    $namacustomer = $s->namacustomer;
    $prepared_by = $s->prepared_by;
    $tanggal_invoice = $s->tanggal_invoice;
    $address = str_replace("<br />", "", $s->address);
    $nofaktur = $s->nofaktur;

    if ($s->term == '0') {
        $term_val = 'COD';
    } else {
        $term_val = $s->term . ' days';
    }
    $term = $term_val;

    // $term = $s->term;
    $etddate = $s->etddate;
    $etadate = $s->etadate;
    $shipmentdate = $s->shipmentdate;
    $blno = $s->blno;
    $ctrno = $s->ctrno;
    $kode_sup = $s->kode_sup;
    $paymentto = $s->paymentto;
}

// var_dump($paymentto);
// die;

foreach($get_currency as $curr){
    $_bankName = $curr->bank_name;
    $_bankSwift = $curr->bank_swift;
    $_bankAccount1 = $curr->bank_account_number;
    $_bankCurrency = $curr->bank_currency_id;
    $_bankAccount2 = $curr->bank_account_number_2;
    $_bankCurrency2 = $curr->bank_currency_id_2;
}

$totalgst = 0;
if (!empty($get_data_detail)) {
    foreach ($get_data_detail as $key) {
        $totalgst += $key->gst_value;
    }
}



$currency = $_GET['cur'];


$pdf = new PDF();

$pdf->namacustomer = $namacustomer;
$pdf->jenis_inv = $jenis_inv;
$pdf->tanggal_invoice = $tanggal_invoice;
$pdf->address = $address;
$pdf->nofaktur = $nofaktur;
$pdf->term = $term;
$pdf->etddate = $etddate;
$pdf->prepared_by = $prepared_by;
$pdf->etadate = $etadate;
$pdf->shipmentdate = $shipmentdate;
$pdf->blno = $blno;
$pdf->ctrno = $ctrno;
$pdf->he = $judul;
$pdf->currency = $currency;
$pdf->kode_sup = $kode_sup;
$pdf->paymentto = $paymentto;

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->setFont('Times', '', 10);
$NO = 1;
$w = 90;
$h = 5;
$total1 = 0;
$totalgst = 0;
if (!empty($get_data_detail)) {
    foreach ($get_data_detail as $key) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->cell(20, 6, $NO++, 0, 0, 'C');
        $pdf->SetXY($x + 93, $y);
        $pdf->MultiCell(47, 6, number_format($key->Qty, 2), 0, 'R');
        $pdf->SetXY($x + 115, $y);
        $pdf->MultiCell(47, 6, number_format($key->Harga, 2), 0, 'R');
        $pdf->SetXY($x + 160, $y);
        if ($key->Qty * $key->Harga == 0) {
            $col3 = $key->Harga;
        } else {
            $col3 = $key->Qty * $key->Harga;
        }
        $pdf->MultiCell(30, 6, number_format($col3, 2), 0, 'R');
        $col2 = $key->Items . "   ";
        $pdf->SetXY($x + 20, $y);
        $pdf->MultiCell($w, 6, $col2, 0, 'L');

        $total1 += $col3;
        $totalgst += $key->gst_value;

        if ($pdf->GetY() > 240) {
            $pdf->AddPage();
        }
    }
}



foreach ($nota as $v) {

    if ($totalgst == 0) {
        $pdf->SetY(-85);
    } else {
        $pdf->SetY(-102);
    }

    //buat garis horizontal
    $pdf->Line(10, $pdf->GetY() - 1, 250 - 50, $pdf->GetY() - 1);
    $j = $pdf->GetY();
    if ($totalgst == 0) {
        $pdf->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
        $pdf->Cell(0, 6, number_format($v->piutang, 2, '.', ','), 0, 1, 'R', 1);
        $pdf->Ln(10);
        $pdf->Line(10, $pdf->GetY() - 5, 250 - 50, $pdf->GetY() - 5);
    } else {
        $pdf->cell(160, 6, 'SUB TOTAL', 0, 0, 'R', 1);
        $pdf->Cell(0, 6, number_format($total1, 2, '.', ','), 0, 1, 'R', 1);

        if($nofaktur == "ZH0426/05/2024"){
            $pdf->cell(160, 6, 'GST 8%', 0, 0, 'R', 1);
            $pdf->Cell(0, 6, number_format($totalgst, 2, '.', ','), 0, 1, 'R', 1);
        }else{
            $pdf->cell(160, 6, 'GST 9%', 0, 0, 'R', 1);
            $pdf->Cell(0, 6, number_format($totalgst, 2, '.', ','), 0, 1, 'R', 1);
        }
        // $pdf->cell(160, 6, 'GST 9%', 0, 0, 'R', 1);
        // $pdf->Cell(0, 6, number_format($totalgst, 2, '.', ','), 0, 1, 'R', 1);

        $putangfinal = $total1 + $totalgst;

        $pdf->cell(160, 6, 'TOTAL', 0, 0, 'R', 1);
        $pdf->Cell(0, 6, number_format($putangfinal, 2, '.', ','), 0, 1, 'R', 1);

        $sumgst = $totalgst * $v->rate_sgd;
        $sumsgd = $total1 * $v->rate_sgd;
        $sumall = $sumgst + $sumsgd;
        $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());
        $pdf->SetFont('Times', '', 8);
        $pdf->SetX(11);
        $pdf->Cell(36, 4, 'GST in SGD');
        $pdf->Cell(2, 4, ':');
        $pdf->Cell(36, 4, 'Exchange Rate @ ' . number_format($v->rate_sgd, 6), 0, 0, 'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36, 4, 'Total Before GST in SGD');
        $pdf->Cell(2, 4, ':');
        $pdf->Cell(36, 4, number_format($sumsgd, 3), 0, 0, 'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36, 4, 'GST Amount in SGD');
        $pdf->Cell(2, 4, ':');
        $pdf->Cell(36, 4, number_format($sumgst, 3), 0, 0, 'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36, 4, 'Total Amount to SGD');
        $pdf->Cell(2, 4, ':');
        $pdf->Cell(36, 4, number_format($sumall, 3), 0, 0, 'R');
        $pdf->Ln(10);
    }

    $sig = $_GET['signature'];
    if ($totalgst == 0) {
        $pdf->SetY(230);
    } else {
        $pdf->SetY(230);
    }
    $pdf->setFont('Arial', 'B', 8);
    $pdf->setFillColor(255, 255, 255);
    $pdf->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
    $pdf->setFont('Arial', 'B', 10);
    $pdf->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
    $pdf->setFont('Arial', 'i', 8);
        if ($paymentto =='') {
            

            // $pdf->Cell(24, 5, 'Beneficiary Name ', 0, 0, 'l');
            // $pdf->Cell(5, 5, ': Zhenghe Logistics Pte Ltd', 0, 1, 'L'); 
            // $pdf->Cell(24, 5, 'Bank Name ', 0, 0, 'l');
            // $pdf->Cell(5, 5, ': OCBC', 0, 1, 'L'); 
            // $pdf->Cell(26, 5, 'Bank Account No. : ', 0, 0, 'L');
            // $pdf->Cell(5, 5, $_bankAccount1 . ' (' . $_bankCurrency . ')', 0, 1, 'L'); 
            // $pdf->Cell(26, 5, '', 0, 0, 'L');
            // $pdf->Cell(5, 5, $_bankAccount2 . ' (' . $_bankCurrency2 . ')', 0, 1, 'L');
            // $pdf->Cell(22, 5, 'Swift Code ', 0, 0, 'l');
            // $pdf->Cell(115, 5, ' : ' . $_bankSwift , 0, 0, 'L');

            // Old
            $pdf->Cell(24, 5, 'Beneficiary Name ', 0, 0, 'l');
            $pdf->Cell(5, 5, ': Zhenghe Logistics Pte Ltd', 0, 1, 'L'); 
            $pdf->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
            $pdf->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
            $pdf->Cell(10, 5, 'Swift Code : UOVBSGSG', 0, 1, 'l');
            $pdf->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');
            $pdf->Cell(135, 5, 'USD Acct No. 357-907-139-5', 0, 0, 'L');

            $pdf->Line(145, $pdf->GetY(), 250 - 50, $pdf->GetY());
            $pdf->setFont('Arial', 'B', 11);
            $pdf->Cell(70, 5,  $sig, 0, 1, 'L');
             $pdf->setFont('', 'I', 7);
             $pdf->multicell(120, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request.', 0, 1, 'L');
        }else{
            $_bankName = $curr->bank_name;
            $_bankSwift = $curr->bank_swift;
            $_bankAccount1 = $curr->bank_account_number;
            $_bankCurrency = $curr->bank_currency_id;
            $_bankAccount2 = $curr->bank_account_number_2;
            $_bankCurrency2 = $curr->bank_currency_id_2;
            
            $pdf->Cell(24, 5, 'Beneficiary Name ', 0, 0, 'l');
            $pdf->Cell(5, 5, ': Zhenghe Logistics Pte Ltd', 0, 1, 'L'); 
            $pdf->Cell(24, 5, 'Bank Name ', 0, 0, 'l');
            $pdf->Cell(5, 5, ': ' . $_bankName, 0, 1, 'L'); 
            $pdf->Cell(26, 5, 'Bank Account No. :  ', 0, 0, 'L');
            $pdf->Cell(5, 5, $_bankAccount1 . ' (' . $_bankCurrency . ')', 0, 1, 'L'); 
            $pdf->Cell(26, 5, '', 0, 0, 'L');
            $pdf->Cell(5, 5, $_bankAccount2 . ' (' . $_bankCurrency2 . ')', 0, 1, 'L');
            $pdf->Cell(22, 5, 'Swift Code ', 0, 0, 'l');
            $pdf->Cell(115, 5, ' : ' . $_bankSwift , 0, 0, 'L');
            
            $pdf->Line(145, $pdf->GetY(), 250 - 50, $pdf->GetY());
            $pdf->setFont('Arial', 'B', 11);
            $pdf->Cell(70, 5,  $sig, 0, 1, 'L');
            $pdf->setFont('', 'I', 7);
            $pdf->Cell(22, 5, 'Please select the "OUR" payment method for SWIFT transfers.', 0, 0, 'l');
            $pdf->SetY(265);
            $pdf->multicell(120, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request.', 0, 1, 'L');
        }

        if ($prepared_by <> ''){
            $pdf->SetY(270);
            $pdf->setFont('Arial', 'i', 8);
            $pdf->Cell(190, 5, 'Prepared By : ' . ucwords(strtolower($prepared_by)), 0, 1, 'R');
        }
    }
    

$pdf->Output();
