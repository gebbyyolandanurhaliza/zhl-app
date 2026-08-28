<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<script>
  $(function() {
    $('.no_coa').autocomplete({
      serviceUrl: "<?php echo site_url('Receivable_recognition_tims/get_coa'); ?>",
        onSelect: function (suggestion) {
          console.log(suggestion);
          var CoaDetail = suggestion.NoCOA;
          var dept = suggestion.kode_department;
          
          $('#txtDeptCodeRow3').html(`<input name="dept_code[3]" type="text" class="txt" value="${dept}" required />`);
        }
    });
  });
</script>
<script>
  $(document).ready(function(){
    if ($("#term").val()) {
        hitungSelisihHari2();
    }
  });
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

    $("#search").keyup(function() {
      _this = this;
      $.each($("#tbl_coa tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });

    });

    var btn = document.getElementById('btn_update').value;
    $('form#form1').submit(function() {
      window.onbeforeunload = null;
    });
    if (btn === 'Save') {
      window.onbeforeunload = function() {
        return "Do you want to leave?";
      };
    }


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
    var gst = document.getElementsByClassName('txtGSTValue');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
      gst[i].value = gst[i].value.replace(",", "");
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
    var type = document.getElementById("jenis").value;
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

    document.getElementById('nota_debet').value = sum.toFixed(2);
    for (var i = 0; i < total.length; i++) {
      if (i < 1) {
        total[0].value = sum.toFixed(2);
      }
      if (i > 1) {
        total[2].value = sumx.toFixed(2);
      }
      if (i < 5) {
        if (type === "CCN") {
          if (dk[i].value === "C") {
            total_AP -= parseFloat(total[i].value);
          } else {
            total_AP += parseFloat(total[i].value);
          }
          total[5].value = total_AP.toFixed(2);
        }else{
          if (dk[i].value === "D") {
            total_AP -= parseFloat(total[i].value);
          } else {
            total_AP += parseFloat(total[i].value);
          }
          total[5].value = total_AP.toFixed(2);
        }
          

      }
      if (type === "CCN") {
        if (dk[i].value === "C" && i < 6) {
          var data = total[i].value * rate[i].value;
          jur_credit[i].value = data.toFixed(2);
          sum_crt += parseFloat(data);
          jur_det[i].value = 0;
        } else {
          var data = total[i].value * rate[i].value;
          jur_det[i].value = data.toFixed(2);
          sum_dbt += parseFloat(data);
          jur_credit[i].value = 0;
        }
      }else{
        if (dk[i].value === "D" && i < 6) {
          var data = total[i].value * rate[i].value;
          jur_det[i].value = data.toFixed(2);
          sum_dbt += parseFloat(data);
          jur_credit[i].value = 0;
        }else{
          var data = total[i].value * rate[i].value;
          jur_credit[i].value = data.toFixed(2);
          sum_crt += parseFloat(data);
          jur_det[i].value = 0;
        }
      }
        
    }

    var data_ar = total[0].value * rate[0].value;
    var selisih = (sum_dbt - sum_crt).toFixed(2);

    if (type === "CCN") {
      if (selisih != 0) {
        jur_det[0].value = (data_ar - selisih).toFixed(2);
      }
    }else{
      if (selisih != 0) {
        jur_credit[0].value = (data_ar - selisih).toFixed(2);
      }
    }
      

    total_credit.value = (sum_crt - selisih).toFixed(2);
    total_deb.value = sum_dbt.toFixed(2);
    cek_gst();
  }

  function cek_gst() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var txtsummary = document.getElementsByClassName('txtsummary');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }
    // hitung_total(); gst dihilangkan karena tidak auto. di ganti ke hitung total agar terhitung auto nya
    var gst_type = document.getElementsByClassName('txtGST');
    var sgd_txt = document.getElementsByClassName('txtSGD');
    var rate_sgd = document.getElementById('rate_sgd');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    var tgl1 = document.getElementById('tanggal_invoice').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    for (var i = 0; i < gst_type.length; i++) {
      if (sgd_txt[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {
        if (gst_type[i].value === 'GST') {
          if (tahun > '2023') {
            var total = qty[i].value * harga[i].value * 9 / 100;
            gst_value[i].value = total.toFixed(2);
            txtsummary[i].value = qty[i].value * harga[i].value;
          } else {
            var total = qty[i].value * harga[i].value * 8 / 100;
            gst_value[i].value = total.toFixed(2);
            txtsummary[i].value = qty[i].value * harga[i].value;
          }
        } else {
          gst_value[i].value = '0';
          txtsummary[i].value = '0';
        }
      }
    }
    hitung_total();
  }

  function buat_faktur() {

    var refno = document.getElementById('refno');
    var id = document.getElementById('rate_currency');
    var tgl = document.getElementById('tanggal_invoice').value;
    $tgl = tgl.split("/");
    var date = $tgl[2] + '-' + $tgl[1] + '-' + $tgl[0];

    if (tgl != '') {
      var today = new Date(date);
      var b = ("0" + (today.getMonth() + 1)).slice(-2);
      var y = today.getFullYear();
      if (refno.value === "INV") {
        $.ajax({
          url: "<?php echo base_url(); ?>Receivable_recognition_tims/buat_nofak?tahun=" + y,
          success: function(e) {
            var ref = parseFloat(e);
            var no = ("000000" + ref).slice(-3);
            refno.value = 'INV' + no + '/' + b + "/" + y;
            return false;
          },
          dataType: "html"
        });
      }
    }

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

  // function get_coa() {
  //   var supp = document.getElementById('supplier').value;
  //   var nocao = document.getElementById('no_coa5');
  //   var btn_update = document.getElementById('btn_update').value;
  //   //alert(btn_update);
  //   var belah = supp.split("|");
  //   document.getElementById("supp").value = belah[0];
  //   document.getElementById("NoCOA").value = belah[1];
  //   nocao.value = belah[1];

  // }

  function get_coa() {
    var supp = document.getElementById('supplier').value;
    var btn_update = document.getElementById('btn_update').value;
    var nocao = document.getElementById('no_coa5');
    //alert(btn_update);

    var belah = supp.split("|");
    document.getElementById("supp").value = belah[0];
    document.getElementById("NoCOA").value = belah[1];
    nocao.value = belah[1];

    var supplierID = belah[0];
    var found = false; 
    var listCoa = <?php echo json_encode($List_coa); ?>;
    console.log(listCoa);
    listCoa.forEach(function(element) {
        var Nocoa = element.NoCOA;
        var sub_account = element.sub_account_type;
        if(Nocoa == nocao.value){
          found = true;
          if(sub_account == "DEPT"){
            $('#txtDeptCodeRow5').html(`<select name="dept_code[5]" class="txt">
                <option value=""> -- Select --</option>
                <?php foreach ($dept_code as $dept) : ?>
                  <option value="<?php echo $dept->dept_code; ?>"> <?php echo $dept->dept_name; ?></option>
                <?php endforeach; ?>
            </select>`);
          }else{ 
            $('#txtDeptCodeRow5').html(`<input hidden name="dept_code[5]" type="text" class="txt" value="000" required />
            <input type="text" class="txt" value="000" />`);
          }
        }
    });

    if (!found) {
        $('#txtDeptCodeRow5').html(`<input hidden name="dept_code[5]" type="text" class="txt" value="000" required />
        <input type="text" class="txt" value="000" />`);
    }

    var periode = document.getElementById('tgl_invoice').value;
    var currency = "";
    
    // $.ajax({
    //     url: '<?php echo site_url('Receivable_recognition_tims/get_supp_piu'); ?>', 
    //     method: 'GET',
    //     dataType: 'json',
    //     data: {
    //         supp: supplierID,
    //         currency: currency,
    //         periode: periode
    //     },
    //     success: function(response) {
    //         console.log(response);
    //         if(belah[0] === response){
    //           bootbox.alert("The Customer Has Outstanding Payment more than 2 months");
    //         }
    //     },
    //     error: function() {
    //         alert('Data tidak dimuat');
    //     }
    // });

    get_item_cust(supplierID);
    get_ap_cust(supplierID);

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

  function select_item() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {

      var price = getText(document.getElementById('tblitem').rows[i].cells[3]);
      var gst = getText(document.getElementById('tblitem').rows[i].cells[4]);
      var NoCoa = getText(document.getElementById('tblitem').rows[i].cells[6]);
      var deptCode = getText(document.getElementById('tblitem').rows[i].cells[7]);

      var getItem = '<tr><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="'+ getText(document.getElementById('tblitem').rows[i].cells[1]) +'" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="'+ getText(document.getElementById('tblitem').rows[i].cells[6]) +'"  /></td>\n\
                <td><input type="text" name="txtdept[]" class="txt" value="' + deptCode + '" readonly/></td>\n\
                <td><input type="text" name="txtContainerNo[]" class="txt" value="" /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA">'+ getText(document.getElementById('tblitem').rows[i].cells[2]) +'</textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_total()" required/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" /><input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber" value="' + price + '" onKeyup="hitung_total()" required/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber"  data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                    <option value="" ' + (gst === "" ? "selected" : "") + '>Select</option>\n\
                    <option value="GST" ' + (gst === "GST" ? "selected" : "") + '>GST</option>\n\
                    <option value="ZER" ' + (gst === "ZER" ? "selected" : "") + '>Zero Rate</option>\n\
                    <option value="EXP" ' + (gst === "EXP" ? "selected" : "") + '>Exampt</option>\n\
                    <option value="OUT" ' + (gst === "OUT" ? "selected" : "") + '>Out of Scope</option>\n\
                </select></td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  onKeyup="hitung_total()" /></td>\n\
        </tr>';
        $('table[id="tabel"]').append(getItem);
    } i++;
  }
    $('.modal-item').modal('hide');
  }

  function select_ap() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chkk[]");
    var chk_length = chk_arr.length;
    i = 1;


    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {  
      var unit = document.getElementById('tblap').rows[i].cells[5];
      var price = document.getElementById('tblap').rows[i].cells[2];
      var deptCode = getText(document.getElementById('tblap').rows[i].cells[7]);

      var value1 = parseFloat(getText(unit).replace(/,/g, '')) || 0; 
      var value2 = parseFloat(getText(price).replace(/,/g, '')) || 0; 
      var result = value1 * value2;
      var amount = number_format(result, 2, ".", ",");

      var selectAp = '<tr><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="hidden" name="Detail_item_id[]" value="0" />\n\
                <input type="hidden" name="Detail_jurnal_id[]" value="0" /><input type="text" name="Detail_po[]" class="txt" value="" /></td>\n\
                <td><input type="text" name="txtCOA[]" class="txt txtCOA" onkeypress="return isNumber(event)"  value="'+ getText(document.getElementById('tblap').rows[i].cells[8]) +'"  /></td>\n\
                <td><input type="text" name="txtdept[]" class="txt" value="'+deptCode+'" readonly/>\n\
                <td><input type="text" name="txtContainerNo[]" class="txt" value="" /></td>\n\
                <td><textarea name="txtItem[]" rows="1" cols="30" class="txt txtNmCOA">'+ getText(document.getElementById('tblap').rows[i].cells[1]) +'</textarea></td>\n\
                <td><input type="text" class="txt number quantity autonumber auto" name="txtQty[]" placeholder="0" onClick="make_blank()" onkeypress="return isNumber(event);" onKeyup="hitung_total()" required value="'+ getText(document.getElementById('tblap').rows[i].cells[5]) +'"/></td>\n\
                <td><input type="text" name="txtUnit[]" class="txt" value="'+ getText(document.getElementById('tblap').rows[i].cells[6]) +'"/><input type="hidden" name="txtSummary[]" class="txt txtSummary" /></td>\n\
                <td><input type="text" name="txtPrice[]" class="txt number prices autonumber"  onKeyup="hitung_total()"  placeholder="0" required value="'+ getText(document.getElementById('tblap').rows[i].cells[2]) +'"/></td>\n\
                <td><input type="text" name="txtAmount[]" class="txt number amount autonumber"  data-a-sep="," data-a-dec="." onkeypress="return isNumber(event)" value="'+ amount +'" +  /></td>\n\
                <input type="hhidden" name="txtRate[]" class="txt number autonumber" onkeypress="return isNumber(event)"  value="" />\n\
                <td><input type="text" name="txtSGD[]" class="txt number txtSGD autonumber" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                        <option value="">Select</option>\n\
                        <option value="GST">GST</option>\n\
                        <option value="ZER">Zero Rate</option>\n\
                        <option value="EXP">Exampt</option>\n\
                        <option value="OUT">Out of Scope</option>\n\
                    </select>\n\
                </td>\n\
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  onKeyup="hitung_total()" /></td>\n\
        </tr>';
        $('table[id="tabel"]').append(selectAp);
    } i++;
  }
    $('.modal-ap').modal('hide');
  }


  function tambah_baris() {
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/Receivable_recognition_tims/list_currency",
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
                <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0" onKeyup="hitung_total()" /></td>\n\
        </tr>');
    }
  }

  function tambah_atch() {
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tabel-atch"]').append(`<tr>
          <td class="text-center">
            <button class="tombol" onclick="hapus_atch(this)" >Remove</button>
          </td>
          <td>
              <input type="file" name="file_atch[]" class="form-control" accept="application/pdf">
              <small class="text-danger">* only receive PDF file</small>
          </td>
            <td>
              <input type="text" name="remarks[]" value="" class="form-control" placeholder="input your remark here...">
          </td>
      </tr>`);
    }
  }

  function hapus_atch(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }

  function hapus_atch_delete(btn) {

    var id = btn.getAttribute('data-id');

    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);

    // Confirmation prompt (optional)
    if (!confirm('Are you sure you want to delete this item?')) {
      return;
    }

    $.ajax({
      type: "post",
      url: "<?= site_url('Receivable_recognition_tims/delete_file/') ?>",
      data: {
        id: id,
      },
      dataType: "json"
    });
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
                                              <select name="dept_code[]" class="txt">\n\
                                                <option value="000"> Without Dept</option>\n\
                                                <?php foreach ($dept_code as $dept) : ?>\n\
                                                  <option value="<?php echo $dept->dept_code; ?>"> <?php echo $dept->dept_name; ?></option>\n\
                                                <?php endforeach; ?>\n\
                                              </select>\n\
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
      url: "<?php echo base_url(); ?>Receivable_recognition_tims/data_dp?id=" + supp + "&currency=" + curency,
      success: function(response) {
        $(".err").html(response);
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
    hitung_total();
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
      url: "<?php echo base_url(); ?>Receivable_recognition_tims/cek_tabel_ar?id=" + refno,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
  }

  // berdasarkan type transaction
  function ganti_credit() {
    var type = document.querySelector('input[name="type"]:checked').value;
    var jenis = document.getElementById("jenis");
    var dk_sales = document.getElementById("dk_sales");
    var dk_ar = document.getElementById("dk_ar");
    var dk2 = document.getElementsByName('dk[2]')[0];

    if (type === 'credit') {
      jenis.value = 'CCN';
      dk_sales.value = 'D';
      if (dk2) dk2.value = 'D'; 
      dk_ar.value = 'C';
    } else if (type === 'debit') { 
      jenis.value = 'CDN';
      dk_sales.value = 'C';
      if (dk2) dk2.value = 'C'; 
      dk_ar.value = 'D';
    } else { 
      jenis.value = 'INV';
      dk_sales.value = 'C';
      if (dk2) dk2.value = 'C'; 
      dk_ar.value = 'D';
    }

    // panggil hitung_total() jika ada
    if (typeof hitung_total === 'function') {
      hitung_total();
    }
  }


  // manual change
  // function ganti_credit() {

  //   var jenis = document.getElementById("jenis");
  //   if (document.getElementById('credit').checked === true) {
  //     jenis.value = 'CCN';
  //     document.getElementById("dk_sales").selectedIndex = 0;
  //     document.getElementById("dk_ar").selectedIndex = 1;
  //   }else if (document.getElementById('debit').checked === true) {
  //     jenis.value = 'CDN';
  //     document.getElementById("dk_sales").selectedIndex = 1;
  //     document.getElementById("dk_ar").selectedIndex = 0;
  //   } else {
  //     jenis.value = 'INV';
  //     document.getElementById("dk_sales").selectedIndex = 1;
  //     document.getElementById("dk_ar").selectedIndex = 0;
  //   }

  // }  

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

  function Rate_notfound() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tanggal_invoice").value;
    document.getElementById("tgl_tempo").value = $docdate;

        console.log($cur);
        console.log($docdate);
    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_factory/accounting_rate?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        console.log(response);
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
    $supplier_id = $s->kode_sup . "|" . $s->NoCOA;
    $NoCOA = $s->NoCOA;
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
    $type = $s->jenisjurnalid;
    $readonly = 'readonly';
    $disable = '';
    $submit_value = 'Update';
    if ($s->status_dp == 1) {
      $status_dp = "checked";
    } else {
      $status_dp = "";
    }

    if ($s->etadate == '1970-01-01') {
      $etadate = '';
    } else {
      $etadate = date_format((new DateTime($s->etadate)), 'd/m/Y');
    }

    if ($s->etddate == '1970-01-01') {
      $etddate = '';
    } else {
      $etddate = date_format((new DateTime($s->etddate)), 'd/m/Y');
    }

    // $invtype = '';
    $jenis_in = $s->jenis_inv;
    if ($s->shipmentdate == '1970-01-01') {
      $shpdate = '';
    } else {
      $shpdate = date_format((new DateTime($s->shipmentdate)), 'd/m/Y');
    }

    $bargevoy = $s->voyage;
    $blno = $s->blno;
    $ctrno = $s->ctrno;
    $shipper = $s->shipper;
    if ($s->target_app == '1970-01-01' || $s->target_app == null) {
      $trgt_app = '';
    } else {
      $trgt_app = date_format((new DateTime($s->target_app)), 'd/m/Y');
    }
  }
} else {
  $nofaktur = '';
  $kode_sup = '';
  $currency_id = '';
  $supplier_id = "";
  $NoCOA = '';
  $Currency_symbol = '';
  $rate = '0';
  $status_dp = "";
  $date_of_journal = date('d/m/Y');
  $date_invoice = date('d/m/Y');
  $tgl_tempo = date('d/m/Y');
  $term = '30';
  $rate_sgd = '0';
  $nota_debet = '0';
  $readonly = '';
  $type = '';
  $disable = 'disable';
  $submit_value = 'Save';
  // $etadate = date('d/m/Y');
  // $etddate = date('d/m/Y');
  // $shpdate = date('d/m/Y');
  $etadate = '';
  $etddate = '';
  $shpdate = '';
  // $invtype = '';
  $jenis_in = '';
  $bargevoy = '';
  $blno = '';
  $ctrno = '';
  $shipper = '';
  $trgt_app = '';
}
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>index.php/Receivable_recognition_tims/save_receivable_rec" name="form1" id="form1" method="post" enctype="multipart/form-data">
        <div class="col-md-12">

          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date_1'); ?>" />
          <input type="hidden" id="closing" name="closing" value="<?php echo $closing; ?>" />
          <div id="error_id"></div>
          <?php echo $message; ?>
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Receivable Recognition</span>
              </div>
              <div class="form-group">
                <?php if ($this->input->get('id') <> '') { ?>
                  <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Receivable_recognition_tims/add_new"><i class="fa fa-plus"></i> Create New</a>
                <?php
                } else {
                  echo "<label class='btn kanan' style='color:red'>Closing Date: " . $this->session->userdata('closing_date_1') . "</label>";
                }
                ?>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Type of Transaction</label>
                      <div class="col-md-9">
                        <div id="bounds">
                          <input type="radio" name="type" onclick="ganti_credit()" id="debit" value="debit" <?php
                                                                                                            if ($type == 'CDN') {
                                                                                                              echo "checked";
                                                                                                            }
                                                                                                            ?>><label for="debit"> Debt Note</label>
                          <input type="radio" name="type" onclick="ganti_credit()" id="credit" value="credit" <?php
                                                                                                            if ($type == 'CCN') {
                                                                                                              echo "checked";
                                                                                                            }
                                                                                                            ?>><label for="credit"> Credit Note</label>
                          <input type="radio" name="type" onclick="ganti_credit()" id="invoice" value="invoice" <?php
                                                                                                            if ($type == 'INV') {
                                                                                                              echo "checked";
                                                                                                            }
                                                                                                            ?>><label for="invoice"> Invoice</label>
                          <input type="hidden" name="JenisJurnal_head" id="jenis" value="<?php echo $type; ?>" onchange="ganti_credit()" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Ref. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" value="<?php echo $nofaktur; ?>" onkeyup="buat_faktur()" class="form-control" onchange="cek_nofak()" readonly />
                        <label class="CurID"></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = "class='select2me form-control' onchange='get_coa()' id='supplier' $disable";
                        echo form_dropdown('supplier', $SupplierID, $supplier_id, $style_kategori);
                        echo "<input type='hidden' name='supplier' id='supp'  class='form-control' value='$kode_sup'/>";
                        echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value='$NoCOA'/>";
                        ?>
                      </div>
                    </div>

<!--                     <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <?php
                        $extra_customer      = 'id="customer" class="form-control select2me" required';
                        $option_customer[''] = '';
                        foreach ($cbo_customer as $r) :
                          $option_customer[$r->customer_code] = $r->customer_name;
                        endforeach;
                        echo form_dropdown('Customer_code', $option_customer, $Customer_code, $extra_customer);
                        ?>
                      </div>
                    </div> -->

                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='select2me form-control' id='currency' onchange='get_cur();Rate_notfound();'";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                          echo "<input type='hidden' name='xxx' id='cursyp'  class='form-control' value='$currency_id'/>";
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Type </label>
                      <div class="col-md-9">
                        <select name="invtype" id="invtype" class="form-control select2me" onchange="gettanggal()" required>
                          <option></option>
                          <option value="bar" <?php if ($jenis_in === 'bar') {
                                                echo 'SELECTED';
                                              } ?>>Barge Charges</option>
                          <option value="fre" <?php if ($jenis_in === 'fre') {
                                                echo 'SELECTED';
                                              } ?>>Freight Charges</option>
                          <option value="trn" <?php if ($jenis_in === 'trn') {
                                                echo 'SELECTED';
                                              } ?>>Transport Charges</option>
                          <option value="imp" <?php if ($jenis_in === 'imp') {
                                                echo 'SELECTED';
                                              } ?>>Import Shipment</option>
                          <option value="det" <?php if ($jenis_in === 'det') {
                                                echo 'SELECTED';
                                              } ?>>Detention</option>
                          <option value="oth" <?php if ($jenis_in === 'oth') {
                                                echo 'SELECTED';
                                              } ?>>Other</option>
                          <option value="casa" <?php if ($jenis_in === 'casa') {
                                                  echo 'SELECTED';
                                                } ?>>Cash Sales</option>
                          <option value="truck" <?php if ($jenis_in === 'truck') {
                                                  echo 'SELECTED';
                                                } ?>>Trucking</option>
                        </select>
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
                          <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Invoice Date</label>
                      <div class="col-md-3">
                        <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date target" onchange="get_cur();Rate_notfound();" value="<?php echo $date_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
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
                        <input type="text" id="tgl_tempo" name="tgl_jurnal" class="form-control date target" value="<?php echo $date_of_journal; ?>" data-date-format="dd/mm/yyyy" readonly required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Due Date</label>
                      <div class="col-md-3">
                        <input type="text" id="tgl_invoice" name="tgl_tempo" class="form-control" value="<?php echo $tgl_tempo; ?>" <?php echo $readonly; ?> required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">ETD DATE</label>
                      <div class="col-md-3">
                        <input type="text" id="etddate" name="etddate" class="form-control date date-picker" value="<?php echo $etddate; ?>" data-date-format="dd/mm/yyyy" readonly required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">ETA DATE</label>
                      <div class="col-md-3">
                        <input type="text" id="etadate" name="etadate" class="form-control date date-picker" value="<?php echo $etadate; ?>" data-date-format="dd/mm/yyyy" readonly required />
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3">Shipper</label>
                      <div class="col-md-3">
                        <input type="text" id="shipper" name="shipper" class="form-control" value="<?= $shipper; ?>" />
                      </div>
                    </div>
                    <!-- tambahan 18-07-2018 -->
                    <div class="form-group">
                      <label class="control-label col-md-3">Po No.</label>
                      <div class="col-md-3">
                        <input type="text" id="blnnum" name="blnnum" class="form-control" value="<?= $blno; ?>" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Your Reff No.</label>
                      <div class="col-md-3">
                        <input type="text" id="ctrnum" name="ctrnum" class="form-control" value="<?= $ctrno; ?>" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Vessel No</label>
                      <div class="col-md-3">
                        <input type="text" id="bargenum" name="bargenum" class="form-control" value="<?= $bargevoy; ?>" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Delivery Date</label>
                      <div class="col-md-3">
                        <input type="text" id="shipdate" name="shipdate" class="form-control date date-picker" value="<?php echo $shpdate; ?>" value="" data-date-format="dd/mm/yyyy" />
                      </div>
                    </div>
                  </div>
                  <!--<div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Status</label>
                                            <div class="col-md-9">
                                                <input type="checkbox" name="statusDp" id="statusDp" onclick="ubah_statusx()" <?php echo $status_dp; ?>> <label for="statusDp"> Check for Deposit invoice</label>
                                                <input type="hidden" name="stsDP" id="stsDP" value="NoDP" />
                                            </div>
                                        </div>
                                    </div>-->
                </div>
                <hr />
                <div class="hidden">  
                  <a class="btn green" data-toggle="modal" id="co" href="#coa" title="Serch COA number"><i class="fa fa-search"></i> Add Detail With COA</a>
                </div>

                <a class="btn btn-primary" data-toggle="modal" data-target=".modal-item"><i class="fa fa-plus"></i> Search Item</a>
                <div id="demo" style="display: none"></div>

                <a class="btn btn-success" data-toggle="modal" data-target=".modal-ap"><i class="fa fa-search"></i> From AP</a>
                <div id="demo" style="display: none"></div>

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
                      Item ID
                    </th>
                    <th width="8%">
                      Sales Account Detail
                    </th>
                    <th width="8%">
                      Department Code
                    </th>
                    <th width="8%">
                      <!-- Container No 1 -->
                       B/L Code
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
                    <th width="7%">
                      Price
                    </th>
                    <th width="7%">
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
                      GST Value
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
                  ?>
                      <tr id="coa<?php echo $no++; ?>">
                        <td style="text-align: center;">
                          <input type="hidden" name="Detail_item_id[]" value="<?php echo $v->DetailID; ?>" />
                          <input type="hidden" name="NoUrut[]" value="0" />
                          <button class="tombol" onclick="hapus_dp(this)">Remove</button>
                        </td>
                        <td><input type="text" class="txt" name="Detail_po[]" value="<?php echo $v->no_po; ?>" /></td>
                        <td>
                          <input type="text" id="nocoa<?php echo $n++; ?>" name="txtCOA[]" ondblclick="cek_tr_id(this.id)" value="<?php echo $v->NoCOA; ?>" class="no_coa txt txtCOA">
                        </td>
                        <?php if($v->dept_code == '0' || $v->dept_code == ''){?>
                          <td><input type="text" class="txt" name="txtdept[]" value="000" /></td>
                        <?php } else { ?>
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
                        <?php }?>
                        <td><input type="text" class="txt" name="txtContainerNo[]" value="<?php echo $v->containerNo; ?>" /></td>
                        <td><textarea name="txtItem[]" rows="1" cols="30" id="namacoa<?php echo $m++; ?>" class="txt txtNmCOA"><?php echo $v->Items; ?></textarea></td>
                        <td><input type="text" class="txt number quantity" name="txtQty[]" value="<?php echo number_format($v->Qty, 2, '.', ','); ?>" onkeypress="return isNumber(event);" onKeyup="hitung_total()" /></td>
                        <td>
                          <input type="text" name="txtUnit[]" class="txt" value="<?php echo $v->Unit; ?>" />
                          <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" />
                        </td>
                        <td><input type="text" class="txt number prices" name="txtPrice[]" value="<?php echo number_format($v->Harga, 4, '.', ','); ?>" onKeyup="hitung_total()" /></td>
                        <td><input type="text" class="txt number amount" name="txtAmount[]" onkeypress="return isNumber(event);" value="<?php echo number_format($v->Qty * $v->Harga, 2, '.', ','); ?>" /></td>
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
              
              <!-- ini untuk attachment receivable -->
              <p class="text-danger"><i class="fa fa-file-pdf-o"></i> Attachment</p>
              <table class="table table-bordered" id="tabel-atch">
                <thead>
                  <tr>
                    <th width="1%">
                      <a class="btn btn-success" onclick="tambah_atch()"><i class="fa fa-plus"></i></a>
                    </th>
                    <th width="8%">
                      File
                    </th>
                    <th width="8%">
                      Remarks
                    </th>
                  </tr>
                </thead id="tbody-atch">

                <tbody>
                  <?php
                  if (!empty($attach)) {
                    foreach ($attach as $value) { ?>
                      <tr>
                        <td class="text-center">
                          <button class="tombol" onclick="hapus_atch_delete(this)" data-id="<?= $value->id ?>">Remove</button>
                        </td>
                        <td>
                          <a class="btn btn-block btn-sm btn-info btn-circle" href="<?= base_url('uploads/' . $value->file_name) ?>" target="_blank">Click View Document</a>
                        </td>
                        <td>
                          <input type="text" name="remarks[]" value="<?= $value->remark ?>" class="form-control" placeholder="input your remark here...">
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
              <hr />
              <!-- ini tutup untuk attachment receivable -->

              <table class="table table-bordered" id="table_jurnal">
                <thead>
                  <th></th>
                  <th width="7%">Account Number</th>
                  <th width="7%">Department Code</th>
                  <th width="5%">D/C</th>
                  <th width="20%">Account Name</th>
                  <th width="20%">Description</th>
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
                      if ($type == 'CCN') {
                        $DetailID1 = $z->DetailID;
                        $NoCOA1 = "400165";
                        $chk1x = 'value="D" selected';
                        $chk1 = 'value="C"';
                        $Debit1 =  number_format($z->Debet, 2, '.', '');;
                        $credit1 = "0";

                        $desc1 = "Customer";
                        $Total1 = number_format($z->Total, 2, '.', '');
                      }else{
                        $DetailID1 = $z->DetailID;
                        $NoCOA1 = "400165";
                        $chk1x = 'value="D" ';
                        $chk1 = 'value="C" selected';
                        $Debit1 = "0";
                        $credit1 = number_format($z->Kredit, 2, '.', '');

                        $desc1 = "Customer";
                        $Total1 = number_format($z->Total, 2, '.', '');
                      }
                      
                    }
                  } else {
                    $DetailID1 = "0";
                    $NoCOA1 = "400165";
                    $chk1 = 'value="C" selected';
                    $chk1x = 'value="D" ';
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
                        $Debit2 = number_format($x->Debet, 2, '.', '');
                        $credit2 = "0";
                      } else {
                        $chk2 = 'value="C" selected';
                        $chk2x = 'value="D"';
                        $credit2 = number_format($x->Kredit, 2, '.', '');
                        $Debit2 = "0";
                      }
                      $desc2 = $x->Uraian;
                      $Total2 = number_format($x->Total, 2, '.', '');
                    }
                  } else {
                    $DetailID2 = "0";
                    $NoCOA2 = "400301";
                    $chk2 = 'value="C" ';
                    $chk2x = 'value="D" selected';
                    $credit2 = "0";
                    $Debit2 = "0";
                    $desc2 = "Sales Discount";
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
                        $chk3 = 'value="C" selected';
                        $chk3x = 'value="D"';
                        $credit3 = number_format($w->Kredit, 2, '.', '');
                        $Debit3 = "0";
                      }
                      $desc3 = $w->Uraian;
                      $Total3 = $w->Total;
                    }
                  } else {
                    $DetailID3 = "0";
                    $NoCOA3 = "400101";
                    $chk3 = 'value="C" selected';
                    $chk3x = 'value="D" ';
                    $credit3 = "0";
                    $Debit3 = "0";
                    $desc3 = "GST Output Tax";
                    $Total3 = "0";
                  }

                  //Additional Cost
                  if (!empty($get_data_jurnal4)) {
                    foreach ($get_data_jurnal4 as $u) {
                      $DetailID4 = $u->DetailID;
                      $NoCOA4 = $u->NoCOA;
                      if ($u->chk == 'D') {
                        $chk4x = 'value="D" ';
                        $chk4 = 'value="C" selected';
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
                      $dept3 = $u->dept_code;
                    }
                  } else {
                    $DetailID4 = "0";
                    $NoCOA4 = "";
                    $chk4 = 'value="C"';
                    $chk4x = 'value="D"  selected';
                    $credit4 = "0";
                    $Debit4 = "0";
                    $desc4 = "";
                    $Total4 = "0";
                    // $dept3 = $u->dept_code;
                    $dept3 = "";
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
                      $desc5 = $u->Uraian;
                      $Total5 = $u->Total;
                    }
                  } else {
                    $DetailID5 = "0";
                    $NoCOA5 = "200508";
                    $chk5 = 'value="C" ';
                    $chk5x = 'value="D"  selected';
                    $credit5 = "0";
                    $Debit5 = "0";
                    $desc5 = "Customer Deposit";
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
                      $dept5 = $u->dept_code;
                    }
                  } else {
                    $DetailID6 = "0";
                    $NoCOA6 = "";
                    $chk6x = 'value="D" selected';
                    $chk6 = 'value="C" ';
                    $credit6 = "0";
                    $Debit6 = "0";
                    $desc6 = "";
                    $Total6 = "0";
                    // $dept5 = $u->dept_code;
                    $dept5 = "";
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
                        <input hidden type="hidden" name="dept_code[0]" value="0">
                        <input type="text" value="000" class="dept_code txt">
                    </td>
                    <td>
                      <select name="dk[]" id="dk_sales" onchange="hitung_total()" class="txt dk">
                        <option <?php echo "$chk1x"; ?>>D</option>
                        <option <?php echo "$chk1"; ?>>C</option>
                      </select>
                    <td>
                      <input type="hidden" name="NoUrut[0]" value="1" class="txt">
                      <input type="text" name="JenisJurnal[0]" value="Sales" class="txt">
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
                      <input hidden type="hidden" name="dept_code[1]" value="0">
                      <input type="text" value="000" class="dept_code txt">
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
                      <input hidden type="text" name="dept_code[2]" value="000" class="dept_code txt">
                      <input type="text" value="000" class="dept_code txt">
                    </td>
                    <td>
                      <select name="dk[2]" onchange="hitung_total()" class="txt dk">
                        <option <?php echo "$chk3x"; ?>>D</option>
                        <option <?php echo "$chk3"; ?>>C</option>
                      </select>
                    <td>
                      <input type="hidden" name="NoUrut[2]" value="3" class="txt">
                      <input type="text" name="JenisJurnal[2]" value="Tax" class="txt">
                      <input type="hidden" name="SubAccountId[2]" value="TAX" class="txt">
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
                    <td id="txtDeptCodeRow3">
                        <input type="text" name="dept_code[3]" value="<?php echo "$dept3" ?>" class="dept_code txt" readonly>
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
                      <input hidden type="text" name="dept_code[4]" value="0" class="dept_code txt">
                      <input type="text" value="000" class="dept_code txt">
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
                    <?php if ($dept5 == null): ?>
                      <td id="txtDeptCodeRow5">
                          <input type="text" value="" class="dept_code txt" readonly>
                      </td>
                    <?php else: ?>
                        <?php if ($dept5 == '000'): ?>
                          <td>
                            <input type="text" class="txt" value="000" readonly/>
                            <input hidden type="text" name="dept_code[5]" value="000" class="dept_code txt">
                          </td>
                        <?php else: ?>
                          <td>
                            <select name="dept_code[5]" class="txt">
                              <?php foreach ($dept_code as $deptItem): ?>
                                <option value="<?php echo $deptItem->dept_code; ?>" 
                                  <?php echo ($dept5 == $deptItem->dept_code) ? 'selected' : ''; ?>>
                                  <?php echo $deptItem->dept_name; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                        <?php endif; ?>
                    <?php endif; ?>

                    <td>
                      <select name="dk[5]" id="dk_ar" onchange="hitung_total()" class="txt dk">
                        <option <?php echo $chk6x; ?>>D</option>
                        <option <?php echo $chk6; ?>>C</option>
                      </select>
                    </td>
                    <td>
                      <input type="text" name="JenisJurnal[5]" value="Account Receivable" class="txt">
                      <input type="hidden" name="NoUrut[5]" value="6" class="txt">
                      <input type="hidden" name="SubAccountId[5]" value="PIU" class="txt">
                    </td>
                    <td><input type="text" name="desc[5]" value="<?php echo $desc6; ?>" class=" txt"></td>
                    <td class="total">
                      <input type="text" name="total_jr[5]" value="<?php echo number_format($Total6, 2, ".", ","); ?>" class="txt number jur_total" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                    </td>
                    <td><input type="text" name="rate_jr[5]" id="jr_rate6" class="txt number jr_rate" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="debt_jr[5]" value="<?php echo number_format($Debit6, 2, ".", ","); ?>" class="txt number jur_deb" onkeypress="return isNumber(event)"></td>
                    <td><input type="text" name="credit_jr[5]" value="<?php echo number_format($credit6, 2, ".", ","); ?>" class="txt number jur_credit" onkeypress="return isNumber(event)"></td>
                  </tr>

                  <!-- Account Receivable Berakhir -->

                  <tr>
                    <td colspan="10"></td>
                  </tr>
                </tbody>
              </table>
            </div>
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
            <!-- <a class="btn btn-success left" target="_blank" href="<?php echo site_url('Tims_invoice/print_report_zht/?id=' . encode_str($this->input->get('nofaktur'))) ?>">
              <i class="fa fa-file-pdf-o"></i> PDF
            </a> -->

            <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
            <a class="btn btn-warning" href="<?php echo base_url(); ?>index.php/Receivable_recognition_tims"><i class="fa fa-warning"></i> Cancel</a>
            <?php if ($this->input->get('id') <> '') { 
              $is_me = (strtoupper($this->session->userdata('userid_1')) === "FAUZI" || strtoupper($this->session->userdata('userid_1')) === "DESMOND-FOO" || strtoupper($this->session->userdata('userid_1')) === "WINNIE-LAU" || strtoupper($this->session->userdata('userid_1')) === "ANISA" || strtoupper($this->session->userdata('userid_1')) === "NICK");
                $readonly_attr = $is_me ? '' : 'disabled';
                $value_date    = $is_me ? $date_invoice : 'dd/mm/yyyy';
              ?>
              <div class="row">
                <div class="col-md-3 kanan">
                  <div style="margin-left: -4.5rem;display:flex;align-items:center;">
                    <label style="margin-right:10px; margin-bottom:0; white-space:nowrap;">
                      Approval by :
                    </label>
                    <select name="signiture"
                            onchange="ganti_signature()"
                            id="signature"
                            class="form-control kanan"
                            style="width:20rem;" <?php echo $readonly_attr; ?>>
                      <option value="Ms. Winnie Lau">Ms. Winnie Lau </option>
                      <option value="Mr. Desmond Foo">Mr. Desmond Foo </option>
                      <option value="Mr. Tahir Bin Abdul Aziz">Mr. Tahir Bin Abdul Aziz</option>
                      <option value="Ms. Cindy Lew">Ms. Cindy Lew </option>
                      <option value="Mr. Nick Chung">Ms. Nick Chung </option>
                    </select>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-4 kanan">
                  <div style="display:flex;gap: 4px;justify-content: flex-end;align-items: flex-start;">
                    <label style="align-self: center;margin-right:10px;white-space:nowrap;">
                      Approval of Date :
                    </label>

                    <input type="text"
                          style="width: 20rem;"
                          name="trgt_app"
                          id="target_app"
                          class="form-control date target-app kanan"
                          value="<?php echo $trgt_app; ?>"
                          placeholder="dd/mm/yyyy"
                          <?php echo $readonly_attr; ?>
                          data-date-format="dd/mm/yyyy"
                          required />

                    <a class="btn btn-primary  kanan" id="cetak" href="<?php echo base_url(); ?>index.php/Receivable_recognition_tims/print_report?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>&cur=<?php echo $currency_id; ?>&signature=Ms. Winnie Lau" target="_blank"><i class="fa fa-print"></i> Print</a>
                    <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>index.php/Receivable_recognition_tims/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
                  </div>
                </div>
              </div>

              <script type="text/javascript">
                function ganti_signature() {
                  var cetak = document.getElementById('cetak');
                  var locAppend = $('#signature').find('option:selected').val(),
                    locSnip = window.location.href.split('edit')[0];
                  cetak.href = locSnip + "print_report?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>&cur=<?php echo $currency_id; ?>&signature=" + locAppend;
                }
              </script>
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


<div class="modal fade" id="coa_detail" tabindex="-1" role="basic" aria-hidden="true">
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


<div class="modal fade modal-item" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myLargeModalLabel">Master Item Per Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-scrollable" id="detail_item_cust">
          <table id="tblitem" class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>GST Type</th>
                <th>No COA</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary waves-effect waves-light btn-save" onclick="select_item()">
            Choose
          </button>
          <button type="button" class="btn btn-secondary waves-effect " data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- INI UNTUK AMBIL NILAI AP DARI PROSEDURE -->
<div class="modal fade modal-ap" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myLargeModalLabel">Receivable Data From Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-scrollable" id="detail_ap_cust">
          <table id="tblap" class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>GST Type</th>
                <th>No COA</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary waves-effect waves-light btn-save" onclick="select_ap()">
            Choose
          </button>
          <button type="button" class="btn btn-secondary waves-effect " data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- INI TUTUP UNTUK AMBIL NILAI AP DARI PROSEDURE -->

<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#target_app').datepicker({
        dateFormat: 'dd/mm/yy',
        beforeShow: function(input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: $(input).offset().top - inst.dpDiv.outerHeight()
                });
            }, 0);
        }
    });
    var target_app = $('#target_app').val();
    var userId = "<?php echo strtoupper($this->session->userdata('userid_1')); ?>";

    var restrictedUsers = [
      "DESMOND-FOO",
      "WINNIE-LAU",
      "ANISA",
      "IAN-TOH",
      "NICK",
      "FAUZI"
    ];

    if (target_app.trim() !== '') {
      if (restrictedUsers.includes(userId)) {
        $('#btn_update').prop('disabled', false);
      }else{
        $('#btn_update').prop('disabled', true);
      }
    } else {
        $('#btn_update').prop('disabled', false);
    }

    
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    var tgl = $('#closing').val();
      $('.target').datepicker({
      'autoclose': true,
      'todayHighlight': !0,
      'startDate': tgl,
      'orientation': "top right",
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
          $('#tanggal_invoice').prop('disabled', true);
          $('#btn_update').prop('disabled', true);
        }
    }

    $("#tabel_dpi").dataTable({
      "scrollY": 400,
      "scrollX": true
    });

    get_item_cust("<?= $kode_sup ?>");
    get_ap_cust("<?= $kode_sup ?>");
    ganti_credit()
  });

  function get_item_cust(selectedCustomer) {
    $.ajax({
      url: "<?php echo base_url(); ?>Tims_invoice/tampil_item_cust?cust=" + selectedCustomer + "",
      success: function(response) {
        $("#detail_item_cust").html(response);
        // console.log(response);
      },
      dataType: "html"
    });
  }

  function get_ap_cust(selectedCustomer) {
    $.ajax({
      url: "<?php echo base_url(); ?>Tims_invoice/tampil_ap_cust?cust=" + selectedCustomer + "",
      success: function(response) {
        $("#detail_ap_cust").html(response);
      },
      dataType: "html"
    });
  }

  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Receivable_recognition_tims/selectInvoiceReceivable", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });

  window.onload = function () {
    cek_gst();       // Hitung nilai GST berdasarkan qty & price
    hitung_total();  // Jumlahkan semua nilai termasuk GST Output
  };

  
</script>