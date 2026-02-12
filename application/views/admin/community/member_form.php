<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18"><?= isset($member) ? 'Edit Member' : 'Add New Member' ?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                            <?php 
                                $is_edit = isset($member); 
                                $m = $is_edit ? $member : null;
                            ?>
                            
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#community" role="tab">Community Profile</a>
                                </li>
                                <?php if($is_edit): ?>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#family" role="tab">Family Members</a>
                                </li>
                                <?php endif; ?>
                            </ul>

                            <div class="tab-content p-3 text-muted">
                                <!-- Personal Details Tab -->
                                <div class="tab-pane active" id="personal" role="tabpanel">
                                    <?= form_open('') ?>
                                        <input type="hidden" name="tab" value="personal">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>First Name</label>
                                                <input type="text" name="first_name" class="form-control" value="<?= $is_edit ? $m->first_name : set_value('first_name') ?>" required>
                                                <?= form_error('first_name', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="<?= $is_edit ? $m->last_name : set_value('last_name') ?>" required>
                                                <?= form_error('last_name', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="<?= $is_edit ? $m->email : set_value('email') ?>" >
                                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                                        </div>

                                        <div class="mb-3">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" value="<?= $is_edit ? $m->phone : set_value('phone') ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Password <?= $is_edit ? '(Leave blank to keep unchanged)' : '' ?></label>
                                            <input type="password" name="password" class="form-control" <?= $is_edit ? '' : 'required' ?>>
                                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                                        </div>

                                        <div class="mb-3">
                                            <label>Bio</label>
                                            <textarea name="bio" class="form-control" rows="3"><?= $is_edit ? $m->bio : set_value('bio') ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" <?= ($is_edit && $m->status == 1) ? 'selected' : '' ?>>Active</option>
                                                <option value="0" <?= ($is_edit && $m->status == 0) ? 'selected' : '' ?>>Banned</option>
                                            </select>
                                        </div>
                                    
                                </div>

                                <!-- Community Profile Tab -->
                                <div class="tab-pane" id="community" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" value="<?= $is_edit ? $m->dob : set_value('dob') ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Gotra</label>
                                            <input type="text" name="gotra" class="form-control" value="<?= $is_edit ? $m->gotra : set_value('gotra') ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Marital Status</label>
                                            <select name="marital_status" class="form-control">
                                                <option value="Single" <?= ($is_edit && $m->marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
                                                <option value="Married" <?= ($is_edit && $m->marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
                                                <option value="Widowed" <?= ($is_edit && $m->marital_status == 'Widowed') ? 'selected' : '' ?>>Widowed</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Spouse Name</label>
                                            <input type="text" name="spouse_name" class="form-control" value="<?= $is_edit ? $m->spouse_name : set_value('spouse_name') ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" rows="2"><?= $is_edit ? $m->address : set_value('address') ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="<?= $is_edit ? $m->city : set_value('city') ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="<?= $is_edit ? $m->pincode : set_value('pincode') ?>">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Member Details</button>
                                    <a href="<?= base_url('admin/community/members') ?>" class="btn btn-secondary">Cancel</a>
                                    <?= form_close() ?>
                                </div>

                                <!-- Family Members Tab (Only in Edit) -->
                                <?php if($is_edit): ?>
                                <div class="tab-pane" id="family" role="tabpanel">
                                    <div class="mb-4">
                                        <h5>Family Members</h5>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Relation</th>
                                                    <th>DOB</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($m->family)): foreach($m->family as $f): ?>
                                                <tr>
                                                    <td><?= $f->name ?></td>
                                                    <td><?= $f->relation ?></td>
                                                    <td><?= $f->dob ? date('d M Y', strtotime($f->dob)) : '-' ?></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/community/delete_family_member/'.$f->id.'/'.$m->id) ?>" class="text-danger" onclick="return confirm('Remove this family member?')"><i class="fas fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; else: ?>
                                                <tr><td colspan="4" class="text-center">No family members added.</td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <hr>
                                    <h5>Add Family Member</h5>
                                    <?= form_open('admin/community/add_family_member/'.$m->id) ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="relation" class="form-control" required>
                                                    <option value="">Relation</option>
                                                    <option value="Spouse">Spouse</option>
                                                    <option value="Son">Son</option>
                                                    <option value="Daughter">Daughter</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" name="dob" class="form-control" placeholder="DOB">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-success w-100">Add</button>
                                            </div>
                                        </div>
                                    <?= form_close() ?>
                                </div>
                                <?php endif; ?>
                            </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
