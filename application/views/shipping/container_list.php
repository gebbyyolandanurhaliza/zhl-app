<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-navicon theme-font"></i>
              <span class="caption-subject theme-font bold">Container Outward</span>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row mb-2">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Tipe</label>
                      <div class="col-md-3">
                        <select class="form-control select2me" name="tipe">
                          <option value="1">Container Outward</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Shipment Date</label>
                      <div class="col-md-3">
                        <input class="form-control input-sm date date-picker" name="shipdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" required>
                        <input class="form-control input-sm" name="contid" value="" type="hidden">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vessel ( Barge)</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="barge" id="vessel_barge">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Voyage</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" name="voyage" id="voyage_no">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETD</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <input class="form-control input-sm" placeholder="ETD" name="etd" value="SINGAPORE" readonly="">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETD Date" name="etddate" id="etddate" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">ETA</label>
                      <div class="col-md-7">
                        <div class="input-group">
                          <select class="form-control input-sm" name="eta">
                            <option>Select Factory</option>
                            <option value="RSUP" id="RSUP">Riau Sakti United Plantation</option>
                            <option value="PSG" id="PSG">Pulau Sambu Guntung</option>
                            <option value="PSKE" id="PSKE">Pulau Sambu Kuala Enok</option>
                          </select>
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input class="form-control input-sm date date-picker" placeholder="ETA Date" id="etadate" name="etadate" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">To</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" id="to_out" name="to">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-2 label-sm">From</label>
                      <div class="col-md-7">
                        <input class="form-control input-sm" id="from_out" name="from">
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;display: none;">
                      <label class="col-md-2 label-sm">Amendment</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm date date-picker" name="amendmentdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?= date('Y-m-d') ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="portlet-title mt-5">
                  <div class="caption">
                    <i class="fa fa-file theme-font"></i>
                  <span class="caption-subject theme-font bold">PO List PSS</span>
                  </div>
                </div>
                <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO()"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap>Seq No</th>
                        <th nowrap>PO Number</th>
                        <th nowrap>Shipper/Carrier</th>
                        <th nowrap>FCL</th>
                        <th nowrap>Destination</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Vessel/Voyage</th>
                        <th nowrap>Connecting Vessel</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap>Depot</th>
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETA Sin</th>
                        <th nowrap>ETA</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1">
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="portlet-title mt-5">
                <div class="caption">
                  <i class="fa fa-navicon theme-font"></i>
                  <span class="caption-subject theme-font bold">Local Container</span>
                </div>
              </div>
              <div class="table-scrollable">
                <table class="table table-bordered" id="tblList_lc">
                  <thead>
                    <tr>
                      <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO_lc()"><i class="fa fa-arrow-down"></i></button></th>
                      <th nowrap width="20">Seq No</th>
                      <th nowrap>Stuffing</th>
                      <th nowrap>Container Type</th>
                      <th nowrap>Container Number</th>
                      <th nowrap>Supplier</th>
                      <th nowrap>Customer</th>
                      <th nowrap>Booking Ref</th>
                    </tr>
                  </thead>
                  <tbody id="tblList_1_lc">
                  </tbody>
                </table>
              </div>

            <!-- ============================== Start of PO List GGFS ============================== -->
              <div class="portlet-title mt-5">
                <div class="caption">
                  <i class="fa fa-file theme-font"></i>
                  <span class="caption-subject theme-font bold">PO List GGFS</span>
                </div>
              </div>
              <div class="table-scrollable">
                  <table class="table table-bordered" id="tblList_ggfs">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogPO_ggfs()"><i class="fa fa-arrow-down"></i></button></th>
                        <th nowrap>Seq No</th>
                        <th nowrap>PO Number</th>
                        <th nowrap>Shipper/Carrier</th>
                        <th nowrap>FCL</th>
                        <th nowrap>Destination</th>
                        <th nowrap>Booking Ref</th>
                        <th nowrap>Supplier</th>
                        <th nowrap>Vessel/Voyage</th>
                        <th nowrap>Connecting Vessel</th>
                        <th nowrap>Stuffing</th>
                        <th nowrap>Depot</th>
                        <th nowrap>POD</th>
                        <th nowrap>OP Code</th>
                        <th nowrap>ETA Sin</th>
                        <th nowrap>ETA</th>
                      </tr>
                    </thead>
                    <tbody id="tblList_1_ggfs">
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- ============================== End of PO List GGFS ============================== -->

          <div class="row mt-5">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-md-1 label-sm">Remark</label>
                <div class="col-md-4">
                  <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                </div>
              </div>
            </div>

            <div class="col-md-6 mt-2">
              <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
              <button type="reset" class="col-md-2 btn btn-default" onclick="$('#tblList_1 tr').remove();">Cancel</button>
              
              <button type="button" class="col-md-2 btn btn-success" onclick="fn_import()">Import Excel</button>

              
            </div>

            <div class="col-md-6 mt-2">
              <button type="button" class="col-md-3 col-md-push-7 btn btn-default" onclick="fnDialogContainerOutward()">Copy Outward</button>
              <button type="button" class="col-md-2 col-md-push-7 btn btn-warning" onclick="fnDialogContainerAll()">Find</button>
            </div>

            </div>
          </div>
          </form>
        </div>
      </div>
      <div id="formdialogContainerOutward"></div>
      <div id="formdialogContainerAll" hidden>
        <div class='portlet-body'>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Shipment Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="dt_shipment">
              </div>
            </div>
          </div>
          <div class='col-md-12 mb-2'>
            <div class='form-group'>
              <label class='col-md-2 label-sm'>Find Order By</label>
              <div class='col-md-7'>
                <input class='form-control input-sm' id='dt_data'>
              </div>
              <button type='button' class='col-md-1 btn blue' onclick='filtercontainerall()'>Search</button>
            </div>
          </div>
          <br>
          <hr>
          <div class='table-scrollable' style='overflow: auto; height:490px;'>
            <table id='tbl-containerall' class='table table-bordered table-striped'>
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Tipe</th>
                  <th>Shipment Date</th>
                  <th>Vessel (Barge)</th>
                  <th>Voyage</th>
                  <th>ETD</th>
                  <th>ETD Date</th>
                  <th>ETA</th>
                  <th>ETA Date</th>
                  <th>From</th>
                  <th>To</th>
                  <th>Created By</th>
                  <th>Created Date</th>
                  <th>LastUpdated By</th>
                  <th>LastUpdated Date</th>
                </tr>
              </thead>
              <tbody id='tblcontainerall'></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
        </div>
      </div>
      <div id="formdialogPO" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Factory</label>
              <div class="col-md-4">
                <select class="form-control select2me" data-placeholder="Factory" id="factory">
                  <option value=""></option>
                  <?php
                  foreach ($factory as $r) {
                    echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
                  }
                  ?>
                </select>
              </div>
              <button type="button" class="col-md-2 btn blue" onclick="filterpo()">Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Schedule Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule">
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-2">
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
                  <th>Schedule Date</th>
                  <th>PO Number</th>
                  <th>Factory</th>
                  <th>Shipper/Carrier</th>
                  <th>FCL</th>
                  <th>Final Destination</th>
                </tr>
              </thead>
              <tbody id="tblpo"></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader2">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="col-md-3 btn blue" onclick="choose_PO()" id="choose">Choose</button>
          </div>
        </div>
      </div>
      <!-- ggfs -->
      <div id="formdialogPO_ggfs" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Factory</label>
              <div class="col-md-4">
                <select class="form-control select2me" data-placeholder="Factory" id="factory_ggfs">
                  <option value=""></option>
                  <?php
                  foreach ($factory as $r) {
                    echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
                  }
                  ?>
                </select>
              </div>
              <button type="button" class="col-md-2 btn blue" onclick="filterpo_ggfs()">Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Schedule Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule_ggfs">
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label class="col-md-2 label-sm">PO / Carrier</label>
              <div class="col-md-7">
                <input class="form-control input-sm" id="po_ggfs">
              </div>
            </div>
          </div>
          <br>
          <hr>
          <div class="table-scrollable" style="overflow: auto; height:300px;">
            <table id="tbl-po_ggfs" class="table table-bordered">
              <thead>
                <tr>
                  <th width="5px"><input type="checkbox" onchange="check(this)"></th>
                  <th>Schedule Date</th>
                  <th>PO Number</th>
                  <th>Factory</th>
                  <th>Shipper/Carrier</th>
                  <th>FCL</th>
                  <th>Final Destination</th>
                </tr>
              </thead>
              <tbody id="tblpo_ggfs"></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader2">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="col-md-3 btn blue" onclick="choose_PO_ggfs()" id="choose">Choose</button>
          </div>
        </div>
      </div>

      <div id="formdialogPO_ex" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Factory</label>
              <div class="col-md-4">
                <select class="form-control select2me" data-placeholder="Factory" id="factory_ex">
                  <option value=""></option>
                  <?php
                  foreach ($factory as $r) {
                    echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
                  }
                  ?>
                </select>
              </div>
              <button type="button" class="col-md-2 btn blue" onclick="filterpo_ex()">Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Schedule Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule_ex">
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label class="col-md-2 label-sm">PO / Carrier</label>
              <div class="col-md-7">
                <input class="form-control input-sm" id="po_ex">
              </div>
            </div>
          </div>
          <br>
          <hr>
          <div class="table-scrollable" style="overflow: auto; height:300px;">
            <table id="tbl-po_ex" class="table table-bordered">
              <thead>
                <tr>
                  <th>Schedule Date</th>
                  <th>PO Number</th>
                  <th>Factory</th>
                  <th>Shipper/Carrier</th>
                  <th>FCL</th>
                  <th>Final Destination</th>
                </tr>
              </thead>
              <tbody id="tblpo_ex"></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader2">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
        </div>
      </div>
      <div id="formdialogPO_ex_ggfs" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Factory</label>
              <div class="col-md-4">
                <select class="form-control select2me" data-placeholder="Factory" id="factory_ex_ggfs">
                  <option value=""></option>
                  <?php
                  foreach ($factory as $r) {
                    echo '<option value="' . $r->factory_id . '">' . $r->factory_name . '</option>';
                  }
                  ?>
                </select>
              </div>
              <button type="button" class="col-md-2 btn blue" onclick="filterpo_ex_ggfs()">Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-2 label-sm">Schedule Date</label>
              <div class="col-md-4">
                <input class="form-control input-sm date date-picker" data-date="02-12-2012" data-date-format="dd-mm-yyyy" id="schedule_ex_ggfs">
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label class="col-md-2 label-sm">PO / Carrier</label>
              <div class="col-md-7">
                <input class="form-control input-sm" id="po_ex_ggfs">
              </div>
            </div>
          </div>
          <br>
          <hr>
          <div class="table-scrollable" style="overflow: auto; height:300px;">
            <table id="tbl-po_ex_ggfs" class="table table-bordered">
              <thead>
                <tr>
                  <th>Schedule Date</th>
                  <th>PO Number</th>
                  <th>Factory</th>
                  <th>Shipper/Carrier</th>
                  <th>FCL</th>
                  <th>Final Destination</th>
                </tr>
              </thead>
              <tbody id="tblpo_ex_ggfs"></tbody>
            </table>
            <div class="text-center" style="display:none" id="loader2">
              <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
              <p>Loading...</p>
            </div>
          </div>
        </div>
      </div>
      <div id="formdialogPO_lc" hidden>
        <div class="portlet-body">
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-3 label-sm">Container Type</label>
              <div class="col-md-9">
                <?php
                if (!empty($container_name)) {
                ?>
                  <select id='ctr_id' class="form-control select2me">
                    <?php
                    foreach ($container_name as $r) {
                    ?>
                      <option value="<?= $r->container_id; ?>"><?= $r->container_name; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="col-md-3 label-sm">Row Count</label>
              <div class="col-md-9">
                <input type="text" class="txt form-control" name="rowcount" id="rowcount" value="1">
              </div>
            </div>
          </div>
          <br><br><br><br>
          <hr>

          <div class="col-md-6">
            <button type="button" class="col-md-3 btn blue" onclick="choose_PO_lc()" id="choose">Choose</button>
            <button type="button" class="col-md-3 btn grey" onclick="close_PO_lc()">Close</button>
          </div>
        </div>
      </div>
      <div id="formdialog_import" hidden>
        <div class="portlet-body">
          <form id="form-import-excel" method="post" enctype="multipart/form-data"
                action="<?= base_url('Shipping/import_outward_preview') ?>">
            <div class="form-group">
              <label class="control-label col-md-3 col-lg-3">Choose File</label>
              <div class="col-md-9 col-lg-9">
                <input type="file" class="form-control" id="input-excel" name="excel_file" accept=".xlsx,.xls" />
                <small class="form-text text-muted text-danger">Accepted file types: .xlsx, .xls</small>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div id="modal_delete" class="modal fade bs-modal-lg" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

    </div>
  </div>
</div>
</div>
<script>
  document.querySelector('#input-excel').addEventListener('change', function() {
      document.querySelector('#form-import-excel').submit();
  });
</script>
<?php if ($this->session->flashdata('import_result')): ?>
<script>
  const importResult = <?= json_encode($this->session->flashdata('import_result')) ?>;

  if(importResult.status === 'success') {
    $('#vessel_barge').val(importResult.header.vessel_barge);
    $('#voyage_no').val(importResult.header.voyage);
    $('#etddate').val(importResult.header.etd_singapore);
    $('#etadate').val(importResult.header.eta_psg);
    $('#to_out').val(importResult.header.to);
    $('#from_out').val(importResult.header.from);

    // Sheet 1 -> tabel pertama (tblList)
    importResult.data.forEach((rowData, index) => {
        addNewRowFromExcel(rowData, index);
    });

    // Sheet 2 -> tabel ketiga / GGFS (tblList_ggfs)
    if (importResult.data_ggfs && importResult.data_ggfs.length) {
        importResult.data_ggfs.forEach((rowData, index) => {
            addNewRowFromExcel_ggfs(rowData, index);
        });
        cekDtl_ggfs(); // aktifkan tombol Save kalau ada baris GGFS
    }

    $("#formdialog_import").dialog("close");
  } else {
    alert(importResult.message);
  }

  function addNewRowFromExcel(dataRow, index) {
    let containerSizes = '';
    let containerType = '';
    if (dataRow.ct=='GP') {
     containerType = 'Standard Container (s)'
    }else if (dataRow.ct=='HC') {
      containerType = 'High Cube Container (s)'
    }

    if (dataRow.c20 > 0) {
     containerSizes += '20ft ';
    }

    if (dataRow.c40 > 0) {
      containerSizes += '40ft ';
    }



    let fclValue = containerSizes + containerType ;
    fclValue = fclValue.trim(); // Buang spasi ekstra

    var $new_row = $(`
        <tr onclick="deleterow(this)">
            <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="${index + 1}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" onclick="get_po_ex(this)" class="form-control input-sm po" style="width: 110px;" name="po[]" value="" readonly>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="carrier[]" value="${dataRow.shipper || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm fcl" style="width: 110px;" name="fcl[]" value="${fclValue}" readonly>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm dest" style="width: 250px;" name="final[]" value="${dataRow.dest || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 300px;" name="reff[]" value="${dataRow.reff || ''}">
                <textarea class="form-control" name="reff_remark[]" placeholder="Remarks..."></textarea>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select class="form-control input-sm" name="supplier[]" style="width: 250px;">
                    <option value=""></option>
                    <!-- Jika mau, inject opsi supplier dari PHP ke JS variabel -->
                </select>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value="${dataRow.vessel || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value="">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select name="stuffing[]" id="stuffing">
                    <option value="EE">Export Empty</option>
                    <option value="EECN">Export Empty (CN)</option>
                    <option value="EL">Export Laden</option>
                    <option value="IT">Import Transhipment</option>
                    <option value="IL">Import Laden</option>
                    <option value="ITCN">Import Transhipment (CN)</option>
                    <option value="LC">Local Container</option>
                    <option value="RE">Recall Container</option>
                    <option value="ELCN">Export Laden (CN)</option>
                    <option value="ITCNDP" id="ITCNDP">Import Transhipment Direct Purchase(CN)</option>
                    <option value="ITDP" id="ITDP">Import Transhipment Direct Purchase</option>
                </select>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select class="form-control input-sm" name="depot[]" style="width: 200px;">
                    <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                </select>
                <textarea class="form-control" name="depot_remark[]" placeholder="Remarks..."></textarea>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="${dataRow.pod || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="${dataRow.opcode || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value="${dataRow.etasin || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="${dataRow.eta || ''}">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)">
            </td>
            <td hidden>
                <input required type="text" class="form-control input-sm shipid" name="shipid[]" value="">
            </td>
            <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="id[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="actual_seal[]" value=""></td>
            <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="tare_weight[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="trucking_date[]" value="0"></td>
        </tr>
    `);

    $new_row.find('button.btn-danger').on('click', function(e) {
        e.stopPropagation();
        $(this).closest('tr').remove();
    });

    $('table#tblList').append($new_row);
    setSelectByText($new_row.find('select[name="depot[]"]'), dataRow.depot);
  }

  // ====== Sheet 2 -> tabel ketiga (GGFS) ======
  // Catatan: field name pakai suffix "_ggfs[]" agar cocok dengan choose_PO_ggfs.
  // Input shipid/fcl/dest diberi class shipid/fcl/dest dan po_ggfs[] pakai
  // onclick get_po_ex(this), sehingga picker PO existing langsung bisa dipakai.
  function addNewRowFromExcel_ggfs(dataRow, index) {
    let containerSizes = '';
    let containerType = '';
    if (dataRow.ct=='GP') {
     containerType = 'Standard Container (s)'
    }else if (dataRow.ct=='HC') {
      containerType = 'High Cube Container (s)'
    }

    if (dataRow.c20 > 0) {
     containerSizes += '20ft ';
    }

    if (dataRow.c40 > 0) {
      containerSizes += '40ft ';
    }

    let fclValue = containerSizes + containerType ;
    fclValue = fclValue.trim();

    var $new_row = $(`
        <tr onclick="deleterow_ggfs(this)">
            <td><button class="btn btn-sm btn-danger" type="button"><i class="fa fa-trash"></i></button></td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 50px;" name="urut_ggfs[]" value="${index + 1}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" onclick="get_po_ex_ggfs(this)" class="form-control input-sm po" style="width: 110px;" name="po_ggfs[]" value="" readonly>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="carrier_ggfs[]" value="${dataRow.shipper || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm fcl" style="width: 110px;" name="fcl_ggfs[]" value="${fclValue}" readonly>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm dest" style="width: 250px;" name="final_ggfs[]" value="${dataRow.dest || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 300px;" name="reff_ggfs[]" value="${dataRow.reff || ''}">
                <textarea class="form-control" name="reff_remark_ggfs[]" placeholder="Remarks..."></textarea>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select class="form-control input-sm" name="supplier_ggfs[]" style="width: 250px;">
                    <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                </select>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="vessel_ggfs[]" value="${dataRow.vessel || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 200px;" name="convessel_ggfs[]" value="">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select name="stuffing_ggfs[]">
                    <option value="EE">Export Empty</option>
                    <option value="EECN">Export Empty (CN)</option>
                    <option value="EL">Export Laden</option>
                    <option value="IT">Import Transhipment</option>
                    <option value="IL">Import Laden</option>
                    <option value="ITCN">Import Transhipment (CN)</option>
                    <option value="LC">Local Container</option>
                    <option value="RE">Recall Container</option>
                    <option value="ELCN">Export Laden (CN)</option>
                    <option value="ITCNDP">Import Transhipment Direct Purchase(CN)</option>
                    <option value="ITDP">Import Transhipment Direct Purchase</option>
                </select>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <select class="form-control input-sm" name="depot_ggfs[]" style="width: 200px;">
                    <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                </select>
                <textarea class="form-control" name="depot_remark_ggfs[]" placeholder="Remarks..."></textarea>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value="${dataRow.pod || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value="${dataRow.opcode || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin_ggfs[]" value="${dataRow.etasin || ''}">
            </td>
            <td nowrap onclick="event.stopPropagation();return false;">
                <input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value="${dataRow.eta || ''}">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" value="">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value="">
            </td>
            <td hidden>
                <input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight_ggfs[]" value="0" onkeypress="return isNumber(event)">
            </td>
            <td hidden>
                <input required type="text" class="form-control input-sm shipid" name="shipid_ggfs[]" value="">
            </td>
            <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="actual_seal_ggfs[]" value=""></td>
            <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight_ggfs[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="tare_weight_ggfs[]" value="0"></td>
            <td hidden><input type="text" class="form-control input-sm" name="trucking_date_ggfs[]" value="0"></td>
        </tr>
    `);

    $new_row.find('button.btn-danger').on('click', function(e) {
        e.stopPropagation();
        $(this).closest('tr').remove();
    });

    $('table#tblList_ggfs').append($new_row);
    setSelectByText($new_row.find('select[name="depot_ggfs[]"]'), dataRow.depot);
  }

  function setSelectByText($select, text) {
    let matchedOption = $select.find('option').filter(function () {
        return $(this).text().trim() === text.trim();
    }).first();

    if (matchedOption.length) {
        $select.val(matchedOption.val());
    }
  }
</script>
<?php endif; ?>

<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
  });

  let currentInput = null;
  function get_po_ex(el) {
    currentInput = el; // simpan referensi input yang diklik
    fnDialogPO_ex();
  }


  $(document).on('input', '#tblList_lc input[name="container_number_lc[]"]', function () {
    const $row = $(this).closest('tr');
    // opsional: normalisasi (hapus spasi & uppercase)
    // const v = $(this).val().replace(/\s+/g, '').toUpperCase();
    const v = $(this).val();
    const $reff = $row.find('input[name="reff_lc[]"]');

    // kalau reff_lc belum disentuh user, sinkronkan
    if (!$reff.data('manual')) {
      $reff.val(v);
    }
  });

  $(document).on('input', '#tblList_lc input[name="reff_lc[]"]', function () {
    $(this).data('manual', true);
  });

  function fnDialogPO_ex() {
    // Define the Dialog and its properties.
    $("#formdialogPO_ex").dialog({
      resizable: false,
      modal: true,
      title: "List PO PSS",
      height: 550,
      width: 800

    });
    // filterContainerLocal();
  }

  function filterpo_ex() {
    $factory = document.getElementById("factory_ex").value;
    $schedule = document.getElementById("schedule_ex").value;
    $po = document.getElementById("po_ex").value;

    // $("#tblpo_ex").html("");

    $.ajax({
      dataType: "json",
      url: "<?php echo base_url(); ?>shipping/container_po_ex?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      beforeSend: function() {
        $("#loader2").show();
      },
      success: function(response) {
        if (response.length > 0) {
        var html = "";
          response.forEach(function (item, index) {
            const dateObj = new Date(item.schedule_date);
            const d = String(dateObj.getDate()).padStart(2, '0');
            const m = String(dateObj.getMonth() + 1).padStart(2, '0');
            const y = dateObj.getFullYear();
            html += `
              <tr>
                <td class="select-data">${d+'-'+m+'-'+y}</td>
                <td class="select-data">${item.po_number}</td>
                <td class="select-data">${item.factory_abbr}</td>
                <td class="select-data">${item.shipping_name}</td>
                <td class="select-data">${item.container_name}</td>
                <td class="select-data">${item.port_name +'-'+item.destination}</td>
                <td class="select-data" hidden>${item.ship_id}</td>
              </tr>
            `;
          });
          $("#tblpo_ex").html(html);
        }
      },
      complete: function() {
        $("#loader2").hide();
      }
    });

    return false;
  }

  document.getElementById("tblpo_ex").addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("select-data")) {
      const row = e.target.closest("tr"); // ambil baris
      const cells = row.querySelectorAll("td");

      const poNumber = cells[1].textContent.trim();   // Kolom ke-2
      const shipId = cells[6].textContent.trim();     // Kolom ke-7 (hidden)
      const fcl = cells[4].textContent.trim();     // Kolom ke-7 (hidden)
      const dest = cells[5].textContent.trim();     // Kolom ke-7 (hidden)
      console.log(fcl);
      // Masukkan nilai ke input yang sedang aktif
      if (currentInput) {
        currentInput.value = poNumber;

        // Kalau kamu punya hidden input untuk ship_id
        const shipIdField = currentInput.closest("tr").querySelector(".shipid");
        const fclValue = currentInput.closest("tr").querySelector(".fcl");
        const destValue = currentInput.closest("tr").querySelector(".dest");
        if (shipIdField) {
          shipIdField.value = shipId;
          fclValue.value = fcl;
          destValue.value = dest;
        }
      }

      $("#formdialogPO_ex").dialog("close");
      cekDtl();
    }
  });

  function fn_import() {
    $("#formdialog_import").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 250,
      width: 600

    });
  }

  function choose_PO_lc() {
    $ctr_name = $('#ctr_id option:selected').text();
    $ctr_id = $('#ctr_id option:selected').val();
    $rowcount = $('#rowcount').val();

    console.log($ctr_name);
    console.log($ctr_id);
    console.log($rowcount);

    for ($i = 0; $i < $rowcount; $i++) {
      var $new_row = $('<tr onclick="deleterow_lc(this)">\n\
                                    <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="urut_lc[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" style="width: 100px;"><select name="stuffing_lc[]" id="stuffing_lc"><option value="LL" id="LL">Local Laden<option value="LE" id="LE">Local Empty<option value="LLTP" id="LLTP">Local Laden (TP)</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name_lc[]" value="' + $ctr_name + '" readonly><input type="hidden" class="form-control input-sm" name="container_id_lc[]" value="' + $ctr_id + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control container_number_lc input-sm" name="container_number_lc[]" value="" required></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier_lc[]">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </select>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;" required>\n\
                                        <select class="form-control input-sm" name="customer_lc[]">\n\
                                            <option value="PSS">Pulau Sambu Singapore Pte Ltd</option>\n\
                                            <?php foreach ($supp as $r) { ?>\n\
                                            <option value="<?php echo $r->customer_code; ?>"><?php echo $r->customer_name; ?></option>\n\
                                        <?php } ?>\n\
                                        </select>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control reff_lc input-sm" name="reff_lc[]" value="" required></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id_lc[]" value="0" required></td>\n\
                                        <td hidden></td>\n\
                                        <td hidden></td>\n\
                                </tr>');

      $('table[id="tblList_lc"]').append($new_row);
    }

    $("#formdialogPO_lc").dialog("close");
  }

  function close_PO_lc() {
    $("#formdialogPO_lc").dialog("close");
  }


  function deleterow_lc(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList_lc").deleteRow($r);
      cekDtl();
    }
  }

  function fnDialogPO_lc() {
    // Define the Dialog and its properties.
    $("#formdialogPO_lc").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 250,
      width: 800

    });
    // filterContainerLocal();
  }

  function fnDialogPO() {
    // Define the Dialog and its properties.
    $("#formdialogPO").dialog({
      resizable: false,
      modal: true,
      title: "List PO",
      height: 570,
      width: 800

    });
  }

  $('#formdialogPO').on('dialogclose', function(event) {
    $('#tblpo').html("");
  });


  function fnDialogContainerAll() {
    // Define the Dialog and its properties.
    $("#formdialogContainerAll").dialog({
      resizable: false,
      modal: true,
      title: "List Container",
      height: 650,
      width: 1200

    });
  }

  $('#formdialogContainerAll').on('dialogclose', function(event) {
    $('#tblcontainerall').html("");
  });


  function fnDialogContainerOutward() {
    $("#formdialogContainerOutward").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class='form-control input-sm' id='findcontaineroutward'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-1 btn blue' onclick='filtercontaineroutward()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable' style='overflow: auto; height:490px;'>\n\
                            <table id='tbl-containerall' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Action</th>\n\
                                        <th>Tipe</th>\n\
                                        <th>Shipment Date</th>\n\
                                        <th>Vessel (Barge)</th>\n\
                                        <th>Voyage</th>\n\
                                        <th>ETD</th>\n\
                                        <th>ETD Date</th>\n\
                                        <th>ETA</th>\n\
                                        <th>ETA Date</th>\n\
                                        <th>From</th>\n\
                                        <th>To</th>\n\
                                        <th>Created By</th>\n\
                                        <th>Created Date</th>\n\
                                        <th>LastUpdated By</th>\n\
                                        <th>LastUpdated Date</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblcontaineroutward'>\n\
                                    <tr>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogContainerOutward").dialog({
      resizable: false,
      modal: true,
      title: "List Container Outward",
      height: 650,
      width: 1200

    });
  }

  //    checkAll
  function check(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = true;
        }
      }
    } else {
      for (var i = 0; i < checkboxes.length; i++) {
        console.log(i)
        if (checkboxes[i].type == 'checkbox') {
          checkboxes[i].checked = false;
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
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 300px;" name="reff[]" value=""><textarea class="form-control" name="reff_remark[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier[]" style="width: 250px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" id="stuffing"> <option value="EE" id="EE" onclick="">Export Empty <option value="EECN" id="EECN" onclick="">Export Empty (CN) <option value="EL" id="EL">Export Laden<option value="IT" id="IT">Import Transhipment <option value="IL" id="IL">Import Laden <option value="ITCN" id="ITCN">Import Transhipment (CN) <option value="LC" id="LC">Local Container <option value="RE" id="RE">Recall Container <option value="ELCN" id="ELCN">Export Laden (CN)<option value="ITCNDP" id="ITCNDP">Import Transhipment Direct Purchase(CN)<option value="ITDP" id="ITDP">Import Transhipment Direct Purchase</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="depot[]" style="width: 200px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                                        <textarea class="form-control" name="depot_remark[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="' + getText(document.getElementById("tbl-po").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="actual_seal[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="tare_weight[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="trucking_date[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList"]').append($new_row);
      }
      i++;
    }

    $("#formdialogPO").dialog("close");
    cekDtl();
  }

  function close_PO() {
    $("#formdialogPO").dialog("close");
  }


  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
      cekDtl();
    }
  }

  function filtercontainerall() {
    $dt_shipment = document.getElementById("dt_shipment").value;
    $dt_data = document.getElementById("dt_data").value;

    $("#tblcontainerall").html("");

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_containerall?dt=" + $dt_shipment + "&call=" + $dt_data + "",
      dataType: "html",
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(response) {
        if (response == '') {
          $("#tblcontainerall").html("<tr><td class='text-center' colspan='15'>List Empty</td></tr>");
        } else {
          $("#tblcontainerall").html(response);
        }

      },
      complete: function() {
        $("#loader").hide();
      }
    });
  }

  function filtercontaineroutward() {
    $findcontaineroutward = document.getElementById("findcontaineroutward").value;

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_containeroutward?cout=" + $findcontaineroutward + "",
      success: function(response) {
        $("#tblcontaineroutward").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filterpo() {
    filterpodtl();
  }

  function filterpodtl() {
    $factory = document.getElementById("factory").value;
    $schedule = document.getElementById("schedule").value;
    $po = document.getElementById("po").value;

    $("#tblpo").html("");

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>shipping/container_po?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      beforeSend: function() {
        $("#loader2").show();
      },
      success: function(response) {
        $("#tblpo").html(response);
      },
      complete: function() {
        $("#loader2").hide();
      }
    });

    return false;
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("shipid[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function modal_delete(data) {

    $.ajax({
      url: "<?php echo base_url(); ?>shipping/container_modal_delete?delete=" + data + "",
      success: function(response) {
        $("#modal_delete").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
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

  function run_disable_depot() {
    $ck1 = document.getElementById('EE').checked;
    $ck2 = document.getElementById('EL').checked;
    $ck3 = document.getElementById('IL').checked;
    $ck4 = document.getElementById('IT').checked;

    var depot = document.getElementById("depot");

    if ($ck1 == true) {
      depot.disabled = false;
    } else if ($ck2 == true) {
      depot.disabled = true;
    } else if ($ck3 == true) {
      depot.disabled = true;
    } else {
      depot.disabled = true;
    }
  }
</script>

<script>
  function fnDialogPO_ggfs() {
    $("#formdialogPO_ggfs").dialog({
      resizable: false,
      modal: true,
      title: "List PO GGFS",
      height: 570,
      width: 800

    });
  }

  $('#formdialogPO_ggfs').on('dialogclose', function(event) {
    $('#tblpo_ggfs').html("");
  });

  function choose_PO_ggfs() {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    var chk_arr = document.getElementsByName("chk_ggfs[]");

    var chk_length = chk_arr.length;
    i = 1;

    for (k = 0; k < chk_length; k++) {
      if (chk_arr[k].checked == true) {
        var $new_row = $('<tr onclick="deleterow_ggfs(this)">\n\
                                    <td><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut_ggfs[]" value="0"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[2]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="carrier_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[4]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[5]) + '" disabled></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 250px;" name="final_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[6]) + '"></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 300px;" name="reff_ggfs[]" value=""><textarea class="form-control" name="reff_remark_ggfs[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="supplier_ggfs[]" style="width: 250px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($ven as $r) { ?>\n\
                                            <option value="<?php echo $r->id_supp; ?>"><?php echo $r->name_supp; ?></option>\n\
                                        <?php } ?>\n\
                                        </td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="vessel_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 200px;" name="convessel_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing_ggfs[]" id="stuffing"> <option value="EE" id="EE" onclick="">Export Empty <option value="EECN" id="EECN" onclick="">Export Empty (CN) <option value="EL" id="EL">Export Laden<option value="IT" id="IT">Import Transhipment <option value="IL" id="IL">Import Laden <option value="ITCN" id="ITCN">Import Transhipment (CN) <option value="LC" id="LC">Local Container <option value="RE" id="RE">Recall Container <option value="ELCN" id="ELCN">Export Laden (CN)<option value="ITCNDP" id="ITCNDP">Import Transhipment Direct Purchase(CN)<option value="ITDP" id="ITDP">Import Transhipment Direct Purchase</select></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;">\n\
                                        <select class="form-control input-sm" name="depot_ggfs[]" style="width: 200px;">\n\
                                            <option value=""></option>\n\
                                            <?php foreach ($depot as $r) { ?>\n\
                                            <option value="<?php echo $r->depot_id; ?>"><?php echo $r->depot_name; ?></option>\n\
                                        <?php } ?>\n\
                                        <textarea class="form-control" name="depot_remark_ggfs[]" value="" placeholder="Remarks..."></textarea></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etdsin_ggfs[]" value=""></td>\n\
                                        <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 150px;" name="container_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" style="width: 100px;" name="seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight_ggfs[]" value="0" onkeypress="return isNumber(event)"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="shipid_ggfs[]" value="' + getText(document.getElementById("tbl-po_ggfs").rows[i].cells[7]) + '"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="outward_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="id_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="actual_seal_ggfs[]" value=""></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="total_gross_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="tare_weight_ggfs[]" value="0"></td>\n\
                                        <td hidden><input type="text" class="form-control input-sm" name="trucking_date_ggfs[]" value="0"></td>\n\
                                </tr>');

        //                $new_row.find('.date').datepicker();

        $('table[id="tblList_ggfs"]').append($new_row);
      }
      i++;
    }

    $("#formdialogPO_ggfs").dialog("close");
    cekDtl_ggfs ();
  }

  
  function close_PO_ggfs() {
    $("#formdialogPO_ggfs").dialog("close");
  }

  function deleterow_ggfs(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList_ggfs").deleteRow($r);
      cekDtl_ggfs();
    }
  }

  function filterpo_ggfs() {
    filterpodtl_ggfs();
  }

  function filterpodtl_ggfs() {
    $factory = document.getElementById("factory_ggfs").value;
    $schedule = document.getElementById("schedule_ggfs").value;
    $po = document.getElementById("po_ggfs").value;

    $("#tblpo_ggfs").html("");

    $.ajax({
      dataType: "html",
      url: "<?php echo base_url(); ?>shipping/container_po_ggfs?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      beforeSend: function() {
        $("#loader2").show();
      },
      success: function(response) {
        $("#tblpo_ggfs").html(response);
      },
      complete: function() {
        $("#loader2").hide();
      }
    });

    return false;
  }

  function cekDtl_ggfs() {
    var ID_arr = document.getElementsByName("shipid_ggfs[]");
    var ID_length = ID_arr.length;

    if ((ID_length > 0)) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }
</script>

<script type="text/javascript">
  let currentInput_g = null;
  function get_po_ex_ggfs(el) {
    currentInput_g = el; // simpan referensi input yang diklik
    fnDialogPO_ex_ggfs();
  }
  function fnDialogPO_ex_ggfs() {
    // Define the Dialog and its properties.
    $("#formdialogPO_ex_ggfs").dialog({
      resizable: false,
      modal: true,
      title: "List PO GGFS",
      height: 550,
      width: 800

    });
    // filterContainerLocal();
  }

  function filterpo_ex_ggfs() {
    $factory = document.getElementById("factory_ex_ggfs").value;
    $schedule = document.getElementById("schedule_ex_ggfs").value;
    $po = document.getElementById("po_ex_ggfs").value;

    // $("#tblpo_ex_ggfs").html("");

    $.ajax({
      dataType: "json",
      url: "<?php echo base_url(); ?>shipping/container_po_ex_ggfs?fac=" + $factory + "&schedule=" + $schedule + "&po=" + $po + "",
      beforeSend: function() {
        $("#loader2").show();
      },
      success: function(response) {
        if (response.length > 0) {
        var html = "";
          response.forEach(function (item, index) {
            const dateObj = new Date(item.schedule_date);
            const d = String(dateObj.getDate()).padStart(2, '0');
            const m = String(dateObj.getMonth() + 1).padStart(2, '0');
            const y = dateObj.getFullYear();
            html += `
              <tr>
                <td class="select-data">${d+'-'+m+'-'+y}</td>
                <td class="select-data">${item.po_number}</td>
                <td class="select-data">${item.factory_abbr}</td>
                <td class="select-data">${item.shipping_name}</td>
                <td class="select-data">${item.container_name}</td>
                <td class="select-data">${item.port_name +'-'+item.destination}</td>
                <td class="select-data" hidden>${item.ship_id}</td>
              </tr>
            `;
          });
          $("#tblpo_ex_ggfs").html(html);
        }
      },
      complete: function() {
        $("#loader2").hide();
      }
    });

    return false;
  }

  document.getElementById("tblpo_ex_ggfs").addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("select-data")) {
      const row = e.target.closest("tr"); // ambil baris
      const cells = row.querySelectorAll("td");

      const poNumber = cells[1].textContent.trim();   // Kolom ke-2
      const shipId = cells[6].textContent.trim();     // Kolom ke-7 (hidden)
      const fcl = cells[4].textContent.trim();     // Kolom ke-7 (hidden)
      const dest = cells[5].textContent.trim();     // Kolom ke-7 (hidden)
      console.log(fcl);
      // Masukkan nilai ke input yang sedang aktif
      if (currentInput_g) {
        currentInput_g.value = poNumber;

        // Kalau kamu punya hidden input untuk ship_id
        const shipIdField = currentInput_g.closest("tr").querySelector(".shipid");
        const fclValue = currentInput_g.closest("tr").querySelector(".fcl");
        const destValue = currentInput_g.closest("tr").querySelector(".dest");
        if (shipIdField) {
          shipIdField.value = shipId;
          fclValue.value = fcl;
          destValue.value = dest;
        }
      }

      $("#formdialogPO_ex_ggfs").dialog("close");
      cekDtl_ggfs();
    }
  });
</script>