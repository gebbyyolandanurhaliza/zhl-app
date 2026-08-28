<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/autoNumeric-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script>
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

  function get_cur_purchase() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tanggal_invoice").value;
    document.getElementById("tgl_tempo").value = $docdate;
    var currency_id = document.getElementById('currency').value;

    var supp = document.getElementById('supplier').value;
    var belah = supp.split("|");
    var vendor = belah[0];

    var tgl1 = document.getElementById('tanggal_invoice').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];
    $a1 = 1;
    if ($('#invtype').val() === 'bar') {
      if ($('#dest_barge').val()) {
        $a1 = 1;
      } else {
        $a1 = 0;
      }
    }

    if ($a1 == 1) {
      $.ajax({
        url: "<?php echo base_url(); ?>Purchase_inv/ambil_currency?cur=" + $cur + "&date=" + $docdate + "",
        success: function(response) {
          $("#daftar_kurs").html(response);

          var cur = document.getElementById('rate_currency').value;
        },
        dataType: "html"
      });
    }


    // get_po();
  }

  function Rate_notfound() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tanggal_invoice").value;

    $a1 = 1;
    if ($('#invtype').val() === 'bar') {
      if ($('#dest_barge').val()) {
        $a1 = 1;
      } else {
        $a1 = 0;
      }
    }

    if ($a1 == 1) {
      $.ajax({
        url: "<?php echo base_url(); ?>Purchase_inv/accounting_rate?cur=" + $cur + "&date=" + $docdate + "",
        success: function(response) {
          $("#rate2").html(response);
        },
        dataType: "html"
      });
    }

    return false;
  }

  // Mulai ajax cari data
  function gettanggal() {
    hidden_vessel();
    $inv = $("#invtype").val();
    if ($inv === 'bar') {
      $ft = $('#dest_barge').val();
    } else {
      $ft = 0;
    }
    $ur = "<?php echo base_url(); ?>Sales_inv/getAjaxTanggal?jeninv=" + $inv + "&bargedest=" + $ft;
    console.log($ur);
    $.ajax({
      url: $ur,
      success: function(response) {
        $("#tlga").html(response);
      },
      dataType: "html"
    });
    get_port();
    cekbarge();

    return false;
    // 
  }


  function getDetailContainer() {
    $tgl = $("#tanggal_invoice").val();
    $invtype = $("#invtype").val();
    if (!$('#dest_barge').val()) {
      $bargedest = '0';
    } else {
      $bargedest = $('#dest_barge').val();
    }

    var url3 = "<?php echo base_url(); ?>Sales_inv/get_detail3?date=" + $tgl + "&invtype=" + $invtype + "&bargedest=" + $bargedest;
    console.log(url3);

    $.ajax({
      url: url3,
      success: function(response) {
        $("#dtl_cont").html(response);
      },
      dataType: "html"
    });

  }

  function get_port() {
    $tgl = $("#tanggal_invoice").val();
    $val = $("#buyer").val();
    $belah = $val.split('|');
    $supp = $belah[0];

    $invtype = $("#invtype").val();
    var urll = "<?php echo base_url(); ?>Sales_inv/get_port?date=" + $tgl + "&type=" + $invtype + "&buyer=" + $supp;
    console.log(5);
    console.log(urll);
    $.ajax({
      url: urll,
      success: function(response) {
        $("#gantiport").html(response);
      },
      dataType: "html"
    });
  }

  function getsup() {
    $jenis = $("#invtype").val();
    var tgl = $("#tanggal_invoice").val();
    $invtype = $("#invtype").val();
    //  $('#pizza_kind').prop('disabled', false);
    if ($jenis === 'bar') {

      if (!$('#dest_barge').val() && $("#tanggal_invoice").val()) {
        setPulsate('#dest_barge, #dest_barge');
        setToast('Please Select Form - To First');
        $('#tanggal_invoice').val('');
      } else {
        if (!$('#dest_barge').val()) {
          $bargedest = '0';
        } else {
          $bargedest = $('#dest_barge').val();
        }

        $("#barge").val('MARCOPOLO 252');
        $("#buyer").prop('disabled', 'disabled');
        var url2 = "<?php echo base_url(); ?>Sales_inv/get_detail2?date=" + tgl + "&invtype=" + $invtype + "&bargedest=" + $bargedest;
        console.log(2);
        console.log(url2);
        $.ajax({
          url: url2,
          success: function(response) {
            $("#detail_inv").html(response);
          },
          dataType: "html"
        });

        getDetailContainer();
      }

    } else {
      $("#buyer").prop('disabled', false);
      var urll = "<?php echo base_url(); ?>Sales_inv/get_sup?date=" + tgl + "&type=" + $invtype;
      console.log(1);
      console.log(urll);
      // alert(urll);

      $.ajax({
        url: urll,
        success: function(response) {
          $("#gantiincust").html(response);
        },
        dataType: "html"
      });
      get_port();
    }

    return false;

  }

  function hidden_vessel() {
    $invtype = $("#invtype").val();

    if ($invtype === 'fre') {
      $('#divvessel').show();
    } else {
      $('#divvessel').hide();
    }
  }

  function get_vessel() {
    $val = $("#buyer").val();
    $tgl = $("#tanggal_invoice").val();

    $belah = $val.split('|');

    $supp = $belah[0];
    $barge = $belah[1];
    $namebuy = $belah[2];
    $('#buyerin').val($supp);
    $('#barge').val($barge);
    $('#buyername').val($namebuy);

    $portes = $("#portes").val();

    $url1 = "<?php echo base_url(); ?>Sales_inv/get_vessel?date=" + $tgl + "&supp=" + $supp + "&invtype=" + $invtype + "&port=" + $portes;
    console.log(19);
    console.log($url1);

    $.ajax({
      url: $url1,
      success: function(response) {
        $("#gantivessel").html(response);
      },
      dataType: "html"
    });
    return false;

  }

  function isi_barge() {
    $barge = $('#vesselname').val();
    $('#barge').val($barge);
  }

  function get_isi() {
    $val = $("#buyer").val();
    $tgl = $("#tanggal_invoice").val();
    $invtype = $("#invtype").val();
    $belah = $val.split('|');

    $supp = $belah[0];
    $barge = $belah[1];
    $namebuy = $belah[2];
    $('#buyerin').val($supp);
    // $('#barge').val($barge);
    $('#buyername').val($namebuy);

    $portes = $("#portes").val();
    $vesselname = $('#vesselname').val();

    $url1 = "<?php echo base_url(); ?>Sales_inv/get_detail?date=" + $tgl + "&supp=" + $supp + "&invtype=" + $invtype + "&port=" + $portes + "&vesselname=" + $vesselname;
    console.log(9);
    console.log($url1);

    $.ajax({
      url: $url1,
      success: function(response) {
        $("#detail_inv").html(response);
      },
      dataType: "html"
    });
    return false;

  }

  function get_isi_det() {
    $val = $("#buyer").val();
    $tgl = $("#tanggal_invoice").val();
    $invtype = $("#invtype").val();
    $belah = $val.split('|');

    $supp = $belah[0];
    $barge = $belah[1];
    $namebuy = $belah[2];
    $('#buyerin').val($supp);
    // $('#barge').val($barge);
    $('#buyername').val($namebuy);

    $portes = $("#portes").val();
    $vesselname = $('#vesselname').val();

    $url2 = "<?php echo base_url(); ?>Sales_inv/get_detailfre?date=" + $tgl + "&supp=" + $supp + "&invtype=" + $invtype + "&port=" + $portes + "&vesselname=" + $vesselname;
    console.log(29);
    console.log($url2);

    $.ajax({
      url: $url2,
      success: function(response) {
        $("#dtl_cont").html(response);
      },
      dataType: "html"
    });
  }




  function cekbarge() {
    $inv = $("#invtype").val();
    if ($inv === 'bar') {
      $("#bargedest").show();
      $("#divbuyer").hide();
      $("#divport").hide();
    } else {
      $("#bargedest").hide();
      $("#divbuyer").show();
      $("#divport").show();
    }
  }

  function hitung_total(x) {
    $txt = "txtHarga-" + x;
    $total = "#txtTotal-" + x;
    $unit = "#unit-" + x;
    $usd = "txtUSD-" + x;
    $rate = $("#rate_currency").val();
    $t = $($unit).val();
    // console.log($rate);
    $harga = document.getElementById($txt).value;
    console.log($harga);
    $amount = $t * $harga;
    $totusd = $t * $harga * $rate;
    $($total).val($amount);
    console.log($totusd);
    document.getElementById($usd).value = $totusd;

    hitung_semua();
  }

  function cek_gst(x) {
    $gst = "txtGST-" + x;
    $usd = "txtTotal-" + x;
    $gstvalue = "txtGSTValue-" + x;

    $gst_t = document.getElementById($gst).value;
    $usd = document.getElementById($usd).value;

    if ($gst_t === "GST") {
      $v = $usd * 7 / 100;
    } else {
      $v = 0;
    }

    document.getElementById($gstvalue).value = $v;

    hitung_semua();
  }

  function hitung_semua() {

    var txt = document.getElementsByClassName("txtTotal");
    var usd = document.getElementsByClassName("txtUSD");
    var gst = document.getElementsByClassName("txtGSTValue");
    var th = 0;
    var tu = 0;
    var tg = 0;
    for (var i = 0; i < txt.length; i++) {
      th += parseFloat(txt[i].value.replace(/,/g, ""));
      tu += parseFloat(usd[i].value.replace(/,/g, ""));
      tg += parseFloat(gst[i].value.replace(/,/g, ""));
      // alert('adaerror');
    }

    $tsm = parseFloat(tg) + parseFloat(tu);

    document.getElementById("totalinv").value = th;
    document.getElementById("totalinvusd").value = tu;
    document.getElementById("totalgst").value = tg;
    document.getElementById("stotalinv").value = $tsm;

  }

  function ambil_harga(x) {
    // alert(x);
    $z = "#idcont-" + x;
    $idcont = $($z).val();
    $j = "#jenisbarge-" + x;
    $idjenis = $($j).val();
    $harga = "#txtHarga-" + x;



    $url1 = "<?php echo base_url(); ?>Sales_inv/getharga?idcont=" + $idcont + "&jen=" + $idjenis + "&x=" + x;

    console.log($url1);
    // alert($url1);
    $.ajax({
      url: $url1,
      success: function(results) {
        console.log(results);
        $isi = "#isi-" + x;
        $($isi).html(results);
        hitung_total(x);
        // $ayam = results;
        // $($harga).val(results);
        // document.getElementById($harga).value = results;
        // alert(results);
        // $($harga).val(results);
        // $("#tlga").html(response);
      },
      dataType: "html"
    });

    // alert($ayam);
    // console.log($ayam);

  }

  function setPulsate(elm) {
    $(elm).pulsate({
      color: "#D9000B",
      reach: 30,
      repeat: 5,
      speed: 500,
      glow: true
    });
  }

  function setToast(txtMsg) {
    $('#toast-container').stop().fadeIn(300).delay(1000).fadeOut(600);
    $('.toast-message').html(txtMsg);
  }
