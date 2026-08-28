<script type="text/javascript">
  function addRow(tabel_coa) {

    var table = document.getElementById(tabel_coa);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;
    var lRow = table.rows.length - 2;
    // alert(colCount);
    n1 = 0;
    n2 = 0;
    for (var i = 0; i < colCount; i++) {

      var newcell = row.insertCell(i);

      newcell.innerHTML = table.rows[lRow].cells[i].innerHTML;
      if (i == 1) {
        newcell.childNodes[1].value = "";
      }

    }
  }

  function addRow(tbl_coa_dtl) {

    var table = document.getElementById(tbl_coa_dtl);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var colCount = table.rows[0].cells.length;
    var lRow = table.rows.length - 2;
    // alert(colCount);
    n1 = 0;
    n2 = 0;
    for (var i = 0; i < colCount; i++) {

      var newcell = row.insertCell(i);

      newcell.innerHTML = table.rows[lRow].cells[i].innerHTML;
      if (i == 1) {
        newcell.childNodes[1].value = "";
      }
    }
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
  }
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
            <form action="Kurs2/save_kurs_usd" method="post">
              <section class="">
                <div class="contain">
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
                    <?php
                    // echo $_usd->rate_usd;
                    $this->load->model('M_Kurs');
                    foreach ($_period as $l) {
                      $tgl = date('d-m-Y', strtotime($l->periode));

                      $bln = date('m-Y', strtotime($l->periode));
                      $tgl_ubah = date('m-Y', strtotime("-2 month"));
                      if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                        echo "<tr>";
                        echo "<td width='6%'>USD</td>";
                        echo "<td width='6%'> <input type='text' id='period' name='period[]' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl' required></td>";
                        foreach ($_cur as $r) {
                          $usd = $this->M_Kurs->get_rateusd($r->currency_id, $l->periode);

                          if (!empty($usd)) {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)' required>
                                            </td>";
                          } else {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                            </td>";
                          }
                        }
                        echo "</tr>";
                      } else {
                        echo "<tr>";
                        echo "<td width='6%'>USD</td>";
                        echo "<td width='6%'> <input type='text' id='period' name='period[]' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl'  required></td>";
                        foreach ($_cur as $r) {
                          $usd = $this->M_Kurs->get_rateusd($r->currency_id, $l->periode);

                          if (!empty($usd)) {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)'  required>
                                            </td>";
                          } else {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                            </td>";
                          }
                        }
                        echo "</tr>";
                      }
                    }
                    ?>
                  </table>
                </div>
              </section>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <input type="submit" value="Save" class="btn btn-primary" />
                  <input type="button" value="Add Row" onclick="addRow('tabel_coa')" class="btn btn-primary" />
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

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
                  <table class="table table-bordered " id="tbl_coa_dtl" width="100%">
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
                    <?php
                    // echo $_usd->rate_usd;
                    $this->load->model('M_Kurs');
                    foreach ($_period as $l) {
                      $tgl = date('d-m-Y', strtotime($l->periode));
                      $bln = date('m-Y', strtotime($l->periode));
                      $tgl_ubah = date('m-Y', strtotime("-2 month"));
                      if ($bln == $tgl_ubah || $bln == date('m-Y')) {
                        echo "<tr>";
                        echo "<td width='6%'>SGD</td>";
                        echo "<td width='6%'> <input type='text' id='period' name='period[]' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl' required></td>";
                        foreach ($_cur as $r) {
                          $usd = $this->M_Kurs->get_ratesgd($r->currency_id, $l->periode);

                          if (!empty($usd)) {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                            </td>";
                          } else {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                            </td>";
                          }
                        }
                        echo "</tr>";
                      } else {
                        echo "<tr>";
                        echo "<td width='6%'>SGD</td>";
                        echo "<td width='6%'> <input type='text' id='period' name='period[]' class='txt date-picker' data-date-format='dd-mm-yyyy' value='$tgl' required></td>";
                        foreach ($_cur as $r) {
                          $usd = $this->M_Kurs->get_ratesgd($r->currency_id, $l->periode);

                          if (!empty($usd)) {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='$usd->rate_kurs' onkeypress='return isNumber(event)' required>
                                            </td>";
                          } else {
                            echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                            </td>";
                          }
                        }
                        echo "</tr>";
                      }
                    }
                    ?>
                  </table>
                </div>
              </section>
              <br />
              <div class="row">
                <div class="col-md-4">
                  <input type="submit" value="Save" class="btn btn-primary" />
                  <input type="button" value="Add Row" onclick="addRow('tbl_coa_dtl')" class="btn btn-primary" />
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>