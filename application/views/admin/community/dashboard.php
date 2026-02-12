<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Community Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Total Members</p>
                                    <h4 class="mb-0"><?= $stats['total_members'] ?></h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="fas fa-users font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Total Posts</p>
                                    <h4 class="mb-0"><?= $stats['total_posts'] ?></h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-success align-self-center">
                                    <span class="avatar-title">
                                        <i class="fas fa-comments font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Pending Approval</p>
                                    <h4 class="mb-0"><?= $stats['pending_posts'] ?></h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                    <span class="avatar-title">
                                        <i class="fas fa-clock font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Pending Posts</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Member</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $pending = $this->db->select('com_posts.*, com_members.first_name, com_members.last_name, com_categories.name as category_name')
                                            ->from('com_posts')
                                            ->join('com_members', 'com_members.id = com_posts.member_id', 'left')
                                            ->join('com_categories', 'com_categories.id = com_posts.category_id', 'left')
                                            ->where('com_posts.status', 'pending')
                                            ->order_by('com_posts.created_at', 'DESC')
                                            ->limit(5)
                                            ->get()->result();
                                        
                                        if(!empty($pending)): foreach($pending as $p): ?>
                                        <tr>
                                            <td><?= $p->id ?></td>
                                            <td><?= $p->first_name . ' ' . $p->last_name ?></td>
                                            <td><?= $p->category_name ?></td>
                                            <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/community/view_post/'.$p->id) ?>" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">View Details</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                        <tr><td colspan="5" class="text-center">No pending posts</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
