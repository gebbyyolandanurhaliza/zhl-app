<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_mon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_purchasing_mon'));
        $this->load->library('PHPExcel');
    }
    //------------------------------------------------About Mon Purchase Order-------------------------------------------------------
    function mon_purchase_order()
    {
        $data['vendor'] = $this->m_purchasing->tampil_vendor_pur('');
        // $data['purchaser']=$this->m_purchasing_mon->tampil_purchaser('pur_tbl_trn_po_hdr');
        $this->template->display('purchasing/mon/mon_purchase_order', $data);
    }

    function mon_purchase_order_filter_po()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $purchaser  = $this->input->get('pur');
        $status     = $this->input->get('stat');
        $mainpo     = $this->input->get('po');
        $npbb       = $this->input->get('npbb');
        $item       = $this->input->get('item');
        $out        = $this->input->get('out');

        $data['po'] =  $this->m_purchasing_mon->tampil_po_filter($from, $to, $vendor, $purchaser, $status, $npbb, $mainpo, $item, $out);
        // $data['pur']=  $this->m_purchasing_mon->tampil_po_filter_purchaser($from,$to,$vendor,$purchaser,$status,$npbb,$mainpo,$item,$out);
        $this->load->view('purchasing/mon/mon_purchase_order_filter_po', $data);
    }
    function mon_proforma_invoice_filter_po()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        // $purchaser = $this->input->get('pur');
        $status = $this->input->get('stat');
        $sono   = $this->input->get('sono');
        // $npbb = $this->input->get('npbb');
        $item   = $this->input->get('item');
        $out    = $this->input->get('out');

        $data['pi'] =  $this->m_purchasing_mon->tampil_pi_filter($from, $to, $vendor, $status,  $sono, $item, $out);
        //   $data['pur'] =  $this->m_purchasing_mon->tampil_po_filter_purchaser($from, $to, $vendor, $purchaser, $status,  $mainpo, $item, $out);
        $this->load->view('purchasing/mon/mon_proforma_invoice_filter', $data);
    }
    function mon_packing_list_filter()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');

        $status = $this->input->get('stat');
        $sono   = $this->input->get('sono');
        $item   = $this->input->get('item');
        $out    = $this->input->get('out');

        $data['pl'] =  $this->m_purchasing_mon->tampil_pi_filter($from, $to, $vendor,  $status,  $sono, $item, $out);
        $this->load->view('purchasing/mon/mon_packing_list_filter', $data);
    }

    function mon_purchase_order_filter_whs()
    {
        $mainpo = $this->input->get('po');
        $cust   = $this->input->get('cust');
        $item   = $this->input->get('item');

        $data['whs'] =  $this->m_purchasing_mon->tampil_po_filter_whs($mainpo, $item, $cust);
        $this->load->view('purchasing/mon/mon_purchase_order_filter_whs', $data);
    }

    function mon_purchase_order_filter_vendor()
    {
        $vendor = $this->input->get('vendor');

        $data['vendor'] =  $this->m_purchasing_mon->tampil_po_filter_vendor($vendor);
        $this->load->view('purchasing/mon/mon_purchase_order_filter_vendor', $data);
    }

    public function purchase_order_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $from       = $this->convert($this->input->get('from'));
        $to         = $this->convert($this->input->get('to'));
        $vendor     = $this->input->get('vendor');
        $purchaser  = $this->input->get('pur');
        $status     = $this->input->get('stat');
        $mainpo     = $this->input->get('po');
        $item       = $this->input->get('item');
        $out        = $this->input->get('out');

        $data =  $this->m_purchasing_mon->tampil_po_filter($from, $to, $vendor, $purchaser, $status, $mainpo,  $item, $out);
        // print_r($data);
        // die;
        //  $pur =  $this->m_purchasing_mon->tampil_po_filter_purchaser($from, $to, $vendor, $purchaser, $status, $mainpo,  $item, $out);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $header = array(
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
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(45);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(90);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(45);

        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A1'.$counter, 'Date : '.date("d/m/Y", strtotime($from)).' To '.date("d/m/Y", strtotime($to)));
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $counter = 4;
   
        $counter++;
        $qtyorder = 0;
        $qtyrecv = 0;
        $qtyout = 0;
        $qtyprice = 0;
        $qtytotal = 0;
        $qtytotalUSD = 0;
        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'Main PO')
            ->setCellValue('B' . $counter, 'Doc Date')
            ->setCellValue('C' . $counter, 'Delivery Date')
            ->setCellValue('D' . $counter, 'Shipment Date')
            ->setCellValue('E' . $counter, 'Status')
            ->setCellValue('F' . $counter, 'Vendor ID')
            ->setCellValue('G' . $counter, 'Vendor Name')
            ->setCellValue('H' . $counter, 'Item ID')
            ->setCellValue('I' . $counter, 'Item Name')
            ->setCellValue('J' . $counter, 'UOM')
            ->setCellValue('K' . $counter, 'Qty Order')
            ->setCellValue('L' . $counter, 'Qty Recv')
            ->setCellValue('M' . $counter, 'Qty Out Standing')
            ->setCellValue('N' . $counter, 'Price')
            ->setCellValue('O' . $counter, 'Total')
            ->setCellValue('P' . $counter, 'Currency')
            ->setCellValue('Q' . $counter, 'Total(USD)');

        $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':Q' . $counter)->applyFromArray($styleArray);
        $counter++;
        foreach ($data as $v) :
            if ($v->status == '2') {
                $status = 'Closed';
            } else {
                $status = 'Open';
            }
            if ($v->qty_outstanding < 0) {
                $out = '0';
            } else {
                $out = $v->qty_outstanding;
            }
            $total = $out * $v->unitprice;
            $totalUSD = $v->total * $v->rate;

            // if ($v->createdby == $rr->createdby) {
            $qtyorder += $v->qtypo;
            $qtyrecv += $v->qtywhs;
            $qtyout += $out;
            $qtyprice += $v->unitprice;
            $qtytotal += $total;
            $qtytotalUSD += $totalUSD;


            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->mainpo)
                ->setCellValue('B' . $counter, date("d/m/Y", strtotime($v->docdate)))
                ->setCellValue('C' . $counter, date("d/m/Y", strtotime($v->deliverdate)))
                ->setCellValue('D' . $counter, date("d/m/Y", strtotime($v->shipdate)))
                ->setCellValue('E' . $counter, $status)
                ->setCellValue('F' . $counter, $v->vendorid)
                ->setCellValue('G' . $counter, $v->vendorcompany)
                ->setCellValue('H' . $counter, $v->itemid)
                ->setCellValue('I' . $counter, $v->itemname)
                ->setCellValue('J' . $counter, $v->uomname)
                ->setCellValue('K' . $counter, number_format($v->qtypo, 2, '.', ''))
                ->setCellValue('L' . $counter, number_format($v->qtywhs, 2, '.', ''))
                ->setCellValue('M' . $counter, number_format($out, 2, '.', ''))
                ->setCellValue('N' . $counter, number_format($v->unitprice, 2, '.', ''))
                ->setCellValue('O' . $counter, number_format($total, 2, '.', ''))
                ->setCellValue('P' . $counter, $v->currency)
                ->setCellValue('Q' . $counter, number_format($totalUSD, 2, '.', ''));

            $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':Q' . $counter)->applyFromArray($styleArray);
            $counter++;
        // }
        endforeach;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $counter . ':J' . $counter);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('M' . $counter, $qtyout)
            ->setCellValue('O' . $counter, $qtytotal)
            ->setCellValue('Q' . $counter, $qtytotalUSD);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':Q' . $counter)->applyFromArray($styleArray);
        $counter++;
        $counter++;
        // }


        $objPHPExcel->getActiveSheet()->setTitle('Purchase Order');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Purchase Order ' . date("dmy") . '.xlsx"');
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

    //------------------------------------------------About Mon Good Receipt--------------------------------------------------------
    function mon_goods_receipt()
    {
        $data['vendor'] = $this->m_purchasing->tampil_vendor_pur('');
        $this->template->display('purchasing/mon/mon_good_receipt', $data);
    }

    function mon_goods_receipt_filter_po()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $docgr  = $this->input->get('docgr');
        $item   = $this->input->get('item');
        $mainpo = $this->input->get('mainpo');

        $data['gr'] =  $this->m_purchasing_mon->tampil_gr_filter($from, $to, $vendor, $docgr, $item, $mainpo);
        // echo "<pre>";
        // print_r($data);
        // die;
        $this->load->view('purchasing/mon/mon_good_receipt_filter_po', $data);
    }

    public function goods_receipt_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $docgr  = $this->input->get('docgr');
        $item   = $this->input->get('item');
        $mainpo = $this->input->get('mainpo');

        $data   =  $this->m_purchasing_mon->tampil_gr_filter($from, $to, $vendor, $docgr, $item, $mainpo);



        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Period : ' . $this->$from->segment(3) . ' To ' . $this->$to->segment(4))
            ->setCellValue('A3', 'No Reff')
            ->setCellValue('B3', 'Doc Date')
            ->setCellValue('C3', 'Delivery Date')
            ->setCellValue('D3', 'Main PO')
            ->setCellValue('E3', 'Item ID')
            ->setCellValue('F3', 'Item Name')
            ->setCellValue('G3', 'Uom')
            ->setCellValue('H3', 'Qty Order')
            ->setCellValue('I3', 'Qty Recv')
            ->setCellValue('J3', 'Unit Price')
            ->setCellValue('K3', 'Vendor Company');


        $counter = 4;
        $qtyorder = 0;
        $qtyrecv = 0;
        foreach ($data as $v) :
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->docno)
                ->setCellValue('B' . $counter, date("d-m-Y", strtotime($v->docdate)))
                ->setCellValue('C' . $counter, date("d-m-Y", strtotime($v->duedate)))
                ->setCellValue('D' . $counter, $v->mainpo)
                ->setCellValue('E' . $counter, $v->itemid)
                ->setCellValue('F' . $counter, $v->itemname)
                ->setCellValue('G' . $counter, $v->uomname)
                ->setCellValue('H' . $counter, $v->qtypo)
                ->setCellValue('I' . $counter, $v->qtywhs)
                ->setCellValue('J' . $counter, $v->unitprice)
                ->setCellValue('K' . $counter, $v->vendorcompany);
            $counter++;
            $qtyorder += $v->qtypo;
            $qtyrecv += $v->qtywhs;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('H' . $counter, $qtyorder)
            ->setCellValue('I' . $counter, $qtyrecv);

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
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':K' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':K' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Goods Receipt');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Goods Receipt ' . date("dmy") . '.xlsx"');
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

    //------------------------------------------------About Mon Good Receipt--------------------------------------------------------
    function mon_sales_invoice()
    {
        $data['cust'] = $this->m_purchasing->tampil_cust_pur('');
        // $data['purchaser'] = $this->m_purchasing_mon->tampil_purchaser('pur_tbl_trn_inv_hdr');
        $this->template->display('purchasing/mon/mon_sales_invoice', $data);
    }

    function mon_sales_invoice_filter_inv()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $cust   = $this->input->get('cust');
        $purchaser = $this->input->get('pur');
        $invno  = $this->input->get('inv');
        $mainpo = $this->input->get('po');
        $item   = $this->input->get('item');
        $sono   = $this->input->get('sono');

        $data['inv'] =  $this->m_purchasing_mon->tampil_inv_filter($from, $to, $cust, $purchaser, $invno, $mainpo, $item, $sono);
        $this->load->view('purchasing/mon/mon_sales_invoice_filter_inv', $data);
    }

    function print_pdf()
    {
        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));

        $data['_Getinv'] =  $this->m_purchasing_mon->print_inv_filter($from, $to);
        $this->load->view('purchasing/printout/purchase_sales_invoice_print', $data);
    }

    public function sales_invoice_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $cust   = $this->input->get('cust');
        $purchaser = $this->input->get('pur');
        $invno  = $this->input->get('inv');
        $mainpo = $this->input->get('po');
        $item   = $this->input->get('item');
        $sono   = $this->input->get('sono');

        $data_hasil =  $this->m_purchasing_mon->tampil_inv_filter($from, $to, $cust, $purchaser, $invno, $mainpo, $item, $sono);
        // print_r($data_hasil);
        // die;
        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('P')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('Q')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('R')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)

            ;

        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.0000_);[Red](#,##0.0000)')
            ->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')

            ;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Date : ' . date("d/m/Y", strtotime($from)) . ' To ' . date("d/m/Y", strtotime($to)))
            ->setCellValue('A3', 'Invoice No')
            ->setCellValue('B3', 'SO No')
            ->setCellValue('C3', 'Doc Date')
            ->setCellValue('D3', 'Due Date')
            ->setCellValue('E3', 'Shipment Date')
            ->setCellValue('F3', 'Customer')
            ->setCellValue('G3', 'Status')
            ->setCellValue('H3', 'MainPO')
            ->setCellValue('I3', 'Item ID')
            ->setCellValue('J3', 'Item Name')
            ->setCellValue('K3', 'Qty')
            ->setCellValue('L3', 'Unit Price')
            ->setCellValue('M3', 'Currency')
            ->setCellValue('N3', 'Tax Code')
            ->setCellValue('O3', 'FC')
            ->setCellValue('P3', 'LC')
            ->setCellValue('Q3', 'Total FC')
            ->setCellValue('R3', 'Total LC')

           ;

        $counter = 4;
        foreach ($data_hasil as $v) :
            // if ($v->tax == 7) {
            //     $taxcode = 'GST';
            // } else {
            //     $taxcode = '-';
            // }
            if ($v->taxcode == 'ZER') {
                $taxcode = 'Zero Rate';
            }else if($v->taxcode == 'GST'){
                $taxcode = 'GST';
            }           
            else {
                $taxcode = 'Out of Scope';
            }

            if ($v->currency == 'SGD') {
                $fc = $v->total;
                $totalfc = $v->rate * $v->total;
            } else {
                $fc = '';
                $totalfc='';
            }
            if ($v->currency == 'USD') {
                $lc = $v->total;
                $totallc = $v->rate * $v->total;
            } else {
                $lc = '';
                $totallc ='';
            }
            // if ($v->currency == 'SGD') {
            //     $totalfc = $v->rate * $v->total;
            // } if ($v->currency == 'USD') {
            //     $totallc = $v->rate * $v->total;
            // }
            if($v->status!=1){
                $stat='CLOSED';
            }else{
                $stat='OPEN';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->invno)
                ->setCellValue('B' . $counter, $v->sono)
                ->setCellValue('C' . $counter, $v->docdate)
                ->setCellValue('D' . $counter, $v->duedate)
                ->setCellValue('E' . $counter, $v->shipdate)
                ->setCellValue('F' . $counter, $v->custid == 'S00040' ? 'S&Z Services ' : $v->custcompany)
                ->setCellValue('G' . $counter, $stat)
                ->setCellValue('H' . $counter, $v->mainpo)
                ->setCellValue('I' . $counter, $v->itemid )
                ->setCellValue('J' . $counter, $v->itemname)
                ->setCellValue('K' . $counter, $v->qty)
                ->setCellValue('L' . $counter, $v->unitprice)
                ->setCellValue('M' . $counter, $v->currency)
                ->setCellValue('N' . $counter, $taxcode)
                ->setCellValue('O' . $counter, $fc != 0 ? $fc : "-")
                ->setCellValue('P' . $counter, $lc != 0 ? $lc : "-")
                ->setCellValue('Q' . $counter, $totalfc != 0 ? $totalfc : "-")
                ->setCellValue('R' . $counter, $totallc != 0 ? $totallc : "-")
                // ->setCellValue('O' . $counter, '$ '.$fc != 0 ? $fc : "0")
                // ->setCellValue('P' . $counter, '$ '.$lc != 0 ? $lc : "0")
                // ->setCellValue('Q' . $counter, '$ '.$totalfc != 0 ? $totalfc : "0")
                // ->setCellValue('R' . $counter, '$ '.$totallc != 0 ? $totallc : "0")

          ;
            $objPHPExcel->getActiveSheet()->getStyle('C' . $counter)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $counter)->getAlignment()->setWrapText(true);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->getStyle('A3:R3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:R3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
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
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L3:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M3:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N3:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O3:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P3:P' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('Q3:Q' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('R3:R' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':R' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':R' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Purchase Sales Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Purchase Sales Invoice ' . date("dmy") . '.xlsx"');
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

    //------------------------------------PROFORMA INVOICE-----------------------
    function mon_proforma_invoice()
    {
        $data['customer'] = $this->m_purchasing->tampil_cust_pur('');
        // $data['purchaser']=$this->m_purchasing_mon->tampil_purchaser('pur_tbl_trn_po_hdr');
        $this->template->display('purchasing/mon/mon_proforma_invoice', $data);
    }

    public function proforma_invoice_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');


        $from   = $this->convert($this->input->get('from'));
        $to     = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $status = $this->input->get('stat');
        $sono   = $this->input->get('sono');
        $item   = $this->input->get('item');
        $out    = $this->input->get('out');


        $data =  $this->m_purchasing_mon->tampil_pi_filter($from, $to, $vendor, $status,  $sono, $item, $out);


        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(35);


        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Period : ' . $this->$from->segment(3) . ' To ' . $this->$to->segment(4))
            ->setCellValue('A3', 'No So /Pi')
            ->setCellValue('B3', 'Doc Date')
            ->setCellValue('C3', 'Delivery Date')
            ->setCellValue('D3', 'Shipment Date')
            ->setCellValue('E3', 'Status')
            ->setCellValue('F3', 'Item ID')
            ->setCellValue('G3', 'Item Name')
            ->setCellValue('H3', 'UOM')
            ->setCellValue('I3', 'Qty')
            ->setCellValue('J3', 'Price')
            ->setCellValue('K3', 'Total')
            ->setCellValue('L3', 'Currency')
            ->setCellValue('M3', 'Customer');


        $counter = 4;
        $qtySO = 0;
        $tot = 0;

        foreach ($data as $v) :
            if ($v->status == 2) {
                $stat = 'CLOSED';
            } else {
                $stat = 'OPEN';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->sono)
                ->setCellValue('B' . $counter, date("d-m-Y", strtotime($v->docdate)))
                ->setCellValue('C' . $counter, date("d-m-Y", strtotime($v->duedate)))
                ->setCellValue('D' . $counter, date("d-m-Y", strtotime($v->shipdate)))
                ->setCellValue('E' . $counter, $stat)
                ->setCellValue('F' . $counter, $v->itemid)
                ->setCellValue('G' . $counter, $v->itemname)
                ->setCellValue('H' . $counter, $v->uomname)
                ->setCellValue('I' . $counter, $v->qty)
                ->setCellValue('J' . $counter, $v->unitprice)
                ->setCellValue('K' . $counter, $v->total)
                ->setCellValue('L' . $counter, $v->currency)
                ->setCellValue('M' . $counter, $v->custcompany);
            $counter++;
            $qtySO += $v->qty;
            $tot += $v->total;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $counter . ':H' . $counter)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('I' . $counter, $qtySO)
            ->setCellValue('K' . $counter, $tot);

        $objPHPExcel->getActiveSheet()->getStyle('A3:M3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:M3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
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
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L3:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M3:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':M' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Proforma Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Proforma Invoice ' . date("dmy") . '.xlsx"');
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


    public function packing_list_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');


        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $status = $this->input->get('stat');
        $sono = $this->input->get('sono');
        $item = $this->input->get('item');
        $out = $this->input->get('out');


        $data =  $this->m_purchasing_mon->tampil_pi_filter($from, $to, $vendor, $status,  $sono, $item, $out);


        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(35);


        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A1', 'Period : ' . $this->$from->segment(3) . ' To ' . $this->$to->segment(4))
            ->setCellValue('A3', 'No PL')
            ->setCellValue('B3', 'Doc Date')
            ->setCellValue('C3', 'Delivery Date')
            ->setCellValue('D3', 'Shipment Date')
            ->setCellValue('E3', 'Status')
            ->setCellValue('F3', 'Item ID')
            ->setCellValue('G3', 'Item Name')
            ->setCellValue('H3', 'UOM')
            ->setCellValue('I3', 'Qty')
            ->setCellValue('J3', 'Net Weight')
            ->setCellValue('K3', 'Gross Weight')
            ->setCellValue('L3', 'Customer');


        $counter = 4;
        $qtySO = 0;


        foreach ($data as $v) :
            if ($v->status == 2) {
                $stat = 'CLOSED';
            } else {
                $stat = 'OPEN';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->sono)
                ->setCellValue('B' . $counter, date("d-m-Y", strtotime($v->docdate)))
                ->setCellValue('C' . $counter, date("d-m-Y", strtotime($v->duedate)))
                ->setCellValue('D' . $counter, date("d-m-Y", strtotime($v->shipdate)))
                ->setCellValue('E' . $counter, $stat)
                ->setCellValue('F' . $counter, $v->itemid)
                ->setCellValue('G' . $counter, $v->itemname)
                ->setCellValue('H' . $counter, $v->uomname)
                ->setCellValue('I' . $counter, $v->qty)
                ->setCellValue('J' . $counter, $v->NettWeight)
                ->setCellValue('K' . $counter, $v->GrossWeight)
                ->setCellValue('L' . $counter, $v->custcompany);
            $counter++;
            $qtySO += $v->qty;

        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $counter . ':H' . $counter)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('I' . $counter, $qtySO);


        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A3:L3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
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
            ->getActiveSheet()->getStyle('K3:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L3:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Packing List');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Packing List' . date("dmy") . '.xlsx"');
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


    //------------------------------------------------About Mon Mainly Purchase--------------------------------------------------------
    function mon_monthly_ps()
    {
        $data['year'] =  $this->m_purchasing_mon->get_year();
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $data['group'] =  $this->m_purchasing->tampil_item_group();
        $data['filter'] = $this->m_purchasing->tampil_supp('');
        $data['created'] = $this->m_purchasing_mon->tampil_purchaser('pur_tbl_trn_po_hdr');
        $this->template->display('purchasing/mon/mon_monthly_ps', $data);
    }

    function mon_monthly_ps_filter()
    {
        $year = $this->input->get('year');
        $tipe = $this->input->get('tipe');
        $cur = $this->input->get('cur');
        $cat = $this->input->get('cat');
        $subcat = $this->input->get('sub');
        $filter = $this->input->get('filter');
        $created = $this->input->get('created');

        $cek = 0;
        if ($tipe == 'sp_pur_mon_mainly_vendor_category' || $tipe == 'sp_pur_mon_mainly_customer_category') {
            $cek = 1;
        }

        $data['mainly'] =  $this->m_purchasing_mon->tampil_monthly_ps($tipe, $year, $cur, $cat, $subcat, $filter, $created);
        $data['cek'] = $cek;
        $this->load->view('purchasing/mon/mon_monthly_ps_dtl', $data);
    }


    function mon_monthly_ps_tbl_design()
    {
        $tipe = $this->input->get('tipe');

        $data['tipe'] = $tipe;
        $this->load->view('purchasing/mon/mon_monthly_ps_dtl_design', $data);
    }

    function mon_monthly_ps_filter_category()
    {
        $cat = $this->input->get('cat');

        $data['groupsub'] =  $this->m_purchasing->tampil_item_group_sub_where($cat);
        $this->load->view('purchasing/mon/mon_monthly_ps_dtl_category', $data);
    }

    public function mon_monthly_excel()
    {
        $year = $this->input->get('year');
        $tipe = $this->input->get('tipe');
        $cur = $this->input->get('cur');
        $cat = $this->input->get('cat');
        $subcat = $this->input->get('sub');
        $filter = $this->input->get('filter');
        $created = $this->input->get('created');

        $data =  $this->m_purchasing_mon->tampil_monthly_ps($tipe, $year, $cur, $cat, $subcat, $filter, $created);

        if ($cat > 0) {
            $category =  $this->m_purchasing->tampil_item_group_where($cat);
            $categoryname = $category->categoryname;
        } else {
            $categoryname = '';
        }

        if ($subcat > 0) {
            $categorysub =  $this->m_purchasing->tampil_item_group_sub_where_row($subcat);
            $categorysubname = $categorysub->categorysubname;
        } else {
            $categorysubname = '';
        }

        if ($tipe == 'sp_pur_mon_mainly_vendor_category' || $tipe == 'sp_pur_mon_mainly_customer_category' || $tipe == 'sp_pur_mon_mainly_comission_category') {
            $this->mon_monthly_excel_category($year, $cur, $data, $categoryname, $categorysubname);
        } else {
            $this->mon_monthly_excel_non_category($year, $cur, $data);
        }
    }

    public function mon_monthly_excel_non_category($year, $cur, $data)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');


        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $objPHPExcel->getActiveSheet()->getStyle("A1:A4")->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle(6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Periode : ' . $year)
            ->setCellValue('A2', 'Currency : ' . $cur)
            ->mergeCells('A1:C1')
            ->mergeCells('A2:C2')
            ->mergeCells('A3:C3')
            ->mergeCells('A4:C4')
            ->setCellValue('A5', 'No')
            ->setCellValue('B5', 'ID')
            ->setCellValue('C5', 'Name')
            ->setCellValue('D5', 'Month')
            ->setCellValue('P5', 'Total')
            ->mergeCells('A5:A6')
            ->mergeCells('B5:B6')
            ->mergeCells('C5:C6')
            ->mergeCells('D5:O5')
            ->mergeCells('P5:P6')
            ->setCellValue('D6', '1')
            ->setCellValue('E6', '2')
            ->setCellValue('F6', '3')
            ->setCellValue('G6', '4')
            ->setCellValue('H6', '5')
            ->setCellValue('I6', '6')
            ->setCellValue('J6', '7')
            ->setCellValue('K6', '8')
            ->setCellValue('L6', '9')
            ->setCellValue('M6', '10')
            ->setCellValue('N6', '11')
            ->setCellValue('O6', '12');

        $no = 1;
        $counter = 7;
        $satu = 0;
        $dua = 0;
        $tiga = 0;
        $empat = 0;
        $lima = 0;
        $enam = 0;
        $tujuh = 0;
        $delapan = 0;
        $sembilan = 0;
        $sepuluh = 0;
        $sebelas = 0;
        $duabelas = 0;
        foreach ($data as $v) :
            $total = $v->tmp_satu + $v->tmp_dua + $v->tmp_tiga + $v->tmp_empat + $v->tmp_lima + $v->tmp_enam + $v->tmp_tujuh + $v->tmp_delapan + $v->tmp_sembilan + $v->tmp_sepuluh + $v->tmp_sebelas + $v->tmp_duabelas;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $v->tmp_id)
                ->setCellValue('C' . $counter, $v->tmp_name)
                ->setCellValue('D' . $counter, $v->tmp_satu)
                ->setCellValue('E' . $counter, $v->tmp_dua)
                ->setCellValue('F' . $counter, $v->tmp_tiga)
                ->setCellValue('G' . $counter, $v->tmp_empat)
                ->setCellValue('H' . $counter, $v->tmp_lima)
                ->setCellValue('I' . $counter, $v->tmp_enam)
                ->setCellValue('J' . $counter, $v->tmp_tujuh)
                ->setCellValue('K' . $counter, $v->tmp_delapan)
                ->setCellValue('L' . $counter, $v->tmp_sembilan)
                ->setCellValue('M' . $counter, $v->tmp_sepuluh)
                ->setCellValue('N' . $counter, $v->tmp_sebelas)
                ->setCellValue('O' . $counter, $v->tmp_duabelas)
                ->setCellValue('P' . $counter, $total);

            $satu += $v->tmp_satu;
            $dua += $v->tmp_dua;
            $tiga += $v->tmp_tiga;
            $empat += $v->tmp_empat;
            $lima += $v->tmp_lima;
            $enam += $v->tmp_enam;
            $tujuh += $v->tmp_tujuh;
            $delapan += $v->tmp_delapan;
            $sembilan += $v->tmp_sembilan;
            $sepuluh += $v->tmp_sepuluh;
            $sebelas += $v->tmp_sebelas;
            $duabelas += $v->tmp_duabelas;
            $counter++;
        endforeach;

        $grandtotal = $satu + $dua + $tiga + $empat + $lima + $enam + $tujuh + $delapan + $sembilan + $sepuluh + $sebelas + $duabelas;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('D' . $counter, $satu)
            ->setCellValue('E' . $counter, $dua)
            ->setCellValue('F' . $counter, $tiga)
            ->setCellValue('G' . $counter, $empat)
            ->setCellValue('H' . $counter, $lima)
            ->setCellValue('I' . $counter, $enam)
            ->setCellValue('J' . $counter, $tujuh)
            ->setCellValue('K' . $counter, $delapan)
            ->setCellValue('L' . $counter, $sembilan)
            ->setCellValue('M' . $counter, $sepuluh)
            ->setCellValue('N' . $counter, $sebelas)
            ->setCellValue('O' . $counter, $duabelas)
            ->setCellValue('P' . $counter, $grandtotal)
            ->mergeCells('A' . $counter . ':C' . $counter);

        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('A' . $counter . ':C' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5:O5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A6:P6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A5:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D6:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E6:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F6:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G6:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H6:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I6:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J6:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K6:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L6:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M6:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N6:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O5:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P5:P' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Monthly Report');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Monthly Report ' . date("dmy") . '.xlsx"');
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

    public function mon_monthly_excel_category($year, $cur, $data, $categoryname, $categorysubname)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)')
            ->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

        $objPHPExcel->getActiveSheet()->getStyle("A1:A4")->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle(6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Periode : ' . $year)
            ->setCellValue('A2', 'Currency : ' . $cur)
            ->setCellValue('A3', 'Category : ' . $categoryname)
            ->setCellValue('A4', 'Category Sub : ' . $categorysubname)
            ->mergeCells('A1:C1')
            ->mergeCells('A2:C2')
            ->mergeCells('A3:C3')
            ->mergeCells('A4:C4')
            ->setCellValue('A5', 'No')
            ->setCellValue('B5', 'Category')
            ->setCellValue('C5', 'Sub Category')
            ->setCellValue('D5', 'Month')
            ->setCellValue('P5', 'Total')
            ->mergeCells('A5:A6')
            ->mergeCells('B5:B6')
            ->mergeCells('C5:C6')
            ->mergeCells('P5:P6')
            ->mergeCells('D5:O5')
            ->setCellValue('D6', '1')
            ->setCellValue('E6', '2')
            ->setCellValue('F6', '3')
            ->setCellValue('G6', '4')
            ->setCellValue('H6', '5')
            ->setCellValue('I6', '6')
            ->setCellValue('J6', '7')
            ->setCellValue('K6', '8')
            ->setCellValue('L6', '9')
            ->setCellValue('M6', '10')
            ->setCellValue('N6', '11')
            ->setCellValue('O6', '12');

        $no = 1;
        $counter = 7;
        $satu = 0;
        $dua = 0;
        $tiga = 0;
        $empat = 0;
        $lima = 0;
        $enam = 0;
        $tujuh = 0;
        $delapan = 0;
        $sembilan = 0;
        $sepuluh = 0;
        $sebelas = 0;
        $duabelas = 0;
        foreach ($data as $v) :
            $total = $v->tmp_satu + $v->tmp_dua + $v->tmp_tiga + $v->tmp_empat + $v->tmp_lima + $v->tmp_enam + $v->tmp_tujuh + $v->tmp_delapan + $v->tmp_sembilan + $v->tmp_sepuluh + $v->tmp_sebelas + $v->tmp_duabelas;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $v->tmp_id)
                ->setCellValue('C' . $counter, $v->tmp_name)
                ->setCellValue('D' . $counter, $v->tmp_satu)
                ->setCellValue('E' . $counter, $v->tmp_dua)
                ->setCellValue('F' . $counter, $v->tmp_tiga)
                ->setCellValue('G' . $counter, $v->tmp_empat)
                ->setCellValue('H' . $counter, $v->tmp_lima)
                ->setCellValue('I' . $counter, $v->tmp_enam)
                ->setCellValue('J' . $counter, $v->tmp_tujuh)
                ->setCellValue('K' . $counter, $v->tmp_delapan)
                ->setCellValue('L' . $counter, $v->tmp_sembilan)
                ->setCellValue('M' . $counter, $v->tmp_sepuluh)
                ->setCellValue('N' . $counter, $v->tmp_sebelas)
                ->setCellValue('O' . $counter, $v->tmp_duabelas)
                ->setCellValue('P' . $counter, $total);

            $satu += $v->tmp_satu;
            $dua += $v->tmp_dua;
            $tiga += $v->tmp_tiga;
            $empat += $v->tmp_empat;
            $lima += $v->tmp_lima;
            $enam += $v->tmp_enam;
            $tujuh += $v->tmp_tujuh;
            $delapan += $v->tmp_delapan;
            $sembilan += $v->tmp_sembilan;
            $sepuluh += $v->tmp_sepuluh;
            $sebelas += $v->tmp_sebelas;
            $duabelas += $v->tmp_duabelas;
            //                $grandtotal += $total;
            $counter++;
        endforeach;

        $grandtotal = $satu + $dua + $tiga + $empat + $lima + $enam + $tujuh + $delapan + $sembilan + $sepuluh + $sebelas + $duabelas;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $counter, 'Grand Total')
            ->setCellValue('D' . $counter, $satu)
            ->setCellValue('E' . $counter, $dua)
            ->setCellValue('F' . $counter, $tiga)
            ->setCellValue('G' . $counter, $empat)
            ->setCellValue('H' . $counter, $lima)
            ->setCellValue('I' . $counter, $enam)
            ->setCellValue('J' . $counter, $tujuh)
            ->setCellValue('K' . $counter, $delapan)
            ->setCellValue('L' . $counter, $sembilan)
            ->setCellValue('M' . $counter, $sepuluh)
            ->setCellValue('N' . $counter, $sebelas)
            ->setCellValue('O' . $counter, $duabelas)
            ->setCellValue('P' . $counter, $grandtotal)
            ->mergeCells('A' . $counter . ':C' . $counter);

        $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('A' . $counter . ':C' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D5:O5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A6:P6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A5:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B5:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C5:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D6:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E6:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F6:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G6:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H6:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I6:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J6:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K6:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L6:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M6:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N6:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O5:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P5:P' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Monthly Report');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Monthly Report ' . date("dmy") . '.xlsx"');
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

    //-------------------------------------------------------mon_proforma_invoice_filter_po--------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }
    //--------------------------------------------------------------------END----------------------------------------------------------------

    ///////////////////////////////MONITORING DO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


    function mon_do()
    {
        $data['vendor'] = $this->m_purchasing->tampil_vendor_pur('');
        //  $data['purchaser'] = $this->m_purchasing_mon->tampil_purchaser('zhl_pur_tbl_trn_gr_hdr');
        $this->template->display('purchasing/mon/mon_do', $data);
    }

    function mon_do_filter_po()
    {
        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $purchaser = $this->input->get('pur');
        $mainpo = $this->input->get('po');
        $item = $this->input->get('item');

        $data['do'] =  $this->m_purchasing_mon->tampil_do_filter($from, $to, $vendor, $purchaser, $mainpo, $item);

        $this->load->view('purchasing/mon/mon_do_filter_po', $data);
    }
    function do_excel()
    {
        $this->load->library("excel/PHPExcel");
        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $vendor = $this->input->get('vendor');
        $purchaser = $this->input->get('pur');
        $mainpo = $this->input->get('po');
        $item = $this->input->get('item');

        $data['do'] =  $this->m_purchasing_mon->tampil_do_filter($from, $to, $vendor, $purchaser, $mainpo, $item);
        $this->load->view('purchasing/mon/toexcel_do', $data);
    }

    //---------------------------------------------------------------Stock------------------------------------------------
    function mon_stock()
    {
        $this->template->display('purchasing/mon/mon_stock');
    }


    function mon_stock_filter()
    {
        $dari       = str_replace('/', '-', $this->input->get('from'));
        $p_dari     = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("to"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $mainpo = $this->input->get('po');
        $item   = $this->input->get('item');
        $status = $this->input->get('status');

        $data['_list'] = $this->m_purchasing_mon->tampil_whs_filter($p_dari, $p_sampai, $mainpo, $item, $status);
        // echo "<pre>";
        // print_r($data);
        // die;
        $this->load->view('purchasing/packing_do/ajax_packingdo_mon', $data);
    }

    public function mon_stock_excel()
    {
        $this->load->library("excel/PHPExcel");
        $dari       = str_replace('/', '-', $this->input->get('from'));
        $p_dari     = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("to"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $mainpo = $this->input->get('po');
        $item   = $this->input->get('item');
        $status = $this->input->get('status');

        $data['record'] = $this->m_purchasing_mon->tampil_whs_filter($p_dari, $p_sampai, $mainpo, $item, $status);

        // $WhsDetail = $this->m_purchasing_mon->tampil_whs_arr($p_dari, $p_sampai, $mainpo, $item, $status);
        // $data['WhsDtl'] =  $WhsDetail;

        // print "<pre>";
        // print_r($data);
        // die;
        $this->load->view('purchasing/printout/toexcel_warehouse', $data);
    }


    //------------------------------------------------------------item stock
    function mon_stock_item()
    {
        $this->template->display('purchasing/mon/mon_stock_item');
    }

    function mon_stock_filter_item()
    {
        $tanggal       = str_replace('/', '-', $this->input->get('tanggal'));
        $tanggal     = date('Y-m-d', strtotime($tanggal));
        $item   = $this->input->get('item');
        $data   = array(
            '_list' => $this->m_purchasing_mon->tampil_whs_filter_item($tanggal,$item)->result()
        );
       // $data['_list'] = $this->m_purchasing_mon->tampil_whs_filter_item($tanggal,$item);
        // echo "<pre>";
        // print_r($data);
        // die;
        $this->load->view('purchasing/packing_do/ajax_packingdo_mon_item', $data);
    }
    public function mon_stock_item_excel()
    {
        $this->load->library("excel/PHPExcel");
        $tanggal       = str_replace('/', '-', $this->input->get('tanggal'));
        $tanggal     = date('Y-m-d', strtotime($tanggal));

        $item   = $this->input->get('item');
        $data   = array(
            'record' => $this->m_purchasing_mon->tampil_whs_filter_item($tanggal,$item)->result()
        );
        // $data['record'] = $this->m_purchasing_mon->tampil_whs_filter_item($p_dari, $p_sampai, $item);

        // $WhsDetail = $this->m_purchasing_mon->tampil_whs_arr($p_dari, $p_sampai, $mainpo, $item, $status);
        // $data['WhsDtl'] =  $WhsDetail;

        // print "<pre>";
        // print_r($data);
        // die;
        $this->load->view('purchasing/printout/toexcel_item_warehouse', $data);
    }
}
