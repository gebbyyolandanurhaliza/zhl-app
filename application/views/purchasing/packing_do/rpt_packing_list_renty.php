<?php

  Class PDF extends TFPDF{
    function Header(){
     
      $this->setXY(30,15);
      $this->setFont('Arial', 'B', 18);
      $this->SetTextColor(0, 51, 153);
      $this->setFillColor(255, 255, 255);
      $this->Cell(168, 5, 'PULAU SAMBU SINGAPORE PTE LTD',0, 0, 'C', 1);

      $this->setXY(30,21);
      $this->setFont('Arial', '', 7);
      $this->Cell(168, 3, 'Reg. No.: 201537276N',0, 0, 'C');

      $this->setXY(30,25);
      $this->setFont('Arial', '', 9);
      $this->cell(168, 4, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909',0, 0, 'C', 1);
      $this->setXY(30,30);
      $this->cell(168, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg',0, 0, 'C', 1);
      $this->setXY(30,34);
      $this->cell(168, 4, 'www.sambugroup.com',0, 0, 'C', 1);

      $this->setXY(40,5);
      $this->Image('assets/PSG.png', 17, 10, 35, 0, 'PNG');


      //$this->Ln(5);
      $this->SetTextColor(0, 0, 0);
      $this->setXY(10,41);
      $this->setFont('Arial', 'B', 20);
      $this->cell(56, 10, 'PACKING LIST',0, 0, 'L', 1);

      $this->setFont('Arial', '', 9);
      $this->setXY(10,$this->getY()+11);
      $this->Cell(20,5,'Date',0,'L');
      $this->Cell(47.5,5,':',0,'L');

      $this->setXY(10,$this->getY()+5);                                   
      $this->Cell(20,5,'PLNo',0,'L');
      $this->Cell(47.5,5,':',0,'L');

      $this->setXY(10,$this->getY()+5);
      $this->Cell(20,5,'Customer',0,'L');
      $this->Cell(47.5,5,':',0,'L');

      $this->setXY(118,$this->getY()-11);
      $this->Cell(35,5,'Shipment Date',0,'L');
      $this->Cell(47.5,5,':',0,'L');

      $this->setXY(118,$this->getY()+5);
      $this->Cell(35,5,'Shipment Term',0,'L');
      $this->Cell(47.5,5,':',0,'L');


      $this->SetXY(10,75);
      $this->setFont('Arial', 'B', 9);
      $this->Cell(15,5,' No',1,0,'C',1);
      $this->Cell(30,5,'QUANTITY',1,0,'C',1);
      $this->Cell(75,5,'DESCRIPTION OF GOODS',1,0,'C',1);
      $this->Cell(35,5,'GROSS WEIGHT',1,0,'C',1);
      $this->Cell(35,5,'NET WEIGHT',1,0,'C',1);
      
    }
    function Content(){
     

    }
    function Footer(){
      $this->SetXY(10,240);
      $this->setFillColor(255, 255, 255);
      $this->setFont('Arial', 'B', 9);
      $this->Cell(30,10,'Country Of Origin:',1,0,'C',1);
      $this->Cell(50,10,'',1,0,'C',1);

      $this->SetXY(110,250);
      $this->Cell(90,5,'PULAU SAMBU SINGAPORE LTD',0,0,'L',1);
      $this->SetXY(110,275);
      $this->Cell(90,5,'Approved By:','T',0,'L',1);


    }
    function NbLines($w, $txt) {
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

  foreach($packdo as $r){
      $noreff         = $r->noreff;
      $type           = $r->type;
      $factory_id     = $r->factory_id;
      $ship_date      = date("d-m-Y",  strtotime($r->ship_date));
      $ship_via       = $r->ship_via;
      $detail_id      = $r->detail_id;
      $descriptions   = $r->descriptions;
      $itemid         = $r->itemid;
      $grossweight    = $r->grossweight;
      $qty            = $r->qty;
      $neetweight     = $r->neetweight;
      $docno_gr       = $r->docno_gr;
      $mainpo         = substr($r->mainpo,9);
      $npbbno         = $r->npbbno;
      $id_gr          = $r->id_gr;
  }

    
     

  $pdf = new PDF('P','mm','A4');

    $pdf->noreff      =$noreff;
    $pdf->type        =$type;
    $pdf->factory_id  =$factory_id;
    $pdf->ship_date   =$ship_date;
    $pdf->ship_via    =$ship_via;
    $pdf->detail_id   =$detail_id;
    $pdf->descriptions=$descriptions;
    $pdf->itemid      =$itemid;
    $pdf->grossweight =$grossweight;
    $pdf->qty         =$qty;
    $pdf->neetweight  =$neetweight;
    $pdf->docno_gr    =$docno_gr;
    $pdf->mainpo      =$mainpo;
    $pdf->npbbno      =$npbbno;
    $pdf->id_gr       =$id_gr;
    $pdf->customer_name =$cust->customer_name;
    $pdf->customer_contact_name =$cust->customer_contact_name;
    $pdf->customer_contact_phone =$cust->customer_contact_phone;
    $pdf->custaddress   =$cust->customer_address;

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->ln(1);
    $no = 0;
    $pdf->setFont('Times', '', 8);
    $pdf->SetY(80);

    

     foreach($packdo as $l){ 
            $no++;
            $y = $pdf->GetY();
            
            if($y > 250){
              $pdf->AddPage();
              $pdf->SetY(80);
              $y = $pdf->GetY();
            }
            $pdf->SetFont('Times','',9);     
            $pdf->SetXY(10,$y);
            $pdf->cell(15,13,'','RLB', 'C'); 
            $pdf->SetXY(10,$y);
            $pdf->multicell(15,5,$no,0, 'C'); 


            $pdf->SetXY(25,$y);
            $pdf->cell(30,13,'','RLB', 'C'); 
            $pdf->SetXY(25,$y);
            $pdf->cell(105,13,'','RLB', 'C'); 
            $pdf->SetXY(25,$y);
            $pdf->multicell(30,5,$l->qty.'-'.$l->uom,0, 'L');

            $max = $pdf->NbLines(30,$l->qty.'-'.$l->uom);
            $y8 = $pdf->GetY();

            $pdf->SetXY(55,$y);
            $pdf->multicell(55,5,$l->descriptions,0, 'L');
            $pdf->Ln();
            $y2 = $pdf->GetY()-5;
            $pdf->SetXY(55,$y2);
            $pdf->multicell(55,5,'P/O NUMBER : '.$l->mainpo,0, 'L');

            $pdf->SetXY(130,$y);
            $pdf->cell(35,13,'','RLB', 'C'); 
            $pdf->SetXY(130,$y);
            $pdf->multicell(35,5,$l->grossweight.' KGS',0,'R');

            $pdf->SetXY(165,$y);
            $pdf->cell(35,13,'','RLB', 'C'); 
            $pdf->SetXY(165,$y);
            $pdf->multicell(35,5,$l->neetweight.' KGS',0,'R');


            $pdf->Ln(10);
      }        
        $pdf->SetFont('Times','B','8');
        $pdf->setFillColor(255, 255, 255);
        $pdf->Cell(120,5,'SUB TOTAL',1,'C',0,0);
        $pdf->Cell(35,5,'  '.number_format('200000',0,',','.'),1,'R',0,0);
        $pdf->Cell(35,5,'  '.number_format('200000',0,',','.'),1,'R',0,1);
       
  $pdf->Output();
 
?>