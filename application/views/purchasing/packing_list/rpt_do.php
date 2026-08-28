<?php
class PDF extends FPDF
{
    function Header()
    {
        $this->SetX(10);
        $this->Cell(190, 25, '', 0, 0);
        $this->Image('assets/zhlkop.PNG', 16, 3, 180, 33);
        $this->Line(10, 35, 250 - 50, 35);
        $this->Line(10, 35, 250 - 50, 35);
        $this->Ln(25);

        $this->SetX(10);
        $this->Cell(190, 243, '', 0, 0);
        $this->SetFont('Times', 'B', 18);
        $this->SetX(80);
        $this->Cell(0, 10, 'DELIVERY ORDER', 0, 0);
        $this->Ln(15);
        $this->SetFont('Times', '', 9);
        $this->SetX(11);
        $this->Cell(20, 4, 'Customer', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->custcompany, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'PL No', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->pl_no, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'Contact Person', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->custcontact, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Date', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->SetX(140);
        $this->Cell(20, 4, 'Shipment Date', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->shipdate_pl, 0, 0);


        $y = $this->GetY();
        $this->Line(10, 65, 253 - 50, 65);
        $this->Line(10, 75, 253 - 50, 75);
        $this->Ln(7);
        $this->SetFont('Times', 'B', 9);
        $this->SetX(11);
        $this->Cell(10, 10, 'No', '', 0, 'C');
        $this->SetX(21);
        $this->Cell(60, 10, 'Item Name', '', 0, 'C');
        $this->Cell(22, 10, 'UOM', '', 0, 'R');
        $this->Cell(35, 10, 'Quantity', '', 0, 'R');
        $this->Cell(30, 10, 'Nett Weight (kgs)', '', 0, 'R');
        $this->Cell(33, 10, 'Gross Weight (kgs)', '', 0, 'R');

        $this->Ln();

        // WATERMARK
        if ($this->status == 3) {
            $this->SetFont('ARIAL', 'B', 50);
            $this->SetTextColor(255, 192, 203);
            $this->RotatedText(52, 190, 'C A N C E L L E D', 40);
        }
    }

    function Footer()
    {
        $this->SetY(-35);
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->SetX(155);
        $this->Cell(40, 4, 'Printed By : ' . $this->created);
        $this->Ln();
        $this->SetFont('Times', 'I', 8);
        $this->SetX(155);
        $this->Cell(40, 4, 'Page ' . $this->PageNo() . '/{nb}');
    }

    // PDF_Rotate (untuk watermark)
    // http://www.fpdf.org/en/script/script2.php
    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle)
    {
        //Image rotated around its upper-left corner
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }
}

foreach ($packdo as $r) {
    $pl_no = $r->pl_no;
    $shipdate_pl =
        date("d/m/Y",  strtotime($r->shipdate_pl));
    $docdate = date("d/m/Y",  strtotime($r->docdate));

    $status = $r->status;
    $createdby = $r->createdby;
    $remark = $r->remark;
    $custcompany = $r->custcompany;
    $custcontact = $r->custcontact;
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->status = $status;
$pdf->pl_no = $pl_no;
$pdf->shipdate_pl = $shipdate_pl;
$pdf->docdate = $docdate;
$pdf->created = $createdby;
$pdf->remark = $remark;
$pdf->custcontact = $r->custcontact;
$pdf->custcompany = $custcompany;



$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 9);
$i = 1;
$totalnet = 0;
$totalgros = 0;
$totalqty = 0;
$yawal = $pdf->GetY();
foreach ($packdo as $r) {
    $totalnet += $r->neetweight;
    $totalgros += $r->grossweight;
    $totalqty += $r->qty;

    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(29, $y);
    $pdf->MultiCell(104, 5, $r->descriptions, 0, 'L');
    $pdf->SetXY(90, $y);
    $pdf->MultiCell(18, 5, $r->uomname, 0, 'C');
    $pdf->SetXY(115, $y);
    $pdf->MultiCell(20, 5, number_format($r->qty, 2), 0, 'R');
    $pdf->SetXY(140, $y);
    $pdf->MultiCell(20, 5, number_format($r->neetweight, 2), 0, 'R');
    $pdf->SetXY(165, $y);
    $pdf->MultiCell(24, 5, number_format($r->grossweight, 2), 0, 'R');
    $pdf->Ln();
    //  $y2 = $pdf->GetY() - 5;
    // $pdf->SetXY(21,$y2);
    // $pdf->MultiCell(104,5,$r->itemname,0,'L');
    // $pdf->Ln();

    // if($r->itemremark != ''){
    //     $y3 = $pdf->GetY() - 5;
    //     $pdf->SetXY(21,$y3);
    //     $pdf->MultiCell(94,10,$r->itemremark,0);
    //     $pdf->Ln();
    // }


    $y5 = $pdf->GetY() - 5;
    // $pdf->Line(11, $yawal, 11, $y5);
    // $pdf->Line(21, $yawal, 21, $y5);
    // $pdf->Line(120, $yawal, 120, $y5);
    // $pdf->Line(140, $yawal, 140, $y5);
    // $pdf->Line(155, $yawal, 155, $y5);
    // $pdf->Line(175, $yawal, 175, $y5);
    // $pdf->Line(199, $yawal, 199, $y5);

    if ($y5 > 250) {
        $y6 = $pdf->GetY() - 5;
        $pdf->Line(11, $y6, 199, $y6);
        $pdf->AddPage();
    }
    $i++;
}
$y7 = $pdf->GetY() + 30;
$pdf->Line(11, $y7, 199, $y7);
$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(12, $y7);
$pdf->cell(40, 10, 'Total ', '');
$pdf->Ln();
// $pdf->SetXY(12, $y7 + 4);
// $pdf->cell(40, 10, 'Discount', '');
// $pdf->Ln();
// $pdf->SetXY(12, $y7 + 8);
// $pdf->cell(40, 10, 'Freight', '');
// $pdf->Ln();
// $pdf->SetXY(12, $y7 + 12);
// $pdf->cell(40, 10, 'GST ' . number_format($taxprice, 0) . ' %', '');
// $pdf->Ln();
// $pdf->SetXY(12, $y7 + 16);
// $pdf->cell(40, 10, 'Grand Total', '');
// $pdf->Ln();
$y0 = $pdf->GetY() + 1;
$pdf->Line(11, $y0, 199, $y0);
$pdf->Line(11, $y0, 199, $y0);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(40, $y7);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(100, $y7);
$pdf->cell(34, 10, ($totalqty > 0 ? number_format($totalqty, 2) : '-'), '', 0, 'R');
$pdf->SetXY(128, $y7);
$pdf->cell(34, 10, ($totalnet > 0 ? number_format($totalnet, 2) : '-'), '', 0, 'R');
$pdf->SetXY(155, $y7);
$pdf->cell(34, 10, ($totalgros > 0 ? number_format($totalgros, 2) : '-'), '', 0, 'R');
$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Shipping Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, '');
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Payment Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, '');
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(34, 4, 'Remarks :');
$pdf->Ln();
$pdf->SetFont('Times', '', 9);
$pdf->SetX(11);
$pdf->MultiCell(180, 5, str_replace("<br />", "", $r->remark));
$pdf->Ln();

$pdf->SetY(-29);
$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(155);
$pdf->Cell(40, 4, 'Approve By', 0, 0, 'C');
$pdf->SetFont('Times', '', 8);

$pdf->Output($pl_no . '.pdf', 'I');
