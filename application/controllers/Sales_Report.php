<?php
/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 10:51 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_Report extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Sales_Report'));
        $this->load->model(array('M_Fin_Master'));
        $this->load->library(array('user_agent', 'Template','PHPExcel'));
        $this->load->helper('mysqli');
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
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


    function index()
    {
        $data['customer'] = $this->M_Sales_Report->get_customer();
        $this->template->display('accounting/Laporan/Sales_Report', $data);
    }

    function search() {
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));
        $customer      = $this->input->get('customer_name');

        

        $data['customer'] = $this->M_Sales_Report->get_customer();
        $data['product'] = $this->M_Sales_Report->product_category();
        $data['GroupCustomerID'] = $this->M_Sales_Report->get_group_cust($p_dari, $p_sampai, $customer);
        $data['_tampil_item'] = $this->M_Sales_Report->call_Sales_Report($p_dari, $p_sampai, $customer);

        $this->template->display('accounting/Laporan/Sales_Report', $data);
    }

    function detail_transaction() {
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));
        $customer      = $this->input->get('customer_name');

        

        $data['customer'] = $this->M_Sales_Report->get_customer();
        $data['product'] = $this->M_Sales_Report->product_category();
        $data['GroupCustomerID'] = $this->M_Sales_Report->get_group_cust($p_dari, $p_sampai, $customer);
        $data['_tampil_item'] = $this->M_Sales_Report->call_Sales_Report_detail($p_dari, $p_sampai, $customer);

        $this->template->display('accounting/Laporan/Sales_Report_Detail', $data);
    }



    function toExcelSalesReport()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));
        $customer      = $this->input->get('customer_name');

        $product = $this->M_Sales_Report->product_category();
        $tampil_item = $this->M_Sales_Report->call_Sales_Report($p_dari, $p_sampai, $customer);


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->mergeCells("A3:A4");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getstyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('A3')->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->getstyle('B3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells("B3:B4");
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Header
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1' , 'PULAU SAMBU SINGAPORE PTE LTD');


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3' , 'CUSTOMER');
              $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B3' , 'SALES PERSON');
        $a = 2;
        $b = 2;
        $arr_sub = array('QTY', 'USD', 'USD/QTY');

        foreach ($product as $r) :
            $objPHPExcel->getActiveSheet()->mergeCells($this->getNameFromNumber($a)."3:".$this->getNameFromNumber($a + 2)."3");
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($a).'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($a).'3')->getFont()->setBold(true);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($a).'3', $r->product_category_name);

            $b_1=$b++;
            $b_2=$b++;
            $b_3=$b++;

            $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_1))->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_2))->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_3))->setWidth(10);

            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_1).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_2).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_3).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_1).'4')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_2).'4')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_3).'4')->getFont()->setBold(true);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_1).'4', $arr_sub[0]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_2).'4', $arr_sub[1]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_3).'4', $arr_sub[2]);

            $a += 3;
        endforeach;

        $objPHPExcel->getActiveSheet()->mergeCells($this->getNameFromNumber($a)."3:".$this->getNameFromNumber($a + 2)."3");
        $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($a).'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($a).'3')->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($a).'3', 'TOTAL');

        $b_1=$b++;
        $b_2=$b++;
        $b_3=$b++;

        $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_1))->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_2))->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($b_3))->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_1).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_2).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($b_3).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_1).'4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_2).'4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($b_3).'4')->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_1).'4', $arr_sub[0]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_2).'4', $arr_sub[1]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($b_3).'4', $arr_sub[2]);

         $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );

        $counter=5;
        foreach ($tampil_item as $v) :
            $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $counter, htmlspecialchars_decode($v->custcompany,ENT_QUOTES));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $counter, $v->sales_id);


            $c = 2;
            $totqty = 0;
            $totusd = 0;
            $totunit = 0;   
            foreach ($product as $p) :
                $prod = $this->M_Sales_Report->call_by_product_id($p->product_category_id, $v->custid);

                if(!empty($prod->tot_qty)){
                    $qty =$prod->tot_qty;
                    $usd = $prod->tot_usd;
                    $price = $prod->tot_unitprice;
                }else{
                    $qty = 0;
                    $usd = 0;
                    $price = 0;
                }

                $totqty += $qty;
                $totusd += $usd;
                $totunit += $price;

                $c_1 = $c++;
                $c_2 = $c++;
                $c_3 = $c++;

                $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_1).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_2).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_3).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_1). $counter)->getNumberFormat()->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_2). $counter)->getNumberFormat()->setFormatCode('#,##0.00');
                $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_3). $counter)->getNumberFormat()->setFormatCode('#,##0.0000');

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_1).$counter, round($qty,2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_2).$counter, round($usd,2));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_3).$counter, round($price,4));
            endforeach;

            $c_1 = $c++;
            $c_2 = $c++;
            $c_3 = $c++;    

            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_1).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_2).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($c_3).$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_1). $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_2). $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($c_3). $counter)->getNumberFormat()->setFormatCode('#,##0.0000');

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_1).$counter, round($totqty,2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_2).$counter, round($totusd,2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($c_3).$counter, round($totunit,4));

        $counter++;
        endforeach;

        // $objPHPExcel->getActiveSheet()->getStyle('A3:'.$this->getNameFromNumber($c_3).($jlh+1))->applyFromArray($styleArray);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B".$counter, "AMOUNT");
        for ($i = 2 ; $i < 62; $i++){
            $a = $this->getNameFromNumber($i);
            $b = "=SUM(".$a."5".":".$a.($counter-1).")";
            $objPHPExcel->getActiveSheet()->getStyle($a. $counter)->getNumberFormat()->setFormatCode('#,##0.00');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($a.$counter, $b);
            // echo $a." - ";
        }
        // $objPHPExcel->

        $objPHPExcel->getActiveSheet()->getStyle('A3:'.$this->getNameFromNumber($c_3).($jlh+2))->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->setTitle('SALES REPORT NEW');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales_Report_New.xlsx"');
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

    // function toPrintSalesReportOFInsurance(){
    //     $dari = str_replace('/', '-', $this->input->get('dari'));
    //     $p_dari = date('Y-m-d', strtotime($dari));

    //     $sampai = str_replace('/', '-', $this->input->get("sampai"));
    //     $p_sampai = date('Y-m-d', strtotime($sampai));



    //     $data['_tampil_item'] = $this->M_Report_Insurance->call_report_insurance($p_dari, $p_sampai);
    //     $this->load->view('accounting/rpt/sales_report_insurance', $data);
    // }
}
?>