<?php
$po_number = $this->input->get("po_number");
$id = $this->input->get("id_sn_truck");
?>
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE CONTENT INNER -->
        <?php if (!empty($id)) { ?>
            <div class="note note-danger note-bordered">
                <p>
                <h4>DKSH Trucking Not Found !!!</h4>                                 
                </p>
            </div>
        <?php } ?>
        <div class="row">
        </div>
        <div class="row">
           
            <div class="col-md-12">
            <?php echo $message; ?>
                <div class="portlet light">
                    <!-- ini untuk search -->
                    <div class="portlet-body">
                        <form action="<?php echo base_url(); ?>Shipping_mon/search" method="get">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">PO Number</label>
                                        <div style="display: flex; flex-wrap: wrap;" class="col-md-8">
                                            <div class="col-md-8">
                                            <input type="text" name="po_number" id="search" value="<?php echo $po_number; ?>" class="form-control">
                                            </div>
                                            <div style="text-align: -webkit-right;" class="col-md-8">
                                                <button class="btn btn-default"><i class="fa fa-search"></i> Filter</button>
                                            </div>
                                            <!-- <a class="btn green col-md-3" id="btn-excel" name="action" value="excel" onclick="excel()"><i class="fa fa-file-excel-o"></i> Excel</a> -->
                                            <div class="col-md-8" style="display: flex; margin-top: 10px; justify-content: flex-end;">
                                                <a class="btn blue col-md-6" id="btn-excel" onclick="exportToExcel()"><i class="fa fa-file-excel-o"></i> Excel perPage</a>

                                                <a class="btn green col-md-6" id="btn-excel" onclick="exportToExcelAllPage()"><i class="fa fa-file-excel-o"></i> Excel All Page</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form> 
                    </div>
                    <!-- ini tutup untuk search -->
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-blue-sharp">Data DKSH TRUCKING</span>
                        </div>
                        <div class="form-group">
                            <a type="reset" class="btn btn-primary kanan" href="<?php echo base_url(); ?>Shipping_mon/add_dksh_trucking"><i class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <th hidden></th>
                            <th>Action</th>
                            <th>S/N</th>
                            <th>SHIPPER</th>
                            <th>CNEE</th>
                            <th>PO NUMBER</th>
                            <th>POL</th>
                            <th>CONT#</th>
                            <th>HOUSE B/L</th> 
                            <th>CONT TYPE</th> 
                            <th>ESTD TIME ARR</th> 
                            <th>ACTUAL TIME ARR</th> 
                            <th>VESSEL DISCHARGE TIMING</th> 
                            <th>TRUCK INTO YARDS DATE</th> 
                            <th>TRUCK OUT FM YARDS DATE</th>
                            <th>ESTD DETENTION CHARGES </th>
                            <th>ESTD DETENTION DAYS </th>
                            <th>REMARK </th>
                            </thead>
                            <tbody>
                                <?php
                                $nomor_urut = 1;
                                if (!empty($List_trucking_dksh)) {
                                   
                                    foreach ($List_trucking_dksh as $dksh) {
                                       
                                        $tgl_estd_time_arr = date_format(date_create($dksh->estd_time_arr), "d F Y");
                                        $tgl_actual_time_Arr = date_format(date_create($dksh->actual_time_Arr), "d F Y");
                                        $tgl_truck_in_to_yards_date = date_format(date_create($dksh->truck_in_to_yards_date), "d F Y");
                                        $tgl_truck_out_fm_yards_date = date_format(date_create($dksh->truck_out_fm_yards_date), "d F Y");
                                    
                                        ?>
                                        <tr onclick="pilih(this)" style="cursor: pointer;">
                                            <td>
                                                <a class="btn-sm btn-warning" href="<?php echo site_url('Shipping_mon/edit?id_sn_truck='.$dksh->id_sn_truck); ?>"><i class="fa fa-pencil" style="margin: auto;"></i></a>
                                                <a class="btn-sm btn-danger" href="<?php echo site_url('Shipping_mon/delete_dksh_trucking?id_sn_truck='.$dksh->id_sn_truck); ?>" onclick="javasciprt: return confirm('Are you sure delete Shipper <?php echo $dksh->shipper; ?> ?')"><i class="fa fa-trash" style="margin: auto;"></i></a>
                                                
                                            </td>
                                            <!-- <td><?php echo $dksh->id_sn_truck; ?></td> -->
                                            <td hidden><?php echo $dksh->id_sn_truck; ?></td>
                                            <td><?php echo $nomor_urut; ?></td>
                                            <td><?php echo $dksh->shipper; ?></td>
                                            <td><?php echo $dksh->cnee; ?></td>
                                            <td><?php echo $dksh->po_number; ?></td>
                                            <td><?php echo $dksh->pol; ?></td>
                                            <td><?php echo $dksh->cont; ?></td>
                                            <td><?php echo $dksh->house_bl; ?></td>
                                            <td><?php echo $dksh->cont_type; ?></td>
                                            <td style="text-align: center"><?php echo $tgl_estd_time_arr; ?></td>
                                            <td style="text-align: center"><?php echo $tgl_actual_time_Arr; ?></td>
                                            <td><?php echo $dksh->vessel_discharge_timing; ?></td>
                                            <td style="text-align: center"><?php echo $tgl_truck_in_to_yards_date; ?></td>
                                            <td style="text-align: center"><?php echo $tgl_truck_out_fm_yards_date; ?></td>
                                            <?php if($dksh->estd_detention_charges !== null) {?>
                                                <td>$ <?php echo $dksh->estd_detention_charges; ?></td>
                                            <?php } else{?>
                                                <td><?php echo $dksh->estd_detention_charges; ?></td>
                                            <?php }?>
                                            <td><?php echo $dksh->estd_detention_days; ?></td>
                                            <td><?php echo $dksh->remarks; ?></td>
                                        </tr>
                                        <?php
                                        $nomor_urut++;
                                    }
                                ?>

                            </tbody>
                        
                                <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // $(document).ready(function () {
	// 	$("#mytable").dataTable();
        // var table = $("#mytable").dataTable();

        // $("#btn-excel").click(function () {
        //     var currentPage = table.api().page.info().page + 1;
        //     var excelUrl = "Shipping_mon/dksh_trucking_excel?page=" + currentPage;
        //     window.location.href = excelUrl;
        // });
            
	// });

    $(document).ready(function () {
    $("#mytable").DataTable(); 
});
</script>

<script>

    function pilih(x)
    {

        function getText(el) {
            if (typeof el.textContent === 'string')
                return el.textContent;
            if (typeof el.innerText === 'string')
                return el.innerText;
        }

        $r = x.rowIndex;
        var url = "<?php echo base_url(); ?>";

        var TruckingDKHSNumber = getText(document.getElementById('tabel1').rows[$r].cells[0]);
        window.location.href = url + "Shipping_mon/edit?id_sn_truck=" + TruckingDKHSNumber + "";
    }
    
    function exportToExcel() {
        // ini function digunakan untuk mengambil nilai page saja, tidak mengambil limit nya

        // var table = $("#mytable").dataTable().api();
        // var currentPage = table.page() + 1;
        // var url = "<?php echo base_url(); ?>";
        // window.location.href = url + "Shipping_mon/dksh_trucking_excel?page=" + currentPage;

        var table = $("#mytable").DataTable();

        var currentPage = table.page() + 1;

        var rowsPerPage = table.page.len(); 

        var url = "<?php echo base_url(); ?>";

        window.location.href = url + "Shipping_mon/dksh_trucking_excel?page=" + currentPage + "&limit=" + rowsPerPage;
    }

    function exportToExcelAllPage() {
        var url = "<?php echo base_url(); ?>";
        window.location.href = url + "Shipping_mon/dksh_trucking_excel_all";
    }

</script>