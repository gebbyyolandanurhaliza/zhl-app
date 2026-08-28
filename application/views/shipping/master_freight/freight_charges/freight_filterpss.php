<?php
$start = 0;
foreach ($freight as $xx)
{
?>
<tr>
    <td class="center" width="2%" nowrap><?php echo ++$start ?></td>
    <td width='6%'><?php echo $xx->container_name ?></td>
    <td width='6%'><?php echo $xx->port_name ?></td>
    <td width='6%'><?php echo $xx->country_name ?></td>
    <!-- <td width='6%'><?php echo $xx->trading_term_name.' ('.$xx->trading_term_remark.')' ?></td> -->
    <!-- <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_from)) ?></td> -->
    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_till)) ?></td>
    <td width='6%'><?php echo $xx->cust_rates ?></td>
    <td width='6%' hidden=""><?php echo $xx->freight_charges_id ?></td>
</tr>
<?php
}
?>