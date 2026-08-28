<?php

    Class PDF extends TFPDF{
        function Header(){
            $titel = 'Payable Recognition';
            $this->SetX(10);
            $this->Cell(190,25,'',0,0);
            $this->Image(base_url().'assets/zhl-kop.PNG',3,8,205,33);
            $this->Ln();
            $this->SetX(10);
            $this->Cell(190,243,'',0,0);
            $this->SetFont('Times','B',20);
            $this->SetX(10);
            $this->Cell(0,10,'Payable Invoice',0,1,'C');

            $this->Ln();
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'To',0,0,'L',0);
            $this->Cell(2,5,':',0,0,'L',0);
            
            $this->SetFont('Times','',10);
            $this->Cell(80,5,$this->tujuan1,0,0,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'Date',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->tgl,0,1,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Addres',0,0,'L',0);
            $this->Cell(2,5,':',0,0,'L',0);

            
            $this->SetFont('Times','',10);
            $this->MultiCell(45,5,str_replace("<br />", "",$this->alamat),0,'L');

            $this->SetXY(132,60);
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Invoice No.',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5, $this->inv,0,1,'L',0);

            $this->SetXY(132,65);
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Payment Terms',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(3,5, $this->term,0,0,'L',0);
            $this->Cell(10,5,'days',0,1,'L',0);

            $this->SetXY(132,75);
            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Barge/Voy No.',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->voyage,0,1,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(20,5,'Attn',0,0,'L',0);
            $this->Cell(2,5,':',0,0,'L',0);

            $this->SetFont('Times','',10);
            $this->Cell(80,5,'Accounts Dept',0,0,'L',0);

            $this->SetFont('Times','B',10);
            $this->Cell(40,5,'Shipment Date',0,0,'R',0);
            $this->Cell(2,5,':',0,0,'L',0);
            $this->SetFont('Times','',10);
            $this->Cell(40,5,$this->tglship,0,1,'L',0);

            $this->ln(10);
            $this->SetFont('Times','B',10);
            $this->Cell(50, 5, 'Item', 'BT', 0, 'C');
            $this->Cell(70, 5, 'Description', 'BT', 0, 'C');
            $this->Cell(15, 5, 'Unit', 'BT', 0, 'R');
            $this->Cell(18, 5, 'Unit Price', 'BT', 0, 'R');
            $this->Cell(19, 5, 'Total', 'BT', 0, 'R');
            $this->Cell(20, 5, 'Total (USD)', 'BT', 0, 'R');
        }

        function Footer(){
            $this->SetY(-50);
       
            $this->Cell(145, 5, 'Total Amount USD', 'T', 0, 'R');
            $this->Cell(5,5, '', 'TR',0,'R');
            $this->Cell(40,5, number_format($this->hutang,2), 'BT',1,'R');

            $this->ln();
            $this->setFont('Arial', '', 8);
            $this->setFillColor(255, 255, 255);
            $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
            $this->setFont('Arial', 'B', 10);
            $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
            $this->setFont('Arial', 'i', 8);
            $this->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
            $this->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
            $this->Cell(10, 5, 'Swift Code : OCBCSGSG', 0, 1, 'l');
            $this->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');

            $this->Cell(90, 5, 'USD Acct No. 357-907-139-5', 0, 0, 'L');
            $this->setFont('Arial', 'B', 10);
            $this->Cell(95, 5, 'Mr. Tahir Bin Abdul Aziz', 0, 1, 'R');

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

    foreach($get_data_header as $r){
        $tujuan = $r->namavendor;
        $alamat = $r->address;
        $tgl = date("d-F-Y",  strtotime($r->tanggal));
        $tglship =  date("d-F-Y",  strtotime($r->tanggal_invoice));
        $inv = $r->nofaktur;
        $term = $r->term;
        $voyage = $r->voyage;
        $hutang = $r->hutang * $r->rate;
    }

    $pdf = new PDF('P','mm','A4');

    $pdf->tujuan1 = $tujuan;
    $pdf->alamat = $alamat;
    $pdf->tgl = $tgl;
    $pdf->tglship = $tglship;
    $pdf->inv = $inv;
    $pdf->term = $term;
    $pdf->voyage = $voyage;
    $pdf->hutang = $hutang;

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->ln();
    $no = 0;
    $pdf->setFont('Arial', '', 9);
    foreach($get_data_detail as $l){
        $no++;
        $y = $pdf->GetY();

        $pdf->SetXY(10, $y);
        $pdf->MultiCell(50, 5, $no.' '.$l->ItemName, 0, 'L');
        $pdf->SetXY(60, $y);
        $pdf->MultiCell(70, 5, $l->description, 0, 'L');
        $pdf->Ln();
        $max = $pdf->NbLines(80,$l->description);
        $y8 = $pdf->GetY();

        $pdf->SetXY(130,$y+$max);
        $pdf->MultiCell(15, 5, $l->unit, 0, 'C');
        $pdf->ln(5)    ;

        $pdf->SetXY(145,$y+$max);
        $pdf->MultiCell(18, 5, number_format($l->price,2), 0, 'R');
        $pdf->ln(5);

        $pdf->SetXY(163,$y+$max);
        $pdf->MultiCell(19, 5, number_format($l->price * $l->unit,2), 0, 'R');
        $pdf->ln(5);

        $pdf->SetXY(182,$y+$max);
        $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate,2), 0, 'R');
        $pdf->ln(5);

    }
    


    $pdf->Output();
    // $pdf->setData()
?>