<?php

class PDF1 extends FPDF {
	
	function Header() {
		
		
		$this->SetXY(10, $this->GetY());
//		$this->Ln(5);
		$this->Line(10, $this->GetY(), 285, $this->GetY());
		$this->Line(10, $this->GetY(), 10, $this->GetY()+23);
		$this->Line(230, $this->GetY(), 230, $this->GetY()+23);
		$this->Line(285, $this->GetY(), 285, $this->GetY()+23);
		$this->Line(10, $this->GetY()+23, 285, $this->GetY()+23);
		$this->Image('assets/pss-header-no-addr.png', 13, 12, 120, 18, 'PNG');
//        $this->setFont('Arial', 'B', 10);
//        $this->SetTextColor(0, 51, 153);
//        $this->setFillColor(255, 255, 255);
		
		$this->Ln(5);
		
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
//		$this->SetTextColor(0, 51, 153);
		
//		$this->SetFont('arial', 'B', 12);
//		$this->Cell(222);
//		$this->Cell(52,4,'SHIPPING ADVICE', 0, 1, 'C');
		
		$this->Ln(2);
		$this->SetFont('arial', '', 9);
		$this->Cell(222);		
		$this->Cell(52,4,'Page : '.$this->PageNo().' of {nb}', 0, 1, 'C');
		
		$this->Ln(14);
		
		$this->SetFont('arial', 'B', 14);
		$this->Cell(275,4, 'SHIPPING ADVICE', 0, 1, 'C');
		$this->Ln(5);
	}
	
	function Content($rec_hdr, $rec_dtl)
	{
		$h = 4;
		$font_size = 9;
		
		$this->SetFont('arial', '', 9);
		$arr_w = array(10, 20, 2, 220, 2, 11, 2, 28, 1);
		$arr_x = array(
			0	=> $arr_w[0],
			1	=> $arr_w[0] + $arr_w[1],
			2	=> $arr_w[0] + $arr_w[1] + $arr_w[2],
			3	=> $arr_w[0] + $arr_w[1] + $arr_w[2] + $arr_w[3],
			4	=> $arr_w[0] + $arr_w[1] + $arr_w[2] + $arr_w[3] + $arr_w[4],
			5	=> $arr_w[0] + $arr_w[1] + $arr_w[2] + $arr_w[3] + $arr_w[4] + $arr_w[5],
			6	=> $arr_w[0] + $arr_w[1] + $arr_w[2] + $arr_w[3] + $arr_w[4] + $arr_w[5] + $arr_w[6],
			7	=> $arr_w[0] + $arr_w[1] + $arr_w[2] + $arr_w[3] + $arr_w[4] + $arr_w[5] + $arr_w[6] + $arr_w[7],
		);
		
		$y = $this->GetY();
		$this->SetXY($arr_x[0], $y);
		$this->MultiCell($arr_w[1], $h, 'To');
		$this->SetXY($arr_x[1], $y);
		$this->MultiCell($arr_w[2], $h, ':');
		$this->SetXY($arr_x[2], $y);
		$this->MultiCell($arr_w[3], $h, $rec_hdr->to);
		$this->SetXY($arr_x[3], $y);
		$this->MultiCell($arr_w[4], $h, '');
		$this->SetXY($arr_x[4], $y);
		$this->MultiCell($arr_w[5], $h, 'Date');
		$this->SetXY($arr_x[5], $y);
		$this->MultiCell($arr_w[6], $h, ':');
		$this->SetXY($arr_x[6], $y);
		$this->MultiCell($arr_w[7], $h, (!is_null($rec_hdr->schedule_date)) ? tgl_ind($rec_hdr->schedule_date) : '');
		
		$this->SetXY($arr_x[7], $y);
		$this->MultiCell($arr_w[8], $this->NbLines($arr_w[3], $rec_hdr->to) * $h, '');
		
		$y = $this->GetY();
		$this->SetXY($arr_x[0], $y);
		$this->MultiCell($arr_w[1], $h, 'Attn');
		$this->SetXY($arr_x[1], $y);
		$this->MultiCell($arr_w[2], $h, ': ');
		$this->SetXY($arr_x[2], $y);
		$this->MultiCell($arr_w[3], $h, $rec_hdr->attn);
		$this->SetXY($arr_x[3], $y);
		$this->MultiCell($arr_w[4], $h, '');
		
		$this->Ln(2);
		
		$dw = array(29, 28, 30, 18, 18, 25, 63, 30, 35);
		$da = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
		
		$head_title	= array(
			'P/O No.', 'Buyer Ref', 'Vessel / Voyage', 'ETD', 'ETA', 'Port', 'Product', 'Container No./ Seal No / CT', 'Booking Ref No./ Shipping Carrier',
		);
		
		$arr_cell_height = array();
		for($i=0; $i < count($head_title); $i++):
			$arr_cell_height[$i] = $this->NbLines($dw[$i], $head_title[$i]);
		endfor;
		
		$hmax = max($arr_cell_height);
		
		$this->SetFont('arial', 'B', $font_size);
		
		$hy = $this->GetY();
		$hx = 10;
		for($i=0; $i < count($head_title); $i++):
//            $this->Cell($dw[$i], 6,$head_title[$i], 'BLT', 0, $da[$i]);
			$this->SetXY($hx, $hy);
			$this->MultiCell($dw[$i], ($hmax / $arr_cell_height[$i]) * 6 , $head_title[$i], 'BLT', $da[$i]);
			$hx = $hx + $dw[$i];
        endfor;
		
		$this->SetXY($hx, $hy);
		$this->MultiCell(1,12,'','L',1);	// garis kanan
		$this->SetFont('arial', '', $font_size);
		
		$this->SetWidths($dw);
		$this->SetAligns($da);
		
		foreach ($rec_dtl as $r) {
			
//			$c20 = ($r->container_size == 20) ? number_format($r->total_fcl) : '';
//			$c40 = ($r->container_size == 40) ? number_format($r->total_fcl) : '';
			
			$etdsin	= str_replace('-', '/', $r->etdsin);
			$etasin = str_replace('-', '/', $r->etasin);
			
			$container = (trim($r->container) != '') ? $r->container.' / ' : '';
			$seal	= (trim($r->seal) != '') ? $r->seal.' / ' : '';
			
			$this->Row(
				array(
					$r->po_number,
					$r->buyer_si,
					$r->vessel,
					str_replace('/20', '/', $etdsin),
					str_replace('/20', '/', $etasin),
					$r->port_name.', '.$r->destination_country,
					$r->product,
					$container."\n".$seal."\n".$r->container_size."' ".$r->container_abbr,
					$r->reff."\n".$r->shipping

				)
			);
		}
		
		$this->Ln(1);
		$this->Cell(275, $h, 'Issued By : '.$rec_hdr->printed_by, 0, 1, 'R');
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
        $h = 4 * $nb;
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
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $rec_dtl[$i], 0, $a);
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

$pdf = new PDF1('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($rec_hdr,$rec_dtl);
$pdf->Output();