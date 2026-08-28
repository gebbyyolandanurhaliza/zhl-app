<?php
$id = $_GET['invtype'];
if ($id == 'bar') {
?>
    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <thead>
            <tr>
                <th>Acount Number</th>
                <th>Department Code</th>
                <th>Acount Name</th>
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
        </thead>
        <tbody>

            <?php
            $i = 0;
            if (!empty($_detail)) {

                foreach ($_detail as $r) {
            ?>
                    <tr>
                        <td>
                            <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                            <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                        </td>
                        
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                        </td>
                        <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                            echo $r->stuffing . ' - ';
                                                                                                        }
                                                                                                        echo $r->container_name; ?></textarea>
                        </td>
                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name; ?></textarea>
                        </td>
                        <td>
                            <?php
                            $stuff = '';
                            if ($r->stuffing == 'EE') {
                                $stuff = 'Export Empty';
                            } else if ($r->stuffing == 'EL') {
                                $stuff = 'Export Laden';
                            } else if ($r->stuffing == 'ELCN') {
                                $stuff = 'Export Laden (CN)';
                            } else if ($r->stuffing == 'IT') {
                                $stuff = 'Import Transhipment';
                            } else if ($r->stuffing == 'ITCN') {
                                $stuff = 'Import Transhipment CN';
                            } else if ($r->stuffing == 'IL') {
                                $stuff = 'Import Laden';
                            } else if ($r->stuffing == 'RE') {
                                $stuff = 'Recall Container';
                            } else if ($r->stuffing == 'LO') {
                                $stuff = 'Loose Cargo';
                            }else if ($r->stuffing == 'EECN') {
                                $stuff = 'Empty Export (CN)';
                            }
                            echo $stuff;
                            ?>
                            <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>

                            <!-- <select name="jenisbarge[]" id="jenisbarge-<?= $i; ?>" onchange="ambil_harga(<?= $i; ?>); hitung_total(<?= $i; ?>)">
                            <option></option>
                            <option value="EE" <?php if ($r->stuffing) ?> >Export Empty</option>
                            <option value="EL">Export Laden</option>
                            <option value="IT">Import Transhipment</option>
                            <option value="IL">Import Laden</option>
                        </select> -->
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" onchange="hitung_total(<?= $i; ?>)">
                        </td>
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>">
                                <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                    </tr>
                <?php
                    $i++;
                }
            }


            if (!empty($_detail2)) {
                foreach ($_detail2 as $r) {
                ?>
                    <tr>
                        <td>
                            <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                            <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                        </td>
                        
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                        </td>
                        <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                            echo $r->stuffing . ' - ';
                                                                                                        }
                                                                                                        echo $r->container_name; ?></textarea>
                        </td>
                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name . ' ' . $r->etd . ' - ' . $r->eta; ?></textarea>
                        </td>
                        <td>
                            <?php
                            $stuff = '';
                            if ($r->stuffing == 'LE') {
                                $stuff = 'Local Empty';
                            } else if ($r->stuffing == 'LL') {
                                $stuff = 'Local Laden';
                            } else if ($r->stuffing == 'EI') {
                                $stuff = 'Empty Import';
                            } else if ($r->stuffing == 'LO') {
                                $stuff = 'Loose Cargo';
                            }
                            echo $stuff;
                            ?>
                            <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" onchange="hitung_total(<?= $i; ?>)">
                        </td>
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                    </tr>
                <?php
                    $i++;
                }
            }


            if (!empty($_detail3)) {
                foreach ($_detail3 as $r) {
                ?>
                    <tr>
                        <td>
                            <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                            <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                        </td>
                        
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                        </td>
                        <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                            echo $r->stuffing . ' - ';
                                                                                                        }
                                                                                                        echo $r->container_name; ?></textarea>
                        </td>
                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name . ' ' . $r->etd . ' - ' . $r->eta; ?></textarea>
                        </td>
                        <td>
                            <?php
                            $stuff = '';
                            if ($r->stuffing == 'LE') {
                                $stuff = 'Local Empty';
                            } else if ($r->stuffing == 'LL') {
                                $stuff = 'Local Laden';
                            } else if ($r->stuffing == 'EI') {
                                $stuff = 'Empty Import';
                            } else if ($r->stuffing == 'LO') {
                                $stuff = 'Loose Cargo';
                            }
                            echo $stuff;
                            ?>
                            <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" onchange="hitung_total(<?= $i; ?>)">
                        </td>
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                    </tr>
                <?php
                    $i++;
                }
            }

            $ft20 = 0;
            $ft40 = 0;
            $ft20reefer = 0;
            $ft40reefer = 0;

            if (!empty($_ft1)) {
                foreach ($_ft1 as $r) {
                    if ($r->container_size == "20") {
                        $ft20 = $ft20 + $r->Jumlah_container;
                    } else if ($r->container_size == "40") {
                        $ft40 = $ft40 + $r->Jumlah_container;
                    } else if ($r->container_size == "20 reefer") {
                        $ft20reefer = $ft20reefer + $r->Jumlah_container;
                    } else{
                        $ft40reefer = $ft40reefer + $r->Jumlah_container;
                    }
                }
            }


            if (!empty($_ft2)) {
                foreach ($_ft2 as $l) {
                    if ($l->container_size == "20") {
                        $ft20 = $ft20 + $l->Jumlah_container;
                    } else if ($l->container_size == "40") {
                        $ft40 = $ft40 + $l->Jumlah_container;
                    } else if ($l->container_size == "20 reefer") {
                        $ft20reefer = $ft20reefer + $l->Jumlah_container;
                    } else{
                        $ft40reefer = $ft40reefer + $l->Jumlah_container;
                    }
                }
            }

            if (!empty($_ft3)) {
                foreach ($_ft3 as $l) {
                    if ($l->container_size == "20") {
                        $ft20 = $ft20 + $l->Jumlah_container;
                    } else if ($l->container_size == "40") {
                        $ft40 = $ft40 + $l->Jumlah_container;
                    } else if ($l->container_size == "20 reefer") {
                        $ft20reefer = $ft20reefer + $l->Jumlah_container;
                    } else{
                        $ft40reefer = $ft40reefer + $l->Jumlah_container;
                    }
                }
            }

            if ($ft20 != 0) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="0">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft Container</textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20 . ' x 20ft Container'; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="jenisbarge[]" value='trucking20ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>Trucking 20ft
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
                $i++;
            }

            if ($ft40 != 0) {
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="50">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft Container</textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40 . ' x 40ft Container'; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="jenisbarge[]" value='trucking40ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 40ft
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
                $i++;
            }
            // tambahan reefer 20
            if ($ft20reefer != 0) {
                ?>
                    <tr>
                        <td>
                            <input type="hidden" name="detailidcont[]" value="60">
                            <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20 reefer">
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                        </td>
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                        </td>
                        <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft Reefer Container</textarea>
                        </td>
                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20reefer . ' x 20ft reefer Container'; ?></textarea>
                        </td>
                        <td>
                            <input type="hidden" name="jenisbarge[]" value='trucking20ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 20ft Reefer
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20reefer; ?>" readonly>
                        </td>
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                    </tr>
                <?php
                $i++;
            }

            if ($ft40reefer != 0) {
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="70">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40 reefer">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft Reefer Container</textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40reefer . ' x 40ft reefer Container'; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="jenisbarge[]" value='trucking40ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 40ft Reefer
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40reefer; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
            $i++;
            }
        ?>

            
            <tr>
                <td colspan="8" align="right">TOTAL</td>
                <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
                <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
                <td></td>
                <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
            </tr>
            <tr>
                <td colspan="8" align="right">GRAND TOTAL</td>
                <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
            </tr>
        </tbody>
    </table>

    <script type="text/javascript">
        gethargabarge();
        geteta();
        getetd();
        getbarge();
    </script>
