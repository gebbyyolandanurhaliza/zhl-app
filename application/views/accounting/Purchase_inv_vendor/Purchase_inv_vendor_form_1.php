<?php
//update date : 29 Nov 16 3.21 AM
//Update By : Ozzy
?>
<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<script>
  $(function() {
    $('.no_coa').autocomplete({
      serviceUrl: "<?php echo site_url('Purchase_inv_vendor/get_coa'); ?>"
    });
  });
</script>
<script>
  // function standard
  function hitungSelisihHari() {
    tgl1 = document.getElementById('tgl_tempo').value;
    tgl2 = document.getElementById('tgl_invoice').value;
    // varibel miliday sebagai pembagi untuk menghasilkan hari
    var miliday = 60 * 24 * 60 * 1000;
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

  function sum() {
    var sum = 0;
    $(".amount").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum;
  }
  $(document).ready(function() {
    var cur = document.getElementById('rate_currency').value;
    //document.getElementById('rate_sgd').value = cur;
    document.getElementById('jr_rate1').value = cur;
    document.getElementById('jr_rate2').value = cur;
    document.getElementById('jr_rate3').value = cur;
    document.getElementById('jr_rate4').value = cur;
    document.getElementById('jr_rate5').value = cur;
    document.getElementById('jr_rate6').value = cur;
  });

  $(document).ready(function() {
    $("#search_coa").keyup(function() {
      _this = this;
      $.each($("#tbl_coa tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });

    });
    $("#search").keyup(function() {
      _this = this;
      $.each($("#tabel_gl tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });

    });

    $("#search_dtl").keyup(function() {
      _this = this;
      $.each($("#tbl_coa_dtl tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });
  });

  function hitung_total() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var gst_value = document.getElementsByClassName('txtGSTValue');

    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
      gst_value[i].value = gst_value[i].value.replace(",", "");
    }

    var total4 = document.getElementById('total_jr4');
    total4.value = total4.value.replace(",", "");
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var jur_credit = document.getElementsByClassName('jur_credit');
    var dk = document.getElementsByClassName('dk');
    var rate = document.getElementsByClassName('jr_rate');
    var total_deb = document.getElementById('total_debet');
    var total_credit = document.getElementById('total_credit');
    var gst_type = document.getElementsByClassName('txtGST');
    var txtsummary = document.getElementsByClassName('txtsummary');
    var rate_sgd = document.getElementById('rate_sgd');
    var sum_dbt = 0;
    var sum_crt = 0;
    var total_AP = 0;
    var sum = 0;
    var sumx = 0;
    var sumz = 0;
    var sum_rate = 0;
    var sum_disc = 0;
    var amount = document.getElementsByClassName('amount');
    var price = document.getElementsByClassName('prices');
    var quantity = document.getElementsByClassName('quantity');
    var txtSGD = document.getElementsByClassName('txtSGD');
    var cur = document.getElementById('rate_currency').value;
    for (var i = 0; i < price.length; i++) {
      var utkAmount = price[i].value * quantity[i].value;
      amount[i].value = utkAmount.toFixed(2);
      var ttlSGD = cur * amount[i].value;
      txtSGD[i].value = ttlSGD.toFixed(2);
    }

    $(".amount").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    $(".txtGSTValue").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumx += parseFloat(this.value);
      }
    });

    $(".txtsummary").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumz += parseFloat(this.value);
      }
    });

    $(".txtrate").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum_rate += parseFloat(this.value);
      }
    });

    var txtDisc = document.getElementsByClassName('dis_per');
    var txtDiscDol = document.getElementsByClassName('dis_dol');
    for (var i = 0; i < price.length; i++) {
      var utkAmount = price[i].value * quantity[i].value;
      amount[i].value = utkAmount.toFixed(2);
      var disc_amount = utkAmount * txtDisc[i].value / 100;
      txtDiscDol[i].value = (utkAmount - disc_amount).toFixed(2);
      var ttlSGD = cur * amount[i].value;
      txtSGD[i].value = ttlSGD.toFixed(2);
    }

    $(".dis_dol").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum_disc += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum.toFixed(2);

    for (var i = 0; i < total.length; i++) {
      if (i < 1) {
        total[0].value = sum.toFixed(2);
      }
      if (i > 1) {
        total[1].value = (sum - sum_disc).toFixed(2);
        total[2].value = sumx.toFixed(2);
      }
      if (i < 5) {
        if (dk[i].value === "D") {
          total_AP += parseFloat(total[i].value);
        } else {
          total_AP -= parseFloat(total[i].value);
        }
        total[5].value = total_AP.toFixed(2);
      }
      if (dk[i].value === "D" && i < 6) {
        var data = total[i].value * rate[i].value;
        jur_det[i].value = data.toFixed(2);
        sum_dbt += parseFloat(data.toFixed(2));
        jur_credit[i].value = 0;
      } else {
        var data = total[i].value * rate[i].value;
        jur_credit[i].value = data.toFixed(2);
        sum_crt += parseFloat(data.toFixed(2));
        jur_det[i].value = 0;
      }
    }

    var data_ar = total[0].value * rate[0].value;
    var selisih = sum_dbt - sum_crt;

    if (selisih != 0) {
      jur_det[0].value = (data_ar - selisih).toFixed(2);
    }

    total_deb.value = (sum_dbt - selisih).toFixed(2);
    total_credit.value = sum_crt.toFixed(2);

    var cur1 = sum_rate / document.getElementsByClassName('txtrate').length;
    if (isNaN(cur1)) {
      var cur = 0;
    } else {
      var cur = cur1;
    }
    document.getElementById('rate_currency').value = cur.toFixed(6);
    document.getElementById('jr_rate1').value = cur.toFixed(6);
    document.getElementById('jr_rate2').value = cur.toFixed(6);
    document.getElementById('jr_rate3').value = cur.toFixed(6);
    document.getElementById('jr_rate4').value = cur.toFixed(6);
    document.getElementById('jr_rate5').value = cur.toFixed(6);
    document.getElementById('jr_rate6').value = cur.toFixed(6);

  }

  function get_cur_purchase() {
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    var supp = document.getElementById('supplier').value;
    var belah = supp.split("|");

    var vendor = belah[0];
    var currency = document.getElementById("currency").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Payable_recognition/ambil_currency?kurs=" + currency_id + "&bln=" + bulan + "&thn=" + tahun,
      success: function(response) {
        $("#daftar_kurs").html(response);
      },
      dataType: "html"
    });

    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_vendor/tampil_po?supplier=" + vendor + "&currency=" + currency + "",
      success: function(response) {
        $("#detail_po_id").html(response);
        $("#loading-spiner").hide();
      },
      dataType: "html"
    });
  }

  function cek_gst() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var txtDisc = document.getElementsByClassName('dis_per');
    var txtsummary = document.getElementsByClassName('txtsummary');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    // hitung_total();

    var gst_type = document.getElementsByClassName('txtGST');
    var sgd_txt = document.getElementsByClassName('txtSGD');
    var rate_sgd = document.getElementById('rate_sgd');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    for (var i = 0; i < gst_type.length; i++) {
      if (sgd_txt[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {
        if (gst_type[i].value === 'GST') {
          var utkAmount = qty[i].value * harga[i].value;
          var disc_amount = utkAmount * txtDisc[i].value / 100;
          var total = utkAmount - disc_amount;
          txtsummary[i].value = total;
          gst_value[i].value = (total * 7 / 100).toFixed(2);
        } else {
          gst_value[i].value = '0';
          txtsummary[i].value = '0';
        }
      }
    }
    hitung_total();
  }

  function isNumber(evt) {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
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
    document.getElementById('symbol_currency').value = res[2];
    document.getElementById('rate_currency').value = res[0];
    document.getElementById('rate_sgd').value = res[1];
    document.getElementById('jr_rate1').value = res[0];
    document.getElementById('jr_rate2').value = res[0];
    document.getElementById('jr_rate3').value = res[0];
    document.getElementById('jr_rate4').value = res[0];
    document.getElementById('jr_rate5').value = res[0];
    document.getElementById('jr_rate6').value = res[0];
    hitung_total();
    document.getElementById('tombol_dp').style.display = 'inline';
  }

  function cari_po() {
    //untuk menampilakan PO
    var currency = document.getElementById('currency').value;
    var supplier = document.getElementById('supplier').value;
    if (currency === '') {
      $('#error_currency').modal('show');
    } else if (supplier === '') {
      $('#error_vendor').modal('show');
    } else if (currency !== '' && supplier !== '') {
      $('#po_v').modal('show');
    }
  }

  function get_coa() {

    $("#loading-spiner").show();
    var supp = document.getElementById('supplier').value;
    var nocao = document.getElementById('no_coa5');
    var btn_update = document.getElementById('btn_update').value;
    //alert(btn_update);
    var belah = supp.split("|");

    var vendor = belah[0];
    var currency = document.getElementById("currency").value;

    //alert("Purchase_inv_vendor/tampil_po?supplier=" + vendor + "&currency=" + currency + "");
    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_vendor/tampil_po?supplier=" + vendor + "&currency=" + currency + "",
      success: function(response) {
        $("#detail_po_id").html(response);
        $("#loading-spiner").hide();
      },
      dataType: "html"
    });

    document.getElementById("supp").value = belah[0];
    document.getElementById("NoCOA").value = belah[1];
    nocao.value = belah[1];
    document.getElementById('tombol_dp').style.display = 'inline';
    document.getElementById("desc5").value = "Account Payable for Vendor ID: " + belah[0];


  }
  $(document).ready(function() {
    sum = 0;
    var txtdiscount_all = document.getElementById('discount_all');
    var txtDisc = document.getElementsByClassName('dis_per');
    $(".dis_per").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });
    var result = sum / txtDisc.length;
    if (isNaN(result)) result = 0;
    txtdiscount_all.value = result;
    txtdiscount_all.disabled = true;
  });

  function masukan_discount() {
    var txtdiscount_all = document.getElementById('discount_all');
    var txtDisc = document.getElementsByClassName('dis_per');
    for (var i = 0; i < txtDisc.length; i++) {
      txtDisc[i].value = txtdiscount_all.value;
    }
    hitung_disc();
  }

  function hitung_disc() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var cur = document.getElementById('rate_currency').value;
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    var amount = document.getElementsByClassName('amount');
    var price = document.getElementsByClassName('prices');
    var quantity = document.getElementsByClassName('quantity');
    var txtSGD = document.getElementsByClassName('txtSGD');
    var txtDisc = document.getElementsByClassName('dis_per');
    var txtDiscDol = document.getElementsByClassName('dis_dol');
    for (var i = 0; i < price.length; i++) {
      var utkAmount = price[i].value * quantity[i].value;
      amount[i].value = utkAmount;
      var disc_amount = utkAmount * txtDisc[i].value / 100;
      txtDiscDol[i].value = utkAmount - disc_amount;
      var ttlSGD = cur * amount[i].value;
      txtSGD[i].value = ttlSGD.toFixed(2);

    }

    $(".dis_dol").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });


    hitung_total();
  }

  function make_blank() {
    //document.form1.type.value = "";
    var qty = document.getElementsByClassName('quantity');
    qty.value = "";
  }

  function ambil_detail(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var num = 1;

    var AccNo = getText(document.getElementById('tbl_coa_dtl').rows[$r].cells[0]);
    var AccNm = getText(document.getElementById('tbl_coa_dtl').rows[$r].cells[1]);
    var txtIdCoa = document.getElementById('txtIdCoa').value;
    var txtNmCoa = document.getElementById('txtNmCoa').value;

    document.getElementById(txtIdCoa).value = AccNo;
    document.getElementById(txtNmCoa).value = AccNm;
    $('#coa_detail').modal('hide');
  }

  function ambilx() {
    var sum_dp = 0;
    var dp = document.getElementsByClassName('jum_dp');
    for (var i = 0; i < dp.length; i++) {
      dp[i].value = dp[i].value.replace(",", "");
    }
    $(".jum_dp").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum_dp += parseFloat(this.value);

      }

    });

    for (var i = 0; i < dp.length; i++) {
      document.getElementById('total_jr4').value = sum_dp;

    }
    // hitung_total();

  }

  function ambil(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var num = 1;
    var AccNo = getText(document.getElementById('tbl_coa').rows[$r].cells[0]);
    var AccNm = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);

    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                    <td><input type="hidden" class="txt" name="Detail_item_id" value="0" /> \n\
                        <input type="hidden" name="NoUrut[]" value="0" />\n\
                        <input type="hidden" name="txtdocno[]" value="" />\n\
                        <input type="hidden" name="txtship_id[]" class="txt txtship_id" value="0" />\n\
                        <input type="text" class="txt" name="Detail_po[]" value=""></td>\n\
                    <td><input type="hidden" class="txt" name="txtItemId[]" value="">\n\
                        <input type="text" class="txt" name="txtItemName[]" value="' + AccNm + '"></td>\n\
                    <td><input type="text" class="txt number quantity" onKeyup="hitung_total()" name="txtQty[]" value="0"></td>\n\
                    <td><input type="text" class="txt" name="txtunit[]" value="">\n\
                        <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                    <td><input type="text" class="txt number prices" name="txtunitprice[]" onKeyup="hitung_total()" value="0"></td>\n\
                    <td><input type="text" class="txt number amount" name="txtamount[]" value="0"></td>\n\
                    <td><input type="text" class="txt number txtrate " name="txtRate[]" value="' + rate + '"></td>\n\
                    <td><input type="text" class="txt number txtSGD " name="txtusd[]" value=""></td>\n\
                    <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                            <option value="">Select</option>\n\
                            <option value="GST">GST</option>\n\
                            <option value="ZER">Zero Rate</option>\n\
                            <option value="EXP">Exampt</option>\n\
                            <option value="OUT">Out of Scope</option>\n\
                        </select>\n\
                    </td>\n\
                    <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0" onKeyup="hitung_total()" /></td>\n\
                    </tr>');
    }
    $('#coa').modal('hide');
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
      $('table[id="tabel"]').append('<tr><button class="tombol" onclick="hapus_dp(this)" >Remove</button><td></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt no_coa txtCOA" value=""  /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA"></textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber"  data-a-sep="," data-a-dec="." name="txtQty[]" value="0" onkeypress="return isNumber(event);" onKeyup="hitung_total()"/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber"  onKeyup="hitung_total()"  placeholder="0" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber"  onkeypress="return isNumber(event)"   placeholder="0" required /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
                <input type="hidden" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  />\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
  }

  function tambah_jurnal() {
    var num = 1;
    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {

      $('table[id="table_jurnal"]').append('<tr><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                                            <td>\n\
                                                <input type="hidden" name="Detail_item_id[]" value="0" />\n\
                                                <input type="hidden" name="Detail_jurnal_id[]" value="0" />\n\
                                                <input type="text" name="no_coa[]" value="" class="no_coa txt">\n\
                                            </td>\n\
                                            <td>\n\
                                            <select name="dk[]" onchange="buat_nol()" class="txt dk">\n\
                                                <option value="D">D</option>\n\
                                                <option value="C">C</option>\n\
                                            </select>\n\
                                            </td>\n\
                                            <td>\n\
                                                <input type="hidden" name="NoUrut[]" value="2" class="txt">\n\
                                                <input type="text" name="JenisJurnal[]" value="" class="txt">\n\
                                            </td>\n\
                                            <td><input type="text" name="desc_jr[]" value=" " class="txt"></td>\n\
                                            <td class="total"><input type="text" name="total[]" value="0" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="rate_jr[]" value="' + rate + '" class="txt number jur_rate" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="debt_jr[]" value="0" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>\n\
                                            <td><input type="text" name="credit_jr[]" value="0" class="txt number jur_credit" onkeypress="return isNumber(event)"></td> \n\
                                           </tr>');
    }
  }


  function hapus_baris() {
    document.getElementById("tabel").deleteRow(-1);
    sum();
  }

  function ambil_tabel() {
    var supp = document.getElementById("supp").value;
    var curency = document.getElementById("currency").value;
    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_vendor/data_dp?id=" + supp + "&currency=" + curency,
      success: function(response) {

        $(".err").html(response);
        $('#loading_spinner').hide();

      },
      dataType: "html"
    });
  }

  function ubah_statusx() {
    if (document.getElementById("statusDp").checked) {
      document.getElementById("stsDP").value = "DP";
      document.getElementById("ds1").style.display = "none";
      document.getElementById("ds2").style.display = "none";
      document.getElementById("ds3").style.display = "none";
      document.getElementById("ds4").style.display = "none";
    } else {
      document.getElementById("stsDP").value = "NoDP";
      document.getElementById("ds1").style.display = "table-row";
      document.getElementById("ds2").style.display = "table-row";
      document.getElementById("ds3").style.display = "table-row";
      document.getElementById("ds4").style.display = "table-row";
    }

  }

  function hapus_dp(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }

  function hapus_semua_dp() {
    hitung_total();
    $("#destinationtable tr").remove();
    document.getElementById("destinationtable").style.display = "none";
    document.getElementById("info_deposit").style.display = "none";
    document.getElementById("garis_dp").style.display = "none";
    document.getElementById("tombol_dp").style.display = "none";
    document.getElementById("total_jr4").value = 0;
  }

  function cek_nofak() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_vendor/cek_tabel_ar?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
  }

  function get_detail_coa() {

    var nocoa = document.getElementsByClassName("txtCOA");
    var txtNmCOA = document.getElementsByClassName("txtNmCOA");
    alert(txtNmCOA);
    for (var i = 0; i < nocoa.length; i++) {
      var belah = nocoa[i].value;
      var sd = belah.split("|");
      alert(sd[0]);
    }
  }

  function cek_tr_id(xid) {
    var nocoa = xid.replace("nocoa", "");;

    document.getElementById("txtIdCoa").value = xid;
    document.getElementById("txtNmCoa").value = "namacoa" + nocoa;
    $("#coa_detail").modal();
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur = $s->nofaktur;
    $kode_sup = $s->kode_sup;
    $supplier_id = $s->kode_sup . "|" . $s->nocoa;
    $NoCOA = $s->nocoa;
    $currency_id = $s->currency_id;
    $Currency_symbol = $s->currency_id;
    $rate_sgd = $s->rate_sgd;
    $rate = $s->rate;
    $sdate = new DateTime($s->tanggal);
    $date_of_journal = date_format($sdate, 'd/m/Y');
    $idate = new DateTime($s->tanggal_invoice);
    $date_invoice = date_format($idate, 'd/m/Y');
    $xdate = new DateTime($s->tanggal_tempo);
    $tgl_tempo = date_format($xdate, 'd/m/Y');
    $term = $s->term;
    $nota_debet = $s->nota_debet;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
    if ($s->status_dp == 1) {
      $status_dp = "checked";
    } else {
      $status_dp = "";
    }
  }
} else {
  $nofaktur = '';
  $kode_sup = '';
  $currency_id = '';
  $supplier_id = '';
  $NoCOA = '';
  $Currency_symbol = '';
  $rate = '0';
  $status_dp = "";
  $date_of_journal = date('d/m/Y');
  $date_invoice = date('d/m/Y');
  $tgl_tempo = date('d/m/Y');
  $term = '0';
  $rate_sgd = '0';
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
      <form action="<?php echo base_url(); ?>Purchase_inv_vendor/save_receivable_rec" name="form1" id="form1" method="post">
        <div class="col-md-12">

          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date'); ?>" />
          <div id="error_id"></div>
          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">

              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Purchase Invoice Journal For Vendor</span>
              </div>
              <div class="form-group">
                <?php if ($this->input->get('id') <> '') { ?>
                  <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Purchase_inv_vendor/add_new"><i class="fa fa-plus"></i> Create New</a>
                <?php
                } else {
                  echo "<label class='btn kanan' style='color:red'>Closing Date: " . $this->session->userdata('closing_date') . "</label>";
                }
                ?>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Ref. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" value="<?php echo $nofaktur; ?>" class="form-control" onchange="cek_nofak()" <?php echo $readonly; ?> required />
                        <label class="CurID"></label>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Vendor</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = "class='select2me form-control' onchange='get_coa()' id='supplier' $disable";
                        echo form_dropdown('supplier', $SupplierID, $supplier_id, $style_kategori);
                        echo "<input type='hidden' name='supplier' id='supp'  class='form-control' value='$kode_sup'/>";
                        echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value='$NoCOA'/>";
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-4">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='select2me form-control' id='currency' onchange='get_cur_purchase()'";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                          echo "<input type='hidden' name='xxx' id='cursyp'  class='form-control' value='$currency_id'/>";
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Discount</label>
                      <div class="col-md-2">
                        <input type="text" name="discount" class="form-control" onkeypress="return isNumber(event)" id="discount_all" value="0" onkeyup="masukan_discount()" />
                      </div>
                      <h3>%</h3>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div id="daftar_kurs">
                      <div class="form-group">
                        <label class="control-label col-md-3">Rate</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_currency" name="rate_header" class="form-control" value="<?php echo $rate; ?>" onkeyup="validasi_enter(event)" onkeypress="return isNumber(event)" <?php echo $readonly; ?> required />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">SGD Rate</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" <?php echo $readonly; ?> required />
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
                <hr />
                <a class="btn green" onclick="cari_po()" title="Serch PO Vendor"><i class="fa fa-search"></i> Search PO Vendor</a>
                <a class="btn red" data-toggle="modal" id="co" href="#coa" title="Serch COA number"><i class="fa fa-search"></i> Search Additional COA</a>
                <a class="btn btn-primary" data-toggle="modal" href="#deposit" id="tombol_dp" style="display: none" onclick="ambil_tabel()"><i class="fa fa-money"></i> Select Deposit</a>

                <div class="col-md-2 kanan">
                  <input type="hidden" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <div id="demo" style="display: none"></div>
                <hr />

              </div>

              <div class="portlet light" id="garis_dp" style="display: none">
                <div class="portlet-title">
                  <div class="caption">
                    <span class="caption-subject theme-font">List Of deposit</span>
                  </div>
                  <div class="tools">
                    <a href="javascript:;" onclick="hapus_semua_dp()"><i class="fa fa-close"></i> Cancel Deposit</a>
                  </div>
                </div>
                <div class="note note-danger note-bordered" style="display: none" id="info_deposit">
                  <p><b>Warning!</b></p>
                  <p>
                    The table below are deposits that have been previously. Table deposit only temporary table, when the transaction has been completed to automatically deposit table will disappear by itself. Thus the deposit data will not be updated back.
                  </p>
                </div>
                <table class="table table-bordered" id="destinationtable">
                  <tr>
                    <th width="5%"></th>
                    <th width="5%" style="text-align:center">ID Deposit</th>
                    <th width="30%" style="text-align:center">Vendor Name</th>
                    <th width="30%" style="text-align:center">PO Number</th>
                    <th width="15%" style="text-align:center">Total</th>
                    <th width="15%" style="text-align:center">Amount</th>
                  </tr>
                </table>
              </div>
              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="3%">

                    </th>
                    <th width="8%">
                      PO Number
                    </th>
                    <th width="20%">
                      Items
                    </th>
                    <th width="5%">
                      Qty
                    </th>
                    <th width="5%">
                      Unit
                    </th>
                    <th width="5%">
                      Price
                    </th>
                    <th width="7%">
                      Amount
                    </th>
                    <th width="5%">
                      Discount
                    </th>
                    <th width="7%">
                      Amount After Disc
                    </th>

                    <th width="5%">
                      Rate
                    </th>
                    <th width="7%">
                      USD Equivalent
                    </th>
                    <th width="7%">
                      GST Type
                    </th>
                    <th width="8%">
                      GST Value
                    </th>

                  </tr>
                </thead>

                <tbody>
                  <tr></tr>
                  <?php
                  if (!empty($get_data_detail)) {
                    $no = 1;
                    $n = 1;
                    $m = 1;
                    foreach ($get_data_detail as $v) {
                      $amount = $v->Qty * $v->price;
                      $discount = $v->disc_per;
                      $ttl_discount = $amount * $discount / 100;
                      $total_discount = $amount - $ttl_discount;
                  ?>
                      <tr id="coa<?php echo $no++; ?>">
                        <td style="text-align: center;">
                          <input type="hidden" name="Detail_item_id[]" value="<?php echo $v->DetailID; ?>" />
                          <input type="hidden" name="NoUrut[]" value="0" />
                          <a href="<?php echo base_url(); ?>index.php/Purchase_inv_vendor/delete?id=<?php echo $v->DetailID; ?>&nofaktur=<?php echo $v->HeaderID; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                        <td><input type="text" class="txt" name="Detail_po[]" value="<?php echo $v->no_po; ?>" /></td>
                        <td><input type="hidden" name="txtdocno[]" class="txt txtdocno" onkeypress="return isNumber(event)" value="<?php echo $v->docno; ?>" />
                          <input type="hidden" name="txtItemId[]" class="txt txtItemId" onkeypress="return isNumber(event)" value="<?php echo $v->ItemID; ?>" />
                          <textarea name="txtItemName[]" rows="1" cols="30" id="namacoa<?php echo $m++; ?>" class="txt txtNmCOA"><?php echo $v->ItemName; ?></textarea>
                        </td>
                        <td><input type="hidden" class="txt number" name="txtQty1000[]" value="<?php echo $v->per1000; ?>" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_total()" required />
                          <input type="text" class="txt number quantity" name="txtQty[]" value="<?php echo number_format($v->Qty, 2, '.', ','); ?>" onkeypress="return isNumber(event);" onKeyup="hitung_total()" />
                        </td>
                        <td>
                          <input type="text" name="txtunit[]" class="txt" value="<?php echo $v->unit; ?>" />
                          <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" />
                        </td>
                        <td><input type="text" class="txt number prices" name="txtunitprice[]" value="<?php echo number_format($v->price, 4, '.', ','); ?>" onKeyup="hitung_total()" /></td>
                        <td><input type="hidden" name="txtRate[]" class="txt number autonumber txtrate" onkeypress="return isNumber(event)" value="<?php echo $v->rate; ?>" />
                          <input type="hidden" name="txtNppbItemId[]" class="txt" value="<?php echo $v->npbbitem; ?>" />
                          <input type="text" class="txt number amount" name="txtamount[]" onkeypress="return isNumber(event);" value="<?php echo number_format($v->Qty * $v->price, 2, '.', ','); ?>" />
                        </td>
                        <td><input type="text" class="txt number dis_per" name="dis_per[]" onkeypress="return isNumber(event);" onKeyup="hitung_disc()" value="<?php echo number_format($v->disc_per, 1, '.', ','); ?>" /></td>
                        <td><input type="text" class="txt number dis_dol" name="dis_dol[]" onkeypress="return isNumber(event);" value="<?php echo number_format($total_discount, 2, '.', ','); ?>" readonly /></td>
                        <td><input type="text" class="txt number txtRateDtl" name="txtRate[]" onkeypress="return isNumber(event)" value="<?php echo number_format($v->rate, 6, '.', ''); ?>" /></td>
                        <td><input type="text" class="txt number txtSGD" name="txtusd[]" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Qty * $v->price * $v->rate, 2, '.', ','); ?>" /></td>
                        <td>
                          <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST" <?php
                                                if ($v->gst_type == 'GST') {
                                                  echo "selected";
                                                }
                                                ?>>GST</option>
                            <option value="ZER" <?php
                                                if ($v->gst_type == 'ZER') {
                                                  echo "selected";
                                                }
                                                ?>>Zero Rate</option>
                            <option value="EXP" <?php
                                                if ($v->gst_type == 'EXP') {
                                                  echo "selected";
                                                }
                                                ?>>Exampt</option>
                            <option value="OUT" <?php
                                                if ($v->gst_type == 'OUT') {
                                                  echo "selected";
                                                }
                                                ?>>Out of Scope</option>
                          </select>
                        </td>
                        <td><input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" value="<?php echo number_format($v->gst_value, 2, '.', ','); ?>" onKeyup="hitung_total()" /></td>
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
                  <th width="10%">Account Number</th>
                  <th width="5%">D/C</th>
                  <th width="20%">Account Name</th>
                  <th width="25%">Description</th>
                  <th width="10%">Total</th>
                  <th width="10%">Rate</th>
                  <th width="10%">Debit</th>
                  <th width="10%">Credit</th>
                </thead>
                <tbody>
                  <!-- form untuk edit dimulai -->
                  <?php
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
                      $chk1x = 'value="D"  selected';
                      $chk1 = 'value="C"';
                      $Debit1 = number_format($z->Debet, 2, '.', '');
                      $credit1 = 0;

                      $desc1 = "Accrued Received Goods Liability";
                      $Total1 = number_format($z->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID1 = "0";
                    $NoCOA1 = "200104";
                    $chk1 = 'value="C"';
                    $chk1x = 'value="D" selected ';
                    $credit1 = "0";
                    $Debit1 = "0";
                    $desc1 = "Accrued Received Goods Liability";
                    $Total1 = "0";
                  }

                  //diskon
                  if (!empty($get_data_jurnal2)) {
                    foreach ($get_data_jurnal2 as $x) {
                      $DetailID2 = $x->DetailID;
                      $NoCOA2 = $x->NoCOA;
                      if ($x->chk == 'D') {
                        $chk2x = 'value="D"';
                        $chk2 = 'value="C" selected';
                        $Debit2 = number_format($x->Debet, 2, '.', '');
                        $credit2 = "0";
                      } else {
                        $chk2 = 'value="C"';
                        $chk2x = 'value="D" selected';
                        $credit2 = number_format($x->Kredit, 2, '.', '');
                        $Debit2 = "0";
                      }
                      $desc2 = $x->Keterangan;
                      $Total2 = number_format($x->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID2 = "0";
                    $NoCOA2 = "400301";
                    $chk2 = 'value="C" selected ';
                    $chk2x = 'value="D"';
                    $credit2 = "0";
                    $Debit2 = "0";
                    $desc2 = "Purchase Discount";
                    $Total2 = "0";
                  }

                  //pajak
                  if (!empty($get_data_jurnal3)) {
                    foreach ($get_data_jurnal3 as $w) {
                      $DetailID3 = $w->DetailID;
                      $NoCOA3 = $w->NoCOA;
                      if ($w->chk == 'D') {
                        $chk3x = 'value="D" selected';
                        $chk3 = 'value="C" ';
                        $Debit3 = number_format($w->Debet, 2, '.', '');
                        $credit3 = "0";
                      } else {
                        $chk3 = 'value="C" selected';
                        $chk3x = 'value="D" ';
                        $credit3 = number_format($w->Kredit, 2, '.', '');
                        $Debit3 = "0";
                      }
                      $desc3 = $w->Keterangan;
                      $Total3 = number_format($w->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID3 = "0";
                    $NoCOA3 = "140601";
                    $chk3 = 'value="C"';
                    $chk3x = 'value="D"  selected';
                    $credit3 = "0";
                    $Debit3 = "0";
                    $desc3 = "GST Input Tax";
                    $Total3 = "0";
                  }

                  //Additional Cost
                  if (!empty($get_data_jurnal4)) {
                    foreach ($get_data_jurnal4 as $u) {
                      $DetailID4 = $u->DetailID;
                      $NoCOA4 = $u->NoCOA;
                      if ($u->chk == 'D') {
                        $chk4x = 'value="D" selected ';
                        $chk4 = 'value="C"';
                        $Debit4 = number_format($u->Debet, 2, '.', '');
                        $credit4 = "0";
                      } else {
                        $chk4 = 'value="C" selected';
                        $chk4x = 'value="D"';
                        $credit4 = number_format($u->Kredit, 2, '.', '');
                        $Debit4 = "0";
                      }
                      $desc4 = $u->Keterangan;
                      $Total4 = number_format($u->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID4 = "0";
                    $NoCOA4 = "";
                    $chk4 = 'value="C" selected';
                    $chk4x = 'value="D" ';
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
                        $Debit5 = number_format($u->Debet, 2, '.', '');
                        $credit5 = "0";
                      } else {
                        $chk5 = 'value="C" selected';
                        $chk5x = 'value="D"';
                        $credit5 = number_format($u->Kredit, 2, '.', '');
                        $Debit5 = "0";
                      }
                      $desc5 = $u->Keterangan;
                      $Total5 = number_format($u->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID5 = "0";
                    $NoCOA5 = "200508";
                    $chk5 = 'value="C" ';
                    $chk5x = 'value="D"  selected';
                    $credit5 = "0";
                    $Debit5 = "0";
                    $desc5 = "Deposit for vendor";
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
                        $Debit6 = number_format($u->Debet, 2, '.', '');
                        $credit6 = "0";
                      } else {
                        $chk6 = 'value="C" selected';
                        $chk6x = 'value="D" ';
                        $credit6 = number_format($u->Kredit, 2, '.', '');
                        $Debit6 = "0";
                      }
                      $desc6 = $u->Keterangan;
                      $Total6 = number_format($u->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID6 = "0";
                    $NoCOA6 = "";
                    $chk6x = 'value="D"';
                    $chk6 = 'value="C" selected ';
                    $credit6 = "0";
                    $Debit6 = "0";
                    $desc6 = "";
                    $Total6 = "0";
                  }
                  //$total_debet_al = 0;
                  //$total_debet_al +=  $z->Total;
                  ?>
                  <!-- 1. baris Sales -->
                  <tr id="ds1">
                    <td></td>
                    <td>
                      <input type="hidden" name="DetailID[0]" value="<?php echo "$DetailID1"; ?>" />
                      <input type="text" name="no_coa[0]" value="<?php echo "$NoCOA1"; ?>" class="no_coa txt">
                    </td>
                    <td>
                      <select name="dk[]" onchange="hitung_total()" class="txt dk">
                        <option <?php echo "$chk1x"; ?>>D</option>
                        <option <?php echo "$chk1"; ?>>C</option>
                      </select>
                    <td>
                      <input type="hidden" name="NoUrut[0]" value="1" class="txt">
                      <input type="text" name="JenisJurnal[0]" value="ARGL" class="txt">
                      <input type="hidden" name="SubAccountId[0]" value="" class="txt">
                    </td>
                    <td><input type="text" name="desc[0]" value="<?php echo "$desc1"; ?>" class="txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[0]" value="<?php echo number_format($Total1, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
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
                      <input type="hidden" name="SubAccountId[1]" value="DRC" class="txt">
                    </td>
                    <td><input type="text" name="desc[1]" value="<?php echo "$desc2"; ?>" class="txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[1]" value="<?php echo number_format($Total2, 2, ".", ",");               ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                    </td>
                    <td><input type="text" name="rate_jr[1]" id="jr_rate2" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="debt_jr[1]" value="<?php echo number_format($Debit2, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="credit_jr[1]" value="<?php echo number_format($credit2, 2, ".", ",");               ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
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
                      <input type="text" name="JenisJurnal[2]" value="GST Input Tax" class="txt">
                      <input type="hidden" name="SubAccountId[2]" value="GIT" class="txt">
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
                      <input type="hidden" name="SubAccountId[3]" value="" class="txt">
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
                      <input type="hidden" name="SubAccountId[4]" value="DPA" class="txt">
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
                      <input type="hidden" name="SubAccountId[5]" value="HUT" class="txt">
                    </td>
                    <td><input type="text" name="desc[5]" id="desc5" value="<?php echo $desc6; ?>" class=" txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[5]" value="<?php echo number_format($Total6, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                    </td>
                    <td><input type="text" name="rate_jr[5]" id="jr_rate6" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="debt_jr[5]" value="<?php echo number_format($Debit6, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="credit_jr[5]" value="<?php echo number_format($credit6, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                  </tr>

                  <!-- Account Receivable Berakhir -->

                </tbody>
              </table>
            </div>
            <table class="table table-bordered">
              <?php
              if (!empty($get_data_footer)) {
                $Total_creditx = $credit1 + $credit2 + $credit3 + $credit4 + $credit5 + $credit6;
                $Totalx = $Debit1 + $Debit2 + $Debit3 + $Debit4 + $Debit5 + $Debit6;
              } else {
                $Total_creditx = 0;
                $Totalx = 0;
              }
              ?>
              <tr>
                <td width="80%"></td>
                <td><input type="text" name="nota_debet" value="<?php echo number_format($Totalx, 2, '.', ','); ?>" onkeypress="return validasi_enter(event)" class="txt number" id="total_debet" keypress></td>
                <td><input type="text" name="nota_credit" value="<?php echo number_format($Total_creditx, 2, '.', ','); ?>" onkeypress="return validasi_enter(event)" class="txt number" id="total_credit" keypress></td>
              </tr>

            </table>
            <hr />

            <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
            <a class="btn btn-warning" href="<?php echo base_url(); ?>Purchase_inv_vendor"><i class="fa fa-warning"></i> Cancel</a>
            <?php if ($this->input->get('id') <> '') { ?>
              <a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>Purchase_inv_vendor123/print_report?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" target="_blank"><i class="fa fa-print"></i> Print</a>
              <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>Purchase_inv_vendor/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
            <?php } ?>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Master COA</h4>
        <input class="form-control" type="text" id="search_coa" placeholder="search">
      </div>
      <div class="modal-body">
        <!-- <select name="select_vcdn" class="form-control" id="select_vcdn">
                    <option value="credit">Credit</option>
                    <option value="Debt">Debt</option>
                </select> -->
        <input type="hidden" name="select_vcdn" id="select_vcdn" value="credit">
        <section class="">
          <div class="contain">
            <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa" width="100%">
              <thead>
                <tr class="header">
                  <th>No. COA<div>No. COA</div>
                  </th>
                  <th>Account Name<div>Account Name</div>
                  </th>
                  <th>Group <div>Group</div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php
                if (!empty($List_coa)) {
                  foreach ($List_coa as $s) {
                ?>
                    <tr onclick="ambil(this)" style="cursor: pointer;">
                      <td><?php echo $s->NoCOA; ?></td>
                      <td><?php echo $s->AccountName; ?></td>
                      <td><?php echo $s->GroupCOA; ?></td>
                    </tr>
                <?php
                  }
                }
                ?>

              </tbody>
            </table>
          </div>
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>

  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of PO Vendor</h4>
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="deposit" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Deposit Customer</h4>
      </div>
      <div class="err"></div>
    </div>
  </div>
</div>
<div class="modal fade" id="error_currency" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4>Please complete field Currency!</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="error_vendor" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4>Please complete field Vendor!</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel_dpi").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });
</script>