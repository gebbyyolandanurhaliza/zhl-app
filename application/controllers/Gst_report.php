<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gst_report extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_gst'));
        $this->load->library('PHPExcel');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $data['_gst'] = $this->M_gst->get_gst();
        $this->template->display('accounting/gstreport', $data);
    }

    // function search_old() {
    //     $gst = $this->input->get('client');
    //     $dari = $this->input->get('dari');
    //     $sampai = $this->input->get('sampai');

    //     $data['_gst'] = $this->M_gst->get_gst();
    //     $data['ambil_gst'] = $this->M_gst->ambil_gst();
    //     $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
    //     $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);
    //     $this->template->display('accounting/gstreport4', $data);
    // }

    function search(){
        $companyid   = strtoupper($this->session->userdata('company_id'));
        $gst = $this->input->get('client');
        $dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));

        $data['_gst'] = $this->M_gst->get_gst();
        $data['ambil_gst'] = $this->M_gst->ambil_gst();
        $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
        $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);
        if($companyid == 2) {
           $data['gstt']=$this->M_gst->call_gst_report_zht($dari, $sampai, $gst);
        }else{
            $data['gstt']=$this->M_gst->call_gst_report($dari, $sampai, $gst);
        }
        $this->template->display('accounting/gstreport', $data);
    }

    function gsttoexcel(){
        $companyid   = strtoupper($this->session->userdata('company_id'));
        $gst = $this->input->get('client');
        $dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));

        $data['_gst'] = $this->M_gst->get_gst();
        $data['ambil_gst'] = $this->M_gst->ambil_gst();
        $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
        $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);
        if ($companyid == 2) {
           $data['gstt']=$this->M_gst->call_gst_report_zht($dari, $sampai, $gst);
        }else{
            $data['gstt']=$this->M_gst->call_gst_report($dari, $sampai, $gst);
        }
        
        $this->load->view('accounting/gstreporttoexcel', $data);
    }

    function print_report() {
        $gst = $this->input->get('client');
        $dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));

		$data['gst']=$this->input->get('client');
        $data['dari'] = $this->input->get('dari');
        $data['_gst'] = $this->M_gst->get_gst();
        $data['ambil_gst'] = $this->M_gst->ambil_gst();
        $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
        $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);
        $data['gstt']=$this->M_gst->call_gst_report($dari, $sampai, $gst);


        $this->load->view('accounting/rpt/rpt_gstreport', $data);
    }
    // function print_report_old() {
    //     $gst = $this->input->get('client');
    //     $dari = $this->input->get('dari');
    //     $sampai = $this->input->get('sampai');


    //     $data['dari'] = $this->input->get('dari');
    //     $data['_gst'] = $this->M_gst->get_gst();
    //     $data['ambil_gst'] = $this->M_gst->ambil_gst();
    //     $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
    //     $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);

    //     $this->load->view('accounting/rpt/rpt_gstreport', $data);
    // }
     function toExcelGst_report(){
        $companyid   = strtoupper($this->session->userdata('company_id'));
        $gst = $this->input->get('client');
        $dari = date('Y-m-d', strtotime($this->input->get('dari')));
        $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));

        $data['_gst'] = $this->M_gst->get_gst();
        $data['ambil_gst'] = $this->M_gst->ambil_gst();
        $data['_tampil'] = $this->M_gst->hasil1($dari, $sampai, $gst);
        $data['total_gst'] = $this->M_gst->total_gst($dari, $sampai, $gst);
        if ($companyid == 2) {
            $data['gstt']=$this->M_gst->call_gst_report_zht($dari, $sampai, $gst);
        }else{
            $data['gstt']=$this->M_gst->call_gst_report($dari, $sampai, $gst);
        }
        $this->load->view('accounting/gstreport_excel', $data);
     }

//     function toExcelGst_report()
//     {
//         error_reporting(E_ALL);
//         ini_set('display_errors', TRUE);
//         ini_set('display_startup_errors', TRUE);
//         date_default_timezone_set('Europe/London');

//         $gst = $this->input->get('client');
//         $dari = date('Y-m-d', strtotime($this->input->get('dari')));
//         $sampai = date('Y-m-d', strtotime($this->input->get('sampai')));


//         $datagstt=$this->M_gst->call_gst_report($dari, $sampai, $gst);


//         $objPHPExcel = new PHPExcel();

//         $objPHPExcel->getActiveSheet()->mergeCells("A2:M2");
//         $objPHPExcel->getActiveSheet()->mergeCells("A3:M3");
//         $objPHPExcel->getActiveSheet()->mergeCells("A4:M4");

//         $objPHPExcel->getActiveSheet()->mergeCells("A6:A7");
//         $objPHPExcel->getActiveSheet()->mergeCells("B6:B7");
//         $objPHPExcel->getActiveSheet()->mergeCells("C6:C7");
//         $objPHPExcel->getActiveSheet()->mergeCells("D6:D7");
//         $objPHPExcel->getActiveSheet()->mergeCells("E6:E7");
//         $objPHPExcel->getActiveSheet()->mergeCells("F6:F7");
//         $objPHPExcel->getActiveSheet()->mergeCells("G6:G7");
//         $objPHPExcel->getActiveSheet()->mergeCells("H6:K6");
//         $objPHPExcel->getActiveSheet()->mergeCells("L6:O6");

