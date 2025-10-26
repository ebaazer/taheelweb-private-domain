<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/kottenator/jquery-circle-progress/1.2.0/dist/circle-progress.js"></script>
<div class="clearfix"></div>


<div class="clearfix"></div>

<section class="sec-padding">
    <div class="container">
        <div class="row" style="direction: rtl;">
            <div class="col-md-4">
                <img class="h-40px w-40px" src="<?php echo base_url() ?>assets/media/svg/icons/Home/Earth.svg"/>
            </div>
            <div class="col-md-4">
                <center>
                    <div>
                        <img src="<?php echo base_url(); ?>assets/afac/ca245ce3ff376ab7788b7aaeb00b099752b27b86a5bb3ab1.png" alt="Company logo" style=" max-width: 70%; padding-bottom: 20px;">
                    </div>
                </center>
                <div class="smart-forms bmargin">
                    <center>
                        <h3 class="love-ya-like-a-sister rrrrrrrrrr">
                            مواعيد مناقشة
                            <br />
                            الخطة التربوية الفردية
                        </h3>
                    </center>
                    <p class="msg-success">
                        ادخل رقم الهوية الوطنية للطالب
                    </p>
                    <form>
                        <div>

                            <div class="section">
                                <label class="field prepend-icon" style="margin-bottom: 10px;">
                                    <input type="text" name="id_no" id="id_no" class="gui-input" placeholder="رقم الهوية للطالب">
                                    <span class="field-icon"><i class="fa fa-user"></i></span>
                                </label>
                                <span style=" color: red; font-weight: bold; padding-top: 10px; margin: 10px;" id="e_c_id"></span>
                            </div>

                            <div class="result"></div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="button btn-primary orange-4">
                                للأمام
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>

        </div>
    </div>
</section>
<div class="clearfix"></div>

<script>
    $(document).ready(function () {

        $("form").submit(function (event) {
            var formData = {
                id_no: $("#id_no").val(),
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/booking_plan_step_1_ajax",
                data: formData,
                encode: true,
            }).done(function (data) {

                obj = JSON.parse(data);

                console.log(obj);
                if (!obj.success) {
                    if (obj.errors.id_no) {
                        document.getElementById("e_c_id").innerHTML = obj.errors.id_no;
                    } else {
                        document.getElementById("e_c_id").innerHTML = "";
                    }

                } else {

                    var encrypt_thread = obj.encrypt_thread;
                    //console.log(encrypt_thread);
                    window.location.replace('<?php echo base_url(); ?>home/booking_plan_step_2/' + encrypt_thread);

                }
            });
            event.preventDefault();
        });
    });
</script>