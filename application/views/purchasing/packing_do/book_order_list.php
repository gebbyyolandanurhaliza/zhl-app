<?php
error_reporting(0)
?>

<!-- <link href="<?php echo base_url(); ?>assets/admin/css/cloud-admin.css" rel="stylesheet" type="text/css"> -->

<div class="page-content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-12">
        <?php
        if ($this->session->flashdata('message')) :
          echo $this->session->flashdata('message');
        endif;
        ?>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-list theme-font"></i>
              <span class="caption-subject theme-font bold">List Booking Order</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="row">
              <div class="col-md-4">
                <div class='form-group'>
                  <label class='col-md-3 label-sm'>Find</label>
                  <div class='col-md-6'>
                    <input class='form-control input-sm' id='findinv'>
                  </div>
                  <button type='button' class='col-md-3 btn blue' onclick='filterinv()'>Search</button>
                </div>
              </div>
            </div>
            <div class="table-scrollable" style="overflow: auto; height:400px;">
              <table class="table table-bordered" id="table">
                <thead>
                  <tr>
                    <th class="text-center"> Actions</th>
                    <th class="text-center" data-sortable="true">Book Ref No</th>
                    <th class="text-center">Cust</th>
                    <th class="text-center">ETD</th>
                    <th class="text-center">Barge</th>
                    <th class="text-center">Voyage</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated By</th>
                    <th class="text-center">Updated Date</th>
                  </tr>
                </thead>
                <tbody id="tbl-mon">
                  <?php foreach ($book as $r) {
                    echo '<tr >';
                    echo '<td nowrap>';
                    echo '<a class="btn-sm btn-warning" title="Edit" href="' . site_url('Packing_do/book_order_shipping_input?bookref_no=' . $r->bookref_no . '&ship=' . $r->date . '&cust=' . $r->custid) . '"><i class="fa fa-pencil"></i></a> ';
                    echo '<a type="button" title="Print" class="btn-sm btn-info" href="' . site_url('Packing_do/book_order_shipping_excel?bookref_no=' . $r->bookref_no . '&cust=' . $r->custid) . '" target="_blank"><i class="fa fa-file-excel-o"></i></a>';
                    echo '</td>';
                    echo '<td nowrap>' . $r->bookref_no . '</td>';
                    echo '<td nowrap>' . $r->custid . '</td>';
                    echo '<td nowrap>' . date("d-m-Y",  strtotime($r->etd)) . '</td>';
                    echo '<td nowrap>' . $r->barge . '</td>';
                    echo '<td nowrap>' . $r->voyage . '</td>';
                    echo '<td nowrap>' . $r->createdby . '</td>';
                    echo '<td nowrap>' . $r->createddate . '</td>';
                    echo '<td nowrap>' . $r->lastupdatedby . '</td>';
                    echo '<td nowrap>' . $r->lastupdateddate . '</td>';
                    echo '</tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>


</script>