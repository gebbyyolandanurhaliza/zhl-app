<?php
$this->load->model(array('M_Profit_and_lost'));

error_reporting(0);
$period = $this->input->get('tahun');
$type = $this->input->get('currency');


if ($this->input->get('dari') <> '') {
  $period = $this->input->get('tahun');
  $type = $this->input->get('currency');
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $txtSampai = "A/C for the period ended " . $period;
} else {
  $period = date("Y");
  $type = 'USD';
  $txtSampai = '';
  $dari = date("01-m-Y");
  $sampai = date("d-m-Y");
}
?>
<script>
  function validate(form) {
    var from = document.getElementById("from");
    var to = document.getElementById("to");
    var ageDifMs = to.getTime() - from.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);

    if (ageDifMs > 1) {
      alert('Range date cannot 1 year !');
      return false;
    }
  }
</script>

<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Reporting <small>Profit and Loss</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>
<!-- END PAGE HEAD -->
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Trading, Profit and Loss</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Profit_and_loss/search_period" method="get">
              <div class="form-body">
                <div class="row">
                  <!--/span-->

                  <div class="col-md-6">
                    <label class="control-label col-md-3">Period</label>
                    <div class="col-md-9">
                      <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                        <span class="input-group-addon">
                          to </span>
                        <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-4">Currency Convert</label>
                      <div class="col-md-8">
                        <select name="currency" class="form-control" onchange="cek_rate()">
                          <option value="USD">USD</option>
                          <option value="SGD">SGD</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <!-- <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                            <a href="<?php echo base_url(); ?>Excel/toExcelProfit_Loss?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&type=<?php echo $type; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
            </form>
          </div>
          <hr />
          <div class="row">
            <?php
            if (!empty($get_invoice)) {
              //nilai string
              $bln_awal = $bulan_awal - 1;
              $bln_akhir = $bulan_akhir - 1;
              $subtotal_sales = "SELECT SUM(Debet)- SUM(Kredit)  as subsales FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '4001%'";
              $subtotal_opening = "SELECT SUM(Debet)- SUM(Kredit)  as subopening FROM acc_tbl_trn_jurnal where "
                . "          (MONTH(Tanggal)  BETWEEN '$bln_awal' and '$bln_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '1101%')"
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '1201%') ";
              $subtotal_purchase = "SELECT SUM(Debet)- SUM(Kredit)  as subpurchase FROM acc_tbl_trn_jurnal where "
                . "             (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5002%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5001%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5003%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5004%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '5005%') "
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA = '200104')";
              $subtotal_freight = "SELECT SUM(Debet)- SUM(Kredit)  as subfreight FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA IN ('410201', '620018', '620019')";
              $subtotal_closing = "SELECT SUM(Debet)- SUM(Kredit)  as subclosing FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA like '1101%'"
                . "           or (MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir' and NoCOA like '1201%') ";
              $subtotal_bank = "SELECT SUM(Debet)- SUM(Kredit)  as subbank FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA = '410208'";
              $subtotal_other = "SELECT SUM(Debet)- SUM(Kredit)  as subother FROM acc_tbl_trn_jurnal where MONTH(Tanggal)  BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'  and NoCOA = '410206'";
            ?>
              <!--<div class="contain">-->
              <table class="table table-bordered" id="tabel" width="100%">
                <thead>
                  <tr>
                    <td rowspan="2" style="text-align: right; display: none">
                      &nbsp;
                    </td>
                    <td rowspan="2">
                      &nbsp;
                    </td>
                    <?php
                    $no = 0;
                    $w = 0;
                    for ($i = 0; $i < $jumlah_bulan; $i++) {
                      $bln = $tahun_awal;
                      $dateObj = DateTime::createFromFormat('!Y', $bln);
                      $Bln = strtoupper($dateObj->format('Y'));

                      $nomor = $bulan_awal + $w++;
                      if ($nomor > 12) {
                        $tahun = $Bln + 1;
                      } else {
                        $tahun = $Bln;
                      }
                      echo "<td style='text-align: center;'>$tahun</td>";
                    }
                    ?>
                    <?php
                    if ($jumlah_bulan > 1) {
                      echo "<td style='text-align: center;'>$tahun</td>";
                    }
                    ?>
                  </tr>
                  <tr>
                    <?php
                    for ($i = 0; $i < $jumlah_bulan; $i++) {
                      $bln = $bulan_awal + $no++;
                      $dateObj = DateTime::createFromFormat('!m', $bln);
                      $namaBln = strtoupper($dateObj->format('M'));

                      echo "<td style='text-align: center;'>$namaBln</td>";
                    }
                    if ($jumlah_bulan > 1) {
                      echo "<td style='text-align: center;'>TOTAL</td>";
                    }
                    ?>
                  </tr>

                </thead>
                <tbody>
                  <!-- Header Start -->
                  <?php
                  //sales
                  $s1 = 0;
                  echo "<tr>";
                  echo "<td style='display: none'>13</td>";
                  echo "<td>Sales</td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan = $bulan_awal + $s1++;
                    $dateObj = DateTime::createFromFormat('!m', $blan);
                    $monthName = $dateObj->format('m');

                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));
                    $bln = $monthName;

                    $total_sales = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '4001%'");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $sales = 0 - $r->t_1;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $sales));
                        echo "</td>";
                      }
                    }
                  }

                  //total sales start
                  if ($jumlah_bulan > 1) {
                    $sql_sales = $this->db->query($subtotal_sales);
                    if ($sql_sales->num_rows() > 0) {
                      foreach ($sql_sales->result() as $r) {
                        $subsales = 0 - $r->subsales;
                      }
                    }
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $subsales));
                    echo "</td>";
                  }
                  echo "</tr>";
                  //total sales End
                  //opening stock
                  $op1 = 0;
                  echo "<tr>";
                  echo "<td style='display: none'>12</td>";
                  echo "<td>Opening Stock</td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan = ($bulan_awal - 1) + $op1++;
                    $dateObj = DateTime::createFromFormat('!m', $blan);
                    $monthName = $dateObj->format('m');
                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));
                    $bln = $monthName;

                    $total_opening = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%') or (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $opening = 0 - $r->t_1;
                        $total_opening += 0 - $r->t_1;
                        //str_replace("$", "", money_format('%(#10n', $bln_str));
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $opening));
                        echo "</td>";
                      }
                    }
                  }

                  if ($jumlah_bulan > 1) {
                    $sql = $this->db->query($subtotal_opening);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $ttl_2 = 0 - $r->subopening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $ttl_2));
                        echo "</td>";
                      }
                    }
                  }
                  echo "</tr>";

                  //purchase
                  echo "<tr>";
                  echo "<td style='display: none'>11</td>";
                  echo "<td>Purchase</td>";
                  $pur2 = 0;
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan_pur = $bulan_awal + $pur2++;
                    $dateObj_pur = DateTime::createFromFormat('!m', $blan_pur);
                    $monthName_pur = $dateObj_pur->format('m');
                    $bln_pur = $monthName_pur;


                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahun_pur = strtoupper($dateObjt->format('Y'));

                    $total_purchase = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_purchase FROM acc_tbl_trn_jurnal where "
                      . "                 MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5002%' "
                      . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5001%') "
                      . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5003%') "
                      . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5004%') "
                      . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA like '5005%') "
                      . "                 or (MONTH( Tanggal) = '$bln_pur' and YEAR( Tanggal) = '$tahun_pur' and NoCOA = '200104')");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $purchase = 0 - $r->t_purchase;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $purchase));
                        echo "</td>";
                      }
                    }
                  }
                  if ($jumlah_bulan > 1) {
                    $sql = $this->db->query($subtotal_purchase);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $total_purchase = 0 - $r->subpurchase;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $total_purchase));
                        echo "</td>";
                      }
                    }
                  }
                  echo "</tr>";

                  //total purchase + opening stock
                  $pur1 = 0;
                  $op2 = 0;
                  echo "<tr  style='background:#ddd;'>";
                  echo "<td style='display: none'>10</td>";
                  echo "<td></td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan = $bulan_awal + $pur1++;
                    $dateObj = DateTime::createFromFormat('!m', $blan);
                    $monthName = $dateObj->format('m');
                    $bln = $monthName;

                    $bulan = ($bulan_awal - 1) + $op2++;
                    $dateObje = DateTime::createFromFormat('!m', $bulan);
                    $opmonthName = $dateObje->format('m');
                    $op_bln = $opmonthName;

                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));

                    $total_purchase = 0;

                    $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_opening FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql2->num_rows() > 0) {
                      foreach ($sql2->result() as $s) {
                        $z_opening = 0 - $s->z_opening;
                      }
                    }

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_purchase FROM acc_tbl_trn_jurnal where "
                      . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $pur_op = (0 - $r->z_purchase) + $z_opening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $pur_op));
                        echo "</td>";
                      }
                    }
                  }

                  if ($jumlah_bulan > 1) {
                    $sql = $this->db->query($subtotal_opening);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $ttl_2i = 0 - $r->subopening;
                      }
                    }
                    $sqld = $this->db->query($subtotal_purchase);
                    if ($sqld->num_rows() > 0) {
                      foreach ($sqld->result() as $r) {
                        $total_purchase = (0 - $r->subpurchase) + $ttl_2i;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $total_purchase));
                        echo "</td>";
                      }
                    }
                  }
                  echo "</tr>";

                  //Freight charges
                  echo "<tr>";
                  echo "<td style='display: none'>9</td>";
                  echo "<td>Freight Charges</td>";
                  $fre = 0;
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan_fre = $bulan_awal + $fre++;
                    $dateObj_fre = DateTime::createFromFormat('!m', $blan_fre);
                    $monthName_fre = $dateObj_fre->format('m');
                    $bln_fre = $monthName_fre;


                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahun_fre = strtoupper($dateObjt->format('Y'));

                    $total_fre = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_freight FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln_fre' and YEAR(Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $freight = $f->z_freight;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $freight));
                        echo "</td>";
                      }
                    }
                  }

                  if ($jumlah_bulan > 1) {
                    $sql = $this->db->query($subtotal_freight);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $ttl_4 = $f->subfreight;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $ttl_4));
                        echo "</td>";
                      }
                    }
                  }
                  echo "</tr>";
                  //total purhase End
                  //Closing Stock
                  echo "<tr>";
                  echo "<td style='display: none'>8</td>";
                  echo "<td>Closing Stock</td>";
                  $clo = 0;
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan_clo = $bulan_awal + $clo++;
                    $dateObj_clo = DateTime::createFromFormat('!m', $blan_clo);
                    $monthName_clo = $dateObj_clo->format('m');
                    $bln_clo = $monthName_clo;


                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahun_clo = strtoupper($dateObjt->format('Y'));

                    $total_clo = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as z_closing FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$bln_clo' and YEAR(Tanggal) = '$tahun_clo' and NoCOA like '1101%' or (MONTH(Tanggal) = '$bln_clo' and YEAR(Tanggal) = '$tahun_clo' and NoCOA like '1201%')");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $closing = $f->z_closing;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $closing));
                        echo "</td>";
                      }
                    }
                  }


                  //total closing stock start
                  if ($jumlah_bulan > 1) {
                    $sql = $this->db->query($subtotal_closing);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $ttl_5 = $f->subclosing;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $ttl_5));
                        echo "</td>";
                      }
                    }
                  }
                  echo "</tr>";
                  //total closing stok End
                  //

                  //total freight + closing stock
                  $fre1 = 0;
                  $clo2 = 0;
                  $pur3 = 0;
                  $opn3 = 0;
                  $ox3 = 0;
                  echo "<tr  style='background:#ddd;'>";
                  echo "<td style='display: none'>7</td>";
                  echo "<td></td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $bln_fre1 = $bulan_awal + $fre1++;
                    $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                    $monthName = $dateObj->format('m');
                    $fre_bln = $monthName;

                    $bln_clo2 = $bulan_awal + $clo2++;
                    $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                    $opmonthName = $dateObje->format('m');
                    $clo_bln = $opmonthName;

                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));

                    //opening stock
                    $bln_op3 = ($bulan_awal - 1) + $opn3++;
                    $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                    $op3_bln = $date_op3->format('m');

                    //opening stock
                    $openingx3 = ($bulan_awal - 1) + $ox3++;
                    $tgl_op3 = DateTime::createFromFormat('!m', $openingx3);
                    $openingx33 = $tgl_op3->format('m');


                    $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql_op3->num_rows() > 0) {
                      foreach ($sql_op3->result() as $op3) {
                        $opening_stock = 0 - $op3->t_2;
                      }
                    }

                    //purchasing
                    $bln_pur2 = $bulan_awal + $pur3++;
                    $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                    $pur2_bln = $date_pur2->format('m');
                    $bln = $pur2_bln;

                    $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                      . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                    if ($sql_pur3->num_rows() > 0) {

                      foreach ($sql_pur3->result() as $r) {
                        $pur_opening = (0 - $r->t_1) + $opening_stock;
                      }
                    }

                    //NILAI CLOSING STOCK
                    $sql_closing = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_clo FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql_closing->num_rows() > 0) {
                      foreach ($sql_closing->result() as $s) {
                        $clo = $s->t_clo;
                      }
                    }


                    //NILAI FREIGHT
                    $sql_freight = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_fre FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$fre_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                    if ($sql_freight->num_rows() > 0) {
                      foreach ($sql_freight->result() as $r) {
                        $fre_clo = $r->t_fre + $clo + $pur_opening;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $fre_clo));
                      }
                    }
                  }
                  //total freight + closing stock start
                  if ($jumlah_bulan > 1) {

                    $sql = $this->db->query($subtotal_opening);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $subopening = 0 - $r->subopening;
                      }
                    }
                    $sqld = $this->db->query($subtotal_purchase);
                    if ($sqld->num_rows() > 0) {
                      foreach ($sqld->result() as $r) {
                        $subpurchase = 0 - $r->subpurchase;
                      }
                    }

                    $sql_closing = $this->db->query($subtotal_freight);
                    if ($sql_closing->num_rows() > 0) {
                      foreach ($sql_closing->result() as $s) {
                        $subfreight = $s->subfreight;
                      }
                    }
                    $sql_freight = $this->db->query($subtotal_closing);
                    if ($sql_freight->num_rows() > 0) {
                      foreach ($sql_freight->result() as $r) {
                        $subclosing = $r->subclosing;
                      }
                    }
                    $gross_profit = $subopening + $subpurchase + $subfreight + $subclosing;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $gross_profit));
                  }
                  echo "</tr>";
                  //total freight + closing stok End
                  // == Start Gross Profit = Sales - purchase - freight charges ======
                  $fre4 = 0;
                  $clo4 = 0;
                  $pur4 = 0;
                  $opn4 = 0;
                  $sale4 = 0;

                  echo "<tr'>";
                  echo "<td style='display: none'>6</td>";
                  echo "<td>Gross Profit</td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $bln_fre1 = $bulan_awal + $fre4++;
                    $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                    $monthName = $dateObj->format('m');
                    $fre_bln = $monthName;

                    $bln_clo2 = $bulan_awal + $clo4++;
                    $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                    $opmonthName = $dateObje->format('m');
                    $clo_bln = $opmonthName;

                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));

                    //opening stock
                    $bln_op3 = ($bulan_awal - 1) + $opn4++;
                    $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                    $op3_bln = $date_op3->format('m');

                    $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql_op3->num_rows() > 0) {
                      foreach ($sql_op3->result() as $op3) {
                        $gr_opening = 0 - $op3->t_2;
                      }
                    }

                    //purchasing
                    $bln_pur2 = $bulan_awal + $pur4++;
                    $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                    $pur2_bln = $date_pur2->format('m');
                    $bln = $pur2_bln;

                    $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                      . "                 MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                    if ($sql_pur3->num_rows() > 0) {

                      foreach ($sql_pur3->result() as $r) {
                        $gr_purchasing = 0 - $r->t_1;
                      }
                    }

                    //NILAI CLOSING STOCK
                    $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$clo_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql2->num_rows() > 0) {

                      foreach ($sql2->result() as $s) {
                        $gr_closing = $s->t_clo;
                      }
                    }

                    //nilai sales
                    $bln_sale3 = $bulan_awal + $sale4++;
                    $date_sale3 = DateTime::createFromFormat('!m', $bln_sale3);
                    $sale3_bln = $date_sale3->format('m');

                    $sql_sales = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_sale FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$sale3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '4001%'");
                    if ($sql_sales->num_rows() > 0) {
                      foreach ($sql_sales->result() as $sale) {
                        $gr_sales = 0 - $sale->t_sale;
                      }
                    }

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as gr_freight FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$fre_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                    if ($sql->num_rows() > 0) {
                      //NILAI FREIGHT
                      foreach ($sql->result() as $r) {
                        $gr_freight = $r->gr_freight;
                      }
                    }
                    $gross_total = $gr_opening + $gr_purchasing + $gr_freight + $gr_closing + $gr_sales;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $gross_total));
                    echo "</td>";
                  }

                  // total gross profit start
                  if ($jumlah_bulan > 1) {
                    $gross_profit = $subopening + $subpurchase + $subfreight + $subclosing + $subsales;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $gross_profit));
                  }
                  echo "</tr>";
                  //total freight + closing stok End
                  //
                  // == End Gross Profit = Sales + opening stock + purchase + freight charges + closing stock ======
                  //bank interest
                  echo "<tr>";
                  echo "<td style='display: none'>5</td>";
                  echo "<td>Bank Interest</td>";
                  $bank = 0;
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan_bank = $bulan_awal + $bank++;
                    $dateObj_bank = DateTime::createFromFormat('!m', $blan_bank);
                    $monthName_bank = $dateObj_bank->format('m');
                    $bln_bank = $monthName_bank;


                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahun_bank = strtoupper($dateObjt->format('Y'));

                    $total_gro = 0;

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_bank FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bln_bank' and YEAR( Tanggal) = '$tahun_bank' and NoCOA = '410208'");
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $bank_i = $f->t_bank;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $bank_i));
                        echo "</td>";
                      }
                    }
                  }
                  if ($jumlah_bulan > 1) {
                    $sql_bank = $this->db->query($subtotal_bank);
                    if ($sql_bank->num_rows() > 0) {
                      foreach ($sql_bank->result() as $s) {
                        $subbank = $s->subbank;
                      }
                    }
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $subbank));
                    echo "</td>";
                  }
                  echo "</tr>";

                  //other income
                  echo "<tr>";
                  echo "<td style='display: none'>5</td>";
                  echo "<td>Other Income</td>";
                  $ot = 0;
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $blan_ot = $bulan_awal + $ot++;
                    $dateObj_ot = DateTime::createFromFormat('!m', $blan_ot);
                    $monthName_ot = $dateObj_ot->format('m');
                    $bln_ot = $monthName_ot;


                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahun_ot = strtoupper($dateObjt->format('Y'));

                    $sql_ot = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_bank FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bln_ot' and YEAR( Tanggal) = '$tahun_ot' and NoCOA = '410206'");
                    if ($sql_ot->num_rows() > 0) {
                      foreach ($sql_ot->result() as $f) {
                        $other = $f->t_ot;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $other));
                        echo "</td>";
                      }
                    }
                  }
                  if ($jumlah_bulan > 1) {
                    if ($jumlah_bulan > 1) {
                      $sql_other = $this->db->query($subtotal_other);
                      if ($sql_other->num_rows() > 0) {
                        foreach ($sql_other->result() as $s) {
                          $subother = $s->subother;
                        }
                      }
                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $subother));
                      echo "</td>";
                    }
                  }
                  echo "</tr>";

                  // == Start total ======
                  $fre5 = 0;
                  $clo5 = 0;
                  $pur5 = 0;
                  $opn5 = 0;
                  $sale5 = 0;
                  $oi5 = 0;
                  $bii5 = 0;

                  echo "<tr style='background:#FFF;'>";
                  echo "<td style='display: none'>4</td>";
                  echo "<td>Gross Profit Margin</td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    $bln_fre1 = $bulan_awal + $fre5++;
                    $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                    $monthName = $dateObj->format('m');
                    $fre_bln = $monthName;

                    $bln_clo2 = $bulan_awal + $clo5++;
                    $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                    $opmonthName = $dateObje->format('m');
                    $clo_bln = $opmonthName;

                    $buln = $tahun_awal;
                    $dateObjt = DateTime::createFromFormat('!Y', $buln);
                    $tahunan = strtoupper($dateObjt->format('Y'));

                    //opening stock
                    $bln_op3 = ($bulan_awal - 1) + $opn5++;
                    $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                    $op3_bln = $date_op3->format('m');

                    $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$op3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql_op3->num_rows() > 0) {
                      foreach ($sql_op3->result() as $op3) {
                        $opening_stock = 0 - $op3->t_2;
                      }
                    }

                    //purchasing
                    $bln_pur2 = $bulan_awal + $pur5++;
                    $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                    $pur2_bln = $date_pur2->format('m');
                    $bln_2 = $pur2_bln;

                    $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                      . "                 MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                      . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                      . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                      . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                      . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                      . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                    if ($sql_pur3->num_rows() > 0) {

                      foreach ($sql_pur3->result() as $r) {
                        $pur_opening = (0 - $r->t_1) + $opening_stock;
                      }
                    }

                    //NILAI CLOSING STOCK
                    $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_clo FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$clo_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                    if ($sql2->num_rows() > 0) {

                      foreach ($sql2->result() as $s) {
                        $clo = $s->t_clo;
                      }
                    }

                    //nilai sales
                    $bln_sale3 = $bulan_awal + $sale5++;
                    $date_sale3 = DateTime::createFromFormat('!m', $bln_sale3);
                    $sale3_bln = $date_sale3->format('m');

                    $sql_sales = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_sale FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$sale3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '4001%'");
                    if ($sql_sales->num_rows() > 0) {
                      foreach ($sql_sales->result() as $sale) {
                        $sales = 0 - $sale->t_sale;
                      }
                    }

                    //nilai other income
                    $bln_oi = $bulan_awal + $oi5++;
                    $dateObj_oi = DateTime::createFromFormat('!m', $bln_oi);
                    $monthName_oi = $dateObj_oi->format('m');
                    $oi_bln = $monthName_oi;
                    $sql_ot = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_ot FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$oi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410206'");
                    if ($sql_ot->num_rows() > 0) {
                      foreach ($sql_ot->result() as $f) {
                        $other = $f->t_ot;
                      }
                    }

                    //nilai bank interest
                    $bln_bi = $bulan_awal + $bii5++;
                    $dateObj_bi = DateTime::createFromFormat('!m', $bln_bi);
                    $monthName_bi = $dateObj_bi->format('m');
                    $bi_bln = $monthName_bi;
                    $sql_bi = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_ot FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410208'");
                    if ($sql_bi->num_rows() > 0) {
                      foreach ($sql_bi->result() as $f) {
                        $bank_interest = $f->t_bi;
                      }
                    }

                    $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_fre FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$fre_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                    if ($sql->num_rows() > 0) {
                      //NILAI FREIGHT
                      foreach ($sql->result() as $r) {
                        $fre_clo = $r->t_fre + $clo + $pur_opening + $sales + $other + $bank_interest;
                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $fre_clo));
                        echo "</td>";
                      }
                    }
                  }
                  //total bank interest
                  if ($jumlah_bulan > 1) {
                    $subtotal_all = $subopening + $subpurchase + $subfreight + $subclosing + $subsales + $subbank + $subother;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $subtotal_all));
                    echo "</td>";
                  }
                  echo "</tr>";
                  //total bank interest
                  //
                  // == End Total ======
                  // == Start total ======
                  $fre6 = 0;
                  $clo6 = 0;
                  $pur6 = 0;
                  $opn6 = 0;
                  $sale6 = 0;
                  $oi6 = 0;
                  $bii6 = 0;

                  echo "<tr>";
                  echo "<td style='display: none'>3</td>";
                  echo "<td></td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    echo "<td></td>";
                  }

                  //total margin
                  if ($jumlah_bulan > 1) {
                    echo "<td></td>";
                  }
                  echo "</tr>";
                  //total margin
                  // == End Total ======
                  $gr = 0;

                  echo "<tr style='Background:aquamarine;'>";
                  echo "<td style='display: none'>1</td>";
                  echo "<td><b>General & Administrative Expenses</b></td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    echo "<td></td>";
                  }
                  if ($jumlah_bulan > 1) {
                    echo "<td></td>";
                  }
                  echo "</tr>";

                  //General
                  foreach ($get_invoice as $v) {
                    $s = 0;
                    $x = 0;
                    echo "<tr>";
                    echo "<td style='display: none'></td>";
                    echo "<td>$v->t_nama_group</td>";
                    for ($i = 0; $i < $jumlah_bulan; $i++) {
                      $blan = $bulan_awal + $s++;
                      $dateObj = DateTime::createFromFormat('!m', $blan);
                      $monthName = $dateObj->format('m');
                      $buln = $tahun_awal;
                      $dateObjt = DateTime::createFromFormat('!Y', $buln);
                      $tahunan = strtoupper($dateObjt->format('Y'));
                      $nomor = $bulan_awal + $w++;

                      $coa = $v->t_no_coa;
                      $bln = $monthName;

                      $total = 0;
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet-Kredit),0) as Total FROM acc_tbl_trn_jurnal WHERE NoCOA = '$coa' AND MONTH(Tanggal) = '$bln' AND Year(Tanggal) = '$tahunan'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $bln_str = 0 - $r->Total;
                          //str_replace("$", "", money_format('%(#10n', $bln_str));
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'>";
                          echo str_replace("$", "", money_format('%(#10n', $bln_str));
                          echo "</td>";
                        }
                      }
                      //total sales start
                    }
                    if ($jumlah_bulan > 1) {
                      $sql = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 AND c.NoCOA = '$coa' and MONTH( Tanggal) BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR( Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $total_general = 0 - $r->Total;
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'>";
                          echo str_replace("$", "", money_format('%(#10n', $total_general));
                          echo "</td>";
                        }
                      }
                    }
                  }

                  echo "</tr>";
                  //total GENERAL
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td style='display: none'></td>
                    <td><b>Total Expenses</b></td>
                    <?php
                    $dx = 0;
                    $rx = 0;
                    $t_blan = 0;
                    for ($i = 0; $i < $jumlah_bulan; $i++) {
                      $blan = $bulan_awal + $dx++;
                      $dateObj = DateTime::createFromFormat('!m', $blan);
                      $monthName = $dateObj->format('m');
                      $buln = $tahun_awal;
                      $dateObjt = DateTime::createFromFormat('!Y', $buln);
                      $tahunan = strtoupper($dateObjt->format('Y'));
                      $bln = $monthName;

                      $bln_str = 0;
                      $sql = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 and MONTH(Tanggal) = '$bln' AND Year(Tanggal) = '$tahunan'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $bln_str = 0 - $r->Total;
                          //str_replace("$", "", money_format('%(#10n', $bln_str));
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'>";
                          echo str_replace("$", "", money_format('%(#10n', $bln_str));
                          echo "</td>";
                        }
                      }
                      //total GENERAL
                    }
                    //total sales start
                    if ($jumlah_bulan > 1) {
                      $sql = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 and MONTH(Tanggal) BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $Total = 0 - $r->Total;
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'>";
                          echo str_replace("$", "", money_format('%(#10n', $Total));
                          echo "</td>";
                        }
                      }
                    }
                    ?>
                  </tr>
                  <tr>
                    <td style='display: none'></td>
                    <td><b>Profit / (Loss) Before Taxation</b></td>
                    <?php
                    $fre7 = 0;
                    $clo7 = 0;
                    $opn7 = 0;
                    $pur7 = 0;
                    $sale7 = 0;
                    $oi7 = 0;
                    $bii7 = 0;
                    for ($i = 0; $i < $jumlah_bulan; $i++) {
                      $bln_fre1 = $bulan_awal + $fre7++;
                      $dateObj = DateTime::createFromFormat('!m', $bln_fre1);
                      $monthName = $dateObj->format('m');
                      $fre_bln = $monthName;

                      $bln_clo2 = $bulan_awal + $clo7++;
                      $dateObje = DateTime::createFromFormat('!m', $bln_clo2);
                      $opmonthName = $dateObje->format('m');
                      $clo_bln = $opmonthName;

                      $buln = $tahun_awal;
                      $dateObjt = DateTime::createFromFormat('!Y', $buln);
                      $tahunan = strtoupper($dateObjt->format('Y'));

                      //opening stock
                      $bln_op3 = ($bulan_awal - 1) + $opn7++;
                      $date_op3 = DateTime::createFromFormat('!m', $bln_op3);
                      $op3_bln = $date_op3->format('m');

                      $sql_op3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_2 FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$op3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$op3_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                      if ($sql_op3->num_rows() > 0) {
                        foreach ($sql_op3->result() as $op3) {
                          $opening_stock = 0 - $op3->t_2;
                        }
                      }

                      //purchasing
                      $bln_pur2 = $bulan_awal + $pur7++;
                      $date_pur2 = DateTime::createFromFormat('!m', $bln_pur2);
                      $pur2_bln = $date_pur2->format('m');
                      $bln_2 = $pur2_bln;

                      $sql_pur3 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_1 FROM acc_tbl_trn_jurnal where "
                        . "                 MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5002%' "
                        . "                 or (MONTH( Tanggal) = '$bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5001%') "
                        . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5003%') "
                        . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5004%') "
                        . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA like '5005%') "
                        . "                 or (MONTH( Tanggal) = '$bln_2' and YEAR( Tanggal) = '$tahunan' and NoCOA = '200104')");
                      if ($sql_pur3->num_rows() > 0) {

                        foreach ($sql_pur3->result() as $r) {
                          $pur_opening = (0 - $r->t_1) + $opening_stock;
                        }
                      }

                      //NILAI CLOSING STOCK
                      $sql2 = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_clo FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$clo_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '1101%' or (MONTH(Tanggal) = '$clo_bln' and YEAR(Tanggal) = '$tahunan' and NoCOA like '1201%')");
                      if ($sql2->num_rows() > 0) {

                        foreach ($sql2->result() as $s) {
                          $clo = $s->t_clo;
                        }
                      }

                      //nilai sales
                      $bln_sale3 = $bulan_awal + $sale7++;
                      $date_sale3 = DateTime::createFromFormat('!m', $bln_sale3);
                      $sale3_bln = $date_sale3->format('m');

                      $sql_sales = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_sale FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$sale3_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '4001%'");
                      if ($sql_sales->num_rows() > 0) {
                        foreach ($sql_sales->result() as $sale) {
                          $sales = 0 - $sale->t_sale;
                        }
                      }

                      //nilai other income
                      $bln_oi = $bulan_awal + $oi7++;
                      $dateObj_oi = DateTime::createFromFormat('!m', $bln_oi);
                      $monthName_oi = $dateObj_oi->format('m');
                      $oi_bln = $monthName_oi;
                      $sql_ot = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_ot FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$oi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410206'");
                      if ($sql_ot->num_rows() > 0) {
                        foreach ($sql_ot->result() as $f) {
                          $other = $f->t_ot;
                        }
                      }

                      //nilai bank interest
                      $bln_bi = $bulan_awal + $bii7++;
                      $dateObj_bi = DateTime::createFromFormat('!m', $bln_bi);
                      $monthName_bi = $dateObj_bi->format('m');
                      $bi_bln = $monthName_bi;
                      $sql_bi = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_ot FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$bi_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA like '410208'");
                      if ($sql_bi->num_rows() > 0) {
                        foreach ($sql_bi->result() as $f) {
                          $bank_interest = $f->t_bi;
                        }
                      }

                      $bln_str = 0;
                      $sql_tx = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 and MONTH(Tanggal) = '$bln' AND Year(Tanggal) = '$tahunan'");
                      if ($sql_tx->num_rows() > 0) {
                        foreach ($sql_tx->result() as $r) {
                          $bln_stx = 0 - $r->Total;
                        }
                      }

                      $sql = $this->db->query("SELECT SUM(Debet)- SUM(Kredit)  as t_fre FROM acc_tbl_trn_jurnal where MONTH( Tanggal) = '$fre_bln' and YEAR( Tanggal) = '$tahunan' and NoCOA IN ('410201', '620018', '620019')");
                      if ($sql->num_rows() > 0) {
                        //NILAI FREIGHT
                        foreach ($sql->result() as $r) {
                          $fre_clo = ($r->t_fre + $clo + $pur_opening + $sales + $other + $bank_interest) + $bln_stx;
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'><b>";
                          echo str_replace("$", "", money_format('%(#10n', $fre_clo));
                          echo "</b></td>";
                        }
                      }
                    }

                    //total sales start
                    if ($jumlah_bulan > 1) {
                      $subtotal_all = $subopening + $subpurchase + $subfreight + $subclosing + $subsales + $subbank + $subother;

                      $sql = $this->db->query("SELECT SUM(Debet)-SUM(Kredit) as Total FROM acc_report_coa a INNER JOIN acc_tbl_trn_jurnal as c on a.no_coa = c.NoCOA INNER JOIN acc_report_group AS b ON a.id_kategori = b.id where a.id_group = '1' and b.no_urut = 0 and MONTH(Tanggal) BETWEEN '$bulan_awal' and '$bulan_akhir' and YEAR(Tanggal) BETWEEN '$tahun_awal' and '$tahun_akhir'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $Total = $subtotal_all + 0 - $r->Total;
                          setlocale(LC_MONETARY, 'en_US.UTF-8');
                          echo "<td style='text-align:right'><b>";
                          echo str_replace("$", "", money_format('%(#10n', $Total));
                          echo "</b></td>";
                        }
                      }
                    }
                    ?>
                  </tr>

                </tfoot>
              </table>
              <!--</div>-->
            <?php
              //}
            }
            ?>
            <!--<i style="color:red;">* Click total monthly for Profit and Loss Statement</i>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 600,
      "scrollX": true,
      "iDisplayLength": 100,
      "order": [
        [0, 'desc'],
        [1, 'asc']
      ]
    });

  });
</script>