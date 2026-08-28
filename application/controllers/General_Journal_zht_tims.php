
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General_Journal_zht_tims extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_General_Journal_zht','M_vcdn', 'm_po_journal', 'M_login'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "List of Payable Recognition ZHT";
        $data['List_payable'] = $this->M_General_Journal_zht->get_list_hutang();
        $data['List_general'] = $this->M_General_Journal_zht->get_list();
       $this->template->display('accounting/General_Journal_zht/General_Journal_list_zht', $data);
    }

    function ambil_currency() {
        $kurs= $this->input->get('kurs');
        $tgl = date('Y/m/d',strtotime($this->convert($this->input->get('tgl'))));
        $data['currency'] = $this->M_General_Journal_zht->tampil_po_rate($kurs, $tgl);
        $this->load->view('accounting/ajax/get_currency_gj', $data);
        
    }

    function ambil_currency2() {
        $kurs= $this->input->get('kurs');
        $tgl = date('Y/m/d',strtotime($this->convert($this->input->get('tgl'))));
        $data['thn'] = date('Y', strtotime($tgl));
        $data['bln'] = date('m', strtotime($tgl));
        $data['hari'] = date('d', strtotime($tgl));
        $data['currency'] = $this->M_General_Journal_zht->tampil_po_rate($kurs, $tgl);
        $this->load->view('accounting/ajax/get_currency_error', $data);
    }    

     public function convert($date){
        $explode=explode("/", $date);

        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];

        return $time;
    }

    function cekrate() {
        $rate = $this->input->get('rate');
        if ($rate <= 0) {
            $data['rate_usd'] = 0;
        }else{
            $data['rate_usd'] = $rate;
        }


    }

    function add_new() {
        $company   = strtoupper($this->session->userdata('company_id'));
        $date = date('Y-m-d');
        $data['SupplierID'] = $this->M_General_Journal_zht->get_supplier();
        $data['dept_code'] = $this->M_General_Journal_zht->get_departmentcode();
        $data['dept_code_json'] = json_encode($data['dept_code']);

        $data['Currency'] = $this->M_General_Journal_zht->get_currency($date);
        $data['List_coa'] = $this->M_vcdn->get_coa_tims($company);
        // echo "<pre>";
        // print_r($data['List_coa']);
        // echo "</pre>";
        // die;
        $data['_reff'] = $this->get_refnumber($date);
        $data['cur']=  $this->m_po_journal->tampil_cur();
        $this->template->display('accounting/General_Journal_zht/General_form_zht', $data);
    }

    function edit() {
        // $data['SupplierID'] = $this->M_General_Journal_zht->get_supplier();
        // $data['Currency'] = $this->M_General_Journal_zht->get_currency();
        // $data['CurrencyID'] = $this->M_General_Journal_zht->get_currency_detail();
        // //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        // $id = $this->input->get("id");

        // //variable invoice number header
        // $data['HeaderID'] = $id;
        // $data['nota'] = $this->M_General_Journal_zht->nota($id);
        // $data['get_data_header'] = $this->M_General_Journal_zht->get_data_header($id);
        // //variable invoice number detail
        // $data['get_data_detail'] = $this->M_General_Journal_zht->get_data_detail($id);
        // //variable invoice number footer
        // $data['get_data_footer'] = $this->M_General_Journal_zht->get_data_footer($id);
        $id = $this->input->get('id');
        $company = strtoupper($this->session->userdata('company_id'));
        $data['get_header'] = $this->M_General_Journal_zht->get_header($id);
        $data['get_jurnal'] = $this->M_General_Journal_zht->get_jurnal($id);
        $data['List_coa'] = $this->M_vcdn->get_coa(2);
        $data['dept_code'] = $this->M_General_Journal_zht->get_departmentcode();
        $data['dept_code_json'] = json_encode($data['dept_code']);
        $close_date         = $this->M_login->ambil_tgl()->row();
        $data['closing']    = date_format(date_create($close_date->tanggal), "d/m/Y");
        $this->template->display('accounting/General_Journal_zht/General_form_zht', $data);
    }

    function list_currency() {
        $data['Currency'] = $this->M_General_Journal_zht->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function get_currency_date() {
        $sekarang = date($this->uri->segment(3));
        $data['Currency'] = $this->M_General_Journal_zht->get_currency_date($sekarang);
        $this->load->view('accounting/list_currency_date', $data);
    }

    function list_payable() {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_General_Journal_zht->get_data_header($id);
    }

    function get_refnumber($tgli){
        $date = $tgli;
        $tahun = substr($tgli,2,6);
        $bulan = substr($tgli,0,2);
        // echo $date;
        $ini = $this->M_General_Journal_zht->get_refnum($tahun, $bulan);

        if(empty($ini)){
            $ref = 'ZHTGV'.$bulan.$tahun.'0001';
            // echo $ref;
        }
        else{
             $no1 = $ini->no_reff;
             // echo $no1;
             $no2 = substr($no1,11,6);
             // echo $no2;
             $no3 = intval($no2) + 1;
             $no4 = str_pad($no3,4,0, STR_PAD_LEFT);
             $ref = 'ZHTGV'.$bulan.$tahun.$no4;

        }
        return $ref;
        // echo $ref;
    }

    function get_refnumber1(){
        $tgl = $this->input->get('tgl');
        $data['_reff'] = $this->get_refnumber($tgl);

        $this->load->view('accounting/General_Journal_zht/General_ref_zht', $data);
    }

    function save(){
        $tgl1 = $this->session->userdata('periode_1');
        $tgl2 = $tgl1."/01";
        // echo $tgl2;
        $tanggal = date_create($tgl2);
        $no_ref = $this->input->post('refno');
        $var = $this->input->post('tanggal');
        $date = str_replace('/', '-', $var);
        $tanggal1 = date('Y-m-d', strtotime($date));
        // echo $tanggal1;
        $currency = $this->input->post('currency');
        $cur = $this->input->post('cur');
        $rate_usd = $this->input->post('rate_usd');
        $rate_sgd = $this->input->post('rate_sgd');
        $nocoa = $this->input->post('txtAccountNo');
        $namacoa = $this->input->post('txtAccountName');
        $deskripsi = $this->input->post('txtDesc');
        $dept_code = $this->input->post('txtdept');
        $totaldebet = $this->input->post('nota_debet');
        $totalcredit = $this->input->post('nota_credit');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        // $periode = $this->session->userdata('periode_1');
        $p1 = date_format($tanggal, "Y");
        $p2 = date_format($tanggal, "m");
        $periode = $p1."/".$p2;
        // echo $periode;
        // echo $periode;
        //echo $p1;
        $txtdebet = $this->input->post('txtDebt');
        $txtcredit = $this->input->post('txtCredit');
        $submit = $this->input->post('sbt');
        $by = $this->session->userdata('userid_1');
        $dateby = date('Y-m-d H:i:s');
        $created_by = $this->input->post('created_by');
        $created_date = $this->input->post('created_date');

        $dk = '';
        $debet = 0;
        $credit = 0;
        $credit_sgd = 0;
        $debet_sgd = 0;
        $sum_debet = 0;
        $sum_debet_sgd = 0;

        $rems = $this->input->post('remarkss');


        // $this->db->trans_begin();

        if($submit == 'Save'){
            for($j = 0; $j < count($txtdebet); $j++){
                $data = array(
                    'no_reff'=>$no_ref,
                    'tanggal'=>$tanggal1,
                    'currency'=>$currency,
                    'JenisJurnalID'=>$namacoa[$j],
                    'no_coa'=>$nocoa[$j],
                    'dept_code'=>$dept_code[$j],
                    'rate'=>$rate_usd,
                    'rate_sgd'=>$rate_sgd,
                    'description' => $deskripsi[$j],
                    'debet'=> number_format(str_replace(",", "", $txtdebet[$j]), 2, ".", ""),
                    'credit'=> number_format(str_replace(",", "", $txtcredit[$j]), 2, ".", ""),
                    'created_by'=>$by,
                    'created_date'=>$dateby,
                    'remarks'=> $rems
                    );
                $this->M_General_Journal_zht->simpan_header($data);
            }

            for($i = 0; $i < count($txtdebet); $i++){
                if ($txtdebet[$i] > 0) {
                    $dk = 'D';
                    $debet = number_format(str_replace(",", "", $txtdebet[$i]) * $rate_usd, 2, ".", "");
                    $debet_sgd = number_format(str_replace(",", "", $txtdebet[$i]) * $rate_sgd, 2, ".", "");
                    $credit = '0';
                    $credit_sgd = '0';
                    $sum_debet += $debet;
                    $sum_debet_sgd += $debet_sgd;
                }elseif($txtcredit[$i] > 0){
                    $dk = 'C';
                    $debet = '0';
                    $debet_sgd = '0';
                    $credit = number_format(str_replace(",", "", $txtcredit[$i]) * $rate_usd, 2, ".", "");
                    $credit_sgd = number_format(str_replace(",", "", $txtcredit[$i]) * $rate_sgd, 2, ".", "");
                    $sum_credit +=  $credit;
                    $sum_credit_sgd += $credit_sgd;
                }

                if ((count($txtdebet) - 1) == $i){
                    $selisih = $sum_debet - $sum_credit;

                    if ($selisih != 0) {
                        if ($dk == 'D') {
                            $debet = $debet - $selisih; 
                        } else {
                            $credit = $credit + $selisih; 
                        }
                    }

                    $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                    if ($selisih_sgd != 0){
                        if ($dk == 'D') {
                            $debet_sgd = $debet_sgd - $selisih_sgd; 
                        } else {
                            $credit_sgd = $credit_sgd + $selisih_sgd; 
                        }
                    }
                }

                $data_jurnal = array(
                    'JenisJurnalID'=>$namacoa[$i],
                    'CompanyID'=>'PSS',
                    'jenis_trans' => 'GJ',
                    'NoJurnal'=>$no_ref,
                    'Tanggal'=>$tanggal1,
                    'chk' =>$dk,
                    'periode'=>$periode,
                    'NoCOA'=>$nocoa[$i],
                    'dept_code'=>$dept_code[$i],
                    'Uraian'=>$deskripsi[$i],
                    'Debet'=> round($debet,2),
                    'Kredit'=> round($credit,2),
                    'Debet_SGD'=> round($debet_sgd,2),
                    'Kredit_SGD'=> round($credit_sgd,2),
                    'Total' => round(str_replace(",", "",$txtdebet[$i]) + str_replace(",", "",$txtcredit[$i]),2),
                    'Currency'=>$currency,
                    'Rate'=>$rate_usd,
                    'rate_sgd'=>$rate_sgd,
                    'CurrencyAsal'=>$currency,
                    'RateAsal'=>$rate_usd,
                    'created_by'=>$by,
                    'created_date'=>$dateby,
                    'ip_address' =>$ip_address
                    );
                $this->M_General_Journal_zht->simpan_jurnal($data_jurnal);
            }
            redirect("General_Journal_zht_tims/edit?id=$no_ref");
        }
        else{
            $this->M_General_Journal_zht->delete_header($no_ref);
            $this->M_General_Journal_zht->delete_jurnal($no_ref);
            
            for($j = 0; $j < count($txtdebet); $j++){
                $data = array(
                    'no_reff'=>$no_ref,
                    'tanggal'=>$tanggal1,
                    'currency'=>$currency,
                    'JenisJurnalID'=>$namacoa[$j],
                    'no_coa'=>$nocoa[$j],
                    'dept_code'=>$dept_code[$j],
                    'rate'=>$rate_usd,
                    'rate_sgd'=>$rate_sgd,
                    'description' => $deskripsi[$j],
                    'debet'=> number_format(str_replace(",", "", $txtdebet[$j]), 2, ".", ""),
                    'credit'=> number_format(str_replace(",", "", $txtcredit[$j]), 2, ".", ""),
                    'created_by'=>$created_by,
                    'created_date'=>$created_date,
                    'update_by'=>$by,
                    'update_date'=>$dateby,
                    'remarks'=> $rems
                    );
                $this->M_General_Journal_zht->simpan_header($data);
            }

            for($i = 0; $i < count($txtdebet); $i++){
                if ($txtdebet[$i] > 0) {
                    $dk = 'D';
                    $debet = number_format(str_replace(",", "", $txtdebet[$i]) * $rate_usd, 2, ".", "");
                    $debet_sgd = number_format(str_replace(",", "", $txtdebet[$i]) * $rate_sgd,  2, ".", "");
                    $credit = '0';
                    $credit_sgd = '0';
                    $sum_debet += $debet;
                    $sum_debet_sgd += $debet_sgd;
                }elseif($txtcredit[$i] > 0){
                    $dk = 'C';
                    $debet = '0';
                    $debet_sgd = '0';
                    $credit = number_format(str_replace(",", "", $txtcredit[$i]) * $rate_usd, 2, ".", "");
                    $credit_sgd = number_format(str_replace(",", "", $txtcredit[$i]) * $rate_sgd, 2, ".", "");
                    $sum_credit +=  $credit;
                    $sum_credit_sgd += $credit_sgd;
                }

                if ((count($txtdebet) - 1) == $i){
                    $selisih = $sum_debet - $sum_credit;

                    if ($selisih != 0) {
                        if ($dk == 'D') {
                            $debet = $debet - $selisih; 
                        } else {
                            $credit = $credit + $selisih; 
                        }
                    }

                    $selisih_sgd = $sum_debet_sgd - $sum_credit_sgd;

                    if ($selisih_sgd != 0){
                        if ($dk == 'D') {
                            $debet_sgd = $debet_sgd - $selisih_sgd; 
                        } else {
                            $credit_sgd = $credit_sgd + $selisih_sgd; 
                        }
                    }
                }

                $data_jurnal = array(
		            'JenisJurnalID'=>$namacoa[$i],
                    'CompanyID'=>'ZHL',
                    'jenis_trans' => 'GJ',
                    'NoJurnal'=>$no_ref,
                    'Tanggal'=>$tanggal1,
                    'chk' =>$dk,
                    'periode'=>$periode,
                    'NoCOA'=>$nocoa[$i],
                    'dept_code'=>$dept_code[$i],
                    'Uraian'=>$deskripsi[$i],
                    'Debet'=> round($debet,2),
                    'Kredit'=> round($credit,2),
                    'Debet_SGD'=> round($debet_sgd,2),
                    'Kredit_SGD'=> round($credit_sgd,2),
                    'Total' => round(str_replace(",", "",$txtdebet[$i]) + str_replace(",", "",$txtcredit[$i]),2),
                    'Currency'=>$currency,
                    'Rate'=>$rate_usd,
                    'rate_sgd'=>$rate_sgd,
                    'CurrencyAsal'=>$currency,
                    'RateAsal'=>$rate_usd,
                    'created_by'=>$by,
                    'created_date'=>$dateby,
                    'ip_address' =>$ip_address
                    );
                $this->M_General_Journal_zht->simpan_jurnal($data_jurnal);
            }

        }

        // if ($this->db->trans_status() === FALSE)
        // {
        //     $this->db->trans_rollback();
        //     redirect("General_Journal_zht_tims/add_new");
        // }
        // else
        // {
        //     $this->db->trans_commit();
            redirect("General_Journal_zht_tims/edit?id=".$no_ref);
        // }

    }

    function delete() {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_General_Journal_zht->delete_item($id);
        redirect("Payable_recognition/edit?id=$nofaktur");

    }


     function hapus(){
        $id = $this->input->get('id');
        $created = $this->session->userdata('userid_1');
        $created_date = date('Y-m-d');

        $cek_gl = $this->M_General_Journal_zht->cek_gl();

        $this->db->trans_begin();

        if($id != $cek_gl->no_reff){

            $data_hdr = array(
                'debet' => 0,
                'credit' => 0,
                'description' => 'Cancelled',
                'update_by' => $created,
                'update_date' => $created_date

            );

            $this->M_General_Journal_zht->update_header($id,$data_hdr);

            $data_jur = array('Debet' => 0,
                'Kredit' => 0,
                'Debet_SGD'=>0,
                'Kredit_SGD'=>0,
                'Total'=>0,
                'keterangan' => 'Cancelled',
                'last_update_by' => $created,
                'last_update_date' => $created_date

            );

            $this->M_General_Journal_zht->update_jurnal($id,$data_jur);
        } else {
            $this->M_General_Journal_zht->delete_header($id);
            $this->M_General_Journal_zht->delete_jurnal($id);
        }

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            redirect("General_Journal_zht_tims?stat=notok");
        }
        else
        {
            $this->db->trans_commit();
            redirect("General_Journal_zht_tims?stat=ok");
        }

    }

    function print_gj_2() {
        $id = $this->input->get('id');
        $data['get_header'] = $this->M_General_Journal_zht->get_header($id);
        $data['get_jurnal'] = $this->M_General_Journal_zht->get_jurnal($id);
        $data['List_coa'] = $this->M_vcdn->get_coa();

        
        $this->load->view('accounting/rpt/rpt_general_journal', $data);
    }


    function print_gj() {
        $id = $this->input->get('id');
        $data['company'] = strtoupper($this->session->userdata('company_id'));

        $data['get_header'] = $this->M_General_Journal_zht->get_header($id);
        $data['get_jurnal'] = $this->M_General_Journal_zht->get_jurnal($id);
        $data['List_coa'] = $this->M_vcdn->get_coa();

        $jurnal = $this->M_General_Journal_zht->get_jurnal($id);
        $totals = 0;
        if(!empty($jurnal))
        {
            foreach ($jurnal as $v) {
                $totals += $v->debet;
            }
        }

        $jur = array('totals' => $totals);
        $data['ini'] = $jur;

        $this->load->view('accounting/rpt/rpt_general_journal_2', $data);
    }

    function selectInvoiceGJ(){
        $data   = array(
            '_selectHeader' => $this->M_General_Journal_zht->selectInvoiceforFindGJ()->result()
        );
        $this->load->view('accounting/General_Journal_zht/FindIGJ/selectIGJ_zht',$data);
    }
}
