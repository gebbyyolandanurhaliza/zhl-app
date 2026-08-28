<style>
       

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            background-color: white;
        }

        tr:hover td {
            background-color: #f8f9fa;
        }

        /* Input Styles */
        .table-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .table-input:focus {
            outline: none;
            border-color: #0033a0;
        }

        /* Multi-Value Field */
        .multi-value-field {
            position: relative;
            width: 100%;
        }

        .multi-value-display {
            min-height: 38px;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f8f9fa;
            cursor: pointer;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .multi-value-display:hover {
            border-color: #0033a0;
        }

        .value-tag {
            background-color: #0033a0;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .value-tag .remove-tag {
            cursor: pointer;
            font-weight: bold;
            margin-left: 4px;
        }

        .value-tag .remove-tag:hover {
            color: #ff4444;
        }

        .placeholder-text {
            color: #999;
            font-style: italic;
            font-size: 14px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #0033a0;
            color: white;
        }

        .btn-primary:hover {
            background-color: #002580;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 800px;
            width: 90%;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            line-height: 1;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        /* Search Box in Modal */
        .modal-search {
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: #0033a0;
        }

        /* Master Data Table in Modal */
        .master-table {
            width: 100%;
            border-collapse: collapse;
        }

        .master-table th {
            background-color: #0033a0;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        .master-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .master-table tr:hover td {
            background-color: #f0f8ff;
        }

        .checkbox-cell {
            width: 40px;
            text-align: center;
        }

        /* Selected Items Preview */
        .selected-preview {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 15px;
            max-height: 100px;
            overflow-y: auto;
        }

        .selected-preview h4 {
            font-size: 14px;
            margin-bottom: 8px;
            color: #555;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .selected-item {
            background-color: #e7f3ff;
            color: #0033a0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            border: 1px solid #0033a0;
        }

        /* Info Message */
        .info-message {
            background-color: #e7f3ff;
            border-left: 4px solid #0033a0;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #004085;
        }

        /* Action Column */
        .action-column {
            width: 100px;
            text-align: center;
        }

        /* Summary Box */
        .summary-box {
            background-color: #f8f9fa;
            border: 2px solid #0033a0;
            border-radius: 4px;
            padding: 20px;
            margin-top: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #0033a0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }

        /* Loading Spinner */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0033a0;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
<div class="page-content">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-car theme-font"></i>
              <span class="caption-subject theme-font uppercase"><?php echo $header_title; ?></span>
            </div>

            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
            </div>

          </div>

          <?php echo $this->session->flashdata('message'); ?>

          <div class="portlet-body form" id="save_as_new">
            <form action="<?php echo $action; ?>" id="form-data" method="post" class="form-horizontal" irole="form">
              <div class="form-body">
                <div class="col-md-1 pull-right"></div>
                <div class="form-group">
                  <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-body">

                        <div class="form-group required">

                          <label class="col-md-1 control-label" for="varchar">Current Date</label>
                          <div class="col-md-2">
                            <input type="text" class="form-control date <?= $date_picker ?>" name="current_date" placeholder="DD/MM/YYYY" value="<?= $current_date ?>" readonly required />
                          </div>

                          <div class="col-md-4"></div>

                          <?php 
                             if($trigger == 'edit'){
                          ?>

                          <label class="col-md-1 control-label" for="varchar">Filter By Driver</label>
                          <div class="col-md-3">
                              <select id="id_vehicle_filter" class="form-control select2">
                                    <option value="">Choose Vehicle</option>
                                    <?php
                                    foreach ($vehicle as $ve) { ?>
                                      <option value="<?= $ve->id_vehicle ?>"><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                          </div>
                          <div class="col-md-1">
                             <button class="btn btn-success" id="filterbutton"><i class="fa fa-search"></i></button>
                          </div>

                          <?php 
                             }
                          ?>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div>
                <div class="table-scrollable">
                  <table class="table-bordered table-striped table-condensed table-hover scrollable" id="tabel" width="100%">
                    <thead>
                      <tr>
                        <th colspan="8" class="schedule-info bg-info" nowrap style="text-align:center">SCHEDULE </th>
                      </tr>

                      <tr class="double-border-bottom">
                        <th>
                          <!-- <a class="btn green" onclick="tambah_job()"><i class="fa fa-plus fa-3x fa-fw"></i> </a> -->
                        </th>
                        <th class="text-center">CLIENTS</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">JOB</th>
                        <th class="text-center">VEHICLE</th>
                        <!-- <th class="text-center">TIME</th> -->
                        <th class="text-center">SEND TO</th>
                        <th class="text-center">DRIVER PRICE</th>
                      </tr>
                    </thead>
                    <tbody id="dtl_item">
                      <?php
                      if (isset($dtl)) {
                      $no=0;  foreach ($dtl as $val) { if ($val->status != 'Complete') { ?>
                          <tr data-row-id="<?=$no;?>">
                        <?php }else{ ?>
                          <tr>
                        <?php } ?>
                            <td>
                              <?php
                              $disable = "disabled";
                              if ($val->status != 'Complete') {
                                $disable = "";
                                echo '<button class="btn red" onclick="hapus_baris(this,event)" data-id="' . $val->id_job_dtl . '" ><i class="fa fa-trash"></i></button>';
                              }else{
                                echo '<button class="btn btn-warning" onclick="restore_baris(this,event)" data-id="' . $val->id_job_dtl . '" title="Restore Data" ><i class="fa fa-refresh"></i></button>';
                              }
                              ?>
                              <input type="hidden" name="id_job_dtl[]" value="<?= $val->id_job_dtl ?>" class="id_job_dtl txt" <?= $disable ?> required>
                            </td>
                            <td>
                              <select name="client_id[]" class="form-control clients select2" <?= $disable ?> required>
                                <option value="">Choose Clients</option>
                                <?php
                                foreach ($customers as $cus) { ?>
                                  <option value="<?= $cus->customer_code_old ?>" <?= $cus->customer_code_old == $val->client_id ? 'selected' : '' ?>><?= $cus->customer_name ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </td>
                            <td>
                              <select name="status_cont[]" class="form-control select2">
                                <option value="">Choose Status</option>
                                <option value="Laden" <?= $val->status_cont == "Laden" ? 'selected' : '' ?>>Laden</option>
                                <option value="Empty" <?= $val->status_cont == "Empty" ? 'selected' : '' ?>>Empty</option>
                              </select>
                            </td>
                            <td style="width: 200px;">
                              <input type="text" name="job[]" value="<?= $val->job ?>" class="form-control job txt" <?= $disable ?> placeholder="Input Job Here" required>
                            </td>
                            <td>
                              <select name="id_vehicle[]" class="form-control select2" <?= $disable ?> required>
                                <option value="">Choose Vehicle</option>
                                <?php
                                foreach ($vehicle as $ve) { ?>
                                  <option value="<?= $ve->id_vehicle ?>" <?= $ve->id_vehicle == $val->id_vehicle ? 'selected' : '' ?>><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </td>
                            <td hidden>
                              <input type="time" name="time[]" value="<?= $val->time ?>" class="form-control time txt" <?= $disable ?>>
                            </td>
                            <td style="width: 250px;">
                              <input type="text" name="send_to[]" value="<?= $val->send_to ?>" class="form-control send_to txt" <?= $disable ?> placeholder="Input Send To" required>
                            </td>
                            <td>
                             <?php if ($val->status != 'Complete'){ ?> 
                              <div class="multi-value-field" onclick="openChargeModal(<?=$no;?>)">
                                  <div class="multi-value-display" id="charges-<?=$no;?>">
                                    <?php if (!empty($val->charges)): ?>
                                        <?php  foreach ($val->charges as $charge): ?>
                                          <span class="value-tag">
                                             <?= $charge->driver_wages; ?>
                                              <span class="remove-tag" onclick="removeCharge(<?=$no;?>,'<?= $charge->job_price_id;;?>')">×</span>
                                          </span>
                                        <?php  endforeach; ?>
                                        <?php endif; ?>
                                  </div>
                              </div>
                              <div id="hidden-charges-<?=$no;?>" style="display: none;">
                                 <?php if (!empty($val->charges)): ?>
                                  <?php  foreach ($val->charges as $charge): ?>
                                    <input type="hidden" name="charges[<?= $no ?>][]" value="<?= $charge->job_price_id ?>">
                                  <?php  endforeach; ?>
                                  <?php endif; ?>
                              </div>
                              
                              <?php $no++; }else{ ?> 
                                <div class="multi-value-field">
                                  <div class="multi-value-display">
                                    <?php if (!empty($val->charges)): ?>
                                        <?php  foreach ($val->charges as $charge): ?>
                                          <span class="value-tag">
                                             <?= $charge->driver_wages; ?>
                                          </span>
                                        <?php  endforeach; ?>
                                        <?php endif; ?>
                                  </div>
                              </div>
                            <?php } ?>
                        </td>
                          </tr>
                      <?php 
                        }
                      }else{ ?>
                        <tr data-row-id="0"><td>
                          <button class="btn red" onclick="hapus_baris(this,event)" data-id=""><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          <select name="client_id[]" class="form-control select2" required>
                          <option value="">Choose </option>
                              <?php  
                                foreach ($customer as $cus) { ?>
                                  <option value="<?= $cus->customer_code_old ?>"><?= $cus->customer_name ?></option>
                                <?php
                                }
                                ?>
                          </select>
                        </td>
                        <td>
                          <select name="status_cont[]" class="form-control select2">
                            <option value="">Choose Status</option>
                            <option value="Laden">Laden</option>
                            <option value="Empty">Empty</option>
                          </select>
                        </td>
                        <td>
                        <input type="text" name="job[]" class="job form-control txt" placeholder="Input Job Here">
                        </td>
                        <td>
                          <select name="id_vehicle[]" class="form-control select2" required>
                            <option value="">Choose Vehicle</option>
                                <?php
                                foreach ($vehicle as $ve) { ?>
                                  <option value="<?= $ve->id_vehicle ?>"><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
                                <?php
                                }
                                ?>
                          </select>
                        </td>
                        <td>
                        <input type="time" name="time[]" class="form-control time txt">
                        </td>
                        <td>
                            <input type="text" name="send_to[]" class="form-control send_to txt" placeholder="Input Send To">
                        </td>
                        <td>
                            <div class="multi-value-field" onclick="openChargeModal(0)">
                                <div class="multi-value-display" id="charges-0">
                                    <span class="placeholder-text">Click to select charges...</span>
                                </div>
                            </div>
                            <div id="hidden-charges-0" style="display: none;">
                              
                            </div>
                        </td></tr>
                    <?php }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>

              <div class="form-actions">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-10">
                      <a class="btn btn-primary" onclick="tambah_job()"><i class="fa fa-plus fa-3x fa-fw"></i> Add Row </a>
                        <button type="submit" class="btn green w-100" onclick="return confirm('Are you sure to save the data?')"><?php echo $button ?></button>
                        <a href="<?php echo site_url('tims/job-add') ?>" class="btn red"><i class="fa fa-close fa-3x fa-fw"></i> Cancel</a>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class=" col-md-2 btn btn-block btn-warning" onclick="fnDialogModalFind()"><i class="fa fa-search fa-3x fa-fw"></i> Find</button>
                      </div>
                    </div>
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

<!-- modal Find -->
<div id="modalDialogFind" hidden>
  <div class='portlet-body'>
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-md-2 label-sm">Current Date Start</label>
        <div class="col-md-2">
          <input type="text" id="current_date_start" class="form-control input-sm date date-picker" value="<?= date('01/m/Y') ?>" tabindex="-1">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 label-sm">Current Date End</label>
        <div class="col-md-2">
          <input type="text" id="current_date_end" class="form-control input-sm date date-picker" value="<?= date('t/m/Y') ?>" tabindex="-1">
        </div>
      </div>
      <div class="col-md-2">
        <div class='form-group'>
          <button type='button' class='col-md-1 btn blue btn-block' onclick='filterJoball()'>Search</button>
        </div>
      </div>
    </div>
    <br><br>

    <div class='table-scrollable' style='overflow: auto; height:490px;'>
      <table id='tbl-find' class='table table-bordered table-striped'>
        <thead>
          <tr>
            <th class="text-center">Action</th>
            <th class="text-center">Current Date</th>
            <th class="text-center">Create By</th>
            <th class="text-center">Create Date</th>
          </tr>
        </thead>
        <tbody id='findBody'></tbody>
      </table>
      <div class="text-center" id="loader" style="display:none">
        <h2><i class="fa fa-spinner fa fa-spin"></i></h2>
        <p>Loading...</p>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="chargeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Select Charges</h3>
                <button class="close-btn" onclick="closeModal('chargeModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-search">
                    <input type="text" class="search-input" id="chargeSearch" placeholder="Search charges..." onkeyup="filterCharges()">
                </div>
                <table class="master-table">
                    <thead>
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAllCharges" onchange="toggleAllCharges()">
                            </th>
                            <th>Driver Wages</th>
                            <th>Local Per Trip</th>
                            <th>PRC Per Trip</th>
                            <th>Extra</th>
                        </tr>
                    </thead>
                    <tbody id="chargeList">
                        
                    </tbody>
                </table>
                <div class="selected-preview">
                    <h4>Selected Charges (<span id="selectedChargeCount">0</span>)</h4>
                    <div class="selected-items" id="selectedChargesList"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('chargeModal')">Cancel</button>
                <button class="btn btn-primary" onclick="confirmChargeSelection()">Confirm Selection</button>
            </div>
        </div>
    </div>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%'
    });
  });

  $('.date-picker').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true
  });

  // let selectedCharges = {};
  let selectedCharges = <?php
  $js_charges = [];
  $rowIndex = 0;
  if (isset($dtl)) {
    foreach ($dtl as $row) {
      if (!empty($row->charges)) {
        $js_charges["charges-$rowIndex"] = array_map(function($c) {
          return (string)$c->job_price_id;
        }, $row->charges);
      }
      $rowIndex++;
    }
  }
  echo json_encode($js_charges, JSON_PRETTY_PRINT);
