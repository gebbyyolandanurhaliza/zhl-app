<!-- timeline css -->
<style>
  @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600');

  body {
    padding: 0;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
  }

  h1 {
    font-size: 60px;
    text-align: center;
  }

  .timeline {
    position: relative;
    margin: 50px auto;
    padding: 40px 0;
    width: 1000px;
    box-sizing: border-box;
  }

  .timeline:before {
    content: '';
    position: absolute;
    left: 50%;
    width: 2px;
    height: 100%;
    background: #5E87B0;
  }

  .timeline ul {
    padding: 0;
    margin: 0;
  }

  .timeline ul li {
    list-style: none;
    position: relative;
    width: 50%;
    padding: 20px 40px;
    box-sizing: border-box;
  }

  .timeline ul li:nth-child(odd) {
    float: left;
    text-align: right;
    clear: both;
  }

  .timeline ul li:nth-child(even) {
    float: right;
    text-align: left;
    clear: both;
  }

  .content {
    padding-bottom: 20px;
  }

  .timeline ul li:nth-child(odd):before {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    top: 24px;
    right: -6px;
    background: rgba(233, 33, 99, 1);
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(233, 33, 99, 0.2);
  }

  .timeline ul li:nth-child(even):before {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    top: 24px;
    left: -4px;
    background: rgba(233, 33, 99, 1);
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(233, 33, 99, 0.2);
  }

  .timeline ul li h3 {
    padding: 0;
    margin: 0;
    color: rgba(94, 135, 176, 1);
    font-weight: 600;
  }

  .timeline ul li p {
    margin: 10px 0 0;
    padding: 0;
  }

  .timeline ul li .time h4 {
    margin: 0;
    padding: 0;
    font-size: 14px;
  }

  .timeline ul li:nth-child(odd) .time {
    position: absolute;
    top: 12px;
    right: -165px;
    margin: 0;
    padding: 8px 16px;
    background: rgba(94, 135, 176, 1);
    color: #fff;
    border-radius: 18px;
    box-shadow: 0 0 0 3px rgba(94, 100, 190, 1);
  }

  .timeline ul li:nth-child(even) .time {
    position: absolute;
    top: 12px;
    left: -165px;
    margin: 0;
    padding: 8px 16px;
    background: rgba(94, 135, 176, 1);
    color: #fff;
    border-radius: 18px;
    box-shadow: 0 0 0 3px rgba(94, 100, 190, 1);
  }

  @media(max-width:1000px) {
    .timeline {
      width: 100%;
    }
  }

  @media(max-width:767px) {
    .timeline {
      width: 100%;
      padding-bottom: 0;
    }

    h1 {
      font-size: 40px;
      text-align: center;
    }

    .timeline:before {
      left: 20px;
      height: 100%;
    }

    .timeline ul li:nth-child(odd),
    .timeline ul li:nth-child(even) {
      width: 100%;
      text-align: left;
      padding-left: 50px;
      padding-bottom: 50px;
    }

    .timeline ul li:nth-child(odd):before,
    .timeline ul li:nth-child(even):before {
      top: -18px;
      left: 16px;
    }

    .timeline ul li:nth-child(odd) .time,
    .timeline ul li:nth-child(even) .time {
      top: -30px;
      left: 50px;
      right: inherit;
    }
  }

  .highlight {
    background-color: red;
  }
</style>

