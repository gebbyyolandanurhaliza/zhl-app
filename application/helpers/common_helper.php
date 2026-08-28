<?php

if (!function_exists('on_dev_page')) {
  function on_dev_page()
  {
    $ci = get_instance();
    $array = ['eva', 'ardiansyah', 'anisa'];
    if (!in_array($ci->session->userdata('userid_1'), $array)) {
      echo '<script>alert("Sorry, the page on development..")</script>';
      redirect('', 'refresh');
    } else {
      return FALSE;
    }
  }

  function remove_zero_behind($num)
  {
    return number_format($num, 0);
  }
}
