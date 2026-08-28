<?php

class PDF1 extends FPDF {
	
	function Header() {
		$this->SetXY(12, $this->GetY());
		$this->Ln(5);
		$this->Image('assets/PSG.png', 12, 15, 10, 0, 'PNG');
        $this->setFont('Arial', 'B', 10);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
//		$this->Cell(265, 3, '', 'LR', 1);
		
        $this->Cell(15, 5);
        $this->Cell(250, 5, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'L');
        		
		$this->setFont('Arial', 'B', 12);
		$this->SetTextColor(0, 0, 0);
		$this->Ln(3);
		$this->Cell(100);
		$this->Cell(65, 8, 'SHIPPING ADVICE', 'LTBR', 1, 'C', false);
		
		$this->setFont('Arial', 'B', 9);
		$this->Ln(2);
		
		$this->Cell(2);
		$this->Cell(20, 5, 'Customer');
		$this->Cell(254, 5, ': '.decode_str($_GET['cst']),0,1);
		
		$this->Cell(2);
		$this->Cell(20, 5, 'Att');
		$this->Cell(254, 5, ': '.decode_str($_GET['att']),0,1);
	}
	
	function Content($record_detail) {
		$fontsize = 8;
		
		$this->SetTextColor(0, 0, 0);
        $this->setFillColor(230,230,230);
		
		$this->Ln(3);
		
		$this->Cell(2);
		$this->Cell(8, 7, 'No', 'TLR', 0, 'C', true);
		$this->Cell(35, 7, 'P.O. No', 'TLR', 0, 'C', true);
		$this->Cell(8, 7, "20'", 'TLR', 0, 'C', true);
		$this->Cell(8, 7, "40'", 'TLR', 0, 'C', true);
		$this->Cell(10, 7, 'CT', 'TLR', 0, 'C', true);
		$this->Cell(30, 7, 'Ctnr/Seal No', 'TLR', 0, 'C', true);
		$this->Cell(35, 7, 'Destination', 'TLR', 0, 'C', true);
		$this->Cell(60, 7, 'Description/Brand', 'TLR', 0, 'C', true);
		$this->Cell(20, 7, 'Ref:', 'TLR', 0, 'C', true);
		$this->Cell(60, 7, 'Vessel Details', 'TLR', 1, 'C', true);
		
		$this->Line(12, $this->GetY(), 286, $this->GetY());
		
		$this->setFont('Arial', '', $fontsize);
		$this->setFillColor(255, 255, 255);
		
		$no = 1;
		
		foreach ($record_detail as $r) {
			$arr_cell_height = array(
				$this->NbLines(8, $no),
				$this->NbLines(35, $r->po_number),
				$this->NbLines(8, $r->c20),
				$this->NbLines(8, $r->c40),
				$this->NbLines(10, $r->ct),
				$this->NbLines(30, $r->seal),
				$this->NbLines(35, $r->destination),
				$this->NbLines(60, $r->product_description),
				$this->NbLines(20, $r->reff),
				$this->NbLines(60, "ETD : $r->etd ETA : $r->eta \n$r->vessel\n$r->bkgref"),
			);
			
			$hmax = max($arr_cell_height);
			$hline = 4;
			
			$yval = $this->GetY();
			$xval = 12;
			
			$this->SetXY($xval, $yval);
			$this->MultiCell(8, ($hmax / $arr_cell_height[0]) * $hline, $no, 'LB', 'C', false);
			
			$this->SetXY($xval+8, $yval);
			$this->MultiCell(35, ($hmax / $arr_cell_height[1]) * $hline, $r->po_number, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35, $yval);
			$this->MultiCell(8, ($hmax / $arr_cell_height[2]) * $hline, $r->c20, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8, $yval);
			$this->MultiCell(8, ($hmax / $arr_cell_height[3]) * $hline, $r->c40, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8, $yval);
			$this->MultiCell(10, ($hmax / $arr_cell_height[4]) * $hline, $r->ct, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8+10, $yval);
			$this->MultiCell(30, ($hmax / $arr_cell_height[5]) * $hline, $r->seal, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8+10+30, $yval);
			$this->MultiCell(35, ($hmax / $arr_cell_height[6]) * $hline, $r->destination, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8+10+30+35, $yval);
			$this->MultiCell(60, ($hmax / $arr_cell_height[7]) * $hline, $r->product_description, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8+10+30+35+60, $yval);
			$this->MultiCell(20, ($hmax / $arr_cell_height[8]) * $hline, $r->reff, 'LB', 'C', false);
			
			$this->SetXY($xval+8+35+8+8+10+30+35+60+20, $yval);
			$this->MultiCell(60, ($hmax / $arr_cell_height[9]) * $hline, "ETD : $r->etd ETA : $r->eta \n$r->vessel\n$r->bkgref", 'LBR', 'C', false);
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

$pdf = new PDF1('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($record_detail);
$pdf->Output();