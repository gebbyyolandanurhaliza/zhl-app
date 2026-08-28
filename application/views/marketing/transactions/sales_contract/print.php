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
        $this->Cell(58, 10, 'Sales Contract', 0, 0, 'L');
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
        $this->Cell(30, 4, 'Sales Contract No.', 0, 0, 'L');
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

    function Content($record_header,$record_detail,$record_document) {
        //
        
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        
        $this->setFont('Arial', 'B', 8);
        $this->cell(95, 4, 'TO', 0, 0, 'L', 1);
		if ($record_header->agent_name){
			$this->cell(95, 4, 'AGENT', 0, 1, 'L', 1);
		} else {
			$this->cell(95, 4, '', 0, 1, 'L', 1);
		}
        
        $this->setFont('Arial', 'B', 8);
        $this->cell(95, 4, $record_header->customer_company_name, 0, 0, 'L', 1);
		if ($record_header->agent_name){
			$this->cell(95, 4, $record_header->agent_name, 0, 1, 'L', 1);
		} else {
			$this->cell(95, 4, '', 0, 1, 'L', 1);
		}
        
        $this->setFont('Arial', '', 8);
        $this->SetXY(10, $this->GetY());
        $this->MultiCell(95, 4, $record_header->customer_address.
                $record_header->customer_country_name, 0);
        $this->SetXY(105, 47);
		if ($record_header->agent_name){
			$this->MultiCell(95, 4, $record_header->agent_address.
				$record_header->agent_country_name.'Attn : '.$record_header->agent_contact_name, 0);
		} else {
			$this->MultiCell(95, 4, '', 0);
		}
		
        $this->Ln(5);
        $this->setFont('Arial', 'B', 8);
        $this->cell(95, 4, 'Contact Person : '.$record_header->customer_contact_name, 0, 1, 'L', 1);
        
		$this->Line(10, $this->GetY()+2, 200, $this->GetY()+2);
		
//        $this->Line(10, 72, 250-50, 72);
        $this->Ln(3);
        $this->setFont('Arial', '', 8);
        $this->cell(40, 4, 'Customer Ref No', 0, 0, 'L', false);
        $this->cell(55, 4, ': '.$record_header->customer_reference, 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Partial Shipment', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->partial_shipment, 0, 1, 'L', 1);
        //
        $this->cell(40, 4, 'Trading Term', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->trading_term_name, 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Marine Insurance', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->marine_insurance, 0, 1, 'L', 1);
        //
        $this->cell(40, 4, 'Shipment From', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->shipment_from, 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Shipment Line', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->shipping_line, 0, 1, 'L', 1);
        //
        $this->cell(40, 4, 'Port of Discharge', 0, 0, 'L', 1);
        $this->cell(55, 4, ': ', 0, 0, 'L', 1);
        
        $this->cell(40, 4, '', 0, 0, 'L', 1);
        $this->cell(55, 4, '', 0, 1, 'L', 1);
        //
        $this->cell(40, 4, 'Final Destination', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->final_destination, 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Shipment Schedule', 0, 0, 'L', 1);
        $this->MultiCell(55, 4, ': '.$record_header->shipment_schedule, 0);
        //
        $this->cell(40, 4, 'Container Loading', 0, 0, 'L', 1);
        $this->cell(55, 4, ': '.$record_header->container_name, 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Agent Commission', 0, 0, 'L', 1);
		if ($record_header->agen_commission){
			$this->cell(55, 4, ': '.number_format($record_header->agen_commission, 2, '.', ',').'%', 0, 1, 'L', 1);
		} else {
			$this->cell(55, 4, ': ', 0, 1, 'L', 1);
		}
        //
        $this->cell(40, 4, '', 0, 0, 'L', 1);
        $this->cell(55, 4, '', 0, 0, 'L', 1);
        
        $this->cell(40, 4, 'Agent Reference', 0, 0, 'L', false);
        $this->cell(55, 4, ': ', 0, 1, 'L', 1);
        
        //=========================
		
        $this->Ln(5);
		$this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->setFont('Arial', 'B', 8);
        $headerTable    = array(
            '#', 'Product Description', 'Brand', 'Pack Size', 'Quantity', 'FCL', 'UOM', 'Price', 'Total ('.$record_header->currency_id.')'
        );
        $alightTable    = array(
            'C', 'L', 'C', 'C', 'R', 'C', 'C', 'R', 'R'
        );
        $w  = array(
            5,44,20,25,20,15,20,15,24
        );
		$this->Cell(1, 5, '', 'L', 0);
        for($i=0;$i<count($headerTable);$i++):
            $this->Cell($w[$i],5,$headerTable[$i],0,0,$alightTable[$i],false);
        endfor;
		$this->Cell(1, 5, '', 'R', 1);
		$this->Line(10, $this->GetY(), 200, $this->GetY());
		
        $this->Ln(2);
        $this->setFont('Arial', '', 8);
        $this->SetWidths(array(5,44,20,25,20,15,20,15,24));
        $this->SetAligns(array('C', 'L', 'C', 'C', 'R', 'C', 'C', 'R', 'R'));
        $no = 1;
        $this->SetFillColor(255);
        foreach ($record_detail as $baris) {
			if ($baris->container_20ft > 0){
				$fcl = $baris->quantity / $baris->container_20ft;
			} else {
				$fcl = 0;
			}
            $this->Row(
                    array($no++,
                        $baris->product_name,
                        $baris->brand_name,
                        number_format($baris->uom_volume,0).' '.$baris->uom_volume_name.' x '.number_format($baris->per_packing,0).' '.$baris->packing_size.' per '.$baris->uom_quantity_name,
                        number_format($baris->quantity, 2),
                        number_format($fcl, 2),
                        $baris->uom_quantity_name,
                        number_format($baris->price, 2),
                        number_format($baris->total, 2)
            ));
        }
        //$this->Ln();
        $this->SetXY(160, $this->GetY());
        $this->SetFont('Arial', 'B', 8);
        $this->cell(15, 4, 'TOTAL', 0, 0, 'L', 1);
        $this->cell(25, 4, number_format($record_header->grand_total, 2), 0, 1, 'R', 1);
        
        $this->Line(10, $this->GetY()+1, 250-50, $this->GetY()+1);
        $this->Ln(2);
        $this->SetFont('Arial', 'B', 8);
        $this->cell(35, 4, 'Amount in Words: ', 0, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->cell(155, 4, $record_header->currency_say_in_words.' '.number_to_word($record_header->grand_total).' Only', 0, 1, 'L', 1);
        
        $this->Ln(1);
        $this->SetFont('Arial', 'BU', 8);
        $this->cell(35, 4, 'Payment Terms: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->cell(190, 4, $record_header->payment_terms, 0, 1, 'L', 1);
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->cell(35, 4, 'Bank Details: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', 8);		
        $this->MultiCell(190, 4, 
                $record_header->bank_country_name.', SWIFT: '.
                $record_header->bank_swift, 0, 'L');
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->cell(35, 4, 'Shelf Life: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->cell(190, 4, $record_header->product_shelf_life, 0, 1, 'L', 1);
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->cell(60, 4, 'Document Provided by Seller: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', 8);
		$doc_name = '';
		foreach ($record_document as $doc){
			if ($doc_name == ''){
				$doc_name .= $doc->document_name;
			} else {
				$doc_name .= ', '.$doc->document_name;
			}
		}
        $this->MultiCell(200, 4, $doc_name, 0, 'L', false);
        
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->cell(35, 4, 'Remarks: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(190, 4, $record_header->remark, 0, 'L');
        
        $this->Ln(4);
        $this->cell(70, 4, 'Seller', 0, 0, 'L', 1);
        $this->cell(50, 4, '', 0, 0, 'L', 1);
        $this->cell(70, 4, 'Buyer: ', 0, 1, 'L', 1);
        
        $this->cell(70, 4, 'Pulau Sambu Singapore Pte Ltd', 0, 0, 'L', 1);
        $this->cell(50, 4, '', 0, 0, 'L', 1);
        $this->cell(70, 4, $record_header->customer_company_name, 0, 1, 'L', 1);
        
        $this->Ln(8);
        $this->Line(10, $this->GetY(), 80, $this->GetY());
        $this->Line(130, $this->GetY(), 200, $this->GetY());
        $this->Ln(0.5);
        $this->cell(70, 4, 'Mr Henry Fok (General Manager)', 0, 0, 'L', false);
        $this->cell(50, 4, '', 0, 0, 'L', false);
        $this->cell(70, 4, $record_header->customer_contact_name, 0, 1, 'L', false);
        $this->cell(70, 4, 'Date: ', 0, 0, 'L', false);
        $this->cell(50, 4, '', 0, 0, 'L', false);
        $this->cell(70, 4, 'Date: ', 0, 1, 'L', false);
        
		if ($record_header->agent_name){
        //
			$this->Ln();
			$this->cell(120, 4, '', 0, 0, 'L', false);
			$this->cell(70, 4, 'Agent', 0, 1, 'L', false);

			$this->cell(120, 4, '', 0, 0, 'L', false);
			$this->cell(70, 4, 'Inc: ', 0, 1, 'L', false);

			$this->Ln(8);
			$this->Line(130, $this->GetY(), 200, $this->GetY());
			$this->cell(120, 4, '', 0, 0, 'L');
			$this->cell(70, 4, 'Mr', 0, 1, 'L');
			$this->cell(120, 4, '', 0, 0, 'L');
			$this->cell(70, 4, 'Date: ', 0, 1, 'L');
		} 
    }

  
//    function Footer() {
//        $this->setFont('Arial', 'B', 10);
//        //atur posisi 1.5 cm dari bawah
//        $this->SetY(-10);
//        //buat garis horizontal
//        $this->Line(10, $this->GetY(), 250-50, $this->GetY());
//        //nomor halaman
//        $this->Cell(0, 5, 'Page ' . $this->PageNo() . ' of {nb}', 0, 1, 'R');
//        
//    }

    
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
$pdf->Content($record_header,$record_detail,$record_document);
$pdf->Output();
