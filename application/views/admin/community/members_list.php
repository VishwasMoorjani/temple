<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Community Members</h4>
                        <div class="page-title-right">
                            <a href="<?= base_url('admin/community/add_member') ?>" class="btn btn-primary">Add Member</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Joined At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($members)): foreach($members as $m): ?>
                                    <tr>
                                        <td><?= $m->id ?></td>
                                        <td><?= html_escape($m->first_name . ' ' . $m->last_name) ?></td>
                                        <td><?= html_escape($m->email) ?></td>
                                        <td><?= html_escape($m->phone) ?></td>
                                        <td>
                                            <?php if($m->status == 1): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Banned</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y', strtotime($m->created_at)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/community/edit_member/'.$m->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <a href="<?= base_url('admin/community/delete_member/'.$m->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No members found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <?= $pagination ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
