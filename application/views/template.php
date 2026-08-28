<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Zhenghe Logistic Pte Ltd">
  <meta name="author" content="Sambu's Software Engineer">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>Zhenghe Logistic Pte Ltd | Sambu Group</title>

  <noscript>
    <h3>This site has features that require javascript.
      Follow these simple instructions to</h3>
    <a href="http://www.activatejavascript.org" target="_blank">
      <h3>enable JavaScript in your web browser</h3>
    </a>

    <style>
      div {
        display: none;
      }
    </style>
  </noscript>

  <?php echo $_style; ?>
  <?php echo $_script; ?>
</head>

<body class="page-header-menu-fixed" id="block" onload="startTime()">
  <!-- BEGIN HEADER -->
  <div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
      <div class="container-fluid">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
          <a href="<?= site_url('home') ?>">
            <img src="<?php echo base_url(); ?>assets/global/img/newlogo3.png" alt="logo" class="logo-default" style="width: 280px;margin-top:10px">
            <!--<h1 class=" font-blue-dark">PULAU SAMBU</h1>-->
          </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler"></a>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <?php echo $_navigation; ?>

      </div>
    </div>
    <!-- END HEADER TOP -->

    <?php echo $_menu; ?>

  </div>
  <!-- END HEADER -->

  <!-- BEGIN PAGE CONTAINER -->
  <div class="page-container">
    <!--email_off-->
    <?php echo $_content; ?>
    <!--/email_off-->
  </div>
  <!-- END PAGE CONTAINER -->

  <?php echo $_footer; ?>
</body>

</html>