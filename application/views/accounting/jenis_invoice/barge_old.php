<div class="page-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-7">
          <div class="note note-success note-bordered">
            <p>
              This is Master Invoce OF Barge.
            </p>
          </div>
          <!-- BEGIN PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-speech theme-font"></i>
                <span class="caption-subject bold uppercase"> Number Of COA</span>
                <span class="caption-helper">Master Number of COA</span>
              </div>
              <div class="kanan">
                <a class="btn green" href="<?php echo base_url(); ?>Excel/toExcelCoa"><i class="fa fa-file-excel-o"></i> Export to excel</a>
              </div>
            </div>
            <div class="portlet-body">
              <table class="datatable table table-bordered table-hover" id="datatable2">
                <thead>
                  <tr>
                    <th>Container</th>
                    <th hidden>Container ID</th>
                    <th>Form - To</th>
                    <th hidden></th>
                    <th>Price</th>
                    <th>Exp. Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($_listbarge)) {
                    // echo "ada";
                    foreach ($_listbarge as $v) {
                      if ($v->dest_type == 1) {
                        $a = "Singapore - Sei Guntung";
                      } else {
                        $a = "Sei Guntung - Singapore";
                      }
                      $tgl = date('d/m/Y', strtotime($v->expiredate));
                  ?>
                      <tr onclick="pilih(this)" style="cursor: pointer;">
                        <?php
                        echo "<td>$v->container_name</td>"
                          . "<td hidden>$v->container_type</td>"
                          . "<td>$a</td>"
                          . "<td hidden>$v->dest_type</td>"
                          . "<td>$v->Harga</td>"
                          . "<td>$tgl</td>";
                        ?>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- END PORTLET-->
        </div>
        <div class="col-md-5">

          <?php //echo $message; 
          ?>

          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption theme-font">
                <i class="icon-calculator theme-font"></i>
                <span class="caption-subject bold uppercase"> FORM</span>
                <span class="caption-helper">Master Of Barge</span>
              </div>
              <div class="tools">
                <a href="javascript:;" class="collapse">
                </a>
              </div>
              <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title="">
                </a>
              </div>
            </div>
            <div class="portlet-body">
              <!-- FORM MASTER COA -->
              <form role="form" method="post" action="<?php echo base_url(); ?>Barge/save_barge">
                <div class="form-group">
                  <label class="control-label">Container Type</label>
                  <?php
                  $style_currency = "class='form-control' id='cont' onchange='getnama()' ";
                  echo form_dropdown('cont', $_container, '', $style_currency);
                  ?>
                  <input type="hidden" name="ct_name" id="ct_name" value="">
                  <script>
                    function getnama() {
                      var nama = $("#cont :selected").text();
                      $("#ct_name").val(nama);
                      // alert(nama);
                    }
                  </script>
                </div>

                <div class="form-group">
                  <label class="control-label">Form - To</label>
                  <select name="dest" id="dest" class="form-control">
                    <option value="1">Singapore - Sei Guntung</option>
                    <option value="2">Sei Guntung - Singapore</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Price</label>
                  <input type="text" id="price" name="price" class="form-control" required />
                </div>
                <div class="form-group">
                  <label class="control-label">Exp. Date</label>
                  <input type="text" id="exp" name="exp" class="form-control date date-picker" data-date-format="dd/mm/yyyy" required />
                </div>
                <div class="margiv-top-10">
                  <input type="submit" name="sbt" id="tombol" class="btn blue-dark" value="Save">
                </div>

              </form>
              <!-- FORM MASTER COA -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END PROFILE CONTENT -->
</div>
</div>
<!-- END PAGE CONTENT INNER -->
</div>
<!-- END PAGE CONTENT -->

<script>
  function pilih(x) {

    function getText(el) {
      if (typeof el.textContent === 'string')
        return el.textContent;
      if (typeof el.innerText === 'string')
        return el.innerText;
    }

    $r = x.rowIndex;
    var url = "<?php echo base_url(); ?>";

    var nama_cont = getText(document.getElementById('datatable2').rows[$r].cells[0]);
    var id_cont = getText(document.getElementById('datatable2').rows[$r].cells[1]);
    var id_dest = getText(document.getElementById('datatable2').rows[$r].cells[3]);
    var harga = getText(document.getElementById('datatable2').rows[$r].cells[4]);
    var tgli = getText(document.getElementById('datatable2').rows[$r].cells[5]);
    console.log(harga);
    console.log(id_dest);
    console.log(tgli);

    document.getElementById('cont').value = id_cont;
    document.getElementById('ct_name').value = nama_cont;
    document.getElementById('dest').value = id_dest;
    document.getElementById('price').value = harga;
    // document.getElementById('price').value = harga;
    $("#exp").val(tgli);
    document.getElementById('tombol').value = 'Update';
    $('body').scrollTop(0);
  }

  function cek_coa() {
    var NoCOA = document.getElementById('NoCOA').value;
    $.ajax({
      url: "<?php echo base_url(); ?>Master_COA/cek_coa?id=" + NoCOA,
      success: function(response) {
        $("#err").html(response);
      },
      dataType: "html"
    });
  }

  function ubah() {
    var t = document.getElementById("RegNo");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('GroupCOA').value = selectedText;
  }

  function ubah_group() {
    var t = document.getElementById("id_journal");
    var selectedText = t.options[t.selectedIndex].text;
    document.getElementById('GroupJournal').value = selectedText;
  }
  $(document).ready(function() {
    $("#datatable2").dataTable({
      "scrollY": 350,
      "scrollX": true
    });
  });
</script>