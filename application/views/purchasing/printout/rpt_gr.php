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
        $this->Cell(0, 10, 'GOOD RECEIPT', 0, 0);
        $this->Ln(15);
        $this->SetFont('Times', '', 9);
        $this->SetX(11);
        $this->Cell(20, 4, 'Document Date', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'GR No', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->docno, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'Arrived Date', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->duedate, 0, 0);

        $this->Ln();



        $y = $this->GetY();
        $this->Line(10, 65, 253 - 50, 65);
        $this->Line(10, 75, 253 - 50, 75);
        $this->Ln(7);
        $this->SetFont('Times', 'B', 9);
        $this->SetX(11);
        $this->Cell(10, 10, 'No', '', 0, 'C');
        $this->SetX(28);
        $this->Cell(40, 10, 'Item Name', '', 0, 'L');
        $this->Cell(35, 10, 'UOM', '', 0, 'R');
        $this->Cell(23, 10, 'PO No', '', 0, 'R');
        $this->Cell(25, 10, 'Qty Order', '', 0, 'R');
        $this->Cell(23, 10, 'Qty Receiv', '', 0, 'R');
        $this->Cell(23, 10, 'Shelf Life', '', 0, 'R');
        $this->Ln();

        // WATERMARK

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

foreach ($packgr as $r) {
    $docno = $r->docno;
    $docdate = date("d/m/Y",  strtotime($r->docdate));
    $duedate = date("d/m/Y",  strtotime($r->duedate));

    // $amendmentdateTemp = $r->amendmentdate;
    // if ($amendmentdateTemp != '0000-00-00') {
    //     $amendmentdate = date("d/m/Y",  strtotime($amendmentdateTemp));
    // } else {
    //     $amendmentdate = '';
    // }
    //$status = $r->status;
    $createdby = $r->createdby;
    // $remark = $r->remark;
    // $remarks = $r->remarks;
    $shelf = $r->shelf;
}

$pdf = new PDF('P', 'mm', 'A4');

$pdf->docno = $docno;
$pdf->shelf = $shelf;
$pdf->docdate = $docdate;
$pdf->duedate = $duedate;
$pdf->created = $createdby;
// $pdf->remark = $remark;




$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 9);
$i = 1;

$totalqtypo = 0;
$totalqtywhs = 0;
$yawal = $pdf->GetY();
foreach ($packgr as $r) {

    $totalqtypo += $r->qtypo;
    $totalqtywhs += $r->qtywhs;

    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(29, $y);
    $pdf->MultiCell(104, 5, $r->itemid, 0, 'L');
    $pdf->SetXY(89, $y);
    $pdf->MultiCell(18, 5, $r->uomname, 0, 'C');
    $pdf->SetXY(110, $y);
    $pdf->MultiCell(20, 5, $r->mainpo, 0, 'R');
    $pdf->SetXY(128, $y);
    $pdf->MultiCell(20, 5, number_format($r->qtypo, 2), 0, 'R');
    $pdf->SetXY(150, $y);
    $pdf->MultiCell(20, 5, number_format($r->qtywhs, 2), 0, 'R');
    $pdf->SetXY(175, $y);
    $pdf->MultiCell(24, 5, $r->shelf, 0, 'R');
    $pdf->Ln();
    $y2 = $pdf->GetY() - 5;
    $pdf->SetXY(21, $y2);
    $pdf->MultiCell(104, 5, $r->itemname, 0, 'L');
    $pdf->Ln();

    // if($r->itemremark != ''){
    //     $y3 = $pdf->GetY() - 5;
    //     $pdf->SetXY(21,$y3);
    //     $pdf->MultiCell(94,10,$r->itemremark,0);
    //     $pdf->Ln();
    // }


    $y5 = $pdf->GetY() - 5;


    if ($y5 > 250) {
        $y6 = $pdf->GetY() - 5;
        $pdf->Line(11, $y6, 199, $y6);
        $pdf->AddPage();
    }
    $i++;
}
$y7 = $pdf->GetY() + 10;
$pdf->Line(11, $y7, 199, $y7);
$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(12, $y7);
$pdf->cell(40, 10, 'Total ', '');
$pdf->Ln();

$y0 = $pdf->GetY() + 1;
$pdf->Line(11, $y0, 199, $y0);
$pdf->Line(11, $y0, 199, $y0);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(40, $y7);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(114, $y7);
$pdf->cell(34, 10, ($totalqtypo > 0 ? number_format($totalqtypo, 2) : '-'), '', 0, 'R');
$pdf->SetXY(137, $y7);
$pdf->cell(34, 10, ($totalqtywhs > 0 ? number_format($totalqtywhs, 2) : '-'), '', 0, 'R');


$pdf->Ln();

$pdf->SetY(-30);

$pdf->SetX(20);
$pdf->Cell(40, 4, '', 'B');
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(8);
$pdf->Cell(40, 4, 'Delivery By', 0, 0, 'C');

$pdf->SetX(85);
$pdf->Cell(40, 4, '', 'B');
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(73);
$pdf->Cell(40, 4, 'Received By', 0, 0, 'C');

$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(143);
$pdf->Cell(40, 4, 'Approve By', 0, 0, 'C');
$pdf->SetFont('Times', '', 8);

$pdf->Output($docno . '.pdf', 'I');
