<?php 
/**
* 
*/
class ClosingEarning extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata('userid_1')){
            redirect('login');
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('m_closing_earning'));
	}

	function index(){
		$data['_datahistory'] = $this->m_closing_earning->get_history();
		$this->template->display('accounting/Closing_earning', $data);
	}

	function save(){
		$nocoa 			= $this->input->post('coa');
		$periode_bulan 	= 1;
		$periode_tahun 	= $this->input->post('period'); 
		$periode_tanggal= $this->input->post('periodtgl');
		$periode_string = $this->input->post('periodstr');
		$debet 			= $this->input->post('debit');
		$kredit 		= $this->input->post('credit');
		$debet_SGD 		= $this->input->post('debitsgd');
		$kredit_SGD 	= $this->input->post('creditsgd');
		$created_by 	= $this->session->userdata('userid_1');
		$created_date 	= date('Y-m-d H:i:s');
		$updated_by 	= $this->session->userdata('userid_1');
		$updated_date 	= date('Y-m-d H:i:s');

		$data_history = array(
			'Coa' => $nocoa, 'Debet' => $debet, 'Kredit' => $kredit, 'DebetSGD' => $debet_SGD,
			'KreditSGD' => $kredit_SGD, 'CreatedBy' => $created_by, 'CreatedDate' => $updated_date 
		);

		// $cekcoa = $this->m_closing_earning->cekcoa($nocoa, $periode_tahun);

		// if($cekcoa == ''){
		// 	$data = array( 'nocoa' => $nocoa, 'periode_bulan' => $periode_bulan, 'periode_tahun' => $periode_tahun,
		// 		'periode_tanggal' => $periode_tanggal, 'periode_string' => $periode_string, 'debet' => $debet,
		// 		'kredit' => $kredit, 'debet_SGD' => $debet_SGD, 'kredit_SGD' => $kredit_SGD, 'created_by' => $created_by, 
		// 		'created_date' => $created_date
		// 	);
		// 	$this->m_closing_earning->save($data);
		// 	$this->m_closing_earning->save_history($data_history);
		// }else{
		// 	$data = array(  'debet' => $debet, 'kredit' => $kredit, 'debet_SGD' => $debet_SGD, 'last_update_by' => $kredit_SGD, 
		// 		'last_update_by' => $created_by, 'last_update_date' => $created_date
		// 	);
		// 	$this->m_closing_earning->update($data, $nocoa, $periode_tahun);
		// 	$this->m_closing_earning->save_history($data_history);
		// }

		$this->m_closing_earning->save($periode_tahun, $this->session->userdata('userid_1'));
		$this->m_closing_earning->save_history($data_history);

		redirect('ClosingEarning');
	}

	function getearning(){
		$th = $this->input->get('th');
		$data = $this->m_closing_earning->get_earning($th);

		$usd = $data->usd;
		$sgd = $data->sgd;

		if($usd > 0){
			$debit = $usd;
			$kredit = 0;
		}else{
			$debit = 0;
			$kredit = abs($usd);
		}

		if($sgd > 0){
			$debitsgd = $sgd;
			$kreditsgd = 0;
		}else{
			$debitsgd = 0;
			$kreditsgd = abs($sgd);
		}

		$ptgl = $th.'-01-01';
		$pstr = $th.'01';

		echo "
			<table class='table table-bordered' id='tbl'>
				<tr>
					<th width='10%'>Account Number</th>
					<th width='10%'>Period</th>
					<th width='20%'>Debet</th>
					<th width='20%'>Credit</th>
					<th width='20%'>Debet SGD</th>
					<th width='20%'>Credit SGD</th>
				</tr>
				<tr>
					<td align='right'>300102<input type='hidden' class='txt' name='coa' value='300102' readonly /></td>
					<td align='right' >$th
						<input type='hidden' class='txt' name='period' value='$th' readonly />
						<input type='hidden' class='txt' name='periodtgl' value='$ptgl' />
						<input type='hidden' class='txt' name='periodstr' value='$pstr' />
					</td>
					<td align='right'>".number_format($debit, 2)."<input type='hidden' class='txt' name='debit' value='$debit' readonly /></td>
					<td align='right'>".number_format($kredit, 2)."<input type='hidden' class='txt' name='credit' value='$kredit' readonly /></td>
					<td align='right'>".number_format($debitsgd, 2)."<input type='hidden' class='txt' name='debitsgd' value='$debitsgd' readonly /></td>
					<td align='right'>".number_format($kreditsgd, 2)."<input type='hidden' class='txt' name='creditsgd' value='$kreditsgd' readonly /></td>
				</tr>
			</table>

			<button type='submit' class='btn btn-primary'>
                <i class='fa fa-save'> Save</i>
            </button>
		";
	}
}

?>