//         $objPHPExcel->getActiveSheet()->mergeCells("A8:M8");

//         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
//         $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);

//         $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT);
//         $objPHPExcel->getActiveSheet()->getstyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getstyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getstyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getstyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getstyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('N7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('O7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


//         $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');



//         $styleArray = array(
//             'borders' => array(
//                 'allborders' => array(
//                     'style' => PHPExcel_Style_Border::BORDER_THIN
//                 )
//             )
//         );
//         if($this->input->get('client')=='HUT'){
//             $text3=' Accounts Payable - Details';
//             $acc='Vendor';
//             $text='Input Tax';
//             $text2='Total FOr Output Tax';
//         }
//         else{
//             $text3=' Accounts Receivable - Details';
//             $acc='Customer';
//             $text='Output Tax';
//             $text2='Total For Input Tax';
//         }
//         $objPHPExcel->getActiveSheet()->getstyle('A2')->getFont()->setBold(true);
//         $objPHPExcel->getActiveSheet()->getstyle('A3')->getFont()->setBold(true);

//         $jlh1 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A2','ZHENGHE LOGISTIC Pte Ltd')
//             ->setCellValue('A3',$text3)
//             ->setCellValue('A4','GST Report from '.$dari.' to '.$sampai)
//             ->setCellValue('A6', 'No')
//             ->setCellValue('B6', 'Date')
//             ->setCellValue('C6', 'Invoice No')
//             ->setCellValue('D6', 'PO No')
//             ->setCellValue('E6', $acc)
//             ->setCellValue('F6', 'Description')
//             ->setCellValue('G6', 'Doc Cur')
//             ->setCellValue('H6', 'Foreign Currency')
//             ->setCellValue('H7', 'Sub Total')
//             ->setCellValue('I7', 'Other')
//             ->setCellValue('J7', 'GST')
//             ->setCellValue('K7', 'Total Amount')
//             ->setCellValue('L6', 'Local Currency (USD)')
//             ->setCellValue('L7', 'Sub Total')
//             ->setCellValue('M7', 'Other')
//             ->setCellValue('N7', 'GST')
//             ->setCellValue('O7', 'Total Amount')
//             ->setCellValue('A8', 'Exempted 0%');

//         $styleArray = array(
//             'borders' => array(
//                 'allborders' => array(
//                     'style' => PHPExcel_Style_Border::BORDER_THIN
//                 )
//             )
//         );

//         $objPHPExcel->getActiveSheet()->getStyle('A6:O' . ($jlh1+1))->applyFromArray($styleArray);

//         $no=1;
//         $no2=1;
//         $no3=1;
//         $no4=1;

//         $subtotalexpusd=0;
//         $subtotalgstexpusd=0;
//         $subtotalusd=0;
//         $subtotalexpsgd=0;
//         $subtotalgstexpsgd=0;
//         $subtotalsgd=0;
//         $subtotal1othersgd = 0;
//         $subtotal1otherusd = 0;

//         $subtotalgstusd=0;
//         $subtotalgstgstusd=0;
//         $subtotal2usd=0;
//         $subtotalgstsgd=0;
//         $subtotalgstgstsgd=0;
//         $subtotal2sgd=0;
//         $subtotal2othersgd = 0;
//         $subtotal2otherusd = 0;

//         $subtotaloutusd=0;
//         $subtotalgstoutusd=0;
//         $subtotal3usd=0;
//         $subtotaloutsgd=0;
//         $subtotalgstoutsgd=0;
//         $subtotal3sgd=0;
//         $subtotal3othersgd = 0;
//         $subtotal3otherusd = 0;

//         $subtotalzerusd=0;
//         $subtotalgstzerusd=0;
//         $subtotal4usd=0;
//         $subtotalzersgd=0;
//         $subtotalgstzersgd=0;
//         $subtotal4sgd=0;
//         $subtotal4othersgd = 0;
//         $subtotal4otherusd = 0;

//         $rate_sgd=0;
//         $totalothersgd = 0;
//         $totalotherusd = 0;

//         //gst exempted
//         $counter=9;
//         foreach ($datagstt as $value) :
//             $jlh = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//             if($value->t_gst=='EXP') {
//                 if ($value->t_currency == 'USD') {

//                     $subtotalexp = ($value->t_qty * $value->t_price) * $value->t_rate;
//                     $gstexp = $value->t_gst_value;
//                     $total1 = $subtotalexp + $gstexp + $value->t_ocean_freight ;
//                     $subtotalexpusd += $subtotalexp;
//                     $subtotalgstexpusd += $gstexp;
//                     $subtotalusd += $total1;
//                     $subtotal1otherusd += $value->t_ocean_freight;
//                     $rate_sgd = $value->t_rate_sgd; 
//                     $subtotalgstexpsgd+= round($gstexp * $value->t_rate_sgd,2);
//                 } else {
//                     if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' ||$value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP' ){
//                         $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     else{
//                         $subtotalexp= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }

