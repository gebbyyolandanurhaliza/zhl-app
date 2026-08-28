<?php
// Hitung total kolom
$totalCol = 22;
?>

<!-- ===== TABEL PSS ===== -->
<h4 style="margin: 10px 0 5px; padding-left: 5px;">
  <strong><i class="fa fa-table"></i> PSS</strong>
  <span class="badge"><?= count($shipping_liner) ?></span>
</h4>
<div class="table-scrollable" style="overflow: auto; height: 400px;">
  <table class="table table-bordered table-hover table-condensed" id="tblmon-pss">
    <thead>
      <tr>
        <th nowrap>Shipment Date</th>
        <th nowrap>Factory</th>
        <th nowrap>Barge</th>
        <th nowrap>To</th>
        <th nowrap>From</th>
        <th nowrap>PO Number</th>
        <th nowrap>Customer</th>
        <th nowrap>Shipping Liner</th>
        <th nowrap>Container Type</th>
        <th nowrap>Port - Destination</th>
        <th nowrap>Reff</th>
        <th nowrap>Vessel</th>
        <th nowrap>Depot</th>
        <th nowrap>POD</th>
        <th nowrap>OP Code</th>
        <th nowrap>ETA Sin</th>
        <th nowrap>ETA Dest</th>
        <th nowrap>Container</th>
        <th nowrap>Actual Seal</th>
        <th nowrap>Weight</th>
        <th nowrap>Stuffing</th>
        <th nowrap>Jurnal Barge Sales</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($shipping_liner)) : ?>
        <?php foreach ($shipping_liner as $r) : ?>
          <tr onclick="clickdb(this);" style="cursor: pointer;">
            <td nowrap name="ship[]"><?= date("d/m/Y", strtotime($r->shipmentdate)) ?></td>
            <td nowrap><?= $r->factory_name ?></td>
            <td nowrap><?= $r->barge ?></td>
            <td nowrap><?= $r->to ?></td>
            <td nowrap><?= $r->from ?></td>
            <td nowrap><?= $r->po_number ?></td>
            <td nowrap><?= $r->customer_name ?></td>
            <td nowrap><?= $r->shipping_liner ?></td>
            <td nowrap><?= $r->container_name ?></td>
            <td nowrap><?= $r->port_name . ' - ' . $r->destination_si ?></td>
            <td nowrap><?= $r->reff ?></td>
            <td nowrap><?= $r->vessel ?></td>
            <td nowrap><?= $r->depot ?></td>
            <td nowrap><?= $r->pod ?></td>
            <td nowrap><?= $r->opcode ?></td>
            <td nowrap><?= $r->etdsin ?></td>
            <td nowrap><?= $r->etasin ?></td>
            <td nowrap><?= $r->container ?></td>
            <td nowrap><?= $r->actual_seal ?></td>
            <td nowrap class="text-right"><?= number_format($r->weight, 2) ?></td>
            <td nowrap><?= $r->stuffing ?></td>
            <td nowrap><?= $r->jurnal_barge_sales ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="<?= $totalCol ?>" class="text-center text-muted">
            <i class="fa fa-inbox"></i> No data (PSS)
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- ===== TABEL GGFS ===== -->
<h4 style="margin: 20px 0 5px; padding-left: 5px;">
  <strong><i class="fa fa-table"></i> GGFS</strong>
  <span class="badge"><?= count($shipping_liner_ggfs) ?></span>
</h4>
<div class="table-scrollable" style="overflow: auto; height: 400px;">
  <table class="table table-bordered table-hover table-condensed" id="tblmon-ggfs">
    <thead>
      <tr>
        <th nowrap>Shipment Date</th>
        <th nowrap>Factory</th>
        <th nowrap>Barge</th>
        <th nowrap>To</th>
        <th nowrap>From</th>
        <th nowrap>PO Number</th>
        <th nowrap>Customer</th>
        <th nowrap>Shipping Liner</th>
        <th nowrap>Container Type</th>
        <th nowrap>Port - Destination</th>
        <th nowrap>Reff</th>
        <th nowrap>Vessel</th>
        <th nowrap>Depot</th>
        <th nowrap>POD</th>
        <th nowrap>OP Code</th>
        <th nowrap>ETA Sin</th>
        <th nowrap>ETA Dest</th>
        <th nowrap>Container</th>
        <th nowrap>Actual Seal</th>
        <th nowrap>Weight</th>
        <th nowrap>Stuffing</th>
        <th nowrap>Jurnal Barge Sales</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($shipping_liner_ggfs)) : ?>
        <?php foreach ($shipping_liner_ggfs as $r) : ?>
          <tr onclick="clickdb(this);" style="cursor: pointer;">
            <td nowrap name="ship[]"><?= date("d/m/Y", strtotime($r->shipmentdate)) ?></td>
            <td nowrap><?= $r->factory_name ?></td>
            <td nowrap><?= $r->barge ?></td>
            <td nowrap><?= $r->to ?></td>
            <td nowrap><?= $r->from ?></td>
            <td nowrap><?= $r->po_number ?></td>
            <td nowrap><?= $r->customer_name ?></td>
            <td nowrap><?= $r->shipping_liner ?></td>
            <td nowrap><?= $r->container_name ?></td>
            <td nowrap><?= $r->port_name . ' - ' . $r->destination_si ?></td>
            <td nowrap><?= $r->reff ?></td>
            <td nowrap><?= $r->vessel ?></td>
            <td nowrap><?= $r->depot ?></td>
            <td nowrap><?= $r->pod ?></td>
            <td nowrap><?= $r->opcode ?></td>
            <td nowrap><?= $r->etdsin ?></td>
            <td nowrap><?= $r->etasin ?></td>
            <td nowrap><?= $r->container ?></td>
            <td nowrap><?= $r->actual_seal ?></td>
            <td nowrap class="text-right"><?= number_format($r->weight, 2) ?></td>
            <td nowrap><?= $r->stuffing ?></td>
            <td nowrap><?= $r->jurnal_barge_sales ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="<?= $totalCol ?>" class="text-center text-muted">
            <i class="fa fa-inbox"></i> No data (GGFS)
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>