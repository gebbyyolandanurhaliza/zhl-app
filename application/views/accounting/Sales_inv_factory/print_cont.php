<?php

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Times','B',15);
        $this->Image(base_url().'assets/ZHL-Report.png',100,10,20);
        $this->Cell(40);
        $this->Cell(0,10,'ZHENGHE LOGISTIC PTE LTD',0,0,'C');
       
       
        $this->Ln(30);
        $this->SetFont('Times','B',12);
        $this->Cell(40,5,'Shipmentdate',0,0,'L',0);
        $this->Cell(2,5,':',0,0,'L',0);
            
        $this->SetFont('Times','',12);
        $this->Cell(80,5,$this->shipmentdate,0,0,'L',0);

        $this->SetY(45);
        $this->SetFont('Times','B',12);
        $this->Cell(40,5,'Vessel /Voyage No',0,0,'L',0);
        $this->Cell(2,5,':',0,0,'L',0);
        $this->SetFont('Times','',12);
        $this->Cell(80,5,$this->voyage,0,0,'L',0);

        $this->SetFont('Times','B',12);
        $this->Cell(100,5,'Invoice Type:',0,0,'R',0);
         $this->SetFont('Times','',12);
        $this->Cell(30,5,$this->jenis_inv,0,0,'R',0);


        $this->Ln(10);   
        $this->SetFillColor(192,192,192);
        $this->SetFont('Times','',10);
        $this->SetX(10);
        $this->Cell(10,5,'No',1,0,'C',1);
        $this->SetX(20);
        $this->Cell(60,5,'Container Type',1,0,'C',1);
        $this->SetX(80);
        $this->Cell(70,5,"Container Number",1,0,'C',1);
        $this->SetX(150);
        $this->Cell(60,5,'Seal NUmber',1,0,'C',1);
        $this->SetX(210);
        $this->Cell(60,5,'Type Stuffing',1,0,'C',1);
        $this->Ln(5);
            
        
    }
}



foreach($get_data_header as $v){
        $shipmentdate =  date("d F Y",  strtotime($v->shipmentdate));
        $voyage = $v->voyage;
       if($v->jenis_inv=='bar'){
            $jenis_inv = 'Barge Charges';
            }elseif($v->jenis_inv=='fre'){
            $jenis_inv = 'Freight Charges';
            }elseif($v->jenis_inv=='trn'){
            $jenis_inv = 'Transport Charges';
            }elseif($v->jenis_inv=='imp'){
            $jenis_inv = 'Import Charges';
            }elseif($v->jenis_inv=='eim'){
            $jenis_inv = 'Empty Import';
            }elseif($v->jenis_inv=='lem'){
            $jenis_inv = 'Local Empty';
            }      
    }
    $pdf = new PDF('L','mm','A4');
    $pdf->shipmentdate = $shipmentdate;
    $pdf->voyage = $voyage;
    $pdf->jenis_inv = $jenis_inv;

$ytemp=0;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
$i=1;
foreach ($dtlctr as $r){
   
    $y = $pdf->GetY() - $ytemp;
    
    $pdf->Line(10, $y, 270, $y);

    $pdf->SetXY(10, $y);
    $pdf->Cell(10, 5, $i,1,0,'C',1);
    $pdf->SetXY(20, $y);
    $pdf->Cell(60, 5, $r->container_name,1,0,'C',1);
    $pdf->SetXY(80, $y);
    $pdf->Cell(70, 5, $r->container_number,1,0,'C',1);
    $pdf->SetXY(150, $y);
    $pdf->Cell(60, 5, $r->seal_number,1,0,'C',1);
    $pdf->SetXY(210, $y);
    $pdf->Cell(60, 5, '',1,0,'C',1);
    $pdf->Ln();
    $i++;
    if($y > 170){
                $y3 = $pdf->GetY();
                $pdf->Line(10, $y3, 288, $y3);
                $pdf->AddPage();
            }
            
           
    }
    
    $y4 = $pdf->GetY();
    $pdf->Line(10, $y4, 273, $y4);
    

$pdf->Output('Loading Confirmation '.date('dmy').'pdf','I');