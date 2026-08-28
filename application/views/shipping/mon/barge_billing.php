<div class="modal-body">

    <div class="table-scrollable-borderless">

        <table id="tbl_filter_po" class="table table-bordered">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>FACTORY</th>
                    <th>Stuffing</th>
                    <th>CT</th>
                    <th>C20</th>
                    <th>C40</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($billing as $rec) {
                    echo "<tr>";
                    echo "<td class='text-center'>$rec->po_number</td>";
                    echo "<td class='text-center'>$rec->factory_abbr</td>";
                    echo "<td class='text-center'>$rec->stuffing</td>";
                    echo "<td class='text-center'>$rec->container_abbr</td>";
                    echo "<td class='text-center'>$rec->c20</td>";
                    echo "<td class='text-center'>$rec->c40</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>