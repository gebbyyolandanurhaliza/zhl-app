<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tims_invoice extends CI_Controller
{

  function __construct()
  {
    parent::__construct();

    $this->load->model(array('M_Tims' => 'm_tims', 'M_Receivable_recognition', 'M_login', 'M_mar_master'));
    $this->load->library(array('template', 'user_agent'));

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }
  }


  public function index()
  {
    $data['SupplierID']     = $this->m_tims->get_sup();
    $data['List_invoice']   = $this->m_tims->get_inv();
    $data['title']          = "List of Customer Invoice";


    $this->template->display('accounting/Tims/customer_invoice', $data);
  }
  function add_new()
  {

    $data               =  array(
      'cbo_customer'    => $this->m_tims->get_customer(),
      'cbo_currency'    => $this->m_tims->get_currency(),
      'message'         => $this->session->flashdata('message'),
      'action'          => site_url('Tims_invoice/save'),
      'Noinv'           => set_value('nofaktur', "", false),
      'readonly'        => 'readonly',
      'disable'         => '',
      'kode_sup'        => '',
      'rate'            => '',
      'rate_sgd'        => '',
      'Currency'        => '',
      'Customer_code'   => '',
      'Term'            => '0',
      'Shipper'         => '',
      'Reff'            => '',
      'type'            => '',
      'Invoice_date'    => set_value('tgl_invoice', date('d/m/Y'), true),
      'Currency_symbol' => '',
      'date_of_journal' => set_value('tgl_jurnal', date('d/m/Y'), true),
      'tgl_tempo'       => set_value('tgl_tempo', date('d/m/Y'), true),
      'Vessel'          => '',
      'Total'           => set_value('total', '', true),
      'Freight'         => set_value('freight', '0.0', true),
      'Tax'             => set_value('amount_tax', '', true),
      'Total_amount'    => set_value('amount_due', '', true),
      'Address'         => set_value('address', '', false),
      'Country'         => set_value('country', '', false),
      'currency'         => set_value('currency', 'SGD', false),
      'po_number'         => set_value('po_number', '', false),
      'submit_value'    => 'Save',
    );

    $this->template->display('accounting/Tims/invoice_customer_form', $data);
  }


  function get_item()
  {
    $keyword = $this->uri->segment(3);

    $data = $this->db->from('zhl_tims_mst_item')->like('Description', $keyword)->get();

    foreach ($data->result() as $row) {
      $arr['query'] = $keyword;
      $arr['suggestions'][] = array(
        'value' =>  $row->Description,
        // 'value' => $row->Item_number . " | " . $row->Description,
        'Item_number' => $row->Item_number,
        'Description' => $row->Description
      );
    }
    // minimal PHP 5.2
    echo json_encode($arr);
  }

  function get_selectedCustomer()
  {
    $get_customerId = $this->input->get('id');

    $response = $this->m_tims->get_customerId($get_customerId);

    echo json_encode($response);
  }

  function save()
  {
    $data = $this->input->post(null, true);

    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');

    $nofaktur = '';

    if (empty($data['nofaktur'])) {
      $tgl_invoice = convert_tgl_db_2($data['tgl_invoice']);
      $p_tahun = date('Y', strtotime($tgl_invoice));
      $p_bulan = date('m', strtotime($tgl_invoice));

      $sql_faktur = $this->m_tims->get_nofaktur($p_tahun, $p_bulan);
      $nofaktur = $sql_faktur;
    }

    $data_hdr = [
      'Noinv'         => $nofaktur,
      'Customer_code' => $data['Customer_code'],
      'Address'       => $data['address'],
      'Country'       => $data['country'],
      'Vessel'        => $data['vessel'],
      'currency'      => $data['currency'],
      'Term'          => $data['term'],
      'Shipper'       => $data['shipper'],
      'Reff'          => $data['reff'],
      'Total'         => $data['total'],
      'Freight'       => $data['freight'],
      'type_trans'       => $data['JenisJurnal'],
      'Tax'           => $data['amount_tax'],
      'Total_amount'  => $data['amount_due'],
      'po_number'     => $data['po_number'],
      'Invoice_date'  => convert_tgl_db_2($data['tgl_invoice']),
      'Delivery_date' => convert_tgl_db_2($data['tgl_tempo']),
      'Jurnal_date'   => convert_tgl_db_2($data['tgl_jurnal']),
      'createdby'     => $createdby,
      'createddate'   => $createddate
    ];


    $id_inv_hdr = $this->m_tims->save_inv_hdr($data_hdr);


    for ($i = 0; $i < count($this->input->post('Detail_item_id')); $i++) {
      $data_dtl[] = [
        'Header_id'     => $id_inv_hdr,
        'Backorder'     => $data['Backorder'][$i],
        'Job'           => $data['job'][$i],
        'Item_desc'     => $data['Item_number'][$i],
        'Qty'           => $data['Ship'][$i],
        'Price'         => $data['Price'][$i],
        'Amount'        => $data['Amount'][$i],
        'Discount'      => $data['Discount'][$i],
        'Tax_type'      => $data['txtGST'][$i],
        'Tax_value'     => $data['txtGSTValue'][$i]
      ];
    }

    $save_dtl = $this->m_tims->save_inv_dtl($data_dtl);

    if (!$save_dtl) {
      $this->session->set_flashdata('message', pesan('Save Invoice Job', pesan_error()));
    } else {
      $this->session->set_flashdata('message', pesan('Save Invoice Job', pesan_sukses()));
    }
    redirect(site_url("Tims_invoice/Edit?id=$id_inv_hdr"));
  }


  public function Edit()
  {

    $id = $this->input->get("id");
    //  $id	= decode_str($this->input->get('id'));

    $hdr = $this->m_tims->get_inv_hdr($id);
    $dtl = $this->m_tims->get_inv_dtl($id);
    $cbo_customer      = $this->m_tims->get_customer();
    $cbo_currency      = $this->m_tims->get_currency();

    if (!$id) {
      redirect(site_url('Tims_invoice/add_new'));
    }

    $data = [
      'message'               => $this->session->flashdata('message'),
      'cbo_customer'          =>  $cbo_customer,
      'cbo_currency'          =>  $cbo_currency,
      'currency'              => set_value('currency', $hdr->Currency),
      'button'                => '<i class="fa fa-save fa-3x fa-fw"></i> Update',
      'action'                => site_url('Tims_invoice/Update/' . $id),
      'Noinv'                 => set_value('nofaktur', $hdr->Noinv, true),
      'Address'               => set_value('address', $hdr->Address, true),
      'Country'               => set_value('country', $hdr->Country, true),
      'readonly'              => 'readonly',
      'disable'               => '',
      'supplier_id'           => '',
      'kode_sup'              => '',
      'currency_id'           => '',
      'rate'                  => '',
      'rate_sgd'              => '',
      'term'                  => '',
      'type'                  => set_value('type', $hdr->type_trans, true),
      'Shipper'               => set_value('shipper', $hdr->Shipper, true),
      'po_number'               => set_value('po_number', $hdr->po_number, true),
      'Reff'                  => set_value('reff', $hdr->Reff, true),
      'Invoice_date'          => set_value('tgl_invoice', convert_tgl_2($hdr->Invoice_date), true),
      'Currency_symbol'       => '',
      'date_of_journal'       => '',
      'tgl_tempo'             => set_value('tgl_tempo', convert_tgl_2($hdr->Delivery_date), true),
      'submit_value'          => 'Update',
      'dtl'                   => $dtl,
      'Customer_code'         => set_value('Customer_code', $hdr->Customer_code),
      'Total'                 => set_value('total', $hdr->Total, true),
      'Term'                  => set_value('term', $hdr->Term, true),
      'Vessel'                => set_value('vessel', $hdr->Vessel, true),
      'Freight'               => set_value('freight', $hdr->Freight, true),
      'Tax'                   => set_value('amount_tax', $hdr->Tax, true),
      'Total_amount'          => set_value('amount_due', $hdr->Total_amount, true),
    ];

    $this->template->display('accounting/Tims/invoice_customer_form', $data);
  }



  public function Update($id)
  {
    $data = $this->input->post(null, true);
    $createdby = strtoupper($this->session->userdata('userid_1'));
    $createddate = date('Y-m-d H:i:s');


    // update header
    $data_hdr = [
      'Customer_code' => $data['Customer_code'],
      'Address'       => $data['address'],
      'Country'       => $data['country'],
      'Vessel'        => $data['vessel'],
      'currency'      => $data['currency'],
      'Term'          => $data['term'],
      'Shipper'       => $data['shipper'],
      'Reff'          => $data['reff'],
      'Total'         => $data['total'],
      'Freight'       => $data['freight'],
      'Tax'           => $data['amount_tax'],
      'Total_amount'  => $data['amount_due'],
      'po_number'     => $data['po_number'],
      'Invoice_date'  => convert_tgl_db_2($data['tgl_invoice']),
      'Delivery_date' => convert_tgl_db_2($data['tgl_tempo']),
      'Jurnal_date'   => convert_tgl_db_2($data['tgl_jurnal']),
      'Updateby' => $createdby,
      'Updatedate' => $createddate
    ];

    $this->m_tims->update_inv_hdr($data_hdr, $id);

    for ($i = 0; $i < count($data['Detail_item_id']); $i++) {
      if (isset($data['Detail_item_id'][$i])) {
        if ($data['Detail_item_id'][$i] == '') {
          // Insert new data
          $data_dtl_insert[] = [
            'Header_id' => $id,
            'Backorder' => $data['Backorder'][$i],
            'Job' => $data['job'][$i],
            'Item_desc' => $data['Item_number'][$i],
            'Qty' => $data['Ship'][$i],
            'Price' => $data['Price'][$i],
            'Amount' => $data['Amount'][$i],
            'Discount' => $data['Discount'][$i],
            'Tax_type' => $data['txtGST'][$i],
            'Tax_value' => $data['txtGSTValue'][$i]
          ];
        } else {
          // Update existing data
          $data_dtl_update[] = [
            'Header_id' => $id,
            'Detail_id' => $data['Detail_item_id'][$i],
            'Backorder' => $data['Backorder'][$i],
            'Job' => $data['job'][$i],
            'Item_desc' => $data['Item_number'][$i],
            'Qty' => $data['Ship'][$i],
            'Price' => $data['Price'][$i],
            'Amount' => $data['Amount'][$i],
            'Discount' => $data['Discount'][$i],
            'Tax_type' => $data['txtGST'][$i],
            'Tax_value' => $data['txtGSTValue'][$i]
          ];
        }
      }
    }

    if (!empty($data_dtl_insert)) {
      $save = $this->m_tims->save_inv_dtl($data_dtl_insert);
    }

    if (!empty($data_dtl_update)) {
      $update = $this->m_tims->update_inv_dtl($data_dtl_update);
    }


    $this->session->set_flashdata('message', pesan('Update Invoice Job', pesan_sukses()));
    redirect(site_url("Tims_invoice/Edit?id=$id"));
  }


  function delete_transaction()
  {
    $id = $this->input->get("id");

    $this->m_tims->delete_invoice($id);
    redirect("Tims_invoice");
  }


  function print_report()
  {
    $id  = decode_str($this->input->get('id'));

    $data = array(
      'rec_hdr' => $this->m_tims->get_inv_hdr_id($id),
      'dtl' => $this->m_tims->get_inv_dtl($id),

    );
    $this->load->view('accounting/rpt/rpt_tims_invoice', $data);
  }

  function print_report_zht()
  {
    $id	= decode_str($this->input->get('id'));
 


      $data= array(
          'rec_hdr' =>$this->m_tims->get_inv_hdr_id($id),
          'dtl' =>$this->m_tims->get_inv_dtl($id),

       );


      $this->load->view('accounting/rpt/rpt_tims_invoice_zht', $data);
  }

  function tampil_job()
  {
    $customer = $this->input->get("cust");

    $data["list_job"] = $this->m_tims->tampil_job_list($customer);


    $this->load->view('accounting/ajax/Tampil_job', $data);
  }

  function search()
  {
    $data['SupplierID'] = $this->M_Receivable_recognition->get_sup();
    $invoice            = $this->input->get("invoice");
    $dari               = str_replace('/', '-', $this->input->get('dari'));
    $p_dari             = date('Y-m-d', strtotime($dari));
    $sampai             = str_replace('/', '-', $this->input->get("sampai"));
    $p_sampai           = date('Y-m-d', strtotime($sampai));
    $supplier           = $this->input->get("supplier");

    $data['tgl'] = $dari;
    if ($dari != '') {
      $data['List_invoice'] = $this->m_tims->advance_list_piutang($p_dari, $p_sampai, $invoice, $supplier);
    } else {
      $data['List_invoice'] = $this->m_tims->advance_list_invoice($invoice, $supplier);
    }
    $this->template->display('accounting/Tims/customer_invoice', $data);
  }

  function tampil_item_cust()
  {
    $customer = $this->input->get("cust");
    $data["item"] = $this->m_tims->get_id_customer_transport_dtl_code($customer);
    $this->load->view('accounting/ajax/tampil_item_cust', $data);
  }

  function tampil_ap_cust()
  {
    $customer = $this->input->get("cust");
    $data["ap"] = $this->m_tims->get_id_ap_dtl_code($customer);
    $this->load->view('accounting/ajax/tampil_ap_cust', $data);
  }
}
