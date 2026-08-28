<?php

/**
 * Created by PhpStorm.
 * User: rezai
 * Date: 4/17/2017
 * Time: 1:35 PM
 */
class Kas_Kecil extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Mst_Rekening','M_Kas_Kecil'));
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->helper('terbilang_helper');

    }


    public function index()
    {

        $this->template->display('kas_kecil/Transaksi/index');
    }

    /*function setoran(){
        $this->load->view('kas_kecil/Transaksi/ajax/tes');
    }*/
    function pencairan(){
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $this->load->view('kas_kecil/Transaksi/pencairan',$data);
    }

    function setoran(){
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $this->load->view('kas_kecil/Transaksi/setoran',$data);
    }

    function transfer(){
        $data['_selectCurrency']    = $this->db->get('gen_tbl_mst_currency')->result();
        $this->load->view('kas_kecil/Transaksi/transfer',$data);
    }

    function insertTransaksiSetoran(){
        $data   = array(
            'IDTrans'           => $this->input->post('txtNoTrans'),
            'IDType'        => 'STR',
            'Tanggal'             => date('Y-m-d', strtotime($this->input->post('txtTanggal'))),
            'NoRek'     => $this->input->post('txtNomorRek'),
            'Currency'        => $this->input->post('txtCurr'),
            'Currency_Rate'           => $this->input->post('txtRateIDR'),
            'Amount' => $this->input->post('txtSetoran'),
            'Keterangan'           => $this->input->post('txtKeterangan'),
            'INOUT'           => $this->input->post('txtIO'),
            'CreatedBy'        => $this->session->userdata('userid_1'),
            'CreatedDate'      => date('Y-m-d H:i:s'),
            'IPAddress' =>$this->input->post('IPAddress'),
            'Terbilang'=>$this->input->post('txtTerbilang'),
            'NoCek'=>$this->input->post('txtCekBank')
        );
         $this->M_Kas_Kecil->insertTransaksiSetoran($data);


    }

    function insertTransaksiPencairan(){
        $data   = array(
            'IDTrans'           => $this->input->post('txtNoTrans'),
            'IDType'        => 'PNC',
            'Tanggal'             => date('Y-m-d', strtotime($this->input->post('txtTanggal'))),
            'NoRek'     => $this->input->post('txtNomorRek'),
            'Currency'        => $this->input->post('txtCurr'),
            'Currency_Rate'           => $this->input->post('txtRateIDR'),
            'Amount' => $this->input->post('txtPencairan'),
            'Keterangan'           => $this->input->post('txtKeterangan'),
            'INOUT'           => $this->input->post('txtIO'),
            'CreatedBy'        => $this->session->userdata('userid_1'),
            'CreatedDate'      => date('Y-m-d H:i:s'),
            'IPAddress' =>$this->input->post('IPAddress'),
            'Terbilang'=>$this->input->post('txtTerbilang'),
            'NoCek'=>$this->input->post('txtCekBank')
        );
        $this->M_Kas_Kecil->insertTransaksiPencairan($data);


    }

    function insertTransaksiTransfer(){
        $data   = array(
            'IDTrans'           => $this->input->post('txtNoTrans'),
            'IDType'        => 'TRF',
            'Tanggal'             => date('Y-m-d', strtotime($this->input->post('txtTanggal'))),
            'NoRek'     => $this->input->post('txtNomorRek1'),
            'Currency'        => $this->input->post('txtCurr'),
            'Currency_Rate'           => $this->input->post('txtRateIDR'),
            'Amount' => $this->input->post('txtTransfer'),
            'Keterangan'           => $this->input->post('txtKeterangan'),
            'INOUT'           => $this->input->post('txtIO1'),
            'CreatedBy'        => $this->session->userdata('userid_1'),
            'CreatedDate'      => date('Y-m-d H:i:s'),
            'IPAddress' =>$this->input->post('IPAddress'),
            'Terbilang'=>$this->input->post('txtTerbilang')
        );
        $data2   = array(
            'IDTrans'           => $this->input->post('txtNoTrans'),
            'IDType'        => 'TRF',
            'Tanggal'             => date('Y-m-d', strtotime($this->input->post('txtTanggal'))),
            'NoRek'     => $this->input->post('txtNomorRek2'),
            'Currency'        => $this->input->post('txtCurr'),
            'Currency_Rate'           => $this->input->post('txtRateIDR'),
            'Amount' => $this->input->post('txtTransfer'),
            'Keterangan'           => $this->input->post('txtKeterangan'),
            'INOUT'           => $this->input->post('txtIO2'),
            'CreatedBy'        => $this->session->userdata('userid_1'),
            'CreatedDate'      => date('Y-m-d H:i:s'),
            'IPAddress' =>$this->input->post('IPAddress'),
            'Terbilang'=>$this->input->post('txtTerbilang')
        );
        $this->M_Kas_Kecil->insertTransaksiTransfer($data);
        $this->M_Kas_Kecil->insertTransaksiTransfer($data2);


    }

    function listRekening(){

        $data['_selectHeader'] = $this->M_Mst_Rekening->select_rekening();

        $this->load->view('kas_kecil/Transaksi/ajax/listRekening',$data);
    }

    function listRekening2(){

        $data['_selectHeader'] = $this->M_Mst_Rekening->select_rekening();

        $this->load->view('kas_kecil/Transaksi/ajax/listRekening2',$data);
    }

    function List_Record_Setoran()
    {

        $data['Record_setoran']=$this->M_Kas_Kecil->r_setoran();
        $this->template->display('kas_kecil/Record/list_record_setoran',$data);

    }

    function Record_Setoran(){
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);
        $this->template->display('kas_kecil/Record/record_setoran',$data);
    }

    function Record_Pencairan(){
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);
        $this->template->display('kas_kecil/Record/record_pencairan',$data);
    }

    function Record_Transfer(){
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);
        $this->template->display('kas_kecil/Record/record_transfer',$data);
    }

    function List_Record_Pencairan()
    {

        $data['Record_setoran']=$this->M_Kas_Kecil->r_pencairan();
        $this->template->display('kas_kecil/Record/list_record_pencairan',$data);

    }
    function List_Record_Transfer()
    {

        $data['Record_transfer']=$this->M_Kas_Kecil->r_transfer();
        $this->template->display('kas_kecil/Record/list_record_transfer',$data);

    }

    function Buku_Rekening(){
        $this->template->display('kas_kecil/monitoring/account_book');
    }

    function search() {
        $rek = $this->input->get('NomorRek');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));

        $data['Get_record']  = $this->M_Kas_Kecil->call_data($rek,$from,$to);

        $this->template->display('kas_kecil/monitoring/account_book',$data);
    }

    function print_setoran_bni() {
       /* $id = $this->input->get('id');
        $data['get_header'] = $this->M_General_Journal->get_header($id);
        $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
        $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_setoran',$data);
    }

    function print_transfer_maybank() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_transfer',$data);
    }

    function print_setoran_maybank() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_setoran_maybank',$data);
    }

    function print_bb_pengeluaran_pske() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_bbPengeluaran_pske',$data);
    }

    function print_bb_penerimaan_pske() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_bbPenerimaan_pske',$data);
    }

    function print_bb_perimaan_psj() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_bbPenerimaan_psj',$data);
    }
    function print_bk_pengeluaran_psj() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_bkPengeluaran_psj',$data);
    }
    function print_bk_penerimaan_psj() {
        /* $id = $this->input->get('id');
         $data['get_header'] = $this->M_General_Journal->get_header($id);
         $data['get_jurnal'] = $this->M_General_Journal->get_jurnal($id);
         $data['List_coa'] = $this->M_vcdn->get_coa();*/
        $id = $this->input->get("id");
        $data['HeaderID'] = $id;
        $data['get_record']=$this->M_Kas_Kecil->get_record($id);

        $this->load->view('kas_kecil/Print/rpt_bkPenerimaan_psj',$data);
    }
}