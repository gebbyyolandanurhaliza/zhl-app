<?php
$style_kategoriser = "class='select2me form-control' id='tanggal_shipment' onchange='getsup();' ";
echo form_dropdown('tgl_shipment', $_tgl, '', $style_kategoriser);
?>
<script>
  $('#tanggal_shipment').select2();
</script>