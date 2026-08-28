
<?php
$_tampil_item = isset($_tampil_item) ? $_tampil_item : [];
$dept_code    = isset($dept_code) ? $dept_code : '';
$dari         = isset($dari) ? $dari : '';
$sampai       = isset($sampai) ? $sampai : '';
class PDF extends FPDF {

    private $data = array();
    public function setData($data){
        $this->data = $data;
    }
function Header() {
    $this->SetFont('Times', 'BI', 10);
    $this->Cell(230, 6, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'C');
    $this->Cell(230, 6, 'B/L Code Report AT ' . $_GET['dari'] . ' TO ' . $_GET['sampai'], 0, 1, 'C');
    $this->Ln(5);

    $this->SetFont('Times', '', 8);
    $this->Cell(25, 5, $this->data['string'], 0, 1, 'L');
    $this->SetFont('Times', 'B', 7);

    $dept_code = isset($this->data['dept_code']) ? $this->data['dept_code'] : '';

    if ($dept_code == '002') {
        $headers = [
            'No','B/L Code','Customer','Date','Receivable Recognition Ref. Number',
            'Department Code','Freight Income - BU','Barge Income - BU',
            'Barge Freight Income - BU','Local Income - BU','Trucking Income - BU',
            'Management fee - Handling charge - BU','Cash Bank Ref.',
            'Ap Inv. Number','Ap Inv. Number','Freight Charges - BU','Barge Charges - BU',
            'Local Charges - BU','Trucking Charges - BU','Insurance - Marine Insurance Expenses - BU','Gross Profit'
        ];
        $widths = [6,18,18,10,18,15,12,12,12,12,12,17,15,15,15,12,12,12,12,15,12];
    } elseif ($dept_code == '003') {
        $headers = [
            'No','B/L Code','Customer','Date','Receivable Recognition Ref. Number',
            'Department Code','Freight Income - FF','Barge Income - FF',
            'Local Income - FF','Trucking Income - FF','Cash Bank Ref.',
            'Ap Inv. Number','Ap Inv. Number','Freight Charges - FF','Barge Charges - FF',
            'Local Charges - FF','Trucking Charges - FF','Insurance - Marine Insurance Expenses - FF','Gross Profit'
        ];
        $widths = [6,20,20,15,20,15,13,13,13,13,16,20,20,13,13,13,13,13,13];
    }

    $this->SetWidths($widths);
    $this->Row($headers, true);
}

function Content($items, $dept_code) {
    $this->SetFont('Times', '', 7);
    $this->SetFillColor(255, 255, 255);

    $no = 1;
    foreach ($items as $item) {
        if ($dept_code == '002') {
            $total_formula = 
                floatval($item->amount_500202_002_001)
                + floatval($item->amount_500101_002_001)
                + floatval($item->amount_500109_002_001)
                + floatval($item->amount_500105_002_001)
                + floatval($item->amount_500203_002_001)
                + floatval($item->amount_500107_002_001)
                - floatval($item->amount_600101_002_001)
                - floatval($item->amount_600102_002_001)
                - floatval($item->amount_600103_002_001)
                - floatval($item->amount_600104_002_001)
                - floatval($item->total_sum_amount);

            $cells = [
                $no++,
                $item->blCode,
                $item->customer_name,
                date('d-m-Y', strtotime($item->Tanggal)),
                trim($item->HeaderID),
                $item->dept_code,
                number_format($item->amount_500202_002_001, 2),
                number_format($item->amount_500101_002_001, 2),
                number_format($item->amount_500109_002_001, 2),
                number_format($item->amount_500105_002_001, 2),
                number_format($item->amount_500203_002_001, 2),
                number_format($item->amount_500107_002_001, 2),
                trim($item->no_reff),
                $item->headerPR,
                $item->headerPR_700071,
                number_format($item->amount_600101_002_001, 2),
                number_format($item->amount_600102_002_001, 2),
                number_format($item->amount_600103_002_001, 2),
                number_format($item->amount_600104_002_001, 2),
                number_format($item->total_sum_amount, 2),
                number_format($total_formula, 2),
            ];
        } elseif ($dept_code == '003') {
            $total_formula = 
                floatval($item->amount_500202_003_001)
                + floatval($item->amount_500101_003_001)
                + floatval($item->amount_500105_003_001)
                + floatval($item->amount_500203_003_001)
                - floatval($item->amount_600101_003_001)
                - floatval($item->amount_600102_003_001)
                - floatval($item->amount_600103_003_001)
                - floatval($item->amount_600104_003_001)
                - floatval($item->total_sum_amount_1);

            $cells = [
                $no++,
                $item->blCode,
                $item->customer_name,
                date('d-m-Y', strtotime($item->Tanggal)),
                trim($item->HeaderID),
                $item->dept_code,
                number_format($item->amount_500202_003_001, 2),
                number_format($item->amount_500101_003_001, 2),
                number_format($item->amount_500105_003_001, 2),
                number_format($item->amount_500203_003_001, 2),
                trim($item->no_reff),
                $item->headerPR_003,
                $item->headerPR_700071_003,
                number_format($item->amount_600101_003_001, 2),
                number_format($item->amount_600102_003_001, 2),
                number_format($item->amount_600103_003_001, 2),
                number_format($item->amount_600104_003_001, 2),
                number_format($item->total_sum_amount_1, 2),
                number_format($total_formula, 2),
            ];
        } else {
            continue; 
        }

        $this->Row($cells);
    }
}

    function SetWidths($w){ $this->widths = $w; }
    function SetAligns($a){ $this->aligns = $a; }

    function Row($data, $isHeader=false){
        $nb = 0;
        $lineHeight = 5;
        for($i=0; $i<count($data); $i++){
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $lineHeight * $nb;

        if($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage();

        $x = $this->GetX();
        $y = $this->GetY();

        for($i=0; $i<count($data); $i++){
            $w = $this->widths[$i];
            $align = $isHeader ? 'C' : ((isset($this->aligns[$i]) ? $this->aligns[$i] : ($i<4?'C':'R')));
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, $lineHeight, $data[$i], 0, $align);
            $x += $w;
            $this->SetXY($x, $y);
        }
        $this->Ln($h);
    }

    function NbLines($w, $txt){
        $cw = &$this->CurrentFont['cw'];
        if($w==0) $w=$this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
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

$pdf = new PDF('L','mm',array(240,297));
$pdf->setData([
    'string' => 'Dept: '.$dept_code,
    'dept_code' => $dept_code   
]);


$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Content($_tampil_item, $dept_code);

$pdf->Output();


?>
