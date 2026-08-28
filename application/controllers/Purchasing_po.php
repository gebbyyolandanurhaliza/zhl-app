<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_po extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_purchasing_po'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library('Fpdf');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        // comment this if development mode is over
        //on_dev_page();
    }

    //    -----------------------------------------------------------------------ABOUT PO-----------------------------------------------------
    public function index()
    {
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['rate']    = $this->m_purchasing->tampil_po_rate('SGD', date("Y-m-d"));
        $data['whs']     = $this->m_purchasing->tampil_whs_pur('');
        $data['term']    = $this->m_purchasing->tampil_trade();
        $data['cust']    = $this->m_purchasing->tampil_cust_mar('');
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order', $data);
    }

    public function purchase_order_Show()
    {
        $data['po']      = $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['whs']     = $this->m_purchasing->tampil_whs_pur('');
        $data['term']    = $this->m_purchasing->tampil_trade();
        $data['cust']    = $this->m_purchasing->tampil_cust_mar('');


        $this->template->display('purchasing/purchase_order_show', $data);
    }

    public function purchase_order_vendor()
    {
        $data['supp'] =  $this->m_purchasing->tampil_vendor_pur($this->input->get('vendor'));
        $this->load->view('purchasing/purchase_order_filter_supp', $data);
    }

    public function purchase_order_supp()
    {
        $data['supp'] =  $this->m_purchasing->tampil_supp($this->input->get('vendor'));
        $this->load->view('purchasing/purchase_order_filter_supp', $data);
    }

    public function purchase_order_cust()
    {
        $data['cust'] =  $this->m_purchasing->tampil_cust_mar($this->input->get('cust'));
        $this->load->view('purchasing/purchase_order_filter_cust', $data);
    }

    public function purchase_order_rate()
    {
        $data['rate'] = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $this->load->view('purchasing/purchase_order_filter_rate', $data);
    }

    public function purchase_order_rate2()
    {
        $data['rate'] = $this->m_purchasing->tampil_po_rate($this->input->get('cur'), $this->convert($this->input->get('date')));
        $data['date2'] = $this->convert($this->input->get('date'));
        $data['date'] = date('Y/m', strtotime("-1 days", strtotime($this->convert($this->input->get('date')))));
        $data['newdate'] = date('Y/m', strtotime("-1 months", strtotime($this->convert($this->input->get('date')))));
        $this->load->view('purchasing/purchase_order_filter_rate2', $data);
    }

    public function purchase_order_npbb()
    {
        $cek    = $this->input->get('cek');
        $cust   = trim($this->input->get('cust'));
        $npbb   = $this->input->get('item');
        $vendor = $this->input->get('vendor');
        $cur    = $this->input->get('cur');

        $data['cek'] = $cek;

        if ($cek != 'true') {
            $data['npbb'] =  $this->m_purchasing_po->tampil_po_npbb($npbb);
        } else {
            $data['npbb'] =  $this->m_purchasing_po->tampil_po_item($npbb, $vendor, $cur);
        }

        $this->load->view('purchasing/purchase_order_filter_npbb', $data);
    }

    public function purchase_order_po()
    {
        $data['po'] =  $this->m_purchasing_po->tampil_po($this->input->get('po'));
        $this->load->view('purchasing/purchase_order_po_all', $data);
    }

    public function purchase_order_remark()
    {
        $data['po'] =  $this->m_purchasing_po->tampil_po_hdr($this->input->get('remark'));
        $this->load->view('purchasing/purchase_order_filter_remark', $data);
    }

    public function purchase_order_modal_delete()
    {
        $data['po'] =  $this->m_purchasing_po->tampil_po_where($this->input->get('delete'));
        $this->load->view('purchasing/purchase_order_filter_modal_delete', $data);
    }

    public function purchase_order_edit()
    {
        $data['po']      = $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['whs']     = $this->m_purchasing->tampil_whs('');
        $data['term']    = $this->m_purchasing->tampil_trade();
        $data['cust']    = $this->m_purchasing->tampil_cust('');
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order_show', $data);
    }

    public function purchase_order_edit_copy()
    {
        $data['po']      = $this->m_purchasing_po->tampil_po_where($this->input->get('po'));
        $data['rate']    = $this->m_purchasing->tampil_po_rate('SGD', date("Y-m-d"));
        $data['cur']     = $this->m_purchasing->tampil_cur();
        $data['whs']     = $this->m_purchasing->tampil_whs('');
        $data['term']    = $this->m_purchasing->tampil_trade();
        $data['cust']    = $this->m_purchasing->tampil_cust('');
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/purchase_order_show_copy', $data);
    }

    public function purchase_order_delete()
    {
        $result = $this->m_purchasing_po->delete_po_sp($this->input->get('po'), 0);

        if ($result['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_po/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>");
            redirect('purchasing_po/index');
        }
    }

    public function purchase_order_cancel()
    {
        $result = $this->m_purchasing_po->delete_po_sp($this->input->get('po'), 1);

        if ($result['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Cancel Data Success</div>");
            redirect('purchasing_po/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>");
            redirect('purchasing_po/index');
        }
    }

    public function purchase_order_save($trans)
    {
        // Header
        $vendor         = $this->input->post('vendor');
        $name           = $this->input->post('name');
        $contact        = $this->input->post('contact');
        $vendorref      = $this->input->post('vendorref');
        $cur            = $this->input->post('cur');
        $rate           = $this->input->post('rate');
        $status         = $this->input->post('status');
        $mainpo         = $this->input->post('mainpo');
        $postdate       = $this->convert($this->input->post('postdate'));
        $deliverdate    = $this->convert($this->input->post('deliverdate'));
        $docdate        = $this->convert($this->input->post('docdate'));
        $remark         = $this->input->post('remark');
        $remarks        = nl2br($this->input->post('remarks'));
        $totalbefore    = $this->input->post('totalbefore');
        $discount       = $this->input->post('totaldis');
        $freight        = $this->input->post('freight');
        $tax            = $this->input->post('tax');
        $totaldue       = $this->input->post('totaldue');
        $cust           = $this->input->post('cust');
        $custname       = $this->input->post('custname');
        $from           = $this->input->post('from');
        $to             = $this->input->post('to');
        $term           = $this->input->post('term');
        $whs            = $this->input->post('whs');
        $more           = $this->input->post('more');
        $include        = $this->input->post('include');
        $remark_country = $this->input->post('remark_country');

        $shipdateTemp = $this->input->post('shipdate');
        if ($shipdateTemp != '') {
            $shipdate = $this->convert($shipdateTemp);
        } else {
            $shipdate = '';
        }

        $arriveddate = '';

        $amendmentdateTemp = $this->input->post('amendmentdate');
        if ($amendmentdateTemp != '') {
            $amendmentdate = $this->convert($amendmentdateTemp);
        } else {
            $amendmentdate = '';
        }

        $datahdr = array(
            'trans'          => $trans,
            'mainpo'         => $mainpo,
            'vendorid'       => $vendor,
            'vendorcompany'  => $name,
            'vendorcontact'  => $contact,
            'vendorref'      => $vendorref,
            'currency'       => $cur,
            'rate'           => $rate,
            'status'         => $status,
            'postdate'       => $postdate,
            'deliverdate'    => $deliverdate,
            'docdate'        => $docdate,
            'remark'         => $remark,
            'remarks'        => $remarks,
            'total'          => $totalbefore,
            'discount'       => $discount,
            'freight'        => $freight,
            'tax'            => $tax,
            'totaldue'       => $totaldue,
            'custid'         => $cust,
            'custcompany'    => $custname,
            'shipdate'       => $shipdate,
            'custfrom'       => $from,
            'custto'         => $to,
            'arriveddate'    => $arriveddate,
            'amendmentdate'  => $amendmentdate,
            'tradeterm'      => $term,
            'whsid'          => $whs,
            'more'           => $more,
            'include'        => $include,
            'createdby'      => strtoupper($this->session->userdata('userid_1')),
            'remark_country' => $remark_country
        );

        $getPurchase = $this->db->get_where("zhl_pur_tbl_trn_po_hdr", ["mainpo" => $datahdr['mainpo']])->row();

        if ($getPurchase->pur_status != "IN") {
            $query = $this->m_purchasing_po->simpan_po_sp($datahdr);
        }


        if ($query) {
            if ($query['flag'] == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
                redirect('purchasing_po/purchase_order_show?po=' . $query['mainpo']);
            } else {
                $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
                redirect('purchasing_po/index');
            }
        } else {
            redirect('purchasing_po/purchase_order_show?status=400');
        }
    }

    public function purchase_order_print()
    {
        $mainpo = $this->input->get('po');
        $PO = $this->m_purchasing_po->tampil_po_where($mainpo);
        $data['_getPO'] = $PO;

        foreach ($PO as $r) {
            $vendorid = $r->vendorid;
            $whsid = $r->whsid;
            $country_id = $r->country_id;
        }

        if (!empty($country_id)) {
            $data['country'] = $this->m_purchasing->tampil_country_where($country_id);
        } else {
            $data['country'] = '';
        }

        $data['vendor'] = $this->m_purchasing->tampil_vendor_where($vendorid);
        $data['whs'] = $this->m_purchasing->tampil_whs_where($whsid);


        //        Versi FPDF
        //------------------------------------------------------------------------------       
        $this->load->view('purchasing/printout/purchase_order_fpdf', $data);
    }
    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }
    //--------------------------------------------------------------------END----------------------------------------------------------------


    /* ----------------------not use Code ------------------------------------------ */

    // Save Data
    // if ($trans == 'add') {

    // $main_po_num   = substr('0000' . $this->m_purchasing_po->get_max_mainpo_num($docdate)->max_mainpo_num, -4);
    // $year_main_po  = substr(date('Y', strtotime($docdate)), 2);
    // $month_main_po = date('m', strtotime($docdate));
    // $main_po = 'PSV' . $year_main_po . '-' . $month_main_po . '-' . $main_po_num;
    // $check = $this->m_purchasing_po->check_mainpo($main_po);

    // if (!$check) {
    //     echo "simpan data";
    // } else {
    //     echo "jangan simpan";
    // }
    // }
    // }

    //        if ($trans != 'update'){
    //            $getNo=  $this->m_purchasing_po->getDocNo_po($docdate);
    //            $getdoc='PSV/'.date("y",  strtotime($docdate)).'-'.date("m",  strtotime($docdate)).'-'.$getNo;
    //            $datahdr=array('mainpo'=>$getdoc,'vendorid'=>$vendor,'vendorcompany'=>$name,'vendorcontact'=>$contact,'vendorref'=>$vendorref,'currency'=>$cur,'rate'=>$rate,'status'=>$status,
    //                            'postdate'=>$postdate,'deliverdate'=>$deliverdate,'docdate'=>$docdate,'remark'=>$remark,'remarks'=>$remarks,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
    //                            'totaldue'=>$totaldue,'custid'=>$cust,'custcompany'=>$custname,'shipdate'=>$shipdate,'custfrom'=>$from,'custto'=>$to,'arriveddate'=>$arriveddate,'tradeterm'=>$term,'whsid'=>$whs,'more'=>$more,
    //                            'createdby'=> strtoupper($this->session->userdata('userid_1')),'createddate'=> date('Y-m-d H:i:s'));
    //            $query = $this->m_purchasing_po->simpan_po($datahdr);
    //            $message="Save Transaction Success";
    //        } else {
    //            $datahdr=array('currency'=>$cur,'rate'=>$rate,'status'=>$status,
    //                            'postdate'=>$postdate,'deliverdate'=>$deliverdate,'docdate'=>$docdate,'remark'=>$remark,'remarks'=>$remarks,'total'=>$totalbefore,'discount'=>$discount,'freight'=>$freight,'tax'=>$tax,
    //                            'totaldue'=>$totaldue,'custid'=>$cust,'shipdate'=>$shipdate,'custfrom'=>$from,'custto'=>$to,'arriveddate'=>$arriveddate,'tradeterm'=>$term,'whsid'=>$whs,'more'=>$more,
    //                            'lastupdatedby'=> strtoupper($this->session->userdata('userid_1')),'lastupdateddate'=> date('Y-m-d H:i:s'));
    //            $query = $this->m_purchasing_po->update_po($mainpo,$datahdr);
    //            $getdoc=$mainpo;
    //            $message="Update Transaction Success";
    //        }

    /* ----------------------not use Code ------------------------------------------ */
}
