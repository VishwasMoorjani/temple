<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Dashboard</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <div class="container">
              <div class="row">
                <?php 
                $modules = $this->db->order_by('id', 'ASC')->get('modules')->result();
                foreach($modules as $module){ ?>
                  <div class="col-md-3">
                    <a href="<?=base_url('admin/module/'.$module->hash)?>" class="text-white">
                      <div class="card text-white mb-3">
                        <div class="card-header">
                          <h5><?=$module->name?></h5>
                        </div>
                      </div>
                    </a>
                  </div>
                <?php } ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
<?php $this->load->view('admin/footer'); ?>