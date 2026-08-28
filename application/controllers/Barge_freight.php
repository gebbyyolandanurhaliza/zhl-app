<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barge_freight extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        $this->load->model(array(
            'M_master_barge_freight' => 'barge_freight_model',
            'M_barge_freight' => 'm_barge_freight'
        ));
    }

    public function add()
    {
        $container   = $this->barge_freight_model->container();
        $destination = $this->barge_freight_model->destination();
        $con_type    = $this->barge_freight_model->container_type();
        $customer    = $this->m_barge_freight->get_cust();
        $vessel      = $this->barge_freight_model->vessel_list();

        $form_url = site_url('Barge_freight/insert');
        $btn_name = 'Save';

        $data = [
            'header_title' => 'Transaction Barge Freight',
            'container'    => $container,
            'destination'  => $destination,
            'customer'     => $customer,
            'con_type'     => $con_type,
            'form_url'     => $form_url,
            'btn_name'     => $btn_name,
            'vessel'       => $vessel,
            'action'       => 'add',
        ];

        $this->template->display('shipping/barge_freight/form', $data);
    }

    public function get_item()
    {
        $destination_id = $this->input->post('destination_id');
        $container_id   = $this->input->post('container_id');
        $con_type_id    = $this->input->post('con_type_id');
        $kode           = $this->input->post('kode');
        $data['kode']   = $kode;
        $data['items']  = $this->m_barge_freight->get_item($destination_id, $container_id, $con_type_id);

        if (!$data['items']) {
            echo "not found";
            exit();
        }

        $this->load->view('shipping/barge_freight/items', $data);
    }

    public function insert()
    {
        $input = $this->input->post(null, true);
        $by =  $this->session->userdata('namalengkap_1');

        if (isset($input['gst_check'])) {
            $input['gst_check'] = $input['gst_check'];
        } else {
            $input['gst_check'] = '';
        }

        $input_hdr = [
            // 'gst_reg_no'        => $input['gst_reg_no'],
            // 'inv_no'            => $input['inv_no'],
            // 'shipment_date'     => convert_tgl_db($input['shipment_date']),
            // 'ac_code'           => $input['ac_code'],
            'credit_term'       => $input['credit_term'],
            'vesel'             => $input['vesel'],
            'voyage_no'         => $input['voyage_no'],
            'customer_id'       => $input['customer_id'],
            'port_of_load'      => $input['port_of_load'],
            'ship_board_date'   => convert_tgl_db($input['ship_board_date']),
            'total_amount'      => str_replace(',', '', $input['total_amount']),
            'gst_value'         => str_replace(',', '', $input['gst_value']),
            'amount_due'        => str_replace(',', '', $input['amount_due']),
            'gst_check'         => $input['gst_check'],
            'created_by'        => $by,
            'created_at'        => tgl_db()
        ];

        $insert_hdr = $this->m_barge_freight->insert_hdr($input_hdr);

        if ($insert_hdr) {
            $hdr_id = $this->db->insert_id();
            $input_dtl = [];
            if (isset($input['description'])) {
                for ($i = 0; $i < count($input['description']); $i++) {
                    $input_dtl[] = [
                        'bargefreight_hdr_id' => $hdr_id,
                        'head'                => $input['head'][$i],
                        'row'                 => $input['row'][$i],
                        'jo_ref'              => $input['jo_ref'][$i],
                        'con_type_name'       => $input['con_type_name'][$i],
                        'pod'                 => $input['pod'][$i],
                        'uom'                 => $input['uom'][$i],
                        'description'         => $input['description'][$i],
                        'freight_desc_list'   => $input['freight_desc_list'][$i],
                        'freight_per_mt'      => $input['freight_per_mt'][$i],
                        'unit_price'          => str_replace(',', '', $input['unit_price'][$i]),
                        'qty'                 => str_replace(',', '', $input['qty'][$i]),
                        'amount'              => str_replace(',', '', $input['amount'][$i]),
                    ];
                }
                $insert_dtl = $this->m_barge_freight->insert_dtl($input_dtl);

                if ($insert_dtl) {
                    $this->session->set_flashdata('message', pesan('Insert data success', pesan_sukses()));
                    redirect('Barge_freight/edit/' . safe_b64encode($hdr_id), 'refresh');
                } else {
                    $this->session->set_flashdata('message', pesan('Failed to Insert Detail !', pesan_error()));
                    redirect('Barge_freight/add', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', pesan('Insert data success', pesan_sukses()));
                redirect('Barge_freight/edit/' . safe_b64encode($hdr_id), 'refresh');
            }
        } else {
            $this->session->set_flashdata('message', pesan('Failed Insert Data !', pesan_error()));
            redirect('Barge_freight/add', 'refresh');
        }
    }

    public function edit($id)
    {
        $id = safe_b64decode($id);

        $container   = $this->barge_freight_model->container();
        $destination = $this->barge_freight_model->destination();
        $con_type    = $this->barge_freight_model->container_type();
        $customer    = $this->m_barge_freight->get_cust();
        $vessel      = $this->barge_freight_model->vessel_list();

        $form_url    = site_url('Barge_freight/update/' . safe_b64encode($id));
        $btn_name    = 'Update';

        $data_hdr    = $this->m_barge_freight->get_hdr_byid($id);
        $data_dtl    = $this->m_barge_freight->get_dtl_byhdrid($id);

        if (!$data_hdr) redirect('Barge_freight/add');

        $data = [
            'header_title' => 'TRANSACTION BARGE FREIGHT',
            'container'    => $container,
            'destination'  => $destination,
            'con_type'     => $con_type,
            'form_url'     => $form_url,
            'btn_name'     => $btn_name,
            'data_hdr'     => $data_hdr,
            'data_dtl'     => $data_dtl,
            'customer'     => $customer,
            'vessel'       => $vessel,
            'action'       => 'edit',
        ];

        $this->template->display('shipping/barge_freight/form', $data);
    }

    public function update($id)
    {
        $id = safe_b64decode($id);
        $input = $this->input->post(null, true);
        $by =  $this->session->userdata('namalengkap_1');

        if (isset($input['gst_check'])) {
            $input['gst_check'] = $input['gst_check'];
        } else {
            $input['gst_check'] = '';
        }

        $data_hdr = [
            'credit_term'       => $input['credit_term'],
            'vesel'             => $input['vesel'],
            'voyage_no'         => $input['voyage_no'],
            'customer_id'       => $input['customer_id'],
            'port_of_load'      => $input['port_of_load'],
            'ship_board_date'   => convert_tgl_db($input['ship_board_date']),
            'total_amount'      => str_replace(',', '', $input['total_amount']),
            'gst_value'         => str_replace(',', '', $input['gst_value']),
            'amount_due'        => str_replace(',', '', $input['amount_due']),
            'gst_check'         => $input['gst_check'],
            'updated_by'        => $by,
            'updated_at'        => tgl_db()
        ];

        $this->m_barge_freight->update_hdr($data_hdr, $id);

        // proses delete item ketika save
        if (count($input['bargefreight_dtl_id']) > 0) {

            $dtl_now = $input['bargefreight_dtl_id'];

            $all_id_dtl = $this->m_barge_freight->get_all_dtl_id($id);

            $dtl_old = [];
            if ($all_id_dtl) {
                foreach ($all_id_dtl as $id_dtl) {
                    $dtl_old[] = $id_dtl->bargefreight_dtl_id;
                }
            }
            $id_dtl_array = array_diff($dtl_old, $dtl_now);

            if ($id_dtl_array) {
                $this->m_barge_freight->delete_items($id_dtl_array);
            }
        }


        $update_dtl = [];
        $insert_dtl = [];

        for ($i = 0; $i < count($input['description']); $i++) {
            if (isset($input['bargefreight_dtl_id'][$i])) {
                $update_dtl[] = [
                    'bargefreight_dtl_id' => $input['bargefreight_dtl_id'][$i],
                    'head'                => $input['head'][$i],
                    'row'                 => $input['row'][$i],
                    'jo_ref'              => $input['jo_ref'][$i],
                    'con_type_name'       => $input['con_type_name'][$i],
                    'pod'                 => $input['pod'][$i],
                    'uom'                 => $input['uom'][$i],
                    'description'         => $input['description'][$i],
                    'freight_desc_list'   => $input['freight_desc_list'][$i],
                    'freight_per_mt'      => $input['freight_per_mt'][$i],
                    'unit_price'          => str_replace(',', '', $input['unit_price'][$i]),
                    'qty'                 => str_replace(',', '', $input['qty'][$i]),
                    'amount'              => str_replace(',', '', $input['amount'][$i]),
                ];
            } else {
                $insert_dtl[] = [
                    'bargefreight_hdr_id' => $id,
                    'head'                => $input['head'][$i],
                    'row'                 => $input['row'][$i],
                    'jo_ref'              => $input['jo_ref'][$i],
                    'con_type_name'       => $input['con_type_name'][$i],
                    'pod'                 => $input['pod'][$i],
                    'uom'                 => $input['uom'][$i],
                    'description'         => $input['description'][$i],
                    'freight_desc_list'   => $input['freight_desc_list'][$i],
                    'freight_per_mt'      => $input['freight_per_mt'][$i],
                    'unit_price'          => str_replace(',', '', $input['unit_price'][$i]),
                    'qty'                 => str_replace(',', '', $input['qty'][$i]),
                    'amount'              => str_replace(',', '', $input['amount'][$i]),
                ];
            }
        }

        if ($update_dtl) {
            $this->m_barge_freight->update_batch_dtl($update_dtl);
        }

        if ($insert_dtl) {
            $this->m_barge_freight->insert_dtl($insert_dtl);
        }

        $id = safe_b64encode($id);

        if ($insert_dtl || $update_dtl) {
            $this->session->set_flashdata('message', pesan('Update data success', pesan_sukses()));
            redirect('Barge_freight/edit/' . $id, 'refresh');
        } else {
            $this->session->set_flashdata('message', pesan('Failed update detail data ', pesan_error()));
            redirect('Barge_freight/edit/' . $id, 'refresh');
        }
    }

    public function find()
    {
        $search = $this->input->post('search');
        $list = $this->m_barge_freight->find($search);
        $data = [
            'list' => $list
        ];
        $this->load->view('shipping/barge_freight/list_find', $data);
    }

    public function delete($id)
    {
        $id = safe_b64decode($id);
        $by =  $this->session->userdata('namalengkap_1');

        $data = [
            'deleted_by' => $by,
            'deleted_at' => tgl_db()
        ];

        $delete = $this->m_barge_freight->update_hdr($data, $id);

        if ($delete) {
            $this->session->set_flashdata('message', pesan('Delete data success', pesan_sukses()));
        } else {
            $this->session->set_flashdata('message', pesan('Failed delete data ', pesan_error()));
        }
        redirect('barge_freight/add');
    }

    public function print_pdf($id)
    {
        $id = safe_b64decode($id);

        $data_hdr = $this->m_barge_freight->get_hdr_byid($id);
        $data_dtl = $this->m_barge_freight->get_dtl_byhdrid($id);
        $costumer = $this->m_barge_freight->get_cust_row($data_hdr->customer_id);

        $path = './assets/zhl-kop.PNG';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $header['logo'] = 'data:image/png' . $type . ';base64,' . base64_encode($data);
        $header['pt_name'] = 'SINDO DAMAI SHIPPING PTE LTD';
        $header['title'] = 'TAX INVOICE';
        $header['boc_no'] = $data_hdr->gst_reg_no;

        $data = [
            'hdr'      => $data_hdr,
            'dtls'     => $data_dtl,
            'header'   => $header,
            'costumer' => $costumer
        ];

        $this->load->library('pdfgenerator');
        $html = $this->load->view('shipping/barge_freight/print_pdf', $data, true);
        $this->pdfgenerator->createPDF($html, 'Tax Invoice', false);
    }
}

/* End of file Controllername.php */
