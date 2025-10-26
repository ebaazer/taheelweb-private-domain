<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 01/03/2021        
 *      MANAGE Web site
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Home extends CI_Controller {

    protected $theme;

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper('language');
        $this->load->model('crud_model');
        $this->load->model('email_model');
        $this->load->model('sms_model');
        $this->load->model('frontend_model');
        $this->load->model('star_rating_model');
        $this->load->library('pagination');

        $this->theme = $this->frontend_model->get_frontend_settings('theme');

        $this->db2 = $this->load->database('operating_system', TRUE);
        $this->db3 = $this->load->database('curriculum_scale', TRUE);

        /* Client Id */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $source = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } else {
            $source = $_SERVER['HTTP_HOST'];
        }
        $client_id = explode(".", $source)[0];
        $this->session->set_userdata('client_id', $client_id);

        /* language control */
        $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
        $site_lang = $this->session->userdata('site_lang');

        include 'inc_language.php';
    }

    public function index() {

        $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;
        if ($c_name != 'taheelweb') {
            $expiration_date = $this->db->get_where('settings', array('type' => 'expiration_date'))->row()->description;
            $curdate = date('Y-m-d');

//echo date('Y-m-d', strtotime($curdate. ' + 15 days'));
            if ($expiration_date < $curdate) {
                $this->expirat_page();
            } else {
                $this->home();
            }
        } else {
            $this->home();
        }
    }

    function home() {
        $page_data['page_name'] = 'home';
        $page_data['page_title'] = $this->lang->line('home');
        $page_data['departments'] = $this->frontend_model->get_departments();
        $page_data['doctors'] = $this->frontend_model->get_random_doctors(4);
        $page_data['sliders'] = $this->frontend_model->get_frontend_settings('slider');
        $page_data['welcome_content'] = $this->frontend_model->get_frontend_settings('homepage_welcome_section');
        $page_data['about_us_content'] = $this->frontend_model->get_frontend_settings('about_us');
        $page_data['opening_hours'] = $this->frontend_model->get_frontend_settings('opening_hours');
        $page_data['service_section'] = $this->frontend_model->get_frontend_settings('service_section');
        $page_data['mission_and_visions'] = $this->frontend_model->get_frontend_settings('mission_and_visions');
        $page_data['services'] = $this->frontend_model->get_services();

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function expirat_page() {
        $page_data['page_name'] = 'expirat_page';
        $page_data['page_title'] = $this->lang->line('home');
        $page_data['departments'] = $this->frontend_model->get_departments();
        $page_data['doctors'] = $this->frontend_model->get_random_doctors(4);
        $page_data['sliders'] = $this->frontend_model->get_frontend_settings('slider');
        $page_data['welcome_content'] = $this->frontend_model->get_frontend_settings('homepage_welcome_section');
        $page_data['about_us_content'] = $this->frontend_model->get_frontend_settings('about_us');
        $page_data['opening_hours'] = $this->frontend_model->get_frontend_settings('opening_hours');
        $page_data['service_section'] = $this->frontend_model->get_frontend_settings('service_section');
        $page_data['mission_and_visions'] = $this->frontend_model->get_frontend_settings('mission_and_visions');
        $page_data['services'] = $this->frontend_model->get_services();

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_what_is_taheelweb() {
        $page_data['page_name'] = 'p_what_is_taheelweb';
        $page_data['page_title'] = $this->lang->line('what_is_it') . ' ' . $this->lang->line('taheelweb');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_why_taheelweb() {
        $page_data['page_name'] = 'p_why_taheelweb';
        $page_data['page_title'] = $this->lang->line('Why') . ' ' . $this->lang->line('taheelweb');
        ;

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_features_taheelweb() {
        $page_data['page_name'] = 'p_features_taheelweb';
        $page_data['page_title'] = $this->lang->line('features') . ' ' . $this->lang->line('taheelweb');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_work_team() {
        $page_data['page_name'] = 'p_work_team';
        $page_data['page_title'] = $this->lang->line('team');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_our_story() {
        $page_data['page_name'] = 'p_our_story';
        $page_data['page_title'] = $this->lang->line('Our Story');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function how_to_subscribe() {
        $page_data['page_name'] = 'how_to_subscribe';
        $page_data['page_title'] = $this->lang->line('how_to_subscribe');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_price() {
        $page_data['page_name'] = 'p_price';
        $page_data['page_title'] = $this->lang->line('price');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_sponsoring_charity_center() {
        $page_data['page_name'] = 'p_sponsoring_charity_center';
        $page_data['page_title'] = $this->lang->line('Sponsor') . ' ' . $this->lang->line('charity') . '/' . $this->lang->line('center');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_digital_transformation_special_education_institutions() {
        $page_data['page_name'] = 'p_digital_transformation_special_education_institutions';
        $page_data['page_title'] = $this->lang->line('digital_transformation_of_special_education_institutions');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_what_is_waei() {
        $page_data['page_name'] = 'p_what_is_waei';
        $page_data['page_title'] = $this->lang->line('what_isit') . ' ' . $this->lang->line('initiative') . ' ' . $this->lang->line('waei');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_lectures() {

        $total_courses_taheelweb = $this->db->get_where('courses_taheelweb', array(
                    'publish_site' => 1,
                    'active' => 1
                ))->num_rows();

        $config = array();
        $config = pagination($total_courses_taheelweb, 9);
        $config['base_url'] = base_url() . 'home/p_lectures/';

        $config['attributes'] = array('class' => 'myclass');
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);

        $page_data['per_page'] = $config['per_page'];
        $page_data['page_name'] = 'p_lectures';
        $page_data['page_title'] = $this->lang->line('Lectures');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_Issuing_certificate() {
        $page_data['page_name'] = 'p_Issuing_certificate';
        $page_data['page_title'] = $this->lang->line('issuing_certificate');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_take_initiative_with_us() {
        $page_data['page_name'] = 'p_take_initiative_with_us';
        $page_data['page_title'] = $this->lang->line('badar_maeana');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_administrative_organizational_services_special_education_institutions() {
        $page_data['page_name'] = 'p_administrative_organizational_services_special_education_institutions';
        $page_data['page_title'] = $this->lang->line('administrative_organizational_services_special_education_institutions');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_training_qualification_cadres() {
        $page_data['page_name'] = 'p_training_qualification_cadres';
        $page_data['page_title'] = $this->lang->line('training_qualification_cadres');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function p_shadow_teacher() {
        $page_data['page_name'] = 'p_shadow_teacher';
        $page_data['page_title'] = $this->lang->line('Shadow_teacher');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function privacy_policy() {
        $page_data['page_name'] = 'privacy';
        $page_data['page_title'] = $this->lang->line('privacy');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function terms_of_service() {
        $page_data['page_name'] = 'terms_of_service';
        $page_data['page_title'] = $this->lang->line('Terms');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function curriculum_taheelweb() {
        $page_data['page_name'] = 'curriculum_taheelweb';
        $page_data['page_title'] = $this->lang->line('curriculum_taheelweb');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function soon_page() {
        $page_data['page_name'] = 'soon';
        $page_data['page_title'] = $this->lang->line('soon');
        $this->processes_model->visit_pages_site($page_data['soon']);
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function department($department_id) {
        $info = $this->frontend_model->get_department_info($department_id);
        $page_data['page_name'] = 'department';
        $page_data['page_title'] = $info->name;
        $page_data['department'] = $info;
        $page_data['departments'] = $this->frontend_model->get_departments();
        $page_data['doctors'] = $this->frontend_model->get_doctors($department_id);
        $page_data['facilities'] = $this->frontend_model->get_department_facilities($department_id);

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function doctors($department_id = '') {
        if ($department_id == '') {
            $page_data['doctors'] = $this->frontend_model->get_doctors();
        } else {
            $page_data['doctors'] = $this->frontend_model->get_doctors($department_id);
            $page_data['department'] = $this->frontend_model->get_department_info($department_id);
        }
        $page_data['departments'] = $this->frontend_model->get_departments();
        $page_data['page_name'] = 'doctors';
        $page_data['page_title'] = $this->lang->line('doctors');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    /*
      function get_doctor_details($doctor_id) {
      $page_data['doctor'] = $this->frontend_model->get_doctor_info($doctor_id);
      $this->load->view('frontend/' . $this->theme . '/slide_view', $page_data);
      }
     */

    function about_us() {
        $page_data['page_name'] = 'about_us';
        $page_data['page_title'] = $this->lang->line('about_us');
        $page_data['service_section'] = $this->frontend_model->get_frontend_settings('service_section');
        $page_data['about_us_content'] = $this->frontend_model->get_frontend_settings('about_us');
        $page_data['services'] = $this->frontend_model->get_services();

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function appointment($doctor_id = '') {
        if ($doctor_id != '') {
            $page_data['doctor'] = $this->frontend_model->get_doctor_info($doctor_id);
        }
        $page_data['page_name'] = 'appointment';
        $page_data['page_title'] = $this->lang->line('appointment');
        $page_data['departments'] = $this->frontend_model->get_departments();
        $page_data['recaptcha'] = json_decode($this->frontend_model->get_frontend_settings('recaptcha'));

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function make_an_appointment() {
        $result = $this->frontend_model->set_an_appointment();
        if ($result == 'success') {
            $this->session->set_flashdata('success_message', $this->lang->line('appointment_requested_successfully') . '. ' . $this->lang->line('log_in_to_your_account_to_see_whether_it_is_approved'));
            redirect(site_url('home/appointment'), 'refresh');
        } else if ($result == 'captcha_failed') {
            $this->session->set_flashdata('error_message', $this->lang->line('captcha_verification_failed'));
            redirect(site_url('home/appointment'), 'refresh');
        } else if ($result == 'code_failed') {
            $this->session->set_flashdata('error_message', $this->lang->line('invalid_patient_code'));
            redirect(site_url('home/appointment'), 'refresh');
        } else if ($result == 'email_exists') {
            $this->session->set_flashdata('error_message', $this->lang->line('email_already_exists'));
            redirect(site_url('home/appointment'), 'refresh');
        }
    }

    function check_patient_code($code) {
        $query = $this->db->get_where('patient', array(
                    'code' => $code
                ))->num_rows();

        echo $query == 1 ? 1 : 0;
    }

    function get_doctors_of_department($department_id) {
        if ($department_id != 0) {
            $page_data['department'] = $this->frontend_model->get_department_info($department_id);
        }
        $page_data['doctors'] = $this->frontend_model->get_doctors($department_id);
        $this->load->view('frontend/' . $this->theme . '/doctors_of_department', $page_data);
    }

    function tools_all() {

        $total_tools = $this->db->get_where('tools_taheelweb', array(
                    'published' => 1,
                    'active' => 1
                ))->num_rows();

        $config = array();
        $config = pagination($total_tools, 9);
        $config['base_url'] = base_url() . 'home/tools_all/';

        $config['attributes'] = array('class' => 'myclass');
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);

        $page_data['page_name'] = 'tools_all';
        $page_data['page_title'] = $this->lang->line('tools');
        $page_data['per_page'] = $config['per_page'];

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function blog() {

        $total_blogs = $this->db->get_where('frontend_blog', array(
                    'published' => 1,
                    'active' => 1
                ))->num_rows();

        $config = array();
        $config = pagination($total_blogs, 9);
        $config['base_url'] = base_url() . 'home/blog/';

        $config['attributes'] = array('class' => 'myclass');
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);

        $page_data['page_name'] = 'blog';
        $page_data['page_title'] = $this->lang->line('blog');
        $page_data['per_page'] = $config['per_page'];

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function categories_blog($param1 = '') {

        $categories_id = $param1;

        $total_blogs = $this->db->get_where('frontend_blog', array('published' => 1, 'active' => 1, 'categories_id' => $categories_id))->num_rows();

        $config = array();
        $config = pagination($total_blogs, 9);
        $config['base_url'] = base_url() . 'home/categories_blog/' . $categories_id . '/';

        $config['attributes'] = array('class' => 'myclass');
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);

        $page_data['categories_id'] = $categories_id;
        $page_data['page_name'] = 'categories_blog';
        $page_data['page_title'] = $this->lang->line('categories_blog');
        $page_data['per_page'] = $config['per_page'];
//$page_data['base_url'] = $config['base_url'];

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function blog_detail($blog_id = '') {

        $b_id = $this->db->get_where('frontend_blog', array('encrypt_thread' => $blog_id))->row()->frontend_blog_id;

        $page_data['page_name'] = 'blog_detail';
        $page_data['page_title'] = $this->lang->line('blog_details');
        $page_data['blog_id'] = $b_id;
        $page_data['blog'] = $this->frontend_model->get_blog_details($blog_id);

        $number_visits = $this->db->get_where('frontend_blog', array('frontend_blog_id' => $b_id))->row()->number_visits;

        $data['number_visits'] = $number_visits + 1;

        $this->db->where('frontend_blog_id', $b_id);
        $this->db->update('frontend_blog', $data);

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function tools_detail($tools_id = '') {

        $t_id = $this->db->get_where('tools_taheelweb', array('encrypt_thread' => $tools_id))->row()->tools_frontend_id;

        $page_data['page_name'] = 'tools_detail';
        $page_data['page_title'] = 'ادوات منصة تاهيل ويب';
        $page_data['tools_id'] = $t_id;
        $page_data['tools'] = $this->frontend_model->get_tools_details($tools_id);

        $number_visits = $this->db->get_where('tools_taheelweb', array('tools_frontend_id' => $t_id))->row()->number_visits;

        $data['number_visits'] = $number_visits + 1;

        $this->db->where('tools_frontend_id', $t_id);
        $this->db->update('tools_taheelweb', $data);

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

//غير مستخدم - تاكد قبل الحذف
    function question_details($question_id = '', $param2 = '', $param3 = '') {

        $question = $this->db->get_where('society_question', array('encrypt_thread' => $question_id))->row()->id;

        if ($question == null || $question == '') {
            redirect('/my404', 'refresh');
        } else {


            $num_visits = $this->db->get_where('society_question', array('id' => $question))->row()->visits;
            $data['visits'] = $num_visits + 1;

            $this->db->where('id', $question);
            $this->db->update('society_question', $data);

            if ($data['visits'] == 10000) {
                $question_user = $this->db->get_where('society_question', array('encrypt_thread' => $question_id))->row()->id_user_employee;
                $data_badge['user_id'] = $question_user;
                $data_badge['badge_id'] = 2;
                $data_badge['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_badge);
            } elseif ($data['visits'] == 6500) {
                $question_user = $this->db->get_where('society_question', array('encrypt_thread' => $question_id))->row()->id_user_employee;
                $data_badge['user_id'] = $question_user;
                $data_badge['badge_id'] = 23;
                $data_badge['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_badge);
            } elseif ($data['visits'] == 3000) {
                $question_user = $this->db->get_where('society_question', array('encrypt_thread' => $question_id))->row()->id_user_employee;
                $data_badge['user_id'] = $question_user;
                $data_badge['badge_id'] = 46;
                $data_badge['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_badge);
            }

            if ($this->session->userdata('userweb_login') == 1) {

                $if_user_visits_question = $this->db->get_where('user_visits_question', array('question_id' => $question, 'user_id' => $this->session->userdata('login_user_id')))->num_rows();
//$if_user_visits_question = 0;
                if ($if_user_visits_question > 0) {
                    
                } else {

                    $data_user_visits['user_id'] = $this->session->userdata('login_user_id');
                    $data_user_visits['question_id'] = $question;
                    $data_user_visits['date'] = date("Y-m-d H:i:s");
                    $this->db->insert('user_visits_question', $data_user_visits);

                    $num_user_visits_question = $this->db->get_where('user_visits_question')->num_rows();

                    if ($num_user_visits_question == 10000) {
                        $data_badge_records['user_id'] = $this->session->userdata('login_user_id');
                        $data_badge_records['badge_id'] = 5;
                        $data_badge_records['date'] = date("Y-m-d H:i:s");
                        $this->db->insert('badge_records', $data_badge_records);
                    } elseif ($num_user_visits_question == 6000) {
                        $data_badge_records['user_id'] = $this->session->userdata('login_user_id');
                        $data_badge_records['badge_id'] = 25;
                        $data_badge_records['date'] = date("Y-m-d H:i:s");
                        $this->db->insert('badge_records', $data_badge_records);
                    } elseif ($num_user_visits_question == 3000) {
                        $data_badge_records['user_id'] = $this->session->userdata('login_user_id');
                        $data_badge_records['badge_id'] = 49;
                        $data_badge_records['date'] = date("Y-m-d H:i:s");
                        $this->db->insert('badge_records', $data_badge_records);
                    }
                }
            }

            $question = $this->frontend_model->get_question_details($question);

            $this->db->select('id');
            $this->db->where("society_question_id", $question->id);
            $this->db->where("active", 1);
            $answerCount = $this->db->get('society_answers')->num_rows();

            $this->db->select("a.useful,a.answers");
            $this->db->from("society_answers a");
            $this->db->where("a.society_question_id", $question->id);
            $this->db->where("a.active", 1);
            $this->db->order_by('useful', 'DESC');
            $this->db->limit(1);
            $society_answers_question_array = $this->db->get()->result_array();

            $question_0 = strip_tags($question->question);
            $question_str = str_replace("&nbsp;", " ", $question_0);

            $answers_0 = strip_tags($society_answers_question_array[0]['answers']);
            $answers_str = str_replace("&nbsp;", " ", $answers_0);

            $results = array(
                'name' => $question->title_question,
                "text_q" => $question_str,
                'answerCount' => $answerCount, //Question
                'text_a' => $answers_str, //acceptedAnswer //Question
                'upvoteCount' => $society_answers_question_array[0]['useful'], //acceptedAnswer
            );

            $page_data['page_name'] = 'question_details';
            $page_data['page_title'] = $this->lang->line('question_details');
            $page_data['question'] = $question;
            $page_data['answerCount'] = $answerCount;

            $page_data['results'] = $results;

            $this->processes_model->visit_pages_site($page_data['page_name']);
            $this->load->view('frontend/' . $this->theme . '/index', $page_data);
        }
    }

    function contact_us($param1 = "") {
        $page_data['page_name'] = 'contact_us';
        $page_data['page_title'] = $this->lang->line('contact_us');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function contact($param1 = "") {
        $page_data['page_name'] = 'contact_us';
        $page_data['page_title'] = $this->lang->line('contact_us');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function submit_contact() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_name'])) {
            $errors['contact_name'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = $this->lang->line('is_required');
        } else {
            $check_email = $this->test_input($_POST["contact_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            }
        }

        if (empty($_POST['contact_phone'])) {
            $errors['contact_phone'] = $this->lang->line('is_required');
        }

        //if (empty($_POST['contact_subject'])) {
        //    $errors['contact_subject'] = $this->lang->line('is_required');
        //}

        if (empty($_POST['contact_message'])) {
            $errors['main_message'] = $this->lang->line('is_required');
        }

        if (!empty($errors)) {
            //$main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            //array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            //contact
            $data_contact['name'] = $this->test_input($_POST["contact_name"]);
            $data_contact['email'] = $this->test_input($_POST["contact_email"]);
            $data_contact['phone'] = $this->test_input($_POST["contact_phone"]);
            //$data_contact['account_type_id'] = $this->test_input($_POST["contact_type"]);
            $data_contact['visit_subject'] = $this->test_input($_POST["contact_subject"]);
            $data_contact['message'] = $this->test_input($_POST["contact_message"]);
            $data_contact['timestamp'] = date("Y-m-d H:i:s");

            $this->db->insert('contact_email', $data_contact);
            //$contact_id = $this->db->insert_id();
            //$data_mailing_list['email'] = $data_contact['email'];
            //$data_mailing_list['date'] = date("Y-m-d H:i:s");
            //$this->db->insert('mailing_list', $data_mailing_list);

            $data['success'] = true;
            $data['message'] = $this->lang->line('thank_you');
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function footer_send() {

        //contact
        $data_contact['name'] = $this->test_input($_POST["contact_name"]);
        $data_contact['email'] = $this->test_input($_POST["contact_email"]);
        //$data_contact['phone'] = $this->test_input($_POST["contact_phone"]);
        //$data_contact['account_type_id'] = $this->test_input($_POST["contact_type"]);
        //$data_contact['visit_subject'] = $this->test_input($_POST["contact_subject"]);
        $data_contact['message'] = $this->test_input($_POST["contact_message"]);
        $data_contact['timestamp'] = date("Y-m-d H:i:s");

        $this->db->insert('contact_email', $data_contact);
        //$contact_id = $this->db->insert_id();
        //$data_mailing_list['email'] = $data_contact['email'];
        //$data_mailing_list['date'] = date("Y-m-d H:i:s");
        //$this->db->insert('mailing_list', $data_mailing_list);

        $data['success'] = true;
        $data['message'] = $this->lang->line('thank_you');

        //echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function registration($param1 = "") {
        $page_data['page_name'] = 'registration';
        $page_data['page_title'] = $this->lang->line('enroll');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function submit_registration() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_name'])) {
            $errors['contact_name'] = 'Name is required.';
        } else {
            $check_name = $this->test_input($_POST["contact_name"]);
            if (!preg_match("/^[\p{Arabic}a-zA-Z- ]+$/", $check_name) && !preg_match("/[א-ת]/", $check_name)) {
//"/[א-ת]/"
// if (!preg_match("/^[a-zA-Z-' ]*$/", $check_name)) {
                $errors['contact_name'] = "Only letters and white space allowed";
            }
        }

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = 'Email is required.';
        } else {
            $check_email = $this->test_input($_POST["contact_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            } elseif ($this->check_email($check_email) == false) {
                $errors['contact_email'] = "The email already exists";
            }
        }

        if (empty($_POST['contact_phone'])) {
            $errors['contact_phone'] = 'phone is required.';
        } else {
            $check_phone = $this->test_input($_POST["contact_phone"]);
            if (!preg_match("/^[0-9']*$/", $check_phone)) {
                $errors['contact_phone'] = "Only numbers allowed";
            } elseif ($this->check_phone($check_phone) == false) {
                $errors['contact_phone'] = "The phone already exists";
            }
        }

        if (empty($_POST['contact_password'])) {
            $errors['contact_password'] = 'password is required.';
        }

        if (empty($_POST['contact_type'])) {
            $errors['contact_type'] = 'Please choose an Interest';
        }

        if (!empty($errors)) {
            $main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $data_registration_1['name'] = $this->test_input($_POST["contact_name"]);
            $data_registration_1['capacity'] = 3;
            $data_registration_1['start_working_hours'] = '09:00';
            $data_registration_1['end_working_hours'] = '20:00';
            $data_registration_1['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_registration_1['date_added'] = date("Y-m-d H:i:s");

            $this->db->insert('class', $data_registration_1);
            $class_id = $this->db->insert_id();

            $data_registration_2['name'] = $this->test_input($_POST["contact_name"]);
            $data_registration_2['employee_code'] = bin2hex(random_bytes(25));
            $data_registration_2['job_title_id'] = 31;
            $data_registration_2['level'] = 2;
            $data_registration_2['phone'] = $this->test_input($_POST["contact_phone"]);
            $data_registration_2['email'] = $this->test_input($_POST["contact_email"]);
            $data_registration_2['password'] = sha1($this->test_input($_POST["contact_password"]));
            $data_registration_2['date_added'] = date("Y-m-d H:i:s");
            $data_registration_2['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_registration_2['key_pass'] = $this->test_input($_POST["contact_password"]);

            $this->db->insert('employee', $data_registration_2);
            $employee_id = $this->db->insert_id();

            $data_registration_3['class_id'] = $class_id;
            $data_registration_3['employee_id'] = $employee_id;
            $data_registration_3['date'] = date("Y-m-d H:i:s");

            $this->db->insert('employee_classes', $data_registration_3);

            $encrypt_thread = $this->input->post('class_id');
            $class_id = $this->db->get_where('class', array('encrypt_thread' => $encrypt_thread))->row()->class_id;

            $data_registration_4['class_id'] = $class_id;
            $data_registration_4['name'] = $data_registration_2['name'];
            $data_registration_4['nick_name'] = $data_registration_2['name'];
            $data_registration_4['capacity'] = 0;

            $data_registration_4['date_created'] = date("Y-m-d H:i:s");
            $data_registration_4['encrypt_thread'] = bin2hex(random_bytes(25));

            $this->db->insert('section', $data_registration_4);
            $sctions_id = $this->db->insert_id();

            $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            $years = explode('-', $year);
            $section_schedule['section_id'] = $sctions_id;
            $section_schedule['start_date'] = $years[0] . '-09-01';
            $section_schedule['end_date'] = $years[0] . '-06-01';
            $section_schedule['year'] = $year;
            $this->db->insert("section_schedule", $section_schedule);

            $data['success'] = true;
            $data['message'] = 'Success!';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function booking_plan_step_1($param1 = '') {

        $page_data['page_name'] = 'booking_plan_step_1';
        $this->processes_model->visit_pages_site($page_data['booking']);
        $page_data['page_title'] = $this->lang->line('Booking');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function booking_plan_step_2($param1 = '') {

        $student_encrypt_thread = $param1;

        $page_data['student_encrypt_thread'] = $student_encrypt_thread;
        $page_data['page_name'] = 'booking_plan_step_2';
        $this->processes_model->visit_pages_site($page_data['booking']);
        $page_data['page_title'] = $this->lang->line('Booking');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function check_id_no($id_no = '') {

        //$phone = $_POST['phone'];
        //$old_phone = $_POST['old_phone'];

        $check_id_no = $this->db->get_where('student', array('no_identity' => $id_no))->row()->student_id;

        if ($check_id_no == 0 || $check_id_no == null) {
            $isAvailable = 0;
        } else {
            $isAvailable = $check_id_no;
        }

        return $isAvailable;
    }

    function booking_plan_step_1_ajax() {

        $errors = [];
        $data = [];

        if (empty($_POST['id_no'])) {
            //$errors['id_no'] = $this->lang->line('value_required');
            $errors['id_no'] = 'required';
        } else {
            $check_id_no = $this->test_input($_POST["id_no"]);
            if (!preg_match("/^[0-9']*$/", $check_id_no)) {
                $errors['id_no'] = "يسمج بالارقام فقط";
            } elseif ($this->check_id_no($check_id_no) == 0) {
                $errors['id_no'] = "لا يوجد بيانات متطابقة";
            }
        }

        $if_book = $this->db->get_where('booking_plan', array('id_no' => $_POST["id_no"]))->num_rows();

        if ($if_book > 0) {
            $my_book = $this->db->get_where('booking_plan', array('id_no' => $_POST["id_no"]))->row();
            $errors['id_no'] = "Appointment has been booked in advance." . ' ' . " " . $my_book->date_m . ' ' . '- ' . $my_book->time_m . ' A.M';
        }


        $no_encrypt_thread = $this->db->get_where('student', array('no_identity' => $_POST["id_no"]))->row()->encrypt_thread;

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $data['success'] = true;
            $data['encrypt_thread'] = $no_encrypt_thread;
            $data['message'] = $no_encrypt_thread;
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    //booking_plan
    function booking_plan_step_2_ajax() {

        $errors = [];
        $data = [];

        $if_book = $this->db->get_where('booking_plan', array('id_no' => $_POST["id_no"]))->num_rows();

        if ($if_book > 0) {
            $my_book = $this->db->get_where('booking_plan', array('id_no' => $_POST["id_no"]))->row();
            $errors['id_no'] = "Appointment has been booked in advance." . ' ' . " " . $my_book->date_m . ' ' . '- ' . $my_book->time_m . ' A.M';
        }

        if ($_POST['section_name'] == '3111111111' || $_POST['section_name'] == '32') {
            $errors['id_no'] = "لا يوجد مواعيد لهذا الصف";
        }


        if (empty($_POST['student_id'])) {
            $errors['all_e'] = "There are no data";
        }

        if (empty($_POST['parent_id'])) {
            $errors['all_e'] = "There are no data";
        }

        if (empty($_POST['section_id'])) {
            $errors['all_e'] = "There are no data";
        }

        if (empty($_POST['section_name'])) {
            $errors['all_e'] = "There are no data";
        }

        if (empty($_POST['date_m'])) {
            $errors['all_e'] = "There are no data";
        }

        if ($_POST['time_m'] == "00:00") {
            //$errors['time_m'] = $this->lang->line('is_required');
            $errors['time_m'] = required;
        }

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $data_contact['id_no'] = $this->test_input($_POST["id_no"]);
            $data_contact['student_id'] = $this->test_input($_POST["student_id"]);
            $data_contact['parent_id'] = $this->test_input($_POST["parent_id"]);
            $data_contact['section_id'] = $this->test_input($_POST["section_id"]);
            $data_contact['section_name'] = $this->test_input($_POST["section_name"]);
            $data_contact['date_m'] = $this->test_input($_POST["date_m"]);
            $data_contact['time_m'] = $this->test_input($_POST["time_m"]);
            $data_contact['date_add'] = date("Y-m-d H:i:s");

            $this->db->insert('booking_plan', $data_contact);

            $data['success'] = true;
            $data['message'] = "The appointment was booked on " . ' ' . $data_contact['date_m'] . ' ' . ' - ' . $data_contact['time_m'] . ' Thank you';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function booking($param1 = '') {
        if ($param1 == 'contact') {
            $result = $this->frontend_model->send_contact_message();
            if ($result == true) {
                $this->session->set_flashdata('success_message', $this->lang->line('your_message_was_sent') . '.' . $this->lang->line('we_will_be_in_touch_with_you_shortly'));
            } else {
                $this->session->set_flashdata('error_message', $this->lang->line('captcha_validation_failed'));
            }
            redirect(base_url() . 'index.php/home/contact_us', 'refresh');
        }

        $page_data['page_name'] = 'booking';
        $this->processes_model->visit_pages_site($page_data['booking']);
        $page_data['page_title'] = $this->lang->line('Booking');
//$page_data['recaptcha'] = json_decode($this->frontend_model->get_frontend_settings('recaptcha'));
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function gallery() {

        //$count_gallery = $this->db->get_where('frontend_gallery', array('published' => 1))->num_rows();
        //$config = array();
        //$config = manager($count_gallery, 6);
        //$config['base_url'] = site_url('home/gallery/');
        //$this->pagination->initialize($config);
        //$page_data['per_page'] = $config['per_page'];

        $page_data['page_name'] = 'gallery';
        $page_data['page_title'] = $this->lang->line('gallery');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function gallery_view($id = '') {

        $gallery_id = $this->db->get_where('frontend_gallery', array('encrypt_thread' => $id))->row()->frontend_gallery_id;
        //$count_images = $this->db->get_where('frontend_gallery_image', array('frontend_gallery_id' => $gallery_id))->num_rows();
        //$config = array();
        //$config = manager($count_images, 9);
        //$config['base_url'] = base_url() . 'index.php/home/gallery_view/' . $gallery_id . '/';
        //$this->pagination->initialize($config);
        //$page_data['per_page'] = $config['per_page'];

        $number_visits = $this->db->get_where('frontend_gallery', array('frontend_gallery_id' => $gallery_id))->row()->number_visits;
        $data['number_visits'] = $number_visits + 1;
        $this->db->where('frontend_gallery_id', $gallery_id);
        $this->db->update('frontend_gallery', $data);

        $page_data['gallery_id'] = $gallery_id;
        $page_data['page_name'] = 'gallery_view';
        $page_data['page_title'] = $this->lang->line('gallery');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function new_booking() {

        $name = $_POST['name'];
        $student_name = $_POST['students_name'];
        $visit_subject = $_POST['subject_visit'];
        $datetime = $_POST['datetime'] . ':00';
        $phone = $_POST['phone'];

        $data = array(
            'name' => $name,
            'student_name' => $student_name,
            'visit_subject' => $visit_subject,
            'datetime' => $datetime,
            'phone' => $phone
        );

        $this->db->insert('book_visit', $data);

        //echo $this->lang->line("book_has_been_confirmed");
        redirect(base_url() . 'home/booking_ok/', 'refresh');
    }

    function save_subscribe() {

        $data['email'] = $_POST["email_subscribeSr"];
        $data['date'] = date("Y-m-d H:i:s");

        $this->db->insert('mailing_list', $data);
        echo "done";
    }

    /*
      function register_demo() {
      $page_data['page_name'] = 'register_demo';
      $page_data['page_title'] = $this->lang->line('register');
      $this->load->view('frontend/' . $this->theme . '/index', $page_data);
      }
     */

    function frequently_asked_questions() {
        $page_data['page_name'] = 'frequently_asked_questions';
        $page_data['page_title'] = $this->lang->line('frequently_asked_questions');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function feature_tour() {
        $page_data['page_name'] = 'feature_tour';
        $page_data['page_title'] = $this->lang->line('Feature Tour');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function reasons_101() {
        $page_data['page_name'] = 'reasons_101';
        $page_data['page_title'] = $this->lang->line('reasons_101');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function pricing() {
        $page_data['page_name'] = 'pricing';
        $page_data['page_title'] = $this->lang->line('pricing');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function our_story() {
        $page_data['page_name'] = 'our_story';
        $page_data['page_title'] = $this->lang->line('our_story');
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    public function check_email($email = '') {

//$email = $_POST['email'];

        $checkAdmin = $this->db->get_where('admin', array('email' => $email))->num_rows();
        $checkEmployee = $this->db->get_where('employee', array('email' => $email))->num_rows();
        $checkParent = $this->db->get_where('parent', array('email' => $email))->num_rows();
        $checkTechnical = $this->db->get_where('technical_support', array('email' => $email))->num_rows();

        if ($checkAdmin > 0 || $checkEmployee > 0 || $checkParent > 0 || $checkTechnical > 0) {
            $isAvailable = false;
        } else {
            $isAvailable = true;
        }

        return $isAvailable;
    }

    function check_phone($phone = '', $old_phone = '') {

//$phone = $_POST['phone'];
//$old_phone = $_POST['old_phone'];

        $checkAdmin = $this->db->get_where('admin', array('phone' => $phone))->num_rows();
        $checkEmployee = $this->db->get_where('employee', array('phone' => $phone))->num_rows();
        $checkParent = $this->db->get_where('parent', array('phone' => $phone))->num_rows();
        $checkTechnical = $this->db->get_where('technical_support', array('phone' => $phone))->num_rows();

//بحاجة اذا كان نفس الرقم اظهار انه نفس الرقم واعطاء استجابه انه صحيح
        if ($checkAdmin > 0 || $checkEmployee > 0 || $checkParent > 0 || $checkTechnical > 0) {

            if ($old_phone == $phone) {
                $isAvailable = true;
            } else {
                $isAvailable = false;
            }
        } else {
            $isAvailable = true;
        }

        return $isAvailable;
    }

//courses_certificates
    function courses_certificates($param1 = "") {
        $page_data['page_name'] = 'courses_certificates';
        $page_data['page_title'] = "اصدار شهادة دورة أو ورشة";

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    public function check_email_course_subscribers($email = '', $course_id = "") {

//$email = $_POST['email'];
//1 دورة عبدالله خاطر
//2 ورشة تاهيل ويب
//3 مدخل للسلوك اللفظي
//4 دورة تعديل سلوك
//5 ورشة المعلم المرشد

        $checkEmail = $this->db->get_where('course_subscribers', array('email' => $email, 'course_id' => $course_id))->num_rows();

        if ($checkEmail > 0) {
            $isAvailable = true;
        } else {
            $isAvailable = false;
        }
        return $isAvailable;
    }

    function submit_courses_certificates() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = $this->lang->line('required');
        } else {
            $check_email = $this->test_input(strtoupper($_POST["contact_email"]));
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            } elseif ($this->check_email_course_subscribers($check_email, $_POST['courses_id']) == true) {
//$errors['contact_email'] = "The email already exists";
            } else {
                $errors['contact_email'] = "The email not exists";
            }
        }

        if ($_POST['courses_id'] == 0) {
            $errors['contact_courses_id'] = $this->lang->line('required');
        }

        if (!empty($errors)) {
            $main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $data['success'] = true;
            $data['message'] = 'Success!';
            $encrypt_thread_Email = $this->db->get_where('course_subscribers', array('email' => $check_email, 'course_id' => $_POST['courses_id']))->row()->encrypt_thread;
            $data['encrypt_thread'] = $encrypt_thread_Email;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function certificates_num($input, $pad_len = 7, $prefix = null) {
//FTW ورشة تدريبية مجانية
//PTW ورشة تدريبية مدفوعة
        $prefix = "FTW-";
        if ($pad_len <= strlen($input)) {
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
        }
        if (is_string($prefix)) {
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);

// Returns input with 7 zeros padded on the left
//echo invoice_num(1); // Output: 0000001
// Returns input with 10 zeros padded
//echo invoice_num(1, 10); // Output: 0000000001
// Returns input with prefixed F- along with 7 zeros padded
//echo invoice_num(1, 7, "F-"); // Output: F-0000001
// Returns input with prefixed F- along with 10 zeros padded
//echo invoice_num(1, 10, "F-"); // Output: F-0000000001        
    }

    function print_courses_certificates($param1 = '', $param2 = '', $param3 = '') {

        $this->load->library('pdf_lib');

        $user_data = $this->db->get_where('course_subscribers', array('encrypt_thread' => $param1))->row();

        $course_data = $this->db->get_where('courses_taheelweb', array('id' => $user_data->course_id))->row();

//certificate_text
        $page_data['course_id'] = $user_data->course_id;
        $page_data['certificate_text'] = $course_data->certificate_text;
        $page_data['name_user'] = $user_data->name;
        $page_data['certificates_num'] = $this->certificates_num($user_data->id);
        $page_data['page_name'] = 'courses_certificates_view';
        $page_data['page_title'] = 'اصدار شهادات تاهيل ويب';
//courses_certificates_view
        $this->load->view('frontend/taheelweb/index', $page_data);
    }

//teacher_guide_form


    function teacher_guide_form($param1 = '', $param2 = '', $param3 = '') {

//$page_data['name_user'] = $name;
        $page_data['page_name'] = 'teacher_guide_form';
        $page_data['page_title'] = 'دليل معلم التربية الخاصة';

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function teacher_guide_download($param1 = '', $param2 = '', $param3 = '') {

        $download_en = $this->db->get_where('teacher_guide', array('encrypt_thread' => $param1));

        if ($download_en->num_rows() > 0) {

            $teacher_guide_data = $download_en->row();

            if ($teacher_guide_data->expiration_date > date("Y-m-d H:m:s")) {

                $page_data['page_name'] = 'teacher_guide_download';
                $page_data['page_title'] = 'تنزيل دليل معلم التربية الخاصة';
            } else {

                $page_data['page_name'] = 'teacher_guide_download_expiration';
                $page_data['page_title'] = 'تنزيل دليل معلم التربية الخاصة';
            }
        } else {
            redirect(base_url() . 'Error_page', 'refresh');
            return;
        }

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function teacher_guide_form_submit() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = 'Email is required.';
        } else {
            $check_email = $this->test_input($_POST["contact_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            }
        }

        if (empty($_POST['contact_type'])) {
            $errors['contact_type'] = 'Please choose an Interest';
        }

        if (!empty($errors)) {
            $main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $data_registration_1['email'] = $_POST['contact_email'];
            $data_registration_1['contact_type'] = $_POST['contact_type'];
            $data_registration_1['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_registration_1['date'] = date("Y-m-d H:i:s");
            $data_registration_1['expiration_date'] = date("Y-m-d H:i:s", strtotime('23 hours'));
//$data_registration_1['expiration_date'] = date("Y-m-d H:i:s", strtotime('1 minutes'));

            $this->db->insert('teacher_guide', $data_registration_1);

            $data_mailing_list['email'] = $_POST['contact_email'];
            $data_mailing_list['date'] = date("Y-m-d H:i:s");
            $this->db->insert('mailing_list', $data_mailing_list);

            $r_encrypt_thread = $data_registration_1['encrypt_thread'];

            $data['success'] = true;
            $data['message'] = 'Success!';
            $data['r_encrypt_thread'] = $r_encrypt_thread;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

//autism_screening_form_1
    function autism_screening_form_0($param1 = '', $param2 = '', $param3 = '') {

//$page_data['name_user'] = $name;
        $page_data['page_name'] = 'autism_screening_form_0';
        $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function get_autism_screening_form($param1 = '', $param2 = '', $param3 = '') {

        if ($param1 == 1) {
            $data_autism_screening_item = $this->db3->get_where('autism_screening_item', array('id' => 1))->row();
            return $data_autism_screening_item;
        } else {
            $data_autism_screening_item = $this->db3->get_where('autism_screening_item', array('id' => $param1))->row();
            return $data_autism_screening_item;
        }
    }

    function autism_screening_form($param1 = '', $param2 = '', $param3 = '') {

        if ($param1 == null) {
            $page_data['page_name'] = 'autism_screening_form_r';
            $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';
            $this->load->view('frontend/' . $this->theme . '/index', $page_data);
        } else {
            $r_submit = $this->db->get_where('autism_screening_form_submit', array('encrypt_thread' => $param1))->row()->id;

            if ($r_submit == null) {
                $data_autism_screening_item = $this->get_autism_screening_form(1);
                $page_data['item_id'] = $data_autism_screening_item->id;
                $page_data['item'] = $data_autism_screening_item->item;
                $page_data['encrypt_thread'] = $data_autism_screening_item->encrypt_thread;
                $page_data['r_encrypt_thread'] = $param1;

                $data_autism_screening_item_n = $this->get_autism_screening_form(2);
                $page_data['encrypt_thread_n'] = $data_autism_screening_item_n->encrypt_thread;
                $page_data['encrypt_thread_p'] = $data_autism_screening_item->encrypt_thread;

                $page_data['page_name'] = 'autism_screening_form_r';
                $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';
                $this->load->view('frontend/' . $this->theme . '/index', $page_data);
            } else {

                if ($param2 == null) {
                    $data_autism_screening_item = $this->get_autism_screening_form(1);
                    $page_data['item_id'] = $data_autism_screening_item->id;
                    $page_data['item'] = $data_autism_screening_item->item;
                    $page_data['encrypt_thread'] = $data_autism_screening_item->encrypt_thread;
                    $page_data['r_encrypt_thread'] = $param1;

                    $data_autism_screening_item_n = $this->get_autism_screening_form(2);
                    $page_data['encrypt_thread_n'] = $data_autism_screening_item_n->encrypt_thread;
                    $page_data['encrypt_thread_p'] = $data_autism_screening_item->encrypt_thread;

                    $page_data['page_name'] = 'autism_screening_form';
                    $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';
                    $this->load->view('frontend/' . $this->theme . '/index', $page_data);
                } else {

                    $item_id = $this->db3->get_where('autism_screening_item', array('encrypt_thread' => $param2))->row()->id;

                    if ($item_id == null) {
                        $page_data['page_name'] = 'autism_screening_form_r';
                        $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';
                        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
                    } elseif ($item_id == 26) {

                        $r_submit = $this->db->get_where('autism_screening_form_submit', array('encrypt_thread' => $param1))->row()->id;

                        $this->db->select_sum('degree');
                        $this->db->where('form_submit_id', $r_submit);
                        $result = $this->db->get('autism_screening_form_record')->row();
                        $page_data['total_degree'] = $result->degree;

                        $page_data['page_name'] = 'autism_screening_form_re';
                        $page_data['page_title'] = 'مؤشرات الحاجة إلى خدمات التربية الخاصة';
                        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
                    } else {

                        $data_autism_screening_item = $this->get_autism_screening_form($item_id);
                        $page_data['item_id'] = $data_autism_screening_item->id;
                        $page_data['item'] = $data_autism_screening_item->item;
                        $page_data['encrypt_thread'] = $data_autism_screening_item->encrypt_thread;
                        $page_data['r_encrypt_thread'] = $param1;

                        $data_autism_screening_item_n = $this->get_autism_screening_form($item_id + 1);
                        $page_data['encrypt_thread_n'] = $data_autism_screening_item_n->encrypt_thread;
                        $data_autism_screening_item_p = $this->get_autism_screening_form($item_id - 1);
                        $page_data['encrypt_thread_p'] = $data_autism_screening_item_p->encrypt_thread;

                        $page_data['page_name'] = 'autism_screening_form';
                        $page_data['page_title'] = '';
                        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
                    }
                }
            }
        }
    }

    function autism_screening_form_submit() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_name'])) {
            $errors['contact_name'] = 'Name is required.';
        } else {
            $check_name = $this->test_input($_POST["contact_name"]);
            if (!preg_match("/^[\p{Arabic}a-zA-Z- ]+$/", $check_name) && !preg_match("/[א-ת]/", $check_name)) {
//"/[א-ת]/"
// if (!preg_match("/^[a-zA-Z-' ]*$/", $check_name)) {
                $errors['contact_name'] = "Only letters and white space allowed";
            }
        }

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = 'Email is required.';
        } else {
            $check_email = $this->test_input($_POST["contact_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            }
        }

        if (empty($_POST['contact_phone'])) {
            $errors['contact_phone'] = 'phone is required.';
        } else {
            $check_phone = $this->test_input($_POST["contact_phone"]);
            if (!preg_match("/^[0-9']*$/", $check_phone)) {
                $errors['contact_phone'] = "Only numbers allowed";
            }
        }

        if (empty($_POST['contact_type'])) {
            $errors['contact_type'] = 'Please choose an Interest';
        }

        if (!empty($errors)) {
            $main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $data_registration_1['name'] = $this->test_input($_POST["contact_name"]);
            $data_registration_1['email'] = $_POST['contact_email'];
            $data_registration_1['phone'] = $_POST['contact_phone'];
            $data_registration_1['contact_type'] = $_POST['contact_type'];
            $data_registration_1['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_registration_1['date_added'] = date("Y-m-d H:i:s");

            $this->db->insert('autism_screening_form_submit', $data_registration_1);

            $data_mailing_list['email'] = $_POST['contact_email'];
            $data_mailing_list['date'] = date("Y-m-d H:i:s");
            $this->db->insert('mailing_list', $data_mailing_list);

            $r_encrypt_thread = $data_registration_1['encrypt_thread'];

            $data['success'] = true;
            $data['message'] = 'Success!';
            $data['r_encrypt_thread'] = $r_encrypt_thread;
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function save_item() {

        $data_gole = explode('-', $_POST['id']);

//item_id
//r_encrypt_thread
        $r_submit = $this->db->get_where('autism_screening_form_submit', array('encrypt_thread' => $data_gole[1]))->row()->id;

        $if_record_id = $this->db->get_where('autism_screening_form_record', array('form_submit_id' => $r_submit, 'item_id' => $data_gole[0]));

        if ($if_record_id->num_rows() > 0) {

            $data['degree'] = $data_gole[2];

            $this->db->where('id', $if_record_id->row()->id);
            $this->db->update('autism_screening_form_record', $data);
        } else {
            $data_record['form_submit_id'] = $r_submit;
            $data_record['item_id'] = $data_gole[0];
            $data_record['degree'] = $data_gole[2];
            $data_record['date_added'] = date("Y-m-d H:i:s");
            $this->db->insert('autism_screening_form_record', $data_record);
        }
    }

    function fetch() {
        echo $this->star_rating_model->html_output();
    }

    function insert() {
        if ($this->input->post('rate_info_id')) {
            $data = array(
                'rate_info_id' => $this->input->post('rate_info_id'),
                'rating' => $this->input->post('index')
            );
            $this->star_rating_model->insert_rating($data);
        }
    }

    function all_tags() {

        $total_post = $this->db->get_where('tag', array('active' => 1))->num_rows();

        $config = array();
        $config = pagination($total_post, 36);
        $config['base_url'] = base_url() . 'home/all_tags/';
        $this->pagination->initialize($config);
        $page_data['per_page'] = $config['per_page'];

        $page_data['page_name'] = 'all_tags';
        $page_data['page_title'] = '';

        $this->processes_model->visit_pages_site($page_data['page_name']);
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function tagfilter() {

        $results = array();
        $entry = $_POST['input'];

        $this->db->like('name', $entry);
        $query = $this->db->get('tag');

        $html = '<div class="row">';

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                array_push($results, array(
                    'id' => $row["id"],
                    'name' => $row["name"],
                    'encrypt_thread' => $row["encrypt_thread"],
                    'description' => $row["description"],
                ));
            }

            foreach ($results as $all_tag_row) {

                $this->db->select("a.id");
                $this->db->from("tag_used a");
                $this->db->where("a.tag_id", $all_tag_row["id"]);
                $this->db->where("a.active", 1);
                $num_use = $this->db->get()->num_rows();

                $this->db->select("a.id");
                $this->db->from("tag_used a");
                $this->db->where('a.tag_id', $all_tag_row['id']);
                $this->db->where('a.post_type', 1);
                $this->db->where('a.active', 1);
                $num_use_q = $this->db->get()->num_rows();

                $this->db->select("a.id");
                $this->db->from("tag_used a");
                $this->db->where('a.tag_id', $all_tag_row['id']);
                $this->db->where('a.post_type', 3);
                $this->db->where('a.active', 1);
                $this->db->group_by('a.tag_id');
                $num_use_b = $this->db->get()->num_rows();

                $html .= '

                    <div class="col-12 col-lg-6" style="margin-bottom: 10px;">
                                <div class="member-card">
                                    <div class="card-body ">
                                        <div class="text-left member-title">' .
                        $all_tag_row["name"]
                        . '</div>
                                        <div class="text-left member-description" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;">' .
                        $all_tag_row["description"]
                        . '</div>
                                        <div class="member-contact">
                                            <div class="row">
                                                <div class="col-4">
                                                    <a href="' . base_url() . 'home/question_by_tag/' . $all_tag_row["encrypt_thread"] . '" title="اظهر الاسئلة الموسومة بــ ' . $all_tag_row["name"] . '">' .
                        $num_use_q
                        . '
                                                        سؤال
                                                    </a>
                                                </div>
                                                <div class="col-4">
                                                    <a href="' . base_url() . 'home/blog_by_tag/' . $all_tag_row["encrypt_thread"] . '" title="اظهر المقالات الموسومة بــ ' . $all_tag_row["name"] . '">' .
                        $num_use_b
                        . '                                     
                                                        مقال
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                         ';
            }
            $html .= '</div>';
            echo $html;
        } else {
            echo '<h1 class="fs-headline1 mb16">لا يوجد نتائج</h1>';
        }
    }

    function question_by_tag($param1 = '', $param2 = '', $param3 = '') {

        $if_tag = $this->db->get_where('tag', array('encrypt_thread' => $param1));

        if ($if_tag->num_rows() == 0) {
            redirect(site_url('my404'), 'refresh');
            return;
        } else {
            $total_post = $this->db->get_where('tag_used', array('post_type' => 1, 'tag_id' => $if_tag->row()->id))->num_rows();

            $total_post = $this->db->get_where('tag_used', array('tag_id' => $if_tag->row()->id, 'post_type' => 1, 'active' => 1))->num_rows();
            $config = array();
            $config = pagination($total_post, 15);
            $config['base_url'] = base_url() . 'home/question_by_tag/' . $if_tag->row()->encrypt_thread;
//$config['base_url'] = base_url() . 'home/question_by_tag/';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(4) : 0;
            $this->pagination->initialize($config);
            $page_data['per_page'] = $config['per_page'];
            $page_data['page'] = $page;

            $page_data['post_type'] = 1;
            $page_data['tag_id'] = $if_tag->row()->id;
            $page_data['tag_description'] = $if_tag->row()->description;
            $page_data['tag_name'] = $if_tag->row()->name;
            $page_data['tag_encrypt_thread'] = $if_tag->row()->encrypt_thread;
            $page_data['page_name'] = 'question_by_tag';
            $page_data['page_title'] = '';
            $this->load->view('frontend/' . $this->theme . '/index', $page_data);
        }
    }

    function blog_by_tag($param1 = '', $param2 = '', $param3 = '') {

        $if_tag = $this->db->get_where('tag', array('encrypt_thread' => $param1));

        if ($if_tag->num_rows() == 0) {
            redirect(site_url('my404'), 'refresh');
            return;
        } else {
            $total_post = $this->db->get_where('tag_used', array('post_type' => 1, 'tag_id' => $if_tag->row()->id))->num_rows();

            $total_post = $this->db->get_where('tag_used', array('tag_id' => $if_tag->row()->id, 'post_type' => 3, 'active' => 1))->num_rows();
            $config = array();
            $config = pagination($total_post, 15);
            $config['base_url'] = base_url() . 'home/blog_by_tag/' . $if_tag->row()->encrypt_thread;
//$config['base_url'] = base_url() . 'home/question_by_tag/';
            $page = ($this->uri->segment(3)) ? $this->uri->segment(4) : 0;
            $this->pagination->initialize($config);
            $page_data['per_page'] = $config['per_page'];
            $page_data['page'] = $page;

            $page_data['post_type'] = 3;
            $page_data['tag_id'] = $if_tag->row()->id;
            $page_data['tag_description'] = $if_tag->row()->description;
            $page_data['tag_name'] = $if_tag->row()->name;
            $page_data['tag_encrypt_thread'] = $if_tag->row()->encrypt_thread;
            $page_data['page_name'] = 'blog_by_tag';
            $page_data['page_title'] = '';
            $this->load->view('frontend/' . $this->theme . '/index', $page_data);
        }
    }

    function society() {

        $total_question = $this->db->get_where('society_question', array('q_for' => 'p', 'publish' => 1, 'active' => 1))->num_rows();

        $config = array();
        $config = pagination($total_question, 15);
//$config['base_url'] = base_url() . 'index.php/home/society/';
        $config['base_url'] = base_url() . 'home/society/';
        $this->pagination->initialize($config);

        $page_data['per_page'] = $config['per_page'];

        $page_data['page_name'] = 'society';
        $page_data['page_title'] = "الاسئلة";

        $this->processes_model->visit_pages_site($page_data['page_name']);
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function question_not_answered() {

        $total_question = $this->db->get_where('society_question', array('publish' => 1, 'active' => 1, 'is_answered' => 0))->num_rows();

        $config = array();
        $config = pagination($total_question, 15);
        $config['base_url'] = base_url() . 'home/question_not_answered/';
        $this->pagination->initialize($config);

        $page_data['per_page'] = $config['per_page'];

        $page_data['page_name'] = 'question_not_answered';
        $page_data['page_title'] = $this->lang->line('society');

        $this->processes_model->visit_pages_site($page_data['page_name']);
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function questionfilter() {

        $results = array();
        $entry = $_POST['input'];

        $this->db->like('title_question', $entry);
        $query = $this->db->get('society_question');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                array_push($results, array(
                    'id' => $row["id"],
                    'title_question' => $row["title_question"],
                    'encrypt_thread' => $row["encrypt_thread"],
                    'question' => $row["question"],
                    'tags' => $row["tags"],
                    'date' => $row["date"],
                    'visits' => $row["visits"],
                    'useful' => $row["useful"],
                ));
            }

            foreach ($results as $society_question_array_row) {

                $this->db->select('id');
                $this->db->where("society_question_id", $society_question_array_row['id']);
                $this->db->where("active", 1);
                $society_answers_question = $this->db->get('society_answers')->num_rows();

                if ($society_answers_question == 0) {

                    $society_answers_question_re = '
                                            <div class="s-post-summary--stats-item has-answers" title="0 answer">
                                                <span class="s-post-summary--stats-item-number">0</span>
                                                <span class="s-post-summary--stats-item-unit">اجابات</span>
                                            </div> ';
                } else {

                    $society_answers_question_re = '
                                            <div class="s-post-summary--stats-item has-answers has-accepted-answer" title="one of the answers was accepted as the correct answer">
                                                <svg aria-hidden="true" class="svg-icon iconCheckmarkSm" width="14" height="14" viewBox="0 0 14 14"><path d="M13 3.41 11.59 2 5 8.59 2.41 6 1 7.41l4 4 8-8Z"></path></svg>
                                                <span class="s-post-summary--stats-item-number">
                                                    ' . $society_answers_question . '
                                                </span>
                                                <span class="s-post-summary--stats-item-unit">اجابات</span>
                                            </div>';
                }

                $html = '
                    <div class="member-card" style=" direction: rtl;">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-2 mb-1">

                                    <div class="s-post-summary--stats js-post-summary-stats">
                                        <div class="s-post-summary--stats-item s-post-summary--stats-item__emphasized" title="حصل على ' . $society_question_array_row["useful"] . '">
                                            <span class="s-post-summary--stats-item-number">
                                                ' . $society_question_array_row["useful"] . '                  
                                            </span>
                                            <span class="s-post-summary--stats-item-unit">صوت</span>
                                        </div>' .
                        $society_answers_question_re . '

                                        <div class="s-post-summary--stats-item" title="' . $society_question_array_row["visits"] . ' مشاهدات">
                                            <span class="s-post-summary--stats-item-number">' . $society_question_array_row["visits"] . '</span>
                                            <span class="s-post-summary--stats-item-unit">مشاهدات</span>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-12 col-lg-10">

                                    <div class="text-left member-title member-subtitle">

                                        <a href="' . base_url() . 'home/question_details/' . $society_question_array_row["encrypt_thread"] . '" class="s-link">
                                                ' . $society_question_array_row["title_question"] . '
                                        </a>                                    
                                    </div>

                                    <div class="text-left member-description" style="display: -webkit-box;
                                         -webkit-line-clamp: 3;
                                         -webkit-box-orient: vertical;
                                         overflow: hidden;">
                                        ' . strip_tags($society_question_array_row["question"]) . '
                                        ...
                                    </div>
                                    <div class="" style=" margin-top: 10px;">

                                        <ul class="mr0 list-ls-none js-post-tag-list-wrapper d-inline" style=" margin: 0px;
                                            padding: 0px;">';
                $tags_specialties = explode(",", $society_question_array_row["tags"]);

                foreach ($tags_specialties as $tags_specialties_row) {
                    $tag_data = $this->db->get_where("tag", array("id" => $tags_specialties_row))->row();

                    $new_style = 'style = "background-color: #f2720c; color: aliceblue;font-weight: bold;"';

                    $html .= '<li class="d-inline mr4 js-post-tag-list-item">
                                                    <a href="' . base_url() . 'home/question_by_tag/' . $tag_data->encrypt_thread . '"
                                                       class="post-tag flex--item mt0 js-tagname-javascript"
                                                       title="اظهر الاسئلة الموسومة بــ ' . $tag_data->name . '"
                                                       aria-label="اظهر الاسئلة الموسومة بــ ' . $tag_data->name . '"
                                                       rel="tag" aria-labelledby="' . $tag_data->name . '">
                                                         ' . $tag_data->name . '
                                                    </a>
                                                </li>';
                }
                $html .= '</ul>
                                    </div>                                    

                                    <div class="s-post-summary--meta">
                                        <div class="s-post-summary--meta-tags tags js-tags t-javascript t-nodeûjs t-reactjs t-npm t-node-modules" >

                                            <div class="s-user-card s-user-card__minimal">
                                                <time class="s-user-card--time">
                                                    سئل منذ 
                                                    <span title="" class="relativetime">';
                $first_date = new DateTime($society_question_array_row["date"]);
                $second_date = new DateTime(date("Y-m-d H:i:s"));
                $interval = $first_date->diff($second_date);

                if ($interval->format("%Y") >= 1) {
                    $html .= $interval->format("%Y سنة");
                }

                if ($interval->format("%M") >= 1) {
                    $html .= $interval->format("%M شهر") . ' و';
                }

                if ($interval->format("%D") >= 1) {
                    $html .= $interval->format("%D يوم");
                } else {
                    $html .= $interval->format("%h ساعة %i دقيقة");
                }

                $html .= '</span>
                                                </time>
                                            </div>

                                        </div>
                                    </div>                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>';
                echo $html;
            }
        } else {
            echo '<h1 class="fs-headline1 mb16">لا يوجد نتائج</h1>';
        }
    }

    function entity_add() {

        $page_data['page_name'] = 'entity_add';
        $page_data['page_title'] = $this->lang->line('entity_add');
        $this->processes_model->visit_pages_site($page_data['page_name']);
        $this->load->view('frontend/' . $this->theme . '/index', $page_data);

//redirect(site_url('/home/entity_add/'));
    }

    function entity_add_insert($param1 = '', $param2 = '', $param3 = '') {

        $errors = [];
        $data = [];

        if (empty($_POST['title_question'])) {
            $errors['contact_title_question'] = 'title question is required.';
        }

        if (empty($_POST['question'])) {
            $errors['contact_question'] = 'question is required.';
        }


        if (empty($_POST['tags'])) {
            $errors['contact_tags'] = 'tags is required.';
        }

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $tags_array = array();

            $tags = explode(",", $this->input->post('tags'));

            foreach ($tags as $row) {

                $this->db->select("a.*");
                $this->db->from("tag a");
                $this->db->where("name", $row);
                $tag_id = $this->db->get()->row()->id;

                if ($tag_id > 0) {
                    array_push($tags_array, $tag_id);
                } else {

                    $data_new_tag['name'] = $row;
                    $data_new_tag['encrypt_thread'] = bin2hex(random_bytes(32));
                    $this->db->insert('tag', $data_new_tag);

                    $tag_id = $this->db->insert_id();
                    array_push($tags_array, $tag_id);

                    $data_tag_origin['tag_id'] = $tag_id;
                    $data_tag_origin['user_id'] = $this->session->userdata('login_user_id');
                    $data_tag_origin['date'] = date("Y-m-d H:i:s");
                    $this->db->insert('tag_origin', $data_tag_origin);
                }
            }

            $data_q['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_q['title_question'] = $this->input->post('title_question');
            $data_q['id_user_employee'] = $this->session->userdata('login_user_id');
            $data_q['question'] = $this->input->post('question');
//$data_q['skills'] = $this->input->post('skills');
            $data_q['user_type'] = $this->session->userdata('login_type');
            $data_q['tags'] = implode(",", $tags_array);

            if ($this->input->post('is_unknown') == 'on') {
                $data_q['is_unknown'] = 1;
            } else {
                $data_q['is_unknown'] = 0;
            }

            $data_q['date'] = date("Y-m-d H:i:s");

            $this->db->insert('society_question', $data_q);
            $question_id = $this->db->insert_id();

            $if_first_question = $this->db->get_where('society_question', array('id_user_employee' => $this->session->userdata('login_user_id')))->num_rows();
            if ($if_first_question == 1) {
                $data_first_question['user_id'] = $this->session->userdata('login_user_id');
                $data_first_question['badge_id'] = 44; //اي دي قام بطرح سؤاله الاول
                $data_first_question['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_first_question);
            }

            $data_points['id_user_employee'] = $this->session->userdata('login_user_id');
            $data_points['user_type'] = $this->session->userdata('login_type');
            $data_points['points'] = 25; //نقاط اضافة سؤال
            $data_points['reward_for'] = 1;
            $data_points['id_post'] = $question_id;
            $data_points['date'] = date("Y-m-d H:i:s");
            $this->db->insert('history_points', $data_points);

//function master_badges_add
//$this->master_badges_add_64($this->session->userdata('login_user_id'));
//$this->master_badges_add_65($this->session->userdata('login_user_id'));
//$this->master_badges_add_66($this->session->userdata('login_user_id'));

            $new_rrrr = explode(",", $data_q['tags']);

            foreach ($tags_array as $new_rrrr_row) {
                $questions_specialties_taq['post_id'] = $question_id;
                $questions_specialties_taq['post_type'] = 1; // 1 يعني نوع المشاركة سؤال
                $questions_specialties_taq['tag_id'] = $new_rrrr_row;
                $questions_specialties_taq['user_id'] = $this->session->userdata('login_user_id');
                $questions_specialties_taq['date'] = date("Y-m-d H:i:s");
                $this->db->insert('tag_used', $questions_specialties_taq);

                $num_to = $this->db->get_where('tag', array('id' => $new_rrrr_row))->row()->tag_used;

                $data_used['tag_used'] = $num_to + 1;

                $this->db->where('id', $new_rrrr_row);
                $this->db->update('tag', $data_used);
            }

            $data['success'] = true;
            $data['message'] = 'Success!';
            $data['r_encrypt_thread'] = $data_q['encrypt_thread'];

//print_r($data);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function customWordCount($content_text = "") {
        $content_text = 'آمل آمل آمل أن يكون هذا يعمل هذه هي بعض بعبارة أخرى الكلمة هذه هي بعض الكلمة بعبارة أخرى آمل أن الكلمة يكون هذا يعمل';

        $resultArray = explode(' ', trim($content_text));
        foreach ($resultArray as $key => $item) {
            if (in_array($item, ["|", ";", ".", "-", "=", ":", "{", "}", "[", "]", "(", ")"])) {
                $resultArray[$key] = '';
            }
        }

        $resultArray = array_filter($resultArray);

        $array = array(12, 43, 66, 21, 56, 43, 43, 78, 78, 100, 43, 43, 43, 21);
        $vals = array_count_values($resultArray);

//return count($resultArray);
        echo '<pre>';
        print_r($vals);
        echo '</pre>';
    }

    function save_answers() {


        $errors = [];
        $data = [];

        if (empty($_POST['u_answers'])) {
            $errors['contact_title_question'] = 'u answers is required.';
        }

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

//$type = $_POST["type"];
//$emp = $_POST["id"];

            $data_society_answers['id_user_employee'] = $this->session->userdata('login_user_id');

            $data_society_answers['user_type'] = $this->session->userdata('login_type');
            $data_society_answers['society_question_id'] = $_POST['society_question_id'];
            $data_society_answers['answers'] = $_POST['u_answers'];

            if ($_POST['is_unknown'] == '1') {
                $data_society_answers['is_unknown'] = 1;
            } else {
                $data_society_answers['is_unknown'] = 0;
            }

            $data_society_answers['date'] = date("Y-m-d H:i:s");
            $data_society_answers['encrypt_thread'] = bin2hex(random_bytes(32));

            $this->db->insert('society_answers', $data_society_answers);
            $answers_id = $this->db->insert_id();

            $data_is_answered['is_answered'] = 1;
            $this->db->where('id', $_POST['u_answers']);
            $this->db->update('society_question', $data_is_answered);

            $if_first_answers = $this->db->get_where('society_answers', array('id_user_employee' => $this->session->userdata('login_user_id')))->num_rows();
            if ($if_first_answers == 1) {
                $data_first_question['user_id'] = $this->session->userdata('login_user_id');
                $data_first_question['badge_id'] = 47; //اول اجابة له
                $data_first_question['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_first_question);
            }

            $if_answer_his_question = $this->db->get_where('society_question', array('id_user_employee' => $this->session->userdata('login_user_id'), 'id' => $_POST['u_answers']))->num_rows();

            if ($if_answer_his_question == 1) {

                $if_user_badge = $this->db->get_where('badge_records', array('user_id' => $this->session->userdata('login_user_id'), 'badge_id' => 48))->num_rows();

                if ($if_user_badge > 0) {
                    
                } else {
                    $data_first_question['user_id'] = $this->session->userdata('login_user_id');
                    $data_first_question['badge_id'] = 48; //
                    $data_first_question['date'] = date("Y-m-d H:i:s");
                    $this->db->insert('badge_records', $data_first_question);
                }
            }

            if ($if_answer_his_question == 125) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 67; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            } elseif ($if_answer_his_question == 85) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 68; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            } elseif ($if_answer_his_question == 25) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 41; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            }

            $num_answers = $this->db->get_where('society_answers', array('id_user_employee' => $this->session->userdata('login_user_id')))->num_rows();
            if ($num_answers == 500) {
                $data_first_question['user_id'] = $this->session->userdata('login_user_id');
                $data_first_question['badge_id'] = 7; //
                $data_first_question['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_first_question);
            }

            $num_unknown_answers = $this->db->get_where('society_answers', array('id_user_employee' => $this->session->userdata('login_user_id'), 'is_unknown' => 1))->num_rows();
            if ($num_unknown_answers == 125) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 9; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            } elseif ($num_unknown_answers == 85) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 29; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            } elseif ($num_unknown_answers == 25) {
                $data_unknown_answers['user_id'] = $this->session->userdata('login_user_id');
                $data_unknown_answers['badge_id'] = 51; //
                $data_unknown_answers['date'] = date("Y-m-d H:i:s");
                $this->db->insert('badge_records', $data_unknown_answers);
            }

            $data_points['id_user_employee'] = $this->session->userdata('login_user_id');
            $data_points['user_type'] = $this->session->userdata('login_type');
            $data_points['points'] = 15; // نقاط الاجابة على السؤال
            $data_points['reward_for'] = 3; // يعني انه جواب
            $data_points['id_post'] = $answers_id;
            $data_points['date'] = date("Y-m-d H:i:s");
            $this->db->insert('history_points', $data_points);

//function master_badges_add
//$this->master_badges_add_64($this->session->userdata('login_user_id'));
//$this->master_badges_add_65($this->session->userdata('login_user_id'));
//$this->master_badges_add_66($this->session->userdata('login_user_id'));

            $questions_data = $this->db->get_where('society_question', array('id' => $_POST['u_answers']))->row()->specialties;
            $new_rrrr = explode(",", $questions_data);
            foreach ($new_rrrr as $new_rrrr_row) {
                $questions_specialties_taq['questions_id'] = $_POST['u_answers'];
                $questions_specialties_taq['post_type'] = 2; // 2 يعني المشاركة كانت اجابة
                $questions_specialties_taq['specialties_taq_id'] = $this->db->get_where('specialties', array('name' => $new_rrrr_row))->row()->id;
                $questions_specialties_taq['user_id'] = $this->session->userdata('login_user_id');
                $questions_specialties_taq['date'] = date("Y-m-d H:i:s");
                $this->db->insert('questions_specialties_taq', $questions_specialties_taq);
            }

//echo $num_to_rate;
            $data['success'] = true;
            $data['message'] = 'Success!';
//$data['r_encrypt_thread'] = $data_q['encrypt_thread'];
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function courses_taheelweb() {

        $total_courses = $this->db->get_where('courses_taheelweb', array(
                    'publish_site' => 1
                ))->num_rows();

        $config = array();
        $config = pagination($total_courses, 9);
        $config['base_url'] = base_url() . 'home/courses_taheelweb/';

        $config['attributes'] = array('class' => 'myclass');
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);

        $page_data['page_name'] = 'courses_taheelweb';
        $page_data['page_title'] = "courses"; //$this->lang->line('courses');
        $page_data['per_page'] = $config['per_page'];

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function courses_taheelweb_detail($courses_taheelweb_id = '') {

        $c_id = $this->db->get_where('courses_taheelweb', array('encrypt_thread' => $courses_taheelweb_id))->row()->id;

        $page_data['page_name'] = 'p_lectures_detail';
        $page_data['courses_taheelweb'] = $this->frontend_model->get_courses_taheelweb_details($courses_taheelweb_id);
        $page_data['page_title'] = $page_data['courses_taheelweb']->name;
        $page_data['courses_taheelweb_id'] = $c_id;

        $number_visits = $this->db->get_where('courses_taheelweb', array('id' => $c_id))->row()->number_visits;

        $data['number_visits'] = $number_visits + 1;

        $this->db->where('id', $c_id);
        $this->db->update('courses_taheelweb', $data);

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    public function change_language($language = "") {
        $this->session->set_userdata('site_lang', $language);
        $this->session->set_userdata('language', $language);

        if ($language == 'arabic') {
            $this->session->set_userdata('site_folder', 'rtl');
        } else {
            $this->session->set_userdata('site_folder', 'ltr');
        }

        echo 'true';
        return;
    }

//calendly center
    function calendly_center() {

        $page_data['page_name'] = 'calendly_center';
        $page_data['page_title'] = "calendly"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function calendly_register_center() {

        $page_data['page_name'] = 'calendly_register_center';
        $page_data['page_title'] = "calendly register"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

//calendly taheelweb
    function calendly_taheelweb() {

        $page_data['page_name'] = 'calendly';
        $page_data['page_title'] = "calendly"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function fetch_calendly($param1 = '', $param2 = '', $param3 = '') {

        $this->db->select("a.meeting_time");
        $this->db->from("calendly a");
        $this->db->where("a.pick_date", $param1);
        $pick_date = $this->db->get()->result_array();

        echo json_encode(array_column($pick_date, 'meeting_time'), JSON_UNESCAPED_UNICODE);
    }

    function calendly_register() {

        $page_data['page_name'] = 'calendly_register';
        $page_data['page_title'] = "calendly register"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function submit_calendly_taheelweb() {

        $errors = [];
        $data = [];

        if (empty($_POST['calendly_name'])) {
            $errors['calendly_name'] = '(' . $this->lang->line('can_not_be_empty') . ')';
        }

        if (empty($_POST['calendly_email'])) {
            $errors['calendly_email'] = '(' . $this->lang->line('can_not_be_empty') . ')';
        } else {
            $check_email = $this->test_input($_POST["calendly_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['calendly_email'] = "Invalid email format";
            }
        }

        if (empty($_POST['calendly_phone'])) {
            $errors['calendly_phone'] = '(' . $this->lang->line('can_not_be_empty') . ')';
        }

        if (empty($_POST['calendly_country'])) {
            $errors['calendly_country'] = '(' . $this->lang->line('can_not_be_empty') . ')';
        }

        if (empty($_POST['calendly_institution'])) {
            $errors['calendly_institution'] = '(' . $this->lang->line('can_not_be_empty') . ')';
        }

        if (!empty($errors)) {
//$main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
//array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

//contact
            $data_contact['name'] = $this->test_input($_POST["calendly_name"]);
            $data_contact['email'] = $this->test_input($_POST["calendly_email"]);
            $data_contact['phone'] = $this->test_input($_POST["calendly_phone"]);

            $data_contact['pick_date'] = $_POST["pick_date"];

            $data_contact['institution'] = $this->test_input($_POST["calendly_institution"]);
            $data_contact['​​interest'] = $this->test_input($_POST["calendly_interest"]);
            $data_contact['roll'] = $this->test_input($_POST["calendly_roll"]);
            $data_contact['country'] = $this->test_input($_POST["calendly_country"]);
            $data_contact['more'] = $this->test_input($_POST["calendly_more"]);
//$data_contact['meeting_date'] = $this->test_input($_POST["meeting_date"]);
            $data_contact['timestamp'] = date("Y-m-d H:i:s");

            $meeting_date = $this->test_input($_POST["meeting_date"]);
            $ex_meeting_date = explode(" ", $meeting_date);

            $time = $ex_meeting_date[0];
            $day_name = $ex_meeting_date[1];
            $day_num = $ex_meeting_date[3];
            $month = $ex_meeting_date[2];
//$year = $ex_meeting_date[4];
            $data_contact['meeting_time'] = $time;
            $data_contact['meeting_day_name'] = $day_name;
            $data_contact['meeting_day_num'] = $day_num;
            $data_contact['meeting_month'] = $month;

//2:00pm Tuesday July 23

            $this->db->insert('calendly', $data_contact);
//$contact_id = $this->db->insert_id();

            $data_mailing_list['email'] = $data_contact['email'];
            $data_mailing_list['date'] = date("Y-m-d H:i:s");
            $this->db->insert('mailing_list', $data_mailing_list);

            $data['success'] = true;
            $data['message'] = "شكرا لكم، سيتم التواصل معكم لتأكيد الموعد";
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function order_summary($param1 = '', $param2 = '', $param3 = '') {

//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
//echo '<br />';


        $subscription_types = $_POST["plan_id"];

//die();

        /*

          [price_input2] => 1250
          [teamSizeSelect_old2] => 129
          [storageSizeSelect_old2] => 96
          [additional_student_price2] => 12.5
          [price_input_storage2] => 5
          [final_total2] => 1792.5
          [basic_service_price2] => 1250
          [total_student_service2] => 362.5
          [total_storage_service2] => 180
          [_token] => IdcTFw3Qud8qKxQZOLcTCV1uRfTuURbygxsSMynz
          [plan_id] => 17
          [users_number] => 5
          [account_type_id] => 7
          [period] => Monthly
          [is_free] => 0


         */

        $data_order = [];

        $data_order['price_input'] = $_POST["price_input$subscription_types"];
        $data_order['teamSizeSelect_old'] = $_POST["teamSizeSelect_old$subscription_types"];
        $data_order['storageSizeSelect_old'] = $_POST["storageSizeSelect_old$subscription_types"];
        $data_order['additional_student_price'] = $_POST["additional_student_price$subscription_types"];
        $data_order['price_input_storage'] = $_POST["price_input_storage$subscription_types"];
        $data_order['final_total'] = $_POST["final_total$subscription_types"];
        $data_order['basic_service_price'] = $_POST["basic_service_price$subscription_types"];
        $data_order['total_student_service'] = $_POST["total_student_service$subscription_types"];
        $data_order['total_storage_service'] = $_POST["total_storage_service$subscription_types"];
        $data_order['subscription_types'] = $_POST["subscription_types$subscription_types"];

        $page_data['data_order'] = $data_order;
        $page_data['page_name'] = 'p_price_order_summary';
        $page_data['page_title'] = "order_summary"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function register_demo() {

        $page_data['page_name'] = 'p_register_demo';
        $page_data['page_title'] = "register demo"; //$this->lang->line('courses');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function submit_register_demo() {

        $errors = [];
        $data = [];

        if (empty($_POST['name_reg'])) {
            $errors['name_reg'] = $this->lang->line('can_not_be_empty');
        } else {
            $check_name = $this->test_input($_POST["name_reg"]);
            if (!preg_match("/^[\p{Arabic}a-zA-Z- ]+$/u", $check_name)) {
// if (!preg_match("/^[a-zA-Z-' ]*$/", $check_name)) {
                $errors['name_reg'] = $this->lang->line('only_letters_white_space_allowed');
            }
        }

        if (empty($_POST['phone_reg'])) {
            $errors['phone_reg'] = $this->lang->line('can_not_be_empty');
        } else {
            $check_phone = $this->test_input($_POST["phone_reg"]);
            if (!preg_match("/^[0-9']*$/", $check_phone)) {
                $errors['phone_reg'] = $this->lang->line('only_numbers_allowed');
            } else {
                $if_existing_phone = $this->db->get_where('client', array('phone' => $_POST['phone_reg']))->num_rows();
                if ($if_existing_phone > 0) {
                    //$errors['phone_reg'] = $this->lang->line('existing_phone');
                }
            }
        }

        if (empty($_POST['email_reg'])) {
            $errors['email_reg'] = $this->lang->line('can_not_be_empty');
        } else {
            $check_email = $this->test_input($_POST["email_reg"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['email_reg'] = $this->lang->line('invalid_email_format');
            } else {
                $if_existing_email = $this->db->get_where('client', array('email' => $_POST["email_reg"]))->num_rows();
                if ($if_existing_email > 0) {
                    //$errors['email_reg'] = $this->lang->line('existing_email');
                }
            }
        }

        if (empty($_POST['country_reg'])) {
            $errors['country_reg'] = $this->lang->line('can_not_be_empty');
        }

        if (empty($_POST['city_reg'])) {
            $errors['city_reg'] = $this->lang->line('can_not_be_empty');
        }

        if (empty($_POST['role_in_institution'])) {
            $errors['role_in_institution'] = $this->lang->line('can_not_be_empty');
        }

        if (empty($_POST['organization_reg'])) {
            $errors['organization_reg'] = $this->lang->line('can_not_be_empty');
        }

        /*
          if (empty($_POST['password_reg'])) {
          $errors['password_reg'] = $this->lang->line('can_not_be_empty');
          }
         */

        if (empty($_POST['url_reg'])) {
            $errors['url_reg'] = $this->lang->line('can_not_be_empty');
        } else {
            $check_url = $this->test_input($_POST["url_reg"]);
            $subsperm_not_allowed = array(
                'taheelweb',
                'demo',
                'demos',
                'ft',
                '8ayem',
                    //'',
            );
            if (!preg_match("/^[a-zA-Z-']*$/", $check_url)) {
                $errors['url_reg'] = "Only letters allowed";
            } elseif (in_array($check_url, $subsperm_not_allowed)) {
                $errors['url_reg'] = $this->lang->line('subsperm_not_allowed');
            } else {
                $if_existing_url = $this->db->get_where('client', array('url' => $_POST['url_reg']))->num_rows();
                if ($if_existing_url > 0) {
                    $errors['url_reg'] = $this->lang->line('existing_url');
                }
            }
        }

        if (!empty($errors)) {
            $main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
            //$data['register_url'] = $_POST["url_reg"].'.taheelweb.com';
        } else {

            //client
            $data_client['name'] = $this->test_input($_POST["name_reg"]);
            //$data_client['location'] = $this->test_input($_POST["location_reg"]);
            //$data_client['Country_key_reg'] = $this->test_input($_POST["Country_key_reg"]);
            $data_client['phone'] = $this->test_input($_POST["phone_reg"]);
            $data_client['email'] = $this->test_input($_POST["email_reg"]);
            $data_client['country'] = $this->test_input($_POST["country_reg"]);
            $data_client['city'] = $this->test_input($_POST["city_reg"]);
            $data_client['organization'] = $this->test_input($_POST["organization_reg"]);
            $data_client['organization_size'] = $this->test_input($_POST["organization_size_reg"]);
            $data_client['role_in_institution'] = $this->test_input($_POST["role_in_institution"]);
            $data_client['website'] = $this->test_input($_POST["website_reg"]);
            $data_client['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_client['verify_email_code'] = random_int(100000, 999999);
            $data_client['verify_phone_code'] = random_int(100000, 999999);
            $data_client['date'] = date("Y-m-d H:i:s");
            $data_client['url'] = $this->test_input($_POST["url_reg"]);
            $this->db->insert('client', $data_client);
            $client_id = $this->db->insert_id();

            //subscriptions
            $data_subscriptions['client_id'] = $client_id;
            $data_subscriptions['account_type_id'] = $this->test_input($_POST["account_type_reg"]);

            if ($data_subscriptions['account_type_id'] == 1) {
                $data_subscriptions['types_subscriptions_id'] = 4;
                $data_subscriptions['expiration'] = date('Y-m-d H:i:s', strtotime($Date . ' + 14 days'));
                $data_subscriptions['expiration'] = date('Y-m-d H:i:s', strtotime($Date . ' + 14 days'));
            } else {
                $data_subscriptions['types_subscriptions_id'] = 5;
                $data_subscriptions['expiration'] = date('Y-m-d H:i:s', strtotime($Date . ' + 7 days'));
                $data_subscriptions['expiration'] = date('Y-m-d H:i:s', strtotime($Date . ' + 7 days'));
            }
            $data_subscriptions['url'] = $this->test_input($_POST["url_reg"]);
            //$data_subscriptions['types_subscriptions_id'] = 1;
            $data_subscriptions['start'] = date('Y-m-d H:i:s');
            $data_subscriptions['encrypt_thread'] = bin2hex(random_bytes(32));
            $data_client['url'] = $this->test_input($_POST["url_reg"]);

            $data_subscriptions['basic_number_students'] = 10;
            $data_subscriptions['additional_number_students'] = 0;
            $data_subscriptions['basic_storage_space'] = 5;
            $data_subscriptions['additional_storage_space'] = 0;
            //$data_subscriptions['coupon_code'] = ;
            //$data_subscriptions['coupon_discount_percentage'] = ;
            //$data_subscriptions['coupon_discount_value'] = ;
            $data_subscriptions['basic_product_price'] = 0;
            $data_subscriptions['additional_student_price'] = 0;
            $data_subscriptions['additional_storage_price'] = 0;
            $data_subscriptions['total_subscription_price'] = 0;
            $data_subscriptions['total_additional_student_price'] = 0;
            $data_subscriptions['total_additional_storage_price'] = 0;

            $this->db->insert('subscriptions', $data_subscriptions);
            $subscriptions_id = $this->db->insert_id();

            //invoice
            $data_invoice['types_subscriptions_id'] = $this->test_input($_POST["account_type_reg"]);
            $data_invoice['client_id'] = $client_id;
            $data_invoice['title'] = '';
            $data_invoice['description'] = '';
            $data_invoice['discount_id_1'] = '';
            $data_invoice['discount_amount_1'] = '';
            $data_invoice['discount_id_2'] = '';
            $data_invoice['discount_amount_2'] = '';
            $data_invoice['discount_id_3'] = '';
            $data_invoice['discount_amount_3'] = '';
            $data_invoice['vat'] = 0;
            $data_invoice['amount'] = 0;
            $data_invoice['amount_paid'] = 0;
            $data_invoice['due'] = 0;
            $data_invoice['creation_timestamp'] = date('Y-m-d H:i:s');
            $data_invoice['payment_timestamp'] = date('Y-m-d H:i:s');
            $data_invoice['payment_method'] = '';
            $data_invoice['payment_details'] = '';
            $data_invoice['status'] = '';
            $data_invoice['year'] = '';
            $data_invoice['encrypt_thread'] = bin2hex(random_bytes(32));

            $this->db->insert('invoice', $data_invoice);
            $invoice_id = $this->db->insert_id();

            //payment
            $data_payment['types_subscriptions_id'] = $this->test_input($_POST["account_type_reg"]);
            $data_payment['title'] = 'اشتراك في النسخة المجانية';
            $data_payment['payment_type'] = '';
            $data_payment['invoice_id'] = $invoice_id;
            $data_payment['method'] = '';
            $data_payment['description'] = 'free';
            $data_payment['amount'] = 0;
            $data_payment['timestamp'] = date('Y-m-d H:i:s');
            $data_payment['year'] = '';
            $data_payment['client_id'] = $client_id;
            $data_payment['user_id'] = '';
            $data_payment['encrypt_thread'] = bin2hex(random_bytes(32));

            $this->db->insert('payment', $data_payment);

            $url_reg = $this->test_input($_POST["url_reg"]);

            //$this->create_subdomain($url_reg);

            if ($this->create_subdomain($url_reg)) {
                $email = $this->test_input($_POST["email_reg"]);
                $url = $this->test_input($_POST["url_reg"]) . '.taheelweb.com';
                $password = random_int(100000, 999999);

                $this->reg_edit_admin_data($email, $url_reg, $password);
                $this->send_email_submit_register_demo($email, $url, $password);
            }

            //$this->unzip_file($data['client_url']);
            //$this->configure_database_php($data['client_url']);
            //$this->create_new_database($data['client_url']);
            //$this->run_blank_sql($data['client_url']);

            $data['success'] = true;
            $data['message'] = 'success!';
            $data['register_status'] = 'success';
            $data['register_url'] = $url_reg . '.taheelweb.com';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function create_subdomain($param1 = '', $param2 = '', $param3 = '') {

        $bearer = $this->db->get_where('settings', array('type' => 'bearer'))->row()->description;
        $subdomain = strtolower($param1);

        $data = array(
            "type" => "A",
            "name" => $subdomain,
            "data" => "164.90.175.32", // your ip address
            "ttl" => 3600
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.digitalocean.com/v2/domains/taheelweb.com/records");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $bearer" // your api key
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        curl_close($ch);

        $this->configure_yaml_file($subdomain);
        $this->create_new_database($subdomain);
        $this->run_blank_sql($subdomain);

        return $result = json_decode($result, true);
//print_r($result);
    }

    function configure_yaml_file($param1 = '', $param2 = '', $param3 = '') {
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', 'On');

        $yaml_file_name = strtolower($param1);

        $txt_add = '  
http:
  routers:
    ' . $yaml_file_name . 'WebApp:
      rule: "Host(`' . $yaml_file_name . '.taheelweb.com`)"
      service: ' . $yaml_file_name . 'Service
      tls:
        certResolver: myresolver
  services:
    ' . $yaml_file_name . 'Service:
      loadBalancer:
        passHostHeader: false
        servers:
          - url: "https://ft.taheelweb.com:8443"';

        $myfile = fopen("/usr2/apps/traefik/conf/$yaml_file_name.taheelweb.com.yaml", "w") or die("Unable to open file!");
        fwrite($myfile, $txt_add);
        fclose($myfile);
    }

    function run_blank_sql($param1 = '', $param2 = '', $param3 = '') {
        $db_name = strtolower($param1);

        shell_exec("cat /var/www/3b801d123185deaf565182b5e9cca6931d2a72a5695c1807/new_client_v2.sql|mysql -u root $db_name");
    }

    function create_new_database($param1 = '', $param2 = '', $param3 = '') {
        $this->load->dbforge();

        $db_name = strtolower($param1);

// check if database is created
//if ($this->dbforge->create_database($db_name)) {
//CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        $this->db->query('CREATE DATABASE ' . strtolower($db_name) . ' CHARACTER SET utf8 COLLATE utf8_unicode_ci;');
//echo 'Database created successfully...';
//}
    }

    function send_email_submit_register_demo($param1 = '', $param2 = '', $param3 = '') {

        $email = $param1;
        $url = $param2;

        $password = '21a071170c8f0435f6ee8b6ece43b415';
        $to = $email;
        $url = $url;
        $is_ok = '12DFJR4HS6SGJGTF4419';
        $pass_user = $param3;

        $is_valid_email = 'http://165.22.93.21/t_register_demo.php?val1=';
        $is_valid_email .= $password;
        $is_valid_email .= '&val2=';
        $is_valid_email .= $to;
        $is_valid_email .= '&val3=';
        $is_valid_email .= $url;
        $is_valid_email .= '&val4=';
        $is_valid_email .= $is_ok;
        $is_valid_email .= '&val5=';
        $is_valid_email .= $pass_user;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $is_valid_email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($response == 1) {
            //echo '1';
        } else {
            //echo '0';
        }
    }

    function reg_edit_admin_data($param1 = '', $param2 = '', $param3 = '') {

        $this->load->dbforge();

        $email = $param1;
        $db_for_con = $param2;
        $password = $param3;

        $db_con = array(
            'dsn' => '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => $db_for_con,
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => TRUE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );

        $this->db_con = $this->load->database($db_con, TRUE);
        //$student_id = $param2;

        $data['email'] = $param1;
        $data['password'] = sha1($param3);
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['key_pass'] = $param3;

        $this->db_con->insert('admin', $data);

        $data_2['description'] = date('Y-m-d', strtotime('+ 14 days'));
        //$data['description'] = '2023-01-01';

        $this->db_con->where('type', 'expiration_date');
        $this->db_con->update('settings', $data_2);

        //$this->db_con->where('id', 1);
        //$this->db_con->update('admin', $data);
        $this->db_con->close();
    }

    function job_application_form($param1 = "", $param2 = "", $param3 = "") {

        $page_data['page_name'] = 'job_application_form';
        $page_data['page_title'] = $this->lang->line('job_application_form');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function submit_job_application_form() {

        $errors = [];
        $data = [];

        if (empty($_POST['contact_name'])) {
            $errors['contact_name'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_email'])) {
            $errors['contact_email'] = $this->lang->line('is_required');
        } else {
            $check_email = $this->test_input($_POST["contact_email"]);
            if (!filter_var($check_email, FILTER_VALIDATE_EMAIL)) {
                $errors['contact_email'] = "Invalid email format";
            }
        }

        if (empty($_POST['contact_phone'])) {
            $errors['contact_phone'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_bio'])) {
            $errors['contact_bio'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_degree'])) {
            $errors['contact_degree'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_nationality'])) {
            $errors['contact_nationality'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_cv_link'])) {
            $errors['job_application_cv'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_country'])) {
            $errors['contact_country'] = $this->lang->line('is_required');
        }

        if (empty($_POST['contact_city'])) {
            $errors['contact_city'] = $this->lang->line('is_required');
        }

        if (!empty($errors)) {
            //$main_message = $errors['main_message'] = $this->lang->line('There is some data that needs correction');
            //array_push($errors, $main_message);
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $data_contact['apply_for'] = $this->test_input($_POST["contact_apply_for"]);
            $data_contact['name'] = $this->test_input($_POST["contact_name"]);
            $data_contact['email'] = $this->test_input($_POST["contact_email"]);
            $data_contact['phone'] = $this->test_input($_POST["contact_phone"]);
            $data_contact['bio'] = $this->test_input($_POST["contact_bio"]);
            $data_contact['degree'] = $this->test_input($_POST["contact_degree"]);
            $data_contact['years_experience'] = $this->test_input($_POST["contact_years_experience"]);
            $data_contact['nationality'] = $this->test_input($_POST["contact_nationality"]);
            $data_contact['cv_link'] = $this->test_input($_POST["contact_cv_link"]);

            $birth_day = $this->test_input($_POST["contact_birth_day"]);
            $birth_month = $this->test_input($_POST["contact_birth_month"]);
            $birth_year = $this->test_input($_POST["contact_birth_year"]);

            $data_contact['date_of_birth'] = $birth_day . '-' . $birth_month . '-' . $birth_year;
            $data_contact['english_level'] = $this->test_input($_POST["contact_english_level"]);
            $data_contact['computer_level'] = $this->test_input($_POST["contact_computer_level"]);
            $data_contact['country'] = $this->test_input($_POST["contact_country"]);
            $data_contact['city'] = $this->test_input($_POST["contact_city"]);

            $data_contact['date'] = date("Y-m-d H:i:s");

            $this->db->insert('job_application', $data_contact);

            $data['success'] = true;
            $data['message'] = $this->lang->line('thank_you');
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function add_cv_job_application_form() {

        $response = array();
        // Looping all files

        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));
        $folder = 'uploads/cv_job_application_form/';

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
        $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
        $name = $uname . '.' . $info->getExtension();
        $response = array(
            'url' => $relative_path,
            'name' => $name
        );

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    function masterslider_article($param1 = '', $param2 = '', $param3 = '') {

        if ($param1 == 'article_1') {
            $page_data['page_name'] = 'masterslider_article_1';
            $page_data['page_title'] = $this->lang->line('appointment');
        }

        if ($param1 == 'article_2') {
            $page_data['page_name'] = 'masterslider_article_2';
            $page_data['page_title'] = $this->lang->line('appointment');
        }


        if ($param1 == 'article_3') {
            $page_data['page_name'] = 'masterslider_article_3';
            $page_data['page_title'] = $this->lang->line('appointment');
        }

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function service_article($param1 = '', $param2 = '', $param3 = '') {

        if ($param1 == 'service_article_1') {
            $page_data['page_name'] = 'service_article_1';
            $page_data['page_title'] = $this->lang->line('appointment');
        }

        if ($param1 == 'service_article_2') {
            $page_data['page_name'] = 'service_article_2';
            $page_data['page_title'] = $this->lang->line('appointment');
        }


        if ($param1 == 'service_article_3') {
            $page_data['page_name'] = 'service_article_3';
            $page_data['page_title'] = $this->lang->line('appointment');
        }

        if ($param1 == 'service_article_4') {
            $page_data['page_name'] = 'service_article_4';
            $page_data['page_title'] = $this->lang->line('appointment');
        }

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }

    function booking_ok($param1 = "", $param2 = "", $param3 = "") {

        $page_data['page_name'] = 'booking_ok';
        $page_data['page_title'] = $this->lang->line('book_has_been_confirmed');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }
    
        function send_ok($param1 = "", $param2 = "", $param3 = "") {

        $page_data['page_name'] = 'send_ok';
        $page_data['page_title'] = $this->lang->line('book_has_been_confirmed');

        $this->load->view('frontend/' . $this->theme . '/index', $page_data);
    }
}
