<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_inv extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_purchasing_inv', 'm_purchasing_so'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library('Fpdf');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    //---------------------------------------------------------------------About Invoice--------------------------------------------
    public function index()
    {
        $data['cur']  = $this->m_purchasing->tampil_cur();
        $data['whs']  = $this->m_purchasing->tampil_whs_pur('');
        $data['rate'] = $this->m_purchasing->tampil_po_rate('SGD', date("Y-m-d"));
        $this->template->display('purchasing/sales_invoice/sales_invoice', $data);
    }

    public function sales_invoice_show()
    {
        $data['inv']    = $this->m_purchasing_inv->tampil_inv_where($this->input->get('inv'));
        $data['inv_dp'] = $this->m_purchasing_inv->tampil_inv_where_dp($this->input->get('inv'));
        $data['cur']    = $this->m_purchasing->tampil_cur();
        $data['whs']    = $this->m_purchasing->tampil_whs('');
        $this->template->display('purchasing/sales_invoice/sales_invoice_show', $data);
    }

    public function sales_invoice_cust()
    {
        $data['cust'] =  $this->m_purchasing->tampil_cust_pur(trim($this->input->get('cust')));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_cust', $data);
    }

    //    public function sales_invoice_get_dp(){
    //        $data['dp']=  $this->m_purchasing_inv->tampil_inv_get_dp(str_replace(".p", "'",str_replace(".k", ",",$this->uri->segment(3))));
    //        $this->load->view('purchasing/sales_invoice_filter_dp',$data);
    //    }

    public function sales_invoice_get_dp_new()
    {
        $data['dp'] =  $this->m_purchasing_inv->tampil_inv_get_dp_new($this->input->get('cust'), $this->input->get('filter'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_dp_new', $data);
    }

    public function sales_invoice_po()
    {
        $data['po'] =  $this->m_purchasing_inv->tampil_inv_so($this->input->get('cust'), $this->input->get('sono'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_po', $data);
    }

    public function sales_invoice_inv()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv($this->input->get('inv'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_inv_all', $data);
    }

    public function sales_invoice_so()
    {
        $data['so'] =  $this->m_purchasing_inv->tampil_inv_so($this->input->get('cust'), $this->input->get('sono'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_so_all', $data);
    }
    public function sales_invoice_all(){
        $data['so']=  $this->m_purchasing_inv->tampil_inv_soall($this->input->get('sono'));
        // print_r($data);
        // die;
       $this->load->view('purchasing/sales_invoice/sales_invoice_so_all',$data);
    }

    public function sales_invoice_rate()
    {
        $data['rate'] = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_rate', $data);
    }

    public function sales_invoice_rate2()
    {
        $data['rate']   = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $data['date2']  = $this->convert($this->input->get('date'));
        $data['date']   = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
        $data['newdate']= date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_rate2', $data);
    }

    public function sales_invoice_modal_delete()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_where($this->input->get('delete'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_filter_modal_delete', $data);
    }

    //    public function sales_invoice_edit(){
    //        $data['inv']=  $this->m_purchasing_inv->tampil_inv_where(str_replace(".slash","/",$this->uri->segment(3)));
    //        $data['cur']=  $this->m_purchasing->tampil_cur();
    //        $this->template->display('purchasing/sales_invoice_show',$data);
    //    }

    public function sales_invoice_edit_copy()
    {
        $so = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['so']  = $so;
        $data['whs'] =  $this->m_purchasing->tampil_whs('');
        $data['cur'] =  $this->m_purchasing->tampil_cur();

        $mainpo = "";
        foreach ($so as $r) {
            if ($mainpo != "") {
                $mainpo = $mainpo . ",'" . $r->mainpo . "'";
            } else {
                $mainpo = "'" . $r->mainpo . "'";
            }
        }
        $dp = $this->m_purchasing_inv->tampil_inv_get_dp($mainpo);

        foreach ($dp as $x) {
            $dpayment = $x->uang_muka;
        }

        $data['dp'] = $dpayment;
        $this->template->display('purchasing/sales_invoice/sales_invoice_show_copy', $data);
    }

    public function sales_invoice_delete()
    {
        $result = $this->m_purchasing_inv->delete_inv_sp($this->input->get('inv'));

        if ($result['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_inv/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data error</div>");
            redirect('purchasing_inv/index');
        }
    }

    public function sales_invoice_save($trans)
    {
        $cust        = $this->input->post('cust');
        $name        = $this->input->post('name');
        $contact     = $this->input->post('contact');
        $custref     = $this->input->post('custref');
        $cur         = $this->input->post('cur');
        $rate        = $this->input->post('rate');
        $status      = $this->input->post('status');
        $gst         = $this->input->post('gst');
        $invoice     = $this->input->post('invno');
        $sono        = $this->input->post('sono');
        $postdate    = $this->convert($this->input->post('postdate'));
        $duedate     = $this->convert($this->input->post('duedate'));
        $docdate     = $this->convert($this->input->post('docdate'));
        $via         = $this->input->post('via');
        $remark      = $this->input->post('remark');
        $totalbefore = $this->input->post('totalbefore');
        $discount    = $this->input->post('totaldis');
        $freight     = $this->input->post('freight');
        $tax         = $this->input->post('taxcode');
        $totaldue    = $this->input->post('totaldue');
        $dp          = $this->input->post('dp');
        $balance     = $this->input->post('balance');
        $from        = '';
        $to          = '';
        $whs         = $this->input->post('whs');
        $shipdate    = $this->convert($this->input->post('shipdate'));
        $term        = $this->input->post('term');
        $day         = $this->input->post('day');
        $ipaddress   = $_SERVER['REMOTE_ADDR'];
        $include     = $this->input->post('include');

        $datahdr = array(
            'trans'       => $trans,
            'invno'       => $invoice,
            'sono'        => $sono,
            'custid'      => $cust,
            'custcompany' => $name,
            'custcontact' => $contact,
            'custref'     => $custref,
            'currency'    => $cur,
            'rate'        => $rate,
            'status'      => $status,
            'gst'         => $gst,
            'postdate'    => $postdate,
            'duedate'     => $duedate,
            'docdate'     => $docdate,
            'remark'      => $remark,
            'via'         => $via,
            'total'       => $totalbefore,
            'discount'    => $discount,
            'freight'     => $freight,
            'tax'         => $tax,
            'totaldue'    => $totaldue,
            'dp'          => $dp,
            'balance'     => $balance,
            'invfrom'     => $from,
            'invto'       => $to,
            'shipdate'    => $shipdate,
            'warehouse'   => $whs,
            'term'        => $term,
            'termdays'    => $day,
            'include'      => $include,
            'createdby'   => strtoupper($this->session->userdata('userid_1')),
            'ipaddress'   => $ipaddress
        );
        $query = $this->m_purchasing_inv->simpan_inv_sp($datahdr);

        // print_r($datahdr);
        // die;
        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('purchasing_inv/sales_invoice_show?inv=' . $query['invno']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('purchasing_inv/index');
        }
    }

    public function sales_invoice_direct()
    {
        $data['cur']  = $this->m_purchasing->tampil_cur();
        $data['rate'] = $this->m_purchasing->tampil_po_rate('SGD', date("Y-m-d"));
        $data['whs']  = $this->m_purchasing->tampil_whs('');
        $this->template->display('purchasing/sales_invoice/sales_invoice_direct', $data);
    }

    public function sales_invoice_direct_save($trans)
    {
        $cust        = $this->input->post('cust');
        $name        = $this->input->post('name');
        $contact     = $this->input->post('contact');
        $custref     = $this->input->post('custref');
        $cur         = $this->input->post('cur');
        $rate        = $this->input->post('rate');
        $status      = $this->input->post('status');
        $gst         = $this->input->post('gst');
        $invoice     = $this->input->post('invno');
        $sono        = "";
        $postdate    = $this->convert($this->input->post('postdate'));
        $duedate     = $this->convert($this->input->post('duedate'));
        $docdate     = $this->convert($this->input->post('docdate'));
        $via         = $this->input->post('via');
        $remark      = $this->input->post('remark');
        $totalbefore = $this->input->post('totalbefore');
        $discount    = $this->input->post('totaldis');
        $freight     = $this->input->post('freight');
        $tax         = $this->input->post('tax');
        $totaldue    = $this->input->post('totaldue');
        $from        = '';
        $to          = '';
        $whs         = $this->input->post('whs');
        $shipdate    = $this->convert($this->input->post('shipdate'));
        $term        = $this->input->post('term');
        $day         = $this->input->post('day');
        $ipaddress   = $_SERVER['REMOTE_ADDR'];

        $datahdr = array(
            'trans'       => $trans,
            'invno'       => $invoice,
            'sono'        => $sono,
            'custid'      => $cust,
            'custcompany' => $name,
            'custcontact' => $contact,
            'custref'     => $custref,
            'currency'    => $cur,
            'rate'        => $rate,
            'status'      => $status,
            'gst'         => $gst,
            'postdate'    => $postdate,
            'duedate'     => $duedate,
            'docdate'     => $docdate,
            'remark'      => $remark,
            'via'         => $via,
            'total'       => $totalbefore,
            'discount'    => $discount,
            'freight'     => $freight,
            'tax'         => $tax,
            'totaldue'    => $totaldue,
            'invfrom'     => $from,
            'invto'       => $to,
            'shipdate'    => $shipdate,
            'warehouse'   => $whs,
            'term'        => $term,
            'termdays'    => $day,
            'createdby'   => strtoupper($this->session->userdata('userid_1')),
            'ipaddress'   => $ipaddress
        );
        $query = $this->m_purchasing_inv->simpan_inv_direct_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('purchasing_inv/sales_invoice_direct_show?inv=' . $query['invno']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('purchasing_inv/sales_invoice_direct');
        }
    }

    public function sales_invoice_direct_modal_delete()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_where($this->input->get('delete'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_direct_filter_modal_delete', $data);
    }

    public function sales_invoice_direct_delete()
    {
        $result = $this->m_purchasing_inv->delete_inv_direct_sp($this->input->get('inv'));

        if ($result['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_inv/sales_invoice_direct');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data error</div>");
            redirect('purchasing_inv/sales_invoice_direct');
        }
    }

    public function sales_invoice_direct_edit()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_where($this->input->get('inv'));
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/sales_invoice/sales_invoice_direct_show', $data);
    }

    public function sales_invoice_direct_copy()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_where($this->input->get('inv'));
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/sales_invoice/sales_invoice_direct_show_copy', $data);
    }

    public function sales_invoice_direct_item()
    {
        $data['item'] =  $this->m_purchasing_inv->tampil_inv_direct_item($this->input->get('item'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_direct_filter_item', $data);
    }

    public function sales_invoice_direct_inv()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_direct($this->input->get('inv'));
        $this->load->view('purchasing/sales_invoice/sales_invoice_direct_inv_all', $data);
    }

    public function sales_invoice_direct_show()
    {
        $data['inv'] =  $this->m_purchasing_inv->tampil_inv_where($this->input->get('inv'));
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/sales_invoice/sales_invoice_direct_show', $data);
    }

    public function sales_invoice_print()
    {
        $invno = $this->input->get('inv');

        $inv = $this->m_purchasing_inv->tampil_inv_where($invno);
        $data['_getInv'] = $inv;

        foreach ($inv as $r) {
            $customer = $r->custid;
            $whsid = $r->whsid;
            $total = $r->totaldue;
        }

        $data['customer'] = $this->m_purchasing->tampil_cust_where($customer);
        $data['whs'] = $this->m_purchasing->tampil_whs_where($whsid);
        $data['terbilang'] =  $this->convert_number_to_words(number_format($total, 2, '.', ''));

        //        Versi FPDF
        //------------------------------------------------------------------------------       
        $this->load->view('purchasing/printout/sales_invoice_new_fpdf', $data);
        //------------------------------------------------------------------------------
        //        
        //        Versi HTML2PDF
        //------------------------------------------------------------------------------  
        //        ob_start(); 
        //        $this->load->view('purchasing/printout/sales_invoice_print', $data);
        //        $html   = ob_get_contents();
        //        ob_end_clean();
        //        
        //        require_once ('./assets/global/html2pdf/html2pdf.class.php');
        //        $pdf    = new HTML2PDF('P','A4','en');
        //        $pdf->writeHTML($html);
        //        $pdf->Output($invno.'.pdf');
        //------------------------------------------------------------------------------

    }

    public function sales_contract_print()
    {
        $invno = $this->input->get('inv');

        $inv = $this->m_purchasing_inv->tampil_inv_where($invno);
        $data['_getInv'] = $inv;

        foreach ($inv as $r) {
            $customer = $r->custid;
            $maintotal = $r->maintotal;
        }
        $data['nominal'] = $this->convert_number_to_words($maintotal);
        $data['customer'] = $this->m_purchasing->tampil_cust_where($customer);

        ob_start();
        $this->load->view('purchasing/printout/sales_contract_print', $data);
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/global/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('Sales_contract-' . date("m/d/Y") . '.pdf');
    }
    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        //$newdate = '2016-10-10';
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }

    public function convert_number_to_words($number)
    {
        $hyphen      = '-';
        $conjunction = ' ';
        $separator   = ' ';
        $negative    = 'negative ';
        $decimal     = ' and Cents ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'forty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = 'And ' . $dictionary[$tens];

                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[substr($hundreds, 0, 1)] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder, $dictionary);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder, $dictionary);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            //            $string .= $decimal;
            $stringdecimal = '';
            $words = array();

            $i = 0;
            $zerotemp = 0;
            $zero = 0;
            foreach (str_split((string) $fraction) as $number) {
                if ($i < 2) {
                    $zerotemp = $number;
                    $words[] = $number;

                    if ($zerotemp > 0) {
                        $zero = 1;
                    }
                }
                $i++;
            }
            $number = implode('', $words);

            if ($zero == 1) {
                switch (true) {
                    case $number < 21:
                        $stringdecimal = $decimal . $dictionary[number_format($number)];
                        break;
                    case $number < 100:
                        $tens2   = ((int) ($number / 10)) * 10;
                        $units2  = $number % 10;
                        $stringdecimal = $decimal . $dictionary[$tens2];
                        if ($units2) {
                            $stringdecimal .= $hyphen . $dictionary[$units2];
                        }
                        break;
                }

                $string =  str_replace('And ', '', $string);
            } else {
                $list =  explode('And', $string);
                $jml = count($list);

                for ($i = 1; $i <= $jml; $i++) {
                    if ($i == $jml) {
                        $list[$i - 1] = '' . $list[$i - 1];
                    }
                }

                $string = implode($list);
            }

            $string .= $stringdecimal . ' Only';
        }

        return $string;
    }

    //--------------------------------------------------------------------END----------------------------------------------------------------
}
