<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(90);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);

        $this->Ln(2);
        $this->setFont('Arial', 'B', 5); 
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);

        // $this->Line(10, 42, 325 - 40, 42);
        $this->cell(5, 6, 'No', "RTL", 0, 'C', 1);
        $this->cell(10, 6, 'Date', "RTL", 0, 'C', 1);
        $this->cell(20,6, 'Invoice No', "RTL", 0, 'C', 1);
        $this->cell(32, 6, 'Customer / Vendor Name', "RTL", 0, 'L', 1);
        $this->cell(40, 6, 'Description', "RTL", 0, 'L', 1);
        $this->cell(9, 6, 'Doc Cur', "RTL", 0, 'C', 1);
        $this->cell(39, 6, 'Foreign Currency', 1, 0, 'C', 1);
        $this->cell(39, 6, 'Local Currency(USD)', 1, 1, 'C', 1);

        $this->cell(5, 6, '', "RBL", 0, 'C', 1);
        $this->cell(10, 6, '', "RBL", 0, 'C', 1);
        $this->cell(20,6, '', "RBL", 0, 'C', 1);
        $this->cell(32, 6, '', "RBL", 0, 'L', 1);
        $this->cell(40, 6, '', "RBL", 0, 'L', 1);
        $this->cell(9, 6, '', "RBL", 0, 'C', 1);
        $this->cell(13, 6, 'Sub Total', 1, 0, 'C', 1);
        $this->cell(13, 6, 'GST', 1, 0, 'C', 1);
        $this->cell(13, 6, 'Total Amount', 1, 0, 'C', 1);
        $this->cell(13, 6, 'Sub Total', 1, 0, 'C', 1);
        $this->cell(13, 6, 'GST', 1, 0, 'C', 1);
        $this->cell(13, 6, 'Total Amount', 1, 1, 'C', 1);

        // $this->Line(10, 48, 325 - 40, 48);

        // $this->Ln(1);
    }

    function Content($dari, $_tampil,$gstt,$gst) {

        if($gst=='HUT'){
            $text3=' Accounts Payable - Details';
            $acc='Vendor';
            $text='Input Tax';
            $text2='Total FOr Output Tax';
        }
        else{
            $text3=' Accounts Receivable - Details';
            $acc='Customer';
            $text='Output Tax';
            $text2='Total For Input Tax';
        }
        

        $NO = 1;
        $this->setFont('Arial', '', 5);
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
            $this->setFont('Arial', '', 5);
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

        $rate_sgd=0;

        //exampted
        $this->cell(194, 6, 'Exempted 0%', 1, 1, 'L', 1);

        foreach ($gstt as $value) {

            if($value->t_gst=='EXP') {
                if($value->t_currency=='USD') {

                    $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate;
                    $gstexp= $value->t_gst_value;
                    $total1=$subtotalexp+$gstexp;
                    $subtotalexpusd+=$subtotalexp;
                    $subtotalgstexpusd+=$gstexp;
                    $subtotalusd+=$total1;

                    $rate_sgd = $value->t_rate_sgd; 
                    $subtotalgstexpsgd+= round($gstexp * $value->t_rate_sgd,2);
                }
                else{
                    if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' || $value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP'){
                        $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    else{
                        $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    $gstexp= $value->t_gst_value;
                    $total1=$subtotalexp+$gstexp;
                    $subtotalexpsgd+=$subtotalexp;
                    $subtotalgstexpsgd+=$gstexp;
                    $subtotalsgd+=$total1;
                }

                $this->cell(5, 6, $no, 1, 0, 'C', 1);
                $this->cell(10, 6, $value->t_tanggal, 1, 0, 'C', 1);
                $this->cell(20,6, $value->t_ref_nomor, 1, 0, 'L', 1);
                $this->cell(32, 6, $value->t_customer_name, 1, 0, 'L', 1);
                $this->cell(40, 6,  $value->t_desc, 1, 0, 'L', 1);
                $this->cell(9, 6, $value->t_currency, 1, 0, 'C', 1);




                    if($value->t_currency=='USD')
                    {
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstexp * $rate_sgd, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($subtotalexp, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstexp, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($total1, 2, ',', '.'), 1, 1, 'R', 1);

                    }
                    else{
                        $this->cell(13, 6, number_format($subtotalexp, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstexp, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($total1, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 1, 'R', 1);
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

        $this->cell(116, 6, 'sub Total for Exempted 0%', 1, 0, 'C', 1);
        $this->cell(13, 6, $nsubtotalexpsgd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstexpsgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotalsgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotalexpusd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstexpusd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotalusd, 1, 1, 'R', 1);

        $this->cell(194, 6, 'GST 7%', 1, 1, 'L', 1);
//gstt
 foreach ($gstt as $value) {

            if($value->t_gst=='GST') {
                if($value->t_currency=='USD') {

                   $subtotalgst = ($value->t_qty * $value->t_price) * $value->t_rate;
                    $gstgst= $value->t_gst_value;
                    $total2=$subtotalgst+$gstgst;
                    $subtotalgstusd+=$subtotalgst;
                    $subtotalgstgstusd+=$gstgst;
                    $subtotal2usd+=$total2;

                    $rate_sgd = $value->t_rate_sgd; 
                    $subtotalgstgstsgd+= round($gstgst * $value->t_rate_sgd,2);
                }
                else{
                    if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' || $value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP'){
                        $subtotalgst= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    else{
                        $subtotalgst= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    $gstgst= $value->t_gst_value;
                    $total2=$subtotalgst+$gstgst;
                    $subtotalgstsgd+=$subtotalgst;
                    $subtotalgstgstsgd+=$gstgst;
                    $subtotal2sgd+=$total2;
                }

                $this->cell(5, 6, $no2, 1, 0, 'C', 1);
                $this->cell(10, 6, $value->t_tanggal, 1, 0, 'C', 1);
                $this->cell(20,6, $value->t_ref_nomor, 1, 0, 'L', 1);
                $this->cell(32, 6, $value->t_customer_name, 1, 0, 'L', 1);
                $this->cell(40, 6,  $value->t_desc, 1, 0, 'L', 1);
                $this->cell(9, 6, $value->t_currency, 1, 0, 'C', 1);

                    if($value->t_currency=='USD')
                    {
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstgst * $rate_sgd, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($subtotalgst, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstgst, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($total2, 2, ',', '.'), 1, 1, 'R', 1);
                    }
                    else{
                        $this->cell(13, 6, number_format($subtotalgst, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($gstgst, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, number_format($total2, 2, ',', '.'), 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 0, 'R', 1);
                        $this->cell(13, 6, '', 1, 1, 'R', 1);
                    }
                $no2++;
            }

        }

        $nsubtotalgstsgd= number_format($subtotalgstsgd, 2, ',', '.');
        $nsubtotalgstgstsgd= number_format($subtotalgstgstsgd, 2, ',', '.');
        $nsubtotal2sgd= number_format($subtotal2sgd, 2, ',', '.');
        $nsubtotalgstusd= number_format($subtotalgstusd, 2, ',', '.');
        $nsubtotalgstgstusd= number_format($subtotalgstgstusd, 2, ',', '.');
        $nsubtotal2usd= number_format($subtotal2usd, 2, ',', '.');

        $this->cell(116, 6, 'sub Total for GST 7%', 1, 0, 'C', 1);
        $this->cell(13, 6, $nsubtotalgstsgd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstgstsgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotal2sgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotalgstusd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstgstusd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotal2usd, 1, 1, 'R', 1);

        //out
        $this->cell(194, 6, 'Out Of Scope 0%', 1, 1, 'L', 1);
//gstt
 foreach ($gstt as $value) {

            if($value->t_gst=='OUT') {
                if($value->t_currency=='USD') {

                   $subtotalout = ($value->t_qty * $value->t_price) * $value->t_rate;
                    $gstout=$value->t_gst_value;
                    $total3=$subtotalout+$gstout;
                    $subtotaloutusd+=$subtotalout;
                    $subtotalgstoutusd+=$gstout;
                    $subtotal3usd+=$total3;

                    $rate_sgd = $value->t_rate_sgd; 
                    $subtotalgstoutsgd+= round($gstout * $value->t_rate_sgd,2);
                }
                 else{
                    if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' || $value->t_jenis_trans=='PIJF' ||$value->t_jenis_trans=='AP'){
                        $subtotalout= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    else{
                        $subtotalout= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }

                    $gstout=$value->t_gst_value;
                    $total3=$subtotalout+$gstout;
                    $subtotaloutsgd+=$subtotalout;
                    $subtotalgstoutsgd+=$gstout;
                    $subtotal3sgd+=$total3;
                }



                $this->cell(5, 6, $no3, 1, 0, 'C', 1);
                $this->cell(10, 6, $value->t_tanggal, 1, 0, 'C', 1);
                $this->cell(20,6, $value->t_ref_nomor, 1, 0, 'L', 1);
                $this->cell(32, 6, $value->t_customer_name, 1, 0, 'L', 1);
                $this->cell(40, 6,  $value->t_desc, 1, 0, 'L', 1);
                $this->cell(9, 6, $value->t_currency, 1, 0, 'C', 1);




                if($value->t_currency=='USD')
                {
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstout * $rate_sgd, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($subtotalout, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstout, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($total3, 2, ',', '.'), 1, 1, 'R', 1);

                }
                else{
                    $this->cell(13, 6, number_format($subtotalout, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstout, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($total3, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 1, 'R', 1);


                }



                $no3++;
            }

        }

        $nsubtotaloutsgd= number_format($subtotaloutsgd, 2, ',', '.');
        $nsubtotalgstoutsgd= number_format($subtotalgstoutsgd, 2, ',', '.');
        $nsubtotal3sgd= number_format($subtotal3sgd, 2, ',', '.');
        $nsubtotaloutusd= number_format($subtotaloutusd, 2, ',', '.');
        $nsubtotalgstoutusd= number_format($subtotalgstoutusd, 2, ',', '.');
        $nsubtotal3usd= number_format($subtotal3usd, 2, ',', '.');

        $this->cell(116, 6, 'sub Total for Out 0%', 1, 0, 'C', 1);
        $this->cell(13, 6, $nsubtotaloutsgd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstoutsgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotal3sgd, 1, 0, 'R', 1);
        $this->cell(13, 6, $nsubtotaloutusd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotalgstoutusd, 1, 0, 'R', 1);
        $this->cell(13, 6,  $nsubtotal3usd, 1, 1, 'R', 1);

        $this->cell(194, 6, 'Zero Rated 0%', 1, 1, 'L', 1);
//gstt
 foreach ($gstt as $value) {

            if($value->t_gst=='ZER') {
                 if($value->t_currency=='USD') {
                    $subtotalzer = ($value->t_qty * $value->t_price) * $value->t_rate;
                    $gstzer=$value->t_gst_value;
                    $total4=$subtotalzer+$gstzer;
                    $subtotalzerusd+=$subtotalzer;
                    $subtotalgstzerusd+=$gstzer;
                    $subtotal4usd+=$total4;

                    $rate_sgd = $value->t_rate_sgd; 
                    $subtotalgstzersgd+= round($gstzer * $value->t_rate_sgd,2);

                }
                else{
                    if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' ||  $value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP' ){
                        $subtotalzer= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }
                    else{
                        $subtotalzer= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
                    }

                    $gstzer=$value->t_gst_value;
                    $total4=$subtotalzer+$gstzer;
                    $subtotalzersgd+=$subtotalzer;
                    $subtotalgstzersgd+=$gstzer;
                    $subtotal4sgd+=$total4;

                }
                $this->cell(5, 6, $no4, 1, 0, 'C', 1);
                $this->cell(10, 6, $value->t_tanggal, 1, 0, 'C', 1);
                $this->cell(20,6, $value->t_ref_nomor, 1, 0, 'L', 1);
                $this->cell(32, 6, $value->t_customer_name, 1, 0, 'L', 1);
                $this->cell(40, 6,  $value->t_desc, 1, 0, 'L', 1);
                $this->cell(9, 6, $value->t_currency, 1, 0, 'C', 1);




                if($value->t_currency=='USD')
                {
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstzer * $rate_sgd, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($subtotalzer, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstzer, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($total4, 2, ',', '.'), 1, 1, 'R', 1);

                }
                else{
                    $this->cell(13, 6, number_format($subtotalzer, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($gstzer, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, number_format($total4, 2, ',', '.'), 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 0, 'R', 1);
                    $this->cell(13, 6, '', 1, 1, 'R', 1);


                }



                $no4++;
            }

        }

           $nsubtotalzersgd= number_format($subtotalzersgd, 2, ',', '.');
            $nsubtotalgstzersgd= number_format($subtotalgstzersgd, 2, ',', '.');
            $nsubtotal4sgd= number_format($subtotal4sgd, 2, ',', '.');
            $nsubtotalzerusd= number_format($subtotalzerusd, 2, ',', '.');
            $nsubtotalgstzerusd= number_format($subtotalgstzerusd, 2, ',', '.');
            $nsubtotal4usd= number_format($subtotal4usd, 2, ',', '.');
            
            $this->cell(116, 6, 'sub Total for Zero 0%', 1, 0, 'C', 1);
            $this->cell(13, 6, $nsubtotalzersgd, 1, 0, 'R', 1);
            $this->cell(13, 6,  $nsubtotalgstzersgd, 1, 0, 'R', 1);
            $this->cell(13, 6, $nsubtotal4sgd, 1, 0, 'R', 1);
            $this->cell(13, 6, $nsubtotalzerusd, 1, 0, 'R', 1);
            $this->cell(13, 6,  $nsubtotalgstzerusd, 1, 0, 'R', 1);
            $this->cell(13, 6,  $nsubtotal4usd, 1, 1, 'R', 1);

 //total tax
                                               

        $totalsum1a=$subtotalexpsgd+ $subtotalgstsgd+ $subtotaloutsgd + $subtotalzersgd ;
        $totalsum2a=$subtotalgstexpsgd+ $subtotalgstgstsgd+ $subtotalgstoutsgd + $subtotalgstzersgd ;
        $totalsum3a=$subtotalsgd+ $subtotal2sgd+ $subtotal3sgd + $subtotal4sgd ;

        $totalsum1b=$subtotalexpusd+ $subtotalgstusd+ $subtotaloutusd + $subtotalzerusd ;
        $totalsum2b=$subtotalgstexpusd+ $subtotalgstgstusd+ $subtotalgstoutusd + $subtotalgstzerusd ;
        $totalsum3b=$subtotalusd+ $subtotal2usd+ $subtotal3usd + $subtotal4usd ;
                                                $this->Ln(3);
$this->cell(116, 6, 'Exempted 0%', 1, 0, 'L', 1);
$this->cell(13, 6, $nsubtotalexpsgd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstexpsgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotalsgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotalexpusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstexpusd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotalusd, 1, 1, 'R', 1);



$this->cell(116, 6, 'GST 7%', 1, 0, 'L', 1);
$this->cell(13, 6, $nsubtotalgstsgd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstgstsgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotal2sgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotalgstusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstgstusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotal2usd, 1, 1, 'R', 1);

$this->cell(116, 6, 'Out 0%', 1, 0, 'L', 1);
$this->cell(13, 6, $nsubtotaloutsgd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstoutsgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotal3sgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotaloutusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstoutusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotal3usd, 1, 1, 'R', 1);                                          

$this->cell(116, 6, 'Zero 0%', 1, 0, 'L', 1);
$this->cell(13, 6, $nsubtotalzersgd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstzersgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotal4sgd, 1, 0, 'R', 1);
$this->cell(13, 6, $nsubtotalzerusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotalgstzerusd, 1, 0, 'R', 1);
$this->cell(13, 6,  $nsubtotal4usd, 1, 1, 'R', 1);

$this->cell(116, 6, $text2, 1, 0, 'L', 1);
$this->cell(13, 6,number_format($totalsum1a, 2, ',', '.'), 1, 0, 'R', 1);
$this->cell(13, 6,  number_format($totalsum2a, 2, ',', '.'), 1, 0, 'R', 1);
$this->cell(13, 6, number_format($totalsum3a, 2, ',', '.'), 1, 0, 'R', 1);
$this->cell(13, 6, number_format($totalsum1b, 2, ',', '.'), 1, 0, 'R', 1);
$this->cell(13, 6,  number_format($totalsum2b, 2, ',', '.'), 1, 0, 'R', 1);
$this->cell(13, 6,  number_format($totalsum3b, 2, ',', '.'), 1, 1, 'R', 1);
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
        $this->setFont('Arial', 'i', 6);

        $this->setFont('Arial', '', 6);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 202, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($dari, $_tampil,$gstt,$gst);
$pdf->Output();
