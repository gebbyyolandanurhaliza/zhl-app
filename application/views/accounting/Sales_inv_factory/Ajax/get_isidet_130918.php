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
                            if($r->stuffing == 'EE'){$stuff = 'Export Empty';}else if($r->stuffing == 'EL'){$stuff = 'Export Laden';}else if($r->stuffing == 'IT'){$stuff = 'Import Transhipment';}else if($r->stuffing == 'IL'){$stuff = 'Import Laden';}else if($r->stuffing == 'RE'){$stuff = 'Recall Container';}
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
                        <div id="isi-<?=$i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?=$i; ?>" onchange="hitung_total(<?=$i;?>)" value="0" ></div>
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

        if(!empty($_detail2)){
            foreach ($_detail2 as $r) {
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
                            if($r->stuffing == 'LE'){$stuff = 'Local Empty';}else if($r->stuffing == 'LL'){$stuff = 'Local Laden';}
                            echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?=$r->stuffing; ?>' id="jenisbarge-<?=$i; ?>" class='jenisbarge'>
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
    }elseif($id == 'lem' || $id == 'eim'){
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
        $i = 0;
        if(!empty($_detail2)){
            foreach ($_detail2 as $r) {
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
                            if($r->stuffing == 'LE'){$stuff = 'Local Empty';}else if($r->stuffing == 'LL'){$stuff = 'Local Laden';}
                            echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?=$r->stuffing; ?>' id="jenisbarge-<?=$i; ?>" class='jenisbarge'>
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
        geteta2();
        getetd2();
        getbarge2();
    </script>
<?php
    }
?>
        