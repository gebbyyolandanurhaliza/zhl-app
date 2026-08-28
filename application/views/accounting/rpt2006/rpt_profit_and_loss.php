<?php
$dari = $this->input->get('dari');
$sampai = $this->input->get('sampai');
$timeStart=strtotime($dari);
$timeEnd=strtotime($sampai);
$numbulan=1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
$numbulan += date("m",$timeEnd)-date("m",$timeStart);

$lbr=165;
$lbr -= 20 * $numbulan;


class PDF extends FPDF {
    function Content($get_coa, $jumlah_bulan, $tahun_akhir, $tahun_awal, $bulan_akhir, $bulan_awal, $akhir, $awal, $get_t1, $get_purchase, $dari, $sampai, $hide, $get_zopening, $get_zclosing, $get_gprofit, $get_general, $get_all) {
        $new_awal = date('F jS, Y', strtotime($dari));  
        $new_akhir = date('F jS, Y', strtotime($sampai));  
        $this->Ln(1);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(25, 5, 'PROFIT & LOSS FOR THE PERIOD '.$new_awal.' - '.$new_akhir, 0, 1, 'C', 1);

        $this->Ln(1);

        $NO = 1;
        $this->setFont('Arial', 'B', 7);
        $this->setFillColor(255, 255, 255);

        
        if (!empty($get_coa)) {
            $bln_awal = $bulan_awal - 1;
            $bln_akhir = $bulan_akhir - 1;

            $this->cell($this->lbr, 5, '', 0, 0, 'L', 1);
            for ($i = 1; $i <= $jumlah_bulan; $i++) {                
                $b=$i - 1;
                $tahun = date('Y', strtotime('+'.$b.' month', strtotime($dari)));

                if($hide != '1'){
                    $this->cell(20, 3, $tahun, 'TLR', 0, 'C', 1);    
                }
            }
            if ($jumlah_bulan > 0) { 
                $this->cell(20, 3, $tahun, 'TLR', 1, 'C', 1); 
            }
            $this->cell($this->lbr, 5, '', 0, 0, 'L', 1);
            for ($i = 1; $i <= $jumlah_bulan; $i++) {                
                $b=$i - 1;
                $namaBln = date('F', strtotime('+'.$b.' month', strtotime($dari)));
                if($hide != '1'){
                    $this->cell(20, 3, $namaBln, 'BLR', 0, 'C', 1);
                }
            }
            if ($jumlah_bulan > 0) {
                $this->cell(20, 3, 'Total', 'BLR', 1, 'C', 1);
            }
            $this->setFont('Arial', '', 7);            
            $awal= date('m', strtotime($dari)) +1;
            $akhir=date('m', strtotime($sampai));
            //Sales
            $this->cell($this->lbr, 5, 'Sales', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satu)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_dua)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tiga)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empat)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_lima)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enam)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuh)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapan)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilan)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluh)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelas)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelas)), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subsales)), 'BTLR', 1, 'R', 1);
               }
            } 
            $this->cell($this->lbr, 5, 'Purchase', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satup)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duap)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigap)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limap)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enamp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhp)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasp)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasp)), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subpurchase)), 'BTLR', 1, 'R', 1);
               }
            } 
            $this->cell($this->lbr, 5, '', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satul)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_dual)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigal)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limal)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enaml)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasl)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasl)), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_totalsp)), 'BTLR', 1, 'R', 1);
               }
            }
            $this->cell($this->lbr, 5, 'Closing Stock', 'BTLR', 0, 'L', 1);
            for ($i = 1; $i <= $jumlah_bulan; $i++) {
                $b=$i-1;
                if ($jumlah_bulan == 1) {
                    $new_awal=$awal;
                    $new_akhir=$akhir;
                } else{
                    switch ($i) {
                        case 1:
                            $new_awal=$awal;
                            $new_akhir=date('Y-m-t', strtotime($dari));
                            break;
                        case $jumlah_bulan:
                            $new_awal=date('Y-m-01', strtotime($sampai));
                            $new_akhir=$akhir;
                            break;
                        default:
                            $new_awal=date('Y-m-01', strtotime('+'.$b.' month', strtotime($dari)));
                            $new_akhir=date('Y-m-t', strtotime('+'.$b.' month', strtotime($dari)));
                            break;
                    }
                }
            if($hide != '1'){
                $closing=0;
                    foreach ($get_zclosing as $f) {     
                        $closing = 0 - $f->z_closing;
                    }
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', 0)), 'BTLR', 0, 'R', 1);
                }
            }
            //total closing stock start
            if ($jumlah_bulan > 0) {
                $total_closing  = 0;
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', 0)), 'BTLR', 1, 'R', 1);
            }
            $t_satul = $g->t_satul;
            $t_dual = $g->t_dual;
            $t_tigal = $g->t_tigal;
            $t_empatl = $g->t_empatl;
            $t_limal = $g->t_limal;
            $t_enaml = $g->t_enaml;
            $t_tujuhl = $g->t_tujuhl;
            $t_delapanl = $g->t_delapanl;
            $t_sembilanl = $g->t_sembilanl;
            $t_sepuluhl = $g->t_sepuluhl;
            $t_sebelasl = $g->t_sebelasl;
            $t_duabelasl = $g->t_duabelasl;
            $t_totalsp = $g->t_totalsp;
            $this->cell($this->lbr, 5, 'Gross Profit', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satul)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_dual)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigal)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limal)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enaml)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhl)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasl)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasl)), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_totalsp)), 'BTLR', 1, 'R', 1);
               }
            }
            $this->setFont('Arial', 'B', 7);
            $this->cell(185, 5, 'General & Administrative Expenses', 'BTLR', 1, 'L', 1);
            $this->setFont('Arial', '', 7);
            foreach ($get_general as $g) {
                $this->cell($this->lbr, 5, $g->t_accountname, 'BTLR', 0, 'L', 1);
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g1)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g2)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g3)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g4)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g5)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g6)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g7)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g8)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g9)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g10)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g11)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->g12)), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subgeneral)), 'BTLR', 1, 'R', 1);
                }
            }
            $t_satu = 0; 
            $t_dua = 0;
            $t_tiga = 0;
            $t_empat = 0;
            $t_lima = 0;
            $t_enam = 0;
            $t_tujuh = 0;
            $t_delapan = 0;
            $t_sembilan = 0;
            $t_sepuluh = 0;
            $t_sebelas = 0;
            $t_duabelas = 0;
                $t_subgeneral = 0;
            $this->setFont('Arial', 'B', 7);
            $this->cell($this->lbr, 5, 'Total Expenses', 'BTLR', 0, 'L', 1);
            foreach ($get_general as $g) {
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $t_satu += $g->g1; 
                $t_dua += $g->g2;
                $t_tiga += $g->g3;
                $t_empat += $g->g4;
                $t_lima += $g->g5;
                $t_enam += $g->g6;
                $t_tujuh += $g->g7;
                $t_delapan += $g->g8;
                $t_sembilan += $g->g9;
                $t_sepuluh += $g->g10;
                $t_sebelas += $g->g11;
                $t_duabelas += $g->g12;
                $t_subgeneral += $g->t_subgeneral;
            }
            for ($i= $awal-1; $i <= $akhir ; $i++) {  
                if ($i==1) {
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_satu)), 'BTLR', 0, 'R', 1);
                }elseif($i==2){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_dua)), 'BTLR', 0, 'R', 1);
                }elseif($i==3){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_tiga)), 'BTLR', 0, 'R', 1);
                }elseif($i==4){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_empat)), 'BTLR', 0, 'R', 1);
                }elseif($i==5){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_lima)), 'BTLR', 0, 'R', 1);
                }elseif($i==6){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_enam)), 'BTLR', 0, 'R', 1);
                }elseif($i==7){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_tujuh)), 'BTLR', 0, 'R', 1);
                }elseif($i==8){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_delapan)), 'BTLR', 0, 'R', 1);
                }elseif($i==9){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_sembilan)), 'BTLR', 0, 'R', 1);
                }elseif($i==10){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_sepuluh)), 'BTLR', 0, 'R', 1);
                }elseif($i==11){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_sebelas)), 'BTLR', 0, 'R', 1);
                }else{
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_duabelas)), 'BTLR', 0, 'R', 1);
                } 
            }
            // total gross profit start
            if ($jumlah_bulan > 0) {
                $total_general = 0;
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $t_subgeneral)), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Profit / (Loss) before Taxation', 'BTLR', 0, 'L', 1);
            $p_satu = $t_satu + $t_satul;
            $p_dua = $t_dua + $t_dual;
            $p_tiga = $t_tiga + $t_tigal;
            $p_empat = $t_empat + $t_empatl;
            $p_lima = $t_lima + $t_limal;
            $p_enam = $t_enam + $t_enaml;
            $p_tujuh = $t_tujuh + $t_tujuhl;
            $p_delapan = $t_delapan + $t_delapanl;
            $p_sembilan = $t_sembilan + $t_sembilanl;
            $p_sepuluh = $t_sepuluh + $t_sepuluhl;
            $p_sebelas = $t_sebelas + $t_sebelasl;
            $p_duabelas = $t_duabelas + $t_duabelasl;
            $p_totalpb = $t_subgeneral + $t_totalsp;
            for ($i= $awal-1; $i <= $akhir ; $i++) {  
                if ($i==1) {
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_satu)), 'BTLR', 0, 'R', 1);
                }elseif($i==2){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_dua)), 'BTLR', 0, 'R', 1);
                }elseif($i==3){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_tiga)), 'BTLR', 0, 'R', 1);
                }elseif($i==4){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_empat)), 'BTLR', 0, 'R', 1);
                }elseif($i==5){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_lima)), 'BTLR', 0, 'R', 1);
                }elseif($i==6){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_enam)), 'BTLR', 0, 'R', 1);
                }elseif($i==7){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_tujuh)), 'BTLR', 0, 'R', 1);
                }elseif($i==8){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_delapan)), 'BTLR', 0, 'R', 1);
                }elseif($i==9){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_sembilan)), 'BTLR', 0, 'R', 1);
                }elseif($i==10){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_sepuluh)), 'BTLR', 0, 'R', 1);
                }elseif($i==11){
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_sebelas)), 'BTLR', 0, 'R', 1);
                }else{
                    $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_duabelas)), 'BTLR', 0, 'R', 1);
                } 
            }
            // total gross profit start
            if ($jumlah_bulan > 0) {
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $p_totalpb)), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Income Tax', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satuincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duaincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigaincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limaincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enamincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhincome)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasincome)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasincome)), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subincome)), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Other Tax', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satuother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duaother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigaother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limaother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enamother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhother)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasother)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasother)), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subother)), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Profit / (Loss) Before Taxation', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_satuother+$g->t_satuincome+$p_satu)), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duaother+$g->t_duaincome+$p_dua)), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tigaother+$g->t_tigaincome+$p_tiga)), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_empatother+$g->t_empatincome+$p_empat)), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_limaother+$g->t_limaincome+$p_lima)), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_enamother+$g->t_enamincome+$p_enam)), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_tujuhother+$g->t_tujuhincome+$p_tujuh)), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_delapanother+$g->t_delapanincome+$p_delapan)), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sembilanother+$g->t_sembilanincome+$p_sembilan)), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sepuluhother+$g->t_sepuluhincome+$p_sepuluh)), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_sebelasother+$g->t_sebelasincome+$p_sebelas)), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_duabelasother+$g->t_duabelasincome+$p_duabelas)), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, str_replace("$", "", money_format('%(#10n', $g->t_subother+$g->t_subincome+$p_totalpb)), 'BTLR', 1, 'R', 1);
            }
    }
}
}
$pdf = new PDF('P','mm','A4');
$pdf->lbr=$lbr;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content($get_coa, $jumlah_bulan, $tahun_akhir, $tahun_awal, $bulan_akhir, $bulan_awal, $akhir, $awal, $get_t1, $get_purchase, $dari, $sampai, $hide, $get_zopening, $get_zclosing, $get_gprofit, $get_general, $get_all);
$pdf->Output();
