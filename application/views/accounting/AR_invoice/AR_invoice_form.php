<?php //error_reporting(0)                                                                                                   
?>
<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
  }

  function validasi_enter(event) {
    var char = event.which || event.keyCode;
    if (char == 13) {
      // alert('a');
      return false;
    }
    return true;

  }

  function grand_total() {

    var sum = 0;
    var sumRate = 0;
    var sumBro = 0;
    var rate_hdr = document.getElementById('rate_header');


    $("#destinationtable .jr_hutang").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
      document.getElementById('grand_hutang').value = sum;

    });

    $("#destinationtable .jr_rate").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumRate += parseFloat(this.value);
      }
    });

    $("#destinationtable .jr_bruto").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumBro += parseFloat(this.value);
      }
    });

    rate_hdr.value = sumBro / sum;
    return sum;
    return sumRate;
    return sumBro;
  }

  function hitung_bayar() {
    var x = document.getElementsByClassName("jr_bayar");
    for (var i = 0; i < x.length; i++) {
      var str = x[i].value;
      var text = str.replace(",", "");
      x[i].value = text;
    }
    var sum = 0;
    $("#destinationtable .jr_bayar").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {

        sum += parseFloat(this.value);
      }
      document.getElementById('grand_bayar').value = sum;
    });
    return sum;
  }

  var addedrows = new Array();
  $(document).ready(function() {
    $("#tabel_coa tbody tr").on("click", function(event) {
      var ok = 0;
      var theid = $(this).attr('id').replace("sour", "");
      var newaddedrows = new Array();
      //var grandtotal = 0;

      for (index = 0; index < addedrows.length; ++index) {
        // if already selected then remove
        if (addedrows[index] === theid) {
          $(this).css("color", "#000");
          // remove from second table :
          var tr = $("#dest" + theid);
          tr.css("color", "#FF0000");
          tr.fadeOut(400, function() {
            tr.remove();
            grand_total();
          });
          //addedrows.splice(theid, 1);   
          //the boolean
          ok = 1;

        } else {
          newaddedrows.push(addedrows[index]);
          //grandtotal += Number(txtamount[index].value);
        }

      }
      addedrows = newaddedrows;
      //alert(txtamount[1].value);

      // if no match found then add the row :
      if (!ok) {
        addedrows.push(theid);
        $(this).css("color", "#FF0000");
        $('#destinationtable tr:last').before('<tr id="dest' + theid + '"><td>' +
          $(this).find("td").eq(0).html() + '</td><td>' +
          $(this).find("td").eq(1).html() + '</td><td style="text-align:right">' +
          $(this).find("td").eq(2).html() + '</td><td style="text-align:right">' +
          $(this).find("td").eq(3).html() + '</td><td style="text-align:right">' +
          $(this).find("td").eq(4).html() + '</td><td style="display:none">' +
          $(this).find("td").eq(5).html() + '</td></tr>');
      }
      grand_total();
    });

  });

  function get_currency() {
    var cur = document.getElementById('currency').value;
    var sup = document.getElementById('supplier').value;
    var ref = document.getElementById('refno').value;
    window.location = '?ref=' + ref + '&sup=' + sup + '&cur=' + cur;

  }

  function get_supplier() {
    var ref = document.getElementById('refno').value;
    var sup = document.getElementById('supplier').value;
    var cur = document.getElementById('currency').value;
    window.location = '?ref=' + ref + '&sup=' + sup + '&cur=' + cur;
  }

  function ambil_tabel() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/AR_invoice/cek_tabel?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur = $this->input->get('id');
    $kode_sup = $s->namavendor;
    $currency_id = $s->CurrencyID;
    $Currency_symbol = $s->CurrencyID;
    $Remark = $s->Remarks;
    $sdate = new DateTime($s->Tanggal);
    $date_of_journal = date_format($sdate, 'm/d/Y');
    $rate_header = $s->rate_header;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
  }
} else {
  $nofaktur = $this->input->get('ref');
  $kode_sup = '';
  $currency_id = '';
  $Currency_symbol = $this->input->get('cur');
  $rate_header = '0';
  $Remark = '';
  $date_of_journal = date('m/d/Y');
  $term = '0';
  $nota_debet = '0';
  $readonly = '';
  $disable = 'disable';
  $submit_value = 'Save';
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>AR_invoice/save_ap_invoice" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">A/R Invoice</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" onchange="ambil_tabel()" value="<?php echo $nofaktur; ?>" class="form-control" <?php echo $readonly; ?> required />
                        <label class="CurID"></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Customer </label>
                      <div class="col-md-9">
                        <?php
                        if ($kode_sup == '') {
                          $style_kategori = "class='select2me form-control' onchange='get_supplier()' id='supplier' $disable";
                          echo form_dropdown('supplier', $SupplierID, $this->input->get('sup'), $style_kategori);
                        } else {
                          echo "<input type='text' name='supplier'  class='form-control' value='$kode_sup' $readonly />";
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          if ($currency_id == '') {
                            $style_currency = "class='select2me form-control' id='currency' onchange='get_currency()' required";
                            echo form_dropdown('Currency', $Currency, $this->input->get('cur'), $style_currency);
                          } else {
                            echo "<input type='text' name='Currency'  class='form-control' value='$Currency_symbol' $readonly />";
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="tanggal" class="form-control date date-picker" value="<?php echo $date_of_journal; ?>" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Remark</label>
                      <div class="col-md-9">
                        <textarea id="term" name="remark" class="form-control"><?php echo $Remark; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="rate_header" id="rate_header" value="<?php echo $rate_header; ?>" />
                <hr />

              </div>
              <table class="table table-bordered" id="destinationtable">
                <thead>
                  <tr>
                    <th width="3%"><a class="btn blue" data-toggle="modal" href="#purchasing"><i class="fa fa-search"></i></a>
                    </th>
                    <th>
                      No Invoice
                    </th>
                    <th width="10%">
                      Rate
                    </th>
                    <th width="13%">
                      Total Before
                    </th>
                    <th width="13%">
                      Total
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  if (!empty($get_data_detail)) {
                    foreach ($get_data_detail as $v) {
                  ?>
                      <tr>
                        <td><input type="hidden" class="txt" name="DetailID[]" value="<?php echo $v->DetailID; ?>" /></td>
                        <td><input type="text" class="txt" name="noivoice[]" value="<?php echo $v->NoInvoice; ?>" /></td>
                        <td><input type="text" class="txt jr_rate" style="text-align: right;" name="rate[]" onkeypress="isNumber()" value="<?php echo number_format($v->Rate, 2, '.', ','); ?>" /></td>
                        <td style="text-align: right;"><input type="text" class="txt jr_hutang" style="text-align: right;" onkeypress="return isNumber(event)" name="hutang[]" value="<?php echo number_format($v->hutang, 2, '.', ','); ?>" /></td>
                        <td style="text-align: right;"><input type="text" class="txt jr_bayar" onkeyup="hitung_bayar()" onkeypress="return isNumber(event)" style="text-align: right;" id="bayar[]" name="bayar[]" value="<?php echo number_format($v->Total, 2, '.', ','); ?>" /></td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                  <tr id="dest"></tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" style="text-align:right; font-weight: bold">Grand Total</td>
                    <?php
                    if (!empty($get_data_footer)) {
                      foreach ($get_data_footer as $v) {
                    ?>
                        <td style="text-align:right; font-weight: bold"><input name="grand_total" id="grand_hutang" value="<?php echo number_format($v->GrandHutang, 2, '.', ','); ?>" class="txt" style="text-align:right;" /></td>
                        <td style="text-align:right; font-weight: bold"><input name="grand_hutang" id="grand_bayar" value="<?php echo number_format($v->GrandTotal, 2, '.', ','); ?>" class="txt" style="text-align:right;" /></td>
                    <?php
                      }
                    } else {
                      echo '<td style="text-align:right; font-weight: bold">
                                                <input name="grand_hutang" id="grand_hutang" value="0" class="txt" style="text-align:right;"  />
                                                </td>
                                                <td style="text-align:right; font-weight: bold">
                                                <input name="grand_bayar" id="grand_bayar" value="0" class="txt" style="text-align:right;"  />
                                                </td>';
                    }
                    ?>
                  </tr>
                </tfoot>
              </table>
              <hr />
              <a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-download"></i> Input</a>
              <button type="submit" name="sbt" class="btn btn-primary" id="btn_save" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/AR_invoice"><i class="fa fa-warning"></i> Cancel</a>
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>index.php/AR_invoice/print_report?id=<?php echo $this->input->get('id'); ?>" target="_blank"><i class="fa fa-print"></i> Print</a>
                <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>index.php/AR_invoice/delete_transaction?id=<?php echo $this->input->get('id'); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
              <?php } ?>

            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="purchasing" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Journal Entry</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabel_coa" width="568px">
          <thead>
            <th style="display:none"></th>
            <th width="138px">No. Invoice</th>
            <th width="100px">Rate</th>
            <th width="110px">Total Before</th>
            <th width="110px">Total</th>
            <th style="display:none" width="110px">Grand Total</th>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if (!empty($get_data_journal)) {
              foreach ($get_data_journal as $v) {
            ?>
                <tr id="sour<?php echo $no++; ?>" onclick="hitung_total()">
                  <td style="display:none"><input type="hidden" class="txt" name="DetailID[]" value="0" /></td>
                  <td width="138px"><input type="text" class="txt" name="noivoice[]" value="<?php echo $v->nofaktur; ?>" /></td>
                  <td width="100px"><input type="text" class="txt jr_rate" onkeypress="isNumber()" style="text-align: right;" name="rate[]" value="<?php echo number_format($v->rate, 2, '.', ','); ?>" /></td>
                  <td width="110px"><input type="hidden" class="txt jr_hutang" onkeypress="isNumber()" style="text-align: right;" name="hutang[]" value="<?php echo $v->piutang; ?>" /><?php echo number_format($v->piutang, 2, '.', ','); ?></td>
                  <td width="110px"><input type="text" class="txt jr_bayar" onkeypress="isNumber()" style="text-align: right;" name="bayar[]" onkeyup="hitung_bayar()" value="<?php echo number_format($v->TotalPayment, 2, '.', ','); ?>" /></td>
                  <td style="display:none"><input type="text" class="txt jr_bruto" onkeypress="return isNumber(event)" style="text-align: right;" id="bruto[]" name="bayarin[]" value="<?php echo number_format($v->rate * $v->piutang, 2, '.', ''); ?>" />.</td>
                </tr>
            <?php
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel_coa").dataTable({
      "scrollY": 300,
      "scrollX": true
    });
  });
</script>