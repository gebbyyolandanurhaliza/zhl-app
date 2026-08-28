
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payable_statement extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Payable_statement'));
        $this->load->library(array('user_agent', 'Template','PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {
        $data['SupplierID'] = $this->M_Payable_statement->get_supplier();
        $data['CurrencyID'] = $this->M_Payable_statement->get_currency();
        $this->template->display('accounting/Laporan/payable_statement', $data);
    }

    function search() {
        $sup     = $this->input->get('supplier');       
        $curreny = $this->input->get('currency');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        
        $data['SupplierID'] = $this->M_Payable_statement->get_supplier($sup);
        $data['CurrencyID'] = $this->M_Payable_statement->get_currency();
        $data['get_customer'] = $this->M_Payable_statement->call_data_ps($sup, $curreny, $periode);
        $data['get_agings'] = $this->M_Payable_statement->call_data_agings($sup, $curreny, $periode);

        $this->template->display('accounting/Laporan/payable_statement', $data);
    }
    
    function print_report() {
        $sup     = $this->input->get('supplier');       
        $curreny = $this->input->get('currency');
        //$curreny = $this->input->get('currency');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        
        $data['SupplierID'] = $this->M_Payable_statement->get_data_supplier($sup);
        $data['CurrencyID'] = $this->M_Payable_statement->get_currency();
        $data['get_agings'] = $this->M_Payable_statement->call_data_agings($sup, $curreny, $periode);


        $this->load->view('accounting/rpt/rpt_payable_statement', $data);
    }


    function toExcel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $SupplierID = $this->M_Payable_statement->get_data_supplier($sup);
        $CurrencyID = $this->M_Payable_statement->get_currency();
        $id = $this->input->get("id");
        $curreny = $this->input->get('currency');

         $tgl = $this->input->get("period");
        $periode = date('Y-m-d', strtotime($tgl));

        $str=explode("-",$periode);
        $thn=$str[0];
        $bulan=$str[1];


        //variable invoice number header
        $dataHeader = $id;

        $title           = 'Payable Statement Of Account';
        $get_data_header = $this->M_Payable_statement->get_data_header($id);
        //variable invoice number detail
        $get_data_detail = $this->M_Payable_statement->get_mutation($sup, $curreny, $thn, $bulan);
        $get_total       = $this->M_Payable_statement->get_total($sup, $curreny, $thn, $bulan);
        //variable invoice number footer
        $get_agings      = $this->M_Payable_statement->call_data_agings($sup, $curreny, $periode);



        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A3:A4")->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("B3:B4")->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("C3:C4")->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("D3:D4")->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->mergeCells("E3:E4")->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("F3:F4")->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("G3:G4")->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("H3:H4")->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("I3:I4")->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("J3:J4")->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("K3:K4")->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("L3:L4")->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("M3:M4")->getColumnDimension('M')->setWidth(20);

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
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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
        $objPHPExcel->getActiveSheet()->getstyle('K3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('L3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('M3')->getFont()->setBold(true);



        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No Invoice')
            ->setCellValue('B3', 'Invoice Date')
            ->setCellValue('C3', 'Due Date')
            ->setCellValue('D3', 'Currency')
            ->setCellValue('E3', 'Amount')
            ->setCellValue('F3', 'Payment')
            ->setCellValue('G3', 'Payment Date')
            ->setCellValue('H3', 'Balance')
            ->setCellValue('I3', 'Current')
            ->setCellValue('J3', '1-30 Days')
            ->setCellValue('K3', '31-60 Days')
            ->setCellValue('L3', '61-90 Days')
            ->setCellValue('M3', '> 90 Days')

        ;

        $counter    =5;
        $balance    =0;
        $current    =0;
        $piutang    =0;
        $bayar      =0;
        $tiga       =0;
        $enam       =0;
        $sembilan   =0;
        $lebih      =0;
        foreach ($get_agings as $row_agings) :
            if($row_agings->tmp_payment == 0){
                $balance = $row_agings->tmp_hutang;
                $tanggal = "-";
            }else{
				if(!empty($row_agings->tmp_hutang)){
					$balance = $row_agings->tmp_hutang - $row_agings->tmp_payment;
				}else{
					$balance = 0;
				}
                $tanggal = date('d-M-Y', strtotime($row_agings->tmp_realisasi_date));
            }
            $current    += $row_agings->tmp_not_due_date;
            $piutang    += $row_agings->tmp_payment;
            $bayar      += $row_agings->tmp_payment;
            $tiga       += $row_agings->tmp_0sd30;
            $enam       += $row_agings->tmp_31sd60;
            $sembilan   += $row_agings->tmp_61sd90;
            $lebih      += $row_agings->tmp_91sd120+$row_agings->tmp_more120;

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $row_agings->tmp_invno)
                ->setCellValue('B' . $counter, date('d-m-Y',strtotime($row_agings->tmp_inv_date)))
                ->setCellValue('C' . $counter, date('d-m-Y',strtotime($row_agings->tmp_due_date)))
                ->setCellValue('D' . $counter, $row_agings->tmp_currency)
                ->setCellValue('E' . $counter, number_format($row_agings->tmp_hutang, 2))
                ->setCellValue('F' . $counter, number_format($row_agings->tmp_payment, 2))
                ->setCellValue('G' . $counter, $tanggal)
                ->setCellValue('H' . $counter, number_format($balance, 2))
                ->setCellValue('I' . $counter, number_format($row_agings->tmp_not_due_date, 2))
                ->setCellValue('J' . $counter, number_format($row_agings->tmp_0sd30, 2))
                ->setCellValue('K' . $counter, number_format($row_agings->tmp_31sd60, 2))
                ->setCellValue('L' . $counter, number_format($row_agings->tmp_61sd90, 2))
                ->setCellValue('M' . $counter, number_format($row_agings->tmp_91sd120+$row_agings->tmp_more120, 2));

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:M' . ($jlh+1))->applyFromArray($styleArray);
            $counter++;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D' . $counter, 'TOTAL')
            ->setCellValue('E' . $counter, number_format($piutang, 2, '.', ','))
            ->setCellValue('F' . $counter, number_format($bayar, 2, '.', ','))
            ->setCellValue('H' . $counter, number_format(($piutang-$bayar), 2, '.', ','))
            ->setCellValue('I' . $counter, number_format($current, 2, '.', ','))
            ->setCellValue('J' . $counter, number_format($tiga, 2, '.', ','))
            ->setCellValue('K' . $counter, number_format($enam, 2, '.', ','))
            ->setCellValue('L' . $counter, number_format($sembilan, 2, '.', ','))
            ->setCellValue('M' . $counter, number_format($lebih, 2, '.', ','));


        $objPHPExcel->getActiveSheet()->setTitle('Payable Statement');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Statement.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_clean();
        $objWriter->save('php://output');
        exit;

    }

}
