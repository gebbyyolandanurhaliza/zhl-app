<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<link href="<?php echo base_url(); ?>assets/admin/pages/css/chat-ismo.css" rel="stylesheet" type="text/css" />
<style>
  .item:nth-child(1) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0001.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;

  }

  .item:nth-child(2) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0002.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(3) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0004.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(4) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0006.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(5) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0016.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(6) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0020.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(7) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0026.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }

  .item:nth-child(8) {
    background: url('<?= base_url("images/4. ZHL PPT GFS - 06.12.23 (1)_page-0027.jpg") ?>');
    background-size: cover;
    background-size: 100% 100%;
    background-position: center center;
    background-repeat: no-repeat;
  }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYdGw9exOCnJo2HnCoj1cymm3kHO9WnqU&callback=initMap" async defer></script>
<?php
$locations = [
  ['lat' => 1.24753630161285, 'lng' => 103.7164306640625],
  ['lat' => -34.398, 'lng' => 150.645],
  ['lat' => -34.399, 'lng' => 150.646],
  ['lat' => -34.400, 'lng' => 150.647],
  ['lat' => -34.401, 'lng' => 150.648],
  ['lat' => -34.402, 'lng' => 150.649],
  ['lat' => -34.403, 'lng' => 150.650],
  ['lat' => -34.404, 'lng' => 150.651],
  ['lat' => -34.405, 'lng' => 150.652],
  ['lat' => 21.461389541625977, 'lng' => 39.11595916748047],
  // Tambahkan lebih banyak lokasi sesuai kebutuhan
];


?>
<script>
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 3,
      center: {
        lat: 1.24753630161285,
        lng: 103.7164306640625
      } // Pusat peta
    });

    var locations = <?php echo json_encode($locations); ?>;
    var flightPathCoordinates = [];

    locations.forEach(function(location) {
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(location.lat, location.lng),
        map: map
      });
    });
    // locations.forEach(function(location) {
    //     var position = new google.maps.LatLng(location.lat, location.lng);
    //     flightPathCoordinates.push(position);

    //     var marker = new google.maps.Marker({
    //         position: position,
    //         map: map
    //     });
    // });

    var flightPath = new google.maps.Polyline({
      path: flightPathCoordinates,
      geodesic: true,
      strokeColor: '#FF0000',
      strokeOpacity: 1.0,
      strokeWeight: 2
    });

    flightPath.setMap(map);
  }
</script>



<div class="page-content">
  <div class="container">
    <!-- <div class="alert alert-info">Welcome To Zhenghe Logistic System</div> -->
    <p><strong><i class="fa fa-bullhorn"></i> Exchange Rate Information</strong></p>
    <div class="marquee">
      <p class="marquee-content">
        <?php foreach ($kurs as $kurs) :
          $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        ?>
          <b style="color: <?= $randomColor ?>; font-weight:900; font-size: 14px;"><?= $kurs->currency_id ?></b>&nbsp; ( <?= "SGD : " . $kurs->rate_kurs ?> | <?= "USD : " . $kurs->rate_usd ?> ) &nbsp;
        <?php endforeach ?>

    </div>


    <!-- SLIDER -->


    <!-- END SLIDER -->

    <div class="row margin-top-10">

      <div class="col-md-8">
        <div class="portlet light">
          <div class="portlet-body">
            <div id="carouselFade" class="carousel slide carousel-fade" data-ride="carousel" style="height: 70%">
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <div class="carousel-caption">
                  </div>
                </div>
                <?php for ($i = 1; $i <= 7; $i++) : ?>
                  <div class="item">
                    <div class="carousel-caption">
                    </div>
                  </div>
                <?php endfor; ?>

              </div>

              <a class="left carousel-control" href="#carouselFade" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carouselFade" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption caption-md"></div>

            <select class="form-control" id="shipmentDate" style="border-radius: 5px; width: 300px;" onchange="changeShipment()">
              <option disabled selected>Pease Select Shipment</option>
              <?php foreach ($getListShipmentDate as $key => $value) : ?>
                <option value="<?= $value->shipmentdate ?>"><?= $value->shipmentdate ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="portlet-body" style=" align-items: center; justify-content: center;">
            <div id="myChart" style="padding: 0px; margin: 0px; height: 27%;"></div>
          </div>

        </div>
      </div>

      <div class="col-md-4">
        <div class="portlet light">
          <div class="portlet-body">
            <div id="map" style="height: 30%; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>