//                     $gstexp = $value->t_gst_value;
//                     $total1 = $subtotalexp + $gstexp + $value->t_ocean_freight;
//                     $subtotalexpsgd += $subtotalexp;
//                     $subtotalgstexpsgd += $gstexp;
//                     $subtotal1othersgd +=  $value->t_ocean_freight;
//                     $subtotalsgd += $total1;
//                 }
//                 $objPHPExcel->setActiveSheetIndex(0)
//                     ->setCellValue('A'.$counter, $no)
//                     ->setCellValue('B'.$counter,date('d-m-Y', strtotime($value->t_tanggal)))
//                     ->setCellValue('C'.$counter, $value->t_ref_nomor)
//                     ->setCellValue('D'.$counter, '')
//                     ->setCellValue('E'.$counter, $value->t_customer_name)
//                     ->setCellValue('F'.$counter, $value->t_desc)
//                     ->setCellValue('G'.$counter, $value->t_currency);

//                 $objPHPExcel->getActiveSheet()->getStyle('H'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('I'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('J'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('K'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('L'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('M'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//                 if($value->t_currency=='USD'){
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter, '' )
//                         ->setCellValue('I'.$counter, '' )
//                         ->setCellValue('J'.$counter, $gstexp * $rate_sgd)
//                         ->setCellValue('K'.$counter, '' )
//                         ->setCellValue('L'.$counter,  $subtotalexp )
//                         ->setCellValue('M'.$counter,  $value->t_ocean_freight )
//                         ->setCellValue('N'.$counter,  $gstexp )
//                         ->setCellValue('O'.$counter,  $total1 );
//                 }
//                 else{
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter,  $subtotalexp )
//                         ->setCellValue('I'.$counter,  $value->t_ocean_freight )
//                         ->setCellValue('J'.$counter,  $gstexp )
//                         ->setCellValue('K'.$counter,  $total1 )
//                         ->setCellValue('L'.$counter, '' )
//                         ->setCellValue('M'.$counter, '')
//                         ->setCellValue('N'.$counter, '')
//                         ->setCellValue('O'.$counter, '');
//                 }

//                 $styleArray = array(
//                     'borders' => array(
//                         'allborders' => array(
//                             'style' => PHPExcel_Style_Border::BORDER_THIN
//                         )
//                     )
//                 );

//                 $objPHPExcel->getActiveSheet()->getStyle('A8:O' . ($jlh+1))->applyFromArray($styleArray);

//                 $no++;
//                 $counter++;
//             }




//             endforeach;
//         $countersub1=$counter;
//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$countersub1.':G'.$countersub1);

//         $nsubtotalexpsgd=  $subtotalexpsgd ;
//         $nsubtotalgstexpsgd=  $subtotalgstexpsgd ;
//         $nsubtotalsgd=  $subtotalsgd ;
//         $nsubtotalexpusd=  $subtotalexpusd ;
//         $nsubtotalgstexpusd=  $subtotalgstexpusd ;
//         $nsubtotalusd=  $subtotalusd ;
//         $subtotal1othersgd =  $subtotal1othersgd ;
//         $subtotal1otherusd =  $subtotal1otherusd ;

//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('H'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('I'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('J'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('K'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('L'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('M'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('N'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('O'.$countersub1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $jlhs1 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersub1, 'Sub Total for Exemted 0%' )
//             ->setCellValue('H'.$countersub1, $nsubtotalexpsgd )
//             ->setCellValue('I'.$countersub1, $subtotal1othersgd )
//             ->setCellValue('J'.$countersub1, $nsubtotalgstexpsgd )
//             ->setCellValue('K'.$countersub1, $nsubtotalsgd)
//             ->setCellValue('L'.$countersub1, $nsubtotalexpusd)
//             ->setCellValue('M'.$countersub1, $subtotal1otherusd)
//             ->setCellValue('N'.$countersub1, $nsubtotalgstexpusd)
//             ->setCellValue('O'.$countersub1, $nsubtotalusd);

//         ;
//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub1.':O' . ($jlhs1+1))->applyFromArray($styleArray);
//         //gst 7%
//         $counter2=$countersub1+1;

//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter2.':O'.$counter2);
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$counter2, 'GST 7%');

