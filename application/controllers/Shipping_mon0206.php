<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class shipping_mon extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_shipping','m_shipping_mon','m_shipping_inv'));
        $this->load->library('PHPExcel');
    }
//--------------------------------------------------------------About Shipping Line-------------------------------------------
    function mon_shipping_liner(){
        $data['factory']=$this->m_shipping->tampil_factory();
        $this->template->display('shipping/mon/mon_container',$data);
    }
    

    function container_stock_mon(){
        $data['factory']=$this->m_shipping->tampil_factory_stock_container();
        $this->template->display('shipping/mon/mon_container_stock',$data);
    }


    function mon_shipping_liner_filter(){
        $tipe=$this->input->get('tipe');
        $shipdate=$this->input->get('ship');
        $factory=$this->input->get('fac');
        $ref=$this->input->get('ref');
        $cont=$this->input->get('cont');
        $seal=$this->input->get('seal');
        
        if(trim($shipdate) != ''){
            $shipdate=$this->convert($this->input->get('ship'));
        }
       
        $data['shipping_liner']=  $this->m_shipping_mon->tampil_container_stock_filter($tipe,$shipdate,$factory,$ref,$cont,$seal);
        $this->load->view('shipping/mon/mon_container_filter_shipping_liner',$data);
    }
    
    function mon_container_stock_filter(){
        $factory_tipe=$this->input->get('factory_tipe');
        $order_by=$this->input->get('order_by');
        $dari=$this->input->get('dari');
        $sampai=$this->input->get('sampai');
        // $shipdate=$this->input->get('ship');
        // $factory=$this->input->get('fac');
        // $ref=$this->input->get('ref');
        // $cont=$this->input->get('cont');
        // $seal=$this->input->get('seal');
        
        // // if(trim($shipdate) != ''){
        // //     $shipdate=$this->convert($this->input->get('ship'));
        // // }
       
        // //$data['shipping_liner']=  $this->m_shipping_mon->tampil_shipping_liner_filter($tipe,$shipdate,$factory,$ref,$cont,$seal);
        $data['shipping_liner']=  $this->m_shipping_mon->tampil_container_stock_filter($factory_tipe,$order_by,$dari,$sampai);
        $this->load->view('shipping/mon/mon_container_stock_filter_shipping_liner',$data);
    }

    function print_pdf(){
        $from=$this->convert($this->input->get('from'));
        $to=$this->convert($this->input->get('to'));
        $cust=$this->input->get('cust');
        $invno=$this->input->get('inv');
        $mainpo=$this->input->get('po');
        $product=$this->input->get('product');
       
        $data['_getInv']=  $this->m_shipping_mon->print_inv_filter($from,$to,$cust,$invno,$mainpo,$product);
        $this->load->view('shipping/printout/shipping_sales_invoice_print',$data);
    }
    
    function mon_sales_invoice(){
        $data['cust']=$this->m_shipping->tampil_cust();
        $this->template->display('shipping/mon/mon_sales_invoice',$data);
    }
    
    function mon_sales_invoice_filter_inv(){
        $from=$this->convert($this->input->get('from'));
        $to=$this->convert($this->input->get('to'));
        $cust=$this->input->get('cust');
        $invno=$this->input->get('inv');
        $po=$this->input->get('po');
        $product=$this->input->get('product');
       
        $data['inv']=  $this->m_shipping_mon->tampil_inv_filter($from,$to,$cust,$invno,$po,$product);
        $this->load->view('shipping/mon/mon_sales_invoice_filter_inv',$data);
    }
    
    function mon_sales_list(){
        $this->template->display('shipping/mon/mon_sales_list');
    }
    
    function mon_sales_list_filter_inv(){
        $tgl=$this->input->get('tgl');
       
        $data['inv']=  $this->m_shipping_mon->tampil_sales_list($tgl);
        $this->load->view('shipping/mon/mon_sales_list_filter_inv',$data);
    }
    
    function mon_total_sales(){
        $data['year']=  $this->m_shipping_mon->get_year();
        $this->template->display('shipping/mon/mon_total_sales',$data);
    }
    
    function mon_total_sales_filter(){
        $year=$this->input->get('year');
       
        $data['total']=  $this->m_shipping_mon->tampil_total_sales($year);
        $this->load->view('shipping/mon/mon_total_sales_dtl',$data);
    }
    
    public function container_print_summary(){
        $shipdate=$this->convert($this->input->get('ship'));
        $factory=$this->input->get('fac');
        
        $result=$this->m_shipping_mon->tampil_cont_where_brand($shipdate,$factory);
        
        if($result->num_rows() > 0){
            $data['_getcont'] =  $result->result();
            $this->load->view('shipping/printout/container_print_summary_fpdf',$data);
        }
    }
    
    public function container_stock_print_summary(){
        $shipdate=$this->convert($this->input->get('ship'));
        $factory=$this->input->get('fac');
        
        $result=$this->m_shipping_mon->tampil_cont_where_brand($shipdate,$factory);
        
        if($result->num_rows() > 0){
            $data['_getcont'] =  $result->result();
            $this->load->view('shipping/printout/container_print_summary_fpdf',$data);
        }
    }

    public function summary_report(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $shipdate=$this->convert($this->input->get('ship'));
        $factory=$this->input->get('fac');
       
        $data =  $this->m_shipping_mon->tampil_cont_where_brand($shipdate,$factory)->result();
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);

        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('G2:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle('F:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle(6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ps.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('H2');
        $objDrawing->setHeight(60);
        $objDrawing->setOffsetX(120);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
        
        foreach ($data as $r){
            $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            $barge=$r->barge;
            $voyage=$r->voyage;
            $etd=$r->etd;
            $etddate=date("d/m/Y",  strtotime($r->etddate));
            $eta=$r->eta;
            $etadate=date("d/m/Y",  strtotime($r->etadate));
            $shipment=date("d M Y",  strtotime($r->shipmentdate));
            $factory=$r->factory_abbr;
        }
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Vessel (Barge) :')
                ->setCellValue('C2', $barge)
                ->setCellValue('A3', 'Voyage :')
                ->setCellValue('C3', $voyage.' ')
                ->setCellValue('A4', 'ETD '.$etd.' :')
                ->setCellValue('C4', $etddate)
                ->setCellValue('A5', 'ETA '.$eta.' :')
                ->setCellValue('C5', $etadate)
                ->setCellValue('G2', $factory.' SUMMARY REPORT')
                ->setCellValue('G3', 'SHIPMENT DATE : '.$shipment)
                ->setCellValue('I3', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('A6', 'No')
                ->setCellValue('B6', 'PO No')
                ->setCellValue('C6', "20'")
                ->setCellValue('D6', "40'")
                ->setCellValue('E6', 'CT')
                ->setCellValue('F6', 'Ctnr/Seal No')
                ->setCellValue('G6', 'Destination')
                ->setCellValue('H6', 'Description/Brand')
                ->setCellValue('I6', 'Ref')
                ->setCellValue('J6', 'Vessel Details');

         $no = 1;
         $counter = 7;$counter_temp=7; $C20=0;$C40=0;$po_temp='';
         foreach($data as $v):
            if($po_temp != $v->po_number){
                $counter_temp=$counter;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$counter, $no++)
                    ->setCellValue('B'.$counter, $v->po_number)
                    ->setCellValue('C'.$counter, $v->c20)
                    ->setCellValue('D'.$counter, $v->c40)
                    ->setCellValue('E'.$counter, $v->container_abbr)
                    ->setCellValue('F'.$counter, $v->container)
                    ->setCellValue('G'.$counter, $v->destination);
            }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$counter_temp, $v->product_name);
                $counter_temp++;
            if($po_temp != $v->po_number){  
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('I'.$counter, $v->client_ref_no)
                    ->setCellValue('J'.$counter, 'ETD Sin : '.$v->etdsin.'   ETA : '.$v->etasin);
            }
            $counter++;
            if($po_temp != $v->po_number){ 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$counter, $v->seal);
            }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$counter_temp, $v->packing);
                $counter_temp++;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$counter_temp, $v->quantity .' '.$v->uom_quantity_name);
                $counter_temp++;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$counter_temp, $v->brand_name);
                $counter_temp++;
                
            if($po_temp != $v->po_number){   
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$counter, 'VESL/VOY : '.$v->vessel);;
            }
            
            $counter++;
            
            if($po_temp != $v->po_number){
                if($v->convessel != '' && strtoupper($v->convessel) != 'X'){
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('J'.$counter, 'Connecting Vessel : '.$v->convessel);
                        $counter++;
                 }
                 $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('J'.$counter, 'BKG REF : '.$v->reff);
                 $counter++;
                 
                 if($v->shipping != '' && isset($v->shipping)){
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('J'.$counter, 'CARRIER: '.$v->shipping);
                        $counter++;
                 }
                 
                 $C20+=$v->c20;$C40+=$v->c40;
            }
            $po_temp=$v->po_number;
            
            if($counter_temp > $counter){$counter=$counter_temp;}
            $counter++;
         endforeach;
        
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C'.$counter, $C20)
                ->setCellValue('D'.$counter, $C40);
          
        $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A6:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B6:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C6:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D6:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E6:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F6:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G6:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H6:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I6:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J6:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':J'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':J'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Summary Report');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Summary Report '.$shipmentdate.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    public function mon_sales_lish_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $tgl=$this->input->get('tgl');
       
        $data = $this->m_shipping_mon->tampil_sales_list($tgl);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(8)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('A8:H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/pss-header.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('B2');
        $objDrawing->setHeight(80);
        $objDrawing->setOffsetX(200);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
        
        foreach ($data as $r){
            $docdate=date("M Y",  strtotime($r->docdate));
        }
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A6', 'Sales Invoice List - '.$docdate)
                ->setCellValue('A8', 'Invoice Date')
                ->setCellValue('B8', 'Invoice No')
                ->setCellValue('C8', 'PO')
                ->setCellValue('D8', 'Customer')
                ->setCellValue('E8', 'Shipment Date')
                ->setCellValue('F8', 'Terms (Days)')
                ->setCellValue('G8', 'GST')
                ->setCellValue('H8', 'Amount (USD)');

         $counter = 9;$total=0;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, date("d-m-Y", strtotime($v->docdate)))
                ->setCellValue('B'.$counter, $v->invno)
                ->setCellValue('C'.$counter, $v->ponumber)
                ->setCellValue('D'.$counter, htmlspecialchars_decode($v->custcompany,ENT_QUOTES))
                ->setCellValue('E'.$counter, date("d-m-Y", strtotime($v->shipdate)))
                ->setCellValue('F'.$counter, $v->termdays)
                ->setCellValue('G'.$counter, $v->tax)
                ->setCellValue('H'.$counter, number_format($v->total * $v->rate ,2));
                $total= $total + $v->total * $v->rate;
            $counter++;
         endforeach;
         
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H'.$counter, number_format($total,2));
          
        $objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A8:H8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A8:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B8:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C8:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D8:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E8:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F8:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G8:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H8:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A9:B'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle('E9:E'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle('H9:H'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('A'.$counter.':H'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':H'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Sales List');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales List '.$docdate.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    public function mon_total_sales_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $year=$this->input->get('year');
       
        $data =  $this->m_shipping_mon->tampil_total_sales($year);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('A5:AO6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->freezePane('F7');
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'ZHENGHE LOGISTIC PTE LTD')
                ->setCellValue('A2', 'SALES')
                ->setCellValue('A3', 'JANUARI - DECEMBER '.$year)
                ->setCellValue('A5', 'PRODUCT')
                ->mergeCells('A5:A6')
                ->setCellValue('B5', 'UNIT')
                ->mergeCells('B5:B6')
                ->setCellValue('C5', 'TOTAL')
                ->mergeCells('C5:E5')
                ->setCellValue('F5', 'JAN')
                ->mergeCells('F5:H5')
                ->setCellValue('I5', 'FEB')
                ->mergeCells('I5:K5')
                ->setCellValue('L5', 'MAR')
                ->mergeCells('L5:N5')
                ->setCellValue('O5', 'APR')
                ->mergeCells('O5:Q5')
                ->setCellValue('R5', 'MAY')
                ->mergeCells('R5:T5')
                ->setCellValue('U5', 'JUN')
                ->mergeCells('U5:W5')
                ->setCellValue('X5', 'JUL')
                ->mergeCells('X5:Z5')
                ->setCellValue('AA5', 'AUG')
                ->mergeCells('AA5:AC5')
                ->setCellValue('AD5', 'SEP')
                ->mergeCells('AD5:AF5')
                ->setCellValue('AG5', 'OCT')
                ->mergeCells('AG5:AI5')
                ->setCellValue('AJ5', 'NOV')
                ->mergeCells('AJ5:AL5')
                ->setCellValue('AM5', 'DEC')
                ->mergeCells('AM5:AO5')
                ->setCellValue('C6', 'QTY')
                ->setCellValue('D6', 'US$')
                ->setCellValue('E6', '@')
                ->setCellValue('F6', 'QTY')
                ->setCellValue('G6', 'US$')
                ->setCellValue('H6', '@')
                ->setCellValue('I6', 'QTY')
                ->setCellValue('J6', 'US$')
                ->setCellValue('K6', '@')
                ->setCellValue('L6', 'QTY')
                ->setCellValue('M6', 'US$')
                ->setCellValue('N6', '@')
                ->setCellValue('O6', 'QTY')
                ->setCellValue('P6', 'US$')
                ->setCellValue('Q6', '@')
                ->setCellValue('R6', 'QTY')
                ->setCellValue('S6', 'US$')
                ->setCellValue('T6', '@')
                ->setCellValue('U6', 'QTY')
                ->setCellValue('V6', 'US$')
                ->setCellValue('W6', '@')
                ->setCellValue('X6', 'QTY')
                ->setCellValue('Y6', 'US$')
                ->setCellValue('Z6', '@')
                ->setCellValue('AA6', 'QTY')
                ->setCellValue('AB6', 'US$')
                ->setCellValue('AC6', '@')
                ->setCellValue('AD6', 'QTY')
                ->setCellValue('AE6', 'US$')
                ->setCellValue('AF6', '@')
                ->setCellValue('AG6', 'QTY')
                ->setCellValue('AH6', 'US$')
                ->setCellValue('AI6', '@')
                ->setCellValue('AJ6', 'QTY')
                ->setCellValue('AK6', 'US$')
                ->setCellValue('AL6', '@')
                ->setCellValue('AM6', 'QTY')
                ->setCellValue('AN6', 'US$')
                ->setCellValue('AO6', '@')
                ;

         $counter = 7;$us_tot=0;$us1=0;$us2=0;$us3=0;$us4=0;$us5=0;
         $us6=0;$us7=0;$us8=0;$us9=0;$us10=0;$us11=0;$us12=0;
         foreach($data as $r):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $r->tmp_product)
                ->setCellValue('B'.$counter, $r->tmp_unit)
                ->setCellValue('C'.$counter, ($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_qty_tot,0)))
                ->setCellValue('D'.$counter, ($r->tmp_us_tot == 0 ? '' : number_format($r->tmp_us_tot,2)))
                ->setCellValue('E'.$counter, ($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_us_tot/$r->tmp_qty_tot,2)))
                ->setCellValue('F'.$counter, ($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_qty1,0)))
                ->setCellValue('G'.$counter, ($r->tmp_us1 == 0 ? '' : number_format($r->tmp_us1,2)))
                ->setCellValue('H'.$counter, ($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_us1/$r->tmp_qty1,2)))
                ->setCellValue('I'.$counter, ($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_qty2,0)))
                ->setCellValue('J'.$counter, ($r->tmp_us2 == 0 ? '' : number_format($r->tmp_us2,2)))
                ->setCellValue('K'.$counter, ($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_us2/$r->tmp_qty2,2)))
                ->setCellValue('L'.$counter, ($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_qty3,0)))
                ->setCellValue('M'.$counter, ($r->tmp_us3 == 0 ? '' : number_format($r->tmp_us3,2)))
                ->setCellValue('N'.$counter, ($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_us3/$r->tmp_qty3,2)))
                ->setCellValue('O'.$counter, ($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_qty4,0)))
                ->setCellValue('P'.$counter, ($r->tmp_us4 == 0 ? '' : number_format($r->tmp_us4,2)))
                ->setCellValue('Q'.$counter, ($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_us4/$r->tmp_qty4,2)))
                ->setCellValue('R'.$counter, ($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_qty5,0)))
                ->setCellValue('S'.$counter, ($r->tmp_us5 == 0 ? '' : number_format($r->tmp_us5,2)))
                ->setCellValue('T'.$counter, ($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_us5/$r->tmp_qty5,2)))
                ->setCellValue('U'.$counter, ($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_qty6,0)))
                ->setCellValue('V'.$counter, ($r->tmp_us6 == 0 ? '' : number_format($r->tmp_us6,2)))
                ->setCellValue('W'.$counter, ($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_us6/$r->tmp_qty6,2)))
                ->setCellValue('X'.$counter, ($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_qty7,0)))
                ->setCellValue('Y'.$counter, ($r->tmp_us7 == 0 ? '' : number_format($r->tmp_us7,2)))
                ->setCellValue('Z'.$counter, ($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_us7/$r->tmp_qty7,2)))
                ->setCellValue('AA'.$counter, ($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_qty8,0)))
                ->setCellValue('AB'.$counter, ($r->tmp_us8 == 0 ? '' : number_format($r->tmp_us8,2)))
                ->setCellValue('AC'.$counter, ($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_us8/$r->tmp_qty8,2)))
                ->setCellValue('AD'.$counter, ($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_qty9,0)))
                ->setCellValue('AE'.$counter, ($r->tmp_us9 == 0 ? '' : number_format($r->tmp_us9,2)))
                ->setCellValue('AF'.$counter, ($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_us9/$r->tmp_qty9,2)))
                ->setCellValue('AG'.$counter, ($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_qty10,0)))
                ->setCellValue('AH'.$counter, ($r->tmp_us10 == 0 ? '' : number_format($r->tmp_us10,2)))
                ->setCellValue('AI'.$counter, ($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_us10/$r->tmp_qty10,2)))
                ->setCellValue('AJ'.$counter, ($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_qty11,0)))
                ->setCellValue('AK'.$counter, ($r->tmp_us11 == 0 ? '' : number_format($r->tmp_us11,2)))
                ->setCellValue('AL'.$counter, ($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_us11/$r->tmp_qty11,2)))
                ->setCellValue('AM'.$counter, ($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_qty12,0)))
                ->setCellValue('AN'.$counter, ($r->tmp_us12 == 0 ? '' : number_format($r->tmp_us12,2)))
                ->setCellValue('AO'.$counter, ($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_us12/$r->tmp_qty12,2)));
            $counter++;$us_tot +=$r->tmp_us_tot;$us1 +=$r->tmp_us1;$us2 +=$r->tmp_us2;$us3 +=$r->tmp_us3;$us4 +=$r->tmp_us4;$us5 +=$r->tmp_us5;
            $us6 +=$r->tmp_us6;$us7 +=$r->tmp_us7;$us8 +=$r->tmp_us8;$us9 +=$r->tmp_us9;$us10 +=$r->tmp_us10;$us11 +=$r->tmp_us11;$us12 +=$r->tmp_us12;
         endforeach;
         
         $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'GRAND TOTAL')
                ->setCellValue('D'.$counter, number_format($us_tot,2))
                ->setCellValue('G'.$counter, number_format($us1,2))
                ->setCellValue('J'.$counter, number_format($us2,2))
                ->setCellValue('M'.$counter, number_format($us3,2))
                ->setCellValue('P'.$counter, number_format($us4,2))
                ->setCellValue('S'.$counter, number_format($us5,2))
                ->setCellValue('V'.$counter, number_format($us6,2))
                ->setCellValue('Y'.$counter, number_format($us7,2))
                ->setCellValue('AB'.$counter, number_format($us8,2))
                ->setCellValue('AE'.$counter, number_format($us9,2))
                ->setCellValue('AH'.$counter, number_format($us10,2))
                ->setCellValue('AK'.$counter, number_format($us11,2))
                ->setCellValue('AN'.$counter, number_format($us12,2));
         
         $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('A'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
          
        $objPHPExcel->getActiveSheet()->getStyle('A5:AO8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C5:AO5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A6:AO6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A5:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B5:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('C6:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('D6:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('E5:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('F6:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('G6:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('H5:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('I6:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('J6:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('K5:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('L6:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('M6:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('N5:N'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('O6:O'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('P6:P'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('Q5:Q'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('R6:R'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('S6:S'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('T5:T'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('U6:U'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('V6:V'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('W5:W'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('X6:X'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('Y6:Y'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('Z5:Z'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AA6:AA'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AB6:AB'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AC5:AC'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AD6:AD'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AE6:AE'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AF5:AF'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AG6:AG'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AH6:AH'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AI5:AI'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AJ6:AJ'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AK6:AK'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AL5:AL'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AM6:AM'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AN6:AN'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('AO5:AO'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('B7:B'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->getActiveSheet()->getStyle('C7:AO'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('A'.$counter.':AO'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':AO'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Sales');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales '.$year.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    public function ToExcel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $tipe=$this->input->get('tipe');
        $shipdate=$this->input->get('ship');
        $factory=$this->input->get('tipe');
        
        if(trim($shipdate) != ''){
            $shipdate=$this->convert($this->input->get('ship'));
        }
       
        $data =  $this->m_shipping_mon->tampil_shipping_liner_filter($tipe,$shipdate,$factory);
        
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);

//         $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//         $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Shipment Date')
                ->setCellValue('C1', 'Factory')
                ->setCellValue('D1', 'Vessel (Barge')
                ->setCellValue('E1', 'To')
                ->setCellValue('F1', 'From')
                ->setCellValue('G1', 'PO Number')
                ->setCellValue('H1', 'Shipper/Carrier')
                ->setCellValue('I1', 'FCL')
                ->setCellValue('J1', 'Destination')
                ->setCellValue('K1', 'Booking Ref')
                ->setCellValue('L1', 'Vessel/Voyage')
                ->setCellValue('M1', 'Depot')
                ->setCellValue('N1', 'PO POD')
                ->setCellValue('O1', 'OP Code')
                ->setCellValue('P1', 'ETD Sin')
                ->setCellValue('Q1', 'Container')
                ->setCellValue('R1', 'Seal')
                ->setCellValue('S1', 'Weight');

         $no = 1;
         $counter = 2;
         foreach($data as $v):
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $no++)
                ->setCellValue('B'.$counter, $v->shipmentdate)
                ->setCellValue('C'.$counter, $v->factory_name)
                ->setCellValue('D'.$counter, $v->barge)
                ->setCellValue('E'.$counter, $v->to)
                ->setCellValue('F'.$counter, $v->from)
                ->setCellValue('G'.$counter, $v->po_number)
                ->setCellValue('H'.$counter, $v->shipping_liner)
                ->setCellValue('I'.$counter, $v->container_name)
                ->setCellValue('J'.$counter, $v->port_name.' - '.$v->destination)
                ->setCellValue('K'.$counter, $v->reff)
                ->setCellValue('L'.$counter, $v->vessel)
                ->setCellValue('M'.$counter, $v->depot)
                ->setCellValue('N'.$counter, $v->pod)
                ->setCellValue('O'.$counter, $v->opcode)
                ->setCellValue('P'.$counter, $v->etdsin)
                ->setCellValue('Q'.$counter, $v->container)
                ->setCellValue('R'.$counter, $v->seal)
                ->setCellValue('S'.$counter, $v->weight);
             $counter++;
         endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Container');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function shipping_excel(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
        
        $from=$this->convert($this->input->get('from'));
        $to=$this->convert($this->input->get('to'));
        $cust=$this->input->get('cust');
        $invno=$this->input->get('inv');
        $mainpo=$this->input->get('po');
        $product=$this->input->get('product');
  
        $data_hasil =  $this->m_shipping_mon->print_inv_filter($from,$to,$cust,$invno,$mainpo,$product);
        
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(41);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
                ->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 ->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 // ->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 ->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 ->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
                 ->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date : '.date("d/m/Y", strtotime($from)).' To '.date("d/m/Y", strtotime($to)))
                ->setCellValue('A3', 'Invoice Date')
                ->setCellValue('B3', 'Invoice No')
                ->setCellValue('C3', 'PO')
                ->setCellValue('D3', 'Custemer')
                ->setCellValue('E3', 'Amount(USD)')
                ->setCellValue('F3', 'Frt/Others(USD)')
                ->setCellValue('G3', 'GST(USD)')
                ->setCellValue('H3', 'Total(USD)')
                ->setCellValue('I3', 'Amount(SGD)')
                ->setCellValue('J3', 'GST(SGD)')
                ->setCellValue('K3', 'Total(SGD)');
        
         $counter = 4;
         foreach($data_hasil as $v): 
            if($v->currency == 'USD'){
                $amountusd = $v->total;
            } else {
                $amountusd = ' ';
            }
            if($v->currency == 'USD'){
                $frtusd = $v->freight;
            } else {
                $frtusd = ' ';
            }
            if($v->currency == 'USD'){
                $gstusd = $v->tax;
            } else {
                $gstusd = ' ';
            }
            if($v->currency == 'USD'){
                $totalusd = $v->totaldue;
            } else {
                $totalusd = ' ';
            }

            if($v->currency == 'SGD'){
                $amountsgd = $v->total;
            } else {
                $amountsgd = '-';
            }
            if($v->currency == 'SGD'){
                $gstsgd = $v->gst;
            } else {
                $gstsgd = '-';
            }
            if($v->currency == 'SGD'){
                $totalsgd = $v->totaldue;
            } else {
                $totalsgd = '-';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, $v->docdate)
                ->setCellValue('B'.$counter, $v->invno)
                ->setCellValue('C'.$counter, $v->ponumber)
                ->setCellValue('D'.$counter, $v->custcompany)
                ->setCellValue('E'.$counter, $amountusd)
                ->setCellValue('F'.$counter, $frtusd)
                ->setCellValue('G'.$counter, $gstusd)
                ->setCellValue('H'.$counter, $totalusd)
                ->setCellValue('I'.$counter, $amountsgd)
                ->setCellValue('J'.$counter, $gstsgd)
                ->setCellValue('K'.$counter, $totalsgd);
            $counter++;
        endforeach;
       
        $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A3:K3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
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
                ->getActiveSheet()->getStyle('A'.$counter.':K'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getActiveSheet()->getStyle('A'.$counter.':K'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        
        $objPHPExcel->getActiveSheet()->setTitle('Shipping Sales Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Shipping Sales Invoice '.date("dmy").'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
//---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date){
        $explode=explode("-", $date);
        
        $time=$explode[2].'/'.$explode[1].'/'.$explode[0];
        
        return $time;
    }
    
//--------------------------------------------------------------------END---------------------------------------------------------------- 
}