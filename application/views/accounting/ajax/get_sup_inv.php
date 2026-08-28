<?php
$style_kategoris = "class='select2me form-control' onchange='get_isi()' id='supplier' ";
echo form_dropdown('supplier', $SupplierID, '', $style_kategoris);
echo "<input type='hidden' name='supplierer' id='supp'  class='form-control' value=''/>";
echo "<input type='hidden' name='suppliername' id='suppname'  class='form-control' value=''/>";
echo "<input type='hidden' name='NoCOA' id='NoCOA'  class='form-control' value=''/>";
?>

<!-- <script src="<?php echo base_url();?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script> -->
<script>
    $('#supplier').select2();
</script>