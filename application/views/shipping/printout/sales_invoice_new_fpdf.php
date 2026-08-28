<?php
class PDF extends TFPDF {
        function Header(){
            $this->SetX(10);
            $this->Cell(190,25,'',0,0);
            $this->Image(base_url().'assets/pss-header.png',12,12,180,23);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(190,243,'',0,0);
            $this->SetFont('Times','B',18);
            $this->SetX(10);
            $this->Cell(0,10,'INVOICE',0,0,'L');
            $this->Ln();
            $this->SetFont('Times','',8);
            $this->SetX(10);
            $this->Cell(20,4,'Date',0,0);
            $this->SetX(30);
            $this->Cell(29,4,': '.$this->docdate,0,0);
            $this->SetX(140);
            $this->Cell(20,4,'Shipment Date',0,0);
            $this->SetX(160);
            $this->Cell(29,4,': '.$this->shipdate,0,0);
            $this->Ln();
            $this->SetFont('Times','',8);
            $this->SetX(10);
            $this->Cell(20,4,'Invoice No',0,0);
            $this->SetX(30);
            $this->Cell(29,4,': '.$this->inv,0,0);
            $this->SetX(140);
            $this->Cell(20,4,'SO Number',0,0);
            $this->SetX(160);
            $this->Cell(29,4,': '.$this->sono,0,0);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(20,4,'Customer',0,0);
            $this->SetX(30);
            $this->Cell(29,4,': '.$this->cust,0,0);
            $this->SetX(140);
            $this->Cell(20,4,'Term',0,0);
            $this->SetX(160);
            $this->Cell(29,4,': '.$this->term,0,0);
            $this->Ln(6);
            $this->SetX(11);
            $this->Cell(94,3,'Bill To :',1,0,'C');
            $this->SetX(106);
            $this->Cell(93,3,'Ship / Deliver To :',1,0,'C');
            $this->Ln();
            $this->SetFont('Times','B',10);
            $this->SetX(11);
            $this->Cell(94,5,$this->custcompany);
            $this->SetX(106);
            if($this->whs > 0){
                $this->Cell(93,5,$this->whscompany);
            } else {
                $this->Cell(93,5,$this->custcompany);
            }
            $this->Ln();
            $y = $this->GetY();
            $this->SetFont('DroidSansFallback','',10);
            $this->SetX(11);
            $this->MultiCell(94,4,str_replace("<br />", "",$this->address));
            $this->SetXY(106,$y);
            if($this->whs > 0){
                $this->MultiCell(93,4,str_replace("<br />", "",$this->whsaddress));
            } else {
                $this->MultiCell(93,4,str_replace("<br />", "",$this->address));
            }
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94,3,'Telephone : '.$this->telephone);
            $this->SetX(106);
            if($this->whs > 0){
                $this->Cell(93,3,'Telephone : '.$this->whstelephone);
            } else {
                $this->Cell(93,3,'Telephone : '.$this->telephone);
            }
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94,3,'Contact : '.$this->contact);
            $this->SetX(106);
            if($this->whs > 0){
                $this->Cell(93,3,'Contact : '.$this->whscontact);
            } else {
                $this->Cell(93,3,'Contact : '.$this->contact);
            }
            $this->Ln(5);
            $this->SetFont('Times','B',8);
            $this->SetX(11);
            $this->Cell(10,10,'No','LT',0,'C');
            $this->SetX(21);
            $this->Cell(100,5,'Item Number',1,0,'C');
            $this->SetX(121);
            $this->Cell(24,10,'Quantity','TR',0,'C');
            $this->SetX(145);
            if($this->per1000 == 1){
                $this->Cell(20,5,  'Unit Price','TR',0,'C');
            } else {
                $this->Cell(20,10,  'Unit Price','TR',0,'C');
            }
            $this->SetX(165);
            $this->Cell(34,10,'Extended Price','TR',0,'C');
            $this->SetX(199);
            $this->Cell(1,5,'');
            $this->Ln();
            $this->SetX(11);
            $this->Cell(10,5,'','LBR');
            $this->SetX(21);
            $this->Cell(100,5,'Item Description','BR',0,'C');
            $this->SetX(121);
            $this->Cell(24,5,'','BR');
            $this->SetX(145);
            if($this->per1000 == 1){
                $this->Cell(20,5,'(per 1000)','BR',0,'C');
            } else {
                $this->Cell(20,5,'','BR');
            }
            $this->SetX(165);
            $this->Cell(34,5,'','BR');
            $this->Ln();
        }

        function Footer(){
            $this->SetY(-35);
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->SetX(155);
            $this->Cell(40,4,'Printed By : '.$this->created);
            $this->Ln();
            $this->SetFont('Times','I',8);
            $this->SetX(155);
            $this->Cell(40,4,'Page '.$this->PageNo().'/{nb}');
        }
    }
    
    foreach ($_getInv as $r){
        $invno=$r->invno;
        $sono=$r->sono;
        $custid=$r->custid;
        $docdate=date("d/m/Y",  strtotime($r->docdate));
        $shipdate=date("d/m/Y",  strtotime($r->shipdate));
        $createdby=$r->createdby;
        $via=$r->via;
        $remark=$r->remark;
        $maintotal=$r->maintotal;
        $freight=$r->freight;
        $taxprice=  $r->tax;
        $disc=$r->discount;
        $tax= $taxprice * (($maintotal - $disc) / 100);
        $totaldue=$r->totaldue;
        $cur=$r->currency;
        $whsid=$r->whsid;
        $term=$r->term;
        $curname=$r->currency_name;
        $per1000=$r->per1000;
    }
    

    $pdf = new PDF('P','mm','A4');
    $pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);
    $pdf->inv=$invno;
    $pdf->cust=$custid;
    $pdf->custcompany=$customer->customer_company_name;
    $pdf->address=$customer->customer_address;
    $pdf->telephone=$customer->customer_phone;
    $pdf->contact=$customer->customer_contact_name;
    $pdf->term=$term;
    if ($whsid > 0){
        $pdf->whscompany=$whs->name;
        $pdf->whsaddress=$whs->address;
        $pdf->whstelephone=$whs->telephone;
        $pdf->whscontact=$whs->contact;
        $pdf->whsterm='';
    }
    $pdf->via=$via;
    $pdf->docdate=$docdate;
    $pdf->shipdate=$shipdate;
    $pdf->sono=$sono;
    $pdf->remark=$remark;
    $pdf->whs=$whsid;
    $pdf->per1000=$per1000;
    $pdf->created=$createdby;
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',10);
    $i=1;
    $yawal = $pdf->GetY();
    foreach ($_getInv as $r){
            $npbb = '';
            $pono='';
            if($r->npbbno != ''){
                $npbb = 'NPBB : '.$r->npbbno;
            }
            if($r->pono != ''){
                $pono = 'PONO : '.$r->pono;
            }
            
            $description= $npbb.' '.$pono;
        
            $y = $pdf->GetY();
            $pdf->SetXY(11,$y);
            $pdf->MultiCell(10,5,$i,0,'C');
            $pdf->SetXY(21,$y);
            $pdf->MultiCell(100,5,$r->itemid,0,'L');
            $pdf->SetXY(121,$y);
            if ($r->qty == 0){
                $pdf->MultiCell(24,5,'',0,'R');
            } else {
                $pdf->MultiCell(24,5,number_format($r->qty,2),0,'R');
            }
            $pdf->SetXY(145,$y);
            if ($r->qty == 0){
                $pdf->MultiCell(20,5,'',0,'R');
            } else {
                $pdf->MultiCell(20,5,number_format($r->invoiceprice,4),0,'R');
            }
            $pdf->SetXY(165,$y);
            $pdf->MultiCell(34,5,number_format($r->total,2),0,'R');
            $pdf->Ln();
            $y2 = $pdf->GetY() - 5;
            $pdf->SetXY(21,$y2);
            $pdf->MultiCell(114,5,$r->itemname,0,'L');
            $pdf->Ln();
            
            if($description != ''){
                $y3 = $pdf->GetY() - 5;
                $pdf->SetXY(21,$y3);
                $pdf->MultiCell(94,5,$description);
                $pdf->Ln();
            }
            
            $y5 = $pdf->GetY() - 5;
            $pdf->Line(11, $yawal, 11, $y5);
            $pdf->Line(21, $yawal, 21, $y5);
            $pdf->Line(121, $yawal, 121, $y5);
            $pdf->Line(145, $yawal, 145, $y5);
            $pdf->Line(165, $yawal, 165, $y5);
            $pdf->Line(199, $yawal, 199, $y5);
           
            if($y5 > 250){
                $y6 = $pdf->GetY() - 5;
                $pdf->Line(11, $y6, 199, $y6);
                $pdf->AddPage();
            }
            
            $i++;
    }
    
    $y7 = $pdf->GetY() - 5;
    
    if($y7 < $yawal){
        $y7=$yawal;
    }
    $pdf->Line(11, $y7, 199, $y7);
    $pdf->SetFont('Times','B',8);
    $pdf->SetXY(121,$y7);
    $pdf->cell(54,4,'Sub Total','LB');
    $pdf->Ln();
    $pdf->SetXY(121,$y7 + 4);
    $pdf->cell(54,4,'Discount','LB');
    $pdf->Ln();
    $pdf->SetXY(121,$y7 + 8);
    $pdf->cell(54,4,'Freight','LB');
    $pdf->Ln();
    $pdf->SetXY(121,$y7 + 12);
    $pdf->cell(54,4,'GST '.number_format($taxprice,0).' %','LB');
    $pdf->Ln();
    $pdf->SetXY(121,$y7 + 16);
    $pdf->cell(54,4,'Grand Total','LB');
    $pdf->Ln();
    
    $pdf->SetFont('Times','',8);
    $pdf->SetXY(165,$y7);
    $pdf->cell(10,4,($maintotal > 0 ? $cur : ''),'LB',0,'L');
    $pdf->SetXY(175, $y7);
    $pdf->cell(24,4,($maintotal > 0 ? number_format($maintotal,2) : ''),'BR',0,'R');
    $pdf->Ln();
    $pdf->SetXY(165,$y7 + 4);
    $pdf->cell(10,4,($disc > 0 ? $cur : ''),'LB',0,'L');
    $pdf->SetXY(175, $y7 + 4);
    $pdf->cell(24,4,($disc > 0 ? number_format($disc,2) : ''),'BR',0,'R');
    $pdf->Ln();
    $pdf->SetXY(165,$y7 + 8);
    $pdf->cell(10,4,($freight > 0 ? $cur : ''),'LB',0,'L');
    $pdf->SetXY(175, $y7 + 8);
    $pdf->cell(24,4,($freight > 0 ? number_format($freight,2) : ''),'BR',0,'R');
    $pdf->Ln();
    $pdf->SetXY(165,$y7 + 12);
    $pdf->cell(10,4,($tax > 0 ? $cur : ''),'LB',0,'L');
    $pdf->SetXY(175, $y7 + 12);
    $pdf->cell(24,4,($tax > 0 ? number_format($tax,2) : ''),'BR',0,'R');
    $pdf->Ln();
    $pdf->SetXY(165,$y7 + 16);
    $pdf->cell(10,4,($totaldue > 0 ? $cur : ''),'LB',0,'L');
    $pdf->SetXY(175, $y7 + 16);
    $pdf->cell(24,4,($totaldue > 0 ? number_format($totaldue,2) : ''),'BR',0,'R');
    $pdf->Ln();
    
    if($via != ''){
        $pdf->SetFont('Times','B',10);
        $pdf->SetX(11);
        $pdf->Cell(26,4,'Ship Via : ');
        $pdf->SetFont('Times','',10);
        $pdf->SetX(37);
        $pdf->Cell(34,4,$via);
        $pdf->Ln();
    }
    
