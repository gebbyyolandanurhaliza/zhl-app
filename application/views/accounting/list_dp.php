

<div id="contact_form">
    <div class="modal-body">
        <section class="">
            <div class="contain">
                <!--<input type="text" class="form-group" name="search" id="cari">-->

                <table class="table table-bordered" id="tabel_dp">
                    <thead>
                        <tr class="header">
                            <th>Vendor Name</th>
                            <th>PO Number</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($pilih_dp)) {
                            $no = 1;
                            foreach ($pilih_dp as $y) {
                                ?>
                                <tr onclick="get_dp(this)"  style="cursor: pointer;">
                                    <td  style="display:none"><?php echo $y->header_id; ?></td>
                                    <td  style="display:none"><?php echo $y->header_id; ?></td>
                                    <td><?php echo $y->suplier; ?></td>
                                    <td><?php echo $y->no_reff; ?></td>
                                    <td><?php echo number_format($y->dp_total - $y->total_bayar, 2, ".", ","); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>

            </div>


            <div class="modal-footer">
                <input type="button" class="btn red" data-dismiss="modal" onclick="get_dp()" value="Ok" >
            </div>

        </section>
    </div>
</div>


<script>
    $(document).ready(function () {

        document.getElementById("destinationtable").style.display = "";
        document.getElementById("info_deposit").style.display = "";
        document.getElementById("garis_dp").style.display = "";
        //var total_deposit = document.getElementById("total_jr4");
        var sum = 0;
        $(".jum_dp").each(function () {
            if (!isNaN(this.value) && this.value.length !== 0) {
                sum += parseFloat(this.value);
            }
        });

        //total_deposit.value = sum;
    });

    function ambilx() {
        document.getElementById("destinationtable").style.display = "";
        var sum = 0;
        var dp = document.getElementsByClassName('jum_dp');
        for (var i = 0; i < dp.length; i++) {
            dp[i].value = dp[i].value.replace(",", "");
        }
        $(".jum_dp").each(function () {
            if (!isNaN(this.value) && this.value.length !== 0) {
                sum += parseFloat(this.value);

            }

        });

        for (var i = 0; i < dp.length; i++) {
            document.getElementById('total_jr4').value = sum;

        }
        hitung_total();

    }

</script>


<script>
    function get_dp(x) {

        function getText(el) {
            if (typeof el.textContent === 'string')
                return el.textContent;
            if (typeof el.innerText === 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        var num = 1;
        var detail_id = getText(document.getElementById('tabel_dp').rows[$r].cells[0]);
        var header_id = getText(document.getElementById('tabel_dp').rows[$r].cells[1]);
        var vendor = getText(document.getElementById('tabel_dp').rows[$r].cells[2]);
        var po = getText(document.getElementById('tabel_dp').rows[$r].cells[3]);
        var total = getText(document.getElementById('tabel_dp').rows[$r].cells[4]);

        for (var i = 0; i < num; i++) {
            $('table[id="destinationtable"]').append('<tr>\n\
                <td style="text-align:center"><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                <td><input type="text" name="detail_dp_id[]" class="txt" onkeypress="return isNumber(event)"  value="' + detail_id + '"  />\n\
                    <input type="hidden" name="header_dp_id[]" class="txt" onkeypress="return isNumber(event)"  value="' + header_id + '"  /></td>\n\
                <td><input type="text" name="vendor_dp_id[]" class="txt" style="text-align:center"  value="' + vendor + '"  /></td>\n\
                <td><input type="text" name="po_dp_id[]" class="txt" style="text-align:center"  value="' + po + '"  /></td>\n\
                <td style="text-align:right">' + total + '</td>\n\
                <td><input type="text" name="bayar_dp[]" class="txt number jum_dp" onkeyup="ambilx()" onkeypress="return isNumber(event)" value="' + total + '" /></td></tr>'
                    );
        }
        
        var sum = 0;
        var dp = document.getElementsByClassName('jum_dp');
        for (var i = 0; i < dp.length; i++) {
            dp[i].value = dp[i].value.replace(",", "");
        }
        $(".jum_dp").each(function () {
            if (!isNaN(this.value) && this.value.length !== 0) {
                sum += parseFloat(this.value);

            }

        });

        for (var i = 0; i < dp.length; i++) {
            document.getElementById('total_jr4').value = sum;

        }
        hitung_total();
        $('#deposit').modal('hide');
    }
</script>


