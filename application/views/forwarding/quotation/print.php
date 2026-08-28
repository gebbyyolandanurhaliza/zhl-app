<?php

class PDF1 extends FPDF {
	
	//Page header            
    function Header() {
		
       
		$this->SetXY(10, $this->GetY());
		$this->Image('assets/zhl-kop.PNG', 10, 10, 185, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);	        
        
		$this->Ln(35);

		
		
		
    }
	
	function Content($record_header,$record_detail,$cbo_port,$cbo_currency) {
		$this->SetTextColor(0, 0, 0);
      
        $this->setFont('Arial', 'B', 9);
		$this->setFillColor(230, 230, 230);
        $this->cell(95, 5, 'TO', 'TLRB', 1, 'L', true);
		
		$this->setFont('Arial', 'B', 9);
		$this->setFillColor(255, 255, 255);
        $this->cell(95, 5, $record_header->customer_name, 0, 1, 'L', false);
		
		$this->Ln(1);
		
		$this->setFont('Arial', '', 9);
        $this->SetXY(10, $this->GetY());
        $this->MultiCell(95, 4, $record_header->customer_address, 0);
		
		$this->Ln(10);
		
		$this->Cell(40, 5, 'Quotation No');
		$this->Cell(100, 5, ': '.$record_header->quotation_number, 0, 1);

		// $this->Cell(40, 5, 'Customer Ref No');
		// $this->Cell(100, 5, ': '.$record_header->customer_reference, 0, 1);
		
		$this->Cell(40, 5, 'Sales Person');
		$this->Cell(100, 5, ': '.$record_header->sales_firstname.' '.$record_header->sales_lastname, 0, 1);
		
		$this->Cell(40, 5, 'Document Date');
		$this->Cell(100, 5, ': '.tgl_ind($record_header->document_date), 0, 1);

		$this->Cell(40, 5, 'Validity Date');
		$this->Cell(100, 5, ': '.tgl_ind($record_header->validity_date), 0, 1);

		$this->Cell(40, 5, 'Port Of Loading');
		$this->Cell(100, 5, ': '.$record_header->shipment_from, 0, 1);

		$this->Cell(40, 5, 'Port of Discharge');
		$this->Cell(100, 5, ': '.$record_header->port_id, 0, 1);
		
		
		$this->Ln(5);

        $this->setFont('Arial', 'B', 9);
		$this->setFillColor(230,230,230);
		$this->Cell(8, 7, 'No', 'TLR', 0, 'C', true);
		$this->Cell(25, 7, 'Service Type', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Port', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Charge Type', 'TLR', 0, 'C', true);
		$this->Cell(30, 7, 'Description	', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Currency', 'TLR', 0, 'C', true);
		$this->Cell(16, 7, 'Rate SGD', 'TLR', 0, 'C', true);
		$this->Cell(16, 7, 'Rate USD', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Price', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Quantity', 'TLR', 1, 'C', true);
		
		$this->Line(10, $this->GetY(), 205, $this->GetY());
       

		$this->setFont('Arial', '', 9);
		$this->setFillColor(255, 255, 255);
		

				
		$no = 1;
		$grandtotal = 0;
		$portname='';
		$currency_name='';
		
		foreach ($record_detail as $r) {
			foreach ($cbo_port as $key) {
				if ($r->port_service == $key->port_id){
					$portname=$key->port_name;
				}
			}

			foreach ($cbo_currency as $val) {
				if ($r->currency == $val->currency_id){
					$currency_name = $val->currency_symbol . ' - ' . $val->currency_name;
				}
			}
			
			$arr_cell_height = array(
				$this->NbLines(8, $no), 
				$this->NbLines(25, $r->service_type), 
				$this->NbLines(20, $portname),
				$this->NbLines(20, $r->charge_id),		
				$this->NbLines(30, $r->desc),		
				$this->NbLines(20, $currency_name),
				$this->NbLines(16, $r->rate_sgd),
				$this->NbLines(16, $r->rate_usd),
				$this->NbLines(20, $r->price),
				$this->NbLines(20, $r->quantity)
			);
			
			$hmax = max($arr_cell_height);
			
			$yval = $this->GetY();
			$this->SetXY(10, $yval);
			$this->MultiCell(8, ($hmax / $arr_cell_height[0]) * 5, $no,'LB', 'C', false);
			
			$this->SetXY(10+8+25, $yval);
			$this->MultiCell(20,($hmax / $arr_cell_height[2]) * 5, $portname,'LB', 'C', false);
			
			$this->SetXY(10+8+25+20, $yval);
			$this->MultiCell(20,($hmax / $arr_cell_height[3]) * 5, $r->charge_id,'LB', 'C', false);
			
			$this->SetXY(10+8+25+20+20, $yval);
			$this->MultiCell(30,($hmax / $arr_cell_height[4]) * 5, $r->desc,'LB', 'C', false);
			
			$this->SetXY(10+8+25+20+20+30, $yval);
			$this->MultiCell(20,($hmax / $arr_cell_height[5]) * 5, $currency_name,'LB', 'C', false);
			
			$this->SetXY(10+8+25+20+20+30+20, $yval);
			$this->MultiCell(16,($hmax / $arr_cell_height[6]) * 5, $r->rate_sgd,'LB', 'C', false);
			
			$this->SetXY(10+8+25+20+20+30+20+16, $yval);
			$this->MultiCell(16,($hmax / $arr_cell_height[7]) * 5, $r->rate_usd,'LB', 'C', false);

			$this->SetXY(10+8+25+20+20+30+20+16+16, $yval);
			$this->MultiCell(20,($hmax / $arr_cell_height[8]) * 5, $r->price,'LB', 'C', false);

			$this->SetXY(10+8+25+20+20+30+20+16+16+20, $yval);
			$this->MultiCell(20,($hmax / $arr_cell_height[9]) * 5, $r->quantity,'LBR', 'C', false);

			$this->SetXY(18, $yval);
			$this->MultiCell(25,($hmax / $arr_cell_height[1]) * 5, $r->service_type,'LB', 'C', false);


			// $y2 = $this->GetY();
            // $this->Line(10, $yval, 10, $y2);
            // $this->Line(18, $yval, 18, $y2);
            // $this->Line(43, $yval, 43, $y2);
            // $this->Line(63, $yval, 63, $y2);
            // $this->Line(83, $yval, 83, $y2);
            // $this->Line(113, $yval, 113, $y2);
            // $this->Line(133, $yval, 133, $y2);
            // $this->Line(149, $yval, 149, $y2);
            // $this->Line(165, $yval, 165, $y2);
            // $this->Line(185, $yval, 185, $y2);
            // $this->Line(205, $yval, 205, $y2);
            // $this->Line(10, $y2, 205, $y2);
			$no++;
			

		}
		$this->Ln(5);
		
		$this->setFont('Arial', 'B', 9);
		$this->Cell(150, 5, 'Total Amount', 0, 0, 'R');
		$this->Cell(40, 5, number_format($record_header->final_total, 2), 0, 1, 'R');
		
		$this->Ln(5);		
		

		$this->setFont('Arial', 'BU', 9);
		$this->Cell(210, 5, 'Payment Terms', 0, 1 );
		
		$payterm =  $record_header->payment_term;
		
		$this->setFont('Arial', '', 9);
		$this->Cell(210, 5, html_entity_decode($payterm, ENT_QUOTES), 0, 1 );
		
		
		
		$this->Ln(2);
		
		$this->setFont('Arial', 'BU', 9);
		$this->Cell(210, 5, 'Remarks', 0, 1 );
		
		$this->Ln(2);
		
		$this->setFont('Arial', '', 9);
		$this->MultiCell(190, 5, $record_header->quotation_remark, 0, 'J' );
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
$pdf->Content($record_header,$record_detail,$cbo_port,$cbo_currency);
$pdf->Output();
