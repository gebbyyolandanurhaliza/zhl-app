<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        * {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            margin: 10px;
        }

        .kepala {
            text-align: center;
        }

        .kepala h3 {
            margin: 0;
        }

        .kepala p {
            margin: 0 0 5px 0;
        }

        .body {
            font-size: 10px;
        }

        .alamat {
            width: 100%;
        }

        .alamat p {
            padding: 0px;
            margin: 0px;
        }

        .voyage {
            width: 100%;
            border: 1px solid;
        }

        .list {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            border-top: none;
        }

        .payment_1 {
            border: 1px solid;
            border-collapse: collapse;
            width: 100%;
            border-top: none;
            margin-top: 0;
            padding-top: 0;
        }

        .footer {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .image {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <section class="kepala">
        <img src="<?= $header['logo'] ?>" class="image" width="100%">
        <h2><?= $header['title'] ?></h2>
    </section>
    <section class="body">
        <table class="alamat">
            <tr>
                <td width="60%">
                    <p><?= $costumer->customer_name ?></p>
                    <p style="width: 40% ;"><?= $costumer->customer_address ?></p>
                    <!-- <p>Boon Siew Building</p> -->
                    <!-- <p>Singapore 229833</p> -->
                    <p>Attn: Acoount Team</p>
                </td>
                <td width="40%">
                    <!-- <p>GST REGISTRATION NO: <?= $hdr->gst_reg_no ?></p> -->
                    <table>
                        <!-- <tr> -->
                        <!-- <td>INVOICE NO</td>
                            <td>:</td>
                            <td> <?= $hdr->inv_no ?></td>
                        </tr> -->
                        <!-- <tr>
                            <td>DATE</td>
                            <td>:</td>
                            <td><?= tgl_mdy($hdr->shipment_date) ?></td>
                        </tr>
                        <tr>
                            <td>A/C CODE</td>
                            <td>:</td>
                            <td> <?= $hdr->ac_code ?></td>
                        </tr> -->
                        <tr>
                            <td>CREDIT TERM</td>
                            <td>:</td>
                            <td> <?= $hdr->credit_term ?></td>
                        </tr>
                        <tr>
                            <td>Page No</td>
                            <td>:</td>
                            <td>1 OF 1</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="voyage">
            <tr>
                <td width="20%">VESSEL/VOYAGE NO</td>
                <td width="1%">:</td>
                <td> <?= $hdr->vesel . '/' . $hdr->voyage_no ?></td>
            </tr>
            <tr>
                <td>PORT OF LOADING/DISCHARGE</td>
                <td>:</td>
                <td> <?= $hdr->port_of_load ?></td>
            </tr>
            <tr>
                <td>SHIPPED ON BOARD DATE</td>
                <td>:</td>
                <td> <?= $hdr->ship_board_date ?></td>
            </tr>
        </table>
        <table class="list" border="1">
            <tr>
                <td widtd="10px">ITEM</td>
                <td>JO REF</td>
                <td>Type</td>
                <td>POD</td>
                <td>UOM</td>
                <td>Description</td>
                <td>Freight PER M.T</td>
                <td>Unit Price <br> (SGD)</td>
                <td>QTY</td>
                <td>Amount <br> (SGD)</td>
            </tr>

            <?php
            if ($dtls) {
                $no = 1;
                foreach ($dtls as  $dtl) { ?>
                    <tr>
                        <?php
                        if ($dtl->head == '1') { ?>
                            <td rowspan="<?= $dtl->row ?>">
                                <?= $no++ ?>
                            </td>
                            <td rowspan="<?= $dtl->row ?>" class="text-left">
                                <?= $dtl->jo_ref ?>
                            </td>
                            <td rowspan="<?= $dtl->row ?>" class="text-left">
                                <?= $dtl->con_type_name ?>
                            </td>
                            <td rowspan="<?= $dtl->row ?>">
                                <?php
                                $pod = explode('-', $dtl->pod);
                                echo $pod[0] . '<br>' . $pod[1];
                                ?>
                            </td>
                            <td>
                                <?= $dtl->uom ?>
                            </td>
                            <td class=" text-left">
                                <?= $dtl->description ?>
                            </td>
                            <td>
                                <?= $dtl->freight_per_mt  ?>
                            </td>
                            <td class="text-right">
                                <?= number_format($dtl->unit_price, 2) ?>
                            </td>
                            <td>
                                <?= $dtl->qty ?>
                            </td>
                            <td class="text-right">
                                <?= number_format($dtl->amount, 2) ?>
                            </td>
                        <?php
                        } else { ?>
                            <td>
                                <?= $dtl->uom ?>
                            </td>
                            <td class="text-left">
                                <?= $dtl->description ?>
                            </td>
                            <td>
                                <?= $dtl->freight_per_mt  ?>
                            </td>
                            <td class="text-right">
                                <?= number_format($dtl->unit_price, 2) ?>
                            </td>
                            <td>
                                <?= $dtl->qty ?>
                            </td>
                            <td style="text-align: right;">
                                <?= number_format($dtl->amount, 2) ?>
                            </td>

                        <?php

                        }

                        ?>

                    </tr>
            <?php
                }
            }
            ?>
            <tr>
                <td colspan="8" style="border-bottom: none;"></td>
                <td style="text-align: left;">TOTAL</td>
                <td style="text-align: right;"> <?= number_format($hdr->total_amount, 2) ?></td>
            </tr>
            <tr>
                <td colspan="8" style="border-bottom: none; border-top:none;"></td>
                <td style="text-align: left;">ADD: GST AT 8%</td>
                <td style="text-align: right;"><?= number_format($hdr->gst_value, 2) ?></td>
            </tr>
            <tr>
                <td colspan="8" style="border-top:none;"></td>
                <td style="text-align: left;">AMOUNT DUE</td>
                <td style="text-align: right;"><?= number_format($hdr->amount_due, 2) ?></td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: left; border-bottom:none">
                    <p>For cheque payment: please ensure the cheques is made payable to "ZHENGHE LOGISTIC PTE LTD" and crossed A/C Payee only.</p>
                    <p> FOR REMITTANCE: PLEASE REMIT TO OUR NEW ACCOUNT IN OCBC BANK AS FOLLOWS:</p>
                </td>
            </tr>
            <tr>
                <td colspan="10" style="border-top:none">
                    <!-- <table>
                        <tr>
                            <td>Bank</td>
                            <td>:</td>
                            <td>OCBC BANK</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>65 CHULIA STREET, OCBC CENTRE</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>SINGAPORE 0495513</td>
                        </tr>
                        <tr>
                            <td>Account Info</td>
                            <td>:</td>
                            <td>629-364613 001</td>
                        </tr>
                        <tr>
                            <td>Favouring</td>
                            <td>:</td>
                            <td>SINDO DAMAI SHIPPING PTE LTD</td>
                        </tr>
                        <tr>
                            <td>Swift Code</td>
                            <td>:</td>
                            <td>OCBCCSG5G</td>
                        </tr>
                    </table> -->
                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: left; border-right:none">
                    <p>* Interest at 2% per month will be levied on any outstanding amount for exceeding the credit granted from the date of this bill</p>
                    <h2>ALERT</h2>
                    <h2>No payment to 3rd party accounts. Please call ZHL Marketing independently to check if in doubt.</h2>
                </td>
                <td colspan="3" style="vertical-align:bottom; border-left:none">
                    <!-- <hr>
                    <p>SINDO DAMAI SHIPPING PTE.LTD</p> -->
                </td>
            </tr>
        </table>
    </section>
    <section class="footer">
        <!-- <p>180B Becoolen Street, #09-03/04/05, The Bencoolen, Singapore 189648</p> -->
        <!-- <p>* Tel: +65 6334 5100 * Fax +65 6334 5130</p> -->
    </section>

</body>

</html>