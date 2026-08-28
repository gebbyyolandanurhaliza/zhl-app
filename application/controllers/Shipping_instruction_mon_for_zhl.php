<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class shipping_instruction_mon_for_zhl extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('M_shipping'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library(array('Fpdf','PHPExcel'));
        
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

//===========================E-Form===============================================
    public function index(){
            // $data['doc_id'] = $this->m_eform->get_document();
            // $data['cust']   = $this->m_eform->get_cust();
            // $this->template->display('eform/index', $data);

                // $cbo_factory        = $this->M_gen_master->get_all('factory2');
                // $cbo_customer       = $this->M_master->cust_get_all_active();
                // $cbo_port           = $this->M_master->port_get_all();  
                // $cbo_sales_marketing = $this->M_master->sales_marketing_active();



                $data = array(
                    'message'           => $this->session->flashdata('no_si_msg'),
                    'record_mon'        => '',
                    'cbo_factory'       => '',
                    'factory_abbr'      => set_value('factory_abbr'),
                    'cbo_customer'      => '',
                    'customer_name'     => set_value('customer_name'),
                    'cbo_port'          => '',
                    'port_name'         => set_value('port_name'),
                    // 'cbo_product_category' => $cbo_product_category,
                    // 'product_category_name' => set_value('product_category_name'),                   
                    'cbo_sales_marketing' => '',
                    'sales_marketing'     => set_value('sales_marketing'),
                    'current_date'        => date('d/m/Y'),
                    'schedule_date1'      => date('01/m/Y'),
                    'schedule_date2'      => date('t/m/Y')
                    
                );

                $this->template->display('marketing/transactions/shipping_instruction/mon_si_index', $data);
    }

    function monitor_filtered(){
                $record = $this->M_shipping->monitor_filter();
                $data = array(
                    'record_mon'    => $record,
                );

                $this->load->view('marketing/transactions/shipping_instruction/mon_si_filtered', $data);     

                //print_r($data);   
    }

    function monsi_report()
    {
        $param_search   = $this->input->get('param_search');
        $schedule_date1 = $this->input->get('schedule_date1');
        $schedule_date2 = $this->input->get('schedule_date2');

        $data['record'] =  $this->M_shipping->monitor_filter_excel($param_search,$schedule_date1,$schedule_date2);
        $this->load->view('marketing/transactions/shipping_instruction/si_batch_excel', $data);

        // print_r($data['record'] );
    }

function batch_print(){
                    $si_count   = count($this->input->post('chk_si'));
                    $ship_id    = $this->input->post('chk_si');

                    $a = 0;
                    $total_si = 0;
                    $selected_si = array();
                    if (!empty($ship_id)){
                        for($i=0; $i < $si_count; $i++){
                            if (isset($ship_id[$i])){
                                array_push($selected_si, $ship_id[$a]);
                                $a++;
                                $total_si++;
                            }
                        }
                    }

                    if ($total_si > 0){
                        $hdr        = array();
                        $rec_hdr    = array();
                        $rec_doc    = array();
                        $rec_doc_s  = array();
                        $agent      = array();
                        $mix_po     = array();
                        $get_list_po = array();
                        $rec_dtl    = array();
                        $inward     =array ();

                        for ($i = 0; $i < $total_si; $i++){
                            $header_id          = $selected_si[$i];
                            $rec_hdr[$i]        = json_encode($this->M_shipping->sp_prt_hdr($header_id));
                            $rec_doc[$i]        = json_encode($this->M_shipping->sp_get_view_document($header_id));
                            $rec_doc_s[$i]      = json_encode($this->M_shipping->sp_get_view_document($header_id, 1));
                            $agent[$i]          = json_encode($this->M_shipping->get_agent_for_print($header_id)->row());
                            $obj_mix_po         = $this->M_shipping->sp_get_detail_po($header_id);
                            $mix_po[$i]         = json_encode($obj_mix_po);
                            $inward[$i]         = json_encode($this->M_shipping->get_inward_data_to_si($header_id));
                    //            echo "<pre>";
                    // var_dump($inward);
                    // echo "</pre>";
                    // die;
                        }

                        $data = array(
                            'js_hdr'        => $rec_hdr,
                            'js_dtl'        => $rec_dtl,
                            'js_doc'        => $rec_doc,
                            'js_doc_s'      => $rec_doc_s,
                            'js_agent'      => $agent,
                            'js_mix_po'     => $mix_po,
                            'js_get_list_po'=> $get_list_po,
                            'mix_po_count'  => count($mix_po),
                            'total_si'      => $total_si,
                            'inward'        => $inward
                        );
                            // echo "<pre>";
                            // var_dump($data['js_hdr']);
                            // echo "</pre>";

                      //  var_dump($data['inward']);
                     //   die;
                         $this->load->view('marketing/transactions/shipping_instruction/si_batch_print', $data);
                    } else {
                        $this->session->set_flashdata('no_si_msg', pesan('No SI(s) Selected...', pesan_error()));
                        redirect('marketing_transaction/shipping_instruction/monitor');
                    }

    }

    // public function request(){
    //         $data['doc_id'] = $this->m_eform->get_document();
    //         $data['cust']   = $this->m_eform->get_cust();
    //         $this->template->display('eform/request_mark', $data);

    // }

    // function list_filter(){
    //     $custid = $this->input->get('custid');
    //     $tgl1 = date('Y-m-d', strtotime($this->input->get('from')));
    //     $tgl2 = date('Y-m-d', strtotime($this->input->get('to')));
    //     // echo $tgl1;
    //     // echo $tgl2;
    //     $po = $this->input->get('po');
    //     $user=$this->session->userdata('userid');
    //     $status=$this->input->get('status');

    //     $data1 = array(
    //             'p_cust' => $custid,
    //             'p_ship1' => $tgl1,
    //             'p_ship2' => $tgl2,
    //             'po_numbers' => $po,
    //             'p_user' => $user,
    //             'p_status' => $status
    //         );

    //     $data['_list'] = $this->m_eform->get_filter($data1);
    //     $this->load->view('eform/ajax_form/list.php', $data);

    // }


    // function apply_again_document_po(){

    //     $ship   = $this->input->get('ship');
    //     $po     = $this->input->get('po'); 
    //     $doc_id = $this->input->get('doc');
    //     $id     = $this->input->get('id_coa_gen');

    //     $this->m_eform->do_apply_again_po($ship,$po,$doc_id,$id);
    //     redirect('eform');
    
    // }

    // function apply_again_document_product(){

    //     $ship   = $this->input->get('ship');
    //     $po     = $this->input->get('po'); 
    //     $doc_id = $this->input->get('doc');
    //     $proid  = $this->input->get('proid');
    //     $id     = $this->input->get('id_coa_gen');

    //     $this->m_eform->do_apply_again_product($ship,$po,$doc_id,$proid,$id);
    //     redirect('eform');
    // }

    // function delete_document_po(){

    //     $ship   = $this->input->get('ship');
    //     $po     = $this->input->get('po'); 
    //     $doc_id = $this->input->get('doc');
    //     $id     = $this->input->get('id_coa_gen');

    //     $this->m_eform->delete_po($ship,$po,$doc_id,$id);
    //     redirect('eform');
    
    // }

    // function delete_document_product(){

    //     $ship   = $this->input->get('ship');
    //     $po     = $this->input->get('po'); 
    //     $doc_id = $this->input->get('doc');
    //     $proid  = $this->input->get('proid');
    //     $id     = $this->input->get('id_coa_gen');

    //     $this->m_eform->delete_product($ship,$po,$doc_id,$proid,$id);
    //     redirect('eform');
    // }
}