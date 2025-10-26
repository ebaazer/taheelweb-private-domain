<div class="clearfix"></div>
<section>
    <div class="header-inner two">
        <div class="inner text-center">
            <h4 class="title text-white uppercase">
                حجز موعد
            </h4>
            <h5 class="text-white uppercase">
                احجز موعدك الآن لتقديم أفضل رعاية تعليمية وسلوكية لطفلك!
            </h5>
            <h5 class="text-white uppercase">
                نحن هنا لدعمه في تحقيق التقدم والنجاح بأساليب مبتكرة تناسب احتياجاته
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
                    <h3 class="love-ya-like-a-sister"><?php echo $this->lang->line('Booking'); ?></h3>
                    <p class="msg-success">
                        <?php echo $this->lang->line('please_call_us_or_complete_the_form_below_and_we_will_get_to_you_shortly'); ?>
                    </p>
                    <br/>
                    <br/>
                    <form method="post" action="<?php echo base_url(); ?>home/new_booking" id="smart-form">
                        <div>

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="name" id="sendername" class="gui-input" required placeholder="<?php echo $this->lang->line('your_name'); ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                            </div>

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="students_name" id="sendername" class="gui-input" required placeholder="<?php echo $this->lang->line('students_name'); ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                            </div>

                            <?php
                            $class = $this->frontend_model->get_class();
                            ?>

                            <div class="section">
                                <label class="field select">
                                    <select id="" name="class_id" required>
                                        <?php
                                        foreach ($class as $class_row) {
                                            ?>
                                            <option value="<?php echo $class_row['class_id'] ?>"><?php echo $class_row['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <i class="arrow"></i>                    
                                </label>  
                            </div>                             

                            <div class="section">
                                <label class="field select">
                                    <select id="country" name="subject_visit" required>
                                        <option value=""><?php echo $this->lang->line('The subject of the visit'); ?></option>
                                        <option value="book_consultation_appointment">حجز موعد استشارة</option>
                                        <option value="register_new_student"><?php echo $this->lang->line('Register a new student'); ?></option>

                                        <option value="speech_and_language_assessment"><?php echo $this->lang->line('speech_and_language_assessment'); ?></option>
                                        <option value="occupational_therapy_assessment"><?php echo $this->lang->line('occupational_therapy_assessment'); ?></option>
                                        <option value="applied_behavior_analysis_ABA_assessment"><?php echo $this->lang->line('applied_behavior_analysis_ABA_assessment'); ?></option>
                                        
                                      
                                        <option value="discuss_the_plan"><?php echo $this->lang->line('Discuss the plan'); ?></option>
                                        <option value="discuss_student_behavior"><?php echo $this->lang->line('Discuss student behavior'); ?></option>
                                        <option value="general_followup_of_the_student"><?php echo $this->lang->line('General follow-up of the student'); ?></option>
                                        <option value="see_the_center_services"><?php echo $this->lang->line('See the center services'); ?></option>
                                        <option value="other"><?php echo $this->lang->line('other'); ?></option>
                                    </select>
                                    <i class="arrow"></i>                    
                                </label>  
                            </div>                            

                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                            <script src="https://npmcdn.com/flatpickr/dist/l10n/ar.js"></script>
                            <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
                            <div class="section">
                                <label class="field prepend-icon">
                                    <input type="text" name="datetime" id="datetime" class="gui-input" required placeholder="<?php echo $this->lang->line('datetime'); ?>">
                                    <span class="field-icon"><i class="fa fa-calendar"></i></span> </label>
                            </div>
                            <script type="text/javascript">
                                flatpickr.l10ns.default.firstDayOfWeek = 7
                                flatpickr("#datetime", {
                                    enableTime: true,
                                    minuteIncrement: 30,
                                    locale: "ar",
                                    "disable": [
                                        function (date) {
                                            // return true to disable
                                            return (date.getDay() === 5 || date.getDay() === 6);
                                        }
                                    ],
                                    onChange: function (val, dateText, instance) {
                                        //console.log(val, dateText);
                                    }
                                });
                            </script>

                            <div class="section colm colm6">
                                <label class="field prepend-icon">
                                    <input type="tel" name="phone" id="telephone" class="gui-input" required placeholder="<?php echo $this->lang->line('phone'); ?>">
                                    <span class="field-icon"><i class="fa fa-phone-square"></i></span> </label>
                            </div>

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

<script>
    //console.log(window.$)
</script>