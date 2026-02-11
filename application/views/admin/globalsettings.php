<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/header'); ?>
<div class="container-fluid py-4 mt-5">
    <div class="card">
        <div class="card-header p-0 position-relative mt-n5 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <center>
                    <h5 class="font-weight-bolder text-white">Global Settings</h5>
                </center>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 col-sm-4">Name</div>
                <div class="col-4 col-sm-4">Value</div>
                <div class="col-4 col-sm-4">Submit</div>
            </div>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="footercontent" hidden>
                        <h5>Footer Content</h5>
                    </div>
                    <div class="col-4 col-sm-4"><textarea name="value" rows="6" cols="30"><?=strip_tags($footercontent); ?></textarea></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="address" hidden>
                        <h5>Address</h5>
                    </div>
                    <div class="col-4 col-sm-4"><textarea name="value" rows="6" cols="30"><?=strip_tags($address); ?></textarea></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">                    
                        <input type="text" name="name" value="mobile" hidden>
                        <h5>Mobile</h5>
                    </div>

                    <div class="col-4 col-sm-4"><input type="text" name="value" value="<?=($mobile); ?>" id=""></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">                    
                        <input type="text" name="name" value="mobile2" hidden>
                        <h5>Alternate Mobile</h5>
                    </div>

                    <div class="col-4 col-sm-4"><input type="text" name="value" value="<?=($mobile2); ?>" id=""></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                        <input type="text" name="name" value="email" hidden>
                        <h5>Email</h5>
                    </div>
                    <div class="col-4 col-sm-4"><input type="text" name="value" value="<?=($email); ?>" id=""></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <h2>Home Banner Content</h2>
            <br>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="banner_title" hidden>
                        <i aria-hidden="true">Banner Title</i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($banner_title); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="banner_content" hidden>
                        <h5>Banner Content</h5>
                    </div>
                    <div class="col-4 col-sm-4"><textarea name="value" rows="6" cols="30"><?=strip_tags($banner_content); ?></textarea></div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <h2>Social Links</h2>
            <br>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="facebook" hidden>
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($facebook); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="twitter" hidden>
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($twitter); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="instagram" hidden>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($instagram); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="youtube" hidden>
                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($youtube); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="whatsapp" hidden>
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($whatsapp); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <h2>Counters</h2>
            <br>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="experience" hidden>
                        <i aria-hidden="true">Experience</i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($experience); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="satisfied_customer" hidden>
                        <i aria-hidden="true">Satisfied Customer</i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($satisfied_customer); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="success" hidden>
                        <i aria-hidden="true">Success</i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($success); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>
            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="team" hidden>
                    <i aria-hidden="true">Team</i>
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($team); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>

            <form class="multisteps-form__form" method="post" action="editsettings">
                <div class="row mt-2">
                    <div class="col-4 col-sm-4">
                    <input type="text" name="name" value="gmblink" hidden>
                        <i class="fa fa-google" aria-hidden="true"></i> (Google My Business)
                    </div>
                    <div class="col-4 col-sm-4">
                        <input type="text" name="value" value="<?=($gmblink); ?>" id="">
                    </div>
                    <div class="col-4 col-sm-4"><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
                </div>
                <hr style=" color: #000; opacity: 100%;border-style: inset;border-width: 1px;">
            </form>


        </div>
    </div>
</div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $this->load->view('admin/footer'); ?>