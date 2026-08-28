<?php

    Class PDF extends TFPDF{
        function Header(){
            $titel = 'Payable Recognition';
            $this->SetX(10);
            $this->Cell(190,25,'',0,0);
            $this->Image('assets/zhl-kop.PNG',3,8,205,33);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(190,243,'',0,0);
            $this->SetFont('Times','B',20);
            $this->SetX(10);
            if($this->gst == 'GST'){
                $this->Cell(0,10,'Tax Invoice',0,0,'C');
            }else{
                $this->Cell(0,10,'Invoice',0,1,'C');
            }
            $this->Ln();
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'To',0,0,'L',0);
            $this->Cell(2,5,':',0,0,'L',0);
            
            $this->SetFont('Times','',10);
            $this->Cell(80,5,$this->namacustomer,0,0,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'Date',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->tanggal,0,1,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Addres',0,0,'L',0);
            $this->Cell(2,5,':',0,0,'L',0);
            
            $this->SetFont('Times','',10);
            $this->MultiCell(45,5,str_replace("<br />", "",$this->address),0,'L');

            $this->SetXY(132,60);
            $this->SetFont('Times','B',10);
            $this->Cell(20,-15,'Invoice No.',0,0,'R',0);
            $this->Cell(2,-15,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,-15, $this->nofaktur,0,1,'L',0);

            $this->SetXY(132,65);
            $this->SetFont('Times','B',10);
            $this->Cell(20,-15,'Invoice Type',0,0,'R',0);
            $this->Cell(2,-15,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(3,-15, $this->jenis_inv,0,0,'L',0);

            $this->SetXY(132,70);
            $this->SetFont('Times','B',10);
            $this->Cell(20,-15,'From',0,0,'R',0);
            $this->Cell(2,-15,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(4,-15,$this->destbarge,0,1,'L',0);

            $this->SetXY(132,75);
            $this->SetFont('Times','B',10);
            $this->Cell(20,-15,'Payment Terms',0,0,'R',0);
            $this->Cell(2,-15,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(3,-15, $this->term,0,0,'L',0);
            $this->Cell(10,-15,' days',0,1,'L',0);


            $this->SetXY(132,70);
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Vessel/Voyage No.',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->voyage,0,1,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(20,-15,'Attn',0,0,'L',0);
            $this->Cell(2,-15,':',0,0,'L',0);

            $this->SetFont('Times','',10);
            $this->Cell(80,-15,'Accounts Dept',0,0,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'ETD',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->etddate,0,1,'L',0);

            $this->SetXY(112,80);
            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'ETA',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->etadate,0,1,'L',0);

            $this->SetXY(112,85);
            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'Shipment Date',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->shipmentdate,0,1,'L',0);

            $this->ln(10);
            $this->SetFont('Times','B',10);
            $this->Cell(50, 5, 'Item', 'BT', 0, 'C');
            $this->Cell(70, 5, 'Description', 'BT', 0, 'C');
            $this->Cell(20, 5, 'Unit', 'BT', 0, 'R');
            $this->Cell(25, 5, 'Unit Price', 'BT', 0, 'R');
            $this->Cell(27, 5, 'Total (USD)', 'BT', 0, 'R');
            $this->ln(5);
        }

        function Footer(){

            $sig = $_GET['signature'];
            $this->SetY(-50);
            $this->setFont('Arial', 'B', 8);
            $this->setFillColor(255, 255, 255);
            $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
            $this->setFont('Arial', 'B', 10);
            $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
            $this->setFont('Arial', 'i', 8);
            $this->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
            $this->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
            $this->Cell(10, 5, 'Swift Code : UOVBSGSG', 0, 1, 'l');
            $this->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');

            $this->Cell(135, 5, 'USD Acct No. 357-907-139-5', 0, 0, 'L');
            $this->Line(145, $this->GetY(), 250 - 50, $this->GetY());
            $this->setFont('Arial', 'B', 11);
            $this->Cell(70, 5, $sig, 0, 1, 'L');

            // $this->setFont('Arial', '', 8);
            // $this->Cell(10, 5, $titel1, 0, 1, 'l');
            // $this->Cell(10, 5, $titel2, 0, 1, 'l');

        }

        function NbLines($w, $txt) {
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
                $l+=$cw[$c];
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
    }

        foreach ($total as $key) {
            $hutang = $key->JUMLAH * $key->rate;
        }
        foreach($get_data_header as $r){
            $rate_sgd =  $r->rate_sgd;
            $namacustomer = $r->namacustomer;
            $address = $r->address;
            $tanggal = date("d F Y",  strtotime($r->tanggal));
            $nofaktur = $r->nofaktur;
            $term = $r->term;
            $voyage = $r->voyage;
            if ($r->shipmentdate=='1970-01-01') {
                $shipmentdate='';
            }else{
                $shipmentdate =  date("d F Y",  strtotime($r->shipmentdate));
            }
            if ($r->etddate=='1970-01-01') {
                $etddate='';
            }else{
                $etddate = date("d F Y",  strtotime($r->etddate));
            }
            if ($r->etadate=='1970-01-01') {
                $etadate='';
            }else{
                $etadate = date("d F Y",  strtotime($r->etadate));
            }
            if($r->jenis_inv=='bar'){
                $jenis_inv = 'Barge Charges';
                }elseif($r->jenis_inv=='fre'){
                $jenis_inv = 'Freight Charges';
                }elseif($r->jenis_inv=='trn'){
                $jenis_inv = 'Transport Charges';
                }elseif($r->jenis_inv=='imp'){
                $jenis_inv = 'Import Charges';
                }elseif($r->jenis_inv=='eim'){
                $jenis_inv = 'Empty Import';
                }elseif($r->jenis_inv=='lem'){
                $jenis_inv = 'Local Empty';
                }       
            if($r->destbarge=='idn'){
                $destbarge = 'Indonesia (PSG) To Singapore';
            }elseif($r->destbarge=='idn2'){
                $destbarge = 'Indonesia (RSUP) To Singapore';
            }elseif($r->destbarge=='sin'){
                $destbarge = 'Singapore To Indonesia (PSG)';
            }elseif($r->destbarge=='sin2'){
                $destbarge = 'Singapore To Indonesia (RSUP)';
            }else{
                $destbarge = '';
            }
        }

    $pdf = new PDF('P','mm','A4');
    foreach($get_data_detail as $l){
        $gst= $l->gst_type;
    }
    $pdf->namacustomer = $namacustomer;
    $pdf->address = $address;
    $pdf->tanggal = $tanggal;
    $pdf->shipmentdate = $shipmentdate;
    $pdf->nofaktur = $nofaktur;
    $pdf->term = $term;
    $pdf->voyage = $voyage;
    $pdf->etddate = $etddate;
    $pdf->etadate = $etadate;
    $pdf->destbarge = $destbarge;
    $pdf->jenis_inv = $jenis_inv;
    $pdf->hutang = $hutang;
    $pdf->rate_sgd = $rate_sgd;
    $pdf->gst = $gst;


    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->ln();
    $totalgst = 0;
    $no = 0;
    $pdf->setFont('Arial', '', 9);
    foreach($get_data_detail as $l){
        $no++;
        if($pdf->GetY() > 235){
                        $pdf->AddPage();
                    }
        $y = $pdf->GetY();
        $pdf->SetXY(10, $y);
        $pdf->MultiCell(50, 5, $no.' '.$l->ItemName, 0, 'L');
        $pdf->SetXY(60, $y);
        $pdf->MultiCell(90, 5, $l->description, 0, 'L');
        $pdf->Ln();
        $max = $pdf->NbLines(80,$l->description);
        $y8 = $pdf->GetY();

        $pdf->SetXY(130,$y+$max);
        $pdf->MultiCell(33, 5, $l->unit, 0, 'C');
        $pdf->ln();

        $pdf->SetXY(145,$y+$max);
        $pdf->MultiCell(30, 5, number_format($l->price,2), 0, 'R');
        $pdf->ln();

        $pdf->SetXY(182,$y+$max);
        $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate,2), 0, 'R');
        $pdf->ln();

        $gst_type= $l->gst_type;
        $totalgst += $l->gst_value;
        

    }
    $pdf->SetY(-80);
    $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());
    if($gst_type == 'GST'){
            $pdf->SetFont('Times','',10);
            $pdf->SetX(120);
            $pdf->Cell(36,4,'Subtotal Amount USD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($hutang,3),0,0,'R');
            $pdf->Ln();
            $pdf->SetX(120);
            $pdf->Cell(36,4,'GST 7%');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($totalgst,3),0,0,'R');
            $pdf->Ln();
            $pdf->SetX(120);
            $pdf->Cell(36,4,'Total Amount USD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($hutang+$totalgst,3),0,0,'R');
            $pdf->Ln();
            $sumgst = $totalgst*$rate_sgd;
            $sumsgd = $hutang * $rate_sgd;
            $sumall = $sumgst + $sumsgd;
            $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());
            $pdf->SetFont('Times','',8);
            $pdf->SetX(11);
            $pdf->Cell(36,4,'GST in SGD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,'Exchange Rate @ '.number_format($rate_sgd,6),0,0,'R');
            $pdf->Ln();
            $pdf->SetX(11);
            $pdf->Cell(36,4,'Total Before GST in SGD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($sumsgd,3),0,0,'R');
            $pdf->Ln();
            $pdf->SetX(11);
            $pdf->Cell(36,4,'GST Amount in SGD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($sumgst,3),0,0,'R');
            $pdf->Ln();
            $pdf->SetX(11);
            $pdf->Cell(36,4,'Total Amount to SGD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($sumall,3),0,0,'R');
            $pdf->Ln(10);
    }else{
        $pdf->SetFont('Times','',10);
            $pdf->SetX(120);
            $pdf->Cell(36,4,'Subtotal Amount USD');
            $pdf->Cell(2,4,':');
            $pdf->Cell(36,4,number_format($hutang,3),0,0,'R');
            $pdf->Ln();
            $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());
            
    }
    
    


    $pdf->Output();
    // $pdf->setData()
?>