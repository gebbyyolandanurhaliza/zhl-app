<script type="text/javascript">
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      $.each($("#tbl_cust tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });
  });

  function check() {
    var input = document.getElementById('descpack[]').value;
    if (input.lastIndexOf('\n') != -1) {
      console.log("hahahaha");
    } else {
      console.log("hihihi");
    }
  }
</script>


<div class="modal fade" id="master-customer" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Customer</h4>
        <input class="form-control" type="text" id="search" placeholder="Search">
      </div>
      <div class="modal-body">
        <section class="">
          <div class="contain">
            <table cellspacing="2" cellpadding="2" border="2" id="tbl_cust" width="100%">
              <thead>
                <tr class="header">
                  <th align="center">Customer Name</th>
                  <th align="center">Customer Country</th>
                </tr>
              </thead>

              <tbody>
                <?php
                foreach ($hasilfilter as $s) {

                  $cus_name    = strtoupper($s->customer_name);
                  $cus_add     = strtoupper($s->customer_address);
                  $cus_cou     = strtoupper($s->customer_country);
                  $cus_group   = strtoupper($s->customer_group_name);

                ?>
                  <tr onclick="pilihCus(this)" style="cursor: pointer;" value="<?php echo $s->customer_id; ?>">
                    <td align="center" hidden><input type="radio" value="<?php echo $s->customer_id; ?>"></td>
                    <td align="center"><?php echo $cus_name; ?></td>
                    <td align="center"><?php echo $cus_cou; ?></td>
                    <td hidden><?php echo $cus_group; ?></td>
                    <td hidden><?php echo $cus_add; ?></td>
                    <td hidden><?php echo $s->customer_id; ?></td>
                    <td hidden><?php echo $s->country_id; ?></td>
                  </tr>

                <?php
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
<!-- ========================== -->

<div id="formdialogPO" hidden>
  <div class="portlet-body">
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 label-sm">Factory</label>
        <div class="col-md-4">
          <select class="form-control select2me" data-placeholder="Factory" id="factory">
            <option value=""></option>
            <option value="1">PSG</option>
            <option value="3">RSUP</option>
          </select>
        </div>
        <button type="button" class="col-md-2 btn blue" onclick="hasilfilterPO()">Search</button>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 label-sm">Schedule Date</label>
        <div class="col-md-4">
          <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="date">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 label-sm">PO / Carrier</label>
        <div class="col-md-7">
          <input class="form-control input-sm" id="po">
        </div>
      </div>
    </div>
    <br>
    <hr>
    <div class="table-scrollable" style="overflow: auto; height:300px;">
      <table id="tbl-po" class="table table-bordered">
        <thead>
          <tr>
            <th width="5px"><input type="checkbox" onchange="check(this)"></th>
            <th>Shipmentate</th>
            <th>PO Number</th>
            <th>Factory</th>
            <th>Quality</th>
            <th>Gross Weight</th>
            <th>Shipping Liner</th>
            <th>Final Destination</th>
            <th>Client Reff Number</th>
          </tr>
        </thead>
        <tbody id="tblpo" align="center"></tbody>
      </table>
    </div>
    <div class="col-md-6">
      <button type="button" class="col-md-3 btn blue" onclick="choose_PO()" id="choose">Choose</button>
      <button type="button" class="col-md-3 btn grey" onclick="close_PO()">Close</button>
    </div>
  </div>
</div>
<div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

<div class="page-content">
  <form action="<?php echo site_url('shipping/coo_new_save'); ?>" method="post" role="form" name="my_form">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <?php foreach ($product as $x) {
                  $po_no = $x->po_number;
                } ?>
                <span class="caption-subject theme-font">
                  <h3>CERTIFICATE OF ANALYSIS <b style="color: red;">(<?php echo $po_no; ?>)</b></h3>
                  <h6>*General Format</h6>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">PO Information</span>
              </div>
            </div>
            <?php foreach ($header as $z) { ?>
              <div class="portlet-body">
                <div class="row">
                  <div class="form-group">
                    <label class="col-md-2 control-label" for="int">Shipmentdate</label>
                    <div class="col-md-4">
                      <input type="text" name="doc_date" class="form-control date date-picker" value="<?php echo $z->schedule_date; ?>" data-date-format="dd-mm-yyyy" id="doc_date" readonly />
                    </div>
                    <label class="col-md-2 control-label" for="int">Factory</label>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="from" id="from" placeholder="" value="<?php echo $z->factory_name; ?>" readonly />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-2 control-label" for="int">Customer</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="from" id="from" placeholder="" value="<?php echo $z->customer_name; ?>" readonly />
                    </div>
                    <span class="help-inline"></span>
                  </div>


                  <div class="form-group">
                    <span class="help-inline"></span>
                    <label class="col-md-2 control-label" for="int">Po Number</label>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="attn" id="attn" placeholder="" value="<?php echo $z->po_number; ?>" readonly />
                    </div>
                    <span class="help-inline"></span>
                  </div>

                  <div class="form-group">
                    <span class="help-inline"></span>
                    <label class="col-md-2 control-label" for="int">Container Number</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control" name="attn" id="attn" placeholder="" value="" readonly="" />
                    </div>
                    <span class="help-inline"></span>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>


        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="portlet light">
                <div class="portlet-title">
                  <div class="caption">
                    <span class="caption-subject theme-font">List Product From PO</span>
                  </div>
                </div>
                <div class="portlet-body" id="package_detail">
                  <div class="table-scrollable">
                    <table class="table table-bordered" id="tblList">
                      <thead>
                        <tr>
                          <th nowrap width="50px">Action</th>
                          <th nowrap>Product Name</th>
                          <th nowrap>Brand Name</th>
                          <th nowrap>Category Product</th>
                          <th nowrap>Quantity</th>
                          <th nowrap>Packing</th>
                          <th nowrap>Status CoA</th>
                        </tr>
                      </thead>
                      <?php foreach ($product as $y) { ?>
                        <tbody id="tblList_1">
                          <td align="center"><a class="btn-primary grey" href="<?php echo base_url('eform/request_product_coa?ship=' . $y->ship_id . '&po=' . $y->po_hdr_id . '&fac=' . $y->factory_id . '&proid=' . $y->ship_product_id); ?>" target="_blank">Create CoA</a></td>
                          <td align="center"><?php echo $y->detail_product_name; ?></td>
                          <td align="center"><?php echo $y->brand_name; ?></td>
                          <td align="center"><?php echo $y->product_category_name; ?></td>
                          <td align="center"><?php echo $y->quantity . ' ' . $y->uom_quantity_name; ?></td>
                          <td align="center"><?php echo $y->packing_view; ?></td>
                          <td align="center"><i class="fa fa-close" style="color: red;"></i></td>
                        </tbody>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="portlet light">
                <div class="portlet-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-actions">
                        <div class="row">
                          <div class="portlet-body">
                            <div class="col-md-offset-8 col-md-4">
                              <button type="reset" class="btn btn-primary red">Cancel</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

  </form>
</div>

<!-- Para MODAL -->
<div class="modal fade" id="master-factory" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List Factory (Sambu Group)</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabel-fac">
          <thead>
            <th>No</th>
            <th>Factory (Exporter)</th>
            <th>Factory Country</th>
          </thead>
          <tbody id="ISIFac">
            <!-- Ada Isi lho -->
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

<div class="modal fade" id="master-customer1" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog modal-full">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List Customer</h4>
      </div>
      <div class="col-md-5">
        <button type="button" class="col-md-2 btn blue" onclick="hasilfilterPO()">Search</button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="tabel-cus">
          <thead>
            <th>No</th>
            <th>Customer</th>
            <th>Consignee</th>
            <th>Customer Country</th>
          </thead>
          <tbody id="ISICus">
            <!-- Ada Isi lho -->
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


<!-- Para MODAL -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel1").dataTable({
      "scrollY": 400,
      "scrollX": true,
      "order": [
        [0, ''],
        [1, 'desc']
      ]
    });

  });
