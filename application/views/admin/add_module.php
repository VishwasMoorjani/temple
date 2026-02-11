<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>
<div class="container-fluid py-4 mt-5">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <center>
                <h5 class="font-weight-bolder text-white">Module Information</h5>
            </center>
        </div>
    </div>

    <div class="card-body">
      <form id="moduleForm" method="POST" action="<?= base_url('admin/save_module') ?>" enctype="multipart/form-data">

        <div class="pt-3 border-radius-xl bg-white">
          <div class="multisteps-form__content">
            <div class="row mt-3">
              <div class="col-12 col-sm-6">
                <div class="input-group input-group-static m-2">
                  <label for="module_name">Module Name *</label>
                  <input class="form-control" type="text" name="module_name" id="module_name" placeholder="e.g. Sliders" required>
                </div>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <div class="input-group input-group-static m-2">
                  <label for="table_name">Table Name *</label>
                  <input class="form-control" type="text" name="table_name" id="table_name" placeholder="e.g. sliders" required>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-12">
                <div class="input-group input-group-static m-2">
                  <label>Module Fields</label>
                </div>

                <div class="table-responsive">
                  <table class="table align-items-center mb-0" id="fieldsTable">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Field Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Label</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="text" class="form-control field-name" placeholder="title"></td>
                        <td>
                          <select class="form-control field-type">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="file">File</option>
                            <option value="number">Number</option>
                            <option value="select">Select</option>
                            <option value="relation">Relation</option>
                            </select>
                            <div class="relation-options mt-2" style="display:none;">
                            <select class="form-control relation-module mb-2">
                                <option value="">Select Related Module</option>
                                <?php foreach ($modules as $mod): ?>
                                <option value="<?= $mod->name ?>"><?= $mod->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" class="form-control relation-field" placeholder="Display Field (e.g. name)">
                            </div>

                        </td>

                        
                        <td><input type="text" class="form-control field-label" placeholder="Title"></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-danger remove-field">×</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="m-2">
                  <button type="button" id="addField" class="btn bg-gradient-info btn-sm mt-3">+ Add Field</button>
                </div>
              </div>
            </div>

            <input type="hidden" name="fields_json" id="fields_json">
            <div class="m-2 text-end">
              <button type="submit" class="btn bg-gradient-primary mt-4 mb-0">Save Module</button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(function() {

  // Safe module list from PHP -> pure JSON
  const modulesList = <?= json_encode(
    array_map(fn($m) => ['name' => $m->name], $modules ?? [])
  ); ?>;

  // Build relation options HTML
  const relationOptions = modulesList.map(m => 
    `<option value="${m.name}">${m.name}</option>`
  ).join('');

  // Add new field row
  $('#addField').on('click', function() {
    const newRow = `
      <tr>
        <td><input type="text" class="form-control field-name" placeholder="field_name"></td>
        <td>
          <select class="form-control field-type">
            <option value="text">Text</option>
            <option value="textarea">Textarea</option>
            <option value="file">File</option>
            <option value="number">Number</option>
            <option value="select">Select</option>
            <option value="relation">Relation</option>
          </select>
          <div class="relation-options mt-2" style="display:none;">
            <select class="form-control relation-module mb-2">
              <option value="">Select Related Module</option>
              ${relationOptions}
            </select>
            <input type="text" class="form-control relation-field" placeholder="Display Field (e.g. name)">
          </div>
        </td>
        <td><input type="text" class="form-control field-label" placeholder="Label"></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger remove-field">×</button>
        </td>
      </tr>`;
    $('#fieldsTable tbody').append(newRow);
  });

  // Remove a field row
  $(document).on('click', '.remove-field', function() {
    $(this).closest('tr').remove();
  });

  // Toggle relation inputs
  $(document).on('change', '.field-type', function() {
    const isRelation = $(this).val() === 'relation';
    $(this).closest('td').find('.relation-options').toggle(isRelation);
  });

  // Convert to JSON before submit
  $('#moduleForm').on('submit', function() {
    const fields = [];
    $('#fieldsTable tbody tr').each(function() {
      const name  = $(this).find('.field-name').val().trim();
      const type  = $(this).find('.field-type').val();
      const label = $(this).find('.field-label').val().trim();
      const relation_module = $(this).find('.relation-module').val();
      const relation_field  = $(this).find('.relation-field').val().trim();
      if (name) fields.push({ name, type, label, relation_module, relation_field });
    });
    $('#fields_json').val(JSON.stringify(fields));
  });

});
</script>

<?php $this->load->view('admin/footer'); ?>
