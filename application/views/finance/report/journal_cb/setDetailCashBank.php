<table style="width: 100%; background-color: transparent; border: none;">
    <thead>
        <tr>
            <th>C.O.A</th>
            <th>C.O.A Description</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_selectDetailByHeaderID as $row): 
            if ($row->credit == '0'){
                $credit = '';
            }else{
                $credit = number_format($row->credit, 2, '.', ',');
            }

            if ($row->debit == '0'){
                $debit = '';
            }else{
                $debit = number_format($row->debit, 2, '.', ',');
            }
        ?>
        <tr>
            <td><?php echo $row->coa;?></td>
            <td><?php echo $row->coa_description;?></td>
            <td class="text-right"><?php echo $debit;?></td>
            <td class="text-right"><?php echo $credit;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>