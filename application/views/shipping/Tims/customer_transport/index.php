<div class="page-content">

  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">

        <?php echo $message; ?>

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>
              <span class="caption-subject theme-font uppercase">Master Customer Transport</span>
            </div>
            <div class="actions">
              <?php echo anchor(site_url('Master_Tims/add_customer_transport'), '<i class="fa fa-plus"></i> Create New Customer', 'class="btn btn-primary"'); ?>
            </div>
          </div>

          <div class="portlet-body flip-scroll">
            <div class="col-md-12">
              <!-- search form here -->
            </div>

            <div class="search_result"> <!-- Hasil pencarian tampilkan disini -->
              <div class="table-scrollable-borderless">
                <table id="tblmst_customer" class="table table-bordered table-striped table-condensed">
                  <thead>
                    <tr>
                      <th width="30px">#</th>
                      <th scope="col" class="text-center">NO</th>
                      <th scope="col" class="text-center" hidden>CUSTOMER ID</th>
                      <th scope="col" class="text-center">Name</th>
                      <th scope="col" class="text-center">Customer Code</th>
                      <th scope="col" class="text-center">Currency Code</th>
                      <th scope="col" class="text-center">Country</th>
                      <th scope="col" class="text-center">Contact Name</th>
                      <th scope="col" class="text-center">Fax</th>
                      <th scope="col" class="text-center">Email</th>
                      <th scope="col" class="text-center">Phone</th>
                      <th scope="col" class="text-center">Term Payment Due</th>
                      <th scope="col" class="text-center">Balance Due Date</th>
                      <th scope="col" class="text-center">Account</th>
                      <th scope="col" class="text-center">Payament Method</th>
                      <th scope="col" class="text-center">Address</th>
                      <th scope="col" class="text-center">Created By</th>
                      <th scope="col" class="text-center">Created Date</th>
                      <th scope="col" class="text-center">Updated By</th>
                      <th scope="col" class="text-center">Updated Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no_urut = 1;
                    foreach ($list_customer as $master_customer) {
                    ?>
                      <tr>
                        <td style="text-align:center" width="100px">
                          <a class="btn default btn-sm green-stripe" href="<?php echo site_url('Master_Tims/Edit_customer_transport?customer_id=' . $master_customer->customer_id); ?>"><i class="fa fa-edit" style="margin: auto;"></i></a>
                          <a class="btn default btn-sm red-stripe" href="<?php echo site_url('Master_Tims/delete_customer_transport?customer_id=' . $master_customer->customer_id); ?>" onclick="javasciprt: return confirm('Are you sure delete Customer Transport <?php echo $master_customer->customer_name; ?> ?')"><i class="fa fa-trash-o" style="margin: auto;"></i></a>
                        </td>
                        <td><?php echo $no_urut ?></td>
                        <td hidden><?php echo $master_customer->customer_id ?></td>
                        <td><?php echo $master_customer->customer_name ?></td>
                        <td><?php echo $master_customer->customer_code ?></td>
                        <td><?php echo $master_customer->curency_code ?></td>
                        <td><?php echo $master_customer->country ?></td>
                        <!-- ini untuk menampilkan country by code country -->
                        <!-- <td>
                                                    <?php
                                                    $country_id = $master_customer->country;
                                                    $country_name = '';
                                                    foreach ($country as $c) {
                                                      if ($c->country_id == $country_id) {
                                                        $country_name = $c->country_name;
                                                        break;
                                                      }
                                                    }

                                                    echo $country_name;
                                                    ?>
                                                </td> -->
                        <td><?php echo $master_customer->contact_name  ?></td>
                        <td><?php echo $master_customer->fax ?></td>
                        <td><?php echo $master_customer->email ?></td>
                        <td><?php echo $master_customer->phone ?></td>
                        <td><?php echo $master_customer->term_payment_due ?></td>
                        <td><?php echo $master_customer->balance_due_date ?></td>
                        <td><?php echo $master_customer->account ?></td>
                        <td><?php echo $master_customer->payment_method ?></td>
                        <td><?php echo $master_customer->address ?></td>
                        <td><?php echo $master_customer->createby ?></td>
                        <td><?php echo $master_customer->createddate ?></td>
                        <td><?php echo $master_customer->updatedby ?></td>
                        <td><?php echo $master_customer->updateddate ?></td>

                      </tr>
                    <?php
                      $no_urut++;
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

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#tblmst_customer").dataTable({
      "sScrollX": "200%", //This is what made my columns increase in size.
      "bScrollCollapse": true,
      //			"sScrollY": "500px",
      "autoWidth": false
    });
  });
</script>