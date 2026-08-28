<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function dmy_to_ymd($tgl)
{
  $tanggal = substr($tgl, 0, 2);
  $bulan  = substr($tgl, 3, 2);
  $tahun  = substr($tgl, 6, 4);
  return $tahun . '-' . $bulan . '-' . $tanggal;
}

function tgl_ymd($tgl)
{
  $bulan  = substr($tgl, 0, 2);
  $tanggal = substr($tgl, 3, 2);
  $tahun  = substr($tgl, 6, 4);
  return $tahun . '-' . $bulan . '-' . $tanggal;
}

function tgl_dmy($tgl)
{
  return date("d/m/Y",  strtotime($tgl));
}

function tgl_dmy_strip($tgl)
{
  return date("d-m-Y",  strtotime($tgl));
}

function tgl_mdy($tgl)
{
  return date("m-d-Y",  strtotime($tgl));
}

function tgl_dmy2($tgl)
{
  return date("d-m-Y",  strtotime($tgl));
}

function tgl_eng($tgl)
{
  $tanggal  = substr($tgl, 0, 2);
  $bulan  = substr($tgl, 3, 2);
  $tahun  = substr($tgl, 6, 4);
  return $tahun . '-' . $bulan . '-' . $tanggal;
}

function tgl_ind($tgl)
{
  return date("d/m/Y",  strtotime($tgl));
}

function add_date_ind($orgDate, $mth)
{
  $cd = strtotime($orgDate);
  $retDAY = date('d/m/Y', mktime(0, 0, 0, date('m', $cd) + $mth, date('d', $cd), date('Y', $cd)));
  return $retDAY;
}

function periode($tgl)
{
  $bulan  = substr($tgl, 3, 2);
  $tahun  = substr($tgl, 6, 4);
  return $bulan . '/' . $tahun;
}

function periode_po($tgl_dmy)
{
  $bulan  = substr($tgl_dmy, 3, 2);
  $tahun  = substr($tgl_dmy, 8, 2);
  return $bulan . '/' . $tahun;
}

function dateDifference($date_1, $date_2, $differenceFormat = '%R%a')    //http://php.net/manual/en/function.date-diff.php#115065
{
  $datetime1 = date_create($date_1);
  $datetime2 = date_create($date_2);

  $interval = date_diff($datetime1, $datetime2);

  return $interval->format($differenceFormat);
}


function convert_tgl_db($tgl)
{
  return date("Y-m-d",  strtotime($tgl));
}

function convert_tgl_db_2($tgl)
{
  return date("Y-m-d",  strtotime(str_replace('/', '-', $tgl)));
}

function convert_tgl_2($tgl)
{
  return date("d/m/Y",  strtotime(str_replace('-', '/', $tgl)));
}

function tgl_db()
{
  return date("Y-m-d");
}
