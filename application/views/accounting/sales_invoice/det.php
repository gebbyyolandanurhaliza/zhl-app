<script type="text/javascript">
    var addedrows = new Array();
    $(document).ready(function () {
        $("#sourcetable tbody tr").on("click", function (event) {
            var ok = 0;
            var theid = $(this).attr('id').replace("sour", "");
            var newaddedrows = new Array();
            for (index = 0; index < addedrows.length; ++index) {
                // if already selected then remove
                if (addedrows[index] == theid) {
                    $(this).css("background-color", "#fff");
                    // remove from second table :
                    var tr = $("#dest" + theid);
                    tr.css("background-color", "#FF3700");
                    tr.fadeOut(400, function () {
                        tr.remove();
                    });
                    //addedrows.splice(theid, 1);	
                    //the boolean
                    ok = 1;
                } else {
                    newaddedrows.push(addedrows[index]);
                }
            }
            addedrows = newaddedrows;
            // if no match found then add the row :
            if (!ok) {
                // retrieve the id of the element to match the id of the new row :
                addedrows.push(theid);
                $(this).css("background-color", "#cacaca");
                $('#destinationtable tr:last').after('<tr id="dest' + theid + '"><td>'
                        + $(this).find("td").eq(0).html() + '</td><td>'
                        + $(this).find("td").eq(1).html() + '</td><td>'
                        + $(this).find("td").eq(2).html() + '</td><td>'
                        + $(this).find("td").eq(3).html() + '</td><td>'
                        + $(this).find("td").eq(4).html() + '</td><td>'
                        + $(this).find("td").eq(5).html() + '</td><td>'
                        + $(this).find("td").eq(6).html() + '</td><td>'
                        + $(this).find("td").eq(7).html() + '</td><td>'
                        + $(this).find("td").eq(8).html() + '</td><td>'
                        + $(this).find("td").eq(9).html() + '</td><td>'
                        + $(this).find("td").eq(10).html() + '</td><td>'
                        + $(this).find("td").eq(11).html() + '</td></tr>');
            }
        });
    });
</script>		

