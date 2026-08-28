<select id="voyage_no" name="voyage_no" class="form-control select2me" required>
  <option>Choose</option>
  <?php
  foreach ($voyages as $v) { ?>
    <option value="<?= $v->voyage_no ?>"><?= $v->voyage_no; ?></option>
  <?php
  }
  ?>
</select>

<script>
  $('#voyage_no').select2();
</script>