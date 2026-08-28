<page orientation="landscape" format="A4">
    <img src="<?=base_url(); ?>assets/zhl-kop.PNG" style="width: 100%; height: 100px;">
    <p style="text-align:center; font-size:26px;">Freight Charges Preview</p>

    <table cellpadding="0" cellspacing="0" style="border: 1px solid #000; width:700px;">
        <tr>
            <th style="border: 1px solid #000; width:50px;" valign="center">Inv. No</th>
            <th style="border: 1px solid #000; width:300px;" valign="center">P.O.NO.</th>
            <th style="border: 1px solid #000; width:300px;" valign="center">PRODUCTS</th>
            <th style="border: 1px solid #000; width:200px;" valign="center">CUSTOMER</th>
            <th style="border: 1px solid #000; width:100px;" valign="center">DESTINATION</th>
            <th style="border: 1px solid #000; width:70px;" valign="center">AMOUNT</th>
        </tr>
        <?php
            if(!empty($tampil_item)){
                foreach($tampil_item as $r){
                    ?>
                    <tr style="font-size: 8px">
                        <td style="border: 0.1px solid #000; width:50px; heigth:30px;"><?php echo $r->invno;?></td>
                        <td style="border: 0.1px solid #000; width:300px; heigth:30px;"><?php echo htmlentities($r->po_num); ?></td>
                        <td style="border: 0.1px solid #000; width:300px; heigth:30px;"><?php echo $r->prod; ?></td>
                        <td style="border: 0.1px solid #000; width:200px; heigth:30px;"><?php echo $r->custcompany; ?></td>
                        <td style="border: 0.1px solid #000; width:100px; heigth:30px;"><?php echo $r->destination; ?></td>
                        <td style="border: 0.1px solid #000; width:70px; heigth:30px;" align="right"><?php echo number_format($r->jumlah_container*$r->Harga, 2, '.',','); ?></td>
                    </tr>
                    <?php
                }
            }


        ?>
        
    </table>
</page>