//         $counter2_2=$counter2+1;
//         foreach ($datagstt as $value) :
//             $jlh2 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//             if($value->t_gst=='GST') {
//                 if($value->t_currency=='USD') {
//                     $subtotalgst = ($value->t_qty * $value->t_price) * $value->t_rate;
//                     $gstgst= $value->t_gst_value;
//                     $total2=$subtotalgst+$gstgst+$value->t_ocean_freight;
//                     $subtotalgstusd+=$subtotalgst;
//                     $subtotalgstgstusd+=$gstgst;
//                     $subtotal2usd+=$total2;
//                     $subtotal2otherusd += $value->t_ocean_freight;
//                     $rate_sgd = $value->t_rate_sgd; 
//                     $subtotalgstgstsgd+= round($gstgst * $value->t_rate_sgd,2);
//                 }
//                 else{
//                     if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' ||$value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP' ){
//                         $subtotalgst= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     else{
//                         $subtotalgst= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     $gstgst= $value->t_gst_value;
//                     $total2=$subtotalgst+$gstgst+$value->t_ocean_freight;
//                     $subtotalgstsgd+=$subtotalgst;
//                     $subtotalgstgstsgd+=$gstgst;
//                     $subtotal2sgd+=$total2;
//                     $subtotal2othersgd += $value->t_ocean_freight;
//                 }
//                 $objPHPExcel->setActiveSheetIndex(0)
//                     ->setCellValue('A'.$counter2_2, $no2)
//                     ->setCellValue('B'.$counter2_2, date('d-m-Y', strtotime($value->t_tanggal)))
//                     ->setCellValueExplicit('C'.$counter2_2, $value->t_ref_nomor,PHPExcel_Cell_DataType::TYPE_STRING)
//                     ->setCellValue('D'.$counter2_2, '')
//                     ->setCellValue('E'.$counter2_2, $value->t_customer_name)
//                     ->setCellValue('F'.$counter2_2, $value->t_desc)
//                     ->setCellValue('G'.$counter2_2, $value->t_currency);

//                 $objPHPExcel->getActiveSheet()->getStyle('H'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('I'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('J'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('K'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('L'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('M'.$counter2_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//                 // if($value->t_currency=='USD'){
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter2_2, '' )
//                 //         ->setCellValue('I'.$counter2_2,  $gstgst * $rate_sgd )
//                 //         ->setCellValue('J'.$counter2_2, '')
//                 //         ->setCellValue('K'.$counter2_2,  $subtotalgst )
//                 //         ->setCellValue('L'.$counter2_2,  $gstgst )
//                 //         ->setCellValue('M'.$counter2_2,  $total2 );
//                 // }
//                 // else{
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter2_2,  $subtotalgst )
//                 //         ->setCellValue('I'.$counter2_2,  $gstgst )
//                 //         ->setCellValue('J'.$counter2_2,  $total2 )
//                 //         ->setCellValue('K'.$counter2_2, '' )
//                 //         ->setCellValue('L'.$counter2_2, '')
//                 //         ->setCellValue('M'.$counter2_2, '');
//                 // }


//                 if($value->t_currency=='USD'){
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter2_2, '' )
//                         ->setCellValue('I'.$counter2_2, '' )
//                         ->setCellValue('J'.$counter2_2, $gstgst * $rate_sgd )
//                         ->setCellValue('K'.$counter2_2, '' )
//                         ->setCellValue('L'.$counter2_2,  $subtotalgst )
//                         ->setCellValue('M'.$counter2_2,  $value->t_ocean_freight )
//                         ->setCellValue('N'.$counter2_2,  $gstgst )
//                         ->setCellValue('O'.$counter2_2,  $total2 );
//                 }
//                 else{
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter2_2,  $subtotalgst )
//                         ->setCellValue('I'.$counter2_2,  $value->t_ocean_freight )
//                         ->setCellValue('J'.$counter2_2,  $gstgst )
//                         ->setCellValue('K'.$counter2_2,  $total2 )
//                         ->setCellValue('L'.$counter2_2, '' )
//                         ->setCellValue('M'.$counter2_2, '')
//                         ->setCellValue('N'.$counter2_2, '')
//                         ->setCellValue('O'.$counter2_2, '');
//                 }
//                 $styleArray = array(
//                     'borders' => array(
//                         'allborders' => array(
//                             'style' => PHPExcel_Style_Border::BORDER_THIN
//                         )
//                     )
//                 );

//                 $objPHPExcel->getActiveSheet()->getStyle('A'.$counter2.':O' . ($jlh2+1))->applyFromArray($styleArray);

//                 $no2++;
//                 $counter2_2++;

//             }




//         endforeach;
//         $countersub2=$counter2_2;
//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$countersub2.':G'.$countersub2);

//         $nsubtotalgstsgd=  $subtotalgstsgd ;
//         $nsubtotalgstgstsgd=  $subtotalgstgstsgd ;
//         $nsubtotal2sgd=  $subtotal2sgd ;
//         $nsubtotalgstusd=  $subtotalgstusd ;
//         $nsubtotalgstgstusd=  $subtotalgstgstusd ;
//         $nsubtotal2usd=  $subtotal2usd ;
//         $subtotal2othersgd =  $subtotal2othersgd ;
//         $subtotal2otherusd =  $subtotal2otherusd ;
                                               

