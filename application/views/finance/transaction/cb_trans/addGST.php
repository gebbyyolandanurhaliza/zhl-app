<select name="txtGST[]" class="txt gst-name" onchange="checkGST()">
    <option value=""> -- Select --</option>
    <?php foreach ($_selectGST as $gst): ?>
        <option value="<?php echo $gst->gst_id; ?>"> <?php echo $gst->gst_name; ?></option>
    <?php endforeach; ?>
</select>