<?php //error_reporting(0)                                                              
?>

<script>
  $(document).ready(function() {

    var sum = 0;
    var amount = document.getElementsByClassName('amount');
    var price = document.getElementsByClassName('price');
    var quantity = document.getElementsByClassName('quantity');
    var txtSGD = document.getElementsByClassName('txtSGD');
    var cur = document.getElementById('rate_currency').value;
    var nota_debet = document.getElementById('nota_debet').value;
    //var nota_credit = document.getElementById('nota_credit');

    for (var i = 0; i < price.length; i++) {
      amount[i].value = price[i].value * quantity[i].value;
      txtSGD[i].value = cur * amount[i].value;
    }
    $(".txtSGD").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum;

    document.getElementsByClassName('jr_rate').value = '0';
  });


  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;

  }

  function get_currency() {
    var currency_id = document.getElementById('currency').value;
    var res = currency_id.split("|");
    document.getElementById('currency_val').value = res[0];
    document.getElementById('symbol_currency').value = res[1];
    document.getElementById('rate_currency').value = res[0];
    document.getElementById('jr_rate1').value = res[0];
    document.getElementById('jr_rate2').value = res[0];
    document.getElementById('jr_rate3').value = res[0];
    document.getElementById('jr_rate4').value = res[0];
    document.getElementById('jr_rate5').value = res[0];
    document.getElementById('jr_rate6').value = res[0];
  }

  function debit() {
    var sum = 0;
    var amount = document.getElementsByClassName('amount');
    var price = document.getElementsByClassName('price');
    var quantity = document.getElementsByClassName('quantity');
    var txtSGD = document.getElementsByClassName('txtSGD');
    var cur = document.getElementById('rate_currency').value;
    var nota_debet = document.getElementById('nota_debet').value;
    //var nota_credit = document.getElementById('nota_credit');

    for (var i = 0; i < price.length; i++) {
      amount[i].value = price[i].value * quantity[i].value;
      txtSGD[i].value = cur * amount[i].value;

    }
    //iterate through each textboxes and add the values
    $(".txtSGD").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum;

  }

  function hitung_total() {
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var jur_credit = document.getElementsByClassName('jur_credit');
    var dk = document.getElementsByClassName('dk');
    var rate = document.getElementsByClassName('jr_rate');
    for (var i = 0; i < total.length; i++) {
      if (dk[i].value === 'D') {
        jur_credit[i].value = 0;
        jur_det[i].value = total[i].value * rate[i].value;
      } else {
        jur_det[i].value = 0;
        jur_credit[i].value = total[i].value * rate[i].value;
      }
    }
  }


  function tambah_baris() {
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/Payable_recognition/list_currency",
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
    var num = 1;
    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr>\n\
                <td><input type="hidden" name="Detail_ID[]" value="0" /></td>\n\
                <td><input type="text" name="txtItem[]" class="txt" required/></td>\n\
                <td><input type="text" name="txtQty[]" class="txt number quantity" onkeypress="return isNumber(event)" value="0"  onKeyup="debit()"/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number price" onkeypress="return isNumber(event); " onKeyup="debit()"   value="0" /></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount" onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <td><div class="CurID"></div></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        </tr>');
    }
  }

  function tambah_jurnal() {
    var num = 1;
    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {

      $('table[id="table_jurnal"]').append('<tr>\n\
                                            <td>\n\
                                                <input type="hidden" name="DetailID[]" value="0"/>\n\
                                                <input type="text" name="no_coa[]" value="-" class="txt">\n\
                                            </td>\n\
                                            <td>\n\
                                            <select name="dk[]" onchange="buat_nol()" class="txt dk">\n\
                                                <option value="D">D</option>\n\
                                                <option value="C">C</option>\n\
                                            </select>\n\
                                            </td>\n\
                                            <td>\n\
                                                <input type="hidden" name="NoUrut[]" value="2" class="txt">\n\
                                                <input type="text" name="JenisJurnal[]" value="-" class="txt">\n\
                                            </td>\n\
                                            <td><input type="text" name="desc[]" value="-" class="txt"></td>\n\
                                            <td class="total"><input type="text" name="total[]" value="0" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="rate_jr[]" value="' + rate + '" class="txt number jur_rate" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="debt_jr[]" value="0" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="credit_jr[]" value="0" class="txt number jur_credit" onkeypress="return isNumber(event)"></td> \n\
                                           </tr>');
    }
  }


  function hapus_baris() {
    var sum = 0;
    document.getElementById("tabel").deleteRow(-1);
    $(".txtSGD").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum;
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur = $s->nofaktur;
    $kode_sup = $s->kode_sup;
    $currency_id = $s->rate . "|" . $s->currency_id;
    $Currency_symbol = $s->currency_id;
    $rate = $s->rate;
    $sdate = new DateTime($s->tanggal);
    $date_of_journal = date_format($sdate, 'm/d/Y');
    $idate = new DateTime($s->tanggal_invoice);
    $date_invoice = date_format($idate, 'm/d/Y');
    $term = $s->term;
    $nota_debet = $s->nota_debet;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
  }
} else {
  $nofaktur = '';
  $kode_sup = '';
  $currency_id = '';
  $Currency_symbol = '';
  $rate = '0';
  $date_of_journal = date('m/d/Y');
  $date_invoice = date('m/d/Y');
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
      <form action="<?php echo base_url(); ?>index.php/Payable_recognition/save_payable_rec" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Payable Recognition</span>
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
                      <label class="control-label col-md-3">Ref. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" value="<?php echo $nofaktur; ?>" class="form-control" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Vendor</label>
                      <div class="col-md-9">
                        <?php
                        if ($kode_sup == '') {
                          $style_kategori = "class='select2me form-control' id='supplier' $disable";
                          echo form_dropdown('supplier', $SupplierID, $kode_sup, $style_kategori);
                        } else {
                          echo "<input type='text' name='supplier'  class='form-control' value='$kode_sup' $readonly />";
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        if ($currency_id == '') {
                          $style_currency = "class='select2me form-control' id='currency' onchange='get_currency()' required";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                        } else {
                          echo "<input type='text' name='Currency'  class='form-control' value='$Currency_symbol' $readonly />";
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Rate</label>
                      <div class="col-md-9">
                        <input type="text" id="rate_currency" name="rate_header" class="form-control" value="<?php echo $rate; ?>" onkeypress="return isNumber(event)" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date of Journal</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_tempo" name="tgl_tempo" class="form-control date date-picker" value="<?php echo $date_of_journal; ?>" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_invoice" name="tgl_invoice" class="form-control date date-picker" value="<?php echo $date_invoice; ?>" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Term</label>
                      <div class="col-md-3">
                        <input type="text" id="term" name="term" value="<?php echo $term; ?>" class="form-control" onkeypress="return isNumber(event)" <?php echo $readonly; ?> required />
                        <input type="hidden" id="symbol_currency" name="symbol_currency" value="<?php echo $Currency_symbol; ?>" class="form-control" />
                        <input type="hidden" id="currency_val" name="currency_val" value="<?php echo $rate; ?>" class="form-control currency_val" />

                      </div>
                      <label class="control-label"> Days</label>
                    </div>
                  </div>
                </div>
                <hr />
                <a class="btn btn-success btn-add" onclick="tambah_baris()"><i class="fa fa-plus-circle"></i> Add Detail</a>
                <a type="reset" class="btn btn-danger" onclick="hapus_baris()"><i class="fa fa-close"></i> Remove Detail</a>
                <div class="col-md-2 kanan">
                  <input type="text" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <label class="control-label col-md-1 kanan">Grand Total</label>
                <div id="demo" style="display: none"></div>
                <hr />

              </div>
              <!-- <table id="p_recognition"></table>
                                <div id="pager1"></div> -->
              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="3%">
                    </th>
                    <th>
                      Items
                    </th>
                    <th width="10%">
                      Qty
                    </th>
                    <th width="5%">
                      Unit
                    </th>
                    <th width="10%">
                      Price
                    </th>
                    <th width="10%">
                      Amount
                    </th>
                    <th width="10%">
                      Currency Items
                    </th>
                    <th width="10%">
                      Rate
                    </th>
                    <th width="15%">
                      USD Equivalent
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  if (!empty($get_data_detail)) {
                    foreach ($get_data_detail as $v) {
                  ?>
                      <tr>
                        <td style="text-align: center;">
                          <input type="hidden" name="Detail_ID[]" value="<?php echo $v->DetailID; ?>" />
                          <a href="<?php echo base_url(); ?>index.php/Payable_recognition/delete?id=<?php echo $v->DetailID; ?>&nofaktur=<?php echo $v->HeaderID; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                        <td><input type="text" class="txt" name="txtItem[]" value="<?php echo $v->Items; ?>" /></td>
                        <td><input type="text" class="txt number quantity" name="txtQty[]" value="<?php echo number_format($v->Qty, 5, '.', ''); ?>" onkeypress="return isNumber(event);" onKeyup="debit()" /></td>
                        <td>
                          <input type="text" name="txtUnit[]" class="txt" />
                        </td>
                        <td><input type="text" class="txt number price" name="txtPrice[]" onkeypress="return isNumber(event);
                                                           " value="<?php echo number_format($v->Harga, 5, '.', ''); ?>" onKeyup="debit()" /></td>
                        <td><input type="text" class="txt number amount" name="txtAmount[]" onkeypress="return isNumber(event);" value="<?php echo number_format($v->Qty * $v->Harga, 5, '.', ''); ?>" /></td>
                        <td>
                          <?php
                          $style_currency = 'class="txt" id="txtCurrency" required';
                          echo form_dropdown('txtCurrency[]', $CurrencyID, $v->currency, $style_currency);
                          ?>
                        </td>
                        <td><input type="text" class="txt number" name="txtRate[]" onkeypress="return isNumber(event)" value="<?php echo number_format($v->rate, 5, '.', ''); ?>" /></td>
                        <td><input type="text" class="txt number txtSGD" name="txtSGD[]" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Qty * $v->Harga * $v->rate, 2, '.', ''); ?>" /></td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
              <hr />
              <table class="table table-bordered" id="table_jurnal">
                <thead>
                  <th></th>
                  <th>Account Number</th>
                  <th width="4%">D/K</th>
                  <th>Account Name</th>
                  <th width="40%">Description</th>
                  <th>Total</th>
                  <th>Rate</th>
                  <th>Debt</th>
                  <th>Credit</th>
                </thead>
                <tbody>
                  <?php
                  if (!empty($get_data_footer)) {
                    foreach ($get_data_footer as $f) {

                      $Uraian1 = $f->Uraian;
                      $Total1 = number_format($f->Total, 5, '.', '');
                      $Rate1 = number_format($f->Rate, 5, '.', '');
                      $Debet1 = number_format($f->Debet, 5, '.', '');
                      $Kredit1 = number_format($f->Kredit, 5, '.', '');
                  ?>
                      <tr>
                        <td style="text-align: center;">
                          <input type="hidden" name="Detail_ID[]" value="<?php echo $f->DetailID; ?>" />
                          <a href="<?php echo base_url(); ?>index.php/Payable_recognition/hapus?id=<?php echo $f->DetailID; ?>&nofaktur=<?php echo $HeaderID; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <input type="hidden" name="DetailID[]" value="<?php echo $f->DetailID; ?>" />
                          <input type="text" name="no_coa[]" value="<?php echo $f->NoCOA; ?>" class="txt">
                        </td>
                        <td>
                          <select name="dk[]" onchange="hitung_total()" class="txt dk">
                            <option value="D" <?php if ($f->chk == 'D') {
                                                echo 'selected';
                                              } ?>>D</option>
                            <option value="C" <?php if ($f->chk == 'C') {
                                                echo 'selected';
                                              } ?>>C</option>
                          </select>
                        <td>
                          <input type="hidden" name="NoUrut[]" value="<?php echo $f->NoUrut; ?>" class="txt">
                          <input type="text" name="JenisJurnal[]" value="<?php echo $f->JenisJurnalID; ?>" class="txt">
                        </td>
                        <td><input type="text" name="desc[]" value="-" class="txt"></td>
                        <td class="total">
                          <input type="text" name="total[]" value="<?php echo $Total1; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input type="text" name="rate_jr[]" class="txt number jr_rate" value="<?php echo "$Rate1"; ?>" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="debt_jr[]" value="<?php echo $Debet1; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit1; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>

                    <?php
                    }
                  } else if (empty($get_data_footer)) {
                    $DetailID1 = '0';
                    $NoCOA1 = '-';
                    $Uraian1 = '-';
                    $Total1 = '0';
                    $Rate1 = '0';
                    $Debet1 = '0';
                    $Kredit1 = '0';

                    $DetailID2 = '0';
                    $NoCOA2 = '-';
                    $Uraian2 = '-';
                    $Total2 = '0';
                    $Rate2 = '0';
                    $Debet2 = '0';
                    $Kredit2 = '0';

                    $DetailID3 = '0';
                    $NoCOA3 = '-';
                    $Uraian3 = '-';
                    $Total3 = '0';
                    $Rate3 = '0';
                    $Debet3 = '0';
                    $Kredit3 = '0';

                    $DetailID4 = '0';
                    $NoCOA4 = '-';
                    $Uraian4 = '-';
                    $Total4 = '0';
                    $Rate4 = '0';
                    $Debet4 = '0';
                    $Kredit4 = '0';

                    $DetailID5 = '';
                    $NoCOA5 = '-';
                    $Uraian5 = '-';
                    $Total5 = '0';
                    $Rate5 = '0';
                    $Debet5 = '0';
                    $Kredit5 = '0';

                    $DetailID6 = '';
                    $NoCOA6 = '-';
                    $Uraian6 = '-';
                    $Total6 = '0';
                    $Rate6 = '0';
                    $Debet6 = '0';
                    $Kredit6 = '0';
                    ?>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="hitung_total()" class="txt dk">
                          <option value="D" selected>D</option>
                          <option value="C">C</option>
                        </select>
                      <td>
                        <input type="hidden" name="NoUrut[]" value="1" class="txt">
                        <input type="text" name="JenisJurnal[]" value="Purchase" class="txt">
                      </td>
                      <td><input type="text" name="desc[0]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[0]" value="<?php echo $Total1; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[0]" id="jr_rate1" value="<?php echo $Rate1; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[0]" value="<?php echo $Debet1; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[0]" value="<?php echo $Kredit1; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="buat_nol()" class="txt dk">
                          <option value="D">D</option>
                          <option value="C" selected>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="hidden" name="NoUrut[]" value="2" class="txt">
                        <input type="text" name="JenisJurnal[]" value="Discount" class="txt">
                      </td>
                      <td><input type="text" name="desc[]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[]" value="<?php echo $Total2; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[]" id="jr_rate2" value="<?php echo $Rate2; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[]" value="<?php echo $Debet2; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit2; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="buat_nol()" class="txt dk">
                          <option value="D" selected>D</option>
                          <option value="C">C</option>
                        </select>
                      </td>
                      <td>
                        <input type="hidden" name="NoUrut[]" value="3" class="txt">
                        <input type="text" name="JenisJurnal[]" value="Tax" class="txt">
                      </td>
                      <td><input type="text" name="desc[]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[]" value="<?php echo $Total3; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[]" id="jr_rate3" value="<?php echo $Rate3; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[]" value="<?php echo $Debet3; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit3; ?>" class="txt number  jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="buat_nol()" class="txt dk">
                          <option value="D">D</option>
                          <option value="C" selected>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[]" value="Additional costs" class="txt">
                        <input type="hidden" name="NoUrut[]" value="4" class="txt">
                      </td>
                      <td><input type="text" name="desc[]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[]" value="<?php echo $Total4; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[]" id="jr_rate4" value="<?php echo $Rate4; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[]" value="<?php echo $Debet4; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit4; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="buat_nol()" class="txt dk">
                          <option value="D">D</option>
                          <option value="C" selected>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[]" value="Down Payment" class="txt">
                        <input type="hidden" name="NoUrut[]" value="5" class="txt">
                      </td>
                      <td><input type="text" name="desc[]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[]" value="<?php echo $Total5; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[]" id="jr_rate5" value="<?php echo $Rate5; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[]" value="<?php echo $Debet5; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit5; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="0" />
                        <input type="text" name="no_coa[]" value="-" class="txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="buat_nol()" class="txt dk">
                          <option value="D">D</option>
                          <option value="C" selected>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[]" value="Account payable" class="txt">
                        <input type="hidden" name="NoUrut[]" value="6" class="txt">
                      </td>
                      <td><input type="text" name="desc[]" value="-" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total[]" value="<?php echo $Total6; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[]" id="jr_rate6" value="<?php echo $Rate6; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[]" value="<?php echo $Debet6; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[]" value="<?php echo $Kredit6; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                  <?php }
                  ?>

                </tbody>
              </table>
              <hr />
              <a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-download"></i> Input</a>
              <button type="submit" name="sbt" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/Payable_recognition"><i class="fa fa-warning"></i> Cancel</a>
              <a type="reset" class="btn btn-primary  kanan"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>