<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;
$tgl2 = date_create($tgl1);
$tgl = date_format($tgl2, 'd-m-Y');

$coa = $this->input->get('coa');
$cur = $this->input->get('cur');
if (empty($cur)) {
  $cur = 'USD';
}
?>

<script type="text/javascript">
  function changedate() {
    var tgl1 = document.getElementById('from').value;
    var al = tgl1.split('-');
    var all = al[1] + '-' + al[0] + '-' + al[2];

    // alert(all);
    var tgl2 = document.getElementById('to');
    var t = 1;
    var date = new Date(all);
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() + Number(t));

    var dd = newdate.getDate();
    if (dd < 9) {
      dd = '0' + dd;
    }
    var mm = newdate.getMonth() + 1;
    if (mm < 9) {
      mm = '0' + mm;
    }
    var y = newdate.getFullYear();

    var someFormattedDate = dd + '-' + mm + '-' + y;
    tgl2.value = someFormattedDate;

  }


  function changedate2() {
    var tgl1 = document.getElementById('to').value;
    var al = tgl1.split('-');
    var all = al[1] + '-' + al[0] + '-' + al[2];

    // alert(all);
    var tgl2 = document.getElementById('from');
    var t = 1;
    var date = new Date(all);
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() - Number(t));

    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();

    var someFormattedDate = dd + '-' + mm + '-' + y;
    tgl2.value = someFormattedDate;
  }
</script>
<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Finance Report <small>Daily Report</small></h1>
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
              <span class="caption-subject theme-font">Daily Report</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Monitoring_finace/daily_search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="control-label col-md-3">Date</label>
                      <div class="col-md-9">
                        <div class="input-group date-picker input-daterange" data-date="02-12-2012" data-date-format="dd-mm-yyyy">
                          <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo date('d-m-Y', strtotime("-1 days")); ?>" onchange="changedate()" required>
                          <span class="input-group-addon">
                            to </span>
                          <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo date('d-m-Y'); ?>" required onchange="changedate2()">
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
                    <div class="form-group col-md-4">
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
                      <a href="<?php echo base_url(); ?>Excel\toExcel1" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>
                      <button type="button" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                    </div>
                  </div>

                  <hr>
                  <?php
                  if (!empty($_begining)) {
                    $begin = $_begining->saldo_awal;
                  } else {
                    $begin = 0;
                  }

                  if (!empty($_begin)) {
                    $bein = $_begin->jumlah1;
                    // echo $_begin->cb_code;
                  } else {
                    $bein = 0;
                  }
                  $totalbegining = $begin + $bein;
                  $totalcredit = 0;
                  $totaldebit = 0;
                  ?>


                  <table class="table" border="1px">
                    <tr>
                      <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Remark</th>
                        <th>No. Reference</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Balance</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Date</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td colspan="5" align="center"><b>Begininng Balance...</b></td>
                          <td align='right'><?php echo number_format($totalbegining, 2, '.', ','); ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <?php
                        if (!empty($_tampil)) {
                          $no = 1;

                          foreach ($_tampil as $r) {
                            $totalbegining = $totalbegining + $r->jumlah;
                            $totalcredit += $r->credit;
                            $totaldebit += $r->debit;
                        ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo $r->coa_description; ?></td>
                              <td><?php echo $r->trans_description; ?></td>
                              <td><?php echo $r->no_facture; ?></td>
                              <td align='right'><?php echo number_format($r->debit, 2, '.', ','); ?></td>
                              <td align='right'><?php echo number_format($r->credit, 2, '.', ','); ?></td>
                              <td align='right'><?php echo number_format($totalbegining, 2, '.', ','); ?></td>
                              <td><?php echo $r->created_by; ?></td>
                              <td><?php echo $r->created_date; ?></td>
                              <td><?php echo $r->date1; ?></td>

                            </tr>
                        <?php
                          }
                        }
                        ?>
                        <tr>
                          <td></td>
                          <td colspan="3" align="right"><b>Total</b></td>
                          <td align='right'><?php echo number_format($totaldebit, 2, '.', ','); ?></td>
                          <td align='right'><?php echo number_format($totalcredit, 2, '.', ','); ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>

                      </tbody>
                    </tr>
                  </table>




                </div>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>