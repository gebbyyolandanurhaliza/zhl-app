<style>
  #input {
    font-size: 13px;
    font-family: Arial, sans-serif;
    border: 0px solid #ccc;
    color: #333;
    background-color: #f5f5f5;
    border-radius: 5px;
    padding: 3px;
    margin-bottom: 5px;
  }

  .myLoading {
    display: none;
    margin: 0 auto;
    text-align: center;
  }

  .myLoading-bar {
    display: inline-block;
    width: 6px;
    height: 18px;
    margin: 0 3px;
    background-color: #333;
    animation: loading 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
  }

  .myLoading-bar:nth-child(1) {
    animation-delay: -0.45s;
  }

  .myLoading-bar:nth-child(2) {
    animation-delay: -0.3s;
  }

  .myLoading-bar:nth-child(3) {
    animation-delay: -0.15s;
  }

  @keyframes loading {
    0% {
      transform: scale(1);
    }

    20% {
      transform: scale(1, 2.5);
    }

    40% {
      transform: scale(1);
    }
  }
</style>

<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-table theme-font"></i>

              <span class="caption-subject theme-font">Form Import Outward / Inward List</span>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"></a>
              <a href="javascript:;" class="reload"></a>
            </div>
          </div>
          <div class="portlet-body" style="margin-bottom: 50px;">
            <div class="form-body">
              <div class="row">

                <div class="col-md-12">
                  <form id="form-import-excel" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-md-2 col-lg-1">Choose File</label>
                      <div class="col-md-6 col-lg-4">
                        <input type="file" class="form-control" id="input-excel" name="excel_file" accept=".xlsx,.xls" />
                        <small class="form-text text-muted text-danger">Accepted file types: .xlsx, .xls</small>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-md-offset-1 col-md-9">
                </div>
              </div>
            </div>
            <hr>

            <div class="myLoading">
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
            </div>
            <div class="previewImportExcel" style="padding-left: 15px;"></div>
            <div x-date='postData()' x-init="init()">

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption">
              <span class="caption-subject theme-font"> List Of Import Outward / Inward</span>
            </div>
          </div>
          <div class="portlet-body">

            <div class="row">
              <form class="filter-search">
                <div class="form-group col-md-3">
                  <label for="inputEmail4">Customer</label>
                  <select class="form-control select2me" data-placeholder="..." name="customer">
                    <option></option>
                    <?php foreach ($list_customer as $val) : ?>
                      <option><?= ucwords(strtolower($val->customer))  ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-3">
                  <label for="inputEmail4">Shipement Date</label>
                  <select class="form-control select2me" name="shipment_date" data-placeholder="...">
                    <option></option>
                    <?php foreach ($list_shipment_date as $val) : ?>
                      <option value="<?= $val->shipmentdate ?>"><?= setDateFormat($val->shipmentdate, "d/m/Y") ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="inputEmail4">Keyword</label>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="margin-right: 10px;">@</span>
                    <div class="row">
                      <div class="col-md-8 col-lg-4" style="padding:0px;">
                        <select class="form-control field" style="width: 100%; margin-left: 10px;" name="field">
                          <option value="0">Choose One</option>
                          <option>Barge</option>
                          <option>Voyage</option>
                          <option>Eta</option>
                          <option>Etd</option>
                        </select>
                      </div>
                      <div class="col-md-4 col-lg-7" style="padding:0px; margin-left: 10px;">
                        <input type="text" class="form-control keyword" placeholder="Keyword" aria-describedby="basic-addon1" name="keyword" style="width: 100%; float:left" autofocus>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-2 col-lg-1 col-sm-3">
                  <label for="inputEmail4">&nbsp;</label>
                  <button type="button" onclick="refresh()" class="btn btn-danger form-control btn-refresh"><span class="fa fa-search"></span> Refresh</button>
                </div>
              </form>
            </div>

            <hr>

            <div class="loadingRefresh text-center" style="display: none;">
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
              <div class="myLoading-bar"></div>
            </div>

            <div class="loadLastImport">


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>













  <script>
    $(".keyword").attr("disabled", "disabled");

    $(document).ready(function() {
      refresh();

      $(".filter-search input").keypress(function(event) {
        if (event.keyCode === 13) {
          event.preventDefault();
          refresh();
        }
      });
    });

    // Mengambil element loading
    const loadingEl = document.querySelector('.myLoading');

    document.querySelector('#input-excel').addEventListener('change', function(evt) {
      evt.preventDefault();
      var formData = new FormData(document.querySelector('#form-import-excel'));

      // Menampilkan animasi loading
      loadingEl.style.display = 'block';

      fetch('<?= base_url('Shipping/import') ?>', {
          method: 'POST',
          body: formData,
        })
        .then(response => response.text())
        .then(data => {
          try {
            const jsonData = JSON.parse(data);
            setTimeout(function() {
              // alert(jsonData.message);
              swal("Failed", jsonData.message, 'error')

              loadingEl.style.display = 'none';
              document.querySelector('.load-data').remove();
            }, 1000);
          } catch (error) {
            setTimeout(function() {
              document.querySelector('.previewImportExcel').innerHTML = data;
              loadingEl.style.display = 'none';

            }, 1000);
          }
        })
        .catch(error => console.error(error));

    });

    $(document).on('click', '.btn-save', function() {
      var form_data = new FormData($("#form-data")[0]);

      swal({
          title: "Are you sure?",
          text: "You will not be able to recover this data!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#1E90FF',
          confirmButtonText: 'Yes, Save !',
          cancelButtonText: "No, cancel it!",
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true

        },
        function(isConfirm) {

          if (isConfirm) {
            fetch('<?= base_url('Shipping/importAction') ?>', {
                method: 'POST',
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                },
                body: form_data,
                processData: false,
                contentType: false,
              })
              .then(response => response.json())
              .then(data => {

                setTimeout(() => {
                  if (data.code == 200) {
                    $('.loadReport').html(data);
                    swal("Success", data.message.toString(), 'success');
                    // window.location.href = "<?= base_url() ?>shipping/container_show?cont=" + data.message + "&tipe=2";
                    location.reload();
                  } else {
                    swal("Error", data.message.toString(), 'error');
                  }
                  $(".btn-save").prop("disabled", false);

                }, 2000);
              })
              .catch(error => {
                console.log(error);
              });

          } else {
            swal("Cancelled", "Ship To Inward List", "error");
          }
        });

    });

    function deleted(id) {
      swal({
          title: "Are you sure?",
          text: "You will not be able to recover this data!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, Deleted !',
          cancelButtonText: "No, cancel it!",
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true

        },
        function(isConfirm) {

          if (isConfirm) {
            fetch('<?= base_url('Shipping/deleteImport') ?>/' + id, {
                method: 'get',
                processData: false,
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                },
                contentType: false,
              })
              .then(response => response.json())
              .then(data => {

                setTimeout(() => {
                  if (data.code == 200) {
                    swal("Success", data.message.toString(), 'success');
                    location.reload();
                  } else {
                    swal("Error", data.message.toString(), 'error');
                  }

                }, 1500);
              })
              .catch(error => {
                console.log(error);
              });

          } else {
            swal("Cancelled", "Ship To Inward List", "error");
          }
        });

    }

    function refresh() {
      const loadingRefresh = document.querySelector('.loadingRefresh');
      const btnRefresh = document.querySelector('.btn-refresh');

      $(".table-last-import").remove();
      loadingRefresh.style.display = 'block';
      btnRefresh.disabled = true;

      var data = $(".filter-search").serialize();


      fetch('<?= base_url('Shipping/refreshMonImportInOutward') ?>?' + new URLSearchParams(data), {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
        })

        .then(response => response.text())
        .then(data => {
          try {
            const jsonData = JSON.parse(data);
            setTimeout(() => {
              swal("Failed", jsonData.message, 'error');
              loadingRefresh.style.display = 'none';

            }, 1000);
          } catch (error) {
            setTimeout(() => {
              document.querySelector('.loadLastImport').innerHTML = data;
              loadingRefresh.style.display = 'none';
              btnRefresh.disabled = false;
            }, 1000);
          }
        })
        .catch(console.error);
    }

    $(".field").change(function() {
      if ($(".field").find(":selected").val() == 0) {
        $(".keyword").attr("disabled", "disabled");
      } else {
        $(".keyword").removeAttr("disabled", "disabled");
      }
    })



    function pilih(element, contid) {
      Array.from(document.getElementsByTagName('tr')).forEach(row => row.style.color = row === element ? 'red' : 'black');

      fetch('<?= base_url('Shipping/show_import') ?>/' + contid, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
        })
        .then(response => response.text())
        .then(data => {
          document.querySelector('.previewImportExcel').innerHTML = data
          document.querySelector('.btn-save').disabled = true;
          document.querySelector('.btn-print').disabled = false;
          document.querySelector('.btn-delete').disabled = false;
        })
        .catch(error => console.error(error));
    }

    function downloadExcel(id) {
      // alert(id)
      // Open the URL in a new tab or window
      window.open(`<?= base_url('shipping/export_excel_import') ?>/${id}`, "_blank");
    }
  </script>