//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('H'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('I'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('J'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('K'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('L'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('M'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('N'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('O'.$countersub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//         $jlhs2 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersub2, 'Sub Total for GST 7%' )
//             ->setCellValue('H'.$countersub2, $nsubtotalgstsgd )
//             ->setCellValue('I'.$countersub2, $subtotal2othersgd )
//             ->setCellValue('J'.$countersub2, $nsubtotalgstgstsgd )
//             ->setCellValue('K'.$countersub2, $nsubtotal2sgd)
//             ->setCellValue('L'.$countersub2, $nsubtotalgstusd)
//             ->setCellValue('M'.$countersub2, $subtotal2otherusd)
//             ->setCellValue('N'.$countersub2, $nsubtotalgstgstusd)
//             ->setCellValue('O'.$countersub2, $nsubtotal2usd);

        
//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub2.':O' . ($jlhs2+1))->applyFromArray($styleArray);
//         //out of scope
//         $counter3=$countersub2+1;

//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter3.':O'.$counter3);
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$counter3, 'Out OF Scope 0%');

//         $counter3_2=$counter3+1;

//         foreach ($datagstt as $value) :
//             $jlh3 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//             if($value->t_gst=='OUT') {
//                 if($value->t_currency=='USD') {
//                     $subtotalout = ($value->t_qty * $value->t_price) * $value->t_rate;
//                     $gstout= $value->t_gst_value;
//                     $total3=$subtotalout+$gstout+$value->t_ocean_freight;
//                     $subtotal3otherusd += $value->t_ocean_freight;
//                     $subtotaloutusd+=$subtotalout;
//                     $subtotalgstoutusd+=$gstout;
//                     $subtotal3usd+=$total3;

//                     $rate_sgd = $value->t_rate_sgd; 
//                     $subtotalgstoutsgd+= round($gstout * $value->t_rate_sgd,2);
//                 }
//                 else{
//                     if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' ||$value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP' ){
//                         $subtotalout= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     else{
//                         $subtotalout= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     $gstout= $value->t_gst_value;
//                     $total3=$subtotalout+$gstout+$value->t_ocean_freight;
//                     $subtotal3othersgd += $value->t_ocean_freight;
//                     $subtotaloutsgd+=$subtotalout;
//                     $subtotalgstoutsgd+=$gstout;
//                     $subtotal3sgd+=$total3;
//                 }
//                 $objPHPExcel->setActiveSheetIndex(0)
//                     ->setCellValue('A'.$counter3_2, $no3)
//                     ->setCellValue('B'.$counter3_2, date('d-m-Y', strtotime($value->t_tanggal)))
//                     ->setCellValue('C'.$counter3_2, $value->t_ref_nomor)
//                     ->setCellValue('D'.$counter3_2, '')
//                     ->setCellValue('E'.$counter3_2, $value->t_customer_name)
//                     ->setCellValue('F'.$counter3_2, $value->t_desc)
//                     ->setCellValue('G'.$counter3_2, $value->t_currency);
//                 $objPHPExcel->getActiveSheet()->getStyle('H'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('I'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('J'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('K'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('L'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('M'.$counter3_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//                 // if($value->t_currency=='USD'){
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter3_2, '' )
//                 //         ->setCellValue('I'.$counter3_2,  $gstout * $rate_sgd )
//                 //         ->setCellValue('J'.$counter3_2, '')
//                 //         ->setCellValue('K'.$counter3_2,  $subtotalout )
//                 //         ->setCellValue('L'.$counter3_2,  $gstout )
//                 //         ->setCellValue('M'.$counter3_2,  $total3 );
//                 // }
//                 // else{
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter3_2,  $subtotalout )
//                 //         ->setCellValue('I'.$counter3_2,  $gstout )
//                 //         ->setCellValue('J'.$counter3_2,  $total3 )
//                 //         ->setCellValue('K'.$counter3_2, '' )
//                 //         ->setCellValue('L'.$counter3_2, '')
//                 //         ->setCellValue('M'.$counter3_2, '');
//                 // }

//                 if($value->t_currency=='USD'){
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter3_2, '' )
//                         ->setCellValue('I'.$counter3_2, '' )
//                         ->setCellValue('J'.$counter3_2, $gstout * $rate_sgd )
//                         ->setCellValue('K'.$counter3_2, '' )
//                         ->setCellValue('L'.$counter3_2,  $subtotalout )
//                         ->setCellValue('M'.$counter3_2,  $value->t_ocean_freight )
//                         ->setCellValue('N'.$counter3_2,  $gstout )
//                         ->setCellValue('O'.$counter3_2,  $total3 );
//                 }
//                 else{
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter3_2,  $subtotalout )
//                         ->setCellValue('I'.$counter3_2,  $value->t_ocean_freight )
//                         ->setCellValue('J'.$counter3_2,  $gstout )
//                         ->setCellValue('K'.$counter3_2,  $total3 )
//                         ->setCellValue('L'.$counter3_2, '' )
//                         ->setCellValue('M'.$counter3_2, '')
//                         ->setCellValue('N'.$counter3_2, '')
//                         ->setCellValue('O'.$counter3_2, '');
//                 }

//                 $styleArray = array(
//                     'borders' => array(
//                         'allborders' => array(
//                             'style' => PHPExcel_Style_Border::BORDER_THIN
//                         )
//                     )
//                 );

//                 $objPHPExcel->getActiveSheet()->getStyle('A'.$counter3.':O' . ($jlh3+1))->applyFromArray($styleArray);

