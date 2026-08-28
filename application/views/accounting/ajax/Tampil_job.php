<script type="text/javascript">
    //update date : 3 Dec 10.11 PM
    //Update By : Ozzy

//     var addedrows = new Array();
//     $(document).ready(function() {
//         $("#tabel_gl tbody tr").on("click", function(event) {
//             var ok = 0;
//             var theid = $(this).attr('id').replace("sour", "");
//             var sum = 0;
//             var rater = 0;
//             var newaddedrows = new Array();
//             //var grandtotal = 0;

//             for (index = 0; index < addedrows.length; ++index) {
//                 // if already selected then remove
//                 if (addedrows[index] == theid) {
//                     $(this).css("color", "#333");
//                     // remove from second table :
//                     var tr = $("#dest" + theid);
//                     tr.css("color", "#FF)000");
//                     tr.fadeOut(400, function() {
//                         tr.remove();
//                         //rate();
//                         debit();
//                         hitung_amount();
//                     });
//                     //addedrows.splice(theid, 1);   
//                     //the boolean
//                     ok = 1;


//                 } else {
//                     newaddedrows.push(addedrows[index]);
//                     //grandtotal += Number(txtamount[index].value);
//                 }

//             }
//             addedrows = newaddedrows;
//             var gst_select = 'FALSE';
//             //alert(txtamount[1].value);

//             // if no match found then add the row :
//             if (!ok) {
//                 // retrieve the id of the element to match the id of the new row :
//                 addedrows.push(theid);

//                 $(this).css("color", "#FF0000");
//                 $('#tabel tr:last').after('<tr id="dest' + theid + '"><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
//                     <td><input type="hidden" class="txt" name="Detail_item_id" value="0" /> \n\
//                         <input type="hidden" name="NoUrut[]" value="0" />\n\
//                         <input type="hidden" name="txtdocno[]" value="' + $(this).find("td").eq(8).html() + '" />\n\
//                         <input type="hidden" name="txtship_id[]" class="txt txtship_id" value="' + $(this).find("td").eq(8).html() + '" />\n\
//                         <input type="text" class="txt" name="Detail_po[]" value="' + $(this).find("td").eq(0).html() + '"></td>\n\
//                     <td><input type="hidden" class="txt" name="txtItemId[]" value="' + $(this).find("td").eq(5).html() + '">\n\
//                         <input type="text" class="txt" name="txtItemName[]" value="' + $(this).find("td").eq(1).html() + '"></td>\n\
//                     <td><input type="text" class="txt number quantity" onKeyup="hitung_amount()" name="txtQty[]" value="' + $(this).find("td").eq(2).html() + '"></td>\n\
//                     <td><input type="text" class="txt" name="txtunit[]" value="' + $(this).find("td").eq(9).html() + '">\n\
//                         <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
//                     <td><input type="text" class="txt number prices" name="txtunitprice[]" onKeyup="hitung_amount()" value="' + $(this).find("td").eq(3).html() + '"></td>\n\
//                     <td><input type="text" class="txt number amount" name="txtamount[]" onKeyup="hitung_total()" value="' + $(this).find("td").eq(4).html() + '"></td>\n\
//                     <td><input type="text" class="txt number dis_per" name="dis_per[]" onKeyup="hitung_disc()"  value="0"></td>\n\
//                     <td><input type="text" class="txt number dis_dol" name="dis_dol[]" value="' + $(this).find("td").eq(4).html() + '"></td>\n\
//                     <td><input type="text" class="txt number txtrate " name="txtRate[]" value="' + $(this).find("td").eq(10).html() + '"></td>\n\
//                     <td><input type="text" class="txt number txtSGD " name="txtusd[]" value="' + $(this).find("td").eq(11).html() + '"></td>\n\
//                     <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
//                             <option value="">Select</option>\n\
//                             <option value="GST">GST</option>\n\
//                             <option value="ZER">Zero Rate</option>\n\
//                             <option value="EXP">Exampt</option>\n\
//                             <option value="OUT">Out of Scope</option>\n\
//                         </select>\n\
//                     </td>\n\
//                     <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onKeyup="hitung_total()"  onkeypress="return isNumber(event)"  value="0"  /></td>\n\
//                     </tr>');
//             }
//             hitung_amount();
//             cek_gst();
//             var txtdiscount_all = document.getElementById('discount_all');
//             txtdiscount_all.disabled = false;

//         });

//     });
// </script>


<table class="datatable table table-bordered table-hover" id="tabel_gl">
    <thead>
        <tr class="header">
            <th>JOB<div>JOB</div>
            </th>
            <th>VEHICLE NO<div>VEHICLE NO</div>
            </th>
            <th>DRIVER NAME<div>DRIVER NAME</div>
            </th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($list_job)) {

            $no = 1;
            foreach ($list_job as $v) {
             
        ?>
                <tr style="cursor: pointer;" id="sour<?php echo $no++; ?>">
                    <td><?php echo $v->job; //0   
                        ?></td>
                    <td><?php echo $v->vehicle_no; //1   
                        ?></td>
                    <td><?php echo $v->driver_name; //1   
                        ?></td>
                    
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>