</div>

</div>
</div>

<!-- <slider -->
<script>
  $(document).ready(function() {
    $('#carouselFade').carousel();
  });
</script>
<!-- end slider -->

<!-- <script defer>
                        $(setInterval(function() {
                            $('#body').load('<?php echo base_url(); ?>home/viewMessageNew'),
                                $('#body').attr({
                                    scrollBottom: $('#body').attr('scrollHeight')
                                });
                        }, 500));
                        $(setInterval(function() {
                            var objDiv = document.getElementById("body");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 6000));
                    </script>
                    <script>
                        jQuery(function($) {
                            $('.popover-markup>.trigger').popover({
                                html: true,
                                title: function() {
                                    return $(this).parent().find('.head').html();
                                },
                                content: function() {
                                    return $(this).parent().find('.content').html();
                                }
                            });
                        });
                    </script>
                    <script defer>
                        $(function() {
                            $('.error').hide();
                            $('.sukses').hide();
                            $('#btnSend').click(function() {
                                var isipesan = $('#txtMessage').val();

                                if (isipesan === '') {
                                    $('.error').show();
                                    $('.sukses').hide();
                                    return false;
                                }

                                var strdata = 'txtMessage=' + isipesan;

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>Home/sendMessage',
                                    data: strdata,
                                    success: function() {
                                        $('#txtMessage').val('');
                                        $('.sukses').show();
                                        $('.error').hide();
                                        $('#body').attr({
                                            scrollBottom: $('#body').attr('scrollHeight')
                                        });
                                    }
                                });
                            });
                        });
                    </script> -->
<!-- <script>
                        $('#txtMessage').on('keydown', function(e) {
                            if (e.which == 13) {
                                e.preventDefault();
                                var isipesan = $('#txtMessage').val();

                                if (isipesan === '' || isipesan === ' ') {
                                    $('.error').show();
                                    $('.sukses').hide();
                                    return false;
                                }

                                var strdata = 'txtMessage=' + isipesan;

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>Home/sendMessage',
                                    data: strdata,
                                    success: function() {
                                        $('#txtMessage').val('');
                                        $('.sukses').show();
                                        $('.error').hide();
                                        $('#body').attr({
                                            scrollBottom: $('#body').attr('scrollHeight')
                                        });
                                    }
                                });

                                this.value = null;
                            }
                        });
                    </script> -->


<script>
  function changeShipment() {
    var shipmentDate = $('#shipmentDate').val();

    getStatShipmentByContainerType(shipmentDate);
  }

  $(document).ready(function() {

    getStatShipmentByContainerType('2023-12-19');

  });

  function getStatShipmentByContainerType(shipmentDate) {
    $.ajax({
      url: '<?php echo site_url('Shipping/get_count_shipment_by_container_type'); ?>',
      type: 'GET',
      dataType: 'json',
      data: {
        'shipmentDate': shipmentDate
      },
      beforeSend: function() {
        $('#myChart').empty();
      },
      success: function(data) {
        console.log(data);
        Morris.Donut({
          element: 'myChart',
          data: data
        });
      },
      complete: function() {
        // $('#myChartLoading').html('');
      }
    });
  }
</script>























<!-- <link href="<?php echo base_url(); ?>assets/admin/pages/css/chat-ismo.css" rel="stylesheet" type="text/css" />
<style>
    .fixed-content {
        min-height: 300px;
        max-height: 300px;
        overflow-y: scroll;
    }

    .fixed-content-1 {
        min-height: 358px;
        max-height: 358px;
    }

    .fixed-content-2 {
        min-height: 368px;
        max-height: 368px;
        overflow-y: scroll;
    }