//                 $no3++;
//                 $counter3_2++;
//             }





//         endforeach;
//         $countersub3=$counter3_2;
//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$countersub3.':G'.$countersub3);

//         $nsubtotaloutsgd=  $subtotaloutsgd ;
//         $nsubtotalgstoutsgd=  $subtotalgstoutsgd ;
//         $nsubtotal3sgd=  $subtotal3sgd ;
//         $nsubtotaloutusd=  $subtotaloutusd ;
//         $nsubtotalgstoutusd=  $subtotalgstoutusd ;
//         $nsubtotal3usd=  $subtotal3usd ;
//         $subtotal3othersgd =  $subtotal3othersgd ;
//         $subtotal3otherusd =  $subtotal3otherusd ;

//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('H'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('I'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('J'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('K'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('L'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('M'.$countersub3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $jlhs3 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersub3, 'Sub Total for Out 0%' )
//             ->setCellValue('H'.$countersub3, $nsubtotaloutsgd )
//             ->setCellValue('I'.$countersub3, $subtotal3othersgd )
//             ->setCellValue('J'.$countersub3, $nsubtotalgstoutsgd )
//             ->setCellValue('K'.$countersub3, $nsubtotal3sgd)
//             ->setCellValue('L'.$countersub3, $nsubtotaloutusd)
//             ->setCellValue('M'.$countersub3, $subtotal3otherusd)
//             ->setCellValue('N'.$countersub3, $nsubtotalgstoutusd)
//             ->setCellValue('O'.$countersub3, $nsubtotal3usd);

//         ;
//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub1.':O' . ($jlhs3+1))->applyFromArray($styleArray);
// //ZERO
//         $counter4=$countersub3+1;

//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter4.':O'.$counter4);
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$counter4, 'Zero Rated 0%');

//         $counter4_2=$counter4+1;
//         foreach ($datagstt as $value) :
//             $jlh4 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
//             if($value->t_gst=='ZER') {
//                 if($value->t_currency=='USD') {
//                     $subtotalzer = ($value->t_qty * $value->t_price) * $value->t_rate;
//                     $gstzer=$value->t_gst_value;
//                     $total4=$subtotalzer+$gstzer+$value->t_ocean_freight;
//                     $subtotalzerusd+=$subtotalzer;
//                     $subtotalgstzerusd+=$gstzer;
//                     $subtotal4usd+=$total4;
//                     $subtotal4otherusd +=  $value->t_ocean_freight;
//                     $rate_sgd = $value->t_rate_sgd; 
//                     $subtotalgstzersgd+= round($gstzer * $value->t_rate_sgd,2);
//                 }
//                 else{
//                     if($value->t_jenis_trans=='BO' || $value->t_jenis_trans=='BI' || $value->t_jenis_trans=='CO' || $value->t_jenis_trans=='CI' ||$value->t_jenis_trans=='PIJF'||$value->t_jenis_trans=='AP' ){
//                         $subtotalzer= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     else{
//                         $subtotalzer= ($value->t_qty * $value->t_price) * $value->t_rate_sgd;
//                     }
//                     $gstzer=$value->t_gst_value;
//                     $total4=$subtotalzer+$gstzer+$value->t_ocean_freight;
//                     $subtotalzersgd+=$subtotalzer;
//                     $subtotalgstzersgd+=$gstzer;
//                     $subtotal4sgd+=$total4;
//                     $subtotal4othersgd +=  $value->t_ocean_freight;
//                 }
//                 $objPHPExcel->setActiveSheetIndex(0)
//                     ->setCellValue('A'.$counter4_2, $no4)
//                     ->setCellValue('B'.$counter4_2, date('d-m-Y', strtotime($value->t_tanggal)))
//                     ->setCellValue('C'.$counter4_2, $value->t_ref_nomor)
//                     ->setCellValue('D'.$counter4_2, '')
//                     ->setCellValue('E'.$counter4_2, $value->t_customer_name)
//                     ->setCellValue('F'.$counter4_2, $value->t_desc)
//                     ->setCellValue('G'.$counter4_2, $value->t_currency);
//                 $objPHPExcel->getActiveSheet()->getStyle('H'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('I'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('J'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('K'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('L'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('M'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('N'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                 $objPHPExcel->getActiveSheet()->getStyle('O'.$counter4_2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//                 // if($value->t_currency=='USD'){
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter4_2, '' )
//                 //         ->setCellValue('I'.$counter4_2,  $gstzer * $rate_sgd )
//                 //         ->setCellValue('J'.$counter4_2, '')
//                 //         ->setCellValue('K'.$counter4_2,  $subtotalzer )
//                 //         ->setCellValue('L'.$counter4_2,  $gstzer )
//                 //         ->setCellValue('M'.$counter4_2,  $total4 );
//                 // }
//                 // else{
//                 //     $objPHPExcel->setActiveSheetIndex(0)
//                 //         ->setCellValue('H'.$counter4_2,  $subtotalzer )
//                 //         ->setCellValue('I'.$counter4_2,  $gstzer )
//                 //         ->setCellValue('J'.$counter4_2,  $total4 )
//                 //         ->setCellValue('K'.$counter4_2, '' )
//                 //         ->setCellValue('L'.$counter4_2, '')
//                 //         ->setCellValue('M'.$counter4_2, '');
//                 // }

