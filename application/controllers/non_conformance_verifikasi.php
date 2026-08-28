<style>
    td {
        vertical-align: middle;
        border: 1px solid black;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h5 style="font-weight: Bold; font-size: 20px;">Tracking Container</h5>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Transaction / </a></li>
                        <li class="breadcrumb-item"><a href="#">Shipping / </a></li>
                        <li class="breadcrumb-item active" aria-current="page">Track Container</li>
                    </ol>
                </nav>

                <div class="portlet light">
                    <div class="row" style="padding-left: 40px; padding-right: 40px; ">
                        <div class="col-12" style="padding-top: 40px;">
                            <div class="row mt-4 align-items-center">
                                <div class="col-md-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <form class="form-filter">
                                                <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-2 col-form-label">Shipment Date</label>
                                                    <div class="col-sm-2 col-md-4">
                                                        <input type="date" class="form-control shipemnt_date" name="shipment_date" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-2 col-form-label">Factory</label>
                                                    <div class="col-sm-4 col-md-6">
                                                        <select class="form-control factory_abbr" name="factory_abbr" id="factory_abbr">
                                                            <option selected class="holder" value="">Please select</option>
                                                            <option value="PSG">PT Pulau Sambu Guntung</option>
                                                            <option value="RSUP">PT Riau Sakti United Plantations</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="example-date-input" class="col-sm-2 col-form-label">QAD Verification</label>
                                                    <div class="col-sm-4 col-md-6">
                                                        <select class="form-control" name="qad_verification" id="qad_verification">
                                                            <option selected class="holder" value="">Please select</option>
                                                            <option>Return</option>
                                                            <option>Release</option>
                                                        </select>
                                                        <div class="custom-control custom-checkbox mt-2">
                                                            <input type="checkbox" checked class="custom-control-input" id="customCheck2" data-parsley-multiple="groups" data-parsley-mincheck="2" name="show_img" value="1">
                                                            <label class="custom-control-label" for="customCheck2" style="padding-top: 3px;">Show Container Image</label>
                                                        </div>
                                                        <button class="btn btn-primary mt-3 btn-refresh" type="button">
                                                            <span id="spinner"></span> Refresh
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="col-md-12">
                                    <div class="card m-b-30">
                                        <div class="card-body" id="tableOfUsers">

                                            <div class="row" style="padding-left: 10px; ">
                                                <div class="col">
                                                    <h4 class="header-title">List Of Container</h4>
                                                </div>
                                            </div>
                                            <hr>
                                            <form id="saveAcceptanse">
                                                <input type="hidden" name="factory_id" id="factoryId">

                                                <button type="button" class="btn btn-primary btn-excel" style="margin-bottom: 10px;" disabled >Export Excel</button>

                                                <div class="table-responsive" style="height: 600px; overflow-y: auto;">
                                                    <table class="table table-hover table-striped table-bordered table-container " style="font-size: 11px;">
                                                        <thead style="position: sticky; top:  -3px; background-color: antiquewhite;">
                                                            <th style="width: 1px;" class="text-center">#</th>
                                                            <th>Container Number</th>
                                                            <th>Shipping</th>
                                                            <th>Shipment Date</th>
                                                            <th>Po Number</th>
                                                            <th>Issue</th>
                                                            <th>Photo Defect</th>
                                                            <th>Status</th>
                                                            <th>QAD Remarks</th>
                                                            <th>Photo After Repair</th>
                                                            <th>QAD Verification</th>
                                                            <th>LOI</th>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <div class="text-center not-found" style="margin-top: -350px;">
                                                        <img class="text-center" src="https://sambu.krodec.com/container/assets/images/undraw_No_data_re_kwbl.png" style="width: 300px; text-align: center;">
                                                        <h4>Data Not Found</h4>
                                                    </div>
                                                </div>


                                                <hr>
                                            </form>


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                    <div class="modal fade modal-open" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-large" style="width: 60%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0 nonconformance-title">Varifikasi Container Non Conformance</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-nonNonConformance" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-5 border-right" style="border-right: 1px solid black;">

                                                <div class="form-group" style="padding-bottom: 10px;">
                                                    <label for="shipping-liner">Shipment Date</label>
                                                    <textarea class="form-control" rows="1" id="shipment-date" readonly name="qad_remarks"></textarea>
                                                </div>
                                                <div class="form-group" style="padding-bottom: 10px;">
                                                    <label for="shipping-liner">Shipping Liner</label>
                                                    <input type="text" id="shipping-liner" class="form-control" readonly>
                                                    <input type="hidden" id="cont_detailid" name="cont_detailid" class="form-control" readonly>
                                                    <input type="hidden" name="conformance_id" id="conformance-id">
                                                </div>

                                                <div class="form-group" style="padding-bottom: 10px;">
                                                    <label for="shipping-liner">Container Number</label>
                                                    <textarea class="form-control" rows="1" id="container-number" name="" readonly></textarea>

                                                </div>
                                                <label for="shipping-liner">Po Number</label>
                                                <div class="listPoNumber"></div>
                                                <hr>
                                                <label for="shipping-liner">Description</label>
                                                <div class="listDescription"></div>


                                            </div>

                                            <div class="col-md-7 ">
                                                <div class="form-group">
                                                    <label for="shipping-liner">Container Issue</label>
                                                    <textarea class="form-control" name="issue" id="issue" rows="3" readonly></textarea>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="shipping-liner">Status</label>
                                                            <input class="form-control" name="status" id="status" readonly>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="shipping-liner">Remarks From Factory</label>
                                                    <textarea class="form-control" rows="3" id="factory_remarks" readonly name=""></textarea>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label for="shipping-liner">Remarks ZHL</label>
                                                    <textarea class="form-control" rows="3" id="remarks" name="zhl_remarks"></textarea>
                                                </div>


                                                <div class="progress-upload" hidden>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-save"><span class="fa fa-save"></span>&nbsp;Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadLoi">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="uploadLoi" tabindex="-1" role="dialog" aria-labelledby="uploadLoiTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="uploadLoiTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUploadLoi" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirmance ID</label>
                        <input type="" class="form-control" name="conformance_id" id="conformance_ids" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Upload File LOI</label>
                        <input type="file" class="form-control" aria-describedby="emailHelp" placeholder="Upload File LOI" name="file">
                        <small id="emailHelp" class="form-text text-muted text-danger">Upload file jpg, jpeg, png</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Panggil fungsi inisialisasi saat halaman pertama kali dimuat
    $(document).ready(function() {
        $('.btn-secondary').attr('hidden', true)
    });
    $('.form-nonNonConformance').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "<?= base_url('C_NonConformance/store') ?>",
            cache: false,
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.code == 200) {
                    swal("Success", response.message, 'success')
                    $(".modal-open").modal('hide');
                    $(".btn-refresh").click();
                    reset();
                } else {
                    swal('Warning', response.message, 'warning');

                }
            },
            error: function(response) {
                console.log(response); // Show error message in the console
                // Handle the error here (uncomment and modify as needed)
                // Swal.fire('Warning', response.responseJSON.message, 'warning');

            }
        });
    });




    $(".btn-verification").click(function() {
        alert("test")
    });

    $(".btn-refresh").click(function() {
        var formData = $(".form-filter").serialize();
        var shipmentDate = $(".shipemnt_date").val()
        var factoryAbbr = $(".factory_abbr").val()
        var qadVerification = $("#qad_verification").val()
        var showImg = $("#customCheck2").prop("checked")
        var base_url = '<?= base_url() ?>';
        alert(factoryAbbr)
        $.ajax({
            type: "get",
            url: "<?= base_url('C_NonConformance/getAllByParam') ?>",
            data: formData,
            dataType: "json",
            beforeSend: function() {
                $('.btn-refresh').html('<span class="spinner-border spinner-border-sm"></span> Loading ...');
                $(".btn-refresh").prop("disabled", true);
                // $('.table-container').DataTable().destroy();
                $(".table-container tbody").empty();
            },
            success: function(response) {
                console.log(response);
                var $btnRefresh = $(".btn-refresh");
                $btnRefresh.html("Refresh").prop("disabled", false);

                var $notFound = $(".not-found");
                $notFound.attr('hidden', response.response.containerNonConformance.length > 0);

                var factories = [{
                        factory_name: 'PT Riau Sakti United Plantations',
                        factory_abbr: 'RSUP'
                    },
                    {
                        factory_name: 'PT Pulau Sambu Guntung',
                        factory_abbr: 'PSG'
                    }
                ];

                // $(".btn-excel").removeAttr('disabled', '').attr('data-shipmentdate', shipmentDate).attr('data-factoryabbr', factoryAbbr).attr('data-qadverification', qadVerification)
                $(".btn-excel")
                    .removeAttr('disabled')
                    .data('shipmentdate', shipmentDate)
                    .data('factoryabbr', factoryAbbr)
                    .data('qadverification', qadVerification);


                $.each(factories, function(i, data) {
                    var factory = $(".factory_abbr").val();
                    if (factory != '') {
                        if (factory == data.factory_abbr) {
                            var hdr = `<tr style="background-color: #2F4F4F; color: white">
                            <td colspan="13">${data.factory_name}</td>
                        </tr>`;
                        }
                    } else {
                        var hdr = `<tr style="background-color: #2F4F4F; color: white">
                            <td colspan="13">${data.factory_name}</td>
                        </tr>`
                    }
                    var rowsHTML = "";

                    $.each(response.response.containerNonConformance, function(key, item) {
                        if (item.factory_abbr === data.factory_abbr) {
                            var containerSize = item.c20 > 0 ? 20 : 40;
                            var uniquePOs = new Set();
                            var uniqueDesc = new Set();
                            var uniqueBuyers = new Map();
                            var bgColor = item.complete_non_conformance == 1 ? "CC3300" : ""
                            var color = item.complete_non_conformance == 1 ? "white" : ""
                            var row = `<tr style="line-height: 1.5; background-color: 	${bgColor}; color : ${color}; vertical-align: middle">`

                            // alert(item.complete_non_conformance)
                            if (item.complete_non_conformance == 1) {
                                row += `<td align="center"><button type="button" data-id="${item.cont_dtl_id}" data-factory="${item.factory_abbr}" data-conformanceId=${item.conformance_id} class="btn btn-primary btn-sm btn-verification">Verification</button></td>`
                            } else {
                                row += `<td align="center">`
                                row += `<button type="button" disabled class="btn btn-success btn-sm">Already Verification</button>`
                                if (item.status == "Hold") {
                                    row += `<button type="button" class="btn btn-primary btn-sm open-modal-loi" ${item.loi_file == null  ? "" : "disabled" } data-id=${item.id}>Upload Loi</button>`
                                }
                                row += `</td>`
                            }
                            row += `<td class="container-number">${item.container_number}</td>`
                            row += `<td class="shipping">${item.shipping}</td>`
                            row += `<td class="shipment-date">${moment(item.shipment_date).format("DD/MM/YYYY")}</td>`
                            row += `<td class="po_number">`

                            // Rest of the code remains the same as in your original function.

                            $.each(response.response.contExport[item.container_number], function(k, val) {
                                if (!uniquePOs.has(val.po_number)) {
                                    uniquePOs.add(val.po_number);
                                    row += `<i class='fa fa-angle-double-right' aria-hidden='true'> ${val.po_number}</i><br>`
                                }
                            });

                            row += "</td><td  hidden class='description'> "
                            $.each(response.response.contExport[item.container_number], function(k, val) {
                                if (!uniqueDesc.has(val.Description)) {
                                    uniqueDesc.add(val.Description);
                                    row += `<i class='fa fa-angle-double-right mb-2' aria-hidden='true'> ${val.Description}</i><br>`
                                }
                            });

                            // row += "</td><td>"

                            // $.each(response.response.contExport[item.container_number], function(k, val) {
                            //     if (!uniqueBuyers.has(val.customer_name)) {
                            //         uniqueBuyers.set(val.customer_name, true);
                            //         row += `<i class='fa fa-angle-double-right' aria-hidden='true'> ${val.customer_name}</i><br>`
                            //     }
                            // });

                            // row += "</td>"

                            row += `<td class="issue">${item.issue}</td>`

                            row += `<td>`
                            if (showImg) {
                                $.each(response.response.conformanceFile[item.conformance_id], function(k, val) {
                                    if (val.is_defect == 1) {

                                        row += `<div class="zoom-gallery mb-2">
                                        <a class="floatleft" href="<?= base_url() ?>../container/assets/images/container_confirmance/${val.file}" title="Project 1">
                                        <img src="<?= base_url() ?>../container/assets/images/container_confirmance/${val.file}" alt="" width="150" class="" style="border: 2px solid #000; border-radius: 5px;" >
                                        </a>
                                    </div>`;
                                    }
                                });
                            }
                            row += `</td>`

                            row += `<td class="status">${item.status}</td>`
                            row += `<td class="factory-remarks">${item.qad_remarks}</td>`
                            // row += `<td>${item.zhl_remarks}</td>`
                            row += `<td>`
                            if (showImg) {
                                $.each(response.response.conformanceFile[item.conformance_id], function(k, val) {
                                    if (val.is_defect == 0) {
                                        row += `<div class="zoom-gallery mb-2">
                                        <a class="floatleft" href="<?= base_url() ?>../container/assets/images/container_confirmance/${val.file}" title="Project 1">
                                        <img src="<?= base_url() ?>../container/assets/images/container_confirmance/${val.file}" alt="" width="150" class="" style="border: 2px solid #000; border-radius: 5px;" >
                                        </a>
                                    </div>`;
                                    }
                                });
                            }
                            row += `</td>`
                            row += `<td>${item.qad_verification}</td>`
                            row += '<td>';
                            row += (item.loi_file != null) ?
                                '<a target="_blank" href="' + base_url + '../container/assets/images/loi_file/' + item.loi_file + '" class="btn btn-primary btn-xs">show loi</a>' :
                                '<span class="btn btn-danger btn-xs disabled">Loi Not Found</span>';
                            row += '</td>';


                            row += `</tr>`;
                            rowsHTML += row;

                        }
                    });

                    $(".table-container tbody").append(hdr + rowsHTML);
                });

            },

            error: function(xhr, jqXHR) {
                $(".not-found").removeAttr('hidden', true)
            }
        });


    });

    // Fungsi untuk menggulirkan tabel ke bagian atas
    function scrollTableToTop() {
        // Menggunakan animasi .animate() untuk menggulirkan tabel ke bagian atas
        var tableContainer = $(".table-container");
        var scrollTopPosition = tableContainer.offset().top;
        $("html, body").animate({
            scrollTop: scrollTopPosition
        }, 500); // Durasi animasi (dalam milidetik)
    }


    function createList(items, containerClass, labelName) {
        var formGroup = $('<div>').addClass('form-group');
        formGroup.empty();

        var label = $('<label>').text(labelName);
        var ul = $('<ul>').addClass('list-unstyled');

        label.appendTo(formGroup);

        items.forEach(function(item) {
            var li = $('<li>').html("<i class='fas fa-angle-right'></i> " + item);
            li.appendTo(ul);
        });

        ul.appendTo(formGroup);

        // Clear the desired container before appending the form group
        $(containerClass).empty();
        formGroup.appendTo(containerClass);
    }

    $(document).on("click", ".btn-verification", function() {
        var row = $(this).closest("tr");
        var conformanceId = $(this).data('conformanceid')
        var contDetailId = $(this).data("id")
        var container_number = row.find('.container-number').text()
        var shipping = row.find('.shipping').text()
        var shipment_date = row.find('.shipment-date').text()
        var status = row.find('.status').text()
        var issue = row.find('.issue').text()
        var poNumber = row.find('.po_number').html()
        var description = row.find('.description').html()
        var factory = $(this).data('factory')
        var factory_remarks = row.find('.factory-remarks').text();

        // alert(container_number)
        // alert(shipping)
        // alert(shipment_date)
        // alert(status)

        $("#shipping-liner").val(shipping)
        $("#cont_detailid").val(contDetailId)
        $("#container-number").val(container_number)
        $("#shipment-date").val(shipment_date)
        $("#status").val(status)
        $("#status").val(status)
        $("#factory").val(factory)
        $("#status").val(status)
        $("#issue").val(issue)
        $("#factory_remarks").val(factory_remarks)
        $(".listPoNumber").html(poNumber)
        $(".listDescription").html(description)
        $("#conformance-id").val(conformanceId)
        $(".modal-open").modal('show')


    })


    $(document).on("click", ".open-modal-loi", function() {
        row = $(this).closest("tr");
        conformanceId = $(this).data('id')

        $("#uploadLoi").modal('show')
        $("#uploadLoiTitle").html("Form Upload Loi")
        $("#conformance_ids").val(conformanceId)
    })

    $("#formUploadLoi").submit(function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();


        //berikan script ajax upload file
        $.ajax({
            url: "<?= base_url('C_NonConformance/uploadLoi') ?>",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-save').html('<span class="spinner-border spinner-border-sm"></span> Loading ...');
                $(".btn-save").prop("disabled", true);
            },
            success: function(response) {
                console.log(response);
                // if (response.code == 200) {
                //     swal("Success", response.message, 'success')
                //     $(".modal-open").modal('hide');
                //     $(".btn-refresh").click();
                //     reset();
                // } else {
                //     swal('Warning', response.message, 'warning');

                // }
            },
            error: function(response) {
                console.log(response); // Show error message in the console
                // Handle the error here (uncomment and modify as needed)
                // Swal.fire('Warning', response.responseJSON.message, 'warning');

            }
        });


        // Your custom code here
        // For example, you can get the form data and perform an AJAX request
        var formData = $(this).serialize(); // Serialize form data
        // Perform an AJAX request here
        // Example:
        /*
        $.ajax({
        url: "your_server_endpoint",
        type: "POST",
        data: formData,
        success: function(response) {
            // Handle the response
        }
        });
        */
    });


    function reset() {
        $("#issue").val("")
        $("#status").val("")
        $("#remarks").val("")
        $("#file").val("")
    }

    // $(document).on("click", ".btn-verification", function() {
    //     var row = $(this).closest("tr");
    //     var conformanceId = $(this).data('conformanceid')
    //     var contDetailId = $(this).data("id")
    //     var container_number = row.find('.container-number').text()
    //     var shipping = row.find('.shipping').text()
    //     var shipment_date = row.find('.shipment-date').text()
    //     var status = row.find('.status').text()
    //     var issue = row.find('.issue').text()
    //     var poNumber = row.find('.po_number').html()
    //     var description = row.find('.description').html()
    //     var factory = $(this).data('factory')
    //     var factory_remarks = row.find('.factory-remarks').text();

    //     // alert(container_number)
    //     // alert(shipping)
    //     // alert(shipment_date)
    //     // alert(status)

    //     $("#shipping-liner").val(shipping)
    //     $("#cont_detailid").val(contDetailId)
    //     $("#container-number").val(container_number)
    //     $("#shipment-date").val(shipment_date)
    //     $("#status").val(status)
    //     $("#status").val(status)
    //     $("#factory").val(factory)
    //     $("#status").val(status)
    //     $("#issue").val(issue)
    //     $("#factory_remarks").val(factory_remarks)
    //     $(".listPoNumber").html(poNumber)
    //     $(".listDescription").html(description)
    //     $("#conformance-id").val(conformanceId)
    //     $(".modal-open").modal('show')


    // })

    $(document).on('click', '.btn-excel', function(){
        var shipmentDate = $(this).data('shipmentdate');
        var factoryAbbr = $(this).data('factoryabbr');
        var qadVerification = $(this).data('qadverification');
        var url = `<?= base_url() ?>/Excel/toExcelNonConformanceContainer?shipment-date=${shipmentDate}&factory-abbr=${factoryAbbr}&qad-verification=${qadVerification}`
        window.open(url, '_blank');
    })
</script>