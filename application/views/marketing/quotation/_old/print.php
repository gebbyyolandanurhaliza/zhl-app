<?php

class PDF1 extends FPDF {
	
	//Page header            
    function Header() {
		$this->Line(10, $this->GetY(), 200, $this->GetY());		
        $this->Cell(1, 25, '', 'L', 0, 'L');
		$this->SetXY(10, $this->GetY());
		$this->Image('assets/PSG.png', 11, 12, 22, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(22, 10);
        $this->Cell(100, 10, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'C');
        $this->Cell(10);
        $this->setFont('Arial', 'B', 15);
        $this->Cell(58, 10, 'Sales Quotation', 0, 0, 'L');
		$this->Cell(1, 8, '', 'L', 1, 'L');
				        
        $this->setFont('Arial', '', 6);
        $this->Cell(22);
        $this->cell(100, 3, 'Reg. No.: 201537276N', 0, 0, 'C');
        $this->Cell(10);
        $this->Cell(58, 3, '', 0, 0, 'L');
		$this->Cell(1, 3, '', 'L', 1, 'L');
		
        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(10);
        $this->Cell(30, 4, 'Sales Quotation No.', 0, 0, 'L');
        $this->Cell(28, 4, ': '.decode_str($_GET['no']), 0, 0, 'L');	
		$this->Cell(1, 4, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(10);
        $this->Cell(30, 4, 'Date', 0, 0, 'L');
        $this->Cell(28, 4, ': '.decode_str($_GET['dt']), 0, 0, 'L');
		$this->Cell(1, 4, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, 'www.sambugroup.com', 0, 0, 'C');
		$this->Cell(68, 4, '', 0, 0);
		$this->Cell(1, 6, '', 'L', 1, 'L');
		$this->Ln(5);
//		$this->Cell(200);
//		$this->Cell(1, 3, '', 'L', 1, 'L');
		
		$this->Line(10, $this->GetY()-5, 200, $this->GetY()-5);
		
    }
	
	function Content($record_header,$record_detail) {
		$this->SetTextColor(0, 0, 0);
      
        $this->setFont('Arial', 'B', 9);
		$this->setFillColor(230, 230, 230);
        $this->cell(95, 5, 'TO', 'TLRB', 1, 'L', true);
		
		$this->setFont('Arial', 'B', 9);
		$this->setFillColor(255, 255, 255);
        $this->cell(95, 5, $record_header->customer_company_name, 0, 1, 'L', false);
		
		$this->Ln(1);
		
		$this->setFont('Arial', '', 9);
        $this->SetXY(10, $this->GetY());
        $this->MultiCell(95, 4, $record_header->customer_address, 0);
		
		$this->Ln(10);
		
		$this->Cell(40, 5, 'Customer Ref No');
		$this->Cell(100, 5, ':', 0, 1);
		
		$this->Cell(40, 5, 'Container Loading');
		$this->Cell(100, 5, ': '.$record_header->container_name, 0, 1);
		
		$this->Cell(40, 5, 'Currency');
		$this->Cell(100, 5, ': '.$record_header->currency_id, 0, 1);
		
		$this->Cell(40, 5, 'Shipping Term');
		$this->Cell(100, 5, ': '.$record_header->trading_term_name, 0, 1);
		
		$this->Cell(40, 5, 'Shipping Mode');
		$this->Cell(100, 5, ': '.$record_header->shipping_mode, 0, 1);
		
		$this->Cell(40, 5, 'Destination');
		$this->Cell(100, 5, ': '.$record_header->port_name.', '.$record_header->destination_country, 0, 1);
		
		// Detail Product
		// Table Title
		$this->Ln(5);
//		$this->Line(10, $this->GetY(), 200, $this->GetY());		
        $this->setFont('Arial', 'B', 9);
		$this->setFillColor(230,230,230);
		$this->Cell(8, 7, 'No', 'TLR', 0, 'C', true);
		$this->Cell(40, 7, 'Product / Packing', 'TLR', 0, 'L', true);
		$this->Cell(20, 7, 'Brand', 'TLR', 0, 'C', true);
		$this->Cell(15, 7, 'Cus Ref', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Pack Size', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Quantity', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'UOM', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Price', 'TLR', 0, 'C', true);
		$this->Cell(27, 7, 'Total', 'TLR', 1, 'C', true);
		
		$this->Line(10, $this->GetY(), 200, $this->GetY());
       
//		$this->Ln(1);
		$this->setFont('Arial', '', 9);
		$this->setFillColor(255, 255, 255);
		
//		$this->MultiCell($w, $h, $txt, $border, $align, $fill)
				
		$no = 1;
		$grandtotal = 0;
		
		foreach ($record_detail as $r) {
			$total = $r->price * $r->quantity;
			$grandtotal += $total;
			
			$arr_cell_height = array(
				$this->NbLines(8, $no), 
				$this->NbLines(40, $r->product_name), 
				$this->NbLines(20, $r->brand_name),
				$this->NbLines(20, floatval($r->uom_volume).' '.$r->uom_volume_name.' per '.$r->cma_uom_quantity_id),		
				$this->NbLines(20, $record_header->currency_id.' '.$r->price),
				$this->NbLines(27, $record_header->currency_id.' '.number_format($total, 2)),
			);
			
			$hmax = max($arr_cell_height);
			
			$yval = $this->GetY();
			$this->SetXY(10, $yval);
			$this->MultiCell(8, ($hmax / $arr_cell_height[0]) * 5, $no, 'LB', 'C', false);
			
			$this->SetXY(18, $yval);
			$this->MultiCell(40, ($hmax / $arr_cell_height[1]) * 5, $r->product_name, 'LB', 'L', false);
			
			$this->SetXY(58, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[2]) * 5, $r->brand_name, 'LB', 'C', false);
			
			$this->SetXY(78, $yval);
			$this->MultiCell(15, ($hmax / $arr_cell_height[0]) * 5, '', 'LB', 'C', false);
			
			$this->SetXY(93, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[3]) * 5, floatval($r->uom_volume).' '.$r->uom_volume_name.' per '.$r->cma_uom_quantity_id, 'LB', 'C', false);
			
			$this->SetXY(113, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[0]) * 5, $r->quantity, 'LB', 'C', false);
			
			$this->SetXY(133, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[0]) * 5, $r->uom_quantity_name, 'LB', 'C', false);
			
			$this->SetXY(153, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[4]) * 5, $record_header->currency_id.' '.$r->price, 'LB', 'R', false);
			
