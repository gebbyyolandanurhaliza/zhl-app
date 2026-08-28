<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <?php echo $message; ?>

        <div class="col-md-7">

          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase">Master Of Item Invoice</span>

              </div>
              <div class="kanan">
                <!-- <a class="btn green" href="<?php echo base_url(); ?>Excel/toExcelCoa"><i class="fa fa-file-excel-o"></i> Export to excel</a> -->
              </div>
            </div>
            <div class="portlet-body">
              <table class="datatable table table-bordered table-hover" id="datatable2">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Item Number</th>
                    <th>Item Name</th>
                    <th>Income COA</th>
                    <th>Expenses COA</th>
                    <th>GST Type</th>
                    <th>Description</th>
                    <th hidden>Income Dept</th>
                    <th hidden>Expenses Dept</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($all_item)) {
                    foreach ($all_item as $v) {
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <?php
                        if($v->income_dept == null){
                          $accountIncome = $v->Income_coa;
                          $accountExpenses = $v->expenses_coa;
                        }else{
                          $accountIncome = $v->Income_coa."-".$v->income_dept."-002";
                          $accountExpenses = $v->expenses_coa."-".$v->expenses_dept."-002";
                        }
                        echo "<td>$v->Id</td>"
                          . "<td>$v->Item_number</td>"
                          . "<td>$v->Item_name</td>"
                          . "<td>$accountIncome</td>"
                          . "<td>$accountExpenses</td>"
                          // . "<td>$v->price2</td>"
                          // . "<td>$v->Price</td>"
                          . "<td>$v->gst_type</td>"
                          . "<td>$v->Description</td>"
                          . "<td hidden>$v->income_dept</td>"
                          . "<td hidden>$v->expenses_dept</td>"
                        ?>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- END PORTLET-->
        </div>
        <div class="col-md-5">

          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> FORM</span>
                <span class="caption-helper">Input Item</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <!-- FORM MASTER COA -->

              <form role="form" method="post" action="<?php echo $action; ?>">
                <div class="form-group">
                  <input type="hidden" id="Id" name="Id" class="form-control" readonly />
                  <label class="control-label">Item Number</label>
                  <input type="text" id="Itemnumber" name="Item_number" class="form-control" onkeyup="cek_coa()" required />
                  <div id="err"></div>
                </div>
                <div class="form-group">
                  <label class="control-label">Item Name</label>
                  <input type="text" id="Itemname" name="Item_name" class="form-control" required />
                </div>
                <div class="form-group">
                      <label class="control-label">Income COA</label>
                      <div class="input-group">
                          <input type="text" id="Incomecoa" name="Income_coa" class="form-control" readonly />
                          <input type="hidden" id="income_oldcoa" name="income_oldcoa" class="form-control" readonly />
                          <span class="input-group-btn">
                            <button  data-toggle="modal" onclick="coa(1)" class="btn btn-sm btn-primary" type="button" style="height:35px;"><i class="fa fa-arrow-down"></i></button>
                          </span>
                      </div>
                  
                </div>
                <div class="form-group">
                  <label class="control-label">Expenses COA</label>
                  <div class="input-group">
                    <input type="text" id="expensescoa" name="expenses_coa" class="form-control" readonly />
                    <input type="hidden" id="expenses_oldcoa" name="expenses_oldcoa" class="form-control" readonly />
                        <span class="input-group-btn">
                          <button  data-toggle="modal" onclick="coa(2)" class="btn btn-sm btn-primary" type="button" style="height:35px;"><i class="fa fa-arrow-down"></i></button>
                        </span>
                    </div>
                </div>
                <!-- <div class="form-group">
                  <label class="control-label">Price Sell</label>
                  <input type="text" id="pricesell" name="price_sell" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="control-label">Price Buy</label>
                  <input type="text" id="pricebuy" name="price_buy" class="form-control" />
                </div> -->
                <div class="form-group">
                  <label class="control-label">GST Type</label>
                  <select class="form-control" id="gst_type" name="gst_type">
                    <option value="">Select</option>
                    <option value="GST">GST</option>
                    <option value="ZER">Zero Rate</option>
                    <option value="EXP">Exampt</option>
                    <option value="OUT">Out of Scope</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label">Description</label>
              <textarea type="text" id="Description" name="Description" class="form-control"></textarea>
            </div>

            <div class="margiv-top-10">
              <input type="submit" name="sbt" id="tombol" class="btn btn-primary" value="Save Data">
            </div>
            </form>
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

<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">List of Master COA</h4>
        <input class="form-control" type="text" id="search" placeholder="Search">
      </div>
      <div class="modal-body">
        <input type="hidden" name="data_coa" id="data_coa">
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


<script>
  $(document).ready(function() {
    $("#datatable2").dataTable({
      "scrollY": 350,
      "scrollX": true
    });

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



  function getText(el) {
    if (typeof el.textContent === 'string')
      return el.textContent;
    if (typeof el.innerText === 'string')
      return el.innerText;
  }


  function pilih(x) {

    $r = x.rowIndex;
    var url = "<?php echo base_url(); ?>";
    var Id = getText(document.getElementById('datatable2').rows[$r].cells[0]);
    var Itemnumber = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var Itemname = getText(document.getElementById('datatable2').rows[$r].cells[2]);
    var Incomecoa = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var expensescoa = getText(document.getElementById('datatable2').rows[$r].cells[4]);
    var gst_type = getText(document.getElementById('datatable2').rows[$r].cells[5]);
    var Description = getText(document.getElementById('datatable2').rows[$r].cells[6]);
    var income_dept = getText(document.getElementById('datatable2').rows[$r].cells[7]);
    var expenses_dept = getText(document.getElementById('datatable2').rows[$r].cells[8]);

    document.getElementById('Id').value = Id;
    document.getElementById('Itemnumber').value = Itemnumber;
    document.getElementById('Itemname').value = Itemname;
    document.getElementById('Incomecoa').value = Incomecoa;
    document.getElementById('expensescoa').value = expensescoa;
    // document.getElementById('pricesell').value = pricesell;
    // document.getElementById('pricebuy').value = pricebuy;
    document.getElementById('gst_type').value = gst_type;
    document.getElementById('Description').value = Description;
    document.getElementById('income_oldcoa').value = income_dept;
    document.getElementById('expenses_oldcoa').value = expenses_dept;
    document.getElementById('tombol').value = 'Update';
    
    $('body').scrollTop(0);
  }

  function ambil(x) {
    var data_coa = document.getElementById('data_coa').value;
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var AccNo = getText(document.getElementById('tbl_coa').rows[$r].cells[4]);
    var coaNew = getText(document.getElementById('tbl_coa').rows[$r].cells[5]);
    console.log("ini adalkah acc no" + coaNew);
    if (data_coa==1) {
      document.getElementById('Incomecoa').value = AccNo;
      document.getElementById('income_oldcoa').value = coaNew;
    }else if (data_coa==2) {
      document.getElementById('expensescoa').value = AccNo;
      document.getElementById('expenses_oldcoa').value = coaNew;
    }
    
    $('#coa').modal('hide');
  }

  function coa(id) {
    $('#coa').modal('show');
    document.getElementById('data_coa').value = id;
  }

  function cek_coa() {
    var Itemnumber = document.getElementById('Itemnumber').value;
    $.ajax({
      url: "<?php echo base_url(); ?>Master_COA/cek_coa?id=" + NoCOA,
      success: function(response) {
        $("#err").html(response);
      },
      dataType: "html"
    });
  }
</script>