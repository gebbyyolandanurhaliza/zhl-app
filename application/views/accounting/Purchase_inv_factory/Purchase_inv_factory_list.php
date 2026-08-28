<?php
$invoice = $this->input->get("invoice");
$supplier = $this->input->get("supplier");

if ($this->input->get("dari") <> "") {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $dari = "";
  $sampai = "";
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-6">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Advance Search</span>
            </div>

          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Purchase_inv_factory/search" method="get">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-2">Invoice</label>
                    <div class="col-md-10">
                      <input type="text" name="invoice" id="search" value="<?php echo $invoice; ?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Date</label>
                    <div class="col-md-10">
                      <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control" id="from" name="dari" value="<?php echo $dari; ?>">
                        <span class="input-group-addon">
                          to </span>
                        <input type="text" class="form-control" id="to" name="sampai" value="<?php echo $sampai; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-2">Factory</label>
                    <div class="col-md-10">
                      <?php
                      $style_kategori = "class='select2me form-control' onchange='get_coa()' id='supplier'";
                      echo form_dropdown('supplier', $SupplierID, "$supplier", $style_kategori);
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">&nbsp;</label>
                    <div class="col-md-10">
                      <button class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Quick View</span>
            </div>
          </div>
          <div class="note note-success note-bordered">
            <p>
              Are you sure you are looking invoice has been entered into the system ? Please input the invoice number in the search box below then press enter.
            </p>

          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Purchase_inv_factory/edit" method="get">
              <div class="row">
                <div class="col-md-12">

                  <div class="form-group">
                    <label class="control-label col-md-2">Invoice</label>
                    <div class="col-md-7">
                      <input type="text" name="id" id="search" value="<?php echo $invoice; ?>" class="form-control">
                    </div>
                    <div class="col-md-3">
                      <button class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    </div>
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Sales Invoice Journal for Factory List</span>
            </div>
            <div class="form-group">
              <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>Purchase_inv/add_new"><i class="fa fa-plus"></i> Create New</a>
            </div>
          </div>
          <div class="portlet-body">

            <table class="table table-bordered" id="tabel1">
              <thead>
                <th width="10%">Invoice Number</th>
                <th width="10%">Date of Journal</th>
                <th width="10%">Invoice Date</th>
                <th width="10%">Due Date</th>
                <th width="20%">Customer</th>
                <th width="5%">Currency</th>
                <th width="10%">Rate</th>
                <th width="10%">Grand Total</th>
                <th width="10%">Amount</th>
                <th width="5%">Term</th>
              </thead>
              <tbody>
                <?php
                if (!empty($List_payable)) {
                  $piutang = 0;
                  $total = 0;
                  foreach ($List_payable as $s) {
                    $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                    $tgl_invoice = date_format(date_create($s->tanggal_invoice), "d F Y");
                    $tgl_tempo = date_format(date_create($s->tanggal_tempo), "d F Y");
                    $piutang += $s->hutang;
                    $total += $s->hutang * $s->rate;
                ?>
                    <tr onclick="pilih(this)" style="cursor: pointer;">
                      <td><?php echo $s->nofaktur; ?></td>
                      <td style="text-align: center"><?php echo $tgl_jurnal; ?></td>
                      <td style="text-align: center"><?php echo $tgl_invoice; ?></td>
                      <td style="text-align: center"><?php echo $tgl_tempo; ?></td>
                      <td><?php echo $s->namavendor; ?></td>
                      <td><?php echo $s->currency; ?></td>
                      <td style="text-align: right"><?php echo $s->rate; ?></td>
                      <td style="text-align: right"><?php echo number_format($s->hutang, 2, ".", ","); ?></td>
                      <td style="text-align: right"><?php echo number_format($s->hutang * $s->rate, 2, ".", ","); ?></td>
                      <td><?php echo $s->term; ?> Days</td>
                    </tr>
                <?php
                  }
                } else {
                  $piutang = 0;
                  $total = 0;
                }
                ?>

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="7" style="text-align: right; font-weight: bold">Grand Total</td>
                  <td style="text-align: right; font-weight: bold" width="10%"><?php echo number_format($piutang, 2, ".", ","); ?></td>
                  <td style="text-align: right; font-weight: bold" width="10%"><?php echo number_format($total, 2, ".", ","); ?></td>
                  <td style="text-align: right; font-weight: bold" width="10%"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel1").dataTable({
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

    var InvoiceNumber = getText(document.getElementById('tabel1').rows[$r].cells[0]);
    //        window.open(url + "Purchase_inv_factory/edit?id=" + InvoiceNumber + "");
    window.location.href = url + "Purchase_inv/edit?id=" + InvoiceNumber + "";
  }
</script>