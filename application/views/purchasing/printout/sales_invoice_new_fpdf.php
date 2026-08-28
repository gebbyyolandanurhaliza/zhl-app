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
        $this->Ln();
        $this->SetX(10);
        $this->Cell(190, 243, '', 0, 0);
        $this->SetFont('Times', 'B', 18);
        $this->SetX(70);
        $this->Cell(0, 10, 'SALES TAX INVOICE', 0, 0);
        $this->Ln();
        $this->Ln();

        $this->SetFont('Times', '', 9);
        $this->SetX(11);
        $this->Cell(20, 4, 'To', 0, 0);
        $this->SetX(31);
        if ($this->custid == 'S00040') {
            $this->Cell(29, 4, ': S&Z Services ', 0, 0);
        } else {
            $this->Cell(29, 4, ': ' . $this->custcompany, 0, 0);
        }
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
        $this->Cell(20, 4, 'Invoice No', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ' . $this->invno, 0, 0);
        $this->Ln();
        $this->SetX(11);
        $this->SetX(140);
        $this->Cell(20, 4, 'Payment Terms', 0, 0);
        $this->SetX(170);
        $this->Cell(29, 4, ': ' . $this->paymentterm, 0, 0);
        $this->SetX(11);
        $this->Cell(20, 4, 'Address', 0, 0);
        $this->Cell(24, 4, ':', 0, 0);
        $this->SetX(32);
        $this->MultiCell(90, 4, $this->customer_address, 0);


        $y = $this->GetY();
        // $y7 = $pdf->GetY() + 30;
        $this->Line(11, $y + 6, 199, $y + 6);
        $this->Line(11, $y + 17, 199, $y + 17);

        $this->Ln(7);
        $this->SetFont('Times', 'B', 9);
        $this->SetX(11);
        $this->Cell(10, 10, 'No', '', 0, 'C');
        $this->SetX(29);
        $this->Cell(40, 10, 'Item Name', '', 0, 'L');
        $this->Cell(28, 10, 'UOM', '', 0, 'R');
        $this->Cell(40, 10, 'Quantity', '', 0, 'R');
        $this->Cell(28, 10, 'Price', '', 0, 'R');
        $this->SetX(177);
        $this->Cell(20, 10, 'Amount (' . $this->currency . ')', 0, 0);

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


        // $this->Cell(70, 5,  $sig, 0, 1, 'L');
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

foreach ($_getInv as $r) {
    $invno = $r->invno;
    $sono = $r->sono;
    $custid = $r->custid;
    $docdate = date("d/m/Y",  strtotime($r->docdate));
    $shipdate = date("d/m/Y",  strtotime($r->shipdate));
    $postdate = date("d/m/Y",  strtotime($r->postdate));
    $createdby = $r->createdby;
    $via = $r->via;
    $remark = $r->remark;
    $maintotal = $r->maintotal;
    $freight = $r->freight;
    $taxprice =  $r->tax;
    $disc = $r->discount;
    // $tax = $taxprice * (($maintotal - $disc) / 100);
    $totaldue = $r->totaldue;
    $dp = $r->advancepayment;
    $balance = $r->totalbalance;
    $currency = $r->currency;
    $whsid = $r->whsid;
    $term = $r->term;
    $curname = $r->currency_name;
    $per1000 = $r->per1000;
    $status = $r->status;
    $custcontact = $r->custcontact;
    $paymentterm = $r->paymentterm;
    $customer_address = $r->customer_address;
    $year = date('Y', strtotime($r->postdate));

    $taxPriceTemp = 0;
    $include = $r->include;
    // $year = date('Y', strtotime($postdate));
    if ($include == '1' && $year > '2023') {
        $taxPriceTemp = 9;
    } else if ($include == '1' && $year < '2023') {
        $taxPriceTemp = 8;
    } else {
        $taxPriceTemp = 0;
    }

    $totalbefore = $r->maintotal;
    $Totdiscount = $r->discount;

    $taxfreight = (($totalbefore - $Totdiscount) + $freight) / 100;

    $taxtotal = $taxPriceTemp * $taxfreight;
}
// echo $year;
// die;


$pdf = new PDF('P', 'mm', 'A4');
$pdf->invno = $invno;
$pdf->custid = $custid;
$pdf->currency = $currency;
$pdf->custcontact = $custcontact;
$custcompany = $r->custcompany;
$pdf->customer_address = $customer_address;
$pdf->term = $term;
$pdf->via = $via;
$pdf->docdate = $docdate;
$pdf->postdate = $postdate;
$pdf->year = $year;
$pdf->shipdate = $shipdate;
$pdf->sono = $sono;
$pdf->remark = $remark;
$pdf->whs = $whsid;
$pdf->status = $status;
$pdf->per1000 = $per1000;
$pdf->created = $createdby;
$pdf->custcompany = $custcompany;
$pdf->custid = $custid;
$pdf->paymentterm = $paymentterm;


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Times', '', 9);
$i = 1;
$yawal = $pdf->GetY();
foreach ($_getInv as $r) {

    $y = $pdf->GetY();
    $pdf->SetXY(11, $y);
    $pdf->MultiCell(10, 5, $i, 0, 'C');
    $pdf->SetXY(29, $y);
    $pdf->MultiCell(104, 5, $r->itemid, 0, 'L');
    $pdf->SetXY(83, $y);
    $pdf->MultiCell(18, 5, $r->uomname, 0, 'C');
    $pdf->SetXY(112, $y);
    $pdf->MultiCell(20, 5, number_format($r->qty, 2), 0, 'R');
    $pdf->SetXY(145, $y);
    $pdf->MultiCell(20, 5, number_format($r->unitprice, 2), 0, 'R');
    $pdf->SetXY(171, $y);
    $pdf->MultiCell(24, 5, number_format($r->total, 2), 0, 'R');
    $pdf->Ln();
    $y2 = $pdf->GetY() - 5;
    $pdf->SetXY(28, $y2);
    $pdf->MultiCell(100, 5, $r->itemname, 0, 'L');
    $pdf->Ln();


    $y5 = $pdf->GetY() - 5;
    if ($y5 > 210) {
        $y6 = $pdf->GetY() - 5;
        // $pdf->Line(11, $y6, 199, $y6);
        $pdf->AddPage();
    }

    $i++;
}

$y7 = $pdf->GetY() + 30;
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
$pdf->cell(40, 10,  $year > '2023' ? 'GST 9 %' : 'GST 8 %', '');

$pdf->Ln();
$pdf->SetXY(12, $y7 + 16);
$pdf->cell(40, 10, 'Total Invoice', '');
$pdf->Ln();
$y0 = $pdf->GetY() + 1;
$pdf->Line(11, $y0, 199, $y0);
$pdf->Line(11, $y0, 199, $y0);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetXY(40, $y7);
$pdf->cell(10, 10, ': ', '', 0, 'L');

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
$pdf->cell(34, 10, ($taxtotal > 0 ? number_format($taxtotal, 2) : '-'), '', 0, 'R');
$pdf->Ln();
$pdf->SetXY(40, $y7 + 16);
$pdf->cell(10, 10, ': ', '', 0, 'L');
// $pdf->cell(10,10,($totaldue > 0 ? $cur : ''),'',0,'L');
$pdf->SetXY(165, $y7 + 16);
$pdf->cell(34, 10, ($totaldue > 0 ? number_format($totaldue, 2) : '-'), '', 0, 'R');

$pdf->Ln();

$pdf->Ln(10);
if ($via != '') {
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetX(11);
    $pdf->Cell(26, 4, 'Ship Via : ');
    $pdf->SetFont('Times', '', 10);
    $pdf->SetX(37);
    $pdf->Cell(34, 4, $via);
    $pdf->Ln();
}

if ($remark != '') {
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetX(11);
    $pdf->Cell(34, 4, 'Remarks :');
    $pdf->Ln();
    $pdf->SetFont('Times', '', 9);
    $pdf->SetX(11);
    $pdf->MultiCell(180, 5, str_replace("<br />", "", $remark));
    $pdf->Ln();
}

$pdf->SetY(-29);
$pdf->SetX(155);
$pdf->Cell(40, 4, '', 'B');
$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->SetX(145);
$pdf->Cell(40, 4, 'Director', 0, 0, 'L');
$pdf->SetFont('Times', '', 8);


$pdf->SetY(-60);

$pdf->setFont('Arial', 'B', 8);
$pdf->setFillColor(255, 255, 255);
$pdf->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
$pdf->setFont('Arial', 'B', 10);
$pdf->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
$pdf->setFont('Arial', 'i', 8);
$pdf->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
$pdf->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
$pdf->Cell(10, 5, 'Swift Code : UOVBSGSG', 0, 1, 'l');
$pdf->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');

$pdf->Cell(135, 5, 'USD Acct No. 357-907-139-5', 0, 0, 'L');

$pdf->setFont('Arial', 'B', 11);


$pdf->Output($invno . '.pdf', 'I');
