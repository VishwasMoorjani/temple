<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4 mt-5">

  <div class="card mb-4">
    <div class="card-header pb-0">
      <div class="d-lg-flex">
        <div>
          <h5 class="mb-0">Manage <?= htmlspecialchars($module->name); ?></h5>
        </div>
        <div class="ms-auto my-auto mt-lg-0 mt-4">
          <div class="ms-auto my-auto">
            <a href="<?= base_url('admin/add_record/'.$module->hash) ?>" class="btn bg-gradient-primary btn-sm mb-0">+ Add New</a>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body px-0 pb-0">
      <div class="table-responsive">
        <table class="table table-flush" id="dynamic-list">
          <thead>
            <tr>
              <?php foreach ($fields as $f):
                if ($f->type == 'textarea') continue; ?>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  <?= ucfirst($f->label) ?>
                </th>
              <?php endforeach; ?>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($records as $r): ?>
              <tr>
                <?php foreach ($fields as $f): 
                  if ($f->type == 'textarea') continue; ?>
                  <td>
                    <?php if ($f->type == 'relation'): ?>
                      <?php
                        $relMod = $this->db->get_where('modules', ['name' => $f->relation_module])->row();
                        $related = $this->db->get_where($relMod->table_name, ['id' => $r->{$f->name}])->row();
                        echo $related ? htmlspecialchars($related->{$f->relation_field}) : '-';
                      ?>
                    <?php elseif ($f->type == 'file'): ?>
                      <img src="<?= base_url('assets/front/images/'.$r->{$f->name}) ?>" height="40" alt="">
                    <?php else: ?>
                      <?= htmlspecialchars($r->{$f->name}) ?>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>

                <td class="text-center">
                  <?php if ($r->status == 1): ?>
                    <a href="<?= base_url('admin/deactivate_record/'.$module->hash.'/'.$r->id) ?>" class="badge bg-gradient-success">Active</a>
                  <?php else: ?>
                    <a href="<?= base_url('admin/activate_record/'.$module->hash.'/'.$r->id) ?>" class="badge bg-gradient-secondary">Inactive</a>
                  <?php endif; ?>
                </td>

                <td class="text-center">
                  <a href="<?= base_url('admin/edit_record/'.$module->hash.'/'.$r->id) ?>" class="text-primary text-xs me-2">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="<?= base_url('admin/delete_record/'.$module->hash.'/'.$r->id) ?>" 
                     class="text-danger text-xs"
                     onclick="return confirm('Delete this record?')">
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('admin/footer'); ?>

<script>
if (document.getElementById('dynamic-list')) {
  const dataTableSearch = new simpleDatatables.DataTable("#dynamic-list", {
    searchable: true,
    fixedHeight: false,
    perPage: 15
  });
}
</script>
