<?php

// NOTE
// Weight Gross and Net requested by Emily Chen (SHP) on 11 Okt 2016

class PDF1 extends TFPDF {
	
	function set_factory($factory){
		$this->factory = $factory;
	}
	
	//Page header            
    function Header() {
//		$this->Line(10, $this->GetY(), 200, $this->GetY());	
//		$this->Cell(1, 23, '', 'L', 0, 'L');
		$this->SetXY(10, $this->GetY());
		$this->Image('assets/PSG.png', 15, 13, 20, 0, 'PNG');
        $this->setFont('Arial', 'B', 15);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
		$this->Cell(190, 2, '', 0, 1, 'L');
        $this->Cell(20);
        $this->Cell(120, 5, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'C', false);
        $this->Cell(5);
        $this->setFont('Arial', 'B', 10);
        $this->Cell(45, 5, 'Shipping Instruction', 0, 0, 'L', false);	
		$this->Cell(1, 5, '', 0, 1, 'L');
        
        $this->setFont('Arial', '', 6);
        $this->Cell(20);
        $this->cell(120, 3, 'Reg. No.: 201537276N', 0, 0, 'C', false);
		$this->Cell(50, 3);
		$this->Cell(3, 3, '', 0, 1, 'R');

        $this->setFont('Arial', '', 8);
        $this->Cell(20);
        $this->cell(120, 4, '19 Tanglin Road, #11-01/02, Tanglin Shopping Centre, Singapore 247909', 0, 0, 'C', false);
        $this->Cell(5);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(15, 4, 'Factory', 0, 0, 'L', false);
		
        $this->Cell(30, 4, ': '.$this->factory, 0, 0, 'L', false);
//		$this->Cell(30, 4, ': '.$_GET['factory'], 0, 0, 'L', false);
		$this->Cell(3, 4, '', 0, 1, 'R');
		
        $this->setFont('Arial', '', 8);
        $this->Cell(20);
        $this->cell(120, 4, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.com.sg', 0, 0, 'C', false);
		$this->Cell(5);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(15, 4, 'Page', 0, 0, 'L', false);
//        $this->Cell(30, 4, ': '.$this->GroupPageNo().' of '.$this->PageGroupAlias(), 0, 0, 'L', false);
		$this->Cell(30, 4, ': '.$this->PageNo().' of {nb}', 0, 0, 'L', false);
		$this->Cell(3, 4, '', 0, 1, 'R');

        $this->setFont('Arial', '', 8);
        $this->Cell(20);
        $this->cell(120, 3, 'www.sambugroup.com', 0, 0, 'C', false);
		$this->Cell(50, 3);
		$this->Cell(3, 5, '', 0, 1, 'L');
		
        $this->Ln(4);
		
		$this->Line(10, $this->GetY()-4, 200, $this->GetY()-4);
	}
	
	function Content($rec_hdr, $rec_dtl, $rec_doc, $rec_doc_s, $agent, $po1, $po2, $con_issued)
	{
		$fontsize	= 9;
		$border		= 0;
		$align		= 'L';
			
//			$this->SetXY(0, 250);
//			$this->MultiCell(15, 4, 'Factory');
			
			$this->SetTextColor(0, 0, 0);
			$this->setFillColor(255, 255, 255);

			$this->setFont('Arial', 'B', $fontsize);
			$this->Cell(15, 4, 'Schedule');
			$this->Cell(100, 4, ': '.tgl_dmy($rec_hdr->schedule_date));
			
			if ($rec_hdr->issue_by){
				$issued_by = $rec_hdr->issue_by;
			} else {
				if (isset($con_issued)){
					$issued_by		= '';
					$issued_by		.= ($con_issued->sm_firstname ? $con_issued->sm_firstname.' '.$con_issued->sm_lastname : '');
					$issued_by		.= ($con_issued->sp_firstname ? ' / '.$con_issued->sp_firstname.' '.$con_issued->sp_lastname : '');
					$issued_by		.= ($con_issued->pm_firstname ? ' / '.$con_issued->pm_firstname.' '.$con_issued->pm_lastname : '');
				} else {
					$issued_by		= '';
				}
			}
			
			$this->setFont('Arial', '', $fontsize);
			$this->Cell(75, 4, 'Issue By : '.$issued_by,0,1,'R');

		//==> CUSTOMER & ORDER INFO
			$this->setFont('Arial', 'BU', $fontsize);
			$this->Ln(3);
			$this->Cell(115, 5, 'CUSTOMER & ORDER INFO');
			$this->Cell(75, 5, '', 0, 1);
//			$this->Cell(75, 5, $via, 0, 1);

			$this->setFont('Arial', '', $fontsize);
			
			$y = $this->GetY();
			$this->SetXY(10, $y);
			$this->MultiCell(35, 4, 'No of FCL');
			$this->SetXY(10+35, $y);
			$this->MultiCell(2, 4, ': ',0,'L');
			$this->SetXY(10+35+2, $y);
			$this->MultiCell(78, 4, $rec_hdr->container_name,0,'L');
			$this->SetXY(10+35+2+78, $y);
			$this->MultiCell(35, 4, 'Client Ref No',0,'L');
			$this->SetXY(10+35+2+78+35, $y);
			$this->MultiCell(2, 4, ': ');
			$this->SetXY(10+35+2+78+35+2, $y);
			$this->MultiCell(40, 4, $rec_hdr->client_ref_no, 0, 'L');
			
			$arr_hmax = array(
				$this->NbLines(78, $rec_hdr->container_name),
				$this->NbLines(40, $rec_hdr->client_ref_no),
			);
			
			$hmax = max($arr_hmax);
			$this->SetXY(205, $y);
			$this->MultiCell(1, 4 * $hmax, '');

			$y = $this->GetY();
			$this->SetXY(10,$y);
			$this->MultiCell(35, 4, 'Purchase Order');
			$this->SetXY(45, $y);
			$this->MultiCell(2, 4, ': ',0,'L');
			$this->SetXY(47, $y);
			$this->MultiCell(78, 4,  $po1.' '.$po2, $border, $align);
			$this->SetXY(47+78, $y);
			$this->MultiCell(35, 4, 'Client Contract No');
			$this->SetXY(47+78+35, $y);
			$this->MultiCell(2, 4, ': ', $border, $align);
			$this->SetXY(47+78+35+2, $y);
			$this->MultiCell(40, 4, $rec_hdr->client_contract_no);
			
			$arr_hmax = array(
				$this->NbLines(78,  $po1.' '.$po2),
				$this->NbLines(40, $rec_hdr->client_contract_no),
			);
			
			$hmax = max($arr_hmax);
			$this->SetXY(205, $y);
			$this->MultiCell(1, 4 * $hmax, '');

// VERSI LAMA
//			$this->Cell(35, 4, 'Purchase Order');
//			$this->Cell(80, 4, ': '.$po1.' '.$po2);
//			$this->Cell(35, 4, 'Client Contract No');
//			$this->Cell(40, 4, ': '.$rec_hdr->client_contract_no, 0, 1);
			
			$y = $this->GetY();
			$this->SetXY(10, $y);			
			$this->MultiCell(35, 4, 'Client');
			$this->SetXY(10+35, $y);
			$this->MultiCell(2, 4, ': ');
			$this->SetXY(10+35+2, $y);
			$this->MultiCell(78, 4, $rec_hdr->customer_company_name);
			$this->SetXY(10+35+2+78, $y);
			$this->MultiCell(35, 4, 'Customer Code');
			$this->SetXY(10+35+2+78+35, $y);
			$this->MultiCell(2, 4, ': ');
			$this->SetXY(10+35+2+78+35+2, $y);
			$this->MultiCell(38, 4, $rec_hdr->customer_code);
			
			$arr_hmax = array(
				$this->NbLines(78, $rec_hdr->customer_company_name),
				$this->NbLines(38, $rec_hdr->customer_code),
			);
			
			$hmax=max($arr_hmax);
			$this->SetXY(205, $y);
			$this->MultiCell(1, 4 * $hmax, '');
			
			$y = $this->GetY();
			$this->SetXY(10, $y);
			$this->MultiCell(35, 4, 'Agent');
			$this->SetXY(10+35, $y);
			$this->MultiCell(2, 4, ': ');
			$this->SetXY(10+35+2, $y);
			$show_agent = ($agent) ? $agent->agent_name : '';
			$this->MultiCell(78, 4, $show_agent);		
			$this->SetXY(10+35+2+78, $y);
			$this->MultiCell(35, 4, 'Our Sales Contract No');
			$this->SetXY(10+35+2+78+35, $y);
			$this->MultiCell(2, 4, ': ');
			$this->SetXY(10+35+2+78+35+2, $y);
			$this->MultiCell(38, 4, $rec_hdr->contract_no, 0, 1);
			
			$arr_hmax = array(
				$this->NbLines(78, $show_agent),
				$this->NbLines(38, $rec_hdr->contract_no),
			);
			
			$hmax=max($arr_hmax);
			$this->SetXY(205, $y);
			$this->MultiCell(1, 4 * $hmax, '');
			
			$y = $this->GetY();
			$this->SetXY(10, $y);
			$this->MultiCell(35, 4, 'Invoice To Buyer', $border, $align);
			$this->SetXY(10+35, $y);
			$this->MultiCell(2, 4, ': ', $border, $align);
			$this->SetXY(10+35+2, $y);
			$this->MultiCell(78, 4, $rec_hdr->invoice2buyer, 0, $align);		
//			$this->Cell(35, 4, '');
//			$this->Cell(40, 4, '', 0, 1);

		//==> PRODUCT INFO
			$this->setFont('Arial', 'BU', $fontsize);
			$this->Ln(3);
			$this->Cell(190, 5, 'PRODUCT INFO', 0, 1);

			$this->setFont('Arial', '', $fontsize);
			$no = 1;
			$grand_tot_gross = 0;
			$grand_tot_net = 0;
			
			foreach ($rec_dtl as $pro){
				$this->CheckPageBreak(4);
				
				$product_desc = ($pro->detail_product_name ? $pro->detail_product_name : $pro->product_name);
				$per_quantity = ' per '.$pro->uom_quantity_name;

				$this->Cell(5, 4, $no, 0, 0, 'C');

				$this->Cell(30, 4, 'Description');
				$y=  $this->GetY();
				$this->SetXY(45, $y);
				$this->MultiCell(2, 4, ': ', 0, 'L');
				$this->SetXY(45+2, $y);
				$this->MultiCell(78, 4, $product_desc);
				
				$this->SetXY(45+2+78, $y);
				$this->MultiCell(25, 4, 'Brand');
				$this->SetXY(45+2+78+25, $y);
				$this->MultiCell(50, 4, ': '.$pro->brand_name);
				
				$this->SetXY(45+2+78+25+56, $y);
				$this->MultiCell(1, $this->NbLines(78, $product_desc) * 4, '');

				$palletized = ($pro->detail_palletized == 1 ? 'YES' : 'NO');
				
				$this->Cell(5, 4);
				$this->Cell(30, 4, 'Packing');
				$this->Cell(80, 4,': '.$pro->detail_pack_size, 0, 0, 'L', false);
				$this->Cell(25, 4, 'Palletized');
				$this->Cell(50, 4, ': '.$palletized, 0, 1, 'L', false);

	//			$this->Cell(5, 4);
	//			$this->Cell(30, 4, 'Brand');
	//			$this->Cell(165, 4,': '.$pro->brand_name, 0, 1, 'L', false);

				$this->Cell(5, 4);
				$this->Cell(30, 4, 'Quantity');
				$this->Cell(80, 4,': '.$pro->quantity.' '.$pro->uom_quantity_name, 0, 0, 'L', false);
				$this->Cell(25, 4, 'Pallet No.');
				$this->Cell(50, 4, ': '.$pro->pallet_qty, 0, 1, 'L', false);

				$this->Cell(5, 4);
				$this->Cell(30, 4, 'Unit Price');
				if (is_float($pro->invoice_price)){
					$this->Cell(80, 4,': '.$pro->currency_id.' '.floatval(number_format($pro->invoice_price,2)).$per_quantity, 0, 0, 'L', false);
				} else {
					$this->Cell(80, 4,': '.$pro->currency_id.' '.number_format($pro->invoice_price,2).$per_quantity, 0, 0, 'L', false);
				}
				
				$tot_gross = floatval($pro->gross_weight) * $pro->quantity;
				$tot_net = floatval($pro->net_weight) * $pro->quantity;
				
				$grand_tot_gross = $grand_tot_gross + $tot_gross;
				$grand_tot_net = $grand_tot_net + $tot_net;
				
				$this->Cell(25, 4, 'Weight Per Ctn');
				$this->Cell(50, 4, ': '.number_format($pro->gross_weight, 2).' / '.number_format($pro->net_weight, 2), 0, 1, 'L', false);
				
				$this->Cell(115);
				$this->Cell(25, 4, 'Total');
				$this->Cell(50, 4, ': '.number_format($tot_gross, 2).' / '.number_format($tot_net, 2), 0, 1, 'L', false);
				
	//			$this->Cell(5, 4);
	//			$this->Cell(30, 4, 'Invoice Price');
	////			$this->SetTextColor(255, 0, 0);
	//			$this->Cell(165, 4,': '.$pro->currency_id.' '.floatval(number_format($pro->invoice_price, 2)), 0, 1, 'L', false);
	//			$this->SetTextColor(0, 0, 0);
				
				$this->Ln(3);

				$no++;
			}

		//==> SHIPPING INFO
			$this->setFont('Arial', 'BU', $fontsize);		

			$this->Ln(5);
			$this->Cell(190, 5, 'SHIPPING INFO', 0, 1);

			$this->setFont('Arial', '', $fontsize);
			
			$payterm = ($rec_hdr->payment_term_id) ? html_entity_decode($rec_hdr->payment_term, ENT_QUOTES) : html_entity_decode($rec_hdr->payment_terms, ENT_QUOTES);

			$this->Cell(35, 4, 'Payment Term');
			$this->Cell(165, 4, ': '.str_replace('&#039',"'",$payterm), 0, 1);
//			$this->Cell(165, 4, ': '.html_entity_decode($rec_hdr->payment_terms, ENT_QUOTES), 0, 1);

			$this->Cell(35, 4, 'Trading Term');
			$this->Cell(80, 4, ': '.$rec_hdr->trading_term_name);
//			$this->Cell(80, 4, ': '.$rec_hdr->trading_term_name.' '.$rec_hdr->shipment_from);		
			$this->Cell(35, 4, 'LC Number');
			$this->Cell(40, 4, ': '.$rec_hdr->lc_number, 0, 1);

			$this->Cell(35, 4, 'Ocean Freight Charges');
			$this->Cell(80, 4, ': '.$rec_hdr->ocean_freight);		
			$this->Cell(35, 4, 'Trucking Date');
			$this->Cell(40, 4, ': ', 0, 1);

			$this->Cell(35, 4, 'Shipping Liner');
			$this->Cell(80, 4, ': '.$rec_hdr->shipping_name);
			
			$this->setFont('Arial', 'B', $fontsize);
			$this->Cell(35, 4, 'Weight Grand Total');
			$this->Cell(80, 4, ': '.number_format($grand_tot_gross,2).' / '.number_format($grand_tot_net,2), 0,1);
			$this->setFont('Arial', '', $fontsize);

			$this->Cell(35, 4, 'Service Number');
			$this->Cell(165, 4, ': '.$rec_hdr->service_number, 0, 1);

			if (!isset($rec_hdr->destination_id) || $rec_hdr->destination == ''){
				$dest = '';
			} else {
				$dest = ', '.$rec_hdr->destination;
			}
			
			$this->Cell(35, 4, 'Final Destination');
			
			$this->Cell(165, 4, ': '.$rec_hdr->port_name.$dest, 0, 1);

			//Orang shipping tidak mau ditampilkan (2016-10-11)
//			$this->Cell(35, 4, 'Shipping Date');
//			$this->Cell(165, 4, ': '.$rec_hdr->ship_date, 0, 1);

			$cons_y = $this->GetY();
			$this->SetXY(10, $cons_y);
			$this->MultiCell(35, 4, 'Consignee');
			$this->SetXY(45, $cons_y);
			$this->MultiCell(2, 4, ':');
			$this->SetXY(47, $cons_y);
			$this->SetFont('DroidSansFallback', '', $fontsize);
			$this->MultiCell(163, 4, $rec_hdr->consignee, 0, 1);
			$this->setFont('Arial', '', $fontsize);
	//		$this->SetXY(46, $this->GetY());
	//		$this->MultiCell(163, 4, $rec_hdr->customer_address, 0, 'L');

		//==> NOTIFY PARTY
			$this->CheckPageBreak(4);
			$this->setFont('Arial', 'BU', $fontsize);
			$this->Ln(3);
			$this->Cell(190, 5, 'NOTIFY PARTY', 0, 1);

			$this->setFont('Arial', '', $fontsize);
			
			$this->CheckPageBreak(4);
			$notif_y = $this->GetY();
			$this->SetXY(10, $notif_y);
			$this->MultiCell(35, 4, '1st NotifyParty');
			$this->SetXY(45, $notif_y);
			$this->MultiCell(2, 4, ':');
			$this->SetXY(47, $notif_y);
			$this->MultiCell(163, 4, $rec_hdr->notify_party1, 0, 1);

			$this->CheckPageBreak(4);
			$notif_y = $this->GetY();
			$this->SetXY(10, $notif_y);
			$this->MultiCell(35, 4, '2nd NotifyParty');
			$this->SetXY(45, $notif_y);
			$this->MultiCell(2, 4, ':');
			$this->SetXY(47, $notif_y);
			$this->MultiCell(163, 4, $rec_hdr->notify_party2, 0, 1);

	//		$this->Cell(35, 4, '1st NotifyParty');
	//		$this->Cell(165, 4, ': '.$rec_hdr->notify_party1, 0, 1);

	//		$this->Cell(35, 4, '2nd NotifyParty');
	//		$this->Cell(165, 4, ': '.$rec_hdr->notify_party2, 0, 1);

		//==> DOCUMENT
			$this->setFont('Arial', 'BU', $fontsize);
			$this->Ln(3);
			$this->Cell(190, 5, 'DOCUMENT REQUIRED', 0, 1);
			
			$this->CheckPageBreak(4);
			$this->setFont('Arial', '', $fontsize);
			foreach ($rec_doc as $doc){
				$this->Cell(190, 4, $doc->document_name, 0, 1);
			}

		//==> SPECIAL DOCUMENT
			if ($rec_doc_s){
				$this->CheckPageBreak(4);
				$this->setFont('Arial', 'BU', $fontsize);
				$this->Ln(3);
				$this->Cell(190, 5, 'SPECIAL DOCUMENT', 0, 1);

				$this->setFont('Arial', '', $fontsize);
				foreach ($rec_doc_s as $doc_s){
					$this->Cell(190, 4, $doc_s->document_name, 0, 1);
				}
				$this->CheckPageBreak(4);
			}

		//==> REMARKS
			$this->setFont('Arial', 'BU', $fontsize);			
			$this->Ln(3);
			$this->Cell(190, 5, 'REMARKS', 0, 1);

//			$this->setFont('Arial', '', $fontsize);
			$this->SetFont('DroidSansFallback', '', $fontsize);
			$this->SetXY(10, $this->GetY()+1);
			$this->MultiCell(190, 4, $rec_hdr->sipo_remark);

			$this->Ln(5);
//			$this->AddPage();
			
			if ($this->GetY() > 250){
				$this->AddPage();
			}
			
		//==> Page Shipping Dept
			$this->setFont('Arial', 'BU', $fontsize);
			$this->Ln(3);
			$this->Cell(190, 5, 'FOR SHIPPING DEPARTMENT ONLY', 0, 1);

			$this->setFont('Arial', '', $fontsize);
			$this->Cell(30, 4, 'Vessel / Voyage');
			$this->Cell(70, 4, ': ');
			$this->Cell(10);
			$this->Cell(30, 4, 'ETD Destination');
			$this->Cell(50, 4, ': ', 0, 1);

			$this->Cell(30, 4, 'ETD Singapore');
			$this->Cell(70, 4, ': ');
			$this->Cell(10);
			$this->Cell(30, 4, 'Booking Reff');
			$this->Cell(50, 4, ': ', 0, 1);

			$this->Cell(30, 4, 'Port of Discharge');
			$this->Cell(70, 4, ': ');
			$this->Cell(10);
			$this->Cell(30, 4, 'Collection Yard');
			$this->Cell(50, 4, ': ', 0, 1);

			$this->Cell(30, 4, 'Place of Delivery');
			$this->Cell(70, 4, ': ');
			$this->Cell(10);
			$this->Cell(30, 4, 'Container / Seal No');
			$this->Cell(50, 4, ': ', 0, 1);

			$this->Cell(30, 4, 'Barge Ref');
			$this->Cell(70, 4, ': ', 0, 1);
		
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
	
// ADD-ON FPDF ==> GROUP NUMBERING
    var $NewPageGroup;   // variable indicating whether a new group was requested
    var $PageGroups;     // variable containing the number of pages of the groups
    var $CurrPageGroup;  // variable containing the alias of the current page group

    // create a new page group; call this before calling AddPage()
    function StartPageGroup()
    {
        $this->NewPageGroup = true;
    }

    // current page in the group
    function GroupPageNo()
    {
        return $this->PageGroups[$this->CurrPageGroup];
    }

    // alias of the current page group -- will be replaced by the total number of pages in this group
    function PageGroupAlias()
    {
        return $this->CurrPageGroup;
    }

    function _beginpage($orientation, $format)
    {
        parent::_beginpage($orientation, $format);
        if($this->NewPageGroup)
        {
            // start a new group
            $n = sizeof($this->PageGroups)+1;
            $alias = "{nb$n}";
            $this->PageGroups[$alias] = 1;
            $this->CurrPageGroup = $alias;
            $this->NewPageGroup = false;
        }
        elseif($this->CurrPageGroup)
		{
            $this->PageGroups[$this->CurrPageGroup]++;
		}
    }

    function _putpages()
    {
        $nb = $this->page;
        if (!empty($this->PageGroups))
        {
            // do page number replacement
            foreach ($this->PageGroups as $k => $v)
            {
                for ($n = 1; $n <= $nb; $n++)
                {
                    $this->pages[$n] = str_replace($k, $v, $this->pages[$n]);
                }
            }
        }
        parent::_putpages();
    }

}


$pdf = new PDF1('P','mm','A4');
$pdf->AddFont('DroidSansFallback', '', 'DroidSansFallback.ttf', true);

	$get_list_po	= $this->M_mar_shipping_instruction->get_mix_po($rec_hdr->ship_id, $rec_hdr->po_hdr_id);
	
	if ($get_list_po){
		$i = 1;
		foreach ($get_list_po as $row) {
			if ($i == 1){
				$list_po = ' mix with '.$row->po_number;
			} else {
				$list_po .= ', '.$row->po_number;
			}
			$i++;
		}
	} else {
		$list_po = '';
	}

	$pdf->AliasNbPages();
	$pdf->set_factory($rec_hdr->factory_abbr);
	$pdf->AddPage();
	
	$con_issued	= $this->M_mar_sales_contract->get_issued_by($rec_hdr->contract_hdr_id);
	
	$pdf->Content($rec_hdr, $rec_dtl, $rec_doc, $rec_doc_s, $agent, $rec_hdr->po_number, $list_po, $rec_hdr->po_number, $con_issued);

$pdf->Output();
