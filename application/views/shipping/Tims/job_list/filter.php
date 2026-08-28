<?php
foreach ($search as $key => $value) { ?>
  <tr>
    <td class="text-center">
      <a class="btn-sm btn-warning" title="Edit" href="<?= site_url('tims/job-edit/' . $value->id_job_hdr) ?>"><i class="fa fa-pencil"></i></a>
      <a class="btn-sm btn-danger" title="Delete" href="<?= site_url('tims/job-delete/' . $value->id_job_hdr) ?>" onclick="return confirm('Are You Sure to Delete This Data ?')"><i class="fa fa-trash"></i></a>
    </td>
    <td class="text-center"><?= convert_tgl_2($value->current_date); ?> </td>
    <td class="text-center"><?= $value->createdby; ?></td>
    <td class="text-center"><?= $value->createddate; ?></td>
  </tr>
<?php
}
?>