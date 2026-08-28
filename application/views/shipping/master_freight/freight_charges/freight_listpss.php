<div class="page-content">
    
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                                
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">MASTER FREIGHT CHARGES - PSS</span>
                        </div>
                    </div>


                        <div class="portlet-title">
                            <div class="col-md-4">
                                    <select class="form-control select2me" id="dest">
                                        <option value="">All Destination</option>
                                        <?php foreach ($dest as $v) { ?>
                                        <option value="<?php echo $v->port_id; ?>"><?php echo $v->port_name. ', ' .$v->country_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-control select2me" id="cont">
                                        <option value="">All Container</option>
                                        <?php foreach ($cont as $v) { ?>
                                        <option value="<?php echo $v->container_id; ?>"><?php echo $v->container_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-control select2me" id="ship">
                                        <option value="">All Shipping Term</option>
                                        <?php foreach ($ship as $v) { ?>
                                        <option value="<?php echo $v->trading_term_id; ?>"><?php echo $v->trading_term_name. ' (' .$v->trading_term_remark. ')'; ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-md-4">
                                    <select class="form-control select2me" id="con">
                                        <option value="">All Consignee</option>
                                        <?php foreach ($con as $v) { ?>
                                        <option value="<?php echo $v->customer_id; ?>"><?php echo $v->customer_name; ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                                    <button class="btn-primary btn green" onclick="filterfactory()">Search</button>
                        </div>



                    <div class="table-scrollable" style="overflow: auto; height: 550px;">
                        <table class="table-bordered table-condensed" id="tblmon">
                            <thead>
                                <tr>
                                    <th  nowrap>No</th>
                                    <th  nowrap>Container Number</th>
                                    <th  nowrap>Port Name</th>
                                    <th  nowrap>Country Name</th>
                                    <!-- <th rowspan="2" nowrap>Validity From</th> -->
                                    <th  nowrap>Validity Untill</th>
                                    <th  nowrap>Customer Prices</th>
                                    <th  hidden="">Id Freight Charger</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-pete" id="tbl-pete">
                                <?php
                                $start = 0;
                                foreach ($freight as $xx)
                                {
                                ?>
                                <tr>
                                    <td class="center" width="2%" nowrap><?php echo ++$start ?></td>
                                    <td width='6%'><?php echo $xx->container_name ?></td>
                                    <td width='6%'><?php echo $xx->port_name ?></td>
                                    <td width='6%'><?php echo $xx->country_name ?></td>
                                    <!-- <td width='6%'><?php echo $xx->trading_term_name.' ('.$xx->trading_term_remark.')' ?></td> -->
                                    <!-- <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_from)) ?></td> -->
                                    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_till)) ?></td>
                                    <td width='6%'><?php echo $xx->cust_rates ?></td>
                                    <td width='6%' hidden=""><?php echo $xx->freight_charges_id ?></td>
                                </tr>
                            <?php
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
    $(document).ready(function () {
        $("#mytable").dataTable();
    });


function filterfactory(){
    $dest = document.getElementById('dest').value;
    $cont = document.getElementById('cont').value;
    $ship = document.getElementById('ship').value;
    $con  = document.getElementById('con').value;

            console.log("<?php echo base_url(); ?>master_freight/container_stock_filterpss?dest=" + $dest + "&cont="  + $cont + "&ship="  + $ship + "&con="  + $con);


            $.ajax({
            url: "<?php echo base_url(); ?>master_freight/container_stock_filterpss?dest=" + $dest + "&cont="  + $cont + "&ship="  + $ship + "&con="  + $con,
            success: function(response){
            //location.reload()
            $("#tbl-pete").html(response);
            },
            dataType: "html"
            });
}
</script>