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
            <form action="<?php echo site_url('System_log'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php foreach ($log as $key) { ?>
                      <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $key->id ?>">
                      <div class="form-group">
                        <label class="col-md-2 control-label" for="int">Date of Create</label>
                        <div class="col-md-4">
                          <input type="text" name="date" class="form-control date" value="<?php echo $key->tgl ?>" id="date" readonly required />
                        </div>
                        <span class="help-inline"></span>
                      </div>

                      <div class="form-group">
                        <label class="col-md-2 control-label" for="int">Create By</label>
                        <div class="col-md-4">
                          <input type="text" readonly name="prog" id="prog" value="<?php echo $key->creator ?>" class="form-control autonumber" />
                        </div>
                        <span class="help-inline"></span>
                      </div>

                      <div class="form-group">
                        <label class="col-md-2 control-label" for="int">Subject of Log</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="sub" id="sub" value="<?php echo $key->subjek ?>" readonly />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-2 control-label" for="int">Content of Log</label>
                        <div class="col-md-10">
                          <textarea name="isi" id="isi" cols="105" rows="20" readonly><?php echo $key->isi ?></textarea>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-offset-10">
                    <a><button type="submit" class="btn btn-primary">Back</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>