<?php
$period = $this->session->userdata('periode_1');
$tgl1 = $period . "/01";

if ($this->input->post('eta') <> '') {
    $shipdate = $this->input->post('shipdate');
} else {
    $shipdate = date("d-m-Y");
}



?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <!-- <?php
                        // echo $message;
                        // echo form_open(site_url('Shipping/print_tracking_pdf'), 'target="_blank" method="post" class="form-horizontal"');
                        ?> -->


                <div class="portlet light">

                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font uppercase">Non Conformance Container</span>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                            <a href="javascript:;" class="fullscreen"></a>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <div class="form-body row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title"><i class='fa fa-filter'></i> Filter Data</h5>
                                    </div>
                                    <div class="panel-body">

                                        <div class="col-md-12 row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="varchar">Location</label>
                                                <div class="col-md-3">
                                                    <select class="form-control select2me" name="eta" data-placeholder="choose factory" id="location" data-placeholder="choose">
                                                        <option value=""></option>
                                                        <option value="PSG">PT. Pulau Sambu Guntung</option>
                                                        <option value="RSUP">PT. RIau Sakti United Plantations</option>
                                                        <option value="STI">PT. Sumtra Timur Indonesia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="varchar">Tipe</label>
                                                <div class="col-md-3">
                                                    <select class="form-control select2me" name="tipe" data-placeholder="choose factory" id="tipe" data-placeholder="choose" onclick="changeTipe()">
                                                        <option value="2">Container Inward</option>
                                                        <option value="1">Container Outward</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group row">
                                                <label class="col-md-2 label-sm">Shipment Date</label>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><input type="checkbox" id="chk1" onclick="chk1_click()"></span>
                                                        <div class="input-group date-picker input-daterange" name="shipment_date" data-date-format="dd-mm-yyyy">
                                                            <input type="text" class="form-control date-picker" name="shipment_date" id="shipdate" value="<?php echo $shipdate; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group">
                                                <div class="col-md-12 col-md-offset-2">
                                                    <button type="button" class="btn blue fontawesome-font btn-f-refresh" onclick="refresh()"><span class="fa fa-refresh"></span> Refresh</button>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>



                            <div class="flip-scroll">
                                <div class="doc-scroll" style="height: 360px;">
                                    <div class="loadReport"></div>
                                    <table id="tbl_po" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PO Number</th>
                                                <th>PO Date</th>
                                                <th>Factory</th>
                                                <th>Customer</th>
                                                <th>Total Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">

                                <button type="button" class="btn btn-primary" id="inward" onclick="shipToInwardList()"><span class=" fa fa-calendar"></span> ship to inward list</button>
                                <button type="button" class="btn btn-success" id="outward" onclick="shipToOutwardList()"><span class=" fa fa-calendar"></span> ship to outward list</button>


                            </div>
                        </div>
                    </div>

                </div>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>






<script>
    $('#tbl_po').dataTable();
</script>




