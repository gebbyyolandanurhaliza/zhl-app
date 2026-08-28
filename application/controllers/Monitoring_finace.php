<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Monitoring_finace extends CI_Controller{
        public function __construct() {
            parent::__construct();
            
            if(!$this->session->userdata('userid_1')){
                redirect('login');
            }
            $this->load->library('PHPExcel');
            date_default_timezone_set("Asia/Jakarta");
            $this->load->model(array('M_Fin_Report','M_Receivable_aging'));
        }

        function index(){
            $data['_coacash'] = $this->M_Fin_Report->get_coacash();
            $data['_CurrencyID'] = $this->M_Receivable_aging->get_currency();

            $this->template->display('finance/report/monitoring/monitoring_registerbook', $data);
        }

        function search(){
            $data['_coacash']       = $this->M_Fin_Report->get_coacash();
            $data['_CurrencyID']    = $this->M_Receivable_aging->get_currency();

            $dari = '';
            $dari                   = ($this->input->get('dari') === TRUE ? '2016-01-01' : date('Y-m-d', strtotime($this->input->get('dari'))));
            $sampai                 = ($this->input->get('sampai') === TRUE ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->get('sampai'))));
            $coa                    = ($this->input->get('coa') ? $this->input->get('coa') : '140801');

            /*$dari                   = date('Y-m-d', strtotime('01-01-2016'));
            $sampai                 = date('Y-m-d');
            $coa                    = '140901';
            $cur                    = $this->input->get('cur');*/

            $data['_tampil']        = $this->M_Fin_Report->hasil($dari, $sampai, $coa);
            $data['_test']          = $dari;

            $this->template->display('finance/report/monitoring/monitoring_registerbook', $data);

        }

        function cash_balance(){
            $this->template->display('finance/report/monitoring/monitoring_cashbalance');
        }

        function search_cb(){
            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');

            // $data = $this->input->get('get_cashbalance');
            $data['_tampil'] = $this->M_Fin_Report->get_cashbalance($dari , $sampai);
            $this->template->display('finance/report/monitoring/monitoring_cashbalance', $data);
        }

        function daily(){
            $data['_coacash'] = $this->M_Fin_Report->get_coacash();
            $data['_CurrencyID'] = $this->M_Receivable_aging->get_currency();
            $this->template->display('finance/report/monitoring/monitoring_daily', $data);
        }

        function daily_search(){
            $data['_coacash'] = $this->M_Fin_Report->get_coacash();
            $data['_CurrencyID'] = $this->M_Receivable_aging->get_currency();
            
            $coa = $this->input->get('coa');
            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');
            $cur = $this->input->get('cur');

            $data['_begining'] = $this->M_Fin_Report->get_coaca($coa);
            $data['_begin'] = $this->M_Fin_Report->hitung_dailybegin($dari, $coa);
            $data['_tampil'] = $this->M_Fin_Report->get_daily($dari, $sampai, $coa);
            $this->template->display('finance/report/monitoring/monitoring_daily', $data);   
        }

        function downpayment(){
            // $data['_coacash'] = $this->M_Fin_Report->get_coacash();
            $this->template->display('finance/report/monitoring/monitoring_dp');
        }

        function downpayment_search(){
            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');
            $data['_hasil'] = $this->M_Fin_Report->get_dp($dari, $sampai);
            $this->template->display('finance/report/monitoring/monitoring_dp', $data);   
        }

        function ap_payment(){
        	$data['SupplierID'] = $this->M_Fin_Report->get_supplier();

            $this->template->display('finance/report/monitoring/monitoring_account_payable',$data);
        }

        function ar_payment(){
        	
            $this->template->display('finance/report/monitoring/monitoring_account_payable');
        }

        function ap_payment_search(){
        	$dari = date('Y-m-d', strtotime($this->input->get('dari')));
            $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));
            $sup = $this->input->get('sup');

        	$data['SupplierID'] = $this->M_Fin_Report->get_supplier();
        	$data['TampilData'] = $this->M_Fin_Report->get_appayment($dari,$sampai,$sup);
            $this->template->display('finance/report/monitoring/monitoring_account_payable',$data);
        }

        function toExcelDownPayment(){

            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            date_default_timezone_set('Europe/London');

            $dari   = $this->input->get('dari');
            $sampai = $this->input->get('sampai');


            $data = $this->M_Fin_Report->get_dp($dari, $sampai);
            if (PHP_SAPI == 'cli')
                die('This example should only be run from a Web Browser');
            // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

            //set aligment header row
            $objPHPExcel->getActiveSheet()->getstyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            //set font bold header row
            $objPHPExcel->getActiveSheet()->getstyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('B3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('C3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('D3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('E3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('F3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('G3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('H3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('I3')->getFont()->setBold(true);



            $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

            $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'ID')
                ->setCellValue('C3', 'Supplier / Customer')
                ->setCellValue('D3', 'Reff. No')
                ->setCellValue('E3', 'Date')
                ->setCellValue('F3', 'Currency')
                ->setCellValue('G3', 'Amount')
                ->setCellValue('H3', 'Rate')
                ->setCellValue('I3', 'USD Equivalent')

            ;

            $no = 1;
            $counter = 4;
            $total_usd_equivalent=0;
            foreach ($data as $v):

                $total_usd_equivalent+=$v->uang_muka*$v->currency_rate;
                $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->supp_code)
                    ->setCellValue('C' . $counter, $v->cust_supp_name)
                    ->setCellValue('D' . $counter, $v->no_reff)
                    ->setCellValue('E' . $counter, $v->date)
                    ->setCellValue('F' . $counter, $v->currency_id)
                    ->setCellValue('G' . $counter, number_format($v->uang_muka, 2 , '.',','))
                    ->setCellValue('H' . $counter, number_format($v->currency_rate, 2 , '.',','))
                    ->setCellValue('I' . $counter, number_format($v->uang_muka*$v->currency_rate, 2 , '.',','));



                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );

                $objPHPExcel->getActiveSheet()->getStyle('A3:I' . ($jlh+1))->applyFromArray($styleArray);
                $counter++;
            endforeach;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E' . $counter, 'TOTAL')
                ->setCellValue('F' . $counter, 'USD')
                ->setCellValue('I' . $counter, number_format($total_usd_equivalent, 2, '.', ','));


            $objPHPExcel->getActiveSheet()->setTitle('Down Payment');
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Down_Payment.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }

        function toExcelCashBalance(){

            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            date_default_timezone_set('Europe/London');

            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');

            // $data = $this->input->get('get_cashbalance');
            $data= $this->M_Fin_Report->get_cashbalance($dari , $sampai);
            if (PHP_SAPI == 'cli')
                die('This example should only be run from a Web Browser');
            // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            //set aligment header row
            $objPHPExcel->getActiveSheet()->getstyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


            //set font bold header row
            $objPHPExcel->getActiveSheet()->getstyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('B3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('C3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('D3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('E3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('F3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('G3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('H3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('I3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle('J3')->getFont()->setBold(true);



            $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

            $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Name')
                ->setCellValue('B3', 'Account')
                ->setCellValue('C3', 'Amount (USD)')
                ->setCellValue('D3', 'Pending Cash')
                ->setCellValue('E3', 'NET')
                ->setCellValue('F3', 'Amount (OTHER CUR)')
                ->setCellValue('G3', 'Pending Cash')
                ->setCellValue('H3', 'NET (OTHER CUR)')
                ->setCellValue('I3', 'Total USD Equivalent')
                ->setCellValue('J3', 'Average Rate')

            ;

            $no = 1;
            $counter = 4;
            $totalusd = 0;
            $totalusdnet = 0;
            $totalcur = 0;
            $totalcurnet = 0;
            $totalsel = 0;
            foreach ($data as $r):

                $totalusd += $r->jumlah_usd;
                $totalusdnet += $r->jumlah_usd;
                $totalcur += $r->jumlah_notusd;
                $totalcurnet += $r->jumlah_notusd;

                $total = $r->jumlah_usd + $r->jumlah_notusd;
                $totalsel += $total;
                $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $r->AccountName)
                    ->setCellValue('B' . $counter, $r->no_coa)
                    ->setCellValue('C' . $counter, number_format($r->jumlah_usd, 2, '.',','))
                    ->setCellValue('D' . $counter, '')
                    ->setCellValue('E' . $counter, number_format($r->jumlah_usd, 2, '.',','))
                    ->setCellValue('F' . $counter, number_format($r->jumlah_notusd, 2, '.',','))
                    ->setCellValue('G' . $counter,'')
                    ->setCellValue('H' . $counter,number_format($r->jumlah_notusd, 2, '.',','))
                    ->setCellValue('I' . $counter,number_format($total, 2, '.',','))
                    ->setCellValue('J' . $counter,number_format($r->average_rate, 2, '.',','));


                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );

                $objPHPExcel->getActiveSheet()->getStyle('A3:J' . ($jlh+1))->applyFromArray($styleArray);
                $counter++;
            endforeach;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, 'GRAND TOTAL')
                ->setCellValue('C' . $counter, number_format($totalusd, 2, '.', ','))
                ->setCellValue('E' . $counter, number_format($totalusdnet, 2, '.', ','))
                ->setCellValue('F' . $counter, number_format($totalcur, 2, '.', ','))
                ->setCellValue('H' . $counter, number_format($totalcurnet, 2, '.', ','))
                ->setCellValue('I' . $counter, number_format($totalsel, 2, '.', ','))
                ;



            $objPHPExcel->getActiveSheet()->setTitle('Cash Balance');
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Cash_Balance.xlsx"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }


        function toPrintDownPayment(){

            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');
            $data['_hasil'] = $this->M_Fin_Report->get_dp($dari, $sampai);


            $this->load->view('finance/report/rpt_down_payment', $data);
        }

        function toPrintCashBalance(){
            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');

            // $data = $this->input->get('get_cashbalance');
            $data['_tampil'] = $this->M_Fin_Report->get_cashbalance($dari , $sampai);
            $this->template->display('finance/report/rpt_cash_balance', $data);
        }

        function toPrintRegisterBook(){

            $data['_coacash']       = $this->M_Fin_Report->get_coacash();
            $data['_CurrencyID']    = $this->M_Receivable_aging->get_currency();

            $dari = '';
            $dari                   = ($this->input->get('dari') === TRUE ? '2016-01-01' : date('Y-m-d', strtotime($this->input->get('dari'))));
            $sampai                 = ($this->input->get('sampai') === TRUE ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->get('sampai'))));
            $coa                    = ($this->input->get('coa') ? $this->input->get('coa') : '140801');

            /*$dari                   = date('Y-m-d', strtotime('01-01-2016'));
            $sampai                 = date('Y-m-d');
            $coa                    = '140901';
            $cur                    = $this->input->get('cur');*/

            $data['_tampil']        = $this->M_Fin_Report->hasil($dari, $sampai, $coa);
            $data['_test']          = $dari;

            $this->template->display('finance/report/rpt_register_book', $data);


        }

	function print_report() {
            $coa = $this->input->get('coa');
            $dari = $this->input->get('dari');
            $sampai = $this->input->get('sampai');
            $cur = $this->input->get('cur');

            $data['_begining'] = $this->M_Fin_Report->get_coaca($coa);
            $data['_begin'] = $this->M_Fin_Report->hitung_dailybegin($coa, $coa);
            $data['_tampil'] = $this->M_Fin_Report->get_daily($dari, $sampai, $coa);
        $this->load->view('accounting/rpt/rpt_monitoring_daily', $data);
    }
    }
?>