//    if($customer->customer_term != ''){
//        $pdf->SetFont('Times','B',10);
//        $pdf->SetX(11);
//        $pdf->Cell(26,4,'Payment Term : ');
//        $pdf->SetFont('Times','',10);
//        $pdf->SetX(37);
//        $pdf->Cell(34,4,$customer->customer_term);
//        $pdf->Ln();
//    }
    
    if($remark != ''){
        $pdf->SetFont('Times','B',10);
        $pdf->SetX(11);
        $pdf->Cell(34,4,'Remarks :');
        $pdf->Ln();
        $pdf->SetFont('Times','',8);
        $pdf->SetX(11);
        $pdf->MultiCell(180,5,str_replace("<br />", "",$remark));
        $pdf->Ln();
    }
    
    $pdf->Ln(10);
    $pdf->SetFont('Times','B',10);
    $pdf->SetX(11);
    $pdf->Cell(26,4,$curname);
    $pdf->SetX(37);
    $pdf->Cell(34,4,' : '.  ucwords($terbilang));
    $pdf->Ln();
    
    
    
    $pdf->SetY(-29);
    $pdf->SetX(155);
    $pdf->Cell(40,4,'','B');
    $pdf->Ln();
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(155);
    $pdf->Cell(40,4,'Approve By',0,0,'C');
    $pdf->SetFont('Times','',8);

    $pdf->Output('PO-'.date("mdy").'.pdf','I');

?>