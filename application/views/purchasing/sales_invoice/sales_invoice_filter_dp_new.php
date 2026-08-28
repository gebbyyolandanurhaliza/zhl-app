
<?php $i=0; foreach ($dp as $r){ $i++; ?>
    <tr style="cursor: pointer;">';
        <td style="width: 5px;"><input type="checkbox" name="chk_dp[]" onclick="cekdp('<?php echo $i; ?>')" id="chkdp<?php echo $i; ?>"></td>
        <td nowrap><?php echo $r->customer_company_name ;?></td>
        <td nowrap><?php echo $r->no_reff;?></td>
        <td nowrap><?php echo $r->currency_id;?></td>
        <td nowrap class="text-right"><?php echo number_format(($r->dp_total - $r->total_bayar),2,'.','') ;?></td>
        <td hidden><?php echo $r->header_id ;?></td>
    </tr>
<?php
}
?>