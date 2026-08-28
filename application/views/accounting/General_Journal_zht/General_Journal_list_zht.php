<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>General_Journal_zht_tims/save_payable_rec" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">General Journal ZHT List</span>
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
                    <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>General_Journal_zht_tims/add_new"><i class="fa fa-plus"></i> Create New</a>
                  </div>
                </div>
              </div>
              <hr />
              <table class="table table-bordered" id="tabel">
                <thead>
                  <th>No Reference</th>
                  <th>Date of Journal</th>
                  <th>Currency</th>
                  <th>Rate</th>
                  <th>Debet</th>
                  <th>Credit</th>
                  <th>Descriptions</th>
                </thead>
                <tbody>
                  <?php
                  $debet = 0;
                  $kredit = 0;
                  if (!empty($List_general)) {
                    foreach ($List_general as $s) {
                      //$debet = $debet+$s->debet;
                      //$kredit = $kredit+$s->credit;
                      // $tgl_jurnal = date_format(date_create($s->tanggal), "F, d Y");
                      // $tgl_invoice = date_format(date_create($s->tanggal_invoice), "F, d Y");
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <td><?php echo $s->no_reff; ?></td>
                        <td><?php echo $s->tanggal; ?></td>
                        <td><?php echo $s->currency; ?></td>
                        <td><?php echo $s->rate; ?></td>
                        <td><?php echo number_format($s->debet, 2, ".", ","); ?></td>
                        <td><?php echo  number_format($s->credit, 2, ".", ","); ?></td>
                        <td><?php echo $s->description; ?></td>
                        <!--  <td><?php echo $s->nofaktur; ?></td>
                                                <td><?php echo $tgl_jurnal; ?></td>
                                                <td><?php echo $tgl_invoice; ?></td>
                                                <td><?php echo $s->kode_sup; ?></td>
                                                <td><?php echo $s->currency_id; ?></td>
                                                <td><?php echo $s->rate; ?></td>
                                                <td><?php echo $s->nota_debet; ?></td>
                                                <td><?php echo $s->nota_kredit; ?></td>
                                                <td><?php echo $s->term; ?> Days</td> -->
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

    window.location.href = url + "General_Journal_zht_tims/edit?id=" + InvoiceNumber + "";
  }
</script>