<?php
class PDF extends FPDF {
        function Header(){
            $this->SetX(10);
            $this->Cell(190,25,'',1,0);
            $this->Image(base_url().'assets/pss-header.png',12,12,180,23);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(190,243,'',1,0);
            $this->SetFont('Times','B',18);
            $this->SetX(10);
            $this->Cell(0,10,'INVOICE',0,0,'R');
            $this->Ln();
            $this->SetFont('Times','',8);
            $this->SetX(140);
            $this->Cell(30,5,'Invoice No.',1,0);
            $this->SetX(170);
            $this->Cell(29,5,$this->inv,1,0);
            $this->Ln();
            $this->SetX(140);
            $this->Cell(30,5,'Customer No.',1,0);
            $this->SetX(170);
            $this->Cell(29,5,$this->cust,1,0);
            $this->Ln(10);
            $this->SetX(11);
            $this->Cell(94,3,'Bill To :',1,0,'C');
            $this->SetX(106);
            $this->Cell(93,3,'Ship To :',1,0,'C');
            $this->Ln();
            $this->SetFont('Times','B',10);
            $this->SetX(11);
            $this->Cell(94,5,$this->custcompany);
            $this->SetX(106);
            $this->Cell(93,5,$this->custcompany);
            $this->Ln();
            $y = $this->GetY();
            $this->SetFont('Times','',10);
            $this->SetX(11);
            $this->MultiCell(94,4,str_replace("<br />", "",$this->address));
            $this->SetXY(106,$y);
            $this->MultiCell(93,4,str_replace("<br />", "",$this->address));
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94,3,'Telephone : '.$this->telephone);
            $this->SetX(106);
            $this->Cell(93,3,'Telephone : '.$this->telephone);
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94,3,'Contact : '.$this->contact);
            $this->SetX(106);
            $this->Cell(93,3,'Contact : '.$this->contact);
            $this->Ln(5);
            $this->SetFont('Times','B',8);
            $this->SetX(11);
            $this->Cell(94,5,'Ship Via',1,0,'C');
            $this->SetX(105);
            $this->Cell(94,5,'Payment Term',1,0,'C');
            $this->Ln();
            $this->SetFont('Times','',8);
            $this->SetX(11);
            $this->Cell(94,5,$this->via,1);
            $this->SetX(105);
            $this->Cell(94,5,$this->term,1);
            $this->Ln();
            $this->SetFont('Times','B',8);
            $this->SetX(11);
            $this->Cell(25,5,'Invoice Date',1,0,'C');
            $this->SetX(36);
            $this->Cell(25,5,'Ship Date',1,0,'C');
            $this->SetX(61);
            $this->Cell(44,5,'SO#',1,0,'C');
            $this->SetX(105);
            $this->Cell(94,5,'Remark',1,0,'C');
            $this->Ln();
            $this->SetFont('Times','',8);
            $this->SetX(11);
            $this->Cell(25,5,$this->docdate,1,0,'C');
            $this->SetX(36);
            $this->Cell(25,5,$this->shipdate,1,0,'C');
            $this->SetX(61);
            $this->Cell(44,5,$this->sono,1,0,'C');
            $this->SetX(105);
            $this->Cell(94,5,$this->remark,1,0);
            $this->Ln();
            $this->SetFont('Times','B',8);
            $this->SetX(11);
            $this->Cell(114,135,'',1);
            $this->SetX(125);
            $this->Cell(20,135,'',1);
            $this->SetX(145);
            $this->Cell(20,135,'',1);
            $this->SetX(165);
            $this->Cell(34,135,'',1);
            $this->SetX(199);
            $this->Cell(1,135,'');
            $this->SetX(11);
            $this->Cell(114,5,'Item Number',1,0,'C');
            $this->SetX(125);
            $this->Cell(20,10,'Quantity','LR',0,'C');
            $this->SetX(145);
            if($this->per1000 == 1){
                $this->Cell(20,5,  'Unit Cost','LT',0,'C');
            } else {
                $this->Cell(20,10,  'Unit Cost','LT',0,'C');
            }
            $this->SetX(165);
            $this->Cell(34,10,'Extended Price','LR',0,'C');
            $this->SetX(199);
            $this->Cell(1,5,'');
            $this->Ln();
            $this->SetX(11);
            $this->Cell(114,5,'Item Description',1,0,'C');
            $this->SetX(125);
            $this->Cell(20,5,'','LBR');
            $this->SetX(145);
            if($this->per1000 == 1){
                $this->Cell(20,5,'(per 1000)','LB',0,'C');
            } else {
                $this->Cell(20,5,'','LB');
            }
            $this->SetX(165);
            $this->Cell(34,5,'','LBR');
            $this->Ln();
        }

        function Footer(){
            $this->SetY(-48);
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->SetX(11);
            $this->Cell(40,5,'Printed By : '.$this->created);
            $this->Ln();
            $this->SetFont('Times','I',8);
            $this->SetX(11);
            $this->Cell(40,5,'Page '.$this->PageNo().'/{nb}');
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
        $tax=$r->tax;
        $disc=$r->discount;
        $totaldue=$r->totaldue;
        $cur=$r->currency;
        $per1000=$r->per1000;
    }
    

    $pdf = new PDF('P','mm','A4');
    $pdf->inv=$invno;
    $pdf->cust=$custid;
    $pdf->custcompany=$customer->customer_company_name;
    $pdf->address=$customer->customer_address;
    $pdf->telephone=$customer->customer_phone;
    $pdf->contact=$customer->customer_contact_name;
    $pdf->term=$customer->customer_term;
    $pdf->via=$via;
    $pdf->docdate=$docdate;
    $pdf->shipdate=$shipdate;
    $pdf->sono=$sono;
    $pdf->remark=$remark;
    $pdf->per1000=$per1000;
    $pdf->created=$createdby;
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',10);
    $i=1;
    foreach ($_getInv as $r){
            $y = $pdf->GetY() + 1;
            $pdf->SetXY(11,$y);
            $pdf->MultiCell(114,5,$r->itemid);
            $pdf->SetXY(126,$y);
            $pdf->MultiCell(18,5,number_format($r->quantity,2),0,0,'R');
            $pdf->SetXY(146,$y);
            $pdf->MultiCell(18,5,number_format($r->invoiceprice,4),0,0,'R');
            $pdf->SetXY(166,$y);
            $pdf->MultiCell(32,5,number_format($r->total,2),0,0,'R');
            $pdf->SetXY(199,$y);
            $pdf->MultiCell(1,5,'');
            $pdf->Ln();
            $y2 = $pdf->GetY() - 5;
            $pdf->SetXY(11,$y2);
            $pdf->MultiCell(114,5,$r->itemname);
            $pdf->Ln();
            
            if($i % 7 == 1 and $i > 1){
                $pdf->AddPage();
            }
            $i++;
    }
    
    $pdf->SetY(-48);
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(61);
    $pdf->Cell(34,4,'Total Paid','LTR',0,'R');
    $pdf->SetX(135);
    $pdf->Cell(34,4,'Subtotal','LTR',0,'R');
    $pdf->SetFont('Times','',8);
    $pdf->SetX(95);
    $pdf->Cell(30,4,'','TR',0,'R');
    $pdf->SetX(169);
    $pdf->Cell(10,4,$cur,'T',0,'C');
    $pdf->SetX(179);
    $pdf->Cell(20,4,number_format($maintotal,2),'TR',0,'R');
    $pdf->Ln();
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(61);
    $pdf->Cell(34,4,'','LR');
    $pdf->SetX(135);
    $pdf->Cell(34,4,'Discount','LR',0,'R');
    $pdf->SetFont('Times','',8);
    $pdf->SetX(95);
    $pdf->Cell(30,4,'','R');
    if( $disc > 0){
        $pdf->SetX(169);
        $pdf->Cell(10,4,$cur,0,0,'C');
        $pdf->SetX(179);
        $pdf->Cell(20,4,number_format($disc,2),'R',0,'R');
    } else {
        $pdf->SetX(169);
        $pdf->Cell(30,4,'','R',0,'R');
    }
    $pdf->Ln();
    $pdf->SetX(11);
    $pdf->Cell(40,4,'','B');
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(61);
    $pdf->Cell(34,4,'Balance Due','LBR',0,'R');
    $pdf->SetX(135);
    $pdf->Cell(34,4,'Freight','LR',0,'R');
    $pdf->SetFont('Times','',8);
    $pdf->SetX(95);
    $pdf->Cell(30,4,'','BR',0,'R');
    if( $freight > 0){
        $pdf->SetX(169);
        $pdf->Cell(10,4,$cur,0,0,'C');
        $pdf->SetX(179);
        $pdf->Cell(20,4,number_format($freight,2),'R',0,'R');
    } else {
        $pdf->SetX(169);
        $pdf->Cell(30,4,'','R',0,'R');
    }   
    $pdf->Ln();
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(11);
    $pdf->Cell(40,4,'Approve By',0,0,'C');
    $pdf->SetX(135);
    $pdf->Cell(34,4,'GST','LR',0,'R');
    $pdf->SetFont('Times','',8);
    if( $tax > 0){
        $pdf->SetX(169);
        $pdf->Cell(10,4,$cur,0,0,'C');
        $pdf->SetX(179);
        $pdf->Cell(20,4,number_format($tax,2),'R',0,'R');
    } else {
        $pdf->SetX(169);
        $pdf->Cell(30,4,'','R',0,'R');
    }   
    $pdf->Ln();
    $pdf->SetX(11);
    $pdf->Cell(40,4,'');
    $pdf->SetX(135);
    $pdf->Cell(34,4,'','LR',0,'R');
    $pdf->SetX(169);
    $pdf->Cell(30,4,'','R',0,'R');
    $pdf->Ln();
    $pdf->SetX(11);
    $pdf->Cell(40,4,'');
    $pdf->SetFont('Times','B',8);
    $pdf->SetX(135);
    $pdf->Cell(34,4,'Grand Total','LBR',0,'R');
    $pdf->SetFont('Times','',8);
    $pdf->SetX(169);
    $pdf->Cell(10,4,$cur,'B',0,'C');
    $pdf->SetX(179);
    $pdf->Cell(20,4,number_format($totaldue,2),'BR',0,'R');

    $pdf->Output('PO-'.date("mdy").'.pdf','I');

?>