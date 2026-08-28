<script type="text/javascript">
  // function addRow(tabel_coa) {

  //     var table = document.getElementById(tabel_coa);

  //     var rowCount = table.rows.length;
  //     var row = table.insertRow(rowCount);

  //     var colCount = table.rows[0].cells.length;
  //     var lRow = table.rows.length - 2;
  //     // alert(colCount);
  //     n1 = 0;
  //     n2 = 0;
  //     for (var i = 0; i < colCount; i++) {

  //         var newcell = row.insertCell(i);

  //         newcell.innerHTML = table.rows[lRow].cells[i].innerHTML;
  //         if (i == 1) {
  //             newcell.childNodes[1].value = "";
  //         }

  //     }
  // }

  // function addRow(tbl_coa_dtl) {

  //     var table = document.getElementById(tbl_coa_dtl);

  //     var rowCount = table.rows.length;
  //     var row = table.insertRow(rowCount);

  //     var colCount = table.rows[0].cells.length;
  //     var lRow = table.rows.length - 2;
  //     // alert(colCount);
  //     n1 = 0;
  //     n2 = 0;
  //     for (var i = 0; i < colCount; i++) {

  //         var newcell = row.insertCell(i);

  //         newcell.innerHTML = table.rows[lRow].cells[i].innerHTML;
  //         if (i == 1) {
  //             newcell.childNodes[1].value = "";
  //         }
  //     }
  // }

  // function isNumber(evt) {
  //     evt = (evt) ? evt : window.event;
  //     var charCode = (evt.which) ? evt.which : evt.keyCode;
  //     if (charCode > 31 && (charCode < 46 || charCode > 57)) {
  //         return false;
  //     }
  //     return true;
  // }
</script>


