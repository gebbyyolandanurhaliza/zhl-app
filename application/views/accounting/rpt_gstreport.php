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

    function Content($dari, $_tampil,$gstt) {
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(10, 6, 'No', 1, 0, 'C', 1);
        $this->cell(20, 6, 'Date', 1, 0, 'C', 1);
        $this->cell( 25,6, 'Invoice No', 1, 0, 'C', 1);
        $this->cell(25, 6, 'PO No', 1, 0, 'C', 1);
        $this->cell(40, 6, 'Customer / Vendor Name', 1, 0, 'C', 1);
        $this->cell(25, 6, 'Description', 1, 0, 'C', 1);
        $this->cell(12, 6, 'Doc Cur', 1, 0, 'C', 1);
        $this->cell(60, 6, 'Foreign Currency', 1, 0, 'C', 1);
        $this->cell(60, 6, 'Local Currency(USD)', 1, 1, 'C', 1);

        $this->cell(10, 6, '', 1, 0, 'C', 1);
        $this->cell(20, 6, '', 1, 0, 'C', 1);
        $this->cell( 25,6, '', 1, 0, 'C', 1);
        $this->cell(25, 6, '', 1, 0, 'C', 1);
        $this->cell(40, 6, '', 1, 0, 'C', 1);
        $this->cell(25, 6, '', 1, 0, 'C', 1);
        $this->cell(12, 6, '', 1, 0, 'C', 1);
        $this->cell(20, 6, 'Sub Total', 1, 0, 'C', 1);
        $this->cell(20, 6, 'GST', 1, 0, 'C', 1);
        $this->cell(20, 6, 'Total Amount', 1, 0, 'C', 1);
        $this->cell(20, 6, 'Sub Total', 1, 0, 'C', 1);
        $this->cell(20, 6, 'GST', 1, 0, 'C', 1);
        $this->cell(20, 6, 'Total Amount', 1, 1, 'C', 1);

        $this->Line(10, 48, 325 - 40, 48);

        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

            $tgl = $dari;
            $bln = explode('-', $tgl);
            if ($bln[1] == 01) {
                $tbln = 'January';
            } elseif ($bln[1] == 02) {
                $tbln = 'February';
            } elseif ($bln[1] == 03) {
                $tbln = 'March';
            } elseif ($bln[1] == 04) {
                $tbln = 'April';
            } elseif ($bln[1] == 05) {
                $tbln = 'May';
            } elseif ($bln[1] == 06) {
                $tbln = 'June';
            } elseif ($bln[1] == 07) {
                $tbln = 'July';
            } elseif ($bln[1] == 08) {
                $tbln = 'August';
            } elseif ($bln[1] == 09) {
                $tbln = 'September';
            } elseif ($bln[1] == 10) {
                $tbln = 'October';
            } elseif ($bln[1] == 11) {
                $tbln = 'November';
            } elseif ($bln[1] == 12) {
                $tbln = 'December';
            }
        
            $garis1 = 0;
            $saldo = 0;
            $debit2 = 0;
            $subtotlfc = 0;
            $subtotllc = 0;

            $NO = 1;
            $this->setFont('Arial', '', 8);
            $this->setFillColor(255, 255, 255);

        $no=1;
        $no2=1;
        $no3=1;
        $no4=1;

        $subtotalexpusd=0;
        $subtotalgstexpusd=0;
        $subtotalusd=0;
        $subtotalexpsgd=0;
        $subtotalgstexpsgd=0;
        $subtotalsgd=0;

        $subtotalgstusd=0;
        $subtotalgstgstusd=0;
        $subtotal2usd=0;
        $subtotalgstsgd=0;
        $subtotalgstgstsgd=0;
        $subtotal2sgd=0;

        $subtotaloutusd=0;
        $subtotalgstoutusd=0;
        $subtotal3usd=0;
        $subtotaloutsgd=0;
        $subtotalgstoutsgd=0;
        $subtotal3sgd=0;

        $subtotalzerusd=0;
        $subtotalgstzerusd=0;
        $subtotal4usd=0;
        $subtotalzersgd=0;
        $subtotalgstzersgd=0;
        $subtotal4sgd=0;
        $this->cell(277, 6, 'Exempted 0%', 1, 1, 'L', 1);

        foreach ($gstt as $value) {

            if($value->t_gst=='EXP') {
                if($value->t_currency=='USD') {

                    $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate;
                    $gstexp= ($subtotalexp)* $value->t_gst_value_mst;
                    $total1=$subtotalexp+$gstexp;
                    $subtotalexpusd+=$subtotalexp;
                    $subtotalgstexpusd+=$gstexp;
                    $subtotalusd+=$total1;
                }
                else{
                    if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' || $value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP'){
                        $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate;
                    }
                    else{
                        $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    $gstexp= ($subtotalexp)* $value->t_gst_value_mst;
                    $total1=$subtotalexp+$gstexp;
                    $subtotalexpsgd+=$subtotalexp;
                    $subtotalgstexpsgd+=$gstexp;
                    $subtotalsgd+=$total1;
                }




                $this->cell(10, 6, $no, 1, 0, 'C', 1);
                $this->cell(20, 6, $value->t_tanggal, 1, 0, 'C', 1);
                $this->cell( 25,6, $value->t_ref_nomor, 1, 0, 'C', 1);
                $this->cell(25, 6, '', 1, 0, 'C', 1);
                $this->cell(40, 6, $value->t_customer_name, 1, 0, 'C', 1);
                $this->cell(25, 6,  $value->t_desc, 1, 0, 'C', 1);
                $this->cell(12, 6, $value->t_currency, 1, 0, 'C', 1);




                    if($value->t_currency=='USD')
                    {
$this->cell(20, 6, '', 1, 0, 'C', 1);
$this->cell(20, 6, '', 1, 0, 'C', 1);
$this->cell(20, 6, '', 1, 0, 'C', 1);
$this->cell(20, 6, number_format($subtotalexp, 2, ',', '.'), 1, 0, 'C', 1);
$this->cell(20, 6, number_format($gstexp, 2, ',', '.'), 1, 0, 'C', 1);
$this->cell(20, 6, number_format($total1, 2, ',', '.'), 1, 1, 'C', 1);

                    }
                    else{
$this->cell(20, 6, number_format($subtotalexp, 2, ',', '.'), 1, 0, 'C', 1);
$this->cell(20, 6, number_format($gstexp, 2, ',', '.'), 1, 0, 'C', 1);
$this->cell(20, 6, number_format($total1, 2, ',', '.'), 1, 0, 'C', 1);
$this->cell(20, 6, '', 1, 0, 'C', 1);
$this->cell(20, 6, '', 1, 0, 'C', 1);
$this->cell(20, 6, '', 1, 1, 'C', 1);


                    }



                $no++;
            }

        }

        $nsubtotalexpsgd= number_format($subtotalexpsgd, 2, ',', '.');
                                                $nsubtotalgstexpsgd= number_format($subtotalgstexpsgd, 2, ',', '.');
                                                $nsubtotalsgd= number_format($subtotalsgd, 2, ',', '.');
                                                $nsubtotalexpusd= number_format($subtotalexpusd, 2, ',', '.');
                                                $nsubtotalgstexpusd= number_format($subtotalgstexpusd, 2, ',', '.');
                                                $nsubtotalusd= number_format($subtotalusd, 2, ',', '.');

 $this->cell(10, 6, $no, 1, 0, 'C', 1);
                                                $this->cell(20, 6, $nsubtotalexpsgd, 1, 0, 'C', 1);
$this->cell(20, 6,  $nsubtotalgstexpsgd, 1, 0, 'C', 1);
$this->cell(20, 6, $nsubtotalsgd, 1, 0, 'C', 1);
$this->cell(20, 6, $nsubtotalexpusd, 1, 0, 'C', 1);
$this->cell(20, 6,  $nsubtotalgstexpusd, 1, 0, 'C', 1);
$this->cell(20, 6, $nsubtotalusd, 1, 1, 'C', 1);


        /* foreach ($_tampil as $value) {
             if ($value->gst_value == 0) {
                 $nlc = '';
                 $nfc = '';
                 $ntlc = '';
                 $ntfc = '';
             } else {
                 $lc = $value->gst_value;
                 $fc = $value->gst_value * $value->Rate;
                 $saldo += $value->gst_value;
                 $debit2 += $value->gst_value* $value->Rate ;

                 $nlc = number_format($lc, 2, ',', '.');
                 $nfc = 'SGD ' . number_format($fc, 2, ',', '.');
                 $ntlc = number_format($saldo, 2, ',', '.');
                 $ntfc = 'SGD ' . number_format($debit2, 2, ',', '.');

                 $subtotlfc += $saldo;
                 $subtotllc += $debit2;
             }
             if($value->Kredit > 0){
                 $total = $value->Kredit;
             }else{
                 $total = $value->Debet;
             }
         $this->cell(20, 6, $value->DetailID, 0, 0, 'L', 1);
         $this->cell(35, 6, $value->Tanggal, 0, 0, 'C', 1);
         $this->cell(35, 6, $value->Tanggal, 0, 0, 'C', 1);
         $this->cell(25, 6, $value->NoJurnal, 0, 0, 'C', 1);
         $this->cell(65, 6, $value->nama_sup, 0, 0, 'L', 1);
         $this->cell(20, 6, number_format($total,2), 0, 0, 'R', 1);
         $this->cell(20, 6, $nlc, 0, 0, 'C', 1);
         $this->cell(20, 6, $nfc, 0, 0, 'C', 1);
         $this->cell(20, 6, $ntlc, 0, 0, 'C', 1);
         $this->cell(20, 6, $ntfc, 0, 1, 'C', 1);
         $NO ++;
     }
     $this->setFont('Arial', 'B', 8);
     $this->setFillColor(255, 255, 255);

     $this->cell(220, 6, "Grand Total", 0, 0, 'R', 1);
     $this->cell(20, 6, number_format($subtotlfc, 2), 0, 0, 'R', 1);
     $this->cell(20, 6, number_format($subtotllc, 2), 0, 0, 'R', 1);*/

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-25);
        $this->setFont('Arial', 'i', 8);

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
$pdf->Content($dari, $_tampil,$gstt);
$pdf->Output();
