<?php
error_reporting(0)
?>

<script type="text/javascript">
  //    checkAll
  function checkall(ele) {

    var checkboxes = document.getElementsByName('chk[]');
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
</script>

<style>
  input {
    border: 0px;
  }
</style>

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
              <i class="fa fa-upload theme-font"></i>
              <span class="caption-subject theme-font bold">Import NPBB</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
            echo form_open_multipart('purchasing_npbb/npbb_transfer_ex', $att); ?>
            <div class="form-group">
              <div class="col-md-3">
                <input type="file" id="file_upload" name="userfile" size="20" onchange="tempExcel()" style="display: none;" />
                <input id="txt_excel" name="txt_excel" type="text" class="form-control" placeholder="Put Your Excel in Here">
              </div>
              <div>
                <button type="button" class="col-md-1 btn green" onclick="findExcel()">Find</button>
                <button type="submit" class="col-md-1 btn yellow-lemon">Procces</button>
              </div>
            </div>
            <?php echo form_close(); ?>

            <hr>

            <form action="<?php echo site_url('purchasing_npbb/npbb_transfer_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">

                <div class="table-scrollable" style="overflow: auto; height:400px;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th witdh="10px">#</th>
                        <th>NPBB No</th>
                        <th>NPBB Date</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Qnty</th>
                        <th>UOM</th>
                        <th>Currency</th>
                        <th>Rate</th>
                        <th>Unit Price</th>
                        <th>Remark</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0;
                      if (isset($NPBBNo)) {
                        while ($i < count($NPBBNo)) :

                          $sql = $this->db->query("Select * from gen_tbl_mst_item where idcwp1 = '$ItemID[$i]' or idcwp2 = '$ItemID[$i]' or idcwp3='$ItemID[$i]'");

                          if ($sql->num_rows() > 0) {
                            $x = 1;
                          } else {
                            $x = 0;
                          }

                      ?>
                          <tr <?php if ($x == 0) {
                                echo 'style="color:#FF0000"';
                              } ?>>
                            <td style="width: 5px;"><input type="checkbox" name="chk[]" value="<?php echo $i; ?>"></td>
                            <td nowrap><input type="text" name="NPBBNo[]" value="<?php echo $NPBBNo[$i]; ?>" readonly style="width: 120px;"></td>
                            <td nowrap><input type="text" name="TransDate[]" value="<?php echo $TransDate[$i]; ?>" readonly style="width: 80px;"></td>
                            <td nowrap><input type="text" name="ItemID[]" value="<?php echo $ItemID[$i]; ?> " readonly style="width: 80px;"></td>
                            <td nowrap><input type="text" name="ItemName[]" value="<?php echo htmlspecialchars($ItemName[$i], ENT_QUOTES); ?>" readonly style="width: 300px;"></td>
                            <td nowrap><input type="text" name="Qnty[]" value="<?php echo $Qnty[$i]; ?>" readonly style="width: 50px;text-align: right;"></td>
                            <td nowrap><input type="text" name="PurchaseUOM[]" value="<?php echo $Uom[$i]; ?>" readonly style="width: 50px;"></td>
                            <td nowrap><input type="text" name="Currency[]" value="<?php echo $Currency[$i]; ?>" readonly style="width: 50px;"></td>
                            <td nowrap><input type="text" name="ExchangeRate[]" value="<?php echo $ExchangeRate[$i]; ?>" readonly style="width: 50px;text-align: right;"></td>
                            <td nowrap><input type="text" name="UnitPrice[]" value="<?php echo $UnitPrice[$i]; ?>" readonly style="width: 50px;text-align: right;"></td>
                            <td nowrap><input type="text" name="Remark[]" value="<?php echo $Remark[$i]; ?>" readonly style="width: 200px;"></td>
                            <td style="display: none;"><input type="text" name="Active[]" value="<?php echo $x; ?>"></td>
                          </tr>
                      <?php $i++;
                        endwhile;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-offset-10">
                  <button type="submit" class="col-md-5 btn blue">Save</button>
                  <a class="col-md-5 btn default" href="<?php echo site_url('purchasing_npbb/import_npbb'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List NPBB</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="expand"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body" style="display:none;">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">Date</label>
                    <div class="col-md-9">
                      <div class="input-group input-large date-picker input-daterange" data-date="2012-10-11" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control input-sm" name="from" value="<?php echo date("Y-m-d"); ?>">
                        <span class="input-group-addon">
                          to </span>
                        <input type="text" class="form-control input-sm" name="to" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3">NPBB</label>
                    <div class="col-md-4">
                      <input type="text" class="form-control input-sm" name="npbb">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-md-offset-2 col-md-pull-2">Item</label>
                    <div class="col-md-5 col-md-pull-3">
                      <input type="text" class="form-control input-sm" name="Item">
                    </div>
                    <div style="margin-left:20px;">
                      <button class="btn btn-primary btn-sm col-md-2 col-md-offset-3" onclick="search()">Refresh</button>
                    </div>
                  </div>
                </div>
              </div>

              <br>
              <hr>

              <div class="table-scrollable" style="overflow: auto; height:400px;">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>NPBB No</th>
                      <th>NPBB Date</th>
                      <th>Item ID</th>
                      <th>Item Name</th>
                      <th>Qnty</th>
                      <th>UOM</th>
                      <th>Currency</th>
                      <th>Rate</th>
                      <th>Unit Price</th>
                      <th>Remark</th>

                    </tr>
                  </thead>
                  <tbody id="tblMon">
                    <?php foreach ($npbb_temp as $r) { ?>
                      <tr>
                        <td>
                          <a class="btn-sm" href="<?php echo site_url('purchasing_npbb/npbb_temp_delete?npbb=' . $r->npbbno . '&item=' . $r->itemid); ?>" onclick="javasciprt: return confirm('Are you sure delete NPBB No : <?php echo $r->npbbno; ?> and  Item : <?php echo $r->itemname; ?> ?')"><i class="fa fa-trash"></i></a>
                        </td>
                        <td nowrap><?php echo $r->npbbno; ?></td>
                        <td nowrap><?php echo date("d-m-Y", strtotime($r->transdate)); ?></td>
                        <td nowrap><?php echo $r->itemid; ?></td>
                        <td nowrap><?php echo $r->itemname; ?></td>
                        <td nowrap class="text-right"><?php echo $r->qnty; ?></td>
                        <td nowrap><?php echo $r->uom; ?></td>
                        <td nowrap><?php echo $r->currencyid; ?></td>
                        <td nowrap class="text-right"><?php echo $r->exchangerate; ?></td>
                        <td nowrap class="text-right"><?php echo $r->unitprice; ?></td>
                        <td nowrap><?php echo $r->remark; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function findExcel() {
    document.getElementById('file_upload').click();
  }

  function tempExcel() {
    var temp = document.getElementById('file_upload').value;
    document.getElementById('txt_excel').value = temp;
  }

  function search() {
    $from = document.getElementById("from").value;
    $to = document.getElementById("to").value;
    $npbb = document.getElementById("npbb").value;
    $item = document.getElementById("item").value;

    $.ajax({
      url: "<?php echo base_url(); ?>purchasing_npbb/import_npbb_search/" + $from + "/" + $to + "/" + $npbb + "/" + $item + "",
      success: function(response) {
        $("#tblMon").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>