<div class="page-content">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Rate to USD</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="" method="post">
              <section class="">
                <div class="contain">
                  <table class="table table-bordered " id="tabel_coa" width="100%">
                    <thead>
                      <tr class="header">
                        <th width="6%">Currency <div>Currency</div>
                        </th>
                        <th width="6%">Period <div>Period</div>
                        </th>
                        <!-- <?php
                        $co = $_count + 2;
                        foreach ($_cur as $r) {
                          echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                        }
                        ?> -->

                        <!-- gebby -->
                        <?php
                            $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan
                            $co = $_count + 2;

                            foreach ($_cur as $r) {
                                // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                if (in_array($r->currency_id, $allowed_currencies)) {
                                    echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                                }
                            }
                          ?>

                        <th width="6%">Action <div>Action</div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- <?php
                      // echo $_usd->rate_usd;
                      $this->load->model('M_KursNew');
                      foreach ($_period as $l) {
                        $tgl = date('d-m-Y', strtotime($l->periode));

                        $bln = date('m-Y', strtotime($l->periode));
                        $tgl_ubah = date('m-Y', strtotime("-2 month"));
                        if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                          echo "<tr>";
                          echo "<td width='6%'>USD</td>";
                          echo "<td width='6%'>$tgl</td>";
                          foreach ($_cur as $r) {
                            $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                              echo "<td width='9%'>$usd->rate_usd</td>";
                            } else {
                              echo "<td width='9%'>0</td>";
                            }
                          }
                          //echo "</tr>";
                        } else {
                          echo "<tr>";
                          echo "<td width='6%'>USD</td>";
                          echo "<td width='6%'> <input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl'  required></td>";
                          foreach ($_cur as $r) {
                            $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                              echo "<td width='9%'>$usd->rate_usd</td>";
                            } else {
                              echo "<td width='9%'>0</td>";
                            }
                          }
                        }
                      ?>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('KursNew/updateUSD'); ?>/<?php echo $l->periode; ?>/USD" class="glyphicon glyphicon-pencil" title="Edit">Edit</a></td>
                      <?php echo "</tr>";
                      }
                      ?> -->

                      <!-- gebby -->
                      <?php
                          $this->load->model('M_KursNew');
                          $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan

                          foreach ($_period as $l) {
                              $tgl = date('d-m-Y', strtotime($l->periode));
                              $bln = date('m-Y', strtotime($l->periode));
                              $tgl_ubah = date('m-Y', strtotime("-2 month"));

                              if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                                  echo "<tr>";
                                  echo "<td width='6%'>USD</td>";
                                  echo "<td width='6%'>$tgl</td>";

                                  // Memproses hanya currency yang ada dalam allowed_currencies
                                  foreach ($_cur as $r) {
                                      if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                          $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                                          if (!empty($usd)) {
                                              echo "<td width='9%'>$usd->rate_usd</td>";
                                          } else {
                                              echo "<td width='9%'>0</td>";
                                          }
                                      }
                                  }
                              } else {
                                  echo "<tr>";
                                  echo "<td width='6%'>USD</td>";
                                  echo "<td width='6%'> <input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl' required></td>";

                                  // Memproses hanya currency yang ada dalam allowed_currencies
                                  foreach ($_cur as $r) {
                                      if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                          $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                                          if (!empty($usd)) {
                                              echo "<td width='9%'>$usd->rate_usd</td>";
                                          } else {
                                              echo "<td width='9%'>0</td>";
                                          }
                                      }
                                  }
                              }
                              ?>
                              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('KursNew/updateUSD'); ?>/<?php echo $l->periode; ?>/USD" class="glyphicon glyphicon-pencil" title="Edit">Edit</a></td>
                              <?php echo "</tr>";
                          }
                          ?>
                    </tbody>

                  </table>
                </div>
              </section>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <!-- <input type="submit" value="Save" class="btn btn-primary"  /> -->
                  <!-- <input type="button" value="Add Row" onclick="addRow('tabel_coa')" class="btn btn-primary" /> -->
                  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Row</button> -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Row</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>




    <!-- ------------modalupdate -->
    <div class="modal fade" id="myModalupdate" role="dialog">
      <div class="modal-dialog-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Rate USD</h4>
          </div>
          <div class="modal-body">
            <form action="KursNew/update_kurs_usd_new" method="post">
              <section class="">
                <div>
                  <table class="table table-bordered " width="100%">
                    <thead>
                      <tr class="header">
                        <th width="6%">Currency</th>
                        <th width="6%">Period</th>
                        <!-- <?php
                        $co = $_count + 2;
                        foreach ($_cur as $r) {
                          echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                        }
                        ?> -->

                        <!-- gebby -->
                      <?php
                        $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan
                        $co = $_count + 2;

                        foreach ($_cur as $r) {
                            // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                            if (in_array($r->currency_id, $allowed_currencies)) {
                                echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                            }
                        }
                      ?>

                      </tr>
                    </thead>
                    <tbody>
                      <td width='6%'>USD</td>
                      <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='<?php echo date('d-m-Y', strtotime($l->periode)); ?>' required></td>

                      <!-- <?php
                      foreach ($_cur as $r) {
                        $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                        if (!empty($usd)) {
                          echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)'  required>
                                                        </td>";
                        } else {
                          echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                        </td>";
                        }
                      }
                      ?> -->


                      <?php
                      $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan

                      foreach ($_cur as $r) {
                          // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                          if (in_array($r->currency_id, $allowed_currencies)) {
                              $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                              if (!empty($usd)) {
                                  echo "<td width='9%'> 
                                          <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)' required>
                                        </td>";
                              } else {
                                  echo "<td width='9%'> 
                                          <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required>
                                        </td>";
                              }
                          }
                      }
                      ?>

                    </tbody>
                  </table>
                </div>
              </section>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <input type="submit" value="Save" class="btn btn-primary" />

                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <!-- ----------- -->
    <div class="row ">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Rate to SGD</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="Kurs2/save_kurs_sgd" method="post">
              <section class="">
                <div class="contain">
                  <table class="table table-bordered " id="tabel_coa" width="100%">
                    <thead>
                      <tr class="header">
                        <th width="6%">Currency <div>Currency</div>
                        </th>
                        <th width="7%">Period <div>Period</div>
                        </th>
                        <!-- <?php
                        $co = $_count + 2;
                        foreach ($_cur as $r) {
                          echo "<th width='6%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                        }
                        ?> -->

                        <!-- gebby -->

                        <?php
                            $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan
                            $co = $_count + 2;

                            foreach ($_cur as $r) {
                                // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                if (in_array($r->currency_id, $allowed_currencies)) {
                                    echo "<th width='6%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                                }
                            }
                          ?>

                        <th width="6%">Action <div>Action</div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- <?php
                      // echo $_usd->rate_usd;
                      $this->load->model('M_KursNew');
                      foreach ($_period as $l) {
                        $tgl = date('d-m-Y', strtotime($l->periode));
                        $bln = date('m-Y', strtotime($l->periode));
                        $tgl_ubah = date('m-Y', strtotime("-2 month"));
                        if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                          echo "<tr>";
                          echo "<td width='6%'>SGD</td>";
                          echo "<td width='6%'>$tgl</td>";
                          foreach ($_cur as $r) {
                            $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                              echo "<td width='9%'>$usd->rate_kurs
                                                                     </td>";
                            } else {
                              echo "<td width='9%'>0</td>";
                            }
                          }
                          //echo "</tr>";
                        } else {
                          echo "<tr>";
                          echo "<td width='6%'>SGD</td>";
                          echo "<td width='6%'>$tgl</td>";
                          foreach ($_cur as $r) {
                            $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                              echo "<td width='9%'>$usd->rate_kurs</td>";
                            } else {
                              echo "<td width='9%'>0</td>";
                            }
                          }
                        }
                      ?>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('KursNew/updateSGD'); ?>/<?php echo $l->periode; ?>/SGD" class="glyphicon glyphicon-pencil" title="Edit">Edit</a></a></td>
                      <?php echo "</tr>";
                      }
                      ?> -->

                      <!--gebby-->
                      <?php
                          $this->load->model('M_KursNew');
                          $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan

                          foreach ($_period as $l) {
                              $tgl = date('d-m-Y', strtotime($l->periode));
                              $bln = date('m-Y', strtotime($l->periode));
                              $tgl_ubah = date('m-Y', strtotime("-2 month"));

                              if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                                  echo "<tr>";
                                  echo "<td width='6%'>SGD</td>";
                                  echo "<td width='6%'>$tgl</td>";

                                  // Memproses hanya currency yang ada dalam allowed_currencies
                                  foreach ($_cur as $r) {
                                      if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                          $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                                          if (!empty($usd)) {
                                              echo "<td width='9%'>$usd->rate_kurs</td>";
                                          } else {
                                              echo "<td width='9%'>0</td>";
                                          }
                                      }
                                  }
                              } else {
                                  echo "<tr>";
                                  echo "<td width='6%'>SGD</td>";
                                  echo "<td width='6%'>$tgl</td>";

                                  // Memproses hanya currency yang ada dalam allowed_currencies
                                  foreach ($_cur as $r) {
                                      if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                                          $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                                          if (!empty($usd)) {
                                              echo "<td width='9%'>$usd->rate_kurs</td>";
                                          } else {
                                              echo "<td width='9%'>0</td>";
                                          }
                                      }
                                  }
                              }
                              ?>
                              <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('KursNew/updateSGD'); ?>/<?php echo $l->periode; ?>/SGD" class="glyphicon glyphicon-pencil" title="Edit">Edit</a></td>
                              <?php echo "</tr>";
                          }
                          ?>

                    </tbody>

                  </table>
                </div>
              </section>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <!-- <input type="submit" value="Save" class="btn btn-primary"  /> -->
                  <!--  <input type="button" value="Add Row" onclick="addRow('tabel_coa')" class="btn btn-primary" /> -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rateToSGD">Add Row</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