<?php
} elseif ($id == 'lem' || $id == 'eim') {
    $ft20 = 0;
    $ft40 = 0;
    $ft20reefer = 0;
    $ft40reefer = 0;
    if (!empty($_ft2)) {
        foreach ($_ft2 as $l) {
            if ($l->container_size == "20") {
                $ft20 = $ft20 + $l->Jumlah_container;
            } else if ($l->container_size == "40") {
                $ft40 = $ft40 + $l->Jumlah_container;
            } else if ($l->container_size == "20 reefer") {
                $ft20reefer = $ft20reefer + $l->Jumlah_container;
            } else{
                $ft40reefer = $ft40reefer + $l->Jumlah_container;
            }
        }
    }
?>
    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <tr>
            <th>Account Number</th>
            <th>Department Code</th>
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
        if (!empty($_detail2)) {
            foreach ($_detail2 as $r) {
        ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                    </td>
                    
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                        echo $r->stuffing . ' - ';
                                                                                                    }
                                                                                                    echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name . ' ' . $r->etd . ' - ' . $r->eta; 
                        if ($i == 0) {
                            echo "\n- 1 WAY IMPORT LADEN\n- 1 WAY MTY RETURN";
                        }
                        ?></textarea>
                    </td>
                    <td>
                        <?php
                        $stuff = '';
                        if ($r->stuffing == 'LE') {
                            $stuff = 'Local Empty';
                        } else if ($r->stuffing == 'LL') {
                            $stuff = 'Local Laden';
                        } else if ($r->stuffing == 'EI') {
                            $stuff = 'Empty Import';
                        }
                        echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
                $i++;
            }
        }
        
        if ($ft20 != 0) {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="0">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20 . ' x 20ft Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking20ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>Trucking 20ft
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
            $i++;
        }

        if ($ft40 != 0) {
        ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="50">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40 . ' x 40ft Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking40ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 40ft
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
            $i++;
        }

        if ($ft20reefer != 0) {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="0">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20 reefer">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft Reefer Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20reefer . ' x 20ft reefer Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking20ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>Trucking 20ft Reefer
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20reefer; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
            $i++;
        }

        if ($ft40reefer != 0) {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="0">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40 reefer">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft Reefer Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40reefer . ' x 40ft reefer Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking40ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>Trucking 40ft Reefer
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40reefer; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
            $i++;
        }
    ?>
        <tr>
            <td colspan="8" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="8" align="right">GRAND TOTAL</td>
            <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
        </tr>
    </table>

    <script type="text/javascript">
        gethargabarge();
        geteta2();
        getetd2();
        getbarge2();
    </script>
