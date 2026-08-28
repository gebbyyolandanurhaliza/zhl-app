<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">Advance Search Vendor Credit and Debet Note</span>
            </div>

          </div>
          <div class="portlet-body">
            <form action="<?php // // echo base_url(); 
                          ?>vcdn/search" method="get">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-2">Invoice</label>
                      <div class="col-md-10">
                        <input type="text" name="invoice" id="search" value="<?php // // echo $invoice; 
                                                                              ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-2">Customer</label>
                      <div class="col-md-10">
                        <?php //
                        // $style_kategori = "class='select2me form-control' onchange='get_coa()' id='supplier'";
                        // echo form_dropdown('supplier', $SupplierID, "$supplier", $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-2">Date</label>
                      <div class="col-md-10">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control" id="from" name="dari" value="<?php // echo $dari; 
                                                                                                ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control" id="to" name="sampai" value="<?php // echo $sampai; 
                                                                                                ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-2">&nbsp;</label>
                    <div class="col-md-10">
                      <button class="btn btn-danger"><i class="fa fa-search"></i> Filter</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>
      <form action="<?php // echo base_url(); 
                    ?>index.php/vcdn/save_payable_rec" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Vendor Credit and Debet Note List</span>
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
                    <a type="reset" class="btn btn-primary kanan" href="<?php // echo base_url(); 
                                                                        ?>index.php/vcdn/add_new"><i class="fa fa-plus"></i> Create New</a>
                  </div>
                </div>
              </div>
              <hr />
              <table class="table table-bordered" id="tabel">
                <thead>
                  <th width="20%">Invoice Number</th>
                  <th width="10%">Date of Journal</th>
                  <th width="10%">Invoice Date</th>
                  <th width="20%">Vendor</th>
                  <th width="5%">Currency</th>
                  <th width="10%">Rate</th>
                  <th width="10%">Grand Total</th>
                  <th width="10%">Amount</th>
                  <th style="display: none">Jenis</th>
                </thead>
                <tbody>
                  <?php //
                  if (!empty($List_vcdn)) {
                    foreach ($List_vcdn as $s) {
                      $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                      $tgl_invoice = date_format(date_create($s->tanggal), "d F Y");
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <td><?php // echo $s->no_reff; 
                            ?></td>
                        <td><?php // echo $tgl_jurnal; 
                            ?></td>
                        <td><?php // echo $tgl_invoice; 
                            ?></td>
                        <td><?php // echo $s->nama_sup; 
                            ?></td>
                        <td><?php // echo $s->currency; 
                            ?></td>
                        <td style="text-align: right"><?php // echo $s->currency_rate; 
                                                      ?></td>
                        <td style="text-align: right"><?php // echo number_format($s->total, 2, ".", ","); 
                                                      ?></td>
                        <td style="text-align: right"><?php // echo number_format($s->total * $s->currency_rate, 2, ".", ","); 
                                                      ?></td>
                        <td style="display: none;"><?php // echo $s->jenis_debit_kredit; 
                                                    ?></td>
                      </tr>
                  <?php //
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
    var url = "<?php // echo base_url(); 
                ?>";

    var InvoiceNumber = getText(document.getElementById('tabel').rows[$r].cells[0]);
    var Jenis = getText(document.getElementById('tabel').rows[$r].cells[8]);

    window.location.href = url + "index.php/vcdn/edit?id=" + InvoiceNumber + "&jenis=" + Jenis;
  }
</script>