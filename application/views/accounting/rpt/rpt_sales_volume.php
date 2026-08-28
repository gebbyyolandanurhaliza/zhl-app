<?php


class PDF extends FPDF {

    //Page header
     function Header() {
        $titel = 'Receivable Aging';
        $this->Image('assets/PSG.png', 12, 10, 25, 0, 'PNG');
        $this->setFont('Arial', 'B', 12);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(85);
        $this->cell(100, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(100, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(100, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(85);
        $this->cell(100, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(85);
        $this->cell(100, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(85);
        $this->cell(100, 6, 'Sales Value / Volume Report '.date('d-m-Y', strtotime($this->from)).' - '.date('d-m-Y', strtotime($this->to)), 0, 1, 'C', 1);
        // $this->Ln(15);
        
        $this->setFont('Arial', 'B', 6);
        $this->Line(10, 47, 203, 47);
        $this->cell(30, 6, 'Invoice Number', 'BTRL', 0, 'C', 1);
        $this->cell(115, 6, 'Item Name', 'BTRL', 0, 'C', 1);
        $this->cell(30, 6, 'Quantity (KG/MT)', 'BTRL', 0, 'C', 1);
        $this->cell(30, 6, 'Price per Unit', 'BTRL', 0, 'C', 1);
        $this->cell(30, 6, 'Sales Amount (USD)', 'BTRL', 0, 'C', 1);
        $this->cell(40, 6, 'Sales Person', 'BTRL', 1, 'C', 1);
    }

    function Content($_tampil_sales,$customer_list) {        

        $this->setFillColor(255, 255, 255);
        $NO = 1;

        
        if (!empty($_tampil_sales)) {
            foreach ($customer_list as $row_customer){
                $invno = 0;
                $productname = 0;
                $qty = 0;
                $unitprice = 0;
                $total = 0;
                $sales_id = 0;
                $this->setFont('Arial', 'B', 6);
                $this->cell(275, 6, $row_customer->custcompany, 'TRL', 1, 'L', 1);
                $this->setFont('Arial', '', 6);
                foreach ($_tampil_sales as $row_tampilsales) {
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($row_customer->custid == $row_tampilsales->custid) {
                        $invno += $row_tampilsales->invno;
                        $productname += $row_tampilsales->productname;
                        $qty += $row_tampilsales->qty;
                        $unitprice += $row_tampilsales->unitprice;
                        $total += $row_tampilsales->total;
                        $sales_id += $row_tampilsales->sales_id;

                        // $this->cell(30, 6, "", 'LR', 0, 'C', 1);
                        $this->cell(30, 6, $row_tampilsales->invno, 'BTRL', 0, 'L', 0);
                        $this->cell(115, 6, $row_tampilsales->productname, 'BTRL', 0, 'L', 1);
                        $this->cell(30, 6, $row_tampilsales->qty, 'BTRL', 0, 'L', 1);
                        $this->cell(30, 6, $row_tampilsales->unitprice, 'BTRL', 0, 'R', 1);
                        $this->cell(30, 6, $row_tampilsales->total, 'BTRL', 0, 'R', 1); 
                        $this->cell(40, 6, $row_tampilsales->sales_id, 'BTRL', 1, 'L', 1);  
                        $NO ++;

                        // if($this->SetY() == 100){
                        //     $this->Line(10, 290,204, 290);
                        // }
                    }
                }

                $this->cell(175, 6, "Grand Total", 'BTRL', 0, 'R', 1);
                $this->cell(30, 6, number_format($unitprice, 2), 'BTRL', 0, 'R', 1);
                $this->cell(30, 6, number_format($total, 2), 'BTRL', 0, 'R', 1);
                $this->cell(40, 6, '', 'BTRL', 1, 'R', 1);
            }
            
        }

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-10);
        $this->setFont('Arial', 'i', 8);

        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, 290,204, 290);
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo(). ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('L','mm','A4');
$pdf->from=$from;
$pdf->to=$to;
$pdf->sales_person=$sales_person;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil_sales,$customer_list);
$pdf->Output();
