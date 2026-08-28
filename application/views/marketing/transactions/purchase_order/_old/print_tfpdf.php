<?php

class PDF1 extends TFPDF {

	//Page header            
    function Header() {
		$this->Line(10, $this->GetY(), 200, $this->GetY());	
		$this->Cell(1, 23, '', 'L', 0, 'L');
		$this->SetXY(10, $this->GetY());
        $this->Image('assets/PSG.png', 12, 13, 20, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
		$this->Cell(190, 2, '', 'R', 1, 'L');
        $this->Cell(22);
        $this->Cell(121, 5, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'C', 1);
        $this->Cell(8);
        $this->setFont('Arial', 'B', 10);
        $this->Cell(15, 5, 'Date', 0, 0, 'L', 1);		
		$this->Cell(24, 5, ': '.  decode_str($_GET['dt']), 'R', 1, 'L', false);
		
        $this->setFont('Arial', '', 6);
        $this->Cell(22);
        $this->Cell(120, 3, 'Reg. No.: 201537276N', 0, 0, 'C');
		$this->Cell(48, 3, '', 0, 0);
		$this->Cell(1, 3, '', 'L', 1);

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(120, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Centre, Singapore 247909', 0, 0, 'C', false);
        $this->Cell(9);
        $this->setFont('Arial', 'B', 10);
        $this->Cell(15, 4, 'Page', 0, 0, 'L', false);
        $this->Cell(24, 4, ': '.$this->PageNo().' of {nb}', 0, 0, 'L', false);
		$this->Cell(1, 4, '', 'L', 1, 'L');
		
        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(120, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 0, 'C', false);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(10);
        $this->Cell(38, 4, '', 0, 0, 'L', false);
		$this->Cell(1, 4, '', 'L', 1, 'L');

        $this->setFont('Arial', '', 8);
        $this->Cell(22);
        $this->cell(120, 4, 'www.sambugroup.com', 0, 0, 'C', 1);
		$this->Cell(48, 3, '', 0, 0);
		$this->Cell(1, 3, '', 'L', 1);
        
		$this->Cell(190, 2, '', 'R', 1, 'L');
		
		$this->Ln(5);
		
		$this->Line(10, $this->GetY()-5, 200, $this->GetY()-5);
		
    }
	
	function Content($rec_hdr,$rec_dtl,$rec_doc, $rec_agent) {
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
		
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(20);
		$this->Cell(150,4,'Purchase Order - PSS', 0, 1, 'C');
		
		$this->Ln(8);
		
		$this->setFont('Arial', '', 9);
		$this->cell(30, 5, 'PO No', 0, 0, 'L', 1);
		$this->SetFont('Arial', 'B', 9);
        $this->cell(65, 5, ': '.$rec_hdr->po_number, 0, 0, 'L', 1);
		$this->SetFont('Arial', '', 9);
        $this->cell(26, 5, 'Factory', 0, 0, 'L', 1);
		$this->cell(70, 5, ': '.$rec_hdr->factory_name, 0, 1, 'L', 1);
		
		$this->SetFont('Arial', '', 9);
		
		$arr_cell_height = array(
			$this->NbLines(65, $rec_hdr->customer_name),
			$this->NbLines(70, $rec_hdr->buyer_si),
		);
		
		$hmax = max($arr_cell_height);
		
		$y1 = $this->GetY();
		$this->SetXY(10, $y1);		
		$this->MultiCell(30, 5, 'Customer', 0, 'L');	
		$this->SetXY(10+30, $y1);
		$this->MultiCell(2, 5, ': ');
		$this->SetXY(10+30+2, $y1);
        $this->MultiCell(63, 5, $rec_hdr->customer_name, 0, 'L',false);
		
		$this->SetXY(10+30+65, $y1);
		$this->MultiCell(26,5, 'Buyer SI', 0, 'L',false);
		$this->SetXY(10+30+65+26, $y1);
		$this->MultiCell(69, 5, ': '.$rec_hdr->buyer_si,0, 'L',false);
		
		$this->SetXY(200, $y1);
		$this->MultiCell(1, 5 * $hmax, '');
		$this->SetFont('Arial', '', 9);
		
		if (isset($rec_agent->agent_name)){
			$agent_name = $rec_agent->agent_name;
			$y = $this->GetY();
			$this->SetXY(10, $y);		
			$this->MultiCell(30, 5, 'Agent', 0, 'L');	
			$this->SetXY(10+30, $y);
			$this->MultiCell(2, 5, ': ');
			$this->SetXY(10+30+2, $y);
			$this->MultiCell(63, 5, $agent_name, 0, 'L',false);
		}
		
		$y = $this->GetY();
		$this->SetXY(10, $y);
		$this->MultiCell(30, 5, 'Contract Date', 0, 'L', false);
		
		$this->SetXY(10+30, $y);
        $this->Multicell(65, 5, ': '.tgl_ind($rec_hdr->contract_date), 0, 'L', false);
		
//		$this->SetXY(10+30, $y);
//        $this->Multicell(65, 5, ': '.tgl_ind($rec_hdr->contract_date), 0, 'L', false);
		
		$this->SetXY(10+30+65, $y);
		$this->Multicell(27, 5, 'Final Destination', 0, 'L', false);
		
		if ($rec_hdr->destination_country){
			$destination = $rec_hdr->port_name.', '.$rec_hdr->destination_country;
		} else {
			$destination = $rec_hdr->port_name;
		}
		
		$this->SetXY(10+30+65+26, $y);
		$this->Multicell(69, 5, ': '.$destination, 0, 'L');
//		$this->cell(70, 5, ': '.$rec_hdr->port_name.', '.$rec_hdr->destination, 0, 1, 'L', 1);
		
		$hmax = $this->NbLines(65, $destination);
		$this->SetXY(200, $y);
		$this->MultiCell(1, 5 * $hmax, '');
		
		$y = $this->GetY();
		
		$this->SetFont('Arial', '', 9);
		$this->SetXY(10, $y);
		$this->MultiCell(30, 5, 'Contract Number', 0, 'L', false);		
		$this->SetXY(10+30, $y);
        $this->MultiCell(65, 5, ': '.$rec_hdr->contract_no, 0, 'L', false);
		$this->SetXY(10+30+65, $y);
		$this->MultiCell(26, 5, 'Shipping Date', 0, 'L', false);
		$this->SetXY(10+30+65+26, $y);
		$this->MultiCell(69, 5, ': '.tgl_ind($rec_hdr->ship_date), 0, 'L', false);
		
		$this->SetFont('Arial', '', 9);
		$this->cell(30, 5, 'Shipping Mark', 0, 0, 'L', 1);		
        $this->cell(65, 5, ': '.$rec_hdr->ship_mark, 0, 0, 'L', 1);
		$this->cell(26, 5, 'Ocean Freight', 0, 0, 'L', 1);
		$this->cell(70, 5, ': '.$rec_hdr->ocean_freight, 0, 1, 'L', 1);
		
		$this->Cell(210, 5, '', 0, 1);
		
		$this->SetFont('Arial', 'B', 9);
		$this->cell(30, 5, 'Remarks', 0, 0, 'L', false);
		$this->cell(2, 5, ': ', 0, 0, 'L', false);
//		$this->SetFont('Arial', '', 9);
		$this->SetFont('DroidSansFallback', '', $fontsize);
		$this->MultiCell(158, 5, $rec_hdr->remark, 0, 'L', false);
		
		$this->SetFont('Arial', '', 9);
		$this->Cell(210, 5, '', 0, 1);
		$this->Cell(30, 5, 'Certificate Required', 0, 0, 'L', 1);
		$doc_name = '';
		foreach ($rec_doc as $doc){
			if ($doc_name == ''){
				$doc_name .= $doc->document_name;
			} else {
				$doc_name .= ', '.$doc->document_name;
			}
		}
		$this->Cell(2, 5, ':', 0, 0, 'L');
		$this->MultiCell(158, 5, $doc_name, 0, 'L', false);
		
		$this->CheckPageBreak(5);
		
		// Detail Product
		// Table Title
		$this->Ln(5);
		$this->Line(10, $this->GetY(), 200, $this->GetY());		
        $this->setFont('Arial', 'B', 10);
		$this->Cell(10, 7, 'No', 'L', 0, 'C');
		$this->Cell(80, 7, 'Product / Packing', 0, 0, 'L');
		$this->Cell(30, 7, 'Brand', 0, 0, 'C');
		$this->Cell(20, 7, 'Qty', 0, 0, 'R');
		$this->Cell(20, 7, 'FCL', 0, 0, 'C');
		$this->Cell(30, 7, 'Unit Value (USD)', 'R', 1, 'C');
		$this->Line(10, $this->GetY(), 200, $this->GetY());
       
		$this->Ln(3);
		$this->setFont('Arial', '', 9);
		
//		$arr_brand = array();
//		$arr_i = 0;
		$total_qty = 0;
		$total_fcl = 0;
		
		$no = 1;
		foreach ($rec_dtl as $r) {
			
			//default value
			$h = 4;
			$border = 0;
			
			$ypro = $this->GetY();
			
			$this->SetXY(10, $ypro);
			$this->MultiCell(10, $h, $no++);
			
			$this->SetXY(10+10, $ypro);
			$this->MultiCell(80, $h, $r->product_code);
			
			$this->SetXY(10+10+80, $ypro);
			$this->MultiCell(30, $h, $r->brand_name, $border, 'C');
			
			$this->SetXY(10+10+80+30, $ypro);
			$this->MultiCell(20, $h, number_format($r->quantity,0,'.',','), $border, 'R');
			
			$this->SetXY(10+10+80+30+20, $ypro);
			$this->MultiCell(20, $h, number_format($r->fcl,2,'.',','), $border, 'C');
			
			$this->SetXY(10+10+80+30+20+20, $ypro);
			$this->MultiCell(30, $h, number_format($r->fob_price,2,'.',',').' per '.$r->cma_uom_quantity_id, $border, 'R');
			
			$this->Ln(1);
			$ypro = $this->GetY();
			
			$product_desc = ($r->product_view ? $r->product_view : $r->product_name);
			
			$this->SetXY(10+10, $ypro);
			$this->MultiCell(80, $h, $product_desc);
			
//			$hp = $this->NbLines(80, $product_desc);
						
			$ypro = $this->GetY();
			$this->SetXY(10+10, $ypro);
			
			$pack_size = $r->detail_pack_size;
			if ($pack_size == ''){
				$pack_size = number_format($r->uom_volume,0).$r->uom_volume_name.' x '.number_format($r->per_packing,0).$r->packing_size.' per '.$r->cma_uom_quantity_id;
			}
			$this->MultiCell(80, $h, $pack_size);
						
			if ($r->sodium_metabisulphite){
				$ypro = $this->GetY();
				$this->SetXY(10+10, $ypro);
				$this->MultiCell(80, $h, 'Sodium Metabisulphite '.$r->sodium_metabisulphite);
			}
			
//			$this->Cell(10, 4, $no++, 0, 0, 'C');
//			$this->Cell(80, 4, $r->product_code, 0, 0, 'L');
//			$this->Cell(30, 4, $r->brand_name, 0, 0, 'C');
//			$this->Cell(20, 4, number_format($r->quantity,0,'.',','), 0, 0, 'R');
//			$this->Cell(20, 4, number_format($r->fcl,2,'.',','), 0, 0, 'C');
//			$this->Cell(30, 4, number_format($r->fob_price,2,'.',',').' per '.$r->cma_uom_quantity_id, 0, 1, 'R');
			
//			$product_desc = ($r->product_view ? $r->product_view : $r->product_name);
			
//			$this->Cell(10, 4, '');
//			$this->Cell(190, 4, $product_desc, 0, 1, 'L');
			
//			$this->Cell(10, 4, '');
//			$this->Cell(190, 5, number_format($r->uom_volume,0).$r->uom_volume_name.' x '.number_format($r->per_packing,0).$r->packing_size.' per '.$r->cma_uom_quantity_id, 0, 1, 'L');
			
//			$this->Cell(10, 4, '');
//			if ($r->sodium_metabisulphite){
//				$this->Cell(80, 4, 'Sodium Metabisulphite '.$r->sodium_metabisulphite, 0, 1, 'L');
//			} else {
//				$this->Cell(80, 0, $r->sodium_metabisulphite, 0, 1, 'L');
//			}
			
//			$arr_brand[$arr_i] = $r->brand_name;
//			$arr_i++;
			
			$total_qty = floatval($total_qty) + floatval($r->quantity);
			$total_fcl = floatval($total_fcl) + floatval($r->fcl);
			
			$this->CheckPageBreak(5);
			
			$this->Ln(3);
		}
		
		$this->setFont('Arial', 'B', 9);
		$this->Cell(90, 4, '', 0, 0, 'C');
		$this->Cell(30, 4, 'Total', 0, 0, 'C');
		$this->Cell(20, 4, number_format($total_qty,0,'.',','), 0, 0, 'R');
		$this->Cell(20, 4, number_format($total_fcl,2,'.',','), 0, 0, 'C');
		$this->MultiCell(30, 4, $rec_hdr->container_name, 0, 'L');
		
		if ($rec_hdr->palletized == 1){
			$this->Cell(160,4,'');
			$this->Cell(30, 4, 'PALLETIZED', 0, 1, 'C');
			$this->Ln(3);
		}
		
		$this->Line(10, $this->GetY()+2, 200, $this->GetY()+2);
		
//		$this->Cell(40, 4, $rec_hdr->container_name, 0, 1, 'R');
		$this->setFont('Arial', '', 9);
		
		$this->Ln(5);
		
		$count_pm_label = 0;
		foreach ($rec_dtl as $r) {
			if ($r->pm_label_code){
				$count_pm_label++;
			}
		}

		if ($count_pm_label > 0){
			$this->Line(10, $this->GetY(), 200, $this->GetY());		
			$this->setFont('Arial', 'B', 9);
			$this->Cell(155, 7, 'PM Label Code', 'L', 0, 'L');
			$this->Cell(35, 7, 'Quantity', 'R', 1, 'C');
			$this->Line(10, $this->GetY(), 200, $this->GetY());
			$this->Ln(3);

			$this->setFont('Arial', '', 9);
			foreach ($rec_dtl as $r) {
				$this->Cell(5);
				$this->Cell(25, 5, $r->pm_label_code);
				$this->Cell(100, 5, $r->brand_name);
				$this->Cell(50, 5, number_format($r->label_qty, 0, '.',',').' pcs', 0, 1, 'R');
			}
		}
		
		$this->Ln(5);
		
		$this->CheckPageBreak(5);
		
		$this->setFont('Arial', 'B', 9);
		$this->Cell(190, 5, 'For Pulau Sambu Singapore Pte Ltd', 0, 1);
		$this->Cell(200, 10, '', 0, 1);
		$this->CheckPageBreak(5);
		$this->Cell(190, 5, 'Miss Hoa Poh Lin', 0, 1);
		$this->setFont('Arial', '', 9);
		$this->Cell(100, 5, 'Sales Management Manager', 0, 0);
		$this->Cell(90, 5, 'SM In Charge : '.$rec_hdr->firstname.' '.$rec_hdr->lastname, 0, 1, 'R');
		
		// Halaman Shipping Instruction
		
		if ($r->long_side > 0 || $r->short_side > 0){
			$this->AddPage();
			$this->SetTextColor(0, 0, 0);
			$this->setFillColor(255, 255, 255);

			$this->SetFont('Arial', 'B', 20);
			$this->Cell(20);
			$this->Ln(8);
			$this->Cell(190,5,'Shipping/Carton Instruction - PSS', 0, 1, 'C');

			$this->Ln(3);
			$this->SetFont('Arial', 'B', 9);

			$this->Line(10, $this->GetY(), 200, $this->GetY());
			$this->Cell(95, 5, '', 'L', 0);
			$this->Cell(95, 5, '', 'L', 0);
			$this->Cell(1, 5, '', 'L', 1);

			$this->Cell(10, 5, '', 'L');
			$this->Cell(85, 5, 'Carton marks for PO#');
			$this->Cell(10, 5, '', 'L');
			$this->Cell(85, 5, $rec_hdr->factory_name);
			$this->Cell(1, 5, '', 'L', 1);

			$this->Cell(95, 3, '', 'L', 0);
			$this->Cell(10, 3, '', 'L');
			$this->Cell(85, 3, $rec_hdr->customer_contact_name);		
			$this->Cell(1, 3, '', 'L', 1);

			$this->SetFont('Arial', 'B', 9);
			$this->Cell(10, 10, '', 'L');
			$this->Cell(85, 10, $rec_hdr->po_number);
			$this->Cell(95, 10, '', 'L', 0);
			$this->Cell(1, 10, '', 'L', 1);

			$this->Line(10, $this->GetY(), 200, $this->GetY());

			$this->Ln(5);

			$no_c = 1;
			foreach ($rec_dtl as $r) {
				if ($r->long_side > 0 || $r->short_side > 0){
					$this->SetFont('Arial', '', 9);
					
					$ymar = $this->GetY();
					$this->SetXY(10, $ymar);
					$this->MultiCell(10, $h, $no_c++);
					
					$this->SetXY(10+10, $ymar);
					$this->SetFont('Arial', 'B', 9);
					$this->MultiCell(50, $h, 'Marking on Long Side :');
					
					if ($r->long_side == 0){
						$this->SetXY(10+10+50, $ymar);
						$this->SetFont('Arial', '', 9);
						$this->MultiCell(40, $h, '');
					} else {
						$this->SetXY(10+10+50, $ymar);
						$this->SetFont('Arial', '', 9);
						$this->MultiCell(40, $h, $r->long_side.' side');
					}
					
					$this->SetXY(10+10+50+40, $ymar);
					$this->SetFont('Arial', 'B', 9);
					$this->MultiCell(50, 4, 'Marking on Short Side :');
					
					if ($r->short_side == 0){
						$this->SetXY(10+10+50+40+50, $ymar);
						$this->SetFont('Arial', '', 9);
						$this->MultiCell(40, 4, '');
					} else {
						$this->SetXY(10+10+50+40+50, $ymar);
						$this->SetFont('Arial', '', 9);
						$this->MultiCell(40, 4, $r->short_side.' side');
					}
					
					$this->SetFont('Arial', '', 9);
					$ymar = $this->GetY();
					$this->SetXY(20, $ymar);
					$this->MultiCell(90, 4, $r->marking_long_side, 0, 'L', false);
					$this->SetXY(110, $ymar);
					$this->MultiCell(90, 4, $r->marking_short_side, 0, 'L', false);
					
					$arr_max = array(
						$this->NbLines(90, $r->marking_long_side),
						$this->NbLines(90, $r->marking_short_side),
					);
					
					$hmax = max($arr_max);
					$this->SetXY(200, $ymar);
					$this->MultiCell(1, $h * $hmax, '');
					
					$this->Ln(2);
				}
			}

			$this->Ln(7);

			$no_b = 1;
			foreach ($rec_dtl as $r) {	
				if ($r->carton_remark){
					$this->SetFont('Arial', 'B', 9);
					
					$ycar = $this->GetY();
					$this->SetXY(10, $ycar);
					$this->MultiCell(35, $h, 'Carton Barcode # :');
					$this->SetXY(10+35, $ycar);
					$this->MultiCell(145, $h, $r->carton_barcode, 0, 'L');
										
					$ycar = $this->GetY()+1;
					$this->SetXY(10, $ycar);
					$this->MultiCell(10, 4, $no_b, 0, 'J');
										
//					$this->Cell(10, $h, $no_b);
										
					$this->SetFont('Arial', 'B', 9);
					$this->SetXY(10+10, $ycar);
					$this->MultiCell(170, $h, $r->carton_remark, 0, 'L');
					
					$no_b++;
					$this->Ln(3);
				}
			}
		}
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

    function Row($rec_dtl) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($rec_dtl); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $rec_dtl[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($rec_dtl); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $rec_dtl[$i], 0, $a);
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

$pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($rec_hdr,$rec_dtl,$rec_doc,$rec_agent);
ob_clean();
$pdf->Output();