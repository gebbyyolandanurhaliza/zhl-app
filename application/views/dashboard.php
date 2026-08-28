<link href="<?php echo base_url(); ?>assets/admin/pages/css/timeline-ismo.css" rel="stylesheet" type="text/css" />
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
            <h1>Dashboard <small>Welcome to MyPSS Apps</small></h1>
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
                            <span class="caption-subject theme-font bold uppercase">Last Rate</span>
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
                                            <td style="text-align: center"><?php echo "$v->rate"; ?></td>
                                            <td style="text-align: center"><?php echo "$v->rate_usd"; ?></td>
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
                                                <img class="user-pic" src="" alt="">
                                            </td>
                                            <td>
                                                <?php echo "$x->firstname $x->lastname"; ?>
                                            </td>
                                            <td style="text-align: center">
                                                <span class="bold theme-font center"><a href="javascript:;" class="primary-link"><i class="fa fa-envelope-o"></i> Send Message</a></span>
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
                    <div id="body" class="portlet-body fixed-content">
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
                            $('#body').load('<?php echo base_url(); ?>home/viewMessage'),
                                $('#body').attr({
                                    scrollBottom: $('#body').attr('scrollHeight')
                                });
                        }, 500));
                        $(setInterval(function() {
                            var objDiv = document.getElementById("body");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 3000));
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
</div>