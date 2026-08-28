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
  $hide = $this->input->get('hide');
} else {
  $period = date("Y");
  $type = 'USD';
  $dari = date("01-m-Y");
  $sampai = date("d-m-Y");
  $hide = '';
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

                  <div class="col-md-5">
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
                  <!-- div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Currency</label>
                                            <div class="col-md-8">
                                                <select name="currency" class="form-control" onchange="cek_rate()">
                                                    <option value="USD">USD</option>
                                                    <option value="SGD">SGD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->

                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Refresh</button>
                        <a href="<?php echo base_url(); ?>Excel3/toExcelProfit_Loss2?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&type=<?php echo $type; ?>&hide=<?php echo $hide; ?>" class="btn green col-md-3"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Profit_and_loss/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->

                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-5">
                    <div class="col-md-9 col-md-push-3">
                      <div class="form-group">
                        <label class="col-md-5" style="padding-left: 0px;"><input type="checkbox" name="hide" id="hide" value="1" <?php if ($hide == "1") {
                                                                                                                                    echo 'checked';
                                                                                                                                  } ?>>Hidden Month</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <hr />
          <div class="row">
            <?php
            if (!empty($get_coa)) {
              //nilai string
              $bln_awal = $bulan_awal - 1;
              $bln_akhir = $bulan_akhir - 1;

              $subtotal_sales = "SELECT IFNULL(SUM(Debet - Kredit),0)  as subsales FROM acc_tbl_trn_jurnal where Tanggal  BETWEEN '$awal' and '$akhir' and  NoCOA in (select no_coa from acc_report_coa where id_group = 1) ";

              $subtotal_purchase = "SELECT IFNULL(SUM(Debet - Kredit),0)  as subpurchase FROM acc_tbl_trn_jurnal where Tanggal  BETWEEN '$awal' and '$akhir' and  NoCOA in (select no_coa from acc_report_coa where id_group = 72)  ";

              $subtotal_sales_purchase = "SELECT IFNULL(SUM(Debet - Kredit),0)  as subsalepurchase FROM acc_tbl_trn_jurnal where Tanggal  BETWEEN '$awal' and '$akhir' and  NoCOA in (select no_coa from acc_report_coa where id_group in (1,72))  ";

              $subtotal_closing = "SELECT IFNULL(SUM(Debet - Kredit),0)  as subclosing FROM acc_tbl_trn_jurnal where Tanggal  BETWEEN '$awal' and '$akhir' and  NoCOA in (select no_coa from acc_report_coa where id_group = 226) ";

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
                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $b = $i - 1;
                      $tahun = date('Y', strtotime('+' . $b . ' month', strtotime($dari_new)));

                      if ($hide != '1') {
                        echo "<td style='text-align: center;'>$tahun</td>";
                      }
                    }

                    if ($jumlah_bulan > 0) {
                      echo "<td style='text-align: center;'>$tahun</td>";
                    }
                    ?>
                  </tr>
                  <tr>
                    <?php
                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $b = $i - 1;
                      $namaBln = date('F', strtotime('+' . $b . ' month', strtotime($dari_new)));

                      if ($hide != '1') {
                        echo "<td style='text-align: center;'>$namaBln</td>";
                      }
                    }

                    if ($jumlah_bulan > 0) {
                      echo "<td style='text-align: center;'>TOTAL</td>";
                    }
                    ?>
                  </tr>

                </thead>
                <tbody>
                  <!-- Header Start -->
                  <?php

                  // 1 sales ,72 purchases,224 general,225 income, 73 other income
                  //sales
                  echo "<tr>";
                  echo "<td style='display: none'>16</td>";
                  echo "<td>Sales</td>";

                  for ($i = 1; $i <= $jumlah_bulan; $i++) {
                    $b = $i - 1;
                    if ($jumlah_bulan == 1) {
                      $new_awal = $awal;
                      $new_akhir = $akhir;
                    } else {
                      switch ($i) {
                        case 1:
                          $new_awal = $awal;
                          $new_akhir = date('Y-m-t', strtotime($dari));
                          break;
                        case $jumlah_bulan:
                          $new_awal = date('Y-m-01', strtotime($sampai));
                          $new_akhir = $akhir;
                          break;
                        default:
                          $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          break;
                      }
                    }

                    if ($hide != '1') {

                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as t_1 FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir' and NoCOA in (select no_coa from acc_report_coa where id_group = 1) ");

                      $sales = 0;

                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $sales = 0 - $r->t_1;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $sales));
                      echo "</td>";
                    }
                  }

                  //total sales start
                  if ($jumlah_bulan > 0) {
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

                  //purchase
                  echo "<tr>";
                  echo "<td style='display: none'>15</td>";
                  echo "<td>Purchase</td>";
                  for ($i = 1; $i <= $jumlah_bulan; $i++) {
                    $b = $i - 1;
                    if ($jumlah_bulan == 1) {
                      $new_awal = $awal;
                      $new_akhir = $akhir;
                    } else {
                      switch ($i) {
                        case 1:
                          $new_awal = $awal;
                          $new_akhir = date('Y-m-t', strtotime($dari_new));
                          break;
                        case $jumlah_bulan:
                          $new_awal = date('Y-m-01', strtotime($sampai));
                          $new_akhir = $akhir;
                          break;
                        default:
                          $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          break;
                      }
                    }

                    if ($hide != '1') {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)   as t_purchase FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir' and NoCOA in (select no_coa from acc_report_coa where id_group = 72) ");

                      $purchase = 0;
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $purchase = 0 - $r->t_purchase;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $purchase));
                      echo "</td>";
                    }
                  }

                  if ($jumlah_bulan > 0) {
                    $sql = $this->db->query($subtotal_purchase);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $total_purchase = 0 - $r->subpurchase;
                      }
                    }

                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $total_purchase));
                    echo "</td>";
                  }

                  echo "</tr>";

                  //total purchase 
                  echo "<tr  style='background:#ddd;'>";
                  echo "<td style='display: none'>14</td>";
                  echo "<td></td>";
                  for ($i = 1; $i <= $jumlah_bulan; $i++) {
                    $b = $i - 1;
                    if ($jumlah_bulan == 1) {
                      $new_awal = $awal;
                      $new_akhir = $akhir;
                    } else {
                      switch ($i) {
                        case 1:
                          $new_awal = $awal;
                          $new_akhir = date('Y-m-t', strtotime($dari_new));
                          break;
                        case $jumlah_bulan:
                          $new_awal = date('Y-m-01', strtotime($sampai));
                          $new_akhir = $akhir;
                          break;
                        default:
                          $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          break;
                      }
                    }

                    if ($hide != '1') {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as z_opening FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir' and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72)) ");

                      $z_opening = 0;

                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $z_opening = 0 - $r->z_opening;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $z_opening));
                      echo "</td>";
                    }
                  }



                  if ($jumlah_bulan > 0) {
                    $sql = $this->db->query($subtotal_sales_purchase);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $r) {
                        $total_sales_purchase = 0 - $r->subsalepurchase;
                      }
                    }

                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $total_sales_purchase));
                    echo "</td>";
                  }

                  echo "</tr>";

                  //Closing Stock
                  echo "<tr>";
                  echo "<td style='display: none'>13</td>";
                  echo "<td>Closing Stock</td>";
                  for ($i = 1; $i <= $jumlah_bulan; $i++) {
                    $b = $i - 1;
                    if ($jumlah_bulan == 1) {
                      $new_awal = $awal;
                      $new_akhir = $akhir;
                    } else {
                      switch ($i) {
                        case 1:
                          $new_awal = $awal;
                          $new_akhir = date('Y-m-t', strtotime($dari_new));
                          break;
                        case $jumlah_bulan:
                          $new_awal = date('Y-m-01', strtotime($sampai));
                          $new_akhir = $akhir;
                          break;
                        default:
                          $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          break;
                      }
                    }

                    if ($hide != '1') {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as z_closing FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir' and NoCOA in (select no_coa from acc_report_coa where id_group = 226 ) ");

                      $closing = 0;
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $f) {
                          $closing = 0 - $f->z_closing;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', 0));
                      echo "</td>";
                    }
                  }


                  //total closing stock start
                  if ($jumlah_bulan > 0) {
                    $sql = $this->db->query($subtotal_closing);
                    if ($sql->num_rows() > 0) {
                      foreach ($sql->result() as $f) {
                        $total_closing = $f->subclosing;
                      }
                    }

                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', 0));
                    echo "</td>";
                  }

                  echo "</tr>";
                  //total closing stok End
                  //

                  // == Gross Profit  ======
                  echo "<tr'>";
                  echo "<td style='display: none'>12</td>";
                  echo "<td>Gross Profit</td>";
                  for ($i = 1; $i <= $jumlah_bulan; $i++) {
                    $b = $i - 1;
                    if ($jumlah_bulan == 1) {
                      $new_awal = $awal;
                      $new_akhir = $akhir;
                    } else {
                      switch ($i) {
                        case 1:
                          $new_awal = $awal;
                          $new_akhir = date('Y-m-t', strtotime($dari_new));
                          break;
                        case $jumlah_bulan:
                          $new_awal = date('Y-m-01', strtotime($sampai));
                          $new_akhir = $akhir;
                          break;
                        default:
                          $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                          break;
                      }
                    }

                    if ($hide != '1') {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as sub_gross_profit FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72))");

                      $sub_gross_profit = 0;

                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $f) {
                          $sub_gross_profit = 0 - $f->sub_gross_profit;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $sub_gross_profit));
                      echo "</td>";
                    }
                  }

                  // total gross profit start
                  if ($jumlah_bulan > 0) {
                    $total_gross_profit = $total_sales_purchase;
                    setlocale(LC_MONETARY, 'en_US.UTF-8');
                    echo "<td style='text-align:right'>";
                    echo str_replace("$", "", money_format('%(#10n', $total_gross_profit));
                    echo "</td>";
                  }
                  echo "</tr>";

                  //
                  //
                  // == End Gross Profit  ======

                  echo "<tr style='Background:aquamarine;'>";
                  echo "<td style='display: none'>11</td>";
                  echo "<td><b>General & Administrative Expenses</b></td>";
                  for ($i = 0; $i < $jumlah_bulan; $i++) {
                    if ($hide != '1') {
                      echo "<td></td>";
                    }
                  }
                  if ($jumlah_bulan > 0) {
                    echo "<td></td>";
                  }
                  echo "</tr>";

                  //General
                  foreach ($get_coa as $v) {
                    $s = 17;
                    echo "<tr>";
                    echo "<td style='display: none'>'.$s++'.</td>";
                    echo "<td>$v->AccountName</td>";
                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as subtotal FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA = '$coa'");

                        $bln_str = 0;

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $bln_str = 0 - $r->subtotal;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $bln_str));
                        echo "</td>";
                      }

                      //total sales start
                    }

                    if ($jumlah_bulan > 0) {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as total FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA = '$coa'");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $total_general = 0 - $r->total;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $total_general));
                      echo "</td>";
                    }
                  }

                  echo "</tr>";
                  //total GENERAL
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td style='display: none'>b11</td>
                    <td><b>Total Expenses</b></td>
                    <?php
                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->t_no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0)  as sub_grandtotal FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 224) ");

                        $grand_bln_str = 0;
                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $grand_bln_str = 0 - $r->sub_grandtotal;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $grand_bln_str));
                        echo "</td>";
                      }
                      //total GENERAL
                    }
                    //total sales start
                    if ($jumlah_bulan > 0) {
                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as grandtotal FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 224) ");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $GrandTotal = 0 - $r->grandtotal;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $GrandTotal));
                      echo "</td>";
                    }
                    ?>
                  </tr>

                  <tr>
                    <td style='display: none'>b12</td>
                    <td><b>Profit / (Loss) before Taxation</b></td>
                    <?php

                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->t_no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as sub_profit FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (SELECT no_coa from acc_report_coa where id_group in (1,72,224)) ");

                        $sub_profit = 0;

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $sub_profit = 0 - $r->sub_profit;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'><b>";
                        echo str_replace("$", "", money_format('%(#10n', $sub_profit));
                        echo "</b></td>";
                      }
                    }

                    //total sales start
                    if ($jumlah_bulan > 0) {

                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as profit FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72,224)) ");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $profit = 0 - $r->profit;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'><b>";
                      echo str_replace("$", "", money_format('%(#10n', $profit));
                      echo "</b></td>";
                    }
                    ?>
                  </tr>

                  <!-- Start Income -->
                  <tr>
                    <td style='display: none'>b13</td>
                    <td>Income Tax</td>
                    <?php

                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->t_no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as sub_income FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 225) ");

                        $sub_income = 0;

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $sub_income = 0 - $r->sub_income;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $sub_income));
                        echo "</td>";
                      }
                    }


                    if ($jumlah_bulan > 0) {

                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as income FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 225) ");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $income = 0 - $r->income;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $income));
                      echo "</td>";
                    }
                    ?>
                  </tr>

                  <!-- End Income -->
                  <!-- start other Income -->
                  <tr>
                    <td style='display: none'>b14</td>
                    <td>Other Income</td>
                    <?php

                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->t_no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as sub_other FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 73) ");

                        $sub_other = 0;

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $sub_other = 0 - $r->sub_other;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'>";
                        echo str_replace("$", "", money_format('%(#10n', $sub_other));
                        echo "</td>";
                      }
                    }

                    if ($jumlah_bulan > 0) {

                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as other FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group = 73) ");
                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $other = 0 - $r->other;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'>";
                      echo str_replace("$", "", money_format('%(#10n', $other));
                      echo "</td>";
                    }
                    ?>
                  </tr>

                  <!-- end Other Income -->

                  <!-- Start Profit /Loss -->
                  <tr>
                    <td style='display: none'></td>
                    <td><b>Profit / (Loss) Before Taxation</b></td>
                    <?php

                    for ($i = 1; $i <= $jumlah_bulan; $i++) {
                      $coa = $v->t_no_coa;
                      $b = $i - 1;
                      if ($jumlah_bulan == 1) {
                        $new_awal = $awal;
                        $new_akhir = $akhir;
                      } else {
                        switch ($i) {
                          case 1:
                            $new_awal = $awal;
                            $new_akhir = date('Y-m-t', strtotime($dari_new));
                            break;
                          case $jumlah_bulan:
                            $new_awal = date('Y-m-01', strtotime($sampai));
                            $new_akhir = $akhir;
                            break;
                          default:
                            $new_awal = date('Y-m-01', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            $new_akhir = date('Y-m-t', strtotime('+' . $b . ' month', strtotime($dari_new)));
                            break;
                        }
                      }

                      if ($hide != '1') {
                        $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as sub_grand_profit FROM acc_tbl_trn_jurnal where Tanggal between '$new_awal' and '$new_akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72,73,224,225)) ");

                        $sub_grand_profit = 0;

                        if ($sql->num_rows() > 0) {
                          foreach ($sql->result() as $r) {
                            $sub_grand_profit = 0 - $r->sub_grand_profit;
                          }
                        }

                        setlocale(LC_MONETARY, 'en_US.UTF-8');
                        echo "<td style='text-align:right'><b>";
                        echo str_replace("$", "", money_format('%(#10n', $sub_grand_profit));
                        echo "</b></td>";
                      }
                    }

                    if ($jumlah_bulan > 0) {

                      $sql = $this->db->query("SELECT IFNULL(SUM(Debet - Kredit),0) as grand_profit FROM acc_tbl_trn_jurnal where Tanggal between '$awal' and '$akhir'  and NoCOA in (select no_coa from acc_report_coa where id_group in (1,72,73,224,225)) ");

                      if ($sql->num_rows() > 0) {
                        foreach ($sql->result() as $r) {
                          $grand_profit = 0 -  $r->grand_profit;
                        }
                      }

                      setlocale(LC_MONETARY, 'en_US.UTF-8');
                      echo "<td style='text-align:right'><b>";
                      echo str_replace("$", "", money_format('%(#10n', $grand_profit));
                      echo "</b></td>";
                    }
                    ?>
                  </tr>

                  <!-- End Profit / Loss -->

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
        [0, 'desc']
      ]
    });

    // $("#from,#to").change(function(){
    //     var from = document.getElementById("from").value;
    //     var to = document.getElementById("to").value;

    //     var Arrfrom = from.split("-");
    //     var Arrto = to.split("-");

    //     var newfrom= new Date(Arrfrom[2],Arrfrom[1],'01');
    //     var newto=new Date(Arrto[2],Arrto[1],'01');
    //     var newdt=new Date(newto.setMonth(newto.getMonth()-5));

    //     if(newfrom.getYear()<=newdt.getYear())
    //     {

    //        if(newfrom.getMonth()<newdt.getMonth()){
    //         var temp=new Date(newfrom.setMonth(newfrom.getMonth()+6));
    //         var tempnew =new Date(temp.getFullYear(),("0"+temp.getMonth()).slice(-2),'01');
    //         var temp2=new Date(tempnew.setDate(tempnew.getDate()-1));
    //         document.getElementById("to").value = ("0"+temp2.getDate()).slice(-2) +'-' + ("0"+temp2.getMonth()).slice(-2)+'-'+temp2.getFullYear();
    //         //document.getElementById("to").value =tempnew;

    //        }
    //     }
    // });

  });
</script>