<?php
class PDF extends TFPDF {
        function Header(){
            $this->SetX(10);
            $this->Cell(190,25,'',0,0);
            $this->Image(base_url().'assets/pss-blank.png',12,12,180,23);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(190,243,'',0,0);
            $this->SetFont('Times','B',20);
            $this->SetX(10);
            if($this->gst == 'GST'){
                $this->Cell(0,10,'Tax Invoice',0,0,'C');
            }else{
                $this->Cell(0,10,'Commercial Invoice',0,0,'C');
            }
            $this->SetFont('Times','I',9);
            $this->SetXY(155,42);
            $this->Cell(49,4,'Page '.$this->PageNo().'/{nb}',0,0,'R');
            $this->Ln(5);
            $y=  $this->GetY();
            $this->line(11,$y,199,$y);
            $this->Ln(1);
            $this->SetFont('Times','B',11);
            $this->SetX(11);
            $this->Cell(94,4,'Bill To :',0,0,'L');
            $this->SetX(126);
            $this->Cell(20,4,'Date');
            $this->SetFont('Times','',11);
            $this->SetX(152);
            $this->Cell(20,4,': '.$this->docdate);
            $this->Ln();
            $this->SetFont('NotoSans-Regular','',11);
            $this->SetX(11);
            $this->Cell(94,4,$this->custcompany);
            $this->SetFont('Times','B',11);
            $this->SetX(126);
            $this->Cell(20,4,'Invoice No');
            $this->SetFont('Times','',11);
            $this->SetX(152);
            $this->Cell(20,4,': '.$this->inv);
            $this->Ln();
            $y1 = $this->GetY();
            $this->SetFont('NotoSans-Regular','',11);
            $this->SetX(11);
            $this->MultiCell(94,4,str_replace("<br />", "",$this->address),0,'L');
            $this->SetFont('Times','B',11);
            $this->SetXY(126,$y1);
            $this->Cell(20,4,'Due Date');
            $this->SetFont('Times','',11);
            $this->SetXY(152,$y1);
            if($this->termdays !='0'){
                $this->Cell(20,4,': '.$this->duedate);
            } else {
                $this->Cell(20,4,': -');
            }
            $this->SetFont('Times','B',11);
            $this->SetXY(126,$y1 + 4);
            $this->Cell(20,4,'Shipment Date');
            $this->SetFont('Times','',11);
            $this->SetXY(152,$y1 + 4);
            $this->Cell(20,4,': '.$this->shipdate);
            $br = $this->NbLines(94,$this->address);
            $this->Ln($br * 5);
            $y2=  $this->GetY();
            $this->line(11,$y2,199,$y2);
            $this->line(126,$y,126,$y2);
            $this->Ln(1);
            $this->SetFont('Times','B',11);
            $this->SetX(11);
            $this->Cell(20,4,'Vessel / Voy No');
            $this->SetFont('Times','',11);
            $this->SetX(45);
            $this->Cell(20,4,': '.$this->vessel);
            $this->Ln();
                if($this->convessel != '' && strtoupper($this->convessel) != 'X'){
                    $this->SetFont('Times','B',11);
                    $this->SetX(11);
                    $this->Cell(30,4,'Connecting Vessel');
                    $this->SetFont('Times','',11);
                    $this->SetX(45);
                    $this->Cell(20,4,': '.$this->convessel);
                    $this->Ln();
                }
            $this->SetFont('Times','B',11);
            $this->SetX(11);
            $this->Cell(20,4,'Shipment From');
            $this->SetFont('Times','',11);
            $this->SetX(45);
            $this->Cell(20,4,': '.$this->shipment_from);
            $this->SetFont('Times','B',11);
            $this->SetX(80);
            $this->Cell(20,4,'Shipment To');
            $this->SetFont('Times','',11);
            $this->SetX(110);
            $this->Cell(20,4,': '.$this->port_name.', '.$this->country_name);
            $this->Ln();
            $this->SetFont('Times','B',11);
            $this->SetX(11);
            $this->Cell(20,4,'Payment Term');
            $this->SetFont('Times','',11);
            $this->SetX(45);
            $this->MultiCell(150,4,': '.$this->term);
            $this->Ln(5);
            $y3=  $this->GetY();
            $this->line(11,$y3,199,$y3);
            $this->Ln(1);
            $this->SetFont('Times','B',11);
            $this->SetX(11);
            $this->Cell(30,4,"Buyer's Ref",0,0,'C');
            $this->SetX(21);
            $this->Cell(80,4,'Description',0,0,'C');
            $this->SetX(121);
            $this->Cell(34,4,'Quantity',0,0,'C');
            $this->SetX(145);
            $this->Cell(30,4,'Unit Price',0,0,'C');
            $this->SetX(165);
            $this->Cell(44,4,'Amount',0,0,'C');
            $this->Ln();
            $this->SetX(11);
            $this->Cell(30,4,"",0,0,'C');
            $this->SetX(41);
            $this->Cell(80,4,'',0,0,'C');
            $this->SetX(121);
            $this->Cell(34,4,'',0,0,'C');
            $this->SetX(145);
            $this->Cell(30,4,'('.$this->cur.')',0,0,'C');
            $this->SetX(165);
            if ($this->trading == 'CIF' || $this->trading == 'CFR'){
                $this->MultiCell(44,4,'('.$this->trading.' '.$this->port_name.')',0,'C');
            } else {
                $this->MultiCell(44,4,'('.$this->trading.')',0,'C');
//                $pdf->MultiCell(34,4,number_format($r->total,2),0,'R');
            }
            $this->Ln();
            $y4=  $this->GetY();
            $this->line(11,$y4,199,$y4);
            $this->Ln();

            // WATERMARK
            if ($this->status == 3){
                $this->SetFont('ARIAL', 'B', 50);
                $this->SetTextColor(255,192,203);
                $this->RotatedText(52, 190, 'C A N C E L E D', 40);
            }
        }