<!-- ------------modalSGD -->
<!-- <div class="modal fade" id="psgModal" role="dialog">
    <div class="modal-dialog-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Rate SGD</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url(); ?>KursNew/save_kurs_sgd_new" method="post">
                    <section class="">
                        <div>
                            <table class="table table-bordered " id="tabel_coa" width="100%">
                                <thead>
                                    <tr class="header">
                                        <th width="6%">Currency <div>Currency</div>
                                        </th>
                                        <th width="6%">Period <div>Period</div>
                                        </th>
                                        <?php
                                        $co = $_count + 2;
                                        foreach ($_cur as $r) {
                                          echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td width='6%'>SGD</td>
                                    <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='' required></td>

                                    <?php
                                    foreach ($_cur as $r) {
                                      $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                                      if (!empty($usd)) {
                                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                                        </td>";
                                      } else {
                                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                        </td>";
                                      }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <br />
                    <div class="row">
                        <div class="col-md-4">
                            <input type="submit" value="Save" class="btn btn-primary" />

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div> -->


<!-- ----------- -->

<!-- ------------modal update -->
<div class="modal fade" id="psgModalupdate" role="dialog">
  <div class="modal-dialog-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rate SGD</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url(); ?>KursNew/update_kurs_usd" method="post">
          <section class="">
            <div>
              <table class="table table-bordered " id="tabel_coa" width="100%">
                <thead>
                  <tr class="header">
                    <th width="6%">Currency <div>Currency</div>
                    </th>
                    <th width="6%">Period <div>Period</div>
                    </th>
                    <!-- <?php
                    $co = $_count + 2;
                    foreach ($_cur as $r) {
                      echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                    }
                    ?> -->

                    <!--gebby-->
                    <?php
                      $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan
                      $co = $_count + 2;

                      foreach ($_cur as $r) {
                          // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                          if (in_array($r->currency_id, $allowed_currencies)) {
                              echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                          }
                      }
                    ?>

                  </tr>
                </thead>
                <tbody>
                  <td width='6%'>SGD</td>
                  <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='' required></td>

                  <!-- <?php
                  foreach ($_cur as $r) {
                    $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                    if (!empty($usd)) {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                                    </td>";
                    } else {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                    </td>";
                    }
                  }
                  ?> -->

                  <!--gebby-->
                  <?php
                    $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan

                    foreach ($_cur as $r) {
                        // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                        if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                            $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                      </td>";
                            } else {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required>
                                      </td>";
                            }
                        }
                    }
                  ?>

                </tbody>
              </table>
            </div>
          </section>
          <br />
          <div class="row">
            <div class="col-md-4">
              <input type="submit" value="Save" class="btn btn-primary" />

            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- ----------- -->

