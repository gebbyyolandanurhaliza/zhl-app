<?php

class PDF1 extends FPDF {    
    
    //Page header            
    function Header() {
    	$this->SetXY(10, $this->GetY());
		
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhlkop.PNG', 11, 15, 200, 35);
        $this->Ln();
        $this->SetX(10);
		$this->ln(15);
		$this->SetTextColor(0, 0, 0);
		$this->setFont('Arial', 'B', 12);
        $this->cell(190, 5, 'PAYMENT ADVICE', 0, 0, 'C');
         $this->Line(10, 45, 250 - 50, 45);
        $this->ln(15);

		$this->SetTextColor(0, 0, 0);
		$this->setFont('Arial', 'B', 9);

        $this->cell(15, 5, 'TO', 0, 0, 'L');
        $this->cell(1, 5, ':', 0, 0, 'C');
        $this->cell(100, 5, strtoupper(decode_str($_GET['sup'])), 0, 1, 'L');
        $this->cell(16);
        $this->cell(100, 5, strtoupper(decode_str($_GET['adr'])), 0, 1, 'L');
        $this->cell(16);
        $this->cell(100, 5, ucwords(strtolower(str_replace('<br />', '', decode_str($_GET['adr2'])))), 0, 1, 'L');

        $this->ln(5);
        $this->cell(15, 5, 'ATTN', 0, 0, 'L');
        $this->cell(1, 5, ':', 0, 0, 'C');
        $this->cell(100, 5, 'ACCOUNT DEPT', 0, 1, 'L');

        $this->ln(5);
        
    }

    function setBoldText($pdf,$text,$sX,$sY){
        $pdf->setFont('Arial', 'B', 9);
        return $pdf->Text($sX,$sY+3.5,$text);
    }
    function setNormalText($pdf,$text,$sX,$sY){
        $pdf->setFont('Arial', '', 9);
        return $pdf->Text($sX,$sY+3.5,$text);
    }

    function Content($_selectInvoice,$_numberCheck) {
        $paid   = 0;
        foreach ($_selectInvoice as $row) {
            $paid += $row->Paid;
        }
        $this->setFont('Arial', '', 9);
        $this->MultiCell(190, 5, $this->setNormalText($this,'Enclosed the Cheque',25,$this->GetY())
            .$this->setBoldText($this, $_numberCheck, 57,$this->GetY())
            .$this->setNormalText($this,'of Amount', (strlen($_numberCheck)*1.85)+58,$this->GetY())
            .$this->setBoldText($this,number_format($paid,2), (strlen($_numberCheck)*1.85)+75.5,$this->GetY())
            .$this->setNormalText($this,'in payment as follows : ', (strlen($_numberCheck)*1.85)+75.5+(strlen(number_format($paid,2))*1.85),$this->GetY()), 0, 1);

        // Detail Product
        // Table Title
        $this->Ln(5);
        // $this->Line(10, $this->GetY(), 200, $this->GetY());     
        $this->setFont('Arial', 'B', 10);
        $this->setFillColor(230,230,230);
        $this->Cell(10, 7, 'No', 'BT', 0, 'C', true);
        $this->Cell(40, 7, 'Invoice No.', 'BT', 0, 'L', true);
        $this->Cell(40, 7, 'Invoice Date.','BT', 0, 'C', true);
        $this->Cell(50, 7, 'Invoice Total (SGD)', 'BT', 0, 'C', true);
        $this->Cell(50, 7, 'Amount Paid (SGD)', 'BT', 1, 'C', true);
        
        // $this->Line(10, $this->GetY(), 200, $this->GetY());
       
        // $this->Ln(1);
        $this->setFont('Arial', '', 9);
        $this->setFillColor(255, 255, 255);
        
        // $this->MultiCell($w, $h, $txt, $border, $align, $fill)
                
        $no = 1;
        $grandTotal     = 0;
        $grandPaid      = 0;
        
        foreach ($_selectInvoice as $r) {
            if($this->GetY() > 270){
                $this->AddPage();
            }
            $grandTotal += $r->TotalInvoice;
            $grandPaid += $r->Paid;
            
            $arr_cell_height = array(
                $this->NbLines(10, $no), 
                $this->NbLines(40, $r->NoInvoice), 
                $this->NbLines(40, $r->InvoiceDate),       
                $this->NbLines(50, $r->TotalInvoice),
                $this->NbLines(50, $r->Paid),
            );
            
            $hmax = max($arr_cell_height);
            
            $yval = $this->GetY();
            $this->SetXY(10, $yval);
            $this->MultiCell(10, ($hmax / $arr_cell_height[0]) * 6, $no, '', 'C', false);
            
            $this->SetXY(20, $yval);
            $this->MultiCell(40, ($hmax / $arr_cell_height[1]) * 6, $r->NoInvoice, '', 'L', false);
            
            $this->SetXY(60, $yval);
            $this->MultiCell(40, ($hmax / $arr_cell_height[2]) * 6, date('d-M', strtotime($r->InvoiceDate)), '', 'C', false);
            
            $this->SetXY(100, $yval);
            $this->MultiCell(50, ($hmax / $arr_cell_height[3]) * 6, number_format($r->TotalInvoice, 2), '', 'R', false);
            
            $this->SetXY(150, $yval);
            // $this->MultiCell(50, ($hmax / $arr_cell_height[4]) * 6, number_format($r->Paid, 2), '', 'R', false);
            $this->MultiCell(50, ($hmax / $arr_cell_height[4]) * 6, number_format($r->Paid, 2), '', 'R', false);

            $no++;
            // if
        // $this->Ln();
        }
        $this->Ln(5);
        
        $this->setFont('Arial', 'B', 9);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Cell(90, 5, 'Total Paid', 0, 0, 'L');
        $this->Cell(50, 5, number_format($grandTotal, 2), 0, 0, 'R');
        $this->Cell(50, 5, number_format($grandPaid, 2), 0, 1, 'R');
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

      
        // $this->Cell(5, 10, '', 1, 1 );
        $this->setFont('', 'I', 9);
        $this->Cell(1, 45, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition', 0, 0);
        $this->Cell(0, 55, 'copy is available upon request.', 0, 0);


    }
    
    private $widths;
    private $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($record_detail) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($record_detail); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $record_detail[$i]));
        }
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($record_detail); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $record_detail[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
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


    // if ($trans_date <= '19-12-2018') {
    //     $url='assets/zhl-kop.PNG';
    // }else{
    //     $url='assets/zhl-kop-new.PNG';
    // }

$pdf = new PDF1('P','mm','A4');
//$pdf->url = $url;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_selectInvoice,$_numberCheck);
$pdf->Output();