<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    //$this->load->model(array('m_login'));
    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }

    if (preg_match('/(?i)msie [5-9]/', $_SERVER['HTTP_USER_AGENT'])) {
      redirect('login');
    }

    $this->load->model(array('M_Home', 'M_shipping'));
    $this->load->library('table');
    $this->load->helper('smiley');
  }

  public function index1()
  {
    $this->template->display('home');
  }

  function set_session_update()
  {
    $company_id = $this->input->post('company_id');
    $this->session->set_userdata('company_id', $company_id);
    $referer = $this->input->server('HTTP_REFERER');
    redirect($referer);

  }

  public function dashboard()
  {
    $image_array = get_clickable_smileys(base_url() . 'assets/global/smileys/', 'txtMessage');
    $col_array = $this->table->make_columns($image_array, 6);
    $tmpl = array('table_open'  => '<table border="0" cellpadding="4" cellspacing="0" id="tblEmot" >');
    $this->table->set_template($tmpl);
    $data   = array(
      'smiley_table'  => $this->table->generate($col_array),
      'cari_rate'     => $this->M_Home->get_kurs(),
      'cari_user'     => $this->M_Home->get_user()
    );
    $this->template->display('dashboard', $data);
  }

  // public function index()
  // {
  //     $image_array = get_clickable_smileys(base_url() . 'assets/global/smileys/', 'txtMessage');
  //     $col_array = $this->table->make_columns($image_array, 6);
  //     $tmpl = array('table_open'  => '<table border="0" cellpadding="4" cellspacing="0" id="tblEmot" >');
  //     $this->table->set_template($tmpl);

  //     $kur_array = $this->M_Home->get_kurs_new();

  //     $data   = array(
  //         'smiley_table' => $this->table->generate($col_array),
  //         'cari_rate'    => $kur_array['result'],
  //         'cari_user'    => $this->M_Home->get_user(),
  //         'periode'      => $kur_array['get']
  //     );
  //     $this->template->display('dashboard-new', $data);
  // }

  public function index()
  {
    $image_array = get_clickable_smileys(base_url() . 'assets/global/smileys/', 'txtMessage');
    $kur_array = $this->M_Home->get_kurs_new();

    $data['kurs'] = $kur_array['result'];
    $data['getListShipmentDate'] = $this->M_shipping->getAllShipmentDate();


    $data['title'] = "test";

    $this->template->display('dashboard-new', $data);
  }

  function sendMessage()
  {
    $data   = array(
      'username'  => trim(strip_tags($this->session->userdata('userid_1'))),
      'message'   => trim(strip_tags($this->input->post('txtMessage'))),
      'datetime'  => date('Y-m-d H:i:s')
    );
    $this->M_Home->insertChat($data);
  }

  function viewMessage()
  {
    $selectChat = $this->M_Home->selectChat()->result();
    $countChat  = $this->M_Home->selectChat()->num_rows();
    $num        = 1;
    if (!empty($selectChat)) {
      echo '<ul class="timeline">';

      foreach ($selectChat as $row) :
        $str        = parse_smileys($row->message, base_url() . "assets/global/smileys/");
        $datetime   = $this->timeAgo($row->datetime);
        $time       = date('H:i', strtotime($row->datetime));
        $date       = date('F, d Y', strtotime($row->datetime));
        echo '<li class="';
        if ($num++ == $countChat) {
          echo 'timeline-noline ';
        }
        if (strtoupper($this->session->userdata('userid_1')) == strtoupper($row->username)) {
          echo 'timeline-blue">';
        } else {
          echo 'timeline-grey">';
        }
        echo '<div class="timeline-time">
                                <span class="date">
                                    ' . $date . ' </span>
                                <span class="time">
                                    ' . $time . ' </span>
                            </div>
                            <div class="timeline-icon">
                                <img src="' . base_url() . 'assets/admin/img/user.png" />
                            </div>
                            <div class="timeline-body">
                                <h4>';
        if ($row->lastname == NULL) {
          echo ucwords(strtolower($row->username));
        } else {
          echo ucwords(strtolower($row->firstname));
        }
        echo ', <span class="time-ago">' . $datetime . '</span></h4>
                                <div class="timeline-content">
                                    ' . $str . '
                                </div>
                            </div>
                        </li>';
      endforeach;

      echo '</ul>';
    } else {
      echo "No Messages";
    }
  }

  function viewMessageNew()
  {
    $selectChat = $this->M_Home->selectChat()->result();
    $countChat  = $this->M_Home->selectChat()->num_rows();
    $num        = 1;
    if (!empty($selectChat)) {
      echo '<ol class="chat">';

      foreach ($selectChat as $row) :
        $str        = parse_smileys($row->message, base_url() . "assets/global/smileys/");
        $datetime   = $this->timeAgo($row->datetime);
        $time       = date('H:i', strtotime($row->datetime));
        $date       = date('F, d Y', strtotime($row->datetime));

        if (strtoupper($this->session->userdata('userid_1')) == strtoupper($row->username)) {
          echo '<li class="self">
                                <div class="avatar-ol">
                                    <div class="text-in-circle-small-self">' . substr($row->firstname, 0, 1) . '</div>
                                </div>
                                <div class="msg">
                                    <strong>' . ucwords(strtolower($row->firstname)) . '</strong>
                                    <p>' . $str . '</p>
                                    <time>' . $datetime . '</time>
                                </div>
                            </li>';
        } else {
          echo '<li class="other">
                                <div class="avatar-ol">
                                    <div class="text-in-circle-small-other">' . substr($row->firstname, 0, 1) . '</div>
                                </div>
                                <div class="msg">
                                    <strong>' . ucwords(strtolower($row->firstname)) . '</strong>
                                    <p>' . $str . '</p>
                                    <time>' . $datetime . '</time>
                                </div>
                            </li>';
        }
      endforeach;

      echo '</ol>';
    } else {
      echo "No Messages";
    }
  }

  function timeAgo($datetime)
  {
    $time_ago = strtotime($datetime);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed;
    $minutes    = round($time_elapsed / 60);
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400);
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640);
    $years      = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
      return "Just now";
    }
    //Minutes
    else if ($minutes <= 60) {
      if ($minutes == 1) {
        return "One minute ago";
      } else {
        return "$minutes minutes ago";
      }
    }
    //Hours
    else if ($hours <= 24) {
      if ($hours == 1) {
        return "an Hour ago";
      } else {
        return "$hours hours ago";
      }
    }
    //Days
    else if ($days <= 7) {
      if ($days == 1) {
        return "Yesterday";
      } else {
        return "$days days ago";
      }
    }
    //Weeks
    else if ($weeks <= 4.3) {
      if ($weeks == 1) {
        return "a Week ago";
      } else {
        return "$weeks weeks ago";
      }
    }
    //Months
    else if ($months <= 12) {
      if ($months == 1) {
        return "a Month ago";
      } else {
        return "$months months ago";
      }
    }
    //Years
    else {
      if ($years == 1) {
        return "One year ago";
      } else {
        return "$years years ago";
      }
    }
  }

  function signout()
  {
    $login_id = $this->session->userdata('login_id');

    if ($login_id != '') {
      $this->M_login->simpan_log_out($login_id);
    }

    $this->session->unset_userdata('userid_1');
    $this->session->unset_userdata('username_1');
    $this->session->unset_userdata('login_id_1');
    redirect('login');
  }

  function dev_mode()
  {
    echo ENVIRONMENT;
  }

  /* function signout() {
        $signid = $this->session->userdata('signid');

        if ($signid <> '') {
            $this->m_login->simpan_log_out($signid);
        }

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        redirect('login');
    } */
}