        function Footer(){
            $this->SetY(-10);
            $this->SetFont('Times','I',9);
            $this->SetX(155);
            $this->Cell(49,4,'Printed By : '.$this->created,0,0,'R');
        }

        // PDF_Rotate (untuk watermark)
        // http://www.fpdf.org/en/script/script2.php
        var $angle=0;

        function Rotate($angle,$x=-1,$y=-1)
        {
            if($x==-1)
                $x=$this->x;
            if($y==-1)
                $y=$this->y;
            if($this->angle!=0)
                $this->_out('Q');
            $this->angle=$angle;
            if($angle!=0)
            {
                $angle*=M_PI/180;
                $c=cos($angle);
                $s=sin($angle);
                $cx=$x*$this->k;
                $cy=($this->h-$y)*$this->k;
                $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
            }
        }

        function _endpage()
        {
            if($this->angle!=0)
            {
                $this->angle=0;
                $this->_out('Q');
            }
            parent::_endpage();
        }
        
        function RotatedText($x,$y,$txt,$angle)
        {
            //Text rotated around its origin
            $this->Rotate($angle,$x,$y);
            $this->Text($x,$y,$txt);
            $this->Rotate(0);
        }

        function RotatedImage($file,$x,$y,$w,$h,$angle)
        {
            //Image rotated around its upper-left corner
            $this->Rotate($angle,$x,$y);
            $this->Image($file,$x,$y,$w,$h);
            $this->Rotate(0);
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
    
    foreach ($_getInv as $r){
        $invno=$r->invno;
        $docdate=date("d-F-Y",  strtotime($r->docdate));
        $shipdate=date("d-F-Y",  strtotime($r->shipdate));
        $duedate=date("d-F-Y",  strtotime($r->duedate));
        $createdby=$r->createdby;
        $remark=htmlspecialchars_decode($r->remark,ENT_QUOTES);
        $paymentto=$r->paymentto;
        $maintotal=$r->maintotal;
        $freight=$r->freight;
        $taxprice=  $r->tax;
        $disc=$r->discount;
        $tax= $taxprice * (($maintotal - $disc) / 100);
        $totaldue=$r->totaldue;
        $dp=$r->advancepayment;
        $balance=$r->totalbalance;
        $cur=$r->currency;
        $cur_name=$r->currency_name;
        $term=htmlspecialchars_decode($r->term,ENT_QUOTES);
        $termdays=$r->termdays;
        $shipment_from=$r->shipment_from;
        $port_name=$r->port_name;
        $country_name=$r->country_name;
        $destination=$r->destination;
        $approvalby=$r->firstname.' '.$r->lastname;
        $jabatan=$r->jabatan;
        $uom=$r->uom_quantity_name;
        $trading=$r->trading_term_name;
        $status = $r->status;
        $gst=$r->gst;
        $rateSGD=$r->rateSGD;
    }
    

    $pdf = new PDF('P','mm','A4');
    $pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);
    $pdf->AddFont('NotoSans-Regular', '', 'NotoSans-Regular.ttf', true);
    
