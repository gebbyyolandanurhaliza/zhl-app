<?php
//$this->load->model(array('M_Profit_and_lost'));
$p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
$p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

$type = $this->input->get('type');
class PDF extends FPDF {

    function Header() {
         $tgal = $_GET['dari'];
        $tgal2 = $_GET['sampai'];
        $str = date_create($tgal);
        $str2 = date_create($tgal2);
        $periode = date_format($str,"d F Y");
        $periode2 = date_format($str2,"d F Y");
	$this->Image('assets/PSG.png', 12, 12, 31, 0, 'PNG');

        $this->setFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 153);
        $this->setFillColor(255, 255, 255);
        $this->Cell(120);
        $this->cell(30, 6, 'PULAU SAMBU SINGAPORE PTE LTD', 0, 1, 'C', 1);
        $this->setFont('Arial', 'B', 14);
        $this->Cell(120);
	$titel = 'PROFIT / (LOSS) STATEMENT AT ' . strtoupper($periode).' - '. strtoupper($periode2);
	$this->cell(25, 6, $titel, 0, 1, 'C', 1);


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

    function Content($get_invoice) {
        $this->Ln(10);
        $this->setFont('Arial', 'B', 12);
        $this->setFillColor(255, 255, 255);

    if (!empty($get_invoice)) {
        $this->Line(10, 44, 325 - 40, 44);

        $this->Ln(2);

        $NO = 1;
        $this->setFont('Arial', '', 12);
        $this->setFillColor(255, 255, 255);
     
            setlocale(LC_MONETARY, 'en_US.UTF-8');

            $hasilakhir = 0; $hasil = 0;  $hasil2 =0; $tt_totald = 0; $tt_totalk = 0;
            $hasilakhir_2 = 0;  $hasil_2  = 0; $hasil2_2 = 0; $tt_totald_2  = 0; $tt_totalk_2  = 0;
            $hasilakhir_3 = 0;  $hasil_3  = 0; $hasil2_3 = 0; $tt_totald_3  = 0; $tt_totalk_3  = 0;
            $hasilakhir_4 = 0;  $hasil_4  = 0; $hasil2_4 = 0; $tt_totald_4  = 0; $tt_totalk_4  = 0; $hasil_5  = 0;
            $t_1=0; $t_2=0; $t_3=0; $t_4=0;

            foreach ($get_invoice as $v){                                
                if ($v->id_group=='215' || $v->id_group=='217') {
                    $hasil = $v->MTKredit-$v->MTDebet;
                    $hasilakhir += $hasil;
                     if ($hasil < 0) {
                        $hasil2 = $hasil;
                        // $b = str_replace("-", "", $hasil);
                        // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                    } elseif ($hasil == 0) {
                        $hasil2 = '-';
                    } else {
                        $hasil2 = $hasil;
                    }
                    $t_12 = str_replace("$", "", money_format('%(#10n', $hasil2));

                    $this->cell(150, 6, strtoupper($v->nama_group), 0, 0, 'L', 1);
                    $this->cell(100, 6, $t_12, 0, 1, 'R', 1);
                } 
            }
            $this->setFont('Arial', 'B', 12);
            $this->setFillColor(255, 255, 255);


            $t_1 = str_replace("$", "", money_format('%(#10n', $hasilakhir));
            $this->cell(150, 6, "GROSS PROFIT", 0, 0, 'L', 1);
            $this->cell(100, 6, $t_1, 0, 1, 'R', 1);

            $this->Ln(4);

            $this->setFont('Arial', '', 12);
            $this->setFillColor(255, 255, 255);

            foreach ($get_invoice  as $g){
                    if ($g->id_group=='216') {
                        $hasil_3 = $g->MTKredit-$g->MTDebet;    
                        $hasilakhir3 = $hasilakhir+$hasil_3;
                         if ($hasil_3 < 0) {
                            $hasil2_3 = $hasil_3;    
                        } elseif ($hasil_3 == 0) {
                            $hasil2_3 = 0;
                        } else {
                            $hasil2_3 = $hasil_3;
                        }
                        $t_13 = str_replace("$", "", money_format('%(#10n', $hasil2_3));

                        $this->cell(150, 6, strtoupper($g->nama_group), 0, 0, 'L', 1);
                        $this->cell(100, 6, $t_13, 0, 1, 'R', 1);                                    
                    }
            }
            $this->setFont('Arial', 'B', 12);
            $this->setFillColor(255, 255, 255);

            $t_2 = str_replace("$", "", money_format('%(#10n', $hasilakhir3));
            $this->cell(150, 6, "", 0, 0, 'L', 1);
            $this->cell(100, 6, $t_2, 0, 1, 'R', 1);

            $this->Ln(4);

            $this->setFont('Arial', '', 12);
            $this->setFillColor(255, 255, 255);
            foreach ($get_invoice  as $g){
                    if ($g->id_group=='218' || $g->id_group=='219' ) {
                        $hasil_4 = $g->MTKredit-$g->MTDebet;
                        $hasil_5 += $hasil_4;                                        
                         if ($hasil_4 < 0) {
                            $hasil2_4 =$hasil_4;
                        } elseif ($hasil_4 == 0) {
                            $hasil2_4 = 0;
                        } else {
                            $hasil2_4 = $hasil_4;
                        }
                        $t_14 = str_replace("$", "", money_format('%(#10n', $hasil2_4));

                        $this->cell(150, 6, strtoupper($g->nama_group), 0, 0, 'L', 1);
                        $this->cell(100, 6, $t_14, 0, 1, 'R', 1); 
                    }                                
            }
            $this->setFont('Arial', 'B', 12);
            $this->setFillColor(255, 255, 255);
            $hasilakhir4 = $hasilakhir3+$hasil_5;

	    $this->Ln(4);
            $t_3 = str_replace("$", "", money_format('%(#10n', $hasilakhir4));
            $this->cell(150, 6, "PROFIT /( LOSS ) BEFORE TAXITON", 0, 0, 'L', 1);
            $this->cell(100, 6, $t_3, 0, 1, 'R', 1);
            }
        }
   }

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_invoice);
$pdf->Output();
