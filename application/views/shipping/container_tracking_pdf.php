<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        * {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        }

        .kepala {
            text-align: center;
        }

        .kepala h3 {
            margin: 0;
        }

        .kepala p {
            margin: 0 0 10px 0;
        }

        .body {
            font-size: 9px;
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

        div.page_break+div.page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <?php foreach ($listData as $item) : ?>
        <div class="page_break">
            <section class="kepala">
                <h3> ZHENGHE LOGISTIC PTE. LTD</h3>
                <p>LIST OF TRACKING CONTAINER</p>
            </section>
            <hr>
            <section class="body">
                <table class="alamat">
                    <tr>
                        <!-- <td width="60%">
                    <p>Zhenghe Logistics Pte Ltd</p>
                    <p>75 Bukit Timah Road, #05-01</p>
                    <p>Boon Siew Building</p>
                    <p>Singapore 229833</p>
                    <p>Attn: Acoount Team</p>
                </td> -->
                        <td width="40%">
                            <!-- <p>GST REGISTRATION NO: 201014756W</p> -->
                            <table>
                                <tr>
                                    <td>Barge</td>
                                    <td>:</td>
                                    <td><?= $item->barge ?></td>
                                </tr>
                                <tr>
                                    <td>Voyage</td>
                                    <td>:</td>
                                    <td><?= $item->voyage ?></td>
                                </tr>
                                <tr>
                                    <td>Shipment Date</td>
                                    <td>:</td>
                                    <td><?= date("d/m/Y", strtotime($item->shipmentdate))  ?></td>
                                </tr>
                                <tr>
                                    <td>Eta</td>
                                    <td>:</td>
                                    <td><?= $item->eta ?></td>
                                </tr>
                                <tr>
                                    <td>Eta Date</td>
                                    <td>:</td>
                                    <td><?= date("d/m/Y", strtotime($item->etddate))  ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- <table class="voyage">
                    <tr>
                        <td width="20%">VESSEL/VOYAGE NO</td>
                        <td width="1%">:</td>
                        <td>BINA MARINE 80 V 57SN</td>
                    </tr>
                    <tr>
                        <td>PORT OF LOADING/DISCHARGE</td>
                        <td>:</td>
                        <td>SINGAPORE/PULAU BURUNG/SINGAPORE</td>
                    </tr>
                    <tr>
                        <td>SHIPPED ON BOARD DATE</td>
                        <td>:</td>
                        <td>10-JUNI-21, PULAU BURUNG</td>
                    </tr>
                </table> -->
                <table class="list" border="1">
                    <tr>
                        <td>No</td>
                        <td>STUFFING</td>
                        <td>CONTAINER NUMBER</td>
                        <td>CONTAINER TYPE</td>
                        <td>STATUS</td>
                        <td>RECEIVED BY</td>
                        <td>RECEIVED DATE</td>
                        <!-- <td>UNIT PRICE <br> (SGD)</td> -->
                        <!-- <td>AMOUNT <br> (SGD)</td> -->
                    </tr>
                    <!-- <tr>
                        <td>1</td>
                        <td colspan="7" style="text-align: left;">OUTWARD - SGP TO BURUNG (40' RF EMPTY)</td>
                    </tr> -->
                    <?php foreach ($item->det_local as $key => $det) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $det->stuffing ?></td>
                            <td><?= $det->container_number ?></td>
                            <td><?= $det->container_type ?></td>
                            <td><?= $det->status_received ?></td>
                            <td><?= $det->receive_by ?></td>
                            <td><?= setDateFormat($det->receive_date, "d/m/Y")  ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>

                <table style="text-align: center; width:100%; margin-top:30px">
                    <tr>
                        <td>180 Bencoolen Street, #09-03/04/05, The Bencoolen, Singapore 189648 <br> Telp: 65 6334 5100. Fax: +65 6334 5430</td>
                    </tr>
                </table>
            </section>
        </div>
    <?php endforeach ?>

</body>

</html>