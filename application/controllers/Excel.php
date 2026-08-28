<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Author by ITD15
 */

class Excel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('M_Payable_aging','M_Profit_and_loss_old', 'M_gst', 'M_ccdn', 'M_Monitoring_journal', 'M_Mst_COA', 'M_General_Ledger', 'M_General_Ledger_zht', 'M_Payable_mutation', 'M_Receivable_aging', 'M_Receivable_mutation', 'M_Payable_invoice', 'M_Receivable_invoice', 'M_Supplier_card', 'M_Customer_card', 'M_Payable_statement', 'M_Receivable_statement', 'M_Trial_balance', 'M_Profit_and_loss', 'M_Profit_and_lost', 'M_Balance_sheet','M_Fin_Report','M_Aged_Payable_Summary','M_Aged_Receivable_Summary','M_All_Transaction','M_All_Transaction_rec', 'M_factory','M_Fin_CB', 'M_Customer_card_zht', 'M_Supplier_card_zht','M_Receivable_recognition_tims','M_Aged_Payable_Summary_zht','M_Aged_Receivable_Summary_zht'));
        $this->load->model('Nonconformance_model', 'Container');
	$this->load->library('PHPExcel');
    }

    public function downloadExcel() {

    }

    function toExcelCOA() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $data = $this->M_Mst_COA->select_coa();
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);


        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'Number of COA')
                ->setCellValue('C3', 'Account Name')
                ->setCellValue('D3', 'Group COA');
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle('A3:D' . $jlh)->applyFromArray($styleArray);

        $no = 1;
        $counter = 4;
        foreach ($data as $v):

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->Kombinasi_COA)
                    ->setCellValue('C' . $counter, $v->AccountName)
                    ->setCellValue('D' . $counter, $v->GroupName);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('General Ledger');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toExcelGSTLedger() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $gst = '';

        $data = $this->M_gst->hasil1($dari, $sampai, $gst);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(38);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'DOC. No.')
                ->setCellValue('B3', 'Post. Date')
                ->setCellValue('C3', 'Due Date')
                ->setCellValue('D3', 'Details')
                ->setCellValue('E3', 'Account / Customer / Vendor Name.')
                ->setCellValue('F3', 'LC')
                ->setCellValue('G3', 'FC ')
                ->setCellValue('H3', 'Total(LC)')
                ->setCellValue('I3', 'Total(FC)');

        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $no = 1;
        $counter = 4;
        $saldo = 0;
        $debit2 = 0;
        foreach ($data as $value):
            if ($value->gst_value == 0) {
                $nlc = '';
                $nfc = '';
                $ntlc = '';
                $ntfc = '';
                $Y = '';
            } else {
                $lc = $value->gst_value;
                $fc = $value->gst_value * $value->Rate;
                $saldo += $value->gst_value;
                $debit2 += $value->gst_value * $value->Rate;

                $nlc = $lc;
                $nfc = $fc;
                $ntlc = $saldo;
                $Y = 'SGD ';
                $ntfc = $debit2;
            }

        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->DetailID)
                    ->setCellValue('B' . $counter, date('d M Y', strtotime($value->Tanggal)))
                    ->setCellValue('C' . $counter, date('d M Y', strtotime($value->Tanggal)))
                    ->setCellValue('D' . $counter, $value->NoJurnal)
                    ->setCellValue('E' . $counter, $value->nama_sup)
                    ->setCellValue('F' . $counter, $nlc)
                    ->setCellValue('G' . $counter, $nfc)
                    ->setCellValue('H' . $counter, $ntlc)
                    ->setCellValue('I' . $counter, $ntfc);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $counter, '=SUM(F4:G' . $jlh . ')')
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(I4:H' . $jlh . ')');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A3:I' . $jlh)->applyFromArray($styleArray);

        endforeach;


        $objPHPExcel->getActiveSheet()->setTitle('GST Report');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="GST_Report.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toExcelGl() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $company   = strtoupper($this->session->userdata('company_id'));
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");
        $coa_new = $this->input->get("new_coa");
        $status = $this->input->get("check_coa");
        $parts = explode("-", $coa_new);

        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';
        
        if($status == 1){
            $data = $this->M_General_Ledger->call_gl_summary_new($p_dari,$p_sampai,$part1, $part2);
        }else{
            $data = $this->M_General_Ledger->call_gl_summary($p_dari,$p_sampai,$coa);
        }
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die;
        
        // $data = $this->M_General_Ledger->call_gl_summary($p_dari,$p_sampai,$coa);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Account')
                ->setCellValue('B3', 'Account Name')
                ->setCellValue('C3', 'Beginning Balance')
                ->setCellValue('D3', 'Total Debit')
                ->setCellValue('E3', 'Total Credit')
                ->setCellValue('F3', 'Net Activity ')
                ->setCellValue('G3', 'Last Balance');


        $no = 1;
        $counter = 4;
        $totaldebit = 0;
        $totalkredit = 0;
        $totalnet = 0;
        $totalng = 0;
        $begining = 0;
        $totalbegining = 0;
        $totalB = 0;

        foreach ($data as $value):
            $totalbegining += $value->BBDebet - $value->BBKredit;
            $begining = $value->BBDebet - $value->BBKredit;
            $Debet = $value->MTDebet;
            $Kredit = $value->MTKredit;
            $net = $value->MTDebet - $value->MTKredit;
            $ending = $value->EBDebet - $value->EBKredit;
            $totalB += $begining;
            $totaldebit += $Debet;
            $totalkredit += $Kredit;
            $totalnet += $net;
            $totalng += $ending;
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->NoCOA . '-' . $part2 . '-00' . $company)
                    ->setCellValue('B' . $counter, $value->AccountName)
                    ->setCellValue('C' . $counter, $begining)
                    ->setCellValue('D' . $counter, $Debet)
                    ->setCellValue('E' . $counter, $Kredit)
                    ->setCellValue('F' . $counter, $net)
                    ->setCellValue('G' . $counter, $ending);
            $counter++;
        endforeach;
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $counter, "Grand Total" )
                ->setCellValue('C' . $counter, $totalB)
                ->setCellValue('D' . $counter, $totaldebit)
                ->setCellValue('E' . $counter, $totalkredit)
                ->setCellValue('F' . $counter, $totalnet)
                ->setCellValue('G' . $counter, $totalng);
        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        
        $objPHPExcel->getActiveSheet()->setTitle('General Ledger');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toBalanceSheet1(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $new_awal = date('F jS, Y', strtotime($dari));
        $new_akhir = date('F jS, Y', strtotime($sampai));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $companyid = $this->session->userdata('company_id');
        $year = date('Y', strtotime($sampai));

        if ($companyid == 2) {
            $_balance = $this->M_Balance_sheet->getdata_zht($p_sampai);
            $headerIds = [1, 13];
            $boldIds = [12, 23];
        } else {
            if ($year >=2025) {
                $_balance = $this->M_Balance_sheet->getdata_2025($p_sampai);
                $headerIds = [1, 25, 49, 61];
                $boldIds = [24, 48, 60];
            }else{
                $_balance = $this->M_Balance_sheet->getdata($p_sampai);
                $headerIds = [1, 35];
                $boldIds = [34, 46];
            }
            
        }

        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

            $header = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            );
    
            $header2 = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            );
    
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getStyle("A1:B1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objPHPExcel->getActiveSheet()->getStyle("A2:B2")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
            $objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
    
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(80);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    
            $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
    
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ZHENGHE LOGISTIC PTE. LTD.')
                ->setCellValue('A2', 'BALANCE SHEET AT (' . $new_awal . ') - (' . $new_akhir . ')');

            // INI ISINYA
            
            $counter = 5;

            foreach($_balance as $value):
                $row = $counter;

                if ($companyid == 1 && $year >=2025) {
                    $value->t_coaid = $value->t_number;
                }
            
                if (in_array($value->t_coaid, $headerIds)) {
                    $objPHPExcel->getActiveSheet()->mergeCells("A{$row}:B{$row}");
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A{$row}", $value->t_coaname);
            
                    $objPHPExcel->getActiveSheet()->getStyle("A{$row}:B{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => '7FFFD4'] 
                        ]
                    ]);
                } elseif (in_array($value->t_coaid, $boldIds)) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A{$row}", $value->t_coaname)
                        ->setCellValue("B{$row}", $value->t_balance);
            
                    $objPHPExcel->getActiveSheet()->getStyle("A{$row}:B{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => ['rgb' => 'C0C0C0']
                        ]
                    ]);
                } else {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A{$row}", $value->t_coaname)
                        ->setCellValue("B{$row}", $value->t_balance);
            
                    $objPHPExcel->getActiveSheet()->getStyle("A{$row}:B{$row}")->applyFromArray([
                        'font' => ['bold' => false],
                        'fill' => [
                            'type' => PHPExcel_Style_Fill::FILL_NONE,
                        ]
                    ]);
                }
            
                $counter++;
            endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Balance Sheet');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="BalanceSheet.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    // ini untuk excel gl zht
    function toExcelGlZht() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        $company   = strtoupper($this->session->userdata('company_id'));

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa_new = $this->input->get("new_coa");
        $parts = explode("-", $coa_new);
        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';

        $data = $this->M_General_Ledger_zht->call_gl_summary($p_dari,$p_sampai,$part1, $part2);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Account')
                ->setCellValue('B3', 'Account Name')
                ->setCellValue('C3', 'Beginning Balance')
                ->setCellValue('D3', 'Total Debit')
                ->setCellValue('E3', 'Total Credit')
                ->setCellValue('F3', 'Net Activity ')
                ->setCellValue('G3', 'Last Balance');


        $no = 1;
        $counter = 4;
        $totaldebit = 0;
        $totalkredit = 0;
        $totalnet = 0;
        $totalng = 0;
        $begining = 0;
        $totalbegining = 0;
        $totalB = 0;

        foreach ($data as $value):
            $totalbegining += $value->BBDebet - $value->BBKredit;
            $begining = $value->BBDebet - $value->BBKredit;
            $Debet = $value->MTDebet;
            $Kredit = $value->MTKredit;
            $net = $value->MTDebet - $value->MTKredit;
            $ending = $value->EBDebet - $value->EBKredit;
            $totalB += $begining;
            $totaldebit += $Debet;
            $totalkredit += $Kredit;
            $totalnet += $net;
            $totalng += $ending;
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->NoCOA . '-' . $part2 . '-00' . $company)
                    ->setCellValue('B' . $counter, $value->AccountName)
                    ->setCellValue('C' . $counter, $begining)
                    ->setCellValue('D' . $counter, $Debet)
                    ->setCellValue('E' . $counter, $Kredit)
                    ->setCellValue('F' . $counter, $net)
                    ->setCellValue('G' . $counter, $ending);
            $counter++;
        endforeach;
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $counter, "Grand Total" )
                ->setCellValue('C' . $counter, $totalB)
                ->setCellValue('D' . $counter, $totaldebit)
                ->setCellValue('E' . $counter, $totalkredit)
                ->setCellValue('F' . $counter, $totalnet)
                ->setCellValue('G' . $counter, $totalng);
        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        
        $objPHPExcel->getActiveSheet()->setTitle('General Ledger ZHT');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_zht.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toExcelGlDetail_zht() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        $company   = strtoupper($this->session->userdata('company_id'));

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa_new = $this->input->get("new_coa");
        $dept_code = $this->input->get("dept_code");
        $parts = explode("-", $coa_new);
        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';
        
        $data = $this->M_General_Ledger_zht->get_detail_gl($p_dari,$p_sampai,$part1, $part2);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);


       
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Invoice Number')
                ->setCellValue('B3', 'Date Of Journal')
                ->setCellValue('C3', 'Check Number')
                ->setCellValue('D3', 'Vendor / Customer')
                ->setCellValue('E3', 'Description')
                ->setCellValue('F3', 'B/L Code')
                ->setCellValue('G3', 'Debit(LC)')
                ->setCellValue('H3', 'Credit(LC)')
                ->setCellValue('I3', 'Balance(LC)')
                ->setCellValue('J3', 'Debit(FC)')
                ->setCellValue('K3', 'Credit(FC)')
                ->setCellValue('L3', 'Balance(FC)');


        $no = 1;
        $counter = 4;
        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($data as $value):
            if ($value->tmp_debet < 0) {
                $value->tmp_kredit += abs($value->tmp_debet);
                $value->tmp_debet = 0;
            }

            if ($value->tmp_debet_sgd < 0) {
                $value->tmp_kredit_sgd += abs($value->tmp_debet_sgd);
                $value->tmp_debet_sgd = 0;
            }

            $tDebet += $value->tmp_debet;
            $tKredit += $value->tmp_kredit;
            $tBalance = $value->tmp_balance;
            $tDebetSGD += $value->tmp_debet_sgd;
            $tKreditSGD += $value->tmp_kredit_sgd;
            $tBalanceSGD = $value->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($value->tmp_tanggal), "d F Y");
            $saldo += $value->tmp_debet - $value->tmp_kredit;
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('B' . $counter, $tgl_jurnal)
                    ->setCellValue('C' . $counter, $value->tmp_check_bank)
                    ->setCellValue('D' . $counter, $value->tmp_sup_cust)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_containerNo)
                    ->setCellValue('G' . $counter, $value->tmp_debet)
                    ->setCellValue('H' . $counter, $value->tmp_kredit)
                    ->setCellValue('I' . $counter, $value->tmp_balance)
                    ->setCellValue('J' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('L' . $counter, $value->tmp_balance_sgd);
            $counter++;
        endforeach;
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle($counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('E' . $counter, "Total" )
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, round($tBalance,2))
                    ->setCellValue('J' . $counter, '=SUM(J4:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(K4:K' . $jlh . ')')
                    ->setCellValue('L' . $counter, round($tBalanceSGD,2));

        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:L3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J3:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K3:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L3:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $objPHPExcel->getActiveSheet()->setTitle('General Ledger ZHT Detail');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_Detail_zht.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function ExcelGlDetail_zht()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");
        $coa2 = $this->input->get("jenis_coa_2");

        $data = $this->M_General_Ledger_zht->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);


        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No COA')
            ->setCellValue('B3', 'Invoice Number')
            ->setCellValue('C3', 'Date Of Journal')
            ->setCellValue('D3', 'Check Number')
            ->setCellValue('E3', 'Description')
            ->setCellValue('F3', 'Debit(LC)')
            ->setCellValue('G3', 'Credit(LC)')
            ->setCellValue('H3', 'Balance(LC)')
            ->setCellValue('I3', 'Debit(FC)')
            ->setCellValue('J3', 'Credit(FC)')
            ->setCellValue('K3', 'Balance(FC)');


        $no = 1;
        $counter = 4;
        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($data as $value) :
            $tDebet += $value->tmp_debet;
            $tKredit += $value->tmp_kredit;
            $tBalance += $value->tmp_balance;
            $tDebetSGD += $value->tmp_debet_sgd;
            $tKreditSGD += $value->tmp_kredit_sgd;
            $tBalanceSGD += $value->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($value->tmp_tanggal), "d F Y");
            $saldo += $value->tmp_debet - $value->tmp_kredit;

            if (
                $value->tmp_uraian == 'BEGINING BALANCE'
            ) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->tmp_no_coa . ' ' . $value->tmp_namaakun)
                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('C' . $counter, $tgl_jurnal)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
            } else if ($value->tmp_uraian == 'TOTAL') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':J' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                    ->getActiveSheet()->getStyle('A' . $counter . ':J' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            } else if ($value->tmp_uraian != 'TOTAL' || $value->tmp_uraian != 'BEGINING BALANCE') {
                $objPHPExcel->setActiveSheetIndex(0)

                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('C' . $counter, $tgl_jurnal)
                    ->setCellValue('D' . $counter, $value->tmp_check_bank)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
            }
            $counter++;
        endforeach;
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle($counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $counter -= 1;
        $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:K3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B3:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C3:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D3:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E3:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F3:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G3:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H3:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I3:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J3:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('General Ledger ZHT Detail');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_Detail_zht.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    // tutup general ledger detail

    function toExcelGlDetail() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        $company   = strtoupper($this->session->userdata('company_id'));

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");
        $coa_new = $this->input->get("new_coa");
        $status = $this->input->get("check_coa");
        $dept_code = $this->input->get("dept_code");
        $parts = explode("-", $coa_new);

        $part1 = isset($parts[0]) ? $parts[0] : ''; 
        $part2 = isset($parts[1]) ? $parts[1] : '';

        if($status == 1){
            $data = $this->M_General_Ledger->get_detail_gl_new($p_dari,$p_sampai,$part1, $part2);
        }else{
            $data = $this->M_General_Ledger->get_detail_gl($p_dari,$p_sampai,$coa);
        }

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);


       
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        
        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Invoice Number')
                ->setCellValue('B3', 'Date Of Journal')
                ->setCellValue('C3', 'Check Number')
                ->setCellValue('D3', 'B/L Code')
                ->setCellValue('E3', 'Vendor / Customer')
                ->setCellValue('F3', 'Description')
                ->setCellValue('G3', 'Debit(LC)')
                ->setCellValue('H3', 'Credit(LC)')
                ->setCellValue('I3', 'Balance(LC)')
                ->setCellValue('J3', 'Debit(FC)')
                ->setCellValue('K3', 'Credit(FC)')
                ->setCellValue('L3', 'Balance(FC)');


        $no = 1;
        $counter = 4;
        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($data as $value):
            $tDebet += $value->tmp_debet;
            $tKredit += $value->tmp_kredit;
            $tBalance = $value->tmp_balance;
            $tDebetSGD += $value->tmp_debet_sgd;
            $tKreditSGD += $value->tmp_kredit_sgd;
            $tBalanceSGD = $value->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($value->tmp_tanggal), "d F Y");
            $saldo += $value->tmp_debet - $value->tmp_kredit;
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('B' . $counter, $tgl_jurnal)
                    ->setCellValue('C' . $counter, $value->tmp_check_bank)
                    ->setCellValue('D' . $counter, $value->tmp_blCode)
                    ->setCellValue('E' . $counter, $value->tmp_sup_cust)
                    ->setCellValue('F' . $counter, $value->tmp_uraian)
                    ->setCellValue('G' . $counter, $value->tmp_debet)
                    ->setCellValue('H' . $counter, $value->tmp_kredit)
                    ->setCellValue('I' . $counter, $value->tmp_balance)
                    ->setCellValue('J' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('L' . $counter, $value->tmp_balance_sgd);
            $counter++;
        endforeach;
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle($counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $counter, "Total" )
                    ->setCellValue('G' . $counter, '=SUM(G4:F' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, round($tBalance,2))
                    ->setCellValue('J' . $counter, '=SUM(J4:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(K4:K' . $jlh . ')')
                    ->setCellValue('L' . $counter, round($tBalanceSGD,2));

        // $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValue('C' . $counter, "Total" )
        //         ->setCellValue('D' . $counter, $tDebet)
        //         ->setCellValue('E' . $counter, $tKredit)
        //         ->setCellValue('F' . $counter, $tBalance)
        //         ->setCellValue('G' . $counter, $tDebetSGD)
        //         ->setCellValue('H' . $counter, $tKreditSGD)
        //         ->setCellValue('I' . $counter, $tBalanceSGD);
        
        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:L3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J3:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K3:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L3:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':L'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $objPHPExcel->getActiveSheet()->setTitle('General Ledger Detail');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_Detail.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toExcelGlDetailALL() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $start_coa  = strlen($this->input->get("jenis_coa")) > 0 ? $this->input->get("jenis_coa") : null;
        $end_coa  = strlen($this->input->get("jenis_coa2")) > 0 ? $this->input->get("jenis_coa2") : null;

        //$data = $this->M_General_Ledger->call_gl_all_detail($p_dari,$p_sampai,$coa, $coa2);

        $data = $this->M_General_Ledger->call_gl_all_detail_dev($p_dari, $p_sampai, $start_coa, $end_coa);
        
        // echo "<pre>";
        // print_r ($data);
        // echo "</pre>";
        // die;
        

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);


        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No COA')
            ->setCellValue('B3', 'Invoice Number')
            ->setCellValue('C3', 'Supplier / Customer')
            ->setCellValue('D3', 'Date Of Journal')
            ->setCellValue('E3', 'Check Number')
            ->setCellValue('F3', 'Description')
            ->setCellValue('G3', 'Debit(LC)')
            ->setCellValue('H3', 'Credit(LC)')
            ->setCellValue('I3', 'Balance(LC)')
            ->setCellValue('J3', 'Debit(FC)')
            ->setCellValue('K3', 'Credit(FC)')
            ->setCellValue('L3', 'Balance(FC)');


        $no = 1;
        $counter = 4;
        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($data as $value):
            $tDebet += $value->tmp_debet;
            $tKredit += $value->tmp_kredit;
            $tBalance += $value->tmp_balance;
            $tDebetSGD += $value->tmp_debet_sgd;
            $tKreditSGD += $value->tmp_kredit_sgd;
            $tBalanceSGD += $value->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($value->tmp_tanggal), "d F Y");
            $saldo += $value->tmp_debet - $value->tmp_kredit;

      IF( $value->tmp_uraian=='BEGINING BALANCE' ) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $value->tmp_no_coa.' '.$value->tmp_namaakun)
                ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                ->setCellValue('D' . $counter, $tgl_jurnal)
                ->setCellValue('F' . $counter, $value->tmp_uraian)
                ->setCellValue('G' . $counter, $value->tmp_debet)
                ->setCellValue('H' . $counter, $value->tmp_kredit)
                ->setCellValue('I' . $counter, $value->tmp_balance)
                ->setCellValue('J' . $counter, $value->tmp_debet_sgd)
                ->setCellValue('K' . $counter, $value->tmp_kredit_sgd)
                ->setCellValue('L' . $counter, $value->tmp_balance_sgd);
        }
        ELSE IF($value->tmp_uraian=='TOTAL' ) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                ->setCellValue('F' . $counter, $value->tmp_uraian)
                ->setCellValue('G' . $counter, $value->tmp_debet)
                ->setCellValue('H' . $counter, $value->tmp_kredit)
                ->setCellValue('I' . $counter, $value->tmp_balance)
                ->setCellValue('J' . $counter, $value->tmp_debet_sgd)
                ->setCellValue('K' . $counter, $value->tmp_kredit_sgd)
                ->setCellValue('L' . $counter, $value->tmp_balance_sgd);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':J'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':J'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        }
        ELSE IF($value->tmp_uraian!='TOTAL' || $value->tmp_uraian!='BEGINING BALANCE' ) {
            $objPHPExcel->setActiveSheetIndex(0)

                ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                ->setCellValue('C' . $counter, $value->tmp_supplier)
                ->setCellValue('D' . $counter, $tgl_jurnal)
                ->setCellValue('E' . $counter, $value->tmp_check_bank)
                ->setCellValue('F' . $counter, $value->tmp_uraian)
                ->setCellValue('G' . $counter, $value->tmp_debet)
                ->setCellValue('H' . $counter, $value->tmp_kredit)
                ->setCellValue('I' . $counter, $value->tmp_balance)
                ->setCellValue('J' . $counter, $value->tmp_debet_sgd)
                ->setCellValue('K' . $counter, $value->tmp_kredit_sgd)
                ->setCellValue('L' . $counter, $value->tmp_balance_sgd);
        }
            $counter++;
        endforeach;
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle($counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $counter -= 1;
        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:L3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J3:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K3:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L3:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('General Ledger Detail');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_Detail.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }



    function ExcelGlDetail()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $coa = $this->input->get("jenis_coa");
        $coa2 = $this->input->get("jenis_coa_2");
        $coa_new = $this->input->get("new_coa");
        $coa_new2 = $this->input->get("new_coa_2");
        $status = $this->input->get("check_coa");

        if($status == 1){
            $data = $this->M_General_Ledger->call_gl_all_detail_2_new($p_dari,$p_sampai,$coa_new, $coa_new2);
        }else{
            $data = $this->M_General_Ledger->call_gl_all_detail_2($p_dari,$p_sampai,$coa, $coa2);
        }
        // $data = $this->M_General_Ledger->call_gl_all_detail_2($p_dari, $p_sampai, $coa, $coa2);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);


        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No COA')
            ->setCellValue('B3', 'Invoice Number')
            ->setCellValue('C3', 'Date Of Journal')
            ->setCellValue('D3', 'Check Number')
            ->setCellValue('E3', 'Description')
            ->setCellValue('F3', 'Debit(LC)')
            ->setCellValue('G3', 'Credit(LC)')
            ->setCellValue('H3', 'Balance(LC)')
            ->setCellValue('I3', 'Debit(FC)')
            ->setCellValue('J3', 'Credit(FC)')
            ->setCellValue('K3', 'Balance(FC)');


        $no = 1;
        $counter = 4;
        $tDebet = 0;
        $tKredit = 0;
        $tBalance = 0;
        $tDebetSGD = 0;
        $tKreditSGD = 0;
        $tBalanceSGD = 0;
        $saldo = 0;

        foreach ($data as $value) :
            $tDebet += $value->tmp_debet;
            $tKredit += $value->tmp_kredit;
            $tBalance += $value->tmp_balance;
            $tDebetSGD += $value->tmp_debet_sgd;
            $tKreditSGD += $value->tmp_kredit_sgd;
            $tBalanceSGD += $value->tmp_balance_sgd;
            $tgl_jurnal = date_format(date_create($value->tmp_tanggal), "d F Y");
            $saldo += $value->tmp_debet - $value->tmp_kredit;

            if (
                $value->tmp_uraian == 'BEGINING BALANCE'
            ) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->tmp_no_coa . ' ' . $value->tmp_namaakun)
                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('C' . $counter, $tgl_jurnal)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
            } else if ($value->tmp_uraian == 'TOTAL') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':J' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                    ->getActiveSheet()->getStyle('A' . $counter . ':J' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            } else if ($value->tmp_uraian != 'TOTAL' || $value->tmp_uraian != 'BEGINING BALANCE') {
                $objPHPExcel->setActiveSheetIndex(0)

                    ->setCellValue('B' . $counter, $value->tmp_nojurnal)
                    ->setCellValue('C' . $counter, $tgl_jurnal)
                    ->setCellValue('D' . $counter, $value->tmp_check_bank)
                    ->setCellValue('E' . $counter, $value->tmp_uraian)
                    ->setCellValue('F' . $counter, $value->tmp_debet)
                    ->setCellValue('G' . $counter, $value->tmp_kredit)
                    ->setCellValue('H' . $counter, $value->tmp_balance)
                    ->setCellValue('I' . $counter, $value->tmp_debet_sgd)
                    ->setCellValue('J' . $counter, $value->tmp_kredit_sgd)
                    ->setCellValue('K' . $counter, $value->tmp_balance_sgd);
            }
            $counter++;
        endforeach;
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle($counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $counter -= 1;
        $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:K3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B3:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C3:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D3:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E3:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F3:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G3:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H3:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I3:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J3:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('General Ledger Detail');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger_Detail.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


	function toExcelCcdn() 
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $invoice = $this->input->get("invoice");
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $supplier = $this->input->get("supplier");

        $List_coa= $this->M_ccdn->get_coa();
        $List_ccdn = $this->M_ccdn->list_ccdn3($invoice, $supplier, $p_dari, $p_sampai);



        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A3:A4")->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("B3:B4")->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("C3:C4")->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->mergeCells("D3:D4")->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("E3:E4")->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("F3:F4")->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("G3:G4")->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("H3:H4")->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("I3:I4")->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("J3:J4")->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("K3:K4")->getColumnDimension('K')->setWidth(15);

        //set aligment header row
        $objPHPExcel->getActiveSheet()->getstyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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



        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.0000_);[Red](#,##0.0000)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A1', ' Debet / Credit Note List - '.date("M Y", strtotime($dari)))
            ->setCellValue('A3', 'Date of Jurnal')
            ->setCellValue('B3', 'Invoice Number')
            ->setCellValue('C3', 'Customer')
            ->setCellValue('D3', 'Currency')
            ->setCellValue('E3', 'Rate')
            ->setCellValue('F3', 'Amount (USD)')
            ->setCellValue('G3', 'GST (USD)')
            ->setCellValue('H3', 'Total (USD)')
            ->setCellValue('I3', 'Amount (SGD)')
            ->setCellValue('J3', 'GST (SGD)')
            ->setCellValue('K3', 'Total (SGD)')

        ;

        $counter=5;
        $amount_usd = 0;
        $gst_value_usd = 0;
        $total_usd = 0;
        $amount_sgd = 0;
        $gst_value_sgd = 0;
        $total_sgd = 0;
        foreach ($List_ccdn as $v) :
            if ($v->currency == 'USD'){
                $amount_usd += $v->hutang;
            }
            if ($v->gst_value > '0.0000'){
                $gst_value_usd += $v->gst_value * $v->rate_sgd;
            }
            if ($v->currency == 'USD'){
                $total_usd += $v->hutang + $v->gst_value * $v->rate_sgd;
            }

            if ($v->currency == 'SGD'){
                $amount_sgd += $v->hutang;
            }
            if ($v->gst_value > '0.0000'){
                $gst_value_sgd += $v->gst_value * $v->rate_sgd;
            }
            if ($v->currency == 'SGD'){
                $total_sgd += $v->hutang + $v->gst_value * $v->rate_sgd;
            }

            if ($v->currency == 'USD') {
                $amountusd = $v->hutang;
            } else{
                $amountusd = '-';
            }
            if ($v->gst_value > '0.0000'){
                $gst_valueusd = $v->gst_value * $v->rate_sgd;
            } else {
                $gst_valueusd = '-';
            }
            if ($v->currency == 'USD'){
                $totalusd = $v->hutang + $v->gst_value * $v->rate_sgd;
            } else {
                $totalusd = '-';
            }

            if ($v->currency == 'SGD') {
                $amountsgd = $v->hutang;
            } else{
                $amountsgd = '-';
            }
            if ($v->gst_value > '0.0000'){
                $gst_valuesgd = $v->gst_value * $v->rate_sgd;
            } else {
                $gst_valuesgd = '-';
            }
            if ($v->currency == 'SGD'){
                $totalsgd = $v->hutang + $v->gst_value * $v->rate_sgd;
            } else {
                $totalsgd = '-';
            }

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->tanggal)
                ->setCellValue('B' . $counter, $v->no_reff)
                ->setCellValue('C' . $counter, $v->nama_sup)
                ->setCellValue('D' . $counter, $v->currency)
                ->setCellValue('E' . $counter, number_format($v->Rate, 4))
                ->setCellValue('F' . $counter, $amountusd)
                ->setCellValue('G' . $counter, $gst_valueusd)
                ->setCellValue('H' . $counter, $totalusd)
                ->setCellValue('I' . $counter, $amountsgd)
                ->setCellValue('J' . $counter, $gst_valuesgd)
                ->setCellValue('K' . $counter, $totalsgd);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $counter, '=SUM(F5:F' . $jlh . ')')
                    ->setCellValue('G' . $counter, '=SUM(G5:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H5:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(I5:I' . $jlh . ')')
                    ->setCellValue('J' . $counter, '=SUM(J5:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(K5:K' . $jlh . ')');


            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . ($jlh+1))->applyFromArray($styleArray);
        endforeach;


        $objPHPExcel->getActiveSheet()->setTitle('CCDN');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="CCDN.xlsx"');
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
	
    function toExcelJurnal1() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');
        $noreference = $this->input->get('noreference');
        $jenis_coa = $this->input->get('jenis_coa');
        $data = $this->M_Monitoring_journal->hasil($dari, $sampai, $jenis_coa, $noreference, $jenis_trans);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Date')
                ->setCellValue('C3', 'No COA')
                ->setCellValue('D3', 'Remark')
                ->setCellValue('E3', 'No Reference')
                ->setCellValue('F3', 'Debit')
                ->setCellValue('G3', 'Credit')
                ->setCellValue('H3', 'Currency')
                ->setCellValue('I3', 'Rate');


        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            if ($v->Debet == '0') {
                $Debet = '';
            } else {
                $Debet = $v->Debet;
            }

            if ($v->Kredit == '0') {
                $Kredit = '';
            } else {
                $Kredit = $v->Kredit;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, '')
                    ->setCellValue('B' . $counter, $v->Tanggal)
                    ->setCellValue('C' . $counter, $v->NoCOA)
                    ->setCellValue('D' . $counter, $v->Uraian)
                    ->setCellValue('E' . $counter, $v->NoJurnal)
                    ->setCellValue('F' . $counter, $Debet)
                    ->setCellValue('G' . $counter, $Kredit)
                    ->setCellValue('H' . $counter, $v->Currency)
                    ->setCellValue('I' . $counter, $v->Rate);
            $counter++;
        endforeach;


        $objPHPExcel->getActiveSheet()->setTitle('Monitoring Journal');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Monitoring_Journal.xlsx"');
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

    function toExcelJurnal() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');
        $noreference = $this->input->get('noreference');
        $jenis_coa = $this->input->get('jenis_coa');

        $data = $this->M_Monitoring_journal->select_journal($dari, $sampai);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');


        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Date')
                ->setCellValue('C3', 'No COA')
                ->setCellValue('D3', 'Remark')
                ->setCellValue('E3', 'No Reference')
                ->setCellValue('F3', 'Debit')
                ->setCellValue('G3', 'Credit')
                ->setCellValue('H3', 'Currency')
                ->setCellValue('I3', 'Rate');
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle('A3:K' . $jlh)->applyFromArray($styleArray);

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            if ($v->Debet == '0') {
                $Debet = '';
            } else {
                $Debet = $v->Debet;
            }

            if ($v->Kredit == '0') {
                $Kredit = '';
            } else {
                $Kredit = $v->Kredit;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, '')
                    ->setCellValue('B' . $counter, $v->Tanggal)
                    ->setCellValue('C' . $counter, $v->NoCOA)
                    ->setCellValue('D' . $counter, $v->Uraian)
                    ->setCellValue('E' . $counter, $v->NoJurnal)
                    ->setCellValue('F' . $counter, $Debet)
                    ->setCellValue('G' . $counter, $Kredit)
                    ->setCellValue('H' . $counter, $v->Currency)
                    ->setCellValue('I' . $counter, $v->Rate);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('General Ledger');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="General_Ledger.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    function toExcel1() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Payable_aging->call_data_aging($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Vendor')
                ->setCellValue('C3', 'Inv. Date')
                ->setCellValue('D3', 'Invoice Number')
                ->setCellValue('E3', 'Due Date')
                ->setCellValue('F3', 'Currency')
                ->setCellValue('G3', 'Amount')
                ->setCellValue('H3', 'Current')
                ->setCellValue('I3', '0 - 30 Days')
                ->setCellValue('J3', '31 - 60 Days')
                ->setCellValue('K3', '61 - 90 Days')
                ->setCellValue('L3', '> 91 Days')
                ->setCellValue('M3', 'Total');

        $no = 1;
        $xs = 4;
        $counter = 5;
        $duedate = 0;
        $sd30 = 0;
        $sd60 = 0;
        $sd90 = 0;
        $sd120 = 0;
        $grand_total = 0;
        $gt = 0;
        foreach ($data as $v):
            $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
            $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120 ;
            $duedate += $v->tmp_not_due_date;
            $sd30 += $v->tmp_0sd30;
            $sd60 += $v->tmp_31sd60;
            $sd90 += $v->tmp_61sd90;
            $sd120 += $v->tmp_91sd120;
            $grand_total += $v->tmp_91sd120 + $v->tmp_more120;

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('C' . $counter, $v->tmp_inv_date)
                    ->setCellValue('D' . $counter, $v->tmp_invno)
                    ->setCellValue('E' . $counter, $v->tmp_due_date)
                    ->setCellValue('F' . $counter, $v->tmp_currency)
                    ->setCellValue('G' . $counter, $total)
                    ->setCellValue('H' . $counter, $v->tmp_not_due_date)
                    ->setCellValue('I' . $counter, $v->tmp_0sd30)
                    ->setCellValue('J' . $counter, $v->tmp_31sd60)
                    ->setCellValue('K' . $counter, $v->tmp_61sd90)
                    ->setCellValue('L' . $counter, $v->tmp_91sd120 + $v->tmp_more120)
                    ->setCellValue('M' . $counter, $total);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(I4:I' . $jlh . ')')
                    ->setCellValue('J' . $counter, '=SUM(J4:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(K4:K' . $jlh . ')')
                    ->setCellValue('L' . $counter, '=SUM(L4:L' . $jlh . ')')
                    ->setCellValue('M' . $counter, '=SUM(M4:M' . $jlh . ')');

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:M' . $jlh)->applyFromArray($styleArray);
        endforeach;


        $objPHPExcel->getActiveSheet()->setTitle('Payable Aging');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Aging.xlsx"');
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

    function toExcel2() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_receivable_aging->call_data_aging($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
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
                ->setCellValue('K3', 'Total');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            $total = 0;
            $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('C' . $counter, $v->tmp_inv_date)
                    ->setCellValue('D' . $counter, $v->tmp_invno)
                    ->setCellValue('E' . $counter, $v->tmp_due_date)
                    ->setCellValue('F' . $counter, $v->tmp_not_due_date)
                    ->setCellValue('G' . $counter, $v->tmp_0sd30)
                    ->setCellValue('H' . $counter, $v->tmp_31sd60)
                    ->setCellValue('I' . $counter, $v->tmp_61sd90)
                    ->setCellValue('J' . $counter, $v->tmp_91sd120 + $v->tmp_more120)
                    ->setCellValue('K' . $counter, $total);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Receivable Aging');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Aging.xlsx"');
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

    function toExcel3() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Payable_mutation->call_data($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Supplier ID')
                ->setCellValue('C3', 'Supplier Name')
                ->setCellValue('D3', 'Begining Balance')
                ->setCellValue('E3', 'Purchase')
                ->setCellValue('F3', 'Down Payment')
                ->setCellValue('G3', 'Payment')
                ->setCellValue('H3', 'Debt Note')
                ->setCellValue('I3', 'Credit Note')
                ->setCellValue('J3', 'Balance')
                ->setCellValue('K3', 'Ending Rate');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            $balance = 0;
            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $balance = $v->begining_balance + $v->purchase - $v->payment - $v->debet_note + $v->kredit_note;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->kode_sup)
                    ->setCellValue('C' . $counter, $v->suppliercompany)
                    ->setCellValue('D' . $counter, $v->begining_balance)
                    ->setCellValue('E' . $counter, $v->purchase)
                    ->setCellValue('F' . $counter, $v->down_payment)
                    ->setCellValue('G' . $counter, $v->payment)
                    ->setCellValue('H' . $counter, $v->debet_note)
                    ->setCellValue('I' . $counter, $v->kredit_note)
                    ->setCellValue('J' . $counter, $balance)
                    ->setCellValue('K' . $counter, $v->balance_rateakhir);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . $counter, '=SUM(D4:D' . $jlh . ')')
                    ->setCellValue('E' . $counter, '=SUM(E4:E' . $jlh . ')')
                    ->setCellValue('F' . $counter, '=SUM(F4:F' . $jlh . ')')
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('J' . $counter, '=SUM(J4:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(J4:J' . $jlh . ')');

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . $jlh)->applyFromArray($styleArray);
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Payable Mutation');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Mutation.xlsx"');
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

    function toExcel4() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Receivable_mutation->call_data($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Customer ID')
                ->setCellValue('C3', 'Customer Name')
                ->setCellValue('D3', 'Begining Balance')
                ->setCellValue('E3', 'Purchase')
                ->setCellValue('F3', 'Down Payment')
                ->setCellValue('G3', 'Payment')
                ->setCellValue('H3', 'Debt Note')
                ->setCellValue('I3', 'Credit Note')
                ->setCellValue('J3', 'Balance')
                ->setCellValue('K3', 'Balance Rate');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            $balance = 0;
            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $balance = $v->begining_balance + $v->purchase - $v->payment - $v->debet_note + $v->kredit_note;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->customer_code)
                    ->setCellValue('C' . $counter, $v->customer_name)
                    ->setCellValue('D' . $counter, $v->begining_balance)
                    ->setCellValue('E' . $counter, $v->purchase)
                    ->setCellValue('F' . $counter, $v->down_payment)
                    ->setCellValue('G' . $counter, $v->payment)
                    ->setCellValue('H' . $counter, $v->debet_note)
                    ->setCellValue('I' . $counter, $v->kredit_note)
                    ->setCellValue('J' . $counter, $balance)
                    ->setCellValue('K' . $counter, $v->balance_rateakhir);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . $counter, '=SUM(D4:D' . $jlh . ')')
                    ->setCellValue('E' . $counter, '=SUM(E4:E' . $jlh . ')')
                    ->setCellValue('F' . $counter, '=SUM(F4:F' . $jlh . ')')
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(H4:H' . $jlh . ')')
                    ->setCellValue('J' . $counter, '=SUM(J4:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(J4:J' . $jlh . ')');

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . $jlh)->applyFromArray($styleArray);
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Receivable Mutation');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Mutation.xlsx"');
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

    // function toExcel5() {
    //     error_reporting(E_ALL);
    //     ini_set('display_errors', TRUE);
    //     ini_set('display_startup_errors', TRUE);
    //     date_default_timezone_set('Europe/London');

    //     $sup = $this->input->get('supplier');
    //     $tgl = $this->input->get('periode') . "/" . date("d");
    //     $curreny = $this->input->get('currency');
    //     $data = $this->M_Payable_invoice->call_data($sup, $curreny, $tgl);
    //     if (PHP_SAPI == 'cli')
    //         die('This example should only be run from a Web Browser');
    //     // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';

        

    //     $objPHPExcel = new PHPExcel();        
       

    //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


    //     $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

    //     $objPHPExcel->setActiveSheetIndex(0)
    //             // ->setCellValue('A1', $title)
    //             ->setCellValue('A3', 'No')
    //             ->setCellValue('B3', 'Supplier ID')
    //             ->setCellValue('C3', 'Supplier Name')
    //             ->setCellValue('D3', 'Invoice Number')
    //             ->setCellValue('E3', 'Invoice Date')
    //             ->setCellValue('F3', 'Date Of Journal')
    //             ->setCellValue('G3', 'Due Date')
    //             ->setCellValue('H3', 'Prepaid')
    //             ->setCellValue('I3', 'Total')
    //             ->setCellValue('J3', 'currency')
    //             ->setCellValue('K3', 'Rate')
    //             ->setCellValue('L3', 'Total USD')
    //             ->setCellValue('M3', 'Ending Rate')
    //             ->setCellValue('N3', 'Ending Total');

    //     $no = 1;
    //     $counter = 4;
    //     $g_prepaid=0;
    //     $Total_usd_rateakhir = 0;
    //     $Total_usd = 0;
    //     $uang_muka = 0;
    //     $sisa = 0;
    //     $Total_usd = 0;
    //     $Total_usd_rateakhir = 0;
    //     foreach ($data as $v):

            
    //         $uang_muka += $v->uang_muka;
    //         $sisa += $v->hutang;
    //         $Total_usd += $v->Total_usd;
    //         $Total_usd_rateakhir += $v->Total_usd_rateakhir;
    //         $n1 = number_format($Total_usd, 2, '.', ',');
    //         $n2 = number_format($Total_usd_rateakhir, 2, '.', ',');

    //         // $balance = 0;
    //         // $balance = $v->begining_balance + $v->purchase  - $v->payment - $v->debet_note + $v->kredit_note;
    //         $objPHPExcel->setActiveSheetIndex(0)
    //                 ->setCellValue('A' . $counter, $no++)
    //                 ->setCellValue('B' . $counter, $v->kode_sup)
    //                 ->setCellValue('C' . $counter, $v->suppliercompany)
    //                 ->setCellValue('D' . $counter, $v->nofaktur)
    //                 ->setCellValue('E' . $counter, $v->tanggal_invoice)
    //                 ->setCellValue('F' . $counter, $v->tanggal)
    //                 ->setCellValue('G' . $counter, $v->tanggal_tempo)
    //                 ->setCellValue('H' . $counter, $v->uang_muka)
    //                 ->setCellValue('I' . $counter, $v->hutang)
    //                 ->setCellValue('J' . $counter, $v->currency_id)
    //                 ->setCellValue('K' . $counter, number_format($v->rate_awal, 6, ',', '.'))
    //                 ->setCellValue('L' . $counter, $v->Total_usd)
    //                 ->setCellValue('M' . $counter, number_format($v->rate_akhir, 6, ',', '.'))
    //                 ->setCellValue('N' . $counter, $v->Total_usd_rateakhir);
    //         $counter++;
    //     endforeach;

    //     $objPHPExcel->getActiveSheet()->mergeCells('A'. $counter.':G' . $counter);
    //     $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A' . $counter,  "Grand Total")
    //         ->setCellValue('H' . $counter, number_format($uang_muka, 2, ".", ","))
    //         ->setCellValue('I' . $counter, number_format($sisa, 2, ".", ","))
    //         ->setCellValue('L' . $counter, number_format($Total_usd, 2, ".", ","))
    //         ->setCellValue('N' . $counter, number_format($Total_usd_rateakhir, 2, ".", ","));





    //     $objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:N3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('J3:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('K3:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('L3:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('M3:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('N3:N'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A'.$counter.':N'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //     $objPHPExcel->getActiveSheet()->setTitle('Payable Invoice');
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Payable_Invoice.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    //     header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header('Pragma: public'); // HTTP/1.0
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //     $objWriter->save('php://output');
    //     exit;
    // }

    function toExcel5() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Payable_invoice->call_data($sup, $curreny, $tgl);
        $supp = $this->M_Payable_invoice->get_supply($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $rgb = array('rgb'=>'000000');

        $header = array(
                'font'  => array(
                    'bold' => true,
                    'color' => $rgb,
                    'name' => 'Verdana'
                )
            );

        $tot1 = array();
        $tot2 = array();

        $objPHPExcel = new PHPExcel();        
       

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            // $jlh = $jlh + 1;


        


        $counter = 3;
        foreach ($supp as $r) {
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$counter.':K'.$counter);

        

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $r->kode_sup)
                ->setCellValue('B' . $counter, $r->suppliercompany);
                $counter++;

            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)
                    ->applyFromArray($header)->getFont()->setSize(10);

            $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A'.$counter, 'No')
                // ->setCellValue('B3', 'Supplier ID')
                // ->setCellValue('C3', 'Supplier Name')
                ->setCellValue('D'.$counter, 'Invoice Number')
                ->setCellValue('E'.$counter, 'Invoice Date')
                ->setCellValue('F'.$counter, 'Date Of Journal')
                ->setCellValue('G'.$counter, 'Due Date')
                ->setCellValue('H'.$counter, 'Currency')
                ->setCellValue('I'.$counter, 'Total')
                // ->setCellValue('J'.$counter, 'currency')
                ->setCellValue('J'.$counter, 'Rate')
                ->setCellValue('K'.$counter, 'Total USD');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':K' . $counter)->applyFromArray($styleArray);
                // ->setCellValue('L'.$counter, 'Ending Rate')
                // ->setCellValue('M'.$counter, 'Ending Total');
                $counter++;

                $no = 1;
                $g_prepaid=0;
                $Total_usd_rateakhir = 0;
                $Total_usd = 0;
                $uang_muka = 0;
                $sisa = 0;
                $Total_usd = 0;
                $Total_usd_rateakhir = 0;
                $supp_no = 0;
                $awal = $counter;

            foreach ($data as $v){
                if($r->kode_sup == $v->kode_sup){
                    $uang_muka += $v->uang_muka;
                    $sisa += $v->hutang;
                    $Total_usd += $v->Total_usd;
                    $Total_usd_rateakhir += $v->Total_usd_rateakhir;
                    $n1 = number_format($Total_usd, 2, '.', ',');
                    $n2 = number_format($Total_usd_rateakhir, 2, '.', ',');

                    // $balance = 0;
                    // $balance = $v->begining_balance + $v->purchase  - $v->payment - $v->debet_note + $v->kredit_note;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no++)
                            // ->setCellValue('B' . $counter, $v->kode_sup)
                            // ->setCellValue('C' . $counter, $v->suppliercompany)
                            ->setCellValue('D' . $counter, $v->nofaktur)
                            ->setCellValue('E' . $counter, $v->tanggal_invoice)
                            ->setCellValue('F' . $counter, $v->tanggal)
                            ->setCellValue('G' . $counter, $v->tanggal_tempo)
                            ->setCellValue('H' . $counter, $v->currency_id)
                            ->setCellValue('I' . $counter, $v->hutang)
                            // ->setCellValue('J' . $counter, $v->currency_id)
                            ->setCellValue('J' . $counter, number_format($v->rate_awal, 6, ',', '.'))
                            ->setCellValue('K' . $counter, $v->Total_usd);
                            // ->setCellValue('L' . $counter, number_format($v->rate_akhir, 6, ',', '.'))
                            // ->setCellValue('N' . $counter, $v->Total_usd_rateakhir);
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':K' . $counter)->applyFromArray($styleArray);
                    $counter++;
                }
            }
            $habis = $counter - 1;

            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)
                    ->applyFromArray($header)->getFont()->setSize(10);

            $objPHPExcel->getActiveSheet()->mergeCells('A'. $counter.':G' . $counter);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter,  "Grand Total")
                // ->setCellValue('H' . $counter, "=SUM(H".$awal.":H".$habis.")")
                ->setCellValue('I' . $counter, "=SUM(I".$awal.":I".$habis.")")
                ->setCellValue('K' . $counter, "=SUM(K".$awal.":K".$habis.")");
                // ->setCellValue('N' . $counter, "=SUM(N".$awal.":N".$habis.")");
                $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':K' . $counter)->applyFromArray($styleArray);

            $I = "I".$counter;
            $K = "K".$counter;
            array_push($tot1, $I);
            array_push($tot2, $K);

            $counter++;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter.':K'.$counter);
            $counter++;

        }

        $to1 = "";
        $to2 = "";

        foreach ($tot1 as $l) {
            if($l == end($tot1))
                $tota1 = $l;
            else
                $tota1 = $l."+";

            $to1 = $to1.$tota1;
        }
        $t1 = "=".$to1;

         foreach ($tot2 as $l) {
            if($l == end($tot2))
                $tota2 = $l;
            else
                $tota2 = $l."+";

            $to2 = $to2.$tota2;
        }
        $t2 = "=".$to2;



        $counter++;
        $habis = $counter - 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A'. $counter.':G' . $counter);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter,  "Grand Total ALL")
            // ->setCellValue('H' . $counter, "=SUM(H4:H".$habis.")")
            ->setCellValue('I' . $counter, $t1)
            ->setCellValue('K' . $counter, $t2);
            // ->setCellValue('N' . $counter, "=SUM(N4:N".$habis.")");

        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        
        // $styleArray = array(
        //         'borders' => array(
        //             'allborders' => array(
        //                 'style' => PHPExcel_Style_Border::BORDER_THIN
        //             )
        //         )
        //     );
        //     // $jlh = $jlh + 1;


        // $objPHPExcel->getActiveSheet()->getStyle('A3:K' . $jlh)->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('Payable Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Invoice.xlsx"');
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

    // function toExcel6() {
    //     //error_reporting(E_ALL);
    //     ini_set('display_errors', TRUE);
    //     ini_set('display_startup_errors', TRUE);
    //     date_default_timezone_set('Europe/London');

    //     $sup = $this->input->get('supplier');
    //     $tgl = $this->input->get('periode') . "-01";
    //     $curreny = $this->input->get('currency');
    //     $data = $this->M_Receivable_invoice->call_data($sup, $curreny, $tgl);
    //     if (PHP_SAPI == 'cli')
    //         die('This example should only be run from a Web Browser');
    //     // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


    //     $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

    //     $objPHPExcel->setActiveSheetIndex(0)
    //             // ->setCellValue('A1', $title)
    //             ->setCellValue('A3', 'No')
    //             ->setCellValue('B3', 'Customer ID')
    //             ->setCellValue('C3', 'Customer Name')
    //             ->setCellValue('D3', 'Invoice Number')
    //             ->setCellValue('E3', 'Invoice Date')
    //             ->setCellValue('F3', 'Date Of Journal')
    //             ->setCellValue('G3', 'Due Date')
    //             ->setCellValue('H3', 'Prepaid')
    //             ->setCellValue('I3', 'Total')
    //             ->setCellValue('J3', 'currency')
    //             ->setCellValue('K3', 'Rate')
    //             ->setCellValue('L3', 'Total USD')
    //             ->setCellValue('M3', 'Ending Rate')
    //             ->setCellValue('N3', 'Ending Total');

    //     $no = 1;
    //     $counter = 4;
    //     $uang_muka=0;
    //     $sisa=0;
    //     $Total_usd=0;
    //     $Total_usd_rateakhir=0;
    //     foreach ($data as $v):
    //         $uang_muka += $v->uang_muka;
    //         $sisa += $v->piutang;
    //         $Total_usd += $v->Total_usd;
    //         $Total_usd_rateakhir += $v->Total_usd_rateakhir;
    //         // $balance = 0;
    //         // $balance = $v->begining_balance + $v->purchase  - $v->payment - $v->debet_note + $v->kredit_note;
    //         $objPHPExcel->setActiveSheetIndex(0)
    //                 ->setCellValue('A' . $counter, $no++)
    //                 ->setCellValue('B' . $counter, $v->customer_code)
    //                 ->setCellValue('C' . $counter, $v->customer_name)
    //                 ->setCellValue('D' . $counter, $v->nofaktur)
    //                 ->setCellValue('E' . $counter, $v->tanggal_invoice)
    //                 ->setCellValue('F' . $counter, $v->tanggal)
    //                 ->setCellValue('G' . $counter, $v->tanggal_tempo)
    //                 ->setCellValue('H' . $counter, $v->uang_muka)
    //                 ->setCellValue('I' . $counter, $v->piutang)
    //                 ->setCellValue('J' . $counter, $v->currency_id)
    //                 ->setCellValue('K' . $counter, number_format($v->rate, 6, ',', '.'))
    //                 ->setCellValue('L' . $counter, $v->Total_usd)
    //                 ->setCellValue('M' . $counter, number_format($v->rate_akhir, 6, ',', '.'))
    //                 ->setCellValue('N' . $counter, $v->Total_usd_rateakhir);
    //         $counter++;
    //     endforeach;

    //     $objPHPExcel->getActiveSheet()->mergeCells('A'. $counter.':G' . $counter);
    //     $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A' . $counter,  "Grand Total")
    //         ->setCellValue('H' . $counter, number_format($uang_muka, 2, ".", ","))
    //         ->setCellValue('I' . $counter, number_format($sisa, 2, ".", ","))
    //         ->setCellValue('L' . $counter, number_format($Total_usd, 2, ".", ","))
    //         ->setCellValue('N' . $counter, number_format($Total_usd_rateakhir, 2, ".", ","));




    //     $objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:N3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('J3:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('K3:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('L3:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('M3:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('N3:N'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A'.$counter.':N'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //     $objPHPExcel->getActiveSheet()->setTitle('Receivable Invoice');
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Receivable_Invoice.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    //     header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header('Pragma: public'); // HTTP/1.0
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //     $objWriter->save('php://output');
    //     exit;
    // }

    //error_reporting(E_ALL);
    function toexcel6(){
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        // $tgl = $this->input->get('periode')."-01";

        $p_dari = $this->input->get('dari');
        $p_sampai = $this->input->get('sampai');
        // echo $tgl."<br>";
        $curreny = $this->input->get('currency');


        $data = $this->M_Receivable_invoice->call_data($sup, $curreny, $p_dari, $p_sampai);

        //  print_r($data);
        // die;
        //$supa = $this->M_Receivable_invoice->get_supply($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

         $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

          $rgb = array('rgb'=>'000000');

          $header = array(
                'font'  => array(
                    'bold' => true,
                    'color' => $rgb,
                    'name' => 'Verdana'
                )
            );


        require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
          $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );


        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:G2")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


        
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.000000_);[Red](#,##0.000000)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)'); 
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        //$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        // 
        // $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        // $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        // $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

          $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('A2', 'RECEIVABLE INVOICE AT ('.$p_dari.') - ('.$p_sampai.')')
                ;
        
        $counter = 4;
       // foreach ($supa as $l) {
            // $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)
            //             ->applyFromArray($header)->getFont()->setSize(10);
            // $objPHPExcel->getActiveSheet()->mergeCells('B'.$counter.':I'.$counter);
            $no = 1;
            
            $uang_muka=0;
            $sisa=0;
            $Total_usd=0;
            $Total_usd_rateakhir=0;
            // $objPHPExcel->setActiveSheetIndex(0)
            //         // ->setCellValue('A1', $title)
            //         // ->setCellValue('A'.$counter, $l->customer_code)
            //         ->setCellValue('B'.$counter, $l->customer_name);
            // $counter++;
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
            $objPHPExcel->setActiveSheetIndex(0)
                    // ->setCellValue('A1', $title)
                    ->setCellValue('A'.$counter, 'No')
                    // ->setCellValue('B'.$counter, 'Customer ID')
                    // ->setCellValue('C'.$counter, 'Customer Name')
                    ->setCellValue('B'.$counter, 'Date')
                    ->setCellValue('C'.$counter, 'Customer Name')
                    ->setCellValue('D'.$counter, 'No. Reff')
                    ->setCellValue('E'.$counter, 'Tax Code')
                   // ->setCellValue('E'.$counter, 'Due Date')
                    // ->setCellValue('F'.$counter, 'Prepaid')
                    ->setCellValue('F'.$counter, 'currency')               
                    ->setCellValue('G'.$counter, 'Rate')
                    ->setCellValue('H'.$counter, 'Amount Before GST')    
                   // ->setCellValue('I'.$counter, 'Total USD')
                    // ->setCellValue('J'.$counter, 'PO')
                     ->setCellValue('I'.$counter, 'GST')
                     ->setCellValue('J'.$counter, 'Total')
                    ;
                    // ->setCellValue('K'.$counter, 'Ending Rate')
                    // ->setCellValue('L'.$counter, 'Ending Total');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':J' . $counter)->applyFromArray($styleArray);
            $counter++;
            foreach ($data as $v){
                 if($v->taxcode == 'ZER'){
                    $taxcode='Zero Rate';
                } else if($v->taxcode == 'GST'){
                    $taxcode='GST';
                }else {
                    $taxcode='Out of Scope';
                }
                // if($l->customer_code == $v->customer_code)
                // {
                    $uang_muka += $v->uang_muka;
                    $sisa += $v->piutang;
                    $Total_usd += $v->Total_usd;
                    $Total_usd_rateakhir += $v->Total_usd_rateakhir;
                    // $balance = 0;
                    // $balance = $v->begining_balance + $v->purchase  - $v->payment - $v->debet_note + $v->kredit_note;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no++)
                            // ->setCellValue('B' . $counter, $v->customer_code)
                            // ->setCellValue('C' . $counter, $v->customer_name)
                            ->setCellValue('B' . $counter, $v->tanggal)
                            ->setCellValue('C' . $counter, $v->customer_name)
                            ->setCellValue('D' . $counter, $v->nofaktur)
                           ->setCellValue('E' . $counter, $taxcode)
                           
                           // ->setCellValue('E' . $counter, $v->tanggal_tempo)
                            // ->setCellValue('H' . $counter, $v->uang_muka)
                            ->setCellValue('F' . $counter, $v->currency_id)
                            ->setCellValue('G' . $counter, $v->rate)
                            ->setCellValue('H' . $counter, $v->piutang)
                            
                           // ->setCellValue('I' . $counter, $v->Total_usd)
                          //  ->setCellValue('J' . $counter, $v->PO)
                            ->setCellValue('I' . $counter, $v->gst)
                            ->setCellValue('J' . $counter, $v->piutang)
                            ;
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':J' . $counter)->applyFromArray($styleArray);
                            // ->setCellValue('M' . $counter, number_format($v->rate_akhir, 6, ',', '.'))
                            // ->setCellValue('N' . $counter, $v->Total_usd_rateakhir);
                    $counter++;
                //}
            }

             $objPHPExcel->getActiveSheet()->mergeCells('A'. $counter.':F' . $counter);
             $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter,  "Grand Total")
            //     // ->setCellValue('H' . $counter, number_format($uang_muka, 2, ".", ","))
                 ->setCellValue('H' . $counter, $sisa)
               // ->setCellValue('I' . $counter, $Total_usd)
                ;
                // ->setCellValue('N' . $counter, number_format($Total_usd_rateakhir, 2, ".", ","));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':J' . $counter)->applyFromArray($styleArray);
          //  $counter++;
           // $counter++;

        //}

        




        $objPHPExcel->getActiveSheet()->setTitle('Receivable Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Invoice.xlsx"');
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

    // function toExcel7() {
    //     error_reporting(E_ALL);
    //     ini_set('display_errors', TRUE);
    //     ini_set('display_startup_errors', TRUE);
    //     date_default_timezone_set('Europe/London');

    //     $sup = $this->input->get('supplier');
    //     $coa = $this->input->get('coa');
    //     $from = date('Y-m-d', strtotime($this->input->get('from')));
    //     $to = date('Y-m-d', strtotime($this->input->get('to')));
    //     $cur = $this->input->get('currency');

    //     $data = $this->M_Supplier_card->call_data($sup, $cur,$from, $to, $coa);
    //     if (PHP_SAPI == 'cli')
    //         die('This example should only be run from a Web Browser');
    //     // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


    //     $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

    //     $objPHPExcel->setActiveSheetIndex(0)
    //             // ->setCellValue('A1', $title)
    //             ->setCellValue('A3', 'No')
    //             ->setCellValue('B3', 'Supplier ID')
    //             ->setCellValue('C3', 'Supplier Name')
    //             ->setCellValue('D3', 'Date')
    //             ->setCellValue('E3', 'Description')
    //             ->setCellValue('F3', 'Reference')
    //             ->setCellValue('G3', 'Debet')
    //             ->setCellValue('H3', 'Credit')
    //             ->setCellValue('I3', 'Balance');

    //     $no = 1;
    //     $counter = 4;
    //     $balance = 0;
    //     foreach ($data as $v):
    //         if($v->tmp_balance < 0){
    //             $str = str_replace("-", '', $v->tmp_balance);
    //             $balance = "(".number_format($str, 2, ",", ".") .")";
    //         } else {
    //             $balance = number_format($v->tmp_balance, 2, ",", ".");
    //         }
    //         $objPHPExcel->setActiveSheetIndex(0)
    //                 ->setCellValue('A' . $counter, $no++)
    //                 ->setCellValue('B' . $counter, $v->tmp_kodesup)
    //                 ->setCellValue('C' . $counter, $v->tmp_supplier_name)
    //                 ->setCellValue('D' . $counter, date('d-m-Y',strtotime(($v->tmp_tanggal))))
    //                 ->setCellValue('E' . $counter, $v->tmp_uraian)
    //                 ->setCellValue('F' . $counter, $v->tmp_nojurnal)
    //                 ->setCellValue('G' . $counter, $v->tmp_debet)
    //                 ->setCellValue('H' . $counter, $v->tmp_kredit)
    //                 ->setCellValue('I' . $counter, $v->tmp_balance);
    //         $counter++;
    //     endforeach;
        
    //     $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:I3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //     $objPHPExcel->getActiveSheet()->setTitle('Vendor Card');
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Vendor_card.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    //     header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header('Pragma: public'); // HTTP/1.0
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //     $objWriter->save('php://output');
    //     exit;
    // }

    function toExcel7() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup1 = "";
        $sup = $this->input->get('supplier');
        $coa = $this->input->get('coa');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $cur = $this->input->get('currency');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $rgb = array('rgb'=>'000000');

        $header = array(
            'font'  => array(
                'bold' => true,
                'color' => $rgb,
                'name' => 'Verdana'
            )
        );


        $data = $this->M_Supplier_card->call_data($sup, $cur,$from, $to, $coa);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);


        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                // ->setCellValue('B3', 'Supplier ID')
                // ->setCellValue('C3', 'Supplier Name')
                ->setCellValue('B3', 'Date')
                ->setCellValue('C3', 'Description')
                ->setCellValue('D3', 'Reference')
                ->setCellValue('E3', 'Debet')
                ->setCellValue('F3', 'Credit')
                ->setCellValue('G3', 'Balance');

        $no = 1;
        $counter = 4;
        $balance = 0;
        foreach ($data as $v):
            $sup1 = $v->tmp_supplier_name;
            if($v->tmp_balance < 0){
                $str = str_replace("-", '', $v->tmp_balance);
                $balance = "(".number_format($str, 2, ",", ".") .")";
            } else {
                $balance = number_format($v->tmp_balance, 2, ",", ".");
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    // ->setCellValue('B' . $counter, $v->tmp_kodesup)
                    // ->setCellValue('C' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('B' . $counter, date('d-m-Y',strtotime(($v->tmp_tanggal))))
                    ->setCellValue('C' . $counter, $v->tmp_uraian)
                    ->setCellValue('D' . $counter, $v->tmp_nojurnal)
                    ->setCellValue('E' . $counter, $v->tmp_debet)
                    ->setCellValue('F' . $counter, $v->tmp_kredit)
                    ->setCellValue('G' . $counter, $v->tmp_balance);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:I2')
                        ->applyFromArray($header)->getFont()->setSize(10);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B2', $sup1)
                ->setCellValue('F2', 'Currency')
                ->setCellValue('G2',$cur);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.$counter, "TOTAL")
                ->setCellValue('E'.$counter, "=SUM(E4:E".($counter-1).")")
                ->setCellValue('F'.$counter, "=SUM(F4:F".($counter-1).")")
                ->setCellValue('G'.$counter, "=G".($counter-1));
        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Vendor Card');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vendor_card.xlsx"');
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

    function vendor_zht() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup1 = "";
        $sup = $this->input->get('supplier');
        $coa = $this->input->get('coa');
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $cur = $this->input->get('currency');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $rgb = array('rgb'=>'000000');

        $header = array(
            'font'  => array(
                'bold' => true,
                'color' => $rgb,
                'name' => 'Verdana'
            )
        );


        $data = $this->M_Supplier_card_zht->call_data($sup, $cur,$from, $to, $coa);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);


        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                // ->setCellValue('B3', 'Supplier ID')
                // ->setCellValue('C3', 'Supplier Name')
                ->setCellValue('B3', 'Date')
                ->setCellValue('C3', 'Description')
                ->setCellValue('D3', 'Reference')
                ->setCellValue('E3', 'Debet')
                ->setCellValue('F3', 'Credit')
                ->setCellValue('G3', 'Balance');

        $no = 1;
        $counter = 4;
        $balance = 0;
        foreach ($data as $v):
            $sup1 = $v->tmp_supplier_name;
            if($v->tmp_balance < 0){
                $str = str_replace("-", '', $v->tmp_balance);
                $balance = "(".number_format($str, 2, ",", ".") .")";
            } else {
                $balance = number_format($v->tmp_balance, 2, ",", ".");
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    // ->setCellValue('B' . $counter, $v->tmp_kodesup)
                    // ->setCellValue('C' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('B' . $counter, date('d-m-Y',strtotime(($v->tmp_tanggal))))
                    ->setCellValue('C' . $counter, $v->tmp_uraian)
                    ->setCellValue('D' . $counter, $v->tmp_nojurnal)
                    ->setCellValue('E' . $counter, $v->tmp_debet)
                    ->setCellValue('F' . $counter, $v->tmp_kredit)
                    ->setCellValue('G' . $counter, $v->tmp_balance);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:I2')
                        ->applyFromArray($header)->getFont()->setSize(10);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B2', $sup1)
                ->setCellValue('F2', 'Currency')
                ->setCellValue('G2',$cur);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D'.$counter, "TOTAL")
                ->setCellValue('E'.$counter, "=SUM(E4:E".($counter-1).")")
                ->setCellValue('F'.$counter, "=SUM(F4:F".($counter-1).")")
                ->setCellValue('G'.$counter, "=G".($counter-1));
        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Vendor Card ZHT');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vendor_card_ZHT.xlsx"');
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

    // function toExcel8() {
    //     error_reporting(E_ALL);
    //     ini_set('display_errors', TRUE);
    //     ini_set('display_startup_errors', TRUE);
    //     date_default_timezone_set('Europe/London');

    //     $sup = $this->input->get('supplier');
    //     $coa = $this->input->get('coa');
        
    //     $from = date('Y-m-d', strtotime($this->input->get('from')));
    //     $to = date('Y-m-d', strtotime($this->input->get('to')));
    //     $cur = $this->input->get('currency');
        
    //     $data = $this->M_Customer_card->call_data($sup, $cur,$from, $to,$coa);
        
    //     if (PHP_SAPI == 'cli')
    //         die('This example should only be run from a Web Browser');
    //     // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


    //     $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    //     $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

    //     $objPHPExcel->setActiveSheetIndex(0)
    //         // ->setCellValue('A1', $title)
    //         ->setCellValue('A3', 'No')
    //         ->setCellValue('B3', 'Customer ID')
    //         ->setCellValue('C3', 'Customer Name')
    //         ->setCellValue('D3', 'Date')
    //         ->setCellValue('E3', 'Description')
    //         ->setCellValue('F3', 'Reference')
    //         ->setCellValue('G3', 'Debet')
    //         ->setCellValue('H3', 'Credit')
    //         ->setCellValue('I3', 'Balance');

    //     $no = 1;
    //     $counter = 4;
    //     foreach ($data as $v):
    //         if($v->tmp_balance < 0){
    //             $str = str_replace("-", '', $v->tmp_balance);
    //             $balance = "(".number_format($str, 2, ",", ".") .")";
    //         } else {
    //             $balance = number_format($v->tmp_balance, 2, ",", ".");
    //         }
            
    //         $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A' . $counter, $no++)
    //             ->setCellValue('B' . $counter, $v->tmp_kodecus)
    //             ->setCellValue('C' . $counter, $v->tmp_customer_name)
    //             ->setCellValue('D' . $counter,  date('d-m-Y',strtotime(($v->tmp_tanggal))))
    //             ->setCellValue('E' . $counter, $v->tmp_uraian)
    //             ->setCellValue('F' . $counter, $v->tmp_nojurnal)
    //             ->setCellValue('G' . $counter, $v->tmp_debet)
    //             ->setCellValue('H' . $counter, $v->tmp_kredit)
    //             ->setCellValue('I' . $counter, $v->tmp_balance);
    //         $counter++;
    //     endforeach;
        
    //     $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:I3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //     $objPHPExcel->getActiveSheet()->setTitle('Customer Card');
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Customer_card.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    //     header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header('Pragma: public'); // HTTP/1.0
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //     $objWriter->save('php://output');
    //     exit;
    // }

     function toExcel8() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $coa = $this->input->get('coa');
        
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $cur = $this->input->get('currency');
        
        $data = $this->M_Customer_card->call_data2($sup, $cur,$from, $to,$coa);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);

        // $objPHPExcel->getActiveSheet->freezePane('G2');

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No')
            // ->setCellValue('B3', 'Customer ID')
            // ->setCellValue('C3', 'Customer Name')
            ->setCellValue('B3', 'Date')
            ->setCellValue('C3', 'Description')
            ->setCellValue('D3', 'Reference / Invoice')
            ->setCellValue('E3', 'Debet')
            ->setCellValue('F3', 'Credit')
            ->setCellValue('G3', 'Balance');

        $no = 1;
        $counter = 4;
        $suppll;
        // $cur = $_GET['currency'];
        foreach ($data as $v):
            if($v->tmp_balance < 0){
                $str = str_replace("-", '', $v->tmp_balance);
                $balance = "(".number_format($str, 2, ",", ".") .")";
            } else {
                $balance = number_format($v->tmp_balance, 2, ",", ".");
            }
            
            $suppll = $v->tmp_customer_name;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                // ->setCellValue('B' . $counter, $v->tmp_kodecus)
                // ->setCellValue('C' . $counter, $v->tmp_customer_name)
                ->setCellValue('B' . $counter,  date('d-m-Y',strtotime(($v->tmp_tanggal))))
                ->setCellValue('C' . $counter, $v->tmp_uraian)
                ->setCellValue('D' . $counter, $v->tmp_nojurnal)
                ->setCellValue('E' . $counter, $v->tmp_debet)
                ->setCellValue('F' . $counter, $v->tmp_kredit)
                ->setCellValue('G' . $counter, $v->tmp_balance);
            $counter++;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $suppll)
            ->setCellValue('G2', $cur);

        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$counter, "TOTAL")
            ->setCellValue('E'.$counter, "=SUM(E4:E".($counter-1).")")
            ->setCellValue('F'.$counter, "=SUM(F4:F".($counter-1).")")
            ->setCellValue('G'.$counter, "=G".($counter-1));

        

        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Customer Card');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Customer_card.xlsx"');
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

    function cus_zht() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $coa = $this->input->get('coa');
        
        $from = date('Y-m-d', strtotime($this->input->get('from')));
        $to = date('Y-m-d', strtotime($this->input->get('to')));
        $cur = $this->input->get('currency');
        
        $data = $this->M_Customer_card_zht->call_data2($sup, $cur,$from, $to,$coa);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);

        // $objPHPExcel->getActiveSheet->freezePane('G2');

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No')
            // ->setCellValue('B3', 'Customer ID')
            // ->setCellValue('C3', 'Customer Name')
            ->setCellValue('B3', 'Date')
            ->setCellValue('C3', 'Description')
            ->setCellValue('D3', 'Reference / Invoice')
            ->setCellValue('E3', 'Debet')
            ->setCellValue('F3', 'Credit')
            ->setCellValue('G3', 'Balance');

        $no = 1;
        $counter = 4;
        $suppll;
        // $cur = $_GET['currency'];
        foreach ($data as $v):
            if($v->tmp_balance < 0){
                $str = str_replace("-", '', $v->tmp_balance);
                $balance = "(".number_format($str, 2, ",", ".") .")";
            } else {
                $balance = number_format($v->tmp_balance, 2, ",", ".");
            }
            
            $suppll = $v->tmp_customer_name;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                // ->setCellValue('B' . $counter, $v->tmp_kodecus)
                // ->setCellValue('C' . $counter, $v->tmp_customer_name)
                ->setCellValue('B' . $counter,  date('d-m-Y',strtotime(($v->tmp_tanggal))))
                ->setCellValue('C' . $counter, $v->tmp_uraian)
                ->setCellValue('D' . $counter, $v->tmp_nojurnal)
                ->setCellValue('E' . $counter, $v->tmp_debet)
                ->setCellValue('F' . $counter, $v->tmp_kredit)
                ->setCellValue('G' . $counter, $v->tmp_balance);
            $counter++;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $suppll)
            ->setCellValue('G2', $cur);

        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$counter, "TOTAL")
            ->setCellValue('E'.$counter, "=SUM(E4:E".($counter-1).")")
            ->setCellValue('F'.$counter, "=SUM(F4:F".($counter-1).")")
            ->setCellValue('G'.$counter, "=G".($counter-1));

        

        
        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B3:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C3:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D3:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E3:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F3:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G3:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('H3:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                // ->getActiveSheet()->getStyle('I3:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':G'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Customer Card ZHT');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Customer_card_ZHT.xlsx"');
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

    function toExcel9() {

    }

    function toExcel10() {

    }

    function toExcel11() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Payable_statement->call_data($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Supplier ID')
                ->setCellValue('C3', 'Supplier Name')
                ->setCellValue('D3', 'Invoice Date')
                ->setCellValue('E3', 'Chq No.')
                ->setCellValue('F3', 'Reference Number')
                ->setCellValue('G3', 'Debit Note')
                ->setCellValue('H3', 'Credit Note');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            // $total = 0;
            // $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 = $v->tmp_more120;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->tmp_kodesup)
                    ->setCellValue('C' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('D' . $counter, $v->tmp_inv_date)
                    ->setCellValue('E' . $counter, $v->tmp_chqno)
                    ->setCellValue('F' . $counter, $v->tmp_reference)
                    ->setCellValue('G' . $counter, $v->tmp_debit)
                    ->setCellValue('H' . $counter, $v->tmp_credit);
            $counter++;
        endforeach;

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
        $objWriter->save('php://output');
        exit;
    }

    function toExcel12() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $tgl = $this->input->get('periode') . "/" . date("d");
        $curreny = $this->input->get('currency');
        $data = $this->M_Receivable_statement->call_data($sup, $curreny, $tgl);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'Customer ID')
                ->setCellValue('C3', 'Customer Name')
                ->setCellValue('D3', 'Invoice Date')
                ->setCellValue('E3', 'Chq No.')
                ->setCellValue('F3', 'Reference Number')
                ->setCellValue('G3', 'Debit Note')
                ->setCellValue('H3', 'Credit Note');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            // $total = 0;
            // $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 = $v->tmp_more120;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->tmp_kodesup)
                    ->setCellValue('C' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('D' . $counter, $v->tmp_inv_date)
                    ->setCellValue('E' . $counter, $v->tmp_chqno)
                    ->setCellValue('F' . $counter, $v->tmp_reference)
                    ->setCellValue('G' . $counter, $v->tmp_debit)
                    ->setCellValue('H' . $counter, $v->tmp_credit);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Receivable Statement');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Statement.xlsx"');
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

    function toExcel13() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $coa1 = $this->input->get('coa1');
        $coa2 = $this->input->get('coa2');
        $periode = $this->input->get('period') . "/" . date("d");
        $dat = $this->M_Trial_balance->select_group();
        $data = $this->M_Trial_balance->call_data($coa1, $coa2, $periode);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'COA Number')
                ->setCellValue('C3', 'Account Name')
                ->setCellValue('D3', 'Debit Begining Balance')
                ->setCellValue('E3', 'Credit Begining Balance')
                ->setCellValue('F3', 'Mutations Debit')
                ->setCellValue('G3', 'Mutations Credit')
                ->setCellValue('H3', 'Debit Balance')
                ->setCellValue('I3', 'Credit Balance');

        $no = 1;
        $counter = 4;
        foreach ($dat as $value) :
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->GroupName);
            $counter++;
            foreach ($data as $v):
                if ($v->GroupCOA == $value->id_group):
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $v->NoCOA)
                            ->setCellValue('C' . $counter, $v->AccountName)
                            ->setCellValue('D' . $counter, $v->saldo_awal_debet)
                            ->setCellValue('E' . $counter, $v->saldo_awal_kredit)
                            ->setCellValue('F' . $counter, $v->mutasi_debet)
                            ->setCellValue('G' . $counter, $v->mutasi_kredit)
                            ->setCellValue('H' . $counter, $v->balance_debet)
                            ->setCellValue('I' . $counter, $v->balance_kredit);
                    $counter++;
                endif;

            endforeach;
        endforeach;
        // foreach($data as $v):
        //    $total = 0;
        //    $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 = $v->tmp_more120;
        //    $objPHPExcel->setActiveSheetIndex(0)
        //        ->setCellValue('A'.$counter, $no++)
        //        ->setCellValue('B'.$counter, $v->tmp_supplier_name)
        //        ->setCellValue('C'.$counter, $v->tmp_invno)
        //        ->setCellValue('D'.$counter, $v->tmp_invno)
        //        ->setCellValue('E'.$counter, $v->tmp_due_date)
        //        ->setCellValue('F'.$counter, $v->tmp_not_due_date)
        //        ->setCellValue('G'.$counter, $v->tmp_0sd30)
        //        ->setCellValue('H'.$counter, $v->tmp_31sd60)
        //        ->setCellValue('I'.$counter, $v->tmp_61sd90)
        //        ->setCellValue('J'.$counter, $v->tmp_91sd120)
        //        ->setCellValue('K'.$counter, $v->tmp_more120)
        //        ->setCellValue('L'.$counter, $total);
        //     $counter++;
        // endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Trial Balance');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Trial_balance.xlsx"');
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

    function toExcel14() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $coa1 = '';
        $coa2 = '';
        $periode = $this->input->get('periode') . "/" . date("d");
        $type = $this->input->get('type');
        $data["coa1"] = $this->input->get('coa1');
        $data["coa2"] = $this->input->get('coa2');
        $dat1 = $this->M_Balance_sheet->select_group();
        $data1 = $this->M_Balance_sheet->call_data($periode);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'COA Number')
                ->setCellValue('C3', 'Account Name');

        if ($type == 'tahun'):
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D3', 'Begining Year')
                    ->setCellValue('E3', 'Current Period');
        endif;

        if ($type == 'bulan'):
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D3', 'Begining Month')
                    ->setCellValue('E3', 'Current Period');
        endif;


        $no = 1;
        $counter = 4;
        foreach ($dat1 as $value) :
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->GroupName);
            $counter++;
            foreach ($data1 as $v):
                if ($value->GroupCOA = $v->tmp_coa_groupid):
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $v->tmp_nocoa)
                            ->setCellValue('C' . $counter, $v->tmp_coa_name)
                            ->setCellValue('D' . $counter, $v->tmp_balance_current_periode)
                            ->setCellValue('E' . $counter, $v->tmp_balance_begining_of_year);
                    $counter++;
                endif;

            endforeach;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Trial Balance');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Balance_Sheet.xlsx"');
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

    function toExcel15() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $coa1 = '';
        $coa2 = '';
        $periode = $this->input->get('period') . "/" . date("d");
        $type = $this->input->get('type');
        $data["coa1"] = $this->input->get('coa1');
        $data["coa2"] = $this->input->get('coa2');
        $dat = $this->M_Profit_and_lost->select_group();
        $data = $this->M_Profit_and_lost->call_data($coa1, $coa2, $periode, $type);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')
                ->setCellValue('B3', 'COA Number')
                ->setCellValue('C3', 'Account Name');

        if ($type == 'tahun'):
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D3', 'Current Year')
                    ->setCellValue('E3', 'Last Year');
        endif;

        if ($type == 'bulan'):
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D3', 'Current Month')
                    ->setCellValue('E3', 'Last Month');
        endif;


        $no = 1;
        $counter = 4;
        foreach ($dat as $value) :
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $value->GroupName);
            $counter++;
            foreach ($data as $v):
                if ($value->GroupCOA = $v->tmp_coa_groupid):
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $v->tmp_nocoa)
                            ->setCellValue('C' . $counter, $v->tmp_coa_name)
                            ->setCellValue('D' . $counter, $v->tmp_balance_current_periode)
                            ->setCellValue('E' . $counter, $v->tmp_balance_last_periode);
                    $counter++;
                endif;

            endforeach;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Trial Balance');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_and_Lost.xlsx"');
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
    function toExcelMonRegBook(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari                   = ($this->input->get('dari') === TRUE ? '2016-01-01' : date('Y-m-d', strtotime($this->input->get('dari'))));
        $sampai                 = ($this->input->get('sampai') === TRUE ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->get('sampai'))));
        $coa                    = ($this->input->get('coa') ? $this->input->get('coa') : '140801');

        $data = $this->M_Fin_Report->hasil($dari, $sampai, $coa);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A3:A4")->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->mergeCells("B3:B4")->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->mergeCells("C3:C4")->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->mergeCells("D3:D4")->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->mergeCells("E3:E4")->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->mergeCells("F3:F4")->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->mergeCells("G3:H3")->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("I3:J3")->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->mergeCells("K3:K4")->getColumnDimension('K')->setWidth(20);

        //set aligment header row
        $objPHPExcel->getActiveSheet()->getstyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

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



        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A3', 'No')
            ->setCellValue('B3', 'Date')
            ->setCellValue('C3', 'Reff No')
            ->setCellValue('D3', 'Check NUmber')
            ->setCellValue('E3', 'Currency')
            ->setCellValue('F3', 'Memo')
            ->setCellValue('G3', 'USD Mutation Currency')
            ->setCellValue('G4', 'Debit')
            ->setCellValue('H4', 'Credit')
            ->setCellValue('I3', 'Other Currency Mutation')
            ->setCellValue('I4', 'Debit')
            ->setCellValue('J4', 'Credit')
            ->setCellValue('K3', 'Currency Rate')

        ;

        $no = 1;
        $counter = 5;
        foreach ($data as $v):

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, date('d-m-Y',strtotime($v->date1)))
                ->setCellValue('C' . $counter, $v->no_facture)
                ->setCellValue('D' . $counter, $v->check_bank)
                ->setCellValue('E' . $counter, $v->currency_id)
                ->setCellValue('F' . $counter, $v->trans_description);
            if ($v->currency_id == 'USD'){
                if ($v->debit != 0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$counter, number_format($v->debit, 2));
                }
                if ($v->credit != 0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$counter, number_format($v->credit, 2));
                }
            }
            else {
                if ($v->debit != 0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$counter, number_format($v->debit, 2));
                }
                if ($v->credit != 0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$counter, number_format($v->credit, 2));
                }
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('K' . $counter, number_format($v->currency_rate, 2, '.', ','));



            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A3:K' . ($jlh+1))->applyFromArray($styleArray);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Register Book');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Register_Book.xlsx"');
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