<!-- ------------modal USD-->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rate USD</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url(); ?>KursNew/save_kurs_usd_new" method="post">
          <section class="">
            <div>
              <table class="table table-bordered " width="100%">
                <thead>
                  <tr class="header">
                    <th width="6%">Currency</th>
                    <th width="6%">Period</th>
                    <!-- <?php
                    $co = $_count + 2;
                    foreach ($_cur as $r) {
                      echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                    }
                    ?> -->

                    <?php
                      $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan
                      $co = $_count + 2;

                      foreach ($_cur as $r) {
                          // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                          if (in_array($r->currency_id, $allowed_currencies)) {
                              echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                          }
                      }
                    ?>

                  </tr>
                </thead>
                <tbody>
                  <td width='6%'>USD</td>
                  <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='' required></td>

                  <!-- <?php
                  foreach ($_cur as $r) {
                    $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                    if (!empty($usd)) {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)'  required>
                                                        </td>";
                    } else {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                        </td>";
                    }
                  }
                  ?> -->

                    <?php
                      $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Daftar currency yang diizinkan

                      foreach ($_cur as $r) {
                          // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                          if (in_array($r->currency_id, $allowed_currencies)) {  // Memeriksa apakah currency_id ada dalam daftar allowed_currencies
                              $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                              if (!empty($usd)) {
                                  echo "<td width='9%'> 
                                          <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)' required>
                                        </td>";
                              } else {
                                  echo "<td width='9%'> 
                                          <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required>
                                        </td>";
                              }
                          }
                      }
                    ?>

                </tbody>
              </table>
            </div>
          </section>
          <br />
          <div class="row">
            <div class="col-md-4">
              <input type="submit" value="Save" class="btn btn-primary" />

            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>








