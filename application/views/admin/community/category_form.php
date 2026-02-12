<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Add Category</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <?= form_open('') ?>
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= set_value('name') ?>" required>
                                    <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="mb-3">
                                    <label>Slug</label>
                                    <input type="text" name="slug" class="form-control" value="<?= set_value('slug') ?>" required>
                                    <?= form_error('slug', '<small class="text-danger">', '</small>') ?>
                                </div>
                                <div class="mb-3">
                                    <label>Icon Class (FontAwesome)</label>
                                    <input type="text" name="icon" class="form-control" value="<?= set_value('icon') ?>" placeholder="fas fa-users">
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Category</button>
                                <a href="<?= base_url('admin/community/categories') ?>" class="btn btn-secondary">Cancel</a>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
