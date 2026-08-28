<?php

class PDF extends FPDF {

    private  $data = array();
    public function setData($data){
        $this->data=$data;
    }

    //Page header
    function Header() {
        $currency = $_GET['currency'];
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(90);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(90);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Customer Card ZHT For Period '.date('d-m-Y', strtotime($this->from)).' to '.date('d-m-Y', strtotime($this->to)), 0, 0, 'C', 1);
        $this->Ln();
        // $this->Cell(90);
        
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->cell(100, 6, $this->sup, 0, 0, 'L', 0);
        // $this->Cell(90);
        $this->cell(90, 6, $currency, 0, 1, 'R', 0);

        // $this->Line(10, 46, 204, 46);
        // $this->cell(15, 6, 'Supplier ID', 0, 0, 'C', 1);
        // $this->cell(35, 6, 'Supplier Name', 0, 0, 'C', 1);
        $this->cell(17, 6, 'Date', 'BT', 0, 'C', 1);
        $this->cell(75, 6, 'Dercription', 'BT', 0, 'C', 1);
        $this->cell(35, 6, 'Reference / Invoice', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Debet', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Credit ', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Balance', 'BT', 1, 'C', 1);
        // $this->cell(8, 6, 'Status', 0, 1, 'C', 1);

        $this->Line(10, 52, 204, 52);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w - $this->rMargin - $this->x;
            $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
            $s = str_replace("\r",'',$txt);
            $nb = strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
                $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }


    function Content($get_data) {        
        
        $NO = 1;
        $this->setFont('Arial', '', 7);
        $this->setFillColor(255, 255, 255);

        $toc = 0;
        $tod = 0;
        $Balance = 0;

        foreach ($get_data as $key) {
            $tod += $key->tmp_debet;
            $toc += $key->tmp_kredit;
            if($key->tmp_balance < 0){
                $str = str_replace("-", '', $key->tmp_balance);
                $Balance = "(". number_format($str, 2, ",", ".") .")";
            } else {
                $Balance=number_format($key->tmp_balance, 2, ",", ".");
            }
            // $this->cell(15, 6, $key->tmp_kodesup, 0, 0, 'L', 1);
            // $this->cell(35, 6, $key->tmp_supplier_name, 0, 0, 'C', 1);
            $lineHeight = 6;
            $nb = $this->NbLines(75, $key->tmp_uraian);
            $rowHeight = $lineHeight * $nb;
            if ($this->GetY() + $rowHeight > $this->PageBreakTrigger) {
                $this->AddPage();
            }
            $this->Cell(17, $rowHeight, $key->tmp_tanggal, 0, 0, 'C');
            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell(75, $lineHeight, $key->tmp_uraian, 0, 'L');
            $this->SetXY($x + 80, $y);
            $this->Cell(40, $rowHeight, $key->tmp_nojurnal, 0, 0, 'L');
            $this->Cell(20, $rowHeight, number_format($key->tmp_debet, 2), 0, 0, 'R');
            $this->Cell(20, $rowHeight, number_format($key->tmp_kredit, 2), 0, 0, 'R');
            $this->Cell(20, $rowHeight, $Balance, 0, 1, 'R');
            // $huruf = $key->tmp_jenis_trans;
            // if( $huruf == 'AP'){
            //     $this->cell(8, 6, 'PAID', 0, 1, 'C', 1);
            // } else if($huruf == 'PDP'){
            //     $this->cell(8, 6, 'DEPOSIT', 0, 1, 'C', 1);
            // }else{
            //     $this->cell(8, 6, '', 0, 1, 'C', 1);
            // }
            $NO ++;
        }

        // $this->cell(17, 6, $key->tmp_tanggal, 0, 0, 'C', 1);            
        // $this->cell(82, 6, $key->tmp_uraian, 0, 0, 'L', 1);
        $this->cell(129, 6, 'TOTAL', 'T', 0, 'R', 1);
        $this->cell(5,6,'','T',0,'R',1);
        $this->cell(20, 6, number_format($tod, 2), 'T', 0, 'R', 1);
        $this->cell(20, 6, number_format($toc, 2), 'T', 0, 'R', 1);
        $this->cell(20, 6, $Balance, 'T', 1, 'R', 1);
       

    }

    function Footer() {
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 204, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->sup = $supplier;
$pdf->from=$from;
$pdf->to=$to;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data);
$pdf->Output();

