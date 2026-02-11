<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Community Posts</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                     <ul class="nav nav-tabs nav-tabs-custom mb-3">
                        <li class="nav-item">
                            <a class="nav-link <?= $current_status == 'all' ? 'active' : '' ?>" href="<?= base_url('admin/community/posts/all') ?>">All Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_status == 'pending' ? 'active' : '' ?>" href="<?= base_url('admin/community/posts/pending') ?>">Pending Approval</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_status == 'approved' ? 'active' : '' ?>" href="<?= base_url('admin/community/posts/approved') ?>">Approved</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link <?= $current_status == 'rejected' ? 'active' : '' ?>" href="<?= base_url('admin/community/posts/rejected') ?>">Rejected</a>
                        </li>
                    </ul>

                    <div class="card">
                        <div class="card-body">
                            <form method="get" class="row mb-4">
                                <div class="col-md-3">
                                    <label>Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="<?= $this->input->get('start_date') ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="<?= $this->input->get('end_date') ?>">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </form>

                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Member</th>
                                        <th>Category</th>
                                        <th>Content Preview</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($posts)): foreach($posts as $p): ?>
                                    <tr>
                                        <td><?= $p->id ?></td>
                                        <td><?= html_escape($p->first_name . ' ' . $p->last_name) ?></td>
                                        <td><?= html_escape($p->category_name) ?></td>
                                        <td><?= substr(strip_tags($p->content), 0, 50) ?>...</td>
                                        <td>
                                            <?php if($p->status == 'approved'): ?>
                                                <span class="badge badge-success">Approved</span>
                                            <?php elseif($p->status == 'rejected'): ?>
                                                <span class="badge badge-danger">Rejected</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M Y H:i', strtotime($p->created_at)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/community/view_post/'.$p->id) ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> View</a>
                                            
                                            <?php if($p->status == 'pending'): ?>
                                                <a href="<?= base_url('admin/community/approve_post/'.$p->id) ?>" class="btn btn-sm btn-success" onclick="return confirm('Approve this post?')"><i class="fas fa-check"></i></a>
                                                <a href="<?= base_url('admin/community/reject_post/'.$p->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Reject this post?')"><i class="fas fa-times"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No posts found.</td>
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
