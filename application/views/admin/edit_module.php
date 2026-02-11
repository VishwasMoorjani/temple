<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4 mt-5">
  <div class="card">
    <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <center>
                <h5 class="font-weight-bolder text-white">Edit Module: <?= htmlspecialchars($module->name) ?></h5>
            </center>
        </div>
    </div>

    <div class="card-body">
      <form id="moduleForm" method="POST" action="<?= base_url('admin/update_module/'.$module->hash) ?>">

        <div class="pt-3 border-radius-xl bg-white">
          <div class="multisteps-form__content">

            <!-- Module Info -->
            <div class="row mt-3">
              <div class="col-12 col-sm-6">
                <div class="input-group input-group-static m-2">
                  <label for="module_name">Module Name *</label>
                  <input class="form-control" type="text" name="module_name" id="module_name"
                         value="<?= htmlspecialchars($module->name) ?>" required>
                </div>
              </div>
              <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                <div class="input-group input-group-static m-2">
                  <label for="table_name">Table Name *</label>
                  <input class="form-control" type="text" name="table_name" id="table_name"
                         value="<?= htmlspecialchars($module->table_name) ?>" required>
                </div>
              </div>
            </div>

            <!-- Fields Section -->
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
                    <tbody></tbody>
                  </table>
                </div>

                <div class="m-2">
                  <button type="button" id="addField" class="btn bg-gradient-info btn-sm mt-3">+ Add Field</button>
                </div>
              </div>
            </div>

            <!-- Hidden JSON -->
            <input type="hidden" name="fields_json" id="fields_json">

            <div class="m-2 text-end">
              <button type="submit" class="btn bg-gradient-success mt-4 mb-0">Update Module</button>
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
$(document).ready(function() {

  // ✅ Safely pass PHP JSON to JS
  let existingFields = <?= json_encode(json_decode($module->fields ?? '[]', true)); ?>;
  const modulesList = <?= json_encode(array_map(fn($m) => $m->name, $modules)); ?>;

  // Render existing fields (fix)
  if (Array.isArray(existingFields)) {
    existingFields.forEach(f => {
      $('#fieldsTable tbody').append(fieldRow(
        f.name || '',
        f.type || 'text',
        f.label || '',
        f.relation_module || '',
        f.relation_field || ''
      ));
    });
  }

  // Add new field
  $('#addField').click(function() {
    $('#fieldsTable tbody').append(fieldRow());
  });

  // Remove row
  $(document).on('click', '.remove-field', function() {
    $(this).closest('tr').remove();
  });

  // Toggle relation options
  $(document).on('change', '.field-type', function() {
    const relOptions = $(this).closest('td').find('.relation-options');
    relOptions.toggle($(this).val() === 'relation');
  });

  // Prepare JSON before submit
  $('#moduleForm').submit(function() {
    const fields = [];
    $('#fieldsTable tbody tr').each(function() {
      const name = $(this).find('.field-name').val().trim();
      const type = $(this).find('.field-type').val();
      const label = $(this).find('.field-label').val().trim();
      const relation_module = $(this).find('.relation-module').val() || '';
      const relation_field = $(this).find('.relation-field').val().trim() || '';

      if (name) {
        const f = { name, type, label };
        if (type === 'relation') {
          f.relation_module = relation_module;
          f.relation_field = relation_field;
        }
        fields.push(f);
      }
    });
    $('#fields_json').val(JSON.stringify(fields));
  });

  // Escape helper
  function esc(s) {
    return $('<div>').text(s || '').html();
  }

  // Create module options for relation dropdown
  function moduleOptions(selected = '') {
    return ['<option value="">Select Related Module</option>']
      .concat(modulesList.map(m =>
        `<option value="${esc(m)}" ${m === selected ? 'selected' : ''}>${esc(m)}</option>`
      ))
      .join('');
  }

  // Row builder
  function fieldRow(name = '', type = 'text', label = '', relation_module = '', relation_field = '') {
    const relationVisible = type === 'relation' ? 'block' : 'none';
    return `
      <tr>
        <td><input type="text" class="form-control field-name" value="${esc(name)}"></td>
        <td>
          <select class="form-control field-type">
            <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
            <option value="textarea" ${type === 'textarea' ? 'selected' : ''}>Textarea</option>
            <option value="file" ${type === 'file' ? 'selected' : ''}>File</option>
            <option value="number" ${type === 'number' ? 'selected' : ''}>Number</option>
            <option value="select" ${type === 'select' ? 'selected' : ''}>Select</option>
            <option value="relation" ${type === 'relation' ? 'selected' : ''}>Relation</option>
          </select>
          <div class="relation-options mt-2" style="display:${relationVisible};">
            <select class="form-control relation-module mb-2">${moduleOptions(relation_module)}</select>
            <input type="text" class="form-control relation-field" placeholder="Display Field (e.g. name)" value="${esc(relation_field)}">
          </div>
        </td>
        <td><input type="text" class="form-control field-label" value="${esc(label)}"></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger remove-field">×</button>
        </td>
      </tr>`;
  }

});
</script>

<?php $this->load->view('admin/footer'); ?>
