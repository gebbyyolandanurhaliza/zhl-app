<?php
IF(!empty($account_number_select)){
	foreach ($account_number_select as $value) {
    echo "<input type='text'  id='txtAccountName1' name='txtAccountName[]' class='txt' value='$value->AccountName'  />";
}
}

