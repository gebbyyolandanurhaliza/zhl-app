<link href="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="error_id">
          <?php echo $message; ?>
        </div>
        <div class="portlet light">
          <div class="portlet-title">
            <div id="rate2" style="color: #5a7391"></div>
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Invoice TIMS</span>
            </div>
            <div class="form-group">
              <?php if ($this->input->get('id') <> '') { ?>
                <a class="btn btn-primary kanan" href="<?php echo base_url(); ?>Tims_invoice/add_new"><i class="fa fa-plus"></i> Create New</a>
              <?php
              } else {
                // echo "<label class='btn kanan' style='color:red'>Closing Date: " . $tgl . "</label>";
              }
              ?>
            </div>
          </div>
          <div class="portlet-body">
            <form action="<?php echo $action; ?>" id="form1" method="post" irole="form">
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
                          <input type="hidden" name="JenisJurnal" id="jenis" value="INV" onchange="ganti_credit()" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Ref. Number</label>
                      <div class="col-md-9">
                        <input type="text" id="refno" name="nofaktur" value="<?= $Noinv ?>" class="form-control" onchange="cek_nofak()" <?php echo $readonly; ?> />
                        <label class="CurID"></label>
                      </div>
                    </div>

                    <div class="form-group">
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
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Ship to</label>
                      <div class="col-md-9">
                        <input type="text" id="address" name="address" value="<?= $Address ?>" class="form-control" <?php echo $readonly; ?> />

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Destination Country</label>
                      <div class="col-md-9">
                        <input type="text" id="country" name="country" value="<?= $Country ?>" class="form-control country" <?php echo $readonly; ?> />

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <div id="cur_id">
                          <input type="text" name="currency" id="currency" class="form-control" value="<?= $currency ?>" readonly>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div id="daftar_kurs">
                      <div class="form-group">
                        <label class="control-label col-md-2">Vessel</label>
                        <div class="col-md-4">
                          <input type="text" name="vessel" class="form-control" value="<?= $Vessel ?>" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2">Your Ref</label>
                        <div class="col-md-4">
                          <input type="text" name="reff" class="form-control" value="<?= $Reff ?>" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2">Shipper</label>
                        <div class="col-md-4">
                          <input type="text" name="shipper" class="form-control" value="<?= $Shipper ?>" />
                        </div>
                      </div>

                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Term</label>
                      <div class="col-md-4">
                        <input type="text" id="term" name="term" value="<?php echo $Term; ?>" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required />
                        <input type="hidden" id="symbol_currency" name="symbol_currency" value="<?php echo $Currency_symbol; ?>" class="form-control" />
                        <input type="hidden" id="currency_val" name="currency_val" value="<?php echo $rate; ?>" class="form-control currency_val" />

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Invoice Date</label>
                      <div class="col-md-4">
                        <input type="text" name="tgl_invoice" id="tanggal_invoice" class="form-control date target" value="<?php echo $Invoice_date; ?>" data-date-format="dd/mm/yyyy" required />
                      </div>
                    </div>

                    <div class="form-group" Hidden>
                      <label class="control-label col-md-2">Date of Journal</label>
                      <div class="col-md-4">
                        <input type="text" id="tgl_tempo" name="tgl_jurnal" class="form-control input-sm " value="<?php echo $Invoice_date; ?>" data-date-format="dd/mm/yyyy" readonly required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Delivery Date</label>
                      <div class="col-md-4">
                        <input type="text" id="tgl_invoice" name="tgl_tempo" class="form-control" value="<?php echo $tgl_tempo; ?>" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">PO Number</label>
                      <div class="col-md-4">
                        <input type="text" name="po_number" id="po_number" class="form-control" value="<?php echo $po_number; ?>" required />
                      </div>
                    </div>
                  </div>
                </div>
                <hr />
                <!-- <a class="btn green" onclick="cari_job()" title="Serch Job"><i class="fa fa-search"></i> Search Job Detail</a> -->
                <a class="btn btn-primary" data-toggle="modal" data-target=".modal-item"><i class="fa fa-plus"></i> Search Item</a>
                <div id="demo" style="display: none"></div>
                <hr />
              </div>
              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="3%">
                      <!-- <a class="btn green" onclick="tambah_job()"><i class="fa fa-plus"></i> </a> -->
                    </th>
                    <th width="10%" hidden>

                    </th>
                    <th width="5%">
                      ItemId
                    </th>
                    <th width="10%">
                      Job
                    </th>
                    <th width="20%">
                      Description
                    </th>
                    <th width="8%">
                      Ship (Qty)
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


                    <th width="7%">
                      GST Type
                    </th>
                    <th width="8%">
                      GST Value
                    </th>


                  </tr>
                </thead>

                <tbody>
                  <?php
                  if (isset($dtl)) {
                    foreach ($dtl as $val) { ?>
                      <tr>
                        <td>
                          <button class="btn red" onclick="hapus_baris(this)"><i class="fa fa-trash"></i></button>
                        </td>
                        <td hidden>
                          <input type="text" name="Detail_item_id[]" value="<?= $val->Detail_id ?>" class="Detail_id txt">

                        </td>
                        <td>
                          <input type="text" name="Backorder[]" value="<?= $val->Backorder ?>" class="Backorder txt">
                        </td>
                        <td>
                          <input type="text" name="job[]" value="<?= $val->Job ?>" class="job txt">
                        </td>
                        <td>
                          <input type="text" name="Item_number[]" value="<?= $val->Item_desc ?>" class="no_coa txt">
                        </td>
                        <td>
                          <input type="text" name="Ship[]" value="<?= $val->Qty ?>" class="quantity  txt number" onkeypress="return isNumber(event);" onKeyup="hitung_amount();cek_gst();">
                        </td>
                        <td>
                          <input type="text" name="Price[]" value="<?= $val->Price ?>" class="prices txt number" onKeyup="hitung_amount()" onkeypress="return isNumber(event)">
                        </td>
                        <td>
                          <input type="text" name="Amount[]" value="<?= $val->Amount ?>" class="amount txt number" onkeypress="return isNumber(event)">
                        </td>
                        <td>
                          <input type="text" name="Discount[]" value="<?= $val->Discount ?>" class="discount txt number" onkeypress="return isNumber(event)">
                        </td>
                        <td>
                          <input type="text" name="after_disc[]" value="" class="after_disc txt number" onkeypress="return isNumber(event)">
                        </td>
                        <td>
                          <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST" <?php
                                                if ($val->Tax_type == 'GST') {
                                                  echo "selected";
                                                }
                                                ?>>GST</option>
                            <option value="ZER" <?php
                                                if ($val->Tax_type == 'ZER') {
                                                  echo "selected";
                                                }
                                                ?>>Zero Rate</option>
                            <option value="EXP" <?php
                                                if ($val->Tax_type == 'EXP') {
                                                  echo "selected";
                                                }
                                                ?>>Exampt</option>
                            <option value="OUT" <?php
                                                if ($val->Tax_type == 'OUT') {
                                                  echo "selected";
                                                }
                                                ?>>Out of Scope</option>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="txtGSTValue[]" value="<?= $val->Tax_value ?>" class="txtGSTValue txt number" onkeypress="return isNumber(event)">
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
              <hr />
              <div class="col-md-9"></div>
              <div class="col-md-3" style="margin-top:10px;">
                <div class="form-group" style="margin-bottom:1px;">
                  <div class="col-sm-4">
                    <label>Total</label>
                  </div>
                  <div class="col-sm-8">
                    <input class=" form-control  number total_subtotal" name="total" id="total" value="<?= $Total ?>" required readonly>
                  </div>
                </div>
                <div class="form-group" style="margin-bottom:1px;">
                  <div class="col-sm-4">
                    <label>Freight</label>
                  </div>
                  <div class="col-sm-8">
                    <input class="form-control text-right number" onkeypress="return isNumber(event)" data-v-min="0" name="freight" id="freight" value="<?= $Freight ?>" onkeyup="hitung_total()">
                  </div>
                </div>
                <div class="form-group" style="margin-bottom:1px;">
                  <div class="col-sm-4">
                    <label>Tax</label>
                  </div>
                  <div class="col-sm-8">
                    <input class="form-control  number total_tax" name="amount_tax" id="amount_tax" value="<?= $Tax ?>" readonly>
                  </div>
                </div>
                <div class="form-group" style="margin-bottom:1px;">
                  <div class="col-sm-4">
                    <label>Total Amount</label>
                  </div>
                  <div class="col-sm-8">
                    <input class="form-control text-right" name="amount_due" id="amount_due" value="<?= $Total_amount ?>" required readonly>
                  </div>
                </div>
              </div>
              <hr />
              <button type="submit" name="sbt" id="btn_update" class="btn btn-primary" value="<?php echo $submit_value; ?>"><i class="fa fa-save"></i> <?php echo $submit_value; ?></button>
              <a class="btn btn-warning" href="<?php echo base_url(); ?>Tims_invoice"><i class="fa fa-warning"></i> Cancel</a>
              <?php if ($this->input->get('id') <> '') { ?>
                 <?php if(substr($Noinv, 0, 3) === 'ZHT'){?>
            <a class="btn btn-success left" target="_blank" href="<?php echo site_url('Tims_invoice/print_report_zht/?id=' . encode_str($this->input->get('id'))) ?>">
              <i class="fa fa-file-pdf-o"></i> PDF
            </a>
            <?php }else{?>
              <a class="btn btn-success left" target="_blank" href="<?php echo site_url('Tims_invoice/print_report/?id=' . encode_str($this->input->get('id'))) ?>">
              <i class="fa fa-file-pdf-o"></i> PDF
            </a>
            <?php } ?>
                <a class="btn btn-danger left" href="<?php echo base_url(); ?>Tims_invoice/delete_transaction?id=<?php echo htmlspecialchars($this->input->get('id'), ENT_QUOTES); ?>" onclick="return confirm('Are you sure to delete this transaction?')"><i class="fa fa-trash"></i> Delete</a>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="po_v" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of JOB</h4>
        <input class="form-control" type="text" id="search" placeholder="search">
      </div>
      <div class="modal-body">
        <section class="">
          <div class="contain">
            <div id="detail_job"></div>
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

<div class="modal fade" id="error_customer" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4>Please complete field Customer!</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn red" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <!-- /.modal-dialog -->
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

<script src="<?php echo base_url(); ?>assets/admin/scripts/jquery.autocomplete.js" type="text/javascript"></script>

<script>
  $(document).ready(function() {
    get_item_cust("<?= $Customer_code ?>");
  });

  $(document).on('focus', '.no_coa', function() {
    $(this).autocomplete({
      serviceUrl: "<?php echo site_url('Tims_invoice/get_item'); ?>"
    });
  });

  $('#customer').on('change', function() {
    var selectedCustomer = $(this).val();
    get_job_cust(selectedCustomer);
    get_item_cust(selectedCustomer);
    $.ajax({
      url: "<?php echo base_url(); ?>Tims_invoice/get_selectedCustomer?id=" + selectedCustomer,
      success: function(response) {

        $('#address').val(response.address);
        $('.country').val(response.country);
      },
      dataType: "json"
    });
    return false;

  });

  function ganti_credit() {

    var jenis = document.getElementById("jenis");
    var tgl1 = document.getElementById("tgl_tempo").value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];
    if (document.getElementById('credit').checked === true) {
      jenis.value = 'CCN';
    }else if (document.getElementById('debit').checked === true) {
      jenis.value = 'CDN';
    } else {
      jenis.value = 'INV';
    }

  }

  function get_job_cust(selectedCustomer) {
    $.ajax({
      url: "<?php echo base_url(); ?>Tims_invoice/tampil_job?cust=" + selectedCustomer + "",
      success: function(response) {
        $("#detail_job").html(response);
        $("#loading-spiner").hide();
      },
      dataType: "html"
    });


  }

  function get_item_cust(selectedCustomer) {
    console.log("masuk");
    $.ajax({
      url: "<?php echo base_url(); ?>Tims_invoice/tampil_item_cust?cust=" + selectedCustomer + "",
      success: function(response) {
        $("#detail_item_cust").html(response);
      },
      dataType: "html"
    });


  }
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
      // var today = picker.startDate.format('DD/MM/YYYY');
    });
  })
