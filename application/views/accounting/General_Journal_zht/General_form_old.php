<script>
  function validasi_enter(event) {
    var char = event.which || event.keyCode;
    if (char == 13) {
      // alert('a');
      return false;
    }
    return true;

  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
      return false;
    }
    return true;
  }

  function get_currency() {
    //var supp = document.getElementById('supplier').value;
    // var cur = document.getElementById('cur').value;
    // var res = cur.split("|");
    // document.getElementById('rate').value = res[0];
    // document.getElementById('curid').value = res[1];
    // alert('a');
    var curen = document.getElementById('currency').value;
    //alert(curen);
    var resi = curen.split("|");
    document.getElementById('rate_currency').value = resi[0];
    document.getElementById('curid').value = resi[1];
  }


  function KeyAmount(event) {
    var char = event.which || event.keyCode;
    if (char === 13) {
      var rate_currency = document.getElementById("rate_currency").value;
      var total = document.getElementById('total');
      var jenis = document.getElementById("jenis");
      var amount = document.getElementById('amount');
      var hutang = document.getElementById('hutang');
      var desc = document.getElementById('description').value;
      var sup = document.getElementById('suplier_code').value;

      if (jenis.value === 'VDN') {
        if ((Number(amount.value) > Number(total.value))) {
          alert('Value can not exceed the total invoice. Please select your type transaction!');
          amount.value = 0;
          total.value = hutang.value;
          return false;
        } else {
          if (jenis.value === 'VCN') {
            total.value = Number(total.value) + Number(amount.value);
          } else {
            total.value = total.value - amount.value;
          }

          $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa1" class="txt" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VDN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                    </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button> <a data-toggle="modal" href="#coa"> coa</a></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa1"  class="txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1" class="txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VCN" required/></td>\n\
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
          document.getElementById('nota_credit').value = sum1;


          $(".txtDebt").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length !== 0) {
              sum2 += parseFloat(this.value);
            }
          });
          document.getElementById('nota_debet').value = sum2;

          return false;
        }
      } else {
        if (jenis.value === 'VCN') {
          total.value = Number(total.value) + Number(amount.value);
        } else {
          total.value = total.value - amount.value;
        }

        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" id="no_coa0"  class="no_coa txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa0"  class="nama_coa txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VDN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt txtDesc" value="' + desc + '" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="' + amount.value + '" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="' + amount.value + '" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                    </tr><tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa1 txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" id="nama_coa1"  class="nama_coa txt" value="" />\n\
                    <input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VCN" required/></td>\n\
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
        document.getElementById('nota_credit').value = sum1;


        $(".txtDebt").each(function() {
          //add only if the value is number
          if (!isNaN(this.value) && this.value.length !== 0) {
            sum2 += parseFloat(this.value);
          }
        });
        document.getElementById('nota_debet').value = sum2;

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
  // function get_currency() {
  //     var currency_id = document.getElementById('currency').value;
  //     var res = currency_id.split("|");
  //     document.getElementById('currency_val').value = res[0];
  //     document.getElementById('symbol_currency').value = res[1];
  //     document.getElementById('rate_currency').value = res[0];
  //     document.getElementById('jr_rate1').value = res[0];
  //     document.getElementById('jr_rate2').value = res[0];
  //     document.getElementById('jr_rate3').value = res[0];
  //     document.getElementById('jr_rate4').value = res[0];
  //     document.getElementById('jr_rate5').value = res[0];
  //     document.getElementById('jr_rate6').value = res[0];
  // }

  $(document).ready(function() {
    // var sum1 = 0;
    // var sum2 = 0;
    // $(".txtCredit").each(function () {
    //     //add only if the value is number
    //     if (!isNaN(this.value) && this.value.length !== 0) {
    //         sum1 += parseFloat(this.value);
    //     }
    // });
    // document.getElementById('nota_credit').value = sum1;


    // $(".txtDebt").each(function () {
    //     //add only if the value is number
    //     if (!isNaN(this.value) && this.value.length !== 0) {
    //         sum2 += parseFloat(this.value);
    //     }
    // });
    // document.getElementById('nota_debet').value = sum2;


    $("#tabel_coa").dataTable({
      "scrollY": 300,
      "scrollX": true
    });



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
    document.getElementById('nota_credit').value = sum1;


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum2;
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

    document.getElementById('invoice_number').value = refno;
    document.getElementById('tgl_invoice').value = tgl_invoice;
    document.getElementById('suplier_code').value = suplier_code;
    document.getElementById('suplier_name').value = suplier_name;
    document.getElementById('currency').value = currency;
    // document.getElementById('rate_currency').value = rate;
    // document.getElementById('total').value = totali;
    document.getElementById('hutang').value = totali;
    document.getElementById('amount').value = Amount;



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
    var amount = document.getElementById("amount").value;
    var select_vcdn = document.getElementById("select_vcdn");
    var num = 1;
    for (var i = 0; i < num; i++) {
      if (select_vcdn.value === "credit") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="" onkeyup="reset1()"/></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)"  value=""  onKeyup="reset2()"/></td>\n\
        </tr>');
      } else if (select_vcdn.value === "Debt") {
        $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value=""  onKeyup="reset1()"/></td>\n\
                <td><input type="text" onKeydown="return validasi_enter(event)" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)"  value="" onKeyup="reset2()"/></td>\n\
        </tr>');
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
    document.getElementById('nota_credit').value = sum1;


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum2;
    $('#coa').modal('hide');
  }

  function tambah_baris() {
    var rate_currency = document.getElementById("rate_currency").value;
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel"]').append('<tr>\n\
                <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
                <td><input type="text" name="txtAccountNo[]" class="no_coa txt" value="" required/></td>\n\
                <td><input type="text" name="txtAccountName[]" class="txt" value="" /></td>\n\
                <td><input type="hidden" name="txtJenisID[]" class="txt JenisID" value="VDN" required/></td>\n\
                <td><input type="text" name="txtDesc[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtTotal[]" class="txt number txtTotal" onkeypress="return isNumber(event)" onkeyup="hitung_vcdn()" value="0" /></td>\n\
                <td><input type="text" name="txtRate[]" class="txt number txtRate" onkeypress="return isNumber(event)" value="' + rate_currency + '" readonly /></td>\n\
                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="0" readonly /></td>\n\
        </tr>');
    }
  }

  function hitung_vcdn() {
    var total = document.getElementsByClassName('txtTotal');
    var jur_det = document.getElementsByClassName('txtDebt');
    var rate = document.getElementsByClassName('txtRate');
    var jur_credit = document.getElementsByClassName('txtCredit');
    var jenis = document.getElementsByClassName('JenisID');

    for (var i = 0; i < total.length; i++) {
      if (jenis[i].value === 'VDN') {
        jur_credit[i].value = 0;
        jur_det[i].value = total[i].value * rate[i].value;
      } else if (jenis[i].value === 'VCN') {
        jur_det[i].value = 0;
        jur_credit[i].value = total[i].value * rate[i].value;
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
    document.getElementById('nota_credit').value = sum1;


    $(".txtDebt").each(function() {
      //add only if the value is number
      if (!isNaN(this.value) && this.value.length !== 0) {
        sum2 += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum2;
  }

  function debt() {
    var jenis = document.getElementById("jenis");
    if (document.getElementById('debit').checked === true) {
      jenis.value = 'VDN';
      return false;
    } else {
      jenis.value = 'VCN';
      return false;
    }

  }

  function ambil_tabel() {
    var refno = document.getElementById('refno').value;
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/vcdn/cek_tabel?id=" + refno,
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

  function grandtotal1() {
    var sum = 0;
    $("#tabel .txtDebt").each(function() {
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_debet').value = sum;
    // alert(creditin[0].value);


  }

  function reset1() {
    var debitin = document.getElementsByClassName("txtDebt");
    var creditin = document.getElementsByClassName("txtCredt");
    for (var i = 0; i < creditin.length; i++) {
      debitin[i].value = debitin[i].value.replace(",", "");
      creditin[i].value = creditin[i].value.replace(",", "");
    }
    for (var i = 0; i < debitin.length; i++) {
      if (Number(debitin[i].value) > 0) {
        creditin[i].value = 0;
      }
    }
    grandtotal1();
    grandtotal2();
  }

  function reset2() {
    var debitin = document.getElementsByClassName("txtDebt");
    var creditin = document.getElementsByClassName("txtCredt");
    for (var i = 0; i < debitin.length; i++) {
      debitin[i].value = debitin[i].value.replace(",", "");
      creditin[i].value = creditin[i].value.replace(",", "");
    }
    for (var i = 0; i < debitin.length; i++) {
      if (Number(creditin[i].value) > 0) {
        debitin[i].value = 0;
      }
    }
    grandtotal1();
    grandtotal2();
  }

  function grandtotal2() {
    var sum = 0;
    var debitin = document.getElementsByClassName("txtDebt");
    var creditin = document.getElementsByClassName("txtCredt");
    $("#tabel .txtCredt").each(function() {
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }
    });
    document.getElementById('nota_credit').value = sum;
    // alert(creditin[0].value);


  }
</script>
<?php
if (!empty($get_header)) {
  foreach ($get_header as $s) {
    $nofaktur = $s->no_reff;
    $tgl = $s->tanggal;
    //$no_nota = $s->no_nota;
    //$tgl_invoice = $s->tanggal_invoice;
    //$total = number_format($s->total-$s->hutang, 2, '.', '');
    // $amount = number_format($s->hutang, 2, '.', '');
    //$jenis = $s->jenis_debit_kredit;
    $currency = $s->currency;
    $rate = number_format($s->rate, 6, '.', '');
    //$keterangan = $s->keterangan;
    //$nama_sup = $s->namavendor;
    //$kode_sup = $s->kode_sup;
    $total_debet = number_format($s->total_debet, 2, ',', '.');
    $total_credit = number_format($s->total_credit, 2, ',', '.');
    $readonly = "readonly";
    $submit_value = 'Update';
    $amount = "";
    $dt = 1;
  }
} else {
  $nofaktur = "";
  $tgl = date("d/m/Y");
  $no_nota = "";
  $tgl_invoice = "";
  $total = "";
  $jenis = "";
  $currency = "USD";
  $rate = 1;
  $amount = "";
  $keterangan = "";
  $kode_sup = "";
  $nama_sup = "";
  $total_debet = "0.";
  $total_credit = 0;
  $readonly = "";
  $submit_value = 'Save';
  $dt = 0;
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form id="myForm" action="<?php echo base_url(); ?>General_Journal/save" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">General Journal</span>
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
                      <label class="control-label col-md-3">Reff. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo "$nofaktur"; ?>" onkeypress="return valid_enter(event)" class="form-control" <?php echo $readonly; ?> required />
                        <label class="CurID"></label>
                      </div>
                    </div><br />
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" onchange="gantirate()" id="tgl_tempo" name="tanggal" class="form-control date date-picker" onkeypress="return valid_enter(event)" value="<?php echo "$tgl"; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-3">
                        <div id="cur_id">
                          <?php
                          if ($dt == 0) {
                            $style_cur = 'class="select2me form-control" id="currency" onKeydown="return validasi_enter(event)" onchange="get_currency()" required';
                            echo form_dropdown('cur', $cur, $currency, $style_cur);
                          } else {
                            echo "<input type='text' name='cur' class='form-control' onKeydown='return validasi_enter(event)' value='$Currency_symbol' $readonly/>";
                          }
                          ?>
                        </div>
                        <!-- <input type='text' name='cur' class='form-control' onKeydown='return validasi_enter(event)' value='<?php echo $currency ?>' readonly/>      -->
                      </div>
                      <label class="control-label col-md-1" style="text-align:right;">Rate</label>
                      <div class="col-md-2">
                        <input type="text" id="rate_currency" name="rate" value="<?php echo $rate; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" <?php echo $readonly; ?> required />
                        <input type="hidden" id="curid" onKeydown="return validasi_enter(event)" name="curid" class="form-control" value="<?php echo $rate; ?>" onkeypress="return isNumber(event)" readonly required />
                      </div>

                      <div class="col-md-2">
                        <input type="hidden" class="form-control" value="<?php echo $amount; ?>" id="amount" onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="amount" />
                      </div>
                    </div>
                    <div class="form-group">

                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="control-label col-md-3"></label>
                      <div class="col-md-9">
                        <input type="hidden" class="form-control autosizeme" name="description" id="description" data-toggle="modal" onkeyup="return isNumber(event)" onkeypress="return valid_enter(event)" rows="5"></textarea>
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
                    <th width="3%">

                    </th>
                    <th width="20%">
                      Account Number
                    </th>
                    <th width="20%">
                      Account Name
                    </th>
                    <th style="display:none">
                      Jenis ID
                    </th>
                    <th width="31%">
                      Description
                    </th>
                    <th width="13%">
                      Debt
                    </th>
                    <th width="13%">
                      Credit
                    </th>
                  </tr>
                </thead>
                <tbody id="cid">
                  <tr style="background: #cccccc; font-weight: bold">
                    <td colspan="4">Grand Total</td>
                    <td><input type="text" name="nota_debet" id="nota_debet" class="spesial_text txtDebit" id="nota_debet" value="<?php echo $total_debet; ?>" readonly /></td>
                    <td><input type="text" name="nota_credit" id="nota_credit" class="spesial_text txtCredit" id="nota_credit" value="<?php echo $total_credit; ?>" readonly /></td>
                  </tr>
                  <?php
                  if (!empty($get_jurnal)) {
                    foreach ($get_jurnal as $v) {
                  ?>
                      <tr>
                        <td>
                          <button class="tombol" onclick="hapus_baris(this)">Remove</button>
                          <input type="hidden" name="detaiid" value="<?php echo $v->DetailID; ?>">
                        </td>
                        <td><input type="text" name="txtAccountNo[]" class="txt" value="<?php echo $v->NoCOA; ?>" required /></td>
                        <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->JenisJurnalID; ?>" /></td>
                        <td><input type="text" name="txtDesc[]" class="txt" value="<?php echo $v->Uraian; ?>" /></td>
                        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Debet, 2, '.', ','); ?>" onkeyup="reset1()" /></td>
                        <td><input type="text" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->Kredit, 2, '.', ','); ?>" onKeyup="reset2()" /></td>
                        <!--  <td><button class="tombol-disable" disabled >Remove</button></td>
                                                <td><input type="hidden" name="txtID[]" class="txt" value="<?php echo $v->DetailID; ?>" readonly/>
                                                    <input type="text" name="txtAccountNo[]" class="no_coa txt" value="<?php echo $NoCOA[0]; ?>"/></td>
                                                <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->AccountName; ?>"  /></td>
                                                <td><input type="text" name="txtDesc[]" class="txt" value="<?php echo $v->Uraian; ?>" readonly /></td>
                                                <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="<?php echo number_format($v->Debet, 2, '.', ''); ?>" readonly /></td>
                                                <td><input type="text" name="txtCredit[]" class="txt number txtCredit" onkeypress="return isNumber(event)"  value="<?php echo number_format($v->Kredit, 2, '.', ''); ?>" readonly /></td> -->
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
              <hr />
              <!-- <a class="btn btn-success" onclick="tambah_baris()"><i class="fa fa-download"></i> Input</a> -->
              <a class="btn green" data-toggle="modal" id="co" href="#coa" title="Serch COA number"><i class="fa fa-search"></i> Search COA</a>
              <button type="submit" name="sbt" onclick="myFunction()" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>General_Journal"><i class="fa fa-warning"></i> Cancel</a>
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn red" href="<?php echo base_url(); ?>General_Journal/hapus?id=<?php echo $this->input->get('id'); ?>"><i class="fa fa-trash"></i> Delete</a>
                <a class="btn btn-primary" href="<?php echo base_url(); ?>General_Journal/add_new"><i class="fa fa-plus"></i> Create New</a>
                <a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>vcdn/print_vcdn?id=<?php echo $this->input->get('id'); ?>" target="_BLANK"><i class="fa fa-print"></i> Print</a>
              <?php } ?>
            </div>
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
        <input class="form-control" type="text" id="search" placeholder="Search">
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      $.each($("#tbl_coa tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });
  });
</script>