<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master COA</h4>
            </div>
            <div class="modal-body">
                <table id="sourcetable" class="table table-bordered" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%; text-align: center;">P. Date</th>
                                        <th style="width: 5%; text-align: center;">Exp. Date</th>
                                        <th style="width: 5%; text-align: center;">Pallet</th>
                                        <th style="width: 5%; text-align: center;">Kode Batch</th>
                                        <th style="width: 10%; text-align: center;">Quantity</th>
                                        <th style="width: 10%; text-align: center;">Lokasi</th>
                                        <th style="width: 10%; text-align: center;">Shipment</th>
                                        <th style="width: 10%; text-align: center;">Reject</th>
                                        <th style="width: 10%; text-align: center;">Sampling</th>
                                        <th style="width: 10%; text-align: center;">Resampling</th>
                                        <th style="width: 10%; text-align: center;">Repacking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        <tr id="sour1">
                                            <td style="width: 5%; text-align: center;"> 
                                                <input type="hidden" name="DetailID[]" value="a"> 
                                                a
                                            </td>
                                            <td style="width: 5%; text-align: center;">b</td>
                                            <td style="width: 5%; text-align: center;">c</td>
                                            <td style="width: 5%; text-align: center;">d</td>
                                            <td style="width: 10%; text-align: center;">e</td>
                                            <td style="width: 10%; text-align: center;">
                                                <input type="hidden" name="NoRak[]" value="f" class="teks">
                                                <input type="text" name="NoRakUp[]" value="g" class="tex"></td>
                                            <td style="width: 10%; text-align: center;">
                                                <input type="hidden" name="Qty_hidden[]" value="h" class="qty_hidden">
                                                <input type="hidden" name="ProductID" value="i" class="teks">
                                                <input type="hidden" name="NoPO" value="j" class="teks">
                                                <input type="hidden" name="TglPO[]" value="k" class="teks">
                                                <input type="hidden" name="SerialID[]" value="l" class="teks">
                                                <input type="hidden" name="GudangID[]" value="m" class="teks">
                                                <input type="hidden" name="QtyUpdate[]" value="0" class="teks qtyupdate">
                                                <input type='hidden' value="n" name='TanggalPO' >
                                                <input type="text" name="kuantiti[]" value="o" class="teks qty">
                                            </td>
                                            <td style="width: 10%; text-align: center;"><input type="text" name="reject[]" value="0" onkeyup="RejFunction()"  class="teks rej"></td>
                                            <td style="width: 10%; text-align: center;"><input type="text" name="sample[]" value="0" onkeyup="RejFunction()" class="teks sam"></td> 
                                            <td style="width: 10%; text-align: center;"><input type="text" name="resampling[]" value="0" onkeyup="RejFunction()" class="teks res"></td> 
                                            <td style="width: 10%; text-align: center;"><input type="text" name="repacking[]" value="0" onkeyup="RejFunction()" class="teks rep"></td>  
                                            <td style="width: 10%; text-align: center;"><input type="text" name="sisa[]" value="0" onkeyup="RejFunction()" class="teks sisa"></td>   

                                        </tr>
                                     

                                        <tr id="sour2">
                                            <td style="width: 5%; text-align: center;"> 
                                                <input type="hidden" name="DetailID[]" value="a"> 
                                                a
                                            </td>
                                            <td style="width: 5%; text-align: center;">b</td>
                                            <td style="width: 5%; text-align: center;">c</td>
                                            <td style="width: 5%; text-align: center;">d</td>
                                            <td style="width: 10%; text-align: center;">e</td>
                                            <td style="width: 10%; text-align: center;">
                                                <input type="hidden" name="NoRak[]" value="f1" class="teks">
                                                <input type="text" name="NoRakUp[]" value="g2" class="tex"></td>
                                            <td style="width: 10%; text-align: center;">
                                                <input type="hidden" name="Qty_hidden[]" value="h3" class="qty_hidden">
                                                <input type="hidden" name="ProductID" value="i4" class="teks">
                                                <input type="hidden" name="NoPO" value="j" class="teks">
                                                <input type="hidden" name="TglPO[]" value="k" class="teks">
                                                <input type="hidden" name="SerialID[]" value="l" class="teks">
                                                <input type="hidden" name="GudangID[]" value="m" class="teks">
                                                <input type="hidden" name="QtyUpdate[]" value="0" class="teks qtyupdate">
                                                <input type='hidden' value="n" name='TanggalPO' >
                                                <input type="text" name="kuantiti[]" value="o" class="teks qty">
                                            </td>
                                            <td style="width: 10%; text-align: center;"><input type="text" name="reject[]" value="0" onkeyup="RejFunction()"  class="teks rej"></td>
                                            <td style="width: 10%; text-align: center;"><input type="text" name="sample[]" value="0" onkeyup="RejFunction()" class="teks sam"></td> 
                                            <td style="width: 10%; text-align: center;"><input type="text" name="resampling[]" value="0" onkeyup="RejFunction()" class="teks res"></td> 
                                            <td style="width: 10%; text-align: center;"><input type="text" name="repacking[]" value="0" onkeyup="RejFunction()" class="teks rep"></td>  
                                            <td style="width: 10%; text-align: center;"><input type="text" name="sisa[]" value="0" onkeyup="RejFunction()" class="teks sisa"></td>   

                                        </tr>
                                     
                                </tbody>
                            </table>                                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#tabel_coa").dataTable({
            "scrollY": 300,
            "scrollX": true});
    });
</script>



 <a data-toggle="modal" class="btn btn-primary" href="#coa">...</a>
                            
                   <br><br><br><br>
                                <table class="table table-bordered" cellspacing="0"  id="destinationtable" >
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align: center;">P. Date</th>
                                            <th style="width: 5%; text-align: center;">Exp. Date</th>
                                            <th style="width: 5%; text-align: center;">Pallet</th>
                                            <th style="width: 5%; text-align: center;">Kode Batch</th>
                                            <th style="width: 10%; text-align: center;">Quantity</th>
                                            <th style="width: 10%; text-align: center;">Lokasi</th>
                                            <th style="width: 10%; text-align: center;">Shipment</th>
                                            <th style="width: 10%; text-align: center;">Reject</th>
                                            <th style="width: 10%; text-align: center;">Sampling</th>
                                            <th style="width: 10%; text-align: center;">Resampling</th>
                                            <th style="width: 10%; text-align: center;">Repacking</th>
                                            <th style="width: 10%; text-align: center;">Sisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <hr/>
                            