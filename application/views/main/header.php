<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <aside>
                            <section style="background-image: url(<?php echo base_url() . "uploads/images/profile/$userData[icon]?timestamp=" . rand(1000, 2000); ?>)"></section>
                        </aside>
                        <?php echo $userData["name"]; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo base_url() . "module/admin_user/config"; ?>"> Administración</a></li>
                        <li id="log-out"><a href="javascript:void(0);"><i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->