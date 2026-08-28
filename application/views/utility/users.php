<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-3">
          <div class="portlet light">
            <div class="portlet-body">
              <center>
                <?php
                if (file_exists(FCPATH . "uploads/" . $this->session->userdata('userid_1') . ".jpg")) {
                  $image = base_url('uploads/' . $this->session->userdata('userid_1') . '.jpg');
                } else {
                  $image = base_url('images/default.png');
                }
                ?>
                <img src="<?= $image ?>" width="215px" height="215px" border="1px solid #d0d0d0">
              </center>
            </div>
          </div>
        </div>
        <div class="col-md-9">


          <div class="portlet light">
            <div class="portlet-title">
              <h4><i class="fa fa-user"></i>User Profile</h4>
            </div>
            <div class="portlet-body form">
              <div class="tabbable header-tabs">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                  </li>
                  <li>
                    <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                  </li>
                  <li>
                    <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                  </li>
                </ul>
                <div class="portlet-body">
                  <div class="tab-content">
                    <!-- PERSONAL INFO TAB -->
                    <?php
                    foreach ($profile as $p) {
                    ?>
                      <div class="tab-pane active" id="tab_1_1">
                        <form role="form" method="post" action="<?php echo base_url(); ?>index.php/Manage_User/update_profile?id=<?php echo $p->userid; ?>">
                          <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input type="text" value="<?php echo $p->firstname; ?>" name="firstname" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" value="<?php echo $p->lastname; ?>" name="lastname" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label class="control-label">Mobile Number</label>
                            <input type="text" value="<?php echo $p->mobilenumber; ?>" name="mobilenumber" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label class="control-label">Group<span class="required">* </span></label>
                            <?php
                            $style_currency = "class='select2me form-control' id='group' required";
                            echo form_dropdown('group', $GroupID, $p->groupid, $style_currency);
                            ?>
                            <div style="color: red"><?php echo form_error('group'); ?></div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Position<span class="required">* </span></label>

                            <input type="text" value="<?php echo $p->position_name; ?>" name="position" class="form-control" />

                            <div style="color: red"><?php echo form_error('group'); ?></div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" value="<?php echo $p->email; ?>" name="email" class="form-control" />
                          </div>
                          <div class="form-group">
                            <label class="control-label">Occupation<span class="required">* </span></label>
                            <input type="text" placeholder='Occupation at work' name="jabatan" value="<?php echo $p->jabatan; ?>" class="form-control" />

                          </div>
                          <div class="margiv-top-10">
                            <input type="hidden" value="<?php echo $p->userid; ?>" name="userid" class="form-control" />
                            <input type="submit" class="btn blue-dark" value="Save">
                          </div>
                        </form>
                      </div>
                    <?php
                    }
                    ?>
                    <!-- END PERSONAL INFO TAB -->
                    <!-- CHANGE AVATAR TAB -->
                    <div class="tab-pane" id="tab_1_2">

                      <?php echo form_open_multipart('User_Profile/do_upload'); ?>
                      <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="" alt="" />
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                          </div>
                          <div>
                            <label style="color: red"> * For best picture, please upload image in "JPEG or JPG" format only.</label>
                          </div>
                          <div>
                            <input type="file" name="userfile" class="btn" size="20" />

                            <input type="hidden" name="username" value="<?php echo $userid; ?>" class="form-control" />
                          </div>
                        </div>

                      </div>
                      <div class="margin-top-10">
                        <button class="btn green-haze" type="submit">Submit </button>
                        <button class="btn default" type="reset">Cancel </button>
                      </div>
                      </form>
                    </div>
                    <!-- END CHANGE AVATAR TAB -->
                    <!-- CHANGE PASSWORD TAB -->
                    <div class="tab-pane" id="tab_1_3">
                      <?php
                      foreach ($profile as $s) {
                      ?>
                        <form action="<?php echo base_url(); ?>index.php/Manage_User/change_password" method="post">
                          <input type="hidden" name="username" value="<?php echo $s->userid; ?>" class="form-control" />
                          <input type="hidden" name="valid_pass" id="valid_pass" id="valid_pass" value="<?php echo $s->userpassword; ?>" class="form-control" />
                          <!-- <div class="form-group">
                                                         <label class="control-label">Current Password</label>
                                                         <input type="password" name="old_password" id="old_password" class="form-control"/>
                                                         <div id="valid" style="color: red"><?php echo form_error('old_password'); ?></div>
                                                     </div>-->
                          <div class="form-group">
                            <label class="control-label">New Password</label>
                            <input type="password" name="pass1" id="pass1" class="form-control" />
                            <div style="color: red"><?php echo form_error('pass1'); ?></div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Re-type New Password</label>
                            <input type="password" name="pass2" id="pass2" onchange="checkpass()" class="form-control" />
                            <p id="demo" style="color: red"></p>
                            <div style="color: red"><?php echo form_error('pass2'); ?></div>
                          </div>
                          <div class="margin-top-10">
                            <button type="submit" class="btn green-haze">
                              Change Password </button>
                          </div>
                        </form>
                      <?php } ?>
                    </div>
                    <!-- END CHANGE PASSWORD TAB -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END PROFILE CONTENT -->
    </div>
  </div>
  <!-- END PAGE CONTENT INNER -->
</div>
<!-- END PAGE CONTENT -->

<script>
  function checkpass() {
    var valid_pass = document.getElementById('pass1').value;
    var old_pass = document.getElementById('pass2').value;

    if (valid_pass === old_pass) {
      document.getElementById("demo").innerHTML = '';
    } else {
      document.getElementById("demo").innerHTML = 'Current password is incorect, please tray again';
    }
  }
</script>