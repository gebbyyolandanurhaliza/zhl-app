<?php
class PDF extends FPDF {
        function Header(){
            $this->ln(5);
            $this->SetFont('Times','B',9);
            $this->SetX(11);
            $abs1 = $this->GetY();
            $this->SetX(11);
            $this->Cell(27,4,'Company Name',0,0);
            $this->Cell(30,4,':',0,0);
            $this->SetX(45);
            $this->Cell(29,4,'Pulau Sambu Singapore PTE LTD',0,0); // Ini belum di Kirim dari API
            $this->SetX(120);
            // $this->Cell(27,4,'SHIPMENTDATE',0,0);
            // $this->Cell(30,4,':',0,0);
            // $this->SetX(155);
            // $this->Cell(29,4,'',0,0);  // JANGAN DIHAPUS DULU !!!!!!!!!
            $this->Ln();
            $this->SetX(11);
            $this->Cell(27,4,'1st Carrier',0,0);
            $this->Cell(30,4,':',0,0);
            $this->SetX(45);
            $this->Cell(29,4,$this->vesselName,0,0);
            $this->SetX(120);
            $this->Cell(27,4,'Shipmentdate',0,0);
            $this->Cell(30,4,':',0,0);
            $this->SetX(155);
            $date = date('d-m-Y'); // Ini data Date Sementara // Ini belum di Kirim dari API
            $this->Cell(29,4,$date,0,0);
            $this->Ln();
            $this->SetX(11);
            $this->Cell(27,4,'Voyage Number',0,0);
            $this->Cell(30,4,':',0,0);
            $this->SetX(45);
            $this->Cell(29,4,$this->voyage,0,0);
            $this->SetX(120);
            $this->Cell(27,4,'From',0,0);
            $this->Cell(30,4,':',0,0);
            $this->SetX(155);
            $this->Cell(29,4,'PT. Pulau Sambu Guntung',0,0); // Ini belum di Kirim dari API


            $abs4 = $this->GetY()+10;
            $this->Line(11, $abs1, 11, $abs4);
            $this->Line(199, $abs1, 199, $abs4);
            $this->Line(11, $abs1, 199, $abs1);
            $this->Line(11, $abs4, 199, $abs4);

            $abs2 = $this->GetY()+10;
            $this->SetFont('Times','B',9);
            $this->SetXY(11,$abs2);
            $this->MultiCell(10,20,'No',0,'C');
            $this->SetXY(21,$abs2);
            $this->MultiCell(29,20,'PO No',0,'C');
            $this->SetXY(50,$abs2);
            $this->MultiCell(25,20,'Container No',0,'C');
            $this->SetXY(75,$abs2);
            $this->MultiCell(25,20,'Seal No',0,'C');
            $this->SetXY(130,$abs2);
            $this->MultiCell(24,5,'Container Tare Weight (MT)',0,'C');
            $this->SetXY(154,$abs2);
            $this->MultiCell(20,5,'Total Gross Weight (MT)',0,'C');
            $this->SetXY(174,$abs2);
            $this->MultiCell(25,20,'Carrier',0,'C');
            $this->SetXY(100,$abs2);
            $this->MultiCell(30,5,'Goods Gross Weight in MT (Include Product, Packaging, Pallet)',0,'C');
            
            $abs3 = $this->GetY();
            $this->Line(11, $abs2, 11, $abs3);
            $this->Line(21, $abs2, 21, $abs3);
            $this->Line(50, $abs2, 50, $abs3);
            $this->Line(75, $abs2, 75, $abs3);
            $this->Line(100, $abs2, 100, $abs3);
            $this->Line(130, $abs2, 130, $abs3);
            $this->Line(154, $abs2, 154, $abs3);
            $this->Line(130, $abs2, 130, $abs3);
            $this->Line(154, $abs2, 154, $abs3);
            $this->Line(174, $abs2, 174, $abs3);
            $this->Line(199, $abs2, 199, $abs3);
            $this->Line(11, $abs3, 199, $abs3);

            // // WATERMARK
            // if ($this->status == 3){
            //     $this->SetFont('ARIAL', 'B', 50);
            //     $this->SetTextColor(255,192,203);
            //     $this->RotatedText(52, 190, 'C A N C E L L E D', 40);
            // }
        }

        function Footer(){
            $this->SetY(-35);
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->SetX(170);
            // $this->Cell(40,4,'Printed By : $this->created');
            $this->Ln();
            $this->SetFont('Times','I',8);
            $this->SetX(170);
            $this->Cell(30,20,'Page '.$this->PageNo().'/{nb}');
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
    }
    
    if(!empty($HdrDtl)){ 
        $DtlFinal = json_decode($HdrDtl);

        $bukadatasolasHDR = json_decode($HdrDtl); 
        $transID    = $bukadatasolasHDR->transID;
        $vesselName = $bukadatasolasHDR->vesselName;
        $voyage     = $bukadatasolasHDR->voyage;
        $solasDtl   = $bukadatasolasHDR->solasDtl;
    }

    $pdf = new PDF('P','mm','A4');
    $pdf->vesselName = $vesselName;
    $pdf->voyage     = $voyage;

    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Times','',9);

    

    if(!empty($HdrDtl)){ 
        $DtlFinal = json_decode($HdrDtl);

                $bukadatasolasHDR = json_decode($HdrDtl); 
                    $transID    = $bukadatasolasHDR->transID;
                    $vesselName = $bukadatasolasHDR->vesselName;
                    $voyage     = $bukadatasolasHDR->voyage;
                    $solasDtl   = $bukadatasolasHDR->solasDtl;

            $i=1;
            $yawal = $pdf->GetY();    
            foreach ($DtlFinal->solasDtl as $x){
                
                $y = $pdf->GetY();
                $pdf->SetXY(11,$y);
                $pdf->MultiCell(10,5,$i,0,'C');
                $pdf->SetXY(21,$y);
                $pdf->MultiCell(29,5,$x->poNumber,0,'C');
                $pdf->SetXY(50,$y);
                $pdf->MultiCell(25,5,$x->containerNumber,0,'C');
                $pdf->SetXY(75,$y);
                $pdf->MultiCell(25,5,$x->sealNumber,0,'C');
                $pdf->SetXY(100,$y);
                $pdf->MultiCell(30,5,number_format($x->grossWeight, 3, '.',','),0,'C');
                $pdf->SetXY(130,$y);
                $pdf->MultiCell(24,5,number_format($x->otherWeight, 3, '.',','),0,'C');
                $pdf->SetXY(154,$y);
                $pdf->MultiCell(20,5,number_format($x->containerWeight, 3, '.',','),0,'C');
                $pdf->SetXY(174,$y);
                $pdf->MultiCell(25,5,$x->linerName,0,'C');

                if($pdf->GetY() > 250){
                    
                    $pdf->AddPage();
                }
                $i++;

            }
    }    

        
    $pdf->SetY(-29);
    $pdf->SetX(155);
    $pdf->Cell(40,4,'','B');
    $pdf->Ln();
    $pdf->SetFont('Times','B',9);
    $pdf->SetX(155);
    $pdf->Cell(40,4,'Verified by : Doan Wahyudi',0,0,'C');
    $pdf->SetFont('Times','',8);
    $pdf->Output('tes.pdf','I');
    
    ?>
