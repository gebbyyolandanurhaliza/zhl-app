<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.tombol_button{
			background-color: RED;
			border: none;
			color: white;
			padding: 8px 15px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 12px;
			margin: 4px 2px;
			cursor: pointer;
		}

		.tombol_button2{
			background-color: blue;
			border: none;
			color: white;
			padding: 8px 15px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 12px;
			margin: 4px 2px;
			cursor: pointer;
		}

		#customers {
		    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		    border-collapse: collapse;
		    width: 100%;
		}

		#customers td, #customers th {
		    border: 1px solid #ddd;
		    padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		#customers tr:hover {background-color: #ddd;}

		#customers th {
		    padding-top: 12px;
		    padding-bottom: 12px;
		    text-align: center;
		    background-color: #4CAF50;
		    color: white;
		}
	</style>
	<script type="text/javascript">
		function printDiv(divName) {
		    var printContents = document.getElementById(divName).innerHTML;
		    var originalContents = document.body.innerHTML;

		    document.body.innerHTML = printContents;

		    window.print();

		    document.body.innerHTML = originalContents;
		}
	</script>
</head>
<body>
	<button class="tombol_button2" onclick="printDiv('printableArea')">Print</button>
	<button class="tombol_button" onclick="self.close()">Close</button>
	<center>
		<div id="printableArea">
		<table width="90%" id="customers">
			<?php 
				if(!empty($_detail)){
					foreach ($_detail as $r) {
					?>
						<tr>
							
							<th><?=$r->product_name; ?></th>
							
						</tr>
						<tr>
							<td><span align="justify"><?=$r->Description; ?></span></td>
						</tr>
						<!-- <tr>
							<td align="center"><button class="tombol_button2" >Print</button></td>
							<td align="center"><?=$r->product_name; ?></td>
							<td align="center"><button class="tombol_button" onclick="self.close()">Close</button></td>
						</tr> -->
					<?php
					}
				}
			?>
		</table>	
		</div>
	</center>
	
</body>
</html>