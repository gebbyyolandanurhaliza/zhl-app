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
              <span class="caption-subject theme-font">B/L Code Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url('Bl_code_ZHT/search'); ?>" method="get">
              <div class="form-body">
                <div class="row">
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


              <div class="col-md-4">
                <div class="form-group">
                  <button type="submit" class="btn purple"><i class="fa fa-refresh"></i> Filter</button>
                  <a href="<?php echo base_url('Excel/toExcelBlCodeZHT?dari=' . urlencode($dari) . '&sampai=' . urlencode($sampai) . '&dept_code=' . urlencode($dept)); ?>" class="btn green">
                    <i class="fa fa-file-excel-o"></i> Excel
                  </a>
                  <a href="<?php echo base_url('Bl_code_ZHT/print_report?dari=' . urlencode($dari) . '&sampai=' . urlencode($sampai)); ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                </div>
              </div>
               <hr>
               <?php
// echo "<pre>";
// var_dump($dari, $sampai, $dept, $jenis_trans1, $noreference1, $jenis_coa1);
// echo "</pre>";

// echo "<pre>";
// var_dump($_tampil_item);
// echo "</pre>";
// ?>

               <div class="table-responsive">
                    <table class="table table-bordered" id="tabel_bu">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>B/L Code</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Receivable Recognition Ref. Number</th>
                            <th>500115</th>
                            <th>Date</th>
                            <th>Cash Bank Ref.</th>
                            <th>600011</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($_tampil_item as $item): ?>
                            <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($item->containerNo); ?></td>
                            <td><?= htmlspecialchars($item->customer_name); ?></td>
                            <td>
                                <?= !empty($item->created_date) && $item->created_date != '0000-00-00'
                                ? date('d-m-Y', strtotime($item->created_date))
                                : ''; ?>
                            </td> 
                            <td><?= htmlspecialchars(trim($item->nofaktur)); ?></td>
                           <td>
                                <?= (!empty($item->debit) && $item->debit != 0)
                                    ? number_format((float)$item->debit, 2, '.', ',')
                                    : ''; ?>
                            </td>
                            <td>
                                <?= !empty($item->tanggal) && $item->tanggal != '0000-00-00'
                                ? date('d-m-Y', strtotime($item->tanggal))
                                : ''; ?>
                            </td>  
                            <td><?= htmlspecialchars(trim($item->no_reff)); ?></td>
                            <td>
                                <?= (!empty($item->debitAP) && $item->debitAP != 0)
                                ? number_format((float)$item->debitAP, 2, '.', ',')
                                    : ''; ?>
                            </td>
                            <td>
                                <?= (!empty($item->balance) && $item->balance != 0)
                                ? number_format((float)$item->balance, 2, '.', ',')
                                : ''; ?>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
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











