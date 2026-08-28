<?php
//require ("../../libraries/fpdf2.php");

class PDF extends FPDF {

    private  $data = array();
    public function setData($data){
        $this->data=$data;
    }



    //Page header
    function Header() {
       // $ecm = $this->ecm;
        $dari = $_GET['dari'];
        $sampai = $_GET['sampai'];
        $coa=$_GET['jenis_coa'];

        $titel = 'GENERAL LEDGER FOR THE PERIOD AT ' . $dari . ' TO ' . $sampai;
        $this->setFont('Times', 'BI', 10);
        $this->setFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
        $this->cell(230, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->cell(230, 6, $titel, 0, 1, 'C', 1);

        $this->Ln(5);
        $this->setFont('times', '', 8);
        $this->setFillColor(255, 255, 255);
        $dari = $_GET['dari'];

        $this->Cell(25, 5,$this->data['string'], 0, 1, 'L', 0);

        $this->Cell(15, 5, 'No COA', 'BTLR', 0, 'L', 0);
        $this->Cell(20, 5, 'Invoice Number', 'BTLR', 0, 'L', 0);
        $this->Cell(20, 5, 'Date of Jurnal', 'BTLR', 0, 'C', 0);
        $this->Cell(24, 5, 'Check Number', 'BTLR', 0, 'C', 0);
        $this->Cell(38, 5, 'Description', 'BTLR', 0, 'C', 0);
        $this->Cell(15, 5, 'Debit (LC)', 'BTLR', 0, 'C', 0);
        $this->Cell(15, 5, 'Credit (LC)', 'BTLR', 0, 'C', 0);
        $this->Cell(21, 5, 'Balance (LC)', 'BTLR', 0, 'C', 0);
        $this->Cell(15, 5, 'Debit (FC)', 'BTLR', 0, 'C', 0);
        $this->Cell(15, 5, 'Credit (FC)', 'BTLR', 0, 'C', 0);
        $this->Cell(24, 5, 'Balance (FC)', 'BTLR', 1, 'C', 0);


    }

    function Content($detail_trans) {

        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($detail_trans as $s) {
            $this->setFont('times', '', 7);
            $this->setFillColor(255, 255, 255);
            setlocale(LC_MONETARY, 'en_US.UTF-8');

            $this->SetWidths(array(15,20, 20,24, 38, 15, 15, 21, 15, 15, 24));

            $tmp_debet = 0;
            $tmp_kredit = 0;
            $tmp_balance = 0;
            $tmp_debet_sgd = 0;
            $tmp_kredit_sgd = 0;
            $tmp_balance_sgd = 0;
            if ($s->tmp_debet == 0) {
                $tmp_debet = "";
            }else{
                $tmp_debet = number_format($s->tmp_debet, 2);
            }

            if ($s->tmp_kredit == 0) {
                $tmp_kredit = "";
            }else{
                $tmp_kredit = number_format($s->tmp_kredit, 2);
            }
            if ($s->tmp_debet_sgd == 0) {
                $tmp_debet_sgd = "";
            }else{
                $tmp_debet_sgd = "SGD ".number_format($s->tmp_debet_sgd, 2);
            }

            if ($s->tmp_kredit_sgd == 0) {
                $tmp_kredit_sgd = "";
            }else{
                $tmp_kredit_sgd = "SGD ".number_format($s->tmp_kredit_sgd, 2);
            }


            $tDebet += $s->tmp_debet;
            $tKredit += $s->tmp_kredit;
            $tBalance += $s->tmp_balance;
            $tDebetSGD += $s->tmp_debet_sgd;
            $tKreditSGD += $s->tmp_kredit_sgd;
            $tBalanceSGD += $s->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($s->tmp_tanggal), "d F Y");
            $saldo += $s->tmp_debet - $s->tmp_kredit;

            IF( $s->tmp_uraian=='BEGINING BALANCE' ) {
                $this->Row(array($s->tmp_no_coa,str_replace(".","/", $s->tmp_nojurnal),$tgl_jurnal,'', $s->tmp_uraian, $tmp_debet, $tmp_kredit,
                    str_replace("$", "", money_format('%(#10n', $s->tmp_balance)), $tmp_debet_sgd, $tmp_kredit_sgd,
                    "SGD ".str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)) ));
            }
            ELSEIF($s->tmp_uraian=='TOTAL'){
                $this->Row(array('',str_replace(".","/", $s->tmp_nojurnal),'','', $s->tmp_uraian, $tmp_debet, $tmp_kredit,
                    str_replace("$", "", money_format('%(#10n', $s->tmp_balance)), $tmp_debet_sgd, $tmp_kredit_sgd,
                    "SGD ".str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)) ));
            }
            ELSEIF($s->tmp_uraian!='TOTAL' || $s->tmp_uraian!='BEGINING BALANCE' ) {
                $this->Row(array('',str_replace(".","/", $s->tmp_nojurnal),$tgl_jurnal,$s->tmp_check_bank,$s->tmp_uraian, $tmp_debet, $tmp_kredit,
                    str_replace("$", "", money_format('%(#10n', $s->tmp_balance)), $tmp_debet_sgd, $tmp_kredit_sgd,
                    "SGD ".str_replace("$", "", money_format('%(#10n', $s->tmp_balance_sgd)) ));
            }
            }
            /*$this->SetWidths(array(15,25, 53, 21, 21, 21, 21, 21, 24, 24));
            $this->Row(array( "", "", "Total ", number_format($tDebet, 2), number_format($tKredit, 2), str_replace("$", "", money_format('%(#10n', $tBalance)), number_format($tDebetSGD, 2), number_format($tKreditSGD, 2), "SGD ".str_replace("$", "", money_format('%(#10n', $tBalanceSGD)) ));
    */}
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
    function Row($record_detail) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($record_detail); $i++){
            $nb = max($nb, $this->NbLines($this->widths[$i], $record_detail[$i]));
        }
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        $this->SetX(10);
        $i=2;
        for ($i = 0; $i < count($record_detail); $i++) {
            $w = $this->widths[$i];
            if ($i<5) {
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            }else{
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'R';
            }
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $record_detail[$i], 0, $a);
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
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
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
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-30);
        //buat garis horizontal
        //$this->Line(10, $this->GetY(), 350, $this->GetY());
        //nomor halaman
        //$this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm',array(240,297));
$pdf->setData($_dataHeader);
$pdf->AliasNbPages();
$pdf->AddPage();



$pdf->Content($_dataContent);
$pdf->Output();
