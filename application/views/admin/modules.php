<?php include("head.php"); ?>
<?php include("header.php"); ?>

<!-- End Navbar -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- Card header -->
        <div class="card-header pb-0">
          <div class="d-lg-flex">
            <div>
              <h5 class="mb-0">All Modules</h5>
            </div>
            <div class="ms-auto my-auto mt-lg-0 mt-4">
              <div class="ms-auto my-auto">
                <a href="<?= base_url('admin/add_module'); ?>" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; New Module</a>
                <!-- <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button> -->
              </div>
            </div>
          </div>
        </div>
        

        <!-- Card body -->
        <div class="card-body px-0 pb-0">
          <div class="table-responsive">
            <table class="table table-flush" id="modules-list">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Module Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Table Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fields</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach ($modules as $m): ?>
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?= $i++; ?></p>
                    </td>
                    <td>
                      <h6 class="mb-0 text-sm"><?= htmlspecialchars($m->name); ?></h6>
                    </td>
                    <td>
                      <span class="text-xs"><?= htmlspecialchars($m->table_name); ?></span>
                    </td>
                    <td>
                      <span class="text-xs text-secondary">
                        <?php
                          $fields = json_decode($m->fields);
                          $names = array_column($fields, 'name');
                          echo implode(', ', $names);
                        ?>
                      </span>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        <?= date('M j, Y', strtotime($m->created_at)); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center">
                        <a href="<?= base_url('admin/module/'.$m->hash); ?>" 
                            class="text-success font-weight-bold text-xs me-3">
                            <i class="fas fa-database"></i> Open
                        </a>

                        <a href="<?= base_url('admin/edit_module/'.$m->hash); ?>" 
                            class="text-primary font-weight-bold text-xs me-3">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <a href="<?= base_url('admin/delete_module/'.$m->hash); ?>" 
                            class="text-danger font-weight-bold text-xs"
                            onclick="return confirm('Delete this module?')">
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
  </div>
</div>
</main>

<?php include("footer.php"); ?>

<!--   Core JS Files   -->
<script>
  if (document.getElementById('modules-list')) {
    const dataTableSearch = new simpleDatatables.DataTable("#modules-list", {
      searchable: true,
      fixedHeight: false,
      perPage: 10
    });

    document.querySelectorAll(".export").forEach(function(el) {
      el.addEventListener("click", function(e) {
        var type = el.dataset.type;
        var data = {
          type: type,
          filename: "modules-" + type,
        };

        if (type === "csv") {
          data.columnDelimiter = ",";
        }

        dataTableSearch.export(data);
      });
    });
  };
</script>
