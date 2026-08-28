<?php
if (isset($hdr)) {
    $destination_id        = $hdr->destination_id;
    $container_id          = $hdr->container_id;
    $con_type_id           = $hdr->con_type_id;
    $destination_type_id   = $hdr->destination_type_id;
    $destination_type_name = $hdr->destination_type_name;
} else {
    $destination_id = '';
    $container_id = '';
    $con_type_id = '';
    $destination_type_id = '';
    $destination_type_name = '';
}

?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs theme-font"></i>
                            <span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
                        </div>

                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                        </div>
                        <div class="actions">
                            <?php echo anchor(site_url('Master_barge_freight'), '<i class="fa fa-list"></i> List Freight Charges', 'class="btn btn-warning"'); ?>
                        </div>
                    </div>

                    <?php echo $this->session->flashdata('message'); ?>

                    <div class="portlet-body form" id="save_as_new">
                        <form action="<?php echo $action; ?>" method="post" class="form-horizontal" role="form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-md-1 control-label" for="varchar">Form-To</label>
                                                    <div class="col-md-4">
                                                        <select name="destination_id" id="destination_id" class="form-control select2me" required>
                                                            <option value="">Choose</option>
                                                            <?php
                                                            foreach ($destination as $dest) { ?>
                                                                <option value="<?= $dest->destination_id ?>" <?= $destination_id == $dest->destination_id ? 'selected' : '' ?>><?= $dest->destination_name ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-1 control-label" for="destination_type_name">Destination Type</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="destination_type_name" id="destination_type_name" value="<?= $destination_type_name ?>" readonly required>
                                                        <input type="hidden" class="form-control" name="destination_type_id" id="destination_type_id" value="<?= $destination_type_id ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-1 control-label" for="varchar">Container Name </label>
                                                    <div class="col-md-4">
                                                        <select name="container_id" id="container_id" class="form-control select2me" required>
                                                            <option value="">Choose</option>
                                                            <?php
                                                            foreach ($container as $con) { ?>
                                                                <option value="<?= $con->container_id ?>" <?= $container_id == $con->container_id ? 'selected' : '' ?>><?= $con->container_name ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-1 control-label" for="varchar">Container Type </label>
                                                    <div class="col-md-4">
                                                        <select name="con_type_id" id="con_type_id" class="form-control select2me">
                                                            <option value="">Choose</option>
                                                            <?php
                                                            foreach ($con_type as $type) { ?>
                                                                <option value="<?= $type->con_type_id ?>" <?= $con_type_id == $type->con_type_id ? 'selected' : '' ?>><?= $type->con_type_name ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table-bordered table-striped table-condensed table-hover" width="100%" id="table_detail">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center">
                                                <a class="btn green" data-toggle="modal" id="AddDesc" href="#modalAddDesc" title="Search Shipping Liner"><i class="fa fa-plus"></i></a>
                                            </th>
                                            <th style="text-align:center">Description </th>
                                            <th style="text-align:center">Unit Price </th>
                                            <th style="text-align:center">Freight Per MT </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($data_dtl)) {
                                            foreach ($data_dtl as $dtl) { ?>
                                                <tr>
                                                    <td style="text-align: center; ">
                                                        <button type="button" class="btn default btn-xs red-stripe fontawesome-font remove_detail_add" data-id="<?= $dtl->barge_freight_dtl_id ?>" style="margin: 1px; width: 95%;">Remove</button>
                                                        <input name="barge_freight_dtl_id[]" value="<?= $dtl->barge_freight_dtl_id ?>" type="hidden" class="form-control brand-text input-xs input-table">
                                                    </td>
                                                    <td class="bg-editable">
                                                        <input name="desc_nama[]" value="<?= $dtl->desc_nama ?>" type="text" class="form-control brand-text input-xs input-table readonly">
                                                        <input name="desc_list_id[]" value="<?= $dtl->desc_list_id ?>" type="hidden" class="form-control brand-text input-xs input-table">
                                                    </td>
                                                    <td class="bg-editable">
                                                        <input name="unit_price[]" value="<?= $dtl->unit_price ?>" type="text" class="form-control autonum text-right" autocomplete="off" required>
                                                    </td>
                                                    <td class="bg-editable">
                                                        <input name="freight_per_mt[]" value="<?= $dtl->freight_per_mt ?>" type="text" class="form-control autonum text-right" autocomplete="off">
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn green w-100" name="btn_submit" value="<?= $btn_value ?>"><i class="fa fa-save"></i> <?= $btn_name ?></button>
                                        <a href="<?php echo site_url('Master_barge_freight') ?>" class="btn red w-100"><i class="fa fa-close"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="modalAddDesc" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Description</h4>
                <input class="form-control" type="text" id="search" placeholder="search">
            </div>
            <div class="modal-body">
                <section class="">
                    <div class="contain">
                        <table cellspacing="0" cellpadding="0" border="0" id="tbl_coa" width="100%">
                            <thead>
                                <tr class="header">
                                    <th>id<div>id</div>
                                    <th>Description Name<div>Description Name</div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($list_desc)) {
                                    foreach ($list_desc as $list) { ?>
                                        <tr onclick="ambilnew(this)" style="cursor: pointer;">
                                            <td><?php echo $list->desc_list_id; ?></td>
                                            <td><?php echo $list->desc_nama; ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script type="text/javascript">
    $('.autonum').autoNumeric('init', {
        mDec: 0
    });

    $('#destination_id').change(function(e) {
        var fromTo = $(this).val();

        if (fromTo == '1' || fromTo == '2') {
            $('#destination_type_name').val('INWARD');
            $('#destination_type_id').val('2');
        } else {
            $('#destination_type_name').val('OUTWARD');
            $('#destination_type_id').val('1');
        }

    });

    $("#search").keyup(function() {
        _this = this;
        $.each($("#tbl_coa tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });

    });

    function getText(el) {
        if (typeof el.textContent === 'string')
            return el.textContent;
        if (typeof el.innerText === 'string')
            return el.innerText;
    }

    function ambilnew(x) {
        $r = x.rowIndex;
        var num = 1;
        var id = getText(document.getElementById('tbl_coa').rows[$r].cells[0]);
        var desc = getText(document.getElementById('tbl_coa').rows[$r].cells[1]);
        var shipping_editable = "bg-editable";
        var html = '';
        for (var i = 0; i < num; i++) {

            html += `<tr>
                       <td style="text-align: center; ">
                          <button type="button" class="btn default btn-xs red-stripe fontawesome-font remove_detail_add" data-id="0" style="margin: 1px; width: 95%;" >Remove</button>
                        </td>
                        <td class="bg-editable">
                              <input name="desc_nama[]"  value="${desc}" type="text" class="form-control brand-text input-xs input-table readonly">
                              <input name="desc_list_id[]"  value="${id}" type="hidden" class="form-control brand-text input-xs input-table">
                        </td>
                        <td class="bg-editable">
                             <input name="unit_price[]"  value="" type="text" class="form-control autonum text-right" autocomplete="off" required>
                       </td>
                       <td class="bg-editable">
                          <input name="freight_per_mt[]"  value="" type="text" class="form-control autonum text-right" autocomplete="off">
                       </td>
                    </tr>`;
        }

        $('table[id="table_detail"]').append(html);

        $('.autonum').autoNumeric('init', {
            mDec: 0
        });

        $('#modalAddDesc').modal('hide');

        $('#table_detail .remove_detail_add').on('click', function() {
            var tr = $(this).closest('tr');
            var id = $(this).data('id');

            bootbox.confirm('Are you sure want to remove this shipping liner?', function(result) {
                if (result) {
                    if (id !== '0') {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('Master_barge_freight/remove') ?>",
                            data: {
                                id: id
                            },
                            success: function() {
                                $.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove shipping liner Success.', {
                                    type: 'success', // (null, 'info', 'danger', 'success', 'warning')
                                    offset: {
                                        from: 'top',
                                        amount: 250
                                    }, // 'top', or 'bottom'
                                    align: 'center', // ('left', 'right', or 'center')
                                    width: 'auto', // (integer, or 'auto')
                                    delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                                    allow_dismiss: true, // If true then will display a cross to close the popup.
                                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                                });
                            }
                        });
                    }

                    tr.fadeOut(400, function() {
                        tr.remove();
                    });
                }

            });
        });
    }

    $('#table_detail .remove_detail_add').on('click', function() {
        var tr = $(this).closest('tr');
        var id = $(this).data('id');
        bootbox.confirm('Are you sure want to remove this shipping liner?', function(result) {
            if (result) {
                if (id !== '0') {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('Master_barge_freight/remove') ?>",
                        data: {
                            id: id
                        },
                        success: function() {
                            $.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove shipping liner Success.', {
                                type: 'success', // (null, 'info', 'danger', 'success', 'warning')
                                offset: {
                                    from: 'top',
                                    amount: 250
                                }, // 'top', or 'bottom'
                                align: 'center', // ('left', 'right', or 'center')
                                width: 'auto', // (integer, or 'auto')
                                delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                                allow_dismiss: true, // If true then will display a cross to close the popup.
                                stackup_spacing: 10 // spacing between consecutively stacked growls.
                            });
                        }
                    });
                }

                tr.fadeOut(400, function() {
                    tr.remove();
                });
            }

        });
    });
</script>