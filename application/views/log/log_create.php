<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">PSS System Log</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body form">
            <form action="<?php echo site_url('System_log/log_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="int">Date of Create</label>
                      <div class="col-md-4">
                        <input type="text" name="date" class="form-control date" value="<?php $now = date('d-m-Y H:i:s');
                                                                                        echo $now; ?>" id="arrival_date" readonly required />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="int">Create By</label>
                      <div class="col-md-4">
                        <input type="text" readonly name="prog" id="prog" value="<?php $prog = strtoupper($this->session->userdata('userid_1'));
                                                                                  echo $prog; ?>" class="form-control autonumber" required />
                      </div>
                      <span class="help-inline"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="int">Subject of Log</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="sub" id="sub" value="" required />
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="int">Content of Log</label>
                      <div class="col-md-10">
                        <textarea name="isi" id="isi" cols="105" rows="20" required placeholder="Maximum Character is 1500..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-offset-10 col-md-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-primary">Cancel</button>
                  </div>
                </div>
              </div>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>