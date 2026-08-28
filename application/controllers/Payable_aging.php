
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payable_aging extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Payable_aging'));
        $this->load->library(array('user_agent','Excelen/PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $companyid = $this->session->userdata('company_id');
        if ($companyid == 2) {
            $data['SupplierID'] = $this->M_Payable_aging->get_supplier_zht();
        }else{
            $data['SupplierID'] = $this->M_Payable_aging->get_supplier();
        }
        $data['CurrencyID'] = $this->M_Payable_aging->get_currency();

        $this->template->display('accounting/Laporan/payable_aging', $data);
    }

    function search() {
        $sup        = $this->input->get('supplier');
        $periode    = date('Y-m-d', strtotime($this->input->get('period')));
        $curreny    = $this->input->get('currency');
        $companyid  = $this->session->userdata('company_id');

        
        $data['CurrencyID']      = $this->M_Payable_aging->get_currency();
        if ($companyid == 2) {
            $data['SupplierID']      = $this->M_Payable_aging->get_supplier_zht();
            $data['GroupSupplierID'] = $this->M_Payable_aging->get_group_supp_zht($periode, $sup,$curreny);
            $data['Get_aging']       = $this->M_Payable_aging->call_data_aging_zht($sup, $curreny, $periode);
        }else{
            $data['SupplierID']      = $this->M_Payable_aging->get_supplier();
            $data['GroupSupplierID'] = $this->M_Payable_aging->get_group_supp($periode, $sup,$curreny);
            $data['Get_aging']       = $this->M_Payable_aging->call_data_aging($sup, $curreny, $periode);
        }
       

        $this->template->display('accounting/Laporan/payable_aging', $data);
    }

    function toExcel(){
        $this->load->library("Excel/PHPExcel");

        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        // $sampai = $this->input->get('sampai') . "-" . date("d");
        $currency = $this->input->get('currency');

        $title = 'Payable Aging';

        //$data = $this->M_Payable_aging->call_data_aging($sup, $curreny, $dari, $sampai);
        
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);


        //$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        //$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $title)

                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'supplier')
                ->setCellValue('C3', 'Inv. Date')
                ->setCellValue('D3', 'Invoice Number')
                ->setCellValue('E3', 'Due Date')
                ->setCellValue('F3', 'Not Due Date')
                ->setCellValue('G3', '0 - 30 Days')
                ->setCellValue('H3', '31 - 60 Days')
                ->setCellValue('I3', '61 - 90 Days')
                ->setCellValue('J3', '91 - 120 Days')
                ->setCellValue('K3', '120 - Days')
                ->setCellValue('L3', 'Total');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 1;


        $data = $this->M_Payable_aging->call_data_aging($sup, $currency, $periode);
        foreach($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->tmp_supplier_name);
            $ex->setCellValue('C'.$counter, $row->tmp_inv_date);
            $ex->setCellValue('D'.$counter, $row->tmp_invno);
            $ex->setCellValue('E'.$counter, $row->tmp_due_date);
            $ex->setCellValue('F'.$counter, $row->tmp_not_due_date);
            $ex->setCellValue('G'.$counter, $row->tmp_0sd30);
            $ex->setCellValue('H'.$counter, $row->tmp_31sd60);
            $ex->setCellValue('I'.$counter, $row->tmp_61sd90);
            $ex->setCellValue('J'.$counter, $row->tmp_91sd120);
            $ex->setCellValue('K'.$counter, $row->tmp_more120);
            $ex->setCellValue('L'.$counter, $row->tmp_more120);

            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Payable Aging');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Aging.xlsx"');
        
        $objWriter->save('php://output');
    }

     function print_report() {
        $sup     = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        // $sampai = $this->input->get('sampai') . "-" . date("d");
        $currency = $this->input->get('currency');
        $title    = 'Payable Aging';

        //$data['SupplierID'] = $this->M_Payable_aging->get_supplier();
        
        $companyid  = $this->session->userdata('company_id');
        $data['CurrencyID'] = $this->M_Payable_aging->get_currency();
        $data['HeaderID']   = '1';
        $data['titel']      = 'Monitoring Payable Aging';
        $data['periode']    = $periode;
        if ($companyid == 2) {
            $data['Get_aging']  = $this->M_Payable_aging->call_data_aging_zht($sup, $currency, $periode);
            $data['get_data_detail']= $this->M_Payable_aging->call_data_aging_zht($sup, $currency, $periode);
            $data['GroupSupplier'] = $this->M_Payable_aging->get_group_supp_zht($periode, $sup ,$currency);
        }else{
            $data['Get_aging']  = $this->M_Payable_aging->call_data_aging($sup, $currency, $periode);
            $data['get_data_detail']= $this->M_Payable_aging->call_data_aging($sup, $currency, $periode);
            $data['GroupSupplier'] = $this->M_Payable_aging->get_group_supp($periode, $sup ,$currency);
        }
        
        $this->load->view('accounting/rpt/rpt_payable_aging', $data);
    }


    function print_report2() {
        $sup     = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        // $sampai = $this->input->get('sampai') . "-" . date("d");
        $currency = $this->input->get('currency');
        $title    = 'Payable Aging';
        $companyid  = $this->session->userdata('company_id');

        //$data['SupplierID'] = $this->M_Payable_aging->get_supplier();

        $data['CurrencyID'] = $this->M_Payable_aging->get_currency();

        $data['HeaderID'] = '1';
        $data['titel']    = 'Monitoring Payable Aging';
        $data['periode']  = $periode;
        
        if ($companyid == 2) {
            $data['Get_aging']  = $this->M_Payable_aging->call_data_aging_zht($sup, $currency, $periode);
            $data['get_data_detail']= $this->M_Payable_aging->call_data_aging_zht($sup, $currency, $periode);
            $data['GroupSupplier'] = $this->M_Payable_aging->get_group_supp_zht($periode, $sup ,$currency);
        }else{
            $data['Get_aging']  = $this->M_Payable_aging->call_data_aging($sup, $currency, $periode);
            $data['get_data_detail'] = $this->M_Payable_aging->call_data_aging($sup, $currency, $periode);
            $data['GroupSupplier'] = $this->M_Payable_aging->get_group_supp($periode, $sup ,$currency);
        }

        $this->load->view('accounting/rpt/rpt_payable_aging_post', $data);
    }

}