<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">Monitoring Local Track Container</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="fullscreen"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="form-body">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="col-md-3 label-sm">Shipment Date</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control input-sm date-picker" data-date="02-12-2023" data-date-format="dd-mm-yyyy" name="shipmentDate" value="<?php echo date("d-m-Y"); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" id="ref">
                      <div class="form-group">
                        <label class="col-md-3 label-sm" id="lbl1">Container Number</label>
                        <div class="col-md-6">
                          <input class="form-control input-sm" name="containerNumber" type="text" value="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary col-md-2 btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <br>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="table-scrollable" style="overflow: auto; height: 550px;">
                    <div class="">
                      <table class="table table-striped table-hover list-container">
                        <tbody>

                        </tbody>
                      </table>

                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <div class="table-scrollable timeline-shipment" style="overflow: auto; height: 550px;">
                    <div class="loading" style="display: flex; align-items: center; justify-content: center;"></div>
                    <div class="load-timeline"></div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script>
  function getHistoryShipment(containerNumber) {
    $.ajax({
      url: "<?php echo base_url('shipping_mon/filter_local_track_container'); ?>",
      type: "GET",
      data: {
        'containerNumber': containerNumber,
        'limit': 10
      },
      dataType: "JSON",
      beforeSend: function() {
        $('.timeline-shipment .loading').html("<h2>Loading ...</h2>");
        $(".timeline-shipment .load-timeline").empty();
      },
      success: function(response) {
        console.log(response)
        setTimeout(() => {
          if (response) {

            var data = '<div class="timeline">'; // Initialize outside the loop
            data += `<ul>`


            $.each(response, function(i, val) {
              data += `<li>`
              data += `<div class="content">`
              data += `<h3>${val.container_number} <small class="badge badge-primary">${val.tipe == 1 ? "Outward" : "Inward "}</small></h3><hr>`
              data += `<p>ETA : ${val.eta}</p>`
              data += `<p>ETA DATE : ${dateFormat(val.etadate)}</p><hr>`
              data += `<p>ETD : ${val.etd}</p>`
              data += `<p>ETD DATE : ${dateFormat(val.etddate)}</p><hr>`
              data += `<p>FROM : ${val.from}</p>`
              data += `<p>TO : ${val.to}</p><hr>`
              data += `</div>`
              data += `<div class="time">`
              data += `<h4>${dateFormat(val.shipmentdate)}</h4>`
              data += `</div>`
              data += `</li>`
            });

            data += `<div style="clear:both;"></div>`
            data += `</ul>`
            data += `</div>`

            // Append the containerNumber to the element with class "list-container"
            $(".timeline-shipment .load-timeline").append(data);

          }
        }, 1500);

      },
      complete: function() {
        setTimeout(() => {

          $('.btn-refresh').html('<i class="fa fa-refresh"></i> Refresh').prop('disabled', false);
          $('.timeline-shipment .loading').html("");

        }, 1500);

      }
    });
  }

  $(".btn-refresh").click(function() {
    var shipmentDate = $('input[name="shipmentDate"').val()
    var containerNumber = $('input[name="containerNumber"').val()
    $.ajax({
      url: "<?php echo base_url('shipping_mon/filter_local_track_container'); ?>",
      type: "GET",
      data: {
        'shipmentDate': shipmentDate,
        'containerNumber': containerNumber,
        'tipe': 1
      },
      dataType: "JSON",
      beforeSend: function() {
        $('.btn-refresh').html("Loading ...").prop('disabled', true);
        $(".list-container tbody").empty();
        $(".timeline-shipment .load-timeline").empty();
      },
      success: function(response) {

        console.log(response)
        setTimeout(() => {
          if (response) {

            var data = ''; // Initialize outside the loop

            $.each(response, function(i, val) {
              console.log(val);
              data += `<tr><td onclick='getHistoryShipment("${val.container_number}")' style="cursor: grab;">${val.container_number}</td></tr>`;
            });

            // Append the containerNumber to the element with class "list-container"
            $(".list-container tbody").append(data);

          }
        }, 1500);

      },
      complete: function() {
        setTimeout(() => {

          $('.btn-refresh').html('<i class="fa fa-refresh"></i> Refresh').prop('disabled', false);
        }, 1500);

      }
    });

  })

  function dateFormat(date) {
    var specificDate = new Date(date);

    // Format the specific date to 'dd/mm/yyyy' format
    var day = specificDate.getDate();
    var month = specificDate.getMonth() + 1; // Months are zero-based
    var year = specificDate.getFullYear();

    // Ensure two-digit format for day and month
    day = (day < 10) ? '0' + day : day;
    month = (month < 10) ? '0' + month : month;

    var formattedSpecificDate = day + '/' + month + '/' + year;

    return formattedSpecificDate;
  }
</script>