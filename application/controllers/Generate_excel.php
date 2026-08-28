<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Generate_excel extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
		$this->load->library('PHPExcel');
		
		$this->load->model(array('M_gen_master', 'M_mar_master', 'M_mar_product', 'M_factory', 
			'M_mar_sales_contract', 'M_mar_purchase_order', 'M_mar_sales_quotation', 'M_mar_misc', 'M_mar_sales_confirmation',
			'M_mar_shipping_instruction'
			));
		
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
	
	function sales_contract()
	{
		error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Asia/Singapore');
		
		$header_id	= decode_str($this->input->get('id'));
		
		$ex_head	= $this->M_mar_sales_contract->get_by_id($header_id);
		$ex_detail	= $this->M_mar_sales_contract->get_detail($header_id);
		$ex_document= $this->M_mar_sales_contract->get_view_document($header_id);
		$ex_agent	= $this->M_mar_sales_contract->get_agent_contract($header_id);
		
		if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
		
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getActiveSheet()->setShowGridlines(false);
		
		$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(83);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(1.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11.75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1.75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(1.5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6.75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(3.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14.8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(1.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4.75);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(5.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(2.35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(2.9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(1);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(1.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(2.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(3.2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(6.3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(1.2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(1.4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(1.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(1);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(2.4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(3.7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(1.5);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
		
		//untuk autosize height
		//$objWorksheet->getRowDimension('1')->setRowHeight(-1);
				
		$objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/pss-header.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setOffsetX(40);
        $objDrawing->setHeight(70);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
		$styleArrayDefault = array(
			'font'  => array(
				'size'	=> 10,
				'name'  => 'Tahoma'
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
			)
		);
			
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArrayDefault);
				
//		$objPHPExcel->getActiveSheet()->getStyle('U3:AH4')->applyFromArray($styleArrayFont);
		$contract_date = date('d M Y', strtotime($ex_head->contract_date));
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('u2', 'Sales Contract')
			->setCellValue('u3', 'Sales Contract No')
			->setCellValue('u4', 'Date')
			->setCellValue('ab3', ':')
			->setCellValue('ab4', ':')
			->setCellValue('ac3', $ex_head->contract_no)
			->setCellValue('ac4', $contract_date)
			->getStyle('U2:AC4')->getFont()->setBold(true);
		
		$styleArrayTitle = array(
			'font'  => array(
				'bold'  => true,
				'size'	=> 18,
				'name'  => 'Tahoma'
			));
		
		$objPHPExcel->getActiveSheet()->getStyle('U2')->applyFromArray($styleArrayTitle);
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B6', 'TO')
			->setCellValue('B7', $ex_head->customer_name)
			->setCellValue('B8', $ex_head->customer_address)->mergeCells('B8:M10')
			->getStyle('B6:B7')->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setWrapText(true);
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B12', 'Contact Person :')
			->setCellValue('G12', $ex_head->customer_contact_name)
			->getStyle('B12:G12')->getFont()->setBold(true);
		
		//added @30-08-2016 0:22
		$show_agent = 0;
		if (isset($ex_agent->agent_name)){	
			$rec_agent = $ex_agent->agent_name;
			
			if (strtoupper(trim($rec_agent)) == strtoupper(trim($ex_head->customer_company_name))){
				$show_agent = 0;
				//do nothing	
			} else {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('P6', 'AGENT')
					->setCellValue('P7', $ex_agent->agent_name)
					->setCellValue('P8', $ex_agent->agent_address)->mergeCells('P8:AG10')
					->setCellValue('P12', 'Attn : '.$ex_agent->agent_contact_name)
					->getStyle('P6:AG7')->getFont()->setBold(true);
				$objPHPExcel->setActiveSheetIndex(0)->getStyle('P12')->getFont()->setBold(true);
				$show_agent = 1;
			}
		} else {
			$show_agent = 0;
		}
		
//		if (isset($ex_agent->agent_name)){
//			$objPHPExcel->setActiveSheetIndex(0)
//				->setCellValue('P6', 'AGENT')
//				->setCellValue('P7', $ex_agent->agent_name)
//				->setCellValue('P8', $ex_agent->agent_address)->mergeCells('P8:AG10')
//				->getStyle('P6:AG7')->getFont()->setBold(true);
//		}
		
		$objPHPExcel->getActiveSheet()->getStyle('B13:AH13')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B14', 'Customer Ref No')->mergeCells('B14:D14')			
			->setCellValue('F14', ':')
			->setCellValue('G14', $ex_head->customer_reference)->mergeCells('G14:N14')			
			->setCellValue('P14', 'Partial Shipment')->mergeCells('P14:S14')
			->setCellValue('U14', ':')
			->setCellValue('V14', $ex_head->partial_shipment)->mergeCells('V14:AG14');
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B15', 'Trading Term')->mergeCells('B15:D15')			
			->setCellValue('F15', ':')
			->setCellValue('G15', $ex_head->trading_term_name)->mergeCells('G15:N15')
			->setCellValue('P15', 'Marine Insurance')->mergeCells('P15:S15')
			->setCellValue('U15', ':')
			->setCellValue('V15', $ex_head->marine_insurance)->mergeCells('V15:AG15');
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B16', 'Shipment From')->mergeCells('B16:D16')			
			->setCellValue('F16', ':')
			->setCellValue('G16', $ex_head->shipment_from)->mergeCells('G16:N16')
			->setCellValue('P16', 'Shipping Line')->mergeCells('P16:S16')
			->setCellValue('U16', ':')
			->setCellValue('V16', $ex_head->shipping_name)->mergeCells('V16:AG16');
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B17', 'Final Destination')->mergeCells('B17:D17')
			->setCellValue('F17', ':')
			->setCellValue('G17', $ex_head->port_name.', '.$ex_head->destination)->mergeCells('G17:N17')
			->setCellValue('P17', 'Shipment')->mergeCells('P17:S17')
			->setCellValue('U17', ':')
			->setCellValue('V17', $ex_head->shipment_schedule)->mergeCells('V17:AG17');
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B19', 'Container Loading')->mergeCells('B19:D19')
			->setCellValue('F19', ':')
			->setCellValue('G19', $ex_head->container_name)->mergeCells('G19:N19');
		
		if (isset($ex_agent->show_contract)){
			if (isset($ex_agent->com_percent)){
				$agent_commision = number_format($ex_agent->com_percent, 2, '.', ',').' %';
			} else {
				$agent_commision = $ex_agent->com_unit;
			}
			
			if ($ex_agent->com_percent == 0 && $ex_agent->com_unit == 0){
				$agent_commision = '';
			} else {
				if ($ex_agent->com_percent > 0){
					$agent_commision = number_format($ex_agent->com_percent, 2, '.', ','). ' %';
				}
				if ($ex_agent->com_unit > 0){
					$agent_commision = ': USD '.number_format($ex_agent->com_unit, 2, '.', ',').' per unit';
				}
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('P18', 'Agent Commission')->mergeCells('P18:T18')
				->setCellValue('U18', ':')
				->setCellValue('V18', $agent_commision)->mergeCells('V18:AG18');
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('P19', 'Agent Reference')->mergeCells('P19:S19')
				->setCellValue('U19', ':')
				->setCellValue('V19', $ex_agent->agent_reference)->mergeCells('V19:AG19');
		}
		
		//DETAIL PRODUCT
		$objPHPExcel->getActiveSheet()->getStyle('B20:AH20')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A21', '#')
			->setCellValue('C21', 'Product Description')->mergeCells('C21:I21')
			->setCellValue('J21', 'Brand')->mergeCells('J21:L21')
			->setCellValue('M21', 'Pack Size')->mergeCells('M21:N21')
			->setCellValue('P21', 'Quantity')->mergeCells('P21:Q21')
			->setCellValue('R21', 'FCL')->mergeCells('R21:S21')
			->setCellValue('U21', 'UOM')->mergeCells('U21:W21')
			->setCellValue('X21', 'Price')->mergeCells('X21:AB21')
			->setCellValue('AE21', 'Total(USD)')->mergeCells('AE21:AH21')
			->getStyle('A21:AH21')->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getStyle('A21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			->getActiveSheet()->getStyle('J21:U21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
			->getActiveSheet()->getStyle('X21:AH21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$i = 1;
		$lastrow = 23;
		foreach ($ex_detail as $baris){
//			$tampil_product = ($baris->product_view) ? $baris->product_view : $baris->product_name;	
			$tampil_product = ($baris->detail_product_desc) ? $baris->detail_product_desc : $baris->product_name;
//			$pack_size = number_format($baris->uom_volume,0).' '.$baris->uom_volume_name.' x '.number_format($baris->per_packing,0).' '.$baris->packing_size.' per '.$baris->cma_uom_quantity_id;
			$pack_size = $baris->detail_pack_size;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$lastrow, $i)
				->setCellValue('C'.$lastrow, $tampil_product)->mergeCells('C'.$lastrow.':I'.$lastrow)
				->setCellValue('J'.$lastrow, $baris->brand_name)->mergeCells('J'.$lastrow.':L'.$lastrow)
				->setCellValue('M'.$lastrow, $pack_size)->mergeCells('M'.$lastrow.':N'.$lastrow)
				->setCellValue('P'.$lastrow, $baris->quantity)->mergeCells('P'.$lastrow.':Q'.$lastrow)
				->setCellValue('R'.$lastrow, $baris->fcl)->mergeCells('R'.$lastrow.':S'.$lastrow)
				->setCellValue('U'.$lastrow, $baris->uom_quantity_name)->mergeCells('U'.$lastrow.':W'.$lastrow)
				->setCellValue('X'.$lastrow, $baris->price)->mergeCells('X'.$lastrow.':AB'.$lastrow)
				->setCellValue('AE'.$lastrow, $baris->total)->mergeCells('AE'.$lastrow.':AH'.$lastrow);
			
			$objPHPExcel->getActiveSheet()->getRowDimension($lastrow)->setRowHeight(25);
			
			$objPHPExcel->getActiveSheet()->getStyle('C'.$lastrow.':AH'.$lastrow)->getAlignment()->setWrapText(true)
				->getActiveSheet()->getStyle('C'.$lastrow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)
				->getActiveSheet()->getStyle('J'.$lastrow.':O'.$lastrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				->getActiveSheet()->getStyle('U'.$lastrow.':W'.$lastrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
				->getActiveSheet()->getStyle('P'.$lastrow.':R'.$lastrow)->getNumberFormat()->setFormatCode('#,##0.00')	// format number di quantity & fcl
				->getActiveSheet()->getStyle('X'.$lastrow.':AE'.$lastrow)->getNumberFormat()->setFormatCode('#,##0.00');
						
			$i++;
			$lastrow++;
		}
		
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('Y'.$lastrow, 'TOTAL')->mergeCells('Y'.$lastrow.':AB'.$lastrow)
			->setCellValue('AE'.$lastrow, $ex_head->grand_total)->mergeCells('AE'.$lastrow.':AH'.$lastrow)
			->getStyle('Y'.$lastrow.':AH'.$lastrow)->getFont()->setBold(true)
			->getActiveSheet()->getStyle('X'.$lastrow.':AE'.$lastrow)->getNumberFormat()->setFormatCode('#,##0.00');;
		
		$lastrow++;
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow.':AH'.$lastrow)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
		$lastrow++;		
		
		$gr_tot = floatval($ex_head->grand_total);
				
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Amount in Words :')->mergeCells('B'.$lastrow.':F'.$lastrow)
			->setCellValue('G'.$lastrow, $ex_head->currency_say_in_words.' '.convert_number_to_words($gr_tot).' only')->mergeCells('G'.$lastrow.':AH'.$lastrow)
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getRowDimension($lastrow)->setRowHeight(25);
		
		$lastrow++;		
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Payment Terms :')
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		$lastrow++;
		$payterm = ($ex_head->payment_term == null) ? $ex_head->payment_terms : $ex_head->payment_term;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow, html_entity_decode($payterm, ENT_QUOTES))->mergeCells('B'.$lastrow.':AH'.$lastrow);
		
		$lastrow++;
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Bank Details :')
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow, $ex_head->bank_currency_id.' account with '.$ex_head->bank_name)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow,'SWIFT : '.$ex_head->bank_swift.', USD Account: '.$ex_head->bank_account_number)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow,'SWIFT : '.$ex_head->bank_address)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		
		$lastrow++;
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Shelf Life :')
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow, $ex_head->product_shelf_life.' from date of production')->mergeCells('B'.$lastrow.':AH'.$lastrow);
		
		$lastrow++;
		$lastrow++;
		
		$doc_name = '';
		foreach ($ex_document as $doc){
			if ($doc_name == ''){
				$doc_name .= $doc->document_name;
			} else {
				$doc_name .= ', '.$doc->document_name;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Document Provided by Seller :')
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$lastrow, $doc_name)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		$objPHPExcel->getActiveSheet()->getRowDimension($lastrow)->setRowHeight(50);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow.':AH'.$lastrow)->getAlignment()->setWrapText(true);
		
		$lastrow++;
		$lastrow++;
		
		$default_remark = 'Please return one copy of the Sales Contract duly signed and endorsed with company stamp for our life.';
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Remarks :')
			->getStyle('B'.$lastrow)->getFont()->setBold(true);
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, $ex_head->remark)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		
		$objPHPExcel->getActiveSheet()->getRowDimension($lastrow)->setRowHeight(100);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow.':AH'.$lastrow)->getAlignment()
			->setWrapText(true)
			->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, $default_remark)->mergeCells('B'.$lastrow.':AH'.$lastrow);
		
		$lastrow++;
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Seller')
			->setCellValue('Q'.$lastrow, 'Buyer');
		$lastrow++;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Pulau Sambu Singapore Pte Ltd')
			->setCellValue('Q'.$lastrow, $ex_head->customer_name);
		
		$lastrow++;
		$lastrow++;
		$lastrow++;
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow.':L'.$lastrow)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
			->getActiveSheet()->getStyle('Q'.$lastrow.':AF'.$lastrow)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Mr Henry Fok (General Manager)')->mergeCells('B'.$lastrow.':L'.$lastrow)
			->setCellValue('Q'.$lastrow, $ex_head->customer_contact_name)->mergeCells('Q'.$lastrow.':AF'.$lastrow);
		$lastrow++;
		
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$lastrow, 'Date :')->mergeCells('B'.$lastrow.':L'.$lastrow)
			->setCellValue('Q'.$lastrow, 'Date :')->mergeCells('Q'.$lastrow.':AF'.$lastrow);
		$lastrow++;
		$lastrow++;
		
		if ($show_agent === 1){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('Q'.$lastrow, 'Agent')->mergeCells('Q'.$lastrow.':AF'.$lastrow);
			$lastrow++;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('Q'.$lastrow, $ex_agent->agent_name);
			$lastrow++;
			$lastrow++;
			$lastrow++;
			
			$objPHPExcel->getActiveSheet()->getStyle('Q'.$lastrow.':AF'.$lastrow)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$lastrow++;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('Q'.$lastrow, $ex_agent->agent_contact_name);
			$lastrow++;
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('Q'.$lastrow, 'Date :')->mergeCells('Q'.$lastrow.':AF'.$lastrow);
		}
		
		
		//Setting the print area
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:AH'.$lastrow);
		
		// Setup page margin		
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.4);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(1.1);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.4);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales Contract '.$ex_head->contract_no.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');		
        $objWriter->save('php://output');
		
//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//		$pdf = str_replace(".xlsx",".pdf",'test.xls');		
//		$objWriter->save($pdf);
        exit;
	}

	function purchase_order()
	{
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Asia/Singapore');

        $header_id	= decode_str($this->input->get('id'));
        $hdr		= $this->M_mar_purchase_order->get_by_id($header_id);
        $detail		= $this->M_mar_purchase_order->get_detail($header_id);
        $doc		= $this->M_mar_purchase_order->get_view_document($header_id);

        $contract_hdr_id = $this->M_mar_purchase_order->get_contract_hdr_id($header_id);
        $agent		= $this->M_mar_sales_contract->get_agent_contract($contract_hdr_id);


        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->setShowGridlines(false);

        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(83);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11.75);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1.75);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(1.5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6.75);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(1);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(1);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(3.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(14.8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(1.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(1);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(4.75);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(6.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(2.35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(2.9);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(1);

        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(1.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(2.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(3.2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(6.3);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(1.2);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(1.4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(1.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(1);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(1);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(2.4);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(3.7);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(1.5);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        //untuk autosize height
        //$objWorksheet->getRowDimension('1')->setRowHeight(-1);

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/pss-header.png';
        $objDrawing->setPath($logo);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setOffsetX(40);
        $objDrawing->setHeight(70);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $styleArrayDefault = array(
            'font'  => array(
                'size'	=> 10,
                'name'  => 'Tahoma'
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
            )
        );

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($styleArrayDefault);

//		$objPHPExcel->getActiveSheet()->getStyle('U3:AH4')->applyFromArray($styleArrayFont);
       // $contract_date = date('d M Y', strtotime($ex_head->contract_date));

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('r2', 'Date')
            ->setCellValue('r3', 'Page')
            ->setCellValue('v2', ':')
            ->setCellValue('v3', ':')
            ->setCellValue('w2', decode_str($_GET['dt']))
            ->setCellValue('w3', '1 OF 1')
            ->getStyle('r2:w3')->getFont()->setBold(true);

        $styleArraydate = array(
            'font'  => array(
                'bold'  => true,
                'size'	=> 10,
                'name'  => 'ARIAL'
            ));

        $objPHPExcel->getActiveSheet()->getStyle('U2')->applyFromArray($styleArraydate);

//
        $objPHPExcel->getActiveSheet()->mergeCells("A6:AD8");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('a6', 'PURCHASE ORDER - PSS')
        ;

        $styleArrayTitle = array(
            'font'  => array(
                'bold'  => true,
                'size'	=> 20,
                'name'  => 'TAHOMA'
            ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArrayTitle);

            for($row=10;$row<15;$row++)
            {
                $objPHPExcel->getActiveSheet()->mergeCells("B".$row.":"."F".$row);
                $objPHPExcel->getActiveSheet()->mergeCells("P".$row.":"."T".$row);
            }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('b10', 'PO No')
            ->setCellValue('b11', 'Customer')
            ->setCellValue('b12', 'Contract Date')
            ->setCellValue('b13', 'Contract')
            ->setCellValue('b14', 'Shipping Mark')
            ->setCellValue('g10', ':')
            ->setCellValue('g11', ':')
            ->setCellValue('g12', ':')
            ->setCellValue('g13', ':')
            ->setCellValue('g14', ':')
            ->setCellValue('h10', $hdr->po_number)
            ->setCellValue('h11', $hdr->customer_name)
            ->setCellValue('h12', tgl_ind($hdr->contract_date))
            ->setCellValue('h13', $hdr->contract_no)
            ->setCellValue('h14', $hdr->ship_mark)
            ;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('p10', 'Factory')
            ->setCellValue('p11', 'Buyer SI')
            ->setCellValue('p12', 'Final Destination')
            ->setCellValue('p13', 'Shipping Date')
            ->setCellValue('p14', 'Ocean Freight')
            ->setCellValue('u10', ':')
            ->setCellValue('u11', ':')
            ->setCellValue('u12', ':')
            ->setCellValue('u13', ':')
            ->setCellValue('u14', ':')
            ->setCellValue('v10', $hdr->factory_name)
            ->setCellValue('v11', $hdr->buyer_si)
            ->setCellValue('v12', $hdr->destination_country)
            ->setCellValue('v13', tgl_ind($hdr->ship_date))
            ->setCellValue('v14', $hdr->ocean_freight);

        $styleArraydetail = array(
            'font'  => array(
                'bold'  => false,
                'size'	=> 11,
                'name'  => 'Tahoma'
            ));


        $objPHPExcel->getActiveSheet()->getStyle('B10:V14')->applyFromArray($styleArraydetail);
        $objPHPExcel->getActiveSheet()->getStyle('h10')->getFont()->setBold(true);

        //remarks and certificate
        $objPHPExcel->getActiveSheet()->mergeCells("B16:F16");
        $objPHPExcel->getActiveSheet()->mergeCells("B24:F24");
        $objPHPExcel->getActiveSheet()->mergeCells("h16:r22");

        $doc_name = '';
        foreach ($doc as $docs){
            if ($doc_name == ''){
                $doc_name .= $docs->document_name;
            } else {
                $doc_name .= ', '.$docs->document_name;
            }
        }
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('b16', 'Remarks')
            ->setCellValue('b24', 'Certificate')
            ->setCellValue('g16', ':')
            ->setCellValue('g24', ':')
            ->setCellValue('h16', $hdr->remark)
            ->setCellValue('h24', $doc_name);
        
        //Setting the print area
        //$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:AH'.$lastrow);

        $objPHPExcel->getActiveSheet()->getStyle('b16:r24')->applyFromArray($styleArraydetail);
        $objPHPExcel->getActiveSheet()->getStyle('h16:r22')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('h16:r22')
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        //product
        $objPHPExcel->getActiveSheet()->getStyle('B26:AH26')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('b28', 'NO')
            ->setCellValue('c28', 'Product / Packing')->mergeCells('C28:J28')
            ->setCellValue('M28', 'Brand')
            ->setCellValue('P28', 'Qty')->mergeCells('P28:Q28')
            ->setCellValue('T28', 'Fcl')->mergeCells('T28:W28')
            ->setCellValue('Y28', 'Unit Value (USD)')->mergeCells('Y28:AH28')

        ;
        $objPHPExcel->getActiveSheet()->getStyle('b28:y28')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$i = 1;
		$lastrow = 29;
        $lastrow2 =30;
        $total_qty = 0;
		$total_fcl = 0;
		
		$product_code = '';
		$product_desc = '';
		$pack_size = '';
		$products = "$product_code\n$product_desc\n$pack_size";
		
        foreach ($detail as $r){

            $product_code = $r->product_code;
            $product_desc = ($r->product_view ? $r->product_view : $r->product_name);
			$pack_size = $r->detail_pack_size;
			if ($pack_size == ''){
				$pack_size = number_format($r->uom_volume,0).$r->uom_volume_name.' x '.number_format($r->per_packing,0).$r->packing_size.' per '.$r->cma_uom_quantity_id;
			}
			
			$products = "$product_code\n$product_desc\n$pack_size";
			
			//->setCellValue('C'.$lastrow2, $product_desc)->mergeCells('C'.$lastrow2.':J'.$lastrow2)

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$lastrow, $i)
                ->setCellValue('C'.$lastrow, $products)->mergeCells('C'.$lastrow.':J'.$lastrow)
                ->setCellValue('M'.$lastrow, $r->brand_name)
                ->setCellValue('P'.$lastrow, number_format($r->quantity,0,'.',','))->mergeCells('P'.$lastrow.':Q'.$lastrow)
                ->setCellValue('T'.$lastrow, number_format($r->fcl,2,'.',','))->mergeCells('T'.$lastrow.':W'.$lastrow)
                ->setCellValue('Y'.$lastrow, number_format($r->fob_price,2,'.',',').' per '.$r->cma_uom_quantity_id)->mergeCells('Y'.$lastrow.':AH'.$lastrow)
                ->getStyle('M'.$lastrow.':Y'.$lastrow) ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)

            ;

            $objPHPExcel->getActiveSheet()->getRowDimension($lastrow2)->setRowHeight(25);

            $objPHPExcel->getActiveSheet()->getStyle('C'.$lastrow2.':AH'.$lastrow2)->getAlignment()->setWrapText(true);
            $total_qty = floatval($total_qty) + floatval($r->quantity);
            $total_fcl = floatval($total_fcl) + floatval($r->fcl);

            $styleArrayprodHdr = array(
                'font'  => array(
                    'bold'  => True,
                    'size'	=> 11,
                    'name'  => 'Tahoma'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ));

            $styleArrayproddetail = array(
                'font'  => array(
                    'bold'  => false,
                    'size'	=> 11,
                    'name'  => 'Tahoma'
                ));


            $objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow.':Y'.$lastrow)->applyFromArray($styleArrayproddetail);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow2)->applyFromArray($styleArrayproddetail);
            $objPHPExcel->getActiveSheet()->getStyle('B28:Y28')->applyFromArray($styleArrayprodHdr);

            $i++;
            $lastrow++;
            $lastrow2++;
        }

        $lastrow++;
        $lastrow2++;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M'.$lastrow2, 'TOTAL :')
            ->setCellValue('P'.$lastrow2, $total_qty)->mergeCells('P'.$lastrow2.':Q'.$lastrow2)
            ->setCellValue('T'.$lastrow2, $total_fcl)->mergeCells('T'.$lastrow2.':W'.$lastrow2)
            ->setCellValue('Y'.$lastrow2, $hdr->container_name)->mergeCells('Y'.$lastrow2.':AH'.$lastrow2)
            ->getStyle('M'.$lastrow2.':W'.$lastrow2)->getFont()->setBold(true)
            ->getActiveSheet()->getStyle('P'.$lastrow2.':T'.$lastrow2)->getNumberFormat()->setFormatCode('#,##0.00');
		$lastrow2++;
        $objPHPExcel->getActiveSheet()->getStyle('B'.$lastrow2.':AH'.$lastrow2)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        //sign

        $rowsign=$lastrow2+2;
        $rowsign2=$lastrow2+7;


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$rowsign, 'For Pulau Sambu Singapore Pte Ltd')
			->setCellValue('B'.$rowsign2, 'Miss Hoa Poh Lin')
            ;
        $styleArraysign = array(
            'font'  => array(
                'bold'  => True,
                'size'	=> 11,
                'name'  => 'Tahoma'
            ));


        $objPHPExcel->getActiveSheet()->getStyle('B'.$rowsign.':B'.$rowsign2)->applyFromArray($styleArraysign);

        $rowsign2++;


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$rowsign2, 'Sales Management Manager');

             $styleArraysign2 = array(
                 'font'  => array(
                     'bold'  => false,
                     'size'	=> 11,
                     'name'  => 'Tahoma'
                 ));


        $objPHPExcel->getActiveSheet()->getStyle('B'.$rowsign2)->applyFromArray($styleArraysign2);

        // Setup page margin
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.4);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(1.1);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.4);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Purchase_Order_'.$hdr->po_number.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//		$pdf = str_replace(".xlsx",".pdf",'test.xls');
//		$objWriter->save($pdf);
        exit;
    }
	
	function marketing_po()
	{
		error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Asia/Singapore');
		
		$po_count	= count($this->input->post('chk_po'));
		$po_id		= $this->input->post('chk_po');

		$a = 0;
		$total_po = 0;
		$selected_po = array();
		
		if (!empty($po_id)){
			for($i=0; $i < $po_count; $i++){
				if (isset($po_id[$i])){
					array_push($selected_po, $po_id[$a]);	
					$a++;
					$total_po++;
				}
			}
		}
		
		$rec = $this->M_factory->get_selected_po($selected_po);
		
		$this->M_factory->update_selected_po($selected_po);
		
		$objPHPExcel = new PHPExcel();

        $objPHPExcel->getActiveSheet()->setShowGridlines(false);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(83);
		
		$arr_title = array(
			'No', 'PO Number', 'PO Date', 'SC Number', 'SC Date', 'Customer', 'Product Code', 'Product Desc', 'Brand', 'Product Category', 'Packing Size', 'Factory', 'Buyer SI', 'Shipping Mark', 'Shipping Date', 'Ocean Freight', 'Currency ID', 'Rate USD', 'Rate SGD'
			, 'Unit Price', 'FOB Price', 'Quantity', 'FCL', 'Total', 'Palletized', 'Pallet Qty', 'UOM Quantity', 'UOM Volume', 'UOM Volume Name'
			, 'Sodium Metabisulphite', 'PM Label Code', 'Label Qty', 'Long Side', 'Marking Long Side', 'Short Side', 'Marking Short Side', 'Carton Barcode', 'Carton Remark', 'Port Code', 'Port Name'
			, 'Destination Country', 'Country IDS', 'SM In Charge', 'Additional Documents', 'Remark'
			, 'PO Dtl ID', 'PO Hdr ID', 'Contract Hdr ID', 'Customer ID', 'Product ID', 'Produt Category ID', 'Brand ID', 'UOM Quantity ID', 'UOM Volume ID', 'Port ID/Destination ID', 'Container ID'
			, 'Packing List', 'C Of Analysis', 'C Phytosanitary', 'Can Code List', 'C of Origin', 'C Intermodal', 'C Manufactures', 'C Fumigation'
			, 'C Quality Quantity (P1)', 'C Health (Goverment)', 'C Health (Factory)', 'C Quality Quantity'			
		);
		
		for ($i=0; $i<count($arr_title); $i++){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($i).'1', $arr_title[$i]);
		}
		
		$arr_doc = array(1, 2, 3, 4, 10, 16, 22, 24, 29, 40, 54, 60);
		
		$lrow = 2;
		foreach ($rec as $r) {
			$i = 0;
			
			$doc		= $this->M_factory->document_by_po($r->po_hdr_id);
			$doc_list	= '';
			
			if ($doc){
				foreach($doc as $d){
					switch ($d->document_id) {
						case 1:
						case 2:
						case 3:
						case 4:
						case 10:
						case 16:
						case 22:
						case 24:
						case 29:
						case 40:
						case 54:						
						case 60:						
							break;

						default:
							if ($doc_list == ''){
								$doc_list = $d->document_name;
							} else {
								$doc_list .= ', '. $d->document_name;
							}
							break;
					}					
				}
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $lrow-1)				
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->po_number)
				->setCellValue($this->getNameFromNumber($i++).$lrow, tgl_ind($r->po_date))
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->contract_no)
				->setCellValue($this->getNameFromNumber($i++).$lrow, tgl_ind($r->contract_date))
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->customer_company_name)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->product_code)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->detail_product_name)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->brand_name)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->product_category_name)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->detail_pack_size)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->factory_abbr)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->buyer_si)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->ship_mark)
				->setCellValue($this->getNameFromNumber($i++).$lrow, tgl_ind($r->ship_date))
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->ocean_freight)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->currency_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->rate_usd)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->rate_sgd)
				->setCellValue($this->getNameFromNumber($i++).$lrow, number_format($r->price,2))
				->setCellValue($this->getNameFromNumber($i++).$lrow, number_format($r->fob_price, 2))
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->quantity)
				->setCellValue($this->getNameFromNumber($i++).$lrow, number_format($r->fcl,2))
				->setCellValue($this->getNameFromNumber($i++).$lrow, number_format($r->total,2))
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->detail_palletized)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->pallet_qty)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->uom_quantity_name)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->uom_volume)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->uom_volume_name)				
				
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->sodium_metabisulphite)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->pm_label_code)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->label_qty)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->long_side)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->marking_long_side)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->short_side)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->marking_short_side)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->carton_barcode)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->carton_remark)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->port_code)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->port_name)				
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->destination_country)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->country_ids)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->sales_marketing_id)
				
				->setCellValue($this->getNameFromNumber($i++).$lrow, $doc_list)				
				
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->remark)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->po_dtl_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->po_hdr_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->contract_hdr_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->customer_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->product_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->product_category_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->brand_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->uom_quantity_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->uom_volume_id)
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->destination_id)	// port id
				->setCellValue($this->getNameFromNumber($i++).$lrow, $r->container_id);
			
			if ($doc){
				for ($j=0; $j<count($arr_doc); $j++){
					$cell = $this->getNameFromNumber($i++).$lrow;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell, '0');		// default value = 0
					foreach ($doc as $d) {
						if ($d->document_id == $arr_doc[$j]){
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell, '1');
						}
					}
				}
			}
			
			$lrow++;
		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Factory_PO_List.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
	}
}
