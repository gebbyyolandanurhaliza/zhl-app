                    <div class="col-md-12">
                      <div class="portlet light">
                        <div class="portlet-title">
                          <div class="caption">
                            <span class="caption-subject theme-font">Certicate of Analysis List and Create</span>
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
                              if (!empty($doc_id)) {
                                foreach ($doc_id as $s) {
                              ?>
                                  <tr>
                                    <td align="center"><a class="btn-primary green" href="<?php echo base_url('eform/request_coa?ship=' . $s->ship_id . '&po=' . $s->po_hdr_id . '&custid=' . $s->customer_id . '&fac=' . $s->factory_id); ?>" target="_blank">Check Product</a></td>
                                    <td><?php echo $s->po_number; ?></td>
                                    <td><?php echo $s->customer_name; ?></td>
                                    <td><?php echo $s->factory_name; ?></td>
                                  </tr>
                              <?php
                                }
                              }
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