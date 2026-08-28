<section class="table-responsive" style="height: 300px">
	<table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed flip-content" id="tabel">
		<tr>
			<th rowspan="2" width="4%">Customer Name</th>
			<th colspan="2" width="6%">UHT COCONUT CREAM</th>
			<th colspan="2" width="6%">DESICCATED COCONUT</th>
			<th colspan="2" width="6%">CANNED PINEAPPLES</th>
			<th colspan="2" width="6%">PINEAPPLE JUICE CONCENTRATE</th>
			<th colspan="2" width="6%">PINEAPPLE SKIN</th>
			<th colspan="2" width="6%">COCONUT WATER CONCENTRATE</th>
			<th colspan="2" width="6%">COCONUT SHELL CHARCOAL</th>
			<th colspan="2" width="6%">CANNED COCONUT CREAM</th>
			<th colspan="2" width="6%">COCONUT MILK POWDER</th>
			<th colspan="2" width="6%">COCONUT WATER</th>
			<th colspan="2" width="6%">COCONUT OIL</th>
			<th colspan="2" width="6%">ACTIVATED CARBON</th>
			<th colspan="2" width="6%">VIRGIN COCONUT OIL</th>
			<th colspan="2" width="6%">UHT COCONUT MILK</th>
			<th colspan="2" width="6%">COCONUT MILK DRINK</th>
			<th colspan="2" width="6%">COCONUT SUGAR</th>
		</tr>
		<tr>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
			<th>KG</th>
			<th>MT</th>
		</tr>
		<?php 
			if(!empty($_list)){
				foreach ($_list as $r) {
					echo "
						<tr>
							<td>$r->custcompany</td>
							<td style='text-align:right'>".number_format($r->TKGUHT,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTUHT,2,'.',',')."</td>

							<td style='text-align:right'>".number_format($r->TKGDC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTDC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCP,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCP,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGPJC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTPJC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGPS,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTPS,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCWC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCWC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCSC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCSC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCCC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCCC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCMP,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCMP,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCW,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCW,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCO,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCO,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGAC,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTAC,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGVCO,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTVCO,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGUHTCM,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTUHTCM,2,'.',',')."</td>

							<td style='text-align:right'>".number_format($r->TKGCMD,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCMD,2,'.',',')."</td>
							
							<td style='text-align:right'>".number_format($r->TKGCS,2,'.',',')."</td>
							<td style='text-align:right'>".number_format($r->TMTCS,2,'.',',')."</td>
						<tr>
					";
				}
			}
		?>
	</table>
</section>;