<?php
if (!empty($select_hutang)) {

    foreach ($select_hutang as $v) {
        $no = $v->no_reff + 1;
        $t_no = substr('00'.$no,-3);
        if ($jenis == 'CCN') {
            $noref = "ZHCN" . $t_no . "/" . $bulan . "/" . $tahun;
        } else {
            $noref = "ZHDN" . $t_no . "/" . $bulan . "/" . $tahun;
        }
        ?>
        <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo $noref; ?>" onkeypress="return valid_enter(event)" class="form-control" readonly/>
        <?php
    }
} else {
    if ($jenis == 'CCN') {
            $noref = "ZHCN001/" . $bulan . "/" . $tahun;
        } else {
            $noref = "ZHDN001/" . $bulan . "/" . $tahun;
        }
        ?>
        <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo $noref; ?>" onkeypress="return valid_enter(event)" class="form-control" readonly/>
        <?php
}