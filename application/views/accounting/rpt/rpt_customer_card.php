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
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);

        $this->Ln();

        $this->setFont('Arial', 'B', 11);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->SetY(40);
        $this->cell(205, 6, 'Customer Card For Period '.date('d-m-Y', strtotime($this->from)).' to '.date('d-m-Y', strtotime($this->to)), 0, 0, 'C', 1);
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
        $this->cell(82, 6, 'Dercription', 'BT', 0, 'C', 1);
        $this->cell(35, 6, 'Reference / Invoice', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Debet', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Credit ', 'BT', 0, 'C', 1);
        $this->cell(20, 6, 'Balance', 'BT', 1, 'C', 1);
        // $this->cell(8, 6, 'Status', 0, 1, 'C', 1);

        $this->Line(10, 52, 204, 52);
    }

    function Content($get_data) {        
        
        $NO = 1;
        $this->setFont('Arial', '', 8);
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

            $x = $this->GetX();
            $y = $this->GetY();

            $this->Cell(17, $lineHeight, $key->tmp_tanggal, 0, 0, 'C', 1);
            $uraian = $key->tmp_uraian;

            $uraian = str_replace(["\r\n", "\r"], "\n", $uraian);

            $uraian = preg_replace("/\n{3,}/", "\n\n", trim($uraian));
            $xUraian = $this->GetX();
            $this->MultiCell(85, $lineHeight, $uraian, 0, 'L', 1);

            $rowHeight = $this->GetY() - $y;

            $this->SetXY($xUraian + 85, $y);

            $this->Cell(35, $rowHeight, $key->tmp_nojurnal, 0, 0, 'L', 1);
            $this->Cell(20, $rowHeight, number_format($key->tmp_debet, 2), 0, 0, 'R', 1);
            $this->Cell(20, $rowHeight, number_format($key->tmp_kredit, 2), 0, 0, 'R', 1);
            $this->Cell(20, $rowHeight, $Balance, 0, 0, 'R', 1);

            // pindah ke baris berikutnya
            $this->Ln();
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