?>;
  let chargeRowCounter = <?= isset($dtl) ? ($rowIndex-1) : 0 ?>;
  const masterCharges = <?php echo json_encode(array_map(function($key) {
    return [
      'code' => $key->job_price_id,
      'name' => $key->driver_wages,
      'local_pertrip' => (float) $key->local_pertrip,
      'prc_pertrip' => (float) $key->prc_pertrip,
      'extra_trip' => (float) $key->extra_trip,
    ];
  }, $prices), JSON_PRETTY_PRINT); ?>;
  // Load Charges
  function loadCharges() {
      const tbody = document.getElementById('chargeList');
      tbody.innerHTML = '';
      masterCharges.forEach(charge => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td class="checkbox-cell">
                  <input type="checkbox" value="${charge.code}" onchange="updateSelectedChargesPreview()">
              </td>
              <td>${charge.name}</td>
              <td>${charge.local_pertrip}</td>
              <td>${charge.prc_pertrip}</td>
              <td>${charge.extra_trip}</td>
          `;
          tbody.appendChild(row);
      });
  }

  // Open Charge Modal
  function openChargeModal(rowId) {
      currentRowId = rowId;
      
      // Clear search
      document.getElementById('chargeSearch').value = '';
      
      // Get selected category
      const row = document.querySelector(`tr[data-row-id="${rowId}"]`);
      
      
      // Load charges
      loadCharges();
      
      // Restore previous selections and display names
      const key = `charges-${rowId}`;
      if (selectedCharges[key]) {
          selectedCharges[key].forEach(chargeCode => {
              const checkbox = document.querySelector(`#chargeList input[value="${chargeCode}"]`);
              if (checkbox) checkbox.checked = true;
          });
          
          // Also update the display to show names if needed
          const displayElement = document.getElementById(`charges-${rowId}`);
          const charges = selectedCharges[key].map(code => {
              const charge = masterCharges.find(c => c.code === code);
              return charge;
          }).filter(c => c);
          
          if (charges.length > 0) {
              displayElement.innerHTML = charges.map(charge => 
                  `<span class="value-tag">
                      ${charge.name}
                      <span class="remove-tag" onclick="removeCharge(${rowId}, '${charge.code}')">×</span>
                  </span>`
              ).join('');
          }
      }
      
      updateSelectedChargesPreview();
      document.getElementById('chargeModal').classList.add('active');
  }

  function filterCharges() {
    const searchTerm = document.getElementById('chargeSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#chargeList tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
  }

  // Toggle All Charges
  function toggleAllCharges() {
      const selectAll = document.getElementById('selectAllCharges');
      const checkboxes = document.querySelectorAll('#chargeList input[type="checkbox"]');
      
      checkboxes.forEach(checkbox => {
          checkbox.checked = selectAll.checked;
      });
      
      updateSelectedChargesPreview();
  }

  // Update Selected Charges Preview
  function updateSelectedChargesPreview() {
    const selected = [];
    const checkboxes = document.querySelectorAll('#chargeList input[type="checkbox"]:checked');
    
    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        const chargeCode = checkbox.value;
        const chargeName = row.cells[1].textContent;
        selected.push({ code: chargeCode, name: chargeName });
    });
    
    // Update count
    document.getElementById('selectedChargeCount').textContent = selected.length;
    
    // Update preview list
    const listContainer = document.getElementById('selectedChargesList');
    listContainer.innerHTML = selected.map(charge => 
        `<span class="selected-item">${charge.code} - ${charge.name}</span>`
    ).join('');
}

  // Confirm Charge Selection
  function confirmChargeSelection() {
      const selected = [];
      const checkboxes = document.querySelectorAll('#chargeList input[type="checkbox"]:checked');
      
      checkboxes.forEach(checkbox => {
          const row = checkbox.closest('tr');
          selected.push({
              code: checkbox.value,
              name: row.cells[1].textContent
          });
      });
      
      // Store selection (still use code for data integrity)
      const key = `charges-${currentRowId}`;
      selectedCharges[key] = selected.map(c => c.code);
      
      // Update display (show name instead of code)
      const displayElement = document.getElementById(`charges-${currentRowId}`);
      if (selected.length > 0) {
          displayElement.innerHTML = selected.map(charge => 
              `<span class="value-tag">
                  ${charge.name}
                  <span class="remove-tag" onclick="removeCharge(${currentRowId}, '${charge.code}')">×</span>
              </span>`
          ).join('');
      } else {
          displayElement.innerHTML = '<span class="placeholder-text">Click to select charges...</span>';
      }

      // Hapus input hidden sebelumnya (jika ada)
      const hiddenInputContainerId = `hidden-charges-${currentRowId}`;
      const existingContainer = document.getElementById(hiddenInputContainerId);
      if (existingContainer) {
        existingContainer.remove();
      }

      // Buat hidden input container baru
      const hiddenInputs = document.createElement('div');
      hiddenInputs.id = hiddenInputContainerId;
      hiddenInputs.style.display = 'none';

      selected.forEach(charge => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `charges[${currentRowId}][]`;
        input.value = charge.code;
        hiddenInputs.appendChild(input);
      });

      // Sisipkan setelah baris rowId
      const targetRow = document.querySelector(`tr[data-row-id="${currentRowId}"]`);
      targetRow.appendChild(hiddenInputs);
      
      closeModal('chargeModal');
  }

  // Remove Charge
  function removeCharge(rowId, chargeCode) {
      event.stopPropagation();
      const key = `charges-${rowId}`;
      
      if (selectedCharges[key]) {
          selectedCharges[key] = selectedCharges[key].filter(code => code !== chargeCode);
          
          // Re-render (show name instead of code)
          const displayElement = document.getElementById(`charges-${rowId}`);
          const charges = selectedCharges[key].map(code => {
              const charge = masterCharges.find(c => c.code === code);
              return charge;
          }).filter(c => c);
          
          if (charges.length > 0) {
              displayElement.innerHTML = charges.map(charge => 
                  `<span class="value-tag">
                      ${charge.name}
                      <span class="remove-tag" onclick="removeCharge(${rowId}, '${charge.code}')">×</span>
                  </span>`
              ).join('');
          } else {
              displayElement.innerHTML = '<span class="placeholder-text">Click to select charges...</span>';
              delete selectedCharges[key];
          }
      }
  }

  function closeModal(modalId) {
      document.getElementById(modalId).classList.remove('active');
      document.getElementById('selectAllCharges').checked = false;
  }


  function tambah_job() {
    chargeRowCounter++;
    const tbody = document.getElementById('dtl_item');
    const newRow = document.createElement('tr');
    newRow.setAttribute('data-row-id', chargeRowCounter);

    $.ajax({
      url: "<?php echo base_url('Tims/select'); ?>",
      type: 'GET',
      dataType: 'json',
      success: function(data) {
         newRow.innerHTML = `<td>
                          <button class="btn red" onclick="hapus_baris(this,event)" data-id=""><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          <select name="client_id[]" class="form-control select2" required>${generateCustomer(data.customer)}</select>
                        </td>
                        <td>
                          <select name="status_cont[]" class="form-control select2">
                            <option value="">Choose Status</option>
                            <option value="Laden">Laden</option>
                            <option value="Empty">Empty</option>
                          </select>
                        </td>
                        <td>
                        <input type="text" name="job[]" class="job form-control txt" placeholder="Input Job Here">
                        </td>
                        <td>
                          <select name="id_vehicle[]" class="form-control select2" required>${generateVehicle(data.vehicle)}</select>
                        </td>
                        <td hidden>
                        <input type="time" name="time[]" class="form-control time txt">
                        </td>
                        <td>
                            <input type="text" name="send_to[]" class="form-control send_to txt" placeholder="Input Send To">
                        </td>
                        <td>
                            <div class="multi-value-field" onclick="openChargeModal(${chargeRowCounter})">
                                <div class="multi-value-display" id="charges-${chargeRowCounter}">
                                    <span class="placeholder-text">Click to select charges...</span>
                                </div>
                            </div>
                            <div id="hidden-charges-${chargeRowCounter}" style="display: none;">
                              
                            </div>
                        </td>
                  `;

        tbody.append(newRow);
        initSelect2(newRow);
      },
      error: function(data) {
        console.log('Error fetching vehicle data:', data);
      }
    });
  }

  function initSelect2(row) {
    $(row).find('.select2').select2({
      width: '100%'
    });
  }

  function generateVehicle(data) {
    var options = '<option value="">Choose Vehicle</option>';
    for (var i = 0; i < data.length; i++) {
      options += '<option value="' + data[i].id_vehicle + '">' + data[i].vehicle_no + '(' + data[i].driver_name + ')</option>';
    }
    return options;
  }

  function generateCustomer(data) {
    var options = '<option value="">Choose Clients</option>';
    for (var i = 0; i < data.length; i++) {
      options += '<option value="' + data[i].customer_code_old + '">' + data[i].customer_name + '</option>';
    }
    return options;
  }

  function hapus_baris(button, event) {

    event.preventDefault();

    var userConfirmed = confirm("Do you want to delete this item ? the item cannot be restore !!");
    if (userConfirmed) {

      var id = $(button).data('id');
      var row = $(button).closest('tr');

          if (id != "") {
            $.ajax({
              type: "post",
              url: "<?= site_url('Tims/delete_job_dtl') ?>",
              data: {
                id: id
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
                if (response.msg == "success") {
                  row.remove();
                }
              }
            });
          } else {
            row.remove();
          }
    }
   
  }

  function restore_baris(button, event) {

      event.preventDefault();

      var userConfirmed = confirm("Do you want to restore this item ?");
      if (userConfirmed) {

        var id = $(button).data('id');
        var row = $(button).closest('tr');

            if (id != "") {
              $.ajax({
                type: "post",
                url: "<?= site_url('tims/restore_job_dtl') ?>",
                data: {
                  id: id
                },
                dataType: "json",
                success: function(response) {
                
                  if (response.msg == "success") {
                    location.reload("<?=site_url('tims/job-edit/')?>/" + id)
                  }
                }
              });
            } 
      }

}

