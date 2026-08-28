<?php

$style_currency = "class='select2me form-control' id='currency' onchange='get_currency()' required";
echo form_dropdown('Currency', $Currency, '', $style_currency);