//                 if($value->t_currency=='USD'){
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter4_2, '' )
//                         ->setCellValue('I'.$counter4_2, '' )
//                         ->setCellValue('J'.$counter4_2, $gstzer * $rate_sgd )
//                         ->setCellValue('K'.$counter4_2, '' )
//                         ->setCellValue('L'.$counter4_2,  $subtotalzer )
//                         ->setCellValue('M'.$counter4_2,  $value->t_ocean_freight )
//                         ->setCellValue('N'.$counter4_2,  $gstzer )
//                         ->setCellValue('O'.$counter4_2,  $total4 );
//                 }
//                 else{
//                     $objPHPExcel->setActiveSheetIndex(0)
//                         ->setCellValue('H'.$counter4_2,  $subtotalzer )
//                         ->setCellValue('I'.$counter4_2,  $value->t_ocean_freight )
//                         ->setCellValue('J'.$counter4_2,  $gstzer )
//                         ->setCellValue('K'.$counter4_2,  $total4 )
//                         ->setCellValue('L'.$counter4_2, '' )
//                         ->setCellValue('M'.$counter4_2, '')
//                         ->setCellValue('N'.$counter4_2, '')
//                         ->setCellValue('O'.$counter4_2, '');
//                 }

//                 $styleArray = array(
//                     'borders' => array(
//                         'allborders' => array(
//                             'style' => PHPExcel_Style_Border::BORDER_THIN
//                         )
//                     )
//                 );

//                 $objPHPExcel->getActiveSheet()->getStyle('A'.$counter4.':O' . ($jlh4+1))->applyFromArray($styleArray);


//                 $no4++;
//                 $counter4_2++;
//             }
//             endforeach;

//         $countersub4=$counter4_2;
//         $objPHPExcel->getActiveSheet()->mergeCells('A'.$countersub4.':G'.$countersub4);


//         $nsubtotalzersgd=  $subtotalzersgd ;
//         $nsubtotalgstzersgd=  $subtotalgstzersgd ;
//         $nsubtotal4sgd=  $subtotal4sgd ;
//         $nsubtotalzerusd=  $subtotalzerusd ;
//         $nsubtotalgstzerusd=  $subtotalgstzerusd ;
//         $nsubtotal4usd=  $subtotal4usd ;
//         $subtotal4othersgd =  $subtotal4othersgd ;
//         $subtotal4otherusd =  $subtotal4otherusd ;

//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//         $objPHPExcel->getActiveSheet()->getStyle('H'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('I'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('J'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('K'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('L'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('M'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('N'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//         $objPHPExcel->getActiveSheet()->getStyle('O'.$countersub4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//         $jlhs4 = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersub4, 'Sub Total for Zero 0%' )
//             ->setCellValue('H'.$countersub4, $nsubtotalzersgd )
//             ->setCellValue('I'.$countersub4, $subtotal4othersgd )
//             ->setCellValue('J'.$countersub4, $nsubtotalgstzersgd )
//             ->setCellValue('K'.$countersub4, $nsubtotal4sgd)
//             ->setCellValue('L'.$countersub4, $nsubtotalzerusd)
//             ->setCellValue('M'.$countersub4, $subtotal4otherusd)
//             ->setCellValue('N'.$countersub4, $nsubtotalgstzerusd)
//             ->setCellValue('O'.$countersub4, $nsubtotal4usd);

//         ;
//         $objPHPExcel->getActiveSheet()->getStyle('A'.$countersub1.':O' . ($jlhs4+1))->applyFromArray($styleArray);
// ///GST summary report
//         $countersummary=$countersub4+2;


//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersummary, 'GST Summary Report')
//             ->setCellValue('A'.($countersummary+2), $text);


//         $countersummary2=$countersummary+3;

//         $totalotherusd = $subtotal1otherusd + $subtotal2otherusd + $subtotal3otherusd + $subtotal4otherusd;
//         $totalothersgd = $subtotal1othersgd + $subtotal2othersgd + $subtotal3othersgd + $subtotal4othersgd;

//         $totalsum1a=$subtotalexpsgd+ $subtotalgstsgd+ $subtotaloutsgd + $subtotalzersgd ;
//         $totalsum2a=$subtotalgstexpsgd+ $subtotalgstgstsgd+ $subtotalgstoutsgd + $subtotalgstzersgd ;
//         $totalsum3a=$subtotalsgd+ $subtotal2sgd+ $subtotal3sgd + $subtotal4sgd ;

//         $totalsum1b=$subtotalexpusd+ $subtotalgstusd+ $subtotaloutusd + $subtotalzerusd ;
//         $totalsum2b=$subtotalgstexpusd+ $subtotalgstgstusd+ $subtotalgstoutusd + $subtotalgstzerusd ;
//         $totalsum3b=$subtotalusd+ $subtotal2usd+ $subtotal3usd + $subtotal4usd ;



