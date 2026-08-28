<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Eform extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model(array('m_shipping','m_purchasing','m_eform'));
        define('FPDF_FONTPATH',  $this->config->item('fonts_path'));
        $this->load->library(array('Fpdf','PHPExcel'));
        
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
    }

//===========================E-Form===============================================
    public function request(){
            $data['doc_id'] = $this->m_eform->get_document();
            $this->template->display('eform/request_mark', $data);

    }

    function request_coa(){
            $ship = $this->input->get('ship');        
            $po = $this->input->get('po');        
            $custid = $this->input->get('custid');        
            $fac = $this->input->get('fac');        
            $data['header'] = $this->m_eform->get_po_information($ship);
            $data['product'] = $this->m_eform->get_product($ship,$po,$custid,$fac);
            $this->template->display('eform/form_input/coa_product_create', $data);               
    }

    function request_product_coa(){
            $ship = $this->input->get('ship');        
            $po = $this->input->get('po');        
            $custid = $this->input->get('custid');        
            $fac = $this->input->get('fac');        
            $proid = $this->input->get('proid');
            $data['factory'] = $this->m_eform->get_factory($fac);
            $data['header'] = $this->m_eform->get_po_information($ship);
            $data['product'] = $this->m_eform->get_product($ship,$po,$custid,$fac);
            $data['product_dtl'] = $this->m_eform->get_product_detail($ship,$po,$custid,$fac,$proid);
            $data['cont'] = $this->m_eform->get_cont_shipment($ship);
            $this->template->display('eform/form_input/coa_create',$data);               
    }

    function request_product_coa_view_print(){
            $id_coa_gen = $this->input->get('id_coa');
            $ship       = $this->input->get('ship');        
            $po         = $this->input->get('po');        
            $custid     = $this->input->get('cust');        
            $fac        = $this->input->get('fac');        
            $proid      = $this->input->get('pro');
            $brand_id   = $this->input->get('brand');


            //echo "Ini ID nangkap=".$id_coa_gen;
            $data['factory']     = $this->m_eform->get_factory($fac);
            $data['header']      = $this->m_eform->get_po_information($ship);
            $data['product']     = $this->m_eform->get_product($ship,$po,$custid,$fac);
            $data['product_dtl'] = $this->m_eform->get_product_detail($ship,$po,$custid,$fac,$proid);
            $data['cont']        = $this->m_eform->get_cont_shipment($ship);

            $data['hdr']  = $this->m_eform->get_coa_gen_hdr($id_coa_gen);  
            $data['dtl1'] = $this->m_eform->get_coa_gen_dtl_1($id_coa_gen);
            $data['dtl2'] = $this->m_eform->get_coa_gen_dtl_2($id_coa_gen);
            $data['dtl3'] = $this->m_eform->get_coa_gen_dtl_3($id_coa_gen);

            $this->template->display('eform/form_input/coa_view_print',$data);               
    }

    function coa_gen_save(){
            //Header COA
            $doc_date   = $this->input->post('doc_date');
            $id_coa_gen = $this->input->post('id_coa_gen');
            $id_dtl     = $this->input->post('id_dtl');
            $id_dtl1    = $this->input->post('id_dtl1');
            $id_dtl2    = $this->input->post('id_dtl2');
            $to         = $this->input->post('to');
            $to_id      = $this->input->post('to_id');
            $from       = $this->input->post('from');
            $from_id    = $this->input->post('from_id');
            $cert_no    = $this->input->post('cert_no');
            $po_number  = $this->input->post('po_number');
            $ship_product_id = $this->input->post('ship_product_id');
            $exporter   = $this->input->post('exporter');
            $importer   = $this->input->post('importer');
            $brand_product = $this->input->post('brand_product');
            $category_product = $this->input->post('category_product');
            $container  = $this->input->post('container');
            $si_no      = $this->input->post('si_no');
            $name_product = $this->input->post('name_product');
            $code_product = $this->input->post('code_product');
            $lot_no     = $this->input->post('lot_no');
            $packing    = $this->input->post('packing');
            $remarks    = $this->input->post('remarks');
            $product_category_id = $this->input->post('product_category_id');
            $product_brand_id = $this->input->post('product_brand_id');
            $by         = $this->input->post('by');
            $name_sign  = $this->input->post('name_sign');
            $title_hdr  = $this->input->post('title_hdr');
            $date       = $this->input->post('date');
            $shipid     = $this->input->post('shipid');
            $po_hdr_id  = $this->input->post('po_hdr_id');
            $customer_id = $this->input->post('to_id');
            $tipe_coa   = $this->input->post('tipe_coa');


            //Detail COA Phisical
            $id_dtl     = $this->input->post('id_dtl');
            $pro_date   = $this->input->post('pro_date');
            $exp_date   = $this->input->post('exp_date');
            $cap        = $this->input->post('cap');
            $fo         = $this->input->post('fo');
            $no         = $this->input->post('no');

            //Detail COA Chemical
            $id_dtl1    = $this->input->post('id_dtl1');
            $pro_date1  = $this->input->post('pro_date1');
            $exp_date1  = $this->input->post('exp_date1');
            $fc         = $this->input->post('fc');
            $ph         = $this->input->post('ph');
            $dm         = $this->input->post('dm');
            $no1        = $this->input->post('no1');

            //Detail COA Microbio
            $id_dtl2    = $this->input->post('id_dtl2');
            $pro_date2  = $this->input->post('pro_date2');
            $exp_date2  = $this->input->post('exp_date2');
            $cs         = $this->input->post('cs');
            $no2        = $this->input->post('no2');

            //Proses Simpan COA General
            if($id_coa_gen == '' && $id_dtl =='' && $id_dtl1 =='' && $id_dtl2 ==''){
                $data_hdr_gen=array(
                    'doc_date'        => $doc_date,
                    'id_coa_gen'      => $id_coa_gen,
                    'to'              => $to,
                    'to_id'           => $to_id,
                    'from'            => $from,
                    'from_id'         => $from_id,
                    'cert_no'         => $cert_no,
                    'po_number'       => $po_number,
                    'ship_product_id' => $ship_product_id,
                    'exporter'        => $exporter,
                    'importer'        => $importer,
                    'brand_product'   => $brand_product,
                    'category_product'=> $category_product,
                    'container'       => $container,
                    'si_no'           => $si_no,
                    'name_product'    => $name_product,
                    'code_product'    => $code_product,
                    'lot_no'          => $lot_no,
                    'packing'         => $packing,
                    'remarks'         => $remarks,
                    'shipid'          => $shipid,
                    'po_hdr_id'       => $po_hdr_id,
                    'customer_id'     => $customer_id,
                    'product_category_id' => $product_category_id,
                    'product_brand_id'=> $product_brand_id,
                    'by'              => $by,
                    'name_sign'       => $name_sign,
                    'title_hdr'       => $title_hdr,
                    'date'            => $date,
                    'tipe_coa'        => $tipe_coa
                );
                $headerid = $this->m_eform->simpan_coa_gen_hdr($data_hdr_gen);

                //Simpan COA Setail Phisical
                for($i=0; $i<count($no); $i++){
                    $data_dtl=array(
                            'id_coa_gen' => $headerid,
                            'pro_date'   => $pro_date[$i],
                            'exp_date'   => $exp_date[$i],
                            'cap'        => $cap[$i],
                            'fo'         => $fo[$i],
                            'no'         => $no[$i]                        
                    );
                $this->m_eform->simpan_coa_gen_dtl_1($data_dtl);
                }

                //Simpan COA Detail Chemical
                for($i=0; $i<count($no1); $i++){
                    $data_dtl1=array(
                            'id_coa_gen' => $headerid,
                            'pro_date1'  => $pro_date1[$i],
                            'exp_date1'  => $exp_date1[$i],
                            'ph'         => $ph[$i],
                            'fc'         => $fc[$i],
                            'dm'         => $dm[$i],                        
                            'no'         => $no1[$i]                        
                    );
                $this->m_eform->simpan_coa_gen_dtl_2($data_dtl1);
                }

                //SImpan COA Detail Microbio
                for($i=0; $i<count($no2); $i++){
                    $data_dtl2=array(
                            'id_coa_gen' => $headerid,
                            'pro_date2'  => $pro_date2[$i],
                            'exp_date2'  => $exp_date2[$i],
                            'cs'         => $cs[$i],                        
                            'no'         => $no2[$i]                       
                    );
                $this->m_eform->simpan_coa_gen_dtl_3($data_dtl2);
                }

            //Kalau berhasil Save maka akan di redirect ke Halaman ini Sendiri
            redirect('eform/request_product_coa_view_print?ship='.$shipid.'&po='.$po_hdr_id.'&pro='.$ship_product_id.'&cust='.$to_id.'&fac='.$from_id.'&id_coa_gen='.$headerid.'&tipe_coa='.$tipe_coa.'');
            // redirect('eform/request_product_coa_view_print?id_coa_gen='.$headerid);
            }
            
            else
            
            {
            //Proses Update COA General
            }
    }

    public function request_manual(){
            $data['doc_id'] = $this->m_eform->get_document();
            $this->template->display('eform/request_mark',$data);
    }

    public function approval(){

    }

    public function monitoring(){

    }

    function ajax_list_create(){
            $doc_id = $this->input->get('doc_id');
            $data['doc_id'] = $this->m_eform->get_list_po_needed($doc_id);

            if($doc_id == '1'){
            $this->load->view('eform/ajax_form/packing_list_create',$data);
            }else if($doc_id == '2'){
            $this->load->view('eform/ajax_form/coa_list_create',$data);                
            }else if($doc_id == '4'){
            $this->load->view('eform/ajax_form/can_code_create',$data);                
            }else if($doc_id == '83'){
            $this->load->view('eform/ajax_form/ccoa_create',$data);                
            }else{
            $this->load->view('eform/ajax_form/unknown_create',$data);                                
            }

    }
}