<?php 
	defined('BASEPATH') OR exit ('No direct script access allowed');


class Sales_inv extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Sales_inv','m_purchasing', 'M_purchase_inv', 'M_vcdn'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library(array('Fpdf','PHPExcel'));
        
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    // ============================  Halaman Utama ==============================================
    function index(){
    	$data['customer'] = $this->M_Sales_inv->get_cust();
    	$data['title'] = "List of Sales Invoice Jurnal";
    	$data['List_receive'] = $this->M_Sales_inv->get_piutang();
    	$this->template->display('accounting/Sales_inv_factory/Sales_inv_factory_list', $data);
    }
    // =========================== END ============================================================

    // ================================== Halaman buat dan edit invoice ============================
    function add_new(){
    	$data['customer'] = $this->M_Sales_inv->get_cust();
        $data['Currency'] = $this->M_purchase_inv->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa();

        $this->template->display('accounting/Sales_inv_factory/Sales_inv_form', $data);
    }

    function edit(){
        $id = $_GET['id'];
        $data['Currency'] = $this->M_purchase_inv->get_currency();
        $data['get_data_header'] = $this->M_Sales_inv->get_data_header($id);
        $data['customer'] = $this->M_Sales_inv->get_cust();
        // $data['supplier'] = $this->M_Sales_inv->supplier();
        $data['nota'] = $this->M_Sales_inv->nota($id);
        $data['dtlctr'] = $this->M_Sales_inv->get_dtlctr($id);
        $data['get_data_detail'] = $this->M_Sales_inv->get_data_detail($id);
        
        $this->template->display('accounting/Sales_inv_factory/Sales_inv_form', $data);
    }
    // =================================         END ADD AN EDIT       ==============================


    // ================================= CRUD DISINI YA ============================================
    function save_sales_inv(){
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
        $currency = $this->input->post('Currency');
        $term = $this->input->post('term');
        $totalinv = $this->input->post('totalinv');
        $totalinvusd = $this->input->post('totalinvusd');
        $total_gst = $this->input->post('totalgst');
        $totalamount = $this->input->post('stotalinv');
        $bargename = $this->input->post('barge');
        $typeinv = $this->input->post('invtype');
        $buyer = $this->input->post('buyername');
        $barge_dest = $this->input->post('dest_barge');
        $ports = $this->input->post('portes');

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
        
        $created_by = $this->session->userdata('userid_1');
        $ip_address = $_SERVER['REMOTE_ADDR'];

        if($submit_value == 'Save'){
             $perintah = 'add'; 
        }else{ 
            $perintah = 'edit'; 
            $this->M_Sales_inv->hapus($nofaktur);
        }

        //  tambahan 19-04-2018
        $id_cointaner = $this->input->post('idcontainer');
        //tambahan 27-04-2018
        $txtTotal = $this->input->post('txtTotal');

        //input detai_container
        // $container_name = $this->input->post('container_name');
        $container_id = $this->input->post('container_id');
        $contid = $this->input->post('contid');
        $container_number = $this->input->post('container_number');
        $seal_number = $this->input->post('seal_number');


        // insert detail
        for($i = 0; $i < count($dtlcont); $i++){
            $data_detail = array(
                'p_headerid' => $nofaktur,
                'p_itemid' => $id_cointaner[$i],
                'p_itemname' => $itemname[$i],
                'p_qty' => 1,
                'p_unit' => $unit[$i],
                'p_price' => round(str_replace(",", "", $txtHarga[$i]),  2),
                'p_amount' =>  round(str_replace(",", "",$txtTotal[$i]),  2),
                'p_currency' => $currency,
                'p_rate' => $rate,
                'p_usdequivalen' => round(str_replace(",", "",$txtHargaUsd[$i]),  2),
                'p_npbb' => $dtlcont[$i],
                'p_user' => $created_by,
                'p_ip' => $ip_address,
                'p_NoCOA' => $accountid[$i],
                'p_ratesgd' => $rate_sgd,
                'p_gst' => $txtgst[$i],
                'p_gst_value' => round(str_replace(",", "",$txtgstvalue[$i]),  2),
                'p_detcont' => $dtlcont[$i],
                'p_typebarge' => $jenis_barge[$i],
                'p_decript' => $desc[$i],
                'p_tanggal' => $p_tanggal,
                'p_cust' => $supplier,
                'p_jenin' => $typeinv
            );

            $this->M_Sales_inv->call_save_dtl($data_detail);
        }

        for($ii = 0; $ii < count($container_id); $ii++){
        	$data_container_dtl = array(
	        	'p_jurnal' => $nofaktur,
	        	'p_cont_type' =>  $container_id[$ii],
	        	'p_cont_number' => $container_number[$ii],
	        	'p_seal' => $seal_number[$ii],
	        	'p_contid' => $contid[$ii],
	        	'p_jenis_trans' => 'SIJV',
	        	'p_jenis_jurnal' => $typeinv
	        );

	        $this->M_Sales_inv->call_save_container_dtl($data_container_dtl);

        }

        //insert container detail
        // p_jurnal VARCHAR(50), p_cont_type int, p_cont_number VARCHAR(50), p_seal VARCHAR(50), p_contid BIGINT, p_jenis_trans VARCHAR(50), p_jenis_jurnal VARCHAR(50)
       

        // insert header
        $data_header = array(
            'p_perintah' => $perintah,
            'p_nofaktur' => $nofaktur,
            'p_company_id' => 'ZHL',
            'p_tanggal' => $p_tanggal,
            'p_tanggal_tempo' => $p_tanggal_tempo,
            'p_tanggal_invoice' => $p_tanggal_invoice,
            'p_kode_sup' => $supplier,
            'p_jenis_trans' => 'SIJV',
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
            'p_buyer' => $buyer,
            'p_bargedest' => $barge_dest,
            'p_port' => $ports
        );
        $this->M_Sales_inv->call_sp_rec_piutang($data_header);

        // $this->template->display("'""");
        redirect("Sales_inv/edit?id=".$nofaktur);
    }
    //=================================    END CRUD     ============================================

    // ==================================== AJAX SEMUA DISINI ============================================
    function getAjaxTanggal(){
        $id = $this->input->get('jeninv');
        $barge = $this->input->get('bargedest');
        $data['_tgl'] = $this->M_Sales_inv->getAjaxTanggal($id, $barge);
        $this->load->view('accounting/Sales_inv_factory/Ajax/GetTanggal', $data);
    }

    function get_detail(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $supp = $_GET['supp'];
        $inv = $_GET['invtype'];
        $port = $_GET['port'];
        $vesselname = $_GET['vesselname'];
        // echo $vesselname;

        $data['_detail'] = $this->M_Sales_inv->get_isidetail($tgl, $supp, $inv, $port, $vesselname);
        $this->load->view('accounting/Purchase_inv_factory/Ajax/get_isidet', $data);

    }

    function get_detailfre(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $supp = $_GET['supp'];
        $inv = $_GET['invtype'];
        $port = $_GET['port'];
        $vesselname = $_GET['vesselname'];
        // echo $vesselname;

        $data['_detail'] = $this->M_Sales_inv->get_isidetail_new($tgl, $supp, $inv, $port, $vesselname);
        $this->load->view('accounting/Sales_inv_factory/Ajax/get_isidet_dtlctr', $data);

    }

    function get_detail2(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $bargedest = $this->input->get('bargedest');

        $data['_detail'] = $this->M_Sales_inv->get_isidetail2($tgl, $bargedest);

        $this->load->view('accounting/Sales_inv_factory/Ajax/get_isidet', $data);
    }

    function get_detail3(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $bargedest = $this->input->get('bargedest');

        $data['_detail'] = $this->M_Sales_inv->get_isidetail3($tgl, $bargedest);

        $this->load->view('accounting/Sales_inv_factory/Ajax/get_isidet_dtlctr', $data);
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
        $data['buyer'] = $this->M_Sales_inv->get_sup($date1, $id);
        $this->load->view('accounting/Sales_inv_factory/Ajax/get_sup_inv', $data);
    }

    function get_port(){
    	if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $date1 = '2015-01-01';
        }
        else
        {
            $date1=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $id = $_GET['type'];
        $buyer = $_GET['buyer'];
        $port = $this->M_Sales_inv->get_port($date1, $id, $buyer);

        

        if(!empty($port)){
            $style_kategori = 'class="select2me form-control" id="portes" onKeydown="return validasi_enter(event)" onchange="get_vessel()" name="portes" required';
            echo form_dropdown('portes', $port, '', $style_kategori);
        }else{
        	echo "	<select name='port' id='portes' class='form-control'>
        				<option></option>
        			</select>";
        }


    }

    function get_vessel(){
        if(($_GET['date']==='undefined') OR empty($_GET['date'])){
            $tgl = '2015-01-01';
        }
        else
        {
            $tgl=date('Y-m-d',strtotime($this->convert($this->input->get('date'))));
        }
        $supp = $_GET['supp'];
        $inv = $_GET['invtype'];
        $port = $_GET['port'];

        $vessel = $this->M_Sales_inv->get_vessel($tgl, $supp, $inv, $port);

        if(!empty($vessel)){
            $style_kategori = 'class="select2me form-control" id="vesselname" onKeydown="return validasi_enter(event)" onchange="isi_barge();get_isi();get_isi_det();" required';
            echo form_dropdown('vesselname', $vessel, '', $style_kategori);
        }else{
            echo "  <select id='vesselname' class='form-control'>
                        <option></option>
                    </select>";
        }

    }

     function getharga(){
        $idcon = $_GET['idcont'];
        $jenisinv = $_GET['jen'];
        $x = $_GET['x'];
        $idd = "txtHarga-".$x;

        $sql = $this->M_Sales_inv->get_harga($idcon, $jenisinv);
        echo "<input type='text' name='txtHarga[]' class='txt number txtHarga dariAjax' id='$idd' onchange='hitung_total(0)' value='$sql'>";
        // echo "<input type='text' >"$sql;
        // return $sql;
    }

    // ====================================      END AJAX     ============================================


    // ====================================== fungsi tambahan ============================================
    public function convert($date){
        $explode=explode("/", $date);
        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        return $time;
    }
    // ===================================== END =========================================================
}

?>