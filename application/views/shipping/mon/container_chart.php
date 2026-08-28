<?php
$po_number = $this->input->get("po_number");
$id = $this->input->get("id_sn_truck");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .caption{
        font-weight: bolder;
    }

    #loadingMessage {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }
</style>

<div class="page-content">
    <div class="container">
        <div class="row">
        <!-- ini untuk search date / filter -->
        <div class="col-md-6">
                <div class="portlet light">
                    <!-- ini untuk search -->
                    <div class="portlet-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group" style="margin-left: 20px;">
                                        <div style="display: flex; flex-direction: column">
                                            <div style="display: flex;">
                                                <label class="col-md-4">Shipment Date</label>
                                                <div class="col-md-8">
                                                    <input class="form-control input-sm date date-picker" name="shipmentdate" id="shipmentdate" data-date-format="yyyy-mm-dd" required>
                                                </div>
                                            </div>

                                            <div style="display: flex;">
                                                <label class="col-md-4">Factory</label>
                                                <div class="col-md-8">
                                                    <select class="form-control select2me" name="factory_abbr" id="factory_abbr" data-placeholder="Please select">
                                                        <option value=""></option>
                                                        <option value="RSUP">PT RIAU SAKTI UNITED PLANTATIONS</option>
                                                        <option value="PSG">PT SAMBU GUNTUNG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="text-align: right;">
                                                <button type="submit" id="filterBtn" class="btn blue fontawesome-font btn-refresh"><span class="fa fa-filter"></span> Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        <!-- ini tutup untuk search atau filter -->
         <!-- ini untuk sambu rsup  -->
            <!-- <div class="col-md-6">
                <div class="portlet light">
                    <div class="portlet-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="caption">
                                        <span class="caption-subject font-blue-sharp" >Container Inward/Outward Chart PT. Riau Sakti United Plantation</span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row" style="text-align: center; margin-left: 3%; margin-right: 3%; margin-top: 10%;">
                                    <div class="col-md-6">
                                        <div class="caption" style="margin-bottom: 5px; text-align: left;">
                                            <span class="caption-subject font-blue-sharp" >Inward</span>
                                        </div>

                                        <canvas id="myChartPieRSUP" name="myChartPieRSUP"  width="100" height="100"></canvas>
                                        <div id="loadingMessage" style="display: none;">
                                            <p>Mohon tunggu...</p>
                                            <p>Sedang Memuat Chart</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="caption" style="margin-bottom: 5px; text-align: left;">
                                            <span class="caption-subject font-blue-sharp" >Outward</span>
                                        </div>

                                        <canvas id="myChartDoughnutRSUP" name="myChartDoughnutRSUP" width="100" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div> -->

            <!-- ini untuk sambu guntung  -->
            <div class="col-md-6">
                <div class="portlet light">
                    <!-- ini untuk search -->
                    <div class="portlet-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="caption">
                                        <span class="caption-subject font-blue-sharp">Container Inward/Outward Chart <span id="company_name"></span></span>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row" style="text-align: center; margin-left: 3%; margin-right: 3%; margin-top: 5%;">
                                    <div class="col-md-6">
                                        <div class="caption" style="margin-bottom: 5px; text-align: left;">
                                            <span class="caption-subject font-blue-sharp" >Inward</span>
                                        </div>

                                        <canvas id="myChartPieInward" name="myChartPieInward" width="50" height="50"></canvas>

                                        <div id="loadingMessage" style="display: none;">
                                            <p>Mohon tunggu...</p>
                                            <p>Sedang Memuat Chart</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="caption" style="margin-bottom: 5px; text-align: left;">
                                            <span class="caption-subject font-blue-sharp" >Outward</span>
                                        </div>

                                        <canvas id="myChartDoughnutOutward" name="myChartDoughnutOutward" width="50" height="50"></canvas>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var usedColors = {};

    function getRandomColor() {
        var colors = [
            'rgba(255, 99, 132, 0.5)', 
            'rgba(54, 162, 235, 0.5)', 
            'rgba(255, 206, 86, 0.5)', 
            'rgba(75, 192, 192, 0.5)', 
            'rgba(153, 102, 255, 0.5)', 
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 0, 0, 0.5)',
            'rgba(0, 255, 0, 0.5)', 
            'rgba(0, 0, 255, 0.5)',
            'rgba(255, 255, 0, 0.5)',
            'rgba(128, 0, 128, 0.5)', 
            'rgba(0, 255, 255, 0.5)',
        ];
        var randomIndex;
        var randomColor;

        do {
            randomIndex = Math.floor(Math.random() * colors.length);
            randomColor = colors[randomIndex];
        } while (usedColors[randomColor]);

        usedColors[randomColor] = true;

        return randomColor;
    }

    var shipmentdate = document.getElementById('shipmentdate').value;
    var factory = document.getElementById('factory_abbr').value;
        
    $.ajax({
        type: "GET",
        url: "<?php echo base_url('Shipping_mon/container_chart'); ?>",
        data: {
            'shipmentdate': shipmentdate,
            'factory_abbr': factory
        },
        beforeSend: function() {
            $('#loadingMessage').show();
        },
        success: function(response) {
            $('#loadingMessage').hide();

            var ctx1 = document.getElementById('myChartPieInward').getContext('2d');
            var ctx2 = document.getElementById('myChartDoughnutOutward').getContext('2d');
            // var ctx3 = document.getElementById('myChartPiePSG').getContext('2d');
            // var ctx4 = document.getElementById('myChartDoughnutPSG').getContext('2d');

            var cont_chart_in = <?php echo json_encode($cont_chart_inward); ?>;
            var cont_chart_out = <?php echo json_encode($cont_chart_outward); ?>;

            createChart(ctx1, cont_chart_in, 'pie');
            createChart(ctx2, cont_chart_out, 'doughnut');
            // createChart(ctx3, cont_chart_psg_in, 'pie');
            // createChart(ctx4, cont_chart_psg_out, 'doughnut');
        }
    });

    function createChart(ctx, data, type) {
        var stuffingCounts = {};
        var colorMap = {};

        for (var i = 0; i < data.length; i++) {
            var stuffingName = data[i].stuffing_name;
            var containerAbbr = data[i].container_abbr;
            var c20 = parseInt(data[i].c20);
            var c40 = parseInt(data[i].c40);

            var containerCounts = {
                c20: c20,
                c40: c40
            };

            if (!stuffingCounts[stuffingName]) {
                stuffingCounts[stuffingName] = {};
            }

            if (!stuffingCounts[stuffingName][containerAbbr]) {
                stuffingCounts[stuffingName][containerAbbr] = containerCounts;
            } else {
                stuffingCounts[stuffingName][containerAbbr].c20 += c20;
                stuffingCounts[stuffingName][containerAbbr].c40 += c40;
            }

            if (!colorMap[stuffingName]) {
                colorMap[stuffingName] = {};
                colorMap[stuffingName]['c20'] = getRandomColor();
                colorMap[stuffingName]['c40'] = getRandomColor();
            }
        }

        var labels = [];
        var chartData = [];
        var backgroundColor = [];
        var borderColor = [];

        for (var stuffingName in stuffingCounts) {
            for (var containerAbbr in stuffingCounts[stuffingName]) {
                var countC20 = stuffingCounts[stuffingName][containerAbbr].c20;
                var countC40 = stuffingCounts[stuffingName][containerAbbr].c40;

                if (countC20 > 0) {
                    labels.push(stuffingName + ' (' + containerAbbr + ' c20)');
                    chartData.push(countC20);
                    backgroundColor.push(colorMap[stuffingName]['c20']);
                    borderColor.push(colorMap[stuffingName]['c20']);
                }

                if (countC40 > 0) {
                    labels.push(stuffingName + ' (' + containerAbbr + ' c40)');
                    chartData.push(countC40);
                    backgroundColor.push(colorMap[stuffingName]['c40']);
                    borderColor.push(colorMap[stuffingName]['c40']);
                }
            }
        }

        var chartType = type === 'pie' ? 'pie' : 'doughnut';

        var myChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total',
                    data: chartData,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {}
        });
    }

    
    
