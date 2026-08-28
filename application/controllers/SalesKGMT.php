<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD16 ( FCHAN )
 * Date   : 15/01/2018
 * Time   : 14:26
 */

class SalesKGMT extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        // is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->library(array('user_agent', 'Template','PHPExcel'));
        $this->load->model(array('M_Sales_KGMT'));
    }

    function index(){
    	$this->template->display("accounting/sales_report/index");
    }

    function CallData(){
    	$dari 		= str_replace('/', '-', $this->input->get('tanggal1'));
        $p_dari 	= date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("tanggal2"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        // $data['_Customer'] 	= $this->M_Sales_KGMT->getCust($p_dari,$p_sampai);
        // $data['_Product']	= $this->M_Sales_KGMT->getproduct($p_dari,$p_sampai);

        $data['_list'] = $this->M_Sales_KGMT->ambildata($p_dari,$p_sampai);

        $this->load->view('accounting/sales_report/ajax', $data);
        // echo $p_sampai.' '.$p_dari;
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

    function todia(){
    	for($i=1;$i<=32;$i=$i+2){
    		echo $this->getNameFromNumber($i)."3:".$this->getNameFromNumber($i+1)."3 ";
    	}
    }

    // function toExcel(){
    //     $dari       = str_replace('/', '-', $this->input->get('dari'));
    //     $p_dari     = date('Y-m-d', strtotime($dari));

    //     $sampai     = str_replace('/', '-', $this->input->get("sampai"));
    //     $p_sampai   = date('Y-m-d', strtotime($sampai));

    //     echo $dari.' '.$p_dari.' '.$sampai.' '.$p_sampai;
    // }

    function toExcel(){
    	error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        $dari 		= str_replace('/', '-', $this->input->get('dari'));
        $p_dari 	= date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("sampai"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $_list = $this->M_Sales_KGMT->ambildata($p_dari,$p_sampai);



        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getActiveSheet()->mergeCells("A3:A4");
        for($i=1;$i<=32;$i=$i+2){
    		 $objPHPExcel->getActiveSheet()->mergeCells($this->getNameFromNumber($i)."3:".$this->getNameFromNumber($i+1)."3");
    	}
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        for($i=1; $i<=32; $i++){
        	$objPHPExcel->getActiveSheet()->getColumnDimension($this->getNameFromNumber($i))->setWidth(15);
        	$objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($i).'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	$objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($i).'4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	$objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($i).'3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($i).'4')->getFont()->setBold(true);
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );      
        
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getstyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getstyle('A3')->getFont()->setBold(true);       

        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        for($i = 1; $i <= 32; $i++){
            $objPHPExcel->getActiveSheet()->getStyle($this->getNameFromNumber($i))->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');    
        }
        

        //Header
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1' , 'PULAU SAMBU SINGAPORE PTE LTD');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3' , 'CUstomer');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3' , 'UHT COCONUT CREAM');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3' , 'DESICATED COCONUT');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3' , 'CANNDED PINEAPPLES');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3' , 'PINEAPPLE JUICE CONCENTRATE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3' , 'PINEAPPLE SKIN');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3' , 'COCONUT WATER CONCENTRATE');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3' , 'COCONUT SHELL CHARCOAL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3' , 'CANNED COCONUT CREAM');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3' , 'COCONUT MILK POWDER');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3' , 'COCONUT WATER');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3' , 'COCONUT OIL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X3' , 'ACTIVATED CARBON');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z3' , 'VIRGIN COCONUT OIL');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB3' , 'UHT COCONUT MILK');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD3' , 'COCONUT MILK DRINK');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF3' , 'COCONUT SUGAR');

        for($i = 1; $i <= 32 ; $i=$i+2){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($i).'4' , 'KG');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($i+1).'4' , 'MT');
        }
        
        $row = 5;
        if(!empty($_list)){
            foreach ($_list as $r) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row , $r->custcompany);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row , $r->TKGUHT);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row , $r->TMTUHT);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row , $r->TKGDC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row , $r->TMTDC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row , $r->TKGCP);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row , $r->TMTCP);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row , $r->TKGPJC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row , $r->TMTPJC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row , $r->TKGPS);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row , $r->TMTPS);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$row , $r->TKGCWC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row , $r->TMTCWC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row , $r->TKGCSC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row , $r->TMTCSC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row , $r->TKGCCC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row , $r->TMTCCC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$row , $r->TKGCMP);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$row , $r->TMTCMP);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$row , $r->TKGCW);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$row , $r->TMTCW);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$row , $r->TKGCO);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$row , $r->TMTCO);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$row , $r->TKGAC);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$row , $r->TMTAC);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$row , $r->TKGVCO);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$row , $r->TMTVCO);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$row , $r->TKGUHTCM);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$row , $r->TMTUHTCM);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$row , $r->TKGCMD);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$row , $r->TMTCMD);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$row , $r->TKGCS);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$row , $r->TMTCS);

                $row++;
            }

            // $row++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row , 'TOTAL');
            $objPHPExcel->getActiveSheet()->getstyle('A'.$row)->getFont()->setBold(true);

            for($i = 1; $i <= 32 ; $i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->getNameFromNumber($i).$row , "=SUM(".$this->getNameFromNumber($i)."5:".$this->getNameFromNumber($i).($row-1).")");
                $objPHPExcel->getActiveSheet()->getstyle($this->getNameFromNumber($i).$row)->getFont()->setBold(true);
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('A3:AG'.$row)->applyFromArray($styleArray);
       

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

}