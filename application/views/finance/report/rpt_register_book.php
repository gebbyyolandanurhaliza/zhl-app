<?php

class PDF extends FPDF {

    //Page header
    function Header() {
        $titel = 'Down Payment';
        $this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');
        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(120);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'Reg. Number : 201537276N', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, '19 Tanglin Road, #11-01/02, Tanglin Shoping Center, Singapore 247909', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 7);
        $this->Cell(120);
        $this->cell(25, 6, 'Phone: (65) 6734 7138 - Fax: (65) 6734 8601 - info@sambu.sg.com', 0, 1, 'C', 1);

        $this->setFont('Arial', 'B', 9);
        $this->Cell(120);
        $this->cell(25, 6, 'www.sambugroup.com', 0, 1, 'C', 1);

        $this->Line(10, 44, 250 - 50, 44);
    }

    function Content($_tampil) {
        $this->Ln(2);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);

        $this->Line(10, 42, 325 - 40, 42);
        $this->cell(10, 6, 'No', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Date', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Reff No', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Check Number', 0, 0, 'C', 1);
        $this->cell(20, 6, 'Currency', 0, 0, 'C', 1);
        $this->cell(50, 6, 'Memo ', 0, 0, 'C', 1);
        $this->cell(50, 6, 'USD Mutation Currency', 0, 0, 'C', 1);
        $this->cell(50, 6, 'Other Currency Mutation', 0, 0, 'C', 1);
        $this->cell(30, 6, 'Currency Rate', 0, 1, 'C', 1);

	$this->Line(165, 48, 305 - 40, 48);


        $this->cell(10, 6, '', 0, 0, 'C', 1);
        $this->cell(20, 6, '', 0, 0, 'C', 1);
        $this->cell(25, 6, '', 0, 0, 'C', 1);
        $this->cell(30, 6, '', 0, 0, 'C', 1);
        $this->cell(20, 6, '', 0, 0, 'C', 1);
        $this->cell(50, 6, '', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Debit', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Credit', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Debit', 0, 0, 'C', 1);
        $this->cell(25, 6, 'Credit', 0, 0, 'C', 1);
        $this->cell(30, 6, '', 0, 1, 'C', 1);

        $this->Line(10, 55, 325 - 40, 55);
        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', '', 8);
        $this->setFillColor(255, 255, 255);


        foreach ($_tampil as $data) {
            if ($data->trans_type == 'AP') {
                # code...
            }elseif($data->trans_type == 'AR'){

            }else{


            $this->cell(10, 6, $NO, 0, 0, 'C', 1);
            $this->cell(20, 6, date('d-m-Y',strtotime($data->date1)), 0, 0, 'C', 1);
            $this->cell(25, 6, $data->no_facture, 0, 0, 'C', 1);
            $this->cell(30, 6, $data->check_bank, 0, 0, 'C', 1);
            $this->cell(20, 6, $data->currency_id, 0, 0, 'C', 1);
            $this->Cell(50, 6,$data->trans_description , 0, 0, 'L', 1);
            if ($data->currency_id == 'USD'){
                if ($data->debit != 0){
                    $this->cell(25, 6, number_format($data->debit, 2), 0, 0, 'C', 1);
                }
                if ($data->debit == 0){
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                }

                if ($data->credit != 0){
                    $this->cell(25, 6, number_format($data->credit, 2), 0, 0, 'C', 1);
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                }
                

            }
            else {
                /*$this->getY();
                $this->setXY(160,);
                */if ($data->debit != 0){
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                    $this->cell(25, 6, number_format($data->debit, 2), 0, 0, 'C', 1);

                }
                if ($data->debit == 0){
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                    $this->cell(25, 6, '', 0, 0, 'C', 1);
                    $this->cell(25, 6, '', 0, 0, 'C', 1);

                }
                if ($data->credit != 0){
                    $this->cell(25, 6, number_format($data->credit, 2), 0, 0, 'C', 1);

                }
                if ($data->credit == 0){
                    $this->cell(25, 6, '', 0, 0, 'C', 1);

                }

            }
            $this->cell(35, 6, number_format($data->currency_rate, 2), 0, 1, 'C', 1);

            /* $currency=$data->currency_id;
             $total_amount+=$data->uang_muka;
             $total_usd_equivalent+=$data->uang_muka*$data->currency_rate;


             $this->cell(20, 6, $data->supp_code, 0, 0, 'C', 1);
             $this->cell(70, 6, $data->cust_supp_name, 0, 0, 'C', 1);
             $this->cell(40, 6, $data->no_reff, 0, 0, 'C', 1);
             $this->cell(30, 6, $data->date, 0, 0, 'C', 1);
             $this->cell(20, 6,$data->currency_id , 0, 0, 'C', 1);
             $this->cell(30, 6, number_format($data->uang_muka, 2 , '.',','), 0, 0, 'R', 1);
             $this->cell(20, 6, number_format($data->currency_rate, 2 , '.',','), 0, 0, 'R', 1);
             $this->cell(30, 6, number_format($data->uang_muka*$data->currency_rate, 2 , '.',','), 0, 1, 'R', 1);*/

            $NO++;
        }
    }




    }

    function Footer() {
        $this->SetY(-25);
        $this->SetY(-10);
        //buat garis horizontal
        $this->Line(10, $this->GetY(), 285, $this->GetY());
        //nomor halaman
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of   {nb}', 0, 0, 'R');
    }

}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($_tampil);
$pdf->Output();
