<?php
$style_kategoris = "class='select2me form-control' onchange='get_port()' id='buyer' ";
echo form_dropdown('buyer', $buyer, '', $style_kategoris);
echo "<input type='hidden' name='buyer' id='buyerin'  class='form-control' value=''/>";
echo "<input type='hidden' name='buyername' id='buyername'  class='form-control' value=''/>";
// echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value=''/>";
?>

<!-- <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script> -->
<script>
    $('#buyer').select2();
</script>