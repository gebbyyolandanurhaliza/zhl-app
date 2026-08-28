<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Sambu Group | Page Maintenance</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="Sambu Group Application" name="description"/>
        <meta content="Sambu Group" name="author"/>
        
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
        
        <link href="<?php echo base_url(); ?>assets/admin/pages/css/coming-soon.css" rel="stylesheet" type="text/css"/>
        
        <link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
        <link href="<?php echo base_url(); ?>assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css">
        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/global/img/logoPS.gif"/>
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-10 coming-soon-header">
                    <a class="brand" href="<?php echo site_url();?>">
                        <img src="<?php echo base_url(); ?>assets/admin/layout3/img/logo-big.png" alt="logo"/>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-2 col-md-4 coming-soon-content">
                    <h1>We&rsquo;ll be back soon!</h1>
                    <p>
                        Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. 
                        If you need to you can always <a href="mailto:#">contact us</a>, 
                        otherwise we&rsquo;ll be back online shortly!
                    </p>
                    <br>
                    <a href="<?php echo site_url();?>" class="btn blue"><i class="icon-action-undo"></i> Back</a>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-offset-2 col-md-10 coming-soon-footer">
                   <?php echo date('Y'); ?> &copy; Pulau Sambu Singapore.
                </div>
            </div>
        </div>
        
        <!--[if lt IE 9]>
        <script src="<?php echo base_url(); ?>asset/global/plugins/respond.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/global/plugins/excanvas.min.js"></script> 
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/countdown/jquery.countdown.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        
        <script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/pages/scripts/coming-soon.js" type="text/javascript"></script>
        
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                Demo.init(); // init demo features
                ComingSoon.init();
                // init background slide images
                $.backstretch([
                    "<?php echo base_url(); ?>assets/admin/pages/media/bg/1.jpg",
                    "<?php echo base_url(); ?>assets/admin/pages/media/bg/2.jpg",
                    "<?php echo base_url(); ?>assets/admin/pages/media/bg/3.jpg",
                    "<?php echo base_url(); ?>assets/admin/pages/media/bg/4.jpg"
                ], {
                    fade: 1000,
                    duration: 8000
                }
                );
            });
        </script>
        
    </body>
</html>