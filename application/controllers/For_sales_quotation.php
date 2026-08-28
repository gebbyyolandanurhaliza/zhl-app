<?php defined('BASEPATH') or exit('No direct script access allowed');

class For_sales_quotation extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->model(
            array(
                'M_for_sales_quotation'
            )
        );
    }

    function issue()
    {
        $cbo_customer       = $this->M_for_sales_quotation->get_cust();
        $cbo_payterm        = $this->M_for_sales_quotation->get_cust_payterm();
        $cbo_country        = $this->M_for_sales_quotation->get_country();
        $cbo_port           = $this->M_for_sales_quotation->get_port();
        $cbo_tradingterm    = $this->M_for_sales_quotation->get_tradingterm();
        $cbo_currency       = $this->M_for_sales_quotation->get_currency();
        $cbo_sales          = $this->M_for_sales_quotation->sales_person_get_all();
        

        $data = array(
            'datafilter'                 => '',
            'message'                    => $this->session->flashdata('message'),
            'act'                        => set_value('act', 'add'),
            'action'                     => site_url('for-sales-quotation/submit'),
            'header_title'               => 'Sales Quotation',
            'submit_caption'             => 'Save',
            'current_date'               => date('m-d-Y'),
            'cbo_customer'               => $cbo_customer,
            'cbo_currency'               => $cbo_currency,
            'cbo_marketing'              => $cbo_marketing,
            'cbo_sales'                  => $cbo_sales,
            'cbo_agent'                  => $cbo_agent,
            'cbo_status'                 => $cbo_status,
            'cbo_payterm'                => $cbo_payterm,
            'detail'                     => '',
            'btn_print'                  => '<a href="#" class="btn btn-warning" id="btn_print" disabled><i class="fa fa-print"></i> Print ...</a>',
            'btn_delete'                 => '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="0" disabled>',
            'quotation_hdr_id'           => set_value('quotation_hdr_id', '0', true),
            'quotation_number'           => set_value('quotation_number', '', true),
            'customer_id'                => set_value('customer_id', '', true),
            'customer_name'              => set_value('customer_name', '', true),
            'customer_contact_name'      => set_value('customer_contact_name', '', true),
            'customer_reference'         => set_value('customer_reference', '', true),
            'local_currency'             => set_value('local_currency', '', true),
            'rate_usd'                   => set_value('rate_usd', '', true),
            'rate_sgd'                   => set_value('rate_sgd', '', true),
            'sales_id'                   => set_value('sales_id', $this->session->userdata('userid'), true),
            'status_id'                  => set_value('status_id', '0', true),
            'payment_term_id'            => set_value('payment_term_id', '', true),
            'document_date'              => set_value('document_date', date('d/m/Y'), true),
            'validity_date'              => set_value('validity_date', date('d/m/Y'), true),
            'total_before_disc'          => set_value('total_before_disc', '', true),
            'discount'                   => set_value('discount', '', true),
            'total_disc'                 => set_value('total_disc', '', true),
            
            'tax'                        => set_value('tax', '', true),
            'final_total'                => set_value('final_total', '', true),
            'quotation_remark'           => set_value('quotation_remark', '', true),
            //Additional Info
            'cbo_tradingterm'            => $cbo_tradingterm,
            'trading_term_id'            => set_value('trading_term_id', '', true),
            'shipment_from'              => set_value('shipment_from', '', true),
            'cbo_destination'            => $cbo_country,
            'cbo_port'                   => $cbo_port,
            'cbo_container'              => $cbo_container,
            'cbo_shipping_line'          => $cbo_shipping_line,
            'destination_id'             => set_value('destination_id', '', true),
            'port_id'                    => set_value('port_id', '', true),
            'container_id'               => set_value('container_id', '', true)
        );

        $this->template->display('forwarding/quotation/issue', $data);
    }

    function get_customer()
    {

        if ('IS_AJAX') {
            $customer_id = $this->input->post('customer_id');
            $customer = $this->M_for_sales_quotation->get_cust_by_id($customer_id);

            $data = array(
                'customer_name' => set_value('customer_name', isset($customer->customer_name) ? $customer->customer_name : '', true),
                'customer_contact_name' => set_value('customer_contact_name', isset($customer->customer_contact_name) ? $customer->customer_contact_name : '', true),
                'customer_reference' => set_value('customer_reference', isset($customer->customer_reference) ? $customer->customer_reference : '', true),
            );

            echo json_encode($data);
        }
    }

    function get_payterm_by_customer()
    {
        if ('IS_AJAX') {
            $customer_id = $this->input->post('customer_id');
            $cbo_payterm = $this->M_for_sales_quotation->get_cust_payterm_by_id($customer_id);

            $data = array(
                'cbo_payterm'    => $cbo_payterm,
            );
            echo json_encode($data);
        }
    }

    function get_rate()
    {
        $rate           = $this->M_for_sales_quotation->get_rate();
        $rate_is_set    = $this->M_for_sales_quotation->rate_is_set();

        if ($rate) {
            $data = array(
                'rate_usd'    => $rate->rate_usd,
                'rate_sgd'    => $rate->rate_kurs,
                'rate_is_set' => $rate_is_set,
            );
        } else {
            $data = array(
                'rate_usd'    => '',
                'rate_sgd'    => '',
                'rate_is_set' => $rate_is_set,
            );
        }

        echo json_encode($data);
    }

    function get_port()
    {
        if ('IS_AJAX') {
            $country_id = $this->input->post('destination_id');
            $ids        = $this->M_for_sales_quotation->get_ids($country_id);
            $cbo_port   = $this->M_for_sales_quotation->port_get_by_ids($ids);

            $data = array(
                'cbo_port' => $cbo_port,
                'port_id' => set_value('port_id', '', true),
            );

            echo json_encode($data);
        }
    }

    

    function submit()
    {
        $act = $this->input->post('act');
        if ($act == 'add') {
            $submit_result = $this->M_for_sales_quotation->insert();
            $perintah = 'Saving';
        } else {
            $submit_result = $this->M_for_sales_quotation->update();
            $perintah = 'Updating';
        }

        if ($submit_result > 0) {
            $row = $this->M_for_sales_quotation->sp_get_by_id($submit_result);
            $pdf_link = site_url('for-sales-quotation/issue/?id=' . encode_str($row->quotation_hdr_id) . '&no=' . encode_str($row->quotation_number) . '&dt=' . encode_str(date('d-M-Y', strtotime($row->document_date))));
            $extra = "<a href='" . site_url('for-sales-quotation/issue') . "' class='btn btn-success'><i class='fa fa-arrow-right'></i> Go To Next STep ???</a>";
            $this->session->set_flashdata('message', pesan($perintah . ' Sales Quotation <strong>' . $row->quotation_number . '</strong>', pesan_sukses(), $pdf_link, $extra));
        } else {
            $this->session->set_flashdata('message', pesan('Failed create Sales Quotation.', pesan_error()));
        }
        redirect(site_url('for-sales-quotation/issue'));
    }

    // function delete()
    // {
    //     $this->M_for_sales_quotation->delete();
    // }

    function find()
    {
        $data = array(
            'find_record' => $this->M_for_sales_quotation->find_quotation(),
        );
        echo json_encode($data);
    }

    function show_find()
    {
        $id                 = ($this->input->get('id'));
        $row                = $this->M_for_sales_quotation->sp_get_by_id($id);
        $detail             = $this->M_for_sales_quotation->get_detail($id);
        $cbo_customer       = $this->M_for_sales_quotation->get_cust();
        $cbo_payterm        = $this->M_for_sales_quotation->get_cust_payterm();
        $cbo_country        = $this->M_for_sales_quotation->get_country();
        $cbo_port           = $this->M_for_sales_quotation->get_port();
        $cbo_tradingterm    = $this->M_for_sales_quotation->get_tradingterm();
        $cbo_currency       = $this->M_for_sales_quotation->get_currency();
        $cbo_sales          = $this->M_for_sales_quotation->sales_person_get_all();
        $cbo_charge          = $this->M_for_sales_quotation->get_for_charge_all();


        $data = array(
            'datafilter'                 => '',
            'message'                    => $this->session->flashdata('message'),
            'act'                        => set_value('act', 'edit'),
            'action'                     => site_url('for-sales-quotation/submit'),
            'header_title'               => 'Sales Quotation',
            'submit_caption'             => 'Update',
            'current_date'               => date('m-d-Y'),
            'cbo_customer'               => $cbo_customer,
            'cbo_currency'               => $cbo_currency,
            'cbo_marketing'              => $cbo_marketing,
            'cbo_sales'                  => $cbo_sales,
            'cbo_agent'                  => $cbo_agent,
            'cbo_status'                 => $cbo_status,
            'cbo_payterm'                => $cbo_payterm,
            'cbo_charge'                 => $cbo_charge,
            'detail'                     => $detail ,
            'btn_print'             => '<a href="' . site_url('for-sales-quotation/generate-pdf/?id=' . encode_str($row->quotation_hdr_id)) . '&no=' . encode_str($row->quotation_number) . '&dt=' . encode_str(date('d-M-Y', strtotime($row->document_date))) . '" class="btn btn-warning" id="btn_print" target="_blank"><i class="fa fa-print"></i> Print ...</a>',
            'btn_delete'            => '<input type="button" class="btn btn-danger fontawesome-font" value="&#xf014 Delete" id="btn_delete" headerid="' . encode_str($id) . '" data-number="' . $row->quotation_number . '">',
            'quotation_hdr_id'      => set_value('quotation_hdr_id', encode_str($id), true),
            'quotation_number'      => set_value('quotation_number', $row->quotation_number, true),
            'customer_id'           => set_value('customer_id', $row->customer_id, true),
            'customer_name'         => set_value('customer_name', $row->customer_name, true),
            'customer_contact_name' => set_value('customer_contact_name', $row->customer_contact_name, true),
            'customer_reference'    => set_value('customer_reference', $row->customer_reference, true),
            'local_currency'        => set_value('local_currency', $row->currency_id, true),
            'rate_usd'              => set_value('rate_usd', $row->rate_usd, true),
            'rate_sgd'              => set_value('rate_sgd', $row->rate_sgd, true),
            'sales_id'              => set_value('sales_id', $row->sales_id, true),
            'status_id'             => set_value('status_id', $row->status_id, true),
            'payment_term_id'       => set_value('payment_term_id', $row->payment_term_id, true),
            'payment_term'          => set_value('payment_term', $row->payment_terms, true),
            'document_date'         => set_value('document_date', tgl_ind($row->document_date), true),
            'validity_date'         => set_value('validity_date', tgl_ind($row->validity_date), true),
            'total_before_disc'     => set_value('total_before_disc', number_format($row->total_before_disc, 2, '.', ','), true),
            'discount'              => set_value('dicount', $row->discount, true),
            'total_disc'            => set_value('total_disc', number_format($row->total_disc, 2, '.', ','), true),
            
            'tax'                   => set_value('tax', $row->tax, true),
            'final_total'           => set_value('final_total', number_format($row->final_total, 2, '.', ','), true),
            'quotation_remark'      => set_value('quotation_remark', $row->quotation_remark, true),
            //Additional Info
            'cbo_tradingterm'            => $cbo_tradingterm,
            'trading_term_id'       => set_value('trading_term_id', $row->trading_term_id, true),
            'shipment_from'         => set_value('shipment_from', $row->shipment_from, true),
            'cbo_destination'            => $cbo_country,
            'cbo_port'                   => $cbo_port,
            'cbo_container'              => $cbo_container,
            'cbo_shipping_line'          => $cbo_shipping_line,
            'destination_id'        => set_value('destination_id', $row->destination_id, true),
            'port_id'               => set_value('port_id', $row->port_id, true),
            'container_id'          => set_value('container_id', $row->container_id, true),
        );

        $this->template->display('forwarding/quotation/issue', $data);
    }

    // function previous_remark()
    // {
    //     $customer_id = $this->input->post('customer_id');
    //     $data_quote = $this->M_for_sales_quotation->get_previous_remark($customer_id);

    //     $data = array(
    //         'rec_prev'    => $data_quote,
    //     );

    //     $this->load->view('marketing/quotation/pre_find', $data);
    // }

    function generate_pdf()
    {
        $header_id = decode_str($this->input->get('id'));
        $data = array(
            'cbo_currency'  => $this->M_for_sales_quotation->get_currency(),
            'cbo_port'      => $this->M_for_sales_quotation->get_port(),
            'record_header' => $this->M_for_sales_quotation->sp_get_by_id($header_id),
            'record_detail' => $this->M_for_sales_quotation->get_detail($header_id),
        );

        $this->load->view('forwarding/quotation/print', $data);
    }

    // function loadDataAjaxForSelectBrand()
    // {
    //     $data   = array(
    //         '_selectBrand'  => $this->M_for_sales_quotation->getBrandForQuotation()
    //     );
    //     $this->load->view('marketing/quotation/selectBrand', $data);
    // }

    // function loadDataAjaxForSelectProduct()
    // {
    //     $param = $this->input->post('param');
    //     $data['_selectProduct'] = $this->M_mar_product->product_get_by_search($param);
    //     $this->load->view('marketing/quotation/selectProduct', $data);
    // }

    // // MONITOR
    // private function monitor_old($status = '')
    // {
    //     $count_open        = $this->M_for_sales_quotation->get_count_status(0);
    //     $count_confirm    = $this->M_for_sales_quotation->get_count_status(1);

    //     $monitor_data    = $this->M_for_sales_quotation->get_monitor($status);

    //     $data = array(
    //         'count_open'    => $count_open,
    //         'count_confirm'    => $count_confirm,
    //         'monitor_data'    => $monitor_data,
    //     );

    //     $this->template->display('marketing/quotation/mon_quotation', $data);
    // }

    // function monitor($status = '')
    // {
    //     $count_open     = $this->M_for_sales_quotation->get_count_status2(0);
    //     $count_confirm  = $this->M_for_sales_quotation->get_count_status2(1);

    //     // $monitor_data    = $this->M_for_sales_quotation->get_monitor($status);
    //     $monitor_data   = $this->M_for_sales_quotation->get_monitor2();

    //     $data = array(
    //         'count_open'    => $count_open->count_quotation_hdr_id,
    //         'count_confirm' => $count_confirm->count_quotation_hdr_id,
    //         'monitor_data'  => $monitor_data,
    //     );

    //     $this->template->display('marketing/quotation/mon_quotation', $data);
    // }


    // //===========Tambah by Ikbal tapi sudah tidak di pakai lagi========//
    // // function filterportcont(){

    // //     $data['hasilfilter'] = $this->M_mar_master->list_master_freight($this->input->get('port'),$this->input->get('cont'),$this->input->get('trading'),$this->input->get('cust'));
    // //     $this->load->view('marketing/quotation/issue_filter',$data);
    // // }
    // //===========Tambah by Ikbal=======//

    // //UPDATE 29 JANUARI 2022
    // function filterportcont()
    // {

    //     $data['hasilfilter'] = $this->M_mar_master->list_master_freight($this->input->get('port'), $this->input->get('cont'), $this->input->get('trading'), $this->input->get('cust'));
    //     $this->load->view('marketing/quotation/issue_filter', $data);
    // }
}
