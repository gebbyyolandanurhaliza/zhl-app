<?php  
	$this->load->model(array('M_Sales_KGMT')); 
	$dari 		= str_replace('/', '-', $this->input->get('tanggal1'));
    $p_dari 	= date('Y-m-d', strtotime($dari));

    $sampai     = str_replace('/', '-', $this->input->get("tanggal2"));
    $p_sampai   = date('Y-m-d', strtotime($sampai));
?>
<table class="table">
	<tr>
		<th>Customer</th>
		<?php 
			if(!empty($_Product)){
				foreach ($_Product as $r) {
					?>
						<th><?=$r->product_category_name; ?></th>
					<?php
				}
			}
		?>
	</tr>
	<?php 
		if(!empty($_Customer)){
			foreach ($_Customer as $cust) {
				echo "<tr>";
				echo "<td>$cust->custcompany</td>";
					if(!empty($_Product)){
						foreach ($_Product as $r) {
							$isi = $this->M_Sales_KGMT->getList($p_dari, $p_sampai, $cust->custid, $r->product_category_id);
							if(!empty($isi)){
								echo "<td style='text-align:right'>".number_format($isi->TotalKG)."<td>";
							}
							else
							{
								echo "<td style='text-align:right'>0.00<td>";
							}
						}
					}
				echo "</tr>";
			}
		}
	?>
</table>