</script>

<?php
if (!empty($get_data_header)) {
  foreach ($get_data_header as $s) {
    $nofaktur = $s->nofaktur;
    $kode_sup = $s->customer_id;
    $supname = $s->namacustomer;
    $supplier_id = $s->kode_sup . "|" . $s->coa;
    $jenis_in = $s->jenis_inv;
    $NoCOA = $s->coa;
    $currency_id = $s->currency;
    $Currency_symbol = $s->currency;
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
    $voyage = $s->voyage;
    $buyer = $s->buyer;
    $destbarge = $s->destbarge;
    // if ($s->status_dp == 1) {
    //     $status_dp = "checked";
    // } else {
    //     $status_dp = "";
    // }
  }
} else {
  $jenis_in = '';
  $nofaktur = '';
  $kode_sup = '';
  $currency_id = 'USD';
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
  $voyage = '';
  $buyer = '';
  $destbarge = '';
}
?>

<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>Sales_inv/save_sales_inv" method="post">



        <div class="col-md-12">


          <input type="hidden" id="closing_date" name="closing_date" value="<?php echo $this->session->userdata('closing_date'); ?>" />
          <div id="error_id"></div>
          <!-- <?php echo $message; ?> -->
          <div class="portlet light">
            <div class="portlet-title">
              <div id="rate2" style="color: #5a7391"></div>
              <div class="caption">

                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Sales Invoice Journal</span>
              </div>
              <div class="form-group">
                <?php if ($this->input->get('id') <> '') { ?>
                  <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Sales_inv/add_new"><i class="fa fa-plus"></i> Create New</a>
                <?php
                } else {
                  // echo "<label class='btn kanan' style='color:red'>Closing Date: " . $this->session->userdata('closing_date') . "</label>";
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
                      <label class="control-label col-md-3">Invoice Type </label>
                      <div class="col-md-9">
                        <select name="invtype" id="invtype" class="form-control select2me" onchange="gettanggal()">
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
                        </select>
                      </div>
                    </div>

                    <?php
                    if ($jenis_in === 'bar') {
                      $style1 = 'style="display: none"';
                      $style2 = '';
                    } else {
                      $style2 = 'style="display: none"';
                      $style1 = '';
                    }
                    ?>

                    <div class="form-group" id="bargedest" <?= $style2; ?>>

                      <label class="control-label col-md-3">Form - To</label>
                      <div class="col-md-9">
                        <div id="toast-container" class="toast-top-right" aria-live="polite" role="alert" style="display : none; font-size: 20">
                          <div class="toast toast-error" style="display: block;">
                            <div class="toast-message">Are you the six fingered man?</div>
                          </div>
                        </div>
                        <select name="dest_barge" id="dest_barge" class="form-control" onchange="gettanggal()">
                          <option></option>
                          <option value="idn" <?php if ($destbarge === 'idn') {
                                                echo 'SELECTED';
                                              } ?>>Indonesia - Singapore</option>
                          <option value="sin" <?php if ($destbarge === 'sin') {
                                                echo 'SELECTED';
                                              } ?>>Singapore - Indonesia</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group" id="divbuyer" <?= $style1; ?>>
                      <label class="control-label col-md-3">Buyer</label>
                      <div class="col-md-9">
                        <div id="gantiincust">
                          <?php
                          if ($supplier_id === '') {
                            // get_isi
                            $style_kategori = "class='select2me form-control' onchange='get_port()' id='buyer' $disable";
                            echo form_dropdown('buyer', $buyer, $supplier_id, $style_kategori);
                            echo "<input type='hidden' name='buyer' id='buyerin'  class='form-control' value='$kode_sup'/>";
                            // echo "<input type='hidden' name='suppliername' id='suppname'  class='form-control' value=''/>";
                            // echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value='$NoCOA'/>";    
                          } else {
                            echo "<input type='hidden' name='buyer' id='buyer'  class='form-control' value='$buyer'/>";
                            echo "<input type='text' name='buyerName' id='buyername'  class='form-control' value='$buyer' readonly/>";
                            // echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value='$NoCOA'/>";    
                          }

                          ?>
                        </div>
                      </div>
                    </div>

                    <div class='form-group' id="divport" <?= $style1; ?>>
                      <label class="control-label col-md-3">Port</label>
                      <div class="col-md-9">
                        <div id="gantiport">
                          <select class="form-control" name='portes' id='portes'>
                            <option></option>
                          </select>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-md-3">Customer</label>
                      <div class="col-md-9">
                        <!-- supplier -->
                        <?php
                        $style_kategori = "class='select2me form-control' id='supplier' required";
                        echo form_dropdown('supplier', $customer, $kode_sup, $style_kategori);
                        ?>
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
                          <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $rate_sgd; ?>" onkeypress="return isNumber(event)" <?php echo $readonly; ?> readonly />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Shipment Date</label>
                      <div class="col-md-3">
                        <?php if ($nofaktur === '') { ?>
                          <div id="tlga">
                            <select class="form-control">
                              <option></option>
                            </select>
                          </div>
                        <?php } else { ?>
                          <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date date-picker" value="<?php echo $date_invoice; ?>" data-date-format="dd/mm/yyyy" <?php echo $readonly; ?> required />
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-3">
                        <div id="cur_id">
                          <?php
                          $style_currency = "class='form-control' id='currency' onchange='get_cur_purchase();Rate_notfound();'";
                          echo form_dropdown('Currency', $Currency, $currency_id, $style_currency);
                          echo "<input type='hidden' name='xxx' id='cursyp'  class='form-control' value='$currency_id'/>";
                          ?>
                        </div>
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
                    <div class="form-group">
                      <label class="control-label col-md-3">Barge / Voy No.</label>
                      <div class="col-md-3">
                        <input type="text" id="barge" name="barge" class="form-control" value="<?php echo $voyage; ?>" />
                      </div>
                    </div>

                    <div class="form-group" <?= $style1; ?> id='divvessel'>
                      <label class="control-label col-md-3">Vessel Name</label>
                      <div class="col-md-3">
                        <div id="gantivessel">
                          <select id='vesselname' class="form-control">
                            <option></option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr />

                <a class="btn btn-primary" data-toggle="modal" href="#deposit" id="tombol_dp" style="display: none" onclick="ambil_tabel()"><i class="fa fa-money"></i> Select Deposit</a>

                <div class="col-md-2 kanan">
                  <input type="hidden" id="nota_debet" name="nota_debet" value="<?php echo $nota_debet; ?>" class="form-control" onkeypress="return isNumber(event)" required />
                </div>
                <div id="demo" style="display: none"></div>
                <!-- <hr/> -->

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

              <!-- Div detail container -->
              <div class="modal fade" id="trndtlcnt" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog modal-full">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title">Detail Container</h4>
                      <!-- <input class="form-control" type="text" id="search" placeholder="search"> -->
                    </div>
                    <div class="modal-body">
                      <section class="">
                        <div class="contain">
                          <div id="dtl_cont">

                          </div>
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
              <!-- End Div -->

              <!--                             <button class="btn btn-default" id="btndtlcnt" type="button">
                             <i class="fa fa-sm fa-eye fa-fw" aria-hidden="true"></i> Look Detail Container</button>
 -->
              <a class="btn btn-primary" data-toggle="modal" href="#trndtlcnt" id="btnctldtl"><i class="fa fa-eye"></i> Look Detail Container</a>
              <hr>

              <div id="detail_inv">

                <table class="table table-bordered" id="tabel">
                  <?php if ($jenis_in === 'bar') {
                    $hide = '';
                  } else {
                    $hide = 'hidden';
                  } ?>
                  <tr>
                    <th>Account Number</th>
                    <th>Acoount Name</th>
                    <th>Items</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th <?= $hide; ?>>Type Barge</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>USD Equivalent</th>
                    <th>Gst Type</th>
                    <th>Gst Value</th>
                  </tr>
                  <?php
                  if (!empty($get_data_detail)) {
                    $i = 0;
                    foreach ($get_data_detail as $r) {
                  ?>
                      <tr>
                        <td>
                          <input type="hidden" name="detailidcont[]" value="<?= $r->detailCont ?>">
                          <input type="hidden" name="idcontainer[]" value="<?= $r->ItemID ?>">
                          <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                        </td>
                        <td>
                          <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Purchase">
                        </td>
                        <td>
                          <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php echo $r->ItemName; ?></textarea>
                        </td>
                        <td>
                          <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->description; ?></textarea>
                        </td>
                        <td <?= $hide; ?>>
                          <select name="jenisbarge[]" id="jenisbarge-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)">
                            <option></option>
                            <option value="1" <?php if ($r->type_barge == 1) {
                                                echo 'SELECTED';
                                              } ?>>Export Empty</option>
                            <option value="2" <?php if ($r->type_barge == 2) {
                                                echo 'SELECTED';
                                              } ?>>Export Laden</option>
                            <option value="3" <?php if ($r->type_barge == 3) {
                                                echo 'SELECTED';
                                              } ?>>Import Transhipment</option>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="unit[]" class="txt unit number" id="unit-<?= $i; ?>" value="<?= $r->unit; ?>">
                        </td>

                        <td>
                          <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="<?= number_format($r->price, 0); ?>">
                        </td>
                        <td>
                          <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='<?php echo $r->unit * $r->price * $rate; ?>' readonly>
                        </td>
                        <td>
                          <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='<?= $r->usdequivalent; ?>' readonly>
                        </td>
                        <td>
                          <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST" <?php if ($r->gst_type === 'GST') {
                                                  echo "SELECTED";
                                                } ?>>GST</option>
                            <option value="ZER" <?php if ($r->gst_type === 'ZER') {
                                                  echo "SELECTED";
                                                } ?>>Zero Rate</option>
                            <option value="EXP" <?php if ($r->gst_type === 'EXP') {
                                                  echo "SELECTED";
                                                } ?>>Exampt</option>
                            <option value="OUT" <?php if ($r->gst_type === 'OUT') {
                                                  echo "SELECTED";
                                                } ?>>Out of Scope</option>
                          </select>
                        </td>
                        <td>
                          <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="<?= $r->gst_value; ?>" />
                        </td>
                      </tr>
                    <?php
                      $i++;
                    } ?>
                    <?php if ($hide == 'hidden') {
                      $rw = 6;
                    } else {
                      $rw = 7;
                    } ?>
                    <tr>
                      <td colspan="<?= $rw; ?>" align="right">TOTAL</td>
                      <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
                      <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
                      <td></td>
                      <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
                    </tr>
                    <tr>
                      <td colspan="<?= $rw; ?>" align="right">GRAND TOTAL</td>
                      <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
                    </tr>
                  <?php
                  }
                  ?>

                </table>
              </div>
              <hr />
            </div>

            <button class="btn btn-default" id="btnFindRecord" type="button">
              Find <i class="fa fa-sm fa-search fa-fw" aria-hidden="true"></i> </button>

            <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
            <a class="btn btn-warning" href="<?php echo base_url(); ?>Sales_inv"><i class="fa fa-warning"></i> Cancel</a>
            <a href="<?php echo base_url(); ?>Sales_inv/printerin?id=<?= $nofaktur; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Print</a>
            <?php if ($this->input->get('id') <> '') { ?>
              <!--                            <a class="btn btn-primary  kanan" href="<?php echo base_url(); ?>Sales_inv/print_report?id=<?php //echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); 
                                                                                                                                          ?>" target="_blank"><i class="fa fa-print"></i> Print</a>-->
              <a class="btn btn-danger kanan" href="<?php echo base_url(); ?>Sales_inv/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
            <?php } ?>
          </div>
        </div>
      </form>
    </div>
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

</div>

<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of PO Factory</h4>
        <input class="form-control" type="text" id="search" placeholder="search">
      </div>
      <div class="modal-body">
        <section class="">
          <div class="contain">
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
    hitung_semua();
    $("#tabel_dpi").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });

  $("#btnFindRecord").click(function() {
    $.post("<?php echo site_url(); ?>Sales_inv/selectInvoiceFactory", function(data) {
      $('#contentFindAP').html(data);
    });
    $('#modal-findAP').modal('show');
  });
</script>