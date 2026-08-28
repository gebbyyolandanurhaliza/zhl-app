<div class="page-content">
    
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                                
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-table theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">MASTER FREIGHT CHARGES</span>
                        </div>
                        <div class="actions">
                            <?php echo anchor(site_url('master-freight-new/add'), '<i class="fa fa-plus"></i> Create Freight Charges', 'class="btn btn-primary"'); ?>
                        </div>
                    </div>


                        <div class="portlet-title">
                            <div class="col-md-4">
                                    <select class="form-control select2me" id="dest">
                                        <option value="">All Port Destination</option>
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
                        <table class="table-bordered table-striped table-condensed table-hover" id="tblmon">
                            <thead>
                                <tr>
                                    <th rowspan="2" nowrap>Action</th>
                                    <th rowspan="2" nowrap>No</th>
                                    <th rowspan="2" nowrap>Countdown Expiry</th>
                                    <th rowspan="2" nowrap>Notification</th>
                                    <th rowspan="2" nowrap>Container Number</th>
                                    <th rowspan="2" nowrap>Port Name</th>
                                    <th rowspan="2" nowrap>Country Name</th>
                                    <th rowspan="2" nowrap>Trading Term</th>
                                    <th rowspan="2" nowrap>Validity From</th>
                                    <th rowspan="2" nowrap>Validity Untill</th>
                                    <th colspan="2" nowrap>Customer Prices</th>
                                    <th rowspan="2" hidden="">Id Freight Charger</th>
                                </tr>
                                <tr>
                                    <th nowrap>Consignee (Link Marketing)</th>
                                    <th nowrap>Rate 1 (Link Marketing)</th>
                                </tr>
                            </thead>
                            <tbody class="tbl-pete" id="tbl-pete">
                                <?php
                                $start = 0;
                                foreach ($freight as $xx)
                                {
                                ?>

                                <?php if ($xx->kadaluarsa <= '0'){?>
                                <tr style="color: green; cursor: pointer;" onclick="pilih(this)">
                                <?php } elseif ($xx->kadaluarsa <= '7'){ ?>
                                <tr style="color: blue; cursor: pointer;" onclick="pilih(this)">
                                <?php } else { ?>
                                <tr onclick="pilih(this)" style="cursor: pointer;">
                                <?php } ?>
                                    <td style="text-align:center" width="100px">
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('master-freight-new/edit/'.$xx->freight_charges_id); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('master-freight-new/delete/'.$xx->freight_charges_id); ?>" onclick="javasciprt: return confirm('Are you sure delete Master Freight <?php echo $xx->container_name; ?> Port <?php echo $xx->port_name; ?> (<?php echo $xx->country_name; ?>) validity from <?php echo date('d-m-Y', strtotime($xx->validity_from));?> to <?php echo date('d-m-Y', strtotime($xx->validity_till));?>?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td class="center"><?php echo ++$start ?></td>
                                    <td align="center"><b><?php echo $xx->kadaluarsa ?> Days </b></td>
                                    
                                    <?php 

                                    if ($xx->need_comfirm >= '1' || $xx->need_comfirm <= '30'){
                                        if($xx->comfirm == '0'){
                                            $comf = '<a style="color: red">Please Comfirm Rates...!<a/>';
                                        }else{
                                            $comf = '';
                                        }
                                    }else{
                                        $comf = '';                                        
                                    }



                                    if($xx->kadaluarsa <= '7'){
                                        $exp = 'Please Update Rate and Validity...!';
                                    }else{
                                        $exp = '';
                                    }



                                    if ($xx->shipping_term_id == 3){
                                        $trading = "CIF / CFR ";
                                    }else{
                                        $trading = $xx->trading_term_name.' ('.$xx->trading_term_remark.')';
                                    }

                                    

                                    ?>
                                    <td align="center"><b><a style="color: green"><?php echo $exp.' '.$comf; ?></a></b></td>
                                    <td width='6%'><?php echo $xx->container_name ?></td>
                                    <td width='6%'><?php echo $xx->port_name ?></td>
                                    <td width='6%'><?php echo $xx->country_name ?></td>
                                    <td width='6%'><?php echo $trading ?></td>
                                    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_from)) ?></td>
                                    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_till)) ?></td>
                                    <td width='6%'><?php echo $xx->customer_name ?></td>
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

            console.log("<?php echo base_url(); ?>master_freight_new/container_stock_filter?dest=" + $dest + "&cont="  + $cont + "&ship="  + $ship + "&con="  + $con);


            $.ajax({
            url: "<?php echo base_url(); ?>master_freight_new/container_stock_filter?dest=" + $dest + "&cont="  + $cont + "&ship="  + $ship + "&con="  + $con,
            success: function(response){
            //location.reload()
            $("#tbl-pete").html(response);
            },
            dataType: "html"
            });
}


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

        var id_freight = getText(document.getElementById('tblmon').rows[$r].cells[18]);
//        window.open(url + "Sales_inv_factory/edit?id=" + InvoiceNumber + "");
        window.location.href = url + "master-freight-new/edit/" + id_freight + "";
    }
</script>