<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4 mt-5">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
      <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
        <center>
          <h5 class="font-weight-bolder text-white">Edit <?= htmlspecialchars($module->name) ?></h5>
        </center>
      </div>
    </div>

    <div class="card-body">
      <form method="POST" action="<?= base_url('admin/update_record/'.$module->hash.'/'.$record->id) ?>" enctype="multipart/form-data">
        <div class="row">
          <?php foreach ($fields as $f): ?>
            <div class="col-md-12 mb-3">
              <label for="<?= $f->name ?>" class="form-label"><?= htmlspecialchars($f->label) ?></label>

              <?php if ($f->type == 'textarea'): ?>
                <textarea name="<?= $f->name ?>" class="form-control"><?= htmlspecialchars($record->{$f->name}) ?></textarea>

              <?php elseif ($f->type == 'file'): ?>
                <div class="input-group input-group-static m-2">
                  <?php if (!empty($record->{$f->name})): ?>
                    <div class="input-group input-group-static m-2">
                      <img src="<?= base_url('assets/front/images/'.$record->{$f->name}) ?>" height="60" class="rounded shadow-sm border">
                    </div>
                    <div class="btn btn-primary m-2" style="border-radius:0.5rem" onclick="removeFile('<?= $f->name ?>', <?= $record->id ?>)">Remove Image</div>
                  <?php else: ?>
                    <div class="input-group input-group-static m-2">
                      <input type="file" name="<?= $f->name ?>" accept="image/*" />
                    </div>
                  <?php endif; ?>
                </div>

              <?php elseif ($f->type == 'relation'): ?>
                <?php
                  $relMod = $this->db->get_where('modules', ['name' => $f->relation_module])->row();
                  $relData = $this->db->get($relMod->table_name)->result();
                ?>
                <select name="<?= $f->name ?>" class="form-control">
                  <option value="">Select <?= htmlspecialchars($f->label) ?></option>
                  <?php foreach ($relData as $rd): ?>
                    <option value="<?= $rd->id ?>" <?= $rd->id == $record->{$f->name} ? 'selected' : '' ?>>
                      <?= htmlspecialchars($rd->{$f->relation_field}) ?>
                    </option>
                  <?php endforeach; ?>
                </select>

              <?php else: ?>
                <input type="<?= $f->type ?>" name="<?= $f->name ?>" class="form-control" value="<?= htmlspecialchars($record->{$f->name}) ?>">
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="text-end mt-4">
          <a href="<?= base_url('admin/module/'.$module->hash) ?>" class="btn btn-outline-secondary me-2">Cancel</a>
          <button type="submit" class="btn bg-gradient-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replaceAll(function (textarea, config) {
    config.width = '100%';
  });

  function removeFile(field, id) {
    if (!confirm("Are you sure you want to remove this image?")) return;
    $.ajax({
      url: "<?= base_url('admin/remove_file/'.$module->hash) ?>/" + id + "/" + field,
      type: "POST",
      success: function(result) {
        if (result.trim() === "done") {
          location.reload();
        }
      }
    });
  }
</script>

<?php $this->load->view('admin/footer'); ?>
