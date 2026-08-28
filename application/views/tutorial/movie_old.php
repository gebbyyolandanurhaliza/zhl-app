<?php error_reporting(0); ?>
<!-- BEGIN PAGE CONTENT -->

<link href="<?php echo base_url(); ?>assets/admin/pages/css/todo.css" rel="stylesheet" type="text/css" />
<div class="page-content">
  <div class="container">

    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light">
        <div class="portlet-title">
          <div class="caption">
            <span class="caption-subject theme-font bold">Tutorial</span>
          </div>
          <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
          </div>
        </div>
        <div class="table-body">
          <?php if ($this->input->get('id') == 'marketing') { ?>
            <video width="620" height="440" controls>
              <source src="<?php echo base_url(); ?>trial/mtt.mp4" type="video/mp4">
            </video>
          <?php } elseif ($this->input->get('id') == 'accounting') { ?>

            <div class="row">
              <div class="col-md-4 col-sm-3">
                <div class="scroller" style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7">
                  <div class="todo-tasklist">
                    <!-- start looping -->
                    <div class="todo-tasklist-item todo-tasklist-item-border-blue">
                      <a href="<?php echo base_url(); ?>Movie?id=accounting&video=master_coa" style="text-decoration: none">
                        <div class="todo-tasklist-item-title">
                          Input COA
                        </div>
                        <div class="todo-tasklist-item-text">
                          Tutorial form master Count of Account Pulau Sambu
                        </div>
                      </a>
                    </div>
                    <div class="todo-tasklist-item todo-tasklist-item-border-blue">
                      <a href="<?php echo base_url(); ?>Movie?id=accounting&video=purchase_invoice_journal" style="text-decoration: none">
                        <div class="todo-tasklist-item-title">
                          Transaction Purchase Invoice Journal
                        </div>
                        <div class="todo-tasklist-item-text">
                          This tutorial for transaction purchase invoice journal, purchase invoice journal is transaction from Purchase Order transaction
                        </div>
                      </a>
                    </div>
                  </div>
                  <!-- End looping -->
                </div>
              </div>
              <div class="todo-tasklist-devider">
              </div>
              <div class="col-md-7 col-sm-8">
                <div class="scroller" style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7">
                  <video width="100%" height="auto" controls>
                    <source src="<?php echo base_url(); ?>trial/<?php echo $this->input->get('video'); ?>.webm" type='video/webm;codecs="vp8, vorbis"' />
                    <source src="<?php echo base_url(); ?>trial/<?php echo $this->input->get('video'); ?>.mp4" type="video/mp4">
                  </video>
                </div>
              </div>
            </div>
          <?php } elseif ($this->input->get('id') == 'purchasing') { ?>
            <video width="620" height="440" controls>
              <source src="<?php echo base_url(); ?>trial/po.mp4" type="video/mp4">
            </video>
            <p />
            <a href="<?php echo base_url(); ?>trial/po.mp4" class='btn btn-primary'><i class="fa fa-download"></i> Download</a>
          <?php } elseif ($this->input->get('id') == 'finance') {  ?>
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#tab_0" data-toggle="tab" aria-expanded="true">
                  Input AP Finace </a>
              </li>
              <li class="">
                <a href="#tab_1" data-toggle="tab" aria-expanded="false">
                  Input AR Finance </a>
              </li>
              <li class="">
                <a href="#tab_2" data-toggle="tab" aria-expanded="false">
                  Cash Bank Transaction </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_0">
                <video controls="controls" autoplay="autoplay">
                  <source src="<?php echo base_url(); ?>trial/Input_AP_x264.mp4" type="video/mp4" />
                </video>
                <br />
                <a href="<?php echo base_url(); ?>trial/Input_AP_x264.mp4" class='btn btn-primary'><i class="fa fa-download"></i> Download</a>
                <a href="<?php echo base_url(); ?>trial/Input_AP.pdf" class='btn btn-primary'><i class="fa fa-download"></i> PDF</a>
              </div>
              <div class="tab-pane" id="tab_1">
                How to do the same with AP Transaction
              </div>
              <div class="tab-pane" id="tab_2">
                <video controls="controls" autoplay="autoplay">
                  <source src="<?php echo base_url(); ?>trial/CashBankTransaction.mp4" type="video/mp4" />
                </video>
                <br />
                <a href="<?php echo base_url(); ?>trial/CashBankTransaction.mp4" class='btn btn-primary'><i class="fa fa-download"></i> Download</a>
                <a href="<?php echo base_url(); ?>trial/Cash_Bank_Transaction.pdf" class='btn btn-primary'><i class="fa fa-download"></i> PDF</a>
              </div>
            </div>
          <?php } elseif ($this->input->get('id') == 'screen') {  ?>
            <ul class="nav nav-tabs">
              <li class="active">
                <a href="#tab_0" data-toggle="tab" aria-expanded="true">
                  Firefox </a>
              </li>
              <!-- <li class="">
                                <a href="#tab_1" data-toggle="tab" aria-expanded="false">
                                Crome </a>
                            </li> -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_0">
                <video controls="controls" autoplay="autoplay">
                  <source src="<?php echo base_url(); ?>trial/FireShot.mp4" type="video/mp4" />
                </video>
                <br />
                <a href="<?php echo base_url(); ?>trial/FireShot.mp4" class='btn btn-primary'><i class="fa fa-download"></i> Download</a>
              </div>
              <!-- <div class="tab-pane" id="tab_2">
                                <video controls="controls" autoplay="autoplay">
                                    <source src="<?php echo base_url(); ?>trial/CashBankTransaction.mp4" type="video/mp4" />
                                </video>
                                <br/>
                                <a href="<?php echo base_url(); ?>trial/CashBankTransaction.mp4" class='btn btn-primary'><i class="fa fa-download"></i> Download</a>\
                            </div> -->
            </div>
          <?php } ?>
        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>

  </div>
  <!-- END PAGE CONTENT -->
</div>
</div>
<!-- END PAGE CONTENT -->