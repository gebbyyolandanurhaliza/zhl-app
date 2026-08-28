<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class KursNew extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_KursNew');
        $this->load->library('form_validation');
    }

    function index()
    {
        $data['_cur'] = $this->M_KursNew->get_curid();
        $data['_period'] = $this->M_KursNew->get_period();
        $data['_count'] = $this->M_KursNew->count_curid();
        // $data['_usd'] = $this->M_KursNew->get_rateusd('CNY','2016-01-01');
        $this->template->display('accounting/kurs/kursNew', $data);
    }

    function updateUSD()
    {
        $data['_cur'] = $this->M_KursNew->get_curid();
        $data['_period'] = $this->M_KursNew->get_period();
        $data['_count'] = $this->M_KursNew->count_curid();
        $this->template->display('accounting/kurs/updateUSD', $data);
    }

    function updateSGD()
    {
        $data['_cur'] = $this->M_KursNew->get_curid();
        $data['_period'] = $this->M_KursNew->get_period();
        $data['_count'] = $this->M_KursNew->count_curid();
        $this->template->display('accounting/kurs/updateSGD', $data);
    }


    function save_kurs_usd_new()
    {
        $period = $this->input->post('period');
        $now = date('Y-m-d');
        $user = $this->session->userdata('userid_1');
        $aud = $this->input->post('AUD');
        $cny = $this->input->post('CNY');
        $eur = $this->input->post('EUR');
        $idr = $this->input->post('IDR');
        $myr = $this->input->post('MYR');
        $sgd = $this->input->post('SGD');
        $usd = $this->input->post('USD');
        $yen = $this->input->post('YEN');
        $twd = $this->input->post('TWD');
        $gbp = $this->input->post('GBP');




        if ($sgd != 0) {
            $audtosgd = $aud / $sgd;
            $cnytosgd = $cny / $sgd; //Rate CNY / Rate SGD
            $eurtosgd = $eur / $sgd; //Rate EUR / Rate SGD
            $idrtosgd = $idr / $sgd; //Rate IDR / Rate SGD
            $myrtosgd = $myr / $sgd; //Rate MYR / Rate SGD
            $sgdtosgd = $sgd / $sgd; //Rate SGD / Rate SGD
            $usdtosgd = $usd / $sgd; //Rate USD / Rate SGD
            $yentosgd = $yen / $sgd; //Rate YEN / Rate SGD
            $twdtosgd = $twd / $sgd; //Rate TWD / Rate SGD
            $gbptosgd = $gbp / $sgd;
        } else {

            $cnytosgd = 0;
            $eurtosgd = 0;
            $idrtosgd = 0;
            $myrtosgd = 0;
            $sgdtosgd = 0;
            $usdtosgd = 0;
            $yentosgd = 0;
            $twdtosgd = 0;
            $gbptosgd = 0;
        }

        $p = $this->M_KursNew->cek_period($period);
        // echo $p;
        // echo $cnytosgd;
        // echo $eurtosgd;
        // echo $idrtosgd;
        // echo $myrtosgd;
        // echo $sgdtosgd;
        // echo $usdtosgd;
        // echo $yentosgd;
        // echo $twdtosgd;
        if ($p > 0) {
            $dataaud = array('rate_usd' => $aud, 'rate_kurs' => $audtosgd);
            $this->M_KursNew->update_period($period, 'AUD', $dataaud);

            $datacny = array('rate_usd' => $cny, 'rate_kurs' => $cnytosgd);
            $this->M_KursNew->update_period($period, 'CNY', $datacny);

            $dataeur = array('rate_usd' => $eur, 'rate_kurs' => $eurtosgd);
            $this->M_KursNew->update_period($period, 'EUR', $dataeur);

            $dataidr = array('rate_usd' => $idr, 'rate_kurs' => $idrtosgd);
            $this->M_KursNew->update_period($period, 'IDR', $dataidr);

            $datamyr = array('rate_usd' => $myr, 'rate_kurs' => $myrtosgd);
            $this->M_KursNew->update_period($period, 'MYR', $datamyr);

            $datasgd = array('rate_usd' => $sgd, 'rate_kurs' => $sgdtosgd);
            $this->M_KursNew->update_period($period, 'SGD', $datasgd);

            $datausd = array('rate_usd' => $usd, 'rate_kurs' => $usdtosgd);
            $this->M_KursNew->update_period($period, 'USD', $datausd);

            $datayen = array('rate_usd' => $yen, 'rate_kurs' => $yentosgd);
            $this->M_KursNew->update_period($period, 'YEN', $datayen);

            $datatwd = array('rate_usd' => $twd, 'rate_kurs' => $twdtosgd);
            $this->M_KursNew->update_period($period, 'TWD', $datatwd);

            $datagbp = array('rate_usd' => $gbp, 'rate_kurs' => $gbptosgd);
            $this->M_KursNew->update_period($period, 'GBP', $datagbp);

            $dataaud = array(
                'currency_name' => 'Australian Dollar',
                'rate_usd' => $aud,
                'rate_kurs' => $audtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'AUD',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($dataaud);

            $datacny = array(
                'currency_name' => 'Chinese Yuan',
                'rate_usd' => $cny,
                'rate_kurs' => $cnytosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'CNY',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datacny);
            $dataeur = array(
                'currency_name' => 'Euro',
                'rate_usd' => $eur,
                'rate_kurs' => $eurtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'EUR',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($dataeur);
            $dataidr = array(
                'currency_name' => 'Indonesian Rupiah',
                'rate_usd' => $idr,
                'rate_kurs' => $idrtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'IDR',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($dataidr);
            $datamyr = array(
                'currency_name' => 'Ringgit Malaysia',
                'rate_usd' => $myr,
                'rate_kurs' => $myrtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'MYR',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datamyr);
            $datasgd = array(
                'currency_name' => 'Singapore Dollar',
                'rate_usd' => $sgd,
                'rate_kurs' => $sgdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'SGD',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datasgd);
            $datausd = array(
                'currency_name' => 'US Dollar',
                'rate_usd' => $usd,
                'rate_kurs' => $usdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'USD',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datausd);
            $datayen = array(
                'currency_name' => 'Japanese yen',
                'rate_usd' => $yen,
                'rate_kurs' => $yentosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'YEN',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datayen);
            $datatwd = array(
                'currency_name' => 'Taiwan Dollar',
                'rate_usd' => $twd,
                'rate_kurs' => $twdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'TWD',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datatwd);

            $datagbp = array(
                'currency_name' => 'British Poundsterling',
                'rate_usd' => $gbp,
                'rate_kurs' => $gbptosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'GBP',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period_history($datagbp);
        } else {

            $dataaud = array(
                'currency_name' => 'Australian Dollar',
                'rate_usd' => $aud,
                'rate_kurs' => $audtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'AUD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($dataaud);
            $this->M_KursNew->insert_period_history($dataaud);

            $datacny = array(
                'currency_name' => 'Chinese Yuan',
                'rate_usd' => $cny,
                'rate_kurs' => $cnytosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'CNY',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datacny);
            $this->M_KursNew->insert_period_history($datacny);

            $dataeur = array(
                'currency_name' => 'Euro',
                'rate_usd' => $eur,
                'rate_kurs' => $eurtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'EUR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($dataeur);
            $this->M_KursNew->insert_period_history($dataeur);

            $dataidr = array(
                'currency_name' => 'Indonesian Rupiah',
                'rate_usd' => $idr,
                'rate_kurs' => $idrtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'IDR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($dataidr);
            $this->M_KursNew->insert_period_history($dataidr);

            $datamyr = array(
                'currency_name' => 'Ringgit Malaysia',
                'rate_usd' => $myr,
                'rate_kurs' => $myrtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'MYR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datamyr);
            $this->M_KursNew->insert_period_history($datamyr);

            $datasgd = array(
                'currency_name' => 'Singapore Dollar',
                'rate_usd' => $sgd,
                'rate_kurs' => $sgdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'SGD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datasgd);
            $this->M_KursNew->insert_period_history($datasgd);

            $datausd = array(
                'currency_name' => 'US Dollar',
                'rate_usd' => $usd,
                'rate_kurs' => $usdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'USD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datausd);
            $this->M_KursNew->insert_period_history($datausd);

            $datayen = array(
                'currency_name' => 'Japanese yen',
                'rate_usd' => $yen,
                'rate_kurs' => $yentosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'YEN',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datayen);
            $this->M_KursNew->insert_period_history($datayen);

            $datatwd = array(
                'currency_name' => 'Taiwan Dollar',
                'rate_usd' => $twd,
                'rate_kurs' => $twdtosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'TWD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datatwd);
            $this->M_KursNew->insert_period_history($datatwd);

            $datagbp = array(
                'currency_name' => 'British Poundsterling',
                'rate_usd' => $gbp,
                'rate_kurs' => $gbptosgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'GBP',
                'updated_by' => $user,
                'updated_date' => $now
            );
            $this->M_KursNew->insert_period($datagbp);
            $this->M_KursNew->insert_period_history($datagbp);
        }

        redirect(site_url('KursNew'));
    }


    function save_kurs_sgd_new()
    {

        $period = $this->input->post('period');
        $now = date('Y-m-d');
        $user = $this->session->userdata('userid_1');
        $cny = $this->input->post('CNY');
        $eur = $this->input->post('EUR');
        $idr = $this->input->post('IDR');
        $myr = $this->input->post('MYR');
        $sgd = $this->input->post('SGD');
        $usd = $this->input->post('USD');
        $yen = $this->input->post('YEN');




        $p = $this->M_KursNew->cek_period($period);



        if ($p > 0) {
            $datacny = array('rate_kurs' => $cny);
            $this->M_KursNew->update_period($period, 'CNY', $datacny);

            $dataeur = array('rate_kurs' => $eur);
            $this->M_KursNew->update_period($period, 'EUR', $dataeur);

            $dataidr = array('rate_kurs' => $idr);
            $this->M_KursNew->update_period($period, 'IDR', $dataidr);

            $datamyr = array('rate_kurs' => $myr);
            $this->M_KursNew->update_period($period, 'MYR', $datamyr);

            $datasgd = array('rate_kurs' => $sgd);
            $this->M_KursNew->update_period($period, 'SGD', $datasgd);

            $datausd = array('rate_kurs' => $usd);
            $this->M_KursNew->update_period($period, 'USD', $datausd);

            $datayen = array('rate_kurs' => $yen);
            $this->M_KursNew->update_period($period, 'YEN', $datayen);

            $datacny = array(
                'currency_name' => 'Chinese Yuan',
                'rate_kurs' => $cny,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'CNY',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($datacny);

            $dataeur = array(
                'currency_name' => 'Euro',
                'rate_kurs' => $eur,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'EUR',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($dataeur);

            $dataidr = array(
                'currency_name' => 'Indonesian Rupiah',
                'rate_kurs' => $idr,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'IDR',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($dataidr);

            $datamyr = array(
                'currency_name' => 'Ringgit Malaysia',
                'rate_kurs' => $myr,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'MYR',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($datamyr);

            $datasgd = array(
                'currency_name' => 'Singapore Dollar',
                'rate_kurs' => $sgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'SGD',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($datasgd);

            $datausd = array(
                'currency_name' => 'US Dollar',
                'rate_kurs' => $usd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'USD',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($datausd);

            $datayen = array(
                'currency_name' => 'Japanese yen',
                'rate_kurs' => $yen,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'YEN',
                'created_by' => $user,
                'created_date' => $now
            );

            $this->M_KursNew->insert_period_history($datayen);
        } else {
            // echo $cny;
            $datacny = array(
                'currency_name' => 'Chinese Yuan',
                'rate_kurs' => $cny,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'CNY',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datacny);
            $this->M_KursNew->insert_period_history($datacny);

            $dataeur = array(
                'currency_name' => 'Euro',
                'rate_kurs' => $eur,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'EUR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($dataeur);
            $this->M_KursNew->insert_period_history($dataeur);

            $dataidr = array(
                'currency_name' => 'Indonesian Rupiah',
                'rate_kurs' => $idr,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'IDR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($dataidr);
            $this->M_KursNew->insert_period_history($dataidr);

            $datamyr = array(
                'currency_name' => 'Ringgit Malaysia',
                'rate_kurs' => $myr,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'MYR',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datamyr);
            $this->M_KursNew->insert_period_history($datamyr);

            $datasgd = array(
                'currency_name' => 'Singapore Dollar',
                'rate_kurs' => $sgd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'SGD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datasgd);
            $this->M_KursNew->insert_period_history($datasgd);

            $datausd = array(
                'currency_name' => 'US Dollar',
                'rate_kurs' => $usd,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'USD',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datausd);
            $this->M_KursNew->insert_period_history($datausd);

            $datayen = array(
                'currency_name' => 'Japanese yen',
                'rate_kurs' => $yen,
                'periode' => date('Y-m-d', strtotime($period)),
                'currency_id' => 'YEN',
                'created_by' => $user,
                'created_date' => $now
            );
            $this->M_KursNew->insert_period($datayen);
            $this->M_KursNew->insert_period_history($datayen);
        }

        redirect(site_url('KursNew'));
    }


    function update_kurs_usd_new()
    {
        $period = $this->input->post('period');
        $now = date('Y-m-d');
        $user = $this->session->userdata('userid_1');
        $aud = $this->input->post('AUD');
        $cny = $this->input->post('CNY');
        $eur = $this->input->post('EUR');
        $idr = $this->input->post('IDR');
        $myr = $this->input->post('MYR');
        $sgd = $this->input->post('SGD');
        $usd = $this->input->post('USD');
        $yen = $this->input->post('YEN');
        $twd = $this->input->post('TWD');
        $gbp = $this->input->post('GBP');

        if ($sgd != 0) {
            $audtosgd = $aud / $sgd;
            $cnytosgd = $cny / $sgd; //Rate CNY / Rate SGD
            $eurtosgd = $eur / $sgd; //Rate EUR / Rate SGD
            $idrtosgd = $idr / $sgd; //Rate IDR / Rate SGD
            $myrtosgd = $myr / $sgd; //Rate MYR / Rate SGD
            $sgdtosgd = $sgd / $sgd; //Rate SGD / Rate SGD
            $usdtosgd = $usd / $sgd; //Rate USD / Rate SGD
            $yentosgd = $yen / $sgd; //Rate YEN / Rate SGD
            $twdtosgd = $twd / $sgd; //Rate TWD / Rate SGD
            $gbptosgd = $gbp / $sgd; //Rate GBP / Rate SGD
        } else {

            $cnytosgd = 0;
            $eurtosgd = 0;
            $idrtosgd = 0;
            $myrtosgd = 0;
            $sgdtosgd = 0;
            $usdtosgd = 0;
            $yentosgd = 0;
            $twdtosgd = 0;
            $gbptosgd = 0;
        }

        $datacny = array('rate_usd' => $aud, 'rate_kurs' => $audtosgd);
        $this->M_KursNew->update_period($period, 'AUD', $datacny);

        $datacny = array('rate_usd' => $cny, 'rate_kurs' => $cnytosgd);
        $this->M_KursNew->update_period($period, 'CNY', $datacny);

        $dataeur = array('rate_usd' => $eur, 'rate_kurs' => $eurtosgd);
        $this->M_KursNew->update_period($period, 'EUR', $dataeur);

        $dataidr = array('rate_usd' => $idr, 'rate_kurs' => $idrtosgd);
        $this->M_KursNew->update_period($period, 'IDR', $dataidr);

        $datamyr = array('rate_usd' => $myr, 'rate_kurs' => $myrtosgd);
        $this->M_KursNew->update_period($period, 'MYR', $datamyr);

        $datasgd = array('rate_usd' => $sgd, 'rate_kurs' => $sgdtosgd);
        $this->M_KursNew->update_period($period, 'SGD', $datasgd);

        $datausd = array('rate_usd' => $usd, 'rate_kurs' => $usdtosgd);
        $this->M_KursNew->update_period($period, 'USD', $datausd);

        $datayen = array('rate_usd' => $yen, 'rate_kurs' => $yentosgd);
        $this->M_KursNew->update_period($period, 'YEN', $datayen);

        $datatwd = array('rate_usd' => $twd, 'rate_kurs' => $twdtosgd);
        $this->M_KursNew->update_period($period, 'TWD', $datatwd);

        $datagbp = array('rate_usd' => $gbp, 'rate_kurs' => $gbptosgd);
        $this->M_KursNew->update_period($period, 'GBP', $datagbp);

        $dataaud = array(
            'currency_name' => 'Australian Dollar',
            'rate_usd' => $aud,
            'rate_kurs' => $audtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'AUD',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($dataaud);

        $datacny = array(
            'currency_name' => 'Chinese Yuan',
            'rate_usd' => $cny,
            'rate_kurs' => $cnytosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'CNY',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datacny);
        $dataeur = array(
            'currency_name' => 'Euro',
            'rate_usd' => $eur,
            'rate_kurs' => $eurtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'EUR',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($dataeur);
        $dataidr = array(
            'currency_name' => 'Indonesian Rupiah',
            'rate_usd' => $idr,
            'rate_kurs' => $idrtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'IDR',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($dataidr);
        $datamyr = array(
            'currency_name' => 'Ringgit Malaysia',
            'rate_usd' => $myr,
            'rate_kurs' => $myrtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'MYR',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datamyr);
        $datasgd = array(
            'currency_name' => 'Singapore Dollar',
            'rate_usd' => $sgd,
            'rate_kurs' => $sgdtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'SGD',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datasgd);
        $datausd = array(
            'currency_name' => 'US Dollar',
            'rate_usd' => $usd,
            'rate_kurs' => $usdtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'USD',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datausd);
        $datayen = array(
            'currency_name' => 'Japanese yen',
            'rate_usd' => $yen,
            'rate_kurs' => $yentosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'YEN',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datayen);
        $datatwd = array(
            'currency_name' => 'Taiwan Dollar',
            'rate_usd' => $twd,
            'rate_kurs' => $twdtosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'TWD',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datatwd);

        $datagbp = array(
            'currency_name' => 'British Poundsterling',
            'rate_usd' => $gbp,
            'rate_kurs' => $gbptosgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'GBP',
            'updated_by' => $user,
            'updated_date' => $now
        );
        $this->M_KursNew->insert_period_history($datagbp);

        redirect(site_url('KursNew'));
    }


    function update_kurs_sgd_new()
    {
        $period = $this->input->post('period');
        $now = date('Y-m-d');
        $user = $this->session->userdata('userid_1');
        $cny = $this->input->post('CNY');
        $eur = $this->input->post('EUR');
        $idr = $this->input->post('IDR');
        $myr = $this->input->post('MYR');
        $sgd = $this->input->post('SGD');
        $usd = $this->input->post('USD');
        $yen = $this->input->post('YEN');


        // echo $cny;
        // echo $eur;
        // echo $idr;
        // echo $myr;
        // echo $sgd;
        // echo $usd;
        // echo $yen;

        $datacny = array('rate_kurs' => $cny);
        $this->M_KursNew->update_period($period, 'CNY', $datacny);

        $dataeur = array('rate_kurs' => $eur);
        $this->M_KursNew->update_period($period, 'EUR', $dataeur);

        $dataidr = array('rate_kurs' => $idr);
        $this->M_KursNew->update_period($period, 'IDR', $dataidr);

        $datamyr = array('rate_kurs' => $myr);
        $this->M_KursNew->update_period($period, 'MYR', $datamyr);

        $datasgd = array('rate_kurs' => $sgd);
        $this->M_KursNew->update_period($period, 'SGD', $datasgd);

        $datausd = array('rate_kurs' => $usd);
        $this->M_KursNew->update_period($period, 'USD', $datausd);

        $datayen = array('rate_kurs' => $yen);
        $this->M_KursNew->update_period($period, 'YEN', $datayen);

        $datacny = array(
            'currency_name' => 'Chinese Yuan',
            'rate_kurs' => $cny,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'CNY',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($datacny);

        $dataeur = array(
            'currency_name' => 'Euro',
            'rate_kurs' => $eur,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'EUR',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($dataeur);

        $dataidr = array(
            'currency_name' => 'Indonesian Rupiah',
            'rate_kurs' => $idr,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'IDR',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($dataidr);

        $datamyr = array(
            'currency_name' => 'Ringgit Malaysia',
            'rate_kurs' => $myr,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'MYR',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($datamyr);

        $datasgd = array(
            'currency_name' => 'Singapore Dollar',
            'rate_kurs' => $sgd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'SGD',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($datasgd);

        $datausd = array(
            'currency_name' => 'US Dollar',
            'rate_kurs' => $usd,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'USD',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($datausd);

        $datayen = array(
            'currency_name' => 'Japanese yen',
            'rate_kurs' => $yen,
            'periode' => date('Y-m-d', strtotime($period)),
            'currency_id' => 'YEN',
            'created_by' => $user,
            'created_date' => $now
        );

        $this->M_KursNew->insert_period_history($datayen);

        redirect(site_url('KursNew'));
    }



    // function save_kurs_sgd(){
    //     // echo "tes";
    //     $period = $this->input->post('period');
    //     $now = date('Y-m-d');
    //     $user = $this->session->userdata('userid_1');
    //     $cny = $this->input->post('CNY');
    //     $eur = $this->input->post('EUR');
    //     $idr = $this->input->post('IDR');
    //     $myr = $this->input->post('MYR');
    //     $sgd = $this->input->post('SGD');
    //     $usd = $this->input->post('USD');
    //     $yen = $this->input->post('YEN');


    //     for($i=0; $i < count($period); $i++){

    //         $p = $this->M_KursNew->cek_period($period[$i]);
    //         // echo $p;
    //         // echo $period[$i];
    //         if($p>0){
    //             $datacny = array('rate_kurs'=>$cny[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'CNY', $datacny);

    //             $dataeur = array('rate_kurs'=>$eur[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'EUR', $dataeur);

    //             $dataidr = array('rate_kurs'=>$idr[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'IDR', $dataidr);

    //             $datamyr = array('rate_kurs'=>$myr[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'MYR', $datamyr);

    //             $datasgd = array('rate_kurs'=>$sgd[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'SGD', $datasgd);

    //             $datausd = array('rate_kurs'=>$usd[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'USD', $datausd);

    //             $datayen = array('rate_kurs'=>$yen[$i]);
    //             $this->M_KursNew->update_period($period[$i], 'YEN', $datayen);
    //         }
    //         else
    //         {
    //             // echo $cny[$i];
    //             $datacny = array(
    //                 'currency_name'=>'Chinese Yuan',
    //                 'rate_kurs'=>$cny[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'CNY',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($datacny);
    //             $this->M_KursNew->insert_period_history($datacny);

    //             $dataeur = array(
    //                 'currency_name'=>'Euro',
    //                 'rate_kurs'=>$eur[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'EUR',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($dataeur);
    //             $this->M_KursNew->insert_period_history($dataeur);

    //             $dataidr = array(
    //                 'currency_name'=>'Indonesian Rupiah',
    //                 'rate_kurs'=>$idr[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'IDR',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($dataidr);
    //             $this->M_KursNew->insert_period_history($dataidr);

    //             $datamyr = array(
    //                 'currency_name'=>'Ringgit Malaysia',
    //                 'rate_kurs'=>$myr[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'MYR',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($datamyr);
    //             $this->M_KursNew->insert_period_history($datamyr);

    //             $datasgd = array(
    //                 'currency_name'=>'Singapore Dollar',
    //                 'rate_kurs'=>$sgd[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'SGD',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($datasgd);
    //             $this->M_KursNew->insert_period_history($datasgd);

    //             $datausd = array(
    //                 'currency_name'=>'US Dollar',
    //                 'rate_kurs'=>$usd[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'USD',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($datausd);
    //             $this->M_KursNew->insert_period_history($datausd);

    //             $datayen = array(
    //                 'currency_name'=>'Japanese yen',
    //                 'rate_kurs'=>$yen[$i],
    //                 'periode'=>date('Y-m-d',strtotime($period[$i])),
    //                 'currency_id'=>'YEN',
    //                 'created_by'=>$user,
    //                 'created_date'=>$now
    //                 );
    //             $this->M_KursNew->insert_period($datayen);
    //             $this->M_KursNew->insert_period_history($datayen);
    //         }
    //     }
    //    redirect(site_url('kurs2'));
    // }

}
