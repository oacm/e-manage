<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border-right: 1px solid #CCC; background: #EDEDED; border-bottom: 1px solid #D9DEE4;height: 58px;">
            <a href="<?= base_url();?>" class="site_title">
                <i class="fa fa-bolt"></i>
                <img src="<?php echo base_url() . "assets/images/logo-fenix.png"; ?>" />
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                
                <aside class="profile_img img-circle">
                
                    <section style="background-image: url(<?php echo base_url() . "uploads/images/profile/$userData[icon]?timestamp=" . rand(1000, 2000); ?>)"></section>
                
                </aside>
                
            </div>
            <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $userData["name"]; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3><?php echo $userData["position"]; ?></h3>
                <ul class="nav side-menu">
                    
                    <?php
                    
                    foreach ($modules as $value){
                    ?>
                    <li <?php if($value[2]){ echo "class='active current-page'"; }?>>
                        <a>
                            <i class="fa <?php if($value[2]){ echo "fa-circle"; } else {echo "fa-circle-thin";}?>"></i>
                            <?php echo $value[0]; ?>
                        </a>
                        <ul class="nav child_menu" <?php if($value[2]){ echo "style='display: block;'"; }?>>
                        <?php
                        foreach($value[3] as $subModule){
                        ?>
                            <li <?php if($subModule[2]){ echo "class=active"; }?>>
                                <a href="<?php echo $subModule[2] ? "javascript:void(0);" : base_url() . "module/$value[1]/$subModule[1]";?>">
                                    <?php echo $subModule[0]; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->
    </div>
</div>