</script>

<script>
  function detail_package() {
    $tipe = document.getElementById('form').value;

    $urlxxx = "<?php echo base_url(); ?>shipping/get_form_package?tipe=" + $tipe;
    $urlxxx2 = "<?php echo base_url(); ?>shipping/get_form_remark?tipe=" + $tipe;
    $urlxxx3 = "<?php echo base_url(); ?>shipping/get_form_producer?tipe=" + $tipe;
    console.log($urlxxx3);

    $.ajax({
      url: $urlxxx,
      success: function(response) {
        $("#package_detail").html(response);
      },
      dataType: "html"
    });

    $.ajax({
      url: $urlxxx2,
      success: function(response) {
        $("#remark-s").html(response);
      },
      dataType: "html"
    });

    $.ajax({
      url: $urlxxx3,
      success: function(response) {
        $("#producer").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  // ========================== Form_A < Open >

  function tambah_baris_physical_analysis() {
    var jum = document.getElementsByClassName('nova');
    var l = jum.length + 1;
    var no = l;
    // alert(l);
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tblList"]').append('<tr>\n\
                <td class="text-center"><input type="button" class="btn btn-sm btn-danger" onclick="hapus_baris_phisical(this)" value="hapus"></td>\n\
                <td class="text-center" width="50px"><input type="hidden" name="txtdtlid[]" id="txtdtlid" value="0"/>\n\
                <input class="form-control text-center txt input-sm" type="text-center" name="id_1[]" id="id_1" value="' + no + '"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input production date" name="pro_1[]" id="pro_1" class="form-control txt nova"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input expiry date" name="exp_1[]" id="exp_1[]" class="form-control txt"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Color" name="color[]" id="color[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Flavour and Odour" name="flavour[]" id="flavour" class="form-control txt" ></td>\n\
            </tr>');
    }
  }


  function hapus_baris_phisical(ip) {
    var tr = ip.parentNode.parentNode;
    tr.parentNode.removeChild(tr);
  }

  // =========================== Physical Analysis Close >


  // ========================== Chemical Analisys Open>

  function tambah_baris_chemical_analysis() {
    var jum = document.getElementsByClassName('yanti');
    var l = jum.length + 1;
    var no = l;
    // alert(l);
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tblList_11"]').append('<tr>\n\
                <td class="text-center"><input type="button" class="btn btn-sm btn-danger" onclick="hapus_baris_chemical(this)" value="hapus"></td>\n\
                <td class="text-center" width="50px"><input type="hidden" name="txtdtlid[]" id="txtdtlid" value="0"/>\n\
                <input class="form-control text-center txt input-sm" type="text-center" name="id_2[]" id="id_2[]" value="' + no + '"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input production date" name="pro_2[]" id="pro_2[]" class="form-control txt yanti"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Expiry date" name="exp_2[]" id="exp_2[]" class="form-control txt"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Fat Content" name="fat[]" id="fat[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input pH Value" name="pH[]" id="pH[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Dry Matter" name="dry[]" id="dry[]" class="form-control txt" ></td>\n\
            </tr>');
    }
  }


  function hapus_baris_chemical(ip) {
    var tr = ip.parentNode.parentNode;
    tr.parentNode.removeChild(tr);
  }

  // =========================== Chemical Analysis < Close >

  // ========================== Chemical Analisys Open>

  function tambah_baris_microbiological_analysis() {
    var jum = document.getElementsByClassName('situmorang');
    var l = jum.length + 1;
    var no = l;
    // alert(l);
    var num = 1;
    for (var i = 0; i < num; i++) {
      $('table[id="tblList_1111"]').append('<tr>\n\
                <td class="text-center"><input type="button" class="btn btn-sm btn-danger" onclick="hapus_baris_microbiological(this)" value="hapus"></td>\n\
                <td class="text-center" width="50px"><input type="hidden" name="txtdtlid[]" id="txtdtlid" value="0"/>\n\
                <input class="form-control text-center txt input-sm" type="text-center" name="pro_3[]" id="pro_3[]" value="' + no + '"></td>\n\
                <td class="text-center" width="250px"><input type="text" placeholder="Input Production date" name="exp_3[]" id="exp_3[]" class="form-control txt situmorang"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Commercial Sterility" name="commercial[]" id="commercial[]" class="form-control txt"></td>\n\
            </tr>');
    }
  }


  function hapus_baris_microbiological(ip) {
    var tr = ip.parentNode.parentNode;
    tr.parentNode.removeChild(tr);
  }

  // =========================== Chemical Analysis < Close >

  function filter_sambu() {
    $("#master-factory").modal('show');
    hasilfilterFac();
  }



  function hasilfilterFac() {
    $urlxxx = "<?php echo base_url(); ?>shipping/filter_fac_sambu";
    console.log($urlxxx);

    $.ajax({
      url: $urlxxx,
      success: function(response) {
        $("#ISIFac").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function pilihFac(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    var addfac = getText(document.getElementById('tabel-fac').rows[$r].cells[3]);
    var addfac1 = getText(document.getElementById('tabel-fac').rows[$r].cells[3]);
    var fac_id = getText(document.getElementById('tabel-fac').rows[$r].cells[5]);
    var faccou = getText(document.getElementById('tabel-fac').rows[$r].cells[4]);
    var faccou_id = getText(document.getElementById('tabel-fac').rows[$r].cells[2]);


    document.getElementById('addfac').value = addfac;
    document.getElementById('faccou').value = faccou;
    // document.getElementById('addfac_producen').value = addfac1;
    document.getElementById('fac_id').value = fac_id;
    document.getElementById('faccou_id').value = faccou_id;

    $('#master-factory').modal('hide');

  }


  function filter_customer() {
    $("#master-customer").modal('show');
    hasilfilterCus();
  }


  function hasilfilterCus() {
    $urlxxx = "<?php echo base_url(); ?>shipping/filter_cus_coo";
    console.log($urlxxx);

    $.ajax({
      url: $urlxxx,
      success: function(response) {
        $("#ISICus").html(response);
      },
      dataType: "html"
    });

    return false;
  }


  function pilihCus(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    var addcus = getText(document.getElementById('tabel-cus').rows[$r].cells[4]);
    var cust_id = getText(document.getElementById('tabel-cus').rows[$r].cells[5]);
    var cuscou = getText(document.getElementById('tabel-cus').rows[$r].cells[2]);
    var cuscou_id = getText(document.getElementById('tabel-cus').rows[$r].cells[6]);

    document.getElementById('addcus').value = addcus;
    document.getElementById('cust_id').value = cust_id;
    document.getElementById('cuscou').value = cuscou;
    document.getElementById('cuscou_id').value = cuscou_id;

    $('#master-customer').modal('hide');

  }


  function filter_po_si() {
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List Shipping Instruction",
      height: 550,
      width: 1300

    });
  }

  function hasilfilterPO() {
    $fac = document.getElementById('factory').value;
    $date = document.getElementById('date').value;
    $po = document.getElementById('po').value;

    $(document).ajaxStart(function() {
      $('#tblpo').html('<img src="<?php echo base_url(); ?>assets/pages/img/loading.gif">');
    });

    $urlxxx = "<?php echo base_url(); ?>shipping/filter_po_si?fac=" + $fac + "&date=" + $date + "&po=" + $po;
    console.log($urlxxx);

    $.ajax({
      url: $urlxxx,
      success: function(response) {
        $("#tblpo").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function cek_shipid(ele) {
    var checkboxes = document.getElementsByTagName('input');
    var ship_id = ele.value;
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (ship_id == checkboxes[i].value) {
            checkboxes[i].checked = true;
          }
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          if (ship_id == checkboxes[i].value) {
            checkboxes[i].checked = false;
          }
        }
      }
    }
  }

  function choose_PO() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        var $new_row = $('<tr onclick="deleterow(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="po_number[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="qty_lengkap[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" hidden><input type="text" class="form-control input-sm" name="qty[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" hidden><input type="text" class="form-control input-sm" name="uom[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="gross_weight_lengkap[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[7]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" hidden><input type="text" class="form-control input-sm" name="gross_weight[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[8]) + '" readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="after_save[]" value="Can be see, after Save..." readonly></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="origin_criteria[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-center" name="invoice_dtl[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="remark_dtl[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[15]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="port_id[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[12]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="destination_id[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[13]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="customer_id[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[11]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="po_hdr_id[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[16]) + '"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList"]').append($new_row);
      }
      i++;
    }

    $("#formdialogPO").dialog("close");
    cekDtl();
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("container_id[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
    }
  }

  function tofac() {
    $fac = document.getElementById('to').value;

    if ($fac == 'PSG') {
      document.getElementById('attn').value = 'ABIT';
    } else {
      document.getElementById('attn').value = 'AGUS / DAYA / EWIS';
    }

  }
</script>