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

<?php
foreach ($header as $xx) {
  $date    = $xx->schedule_date;
  $from    = $xx->factory_name;
  $from_id = $xx->factory_id;
  $to      = $xx->customer_name;
  $to_id   = $xx->customer_id;
  $cust_name = $xx->customer_name;
  $cust_con = $xx->consignee;
}

foreach ($product as $cc) {
  $product_dtl = $cc->detail_product_name;
  $po_number   = $cc->po_number;
  $product_code = $cc->product_code;
  $ship_product_id = $cc->ship_product_id;
  $packing = $cc->quantity . ' ' . $cc->uom_quantity_name . ' (' . $cc->packing_view . ')';
  $brand_product = $cc->brand_name;
  $category_product = $cc->product_category_name;
  $shipid = $cc->ship_id;
  $po_hdr_id = $cc->po_hdr_id;
}

foreach ($factory as $key) {
  $fac_name = $key->factory_name;
  $fac_id   = $key->id;
  $fac_add  = $key->factory_address;
}

foreach ($cont as $dtl) {
  $cont_no = $dtl->container;
  $shipdate = $dtl->shipmentdate;
}

?>



<div class="page-content">
  <form action="<?php echo site_url('eform/coa_gen_save'); ?>" method="post" role="form" name="my_form">
    <!-- Cek ID -->
    <input type="text" name="id_coa_gen" id="id_coa_gen" value="">
    <input type="text" name="shipid" id="shipid" value="<?php echo $shipid; ?>">
    <input type="text" name="po_hdr_id" id="po_hdr_id" value="<?php echo $po_hdr_id; ?>">
    <input type="text" name="ship_product_id" id="ship_product_id" value="<?php echo $ship_product_id; ?>">
    <input type="text" name="customer_id" id="customer_id" value="<?php echo $to_id; ?>">
    <input type="text" name="tipe_coa" id="tipe_coa" value="GENERAL">
    <!-- Cek ID -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">
                  <h3>CERTIFICATE OF ANALYSIS </h3>
                  <h6>Item <b style="color: red;"><?php echo $product_dtl; ?></b>, Customer <b style="color: red;"><?php echo $cust_name; ?></b>, PO Number <b style="color: red;"><?php echo $po_number; ?></b></h6>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Prologue and Letter Head</span>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="form-group">
                  <label class="col-md-2 control-label" for="int">Document Date</label>
                  <div class="col-md-4">
                    <input type="text" name="doc_date" class="form-control date date-picker" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" id="doc_date" readonly />
                  </div>
                  <label class="col-md-2 control-label" for="int">To</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="too" id="too" placeholder="" value="<?php echo $to; ?>" readonly />
                    <input type="hidden" class="form-control" name="to_id" id="to_id" placeholder="" value="<?php echo $to_id; ?>" readonly />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-2 control-label" for="int">From</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="from" id="from" placeholder="" value="<?php echo $from; ?>" readonly />
                    <input type="hidden" class="form-control" name="from_id" id="from_id" placeholder="" value="<?php echo $from_id; ?>" readonly />
                  </div>
                  <span class="help-inline"></span>
                </div>

                <div class="form-group">
                  <span class="help-inline"></span>
                  <label class="col-md-2 control-label" for="int">Certificate Number</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="cert_no" id="cert_no" placeholder="Input Certificate Number" value="" required />
                  </div>
                  <span class="help-inline"></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Good Consigned From</span>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="producer">
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Exporter's</label>
                    <div class="col-md-10">
                      <textarea rows="3" class="form-control autosize" name="exporter" id="exporter"><?php echo $fac_add; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Good Consigned To</span>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-2">Importer's</label>
                    <div class="col-md-10">
                      <textarea rows="3" class="form-control autosize" name="importer" id="importer"><?php echo $cust_con; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Product Information</span>
              </div>
            </div>
            <!--  -->
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Production Code</label>
                    <div class="col-md-7">
                      <input type="text" name="code_product" id="product_code" value="<?php echo $product_code; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Brand Name</label>
                    <div class="col-md-7">
                      <input type="text" name="brand_product" id="brand_product" value="<?php echo $brand_product; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Category Number</label>
                    <div class="col-md-7">
                      <input type="text" name="category_product" id="category_product" value="<?php echo $category_product; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Name Product</label>
                    <div class="col-md-7">
                      <input type="text" name="name_product" id="name_product" value="<?php echo $product_dtl; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">LOT Number</label>
                    <div class="col-md-7">
                      <input type="text" name="lot_no" id="lot_no" value="" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Packing</label>
                    <div class="col-md-7">
                      <input type="text" name="packing" id="packing" value="<?php echo $packing; ?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Remark</label>
                    <div class="col-md-7">
                      <input type="text" name="remarks" id="remarks" value="" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Shippping Information</span>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Po Number</label>
                    <div class="col-md-7">
                      <input type="text" name="po_number" id="po_number" value="<?php echo $po_number; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Shipping Instruction No</label>
                    <div class="col-md-7">
                      <input type="text" name="si_no" id="si_no" value="" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label col-md-4">Container No</label>
                    <div class="col-md-7">
                      <input type="text" name="container" id="container" value="<?php echo $cont_no; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="int">Shipmentdate</label>
                    <div class="col-md-7">
                      <input type="text" name="shipmentdate" class="form-control date date-picker" value="<?php echo $shipdate; ?>" data-date-format="dd-mm-yyyy" id="shipmentdate" readonly />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">I. PHYSICAL ANALYSIS</span>
              </div>
            </div>
            <div class="portlet-body" id="package_detail">
              <div class="table-scrollable">
                <table class="table table-bordered" id="tblList">
                  <thead>
                    <tr>
                      <th width="10px"><a class="btn green" data-toggle="modal" onclick="tambah_baris_physical_analysis()"><i class="fa fa-plus"></i><!--  Search Container --></a>
                      </th>
                      <th nowrap width="50px">No.</th>
                      <th nowrap>Production Date</th>
                      <th nowrap>Expiry Date</th>
                      <th nowrap>Colour and Appearance</th>
                      <th nowrap>Flavour/odour*</th>
                    </tr>
                  </thead>
                  <tbody id="tblList_1">
                    <input type="hidden" class="form-control" name="id_dtl" id="id_dtl" value="" />
              </div>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption">
                  <span class="caption-subject theme-font">II. CHEMICAL ANALYSIS</span>
                </div>
              </div>
              <div class="portlet-body" id="package_detail">
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList_11">
                    <thead>
                      <tr>
                        <th width="10px"><a class="btn green" data-toggle="modal" onclick="tambah_baris_chemical_analysis()"><i class="fa fa-plus"></i><!--  Search Container --></a>
                        </th>
                        <th nowrap width="50px">No.</th>
                        <th nowrap>Production Date</th>
                        <th nowrap>Expiry Date</th>
                        <th nowrap>Fat Content (%)</th>
                        <th nowrap>pH</th>
                        <th nowrap>Dry Matter (%)</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_111">
                      <input type="hidden" class="form-control" name="id_dtl1" id="id_dtl1" value="" />
                </div>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="portlet light">
                <div class="portlet-title">
                  <div class="caption">
                    <span class="caption-subject theme-font">III. MICROBIOLOGICAL ANALYSIS</span>
                  </div>
                </div>
                <div class="portlet-body" id="package_detail">
                  <div class="table-scrollable">
                    <table class="table table-bordered" id="tblList_1111">
                      <thead>
                        <tr>
                          <th width="10px"><a class="btn green" data-toggle="modal" onclick="tambah_baris_microbiological_analysis()"><i class="fa fa-plus"></i><!--  Search Container --></a>
                          </th>
                          <th nowrap width="50px">No.</th>
                          <th nowrap width="250px">Expiry Date</th>
                          <th nowrap width="250px">Expiry Date</th>
                          <th nowrap>Commercial Sterility</th>
                        </tr>
                      </thead>
                      <tbody id="tblList_11111">
                        <input type="hidden" class="form-control" name="id_dtl2" id="id_dtl2" value="" />
                  </div>
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption">
                  <span class="caption-subject theme-font">Declaration and Issued</span>
                </div>

              </div>
              <div class="portlet-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="control-label col-md-4">By</label>
                      <div class="col-md-8">
                        <input type="text" name="by" id="by" value="" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4">Name</label>
                      <div class="col-md-8">
                        <input type="text" name="name_sign" id="name_sign" value="" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4">Title</label>
                      <div class="col-md-8">
                        <input type="text" name="title_hdr" id="title_hdr" value="" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-4">Date</label>
                      <div class="col-md-8">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy" name="date_sign">
                        </div>
                      </div>
                    </div>
                  </div>
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
                        <div class="form-group">
                          <label class="control-label col-md-2">Remark's</label>
                          <div class="col-md-10">
                            <textarea rows="3" class="form-control autosize" name="remark_dtl" id="remark_dtl"></textarea>
                          </div>
                        </div>
                        <div class="portlet-body">
                          <div class="col-md-offset-8 col-md-4">
                            <button type="submit" class="btn btn-primary">Save</button>
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
  // ========================== Physical_ANalysis < Open >

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
                <input class="form-control text-center txt input-sm" type="text-center" name="no[]" id="no[]" value="' + no + '"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input production date" name="pro_date[]" id="pro_date" class="form-control txt nova"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input expiry date" name="exp_date[]" id="exp_date[]" class="form-control txt"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Color" name="cap[]" id="cap[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Flavour and Odour" name="fo[]" id="fo[]" class="form-control txt" ></td>\n\
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
                <input class="form-control text-center txt input-sm" type="text-center" name="no1[]" id="no1[]" value="' + no + '"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input production date" name="pro_date1[]" id="pro_date1[]" class="form-control txt yanti"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Expiry date" name="exp_date1[]" id="exp_date1[]" class="form-control txt"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Fat Content" name="fc[]" id="fc[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input pH Value" name="ph[]" id="ph[]" class="form-control txt" ></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Dry Matter" name="dm[]" id="dm[]" class="form-control txt" ></td>\n\
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
                <input class="form-control text-center txt input-sm" type="text-center" name="no2[]" id="no2[]" value="' + no + '"></td>\n\
                <td class="text-center" width="250px"><input type="text" placeholder="Input Production date" name="pro_date2[]" id="pro_date2[]" class="form-control txt situmorang"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Expiry Date" name="exp_date2[]" id="exp_date2[]" class="form-control txt"></td>\n\
                <td class="text-center"><input type="text" placeholder="Input Commercial Sterility" name="cs[]" id="cs[]" class="form-control txt"></td>\n\
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