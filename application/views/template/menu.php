<style>
  .page-header .page-header-menu .hor-menu .navbar-nav>li.mega-menu-dropdown.mega-menu-full .dropdown-menu {
    left: 30px;
    right: 30px;
  }
</style>

<div class="page-header-menu">
  <div class="container-fluid">

    <div class="hor-menu ">
      <ul class="nav navbar-nav">

        <!-- Menu Home -->
        <li>
          <a href="<?php echo base_url(); ?>">
            <i class="icon-home"></i>&nbsp;
          </a>
        </li>

        <?php
        $user_group_id = $this->session->userdata('groupid_1');
        $company   = strtoupper($this->session->userdata('company_id'));
        $head_menu = $this->M_menu->get_head_menu();
        foreach ($head_menu as $h) {
          // sql dibawah ini untuk mendeteksi apakah pakai menu classic atau mega menu
          $sql = 'select count(menuhdr_id) as rec_count from zhl_gen_vw_utl_menu where menuhdr_id=' . $h->menu_id . ' and menudtlsub_id is null';
          $row = $this->db->query($sql)->row();

          if ($row) {
            if ($row->rec_count > 0) {
              // menu level 1 - classic menu
              echo '<li class="menu-dropdown classic-menu-dropdown ">';
              echo '<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">';
              echo $h->menu_title;
              echo '<i class="fa fa-angle-down"></i>';
              echo '</a>';

              echo '<ul class="dropdown-menu pull-left" style="min-width: 255px">';
              echo '<li class="">';

              // get menu level 2
              $param2 = array(
                'user_group_id'  => $user_group_id,
                'menu_level'  => 2,
                'menu_parent_id' => $h->menu_id,
              );
              $this->db->order_by('column_group', 'asc');
              $this->db->order_by('menu_title', 'asc');
              $detail_menu = $this->db->get_where('zhl_gen_vw_utl_menu_access', $param2)->result();
              foreach ($detail_menu as $d) {
                echo anchor(site_url($d->menu_link), '<i class="fa ' . $d->menu_icon . '"></i> ' . $d->menu_title);
              }

              echo '</li></ul>';
              echo '</li>';
            } else {
              //menu level 1 - mega menu / classic menu => check di tabel gen_tbl_utl_menu_hdr
              if ($h->menu_style == 'mega') {
                echo '<li class="menu-dropdown mega-menu-dropdown mega-menu-full">';
              } else {
                echo '<li class="menu-dropdown mega-menu-dropdown">';
              }

              echo '<a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">';
              echo $h->menu_title;
              echo '<i class="fa fa-angle-down"></i>';
              echo '</a>';

              $row = $this->db->query('select column_group from zhl_gen_tbl_utl_menu_dtl where menuhdr_id=' . $h->menu_id . ' order by column_group desc limit 1')->row();

              if ($row) {
                $menu_width = $row->column_group * 320;
                $class_width = ($row->column_group != 0) ? (12 / $row->column_group) : 12;
              }

              echo '<ul class="dropdown-menu" style="min-width: ' . $menu_width . 'px">';
              echo '<li>';
              echo '<div class="mega-menu-content">';
              echo '<div class="row">';

              // get menu level 2
              for ($column = 1; $column < 4; $column++) {

                echo '<div class="col-md-' . $class_width . '">';
                echo '<ul class="mega-menu-submenu">';

                $param2 = array(
                  'user_group_id'  => $user_group_id,
                  'menu_level'  => 2,
                  'menu_parent_id' => $h->menu_id,
                  'column_group'  => $column,
                  'factory_menu' => $company
                );

                $detail_menu = $this->db->get_where('zhl_gen_vw_utl_menu_access', $param2);
                foreach ($detail_menu->result() as $d) {

                  if ($d->menu_icon) {
                    echo '<li><h3><i class="fa ' . $d->menu_icon . '"></i> ' . $d->menu_title . '</h3></li>';
                  } else {
                    echo '<li><h3>' . $d->menu_title . '</h3></li>';
                  }

                  //get menu level 3
                  $param3 = array(
                    'user_group_id'  => $user_group_id,
                    'menu_level'  => 3,
                    'menu_parent_id' => $d->menu_id,
                  );
                  $this->db->order_by('menu_id');
                  $detailsub_menu = $this->db->get_where('zhl_gen_vw_utl_menu_access', $param3)->result();
                  $comp = $this->session->userdata('company_id');
                  foreach ($detailsub_menu as $ds) {
                    if ($comp==1 && $ds->menu_id==4203) {
                      $ds->menu_title = 'Sales Registrar for ZHL';
                    }else if ($comp==2 && $ds->menu_id==4203) {
                      $ds->menu_title = 'Sales Registrar for ZHT';
                    }
                    echo '<li>';
                    echo anchor(site_url($ds->menu_link), '<i class="fa fa-angle-right"></i> ' . $ds->menu_title , 'class="iconify"');
                    echo '</li>';
                  }
                }

                echo '</ul></div>';
              }

              echo '</div></div>';
              echo '</li>';
              echo '</ul>';
              echo '</li>';
            }
          }
        }

        ?>

      </ul>
    </div>

  </div>
</div>