//         //summary exp
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$countersummary2, 'Exempted 0%')
//             ->setCellValue('H'.$countersummary2, $nsubtotalexpsgd )
//             ->setCellValue('I'.$countersummary2, $subtotal1othersgd )
//             ->setCellValue('J'.$countersummary2, $nsubtotalgstexpsgd)
//             ->setCellValue('K'.$countersummary2, $nsubtotalsgd)
//             ->setCellValue('L'.$countersummary2, $nsubtotalexpusd)
//             ->setCellValue('M'.$countersummary2, $subtotal1otherusd)
//             ->setCellValue('N'.$countersummary2, $nsubtotalgstexpusd)
//             ->setCellValue('O'.$countersummary2, $nsubtotalusd);

//         //summary gst
//         // $objPHPExcel->setActiveSheetIndex(0)
//         //     ->setCellValue('A'.($countersummary2+2), 'GST 7%')
//         //     ->setCellValue('H'.($countersummary2+2), $nsubtotalgstsgd )
//         //     ->setCellValue('I'.($countersummary2+2), $nsubtotalgstgstsgd)
//         //     ->setCellValue('J'.($countersummary2+2), $nsubtotal2sgd)
//         //     ->setCellValue('K'.($countersummary2+2), $nsubtotalgstusd)
//         //     ->setCellValue('L'.($countersummary2+2), $nsubtotalgstgstusd)
//         //     ->setCellValue('M'.($countersummary2+2), $nsubtotal2usd);
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.($countersummary2+2), 'GST 7%')
//             ->setCellValue('H'.($countersummary2+2), $nsubtotalgstsgd )
//             ->setCellValue('I'.($countersummary2+2), $subtotal2othersgd )
//             ->setCellValue('J'.($countersummary2+2), $nsubtotalgstgstsgd)
//             ->setCellValue('K'.($countersummary2+2), $nsubtotal2sgd)
//             ->setCellValue('L'.($countersummary2+2), $nsubtotalgstusd)
//             ->setCellValue('M'.($countersummary2+2), $subtotal2otherusd)
//             ->setCellValue('N'.($countersummary2+2), $nsubtotalgstgstusd)
//             ->setCellValue('O'.($countersummary2+2), $nsubtotal2usd);

//         //summary out
//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.($countersummary2+4), 'Out Of Scope 0%')
//             ->setCellValue('H'.($countersummary2+4), $nsubtotaloutsgd )
//             ->setCellValue('I'.($countersummary2+4), $subtotal3othersgd)
//             ->setCellValue('J'.($countersummary2+4), $nsubtotalgstoutsgd)
//             ->setCellValue('K'.($countersummary2+4), $nsubtotal3sgd)
//             ->setCellValue('L'.($countersummary2+4), $nsubtotaloutusd)
//             ->setCellValue('M'.($countersummary2+4), $subtotal3otherusd)
//             ->setCellValue('N'.($countersummary2+4), $nsubtotalgstgstusd)
//             ->setCellValue('O'.($countersummary2+4), $nsubtotal3usd);

//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.($countersummary2+6), 'Zero Rated 0%')
//             ->setCellValue('H'.($countersummary2+6), $nsubtotalzersgd )
//             ->setCellValue('I'.($countersummary2+6), $subtotal4othersgd)
//             ->setCellValue('J'.($countersummary2+6), $nsubtotalgstzersgd)
//             ->setCellValue('K'.($countersummary2+6), $nsubtotal4sgd)
//             ->setCellValue('L'.($countersummary2+6), $nsubtotalzerusd)
//             ->setCellValue('M'.($countersummary2+6), $subtotal4otherusd)
//             ->setCellValue('N'.($countersummary2+6), $nsubtotalgstzerusd)
//             ->setCellValue('O'.($countersummary2+6), $nsubtotal4usd);



//         $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.($countersummary2+8), $text2)
//             ->setCellValue('H'.($countersummary2+8), $totalsum1a  )
//             ->setCellValue('I'.($countersummary2+8), $totalothersgd)
//             ->setCellValue('J'.($countersummary2+8),  $totalsum2a )
//             ->setCellValue('K'.($countersummary2+8),  $totalsum3a )
//             ->setCellValue('L'.($countersummary2+8), $totalsum1b  )
//             ->setCellValue('M'.($countersummary2+8), $totalotherusd)
//             ->setCellValue('N'.($countersummary2+8), $totalsum2b )
//             ->setCellValue('O'.($countersummary2+8),  $totalsum3b );


//         $objPHPExcel->getActiveSheet()->setTitle('GST REPORT');
//         $objPHPExcel->setActiveSheetIndex(0);
//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header('Content-Disposition: attachment;filename="GST_report.xlsx"');
//         header('Cache-Control: max-age=0');
//         header('Cache-Control: max-age=1');
//         header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//         header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//         header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//         header('Pragma: public'); // HTTP/1.0
//         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//         ob_clean();
//         $objWriter->save('php://output');
//         exit;
//     }

    }

?>