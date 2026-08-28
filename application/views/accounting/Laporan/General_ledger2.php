<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "";
}

$noreference1 = $this->input->get("noreference");
?>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>General Ledger</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>

<div class="page-contenet">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Monitoring General Ledger (Summary)</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
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
                        <label class="control-label col-md-3">Currency</label>
                        <div class="col-md-9">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="currency" ';
                          echo form_dropdown('currency', $CurrencyID, $cur, $style_kategori);
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12 kanan">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Excel/toExcelGl" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                      <a href="<?php echo base_url(); ?>General_ledger/search_detail?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn btn-danger kanan"><i class="fa fa-calendar"></i> View in Detail</a>
                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_item)) {
                  ?>
                    <section class="">
                      <div class="contain">

                        <table class="table table-bordered" id="tabel_gl">
                          <thead>
                            <tr class="header">
                              <th width="5%">
                                Account<div>Account</div>
                              </th>
                              <th width="18%">
                                Account Name<div>Account Name</div>
                              </th>
                              <th width="15%">
                                Beginning Balance<div>Beginning Balance</div>
                              </th>
                              <th width="15%">
                                Debit (<?php echo "$cur"; ?>)<div>Debit (<?php echo "$cur"; ?>)</div>
                              </th>
                              <th width="15%">
                                Credit (<?php echo "$cur"; ?>)<div>Credit (<?php echo "$cur"; ?>)</div>
                              </th>
                              <th width="15%">
                                Net Activity (<?php echo "$cur"; ?>)<div>Net Activity (<?php echo "$cur"; ?>)</div>
                              </th>
                              <th width="15%">
                                Last Balance (<?php echo "$cur"; ?>)<div>Last Balance (<?php echo "$cur"; ?>)</div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $totaldebit = 0;
                            $totalkredit = 0;
                            $totalnet = 0;
                            $totalng = 0;
                            $begining = 0;
                            $totalbegining = 0;
                            foreach ($_tampil_item as $value) {
                              if ($cur == 'SGD') {
                                $totaldebit += $value->tmp_debit;
                                $totalkredit += $value->tmp_credit;
                                $totalbegining += $value->tmp_balance_current_periode * $value->tmp_rate_sgd;
                                $begining = $value->tmp_balance_current_periode * $value->tmp_rate_sgd;
                                $Debet = $value->tmp_debit * $value->tmp_rate_sgd;
                                $Kredit = $value->tmp_credit * $value->tmp_rate_sgd;
                                $net = $value->tmp_debit - $value->tmp_credit;
                                $ng = $value->tmp_debit - $value->tmp_credit + $value->tmp_balance_current_periode;
                                $totalnet += $net * $value->tmp_rate_sgd;
                                $totalng += $ng * $value->tmp_rate_sgd;
                              } else {
                                $totaldebit += $value->tmp_debit;
                                $totalkredit += $value->tmp_credit;
                                $totalbegining += $value->tmp_balance_current_periode;
                                $begining = $value->tmp_balance_current_periode;
                                $Debet = $value->tmp_debit;
                                $Kredit = $value->tmp_credit;
                                $net = $value->tmp_debit - $value->tmp_credit;
                                $ng = $value->tmp_debit - $value->tmp_credit + $value->tmp_balance_current_periode;
                                $totalnet += $net;
                                $totalng += $ng;
                              }
                              if ($value->tmp_debit > 0 or $value->tmp_credit > 0) {
                            ?>
                                <tr onclick="detail(this)" style="cursor: pointer;">
                                  <td><?php echo $value->tmp_nocoa; ?></td>
                                  <td><?php echo $value->tmp_coa_name; ?></td>
                                  <td align='right'><?php echo number_format($begining, 2, ".", ","); ?></td>
                                  <td align='right'><?php echo number_format($Debet, 2, ".", ","); ?></td>
                                  <td align='right'><?php echo number_format($Kredit, 2, ".", ","); ?></td>
                                  <td align='right'><?php echo number_format($net, 2, ".", ","); ?></td>
                                  <td align='right'><?php echo number_format($ng, 2, ".", ","); ?></td>
                                </tr>
                            <?php
                              }
                            }
                            ?>
                          </tbody>

                          <tfoot>
                            <tr class="tfooter">
                              <td colspan='2' align='right'><b>TOTAL</b></td>
                              <td align='right'><b><?php echo number_format($totalbegining, 2, ".", ","); ?></b></td>
                              <td align='right'><b><?php echo number_format($totaldebit, 2, ".", ","); ?></b></td>
                              <td align='right'><b><?php echo number_format($totalkredit, 2, ".", ","); ?></b></td>
                              <td align='right'><b><?php echo number_format($totalnet, 2, ".", ","); ?></b></td>
                              <td align='right'><b><?php echo number_format($totalng, 2, ".", ","); ?></b></td>
                            </tr>

                          </tfoot>
                        </table>
                      </div>
                    </section>
                  <?php
                  }
                  ?>

                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="modal fade" id="deposit" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Detail Transaction For Account Number <label id="nomorcoa" style="font-weight: bold;"></label></h4>
      </div>
      <div class="row">

        <div class="col-md-12">
          <div class="err" style="padding : 10px 20px 10px 20px;"></div>
        </div>

      </div>

    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      $.each($("#tabel_gl tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });

    });
  });

  function detail(x) {
    var query = window.location.search.substring(1);
    var vars = query.split("=");

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var AccNo = getText(document.getElementById('tabel_gl').rows[$r].cells[0]);
    var dari = document.getElementById("from").value;
    var to = document.getElementById("to").value;
    document.getElementById('nomorcoa').innerHTML = AccNo;

    $('#deposit').modal();
    $.ajax({
      url: "<?php echo base_url(); ?>General_ledger/detail_transaction?id=" + AccNo + "&dari=" + dari + "&sampai=" + to,
      success: function(response) {
        $(".err").html(response);
      },
      dataType: "html"
    });
  }
</script>