function toExcelPayableAging() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $companyid = $this->session->userdata('company_id');
        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        $curreny = $this->input->get('currency');

        // $data = $this->M_Payable_aging->call_data_aging($sup, $curreny, $periode);
        if($companyid == 2){
            $data = $this->M_Payable_aging->call_data_aging_zht($sup, $curreny, $periode);
            $GroupSupplierID = $this->M_Payable_aging->get_group_supp_zht($periode, $sup, $curreny);
        }else{
            $data = $this->M_Payable_aging->call_data_aging($sup, $curreny, $periode);
            $GroupSupplierID = $this->M_Payable_aging->get_group_supp($periode, $sup, $curreny);
        }
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:L1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:L2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Payable Aging')
                ->setCellValue('A2', date('Y-m-d', strtotime($periode)));

        // $objPHPExcel->setActiveSheetIndex(0)
        //         // ->setCellValue('A1', $title)
        //         //->setCellValue('A3', 'No')

        //         ->setCellValue('B3', 'Vendor')
        //         ->setCellValue('C3', 'Invoice Date')
        //         ->setCellValue('D3', 'Invoice Number')
        //         ->setCellValue('E3', 'Due Date')
        //         ->setCellValue('F3', 'Currency')
        //         ->setCellValue('G3', 'Amount')
        //         ->setCellValue('H3', 'Current')
        //         ->setCellValue('I3', '0 - 30 Days')
        //         ->setCellValue('J3', '31 - 60 Days')
        //         ->setCellValue('K3', '61 - 90 Days')
        //         ->setCellValue('L3', '> 91 Days');
        $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
        $no = 1;
        $counter = 4;
        if (!empty($data)) {
            foreach ($GroupSupplierID as $m):
                $objPHPExcel->getActiveSheet()->getStyle('B'. $counter.':L' . $counter)
                        ->applyFromArray($header)
                        ->getFont()->setSize(10);  
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':L' . $counter);           
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter, $m->suppliercompany.' ('.$m->address.' )');  
                $counter++;               
                $duedate = 0;
                $sd30 = 0;
                $sd60 = 0;
                $sd90 = 0;
                $sd120 = 0;
                $grand_total = 0;
                $gt = 0;
                $gttotal=0;
                $duedatetotal=0;
                $sd30total=0;
                $sd60total=0;
                $sd90total=0;
                $sd120total=0;
                $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B'.$counter, 'Invoice Date')
                    ->setCellValue('C'.$counter, 'Invoice Number')
                    ->setCellValue('D'.$counter, 'Due Date')
                    ->setCellValue('E'.$counter, 'Currency')
                    ->setCellValue('F'.$counter, 'Amount')
                    ->setCellValue('G'.$counter, 'Current')
                    ->setCellValue('H'.$counter, '0 - 30 Days')
                    ->setCellValue('I'.$counter, '31 - 60 Days')
                    ->setCellValue('J'.$counter, '61 - 90 Days')
                    ->setCellValue('K'.$counter, '> 91 Days');
                $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);
                $counter++;
            foreach ($data as $v):              
                if ($v->tmp_kodesup == $m->kode_sup) {
                   $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $duedate += $v->tmp_not_due_date;
                    $sd30 += $v->tmp_0sd30;
                    $sd60 += $v->tmp_31sd60;
                    $sd90 += $v->tmp_61sd90;
                    $sd120 += $v->tmp_91sd120;
                    $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                    $objPHPExcel->setActiveSheetIndex(0)
                            //->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $v->tmp_inv_date)
                            ->setCellValue('C' . $counter, $v->tmp_invno)
                            ->setCellValue('D' . $counter, $v->tmp_due_date)
                            ->setCellValue('E' . $counter, $v->tmp_currency)
                            ->setCellValue('F' . $counter, $total)
                            ->setCellValue('G' . $counter, $v->tmp_not_due_date)
                            ->setCellValue('H' . $counter, $v->tmp_0sd30)
                            ->setCellValue('I' . $counter, $v->tmp_31sd60)
                            ->setCellValue('J' . $counter, $v->tmp_61sd90)
                            ->setCellValue('K' . $counter, ($v->tmp_91sd120+$v->tmp_more120));
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);
                 $counter++; 
               
                }    
                $gttotal +=$v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $duedatetotal += $v->tmp_not_due_date;
                $sd30total += $v->tmp_0sd30;
                $sd60total += $v->tmp_31sd60;
                $sd90total += $v->tmp_61sd90;
                $sd120total += $v->tmp_91sd120 + $v->tmp_more120;                                  
                endforeach;               
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':E' . $counter);                
                $objPHPExcel->setActiveSheetIndex(0)                
                            ->setCellValue('B' . $counter,  "Grand Total")
                            ->setCellValue('F' . $counter, $gt)
                            ->setCellValue('G' . $counter, $duedate)
                            ->setCellValue('H' . $counter, $sd30)
                            ->setCellValue('I' . $counter, $sd60)
                            ->setCellValue('J' . $counter, $sd90)
                            ->setCellValue('K' . $counter, $grand_total);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);
                $counter++; 
                $counter++; 
                endforeach;                
                
                $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                }
                $x = $counter ++;
                $objPHPExcel->getActiveSheet()->getStyle($x)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('B' . $x . ':E' . $x);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $x, 'TOTAL')
                    ->setCellValue('F' . $x, $gttotal)
                    ->setCellValue('G' . $x, $duedatetotal)
                    ->setCellValue('H' . $x, $sd30total)
                    ->setCellValue('I' . $x, $sd60total)
                    ->setCellValue('J' . $x, $sd90total)
                    ->setCellValue('K' . $x, $sd120total)
                    
                    ;
                
                    // $jlh = $jlh + 1;


                // $objPHPExcel->getActiveSheet()->getStyle('A3:K' . $jlh)->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->setTitle('Payable Aging');
                $objPHPExcel->setActiveSheetIndex(0);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Payable_Aging.xlsx"');
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

