<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_so extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_purchasing_so'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }
    //---------------------------------------------------------------------SO--------------------------------------------
    public function index()
    {
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['country'] = $this->m_purchasing->tampil_country();
        $data['rate']    = $this->m_purchasing->tampil_po_rate('SGD', date("Y-m-d"));
        $this->template->display('purchasing/sales_order', $data);
    }

    public function sales_order_show()
    {
        $data['so']      = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/sales_order_show', $data);
    }
    public function PI_show()
    {
        $so =  $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['so'] = $so;
        foreach ($so as $r) {
            $country_id = $r->country_id;
        }

        if (!empty($country_id)) {
            $data['country'] = $this->m_purchasing->tampil_country_where($country_id);
        } else {
            $data['country'] = '';
        }

        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/packing_do/add_packing_list', $data);
    }


    public function sales_order_cust()
    {
        $data['cust'] =  $this->m_purchasing->tampil_cust_mar(trim($this->input->get('cust')));
        $this->load->view('purchasing/sales_order_filter_cust', $data);
    }

    public function sales_order_po()
    {
        $data['po'] =  $this->m_purchasing_so->tampil_so_po($this->input->get('cust'), $this->input->get('po'));
        $this->load->view('purchasing/sales_order_filter_po', $data);
    }

    public function sales_order_gr()
    {
        $data['po'] =  $this->m_purchasing_so->tampil_so_gr(trim($this->input->get('item')));
        $this->load->view('purchasing/sales_order_filter_gr', $data);
    }

    public function sales_order_inv()
    {
        $data['so'] =  $this->m_purchasing_so->tampil_so($this->input->get('inv'));
        $this->load->view('purchasing/sales_order_inv_all', $data);
    }

    public function sales_order_rate()
    {
        $data['rate'] = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $this->load->view('purchasing/sales_order_filter_rate', $data);
    }

    public function sales_order_rate2()
    {
        $data['rate']    = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $data['date2']   = $this->convert($this->input->get('date'));
        $data['date']    = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
        $data['newdate'] = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
        $this->load->view('purchasing/sales_order_filter_rate2', $data);
    }

    public function sales_order_modal_delete()
    {
        $data['so'] =  $this->m_purchasing_so->tampil_so_where($this->input->get('delete'));
        $this->load->view('purchasing/sales_order_filter_modal_delete', $data);
    }

    public function sales_order_edit()
    {
        $data['so']      = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/sales_order_show', $data);
    }

    public function sales_order_delete()
    {
        $sono = $this->input->post('sono');
        $query = $this->m_purchasing_so->delete_so_sp($sono);


        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_so/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Transaction Broken.</div>");
            redirect('purchasing_so/index?sono=' . $sono);
        }



        // $param = $this->input->post();
        // $query = $this->m_purchasing_so->delete_so_sp($param);

        // // print_r($query);
        // // die;
        // // $query = $this->m_purchasing_so->delete_so_sp($this->input->get('sono'));

        // if ($query['flag'] == 1) {
        //     $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
        //     redirect('purchasing_so/index');
        // } else {


        //     $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Transaction Broken.</div>");
        //     redirect('purchasing_so/index?sono=' . $param);
        // }
    }

    public function sales_order_save($trans)
    {


        // echo "<pre>";
        // print_r($this->input->post());
        // die;
        $cust        = $this->input->post('cust');
        $name        = $this->input->post('name');
        $contact     = $this->input->post('contact');
        $custref     = $this->input->post('custref');
        $cur         = $this->input->post('cur');
        $rate        = $this->input->post('rate');
        $status      = $this->input->post('status');
        $sono        = $this->input->post('sono');
        $postdate    = $this->convert($this->input->post('postdate'));
        $duedate     = $this->convert($this->input->post('duedate'));
        $docdate     = $this->convert($this->input->post('docdate'));
        $via         = $this->input->post('via');
        $remark      = $this->input->post('remark');
        $totalbefore = $this->input->post('totalbefore');
        $discount    = $this->input->post('totaldis');
        $freight     = $this->input->post('freight');
        $tax         = $this->input->post('tax');
        $taxprice    = $this->input->post('taxprice');
        $totaldue    = $this->input->post('totaldue');
        $from        = '';
        $to          = '';
        $shipdate    = $this->convert($this->input->post('shipdate'));
        $term        = $this->input->post('term');
        $day         = $this->input->post('day');
        $country     = $this->input->post('country');
        $include     = $this->input->post('include');

        // echo $include;
        // die;


        $datahdr = array(
            'trans'       => $trans,
            'sono'        => $sono,
            'custid'      => $cust,
            'custcompany' => $name,
            'custcontact' => $contact,
            'custref'     => $custref,
            'currency'    => $cur,
            'rate'        => $rate,
            'status'      => $status,
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
            'sofrom'      => $from,
            'soto'        => $to,
            'shipdate'    => $shipdate,
            'term'        => $term,
            'termdays'    => $day,
            'createdby'   => strtoupper($this->session->userdata('userid_1')),
            'country_id' => $country,
            'taxprice'     => $taxprice,
            'include'      => $include
        );

        $query =  $this->m_purchasing_so->simpan_so_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('purchasing_so/sales_order_show?sono=' . $query['sono']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('purchasing_so/index');
        }

        //        if ($trans != 'update'){
        //            $getNo=  $this->m_purchasing_so->getDocNo_so($docdate);
        //            $getdoc='SO'.date("y",  strtotime($docdate)).'-'.date("m",  strtotime($docdate)).'-'.$getNo;
        //            $datahdr=array('sono'=>$getdoc,'custid'=>$cust,'custcompany'=>$name,'custcontact'=>$contact,'custref'=>$custref,'currency'=>$cur,'rate'=>$rate,'status'=>$status,
        //                            'postdate'=>$postdate,'duedate'=>$duedate,'docdate'=>$docdate,'remark'=>$remark,'via'=>$via,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
        //                            'totaldue'=>$totaldue,'sofrom'=>$from,'soto'=>$to,'shipdate'=>$shipdate,
        //                            'createdby'=> strtoupper($this->session->userdata('userid')),'createddate'=> date('Y-m-d H:i:s'));
        //            $query = $this->m_purchasing_so->simpan_so($datahdr);
        //            $message="Save Transaction Success";
        //        } else {
        //            $datahdr=array('currency'=>$cur,'rate'=>$rate,'status'=>$status,
        //                            'postdate'=>$postdate,'duedate'=>$duedate,'docdate'=>$docdate,'remark'=>$remark,'via'=>$via,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
        //                            'totaldue'=>$totaldue,'shipdate'=>$shipdate,'sofrom'=>$from,'soto'=>$to,'shipdate'=>$shipdate,
        //                            'lastupdatedby'=> strtoupper($this->session->userdata('userid')),'lastupdateddate'=> date('Y-m-d H:i:s'));
        //            $query = $this->m_purchasing_so->update_so($sono,$datahdr);
        //            $getdoc=$sono;
        //            $message="Update Transaction Success";
        //        }
    }

    public function sales_order_print()
    {
        $sono = $this->input->get('sono');
        $sono = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['_getSO'] = $sono;
        foreach ($sono as $r) {
            $custid     = $r->custid;
            $whsid      = $r->whsid;
            $country_id = $r->country_id;
        }
        if (!empty($country_id)) {
            $data['country'] = $this->m_purchasing->tampil_country_where($country_id);
        } else {
            $data['country'] = '';
        }

        $data['cust'] = $this->m_purchasing->tampil_cust_where($custid);
        $data['cur']  = $this->m_purchasing->tampil_cur();
        $data['whs']  = $this->m_purchasing->tampil_whs_where($whsid);

        $this->load->view('purchasing/printout/sales_order_fpdf', $data);
    }


    public function proforma_invoice_print()
    {
        $sono = $this->input->get('sono');
        $sono = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['_getSO'] = $sono;
        foreach ($sono as $r) {
            $custid     = $r->custid;
            $whsid      = $r->whsid;
            $country_id = $r->country_id;
        }
        if (!empty($country_id)) {
            $data['country'] = $this->m_purchasing->tampil_country_where($country_id);
        } else {
            $data['country'] = '';
        }

        $data['cust'] = $this->m_purchasing->tampil_cust_where($custid);
        $data['cur']  = $this->m_purchasing->tampil_cur();
        $data['whs']  = $this->m_purchasing->tampil_whs_where($whsid);

        $this->load->view('purchasing/printout/proforma_invoice_fpdf', $data);
    }

    function print_report_pl()
    {
        $packdo         = $this->m_purchasing_so->tampil_so_where($this->input->get('sono'));
        $data['packdo'] = $packdo;
        $this->load->view('purchasing/packing_list/rpt_packing_list', $data);
    }
    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }

    public function convert_number_to_words($number)
    {

        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
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
            40                  => 'fourty',
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
                $string = $dictionary[$tens];
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
            $string .= $decimal;
            $words = array();

            $i = 0;
            foreach (str_split((string) $fraction) as $number) {
                if ($i < 2) {
                    $words[] = $dictionary[$number];
                }
                $i++;
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    //--------------------------------------------------------------------END----------------------------------------------------------------
}
