<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 'd-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
}

$jenis_trans1 = $this->input->get("jenis_trans");
$noreference1 = $this->input->get("noreference");
$jenis_coa1 = $this->input->get("jenis_coa");
?>
<div class="page-content">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Monitoring Journal</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_journal/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">Date</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">Type of Journal</label>
                        <div class="col-md-9">
                          <?php
                          $style_kategori = 'class="select2me form-control" id="jenis_trans" required';
                          echo form_dropdown('jenis_trans', $jenis_trans, $jenis_trans1, $style_kategori);
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">No Reference</label>
                        <div class="col-md-9">
                          <input type="text" name="noreference" id="noreference" value="<?php echo $noreference1; ?>" class="text form-control">
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <label class="control-label col-md-3">COA Account</label>
                        <div class="col-md-9">
                          <?php
                          $style = 'class="select2me form-control" id="jenis_coa"';
                          echo form_dropdown('jenis_coa', $jenis_coa, $jenis_coa1, $style);
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Excel\toExcelJurnal?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a class="btn btn-primary" href="<?php echo base_url(); ?>Monitoring_journal\print_re?dari=<?php echo $dari; ?>&sampai=<?php echo $sampai; ?>&jenis_trans=<?php echo $this->input->get('jenis_trans'); ?>&noreference=<?php echo $this->input->get('noreference'); ?>&jenis_coa=<?php echo $this->input->get('jenis_coa');  ?>" target="_blank"><i class="fa fa-print"></i> Print</a>
                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_item)) {
                  ?>
                    <table class="table table-bordered" id="tabel">
                      <thead>
                        <tr>
                          <th width="2%">
                            NO
                          </th>
                          <th width="8%">
                            Date
                          </th>
                          <th width="5%">
                            No COA
                          </th>
                          <th width="15%">
                            Remark
                          </th>
                          <th width="5%">
                            No Reference
                          </th>
                          <th width="10%">
                            Debit
                          </th>
                          <th width="10%">
                            Credit
                          </th>
                          <th width="10%">
                            Debit SGD
                          </th>
                          <th width="10%">
                            Credit SGD
                          </th>
                          <th style="Display:none">
                            Currency
                          </th>
                          <th style="Display:none">
                            Rate
                          </th>
                          <th width="5%">
                            Create By
                          </th>
                          <th width="5%">
                            Created Date
                          </th>
                          <th width="5%">
                            Update By
                          </th>
                          <th width="5%">
                            Update Date
                          </th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $totaldebit = 0;
                        $totalkredit = 0;
                        $totaldebitsgd = 0;
                        $totalkreditsgd = 0;

                        foreach ($_tampil_item as $value) {
                          if ($value->Debet == '0') {
                            $Debet = '';
                          } else {
                            $Debet = number_format($value->Debet, 2, ".", ",");
                          }

                          if ($value->Kredit == '0') {
                            $Kredit = '';
                          } else {
                            $Kredit = number_format($value->Kredit, 2, ".", ",");
                          }

                          if ($value->Debet_SGD == '0') {
                            $Debet_SGD = '';
                          } else {
                            $Debet_SGD = number_format($value->Debet_SGD, 2, ".", ",");
                          }

                          if ($value->Kredit_SGD == '0') {
                            $Kredit_SGD = '';
                          } else {
                            $Kredit_SGD = number_format($value->Kredit_SGD, 2, ".", ",");
                          }

                          // if ($Debet <> '' and $value->chk = 'C'){
                          //     $Debet = '';
                          //     $Kredit = number_format($value->Debet, 2, ".", ",");
                          // }
                          $totaldebit += $value->Debet;
                          $totalkredit += $value->Kredit;
                          $totaldebitsgd += $value->Debet_SGD;
                          $totalkreditsgd += $value->Kredit_SGD;
                        ?>
                          <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $value->Tanggal; ?></td>
                            <td><?php echo $value->NoCOA; ?></td>
                            <td><?php echo substr($value->Uraian, 0, 100); ?></td>
                            <td><?php echo $value->NoJurnal; ?></td>

                            <td align='right'><?php echo $Debet; ?></td>
                            <td align='right'><?php echo $Kredit; ?></td>
                            <td align='right'><?php echo $Debet_SGD; ?></td>
                            <td align='right'><?php echo $Kredit_SGD; ?></td>
                            <td style="Display:none"><?php echo $value->Currency; ?></td>
                            <td style="Display:none"><?php echo $value->Rate; ?></td>
                            <td><?php echo $value->created_by; ?></td>
                            <td><?php echo date_format(date_create($value->created_date), 'd-m-Y'); ?></td>
                            <td><?php echo $value->last_update_by; ?></td>
                            <td><?php echo date_format(date_create($value->last_update_date), 'd-m-Y'); ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan='5' align='right'><b>TOTAL</b></td>
                          <td align='right'><?php echo number_format($totaldebit, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totalkredit, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totaldebitsgd, 2, ".", ","); ?></td>
                          <td align='right'><?php echo number_format($totalkreditsgd, 2, ".", ","); ?></td>
                          <td colspan='4'>&nbsp;</td>
                        </tr>

                      </tfoot>
                    </table>

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

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 300,
      "scrollX": true
    });
  });
</script>