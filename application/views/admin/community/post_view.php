<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">View Post #<?= $post->id ?></h4>
                        <div class="page-title-right">
                             <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="media mb-4">
                                <?php if($post->member_id): ?>
                                    <div class="media-body">
                                        <h5 class="font-size-16 mt-0 mb-1"><?= $post->first_name . ' ' . $post->last_name ?></h5>
                                        <p class="text-muted font-size-13"><?= date('d M Y H:i', strtotime($post->created_at)) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <h5 class="mb-3">Category: <?= $post->category_name ?></h5>

                            <div class="post-content mb-4">
                                <p><?= nl2br($post->content) ?></p>
                            </div>

                            <?php if(!empty($post->media_files)): ?>
                                <?php $files = json_decode($post->media_files, true); ?>
                                <div class="row">
                                    <?php if(is_array($files)): foreach($files as $file): ?>
                                        <div class="col-md-4">
                                            <img src="<?= base_url('assets/uploads/community/'.$file) ?>" class="img-fluid rounded" alt="Post Image">
                                        </div>
                                    <?php endforeach; endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <hr>
                            <div class="mt-4">
                                <h5>Status: <span class="badge badge-<?= $post->status == 'approved' ? 'success' : ($post->status == 'rejected' ? 'danger' : 'warning') ?>"><?= ucfirst($post->status) ?></span></h5>
                            </div>

                             <div class="mt-4">
                                <?php if($post->status == 'pending'): ?>
                                    <a href="<?= base_url('admin/community/approve_post/'.$post->id) ?>" class="btn btn-success"><i class="fas fa-check"></i> Approve</a>
                                    <a href="<?= base_url('admin/community/reject_post/'.$post->id) ?>" class="btn btn-danger"><i class="fas fa-times"></i> Reject</a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
