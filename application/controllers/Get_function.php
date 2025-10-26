<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      MANAGE function
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Get_function extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->output->enable_profiler($this->config->item('profiler'));

        log_message('debug', 'CI : MY_Controller class loaded');

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Barcode_model');
        $this->load->helper('language');
        date_default_timezone_set('Asia/Riyadh');

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        /* language control */
        $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
        $site_lang = $this->session->userdata('site_lang');

        include 'inc_language.php';
    }

    public function index() {

        if ($this->session->userdata('user_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('user_login') == 1)
            redirect(site_url('user/dashboard'), 'refresh');
    }

    function if_user_login() {
        if ($this->session->userdata('user_login') != 1) {
            redirect(base_url(), 'refresh');
            return;
        }
    }

    function get_class_section($class_id) {
        $this->if_user_login();
        $sections = $this->db->get_where('section', array('class_id' => $class_id, 'active' => 1))->result_array();
        echo '<option value="">' . $this->lang->line('select') . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_section_for_datatable($class_id = "", $page_name = "") {
        $this->if_user_login();
        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        /*
         * 2 = مدير قسم
         * 3 = مشرف تربوي
         * 27 = مراقب اجتماعي

         * 4 = معلم
         * 5 = اخصائي علاج وظيفي
         * 6 = اخصائي علاج طبيعي
         * 7 = اخصائي نطق
         * 8 = اخصائي مهني
         * 9 = اخصائي تربية رياضية
         * 10 = تمريض
         * 11 = سكرتير
         * 12 = محاسب
         * 13 = امين مكتبة
         * 14 = اخصائي اجتماعي
         * 15 = أخصائي نفسي
         * 16 = مختص أول
         * 17 = مساعد إداري
         * 18 = علاقات عامة
         * 19 = مسؤول الصيانة
         * 20 = مساعد سكرتير
         * 21 = مربيات
         * 22 = عامل
         * 23 = سائق الباص
         * 24 = مرافق الباص
         * 25 = حارس
         * 26 = الموارد البشرية
         * 28 = مساعد معلم
         * 29 = مساعد علاج طبيعي
         * 30 = حساب خاص بمشرفي الوزارة
         * 31 = معلم جلسات فردية
         */

        //$jobTitle_allowed = array("2", "3", "27", "34", "36", "67");

        $jobTitle_allowed = array();

        $this->db->select("a.job_title_id");
        $this->db->from("job_title a");
        $this->db->where("a.level", 0);
        $this->db->where("a.active", 1);
        $jobTitles = $this->db->get()->result_array();

        $jobTitle_allowed = array_column($jobTitles, 'job_title_id');

        if ($superuser) {
            //$sections = $this->db->get_where('section', array('class_id' => $class_id, 'active' => 1))->result_array();

            $this->db->select("a.*");
            $this->db->from("section a");
            $this->db->where("a.class_id", $class_id);
            $this->db->where("a.active", 1);
            $this->db->order_by('CAST(a.name AS SIGNED) ASC');
            $sections = $this->db->get()->result_array();
        } elseif (in_array($jobTitle, $jobTitle_allowed)) {
            //$sections = $this->db->get_where('section', array('class_id' => $class_id, 'active' => 1))->result_array();

            $this->db->select("a.*");
            $this->db->from("section a");
            $this->db->where("a.class_id", $class_id);
            $this->db->where("a.active", 1);
            $this->db->order_by('CAST(a.name AS SIGNED) ASC');
            $sections = $this->db->get()->result_array();
        } else {
            $sections = $this->db->select('a.*')
                    ->from('section a')
                    ->join('section_employee b', 'b.section_id = a.section_id', 'left')
                    ->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('b.active', 1)
                    ->order_by('CAST(a.name AS SIGNED) ASC')
                    ->get()
                    ->result_array();
        }

        echo '<option value="">' . $this->lang->line('choose_an_option') . '</option>';
        if ($sections != null) {
            //if ($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view') {
            if (is_allowed("attendance_and_absence_management", "view_all_students_option")) {
                echo '<option value="-1">' . $this->lang->line('all') . '</option>';
            }
            //}

            foreach ($sections as $row) {
                echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            //echo '<option value="">' . $this->lang->line('all') . '</option>';
        }
    }

    function get_class_section_for_teacher_timetable($class_id = "", $page_name = "") {
        $this->if_user_login();
        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $level = $this->session->userdata('level');

        if ($level == 1) {
            $this->db->select("a.*");
            $this->db->from("section a");
            $this->db->join("section_employee b", "b.section_id = a.section_id", 'left');
            $this->db->where("a.class_id", $class_id);
            $this->db->where("b.employee_id", $this->session->userdata('login_user_id'));
            $this->db->where("a.active", 1);
            $this->db->where("b.active", 1);
            $this->db->order_by('CAST(a.name AS SIGNED) ASC');
            $this->db->group_by('b.section_id');
            $section = $this->db->get()->result_array();
        } else {
            $this->db->select("a.*");
            $this->db->from("section a");
            $this->db->where("a.class_id", $class_id);
            $this->db->where("a.active", 1);
            $this->db->order_by('CAST(a.name AS SIGNED) ASC');
            $section = $this->db->get()->result_array();
        }

        foreach ($section as $section_row) {

            if ($level == 1) {
                $this->db->select("a.*");
                $this->db->from("section a");
                $this->db->join("section_employee b", "b.section_id = a.section_id", 'left');
                $this->db->where("a.class_id", $class_id);
                $this->db->where("b.employee_id", $this->session->userdata('login_user_id'));
                $this->db->where("a.active", 1);
                $this->db->where("b.active", 1);
                $this->db->order_by('CAST(a.name AS SIGNED) ASC');
                $this->db->group_by('b.section_id');
                $sections = $this->db->get()->result_array();
            } else {
                $this->db->select("a.*");
                $this->db->from("section a");
                $this->db->where("a.class_id", $class_id);
                $this->db->where("a.active", 1);
                $this->db->order_by('CAST(a.name AS SIGNED) ASC');
                $sections = $this->db->get()->result_array();
            }
        }
        if ($sections != null) {
            echo '<option value="">' . $this->lang->line('choose_an_option') . '</option>';

            foreach ($sections as $row) {
                echo '<option value="' . base_url() . 'timetable/teacher_timetable/' . $row['encrypt_thread'] . '">' . $row['name'] . ' - ' . $row['nick_name'] . '</option>';
            }
        } else {
            
        }
    }

    function get_class_specialist_for_specialist_timetable($class_id = "", $page_name = "") {
        $this->if_user_login();
        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        $class_encrypt_thread = $this->db->get_where('class', array('class_id' => $class_id))->row()->encrypt_thread;

        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $level = $this->session->userdata('level');

        if ($level == 2) {

            $this->db->select("a.*");
            $this->db->from("employee a");
            $this->db->join("employee_classes b", "a.employee_id = b.employee_id");
            $this->db->where("b.class_id", $class_id);
            $this->db->where("b.employee_id", $this->session->userdata('login_user_id'));
            $this->db->where("a.active", 1);
            $this->db->where("b.active", 1);
            $this->db->where("a.level", 2);
            $this->db->group_by('b.employee_id');
            $this->db->order_by('a.name', 'ASC');
            $employee = $this->db->get()->result_array();
        } else {
            $this->db->select("a.*");
            $this->db->from("employee a");
            $this->db->join("employee_classes b", "a.employee_id = b.employee_id");
            $this->db->where("b.class_id", $class_id);
            $this->db->where("a.active", 1);
            $this->db->where("b.active", 1);
            $this->db->where("a.level", 2);
            $this->db->group_by('b.employee_id');
            $this->db->order_by('a.name', 'ASC');
            $employee = $this->db->get()->result_array();
        }
        echo '<option value="">' . $this->lang->line('choose_an_option') . '</option>';
        foreach ($employee as $employee_row) {
            $jobTitle_name = $this->db->get_where('job_title', array('job_title_id' => $employee_row['job_title_id']))->row()->name;
            echo '<option value="' . base_url() . 'timetable/specialist_schedule/' . $class_encrypt_thread . '/' . $employee_row['encrypt_thread'] . '">' . $employee_row['name'] . ' - ' . $jobTitle_name . '</option>';
        }
    }

    function get_class_specialists_for_datatable($class_id = "") {

        $this->if_user_login();
        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        /*
         * 2 = مدير قسم
         * 3 = مشرف تربوي
         */

        $jobTitle_allowed = array("2", "3");

        //$jobTitle_allowed = array("2", "3");

        if ($superuser) {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->get()
                    ->result_array();
        } elseif (in_array($jobTitle, $jobTitle_allowed)) {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->get()
                    ->result_array();
        } else {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->get()
                    ->result_array();
        }

        if ($sections != null) {
            echo '<option value="">' . $this->lang->line('all') . '</option>';
            foreach ($sections as $row) {
                echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            
        }
    }

    function get_class_specialists_for_link($class_id = "", $employee_encrypt_thread = "") {
        $this->if_user_login();
        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        $class_encrypt_thread = $this->db->get_where('class', array('class_id' => $class_id))->row()->encrypt_thread;

        /*
         * 2 = مدير قسم
         * 3 = مشرف تربوي
         */

        $jobTitle_allowed = array("2", "3");

        //$jobTitle_allowed = array("2", "3");

        if ($superuser) {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->group_by('a.employee_id')
                    ->get()
                    ->result_array();
        } elseif (in_array($jobTitle, $jobTitle_allowed)) {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->group_by('a.employee_id')
                    ->get()
                    ->result_array();
        } else {
            $sections = $this->db->select('b.*')
                    ->from('employee_classes a')
                    ->join('employee b', 'b.employee_id = a.employee_id', 'left')
                    ->join('job_title c', 'c.job_title_id = b.job_title_id', 'left')
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('c.level', 2)
                    ->where('b.active', 1)
                    ->group_by('a.employee_id')
                    ->get()
                    ->result_array();
        }

        if ($sections != null) {
            echo '<option value="">' . $this->lang->line('select') . '</option>';
            foreach ($sections as $row) {

                if ($employee_encrypt_thread == $row['encrypt_thread']) {
                    $is_selected = "selected";
                } else {
                    $is_selected = "";
                }

                echo '<option value="' . base_url() . 'student/student/by_specialists/' . $class_encrypt_thread . '/' . $row['encrypt_thread'] . '" ' . $is_selected . '>' . $row['name'] . '</option>';
            }
        } else {
            
        }
    }

    function get_class_section_edit($class_id = '', $section_id = '') {
        $this->if_user_login();
        $class_id = $_POST['class_id'];
        $section_id = $_POST['section_id'];

        $sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();

        echo '<option value="">' . $this->lang->line('select') . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '"';
            if ($section_id == $row['section_id']) {
                echo 'selected';
            }
            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_section_students_to_specialists($class_id) {
        //$sections = $this->db->get_where('section', array('class_id' => $class_id))->result_array();
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("section a");
        $this->db->where("a.class_id", $class_id);
        $this->db->where("a.active", 1);
        $this->db->order_by('CAST(a.name AS SIGNED) ASC');
        $sections = $this->db->get()->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        echo '<option value="' . 100 . '">' . $this->lang->line('all_student') . '</option>';
        foreach ($sections as $row) {
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_specialists($class_id) {
        $this->if_user_login();
        $specialists = $this->db->get_where('employee', array('class_id' => $class_id, 'level' => 2, 'active' => 1, 'deleted' => 0))->result_array();
        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($specialists as $row) {
            //echo $class_id;
            echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_specialists_services() {
        $this->if_user_login();
        $services_provided = $_POST['services_provided'];
        $class_id = $_POST['class_id'];

        if ($services_provided == '-1') {

            //$teachers = $this->db->get_where('employee', array('job_title_id' => "31", "class_id" => $class_id))->result_array();
            //$this->db->group_start();
            //$this->db->where('class_id', $class_id);
            //$this->db->or_where('class_id', 0);
            //$this->db->group_end();

            $this->db->group_start();
            $this->db->where('level', 2);
            $this->db->or_where('level', 1);
            $this->db->or_where('job_title_id', 31);
            $this->db->group_end();
            //$this->db->where('job_title_id', 31);
            //$this->db->where('level', 2);
            $this->db->where('active', 1);
            $this->db->where('deleted', 0);
            $teachers = $this->db->get('employee')->result_array();

            echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
            foreach ($teachers as $row) {
                echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            $services_job_title = $this->db->get_where('services_provided', array('services_provided_id' => $services_provided))->row()->job_title_id;

            $job_title_array = explode(",", $services_job_title);

            echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';

            foreach ($job_title_array as $key => $value) {
                //echo '<option value="' . $row['job_title_id'] . '">' . $value . '</option>';
                //$specialists = $this->db->get_where('employee', array('class_id' => $class_id, 'job_title_id' => $value, 'level' => 2, 'active' => 1, 'deleted' => 0))->result_array();
                //$this->db->group_start();
                //$this->db->where('class_id', $class_id);
                //$this->db->or_where('class_id', 0);
                //$this->db->group_end();
                $this->db->where('job_title_id', $value);
                //$this->db->where('level', 2);
                $this->db->where('active', 1);
                $this->db->where('deleted', 0);
                $specialists = $this->db->get('employee')->result_array();

                foreach ($specialists as $row) {
                    //echo $class_id;
                    echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
                }
            }
        }
    }

    function get_student_services_transport() {
        $this->if_user_login();
        $services_id = $_POST['services_id'];
        $section_id = $_POST['section_id'];

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select("b.name, b.student_id");
        $this->db->from("enroll a");
        $this->db->join("student b", "a.student_id = b.student_id", "left");
        $this->db->join("student_services c", "a.student_id = c.student_id", "left");

        $this->db->where("c.services_provided_id", $services_id);
        $this->db->where("a.section_id", $section_id);
        $this->db->where("a.year", $year);
        $this->db->where("c.year", $year);
        $this->db->order_by('b.name', 'ASC');
        $students = $this->db->get()->result_array();

        echo '<div id="CheckboxContainer"class="form-group">
              <label class="col-sm-3 control-label">' . $this->lang->line('students_name') . '</label>
              <div class="col-sm-9">';

        foreach ($students as $row) {
            $get_stu_tran = $this->db->get_where('subscribers_on_transport', array('student_id' => $row['student_id'], 'year' => $year, 'active' => 1))->result_array();
            if ($get_stu_tran == NULL) {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo ' - ';
                echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->region;
                echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand"><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name . ' <span></span></label>
            </div>';
            } else {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo '<div class="checkbox">
            <label>' . $name . ' ' . '<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">
                    ' . $this->lang->line('already_shared') . '</span></label>
            </div>';
            }
        }
        echo '<br><button type="button" class="btn btn-success" onClick="select()">' . $this->lang->line('select_all') . '</button>' . ' ';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onClick="unselect()"> ' . $this->lang->line('select_none') . ' </button>';
        echo '</div></div>';
    }

    function get_stu_emp_id() {
        $this->if_user_login();
        $employee_id = $_POST['employee_id'];
        $section_id = $_POST['section_id'];

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students = $this->db->get_where('enroll', array('section_id' => $section_id, 'year' => $year, 'status' => 1))->result_array();

        echo '<div id="CheckboxContainer"class="form-group">
              <label class="col-sm-3 control-label">' . $this->lang->line('students_name') . '</label>
              <div class="col-sm-9">';
        foreach ($students as $row) {
            $get_stu_emp = $this->db->get_where('students_to_specialists', array('student_id' => $row['student_id'], 'employee_id' => $employee_id, 'year' => $year))->result_array();
            if ($get_stu_emp == NULL) {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand"><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name . ' <span></span></label>
            </div>';
            } else {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--disabled"><input type="checkbox" disabled="disabled">' . $name . ' <span></span></label>
                <label>' . ' ' . '<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">
                    ' . $this->lang->line('associate_with_specialist') . '</span></label>
            </div>';
            }
        }
        echo '<br><button type="button" class="btn btn-success" onClick="select()">' . $this->lang->line('select_all') . '</button>' . ' ';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onClick="unselect()"> ' . $this->lang->line('select_none') . ' </button>';
        echo '</div></div>';
    }

    function get_section($class_id = "") {
        $this->if_user_login();
        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        $employee_id = $this->session->userdata('employee_id');
        $jobTitle = $this->db->get_where('employee', array('employee_id' => $employee_id))->row()->job_title_id;

        /*
         * 2 = مدير قسم
         * 3 = مشرف تربوي
         * 27 = مراقب اجتماعي

         * 4 = معلم
         * 5 = اخصائي علاج وظيفي
         * 6 = اخصائي علاج طبيعي
         * 7 = اخصائي نطق
         * 8 = اخصائي مهني
         * 9 = اخصائي تربية رياضية
         * 10 = تمريض
         * 11 = سكرتير
         * 12 = محاسب
         * 13 = امين مكتبة
         * 14 = اخصائي اجتماعي
         * 15 = أخصائي نفسي
         * 16 = مختص أول
         * 17 = مساعد إداري
         * 18 = علاقات عامة
         * 19 = مسؤول الصيانة
         * 20 = مساعد سكرتير
         * 21 = مربيات
         * 22 = عامل
         * 23 = سائق الباص
         * 24 = مرافق الباص
         * 25 = حارس
         * 26 = الموارد البشرية
         * 28 = مساعد معلم
         * 29 = مساعد علاج طبيعي
         * 30 = حساب خاص بمشرفي الوزارة
         * 31 = معلم جلسات فردية
         */

        $jobTitle_allowed = array("2", "3", "27");

        if ($superuser) {
            $sections = $this->db->get_where('section', array('class_id' => $class_id, 'active' => 1))->result_array();
        } elseif (in_array($jobTitle, $jobTitle_allowed)) {
            $sections = $this->db->get_where('section', array('class_id' => $class_id, 'active' => 1))->result_array();
        } else {
            $sections = $this->db->select('a.*')
                    ->from('section a')
                    ->join('section_employee b', 'b.section_id = a.section_id', 'left')
                    ->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.class_id', $class_id)
                    //->where('b.employee_id', $this->session->userdata('login_user_id'))
                    ->where('a.active', 1)
                    ->where('b.active', 1)
                    ->get()
                    ->result_array();
        }

        if ($page_name = 'manage_attendance' || $page_name = 'manage_attendance_view') {
            if (is_allowed("attendance_and_absence_management", "view_all_students_option")) {
                echo '<option value="-1">' . $this->lang->line('all') . '</option>';
            }
        }

        foreach ($sections as $row):
            echo '<option value="' . $row['section_id'] . '">' . $row['name'] . '</option>';
        endforeach;
    }

    // Get Management Transport

    function get_vehicle_id($vehicle_id) {
        $this->if_user_login();
        //$vehicle_id = $_POST['vehicle_id'];
        $class_id = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $vehicle_id))->row()->class_id;
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $area_management = $this->db->get_where('area_management', array('class_id' => $class_id))->result_array();

        foreach ($area_management as $row) {
            $checkdata = $this->db->get_where('vehicle_area', array('vehicle_id' => $vehicle_id, 'area_id' => $row['area_management_id'], 'year' => $year))->num_rows();
            if ($checkdata == 0) {
                echo '<option value="' . $row['area_management_id'] . '">' . $row['name'] . '</option>';
            }
        }
    }

    function get_stu_id($section_id) {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students = $this->db->get_where('enroll', array('section_id' => $section_id, 'year' => $year, 'status' => 1))->result_array();

        echo '<div id="CheckboxContainer" class="form-group">
              <label class="col-sm-3 control-label">' . $this->lang->line('students_name') . '</label>
              <div class="col-sm-9">';
        foreach ($students as $row) {
            $get_stu_tran = $this->db->get_where('subscribers_on_transport', array('student_id' => $row['student_id'], 'year' => $year))->result_array();
            if ($get_stu_tran == NULL) {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand"><input type="checkbox" class="check" name="student_id[]" value="' . $row['student_id'] . '">' . $name . ' <span></span></label>
            </div>';
            } else {
                $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
                echo '<div class="checkbox">
            <label>' . $name . ' ' . '<span class="m-badge  m-badge--success m-badge--wide">
                    ' . $this->lang->line('already_shared') . '</span></label>
            </div>';
            }
        }
        echo '<br><button type="button" class="btn btn-success" onClick="select()">' . $this->lang->line('select_all') . '</button>' . ' ';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onClick="unselect()"> ' . $this->lang->line('select_none') . ' </button>';
        echo '</div></div>';
    }

    function get_vehicle_id_for_add_stu($aria_id) {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $vehicle_management = $this->db->get('vehicle_management')->result_array();
        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';

        foreach ($vehicle_management as $row) {
            $checkdata = $this->db->get_where('vehicle_area', array('vehicle_id' => $row['vehicle_management_id'], 'area_id' => $aria_id, 'year' => $year))->num_rows();
            if ($checkdata != 0) {
                $this->db->select('COUNT(*) AS count');
                $this->db->where('vehicle_id', $row['vehicle_management_id']);
                //$this->db->where('class_id', $class_id);
                $this->db->where('year', $year);
                $this->db->from('subscribers_on_transport');
                //$number_of_stu_vehicle = $this->db->count_all_results();
                $number_of_stu_vehicle = intval($this->db->get()->result_array()[0]['count']);

                $residuum = $row['absorptive_capacity'] - $number_of_stu_vehicle;

                if ($number_of_stu_vehicle < $row['absorptive_capacity']) {
                    $ava = '<span class="label label-success">' . $this->lang->line('available') . '</span>';
                } else {
                    $ava = '<span class="label label-danger">' . $this->lang->line('unavailable') . '</span>';
                }
                echo '<option value="' . $row['vehicle_management_id'] . '">' . $row['type_car'] . ' ' . $row['number_plate'] . ' --> ' . $ava . ' ' . $residuum . ' ' . $this->lang->line('student') . '</option>';
            }
        }
    }

    function get_area_for_add_student($class_id = "") {
        $this->if_user_login();
        $transports = $this->db->get_where('area_management', array('class_id' => $class_id))->result_array();
        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';

        foreach ($transports as $row) {
            echo '<option value="' . $row['area_management_id'] . '">' . $row['name'] . '</option>';
        }
    }

    // send sms

    function get_class_students($class_id = "") {
        $this->if_user_login();
        //$students = $this->db->get_where('enroll', array('status' => 1,
        //            'class_id' => $class_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
        //        ))->result_array();

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select("b.*");
        $this->db->from("enroll a");
        $this->db->join("student b", "a.student_id = b.student_id", "left");
        $this->db->where("a.year", $year);
        $this->db->where("a.active", 1);
        $this->db->where("a.status", 1);
        $this->db->order_by('b.name', 'ASC');
        $students = $this->db->get()->result_array();

        echo '<option value = "0">' . $this->lang->line('select') . '</option>';
        foreach ($students as $row) {
            echo '<option value="' . $row['student_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_students_edit_inv($class_id = "") {
        $this->if_user_login();

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $selected_student = $this->input->get('selected'); // الطالب المحدد مسبقًا

        $this->db->select("b.*");
        $this->db->from("enroll a");
        $this->db->join("student b", "a.student_id = b.student_id", "left");
        $this->db->where("a.year", $year);
        $this->db->where("a.active", 1);
        $this->db->where("a.status", 1);
        $this->db->where("a.class_id", $class_id); // تصفية الصف
        $this->db->order_by('b.name', 'ASC');
        $students = $this->db->get()->result_array();

        echo '<option value="0">' . $this->lang->line('select') . '</option>';

        foreach ($students as $row) {
            $is_selected = ($row['student_id'] == $selected_student) ? 'selected' : '';
            echo '<option value="' . $row['student_id'] . '" ' . $is_selected . '>' . $row['name'] . '</option>';
        }
    }

    function get_parent_phone($section_id = "") {
        $this->if_user_login();
        $students = $this->db->get_where('enroll', array('status' => 1,
                    'section_id' => $section_id, 'year' => $this->db->get_where('settings', array('type' => 'running_year'))->row()->description
                ))->result_array();
        echo '<div id="CheckboxContainer" class="form-group">
    <label class="col-sm-3 control-label">' . $this->lang->line('phone_parent_student') . '</label>
    <div class="col-sm-9">';
        foreach ($students as $row) {
            $name = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
            $get_parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
            $parent_phone = $this->db->get_where('parent', array('parent_id' => $get_parent_id))->row()->phone;
            $country_code = $this->db->get_where('parent', array('parent_id' => $get_parent_id))->row()->country_code;
            echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand m-checkbox"><input type="checkbox" class="check" name="student_id[]" value="' . $country_code . $parent_phone . '">' . $name . ' <span></span></label>
        </div>';
        }
        echo '<br><button type="button" class="btn btn-success" onClick="select()">' . $this->lang->line('select_all') . '</button>' . ' ';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onClick="unselect()"> ' . $this->lang->line('select_none') . ' </button>';
        echo '</div></div>';
    }

    function get_employee_phone($class_id = "") {
        $this->if_user_login();
        $employees = $this->db->get_where('employee', array('active' => 1, 'class_id' => $class_id, 'deleted' => 0))->result_array();

        echo '<div id="CheckboxContainer" class="form-group">
    <label class="col-sm-3 control-label">' . $this->lang->line('phone_employee') . '</label>
    <div class="col-sm-9">';
        foreach ($employees as $row) {
            echo '<div class="m-checkbox-list">
            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand m-checkbox"><input type="checkbox" class="check" name="employee_id[]" value="' . $row['account_code'] . $row['phone'] . '">' . $row['name'] . ' <span></span></label>
        </div>';
        }
        echo '<br><button type="button" class="btn btn-success" onClick="select()">' . $this->lang->line('select_all') . '</button>' . ' ';
        echo '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onClick="unselect()"> ' . $this->lang->line('select_none') . ' </button>';
        echo '</div></div>';
    }

    // Get Onlin Exam

    function get_class_exam($class_id = "") {
        $this->if_user_login();
        $this->db->select('*');

        //تم ازالتها لكن عليك مراجعتها
        //$this->db->where('class_id', $class_id);
        //if ($class_id != 0) {
        //    $this->db->or_where('class_id', 100);
        //}
        //$this->db->where('active', 1);
        $query = $this->db->get('online_exam');

        if ($query->num_rows() > 0) {
            $exams = $query->result_array();

            echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
            foreach ($exams as $row) {
                if ($row['deleted'] == 0) {

                    echo '<option value="' . $row['online_exam_id'] . '">' . $row['title'] . '</option>';
                }
            }
        }
    }

    function get_job_title_for_exam($online_exam_id = "") {
        $this->if_user_login();
        $page_data['online_exam_id'] = $online_exam_id;
        $this->load->view('backend/user/employee_for_exam_selector', $page_data);
    }

    // Get Students Payment

    function get_students_payment($student_id) {
        $this->if_user_login();
        $students = $this->db->get_where('invoice', array('student_id' => $student_id))->result_array();
        $payments_category = $this->db->get('payments_category')->result_array();

        echo '<option value = "0">' . $this->lang->line('select') . '</option>';
        foreach ($payments_category as $row) {
            if (in_array($row, $students) == FALSE) {
                echo '<option value="' . $row['payments_category_id'] . '">' . $row['name'] . '</option>';
            }
        }
    }

    function get_payment_amount($payments_category_id) {
        $this->if_user_login();
        $price = $this->db->get_where('payments_category', array(
                    'payments_category_id' => $payments_category_id))->row()->price;
        echo $price;
    }

    function get_class_teacher_sections($class_id) {
        $this->if_user_login();
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();

        $this->db->where('job_title_id', 4);
        $this->db->where('active', 1);
        //$this->db->where('deleted', 0);
        $this->db->where('class_id', $class_id);
        //$this->db->or_where('class_id', 0);
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {
            echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_sections_1($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->teacher_id;
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();


        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {

            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->or_where('teacher_id_2', $row['employee_id']);
            $this->db->or_where('teacher_id_3', $row['employee_id']);
            $this->db->or_where('teacher_id_4', $row['employee_id']);
            $this->db->or_where('teacher_id_5', $row['employee_id']);
            $this->db->where('active', 1);
            $this->db->group_start();
            $this->db->where('class_id', $class_id);
            //$this->db->or_where('class_id', 0);
            $this->db->group_end();
            $teachers_check = $this->db->get('section')->num_rows();

            echo '<option value="' . $row['employee_id'] . '"';

            //if ($teachers_check == 1 && $teachers_1 != $row['employee_id']) {
            //    echo 'disabled';
            //}

            if ($teachers_1 == $row['employee_id']) {
                echo 'selected';
            }

            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_2_sections_1($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->teacher_id_2;
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();


        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {

            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->or_where('teacher_id_2', $row['employee_id']);
            $this->db->or_where('teacher_id_3', $row['employee_id']);
            $this->db->or_where('teacher_id_4', $row['employee_id']);
            $this->db->or_where('teacher_id_5', $row['employee_id']);
            $this->db->where('active', 1);
            $this->db->group_start();
            $this->db->where('class_id', $class_id);
            $this->db->or_where('class_id', 0);
            $this->db->group_end();
            $teachers_check = $this->db->get('section')->num_rows();

            echo '<option value="' . $row['employee_id'] . '"';

            if ($teachers_check == 1 && $teachers_1 != $row['employee_id']) {
                echo 'disabled';
            }

            if ($teachers_1 == $row['employee_id']) {
                echo 'selected';
            }

            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_3_sections_1($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->teacher_id_3;
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();


        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {

            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->or_where('teacher_id_2', $row['employee_id']);
            $this->db->or_where('teacher_id_3', $row['employee_id']);
            $this->db->or_where('teacher_id_4', $row['employee_id']);
            $this->db->or_where('teacher_id_5', $row['employee_id']);
            $this->db->where('active', 1);
            $this->db->group_start();
            $this->db->where('class_id', $class_id);
            $this->db->or_where('class_id', 0);
            $this->db->group_end();
            $teachers_check = $this->db->get('section')->num_rows();

            echo '<option value="' . $row['employee_id'] . '"';

            if ($teachers_check == 1 && $teachers_1 != $row['employee_id']) {
                echo 'disabled';
            }

            if ($teachers_1 == $row['employee_id']) {
                echo 'selected';
            }

            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_4_sections_1($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->teacher_id_4;
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();


        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {

            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->or_where('teacher_id_2', $row['employee_id']);
            $this->db->or_where('teacher_id_3', $row['employee_id']);
            $this->db->or_where('teacher_id_4', $row['employee_id']);
            $this->db->or_where('teacher_id_5', $row['employee_id']);
            $this->db->where('active', 1);
            $this->db->group_start();
            $this->db->where('class_id', $class_id);
            $this->db->or_where('class_id', 0);
            $this->db->group_end();
            $teachers_check = $this->db->get('section')->num_rows();

            echo '<option value="' . $row['employee_id'] . '"';

            if ($teachers_check == 1 && $teachers_1 != $row['employee_id']) {
                echo 'disabled';
            }

            if ($teachers_1 == $row['employee_id']) {
                echo 'selected';
            }

            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_5_sections_1($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->teacher_id_5;
        //$teachers = $this->db->get_where('employee', array('job_title_id' => '4', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();


        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $teachers = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teachers as $row) {

            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->or_where('teacher_id_2', $row['employee_id']);
            $this->db->or_where('teacher_id_3', $row['employee_id']);
            $this->db->or_where('teacher_id_4', $row['employee_id']);
            $this->db->or_where('teacher_id_5', $row['employee_id']);
            $this->db->where('active', 1);
            $this->db->group_start();
            $this->db->where('class_id', $class_id);
            $this->db->or_where('class_id', 0);
            $this->db->group_end();
            $teachers_check = $this->db->get('section')->num_rows();

            echo '<option value="' . $row['employee_id'] . '"';

            if ($teachers_check == 1 && $teachers_1 != $row['employee_id']) {
                echo 'disabled';
            }

            if ($teachers_1 == $row['employee_id']) {
                echo 'selected';
            }

            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_class_teacher_sections_2($class_id, $section_id) {
        $this->if_user_login();
        $teachers_1 = $this->db->get_where('section', array('section_id' => $section_id, 'class_id' => $class_id))->row()->assistant_teacher_id;
        $teachers = $this->db->get_where('employee', array('job_title_id' => '28', 'class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();

        $this->db->select('*');

        $this->db->group_start();
        $this->db->where('job_title_id', 4);
        $this->db->or_where('job_title_id', 28);
        $this->db->group_end();
        $this->db->where('active', 1);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();

        $teacher_sections_2 = $this->db->get('employee');
        $teacher_assistant_sections = $teacher_sections_2->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($teacher_assistant_sections as $row) {

            echo '<option value="' . $row['employee_id'] . '"';
            if (!empty($teachers_1) && $teachers_1 == $row['employee_id']) {
                echo 'selected';
            }
            echo '>' . $row['name'] . '</option>';
        }
    }

    function get_employee_level_1_2($class_id) {
        $this->if_user_login();
        //$page_data['class_id'] = $class_id;
        //$employee = $this->db->get_where('employee', array('class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();
        $employee = $this->db->order_by('name', 'ASC')->get_where('employee', array('class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();

        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();

        //$this->db->group_start();
        //$this->db->where('level', 1);
        //$this->db->or_where('level', 2);
        //$this->db->group_end();        

        $this->db->where('active', 1);
        $this->db->where('deleted', 0);

        $this->db->order_by('name', 'ASC');

        $employee = $this->db->get('employee')->result_array();

        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($employee as $row) {
            echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function check_assistant_teacher_for_add_section() {
        $this->if_user_login();
        $assistant_teacher_id = $_POST['assistant_teacher_id'];

        if ($_POST['section_id']) {
            $section_id = $_POST['section_id'];
        }

        //$checkdata = $this->db->get_where('section', array('assistant_teacher_id' => $assistant_teacher_id, 'active' => 1))->num_rows();

        $this->db->select('*');
        $this->db->where('active', 1);
        $this->db->where('teacher_id', $assistant_teacher_id);
        $this->db->or_where('assistant_teacher_id', $assistant_teacher_id);
        $checkdata_1 = $this->db->get('section');
        $checkdata = $checkdata_1->num_rows();

        if ($checkdata > 0) {
            if ($_POST['section_id']) {
                $old_assistant_teacher_id = $this->db->get_where('section', array('section_id' => $section_id))->row()->assistant_teacher_id;
                if ($old_assistant_teacher_id == $assistant_teacher_id) {
                    echo 'true';
                    return;
                }
            } else {
                echo 'false';
                return;
            }
        } else {
            echo 'true';
            return;
        }
    }

    function get_employee($class_id) {
        $this->if_user_login();
        //$page_data['class_id'] = $class_id;
        //$employee = $this->db->get_where('employee', array('class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();
        $employee = $this->db->order_by('name', 'ASC')->get_where('employee', array('class_id' => $class_id, 'active' => 1, 'deleted' => 0))->result_array();
        echo '<option value="' . 0 . '">' . $this->lang->line('select') . '</option>';
        foreach ($employee as $row) {
            echo '<option value="' . $row['employee_id'] . '">' . $row['name'] . '</option>';
        }
    }
}