$('#filterbutton').click(function (e) { 
  e.preventDefault();

   $('#dtl_item').html("");

  // current Date
  var tgl = $("input[name='current_date']").val();
  var vehicle = $('#id_vehicle_filter').val();


   $.ajax({
    type: "get",
    url: "<?=site_url('tims/filter')?>",
    data: {
       tgl:tgl,
       vehicle:vehicle
    },
    dataType: "html",
    success: function (response) {
      $('#dtl_item').html(response);
    }
   });
});

  function fnDialogModalFind() {
    // Define the Dialog and its properties.
    $("#modalDialogFind").dialog({
      resizable: false,
      modal: true,
      title: "List Job Driver",
      height: 650,
      width: 1200

    });
  }

  function filterJoball() {
    var current_date_start = document.getElementById("current_date_start").value;
    var current_date_end = document.getElementById("current_date_end").value;

    $("#findBody").html("");

    $.ajax({
      url: "<?php echo base_url(); ?>tims/findJob",
      data: {
        current_date_start: current_date_start,
        current_date_end: current_date_end
      },
      method: 'GET',
      dataType: "html",
      beforeSend: function() {
        $("#loader").show();
      },
      success: function(response) {
        if (response == '') {
          $("#findBody").html("<tr><td class='text-center' colspan='4'>List Empty</td></tr>");
        } else {
          $("#findBody").html(response);
        }

      },
      complete: function() {
        $("#loader").hide();
      }
    });
  }
</script>