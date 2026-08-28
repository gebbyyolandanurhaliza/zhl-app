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
		
		$this->SetFont('times', 'B', 20);
		$this->Cell(20);
		$this->Cell(150,4,'Proforma Invoice', 0, 1, 'C');
			
	}
	
	function Content($record_header, $record_detail, $record_misc, $con_hdr) {
		
		$fontsize = 9;
		$fontname = 'times';
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
		$this->setFont($fontname, '', $fontsize);
		
		$this->Ln(5);
	
		$h  = 4;
		$w1 = 10;
		$w2 = 20;
		$w3 = 2;
		$w4 = 65;
		$w5 = 3;
		$w6 = 28;
		$w7 = 2;
		$w8 = 70;
		
//-->	Messrs - date		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, 'Messrs');		
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
		
		$arr_cell_height = array(
			$this->NbLines(65, $record_header->customer_name),
			$this->NbLines(70, tgl_ind($record_header->pi_date)),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
//-->	Address - Invoice No		
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, 'Messrs');		
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
		
		$arr_cell_height = array(
			$this->NbLines(65, $record_header->customer_address),
			$this->NbLines(70, $record_header->pi_number),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
//-->	Attn - Terms of payment				
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, 'Attn');		
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
		
		$arr_cell_height = array(
			$this->NbLines(65, $record_header->attn),
			$this->NbLines(70, $record_header->payment_term),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
//-->	Shipment term
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, '');		
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
		
		$arr_cell_height = array(
			$this->NbLines(70, $record_header->shipment_term),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
//-->	From - Ssales Contract No
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, 'From');		
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
		
		$arr_cell_height = array(
			$this->NbLines(65, $record_header->shipment_from),
			$this->NbLines(70, $record_header->contract_no),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
//-->	To - Etd Sin
		$y = $this->GetY();
		$this->SetXY($w1, $y);
		$this->MultiCell($w2, $h, 'To');		
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
		
		$arr_cell_height = array(
			$this->NbLines(65, $record_header->port_name.', '.$record_header->country_name),
			$this->NbLines(70, $record_header->etdsin),
		);
		
		$hmax = max($arr_cell_height);
		$this->SetXY(200, $y);
		$this->MultiCell(1, $h * $hmax, '');
		
		$this->Ln(5);
		
		$wd = array(10, 85, 20, 20, 25, 25, 1);
		
		$this->Cell($wd[0], $h+3, 'No', 'LRBT', 0, 'C');
		$this->Cell($wd[1], $h+3, 'Product Description', 'LRBT', 0, 'C');
		$this->Cell($wd[2], $h+3, 'Quantity', 'LRBT', 0, 'C');
		$this->Cell($wd[3], $h+3, 'UOM', 'LRBT', 0, 'C');
		$this->Cell($wd[4], $h+3, 'Unit Price US$', 'LRBT', 0, 'C');
		$this->Cell($wd[5], $h+3, 'Amount US$', 'LRBT', 1, 'C');
		
		$no = 1;
		$grand_total = 0;
		
		$this->SetWidths($wd);
        $this->SetAligns(array('C', 'L', 'C', 'C', 'C', 'R', ''));
		
		$this->CheckPageBreak($h);
		
		$this->Row(
			array(
				'',
				'For : '.$con_hdr->total_fcl.' x '.$con_hdr->container_name,
				'',
				'',
				'',
				'',
				''
			)
		);
		
		$this->Row(
			array(
				'',
				'Order ref : ',
				'',
				'',
				'',
				'',
				''
			)
		);
		
		$this->RowSpace($wd);
		
		foreach ($record_detail as $d){
			$this->Row(
				array(
					$no, 
					$d->pi_product_view,
					number_format($d->quantity,0),
					$d->uom_quantity_name,
					number_format($d->price,2),
					number_format($d->total,2),
					''
				)
			);
			
			$this->RowSpace($wd);
			
			$grand_total += $d->total;
			$no++;
		}
		
		foreach ($record_misc as $m){
			$this->Cell(10, $h, '', 'L', 0, 'C');
			$this->Cell(85, $h, $m->misc_cost, 'L', 0, 'L');
			$this->Cell(20, $h, '', 'L', 0, 'R');
			$this->Cell(20, $h, '', 'L', 0, 'C');
			$this->Cell(25, $h, '', 'L', 0, 'R');
			$this->Cell(25, $h, number_format($m->misc_amount,2), 'LR', 1, 'R');
			
			$grand_total += $m->misc_amount;
		}
		
		$this->RowSpace($wd);
		$this->Line(10, $this->GetY(), 195, $this->GetY());
		
		
		$this->Ln(3);
		$this->setFont($fontname, 'B', $fontsize);
		$this->Cell(160,$h, 'INVOICE AMOUNT', 0, 0, 'C');
		$this->Cell(25, $h, 'USD '.  number_format($grand_total, 2), 'B', 1, 'C');
		
		$this->setFont($fontname, '', $fontsize);
		
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
		$this->Line(11, $y-1, 60, $y-1);
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
	private $borders;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }
	
	function SetBorders($b){
		//Set the array of column borders
        $this->borders = $b;
	}
	
	function RowSpace($arr_width){
		$y = $this->GetY();
		$this->CheckPageBreak(4);
		for ($i = 0; $i < count($arr_width); $i++){
			$x = $this->GetX();
			$this->Rect($x, $y, 0, 2);
			$this->SetXY($x + $this->widths[$i], $y);
		}
		$this->Ln(2);
	}

    function Row($detail) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($detail); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $detail[$i]));
        }
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($detail); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, 0, $h);
            //Print the text
            $this->MultiCell($w, 4, $detail[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
		//Go to the next line
        $this->Ln($h);
		
//		//Issue a page break first if needed
//        $this->CheckPageBreak($h);
//		// Add Line Space
//		for ($i = 0; $i < count($record_detail); $i++) {
//            $w = $this->widths[$i];
//            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//            //Save the current position
//            $x = $this->GetX();
//            $y = $this->GetY();
//            //Draw the border
//            $this->Rect($x, $y, 0, 2);
//            //Print the text
//            $this->MultiCell($w, 2, '', 0, $a);
//            //Put the position to the right of the cell
//            $this->SetXY($x + $w, $y);
//        }
//        //Go to the next line
//        $this->Ln(2);
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
$pdf->Content($record_header, $record_detail, $record_misc, $con_hdr);
$pdf->Output();