    $pdf->inv=$invno;
    $pdf->custcompany=$customer->customer_company_name;
    $pdf->address=$customer->customer_address;
    $pdf->telephone=$customer->customer_phone;
    $pdf->contact=$customer->customer_contact_name;
    $pdf->docdate=$docdate;
    $pdf->shipdate=$shipdate;
    $pdf->duedate=$duedate;
    $pdf->remark=$remark;
    $pdf->term=$term;
    $pdf->termdays=$termdays;
    $pdf->vessel=$vessel;
    $pdf->convessel=$convessel;
    $pdf->shipment_from=$shipment_from;
    $pdf->port_name=$port_name;
    $pdf->country_name=$country_name;
    $pdf->destination=$destination;
    $pdf->trading=$trading;
    $pdf->status=$status;
    $pdf->cur=$cur;
    $pdf->gst=$gst;
    $pdf->rateSGD=$rateSGD;
    $pdf->created=$createdby;
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',11);
    $shipid='';
    $yawal = $pdf->GetY();
    $cek_no=0;
    $cek_ref=0;
    $qty=0;
    $maxremark=0;

    foreach ($_getInv_Dtl as $r){
        $cek_no++;
        $y = $pdf->GetY();
        if($r->status != 3){
            if($shipid != $r->shipid) {
                $pdf->SetXY(11,$y);
                $pdf->MultiCell(30,4,$r->client_ref_no,0,'C');
                $shipid=$r->shipid;
                
                foreach ($_getInv_Dtl as $x){
                    if($x->shipid == $r->shipid){
                        $cek_ref++;
                    }
                }
            }
                $pdf->SetXY(41,$y);
                $pdf->MultiCell(80,4,$r->productname,0,'L');
                $pdf->SetXY(121,$y);
                $pdf->MultiCell(24,4,number_format($r->qty,0),0,'R');
                $pdf->SetXY(145,$y);
                $pdf->MultiCell(20,4,number_format($r->unitprice,2),0,'R');
                $pdf->SetXY(165,$y);
                $pdf->MultiCell(34,4,number_format($r->total,2),0,'R');
                $pdf->Ln();
                $max = $pdf->NbLines(80,$r->productname);
                $y8 = $pdf->GetY();
                $pdf->SetXY(41,$y + ($max * 4));
                $pdf->MultiCell(80,4,$r->detail_pack_size,0,'L');
                $pdf->SetXY(121,$y  + ($max * 4));
                $pdf->MultiCell(24,4,$r->uom_quantity_name,0,'R');
                $pdf->Ln();
                $qty=$qty + $r->qty;
                
            $y11 = $pdf->GetY();
            if($y11 > 245){
                $pdf->AddPage();
            }
            
            if ($cek_no == $cek_ref) {
                $y2 = $pdf->GetY();
                $pdf->SetFont('Times','B',11);
                $pdf->SetXY(41,$y2);
                $pdf->cell(200,4,'Container / Seal Nos - PO No',0,0,'L');
                $pdf->SetFont('Times','',11);
                $pdf->Ln();
                
                foreach ($_getInv_Cont as $c){
                    if($shipid == $c->shipid) {
                            $y3 = $pdf->GetY();
                            $pdf->SetXY(41,$y3);
                            $pdf->cell(200,5,$c->container.' / '.$c->seal.' - '.$c->ponumber,0,'L');
                            $pdf->Ln();
                    }

                    $y5 = $pdf->GetY() - 5;
                    if($y5 > 245){
                        $pdf->AddPage();
                    }
                }
                
                $pdf->Ln();
                
                $cek_no=0;
                $cek_ref=0;
            }
        }
    }
    
    $pdf->Ln(2);
    
