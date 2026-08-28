<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing_zht extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_purchasing_zht');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    /* This Vendor used in master and for acounting vendor */

    public function vendor_zht()
    {
        $data['supp']   =  $this->m_purchasing_zht->tampil_supp_limit();
        $data['group']  =  $this->m_purchasing_zht->tampil_supp_group();
        $this->template->display('purchasing_zht/mstvendor_zht', $data);
    }

    public function vendor_search()
    {
        $vendor       = $this->input->get('vendor');
        $data['supp'] =  $this->m_purchasing_zht->tampil_supp($vendor);
        $this->load->view('purchasing_zht/mstvendor_edit_dtl', $data);
    }

    public function vendor_edit()
    {
        $vendor         = $this->input->get('vendor');
        $data['supp']   =  $this->m_purchasing_zht->tampil_supp_where($vendor);
        $data['group']  =  $this->m_purchasing_zht->tampil_supp_group();
        // echo "<pre>";
        // print_r($data['group']);
        // echo "</pre>";
        // die;
        $this->template->display('purchasing_zht/mstvendor_edit', $data);
    }

    public function newGenerateSuplierPurchasing()
    {
        $vendorName = $this->input->get('vendorNameCompany');
        $num = $this->m_purchasing_zht->newCheckSuppCode($vendorName);
        $get    = str_pad($num, 4, 0, STR_PAD_LEFT);
        $prefix = strtoupper(substr($vendorName, 0, 1));
        $newGen = $prefix . str_pad($num, 5, '0', STR_PAD_LEFT);
        $set = 'S' . $newGen;

        echo $set;
    }

    public function vendor_delete()
    {
        $vendor = $this->input->get('vendor');
        $query  = $this->m_purchasing_zht->delete_vendor($vendor, strtoupper($this->session->userdata('userid_1')));

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing_zht/vendor_zht');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing_zht/vendor_zht');
        }
    }
    public function vendor_save($trans)
    {
        $vendorid      = trim($this->input->post('vendorid'));
        $vendorcompany = $this->input->post('vendorcompany');
        $address       = nl2br($this->input->post('address'));
        $contact       = $this->input->post('contact');
        $email         = $this->input->post('email');
        $telephone     = $this->input->post('telephone');
        $mobile        = $this->input->post('mobile');
        $did           = $this->input->post('did');
        $fax           = $this->input->post('fax');
        $postal        = $this->input->post('postal');
        $term          = $this->input->post('term');
        $taxcode       = $this->input->post('taxcode');
        $taxprice      = $this->input->post('taxprice');
        $website       = $this->input->post('website');
        $group         =  $this->input->post('group');

        if ($trans == 'add') {

            $cek = $this->m_purchasing_zht->cek('zht_pur_tbl_mst_supplier_tims', 'supplierid = "' . $vendorid . '"');

            if ($cek == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Vendor " . $vendorid . "</div>");
                redirect('purchasing_zht/vendor_zht');
            }

            $data = array(
                'supplierid'      => $vendorid,
                'suppliercompany' => $vendorcompany,
                'contactperson'   => $contact,
                'address'         => $address,
                'telephone'       => $telephone,
                'mobilephone'     => $mobile,
                'did'             => $did,
                'fax'             => $fax,
                'email'           => $email,
                'postalcode'      => $postal,
                'paymentterm'     => $term,
                'taxcode'         => $taxcode,
                'taxprice'        => $taxprice,
                'website'         => $website,
                'groupid'         => $group,
                'createdby'       => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing_zht->simpan_vendor($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'suppliercompany' => $vendorcompany,
                'contactperson'   => $contact,
                'address'         => $address,
                'telephone'       => $telephone,
                'mobilephone'     => $mobile,
                'did'             => $did,
                'fax'             => $fax,
                'email'           => $email,
                'postalcode'      => $postal,
                'paymentterm'     => $term,
                'taxcode'         => $taxcode,
                'taxprice'        => $taxprice,
                'website'         => $website,
                'groupid'         => $group,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing_zht->update_vendor($vendorid, $data, strtoupper($this->session->userdata('userid_1')));
            $message = 'Update Data Success';
        }

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing_zht/vendor_zht');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing_zht/vendor_zht');
        }
    }

    //    ----------------------------------------------------------ABOUT VENDOR GROUP-----------------------------------------------------------

    /* This Vendor Group used in menu master and for acounting vendor */

    public function vendor_group_zht()
    {
        $data['group'] = $this->m_purchasing_zht->tampil_supp_group();
        $data['coa'] =  $this->m_purchasing_zht->tampil_coa('trade accounts pay');
        $this->template->display('purchasing_zht/mstvendor_group_zht', $data);
    }

    public function vendor_group_save()
    {
        $id    = $this->input->post('id');
        $group = $this->input->post('group');
        $coa   = $this->input->post('coa');

        if ($id == '') {
            $data = array(
                'group'       => $group,
                'nocoa'       => $coa,
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing_zht->simpan_vendor_group($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'group'           => $group,
                'nocoa'           => $coa,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing_zht->update_vendor_group($id, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing_zht/vendor_group_zht');
    }

    public function vendor_group_delete()
    {
        $this->m_purchasing_zht->delete_vendor_group($this->uri->segment(3));
        $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing_zht/vendor_group_zht');
    }

}
