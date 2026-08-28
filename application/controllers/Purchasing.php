<?php
defined('BASEPATH') or exit('No direct script access allowed');

class purchasing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_purchasing');

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    //    -----------------------------------------------------------------ABOUT PPH----------------------------------------------------------
    public function import_pph()
    {
        $data['pph_temp'] =  $this->m_purchasing->tampil_pph_temp();
        $this->template->display('purchasing/import_pph', $data);
    }

    public function import_pph_search()
    {
        $from = $this->uri->segment(3);
        $to   = $this->uri->segment(4);
        $pph  = trim($this->uri->segment(5));
        $item = trim($this->uri->segment(6));

        $data['pph'] =  $this->m_purchasing->tampil_pph_temp_search($from, $to, $pph, $item);
        $this->load->view('purchasing/import_pph_tbl', $data);
    }

    public function pph_transfer_ex()
    {
        $config['upload_path'] = './temp_upload/';
        $config['allowed_types'] = 'xls';

        $this->load->library('upload', $config);

        $this->upload->do_upload();
        $upload_data = $this->upload->data();

        $file =  $upload_data['full_path'];

        $this->pph_transfer_tbl($file);
    }

    public function pph_transfer_tbl($excel)
    {
        require_once(APPPATH . "libraries/excel/spreadsheet_excel_reader.php");

        $dataE = new Spreadsheet_Excel_Reader();
        $dataE->setUTFEncoder('iconv');
        $dataE->setOutputEncoding('CP1251');
        $dataE->read($excel);
        error_reporting(E_ALL ^ E_NOTICE);

        $j = -1;

        for ($x = 2; $x <= count($dataE->sheets[0]["cells"]); $x++) {
            $j++;
            $TransDate[$j]   = $dataE->sheets[0]["cells"][$x][5];
            $PPHNo[$j]       = $dataE->sheets[0]["cells"][$x][3];
            $ItemID[$j]      = $dataE->sheets[0]["cells"][$x][9];
            $ItemName[$j]    = $dataE->sheets[0]["cells"][$x][10];
            $Qnty[$j]        = $dataE->sheets[0]["cells"][$x][11];
            $PurchaseUOM[$j] = $dataE->sheets[0]["cells"][$x][12];
            $Remark[$j]      = $dataE->sheets[0]["cells"][$x][20];
        }

        $data = array(
            'TransDate'   => $TransDate,
            'PPHNo'       => $PPHNo,
            'ItemID'      => $ItemID,
            'ItemName'    => $ItemName,
            'Qnty'        => $Qnty,
            'PurchaseUOM' => $PurchaseUOM,
            'Remark'      => $Remark
        );

        $data['pph_temp'] =  $this->m_purchasing->tampil_pph_temp();
        $this->template->display('purchasing/import_pph', $data);
    }

    public function pph_transfer_save()
    {
        $chk    = $this->input->post('chk');
        $PPHNo  = $this->input->post('PPHNo');
        $ItemID = $this->input->post('ItemID');

        if ($chk != false) {
            foreach ($chk as $i) {
                $query_dtl = $this->m_purchasing->cek_pph($PPHNo[$i], $ItemID[$i]);
                if ($query_dtl == 1) {
                    $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate PPH " . $PPHNo[$i] . " And ItemID " . $ItemID[$i] . "</div>");
                    redirect('purchasing/import_pph');
                }
            }

            $query = $this->m_purchasing->simpan_pph();

            if ($query == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">Tranfer PPH Success</div>");
                redirect('purchasing/import_pph');
            } else {
                $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Tranfer PPH Broken</div>");
                redirect('purchasing/import_pph');
            }
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Nothing PPH Selected</div>");
            redirect('purchasing/import_pph');
        }
    }


    //--------------------------------------------------------------ABOUT VENDOR PURCHASING----------------------------------------------------------
    /* this vendor for purchasing */

    public function vendor_pur()
    {
        $data['vendor'] = $this->m_purchasing->tampil_vendor_limit_pur();
        $data['group']  = $this->m_purchasing->tampil_vendor_group_pur();
        $this->template->display('purchasing/mstvendor_pur', $data);
    }

    public function pur_vendor_edit()
    {
        $vendor = $this->input->get('vendor');
        $data['vendor'] = $this->m_purchasing->tampil_vendor_pur_where($vendor);
        $data['group']  = $this->m_purchasing->tampil_vendor_group_pur();
        $this->template->display('purchasing/mstvendor_edit_pur', $data);
    }

    public function pur_vendor_save($trans)
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
        $group         = $this->input->post('group');

        if ($trans == 'add') {

            $cek = $this->m_purchasing->cek('zhl_pur_tbl_mst_vendor', 'vendorid = "' . $vendorid . '"');

            if ($cek == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Vendor " . $vendorid . "</div>");
                redirect('purchasing/vendor_pur');
            }

            $data = array(
                'vendorid'      => $vendorid,
                'vendorcompany' => $vendorcompany,
                'contactperson' => $contact,
                'address'       => $address,
                'telephone'     => $telephone,
                'mobilephone'   => $mobile,
                'did'           => $did,
                'fax'           => $fax,
                'email'         => $email,
                'postalcode'    => $postal,
                'paymentterm'   => $term,
                'taxcode'       => $taxcode,
                'taxprice'      => $taxprice,
                'website'       => $website,
                'groupid'       => $group,
                'createdby'     => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing->simpan_vendor_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'vendorcompany' => $vendorcompany,
                'contactperson' => $contact,
                'address'       => $address,
                'telephone'     => $telephone,
                'mobilephone'   => $mobile,
                'did'           => $did,
                'fax'           => $fax,
                'email'         => $email,
                'postalcode'    => $postal,
                'paymentterm'   => $term,
                'taxcode'       => $taxcode,
                'taxprice'      => $taxprice,
                'website'       => $website,
                'groupid'       => $group,
                'lastupdatedby' => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing->update_vendor_pur($vendorid, $data, strtoupper($this->session->userdata('userid_1')));
            $message = 'Update Data Success';
        }

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/vendor_pur');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/vendor_pur');
        }
    }

    public function pur_vendor_delete()
    {
        $vendor = $this->input->get('vendor');
        $query = $this->m_purchasing->delete_vendor_pur($vendor, strtoupper($this->session->userdata('userid_1')));

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing/vendor_pur');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/vendor_pur');
        }
    }

    public function vendor_search_pur()
    {
        $vendor = $this->input->get('vendor');
        $data['supp'] =  $this->m_purchasing->tampil_vendor_pur($vendor);
        $this->load->view('purchasing/mstvendor_edit_dtl', $data);
    }
    //    ----------------------------------------------------------ABOUT VENDOR ACCOUNTING-----------------------------------------------------------

    /* This Vendor used in master and for acounting vendor */

    public function vendor()
    {
        $data['supp']   =  $this->m_purchasing->tampil_supp_limit();
        $data['group']  =  $this->m_purchasing->tampil_supp_group();
        $this->template->display('purchasing/mstvendor', $data);
    }

    public function vendor_search()
    {
        $vendor       = $this->input->get('vendor');
        $data['supp'] =  $this->m_purchasing->tampil_supp($vendor);
        $this->load->view('purchasing/mstvendor_edit_dtl', $data);
    }

    public function vendor_edit()
    {
        $vendor         = $this->input->get('vendor');
        $data['supp']   =  $this->m_purchasing->tampil_supp_where($vendor);
        $data['group']  =  $this->m_purchasing->tampil_supp_group();
        $this->template->display('purchasing/mstvendor_edit', $data);
    }

    public function vendor_delete()
    {
        $vendor = $this->input->get('vendor');
        $query  = $this->m_purchasing->delete_vendor($vendor, strtoupper($this->session->userdata('userid_1')));

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing/vendor');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/vendor');
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

            $cek = $this->m_purchasing->cek('zhl_pur_tbl_mst_supplier', 'supplierid = "' . $vendorid . '"');

            if ($cek == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Vendor " . $vendorid . "</div>");
                redirect('purchasing/vendor');
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
            $query = $this->m_purchasing->simpan_vendor($data);
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
            $query = $this->m_purchasing->update_vendor($vendorid, $data, strtoupper($this->session->userdata('userid_1')));
            $message = 'Update Data Success';
        }

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/vendor');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/vendor');
        }
    }

    //    ----------------------------------------------------------ABOUT VENDOR GROUP-----------------------------------------------------------

    /* This Vendor Group used in menu master and for acounting vendor */

    public function vendor_group()
    {
        $data['group'] = $this->m_purchasing->tampil_supp_group();
        $data['coa'] =  $this->m_purchasing->tampil_coa('trade accounts pay');
        $this->template->display('purchasing/mstvendor_group', $data);
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
            $this->m_purchasing->simpan_vendor_group_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'group'           => $group,
                'nocoa'           => $coa,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->update_vendor_group_pur($id, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing/vendor_group');
    }

    public function vendor_group_delete()
    {
        $this->m_purchasing->delete_vendor_group_pur($this->uri->segment(3));
        $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/vendor_group');
    }

    //    ----------------------------------------------------------ABOUT CUSTOMER-----------------------------------------------------------
    /*
         For costumer use marketing master costumer
      */
    public function customer()
    {
        redirect('marketing/master/customer');
        // $data['cust'] =  $this->m_purchasing->tampil_cust_pur('');
        // $this->template->display('purchasing/mstcustomer', $data);
    }

    // public function customer_search()
    // {
    //     $cust = $this->input->get('cust');
    //     $data['cust'] =  $this->m_purchasing->tampil_cust_pur($cust);
    //     $this->load->view('purchasing/mstcustomer_edit_dtl', $data);
    // }

    // public function customer_edit()
    // {
    //     $cust = $this->input->get('cust');
    //     $data['cust'] =  $this->m_purchasing->tampil_cust_where_pur($cust);
    //     $this->template->display('purchasing/mstcustomer_edit', $data);
    // }

    // public function customer_delete()
    // {
    //     $cust = $this->input->get('cust');
    //     $this->m_purchasing->delete_customer_pur($cust);
    //     $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
    //     redirect('purchasing/customer');
    // }

    // public function customer_save($trans)
    // {
    //     $customerid      = trim($this->input->post('customerid'));
    //     $customername    = trim($this->input->post('customername'));
    //     $customercompany = $this->input->post('customercompany');
    //     $contact         = $this->input->post('contact');
    //     $address         = nl2br($this->input->post('address'));
    //     $telephone       = $this->input->post('telephone');
    //     $mobile          = $this->input->post('mobile');
    //     $fax             = $this->input->post('fax');
    //     $email           = $this->input->post('email');
    //     $term            = $this->input->post('term');

    //     if ($trans == 'add') {

    //         $cek = $this->m_purchasing->cek('zhl_pur_tblmst_customer', 'customer_code = "' . $customerid . '"');

    //         if ($cek == 1) {
    //             $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Customer " . $customerid . "</div>");
    //             redirect('purchasing/customer');
    //         }

    //         $data = array(
    //             'customer_code'         => $customerid,
    //             'customer_name'         => $customername,
    //             'customer_company_name' => $customercompany,
    //             'customer_contact_name' => $contact,
    //             'customer_address'      => $address,
    //             'customer_phone'        => $telephone,
    //             'customer_mobilephone'  => $mobile,
    //             'customer_fax'          => $fax,
    //             'customer_email'        => $email,
    //             'customer_term'         => $term,
    //             'created_by'            => strtoupper($this->session->userdata('userid_1')),
    //             'created_date'          => date('Y-m-d H:i:s')
    //         );
    //         $query = $this->m_purchasing->simpan_customer_pur($data);
    //         $message = 'Save Data Success';
    //     } else {
    //         $data = array(
    //             'customer_name'         => $customername,
    //             'customer_company_name' => $customercompany,
    //             'customer_contact_name' => $contact,
    //             'customer_address'      => $address,
    //             'customer_phone'        => $telephone,
    //             'customer_mobilephone'  => $mobile,
    //             'customer_fax'          => $fax,
    //             'customer_email'        => $email,
    //             'customer_term'         => $term,
    //             'updated_by'            => strtoupper($this->session->userdata('userid_1')),
    //             'updated_date'          => date('Y-m-d H:i:s')
    //         );
    //         $query = $this->m_purchasing->update_customer_pur($customerid, $data);
    //         $message = 'Update Data Success';
    //     }
    //     if ($query == 1) {
    //         $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
    //         redirect('purchasing/customer');
    //     } else {
    //         $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
    //         redirect('purchasing/customer');
    //     }
    // }

    //   ---------------------------------------------------------------------- ITEM----------------------------------------------------
    public function item()
    {
        $data['group']   = $this->m_purchasing->tampil_item_group_pur();
        $data['uom']     = $this->m_purchasing->tampil_item_uom_pur();
        $data['item']    = $this->m_purchasing->tampil_item_limit_pur();
        $data['country'] = $this->m_purchasing->tampil_country();
        $this->template->display('purchasing/mstitem', $data);
    }

    public function item_category_sub()
    {
        $data['groupsub'] = $this->m_purchasing->tampil_item_group_sub_pur_where($this->uri->segment(3));
        $this->load->view('purchasing/mstitem_edit_category_sub', $data);
    }

    public function item_search()
    {
        $item         = $this->input->get('item');
        $category     = $this->input->get('cat');
        $categorysub  = $this->input->get('sub');
        $data['item'] = $this->m_purchasing->tampil_item_search_pur($item, $category, $categorysub);
        $this->load->view('purchasing/mstitem_edit_dtl', $data);
    }

    public function item_edit()
    {
        $data['group']    = $this->m_purchasing->tampil_item_group_pur();
        $data['groupsub'] = $this->m_purchasing->tampil_item_group_sub_pur();
        $data['uom']      = $this->m_purchasing->tampil_item_uom_pur();
        $data['country']  = $this->m_purchasing->tampil_country();
        $data['item']     = $this->m_purchasing->tampil_item_where_pur($this->input->get('item'));

        $this->template->display('purchasing/mstitem_edit', $data);
    }

    public function item_delete()
    {
        $query = $this->m_purchasing->delete_item_pur($this->input->get('item'), strtoupper($this->session->userdata('userid_1')));

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
            redirect('purchasing/item');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/item');
        }
    }

    public function item_save($trans)
    {
        $itemid       = trim($this->input->post('itemid'));
        $itemname     = $this->input->post('itemname');
        $itemgroupsub = $this->input->post('itemgroupsub');
        $itemremark   = $this->input->post('itemremark');
        $pmcode       = $this->input->post('pmcode');
        $hscode       = $this->input->post('hscode');
        $uom          = $this->input->post('uom');
        $country      = $this->input->post('country');
        $per1000      = $this->input->post('per');
        $unitprice    = $this->input->post('unitprice');
        $nettweight   = $this->input->post('nettweight');
        $grossweight  = $this->input->post('grossweight');

        if ($trans == 'add') {
            $cek = $this->m_purchasing->cek('zhl_pur_tbl_mst_item', 'itemid = "' . $itemid . '"');

            if ($cek == 1) {
                $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Duplicate Item ID " . $itemid . "</div>");
                redirect('purchasing/item');
            }

            $data = array(
                'itemid'        => $itemid,
                'itemname'      => $itemname,
                'categorysubid' => $itemgroupsub,
                'itemremark'    => $itemremark,
                'uomid'         => $uom,
                'country_id'    => $country,
                'pmcode'        => $pmcode,
                'hscode'        => $hscode,
                'per1000'       => $per1000,
                'unitprice'     => $unitprice,
                'nettweight'    => $nettweight,
                'grossweight'   => $grossweight,
                'createdby'     => strtoupper($this->session->userdata('userid_1')),
                'createddate'   => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing->simpan_item_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'itemname'        => $itemname,
                'categorysubid'   => $itemgroupsub,
                'itemremark'      => $itemremark,
                'uomid'           => $uom,
                'country_id'      => $country,
                'pmcode'          => $pmcode,
                'hscode'          => $hscode,
                'per1000'         => $per1000,
                'unitprice'       => $unitprice,
                'nettweight'      => $nettweight,
                'grossweight'     => $grossweight,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $query = $this->m_purchasing->update_item_pur($itemid, $data);
            $message = 'Update Data Success';
        }

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/item');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/item');
        }
    }

    public function item_factory()
    {
        $data['group'] =  $this->m_purchasing->tampil_item_group_pur();
        $data['item'] =  $this->m_purchasing->tampil_item_limit_pur();
        $this->template->display('purchasing/mstitem_factory', $data);
    }

    public function item_factory_search()
    {
        $item = $this->input->get('item');
        $category = $this->input->get('cat');
        $categorysub = $this->input->get('sub');

        $data['item'] =  $this->m_purchasing->tampil_item_search_pur($item, $category, $categorysub);

        $this->load->view('purchasing/mstitem_edit_dtl_factory', $data);
    }

    public function item_factory_edit()
    {
        $data['item'] =  $this->m_purchasing->tampil_item_where_pur($this->input->get('item'));
        $this->template->display('purchasing/mstitem_edit_factory', $data);
    }

    public function item_factory_save()
    {
        $itemid = trim($this->input->post('itemid'));
        $cwp1 =  $this->input->post('cwp1');
        $cwp2 =  $this->input->post('cwp2');
        $cwp3 =  $this->input->post('cwp3');

        $data = array(
            'idcwp1' => $cwp1, 'idcwp2' => $cwp2, 'idcwp3' => $cwp3,
            'updateditemby' => strtoupper($this->session->userdata('userid_1')), 'updateditemdate' => date('Y-m-d H:i:s')
        );
        $query = $this->m_purchasing->update_item_factory($itemid, $data);
        $message = 'Update Data Success';


        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/item_factory');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/item_factory');
        }
    }


    //-----------------------------------------------------------ABOUT ITEM UOM-----------------------------------------------------------
    public function item_uom()
    {
        $data['uom'] =  $this->m_purchasing->tampil_item_uom_pur();
        $this->template->display('purchasing/mstitem_uom', $data);
    }

    public function item_uom_save()
    {
        $uomid =  $this->input->post('uomid');
        $uomname =  $this->input->post('uomname');

        if ($uomid == '') {
            $data = array(
                'uomname'     => $uomname,
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->simpan_item_uom_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'uomname'         => $uomname,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H: i: s')
            );
            $this->m_purchasing->update_item_uom_pur($uomid, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing/item_uom');
    }

    public function item_uom_delete()
    {
        $this->m_purchasing->delete_item_uom_pur($this->uri->segment(3));
        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/item_uom');
    }

    //-----------------------------------------------------------ABOUT ITEM GROUP-----------------------------------------------------------
    public function item_group()
    {
        $data['group']    = $this->m_purchasing->tampil_item_group_pur();
        $data['coainv']   = $this->m_purchasing->tampil_coa('Inventory');
        $data['coags']    = $this->m_purchasing->tampil_coa('COGS');
        $data['coasales'] = $this->m_purchasing->tampil_coa('Sales');
        $this->template->display('purchasing/mstitem_group', $data);
    }

    public function item_group_show($categoryid)
    {
        $data['group'] =  $this->m_purchasing->tampil_item_group_pur_where($categoryid);
        $data['coainv'] =  $this->m_purchasing->tampil_coa('Inventory');
        $data['coags'] =  $this->m_purchasing->tampil_coa('COGS');
        $data['coasales'] =  $this->m_purchasing->tampil_coa('Sales');
        $this->template->display('purchasing/mstitem_group_show', $data);
    }

    public function item_group_save()
    {
        $groupid   = $this->input->post('groupid');
        $groupname = $this->input->post('groupname');
        $coainv    = $this->input->post('coainv');
        $coags     = $this->input->post('coags');
        $coasales  = $this->input->post('coasales');

        if ($groupid == '') {
            $data = array(
                'categoryname' => $groupname,
                'nocoainv'     => $coainv,
                'nocoags'      => $coags,
                'nocoasales'   => $coasales,
                'createdby'    => strtoupper($this->session->userdata('userid_1')),
                'createddate'  => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->simpan_item_group_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'categoryname'    => $groupname,
                'nocoainv'        => $coainv,
                'nocoags'         => $coags,
                'nocoasales'      => $coasales,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->update_item_group_pur($groupid, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing/item_group');
    }

    public function item_group_delete()
    {
        $this->m_purchasing->delete_item_group_pur($this->uri->segment(3));
        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/item_group');
    }

    //-----------------------------------------------------------ABOUT ITEM GROUP SUB-----------------------------------------------------------
    public function item_group_sub()
    {
        $data['group']    = $this->m_purchasing->tampil_item_group_pur();
        $data['groupsub'] = $this->m_purchasing->tampil_item_group_sub_pur();
        $this->template->display('purchasing/mstitem_group_sub', $data);
    }

    public function item_group_sub_save()
    {
        $groupid   = $this->input->post('groupsubid');
        $groupname = $this->input->post('groupsubname');
        $group     = $this->input->post('group');

        if ($groupid == '') {
            $data = array(
                'categorysubname' => $groupname,
                'categoryid'      => $group,
                'createdby'       => strtoupper($this->session->userdata('userid_1')),
                'createddate'     => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->simpan_item_group_sub_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'categorysubname' => $groupname,
                'categoryid'      => $group,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H:i:s')
            );
            $this->m_purchasing->update_item_group_sub_pur($groupid, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing/item_group_sub');
    }

    public function item_group_sub_delete()
    {
        $this->m_purchasing->delete_item_group_sub_pur($this->uri->segment(3));

        $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/item_group_sub');
    }

    //-----------------------------------------------------------ABOUT ITEM PRICE-----------------------------------------------------------
    public function item_price()
    {
        $data['cur']        = $this->m_purchasing->tampil_cur();
        $data['item_price'] = $this->m_purchasing->tampil_item_price_limit_pur();
        $this->template->display('purchasing/mstitem_price', $data);
    }

    public function item_price_search()
    {
        $data['item_price'] =  $this->m_purchasing->tampil_item_price_pur($this->input->get('search'));
        $this->load->view('purchasing/mstitem_price_edit_dtl', $data);
    }

    public function item_price_vendor()
    {
        $data['vendor'] =  $this->m_purchasing->tampil_vendor_pur($this->input->get('vendor'));
        $this->load->view('purchasing/mstitem_price_vendor', $data);
    }

    public function item_price_item()
    {
        $data['item'] =  $this->m_purchasing->tampil_item_pur($this->input->get('item'));
        $this->load->view('purchasing/mstitem_price_item', $data);
    }

    public function item_price_edit()
    {
        $data['cur'] =  $this->m_purchasing->tampil_cur();
        $data['item_price'] =  $this->m_purchasing->tampil_item_price_pur_where($this->input->get('price'), $this->input->get('item'));
        $this->template->display('purchasing/mstitem_price_edit', $data);
    }

    public function item_price_delete()
    {
        $this->m_purchasing->delete_item_price_pur($this->input->get('price'), $this->input->get('item'));
        $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/item_price');
    }

    public function item_price_save($trans)
    {
        $vendorid = trim($this->input->post('vendorid'));
        $name     = $this->input->post('name');
        $contact  = $this->input->post('contact');

        if ($trans != 'update') {
            $datahdr = array(
                'vendorid'        => $vendorid,
                'vendorcompany'   => $name,
                'contactperson'   => $contact,
                'createdby'       => strtoupper($this->session->userdata('userid_1')),
                'createddate'     => date('Y-m-d H:i:s')
            );

            $query =  $this->m_purchasing->simpan_item_price_pur($datahdr);
            $message = 'Save Data Success';
        } else {
            $query =  $this->m_purchasing->update_item_price();
            $message = 'Update Data Success';
        }

        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/item_price');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/item_price');
        }
    }

    //    ----------------------------------------------------------ABOUT WHS-----------------------------------------------------------
    public function whs()
    {
        $data['whs'] =  $this->m_purchasing->tampil_whs_pur('');
        $this->template->display('purchasing/mstwarehouse', $data);
    }

    public function whs_edit()
    {
        $data['whs'] =  $this->m_purchasing->tampil_whs_where_pur(trim($this->uri->segment(3)));
        $this->template->display('purchasing/mstwarehouse_edit', $data);
    }

    public function whs_delete()
    {
        $this->m_purchasing->delete_whs_pur(trim($this->uri->segment(3)));
        $this->session->set_flashdata("message", "<div class=\"alert alert-warning\" id=\"alert\">Delete Data Success</div>");
        redirect('purchasing/whs');
    }

    public function whs_save()
    {
        $id        = trim($this->input->post('id'));
        $name      = $this->input->post('name');
        $contact   = $this->input->post('contact');
        $address   = nl2br($this->input->post('address'));
        $telephone = $this->input->post('telephone');

        if ($id == '') {
            $data = array(
                'name'        => $name,
                'contact'     => $contact,
                'address'     => $address,
                'telephone'   => $telephone,
                'createdby'   => strtoupper($this->session->userdata('userid_1')),
                'createddate' => date('Y-m-d H: i: s')
            );
            $query = $this->m_purchasing->simpan_whs_pur($data);
            $message = 'Save Data Success';
        } else {
            $data = array(
                'name'            => $name,
                'contact'         => $contact,
                'address'         => $address,
                'telephone'       => $telephone,
                'lastupdatedby'   => strtoupper($this->session->userdata('userid_1')),
                'lastupdateddate' => date('Y-m-d H: i: s')
            );
            $query = $this->m_purchasing->update_whs_pur($id, $data);
            $message = 'Update Data Success';
        }
        if ($query == 1) {
            $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
            redirect('purchasing/whs');
        } else {
            $this->session->set_flashdata("message", "<div class=\"alert alert-danger\" id=\"alert\">Transaction Broken</div>");
            redirect('purchasing/whs');
        }
    }

    //---------------------------------------------------------------------EXTRA-----------------------------------------------------
    public function convert($date)
    {
        $explode = explode("-", $date);

        $time = $explode[2] . '/' . $explode[0] . '/' . $explode[1];

        return $time;
    }

    //---------------------------------------------------------------------Not Used Code For Backup-----------------------------------------------------

    /*  public function vendor_group_save() {
        $id = $this->input->post('id');
        $group = $this->input->post('group');
        $coa_dps = $this->input->post('coa_dp_supplier');
        $coa_hut = $this->input->post('coa_hutang');
        $coa_wip = $this->input->post('coa_wip');
        $coa_piu = $this->input->post('coa_piutang');
        $coa_dpc = $this->input->post('coa_dp_customer');

        if ($id == '') {
            $data = array('group' => $group, 'nocoa_hutang' => $coa_hut,'nocoa_uang_muka_hutang' => $coa_dps,'nocoa_piutang' => $coa_piu,'nocoa_uang_muka_piutang' => $coa_dpc,'nocoa_hutang_wip' => $coa_wip,
                 'createdby' => strtoupper($this->session->userdata('userid_1')), 'createddate' => date('Y-m-d H:i:s'));
            $this->m_purchasing->simpan_vendor_group($data);
            $message = 'Save Data Success';
        } else {
            $data = array('group' => $group, 'nocoa_hutang' => $coa_hut,'nocoa_uang_muka_hutang' => $coa_dps,'nocoa_piutang' => $coa_piu,'nocoa_uang_muka_piutang' => $coa_dpc,'nocoa_hutang_wip' => $coa_wip,
                'lastupdatedby' => strtoupper($this->session->userdata('userid_1')), 'lastupdateddate' => date('Y-m-d H:i:s'));
            $this->m_purchasing->update_vendor_group($id, $data);
            $message = 'Update Data Success';
        }

        $this->session->set_flashdata("message", "<div class=\"alert alert-success\" id=\"alert\">$message</div>");
        redirect('purchasing/vendor_group');
    } */


    //--------------------------------------------------------------------END----------------------------------------------------------------
}
