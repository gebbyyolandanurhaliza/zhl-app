<?php
if (isset($rate)) {
?>
    <script>
        $(document).ready(function() {
            $('#btn-update').attr('disabled', false);
            $('#btn-save').attr('disabled', false);
        });
    </script>
<?php
} else {
?>
    <script>
        $(document).ready(function() {
            $('#btn-save').attr('disabled', true);
            $('#btn-update').attr('disabled', true);
        });
    </script>
    <div class="note note-danger note-bordered">
        <p>
        <h4>Rate Not Found !!!</h4>
        <h5>Please, Call Accounting Department for Entering Rates for <b><?php echo $newdate; ?></b> to <b><?php echo $date; ?></b></h5>
        </p>
    </div>
<?php
}
?>