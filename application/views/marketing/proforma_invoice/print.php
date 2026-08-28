<?php

class PDF1 extends FPDF {
	
	function Header() {
		$this->SetXY(12, $this->GetY());
		$this->Ln(5);
		$this->Image('assets/pss-header.png', 10, 10, 180, 20, 'PNG');
//        $this->setFont('Arial', 'B', 10);
//        $this->SetTextColor(0, 51, 153);
//        $this->setFillColor(255, 255, 255);
		
		$this->Ln(23);
		
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
		
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(20);
		$this->Cell(150,4,'Proforma Invoice', 0, 1, 'C');
			
	}
	
	function Content($record_header, $record_detail) {
		
		$fontsize = 9;
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
		$this->setFont('Arial', '', $fontsize);
		
		$this->Ln(5);
		
		$h = 5;
		$w1=10;
		$w2=20;
		$w3=2;
		$w4=65;
		$w5=3;
		$w6=28;
		$w7=2;
		$w8=70;
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, 'Messrs');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, ': ');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, $record_header->customer_name);
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'Date');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, tgl_ind($record_header->pi_date));
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, 'Messrs');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, ': ');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, $record_header->customer_address, 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'Invoice No.');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, $record_header->pi_number);
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, 'Attn');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, ': ');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, $record_header->attn, 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'Terms of Payment', 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, $record_header->payment_term, 0, 'L');
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, '');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, '');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, '', 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'Shipment Term', 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, $record_header->shipment_term, 0, 'L');
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, 'From');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, ': ');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, $record_header->shipment_from, 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'Sales Contract No', 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, $record_header->contract_no, 0, 'L');
		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, 5, 'To');		
		$this->SetXY($w1+$w2, $y);
		$this->MultiCell($w3, $h, ': ');
		$this->SetXY($w1+$w2+$w3, $y);
		$this->MultiCell($w4, $h, $record_header->port_name.', '.$record_header->country_name, 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4, $y);
		$this->MultiCell($w5, $h, '');
		$this->SetXY($w1+$w2+$w3+$w4+$w5, $y);
		$this->MultiCell($w6, $h, 'ETD Singapore', 0, 'L');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6, $y);
		$this->MultiCell($w7, $h, ': ');
		$this->SetXY($w1+$w2+$w3+$w4+$w5+$w6+$w7, $y);
		$this->MultiCell($w8, $h, $record_header->etdsin, 0, 'L');
		
		$this->Ln(5);
		
		$this->Cell(10, $h, 'No', 'LRBT', 0, 'C');
		$this->Cell(80, $h, 'Product Description', 'LRBT', 0, 'C');
		$this->Cell(20, $h, 'Quantity', 'LRBT', 0, 'C');
		$this->Cell(20, $h, 'UOM', 'LRBT', 0, 'C');
		$this->Cell(25, $h, 'Unit Price US$', 'LRBT', 0, 'C');
		$this->Cell(30, $h, 'Amount US$', 'LRBT', 1, 'C');
		
		$no = 1;
		$grand_total = 0;
		foreach ($record_detail as $d){
			$this->Cell(10, $h, $no, 'L', 0, 'C');
			$this->Cell(80, $h, $d->product_name, 'L', 0, 'L');
			$this->Cell(20, $h, number_format($d->quantity,0), 'L', 0, 'R');
			$this->Cell(20, $h, $d->uom_quantity_name, 'L', 0, 'C');
			$this->Cell(25, $h, number_format($d->unit_price,2), 'L', 0, 'R');
			$this->Cell(30, $h, number_format($d->amount,2), 'LR', 1, 'R');
			
			$this->Cell(10, $h, '', 'LB', 0, 'C');
			$this->Cell(80, $h, $d->product_pack, 'LB', 0, 'L');
			$this->Cell(20, $h, '', 'LB', 0, 'R');
			$this->Cell(20, $h, '', 'LB', 0, 'L');
			$this->Cell(25, $h, '', 'LB', 0, 'R');
			$this->Cell(30, $h, '', 'LBR', 1, 'R');
			
			$grand_total += $d->amount;
			$no++;
		}
		
		$this->Cell(10, $h, '*', 'LB', 0, 'C');
		$this->Cell(80, $h, $record_header->misc_cost, 'LB', 0, 'L');
		$this->Cell(20, $h, '', 'LB', 0, 'R');
		$this->Cell(20, $h, '', 'LB', 0, 'L');
		$this->Cell(25, $h, '', 'LB', 0, 'R');
		$this->Cell(30, $h, number_format($record_header->misc_amount,2), 'LBR', 1, 'R');
		
		$grand_total += $record_header->misc_amount;
		
		$this->Ln(3);
		$this->setFont('Arial', 'B', $fontsize);
		$this->Cell(155, $h, 'INVOICE AMOUNT', 0, 0, 'C');
		$this->Cell(30, $h, 'USD '.  number_format($grand_total, 2), 'B', 1, 'C');
		
		$this->setFont('Arial', '', $fontsize);
		
		$this->Ln(5);
		
		$this->Cell(185, $h, 'TOTAL AMOUNT TO READ IN WORDS :', 0, 1);
		$this->SetXY(10, $this->GetY());
		$this->MultiCell(185, $h, $record_header->total_in_word, 0, 'L');
		
		$this->Ln(5);
		
		$this->Cell(90, $h, 'For Pulau Sambu Singapore Pte Ltd', 0, 0, 'L');
		$this->Cell(5);
		$this->Cell(90, $h, 'BANK DETAILS', 'LTR', 1, 'L');
		$this->Cell(95, $h, '');
		$this->Cell(90, $h, $record_header->bank_name, 'LR', 1, 'L');
		$this->Cell(95, $h, '');
		$this->Cell(90, $h, 'SWIFT : '.$record_header->bank_swift, 'LR', 1, 'L');
		$this->Cell(95, $h, '');
		$this->Cell(90, $h, 'USD Account No : '.$record_header->bank_account_number, 'LR', 1, 'L');
		$this->Cell(95, $h, '');
		$this->Cell(90, $h, 'for Account of Pulau Sambu Singapore Pte Ltd', 'LR', 1, 'L');
		
		$y = $this->GetY();
		$this->SetXY(10, $y);
		$this->MultiCell(95, $h, $record_header->firstname.' '.$record_header->lastname, 0, 'L');
		$this->SetXY(105, $y);
		$this->MultiCell(90, $h, 'Intermediary Bank :  '.$record_header->bank_address, 'LRB', 'L');
		
		$y = $this->GetY() + 3;
		$this->SetXY(10, $y);
		$this->MultiCell(185, $h, $record_header->remark, 0, 'L');
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

$pdf = new PDF1('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($record_header, $record_detail);
$pdf->Output();
