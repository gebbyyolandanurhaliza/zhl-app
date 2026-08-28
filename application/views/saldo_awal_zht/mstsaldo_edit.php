

<script type="text/javascript">
  $(document).ready(function() {


    $('#tbl-mon tr').each(function(a, b) {
      $(b).click(function() {
        $('#tbl-mon tr').css('color', '#000000');
        $(this).css('color', '#0000FF');
      });
    });
  });
</script>
    
    <div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-cogs theme-font"></i>
              <span class="caption-subject theme-font bold">Master Saldo Awal ZHT</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body form">
            <form action="<?php echo site_url('Saldo_awal_zht/saldo_save_update'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">COA Number</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="nocoa" value="<?php echo $nocoa; ?>" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode Bulan</label>
                        <div class="col-md-3">
                        <select class="form-control input-sm" name="periode_bulan" required>
                            <option value="">-- Pilih Bulan --</option>
                            <?php 
                            $bulan_options = [
                                "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
                                "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
                                "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
                            ];
                            foreach ($bulan_options as $key => $value) {
                                $selected = ($key == set_value('periode_bulan', $periode_bulan)) ? "selected" : "";
                                echo "<option value='$key' $selected>$value</option>";
                            }
                            ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode Tahun</label>
                        <div class="col-md-3">
                            <input type="number" class="form-control input-sm" name="periode_tahun" min="1900" max="2099" step="1" 
                        value="<?php echo set_value('periode_tahun', $periode_tahun); ?>" required>
                        </div>
                    </div>

                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Perioda Tanggal</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control input-sm" name="periode_tanggal" 
                        value="<?php echo set_value('periode_tanggal', $periode_tanggal); ?>">                     
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode String</label>
                        <div class="col-md-3">
                        <input class="form-control input-sm" name="periode_string" 
                        value="<?php echo set_value('periode_string', $periode_string); ?>">                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Debet</label>
                        <div class="col-md-3">
                        <input class="form-control input-sm" name="debet" 
                        value="<?php echo set_value('debet', $debet); ?>">                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Kredit</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="kredit" 
                        value="<?php echo set_value('kredit', $kredit); ?>">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Debet SGD</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="debet_SGD" 
                        value="<?php echo set_value('debet_SGD', $debet_SGD); ?>">                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Kredit SGD</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="kredit_SGD" 
                        value="<?php echo set_value('kredit_SGD', $kredit_SGD); ?>">                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Dept Code</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="dept_code" 
                        value="<?php echo set_value('dept_code', $dept_code); ?>">                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Company</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="company" 
                        value="<?php echo set_value('company', $company); ?>">                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-5 btn btn-primary">Update</button>
                  <a type="button" class="col-md-5 btn btn-default" href="<?php echo site_url('Saldo_awal_zht/saldo_edit'); ?>">Cancel</a>
                </div>
              </div>
            </form>
          </div>
          <script type="text/javascript">
            $(document).ready(function() {
                $('form').on('submit', function(e) {
                e.preventDefault();  // Mencegah pengiriman form default
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                    // Cek apakah update berhasil dan tampilkan pesan atau lakukan pengalihan
                    alert('Update berhasil!');
                    // Jika ingin tetap di halaman edit setelah sukses
                    window.location.href = '<?php echo site_url('Saldo_awal_zht/saldo_edit'); ?>';
                    },
                    error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
                });
            });
            </script>

        </div>
      </div>
    </div>
  </div>
</div>