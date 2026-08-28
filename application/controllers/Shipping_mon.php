<?php
defined('BASEPATH') or exit('No direct script access allowed');

class shipping_mon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_shipping', 'm_shipping_mon', 'm_shipping_inv'));
        $this->load->library('PHPExcel');


        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    //--------------------------------------------------------------About Shipping Line-------------------------------------------
    
    function mon_shipping_liner()
    {
        $data['factory'] = $this->m_shipping->tampil_factory();
        $this->template->display('shipping/mon/mon_container', $data);
    }

    function container_stock_mon()
    {
        $data['factory'] = $this->m_shipping->tampil_factory_stock_container();
        $this->template->display('shipping/mon/mon_container_stock', $data);
    }

    function mon_shipping_liner_filter()
    {
        $tipe = $this->input->get('tipe');

        $factory = $this->input->get('fac');
        $ref = $this->input->get('ref');
        $cont = $this->input->get('cont');
        $seal = $this->input->get('seal');
        $ves = $this->input->get('ves');
        $shipmonth = $this->input->get('shipmonth');
        $shipdate = $this->input->get('ship');
        if (trim($shipdate) != '') {
            $shipdate = $this->convert($this->input->get('ship'));
        }

        if (trim($shipmonth) != '') {
            $shipmonth = $this->convert($this->input->get('shipmonth'));
        }

        $data['shipping_liner'] =  $this->m_shipping_mon->tampil_shipping_liner_filter($tipe, $shipdate, $factory, $ref, $cont, $seal, $ves, $shipmonth);
        $data['shipping_liner_ggfs'] =  $this->m_shipping_mon->tampil_shipping_liner_filter_ggfs($tipe, $shipdate, $factory, $ref, $cont, $seal, $ves, $shipmonth);

        $this->load->view('shipping/mon/mon_container_filter_shipping_liner', $data);
    }

    function mon_container_stock_filter()
    {
        $factory_tipe = $this->input->get('factory_tipe');
        $order_by = $this->input->get('order_by');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        //$container_number=$this->input->get('container_number');
        // $shipdate=$this->input->get('ship');
        // $factory=$this->input->get('fac');
        // $ref=$this->input->get('ref');
        // $cont=$this->input->get('cont');
        // $seal=$this->input->get('seal');

        // // if(trim($shipdate) != ''){
        // //     $shipdate=$this->convert($this->input->get('ship'));
        // // }

        // //$data['shipping_liner']=  $this->m_shipping_mon->tampil_shipping_liner_filter($tipe,$shipdate,$factory,$ref,$cont,$seal);
        $data['shipping_liner'] =  $this->m_shipping_mon->tampil_container_stock_filter($factory_tipe, $order_by, $dari, $sampai);
        $this->load->view('shipping/mon/mon_container_stock_filter_shipping_liner', $data);
    }

    function print_pdf()
    {
        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $cust = $this->input->get('cust');
        $invno = $this->input->get('inv');
        $mainpo = $this->input->get('po');
        $product = $this->input->get('product');

        $data['_getInv'] =  $this->m_shipping_mon->print_inv_filter($from, $to, $cust, $invno, $mainpo, $product);
        $this->load->view('shipping/printout/shipping_sales_invoice_print', $data);
    }

    function mon_sales_invoice()
    {
        $data['cust'] = $this->m_shipping->tampil_cust();
        $this->template->display('shipping/mon/mon_sales_invoice', $data);
    }

    function mon_sales_invoice_filter_inv()
    {
        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $cust = $this->input->get('cust');
        $invno = $this->input->get('inv');
        $po = $this->input->get('po');
        $product = $this->input->get('product');

        $data['inv'] =  $this->m_shipping_mon->tampil_inv_filter($from, $to, $cust, $invno, $po, $product);
        $this->load->view('shipping/mon/mon_sales_invoice_filter_inv', $data);
    }

    function mon_sales_list()
    {
        $this->template->display('shipping/mon/mon_sales_list');
    }

    function mon_sales_list_filter_inv()
    {
        $tgl = $this->input->get('tgl');

        $data['inv'] =  $this->m_shipping_mon->tampil_sales_list($tgl);
        $this->load->view('shipping/mon/mon_sales_list_filter_inv', $data);
    }

    function mon_total_sales()
    {
        $data['year'] =  $this->m_shipping_mon->get_year();
        $this->template->display('shipping/mon/mon_total_sales', $data);
    }

    function mon_total_sales_filter()
    {
        $year = $this->input->get('year');

        $data['total'] =  $this->m_shipping_mon->tampil_total_sales($year);
        $this->load->view('shipping/mon/mon_total_sales_dtl', $data);
    }

    public function container_print_summary()
    {
        $shipdate = $this->convert($this->input->get('ship'));
        $factory = $this->input->get('fac');
        $ves = $this->input->get('ves');


        $result = $this->m_shipping_mon->tampil_cont_where_brand($shipdate, $factory, $ves);

        if ($result->num_rows() > 0) {
            $data['_getcont'] =  $result->result();
            $this->load->view('shipping/printout/container_print_summary_fpdf', $data);
        }
    }

    public function container_stock_print_summary()
    {
        $factory_tipe = $this->input->get('factory_tipe');
        $order_by = $this->input->get('order_by');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $container_number = $this->input->get('container_number');

        //$result=$this->m_shipping_mon->tampil_cont_where_brand($shipdate,$factory);
        $result = $this->m_shipping_mon->tampil_container_stock_filter($factory_tipe, $order_by, $dari, $sampai);

        if ($result->num_rows() > 0) {
            $data['_getcont'] =  $result->result();
            $this->load->view('shipping/printout/container_print_summary_fpdf', $data);
        }
    }

    public function summary_report()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $shipmonth = $this->input->get('shipmonth');
        $shipdate  = $this->input->get('ship');
        if (trim($shipdate) != '') {
            $shipdate = $this->convert($this->input->get('ship'));
        }
        if (trim($shipmonth) != '') {
            $shipmonth = $this->convert($this->input->get('shipmonth'));
        }
        $factory = $this->input->get('fac');
        $ves     = $this->input->get('ves');

        $data  = $this->m_shipping_mon->tampil_cont_where_brand($shipdate, $factory, $ves, $shipmonth)->result();
        $data2 = $this->m_shipping_mon->tampil_cont_where_brand_ggfs($shipdate, $factory, $ves, $shipmonth)->result(); // << sheet 2

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        $objPHPExcel = new PHPExcel();

        // ============================================================
        // HELPER: setup kolom & style
        // ============================================================
        $setupSheet = function($sheet) {
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(5);
            $sheet->getColumnDimension('D')->setWidth(5);
            $sheet->getColumnDimension('E')->setWidth(5);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
            $sheet->getColumnDimension('I')->setWidth(20);
            $sheet->getColumnDimension('J')->setWidth(40);
            $sheet->getColumnDimension('K')->setWidth(40);

            foreach ([2, 3, 4, 5, 6] as $row) {
                $sheet->getStyle($row)->getFont()->setBold(true);
            }
            $sheet->getStyle('G2:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle(6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        };

        // ============================================================
        // HELPER: isi konten sheet
        // ============================================================
        $fillSheet = function($sheet, $data, $logo_path) {
            if (empty($data)) {
                $sheet->setCellValue('A1', 'No data available');
                return null; // early return
            }
            $style1_c = [
                'font' => [
                    'bold'  => FALSE,
                    'name'  => 'Calibri',
                    'size'  => '10',
                    'color' => ['rgb' => 'ff0000']
                ],
            ];

            // Logo
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath($logo_path);
            $objDrawing->setCoordinates('H2');
            $objDrawing->setHeight(60);
            $objDrawing->setOffsetX(120);
            $objDrawing->setWorksheet($sheet);

            // Ambil info header
            foreach ($data as $r) {
                $shipmentdate = date("dmy",   strtotime($r->shipmentdate));
                $barge        = $r->barge;
                $voyage       = $r->voyage;
                $etd          = $r->etd;
                $etddate      = date("d/m/Y", strtotime($r->etddate));
                $eta          = $r->eta;
                $etadate      = date("d/m/Y", strtotime($r->etadate));
                $shipment     = date("d M Y", strtotime($r->shipmentdate));
                $factory      = $r->factory_abbr;
            }

            // Header info & kolom
            $sheet->setCellValue('A2', 'Vessel (Barge) :')->setCellValue('C2', $barge)
                  ->setCellValue('A3', 'Voyage :')         ->setCellValue('C3', $voyage . ' ')
                  ->setCellValue('A4', 'ETD ' . $etd . ' :')->setCellValue('C4', $etddate)
                  ->setCellValue('A5', 'ETA ' . $eta . ' :')->setCellValue('C5', $etadate)
                  ->setCellValue('G2', $factory . ' SUMMARY REPORT')
                  ->setCellValue('G3', 'SHIPMENT DATE : ' . $shipment)
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
                  ->setCellValue('J6', 'Vessel Details')
                  ->setCellValue('K6', 'Stuffing')
                  ->setCellValue('L6', 'Bill Status');

            $no           = 1;
            $counter      = 7;
            $counter_temp = 7;
            $C20          = 0;
            $C40          = 0;
            $po_temp      = '';

            foreach ($data as $v) {
                if ($po_temp != $v->po_number) {
                    $counter_temp = $counter;
                    $sheet->setCellValue('A' . $counter, $no++)
                          ->setCellValue('B' . $counter, $v->po_number)
                          ->setCellValue('C' . $counter, $v->c20)
                          ->setCellValue('D' . $counter, $v->c40)
                          ->setCellValue('E' . $counter, $v->container_abbr)
                          ->setCellValue('F' . $counter, $v->container)
                          ->setCellValue('G' . $counter, $v->destination)
                          ->setCellValue('L' . $counter, $v->jurnal_barge_sales);

                    // Logika EE
                    if ($v->stuffing == 'EE') {
                        $sheet->setCellValue('K' . $counter, $v->stuffing);
                    } else {
                        $sheet->setCellValue('K' . $counter, $v->stuffing . '-' . $v->depot);
                    }
                }

                $sheet->setCellValue('H' . $counter_temp, $v->product_name);
                $counter_temp++;

                if ($po_temp != $v->po_number) {
                    $sheet->setCellValue('I' . $counter, $v->client_ref_no)
                          ->setCellValue('J' . $counter, 'ETD Sin : ' . $v->etdsin . '   ETA : ' . $v->etasin);
                }
                $counter++;

                if ($po_temp != $v->po_number) {
                    $sheet->getStyle('F' . $counter)->applyFromArray($style1_c);
                    $sheet->setCellValue('F' . $counter, $v->actual_seal);
                }

                $sheet->setCellValue('H' . $counter_temp, $v->packing);
                $counter_temp++;
                $sheet->setCellValue('H' . $counter_temp, number_format($v->quantity, 0, '', '') . ' ' . $v->uom_quantity_name);
                $counter_temp++;
                $sheet->setCellValue('H' . $counter_temp, $v->brand_name);
                $counter_temp++;

                if ($po_temp != $v->po_number) {
                    $sheet->setCellValue('J' . $counter, 'VESL/VOY : ' . $v->vessel);
                }
                $counter++;

                if ($po_temp != $v->po_number) {
                    if ($v->convessel != '' && strtoupper($v->convessel) != 'X') {
                        $sheet->setCellValue('J' . $counter, 'Connecting Vessel : ' . $v->convessel);
                        $counter++;
                    }
                    $sheet->setCellValue('J' . $counter, 'BKG REF : ' . $v->reff);
                    $counter++;

                    if ($v->shipping != '' && isset($v->shipping)) {
                        $sheet->setCellValue('J' . $counter, 'CARRIER: ' . $v->shipping);
                        $counter++;
                    }

                    $C20 += $v->c20;
                    $C40 += $v->c40;
                }

                $po_temp = $v->po_number;

                if ($counter_temp > $counter) {
                    $counter = $counter_temp;
                }
                $counter++;
            }

            // Total row
            $sheet->setCellValue('C' . $counter, $C20)
                  ->setCellValue('D' . $counter, $C40);

            // Border
            $sheet->getStyle('A6:L6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            foreach (range('A', 'L') as $col) {
                $sheet->getStyle($col . '6:' . $col . $counter)
                      ->getBorders()->getRight()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }
            $sheet->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle('A' . $counter . ':L' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            return $shipmentdate;
        };

        // ============================================================
        // SHEET 1 — tampil_cont_where_brand
        // ============================================================
        $sheet1 = $objPHPExcel->getActiveSheet();
        $sheet1->setTitle('Summary Report');
        $setupSheet($sheet1);
        $shipmentdate = $fillSheet($sheet1, $data, 'assets/ZHL-Report.png');

        // ============================================================
        // SHEET 2 — tampil_cont_where_brand_ggfs
        // ============================================================
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet2 = $objPHPExcel->getActiveSheet();
        $sheet2->setTitle('Summary Report GGFS');
        $setupSheet($sheet2);
        $fillSheet($sheet2, $data2, 'assets/ZHL-Report.png');

        // ============================================================
        // OUTPUT
        // ============================================================
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Summary Report ' . $shipmentdate . '.xlsx"');
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

    public function inward_report()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $shipmonth = $this->input->get('shipmonth');
        $shipdate  = $this->input->get('ship');
        if (trim($shipdate) != '') {
            $shipdate = $this->convert($this->input->get('ship'));
        }
        if (trim($shipmonth) != '') {
            $shipmonth = $this->convert($this->input->get('shipmonth'));
        }
        $factory = $this->input->get('fac');

        $data  = $this->m_shipping_mon->tampil_cont_where_inward($shipdate, $factory, $shipmonth)->result();
        $data2 = $this->m_shipping_mon->tampil_cont_where_inward_ggfs($shipdate, $factory, $shipmonth)->result();

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        $objPHPExcel = new PHPExcel();

        // ============================================================
        // HELPER: setup kolom & style
        // ============================================================
        $setupSheet = function($sheet) {
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(35);
            $sheet->getColumnDimension('F')->setWidth(35);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
            $sheet->getColumnDimension('I')->setWidth(20);

            foreach ([2, 3, 4, 5, 7] as $row) {
                $sheet->getStyle($row)->getFont()->setBold(true);
            }
            $sheet->getStyle('G2:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        };

        // ============================================================
        // HELPER: isi konten sheet
        // ============================================================
        $fillSheet = function($sheet, $data, $logo_path) {
            if (empty($data)) {
                $sheet->setCellValue('A1', 'No data available');
                return null; // early return
            }
            // Logo
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $objDrawing->setPath($logo_path);
            $objDrawing->setCoordinates('F2');
            $objDrawing->setHeight(60);
            $objDrawing->setOffsetX(120);
            $objDrawing->setWorksheet($sheet);

            // Ambil info header
            foreach ($data as $r) {
                $shipmentdate = date("dmy",   strtotime($r->shipmentdate));
                $barge        = $r->barge;
                $voyage       = $r->voyage;
                $etd          = $r->etd;
                $etddate      = date("d/m/Y", strtotime($r->etddate));
                $eta          = $r->eta;
                $etadate      = date("d/m/Y", strtotime($r->etadate));
                $shipment     = date("d M Y", strtotime($r->shipmentdate));
                $factory      = $r->factory_abbr;
            }

            // Header info & kolom
            $sheet->setCellValue('A2', 'Vessel (Barge) :')->setCellValue('C2', $barge)
                  ->setCellValue('A3', 'Voyage :')         ->setCellValue('C3', $voyage . ' ')
                  ->setCellValue('A4', 'ETD ' . $etd . ' :')->setCellValue('C4', $etddate)
                  ->setCellValue('A5', 'ETA ' . $eta . ' :')->setCellValue('C5', $etadate)
                  ->setCellValue('E2', $factory . ' INWARD REPORT')
                  ->setCellValue('E3', 'SHIPMENT DATE : ' . $shipment)
                  ->setCellValue('G3', 'ZHENGHE LOGISTIC PTE LTD')
                  ->setCellValue('A7', 'No')
                  ->setCellValue('B7', 'Shimetdate')
                  ->setCellValue('C7', 'PO Number')
                  ->setCellValue('D7', 'Customer Name')
                  ->setCellValue('E7', 'Destination')
                  ->setCellValue('F7', 'Booking Reff')
                  ->setCellValue('G7', 'Vessel / Voyage')
                  ->setCellValue('H7', 'ETD Singapore')
                  ->setCellValue('I7', 'Container');

            $no      = 1;
            $counter = 8;
            $po_temp = '';

            foreach ($data as $v) {
                if ($po_temp != $v->po_number) {
                    $sheet->setCellValue('A' . $counter, $no++)
                          ->setCellValue('B' . $counter, $v->shipmentdate)
                          ->setCellValue('C' . $counter, $v->po_number)
                          ->setCellValue('D' . $counter, $v->customer_name)
                          ->setCellValue('E' . $counter, $v->destination)
                          ->setCellValue('F' . $counter, $v->reff)
                          ->setCellValue('G' . $counter, $v->etdsin)
                          ->setCellValue('H' . $counter, $v->etdsin)
                          ->setCellValue('I' . $counter, $v->container);
                }
                $counter++;
                $po_temp = $v->po_number;
            }

            // Border
            $sheet->getStyle('A7:I7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle('A7:I7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            foreach (range('A', 'I') as $col) {
                $sheet->getStyle($col . '7:' . $col . $counter)
                      ->getBorders()->getRight()
                      ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            }
            $sheet->getStyle('A' . $counter . ':I' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sheet->getStyle('A' . $counter . ':I' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            return $shipmentdate;
        };

        // ============================================================
        // SHEET 1 — tampil_cont_where_inward
        // ============================================================
        $sheet1 = $objPHPExcel->getActiveSheet();
        $sheet1->setTitle('Inward Report');
        $setupSheet($sheet1);
        $shipmentdate = $fillSheet($sheet1, $data, 'assets/ZHL-Report.png');

        // ============================================================
        // SHEET 2 — tampil_cont_where_inward_ggfs
        // ============================================================
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $sheet2 = $objPHPExcel->getActiveSheet();
        $sheet2->setTitle('Inward Report GGFS');
        $setupSheet($sheet2);
        $fillSheet($sheet2, $data2, 'assets/ZHL-Report.png');

        // ============================================================
        // OUTPUT
        // ============================================================
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Inward Report ' . $shipmentdate . '.xlsx"');
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

    public function summary_vessel_report()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $shipmonth = $this->input->get('shipmonth');
        $shipdate = $this->input->get('ship');
        if (trim($shipdate) != '') {
            $shipdate = $this->convert($this->input->get('ship'));
        }

        if (trim($shipmonth) != '') {
            $shipmonth = $this->convert($this->input->get('shipmonth'));
        }
        $factory = $this->input->get('fac');
        $ves = $this->input->get('ves');
        $data =  $this->m_shipping_mon->tampil_cont($shipdate, $factory, $ves, $shipmonth)->result();

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

        $style1_c = array(
            'font'      => array(
                'bold' => FALSE,
                'name' => 'Calibri',
                'size' => '10',
                'color' => array('rgb' => 'ff0000')
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('G2:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('A:B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        foreach ($data as $r) {
            $shipmentdate = date("dmy",  strtotime($r->shipmentdate));
            $barge = $r->barge;
            $voyage = $r->voyage;
            $etd = $r->etd;
            $etddate = date("d/m/Y",  strtotime($r->etddate));
            $eta = $r->eta;
            $etadate = date("d/m/Y",  strtotime($r->etadate));
            $shipment = date("d M Y",  strtotime($r->shipmentdate));
            $factory = $r->factory_abbr;
        }
        //print_r($data);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Vessel (Barge) :')
            ->setCellValue('B2', $barge)
            ->setCellValue('A3', 'Voyage :')
            ->setCellValue('B3', $voyage . ' ')
            ->setCellValue('A4', 'ETD ' . $etd . ' :')
            ->setCellValue('B4', $etddate)
            ->setCellValue('A5', 'ETA ' . $eta . ' :')
            ->setCellValue('B5', $etadate)
            ->setCellValue('C2', $factory . ' VESSEL AND VOYAGE REPORT')
            ->setCellValue('C3', 'SHIPMENT DATE : ' . $shipment)
            ->setCellValue('C4', 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('A7', 'Seq Number')
            ->setCellValue('B7', 'Vessel and Voyage Details');

        $no = 1;
        $counter = 8;
        $counter_temp = 8;
        $C20 = 0;
        $C40 = 0;
        $po_temp = '';
        foreach ($data as $v) :
            if ($po_temp != $v->shipid) {
                $counter_temp = $counter;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $no++);
            }

            if ($po_temp != $v->shipid) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $counter, 'ETD SIN : ' . $v->etdsin);
            }
            $counter++;

            if ($po_temp != $v->shipid) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $counter, 'ETA ' . $v->destination . ' : ' . $v->etasin);
            }
            $counter++;

            if ($po_temp != $v->shipid) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $counter, 'VESL/VOY : ' . $v->vessel);;
            }
            $counter++;

            if ($po_temp != $v->shipid) {
                if ($v->convessel != '' && strtoupper($v->convessel) != 'X') {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $counter, 'Connecting Vessel : ' . $v->convessel);
                    $counter++;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $counter, 'BKG REF : ' . $v->reff);
                $counter++;

                if ($v->shipping_liner != '' && isset($v->shipping_liner)) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $counter, 'CARRIER: ' . $v->shipping_liner);
                    $counter++;
                }

                $C20 += $v->c20;
                $C40 += $v->c40;
            }
            $po_temp = $v->shipid;

            if ($counter_temp > $counter) {
                $counter = $counter_temp;
            }
            $counter++;

        endforeach;


        $objPHPExcel->getActiveSheet()->getStyle('A7:B7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:B7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':B' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':B' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Vessel Voyage Report');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Vessel Voyage Report ' . $shipmentdate . '.xlsx"');
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

    public function container_stock_report()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        // $shipdate=$this->convert($this->input->get('ship'));
        // $factory=$this->input->get('fac');

        // $data =  $this->m_shipping_mon->tampil_cont_where_brand($shipdate,$factory)->result();

        $factory_tipe = $this->input->get('factory_tipe');
        $order_by = $this->input->get('order_by');
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $container_number = $this->input->get('container_number');

        $data =  $this->m_shipping_mon->tampil_container_stock_filter($factory_tipe, $order_by, $dari, $sampai);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        // // Set Color
        // $objPHPExcel = new PHPExcel_Style_Color();
        // $objPHPExcel->setRGB("FFF443");
        // $objPHPExcel->getStyle('B5:Z5')->getFont()->setColor($objPHPExcel);
        // $objPHPExcel->getStyle('D4')->getFont()->setColor($objPHPExcel);
        // $objPHPExcel->getStyle('B6:C6')->getFont()->setBold(true);
        // $objPHPExcel->getStyle('B2:B3')->getFont()->setBold(true);
        // //=========

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);

        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
            ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('F2');
        $objDrawing->setHeight(80);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        foreach ($data as $r) {
            // $shipmentdate=date("dmy",  strtotime($r->shipmentdate));
            // $barge=$r->barge;
            // $voyage=$r->voyage;
            // $etd=$r->etd;
            // $etddate=date("d/m/Y",  strtotime($r->etddate));
            // $eta=$r->eta;
            // $etadate=date("d/m/Y",  strtotime($r->etadate));
            // $shipment=date("d M Y",  strtotime($r->shipmentdate));
            // $to=$r->to;
            // $remark=str_replace("<br />", "",$r->remarks);
            // $createdby=$r->createdby;
            $stock_id_hdr      = $r->stock_id_hdr;
            $stock_id_dtl      = $r->stock_id_dtl;
            $container_number  = $r->container_number;
            $container_id      = $r->container_id;
            $container_name    = $r->container_name;
            $loading_port      = $r->loading_port;
            // $arrival_date = str_replace('/', '-', $this->input->post('arrival_date'));        
            //         $p_tanggal = date('Y-m-d', strtotime($arrival_date)); //tanggal jurnal
            $arrival_date      = date('Y-m-d', strtotime($r->arrival_date)); //tanggal jurnal
            $free_time         = $r->free_time;
            $Remark            = $r->Remark;
            $factory           = $r->factory;
            $supplier          = $r->supplier;
            $import_bl_no      = $r->import_bl_no;
            $eta               = date('Y-m-d', strtotime($r->eta)); //tanggal jurnal
            $free_time_expiry  = date('Y-m-d', strtotime($r->free_time_expiry)); //tanggal jurnal
            $status            = $r->status_note;

            //========Countdown from Expiry Date============
            $awal  = strtotime($r->free_time_expiry);
            $tempo = time();
            $count_down = floor(($awal - $tempo) / (86400));
            //==============================================
        }

        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A2', 'Vessel (Barge) :')
            // ->setCellValue('C2', ' ')
            // ->setCellValue('A3', 'Voyage :')
            // ->setCellValue('C3', ' ')
            // ->setCellValue('A4', 'ETD :')
            // ->setCellValue('C4', ' ')
            // ->setCellValue('A5', 'ETA :')
            // ->setCellValue('C5', ' ')
            ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('G4', 'Monitoring Container Stock List')
            //->setCellValue('G5', 'Shipment Date : ')
            ->setCellValue('J4', 'To : ' . $dari)
            ->setCellValue('J5', 'From : ' . $sampai)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Container Type')
            ->setCellValue('C7', 'Container Number')
            ->setCellValue('D7', 'Import BL No')
            ->setCellValue('E7', 'Carrier')
            ->setCellValue('F7', 'Loading Port')
            ->setCellValue('G7', 'Remark')
            ->setCellValue('H7', 'Factory')
            ->setCellValue('I7', 'Estimation Time Arrival')
            ->setCellValue('J7', 'Arrival Date')
            ->setCellValue('K7', 'Free Time')
            ->setCellValue('L7', 'Expiry Date')
            ->setCellValue('M7', 'Supplier')
            ->setCellValue('N7', 'Status Container')
            ->setCellValue('O7', 'Expiry Date Countdown');

        $no = 1;
        $counter = 8;
        // //$C20=0;$C40=0;
        foreach ($data as $v) :

            //========Countdown from Expiry Date============
            $awal  = strtotime($v->free_time_expiry);
            $tempo = time();
            $count_down = floor(($awal - $tempo) / (86400));
            //==============================================

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $v->container_name)
                ->setCellValue('C' . $counter, $v->container_number)
                ->setCellValue('D' . $counter, $v->import_bl_no)
                ->setCellValue('E' . $counter, $v->carrier)
                ->setCellValue('F' . $counter, $v->loading_port)
                ->setCellValue('G' . $counter, $v->Remark)
                ->setCellValue('H' . $counter, $v->factory)
                ->setCellValue('I' . $counter, $v->eta)
                ->setCellValue('J' . $counter, $v->arrival_date)
                ->setCellValue('K' . $counter, $v->free_time . ' Days')
                ->setCellValue('L' . $counter, $v->free_time_expiry)
                ->setCellValue('M' . $counter, $v->supplier)
                ->setCellValue('N' . $counter, $v->status_note);

            if ($v->status_note == '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, 'Ready');
            } elseif ($v->status_note == '1') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, 'Has Been Used');
            } elseif ($v->status_note == '2') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, 'Return to Singapore');
            } elseif ($v->status_note == '3') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, 'Transfer From Stock Container');
            }

            if ($v->status_note == '0') {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $counter, $count_down . ' Days');
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $counter, '  ');
            }


            $counter++;
        //$C20 += $v->c20;$C40 += $v->c40;
        endforeach;

        // $objPHPExcel->setActiveSheetIndex(0)
        //        ->setCellValue('D'.$counter, $C20)
        //        ->setCellValue('E'.$counter, $C40);

        $objPHPExcel->getActiveSheet()->getStyle('A7:O7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:O7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M7:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N7:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O7:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':O' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':O' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // $counter++;
        // $objPHPExcel->setActiveSheetIndex(0)
        //         ->setCellValue('A'.$counter, 'REMARKS')
        //         ->setCellValue('A'.$counter++, $remark);

        $objPHPExcel->getActiveSheet()->setTitle('Container Stock');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container Stock.xlsx"');
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

    public function mon_sales_lish_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $tgl = $this->input->get('tgl');

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

        foreach ($data as $r) {
            $docdate = date("M Y",  strtotime($r->docdate));
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A6', 'Sales Invoice List - ' . $docdate)
            ->setCellValue('A8', 'Invoice Date')
            ->setCellValue('B8', 'Invoice No')
            ->setCellValue('C8', 'PO')
            ->setCellValue('D8', 'Customer')
            ->setCellValue('E8', 'Shipment Date')
            ->setCellValue('F8', 'Terms (Days)')
            ->setCellValue('G8', 'GST')
            ->setCellValue('H8', 'Amount (USD)');

        $counter = 9;
        $total = 0;
        foreach ($data as $v) :
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, date("d-m-Y", strtotime($v->docdate)))
                ->setCellValue('B' . $counter, $v->invno)
                ->setCellValue('C' . $counter, $v->ponumber)
                ->setCellValue('D' . $counter, htmlspecialchars_decode($v->custcompany, ENT_QUOTES))
                ->setCellValue('E' . $counter, date("d-m-Y", strtotime($v->shipdate)))
                ->setCellValue('F' . $counter, $v->termdays)
                ->setCellValue('G' . $counter, $v->tax)
                ->setCellValue('H' . $counter, number_format($v->total * $v->rate, 2));
            $total = $total + $v->total * $v->rate;
            $counter++;
        endforeach;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H' . $counter, number_format($total, 2));

        $objPHPExcel->getActiveSheet()->getStyle('A8:H8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A8:H8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A8:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B8:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C8:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D8:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E8:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F8:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G8:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H8:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A9:B' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('E9:E' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->getActiveSheet()->getStyle('H9:H' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
            ->getActiveSheet()->getStyle('A' . $counter . ':H' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':H' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->getActiveSheet()->setTitle('Sales List');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales List ' . $docdate . '.xlsx"');
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

    // public function mon_total_sales_excel(){
    //     error_reporting(E_ALL);
    //     ini_set('display_errors', TRUE);
    //     ini_set('display_startup_errors', TRUE);
    //     date_default_timezone_set('Europe/London');

    //     $year=$this->input->get('year');

    //     $data =  $this->m_shipping_mon->tampil_total_sales($year);

    //     if (PHP_SAPI == 'cli')
    //         die('This example should only be run from a Web Browser');
    //     // require_once dirname(__FILE__) . '/../libraries/PHPExcel.php';
    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(10);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(15);
    //     $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(10);

    //     $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle(6)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle('A5:AO6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
    //             ->getActiveSheet()->freezePane('F7');

    //     $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A1', 'ZHENGHE LOGISTIC PTE LTD')
    //             ->setCellValue('A2', 'SALES')
    //             ->setCellValue('A3', 'JANUARI - DECEMBER '.$year)
    //             ->setCellValue('A5', 'PRODUCT')
    //             ->mergeCells('A5:A6')
    //             ->setCellValue('B5', 'UNIT')
    //             ->mergeCells('B5:B6')
    //             ->setCellValue('C5', 'TOTAL')
    //             ->mergeCells('C5:E5')
    //             ->setCellValue('F5', 'JAN')
    //             ->mergeCells('F5:H5')
    //             ->setCellValue('I5', 'FEB')
    //             ->mergeCells('I5:K5')
    //             ->setCellValue('L5', 'MAR')
    //             ->mergeCells('L5:N5')
    //             ->setCellValue('O5', 'APR')
    //             ->mergeCells('O5:Q5')
    //             ->setCellValue('R5', 'MAY')
    //             ->mergeCells('R5:T5')
    //             ->setCellValue('U5', 'JUN')
    //             ->mergeCells('U5:W5')
    //             ->setCellValue('X5', 'JUL')
    //             ->mergeCells('X5:Z5')
    //             ->setCellValue('AA5', 'AUG')
    //             ->mergeCells('AA5:AC5')
    //             ->setCellValue('AD5', 'SEP')
    //             ->mergeCells('AD5:AF5')
    //             ->setCellValue('AG5', 'OCT')
    //             ->mergeCells('AG5:AI5')
    //             ->setCellValue('AJ5', 'NOV')
    //             ->mergeCells('AJ5:AL5')
    //             ->setCellValue('AM5', 'DEC')
    //             ->mergeCells('AM5:AO5')
    //             ->setCellValue('C6', 'QTY')
    //             ->setCellValue('D6', 'US$')
    //             ->setCellValue('E6', '@')
    //             ->setCellValue('F6', 'QTY')
    //             ->setCellValue('G6', 'US$')
    //             ->setCellValue('H6', '@')
    //             ->setCellValue('I6', 'QTY')
    //             ->setCellValue('J6', 'US$')
    //             ->setCellValue('K6', '@')
    //             ->setCellValue('L6', 'QTY')
    //             ->setCellValue('M6', 'US$')
    //             ->setCellValue('N6', '@')
    //             ->setCellValue('O6', 'QTY')
    //             ->setCellValue('P6', 'US$')
    //             ->setCellValue('Q6', '@')
    //             ->setCellValue('R6', 'QTY')
    //             ->setCellValue('S6', 'US$')
    //             ->setCellValue('T6', '@')
    //             ->setCellValue('U6', 'QTY')
    //             ->setCellValue('V6', 'US$')
    //             ->setCellValue('W6', '@')
    //             ->setCellValue('X6', 'QTY')
    //             ->setCellValue('Y6', 'US$')
    //             ->setCellValue('Z6', '@')
    //             ->setCellValue('AA6', 'QTY')
    //             ->setCellValue('AB6', 'US$')
    //             ->setCellValue('AC6', '@')
    //             ->setCellValue('AD6', 'QTY')
    //             ->setCellValue('AE6', 'US$')
    //             ->setCellValue('AF6', '@')
    //             ->setCellValue('AG6', 'QTY')
    //             ->setCellValue('AH6', 'US$')
    //             ->setCellValue('AI6', '@')
    //             ->setCellValue('AJ6', 'QTY')
    //             ->setCellValue('AK6', 'US$')
    //             ->setCellValue('AL6', '@')
    //             ->setCellValue('AM6', 'QTY')
    //             ->setCellValue('AN6', 'US$')
    //             ->setCellValue('AO6', '@')
    //             ;

    //      $counter = 7;$us_tot=0;$us1=0;$us2=0;$us3=0;$us4=0;$us5=0;
    //      $us6=0;$us7=0;$us8=0;$us9=0;$us10=0;$us11=0;$us12=0;
    //      foreach($data as $r):
    //         $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A'.$counter, $r->tmp_product)
    //             ->setCellValue('B'.$counter, $r->tmp_unit)
    //             ->setCellValue('C'.$counter, ($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_qty_tot,0)))
    //             ->setCellValue('D'.$counter, ($r->tmp_us_tot == 0 ? '' : number_format($r->tmp_us_tot,2)))
    //             ->setCellValue('E'.$counter, ($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_us_tot/$r->tmp_qty_tot,2)))
    //             ->setCellValue('F'.$counter, ($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_qty1,0)))
    //             ->setCellValue('G'.$counter, ($r->tmp_us1 == 0 ? '' : number_format($r->tmp_us1,2)))
    //             ->setCellValue('H'.$counter, ($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_us1/$r->tmp_qty1,2)))
    //             ->setCellValue('I'.$counter, ($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_qty2,0)))
    //             ->setCellValue('J'.$counter, ($r->tmp_us2 == 0 ? '' : number_format($r->tmp_us2,2)))
    //             ->setCellValue('K'.$counter, ($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_us2/$r->tmp_qty2,2)))
    //             ->setCellValue('L'.$counter, ($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_qty3,0)))
    //             ->setCellValue('M'.$counter, ($r->tmp_us3 == 0 ? '' : number_format($r->tmp_us3,2)))
    //             ->setCellValue('N'.$counter, ($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_us3/$r->tmp_qty3,2)))
    //             ->setCellValue('O'.$counter, ($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_qty4,0)))
    //             ->setCellValue('P'.$counter, ($r->tmp_us4 == 0 ? '' : number_format($r->tmp_us4,2)))
    //             ->setCellValue('Q'.$counter, ($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_us4/$r->tmp_qty4,2)))
    //             ->setCellValue('R'.$counter, ($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_qty5,0)))
    //             ->setCellValue('S'.$counter, ($r->tmp_us5 == 0 ? '' : number_format($r->tmp_us5,2)))
    //             ->setCellValue('T'.$counter, ($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_us5/$r->tmp_qty5,2)))
    //             ->setCellValue('U'.$counter, ($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_qty6,0)))
    //             ->setCellValue('V'.$counter, ($r->tmp_us6 == 0 ? '' : number_format($r->tmp_us6,2)))
    //             ->setCellValue('W'.$counter, ($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_us6/$r->tmp_qty6,2)))
    //             ->setCellValue('X'.$counter, ($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_qty7,0)))
    //             ->setCellValue('Y'.$counter, ($r->tmp_us7 == 0 ? '' : number_format($r->tmp_us7,2)))
    //             ->setCellValue('Z'.$counter, ($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_us7/$r->tmp_qty7,2)))
    //             ->setCellValue('AA'.$counter, ($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_qty8,0)))
    //             ->setCellValue('AB'.$counter, ($r->tmp_us8 == 0 ? '' : number_format($r->tmp_us8,2)))
    //             ->setCellValue('AC'.$counter, ($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_us8/$r->tmp_qty8,2)))
    //             ->setCellValue('AD'.$counter, ($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_qty9,0)))
    //             ->setCellValue('AE'.$counter, ($r->tmp_us9 == 0 ? '' : number_format($r->tmp_us9,2)))
    //             ->setCellValue('AF'.$counter, ($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_us9/$r->tmp_qty9,2)))
    //             ->setCellValue('AG'.$counter, ($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_qty10,0)))
    //             ->setCellValue('AH'.$counter, ($r->tmp_us10 == 0 ? '' : number_format($r->tmp_us10,2)))
    //             ->setCellValue('AI'.$counter, ($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_us10/$r->tmp_qty10,2)))
    //             ->setCellValue('AJ'.$counter, ($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_qty11,0)))
    //             ->setCellValue('AK'.$counter, ($r->tmp_us11 == 0 ? '' : number_format($r->tmp_us11,2)))
    //             ->setCellValue('AL'.$counter, ($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_us11/$r->tmp_qty11,2)))
    //             ->setCellValue('AM'.$counter, ($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_qty12,0)))
    //             ->setCellValue('AN'.$counter, ($r->tmp_us12 == 0 ? '' : number_format($r->tmp_us12,2)))
    //             ->setCellValue('AO'.$counter, ($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_us12/$r->tmp_qty12,2)));
    //         $counter++;$us_tot +=$r->tmp_us_tot;$us1 +=$r->tmp_us1;$us2 +=$r->tmp_us2;$us3 +=$r->tmp_us3;$us4 +=$r->tmp_us4;$us5 +=$r->tmp_us5;
    //         $us6 +=$r->tmp_us6;$us7 +=$r->tmp_us7;$us8 +=$r->tmp_us8;$us9 +=$r->tmp_us9;$us10 +=$r->tmp_us10;$us11 +=$r->tmp_us11;$us12 +=$r->tmp_us12;
    //      endforeach;

    //      $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A'.$counter, 'GRAND TOTAL')
    //             ->setCellValue('D'.$counter, number_format($us_tot,2))
    //             ->setCellValue('G'.$counter, number_format($us1,2))
    //             ->setCellValue('J'.$counter, number_format($us2,2))
    //             ->setCellValue('M'.$counter, number_format($us3,2))
    //             ->setCellValue('P'.$counter, number_format($us4,2))
    //             ->setCellValue('S'.$counter, number_format($us5,2))
    //             ->setCellValue('V'.$counter, number_format($us6,2))
    //             ->setCellValue('Y'.$counter, number_format($us7,2))
    //             ->setCellValue('AB'.$counter, number_format($us8,2))
    //             ->setCellValue('AE'.$counter, number_format($us9,2))
    //             ->setCellValue('AH'.$counter, number_format($us10,2))
    //             ->setCellValue('AK'.$counter, number_format($us11,2))
    //             ->setCellValue('AN'.$counter, number_format($us12,2));

    //      $objPHPExcel->getActiveSheet()->getStyle($counter)->getFont()->setBold(true)
    //             ->getActiveSheet()->getStyle('A'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


    //     $objPHPExcel->getActiveSheet()->getStyle('A5:AO8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C5:AO5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A6:AO6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A5:A'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B5:B'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('C6:C'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('D6:D'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('E5:E'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('F6:F'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('G6:G'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('H5:H'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('I6:I'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('J6:J'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('K5:K'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('L6:L'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('M6:M'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('N5:N'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('O6:O'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('P6:P'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('Q5:Q'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('R6:R'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('S6:S'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('T5:T'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('U6:U'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('V6:V'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('W5:W'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('X6:X'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('Y6:Y'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('Z5:Z'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AA6:AA'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AB6:AB'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AC5:AC'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AD6:AD'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AE6:AE'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AF5:AF'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AG6:AG'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AH6:AH'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AI5:AI'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AJ6:AJ'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AK6:AK'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AL5:AL'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AM6:AM'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AN6:AN'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('AO5:AO'.$counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('B7:B'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
    //             ->getActiveSheet()->getStyle('C7:AO'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
    //             ->getActiveSheet()->getStyle('A'.$counter.':AO'.$counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
    //             ->getActiveSheet()->getStyle('A'.$counter.':AO'.$counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    //     $objPHPExcel->getActiveSheet()->setTitle('Sales');
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="Sales '.$year.'.xlsx"');
    //     header('Cache-Control: max-age=0');
    //     header('Cache-Control: max-age=1');
    //     header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    //     header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header ('Pragma: public'); // HTTP/1.0
    //     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //     $objWriter->save('php://output');
    //     exit;
    // }

    public function ToExcel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $tipe = $this->input->get('tipe');
        $shipdate = $this->input->get('ship');
        $factory = $this->input->get('tipe');

        if (trim($shipdate) != '') {
            $shipdate = $this->convert($this->input->get('ship'));
        }

        $data =  $this->m_shipping_mon->tampil_shipping_liner_filter($tipe, $shipdate, $factory);

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
        foreach ($data as $v) :
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $v->shipmentdate)
                ->setCellValue('C' . $counter, $v->factory_name)
                ->setCellValue('D' . $counter, $v->barge)
                ->setCellValue('E' . $counter, $v->to)
                ->setCellValue('F' . $counter, $v->from)
                ->setCellValue('G' . $counter, $v->po_number)
                ->setCellValue('H' . $counter, $v->shipping_liner)
                ->setCellValue('I' . $counter, $v->container_name)
                ->setCellValue('J' . $counter, $v->port_name . ' - ' . $v->destination)
                ->setCellValue('K' . $counter, $v->reff)
                ->setCellValue('L' . $counter, $v->vessel)
                ->setCellValue('M' . $counter, $v->depot)
                ->setCellValue('N' . $counter, $v->pod)
                ->setCellValue('O' . $counter, $v->opcode)
                ->setCellValue('P' . $counter, $v->etdsin)
                ->setCellValue('Q' . $counter, $v->container)
                ->setCellValue('R' . $counter, $v->seal)
                ->setCellValue('S' . $counter, $v->weight);
            $counter++;
        endforeach;

        $objPHPExcel->getActiveSheet()->setTitle('Container');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Container.xlsx"');
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

    public function shipping_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $from = $this->convert($this->input->get('from'));
        $to = $this->convert($this->input->get('to'));
        $cust = $this->input->get('cust');
        $invno = $this->input->get('inv');
        $mainpo = $this->input->get('po');
        $product = $this->input->get('product');

        $data_hasil =  $this->m_shipping_mon->print_inv_filter($from, $to, $cust, $invno, $mainpo, $product);

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
            ->setCellValue('A1', 'Date : ' . date("d/m/Y", strtotime($from)) . ' To ' . date("d/m/Y", strtotime($to)))
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
        foreach ($data_hasil as $v) :
            if ($v->currency == 'USD') {
                $amountusd = $v->total;
            } else {
                $amountusd = ' ';
            }
            if ($v->currency == 'USD') {
                $frtusd = $v->freight;
            } else {
                $frtusd = ' ';
            }
            if ($v->currency == 'USD') {
                $gstusd = $v->tax;
            } else {
                $gstusd = ' ';
            }
            if ($v->currency == 'USD') {
                $totalusd = $v->totaldue;
            } else {
                $totalusd = ' ';
            }

            if ($v->currency == 'SGD') {
                $amountsgd = $v->total;
            } else {
                $amountsgd = '-';
            }
            if ($v->currency == 'SGD') {
                $gstsgd = $v->gst;
            } else {
                $gstsgd = '-';
            }
            if ($v->currency == 'SGD') {
                $totalsgd = $v->totaldue;
            } else {
                $totalsgd = '-';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $v->docdate)
                ->setCellValue('B' . $counter, $v->invno)
                ->setCellValue('C' . $counter, $v->ponumber)
                ->setCellValue('D' . $counter, $v->custcompany)
                ->setCellValue('E' . $counter, $amountusd)
                ->setCellValue('F' . $counter, $frtusd)
                ->setCellValue('G' . $counter, $gstusd)
                ->setCellValue('H' . $counter, $totalusd)
                ->setCellValue('I' . $counter, $amountsgd)
                ->setCellValue('J' . $counter, $gstsgd)
                ->setCellValue('K' . $counter, $totalsgd);
            $counter++;
        endforeach;

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

        $objPHPExcel->getActiveSheet()->setTitle('Shipping Sales Invoice');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Shipping Sales Invoice ' . date("dmy") . '.xlsx"');
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

    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }

    //--------------------------------------------------------------------END---------------------------------------------------------------- 
    function lifting_volume()
    {
        $data['tahun'] =  $this->m_shipping_mon->get_year_lifting();
        $this->template->display('shipping/mon/mon_lifting_volume', $data);
    }

    function mon_lifting_volume_filter()
    {
        $tahun = $this->input->get('year');
        $cont = $this->input->get('cont');

        $data['total'] =  $this->m_shipping_mon->tampil_lifting_volume($tahun, $cont);
        $this->load->view('shipping/mon/mon_total_lifting_volume', $data);
    }

    function to_excel_lifting()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $tahun = $this->input->get('year');
        $cont = $this->input->get('cont');

        $data =  $this->m_shipping_mon->tampil_lifting_volume($tahun, $cont);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);

        $style_header = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e0e0e8'),
            ),
            'font' => array(
                'bold' => true,
            )
        );


        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('G2')->getFont()->setSize(18)
            ->getActiveSheet()->getStyle(3)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(4)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(5)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(7)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle(7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/ZHL-Report.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('E2');
        $objDrawing->setHeight(60);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A5', 'Year :')
            ->setCellValue('C5', $tahun)
            ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
            ->setCellValue('G4', 'Monitoring Lifting Volume')
            ->setCellValue('G5', 'Type Container : ' . $cont)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Shipping Liner')
            ->setCellValue('C7', 'Destination')
            ->setCellValue('D7', 'Total Amount (Year)')
            ->setCellValue('E7', 'January')
            ->setCellValue('F7', 'February')
            ->setCellValue('G7', 'March')
            ->setCellValue('H7', 'April')
            ->setCellValue('I7', 'May')
            ->setCellValue('J7', 'June')
            ->setCellValue('K7', 'July')
            ->setCellValue('L7', 'August')
            ->setCellValue('M7', 'September')
            ->setCellValue('N7', 'October')
            ->setCellValue('O7', 'November')
            ->setCellValue('P7', 'December');


        $no = 1;
        $counter = 8;
        foreach ($data as $v) {
            $tot1 = ($v->jan1) + ($v->feb1) + ($v->mar1) + ($v->apr1) + ($v->mei1) + ($v->jun1) + ($v->jul1) + ($v->ags1) + ($v->sep1) + ($v->okt1) + ($v->nov1) + ($v->dec1);
            if ($v->urut == '1') {
                $n = $no++;
                $ship = $v->shipping_liner;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->applyFromArray($style_header);
            } else {
                $n = '';
                $ship = '';
            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $n)
                ->setCellValue('B' . $counter, $ship)
                ->setCellValue('C' . $counter, $v->destination)
                ->setCellValue('D' . $counter, $tot1)
                ->setCellValue('E' . $counter, $v->jan1)
                ->setCellValue('F' . $counter, $v->feb1)
                ->setCellValue('G' . $counter, $v->mar1)
                ->setCellValue('H' . $counter, $v->apr1)
                ->setCellValue('I' . $counter, $v->mei1)
                ->setCellValue('J' . $counter, $v->jun1)
                ->setCellValue('K' . $counter, $v->jul1)
                ->setCellValue('L' . $counter, $v->ags1)
                ->setCellValue('M' . $counter, $v->sep1)
                ->setCellValue('N' . $counter, $v->okt1)
                ->setCellValue('O' . $counter, $v->nov1)
                ->setCellValue('P' . $counter, $v->dec1);

            $counter++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A7:P7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:P7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A7:A' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('B7:B' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('C7:C' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('D7:D' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('E7:E' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('F7:F' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('G7:G' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('H7:H' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('I7:I' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('J7:J' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('K7:K' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('L7:L' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('M7:M' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('N7:N' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('O7:O' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('P7:P' . $counter)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)

            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $counter++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $counter);

        $objPHPExcel->getActiveSheet()->setTitle('Container Inward');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lifting_Volume.xlsx"');
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

    // Tambahan 08 Desember 2019 oleh F.chan
    function lifting_volume_new()
    {
        $data['_cont'] = $this->m_shipping->gettype();
        $data['_fac'] = $this->m_shipping->tampil_factory();
        $this->template->display('shipping/mon/mon_lifting_volume_new', $data);
    }

    function mon_lifting_volume_filter_new()
    {
        $tahun = $this->input->get('year');
        $cont = $this->input->get('cont');
        $fact = $this->input->get('fact');

        $data['_total'] =  $this->m_shipping_mon->tampil_lifting_volume_new($tahun, $cont, $fact);
        $this->load->view('shipping/mon/mon_lifting_volume_new_ajax', $data);
    }
    function mon_total_sales_excel_new()
    {
        $this->load->library("excel/PHPExcel");
        $tahun  = $this->input->get('year');
        $cont   = $this->input->get('cont');
        $fact   = $this->input->get('fact');

        $data['tampil_cont'] = $this->m_shipping_mon->tampil_container($cont);
        $data['_total'] =  $this->m_shipping_mon->tampil_lifting_volume_new($tahun, $cont, $fact);
        $data['tahun']          = $tahun;
        $this->load->view('shipping/mon/mon_lifting_volume_excel', $data);
    }

    function barge_billing()
    {
        $data['_factory'] = $this->m_shipping->get_factory();
        $data['stuffing'] = $this->m_shipping->get_stuffing_rpt();
        $this->template->display('shipping/mon/mon_barge_billing', $data);
    }

    // function search_billing()
    // {

    //     $p_shipdate = date('Y-m-d', strtotime($this->input->get('shipdate')));
    //     $factory = $this->input->get('_factory');
    //     $type = $this->input->get('type');
    //     // print_r($type);
    //     // die;
    //     $data['_factory'] = $this->m_shipping->get_factory();
    //     if ($type == 1) {
    //         $data['_list'] = $this->m_shipping->tampil_sc_stuffing_filter($p_shipdate,  $factory);
    //     } else if ($type == 2) {
    //         $data['_list'] = $this->m_shipping->tampil_sc_stuffingtst($p_shipdate,  $factory);
    //     }
    //     $this->template->display('shipping/mon/mon_barge_billing', $data);
    // }

    function search_billing_arr()
    {
        //montly
        $dari = str_replace('/', '-', $this->input->post('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->post("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $data['awal'] = $p_dari;
        $data['akhir'] = $p_sampai;
        $data['dari_new'] = date('01-m-Y', strtotime($this->input->post('dari')));

        // print_r($this->input->post());
        // die;
        //shipment
        $p_shipdate = date('Y-m-d', strtotime($this->input->post('shipdate')));
        $factory = $this->input->post('factory');
        $type = $this->input->post('type');
        $jenis = $this->input->post('jenis');
        $invDetail = 0;
        $invmontly = 0;
        // print_r($p_sampai);
        // die;
        if ($jenis == 1) {
            $invDetail = $this->m_shipping->tampil_inv_where_detail_arr($p_shipdate, $factory);
        } else {
            $invmontly = $this->m_shipping->tampil_inv_where_detail_arr_montly($p_dari, $p_sampai, $factory);
        }

        $data['billingmonthly'] =  $invmontly['billingmonthly'];
        $data['localmonthly'] =  $invmontly['localmonthly'];
        $data['tetramonthly'] =  $invmontly['tetramonthly'];

        // print_r($invmontly['billingmonthly']);
        // die;

        $data['billing'] =  $invDetail['billing'];
        $data['local'] =  $invDetail['local'];
        $data['tetra'] =  $invDetail['tetra'];
        // $data['billinglocal'] =  $invDetail['billinglocal'];
        // print_r($data['billing']);
        //         die;
        if ($type) {
            $data['type'] = $type;
        } else {
            $data['type'] = '';
        }

        if ($factory) {
            $data['factory'] = $factory;
        } else {
            $data['factory'] = '';
        }

        if ($jenis) {
            $data['jenis'] = $jenis;
        } else {
            $data['jenis'] = '';
        }

        // print_r($data);
        // die;
        if ($jenis == 1) {
            $this->template->display('shipping/mon/mon_barge_billing', $data);
        } else {
            $this->template->display('shipping/mon/mon_barge_billingmonthly', $data);
        }
    }


    function selectbargebilling()
    {

        $contid = $this->input->get('contid');
        $type = $this->input->get('type');


        $data_bargebilling = $this->m_shipping->call_barge_billing($contid);
        $data['billing'] =  $data_bargebilling['billing'];
        $data['local'] =  $data_bargebilling['local'];
        $data['tetra'] =  $data_bargebilling['tetra'];

        // print_r($data_bargebilling);
        // die;
        // print_r($type);
        // die;
        if ($type == 1) {
            $this->load->view('shipping/mon/barge_billing', $data);
        } else if ($type == 2) {
            // print_r($data['local']);
            // die;
            $this->load->view('shipping/mon/barge_local', $data);
        } else {
            $this->load->view('shipping/mon/barge_tetra', $data);
        }
    }




    function excel_stuffing()
    {
        $p_shipdate = date('Y-m-d', strtotime($this->input->get('shipdate')));
        $factory = $this->input->get('factory');
        $type = $this->input->get('type');
        $invDetail = $this->m_shipping->tampil_inv_where_detail_arr($p_shipdate,  $factory);
        $data['hdr'] =  $invDetail['hdr'];
        $data['billing'] =  $invDetail['billing'];
        $data['local'] =  $invDetail['local'];
        $data['tetra'] =  $invDetail['tetra'];

        if ($type == 1) {
            $this->load->view('shipping/printout/barge_billing', $data);
        } else if ($type == 2) {

            $this->load->view('shipping/printout/local_billing', $data);
        } else {

            $this->load->view('shipping/printout/tetra_billing', $data);
        }
    }


    function excel_stuffingmonthly()
    {
        $dari = str_replace('/', '-', $this->input->get('dari'));
        $p_dari = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));
        $factory = $this->input->get('factory');
        $type = $this->input->get('type');

        $invmontly = $this->m_shipping->tampil_inv_where_detail_arr_montly($p_dari, $p_sampai, $factory);


        $data['hdr'] =  $invmontly['hdr'];
        $data['billingmonthly'] =  $invmontly['billingmonthly'];
        $data['localmonthly'] =  $invmontly['localmonthly'];
        $data['tetramonthly'] =  $invmontly['tetramonthly'];

        if ($type == 1) {
            //  print_r($invmontly);
            //             die;

            $this->load->view('shipping/printout/roundtripexport_monthly', $data);
        } else if ($type == 2) {

            $this->load->view('shipping/printout/localbilling_monthly', $data);
        } else {

            $this->load->view('shipping/printout/tetrabilling_monthly', $data);
        }
    }



    // Local Tracking Container

    function track_local_container()
    {

        $data['title'] = 'test';

        $this->template->display('shipping/mon/local_track_container', $data);

    }

    function filter_local_track_container()
    {
        $param = $this->input->get();
        $data = $this->m_shipping->getLocalContainerByParam($param);


        echo json_encode($data);
    }

    //--------------------------------------------------------------About Driver Job Monitoring-------------------------------------------
    function mon_summary_job()
    {
        $data['summary_job'] = $this->m_shipping->tampil_driver_job();
        $this->template->display('shipping/mon/mon_summary_job', $data);
    }

    function mon_driver_job_filter()
    {
        $currentdate = $this->input->get('current_date');
        if (trim($currentdate) != '') {
            $currentdate = $this->convert($this->input->get('current_date'));
        }

        $data['summary_job'] =  $this->m_shipping->tampil_summary_job_filter($currentdate);
        $this->load->view('shipping/mon/mon_summary_job_list', $data);
    }

    // End Local Tracking Container

    //--------------------------------------------------------------About DKSH Trucking Monitoring-------------------------------------------
    public function dksh_trucking()
    {
        // $data['SupplierID']     = $this->M_Receivable_recognition->get_sup();
        $data['List_trucking_dksh']   = $this->m_shipping->get_trucking();
        $data['title']          = "List of DKSH-Trucking";
        $data['message'] = $this->session->flashdata('message');

        $this->template->display('shipping/mon/dksh_trucking', $data);
    }

    function add_dksh_trucking()
    {

        $data= array(
            'message'                  => $this->session->flashdata('message'),
            'action'                   => site_url('Shipping_mon/save'),
            'readonly'                 => 'readonly',
            'disable'                  => '',
            'shipper'                  => '',
            'cnee'                     => '',
            'po_number'                => '',
            'pol'                      => '',
            'cont'                     => '',
            'house_bl'                 => '',
            'cont_type'                => '',
            'estd_time_arr'            => set_value('estd_time_arr', date('d/m/Y'), true),
            'actual_time_Arr'          => set_value('actual_time_Arr', date('d/m/Y'), true),
            'vessel_discharge_timing'  => '',
            'truck_in_to_yards_date'   => set_value('truck_in_to_yards_date', date('d/m/Y'), true),
            'truck_out_fm_yards_date'  => set_value('truck_out_fm_yards_date', date('d/m/Y'), true),
            'estd_detention_charges'   => '',
            'estd_detention_days'      => '',
            'remarks'                  => '',
            'submit_value'          => 'Save',
        );

        $this->template->display('shipping/mon/dksh_trucking_form', $data);
    }

    function save(){
        $data = $this->input->post(null, true);

        $createdby = strtoupper($this->session->userdata('userid_1'));
        $createddate = date('Y-m-d H:i:s');

        $data = [
            'shipper'                  => $data['shipper'],
            'cnee'                     => $data['cnee'],
            'po_number'                => $data['po_number'],
            'pol'                      => $data['pol'],
            'cont'                     => $data['cont'],
            'house_bl'                 => $data['house_bl'],
            'cont_type'                => $data['cont_type'],
            'estd_time_arr'            => convert_tgl_db_2($data['actual_time_Arr']),
            'actual_time_Arr'          => convert_tgl_db_2($data['actual_time_Arr']),
            'vessel_discharge_timing'  => $data['vessel_discharge_timing'],
            'truck_in_to_yards_date'   => convert_tgl_db_2($data['truck_in_to_yards_date']),
            'truck_out_fm_yards_date'  => convert_tgl_db_2($data['truck_out_fm_yards_date']),
            'estd_detention_charges'   => $data['estd_detention_charges'],
            'estd_detention_days'      => $data['estd_detention_days'],
            'remarks'                  => $data['remarks'],
            'createdby'                => $createdby,
            'createddate'              => $createddate
        ];
 

        $save_dtl = $this->m_shipping->save_trucking_dksh($data); 
        
        if (!$save_dtl) {
        $this->session->set_flashdata('message', pesan('Save DKSH Trucking Error', pesan_error()));
        } else {
        $this->session->set_flashdata('message', pesan('Save DKSH Trucking Success', pesan_sukses()));
        }
        redirect(site_url("Shipping_mon/add_dksh_trucking"));
        // redirect(site_url("Shipping_mon/Edit?id_sn_truck=$id"));
    }

    public function Edit()
    {
  
          $id = $this->input->get("id_sn_truck");
     
          $data_trucking = $this->m_shipping->get_id_truck($id);
  
        //   if (!$id) {
        //   redirect(site_url('Shipping_mon/add_dksh_trucking'));
        //   }

          if (!$id) {
            redirect(site_url('Shipping_mon/add_dksh_trucking'));
        }
  
        $data = [
          'message'                  => $this->session->flashdata('message'),
          'button'                   => '<i class="fa fa-save fa-3x fa-fw"></i> Update',
          'action'                   => site_url('Shipping_mon/Update/' . $id),
          'shipper'                  => set_value('shipper', $data_trucking->shipper, true),
          'cnee'                     => set_value('cnee', $data_trucking->cnee, true),
          'po_number'                => set_value('po_number', $data_trucking->po_number, true),
          'readonly'                 => 'readonly',
          'disable'                  => '',
          'submit_value'             => 'Update',
          'pol'                      => set_value('pol', $data_trucking->pol, true),
          'cont'                     => set_value('cont', $data_trucking->cont, true),
          'house_bl'                 => set_value('house_bl', $data_trucking->house_bl, true),
          'cont_type'                => set_value('cont_type', $data_trucking->cont_type, true),
          'estd_time_arr'            => set_value('estd_time_arr', convert_tgl_2($data_trucking->estd_time_arr), true),
          'actual_time_Arr'          => set_value('actual_time_Arr', convert_tgl_2($data_trucking->actual_time_Arr), true),
          'vessel_discharge_timing'  => set_value('vessel_discharge_timing', $data_trucking->vessel_discharge_timing, true),
          'truck_in_to_yards_date'   => set_value('truck_in_to_yards_date', convert_tgl_2($data_trucking->truck_in_to_yards_date), true),
          'truck_out_fm_yards_date'  => set_value('truck_out_fm_yards_date', convert_tgl_2($data_trucking->truck_out_fm_yards_date), true),
          'estd_detention_charges'   => set_value('estd_detention_charges', $data_trucking->estd_detention_charges, true),
          'estd_detention_days'      => set_value('estd_detention_days', $data_trucking->estd_detention_days, true),
          'remarks'                  => set_value('remarks', $data_trucking->remarks, true),
        ];
  
      $this->template->display('shipping/mon/dksh_trucking_form', $data);
    }

    public function Update($id)
    {
        $data = $this->input->post(null, true);
        $createdby = strtoupper($this->session->userdata('userid_1'));
        $createddate = date('Y-m-d H:i:s');

        $data = [
                'shipper'                  => $data['shipper'],
                'cnee'                     => $data['cnee'],
                'po_number'                => $data['po_number'],
                'pol'                      => $data['pol'],
                'cont'                     => $data['cont'],
                'house_bl'                 => $data['house_bl'],
                'cont_type'                => $data['cont_type'],
                'estd_time_arr'            => convert_tgl_db_2($data['actual_time_Arr']),
                'actual_time_Arr'          => convert_tgl_db_2($data['actual_time_Arr']),
                'vessel_discharge_timing'  => $data['vessel_discharge_timing'],
                'truck_in_to_yards_date'   => convert_tgl_db_2($data['truck_in_to_yards_date']),
                'truck_out_fm_yards_date'  => convert_tgl_db_2($data['truck_out_fm_yards_date']),
                'estd_detention_charges'   => $data['estd_detention_charges'],
                'estd_detention_days'      => $data['estd_detention_days'],
                'remarks'                  => $data['remarks'],
                'Updatedby'                => $createdby,
                'Updateddate'              => $createddate
        ];

        $this->m_shipping->update_trucking_dksh($data, $id);

            if (!empty($data)) {
                $save = $this->m_shipping->update_trucking_dksh($data);
            }

        $this->session->set_flashdata('message', pesan('Update DKSH TRUCKING', pesan_sukses()));
        redirect(site_url("Shipping_mon/Edit?id_sn_truck=$id"));

    }

    // function delete_dksh_trucking() {
    //     $id = $this->input->get("id_sn_truck");

    //     $delete_dtl = $this->m_shipping->delete_trucking($id);
    //     // $this->template->display('shipping/mon/dksh_trucking');
    //     if (!$delete_dtl) {
    //         $this->session->set_flashdata('message', pesan('Data failed to delete', pesan_error()));
    //     } else {
    //         $this->session->set_flashdata('message', pesan('Data Success tO delete', pesan_sukses()));
    //     }
    //     redirect('Shipping_mon/dksh_trucking');
    // }

    function delete_dksh_trucking() {
        $id = $this->input->get("id_sn_truck");
    
        $delete_dtl = $this->m_shipping->delete_trucking($id);
        
        if (!$delete_dtl) {
            $this->session->set_flashdata('message', pesan('Data Success to delete', pesan_sukses()));
        } else {
            $this->session->set_flashdata('message', pesan('Data Failed to delete', pesan_error()));
        }
        
        redirect('Shipping_mon/dksh_trucking');
    }    

    function search()
    {
        $po_number                  = $this->input->get("po_number");
        $data['List_trucking_dksh'] = $this->m_shipping->advance_list_dksh_trucking($po_number);
        $data['message'] = $this->session->flashdata('message');
        
        $this->template->display('shipping/mon/dksh_trucking', $data);
    }

    public function dksh_trucking_excel()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
    
        $page = $this->input->get('page') ? $this->input->get('page') : 1;

        $requested_limit = $this->input->get('limit');
        $limit = 10;
        
        if (!empty($requested_limit) && is_numeric($requested_limit)) {
            $limit = $requested_limit;
        }
        $offset = ($page - 1) * $limit;
    
        $data =  $this->m_shipping->tampil_excel_filter_dksh($limit, $offset);

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();

        $style1_c = array(
            'font'      => array(
                'bold' => TRUE,
                'name' => 'Calibri',
                'size' => '9',
                'color' => array('rgb' => '000000')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f9ca3b')
            )
        );

        $style = array(
            'font'      => array(
                'bold' => FALSE,
                'name' => 'Calibri',
                'size' => '9',
                'color' => array('rgb' => '000000')
            ),
        );

        function addAllBorders(PHPExcel_Worksheet $sheet, $startCell, $endCell)
        {
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000'),
                    ),
                ),
            );

            $sheet->getStyle($startCell . ':' . $endCell)->applyFromArray($styleArray);
        }
    
        // $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFont($style1_c);
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($style1_c);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
    
        $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('G2', 'ZHENGHE LOGISTIC PTE LTD')
            // ->setCellValue('G4', 'Monitoring Container Stock List')
            ->setCellValue('A1', 'No')
            // ->setCellValue('B1', 'ID S/N')
            ->setCellValue('B1', 'Shipper')
            ->setCellValue('C1', 'CNEE')
            ->setCellValue('D1', 'PO Number')
            ->setCellValue('E1', 'POL')
            ->setCellValue('F1', 'CONT#')
            ->setCellValue('G1', 'HOUSE B/L')
            ->setCellValue('H1', 'CONT TYPE')
            ->setCellValue('I1', 'ESTD TIME ARR')
            ->setCellValue('J1', 'ACTUAL TIME ARR')
            ->setCellValue('K1', 'VESSEL DISCHARGE TIMING')
            ->setCellValue('L1', 'TRUCK INTO YARDS DATE')
            ->setCellValue('M1', 'TRUCK OUT FM YARDS DATE')
            ->setCellValue('N1', 'ESTD DETENTION CHARGES')
            ->setCellValue('O1', 'ESTD DETENTION DAYS')
            ->setCellValue('P1', 'REMARK');
            
        $no = 1;
        $counter = 2;
        foreach ($data as $dksh_excel) {
            $objPHPExcel->getActiveSheet()->getStyle('A:P')->applyFromArray($style);
            
            $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $objPHPExcel->getActiveSheet()
            ->getStyle('A' . $counter . ':P' . $counter)
            ->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000'),
                    ),
                ),
            ));
            // Ini untuk border
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $dksh_excel->shipper)
                ->setCellValue('C' . $counter, $dksh_excel->cnee)
                ->setCellValue('D' . $counter, $dksh_excel->po_number)
                ->setCellValue('E' . $counter, $dksh_excel->pol)
                ->setCellValue('F' . $counter, $dksh_excel->cont)
                ->setCellValue('G' . $counter, $dksh_excel->house_bl)
                ->setCellValue('H' . $counter, $dksh_excel->cont_type)
                ->setCellValue('I' . $counter, $dksh_excel->estd_time_arr)
                ->setCellValue('J' . $counter, date_format(date_create($dksh_excel->actual_time_Arr), "d/m/Y"))
                ->setCellValue('K' . $counter, $dksh_excel->vessel_discharge_timing)
                ->setCellValue('L' . $counter, date_format(date_create($dksh_excel->truck_in_to_yards_date), "d/m/Y"))
                ->setCellValue('M' . $counter, date_format(date_create($dksh_excel->truck_out_fm_yards_date), "d/m/Y"))
                ->setCellValue('N' . $counter, "$ " . $dksh_excel->estd_detention_charges)
                ->setCellValue('O' . $counter, $dksh_excel->estd_detention_days)
                ->setCellValue('P' . $counter, $dksh_excel->remarks);
    
            // if ($v->status_note == '0') {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Ready');
            // } elseif ($v->status_note == '1') {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Has Been Used');
            // } elseif ($v->status_note == '2') {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Return to Singapore');
            // } elseif ($v->status_note == '3') {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $counter, 'Transfer From Stock Container');
            // }
    
            // if ($v->status_note == '0') {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, $count_down . ' Days');
            // } else {
            //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $counter, '  ');
            // }
    
            $counter++;
        }
        addAllBorders($objPHPExcel->getActiveSheet(), 'A1', 'P' . ($counter - 1));

    
        // Set style and format here if needed
    
        $objPHPExcel->getActiveSheet()->setTitle('DKSH TRUCKING');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DKSH_Trucking.xlsx"');
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
    
    public function dksh_trucking_excel_all(){
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
    
        $data =  $this->m_shipping->tampil_excel_all_dksh();

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $style1_c = array(
            'font'      => array(
                'bold' => TRUE,
                'name' => 'Calibri',
                'size' => '9',
                'color' => array('rgb' => '000000')
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f9ca3b')
            )
        );

        $style = array(
            'font'      => array(
                'bold' => FALSE,
                'name' => 'Calibri',
                'size' => '9',
                'color' => array('rgb' => '000000')
            ),
        );

        function addAllBorders(PHPExcel_Worksheet $sheet, $startCell, $endCell)
        {
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000'),
                    ),
                ),
            );

            $sheet->getStyle($startCell . ':' . $endCell)->applyFromArray($styleArray);
        }
    
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($style1_c);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
    
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Shipper')
            ->setCellValue('C1', 'CNEE')
            ->setCellValue('D1', 'PO Number')
            ->setCellValue('E1', 'POL')
            ->setCellValue('F1', 'CONT#')
            ->setCellValue('G1', 'HOUSE B/L')
            ->setCellValue('H1', 'CONT TYPE')
            ->setCellValue('I1', 'ESTD TIME ARR')
            ->setCellValue('J1', 'ACTUAL TIME ARR')
            ->setCellValue('K1', 'VESSEL DISCHARGE TIMING')
            ->setCellValue('L1', 'TRUCK INTO YARDS DATE')
            ->setCellValue('M1', 'TRUCK OUT FM YARDS DATE')
            ->setCellValue('N1', 'ESTD DETENTION CHARGES')
            ->setCellValue('O1', 'ESTD DETENTION DAYS')
            ->setCellValue('P1', 'REMARK');
            
        $no = 1;
        $counter = 2;
        foreach ($data as $dksh_excel) {
            $objPHPExcel->getActiveSheet()->getStyle('A:P')->applyFromArray($style);
            
            $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':P' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $objPHPExcel->getActiveSheet()
            ->getStyle('A' . $counter . ':P' . $counter)
            ->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000'),
                    ),
                ),
            ));
            // Ini untuk border
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $counter, $no++)
                ->setCellValue('B' . $counter, $dksh_excel->shipper)
                ->setCellValue('C' . $counter, $dksh_excel->cnee)
                ->setCellValue('D' . $counter, $dksh_excel->po_number)
                ->setCellValue('E' . $counter, $dksh_excel->pol)
                ->setCellValue('F' . $counter, $dksh_excel->cont)
                ->setCellValue('G' . $counter, $dksh_excel->house_bl)
                ->setCellValue('H' . $counter, $dksh_excel->cont_type)
                ->setCellValue('I' . $counter, $dksh_excel->estd_time_arr)
                ->setCellValue('J' . $counter, date_format(date_create($dksh_excel->actual_time_Arr), "d/m/Y"))
                ->setCellValue('K' . $counter, $dksh_excel->vessel_discharge_timing)
                ->setCellValue('L' . $counter, date_format(date_create($dksh_excel->truck_in_to_yards_date), "d/m/Y"))
                ->setCellValue('M' . $counter, date_format(date_create($dksh_excel->truck_out_fm_yards_date), "d/m/Y"))
                ->setCellValue('N' . $counter, "$ " . $dksh_excel->estd_detention_charges)
                ->setCellValue('O' . $counter, $dksh_excel->estd_detention_days)
                ->setCellValue('P' . $counter, $dksh_excel->remarks);

            $counter++;
        }
        addAllBorders($objPHPExcel->getActiveSheet(), 'A1', 'P' . ($counter - 1));
    
        $objPHPExcel->getActiveSheet()->setTitle('DKSH TRUCKING');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DKSH_Trucking.xlsx"');
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
    
    //==--------------------------------------------------------------END DKSH Trucking Monitoring-------------------------------------------
    //--------------------------------------------------------------About Container Chart Monitoring-------------------------------------------
    public function container_chart()
    {
        $shipmentdate = $this->input->get('shipmentdate');
        $factory = $this->input->get('factory_abbr');
        
        $data['cont_chart_inward'] = $this->m_shipping->chart_cont_inward($shipmentdate, $factory);
        $data['cont_chart_outward'] = $this->m_shipping->chart_cont_outward($shipmentdate, $factory);
        // $data['cont_chart_psg_inward'] = $this->m_shipping->chart_cont_psg_inward($shipmentdate);
        // $data['cont_chart_psg_outward'] = $this->m_shipping->chart_cont_psg_outward($shipmentdate);
        
        $this->template->display('shipping/mon/container_chart', $data);
        
    }
    // public function container_chart()
    // {
    //     $shipmentdate = $this->input->get('shipmentdate');
    //     // $tipe = $this->input->get('tipe');
    //     $data['cont_chart'] =  $this->m_shipping->chart_cont($shipmentdate);
    //     $this->template->display('shipping/mon/container_chart', $data);
        
    // }
    //==--------------------------------------------------------------END DKSH Trucking Monitoring-------------------------------------------

    function get_license_expired()
    {
      $data['tittle'] =  "Testing";
      $this->template->display('shipping/mon/expired_license', $data);
    }
    
    function expired_license_filter()
    {
        $coe_expiry = str_replace('/', '-', $this->input->get('coe_expiry_date'));
        $coe_expiry = date('Y-m-d', strtotime($coe_expiry));

        $lifespan_expiry = str_replace('/', '-', $this->input->get('lifespan_expiry_date'));
        $lifespan_expiry = date('Y-m-d', strtotime($lifespan_expiry));

        $vpc_expiry = str_replace('/', '-', $this->input->get('vpc_end_date'));
        $vpc_expiry = date('Y-m-d', strtotime($vpc_expiry));
        
        // var_dump($lifespan_expiry);
        // die;

        $data['license'] =  $this->m_shipping_mon->tampil_expired_license($coe_expiry, $lifespan_expiry, $vpc_expiry);
        $this->load->view('shipping/mon/mon_filter_expired_license', $data);
    }
}
