<div class="page-content">

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">

                <?= $this->session->flashdata('message'); ?>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase"><?= $header_title ?></span>
                        </div>
                        <div class="actions">
                            <?php echo anchor(site_url('Master_barge_freight/add'), '<i class="fa fa-plus"></i> Create Freight Charges', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>

                    <div class="portlet" style="margin-bottom:60px">
                        <div class="col-md-4">
                            <select name="destination_id" id="destination_id" class="form-control select2me" required>
                                <option value="">All Destination</option>
                                <?php
                                foreach ($destination as $dest) { ?>
                                    <option value="<?= $dest->destination_id ?>"><?= $dest->destination_name . ' | ' . $dest->destination_abbr ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <select name="container_id" id="container_id" class="form-control select2me" required>
                                <option value="">All Container</option>
                                <?php
                                foreach ($container as $con) { ?>
                                    <option value="<?= $con->container_id ?>"><?= $con->container_name ?></option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <select name="con_type_id" id="con_type_id" class="form-control select2me">
                                <option value="">All Tipe</option>
                                <?php
                                foreach ($con_type as $type) { ?>
                                    <option value="<?= $type->con_type_id ?>"><?= $type->con_type_name ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button class="btn-primary btn green" onclick="filterFreight()" id="btn_search"><i class="fa fa-search"></i> Search</button>
                    </div>


                    <div class="table-scrollable" style="overflow: auto; height: 550px;">
                        <table class="table-bordered table-striped table-condensed table-hover" id="tbl_item" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Desc</th>
                                    <th>Price</th>
                                    <th>Freight Per MT</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_item_body">
                                <?php
                                if ($data_hdr) {
                                    $no = 1;
                                    foreach ($data_hdr as $hdr) {    ?>
                                        <tr>
                                            <td colspan="4" style='text-align:left;font-weight:bold;background-color:#ddd;'>
                                                <p>Destination : <?= $hdr->destination_name ?> </p>
                                                <p>Destination Type : <?= $hdr->destination_type_name ?> </p>
                                                <p>Container Name : <?= $hdr->container_name ?> </p>
                                                <p>Container Type: <?= $hdr->con_type_name ?> </p>
                                            </td>
                                        </tr>
                                        <?php
                                        $data_dtl = $this->barge_freight_model->get_dtl($hdr->barge_freight_hdr_id);
                                        if ($data_dtl) {
                                            foreach ($data_dtl as $dtl) { ?>
                                                <tr>
                                                    <td width="80">
                                                        <a class="btn-sm btn-warning" href="<?= site_url('Master_barge_freight/edit/' . $hdr->barge_freight_hdr_id) ?>"><i class="fa fa-pencil"></i></a>
                                                        <a class="btn-sm btn-danger" href="<?= site_url('Master_barge_freight/delete_dtl/' . $dtl->barge_freight_dtl_id) ?>" onclick="return confirm('Are you sure to delete this ?')"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    <td><?= $dtl->desc_nama ?></td>
                                                    <td><?= $dtl->unit_price ?></td>
                                                    <td><?= $dtl->freight_per_mt ?></td>
                                                </tr>
                                <?php
                                            }
                                        }
                                    }
                                }

                                ?>
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('#btn_search').click(function() {

    });

    // unblock when ajax activity stops 
    // $(document).ajaxStop($.unblockUI);

    function block() {
        $.blockUI({
            message: '<h4> Just a moment...</h4>'
        });
        setTimeout($.unblockUI, 1000);
    }

    function filterFreight() {
        // block();
        const dest = $('#destination_id').val();
        const cont = $('#container_id').val();
        const type = $('#con_type_id').val();

        $.ajax({
            url: "<?php echo site_url(); ?>Master_barge_freight/filter_barge_freight",
            data: {
                'dest': dest,
                'cont': cont,
                'type': type
            },
            dataType: "html",
            beforeSend: block(),
            success: function(response) {
                $('#tbl_item_body').html(response);
            },
        });
    }
</script>