<style>
    .errors_data{
        color: #e84c3d;
        font-weight: 400;
    }
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/calendly_center/css/styles.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/calendly_center/css/register.css" />

<div class="container" style=" direction:  rtl;">

    <section class="description-section" style=" margin: 10px; padding-top: 10px;">
        <hgroup>

            <button class="back-btn" onclick="goBack()"><img class="arrow-icon" src="<?php echo base_url(); ?>assets/calendly/icons/arrow.svg" alt="back-arrow"></button>

            <div class="hPAsHHd0FN8065UiP705 bPjMK2MqWr9_ZWcyR8AJ QPsxCRQmOkF1umgWqDQk">
                <img src="<?php echo base_url(); ?>assets/afac/afac_m.png" alt="Company logo" class="tSHP4_7gU1EgmhU4cdix _CTgggv6aoPOIqf8ezib _N_pQvF_vYXoFUBmSBgT AcSA_0y7q_fwT11N_b1y">
            </div>        

            <hgroup>
                <div class="dByP7suNIfCqOSaMcM6_ _CXzNZJcVKGB6oSxcDYf">
                    <div class="row">
                        <div class=" col-6">
                            <h6 id="scheduler" data-component="name" class="igLUv25CGn1lcV9W4BLo VHgo1Gke8HlB303mVQsG q4cOvvEx6Vd1DIiuVXso GzvVI3Y6rac8lZAKNbGw cj8hJKtajauY7EuaKsh6">
                            </h6>
                        </div>
                        <div class=" col-6">
                            <h6 id="scheduler" data-component="name" class="igLUv25CGn1lcV9W4BLo VHgo1Gke8HlB303mVQsG q4cOvvEx6Vd1DIiuVXso GzvVI3Y6rac8lZAKNbGw cj8hJKtajauY7EuaKsh6">
                            </h6>               
                        </div>
                    </div>
                </div>    

                <h6 id="event">Pricing Review</h6>
                <div class="icon-text-div">
                    <img src="<?php echo base_url(); ?>assets/calendly/icons/clock.svg" alt="clock-icon">
                        <h5 id="duration"></h5>
                </div>
                <div class="icon-text-div">
                    <img src="<?php echo base_url(); ?>assets/calendly/icons/calendar.svg" alt="calendar-icon">
                        <h6 id="event-time-stamp">9:00am - 9:15am, Monday, July 13, 2020</h6>
                </div>



                <div class="icon-text-div">
                    <div class="YAmKI90l5OyINFgGmq9L TuKawS25ZXxJafgZdElP ">
                        <span aria-hidden="true" class="srpdbd5 sxrb1p2 l15h8fme ly3eodl">
                            <svg data-id="details-item-icon" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg" role="img">
                                <path d="M.5 5a4.5 4.5 0 1 0 9 0 4.5 4.5 0 1 0-9 0Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M.846 6.731h1.212a1.212 1.212 0 0 0 1.211-1.212V4.481a1.212 1.212 0 0 1 1.212-1.212 1.211 1.211 0 0 0 1.211-1.211V.553M9.5 4.929a2.469 2.469 0 0 0-1.117-.275H6.9a1.212 1.212 0 1 0 0 2.423.865.865 0 0 1 .865.865v.605" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <span class="__trdF9jFB1QpBhkUGiN t_3_V_cX54ZJ2vS2wbMX">
                            توقيت المملكة العربية السعودية
                        </span>
                    </div>            
                </div>
            </hgroup>

            <div>
                <div class="yHJsX7btzZUMOuQu_qbF _QY08ZnTdckO8dGtuWjX rITYjoHV2NF_yl1tR68x rUewQ7gbiLM7fEmxWleS">
                    <div class="k_tUa2XwT0esKZkWYshM UOUgYFhrylMAqJDUG1Tn">
                    </div>
                </div>
            </div>
        </hgroup>

    </section>

    <div class="divider"></div>
    <section id="register-section" class="body-section"  style=" margin: 10px; padding-top: 10px;">
        <form accept-charset="UTF-8">
            <h3>
                أدخل التفاصيل
            </h3>
            <label for="name">
                الاسم* 
                <span id="e_c_name" class="errors_data"></span>
            </label>
            <input type="text" name="" id="calendly_name" />
            <span id="e_c_name" class="errors_data"></span>

            <label for="institution">
                اسم الطالب* <span id="e_c_institution" class="errors_data"></span>
            </label>
            <input type="text" name="" id="calendly_institution" /> 

            <div data-component="question" class="_XcSYbldo6PBKK04XdZx smoY8RxA6xs8LaouvqHy">
                <div>
                    <div class="c8wotgg">
                        <label for="U3z03guBx2WuBzRvG6sP5" class="ls9i9qr">
                            رقم الاتصال * <span id="e_c_phone" class="errors_data"></span>
                        </label>
                    </div>
                    <div class="XD1y6QivS_xS2hJ9QYgR VMAGmxDoGw7jfNNy_LDs" data-component="phone-field">
                        <div class="l15h8fme d1dzuwnm">
                            <div class="phone-field-wrapper">
                                <input class="i167bxqy i1uya22c" type="tel" id="calendly_phone" aria-invalid="false" autocomplete="tel" data-intl-tel-input-id="0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="c8wotgg">
                    <label for="QWL9pTEPHeSV8-CiIRo_E" class="ls9i9qr">
                        يرجى مشاركة أي شيء من شأنه أن يساعد في التحضير لاجتماعنا.
                    </label>
                </div>
                <div class="l15h8fme d1dzuwnm">
                    <textarea class="i167bxqy ikzg8f9 i1uya22c" type="textarea" maxlength="10000" id="calendly_more" autocorrect="off" autocomplete="off" aria-invalid="false"></textarea>
                </div>
            </div>

            <input type="hidden" id="meeting_date" value="" />
            <input type="hidden" id="pick_date" value="" />

            <button id="submit-btn" type="submit">
                تأكيد الاجتماع
            </button>
        </form>
    </section>

</div>

<script>
    $(document).ready(function () {

        $("form").submit(function (event) {
            var formData = {
                calendly_name: $("#calendly_name").val(),
                calendly_email: $("#calendly_email").val(),
                calendly_institution: $("#calendly_institution").val(),
                calendly_phone: $("#calendly_phone").val(),
                calendly_country: $("#calendly_country").val(),
                calendly_more: $("#calendly_more").val(),
                meeting_date: $("#meeting_date").val(),
                pick_date: $("#pick_date").val(),
                calendly_roll: document.querySelector('input[name="calendly_roll"]:checked').value,
                calendly_interest: document.querySelector('input[name="calendly_interest"]:checked').value,
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/submit_calendly_taheelweb",
                data: formData,
                encode: true,
            }).done(function (data) {

                obj = JSON.parse(data);

                console.log(obj);
                if (!obj.success) {
                    if (obj.errors.calendly_name) {
                        document.getElementById("e_c_name").innerHTML = obj.errors.calendly_name;
                    } else {
                        document.getElementById("e_c_name").innerHTML = "";
                    }

                    if (obj.errors.calendly_phone) {
                        document.getElementById("e_c_phone").innerHTML = obj.errors.calendly_phone;
                    } else {
                        document.getElementById("e_c_phone").innerHTML = "";
                    }

                } else {
                    $("form").html(
                            '<div class="alert alert-success">' + obj.message + "</div>"
                            );
                }
            });
            event.preventDefault();
        });
    });
</script>

<script src="<?php echo base_url(); ?>assets/calendly_center/script/register.js"></script>
