<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/axios.min.js"></script>

<div class="clearfix"></div>

<section>
    <div class="header-inner two">
        <div class="inner text-center">
            <h4 class="title text-white uppercase">
                تواصل معنا
            </h4>
            <h5 class="text-white uppercase">
                نحب أن نسمع منك
            </h5>
        </div>
        <div class="overlay bg-opacity-5"></div>
        <img src="images/header-img.jpg" alt="" class="img-responsive"/> </div>
</section>
<div class="clearfix"></div>

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
                    <form method="post" action="<?php echo base_url(); ?>home/submit_contact/" id="smartcc-form">
                        <div>
                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="name" id="contact_name" class="gui-input" placeholder="<?php echo $this->lang->line('your_name'); ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span>
                                </label>
                                <span id="e_c_name" class="errors_data"></span>
                            </div>

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="email" name="email" id="contact_email" class="gui-input" placeholder="<?php echo $this->lang->line('your_email'); ?>">
                                    <span class="field-icon"><i class="fa fa-envelope"></i></span>
                                </label>
                                <span id="e_c_email" class="errors_data"></span>
                            </div>

                            <div class="section colm colm6">
                                <label class="field prepend-icon">
                                    <input type="tel" name="phone" id="contact_phone" class="gui-input" placeholder="<?php echo $this->lang->line('phone'); ?>">
                                    <span class="field-icon"><i class="fa fa-phone-square"></i></span>
                                </label>
                            </div>
                            
                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="contact_subject" id="contact_subject" class="gui-input" placeholder="<?php echo $this->lang->line('subject'); ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span>
                                </label>
                                <span id="e_c_name" class="errors_data"></span>
                            </div>                            

                            <div class="section">
                                <label class="field prepend-icon">
                                    <textarea class="gui-textarea" id="contact_message" name="message" placeholder="<?php echo $this->lang->line('message'); ?>"></textarea>
                                    <span class="field-icon"><i class="fa fa-comments"></i></span> <span class="input-hint"> <strong>تلميح:</strong> الرجاء إدخال ما بين 80 - 300 حرف.</span>
                                </label>
                            </div>

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

                        </div>

                        <div class="form-footer">
                            <button type="submit" data-btntext-sending="Sending..." class="button btn-primary orange-4"><?php echo $this->lang->line('send_message'); ?></button>
                            <button type="reset" class="button"> <?php echo $this->lang->line('cancel'); ?> </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</section>

<div class="clearfix"></div>

<script>

    $("#smartcc-form").submit(function (event) {
        var formData = {
            contact_name: $("#contact_name").val(),
            contact_email: $("#contact_email").val(),
            contact_phone: $("#contact_phone").val(),
            contact_subject: $("#contact_subject").val(),
            contact_message: $("#contact_message").val(),
        };

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>home/submit_contact",
            data: formData,
            encode: true,
        }).done(function (data) {

            obj = JSON.parse(data);

            console.log(obj);
            if (!obj.success) {
                if (obj.errors.contact_name) {
                    document.getElementById("e_c_name").innerHTML = obj.errors.contact_name;
                } else {
                    document.getElementById("e_c_name").innerHTML = "";
                }

                if (obj.errors.contact_email) {
                    document.getElementById("e_c_email").innerHTML = obj.errors.contact_email;
                } else {
                    document.getElementById("e_c_email").innerHTML = "";
                }

                if (obj.errors.main_message) {
                    document.getElementById("e_c_main_message").innerHTML = obj.errors.main_message;
                } else {
                    document.getElementById("e_c_main_message").innerHTML = "";
                }

            } else {
                $("form").html(
                        '<div class="alert alert-success">' + obj.message + "</div>"
                        );
            }
        });
        event.preventDefault();
    });

</script>


