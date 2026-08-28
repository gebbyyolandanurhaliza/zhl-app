<script>


    $(document).ready(function () {
        $(".txt").focus(function () {
            $(this).select();
        });
    });


    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<div class="page-content">

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-8">

                <?php echo $message; ?>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">Master Currency</span>
                        </div>
                    </div>

                    <div class="portlet-body flip-scroll">
                        <table class="table table-bordered table-striped" id="table_currency">
                            <thead>
                                <tr>
                                    <th class="center" width="50px">No</th>
                                    <th>Currency Symbol</th>
                                    <th>Rate SGD</th>
                                    <th>Rate USD</th>
                                    <th>Period</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 0;
                                foreach ($currency_data as $currency) {
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo ++$start ?></td>
                                        <td class="text-center"><?php echo $currency->currency_id ?></td>
                                        <td class="text-center"><?php echo $currency->rate_kurs ?></td>
                                        <td class="text-center"><?php echo $currency->rate_usd ?></td>
                                        <td class="text-left"><?php echo $currency->periode ?></td>
                                        <td style="text-align:center" width="100px">
                                            <?php
                                            echo anchor(site_url('Kurs/edit_kurs?id=' . $currency->detail_id), 'Edit');
                                            echo ' | ';
                                            echo anchor(site_url('Kurs/delete/' . $currency->detail_id), 'Delete', 'onclick="javasciprt: return confirm(\'Are You Sure Want To Delete Currency ' . $currency->currency_id . ' ?\')"');
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <?php //echo $message1; ?>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">Kurs</span>
                        </div>
                    </div>

                    <div class="portlet-body flip-scroll">
                        <form action="Kurs/save_kurs" method="post">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="int">Period</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control  date date-picker" data-date-format="dd/mm/yyyy" name="periode" id="periode" placeholder="Period" required />
                                
                            <hr/></div>
                            </div>
                            <table class="table table-bordered" id="table_create">
                                <thead>
                                    <tr>
                                        <th>Currency Symbol</th>
                                        <th>Rate SGD</th>
                                        <th>Rate USD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($kurs as $c) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="currency_name[]" value="<?php echo $c->currency_name ?>" class="txt" />
                                                <input type="text" name="currency_simbol[]" value="<?php echo strtoupper($c->currency_symbol) ?>" class="txt" readonly />
                                            </td>
                                            <td class="text-right">
                                                <input type="text" name="txtKurs[]" class="txt" required />
                                            </td>
                                            <td class="text-right">
                                                <input type="text" name="txtKursUSD[]" class="txt" required />
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>


                                </tbody>
                            </table>  
                            <input type="submit" value="Save" class="btn btn-primary"/>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#table_currency").dataTable();
    });
</script>