    foreach ($_getInv_Cost as $x){
            $y1 = $pdf->GetY()-2;
            $pdf->SetXY(41,$y1 + ($maxremark * 5));
            $pdf->MultiCell(80,5,htmlspecialchars_decode($x->additional,ENT_QUOTES),0,'L');
            $pdf->SetXY(165,$y1 + ($maxremark * 5));
            $pdf->cell(34,5,number_format($x->price,2),0,0,'R');
            $maxremark = $pdf->NbLines(80,$x->additional);
            $pdf->Ln();
            
            $maintotal = $maintotal + $x->price;
            
            $y5 = $pdf->GetY() - 5;
            if($y5 > 245){
                $pdf->AddPage();
                $maxremark = 0;
            }
    }
    
    foreach ($_getInv_dp as $s){
            $y11 = $pdf->GetY() +($maxremark * 5);

            $pdf->SetXY(41,$y11);
            $pdf->MultiCell(80,5,$s->remarks,0,'L');
            $pdf->SetXY(165,$y11);
            $pdf->cell(34,5,number_format($s->bayar_inv,2),0,0,'R');
            $maxremark = $pdf->NbLines(80,$s->remarks);
            $pdf->Ln();
            
            $y12 = $pdf->GetY() - 5;
            if($y12 > 245){
                $pdf->AddPage();
                $maxremark=0;
            }
    }
    
    if($remark != ''){
        $y2 = $pdf->GetY();
        $pdf->SetXY(41,$y2 + ($maxremark * 5));
        $pdf->MultiCell(180,4,str_replace("<br />", "",$remark));
        $pdf->Ln();
    }
    
    $pdf->Ln(2);
    
    $y6 = $pdf->GetY() + ($maxremark * 5);
    
    if($y6 < $yawal){
        $y6=$yawal;
    }
    
    if($y6 > 245){
        $pdf->AddPage();
        $y6 = $pdf->GetY();
        $maxremark=0;
    }
    
    $pdf->Line(11, $y6, 199, $y6);
    
    $i=0;
    $y10 =  $pdf->GetY();
    $y10a = $y10;

    foreach ($_getInv_Cont_Group as $w){
        $y10 =  $y10 + ($maxremark * 5);
        if ($i == 0){
            $pdf->SetFont('Times','B',11);
            $pdf->SetXY(53,$y10);
            $pdf->Cell(80,4,$w->jml.' x '.$w->container_name,0,0,'L');
            $pdf->SetXY(121,$y10);
            $pdf->Cell(24,4, number_format($qty,0),0,0,'R');
            $pdf->Ln();
            $y10a=$y10;
            $maxremark = 0;
        } else {
            $pdf->SetXY(53,$y10);
            $pdf->Cell(80,4,$w->jml.' x '.$w->container_name,0,0,'L');
            $pdf->Ln();
        }
        
        $i++;
    }
    
    $x=4;
    
    $pdf->SetXY(11,$y10a);
    $pdf->Cell(30,4,'Invoice Total',0,0);
    $pdf->SetX(47);
    $pdf->Cell(10,4,':');
    $pdf->SetX(170);
    $pdf->Cell(12,4,$cur,0,0,'R');
    $pdf->SetX(180);
    $pdf->Cell(20,4,number_format($maintotal,2),0,0,'R');
    $pdf->Ln();
    
    if($disc > 0){
        $pdf->SetXY(11,$y10 + $x);
        $pdf->Cell(30,4,'Discount',0,0);
        $pdf->SetX(47);
        $pdf->Cell(10,4,':');
        $pdf->SetX(170);
        $pdf->Cell(12,4,$cur,0,0,'R');
        $pdf->SetX(180);
        $pdf->Cell(20,4,number_format($disc,2),0,0,'R');
        $pdf->Ln();
        
        $x +=4;
    }
    
    if($freight > 0){
        $pdf->SetXY(11,$y10 + $x);
        $pdf->Cell(30,4,'Ocean Freight',0,0);
        $pdf->SetX(47);
        $pdf->Cell(10,4,':');
        $pdf->SetX(170);
        $pdf->Cell(12,4,$cur,0,0,'R');
        $pdf->SetX(180);
        $pdf->Cell(20,4,number_format($freight,2),0,0,'R');
        $pdf->Ln();
        
         $x +=4;
    }
    
