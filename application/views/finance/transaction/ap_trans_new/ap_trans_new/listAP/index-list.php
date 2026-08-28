<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> List</span>
              <span class="caption-helper"> AP Payment</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse">
              </a>
            </div>
            <div class="actions">
              <a class="btn btn-circle btn-primary" href="<?php echo site_url('APtrans'); ?>">
                <i class="fa fa-send"></i> New Transaction</a>
              <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
              </a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="tbl-APList" class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>No. Reference</th>
                      <th>Date</th>
                      <th>Supplier</th>
                      <th>Currency</th>
                      <th>Amount</th>
                      <th>Created By</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($_selectAP as $row) : ?>
                      <tr data-id="<?php echo encode_str($row->header_id); ?>" data-noap="<?php echo encode_str($row->no_facture); ?>">
                        <td><?php echo $row->no_facture; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row->trans_date)); ?></td>
                        <td><?php echo $row->suppliercompany; ?></td>
                        <td><?php echo $row->currency_bayar; ?></td>
                        <td class="text-right"><?php echo number_format($row->amount, 2); ?></td>
                        <td><?php echo ucfirst(strtolower($row->created_by)); ?></td>
                        <td class="text-right"><?php echo date('F, d Y h:i:s A', strtotime($row->created_date)); ?></td>
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
</div>

<script>
  $(document).ready(function() {
    $('#tbl-APList').dataTable();

    $('#tbl-APList tbody tr').on('click', function() {
      var thisID = $(this).data('id');
      var noAP = $(this).data('noap');
      var thiss = $(this);
      //$(this).hasClass();
      //alert(thisID);
      if ($(this).hasClass('aktif') == true) {
        $('.addrows').remove();
        $('#tbl-APList tbody tr').removeClass('aktif');
      } else {
        $('.addrows').remove();
        $.ajax({
          url: "<?php echo site_url(); ?>APList/getDetailAPList",
          type: 'POST',
          data: {
            txtHdrID: thisID,
            txtNoAP: noAP
          },
          dataType: 'html',
          success: function(data) {
            thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                            <td colspan="5">' + data + '</td></tr>');
          }
        });
        $('#tbl-APList tbody tr').removeClass('aktif');
        $(this).addClass('aktif');
      }
    });
  });
</script>