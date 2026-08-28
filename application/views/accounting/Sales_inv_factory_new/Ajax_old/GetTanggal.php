<?php
$style_kategoriser = "class='select2me form-control' id='tanggal_invoice' onchange='getsup();get_cur_purchase();Rate_notfound();hitungSelisihHari2()' ";
echo form_dropdown('tgl_invoice', $_tgl, '', $style_kategoriser);
?>
<script>
    // $('#tanggal_invoice').select2();
</script>