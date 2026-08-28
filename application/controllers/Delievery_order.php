<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Delivery_order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'M_delievery_order', 'm_purchasing_so'));
        $this->load->library('PHPExcel');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index()
    {
        $data['_factory'] = $this->M_packing_do->get_factory();
        $this->template->display('purchasing/packing_do/packing_list', $data);
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

    public function show_pl()
    {
        $so =  $this->M_packing_do->tampil_pl_where($this->input->get('pl'));
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
        $this->template->display('purchasing/packing_do/edit_packing_list', $data);
    }

    public function simpan_pl($trans)
    {
        $pl_no       = strtoupper($this->input->post('sono'));
        $packing     = $this->input->post('packing');
        $totalpack   = $this->input->post('ttlpack');
        $via         = $this->input->post('via');
        $shipdate_pl = $this->convert($this->input->post('shipdate'));

        $datahdr = array(
            'pl_no'       => $pl_no,
            'packing'     => $packing,
            'totalpack'   => $totalpack,
            'shipdate_pl' => $shipdate_pl,
            'via'         => $via,
            'createdby'   => strtoupper($this->session->userdata('userid_1')),
            'createddate' => date('Y-m-d H: i: s')
        );

        $query =  $this->M_packing_do->simpan_pl_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('Packing_do/show_pl?pl=' . $pl_no);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('Packing_do/index');
        }
    }

    function edit()
    {
        $data['packdo']   = $this->M_packing_do->tampil_packdo_where($this->input->get('noreff'));
        $data['_factory'] = $this->M_packing_do->get_factory();
        $this->template->display('purchasing/packing_do/edit_packingdo', $data);
    }

    function remove_packdo()
    {
        $id      = $this->input->get('id');
        $noreff  = $this->input->get('noreff');
        $query   = $this->M_packing_do->delete_detail_do($id);
        $message = "delete success";
        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('Packing_Do/edit?noreff=' . $noreff);
    }

    function print_report_pl()
    {
        $packdo         = $this->M_packing_do->tampil_pl_where($this->input->get('pl'));
        $data['packdo'] = $packdo;
        $this->load->view('purchasing/packing_do/rpt_packing_list', $data);
    }

    public function tampil_gr()
    {
        $data['_datagr'] = $this->M_packing_do->get_gr($this->input->get('cust'), $this->input->get('po'));
        $this->load->view('purchasing/packing_do/data_gr_ajax', $data);
    }

    public function sales_order_inv()
    {
        $data['so'] =  $this->m_purchasing_so->tampil_so($this->input->get('inv'));
        $this->load->view('purchasing/packing_do/sales_order_inv_all', $data);
    }

    function tampil_gr_do()
    {
        $factory         = $this->input->get('fac');
        $data['_datagr'] = $this->M_packing_do->get_gr_do($factory);
        $this->load->view('purchasing/packing_do/data_gr_ajax_do', $data);
    }

    public function filter_do()
    {
        $data['packdo']   = $this->M_packing_do->tampil_pack_list($this->input->get('po'));
        $data['_factory'] = $this->M_packing_do->get_factory();
        $this->load->view('purchasing/packing_do/packing_do_all', $data);
    }

    public function filter_pl()
    {
        $data['so'] =  $this->M_packing_do->tampil_pl_all($this->input->get('inv'));
        $this->load->view('purchasing/packing_do/packing_list_all', $data);
    }

    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }

    function mon_packdo()
    {
        $this->template->display('purchasing/packing_do/packingdo_mon');
    }

    function mon_packdo_filter()
    {
        $dari       = str_replace('/', '-', $this->input->get('from'));
        $p_dari     = date('Y-m-d', strtotime($dari));
        $sampai     = str_replace('/', '-', $this->input->get("to"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $mainpo = $this->input->get('po');
        $npbb   = $this->input->get('npbb');
        $item   = $this->input->get('item');
        $status = $this->input->get('status');

        $data['_list'] = $this->M_packing_do->tampil_packdo_filter($p_dari, $p_sampai, $mainpo, $item, $npbb, $status);
        $this->load->view('purchasing/packing_do/ajax_packingdo_mon', $data);
    }

    public function pack_do_excel()
    {
        $this->load->library("excel/PHPExcel");
        $dari       = str_replace('/', '-', $this->input->get('from'));
        $p_dari     = date('Y-m-d', strtotime($dari));

        $sampai     = str_replace('/', '-', $this->input->get("to"));
        $p_sampai   = date('Y-m-d', strtotime($sampai));

        $mainpo = $this->input->get('po');
        $npbb   = $this->input->get('npbb');
        $item   = $this->input->get('item');
        $status = $this->input->get('status');

        $data['record'] = $this->M_packing_do->tampil_packdo_filter($p_dari, $p_sampai, $mainpo, $item, $npbb, $status);
        $this->load->view('purchasing/packing_do/toexcel_warehouse', $data);
    }

    public function packing_list_delete()
    {
        $this->M_packing_do->delete_packing_list($this->input->get('pl'));
        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
        redirect('Packing_do/index');
    }

    public function remove_packing_list()
    {
        $data['pl'] =  $this->M_packing_do->tampil_pl_where($this->input->get('delete'));
        $this->load->view('purchasing/packing_do/packing_list_filter_modal_delete', $data);
    }

    public function add_loading_report()
    {
        $data['_factory'] = $this->M_packing_do->get_factory();
        $this->template->display('purchasing/packing_do/add_loading_report', $data);
    }

    public function sales_order_cust()
    {
        $data['cust'] =  $this->m_purchasing->tampil_cust(trim($this->input->get('cust')));
        $this->load->view('purchasing/sales_order_filter_cust', $data);
    }

    public function loading_report_po()
    {
        $data['po'] =  $this->M_packing_do->tampil_gr_po($this->input->get('cust'), $this->input->get('po'));
        $this->load->view('purchasing/packing_do/good_receipt_filter_po', $data);
    }

    public function save_lr($trans)
    {
        $lrno       = $this->input->post('lrno');
        $shpd       = $this->input->post('shipdate');
        $cust       = $this->input->post('cust');
        $docdate    = $this->convert($this->input->post('docdate'));
        $shipdate   = date('Y-m-d', strtotime($shpd));
        $remark     = $this->input->post('remark');
        $via        = $this->input->post('via');
        $total_pack = $this->input->post('ttlpack');

        $datahdr = array(
            'trans'      => $trans,
            'lrno'       => $lrno,
            'custid'     => $cust,
            'remark'     => $remark,
            'via'        => $via,
            'docdate'    => $docdate,
            'shipdate'   => $shipdate,
            'total_pack' => $total_pack,
            'createdby'  => strtoupper($this->session->userdata('userid_1'))
        );

        $query =  $this->M_packing_do->simpan_lr_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('Packing_do/loading_report_show?lr=' . $query['lrno']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('Packing_do/add_loading_report');
        }
    }

    public function loading_report_show()
    {
        $data['lr'] =  $this->M_packing_do->tampil_lr_where($this->input->get('lr'));
        $this->template->display('purchasing/packing_do/edit_loading_report', $data);
    }

    public function loading_report_inv()
    {
        $data['lr'] =  $this->M_packing_do->tampil_lr_all($this->input->get('inv'));
        $this->load->view('purchasing/packing_do/loading_report_all', $data);
    }

    public function print_report_lr()
    {
        $lr = $this->M_packing_do->tampil_lr_where($this->input->get('lr'));
        $data['lr'] = $lr;
        $this->load->view('purchasing/packing_do/rpt_loading_report', $data);
    }

    public function loading_report_delete()
    {
        $this->M_packing_do->delete_loading_report($this->input->get('lr'), 0);
        redirect('Packing_do/add_loading_report');
    }

    public function loading_report_delete_item_dp()
    {
        $lr = $this->input->get('lrno');
        $this->M_packing_do->loading_report_delete_item_dp($this->input->get('itemid'), 0);
        redirect('Packing_do/loading_report_show?lr=' . $lr);
    }

    public function remove_loading_report()
    {
        $data['lr'] =  $this->M_packing_do->tampil_lr_where($this->input->get('delete'));
        $this->load->view('purchasing/packing_do/loading_report_filter_modal_delete', $data);
    }

    /////////////////////////////////////DO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function add_delivery_oder()
    {
        // $this->template->display('purchasing/delievery_order/add_delivery_order');
        echo "hai";
    }

    public function delivery_oder_show()
    {
        $data['gr'] =  $this->M_packing_do->tampil_do_where($this->input->get('do'));
        $this->template->display('purchasing/packing_do/edit_delivery_order', $data);
    }

    public function delivery_oder_gr()
    {
        $data['po'] =  $this->M_delievery_order->tampil_gr_where_other($this->input->get('po'));
        $this->load->view('purchasing/delievery_order/delivery_oder_filter_gr', $data);
    }

    public function delivery_oder_do()
    {
        $data['do'] =  $this->M_delievery_order->tampil_do(trim($this->input->get('do')));
        $this->load->view('purchasing/delievery_order/delivery_oder_do_all', $data);
    }

    public function delivery_oder_save($trans)
    {
        $docno     = $this->input->post('docno');
        $docdate   = $this->convert($this->input->post('docdate'));
        $duedate   = $this->convert($this->input->post('duedate'));
        $ipaddress = $_SERVER['REMOTE_ADDR'];

        $datahdr = array(
            'trans'     => $trans,
            'docno'     => $docno,
            'docdate'   => $docdate,
            'duedate'   => $duedate,
            'createdby' => strtoupper($this->session->userdata('userid_1')),
            'ipaddress' => $ipaddress
        );
        $query = $this->M_packing_do->simpan_do_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('Packing_do/delivery_oder_show?do=' . $query['docno']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('Packing_do/add_delivery_oder');
        }
    }

    public function delivery_order_modal_delete()
    {
        $data['do'] =  $this->M_packing_do->tampil_do_where($this->input->get('delete'));
        $this->load->view('purchasing/packing_do/delivery_order_filter_modal_delete', $data);
    }

    public function delivery_order_delete()
    {
        $docno = $this->input->post('docno');
        $query = $this->M_packing_do->delete_delivery_order($docno);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Delete Data Success</div>");
            redirect('Packing_do/add_delivery_oder');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Transaction Broken.</div>");
            redirect('Packing_do/delivery_oder_show?do=' . $docno);
        }
    }

    ////////////////////Booking Order\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function book_order()
    {
        $data['_factory'] = $this->M_packing_do->get_factory();
        $this->template->display('purchasing/packing_do/book_order', $data);
    }

    public function book_order_show()
    {
        $data['book'] =  $this->M_packing_do->tampil_bookref_where($this->input->get('bookref_no'));
        $this->template->display('purchasing/packing_do/book_order_show', $data);
    }

    public function book_order_all()
    {
        $data['book'] =  $this->M_packing_do->tampil_bookref_all($this->input->get('inv'));
        $this->load->view('purchasing/packing_do/book_order_all', $data);
    }

    public function add_container_po()
    {
        $data['po'] =  $this->M_packing_do->tampil_container_po($this->input->get('po'));
        $this->load->view('purchasing/packing_do/add_container_filter_po', $data);
    }

    public function add_container_get()
    {
        $data['cont'] =  $this->M_packing_do->tampil_cont_shp($this->input->get('cust'), $this->input->get('ship'), $this->input->get('cont'), $this->input->get('contno'));
        $this->load->view('purchasing/packing_do/get_add_container', $data);
    }

    public function add_container_po_dtl()
    {
        $data['po'] =  $this->M_packing_do->tampil_container_po($this->input->get('cust'), $this->input->get('po'));
        $this->load->view('purchasing/packing_do/add_container_filter_po_dtl', $data);
    }

    public function save_book_ref($trans)
    {
        $bookref_no = $this->input->post('bookref_no');
        $barge      = $this->input->post('barge');
        $voyage     = $this->input->post('voyage');
        $cust       = $this->input->post('cust');
        $ammend     = $this->input->post('ammend');
        $etd        = $this->convert($this->input->post('etd'));
        $date       = $this->convert($this->input->post('date'));

        $datahdr = array(
            'trans'      => $trans,
            'bookref_no' => $bookref_no,
            'barge'      => $barge,
            'voyage'     => $voyage,
            'etd'        => $etd,
            'date'       => $date,
            'cust'       => $cust,
            'ammend'     => $ammend,
            'createdby'  => strtoupper($this->session->userdata('userid_1'))
        );

        $query =  $this->M_packing_do->simpan_book_ref_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('Packing_do/book_order_show?bookref_no=' . $query['bookref_no']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('Packing_do/book_order');
        }
    }

    public function book_order_excel()
    {
        $this->load->library("excel/PHPExcel");
        $cust = $this->input->get('cust');
        $data['book'] =  $this->M_packing_do->tampil_bookref_where($this->input->get('bookref_no'));
        $this->load->view('purchasing/packing_do/toexcel_bookref', $data);
    }

    public function book_order_shipping()
    {
        $data['book'] =  $this->M_packing_do->tampil_bookref_all($this->input->get('inv'));
        $this->template->display('purchasing/packing_do/book_order_list', $data);
    }

    public function book_order_shipping_input()
    {
        $data['book'] =  $this->M_packing_do->tampil_bookref_where($this->input->get('bookref_no'));
        $data['cont'] =  $this->M_packing_do->get_bookref_shp2($this->input->get('cust'), $this->input->get('ship'));
        $this->template->display('purchasing/packing_do/book_order_shipping', $data);
    }

    public function save_book_ref_ship()
    {
        $bookref_no = $this->input->post('bookref_no');

        $datahdr = array(
            'bookref_no' => $bookref_no,
            'createdby'  => strtoupper($this->session->userdata('userid_1'))
        );

        $query =  $this->M_packing_do->simpan_book_ref_shp_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('Packing_do/book_order_shipping_input?bookref_no=' . $query['bookref_no']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('Packing_do/book_order_shipping_input?bookref_no=' . $query['bookref_no']);
        }
    }

    // function save_book_ref_ship(){
    //     $cont   = $this->input->post('cont');
    //     $jml    = count($this->input->post('cont'));
    //     echo $jml;
    //     // for($i = 0;$i < $jml;$i++){
    //     //     $explode=explode("/", $cont[$i]);
    //     //     $mainpo   =  $explode[2];
    //     //     $stuff   =  $explode[1];
    //     //     $ship_book   = $explode[0];
    //     //     echo $ship_book."<br/>";
    //     // }

    //     $row=  $this->db->query("Select @flag as flag")->row();

    //     return $row;
    // }

    public function loading_report_remark()
    {
        $data['po'] =  $this->M_packing_do->tampil_po_hdr($this->input->get('remark'));
        $this->load->view('purchasing/packing_do/loading_report_filter_remark', $data);
    }

    public function book_order_shipping_excel()
    {
        $this->load->library("excel/PHPExcel");
        $data['cust'] = $this->input->get('cust');
        $data['book'] = $this->M_packing_do->get_shp_excel($this->input->get('bookref_no'));
        $data['whs']  = $this->M_packing_do->get_shp_whs($this->input->get('bookref_no'));
        $this->load->view('purchasing/packing_do/toexcel_bookref_shipping', $data);
    }
}
