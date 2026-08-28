<?php

//update date : 28 November
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
  $coa = $this->input->get('jenis_coa');
  $coa_new = $this->input->get('new_coa');
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "USD";
  $coa = "";
  $coa_new = "";
}

$noreference1 = $this->input->get("noreference");
setlocale(LC_MONETARY, 'en_US.UTF-8');
?>



<div class="page-content">
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
                      <div class="col-md-4">
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
                      <!--                                            <div class="col-md-4">
                                                <label class="control-label col-md-3">Currency</label>
                                                <div class="col-md-9">
                                                    <?php
                                                    //                                                    $style_kategori = 'class="select2me form-control" id="currency" ';
                                                    //                                                    echo form_dropdown('currency', $CurrencyID, $cur, $style_kategori);
                                                    ?>
                                                </div>
                                            </div>-->
                      <div class="col-md-4" id="coa_section">
                        <label class="control-label col-md-3">Account</label>
                        <div class="col-md-9"> 
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa" ';
                          echo form_dropdown('jenis_coa', $jenis_coa, $coa, $style_coa);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-4" id="new_coa_section" style="display: none;">
                        <label class="control-label col-md-3">New Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa_new" ';
                          echo form_dropdown('new_coa', $new_coa, $coa_new, $style_coa);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <button type="submit" class="btn purple col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelGl?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_coa=<?php echo $coa; ?>" class="btn green col-md-3" id="excel_linked"><i class="fa fa-file-excel-o"></i> Excel</a>
                        <!--<button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>-->
                        <!-- <a href="<?php // echo base_url(); 
                                      ?>General_ledger/search_detail?dari=<?php // echo $dari; 
                                                                          ?>&sampai=<?php // echo $sampai; 
                                                                                    ?>" class="btn btn-danger kanan"><i class="fa fa-calendar"></i> View in Detail</a>-->
                      </div>
                      <div class="col-md-1">
                          <label>
                              <input type="checkbox" id="toggle_coa" name="check_coa"> New Account
                          </label>
                      </div>
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
                                Ending Balance (<?php echo "$cur"; ?>)<div>Ending Balance (<?php echo "$cur"; ?>)</div>
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
                            $totalB = 0;

                            foreach ($_tampil_item as $value) {
                              
                              if ($value->MTDebet < 0) {
                                  $value->MTKredit += abs($value->MTDebet);
                                  $value->MTDebet = 0;
                              }

                              $Debet = $value->MTDebet;
                              $Kredit = $value->MTKredit;

                              $totalbegining += $value->BBDebet - $value->BBKredit;
                              $begining = $value->BBDebet - $value->BBKredit;
                              $net = $value->MTDebet - $value->MTKredit;
                              $ending = $value->EBDebet - $value->EBKredit;

                              if ($value->posisi_gl == 1) {
                                $totalbegining += ($totalbegining <> 0 ? $totalbegining * -1 : $totalbegining);
                                $begining = ($begining <> 0 ? $begining * -1 : $begining);
                                $net = ($net <> 0 ? $net * -1 : $net);
                                $ending = ($ending <> 0 ? $ending * -1 : $ending);
                              }

                              $totalB += $begining;
                              $totaldebit += $Debet;
                              $totalkredit += $Kredit;
                              $totalnet += $net;
                              $totalng += $ending;

                              //if ($value->tmp_debit > 0 or $value->tmp_credit > 0) {
                            ?>
                              <tr onclick="detail(this)" style="cursor: pointer;">
                                <td hidden>
                                <?php echo isset($value->no_coa) && $value->no_coa != '' ? $value->no_coa : (isset($value->NoCOA) ? $value->NoCOA : ''); ?>
                                </td>
                                <td hidden>
                                  <?php echo trim($value->kode_department); ?>
                                </td>
                                <td>
                                    <?php echo isset($value->no_coa) && $value->no_coa != '' ? $value->no_coa : (isset($value->NewCOA) ? $value->NewCOA : ''); ?>
                                </td>
                                <td>
                                  <?php echo isset($value->nama_akun) && $value->nama_akun != '' ? $value->nama_akun : (isset($value->AccountName) ? $value->AccountName : ''); ?>
                                </td>
                                <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $begining)); ?></td>
                                <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $Debet)); ?></td>
                                <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $Kredit)); ?></td>
                                <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $net)); ?></td>
                                <td align='right'><?php echo str_replace("$", "", money_format('%(#10n', $ending)); ?></td>
                              </tr>
                            <?php
                              //}
                            }
                            ?>
                          </tbody>

                          <tfoot>
                            <tr class="tfooter">
                              <td colspan='2' align='right'><b>TOTAL</b></td>
                              <td align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalB)); ?></b></td>
                              <td align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totaldebit)); ?></b></td>
                              <td align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalkredit)); ?></b></td>
                              <td align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalnet)); ?></b></td>
                              <td align='right'><b><?php echo str_replace("$", "", money_format('%(#10n', $totalng)); ?></b></td>
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
    var AccNo = getText(document.getElementById('tabel_gl').rows[$r].cells[2]).trim();
    var AccNoOld = getText(document.getElementById('tabel_gl').rows[$r].cells[0]).trim();
    var AccNoParts = AccNo.split('-'); 

    var check = document.getElementById("toggle_coa").value;
    var dari = document.getElementById("from").value;
    var to = document.getElementById("to").value;
    document.getElementById('nomorcoa').innerHTML = AccNo;
    console.log(AccNoOld);
    if(check == 1){
      window.open("<?php echo base_url(); ?>General_ledger/detail_transaction?new_coa=" + AccNo + "&dari=" + dari + "&sampai=" + to + "&check_coa=" + check);
    }else{
      window.open("<?php echo base_url(); ?>General_ledger/detail_transaction?jenis_coa=" + AccNoOld + "&dari=" + dari + "&sampai=" + to + "&check_coa=" + check);
    }
    //        $('#deposit').modal();
    //        $.ajax({
    //            url: "<?php echo base_url(); ?>General_ledger/detail_transaction?id=" + AccNo + "&dari=" + dari + "&sampai=" + to,
    //            success: function (response) {
    //                $(".err").html(response);
    //            },
    //            dataType: "html"
    //        });
  }

  $(document).ready(function () {
    var useNewCoa = localStorage.getItem("use_new_coa");
    var baseUrl = "<?php echo base_url(); ?>Excel/toExcelGl";
    var dari = "<?php echo $dari; ?>";
    var sampai = "<?php echo $sampai; ?>";
    var new_coa = "<?php echo $coa_new; ?>";
    var jenis_coa = "<?php echo $coa; ?>"; 
    console.log(new_coa);

    if (useNewCoa === "true") {
        $("#toggle_coa").prop("checked", true).val("1");
        $("#coa_section").hide();
        $("#new_coa_section").show();
    } else {
        $("#toggle_coa").prop("checked", false).val("0");
        $("#coa_section").show();
        $("#new_coa_section").hide();
    }

    $("#toggle_coa").change(function () {
        if ($(this).is(":checked")) {
            $("#coa_section").hide();
            $("#new_coa_section").show();
            $(this).val("1");
            localStorage.setItem("use_new_coa", "true");
            $("#excel_linked").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&new_coa=" + new_coa + "&check_coa=" + 1);
        } else {
            $("#coa_section").show();
            $("#new_coa_section").hide();
            $(this).val("0");
            localStorage.setItem("use_new_coa", "false");
            $("#excel_linked").attr("href", baseUrl + "?dari=" + dari + "&sampai=" + sampai + "&jenis_coa=" + jenis_coa + "&check_coa=" + 0);
        }
    });

    $("#toggle_coa").trigger("change");
  });

</script>