</script>

<!-- <script>
    var usedColors = {};

    function getRandomColor() {
        var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'];
        var randomIndex;
        var randomColor;

        do {
            randomIndex = Math.floor(Math.random() * colors.length);
            randomColor = colors[randomIndex];
        } while (usedColors[randomColor]);

        usedColors[randomColor] = true;

        return randomColor;
    }

    var shipmentdate = document.getElementById('shipmentdate').value;

    $.ajax({
        type: "GET",
        url: "<?php echo base_url('Shipping_mon/container_chart'); ?>",
        data: {
            'shipmentdate': shipmentdate
        },
        beforeSend: function() {
            $('#loadingMessage').show();
        },
        success: function(response) {
            $('#loadingMessage').hide();
            var ctx = document.getElementById('myChartPieRSUP').getContext('2d');
            var contChart = <?php echo json_encode($cont_chart_rsup_inward); ?>;
            var stuffingCounts = {};
            var colorMap = {};

            for (var i = 0; i < contChart.length; i++) {
                var stuffingName = contChart[i].stuffing_name;
                var containerAbbr = contChart[i].container_abbr;
                var c20 = parseInt(contChart[i].c20);
                var c40 = parseInt(contChart[i].c40);

                var containerCounts = {
                    c20: c20,
                    c40: c40
                };

                if (!stuffingCounts[stuffingName]) {
                    stuffingCounts[stuffingName] = {};
                }

                if (!stuffingCounts[stuffingName][containerAbbr]) {
                    stuffingCounts[stuffingName][containerAbbr] = containerCounts;
                } else {
                    stuffingCounts[stuffingName][containerAbbr].c20 += c20;
                    stuffingCounts[stuffingName][containerAbbr].c40 += c40;
                }

                if (!colorMap[stuffingName]) {
                    colorMap[stuffingName] = {};
                    colorMap[stuffingName]['c20'] = getRandomColor();
                    colorMap[stuffingName]['c40'] = getRandomColor();
                }
            }

            var labels = [];
            var data = [];
            var backgroundColor = [];
            var borderColor = [];

            for (var stuffingName in stuffingCounts) {
                for (var containerAbbr in stuffingCounts[stuffingName]) {
                    var countC20 = stuffingCounts[stuffingName][containerAbbr].c20;
                    var countC40 = stuffingCounts[stuffingName][containerAbbr].c40;

                    if (countC20 > 0) {
                        labels.push(stuffingName + ' (' + containerAbbr + ' c20)');
                        data.push(countC20);
                        backgroundColor.push(colorMap[stuffingName]['c20']);
                        borderColor.push(colorMap[stuffingName]['c20']);
                    }

                    if (countC40 > 0) {
                        labels.push(stuffingName + ' (' + containerAbbr + ' c40)');
                        data.push(countC40);
                        backgroundColor.push(colorMap[stuffingName]['c40']);
                        borderColor.push(colorMap[stuffingName]['c40']);
                    }
                }
            }

            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {}
            });

        }
    });
