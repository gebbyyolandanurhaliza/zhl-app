<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>index.php/AR_invoice/save_payable_rec" method="post">

        <div class="col-md-12">

          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">A/R Invoice List</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>AR_invoice/add_new"><i class="fa fa-plus"></i> Create New</a>
                  </div>
                </div>
              </div>
              <hr />
              <table class="table table-bordered" id="tabel">
                <thead>
                  <th>A/R Number</th>
                  <th>Vendor</th>
                  <th>Date</th>
                  <th>Currency</th>
                  <th>Remark</th>
                </thead>
                <tbody>
                  <?php
                  if (!empty($List_ap_invoice)) {
                    foreach ($List_ap_invoice as $s) {
                      $Tanggal = date_format(date_create($s->Tanggal), "F, d Y");
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <td><?php echo $s->NomorAR; ?></td>
                        <td><?php echo $s->SupplierID; ?></td>
                        <td><?php echo $Tanggal; ?></td>
                        <td><?php echo $s->CurrencyID; ?></td>
                        <td><?php echo $s->Remarks; ?></td>
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

    var InvoiceNumber = getText(document.getElementById('tabel').rows[$r].cells[0]);
    var sup = getText(document.getElementById('tabel').rows[$r].cells[1]);
    var cur = getText(document.getElementById('tabel').rows[$r].cells[3]);

    window.location.href = url + "AR_invoice/edit?id=" + InvoiceNumber + "&sup=" + sup + "&cur=" + cur;
  }
</script>