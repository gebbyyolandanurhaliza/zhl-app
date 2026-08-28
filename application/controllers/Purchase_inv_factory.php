
<?php
//update date : 3 Dec 16 9.59 PM
//Update By : deki


defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_inv_factory extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model(array('M_purchase_inv_factory', 'M_purchase_inv_vendor', 'M_vcdn'));
        $this->load->library(array('template', 'user_agent'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['SupplierID'] = $this->M_purchase_inv_factory->get_cust();
        $data['title'] = "List of Receivable Recognition";
        $data['List_payable'] = $this->M_purchase_inv_factory->get_list_hutang();
        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_factory_list', $data);
    }

    function search() {
        $data['SupplierID'] = $this->M_purchase_inv_factory->get_sup();
        $invoice = $this->input->get("invoice");

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));


        $supplier = $this->input->get("supplier");
        $data['tgl'] = $dari;
        if ($dari != '') {
            $data['List_payable'] = $this->M_purchase_inv_factory->advance_list_hutang($p_dari, $p_sampai, $invoice, $supplier);
        } else {
            $data['List_payable'] = $this->M_purchase_inv_factory->advance_list_hutang1($invoice, $supplier);
        }
        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_factory_list', $data);
    }

    function add_new() {
        $data['SupplierID'] = $this->M_purchase_inv_factory->get_sup();
        $data['Currency'] = $this->M_purchase_inv_factory->get_currency();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $data['message'] = $this->session->flashdata('message');

        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_factory_form', $data);
    }

    function get_coa() {
        // tangkap variabel keyword dari URL
        $keyword = $this->uri->segment(3);

        // cari di database
        $data = $this->db->from('acc_master_coa')->like('NoCOA', $keyword)->get();

        // format keluaran di dalam array
        foreach ($data->result() as $row) {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' => $row->NoCOA . " | " . $row->AccountName,
                'NoCOA' => $row->NoCOA,
                'AccountName' => $row->AccountName
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    function tampil_po() {
        $supplier = $this->input->get("supplier");
        $currency = $this->input->get("currency");

        $data["list_po"] = $this->M_purchase_inv_factory->tampil_po_list($supplier, $currency);

        $this->load->view('accounting/ajax/tampil_po_factory_mar', $data);
    }

    function data_dp() {
        $id = $this->input->get("id");
        $currency = $this->input->get("currency");

        $data['pilih_dp'] = $this->M_purchase_inv_factory->pilih_dp($id, $currency);
        $this->load->view('accounting/list_dp', $data);
    }

    function edit() {
        $data['SupplierID'] = $this->M_purchase_inv_factory->get_sup();
        $data['Currency'] = $this->M_purchase_inv_factory->get_currency();
        $data['message'] = $this->session->flashdata('message');
        $data['CurrencyID'] = $this->M_purchase_inv_factory->get_currency_detail();
        $data['List_coa'] = $this->M_vcdn->get_coa();
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['get_data_header'] = $this->M_purchase_inv_factory->get_data_header($id);
        $data['nota'] = $this->M_purchase_inv_factory->nota($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_purchase_inv_factory->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_purchase_inv_factory->get_data_footer($id);

        $data['get_data_jurnal1'] = $this->M_purchase_inv_factory->get_data_awal($id, 'COGS');
        $data['get_data_jurnal2'] = $this->M_purchase_inv_factory->get_data_jurnal(2, $id, 'PIFF');
        $data['get_data_jurnal3'] = $this->M_purchase_inv_factory->get_data_jurnal(3, $id, 'PIFF');
        $data['get_data_jurnal4'] = $this->M_purchase_inv_factory->get_data_jurnal(4, $id, 'PIFF');
        $data['get_data_jurnal5'] = $this->M_purchase_inv_factory->get_data_jurnal(5, $id, 'PIFF');
        $data['get_data_jurnal6'] = $this->M_purchase_inv_factory->get_data_jurnal(6, $id, 'PIFF');


        $data['data_bawah'] = $this->M_purchase_inv_factory->data_paling_bawah($id);

        $this->template->display('accounting/Purchase_inv_factory/Purchase_inv_factory_form', $data);
    }

    function print_report() {
        $data['SupplierID'] = $this->M_purchase_inv_factory->get_customer();
        $data['Currency'] = $this->M_purchase_inv_factory->get_currency();
        $data['CurrencyID'] = $this->M_purchase_inv_factory->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['titel'] = 'Payable Recognition';
        $data['nota'] = $this->M_purchase_inv_factory->nota($id);
        $data['get_data_header'] = $this->M_purchase_inv_factory->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_purchase_inv_factory->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_purchase_inv_factory->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_receivable_recognition', $data);
    }

    function list_currency() {
        $data['Currency'] = $this->M_purchase_inv_factory->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function list_payable() {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_purchase_inv_factory->get_data_header($id);
    }

    function update_po() {

        $po_number = $this->input->post("no_po");
        $bayar = $this->input->post("bayar");

        for ($e = 0; $e < count($bayar); $e++) {
            $data = array('bayar' => $this->input->post("bayar")[$e]);
            $this->M_Receivable_recogniton->update_dp($po_number[$e], $data);
        }
    }

    function save_receivable_rec() {
    		$nofaktur = $this->input->post('nofaktur');
            $query = $this->M_purchase_inv_factory->simpan_inv();

            if($query['flag'] == 'True'){
	            $this->session->set_flashdata('message', pesan("The transaction has been successfully saved with the Invoice Number : $nofaktur", pesan_info()));
            	redirect("Purchase_inv_factory/edit?id=$nofaktur");
	        }else{
	            $this->session->set_flashdata('message', pesan("Transaction Broken", pesan_info()));
            redirect("Purchase_inv_factory/add_new");
	        }
    }

    function delete() {
        $id = $this->input->get("id");
        $idj = $this->input->get("idjurnal");
        $nofaktur = $this->input->get("nofaktur");
        $ship_product_id = $this->input->get("ship_product_id");
        $this->M_purchase_inv_factory->delete_item($id);
        $this->M_purchase_inv_factory->delete_jurnal($idj);
        $this->M_purchase_inv_factory->update_mar_tbl_trn_shipping_intruction_dtl($nofaktur, $ship_product_id, 0);
        redirect("Purchase_inv_factory/edit?id=$nofaktur");
    }

    function cek_tabel_ar() {
        $id = $this->input->get("id");
        $data['select_hutang'] = $this->M_purchase_inv_factory->nota($id);
        $this->load->view('accounting/validasi', $data);
    }

    function hapus() {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_purchase_inv_factory->delete_jurnal($id);
        redirect("Purchase_inv_factory/edit?id=$nofaktur");
    }

    function delete_transaction() {
        $id = $this->input->get("id");
        $this->M_purchase_inv_factory->delete_hutang($id);
        redirect("Purchase_inv_factory");
    }

    public function ambil_currency(){

        $data['currency']= $this->M_purchase_inv_factory->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
        $this->load->view('accounting/ajax/get_currency', $data);
    }

    public function accounting_rate(){
        $date1=date('Y/m/d',strtotime($this->convert($this->input->get('date'))));
        $lastdate= date('Y/m/01',strtotime($this->convert($this->input->get('date'))));
        
        if($date1==$lastdate){
            $data['date'] = date('Y/m', strtotime("+2 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate'] = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
            $data['rate']= $this->M_purchase_inv_factory->tampil_po_rate($this->input->get('cur'),$this->convert($this->input->get('date')));
            $this->load->view('accounting/acc_filter_rate',$data);
        }
        else {
            $data['date'] = date('Y/m', strtotime("+1 days", strtotime($this->convert($this->input->get('date')))));
            $data['newdate'] = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
            $data['rate'] = $this->M_purchase_inv_factory->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
            $this->load->view('accounting/acc_filter_rate', $data);
        }
    }

    public function convert($date){
        $explode=explode("/", $date);

        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];

        return $time;
    }

    // ################################################################################
    // ################################################################################
    //
    // ########## Select Back Recorded Purchase Invoice Vendor ##########

    function selectInvoiceFactory(){
        $data   = array(
            '_selectHeader' => $this->M_purchase_inv_factory->selectInvoiceforFindIF()->result()
        );
        $this->load->view('accounting/Purchase_inv_factory/FindIF/selectIF',$data);
    }
}
