<?php $this->load->view('admin/head'); ?>
<link rel="stylesheet" href="<?=base_url('assets/admin/css/dropzone.min.css');?>" />
<script src="<?=base_url('assets/admin/js/dropzone.min.js');?>"></script>
<?php $this->load->view('admin/header'); ?>

<div class="container-fluid py-4 mt-5">
    <div class="card">
        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 text-center">
                <h5 class="text-white font-weight-bolder">Gallery</h5>
            </div>
        </div>

        <div class="card-body">

            <form action="<?=base_url('admin/dragDropUploadGallery/'.$module->table_name);?>" class="dropzone"></form>

            <div class="row mt-4">
                <?php if (!empty($records)) { ?>
                    <?php foreach ($records as $row) { ?>
                        <div class="col-lg-2 col-md-3 m-2 text-center">
                            <img src="<?=base_url('assets/front/images/'.$row->image);?>" width="150" height="140" />
                            <hr>
                            <a class="btn btn-primary"
                               href="<?=base_url('admin/removegalleryimages/'.$module->table_name.'/'.$row->id.'/'.$row->image);?>">
                               Remove
                            </a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No images found...</p>
                <?php } ?>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
