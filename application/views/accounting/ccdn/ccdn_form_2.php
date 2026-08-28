<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
  }

  function KeyAmount(event) {
    var char = event.which || event.keyCode;
    if (char === 13) {
      var rate_currency = document.getElementById("rate_currency").value;
      var total = document.getElementById('total');
      var jenis = document.getElementById("jenis");
      var amount = document.getElementById('amount');
      var piutang = document.getElementById('piutang');
      var desc = document.getElementById('description').value;
      var sup = document.getElementById('suplier_code').value;

      if (jenis.value === 'CDN') {
        if ((Number(amount.value) > Number(total.value))) {
          alert('Value can not exceed the total invoice. Please select your type transaction!');
          amount.value = 0;
          total.value = piutang.value;
          return false;
        } else {
          if (jenis.value === 'CCN') {
            total.value = Number(total.value) + Number(amount.value);
          } else {
            total.value = total.value - amount.value;
          }

          $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa1" class="txt" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                    </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa1"  class="txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                 </tr>');

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

          return false;
        }
      } else {
        if (jenis.value === 'CCN') {
          total.value = Number(total.value) + Number(amount.value);
        } else {
          total.value = total.value - amount.value;
        }

        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa0"  class="no_coa txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa0"  class="nama_coa txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                    </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa1 txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1"  class="nama_coa txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                 </tr>');

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

        return false;
      }
    }
    if (char > 31 && (char < 46 || char > 57)) {
      return false;
    }
    return true;
  }


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

    var jenis = document.getElementById("jenis");
    if (document.getElementById('debit').checked === true) {
      jenis.value = 'CDN';
      return false;
    } else {
      jenis.value = 'CCN';
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
    if (jenis.value === 'VDN') {
      infor = 'Debit Note for ' + y[x].text;
    } else if (jenis.value === 'VCN') {
      infor = 'Credit Note for ' + y[x].text;
    }
    $.ajax({
      url: "<?php echo base_url(); ?>Vcdn/account_number?id=" + res[1],
      success: function(response) {
        $("#cari_akun").html(response);
      },
      dataType: "html"
    });
    var x = document.getElementById("tabel").rows.length;
    if (x > 2) {
      document.getElementById("tabel").deleteRow(-1);
    }
    var x = document.getElementById("tabel").rows.length;
    if (x > 2) {
      document.getElementById("tabel").deleteRow(-1);
    }


    $('table[id="tabel"]').append('<tr class="myRow">\n\
        <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
            <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN"/>\n\
            <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
        <td><input type="text" name="txtAccountNo[]" id="account_ccdn"  class="txt no_coa" value="' + res[1] + '" required/></td>\n\
        <td><div id="cari_akun"></div></td>\n\
        <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + infor + '</textarea></td>\n\
        <td><input type="text" name="txtTotal[]"  class="txt number txtTotal txtTotalx" id="total_ccdn" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + 0 + '" /></td>\n\
        <td><input type="text" name="txtRate[]" class="txt number txtRate" id="jr_rate1" onkeypress="return isNumber(event)"  value="' + rate + '" /></td>\n\
        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" id="debt_ccdn" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
        <td><input type="text" name="txtCredit[]" class="txt number txtCredit" id="credit_ccdn" onkeypress="return isNumber(event)"  value="' + 0 + '"  /><td><input type="hidden" name="txtGST[]" class="txtGST"></td>\n\
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
    if (jenis.value === 'CDN') {
      infor = 'Debit Note for ' + suplier_code;
      jenistxt = 'CDN';
    } else if (jenis.value === 'CCN') {
      infor = 'Credit Note for ' + suplier_code;
      jenistxt = 'CCN';
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
    var AccNo = getText(document.getElementById('tbl_coa').rows[$r].cells[0]);
    var AccNm = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);
    var rate_currency = document.getElementById("rate_currency").value;
    var amount = document.getElementById("total").value;
    var select_ccdn = document.getElementById("mySelect");
    document.getElementById("verifikasi").value = "YA";
    var gst_id = "kosong";

    var num = 1;
    for (var i = 0; i < num; i++) {
      if (select_ccdn.value === "credit") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CCN"/> \n\
                    <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal"  id="' + gst_id + '" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + amount + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="' + amount * rate_currency + '"  /></td>\n\
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
      } else if (select_ccdn.value === "Debt") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN"/>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="1"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt">' + desc + '</textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" ' + gst_id + '  onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="' + amount + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)"  value="' + rate_currency + '" /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount * rate_currency + '"  /></td>\n\
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
    var txtAccountName1 = document.getElementById('txtAccountName1').value;
    var desc_ccdn = document.getElementById('desc_ccdn').value;
    var jr_rate1 = document.getElementById('jr_rate1').value;
    var credit_ccdn = document.getElementById('credit_ccdn').value;
    var GstValue = document.getElementById('GstValue').value;
    var jenis = document.getElementById('jenis').value;
    var no_coa = '';
    var nm_coa = '';
    if (jenis === 'CCN') {
      no_coa = '140601';
      nm_coa = 'GST Input Tax';
    } else {
      no_coa = '200801';
      nm_coa = 'GST Ouput Tax';
    }
    var num = 1;

    if (GstValue > 0) {
      for (var i = 0; i < num; i++) {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button>\n\
                <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="0"/></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="' + account1 + '" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + txtAccountName1 + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
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
                <td><input type="text" name="txtAccountName[]" class="txt" value="' + nm_coa + '" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
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

  function tambah_baris() {
    var rate_currency = document.getElementById("rate_currency").value;
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="" /></td>\n\
                <td><input type="hidden" name="txtJenisID[]" class="txt JenisID" value="CDN" required/></td>\n\
                <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt"></textarea></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="0" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
        </tr>');
    }
  }

  function cek_gst() {
    //alert('tes');
    var qty = document.getElementsByClassName('txtTotal');
    var harga = document.getElementById('rate_sgd');
    var gst_type = document.getElementsByClassName('txtGST');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    var GstValue = document.getElementById('GstValue');

    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
    }

    for (var i = 0; i < qty.length; i++) {
      if (qty[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {
        var sgd_txt = qty[i].value * harga.value;
        if (gst_type[i].value === 'GST') {
          var total = sgd_txt * 7 / 100;
          gst_value[i].value = total.toFixed(2);

          var sum1 = 0;
          $(".txtGSTValue").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length !== 0) {
              sum1 += parseFloat(this.value);
            }
          });


        } else {
          gst_value[i].value = '0';
          var sum1 = 0;
          $(".txtGSTValue").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length !== 0) {
              sum1 += parseFloat(this.value);
            }
          });
        }

      }
    }
    //        var sum1 = 0;
    //        $(".no_coa").each(function () {
    //            if (!isNaN(this.value) && this.value === '200801') {
    //                //alert(this.value);
    //                $(".txtTotal").each(function () {
    //                    //add only if the value is number
    //                    if (!isNaN(this.value) && this.value.length !== 0) {
    //                        sum1 += parseFloat(this.value);
    //                    }
    //                });
    //            }
    //        });

    GstValue.value = sum1;

    var x = document.getElementById('GstValue').value;

    if (x === 'undefined') {
      document.getElementById('GstValue').value = 0;
    } else {
      document.getElementById('amount').value = Number(document.getElementById('total').value) + sum1;
    }
    //cari GST


  }

  function masukan_jumlah() {
    var amount = document.getElementById("amount");
    var totalawal = document.getElementById("total").value;
    var total = document.getElementById("total_ccdn");
    var rate = document.getElementById("rate_currency");
    var debit = document.getElementById("debt_ccdn");
    var credit = document.getElementById("credit_ccdn");
    var totalx = document.getElementsByClassName("txtTotal");
    var jenis = document.getElementById("jenis");
    var rows = totalx.length;
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
      credit.value = total.value * rate.value;
    } else if (jenis.value === 'VCN') {
      credit.value = 0;
      debit.value = total.value * rate.value;
    }
    hitung_vcdn();
  }

  function hitung_vcdn() {
    var total = document.getElementsByClassName('txtTotal');
    var jur_det = document.getElementsByClassName('txtDebt');
    var rate = document.getElementById('rate_currency');
    var jur_credit = document.getElementsByClassName('txtCredit');
    var jenis = document.getElementsByClassName('txtNoUrut');
    var amount = document.getElementById('amount');

    for (var i = 0; i < total.length; i++) {
      total[i].value = total[i].value.replace(",", "");
      total[i].value = total[i].value.replace(",", "");
      amount.value = amount.value.replace(",", "");
      var total_detail = total[i].value * rate.value;
      if (jenis[i].value === '1') {
        jur_credit[i].value = 0;
        jur_det[i].value = total_detail.toFixed(2);
      } else if (jenis[i].value === '0') {
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

    var totali = 0;
    if (total[2] == undefined) {
      totali = total[1].value;
    } else {
      total1 = Math.abs(total[1].value);
      total2 = Math.abs(total[2].value);
      totali = parseFloat(total1 + total2);
    }
    document.getElementById('nota_debet').value = sum2.toFixed(2);
    document.getElementById('total').value = totali;
    cek_gst();
  }


  function debt() {
    var jenis = document.getElementById("jenis");
    var id = document.getElementById("refno");
    var today = new Date();
    var b = ("0" + (today.getMonth() + 1)).slice(-2);
    var y = today.getFullYear();
    if (document.getElementById('debit').checked === true) {
      jenis.value = 'CDN';
      $.ajax({
        url: "<?php echo base_url(); ?>Ccdn/cek_noref",
        dataType: "json",
        success: function(e) {
          var ref = parseFloat(e);
          var no = ("00" + ref).slice(-3);
          id.value = 'DN' + no + '/' + b + "/" + y;
          document.getElementById("mySelect").selectedIndex = "0";
          return false;
        }
      });
    }
    if (document.getElementById('credit').checked === true) {
      jenis.value = 'CCN';
      $.ajax({
        url: "<?php echo base_url(); ?>Ccdn/cek_noref_credit",
        dataType: "json",
        success: function(e) {
          var ref = parseFloat(e);
          var no = ("00" + ref).slice(-3);
          id.value = 'CN' + no + '/' + b + "/" + y;
          document.getElementById("mySelect").selectedIndex = "1";
          return false;
        }
      });
    }
  }


  function ambil_tabel() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/ccdn/cek_tabel?id=" + refno,
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
</script>
<?php
if (!empty($select_ccdn)) {
  $gstvalue = 0;
  foreach ($select_ccdn as $s) {
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
    $rate = $s->Rate;
    $rate_sgd = $s->rate_sgd;
    $keterangan = $s->Keterangan;
    $nama_sup = $s->nama_sup;
    $kode_sup = $s->kode_sup;
    $coa_sup = $s->NoCOA;
    $account_name = $s->account_name;
    $gst_type = $s->gst_type;
    $disable = "disabled";
    $readonly = "readonly";
    $submit_value = 'Update';
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
  $rate = "";
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
  $submit_value = 'Save';
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form id="myForm" action="<?php echo base_url(); ?>index.php/ccdn/action" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">
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
                          <input type="radio" name="type" id="debit" value="debit" <?php
                                                                                    if ($jenis == 'CDN') {
                                                                                      echo "checked";
                                                                                    }
                                                                                    ?> onclick="debt()"><label for="debit"> Debt Note</label>
                          <input type="radio" name="type" id="credit" value="Credit" <?php
                                                                                      if ($jenis == 'CCN') {
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
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <?php
                        $style_supplier = "class=' form-control' id='SupSelect' onchange='get_sup()' $disable";
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
                        <input type="text" id="tgl_tempo" name="tanggal" class="form-control date date-picker" onkeypress="return valid_enter(event)" value="<?php echo "$tgl"; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
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
                        <input type="text" id="tgl_invoice" name="tgl_invoice" class="form-control date date-picker" onkeypress="return valid_enter(event)" value="<?php echo $tgl_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-2">
                        <?php
                        $style_currency = "class='form-control' id='currency' onchange='get_cur_cdn()' required";
                        echo form_dropdown('Currency', $Currency, $currency, $style_currency);
                        ?>
                        <input type="hidden" id="currencyx" name="currency" class="form-control" onkeypress="return valid_enter(event)" value="<?php echo $currency; ?>" <?php echo $readonly; ?> required />
                      </div>
                      <div id="daftar_kurs">
                        <label class="control-label col-md-1">Rate</label>
                        <div class="col-md-2">
                          <input type="text" id="rate_currency" name="rate" value="<?php echo $rate; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" required />
                        </div>
                        <label class="control-label col-md-2">Rate SGD</label>
                        <div class="col-md-2">
                          <input type="text" id="rate_sgd" name="rate_sgd" value="<?php echo $rate_sgd; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" required />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Total Invoice</label>
                      <div class="col-md-2">
                        <input type="text" id="total" name="total" value="<?php echo $total; ?>" onkeyup="masukan_jumlah()" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" required />
                        <input type="hidden" id="piutang" name="piutang" value="<?php echo $total; ?>" />
                      </div>
                      <!--<label class="control-l  sabel col-md-1">GST</label>-->
                      <div class="col-md-2">
                        <input type="hidden" class="form-control" value="<?php echo $gstvalue; ?>" id="GstValue" readonly onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="GstValue" />
                      </div>
                      <!--<label class="control-label col-md-2">Total Amount</label>-->
                      <div class="col-md-2">
                        <input type="hidden" class="form-control" value="<?php echo $amount; ?>" id="amount" readonly onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="amount" />
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
                    <td colspan="6">Grand Total</td>
                    <td><input type="text" name="nota_debet" class="spesial_text" id="nota_debet" value="<?php echo $Debetz; ?>" readonly /></td>
                    <td><input type="text" name="nota_credit" class="spesial_text" id="nota_credit" value="<?php echo $Kreditz; ?>" readonly /></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  if (!empty($select_jurnal)) {
                    $no = 1;
                    foreach ($select_jurnal as $v) {
                      if ($v->Debet == 0) {
                        $jenisID = 'CDN';
                      } else {
                        $jenisID = 'CCN';
                      }
                  ?>
                      <tr>
                        <td><a type="button" href="<?php echo base_url(); ?>ccdn/delete_detail?id=<?php echo $v->DetailID; ?>&nofak=<?php echo $v->NoJurnal; ?>" class="tombol">Remove</a>
                          <input type="hidden" name="txtID[]" class="txt" value="<?php echo $v->DetailID; ?>" readonly />
                          <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="<?php echo $jenisID; ?>" />
                          <input type="hidden" name="txtNoUrut[]" class="txt txtNoUrut" value="<?php echo $v->NoUrut; ?>" />
                        </td>
                        <td><input type="text" name="txtAccountNo[]" class="txt no_coa" value="<?php echo $v->NoCOA; ?>" readonly /></td>
                        <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->account_name; ?>" readonly /></td>
                        <td><textarea name="txtDesc[]" rows="1" cols="30" class="txt"><?php echo $v->Uraian; ?></textarea></td>
                        <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn(this)" value="<?php echo number_format($v->Total, 2, '.', ','); ?>" /></td>
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
                    }
                  }
                  ?>
                </tbody>
              </table>
              <hr />
              <a class="btn btn-danger" onclick="kalkulasi()"><i class="fa fa-refresh"></i> Calculate GST</a>

              <button type="submit" name="sbt" onclick="myFunction()" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/ccdn"><i class="fa fa-warning"></i> Cancel</a>
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-default" href="<?php echo base_url(); ?>index.php/ccdn/add_new"><i class="fa fa-plus"></i> Add New</a>
                <a class="btn red kanan" href="<?php echo base_url(); ?>index.php/ccdn/hapus?id=<?php echo $this->input->get('id'); ?>"><i class="fa fa-trash"></i> Delete</a>
                <a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>ccdn/print_ccdn?id=<?php echo $this->input->get('id'); ?>&jenis=<?php echo $this->input->get('jenis') ?>&cur=<?php echo $this->input->get('cur') ?>" target="_BLANK"><i class="fa fa-print"></i> Print</a>
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
          <option value="credit">Credit</option>
          <option value="Debt">Debit</option>
        </select>
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