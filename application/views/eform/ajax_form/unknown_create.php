                    <form action="<?php // echo base_url(); 
                                  ?>index.php/vcdn/save_payable_rec" method="post">
                      <div class="col-md-12">
                        <div class="portlet light">
                          <div class="portlet-title">
                            <div class="caption">
                              <span class="caption-subject theme-font">Unknown List and Create</span>
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
                                  <a type="reset" class="btn btn-primary kanan" href="<?php // echo base_url(); 
                                                                                      ?>index.php/vcdn/add_new"><i class="fa fa-plus"></i> Create New</a>
                                </div>
                              </div>
                            </div>
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
                                if (!empty($doc_id)) {
                                  foreach ($doc_id as $s) {
                                ?>
                                    <tr onclick="pilih(this)" style="cursor: pointer;">
                                      <td></td>
                                      <td><?php echo $s->po_number; ?></td>
                                      <td><?php echo $s->customer_name; ?></td>
                                      <td><?php echo $s->factory_name; ?></td>
                                    </tr>
                                <?php //
                                  }
                                }
                                ?>

                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </form>

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