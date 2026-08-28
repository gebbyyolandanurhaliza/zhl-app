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

                    <table class="table-bordered table-striped table-condensed table-hover" id="tblbarge">
                        <thead>
                            <tr>
                                <th>Form To</th>
                                <th>Container Name</th>
                                <th>Container Type</th>
                                <th>Description</th>
                                <th>Unit Price</th>
                                <th>Freight Per M.T.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($datas) {
                                foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= $data->destination_name ?></td>
                                        <td><?= $data->container_name ?></td>
                                        <td><?= $data->con_type_name ?></td>
                                        <td><?= $data->description ?></td>
                                        <td><?= $data->unit_price ?></td>
                                        <td><?= $data->freight_per_mt ?></td>
                                        <td>
                                            <a href="<?= site_url('Master_barge_freight/edit/' . $data->barge_freight_id) ?>" class="btn btn-xs btn-warning"><span class="fa fa-fw fa-pencil-square-o"></span></a>
                                            <a href="<?= site_url('Master_barge_freight/delete/' . $data->barge_freight_id) ?>" class="btn btn-xs btn-danger" onclick="return confirm('are you sure to delete this Row ?')"><span class="fa fa-fw fa-trash-o"></span></a>
                                        </td>
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
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tblbarge').DataTable();
    });
</script>