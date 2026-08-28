<?php

class PDF extends FPDF {

    public function setData($data){
        $this->data=$data;
    }

    //Page header
    function Header() {
        $titel = 'Container Stock List :';
        $this->Image('assets/ZHL-Report.png', 58, 10, 35, 0, 'PNG');
        $this->setFont('Arial', 'B', 20);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(140, 6, 'ZHENGHE LOGISTIC PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(140, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(140, 6, '39 WOODLANDS CLOSE #02-07/08 MEGA@WOODLANDS, SINGAPORE 737856 ', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 8);
        $this->Cell(80);
        $this->cell(140, 6, 'booking@zhenghe.com.sg / shipping@zhenghe.com.sg', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->cell(140, 6, '', 0, 1, 'C', 1);

        $this->Line(10, 40, 300 - 10, 40);

        $this->Ln(4);
        $this->setFont('Arial', 'B', 14);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(80);
        $this->cell(140, 1, $titel, 0, 1, 'C', 1);
        $this->Ln(10);
    }

    function multiexplode($delimiters, $string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

//    function Content($get_jurnal,$get_header) {
    function Content($getstock) {
    $h = 3;
    $font_size = 7;

        $this->Ln(-6);
        $this->setFont('arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        foreach ($getstock as $s) {
                $tanggal_sekarang  = date('d-m-Y');
                $stock_id_hdr      = $s->stock_id_hdr;
                $stock_id_dtl      = $s->stock_id_dtl;
                $container_number  = $s->container_number;
                $container_id      = $s->container_id;
                $container_name    = $s->container_name;
                $loading_port      = $s->loading_port;
                $arrival_date      = date('d-m-Y', strtotime($s->arrival_date)); //tanggal jurnal
                $free_time         = $s->free_time;
                $Remark            = $s->Remark;
                $factory           = $s->factory;
                $supplier          = $s->supplier;
                $import_bl_no      = $s->import_bl_no;
                $eta               = date('d-m-Y', strtotime($s->eta)); //tanggal jurnal
                $free_time_expiry  = date('d-m-Y', strtotime($s->free_time_expiry)); //tanggal jurnal
        }

        $this->cell(25, 6, 'Reff. Number  ', 0, 0, 'L', 1);
        $this->cell(25, 6,': ', 0, 1, 'L', 1);

        $this->cell(25, 6, 'Date Print', 0, 0, 'L', 1);
        $this->cell(25, 6, ': '.date_format(New DateTime($tanggal_sekarang), 'M, d-Y'), 0, 1, 'L', 1);

        $this->cell(25, 6, 'Arrival Date', 0, 0, '', 1);
        $this->cell(25, 6, ': '.$arrival_date, 0, 0, 'L', 1);
        $this->cell(100, 6, 'Free Time', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$free_time.' Day', 0, 0, 'L', 1);
        $this->cell(85, 6, 'Estimation Time Arrival', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$eta, 0, 1, 'L', 1);

        $this->cell(260, 6, 'Free Time Expiry', 0, 0, 'R', 1);
        $this->cell(25, 6, ': '.$free_time_expiry, 0, 1, 'L', 1);

        // $this->cell(25, 6, 'Loading Port', 0, 0, 'L', 1);
        // $this->cell(25, 6, ': '.$loading_port, 0, 0, 'L', 1);
        // $this->cell(25, 6, 'Import BL No.  ', 0, 0, 'L', 1);
        // $this->cell(25, 6,': '.$import_bl_no, 0, 1, 'L', 1);

        $this->cell(25, 6, 'Loading Port  ', 0, 0, 'L', 1);
        $this->cell(165, 6,': '.$loading_port.'', 0, 1, 'L', 1);
        $this->cell(25, 6, 'Import BL No.  ', 0, 0, 'L', 1);
        $this->cell(165, 6,': '.$import_bl_no.'', 0, 1, 'L', 1);
        $this->cell(25, 6, 'Remark  ', 0, 0, 'L', 1);
        $this->cell(165, 6,': "'.$Remark.'"', 0, 1, 'L', 1);


        $this->Ln();

        $dw = array(10,70, 70, 60, 70);
        $da = array('C','L', 'L', 'L', 'L');
        $dc = array('C','C', 'C', 'C', 'C');


        $this->SetFont('arial', '', 5);
        $head_title = array(
            'No','Container Number', 'Container Type', 'Factory', 'Supplier'
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

        $no=1;
        foreach ($getstock as $r) {

                    $tanggal_sekarang  = date('d-m-Y');
                    $stock_id_hdr      = $r->stock_id_hdr;
                    $stock_id_dtl      = $r->stock_id_dtl;
                    $container_number  = $r->container_number;
                    $container_id      = $r->container_id;
                    $container_name    = $r->container_name;
                    $loading_port      = $r->loading_port;
                    $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
                    $free_time         = $r->free_time;
                    $Remark            = $r->Remark;
                    $factory           = $r->factory;
                    $supplier          = $r->supplier;
                    $import_bl_no      = $r->import_bl_no;
                    $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
                    $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal

                $this->Row(
                    array(
                        $no++,
                        $r->container_number,
                        $r->container_name,
                        $r->factory,
                        $r->supplier,
                )
            );
        }

        $this->ln(1);
        $this->cell(280, 6, '', 'T', 0, 'R');
        $this->ln(-5);
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(255, 255, 255);
        $this->Cell(0, 20, 'FOR ZHENGHE LOGISTIC PTE LTD,', 0, 0, 'R');
        $this->Cell(0, 20, '', 0, 0, 'R');
        $this->Cell(0, 50, '.............................................................', 0, 0, 'R');
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
        $h = 4 * $nb;
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

$pdf = new PDF("L","mm","A4");
//$pdf->setData($ini);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($getstock);
$pdf->Output();
