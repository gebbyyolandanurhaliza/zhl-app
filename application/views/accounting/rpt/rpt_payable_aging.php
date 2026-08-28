<?php

class PDF extends TFPDF {

    //Page header
    function Header() {
        $titel = 'Payable Aging';
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);

        $this->setFont('Arial', 'B', 11);
        $this->SetTextColor(0, 0, 0);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90);
        $this->cell(25, 6, 'AP Aging For Period '.date('d-m-Y', strtotime($this->periode)), 0, 0, 'C', 1);
        $this->Ln(10);
        //$this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 0);
        // $this->setFont('Arial', 'B', 6);
        // $this->Line(10, 47, 203, 47);
        // $this->cell(30, 6, 'Vendor', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
        // $this->cell(25, 6, 'Inv Number', 'BTRL', 0, 'C', 1);
        // $this->cell(15, 6, 'Due Date', 'BTRL', 0, 'C', 1);
        // $this->cell(10, 6, 'Currency', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, 'Amount', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, 'Current ', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, '0 - 30 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, '31 - 60 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, '61 - 91 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, '91 - 120 Days', 'BTRL', 0, 'C', 1);
        // $this->cell(14, 6, '> 120 Days', 'BTRL', 1, 'C', 1);

    }

    function Content($get_data_detail,$GroupSupplier, $periode) {        
        

        $this->setFillColor(255, 255, 255);

        $NO = 1;
       

        if (!empty($get_data_detail)) {

            $gtt = 0;
            $gCurrent = 0;
            $gd30=0;
            $gd60=0;
            $gd90=0;
            $gd120=0;
            $gdmore=0;
           
            foreach ($GroupSupplier as $m){
                // $total = 0;
                // $gt = 0;
                // $duedate = 0;
                // $sd30 = 0;
                // $sd60 = 0;
                // $sd90 = 0;
                // $sd120 = 0;
                // $grand_total = 0;
                // $gt = 0;
                $amount     = 0;
                $current    = 0;
                $tiga       = 0;
                $enam       = 0;
                $sembilan   = 0;
                $lebih      = 0;
                $more       = 0;
                $amount1     = 0;
                // $this->setFont('Arial', '', 8);
                $this->SetFont('times', '', 8);
                $this->cell(193, 6, $m->suppliercompany, 0, 1, 'L', 1);
                $this->cell(193, 6,str_replace("<br />"," ","$m->address").' '.$m->postalcode , 'B', 1, 'L', 1);
                $this->setFont('Arial', '', 6);
                $this->setFillColor(255, 255, 255);

                //  $this->setFont('Arial', 'B', 6);
                // $this->Line(10, 47, 203, 47);
                // $this->cell(30, 6, 'Vendor', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Inv. Date', 'BTRL', 0, 'C', 1);
                $this->cell(31, 6, 'Inv Number', 'BTRL', 0, 'C', 1);
                $this->cell(15, 6, 'Due Date', 'BTRL', 0, 'C', 1);
                $this->cell(13, 6, 'Currency', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, 'Amount', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, 'Current ', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, '0 - 30 Days', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, '31 - 60 Days', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, '61 - 91 Days', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, '91 - 120 Days', 'BTRL', 0, 'C', 1);
                $this->cell(17, 6, '> 120 Days', 'BTRL', 1, 'C', 1);

                foreach ($get_data_detail as $key) {
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($key->tmp_supplier_name == $m->suppliercompany) {
                        //$this->cell(55, 6, $key->tmp_supplier_name, 'BTRL', 0, 'C', 1);
                        $amount += ($key->tmp_not_due_date+$key->tmp_0sd30+$key->tmp_31sd60+$key->tmp_61sd90+$key->tmp_91sd120+$key->tmp_more120);
                        $current += $key->tmp_not_due_date;
                        $tiga += $key->tmp_0sd30;
                        $enam += $key->tmp_31sd60;
                        $sembilan += $key->tmp_61sd90;
                        $lebih += $key->tmp_91sd120;
                        $more += $key->tmp_more120;
                      
                        // $amount1 +=$amount;
                        // $this->cell(30, 6, "", 'LR', 0, 'C', 1);
                        $this->cell(15, 6, $key->tmp_inv_date, 'BTRL', 0, 'C', 1);
                        $this->cell(31, 6, $key->tmp_invno, 'BTRL', 0, 'C', 1);            
                        $this->cell(15, 6, $key->tmp_due_date, 'BTRL', 0, 'C', 1);
                        $this->cell(13, 6, $key->tmp_currency, 'BTRL', 0, 'C', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_not_due_date+$key->tmp_0sd30+$key->tmp_31sd60+$key->tmp_61sd90+$key->tmp_91sd120+$key->tmp_more120)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_not_due_date)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_0sd30)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_31sd60)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_61sd90)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_91sd120)), 'BTRL', 0, 'R', 1);
                        $this->cell(17, 6, str_replace("$", "", money_format('%(#6n', $key->tmp_more120)), 'BTRL', 1, 'R', 1);
                        $NO ++;
                    }
                 
                }

                $NO = 1;
                $this->setFont('Arial', 'B', 6);
                $this->setFillColor(255, 255, 255);
          

                // foreach ($get_data_detail as $v) {
                //     $amount += ($v->tmp_not_due_date+$v->tmp_0sd30+$v->tmp_31sd60+$v->tmp_61sd90+$v->tmp_91sd120+$v->tmp_more120);
                //     $current += $v->tmp_not_due_date;
                //     $tiga += $v->tmp_0sd30;
                //     $enam += $v->tmp_31sd60;
                //     $sembilan += $v->tmp_61sd90;
                //     $lebih += $v->tmp_91sd120;
                //     $more += $v->tmp_more120;
                // }
                
                $this->cell(74, 6, "Grand Total", 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $amount)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $current)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $tiga)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $enam)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $sembilan)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $lebih)), 'BTRL', 0, 'R', 1);
                $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $more)), 'BTRL', 1, 'R', 1);

                $gtt += $amount;
                $gCurrent += $current;
                $gd30 += $tiga;
                $gd60 += $enam;
                $gd90 += $sembilan;
                $gd120 += $lebih;
                $gdmore += $more;
                
            }
            $this->cell(74, 6, "Total", 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gtt)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gCurrent)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gd30)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gd60)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gd90)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gd120)), 'BTRL', 0, 'R', 1);
            $this->cell(17, 6, str_replace("$", "", money_format('%(#5n', $gdmore)), 'BTRL', 1, 'R', 1);

            

        }

    }

    function Footer() {
        //atur posisi 1.5 cm dari bawah
        $this->SetY(-10);
        $this->setFont('Arial', 'i', 8);

        $this->setFont('Arial', '', 8);
        $this->SetY(-8);
        //buat garis horizontal
        $this->Line(10, 290,203, 290);
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('P','mm','A4');
$pdf->periode=$periode;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_data_detail,$GroupSupplier, $periode);
$pdf->Output();
