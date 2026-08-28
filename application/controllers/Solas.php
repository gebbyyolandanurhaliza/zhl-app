<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Solas extends My_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_shipping', 'm_shipping_mon', 'm_shipping_inv'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library(array('Fpdf', 'PHPExcel'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index()
    {
        $data['factory'] = $this->m_shipping->tampil_factory_stock_container();


        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die;


        $this->template->display('shipping/Solas/solas_mon', $data);
    }


    function SearchDataSolas()
    {
        $fac  = $this->input->get('factory_tipe');
        $tgl1 = date('Y-m-d', strtotime($this->input->get('dari')));
        $tgl2 = date('Y-m-d', strtotime($this->input->get('sampai')));

        if ($fac == 'RSUP') {
            $data['_dataparse'] = $this->get_curl($this->url_rsup . 'Solas/GetDataSolas?tgl1=' . $tgl1 . '&tgl2=' . $tgl2);
            $this->load->view('shipping/Solas/Solas_parse_data_view_rsup', $data);
        } else if ($fac == 'PSG') {
            $data['_dataparse'] = $this->get_curl($this->url_psg . 'Solas/GetDataSolas?tgl1=' . $tgl1 . '&tgl2=' . $tgl2);
            $this->load->view('shipping/Solas/Solas_parse_data_view_psg', $data);
        } else {
            $data['_dataparse'] = '';
            $this->load->view('shipping/Solas/Solas_parse_data_view_rsup', $data);
        }
    }


    function PrintSolas()
    {
        $Id   = $this->input->get('Id');
        $fac  = $this->input->get('Fac');

        if ($fac == 'RSUP') {
            $data['HdrDtl'] = $this->get_curl($this->url_rsup . 'Solas/GetDataSolasById?id=' . $Id);
            $this->template->display('shipping/Solas/test_hdr_dtl_rsup', $data);
        } else if ($fac == 'PSG') {
            $data['HdrDtl'] = $this->get_curl($this->url_psg . 'Solas/GetDataSolasById?id=' . $Id);
            $this->template->display('shipping/Solas/test_hdr_dtl_psg', $data);
        } else {
            $data['HdrDtl'] = '';
        }
    }

    function PrintSolasPDF()
    {
        $Id   = $this->input->get('Id');
        $fac  = $this->input->get('Fac');

        if ($fac == 'RSUP') {
            $data['HdrDtl'] = $this->get_curl($this->url_rsup . 'Solas/GetDataSolasById?id=' . $Id);
            $this->load->view('shipping/Solas/solas_pdf_rsup', $data);
        } else if ($fac == 'PSG') {
            $data['HdrDtl'] = $this->get_curl($this->url_psg . 'Solas/GetDataSolasById?id=' . $Id);
            $this->load->view('shipping/Solas/solas_pdf_psg', $data);
        } else {
            $data['HdrDtl'] = '';
        }
    }
}
