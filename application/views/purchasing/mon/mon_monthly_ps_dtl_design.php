<?php
    if($tipe == 'sp_pur_mon_mainly_vendor' || $tipe == 'sp_pur_mon_mainly_comission_vendor'){
        $id='Vendor ID';
        $name='Vendor Name';
    } else if ($tipe == 'sp_pur_mon_mainly_customer' || $tipe == 'sp_pur_mon_mainly_comission_customer'){
        $id='Customer ID';
        $name='Customer Name';
    } else {
        $id='Category';
        $name='Sub Category';
    }
?>


<div class="table-scrollable">
    <table class="table table-bordered" id="tblmon">
        <thead>
            <tr>
                <th rowspan="2"><?php echo $id; ?></th>
                <th rowspan="2"><?php echo $name; ?></th>
                <th colspan="12">Month</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
            </tr>
        </thead>
        <tbody id="tbl-mon"></tbody>
    </table>
</div>