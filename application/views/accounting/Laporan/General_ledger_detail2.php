<?php
error_reporting(0);
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
              <span class="caption-subject theme-font">Monitoring General Ledger (Detail)</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger/search_detail" method="get">
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
                      <a href="<?php echo base_url(); ?>Excel/toExcelGl" class="btn green disabled"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>General_ledger/print_general_ledger?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&currency=<?php echo $cur; ?>" target="_BLANK" type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
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
                                Date<div>Date</div>
                              </th>
                              <th width="18%">
                                Type Of Journal<div>Type Of Journal</div>
                              </th>
                              <th width="15%">
                                DR (US$)<div>DR (US$)</div>
                              </th>
                              <th width="15%">
                                CR (US$)<div>CR (US$)</div>
                              </th>
                              <th width="15%">
                                BAL (US$)<div>BAL (US$)</div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            foreach ($akun_gl as $s) {
                              echo "<tr><td colspan='5' style='text-align:left;font-weight:bold;background-color:#ddd;'>$s->nama_group</td></tr>";
                              $totaldebit = 0;
                              $totalkredit = 0;
                              $totalnet = 0;
                              $totalng = 0;
                              $BalanceD = 0;
                              $BalanceK = 0;
                              $totalbegining = 0;

                              foreach ($_tampil_item as $v) {
                                if ($v->NoCOA == $s->NoCOA) {
                                  $totaldebit += $v->Debet;
                                  $totalkredit += $v->Kredit;
                                  $BalanceD += $v->Debet;
                                  $BalanceK += $v->Kredit;
                                  $totalbegining += $BalanceD - $BalanceK;
                                  $date = date_create($v->Tanggal);
                                  $jenis = $v->JenisJurnalID;
                                  if ($v->Uraian != '') {
                                    $uraian = " - " . $v->Uraian;
                                  } else {
                                    $uraian = '';
                                  }
                            ?>

                                  <tr>
                                    <td><?php echo date_format($date, "d-m-Y"); ?></td>
                                    <td><?php echo $v->NoJurnal . " - " . $v->JenisJurnalID . $uraian; ?></td>
                                    <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $v->Debet)); ?></td>
                                    <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $v->Kredit)); ?></td>
                                    <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $totalbegining)); ?></td>
                                  </tr>
                              <?php
                                }
                              }
                              ?>

                              <tr>
                                <td colspan='2' style="background: #ffffcc" align='right'><b>TOTAL</b></td>
                                <td style="background: #ffffcc" align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totaldebit)); ?></b></td>
                                <td style="background: #ffffcc" align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalkredit)); ?></b></td>
                                <td style="background: #ffffcc" align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalbegining)); ?></b></td>
                              </tr>
                            <?php } ?>
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
    var tgl = vars[1].split("-");
    document.getElementById('nomorcoa').innerHTML = AccNo;

    $('#deposit').modal();
    $.ajax({
      url: "<?php echo base_url(); ?>General_ledger/detail_transaction?id=" + AccNo + "&thn=" + tgl[2] + "&bln=" + tgl[1],
      success: function(response) {
        $(".err").html(response);
      },
      dataType: "html"
    });
  }
</script>