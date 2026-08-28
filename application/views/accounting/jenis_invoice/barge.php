<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="note note-success note-bordered col-md-12">
        <p>
          This is Master Invoce OF Barge.
        </p>
      </div>
      <div class="col-md-6">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-speech theme-font"></i>
              <span class="caption-subject bold uppercase"> Barge</span>
              <span class="caption-helper">Master Of Barge ( SINGAPORE - SEIGUNTUNG )</span>
            </div>
            <div class="kanan">
              <a class="btn green" href="<?php echo base_url(); ?>Excel/toExcelCoa"><i class="fa fa-file-excel-o"></i> Export to excel</a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Barge/save_1" role="form" method="post">
            <div class="portlet-body">
              <table class='table'>
                <tr>
                  <th>Container</th>
                  <th>Exp. Date</th>
                  <th>Harga</th>
                </tr>
                <?php
                if (!empty($list_cont)) {
                  foreach ($list_cont as $r) {
                    echo
                    "<tr>
                                                <td><input type='hidden' name='id_cont[]' value='$r->container_id'><input type='text' class='form-control' name='cont_name[]' value='$r->container_name'></td>";

                    if (!empty($_listbarge1)) {
                      foreach ($_listbarge1 as $v) {
                        if ($r->container_id == $v->container_type) {
                          $tgl = date('d/m/Y', strtotime($v->expiredate));
                          echo
                          "<td><input type='text' id='exp' name='exp[]' class='form-control date date-picker' data-date-format='dd/mm/yyyy' value='$tgl' required /></td>
                                                            <td><input type='text' id='price' name='price[]' class='form-control' value='$v->Harga' required/></td>
                                                        </tr>";
                        }
                      }
                    } else {
                      echo
                      "<td><input type='text' id='exp' name='exp[]' class='form-control date date-picker' data-date-format='dd/mm/yyyy' required/></td>
                                                    <td><input type='text' id='price' name='price[]' class='form-control' value='0' required/></td>
                                                </tr>";
                    }
                  }
                }
                ?>
                <tr>
                  <td colspan='3'><input type="submit" value='SAVE' name='svt' class='btn btn-primary kanan'></td>
                </tr>
              </table>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-6">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-speech theme-font"></i>
              <span class="caption-subject bold uppercase"> Barge</span>
              <span class="caption-helper">Master Of Barge ( SEIGUNTUNG - SINGAPORE )</span>
            </div>
            <div class="kanan">
              <a class="btn green" href="<?php echo base_url(); ?>Excel/toExcelCoa"><i class="fa fa-file-excel-o"></i> Export to excel</a>
            </div>
          </div>
          <form action="<?php echo base_url(); ?>Barge/save_2" role="form" method="post">
            <div class="portlet-body">
              <table class='table'>
                <tr>
                  <th>Container</th>
                  <th>Exp. Date</th>
                  <th>Harga</th>
                </tr>
                <?php
                if (!empty($list_cont)) {
                  foreach ($list_cont as $r) {
                    echo
                    "<tr>
                                                <td><input type='hidden' name='id_cont[]' value='$r->container_id'><input type='text' class='form-control' name='cont_name[]' value='$r->container_name'></td>";

                    if (!empty($_listbarge2)) {
                      foreach ($_listbarge2 as $v) {
                        if ($r->container_id == $v->container_type) {
                          $tgl = date('d/m/Y', strtotime($v->expiredate));
                          echo
                          "<td><input type='text' id='exp' name='exp[]' class='form-control date date-picker' data-date-format='dd/mm/yyyy' value='$tgl' required /></td>
                                                            <td><input type='text' id='price' name='price[]' class='form-control' value='$v->Harga' required/></td>
                                                        </tr>";
                        }
                      }
                    } else {
                      echo
                      "<td><input type='text' id='exp' name='exp[]' class='form-control date date-picker' data-date-format='dd/mm/yyyy' required/></td>
                                                    <td><input type='text' id='price' name='price[]' class='form-control' value='0' required/></td>
                                                </tr>";
                    }
                  }
                }
                ?>
                <tr>
                  <td colspan='3'><input type="submit" value='SAVE' name='svt' class='btn btn-primary kanan'></td>
                </tr>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>

</script>