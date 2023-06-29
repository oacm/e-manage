<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"])
            $this->load->view("main/vMenu");
        ?>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title welcome-title">
                        <h2>
                            <p>Bienvenido</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="welcome-page">
                                <div class="welcome-user-img-config">
            
                                    <aside class="profile_img img-circle">

                                        <section style="background-image: url(<?php echo base_url() . "assets/images/profile/$userData[icon]"; ?>)"></section>

                                    </aside>

                                </div>
                                <p><?php echo $userData["name"]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$firstLogin = array(
    "idPanel"     => "first-loggin",
    "module"      => "login",
    "classCss"    => "modal-content-alert modal-content-alert-form-second",
    "tpl"         => "modals/newPass",
    "title"       => "Actualizar Contraseña",
    "args"        => $userData,
    "enableClose" => TRUE
);

if($userData["firstLogin"] == 1){$firstLogin["showModal"] = TRUE;}

$this->load->view("modal_windows/modalInformation", $firstLogin);

$this->load->view("modal_windows/modalAlert");
?>