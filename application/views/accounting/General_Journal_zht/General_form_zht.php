<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', false);
  });
</script>


<script>
  function Rate_notfound() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tgl_tempo").value;
    $.ajax({
      url: "<?php echo base_url(); ?>General_Journal_zht_tims/not_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#rate2").html(response);
      },
      dataType: "html"
    });
    return false;
  }

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

  function cekRate() {
    $rate = document.getElementById("rate_currency").value;
    if ($rate > 0) {

    } else {

    }
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

  function ganti_ref() {
    var a = document.getElementById('tgl_tempo').value;
    var b = a.replace(/\//g, "");
    var c = b.substring(2);

    $.ajax({
      url: "<?php echo base_url(); ?>General_Journal_zht_tims/get_refnumber1?tgl=" + c + "",
      success: function(response) {
        $('#ganti').html(response);
      },
      dataType: "html"
    });
  }

  function get_cur_gj() {
    var currency = document.getElementById('currency').value;
    var tgl = document.getElementById('tgl_tempo').value;

    $.ajax({
      url: "<?php echo base_url(); ?>General_Journal_zht_tims/ambil_currency?kurs=" + currency + "&tgl=" + tgl,
      success: function(response) {
        $("#daftar_kurs").html(response);

        var cur = document.getElementById('rate_currency').value;
        var cur2 = document.getElementById('rate_sgd').value;
        document.getElementById('rate_sgd').value = cur2;
        document.getElementById('currency').value = cur;

        document.getElementById('jr_rate1').value = cur;
        document.getElementById('jr_rate2').value = cur;
        document.getElementById('jr_rate3').value = cur;
        document.getElementById('jr_rate4').value = cur;
        document.getElementById('jr_rate5').value = cur;
        document.getElementById('jr_rate6').value = cur;
      },
      dataType: "html"
    });
    document.getElementById('tombol_dp').style.display = 'inline';
    document.getElementById('garis_dp').style.display = 'block';
  }

  function get_cur_error() {
    var currency = document.getElementById('currency').value;
    var tgl = document.getElementById('tgl_tempo').value;

    $.ajax({
      url: "<?php echo base_url(); ?>General_Journal_zht_tims/ambil_currency2?kurs=" + currency + "&tgl=" + tgl,
      success: function(response) {
        $("#error_kurs").html(response);
      },
      dataType: "html"
    });
  }



  $(document).ready(function() {
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
    var table = document.getElementById('tbl_coa');

for (var rowIndex = 1; rowIndex < table.rows.length; rowIndex++) { 
    var row = table.rows[rowIndex]; 
    var rowData = [];

    for (var cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
        var cellText = row.cells[cellIndex].innerText;
        rowData.push(cellText);
    }
    console.log('Baris ' + rowIndex + ':', rowData);
}

    var AccNo = getText(document.getElementById('tbl_coa').rows[$r].cells[4]);
    var AccNm = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);
    var AccDept = getText(document.getElementById('tbl_coa').rows[$r].cells[5]);
    var type = getText(document.getElementById('tbl_coa').rows[$r].cells[3]);

    var rate_currency = document.getElementById("rate_currency").value;
    var amount = document.getElementById("amount").value;
    var select_vcdn = document.getElementById("select_vcdn");
    var num = 1;

    if (select_vcdn.value === "credit") {
      $('table[id="tabel"]').append('<tr>\n\
              <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtdept[]" class="txt" value="' + AccDept + '" required/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value="" onkeyup="reset1()"/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)"  value=""  onKeyup="reset2()"/></td>\n\
      </tr>');
    } else if (select_vcdn.value === "Debt") {
      $('table[id="tabel"]').append('<tr>\n\
              <td><button class="tombol" onclick="hapus_baris(this)" >Remove</button></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountNo[]" class="txt" value="' + AccNo + '" required/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtdept[]" class="txt" value="' + AccDept + '" required/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtAccountName[]" class="txt" value="' + AccNm + '" /></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDesc[]" class="txt" value="' + desc + '" /></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)"  value=""  onKeyup="reset1()"/></td>\n\
              <td><input type="text" onKeydown="return validasi_enter(event)" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)"  value="" onKeyup="reset2()"/></td>\n\
      </tr>');
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
    document.getElementById('nota_debet').value = sum.toFixed(2);
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
    document.getElementById('nota_credit').value = sum.toFixed(2);
    // alert(creditin[0].value);


  }
</script>
<?php
if (!empty($get_header)) {
  $debet = 0;
  $kredit = 0;
  foreach ($get_header as $s) {
    $debet =  $debet + $s->debet;
    $kredit = $kredit + $s->credit;
    $nofaktur = $s->no_reff;
    $tgl = $s->tanggal;
    $remark = $s->remarks;
    //$no_nota = $s->no_nota;
    //$tgl_invoice = $s->tanggal_invoice;
    //$total = number_format($s->total-$s->hutang, 2, '.', '');
    // $amount = number_format($s->hutang, 2, '.', '');
    //$jenis = $s->jenis_debit_kredit;
    $currency = $s->currency;
    $rate_usd = number_format($s->rate, 6, '.', '');
    $rate_sgd = number_format($s->rate_sgd, 6, '.', '');
    //$keterangan = $s->keterangan;
    //$nama_sup = $s->namavendor;
    //$kode_sup = $s->kode_sup;
    $total_debet = number_format($debet, 2, ',', '.');
    $total_credit = number_format($kredit, 2, ',', '.');
    $created_by = $s->created_by;
    $created_date = $s->created_date;
    $readonly = "readonly";
    $submit_value = 'Update';
    $amount = "";
    $dt = 1;
  }
} else {
  $remark = "";
  $nofaktur = "";
  $tgl = date("d/m/Y");
  $no_nota = "";
  $totalrate = "";
  $tgl_invoice = "";
  $total = "";
  $jenis = "";
  $currency = "";
  $rate_usd = '0';
  $rate_sgd = '0';
  $amount = "";
  $description = "";
  $kode_sup = "";
  $nama_sup = "";
  $total_debet = "0.";
  $total_credit = 0;
  $readonly = "";
  $submit_value = 'Save';
  $dt = 0;
  $created_by = "";
  $created_date = "";
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form id="myForm" action="<?php echo base_url(); ?>General_Journal_zht_tims/save" onsubmit="return validate(this);" method="post">
        <div class="col-md-12">
          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
          <input type="hidden" id="closing" name="closing" value="<?php echo $closing; ?>" />
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">General Journal ZHT</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div id="error_kurs"> </div>
                    <div id="ganti">
                      <div class="form-group">
                        <label class="control-label col-md-3">Reff. Number</label>
                        <div class="col-md-9">
                          <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo "$nofaktur"; ?>" onkeypress="return valid_enter(event)" class="form-control" <?php echo $readonly; ?> required readonly />
                          <label class="CurID"></label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" onchange="ganti_ref();" id="tgl_tempo" name="tanggal" class="form-control date target" onkeypress="return valid_enter(event)" value="<?php echo "$tgl"; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-3">
                        <div id="cur_id">
                          <?php
                          if ($dt == 0) {
                            $style_cur = 'class="select2me form-control" id="currency" onKeydown="return validasi_enter(event)" onchange="ganti_ref();get_cur_error();get_cur_gj();" ';
                            echo form_dropdown('cur', $Currency, $currency, $style_cur);
                          } else {
                            echo "<input type='text' name='cur' class='form-control' onKeydown='return validasi_enter(event)' value='$currency' $readonly />";
                          }
                          ?>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-2">
                          <input type="hidden" class="form-control" value="<?php echo $amount; ?>" id="amount" onkeypress="return valid_enter(event)" onkeyup="return format2(this, event)" name="amount" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div id="daftar_kurs">
                        <div class="form-group">
                          <label class="control-label col-md-3">Rate</label>
                          <div class="col-md-3">
                            <input type="text" id="rate_currency" name="rate_usd" value="<?php echo $rate_usd; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">SGD Rate</label>
                          <div class="col-md-3">
                            <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" onkeypress="return valid_enter(event)" />

                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-3">
                            <input type="hidden" id="currency" name="currency" class="form-control" value="<?php echo $currency; ?>" onkeypress="return isNumber(event)" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Remarks</label>
                      <div class="col-md-9">
                        <textarea name="remarkss" id="remarkss" class="form-control"><?= $remark; ?></textarea>
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
                    <th width="15%">
                      Account Number
                    </th>
                    <th width="7%">
                      Department Code
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
                    <td colspan="5">Grand Total</td>
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
                        <td><input type="text" name="txtAccountNo[]" class="txt" value="<?php echo $v->no_coa; ?>" required /></td>
                        <?php if($v->dept_code == '000'){
                        ?>
                          <td><input type="text" name="txtdept[]" class="txt" value="000" style="background: #cccccc;"/></td>
                        <?php }else{ ?>
                        <td>
                        <select class="form-control select2me" name="txtdept[]">
                            <?php
                            if (is_array($dept_code) || is_object($dept_code)) {
                                foreach ($dept_code as $dept) {
                                    ?>
                                    <option value="<?php echo $dept->dept_code; ?>"
                                        <?php echo ($v->dept_code == $dept->dept_code) ? 'selected' : ''; ?>>
                                        <?php echo $dept->dept_name; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        </td>
                        <?php } ?>
                        <td><input type="text" name="txtAccountName[]" class="txt" value="<?php echo $v->JenisJurnalID; ?>" /></td>
                        <td><input type="text" name="txtDesc[]" class="txt" value="<?php echo $v->description; ?>" /></td>
                        <td><input type="text" name="txtDebt[]" class="txt number txtDebt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->debet, 2, '.', ','); ?>" onkeyup="reset1()" /></td>
                        <td><input type="text" name="txtCredit[]" class="txt number txtCredt" onkeypress="return isNumber(event)" value="<?php echo number_format($v->credit, 2, '.', ','); ?>" onKeyup="reset2()" /></td>
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
              <button id="btn-save" type="submit" name="sbt" onclick="myFunction()" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-primary" href="<?php echo base_url(); ?>General_Journal_zht_tims/print_gj?id=<?php echo $this->input->get('id'); ?>" target="_BLANK"><i class="fa fa-print"></i> Print</a>
              <a class="btn btn-default" href="<?php echo base_url(); ?>General_Journal_zht_tims/add_new"><i class="fa fa-plus"></i> New Transaction</a>
              <button class="btn btn-default" id="btnFindRecord" type="button">
                Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>

              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-warning kanan" href="<?php echo base_url(); ?>General_Journal_zht_tims"><i class="fa fa-warning"></i> Cancel</a>
                <a class="btn red kanan" href="<?php echo base_url(); ?>General_Journal_zht_tims/hapus?id=<?php echo $this->input->get('id'); ?>"><i class="fa fa-trash"></i> Delete</a>
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
<script>
  $(document).ready(function() {

    var tgl = $('#closing').val();
    $('.target').datepicker({
      'autoclose': true,
      'todayHighlight': !0,
      'startDate': tgl,
      'orientation': "top left",
      'format': ('dd/mm/yyyy')
      // var today = picker.startDate.format('DD/MM/YYYY');
    });

    var dateTempo = $('#tgl_tempo').val();
  
    if(dateTempo){
        // var partsDateTempo = dateTempo.split('/');
        var partsClosing = tgl.split('/');
        var partsDateTempo = dateTempo.split('-').reverse().join('/');
        var date_tempo = partsDateTempo.split('/');

        var yearDateTempo = parseInt(date_tempo[2], 10);
        var yearClosing = parseInt(partsClosing[2], 10);

        if(yearDateTempo < yearClosing){
          $('#tgl_tempo').prop('disabled', true);
          $('#btn-save').prop('disabled', true);
        }
    }
  });
</script>

<script type="text/javascript">
  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>General_Journal_zht_tims/selectInvoiceGJ", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });
</script>