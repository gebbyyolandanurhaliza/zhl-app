<script type="text/javascript">
  var addedrows = new Array();
  $(document).ready(function() {
    $("#tabel_gl tbody tr").on("click", function(event) {
      var ok = 0;
      var theid = $(this).attr('id').replace("sour", "");
      var sum = 0;
      var rater = 0;
      var newaddedrows = new Array();

      for (index = 0; index < addedrows.length; ++index) {
        if (addedrows[index] == theid) {
          $(this).css("color", "#333");
          var tr = $("#dest" + theid);
          tr.css("color", "#FF)000");
          tr.fadeOut(400, function() {
            tr.remove();
            //rate();
            debit();
            hitung_amount();
          });
          ok = 1;
        } else {
          newaddedrows.push(addedrows[index]);
        }

      }
      addedrows = newaddedrows;
      var gst_select = 'FALSE';
      if (!ok) {
        addedrows.push(theid);

        $(this).css("color", "#AAAAAA");
        $('#tabel tr:last').after('<tr id="dest' + theid + '"><td><button class="tombol" onclick="hapus_list(this)" type="button">Remove</button></td>\n\
                     <td><input type="number" name="sort_num[]" class="txt"/></td>\n\
                    <td><input type="hidden" name="item_id[]" value="' + $(this).find("td").eq(0).html() + '" /><input type="text" name="item_code[]" class="txt" value="' + $(this).find("td").eq(2).html() + '" readonly /></td>\n\
                    <td><input type="text" class="txt" value="' + $(this).find("td").eq(3).html() + '"/></td>\n\
                    <td><input type="text" class="txt" value="' + $(this).find("td").eq(4).html() + '"/></td>\n\
                    <td><input type="text" class="txt" value="' + $(this).find("td").eq(5).html() + '"/></td>\n\
                    <td><input type="text" class="txt" onkeypress="return isNumber(event)" name="price[]" value="" /></td>\n\
                    </tr>');
      }

      // Tombol Up
      $('.tombol_up').click(function() {
        var row = $(this).parents('tr');
        if (row.index() > 0) { // Memastikan bukan baris pertama
          row.prev().before(row);
        }
      });

      // Tombol Down
      $('.tombol_down').click(function() {
        var row = $(this).parents('tr');
        row.next().after(row);
      });
    });

  });
</script>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  <h4 class="modal-title">Choose Item</h4>
  <input class="form-control" type="text" id="search" placeholder="search">
</div>
<div class="modal-body">
  <section class="">
    <div class="contain">
      <div>
        <table class="datatable table table-bordered table-hover" id="tabel_gl">
          <thead>
            <tr class="header">
              <th hidden>Item ID</th>
              <th>No.</th>
              <th>Item Number<div>Item Number</div>
              </th>
              <th>Item Name<div>Item Name</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($_isi)) {

              $no = 1;
              foreach ($_isi as $r) {
            ?>
                <tr style="cursor: pointer;" id="sour<?php echo $no; ?>">
                  <td hidden><?= $r->Id; ?></td>
                  <td><?= $no; ?></td>
                  <td><?= $r->Item_number; ?></td>
                  <td><?= $r->Item_name; ?></td>
                  <td hidden><?= $r->Income_coa; ?></td>
                  <td hidden><?= $r->expenses_coa; ?></td>
                </tr>
            <?php
                $no++;
              }
            } else {
              echo "data not avaible";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
<div class="modal-footer">
  <button type="button" class="btn red" data-dismiss="modal">Close</button>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#search").keyup(function() {
      _this = this;
      $.each($("#tabel_gl tbody tr"), function() {
        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
          $(this).hide();
        else
          $(this).show();
      });
    });

  });

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode === 8 || charCode === 9 || charCode === 37 || charCode === 39 || charCode === 46 || (charCode > 47 && charCode < 58)) {
      return true;
    }
    return false;
  }
</script>