function toExcelAgedPayableSummary() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        $curreny = $this->input->get('currency');

        $data = $this->M_Aged_Payable_Summary->call_data($sup, $curreny, $periode);
        $GroupSupplierID = $this->M_Aged_Payable_Summary->get_group_supp($periode, $sup, $curreny);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  
        

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Aged Payable Summary')
                ->setCellValue('A2', date('Y-m-d', strtotime($periode)));

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'Supplier')
                ->setCellValue('C4', 'Outstanding')
                ->setCellValue('D4', 'Current')
                ->setCellValue('E4', '0 - 30 Days')
                ->setCellValue('F4', '31 - 60 Days')
                ->setCellValue('G4', '61 - 90 Days')
                ->setCellValue('H4', '> 91 Days')
                ->setCellValue('I4', 'Total (USD)');

        $no = 1;
        $counter = 5;
        $totgt = 0;
        $totduedate = 0;
        $totsd30 = 0;
        $totsd60 = 0;
        $totsd90 = 0;
        $totsd120 = 0;

        foreach ($GroupSupplierID as $m):
            $duedate = 0;
            $sd30 = 0;
            $sd60 = 0;
            $sd90 = 0;
            $sd120 = 0;
            $grand_total = 0;
            $gt = 0;

            foreach ($data as $v):
                if ($v->tmp_kodesup == $m->kode_sup) {
                    $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $duedate += $v->tmp_not_due_date;
                    $sd30 += $v->tmp_0sd30;
                    $sd60 += $v->tmp_31sd60;
                    $sd90 += $v->tmp_61sd90;
                    $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                    $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                }
            endforeach;

            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no)
                            ->setCellValue('B' . $counter, $m->suppliercompany)
                            ->setCellValue('C' . $counter, $gt)
                            ->setCellValue('D' . $counter, $duedate)
                            ->setCellValue('E' . $counter, $sd30)
                            ->setCellValue('F' . $counter, $sd60)
                            ->setCellValue('G' . $counter, $sd90)
                            ->setCellValue('H' . $counter, $sd120)
                            ->setCellValue('I' . $counter, $gt);
            $no++;  
            $counter++;
            $totgt += $gt;
            $totduedate += $duedate;
            $totsd30 += $sd30;
            $totsd60 += $sd60;
            $totsd90 += $sd90;
            $totsd120 += $sd120;
        endforeach;
        
        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, 'GRAND TOTAL')
                            ->setCellValue('C' . $counter, $totgt)
                            ->setCellValue('D' . $counter, $totduedate)
                            ->setCellValue('E' . $counter, $totsd30)
                            ->setCellValue('F' . $counter, $totsd60)
                            ->setCellValue('G' . $counter, $totsd90)
                            ->setCellValue('H' . $counter, $totsd120)
                            ->setCellValue('I' . $counter, $totgt);  
                        
                
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
        $jlh = $jlh;


        $objPHPExcel->getActiveSheet()->getStyle('A4:I' . $jlh)->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('Aged Payable Summary');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Aged_Payable_Summary.xlsx"');
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

