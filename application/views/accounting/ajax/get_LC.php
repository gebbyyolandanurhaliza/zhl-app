<?php // RAY_temp_rraymond1130.php
//error_reporting(E_ALL);
echo "<pre>";

// SEE http://www.experts-exchange.com/OS/Linux/Q_28311139.html

$x = setlocale(LC_MONETARY, 'en_US');
var_dump($x);

$number = -1234.56;
$y = money_format('%(#10n' ,$number);
echo $y;
