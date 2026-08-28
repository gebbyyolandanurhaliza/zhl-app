<?php
$invoice = $this->input->get("invoice");
$supplier = $this->input->get("supplier");

if ($this->input->get("dari") <> "") {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
} else {
  $dari = date("d-m-Y");
  $sampai = date("d-m-Y");
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Advance Search Customer Credit and Debit Note</span>
            </div>

          </div>
          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Ccdn/search" method="get">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-2">Invoice</label>
                      <div class="col-md-10">
                        <input type="text" name="invoice" id="search" value="<?php echo $invoice; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-2">Date</label>
                      <div class="col-md-10">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control" id="from" name="dari" value="<?php echo $dari; ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label col-md-2">&nbsp;</label>
                      <div class="col-md-2">
                        <button class="btn btn-danger"><i class="fa fa-search"></i> Filter</button>
                      </div>
                      <div class="col-md-2">
                        <a href="<?php echo base_url(); ?>ccdn/print_ccdn_old?invoice=<?php echo $this->input->get('invoice'); ?>&dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" target='_blank' class="btn btn-primary"><i class="fa fa-print"></i> Print PDF</a>
                      </div>
                      <div class="col-md-2">
                        <a href="<?php echo base_url(); ?>Excel/toExcelCcdn?invoice=<?php echo $this->input->get('invoice'); ?>&dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" target='_blank' class="btn green"><i class="fa fa-print"></i> Print EXCEL</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Customer Credit and Debt Note List</span>
            </div>
            <div class="form-group">
              <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>index.php/ccdn/add_new"><i class="fa fa-plus"></i> Create New</a>
            </div>
          </div>
          <div class="portlet-body">

            <table class="table table-bordered table-striped" id="tabel">
              <thead>
                <th style="display: none">Tahun</th>
                <th width="20%">Invoice Number</th>
                <th width="10%">Date of Journal</th>
                <th width="10%">Invoice Date</th>
                <th width="20%">Customer</th>
                <th width="5%">Currency</th>
                <th width="10%">Rate</th>
                <th width="10%">Grand Total</th>
                <th width="10%">Amount</th>
                <th style="display: none">Jenis</th>
              </thead>
              <tbody>
                <?php
                if (!empty($List_ccdn)) {
                  foreach ($List_ccdn as $s) {
                    $tgl_jurnal_year = date_format(date_create($s->tanggal), "Y");
                    $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                    $tgl_invoice = date_format(date_create($s->tanggal), "d F Y");
                ?>
                    <tr onclick="pilih(this)" style="cursor: pointer;">
                      <td style="display: none;"><?php echo $tgl_jurnal_year; ?></td>
                      <td><?php echo $s->no_reff; ?></td>
                      <td><?php echo $tgl_jurnal; ?></td>
                      <td><?php echo $tgl_invoice; ?></td>
                      <td><?php echo $s->nama_sup; ?></td>
                      <td><?php echo $s->currency; ?></td>
                      <td style="text-align: right"><?php echo $s->currency_rate; ?></td>
                      <td style="text-align: right"><?php echo number_format(abs($s->total), 2, ".", ","); ?></td>
                      <td style="text-align: right"><?php echo number_format(abs($s->total) * $s->currency_rate, 2, ".", ","); ?></td>
                      <td style="display: none;"><?php echo $s->jenis_debit_kredit; ?></td>
                    </tr>
                <?php
                  }
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true
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

    var InvoiceNumber = getText(document.getElementById('tabel').rows[$r].cells[1]);
    var Jenis = getText(document.getElementById('tabel').rows[$r].cells[9]);
    var Cur = getText(document.getElementById('tabel').rows[$r].cells[5]);

    //window.open(url + "ccdn/edit?id=" + InvoiceNumber + "&jenis=" + Jenis+ "&cur=" + Cur);
    window.location.href = url + "ccdn/edit?id=" + InvoiceNumber + "&jenis=" + Jenis + "&cur=" + Cur;
  }

  function print_ccdn_pdf(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var url = "<?php echo base_url(); ?>";

    var InvoiceNumber = getText(document.getElementById('tabel').rows[$r].cells[1]);
    var Jenis = getText(document.getElementById('tabel').rows[$r].cells[9]);
    var Cur = getText(document.getElementById('tabel').rows[$r].cells[5]);

    //window.open(url + "ccdn/edit?id=" + InvoiceNumber + "&jenis=" + Jenis+ "&cur=" + Cur);
    window.location.href = url + "ccdn/print_ccdn?id=" + InvoiceNumber + "&jenis=" + Jenis + "&cur=" + Cur;
  }
</script>