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
            <th>Type Barge</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Amount</th>
            <th>USD Equivalent</th>
            <th>Gst Type</th>
            <th>Gst Value</th>
            <!-- <th>Gst Value (USD)</th> -->
        </tr>
        
    <?php
        if(!empty($_detail)){
            $i = 0;
            foreach ($_detail as $r) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?=$r->contid?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?=$i; ?>" value="<?=$r->contid?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?=$i; ?>" value="400101">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?=$i; ?>" value="Sales">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php if(!empty($r->stuffing)){echo $r->stuffing.' - ';} echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container.' x '.$r->container_name.' '.$r->etd.' - '.$r->eta; ?></textarea>
                    </td>
                    <td>
                        <?php 
                            $stuff = '';
                            if($r->stuffing == 'EE'){$stuff = 'Export Empty';}else if($r->stuffing == 'EL'){$stuff = 'Export Laden';}else if($r->stuffing == 'IT'){$stuff = 'Import Transhipment';}else if($r->stuffing == 'IL'){$stuff = 'Import Laden';}
                            echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?=$r->stuffing; ?>' id="jenisbarge-<?=$i; ?>" class='jenisbarge'>

                        <!-- <select name="jenisbarge[]" id="jenisbarge-<?=$i; ?>" onchange="ambil_harga(<?=$i; ?>); hitung_total(<?=$i; ?>)">
                            <option></option>
                            <option value="EE" <?php if($r->stuffing) ?> >Export Empty</option>
                            <option value="EL">Export Laden</option>
                            <option value="IT">Import Transhipment</option>
                            <option value="IL">Import Laden</option>
                        </select> -->
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="<?=$r->Jumlah_container; ?>" readonly> </td>
                    </td>
                    <td>
                        <div id="isi-<?=$i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?=$i; ?>" onchange="hitung_total(<?=$i; ?>)" value="0" ></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?=$i; ?>" value='0' readonly>
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
            <td colspan="7" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number"  value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="7" align="right">GRAND TOTAL</td>
            <td colspan="4" ><input type="text" name="stotalinv" id="stotalinv" class="txt Number"  value="0" readonly></td>
        </tr>
    </table>   

    <script type="text/javascript">
        gethargabarge();
        geteta();
        getetd();
        getbarge();
    </script>
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
            <th>Amount</th>
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
                    <!-- <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name.'/'.$r->container_size.'/'.$r->etd.'/'.$r->eta.'/'.$r->destination; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->barge.'/'.$r->vessel; ?></textarea>
                    </td> -->
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo '1'.' x '.$r->container_name.' '.$r->etd.' - '.$r->eta; ?></textarea>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="1" > 
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
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?=$i; ?>" value='0' readonly>
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
            <th>Amount</th>
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
                    <!-- <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name.'/'.$r->container_size.'/'.$r->etd.'/'.$r->eta.'/'.$r->destination; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo $r->barge.'/'.$r->vessel; ?></textarea>
                    </td> -->
                    <td>
                        <textarea name="det_items[]" id="det_items-<?=$i; ?>" cols="25" rows="3"><?php echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?=$i; ?>" cols="25" rows="3"><?php echo '1'.' x '.$r->container_name.' '.$r->etd.' - '.$r->eta; ?></textarea>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?=$i; ?>" value="1" > 
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
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?=$i; ?>" value='0' readonly>
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
    }
?>