function toExcelAgedPayableSummary_zht() {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $sup = $this->input->get('supplier');
    $periode = date('Y-m-d', strtotime($this->input->get('period')));
    $curreny = $this->input->get('currency');

    $data = $this->M_Aged_Payable_Summary_zht->call_data($sup, $curreny, $periode);
    $GroupSupplierID = $this->M_Aged_Payable_Summary_zht->get_group_supp($periode, $sup, $curreny);
    
    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        ); 
    $header2 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
    );  
    

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getStyle("A1:I1")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

    $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true);


    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A1', 'Aged Payable Summary ZHT')
            ->setCellValue('A2', date('Y-m-d', strtotime($periode)));

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Supplier')
            ->setCellValue('C4', 'Outstanding')
            ->setCellValue('D4', 'Current')
            ->setCellValue('E4', '0 - 30 Days')
            ->setCellValue('F4', '31 - 60 Days')
            ->setCellValue('G4', '61 - 90 Days')
            ->setCellValue('H4', '> 91 Days')
            ->setCellValue('I4', 'Total (USD)');

    $no = 1;
    $counter = 5;
    $totgt = 0;
    $totduedate = 0;
    $totsd30 = 0;
    $totsd60 = 0;
    $totsd90 = 0;
    $totsd120 = 0;

    foreach ($GroupSupplierID as $m):
        $duedate = 0;
        $sd30 = 0;
        $sd60 = 0;
        $sd90 = 0;
        $sd120 = 0;
        $grand_total = 0;
        $gt = 0;

        foreach ($data as $v):
            if ($v->tmp_kodesup == $m->kode_sup) {
                $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $duedate += $v->tmp_not_due_date;
                $sd30 += $v->tmp_0sd30;
                $sd60 += $v->tmp_31sd60;
                $sd90 += $v->tmp_61sd90;
                $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
            }
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no)
                        ->setCellValue('B' . $counter, $m->suppliercompany)
                        ->setCellValue('C' . $counter, $gt)
                        ->setCellValue('D' . $counter, $duedate)
                        ->setCellValue('E' . $counter, $sd30)
                        ->setCellValue('F' . $counter, $sd60)
                        ->setCellValue('G' . $counter, $sd90)
                        ->setCellValue('H' . $counter, $sd120)
                        ->setCellValue('I' . $counter, $gt);
        $no++;  
        $counter++;
        $totgt += $gt;
        $totduedate += $duedate;
        $totsd30 += $sd30;
        $totsd60 += $sd60;
        $totsd90 += $sd90;
        $totsd120 += $sd120;
    endforeach;
    
    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, 'GRAND TOTAL')
                        ->setCellValue('C' . $counter, $totgt)
                        ->setCellValue('D' . $counter, $totduedate)
                        ->setCellValue('E' . $counter, $totsd30)
                        ->setCellValue('F' . $counter, $totsd60)
                        ->setCellValue('G' . $counter, $totsd90)
                        ->setCellValue('H' . $counter, $totsd120)
                        ->setCellValue('I' . $counter, $totgt);  
                    
            
    $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


    $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
    $jlh = $jlh;


    $objPHPExcel->getActiveSheet()->getStyle('A4:I' . $jlh)->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->setTitle('Aged Payable Summary ZHT');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Aged_Payable_Summary_zht.xlsx"');
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

function toExcelReceivableAging() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $curreny = $this->input->get('currency');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        // $dari = str_replace('-', '-', $this->input->get('dari'));
        // $p_dari = date('Y-m-d', strtotime($dari));

        // $sampai = str_replace('-', '-', $this->input->get("sampai"));
        // $p_sampai = date('Y-m-d', strtotime($sampai));

        // $data = $this->M_Receivable_aging->call_data($sup, $curreny, $periode);
        // $GroupSupplierID = $this->M_Receivable_aging->get_group_supp($periode, $sup, $curreny);
        $companyid = $this->session->userdata('company_id');
        
        if($companyid == 2){
            $data = $this->M_Receivable_aging->call_data_zht($sup, $curreny, $periode);
            $GroupSupplierID = $this->M_Receivable_aging->get_group_supp_zht($periode, $sup, $curreny);
        }else{
            $data = $this->M_Receivable_aging->call_data($sup, $curreny, $periode);
            $GroupSupplierID = $this->M_Receivable_aging->get_group_supp($periode, $sup, $curreny);
        }
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:L1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:L2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
       //$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        // $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        // $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        //$objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Receivable Aging')
                ->setCellValue('A2', date('Y-m-d', strtotime($periode)));


        // $objPHPExcel->setActiveSheetIndex(0)
        //         // ->setCellValue('A1', $title)
        //         //->setCellValue('A3', 'No')

        //         ->setCellValue('B3', 'Supplier')
        //         ->setCellValue('C3', 'Invoice Date')
        //         ->setCellValue('D3', 'Invoice Number')
        //         ->setCellValue('E3', 'Due Date')
        //         ->setCellValue('F3', 'Current')
        //         ->setCellValue('G3', '0 - 30 Days')
        //         ->setCellValue('H3', '31 - 60 Days')
        //         ->setCellValue('I3', '61 - 90 Days')
        //         ->setCellValue('J3', '> 91 Days')
        //         ->setCellValue('K3', 'Total');
         $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
                    // $jlh = $jlh + 1;


                
        $no = 1;
        $counter = 4;
        if (!empty($data)) {
            foreach ($GroupSupplierID as $m):
                $objPHPExcel->getActiveSheet()->getStyle('B'. $counter.':K' . $counter)
                        ->applyFromArray($header)
                        ->getFont()->setSize(10);  
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':K' . $counter);           
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter, $m->suppliercompany.' ('.$m->customer_address.' )');  
                $counter++;
                $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
                $objPHPExcel->setActiveSheetIndex(0)
                    // ->setCellValue('B'.$counter, 'Supplier')
                    ->setCellValue('B'.$counter, 'Invoice Date')
                    ->setCellValue('C'.$counter, 'Invoice Number')
                    ->setCellValue('D'.$counter, 'Due Date')
                    ->setCellValue('E'.$counter, 'Currency')
                    ->setCellValue('F'.$counter, 'Total')
                    ->setCellValue('G'.$counter, 'Current')
                    ->setCellValue('H'.$counter, '0 - 30 Days')
                    ->setCellValue('I'.$counter, '31 - 60 Days')
                    ->setCellValue('J'.$counter, '61 - 90 Days')
                    ->setCellValue('K'.$counter, '> 91 Days');

                $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);

                $duedate = 0;
                $sd30 = 0;
                $sd60 = 0;
                $sd90 = 0;
                $sd120 = 0;
                $grand_total = 0;
                $gt = 0;
                $gttotal=0;
                $duedatetotal=0;
                $sd30total=0;
                $sd60total=0;
                $sd90total=0;
                $sd120total=0;
                $counter++;
            foreach ($data as $v):
                if ($v->tmp_kodesup == $m->kode_sup) {
                    $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $duedate += $v->tmp_not_due_date;
                    $sd30 += $v->tmp_0sd30;
                    $sd60 += $v->tmp_31sd60;
                    $sd90 += $v->tmp_61sd90;
                    $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                    $grand_total += $v->tmp_91sd120 + $v->tmp_more120;

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $v->tmp_inv_date)
                            ->setCellValue('C' . $counter, $v->tmp_invno)
                            ->setCellValue('D' . $counter, $v->tmp_due_date)
                            ->setCellValue('E' . $counter, $v->tmp_currency)
                            ->setCellValue('F' . $counter, $total)
                            ->setCellValue('G' . $counter, $v->tmp_not_due_date)
                            ->setCellValue('H' . $counter, $v->tmp_0sd30)
                            ->setCellValue('I' . $counter, $v->tmp_31sd60)
                            ->setCellValue('J' . $counter, $v->tmp_61sd90)
                            ->setCellValue('K' . $counter, ($v->tmp_91sd120+$v->tmp_more120));
                 
                 $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);
                 $counter++;

                }
                $gttotal +=$v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $duedatetotal += $v->tmp_not_due_date;
                $sd30total += $v->tmp_0sd30;
                $sd60total += $v->tmp_31sd60;
                $sd90total += $v->tmp_61sd90;
                $sd120total += $v->tmp_91sd120 + $v->tmp_more120;
                endforeach;
                $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':K' . $counter)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':E' . $counter);                
                $objPHPExcel->setActiveSheetIndex(0)                
                            ->setCellValue('B' . $counter,  "Grand Total")
                            ->setCellValue('F' . $counter, $gt)
                            ->setCellValue('G' . $counter, $duedate)
                            ->setCellValue('H' . $counter, $sd30)
                            ->setCellValue('I' . $counter, $sd60)
                            ->setCellValue('J' . $counter, $sd90)
                            ->setCellValue('K' . $counter, $sd120);
                            
                $counter++; 
                $counter++; 
                endforeach;                             
                $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                }
                $x = $counter ++;
                $objPHPExcel->getActiveSheet()->getStyle($x)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('B' . $x . ':E' . $x);
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $x, 'TOTAL')
                    ->setCellValue('F' . $x, $gttotal)
                    ->setCellValue('G' . $x, $duedatetotal)
                    ->setCellValue('H' . $x, $sd30total)
                    ->setCellValue('I' . $x, $sd60total)
                    ->setCellValue('J' . $x, $sd90total)
                    ->setCellValue('K' . $x, $sd120total)
                    
                    ;

                $objPHPExcel->getActiveSheet()->setTitle('Receivable Aging');
                $objPHPExcel->setActiveSheetIndex(0);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Receivable_Aging.xlsx"');
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

function toExcelAgedReceivableSummary() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $periode = date('Y-m-d', strtotime($this->input->get('period')));
        $curreny = $this->input->get('currency');

        $data = $this->M_Aged_Receivable_Summary->call_data($sup, $curreny, $periode);
        $GroupSupplierID = $this->M_Aged_Receivable_Summary->get_group_supp($periode, $sup, $curreny);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:I1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Aged Receivable Summary')
                ->setCellValue('A2', date('Y-m-d', strtotime($periode)));

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'Customer')
                ->setCellValue('C4', 'Outstanding')
                ->setCellValue('D4', 'Current')
                ->setCellValue('E4', '0 - 30 Days')
                ->setCellValue('F4', '31 - 60 Days')
                ->setCellValue('G4', '61 - 90 Days')
                ->setCellValue('H4', '> 91 Days')
                ->setCellValue('I4', 'Total (USD)');

        $no = 1;
        $counter = 5;
        $totgt = 0;
        $totduedate = 0;
        $totsd30 = 0;
        $totsd60 = 0;
        $totsd90 = 0;
        $totsd120 = 0;

        foreach ($GroupSupplierID as $m):
            $duedate = 0;
            $sd30 = 0;
            $sd60 = 0;
            $sd90 = 0;
            $sd120 = 0;
            $grand_total = 0;
            $gt = 0;

            foreach ($data as $v):
                if ($v->tmp_kodesup == $m->kode_sup) {
                    $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    $duedate += $v->tmp_not_due_date;
                    $sd30 += $v->tmp_0sd30;
                    $sd60 += $v->tmp_31sd60;
                    $sd90 += $v->tmp_61sd90;
                    $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                    $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
                }
            endforeach;

            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no)
                            ->setCellValue('B' . $counter, $m->suppliercompany)
                            ->setCellValue('C' . $counter, $gt)
                            ->setCellValue('D' . $counter, $duedate)
                            ->setCellValue('E' . $counter, $sd30)
                            ->setCellValue('F' . $counter, $sd60)
                            ->setCellValue('G' . $counter, $sd90)
                            ->setCellValue('H' . $counter, $sd120)
                            ->setCellValue('I' . $counter, $gt);
            $no++;  
            $counter++;
            $totgt += $gt;
            $totduedate += $duedate;
            $totsd30 += $sd30;
            $totsd60 += $sd60;
            $totsd90 += $sd90;
            $totsd120 += $sd120;
        endforeach;
        
        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, 'GRAND TOTAL')
                            ->setCellValue('C' . $counter, $totgt)
                            ->setCellValue('D' . $counter, $totduedate)
                            ->setCellValue('E' . $counter, $totsd30)
                            ->setCellValue('F' . $counter, $totsd60)
                            ->setCellValue('G' . $counter, $totsd90)
                            ->setCellValue('H' . $counter, $totsd120)
                            ->setCellValue('I' . $counter, $totgt);  
                        
                
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
        $jlh = $jlh;


        $objPHPExcel->getActiveSheet()->getStyle('A4:I' . $jlh)->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('Aged Receivable Summary');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Aged_Receivable_Summary.xlsx"');
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

function toExcelAgedReceivableSummary_zht() {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $sup = $this->input->get('supplier');
    $periode = date('Y-m-d', strtotime($this->input->get('period')));
    $curreny = $this->input->get('currency');

    $data = $this->M_Aged_Receivable_Summary_zht->call_data($sup, $curreny, $periode);
    $GroupSupplierID = $this->M_Aged_Receivable_Summary_zht->get_group_supp($periode, $sup, $curreny);
    
    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        ); 
    $header2 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
    );  

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getStyle("A1:I1")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

    $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true);


    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A1', 'Aged Receivable Summary ZHT')
            ->setCellValue('A2', date('Y-m-d', strtotime($periode)));

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', 'Outstanding')
            ->setCellValue('D4', 'Current')
            ->setCellValue('E4', '0 - 30 Days')
            ->setCellValue('F4', '31 - 60 Days')
            ->setCellValue('G4', '61 - 90 Days')
            ->setCellValue('H4', '> 91 Days')
            ->setCellValue('I4', 'Total (USD)');

    $no = 1;
    $counter = 5;
    $totgt = 0;
    $totduedate = 0;
    $totsd30 = 0;
    $totsd60 = 0;
    $totsd90 = 0;
    $totsd120 = 0;

    foreach ($GroupSupplierID as $m):
        $duedate = 0;
        $sd30 = 0;
        $sd60 = 0;
        $sd90 = 0;
        $sd120 = 0;
        $grand_total = 0;
        $gt = 0;

        foreach ($data as $v):
            if ($v->tmp_kodesup == $m->kode_sup) {
                $total = $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                $duedate += $v->tmp_not_due_date;
                $sd30 += $v->tmp_0sd30;
                $sd60 += $v->tmp_31sd60;
                $sd90 += $v->tmp_61sd90;
                $sd120 += $v->tmp_91sd120 + $v->tmp_more120;
                $grand_total += $v->tmp_91sd120 + $v->tmp_more120;
            }
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no)
                        ->setCellValue('B' . $counter, $m->suppliercompany)
                        ->setCellValue('C' . $counter, $gt)
                        ->setCellValue('D' . $counter, $duedate)
                        ->setCellValue('E' . $counter, $sd30)
                        ->setCellValue('F' . $counter, $sd60)
                        ->setCellValue('G' . $counter, $sd90)
                        ->setCellValue('H' . $counter, $sd120)
                        ->setCellValue('I' . $counter, $gt);
        $no++;  
        $counter++;
        $totgt += $gt;
        $totduedate += $duedate;
        $totsd30 += $sd30;
        $totsd60 += $sd60;
        $totsd90 += $sd90;
        $totsd120 += $sd120;
    endforeach;
    
    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, 'GRAND TOTAL')
                        ->setCellValue('C' . $counter, $totgt)
                        ->setCellValue('D' . $counter, $totduedate)
                        ->setCellValue('E' . $counter, $totsd30)
                        ->setCellValue('F' . $counter, $totsd60)
                        ->setCellValue('G' . $counter, $totsd90)
                        ->setCellValue('H' . $counter, $totsd120)
                        ->setCellValue('I' . $counter, $totgt);  
                    
            
    $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


    $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
    $jlh = $jlh;


    $objPHPExcel->getActiveSheet()->getStyle('A4:I' . $jlh)->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->setTitle('Aged Receivable Summary ZHT');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Aged_Receivable_Summary_zht.xlsx"');
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

function toExcelPayableInvoice() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');

        $data = $this->M_All_Transaction->hasil($dari, $sampai, $jenis_trans);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:N1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:N2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Payable Invoice Transaction')
                ->setCellValue('A2', date('Y-m-d', strtotime($dari)) . ' - ' . date('Y-m-d', strtotime($sampai)));

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'Date')
                ->setCellValue('C4', 'No. Reff')
                ->setCellValue('D4', 'Vendor')
                ->setCellValue('E4', 'Currency')
                ->setCellValue('F4', 'Rate')
                ->setCellValue('G4', 'Tax')
                ->setCellValue('H4', 'Discount')
                ->setCellValue('I4', 'Add Cost')
                ->setCellValue('J4', 'Deposit')
                ->setCellValue('K4', 'Debit Note')
                ->setCellValue('L4', 'Credit Note')
                ->setCellValue('M4', 'Total')
                ->setCellValue('N4', 'Payment');

        $no = 1;
        $counter = 5;
        $totalpajak = 0;
        $totaldiskon = 0;
        $totalbiayalain = 0;
        $totaluang_muka = 0;
        $totalnota_debet = 0;
        $totalnota_kredit = 0;
        $total_hutang = 0;
        $total_bayar = 0;

        foreach ($data as $m):
            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no)
                            ->setCellValue('B' . $counter, $m->tanggal)
                            ->setCellValue('C' . $counter, $m->nofaktur)
                            ->setCellValue('D' . $counter, $m->namavendor)
                            ->setCellValue('E' . $counter, $m->currency_id)
                            ->setCellValue('F' . $counter, $m->rate)
                            ->setCellValue('G' . $counter, $m->pajak)
                            ->setCellValue('H' . $counter, $m->diskon)
                            ->setCellValue('I' . $counter, $m->biaya_lain)
                            ->setCellValue('J' . $counter, $m->uang_muka)
                            ->setCellValue('K' . $counter, $m->nota_debet)
                            ->setCellValue('L' . $counter, $m->nota_kredit)
                            ->setCellValue('M' . $counter, $m->hutang)
                            ->setCellValue('N' . $counter, $m->bayar);
            $no++;  
            $counter++;
            $totalpajak += $m->pajak;
            $totaldiskon+= $m->diskon;
            $totalbiayalain+= $m->biaya_lain;
            $totaluang_muka+= $m->uang_muka;
            $totalnota_debet += $m->nota_debet;
            $totalnota_kredit += $m->nota_kredit;
            $total_hutang += $m->hutang;
            $total_bayar += $m->bayar;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, 'GRAND TOTAL')
                            ->setCellValue('G' . $counter, $totalpajak)
                            ->setCellValue('H' . $counter, $totaldiskon)
                            ->setCellValue('I' . $counter, $totalbiayalain)
                            ->setCellValue('J' . $counter, $totaluang_muka)
                            ->setCellValue('K' . $counter, $totalnota_debet)
                            ->setCellValue('L' . $counter, $totalnota_kredit)
                            ->setCellValue('M' . $counter, $total_hutang)
                            ->setCellValue('N' . $counter, $total_bayar);
                        
                
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
        $jlh = $jlh;


        $objPHPExcel->getActiveSheet()->getStyle('A4:N' . $jlh)->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('Payable Invoice Transaction');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payable_Invoice_Transaction.xlsx"');
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

function toExcelReceivableInvoice2() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $jenis_trans = $this->input->get('jenis_trans');

        $data = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:N1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:N2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Receivable Invoice Transaction')
                ->setCellValue('A2', date('Y-m-d', strtotime($dari)) . ' - ' . date('Y-m-d', strtotime($sampai)));

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'Date')
                ->setCellValue('C4', 'No. Reff')
                ->setCellValue('D4', 'Customer')
                ->setCellValue('E4', 'Currency')
                ->setCellValue('F4', 'Rate')
                ->setCellValue('G4', 'Tax')
                ->setCellValue('H4', 'Discount')
                ->setCellValue('I4', 'Add Cost')
                ->setCellValue('J4', 'Deposit')
                ->setCellValue('K4', 'Debit Note')
                ->setCellValue('L4', 'Credit Note')
                ->setCellValue('M4', 'Total')
                ->setCellValue('N4', 'Payment');

        $no = 1;
        $counter = 5;
        $totalpajak = 0;
        $totaldiskon = 0;
        $totalbiayalain = 0;
        $totaluang_muka = 0;
        $totalnota_debet = 0;
        $totalnota_kredit = 0;
        $total_piutang = 0;
        $total_bayar = 0;

        foreach ($data as $m):
            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no)
                            ->setCellValue('B' . $counter, $m->tanggal)
                            ->setCellValue('C' . $counter, $m->nofaktur)
                            ->setCellValue('D' . $counter, $m->namacustomer)
                            ->setCellValue('E' . $counter, $m->currency)
                            ->setCellValue('F' . $counter, $m->rate)
                            ->setCellValue('G' . $counter, $m->pajak)
                            ->setCellValue('H' . $counter, $m->diskon)
                            ->setCellValue('I' . $counter, $m->biaya_lain)
                            ->setCellValue('J' . $counter, $m->uang_muka)
                            ->setCellValue('K' . $counter, $m->nota_debet)
                            ->setCellValue('L' . $counter, $m->nota_kredit)
                            ->setCellValue('M' . $counter, $m->piutang)
                            ->setCellValue('N' . $counter, $m->bayar);
            $no++;  
            $counter++;
            $totalpajak += $m->pajak;
            $totaldiskon+= $m->diskon;
            $totalbiayalain+= $m->biaya_lain;
            $totaluang_muka+= $m->uang_muka;
            $totalnota_debet += $m->nota_debet;
            $totalnota_kredit += $m->nota_kredit;
            $total_piutang += $m->piutang;
            $total_bayar += $m->bayar;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, 'GRAND TOTAL')
                            ->setCellValue('G' . $counter, $totalpajak)
                            ->setCellValue('H' . $counter, $totaldiskon)
                            ->setCellValue('I' . $counter, $totalbiayalain)
                            ->setCellValue('J' . $counter, $totaluang_muka)
                            ->setCellValue('K' . $counter, $totalnota_debet)
                            ->setCellValue('L' . $counter, $totalnota_kredit)
                            ->setCellValue('M' . $counter, $total_piutang)
                            ->setCellValue('N' . $counter, $total_bayar);
                        
                
        $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
        $jlh = $jlh;


        $objPHPExcel->getActiveSheet()->getStyle('A4:N' . $jlh)->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('Receivable Invoice Transaction');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Invoice_Transaction.xlsx"');
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

function ExcelReceivableMon(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $from = date('Y-m-d', strtotime($this->input->get('from')));
    $to = date('Y-m-d', strtotime($this->input->get('to')));
    $customer = $this->input->get('customer');
    $item = $this->input->get('item');
    $invtype = $this->input->get('invtype');


    $data =  $this->M_Receivable_recognition_tims->receivable_recognition_zht_filter($from, $to, $customer, $item, $invtype);

    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        ); 
    $header2 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
    );
    $objPHPExcel = new PHPExcel();

    // ini content body nya
    $objPHPExcel->getActiveSheet()->getStyle("A1:O1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
    $objPHPExcel->getActiveSheet()->getStyle("A2:O2")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);

    $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
        ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A1', 'Receivable Recognition ZHT Report')
            ->setCellValue('A2', date('Y-m-d', strtotime($from)) . ' - ' . date('Y-m-d', strtotime($to)));

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Reff Number')
            ->setCellValue('C4', 'Invoice Date')
            ->setCellValue('D4', 'Journal Date')
            ->setCellValue('E4', 'Delivery Date')
            ->setCellValue('F4', 'Customer')
            ->setCellValue('G4', 'Item ID')
            ->setCellValue('H4', 'Item Name')
            ->setCellValue('I4', 'Sales Account')
            ->setCellValue('J4', 'Qty')
            ->setCellValue('K4', 'Price')
            ->setCellValue('L4', 'Amount')
            ->setCellValue('M4', 'USD Equivalent')
            ->setCellValue('N4', 'GST Type')
            ->setCellValue('O4', 'GST Value');
    
    $no = 1;
    $counter = 5;
    foreach($data as $payable){
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no)
                        ->setCellValue('B' . $counter, $payable->nofaktur)
                        ->setCellValue('C' . $counter, date('Y-m-d', strtotime($payable->tanggal_invoice)))
                        ->setCellValue('D' . $counter, date('Y-m-d', strtotime($payable->tanggal)))
                        ->setCellValue('E' . $counter, date('Y-m-d', strtotime($payable->shipmentdate)))
                        ->setCellValue('F' . $counter, $payable->customer_name)
                        ->setCellValue('G' . $counter, $payable->no_po)
                        ->setCellValue('H' . $counter, $payable->Items)
                        ->setCellValue('I' . $counter, $payable->NoCOA . '-' . $payable->dept_code . '-002')
                        ->setCellValue('J' . $counter, number_format($payable->Qty, 2))
                        ->setCellValue('K' . $counter, number_format($payable->Harga, 2))
                        ->setCellValue('L' . $counter, number_format($payable->Qty * $payable->Harga, 2))
                        ->setCellValue('M' . $counter, number_format($payable->Qty * $payable->Harga * $payable->rate, 2))
                        ->setCellValue('N' . $counter, $payable->gst_type)
                        ->setCellValue('O' . $counter, number_format($payable->gst_value, 2));
        $no++;  
        $counter++;
    }

    $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


    $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
    $jlh = $jlh;


    $objPHPExcel->getActiveSheet()->getStyle('A4:O' . $jlh)->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->setTitle('Receivable Recog ZHT Report');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Receivable_ZHT_Report.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

