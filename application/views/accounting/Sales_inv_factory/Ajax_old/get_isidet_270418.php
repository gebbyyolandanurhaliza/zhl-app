<?php
    $id = $_GET['invtype'];
    if($id == 'bar'){
?>
    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <tr>
            <th>Account Number</th>
            <th>Acoount Name</th>
            <th>Items</th>
            <th>Description</th>
            <th>Unit</th>
            <th>Type Barge</th>
            <th>Price</th>
            <th>USD Equivalent</th>
            <th>Gst Type</th>
            <th>Gst Value</th>
        </tr>
        
    <?php
        if(!empty('_detail')){
            $i = 0;
            foreach ($_detail as $r) {
                ?>
                <tr>
                    <td>
                          <input type="hidden" name="detailidcont[]" value="<?=$r->detail_id?>">
                          <input type="hidden" name="idcontainer[]" id="idcont-<?=$i; ?>" value="<?=$r->container_id?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?=$i; ?>" value="500101">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?=$i; ?>" value="Purchase">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name.'/'.$r->container_size.'/'.$r->etd.'/'.$r->eta.'/'.$r->destination; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->barge.'/'.$r->vessel; ?></textarea>
                    </td>
                    <td>
                        <select name="jenisbarge[]" id="jenisbarge-<?=$i; ?>" onchange="ambil_harga(<?=$i; ?>); hitung_total(<?=$i; ?>)">
                            <option></option>
                            <option value="1">Export Empty</option>
                            <option value="2">Export Laden</option>
                            <option value="3">Import Transhipment</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="<?=$r->container_name; ?>" > </td>
                    </td>
                    <td>
                        <div id="isi-<?=$i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?=$i; ?>" onchange="hitung_total(<?=$i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?=$i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?=$i;?>)" id="txtGST-<?=$i;?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER">Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?=$i; ?>" value="0"/>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
    ?>
        <tr>
            <td colspan="6" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number"  value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="6" align="right">GRAND TOTAL</td>
            <td colspan="4" ><input type="text" name="stotalinv" id="stotalinv" class="txt Number"  value="0" readonly></td>
        </tr>
    </table>   
<?php
    }else if($id == 'fre'){ 
?>
    <!--  Tabel 2 -->
    <table class="table table-bordered" id="tabel">
        <tr>
            <th>Account Number</th>
            <th>Acoount Name</th>
            <th>Items</th>
            <th>Description</th>
            <th>Unit</th>
            <th hidden>Type Barge</th>
            <th>Price</th>
            <th>USD Equivalent</th>                
            <th>Gst Type</th>
            <th>Gst Value</th>
        </tr>
        
    <?php
        if(!empty('_detail')){
            $i = 0;
            foreach ($_detail as $r) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?=$r->detail_id?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?=$i; ?>" value="<?=$r->container_id?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?=$i; ?>" value="500101">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?=$i; ?>" value="Purchase">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name.'/'.$r->container_size.'/'.$r->etd.'/'.$r->eta.'/'.$r->destination; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->barge.'/'.$r->vessel; ?></textarea>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="<?=$r->container_name; ?>" > 
                    </td>
                    <td hidden>
                        <select name="jenisbarge[]" id="jenisbarge-<?=$i; ?>">
                            <option></option>
                            <option value="1">Export Empty</option>
                            <option value="2">Export Laden</option>
                            <option value="3">Import Transhipment</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?=$i; ?>" onchange="hitung_total(<?=$i; ?>)" value="0">
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?=$i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?=$i;?>)" id="txtGST-<?=$i;?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER">Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?=$i; ?>" value="0"/>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
    ?>
        <tr>
            <td colspan="5" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number"  value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="5" align="right">GRAND TOTAL</td>
            <td colspan="4" ><input type="text" name="stotalinv" id="stotalinv" class="txt Number"  value="0" readonly></td>
        </tr>
    </table>   
<?php
    }else{
?>
    <!-- Tabel 3 -->
    <table class="table table-bordered" id="tabel">
        <tr>
            <th>Account Number</th>
            <th>Acoount Name</th>
            <th>Items</th>
            <th>Description</th>
            <th>Unit</th>
            <th hidden>Type Barge</th>
            <th>Price</th>
            <th>USD Equivalent</th>
            <th>Gst Type</th>
            <th>Gst Value</th>
        </tr>
        
    <?php
        if(!empty('_detail')){
            $i = 0;
            foreach ($_detail as $r) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?=$r->detail_id?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?=$i; ?>" value="<?=$r->container_id?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?=$i; ?>" value="500101">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?=$i; ?>" value="Purchase">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name.'/'.$r->container_size.'/'.$r->etd.'/'.$r->eta.'/'.$r->destination; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->barge.'/'.$r->vessel; ?></textarea>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="<?=$r->container_name; ?>" > 
                    </td>
                    <td hidden>
                        <select name="jenisbarge[]" id="jenisbarge-<?=$i; ?>">
                            <option></option>
                            <option value="1">Export Empty</option>
                            <option value="2">Export Laden</option>
                            <option value="3">Import Transhipment</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?=$i; ?>" onchange="hitung_total(<?=$i; ?>)" value="0">
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?=$i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?=$i;?>)" id="txtGST-<?=$i;?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER">Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?=$i; ?>" value="0"/>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
    ?>
         <tr>
            <td colspan="5" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number"  value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="5" align="right">GRAND TOTAL</td>
            <td colspan="4" ><input type="text" name="stotalinv" id="stotalinv" class="txt Number"  value="0" readonly></td>
        </tr>
    </table>
<?php
    }
?>