<?php
$period = $this->session->userdata('periode_1');

if (isset($_GET['dari'])) {
  $tgl1 = $_GET['dari'];
} else {
  $tgl1 = $period . "/01";
}

if (isset($_GET['sampai'])) {
  $tgl2 = $_GET['sampai'];
} else {
  $tgl2 = $period . "/01";
}
// echo $tgl;
// $tgl2 = date_create($tgl1);
// $tgl = date_format($tgl2, 'd-m-Y');

$coa = $this->input->get('coa');
$cur = $this->input->get('cur')
?>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Finance Report <small>Register Book</small></h1>
    </div>
    <!-- END PAGE TITLE -->
  </div>
</div>

<div class="page-contenet">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-credit-card theme-font"></i>
              <span class="caption-subject theme-font">Monitoring Register Book </span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_finace/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo date('d-m-Y', strtotime($tgl1)); ?>" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo date('d-m-Y', strtotime($tgl2)); ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="control-label col-md-3">C/B CODE</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="coa"';
                        echo form_dropdown('coa', $_coacash, $coa, $style_kategori);
                        ?>
                      </div>
                    </div>
                    <div class="form-group col-md-4 display-none">
                      <label class="control-label col-md-3">Currency</label>
                      <div class="col-md-9">
                        <?php
                        $style_kategori = 'class="select2me form-control" id="cur"';
                        echo form_dropdown('cur', $_CurrencyID, $cur, $style_kategori);
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Excel/toExcelMonRegBook?coa=<?php echo $coa; ?>&dari=<?php echo $tgl1; ?>&sampai=<?php echo $tgl2; ?>" class="btn green enabled"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <a href="<?php echo base_url(); ?>Monitoring_finace/toPrintRegisterBook?coa=<?php echo $coa; ?>&dari=<?php echo $tgl1; ?>&sampai=<?php echo $tgl2; ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>


                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_tampil)) {
                  ?>
                    <table class="table" border="1px" id="tbl-monitoring-regis-book">
                      <thead>
                        <tr>
                          <th rowspan="2">Date</th>
                          <th rowspan="2">Reff No.</th>
                          <th rowspan="2">Check Number</th>
                          <th rowspan="2">Currency</th>
                          <th rowspan="2">Memo</th>
                          <th colspan="2">USD Currency Mutation</th>
                          <th colspan="2">Other Currency Mutation</th>
                          <th rowspan="2">Currency Rate</th>
                        </tr>
                        <tr>
                          <th>Debit</th>
                          <th>Credit</th>
                          <th>Debit</th>
                          <th>Credit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($_tampil as $r) { ?>
                          <?php if ($r->trans_type == 'AP') : ?>
                            <tr data-id="<?php echo encode_str($r->header_id); ?>" onclick="checkAP(this);" data-noap="<?php echo encode_str($r->no_facture); ?>">
                            <?php elseif ($r->trans_type == 'AR') : ?>
                            <tr data-id="<?php echo encode_str($r->header_id); ?>" onclick="checkAR(this);" data-noap="<?php echo encode_str($r->no_facture); ?>">
                            <?php else : ?>
                            <tr> <?php endif; ?>
                            <td><?php echo date('d-m-Y', strtotime($r->date1)); ?></td>
                            <td><?php echo $r->no_facture; ?></td>
                            <td><?php echo $r->check_bank; ?></td>
                            <td><?php echo $r->currency_id; ?></td>
                            <td><?php echo $r->trans_description; ?></td>
                            <?php if ($r->currency_id == 'USD') : ?>
                              <td style="text-align:right"><?php if ($r->debit != 0) echo number_format($r->debit, 2); ?></td>
                              <td style="text-align:right"><?php if ($r->credit != 0) echo number_format($r->credit, 2); ?></td>
                              <td> </td>
                              <td> </td>
                            <?php else : ?>
                              <td> </td>
                              <td> </td>
                              <td style="text-align:right"><?php if ($r->debit != 0) echo number_format($r->debit, 2); ?></td>
                              <td style="text-align:right"><?php if ($r->credit != 0) echo number_format($r->credit, 2); ?></td>
                            <?php endif; ?>
                            <td><?php echo number_format($r->currency_rate, 2, '.', ','); ?></td>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>

                  <?php
                  }

                  ?>


                </div>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-monitoring-regis-book').dataTable({
      "pageLength": 50,
      "lengthMenu": ["All", 3, 5, 10, 25, 50, 100]
    });

    /*$('#tbl-monitoring-regis-book tbody tr').on('click', function (){
        var thisID  = $(this).data('id');
        var noAP    = $(this).data('noap');
        var thiss   = $(this);
        //$(this).hasClass();
        //alert(thisID);
        if($(this).hasClass('aktif') == true){
            $('.addrows').remove();
            $('#tbl-monitoring-regis-book tbody tr').removeClass('aktif');
        }else{
            $('.addrows').remove();
            $.ajax({
                url: "<?php //echo site_url();
                      ?>APList/getDetailAPList",
                type: 'POST',
                data: {
                    txtHdrID : thisID,
                    txtNoAP : noAP
                },
                dataType: 'html',
                success: function (data) {
                    thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                        <td colspan="5">'+data+'</td></tr>');
                }
            });
            $('#tbl-APList tbody tr').removeClass('aktif');
            $(this).addClass('aktif');
        }
    });*/
  });

  function checkAP(x) {
    var tthis = x;
    var thisID = $(tthis).data('id');
    var noAP = $(tthis).data('noap');
    var thiss = $(tthis);
    //$(this).hasClass();
    //alert(thisID);
    if ($(tthis).hasClass('aktif') == true) {
      $('.addrows').remove();
      $('#tbl-monitoring-regis-book tbody tr').removeClass('aktif');
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
                        <td colspan="7">' + data + '</td></tr>');
        }
      });
      $('#tbl-APList tbody tr').removeClass('aktif');
      $(tthis).addClass('aktif');
    }
  }

  function checkAR(x) {
    var tthis = x;
    var thisID = $(tthis).data('id');
    var noAP = $(tthis).data('noap');
    var thiss = $(tthis);
    //$(this).hasClass();
    //alert(thisID);
    if ($(tthis).hasClass('aktif') == true) {
      $('.addrows').remove();
      $('#tbl-monitoring-regis-book tbody tr').removeClass('aktif');
    } else {
      $('.addrows').remove();
      $.ajax({
        url: "<?php echo site_url(); ?>ARList/getDetailARList",
        type: 'POST',
        data: {
          txtHdrID: thisID,
          txtNoAP: noAP
        },
        dataType: 'html',
        success: function(data) {
          thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                        <td colspan="7">' + data + '</td></tr>');
        }
      });
      $('#tbl-APList tbody tr').removeClass('aktif');
      $(tthis).addClass('aktif');
    }
  }
</script>