<?php
/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 10:51 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_insurance extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Report_Insurance'));
        $this->load->library(array('user_agent', 'Template','PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }


    function index()
    {

        $this->template->display('accounting/Laporan/Report_insurance');
    }

    function search() {
        //jenis_trans=&noreference=&jenis_coa=
        //($dari, $sampai, $coa, $reference, $jenis)
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $data['_tampil_item'] = $this->M_Report_Insurance->call_report_insurance($p_dari, $p_sampai);

        $this->template->display('accounting/Laporan/Report_insurance', $data);
    }

    function detail_transaction() {
    	$id = $this->input->get('id');
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));

        $data['category'] = $this->M_Report_Insurance->get_category();
        $data['_tampil_item'] = $this->M_Report_Insurance->call_report_insurance_detail($p_dari, $p_sampai,$id);

        $this->template->display('accounting/Laporan/Report_insurance_detail', $data);
    }

    function toExcelSalesReportOFInsurance()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $bulan_dari=date("F",strtotime($dari));
        $tahun_dari=date("Y",strtotime($dari));


        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $bulan_sampai=date("F",strtotime($sampai));
        $tahun_sampai=date("Y",strtotime($sampai));



        $tampil_item = $this->M_Report_Insurance->call_report_insurance($p_dari, $p_sampai);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");

        $objPHPExcel->getActiveSheet()->mergeCells("A6:A7");
        $objPHPExcel->getActiveSheet()->mergeCells("B6:C6");
        $objPHPExcel->getActiveSheet()->mergeCells("D6:E6");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);


        //set aligment header row
        $objPHPExcel->getActiveSheet()->getstyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        //set font bold header row
        $objPHPExcel->getActiveSheet()->getstyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('B6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('B7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('C7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('D6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('D7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('E7')->getFont()->setBold(true);




        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');


        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1' , 'PULAU SAMBU SINGAPORE PTE LTD')
            ->setCellValue('A2' , 'Reg No. 201537276')
            ->setCellValue('A4' , 'PRODUCTS LIABILITY INSURANCE ');

        if($bulan_dari==$bulan_sampai && $tahun_dari==$tahun_sampai){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5',strtoupper($bulan_dari).' '.$tahun_dari);
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5',strtoupper($bulan_dari).' '.$tahun_dari.' - '.strtoupper($bulan_sampai).' '.$tahun_sampai);

        }

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A6', 'PRODUCT')
            ->setCellValue('B6', 'USA AND AUSTRALIA')
            ->setCellValue('B7', 'CWP 1')
            ->setCellValue('C7', 'CWP 2')
            ->setCellValue('D6', 'REST OF THE WORLD')
            ->setCellValue('D7', 'CWP 1')
            ->setCellValue('E7', 'CWP 2')
        ;

        $counter=8;
        $cwp1_USA = 0;
        $cwp2_USA = 0;
        $a_cwp1_USA = 0;
        $a_cwp2_USA = 0;
        foreach ($tampil_item as $v) :

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->getActiveSheet()->getstyle('B'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('C'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('D'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('E'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objPHPExcel->getActiveSheet()->getStyle('B' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $v->tmp_product_category)
                    ->setCellValue('B' . $counter, round($v->tmp_total_cwp1_USA_AUS, 2))
                    ->setCellValue('C' . $counter, round($v->tmp_total_cwp2_USA_AUS, 2))
                    ->setCellValue('D' . $counter, round($v->tmp_total_cwp1_OTHER, 2))
                    ->setCellValue('E' . $counter, round($v->tmp_total_cwp2_OTHER, 2));


            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            $cwp1_USA += $v->tmp_total_cwp1_USA_AUS;
            $cwp2_USA += $v->tmp_total_cwp2_USA_AUS;
            $a_cwp1_USA += $v->tmp_total_cwp1_OTHER;
            $a_cwp2_USA += $v->tmp_total_cwp2_OTHER;
            $counter++;
        endforeach;
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getstyle('B'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('C'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('D'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('E'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('B' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, 'TOTAL')
                ->setCellValue('B' . $counter, round($cwp1_USA, 2))
                ->setCellValue('C' . $counter, round($cwp2_USA, 2))
                ->setCellValue('D' . $counter, round($a_cwp1_USA, 2))
                ->setCellValue('E' . $counter, round($a_cwp2_USA, 2));

        $objPHPExcel->getActiveSheet()->getStyle('A6:E' . ($jlh+2))->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('SALES REPORT FOR INSURANCE');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales_Report_Insurance.xlsx"');
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

    function toExcelSalesReportOFInsurance_detail()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $id = $this->input->get('id');
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));
        $bulan_dari=date("F",strtotime($dari));
        $tahun_dari=date("Y",strtotime($dari));


        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));
        $bulan_sampai=date("F",strtotime($sampai));
        $tahun_sampai=date("Y",strtotime($sampai));

        $tampil_item = $this->M_Report_Insurance->call_report_insurance_detail($p_dari,$p_sampai,$id);

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");

        $objPHPExcel->getActiveSheet()->mergeCells("A6:A7");
        $objPHPExcel->getActiveSheet()->mergeCells("B6:B7");
        $objPHPExcel->getActiveSheet()->mergeCells("C6:D6");
        $objPHPExcel->getActiveSheet()->mergeCells("E6:F6");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);


        //set aligment header row
        $objPHPExcel->getActiveSheet()->getstyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        //set font bold header row
        $objPHPExcel->getActiveSheet()->getstyle('A6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('B6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('C6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('C7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('D7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('E6')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('E7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('F7')->getFont()->setBold(true);




        $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');


        //Header
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1' , 'PULAU SAMBU SINGAPORE PTE LTD')
            ->setCellValue('A2' , 'Reg No. 201537276')
            ->setCellValue('A4' , 'PRODUCTS LIABILITY INSURANCE ');

        if($bulan_dari==$bulan_sampai && $tahun_dari==$tahun_sampai){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5',strtoupper($bulan_dari).' '.$tahun_dari);
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5',strtoupper($bulan_dari).' '.$tahun_dari.' - '.strtoupper($bulan_sampai).' '.$tahun_sampai);

        }

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', $title)
            ->setCellValue('A6', 'No. Invoice')
            ->setCellValue('B6', 'PRODUCT')
            ->setCellValue('C6', 'USA AND AUSTRALIA')
            ->setCellValue('C7', 'CWP 1')
            ->setCellValue('D7', 'CWP 2')
            ->setCellValue('E6', 'REST OF THE WORLD')
            ->setCellValue('E7', 'CWP 1')
            ->setCellValue('F7', 'CWP 2')
        ;

        $counter=8;
        $cwp1_USA = 0;
        $cwp2_USA = 0;
        $a_cwp1_USA = 0;
        $a_cwp2_USA = 0;
        foreach ($tampil_item as $v) :

            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

            $objPHPExcel->getActiveSheet()->getstyle('C'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('D'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('E'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle('F'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->tmp_invoice)
                ->setCellValue('B' . $counter, $v->tmp_product_category)
                ->setCellValue('C' . $counter, round($v->tmp_total_cwp1_USA_AUS, 2))
                ->setCellValue('D' . $counter, round($v->tmp_total_cwp2_USA_AUS, 2))
                ->setCellValue('E' . $counter, round($v->tmp_total_cwp1_OTHER, 2))
                ->setCellValue('F' . $counter, round($v->tmp_total_cwp2_OTHER, 2));

            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

            
            $cwp1_USA += $v->tmp_total_cwp1_USA_AUS;
            $cwp2_USA += $v->tmp_total_cwp2_USA_AUS;
            $a_cwp1_USA += $v->tmp_total_cwp1_OTHER;
            $a_cwp2_USA += $v->tmp_total_cwp2_OTHER;
            $counter++;

        endforeach;
        $objPHPExcel->getActiveSheet()->getstyle($counter)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells("A".$counter.":B".$counter);
        $objPHPExcel->getActiveSheet()->getstyle('C'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('D'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('E'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getstyle('F'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'TOTAL')
            ->setCellValue('C' . $counter, round($cwp1_USA, 2))
            ->setCellValue('D' . $counter, round($cwp2_USA, 2))
            ->setCellValue('E' . $counter, round($a_cwp1_USA, 2))
            ->setCellValue('F' . $counter, round($a_cwp2_USA, 2));

        $objPHPExcel->getActiveSheet()->getStyle('A6:F' . ($jlh+2))->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('SALES REPORT FOR INSURANCE');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales_Report_Insurance_Detail.xlsx"');
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

    function toPrintSalesReportOFInsurance(){
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));



        $data['_tampil_item'] = $this->M_Report_Insurance->call_report_insurance($p_dari, $p_sampai);
        $this->load->view('accounting/rpt/sales_report_insurance', $data);
    }

     function toPrintSalesReportOFInsurance_Detail(){
        $id = $this->input->get('id');
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai = date('Y-m-d', strtotime($sampai));



        $data['_tampil_item'] = $this->M_Report_Insurance->call_report_insurance_detail($p_dari,$p_sampai,$id);
        $this->load->view('accounting/rpt/sales_report_insurance_detail', $data);
    }
}
?>