</script>

<script type="text/javascript">
  function cari_job() {
    var customer = document.getElementById('customer').value;
    if (customer === '') {
      $('#error_customer').modal('show');
    } else if (customer !== '') {
      $('#po_v').modal('show');
    }
  }
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

  function hapus_baris(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    hitung_amount();

  }

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

    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    var gst = document.getElementsByClassName('txtGSTValue');
    var amount = document.getElementsByClassName('amount');
    var amount_tax = document.getElementById('amount_tax');
    var total = document.getElementById('total');
    var freight = document.getElementById('freight');


    var sum = 0;
    var sumx = 0;
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

    total.value = sum.toFixed(2);
    amount_tax.value = sumx.toFixed(2);

    var freightValue = parseFloat(freight.value) || 0;
    var grandtotal = sum + sumx + freightValue;
    document.getElementById('amount_due').value = grandtotal.toFixed(2);

  }

  function cek_gst() {
    var qty = document.getElementsByClassName('quantity');
    var harga = document.getElementsByClassName('prices');
    // var txtsummary = document.getElementsByClassName('txtsummary');
    for (var i = 0; i < qty.length; i++) {
      qty[i].value = qty[i].value.replace(",", "");
      harga[i].value = harga[i].value.replace(",", "");
    }

    var gst_type = document.getElementsByClassName('txtGST');
    var sgd_txt = document.getElementsByClassName('amount');
    var jur_total2 = document.getElementById('amount_tax');
    var gst_value = document.getElementsByClassName('txtGSTValue');
    for (var i = 0; i < gst_type.length; i++) {
      if (sgd_txt[i].value === 0) {
        alert("Please insert item, quantity, and price first");
      } else {

        if (gst_type[i].value === 'GST') {

          var Amount = qty[i].value * harga[i].value;
          //  txtsummary[i].value = Amount;
          gst_value[i].value = (Amount * 9 / 100).toFixed(2);
        } else {
          gst_value[i].value = '0';
          // txtsummary[i].value = '0';
        }
      }
    }

    hitung_total();
  }

  function select_item() {
    console.log("tes")

    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk[]");
    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {

        var gst = getText(document.getElementById('tblitem').rows[i].cells[4]);
        console.log(gst);

        var html = `<tr>
                      <td style="text-align: center;"><a class="btn red" onclick="hapus_baris(this)"><i class="fa fa-trash"></i> </a></td>
                      <td hidden>
                      <input type="text" name="Detail_item_id[]" value="">
                      </td>
                       <td nowrap onclick="event.stopPropagation();return false;">
                        <input type="text" class="form-control input-sm" style="width: 100px;" name="Backorder[]" value="${getText(document.getElementById('tblitem').rows[i].cells[1]) }" readonly></td>
                      <td>
                        <input type="text" name="job[]" value="" class="job txt">
                      </td>
                      <td nowrap onclick="event.stopPropagation();return false;">
                        <input type="text" class="form-control input-sm" style="width: 500px;" name="Item_number[]" value="${getText(document.getElementById('tblitem').rows[i].cells[2])}" >
                      </td>
                      <td>
                      <input type="text" class="txt number quantity autonumber auto" name="Ship[]" placeholder="0" onkeypress="return isNumber(event);" onKeyup="hitung_amount();cek_gst();" required/>
                      </td>
                      <td>
                        <input type="text" name="Price[]" class="txt number prices autonumber"  onKeyup="hitung_amount()" value="${getText(document.getElementById('tblitem').rows[i].cells[3]) }" placeholder="0" required/>
                      </td>
                      <td>
                        <input type="text" name="Amount[]" class="txt number amount autonumber" onKeyup="hitung_total()" data-a-sep="," data-a-dec="."  value="0"  onkeypress="return isNumber(event)"  value="0" />
                      </td>
                      <td>
                        <input type="text" name="Discount[]" value="0" class="txt number job_discount" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td>
                        <input type="text" name="after_disc[]" value="0" class="txt number after_disc" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td>
                      <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                      <option value="">Select</option>
                      <option value="GST" ${ gst == 'GST' ? 'selected' : '' } >GST</option>
                      <option value="ZER" ${ gst == 'ZER' ? 'selected' : '' }  >Zero Rate</option>
                      <option value="EXP" ${ gst == 'EXP' ? 'selected' : '' }  >Exampt</option>
                      <option value="OUT" ${ gst == 'OUT' ? 'selected' : '' }  >Out of Scope</option>
                      </select>
                      </td>
                      <td>
                        <input type="text" name="txtGSTValue[]" value="0" class="txt number autonumber txtGSTValue" onkeyup="hitung_total()" onkeypress="return isNumber(event)">
                      </td>
                      <td hidden>
                      <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0">
                      </td>
                      </tr>')`;

        $('table[id="tabel"]').append(html);

      }
      i++;
    }
    $('.modal-item').modal('hide');
  }
</script>