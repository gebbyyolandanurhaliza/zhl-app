<?php
$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$new_awal = date('F jS, Y', strtotime($dari));
$new_akhir = date('F jS, Y', strtotime($sampai));
class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Payable Statement Of Account';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(30, 5, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(80);
        $this->cell(25, 5, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(80);
        $this->cell(25, 5, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(80);
        $this->cell(25, 5, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(80);
        $this->cell(25, 5, 'www.sambugroup.com', 0, 1, 'C', 1);
        
    }

    function Content($get_profit, $GroupCOA, $get_data, $get_data2, $dari, $sampai) {      
        $new_awal = date('F jS, Y', strtotime($dari));  
        $new_akhir = date('F jS, Y', strtotime($sampai));  
        $this->Ln(6);
        $this->setFont('Arial', 'B', 12);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(25, 5, 'BALANCE SHEET FOR THE PERIOD '.$new_awal.' - '.$new_akhir.'', 0, 1, 'C', 1);


        $this->setFont('Arial', 'B', 10);
        $this->cell(100, 5, 'Group Name', 'BTLR', 0, 'C', 1);
        $this->cell(80, 5, 'Ammount ', 'BTLR', 1, 'R', 1);

        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);

        $ttl_asset = 0;
        $ttl_other = 0;
        $ttl_equity = 0;
        $ammount = 0;

        foreach ($GroupCOA as $value) {
            setlocale(LC_MONETARY, 'en_US.UTF-8');

            $this->setFont('Arial', 'B', 8);
            $this->cell(180, 5, $value->sub_group, 'BTLR', 1, 'L', 1);
            foreach ($get_profit as $x) {
                if ($value->id_sub_group == $x->id_sub_group) {
                    $id_group = $x->id_sub_group;

                    if ($x->id_sub_group == '1' || $x->id_sub_group == '2') {
                        $ammount = $x->BLDebet - $x->BLKredit;
                    } else {
                        $ammount = $x->BLKredit - $x->BLDebet;
                    }
                    if ($x->id_group !== '214') {
                        if ($x->id_group !== '213') {
                            $this->setFont('Arial', '', 8);
                             $this->cell(100, 5, $x->nama_group, 'BTLR', 0, 'L', 1);
                             $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $ammount)), 'BTLR', 1, 'R', 1);   
                        if ($x->id_sub_group == '1' || $x->id_sub_group == '2') {
                            $ttl_asset += $x->BLDebet - $x->BLKredit;
                        } else if ($x->id_sub_group == '4') {
                            $ttl_equity += $x->BLKredit - $x->BLDebet;
                        } else {
                            $ttl_other += $x->BLKredit - $x->BLDebet;
                        }
                    } elseif ($x->id_group == '213') {
                        foreach ($get_data as $r) {     
                                $PL = ($x->BLKredit - $x->BLDebet);
                        }
                        $this->cell(100, 5, $x->nama_group, 'BTLR', 0, 'L', 1);
                        $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $PL)), 'BTLR', 1, 'R', 1);  
                    }
                }elseif ($x->id_group == '214') {
                    foreach ($get_data2 as $r) {     
                        $CY = abs($r->current);
                    }
                    $this->cell(100, 5, $x->nama_group, 'BTLR', 0, 'L', 1);
                    $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $CY)), 'BTLR', 1, 'R', 1);    
                }
            }
        }
        if ($id_group == '2') {
            $this->setFont('Arial', 'B', 8);
            $this->cell(100, 5, 'TOTAL ASSETS', 'BTLR', 0, 'L', 1);
            $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $ttl_asset)), 'BTLR', 1, 'R', 1);
        } else if ($id_group == '3') {  
            $this->setFont('Arial', 'B', 8);
            $this->cell(100, 5, 'TOTAL CURRENT LIABILITIES', 'BTLR', 0, 'L', 1);
            $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $ttl_other)), 'BTLR', 1, 'R', 1);
        } else if ($id_group == '4') {
            $this->setFont('Arial', 'B', 8);
            $this->cell(100, 5, 'TOTAL EQUITY', 'BTLR', 0, 'L', 1);
            $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $ttl_equity + $PL + $CY )), 'BTLR', 1, 'R', 1);
            $this->cell(100, 5, 'TOTAL CURRENT LIABILITIES AND EQUITY', 'BTLR', 0, 'L', 1);
            $this->cell(80, 5, str_replace("$", "", money_format('%(#10n', $ttl_other + $ttl_equity + $PL + $CY)), 'BTLR', 1, 'R', 1);
        }
        //}
    }
}
    //}
    }

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_profit, $GroupCOA, $get_data, $get_data2, $dari, $sampai);
$pdf->Output();
