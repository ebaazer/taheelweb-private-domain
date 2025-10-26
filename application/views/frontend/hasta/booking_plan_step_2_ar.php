<?php
$student_data = $this->db->get_where('student', array('encrypt_thread' => $student_encrypt_thread))->row();
$student_parent = $this->db->get_where('student_parent', array('student_id' => $student_data->student_id, 'active' => 1))->row()->parent_id;
$parent_data = $this->db->get_where('parent', array('parent_id' => $student_parent, 'active' => 1))->row();
$enroll_data = $this->db->get_where('enroll', array('student_id' => $student_data->student_id, 'active' => 1))->row();
$section_data = $this->db->get_where('section', array('section_id' => $enroll_data->section_id))->row();

$day_1_section = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
$day_2_section = array("21", "22", "23", "24", "25", "26", "27", "28", "29", "30");
$day_3_section = array("33", "34", "35", "36", "37", "38", "39", "40");

$day_4_section = array("31");

$noooo = array();

$day_1_date = "29-09-2024";
$day_2_date = "30-09-2024";
$day_3_date = "01-10-2024";

$day_3_date = "28-10-2024";

$string = preg_replace('/\s+/', '', $section_data->name);
if (in_array($string, $day_1_section)) {
    //echo "day_1_section";
    $is_day = $day_1_date;
    $name_day = "الأحد";
    $is_book = $this->db->get_where('booking_plan', array('date_m' => $day_1_date, 'section_id' => $enroll_data->section_id))->row();
} elseif (in_array($string, $day_2_section)) {
    //echo "day_2_section";
    $is_day = $day_2_date;
    $name_day = "الاثنين";
    $is_book = $this->db->get_where('booking_plan', array('date_m' => $day_2_date, 'section_id' => $enroll_data->section_id))->row();
} elseif (in_array($string, $day_3_section)) {
    //echo "day_3_section";
    $is_day = $day_3_date;
    $name_day = "الثلاثاء";
    $is_book = $this->db->get_where('booking_plan', array('date_m' => $day_3_date, 'section_id' => $enroll_data->section_id))->row();
} elseif (in_array($string, $day_4_section)) {
    //echo "day_3_section";
    $is_day = $day_4_date;
    $name_day = "Monday";
    $is_book = $this->db->get_where('booking_plan', array('date_m' => $day_3_date, 'section_id' => $enroll_data->section_id))->row();
}
else {
    $is_day = "لا يوجد بيانات";
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/kottenator/jquery-circle-progress/1.2.0/dist/circle-progress.js"></script>

<div class="clearfix"></div>


<div class="clearfix"></div>

<section class="sec-padding">
    <div class="container">
        <div class="row" style="direction: rtl;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <center>
                    <div>
                        <img src="<?php echo base_url(); ?>assets/afac/ca245ce3ff376ab7788b7aaeb00b099752b27b86a5bb3ab1.png" alt="Company logo" style=" max-width: 70%; padding-bottom: 20px;">
                    </div>
                </center>
                <div class="smart-forms bmargin">
                    <center>
                        <h3 class="love-ya-like-a-sister">
                            مواعيد مناقشة الخطة
                            <br />
                            <?php echo 'يوم ' . $name_day . ' ' . $is_day . ' '; ?>

                        </h3>
                    </center>
                    <p class="msg-success">
                        قم باختيار الموعد المناسب من قائمة المواعيد المتاحة
                    </p>

                    <br/>
                    <form>

                        <input type="hidden" id="student_id" class="form-control" name="class_id" value="<?php echo $student_data->student_id; ?>" />
                        <input type="hidden" id="parent_id" class="form-control" name="class_id" value="<?php echo $parent_data->parent_id; ?>" />
                        <input type="hidden" id="section_id" class="form-control" name="class_id" value="<?php echo $enroll_data->section_id; ?>" />
                        <input type="hidden" id="section_name" class="form-control" name="class_id" value="<?php echo $string; ?>" />
                        <input type="hidden" id="is_day" class="form-control" name="class_id" value="<?php echo $is_day; ?>" />
                        <input type="hidden" id="id_no" class="form-control" name="class_id" value="<?php echo $student_data->no_identity; ?>" />

                        <div>

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input style=" color: #000; font-weight: bold;" disabled type="text" name="name" id="sendername" class="gui-input" value="<?php echo $parent_data->name; ?>" >
                                    <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                            </div>

                            <div class="section">
                                <label class="field prepend-icon">
                                    <input style=" color: #000; font-weight: bold;" disabled type="text" name="students_name" id="sendername" class="gui-input" value="<?php echo $student_data->name; ?>">
                                    <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                            </div>   

                            <div class="section colm colm6">
                                <label class="field prepend-icon">
                                    <input style=" color: #000; font-weight: bold; direction: rtl;" disabled type="tel" name="phone" id="telephone" class="gui-input" value="<?php echo $parent_data->phone; ?>">
                                    <span class="field-icon"><i class="fa fa-phone-square"></i></span> </label>
                            </div>                            


                            <?php
                            $is_book_9 = $this->db->get_where('booking_plan', array('time_m' => '09:00', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();
                            $is_book_93 = $this->db->get_where('booking_plan', array('time_m' => '09:30', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();
                            $is_book_10 = $this->db->get_where('booking_plan', array('time_m' => '10:00', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();
                            $is_book_103 = $this->db->get_where('booking_plan', array('time_m' => '10:30', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();
                            $is_book_11 = $this->db->get_where('booking_plan', array('time_m' => '11:00', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();
                            $is_book_113 = $this->db->get_where('booking_plan', array('time_m' => '11:30', 'date_m' => $is_day, 'section_id' => $enroll_data->section_id))->num_rows();

                            if ($is_book_9 > 0) {
                                $e9 = '09:00 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e9 = '09:00 صباحا';
                            }

                            if ($is_book_93 > 0) {
                                $e93 = '09:30 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e93 = '09:30 صباحا';
                            }

                            if ($is_book_10 > 0) {
                                $e10 = '10:00 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e10 = '10:00 صباحا';
                            }

                            if ($is_book_103 > 0) {
                                $e103 = '10:30 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e103 = '10:30 صباحا';
                            }

                            if ($is_book_11 > 0) {
                                $e11 = '11:00 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e11 = '11:00 صباحا';
                            }

                            if ($is_book_113 > 0) {
                                $e113 = '11:30 صباحا' . ' - ' . "تم الحجز";
                            } else {
                                $e113 = '11:30 صباحا';
                            }
                            ?>

                            <div class="section">
                                <label class="field select">
                                    <select id="time_m" name="time_m">
                                        <option value="00:00">المواعيد المتاحة</option>
                                        <option value="09:00" <?php if ($is_book_9 > 0) echo 'disabled'; ?>><?php echo $e9; ?></option>
                                        <option value="09:30"  <?php if ($is_book_93 > 0) echo 'disabled'; ?>><?php echo $e93; ?></option>
                                        <option value="10:00"  <?php if ($is_book_10 > 0) echo 'disabled'; ?>><?php echo $e10; ?></option>
                                        <option value="10:30" <?php if ($is_book_103 > 0) echo 'disabled'; ?>><?php echo $e103; ?></option>
                                        <option value="11:00" <?php if ($is_book_11 > 0) echo 'disabled'; ?>><?php echo $e11; ?></option>
                                        <option value="11:30" <?php if ($is_book_113 > 0) echo 'disabled'; ?>><?php echo $e113; ?></option>
                                    </select>
                                    <i class="arrow"></i>                    
                                </label>  
                                <span style=" color: red; font-weight: bold; padding-top: 10px; margin: 10px;" id="e_c_time_m"></span>
                            </div>                            

                            <span class="result" id="e_c_all_e"></span>
                            <span class="result" id="e_c_id_no"></span>


                            <div class="result"></div>

                        </div>
                        <!-- end .form-body section -->
                        <div class="form-footer" style="margin: 15px;">
                            <button type="submit" data-btntext-sending="Sending..." class="button btn-primary orange-4">
                                تأكيد الموعد
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-md-4">
            </div>
        </div>
</section>
<!--end section-->
<div class="clearfix"></div>

<script>
    $(document).ready(function () {

        $("form").submit(function (event) {
            var formData = {
                student_id: $("#student_id").val(),
                parent_id: $("#parent_id").val(),
                section_id: $("#section_id").val(),
                section_name: $("#section_name").val(),
                date_m: $("#is_day").val(),
                time_m: $("#time_m").val(),
                id_no: $("#id_no").val(),
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>home/booking_plan_step_2_ajax",
                data: formData,
                encode: true,
            }).done(function (data) {

                obj = JSON.parse(data);

                console.log(obj);
                if (!obj.success) {
                    if (obj.errors.all_e) {
                        document.getElementById("e_c_all_e").innerHTML = obj.errors.all_e;
                    } else {
                        document.getElementById("e_c_all_e").innerHTML = "";
                    }

                    if (obj.errors.time_m) {
                        document.getElementById("e_c_time_m").innerHTML = obj.errors.time_m;
                    } else {
                        document.getElementById("e_c_time_m").innerHTML = "";
                    }

                    if (obj.errors.id_no) {
                        document.getElementById("e_c_id_no").innerHTML = obj.errors.id_no;
                    } else {
                        document.getElementById("e_c_id_no").innerHTML = "";
                    }




                } else {
                    $("form").html(
                            '<div class="alert alert-success">' + obj.message + "</div>"
                            );
                    //window.location.replace('<?php echo base_url(); ?>home/booking_plan_step_1');
                    //window.setTimeout(function () {
                    //    window.location.href = "<?php echo base_url(); ?>home/booking_plan_step_1";
                    //}, 5000);
                }
            });
            event.preventDefault();
        });
    });
</script>