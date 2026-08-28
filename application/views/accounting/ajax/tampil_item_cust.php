<table id="tblitem" class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Item Code</th>
      <th>Item Name</th>
      <th>Price</th>
      <th>GST Type</th>
      <th>No COA</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($item as $r) {
      echo "<tr>";
      echo "<td><input type='checkbox' name='chk[]' value='" . $r->Id . "'></td>";
      echo "<td>" . $r->Item_number . "</td>";
      echo "<td>" . $r->Item_name . "</td>";
      echo "<td>" . $r->price_item . "</td>";
      echo "<td>" . $r->gst_type . "</td>";
      echo "<td>" . $r->Income_coa."-".$r->income_dept."-002" . "</td>";
      echo "<td hidden>" . $r->Income_coa . "</td>";
      echo "<td hidden>" . $r->income_dept . "</td>";
      echo "</tr>";
      $no++;
    }
    ?>
  </tbody>
</table>