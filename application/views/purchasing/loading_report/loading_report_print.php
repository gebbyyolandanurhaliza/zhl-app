<?php
class PDF extends FPDF
{
    function Header()
    {
        $this->SetX(10);
        $this->Cell(190, 25, '', 0, 0);
        $this->Image('assets/zhlkop.PNG', 18, 3, 180, 33);
        $this->Ln(25);
        $this->SetX(10);
        $this->Cell(190, 243, '', 0, 0);
        $this->SetFont('Times', 'B', 18);
        $this->SetX(10);
        $this->Cell(0, 10, 'LOADING REPORT', 0, 0);
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->SetX(11);
        $this->Cell(20, 4, 'Date', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Shipment Date', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->shipdate, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'LR No', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->lrno, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Shipment Via', 0, 0);
        $this->SetX(160);
        $this->Cell(29, 4, ': ' . $this->via, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'Customer', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->custid, 0, 0);
        $this->Ln(6);
        $this->SetX(11);
        $this->Cell(94, 4, 'Bill To :', 1, 0, 'C');
        $this->SetX(106);
        $this->Cell(93, 4, 'Ship / Deliver To :', 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', 'B', 10);
        $this->SetX(11);
        $this->Cell(94, 5, $this->customer_name);
        $this->SetX(106);
        $this->Cell(93, 5, $this->customer_name);
        $this->Ln();
        $y = $this->GetY();
        $this->SetFont('Times', '', 10);
        $this->SetX(11);
        $this->MultiCell(94, 4, str_replace("<br />", "", $this->custaddress));
        $this->SetXY(106, $y);
        $this->MultiCell(93, 4,  str_replace("<br />", "", $this->custaddress));
        $this->Ln(8);
        $this->SetX(11);
        $this->Cell(94, 4, 'Telephone : ' . $this->customer_contact_phone, 0, 0);
        $this->SetX(106);
        $this->Cell(93, 4, 'Telephone : ' . $this->customer_contact_phone, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(94, 4, 'Contact : ' . $this->customer_contact_name, 0, 0);
        $this->SetX(106);
        $this->Cell(93, 4, 'Contact : ' . $this->customer_contact_name, 0, 0);
        $this->Ln(7);
        $this->SetFont('Times', 'B', 9);
        $this->SetX(11);
        $this->Cell(10, 10, 'No', 'LT', 0, 'C');
        $this->SetX(21);
        $this->Cell(79, 5, 'Item Number', 'LT', 0, 'C');
        $this->SetX(100);
        $this->Cell(25, 5, 'Qty/UOM', 'LT', 0, 'C');
        $this->SetX(125);
        $this->Cell(25, 5, 'NPBB NO', 'LT', 0, 'C');
        $this->SetX(150);
        $this->Cell(27, 10, 'Nett Weight (kgs)', 'LT', 0, 'C');
        $this->SetX(177);
        $this->Cell(25, 10, 'Gross Weight(kgs)', 'LTR', 0, 'C');
        $this->SetX(199);
        $this->Cell(1, 5, '');
        $this->Ln();
        $this->SetX(11);
        $this->Cell(10, 5, '', 'LB');
        $this->SetX(21);
        $this->Cell(79, 5, 'Item Description', 'LTB', 0, 'C');
        $this->SetX(100);
        $this->Cell(25, 5, '', 'LB');
        $this->SetX(125);
        $this->Cell(25, 5, '', 'LB');
        $this->SetX(150);
        $this->Cell(27, 5, '', 'LB');
        $this->SetX(177);
        $this->Cell(25, 5, '', 'LBR');
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-35);
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->SetX(155);
        $this->Cell(40, 4, 'Printed By : ' . $this->createdby);
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

foreach ($lr as $r) {
    $lrno           = $r->lrno;
    $shipdate       = date("d-m-Y",  strtotime($r->shipdate));
    $docdate        = date("d-m-Y",  strtotime($r->docdate));
    $via            = $r->via;
    $custid         = $r->custid;
    $createdby      = $r->createdby;
    $customer_name  = $r->customercompany;
    $customer_contact_name = $r->contactperson;
    $customer_contact_phone = $r->telephone;
    $custaddress   = $r->address;
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->lrno      = $lrno;
$pdf->shipdate  = $shipdate;
$pdf->docdate   = $docdate;
$pdf->via       = $via;
$pdf->custid    = $custid;
$pdf->createdby = $createdby;
$pdf->customer_name = $customer_name;
$pdf->customer_contact_name = $customer_contact_name;
$pdf->customer_contact_phone = $customer_contact_phone;
$pdf->custaddress   = $custaddress;


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 8);
$i = 1;
$totalpackage = 0;
$yawal = $pdf->GetY();
foreach ($lr as $r) {

    if ($r->mainpo != '') {
        $mainpo = 'PO-NO:' . $r->mainpo;
    } else {
        $mainpo = '';
    }

    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(21, $y);
    $pdf->MultiCell(79, 5, $r->itemid, 0, 'L');
    $pdf->SetXY(100, $y);
    $pdf->MultiCell(25, 5, number_format($r->qty, 3) . ' ' . $r->uomname, 0, 'R');
    $pdf->SetXY(125, $y);
    $pdf->MultiCell(25, 5, $r->npbbno, 0, 'C');
    $pdf->SetXY(150, $y);
    $pdf->MultiCell(27, 5, number_format($r->neetweight, 2), 0, 'R');
    $pdf->SetXY(177, $y);
    $pdf->MultiCell(25, 5, number_format($r->grossweight, 2), 0, 'R');
    $pdf->Ln();
    $y2 = $pdf->GetY() - 5;
    $pdf->SetXY(21, $y2);
    $reportSubtitle = iconv('UTF-8', 'windows-1252', $r->itemname);
    $pdf->MultiCell(79, 5, $reportSubtitle, 0, 'L');
    $pdf->Ln();

    if ($mainpo != '') {
        $y4 = $pdf->GetY() - 5;
        $pdf->SetXY(21, $y4);
        $pdf->MultiCell(79, 5, $mainpo);
        $pdf->Ln();
    }

    $y5 = $pdf->GetY() - 5;
    $pdf->Line(11, $yawal, 11, $y5);
    $pdf->Line(21, $yawal, 21, $y5);
    $pdf->Line(100, $yawal, 100, $y5);
    $pdf->Line(125, $yawal, 125, $y5);
    $pdf->Line(150, $yawal, 150, $y5);
    $pdf->Line(177, $yawal, 177, $y5);
    $pdf->Line(202, $yawal, 202, $y5);

    if ($y5 > 250) {
        $y6 = $pdf->GetY() - 5;
        $pdf->Line(11, $y6, 202, $y6);
        $pdf->AddPage();
    }
    $i++;
}
$y7 = $pdf->GetY() - 5;

if ($y7 < $yawal) {
    $y7 = $yawal;
}

$pdf->Line(11, $y7, 202, $y7);

$pdf->Line(130, $y7 + 5, 202, $y7 + 5);
$pdf->SetFont('Times', '', 9);
$pdf->SetXY(130, $y7 + 5);
$pdf->cell(10, 10, 'Total Package', 'LB', 0, 'L');
$pdf->SetXY(140, $y7 + 5);
$pdf->cell(15, 10, '', 'BR', 0, 'R');
$pdf->SetFont('Times', '', 9);
$pdf->SetXY(155, $y7 + 5);
$pdf->cell(10, 10, '', 'LB', 0, 'L');
$pdf->SetXY(165, $y7 + 5);
$pdf->cell(37, 10, $r->total_pack, 'BR', 0, 'R');
$pdf->Ln(15);

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Remarks');
$pdf->SetX(40);
$pdf->Cell(26, 4, ':');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(42);
$pdf->MultiCell(50, 4, $r->remark);


$pdf->SetY(-29);
$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(155);
$pdf->Cell(40, 4, 'Approve By', 0, 0, 'C');
$pdf->SetFont('Times', '', 8);

$pdf->Output();
