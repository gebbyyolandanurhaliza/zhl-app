<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>index.php/Payable_recognition/save_payable_rec" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Purchase Invoice Journal List</span>
              </div>
              <div class="form-group">
                <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>PO_journal/addnew"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="portlet-body">
              <table class="table table-bordered" id="tabel">
                <thead>
                  <th>Invoice Number</th>
                  <th>Date of Journal</th>
                  <th>Invoice Date</th>
                  <th>Vendor ID</th>
                  <th>Vendor</th>
                  <th>Currency</th>
                  <th>Rate</th>
                  <th>Grand Total</th>
                  <th>Amount</th>
                  <th>Term</th>
                </thead>
                <tbody>
                  <?php
                  if (!empty($getList)) {
                    foreach ($getList as $s) {
                      $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                      $tgl_invoice = date_format(date_create($s->tanggal_invoice), "d F Y");
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <td><?php echo $s->nofaktur; ?></td>
                        <td><?php echo $tgl_jurnal; ?></td>
                        <td><?php echo $tgl_invoice; ?></td>
                        <td><?php echo $s->kode_sup; ?></td>
                        <td><?php echo $s->namavendor; ?></td>
                        <td><?php echo $s->currency; ?></td>
                        <td><?php echo $s->rate; ?></td>
                        <td><?php echo number_format($s->hutang, 2, ".", ","); ?></td>
                        <td><?php echo number_format($s->hutang * $s->rate, 2, ".", ","); ?></td>
                        <td><?php echo $s->term; ?> Days</td>
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
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true,
      "order": [
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

    var InvoiceNumber = getText(document.getElementById('tabel').rows[$r].cells[0]);
    var vendor = getText(document.getElementById('tabel').rows[$r].cells[3]);
    var cur = getText(document.getElementById('tabel').rows[$r].cells[5]);
    window.location.href = url + "PO_journal/edit?id=" + InvoiceNumber + "&ve=" + vendor + "&cur=" + cur + "";
  }
</script>