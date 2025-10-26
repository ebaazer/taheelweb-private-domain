<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 31/03/2023
 *        
 *      MANAGE Auth Api
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class AuthApi extends CI_Controller {

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

    function alphanumeric($num = "") {
        //$alphanumeric = md5(time());
        //$alphanumeric = bin2hex(random_bytes(20));
        //$alphanumeric = sha1(time());
        //$alphanumeric = md5(date("Y-m-d H:i:s"));
        $alphanumeric = bin2hex(random_bytes($num));
        return $alphanumeric;
    }

    function filterRequest($requestname = "") {
        return htmlspecialchars(strip_tags($_POST[$requestname]));
    }

    function getAllData($table, $where = null, $values = null) {
        global $con;
        $data = array();

        $count = 0;
        if ($count > 0) {
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }

    function api_test() {

        //if (empty($this->session->userdata('login_user_id')))
        //    return;

        $verifycode = rand(10000, 99999);
        $user_name = $this->filterRequest("user_name");

        $this->db->select("COUNT(*) as count");
        $this->db->from("employee");
        $this->db->where("active", 1);
        $results = $this->db->get()->row()->count;

        $data['photo'] = $this->input->post('photo');
        $data['timestamp'] = date("Y-m-d H:i:s");
        $data['encrypt_thread'] = bin2hex(random_bytes(32));

        $this->db->insert('frontend_blog', $data);

        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function send_mail($to = "", $title = "", $body = "") {
        $to = "ebaa.zer@gmail.com";
        $title = "مرحبا في تاهيل ويب";
        $body = "تم انشاء حسابك في تاهيل ويب";
        $header = "From: info@taheelweb.com";
        mail($to, $title, $body, $header);
    }

    function verifycode($email = "", $verifycode = "") {
        
    }

    function get_data_student() {

        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';
        $user_level = $this->session->userdata('level');
        $section_ids = array();
        $employee_id = $this->session->userdata('employee_id');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $json_data = array();

        $this->db->select("a.* , b.encrypt_thread as student_encrypt_thread , b.name as student_name , b.gender as gender,b.img_type as img_type,b.img_url as img ,c.class_id, c.name as class_name, d.section_id, d.name as section_name, f.case_study_id as case_study");
        $this->db->from("enroll a");
        $this->db->join("student b", "a.student_id = b.student_id", 'left');
        $this->db->join("class c", "a.class_id = c.class_id", 'left');
        $this->db->join("section d", "a.section_id = d.section_id", 'left');

        //case_study
        $this->db->join("case_study f", "a.student_id = f.student_id", 'left');

        $this->db->where("a.year", $running_year);
        $this->db->where('a.status', 1);
        $this->db->where('b.active', 1);

        //$this->db->where("e.active", 1);

        $students = $this->db->get()->result_array();

        //array_unique($students);


        foreach ($students as $students_row) {

            if ($students_row['case_study'] == null) {
                $case_study = 0;
            } else {
                $case_study = 1;
            }

            array_push($json_data, array(
                'student_encrypt_thread' => $students_row['student_encrypt_thread'],
                'enroll_id' => $students_row['enroll_id'],
                'enroll_code' => $students_row['enroll_code'],
                'student_id' => $students_row['student_id'],
                'class_id' => $students_row['class_id'],
                'section_id' => $students_row['section_id'],
                'roll' => $students_row['roll'],
                'date_added' => $students_row['date_added'],
                'year' => $students_row['year'],
                'status' => $students_row['status'],
                'eligibility_number' => $students_row['eligibility_number'],
                'active' => $students_row['active'],
                'student_name' => $students_row['student_name'],
                'gender' => $students_row['gender'],
                'img_type' => $students_row['img_type'],
                'img' => $students_row['img'],
                'class_name' => $students_row['class_name'],
                'section_name' => $students_row['section_name'],
                'case_study' => $case_study,
            ));
        }

        //header('Content-Type: application/json');
        echo json_encode($json_data, JSON_UNESCAPED_UNICODE);

        //echo "hi ebaa";
    }
}
