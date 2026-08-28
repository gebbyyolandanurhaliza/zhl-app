<?php
class PDF extends FPDF {

    private $data = array();
    public function setData($data){
        $this->data = $data;
    }

    function Header() {
    
        $dari = $_GET['dari'];
        $sampai = $_GET['sampai'];
        $titel = 'B/L Code Report AT ' . $dari . ' TO ' . $sampai;
        $this->SetFont('Times', 'BI', 10);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);

        $this->Cell(190, 6, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'C');
        $this->Cell(190, 6, $titel, 0, 1, 'C');

        $this->Ln(5);
        $this->SetFont('Times', '', 8);
        $this->Cell(25, 5, $this->data['string'], 0, 1, 'L');

        // Header tabel
        $this->SetFont('Times', 'B', 7);
        $this->SetFillColor(230,230,230);

        $headers = [
            'No', 'B/L Code', 'Customer', 'Date', 
            'Receivable Recognition Ref. Number',
            '500115', 'Date', 'Cash Bank Ref.', '600011', 'Balance'
        ];
        $widths = [6, 20, 30, 15, 25, 20, 15, 20, 20, 20];
        $this->SetWidths($widths);

        $this->Row($headers, true); 
    }

    function Content($_tampil_item){
        $this->SetFont('Times','',7);
        $this->SetFillColor(255,255,255);

        $no = 1;
        foreach($_tampil_item as $item){
            $cells = [
                $no++,
                $item->containerNo,
                $item->customer_name,
                (!empty($item->created_date) && $item->created_date != '0000-00-00') ? date('d-m-Y', strtotime($item->created_date)) : '',
                $item->nofaktur,
                (!empty($item->debit) && $item->debit != 0) ? number_format($item->debit,2,'.',',') : '',
                (!empty($item->tanggal) && $item->tanggal != '0000-00-00') ? date('d-m-Y', strtotime($item->tanggal)) : '',
                $item->no_reff,
                (!empty($item->debitAP) && $item->debitAP != 0) ? number_format($item->debitAP,2,'.',',') : '',
                (!empty($item->balance) && $item->balance != 0) ? number_format($item->balance,2,'.',',') : ''
            ];
            $this->Row($cells);
        }
    }

    // --- Fungsi Row untuk semua kolom wrap ---
    private $widths;
    function SetWidths($w){ $this->widths=$w; }

    function Row($data, $isHeader=false){
        $nb = 0;
        $lineHeight = 5;
        foreach($data as $i=>$txt){
            $nb = max($nb, $this->NbLines($this->widths[$i], $txt));
        }
        $h = $lineHeight * $nb;

        // page break
        if($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage();

        // cetak sel
        $x = $this->GetX();
        $y = $this->GetY();
        for($i=0;$i<count($data);$i++){
            $w = $this->widths[$i];
            $align = ($i<4) ? 'C' : 'R';
            if($isHeader) $align = 'C';
            $this->Rect($x,$y,$w,$h);
            $this->MultiCell($w, $lineHeight, $data[$i], 0, $align);
            $x += $w;
            $this->SetXY($x, $y);
        }
        $this->Ln($h);
    }

    function NbLines($w, $txt){
        $cw = &$this->CurrentFont['cw'];
        if($w==0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n") $nb--;
        $sep=-1;$i=0;$j=0;$l=0;$nl=1;
        while($i<$nb){
            $c=$s[$i];
            if($c=="\n"){$i++;$sep=-1;$j=$i;$l=0;$nl++;continue;}
            if($c==" ") $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax){
                if($sep==-1){if($i==$j) $i++;} else $i=$sep+1;
                $sep=-1;$j=$i;$l=0;$nl++;
            }else $i++;
        }
        return $nl;
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Times','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'R');
    }
}

$pdf = new PDF('P','mm','A4');
$pdf->setData($_dataHeader);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil_item);
$pdf->Output();
?>
