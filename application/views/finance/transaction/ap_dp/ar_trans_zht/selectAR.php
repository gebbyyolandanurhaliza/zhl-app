<div class="table-responsive">
    <table id="tbl-selectAR" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>AR Number</th>
                <th>AR Date</th>
                <th>Customer Code</th>
                <th>Customer Name</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>toUSD</th>
                <th>Remark</th>
                <th>CustCOA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectAP as $row): ?>
            <tr onclick="Pilih_AR(this)">
                <td><?php echo $row->NomorAR;?></td>
                <td><?php echo $row->Tanggal;?></td>
                <td><?php echo $row->SupplierID;?></td>
                <td><?php echo $row->customer_company_name;?></td>
                <td><?php echo $row->CurrencyID;?></td>
                <td class="text-right"><?php echo number_format($row->AmountPerAR, 6);?></td>
                <td class="text-right"><?php echo number_format($row->rate_header, 6);?></td>
                <td class="text-right"><?php echo number_format($row->AmountPerAR*$row->rate_header, 6);?></td>
                <td><?php echo $row->Remarks;?></td>
                <td><?php echo $row->nocoa;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectAR").dataTable();
    });
</script>