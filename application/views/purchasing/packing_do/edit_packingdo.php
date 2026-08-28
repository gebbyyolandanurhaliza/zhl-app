<?php
foreach ($packdo as $r) {
  $noreff         = $r->noreff;
  $type           = $r->type;
  $factory_id     = $r->factory_id;
  $ship_date      = date("d-m-Y",  strtotime($r->ship_date));
  $doc_date       = date("d-m-Y",  strtotime($r->doc_date));
  $ship_via       = $r->ship_via;
  $detail_id      = $r->detail_id;
  $descriptions   = $r->descriptions;
  $itemid         = $r->itemid;
  $grossweight    = $r->grossweight;
  $qty            = $r->qty;
  $neetweight     = $r->neetweight;
  $docno_gr       = $r->docno_gr;
  $mainpo         = substr($r->mainpo, 9);
  $npbbno         = $r->npbbno;
  $id_gr          = $r->id_gr;
  $remark         = $r->remark;
  $country        = $r->country;
  $term           = $r->term;
  $totalpack      = $r->totalpack;
  $termdays       = $r->termdays;
  $shipdate      = date("d-m-Y",  strtotime($r->shipdate));
}
?>
<script type="text/javascript">
  function cari_po() {
    $fac = $('#factory').val();


    if ($fac == 'select') {
      alert("Please Choose Factory.....");
    } else {
      $tipe = $('#tipe').val();
      $fac = $('#factory').val();

      if ($tipe == 'do') {
        $.ajax({
          url: "<?php echo base_url(); ?>Packing_Do/tampil_gr_do?supplier=" + $fac + "",
          success: function(response) {
            $("#detail_po_id").html(response);
            $("#loading-spiner").hide();
          },
          dataType: "html"
        });
      } else {
        $.ajax({
          url: "<?php echo base_url(); ?>Packing_Do/tampil_gr?supplier=" + $fac + "",
          success: function(response) {
            $("#detail_po_id").html(response);
            $("#loading-spiner").hide();
          },
          dataType: "html"
        });
      }

      $('#po_v').modal('show');

    }
  }

  function get_gr() {

    $("#loading-spiner").show();
    $fac = $('#factory').val();
    $.ajax({
      url: "<?php echo base_url(); ?>Packing_Do/tampil_gr?supplier=" + $fac + "",
      success: function(response) {
        $("#detail_po_id").html(response);
        $("#loading-spiner").hide();
      },
      dataType: "html"
    });

    $('#tabel tbody').empty();

  }

  function get_type() {
    $('#tabel tbody').empty();
  }
