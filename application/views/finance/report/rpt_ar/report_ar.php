<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Invoice';
        $this->Image('assets/ZHL-Report.png', 10, 9, 33, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(8, 10);
        $this->Cell(140, 10, 'Zhenghe Logistics Pte Ltd', 0, 0, 'C');
        $this->Cell(8);
        $this->Cell(100, 10, 'Payment A/P ', 0, 1, 'L');
//      $this->Cell(1, 8, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(15);
        $this->cell(120, 3, 'Reg. No.: 201537276N', 0, 0, 'C');
        $this->Cell(10);
        $this->Cell(58, 3, '', 0, 1, 'L');

        $this->setFont('Arial', 'B', 8);
        $this->Cell(20);
        $this->cell(130, 4, '39 WOODLANDS CLOSE #02-07/08 MEGA@WOODLANDS, SINGAPORE 737856', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(8);
        $this->Cell(15, 4, 'Page', 0, 0, 'R');
        $this->Cell(98, 4, ': '.$this->PageNo().' of {nb}', 0, 1, 'L');

        $this->setFont('Arial', 'B', 8);
        $this->Cell(13);
        $this->cell(140, 4, 'E-mail : booking@zhenghe.com.sg / shipping@zhenghe.com.sg', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        
        $this->Line(10, 40, 250 - 50, 40);

    }

    function Content($HeaderAR, $DetailAP,$DtlJrnal) {
        $this->Ln(5);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($HeaderAR as $s) {
       

     
                  $x = $this->GetX();
                  $y = $this->GetY();

            
                 
                  $this->SetXY(10,45);
                  $this->SetFont('Arial','',9);
                  $this->cell(30,5,'Ref. Number ',0,'L',1);
                  $this->SetXY(35,45);
                  $this->cell(10,5,': ',0,'L',0);
                  $this->Cell(23,5,$s->no_facture,0,0,'L');
                  $this->Cell(-45);
                  $this->cell(120,5,'Customer',0,0,'R');
                  $this->cell(8,5,': ',0,0,'R');
                  $this->SetFont('Arial','',7);
                  $this->MultiCell(70,5,$s->customer_company_name,0,1,'L');
                  $this->SetFont('Arial','',9);
                


                  $this->SetXY(10,50);
                  $this->cell(30,5,'Cash Bank ',0,'L',1);
                  $this->SetXY(35,50);
                  $this->cell(10,5,': ',0,'L',0);
                  $this->cell(21,5,$s->code_cashbank,0,'L',0);
                  $this->Cell(-40);
                  $this->cell(120,5,'Currency',0,'R',0);
                  $this->cell(5,5,': ',0,'R',0);
                  $this->cell(9,5,$s->currency_id,0,'L',0);
                
                  $this->SetFont('Arial','',9);
                  $this->SetXY(10,55);               
                  $this->cell(30,5,'Trans Date ',0,'L',1);
                  $this->SetXY(35,55);                 
                  $this->cell(10,5,': ',0,'L',0);
                  $this->cell(21,5,date_format(New DateTime($s->trans_date), 'M, d-Y'),0,'L',0);
                  $this->Cell(-40);
                  $this->cell(114,5,'Voucher Remark',0,'R',0);
                  $this->cell(11,5,': ',0,'L',0);
                  $this->cell(15,5,$s->remark,0,'L',0);
                

                  $this->SetXY(10,60);
                  $this->cell(30,5,'Account Name ',0,'L',1);
                  $this->SetXY(35,60);
                  $this->SetFont('Arial','',9);
                  $this->cell(10,5,': ',0,'L',0);
                  $this->cell(21,5,$s->AccountName0,'L',0);
                  $this->Cell(-40);
                  $this->cell(122,5,'Rate',0,'R',0);
                  $this->cell(3,5,': ',0,'R',0);
                  $this->SetFont('Arial','',9);
                  $this->cell(15,5,$s->currency_rate,0,'R',0);
             

                  $this->SetXY(10,65);
                  $this->cell(30,5,'Rate SGD ',0,'L',1);
                  $this->SetXY(35,65);
                  $this->cell(10,5,': ',0,'L',0);
                  $this->cell(5,5,$s->rate_sgd,0,'L',0);
                  $this->Cell(10);
                  $this->cell(96,5,'Check Number',0,'R',0);
                  $this->cell(4,5,':',0,'L',0);
                  $this->cell(15,5,$s->check_number,0,'R',0);
                 
                  $this->Ln(7);

                    }


                    $this->Ln();
                    $this->setFont('Arial', 'B', 7);
                    $this->setFillColor(255, 255, 255);

                    $this->Line(10, 75, 253 - 50, 75);
                    $this->Line(10, 84, 253 - 50, 84);

                    $this->cell(7, 5, 'No.', 0, 0, 'C', 1);
                    $this->cell(16,5,'No.Invoice',0,'L',0);
                    $this->cell(23,5,'Rate',0,'L',0);
                    $this->cell(38,5,'Total Before',0,'L',0);
                    $this->cell(13,5,'[USD]Equivalent',0,'L',0);
                    $this->cell(17,5,'Payment',0,'L',0);
                       

                    $this->Ln(10);

                    $NO = 1;
                    $this->setFont('Arial', '', 7);
                    $this->setFillColor(255, 255, 255);
      
                    if (!empty($DetailAP)) {
                        foreach ($DetailAP as $key) {
                            $x = $this->GetX();
                            $y = $this->GetY();

                          $this->cell(7, 5, $NO, 0, 0, 'C');

                          $this->SetXY(17, $y);
                          $this->MultiCell(30, 5, $key->NoInvoice,0,1 );
                          $this->SetXY(27, $y);

                          

                          $this->SetXY($x + 74, $y-5);
                          $this->MultiCell(115, 15, $key->rate_akhir,0,1);
                          $this->SetXY(37, $y);

                          $this->SetXY($x + 90, $y-5);
                          $this->MultiCell(115, 15, number_format($key->piutang,2),0,1);
                          $this->SetXY(37, $y);

                          $this->SetXY($x + 106, $y-5);
                          $this->MultiCell(115, 15,  number_format($key->rate_akhir*$key->piutang, 2),0,1);
                          $this->SetXY(37, $y);

                          $this->SetXY($x + 121, $y-5);
                          $this->MultiCell(115, 15, number_format($key->piutang-$key->total_pay, 2),0,1);
                          $this->SetXY(37, $y);
                          
                        
                          // $this->SetXY($x + 165, $y-5);
                          // $this->MultiCell(115, 15, $key->gst_type,0,1);
                          // $this->SetXY(37, $y);
                            
                          //    $this->SetXY($x + 153, $y-5);
                          //    if ($key->Qty * $key->price == 0){                         
                          //        $col3 = $key->gst_value;
                          //    }else{                               
                          //       $col3 = $key->gst_value;
                          //    }
                          // $this->MultiCell(36,15, number_format($col3, 2), 0, 'R');
                          // $this->SetXY(40, $y);
                          // $this->MultiCell(40, 5, $key->ItemName,0,1,'L');

                            if ($this->GetY() > 255){
                                $this->AddPage();
                                    }
                                $this->Ln(3);
                           
                            $NO ++;

                            
                        }
                    }

                    $this->Ln(3);

                    $this->Line(10, $this->GetY(), 204, $this->GetY());                
                    $this->cell(40, 6, 'Account Number', 0, 'R', 1);
                    $this->cell(-4,6,'D/C',0,'L',0);
                    $this->cell(20,6,'Account Name',0,'L',0);
                    $this->cell(30,6,'Description',0,'C',0);
                    $this->cell(45,6,'Total',0,'L',0);
                    $this->cell(18,6,'Rate',0,'L',0);
                    $this->cell(23,6,'Debit',0,'L',0);
                    $this->cell(18,6,'Credit',0,'L',0);
                    $this->Ln(6);
                    $this->Line(10, $this->GetY(), 204, $this->GetY());
                    $this->Ln(2);
                
                //     if (!empty($get_data_jurnal)) {   
                //     foreach ($get_data_jurnal as $q){
                //         $x = $this->GetX();
                //         $y = $this->GetY();
                                               
                //         $this->SetXY($x-8, $y);
                //         $this->MultiCell(20, 5, $q->NoCOA,0,0, 'L');

                //         $this->SetXY($x+42, $y);
                //         $this->MultiCell(-8, 5, $q->chk,0,0,'R' );
                //         $this->SetXY(20, $y);

                //         $this->SetXY($x+38, $y);
                //         $this->MultiCell(40, 5, $q->JenisJurnalID,0,'L' );


                //         $this->SetXY($x+113, $y);
                //         $this->MultiCell(21, 5, number_format($q->Total,2),0,0,'L' );


                //         $this->SetXY($x+122, $y);
                //         $this->MultiCell(31, 5, $q->Rate,0,0 );

                //         $this->SetXY($x+155, $y);
                //         $this->MultiCell(17, 5, number_format($q->Debet,2),0,0 );
                        
                //         $this->SetXY($x+175, $y);
                //         $this->MultiCell(17, 5, number_format($q->Kredit,2),0,0,'L' );


                //         $this->SetXY(73, $y);
                //         $this->MultiCell(58, 5, $q->Keterangan,0,1,'L' );
                     


                       
                //     }

                // }

              
                //     foreach ($get_total  AS $u){ 
                //     $this->Ln(3);                  
                //     $this->Line(10, $this->GetY(), 204, $this->GetY());                 
                //     $this->cell(173,5,number_format($u->total_debet,2),0,'L',0);
                //     $this->cell(20,5,number_format($u->total_kredit,2),0,'L',0);
                //     $this->Ln(5);
                //     $this->Line(10, $this->GetY(), 204, $this->GetY());
                // }
             }

              function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
            if ($this->GetY() + $h > $this->PageBreakTrigger) {
                $this->AddPage($this->CurOrientation);

        $pdf->AddPage();

        }
    }

    

}

$pdf = new PDF('P','mm','A4');
//$pdf->judul = $judul;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($HeaderAR, $DetailAP,$DtlJrnal);   
$pdf->Output();