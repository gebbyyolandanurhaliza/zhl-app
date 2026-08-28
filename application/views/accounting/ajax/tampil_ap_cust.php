<table id="tblap" class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Item Name</th>
      <th>Price</th>
      <th>GST Type</th>
      <th>No COA</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    foreach ($ap as $r) {
      echo "<tr>";
      echo "<td><input type='checkbox' name='chkk[]' value='" . $r->HeaderID . "'></td>";
      echo "<td>" . $r->Items . "</td>";
      echo "<td>" . $r->Harga . "</td>";
      echo "<td>" . $r->gst_type . "</td>";
      echo "<td>" . $r->NoCOA . "-" . $r->dept_code . "-002" . "</td>";
      echo "<td hidden>" . $r->Qty . "</td>";
      echo "<td hidden>" . $r->Unit . "</td>";
      echo "<td hidden>" . $r->dept_code . "</td>";
      echo "<td hidden>" . $r->NoCOA . "</td>";
      echo "</tr>";
      $no++;
    }
    ?>
  </tbody>
</table>