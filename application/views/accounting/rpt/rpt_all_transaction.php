<?php

class PDF extends FPDF 
{

    //Page header
    function Header() 
    {
        $titel = 'Aged Payable Summary';
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);

        $this->setFont('Arial', 'B', 11);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'Payable Invoice Transaction For Period '.date('d-m-Y', strtotime($this->dari)).' to '.date('d-m-Y', strtotime($this->sampai)), 0, 0, 'C', 1);
        $this->Ln();

        $this->Ln(2);
        $this->setFont('Arial', 'B', 6);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);

        

    }

    // function Content($_tampil_item,$Get_supplier) {        
    //     $this->setFont('Arial', '', 6);
    //     $this->setFillColor(255, 255, 255);
    //     if (!empty($_tampil_sales)) {
    //         foreach ($Get_supplier as $key_supplier)    {
    //             $no = 1;
    //             $totalpajak = 0;
    //             $totaldiskon = 0;
    //             $totalbiayalain = 0;
    //             $totaluang_muka = 0;
    //             $totalnota_debet = 0;
    //             $totalnota_kredit = 0;
    //             $total_hutang = 0;
    //             $total_bayar = 0;
    //             $this->setFont('Arial', 'B', 8);
    //             $this->cell(275, 6, $key_supplier->namavendor,0, 1, 'L', 1);
    //             $this->cell(275, 6, $key_supplier->address,0, 1, 'L', 1);
    //             $this->setFont('Arial', 'B', 6);
    //             // foreach ($_tampil_sales as $key_item) 
    //             // {
    //             //     setlocale(LC_MONETARY, 'en_US.UTF-8');
    //             //     if ($key_item->kode_sup == $key_supplier->kode_sup) 
    //             //     {
    //             //         $totalpajak += $key_item->pajak;
    //             //         $totaldiskon += $key_item->diskon;
    //             //         $totalbiayalain += $key_item->biaya_lain;
    //             //         $totaluang_muka += $key_item->uang_muka;
    //             //         $totalnota_debet += $key_item->nota_debet;
    //             //         $totalnota_kredit += $key_item->nota_kredit;
    //             //         $total_hutang += $key_item->hutang;
    //             //         $total_bayar += $key_item->bayar;

    //             //         $this->cell(5, 6, $no, 'BTRL', 0, 'L', 1);
    //             //         $this->cell(20, 6, $m->nofaktur, 'BTRL', 0, 'L', 1);
    //             //         $this->cell(37, 6, $m->namavendor, 'BTRL', 0, 'L', 1);
    //             //         $this->cell(11, 6, $m->currency_id, 'BTRL', 0, 'L', 1);
    //             //         $this->cell(11, 6, $m->rate, 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->pajak, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->diskon, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->biaya_lain, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->uang_muka, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->nota_debet, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(11, 6, number_format($m->nota_kredit, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(15, 6, number_format($m->hutang, 2), 'BTRL', 0, 'R', 1);
    //             //         $this->cell(15, 6, number_format($m->bayar, 2), 'BTRL', 0, 'R', 1);

    //             //         $totalpajak += $m->pajak;
    //             //         $totaldiskon+= $m->diskon;
    //             //         $totalbiayalain+= $m->biaya_lain;
    //             //         $totaluang_muka+= $m->uang_muka;
    //             //         $totalnota_debet += $m->nota_debet;
    //             //         $totalnota_kredit += $m->nota_kredit;
    //             //         $total_hutang += $m->hutang;
    //             //         $total_bayar += $m->bayar;
    //             //         $no++;
    //             //     }
    //             // }
    //             // $this->setFont('Arial', 'B', 6);
    //             // $this->setFillColor(255, 255, 255);

                
    //             // $this->cell(97, 6, "Grand Total", 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totalpajak, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totaldiskon, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totalbiayalain, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totaluang_muka, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totalnota_debet, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(11, 6, number_format($totalnota_kredit, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(15, 6, number_format($total_hutang, 2), 'BTRL', 0, 'R', 1);
    //             // $this->cell(15, 6, number_format($total_bayar, 2), 'BTRL', 0, 'R', 1);
    //         }
    //     }
    // }

    function Content($_tampil_item,$Get_supplier){
        $this->setFillColor(255, 255, 255);
        if (!empty($_tampil_item)) {
            foreach ($Get_supplier as $key_supplier) {
                $no = 1;
                $totalpajak = 0;
                $totaldiskon = 0;
                $totalbiayalain = 0;
                $totaluang_muka = 0;
                $totalnota_debet = 0;
                $totalnota_kredit = 0;
                $total_hutang = 0;
                $total_bayar = 0;
                $this->setFont('Arial', 'B', 8);
                $this->cell(275, 6, $key_supplier->namavendor,0, 1, 'L', 1);
                $this->cell(275, 6, $key_supplier->address,0, 1, 'L', 1);
                $this->setFont('Arial', 'B', 6);
                $this->cell(7, 6, 'NO', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Date', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'No. Reff', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Currency', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Rate', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Tax', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Discount', 'BTRL', 0, 'C', 1);
                $this->cell(18, 6, 'Additional Cost', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Deposit', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Debit Note', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Credit Note', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Total', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Payment', 'BTRL', 1, 'C', 1);
                foreach ($_tampil_item as $key_item) {
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($key_item->kode_sup == $key_supplier->kode_sup) {
                        $totalpajak += $key_item->pajak;
                        $totaldiskon += $key_item->diskon;
                        $totalbiayalain += $key_item->biaya_lain;
                        $totaluang_muka += $key_item->uang_muka;
                        $totalnota_debet += $key_item->nota_debet;
                        $totalnota_kredit += $key_item->nota_kredit;
                        $total_hutang += $key_item->hutang;
                        $total_bayar += $key_item->bayar;
                        $this->cell(7, 6, $no, 'BTRL', 0, 'L', 0);
                        $this->cell(15, 6, $key_item->tanggal, 'BTRL', 0, 'L', 0);
                        $this->cell(15, 6, $key_item->nofaktur, 'BTRL', 0, 'L', 0);
                        $this->cell(15, 6, $key_item->currency_id, 'BTRL', 0, 'L', 0);
                        $this->cell(15, 6, $key_item->rate, 'BTRL', 0, 'L', 0);
                        $this->cell(15, 6, number_format($key_item->pajak, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->diskon, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(18, 6, number_format($key_item->biaya_lain, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->uang_muka, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->nota_debet, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->nota_kredit, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->hutang, 2), 'BTRL', 0, 'R', 1);
                        $this->cell(15, 6, number_format($key_item->bayar, 2), 'BTRL', 1, 'R', 1);

                        $totalpajak += $key_item->pajak;
                        $totaldiskon+= $key_item->diskon;
                        $totalbiayalain+= $key_item->biaya_lain;
                        $totaluang_muka+= $key_item->uang_muka;
                        $totalnota_debet += $key_item->nota_debet;
                        $totalnota_kredit += $key_item->nota_kredit;
                        $total_hutang += $key_item->hutang;
                        $total_bayar += $key_item->bayar;
                        $no++;
                    }
                }
                $this->setFont('Arial', 'B', 6);
                $this->setFillColor(255, 255, 255);
                
                $this->cell(67, 6, "Grand Total", 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($totalpajak, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($totaldiskon, 2), 'BTRL', 0, 'R', 1);
                $this->cell(18, 6, number_format($totalbiayalain, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($totaluang_muka, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($totalnota_debet, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($totalnota_kredit, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($total_hutang, 2), 'BTRL', 0, 'R', 1);
                $this->cell(15, 6, number_format($total_bayar, 2), 'BTRL', 1, 'R', 1);
            }
        }
    }

    function Footer()
    {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-20);
        $this->setFont('Arial', 'i', 6);

        $this->setFont('Arial', '', 6);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, $this->GetY(),202, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->dari = $dari;
$pdf->sampai = $sampai;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil_item,$Get_supplier);
$pdf->Output();
