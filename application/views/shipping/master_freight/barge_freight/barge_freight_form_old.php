<?php
if (isset($barge_freight)) {
    $barge_freight_id = $barge_freight->barge_freight_id;
    $destination_id   = $barge_freight->destination_id;
    $container_id     = $barge_freight->container_id;
    $con_type_id      = $barge_freight->con_type_id;
    $description      = $barge_freight->description;
    $unit_price       = $barge_freight->unit_price;
    $freight_per_mt   = $barge_freight->freight_per_mt;
} else {
    $barge_freight_id = "";
    $destination_id   = "";
    $container_id     = "";
    $con_type_id      = "";
    $description      = "";
    $unit_price       = "";
    $freight_per_mt   = "";
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
                                                    <label class="col-md-2 control-label" for="varchar">Form-To</label>
                                                    <div class="col-md-8">
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
                                                    <label class="col-md-2 control-label" for="varchar">Container Name </label>
                                                    <div class="col-md-8">
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
                                                    <label class="col-md-2 control-label" for="varchar">Container Type </label>
                                                    <div class="col-md-8">
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

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Description</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="description" id="description" value="<?= $description ?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Freight Per M.T</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="freight_per_mt" id="freight_per_mt" value="<?= $freight_per_mt ?>" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label" for="varchar">Unit Price (SGD)</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control autonum" name="unit_price" id="unit_price" value="<?= $unit_price ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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


<script type="text/javascript">
    $('.autonum').autoNumeric('init', {
        mDec: 0
    });
</script>