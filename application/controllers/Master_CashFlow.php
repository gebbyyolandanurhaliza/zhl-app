<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author   : Ismo Broto
 * Email    : ismo.broto@gmail.com
 */

class Master_CashFlow extends CI_Controller{
    public function __construct() {
        parent::__construct();

        //is_maintenance(FALSE, $this->session->userdata('userid_1'));
        
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        //load Model
        $this->load->model('M_CashBank');
    }
    
    // ##################===== Start Master Cash Flow =====##################
    function index(){// view Form Insert Master Cash Flow
        $idMst  = $this->uri->segment(3);
        if($idMst > 0){
            $data   = array(
                '_Controller'       => $this,
                '_formTitle'        => 'Edit Master Cash Flow',
                'is_edit'           => TRUE,
                '_action'           => array(
                    'sumbit'    => 'updateMasterCashFlow',
                    'button'    => 'Edit'
                ),
                '_getCashFlow'      => $this->M_CashBank->getMasterCashFlow($idMst),
                
                '_selectCashFlow1'  => $this->M_CashBank->selectViewMstCashFlow(1),
                '_selectCashFlow2'  => $this->M_CashBank->selectViewMstCashFlow(2),
                '_selectCashFlow3'  => $this->M_CashBank->selectViewMstCashFlow(3),
                '_selectCashFlow4'  => $this->M_CashBank->selectViewMstCashFlow(4),

                '_selectCashFlow'   => $this->M_CashBank->selectMstCashFlow()
            );
        }else{
            $data   = array(
                '_Controller'       => $this,
                '_formTitle'        => 'Input Master Cash Flow',
                'is_edit'           => FALSE,
                '_action'           => array(
                    'sumbit'    => 'insertMasterCashFlow',
                    'button'    => 'Save'
                ),
                '_getCashFlow'      => '',
                
                '_selectCashFlow1'  => $this->M_CashBank->selectViewMstCashFlow(1),
                '_selectCashFlow2'  => $this->M_CashBank->selectViewMstCashFlow(2),
                '_selectCashFlow3'  => $this->M_CashBank->selectViewMstCashFlow(3),
                '_selectCashFlow4'  => $this->M_CashBank->selectViewMstCashFlow(4),

                '_selectCashFlow'   => $this->M_CashBank->selectMstCashFlow()
            );
        }
        
        $this->template->display('finance/master/cash_flow', $data);
    }
    function insertMasterCashFlow(){
        $cvLevel    = $this->cekLevel($this->input->post('selHeaderCode'), 'CF');
        if($cvLevel == 9999){
            redirect('Master_CashFlow/index/failed');
        }
        
        $data   = array(
            'cf_code'       => $this->input->post('txtCode'),
            'cf_name'       => $this->input->post('txtName'),
            'io'            => $this->input->post('selInOut'),
            'cf_header'     => $this->input->post('selHeaderCode'),
            'cf_level'      => $cvLevel,
            'not_active'    => $this->input->post('txtNotActive'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        $this->M_CashBank->insertMstCashFlow($data);
        
        redirect('Master_CashFlow/index');
    }
    function updateMasterCashFlow(){
        $cvLevel    = $this->cekLevel($this->input->post('selHeaderCode'), 'CF');
        if($cvLevel == 9999){
            redirect('Master_CashFlow/index/failed');
        }
        
        $id         = $this->input->post('txtKey');
        $data   = array(
            'cf_code'       => $this->input->post('txtCode'),
            'cf_name'       => $this->input->post('txtName'),
            'io'            => $this->input->post('selInOut'),
            'cf_header'     => $this->input->post('selHeaderCode'),
            'cf_level'      => $cvLevel,
            'not_active'    => $this->input->post('txtNotActive'),
            'updated_by'    => $this->session->userdata('userid_1'),
            'updated_date'  => date('Y-m-d H:i:s')
        );
        $this->M_CashBank->updateMstCashFlow($id, $data);
        
        redirect('Master_CashFlow/index');
    }
    // ##################===== End Master Cash Flow =====##################
    // 
    // ##################===== Start Master Cash Realization =====##################
    function MasterRealization(){// view Form Insert Master Cash Flow Realization
        $idMst  = $this->uri->segment(3);
        if($idMst > 0){
            $data   = array(
                '_Controller'       => $this,
                '_formTitle'        => 'Edit Master Cash Realization',
                'is_edit'           => TRUE,
                '_action'           => array(
                    'sumbit'    => 'updateMasterRealization',
                    'button'    => 'Edit'
                ),
                '_getCashRealization'       => $this->M_CashBank->getMasterCashRealization($idMst),
                
                '_selectCashRealization1'   => $this->M_CashBank->selectViewMstCashRealization(1),
                '_selectCashRealization2'   => $this->M_CashBank->selectViewMstCashRealization(2),
                '_selectCashRealization3'   => $this->M_CashBank->selectViewMstCashRealization(3),
                '_selectCashRealization4'   => $this->M_CashBank->selectViewMstCashRealization(4),

                '_selectCashRealization'    => $this->M_CashBank->selectMstCashRealization()
            );
        }else{
            $data   = array(
                '_Controller'       => $this,
                '_formTitle'        => 'Input Master Cash Realization',
                'is_edit'           => FALSE,
                '_action'           => array(
                    'sumbit'    => 'insertMasterRealization',
                    'button'    => 'Save'
                ),
                '_getCashRealization'       => '',
                
                '_selectCashRealization1'   => $this->M_CashBank->selectViewMstCashRealization(1),
                '_selectCashRealization2'   => $this->M_CashBank->selectViewMstCashRealization(2),
                '_selectCashRealization3'   => $this->M_CashBank->selectViewMstCashRealization(3),
                '_selectCashRealization4'   => $this->M_CashBank->selectViewMstCashRealization(4),

                '_selectCashRealization'    => $this->M_CashBank->selectMstCashRealization()
            );
        }
        
        $this->template->display('finance/master/realization',$data);
    }
    function insertMasterRealization(){
        $rlzLevel   = $this->cekLevel($this->input->post('selHeaderCode'), 'RLZ');
        if($rlzLevel == 9999){
            redirect('Master_CashFlow/MasterRealization/failed');
        }
        
        $data   = array(
            'rlz_code'      => $this->input->post('txtCode'),
            'rlz_num'       => $this->input->post('txtNumber'),
            'rlz_name'      => $this->input->post('txtDescription'),
            'io'            => $this->input->post('selInOut'),
            'rlz_header'    => $this->input->post('selHeaderCode'),
            'rlz_level'     => $rlzLevel,
            'not_active'    => $this->input->post('txtNotActive'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        $this->M_CashBank->insertMstCashRealization($data);
        
        redirect('Master_CashFlow/MasterRealization');
    }
    function updateMasterRealization(){
        $rlzLevel   = $this->cekLevel($this->input->post('selHeaderCode'), 'RLZ');
        if($rlzLevel == 9999){
            redirect('Master_CashFlow/MasterRealization/failed');
        }
        
        $idRlz  = $this->input->post('txtkey');
        $data   = array(
            'rlz_code'      => $this->input->post('txtCode'),
            'rlz_num'       => $this->input->post('txtNumber'),
            'rlz_name'      => $this->input->post('txtDescription'),
            'io'            => $this->input->post('selInOut'),
            'rlz_header'    => $this->input->post('selHeaderCode'),
            'rlz_level'     => $rlzLevel,
            'not_active'    => $this->input->post('txtNotActive'),
            'created_by'    => $this->session->userdata('userid_1'),
            'created_date'  => date('Y-m-d H:i:s')
        );
        
        $this->M_CashBank->updateMstCashRealization($idRlz, $data);
        
        redirect('Master_CashFlow/MasterRealization');
    }            
    
    function cekLevel($hdr, $cfORrlz = NUll){
        switch ($cfORrlz) {
            case 'CF':
                if($hdr == 0){
                    return 1;
                }else{
                    $this->db->where('cf_key', $hdr);
                    $get = $this->db->get('fin_tblmst_cash_flow');
                    $row = $get->row();

                    return (int)$row->cf_level + 1;
                }
                break;
            case 'RLZ':
                if($hdr == 0){
                    return 1;
                }else{
                    $this->db->where('rlz_key', $hdr);
                    $get = $this->db->get('fin_tblmst_cash_realization');
                    $row = $get->row();

                    return (int)$row->rlz_level + 1;
                }
                break;
            default:
                return 9999;
        }
        
    }
    function lastLevelCF($id){
        $this->db->where('cf_header', $id);
        $get    = $this->db->get('fin_tblmst_cash_flow');
        if($get->num_rows() > 0 ){
            return FALSE;
        }
        return TRUE;
    }
    function lastLevelRlz($id){
        $this->db->where('rlz_header', $id);
        $get    = $this->db->get('fin_tblmst_cash_realization');
        if($get->num_rows() > 0 ){
            return FALSE;
        }
        return TRUE;
    }
    // ##################===== End Master Cash Realization =====##################
    // 
    // ##################===== Start Setting Cash Flow =====##################
    function SettingFlow(){
        $data   = array(
            '_Controller'               => $this,
            '_selectFlowRealization1'   => $this->M_CashBank->selectSettingFlowRealization(1),
            '_selectFlowRealization2'   => $this->M_CashBank->selectSettingFlowRealization(2),
            '_selectFlowRealization3'   => $this->M_CashBank->selectSettingFlowRealization(3),
            '_selectFlowRealization4'   => $this->M_CashBank->selectSettingFlowRealization(4)
        );
        
        $this->template->display('finance/master/setting_flow',$data);
    }
    function ajaxSettingFlow(){
        $data   = array(
            '_id'                       => $this->input->post('txtKey'),
            '_Controller'               => $this,
            
            '_selectCashRealization1'   => $this->M_CashBank->selectViewMstCashRealization(1),
            '_selectCashRealization2'   => $this->M_CashBank->selectViewMstCashRealization(2),
            '_selectCashRealization3'   => $this->M_CashBank->selectViewMstCashRealization(3),
            '_selectCashRealization4'   => $this->M_CashBank->selectViewMstCashRealization(4)
        );
        $this->load->view('finance/master/ajax_setting_flowRealization',$data);
    }
    function updateSettingFlow(){
        $cfID   = $this->uri->segment(3);
        $rlzID  = $this->uri->segment(4);
        
        $data   = array(
            'rlz_key'       => $rlzID
        );
        $this->M_CashBank->updateMstCashFlow($cfID, $data);
        
        redirect(base_url('Master_CashFlow/SettingFlow'));
    }
    // ##################===== End Setting Cash Flow =====##################
    // 
    // ##################===== Start Setting Saldo Awal =====##################
    function SettingBalance(){
        $data   = array(
            '_selectMstCurrency'    => $this->db->get('gen_tbl_mst_currency')->result(),
            '_selectSettingBalance' => $this->M_CashBank->selectSettingBalance()
        );
        $this->template->display('finance/master/setting_balance',$data);
    }
    function ajaxSelectCOA(){
        $data   = array(
            '_selectSettingBalance' => $this->M_CashBank->selectMasterCOAForBalance()->result()
        );
        $this->load->view('finance/master/ajax_select_coa_for_balance',$data);
    }
    function submitBalanceCOA(){
        $int    = $this->input->post('txtNoCOA');
        $saldo  = $this->input->post('txtSaldoAwal');
        for($x=0; $x<count($int); $x++):
            $data   = array(
                'no_coa'            => $int[$x],
                'Currency'          => 'SGD',
                'saldo_awal'        => $saldo[$x],
                'created_by'        => $this->session->userdata('userid_1'),
                'created_date'      => date('Y-m-d H:i:s')
            );
            $this->M_CashBank->insertSettingBalance($data);
        endfor;
        
        redirect(site_url('Master_CashFlow/SettingBalance'));
    }
    function updateBalanceCOA(){
        $saldoID    = $this->input->post('txtCOAKey');
        $data   = array(
            'Currency'          => $this->input->post('txtCurrency'),
            'saldo_awal'        => $this->input->post('txtSaldo'),
            'created_by'        => $this->session->userdata('userid_1'),
            'created_date'      => date('Y-m-d H:i:s')
        );
        $this->M_CashBank->updateSettingBalance($saldoID,$data);
        
        redirect(site_url('Master_CashFlow/SettingBalance'));
    }
    function deleteBalanceCOA($id){
        $this->M_CashBank->deleteSettingBalance($id);
        
        redirect(site_url('Master_CashFlow/SettingBalance'));
    }
    
    function test(){
        echo '<center style="padding-top : 250px;"><h1>hayoooo... gelooo siaa</h1></center>';
    }
}