    if($taxprice > 0){
        $pdf->SetXY(11,$y10 + $x);
        $pdf->Cell(30,4,'Tax',0,0);
        $pdf->SetX(47);
        $pdf->Cell(10,4,':');
        $pdf->SetX(170);
        $pdf->Cell(12,4,$cur,0,0,'R');
        $pdf->SetX(180);
        $pdf->Cell(20,4,number_format($taxprice,2),0,0,'R');
        $pdf->Ln();
        
         $x +=4;
    }
    
    if($dp > 0){
        $pdf->SetXY(11,$y10 + $x);
        $pdf->Cell(30,4,'Advance Payment',0,0);
        $pdf->SetX(47);
        $pdf->Cell(10,4,':');
        $pdf->SetX(170);
        $pdf->Cell(12,4,$cur,0,0,'R');
        $pdf->SetX(180);
        $pdf->Cell(20,4,number_format($dp,2),0,0,'R');
        $pdf->Ln();
        
         $x +=4;
    }
    
    $SumTotal = $disc + $freight + $taxprice + $dp;
    
    if($SumTotal > 0){
        $pdf->SetXY(11,$y10 + $x);
        $pdf->Cell(30,4,'Total Balance',0,0);
        $pdf->SetX(47);
        $pdf->Cell(10,4,':');
        $pdf->SetX(170);
        $pdf->Cell(12,4,$cur,0,0,'R');
        $pdf->SetX(180);
        $pdf->Cell(20,4,number_format($balance,2),0,0,'R');
        $pdf->Ln();
        
         $x +=4;
    }
    
    
    $y7=  $pdf->GetY() + ($i * 2);
    $pdf->line(11,$y7,199,$y7);
    $pdf->Ln(0.5);


    $y8=  $pdf->GetY() + ($i * 2);
    $pdf->line(11,$y8,199,$y8);
    $pdf->Ln(10);

    if($gst == 'GST'){
        $pdf->SetFont('Times','',8);
        $pdf->SetX(11);
        $pdf->Cell(36,4,'GST in SGD');
        $pdf->Cell(2,4,':');
        $pdf->Cell(36,4,'Exchange Rate @ '.number_format($rateSGD,6),0,0,'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36,4,'Total Before GST in SGD');
        $pdf->Cell(2,4,':');
        $pdf->Cell(36,4,number_format(($balance - $taxprice) * $rateSGD,2),0,0,'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36,4,'GST Amount in SGD');
        $pdf->Cell(2,4,':');
        $pdf->Cell(36,4,number_format($taxprice * $rateSGD,2),0,0,'R');
        $pdf->Ln();
        $pdf->SetX(11);
        $pdf->Cell(36,4,'Total Amount to SGD');
        $pdf->Cell(2,4,':');
        $pdf->Cell(36,4,number_format($balance * $rateSGD,2),0,0,'R');
        $pdf->Ln(10);
    }


    $pdf->SetFont('Times','B',11);
    $pdf->SetX(11);
    $pdf->Cell(26,4,$cur_name.'s :');
    $pdf->Ln();
    $pdf->SetFont('Times','',11);
    $pdf->SetX(11);
    $pdf->Cell(100,4,trim(ucwords($terbilang)));
    $pdf->Ln(10);
    
    if($paymentto != ''){
        $pdf->SetFont('Times','B',11);
        $pdf->SetX(11);
        $pdf->Cell(50,4,'Please Remit Payment to :');
        $pdf->Ln();
        $pdf->SetFont('Times','',11);
        $pdf->SetX(11);
        $pdf->MultiCell(180,4,str_replace("<br />", "",$paymentto));
        $pdf->Ln();
    }
    
    $pdf->SetY(-55);
    $pdf->SetFont('Times','B',11);
    $pdf->SetX(145);
    $pdf->Cell(50,4,'For Pulau Sambu Singapore Pte Ltd',0,0,'L');
    $pdf->Ln(20);
    $pdf->SetX(145);
    $pdf->Cell(60,4,'','B');
    $pdf->Ln();
    $pdf->SetFont('Times','B',11);
    $pdf->SetX(145);
    $pdf->Cell(50,4,$approvalby,0,0,'L');
    $pdf->SetFont('Times','',11);
    $pdf->Ln();
    $pdf->SetX(145);
    $pdf->Cell(50,4,$jabatan,0,0,'L');


    
    $pdf->Output($invno.'.pdf','I');

?>