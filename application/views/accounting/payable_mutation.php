<?php
if ($this->input->get('periode') == '') {
  $supp = '';
  $cur = '';
  $periode = date("Y-m-d");
} else {
  $supp = $this->input->get('supplier');
  $cur = $this->input->get('currency');
  $periode = $this->input->get('periode');

  $curTemp = $cur;

  if ($curTemp == '') {
    $curTemp = 'USD';
  }
}
?>
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<!-- BEGIN PAGE HEAD -->
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Account Payable Outstanding Report</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>
<!-- END PAGE HEAD -->
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Account Payable Outstanding Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Payable_mutation/search" method="get" id="form1">
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="periode" class="form-control date date-picker" value="<?php echo $periode; ?>" data-date="2016-02-01" data-date-format="yyyy-mm-dd" required />

                      </div>
                    </div>
                  </div>

                  <!--/span-->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label col-md-2">Supplier</label>
                      <div class="col-md-10">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="supplier" ';
                        echo form_dropdown('supplier', $SupplierID, $supp, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_curreny = 'class="select2me form-control" id="currency" ';
                        echo form_dropdown('currency', $CurrencyID, $cur, $style_curreny);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">

                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <button type="submit" class="btn purple kiri" id="refresh" value="refresh"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                                                <div class="row">
                                                    <div class="control-label col-md-9">
                                                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</button>
                                                         <a href="<?php echo base_url(); ?>Excel/toExcel3?supplier=<?php echo $supp; ?>&currency=<?php echo $cur; ?>&periode=<?php echo $period; ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                                                    </div>
                                                </div>
                                            </div> -->
                      <div class="col-md-4">
                        <div class="row">
                          <div class="control-label col-md-9">
                            <a href="<?php echo base_url(); ?>Payable_mutation/print_report?periode=<?php echo $this->input->get('periode'); ?>&supplier=<?php echo $this->input->get('supplier'); ?>&currency=<?php echo $this->input->get('currency'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
            </div>
          </form>


          <?php
          if (!empty($Get_aging)) {
          ?>
            <table class="table table-bordered" id="tabel1">
              <thead>
                <tr>
                  <th width="50%">
                    Supplier
                  </th>

                  <th width="30%">
                    Total (<?php echo $curTemp; ?>)
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totgt = 0;
                foreach ($GroupSupplierID as $m) {
                  $gt = 0;

                  foreach ($Get_aging as $v) {
                    if ($v->tmp_kodesup == $m->kode_sup) {
                      $gt += $v->tmp_not_due_date + $v->tmp_0sd30 + $v->tmp_31sd60 + $v->tmp_61sd90 + $v->tmp_91sd120 + $v->tmp_more120;
                    }
                  }
                  echo " <tr ><td style='text-align:left;'>" . $m->suppliercompany . "</td>"
                    . "<td style='text-align:right;font-weight: bold;'>" . number_format($gt, 2, '.', ',') . "</td></tr>";

                  $totgt += $gt;
                }
                echo " <tr style='background: #ffffcc'><td  style='text-align:right;f'><b>Grand Total</b></td>"
                  . "<td style='text-align:right;font-weight: bold;'>" . number_format($totgt, 2, '.', ',') . "</td>
                                        </tr>";

                ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {


      // $('form#form1').submit(function(){
      //       var currency = document.getElementById('currency').value;
      //      if(currency == ''){
      //           var curr = 'ALL';
      //      }else{
      //           var curr = 'currency';
      //      }
      //      document.getElementById('matauang').value = curr;
      //  }); 

      // if(btn === 'refresh'){
      //      window.onbeforeunload = function(){
      //      alert('tes');
      //     };

      // }

      $("#tabel").dataTable({
        "scrollY": 400,
        "scrollX": true
      });
    });
  </script>