<?php //error_reporting(0)              
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
                <span class="caption-subject theme-font">Monitoring Accounts Receivable Aging</span>
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
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <select name="txtcurrency" class="select2me form-control">
                          <option value=""></option>
                          <option value="USD">USD</option>
                          <option value="USG">USG</option>
                          <option value="Rp">Rupiah</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Group Supplier</label>
                      <div class="col-md-9">
                        <select name="txtcurrency" class="select2me form-control">
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <input type="text" id="tgl_tempo" name="tgl_tempo" class="form-control date date-picker" data-date="12-02-2012" data-date-format="mm-dd-yyyy" required />
                      </div>
                    </div>
                  </div>
                  <!--/span-->
                </div>
              </div>
              <hr />

              <table class="table table-bordered" id="tabel">
                <thead>
                  <tr>
                    <th width="20%">
                      Supplier
                    </th>
                    <th width="8%">
                      Inv. Date
                    </th>
                    <th width="10%">
                      Invoice Number
                    </th>
                    <th width="8%">
                      Due Date
                    </th>
                    <th width="8%">
                      Not Due Date
                    </th>
                    <th width="10%">
                      0-30 Days
                    </th>
                    <th width="10%">
                      31-60 Days
                    </th>
                    <th width="10%">
                      61-90 Days
                    </th>
                    <th width="10%">
                      91-120 Days
                    </th>
                    <th width="10%">
                      > 120 Days
                    </th>
                    <th width="20%">
                      Total
                    </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-offset-3 col-md-9">
                        <button type="button" class="btn green"><i class="fa fa-file-excel-o"></i> Excell</button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print Detail</button>
                        <button type="button" class="btn red"><i class="fa fa-print"></i> Print Global</button>
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
            </div>
          </div>
      </form>
    </div>
  </div>
</div>