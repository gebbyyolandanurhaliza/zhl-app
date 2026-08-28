<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchasing_do extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_Delivery_order', 'm_purchasing_so'));
        $this->load->library('PHPExcel');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->template->display('purchasing/delievery_order/add_delivery_order');
    }

    public function delivery_oder_show()
    {
        $data['gr'] =  $this->m_Delivery_order->tampil_do_where($this->input->get('do'));
        $this->template->display('purchasing/delievery_order/edit_delivery_order', $data);
    }

    public function delivery_oder_gr()
    {
        $data['po'] =  $this->m_Delivery_order->tampil_gr_where_other($this->input->get('po'));
        $this->load->view('purchasing/delievery_order/delivery_oder_filter_gr', $data);
    }

    public function delivery_oder_do()
    {
        $data['do'] =  $this->m_Delivery_order->tampil_do(trim($this->input->get('do')));
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
        $query = $this->m_Delivery_order->simpan_do_sp($datahdr);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
            redirect('purchasing_do/delivery_oder_show?do=' . $query['docno']);
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('purchasing_do');
        }
    }


    public function delivery_order_modal_delete()
    {
        $data['do'] =  $this->m_Delivery_order->tampil_do_where($this->input->get('delete'));
        $this->load->view('purchasing/delievery_order/delivery_order_filter_modal_delete', $data);
    }

    public function delivery_order_delete()
    {
        $docno = $this->input->post('docno');
        $query = $this->m_Delivery_order->delete_delivery_order($docno);

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_do');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Transaction Broken.</div>");
            redirect('purchasing_do/delivery_oder_show?do=' . $docno);
        }
    }

    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }
}
