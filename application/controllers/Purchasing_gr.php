<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_gr extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('m_purchasing', 'm_purchasing_po', 'm_purchasing_gr'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    //-----------------------------------------------------------------------ABOUT GR---------------------------------------------------------
    public function index()
    {
        // $data['cur']=  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/good_receipt');
    }

    public function good_receipt_show()
    {
        $data['gr']  =  $this->m_purchasing_gr->tampil_gr_where($this->input->get('gr'));
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/good_receipt_show', $data);
    }

    public function good_receipt_po()
    {
        $data['po'] =  $this->m_purchasing_po->tampil_po_where_other($this->input->get('po'));
        $this->load->view('purchasing/good_receipt_filter_po', $data);
    }

    public function good_receipt_po_close()
    {
        $this->m_purchasing_po->update_po_close($this->input->get('po'));
        $data['po'] =  $this->m_purchasing_po->tampil_po_where_other($this->input->get('search'));
        $this->load->view('purchasing/good_receipt_filter_po', $data);
    }

    public function good_receipt_gr()
    {
        $data['gr'] =  $this->m_purchasing_gr->tampil_gr(trim($this->input->get('gr')));
        $this->load->view('purchasing/good_receipt_gr_all', $data);
    }

    public function good_receipt_modal_delete()
    {
        $data['gr'] =  $this->m_purchasing_gr->tampil_gr_where(trim($this->input->get('delete')));
        $this->load->view('purchasing/good_receipt_filter_modal_delete', $data);
    }

    public function good_receipt_edit()
    {
        $data['gr'] =  $this->m_purchasing_gr->tampil_gr_where($this->input->get('gr'));
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $this->template->display('purchasing/good_receipt_show', $data);
    }

    function print_report_gr()
    {
        $packgr         = $this->m_purchasing_gr->tampil_gr_where($this->input->get('gr'));
        $data['packgr'] = $packgr;
        // print_r($packgr);
        // die;
        $this->load->view('purchasing/printout/rpt_gr', $data);
    }

    public function good_receipt_delete()
    {
        $query = $this->m_purchasing_gr->delete_gr_sp($this->input->get('gr'));

        if ($query['flag'] == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_gr/index');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Sorry, This Data used in Another Transaction</div>");
            redirect('purchasing_gr/index');
        }
    }

    public function good_receipt_save($trans)
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
        $query = $this->m_purchasing_gr->simpan_gr_sp($datahdr);



        if ($query['flag'] == 1) {
            if ($query['docno'] != '') {
                $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Transaction Success</div>");
                redirect('purchasing_gr/good_receipt_show?gr=' . $query['docno']);
            } else {
                $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
                redirect('purchasing_gr/index');
            }
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Save Transaction Broken.</div>");
            redirect('purchasing_gr/index');
        }
    }
    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];

        return $time;
    }
    //--------------------------------------------------------------------END----------------------------------------------------------------
}
