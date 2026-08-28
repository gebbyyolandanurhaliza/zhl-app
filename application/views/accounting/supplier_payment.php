<?php
error_reporting(0)
?>
<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <form action="<?php echo base_url(); ?>payable_recognition/save_payable_rec" method="post">
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-credit-card theme-font"></i>
                <span class="caption-subject theme-font">Supplier Down Payment Description</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Supplier</label>
                      <div class="col-md-9">
                        <select name="txtSupplier" class="select2me form-control">
                          <option value=""></option>
                          <option value="KM">KARA MARKETING</option>
                          <option value="FGA">FIRST GRADE AGENCY</option>
                          <option value="FAIRTECK">FAIRTECK HOLDING</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Period</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="tgl_tempo" class="form-control date date-picker" data-date="12-2015" data-date-format="mm-yyyy" required />
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
              <hr />

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn purple"><i class="fa fa-refresh"></i> Refresh</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
                <thead>
                  <tr>
                    <th>
                      Supplier ID
                    </th>
                    <th>
                      Supplier Name
                    </th>
                    <th>
                      Reff. No.
                    </th>
                    <th>
                      Date
                    </th>
                    <th>
                      Due Date
                    </th>
                    <th>
                      Amount
                    </th>
                    <th>
                      Remain
                    </th>
                    <th>
                      Currency
                    </th>
                    <th>
                      Rate
                    </th>
                    <th>
                      Remain Equivalent
                    </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

            </div>
          </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tabel").dataTable({
      "scrollY": 400,
      "scrollX": true
    });
  });
</script>