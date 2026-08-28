<?php
class PDF extends FPDF
{
    function Header()
    {
        if ($this->page == 1) {
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
            $this->Cell(0, 10, 'PURCHASE ORDER', 0, 0);
            $this->Ln(15);
            $this->SetFont('Times', '', 9);
            $this->SetX(11);
            $this->Cell(20, 4, 'Date', 0, 0);
            $this->SetX(31);
            $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
            $this->SetX(140);
            $this->Cell(20, 4, 'Delivery Date', 0, 0);
            $this->SetX(160);
            $this->Cell(29, 4, ': ' . $this->deliverdate, 0, 0);
            $this->Ln();
            $this->SetFont('Times', '', 9);
            // $this->SetX(11);
            // $this->Cell(20, 4, 'Vendor', 0, 0);
            // $this->SetX(31);
            // $this->Cell(29, 4, ': ' . $this->vendorname, 0, 0);
            $this->SetX(140);
            $this->Cell(20, 4, 'PO / PR', 0, 0);
            $this->SetX(160);
            $this->Cell(29, 4, ': ' . $this->mainpo, 0, 0);
            $this->Ln();
            // $this->SetX(11);
            // $this->Cell(20, 4, 'Contact', 0, 0);
            // $this->SetX(31);
            // $this->Cell(29, 4, ': ' . $this->vendorcontact, 0, 0);
            $this->SetX(140);
            $this->Cell(20, 4, 'Curency', 0, 0);
            $this->SetX(160);
            $this->Cell(29, 4, ': ' . $this->currency, 0, 0);
            $this->Ln(6);
            $this->SetX(11);
            $this->Cell(95, 4, 'Vendor :', 1, 0, 'C');
            $this->SetX(112);
            $this->Cell(93, 4, 'Ship / Deliver To :', 1, 0, 'C');
            $this->Ln();
            $this->SetFont('Times', 'B', 10);
            $this->SetX(11);
            $this->Cell(100, 5, $this->vendorname);
            $this->SetX(112);
            $this->Cell(93, 5, $this->whsname);
            $this->Ln();
            $y = $this->GetY();
            $this->SetFont('Times', '', 10);
            $this->SetX(11);
            $this->MultiCell(90, 4, str_replace("<br />", "", $this->vendoraddress) . ' ' . $this->vendorpostal);
            $this->SetXY(112, $y);
            $this->MultiCell(93, 4,  str_replace("<br />", "", $this->whsaddress));
            $this->Ln(12);
            $this->SetX(11);
            $this->Cell(94, 4, 'Telephone : ' . $this->vendortelp, 0, 0);
            $this->SetX(112);
            $this->Cell(93, 4, 'Telephone : ' . $this->whstelp, 0, 0);
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94, 4, 'Contact : ' . $this->vendorcontact, 0, 0);
            $this->SetX(112);
            $this->Cell(93, 4, 'Contact : ' . $this->whscontact, 0, 0);
            $this->Ln();




            $y = $this->GetY();
            $this->Line(10, 110, 253 - 50, 110);
            $this->Line(10, 118, 253 - 50, 118);
            $this->Ln(5);
            $this->SetFont('Times', 'B', 9);
            $this->SetX(11);
            $this->Cell(10, 10, 'No', '', 0, 'C');
            $this->SetX(28);
            $this->Cell(40, 10, 'Item Name', '', 0, 'L');
            $this->Cell(35, 10, 'UOM', '', 0, 'R');
            $this->Cell(40, 10, 'Quantity', '', 0, 'R');
            $this->Cell(27, 10, 'Price', '', 0, 'R');
            $this->Cell(29, 10, 'Total', '', 0, 'R');

            $this->Ln();
        }
        if ($this->page == 2) {
            $this->SetX(10);
            $this->Cell(190, 25, '', 0, 0);
            $this->Image('assets/zhlkop.PNG', 16, 3, 180, 33);
            $this->Line(10, 35, 250 - 50, 35);
            $this->Line(10, 35, 250 - 50, 35);
            $this->Ln(25);

            $this->SetX(10);
            $this->Cell(190, 243, '', 0, 0);
            $this->SetFont('Times', 'B', 18);
            $this->SetX(60);
            $this->Cell(0, 10, 'PURCHASE REQUISITION', 0, 0);
            $this->Ln(15);
            $this->SetFont('Times', '', 9);
            $this->SetX(11);
            $this->Cell(20, 4, 'Date', 0, 0);
            $this->SetX(31);
            $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
            $this->SetX(140);
            $this->Cell(20, 4, 'Delivery Date', 0, 0);
            $this->SetX(160);
            $this->Cell(29, 4, ': ' . $this->deliverdate, 0, 0);
            $this->Ln();
            // $this->SetFont('Times', '', 9);
            // $this->SetX(11);
            // $this->Cell(20, 4, 'Vendor', 0, 0);
            // $this->SetX(31);
            // $this->Cell(29, 4, ': ' . $this->vendorname, 0, 0);
            $this->SetX(140);
            $this->Cell(20, 4, 'PO / PR', 0, 0);
            $this->SetX(160);
            $this->Cell(29, 4, ': ' . $this->mainpo, 0, 0);
            $this->Ln();
            // $this->SetX(11);
            // $this->Cell(20, 4, 'Contact', 0, 0);
            // $this->SetX(31);
            // $this->Cell(29, 4, ': ' . $this->vendorcontact, 0, 0);
            // $this->SetX(140);
            // $this->Cell(20, 4, 'Curency', 0, 0);
            // $this->SetX(160);
            // $this->Cell(29, 4, ': ' . $this->currency, 0, 0);
            $this->Ln(6);
            $this->SetX(11);
            $this->Cell(95, 4, 'Vendor :', 1, 0, 'C');
            $this->SetX(112);
            $this->Cell(93, 4, 'Ship / Deliver To :', 1, 0, 'C');
            $this->Ln();
            $this->SetFont('Times', 'B', 10);
            $this->SetX(11);
            $this->Cell(100, 5, $this->vendorname);
            $this->SetX(112);
            $this->Cell(93, 5, $this->whsname);
            $this->Ln();
            $y = $this->GetY();
            $this->SetFont('Times', '', 10);
            $this->SetX(11);
            $this->MultiCell(90, 4, str_replace("<br />", "", $this->vendoraddress) . ' ' . $this->vendorpostal);
            $this->SetXY(112, $y);
            $this->MultiCell(93, 4,  str_replace("<br />", "", $this->whsaddress));
            $this->Ln(12);
            $this->SetX(11);
            $this->Cell(94, 4, 'Telephone : ' . $this->vendortelp, 0, 0);
            $this->SetX(112);
            $this->Cell(93, 4, 'Telephone : ' . $this->whstelp, 0, 0);
            $this->Ln();
            $this->SetX(11);
            $this->Cell(94, 4, 'Contact : ' . $this->vendorcontact, 0, 0);
            $this->SetX(112);
            $this->Cell(93, 4, 'Contact : ' . $this->whscontact, 0, 0);
            $this->Ln();




            $y = $this->GetY();
            $this->Line(10, 110, 253 - 50, 110);
            $this->Line(10, 118, 253 - 50, 118);
            $this->Ln(5);
            $this->SetFont('Times', 'B', 9);
            $this->SetX(11);
            $this->Cell(10, 10, 'No', '', 0, 'C');
            $this->SetX(29);
            $this->Cell(35, 10, 'Item Name', '', 0, 'L');
            $this->Cell(66, 10, 'UOM', '', 0, 'R');
            $this->Cell(60, 10, 'Quantity', '', 0, 'R');
            $this->Ln();
        }
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

foreach ($_getPO as $r) {
    $mainpo = $r->mainpo;
    $vendorid = $r->vendorid;
    $docdate = date("d/m/Y",  strtotime($r->docdate));
    $deliverdate = date("d/m/Y",  strtotime($r->deliverdate));

    $amendmentdateTemp = $r->amendmentdate;
    if ($amendmentdateTemp != '0000-00-00') {
        $amendmentdate = date("d/m/Y",  strtotime($amendmentdateTemp));
    } else {
        $amendmentdate = '';
    }
    $status = $r->status;
    $createdby = $r->createdby;
    $remark = $r->remark;
    $remarks = $r->remarks;
    $maintotal = $r->maintotal;
    $freight = $r->freight;
    $disc = $r->discount;
    $tax =  $r->tax;
    $totaldue = $r->totaldue;
    $tradename = $r->tradename;
    $currency = $r->currency;
    $custcompany = $r->custcompany;
    $whsid = $r->whsid;
    $per1000 = $r->per1000;
    $include = $r->include;
    $taxfreight = ($maintotal - $disc) / 100;
    if ($include != 0) {
        // if ($freight > 0) {
        $taxprice = 9;
    } else {
        $taxprice = 0;
    }
    $taxfreight = (($maintotal - $disc) + $freight) / 100;
    //}

    // $tax = $taxprice * $taxfreight;
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->status = $status;
$pdf->mainpo = $mainpo;
$pdf->vendor = $vendorid;
$pdf->vendorname = $vendor->vendorcompany;
$pdf->vendoraddress = $vendor->address;
$pdf->vendorpostal = $vendor->postalcode;
$pdf->vendortelp = $vendor->telephone;
$pdf->vendorcontact = $vendor->contactperson;
$pdf->whsname = $whs->name;
$pdf->whsaddress = $whs->address;
$pdf->whstelp = $whs->telephone;
$pdf->whscontact = $whs->contact;
$pdf->paymentterm = $vendor->paymentterm;
$pdf->docdate = $docdate;
//$pdf->duedate = $duedate;
$pdf->deliverdate = $deliverdate;
$pdf->amendmentdate = $amendmentdate;
$pdf->created = $createdby;
$pdf->remark = $remark;
//$pdf->vendorref = $vendorref;
$pdf->custcompany = $custcompany;
$pdf->per1000 = $per1000;
$pdf->currency = $currency;



$pdf->AliasNbPages();

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 9);
$i = 1;
$pdf->AddPage();
$totalqtypo = 0;
$totalprice = 0;
$yawal = $pdf->GetY();


foreach ($_getPO as $r) {

    $totalqtypo += $r->qty;
    $totalprice += $r->total;

    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(29, $y);
    $pdf->MultiCell(104, 5, $r->itemid, 0, 'L');
    $pdf->SetXY(89, $y);
    $pdf->MultiCell(18, 5, $r->uomname, 0, 'C');
    $pdf->SetXY(120, $y);
    $pdf->MultiCell(20, 5, number_format($r->qty, 2), 0, 'R');
    $pdf->SetXY(150, $y);
    $pdf->MultiCell(20, 5, number_format($r->unitprice, 2), 0, 'R');
    $pdf->SetXY(177, $y);
    $pdf->MultiCell(24, 5, number_format($r->total, 2), 0, 'R');
    $pdf->Ln();
    $y2 = $pdf->GetY() - 5;
    $pdf->SetXY(21, $y2);
    $pdf->MultiCell(104, 5, $r->itemname, 0, 'L');
    $pdf->Ln();

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
$pdf->cell(40, 10, 'Sub Total ', '');
$pdf->Ln();
$pdf->SetXY(12, $y7 + 4);
$pdf->cell(40, 10, 'Discount', '');
$pdf->Ln();
$pdf->SetXY(12, $y7 + 8);
$pdf->cell(40, 10, 'Freight', '');
$pdf->Ln();
$pdf->SetXY(12, $y7 + 12);
$pdf->cell(40, 10, 'GST ' . number_format($taxprice, 0) . ' %', '');
$pdf->Ln();
$pdf->SetXY(12, $y7 + 16);
$pdf->cell(40, 10, 'Grand Total', '');
$pdf->Ln();
$y0 = $pdf->GetY() + 1;
$pdf->Line(11, $y0, 199, $y0);
$pdf->Line(11, $y0, 199, $y0);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(40, $y7);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(108, $y7);
$pdf->cell(34, 10, ($totalqtypo > 0 ? number_format($totalqtypo, 2) : '-'), '', 0, 'R');
$pdf->SetXY(165, $y7);
$pdf->cell(34, 10, ($maintotal > 0 ? number_format($maintotal, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->SetXY(40, $y7 + 4);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(165, $y7 + 4);
$pdf->cell(34, 10, ($disc > 0 ? number_format($disc, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->SetXY(40, $y7 + 8);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(165, $y7 + 8);
$pdf->cell(34, 10, ($freight > 0 ? number_format($freight, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->SetXY(40, $y7 + 12);
$pdf->cell(10, 10, ': ', '', 0, 'L');
$pdf->SetXY(165, $y7 + 12);
$pdf->cell(34, 10, ($tax > 0 ? number_format($tax, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->SetXY(40, $y7 + 16);
$pdf->cell(10, 10, ': ', '', 0, 'L');
// $pdf->cell(10,10,($totaldue > 0 ? $cur : ''),'',0,'L');
$pdf->SetXY(165, $y7 + 16);
$pdf->cell(34, 10, ($totaldue > 0 ? number_format($totaldue, 2) : '-'), '', 0, 'R');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Shipping Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, $tradename);
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Payment Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, $vendor->paymentterm);
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(34, 4, 'Remarks :');
$pdf->Ln();
$pdf->SetFont('Times', '', 9);
$pdf->SetX(11);
$pdf->MultiCell(180, 5, str_replace("<br />", "", $r->remarks));
$pdf->Ln();

$pdf->SetY(-29);
$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(155);
$pdf->Cell(40, 4, 'Approve By', 0, 0, 'C');
$pdf->SetFont('Times', '', 8);

$pdf->AddPage();

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 9);


$i = 1;
$totalqtypo = 0;
foreach ($_getPO as $r) {

    $totalqtypo += $r->qty;


    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(29, $y);
    $pdf->MultiCell(104, 5, $r->itemid, 0, 'L');
    $pdf->SetXY(117, $y);
    $pdf->MultiCell(18, 5, $r->uomname, 0, 'C');
    $pdf->SetXY(168, $y);
    $pdf->MultiCell(20, 5, number_format($r->qty, 2), 0, 'R');

    $pdf->Ln();
    $y2 = $pdf->GetY() - 5;
    $pdf->SetXY(21, $y2);
    $pdf->MultiCell(104, 5, $r->itemname, 0, 'L');
    $pdf->Ln();

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
$pdf->SetXY(155, $y7);
$pdf->cell(34, 10, ($totalqtypo > 0 ? number_format($totalqtypo, 2) : '-'), '', 0, 'R');


$pdf->Ln();



// $pdf->SetXY(40, $y7 + 4);
// $pdf->cell(10, 10, ': ', '', 0, 'L');
// $pdf->SetXY(165, $y7 + 4);
// $pdf->cell(34, 10, ($disc > 0 ? number_format($disc, 2) : '-'), '', 0, 'R');
// $pdf->Ln();
// $pdf->SetXY(40, $y7 + 8);
// $pdf->cell(10, 10, ': ', '', 0, 'L');
// $pdf->SetXY(165, $y7 + 8);
// $pdf->cell(34, 10, ($freight > 0 ? number_format($freight, 2) : '-'), '', 0, 'R');
// $pdf->Ln();
// $pdf->SetXY(40, $y7 + 12);
// $pdf->cell(10, 10, ': ', '', 0, 'L');
// $pdf->SetXY(165, $y7 + 12);
// $pdf->cell(34, 10, ($tax > 0 ? number_format($tax, 2) : '-'), '', 0, 'R');
// $pdf->Ln();
// $pdf->SetXY(40, $y7 + 16);
// $pdf->cell(10, 10, ': ', '', 0, 'L');
// // $pdf->cell(10,10,($totaldue > 0 ? $cur : ''),'',0,'L');
// $pdf->SetXY(165, $y7 + 16);
// $pdf->cell(34, 10, ($totaldue > 0 ? number_format($totaldue, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Shipping Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, $tradename);
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(26, 4, 'Payment Term : ');
$pdf->SetFont('Times', '', 10);
$pdf->SetX(37);
$pdf->Cell(34, 4, $vendor->paymentterm);
$pdf->Ln();

$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(11);
$pdf->Cell(34, 4, 'Remarks :');
$pdf->Ln();
$pdf->SetFont('Times', '', 9);
$pdf->SetX(11);
$pdf->MultiCell(180, 5, str_replace("<br />", "", $r->remarks));
$pdf->Ln();

$pdf->SetY(-29);
$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(155);
$pdf->Cell(40, 4, 'Approve By', 0, 0, 'C');
$pdf->SetFont('Times', '', 8);
//$pdf->AddPage();
$pdf->Output($mainpo . '.pdf', 'I');
