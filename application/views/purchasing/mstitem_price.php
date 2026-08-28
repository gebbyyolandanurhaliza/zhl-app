<?php error_reporting(0) ?>

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
              <span class="caption-subject theme-font bold">Item Price</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('purchasing/item_price_save/add'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Vendor</label>
                      <div class="col-md-4">
                        <div class="input-group">
                          <input type="text" class="form-control input-sm" id="vendorid" name="vendorid" required>
                          <span class="input-group-btn">
                            <button class="btn btn-sm btn-primary" type="button" style="height:30px;" onclick="fnDialogvendor()"><i class="fa fa-arrow-down"></i></button>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Name</label>
                      <div class="col-md-5">
                        <input class="form-control input-sm" id="name" name="name" readonly>
                      </div>
                    </div>
                    <div class="form-group " style="margin-bottom:1px;">
                      <label class="col-md-3 label-sm">Contact Person</label>
                      <div class="col-md-4">
                        <input class="form-control input-sm" id="contact" name="contact" readonly>
                      </div>
                    </div>
                    <div class="form-group" style="margin-bottom:1px;">
                      <div class="col-md-4 col-md-offset-3">
                        <select class="form-control select2me" data-placeholder="Currency" name="cur" required>
                          <option value=""></option>
                          <?php
                          foreach ($cur as $r) {
                            echo '<option value="' . $r->currency_id . '">' . $r->currency_id . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="table-responsive">
                  <table class="table table-bordered" id="tblList">
                    <thead>
                      <tr>
                        <th width="10px"><button class="btn btn-sm btn-primary" type="button" onclick="fnDialogItem()"><i class="fa fa-arrow-down"></i></button></th>
                        <th width="20%">Item ID</th>
                        <th width="40%">Item Name</th>
                        <th width="10%">Label PM Code</th>
                        <th width="10%">UOM</th>
                        <th width="10%">Unit Price</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>

              <hr>

              <div class="form-actions">
                <div class="col-md-6">
                  <button type="submit" class="col-md-2 btn btn-primary" id="btn-save">Save</button>
                  <button type="reset" class="col-md-2 btn btn-default">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List Item Price</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <!--                        <div class="row">
                            <div class="col-md-6 col-md-push-6">
                                 <div class="form-group">
                                    <label class="col-md-2 col-md-push-6 label-sm">Search</label>
                                    <div class="col-md-4 col-md-push-6">
                                        <input class="form-control input-sm" id="search">
                                    </div>
                                </div>
                            </div>
                        </div>-->

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-md-1 label-sm">Vendor</label>
                  <div class="col-md-3">
                    <input class="form-control input-sm" id="search">
                  </div>
                  <div class="col-md-5">
                    <button class="btn btn-primary btn-sm" onclick="search()">Refresh</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-scrollable" style="overflow: auto; height:400px;">
              <table class="table table-bordered tree" id="table">
                <thead>
                  <tr>
                    <th class="text-center">Actions</th>
                    <th class="text-center">Item ID</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Label PM Code</th>
                    <th class="text-center">UOM</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Currency</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>
                </thead>
                <tbody id="tbl-mon">
                  <?php
                  $supplier = '';
                  $i = 0;
                  foreach ($item_price as $r) {
                    if ($supplier != $r->vendorid) {
                      $i++;
                      $x = $i;
                  ?>
                      <tr class="treegrid-<?php echo $i; ?>" style="cursor: pointer;background-color: #e7edf3">
                        <td colspan="15"> <?php echo $r->vendorcompany; ?> </td>
                      </tr>
                    <?php $i++;
                    } ?>
                    <tr class="treegrid-<?php echo $i++; ?> treegrid-parent-<?php echo $x; ?>" style="cursor: pointer;">
                      <td nowrap>
                        <a class="btn-sm btn-warning" href="<?php echo site_url('purchasing/item_price_edit?price=' . $r->pricehdrid . '&item=' . $r->itemid); ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/item_price_delete?price=' . $r->pricehdrid . '&item=' . $r->itemid); ?>" onclick="javasciprt: return confirm('Are you sure delete Item <?php echo htmlspecialchars($r->itemname, ENT_QUOTES); ?> ?')"><i class="fa fa-trash"></i></a>
                      </td>
                      <td nowrap><?php echo $r->itemid; ?></td>
                      <td nowrap><?php echo $r->itemname; ?></td>
                      <td nowrap><?php echo $r->pmcode; ?></td>
                      <td nowrap><?php echo $r->uomname; ?></td>
                      <td nowrap><?php echo number_format($r->unitprice, 4); ?></td>
                      <td nowrap><?php echo $r->currencyid; ?></td>
                      <td nowrap><?php echo $r->createdby; ?></td>
                      <td nowrap><?php echo $r->createddate; ?></td>
                      <td nowrap><?php echo $r->lastupdatedby; ?></td>
                      <td nowrap><?php echo $r->lastupdateddate; ?></td>
                    </tr>
                  <?php
                    $supplier = $r->vendorid;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div id="formdialogvendor"></div>
        <div id="formdialogItem"></div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#btn-save').attr('disabled', true);
  });
</script>

<script type="text/javascript">
  //  $(document).ready(function(){
  //     $('.tree').treegrid({
  //      'initialState': 'collapsed',
  //      'saveState': false
  //    });

  //     $("#search").keyup(function(){
  //         _this = this;
  //        $.each($("#table tbody tr"), function() {
  //            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
  //               $(this).hide();
  //            else
  //               $(this).show();                
  //        });
  //    });

  $('#tbl-mon tr').each(function(a, b) {
    $(b).click(function() {
      $('#tbl-mon tr').css('color', '#000000');
      $(this).css('color', '#0000FF');
    });
  });
  //  });
</script>

<script>
  function fnDialogItem() {
    $("#formdialogItem").html(" <div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class=form-control input-sm' id='finditem'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filteritem()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable'>\n\
                            <table id='tbl-item' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Item ID</th>\n\
                                        <th>Item Name</th>\n\
                                        <th>Label PM Code</th>\n\
                                        <th>UOM</th>\n\
                                        <th>Item Remark</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblitem'>\n\
                                    <tr ondblclick='clickdbitem(this)'>\n\
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
    $("#formdialogItem").dialog({
      resizable: false,
      modal: true,
      title: "List Item",
      height: 650,
      width: 1200

    });
  }

  function fnDialogvendor() {
    $("#formdialogvendor").html("<div class='portlet-body'>\n\
                        <div class='col-md-12'>\n\
                            <div class='form-group'>\n\
                                 <label class='col-md-1 label-sm'>Find</label>\n\
                                 <div class='col-md-7'>\n\
                                        <input class=form-control input-sm' id='findvendor'>\n\
                                 </div>\n\
                                 <button type='button' class='col-md-2 btn blue' onclick='filtervendor()'>Search</button>\n\
                            </div>\n\
                        </div>\n\
                        <br><hr>\n\
                        <div class='table-scrollable'>\n\
                            <table id='tbl-vendor' class='table table-bordered'>\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>Vendor ID</th>\n\
                                        <th>Vendor Company</th>\n\
                                        <th>Contact Person</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody id='tblvendor'>\n\
                                    <tr ondblclick='clickdbvendor(this)'>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                        <td></td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </div>\n\
                    </div>");

    // Define the Dialog and its properties.
    $("#formdialogvendor").dialog({
      resizable: false,
      modal: true,
      title: "List Vendor",
      height: 500,
      width: 850

    });
  }
</script>
<script>
  function clickdbvendor(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;
    document.getElementById('vendorid').value = getText(document.getElementById('tbl-vendor').rows[$r].cells[0]);
    document.getElementById('name').value = getText(document.getElementById('tbl-vendor').rows[$r].cells[1]);
    document.getElementById('contact').value = getText(document.getElementById('tbl-vendor').rows[$r].cells[2]);

    $("#formdialogvendor").dialog("close");
    cekDtl();
  }

  function clickdbitem(x) {
    function getText(el) {
      if (typeof el.textContent == 'string') return el.textContent;
      if (typeof el.innerText == 'string') return el.innerText;
    }

    $r = x.rowIndex;

    $('table[id="tblList"]').append('<tr onclick="deleterow(this)">\n\
                    <td><button class="btn btn-sm btn-light-grey" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="ItemID[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[0]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="ItemName[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[1]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="PMCode[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[2]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm"  ame="UOM[]" value="' + getText(document.getElementById('tbl-item').rows[$r].cells[3]) + '" readonly></td>\n\
                    <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" name="UnitPrice[]" value="0"></td>\n\
        </tr>');

    $("#formdialogItem").dialog("close");
    cekDtl();
  }

  function deleterow(x) {
    $r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow($r);
    }
    cekDtl();
  }


  function filtervendor() {
    $findvendor = document.getElementById("findvendor").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_price_vendor?vendor=" + $findvendor + "",
      success: function(response) {
        $("#tblvendor").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function filteritem() {
    $finditem = document.getElementById("finditem").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_price_item?item=" + $finditem + "",
      success: function(response) {
        $("#tblitem").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function search() {
    $search = document.getElementById('search').value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing/item_price_search?search=" + $search + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("ItemID[]");
    var ID_length = ID_arr.length;
    $vendor = document.getElementById("vendorid").value;

    if ((ID_length > 0) && ($vendor != "")) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }
</script>