</script> -->

<!-- <script>
    var usedColors = {};

    function getRandomColor() {
        var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'];
        var randomIndex;
        var randomColor;

        do {
            randomIndex = Math.floor(Math.random() * colors.length);
            randomColor = colors[randomIndex];
        } while (usedColors[randomColor]);

        usedColors[randomColor] = true;

        return randomColor;
    }

    var shipmentdate = document.getElementById('shipmentdate').value;

    $.ajax({
        type: "GET",
        url: "<?php echo base_url('Shipping_mon/container_chart'); ?>",
        data: {
            'shipmentdate': shipmentdate
        },
        beforeSend: function() {
            $('#loadingMessage').show();
        },
        success: function(response) {
            $('#loadingMessage').hide();
            var ctx = document.getElementById('myChartDoughnutRSUP').getContext('2d');
            var contChart = <?php echo json_encode($cont_chart_rsup_outward); ?>;
            var stuffingCounts = {};
            var colorMap = {};

            for (var i = 0; i < contChart.length; i++) {
                var stuffingName = contChart[i].stuffing_name;
                var containerAbbr = contChart[i].container_abbr;
                var c20 = parseInt(contChart[i].c20);
                var c40 = parseInt(contChart[i].c40);

                var containerCounts = {
                    c20: c20,
                    c40: c40
                };

                if (!stuffingCounts[stuffingName]) {
                    stuffingCounts[stuffingName] = {};
                }

                if (!stuffingCounts[stuffingName][containerAbbr]) {
                    stuffingCounts[stuffingName][containerAbbr] = containerCounts;
                } else {
                    stuffingCounts[stuffingName][containerAbbr].c20 += c20;
                    stuffingCounts[stuffingName][containerAbbr].c40 += c40;
                }

                if (!colorMap[stuffingName]) {
                    colorMap[stuffingName] = {};
                    colorMap[stuffingName]['c20'] = getRandomColor();
                    colorMap[stuffingName]['c40'] = getRandomColor();
                }
            }

            var labels = [];
            var data = [];
            var backgroundColor = [];
            var borderColor = [];

            for (var stuffingName in stuffingCounts) {
                for (var containerAbbr in stuffingCounts[stuffingName]) {
                    var countC20 = stuffingCounts[stuffingName][containerAbbr].c20;
                    var countC40 = stuffingCounts[stuffingName][containerAbbr].c40;

                    if (countC20 > 0) {
                        labels.push(stuffingName + ' (' + containerAbbr + ' c20)');
                        data.push(countC20);
                        backgroundColor.push(colorMap[stuffingName]['c20']);
                        borderColor.push(colorMap[stuffingName]['c20']);
                    }

                    if (countC40 > 0) {
                        labels.push(stuffingName + ' (' + containerAbbr + ' c40)');
                        data.push(countC40);
                        backgroundColor.push(colorMap[stuffingName]['c40']);
                        borderColor.push(colorMap[stuffingName]['c40']);
                    }
                }
            }

            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {}
            });

        }
    });
</script> -->
<!-- ini untuk doughnut RSUP -->
<!-- Ini chart Doughnut PSG -->