</script>
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Packing List / DO </span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('Packing_Do/simpan_do/update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="row">
                <div class="col-md-9">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Type</label>
                          <div class="col-md-4">
                            <select class="form-control tipe select2me" id="tipe" name="tipe" onchange="get_type()">
                              <option <?php if ($type == 'pl') {
                                        echo "selected";
                                      } ?> value="pl">Packing List</option>
                              <option <?php if ($type == 'do') {
                                        echo "selected";
                                      } ?> value="do">D/O</option>
                              <option <?php if ($type == 'lr') {
                                        echo "selected";
                                      } ?> value="lr">Loading Report</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">No Reff</label>
                          <div class="col-md-4">
                            <input type="text" name="noreff" class="txt-input form-control" value="<?php echo $noreff; ?>" id="noreff" onkeypress="return isNumber(event);" onkeydown="return validasi_enter(event)">
                          </div>
                        </div>
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-4 label-sm">Factory</label>
                          <div class="col-md-4">
                            <select class="select2me form-control" id="factory" name="factory" onKeydown="return validasi_enter(event)" onchange="get_gr()">
                              <?php
                              foreach ($_factory as $cr) {
                                if ($cr->customerid != $factory_id) {
                                  echo '<option value="' . $cr->customerid . '">' . $cr->customercompany . '</option>';
                                } else {
                                  echo '<option value="' . $cr->customerid . '" selected>' . $cr->customercompany . '</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group" style="margin-bottom:1px;">
                          <label class="col-md-5 col-md-push-3 label-sm"">Shipment Date</label>
                                                    <div class=" col-md-4 col-md-push-3">
                            <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $ship_date; ?>" required onkeypress="return isNumber(event);" onkeydown="return validasi_enter(event)">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-5 col-md-push-3 label-sm"">Document Date</label>
                                                    <div class=" col-md-4 col-md-push-3">
                          <input class="form-control input-sm date date-picker" name="docdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $doc_date; ?>" required onkeypress="return isNumber(event);" onkeydown="return validasi_enter(event)">
                      </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-5 col-md-push-3 label-sm"">Shipment via</label>
                                                    <div class=" col-md-4 col-md-push-3">
                        <input type="text" name="via" class="txt-input form-control" value="<?php echo $ship_via; ?>" id="via">
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="table-scrollable" id="">
                <table class="table table-bordered" id="tabel">
                  <thead>
                    <tr>
                      <th width="5%">
                        <a class="btn green" onclick="cari_po()" title="Serch PO Vendor"><i class="fa fa-search"></i></a>
                      </th>
                      <th width="40%">
                        Descriptions
                      </th>
                      <th width="15%">
                        NPBB NO
                      </th>
                      <th width="10%">
                        Qty
                      </th>
                      <th width="10%">
                        Uom
                      </th>
                      <th width="10%">
                        Gross Weigth
                      </th>
                      <th width="10%">
                        Nett Weigth
                      </th>
                    </tr>
                  </thead>
                  <tbody id="grdtl">
                    <?php foreach ($packdo as $x) { ?>
                      <tr>
                        <td>
                          <?php if ($x->type == 'do') { ?>
                            <a role="button" class="tombol" href="<?php echo site_url('Packing_Do/remove_packdo?id=' . $x->detail_id . '&noreff=' . $x->noreff); ?>" onclick="return confirm('Are you sure remove this row?')">Remove</a>
                          <?php } else { ?>
                            <button class="tombol" onclick="hapus_dp(this)">Remove</button>
                          <?php } ?>

                        </td>
                        <td>
                          <input type="hidden" class="txt" name="txtIdgr[]" value="<?php echo $x->id_gr ?>">
                          <input type="text" class="txt" name="txtItemName[]" value="<?php echo $x->descriptions ?>">
                        </td>
                        <td>
                          <input type="text" class="txt" name="txtItemNPBB[]" value="<?php echo $x->npbbno ?>">
                        </td>
                        <td>
                          <input type="text" class="txt" name="txtItemQty[]" value="<?php echo number_format($x->qty, 0, '.', '') ?>">
                          <input type="hidden" class="txt" name="txtdocno[]" value="<?php echo $x->docno_gr ?>">
                          <input type="hidden" class="txt" name="txtmainpo[]" value="<?php echo $x->mainpo ?>">
                          <input type="hidden" class="txt" name="txtItemId[]" value="<?php echo $x->itemid ?>">
                        </td>
                        <td>
                          <input type="text" class="txt" value="<?php echo $x->uom ?>">
                        </td>
                        <td><input type="text" class="txt" name="txtItemGW[]" value="<?php echo number_format($x->grossweight, 2, '.', '') ?>"></td>
                        <td><input type="text" class="txt" name="txtItemNW[]" value="<?php echo number_format($x->neetweight, 2, '.', '') ?>"></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group" style="margin-bottom:1px;">
                    <label class="col-md-3 label-sm">Remark</label>
                    <div class="col-md-9">
                      <textarea rows="3" class="form-control autosizeme" name="remarks" id="remarks"><?php echo $remark; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom:1px;">
                    <label class="col-md-3 label-sm">Country Of Origin</label>
                    <div class="col-md-9">
                      <textarea rows="1" class="form-control autosizeme" name="remark_country"><?php echo $country; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group" style="margin-bottom:1px;">
                    <label class="col-md-3 label-sm">Total Packing</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control input-sm" name="ttlpack" id="ttlpack" value="<?php echo $totalpack; ?>">
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="form-actions">
            <div class="col-md-6">
              <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
              <button type="reset" class="col-md-2 btn btn-default" onclick="">Cancel</button>
            </div>
            <div class="col-md-6">
              <a type="button" class="col-md-2 col-md-offset-10 btn btn-info" href="<?php echo site_url('Packing_Do/print_report?noreff=' . $noreff . '&type=' . $type); ?>" target="_blank">Print</a>
            </div>
          </div>
        </div>
        <?php
        if ($type === "pl") {
          $style1 = 'style="display: block"';
        } else {
          $style1 = 'style="display: none"';
        }
        ?>
        <div class="col-md-3" id="pi_no" <?= $style1; ?>>
          <div class="portlet light">
            <div class="portlet body">
              <div class="form-group" style="margin-bottom:1px;">
                <label class="col-md-4 label-sm">PI No</label>
                <div class="col-md-8">
                  <input class="form-control input-sm" value="<?php echo $id_gr; ?>" readonly>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:1px;">
                <label class="col-md-4 label-sm">Ship Date</label>
                <div class="col-md-8">
                  <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo $shipdate;; ?>" required>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:1px;">
                <label class="col-md-4 label-sm">Ship Term</label>
                <div class="col-md-8">
                  <textarea readonly="" rows="3" class="form-control" name="term" style="resize: none;height: 167px;" id="term"><?php echo $term; ?></textarea>
                </div>
              </div>
              <div class="form-group" style="margin-bottom:1px;">
                <label class="col-md-4 label-sm">Term Days</label>
                <div class="col-md-8">
                  <input class="form-control input-sm" readonly="" value="<?php echo $termdays; ?>">
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Good Receipt</h4>
        <input class="form-control" type="text" id="search" placeholder="search">
      </div>
      <div class="modal-body">
        <section class="">
          <div class="contain">
            <div id="loading-spiner">
              <center>
                <image src="<?php echo base_url(); ?>/assets/35.gif"><br />Please wait
              </center>
            </div>
            <div id="detail_po_id"></div>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function hapus_dp(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    hitung_amount();
  }
</script>