</style>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Dashboard <small>Welcome to ZHL Apps</small></h1>
            <div class="CekSecretKey" id="CekSecretKey" hidden><?php echo $this->session->flashdata('message'); ?></div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">

        <div class="row margin-top-10">
            <div class="col-md-4">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Last Rate Period <?php echo date('d-m-Y', strtotime($periode)); ?></span>
                        </div>
                    </div>
                    <div class="portlet-body fixed-content-1">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr class="uppercase">
                                        <th style="text-align: center">Currency</th>
                                        <th style="text-align: center">Rate To USD</th>
                                        <th style="text-align: center">Rate To SGD</th>
                                    </tr>
                                </thead>
                                <?php
                                if (!empty($cari_rate)) {
                                  foreach ($cari_rate as $v) {
                                ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo "$v->currency_id"; ?></td>
                                            <td style="text-align: center"><?php echo "$v->rate_usd"; ?></td>
                                            <td style="text-align: center"><?php echo "$v->rate_kurs"; ?></td>
                                        </tr>
                                <?php
                                  }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">List User</span>
                        </div>
                    </div>
                    <div class="portlet-body fixed-content-2">
                        <div class="table-scrollable table-scrollable-borderless">
                            <table class="table table-hover table-light">
                                <thead>
                                    <tr class="uppercase">
                                        <th colspan="2">
                                            MEMBER
                                        </th>
                                        <th>
                                            ACTION
                                        </th>

                                    </tr>
                                </thead>
                                <?php
                                if (!empty($cari_user)) {
                                  foreach ($cari_user as $x) {
                                ?>
                                        <tr>
                                            <td class="fit">
                                                <img class="user-pic" src="<?= base_url('uploads/default.png') ?>" alt="">
                                            </td>
                                            <td>
                                                <?php echo "$x->firstname $x->lastname"; ?>
                                            </td>
                                            <td style="text-align: center">
                                                <span class="bold theme-font center">
                                                    <a href="javascript:;" class="primary-link">
                                                        <i class="fa fa-envelope-o"></i> Send Message</a>
                                                </span>
                                            </td>
                                        </tr>
                                <?php
                                  }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <?php echo smiley_js(); ?>
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Chat room</span>
                        </div>
                    </div>
                    <div id="body" class="portlet-body fixed-content" style="background-color: #E6E6E6;">
                        Loading...
                    </div>
                    <div class="portlet-body" style="padding-top: 20px; ">
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <div class="col-md-1">
                                        <div class="popover-markup">
                                            <a href="#" class="trigger btn btn-sm btn-primary" data-placement="top">
                                                <i class="ace-icon fa fa-smile-o"></i></a>
                                            <div class="head hide">!--</div>
                                            <div class="content hide">
                                                <?php echo $smiley_table; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="input-group">
                                            <input id="txtMessage" name="txtMessage" class="form-control input-sm" type="text" placeholder="Message here.." required>
                                            <span class="input-group-btn">
                                                <button id="btnSend" class="btn btn-sm btn-success" type="button"><i class="fa fa-send fa-fw"></i> send</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <script defer>
                        $(setInterval(function() {
                            $('#body').load('<?php echo base_url(); ?>home/viewMessageNew'),
                                $('#body').attr({
                                    scrollBottom: $('#body').attr('scrollHeight')
                                });
                        }, 500));
                        $(setInterval(function() {
                            var objDiv = document.getElementById("body");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 6000));
                    </script>
                    <script>
                        jQuery(function($) {
                            $('.popover-markup>.trigger').popover({
                                html: true,
                                title: function() {
                                    return $(this).parent().find('.head').html();
                                },
                                content: function() {
                                    return $(this).parent().find('.content').html();
                                }
                            });
                        });
                    </script>
                    <script defer>
                        $(function() {
                            $('.error').hide();
                            $('.sukses').hide();
                            $('#btnSend').click(function() {
                                var isipesan = $('#txtMessage').val();

                                if (isipesan === '') {
                                    $('.error').show();
                                    $('.sukses').hide();
                                    return false;
                                }

                                var strdata = 'txtMessage=' + isipesan;

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>Home/sendMessage',
                                    data: strdata,
                                    success: function() {
                                        $('#txtMessage').val('');
                                        $('.sukses').show();
                                        $('.error').hide();
                                        $('#body').attr({
                                            scrollBottom: $('#body').attr('scrollHeight')
                                        });
                                    }
                                });
                            });
                        });
                    </script>
                    <script>
                        $('#txtMessage').on('keydown', function(e) {
                            if (e.which == 13) {
                                e.preventDefault();
                                var isipesan = $('#txtMessage').val();

                                if (isipesan === '' || isipesan === ' ') {
                                    $('.error').show();
                                    $('.sukses').hide();
                                    return false;
                                }

                                var strdata = 'txtMessage=' + isipesan;

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url(); ?>Home/sendMessage',
                                    data: strdata,
                                    success: function() {
                                        $('#txtMessage').val('');
                                        $('.sukses').show();
                                        $('.error').hide();
                                        $('#body').attr({
                                            scrollBottom: $('#body').attr('scrollHeight')
                                        });
                                    }
                                });

                                this.value = null;
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

    </div>
</div> -->