<script>
    $("#shipdate").val(""); // checked
    $("#shipdate").prop("disabled", true);
    $("#inward").prop("disabled", true);
    $("#outward").prop("disabled", true);


    function chk1_click() {
        // alert("test")
        if ($("#chk1").is(':checked')) {
            // alert('true')
            $("#shipdate").val(""); // checked
            $("#shipdate").prop("disabled", false); // checked
        } else {
            // alert('false')
            $("#shipdate").prop("disabled", true); // checked

        }

    }

    function changeTipe() {
        // var tipe = $("#tipe").find(":selected").val();
        // if (tipe == 1) {
        // 	$("#location").prop("disabled", false)
        // } else if (tipe == 2) {
        // 	$("#location").prop("disabled", true)
        // }

    }

    function shipToInwardList() {
        $('#modalTitle').html('Ship To Inward List');
        $('#modalInward').modal('show');
    }

    function shipToOutwardList() {
        $('#modalTitle2').html('Ship To OutwardList');
        $('#modalOutward').modal('show');
    }

    function saveInwardList() {

        var checkedValues = [];
        var idReceived = [];
        var idLocal = [];
        $("input[name='container_number[]']:checked").each(function() {
            checkedValues.push($(this).val());
            idReceived.push($(this).data("received"));
            idLocal.push($(this).data("local"));
        });

        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true

            },
            function(isConfirm) {

                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "<?php echo site_url('Shipping/save_ship_to_inward') ?>",
                        data: {
                            tipe: 2,
                            contid: $("#contid").val(),
                            det_cont: checkedValues,
                            det_received_id: idReceived,
                            det_local_id: idLocal

                        },
                        dataType: "JSON",
                        beforeSend: function() {
                            sambu.startPageLoading()
                            $(".btn-f-refresh").prop("disabled", true)

                        },
                        success: function(response) {

                            console.log(response);

                            setTimeout(() => {
                                sambu.stopPageLoading();


                                if (response.code == 200) {
                                    $('.loadReport').html(response);
                                    $(".btn-f-refresh").prop("disabled", false)
                                    swal("Success", "Container Inward Success Created", 'success')
                                    window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + response.message + "&tipe=2";

                                } else {
                                    swal("Error", "" + response.message + "", 'error')
                                }
                            }, 2000);
                        },
                        error: function(err, errors) {
                            console.log(err);
                            console.log(errors);
                        }
                    })

                } else {
                    swal("Cancelled", "Ship To Inward List", "error");
                }
            });
    }



    function saveOutwardList() {

        var checkedValues = [];
        var idReceived = [];
        var idLocal = [];
        $("input[name='container_number[]']:checked").each(function() {
            checkedValues.push($(this).val());
            idReceived.push($(this).data("received"));
            idLocal.push($(this).data("local"));
        });

        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            function(isConfirm) {

                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "<?php echo site_url('Shipping/save_ship_to_outward') ?>",
                        data: {
                            tipe: 1,
                            contid: $("#contid2").val(),
                            det_cont: checkedValues,
                            det_received_id: idReceived,
                            det_local_id: idLocal

                        },
                        dataType: "JSON",
                        beforeSend: function() {
                            sambu.startPageLoading()
                            $(".btn-f-refresh").prop("disabled", true)

                        },
                        success: function(response) {

                            console.log(response);

                            setTimeout(() => {
                                sambu.stopPageLoading();


                                if (response.code == 200) {
                                    $('.loadReport').html(response);
                                    $(".btn-f-refresh").prop("disabled", false)
                                    swal("Success", "Container Outward Success Created", 'success')
                                    window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + response.message + "&tipe=1";

                                } else {
                                    swal("Error", "" + response.message + "", 'error')
                                }
                            }, 2000);
                        },
                        error: function(err, errors) {
                            console.log(err);
                            console.log(errors);
                        }
                    })

                } else {
                    swal("Cancelled", "Wrong Queries", "error");
                }
            });
    }

    $("#table-container-local input:checkbox.chkclass").change(function() {

        if (this.checked) {
            //Cache cloned object in a variable
            var clone = $(this).closest("tr").clone();

            //Remove checkbox
            clone.find(':checkbox').remove()
            //Append it
            clone.appendTo("#tabel-load-local");
        } else {
            var index = $(this).closest("tr").attr("data-index");
            var findRow = $("#tabel-load-local tr[data-index='" + index + "']");
            findRow.remove();
        }
    }).change();

    // contorlButton()
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });

    $(document).on("click", "#btn_print", function() {
        // alert("test")
    });

    $(".ship-inward-list").click(function() {
        var location = $("#location").find(":selected").val();
        $("#modal-create").modal("show")
        $("select [value=" + location + "]").attr("selected", "selected")

    });

    function refresh() {

        var location = $('#location').find(":selected").val();
        var tipe = $('#tipe').find(":selected").val();

        var ship_date = $("#shipdate").val();
        var cnumber = $("#containerNumber").val();

        // alert(tipe)


        $.ajax({
            type: "GET",
            url: "<?php echo site_url('Shipping/get_filter_by_ajax') ?>",
            data: {
                tipe: tipe,
                location: location,
                shipment_date: ship_date,
                // container_number: cnumber

            },
            beforeSend: function() {
                sambu.startPageLoading()
                $(".btn-f-refresh").prop("disabled", true)

            },
            success: function(msg) {
                $(".btn-f-refresh").prop("disabled", false)

                setTimeout(() => {
                    sambu.stopPageLoading();
                    $('.loadReport').html(msg);
                    contorlButton()
                }, 2000);
            }
        })
    }

    function save() {

        var data = $(".ship-to-inward").serialize()

        var checkedValues = [];
        var idReceived = [];
        $("input[name='container_number[]']:checked").each(function() {
            checkedValues.push($(this).val());
            idReceived.push($(this).data("received"));
        });

        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {

                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "<?php echo site_url('Shipping/save_ship_to_inward') ?>",
                        data: {
                            shipment_date: $("#shipmentDate").val(),
                            vessel: $("#vessel").val(),
                            voyage: $("#voyage").val(),
                            etd: $("#etd-shipment").find(":selected").val(),
                            etd_date: $("#etdDate").val(),
                            eta: $("#eta-shipment").val(),
                            eta_date: $("#etaDate").val(),
                            from: $("#from").val(),
                            to: $("#to").val(),
                            det_cont: checkedValues,
                            det_received_id: idReceived,

                        },
                        dataType: "JSON",
                        beforeSend: function() {
                            sambu.startPageLoading()
                            $(".btn-f-refresh").prop("disabled", true)

                        },
                        success: function(response) {


                            setTimeout(() => {
                                sambu.stopPageLoading();


                                if (response.code == 200) {
                                    $('.loadReport').html(response);
                                    $(".btn-f-refresh").prop("disabled", false)
                                    swal("Success", "Container Inward Success Created", 'success')
                                    window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + response.message + "&tipe=2";

                                } else {
                                    swal("Error", "" + response.message + "", 'error')
                                }
                            }, 2000);
                        },
                        error: function(err, errors) {
                            console.log(err);
                            console.log(errors);
                        }
                    })

                } else {
                    swal("Cancelled", "Ship To Inward List", "error");
                }
            });

    }

    function contorlButton() {

        var tipe = $("#tipe").find(":selected").val();

        if (tipe == 1) {

            $("#inward").prop("disabled", false);
            $("#outward").prop("disabled", true);

        } else if (tipe == 2) {
            $("#inward").prop("disabled", true);
            $("#outward").prop("disabled", false);
        }

    }
</script>