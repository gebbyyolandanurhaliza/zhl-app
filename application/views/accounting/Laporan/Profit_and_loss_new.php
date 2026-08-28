<?php
$this->load->model(array('M_Profit_and_lost'));

error_reporting(0);
$period = $this->input->get('tahun');
$type = $this->input->get('currency');


if ($this->input->get('dari') <> '') {
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $hide = $this->input->get('hide');
  $awal = intval(date('m', strtotime($this->input->get('dari'))));
  $akhir = intval(date('m', strtotime($this->input->get('sampai'))));
  $tahun = intval(date('Y', strtotime($this->input->get('sampai'))));
} else {
  $period = date("Y");
  $type = 'USD';
  $dari = date("01-01-Y");
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


<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Profit and Loss</span>
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

                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="submit" class="btn purple kiri col-md-3"><i class="fa fa-refresh"></i> Refresh</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelPnL?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&comp=<?php echo $comp; ?>&hide=<?php echo $hide; ?>&dept=<?php echo $dept; ?>&cur=<?php echo $currency; ?>" class="btn green col-md-3"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <a href="<?php echo base_url(); ?>Profit_and_loss/print_report?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->

                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!--/span-->

                  <div class="col-md-5">
                    <label class="control-label col-md-3">Company</label>
                    <div class="col-md-9">
                      <select class="form-control select2me" name="txtcomp">
                        <option value=""></option>
                        <option value="1" <?php if ($comp == 1) {echo 'selected';  } ?>>ZHENGHE HOLDING LOGISTIC PTE LTD</option>
                        <option value="2" <?php if ($comp == 2) {echo 'selected';  } ?>>ZHENGHE HOLDING TRANSPORT PTE LTD</option>
                        </select>
                    </div>
                  </div>
              </div>
              <div class="row">
                  <!--/span-->

                  <div class="col-md-5">
                    <label class="control-label col-md-3">Department</label>
                    <div class="col-md-9">
                      <select class="form-control select2me" name="txtdept">
                        <option value=""></option>
                          <?php
                            foreach ($dept_code as $rr) {
                                  ?>
                                  <option value="<?php echo $rr->dept_code; ?>" <?php if ($dept == $rr->dept_code) {echo 'selected';  } ?>>
                                      <?php echo $rr->dept_name; ?>
                                  </option>
                                  <?php
                              }
                          ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-5" style="padding-left: 0px;"><input type="checkbox" name="hide" id="hide" value="1" <?php if ($hide == "1") {
                                                                                                                                    echo 'checked';  } ?>>Hidden Month</label>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <!--/span-->

                  <div class="col-md-5">
                    <label class="control-label col-md-3">Currency</label>
                    <div class="col-md-9">
                      <select class="form-control select2me" name="txtcurrency">
                        <option value=""></option>
                        <option <?php if ($currency == 'USD') {echo 'selected';  } ?> value="USD" >USD</option>
                        <option <?php if ($currency == 'SGD') {echo 'selected';  } ?> value="SGD" >SGD</option>
                        </select>
                    </div>
                  </div>
              </div>
            </form>
          </div>
          <hr />
          <div class="table-scrollable" style='overflow: auto;'>
            <?php
            if (!empty($_result)) {
              $bulan = array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'Juny', '7' => 'July', '8' => 'Agustus', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
            ?>
              <table class="table table-bordered" id="tabel" width="100%">
                <thead>
                  <tr>
                    <td rowspan="2">
                      &nbsp;
                    </td>
                    <?php
                    for ($i = $awal; $i <= $akhir; $i++) {
                      echo "<td>" . $tahun . "</td>";
                    }
                    ?>
                    <td rowspan="2" style="font-weight:bold">
                      TOTAL
                    </td>
                  </tr>
                  <tr>
                    <?php
                    for ($i = $awal; $i <= $akhir; $i++) {
                      echo "<td style='font-weight:bold'>" . $bulan[$i] . "</td>";
                    }
                    ?>
                  </tr>
                  <tr style="Background:aquamarine;font-weight:bold">
                    <td colspan="<?=$akhir+2?>" >Accounts Name</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $j = 1;
                  $cols = $akhir - $awal + 3;
                  // echo $cols;
                  foreach ($_result as $r) {
                    if ($tahun>='2025') {
                      if ($r->t_coa == '001' ||$r->t_coa == '002') {
                        echo "<tr style='Background:aquamarine;font-weight:bold'>";
                      } else if ($r->t_coa == '003') {
                        echo "<tr style='Background:silver'><td colspan='$cols'>&nbsp;</td></tr><tr style='Background:aquamarine;font-weight:bold'>";
                      } else {
                        echo "<tr>";
                      }
                    }else{
                      if ($j == 53) {
                        echo "<tr style='Background:aquamarine;font-weight:bold'>";
                      } else if ($j == 118) {
                        echo "<tr style='Background:silver'><td colspan='$cols'>&nbsp;</td></tr><tr style='Background:aquamarine;font-weight:bold'>";
                      } else {
                        echo "<tr>";
                      }
                    }
                    
                    echo "<td>$r->t_coaname</td>";
                    for ($i = $awal; $i <= $akhir; $i++) {
                      if ($i == 1) {
                        if ($r->t_1 < 0) {
                          $t1 = "( " . number_format(abs($r->t_1), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_1, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 2) {
                        if ($r->t_2 < 0) {
                          $t1 = "( " . number_format(abs($r->t_2), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_2, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 3) {
                        if ($r->t_3 < 0) {
                          $t1 = "( " . number_format(abs($r->t_3), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_3, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 4) {
                        if ($r->t_4 < 0) {
                          $t1 = "( " . number_format(abs($r->t_4), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_4, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 5) {
                        if ($r->t_5 < 0) {
                          $t1 = "( " . number_format(abs($r->t_5), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_5, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 6) {
                        if ($r->t_6 < 0) {
                          $t1 = "( " . number_format(abs($r->t_6), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_6, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 7) {
                        if ($r->t_7 < 0) {
                          $t1 = "( " . number_format(abs($r->t_7), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_7, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 8) {
                        if ($r->t_8 < 0) {
                          $t1 = "( " . number_format(abs($r->t_8), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_8, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 9) {
                        if ($r->t_9 < 0) {
                          $t1 = "( " . number_format(abs($r->t_9), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_9, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 10) {
                        if ($r->t_10 < 0) {
                          $t1 = "( " . number_format(abs($r->t_10), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_10, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 11) {
                        if ($r->t_11 < 0) {
                          $t1 = "( " . number_format(abs($r->t_11), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_11, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      } else if ($i == 12) {
                        if ($r->t_12 < 0) {
                          $t1 = "( " . number_format(abs($r->t_12), 2) . " )";
                        } else {
                          $t1 = number_format($r->t_12, 2);
                        }
                        echo "<td style='text-align:right'>" . $t1 . "</td>";
                      }
                    }
                    if ($r->t_13 < 0) {
                      $t13 = "( " . number_format(abs($r->t_13), 2) . " )";
                    } else {
                      $t13 = number_format($r->t_13, 2);
                    }
                    echo "<td style='text-align:right;font-weight:bold'>" . $t13 . "</td>";
                    echo "</tr>";
                    $j++;
                  }
                  ?>
                </tbody>
              </table>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">



</script>