<script>
    $(document).ready(function () {
        document.getElementById("pesan_error").style.display = "block";
        setTimeout(function () {
            $('#pesan_error').fadeOut(800);
        }, 7000);
        return false;
    });
</script>

<div class="note note-danger note-bordered" id="pesan_error" style="display: none">
    <p><b>OUT OF DATE</b></p>
    <p>
        Closing Date at <?php echo $this->session->userdata('closing_date'); ?>, the entire transaction can not be done if the journal date before <?php echo $this->session->userdata('closing_date'); ?>. 
        <br/> Please contact the accounting manager to change the Closing Date, or select another date from Date of Journal.
    </p>
</div>