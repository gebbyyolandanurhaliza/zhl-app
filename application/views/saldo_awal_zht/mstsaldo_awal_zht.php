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
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>
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
            <form action="<?php echo site_url('saldo_awal_zht/saldo_save'); ?>" method="post" class="form-horizontal" role="form">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">COA Number</label>
                        <div class="col-md-3">
                          <input type="text" class="form-control input-sm" name="nocoa" required>
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode Bulan</label>
                        <div class="col-md-3">
                            <select class="form-control input-sm" name="periode_bulan" required>
                                <option value="">-- Pilih Bulan --</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode Tahun</label>
                        <div class="col-md-3">
                            <input type="number" class="form-control input-sm" name="periode_tahun" min="1900" max="2099" step="1" value="-" required>
                        </div>
                    </div>

                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Perioda Tanggal</label>
                        <div class="col-md-3">
                            <input type="date" class="form-control input-sm" name="periode_tanggal">                        
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Periode String</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="periode_string">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 label-sm">Debet</label>
                        <div class="col-md-3">
                          <input class="form-control input-sm" name="debet">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Kredit</label>
                        <div class="col-md-3 col-md-push-2">
                        <input class="form-control input-sm" name="kredit">

                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Debet SGD</label>
                        <div class="col-md-3 col-md-push-2">
                          <input class="form-control input-sm" name="debet_SGD">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Kredit SGD</label>
                        <div class="col-md-3 col-md-push-2">
                            <input class="form-control input-sm" name="kredit_SGD">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Dept Code</label>
                        <div class="col-md-3 col-md-push-2">
                          <input class="form-control input-sm" name="dept_code">
                        </div>
                      </div>
                      <div class="form-group" style="margin-bottom:1px;">
                        <label class="col-md-4 col-md-push-2 label-sm">Company</label>
                        <div class="col-md-3 col-md-push-2">
                          <input class="form-control input-sm" name="company">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-actions">
                <div class="col-md-3 col-md-push-9">
                  <button type="submit" class="col-md-3 btn btn-primary">Save</button>
                  <button type="reset" class="col-md-5 btn btn-default">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List Saldo Awal ZHT</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-md-1 label-sm">Saldo Awal</label>
                  <div class="col-md-3">
                    <input class="form-control input-sm" id="search">
                  </div>
                  <div class="col-md-5">
                    <button class="btn btn-primary btn-sm" onclick="search()">Refresh</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-scrollable" style="overflow: auto; height:400px;">
              <table id="table" class="table table-bordered table-condensed">
                <thead>
                  <tr>
                    <th class="text-center">Actions</th>
                    <th class="text-center">COA Number</th>
                    <th class="text-center">Periode Bulan</th>
                    <th class="text-center">Periode Tahun</th>
                    <th class="text-center">Periode Tanggal</th>
                    <th class="text-center">Periode String</th>
                    <th class="text-center">Debet</th>
                    <th class="text-center">Kredit</th>
                    <th class="text-center">Debet SGD</th>
                    <th class="text-center">Kredit SGD</th>
                    <th class="text-center">Dept Code</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Create By</th>
                    <th class="text-center">Create Date</th>
                    <th class="text-center">Last Update By</th>
                    <th class="text-center">Last Update Date</th>

                  </tr>

                </thead>
                
                <tbody id="tbl-mon">
                    <?php foreach ($items as $item) : ?>
                    <tr style="cursor: pointer;">
                        <td nowrap>
                        <a class="btn-sm btn-warning" href="<?php echo site_url('saldo_awal_zht/saldo_edit?nocoa=' . $item->nocoa); ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn-sm btn-danger" href="<?php echo site_url('saldo_awal_zht/saldo_delete?nocoa=' . $item->nocoa); ?>" onclick="javasciprt: return confirm('Are you sure delete Data <?php echo $item->nocoa; ?> ?')"><i class="fa fa-trash"></i></a>
                        </td>
                        <td nowrap><?php echo $item->nocoa; ?></td>
                        <td nowrap><?php echo $item->periode_bulan; ?></td>
                        <td nowrap><?php echo $item->periode_tahun; ?></td>
                        <td nowrap><?php echo $item->periode_tanggal; ?></td>
                        <td nowrap><?php echo $item->periode_string; ?></td>
                        <td nowrap><?php echo $item->debet; ?></td>
                        <td nowrap><?php echo $item->kredit; ?></td>
                        <td nowrap><?php echo $item->debet_SGD; ?></td>
                        <td nowrap><?php echo $item->kredit_SGD; ?></td>
                        <td nowrap><?php echo $item->dept_code; ?></td>
                        <td nowrap><?php echo $item->company; ?></td>
                        <td nowrap><?php echo $item->created_by; ?></td>
                        <td nowrap><?php echo $item->created_date; ?></td>
                        <td nowrap><?php echo $item->last_update_by; ?></td>
                        <td nowrap><?php echo $item->last_update_date; ?></td>
                        <!-- <td nowrap><?php echo $item->ip_address; ?></td> -->
                    </tr>
                    <?php endforeach; ?>
                </tbody>


              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  function search() {
    $search = document.getElementById('search').value;

    $.ajax({
      url: "<?php echo base_url(); ?>saldo_awal_zht/saldo_search?saldo=" + $search + "",
      success: function(response) {
        $("#tbl-mon").html(response);
      },
      dataType: "html"
    });

    return false;
  }
</script>