function selectReportCBMonthly(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $dari = $this->input->get('from');
    $sampai = $this->input->get('to');
    $trans = $this->input->get('trans_type');

    $data = $this->M_Fin_CB->selectCBTransReport($dari, $sampai, $trans);

    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        ); 
    $header2 = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
    );
    $objPHPExcel = new PHPExcel();
    
    // ini content body nya
    $objPHPExcel->getActiveSheet()->getStyle("A1:H1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    $objPHPExcel->getActiveSheet()->getStyle("A2:H2")
            ->applyFromArray($header2)
            ->getFont()->setSize(11);
    $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);

    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
    $objPHPExcel->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
        ->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A1', 'CB Trans Report')
            ->setCellValue('A2', date('Y-m-d', strtotime($dari)) . ' - ' . date('Y-m-d', strtotime($sampai)));

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'Reff Number')
            ->setCellValue('C4', 'Date')
            ->setCellValue('D4', 'Code')
            ->setCellValue('E4', 'From/To')
            ->setCellValue('F4', 'Description')
            ->setCellValue('G4', 'Currency')
            ->setCellValue('H4', 'Amount');
    $no = 1;
    $counter = 5;
    foreach ($data as $cb):
        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no)
                        ->setCellValue('B' . $counter, $cb->no_reff)
                        ->setCellValue('C' . $counter, date('Y-m-d', strtotime($cb->date1)))
                        ->setCellValue('D' . $counter, $cb->cashbank_code)
                        ->setCellValue('E' . $counter, $cb->from_to)
                        ->setCellValue('F' . $counter, $cb->trans_description)
                        ->setCellValue('G' . $counter, $cb->currency_id)
                        ->setCellValue('H' . $counter, $cb->amount);
        $no++;  
        $counter++;
    endforeach;

    $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


    $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
    $jlh = $jlh;


    $objPHPExcel->getActiveSheet()->getStyle('A4:H' . $jlh)->applyFromArray($styleArray);

    $objPHPExcel->getActiveSheet()->setTitle('CB Trans Report');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="CB_Trans_Report.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return $this->getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

function toExcelReceivableInvoice(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');

    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');
    $jenis_trans = $this->input->get('jenis_trans');
    $noreference = $this->input->get('noreference');
    $jenis_coa = $this->input->get('jenis_coa');
    // $data['jenis_trans'] = $this->M_All_Transaction_rec->get_jenis_trans();
    // $data['jenis_coa'] = $this->M_All_Transaction_rec->get_coa();
    $_vendor = $this->M_All_Transaction_rec->hasil_vendor_2($dari, $sampai, $jenis_trans); // tambahan baru
      $_tampil_item = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans);

    if (PHP_SAPI == 'cli')
        die('This example should only be run from a web Browser');

    $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );      

    $rgb = array('rgb' => '000000');
    $header = array(
        'font' => array(
            'bold' => true,
            'color' => $rgb,
            'name' => 'Verdana'
        )
    );


    require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    for($i=1; $i<=13; $i++){
        $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($i))->setWidth(20);
        if($i > 5){
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($i))->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        }
    }

    $counter = 4;

    if(!empty($_vendor)){
        foreach ($_vendor as $v) {
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($counter+1).':I'.($counter+1))
                        ->applyFromArray($header)->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$counter.':I'.$counter);
            $objPHPExcel->getActiveSheet()->mergeCells('B'.($counter+1).':I'.($counter+1));

            $no = 1;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$counter, $v->namacustomer);

            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$counter, $v->addres);

            $counter++;
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':I'.$counter)->applyFromArray($header)->getFont()->setSize(10);

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'NO')
                ->setCellValue('B'.$counter, 'Date')
                ->setCellValue('C'.$counter, 'No. Reff')
                ->setCellValue('D'.$counter, 'Currency')
                ->setCellValue('E'.$counter, 'Rate')
                ->setCellValue('F'.$counter, 'Tax')
                ->setCellValue('G'.$counter, 'Discount')
                ->setCellValue('H'.$counter, 'Add Cost')
                ->setCellValue('I'.$counter, 'Deposit')
                ->setCellValue('J'.$counter, 'Debit Note')
                ->setCellValue('K'.$counter, 'Credit Note')
                ->setCellValue('L'.$counter, 'Total')
                ->setCellValue('M'.$counter, 'Payment');

            $uh = $counter;
            $counter++;
            $sum = $counter;

          

            if(!empty($_tampil_item)){
                foreach ($_tampil_item as $m) {
                    if($v->kode_sup == $m->kode_sup)
                    {
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, $no)
                            ->setCellValue('B' . $counter, $m->tanggal)
                            ->setCellValue('C' . $counter, $m->nofaktur)
                            ->setCellValue('D' . $counter, $m->currency)
                            ->setCellValue('E' . $counter, $m->rate)
                            ->setCellValue('F' . $counter, $m->pajak)
                            ->setCellValue('G' . $counter, $m->diskon)
                            ->setCellValue('H' . $counter, $m->biaya_lain)
                            ->setCellValue('I' . $counter, $m->uang_muka)
                            ->setCellValue('J' . $counter, $m->nota_debet)
                            ->setCellValue('K' . $counter, $m->nota_kredit)
                            ->setCellValue('L' . $counter, $m->piutang)
                            ->setCellValue('M' . $counter, $m->bayar);
                        $no++;  
                        $counter++;
                    }
                }
            }
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter.':E'.$counter);
            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $counter, 'TOTAL')
                            ->setCellValue('F' . $counter,'=SUM(F'.$sum.':F'.($counter-1).')')
                            ->setCellValue('G' . $counter,'=SUM(G'.$sum.':G'.($counter-1).')')
                            ->setCellValue('H' . $counter,'=SUM(H'.$sum.':H'.($counter-1).')')
                            ->setCellValue('I' . $counter,'=SUM(I'.$sum.':I'.($counter-1).')')
                            ->setCellValue('J' . $counter,'=SUM(J'.$sum.':J'.($counter-1).')')
                            ->setCellValue('K' . $counter,'=SUM(K'.$sum.':K'.($counter-1).')')
                            ->setCellValue('L' . $counter,'=SUM(L'.$sum.':L'.($counter-1).')')
                            ->setCellValue('M' . $counter,'=SUM(M'.$sum.':M'.($counter-1).')');

            $objPHPExcel->getActiveSheet()->getStyle('A'.$uh.':M' . $counter)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$counter.':M'.$counter)
                        ->applyFromArray($header)->getFont()->setSize(10);
            $counter++;
            $counter++;
        }
    }


    $objPHPExcel->getActiveSheet()->setTitle('All Transaction Receivable');
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="All_Transaction_Receivable.xlsx"');
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

    function toExcelReceivableAging2() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $sup = $this->input->get('supplier');
        $currency = $this->input->get('currency');

        $dari = str_replace('-', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('-', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        //$sup = $this->input->get('supplier');
        //$tgl = $this->input->get('periode') . "/" . date("d");
        //$curreny = $this->input->get('currency');

        $data = $this->M_Receivable_aging->call_data($sup, $currency, $p_dari, $p_sampai);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')

                ->setCellValue('B3', 'Supplier')
                ->setCellValue('C3', 'Invoice Date')
                ->setCellValue('D3', 'Invoice Number')
                ->setCellValue('E3', 'Due Date')
                ->setCellValue('F3', 'Currency')
                ->setCellValue('G3', 'Current')
                ->setCellValue('H3', '0 - 30 Days')
                ->setCellValue('I3', '31 - 60 Days')
                ->setCellValue('J3', '61 - 90 Days')
                ->setCellValue('K3', '> 91 Days')
                ->setCellValue('L3', 'Total');

        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            $total = 0;
            $more120 = 0;
            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $total = $v->tmp_not_due_date+$v->tmp_0sd30+$v->tmp_31sd60+$v->tmp_61sd90+$v->tmp_91sd120+$v->tmp_more120;
            $more120 = $v->tmp_91sd120+$v->tmp_more120;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++)
                    ->setCellValue('B' . $counter, $v->tmp_supplier_name)
                    ->setCellValue('C' . $counter, $v->tmp_inv_date)
                    ->setCellValue('D' . $counter, $v->tmp_invno)
                    ->setCellValue('E' . $counter, $v->tmp_due_date)
                    ->setCellValue('F' . $counter, $v->tmp_currency)
                    ->setCellValue('G' . $counter, $v->tmp_not_due_date)
                    ->setCellValue('H' . $counter, $v->tmp_0sd30)
                    ->setCellValue('I' . $counter, $v->tmp_31sd60)
                    ->setCellValue('J' . $counter, $v->tmp_61sd90)
                    ->setCellValue('K' . $counter, $more120)
                    ->setCellValue('L' . $counter, $total);
            $counter++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('F' . $counter,  "Grand Total")
                    ->setCellValue('G' . $counter, '=SUM(G3:G' . $jlh . ')')
                    ->setCellValue('H' . $counter, '=SUM(H3:H' . $jlh . ')')
                    ->setCellValue('I' . $counter, '=SUM(I3:I' . $jlh . ')')
                    ->setCellValue('J' . $counter, '=SUM(J3:J' . $jlh . ')')
                    ->setCellValue('K' . $counter, '=SUM(K3:K' . $jlh . ')')
                    ->setCellValue('L' . $counter, '=SUM(L3:L' . $jlh . ')');

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $jlh = $jlh + 1;

            $objPHPExcel->getActiveSheet()->getStyle('A3:L' . $jlh)->applyFromArray($styleArray);
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Receivable Aging');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Receivable_Aging.xlsx"');
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

function toExcelDailyReport() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');


        $coa = $this->input->get('coa');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');

        //$sup = $this->input->get('supplier');
        //$tgl = $this->input->get('periode') . "/" . date("d");
        //$curreny = $this->input->get('currency');

        //$data = $this->M_Fin_Report->get_coaca($coa);
        //$data = $this->M_Fin_Report->hitung_dailybegin($coa, $coa);
        $data = $this->M_Fin_Report->get_daily($dari, $sampai, $coa);


        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'No')

                ->setCellValue('B3', 'Name')
                ->setCellValue('C3', 'Remark')
                ->setCellValue('D3', 'Number Reference')
                ->setCellValue('E3', 'Debit')
                ->setCellValue('F3', 'Kredit')
                ->setCellValue('G3', 'Balance')
                ->setCellValue('H3', 'Created By')
                ->setCellValue('I3', 'Created Date')
                ->setCellValue('J3', 'Date');
        $no = 1;
        $counter2 = 4;
        $totalbegining= 0;

        if(!empty($_begining)){
            $begin = $_begining->saldo_awal;
        }
        else
        {
            $begin = 0;
        }

        if(!empty($_begin)){
        $bein = $_begin->jumlah1;
        }
        else{
            $bein = 0;
        }
        $totalbegining = $begin + $bein;
        $totalcredit = 0;
        $totaldebit = 0;

        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('G' . $counter2, $totalbegining);

        $counter = 5;
            foreach ($data as $v):
                $totalbegining = $totalbegining + $v->jumlah;
                $totalcredit += $v->credit;
                $totaldebit += $v->debit;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no++)
                        ->setCellValue('B' . $counter, $v->coa_description)
                        ->setCellValue('C' . $counter, $v->trans_description)
                        ->setCellValue('D' . $counter, $v->no_facture)
                        ->setCellValue('E' . $counter, $v->debit)
                        ->setCellValue('F' . $counter, $v->credit)
                        ->setCellValue('G' . $counter, $totalbegining)
                        ->setCellValue('H' . $counter, $v->created_by)
                        ->setCellValue('I' . $counter, $v->created_date)
                        ->setCellValue('J' . $counter, $v->date1);
                $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Daily Report');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Daily_report.xlsx"');
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

