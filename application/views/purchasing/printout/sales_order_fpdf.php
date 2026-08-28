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
        $this->SetX(60);
        $this->Cell(0, 10, 'DELIVERY SALES ORDER', 0, 0);
        $this->Ln();
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->SetX(11);
        $this->Cell(20, 4, 'Invoice No', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->sono, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Shipping Terms', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ', 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'To', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->custcompany, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Date', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->Cell(20, 4, 'Contact', 0, 0);
        $this->SetX(31);
        $this->Cell(29, 4, ': ' . $this->custcontact, 0, 0);
        $this->SetX(140);
        $this->Cell(20, 4, 'Delivery Date', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);
        $this->Ln();
        $this->SetX(140);
        $this->Cell(20, 4, 'Due Date', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ' . $this->docdate, 0, 0);

        $this->SetX(11);
        $this->Cell(20, 4, 'Address', 0, 0);
        $this->Cell(24, 4, ':', 0, 0);
        $this->SetX(32);
        $this->MultiCell(90, 4, $this->customer_address, 0);
        $this->SetX(11);
        $this->Cell(20, 4, 'Payment Terms', 0, 0);
        $this->Cell(24, 4, ':', 0, 0);
        $this->SetX(32);
        $this->MultiCell(95, 4, $this->paymentterm, 0);
        $this->SetX(11);
        $this->Cell(20, 4, 'Shipping Method :', 0, 0);
        $this->SetX(32);
        $this->MultiCell(95, 4, '', 0);

        // $this->SetX(11);
        // $this->Cell(20, 4, 'Payment Terms', 0, 0);
        // $this->SetX(170);
        // $this->Cell(29, 4, ': ' . $this->paymentterm, 0, 0);


        $y = $this->GetY();
        // $y7 = $pdf->GetY() + 30;
        $this->Line(11, $y + 6, 199, $y + 6);
        $this->Line(11, $y + 17, 199, $y + 17);
        $this->Ln(7);
        $this->SetFont('Times', 'B', 9);
        $this->SetX(11);
        $this->Cell(10, 10, 'No', '', 0, 'C');
        $this->SetX(21);
        $this->Cell(30, 10, 'Item', '', 0, 'C');
        $this->Cell(30, 10, 'Description', '', 0, 'R');
        $this->Cell(60, 10, 'Pack size', '', 0, 'R');
        $this->Cell(28, 10, 'Quantity', '', 0, 'R');
        $this->Cell(25, 10, 'Uom', '', 0, 'R');


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
        if ($this->page == 1) {
            $this->SetY(-35);
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->SetX(11);
            $this->SetFont('Times', 'I', 13);
            $this->Cell(10, 4, 'Finance Copy');
            $this->Ln();
            $this->SetX(155);
            $this->SetFont('Times', 'I', 8);
            $this->Cell(40, 4, 'Page ' . $this->PageNo() . '/{nb}');
        }
        if ($this->page == 2) {
            $this->SetY(-35);
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->Ln();
            $this->SetX(11);
            $this->SetFont('Times', 'I', 13);
            $this->Cell(40, 4, 'Customer Copy');
            $this->Ln();
            $this->SetFont('Times', 'I', 8);
            $this->SetX(155);
            $this->Cell(40, 4, 'Page ' . $this->PageNo() . '/{nb}');
        }
        if ($this->page == 3) {

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

foreach ($_getSO as $r) {
    $sono = $r->sono;
    $docdate = date("d/m/Y",  strtotime($r->docdate));
    $NettWeight = $r->NettWeight;
    $GrossWeight = $r->GrossWeight;
    $status = $r->status;
    $createdby = $r->createdby;
    $remarks = $r->remarks;
    $maintotal = $r->maintotal;
    $freight = $r->freight;
    $disc = $r->discount;
    $tax =  $r->tax;
    $totaldue = $r->totaldue;
    $currency = $r->currency;
    $custcompany = $r->custcompany;
    $custcontact = $r->custcontact;
    $paymentterm = $r->paymentterm;
    $customer_address = $r->customer_address;
    $itemid = $r->itemid;
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->status = $status;
$pdf->sono = $sono;
$pdf->paymentterm = $paymentterm;
$pdf->docdate = $docdate;
$pdf->custcontact = $custcontact;
$pdf->remarks = $remarks;
$pdf->custcompany = $custcompany;
$pdf->tax = $tax;
$pdf->createdby = $createdby;
$pdf->currency = $currency;
$pdf->customer_address = $customer_address;
$pdf->itemid = $itemid;





$x = 0;
for ($x = 0; $x <= 1; $x++) {
    $totalqty = 0;


    $i = 1;
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('Times', '', 9);
    $pdf->AddPage();

    $pdf->AliasNbPages();
    foreach ($_getSO as $r) {
        $totalqty += $r->qty;

        $y = $pdf->GetY();
        $pdf->Ln();
        $pdf->SetXY(11, $y);
        $pdf->MultiCell(10, 5, $i, 0, 'C');
        $pdf->SetXY(27, $y);
        $pdf->MultiCell(18, 5, $r->itemid, 0, 'C');
        $pdf->SetXY(118, $y);
        $pdf->MultiCell(20, 5, '', 0, 'R');
        $pdf->SetXY(145, $y);
        $pdf->MultiCell(20, 5, number_format($r->qty, 2), 0, 'R');
        $pdf->SetXY(173, $y);
        $pdf->MultiCell(24, 5, $r->uomname, 0, 'R');

        $y2 = $pdf->GetY() - 5;
        $pdf->SetXY(50, $y2);
        $pdf->MultiCell(70, 5, $r->itemname, 0, 'L');
        $pdf->Ln();

        // $y5 = $pdf->GetY() - 5;

        // if ($y5 > 250) {
        //     $y6 = $pdf->GetY() - 5;
        //     $pdf->Line(11, $y6, 199, $y6);
        //     //  $pdf->AddPage();
        // }
        $i++;
    }

    $y7 = $pdf->GetY() + 10;
    $pdf->Line(11, $y7, 199, $y7);
    $pdf->SetFont('Times', 'B', 9);
    $pdf->SetXY(12, $y7);
    $pdf->cell(40, 10, 'Total ', '');
    // $pdf->Ln();
    // $pdf->SetXY(12, $y7 + 4);
    // $pdf->cell(40, 10, 'Discount', '');
    // $pdf->Ln();
    // $pdf->SetXY(12, $y7 + 8);
    // $pdf->cell(40, 10, 'Freight', '');
    // $pdf->Ln();
    // $pdf->SetXY(12, $y7 + 12);
    // $pdf->cell(40, 10, 'GST ' . number_format($tax, 0) . ' %', '');
    // $pdf->Ln();
    // $pdf->SetXY(12, $y7 + 16);
    // $pdf->cell(40, 10, 'Grand Total', '');
    $pdf->Ln();
    $y0 = $pdf->GetY() + 1;
    $pdf->Line(11, $y0, 199, $y0);
    $pdf->Line(11, $y0, 199, $y0);

    $pdf->SetFont('Times', 'B', 9);
    $pdf->SetXY(40, $y7);
    $pdf->cell(10, 10, ': ', '', 0, 'L');
    $pdf->SetXY(131, $y7);
    $pdf->cell(34, 10, ($totalqty > 0 ? number_format($totalqty, 2) : '-'), '', 0, 'R');
    // $pdf->SetXY(110, $y7);
    // $pdf->cell(34, 10, ($totNettWeight > 0 ? number_format($totNettWeight, 2) : '-'), '', 0, 'R');
    // $pdf->SetXY(138, $y7);
    // $pdf->cell(34, 10, ($totGrossWeight > 0 ? number_format($totGrossWeight, 2) : '-'), '', 0, 'R');
    // $pdf->SetXY(163, $y7);
    // $pdf->cell(34, 10, ($maintotal > 0 ? number_format($maintotal, 2) : '-'), '', 0, 'R');
    // $pdf->Ln();
    // $pdf->SetXY(40, $y7 + 4);
    // $pdf->cell(10, 10, ': ', '', 0, 'L');
    // $pdf->SetXY(163, $y7 + 4);
    // $pdf->cell(34, 10, ($disc > 0 ? number_format($disc, 2) : '-'), '', 0, 'R');
    // $pdf->Ln();
    // $pdf->SetXY(40, $y7 + 8);
    // $pdf->cell(10, 10, ': ', '', 0, 'L');
    // $pdf->SetXY(163, $y7 + 8);
    // $pdf->cell(34, 10, ($freight > 0 ? number_format($freight, 2) : '-'), '', 0, 'R');
    // $pdf->Ln();
    // $pdf->SetXY(40, $y7 + 12);
    // $pdf->cell(10, 10, ': ', '', 0, 'L');
    // $pdf->SetXY(163, $y7 + 12);
    // $pdf->cell(34, 10, ($tax > 0 ? number_format($tax, 2) : '-'), '', 0, 'R');
    // $pdf->Ln();
    // $pdf->SetXY(40, $y7 + 16);
    // $pdf->cell(10, 10, ': ', '', 0, 'L');
    // $pdf->SetXY(163, $y7 + 16);
    // $pdf->cell(34, 10, ($totaldue > 0 ? number_format($totaldue, 2) : '-'), '', 0, 'R');
    $pdf->Ln();
    $pdf->Ln();
    // $pdf->SetFont('Times', 'B', 10);
    // $pdf->SetX(11);
    // $pdf->Cell(26, 4, 'Shipping Term : ');
    // $pdf->SetFont('Times', '', 10);
    // $pdf->SetX(37);
    // $pdf->Cell(34, 4, '');
    // $pdf->Ln();

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
    // $pdf->Ln();
    $pdf->SetFont('Times', 'B', 9);
    $pdf->SetX(155);
    $pdf->Cell(18, 4, 'Received By', 0, 0, 'C');
    $pdf->SetFont('Times', '', 8);
}



// $pdf = new FPDF();

//$pdf->SetFont('Arial', 'B', 16);
//$pdf->Cell(40, 10, 'Hello World!');
//$pdf->Output();

$pdf->Output($sono . '.pdf', 'I');
