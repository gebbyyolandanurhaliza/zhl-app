<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 11/11/2016
 * Time: 10:48 AM
 */
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";
// echo $tgl;


if ($this->input->get("dari") <> '') {
  $dari = $this->input->get("dari");
  $sampai = $this->input->get("sampai");
  $cur = $this->input->get("currency");
} else {
  $tgl2 = date_create($tgl1);
  $dari = date_format($tgl2, 't-m-Y');
  $sampai = date('t-m-Y', strtotime($dari));
  $cur = "";
}

?>

<div class="page-head">
  <div class="container-fluid">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
      <h1>Accounting Report <small>Insurance</small></h1>
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
              <span class="caption-subject theme-font">Sales Report Of Insurance</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>

          <div class="portlet-body">
            <form action="<?php echo base_url(); ?>Report_insurance/search" method="get">
              <div class="portlet-body">
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <label class="control-label col-md-3">Period</label>
                        <div class="col-md-9">
                          <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                            <input type="text" class="form-control input-sm" id="from" name="dari" value="<?php echo $dari; ?>" required>
                            <span class="input-group-addon">
                              to </span>
                            <input type="text" class="form-control input-sm" id="to" name="sampai" value="<?php echo $sampai; ?>" required>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-12 kanan">
                      <button type="submit" class="btn purple kiri"><i class="fa fa-refresh"></i> Filter</button>
                      <a href="<?php echo base_url(); ?>Report_insurance/toExcelSalesReportOFInsurance?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn green"><i class="fa fa-file-excel-o"></i> Excel</a>

                      <a href="<?php echo base_url(); ?>Report_insurance/toPrintSalesReportOFInsurance?dari=<?php echo $this->input->get('dari'); ?>&sampai=<?php echo $this->input->get('sampai'); ?>" class="btn btn-primary"><i class="fa fa-print"></i> Print</a>


                    </div>
                  </div>
                  <hr>
                  <?php
                  if (!empty($_tampil_item)) {
                  ?>
                    <section class="">
                      <div class="contain">

                        <table class="table table-bordered" id="tabel_gl">
                          <thead>
                            <tr class="header">
                              <th width="30%">
                                PRODUCT<div>PRODUCT</div>
                              </th>
                              <th sty>
                                USA AND AUSTRALIA <div> USA AND AUSTRALIA
                                  <br>CWP 1

                                </div>

                              </th>
                              <th>
                                USA AND AUSTRALIA <div> USA AND AUSTRALIA
                                  <br>CWP 2

                                </div>

                              </th>
                              <th>
                                REST OF THE WORLD <div> REST OF THE WORLD
                                  <br>CWP 1
                                </div>
                              </th>
                              <th>
                                REST OF THE WORLD <div> REST OF THE WORLD
                                  <br>CWP 2
                                </div>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $cwp1_USA = 0;
                            $cwp2_USA = 0;
                            $a_cwp1_USA = 0;
                            $a_cwp2_USA = 0;

                            foreach ($_tampil_item as $value) {
                              $cwp1_USA += $value->tmp_total_cwp1_USA_AUS;
                              $cwp2_USA += $value->tmp_total_cwp2_USA_AUS;
                              $a_cwp1_USA += $value->tmp_total_cwp1_OTHER;
                              $a_cwp2_USA += $value->tmp_total_cwp2_OTHER;

                            ?>

                              <tr onclick="detail(this)" style="cursor: pointer;">
                                <td><?php echo $value->tmp_product_category; ?></td>
                                <td align='right'><?php echo number_format(($value->tmp_total_cwp1_USA_AUS), 2, ".", ","); ?></td>
                                <td align='right'><?php echo number_format(($value->tmp_total_cwp2_USA_AUS), 2, ".", ","); ?></td>
                                <td align='right'><?php echo number_format(($value->tmp_total_cwp1_OTHER), 2, ".", ","); ?></td>
                                <td align='right'><?php echo number_format(($value->tmp_total_cwp2_OTHER), 2, ".", ","); ?></td>
                                <td style="display: none"><?php echo $value->tmp_product_category_id; ?></td>
                              </tr>
                            <?php
                            }
                            ?>

                          </tbody>
                          <tfoot>
                            <tr style="font-weight: bold;">
                              <td>TOTAL</td>
                              <td align='right'><?php echo number_format(($cwp1_USA), 2, ".", ","); ?></td>
                              <td align='right'><?php echo number_format(($cwp2_USA), 2, ".", ","); ?></td>
                              <td align='right'><?php echo number_format(($a_cwp1_USA), 2, ".", ","); ?></td>
                              <td align='right'><?php echo number_format(($a_cwp2_USA), 2, ".", ","); ?></td>
                              <td style="display: none"></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </section>
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

<script type="text/javascript">
  function detail(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }
    $r = x.rowIndex;
    var id = getText(document.getElementById('tabel_gl').rows[$r].cells[5]);
    var dari = document.getElementById("from").value;
    var sampai = document.getElementById("to").value;

    window.open("<?php echo base_url(); ?>Report_insurance/detail_transaction?id=" + id + "&dari=" + dari + "&sampai=" + sampai);
  }
</script>