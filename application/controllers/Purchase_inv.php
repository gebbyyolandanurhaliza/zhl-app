<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_inv extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_purchase_inv', 'M_purchase_inv_vendor', 'M_vcdn'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['SupplierID'] = $this->M_purchase_inv->get_cust();
        $data['title'] = "List of Purchase Invoice Jurnals";
        $data['List_payable'] = $this->M_purchase_inv->get_list_hutang();
        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_factory_list', $data);
    }

    function add_new() {
        $tgl = date("Y-m-d");
        $id = "0";
        $data['buyer'] = $this->M_purchase_inv->get_sup($tgl, $id);
        $data['supplier'] = $this->M_purchase_inv->supplier();
        $data['Currency'] = $this->M_purchase_inv->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $data['message'] = $this->session->flashdata('message');

        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_form', $data);
    }

    function edit(){
        $id = $_GET['id'];
        $data['Currency'] = $this->M_purchase_inv->get_currency();
        $data['get_data_header'] = $this->M_purchase_inv->get_data_header($id);
        $data['supplier'] = $this->M_purchase_inv->supplier();
        $data['nota'] = $this->M_purchase_inv->nota($id);
        $data['get_data_detail'] = $this->M_purchase_inv->get_data_detail($id);
        
        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_form', $data);
    }

    function printerin(){
        $id = $this->input->get('id');
        $data['get_data_header'] = $this->M_purchase_inv->get_data_header($id);
        $data['get_data_detail'] = $this->M_purchase_inv->get_data_detail($id);

        $this->load->view('accounting/Purchase_inv_factory/printerin', $data);
    }

    public function ambil_currency(){
        $data['currency']= $this->M_purchase_inv->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency_invoice', $data);
    }

    public function accounting_rate(){
        $date1=date('Y/m/d',strtotime($this->convert($this->input->get('date'))));
        $lastdate= date('Y/m/01',strtotime($this->convert($this->input->get('date'))));
        if($date1==$lastdate){
            $data['date'] = date('Y/m', strtotime("+2 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate'] = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
            $data['rate']= $this->M_purchase_inv->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
            $this->load->view('accounting/acc_filter_rate',$data);
        }
        else {
            $data['date'] = date('Y/m', strtotime("+1 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate'] = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
            $data['rate'] = $this->M_purchase_inv->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
            $this->load->view('accounting/acc_filter_rate', $data);
        }
    }

    public function convert($date){
        $explode=explode("/", $date);
        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        return $time;
    }

    function get_sup(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $date1 = '2015-01-01';
        }
        else
        {
            $date1=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $id = $_GET['type'];
        // echo $date1;
        // echo $date1;
        $data['buyer'] = $this->M_purchase_inv->get_sup($date1, $id);
        $this->load->view('accounting/Purchase_inv_factory/Ajax/get_sup_inv', $data);
    }

    function get_detail(){
        // $tgl = date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
         if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $supp = $this->input->get('supp');
        $id = $_GET['invtype'];
        
        $data['_detail'] = $this->M_purchase_inv->get_isidetail($tgl, $supp, $id);
        $this->load->view('accounting/Purchase_inv_factory/Ajax/get_isidet', $data);
    }

    function get_detail2(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }

        $data['_detail'] = $this->M_purchase_inv->get_isidetail2($tgl);
        $this->load->view('accounting/Purchase_inv_factory/Ajax/get_isidet', $data);
    }

    function getAjaxTanggal(){
        $id = $this->input->get('jeninv');
        $data['_tgl'] = $this->M_purchase_inv->getAjaxTanggal($id);
        $this->load->view('accounting/Purchase_inv_factory/Ajax/GetTanggal', $data);
    }

    function save_receivable_rec(){
        // $this->M_purchase_inv->save_data();
         $nofaktur = $this->input->post('nofaktur'); //hedaerID
        $tgl_jurnal = str_replace('/', '-', $this->input->post('tgl_jurnal'));
        $p_tanggal = date('Y-m-d', strtotime($tgl_jurnal)); //tanggal jurnal
        $tgl_tempo = str_replace('/', '-', $this->input->post('tgl_tempo'));
        $p_tanggal_tempo = date('Y-m-d', strtotime($tgl_tempo)); // tanggal tempo
        $tgl_invoice = str_replace('/', '-', $this->input->post('tgl_invoice'));
        $p_tanggal_invoice = date('Y-m-d', strtotime($tgl_invoice)); // tanggal shipment
        $supplier = $this->input->post('supplier');
        $rate = $this->input->post('rate_header');
        
        $rate_sgd = $this->input->post('rate_sgd');
        // $supplier = $this->input->post('supplierer');
        $currency = $this->input->post('Currency');
        $term = $this->input->post('term');
        $totalinv = $this->input->post('totalinv');
        $totalinvusd = $this->input->post('totalinvusd');
        $total_gst = $this->input->post('totalgst');
        $totalamount = $this->input->post('stotalinv');
        $bargename = $this->input->post('barge');
        $typeinv = $this->input->post('invtype');
        $buyer = $this->input->post('buyername');

        // detail
        $dtlcont = $this->input->post('detailidcont');
        $accountid = $this->input->post('accNum');
        $itemname = $this->input->post('det_items');
        $desc = $this->input->post('descr');
        $unit = $this->input->post('unit');
        $jenis_barge = $this->input->post('jenisbarge');
        $txtHarga = $this->input->post('txtHarga');
        $txtHargaUsd = $this->input->post('txtUSD');
        $txtgst = $this->input->post('txtGST');
        $txtgstvalue = $this->input->post('txtGSTValue');

        $submit_value = $this->input->post('sbt');
        //Simpan Header
        $created_by = $this->session->userdata('userid_1');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        if($submit_value == 'Save'){
             $perintah = 'add'; 
        }else{ 
            $perintah = 'edit'; 
            $this->M_purchase_inv->hapus($nofaktur);
        }

        //  tambahan 19-04-2018
        $id_cointaner = $this->input->post('idcontainer');
        // detail
        //tambahan 27-04-2018
        $txtTotal = $this->input->post('txtTotal');



        for($i = 0; $i < count($dtlcont); $i++){
            $data_detail = array(
                'p_headerid' => $nofaktur,
                'p_itemid' => $id_cointaner[$i],
                'p_itemname' => $itemname[$i],
                'p_qty' => 1,
                'p_unit' => $unit[$i],
                'p_price' => $txtHarga[$i],
                'p_amount' =>  $txtTotal[$i],
                'p_currency' => $currency,
                'p_rate' => $rate,
                'p_usdequivalen' => $txtHargaUsd[$i],
                'p_npbb' => $dtlcont[$i],
                'p_user' => $created_by,
                'p_ip' => $ip_address,
                'p_NoCOA' => $accountid[$i],
                'p_ratesgd' => $rate_sgd,
                'p_gst' => $txtgst[$i],
                'p_gst_value' => $txtgstvalue[$i],
                'p_detcont' => $dtlcont[$i],
                'p_typebarge' => $jenis_barge[$i],
                'p_decript' => $desc[$i],
                'p_tanggal' => $p_tanggal,
                'p_cust' => $supplier,
                'p_jenin' => $typeinv
            );

            $this->M_purchase_inv->call_save_dtl($data_detail);
        }


        $data_header = array(
            'p_perintah' => $perintah,
            'p_nofaktur' => $nofaktur,
            'p_company_id' => 'ZHL',
            'p_tanggal' => $p_tanggal,
            'p_tanggal_tempo' => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_kode_sup' => $supplier,
            'p_jenis_trans' => 'PIJV',
            'p_currency_id' => $this->input->post('Currency'),
            'p_term' => $term,
            'p_rate' => $rate,
            'p_rate_sgd' => $rate_sgd,
            'p_pajak' => round(str_replace(",", "",$total_gst),2),
            'p_diskon' => 0,
            'p_biaya_lain' => 0,
            'p_uang_muka' => 0,
            'p_hutang' => round(str_replace(",", "",$totalamount),2),
            'p_status' => '0',
            'p_created_by' => $created_by,
            'p_ip_address' => $ip_address,
            'p_nocoa' => 0,
            'p_status_dp' => 0,
            'p_jenin' => $typeinv,
            'p_voyage' => $bargename,
            'p_buyer' => $buyer
        );
        $this->M_purchase_inv->call_sp_rec_hutang($data_header);

        // $this->template->display("'""");
        redirect("Purchase_inv/edit?id=".$nofaktur);

    }

     //  Tambahan 19/04/2018
    function getharga(){
        $idcon = $_GET['idcont'];
        $jenisinv = $_GET['jen'];
        $x = $_GET['x'];
        $idd = "txtHarga-".$x;

        $sql = $this->M_purchase_inv->get_harga($idcon, $jenisinv);
        echo "<input type='text' name='txtHarga[]' class='txt number txtHarga dariAjax' id='$idd' onchange='hitung_total(0)' value='$sql'>";
        // echo "<input type='text' >"$sql;
        // return $sql;
    }
}
