<?php
error_reporting(0);
?>
<!-- PAGE -->
<div class="page-content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-table theme-font"></i>
                                <span class="caption-subject theme-font">User Registration</span>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form id="form_sample_2" method="post" action="<?php echo base_url(); ?>Manage_User/insert_profile">
                                <!-- PERSONAL INFO TAB -->
                                <div class="form-group">
                                    <label class="control-label">First Name <span class="required">* </span></label>
                                    <input type="text" class="form-control" value="<?php echo set_value('firstname'); ?>" name="firstname"/>
                                    <div style="color: red"><?php echo form_error('firstname'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo set_value('lastname'); ?>"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Mobile Number</label>
                                    <input type="text" placeholder='000-00-000-000' name="mobilenumber" value="<?php echo set_value('mobilenumber'); ?>" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email<span class="required">* </span></label>
                                    <input type="email" placeholder='Your Email address' name="email" value="<?php echo set_value('email'); ?>" class="form-control"/>
                                    <div style="color: red"><?php echo form_error('email'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Occupation<span class="required">* </span></label>
                                    <input type="text" placeholder='Occupation at work' name="jabatan" value="<?php echo set_value('jabatan'); ?>" class="form-control"/>
                                    <div style="color: red"><?php echo form_error('jabatan'); ?></div>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label class="control-label">Group<span class="required">* </span></label>
                                    <?php
                                        $style_currency = "class='select2me form-control' id='group' required";
                                        echo form_dropdown('group', $GroupID, '', $style_currency);
                                    
                                    ?>
                                    <div style="color: red"><?php echo form_error('group'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Position<span class="required">* </span></label>
                                    <?php
                                        $style_position = "class='select2me form-control' id='position' required";
                                        echo form_dropdown('position', $PositionID, '', $style_position);
                                    
                                    ?>
                                    <div style="color: red"><?php echo form_error('group'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">User ID<span class="required">* </span></label>
                                    <input type="text" placeholder='Choose your User ID' name="userid" value="<?php echo set_value('userid'); ?>" class="form-control"/>
                                    <div style="color: red"><?php echo form_error('userid'); ?></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password<span class="required">* </span></label>
                                    <input type="password" placeholder='Press your password' name="pass" value="<?php echo set_value('pass'); ?>" class="form-control"/>
                                    <div style="color: red"><?php echo form_error('pass'); ?></div>
                                </div>
                                <div class="margiv-top-10">
                                    <input type="submit" class="btn blue-dark" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
                <div class="col-md-8">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-table theme-font"></i>
                                <span class="caption-subject theme-font">Manage User</span>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                            </div>
                        </div>

                        <div class="portlet-body flip-scroll">
                            <table id="datatable2" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">
                                            ID User
                                        </th>
                                        <th width="15%">
                                            Full&nbsp;Name
                                        </th>
                                        <th width="15%">
                                            Email
                                        </th>
                                        <th width="10%">
                                            Status
                                        </th>
                                        <th width="10%">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Database berawal disini -->
                                    <?php
                                    foreach ($daftar as $v) {
                                        ?>
                                        <tr>
                                            <td><?php echo $v->userid; ?></td>
                                            <td><?php echo $v->firstname . "&nbsp;" . $v->lastname; ?></td>
                                            <td><a href="mailto:<?php echo $v->email; ?>"><?php echo $v->email; ?></a></td>
                                            <td style="text-align: center">
                                            <?php 
                                                if ($v->notactive == 0){
                                                    echo "Active";
                                                } else {
                                                    echo "Not Active";
                                                }
                                             ?>
                                                
                                            </td>
                                            <td  style="text-align: center">
                                                <a href="<?php echo base_url(); ?>index.php/User_Profile?id=<?php echo $v->userid; ?>"><i class="fa fa-pencil"></i></a>
                                                <a class="bt  btn-danger" href="<?php echo base_url(); ?>Manage_User/inactive_user?id=<?php echo $v->userid; ?>">Non Active</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <!-- Database berakhir disini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: center" width="10%">
                                            ID User
                                        </th>
                                        <th style="text-align: center" width="15%">
                                            Full&nbsp;Name
                                        </th>
                                        <th style="text-align: center" width="15%">
                                            Email
                                        </th>
                                        <th style="text-align: center" width="10%">
                                            Status
                                        </th>
                                        <th style="text-align: center" width="10%">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /BOX -->
                </div>
            </div>
            <!-- /EXPORT TABLES -->
            <div class="footer-tools">
                <span class="go-top">
                    <i class="fa fa-chevron-up"></i> Top
                </span>
            </div>
        </div>
    </div>
</div>
</section>
<!--/PAGE -->
