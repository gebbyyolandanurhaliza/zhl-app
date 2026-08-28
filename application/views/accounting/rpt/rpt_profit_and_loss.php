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
        $this->SetX(10);
        $this->Cell(190,25,'',0,0);
        $this->Image('assets/zhl-kop.PNG',3,8,205,33);
        $this->Ln();
        $this->SetX(10);

        $this->Ln(1);
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);
        $this->Cell(80);
        $this->cell(25, 5, 'PROFIT & LOSS FOR THE PERIOD '.$new_awal.' - '.$new_akhir, 0, 1, 'C', 1);

        $this->Ln(1);
        
        $this->SetTextColor(0, 0, 0);

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
                        $this->cell(20, 5, number_format( $g->t_satu, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_dua, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tiga, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empat, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_lima, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enam, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuh, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapan, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilan, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluh, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, number_format( $g->t_subsales, 2,',','.'), 'BTLR', 1, 'R', 1);
               }
            } 
            $this->cell($this->lbr, 5, 'Purchase', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->t_satup, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_duap, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigap, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limap, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enamp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasp, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, number_format( $g->t_subpurchase, 2,',','.'), 'BTLR', 1, 'R', 1);
               }
            } 
            $this->cell($this->lbr, 5, '', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->t_satul, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_dual, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigal, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limal, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enaml, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, number_format( $g->t_totalsp, 2,',','.'), 'BTLR', 1, 'R', 1);
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
                    $this->cell(20, 5, number_format( 0, 2,',','.'), 'BTLR', 0, 'R', 1);
                }
            }
            //total closing stock start
            if ($jumlah_bulan > 0) {
                $total_closing  = 0;
                $this->cell(20, 5, number_format( 0, 2,',','.'), 'BTLR', 1, 'R', 1);
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
                        $this->cell(20, 5, number_format( $g->t_satul, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_dual, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigal, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limal, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enaml, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasl, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, number_format( $g->t_totalsp, 2,',','.'), 'BTLR', 1, 'R', 1);
               }
            }
            $this->setFont('Arial', 'B', 7);
            $this->cell(185, 5, 'General & Administrative Expenses', 'BTLR', 1, 'L', 1);
            $this->setFont('Arial', '', 7);
            foreach ($get_general as $g) {
                $this->cell($this->lbr, 5, $g->t_accountname, 'BTLR', 0, 'L', 1);
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->g1, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->g2, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->g3, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->g4, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->g5, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->g6, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->g7, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->g8, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->g9, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->g10, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->g11, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->g12, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
                // total gross profit start
                if ($jumlah_bulan > 0) {
                        $total_general = 0;
                        $this->cell(20, 5, number_format( $g->t_subgeneral, 2,',','.'), 'BTLR', 1, 'R', 1);
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
                    $this->cell(20, 5, number_format( $t_satu, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==2){
                    $this->cell(20, 5, number_format( $t_dua, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==3){
                    $this->cell(20, 5, number_format( $t_tiga, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==4){
                    $this->cell(20, 5, number_format( $t_empat, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==5){
                    $this->cell(20, 5, number_format( $t_lima, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==6){
                    $this->cell(20, 5, number_format( $t_enam, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==7){
                    $this->cell(20, 5, number_format( $t_tujuh, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==8){
                    $this->cell(20, 5, number_format( $t_delapan, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==9){
                    $this->cell(20, 5, number_format( $t_sembilan, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==10){
                    $this->cell(20, 5, number_format( $t_sepuluh, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==11){
                    $this->cell(20, 5, number_format( $t_sebelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                }else{
                    $this->cell(20, 5, number_format( $t_duabelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                } 
            }
            // total gross profit start
            if ($jumlah_bulan > 0) {
                $total_general = 0;
                $this->cell(20, 5, number_format( $t_subgeneral, 2,',','.'), 'BTLR', 1, 'R', 1);
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
                    $this->cell(20, 5, number_format( $p_satu, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==2){
                    $this->cell(20, 5, number_format( $p_dua, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==3){
                    $this->cell(20, 5, number_format( $p_tiga, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==4){
                    $this->cell(20, 5, number_format( $p_empat, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==5){
                    $this->cell(20, 5, number_format( $p_lima, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==6){
                    $this->cell(20, 5, number_format( $p_enam, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==7){
                    $this->cell(20, 5, number_format( $p_tujuh, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==8){
                    $this->cell(20, 5, number_format( $p_delapan, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==9){
                    $this->cell(20, 5, number_format( $p_sembilan, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==10){
                    $this->cell(20, 5, number_format( $p_sepuluh, 2,',','.'), 'BTLR', 0, 'R', 1);
                }elseif($i==11){
                    $this->cell(20, 5, number_format( $p_sebelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                }else{
                    $this->cell(20, 5, number_format( $p_duabelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                } 
            }
            // total gross profit start
            if ($jumlah_bulan > 0) {
                $this->cell(20, 5, number_format( $p_totalpb, 2,',','.'), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Income Tax', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->t_satuincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_duaincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigaincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limaincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enamincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasincome, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, number_format( $g->t_subincome, 2,',','.'), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Other Tax', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->t_satuother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_duaother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigaother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limaother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enamother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasother, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, number_format( $g->t_subother, 2,',','.'), 'BTLR', 1, 'R', 1);
            }
            $this->cell($this->lbr, 5, 'Profit / (Loss) Before Taxation', 'BTLR', 0, 'L', 1);
            foreach ($get_all as $g) {
                for ($i= $awal-1; $i <= $akhir ; $i++) {  
                    if ($i==1) {
                        $this->cell(20, 5, number_format( $g->t_satuother+$g->t_satuincome+$p_satu, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==2){
                        $this->cell(20, 5, number_format( $g->t_duaother+$g->t_duaincome+$p_dua, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==3){
                        $this->cell(20, 5, number_format( $g->t_tigaother+$g->t_tigaincome+$p_tiga, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==4){
                        $this->cell(20, 5, number_format( $g->t_empatother+$g->t_empatincome+$p_empat, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==5){
                        $this->cell(20, 5, number_format( $g->t_limaother+$g->t_limaincome+$p_lima, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==6){
                        $this->cell(20, 5, number_format( $g->t_enamother+$g->t_enamincome+$p_enam, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==7){
                        $this->cell(20, 5, number_format( $g->t_tujuhother+$g->t_tujuhincome+$p_tujuh, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==8){
                        $this->cell(20, 5, number_format( $g->t_delapanother+$g->t_delapanincome+$p_delapan, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==9){
                        $this->cell(20, 5, number_format( $g->t_sembilanother+$g->t_sembilanincome+$p_sembilan, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==10){
                        $this->cell(20, 5, number_format( $g->t_sepuluhother+$g->t_sepuluhincome+$p_sepuluh, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }elseif($i==11){
                        $this->cell(20, 5, number_format( $g->t_sebelasother+$g->t_sebelasincome+$p_sebelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                    }else{
                        $this->cell(20, 5, number_format( $g->t_duabelasother+$g->t_duabelasincome+$p_duabelas, 2,',','.'), 'BTLR', 0, 'R', 1);
                    } 
                }
            }
            if ($jumlah_bulan > 0) {
                $subsales = 0;
                $this->cell(20, 5, number_format( $g->t_subother+$g->t_subincome+$p_totalpb, 2,',','.'), 'BTLR', 1, 'R', 1);
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
