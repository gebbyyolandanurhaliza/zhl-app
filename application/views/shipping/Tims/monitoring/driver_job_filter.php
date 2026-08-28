<table id="tblmon_po" class="table table-condensed table-striped">
  <tbody>
    <?php
    if ($record_mon) {
      foreach ($record_mon as $r) {
        $amountDetails = json_decode($r->amount_details, true);
        switch ($r->driver_type) {
          case 'local':
            $bg_class = 'danger';
            $badges  = '<span class="label label-sm label-danger">LOCAL</span>';
            $smount = '<span class="label label-sm label-success">' . $r->amount . '</span>';

            break;
          case 'prc':
            $bg_class = 'success';
            $badges  = '<span class="label label-sm label-success">PRC</span>';
            $smount = '<span class="label label-sm label-danger">' . $r->amount . '</span>';
            break;

          default:
            $bg_class = '';
            $badges  = '';
            break;
        }

        switch ($r->status) {
          case 'Waiting':
            $bg_class = 'warning';
            $status  = '<span class="label label-sm" style="background-color: #04a8e7;">Waiting</span>';
            break;
          case 'Progress':
            $bg_class = 'primary';
            $status  = '<span class="label label-sm" style="background-color: #ef950d;">Progress</span>';
            break;

          default:
            $bg_class = 'success';
            $status  = '<span class="label label-sm" style="background-color: green;">Complete</span>';
            break;
        }

        // if($r->status == "Waiting"){
        // 	$status	= '<span class="label label-sm" style="background-color: blue;">Waiting</span>';
        // }elseif($r->status == "Progress"){
        // 	$status	= '<span class="label label-sm" style="background-color: yellow;">Progress</span>';
        // }else{
        // 	$status	= '<span class="label label-sm" style="background-color: green;">Complete</span>';
        // }

        $customer_name = '';
        foreach ($customer as $c) {
          if ($c->customer_code_old == $r->client_id) {
            $customer_name = $c->customer_name;
            break;
          }
        }

        echo "<tr>";
        echo "<td style='text-align: center; '>";
        // echo "<input type='checkbox' name='chk_si[]' class='chk_si' value='$r->id_job_dtl'>";
        // if($r->status == 'Complete') {
        // 	echo "";
        // } else {
        // 	echo "<input type='checkbox' name='chk_si[]' class='chk_si' value='$r->id_job_dtl' disabled>";
        // }
        echo "<input type='checkbox' name='chk_si[]' class='chk_si' value='$r->id_job_dtl'>";
        echo "</td>";
        echo "<td class='text-center w-200'><div>" . tgl_ind($r->curr_date) . "</div></td>";
        echo "<td class='text center w-150'><div>$r->vehicle_no</div></td>";
        echo "<td class='text center w-150'><div>$r->driver_name</div></td>";
        echo "<td class='text-center w-100'><div>$smount</div></td>";
        echo "<td class='text center w-200'><div>$customer_name</div></td>";
        echo "<td class='text center w-150'><div>$r->job</div></td>";
        echo "<td class='text center w-100'><div>$r->send_to</div></td>";
        echo "<td class='text-center w-100'><div>$r->chasis</div></td>";

        echo "<td class='text-center w-100'><div>$badges</div></td>";
        echo "<td class='text-center w-100'><div>$status</div></td>";
        // ini untuk value datanya
        echo "<tr>";
        echo "<td class='row-detail' style='text-align: left; width:40px;'></td>";
        echo "<td colspan=10>";
        echo "<div class='rTable>' >";
        echo "<div class='rTableRow'>";
        echo "<div class='rTableHead' style='width:500px'>Job Detail</div>";
        echo "<div class='rTableHead w-100'>Price/Trip</div>";
        echo "<div class='rTableHead w-170'>Extra</div>";
        echo "<div class='rTableHead w-170'>Qty</div>";
        echo "<div class='rTableHead w-170'>Container</div>";

        echo "</div>";
        if ($amountDetails) {
          foreach ($amountDetails as $detail) {

            if ($r->driver_type == 'local') {
              $price = $detail['local_pertrip'];
              $extra = $detail['extra_trip'];
            } else {
              $price = $detail['prc_pertrip'];
              $extra = $detail['extra_trip'];
            }
            echo "<div class='rTableRow'>";
            if ($detail['job_price_id'] == 21) {
              echo "<div class='rTableCell' style='color: red'>{$detail['driver_wages']}</div>";
            } elseif ($detail['job_price_id'] == 29) {
              $standby_from = $detail['time_standby']['time_from'];
              $standby_to = $detail['time_standby']['time_to'];

              echo "<div class='rTableCell'>{$detail['driver_wages']} <span style='margin-left: 10px;' class='label label-sm label-success'> $standby_from - $standby_to</span></div>";
            } else {
              echo "<div class='rTableCell'>{$detail['driver_wages']}</div>";
            }
            echo "<div class='rTableCell'>$price</div>";
            echo "<div class='rTableCell'>$extra</div>";
            echo "<div class='rTableCell'>{$detail['qty']}</div>";

            $container_items = $detail['container_items'];

            $all_containers = '';
            foreach ($container_items as $item) {
              $container_value = $item['container'];
              $all_containers .= $container_value . ', ';
            }

            $all_containers = rtrim($all_containers, ', ');
            echo "<div class='rTableCell'>$all_containers</div>";

            // if($detail['job_price_id'] == 29){

            // 	$standby_from = $detail['time_standby']['time_from'];
            // 	$standby_to = $detail['time_standby']['time_to'];

            // 	echo "<div class='rTableCell label label-sm label-success'>$standby_from - $standby_to</div>";
            // }

            echo "</div>";
          }
        }
      }
    }
    ?>
  </tbody>
</table>

<script>
  $('input:checkbox').uniform();
</script>