<div class="page-content">
  <div class="container">
    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font">E-Form Request for Create</span>
            </div>

          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label class="control-label col-md-3">Form Request</label>
                  <div class="col-md-8">
                    <select name="doc_id" id="doc_id" class="form-control select2me" onchange="">
                      <option></option>
                      <?php
                      foreach ($doc_id as $k) {
                      ?>
                        <option value="<?php echo $k->document_id; ?>"><?php echo $k->document_name; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <a class="btn btn-danger" onclick="filter_tipe()"><i class="fa fa-search"></i> Filter</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pl" id="pl">
        <!-- Panggil Data -->
        <div class="col-md-12">
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption">
                <span class="caption-subject theme-font">Document List and Create</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse"></a>
                <a href="javascript:;" class="reload"></a>
              </div>
            </div>
            <div class="portlet-body">
              <hr />
              <table class="table table-bordered" id="tabel">
                <thead>
                  <th>Action</th>
                  <th>PO Number</th>
                  <th>Customer Name</th>
                  <th>Factory Name</th>
                </thead>
                <tbody>
                  <?php //
                  // if (!empty($doc_id)) {
                  // foreach ($doc_id as $s) {
                  ?>
                  <tr onclick="pilih(this)" style="cursor: pointer;">
                    <td></td>
                    <td><?php // echo $s->po_number; 
                        ?></td>
                    <td><?php // echo $s->customer_name; 
                        ?></td>
                    <td><?php // echo $s->factory_name; 
                        ?></td>
                  </tr>
                  <?php //
                  // }
                  // }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <script type="text/javascript">
          $(document).ready(function() {
            $("#tabel").dataTable({
              "scrollY": 400,
              "scrollX": true
            });
          });
          $(document).ready(function() {
            $("#tabel1").dataTable({
              "scrollY": 400,
              "scrollX": true
            });
          });
        </script>
      </div>
    </div>

    <!--         <div class="row">
        <div class="col-md-12">
                    <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject theme-font">E-Form Request for View and Show</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <form action="<?php // // echo base_url(); 
                                              ?>vcdn/search" method="get">
                                    <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Form Request</label>
                                                    <div class="col-md-8">
                                                        <select name="doc_id2" class="form-control select2me" onchange="">
                                                        <option></option>
                                                        <?php
                                                        foreach ($doc_id as $k) {
                                                        ?>
                                                        <option value="<?php echo $k->document_id; ?>"><?php echo $k->document_name; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Keyword</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="keyword" class="form-control">
                                                        <a class="btn btn-danger"><i class="fa fa-search"></i> Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>

                <div class="pl2" id="pl2">
                    <!-- Panggil Data Ajax -->
  </div> -->
</div>
</div>


<script>
  function filter_tipe() {
    $tipe = document.getElementById('doc_id').value;

    console.log($tipe);
    console.log('<?php echo base_url(); ?>eform/ajax_list_create?doc_id=' + $tipe);

    $.ajax({
      url: "<?php echo base_url(); ?>eform/ajax_list_create?doc_id=" + $tipe,
      success: function(response) {
        $("#pl").html(response);
      },
      dataType: "html"
    });

  }
</script>