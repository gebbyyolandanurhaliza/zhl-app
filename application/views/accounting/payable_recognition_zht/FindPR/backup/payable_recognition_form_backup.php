<?php
//===== Last Update Date  : 6 Dec 2016 ========
//===== Last Update By    : Ozzy ==============

error_reporting(0);
?>
<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<script>
  $(function() {
    $('.no_coa').autocomplete({
      serviceUrl: "<?php echo site_url('Payable_recognition/get_coa'); ?>"
    });
  });
</script>
<script>
  // function standard
  function cekdetail() {
    $txtcoa = document.getElementsByClassName('txtCOA');

    // alert();
    if ($txtcoa.length <= 0) {
      // alert(1);
      $("#btn_update").prop("disabled", true);
    } else {
      // alert(2);
      $("#btn_update").prop("disabled", false);
    }
  }


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
    document.getElementById('jr_rate1').value = cur;
    document.getElementById('jr_rate2').value = cur;
    document.getElementById('jr_rate3').value = cur;
    document.getElementById('jr_rate4').value = cur;
    document.getElementById('jr_rate5').value = cur;
    document.getElementById('jr_rate6').value = cur;
    var btn = document.getElementById('btn_update').value;
    $('form#form1').submit(function() {
      window.onbeforeunload = null;
    });
    if (btn === 'Save') {
      window.onbeforeunload = function() {
        return "Do you want to leave?";
      };
    }

    $("#search").keyup(function() {
      _this = this;
      $.each($("#tbl_coa tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });

    $("#search_2").keyup(function() {
      _this = this;
      $.each($("#tbl_coa_2 tbody tr"), function() {
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
    //cek_gst();
  });

  function hitung_amount() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var amount = document.getElementsByClassName('amount');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
      var utkAmount = harga[i].value * qty[i].value;
      amount[i].value = utkAmount.toFixed(2);
    }
    hitung_total();
  }


  function hitung_total() {
    var gst = document.getElementsByClassName('txtGSTValue');
    var total4 = document.getElementById('total_jr4');
    total4.value = total4.value.replace(",", "");
    var total2 = document.getElementById('total_jr2');
    total2.value = total2.value.replace(",", "");
    var total = document.getElementsByClassName('jur_total');
    var jur_det = document.getElementsByClassName('jur_deb');
    var jur_credit = document.getElementsByClassName('jur_credit');
    var dk = document.getElementsByClassName('dk');
    var rate = document.getElementsByClassName('jr_rate');
    var total_deb = document.getElementById('total_debet');
    var total_credit = document.getElementById('total_credit');
    var txtGST = document.getElementsByClassName('txtGST');
    var sum_dbt = 0;
    var sum_crt = 0;
    var total_AP = 0;
    var sum = 0;
    var sumx = 0;
    var sumz = 0;
    var amount = document.getElementsByClassName('amount');
    var price = document.getElementsByClassName('prices');
    var quantity = document.getElementsByClassName('quantity');
    var txtSGD = document.getElementsByClassName('txtSGD');
    var cur = document.getElementById('rate_currency').value;
    for (var i = 0; i < price.length; i++) {
      quantity[i].value = quantity[i].value.replace(",", "");
      price[i].value = price[i].value.replace(",", "");
      gst[i].value = gst[i].value.replace(",", "");
      amount[i].value = amount[i].value.replace(",", "");
      var ttlSGD = cur * amount[i].value;
      txtSGD[i].value = ttlSGD.toFixed(2);
    }

    $(".amount").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum += parseFloat(this.value);
      }
    });

    //$(".txtSGD").each(function () {
    //    if (!isNaN(this.value) && this.value.length !== 0) {
    //        sumx += parseFloat(this.value);
    //    }
    //});

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

    document.getElementById('nota_debet').value = sum;
    for (var i = 0; i < total.length; i++) {
      if (i < 1) {
        total[0].value = sum.toFixed(2);
      }

      if (i > 1) {
        total[2].value = sumx.toFixed(2);
      }

      if (i < 5) {
        if (dk[i].value === "D") {
          total_AP += parseFloat(total[i].value);
        } else {
          total_AP -= parseFloat(total[i].value);
        }
        total[5].value = total_AP.toFixed(2);
        //for gst

        // for (var a = 0; a < txtGSTValue.length; a++) {
        //if (sumz > 0) {
        //    var total_tax = sumz * 0.07;
        //    total[2].value = total_tax.toFixed(2);
        //} else {
        //    total[2].value = total[2].value;
        //}
        //}
      }

      //hitung selisih
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
    var selisih = (sum_dbt - sum_crt).toFixed(2);

    if (selisih != 0) {
      jur_det[0].value = (data_ar - selisih).toFixed(2);
    }

    total_credit.value = sum_crt.toFixed(2);
    total_deb.value = (sum_dbt - selisih).toFixed(2);
  }

  function cek_gst() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var txtsummary = document.getElementsByClassName('txtsummary');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    // hitung_total();

    var gst_type = document.getElementsByClassName('txtGST');
    var sgd_txt = document.getElementsByClassName('amount');
    var rate_sgd = document.getElementById('rate_sgd');
    var jur_total2 = document.getElementById('total_jr2');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    for (var i = 0; i < gst_type.length; i++) {
      if (sgd_txt[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {

        if (gst_type[i].value === 'GST') {
          // var total = sgd_txt[i].value * rate_sgd.value * 7 / 100;
          // gst_value[i].value = total.toFixed(2);
          // jur_total2.value = sgd_txt[i].value * 0.07;
          // txtsummary[i].value = qty[i].value * harga[i].value;

          var Amount = qty[i].value * harga[i].value;
          txtsummary[i].value = Amount;
          gst_value[i].value = (Amount * 7 / 100).toFixed(2);
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
    document.getElementById('rate_sgd_nego').value = res[1];
    document.getElementById('jr_rate1').value = res[0];
    document.getElementById('jr_rate2').value = res[0];
    document.getElementById('jr_rate3').value = res[0];
    document.getElementById('jr_rate4').value = res[0];
    document.getElementById('jr_rate5').value = res[0];
    document.getElementById('jr_rate6').value = res[0];
    hitung_total();
    document.getElementById('tombol_dp').style.display = 'inline';
  }



  function get_coa() {
    var supp = document.getElementById('supplier').value;
    // var nocao = document.getElementsByClassName('no_coa');
    var nocao = document.getElementById('no_coa5');
    // alert(supp);
    var belah = supp.split("|");
    document.getElementById("supp").value = belah[0];
    document.getElementById("NoCOA").value = belah[1];
    //document.getElementById("NoCOA_DP").value = belah[1];
    nocao.value = belah[1];
    // alert(belah[1]);
    document.getElementById('desc5').value = belah[0];
  }

  function make_blank() {
    //document.form1.type.value = "";
    var qty = document.getElementsByClassName('quantity');
    qty.value = "";
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
    var harga = getText(document.getElementById('tbl_coa').rows[$r].cells[2]);
    // var nama = AccNm.split("-");
    // var txt = "";
    // var x = nama[2];
    // if (x === undefined) {
    //     txt = "";
    // } else {
    //     txt = "-" + nama[2];
    // }

    // alert($txtco);
    var txt = AccNo + " / " + AccNm

    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr><td style="text-align: center;"><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="400165"  required /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA">' + txt + '</textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_amount()" required/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber" onKeyup="hitung_amount()"  placeholder="0" value="' + harga + '" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber" onKeyup="hitung_total()" data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="' + rate + '" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)" value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
    $('#carrier').modal('hide');
  }

  function ambil2(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var num = 1;
    var AccNo = getText(document.getElementById('tbl_coa_2').rows[$r].cells[0]);
    var AccNm = getText(document.getElementById('tbl_coa_2').rows[$r].cells[1]);
    var harga = getText(document.getElementById('tbl_coa_2').rows[$r].cells[2]);


    // var nama = AccNm.split("-");
    // var txt = "";
    // var x = nama[2];
    // if (x === undefined) {
    //     txt = "";
    // } else {
    //     txt = "-" + nama[2];
    // }
    var txt = AccNo + " / " + AccNm

    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr><td style="text-align: center;"><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="400165"  required /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA">' + txt + '</textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_amount()" required/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber" onKeyup="hitung_amount()"  placeholder="0" value="' + harga + '" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber" onKeyup="hitung_total()" data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="' + rate + '" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)" value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
    $('#barge').modal('hide');
  }


  function ambilnew(x) {
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
    var harga = getText(document.getElementById('tbl_coa').rows[$r].cells[2]);
    var txt = AccNo + " / " + AccNm

    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr><td style="text-align: center;"><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="' + AccNo + '"  required readonly /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA"></textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_amount()" required/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber" onKeyup="hitung_amount()"  placeholder="0" value="0" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber" onKeyup="hitung_total()" data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="' + rate + '" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)" value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
    $('#coa').modal('hide');
    cekdetail();
  }

  function tambah_detail() {
    var num = 1;
    // tambah_detail
    $txtco = document.getElementsByClassName('txtCOA').length;
    // alert($txtco);
    $idd = 'coa-' + $txtco;
    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr><td style="text-align: center;"><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" id="' + $idd + '" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="400165"  required /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA"></textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_amount()" required/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber" onKeyup="hitung_amount()"  placeholder="0" value="0" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber" onKeyup="hitung_total()" data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="' + rate + '" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)" value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
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
      $('table[id="tabel"]').append('<tr><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value=""  /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA"></textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber"  data-a-sep="," data-a-dec="." name="txtQty[]" value="0" onkeypress="return isNumber(event);" onKeyup="hitung_amount()"/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber"  onKeyup="hitung_amount()"  placeholder="0" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber" onKeyup="hitung_total()" onkeypress="return isNumber(event)"   placeholder="0" required /></td>\n\
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
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
  }

  function tambah_jurnal() {
    var num = 1;
    var rate = document.getElementById('rate_currency').value;
    for (var i = 0; i < num; i++) {

      $('table[id="table_jurnal"]').append('<tr>\n\
                                            <td></td>\n\
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
      url: "<?php echo base_url(); ?>Payable_recognition/data_dp?id=" + supp + "&currency=" + curency,
      success: function(response) {
        $(".err").html(response);
      },
      dataType: "html"
    });
  }


  function ubah_status1() {
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
    hitung_amount();
    cekdetail();
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


  function cek_nofak() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>Payable_recognition/cek_tabel_ap?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
  }

  function cek_tr_id(xid) {
    var nocoa = xid.replace("nocoa", "");;

    document.getElementById("txtIdCoa").value = xid;
    document.getElementById("txtNmCoa").value = "namacoa" + nocoa;
    $("#coa_detail").modal();
  }

  function get_cur_purchase() {
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tanggal_invoice').value;
    document.getElementById('tgl_tempo').value = tgl1;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    var supp = document.getElementById('supplier').value;
    var belah = supp.split("|");

    var vendor = belah[0];
    var currency = document.getElementById("currency").value;

    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_vendor/ambil_currency?cur=" + currency + "&date=" + tgl1 + "",
      success: function(response) {
        $("#daftar_kurs").html(response);

        var cur = document.getElementById('rate_currency').value;

        document.getElementById('jr_rate1').value = cur;
        document.getElementById('jr_rate2').value = cur;
        document.getElementById('jr_rate3').value = cur;
        document.getElementById('jr_rate4').value = cur;
        document.getElementById('jr_rate5').value = cur;
        document.getElementById('jr_rate6').value = cur;
      },
      dataType: "html"
    });
  }

  function Rate_notfound() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tanggal_invoice").value;
    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_factory/accounting_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate2").html(response);
      },
      dataType: "html"
    });
    return false;
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur = $s->nofaktur;
    $kode_sup = $s->kode_sup;
    $supplier_id = $s->kode_sup . "|" . $s->nocoa;
    $NoCOA = $s->nocoa;
    $bayar = $s->bayar;
    $currency_id = $s->currency_id;
    $Currency_symbol = $s->currency_id;
    $rate_sgd = $s->rate_sgd_ori;
    $rate_sgd_nego = $s->rate_sgd;
    $rate = $s->rate;
    $sdate = new DateTime($s->tanggal);
    $date_of_journal = date_format($sdate, 'd/m/Y');
    $idate = new DateTime($s->tanggal_invoice);
    $date_invoice = date_format($idate, 'd/m/Y');
    $tgl_ship = date('d/m/Y');
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
    $jeninv = $s->jenis_inv;
  }
} else {
  $nofaktur = '';
  $kode_sup = '';
  $currency_id = '';
  $supplier_id = "";
  $NoCOA = '';
  $bayar = 0;
  $Currency_symbol = '';
  $rate = '0';
  $status_dp = "";
  $date_of_journal = date('d/m/Y');
  $date_invoice = date('d/m/Y');
  $tgl_tempo = date('d/m/Y');
  $tgl_ship = date('d/m/Y');
  $term = '0';
  $rate_sgd = '0';
  $rate_sgd_nego = '0';
  $nota_debet = '0';
  $readonly = '';
  $disable = 'disable';
  $submit_value = 'Save';
  $jeninv = "";
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Payable_recognition/save_payable_rec" name="form1" id="form1" method="post">
        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date'); ?>" />
          <?php echo $message; ?>
          <div id="error_id"></div>
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Payable Recognition</span>
              </div>
              <div class="form-group">
                <?php if ($this->input->get('id') <> '') { ?>
                  <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Payable_recognition/add_new"><i class="fa fa-plus"></i> Create New</a>
                <?php } ?>
              </div>
            </div>
            <?php if ($bayar > 0) { ?>
              <div class="note note-danger note-bordered">
                <p>
                <h2>Warning!!!</h2>
                This transaction payment already done, you cannot delete this transaction.
                </p>
              </div>
            <?php } ?>
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
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='select2me form-control' id='currency' onchange='get_cur_purchase();Rate_notfound();' required";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                          echo "<input type='hidden' name='xxx' id='supp'  class='form-control' value='$currency_id'/>";
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Type</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='select2me form-control' id='jeninv' required";
                          echo form_dropdown('jeninv', $jenisinv, $jeninv, $style_currency);
                          echo "<input type='hidden' name='xxx' id='supp'  class='form-control' value='$currency_id'/>";
                          ?>
                          <script>
                            function gantiref() {
                              var id = $("#jeninv").val();
                              // alert(id);
                              if (id === 'bar') {
                                $("#co").attr("href", "#barge");
                              } else if (id === 'car') {
                                $("#co").attr("href", "#carrier");
                              } else {
                                $("#co").attr("href", "#");
                              }
                            }
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div id="daftar_kurs">
                      <div class="form-group">
                        <label class="control-label col-md-3">Rate</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_currency" name="rate_header" class="form-control" value="<?php echo $rate; ?>" onkeyup="validasi_enter(event)" onkeypress="return isNumber(event)" <?php echo $readonly; ?> readonly />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">SGD Rate</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" readonly />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">SGD Rate Nego</label>
                        <div class="col-md-3">
                          <input type="text" id="rate_sgd_nego" name="rate_sgd_nego" class="form-control" value="<?php echo $rate_sgd_nego; ?>" onkeypress="return isNumber(event)" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Shipping Date</label>
                      <div class="col-md-3">
                        <input type="text" id="shipdate" name="shipdate" class="form-control date date-picker" value="<?php echo $tgl_ship; ?>" onkeypress="return isNumber(event)" data-date-format="dd/mm/yyyy" <?= $readonly; ?> />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date date-picker" onchange="get_cur_purchase();Rate_notfound();" value="<?php echo $date_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
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
                      <label class="control-label col-md-3">Date of Journal</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_tempo" name="tgl_jurnal" class="form-control date date-picker" value="<?php echo $date_of_journal; ?>" data-date-format="dd/mm/yyyy" readonly required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Due Date</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_invoice" name="tgl_tempo" class="form-control" value="<?php echo $tgl_tempo; ?>" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                  </div>
                  <!--  <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Status</label>
                                            <div class="col-md-9">
                                                <input type="checkbox" name="statusDp" id="statusDp" onclick="ubah_status1()" <?php echo $status_dp; ?>> <label for="statusDp"> Check for Deposit invoice</label>
                                                <input type="hidden" name="stsDP" id="stsDP" value="NoDP" />
                                            </div>
                                        </div>
                                    </div>-->
                </div>
                <hr />
                <!-- <a class="btn green" data-toggle="modal" id="co" href="#coa" title="Serch COA number"><i class="fa fa-search"></i> Add Detail</a> -->

                <a class="btn btn-primary" data-toggle="modal" href="#deposit" id="tombol_dp" style="display: none" onclick="ambil_tabel()"><i class="fa fa-money"></i> Select Deposit</a>
                <div class="col-md-2 kanan">
                  <input type="hidden" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <div id="demo" style="display: none"></div>
                <hr />

              </div>
              <!-- <table id="p_recognition"></table>
                                <div id="pager1"></div> -->
              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="3%">
                      <a class="btn green" data-toggle="modal" id="co" href="#coa" title="Serch COA number"><i class="fa fa-plus"></i></a>
                    </th>
                    <th width="8%">
                      PO Number
                    </th>
                    <th width="8%">
                      ARGL Account
                    </th>
                    <th width="20%">
                      Port / Container
                    </th>
                    <th width="5%">
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
                    <!--<th width="10%">
                                            Rate
                                        </th>-->
                    <th width="10%">
                      USD Equivalent
                    </th>
                    <th width="10%">
                      GST Type
                    </th>
                    <th width="10%">
                      GST Value (SGD)
                    </th>

                  </tr>
                </thead>

                <tbody>
                  <?php
                  if (!empty($get_data_detail)) {
                    $no = 1;
                    $n = 1;
                    $m = 1;
                    foreach ($get_data_detail as $v) {
                      if ($v->gst_value == 0) {
                        $GST = 0;
                      } else {
                        $GST = $v->gst_value;
                      }
                  ?>
                      <tr>
                        <td style="text-align: center;">
                          <input type="hidden" name="Detail_item_id[]" value="<?php echo $v->DetailID; ?>" />
                          <input type="hidden" name="SubAccountId[]" value="" class="txt">
                          <button class="tombol" onclick="hapus_dp(this)">Remove</button>
                        </td>
                        <td><input type="text" class="txt" name="Detail_po[]" value="<?php echo $v->no_po; ?>" /></td>
                        <td>
                          <input type="text" id="nocoa<?php echo $n++; ?>" name="txtCOA[]" ondblclick="cek_tr_id(this.id)" value="<?php echo $v->NoCOA; ?>" class="no_coa txt txtCOA">
                        </td>
                        <td><textarea name="txtItem[]" rows="1" cols="30" id="namacoa<?php echo $m++; ?>" class="txt txtNmCOA"><?php echo $v->Items; ?></textarea></td>
                        <td><input type="text" class="txt number quantity" name="txtQty[]" value="<?php echo number_format($v->Qty, 2, '.', ','); ?>" onkeypress="return isNumber(event);" onKeyup="hitung_amount()" /></td>
                        <td>
                          <input type="text" name="txtUnit[]" class="txt" value="<?php echo $v->Unit; ?>" />
                          <input type="hidden" name="txtSummary[]" class="txt txtSummary" />
                        </td>
                        <td><input type="text" class="txt number prices" name="txtPrice[]" value="<?php echo number_format($v->Harga, 4, '.', ','); ?>" onKeyup="hitung_amount()" /></td>
                        <td><input type="text" class="txt number amount" name="txtAmount[]" onKeyup="hitung_total()" onkeypress="return isNumber(event);" value="<?php echo number_format($v->Qty * $v->Harga, 2, '.', ','); ?>" /></td>
                        <!--<td><input type="text" class="txt number txtRateDtl" name="txtRate[]" onkeypress="return isNumber(event)" value="<?php //echo number_format($v->rate, 6, '.', '');                               
                                                                                                                                              ?>"/></td>-->
                        <td><input type="text" class="txt number txtSGD" name="txtSGD[]" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Qty * $v->Harga * $v->rate, 2, '.', ','); ?>" /></td>
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
                <table class="table table-bordered" style="display: none" id="destinationtable">
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

              <table class="table table-bordered" id="table_jurnal">
                <thead>
                  <th></th>
                  <th width="10%">Account Number</th>
                  <th width="5%">D/C</th>
                  <th width="20%">Account Name</th>
                  <th width="25%">Description</th>
                  <th width="10%">Total</th>
                  <th width="10%">Rate</th>
                  <th width="10%">Debt</th>
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
                      $NoCOA1 = "400165";
                      $chk1x = 'value="D" selected';
                      $chk1 = 'value="C" ';
                      $Debit1 = number_format($z->Debet, 2, '.', '');
                      $credit1 = 0;

                      $desc1 = "Vendor";
                      $Total1 = number_format($z->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID1 = "0";
                    $NoCOA1 = "400165";
                    $chk1x = 'value="D" selected';
                    $chk1 = 'value="C" ';
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
                        $chk2 = 'value="C" ';
                        $Debit2 = number_format($x->Debet, 2, '.', '');
                        $credit2 = "0";
                      } else {
                        $chk2x = 'value="D"';
                        $chk2 = 'value="C" selected';
                        $credit2 = number_format($x->Kredit, 2, '.', '');
                        $Debit2 = "0";
                      }
                      $desc2 = $x->Uraian;
                      $Total2 = number_format($x->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID2 = "0";
                    $NoCOA2 = "";
                    $chk2 = 'value="C" selected';
                    $chk2x = 'value="D" ';
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
                        $Debit3 = number_format($w->Debet, 2, '.', '');
                        $credit3 = "0";
                      } else {
                        $chk3x = 'value="D"';
                        $chk3 = 'value="C" selected';
                        $credit3 = number_format($w->Kredit, 2, '.', '');
                        $Debit3 = "0";
                      }
                      $desc3 = $w->Uraian;
                      $Total3 = $w->Total;
                    }
                  } else {
                    $DetailID3 = "0";
                    $NoCOA3 = "140601";
                    $chk3 = 'value="C" ';
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
                        $Debit4 = number_format($u->Debet, 2, '.', '');
                        $credit4 = "0";
                      } else {
                        $chk4 = 'value="C" selected';
                        $chk4x = 'value="D"';
                        $credit4 = number_format($u->Kredit, 2, '.', '');
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
                    foreach ($get_data_jurnal5 as $a) {
                      $DetailID5 = $a->DetailID;
                      $NoCOA5 = $a->NoCOA;
                      if ($a->chk == 'D') {
                        $chk5x = 'value="D" selected';
                        $chk5 = 'value="C" ';
                        $Debit5 = number_format($a->Debet, 2, '.', '');
                        $credit5 = "0";
                      } elseif ($a->chk == 'C') {
                        $chk5 = 'value="C" selected';
                        $chk5x = 'value="D"';
                        $credit5 = number_format($a->Kredit, 2, '.', '');
                        $Debit5 = "0";
                      }
                      $desc5 = $a->Uraian;
                      $Total5 = $a->Total;
                    }
                  } else {
                    $DetailID5 = "0";
                    $NoCOA5 = "200508";
                    $chk5 = 'value="C"';
                    $chk5x = 'value="D" selected';
                    $credit5 = "0";
                    $Debit5 = "0";
                    $desc5 = "Deposits for vendor";
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
                      $desc6 = $u->Uraian;
                      $Total6 = $u->Total;
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
                      <input type="hidden" name="SubAccountId[]" value="" class="txt">
                    </td>
                    <td><input type="text" name="desc[0]" value="<?php echo "$desc1"; ?>" class="txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[0]" value="<?php echo number_format($Total1, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                    </td>
                    <td><input type="text" name="rate_jr[0]" id="jr_rate1" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="debt_jr[0]" value="<?php echo number_format($Debit1, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="credit_jr[0]" value="<?php echo number_format($credit1, 2, ".", ","); ?>" id="" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
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
                      <input type="hidden" name="SubAccountId[1]" value="" class="txt">
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
                      <input type="hidden" name="SubAccountId[2]" value="GIT" class="txt">
                    </td>
                    <td><input type="text" name="desc[2]" value="<?php echo "$desc3"; ?>" class="txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[2]" id="total_jr2" value="<?php echo number_format($Total3, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
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

                  <!-- 5. Down Payment Start

                                    id="NoCOA_DP"-->
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
                      <input type="text" name="total_jr[4]" value="<?php echo number_format($Total5, 2, ".", ","); ?>" class="txt number jur_total" id="total_jr4" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                    </td>
                    <td><input type="text" name="rate_jr[4]" id="jr_rate5" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="debt_jr[4]" value="<?php echo number_format($Debit5, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="credit_jr[4]" value="<?php echo number_format($credit5, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                  </tr>

                  <!-- 5. Down Payment End -->

                  <!-- 6. Account Receivable Start -->
                  <tr id="ds6">
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
                    <td><input type="text" name="credit_jr[5]" value="<?php echo number_format($credit6, 2, ".", ","); ?>" id="jur_credit5" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                  </tr>

                  <!-- Account Receivable Berakhir -->

                  <tr>
                    <td colspan="9"></td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-bordered">
                <?php
                if (!empty($get_data_footer)) {
                  $Total_creditx = $credit1 + $credit2 + $credit3 + $credit4 + $credit5 + $credit6;
                  $Totalx = $Debit1 + $Debit2 + $Debit3 + $Debit4 + $Debit5 + $Debit6;
                ?>
                  <tr>
                    <td width="80%"><a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-plus-circle"></i> Add Rows</a></td>
                    <td><input type="text" name="nota_debet" value="<?php echo number_format($Totalx, 2, '.', ','); ?>" onkeypress="return validasi_enter(event)" class="txt number" id="total_debet" keypress></td>
                    <td><input type="text" name="nota_credit" value="<?php echo number_format($Total_creditx, 2, '.', ','); ?>" onkeypress="return validasi_enter(event)" class="txt number" id="total_credit" keypress></td>
                  </tr>
                <?php
                } else {
                ?>
                  <tr>
                    <td width="80%"><a class="btn btn-success btn-add" onclick="tambah_jurnal()"><i class="fa fa-plus-circle"></i> Add Rows</a></td>
                    <td><input type="text" name="nota_debet" value="0" class="txt number" id="total_debet" keypress></td>
                    <td><input type="text" name="nota_credit" value="0" class="txt number" id="total_credit" keypress></td>
                  </tr>
                <?php
                }
                ?>
              </table>
              <hr />
              <button class="btn btn-default" id="btnFindRecord" type="button">
                Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
              <button type="submit" name="sbt" class="btn btn-primary" id="btn_update" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>Payable_recognition"><i class="fa fa-warning"></i> Cancel</a>
              <?php if ($this->input->get('id') <> '') { ?>
                <!--<a class="btn btn-primary  kanan" href="<?php //echo base_url(); 
                                                            ?>Payable_recognition/print_report?id=<?php //echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); 
                                                                                                                            ?>" target="_blank"><i class="fa fa-print"></i> Print</a>-->
                <?php if ($bayar == 0) { ?>
                  <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>Payable_recognition/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
              <?php }
              }
              ?>

            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="barge" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master Barge</h4>
            </div>
            <div class="modal-body">
                <table class="table datatable" id="tbl_coa_2">
                    <tr>
                        <th width='15%'>Form - TO</th>
                        <th width='25%'>Container Type</th>
                        <th width='25%'>Price</th>
                        <th width='35%'>Exp. Date</th>
                    </tr>
                    <?php
                    if (!empty($listbarge)) {
                      foreach ($listbarge as $s) {
                        if ($s->dest_type == 1) {
                          $type = "SINGAPORE - SEIGUNTUNG";
                        } else {
                          $type = "SEIGUNTUNG - SINGAPORE";
                        }
                    ?>
                                <tr onclick="ambil2(this)" style="cursor: pointer;">
                                    <td><?php echo $type; ?></td>
                                    <td><?php echo $s->container_name; ?></td>
                                    <td><?php echo $s->Harga; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($s->expiredate)); ?></td>
                                </tr>
                                <?php
                              }
                            }
                                ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
            </div>
        </div>
        
    </div>    
</div> --><!-- 

<div class="modal fade" id="carrier" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master CARRIER</h4>
                <input class="form-control" type="text" id="search" placeholder="search">
            </div>
            <div class="modal-body">
                <input type="hidden" name="select_vcdn" id="select_vcdn" value="credit"> 
                <section class="">
                    <div class="contain">
                        <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa" width="100%">
                            <thead>
                                <tr class="header">
                                    <th width='15%'>Port<div>Port</div></th>
                                    <th width='25%'>Container Type<div>Container Type</div></th>
                                    <th width='25%'>Price<div>Price</div></th>
                                    <th width='35%'>Exp. Date<div>Exp. Date</div></th>
                                </tr>

                            </thead>

                            <tbody>
                            <?php
                            if (!empty($listcarrier)) {
                              foreach ($listcarrier as $s) {
                            ?>
                                            <tr onclick="ambil(this)" style="cursor: pointer;">
                                            <td><?php echo $s->port_name; ?></td>
                                            <td><?php echo $s->container_name; ?></td>
                                            <td><?php echo number_format($s->Harga, 2); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($s->expiredate)); ?></td>
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
            
        </div>
    </div>
</div> -->




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




<!-- <div class="modal fade" id="coa_detail" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master COA</h4>
                <input class="form-control" type="text" id="search_dtl" placeholder="search">
                <input type="hidden" id="txtIdCoa" name="txtIdCoa" />
                <input type="hidden" id="txtNmCoa" name="txtNmCoa" />
            </div>
            <div class="modal-body">
                <section class="">
                    <div class="contain">
                        <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa_dtl" width="100%">
                            <thead>
                                <tr class="header">
                                    <th>No. COA<div>No. COA</div></th>
                                    <th>Account Name<div>Account Name</div></th>
                                    <th>Group <div>Group</div></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($List_coa)) {
                                  foreach ($List_coa as $s) {
                                ?>
                                        <tr onclick="ambil_detail(this)" style="cursor: pointer;">
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
    </div>
</div> -->
<!-- Find Recorded Purchase Inventory Factory Modal -->
<div class="modal fade" id="modal-findAP" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Invoice</h4>
      </div>
      <div class="modal-body">
        <div id="contentFindAP"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Master COA</h4>
        <input class="form-control" type="text" id="search" placeholder="search">
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
                    <tr onclick="ambilnew(this)" style="cursor: pointer;">
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
<script type="text/javascript">
  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Payable_recognition/selectInvoicePayable", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });

  $(document).ready(function() {
    cekdetail();
    $("#tbl_coa_2").dataTable({
      "scrollY": 300,
      "scrollX": true
    });
  });
</script>