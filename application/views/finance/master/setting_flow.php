<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption theme-font">
              <i class="icon-calculator theme-font"></i>
              <span class="caption-subject bold uppercase"> Setting</span>
              <span class="caption-helper"> Cash Flow and Realization</span>
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
          <div class="portlet-body" id="ajaxForm">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8 table-responsive">
                  <table class="table table-striped table-hover" id="table-setting-flow">
                    <thead>
                      <tr>
                        <th colspan="4">Master Cash Flow</th>
                        <th colspan="4">Master Cash Realization</th>
                      </tr>
                      <tr>
                        <th>Code</th>
                        <th style="width: 30%;">Description</th>
                        <th>I/O</th>
                        <th>Header</th>
                        <th>Code</th>
                        <th style="width: 30%;">Description</th>
                        <th>I/O</th>
                        <th>Header</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($_selectFlowRealization1 as $row1) : ?>
                        <tr>
                          <td><?php echo $row1->cf_code; ?></td>
                          <td class="can-edit" data-id="<?php echo $row1->cf_code; ?>">
                            <?php if ($_Controller->lastLevelCF($row1->cf_key) == TRUE) : ?>
                              <a href="javascript:;" data-id="<?php echo $row1->cf_key; ?>">
                                <?php echo $row1->cf_code . ' ' . $row1->cf_name; ?>
                              </a>
                            <?php else : ?>
                              <?php echo $row1->cf_code . ' ' . $row1->cf_name; ?>
                            <?php endif; ?>
                          </td>
                          <td class="text-center"><?php echo $row1->io; ?></td>
                          <td><?php echo $row1->cf_header; ?></td>
                          <td><?php echo $row1->rlz_code; ?></td>
                          <td><?php echo $row1->rlz_num . '. ' . $row1->rlz_name; ?></td>
                          <td><?php echo $row1->rlz_io; ?></td>
                          <td><?php echo $row1->rlz_header; ?></td>
                        </tr>
                        <?php foreach ($_selectFlowRealization2 as $row2) : ?>
                          <?php if ($row2->cf_header == $row1->cf_key) : ?>
                            <tr>
                              <td><?php echo $row2->cf_code; ?></td>
                              <td>
                                <?php if ($_Controller->lastLevelCF($row2->cf_key) == TRUE) : ?>
                                  <a href="javascript:;" data-id="<?php echo $row2->cf_key; ?>">
                                    <?php echo $row2->cf_code . ' ' . $row2->cf_name; ?>
                                  </a>
                                <?php else : ?>
                                  <?php echo $row2->cf_code . ' ' . $row2->cf_name; ?>
                                <?php endif; ?>
                              </td>
                              <td class="text-center"><?php echo $row2->io; ?></td>
                              <td><?php echo $row2->cf_header; ?></td>
                              <td><?php echo $row2->rlz_code; ?></td>
                              <td><?php echo $row2->rlz_num . '. ' . $row2->rlz_name; ?></td>
                              <td><?php echo $row2->rlz_io; ?></td>
                              <td><?php echo $row2->rlz_header; ?></td>
                            </tr>
                          <?php endif; ?>
                          <?php foreach ($_selectFlowRealization3 as $row3) : ?>
                            <?php if ($row3->cf_header == $row2->cf_key && $row2->cf_header == $row1->cf_key) : ?>
                              <tr>
                                <td><?php echo $row3->cf_code; ?></td>
                                <td>
                                  <?php if ($_Controller->lastLevelCF($row3->cf_key) == TRUE) : ?>
                                    <a href="javascript:;" data-id="<?php echo $row3->cf_key; ?>">
                                      <?php echo $row3->cf_code . ' ' . $row3->cf_name; ?>
                                    </a>
                                  <?php else : ?>
                                    <?php echo $row3->cf_code . ' ' . $row3->cf_name; ?>
                                  <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $row3->io; ?></td>
                                <td><?php echo $row3->cf_header; ?></td>
                                <td><?php echo $row3->rlz_code; ?></td>
                                <td><?php echo $row3->rlz_num . '. ' . $row3->rlz_name; ?></td>
                                <td><?php echo $row3->rlz_io; ?></td>
                                <td><?php echo $row3->rlz_header; ?></td>
                              </tr>
                            <?php endif; ?>
                            <?php foreach ($_selectFlowRealization4 as $row4) : ?>
                              <?php if ($row4->cf_header == $row3->cf_key && $row3->cf_header == $row2->cf_key && $row2->cf_header == $row1->cf_key) : ?>
                                <tr>
                                  <td><?php echo $row4->cf_code; ?></td>
                                  <td>
                                    <?php if ($_Controller->lastLevelCF($row4->cf_key) == TRUE) : ?>
                                      <a href="javascript:;" data-id="<?php echo $row4->cf_key; ?>">
                                        <?php echo $row4->cf_code . ' ' . $row4->cf_name; ?>
                                      </a>
                                    <?php else : ?>
                                      <?php echo $row4->cf_code . ' ' . $row4->cf_name; ?>
                                    <?php endif; ?>
                                  </td>
                                  <td class="text-center"><?php echo $row4->io; ?></td>
                                  <td><?php echo $row4->cf_header; ?></td>
                                  <td><?php echo $row4->rlz_code; ?></td>
                                  <td><?php echo $row4->rlz_num . '. ' . $row4->rlz_name; ?></td>
                                  <td><?php echo $row4->rlz_io; ?></td>
                                  <td><?php echo $row4->rlz_header; ?></td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endforeach; ?>
                        <?php endforeach; ?>
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
</div>

<div class="modal fade" id="modal-setting" data-width="75%" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Setting Flow Realization</h4>
      </div>
      <div class="modal-body" id="ajaxSettingFlow">
        <!-- Load data -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#table-setting-flow").dataTable();
  });
</script>

<script type="text/javascript">
  $('#table-setting-flow tbody tr td a').click(function() {
    var id = $(this).data('id');

    //        alert('djsgatd dskjhdk - '+id);

    $.ajax({
      url: "<?php echo site_url('Master_CashFlow/ajaxSettingFlow/'); ?>",
      type: "POST",
      data: "txtKey=" + id,
      datatype: "json",
      cache: false,
      success: function(msg) {
        $("#ajaxSettingFlow").html(msg);
      }
    });
    $('#modal-setting').modal('show');
  });
  $('.can-edit').dblclick(function() {
    //        alert('HEloo');
    this.setAttribute("contenteditable", "true");
  });
  $('.can-edit').blur(function() {
    this.setAttribute("contenteditable", "false");
    var id = $(this).data('id');
    //        alert('HEloo - '+id);
  });
</script>