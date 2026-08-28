<?php

//update date : 28 November
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
  $coa_new = $this->input->get('new_coa');
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "USD";
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
              <span class="caption-subject theme-font">Monitoring General Ledger ZHT (Summary)</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>General_ledger_zht/search" method="get">
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
                      <div class="col-md-4">
                        <label class="control-label col-md-3">Account</label>
                        <div class="col-md-9">
                          <?php
                          $style_coa = 'class="select2me form-control" id="coa_new" ';
                          echo form_dropdown('new_coa', $new_coa, $coa_new, $style_coa);
                          ?>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <button type="submit" class="btn purple col-md-3"><i class="fa fa-refresh"></i> Filter</button>
                        <a href="<?php echo base_url(); ?>Excel/toExcelGlZht?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&new_coa=<?php echo $coa_new; ?>" class="btn green col-md-3"><i class="fa fa-file-excel-o"></i> Excel</a>
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

                                setlocale(LC_MONETARY, 'en_US.UTF-8');
                              //if ($value->tmp_debit > 0 or $value->tmp_credit > 0) {
                            ?>
                               <tr onclick="detail(this)" style="cursor: pointer;">
                                  <td hidden><?php echo $value->NoCOA; ?></td>
                                  <td hidden>
                                    <?php echo trim($value->kode_department); ?>
                                  </td>
                                  <td><?php echo $value->NewCOA; ?></td>
                                  <td><?php echo $value->AccountName; ?></td>
                                  <td align='right'><?php echo number_format($begining, 2, '.', ','); ?></td>
                                  <td align='right'><?php echo number_format($Debet, 2, '.', ','); ?></td>
                                  <td align='right'><?php echo number_format($Kredit, 2, '.', ','); ?></td>
                                  <td align='right'><?php echo number_format($net, 2, '.', ','); ?></td>
                                  <td align='right'><?php echo number_format($ending, 2, '.', ','); ?></td>
                                </tr>
                            <?php
                              //}
                            }
                            ?>
                          </tbody>

                          <tfoot>
                          <tr class="tfooter">
                            <td colspan='2' align='right'><b>TOTAL</b></td>
                            <td align='right'><b><?php echo number_format( $totalB, 2, '.', ','); ?></b></td>
                            <td align='right'><b><?php echo number_format( $totaldebit, 2, '.', ','); ?></b></td>
                            <td align='right'><b><?php echo number_format( $totalkredit, 2, '.', ','); ?></b></td>
                            <td align='right'><b><?php echo number_format( $totalnet, 2, '.', ','); ?></b></td>
                            <td align='right'><b><?php echo number_format( $totalng, 2, '.', ','); ?></b></td>
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
    var AccNoParts = AccNo.split('-'); 
    var dari = document.getElementById("from").value;
    var to = document.getElementById("to").value;
    document.getElementById('nomorcoa').innerHTML = AccNo;
    console.log(AccNo);

    window.open("<?php echo base_url(); ?>General_ledger_zht/detail_transaction?new_coa=" + AccNo + "&dari=" + dari + "&sampai=" + to);
    //        $('#deposit').modal();
    //        $.ajax({
    //            url: "<?php echo base_url(); ?>General_ledger_zht/detail_transaction?id=" + AccNo + "&dari=" + dari + "&sampai=" + to,
    //            success: function (response) {
    //                $(".err").html(response);
    //            },
    //            dataType: "html"
    //        });
  }
</script>