function toExcelTrialBalance() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $companyid = $this->session->userdata('company_id');
        $p_dari = $this->input->get('dari');
        $p_sampai = $this->input->get('sampai');
        $type = $this->input->get('type');

        if ($companyid == 2) {
            if ($type=='USD') {
                $data= $this->M_Trial_balance->call_data_zht($p_dari, $p_sampai);
            }else{
                $data= $this->M_Trial_balance->call_data_zht_sgd($p_dari, $p_sampai);
            }
            
            $company = 'ZHENGHE TRANSPORT PTE LTD';
        }else{
            if (date('Y', strtotime($p_dari)) > 2024) {
                $data = $this->M_Trial_balance->call_data_baruuuuuuuuuuuuuuuu($p_dari, $p_sampai);
            } else {
                $data = $this->M_Trial_balance->call_data($p_dari, $p_sampai);
            }

            $company = 'ZHENGHE LOGISTIC PTE LTD';
        }
        
            

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();  
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:G2")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', $company)
                ->setCellValue('A2', 'TRIAL BALANCE AT ('.$p_dari.') - ('.$p_sampai.')')
                ->setCellValue('A3', 'No')

                ->setCellValue('B3', 'No COA')
                ->setCellValue('C3', '')
                ->setCellValue('D3', 'Debet')
                ->setCellValue('E3', 'Credit')
                ->setCellValue('F3', 'YTD Debet')
                ->setCellValue('G3', 'YTD Kredit');        

        $no = 1;        
        $counter = 5;
        $begining = 0;
        $TDR = 0;
        $TCR = 0;
        if ($this->input->get('type') == 'USD') {
                $type = 'US$';
            } else {
                $type = 'SGD$';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C4', "")
                    ->setCellValue('D4', $type)
                    ->setCellValue('E4', $type)
                    ->setCellValue('F4', $type)
                    ->setCellValue('G4', $type);
                    
        foreach ($data as $v):           
           // $begining = $v->saldo_awal_debet - $v->saldo_awal_kredit;
            $DR = $v->MTDebet;
            $CR = $v->MTKredit;
        $YTDR = $v->EBDebet;
            $YTCR = $v->EBKredit;


            $TDR += $v->MTDebet;
            $TCR += $v->MTKredit;
        $YTDR += $v->EBDebet;
            $YTCR += $v->EBKredit;

            //$mutasi = $v->mutasi_debet - $v->mutasi_kredit;
            if ($DR < 0) {
                $b = str_replace("-", "", $DR);
                $DR = "" . number_format($b, 2, '.', ',') . "";
            } elseif ($DR == 0) {
                $DR = '-';
            } else {
                $DR = number_format($DR, 2, '.', ',');
            }

            if ($CR < 0) {
                $b = str_replace("-", "", $CR);
                $CR = "" . number_format($b, 2, '.', ',') . "";
            } elseif ($CR == 0) {
                $CR = '-';
            } else {
                $CR = number_format($CR, 2, '.', ',');
            }
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $counter, $no++)
                        ->setCellValue('B' . $counter, $v->no_coa)
                        ->setCellValue('C' . $counter, $v->nama_akun)
                        ->setCellValue('D' . $counter, $v->MTDebet)
                        ->setCellValue('E' . $counter, $v->MTKredit)
                        ->setCellValue('F' . $counter, $v->EBDebet)
                        ->setCellValue('G' . $counter, $v->EBKredit);
                $counter++;
               $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
         $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C' . $counter, "Grand Total")
                    ->setCellValue('D' . $counter, '=SUM(D4:D' . $jlh . ')')
                    ->setCellValue('E' . $counter, '=SUM(E4:E' . $jlh . ')')
                    ->setCellValue('F' . $counter, '=SUM(F4:F' . $jlh . ')')
                    ->setCellValue('G' . $counter, '=SUM(G4:G' . $jlh . ')');

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            //$jlh = $jlh + 1;

            //$objPHPExcel->getActiveSheet()->getStyle('A3:N' . $jlh)->applyFromArray($styleArray);
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Trial Balance');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Trial_Balance.xlsx"');
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

    function toExcelProfit_Loss()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        /*$tahun = $this->input->get('period');
        $cur = $this->input->get('type');

        $get_invoice = $this->M_Profit_and_lost->call_data_profit($tahun, '0');
        $get_sales = $this->M_Profit_and_lost->call_data_profit($tahun, '8');
        $get_opening = $this->M_Profit_and_lost->call_data_profit($tahun, '4'); // 7
        $get_purchase = $this->M_Profit_and_lost->call_data_profit($tahun, '6');
        $get_freight = $this->M_Profit_and_lost->call_data_profit($tahun, '5');
        $get_closing = $this->M_Profit_and_lost->call_data_profit($tahun, '4');
        $get_gross = $this->M_Profit_and_lost->call_data_profit($tahun, '3');
        $get_bank = $this->M_Profit_and_lost->call_data_profit($tahun, '2');
        $get_other = $this->M_Profit_and_lost->call_data_profit($tahun, '1');
*/


        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $bulan_awal = date('m', strtotime($this->input->get('dari')));
        $awal = date('Y-m-d', strtotime($this->input->get('dari')));

        $bulan_akhir = date('m', strtotime($this->input->get('sampai')));

        $tahun_awal = date('Y', strtotime($this->input->get('dari')));
        $tahun_akhir = date('Y', strtotime($this->input->get('sampai')));

        $jumlah_bulan = (int) (strtotime($p_sampai) - strtotime($p_dari)) / (60 * 60 * 24 * 30);

        $get_invoice = $this->M_Profit_and_loss->call_data_profit($p_dari, $p_sampai, '0');


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1' , 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('A2' , 'Reg No. 201734570K')
            ->setCellValue('A4' , 'TRADING, PROFIT & LOSS A?C FOR THE PERIOD ');


        if (!empty($get_invoice)) {


            //nilai string
            $bln_awal = $bulan_awal - 1;
            $bln_akhir = $bulan_akhir - 1;
            $subtotal_sales = "SELECT SUM(Debet)- SUM(Kredit)  as subsales FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '4001%'";
            $subtotal_opening = "SELECT SUM(Debet)- SUM(Kredit)  as subopening FROM acc_tbl_trn_jurnal where "
                . "          (MONTH(Tanggal)  BETWEEN '$bln_awal' and '$bln_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '1101%')"
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '1201%') ";
            $subtotal_purchase = "SELECT SUM(Debet)- SUM(Kredit)  as subpurchase FROM acc_tbl_trn_jurnal where "
                . "             (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5002%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5001%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5003%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5004%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5005%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA = '200104')";
            $subtotal_freight = "SELECT SUM(Debet)- SUM(Kredit)  as subfreight FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA IN ('410201', '620018', '620019')";
            $subtotal_closing = "SELECT SUM(Debet)- SUM(Kredit)  as subclosing FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '1101%'"
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '1201%') ";
            $subtotal_bank = "SELECT SUM(Debet)- SUM(Kredit)  as subbank FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA = '410208'";
            $subtotal_other = "SELECT SUM(Debet)- SUM(Kredit)  as subother FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA = '410206'";


            $col = 1;
            $objPHPExcel->getActiveSheet()->getstyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $no = 0;
            $w = 0;
            $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');

            $rowheadertahun=7;
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $bln = $tahun_awal;
                $dateObj = DateTime::createFromFormat('!Y', $bln);
                $Bln = strtoupper($dateObj->format('Y'));

                $nomor = $bulan_awal + $w++;
                if ($nomor > 12) {
                    $tahun = $Bln + 1;
                } else {
                    $tahun = $Bln;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'7',$tahun);

                $colStringHdr++;
            }
            if ($jumlah_bulan > 1) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'7',$tahun);
                $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');

            }

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $bln = $bulan_awal + $no++;
                $dateObj = DateTime::createFromFormat('!m', $bln);
                $namaBln = strtoupper($dateObj->format('M'));

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'8',$namaBln);

                $colStringHdr++;
            }
            if ($jumlah_bulan > 1) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'8',$namaBln);

            }

            /*$jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B7',$tahun)
                ->setCellValue('B8',$cur)
                ->setCellValue('B9','NOV')
                ->setCellValue('C7',$tahun)
                ->setCellValue('C8',$cur)
                ->setCellValue('C9','OCT')
                ->setCellValue('D7',$tahun)
                ->setCellValue('D8',$cur)
                ->setCellValue('D9','SEP')
                ->setCellValue('E7',$tahun)
                ->setCellValue('E8',$cur)
                ->setCellValue('E9','AUG')
                ->setCellValue('F7',$tahun)
                ->setCellValue('F8',$cur)
                ->setCellValue('F9','JUL')
                ->setCellValue('G7',$tahun)
                ->setCellValue('G8',$cur)
                ->setCellValue('G9','JUN')
                ->setCellValue('H7',$tahun)
                ->setCellValue('H8',$cur)
                ->setCellValue('H9','MAY')
                ->setCellValue('I7',$tahun)
                ->setCellValue('I8',$cur)
                ->setCellValue('I9','APR')
                ->setCellValue('J7',$tahun)
                ->setCellValue('J8',$cur)
                ->setCellValue('J9','Mar')
                ->setCellValue('K7',$tahun)
                ->setCellValue('K8',$cur)
                ->setCellValue('K9','Feb')
                ->setCellValue('L7','2015 to 2016')
                ->setCellValue('L8',$cur)
                ->setCellValue('L9','DEC-JAN')
                ->setCellValue('M7',$tahun)
                ->setCellValue('M8',$cur)
                ->setCellValue('M9','TOTAL')
            ;

            $styleArray = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            );*/

           /* $objPHPExcel->getActiveSheet()->getStyle('A7:A9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B7:B9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('C7:C9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('D7:D9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('E7:E9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('F7:F9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('G7:G9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H7:H9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('I7:I9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('J7:J9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('K7:K9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('L7:L9')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('M7:M9')->applyFromArray($styleArray);*/


            //sales
            $s1 = 0;
            $colStringsales = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A9','SALES');

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan = $bulan_awal + $s1++;
                $dateObj = DateTime::createFromFormat('!m', $blan);
                $monthName = $dateObj->format('m');

                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));
                $bln = $monthName;

                $total_sales = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '4001%'");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $sales = 0 - $r->t_1;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringsales.'9',str_replace("$", "", money_format('%(#10n', $sales)));

                        $colStringsales++;
                        //echo str_replace("$", "", money_format('%(#10n', $sales));

                    }
                }
            }
            if ($jumlah_bulan > 1) {
                $sql_sales = $this->db->query($subtotal_sales);
                if ($sql_sales->num_rows() > 0) {
                    foreach ($sql_sales->result() as $r) {
                        $subsales = 0 - $r->subsales;
                    }
                }
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringsales.'9',str_replace("$", "", money_format('%(#10n', $subsales)));

            }




            //opening
            $op1 = 0;
            $colStringopening = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A10','OPENING STOCK');

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan = ($bulan_awal - 1) + $op1++;
                $dateObj = DateTime::createFromFormat('!m', $blan);
                $monthName = $dateObj->format('m');
                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));
                $bln = $monthName;

                $total_opening = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%') or (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $opening = 0 - $r->t_1;
                        $total_opening += 0 - $r->t_1;
                        //str_replace("$", "", money_format('%(#10n', $bln_str));
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringopening.'10',str_replace("$", "", money_format('%(#10n', $opening)));

                        $colStringopening++;

                    }
                }
            }
            if ($jumlah_bulan > 1) {
                $sql = $this->db->query($subtotal_opening);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $ttl_2 = 0 - $r->subopening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringopening.'10',str_replace("$", "", money_format('%(#10n', $ttl_2)));
                    }
                }
            }

            //purchase
            $pur2 = 0;
            $colStringpurchase = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A11','PURCHASE');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan_pur = $bulan_awal + $pur2++;
                $dateObj_pur = DateTime::createFromFormat('!m', $blan_pur);
                $monthName_pur = $dateObj_pur->format('m');
                $bln_pur = $monthName_pur;


                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahun_pur = strtoupper($dateObjt->format('Y'));

                $total_purchase = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_purchase FROM acc_tbl_trn_jurnal where "
                    . "                 MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5002%' "
                    . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5001%') "
                    . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5003%') "
                    . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5004%') "
                    . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5005%') "
                    . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA = '200104')");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $purchase = 0 - $r->t_purchase;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringpurchase.'11',str_replace("$", "", money_format('%(#10n', $purchase)));

                        $colStringpurchase++;

                    }
                }
            }
            if ($jumlah_bulan > 1) {
                $sql = $this->db->query($subtotal_purchase);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $total_purchase = 0 - $r->subpurchase;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringpurchase.'11',str_replace("$", "", money_format('%(#10n', $total_purchase)));

                    }
                }
            }

            //total purchase + Opening stock
            $pur1 = 0;
            $op2 = 0;
            $colStringpurop = PHPExcel_Cell::stringFromColumnIndex('1');

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan = $bulan_awal + $pur1++;
                $dateObj = DateTime::createFromFormat('!m', $blan);
                $monthName = $dateObj->format('m');
                $bln = $monthName;

                $bulan = ($bulan_awal - 1) + $op2++;
                $dateObje = DateTime::createFromFormat('!m', $bulan);
                $opmonthName = $dateObje->format('m');
                $op_bln = $opmonthName;

                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));

                $total_purchase = 0;

                $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_opening FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql2->num_rows() > 0) {
                    foreach ($sql2->result() as $s) {
                        $z_opening = 0 - $s->z_opening;
                    }
                }

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_purchase FROM acc_tbl_trn_jurnal where "
                    . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $pur_op = (0 - $r->z_purchase) + $z_opening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringpurop.'12',str_replace("$", "", money_format('%(#10n', $pur_op)));

                        $colStringpurop++;
                    }
                }
            }

            if ($jumlah_bulan > 1) {
                $sql = $this->db->query($subtotal_opening);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $ttl_2i = 0 - $r->subopening;
                    }
                }
                $sqld = $this->db->query($subtotal_purchase);
                if ($sqld->num_rows() > 0) {
                    foreach ($sqld->result() as $r) {
                        $total_purchase = (0 - $r->subpurchase) + $ttl_2i;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringpurop.'12',str_replace("$", "", money_format('%(#10n', $total_purchase)));

                    }
                }
            }

            //freight charges
            $fre = 0;
            $colStringfreight  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A13','Freight Charges');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan_fre = $bulan_awal + $fre++;
                $dateObj_fre = DateTime::createFromFormat('!m', $blan_fre);
                $monthName_fre = $dateObj_fre->format('m');
                $bln_fre = $monthName_fre;


                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahun_fre = strtoupper($dateObjt->format('Y'));

                $total_fre = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_freight FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln_fre' and YEAR(Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $f) {
                        $freight = $f->z_freight;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringfreight.'13',str_replace("$", "", money_format('%(#10n', $freight)));

                        $colStringfreight++;
                    }
                }
            }

            if ($jumlah_bulan > 1) {
                $sql = $this->db->query($subtotal_freight);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $f) {
                        $ttl_4 = $f->subfreight;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringfreight.'13',str_replace("$", "", money_format('%(#10n', $ttl_4)));

                    }
                }
            }

            //closing stock
            $clo = 0;
            $colStringclose  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A14','CLOSING STOCK');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan_clo = $bulan_awal + $clo++;
                $dateObj_clo = DateTime::createFromFormat('!m', $blan_clo);
                $monthName_clo = $dateObj_clo->format('m');
                $bln_clo = $monthName_clo;


                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahun_clo = strtoupper($dateObjt->format('Y'));

                $total_clo = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_closing FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln_clo' and YEAR(Tanggal) = '$tahun_clo' and NoCOA like '1101%' or (MONTH(Tanggal) = '$bln_clo' and YEAR(Tanggal) = '$tahun_clo' and NoCOA like '1201%')");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $f) {
                        $closing = $f->z_closing;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringclose.'14',str_replace("$", "", money_format('%(#10n', $closing)));

                        $colStringclose++;
                    }
                }
            }


            //total closing stock start
            if ($jumlah_bulan > 1) {
                $sql = $this->db->query($subtotal_closing);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $f) {
                        $ttl_5 = $f->subclosing;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringclose.'14',str_replace("$", "", money_format('%(#10n', $ttl_5)));

                    }
                }
            }

            //total freight + closing stock
            $fre1 = 0;
            $clo2 = 0;
            $pur3 = 0;
            $opn3 = 0;
            $ox3 = 0;
            $colStringfreco  = PHPExcel_Cell::stringFromColumnIndex('1');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $bln_fre1 = $bulan_awal + $fre1++;
                $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                $monthName = $dateObj->format('m');
                $fre_bln = $monthName;

                $bln_clo2 = $bulan_awal + $clo2++;
                $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                $opmonthName = $dateObje->format('m');
                $clo_bln = $opmonthName;

                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));

                //opening stock
                $bln_op3 = ($bulan_awal - 1) + $opn3++;
                $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                $op3_bln = $date_op3->format('m');

                //opening stock
                $openingx3 = ($bulan_awal - 1) + $ox3++;
                $tgl_op3 = DateTime::createFromFormat('!m', $openingx3);
                $openingx33 = $tgl_op3->format('m');


                $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql_op3->num_rows() > 0) {
                    foreach ($sql_op3->result() as $op3) {
                        $opening_stock = 0 - $op3->t_2;
                    }
                }

                //purchasing
                $bln_pur2 = $bulan_awal + $pur3++;
                $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                $pur2_bln = $date_pur2->format('m');
                $bln = $pur2_bln;

                $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                    . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                if ($sql_pur3->num_rows() > 0) {

                    foreach ($sql_pur3->result() as $r) {
                        $pur_opening = (0 - $r->t_1) + $opening_stock;
                    }
                }

                //NILAI CLOSING STOCK
                $sql_closing = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_clo FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql_closing->num_rows() > 0) {
                    foreach ($sql_closing->result() as $s) {
                        $clo = $s->t_clo;
                    }
                }


                //NILAI FREIGHT
                $sql_freight = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_fre FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$fre_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                if ($sql_freight->num_rows() > 0) {
                    foreach ($sql_freight->result() as $r) {
                        $fre_clo = $r->t_fre + $clo + $pur_opening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringfreco.'15',str_replace("$", "", money_format('%(#10n', $fre_clo)));

                        $colStringfreco++;
                    }
                }
            }
            //total freight + closing stock start
            if ($jumlah_bulan > 1) {

                $sql = $this->db->query($subtotal_opening);
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $r) {
                        $subopening = 0 - $r->subopening;
                    }
                }
                $sqld = $this->db->query($subtotal_purchase);
                if ($sqld->num_rows() > 0) {
                    foreach ($sqld->result() as $r) {
                        $subpurchase = 0 - $r->subpurchase;
                    }
                }

                $sql_closing = $this->db->query($subtotal_freight);
                if ($sql_closing->num_rows() > 0) {
                    foreach ($sql_closing->result() as $s) {
                        $subfreight = $s->subfreight;
                    }
                }
                $sql_freight = $this->db->query($subtotal_closing);
                if ($sql_freight->num_rows() > 0) {
                    foreach ($sql_freight->result() as $r) {
                        $subclosing = $r->subclosing;
                    }
                }
                $total_formula = $subopening + $subpurchase + $subfreight + $subclosing;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringfreco.'15',str_replace("$", "", money_format('%(#10n', $total_formula)));


            }

            //total freight + closing stok End
            // == Start Gross Profit = Sales - purchase - freight charges ======
            $fre4 = 0;
            $clo4 = 0;
            $pur4 = 0;
            $opn4 = 0;
            $sale4 = 0;
            $colStringgross  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A16','GROSS PROFIT');

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $bln_fre1 = $bulan_awal + $fre4++;
                $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                $monthName = $dateObj->format('m');
                $fre_bln = $monthName;

                $bln_clo2 = $bulan_awal + $clo4++;
                $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                $opmonthName = $dateObje->format('m');
                $clo_bln = $opmonthName;

                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));

                //opening stock
                $bln_op3 = ($bulan_awal - 1) + $opn4++;
                $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                $op3_bln = $date_op3->format('m');

                $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql_op3->num_rows() > 0) {
                    foreach ($sql_op3->result() as $op3) {
                        $gr_opening = 0 - $op3->t_2;
                    }
                }

                //purchasing
                $bln_pur2 = $bulan_awal + $pur4++;
                $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                $pur2_bln = $date_pur2->format('m');
                $bln = $pur2_bln;

                $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                    . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                if ($sql_pur3->num_rows() > 0) {

                    foreach ($sql_pur3->result() as $r) {
                        $gr_purchasing = 0 - $r->t_1;
                    }
                }

                //NILAI CLOSING STOCK
                $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$clo_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql2->num_rows() > 0) {

                    foreach ($sql2->result() as $s) {
                        $gr_closing = $s->t_clo;
                    }
                }

                //nilai sales
                $bln_sale3 = $bulan_awal + $sale4++;
                $date_sale3 = DateTime::createFromFormat('!m', $bln_sale3);
                $sale3_bln = $date_sale3->format('m');

                $sql_sales = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_sale FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$sale3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '4001%'");
                if ($sql_sales->num_rows() > 0) {
                    foreach ($sql_sales->result() as $sale) {
                        $gr_sales = 0 - $sale->t_sale;
                    }
                }

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as gr_freight FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$fre_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                if ($sql->num_rows() > 0) {
                    //NILAI FREIGHT
                    foreach ($sql->result() as $r) {
                        $gr_freight = $r->gr_freight;
                    }
                }
                $gross_total = $gr_opening + $gr_purchasing + $gr_freight + $gr_closing + $gr_sales;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringgross.'16',str_replace("$", "", money_format('%(#10n', $gross_total)));

                $colStringgross++;
            }

            // total gross profit start
            if ($jumlah_bulan > 1) {
                $total_formula = $subopening + $subpurchase + $subfreight + $subclosing + $subsales;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringgross.'16',str_replace("$", "", money_format('%(#10n', $total_formula)));

            }

            //Bank Interest
            $bank = 0;
            $colStringbank  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A17','Bank Interest');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan_bank = $bulan_awal + $bank++;
                $dateObj_bank = DateTime::createFromFormat('!m', $blan_bank);
                $monthName_bank = $dateObj_bank->format('m');
                $bln_bank = $monthName_bank;


                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahun_bank = strtoupper($dateObjt->format('Y'));

                $total_gro = 0;

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_bank FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bln_bank' and YEAR( Tanggal) = '$tahun_bank' and NoCOA = '410208'");
                if ($sql->num_rows() > 0) {
                    foreach ($sql->result() as $f) {
                        $bank_i = $f->t_bank;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringbank.'17',str_replace("$", "", money_format('%(#10n', $bank_i)));

                        $colStringbank++;
                    }
                }
            }
            if ($jumlah_bulan > 1) {
                $sql_bank = $this->db->query($subtotal_bank);
                if ($sql_bank->num_rows() > 0) {
                    foreach ($sql_bank->result() as $s) {
                        $subbank = $s->subbank;
                    }
                }
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringbank.'17',str_replace("$", "", money_format('%(#10n', $subbank)));

            }


            //other income
            $ot = 0;
            $colStringother  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A18','Other Income');
            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $blan_ot = $bulan_awal + $ot++;
                $dateObj_ot = DateTime::createFromFormat('!m', $blan_ot);
                $monthName_ot = $dateObj_ot->format('m');
                $bln_ot = $monthName_ot;


                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahun_ot = strtoupper($dateObjt->format('Y'));

                $sql_ot = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_bank FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bln_ot' and YEAR( Tanggal) = '$tahun_ot' and NoCOA = '410206'");
                if ($sql_ot->num_rows() > 0) {
                    foreach ($sql_ot->result() as $f) {
                        $other = $f->t_ot;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringother.'18',str_replace("$", "", money_format('%(#10n', $other)));

                        $colStringother++;
                    }
                }
            }
            if ($jumlah_bulan > 1) {
                if ($jumlah_bulan > 1) {
                    $sql_other = $this->db->query($subtotal_other);
                    if ($sql_other->num_rows() > 0) {
                        foreach ($sql_other->result() as $s) {
                            $subother = $s->subother;
                        }
                    }
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($colStringother.'18',str_replace("$", "", money_format('%(#10n', $subother)));
                }
            }

            // == Start total ======
            $fre5 = 0;
            $clo5 = 0;
            $pur5 = 0;
            $opn5 = 0;
            $sale5 = 0;
            $oi5 = 0;
            $bii5 = 0;


            $colStringgpm  = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A19','Gross Profit Margin');

            for ($i = 0; $i < $jumlah_bulan; $i++) {
                $bln_fre1 = $bulan_awal + $fre5++;
                $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                $monthName = $dateObj->format('m');
                $fre_bln = $monthName;

                $bln_clo2 = $bulan_awal + $clo5++;
                $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                $opmonthName = $dateObje->format('m');
                $clo_bln = $opmonthName;

                $buln = $tahun_awal;
                $dateObjt = DateTime::createFromFormat('!Y', $buln);
                $tahunan = strtoupper($dateObjt->format('Y'));

                //opening stock
                $bln_op3 = ($bulan_awal - 1) + $opn5++;
                $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                $op3_bln = $date_op3->format('m');

                $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$op3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql_op3->num_rows() > 0) {
                    foreach ($sql_op3->result() as $op3) {
                        $opening_stock = 0 - $op3->t_2;
                    }
                }

                //purchasing
                $bln_pur2 = $bulan_awal + $pur5++;
                $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                $pur2_bln = $date_pur2->format('m');
                $bln_2 = $pur2_bln;

                $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                    . "                 MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                    . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                    . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                    . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                    . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                    . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                if ($sql_pur3->num_rows() > 0) {

                    foreach ($sql_pur3->result() as $r) {
                        $pur_opening = (0 - $r->t_1) + $opening_stock;
                    }
                }

                //NILAI CLOSING STOCK
                $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_clo FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$clo_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                if ($sql2->num_rows() > 0) {

                    foreach ($sql2->result() as $s) {
                        $clo = $s->t_clo;
                    }
                }

                //nilai sales
                $bln_sale3 = $bulan_awal + $sale5++;
                $date_sale3 = DateTime::createFromFormat('!m', $bln_sale3);
                $sale3_bln = $date_sale3->format('m');

                $sql_sales = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_sale FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$sale3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '4001%'");
                if ($sql_sales->num_rows() > 0) {
                    foreach ($sql_sales->result() as $sale) {
                        $sales = 0 - $sale->t_sale;
                    }
                }

                //nilai other income
                $bln_oi = $bulan_awal + $oi5++;
                $dateObj_oi = DateTime::createFromFormat('!m', $bln_oi);
                $monthName_oi = $dateObj_oi->format('m');
                $oi_bln = $monthName_oi;
                $sql_ot = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_ot FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$oi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410206'");
                if ($sql_ot->num_rows() > 0) {
                    foreach ($sql_ot->result() as $f) {
                        $other = $f->t_ot;
                    }
                }

                //nilai bank interest
                $bln_bi = $bulan_awal + $bii5++;
                $dateObj_bi = DateTime::createFromFormat('!m', $bln_bi);
                $monthName_bi = $dateObj_bi->format('m');
                $bi_bln = $monthName_bi;
                $sql_bi = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_bi FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410208'");
                if ($sql_bi->num_rows() > 0) {
                    foreach ($sql_bi->result() as $f) {
                        $bank_interest = $f->t_bi;
                    }
                }

                $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_fre FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$fre_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                if ($sql->num_rows() > 0) {
                    //NILAI FREIGHT
                    foreach ($sql->result() as $r) {
                        $fre_clo = $r->t_fre + $clo + $pur_opening + $sales + $other + $bank_interest;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($colStringgpm.'19',str_replace("$", "", money_format('%(#10n', $fre_clo)));

                        $colStringgpm++;
                    }
                }
            }
            if ($jumlah_bulan > 1) {
                $subtotal_all = $subopening + $subpurchase + $subfreight + $subclosing + $subsales + $subbank + $subother;
                setlocale(LC_MONETARY, 'en_US.UTF-8');
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringgpm.'19',str_replace("$", "", money_format('%(#10n', $subtotal_all)));

            }


            //General
            $colStringgenerala = PHPExcel_Cell::stringFromColumnIndex('0');
            $colStringgeneralb = PHPExcel_Cell::stringFromColumnIndex('1');

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A20','General');
            $rowgeneral=21;
            $rowgeneralb=21;
            foreach ($get_invoice as $v) {
                $s = 0;
                $x = 0;

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringgenerala.$rowgeneral,$v->t_nama_group);
                for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan = $bulan_awal + $s++;
                    $dateObj = DateTime::createFromFormat('!m', $blan);
                    $monthName = $dateObj->format('m');
                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));
                    $nomor = $bulan_awal + $w++;

                    $coa = $v->t_no_coa;
                    $bln = $monthName;

                    $total = 0;
                    $sql = $this->db->query("SELECT IFNULL(SUM(Debet-Kredit),0) as Total FROM acc_tbl_trn_jurnal WHERE NoCOA = '$coa' AND MONTH(Tanggal) = '$bln' AND Year(Tanggal) = '$tahunan'");
                    if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                            $bln_str = 0 - $r->Total;
                            //str_replace("$", "", money_format('%(#10n', $bln_str));
                            setlocale(LC_MONETARY, 'en_US.UTF-8');

                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($colStringgeneralb.$rowgeneralb,str_replace("$", "", money_format('%(#10n', $bln_str)));
                            $colStringgeneralb++;
                        }
                        if ($jumlah_bulan > 1) {
                            $sql = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 AND c.NoCOA = '$coa' and MONTH( Tanggal) BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR( Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'");
                            if ($sql->num_rows() > 0) {
                                foreach ($sql->result() as $r) {
                                    $total_general = 0 - $r->Total;
                                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                                    $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue($colStringgeneralb.$rowgeneralb,str_replace("$", "", money_format('%(#10n', $total_general)));
                                    //$colStringgeneralb = PHPExcel_Cell::stringFromColumnIndex('1');


                                }
                            }
                        }
                    }

                }
                $colStringgeneralb = PHPExcel_Cell::stringFromColumnIndex('1');

                $rowgeneralb++;
               $rowgeneral++;
            }

                /* $c_opening=11;
                 foreach ($get_opening as $o) {
                     $jlhopen = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $o_12 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_12));
                     $o_11 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_11));
                     $o_10 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_10));
                     $o_9 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_9));
                     $o_8 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_8));
                     $o_7 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_7));
                     $o_6 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_6));
                     $o_5 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_5));
                     $o_4 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_4));
                     $o_3 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_3));
                     $o_2 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_2));
                     $o_1 = str_replace("$", "", money_format('%(#10n', 0 - $o->t_1));
                     $o_total = str_replace("$", "", money_format('%(#10n', $o->t_total));

                     $o1 = 0 - $o->t_1;
                     $o2 = 0 - $o->t_2;
                     $o3 = 0 - $o->t_3;
                     $o4 = 0 - $o->t_4;
                     $o5 = 0 - $o->t_5;
                     $o6 = 0 - $o->t_6;
                     $o7 = 0 - $o->t_7;
                     $o8 = 0 - $o->t_8;
                     $o9 = 0 - $o->t_9;
                     $o10 = 0 - $o->t_10;
                     $o11 = 0 - $o->t_11;
                     $o12 = 0 - $o->t_12;
                     $ototal = 0 - $o->t_total;

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_opening,'Opening')
                         ->setCellValue('B'.$c_opening,$o_10)
                         ->setCellValue('C'.$c_opening,$o_9)
                         ->setCellValue('D'.$c_opening,$o_8)
                         ->setCellValue('E'.$c_opening,$o_7)
                         ->setCellValue('F'.$c_opening,$o_6)
                         ->setCellValue('G'.$c_opening,$o_5)
                         ->setCellValue('H'.$c_opening,$o_4)
                         ->setCellValue('I'.$c_opening,$o_3)
                         ->setCellValue('J'.$c_opening,$o_2)
                         ->setCellValue('K'.$c_opening,$o_1)
                         ->setCellValue('L'.$c_opening,$o_12)
                         ->setCellValue('M'.$c_opening,$o_total)

                     ;

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A11:M' . ($jlhopen+1))->applyFromArray($styleArray);

                 }

                 //purchase
                 $c_purchase=12;
                 $c_purchaseB=13;
                 foreach ($get_purchase as $p) {
                     $jlhpurchase = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $p_12 = str_replace("$", "", money_format('%(#10n', $p->t_12));
                     $p_11 = str_replace("$", "", money_format('%(#10n', $p->t_11));
                     $p_10 = str_replace("$", "", money_format('%(#10n', $p->t_10));
                     $p_9 = str_replace("$", "", money_format('%(#10n', $p->t_9));
                     $p_8 = str_replace("$", "", money_format('%(#10n', $p->t_8));
                     $p_7 = str_replace("$", "", money_format('%(#10n', $p->t_7));
                     $p_6 = str_replace("$", "", money_format('%(#10n', $p->t_6));
                     $p_5 = str_replace("$", "", money_format('%(#10n', $p->t_5));
                     $p_4 = str_replace("$", "", money_format('%(#10n', $p->t_4));
                     $p_3 = str_replace("$", "", money_format('%(#10n', $p->t_3));
                     $p_2 = str_replace("$", "", money_format('%(#10n', $p->t_2));
                     $p_1 = str_replace("$", "", money_format('%(#10n', $p->t_1));
                     $p_total = str_replace("$", "", money_format('%(#10n', $p->t_total));

                     $p1 = str_replace("$", "", money_format('%(#10n', $p->t_1 + $o12));
                     $p2 = str_replace("$", "", money_format('%(#10n', $p->t_2 + $o1));
                     $p3 = str_replace("$", "", money_format('%(#10n', $p->t_3 + $o2));
                     $p4 = str_replace("$", "", money_format('%(#10n', $p->t_4 + $o3));
                     $p5 = str_replace("$", "", money_format('%(#10n', $p->t_5 + $o4));
                     $p6 = str_replace("$", "", money_format('%(#10n', $p->t_6 + $o5));
                     $p7 = str_replace("$", "", money_format('%(#10n', $p->t_7 + $o6));
                     $p8 = str_replace("$", "", money_format('%(#10n', $p->t_8 + $o7));
                     $p9 = str_replace("$", "", money_format('%(#10n', $p->t_9 + $o8));
                     $p10 = str_replace("$", "", money_format('%(#10n', $p->t_10 + $o9));
                     $p11 = str_replace("$", "", money_format('%(#10n', $p->t_11 + $o10));
                     $p12 = str_replace("$", "", money_format('%(#10n', $p->t_12 + $o1));
                     $ptotal = str_replace("$", "", money_format('%(#10n', $p->t_total + $ototal));


                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_purchase,'Purchase')
                         ->setCellValue('B'.$c_purchase,$p_11)
                         ->setCellValue('C'.$c_purchase,$p_10)
                         ->setCellValue('D'.$c_purchase,$p_9)
                         ->setCellValue('E'.$c_purchase,$p_8)
                         ->setCellValue('F'.$c_purchase,$p_7)
                         ->setCellValue('G'.$c_purchase,$p_6)
                         ->setCellValue('H'.$c_purchase,$p_5)
                         ->setCellValue('I'.$c_purchase,$p_4)
                         ->setCellValue('J'.$c_purchase,$p_3)
                         ->setCellValue('K'.$c_purchase,$p_2)
                         ->setCellValue('L'.$c_purchase,$p_1)
                         ->setCellValue('M'.$c_purchase,$p_total)

                     ;
                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A12:M' . ($jlhpurchase+1))->applyFromArray($styleArray);


                     $jlhpurchase2 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('B'.$c_purchaseB,$p11)
                         ->setCellValue('C'.$c_purchaseB,$p10)
                         ->setCellValue('D'.$c_purchaseB,$p9)
                         ->setCellValue('E'.$c_purchaseB,$p8)
                         ->setCellValue('F'.$c_purchaseB,$p7)
                         ->setCellValue('G'.$c_purchaseB,$p6)
                         ->setCellValue('H'.$c_purchaseB,$p5)
                         ->setCellValue('I'.$c_purchaseB,$p4)
                         ->setCellValue('J'.$c_purchaseB,$p3)
                         ->setCellValue('K'.$c_purchaseB,$p2)
                         ->setCellValue('L'.$c_purchaseB,$p1)
                         ->setCellValue('M'.$c_purchaseB,$ptotal)

                     ;
                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A13:M' . ($jlhpurchase2+1))->applyFromArray($styleArray);

                 }

                 //freight
                 $c_freight=14;
                 foreach ($get_freight as $f) {
                     $jlhfreight = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $f_12 = str_replace("$", "", money_format('%(#10n', $f->t_12));
                     $f_11 = str_replace("$", "", money_format('%(#10n', $f->t_11));
                     $f_10 = str_replace("$", "", money_format('%(#10n', $f->t_10));
                     $f_9 = str_replace("$", "", money_format('%(#10n', $f->t_9));
                     $f_8 = str_replace("$", "", money_format('%(#10n', $f->t_8));
                     $f_7 = str_replace("$", "", money_format('%(#10n', $f->t_7));
                     $f_6 = str_replace("$", "", money_format('%(#10n', $f->t_6));
                     $f_5 = str_replace("$", "", money_format('%(#10n', $f->t_5));
                     $f_4 = str_replace("$", "", money_format('%(#10n', $f->t_4));
                     $f_3 = str_replace("$", "", money_format('%(#10n', $f->t_3));
                     $f_2 = str_replace("$", "", money_format('%(#10n', $f->t_2));
                     $f_1 = str_replace("$", "", money_format('%(#10n', $f->t_1));
                     $f_total = str_replace("$", "", money_format('%(#10n', $f->t_total));

                     $f1 = $f->t_1;
                     $f2 = $f->t_2;
                     $f3 = $f->t_3;
                     $f4 = $f->t_4;
                     $f5 = $f->t_5;
                     $f6 = $f->t_6;
                     $f7 = $f->t_7;
                     $f8 = $f->t_8;
                     $f9 = $f->t_9;
                     $f10 = $f->t_10;
                     $f11 = $f->t_11;
                     $f12 = $f->t_12;
                     $ftotal = $f->t_total;

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_freight,'Freight Charges')
                         ->setCellValue('B'.$c_freight,$f_11)
                         ->setCellValue('C'.$c_freight,$f_10)
                         ->setCellValue('D'.$c_freight,$f_9)
                         ->setCellValue('E'.$c_freight,$f_8)
                         ->setCellValue('F'.$c_freight,$f_7)
                         ->setCellValue('G'.$c_freight,$f_6)
                         ->setCellValue('H'.$c_freight,$f_5)
                         ->setCellValue('I'.$c_freight,$f_4)
                         ->setCellValue('J'.$c_freight,$f_3)
                         ->setCellValue('K'.$c_freight,$f_2)
                         ->setCellValue('L'.$c_freight,$f_1)
                         ->setCellValue('M'.$c_freight,$f_total)

                     ;
                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A14:M' . ($jlhfreight+1))->applyFromArray($styleArray);

                 }

                 $c_closing=15;
                 $c_closingB=16;
                 foreach ($get_closing as $c) {
                     $jlhclose = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $c_12 = str_replace("$", "", money_format('%(#10n', $c->t_12));
                     $c_11 = str_replace("$", "", money_format('%(#10n', $c->t_11));
                     $c_10 = str_replace("$", "", money_format('%(#10n', $c->t_10));
                     $c_9 = str_replace("$", "", money_format('%(#10n', $c->t_9));
                     $c_8 = str_replace("$", "", money_format('%(#10n', $c->t_8));
                     $c_7 = str_replace("$", "", money_format('%(#10n', $c->t_7));
                     $c_6 = str_replace("$", "", money_format('%(#10n', $c->t_6));
                     $c_5 = str_replace("$", "", money_format('%(#10n', $c->t_5));
                     $c_4 = str_replace("$", "", money_format('%(#10n', $c->t_4));
                     $c_3 = str_replace("$", "", money_format('%(#10n', $c->t_3));
                     $c_2 = str_replace("$", "", money_format('%(#10n', $c->t_2));
                     $c_1 = str_replace("$", "", money_format('%(#10n', $c->t_1));
                     $c_total = str_replace("$", "", money_format('%(#10n', $c->t_total));

                     $c1 = str_replace("$", "", money_format('%(#10n', $c->t_1 + $f1));
                     $c2 = str_replace("$", "", money_format('%(#10n', $c->t_2 + $f2));
                     $c3 = str_replace("$", "", money_format('%(#10n', $c->t_3 + $f3));
                     $c4 = str_replace("$", "", money_format('%(#10n', $c->t_4 + $f4));
                     $c5 = str_replace("$", "", money_format('%(#10n', $c->t_5 + $f5));
                     $c6 = str_replace("$", "", money_format('%(#10n', $c->t_6 + $f6));
                     $c7 = str_replace("$", "", money_format('%(#10n', $c->t_7 + $f7));
                     $c8 = str_replace("$", "", money_format('%(#10n', $c->t_8 + $f8));
                     $c9 = str_replace("$", "", money_format('%(#10n', $c->t_9 + $f9));
                     $c10 = str_replace("$", "", money_format('%(#10n', $c->t_10 + $f10));
                     $c11 = str_replace("$", "", money_format('%(#10n', $c->t_11 + $f11));
                     $c12 = str_replace("$", "", money_format('%(#10n', $c->t_12 + $f2));
                     $ctotal = str_replace("$", "", money_format('%(#10n', $c->t_total + $ftotal));

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_closing,'Closing Stock')
                         ->setCellValue('B'.$c_closing,$c_11)
                         ->setCellValue('C'.$c_closing,$c_10)
                         ->setCellValue('D'.$c_closing,$c_9)
                         ->setCellValue('E'.$c_closing,$c_8)
                         ->setCellValue('F'.$c_closing,$c_7)
                         ->setCellValue('G'.$c_closing,$c_6)
                         ->setCellValue('H'.$c_closing,$c_5)
                         ->setCellValue('I'.$c_closing,$c_4)
                         ->setCellValue('J'.$c_closing,$c_3)
                         ->setCellValue('K'.$c_closing,$c_2)
                         ->setCellValue('L'.$c_closing,$c_1)
                         ->setCellValue('M'.$c_closing,$c_total);
                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A15:M' . ($jlhclose+1))->applyFromArray($styleArray);

                     $jlhclose2 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_closingB,'')
                         ->setCellValue('B'.$c_closingB,$c11)
                         ->setCellValue('C'.$c_closingB,$c10)
                         ->setCellValue('D'.$c_closingB,$c9)
                         ->setCellValue('E'.$c_closingB,$c8)
                         ->setCellValue('F'.$c_closingB,$c7)
                         ->setCellValue('G'.$c_closingB,$c6)
                         ->setCellValue('H'.$c_closingB,$c5)
                         ->setCellValue('I'.$c_closingB,$c4)
                         ->setCellValue('J'.$c_closingB,$c3)
                         ->setCellValue('K'.$c_closingB,$c2)
                         ->setCellValue('L'.$c_closingB,$c1)
                         ->setCellValue('M'.$c_closingB,$ctotal);

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A16:M' . ($jlhclose2+1))->applyFromArray($styleArray);


                 }

                 //Gross Profit = Sales - Purchases - Freight charges
                 $g1 = $s1 - $p1 - $f1;
                 $g2 = $s2 - $p2 - $f2;
                 $g3 = $s3 - $p3 - $f3;
                 $g4 = $s4 - $p4 - $f4;
                 $g5 = $s5 - $p5 - $f5;
                 $g6 = $s6 - $p6 - $f6;
                 $g7 = $s7 - $p7 - $f7;
                 $g8 = $s8 - $p8 - $f8;
                 $g9 = $s9 - $p9 - $f9;
                 $g10 = $s10 - $p10 - $f10;
                 $g11 = $s11 - $p11 - $f11;
                 $g12 = $s12 - $p12 - $f12;
                 $gtotal = $stotal - $ptotal - $ftotal;

                 $c_gross=17;
                 $jlhgross = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                 $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('A'.$c_gross,'Gross Profit')
                     ->setCellValue('B'.$c_gross,str_replace("$", "", money_format('%(#10n', $g11)))
                     ->setCellValue('C'.$c_gross,str_replace("$", "", money_format('%(#10n', $g10)))
                     ->setCellValue('D'.$c_gross,str_replace("$", "", money_format('%(#10n', $g9)))
                     ->setCellValue('E'.$c_gross,str_replace("$", "", money_format('%(#10n', $g8)))
                     ->setCellValue('F'.$c_gross,str_replace("$", "", money_format('%(#10n', $g7)))
                     ->setCellValue('G'.$c_gross,str_replace("$", "", money_format('%(#10n', $g6)))
                     ->setCellValue('H'.$c_gross,str_replace("$", "", money_format('%(#10n', $g5)))
                     ->setCellValue('I'.$c_gross,str_replace("$", "", money_format('%(#10n', $g4)))
                     ->setCellValue('J'.$c_gross,str_replace("$", "", money_format('%(#10n', $g3)))
                     ->setCellValue('K'.$c_gross,str_replace("$", "", money_format('%(#10n', $g2)))
                     ->setCellValue('L'.$c_gross,str_replace("$", "", money_format('%(#10n', $g1)))
                     ->setCellValue('M'.$c_gross,str_replace("$", "", money_format('%(#10n', $gtotal)));

                 $styleArray = array(
                     'borders' => array(
                         'allborders' => array(
                             'style' => PHPExcel_Style_Border::BORDER_THIN
                         )
                     )
                 );

                 $objPHPExcel->getActiveSheet()->getStyle('A17:M' . ($jlhgross+1))->applyFromArray($styleArray);


                 //Bank INterest
                 $c_bank=18;
                 foreach ($get_bank as $b) {
                     $jlhbank = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $b_12 = str_replace("$", "", money_format('%(#10n', $b->t_12));
                     $b_11 = str_replace("$", "", money_format('%(#10n', $b->t_11));
                     $b_10 = str_replace("$", "", money_format('%(#10n', $b->t_10));
                     $b_9 = str_replace("$", "", money_format('%(#10n', $b->t_9));
                     $b_8 = str_replace("$", "", money_format('%(#10n', $b->t_8));
                     $b_7 = str_replace("$", "", money_format('%(#10n', $b->t_7));
                     $b_6 = str_replace("$", "", money_format('%(#10n', $b->t_6));
                     $b_5 = str_replace("$", "", money_format('%(#10n', $b->t_5));
                     $b_4 = str_replace("$", "", money_format('%(#10n', $b->t_4));
                     $b_3 = str_replace("$", "", money_format('%(#10n', $b->t_3));
                     $b_2 = str_replace("$", "", money_format('%(#10n', $b->t_2));
                     $b_1 = str_replace("$", "", money_format('%(#10n', $b->t_1));
                     $b_total = str_replace("$", "", money_format('%(#10n', $b->t_total));

                     $b1 = $b->t_1;
                     $b2 = $b->t_2;
                     $b3 = $b->t_3;
                     $b4 = $b->t_4;
                     $b5 = $b->t_5;
                     $b6 = $b->t_6;
                     $b7 = $b->t_7;
                     $b8 = $b->t_8;
                     $b9 = $b->t_9;
                     $b10 = $b->t_10;
                     $b11 = $b->t_11;
                     $b12 = $b->t_12;
                     $btotal = $b->t_total;

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_bank,'Bank Interest')
                         ->setCellValue('B'.$c_bank,$b_11)
                         ->setCellValue('C'.$c_bank,$b_10)
                         ->setCellValue('D'.$c_bank,$b_9)
                         ->setCellValue('E'.$c_bank,$b_8)
                         ->setCellValue('F'.$c_bank,$b_7)
                         ->setCellValue('G'.$c_bank,$b_6)
                         ->setCellValue('H'.$c_bank,$b_5)
                         ->setCellValue('I'.$c_bank,$b_4)
                         ->setCellValue('J'.$c_bank,$b_3)
                         ->setCellValue('K'.$c_bank,$b_2)
                         ->setCellValue('L'.$c_bank,$b_1)
                         ->setCellValue('M'.$c_bank,$b_total);
                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A18:M' . ($jlhbank+1))->applyFromArray($styleArray);


                 }

                 //OTHER
                 $c_other=19;
                 $c_x=20;
                 $c_x2=21;
                 foreach ($get_other as $i) {
                     $jlhother = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     setlocale(LC_MONETARY, 'en_US.UTF-8');
                     $i_12 = str_replace("$", "", money_format('%(#10n', $i->t_12));
                     $i_11 = str_replace("$", "", money_format('%(#10n', $i->t_11));
                     $i_10 = str_replace("$", "", money_format('%(#10n', $i->t_10));
                     $i_9 = str_replace("$", "", money_format('%(#10n', $i->t_9));
                     $i_8 = str_replace("$", "", money_format('%(#10n', $i->t_8));
                     $i_7 = str_replace("$", "", money_format('%(#10n', $i->t_7));
                     $i_6 = str_replace("$", "", money_format('%(#10n', $i->t_6));
                     $i_5 = str_replace("$", "", money_format('%(#10n', $i->t_5));
                     $i_4 = str_replace("$", "", money_format('%(#10n', $i->t_4));
                     $i_3 = str_replace("$", "", money_format('%(#10n', $i->t_3));
                     $i_2 = str_replace("$", "", money_format('%(#10n', $i->t_2));
                     $i_1 = str_replace("$", "", money_format('%(#10n', $i->t_1));
                     $i_total = str_replace("$", "", money_format('%(#10n', $i->t_total));

                     $i1 = $i->t_1;
                     $i2 = $i->t_2;
                     $i3 = $i->t_3;
                     $i4 = $i->t_4;
                     $i5 = $i->t_5;
                     $i6 = $i->t_6;
                     $i7 = $i->t_7;
                     $i8 = $i->t_8;
                     $i9 = $i->t_9;
                     $i10 = $i->t_10;
                     $i11 = $i->t_11;
                     $i12 = $i->t_12;
                     $itotal = $i->t_total;

                     $x1 = $g1 + $b1 + $i1;
                     $x2 = $g2 + $b2 + $i2;
                     $x3 = $g3 + $b3 + $i3;
                     $x4 = $g4 + $b4 + $i4;
                     $x5 = $g5 + $b5 + $i5;
                     $x6 = $g6 + $b6 + $i6;
                     $x7 = $g7 + $b7 + $i7;
                     $x8 = $g8 + $b8 + $i8;
                     $x9 = $g9 + $b9 + $i9;
                     $x10 = $g10 + $b10 + $i10;
                     $x11 = $g11 + $b11 + $i11;
                     $x12 = $g12 + $b12 + $i12;
                     $xtotal = $gtotal + $btotal + $itotal;

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_other,'Other Income')
                         ->setCellValue('B'.$c_other,$i_11)
                         ->setCellValue('C'.$c_other,$i_10)
                         ->setCellValue('D'.$c_other,$i_9)
                         ->setCellValue('E'.$c_other,$i_8)
                         ->setCellValue('F'.$c_other,$i_7)
                         ->setCellValue('G'.$c_other,$i_6)
                         ->setCellValue('H'.$c_other,$i_5)
                         ->setCellValue('I'.$c_other,$i_4)
                         ->setCellValue('J'.$c_other,$i_3)
                         ->setCellValue('K'.$c_other,$i_2)
                         ->setCellValue('L'.$c_other,$i_1)
                         ->setCellValue('M'.$c_other,$i_total);

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );
                     $objPHPExcel->getActiveSheet()->getStyle('A19:M' . ($jlhother+1))->applyFromArray($styleArray);




                     $jlhother2 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_x,'')
                         ->setCellValue('B'.$c_x,str_replace("$", "", money_format('%(#10n', $x11)))
                         ->setCellValue('C'.$c_x,str_replace("$", "", money_format('%(#10n', $x10)))
                         ->setCellValue('D'.$c_x,str_replace("$", "", money_format('%(#10n', $x9)))
                         ->setCellValue('E'.$c_x,str_replace("$", "", money_format('%(#10n', $x8)))
                         ->setCellValue('F'.$c_x,str_replace("$", "", money_format('%(#10n', $x7)))
                         ->setCellValue('G'.$c_x,str_replace("$", "", money_format('%(#10n', $x6)))
                         ->setCellValue('H'.$c_x,str_replace("$", "", money_format('%(#10n', $x5)))
                         ->setCellValue('I'.$c_x,str_replace("$", "", money_format('%(#10n', $x4)))
                         ->setCellValue('J'.$c_x,str_replace("$", "", money_format('%(#10n', $x3)))
                         ->setCellValue('K'.$c_x,str_replace("$", "", money_format('%(#10n', $x2)))
                         ->setCellValue('L'.$c_x,str_replace("$", "", money_format('%(#10n', $x1)))
                         ->setCellValue('M'.$c_x,str_replace("$", "", money_format('%(#10n', $xtotal)));

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A20:M' . ($jlhother2+1))->applyFromArray($styleArray);

                     //Gross profit margin = Gross Profit ÷ Sales × 100%
                     if (!empty($g1) or ! empty($s1)) {
                         $gm1 = round($g1 / $s1 * 100, 2);
                         $gm2 = round($g2 / $s2 * 100, 2);
                         $gm3 = round($g3 / $s3 * 100, 2);
                         $gm4 = round($g4 / $s4 * 100, 2);
                         $gm5 = round($g5 / $s5 * 100, 2);
                         $gm6 = round($g6 / $s6 * 100, 2);
                         $gm7 = round($g7 / $s7 * 100, 2);
                         $gm8 = round($g8 / $s8 * 100, 2);
                         $gm9 = round($g9 / $s9 * 100, 2);
                         $gm10 = round($g10 / $s10 * 100, 2);
                         $gm11 = round($g10 / $s10 * 100, 2);
                         $gm12 = round($g12 / $s12 * 100, 2);
                         $gmtotal = round($gtotal / $stotal * 100, 2);
                     }else{
                         $gm1 = 0;
                         $gm2 = 0;
                         $gm3 = 0;
                         $gm4 = 0;
                         $gm5 = 0;
                         $gm6 = 0;
                         $gm7 = 0;
                         $gm8 = 0;
                         $gm9 = 0;
                         $gm10 = 0;
                         $gm11 = 0;
                         $gm12 = 0;
                         $gmtotal = 0;
                     }
                     $jlhother3 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_x2,'Gross Profit Margin')
                         ->setCellValue('B'.$c_x2,$gm11)
                         ->setCellValue('C'.$c_x2,$gm10)
                         ->setCellValue('D'.$c_x2,$gm9)
                         ->setCellValue('E'.$c_x2,$gm8)
                         ->setCellValue('F'.$c_x2,$gm7)
                         ->setCellValue('G'.$c_x2,$gm6)
                         ->setCellValue('H'.$c_x2,$gm5)
                         ->setCellValue('I'.$c_x2,$gm4)
                         ->setCellValue('J'.$c_x2,$gm3)
                         ->setCellValue('K'.$c_x2,$gm2)
                         ->setCellValue('L'.$c_x2,$gm1)
                         ->setCellValue('M'.$c_x2,$gmtotal);

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A21:M' . ($jlhother3+1))->applyFromArray($styleArray);

                     $jlhgen = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A22','General & Andministrative Expenses');

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     $objPHPExcel->getActiveSheet()->getStyle('A22:M' . ($jlhgen+1))->applyFromArray($styleArray);


                 }
                 //total
                 $t1 = 0;
                 $t2 = 0;
                 $t3 = 0;
                 $t4 = 0;
                 $t5 = 0;
                 $t6 = 0;
                 $t7 = 0;
                 $t8 = 0;
                 $t9 = 0;
                 $t10 = 0;
                 $t11 = 0;
                 $t12 = 0;
                 $ttotal = 0;
                 //general
                 $c_general=23;
                 foreach ($get_invoice as $a) {

                     $jlhgeneral = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

                     setlocale(LC_MONETARY, 'en_US.UTF-8');

                     $t_12 = str_replace("$", "", money_format('%(#10n', $a->t_11));
                     $t_11 = str_replace("$", "", money_format('%(#10n', $a->t_11));
                     $t_10 = str_replace("$", "", money_format('%(#10n', $a->t_10));
                     $t_9 = str_replace("$", "", money_format('%(#10n', $a->t_9));
                     $t_8 = str_replace("$", "", money_format('%(#10n', $a->t_8));
                     $t_7 = str_replace("$", "", money_format('%(#10n', $a->t_7));
                     $t_6 = str_replace("$", "", money_format('%(#10n', $a->t_6));
                     $t_5 = str_replace("$", "", money_format('%(#10n', $a->t_5));
                     $t_4 = str_replace("$", "", money_format('%(#10n', $a->t_4));
                     $t_3 = str_replace("$", "", money_format('%(#10n', $a->t_3));
                     $t_2 = str_replace("$", "", money_format('%(#10n', $a->t_2));
                     $t_1 = str_replace("$", "", money_format('%(#10n', $a->t_1));
                     $t_total = str_replace("$", "", money_format('%(#10n', $a->t_total));


                     $t1 += $a->t_1;
                     $t2 += $a->t_2;
                     $t3 += $a->t_3;
                     $t4 += $a->t_4;
                     $t5 += $a->t_5;
                     $t6 += $a->t_6;
                     $t7 += $a->t_7;
                     $t8 += $a->t_8;
                     $t9 += $a->t_9;
                     $t10 += $a->t_10;
                     $t11 += $a->t_11;
                     $t12 += $a->t_12;
                     $ttotal += $a->t_total;

                     $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$c_general,$a->t_nama_group)
                         ->setCellValue('B'.$c_general,$t_11)
                         ->setCellValue('C'.$c_general,$t_10)
                         ->setCellValue('D'.$c_general,$t_9)
                         ->setCellValue('E'.$c_general,$t_8)
                         ->setCellValue('F'.$c_general,$t_7)
                         ->setCellValue('G'.$c_general,$t_6)
                         ->setCellValue('H'.$c_general,$t_5)
                         ->setCellValue('I'.$c_general,$t_4)
                         ->setCellValue('J'.$c_general,$t_3)
                         ->setCellValue('K'.$c_general,$t_2)
                         ->setCellValue('L'.$c_general,$t_1)
                         ->setCellValue('M'.$c_general,$t_total);

                     $styleArray = array(
                         'borders' => array(
                             'allborders' => array(
                                 'style' => PHPExcel_Style_Border::BORDER_THIN
                             )
                         )
                     );

                     //$objPHPExcel->getActiveSheet()->getStyle('A23:M' . ($jlhgeneral+1))->applyFromArray($styleArray);
                     $c_general++;
                 }

                 //Total Expense
                 $c_ttlexpense = 59;
                 $jlhexpense = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                 $objPHPExcel->setActiveSheetIndex(0)
                     ->setCellValue('A'.$c_ttlexpense,'TOTAL EXPENSE')
                     ->setCellValue('B'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t11)))
                     ->setCellValue('C'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t10)))
                     ->setCellValue('D'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t9)))
                     ->setCellValue('E'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t8)))
                     ->setCellValue('F'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t7)))
                     ->setCellValue('G'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t6)))
                     ->setCellValue('H'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t5)))
                     ->setCellValue('I'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t4)))
                     ->setCellValue('J'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t3)))
                     ->setCellValue('K'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t2)))
                     ->setCellValue('L'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $t1)))
                     ->setCellValue('M'.$c_ttlexpense,str_replace("$", "", money_format('%(#10n', $ttotal)));

                 $styleArray = array(
                     'borders' => array(
                         'allborders' => array(
                             'style' => PHPExcel_Style_Border::BORDER_THIN
                         )
                     )
                 );

                 //$objPHPExcel->getActiveSheet()->getStyle('A57:M' . ($jlhexpense+1))->applyFromArray($styleArray);*/
        }

        $objPHPExcel->getActiveSheet()->setTitle('PROFIT AND LOST');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_Lost.xlsx"');
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
     function toExcelProfit_Loss_Statement() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        // $coa1 = $this->input->get('coa1');
        // $coa2 = $this->input->get('coa2');
        
         $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));
        // $p_dari = $this->input->get('dari');
        // $p_sampai = $this->input->get('sampai');
        $type = $this->input->get('type');

        //$sup = $this->input->get('supplier');
        //$tgl = $this->input->get('periode') . "/" . date("d");
        //$curreny = $this->input->get('currency');
        
        $data = $this->M_Profit_and_loss->call_data_profit_new($p_dari, $p_sampai);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();  
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:G1")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:G2")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);

        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('A2', 'PROFIT & LOSS STATEMENT AT ('.$p_dari.') - ('.$p_sampai.')')
                ->setCellValue('A3', 'No')

                ->setCellValue('B3', '')
                ->setCellValue('C3', '');        

        $no = 1;        
        $counter = 5;
        $begining = 0;
        $TDR = 0;
        $TCR = 0;
        if ($this->input->get('type') == 'USD') {
                $type = 'US$';
            } else {
                $type = 'SGD$';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B4', "")
                    ->setCellValue('C4', $type);
            
        if (!empty($data)) {
                         $hasilakhir = 0; $hasil = 0;  $hasil2 =0; $tt_totald = 0; $tt_totalk = 0;
                         $hasilakhir_2 = 0;  $hasil_2  = 0; $hasil2_2 = 0; $tt_totald_2  = 0; $tt_totalk_2  = 0;
                         $hasilakhir_3 = 0;  $hasil_3  = 0; $hasil2_3 = 0; $tt_totald_3  = 0; $tt_totalk_3  = 0;
                         $hasilakhir_4 = 0;  $hasil_4  = 0; $hasil2_4 = 0; $tt_totald_4  = 0; $tt_totalk_4  = 0; $hasil_5  = 0;
                            $TDR = 0;
                            $TCR = 0;
                                foreach ($data as $v):                                
                                    if ($v->id_group=='215' || $v->id_group=='217') {
                                        $hasil = $v->MTKredit-$v->MTDebet;
                                        $hasilakhir += $hasil;
                                         if ($hasil < 0) {
                                            $hasil2 = $hasil;
                                            // $b = str_replace("-", "", $hasil);
                                            // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                                        } elseif ($hasil == 0) {
                                            $hasil2 = '-';
                                        } else {
                                            $hasil2 = $hasil;
                                        }
                                         $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A' . $counter, $no++)
                                            ->setCellValue('B' . $counter, $v->nama_group)
                                            ->setCellValue('C' . $counter, $hasil2);
                                        $counter++;
                                    } 
                                 endforeach;  
                                      
			 $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter,  "Gross Profit")
                            ->setCellValue('C' . $counter, '=SUM(C5:C6)');
				$counter++; 
                                foreach ($data as $g) :
                                if ($g->id_group=='216') {
                                    $hasil_3 = $g->MTKredit-$g->MTDebet;

                                    $hasilakhir3 = $hasilakhir+$hasil_3;
                                    //$hasilakhir3 = $hasilakhir1-$hasilakhir2;
                                     if ($hasil_3 < 0) {
                                        $hasil2_3 =$hasil_3;

                                        // $b = str_replace("-", "", $hasil);
                                        // $hasil2 = "" . number_format($b, 2, '.', ',') . "";
                                    } elseif ($hasil_3 == 0) {
                                        $hasil2_3 = 0;
                                    } else {
                                        $hasil2_3 = $hasil_3;
                                    }
                                    $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue('A' . $counter, $no++)
                                            ->setCellValue('B' . $counter, $g->nama_group)
                                            ->setCellValue('C' . $counter, $hasil2_3);
                                    $counter++;
                                    
                                                  
			 $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter,  "")
                            ->setCellValue('C' . $counter, '=SUM(C7:C8)');
				$counter++; 
                                }
                                 endforeach;
                                foreach ($data as $g):
                                    if ($g->id_group=='218' || $g->id_group=='219' ) {
                                        $hasil_4 = $g->MTKredit-$g->MTDebet;
                                        $hasil_5 += $hasil_4;                                        
                                         if ($hasil_4 < 0) {
                                            $hasil2_4 =$hasil_4;
                                        } elseif ($hasil_4 == 0) {
                                            $hasil2_4 = 0;
                                        } else {
                                            $hasil2_4 = $hasil_4;
                                        }
                                        $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue('A' . $counter, $no++)
                                                ->setCellValue('B' . $counter, $g->nama_group)
                                                ->setCellValue('C' . $counter, $hasil2_4);
                                        $counter++;
                                    }                                
                                 endforeach;
                                $hasilakhir4 = $hasilakhir3+$hasil_5;
			$objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter,  "Profit /( Loss ) Before Tax")
                            ->setCellValue('C' . $counter, '=SUM(C9:C11)');
				$counter++;                                 
                                 }        
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

        $objPHPExcel->getActiveSheet()->setTitle('Profit & Loss Statement');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_Loss_Statement.xlsx"');
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


    function toExcelProduct_9() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $id = $this->input->get('idp');
        $tgl1 = dmy_to_ymd($this->input->get('posting_date1'));
        $tgl2 = dmy_to_ymd($this->input->get('posting_date2'));
        $data = $this->M_factory->getDataPro($id, $tgl1, $tgl2);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A3', 'Product Name')
                ->setCellValue('B3', 'Brand')
                ->setCellValue('C3', 'Pack Size')
                ->setCellValue('D3', 'Quantity')
                ->setCellValue('E3', 'UOM')
                ->setCellValue('F3', '')
                ->setCellValue('G3', 'Price')
                ->setCellValue('H3', '')
                ->setCellValue('I3', 'Total');
                


        $no = 1;
        $counter = 4;
        foreach ($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $v->product_name)
                    ->setCellValue('B' . $counter, $v->brand_name)
                    ->setCellValue('C' . $counter, $v->packing_view)
                    ->setCellValue('D' . $counter, $v->quantity)
                    ->setCellValue('E' . $counter, $v->uom_quantity_name)
                    ->setCellValue('F' . $counter, $v->currency_id)
                    ->setCellValue('G' . $counter, $v->price)
                    ->setCellValue('H' . $counter, $v->currency_id)
                    ->setCellValue('I' . $counter, $v->price);
            $counter++;
        endforeach;


        $objPHPExcel->getActiveSheet()->setTitle('Sales Product Stock');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales_Product_Stock.xlsx"');
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

    function toExcelSalesVolume() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('from'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("to"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $sales_person = str_replace(' ', '-', $this->input->get('sales_person'));

        $data = $this->M_Sales_Volume->call_sales_report($p_dari, $p_sampai, $sales_person);
        $customer_list = $this->M_Sales_Volume->get_datacustomer($p_dari, $p_sampai, $sales_person);
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                ),
                'fill' =>array(
                    'type'      =>PHPExcel_Style_Fill::FILL_SOLID,
                    'color'     =>array('rgb' => 'f1f1f1')
                    )
            ); 
        $header2 = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        ); 
        $borderNON = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                    'right' => array('style' => PHPExcel_Style_Border::BORDER_NONE),
                    'left' => array('style' => PHPExcel_Style_Border::BORDER_NONE)
                ),
                'font' => array(
                    'bold' => false,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );  

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle("A1:H1")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->getStyle("A2:H2")
                ->applyFromArray($header2)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);


        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('A1', $title)
                ->setCellValue('A1', 'Sales Value / Volume Report')
                ->setCellValue('A2', date('Y-m-d', strtotime($dari)) .' - '. date('Y-m-d', strtotime($sampai)));
        $no = 1;
        $counter = 3;   
        if (!empty($data)) 
        {
            foreach ($customer_list as $row_customer):
                $objPHPExcel->getActiveSheet()->getStyle('B'. $counter.':G' . $counter)
                        ->applyFromArray($header)
                        ->getFont()->setSize(10);  
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':G' . $counter);           
                $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('B' . $counter, $row_customer->custcompany);
                
                $counter++;
                $invno = 0;
                $productname = 0;
                $qty = 0;
                $unitprice = 0;
                $total = 0;
                $sales_id = 0;

                $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
                $objPHPExcel->setActiveSheetIndex(0)
                        // ->setCellValue('B3', 'Supplier')
                        ->setCellValue('B'.$counter, 'Invoice Number')
                        ->setCellValue('C'.$counter, 'Item Name')
                        ->setCellValue('D'.$counter, 'Quantity (KG/MT)')
                        ->setCellValue('E'.$counter, 'Price per Unit')
                        ->setCellValue('F'.$counter, 'Sales Amount (USD)')
                        ->setCellValue('G'.$counter, 'Sales Person');
                $counter++;    
            foreach ($data as $row_tampilsales):
                if ($row_tampilsales->custid == $row_customer->custid) 
                {
                    $invno += $row_tampilsales->invno;
                    $productname += $row_tampilsales->productname;
                    $qty += $row_tampilsales->qty;
                    $unitprice += $row_tampilsales->unitprice;
                    $total += $row_tampilsales->total;
                    $sales_id += $row_tampilsales->sales_id;

                    $objPHPExcel->setActiveSheetIndex(0)
                            //->setCellValue('A' . $counter, $no++)
                            ->setCellValue('B' . $counter, $row_tampilsales->invno)
                            ->setCellValue('C' . $counter, $row_tampilsales->productname)
                            ->setCellValue('D' . $counter, $row_tampilsales->qty)
                            ->setCellValue('E' . $counter, $row_tampilsales->unitprice)
                            ->setCellValue('F' . $counter, $row_tampilsales->total)
                            ->setCellValue('G' . $counter, $row_tampilsales->sales_id);
                    $counter++;

                }
                endforeach;
                $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('B'. $counter.':D' . $counter);                
                $objPHPExcel->setActiveSheetIndex(0)                
                            ->setCellValue('B' . $counter,  "Grand Total")
                            ->setCellValue('E' . $counter, $unitprice)
                            ->setCellValue('F' . $counter, $total);
                $counter++;
                // $objPHPExcel->getActiveSheet()->getStyle('B'.$counter.':G'.$counter)
                // ->applyFromArray($borderNON);
                // $objPHPExcel->getActiveSheet()->mergeCells('B'.$counter.':G'.$counter);
                // $counter++;
                endforeach;

                
                $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
                }
                $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );

                
                $objPHPExcel->getActiveSheet()->getStyle('B3:G' . $jlh)->applyFromArray($styleArray);

                // $objPHPExcel->getActiveSheet()->setTitle('Sales Value / Volume Report');
                $objPHPExcel->setActiveSheetIndex(0);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Sales_Volume.xlsx"');
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

    function toExcelPnL()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $hide = $this->input->get('hide');
        $dept = $this->input->get('dept');
        $comp = $this->input->get('comp');
        $cur = $this->input->get('cur');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $bulan_awal = date('m', strtotime($this->input->get('dari')));
        $awal = date('Y-m-d', strtotime($this->input->get('dari')));

        $bulan_akhir = date('m', strtotime($this->input->get('sampai')));
        $akhir = date('Y-m-d', strtotime($this->input->get('sampai')));

        $tahun_awal = date('Y', strtotime($this->input->get('dari')));
        $tahun_akhir = date('Y', strtotime($this->input->get('sampai')));

        $aw = intval(date('m', strtotime($this->input->get('dari'))));
        $ak = intval(date('m', strtotime($this->input->get('sampai'))));

        $timeStart = strtotime($this->input->get('dari'));
        $timeEnd = strtotime($this->input->get("sampai"));
        $numBulan = 1 + (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
        $numBulan  += date("m", $timeEnd) - date("m", $timeStart);
        $jumlah_bulan = $numBulan;

        if ($p_dari > '2024-12-31' and $p_sampai > '2024-12-31') {
            $get_invoice = $this->M_Profit_and_loss->get_data_2025($p_dari, $p_sampai,$dept, $comp, $cur);
         }else if ($p_dari <= '2024-12-31' and $p_sampai <= '2024-12-31') {
            $get_invoice = $this->M_Profit_and_loss->get_data($p_dari, $p_sampai);
         }else{
            $data['_result']='';
            $data['info']= 'cannot combine all data new 2025 with under 2025';
         }
        

        // print_r($get_invoice);
        // die;

        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );

        $color = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E1E0F7'),
            )
        );

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
            ->applyFromArray($header)
            ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
        $objPHPExcel->getActiveSheet()->getStyle("A3:I3")
            ->applyFromArray($header)
            ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
        $objPHPExcel->getActiveSheet()->getStyle("A4:I4")
            ->applyFromArray($header)
            ->getFont()->setSize(12);

        //$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);




        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('A3', 'Reg No. 201734570K')
            ->setCellValue('A4', 'TRADING, PROFIT & LOSS FOR THE PERIOD (' . $p_dari . ') - (' . $p_sampai . ')');


        $bln_awal = $bulan_awal - 1;
        $bln_akhir = $bulan_akhir - 1;

        $colNumber = 2;
        $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', '')
            ->setCellValue('C3', '');

        $no = 0;
        $w = 0;
        $counter = 9;
        $rowheadertahun = 7;
        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i - 1;
            $Bln = date('Y', strtotime('+' . $b . ' month', strtotime($dari)));

            $nomor = $bulan_awal + $w++;
            if ($nomor > 12) {
                $tahun = $Bln + 1;
            } else {
                $tahun = $Bln;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '7', $tahun);

            $colStringHdr++;
        }
        if ($jumlah_bulan > 1) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '7', $tahun);
            $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
        }
        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i - 1;
            $namaBln = date('F', strtotime('+' . $b . ' month', strtotime($dari)));

            if ($hide != '1') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr . '8', $namaBln);
                $colStringHdr++;
            }
        }
        if ($jumlah_bulan > 1) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '8', 'Total');
        }
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

    

        $s1 = 0;
        $counter = 9;
        foreach ($get_invoice as $v) :
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->t_coaname);
            $objPHPExcel->getActiveSheet()->getStyle('A126')
                ->applyFromArray($color)
                ->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('A61')
                ->applyFromArray($color)
                ->getFont()->setSize(10);
            $counter++;
        endforeach;

        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i - 1;
            if ($jumlah_bulan == 1) {
                $new_awal = $awal;
                $new_akhir = $akhir;
            } else {
                switch ($i) {
                    case 1:
                        $new_awal = $awal;
                        $new_akhir = date('Y-m-t', strtotime($dari));
                        break;
                    case $jumlah_bulan:
                        $new_awal = date('Y-m-01', strtotime($sampai));
                        $new_akhir = $akhir;
                        break;
                    default:
                        $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari)));
                        $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari)));
                        break;
                }
            }
            $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
            $counterlb = 9;
            foreach ($get_invoice as $r) {
                for ($i = $aw; $i <= $ak; $i++) {
                    if ($i == 1) {
                        $t1 = $r->t_1;
                    
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 2) {
                        $t1 = $r->t_2;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 3) {
                        $t1 = $r->t_3;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 4) {
                        $t1 = $r->t_4;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 5) {
                        $t1 = $r->t_5;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 6) {
                        $t1 = $r->t_6;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 7) {
                        $t1 = $r->t_7;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 8) {
                        $t1 = $r->t_8;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 9) {
                        $t1 = $r->t_9;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 10) {
                        $t1 = $r->t_10;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 11) {
                        $t1 = $r->t_11;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 12) {
                        $t1 = $r->t_12;
                        
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    }
                    

                }
                
                
                    $t1 = $r->t_13;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                    $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '61')->applyFromArray($color)->getFont()->setSize(10);
                    $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '126')->applyFromArray($color)->getFont()->setSize(10);
                    $colStringgeneral++;
              

                $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
                $counterlb++;
            }
        }


        $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );


        $objPHPExcel->getActiveSheet()->setTitle('PROFIT AND LOST');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_Lost.xlsX"');
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


    function toExcelPnL2()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $hide = $this->input->get('hide');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $bulan_awal = date('m', strtotime($this->input->get('dari')));
        $awal = date('Y-m-d', strtotime($this->input->get('dari')));

        $bulan_akhir = date('m', strtotime($this->input->get('sampai')));
        $akhir = date('Y-m-d', strtotime($this->input->get('sampai')));

        $tahun_awal = date('Y', strtotime($this->input->get('dari')));
        $tahun_akhir = date('Y', strtotime($this->input->get('sampai')));

        $aw = intval(date('m', strtotime($this->input->get('dari'))));
        $ak = intval(date('m', strtotime($this->input->get('sampai'))));

        $timeStart = strtotime($this->input->get('dari'));
        $timeEnd = strtotime($this->input->get("sampai"));
        $numBulan = 1 + (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
        $numBulan  += date("m", $timeEnd) - date("m", $timeStart);
        $jumlah_bulan = $numBulan;


        
        
        $get_invoice = $this->M_Profit_and_loss->get_data($p_dari, $p_sampai);
        // echo "<pre>";
        // print_r ($get_invoice);
        // echo "</pre>";
        // die;
        
    
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );

        $color = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E1E0F7'),
            )
        );

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
            ->applyFromArray($header)
            ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
        $objPHPExcel->getActiveSheet()->getStyle("A3:I3")
            ->applyFromArray($header)
            ->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
        $objPHPExcel->getActiveSheet()->getStyle("A4:I4")
            ->applyFromArray($header)
            ->getFont()->setSize(12);

        //$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);




        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('A3', 'Reg No. 201734570K')
            ->setCellValue('A4', 'TRADING, PROFIT & LOSS FOR THE PERIOD (' . $p_dari . ') - (' . $p_sampai . ')');


        $bln_awal = $bulan_awal - 1;
        $bln_akhir = $bulan_akhir - 1;

        $colNumber = 2;
        $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3', '')
            ->setCellValue('C3', '');



        $no = 0;
        $w = 0;
        $counter = 9;
        $rowheadertahun = 7;
        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i;
            $Bln = date('Y', strtotime('+' . $b . ' month', strtotime($dari)));

            $nomor = $bulan_awal + $w++;
            if ($nomor > 12) {
                $tahun = $Bln + 1;
            } else {
                $tahun = $Bln;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '7', $tahun);

            $colStringHdr++;
        }
        if ($jumlah_bulan > 1) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '7', $tahun);
            $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
        }
        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i - 1;
            $namaBln = date('F', strtotime('+' . $b . ' month', strtotime($dari)));

            if ($hide != '1') {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr . '8', $namaBln);
                $colStringHdr++;
            }
        }
        if ($jumlah_bulan > 1) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($colStringHdr . '8', 'Total');
        }
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        // $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00');
        // $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00');

        //  $objPHPExcel->getActiveSheet()->getStyle('B9:P100')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

 
        $s1 = 0;
        $counter = 9;
        foreach ($get_invoice as $v) :
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->t_coaname);
            $objPHPExcel->getActiveSheet()->getStyle('A113')
                ->applyFromArray($color)
                ->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('A51')
                ->applyFromArray($color)
                ->getFont()->setSize(10);
            $counter++;
        endforeach;

        for ($i = 1; $i <= $jumlah_bulan; $i++) {
            $b = $i - 1;
            if ($jumlah_bulan == 1) {
                $new_awal = $awal;
                $new_akhir = $akhir;
            } else {
                switch ($i) {
                    case 1:
                        $new_awal = $awal;
                        $new_akhir = date('Y-m-t', strtotime($dari));
                        break;
                    case $jumlah_bulan:
                        $new_awal = date('Y-m-01', strtotime($sampai));
                        $new_akhir = $akhir;
                        break;
                    default:
                        $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari)));
                        $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari)));
                        break;
                }
            }
            $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
            $counterlb = 9;
            
      
            foreach ($get_invoice as $r) {
                for ($i = $aw; $i <= $ak; $i++) {

             
                    if ($i == 1) {
                        if ($r->t_1 < 0) {
                            $t1 = $r->t_1;
                           // $t1 = number_format(abs($r->t_1),2);
                        } else {
                            $t1 = $r->t_1;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        // $objPHPExcel->getActiveSheet()->setCellValueExplicit('B9', '1234', PHPExcel_Cell_DataType::TYPE_STRING);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '15')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 2) {
                        if ($r->t_2 < 0) {
                           // $t1 = abs($r->t_2);
                           $t1 = $r->t_2;
                        } else {
                            $t1 = $r->t_2;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 3) {
                        if ($r->t_3 < 0) {
                            // $t1 = abs($r->t_3);
                            $t1 = $r->t_3;
                        } else {
                            $t1 = $r->t_3;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 4) {
                        if ($r->t_4 < 0) {
                            // $t1 = abs($r->t_4);
                            $t1 = $r->t_4;
                        } else {
                            $t1 = $r->t_4;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 5) {
                        if ($r->t_5 < 0) {
                            // $t1 = abs($r->t_5);
                            $t1 = $r->t_5;
                        } else {
                            $t1 = $r->t_5;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 6) {
                        if ($r->t_6 < 0) {
                            // $t1 = abs($r->t_6);
                            $t1 = $r->t_6;
                        } else {
                            $t1 = $r->t_6;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 7) {
                        if ($r->t_7 < 0) {
                            // $t1 = abs($r->t_7);
                            $t1 = $r->t_7;
                        } else {
                            $t1 = $r->t_7;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 8) {
                        if ($r->t_8 < 0) {
                            // $t1 = abs($r->t_8);
                            $t1 = $r->t_8;
                        } else {
                            $t1 = $r->t_8;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 9) {
                        if ($r->t_9 < 0) {
                            // $t1 = abs($r->t_9);
                            $t1 = $r->t_9;
                        } else {
                            $t1 = $r->t_9;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 10) {
                        if ($r->t_10 < 0) {
                            // $t1 = abs($r->t_10);
                            $t1 = $r->t_10;
                        } else {
                            $t1 = $r->t_10;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 11) {
                        if ($r->t_11 < 0) {
                           // $t1 = abs($r->t_11);
                           $t1 = $r->t_11;
                        } else {
                            $t1 = $r->t_11;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    } else if ($i == 12) {
                        if ($r->t_12 < 0) {
                            // $t1 = abs($r->t_12);
                            $t1 = $r->t_12;
                        } else {
                            $t1 = $r->t_12;
                        }
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $t1);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                        $colStringgeneral++;
                    }
                }
                // if ($r->t_13 < 0) {
                //     // $t13 = abs($r->t_13);
                //     $t1 = $r->t_13;
                // } else {
                    $t13 = $r->t_13;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral . $counterlb, $r->t_13);
                    $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '51')->applyFromArray($color)->getFont()->setSize(10);
                    $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral . '113')->applyFromArray($color)->getFont()->setSize(10);
                    $colStringgeneral++;
                // }

                $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
                $counterlb++;
            }
        }


        $header = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'name' => 'Verdana'
            )
        );


        $objPHPExcel->getActiveSheet()->setTitle('PROFIT AND LOST');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_Lost.xlsX"');
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

    function toExcelPnL_old() {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $hide = $this->input->get('hide');

        $p_dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $p_sampai = date('Y-m-d', strtotime($this->input->get("sampai")));

        $bulan_awal = date('m', strtotime($this->input->get('dari')));
        $awal = date('Y-m-d', strtotime($this->input->get('dari')));

        $bulan_akhir = date('m', strtotime($this->input->get('sampai')));
        $akhir = date('Y-m-d', strtotime($this->input->get('sampai')));

        $tahun_awal = date('Y', strtotime($this->input->get('dari')));
        $tahun_akhir = date('Y', strtotime($this->input->get('sampai')));

        $aw = intval(date('m', strtotime($this->input->get('dari'))));
        $ak = intval(date('m', strtotime($this->input->get('sampai'))));

        $timeStart = strtotime($this->input->get('dari'));
        $timeEnd = strtotime($this->input->get("sampai"));
        $numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
        $numBulan  += date("m",$timeEnd)-date("m",$timeStart);
        $jumlah_bulan=$numBulan;


        $get_invoice = $this->M_Profit_and_loss->get_data($p_dari, $p_sampai);

        $header = array(
            'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
        );

         $color = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                ),
                'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            )
            ); 

        $objPHPExcel = new PHPExcel();       
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getStyle("A2:I2")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
                 $objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
        $objPHPExcel->getActiveSheet()->getStyle("A3:I3")
                ->applyFromArray($header)
                ->getFont()->setSize(12);
                $objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
        $objPHPExcel->getActiveSheet()->getStyle("A4:I4")
                ->applyFromArray($header)
                ->getFont()->setSize(12);

        //$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);


      
        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2' , 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('A3' , 'Reg No. 201734570K')
            ->setCellValue('A4' , 'TRADING, PROFIT & LOSS FOR THE PERIOD ('.$p_dari.') - ('.$p_sampai.')');
   
         
                $bln_awal = $bulan_awal - 1;
                $bln_akhir = $bulan_akhir - 1;
            
            $colNumber =2;
            $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B3', '')
                ->setCellValue('C3', ''); 

            $no = 0;
            $w = 0;
            $counter = 9;
            $rowheadertahun=7;
            for ($i = 1; $i <= $jumlah_bulan; $i++) {
                $b=$i;
                $Bln = date('Y', strtotime('+'.$b.' month', strtotime($dari)));

                $nomor = $bulan_awal + $w++;
                if ($nomor > 12) {
                    $tahun = $Bln + 1;
                } else {
                    $tahun = $Bln;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'7',$tahun);

                $colStringHdr++;
            }
            if ($jumlah_bulan > 1) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'7',$tahun);
                $colStringHdr = PHPExcel_Cell::stringFromColumnIndex('1');
            }
            for ($i = 1; $i <= $jumlah_bulan; $i++) {
                $b=$i-1;
                                            $namaBln = date('F', strtotime('+'.$b.' month', strtotime($dari)));

                                            if($hide != '1'){
                                                $objPHPExcel->setActiveSheetIndex(0)
                                                ->setCellValue($colStringHdr.'8',$namaBln);
                                            $colStringHdr++;
                                               
                                            }
            }
            if ($jumlah_bulan > 1) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colStringHdr.'8','Total');

            }
            $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
            $objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');


            $s1 = 0;
            $counter=9;
            foreach($get_invoice as $v):
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$counter, $v->t_coaname);
                $objPHPExcel->getActiveSheet()->getStyle('A17')
                                        ->applyFromArray($color)
                                        ->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle('A38')
                                        ->applyFromArray($color)
                                        ->getFont()->setSize(10);
                 $counter++;
            endforeach;

            for ($i = 1; $i <=$jumlah_bulan; $i++) {
                $b=$i-1;
                if ($jumlah_bulan == 1) {
                    $new_awal=$awal;
                    $new_akhir=$akhir;
                } else{
                    switch ($i) {
                        case 1:
                            $new_awal=$awal;
                            $new_akhir=date('Y-m-t', strtotime($dari));
                            break;
                        case $jumlah_bulan:
                            $new_awal=date('Y-m-01', strtotime($sampai));
                            $new_akhir=$akhir;
                            break;
                        default:
                            $new_awal=date('Y-m-01', strtotime('+'.$b.' month', strtotime($dari)));
                            $new_akhir=date('Y-m-t', strtotime('+'.$b.' month', strtotime($dari)));
                            break;
                    }
                }
                        $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
                        $counterlb=9;
                        foreach ($get_invoice as $r) {
                            for($i= $aw; $i <= $ak; $i++){
                                if($i == 1){ if($r->t_1 < 0)
                                    {$t1 = number_format(abs($r->t_1),2);}else{$t1 = number_format($r->t_1,2);}
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 2){ if($r->t_2 < 0)
                                    {$t1 = number_format(abs($r->t_2),2);}else
                                    {$t1 = number_format($r->t_2,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                       $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 3){ if($r->t_3 < 0)
                                    {$t1 = number_format(abs($r->t_3),2);}else
                                    {$t1 = number_format($r->t_3,2);} 
                                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 4){ if($r->t_4 < 0)
                                    {$t1 = number_format(abs($r->t_4),2);}else
                                    {$t1 = number_format($r->t_4,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 5){ if($r->t_5 < 0)
                                    {$t1 = number_format(abs($r->t_5),2);}else
                                    {$t1 = number_format($r->t_5,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 6){ if($r->t_6 < 0)
                                    {$t1 = number_format(abs($r->t_6),2);}else
                                    {$t1 = number_format($r->t_6,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 7){ if($r->t_7 < 0)
                                    {$t1 = number_format(abs($r->t_7),2);}else
                                    {$t1 = number_format($r->t_7,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 8){ if($r->t_8 < 0)
                                    {$t1 = number_format(abs($r->t_8),2);}else
                                    {$t1 = number_format($r->t_8,2);} \
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 9){ if($r->t_9 < 0)
                                    {$t1 = number_format(abs($r->t_9),2);}else
                                    {$t1 = number_format($r->t_9,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 10){ if($r->t_10 < 0)
                                    {$t1 = number_format(abs($r->t_10),2);}else
                                    {$t1 = number_format($r->t_10,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 11){ if($r->t_11 < 0)
                                    {$t1 = number_format(abs($r->t_11),2);}else
                                    {$t1 = number_format($r->t_11,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                                else if($i == 12){ if($r->t_12 < 0)
                                    {$t1 = number_format(abs($r->t_12),2);}else
                                    {$t1 = number_format($r->t_12,2);} 
                                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t1);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                                }
                            }
                            if($r->t_13 < 0)
                                {$t13 =number_format(abs($r->t_13),2);}else
                            {$t13 = number_format($r->t_13,2);
                                setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colStringgeneral.$counterlb, $t13);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'17')->applyFromArray($color)->getFont()->setSize(10);
                                        $objPHPExcel->getActiveSheet()->getStyle($colStringgeneral.'38')->applyFromArray($color)->getFont()->setSize(10);
                                        $colStringgeneral++;
                            }

                             $colStringgeneral = PHPExcel_Cell::stringFromColumnIndex('1');
                                        $counterlb++;
                        }
                   
                         
                
        }
                                    
    
            $header = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'name' => 'Verdana'
                )
            );


        $objPHPExcel->getActiveSheet()->setTitle('PROFIT AND LOST');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Profit_Lost.xlsx"');
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

/**
     * Fungsi ini digunakan untuk menghasilkan laporan ketidaksesuaian dalam format Excel dan mengirimkannya sebagai unduhan ke pengguna.
     */
    function toExcelNonConformanceContainer()
    {
        // Konfigurasi pelaporan kesalahan dan pengaturan zona waktu
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        // Mengambil parameter permintaan dari input
        $get = $this->input->get();

        // Membuat instansi PHPExcel baru dan mendapatkan lembar aktif
        $phpExcel = new PHPExcel();
        $sheet = $phpExcel->getActiveSheet();

        // Mengatur gaya huruf tebal untuk baris header
        $boldFont = new PHPExcel_Style_Font();
        $boldFont->setBold(true);
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        // Menambahkan border ke sel header
        $styleHeader = $sheet->getStyle('A1:H1');
        $styleHeader->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // Mendefinisikan header kolom untuk lembar Excel
        $headers = ['S/No', 'Container Number', 'Fwrder/MLO', 'Shipment Date', 'PO', 'Issue', 'QAD Remarks', 'QAD Verification'];
        $columnIndex = 0;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($columnIndex++, 1, $header);
        }

        // Menyiapkan parameter untuk mengambil data ketidaksesuaian
        $param = [
            'shipment_date' => $get['shipment-date'],
            'qad_verification' => $get['qad-verification'],
            'factory_abbr' => $get['factory-abbr']
        ];

        // Mengambil data ketidaksesuaian dari model Container
        $data = $this->Container->getContainerConformance($param, $param['shipment_date'], $param['shipment_date']);

        // Menginisialisasi array untuk menyimpan baris data Excel
        $listData = [];

        // Menginisialisasi indeks baris dan penghitung untuk penomoran baris
        $rowIndex = 2;
        $counter = 1;

        // Meloop data ketidaksesuaian dan mengisi baris Excel
        foreach ($data['containerNonConformance'] as $row) {
            $sheet->setCellValue('A' . $rowIndex, $counter);
            $sheet->setCellValue('B' . $rowIndex, $row->container_number);
            $sheet->setCellValue('C' . $rowIndex, $row->shipping);
            $sheet->setCellValue('D' . $rowIndex, date('d/m/Y', strtotime($row->shipment_date)));

            // Menyiapkan dan memformat nomor PO
            $poNumbers = [];
            foreach ($data['contExport'][$row->container_number] as $contExp) {
                $poNumbers[] = $contExp->po_number;
            }
            $poNumbersString = implode(', ', $poNumbers);

            // Mengisi sel-sel Excel dengan data
            $sheet->setCellValue('E' . $rowIndex, $poNumbersString);
            $sheet->setCellValue('F' . $rowIndex, $row->issue);
            $sheet->setCellValue('G' . $rowIndex, $row->qad_remarks);
            $sheet->setCellValue('H' . $rowIndex, $row->qad_verification);

            // Menambahkan border ke sel-sel data
            $styleData = $sheet->getStyle('A' . $rowIndex . ':H' . $rowIndex);
            $styleData->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            // Pindah ke baris berikutnya dan menambah penghitung
            $rowIndex++;
            $counter++;
        }

        // Menyesuaikan otomatis lebar kolom untuk format yang lebih baik
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Mengatur lembar aktif dan membuat penulis Excel
        $phpExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');

        // Mengirim header yang sesuai untuk unduhan berkas Excel
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="NonConformanceReport.xls"');
        header('Cache-Control: max-age=0');

        // Menyimpan berkas Excel ke output dan keluar
        $objWriter->save('php://output');
        exit;
    }




    function toExcelReceivableInvoice1(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');

    $company_id   = strtoupper($this->session->userdata('company_id'));
    $dari         = $this->input->get('dari');
    $sampai       = $this->input->get('sampai');
    $jenis_trans  = $this->input->get('jenis_trans');
    $noreference  = $this->input->get('noreference');
    $jenis_coa    = $this->input->get('jenis_coa');

    // Ambil data berdasarkan company_id
    if ($company_id == '1') {
        $_tampil_item = $this->M_All_Transaction_rec->hasil($dari, $sampai, $jenis_trans, 'nofaktur', 'desc');
    } else {
        $_tampil_item = $this->M_All_Transaction_rec->hasil_zht($dari, $sampai, $jenis_trans, 'nofaktur', 'desc');
    }

    require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Set lebar kolom
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    for ($i = 1; $i <= 13; $i++) {
        $col = $this->getNameFromNumber($i);
        $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
        if ($i > 5) {
            $objPHPExcel->getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        }
    }

    $styleArray = [
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ];

    $header = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'name' => 'Verdana'
        ]
    ];

    $counter = 4;

    // Header kolom
    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':N' . $counter)->applyFromArray($header)->getFont()->setSize(10);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $counter, 'NO')
        ->setCellValue('B' . $counter, 'Date')
        ->setCellValue('C' . $counter, 'No. Reff')
        ->setCellValue('D' . $counter, 'Vendor')
        ->setCellValue('E' . $counter, 'Currency')
        ->setCellValue('F' . $counter, 'Rate')
        ->setCellValue('G' . $counter, 'Tax')
        ->setCellValue('H' . $counter, 'Discount')
        ->setCellValue('I' . $counter, 'Add Cost')
        ->setCellValue('J' . $counter, 'Deposit')
        ->setCellValue('K' . $counter, 'Debit Note')
        ->setCellValue('L' . $counter, 'Credit Note')
        ->setCellValue('M' . $counter, 'Total')
        ->setCellValue('N' . $counter, 'Payment');

    $counter++;
    $no = 1;

    if (!empty($_tampil_item)) {
        foreach ($_tampil_item as $m) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $m->tanggal)
                ->setCellValue('C' . $counter, $m->nofaktur)
                ->setCellValue('D' . $counter, $m->namacustomer . "\n" . $m->address)
                ->setCellValue('E' . $counter, $m->currency)
                ->setCellValue('F' . $counter, $m->rate)
                ->setCellValue('G' . $counter, $m->pajak)
                ->setCellValue('H' . $counter, $m->diskon)
                ->setCellValue('I' . $counter, $m->biaya_lain)
                ->setCellValue('J' . $counter, $m->uang_muka)
                ->setCellValue('K' . $counter, $m->nota_debet)
                ->setCellValue('L' . $counter, $m->nota_kredit)
                ->setCellValue('M' . $counter, $m->piutang)
                ->setCellValue('N' . $counter, $m->bayar);
            $counter++;
        }
    }

    $objPHPExcel->getActiveSheet()->getStyle('A4:N' . ($counter - 1))->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setTitle('All Transaction Receivable');
    $objPHPExcel->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="All_Transaction_Receivable.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}


function toExcelBlCode(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');

    $dari         = $this->input->get('dari');
    $sampai       = $this->input->get('sampai');
    $dept_code    = $this->input->get('dept_code');

    $this->load->model('M_Bl_code_ZHL');

    $_tampil_item = $this->M_Bl_code_ZHL->hasil($dari, $sampai, $dept_code);
    
    require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Default
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);

    $counter = 4;
    $header = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'name' => 'Verdana'
        ]
    ];

    // --- ATUR HEADER & ISI SESUAI dept_code ---
    if ($dept_code == '002') {
        // Tabel BU
        $columns = [
            'NO','B/L Code','Customer','Date','Receivable Recognition Ref. Number','Department Code',
            'Freight Income - BU','Barge Income - BU','Barge Freight Income - BU',
            'Local Income - BU','Trucking Income - BU','Management fee - Handling charge - BU','Cash Bank Ref.','Ap Inv. Number','Ap Inv. Number',
            'Freight Charges - BU','Barge Charges - BU','Local Charges - BU','Trucking Charges - BU',
            'Insurance - Marine Insurance Expenses - BU','Gross Profit'
        ];
    } else if ($dept_code == '003') {
        // Tabel FF
        $columns = [
            'NO','B/L Code','Customer','Date','Receivable Recognition Ref. Number','Department Code',
            'Freight Income - FF ','Barge Freight Income - FF ','Barge Income - FF ','Local Income - FF ',
            'Trucking Income - FF ','Cash Bank Ref.','Ap Inv. Number', 'Ap Inv. Number',
            'Freight Charges - FF ','Barge Charges - FF ','Local Charges - FF',
            'Trucking Charges - FF ','Insurance - Marine Insurance Expenses - FF ','Gross Profit'
        ];
    } else {
        // Jika kode lain/empty
        $columns = ['NO','B/L Code','Customer','Date','Dept Code','Keterangan'];
    }

    // Set header ke Excel
    $colAlpha = 'A';
    foreach ($columns as $col) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($colAlpha . $counter, $col);
        $objPHPExcel->getActiveSheet()->getColumnDimension($colAlpha)->setWidth(20);
        $colAlpha++;
    }
    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':' . chr(ord('A') + count($columns) - 1) . $counter)->applyFromArray($header)->getFont()->setSize(10);

    $counter++;
    $no = 1;

    // --- Data ke Excel ---
    if (!empty($_tampil_item)) {
        foreach ($_tampil_item as $item) {
            $item->total_sum_amount = $this->M_Bl_code_ZHL->get_total_sum_amount($item->blCode);
            $item->total_sum_amount_1 = $this->M_Bl_code_ZHL->get_total_sum_amount_a($item->blCode);


            $colAlpha = 'A';
            if ($dept_code == '002') {
                // Kolom BU
                $total_formula = (
                    floatval($item->amount_500202_002_001)
                    + floatval($item->amount_500101_002_001)
                    + floatval($item->amount_500109_002_001)
                    + floatval($item->amount_500105_002_001)
                    + floatval($item->amount_500203_002_001)
                    + floatval($item->amount_500107_002_001)
                    - floatval($item->amount_600101_002_001)
                    - floatval($item->amount_600102_002_001)
                    - floatval($item->amount_600103_002_001)
                    - floatval($item->amount_600104_002_001)
                    - floatval($item->total_sum_amount)
                );
                $row = [
                    $no++,
                    $item->blCode,
                    $item->customer_name,
                    date('d-m-Y', strtotime($item->Tanggal)),
                    $item->HeaderID,
                    $item->dept_code,
                    $item->amount_500202_002_001,
                    $item->amount_500101_002_001,
                    $item->amount_500109_002_001,
                    $item->amount_500105_002_001,
                    $item->amount_500203_002_001,
                    $item->amount_500107_002_001,
                    $item->no_reff,
                    $item->headerPR,
                    $item->headerPR_700071,
                    $item->amount_600101_002_001,
                    $item->amount_600102_002_001,
                    $item->amount_600103_002_001,
                    $item->amount_600104_002_001,
                    $item->total_sum_amount,
                    $total_formula
                ];
            } else if ($dept_code == '003') {
                // Kolom FF
                $total_formula = (
                    floatval($item->amount_500202_003_001)
                    + floatval($item->amount_500109_003_001)
                    + floatval($item->amount_500101_003_001)
                    + floatval($item->amount_500105_003_001)
                    + floatval($item->amount_500203_003_001)
                    - floatval($item->amount_600101_003_001)
                    - floatval($item->amount_600102_003_001)
                    - floatval($item->amount_600103_003_001)
                    - floatval($item->amount_600104_003_001)
                    - floatval($item->total_sum_amount_1)
                );
                $row = [
                    $no++,
                    $item->blCode,
                    $item->customer_name,
                    date('d-m-Y', strtotime($item->Tanggal)),
                    $item->HeaderID,
                    $item->dept_code,
                    $item->amount_500202_003_001,
                    $item->amount_500109_003_001,
                    $item->amount_500101_003_001,
                    $item->amount_500105_003_001,
                    $item->amount_500203_003_001,
                    $item->no_reff,
                    $item->headerPR_003,
                    $item->headerPR_700071_003,
                    $item->amount_600101_003_001,
                    $item->amount_600102_003_001,
                    $item->amount_600103_003_001,
                    $item->amount_600104_003_001,
                    $item->total_sum_amount_1,
                    $total_formula
                ];
            } else {
                // Default saja
                $row = [
                    $no++,
                    $item->blCode,
                    $item->customer_name,
                    $item->Tanggal,
                    $item->dept_code,
                    '-'
                ];
            }

            // Masukkan baris
            foreach ($row as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue($colAlpha . $counter, $v);
                $colAlpha++;
            }
            $counter++;
        }
    }

    // Style border tabel (optional)
    $lastCol = chr(ord('A') + count($columns) - 1);
    $styleArray = [
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ];
    $objPHPExcel->getActiveSheet()->getStyle('A4:' . $lastCol . ($counter-1))->applyFromArray($styleArray);

    // Nama Sheet
    $objPHPExcel->getActiveSheet()->setTitle('BL Code Report');
    $objPHPExcel->setActiveSheetIndex(0);

    // Output Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="BL_Code_Report.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

function toExcelBlCodeZHT(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');

    $dari   = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    $this->load->model('M_Bl_code_ZHT');

    $_tampil_item = $this->M_Bl_code_ZHT->hasil($dari, $sampai);

    require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Default
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);

    $counter = 4;
    $header = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'name' => 'Verdana'
        ]
    ];

    $columns = [
        'NO',
        'B/L Code',
        'Customer',
        'Date',
        'Receivable Recognition Ref. Number',
        '500115',
        'Date',
        'Cash Bank Ref.',
        '600011',
        'Balance'
    ];

    $colAlpha = 'A';
    foreach ($columns as $col) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($colAlpha . $counter, $col);
        $objPHPExcel->getActiveSheet()->getColumnDimension($colAlpha)->setWidth(20);
        $colAlpha++;
    }
    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':' . chr(ord('A') + count($columns) - 1) . $counter)->applyFromArray($header)->getFont()->setSize(10);

    $counter++;
    $no = 1;

    if (!empty($_tampil_item)) {
        foreach ($_tampil_item as $item) {
            $colAlpha = 'A';

            $row = [
                $no++,
                $item->containerNo,
                $item->customer_name,
                (!empty($item->created_date) && $item->created_date != '0000-00-00')
                    ? date('d-m-Y', strtotime($item->created_date))
                    : '',
                $item->nofaktur,
                // $item->debit,
                (!empty($item->debit) ? number_format($item->debit, 2) : ''),
                (!empty($item->tanggal) && $item->tanggal != '0000-00-00')
                    ? date('d-m-Y', strtotime($item->tanggal))
                    : '',
                $item->no_reff,  
                (!empty($item->debitAP) ? number_format($item->debitAP, 2) : ''), 
                (!empty($item->balance) ? number_format($item->balance, 2) : '')    
            ];

            foreach ($row as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue($colAlpha . $counter, $v);
                $colAlpha++;
            }
            $counter++;
        }
    }

    $lastCol = chr(ord('A') + count($columns) - 1);
    $styleArray = [
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ];
    $objPHPExcel->getActiveSheet()->getStyle('A4:' . $lastCol . ($counter-1))->applyFromArray($styleArray);

    // Nama Sheet
    $objPHPExcel->getActiveSheet()->setTitle('BL Code Report');
    $objPHPExcel->setActiveSheetIndex(0);

    // Output Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="BL_Code_Report_ZHT.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

