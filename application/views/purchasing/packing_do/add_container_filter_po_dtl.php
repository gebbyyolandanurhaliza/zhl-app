<?php foreach ($po as $r){
	echo '<tr>';
     	echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->vendorcontact.'</td>';
        echo '<td nowrap>'.$r->vendoraddress.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'. $r->createddate.'</td>';
        echo '<td nowrap>'. $r->lastupdatedby.'</td>';
        echo '<td nowrap>'. $r->lastupdateddate.'</td>';
        echo '<td hidden>'. $r->telephone.'</td>';
    echo '</tr>';
}
?>
