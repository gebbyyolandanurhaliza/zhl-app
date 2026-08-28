<?php

class PDF extends FPDF {

    public function setData($data){
        $this->data=$data;
    }
    
    //Page header
    function Header() {
        $titel = 'Transaction Journal';
        $this->Image('assets/zhlkop.PNG', 11, 15, 200, 35);
        $this->setFont('Arial', 'B', 20);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        
        $this->Line(10, 45, 250 - 50, 45);

        $this->Ln(37);
        $this->setFont('Arial', 'B', 14);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(40, 6, $titel, 0, 1, 'C', 1);

    }

    function multiexplode($delimiters, $string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    function Content($get_jurnal,$get_header, $company) {
    $h = 3;
    $font_size = 7;

        $this->Ln(1);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($get_header as $s) {
           $reff= $s->no_reff;
           $tgl= $s->tanggal;
           $cur=$s->currency;
           $rate=$s->rate;
           $ratesgd=$s->rate_sgd;
           $remark = $s->remarks;

        }
        $this->cell(25, 6, 'Reff. Number  ', 0, 0, 'L', 1);
        $this->cell(25, 6,': '.$reff, 0, 1, 'L', 1);



        $this->cell(25, 6, 'Date ', 0, 0, 'L', 1);
        $this->cell(25, 6, ': '.date_format(New DateTime($tgl), 'M, d-Y'), 0, 1, 'L', 1);

        $this->cell(25, 6, 'Currency', 0, 0, '', 1);
        $this->cell(25, 6, ': '.$cur, 0, 0, 'L', 1);
        $this->cell(25, 6, 'Rate', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$rate, 0, 0, 'L', 1);
        $this->cell(25, 6, 'Rate SGD', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$ratesgd, 0, 1, 'L', 1);


        $this->cell(25, 6, 'Remark  ', 0, 0, 'L', 1);
        $this->MultiCell(165, 6,': '.$remark, 0, 1, 'L', 1);

        $this->Ln();

        $dw = array(20, 25, 30, 65, 25, 25);
        $da = array('C', 'C', 'L', 'L', 'R', 'R');
        $dc = array('C', 'C', 'C', 'C', 'C', 'C');


        $this->SetFont('arial', '', 5);
        $head_title = array(
            'Date', 'Account Numb', 'Account Name', 'Detail', 'Debet', 'Credit'
        );

        $arr_cell_height = array();
        for($i=0; $i < count($head_title); $i++):
            $arr_cell_height[$i] = $this->NbLines($dw[$i], $head_title[$i]);
        endfor;

        $hmax = max($arr_cell_height);

        $this->SetFont('Arial', 'B', $font_size);

        $hy = $this->GetY();
        $hx = 10;
        for($i=0; $i < count($head_title); $i++):
//            $this->Cell($dw[$i], 6,$head_title[$i], 'BLT', 0, $da[$i]);
            $this->SetXY($hx, $hy);
            if ($arr_cell_height[$i] > 0){
                $this->MultiCell($dw[$i], ($hmax / $arr_cell_height[$i]) * 6 , $head_title[$i], 'BLT', $dc[$i]);
            }
            $hx = $hx + $dw[$i];
        endfor;

        $this->SetXY($hx, $hy);
        $this->MultiCell(1,6,'','L',1);    // garis kanan
        $this->Ln(2);
        $this->SetFont('arial', '', $font_size);
        // $this->SetFont('NotoSans-Regular', '', $font_size);

        $this->SetWidths($dw);
        $this->SetAligns($da);

        foreach ($get_jurnal as $r) {

         $cdebet = number_format($r->debet,2,'.',',');
         $ccredit = number_format($r->credit,2,'.',',');

            // $etdsin = str_replace('-', '/', $r->etdsin);
            // $etasin = str_replace('-', '/', $r->etasin);

            // $container = (trim($r->container) != '') ? $r->container.' / ' : '';
            // $seal   = (trim($r->seal) != '') ? $r->seal.' / ' : '';

            if($r->dept_code == '0'){
                $dept_code = $r->no_coa .'-000' . '-00' . $company; 
            }else if($r->dept_code == ''){
                $dept_code =$r->no_coa;
            }
            else {
                $dept_code = $r->no_coa .'-' . $r->dept_code . '-00' . $company;
            }

            $this->Row(
                array(
                    $r->tanggal,
                    $dept_code,
                    $r->JenisJurnalID,
                    // str_replace('/20', '/', $etdsin),
                    // str_replace('/20', '/', $etasin),
                    // $r->port_name.', '.$r->destination_country,
                    $r->description,
                    $cdebet,
                    $ccredit,
                    // $r->product,
                    // $container."\n".$seal."\n".$r->container_size."' ".$r->container_abbr,
                    // $r->reff."\n".$r->shipping

                )
            );
        }

//        $this->Ln(1);
//        $this->Cell(275, $h, 'Issued By : Ikbal', 0, 1, 'R');

        //atur posisi 1.5 cm dari bawah
        //$this->SetY(-70);
        //nomor halaman
        $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());
        $this->ln(5);
        $this->cell(130, 6, '', 'T', 0, 'R');
        $this->cell(30, 6, 'TOTAL AMOUNT', 'T', 0, 'R', 1);
        $this->cell(30, 6, number_format($this->data['totals'], 2), 'BTRL', 1, 'R', 1);
        //$this->ln(5);
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $this->Cell(0, 10, 'FOR ZHENGHE LOGISTIC PTE LTD', 0, 0, 'R');
        $this->Cell(0, 20, '', 0, 0, 'R');
        $this->Cell(0, 50, '..........................................................................', 0, 0, 'R');

       
        $this->Cell(5, 10, '', 0, 1 );
         $this->setFont('', 'I', 9);
        $this->Cell(1, 45, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition', 0, 0);
        $this->Cell(0, 55, 'copy is available upon request.', 0, 0);

    }

    function Footer() {
        // //atur posisi 1.5 cm dari bawah
        // $this->SetY(-70);
        // //nomor halaman
        //  // $this->Line(10, $this->GetY(), 250 - 50, $this->GetY());
        // $this->cell(130, 6, '', 'T', 0, 'R');
        // $this->cell(30, 6, 'TOTAL AMOUNT', 'T', 0, 'R', 1);
        // $this->cell(30, 6, number_format($this->data['totals'], 2), 'BTRL', 1, 'R', 1);
        // $this->ln(15);
        // $this->setFont('Arial', 'B', 9);
        // $this->setFillColor(255, 255, 255);
        // $this->Cell(0, 10, 'FOR PULAU SAMBU SINGAPORE PTE LTD', 0, 0, 'R');
        // $this->Cell(0, 20, '', 0, 0, 'R');
        // $this->Cell(0, 50, '..........................................................................', 0, 0, 'R');
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

    function Row($get_jurnal) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($get_jurnal); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $get_jurnal[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($get_jurnal); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //$this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 3, $get_jurnal[$i], 0, $a);
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

$pdf = new PDF();
$pdf->setData($ini);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_jurnal,$get_header, $company);
$pdf->Output();
