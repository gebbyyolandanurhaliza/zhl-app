<script>
  //update date 6 Dec 2016 
  //update by Ozzy

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
  }

  function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  // function KeyAmount(event) {
  //     var char = event.which || event.keyCode;
  //     if (char === 13) {
  //         var rate_currency = document.getElementById("rate_currency").value;
  //         var total = document.getElementById('total');
  //         var jenis = document.getElementById("jenis");
  //         var amount = document.getElementById('amount');
  //         var piutang = document.getElementById('piutang');
  //         var desc = document.getElementById('description').value;
  //         var sup = document.getElementById('suplier_code').value;

  //         if (jenis.value === 'CDN') {
  //             if ((Number(amount.value) > Number(total.value))) {
  //                 alert('Value can not exceed the total invoice. Please select your type transaction!');
  //                 amount.value = 0;
  //                 total.value = piutang.value;
  //                 return false;
  //             } else {
  //                 if (jenis.value === 'CCN') {
  //                     total.value = Number(total.value) + Number(amount.value);
  //                 } else {
  //                     total.value = total.value - amount.value;
  //                 }

  //                 $('table[id="tabel"]').append('<tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" id="no_coa1" class="txt" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //                 </tr><tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" id="no_coa1"  class="txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //              </tr>');

  //                 var sum1 = 0;
  //                 var sum2 = 0;
  //                 $(".txtCredit").each(function () {
  //                     //add only if the value is number
  //                     if (!isNaN(this.value) && this.value.length !== 0) {
  //                         sum1 += parseFloat(this.value);
  //                     }
  //                 });
  //                 document.getElementById('nota_credit').value = sum1.toFixed(2);


  //                 $(".txtDebt").each(function () {
  //                     //add only if the value is number
  //                     if (!isNaN(this.value) && this.value.length !== 0) {
  //                         sum2 += parseFloat(this.value);
  //                     }
  //                 });
  //                 document.getElementById('nota_debet').value = sum2.toFixed(2);

  //                 return false;
  //             }
  //         } else {
  //             if (jenis.value === 'CCN') {
  //                 total.value = Number(total.value) + Number(amount.value);
  //             } else {
  //                 total.value = total.value - amount.value;
  //             }

  //             $('table[id="tabel"]').append('<tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" id="no_coa0"  class="no_coa txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa0"  class="nama_coa txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //                 </tr><tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" class="no_coa1 txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa1"  class="nama_coa txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //              </tr>');

  //             var sum1 = 0;
  //             var sum2 = 0;
  //             $(".txtCredit").each(function () {
  //                 //add only if the value is number
  //                 if (!isNaN(this.value) && this.value.length !== 0) {
  //                     sum1 += parseFloat(this.value);
  //                 }
  //             });
  //             document.getElementById('nota_credit').value = sum1.toFixed(2);


  //             $(".txtDebt").each(function () {
  //                 //add only if the value is number
  //                 if (!isNaN(this.value) && this.value.length !== 0) {
  //                     sum2 += parseFloat(this.value);
  //                 }
  //             });
  //             document.getElementById('nota_debet').value = sum2.toFixed(2);

  //             return false;
  //         }
  //     }
  //     if (char > 31 && (char < 46 || char > 57)) {
  //         return false;
  //     }
  //     return true;
  // }


  function valid_enter(event) {
    var char = event.which || event.keyCode;
    if (char == 13) {
      document.getElementById("pesan_error").style.display = "block";
      setTimeout(function() {
        $('#pesan_error').fadeOut(500);
      }, 2000);
      return false;
    }

  }

  function get_currency() {
    var currency_id = document.getElementById('currency').value;
    var res = currency_id.split("|");
    document.getElementById('currencyx').value = res[2];
    document.getElementById('rate_sgd').value = res[1];
    document.getElementById('rate_currency').value = res[0];
    document.getElementById('rate_ccdn').value = res[0];
  }

  $(document).ready(function() {
    $("#tabel_coa").dataTable({
      "scrollY": 300,
      "scrollX": true
    });

    //        var jenis = document.getElementById("jenis");
    //        if (document.getElementById('debit').checked === true) {
    //            jenis.value = 'CDN';
    //            return false;
    //        } else {
    //            jenis.value = 'CCN';
    //            return false;
    //        }
  });


  function hapus_baris(ip) {
    var tr = ip.parentNode.parentNode;
    tr.parentNode.removeChild(tr);

    var sum1 = 0;
    var sum2 = 0;
    $(".txtCredit").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum1 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_credit').value = sum1.toFixed(2);


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum2.toFixed(2);
  }


  function get_sup() {
    var z = document.getElementById('SupSelect').value;
    var res = z.split("|");
    var x = document.getElementById("SupSelect").selectedIndex;
    var y = document.getElementById("SupSelect").options;
    document.getElementById('suplier_code').value = res[0];
    document.getElementById('suplier_coa').value = res[1];
    document.getElementById('nocoa').value = res[1];
    document.getElementById('suplier_name').value = y[x].text;
    var rate = document.getElementById("rate_currency").value;
    var jenis = document.getElementById("jenis");
    var jenisTxt = '';

    var infor = '';
    if (jenis.value === 'CDN') {
      infor = 'Debit Note for ' + y[x].text;
      jenisTxt = 'D';
    } else if (jenis.value === 'CCN') {
      infor = 'Credit Note for ' + y[x].text;
      jenisTxt = 'C';
    }
    $.ajax({
      url: "<?php echo base_url(); ?>Vcdn/account_number?id=" + res[1],
      success: function(response) {
        $("#cari_akun").html(response);
      },
      dataType: "html"
    });


    var x = document.getElementById("tabel").rows.length;
    if (x > 3) {
      document.getElementById("tabel").deleteRow(-1);
      document.getElementById("tabel").deleteRow(-2);
    }


    $('table[id="tabel"]').append('<tr class="myRow">\n\
        <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="' + jenisTxt + '"/>\n\
            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
        <td><input type="text" name="txtAccountNo[]" id="account_ccdn"  class="txt no_coa" value="' + res[1] + '" readonly required/></td>\n\
        <td><input type="text" name="txtDeptCode[]" id="dept_code" class="txt no_coa" value="000" readonly required/></td>\n\
        <td><div id="cari_akun"></div></td>\n\
        <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + infor + '</textarea></td>\n\
        <td><input type="text" name="txtTotal[]"  class="txt number txtTotal txtTotalx" id="total_ccdn" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + 0 + '" /></td>\n\
        <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate1" onkeypress="return isNumber(event)"  value="' + rate + '" readonly /></td>\n\
        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debt_ccdn" onkeypress="return isNumber(event)" readonly  value="0"  /></td>\n\
        <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="credit_ccdn" onkeypress="return isNumber(event)" readonly  value="' + 0 + '"  /><td><input type="hidden" name="txtGST[]" class="txtGST"></td>\n\
        <td><input type="hidden" name="txtGSTValue[]" class="txtGSTValue" readonly></td></tr>');


  }

  function pilih(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var refno = getText(document.getElementById('tabel-1').rows[$r].cells[0]);
    var tgl_invoice = getText(document.getElementById('tabel-1').rows[$r].cells[2]);
    var suplier_code = getText(document.getElementById('tabel-1').rows[$r].cells[3]);
    var suplier_name = getText(document.getElementById('tabel-1').rows[$r].cells[4]);
    var currency = getText(document.getElementById('tabel-1').rows[$r].cells[5]);
    var rate = getText(document.getElementById('tabel-1').rows[$r].cells[6]);
    var totali = getText(document.getElementById('tabel-1').rows[$r].cells[7]);
    var Amount = getText(document.getElementById('tabel-1').rows[$r].cells[8]);
    var term = getText(document.getElementById('tabel-1').rows[$r].cells[9]);
    var coa = getText(document.getElementById('tabel-1').rows[$r].cells[10]);
    var rate_sgd = getText(document.getElementById('tabel-1').rows[$r].cells[11]);
    var txtDebt = document.getElementsByClassName('txtDebt');
    var txtCredit = document.getElementsByClassName('txtCredit');
    document.getElementById("verifikasi").value = "YA";

    for (var i = 0; i < txtCredit.length; i++) {
      txtCredit[i].value = txtCredit[i].value.replace(",", "");
      txtDebt[i].value = txtDebt[i].value.replace(",", "");
    }

    var jenis = document.getElementById("jenis");
    var infor = '';
    var jenistxt = '';

    if (jenis.value === 'CDN') {
      infor = 'Debit Note for ' + suplier_code;
      jenistxt = 'D';
    } else if (jenis.value === 'CCN') {
      infor = 'Credit Note for ' + suplier_code;
      jenistxt = 'C';
    }

    document.getElementById('invoice_number').value = refno;
    document.getElementById('tgl_invoice').value = tgl_invoice;
    document.getElementById('suplier_code').value = suplier_code;
    document.getElementById('SupSelect').value = suplier_code;
    document.getElementById('suplier_name').value = suplier_name;
    document.getElementById('currencyx').value = currency;
    document.getElementById('currency').value = rate + "|" + rate_sgd + "|" + currency;
    document.getElementById('rate_currency').value = rate;
    document.getElementById('total').value = totali;
    document.getElementById('piutang').value = totali;
    document.getElementById('amount').value = Amount;
    document.getElementById('term').value = term;
    document.getElementById('rate_sgd').value = rate_sgd;


    $('table[id="tabel"]').append('<tr class="myRow">\n\
        <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="' + jenistxt + '"/>\n\
            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
        <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="' + coa + '" required/></td>\n\
        <td><input type="text" name="txtAccountName[]" class="txt" value="Trade Accounts Payable"  /></td>\n\
        <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + infor + '</textarea></td>\n\
        <td><input type="text" name="txtTotal[]" class="txt number txtTotal txtTotalx" id="total_ccdn" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + 0 + '" /></td>\n\
        <td><input type="text" name="txtRate[]" class="txt number txtRate" id="rate_ccdn" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debt_ccdn" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="credit_ccdn" onkeypress="return isNumber(event)"  value="' + 0 + '"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  /></td>');

    $('#marketing').modal('hide');
    $('#purchasing').modal('hide');

  }


  function ambil(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var desc = document.getElementById("description").value;
    var AccNo = getText(document.getElementById('tbl_coa').rows[$r].cells[4]);
    var AccNm = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);
    var AccDept = getText(document.getElementById('tbl_coa').rows[$r].cells[5]);
    var rate_currency = document.getElementById("rate_currency").value;
    var amount = document.getElementById("total").value;
    var select_ccdn = document.getElementById("mySelect");
    document.getElementById("verifikasi").value = "YA";
    var jenis = document.getElementById("jenis");
    var gst_id = "kosong";

    amount = amount.replace(",", "");
    var num = 1;
    for (var i = 0; i < num; i++) {
      if (select_ccdn.value === "Credit") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="C"/> \n\
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + AccDept + '" /></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal"  id="' + gst_id + '" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + addCommas(amount) + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + addCommas(amount * rate_currency) + '"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        </tr>');
      } else if (select_ccdn.value === "Debet") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="D"/>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + AccDept + '" /></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" ' + gst_id + '  onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + addCommas(amount) + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + addCommas(amount * rate_currency) + '"  /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        </tr>');
      }
    }

    var txtDebt = document.getElementsByClassName('txtDebt');
    var txtCredit = document.getElementsByClassName('txtCredit');

    for (var i = 0; i < txtCredit.length; i++) {
      txtCredit[i].value = txtCredit[i].value.replace(",", "");
      txtDebt[i].value = txtDebt[i].value.replace(",", "");
    }
    var sum1 = 0;
    var sum2 = 0;
    $(".txtCredit").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum1 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_credit').value = sum1.toFixed(2);


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum2.toFixed(2);
    $('#coa').modal('hide');
  }

  function kalkulasi() {
    var account1 = document.getElementById('account_ccdn').value;
    var dept_code1 = document.getElementById('dept_code').value;
    var txtAccountName1 = document.getElementById('txtAccountName1').value;
    var desc_ccdn = document.getElementById('desc_ccdn').value;
    var jr_rate1 = document.getElementById('jr_rate1').value;
    var credit_ccdn = document.getElementById('credit_ccdn').value;
    var GstValue = document.getElementById('GstValue').value;
    var jenis = document.getElementById('jenis').value;
    var no_coa = '400101';
    var dept_code = '000';
    var nm_coa = 'GST Output Tax';
    // if (jenis === 'CCN') {
    //     no_coa = '140601';
    //     nm_coa = 'GST Input Tax';
    // } else {
    //     no_coa = '400101';
    //     nm_coa = 'GST Ouput Tax';
    // }
    var num = 1;

    if (GstValue > 0) {
      for (var i = 0; i < num; i++) {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="' + account1 + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + dept_code1 + '" />\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + txtAccountName1 + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="' + jenis + '" required/></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc_ccdn + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + GstValue + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + jr_rate1 + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + GstValue * jr_rate1 + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + credit_ccdn + '" readonly /></td>\n\
                <td><input type="hidden" name="txtGST[]"  class="txtGST"></td>\n\
                <td><input type="hidden" name="txtGSTValue[]"  class="txtGSTValue"></td>\n\
        </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="' + no_coa + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + dept_code + '" />\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + nm_coa + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="' + jenis + '" required/></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc_ccdn + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + GstValue + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + jr_rate1 + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + credit_ccdn + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + GstValue * jr_rate1 + '" readonly /></td>\n\
                <td><input type="hidden" name="txtGST[]"  class="txtGST"></td>\n\
                <td><input type="hidden" name="txtGSTValue[]"  class="txtGSTValue"></td>\n\
        </tr>');
      }
    } else {
      alert("GST Cant be Zero!");
    }
  }

  // function tambah_baris() {
  //     var rate_currency = document.getElementById("rate_currency").value;
  //     var num = 1;
  //     for (var i = 0; i < num; i++) {
  //         $('table[id="tabel"]').append('<tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" class="txt" value="" /></td>\n\
  //             <td><input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
  //             <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt"></textarea></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="0" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //     </tr>');
  //     }
  // }

  function cek_gst() {
    //alert('tes');
    var qty = document.getElementsByClassName('txtTotal');
    var harga = document.getElementById('rate_sgd');
    var rate = document.getElementById('rate_currency');
    var gst_type = document.getElementsByClassName('txtGST');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    var GstValue = document.getElementById('GstValue');
    var trGST = document.getElementById('trGST');
    var sbt = document.getElementById('sbt');
    var jenis = document.getElementById('jenis');

    var txtTotalGst = document.getElementById('txtTotalGst');
    var total_a = document.getElementById('total');
    var GstValue = document.getElementById('GstValue');
    var debit = document.getElementsByClassName("txtDebt");
    var credit = document.getElementsByClassName("txtCredit");
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    console.log(tgl1);

    var jenisTxt = '';
    if (jenis.value === 'CDN') {
      jenisTxt = 'C';
    } else if (jenis.value === 'CCN') {
      jenisTxt = 'D';
    }

    total_a.value = total_a.value.replace(",", "");
    GstValue.value = GstValue.value.replace(",", "");

    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      debit[i].value = debit[i].value.replace(",", "");
      credit[i].value = credit[i].value.replace(",", "");
    }

    var sum1 = 0;

    for (var i = 0; i < qty.length; i++) {
      if (qty[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {
        var sgd_txt = qty[i].value;
        if (gst_type[i].value === 'GST') {
          if (tahun > '2023') {
            var total_a = sgd_txt * 9 / 100;
            gst_value[i].value = total_a.toFixed(2);
            trGST.style.display = "";
          } else {
            var total_a = sgd_txt * 8 / 100;
            gst_value[i].value = total_a.toFixed(2);
            trGST.style.display = "";
          }
        } else {
          gst_value[i].value = '';
        }

      }
    }

    $(".txtGSTValue").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum1 += parseFloat(this.value);
      }
    });

    GstValue.value = addCommas(sum1.toFixed(2));

    if (txtTotalGst === 'undefined') {
      txtTotalGst.value = '0';
    } else {
      txtTotalGst.value = sum1.toFixed(2);
    }

    var x = document.getElementById('GstValue').value;

    if (x === 'undefined') {
      document.getElementById('trGST').style.display = "none";
      document.getElementById('GstValue').value = 0;
    } else {
      document.getElementById('amount').value = (parseFloat(document.getElementById('total').value) + sum1).toFixed(2);
    }

    document.getElementById('jenis_gst').value = jenisTxt;
    document.getElementById('jr_rate_gst').value = rate.value;


    //perhitungan total
    var total = document.getElementsByClassName('txtTotal');
    var amount = document.getElementById('amount');
    var jur_det = document.getElementsByClassName('txtDebt');
    var jur_credit = document.getElementsByClassName('txtCredit');
    var rate = document.getElementById('rate_currency');
    var jenis_ccdn = document.getElementById('jenis').value;
    var jenis = document.getElementsByClassName('JenisID');
    var no_coa = document.getElementsByClassName('no_coa');

    if (sum1 == 0) {
      trGST.style.display = "none";
      document.getElementById('txtTotalGst').value = 0;
      total[0].value = parseFloat(document.getElementById('total').value);
    } else {
      total[0].value = parseFloat(document.getElementById('amount').value);
    }

    for (var i = 0; i < total.length; i++) {
      total[i].value = total[i].value.replace(",", "");
      amount.value = amount.value.replace(",", "");
      var total_detail = total[i].value * rate.value;
      if (jenis[i].value === 'D') {
        jur_credit[i].value = 0;
        jur_det[i].value = total_detail.toFixed(2);
      } else if (jenis[i].value === 'C') {
        jur_det[i].value = 0;
        jur_credit[i].value = total_detail.toFixed(2);
      }
    }

    var sum1 = 0;
    var sum2 = 0;
    $(".txtCredit").each(function() {
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum1 += parseFloat(this.value);
      }
    });

    document.getElementById('nota_credit').value = sum1.toFixed(2);


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });

    document.getElementById('nota_debet').value = sum2.toFixed(2);

    var selisih = sum2 - sum1;

    if (selisih != 0) {
      if (jenis[0].value === 'D') {
        jur_det[0].value = (sum2 - selisih).toFixed(2);
        document.getElementById('nota_debet').value = (sum2 - selisih).toFixed(2);
      } else if (jenis[0].value === 'C') {
        jur_credit[0].value = (sum1 + selisih).toFixed(2);
        document.getElementById('nota_credit').value = (sum1 + selisih).toFixed(2);
      }
    }

    var sumX = 0;
    $(".txtGSTValue").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sumX += parseFloat(this.value);
      }
    });
    GstValue.value = sumX.toFixed(2);
    amount.value = (parseFloat(document.getElementById('total').value) + sumX).toFixed(2);
  }

  function add_gst() {
    $('table[id="tabel"]').append('<tr id="trGST" style="display:none">\n\
            <td><a class="tombol" onclick="hidden_baris()" >Remove</a>\n\
                <input type="hidden" name="txtID[]" class="txt" value="0" readonly/>\n\
                <input type="hidden" name="txtJenisID[]" id="jenis_gst" class="txt JenisID"/>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/>\n\
            </td>\n\
            <td><input type="text" name="txtAccountNo[]" class="txt no_coa" id="nocoaGST" value="400101" readonly/></td>\n\
            <td><input type="text" name="txtDeptCode[]" class="txt dept_code" value="000" readonly/></td>\n\
            <td><input type="text" name="txtAccountName[]" class="txt" id="AccountGST" value="GST Output Tax" readonly /></td>\n\
            <td><input type="text" name="txtDesc[]" class="txt" id="descGst" value="GST Output Tax" /></td>\n\
            <td><input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotalGst" readonly /></td>\n\
            <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate_gst" readonly /></td>\n\
            <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debtGst" readonly /></td>\n\
            <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="creditGst" readonly /></td>\n\
            <td><input type="text" name="txtGST[]" class="txt txtGST" id="txtGSTName" readonly /></td>\n\
            <td><input type="text" name="txtGSTValue[]" class="txt number txtGSTValue" id="txtGSTValue" readonly/></td>\n\
        </tr>');
  }


  function masukan_jumlah() {

    var total = document.getElementById('total');
    var GstValue = document.getElementById('GstValue');
    var rate = document.getElementById("rate_currency");
    var jenis = document.getElementById("jenis");
    var totalx = document.getElementById("total_ccdn");
    var debit = document.getElementById("debt_ccdn");
    var credit = document.getElementById("credit_ccdn");

    debit.value = debit.value.replace(",", "");
    credit.value = credit.value.replace(",", "");
    total.value = total.value.replace(",", "");
    GstValue.value = GstValue.value.replace(",", "");

    var total_amount = Number(total.value) + Number(GstValue.value);
    document.getElementById('amount').value = parseFloat(total_amount).toFixed(2);
    totalx.value = parseFloat(document.getElementById('amount').value).toFixed(2);

    if (jenis.value === 'CDN') {
      debit.value = (totalx.value * rate.value).toFixed(2);
      credit.value = 0;
    } else if (jenis.value === 'CCN') {
      credit.value = (totalx.value * rate.value).toFixed(2);
      debit.value = 0;
    }

    //        hitung_vcdn();
  }

  function konfersi_angka() {
    var total = document.getElementById("total");
    total.value = addCommas(document.getElementById("total").value);
  }

  function hitung_vcdn() {
    var total = document.getElementsByClassName('txtTotal');
    var jur_det = document.getElementsByClassName('txtDebt');
    var rate = document.getElementById('rate_currency');
    var jur_credit = document.getElementsByClassName('txtCredit');
    var jenis = document.getElementsByClassName('JenisID');
    var amount = document.getElementById('amount');
    var GSTValue = document.getElementById('GstValue');
    var or = 0;

    var total1 = 0;
    // var total1 = total[0].value.replace(",", "");



    for (var i = 0; i < total.length; i++) {
      total[i].value = total[i].value.replace(",", "");
      total[i].value = total[i].value.replace(",", "");
      amount.value = amount.value.replace(",", "");
      var total_detail = total[i].value * rate.value;

      if (i > 0) {
        total1 += parseFloat(total[i].value);
      }

      // alert(jenis[i].value);

      if (jenis[i].value === 'D') {
        jur_credit[i].value = 0;
        jur_det[i].value = total_detail.toFixed(2);
      } else if (jenis[i].value === 'C') {
        jur_det[i].value = 0;
        jur_credit[i].value = total_detail.toFixed(2);
      }
    }

    var sum1 = 0;
    var sum2 = 0;
    $(".txtCredit").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum1 += parseFloat(this.value);
      }
    });

    document.getElementById('nota_credit').value = sum1.toFixed(2);


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });

    // var totali = 0;

    // if (total[2] === undefined) {
    //     totali = total[1].value;
    // } else {
    //     total1 = Math.abs(total[1].value);
    //     total2 = Math.abs(total[2].value);
    //     totali = parseFloat(total1 + total2) ;
    // }

    if (isNaN(total1)) {
      total1 = 0;
    }

    document.getElementById('nota_debet').value = sum2.toFixed(2);
    document.getElementById('total').value = (total1 - GSTValue.value).toFixed(2);


    cek_gst();
  }


  function ganti_credit() {

    var jenis = document.getElementById("jenis");
    var tgl1 = document.getElementById("tgl_tempo").value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    // if (document.getElementById("refno").value !== '') {
    //     //$("#konfirmasi").modal('show');

    //     $('#ok_ulang').click(function () {
    //         var table = document.getElementById("tabel");
    //         while (table.rows.length > 3) {
    //             table.deleteRow(2);
    //         }

    //         if (document.getElementById('credit').checked === false) {
    //             jenis.value = 'CDN';
    //             $.ajax({
    //                 url: "<?php echo base_url(); ?>ccdn/cek_noref_credit?jenis=CDN&bln=" + bulan +"&tahun=" + tahun,
    //                 success: function (e) {
    //                     $("#ref_number").html(e);
    //                     document.getElementById("mySelect").selectedIndex = "0";
    //                     return false;
    //                 }
    //             }
    //             );
    //         } else {
    //             jenis.value = 'CCN';
    //             $.ajax({
    //                 url: "<?php echo base_url(); ?>ccdn/cek_noref_credit?jenis=CCN&bln=" + bulan +"&tahun=" + tahun,
    //                 success: function (e) {
    //                     $("#ref_number").html(e);
    //                     document.getElementById("mySelect").selectedIndex = "1";
    //                     return false;
    //                 }
    //             }
    //             );
    //         }
    //         $("#konfirmasi").modal('hide');
    //     });

    //     $('#cancel_ok').click(function () {
    //         if (jenis.value === 'CDN') {
    //             $("#debit").prop("checked", true);
    //             $("#credit").prop("checked", false);
    //         } else {
    //             $("#credit").prop("checked", true);
    //             $("#debit").prop("checked", false);
    //         }
    //         $("#konfirmasi").modal('hide');
    //     });

    // } else {
    if (document.getElementById('credit').checked === false) {
      jenis.value = 'CDN';
      $.ajax({
        url: "<?php echo base_url(); ?>ccdn/cek_noref_credit?jenis=CDN&bln=" + bulan + "&tahun=" + tahun,
        success: function(e) {
          $("#ref_number").html(e);
          document.getElementById("mySelect").selectedIndex = "0";
          return false;
        }
      });
    } else {
      jenis.value = 'CCN';
      $.ajax({
        url: "<?php echo base_url(); ?>ccdn/cek_noref_credit?jenis=CCN&bln=" + bulan + "&tahun=" + tahun,
        success: function(e) {
          $("#ref_number").html(e);
          document.getElementById("mySelect").selectedIndex = "1";
          return false;
        }
      });
    }
    //}

  }


  function ambil_tabel() {
    var refno = document.getElementById('refno').value;
    if (refno !== "") {
      $.ajax({
        url: "<?php echo base_url(); ?>ccdn/cek_tabel?id=" + refno,
        success: function(response) {
          $(".CurID").html(response);
        },
        dataType: "html"
      });
    }
  }

  function format2(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
  }

  function validate(form) {
    var debt = document.getElementById("nota_debet").value;
    var credit = document.getElementById("nota_credit").value;
    if (debt === '0' || credit === '0') {
      alert('Debt or Credit value cant be 0 !');
      return false;
    } else if (debt > credit || credit > debt) {
      alert('Debt or Credit not balance');
      return false;
    } else {
      //document.getElementById("myForm").submit();
      return confirm('Do you really want to submit the form?');
    }
  }

  function hidden_baris() {
    document.getElementById('trGST').style.display = 'none';
    var txtGst = document.getElementsByClassName('txtGST');
    for (var i = 0; i < txtGst.length; i++) {
      txtGst[i].value = 'ZER';
    }
    cek_gst();
  }

  function ganti_signature() {
    var cetak = document.getElementById('cetak');
    var locAppend = $('#signature').find('option:selected').val(),
      locSnip = window.location.href.split('edit')[0];
    cetak.href = locSnip + "print_ccdn?id=<?php echo $this->input->get('id'); ?>&jenis=<?php echo $this->input->get('jenis') ?>&cur=<?php echo $this->input->get('cur') ?>&signature=" + locAppend;
    //alert("Redirecting to: " + cetak.href);
  }

  function Rate_notfound() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tgl_tempo").value;
    $.ajax({
      url: "<?php echo base_url(); ?>payable_recognition/ambil_currency_cdn2?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#daftar_kurs").html(response);
        var cur = document.getElementById('rate_currency').value;
        document.getElementById('jr_rate1').value = cur;
        var kur = document.getElementsByClassName('txtRate');
        for (var i = 1; i < kur.length; i++) {
          kur[i].value = cur;
        }
        hitung_vcdn();
      },
      dataType: "html"
    });
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
if (!empty($select_ccdn)) {
  $gstvalue = 0;
  foreach ($select_ccdn as $s) {
    $nofaktur = $s->no_reff;
    $tgl = date('d/m/Y', strtotime($s->tanggal));
    $no_nota = $s->no_nota;
    $tgl_invoice = date('d/m/Y', strtotime($s->tanggal_invoice));
    $gstvalue += $s->gst_value;
    $total = number_format(abs($s->hutang), 2, '.', ',');
    $amount = number_format(abs($s->hutang) + $gstvalue, 2, '.', ',');
    $jenis = $s->jenis_debit_kredit;
    $currency = $s->Currency;
    $currency_id = $s->Rate . "|" . $s->rate_sgd . "|" . $s->Currency;
    $rate = $s->Rate;
    $rate_sgd = $s->rate_sgd;
    $keterangan = $s->Keterangan;
    $nama_sup = $s->nama_sup;
    $kode_sup = $s->kode_sup;
    $coa_sup = $s->NoCOA;
    $prepared_by = $s->prepared_by;
    $account_name = $s->account_name;
    $gst_type = $s->gst_type;
    $disable = "disabled";
    $readonly = "readonly";
    $submit_value = 'Update';
    $paymentto = $s->paymentto;
    $kat = 1;
  }
} else {
  if (isset($_GET['id'])) {
    // echo $id;
    $gstvalue = 0;
    foreach ($select_ccdn2 as $r) {
      $nofaktur = $r->no_reff;
      $tgl = date('d/m/Y', strtotime($r->tanggal));
      $no_nota = $r->no_nota;
      $tgl_invoice = date('d/m/Y', strtotime($r->tanggal));
      $gstvalue += $r->gst_value;
      $total = number_format(abs($r->total), 2, '.', ',');
      $amount = number_format(abs($r->total) + $gstvalue, 2, '.', ',');
      $jenis = $r->jenis_debit_kredit;
      $currency = $r->currency;
      $currency_id = $r->currency_rate . "|" . $r->currency_rate . "|" . $r->currency;
      $rate = $r->currency_rate;
      $rate_sgd = $r->currency_rate;
      $keterangan = $r->keterangan;
      $nama_sup = $r->nama_sup;
      $kode_sup = $r->kode_sup;
      $prepared_by = $r->prepared_by;
      $paymentto = $r->paymentto;
      $coa_sup = "";
      $account_name = "";
      $gst_type = "";
      $disable = "disabled";
      $readonly = "readonly";
      $submit_value = '-';
      $kat = 3;
    }
  } else {
    $nofaktur = "";
    $tgl = date("d/m/Y");
    $no_nota = "";
    $tgl_invoice = "";
    $gstvalue = 0;
    $total = "";
    $jenis = "";
    $currency = "";
    $rate = "0";
    $rate_sgd = "0";
    $amount = "";
    $currency_id = "";
    $keterangan = "";
    $account_name = "";
    $kode_sup = "";
    $paymentto = "";
    $nama_sup = "";
    $readonly = "";
    $coa_sup = "";
    $gst_type = "";
    $disable = "";
    $prepared_by = "";
    $submit_value = 'Save';
    $kat = 0;
  }
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form id="myForm" action="<?php echo base_url(); ?>index.php/ccdn/action" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
          <input type="hidden" id="closing" name="closing" value="<?php echo $closing; ?>" />
          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Customer Credit and Debit Note</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label col-md-3">Type of Transaction</label>
                      <div class="col-md-9">
                        <div id="bounds">
                          <input type="radio" name="type" onclick="ganti_credit()" id="debit" value="debit" <?php
                                                                                                            if ($jenis == 'CDN') {
                                                                                                              echo "checked";
                                                                                                            }
                                                                                                            ?>><label for="debit"> Debt Note</label>
                          <input type="radio" name="type" onclick="ganti_credit()" id="credit" value="Credit" <?php
                                                                                                              if ($jenis == 'CCN') {
                                                                                                                echo "checked";
                                                                                                              }
                                                                                                              ?>><label for="credit"> Credit Note</label>
                          <input type="hidden" name="JenisJurnal" id="jenis" value="<?php echo "$jenis"; ?>" onchange="ganti_credit()" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Reff. Number</label>
                      <div class="col-md-9">
                        <div id="ref_number">
                          <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo "$nofaktur"; ?>" onkeypress="return valid_enter(event)" class="form-control" <?php echo $readonly; ?> readonly />
                        </div>

                        <label class="CurID"></label>
                      </div>
                    </div><br />
                    <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <?php
                        $style_supplier = "class='select2me form-control' id='SupSelect' onchange='get_sup()' $disable";
                        echo form_dropdown('suppliered', $SupplierID, $kode_sup, $style_supplier, $SupplierID);
                        ?>
                        <input type="hidden" id="suplier_code" name="kode_sup" value="<?php echo $kode_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="suplier_name" name="nama_sup" value="<?php echo $nama_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="suplier_coa" name="suplier_coa" value="<?php echo $coa_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="tanggal" class="form-control date target" onchange="ganti_credit();Rate_notfound();" onkeypress="return valid_enter(event)" value="<?php echo "$tgl"; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Number</label>
                      <div class="col-md-9">
                        <div class="input-group">
                          <a class="input-group-addon blue" data-toggle="modal" href="#purchasing"><i class="fa fa-search"></i></a>
                          <input type="text" id="invoice_number" name="invoice_number" onkeypress="return valid_enter(event)" value="<?php echo $no_nota; ?>" class="form-control" <?php echo $readonly; ?> />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_invoice" name="tgl_invoice" class="form-control date target" onkeypress="return valid_enter(event)" value="<?php echo $tgl_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-2">
                        <?php
                        $style_currency = "class='form-control' id='currency' onchange='Rate_notfound()' required";
                        echo form_dropdown('Currency', $Currency, $currency, $style_currency);
                        ?>
                        <input type="hidden" id="currencyx" name="currency" class="form-control" onkeypress="return valid_enter(event)" value="<?php echo $currency; ?>" <?php echo $readonly; ?> required />
                      </div>
                      <div id="daftar_kurs">
                        <label class="control-label col-md-1">Rate</label>
                        <div class="col-md-2">
                          <input type="text" id="rate_currency" name="rate" value="<?php echo $rate; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
                        </div>
                        <label class="control-label col-md-2">Rate SGD</label>
                        <div class="col-md-2">
                          <input type="text" id="rate_sgd" name="rate_sgd" value="<?php echo $rate_sgd; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" readonly />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Total Invoice</label>
                      <div class="col-md-2">
                        <input type="text" id="total" name="total" value="<?php echo $total; ?>" onkeyup="masukan_jumlah()" onblur="konfersi_angka()" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" required />
                        <input type="hidden" id="piutang" name="piutang" value="<?php echo $total; ?>" />
                      </div>
                      <label class="control-l  sabel col-md-1">GST</label>
                      <div class="col-md-2">
                        <input type="text" class="form-control" value="<?php echo $gstvalue; ?>" id="GstValue" readonly onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="GstValue" />
                      </div>
                      <label class="control-label col-md-2">Total Amount</label>
                      <div class="col-md-2">
                        <input type="text" class="form-control" value="<?php echo $amount; ?>" id="amount" readonly onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="amount" />
                      </div>
                      <div class="col-md-2">
                        <input type="hidden" class="form-control" id="rate_akhir" name="rate_akhir" />
                      </div>
                      <div class="col-md-2">
                        <input type="hidden" class="form-control" id="tgl_rate_akhir" name="tgl_rate_akhir" />
                        <input type="hidden" class="form-control" id="term" name="term" />
                        <input type="hidden" class="form-control" id="nocoa" name="nomor_coa" />
                        <input type="hidden" class="form-control" id="verifikasi" name="verifikasi" value="TIDAK" />
                      </div>

                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="control-label col-md-3">Description</label>
                      <div class="col-md-9">
                        <textarea class="form-control autosizeme" name="description" id="description"><?php echo $keterangan; ?></textarea>
                      </div>
                      <span class="help-inline"></span>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                       <label class="col-md-3 label-sm" onclick="fnDialogMasterBank()" style="color: #0081c2;">Master Bank</label>
                      <div class="col-md-9">
                        <div id="pindahwaktu">
                          <textarea rows="4" class="form-control" name="paymentto" id="paymentto"><?= $paymentto ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Prepared By</label>
                        <div class="col-md-9">
                          <select name="prepared_by" id="prepared_by" class="form-control select2me" required>
                            <option value="" required>Please select</option>
                            <option value="nick" <?php if ($prepared_by === 'nick') {
                                                  echo 'SELECTED';
                                                } ?>>Nick</option>
                            <option value="ranny" <?php if ($prepared_by === 'ranny') {
                                                  echo 'SELECTED';
                                                } ?>>Ranny</option>
                            <option value="zanth" <?php if ($prepared_by === 'zanth') {
                                                  echo 'SELECTED';
                                                } ?>>Zanth</option>
                          </select>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="note note-success note-bordered" id="pesan_error" style="display: none;">
                  <p>
                    Please click the "Search Coa" and then click the "Save" button.
                  </p>
                </div>
                <hr />
              </div>
              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="2%">
                      <a class="green" data-toggle="modal" id="co" onclick=" if (document.getElementById('amount').value === '') {
                                                        return alert('Please insert amount first.');
                                                    }" href="#coa" title="Serch COA number"><i class="fa fa-search"></i></a>
                    </th>
                    <th width="10%">
                      Account Number
                    </th>
                    <th width="10%">
                      Department Code
                    </th>
                    <th width="20%">
                      Account Name
                    </th>
                    <th width="20%">
                      Description
                    </th>
                    <th width="8%">
                      Total
                    </th>
                    <th width="6%">
                      Rate
                    </th>
                    <th width="7%">
                      Debt
                    </th>
                    <th width="7%">
                      Credit
                    </th>
                    <th width="10%">
                      GST Type
                    </th>
                    <th width="10%">
                      GST Value
                    </th>
                  </tr>
                </thead>
                <tbody id="cid">
                  <?php
                  if (!empty($select_nota)) {
                    foreach ($select_nota as $q) {
                      $Debetz = number_format($q->Debet, 2, '.', ',');
                      $Kreditz = number_format($q->Kredit, 2, '.', ',');
                    }
                  } else {
                    $Debetz = 0;
                    $Kreditz = 0;
                  }
                  ?>
                  <tr style="background: #cccccc; font-weight: bold">
                    <td colspan="7">Grand Total</td>
                    <td><input type="text" name="nota_debet" class="spesial_text" id="nota_debet" value="<?php echo $Debetz; ?>" /></td>
                    <td><input type="text" name="nota_credit" class="spesial_text" id="nota_credit" value="<?php echo $Kreditz; ?>" readonly /></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  $style = 'style="display:none"';

                  if (!empty($select_jurnal)) {
                    $no = 1;

                    $gstdetail = 0;
                    $gstjenis = '';
                    $gsturut = 0;
                    $gsttotal = 0;
                    $gstrate = 0;
                    $gstdebt = 0;
                    $gstcredit = 0;

                    foreach ($select_jurnal as $v) {
                      // if ($this->input->get('jenis') == 'CCN') {
                      //     if ($v->Kredit > 0) {
                      //         $jenisID = 'C';
                      //     } else {
                      //         $jenisID = 'D';
                      //     }
                      // } else {
                      //     if ($v->Debet > 0) {
                      //         $jenisID = 'D';
                      //     } else {
                      //         $jenisID = 'C';
                      //     }
                      // }

                      if ($v->NoCOA != '400101') {
                  ?>
                        <tr>
                          <td><a class="tombol" onclick="hapus_baris(this)">Remove</a>
                            <input type="hidden" name="txtID[]" class="txt" value="<?php echo $v->DetailID; ?>" readonly />
                            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="<?php echo $v->chk; ?>" />
                            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="<?php echo $v->NoUrut; ?>" />
                          </td>
                          <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="<?php echo $v->NoCOA; ?>" readonly /></td>
                          <td><input type="text" name="txtDeptCode[]" class="txt" value="<?php echo $v->dept_code; ?>" readonly /></td>
                          <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->account_name; ?>" readonly /></td>
                          <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt"><?php echo $v->Uraian; ?></textarea></td>
                          <td><input type="text" name="txtTotal[]" id='total_ccdn' class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="<?php echo number_format($v->Total, 2, '.', ','); ?>" /></td>
                          <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate<?php echo $no++; ?>" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Rate, 6, '.', ','); ?>" readonly /></td>
                          <td><input type="text" name="txtDebt[]" id='debt_ccdn' class="txt number txtDebt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Debet, 2, '.', ','); ?>" readonly /></td>
                          <td><input type="text" name="txtCredit[]" id='credit_ccdn' class="txt number txtCredit" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Kredit, 2, '.', ','); ?>" readonly /></td>
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
                          <td><input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" value="<?php echo $v->gst_value; ?>" /></td>
                        </tr>
                      <?php
                      } else {
                        $style = '';
                        $gstdetail = $v->DetailID;
                        $gstjenis = $v->chk;
                        $gsturut = $v->NoUrut;
                        $gsttotal = $v->Total;
                        $gstrate = $v->Rate;
                        $gstdebt = $v->Debet;
                        $gstcredit = $v->Kredit;
                      }
                      ?>
                </tbody>
              <?php
                    }
              ?>
              <tfoot>
                <tr id="trGST" <?php echo $style; ?>>
                  <td>
                    <input type="hidden" name="txtID[]" class="txt" value="<?php echo $gstdetail; ?>" readonly />
                    <input type="hidden" name="txtJenisID[]" id="jenis_gst" class="txt JenisID" value="<?php echo $gstjenis; ?>" />
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="<?php echo $gsturut; ?>" />
                  </td>
                  <td><input type="text" name="txtAccountNo[]" class="txt no_coa" id="nocoaGST" value="400101" readonly /></td>
                  <td><input type="text" name="txtDeptCode[]" class="txt dept_code" value="000" readonly /></td>
                  <td><input type="text" name="txtAccountName[]" class="txt" id="AccountGST" value="GST Output Tax" readonly /></td>
                  <td><input type="text" name="txtDesc[]" class="txt" id="descGst" value="GST Output Tax" /></td>
                  <td><input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotalGst" value="<?php echo number_format($gsttotal, 2, '.', ','); ?>" readonly /></td>
                  <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate_gst" value="<?php echo number_format($gstrate, 6, '.', ','); ?>" readonly /></td>
                  <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debtGst" value="<?php echo number_format($gstdebt, 2, '.', ','); ?>" readonly /></td>
                  <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="creditGst" value="<?php echo number_format($gstcredit, 2, '.', ','); ?>" readonly /></td>
                  <td><input type="text" name="txtGST[]" class="txt txtGST" id="txtGSTName" readonly /></td>
                  <td><input type="text" name="txtGSTValue[]" class="txt number txtGSTValue" id="txtGSTValue" readonly /></td>
                </tr>
              </tfoot>
            <?php
                  } else {
            ?>
              </tbody>
              <tfoot>
                <tr id="trGST" style="display:none">
                  <td>
                    <input type="hidden" name="txtID[]" class="txt" value="0" readonly />
                    <input type="hidden" name="txtJenisID[]" id="jenis_gst" class="txt JenisID" />
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0" />
                  </td>
                  <td><input type="text" name="txtAccountNo[]" class="txt no_coa" id="nocoaGST" value="400101" readonly /></td>
                  <td><input type="text" name="txtDeptCode[]" class="txt dept_code" value="000" readonly /></td>
                  <td><input type="text" name="txtAccountName[]" class="txt" id="AccountGST" value="GST Output Tax" readonly /></td>
                  <td><input type="text" name="txtDesc[]" class="txt" id="descGst" value="GST Output Tax" /></td>
                  <td><input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotalGst" readonly /></td>
                  <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate_gst" readonly /></td>
                  <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debtGst" readonly /></td>
                  <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="creditGst" readonly /></td>
                  <td><input type="text" name="txtGST[]" class="txt txtGST" id="txtGSTName" readonly /></td>
                  <td><input type="text" name="txtGSTValue[]" class="txt number txtGSTValue" id="txtGSTValue" readonly /></td>
                </tr>
              </tfoot>
            <?php } ?>
              </table>
              <hr />
              <!-- <a class="btn btn-danger" onclick="kalkulasi()"><i class="fa fa-refresh"></i> Calculate GST</a> -->
              <button class="btn btn-default" id="btnFindRecord" type="button">
                Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>

              <button type="submit" name="sbt" id="sbt" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-default" href="<?php echo base_url(); ?>ccdn/add_new"><i class="fa fa-plus"></i> Add New</a>
              <a class="btn btn-primary" id="cetak" href="<?php echo base_url(); ?>ccdn/print_ccdn?id=<?php echo $this->input->get('id'); ?>&jenis=<?php echo $this->input->get('jenis') ?>&st=<?= $kat; ?>&cur=<?php echo $this->input->get('cur') ?>&signature=Mr. Tahir Bin Abdul Aziz" target="_BLANK"><i class="fa fa-print"></i> Print</a>
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-warning kanan" href="<?php echo base_url(); ?>ccdn"><i class="fa fa-warning"></i> Cancel</a>
                <a class="btn red kanan" href="<?php echo base_url(); ?>ccdn/hapus?id=<?php echo $this->input->get('id'); ?>"><i class="fa fa-trash"></i> Delete</a>

                <div class="col-md-2 kanan">
                  <select name="signiture" onchange="ganti_signature()" id="signature" class="form-control kanan">
                    <option value="Mr. Tahir Bin Abdul Aziz">Mr. Tahir Bin Abdul Aziz</option>
                    <option value="Ms.  Cindy Lew">Ms. Cindy Lew </option>
                    <option value="Mr. Nick Chung">Mr. Nick Chung </option>
                  </select>
                </div>
                <script type="text/javascript">
                  function ganti_signature() {
                    var cetak = document.getElementById('cetak');
                    var locAppend = $('#signature').find('option:selected').val(),
                      locSnip = window.location.href.split('edit')[0];
                    cetak.href = locSnip + "print_ccdn?id=<?php echo $this->input->get('id'); ?>&jenis=<?php echo $this->input->get('jenis') ?>&st=<?= $kat; ?>&cur=<?php echo $this->input->get('cur') ?>&signature=" + locAppend;
                  }
                </script>
              <?php } ?>
              <script>
                // function checkreff() {
                //     var reff = document.getElementById("refno").value;
                //     var tgl1 = document.getElementById("tgl_tempo").value;
                //     var tgl = tgl1.split("/");
                //     var tahun = tgl[2];

                //     $.ajax({
                //         url: "<?php echo base_url(); ?>ccdn/cek_noref?reff=" + reff.substring(0,5) + "&tahun=" + tahun,
                //         success: function (e) {
                //             alert(e);
                //             return false;
                //         }
                //     }
                //     );

                // var a = document.getElementById('inputAmountDebit').value;
                // var b = document.getElementById('inputAmountCredit').value;

                // if (a !== b) {
                //     document.getElementById('alert-balanceAmount').style.display = 'block';
                //     return false;
                // } else {
                //     document.getElementById('alert-balanceAmount').style.display = 'none';
                // }
                // }
              </script>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="purchasing" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of vendor transaction</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabel-1">
          <thead>
            <th>Reff. Number</th>
            <th>Date of Journal</th>
            <th>Invoice Date</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Currency</th>
            <th>Rate</th>
            <th>Total</th>
            <th>Credit</th>
            <th>Term</th>
            <th>COA Account</th>
            <th style="display: none">Rate SGD</th>
          </thead>
          <tbody>
            <?php
            if (!empty($List_piutang)) {
              foreach ($List_piutang as $s) {
                setlocale(LC_MONETARY, "en_US");
                $tgl_jurnal = date_format(date_create($s->tanggal), "m/d/Y");
                $tgl_invoice = date_format(date_create($s->tanggal_invoice), "m/d/Y");
            ?>
                <tr onclick="pilih(this)" style="cursor: pointer;">
                  <td><?php echo $s->nofaktur; ?></td>
                  <td><?php echo $tgl_jurnal; ?></td>
                  <td><?php echo $tgl_invoice; ?></td>
                  <td><?php echo $s->kode_sup; ?></td>
                  <td><?php echo strtoupper($s->namacustomer); ?></td>
                  <td><?php echo $s->currency; ?></td>
                  <td><?php echo $s->rate; ?></td>
                  <td><?php echo number_format($s->piutang, 2, '.', ','); ?></td>
                  <td><?php echo number_format($s->nota_kredit, 2, '.', ','); ?></td>
                  <td><?php echo $s->term; ?> Days</td>
                  <td><?php echo $s->coa; ?></td>
                  <td style="display: none"><?php echo $s->rate_sgd; ?></td>
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

<div class="modal fade" id="marketing" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Customer Marketing transaction</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabel-1">
          <thead>
            <th>Reff. Number</th>
            <th>Date of Journal</th>
            <th>Invoice Date</th>
            <th>Costumer ID</th>
            <th>Costumer Name</th>
            <th>Currency</th>
            <th>Rate</th>
            <th>Total</th>
            <th>Credit</th>
            <th>Term</th>
            <th>COA Account</th>
            <th>Rate SGD</th>
          </thead>
          <tbody>
            <?php
            if (!empty($List_piutang)) {
              foreach ($List_piutang as $s) {
                $tgl_jurnal = date_format(date_create($s->tanggal), "m/d/Y");
                $tgl_invoice = date_format(date_create($s->tanggal_invoice), "m/d/Y");
            ?>
                <tr onclick="pilih(this)" style="cursor: pointer;">
                  <td><?php echo $s->nofaktur; ?></td>
                  <td><?php echo $tgl_jurnal; ?></td>
                  <td><?php echo $tgl_invoice; ?></td>
                  <td><?php echo $s->kode_sup; ?></td>
                  <td><?php echo strtoupper($s->suppliercompany); ?></td>
                  <td><?php echo $s->currency_id; ?></td>
                  <td><?php echo $s->rate; ?></td>
                  <td><?php echo number_format($s->piutang, 2, '.', ','); ?></td>
                  <td><?php echo number_format($s->nota_kredit, 2, '.', ','); ?></td>
                  <td><?php echo $s->term; ?> Days</td>
                  <td><?php echo $s->coa; ?></td>
                  <td><?php echo $s->rate_sgd; ?></td>
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
<div class="modal fade" id="konfirmasi" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h5 class="modal-title">
          Are you sure change the type Customer Credit and Debit Note?
          <br />

        </h5>
      </div>
      <div class="modal-body">
        If you click OK, the transaction will start from first time.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn blue" id="cancel_ok">Cancel</button>
        <button type="button" class="btn red" id="ok_ulang">OK</button>
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
      </div>
      <div class="modal-body">
        Select Account Type :
        <select name="select_ccdn" class="form-control" id="mySelect">
          <option value="Credit">Credit</option>
          <option value="Debet">Debit</option>
        </select>
        Search COA:
        <input class="form-control" type="text" id="search" placeholder="search">
        <section class="">
          <div class="contain">
            <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa" width="100%">
              <thead>
                <tr class="header">
                  <th>No. COA<div>No. COA</div>
                  </th>
                  <th>Account Name<div>Account Name</div>
                  </th>
                  <th>Group COA <div>Account Number</div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <?php
                if (!empty($List_coa)) {
                  foreach ($List_coa as $s) {
                ?>
                    <tr onclick="ambil(this)" style="cursor: pointer;">
                      <td width="27%"><?php echo $s->Kombinasi_COA; ?></td>
                      <td><?php echo $s->AccountName; ?></td>
                      <td><?php echo $s->GroupCOA; ?></td>
                      <td hidden><?php echo $s->sub_account_type; ?></td>
                      <td hidden><?php echo $s->NoCOA; ?></td>
                      <td hidden><?php echo $s->kode_department; ?></td>
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
<div id="formdialogMasterBank"></div>
<script type="text/javascript">
  $(document).ready(function(){
    var tgl = $('#closing').val();
    console.log(tgl);
    $('.target').datepicker({
      'autoclose': true,
      'todayHighlight': !0,
      'startDate': tgl,
      'orientation': "top left",
      'format': ('dd/mm/yyyy')
    });

    var dateTempo = $('#tgl_tempo').val();

    if(dateTempo){
        var partsDateTempo = dateTempo.split('/');
        var partsClosing = tgl.split('/');

        var yearDateTempo = parseInt(partsDateTempo[2], 10);
        var yearClosing = parseInt(partsClosing[2], 10);

        if(yearDateTempo < yearClosing){
            $('#tgl_tempo').prop('disabled', true);
            $('#tgl_invoice').prop('disabled', true);
            $('#sbt').prop('disabled', true);
        }
    }
  });

  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Ccdn/selectInvoiceCCDN", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });

  function fnDialogMasterBank() {
    // HTML content with proper formatting
    var dialogContent = `
                <div class='portlet-body'>
                    <div class='table-scrollable' style='overflow: auto; height:150px;'>
                        <table id='tbl-masterbank' class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Account No</th>
                                    <th>Name</th>
                                    <th>Currency</th>
                                </tr>
                            </thead>
                            <tbody id='tblmasterbank'>
                                <?php foreach ($bank as $r) : ?>
                                    <tr ondblclick="clickmasterBank(this)" style="cursor: pointer;">
                                        <td nowrap><?= $r->bank_account_number ?></td>
                                        <td nowrap><?= $r->bank_name ?></td>
                                        <td nowrap><?= $r->bank_currency_id ?></td>
                                 <td hidden><textarea><?= ltrim($r->bank_name) . '&#10;' . 'SWIFT: ' . $r->bank_swift . '&#10;' . $r->bank_currency_id . ' Account No: ' . $r->bank_account_number . '&#10;' . 'for Account of Zhenghe Logistic Pte Ltd' . (($r->swift_intermediary != '') ? '&#10;' . 'Intermediary Bank ' . $r->intermediary  . '&#10;' . 'SWIFT: ' . $r->swift_intermediary : '') ?>
                                </textarea>
                                 </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class='col-md-12' style='margin-left: -15px; margin-bottom: 20px;'>
                        <textarea class='form-control ckeditor' id='txtmasterbank' style='width: 770px; height: 131px;'></textarea>
                    </div>
                    <div class='col-md-6'>
                        <button type='button' class='col-md-4 btn blue' onclick='choose_bankmaster()'>Sent</button>
                        <button type='button' class='col-md-4 btn grey' onclick='close_bankmaster()'>Close</button>
                    </div>
                </div>
            `;

    // Set HTML content to the dialog
    $("#formdialogMasterBank").html(dialogContent);

    // Define the Dialog and its properties.
    $("#formdialogMasterBank").dialog({
      resizable: false,
      modal: true,
      title: "Remit Master Bank",
      top: 5,
      height: 500,
      width: 800
    });

    // Set the value of txtpayment
    $("#txtmasterbank").val($("#paymentto").val());
  }
  function close_bankmaster() {
    $("#formdialogMasterBank").dialog("close");
  }
  function choose_bankmaster() {
    document.getElementById('paymentto').value = document.getElementById('txtmasterbank').value;
    $("#formdialogMasterBank").dialog("close");
  }

  function clickmasterBank(x) {

    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    let $r = x.rowIndex;
    document.getElementById('txtmasterbank').value = getText(document.getElementById('tbl-masterbank').rows[$r].cells[3]);
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

</script>