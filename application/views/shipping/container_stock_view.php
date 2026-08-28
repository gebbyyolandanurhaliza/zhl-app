<script>
  function hitungSelisihHari2() {
    var tgl2 = document.getElementById('free_time').value;
    var tgl3 = document.getElementById('free_time_expiry');
    var str = document.getElementById('arrival_date').value;

    if (!str || !tgl2) {
      tgl3.value = '';
      return;
    }

    var tanggal = str.split("/");
    var tgl = tanggal[0];
    var bln = tanggal[1];
    var thn = tanggal[2];
    var tt = bln + "/" + tgl + "/" + thn;
    var date = new Date(tt);

    if (isNaN(date.getTime())) {
      tgl3.value = '';
      return;
    }

    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + Number(tgl2));
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = dd + '/' + mm + '/' + y;
    tgl3.value = someFormattedDate;
  }

  function ambil_tabel() {
    var no_reff = document.getElementById('no_reff').value;
    $.ajax({
      url: "<?php echo base_url(); ?>index.php/shipping/cek_tabel?id=" + no_reff,
      success: function(response) {
        $(".CurID").html(response);
      },
      dataType: "html"
    });
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
    var a = document.getElementById('arrival_date').value;
    if (!a) return;

    var b = a.replace(/\//g, "");
    var c = b.substring(2);

    $.ajax({
      url: "<?php echo base_url(); ?>Shipping/get_refnumber1?tgl=" + c + "",
      success: function(response) {
        $('#ganti').html(response);
      },
      dataType: "html"
    });
  }
</script>

<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
      <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Container Stock</span>
            </div>
            <div class="note note-success note-bordered" id="pesan_error" style="display: none;">
              <p>
                Please click the "Search Coa" and then click the "Save" button.
              </p>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div id="formdialogStock" hidden>
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
                <button type="button" class="col-md-3 btn blue" onclick="choose_Container()" id="choose">Choose</button>
                <button type="button" class="col-md-3 btn grey" onclick="close_Container()">Close</button>
              </div>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('shipping/container_stock_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="loading_port">Loading Port</label>
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="loading_port" id="loading_port" placeholder="Loading Port" value="" />
                        <input type="hidden" class="form-control" name="stock_id_hdr" id="stock_id_hdr" value="" />
                      </div>
                      <span class="help-inline"></span>
                      <label class="col-md-2 control-label" for="arrival_date">Arrival Date</label>
                      <div class="col-md-3">
                        <input type="text" onchange="ganti_ref();" name="arrival_date" class="form-control date date-picker" value="" data-date-format="dd/mm/yyyy" id="arrival_date" placeholder="Arrival Date" required />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="factory">Factory</label>
                      <div class="col-md-4">
                        <select name="factory" id="factory" class="form-control">
                          <option></option>
                          <option value="RSUP">Riau Sakti United Plantations</option>
                          <option value="PSG">Pulau Sambu Guntung</option>
                        </select>
                      </div>
                      <label class="col-md-2 control-label" for="free_time">Free Time</label>
                      <div class="col-md-3">
                        <input type="text" name="free_time" id="free_time" value="" placeholder="Free Time" class="form-control autonumber" onfocus="this.value = '';" onkeyup="hitungSelisihHari2()" onkeypress="return isNumber(event)" required />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                    <div class="form-group">
                      <span class="help-inline"></span>
                      <label class="col-md-2 control-label" for="supplier">Supplier</label>
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="supplier" id="supplier" placeholder="Supplier" value="" />
                      </div>
                      <label class="col-md-2 control-label" for="free_time_expiry">Free Time Expiry Date</label>
                      <div class="col-md-3">
                        <input type="text" name="free_time_expiry" class="form-control" value="" id="free_time_expiry" placeholder="Free Time Expiry" readonly="" required />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="import_bl_no">Import BL No</label>
                      <div class="col-md-4">
                        <input type="text" class="form-control" name="import_bl_no" id="import_bl_no" placeholder="BL NO" value="" />
                      </div>
                      <span class="help-inline"></span>

                      <label class="col-md-2 control-label" for="carrier">Carrier</label>
                      <div class="col-md-3">
                        <input type="text" class="form-control" name="carrier" id="carrier" placeholder="carrier" value="" />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                  </div>
                </div>
              </div>

              <div class="table-scrollable">
                <table class="table table-bordered" id="tblList">
                  <thead>
                    <tr>
                      <th width="10px"><button class="btn btn-sm green" type="button" onclick="fnDialogStock()"><i class="fa fa-plus"></i></button></th>
                      <th width="300px" nowrap>Container Type</th>
                      <th width="300px" nowrap>Container Number</th>
                      <th width="600px" nowrap>Remark</th>
                    </tr>
                  </thead>
                  <tbody id="tblList_1">
                  </tbody>
                </table>
              </div>
          </div>
          <hr>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                <button type="reset" class="btn btn-primary">Cancel</button>
              </div>
            </div>
          </div>

          </form>
        </div>

      </div>
      </div>

  </div>
</div>

<script>
  function choose_Container() {
    var ctr_name = $('#ctr_id option:selected').text();
    var ctr_id = $('#ctr_id option:selected').val();
    var rowcount = parseInt($('#rowcount').val(), 10) || 1;

    for (var i = 0; i < rowcount; i++) {
      var new_row = $('<tr onclick="deleterow(this)">\n\
            <td align="center"><button class="btn btn-sm btn-danger" type="button" ><i class="fa fa-trash" ></i></button></td>\n\
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_name[]" value="' + ctr_name + '" readonly><input type="hidden" class="form-control input-sm" name="container_id[]" value="' + ctr_id + '"></td>\n\
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" name="container_number[]" value=""></td>\n\
            <td hidden nowrap onclick="event.stopPropagation();return false;" style="width: 10px;"><select name="Remark2[]" class="form-control input-sm"><option value="" >SELECT</option><option value="IFT" >Insufficient FT</option><option value="QCf" >QC fail</option><option value="RNC" >Reuse not approved by carrier</option><option value="CC" >Customs Checks</option><option value="ULS" >Used for local stuffing</option></select> </td>\n\
            <td nowrap onclick="event.stopPropagation();return false;" style="width: 300px;"><input type="text" class="form-control input-sm" name="Remark[]" value=""></td>\n\
            <td hidden></td>\n\
            <td hidden></td>\n\
            <td hidden></td>\n\
        </tr>');

      $('#tblList_1').append(new_row);
    }

    $("#formdialogStock").dialog("close");
    cekDtl();
  }

  function close_Container() {
    $("#formdialogStock").dialog("close");
  }

  function fnDialogStock() {
    $("#formdialogStock").dialog({
      resizable: false,
      modal: true,
      title: "List Stock Container",
      height: 250,
      width: 800
    });
  }

  function cekDtl() {
    var ID_arr = document.getElementsByName("container_id[]");
    var ID_length = ID_arr.length;

    if (ID_length > 0) {
      $('#btn-save').attr('disabled', false);
    } else {
      $('#btn-save').attr('disabled', true);
    }
  }

  function deleterow(x) {
    var r = x.rowIndex;

    if (confirm("Are you sure remove this row?") == true) {
      document.getElementById("tblList").deleteRow(r);
      cekDtl();
    }
  }

  $(document).ready(function() {
    cekDtl();
  });
</script>
<script src="<?= base_url('assets/ai_assistant/js/autofill-container-stock.js'); ?>?v=<?= time(); ?>"></script>
