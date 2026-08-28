<table id="tbl-MasterCOA" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>COA Number</th>
            <th>Account Name</th>
            <th>COA Group</th>
            <th style="display: none;">Reg Number</th>
            <th style="display: none;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_getMasterCOA as $row): ?>
        <tr ondblclick="addRow(this)">
            <td class="text-center"><?php echo $row->NoCOA;?></td>
            <td><?php echo $row->AccountName;?></td>
            <td class="text-center"><?php echo $row->GroupCOA;?></td>
            <td class="text-center" style="display: none;"><?php //echo $row->RegNo;?></td>
            <td class="text-center" style="display: none;"><?php echo $_getNoReff;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>