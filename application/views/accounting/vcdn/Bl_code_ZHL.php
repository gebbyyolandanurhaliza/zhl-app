<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
$dept = $this->input->get('currency');


if ($this->input->get("dari") != '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 'd-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
}

// $jenis_trans1 = $this->input->get("jenis_trans");
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
              <span class="caption-subject theme-font">B/L Code Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url('Bl_code_ZHL/search'); ?>" method="get">
              <div class="form-body">
                <div class="row">
                  <!-- Date Picker -->
                  <div class="col-md-4">
                    <div class="form-group row">
                      <label class="control-label col-md-4">Date</label>
                      <div class="col-md-8">
                        <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                          <span class="input-group-addon">to</span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label col-md-6">Dept Code</label>
                      <div class="col-md-6">
                        <select class="form-control" id="dept_code" name="dept_code" required>
                          <option value="">-- Pilih --</option>
                          <option value="002" <?= (isset($dept_code) && $dept_code=='002') ? 'selected' : ''; ?>>002</option>
                          <option value="003" <?= (isset($dept_code) && $dept_code=='003') ? 'selected' : ''; ?>>003</option>
                        </select>
                      </div>
                    </div>
                  </div>
              </div>


              <div class="col-md-4">
                <div class="form-group">
                  <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Filter</button>
                  <a href="<?php echo base_url('Excel/toExcelBlCode?dari=' . urlencode($dari) . '&sampai=' . urlencode($sampai) . '&dept_code=' . urlencode($dept_code)); ?>" class="btn green">
                      <i class="fa fa-file-excel-o"></i> Excel
                  </a>                  
                  <a href="<?php echo base_url('Bl_code_ZHL/print_report?dari=' . urlencode($dari) . '&sampai=' . urlencode($sampai) . '&dept_code=' . urlencode($dept_code)); ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                </div>
              </div>
               <hr>
               <div class="table-responsive">
                <?php if (!empty($dept_code)) : ?>
                    <?php if ($dept_code == '002' && !empty($_tampil_item)) : ?>
                        <table class="table table-bordered" id="tabel_bu">
                          <thead>
                            <tr>
                              <th>NO</th>
                              <th>B/L Code</th>
                              <th>Customer</th>
                              <th>Date</th>
                              <th>Receivable Recognition Ref. Number</th>
                              <th>Department Code</th>
                              <th>Freight Income - BU</th>
                              <th>Barge Income - BU </th>
                              <th>Barge Freight Income - BU</th>
                              <th>Local Income - BU </th>
                              <th>Trucking Income - BU </th>
                              <th>Management fee - Handling charge - BU</th>
                              <th>Cash Bank Ref.</th>
                              <th>Ap Inv. Number</th>
                              <th>Ap Inv. Number</th>
                              <th>Freight Charges - BU</th>
                              <th>Barge Charges - BU</th>
                              <th>Local Charges - BU</th>
                              <th>Trucking Charges - BU</th>
                              <th>Insurance - Marine Insurance Expenses - BU</th>
                              <th>Gross Profit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; foreach ($_tampil_item as $item): ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($item->blCode); ?></td>
                                <td><?= htmlspecialchars($item->customer_name); ?></td>
                                <td><?= date('d-m-Y', strtotime($item->Tanggal)); ?></td>
                                <td><?= htmlspecialchars(trim($item->HeaderID)); ?></td>
                                <td><?= htmlspecialchars($item->dept_code); ?></td>
                                <td><?= number_format($item->amount_500202_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_500101_002_001, 2); ?></td>   
                                <td><?= number_format($item->amount_500109_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_500105_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_500203_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_500107_002_001, 2); ?></td>
                                <td><?= htmlspecialchars(trim($item->no_reff)); ?></td>
                                <td><?= htmlspecialchars($item->headerPR); ?></td>
                                <td><?= htmlspecialchars($item->headerPR_700071); ?></td>
                                <td><?= number_format($item->amount_600101_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_600102_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_600103_002_001, 2); ?></td>
                                <td><?= number_format($item->amount_600104_002_001, 2); ?></td>
                                <td><?= number_format($item->total_sum_amount, 2); ?></td>
                                <?php
                                $total_formula =
                                    floatval($item->amount_500202_002_001)
                                    + floatval($item->amount_500101_002_001)
                                    + floatval($item->amount_500109_002_001)
                                    + floatval($item->amount_500105_002_001)
                                    + floatval($item->amount_500203_002_001)
                                    + floatval($item->amount_500107_002_001)
                                    - floatval($item->amount_600101_002_001)
                                    - floatval($item->amount_600102_002_001)
                                    - floatval($item->amount_600103_002_001)
                                    - floatval($item->amount_600104_002_001)
                                    - floatval($item->total_sum_amount);
                                ?>
                                <td><?= number_format($total_formula, 2); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                    <?php elseif ($dept_code == '003' && !empty($_tampil_item)) : ?>
                        <!-- Tabel FF (Dept 003) -->
                        <table class="table table-bordered" id="tabel_ff">
                          <thead>
                            <tr>
                              <th>NO</th>
                              <th>B/L Code</th>
                              <th>Customer</th>
                              <th>Date</th>
                              <th>Receivable Recognition Ref. Number</th>
                              <th>Department Code</th>
                              <th>Freight Income - FF</th>
                              <th>Barge Freight Income- FF</th>
                              <th>Barge Income - FF</th>
                              <th>Local Income - FF</th>
                              <th>Trucking Income - FF</th>
                              <th>Cash Bank Ref.</th>
                              <th>Ap Inv. Number</th>
                              <th>Ap Inv. Number</th>
                              <th>Freight Charges - FF</th>
                              <th>Barge Charges - FF</th>
                              <th>Local Charges - FF</th>
                              <th>Trucking Charges - FF</th>
                              <th>Insurance - Marine Insurance Expenses - FF</th>
                              <th>Gross Profit</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $no = 1; foreach ($_tampil_item as $item): ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($item->blCode); ?></td>
                                <td><?= htmlspecialchars($item->customer_name); ?></td>
                                <td><?= date('d-m-Y', strtotime($item->Tanggal)); ?></td>
                                <td><?= htmlspecialchars(trim($item->HeaderID)); ?></td>
                                <td><?= htmlspecialchars($item->dept_code); ?></td>
                                <td><?= number_format($item->amount_500202_003_001, 2); ?></td>

                                <td><?= number_format($item->amount_500109_003_001, 2); ?></td>

                                <td><?= number_format($item->amount_500101_003_001, 2); ?></td>
                                <td><?= number_format($item->amount_500105_003_001, 2); ?></td>
                                <td><?= number_format($item->amount_500203_003_001, 2); ?></td>
                                <td><?= htmlspecialchars(trim($item->no_reff)); ?></td>
                                <td><?= htmlspecialchars($item->headerPR_003); ?></td>
                                <td><?= htmlspecialchars($item->headerPR_700071_003); ?></td>
                                <td><?= number_format($item->amount_600101_003_001, 2); ?></td>
                                <td><?= number_format($item->amount_600102_003_001, 2); ?></td>
                                <td><?= htmlspecialchars($item->amount_600103_003_001, 2); ?></td>
                                <td><?= number_format($item->amount_600104_003_001, 2); ?></td>
                                <td><?= number_format($item->total_sum_amount_1, 2); ?></td>
                                <?php
                                $total_formula =
                                    floatval($item->amount_500202_003_001)
                                    + floatval($item->amount_500101_003_001)
                                    + floatval($item->amount_500105_003_001)
                                    + floatval($item->amount_500203_003_001)
                                    + floatval($item->amount_500109_003_001)
                                    - floatval($item->amount_600101_003_001)
                                    - floatval($item->amount_600102_003_001)
                                    - floatval($item->amount_600103_003_001)
                                    - floatval($item->amount_600104_003_001)
                                    - floatval($item->total_sum_amount_1);
                                ?>
                                <td><?= number_format($total_formula, 2); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                    <?php else: ?>
                        <p>No data found for selected period and Dept Code.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-warning">Silakan pilih Dept Code dulu untuk melihat data.</div>
                <?php endif; ?>

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
    $("#tabel_bu").dataTable({
      "scrollY": 400,
      "scrollX": true,
      "order": [
        [0, ''],
        [1, 'desc']
      ]
    });

  });
</script>

<script>
  function pilih(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var url = "<?php echo base_url(); ?>";

    var InvoiceNumber = getText(document.getElementById('tabel_bu').rows[$r].cells[0]);
    // window.open(url + "Receivable_recognition_tims/edit?id=" + InvoiceNumber + "");
    window.location.href = url + "Receivable_recognition_tims/edit?id=" + InvoiceNumber + "";
  }
</script>