<?php
} else if ($id == 'tet' || $id == 'chinaShipment') {

    $ft20 = 0;
    $ft40 = 0;
    $ft20reefer = 0;
    $ft40reefer = 0;

    if (!empty($_fttet)) {
        foreach ($_fttet as $r) {
            if ($r->container_size == "20") {
                $ft20 = $ft20 + $r->Jumlah_container;
            } else if ($r->container_size == "40") {
                $ft40 = $ft40 + $r->Jumlah_container;
            } else if ($r->container_size == "20 reefer") {
                $ft20reefer = $ft20reefer + $r->Jumlah_container;
            } else{
                $ft40reefer = $ft40reefer + $r->Jumlah_container;
            }
        }
    }
    if (!empty($_fttet2)) {
        foreach ($_fttet2 as $r) {
            if ($r->container_size == "20") {
                $ft20 = $ft20 + $r->Jumlah_container;
            } else if ($r->container_size == "40") {
                $ft40 = $ft40 + $r->Jumlah_container;
            } else if ($r->container_size == "20 reefer") {
                $ft20reefer = $ft20reefer + $r->Jumlah_container;
            } else{
                $ft40reefer = $ft40reefer + $r->Jumlah_container;
            }
        }
    }


?>
    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <tr>
            <th>Account Number</th>
            <th>Department Code</th>
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
        if (!empty($_detailtet)) {

            foreach ($_detailtet as $r) {
        ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                        echo $r->stuffing . ' - ';
                                                                                                    }
                                                                                                    echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <?php
                        $stuff = '';
                        if ($r->stuffing == 'EE') {
                            $stuff = 'Export Empty';
                        } else if ($r->stuffing == 'EL') {
                            $stuff = 'Export Laden';
                        } else if ($r->stuffing == 'IT') {
                            $stuff = 'Import Transhipment';
                        } else if ($r->stuffing == 'IL') {
                            $stuff = 'Import Laden';
                        } else if ($r->stuffing == 'RE') {
                            $stuff = 'Recall Container';
                        } else if ($r->stuffing == 'LO') {
                            $stuff = 'Loose Cargo';
                        } else if ($r->stuffing == 'ELCN') {
                            $stuff = 'Export Laden (CN)';
                        }else if ($r->stuffing == 'EECN') {
                            $stuff = 'Empty Export (CN)';
                        }else if ($r->stuffing == 'ITCN') {
                            $stuff = 'Import Transhipment (CN)';
                        }
                        echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>

                        <!-- <select name="jenisbarge[]" id="jenisbarge-<?= $i; ?>" onchange="ambil_harga(<?= $i; ?>); hitung_total(<?= $i; ?>)">
                            <option></option>
                            <option value="EE" <?php if ($r->stuffing) ?> >Export Empty</option>
                            <option value="EL">Export Laden</option>
                            <option value="IT">Import Transhipment</option>
                            <option value="IL">Import Laden</option>
                        </select> -->
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" onchange="hitung_total(<?= $i; ?>)">
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
                $i++;
            }
        }
        if (!empty($_detail2tet)) {
            foreach ($_detail2tet as $r) {
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->contid ?>">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3"><?php if (!empty($r->stuffing)) {
                                                                                                        echo $r->stuffing . ' - ';
                                                                                                    }
                                                                                                    echo $r->container_name; ?></textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->Jumlah_container . ' x ' . $r->container_name . ' ' . $r->etd . ' - ' . $r->eta; ?></textarea>
                    </td>
                    <td>
                        <?php
                        $stuff = '';
                        if ($r->stuffing == 'LE') {
                            $stuff = 'Local Empty';
                        } else if ($r->stuffing == 'LL') {
                            $stuff = 'Local Laden';
                        } else if ($r->stuffing == 'EI') {
                            $stuff = 'Empty Import';
                        } else if ($r->stuffing == 'LO') {
                            $stuff = 'Loose Cargo';
                        } else if ($r->stuffing == 'LLTP') {
                            $stuff = 'Local Laden (TP)';
                        }
                        echo $stuff;
                        ?>
                        <input type="hidden" name="jenisbarge[]" value='<?= $r->stuffing; ?>' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->Jumlah_container; ?>" onchange="hitung_total(<?= $i; ?>)">
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
                $i++;
            }
        }

        if ($ft20 != 0) {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="0">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20 . ' x 20ft Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking20ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'>Trucking 20ft
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
            $i++;
        }

        if ($ft40 != 0) {
        ?>
            <tr>
                <td>
                    <input type="hidden" name="detailidcont[]" value="50">
                    <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40">
                    <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                </td>
                <td>
                    <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                </td>
                <td>
                    <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                </td>
                <td>
                    <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft Container</textarea>
                </td>
                <td>
                    <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40 . ' x 40ft Container'; ?></textarea>
                </td>
                <td>
                    <input type="hidden" name="jenisbarge[]" value='trucking40ft' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 40ft
                </td>
                <td>
                    <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40; ?>" readonly>
                </td>
                </td>
                <td>
                    <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                </td>
                <td>
                    <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                </td>
                <td>
                    <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                        <option value="">Select</option>
                        <option value="GST">GST</option>
                        <option value="ZER" selected>Zero Rate</option>
                        <option value="EXP">Exampt</option>
                        <option value="OUT">Out of Scope</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                </td>
            </tr>
        <?php
        $i++;
        }

        if ($ft20reefer != 0) {
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="50">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="20 reefer">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 20ft reefer Container</textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft20reefer . ' x 20ft reefer Container'; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="jenisbarge[]" value='trucking20ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 20ft reefer
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft20reefer; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
            $i++;
        }

        if ($ft40reefer != 0) {
            ?>
                <tr>
                    <td>
                        <input type="hidden" name="detailidcont[]" value="50">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="40 reefer">
                        <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500103">
                    </td>
                    <td>
                        <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                    </td>
                    <td>
                        <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Trucking Income">
                    </td>
                    <td>
                        <textarea name="det_items[]" id="det_items-<?= $i; ?>" cols="25" rows="3">Trucking 40ft reefer Container</textarea>
                    </td>
                    <td>
                        <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $ft40reefer . ' x 40ft reefer Container'; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="jenisbarge[]" value='trucking40ftreefer' id="jenisbarge-<?= $i; ?>" class='jenisbarge'> Trucking 40ft Reefer
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $ft40reefer; ?>" readonly>
                    </td>
                    </td>
                    <td>
                        <div id="isi-<?= $i; ?>"><input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0"></div>
                    </td>
                    <td>
                        <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                    </td>
                    <td>
                        <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                            <option value="">Select</option>
                            <option value="GST">GST</option>
                            <option value="ZER" selected>Zero Rate</option>
                            <option value="EXP">Exampt</option>
                            <option value="OUT">Out of Scope</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                    </td>
                </tr>
            <?php
        $i++;
        }
        ?>
        <tr>
            <td colspan="8" align="right">TOTAL</td>
            <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
            <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
            <td></td>
            <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
        </tr>
        <tr>
            <td colspan="8" align="right">GRAND TOTAL</td>
            <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
        </tr>
    </table>

    <script type="text/javascript">
        gethargabarge();
        geteta();
        getetd();
        getbarge();
    </script>
