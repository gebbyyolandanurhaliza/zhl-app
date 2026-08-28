<script>
  $(document).ready(function() {
    $('#shipdate').attr('disabled', true);
    $('#factory').attr('disabled', true);
  });
</script>

<?php
error_reporting(0);
if ($this->input->get('dari') <> '') {
  $period = $this->input->get('tahun');
  $type = $this->input->get('currency');
  $dari = $this->input->get('dari');
  $sampai = $this->input->get('sampai');
  $container_number = $this->input->get('container_number');
  $txtSampai = "A/C for the period ended " . $period;
} else {
  $datestr = date("Y-m-d");
}
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->


<?php
if (!empty($HdrDtl)) {

  $bukadatasolasHDR = json_decode($HdrDtl);

  // print_r($HdrDtl);

  // print_r($bukadatasolasHDR);


  // foreach ($bukadatasolasHDR as $x){
  $transID    = $bukadatasolasHDR->transID;
  $vesselName = $bukadatasolasHDR->vesselName;
  $voyage     = $bukadatasolasHDR->voyage;
  $solasDtl   = $bukadatasolasHDR->solasDtl;
  // }

}

?>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Solas Document</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <form action="<?php echo site_url('shipping_mon/container_print_summary'); ?>" method="post" role="form">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-4 label-sm">Trans ID</label>
                          <div class="col-md-6">
                            <input type="text" name="trans" class="form-control input-sm" value="<?= $transID; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-4 label-sm">Vessel Name</label>
                          <div class="col-md-6">
                            <input type="text" name="" class="form-control input-sm" value="<?= $vesselName; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-4 label-sm">Voyage Number</label>
                          <div class="col-md-6">
                            <input type="text" name="" class="form-control input-sm" value="<?= $voyage; ?>">
                          </div>
                        </div>
                        <a href="<?php echo site_url('Solas/PrintSolasPDF?Id=' . $transID . '&Fac=RSUP'); ?>" class="btn blue col-md-3"><i class="fa fa-file-pdf-o"></i> Print Solas</a>
                      </div>

                    </div>
                  </div>
                  <br>
                </div>
              </form>

              <div class="table-scrollable">
                <table class="table table-bordered" id="tblmon">
                  <thead>
                    <tr>
                      <th nowrap>No</th>
                      <th nowrap>PO Number</th>
                      <th nowrap>Container Number</th>
                      <th nowrap>Seal Number</th>
                      <th nowrap>Shipping Liner</th>
                      <th nowrap>Gross Weight</th>
                      <th nowrap>Other Weight</th>
                      <th nowrap>Container Weight</th>
                      <th nowrap>Total Weight</th>
                    </tr>
                  </thead>
                  <tbody id="tbl-mon">
                    <?php
                    if (!empty($HdrDtl)) {

                      $bukadatasolasHDR = json_decode($HdrDtl);

                      $no = 1;
                      foreach ($bukadatasolasHDR->solasDtl as $y) {

                        $total_gross_weight += $y->grossWeight;
                        $total_other_weight += $y->otherWeight;
                        $total_cont_weight += $y->containerWeight;

                        $total_weight_kg = ($y->grossWeight) + ($y->otherWeight) + ($y->containerWeight * 1000); // Dalam KG
                        $sum_kg += $total_weight_kg;

                        $total_weight_mt = ($y->grossWeight / 1000) + ($y->otherWeight / 1000) + ($y->containerWeight); // Dalam MT
                        $sum_mt += $total_weight_mt;

                    ?>
                        <tr>
                          <td align='center' style='vertical-align: top;'><?= $no; ?></td>
                          <td align='center' style='vertical-align: top;'><?= $y->poNumber; ?></td>
                          <td align='center' style='vertical-align: top;'><?= $y->containerNumber; ?></td>
                          <td align='center' style='vertical-align: top;'><?= $y->sealNumber; ?></td>
                          <td align='center' style='vertical-align: top;'><?= $y->linerName; ?></td>
                          <td align='center' style='vertical-align: top;'><?= number_format($y->grossWeight, 3, '.', ','); ?> Kg</td>
                          <td align='center' style='vertical-align: top;'><?= number_format($y->otherWeight, 3, '.', ','); ?> Kg</td>
                          <td align='center' style='vertical-align: top;'><?= number_format($y->containerWeight, 3, '.', ','); ?> MT</td>
                          <td align='center' style='vertical-align: top;'><?= number_format($total_weight_kg, 3, '.', ','); ?> KG / <?= number_format($total_weight_mt, 3, '.', ','); ?> MT</td>
                        </tr>
                    <?php

                        $no++;
                      }
                    }

                    ?>

                    <tr bgcolor="yellow">
                      <td align='center' style='vertical-align: top;' colspan="5">Grand Total</td>
                      <td align='center' style='vertical-align: top;'><?= number_format($total_gross_weight, 3, '.', ','); ?> Kg</td>
                      <td align='center' style='vertical-align: top;'><?= number_format($total_other_weight, 3, '.', ','); ?> Kg</td>
                      <td align='center' style='vertical-align: top;'><?= number_format($total_cont_weight, 3, '.', ','); ?> MT</td>
                      <td align='center' style='vertical-align: top;'><?= number_format($sum_kg, 3, '.', ','); ?> KG / <?= number_format($sum_mt, 3, '.', ','); ?> MT</td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
</script>