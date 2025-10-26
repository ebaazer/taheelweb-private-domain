<div class="clearfix"></div>

<section>
    <div class="header-inner three less-margin-2">
        <div class="inner text-center">
            <h2 class="title-2 padding-1 text-white raleway"><?php echo $this->lang->line('contact_us_for_help'); ?></h2>
            <h5 class="text-white raleway">...</h5>
        </div>
        <div class="overlay bg-opacity-5"></div>
        <img src="<?php echo base_url(); ?>assets/frontend/hasta/images/sliders/2.jpg" alt="" class="img-responsive"/> 
    </div>
</section>
<div class="clearfix"></div>
<!-- end header inner -->


<section class="sec-padding">
    <div class="container">
        <div class="row" style="direction: rtl;">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <div class="smart-forms bmargin">
                    <h3 class="love-ya-like-a-sister"><?php echo $this->lang->line('contact_us_for_help'); ?></h3>
                    <p>
                        <?php echo $this->lang->line('please_call_us_or_complete_the_form_below_and_we_will_get_to_you_shortly'); ?>
                    </p>
                    <br/>
                    <br/>
                    <form method="post" action="<?php echo base_url(); ?>home/contact_us/contact" id="smart-form">
                        <div>
                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="name" id="sendername" class="gui-input" placeholder="<?php echo $this->lang->line('your_name'); ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                            </div>
                            <!-- end section -->

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="email" name="email" id="emailaddress" class="gui-input" placeholder="<?php echo $this->lang->line('your_email'); ?>">
                                    <span class="field-icon"><i class="fa fa-envelope"></i></span> </label>
                            </div>
                            <!-- end section -->

                            <div class="section colm colm6">
                                <label class="field prepend-icon">
                                    <input type="tel" name="phone" id="telephone" class="gui-input" placeholder="<?php echo $this->lang->line('phone'); ?>">
                                    <span class="field-icon"><i class="fa fa-phone-square"></i></span> </label>
                            </div>
                            <!-- end section -->

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="address" id="sendersubject" class="gui-input" placeholder="<?php echo $this->lang->line('address'); ?>">
                                    <span class="field-icon"><i class="fa fa-lightbulb-o"></i></span> </label>
                            </div>
                            <!-- end section -->

                            <div class="section">
                                <label class="field prepend-icon">
                                    <textarea class="gui-textarea" id="sendermessage" name="message" placeholder="<?php echo $this->lang->line('message'); ?>"></textarea>
                                    <span class="field-icon"><i class="fa fa-comments"></i></span> <span class="input-hint"> <strong>تلميح:</strong> الرجاء إدخال ما بين 80 - 300 حرف.</span> </label>
                            </div>
                            <!-- end section --> 

                            <!--<div class="section">
                                        <div class="smart-widget sm-left sml-120">
                                            <label class="field">
                                                <input type="text" name="captcha" id="captcha" class="gui-input sfcode" maxlength="6" placeholder="Enter CAPTCHA">
                                            </label>
                                            <label class="button captcode">
                                                <img src="php/captcha/captcha.php?<?php echo time(); ?>" id="captchax" alt="captcha">
                                                <span class="refresh-captcha"><i class="fa fa-refresh"></i></span>
                                            </label>
                                        </div> 
                                    </div>-->

                            <div class="result"></div>
                            <!-- end .result  section --> 

                        </div>
                        <!-- end .form-body section -->
                        <div class="form-footer">
                            <button type="submit" data-btntext-sending="Sending..." class="button btn-primary orange-4"><?php echo $this->lang->line('send_message'); ?></button>
                            <button type="reset" class="button"> <?php echo $this->lang->line('cancel'); ?> </button>
                        </div>
                        <!-- end .form-footer section -->
                    </form>
                </div>
                <!-- end .smart-forms section --> 

            </div>




        </div>
    </div>
</section>
<!--end section-->
<div class="clearfix"></div>


