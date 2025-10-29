<?php
$cleaned_link = str_replace("-", "", $client_id);
?>

<div class="topbar red-3 white-2 more-padding topbar-padding">
    <div class="container">
        <?php
        $social = json_decode($this->frontend_model->get_frontend_settings('social_links'));
        $show_social = isset($social[0]->show) ? $social[0]->show : []; // التحقق من المواقع الاجتماعية المسموح بإظهارها
        ?>
        <div class="topbar-right-items pull-left">
            <ul class="toplist toppadding white">
                <?php
                if ($client_id == 'afac') {
                    if ($page_name == 'booking_plan_step_1' || $page_name == 'booking_plan_step_2') {
                        // لا تعرض الروابط في هذه الصفحات
                    } else {
                        ?>
                        <li class="lineright"><a href="<?php echo site_url('login'); ?>">
                                <?php echo $this->lang->line('login'); ?>
                            </a>
                        </li>

                        <?php if (in_array('facebook', $show_social) && !empty($social[0]->facebook)) { ?>
                            <li><a href="<?php echo $social[0]->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                        <?php } ?>

                        <?php if (in_array('twitter', $show_social) && !empty($social[0]->twitter)) { ?>
                            <li><a href="<?php echo $social[0]->twitter; ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php } ?>

                        <?php if (in_array('instagram', $show_social) && !empty($social[0]->instagram)) { ?>
                            <li><a href="<?php echo $social[0]->instagram; ?>"><i class="fa fa-instagram"></i></a></li>
                        <?php } ?>

                        <?php
                    }
                } else {
                    ?>
                    <li class="lineright"><a href="<?php echo site_url('login'); ?>">
                            <?php echo $this->lang->line('login'); ?>
                        </a>
                    </li>

                    <?php if (in_array('facebook', $show_social) && !empty($social[0]->facebook)) { ?>
                        <li><a href="<?php echo $social[0]->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php } ?>

                    <?php if (in_array('twitter', $show_social) && !empty($social[0]->twitter)) { ?>
                        <li><a href="<?php echo $social[0]->twitter; ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>

                    <?php if (in_array('instagram', $show_social) && !empty($social[0]->instagram)) { ?>
                        <li><a href="<?php echo $social[0]->instagram; ?>"><i class="fa fa-instagram"></i></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>


        <div class="topbar-left-items">
            <ul class="toplist toppadding pull-right paddtop1">
                <?php
                if ($client_id == 'afac') {
                    if ($page_name == 'booking_plan_step_1' || $page_name == 'booking_plan_step_2') {
                        
                    } else {
                        ?>
                        <li>
                            <?php echo $this->frontend_model->get_frontend_settings('emergency_contact'); ?>
                        </li>
                        <li class="rightl"><?php echo $this->lang->line('emergency_contact'); ?></li>
                        <?php
                    }
                } else {
                    ?>
                    <li>
                        <?php echo $this->frontend_model->get_frontend_settings('emergency_contact'); ?>
                    </li>
                    <li class="rightl"><?php echo $this->lang->line('emergency_contact'); ?></li>
                <?php }
                ?>
            </ul>
        </div>

    </div>
</div>
<div class="clearfix"></div>
<?php
if ($client_id == 'afac') {
    if ($page_name == 'booking_plan_step_1' || $page_name == 'booking_plan_step_2') {
        $header10 = "";
    } else {
        $header10 = "header10";
    }
} else {
    $header10 = "header10";
}
?>
<div id="<?php echo $header10; ?>">
    <div class="container">
        <div class="menu-bg">

            <div class="navbar red-3 navbar-default yamm">
                <?php
                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;
                $u_logo = $this->db->get_where('settings', array('type' => 'u_logo'))->row()->description;

                $folder = 'https://ft.taheelweb.com/uploads/' . $this->session->userdata('client_id');

                if ($client_id == 'afac') {
                    if ($page_name == 'booking_plan_step_1' || $page_name == 'booking_plan_step_2') {
                        
                    } else {
                        ?>
                        <div class="navbar-header">
                            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid" class="navbar-toggle two three">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo base_url("home") ?>" class="navbar-brand logo-padding">
                                <img width="140" style="margin-top: -30px; max-height: 90px; max-width: 90px" 
                                     src="<?php echo $folder; ?>/logo/<?php echo $u_logo; ?>" alt=""/>
                            </a>
                        </div>

                        <div id="navbar-collapse-grid" class="navbar-collapse collapse pull-right">

                            <ul class="nav red-3 navbar-nav">
                                <li> <a href="<?php echo base_url(); ?>home" class="dropdown-toggle active"><i class="fa fa-home"></i> <br/>
                                        <?php echo $this->lang->line('home'); ?></a>
                                </li>
                                <li> <a href="<?php echo base_url(); ?>home/about_us" class="dropdown-toggle"> <i class="fa fa-users two"></i> <br/>
                                        <?php echo $this->lang->line('about'); ?></a>
                                </li>

                                <!--
                                <li> <a href="facilities.html" class="dropdown-toggle"><i class="fa fa-flask three"></i> <br/>
                                        Facilities</a>
                                </li>
                                -->

                                <li> <a href="<?php echo base_url(); ?>home/blog" class="dropdown-toggle"><i class="fa fa-pencil-square-o five"></i> <br/>
                                        <?php echo $this->lang->line('blog'); ?></a>
                                    </a>
                                </li>

                                <li> <a href="<?php echo base_url(); ?>home/gallery" class="dropdown-toggle"><i class="fa fa-graduation-cap six"></i> <br/>
                                        <?php echo $this->lang->line('gallery'); ?></a>
                                </li>
                                <li> <a href="<?php echo base_url(); ?>home/booking" class="dropdown-toggle"><i class="fa fa-book four"></i> <br/>
                                        <?php echo $this->lang->line('Booking'); ?></a>
                                </li>
                                <li> <a href="<?php echo base_url(); ?>home/contact_us" class="dropdown-toggle"><i class="fa fa-envelope seven"></i> <br/>
                                        <?php echo $this->lang->line('contact'); ?></a>
                                </li>

                                <li> <a href="<?php echo base_url(); ?>login" class="dropdown-toggle"><i class="fa fa-sign-in five"></i> <br/>
                                        <?php echo $this->lang->line('login'); ?></a>
                                </li>                        

                            </ul>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid" class="navbar-toggle two three">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="<?php echo base_url("home") ?>" class="navbar-brand logo-padding">
                            <img width="140" 
                                 style="margin-top: -30px; max-height: 90px; max-width: 90px" 
                                 src="<?php echo $folder; ?>/logo/<?php echo $u_logo; ?>" alt=""/>
                        </a>
                    </div>

                    <div id="navbar-collapse-grid" class="navbar-collapse collapse pull-right">


                        <ul class="nav red-3 navbar-nav">
                            <li> <a href="<?php echo base_url(); ?>home" class="dropdown-toggle active"><i class="fa fa-home"></i> <br/>
                                    <?php echo $this->lang->line('home'); ?></a>
                            </li>
                            <li> <a href="<?php echo base_url(); ?>home/about_us" class="dropdown-toggle"> <i class="fa fa-users two"></i> <br/>
                                    <?php echo $this->lang->line('about'); ?></a>
                            </li>

                            <!--
                            <li> <a href="facilities.html" class="dropdown-toggle"><i class="fa fa-flask three"></i> <br/>
                                    Facilities</a>
                            </li>
                            -->

                            <li> <a href="<?php echo base_url(); ?>home/blog" class="dropdown-toggle"><i class="fa fa-pencil-square-o five"></i> <br/>
                                    <?php echo $this->lang->line('blog'); ?></a>
                                </a>
                            </li>

                            <li> <a href="<?php echo base_url(); ?>home/gallery" class="dropdown-toggle"><i class="fa fa-graduation-cap six"></i> <br/>
                                    <?php echo $this->lang->line('gallery'); ?></a>
                            </li>
                            <li> <a href="<?php echo base_url(); ?>home/booking" class="dropdown-toggle"><i class="fa fa-book four"></i> <br/>
                                    <?php echo $this->lang->line('Booking'); ?></a>
                            </li>                        
                            <li> <a href="<?php echo base_url(); ?>home/contact_us" class="dropdown-toggle"><i class="fa fa-envelope seven"></i> <br/>
                                    <?php echo $this->lang->line('contact'); ?></a>
                            </li>

                            <li> <a href="https://<?php echo $cleaned_link; ?>.taheelweb.com/login" class="dropdown-toggle"><i class="fa fa-sign-in five"></i> <br/>
                                    <?php echo $this->lang->line('login'); ?></a>
                            </li>                        

                        </ul>

                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>