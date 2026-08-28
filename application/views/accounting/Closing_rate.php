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

    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function cari_rate() {
        var periode = document.getElementById('periode').value;
        var str = periode.split("-");
        var month = str[1];
        var d = new Date(str[0], month, 0);
        var tgl = formatDate(d);
        $.ajax({
            url: "<?php echo base_url(); ?>Closing_rate/search_rate?tgl=" + tgl,
            success: function (response) {
                $("#CurID").html(response);
            },
            dataType: "html"
        });
    }
</script>
<div class="page-content">

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-8">

                <?php echo $message; ?>
                <form action="Kurs2/save_kurs_sgd" method="post">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-table theme-font"></i>
                                        <span class="caption-subject theme-font bold">Currency of USD</span>
                                    </div>
                                </div>

                                <div class="portlet-body flip-scroll">

                                    <section class="">
                                        <div class="contain">

                                            <table class="table table-bordered " id="tabel_coa" width="100%">
                                                <thead>
                                                    <tr class="header">
                                                        <th width="10%">Period <div>Period</div></th>
                                                        <?php
                                                        $co = $_count + 2;
                                                        foreach ($_cur as $r) {
                                                            echo "<th width='10%'>" . $r->currency_id . "<div>" . $r->currency_id . "</div></th>";
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <?php
                                                // echo $_usd->rate_usd;
                                                $this->load->model('M_Closing_rate');
                                                foreach ($_period as $l) {
                                                    $tgl = date('Y-m-d', strtotime($l->tanggal));
                                                    echo "<tr>";
                                                    echo "<td width='10%'> <input type='text' id='period' name='period[]' class='txt' value='$tgl' readonly></td>";
                                                    foreach ($_cur as $r) {
                                                        $usd = $this->M_Closing_rate->get_closing_rate($r->currency_id, $l->tanggal);
                                                        if (!empty($usd)) {
                                                            echo "<td width='10%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='$usd->currency_rate'></td>";
                                                        } else {
                                                            echo "<td width='10%'> <input type='text' id='period' name='$r->currency_id[]' class='txt' value='0'></td>";
                                                        }
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>


            <div class="col-md-4">

                <?php //echo $message1; ?>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">Form Rate Revaluation</span>
                        </div>
                    </div>

                    <div class="portlet-body flip-scroll">
                        <form action="Closing_rate/save_rate" method="post">
                            <input type="text" name="periode" id="periode" class="form-control date-picker" onchange="cari_rate()" data-date-format="yyyy-mm-dd" placeholder="Period of Rate" required />
                            <div id="CurID">  
                                <table class="table table-bordered" id="table_create">
                                    <thead>
                                        <tr>
                                            <th>Currency Symbol</th>
                                            <th>Rate USD</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($get_currency)){
                                        foreach ($get_currency as $c) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="date_posting" value="<?php echo $this->session->userdata('periode_1'); ?>" class="txt" />
                                                    <input type="hidden" name="currency_name[]" value="<?php echo $c->currency_name ?>" class="txt" />
                                                    <input type="text" name="currency_simbol[]" value="<?php echo strtoupper($c->currency_id) ?>" class="txt" readonly />
                                                </td>
                                                <td class="text-right">
                                                    <input type="text" name="txtKurs[]" class="txt number" value="<?php echo number_format($c->rate_usd, 6, '.', ''); ?>" required />
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        }
                                        ?>
                                    </tbody>
                                </table>                              
                            </div>


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