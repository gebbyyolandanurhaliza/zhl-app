<style>
  #tbl-rpt-cashbank {
    white-space: nowrap;
  }
</style>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> Report</span>
              <span class="caption-helper">Cash Bank Journal</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse">
              </a>
            </div>
            <div class="actions">
              <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
              </a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="tbl-rpt-cashbank" class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Reff. Number</th>
                      <th>Date</th>
                      <th>Code</th>
                      <th>From/To</th>
                      <th>Description</th>
                      <th>Currency</th>
                      <th>Rate</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($_selectHeaderCashBank as $row) : ?>
                      <tr data-id="<?php echo $row->header_id; ?>" class="iniThis">
                        <!--<tr data-id="<?php //echo $row->header_id;
                                          ?>" onclick="selectViewDetailCB(this);" class="iniThis">-->
                        <td class="text-uppercase"><?php echo $row->no_reff; ?></td>
                        <td class="text-right"><?php echo date('F, d Y', strtotime($row->date1)); ?></td>
                        <td><?php echo $row->cashbank_code; ?></td>
                        <td><?php echo $row->from_to; ?></td>
                        <td><?php echo $row->trans_description; ?></td>
                        <td class="text-center"><?php echo $row->currency_id; ?></td>
                        <td class="text-right"><?php echo number_format($row->currency_rate, 2); ?></td>
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

<!-- Select MCOA -->
<div class="modal fade" id="modal-MCOA" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select Master COA</h4>
      </div>
      <div class="modal-body">
        <div id="contentMasterCOA" class="table-responsive"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // $('#tbl-rpt-cashbank').dataTable();

    /*$('#tbl-rpt-cashbank_length').removeClass();
        $('#tbl-rpt-cashbank_length label').remove();
        $('#tbl-rpt-cashbank_length').html('<form role="form"><div class="col-sm-12"><div class="form-group">&nbsp;</div></div> <div class="col-sm-12"><div class="form-group">&nbsp;</div></div> <div class="col-sm-12"><div class="form-group">&nbsp;</div></div> <div class="col-sm-12"><label> <select name="tbl-rpt-cashbank_length" aria-controls="tbl-rpt-cashbank" class="form-control input-xsmall input-inline input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records </label></div></form>');
        
        $('#tbl-rpt-cashbank_filter').removeClass();
        $('#tbl-rpt-cashbank_filter label').remove();
        $('#tbl-rpt-cashbank_filter').html('<form method="POST" action="<?php //echo site_url('Finance_Report/CashBankJournal/S?');
                                                                        ?>" role="form"> <div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="" class="input-sm form-control" placeholder="Reff. Number"/> </div></div><div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="" class="input-sm form-control" placeholder="From Date : yyyy/mm/dd"/> </div></div><div class="col-sm-2"> <div class="form-group"> <button class="btn btn-sm yellow btn-block" type="submit">Search <i class="fa fa-search"></i></button> </div></div><div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="" class="input-sm form-control" placeholder="I/O"/> </div></div><div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="" class="input-sm form-control" placeholder="To Date : yyyy/mm/dd"/> </div></div><div class="col-sm-2"> <div class="form-group"> <button id="btnCariRefresh" class="btn btn-sm blue btn-block" type="button">Refresh <i class="fa fa-refresh"></i></button> </div></div><div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="txtInputCariCOA" class="input-sm form-control" placeholder="Cash/ Bank Code"/> </div></div><div class="col-sm-5"> <div class="form-group"> \n\
<input name="txtKeyword[]" id="txtInputCariCOAdes" class="input-sm form-control" placeholder="Account Name" readonly/> </div></div></form>');*/

    /*$('#tbl-rpt-cashbank tbody tr').on('click', function (){
        var thisID  = $(this).data('id');
        var thiss   = $(this);
        //$(this).hasClass();
        //alert(thisID);
        if($(this).hasClass('aktif') == true){
            $('.addrows').remove();
            $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
        }else{
            $('.addrows').remove();
            $.ajax({
                url: "<?php //echo site_url();
                      ?>Finance_Report/getCashBankJournalByHeaderID",
                type: 'POST',
                data: {
                    txtHdrID : thisID
                },
                dataType: 'html',
                success: function (data) {
                    thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                        <td colspan="5">'+data+'</td></tr>');
                }
            });
            $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
            $(this).addClass('aktif');
        }
    });*/

    /*$('#btnCariRefresh').on('click', function (){
        window.location = '<?php //echo site_url('Finance_Report/CashBankJournal');
                            ?>';
    });
    
    $("#txtInputCariCOA").click(function() {
        $.ajax({
            url:"<?php //echo site_url('Finance_Report/selectCOA');
                  ?>",
            type:"POST",
            datatype:"json",
            cache:false,
            success:function(respon){
                $('#contentMasterCOA').html(respon);
            }
        });
        $('#modal-MCOA').modal('show');
    });*/

    $(".iniThis").each(function() {
      var thisX = this;
      var thisID = $(thisX).data('id');
      var thiss = $(thisX);
      //$(this).hasClass();
      //alert(thisID);
      if ($(thisX).hasClass('aktif') == true) {
        $('.addrows').remove();
        $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
      } else {
        $('.addrows').remove();
        $.ajax({
          url: "<?php echo site_url(); ?>Finance_Report/getCashBankJournalByHeaderID",
          type: 'POST',
          data: {
            txtHdrID: thisID
          },
          dataType: 'html',
          success: function(data) {
            thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                            <td colspan="5">' + data + '</td></tr>');
          }
        });
        $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
        $(thisX).addClass('aktif');
      }
    });
  });

  function Pilih_MCOA(x) {
    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;

    //== Set value header COA
    $('#txtInputCariCOA').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[0]));
    $('#txtInputCariCOAdes').val(getText(document.getElementById('tbl-MasterCOA').rows[$r].cells[1]));


    $('#modal-MCOA').modal('hide');
  }

  function selectViewDetailCB(x) {
    var thisX = x;
    var thisID = $(thisX).data('id');
    var thiss = $(thisX);
    //$(this).hasClass();
    //alert(thisID);
    if ($(thisX).hasClass('aktif') == true) {
      $('.addrows').remove();
      $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
    } else {
      $('.addrows').remove();
      $.ajax({
        url: "<?php echo site_url(); ?>Finance_Report/getCashBankJournalByHeaderID",
        type: 'POST',
        data: {
          txtHdrID: thisID
        },
        dataType: 'html',
        success: function(data) {
          thiss.after('<tr class="addrows"><td class="text-right" colspan="2"><em>Detail Description</em></td>\n\
                        <td colspan="5">' + data + '</td></tr>');
        }
      });
      $('#tbl-rpt-cashbank tbody tr').removeClass('aktif');
      $(thisX).addClass('aktif');
    }
  }
</script>