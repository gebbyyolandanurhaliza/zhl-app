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
  $(document).ready(function() {
    var rate = document.getElementById('rate_currency').value;
    document.getElementById('jr_rate1').value = rate;
    document.getElementById('jr_rate2').value = rate;
    document.getElementById('jr_rate3').value = rate;
    document.getElementById('jr_rate4').value = rate;
    document.getElementById('jr_rate5').value = rate;
    document.getElementById('jr_rate6').value = rate;

  });

  function get_currency() {
    var currency_id = document.getElementById('currency').value;
    var res = currency_id.split("|");
    document.getElementById('currency_val').value = res[0];
    document.getElementById('curid').value = res[2];
    document.getElementById('rate_currency').value = res[0];
    document.getElementById('rate_sgd1').value = res[1];
    document.getElementById('jr_rate1').value = res[0];
    document.getElementById('jr_rate2').value = res[0];
    document.getElementById('jr_rate3').value = res[0];
    document.getElementById('jr_rate4').value = res[0];
    document.getElementById('jr_rate5').value = res[0];
    document.getElementById('jr_rate6').value = res[0];
    hitung_total();
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
    var curid = document.getElementById('currency').value;
    var nocao = document.getElementById('no_coa5');
    var belah = po.split("|");
    // nocao[6].value = belah[1];
    // alert(belah[0]);
    document.getElementById('idsup').value = belah[0];
    $.ajax({
      url: "<?php echo base_url(); ?>PO_journal/tampilpo/" + belah[0] + "/" + curid + "",
      success: function(response) {
        $('#detailpo').html(response);
      },
      dataType: "html"
    });
    nocao.value = belah[1];
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
    var tgl3 = document.getElementById('tgl_invoice');
    var str = document.getElementById('tgl_tempo').value;
    //ganti tanggal
    var tanggal = str.split("/");
    var tgl = tanggal[0];
    var bln = tanggal[1];
    var thn = tanggal[2];
    var tt = bln + "/" + tgl + "/" + thn;
    var date = new Date(tt);
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + Number(tgl2));
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = dd + '/' + mm + '/' + y;
    tgl3.value = someFormattedDate;
  }

  function debit() {
    var qty = document.getElementsByClassName('txtqty');
    var harga = document.getElementsByClassName('txtprice');

    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }

    var amount = document.getElementsByClassName('txtamount');
    var price = document.getElementsByClassName('txtprice');
    var quantity = document.getElementsByClassName('txtqty');
    var txtgrand = document.getElementsByClassName('txtgrand');
    var rate = document.getElementById('rate_currency');
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var nota_debet = document.getElementById('nota_debet').value;

    for (var i = 0; i < price.length; i++) {
      amount[i].value = price[i].value * quantity[i].value;
      txtgrand[i].value = rate.value * amount[i].value;
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
    $("#destinationtable .txtrate").each(function() {
      if (!isNaN(this.value) && this.value.length != 0) {
        rater += parseFloat(this.value);
      }

    });

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

  function hitung_total() {
    var qty = document.getElementsByClassName('txtqty');
    var harga = document.getElementsByClassName('txtprice');
    var total = document.getElementsByClassName('jur_total');
    var total1 = document.getElementById('jur_total1');
    for (var i = 0; i < qty.length; i++) {
      total1.value = total1.value.replace(",", "");
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    var rate_sgd1 = document.getElementById('rate_sgd1');
    var total5 = document.getElementById('jur_total5');
    var total2 = document.getElementById('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var jur_credit = document.getElementsByClassName('jur_credit');
    var dk = document.getElementsByClassName('dk');
    var rate = document.getElementById('rate_currency');
    var total_deb = document.getElementById('total_debet');
    var total_credit = document.getElementById('total_credit');
    var sum_dbt = 0;
    var sum_crt = 0;
    var total_AP = 0;
    var sum = 0;
    var sumx = 0;
    var sumz = 0;
    var amount = document.getElementsByClassName('txtamount');
    var price = document.getElementsByClassName('txtprice');
    var txtper1000 = document.getElementsByClassName('txtper1000');
    var quantity = document.getElementsByClassName('txtqty');
    var txtSGD = document.getElementsByClassName('txtgrand');
    var cur = document.getElementById('rate_currency').value;

    for (var i = 0; i < price.length; i++) {
      var utkAmount = quantity[i].value / txtper1000[i].value * price[i].value;
      amount[i].value = utkAmount.toFixed(2);
      var ttlSGD = cur * amount[i].value;
      txtSGD[i].value = ttlSGD.toFixed(2);
    }

    $("#destinationtable .txtamount").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });

    $("#destinationtable  .gst_value").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumx += parseFloat(this.value);
      }
    });

    $("#destinationtable  .txtsummary").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumz += parseFloat(this.value);
      }
    });

    document.getElementById('nota_debet').value = sum;

    //var gst_type = document.getElementsByClassName('txtGST');

    var total_dp = sumz * 0.07;
    total[2].value = total_dp.toFixed(2);

    for (var i = 0; i < total.length; i++) {

      total1.value = sum.toFixed(2);
      if (i < 5) {
        if (dk[i].value === "D") {
          total_AP += Number(total[i].value);
        } else {
          total_AP -= Number(total[i].value);
        }
        total5.value = total_AP.toFixed(2);

      }
      if (dk[i].value === "D" && i < 6) {
        var data = total[i].value * rate.value;
        jur_det[i].value = data.toFixed(2);
        sum_dbt += Number(data);
        jur_credit[i].value = 0;
      } else {
        var data = total[i].value * rate.value;
        jur_credit[i].value = data.toFixed(2);
        sum_crt += Number(data);
        jur_det[i].value = 0;
      }
    }
    total_credit.value = sum_crt.toFixed(2);
    total_deb.value = sum_dbt.toFixed(2);
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

  function cekForm() {
    var txtqty = document.getElementsByClassName("txtqty");
    var txtqty_pi = document.getElementsByClassName("txtqty_pi");
    for (var i = 0; i < txtqty.length; i++) {
      var total = txtqty[i].value - txtqty_pi[i].value;
      if (total < 0) {
        document.getElementById('pesan_error').style.display = "block";
        setTimeout(function() {
          $('#pesan_error').fadeOut(500);
        }, 5000);
        return (false);
      } else {
        document.getElementById("myForm").submit();
        return (true);
      }
    }

  }

  //tambahan 02-05-2016
  function cek_gst2() {
    var qty = document.getElementsByClassName('txtqty');
    var harga = document.getElementsByClassName('txtprice');

    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    hitung_total();

    var amount = document.getElementsByClassName('txtamount');
    var nama_gst = document.getElementsByClassName('txtGST');
    var value_gst = document.getElementsByClassName('gst_value');
    var rate_sgd = document.getElementById('rate_sgd1');

    for (var i = 0; i < nama_gst.length; i++) {
      if (nama_gst[i].value === 'GST') {
        var total = qty[i].value * harga[i].value * rate_sgd.value * 0.07;
        value_gst[i].value = total.toFixed(2);
      } else {
        value_gst[i].value = 0;
      }
    }

    hitung_total();
  }

  function cek_nofak() {
    var refno = document.getElementById('nofaktur').value;
    $.ajax({
      url: "<?php echo base_url(); ?>payable_recognition/cek_tabel_ap?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
  }

  function cek_gst() {
    var qty = document.getElementsByClassName('txtqty');
    var harga = document.getElementsByClassName('txtprice');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    hitung_total();
    var gst_type = document.getElementsByClassName('txtGST');
    var txtsummary = document.getElementsByClassName('txtsummary');
    var sgd_txt = document.getElementsByClassName('txtSGD');
    var gst_value = document.getElementsByClassName('gst_value');
    var rate_sgd = document.getElementById('rate_sgd');
    var txtper1000 = document.getElementsByClassName('txtper1000');
    for (var i = 0; i < gst_type.length; i++) {
      if (sgd_txt.value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {

        if (gst_type[i].value === 'GST') {
          var total = qty[i].value / txtper1000[i].value * harga[i].value * rate_sgd.value * 0.07;
          gst_value[i].value = total.toFixed(2);
          txtsummary[i].value = qty[i].value / txtper1000[i].value * harga[i].value * rate_sgd.value;
        } else {
          gst_value[i].value = '0';
          txtsummary[i].value = '0';
        }
      }
    }
    hitung_total();
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $l) {
    $nojurnalinvoice = $l->nofaktur;
    $kode_sup = $l->kode_sup . "|" . $l->coa;
    $supplier_id = $l->kode_sup;
    $namavendor = $l->namavendor;
    $currency_id = $l->rate . "|" . $l->rate_sgd . "|" . $l->currency;
    $Currency_symbol = $l->currency;
    $rate = $l->rate;
    $rate_sgd = $l->rate_sgd;
    $sdate = new DateTime($l->tanggal);
    $date_of_journal = date_format($sdate, 'd/m/Y');
    $idate = new DateTime($l->tanggal_invoice);
    $date_invoice = date_format($idate, 'd/m/Y');
    $tdate = new DateTime($l->tanggal_tempo);
    $tgl_tempo = date_format($tdate, 'd/m/Y');
    $term = $l->term;
    $nota_debet = $l->nota_debet;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
    $keterangan = $l->Keterangan;
    $dt = 1;
  }
} else {
  $nojurnalinvoice = '';
  $kode_sup = '';
  $currency_id = '';
  $Currency_symbol = '';
  $supplier_id = '';
  $rate = '0';
  $rate_sgd = 0;
  $date_of_journal = date('d/m/Y');
  $date_invoice = date('d/m/Y');
  $tgl_tempo = date('d/m/Y');
  $term = '0';
  $nota_debet = '0';
  $readonly = '';
  $disable = 'disable';
  $keterangan = '';
  $submit_value = 'Save';
  $dt = 0;
}
?>

<div class="page-content">
  <div class="container">


    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>PO_journal/save_jurnal_invoice" method="post" id="myForm" name="from">
        <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date'); ?>" />
        <!-- MODAL -->
        <div class="modal fade" id="dp" tabindex="-1" role="basic" aria-hidden="true">
          <div class="modal-dialog modal-full">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Down Payment</h4>
              </div>
              <div class="modal-body">
                <table id="uangmuka">
                  <thead>
                    <th>No PO</th>
                    <th>Uang Muka</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- MODAL -->
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Purchase Invoice Jurnal</span>
              </div>
              <?php if ($this->input->get("id") <> '') { ?>
                <div class="form-group">
                  <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>PO_journal/addnew"><i class="fa fa-plus"></i> Create New</a>
                </div>
              <?php } ?>
            </div>
            <div class="error_id"></div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Doc. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="nofaktur" name="nofaktur" onchange="cek_nofak()" onKeydown="return validasi_enter(event)" value="<?php echo $nojurnalinvoice; ?>" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="sup" name="sup" onKeydown="return validasi_enter(event)" value="<?php echo $supplier_id; ?>" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" name="periode" value="<?php echo $this->session->userdata('periode_1'); ?>" id="s_period" />
                        <input type="hidden" name="until" value="<?php echo $this->session->userdata('closing_date'); ?>" id="s_until" />
                        <input type="hidden" name="until" id="txt_save" />
                        <label class="CurID"></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          $style_cur = 'class="select2me form-control" id="currency" onchange="get_cur()" name="cur" required';
                          echo form_dropdown('cur', $cur, $Currency_symbol, $style_cur);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Vendor</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" onKeydown="return validasi_enter(event)" onchange="get_vendor()" name="supplier" required';
                        echo form_dropdown('supplier', $supp, $kode_sup, $style_kategori);
                        ?>
                        <input type="hidden" onKeydown="return validasi_enter(event)" id="idsup" value="<?php echo $kode_sup; ?>" name="idsup" class="form-control" required />
                      </div>
                    </div>


                  </div>
                  <div class="col-md-6">
                    <div id="daftar_kurs">
                      <div class="form-group">
                        <label class="control-label col-md-3">Rate</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_currency" onKeydown="return validasi_enter(event)" name="rate_header" class="form-control" value="<?php echo $rate; ?>" onkeypress="return isNumber(event)" readonly required />
                          <input type="hidden" id="curid" onKeydown="return validasi_enter(event)" name="curid" class="form-control" value="<?php echo $Currency_symbol; ?>" onkeypress="return isNumber(event)" readonly required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Rate SGD</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_sgd" onKeydown="return validasi_enter(event)" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" readonly required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date of Journal</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_tempo" name="tgl_jurnal" class="form-control date date-picker" onchange="gantirate()" value="<?php echo $date_of_journal; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date date-picker" value="<?php echo $date_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Term</label>
                      <div class="col-md-3">
                        <input type="text" id="term" name="term" value="<?php echo $term; ?>" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required />
                        <input type="hidden" id="symbol_currency" name="symbol_currency" value="<?php echo $Currency_symbol; ?>" class="form-control" />
                        <input type="hidden" id="currency_val" name="currency_val" value="<?php echo $rate; ?>" class="form-control currency_val" />

                      </div>
                      <!--<label class="control-label"> Days</label>-->
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Due Date</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_invoice" name="tgl_tempo" class="form-control" value="<?php echo $tgl_tempo; ?>" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-2 kanan">
                  <input readonly onKeydown="return validasi_enter(event)" type="hidden" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                  <input readonly onKeydown="validasi_enter(event)" type="hidden" id="nota_debit" name="nota_debit" value="" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <div id="demo" style="display: none"></div>
                <hr />

                <div class="note note-warning note-bordered" id="pesan_error" style="display: none;">
                  <p>
                    Quantity on a "Purchase Invoice" does not match the quantity that will in the journal. Please note the previous quantity.
                  </p>
                </div>
                <table class="table table-bordered" id="destinationtable">
                  <thead>
                    <tr>
                      <th width="3%">
                        <a data-toggle="modal" class="btn btn-primary glyphicon glyphicon-search" href="#coa"></a>
                      </th>
                      <th width="7%">
                        ARGL ACCOUNT
                      </th>
                      <th width="10%">
                        Items ID
                      </th>
                      <th width="10%">
                        Items Name
                      </th>
                      <th width="10%">
                        Qty
                      </th>
                      <th width="5%">
                        Qty per Unitprice
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
                        USD Equivalent
                      </th>
                      <th width="10%">
                        GST Type
                      </th>
                      <th width="10%">
                        GST Value
                      </th>
                    </tr>
                  </thead>

                  <tr style="background: #cccccc; font-weight: bold">
                    <td colspan="12"></td>
                  </tr>
                  <?php
                  if (!empty($get_data_item)) {
                  ?>
                    <tbody>
                      <?php
                      foreach ($get_data_item as $r) {
                        if ($r->per1000 == '1') {
                          $per1000 = "1000";
                        } else {
                          $per1000 = "1";
                        }
                      ?>
                        <tr>
                          <td><input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $r->qty_pi; ?>" /></td>
                          <td><input type="text" name="coa_argl[]" class="txt coa_argl" value="200104" required /></td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" name="txtidem[]" readonly class="txt" value="<?php echo $r->ItemID; ?>" required /><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $r->npbbitem; ?>" required /></td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" name="txtinem[]" readonly class="txt" value="<?php echo $r->ItemName; ?>" /></td>
                          <td>
                            <input type="text" onKeydown="return validasi_enter(event)" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo number_format($r->Qty, 2, '.', ','); ?>" />
                            <input type="hidden" name="txtqty_awal[]" class="txt number txtqty_awal" value="<?php echo $r->Qty; ?>" />
                            <input type="hidden" name="txtsummary[]" class="txt number txtsummary" value="" />
                          </td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" name="txtper1000[]" class="txt txtper1000" value="<?php echo $per1000; ?>" /></td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" name="txtunit[]" class="txt" value="<?php echo $r->unit; ?>" /></td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo number_format($r->price, 2, '.', ','); ?>" /></td>
                          <td><input type="text" onKeydown="return validasi_enter(event)" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo number_format($r->amount, 2, '.', ','); ?>" /></td>

                          <td><input type="hidden" onKeydown="return validasi_enter(event)" name="txtrate[]" readonly class="txt number txtrate" value="<?php echo $r->rate; ?>" />
                            <input type="text" onKeydown="return validasi_enter(event)" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo number_format($r->usdequivalent, 2, '.', ','); ?>" />
                          </td>
                          <td>
                            <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                              <option value="">Select</option>
                              <option value="GST" <?php
                                                  if ($r->gst_type == 'GST') {
                                                    echo "selected";
                                                  }
                                                  ?>>GST</option>
                              <option value="ZER" <?php
                                                  if ($r->gst_type == 'ZER') {
                                                    echo "selected";
                                                  }
                                                  ?>>Zero Rate</option>
                              <option value="EXP" <?php
                                                  if ($r->gst_type == 'EXP') {
                                                    echo "selected";
                                                  }
                                                  ?>>Exampt</option>
                              <option value="OUT" <?php
                                                  if ($r->gst_type == 'OUT') {
                                                    echo "selected";
                                                  }
                                                  ?>>Out of Scope</option>
                            </select>
                          </td>
                          <td><input type="text" name="gst_value[]" class="txt gst_value number" value="<?php echo number_format($r->gst_value, 2, ".", ","); ?>" required /></td>
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
                    <th></th>
                    <th>Account Number</th>
                    <th>D/C</th>
                    <th>Account Name</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Rate</th>
                    <th>Debt</th>
                    <th>Credit</th>
                  </thead>
                  <tbody>
                    <!-- form untuk edit dimulai -->
                    <?php
                    $todet = 0;
                    $tocet = 0;
                    if (!empty($get_data_footer)) {
                      foreach ($get_data_footer as $f) {
                        $Uraian = $f->Uraian;
                        $Total = number_format($f->Total, 2, '.', '');
                        $Rate = number_format($f->Rate, 6, '.', '');
                        $Debet = number_format($f->Debet, 2, '.', '');
                        $Kredit = number_format($f->Kredit, 2, '.', '');
                        $nourut = $f->NoUrut;
                        $str = $f->NoCOA;
                        $NoCOA = explode("|", $str);
                      }
                    }

                    if (!empty($get_data_jurnal1)) {
                      foreach ($get_data_jurnal1 as $z) {
                        $DetailID1 = $z->DetailID;
                        $NoCOA1 = "200104";
                        if ($z->chk == 'D') {
                          $chk1x = 'value="D" selected';
                          $chk1 = 'value="C" ';
                          $Debit1 = number_format($z->Total * $z->Rate, 3, '.', '');
                          $credit1 = 0;
                          $todet = $todet + ($z->Total * $z->Rate);
                        } else {
                          $chk1 = 'value="C" selected';
                          $chk1x = 'value="D" ';
                          $credit1 = number_format($z->Total * $z->Rate, 3, '.', '');
                          $tocet = $tocet + ($z->Total * $z->Rate);
                          $Debit1 = 0;
                        }
                        $desc1 = "Customer";
                        $Total1 = number_format($z->Total, 3, '.', '');
                      }
                    } else {
                      $DetailID1 = "0";
                      $NoCOA1 = "200104";
                      $chk1 = 'value="C" ';
                      $chk1x = 'value="D" selected';
                      $credit1 = "0";
                      $Debit1 = "0";
                      $desc1 = "";
                      $Total1 = "0";
                    }

                    //diskon
                    if (!empty($get_data_jurnal2)) {
                      foreach ($get_data_jurnal2 as $x) {
                        $DetailID2 = $x->DetailID;
                        $NoCOA2 = $x->NoCOA;
                        if ($x->chk == 'D') {
                          $chk2x = 'value="D" selected';
                          $chk2 = 'value="C"';
                          $Debit2 = number_format($x->Total * $x->Rate, 3, '.', '');
                          $credit2 = "0";
                          $todet = $todet + ($x->Total * $x->Rate);
                        } else {
                          $chk2 = 'value="C" selected';
                          $chk2x = 'value="D"';
                          $credit2 = number_format($x->Total * $x->Rate, 3, '.', '');
                          $tocet = $tocet + ($x->Total * $x->Rate);
                          $Debit2 = "0";
                        }
                        $desc2 = $x->Uraian;
                        $Total2 = number_format($x->Total, 3, '.', '');
                      }
                    } else {
                      foreach ($_Discount as $value) {
                        $NoCOA2 = $value->NoCOA;
                      }
                      $DetailID2 = "0";

                      $chk2 = 'value="C" selected';
                      $chk2x = 'value="D"';
                      $credit2 = "0";
                      $Debit2 = "0";
                      $desc2 = "";
                      $Total2 = "0";
                    }

                    //pajak
                    if (!empty($get_data_jurnal3)) {
                      foreach ($get_data_jurnal3 as $w) {
                        $DetailID3 = $w->DetailID;
                        $NoCOA3 = $w->NoCOA;
                        if ($w->chk == 'D') {
                          $chk3x = 'value="D" selected';
                          $chk3 = 'value="C"';
                          $Debit3 = number_format($w->Total * $w->Rate, 3, '.', '');
                          $todet = $todet + ($w->Total * $w->Rate);
                          $credit3 = "0";
                        } else {
                          $chk3 = 'value="C" selected';
                          $chk3x = 'value="D"';
                          $credit3 = number_format($w->Total * $w->Rate, 3, '.', '');
                          $tocet = $tocet + ($w->Total * $w->Rate);
                          $Debit3 = "0";
                        }
                        $desc3 = $w->Uraian;
                        $Total3 = $w->Total;
                      }
                    } else {
                      foreach ($_Tax as $value) {
                        $NoCOA3 = $value->NoCOA;
                      }
                      $DetailID3 = "0";
                      $chk3 = 'value="C"';
                      $chk3x = 'value="D"  selected';
                      $credit3 = "0";
                      $Debit3 = "0";
                      $desc3 = "";
                      $Total3 = "0";
                    }

                    //Additional Cost
                    if (!empty($get_data_jurnal4)) {
                      foreach ($get_data_jurnal4 as $u) {
                        $DetailID4 = $u->DetailID;
                        $NoCOA4 = $u->NoCOA;
                        if ($u->chk == 'D') {
                          $chk4x = 'value="D" selected';
                          $chk4 = 'value="C" ';
                          $Debit4 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $todet = $todet + ($u->Total * $u->Rate);
                          $credit4 = "0";
                        } else {
                          $chk4 = 'value="C" selected';
                          $chk4x = 'value="D"';
                          $credit4 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $tocet = $tocet + ($u->Total * $u->Rate);
                          $Debit4 = "0";
                        }
                        $desc4 = $u->Uraian;
                        $Total4 = $u->Total;
                      }
                    } else {
                      $DetailID4 = "0";
                      $NoCOA4 = "";
                      $chk4 = 'value="C" selected';
                      $chk4x = 'value="D"  ';
                      $credit4 = "0";
                      $Debit4 = "0";
                      $desc4 = "";
                      $Total4 = "0";
                    }

                    //Down Payment
                    if (!empty($get_data_jurnal5)) {
                      foreach ($get_data_jurnal5 as $u) {
                        $DetailID5 = $u->DetailID;
                        $NoCOA5 = $u->NoCOA;
                        if ($u->chk == 'D') {
                          $chk5x = 'value="D" selected';
                          $chk5 = 'value="C" ';
                          $Debit5 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $todet = $todet + ($u->Total * $u->Rate);
                          $credit5 = "0";
                        } else {
                          $chk5 = 'value="C" selected';
                          $chk5x = 'value="D"';
                          $credit5 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $tocet = $tocet + ($u->Total * $u->Rate);
                          $Debit5 = "0";
                        }
                        $desc5 = $u->Uraian;
                        $Total5 = $u->Total;
                      }
                    } else {
                      $DetailID5 = "0";
                      $NoCOA5 = "";
                      $chk5 = 'value="C" ';
                      $chk5x = 'value="D"  selected';
                      $credit5 = "0";
                      $Debit5 = "0";
                      $desc5 = "";
                      $Total5 = "0";
                    }

                    //Account Receivable
                    if (!empty($get_data_jurnal6)) {
                      foreach ($get_data_jurnal6 as $u) {
                        $DetailID6 = $u->DetailID;
                        $NoCOA6 = $u->NoCOA;
                        if ($u->chk == 'D') {
                          $chk6x = 'value="D" selected';
                          $chk6 = 'value="C" ';
                          $Dbtt6 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $Debit6 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $todet = $todet + ($u->Total * $u->Rate);
                          $credit6 = "0";
                        } else {
                          $chk6 = 'value="C" selected';
                          $chk6x = 'value="D" ';
                          $cdt6 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $credit6 = number_format($u->Total * $u->Rate, 3, '.', '');
                          $tocet = $tocet + ($u->Total * $u->Rate);
                          $Debit6 = "0";
                        }
                        $desc6 = $u->Uraian;
                        $Total6 = number_format($u->Total, 3, '.', '');
                      }
                    } else {
                      $DetailID6 = "0";
                      $NoCOA6 = "";
                      $chk6x = 'value="D" ';
                      $chk6 = 'value="C" selected';
                      $credit6 = "0";
                      $Debit6 = "0";
                      $desc6 = "";
                      $Total6 = "0";
                    }
                    ?>
                    <!-- 1. baris Sales -->
                    <tr id="ds1">
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[]" value="<?php echo "$DetailID1"; ?>" />
                        <input type="text" name="no_coa[]" value="<?php echo "$NoCOA1"; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo "$chk1x"; ?>>D</option>
                          <option <?php echo "$chk1"; ?>>C</option>
                        </select>
                      <td>
                        <input type="hidden" name="NoUrut[]" value="1" class="txt">
                        <input type="text" name="JenisJurnal[]" value="Purchase" class="txt">
                      </td>
                      <td><input type="text" name="desc[0]" value="<?php echo "$desc1"; ?>" class="txt"></td>
                      <td class="total">
                        <input type="text" id="jur_total1" name="total_jr[0]" value="<?php echo number_format($Total1, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[0]" id="jr_rate1" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[0]" value="<?php echo number_format($Debit1, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[0]" value="<?php echo number_format($credit1, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <!-- 1. baris Sales end -->

                    <!-- 2. baris Discount -->
                    <tr id="ds2">
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[1]" value="<?php echo "$DetailID2"; ?>" />
                        <input type="text" name="no_coa[1]" value="<?php echo "$NoCOA2"; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[1]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo "$chk2x"; ?>>D</option>
                          <option <?php echo "$chk2"; ?>>C</option>
                        </select>
                      <td>
                        <input type="hidden" name="NoUrut[1]" value="2" class="txt">
                        <input type="text" name="JenisJurnal[1]" value="Discount" class="txt">
                      </td>
                      <td><input type="text" name="desc[1]" value="<?php echo "$desc2"; ?>" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total_jr[1]" value="<?php echo number_format($Total2, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[1]" id="jr_rate2" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[1]" value="<?php echo number_format($Debit2, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[1]" value="<?php echo number_format($credit2, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <!-- 2. baris Discount End-->

                    <!-- 3. Baris pajak Start -->
                    <tr id="ds3">
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[2]" value="<?php echo "$DetailID3"; ?>" />
                        <input type="text" name="no_coa[2]" value="<?php echo "$NoCOA3"; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[2]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo "$chk3x"; ?>>D</option>
                          <option <?php echo "$chk3"; ?>>C</option>
                        </select>
                      <td>
                        <input type="hidden" name="NoUrut[2]" value="3" class="txt">
                        <input type="text" name="JenisJurnal[2]" value="Tax" class="txt">
                      </td>
                      <td><input type="text" name="desc[2]" value="<?php echo "$desc3"; ?>" class="txt"></td>
                      <td class="total">
                        <input type="text" name="total_jr[2]" value="<?php echo number_format($Total3, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[2]" id="jr_rate3" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[2]" value="<?php echo number_format($Debit3, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[2]" value="<?php echo number_format($credit3, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <!-- 3. Baris pajak End -->

                    <!-- 4. Additional Cost Start -->
                    <tr id="ds4">
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[3]" value="<?php echo "$DetailID4"; ?>" />
                        <input type="text" name="no_coa[3]" value="<?php echo "$NoCOA4"; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo "$chk4x"; ?>>D</option>
                          <option <?php echo "$chk4"; ?>>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[3]" value="Additional costs" class="txt">
                        <input type="hidden" name="NoUrut[3]" value="4" class="txt">
                      </td>
                      <td><input type="text" name="desc[3]" value="<?php echo "$desc4"; ?>" class=" txt"></td>
                      <td class="total">
                        <input type="text" name="total_jr[3]" value="<?php echo number_format($Total4, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[3]" id="jr_rate4" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[3]" value="<?php echo number_format($Debit4, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[3]" value="<?php echo number_format($credit4, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <!-- 4. Additional Cost End -->

                    <!-- 5. Down Payment Start -->
                    <tr id="ds5">
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[4]" value="<?php echo $DetailID5; ?>" />
                        <input type="text" name="no_coa[4]" value="<?php echo $NoCOA5; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[4]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo $chk5x; ?>>D</option>
                          <option <?php echo $chk5; ?>>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[4]" value="Down Payment" class="txt">
                        <input type="hidden" name="NoUrut[4]" value="5" class="txt">
                      </td>
                      <td><input type="text" name="desc[4]" value="<?php echo $desc5; ?>" class=" txt"></td>
                      <td class="total">
                        <input type="text" id="total_jr4" name="total_jr[4]" value="<?php echo number_format($Total5, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[4]" id="jr_rate5" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[4]" value="<?php echo number_format($Debit5, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[4]" value="<?php echo number_format($credit5, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>

                    <!-- 5. Down Payment End -->

                    <!-- 6. Account Receivable Start -->
                    <tr>
                      <td></td>
                      <td>
                        <input type="hidden" name="DetailID[5]" value="<?php echo $DetailID6; ?>" />
                        <input type="text" name="no_coa[5]" id="no_coa5" value="<?php echo $NoCOA6; ?>" class="no_coa txt">
                      </td>
                      <td>
                        <select name="dk[5]" onchange="hitung_total()" class="txt dk">
                          <option <?php echo $chk6x; ?>>D</option>
                          <option <?php echo $chk6; ?>>C</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="JenisJurnal[5]" value="Account Payable" class="txt">
                        <input type="hidden" name="NoUrut[5]" value="6" class="txt">
                      </td>
                      <td><input type="text" name="desc[5]" value="<?php echo $desc6; ?>" class=" txt"></td>
                      <td class="total">
                        <input type="text" name="total_jr[5]" id="jur_total5" value="<?php echo number_format($Total6, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td><input type="text" name="rate_jr[5]" id="jr_rate6" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="debt_jr[5]" value="<?php echo number_format($Debit6, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                      <td><input type="text" name="credit_jr[5]" value="<?php echo number_format($credit6, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                    </tr>
                    <!-- 6. Account Receivable End -->
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="7"><label class="font-red bold">Remark</label>&nbsp;<label class="bold kanan">Grand Total</label></td>
                      <td><input readonly type="text" onKeydown="return validasi_enter(event)" id="total_debet" name="total_debet" value="<?php echo number_format($todet, 2, ".", ","); ?>" class="txt number  bold" onkeypress="return isNumber(event)" required /></td>
                      <td><input readonly type="text" onKeydown="return validasi_enter(event)" id="total_credit" name="total_credit" value="<?php echo number_format($tocet, 2, ".", ","); ?>" class="txt number bold" onkeypress="return isNumber(event)" required /></td>
                    </tr>
                    <tr>
                      <td colspan="9">
                        <textarea name="remark" class="form-control"><?php echo $keterangan; ?></textarea>
                      </td>

                    </tr>
                  </tfoot>
                </table>

                <!--<a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-download"></i> Input</a>-->
                <button type="submit" name="sbt" id="btn_save" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
                <a class="btn btn-warning" href="<?php echo base_url(); ?>PO_journal"><i class="fa fa-warning"></i> Cancel</a>
                <?php if ($this->input->get('id') <> '') { ?>
                  <a type="reset" class="btn btn-primary  kanan" href="<?php echo base_url(); ?>PO_journal/print_report?id=<?php echo $this->input->get('id'); ?>"><i class="fa fa-print"></i> Print</a>
                  <a class="btn btn-danger  kanan" href="<?php echo base_url(); ?>PO_journal/delete_all?id=<?php echo $this->input->get('id'); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
                <?php } ?>
              </div>
            </div>

            <hr />
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
            $(this).css("color", "#000");
            // remove from second table :
            var tr = $("#dest" + theid);
            tr.css("color", "#FF0000");
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
          $(this).css("color", "#FF0000");
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
        // var sum = grand_total();
        // var total = document.getElementsByClassName('jur_total');
        // total[0].value = sum;

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
          <h4 class="modal-title">List of Items</h4>
        </div>
        <div class="modal-body">
          <section class="">
            <div class="contain">
              <table class="table table-bordered" id="tabel_coa" width="1350%">
                <thead class="header">
                  <th style="display:none"></th>
                  <th style="width:20%">PO <div>PO</div>
                  </th>
                  <th style="width:10%">NoCOA <div>NoCOA</div>
                  </th>
                  <th style="width:20%">Items <div>Items</div>
                  </th>
                  <th style="width:25%">Items Name <div>Items Name</div>
                  </th>
                  <th>Qty <div>Qty</div>
                  </th>
                  <th style="width:5%">Qty per Unit<div>Qty per Unit</div>
                  </th>
                  <th style="display:none">Unit</th>
                  <th style="display:none">Price</th>
                  <th style="width:10%">Amount <div>Amount</div>
                  </th>
                  <th style="display:none">Usd Equivalent</th>
                  <th style="display:none">GST Type</th>
                  <th style="display:none">GST Value</th>
                  <th style="width:10%">Down Payment <div>Down Payment</div>
                  </th>

                </thead>
                <tbody width="100%">
                  <?php
                  if (!empty($tampilpo)) {
                    $no = 1;
                    foreach ($tampilpo as $s) {
                      $qtypi = $s->qtywhs - $s->qty_pi;
                      if ($qtypi > 0) {
                  ?>
                        <tr id="sour<?php echo $no++; ?>">
                          <td style="display:none"></td>
                          <td><input type="text" name="npbbni[]" class="txt" value="<?php echo $s->mainpo; ?>" required /></td>
                          <td><input type="text" name="coa_argl[]" class="txt coa_argl" value="200104" required /></td>
                          <td><input type="text" name="txtidem[]" readonly class="txt" value="<?php echo $s->itemid; ?>" required /><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $s->mainpo; ?>" required /></td>
                          <td><input type="text" name="txtinem[]" readonly class="txt" value="<?php echo $s->itemname; ?>" /></td>
                          <td>
                            <input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $s->qtywhs - $s->qty_pi; ?>" />
                            <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $s->qty_pi; ?>" />
                            <input type="hidden" name="txtxxx[]" class="txt number txtsummary" />
                          </td>
                          <td>
                            <input type="text" name="txtper1000[]" class="txt number txtper1000" value="<?php echo $per1000; ?>" />
                          </td>
                          <td style="display:none"><input type="text" name="txtunit[]" readonly class="txt" value="<?php echo $s->uomname; ?>" /></td>
                          <td style="display:none"><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo $s->unitprice; ?>" /></td>
                          <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo ($s->qtywhs - $s->qty_pi) * $s->unitprice; ?>" /></td>
                          <td style="display:none"><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo (($s->qtywhs - $s->qty_pi) * $s->unitprice) * $s->rate; ?>" /><input type="hidden" name="txtnpbb[]" readonly class="txt" value="<?php echo $s->npbbno; ?>" /></td>
                          <td style="display:none">
                            <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                              <option value="">Select</option>
                              <option value="GST">GST</option>
                              <option value="ZER">Zero Rate</option>
                              <option value="EXP">Exampt</option>
                              <option value="OUT">Out of Scope</option>
                            </select>
                          </td>
                          <td style="display:none">
                            <input type="text" name="gst_value[]" class="txt gst_value" value="0" required />

                          </td>
                          <td>
                            <input type="text" name="uang_muka[]" class="txt uang_muka" value="<?php echo $s->uang_muka; ?>" required />
                          </td>
                        </tr>
                  <?php
                      }
                    }
                  }
                  ?>

                </tbody>
              </table>

            </div>
          </section>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn red" data-dismiss="modal">Choose</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


<?php
}
?>