<?php
} else if ($id == 'bargefreight') { ?>

    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <thead>
            <tr>
                <th>Acount Number</th>
                <th>Acount Name</th>
                <th>Items</th>
                <th>Description</th>
                <th>Type Barge</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Amount</th>
                <th>USD Equivalent</th>
                <th>Gst Type</th>
                <th>Gst Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (!empty($_detail)) {
                foreach ($_detail as $r) {
            ?>
                    <tr>
                        <td>
                            <!-- Input Hidden -->
                            <input type="hidden" name="bargefreight_hdr_id[]" value="<?= $r->bargefreight_hdr_id ?>" readonly>
                            <input type="hidden" name="detailidcont[]" value="<?= $r->bargefreight_hdr_id ?>" readonly>
                            <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->bargefreight_dtl_id ?>" readonly>
                            <input type="hidden" name="head[]" id="head-<?= $i; ?>" value="<?= $r->head ?>" readonly>
                            <input type="hidden" name="con_type_name[]" id="con_type_name-<?= $i; ?>" value="<?= $r->con_type_name ?>" readonly>
                            <input type="hidden" name="uom[]" id="uom-<?= $i; ?>" value="<?= $r->uom ?>" readonly>
                            <input type="hidden" name="pod[]" id="pod-<?= $i; ?>" value="<?= $r->pod ?>" readonly>
                            <input type="hidden" name="description_item[]" id="description_item-<?= $i; ?>" value="<?= $r->description ?>" readonly>
                            <!-- Input Hidden -->

                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="<?= $r->NoCOA ?>">
                        </td>
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="<?= $r->dept_code ?>">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="<?= $r->AccountName ?>">
                        </td>
                        <td class="text-center" width="100">
                            <?= $i ?>
                            <input type="hidden" name="det_items[]" class="txt det_items" id="det_items-<?= $i; ?>" value="<?= $i ?>">
                        </td>
                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->pod . ' ' . $r->uom . ' ' . $r->description; ?></textarea>
                        </td>
                        <td>
                            <textarea name="jenisbarge[]" id="jenisbarge-<?= $i; ?>" class="jenisbarge" cols="25" rows="3"><?php echo $r->con_type_name; ?></textarea>
                        </td>
                        <td class="text-center" width="100">
                            <?= $r->qty; ?>
                            <input type="hidden" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->qty; ?>">
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>">
                                <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="<?= number_format($r->unit_price, 0) ?>">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value='<?= $r->amount ?>' readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                    </tr>
            <?php
                    $i++;
                }
            }
            ?>
            <tr>
                <td colspan="8" align="right">TOTAL</td>
                <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
                <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
                <td></td>
                <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
            </tr>
            <tr>
                <td colspan="8" align="right">GRAND TOTAL</td>
                <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
            </tr>
        </tbody>
    </table>

    <?php

    if ($_detail) {

        $vessel_x = explode("/", $_detail[0]->vesel);
        $voyage_x = explode("/", $_detail[0]->voyage_no);

        $amount_vessel = count($vessel_x);

        if ($amount_vessel == 3) {
            $v = $vessel_x[0] . '/' . $voyage_x[0] . '/' . $vessel_x[1] . '/' . $voyage_x[1] . $vessel_x[2] . '/' . $voyage_x[2];
        } else if ($amount_vessel == 2) {
            $v = $vessel_x[0] . '/' . $voyage_x[0] . '/' . $vessel_x[1] . '/' . $voyage_x[1];
        } else {
            $v = $_detail[0]->vesel . '/' . $_detail[0]->voyage_no;
        }

        $term_x =  explode(" ", $_detail[0]->credit_term);
        $term = $term_x[0];
    } else {
        $v = '';
        $term = '';
    }
    ?>

    <script type="text/javascript">
        hitung_total_usd_bf();
        //getbarge();
        $('#barge').val('<?= $v ?>');
        $('#term').val('<?= $term ?>');
    </script>
<?php
} else if ($id == 'invexcel') { ?>

    <!-- Tabel 1 -->
    <table class="table table-bordered" id="tabel">
        <thead>
            <tr>
                <th>Acount Number</th>
                <th>Acount Name</th>
                <th>Shipper / Carrier</th>
                <th>Description</th>
                <th>Container Type</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Amount</th>
                <th>USD Equivalent</th>
                <th>Gst Type</th>
                <th>Gst Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (!empty($_detailinvexcel)) {
                foreach ($_detailinvexcel as $r) {
            ?>
                    <tr>
                        <input type="hidden" name="detailidcont[]" value="<?= $r->contid ?>">
                        <input type="hidden" name="idcontainer[]" id="idcont-<?= $i; ?>" value="<?= $r->jenis_cont ?>">
                        <td>
                            <input type="text" name="accNum[]" class="txt accNum" id="accNum-<?= $i; ?>" value="500101">
                        </td>
                        <td>
                            <input type="text" name="dept_code[]" class="txt dept_code" id="dept_code-<?= $i; ?>" value="001">
                        </td>
                        <td>
                            <input type="text" name="accName[]" class="txt accName" id="accName-<?= $i; ?>" value="Barge Income">
                        </td>

                        <td>
                            <textarea name="det_items[]" id="det_items-<?= $i; ?>" class="det_items" cols="25" rows="3"><?php echo $r->carrier; ?></textarea>
                        </td>

                        <td>
                            <textarea name="descr[]" id="descr-<?= $i; ?>" cols="25" rows="3"><?php echo $r->booking_ref . ' / ' . $r->vessel . ' / ' . $r->pod; ?></textarea>
                        </td>

                        <td class="text-center" width="100">
                            <p><?= $r->container_type . " " . getContainerType($r->jenis_cont) ?></p>
                            <input type="hidden" name="jenisbarge[]" class="jenisbarge" id="jenisbarge-<?= $i; ?>" value="<?= $r->container_type . '' . getContainerType($r->jenis_cont); ?>">
                        </td>
                        <td class="text-center" width="100">
                            <?= $r->qty; ?>
                            <input type="hidden" name="unit[]" class="txt unit" id="unit-<?= $i; ?>" value="<?= $r->qty; ?>">
                        </td>
                        <td>
                            <div id="isi-<?= $i; ?>">
                                <input type="text" name="txtHarga[]" class="txt number txtHarga" id="txtHarga-<?= $i; ?>" onchange="hitung_total(<?= $i; ?>)" value="0">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="txtTotal[]" class="txt number txtTotal" id="txtTotal-<?= $i; ?>" value="0" readonly>
                        </td>
                        <td>
                            <input type="text" name="txtUSD[]" class="txt number txtUSD" id="txtUSD-<?= $i; ?>" value='0' readonly>
                        </td>
                        <td>
                            <select name="txtGST[]" onchange="cek_gst(<?= $i; ?>)" id="txtGST-<?= $i; ?>" class="txt txtGST">
                                <option value="">Select</option>
                                <option value="GST">GST</option>
                                <option value="ZER" selected>Zero Rate</option>
                                <option value="EXP">Exampt</option>
                                <option value="OUT">Out of Scope</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="txt number txtGSTValue" name="txtGSTValue[]" id="txtGSTValue-<?= $i; ?>" value="0" />
                        </td>
                <?php
                    $i++;
                }
            }
                ?>
                    <tr>
                        <td colspan="8" align="right">TOTAL</td>
                        <td><input type="text" name="totalinv" id="totalinv" class="txt Number" value="0" readonly></td>
                        <td><input type="text" name="totalinvusd" id="totalinvusd" class="txt Number" value="0" readonly></td>
                        <td></td>
                        <td><input type="text" name="totalgst" id="totalgst" class="txt Number" value="0" readonly></td>
                    </tr>
                    <tr>
                        <td colspan="8" align="right">GRAND TOTAL</td>
                        <td colspan="4"><input type="text" name="stotalinv" id="stotalinv" class="txt Number" value="0" readonly></td>
                    </tr>
        </tbody>
    </table>



    <!-- <script type="text/javascript">
        hitung_total_usd_bf();
        //getbarge();
        // $('#barge').val('<?= $v ?>');
        // $('#term').val('<?= $term ?>');
    </script>  -->
<?php
}
?>