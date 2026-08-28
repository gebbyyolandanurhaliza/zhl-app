<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">
  <ul class="nav navbar-nav pull-right">

    <li class="droddown dropdown-separator">
      <a href="javascript:;">
        <span class="datespan" id="tglatas">Date: <?= date('l,d F Y') ?> | <span class="datespan" id="clock">00:00:00</span></span>
      </a>
    </li>

    <li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="icon-film"></i>
      </a>
      <ul class="dropdown-menu">
        <li class="external">
          <h3>Select tutorial</h3>
        </li>
        <li>
          <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
            <li>
              <a href="<?php echo base_url(); ?>Movie?id=jurnal" target="_blank">
                <span class="details">
                  <span class="label label-sm label-icon label-success">
                    <i class="fa fa-truck"></i>
                  </span>Purchase Invoice Jurnal Tutorial </span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>Movie?id=master">
                <span class="details">
                  <span class="label label-sm label-icon label-primary">
                    <i class="fa fa-bar-chart"></i>
                  </span>Master Container Price Tutorial </span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>Movie?id=sales_invoice">
                <span class="details">
                  <span class="label label-sm label-icon label-primary">
                    <i class="fa fa-bar-chart"></i>
                  </span>Sales Invoice Jurnal Tutorial </span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li class="droddown dropdown-separator">
      <span class="separator"></span>
    </li>
    <li class="dropdown dropdown-user dropdown-dark">
      <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <?php
        if (file_exists(FCPATH . "uploads/" . $this->session->userdata('userid_1') . ".jpg")) {
          $image = base_url('uploads/' . $this->session->userdata('userid_1') . '.jpg');
        } else {
          $image = base_url('images/default.png');
        }
        ?>
        <img alt="avatar" class="img-circle" src="<?= $image ?>">
        <span class="username username-hide-mobile" style="font-weight: bold;"><?php echo ucfirst($this->session->userdata('firstname_1')) . " " . ucfirst($this->session->userdata('lastname_1')) ?>
          <span class="badge badge-info"><?= $this->session->userdata('jabatan_1'); ?></span></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-default">
        <li>
          <a type="button" data-toggle="modal" data-target="#myModalupdate">
            <i class="icon-lock"></i> Select Company </a>
        </li>
        <li class="divider"></li>
        <li>
          <a href="<?php echo base_url(); ?>User_Profile">
            <i class="icon-user"></i> My Profile </a>
        </li>
        <li>
          <a href="<?php echo site_url('home/signout'); ?>">
            <i class="icon-key"></i> Log Out </a>
        </li>
      </ul>
    </li>

  </ul>
</div>
<!-- END TOP NAVIGATION MENU -->
<div class="modal fade" id="myModalupdate" role="dialog">
  <div class="modal-dialog modal-sm">
    <?php
    $user = $this->session->userdata('userid_1');
    $comp = $this->session->userdata('company_id');
    $sql = 'select * from zhl_zht_user where userid="' . $user . '" ';
    $row = $this->db->query($sql)->result();
    ?>
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?php echo base_url(); ?>Home/set_session_update" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Company Access</h4>
        </div>
        <div class="modal-body">
          <select class="form-control select2me" data-placeholder="company_id" name="company_id" id="company_id">
            <option value=""></option>
            <?php
            foreach ($row as $r) {
              if ($comp == $r->company_id) {
                $checked = "selected";
              } else {
                $checked = "";
              }
              echo '<option value="' . $r->company_id . '" ' . $checked . '>' . $r->company_name . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" name="btn" class="btn btn-danger">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>