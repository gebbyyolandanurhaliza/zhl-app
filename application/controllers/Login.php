<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Login extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(array('M_login'));
    if ($this->session->userdata('userid_1')) {
      redirect('home');
    }
  }

  private $key = "1niT0k3nr4H4s14p55@2oi9#0k3..asa!223Ac.,asd~12!@@$$#%#^^$^&%**)((W)"; // url: https://www.youtube.com/

  public function index()
  {
    $data = [
      'browser' => $this->_browser()
    ];
    $this->load->view('login/newlogin', $data);
  }

  public function logintest()
  {
    $data = [
      'browser' => $this->_browser()
    ];
    $this->load->view('login/newlogin2', $data);
  }

  public function _browser()
  {
    $browser = $this->agent->browser();
    return $browser;
  }

  public function GenerateToken($data)
  {
    $jwt = JWT::encode($data, $this->key);
    return $jwt;
  }


  public function CekTokenZHL($tokenData)
  {
    $jwtToken = $this->GenerateToken($tokenData);

    echo $jwtToken;
  }


  function sign_in()
  {
    $period = $this->M_login->ambil_tgl();
    $closing_date = $period->row();
    $userid = strtolower($this->input->post('txtUserID'));
    $pass = md5(sha1(strtolower($this->input->post('txtPass'))));

    if ($userid == '') {
      $this->session->set_flashdata('message', "Login Failed Please Try Again !");
      redirect('login');
      exit;
    }

    if ($pass == '') {
      $this->session->set_flashdata('message', "Login Failed Please Try Again !");
      redirect('login');
      exit;
    }

    $cekuser = $this->M_login->cek_user($userid);
    if ($cekuser == true) {
      $cekpass = $this->M_login->sign_in($userid, $pass);
      if ($cekpass->num_rows() > 0) {
        $row = $cekpass->row();
        $tgl = date('Y/m', now());
        $d = date_create($closing_date->tanggal);

        $tokenData['nameid'] = $userid;
        $tokenData['unique_name'] = $userid;
        $tokenData['role'] = 'Admin';

        $tggl = Date('Y-m-d h:i:s');
        $tglbesok = date('Y-m-d h:i:s', strtotime("+3 days"));

        $tgl2 = strtotime($tglbesok);
        $tgl1 = strtotime($tggl);

        $tokenData['nbf'] = $tgl1;
        $tokenData['exp'] = $tgl2;
        $tokenData['iat'] = $tgl1;

        $jwtToken = $this->GenerateToken($tokenData);

        $this->session->set_flashdata('message', pesan('Ini adalah JWTnya =' . $jwtToken, pesan_sukses()));
        $this->session->set_userdata('closing_date_1', date_format($d, 'd/m/Y'));
        $this->session->set_userdata('userid_1', $userid);
        $this->session->set_userdata('firstname_1', $row->firstname);
        $this->session->set_userdata('lastname_1', $row->lastname);
        $this->session->set_userdata('namalengkap_1', $row->firstname . ' ' . $row->lastname);
        $this->session->set_userdata('groupid_1', $row->groupid);
        $this->session->set_userdata('jabatan_1', $row->jabatan);
        $this->session->set_userdata('company_id', $row->company_id);
        $this->session->set_userdata('periode_1', $tgl);
        $this->session->set_userdata('secret_key_1', $jwtToken);
        //                $this->set_info_device();
        $this->simpan_log();
        redirect('home');
      } else {
        $this->session->set_flashdata('message', "Login Failed Please Try Again !");
        redirect('login');
      }
    } else {
      $this->session->set_flashdata('message', "Login Failed Please Try Again !");
      redirect('login');
    }
  }

  function set_info_device()
  {
    $ipaddr = $_SERVER['REMOTE_ADDR'];
    $this->session->set_userdata('ipaddress', $ipaddr);

    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $this->session->set_userdata('hostname', $hostname);
  }


  function simpan_log()
  {
    $this->load->library(array('User_agent', 'Mobile_Detect', 'Misc'));

    $detect = new Mobile_Detect();

    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? '' : '') : 'PC');

    foreach ($detect->getRules() as $name => $regex) :
      $check = $detect->{'is' . $name}();
      if ($check == 'true') {
        $deviceType .= $name . ' ';
      }
    endforeach;

    if ($this->agent->is_browser()) {
      $agent = $this->agent->browser() . ' ' . $this->agent->version();
    } elseif ($this->agent->is_robot()) {
      $agent = $this->agent->robot();
    } elseif ($this->agent->is_mobile()) {
      $agent = $this->agent->mobile();
    } else {
      $agent = 'Unidentified User Agent';
    }

    // $hostname   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $ipaddr     = ($_SERVER['REMOTE_ADDR'] == '::1') ? '127.0.0.1' : $_SERVER['REMOTE_ADDR'];

    $info = array(
      'date_in'    => date("Y-m-d H:i:s"),
      'userid'     => strtoupper($this->session->userdata('userid_1')),
      'hostname'   => $ipaddr,
      'ip_address' => $ipaddr,
      'device'     => $deviceType,
      'browser'    => $agent,
      'platform'   => $this->misc->platform(),
      'user_agent' => $this->agent->agent_string()
    );

    $login_id = $this->M_login->simpan_log($info);
    if ($login_id === 0) {
      $this->session->set_userdata('login_id', 0);
    } else {
      $this->session->set_userdata('login_id', $login_id);
    }
  }
}
