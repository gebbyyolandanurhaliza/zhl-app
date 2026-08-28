<div class="row ">
  <div class="col-md-12">
    <div class="portlet light">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-credit-card theme-font"></i>
          <span class="caption-subject theme-font">Update Rate to USD</span>
        </div>
        <div class="tools">
          <a href="javascript:;" class="collapse"></a>
          <a href="javascript:;" class="reload"></a>
        </div>
      </div>

      <div class="portlet-body">
        <form action="<?php echo site_url(); ?>KursNew/update_kurs_usd_new" method="post">
          <section class="">

            <table class="table table-bordered " id="tabel_coa" width="100%">
              <thead>
                <tr class="header">
                  <th width="6%">Currency <div>Currency</div>
                  </th>
                  <th width="6%">Period <div>Period</div>
                  </th>
                  <!-- <?php
                  $co = $_count + 2;
                  foreach ($_cur as $r) {
                    echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                  }
                  ?> -->
                  <?php
                  $allowed_currencies = ['IDR', 'MYR', 'USD', 'SGD'];  // List of allowed currencies
                  $co = $_count + 2;

                  foreach ($_cur as $r) {
                      // Check if the currency_id is in the allowed currencies list
                      if (in_array($r->currency_id, $allowed_currencies)) {
                          echo "<th width='9%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                      }
                  }
                  ?>

                </tr>
              </thead>
              <!-- <tbody>
                <tr>
                  <td width='6%'>USD</td>
                  <td><input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='<?php echo date('d-m-Y', strtotime($this->uri->segment(3))); ?>' required></td>

                  <?php
                  foreach ($_period as $l);
                  foreach ($_cur as $r) {
                    $usd = $this->M_KursNew->get_rateusd($r->currency_id, $this->uri->segment(3));

                    if (!empty($usd)) {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='$usd->rate_usd' onkeypress='return isNumber(event)'  required>
                                                    </td>";
                    } else {
                      echo "<td width='9%'> <input type='text' id='period' name='$r->currency_id' class='txt' value='0' onkeypress='return isNumber(event)' required >
                                                    </td>";
                    }
                  }
                  ?>
                </tr>
              </tbody> -->

              <tbody>
                  <tr>
                    <td width='6%'>USD</td>
                    <td>
                      <input type='text' id='period' name='period' class='txt date-picker' data-date-format='dd-mm-yyyy' value='<?php echo date('d-m-Y', strtotime($this->uri->segment(3))); ?>' required>
                    </td>

                    <?php
                    foreach ($_cur as $r) {
                        if (in_array($r->currency_id, $allowed_currencies)) {
                            $usd = $this->M_KursNew->get_rateusd($r->currency_id, $this->uri->segment(3));
                            echo "<td width='9%'>
                                    <input type='text' id='period' name='$r->currency_id' class='txt' value='" . (!empty($usd) ? $usd->rate_usd : '0') . "' onkeypress='return isNumber(event)' required>
                                  </td>";
                        }
                    }
                    ?>
                  </tr>
                </tbody>
            </table>

          </section>
          <br />
          <div class="row">
            <div class="col-md-4">
              <input type="submit" value="Save" class="btn btn-primary" />
              <a href="<?php echo site_url('KursNew/index'); ?>" class="btn btn-primary" title="Back">Back</a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>