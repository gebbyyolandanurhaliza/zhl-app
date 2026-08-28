<a class="btn btn-primary" data-toggle="modal" href="#deposit" id="tombol_dp"><i class="fa fa-money"></i> Select Deposit</a>
<hr />
<table class="datatable table table-bordered table-hover" id="datatable2">
    <thead>
        <tr>
            <th></th>
            <th>Number of COA</th>
            <th>Category Report</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //get_coa_list
        if (!empty($get_id_coa)) {
            foreach ($get_id_coa as $v) {
                echo "<tr style='cursor:pointer'>";
                echo "<td><input type='checkbox' name='chk[]' value='$v->no_coa'></td>";
                echo "<td>$v->no_coa</td>"
                . "<td>$v->AccountName</td>"
                . "</tr>";
            }
        }
        ?>
    </tbody>
</table>

<script>
    $("#search_dtl").keyup(function () {
        _this = this;
        $.each($("#tabel_gl tbody tr"), function () {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
</script>
<div class="modal fade" id="deposit" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Account Number</h4>
                <input class="form-control" type="text" id="search_dtl" placeholder="search">
<input type="hidden" name="id_kategori" value="<?php echo "$id_kategori"; ?>" />
<input type="hidden" name="id_group" value="<?php echo "$id_group"; ?>" />
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>Profit_and_lost/simpan_coa" method="post" >
					<input type="hidden" name="id_kategori" value="<?php echo "$id_kategori"; ?>" />
					<input type="hidden" name="id_group" value="<?php echo "$id_group"; ?>" />
                    <button type="submit" name="btn" class="btn btn-danger"><i class="fa fa-save"></i> Save Account For Report</button>

                    <hr />
                    <section class="">
                        <div class="contain">
                            <table class="datatable table table-bordered table-hover" id="tabel_gl">
                                <thead>
                                    <tr class="header">
                                        <th><div></div></th>
                                        <th>No. COA<div>No. COA</div></th>
                                        <th>Account Name<div>Account Name</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //get_coa_list
                                    if (!empty($get_coa_list)) {
                                        foreach ($get_coa_list as $v) {
                                            echo "<tr style='cursor:pointer'>";
                                            echo "<td><input type='checkbox' name='chk[]' value='$v->NoCOA'></td>";
                                            echo "<td>$v->NoCOA</td>"
                                            . "<td>$v->AccountName</td>"
                                            . "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </section>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#datatable2").dataTable({
            "scrollY": 350,
            "scrollX": true});
    });

    $(document).ready(function () {
        $('#datatable2 tr').click(function (event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });
    });


</script>