function toExcelRRGT(){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

    $invoice            = $this->input->get("invoice");
    $dari               = str_replace('/', '-', $this->input->get('dari'));
    $p_dari             = date('Y-m-d', strtotime($dari));
    $sampai             = str_replace('/', '-', $this->input->get("sampai"));
    $p_sampai           = date('Y-m-d', strtotime($sampai));
    $supplier           = $this->input->get('supplier', true);

    $data['tgl'] = $dari;

    if ($dari != '') {
        $List_payable = $this->M_Receivable_recognition_tims->advance_list_piutang($p_dari, $p_sampai, $invoice, $supplier);
        $search_active = !empty($List_payable);
    } else {
        $List_payable = $this->M_Receivable_recognition_tims->advance_list_piutang1($invoice, $supplier);
    }

    require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Default
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B2', 'Receivable Recognition Report Periode' . $p_dari . ' to ' . $p_sampai);

    $objPHPExcel->getActiveSheet()->mergeCells('B2:L2');

    $objPHPExcel->getActiveSheet()->getStyle('B2:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 12,
            'name' => 'Verdana'
        ]
    ]);

    $counter = 4;
    $header = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => '000000'],
            'name' => 'Verdana'
        ]
    ];

    $columns = [
        'No',
        'Invoice Number',
        'Date of Jurnal',
        'Invoice Date',
        'Due Date',
        'Customer',
        'Currency',
        'Rate',
        'Grand Total',
        'Amount',
        'Term'
    ];

    $colAlpha = 'B';
    foreach ($columns as $col) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($colAlpha . $counter, $col);
        $objPHPExcel->getActiveSheet()->getColumnDimension($colAlpha)->setWidth(20);
        $colAlpha++;
    }
    $objPHPExcel->getActiveSheet()->getStyle('B' . $counter . ':' . chr(ord('B') + count($columns) - 1) . $counter)->applyFromArray($header)->getFont()->setSize(10);

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(55);
    $counter++;
    $no = 1;

    if (!empty($List_payable)) {
        foreach ($List_payable as $item) {
            $colAlpha = 'B';
            $piutang = 0;
            $total = 0;

            $row = [
                $no++,
                $item->nofaktur,
                (!empty($item->tanggal) && $item->tanggal != '0000-00-00')
                    ? date('d-m-Y', strtotime($item->tanggal))
                    : '',
                (!empty($item->tanggal_invoice) && $item->tanggal_invoice != '0000-00-00')
                    ? date('d-m-Y', strtotime($item->tanggal_invoice))
                    : '',
                (!empty($item->tanggal_tempo) && $item->tanggal_tempo != '0000-00-00')
                    ? date('d-m-Y', strtotime($item->tanggal_tempo))
                    : '',
                $item->namacustomer,
                $item->currency,
                $item->rate,
                number_format($item->piutang, 2, ".", ","),
                number_format($item->piutang * $item->rate, 2, ".", ","),
                $item->term . ' Days'

            ];

            foreach ($row as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue($colAlpha . $counter, $v);
                $colAlpha++;
            }
            $counter++;
        }
    }

    $lastCol = chr(ord('B') + count($columns) - 1);
    $styleArray = [
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ];
    $objPHPExcel->getActiveSheet()->getStyle('B4:' . $lastCol . ($counter-1))->applyFromArray($styleArray);

    // Nama Sheet
    $objPHPExcel->getActiveSheet()->setTitle('Receivable Recognition');
    $objPHPExcel->setActiveSheetIndex(0);

    // Output Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="receivable_recognition_ZHT.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

}



