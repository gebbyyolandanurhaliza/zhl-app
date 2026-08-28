
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AP_invoice extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('M_AP_invoice');
        $this->load->library(array('template', 'user_agent', 'fpdf'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['title'] = "List of Payable Recognition";
        $data['List_ap_invoice'] = $this->M_AP_invoice->get_list_ap();
        $this->template->display('accounting/AP_invoice/AP_invoice_list', $data);
    }

    function add_new() {
        $sup = $this->input->get('sup');
        $Currency = $this->input->get('cur');
        $data['SupplierID'] = $this->M_AP_invoice->get_supplier();
        $data['Currency'] = $this->M_AP_invoice->get_currency();

        //if ($sup <> '' || $rate <> ''){
        $data['get_data_journal'] = $this->M_AP_invoice->get_data_journal($sup, $Currency);
        //}
        //

        $this->template->display('accounting/AP_invoice/AP_invoice_form', $data);
    }

    function edit() {
        $data['SupplierID'] = $this->M_AP_invoice->get_supplier();
        $data['Currency'] = $this->M_AP_invoice->get_currency();
        $data['CurrencyID'] = $this->M_AP_invoice->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");
        $sup = $this->input->get('sup');
        $Currency = $this->input->get('cur');

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['nota'] = $this->M_AP_invoice->nota($id);
        $data['get_data_header'] = $this->M_AP_invoice->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_AP_invoice->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_AP_invoice->get_data_footer($id);
        $data['get_data_journal'] = $this->M_AP_invoice->get_data_journal($sup, $Currency);

        $this->template->display('accounting/AP_invoice/AP_invoice_form', $data);
    }

    function print_report() {
        $data['SupplierID'] = $this->M_AP_invoice->get_supplier();
        $data['Currency'] = $this->M_AP_invoice->get_currency();
        $data['CurrencyID'] = $this->M_AP_invoice->get_currency_detail();
        //cari nota debet, berdasarkan total seluruh transaksi "Bayar"
        $id = $this->input->get("id");

        //variable invoice number header
        $data['HeaderID'] = $id;
        $data['titel'] = 'Payable Recognition';
        $data['nota'] = $this->M_AP_invoice->nota($id);
        $data['get_data_header'] = $this->M_AP_invoice->get_data_header($id);
        //variable invoice number detail
        $data['get_data_detail'] = $this->M_AP_invoice->get_data_detail($id);
        //variable invoice number footer
        $data['get_data_footer'] = $this->M_AP_invoice->get_data_footer($id);

        $this->load->view('accounting/rpt/rpt_AP_invoice', $data);
    }

    function list_currency() {
        $data['Currency'] = $this->M_AP_invoice->get_currency_detail();
        $this->load->view('accounting/list_currency', $data);
    }

    function get_currency_date() {
        $sekarang = date($this->uri->segment(3));
        $data['Currency'] = $this->M_AP_invoice->get_currency_date($sekarang);
        $this->load->view('accounting/list_currency_date', $data);
    }

    function list_payable() {
        $id = $this->input->get("id");

        //variable invoice number header
        $this->M_AP_invoice->get_data_header($id);
    }

    function cek_tabel() {
        $id = $this->input->get('id');
        $data['select_hutang'] = $this->M_AP_invoice->select_APPayment($id);
        $this->load->view('accounting/validasi', $data);
    }

    function save_ap_invoice() {
        $nofaktur = $this->input->post('nofaktur');
        $supplier = $this->input->post('supplier');
        $tgl_jurnal = new DateTime($this->input->post('tanggal'));
        $tanggal = date_format($tgl_jurnal, "Y-m-d");
        $remark = $this->input->post('remark');
        $symbol_currency = $this->input->post('Currency');
        $DetailID = $this->input->post('DetailID');
        $rate_header = $this->input->post('rate_header');

        //array
        $noivoice = $this->input->post('noivoice');
        $rate = $this->input->post('rate');
        $bayar = str_replace(',', '', $this->input->post('bayar'));
        $tombol = $this->input->post('sbt');

        if ($tombol == 'Save') {
            $data_header = array(
                'NomorAP' => $nofaktur,
                'Tanggal' => $tanggal,
                'SupplierID' => $supplier,
                'CurrencyID' => $symbol_currency,
                'rate_header' => $rate_header,
                'Remarks' => $remark,
                'created_by' => $this->session->userdata('userid_1'),
                'created_date' => date('Y-m-d H:i:s')
            );
            $this->M_AP_invoice->simpan_header($data_header);
            for ($i = 0; $i < count($this->input->post('noivoice')); $i++) {
                $data_detail = array(
                    'NomorAP' => $nofaktur,
                    'NoInvoice' => $noivoice[$i],
                    'Rate' => $rate[$i],
                    'Total' => $bayar[$i],
                    'created_by' => $this->session->userdata('userid_1'),
                    'created_date' => date('Y-m-d H:i:s')
                );
                $this->M_AP_invoice->simpan_detail($data_detail);
            }
        } else {
            $data_header1 = array(
                'Tanggal' => $tanggal,
                'Remarks' => $remark,
                'rate_header' => $rate_header,
                'updated_by' => $this->session->userdata('userid_1'),
                'updated_date' => date('Y-m-d H:i:s')
            );
            $this->M_AP_invoice->update_header($nofaktur, $data_header1);
            if ($DetailID == 0) {
                for ($i = 0; $i < count($this->input->post('noivoice')); $i++) {
                    $data_detailz = array(
                        'NomorAP' => $nofaktur,
                        'NoInvoice' => $noivoice[$i],
                        'Rate' => $rate[$i],
                        'Total' => $bayar[$i],
                        'created_by' => $this->session->userdata('userid_1'),
                        'created_date' => date('Y-m-d H:i:s')
                    );
                    $this->M_AP_invoice->simpan_detail($data_detailz);
                }
            } else {
                for ($Z = 0; $Z < count($this->input->post('noivoice')); $Z++) {
                    $data_detailx = array(
                        'Total' => $bayar[$Z],
                        'updated_by' => $this->session->userdata('userid_1'),
                        'updated_date' => date('Y-m-d H:i:s')
                    );
                    $this->M_AP_invoice->update_detail($DetailID[$Z], $data_detailx);
                }
            }
        }
        redirect("AP_invoice/edit?id=$nofaktur&sup=$supplier&cur=$symbol_currency");
    }

    function delete() {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_AP_invoice->delete_item($id);
        redirect("AP_invoice/edit?id=$nofaktur");
    }

    function hapus() {
        $id = $this->input->get("id");
        $nofaktur = $this->input->get("nofaktur");
        $this->M_AP_invoice->delete_jurnal($id);
        redirect("AP_invoice/edit?id=$nofaktur");
    }

    function delete_transaction() {
        $id = $this->input->get("id");
        $this->M_AP_invoice->delete_all($id);
        redirect("AP_invoice");
    }

}
