<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>
<script>
  $(function() {
    $('.no_coa').autocomplete({
      serviceUrl: "<?php echo site_url('PO_journal/get_coa'); ?>"
    });

  });
</script>

<script>
  function get_currency() {
    //var supp = document.getElementById('supplier').value;
    var cur = document.getElementById('cur').value;
    if (cur == '') {
      document.getElementById('supplier').disabled = true;
    } else {
      //document.getElementById('supplier').selected = false;
      document.getElementById('supplier').disabled = false;
    }
    var res = cur.split("|");
    document.getElementById('rate').value = res[0];
    document.getElementById('curid').value = res[1];
    get_vendor();
  }

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

  function get_vendor() {
    var po = document.getElementById('supplier').value;
    var curid = document.getElementById('curid').value;
    // alert(po);
    document.getElementById('idsup').value = po;
    $.ajax({
      url: "<?php echo base_url(); ?>Sales_invoice_journal_pur/tampilpo/" + po + "/" + curid + "",
      success: function(response) {
        $('#detailpo').html(response);
      },
      dataType: "html"
    });
  }


  function hitungSelisihHari() {
    tgl2 = document.getElementById('tgl_tempo').value;
    tgl1 = document.getElementById('tgl_invoice').value;
    // varibel miliday sebagai pembagi untuk menghasilkan hari
    var miliday = 24 * 60 * 60 * 1000;
    //buat object Date
    var tanggal1 = new Date(tgl1);
    var tanggal2 = new Date(tgl2);
    // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
    var tglPertama = Date.parse(tanggal1);
    var tglKedua = Date.parse(tanggal2);
    var selisih = (tglKedua - tglPertama) / miliday;

    document.getElementById('term').value = selisih;
  }

  function hitungSelisihHari2() {
    var tgl2 = document.getElementById('term').value;
    var tt = document.getElementById('tgl_invoice').value;
    var tgl3 = document.getElementById('tgl_tempo');

    var date = new Date(tt);
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() + Number(tgl2));

    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();

    var someFormattedDate = mm + '/' + dd + '/' + y;
    tgl3.value = someFormattedDate;
  }

  function debit() {

    var amount = document.getElementsByClassName('txtamount');
    var price = document.getElementsByClassName('txtprice');
    var quantity = document.getElementsByClassName('txtqty');
    var txtgrand = document.getElementsByClassName('txtgrand');
    var rate = document.getElementsByClassName('txtrate');
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    //var cur = document.getElementById('rate_currency').value;
    var nota_debet = document.getElementById('nota_debet').value;

    //var nota_credit = document.getElementById('nota_credit');

    for (var i = 0; i < price.length; i++) {
      amount[i].value = price[i].value * quantity[i].value;
      txtgrand[i].value = rate[i].value * amount[i].value;
    }
    //iterate through each textboxes and add the values
    var sum = grand_total();
    var sum2 = grand_total2();
    total[0].value = sum;
    hitung_total();
    document.getElementById('nota_debet').value = sum;
    document.getElementById('nota_debit').value = sum2;
  }

  function get_rate() {
    var rater = 0;
    //var jlh = document.getElementById('destinationtable').getElementsByTagName('tr').length - 2;
    //var rates = document.getElementsByClassName('rate_jr');
    $("#destinationtable .txtrate").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length != 0) {
        rater += parseFloat(this.value);
      }

    });
    //document.getElementById('rate') = rater;
    //document.getElementById('nota_debet').value = sum;
    //alert(rate);
    // for(var i = 0; i < rates.length; i++){
    //     rates[i].value = rate;
    // }

    return rater;
  }

  function grand_total() {
    var sum = 0;
    $("#destinationtable .txtamount").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }

    });
    document.getElementById('nota_debet').value = sum;
    return sum;
  }

  function grand_total2() {
    var sum = 0;
    $("#destinationtable .txtgrand").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }

    });
    document.getElementById('nota_debit').value = sum;
    return sum;
  }


  function sum() {
    var total = document.getElementsByClassName('jur_total');
    $("#destinationtable .txtamount").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }

    });
    document.getElementById('nota_debet').value = sum;

  }


  function hitung_total() {

    var rater;
    var sum = grand_total();
    var sum2 = grand_total2();
    var usd = document.getElementById('nota_debet').value;
    var totali = document.getElementById('nota_debit').value;
    rater = totali / usd;
    document.getElementById('rate').value = rater;
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var jur_credit = document.getElementsByClassName('jur_credit');
    var rates = document.getElementsByClassName('jr_rate');
    var rate_r = document.getElementById('rate').value;
    var dk = document.getElementsByClassName('dk');
    var sum_dbt = 0;
    var sum_crt = 0;
    var total_AP = 0;
    total[0].value = sum;
    for (var i = 0; i < total.length; i++) {
      rates[i].value = rater;
      if (i < 5) {
        if (dk[i].value === "D") {
          total_AP -= Number(total[i].value);
        } else {
          total_AP += Number(total[i].value);
        }
        total[5].value = total_AP;
      }
      if (dk[i].value === 'D') {
        jur_det[i].value = Number(total[i].value) * Number(rates[i].value);
        jur_credit[i].value = 0;
        sum_dbt += Number(jur_det[i].value);
      } else if (dk[i].value === 'C') {
        jur_credit[i].value = Number(total[i].value) * Number(rates[i].value);
        jur_det[i].value = 0;
        sum_crt += Number(jur_credit[i].value);
      }
    }

    document.getElementById('total_debet').value = sum_dbt;
    document.getElementById('total_credit').value = sum_crt;
  }

  function tambah_jurnal() {
    var num = 1;
    var rate = document.getElementById('rate').value;
    for (var i = 0; i < num; i++) {

      $('table[id="table_jurnal"]').append('<tr>\n\
                                        <td>\n\
                                            <input type="hidden" name="DetailID[]" value="0"/>\n\
                                            <input type="text" name="no_coa[]" value="-" class="txt">\n\
                                        </td>\n\
                                        <td>\n\
                                        <select name="dk[]" class="txt dk" onchange="hitung_total()">\n\
                                            <option value="D" selected>D</option>\n\
                                            <option value="C">C</option>\n\
                                        </select>\n\
                                        </td>\n\
                                        <td>\n\
                                            <input type="hidden" name="NoUrut[]" value="7" class="txt">\n\
                                            <input type="text" name="JenisJurnal[]" value="" class="txt">\n\
                                        </td>\n\
                                        <td><input type="text" name="desc[]" value="-" class="txt"></td>\n\
                                        <td class="total"><input type="text" name="total[]" value="0" class="txt number jur_total" onkeypress="return isNumber(event)" onKeyup="hitung_total()" required></td>\n\
                                        <td><input type="text" name="rate_jr[]" value="' + rate + '" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>\n\
                                        <td><input type="text" name="debt_jr[]" value = 0 class="txt number jur_deb" onkeypress="return isNumber(event)"></td>\n\
                                        <td><input type="text" name="credit_jr[]" value = 0 class="txt number jur_credit" onkeypress="return isNumber(event)"></td> \n\
                                       </tr>');
    }
  }

  function cekForm(isForm) {
    if (isForm.total_debet.value !== isForm.total_credit.value) {
      alert("must balance");
      return (false);
    }
    return (true);
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $l) {
    $nojurnalinvoice = $l->nofaktur;
    $kode_sup = $l->kode_sup;
    $namavendor = $l->namacustomer;
    $currency_id = $l->rate . "|" . $l->currency;
    $Currency_symbol = $l->currency;
    $rate = $l->rate;
    $sdate = new DateTime($l->tanggal);
    $date_of_journal = date_format($sdate, 'm/d/Y');
    $idate = new DateTime($l->tanggal_invoice);
    $date_invoice = date_format($idate, 'm/d/Y');
    $tdate = new DateTime($l->tanggal_tempo);
    $date_tempo = date_format($tdate, 'm/d/Y');
    $term = $l->term;
    $nota_debet = $l->nota_debet;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
    $dt = 1;
  }
} else {
  $nojurnalinvoice = '';
  $kode_sup = '';
  $currency_id = '';
  $Currency_symbol = '';
  $rate = '0';
  $date_of_journal = date('m/d/Y');
  $date_invoice = date('m/d/Y');
  $date_tempo = date('m/d/Y');
  $term = '0';
  $nota_debet = '0';
  $readonly = '';
  $disable = 'disable';
  $submit_value = 'Save';
  $dt = 0;
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Sales_invoice_journal_pur/save_jurnal" method="post" id="from" name="from">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Sales Invoice Journal</span>
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
                      <label class="control-label col-md-3">Document Number</label>
                      <div class="col-md-9">
                        <input type="text" id="nofaktur" name="nofaktur" onKeydown="validasi_enter(event)" value="<?php echo $nojurnalinvoice; ?>" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="sup" name="sup" onKeydown="validasi_enter(event)" value="<?php echo $kode_sup; ?>" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" name="periode" value="<?php echo $this->session->userdata('periode_1'); ?>" id="s_period" />
                        <input type="hidden" name="until" value="<?php echo $this->session->userdata('closing_date'); ?>" id="s_until" />
                        <input type="hidden" name="until" id="txt_save" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <?php
                        if ($dt == 0) {
                          $style_kategori = 'class="select2me form-control" id="supplier" onKeydown="validasi_enter(event)" onchange="get_vendor()" name="supplier" required';
                          echo form_dropdown('supplier', $supp, $kode_sup, $style_kategori);
                        } else {
                          echo "<input type='text' onKeydown='validasi_enter(event)' name='supplier' class='form-control' value='$namavendor' $readonly />";
                        }
                        ?>
                        <input type="hidden" onKeydown="validasi_enter(event)" id="idsup" name="idsup" class="form-control" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          if ($dt == 0) {
                            $style_cur = 'class="select2me form-control" id="cur" onKeydown="validasi_enter(event)" onchange="get_currency()" name="cur" required';
                            echo form_dropdown('cur', $cur, $currency_id, $style_cur);
                          } else {
                            echo "<input type='text' name='cur' class='form-control' onKeydown='validasi_enter(event)' value='$Currency_symbol' $readonly/>";
                          }
                          ?>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Rate</label>
                      <div class="col-md-9">
                        <input type="text" id="rate" onKeydown="validasi_enter(event)" name="rate" class="form-control" value="<?php echo $rate; ?>" onkeypress="return isNumber(event)" readonly required />
                        <input type="hidden" id="curid" onKeydown="validasi_enter(event)" name="curid" class="form-control" value="<?php //echo $rate; 
                                                                                                                                    ?>" onkeypress="return isNumber(event)" readonly required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date of Journal</label>
                      <div class="col-md-3">
                        <?php
                        if ($dt == 0) {
                        ?>
                          <input type="text" id="tgl_jurnal" onKeydown="return validasi_enter(event)" name="tgl_jurnal" class="form-control date date-picker" value="<?php echo $date_of_journal; ?>" onchange="getTerm()" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                        <?php
                        } else {
                        ?>
                          <input type="text" id="tgl_tempo" onKeydown="return validasi_enter(event)" name="tgl_tempo" class="form-control" value="<?php echo $date_of_journal; ?>" readonly data-date-format="mm/dd/yyyy" required />
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Due Date</label>
                      <div class="col-md-3">
                        <?php
                        if ($dt == 0) {
                        ?>
                          <input type="text" id="tgl_tempo" onKeydown="return validasi_enter(event)" name="tgl_tempo" onchange="hitungSelisihHari()" class="form-control date date-picker" value="<?php echo $date_tempo; ?>" onchange="getTerm()" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                        <?php
                        } else {
                        ?>
                          <input type="text" id="tgl_tempo" onKeydown="return validasi_enter(event)" name="tgl_tempo" class="form-control" value="<?php echo $date_tempo; ?>" readonly data-date-format="mm/dd/yyyy" required />
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <?php
                        if ($dt == 0) {
                        ?>
                          <input type="text" id="tgl_invoice" name="tgl_invoice" onchange="hitungSelisihHari()" onKeydown="return validasi_enter(event)" class="form-control date date-picker" value="<?php echo $date_invoice; ?>" onchange="getTerm()" data-date-format="mm/dd/yyyy" <?php echo $readonly; ?> required />
                        <?php
                        } else {
                        ?>
                          <input type="text" id="tgl_invoice" name="tgl_invoice" onKeydown="return validasi_enter(event)" class="form-control" value="<?php echo $date_invoice; ?>" data-date-format="mm/dd/yyyy" readonly required />
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Term</label>
                      <div class="col-md-3">
                        <input type="text" onKeydown="return validasi_enter(event)" onKeyup="hitungSelisihHari2()" id="term" name="term" value="<?php echo $term; ?>" class="form-control" onkeypress="return isNumber(event)" <?php echo $readonly; ?> required />
                        <input type="hidden" id="symbol_currency" name="symbol_currency" value="<?php //echo //$Currency_symbol; 
                                                                                                ?>" class="form-control" />
                        <input type="hidden" id="currency_val" name="currency_val" value="<?php //echo $rate; 
                                                                                          ?>" class="form-control currency_val" />

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-2 kanan">
                  <input readonly onKeydown="validasi_enter(event)" type="text" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                  <input readonly onKeydown="validasi_enter(event)" type="hidden" id="nota_debit" name="nota_debit" value="" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <label class="control-label col-md-1 kanan">Grand Total</label>
                <div id="demo" style="display: none"></div>
                <hr />

                <table class="table table-bordered" id="destinationtable">
                  <thead>
                    <tr>
                      <th width="3%">
                        <a data-toggle="modal" class="btn btn-primary glyphicon glyphicon-search" href="#coa"></a>
                      </th>
                      <th width="10%">
                        Items ID
                      </th>
                      <th width="20%">
                        Items Name
                      </th>
                      <th width="10%">
                        Qty
                      </th>
                      <th width="10%">
                        Quantity
                      </th>
                      <th width="10%">
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
                      <th width="10%">
                        USD Equivalent
                      </th>
                    </tr>
                  </thead>

                  <tr style="background: #cccccc; font-weight: bold">
                    <td colspan="11"></td>
                  </tr>
                  <?php
                  if (!empty($get_data_item)) {
                  ?>
                    <tbody>
                      <?php
                      foreach ($get_data_item as $r) {
                      ?>
                        <tr>
                          <td></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtidem[]" readonly class="txt" value="<?php echo $r->ItemID; ?>" required /><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $r->npbbitem; ?>" required /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtinem[]" readonly class="txt" value="<?php echo $r->ItemName; ?>" /></td>
                          <td>
                            <input type="text" onKeydown="validasi_enter(event)" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $r->Qty; ?>" />
                            <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $r->qty_SIP; ?>" />
                            <input type="hidden" name="txtqty_awal[]" class="txt number txtqty_awal" value="<?php echo $r->Qty; ?>" />
                            <!-- <input type="hidden" name="npbbid[]" class="txt number npbbid" value="<?php echo $r->npbbid; ?>" />
                                                <input type="hidden" name="productid[]" class="txt number productid" value="<?php echo $r->product_id; ?>" /> -->
                          </td>
                          <td><input type="text" name="txtquantity[]" class="txt number txtquantity" value="<?php echo $r->Quantity; ?>"></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtunit[]" class="txt" value="<?php echo $r->unit; ?>" /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo number_format($r->unitprice, 2, '.', ''); ?>" /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo number_format($r->amount, 2, '.', ','); ?>" /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtcurrency[]" readonly class="txt" value="<?php echo $r->currency; ?>" /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtrate[]" readonly class="txt number txtrate" value="<?php echo number_format($r->rate, 2, '.', ','); ?>" /></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo number_format($r->usdequivalent, 2, '.', ','); ?>" /></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  <?php
                  } else {
                  ?>
                    <tbody></tbody>

                  <?php
                  }
                  ?>

                </table>
                <hr />


                <table class="table table-bordered" id="table_jurnal">
                  <thead>
                    <th>Account Number</th>
                    <th>D/K</th>
                    <th>Account Name</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Rate</th>
                    <th>Debt</th>
                    <th>Credit</th>
                  </thead>
                  <tbody>
                    <?php
                    $sum_debet;
                    $sum_credit;
                    if (!empty($get_data_footer)) {
                      $sum_debet = 0;
                      $sum_credit = 0;

                      foreach ($get_data_footer as $f) {
                        // $detailid = $f->DetailID;
                        $check = $f->chk;
                        $nourut = $f->NoUrut;
                        $DetailID = $f->DetailID;
                        $str = $f->NoCOA;
                        $NoCOA = explode("|", $str);
                        $Uraian = $f->Uraian;
                        $Total = number_format($f->Total, 2, '.', ',');
                        $Rate = number_format($f->Rate, 2, '.', ',');
                        $debit = $f->Debet;
                        if ($debit != 0) {
                          $Debet = number_format($f->Debet, 2, '.', ',');
                        } else {
                          $Debet = '';
                        }
                        $credt = $f->Kredit;
                        if ($credt != 0) {
                          $Kredit = number_format($f->Kredit, 2, '.', ',');
                        } else {
                          $Kredit = '';
                        }


                        $sum_debet += $f->Debet;
                        $sum_credit += $f->Kredit;
                        $JenisJurnalID = $f->JenisJurnalID;
                    ?>
                        <tr>
                          <td>
                            <input type="hidden" name="DetailID[]" onKeydown="validasi_enter(event)" value="<?php echo $DetailID; ?>" />
                            <input type="text" name="no_coa[]" onKeydown="validasi_enter(event)" value="<?php echo $NoCOA[0]; ?>" class="txt">
                          </td>
                          <td>

                            <select name="dk[]" class="txt dk" onKeydown="validasi_enter(event)" onchange="hitung_total()">
                              <option value="D" <?php if ($check == 'D') {
                                                  echo 'selected';
                                                } ?>>D</option>
                              <option value="C" <?php if ($check == 'C') {
                                                  echo 'selected';
                                                } ?>>C</option>
                            </select>
                          <td>
                            <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="<?php echo $nourut ?>" class="txt">
                            <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="<?php echo $JenisJurnalID ?>" class="txt">
                          </td>
                          <td><input type="text" onKeydown="validasi_enter(event)" name="desc[]" value="<?php echo $Uraian; ?>" class="txt"></td>
                          <td class="total">
                            <?php if ($nourut == 1 || $nourut == 6) { ?>
                              <input type="text" onKeydown="validasi_enter(event)" name="total[]" readonly value="<?php echo $Total; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                            <?php
                            } else {
                            ?>
                              <input type="text" onKeydown="validasi_enter(event)" name="total[]" value="<?php echo $Total; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                            <?php
                            }
                            ?>
                          </td>
                          <td><input type="text" onKeydown="validasi_enter(event)" readonly name="rate_jr[]" id="jr_rate1" value="<?php echo $Rate; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" readonly name="debt_jr[]" value="<?php echo $Debet; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                          <td><input type="text" onKeydown="validasi_enter(event)" readonly name="credit_jr[]" value="<?php echo $Kredit; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                        </tr>
                      <?php
                      }
                    } else {
                      $sum_debet = 0;
                      $sum_credit = 0;
                      $DetailID1 = '0';
                      // $NoCOA1 = '-';
                      $Uraian1 = 'Customer';
                      $Total1 = '0';
                      $Rate1 = '0';
                      $Debet1 = '0';
                      $Kredit1 = '0';

                      $DetailID2 = '0';
                      // $NoCOA2 = '-';
                      $Uraian2 = 'Discount';
                      $Total2 = '0';
                      $Rate2 = '0';
                      $Debet2 = '0';
                      $Kredit2 = '0';

                      $DetailID3 = '0';
                      // $NoCOA3 = '-';
                      $Uraian3 = 'Tax';
                      $Total3 = '0';
                      $Rate3 = '0';
                      $Debet3 = '0';
                      $Kredit3 = '0';

                      $DetailID4 = '0';
                      // $NoCOA4 = '-';
                      $Uraian4 = 'Additional Cost';
                      $Total4 = '0';
                      $Rate4 = '0';
                      $Debet4 = '0';
                      $Kredit4 = '0';

                      $DetailID5 = '';
                      // $NoCOA5 = '-';
                      $Uraian5 = 'Down Payment';
                      $Total5 = '0';
                      $Rate5 = '0';
                      $Debet5 = '0';
                      $Kredit5 = '0';

                      $DetailID6 = '';
                      // $NoCOA6 = '-';
                      $Uraian6 = 'Sales';
                      $Total6 = '0';
                      $Rate6 = '0';
                      $Debet6 = '0';
                      $Kredit6 = '0';

                      ?>

                      <tr>
                        <td width="20%">
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" name="no_coa[0]" value="" />
                          <input type="hidden" onKeydown="validasi_enter(event)" name="DetailID[]" value="<?php echo $DetailID1; ?>" />
                          <!-- <input type="text" onKeydown="validasi_enter(event)" name="no_coa[]" value="<?php echo $NoCOA1; ?>" class="txt"> -->
                        </td>
                        <td width="4%">
                          <select name="dk[]" class="txt dk" onKeydown="validasi_enter(event)" onchange="hitung_total()">
                            <option value="D">D</option>
                            <option value="C" selected>C</option>
                          </select>
                        <td>
                          <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="1" class="txt">
                          <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="Total Before" class="txt">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" name="desc[0]" value="<?php echo $Uraian1; ?>" class="txt"></td>
                        <td class="total">
                          <input type="text" onKeydown="validasi_enter(event)" name="total[0]" value="<?php echo $Total1; ?>" readonly class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="rate_jr[0]" id="jr_rate1" value="<?php echo $Rate1; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="debt_jr[0]" value="<?php echo $Debet1; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="credit_jr[0]" value="<?php echo $Kredit1; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" name="no_coa[1]" value="" /> <br />
                          <input type="hidden" onKeydown="validasi_enter(event)" name="DetailID[]" value="<?php echo $DetailID2; ?>" />
                          <!-- <input type="text" onKeydown="validasi_enter(event)" name="no_coa[]" value="<?php echo $NoCOA2; ?>" class="txt"> -->
                        </td>
                        <td>
                          <select name="dk[]" class="txt dk" onKeydown="validasi_enter(event)" onchange="hitung_total()">
                            <option value="D" selected>D</option>
                            <option value="C">C</option>
                          </select>
                        </td>
                        <td>
                          <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="2" class="txt">
                          <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="Discount" class="txt">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" name="desc[]" value="<?php echo $Uraian2; ?>" class="txt"></td>
                        <td class="total">
                          <input type="text" onKeydown="validasi_enter(event)" name="total[]" value="<?php echo $Total2; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="rate_jr[]" id="jr_rate2" value="<?php echo $Rate2; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="debt_jr[]" value="<?php echo $Debet2; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="credit_jr[]" value="<?php echo $Kredit2; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" name="no_coa[2]" value="" /> <br />
                          <input type="hidden" onKeydown="validasi_enter(event)" name="DetailID[]" value="<?php echo $DetailID3; ?>" />
                          <!-- <input type="text" onKeydown="validasi_enter(event)" name="no_coa[]" value="<?php echo $NoCOA3; ?>" class="txt"> -->
                        </td>
                        <td>
                          <select name="dk[]" onKeydown="validasi_enter(event)" class="txt dk" onchange="hitung_total()">
                            <option value="D">D</option>
                            <option value="C" selected>C</option>
                          </select>
                        </td>
                        <td>
                          <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="3" class="txt">
                          <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="Tax" class="txt">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" name="desc[]" value="<?php echo $Uraian3; ?>" class="txt"></td>
                        <td class="total">
                          <input type="text" onKeydown="validasi_enter(event)" name="total[]" value="<?php echo $Total3; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="rate_jr[]" id="jr_rate3" value="<?php echo $Rate3; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="debt_jr[]" value="<?php echo $Debet3; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="credit_jr[]" value="<?php echo $Kredit3; ?>" class="txt number  jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" name="no_coa[3]" value="" /> <br />
                          <input type="hidden" onKeydown="validasi_enter(event)" name="DetailID[]" value="<?php echo $DetailID4; ?>" />
                          <!-- <input type="text" onKeydown="validasi_enter(event)" name="no_coa[]" value="<?php echo $NoCOA4; ?>" class="txt"> -->
                        </td>
                        <td>
                          <select name="dk[]" class="txt dk" onKeydown="validasi_enter(event)" onchange="hitung_total()">
                            <option value="D" selected>D</option>
                            <option value="C">C</option>
                          </select>
                        </td>
                        <td>
                          <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="Additional costs" class="txt">
                          <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="4" class="txt">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" name="desc[]" value="<?php echo $Uraian4; ?>" class="txt"></td>
                        <td class="total">
                          <input type="text" onKeydown="validasi_enter(event)" name="total[]" value="<?php echo $Total4; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="rate_jr[]" id="jr_rate4" value="<?php echo $Rate4; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="debt_jr[]" value="<?php echo $Debet4; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input type="text" onKeydown="validasi_enter(event)" readonly name="credit_jr[]" value="<?php echo $Kredit4; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" name="no_coa[4]" value="" /> <br />
                          <input type="hidden" name="DetailID[]" onKeydown="validasi_enter(event)" value="<?php echo $DetailID5; ?>" />
                          <!-- <input type="text" onKeydown="validasi_enter(event)" name="no_coa[]" value="<?php echo $NoCOA5; ?>" class="txt"> -->
                        </td>
                        <td>
                          <select name="dk[]" class="txt dk" onchange="hitung_total()">
                            <option value="D" selected>D</option>
                            <option value="C">C</option>
                          </select>
                        </td>
                        <td>
                          <input type="text" onKeydown="validasi_enter(event)" name="JenisJurnal[]" value="Down Payment" class="txt">
                          <input type="hidden" onKeydown="validasi_enter(event)" name="NoUrut[]" value="5" class="txt">
                        </td>
                        <td><input type="text" onKeydown="validasi_enter(event)" name="desc[]" value="<?php echo $Uraian5; ?>" class="txt"></td>
                        <td class="total">
                          <input type="text" onKeydown="validasi_enter(event)" name="total[]" value="<?php echo $Total5; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="rate_jr[]" id="jr_rate5" value="<?php echo $Rate5; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="debt_jr[]" value="<?php echo $Debet5; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="credit_jr[]" value="<?php echo $Kredit5; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" class="no_coa txt" onkeypress="return validasi_enter(event)" value="" name="no_coa[5]" /> <br />
                          <input onKeydown="validasi_enter(event)" type="hidden" name="DetailID[]" value="<?php echo $DetailID6; ?>" />
                          <!-- <input onKeydown="validasi_enter(event)" type="text" name="no_coa[]" value="<?php echo $NoCOA6; ?>" class="txt"> -->
                        </td>
                        <td>
                          <select name="dk[]" class="txt dk" onKeydown="validasi_enter(event)" onchange="hitung_total()">
                            <option value="D" selected>D</option>
                            <option value="C">C</option>
                          </select>
                        </td>
                        <td>
                          <input onKeydown="validasi_enter(event)" type="text" name="JenisJurnal[]" value="Total Payment Due" class="txt">
                          <input onKeydown="validasi_enter(event)" type="hidden" name="NoUrut[]" value="6" class="txt">
                        </td>
                        <td><input onKeydown="validasi_enter(event)" type="text" name="desc[]" value="<?php echo $Uraian6; ?>" class="txt"></td>
                        <td class="total">
                          <input onKeydown="validasi_enter(event)" type="text" readonly name="total[]" value="<?php echo $Total6; ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                        </td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="rate_jr[]" id="jr_rate6" value="<?php echo $Rate6; ?>" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="debt_jr[]" value="<?php echo $Debet6; ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                        <td><input onKeydown="validasi_enter(event)" type="text" readonly name="credit_jr[]" value="<?php echo $Kredit6; ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>

              </div>
              <!-- <table id="p_recognition"></table>
                                <div id="pager1"></div> -->
              <hr />
              <!-- <div class="col-md-2 kanan">
                                    <input readonly type="text" id="total_debet" name="total_debet" value="0" class="form-control" onkeypress="return isNumber(event)" required/>
                                    <input readonly type="text" id="total_credit" name="total_credit" value="0" class="form-control" onkeypress="return isNumber(event)" required/>
                                </div> -->
              <table class="table table-bordered" id="table_total">
                <tr>
                  <td>TOTAL DEBET</td>
                  <td> : </td>
                  <td><input readonly type="text" onKeydown="validasi_enter(event)" id="total_debet" name="total_debet" value="<?php echo number_format($sum_debet, 2, '.', ','); ?>" class="form-control" onkeypress="return isNumber(event)" required /></td>
                  <td>&nbsp;
                  <td>TOTAL CREDIT</td>
                  <td> : </td>
                  <td><input readonly type="text" onKeydown="validasi_enter(event)" id="total_credit" name="total_credit" value="<?php echo number_format($sum_credit, 2, '.', ','); ?>" class="form-control" onkeypress="return isNumber(event)" required /></td>
                </tr>
              </table>
              <hr />
              <a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-download"></i> Input</a>
              <button type="submit" onSubmit="return cekForm(this)" name="sbt" id="btn_save" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>Sales_invoice_journal_mar"><i class="fa fa-warning"></i> Cancel</a>
              <a type="reset" class="btn btn-primary  kanan"><i class="fa fa-print"></i> Print</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if ($dt == 0) {
?>
  <div id="detailpo">

  </div>

<?php
} else {
?>
  <script type="text/javascript">
    var addedrows = new Array();
    $(document).ready(function() {
      $("#tabel_coa tbody tr").on("click", function(event) {
        var ok = 0;
        var theid = $(this).attr('id').replace("sour", "");
        var sum = 0;
        var rater = 0;
        var newaddedrows = new Array();
        //var grandtotal = 0;

        for (index = 0; index < addedrows.length; ++index) {
          // if already selected then remove
          if (addedrows[index] == theid) {
            $(this).css("background-color", "#fff");
            // remove from second table :
            var tr = $("#dest" + theid);
            tr.css("background-color", "#FF3700");
            tr.fadeOut(400, function() {
              tr.remove();
              hitung_total();
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
          // retrieve the id of the element to match the id of the new row :
          addedrows.push(theid);
          $(this).css("background-color", "#cacaca");
          $('#destinationtable tr:last').after('<tr id="dest' + theid + '"><td>' +
            $(this).find("td").eq(0).html() + '</td><td>' +
            $(this).find("td").eq(2).html() + '</td><td>' +
            $(this).find("td").eq(3).html() + '</td><td>' +
            $(this).find("td").eq(4).html() + '</td><td>' +
            $(this).find("td").eq(5).html() + '</td><td>' +
            $(this).find("td").eq(6).html() + '</td><td>' +
            $(this).find("td").eq(7).html() + '</td><td>' +
            $(this).find("td").eq(8).html() + '</td><td>' +
            $(this).find("td").eq(9).html() + '</td><td>' +
            $(this).find("td").eq(10).html() + '</td><td>' +
            $(this).find("td").eq(11).html() + '</td></tr>');
        }
        //debit();
        hitung_total();
        //var txtamount = document.getElementsByClassName('txtamount');
        // $("#destinationtable .txtgrand").each(function () {
        //     //add only if the value is number
        // if (!isNaN(this.value) && this.value.length != 0) {
        //     sum += parseFloat(this.value);
        //     }
        // var total = document.getElementsByClassName('jur_total');
        // var jur_det = document.getElementsByClassName('jur_deb');
        // var jur_credit = document.getElementsByClassName('jur_credit');
        // var rate = document.getElementById('rate').value ;

        // rater = sum*rate;
        // total[0].value = sum;
        // jur_det[0].value = rater;
        // total[5].value = sum;
        // jur_credit[5].value = rater;

        // hitung_total();
        //  alert(grandtotal);
        // });
      });

    });

    function cekRate() {
      // if(document.getElementById('cur').value === ""){
      //     alert("Please Select Currency");
      // }
    }
  </script>


  <div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">List of Master COA</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered" id="tabel_coa" width="1300%">
            <thead width="100%">
              <th width="50%" style="display:none"></th>
              <th width="130%">Invoice NO</th>
              <th width="50%">Items</th>
              <th width="130%">Items Name </th>
              <th width="130%">Qty</th>
              <th width="130%">Unit</th>
              <th width="130%">Price</th>
              <th width="130%">Amount</th>
              <th width="130%">currency Items</th>
              <th width="130%">Rate</th>
              <th width="130%">Usd Equivalent</th>

            </thead>
            <tbody width="100%">
              <?php
              if (!empty($tampilpo)) {
                $no = 1;
                foreach ($tampilpo as $s) {
                  $qty_si = $s->qty - $s->qty_SIP;
                  if ($qty_si > 0) {
              ?>
                    <tr id="sour<?php echo $no++; ?>">
                      <td style="display:none"></td>
                      <td><input type="text" name="npbbno[]" class="txt" value="<?php echo $s->invno; ?>" required /></td>
                      <td><input type="text" name="txtidem[]" readonly class="txt" value="<?php echo $s->itemid; ?>" required /><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $s->invno; ?>" required /></td>
                      <td><input type="text" name="txtinem[]" readonly class="txt" value="<?php echo $s->itemname; ?>" /></td>
                      <td>
                        <input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $s->qty - $s->qty_SIP; ?>" />
                        <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $s->qty_SIP; ?>" />
                        <!-- <input type="hidden" name="npbbid[]" class="txt number npbbid" value="<?php echo $s->contract_id; ?>" />
                                        <input type="hidden" name="productid[]" class="txt number productid" value="<?php echo $s->product_id; ?>" /> -->
                      </td>
                      <td><input type="text" name="txtquantity[]" class="txt number txtquantity" value="<?php echo $s->Quantity; ?>"></td>
                      <td><input type="text" name="txtunit[]" readonly class="txt" value="<?php echo $s->uom; ?>" /></td>
                      <td><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo $s->unitprice; ?>" /></td>
                      <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo ($s->qty - $s->qty_SIP) * $s->unitprice; ?>" /></td>
                      <td><input type="text" name="txtcurrency[]" readonly class="txt" value="<?php echo $s->currency; ?>" /></td>
                      <td><input type="text" name="txtrate[]" readonly class="txt number txtrate" value="<?php echo $s->rate; ?>" /></td>
                      <td><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo (($s->qty - $s->qty_SIP) * $s->unitprice) * $s->rate; ?>" /><!-- <input type="hidden" name="txtnpbb[]" readonly class="txt" value="<?php echo $s->npbbno; ?>" /> --></td>
                    </tr>
              <?php
                  }
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


    <script type="text/javascript">
      $(document).ready(function() {
        $("#tabel_coa").dataTable({
          "scrollY": 300,
          "scrollX": true
        });
      });
    </script>
  <?php
}
  ?>