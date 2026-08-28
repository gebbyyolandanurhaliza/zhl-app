<?php

class PDF1 extends FPDF {
        function Header(){
            $this->SetFont('Times','B',15);
            $this->Image(base_url().'assets/ps.png',100,10,20);
            $this->Cell(40);
            $this->Cell(0,10,'PULAU SAMBU SINGAPORE PTE LTD',0,0,'C');
            $this->Ln(15);
            $this->SetFont('Times','B',12);
            $this->Cell(40,5,'Vessel(Barge)');
            $this->Cell(70,5,': '.strtoupper($this->barge));
            $this->Cell(50,5,'CONTAINER INWARD LIST');
            $this->Cell(40,5,'');
            $this->Cell(35,5,'SHIPMENT FROM');
            $this->Cell(30,5,'  : '.strtoupper($this->from));
            $this->Ln();
            $this->Cell(40,5,'Voyage');
            $this->Cell(70,5,': '.$this->voyage);
            $this->Cell(35,5,'SHIPMENT DATE');
            $this->Cell(55,5,' : '.$this->shipment);
            $this->Cell(20,5,'TO');
            $this->Cell(30,5,': '.strtoupper($this->to));
            $this->Ln();
            $this->Cell(40,5,'ETD '.$this->etd);
            $this->Cell(50,5,': '.$this->etddate);
            $this->Ln();
            $this->Cell(40,5,'ETA '.$this->eta);
            $this->Cell(50,5,': '.$this->etadate);
            $this->Ln(10);

            $this->SetFillColor(192,192,192);
            $this->SetFont('Times','',10);
            $this->SetX(10);
            $this->Cell(10,5,'No',1,0,'C',1);
            $this->SetX(20);
            $this->Cell(30,5,'Container No',1,0,'C',1);
            $this->SetX(50);
            $this->Cell(20,5,'Seal No',1,0,'C',1);
            $this->SetX(70);
            $this->Cell(10,5,"20'",1,0,'C',1);
            $this->SetX(80);
            $this->Cell(10,5,"40'",1,0,'C',1);
            $this->SetX(90);
            $this->Cell(10,5,'CT',1,0,'C',1);
            $this->SetX(100);
            $this->Cell(40,5,'Vessel Voyage',1,0,'C',1);
            $this->SetX(140);
            $this->Cell(20,5,'ETA SIN',1,0,'C',1);
            $this->SetX(160);
            $this->Cell(25,5,'POD',1,0,'C',1);
            $this->SetX(185);
            $this->Cell(30,5,'Destination',1,0,'C',1);
            $this->SetX(215);
            $this->Cell(20,5,'OP/SO',1,0,'C',1);
            $this->SetX(235);
            $this->Cell(40,5,'Carrier',1,0,'C',1);
            $this->SetX(275);
            $this->Cell(15,5,'Weight',1,0,'C',1);
            $this->Ln();
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Times','I',8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    
    foreach ($_getcont as $r){
        $barge=$r->barge;
        $voyage=$r->voyage;
        $etd=$r->etd;
        $eta=$r->eta;
        $etddateTemp=$r->etddate;
        $etadateTemp=$r->etadate;
        $shipment=date("d M Y",  strtotime($r->shipmentdate));
        $from=$r->from;
        $to=$r->to;
        $remarks=$r->remarks;
        
        if ($etddateTemp != '0000-00-00'){
            $etddate=date("d/m/Y",  strtotime($etddateTemp));
        } else {
            $etddate='';
        }
        
        if ($etadateTemp != '0000-00-00'){
            $etadate=date("d/m/Y",  strtotime($etadateTemp));
        } else {
            $etadate='';
        }
    }

    $pdf = new PDF1('L','mm','A4');
    $pdf->barge=$barge;
    $pdf->voyage=$voyage;
    $pdf->etd=$etd;
    $pdf->etddate=$etddate;
    $pdf->eta=$eta;
    $pdf->etadate=$etadate;
    $pdf->shipment=$shipment;
    $pdf->from=$from;
    $pdf->to=$to;
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',10);
    $totc20=0;
    $totc40=0;
    $i=1;
    $yawal = $pdf->GetY();
    $ytemp=0;
    foreach ($_getcont as $r){
            $y = $pdf->GetY() - $ytemp;
            $pdf->Line(10, $y, 290, $y);
            
            $pdf->SetXY(10,$y);
            $pdf->MultiCell(10,5,$i,0,'C');
            $pdf->SetXY(20,$y);
            $pdf->MultiCell(30,5,$r->container,0,'C');
            $pdf->SetXY(50,$y);
            $pdf->MultiCell(20,5,$r->seal,0,'C');
            $pdf->SetXY(70,$y);
            $pdf->MultiCell(10,5,$r->c20,0,'C');
            $pdf->SetXY(80,$y);
            $pdf->MultiCell(10,5,$r->c40,0,'C');
            $pdf->SetXY(90,$y);
            $pdf->MultiCell(10,5,$r->container_abbr,0,'C');
            $pdf->SetXY(100,$y);
            $pdf->MultiCell(40,5,$r->vessel,0,'C');
            $pdf->SetXY(140,$y);
            $pdf->MultiCell(20,5,$r->etdsin,0,'C');
            $pdf->SetXY(160,$y);
            $pdf->MultiCell(25,5,$r->pod,0,'C');
            $pdf->SetXY(185,$y);
            $pdf->MultiCell(30,5,$r->destination,0,'C');
            $pdf->SetXY(215,$y);
            $pdf->MultiCell(20,5,$r->opcode,0,'C');
            $pdf->SetXY(235,$y);
            $pdf->MultiCell(40,5,$r->shipping_liner,0,'C');
            $pdf->SetXY(275,$y);
            $pdf->MultiCell(15,5,  number_format($r->weight,3),0,'C');
            $pdf->Ln();
            
            $y2 = $pdf->GetY();
            $pdf->Line(10, $yawal, 10, $y2);
            $pdf->Line(20, $yawal, 20, $y2);
            $pdf->Line(50, $yawal, 50, $y2);
            $pdf->Line(70, $yawal, 70, $y2);
            $pdf->Line(80, $yawal, 80, $y2);
            $pdf->Line(90, $yawal, 90, $y2);
            $pdf->Line(100, $yawal, 100, $y2);
            $pdf->Line(140, $yawal, 140, $y2);
            $pdf->Line(160, $yawal, 160, $y2);
            $pdf->Line(185, $yawal, 185, $y2);
            $pdf->Line(215, $yawal, 215, $y2);
            $pdf->Line(235, $yawal, 235, $y2);
            $pdf->Line(275, $yawal, 275, $y2);
            $pdf->Line(290, $yawal, 290, $y2);
            
            if($y > 170){
                $y3 = $pdf->GetY();
                $pdf->Line(10, $y3, 290, $y3);
                $pdf->AddPage();
            }
            
            $totc20= $totc20 + $r->c20;
            $totc40= $totc40 + $r->c40;
            $i++;
    }
    
    $y4 = $pdf->GetY();
    $pdf->Line(10, $y4, 290, $y4);
    
    $pdf->SetX(70);
    $pdf->Cell(10,5,$totc20,1,0,'C',1);
    $pdf->SetX(80);
    $pdf->Cell(10,5,$totc40,1,0,'C',1);
    $pdf->Ln(10);

    $pdf->SetFont('Times','',12);
//    $pdf->Cell(10);
//    $pdf->Cell(30,5,'All Shipment will Be Stow Under Deck Away Boiler (UDAB),Unless Otherwise Secify');
    $y5 = $pdf->GetY();
    $pdf->SetXY(20,$y5);
    $pdf->MultiCell(250,5,str_replace("<br />", "",$remarks));
    $pdf->Ln(20);
    $pdf->Cell(10);
    $pdf->Cell(30,5,'Return Container');
    $pdf->Ln();


    $pdf->SetFillColor(192,192,192);
    $pdf->SetFont('Times','',10);
    $pdf->SetX(10);
    $pdf->Cell(10,5,'No',1,0,'C',1);
    $pdf->SetX(20);
    $pdf->Cell(30,5,'Container No',1,0,'C',1);
    $pdf->SetX(50);
    $pdf->Cell(20,5,"20'",1,0,'C',1);
    $pdf->SetX(70);
    $pdf->Cell(10,5,"40'",1,0,'C',1);
    $pdf->SetX(80);
    $pdf->Cell(10,5,'CT',1,0,'C',1);
    $pdf->SetX(90);
    $pdf->Cell(60,5,'Remark',1,0,'C',1);
    $pdf->Ln();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',10);
    $pdf->SetX(10);
    $pdf->Cell(10,15,'',1,0,'C',1);
    $pdf->SetX(20);
    $pdf->Cell(30,15,'',1,0,'C',1);
    $pdf->SetX(50);
    $pdf->Cell(20,15,'',1,0,'C',1);
    $pdf->SetX(70);
    $pdf->Cell(10,15,'',1,0,'C',1);
    $pdf->SetX(80);
    $pdf->Cell(10,15,'',1,0,'C',1);
    $pdf->SetX(90);
    $pdf->Cell(60,15,'',1,0,'C',1);
    $pdf->Ln();

    $pdf->Output('inward-'.date("dmy").'.pdf','I');