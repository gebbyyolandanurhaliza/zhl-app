<label class="col-md-2 control-label" for="varchar">Country </label>
<div class="col-md-3">
    <?php
    $extra_country      = 'id="country_id" class="form-control select2me" ';
    $option_country[''] = '';
    foreach($cbo_country as $r):
        $option_country[$r->country_id] = $r->country_name;
    endforeach;
    echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
    ?>
</div>

<script>
    $('#country_id').select2();
</script>
