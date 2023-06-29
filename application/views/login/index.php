<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">

                <form id="login-form" action="javascript:void(0);" method="post">
                    <h1><img src="<?php echo base_url() . "assets/images/logo-fenix.png"; ?>" class="login_icon_fenix" /></h1>
                    <div>
                        <input type="text" name="username" class="form-control" placeholder="Username" required="required" />
                    </div>
                    <div>
                        <input type="password" name="pass" class="form-control" placeholder="Password" required="required" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success submit">Iniciar Sesión</button>
                        <!--<a id="lost-pass" class="reset_pass" href="#">¿Olvidaste tu password?</a>-->
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                    </div>
                </form>
            </section>
        </div>

        <?php
//        $this->load->view("modal_windows/modalInformation", array(
//            "idPanel"  => "lost-pws",
//            "module"   => "login",
//            "title"    => "Recupera tu password",
//            "classCss" => "modal-content-alert modal-cursor-pointer",
//            "classSec" => "modal-body-alert",
//            "tpl"      => "modals/lostpws"
//        ));
        
        $this->load->view("modal_windows/modalAlert");
        ?>

    </div>

</div>