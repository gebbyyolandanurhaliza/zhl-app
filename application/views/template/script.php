<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php // echo base_url();
              ?>assets/global/plugins/respond.min.js"></script>
                <script src="<?php // echo base_url();
                              ?>assets/global/plugins/excanvas.min.js"></script>
                <![endif]-->

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/notify/notify.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script> -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/autosize/autosize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/autonumeric/autoNumeric.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/icheck/icheck.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL PLUGINS -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.15/dist/sweetalert2.all.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/sweetalert.min.js"></script>



<!-- Begin Tree Table -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/tree/js/jquery.treegrid.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/tree/js/jquery.cookie.js"></script>
<!--- END Tree Table -->

<!-- BEGIN DATATABLE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
<!-- END DATA TABLE PLUGINS -->

<!-- BEGIN MAPS PLUGINS -->
<!--
                <script src="<?php // echo base_url();
                              ?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
                <script src="<?php // echo base_url();
                              ?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
                <script src="<?php // echo base_url();
                              ?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
                -->
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-pickers.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/scripts/misc.js"></script>
<script src="<?php echo base_url(); ?>assets/marketing/sambu.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 44 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }

  function validasi_enter(event) {
    var char = event.which || event.keyCode;
    if (char === 13) {
      return false;
    }

  }

  function formatDate(date) {
    var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;

    return [year, month, day].join('-');
  }

  function get_cur() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tgl_tempo").value;
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    $.ajax({
      url: "<?php echo base_url(); ?>Purchase_inv_factory/ambil_currency?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#daftar_kurs").html(response);

        var cur = document.getElementById('rate_currency').value;

        //document.getElementById('rate_sgd').value = cur;
        document.getElementById('jr_rate1').value = cur;
        document.getElementById('jr_rate2').value = cur;
        document.getElementById('jr_rate3').value = cur;
        document.getElementById('jr_rate4').value = cur;
        document.getElementById('jr_rate5').value = cur;
        document.getElementById('jr_rate6').value = cur;
      },
      dataType: "html"
    });
    document.getElementById('tombol_dp').style.display = 'inline';
    document.getElementById('garis_dp').style.display = 'block';
  }

  function get_cur_old() {
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    $.ajax({
      url: "<?php echo base_url(); ?>payable_recognition/ambil_currency?kurs=" + currency_id + "&bln=" + bulan + "&thn=" + tahun,
      success: function(response) {
        $("#daftar_kurs").html(response);

        var cur = document.getElementById('rate_currency').value;

        //document.getElementById('rate_sgd').value = cur;
        document.getElementById('jr_rate1').value = cur;
        document.getElementById('jr_rate2').value = cur;
        document.getElementById('jr_rate3').value = cur;
        document.getElementById('jr_rate4').value = cur;
        document.getElementById('jr_rate5').value = cur;
        document.getElementById('jr_rate6').value = cur;
      },
      dataType: "html"
    });
    document.getElementById('tombol_dp').style.display = 'inline';
    document.getElementById('garis_dp').style.display = 'block';
  }

  function get_cur_gj() {
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    $.ajax({
      url: "<?php echo base_url(); ?>General_Journal/ambil_currency?kurs=" + currency + "&bln=" + bulan + "&thn=" + tahun,
      success: function(response) {
        $("#daftar_kurs").html(response);

        var cur = document.getElementById('rate_currency').value;

        //document.getElementById('rate_sgd').value = cur;
        document.getElementById('jr_rate1').value = cur;
        document.getElementById('jr_rate2').value = cur;
        document.getElementById('jr_rate3').value = cur;
        document.getElementById('jr_rate4').value = cur;
        document.getElementById('jr_rate5').value = cur;
        document.getElementById('jr_rate6').value = cur;
      },
      dataType: "html"
    });
    document.getElementById('tombol_dp').style.display = 'inline';
    document.getElementById('garis_dp').style.display = 'block';
  }

  function get_cur_cdn() {
    $cur = document.getElementById("currency").value;
    $docdate = document.getElementById("tgl_tempo").value;
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    //vcdn/ambil_cur?cur=" + $cur + "&date=" + $docdate + "",
    $.ajax({
      url: "<?php echo base_url(); ?>payable_recognition/ambil_currency_cdn2?cur=" + $cur + "&date=" + $docdate + "",
      success: function(response) {
        $("#daftar_kurs").html(response);
        var cur = document.getElementById('rate_currency').value;
        document.getElementById('jr_rate1').value = cur;
        var kur = document.getElementsByClassName('txtRate');
        for (var i = 1; i < kur.length; i++) {
          kur[i].value = cur;
        }
      },
      dataType: "html"
    });
    hitung_vcdn();
  }

  function get_cur_cdn_old() {
    var currency_id = document.getElementById('currency').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tahun = tgl[2];
    var bulan = tgl[1];

    $.ajax({
      url: "<?php echo base_url(); ?>payable_recognition/ambil_currency_cdn?kurs=" + currency_id + "&bln=" + bulan + "&thn=" + tahun,
      success: function(response) {
        $("#daftar_kurs").html(response);
        var cur = document.getElementById('rate_currency').value;
        document.getElementById('jr_rate1').value = cur;
        var kur = document.getElementsByClassName('txtRate');
        for (var i = 1; i < kur.length; i++) {
          kur[i].value = cur;
        }
      },
      dataType: "html"
    });
    hitung_vcdn();
  }

  function gantirate() {
    var closing = document.getElementById('closing_date').value;
    var tgl1 = document.getElementById('tgl_tempo').value;
    var tgl = tgl1.split("/");
    var tgl1yy = tgl[2];
    var tgl1mm = tgl[1];
    var tgl1dd = tgl[0];

    //change date closing
    var clos = closing.split("/");
    var closingyy = clos[2];
    var closingmm = clos[1];
    var closingdd = clos[0];

    document.getElementById('term').value = 0;

    var oneDay = 24 * 60 * 60 * 1000;
    //buat object Date yy, mm, dd
    var firstDate = new Date(tgl1yy, tgl1mm, tgl1dd);
    var secondDate = new Date(closingyy, closingmm, closingdd);

    var selisih = Math.round((firstDate.getTime() - secondDate.getTime()) / (oneDay));

    document.getElementById('tanggal_invoice').value = tgl1;
    document.getElementById('tgl_invoice').value = tgl1;
    // alert(selisih);
    //cek closing date
    if (selisih <= 0) {
      $.ajax({
        url: "<?php echo base_url(); ?>Payable_recognition/peringatan",
        success: function(response) {
          $("#error_id").html(response);
        },
        dataType: "html"
      });
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yy = today.getFullYear();
      var ubah_tanggal = dd + "/" + mm + "/" + yy;
      document.getElementById('tanggal_invoice').value = ubah_tanggal;
      document.getElementById('tgl_invoice').value = ubah_tanggal;
      document.getElementById('tgl_tempo').value = ubah_tanggal;
    }
    get_cur();
    cek_gst();
  }

  function valid_closing() {
    var tgl1 = document.getElementById('tgl_tempo').value;
    var closing = document.getElementById('closing_date').value;

    //Change date first
    var tgl = tgl1.split("/");
    var tgl1yy = tgl[2];
    var tgl1mm = tgl[1];
    var tgl1dd = tgl[0];

    //change date closing
    var clos = closing.split("/");
    var closingyy = clos[2];
    var closingmm = clos[1];
    var closingdd = clos[0];

    var oneDay = 24 * 60 * 60 * 1000;
    //buat object Date yy, mm, dd
    var firstDate = new Date(tgl1yy, tgl1mm, tgl1dd);
    var secondDate = new Date(closingyy, closingmm, closingdd);

    var selisih = Math.round((firstDate.getTime() - secondDate.getTime()) / (oneDay));

    // alert(selisih);
    //cek closing date
    if (selisih <= 0) {
      $.ajax({
        url: "<?php echo base_url(); ?>Payable_recognition/peringatan",
        success: function(response) {
          $("#error_id").html(response);
        },
        dataType: "html"
      });
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yy = today.getFullYear();
      var ubah_tanggal = dd + "/" + mm + "/" + yy;
      document.getElementById('tgl_tempo').value = ubah_tanggal;
    }
  }
</script>

<script>
  jQuery(document).ready(function() {
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
    // Layout.init(); // init current layout
    // Demo.init(); // init demo features
    ComponentsPickers.init();

    setTimeout(function() {
      $('.msg').hide("slow");
    }, 4000); // The delay is in milliseconds, so 3000 ms is 3 seconds

  });
</script>

<script>
  function startTime() {
    const today = new Date();

    var options = {
      timeZone: 'Asia/Singapore'
    };

    var currentHour = today.toLocaleTimeString('en-US', options);

    let h = today.toLocaleTimeString('en-US', options);
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('clock').innerHTML = h;
    setTimeout(startTime, 1000);
  }

  function checkTime(i) {
    if (i < 10) {
      i = "0" + i
    }; // add zero in front of numbers < 10
    return i;
  }
</script>
<!-- END JAVASCRIPTS -->