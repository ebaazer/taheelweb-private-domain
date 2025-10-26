<section class="parallax-section45">
    <div class="section-overlay violet-1 bg-opacity-9">
        <div class="footer-cloud-shape"></div>
        <div class="container sec-tpadding-3">
            <div class="row text-right"> <br/>
                <div class="col-md-4 col-sm-6 col-xs-12 colmargin">
                    <div class="footer-logo"><img src="<?php echo base_url('uploads/logo.png'); ?>" width="150" alt=""/></div>
                    <?php ?>
                    <ul class="address-info-3" style="direction: rtl;">
                        <li><i class="fa fa-location-arrow"></i><?php echo $this->lang->line('address'); ?> : <?php echo $this->frontend_model->get_settings('address'); ?></li>
                        <li><i class="fa fa-phone"></i> <?php echo $this->lang->line('phone'); ?> : <?php echo $this->frontend_model->get_frontend_settings('emergency_contact'); ?></li>
                        <li><i class="fa fa-envelope"></i> <?php echo $this->lang->line('email'); ?> : <?php echo $this->frontend_model->get_frontend_settings('email'); ?> </li>
                        <!--
                        <li><i class="fa fa-fax"></i> <?php echo $this->lang->line('fax'); ?> : <?php echo $this->frontend_model->get_settings('fax'); ?></li>
                        <li><i class="fa fa-envelope"></i> Email: support@yoursite.com </li>
                        <li><i class="fa fa-envelope"></i> Email: support@yoursite.com </li>
                        -->
                    </ul>
                </div>
                <!--end item-->

                <!--
                <div class="col-md-3 col-sm-6 col-xs-12 colmargin text-white">
                    <h3 class=" love-ya-like-a-sister footer-title less-mar3">Recent Posts</h3>
                    <div class="footer-title-bottomstrip"></div>
                    <div class="clearfix"></div>
                    <div class="image-left">
                        <div class="fo-postimg-inner"><img src="http://placehold.it/80x80" alt=""/></div>
                    </div>
                    <div class="text-box-right">
                        <h5 class="text-white less-mar3"><a href="javascript:;">Clean And Modern</a></h5>
                        <span>Lorem ipsum dolor sit</span>
                        <div class="footer-post-info"> <span>By John Doe</span><span>May 19</span> </div>
                    </div>
                    <div class="divider-line solid opacity-4 margin"></div>
                    <div class="clearfix"></div>
                    <div class="image-left">
                        <div class="fo-postimg-inner"><img src="http://placehold.it/80x80" alt=""/></div>
                    </div>
                    <div class="text-box-right">
                        <h5 class="text-white less-mar3"><a href="javascript:;">Clean And Modern</a></h5>
                        <span>Lorem ipsum dolor sit</span>
                        <div class="footer-post-info"> <span>By John Doe</span><span>May 19</span> </div>
                    </div>
                </div>
                -->
                <!--end item-->


                <div class="col-md-4 col-sm-6 col-xs-12 colmargin tex-right">
                    <h3 class=" love-ya-like-a-sister footer-title less-mar3"></h3>
                    <div class="clearfix"></div>
                    <ul class="usefull-links-3">

                    </ul>
                </div>                


                <div class="col-md-4 col-sm-6 col-xs-12 colmargin tex-right">
                    <h3 class=" love-ya-like-a-sister footer-title less-mar3"><?php echo $this->lang->line('Quick Links'); ?></h3>
                    <div class="footer-title-bottomstrip"></div>
                    <div class="clearfix"></div>
                    <ul class="usefull-links-3" style="direction: rtl;">
                        <li><a href="<?php echo site_url('home'); ?>"><i class="fa fa-angle-left"></i> <?php echo $this->lang->line('home'); ?></a></li>
                        <li><a href="<?php echo site_url('home/about_us'); ?>"><i class="fa fa-angle-left"></i> <?php echo $this->lang->line('about_us'); ?></a></li>
                        <li><a href="<?php echo site_url('login'); ?>"><i class="fa fa-angle-left"></i> <?php echo $this->lang->line('login'); ?></a></li>
                        <li><a href="<?php echo site_url('home/contact_us'); ?>"><i class="fa fa-angle-left"></i> <?php echo $this->lang->line('contact_us'); ?></a></li>
                    </ul>
                </div>
                <!--end item-->

                <!--
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="item-holder">
                        <h3 class=" love-ya-like-a-sister footer-title less-mar3">Flickr feed</h3>
                        <div class="footer-title-bottomstrip"></div>
                        <div class="clearfix"></div>
                        <ul id="basicuse" class="thumbs">
                        </ul>
                    </div>
                </div>
                -->

                <!--end item-->

                <div class="clearfix"></div>
                <br/>
                <br/>
                <div class="divider-line solid light opacity-4"></div>
                <div class="clearfix"></div>
                <br/>
                <br/>
                <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-12">
                        <?php
                        $social = json_decode($this->frontend_model->get_frontend_settings('social_links'));
                        $show_social = isset($social[0]->show) ? $social[0]->show : []; // التحقق من المواقع الاجتماعية المسموح بإظهارها
                        ?>
                        <ul class="social-icons-3 violet">
                            <?php if (in_array('twitter', $show_social) && !empty($social[0]->twitter)) { ?>
                                <li><a href="<?php echo $social[0]->twitter; ?>"><i class="fa fa-twitter"></i></a></li>
                            <?php } ?>

                            <?php if (in_array('facebook', $show_social) && !empty($social[0]->facebook)) { ?>
                                <li><a href="<?php echo $social[0]->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                            <?php } ?>

                            <?php if (in_array('instagram', $show_social) && !empty($social[0]->instagram)) { ?>
                                <li><a href="<?php echo $social[0]->instagram; ?>"><i class="fa fa-instagram"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <span class="text-white pull-right">
                            Copyright © 2019 
                            <a href="https://1.envato.market/hasta-html-by-codelayers">hasta</a> 
                            By <a href="https://1.envato.market/codelayers">Codelayers</a> | All rights reserved.
                        </span>
                    </div>
                </div>

                <br/>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</section>