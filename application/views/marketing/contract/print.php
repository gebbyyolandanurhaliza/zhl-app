<?php

class PDF1 extends TFPDF {
    
	function set_status_id($deleteby){
		$this->status_id = $deleteby;
	}

	function set_revisi($rev_check,$rev_number){
		$this->rev_check = $rev_check;
		$this->rev_number = $rev_number;
	}

    //Page header            
    function Header() {
//		$this->Line(10, $this->GetY(), 200, $this->GetY());		
//        $this->Cell(1, 25, '', 'L', 0, 'L');
		$this->SetXY(10, $this->GetY());
		$this->Image('assets/PSG.png', 11, 12, 22, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(22, 10);
        $this->Cell(100, 10, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'C');
        $this->Cell(10);
        $this->setFont('Arial', 'B', 15);
        $this->Cell(58, 10, 'Sales Contract', 0, 1, 'L');
//		$this->Cell(1, 8, '', 'L', 1, 'L');
				        
        $this->setFont('Arial', '', 6);
        $this->Cell(22);
        $this->cell(100, 3, 'Reg. No.: 201537276N', 0, 0, 'C');
        $this->Cell(10);
        $this->Cell(58, 3, '', 0, 1, 'L');
//		$this->Cell(1, 3, '', 'L', 1, 'L');
		
        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Centre, Singapore 247909', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(10);
        $this->Cell(30, 4, 'Sales Contract No.', 0, 0, 'L');
        $this->Cell(28, 4, ': '.decode_str($_GET['no']), 0, 1, 'L');	
//		$this->Cell(1, 4, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 0, 'C');
        $this->setFont('Arial', 'B', 8);
        $this->Cell(10);
        $this->Cell(30, 4, 'Date', 0, 0, 'L');
        $this->Cell(28, 4, ': '.decode_str($_GET['dt']), 0, 1, 'L');
//		$this->Cell(1, 4, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(100, 4, 'www.sambugroup.com', 0, 0, 'C');
		
		$this->setFont('Arial', 'B', 8);
		$this->Cell(10);
		$this->Cell(30, 4, 'Page', 0, 0, 'L');
        $this->Cell(28, 4, ': '.$this->PageNo().' of {nb}', 0, 1, 'L');

        if($this->rev_check == 1){
	        $this->setFont('Arial', 'B', 8);
			$this->Cell(132);
			$this->Cell(30, 4, 'Revision', 0, 0, 'L');
	        $this->Cell(28, 4, ': '.$this->rev_number, 0, 1, 'L');
	    }
		
//		$this->Cell(68, 6, '', 0, 1);
////		$this->Cell(1, 6, '', 'L', 1, 'L');
		$this->Ln(5);
//		$this->Cell(200);
//		$this->Cell(1, 3, '', 'L', 1, 'L');
		
//		$this->Line(10, $this->GetY()-5, 200, $this->GetY()-5);
		if ($this->status_id != NULL){
			$this->SetFont('ARIAL', 'B', 50);
	        $this->SetTextColor(255,192,203);
	        $this->RotatedText(52, 190, 'D E L E T E D', 40);
		}
    }

    function Content($record_header,$record_detail,$record_document, $record_agent) {
        //
		
		$fontsize = 9;
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        
        $this->setFont('Arial', 'B', $fontsize);
        $this->cell(95, 4, 'TO', 0, 0, 'L', 1);
		
		//Untuk menampilkan agent yang nama agent & customer tidak sama
		$show_agent = 0;
		if (isset($record_agent->agent_name)){	
			$rec_agent = $record_agent->agent_name;
			
			if (strtoupper(trim($rec_agent)) == strtoupper(trim($record_header->customer_company_name))){
				$this->cell(95, 4, '', 0, 1, 'L', 1);				
			} else {
				$this->cell(95, 4, 'AGENT ', 0, 1, 'L', 1);
				$show_agent = 1;
			}
		} else {
			$this->cell(95, 4, '', 0, 1, 'L', 1);
			$rec_agent = '';
		}
		
		$arr_cell_height_name = array(
			$this->NbLines(95, $record_header->customer_company_name),			
			$this->NbLines(95, $rec_agent),
		);
		
		$hmax = max($arr_cell_height_name);
		$hline = 4;
        
       
        $this->setFont('NotoSans-Bold', '', $fontsize);
		//$this->SetFont('DejaVu', 'B', $fontsize);
		$y = $this->GetY();
		$this->SetXY(10, $y);
		$this->MultiCell(95, $hline, $record_header->customer_company_name, 0, 'L');
//        $this->MultiCell(95, ($hmax / $arr_cell_height_name[0]) * $hline, $record_header->customer_company_name, 0, 'L');
		$this->setFont('Arial', 'B', $fontsize);
		$this->SetXY(105, $y);
		if (isset($record_agent->agent_name)){
			
			if ($show_agent == 1){
				$this->MultiCell(95, $hline, $record_agent->agent_name, 0, 'L');
			} else {
				$this->Multicell(95, 4, '', 0, 'L');
			}
		} else {
			$this->Multicell(95, 4, '', 0, 'L');
		}
		
		$this->SetXY(205, $y);
		$this->MultiCell(1, $hline * $hmax, ' ');
        
		if (isset($record_agent->agent_name)){
			$agent_address = $record_agent->agent_address;
		} else {
			$agent_address = '';
		}
		
		$arr_cell_height = array(
			$this->NbLines(95, $record_header->customer_address),
			$this->NbLines(95, $agent_address),
		);
		
		$hmax = max($arr_cell_height);
		$hline = 4;
				
//        $this->setFont('Arial', '', $fontsize);
		$this->SetFont('NotoSans-Regular', '', $fontsize);
		$y = $this->GetY();
        $this->SetXY(10, $y);
		$this->MultiCell(95, $hline, $record_header->customer_address, 0, 'L');
//		$this->MultiCell(95, ($hmax / $arr_cell_height[0]) * $hline, $record_header->customer_address, 0);
//        $this->SetXY(105, 47);
		$this->SetXY(105, $y);
//		if (isset($record_agent->agent_name)){
		if ($show_agent == 1){
			$this->MultiCell(95, $hline, $record_agent->agent_address, 0, 'L');
//			$this->MultiCell(95, ($hmax / $arr_cell_height[1]) * $hline, $record_agent->agent_address, 0);
		} else {
			$this->MultiCell(95, $hline, '');
//			$this->MultiCell(95, ($hmax / $arr_cell_height[1]) * $hline, '', 0);
		}
		
		$this->setFont('Arial', '', $fontsize);
		$this->SetXY(205, $y);
		$this->MultiCell(1, $hline * $hmax, '');		
		
        $this->SetXY(10, $this->GetY()+4);
        $this->setFont('Arial', 'B', $fontsize);
        $this->cell(95, 4, 'Contact Person : '.$record_header->customer_contact_name, 0, 0, 'L', 1);
//		if (isset($record_agent->agent_name)){
		if ($show_agent == 1){
			$this->Cell(95, 4, 'Attn : '.$record_agent->agent_contact_name, 0, 1, 'L', 1);
		} else {
			$this->Cell(95, 4, '', 0, 1, 'L', 1);
		}
        
		$this->Line(10, $this->GetY()+2, 200, $this->GetY()+2);
		
//        $this->Line(10, 72, 250-50, 72);
        $this->Ln(3);
        $this->setFont('Arial', '', $fontsize);
		
		$y = $this->GetY();
		$this->SetXY(10, $y);
        $this->Multicell(27, 5, 'Customer Ref No');
		$this->SetXY(10+27, $y);
		$this->MultiCell(2, 5, ': ');
		$this->SetXY(10+27+2, $y);
        $this->MultiCell(66, 5, $record_header->customer_reference, 0, 'L');
        
		$this->SetXY(10+27+2+66, $y);
        $this->MultiCell(30, 5, 'Partial Shipment');
		$this->SetXY(10+27+2+66+30, $y);
        $this->MultiCell(65, 5, ': '.$record_header->partial_shipment);
				
		$hmax = $this->NbLines(66, $record_header->customer_reference);
		$this->SetXY(10+27+2+66+30+65, $y);
		$this->MultiCell(1, 5 * $hmax, '');
        //
        $this->cell(27, 5, 'Trading Term', 0, 0, 'L', 1);		
		$this->cell(68, 5, ': '.$record_header->trading_term_name, 0, 0, 'L', 1);
//        $this->cell(68, 5, ': '.$record_header->trading_term_name.' '.$record_header->shipment_from, 0, 0, 'L', 1);
        
        $this->cell(30, 5, 'Marine Insurance', 0, 0, 'L', 1);
        $this->cell(65, 5, ': '.$record_header->marine_insurance, 0, 1, 'L', 1);
        //
        $this->cell(27, 5, 'Shipment From', 0, 0, 'L', 1);
        $this->cell(68, 5, ': '.$record_header->shipment_from, 0, 0, 'L', 1);
        
        $this->cell(30, 5, 'Shipping Line', 0, 0, 'L', 1);
        $this->cell(65, 5, ': '.$record_header->shipping_name, 0, 1, 'L', 1);
        //
//        $this->cell(40, 4, 'Port of Discharge', 0, 0, 'L', 1);
//        $this->cell(55, 4, ': ', 0, 0, 'L', 1);
        
//        $this->cell(40, 4, '', 0, 0, 'L', 1);
//        $this->cell(55, 4, '', 0, 1, 'L', 1);
        //
        $this->cell(27, 5, 'Final Destination', 0, 0, 'L', 1);
		if ($record_header->destination ==''){
			$destination = $record_header->port_name;
		} else {
			$destination = $record_header->port_name.', '.$record_header->destination;
		}
        $this->cell(68, 5, ': '.$destination, 0, 0, 'L', 1);
        
        $this->cell(30, 5, 'Shipment Schedule', 0, 0, 'L', 1);
		$this->cell(2, 5, ': ', 0, 0, 'L');
        $this->MultiCell(63, 5, $record_header->shipment_schedule, 0);
        //
        $this->cell(27, 5, 'Container Loading', 0, 0, 'L', 1);
        $this->cell(68, 5, ': '.$record_header->container_name, 0, 0, 'L', 1);
		
		if (isset($record_agent->show_contract)){
			// Agent Commision
			if ($record_agent->com_percent == 0 && $record_agent->com_unit == 0){
				$this->cell(65, 5, ' ', 0, 1, 'L', 1);
			} else {
				$this->cell(30, 5, 'Agent Commission', 0, 0, 'L', 1);

				if ($record_agent->com_percent > 0){
					$this->cell(65, 5, ': '.number_format($record_agent->com_percent, 2, '.', ',').' %', 0, 1, 'L', 1);
				}
				if ($record_agent->com_unit > 0){
					$this->cell(65, 5, ': USD '.number_format($record_agent->com_unit, 2, '.', ',').' per unit', 0, 1, 'L', 1);
				}

				$this->cell(27, 5, '', 0, 0, 'L', 1);
				$this->cell(68, 5, '', 0, 0, 'L', 1);

				$this->cell(30, 5, 'Agent Reference', 0, 0, 'L', false);
				$this->cell(65, 5, ': '.$record_agent->agent_reference, 0, 1, 'L', 1);
			}
			

		} else {
			 $this->Ln(5);
		}
        //=========================
		
        $this->Ln(5);
		$this->setFont('Arial', 'B', $fontsize);
		$this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(2);
	
		$headerTable    = array(
            '#', 'Product Description', 'Brand', 'Pack Size', 'FCL' , 'Quantity', 'UOM', 'Price', 'Total ('.$record_header->currency_id.')'
        );
        $alightTable    = array(
            'C', 'L', 'C', 'C', 'C', 'R', 'C', 'C', 'R'
        );
        $w  = array(
            7,44,25,25,12,20,20,16,22
        );
//		$this->Cell(1, 5, '', 'L', 0);	// garis kiri
        for($i=0;$i<count($headerTable);$i++):
            $this->Cell($w[$i],5,$headerTable[$i],0,0,$alightTable[$i],false);
        endfor;
		$this->Cell(1, 5, '', '', 1);	//garis kanan
//		$this->Line(10, $this->GetY(), 200, $this->GetY());
		
        $this->Ln(2);
        $this->setFont('Arial', '', $fontsize);
        $this->SetWidths(array(7,44,25,25,12,20,20,16,22));
        $this->SetAligns(array('C', 'L', 'C', 'C', 'C', 'R', 'C', 'C', 'R'));
        $no = 1;
        $this->SetFillColor(255);
        foreach ($record_detail as $baris) {
//			if ($baris->container_20ft > 0){
//				$fcl = $baris->quantity / $baris->container_20ft;
//			} else {
//				$fcl = 0;
//			}
			
//			$tampil_product = ($baris->product_view) ? $baris->product_view : $baris->product_name;
			$tampil_product = ($baris->detail_product_desc) ? $baris->detail_product_desc : $baris->product_name;
			
            $this->Row(
				array(
					$no++,
					$tampil_product,
					$baris->brand_name,
					$baris->detail_pack_size,
//                        number_format($baris->uom_volume,0).' '.$baris->uom_volume_name.' x '.number_format($baris->per_packing,0).' '.$baris->packing_size.' per '.$baris->cma_uom_quantity_id,
					number_format($baris->fcl, 2),
					number_format($baris->quantity, 2),
					$baris->uom_quantity_name,					                        
					number_format($baris->price, 2),
					number_format($baris->total, 2)
            ));
			$this->Ln(2);
        }
        //$this->Ln();
        $this->SetXY(160, $this->GetY());
        $this->SetFont('Arial', 'B', $fontsize);
        $this->cell(16, 4, 'TOTAL', 0, 0, 'L', 1);
        $this->cell(25, 4, number_format($record_header->grand_total, 2), 0, 1, 'R', 1);
		
		$grand_total_float = floatval($record_header->grand_total);
        
        $this->Line(10, $this->GetY()+1, 250-50, $this->GetY()+1);
        $this->Ln(2);
        $this->SetFont('Arial', 'B', $fontsize);
        $this->cell(35, 4, 'Amount in Words: ', 0, 0, 'L', 1);
        $this->SetFont('Arial', '', $fontsize);
        $this->MultiCell(155, 4, $record_header->currency_say_in_words.' '.  convert_number_to_words($grand_total_float).' Only', 0, 'L');
        
        $this->Ln(3);
        $this->SetFont('Arial', 'B', $fontsize);
        $this->cell(35, 4, 'Payment Terms: ', 0, 1, 'L', 1);
		
		$payterm = ($record_header->payment_term == null) ? html_entity_decode($record_header->payment_terms, ENT_QUOTES) : html_entity_decode($record_header->payment_term, ENT_QUOTES);
		
        $this->SetFont('Arial', '', $fontsize);
        $this->cell(190, 4, str_replace('&#039', "'",$payterm) , 0, 1, 'L', 1);
        
        $this->Ln(3);
        $this->SetFont('Arial', 'B', $fontsize);
        $this->cell(35, 4, 'Bank Details: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', $fontsize);		
        $this->MultiCell(190, 4, $record_header->bank_currency_id.' account with '.$record_header->bank_name.',',0,'L');
		$this->MultiCell(190, 4, 'SWIFT : '.$record_header->bank_swift.', USD Account: '.$record_header->bank_account_number,0,'L');
		$this->MultiCell(190, 4, $record_header->bank_address, 0, 'L');
        
		if ($record_header->product_shelf_life){
			$this->Ln(3);
			$this->SetFont('Arial', 'B', $fontsize);
			$this->cell(35, 4, 'Shelf Life: ', 0, 1, 'L', 1);
			$this->SetFont('Arial', '', $fontsize);
			
			switch ($record_header->product_shelf_life_id) {
				case 1:
					$shelf_life	= $record_header->product_shelf_life;
					break;

				default:
					$shelf_life = $record_header->product_shelf_life.' from date of production.';
					break;
			}
			$this->cell(190, 4, $shelf_life, 0, 1, 'L', 1);
		}
        
        $this->Ln(3);
        $this->SetFont('Arial', 'B', $fontsize);
        $this->cell(60, 4, 'Document Provided by Seller: ', 0, 1, 'L', 1);
        $this->SetFont('Arial', '', $fontsize);
		$doc_name = '';
		foreach ($record_document as $doc){
			if ($doc_name == ''){
				$doc_name .= $doc->document_name;
			} else {
				$doc_name .= ', '.$doc->document_name;
			}
		}
		$y = $this->GetY();
		$this->SetXY(10, $y);
        $this->MultiCell(190, 4, $doc_name, 0, 'L', false);
        
		
		$this->Ln(3);
		$this->SetFont('Arial', 'B', $fontsize);
		$this->cell(35, 4, 'Remarks: ', 0, 1, 'L', 1);
		
		$this->SetFont('DroidSansFallback', '', $fontsize);
		if ($record_header->remark){
			$this->MultiCell(190, 4, $record_header->remark, 0, 'L');
		}
		
		$this->Ln(2);	// add space requested By Pohlin on 12 Okt 2016
		$this->SetFont('Arial', '', $fontsize);
		
		if ($this->GetY() > 230){	// last fixed 2016-12-01
			$this->AddPage();
		}
		$this->Cell(190, 4, 'Please return one copy of the Sales Contract duly signed and endorsed with company stamp for our file.', 0, 1);
        			
        $this->Ln(8);
		
//		if ($this->GetY() > 250){
//			$this->AddPage();
//		}
		
        $this->cell(70, 4, 'Seller ', 0, 0, 'L', 1);
        $this->cell(50, 4, '', 0, 0, 'L', 1);
        $this->cell(70, 4, 'Buyer: ', 0, 1, 'L', 1);
        
		$y = $this->GetY();
		
        $this->cell(70, 4, 'Pulau Sambu Singapore Pte Ltd', 0, 0, 'L', 1);
        $this->cell(50, 4, '', 0, 0, 'L', 1);
		$this->SetXY(10+70+50, $y);
        $this->multicell(70, 4, $record_header->customer_company_name, 0, 'L');
        
        $this->Ln(13);
        $this->Line(10, $this->GetY(), 80, $this->GetY());
        $this->Line(130, $this->GetY(), 200, $this->GetY());
        $this->Ln(0.5);
        $this->cell(70, 4, 'Mr Henry Fok (General Manager)', 0, 0, 'L', false);
        $this->cell(50, 4, '', 0, 0, 'L', false);
        $this->cell(70, 4, $record_header->customer_contact_name, 0, 1, 'L', false);
        $this->cell(70, 4, 'Date: ', 0, 0, 'L', false);
        $this->cell(50, 4, '', 0, 0, 'L', false);
        $this->cell(70, 4, 'Date: ', 0, 1, 'L', false);
		
		if (isset($record_agent->agent_name)){
        //
			if ($this->GetY() > 250){
				$this->AddPage();
			}
			$this->Ln();
			$this->cell(120, 4, '', 0, 0, 'L', false);
			$this->cell(70, 4, 'Agent', 0, 1, 'L', false);

			$this->cell(120, 4, '', 0, 0, 'L', false);
			$this->cell(70, 4, 'Inc : '.$record_agent->agent_name, 0, 1, 'L', false);

			$this->Ln(8);
			$this->Line(130, $this->GetY(), 200, $this->GetY());
			$this->cell(120, 4, '', 0, 0, 'L');
			$this->cell(70, 4, $record_agent->agent_contact_name, 0, 1, 'L');
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

$pdf = new PDF1('P','mm','A4');

$pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);
$pdf->AddFont('DejaVu', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
$pdf->AddFont('NotoSans-Bold', '', 'NotoSans-Bold.ttf', true);
$pdf->AddFont('NotoSans-Regular', '', 'NotoSans-Regular.ttf', true);

$pdf->set_status_id($record_header->deleted_by);
$pdf->set_revisi($record_header->revisi,$record_header->revisi_num);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($record_header,$record_detail,$record_document,$record_agent);
$pdf->Output();