<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="width:80%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rate To USD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="<?php echo site_url(); ?>KursNew/save_kurs_usd_new" method="post">
            <section class="">
              <div>
                <table class="table table-bordered " width="100%">
                  <thead>
                    <tr class="header">
                      <th width="6%">Currency</th>
                      <th width="6%">Period</th>
                      <!-- <?php
                      $co = $_count + 2;
                      foreach ($_cur as $r) {
                        echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                      }
                      ?> -->

                      <?php
                      $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Allowed currencies list
                      $co = $_count + 2;

                      foreach ($_cur as $r) {
                          // Check if currency_id is in the allowed currencies list
                          if (in_array($r->currency_id, $allowed_currencies)) {
                              echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                          }
                      }
                      ?>

                    </tr>
                  </thead>
                  <tbody>
                    <td width='6%'>USD</td>
                    <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='' required></td>

                    <!-- <?php
                    foreach ($_cur as $r) {
                      $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                      if (!empty($usd)) {
                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)'  required>
                                                        </td>";
                      } else {
                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                        </td>";
                      }
                    }
                    ?> -->

                    <?php
                    $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Allowed currencies list

                    foreach ($_cur as $r) {
                        // Check if currency_id is in the allowed currencies list
                        if (in_array($r->currency_id, $allowed_currencies)) {
                            $usd = $this->M_KursNew->get_rateusd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)' required>
                                      </td>";
                            } else {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required>
                                      </td>";
                            }
                        }
                    }
                    ?>

                  </tbody>
                </table>
              </div>
            </section>
            <br />
            <div class="row">
              <div class="col-md-4">
                <input type="submit" value="Save" class="btn btn-primary" />

              </div>
            </div>

          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rateToSGD" tabindex="-1" role="dialog" aria-labelledby="rateToSGDLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="width:80%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rateToSGDLabel">Rate To SGD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <form action="<?php echo site_url(); ?>KursNew/save_kurs_sgd_new" method="post">
            <section class="">
              <div>
                <table class="table table-bordered " id="tabel_coa" width="100%">
                  <thead>
                    <tr class="header">
                      <th width="6%">Currency <div>Currency</div>
                      </th>
                      <th width="6%">Period <div>Period</div>
                      </th>
                      <!-- <?php
                      $co = $_count + 2;
                      foreach ($_cur as $r) {
                        echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                      }
                      ?> -->

                    <?php
                    $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Allowed currencies list
                    $co = $_count + 2;

                    foreach ($_cur as $r) {
                        // Check if currency_id is in the allowed currencies list
                        if (in_array($r->currency_id, $allowed_currencies)) {
                            echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                        }
                    }
                    ?>

                    </tr>
                  </thead>
                  <tbody>
                    <td width='6%'>SGD</td>
                    <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='' required></td>

                    <!-- <?php
                    foreach ($_cur as $r) {
                      $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                      if (!empty($usd)) {
                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                                        </td>";
                      } else {
                        echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                        </td>";
                      }
                    }
                    ?> -->

                    <?php
                    $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // Allowed currencies list

                    foreach ($_cur as $r) {
                        // Check if currency_id is in the allowed currencies list
                        if (in_array($r->currency_id, $allowed_currencies)) {
                            $usd = $this->M_KursNew->get_ratesgd($r->currency_id, $l->periode);

                            if (!empty($usd)) {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                      </td>";
                            } else {
                                echo "<td width='9%'> 
                                        <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required>
                                      </td>";
                            }
                        }
                    }
                    ?>

                  </tbody>
                </table>
              </div>
            </section>
            <br />
            <div class="row">
              <div class="col-md-4">
                <input type="submit" value="Save" class="btn btn-primary" />

              </div>
            </div>

          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>