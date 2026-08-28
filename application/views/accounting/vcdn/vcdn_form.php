<script>
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

  //         if (jenis.value === 'VDN') {
  //             if ((Number(amount.value) > Number(total.value))) {
  //                 alert('Value can not exceed the total invoice. Please select your type transaction!');
  //                 amount.value = 0;
  //                 total.value = piutang.value;
  //                 return false;
  //             } else {
  //                 if (jenis.value === 'VCN') {
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
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //                 </tr><tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" id="no_coa1"  class="txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value.toFixed(2) + '" readonly /></td>\n\
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
  //             if (jenis.value === 'VCN') {
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
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //                 </tr><tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" class="no_coa1 txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" id="nama_coa1"  class="nama_coa txt" value="" />\n\
  //                 <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
  //             <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
  //             <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
  //             <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value.toFixed(2) + '" readonly /></td>\n\
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
    document.getElementById('rate_vcdn').value = res[0];
  }

  $(document).ready(function() {
    $("#tabel_coa").dataTable({
      "scrollY": 300,
      "scrollX": true
    });

    var jenis = document.getElementById("jenis");
    if (document.getElementById('debit').checked === true) {
      jenis.value = 'VDN';
      return false;
    } else {
      jenis.value = 'VCN';
      return false;
    }
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
    var infor = '';
    var jenistxt = '';
    if (jenis.value === 'VDN') {
      infor = 'Debit Note for ' + y[x].text;
      jenistxt = 'C';
    } else if (jenis.value === 'VCN') {
      infor = 'Credit Note for ' + y[x].text;
      jenistxt = 'D';
    }
    $.ajax({
      url: "<?php echo base_url(); ?>Vcdn/account_number?id=" + res[1],
      success: function(response) {
        $("#cari_akun").html(response);
      },
      dataType: "html"
    });

    // document.getElementById("tabel").deleteRow(-1);

    var x = document.getElementById("tabel").rows.length;
    if (x > 3) {
      document.getElementById("tabel").deleteRow(-1);
      document.getElementById("tabel").deleteRow(-2);
    }


    $('table[id="tabel"]').append('<tr class="myRow">\n\
        <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="' + jenistxt + '"/>\n\
            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
        <td><input type="text" name="txtAccountNo[]" id="account_vcdn"  class="txt" value="' + res[1] + '" required/></td>\n\
        <td><input type="text" name="txtDeptCode[]" class="txt no_coa" value="000" readonly required/></td>\n\
        <td><div id="cari_akun"></div></td>\n\
        <td><input type="text" name="txtDesc[]"   id="desc_vcdn" class="txt" value="' + infor + '" /></td>\n\
        <td><input type="text" name="txtTotal[]"  class="txt number txtTotal txtTotalx" id="total_vcdn" onkeyup="hitung_vcdn(this)" value="' + 0 + '" /></td>\n\
        <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate1" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debt_vcdn" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="credit_vcdn" onkeypress="return isNumber(event)"  value="' + 0 + '"  /><td><input type="hidden" name="txtGST[]" class="txtGST"></td>\n\
                <td><input type="hidden" name="txtGSTValue[]" class="txtGSTValue"></td></tr>');


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

    if (jenis.value === 'VDN') {
      infor = 'Debit Note for ' + suplier_code;
      jenistxt = 'C';
    } else if (jenis.value === 'VCN') {
      infor = 'Credit Note for ' + suplier_code;
      jenistxt = 'D';
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
        <td><input type="text" name="txtAccountNo[]" class="txt" value="' + coa + '" required/></td>\n\
        <td><input type="text" name="txtAccountName[]" class="txt" value="Trade Accounts Payable"  /></td>\n\
        <td><input type="text" name="txtDesc[]" class="txt" value="' + infor + '" /></td>\n\
        <td><input type="text" name="txtTotal[]" class="txt number txtTotal txtTotalx" id="total_vcdn" onkeyup="hitung_vcdn(this)" value="0" /></td>\n\
        <td><input type="text" name="txtRate[]" class="txt number txtRate" id="rate_vcdn" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debt_vcdn" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="credit_vcdn" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
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
    var select_vcdn = document.getElementById("mySelect");
    var jenis = document.getElementById("jenis");
    document.getElementById("verifikasi").value = "YA";
    var num = 1;
    var or = amount * rate_currency;

    for (var i = 0; i < num; i++) {
      if (select_vcdn.value === "Credit") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="C"/> \n\
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + AccDept + '" /></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn(this)" value="' + amount + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + or.toFixed(2) + '"  /></td>\n\
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
      } else if (select_vcdn.value === "Debet") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="D"/>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtDeptCode[]" class="txt" value="' + AccDept + '" /></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn(this)" value="' + amount + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + or.toFixed(2) + '"  /></td>\n\
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
    var account1 = document.getElementById('account_vcdn').value;
    var txtAccountName1 = document.getElementById('txtAccountName1').value;
    var desc_vcdn = document.getElementById('desc_vcdn').value;
    var jr_rate1 = document.getElementById('jr_rate1').value;
    var credit_vcdn = document.getElementById('credit_vcdn').value;
    var GstValue = document.getElementById('GstValue').value;
    var jenis = document.getElementById('jenis').value;
    var or = GstValue * jr_rate1;
    var no_coa = '200801';
    var nm_coa = 'GST Ouput Tax';

    var num = 1;

    if (GstValue > 0) {
      for (var i = 0; i < num; i++) {
        var txtCredit = GstValue * jr_rate1;
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="' + account1 + '" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + txtAccountName1 + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="D" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt" value="' + desc_vcdn + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + GstValue + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + jr_rate1 + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + or.toFixed(2) + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + 0 + '" readonly /></td>\n\
                <td><input type="hidden" name="txtGST[]"  class="txtGST"></td>\n\
                <td><input type="hidden" name="txtGSTValue[]"  class="txtGSTValue"></td>\n\
        </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="' + no_coa + '" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + nm_coa + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="C" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt" value="' + desc_vcdn + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="' + GstValue + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + jr_rate1 + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + 0 + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + or.toFixed(2) + '" readonly /></td>\n\
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
  //     var jenis =  document.getElementById('jenis').value;
  //     var num = 1;
  //     for (var i = 0; i < num; i++) {
  //         $('table[id="tabel"]').append('<tr>\n\
  //             <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
  //             <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="" required/></td>\n\
  //             <td><input type="text" name="txtAccountName[]" class="txt" value="" /></td>\n\
  //             <td><input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VDN" required/></td>\n\
  //             <td><input type="text" name="txtDesc[]" class="txt" value="" /></td>\n\
  //             <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn()" value="0" /></td>\n\
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
    var total = document.getElementById('total');
    var GstValue = document.getElementById('GstValue');
    var debit = document.getElementsByClassName("txtDebt");
    var credit = document.getElementsByClassName("txtCredit");
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];

    var jenisTxt = '';
    if (jenis.value === 'VDN') {
      jenisTxt = 'D';
    } else if (jenis.value === 'VCN') {
      jenisTxt = 'C';
    }

    total.value = total.value.replace(",", "");
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
            var total = sgd_txt * 9 / 100;
            gst_value[i].value = total.toFixed(2);
            trGST.style.display = "";
          } else {
            var total = sgd_txt * 8 / 100;
            gst_value[i].value = total.toFixed(2);
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

    GstValue.value = addCommas(sum1);

    if (txtTotalGst === 'undefined') {
      txtTotalGst.value = '0';
    } else {
      txtTotalGst.value = sum1;
    }
    var x = document.getElementById('GstValue').value;

    if (x === 'undefined') {
      document.getElementById('trGST').style.display = "none";
      document.getElementById('GstValue').value = 0;
    } else {
      document.getElementById('amount').value = parseFloat(document.getElementById('total').value) + sum1;
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
    GstValue.value = sumX;
    amount.value = (parseFloat(document.getElementById('total').value) + sumX).toFixed(2);

  }

  function masukan_jumlah() {
    var amount = document.getElementById("amount");
    var totalawal = document.getElementById("total").value;
    var total = document.getElementById("total_vcdn");
    var rate = document.getElementById("rate_currency");
    var debit = document.getElementById("debt_vcdn");
    var credit = document.getElementById("credit_vcdn");
    var totalx = document.getElementsByClassName("txtTotal");
    var jenis = document.getElementById("jenis");
    var rows = totalx.length;
    var or = 0;
    //        if (rows > 1) {
    //            alert('Please delete the one row in the table below!');
    //        } else {
    total.value = totalawal;
    amount.value = totalawal;
    //        }
    debit.value = debit.value.replace(",", "");
    credit.value = credit.value.replace(",", "");

    if (jenis.value === 'VDN') {
      debit.value = 0;
      or = total.value * rate.value;
      credit.value = or.toFixed(2);
    } else if (jenis.value === 'VCN') {
      credit.value = 0;
      or = total.value * rate.value;
      debit.value = or.toFixed(2);
    }
    // hitung_vcdn();
  }

  function hitung_vcdn() {
    var total = document.getElementsByClassName('txtTotal');
    var jur_det = document.getElementsByClassName('txtDebt');
    var rate = document.getElementById('rate_currency');
    var jur_credit = document.getElementsByClassName('txtCredit');
    var jenis = document.getElementsByClassName('JenisID');
    var amount = document.getElementById('amount');
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
    document.getElementById('total').value = total1;

    cek_gst();
  }

  function debt() {
    var jenis = document.getElementById("jenis");
    if (document.getElementById('debit').checked === true) {
      jenis.value = 'VDN';
      document.getElementById("mySelect").selectedIndex = "VDN";
      return false;
    } else {
      jenis.value = 'VCN';
      document.getElementById("mySelect").selectedIndex = "VCN";
      return false;
    }
  }

  function ambil_tabel() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>vcdn/cek_tabel?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
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
if (!empty($select_vcdn)) {
  $gstvalue = 0;
  foreach ($select_vcdn as $s) {
    $nofaktur = $s->no_reff;
    $tgl = date('d/m/Y', strtotime($s->tanggal));
    $no_nota = $s->no_nota;
    $tgl_invoice = date('d/m/Y', strtotime($s->tanggal_invoice));
    $total = number_format($s->hutang, 2, '.', ',');
    $gstvalue += $s->gst_value;
    $amount = number_format($s->hutang + $gstvalue, 2, '.', ',');
    $jenis = $s->jenis_debit_kredit;
    $currency = $s->Currency;
    $currency_id = $s->Rate . "|" . $s->rate_sgd . "|" . $s->Currency;
    $rate = number_format($s->Rate, 6, '.', ',');
    $rate_sgd = number_format($s->rate_sgd, 6, '.', ',');
    $keterangan = $s->Keterangan;
    $nama_sup = $s->nama_sup;
    $kode_sup = $s->kode_sup;
    $coa_sup = $s->NoCOA;
    $account_name = $s->account_name;
    $gst_type = $s->gst_type;
    $paymentto = $s->paymentto;
    $prepared_by = $s->prepared_by;
    $disable = "disabled";
    $readonly = "readonly";
    $submit_value = 'Update';
  }
} else {
  // if (isset($_GET['id'])) {
  //   // echo $id;
  //   $gstvalue = 0;
  //   foreach ($select_vcdn2 as $r) {
  //     $nofaktur = $r->no_reff;
  //     $tgl = date('d/m/Y', strtotime($r->tanggal));
  //     $no_nota = $r->no_nota;
  //     $tgl_invoice = date('d/m/Y', strtotime($r->tanggal));
  //     $gstvalue += $r->gst_value;
  //     $total = number_format(abs($r->total), 2, '.', ',');
  //     $amount = number_format(abs($r->total) + $gstvalue, 2, '.', ',');
  //     $jenis = $r->jenis_debit_kredit;
  //     $currency = $r->currency;
  //     $currency_id = $r->currency_rate . "|" . $r->currency_rate . "|" . $r->currency;
  //     $rate = $r->currency_rate;
  //     $rate_sgd = $r->currency_rate;
  //     $keterangan = $r->keterangan;
  //     $nama_sup = $r->nama_sup;
  //     $kode_sup = $r->kode_sup;
  //     $paymentto = '';
  //     $coa_sup = "";
  //     $account_name = "";
  //     $gst_type = "";
  //     $disable = "disabled";
  //     $readonly = "readonly";
  //     $submit_value = '-';
  //     $kat = 3;
  //   }
  // } else {
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
    $nama_sup = "";
    $readonly = "";
    $coa_sup = "";
    $gst_type = "";
    $disable = "";
    $paymentto = "";
    $prepared_by = "";
    $submit_value = 'Save';
  // }
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form id="myForm" action="<?php echo base_url(); ?>Vcdn/action" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
          <input type="hidden" id="closing" name="closing" value="<?php echo $closing; ?>" />
          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Vendor Credit and Debit Note</span>
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
                          <input type="radio" name="type" id="debit" value="debit" <?php
                                                                                    if ($jenis == 'VDN') {
                                                                                      echo "checked";
                                                                                    }
                                                                                    ?> onclick="debt()"><label for="debit"> Debt Note</label>
                          <input type="radio" name="type" id="credit" value="Credit" <?php
                                                                                      if ($jenis == 'VCN') {
                                                                                        echo "checked";
                                                                                      }
                                                                                      ?> onclick="debt()"><label for="credit"> Credit Note</label>
                          <input type="hidden" name="JenisJurnal" id="jenis" value="<?php echo "$jenis"; ?>" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Reff. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo "$nofaktur"; ?>" onkeypress="return valid_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <label class="CurID"></label>
                      </div>
                    </div><br />
                    <div class="form-group">
                      <label class="control-label col-md-3">Vendor</label>
                      <div class="col-md-9">
                        <?php
                        $style_supplier = "class='select2me form-control' id='SupSelect' onchange='get_sup()' $disable";
                        echo form_dropdown('suppliered', $SupplierID, $kode_sup, $style_supplier);
                        ?>
                        <input type="hidden" id="suplier_code" name="kode_sup" value="<?php echo $kode_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="suplier_name" name="nama_sup" value="<?php echo $nama_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <input type="hidden" id="suplier_coa" name="suplier_coa" value="<?php echo $coa_sup; ?>" onkeypress="return validasi_enter(event)" class="form-control" <?php echo $readonly; ?> />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="tanggal" class="form-control date target" onchange="Rate_notfound();" onkeypress="return valid_enter(event)" value="<?php echo "$tgl"; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
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
                        $style_currency = "class='form-control' id='currency' onchange='Rate_notfound();' required";
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
                          <input type="text" id="rate_sgd" name="rate_sgd" value="<?php echo $rate_sgd; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Total Invoice</label>
                      <div class="col-md-2">
                        <input type="text" id="total" name="total" value="<?php echo $total; ?>" onkeyup="masukan_jumlah()" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" required />
                        <input type="hidden" id="piutang" name="piutang" value="<?php echo $total; ?>" />
                      </div>
                      <label class="control-label col-md-1">GST</label>
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
                    <th width="17%">
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
                    <th width="12%">
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
                    <td><input type="text" name="nota_debet" class="spesial_text" id="nota_debet" value="<?php echo $Debetz; ?>" readonly /></td>
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
                      // if ($this->input->get('jenis') == 'VDN') {
                      //      if ($v->Debet == 0) {
                      //          $jenisID = 'D';
                      //      } else {
                      //          $jenisID = 'C';
                      //      }
                      //  } else {
                      //      if ($v->Debet == 0) {
                      //          $jenisID = 'C';
                      //      } else {
                      //          $jenisID = 'D';
                      //      }
                      //  }

                      if ($v->NoCOA != '300106') {
                  ?>
                        <tr>
                          <td><a type="button" onclick="hapus_baris(this)" class="tombol">Remove</a>
                            <input type="hidden" name="txtID[]" class="txt" value="<?php echo $v->DetailID; ?>" readonly />
                            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="<?php echo $v->chk; ?>" />
                            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="<?php echo $v->NoUrut; ?>" />
                          </td>
                          <td><input type="text" name="txtAccountNo[]" class="txt" value="<?php echo $v->NoCOA; ?>" readonly /></td>
                          <td><input type="text" name="txtDeptCode[]" class="txt" value="<?php echo $v->dept_code; ?>" readonly /></td>
                          <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->account_name; ?>" readonly /></td>
                          <td><input type="text" name="txtDesc[]" class="txt" value="<?php echo $v->Uraian; ?>" /></td>
                          <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeyup="hitung_vcdn(this)" value="<?php echo number_format($v->Total, 2, '.', ','); ?>" /></td>
                          <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate<?php echo $no++; ?>" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Rate, 6, '.', ','); ?>" readonly /></td>
                          <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Debet, 2, '.', ','); ?>" readonly /></td>
                          <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Kredit, 2, '.', ','); ?>" readonly /></td>
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
                  <td><input type="text" name="txtAccountNo[]" class="txt no_coa" id="nocoaGST" value="300106" readonly /></td>
                  <td><input type="text" name="txtDeptCode[]" class="txt" value="000" readonly /></td>
                  <td><input type="text" name="txtAccountName[]" class="txt" id="AccountGST" value="GST Input Tax" readonly /></td>
                  <td><input type="text" name="txtDesc[]" class="txt" id="descGst" value="GST Input Tax" /></td>
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
                <tr id="trGST" style="display: none">
                  <td>
                    <input type="hidden" name="txtID[]" class="txt" value="0" readonly />
                    <input type="hidden" name="txtJenisID[]" id="jenis_gst" class="txt JenisID" />
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0" />
                  </td>
                  <td><input type="text" name="txtAccountNo[]" class="txt no_coa" id="nocoaGST" value="300106" readonly /></td>
                  <td><input type="text" name="txtDeptCode[]" class="txt" value="000" readonly /></td>
                  <td><input type="text" name="txtAccountName[]" class="txt" id="AccountGST" value="GST Input Tax" readonly /></td>
                  <td><input type="text" name="txtDesc[]" class="txt" id="descGst" value="GST Input Tax" /></td>
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
              <!-- <a class="btn btn-danger" onclick="kalkulasi()" id ="calculateGST"><i class="fa fa-refresh"></i> Calculate GST</a> -->
              <button class="btn btn-default" id="btnFindRecord" type="button">
                Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>
              <button type="submit" name="sbt" id="save_btn" onclick="myFunction()" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-default" href="<?php echo base_url(); ?>vcdn/add_new"><i class="fa fa-plus"></i> Add New</a>

              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-warning kanan" href="<?php echo base_url(); ?>vcdn"><i class="fa fa-warning"></i> Cancel</a>
                <a class="btn red kanan" href="<?php echo base_url(); ?>vcdn/hapus?id=<?php echo urlencode($this->input->get('id')); ?>">
                    <i class="fa fa-trash"></i> Delete
                </a>
              <?php } ?>
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
            <th>Vendor ID</th>
            <th>Vendor Name</th>
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
        <h4 class="modal-title">List of Vendor Marketing transaction</h4>
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


<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Master COA</h4>
      </div>
      <div class="modal-body">
        Select Account Type :
        <select name="select_vcdn" class="form-control" id="mySelect">
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
            $('#save_btn').prop('disabled', true);
        }
    }
  });

  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Vcdn/selectInvoiceVCDN", function(data) {
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