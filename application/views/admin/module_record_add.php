<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4 mt-5">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <center>
                <h5 class="font-weight-bolder text-white">Add <?= htmlspecialchars($module->name); ?></h5>
            </center>
        </div>
    </div>

    <div class="card-body">
      <form method="POST" action="<?= base_url('admin/save_record/'.$module->hash) ?>" enctype="multipart/form-data" class="multisteps-form__form">

        <div class="pt-3 border-radius-xl bg-white" data-animation="FadeIn">
          <div class="multisteps-form__content">
            <div class="row mt-3">
              <?php foreach ($fields as $f): ?>
                <div class="col-12 col-sm-12">
                  <label for="<?= $f->name ?>"><?= htmlspecialchars($f->label) ?></label>
                  <div class="input-group input-group-static m-2">

                    <?php if ($f->type == 'textarea'): ?>
                      <textarea class="form-control" name="<?= $f->name ?>" id="<?= $f->name ?>" rows="5"></textarea>

                    <?php elseif ($f->type == 'file'): ?>
                      <input type="file" name="<?= $f->name ?>" id="<?= $f->name ?>">

                    <?php elseif ($f->type == 'relation'): ?>
                      <?php
                        $relMod = $this->db->get_where('modules', ['name' => $f->relation_module])->row();
                        $relData = $this->db->get($relMod->table_name)->result();
                      ?>
                      <select name="<?= $f->name ?>" id="<?= $f->name ?>" class="form-control chosen-select">
                        <option value="">Select <?= htmlspecialchars($f->label) ?></option>
                        <?php foreach ($relData as $rd): ?>
                          <option value="<?= $rd->id ?>"><?= $rd->{$f->relation_field} ?></option>
                        <?php endforeach; ?>
                      </select>

                    <?php else: ?>
                      <input class="form-control" type="<?= $f->type ?>" name="<?= $f->name ?>" id="<?= $f->name ?>" placeholder="<?= htmlspecialchars($f->label) ?>">
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="text-end m-3 mt-5">
              <a href="<?= base_url('admin/module/'.$module->hash) ?>" class="btn btn-outline-secondary me-2">Cancel</a>
              <button type="submit" class="btn bg-gradient-primary">Submit</button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replaceAll(function (textarea, config) {
    config.width = '100%';
  });
</script>


<?php $this->load->view('admin/footer'); ?>
