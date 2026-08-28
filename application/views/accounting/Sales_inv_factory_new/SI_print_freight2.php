<?php
    if(!empty($_header)){
        foreach ($total as $key) {
            $hutang = $key->JUMLAH * $key->rate;
        }
        foreach ($_header as $r) {
?>
<style>
#bg-text
{
    color:lightgrey;
    font-size:100px;
    transform:rotate(500deg);
    -webkit-transform:rotate(300deg);
}
}
</style>
<page oreintation="portrait" format="A4">
    <img src="assets/zhl-kop.PNG" style="width: 100%; height: 130px;">
    <table cellpadding="0" cellspacing="0" style="border: 0px; width:740px;">

        <tr>
       
            <th colspan="6" style="width: 740px; text-align: center"><h1>INVOICE</h1></th>    
        </tr>
        
        <tr>
            <td style="width:100px; font-weight: bold;">TO</td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:300px;"><?php echo $r->namacustomer; ?></td>
            <td style="width:100px; font-weight: bold; text-align: right;">Date </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;"> <?php $tgl = date_format((new DateTime($r->tanggal)), 'd M Y'); echo $tgl; ?></td>
        </tr>
        
        <tr>
            <td style="width:100px; text-align: left; vertical-align: top; font-weight: bold;" rowspan="4">Address</td>
            <td style="width:5px;  text-align: left; vertical-align: top; font-weight: bold;" rowspan="4">:</td>
            <td style="width:300px; text-align: left; vertical-align: top;" rowspan="4"><?php echo $r->address; ?></td>
            <td style="width:100px; text-align: right; font-weight: bold;">Invoice No </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;"><?php echo $r->nofaktur; ?></td>
        </tr>
        <tr>
            <td style="width:100px; text-align: right; font-weight: bold;">Invoice Type </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;">Freight Charges</td>
        </tr>
        <tr>
            <td style="width:100px; text-align: right; font-weight: bold;">Payment Terms </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;"> <?php echo $r->term; ?> days</td>
        </tr>
    </table>
    <br><br><br>
    <table cellpadding="0" cellspacing="0" style="border: 0px; width:740px;">
        <tr>
            <td style="width:100px; font-weight: bold;">Attn</td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:300px;">Account Dept</td>
            <td style="width:100px; font-weight: bold; text-align: right;">CNTR No. </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;"></td>
        </tr>
        <tr>
            <td style="width:100px; text-align: left; vertical-align: top; font-weight: bold;" rowspan="4"></td>
            <td style="width:5px;  text-align: left; vertical-align: top; font-weight: bold;" rowspan="4"></td>
            <td style="width:300px; text-align: left; vertical-align: top;" rowspan="4"></td>
            <td style="width:100px; text-align: right; font-weight: bold;">B/L No. </td>
            <td style="width:5px; font-weight: bold;">:</td>
            <td style="width:240px;"></td>
        </tr>
    </table>
    <br>

    <table cellpadding="0" cellspacing="0" style="border: 0px; width:740px;">
    <?php
    if ($r->Keterangan=='cancel'){
        echo "<p id='bg-text'> C A N C E L E D</p>";      
    }
    ?>
   
        <tr>
           <th style="width:70px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;">Items</th>
           <th style="width:380px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;">Description</th>
           <th style="width:50px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;">Quantity</th>
           <th style="width:120px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;">Price</th>
           <th style="width:120px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;">Ammount USD</th>
        </tr>
        <tr>
            <td style="width:70px; text-align: left; vertical-align: top;" rowspan="2"><br><br>1.</td>
            <td style="width:380px;text-align: left; vertical-align: top;"><br><br>Freight Charge for 
            <?php $tgl = date_format((new DateTime($r->tanggal)), 'M Y'); echo $tgl; ?>
            <br>Attached Details
            </td>
            <td style="width:50px; text-align: right; vertical-align: top;" rowspan="2"><br><br>1.00</td>
            <td style="width:120px; text-align: right; vertical-align: top;" rowspan="2"><br><br><?php echo number_format($hutang, 2); ?></td>
            <td style="width:120px; text-align: right; vertical-align: top;" rowspan="2"><br><br><?php echo number_format($hutang, 2); ?></td>
        </tr>
    </table>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <table cellpadding="0" cellspacing="0" style="border: 0px; width:740px;">
        <tr>
           <th style="width:70px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;"></th>
           <th style="width:380px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;"></th>
           <th style="width:50px; font-weight: bold; text-align: center; border-bottom: 1px; border-top: 1px;"></th>
           <th style="width:120px; font-weight: bold; text-align: right; vertical-align: top; border-bottom: 1px; border-top: 1px;">TOTAL <br><br><br></th>
           <th style="width:120px; font-weight: bold; text-align: right; vertical-align: top; border-bottom: 1px; border-top: 1px;"><?php echo number_format($hutang, 2); ?></th>
        </tr>
    </table>
    <br><br><br>
    <table cellpadding="0" cellspacing="0" style="border: 0px; width:740px;">
        <tr>
           <th width="540">Bank Details :</th>
           <th width="200" align="left">ZHENGHE LOGISTICS PTE LTD</th>
        </tr>
        <tr>
           <td width="540"><i>UNITED OVERSEAS BANK LIMITED <br> UOB MAIN BRANCH <br> Swift code : OCBCSGSG <br> SGD Acct No. 357-309-956-5 <br> USD Acct No. 357-907-139-5 </i></td>
           <td width="200" align="left" valign="bottom"><hr><?php echo $_GET['signature'];?></td>
        </tr>
       
        
    </table>
      <br><br><br>
    <table cellpadding="0" cellspacing="0" style="border: 0px; width:780px;">
    <tr>
           <td width="560"> <i>All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request. </i></td>
         
           
        </tr>
      </table>

</page>
<?php
      }
    }
?>
<page orientation="landscape" format="A4">
    <img src="assets/zhl-kop.PNG" style="width: 100%; height: 100px;">
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
                        <td style="border: 0.1px solid #000; width:200px; heigth:30px;"><?php //echo $r->custcompany; ?></td>
                        <td style="border: 0.1px solid #000; width:100px; heigth:30px;"><?php //echo $r->destination; ?></td>
                        <td style="border: 0.1px solid #000; width:70px; heigth:30px;" align="right"><?php echo number_format($r->amount, 2, '.',','); ?></td>
                    </tr>
                    <?php
                }
                $grand = number_format($hutang, 2);
                echo "
                    <tr>
                        <td colspan='2' style='background-color: #f2f2f2; border: 0.1px solid #000; width:50px; heigth:30px;'>GRAND TOTAL</td>
                        <td colspan='4' style='text-align:right; background-color: #f2f2f2; border: 0.1px solid #000; width:50px; heigth:30px;'>$grand</td>
                    </tr>";
            }


        ?>
        
    </table>
</page>