			$this->SetXY(173, $yval);
			$this->MultiCell(27, ($hmax / $arr_cell_height[5]) * 5, $record_header->currency_id.' '.number_format($total, 2), 'LBR', 'R', false);
			
			$no++;
			
//			$this->Ln();
		}
		$this->Ln(1);
		
		$this->setFont('Arial', 'B', 9);
		$this->Cell(150, 5, 'Total Amount', 0, 0, 'R');
		$this->Cell(40, 5, $record_header->currency_id.' '.number_format($grandtotal, 2), 0, 1, 'R');
		
		$this->Ln(5);		
		
//		$this->Cell($w, $h, $txt, $border, $ln, $align, $fill)
		$this->setFont('Arial', 'BU', 9);
		$this->Cell(210, 5, 'Payment Terms', 0, 1 );
		
		$this->setFont('Arial', '', 9);
		$this->Cell(210, 5, $record_header->payment_terms, 0, 1 );
		
//		$this->Cell(210, 5, 'Shipping Period  :', 0, 1 );
//		$this->Cell(210, 5, ' ', 0, 1 );
		
		$this->Ln(2);
		
		$this->setFont('Arial', 'BU', 9);
		$this->Cell(210, 5, 'Remarks', 0, 1 );
		
		$this->Ln(2);
		
		$this->setFont('Arial', '', 9);
		$this->MultiCell(210, 5, $record_header->quotation_remark, 0, 'L' );
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
$pdf->Content($record_header,$record_detail);
$pdf->Output();
