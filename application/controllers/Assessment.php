<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	    @author 	: taheelweb
 *      MANAGE Assessment
 * 	
 * 	    http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Assessment extends CI_Controller {

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

    function alphanumeric() {
        //$alphanumeric = md5(time());
        //$alphanumeric = bin2hex(random_bytes(20));
        //$alphanumeric = sha1(time());
        //$alphanumeric = md5(date("Y-m-d H:i:s"));
        $alphanumeric = bin2hex(random_bytes(24));
        return $alphanumeric;
    }

    function alphanumeric_3() {
        //$alphanumeric = md5(time());
        //$alphanumeric = bin2hex(random_bytes(20));
        //$alphanumeric = sha1(time());
        //$alphanumeric = md5(date("Y-m-d H:i:s"));
        $alphanumeric = bin2hex(random_bytes(3));
        return $alphanumeric;
    }

    function assessment() {
        $this->if_user_login();

        $page_data['page_name'] = 'assessment';
        $page_data['page_title'] = $this->lang->line('manage_assessment');
        $this->load->view('backend/index', $page_data);
    }

    function print_daily_report($employee_id = '', $student_id = '', $month_id = '', $month_plan_id) {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/print_daily_report';
        $page_data['page_title'] = $this->lang->line('print_daily_report');
        $page_data['employee_id'] = $employee_id;
        $page_data['student_id'] = $student_id;
        $page_data['month_id'] = $month_id;
        $page_data['month_plan_id'] = $month_plan_id;
        $this->load->view('backend/assessment/print_daily_report', $page_data);
    }

    function print_monthly_assessment($employee_id = '', $student_id = '', $month_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/print_monthly_assessment';
        $page_data['page_title'] = $this->lang->line('print_monthly_assessment');
        $page_data['employee_id'] = $employee_id;
        $page_data['student_id'] = $student_id;
        $page_data['month_id'] = $month_id;
        $this->load->view('backend/assessment/print_monthly_assessment', $page_data);
    }

    function student_attendance_summary() {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/student_attendance_summary';
        $page_data['page_title'] = $this->lang->line('student_attendance_summary');

        $this->load->view('backend/index', $page_data);
    }

    function manage_assessment($assessment_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'manage_assessment';
        $page_data['page_title'] = $this->lang->line('manage_assessment');
        $page_data['assessment_id'] = $assessment_id;

        $this->load->view('backend/index', $page_data);
    }

    function fetch_assessments() {
        $this->if_user_login();

        $jobTitle = $this->session->userdata('job_title_id');
        $userLevel = $this->db->get_where('job_title', array('job_title_id' => $jobTitle))->row()->level;

        $this->db->select('a.*, b.id AS disability_id, b.disability_name, COUNT(*) as count');
        $this->db->from('student_assessment a');
        $this->db->join('disability b', 'b.id = a.disability_id', 'left');
        //$this->db->where("a.active", 1);

        if ($userLevel == 1 || $userLevel == 2) {
            $this->db->join('assessment_step c', 'a.id = c.assessment_id', 'left');
            $this->db->where_in("c.specialty_id", [$jobTitle, 0]);
            $this->db->where("c.active", 1);
        }
        $this->db->where("a.active", 1);
        if ($this->session->userdata('login_type') != "technical_support") {
            $this->db->where("a.assessment_taheelweb", 0);
        }
        $this->db->having("count > 0");
        $this->db->group_by("a.id");
        $assessments = $this->db->get()->result_array();

        echo json_encode($assessments, JSON_UNESCAPED_UNICODE);
    }

    function fetch_assessment_data($assessment_id) {
        $this->if_user_login();

        $jobTitle = $this->session->userdata('job_title_id');
        $userLevel = $this->db->get_where('job_title', array('job_title_id' => $jobTitle))->row()->level;

        if ($userLevel == 1 || $userLevel == 2) {
            $this->db->select("a.*, COUNT(*) as count");
            $this->db->from("assessment_genre a");
            $this->db->join("assessment_step b", 'b.genre_id = a.id', 'left');
            $this->db->where("a.assessment_id", $assessment_id);
            $this->db->where("a.active", 1);
            $this->db->where_in("b.specialty_id", array(0, $jobTitle));
            $this->db->having("count > 0");
            $this->db->order_by("a.id");
            $this->db->group_by("a.id");
        } else {
            $this->db->select("a.*");
            $this->db->from("assessment_genre a");
            $this->db->where("a.assessment_id", $assessment_id);
            $this->db->where("a.active", 1);
            $this->db->order_by("a.id");
        }

        $assessment_genres = $this->db->get()->result_array();

        $this->db->select("a.*");
        $this->db->from("assessment_goal a");
        $this->db->join("assessment_genre b", "a.genre_id = b.id", "left");
        $this->db->where("a.assessment_id", $assessment_id);
        $this->db->where("b.active", 1);
        $this->db->where("a.active", 1);
        $this->db->order_by("a.id");
        $assessment_goals = $this->db->get()->result_array();

        $this->db->select("a.*");
        $this->db->from("assessment_step a");
        $this->db->join("assessment_goal b", "a.goal_id = b.id", "left");
        $this->db->where("a.assessment_id", $assessment_id);
        $this->db->where("b.active", 1);
        $this->db->where("a.active", 1);
        $this->db->where("a.private", 0);
        $this->db->order_by("a.id");
        $assessment_steps = $this->db->get()->result_array();

        $this->db->select("a.*");
        $this->db->from("assessment_analysis a");
        $this->db->join("assessment_step b", 'a.step_id = b.id', 'left');
        $this->db->where("a.assessment_id", $assessment_id);
        $this->db->where("a.active", 1);
        $this->db->where("b.active", 1);
        $this->db->where('a.student_id IS NULL');
        $this->db->order_by("a.id");

        $assessment_analysis = $this->db->get()->result_array();

        $this->db->select("a.*")
                ->from("step_material a")
                ->where("a.assessment_id", $assessment_id)
                ->where("a.active", 1);

        $assessment_material = $this->db->get()->result_array();

        $results = array();
        $results["genres"] = $assessment_genres;
        $results["goals"] = $assessment_goals;
        $results["data"] = $assessment_steps;
        $results["analysis"] = $assessment_analysis;
        $results['material'] = $assessment_material;

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetchAssessmentIdForSpecialist($user_id, $student_id) {
        $this->if_user_login();

        $jobTitle = $this->db->get_where('employee', array('employee_id' => $user_id))->row()->job_title_id;
        $userLevel = $this->db->get_where('job_title', array('job_title_id' => $jobTitle))->row()->level;
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select('a.id, COUNT(*) as count');
        $this->db->from('student_assessment a');
        $this->db->join('disability b', 'b.id = a.disability_id', 'left');
        //$this->db->where("a.active", 1);

        if ($userLevel == 1 || $userLevel == 2) {
            $this->db->join('assessment_step c', 'a.id = c.assessment_id', 'left');
            $this->db->where_in("c.specialty_id", [$jobTitle, 0]);
            $this->db->where("c.active", 1);
        }
        $this->db->where("a.active", 1);
        $this->db->having("count > 0");
        $this->db->group_by("a.id");

        $results = $this->db->get()->result_array();

        $ids = array();

        foreach ($results AS $result) {
            array_push($ids, $result['id']);
        }

        $plans = $this->db->select('a.id')
                ->from('student_plan a')
                ->join('assessment_case b', 'b.id = a.assessment_case_id', 'left')
                ->join('student_assessment c', 'c.id = b.assessment_id', 'left')
                ->where_in('c.id', $ids)
                ->where('a.student_id', $student_id)
                ->where('a.running_year', $year)
                ->where('a.active', 1)
                ->get()
                ->result_array();

        //echo $this->db->last_query() . '<br/>';
        //print_r($plans) . '<br/>';
        //echo $plans[0]['id'];
        if (count($plans) == 1) {
            return $plans[0]['id'];
        } else {
            return -1;
        }
    }

    function post_assessment() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $assessment = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        if ($assessment['id'] == NULL) {

            //disability_level_id
            if ($assessment['disability_id'] == NULL) {
                $assessment['disability_id'] = 0;
            }

            if ($assessment['allow_use'] == NULL || $assessment['allow_use'] == 0) {
                $assessment['allow_use'] = 0;
            }

            $assessment["datetime_stamp"] = date('Y-m-d H:i:s');
            $this->db->insert('student_assessment', $assessment);
        } else {

            if ($assessment['disability_id'] == NULL) {
                $assessment['disability_id'] = 0;
            }

            if ($assessment['allow_use'] == NULL || $assessment['allow_use'] == 0) {
                $assessment['allow_use'] = 0;
            }

            $this->db->where("id", $assessment['id']);
            $this->db->update('student_assessment', $assessment);
        }

        echo json_encode($assessment, JSON_UNESCAPED_UNICODE);
    }

    function post_genre() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();
        $inputJSON = file_get_contents('php://input');
        $genre = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        if ($genre['id'] == NULL) {
            $this->db->insert('assessment_genre', $genre);
            $genre['id'] = $this->db->insert_id();
        } else {
            $this->db->where("id", $genre['id']);
            $this->db->update('assessment_genre', $genre);
        }
        echo json_encode($genre, JSON_UNESCAPED_UNICODE);
    }

    function post_goal() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $goal = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        if ($goal['id'] == NULL) {
            $this->db->insert('assessment_goal', $goal);
            $goal['id'] = $this->db->insert_id();
        } else {
            $this->db->where("id", $goal['id']);
            $this->db->update('assessment_goal', $goal);
        }
        echo json_encode($goal, JSON_UNESCAPED_UNICODE);
    }

    function post_step() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $step = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        if ($step['id'] == NULL) {
            $this->db->insert('assessment_step', $step);
            $step['id'] = $this->db->insert_id();
        } else {
            $this->db->where("id", $step['id']);
            $this->db->update('assessment_step', $step);
        }

        $this->db->where('id', $step['id']);
        $newStep = $this->db->get('assessment_step')->result_array()[0];

        echo json_encode($newStep, JSON_UNESCAPED_UNICODE);
    }

    function post_lesson_prep_ebaa() {
        $this->if_user_login();

        $errors = [];
        $data = [];

        if (empty($_POST['lesson_prep_ebaa'])) {
            $errors['lesson_prep_ebaa'] = 'Name is required.';
        }

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $data_lesson['lesson_prep'] = $this->input->post('lesson_prep_ebaa');

            $this->db->where("id", $_POST['step_id_ebaa']);
            $this->db->update('assessment_step', $data_lesson);

            $data['success'] = true;
            $data['message'] = 'Success!';
        }

        //echo json_encode($data);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        //$this->db->where("id", $step['step_id']);
        //$this->db->update('assessment_step', $data);
        //$this->db->where('id', $step['step_id']);
        //$newStep = $this->db->get('assessment_step')->result_array()[0];
        //echo json_encode($newStep, JSON_UNESCAPED_UNICODE);
    }

    function post_lesson_prep() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $step = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $data = array(
            'lesson_prep' => $step['lesson_prep']
        );
        $this->db->where("id", $step['step_id']);
        $this->db->update('assessment_step', $data);

        $this->db->where('id', $step['step_id']);
        $newStep = $this->db->get('assessment_step')->result_array()[0];

        echo json_encode($newStep, JSON_UNESCAPED_UNICODE);
    }

    function post_analysis() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();
        $inputJSON = file_get_contents('php://input');
        $analysis = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        if ($analysis['id'] == NULL) {
            $this->db->insert('assessment_analysis', $analysis);
            $analysis['id'] = $this->db->insert_id();
        } else {
            $this->db->where("id", $analysis['id']);
            $this->db->update('assessment_analysis', $analysis);
        }

        $this->db->where('id', $analysis['id']);
        $newAnalysis = $this->db->get('assessment_analysis')->result_array()[0];

        echo json_encode($newAnalysis, JSON_UNESCAPED_UNICODE);
    }

    function delete_goal() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $goal = array();
        $goal["active"] = '0';

        $goalData = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $this->db->where("id", $goalData['goal_id']);
        $this->db->where("assessment_id", $goalData['assessment_id']);
        $this->db->update('assessment_goal', $goal);

        $this->db->where("goal_id", $goalData['goal_id']);
        $this->db->where("assessment_id", $goalData['assessment_id']);
        $this->db->update('assessment_step', $goal);

        echo json_encode($goalData, JSON_UNESCAPED_UNICODE);
    }

    function delete_genre() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $data = array();
        $data["active"] = '0';

        $genreData = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $this->db->where("id", $genreData['genre_id']);
        $this->db->where("assessment_id", $genreData['assessment_id']);
        $this->db->update('assessment_genre', $data);

        $this->db->where("genre_id", $genreData['genre_id']);
        $this->db->where("assessment_id", $genreData['assessment_id']);
        $this->db->update('assessment_goal', $data);

        $this->db->where("genre_id", $genreData['genre_id']);
        $this->db->where("assessment_id", $genreData['assessment_id']);
        $this->db->update('assessment_step', $data);

        echo json_encode($genreData, JSON_UNESCAPED_UNICODE);
    }

    function delete_step() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $step = array();
        $step["active"] = '0';

        $stepData = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $this->db->where("id", $stepData['id']);
        $this->db->update('assessment_step', $step);

        echo json_encode($stepData, JSON_UNESCAPED_UNICODE);
    }

    function delete_analysis() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $analysis = array();
        $analysis["active"] = '0';

        $analysisData = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $this->db->where("id", $analysisData['id']);
        $this->db->update('assessment_analysis', $analysis);

        echo json_encode($analysisData, JSON_UNESCAPED_UNICODE);
    }

    function post_assessment_genre($assessmentId) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $assessment_genres = json_decode($inputJSON, TRUE);
        $this->db->insert_batch('assessment_genre', $assessment_genres);

        $this->db->select("a.id AS 'value', a.genre_name AS 'key'");
        $this->db->from("assessment_genre a");
        $this->db->where("assessment_id", $assessmentId);
        $this->db->order_by("id");
        $assessment_results = $this->db->get()->result_array();

        echo json_encode($assessment_results, JSON_UNESCAPED_UNICODE);
    }

    function post_assessment_goal($assessmentId) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $assessment_goals = json_decode($inputJSON, TRUE);

        $this->db->insert_batch('assessment_goal', $assessment_goals);

        $this->db->select("a.id AS 'value', a.goal_name AS 'key'");
        $this->db->from("assessment_goal a");
        $this->db->where("assessment_id", $assessmentId);
        $this->db->order_by("id");
        $assessment_results = $this->db->get()->result_array();

        echo json_encode($assessment_results, JSON_UNESCAPED_UNICODE);
    }

    function post_assessment_step($assessmentId) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');

        $assessment_steps = json_decode($inputJSON, TRUE);
        $countBefore = $this->db->select("COUNT(*) as totalBefore")->from("assessment_step")->where("assessment_id", $assessmentId)->get()->result_array();
        foreach ($assessment_steps as $step) {
            $rawAnalysis = $step['analysis'];
            unset($step['analysis']);
            $this->db->insert('assessment_step', $step);
            $step_id = $this->db->insert_id();
            $analysis = array();
            foreach ($rawAnalysis as $ana) {
                $ana['step_id'] = $step_id;
                array_push($analysis, $ana);
            }
            if (!empty($analysis)) {
                $this->db->insert_batch('assessment_analysis', $analysis);
            }
        }
        //$this->db->insert_batch('assessment_step', $assessment_steps);
        /*
          $this->db->select("a.id AS 'value', a.step_name AS 'key'");
          $this->db->from("assessment_step a");
          $this->db->where("assessment_id", $assessmentId);
          $this->db->order_by("id");
          $assessment_results = $this->db->get()->result_array();
         */

        $countAfter = $this->db->select("COUNT(*) as totalBefore")->from("assessment_step")->where("assessment_id", $assessmentId)->get()->result_array();
        $data = array(
            "before" => $countBefore,
            "after" => $countAfter
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function post_private_step() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $step = json_decode($inputJSON, TRUE);
        $rawAnalysis = $step['analysis'];
        unset($step['analysis']);
        $step['private'] = 1;
        $this->db->insert('assessment_step', $step);

        $plan_step_id = $this->db->insert_id();

        $step_analysis = array();

        foreach ($rawAnalysis as $analysis) {
            array_push($step_analysis, array(
                'assessment_id' => $step['assessment_id'],
                'genre_id' => $step['genre_id'],
                'goal_id' => $step['goal_id'],
                'step_id' => $plan_step_id,
                'analysis_name' => $analysis['analysis_name']
            ));
        }

        $this->db->insert_batch('assessment_analysis', $step_analysis);

        $this->db->select("*");
        $this->db->from("assessment_step");
        $this->db->where('id', $plan_step_id);

        $stepResult = $this->db->get()->result_array();

        $this->db->select("*");
        $this->db->from("assessment_analysis");
        $this->db->where('step_id', $plan_step_id);

        $analysisResult = $this->db->get()->result_array();

        $results = array(
            'step' => $stepResult,
            'analysis' => $analysisResult
        );

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function delete_assessment() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $assessment = json_decode($inputJSON, TRUE);
        //echo $assessment['id'];
        $data = array();
        $data['active'] = '0';

        $this->db->where("id", $assessment['id']);
        $this->db->update('student_assessment', $data);

        $this->db->where("assessment_id", $assessment['id']);
        $this->db->update('assessment_genre', $data);

        $this->db->where("assessment_id", $assessment['id']);
        $this->db->update('assessment_goal', $data);

        $this->db->where("assessment_id", $assessment['id']);
        $this->db->update('assessment_step', $data);

        echo json_encode($assessment, JSON_UNESCAPED_UNICODE);
    }

    function fetch_disabilities() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $this->db->select('a.id, a.disability_name');
        $this->db->from('disability a');
        $this->db->where('active', 'Y');
        $disabilities = $this->db->get()->result_array();
        $all = array('id' => '0', 'disability_name' => $this->lang->line("all_disabilities"));
        array_unshift($disabilities, $all);
        echo json_encode($disabilities, JSON_UNESCAPED_UNICODE);
    }

    function fetch_genders() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $genders = array();
        array_push($genders, array('id' => 0, 'name' => $this->lang->line("any_gender")));
        array_push($genders, array('id' => 1, 'name' => $this->lang->line("male")));
        array_push($genders, array('id' => 2, 'name' => $this->lang->line("female")));

        echo json_encode($genders, JSON_UNESCAPED_UNICODE);
    }

    function manage_language_save($phrase_id) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $inputJSON = file_get_contents('php://input');
        $lang_update = json_decode($inputJSON, TRUE);

        $this->db->where("phrase_id", $phrase_id);
        $this->db->update('language', $lang_update);
        $lang_update["phrase_id"] = $phrase_id;

        //$CI = & get_instance();
        //$CI->cache->save($phrase, $word, 15 * 60 );


        echo json_encode($lang_update, JSON_UNESCAPED_UNICODE);
    }

    function manage_language_del($phrase_id) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $this->db->where("phrase_id", $phrase_id);
        $this->db->delete('language');
        $lang_update["phrase_id"] = $phrase_id;

        echo json_encode($lang_update, JSON_UNESCAPED_UNICODE);
    }

    function final_assessment($entry_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/final_assessment';
        $page_data['page_title'] = $this->lang->line('final_assessment');
        $page_data['entry_id'] = $entry_id;

        $this->load->view('backend/index', $page_data);
    }

    function final_summary($summary_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/final_summary';
        $page_data['page_title'] = $this->lang->line('final_summary');
        $page_data['summary_id'] = $summary_id;

        $this->load->view('backend/index', $page_data);
    }

    function fetch_student_steps($plan_id) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $this->db->select("plan_name");
        $this->db->from("student_plan");
        $this->db->where("id", $plan_id);

        $plan = $this->db->get()->result_array()[0];

        $this->db->select('a.id, b.id AS step_id, b.step_name as name, b.genre_id');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $steps = $this->db->get()->result_array();

        $this->db->distinct('b.genre_id');
        $this->db->select('b.genre_id AS id, c.genre_name as name');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->join('assessment_genre c', 'c.id = b.genre_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $genres = $this->db->get()->result_array();

        $this->db->select("b.analysis_name, b.step_id, b.id AS analysis_id");
        $this->db->from("student_plan_analysis a");
        $this->db->join("assessment_analysis b", "a.analysis_id = b.id", "left");
        $this->db->where("a.plan_id", $plan_id);

        $analysis = $this->db->get()->result_array();

        $results = array(
            'plan' => $plan,
            'steps' => $steps,
            'analysis' => $analysis,
            'genres' => $genres
        );

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetch_student_steps_final_assessment($plan_id) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $this->db->select("plan_name, student_id, id");
        $this->db->from("student_plan");
        $this->db->where("id", $plan_id);

        $plan = $this->db->get()->result_array()[0];

        $trained_steps = $this->db->
                select("a.step_id")->
                from("daily_report_steps a")->
                join("daily_report b", "a.daily_report_id = b.id")->
                where("b.report_day >= '2020-09-01'")->
                where("b.report_day <= '2020-12-31'")->
                where("a.student_id", $plan['student_id'])->
                group_by("1")->
                get()->
                result_array();

        $trained = array_column($trained_steps, 'step_id');
        //if()

        $this->db->select('a.id, b.id AS step_id, b.step_name as name, b.genre_id, b.standard_group_no');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $this->db->where_in('a.step_id', $trained);
        $steps = $this->db->get()->result_array();

        $this->db->distinct('b.genre_id');
        $this->db->select('b.genre_id AS id, c.genre_name as name');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->join('assessment_genre c', 'c.id = b.genre_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where_in('a.step_id', $trained);
        $this->db->where('a.active', 1);
        $genres = $this->db->get()->result_array();

        $this->db->select("b.analysis_name, b.step_id, b.id AS analysis_id");
        $this->db->from("student_plan_analysis a");
        $this->db->join("assessment_analysis b", "a.analysis_id = b.id", "left");
        $this->db->where("a.plan_id", $plan_id);

        $analysis = $this->db->get()->result_array();

        /*
          $trained = $this->db->
          select("a.step_id")->
          from("daily_report_steps a")->
          join("daily_report b", "a.daily_report_id = b.id")->
          where("b.report_day >= '2020-09-01'")->
          where("b.report_day <= '2020-12-31'")->
          where("a.student_id", $plan['student_id'])->
          group_by("1")->
          get()->
          result_array();
         */

        $results = array(
            'plan' => $plan,
            'steps' => $steps,
            'analysis' => $analysis,
            'genres' => $genres,
            'trained' => $trained
        );

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetch_student_steps_with_measure($plan_id) {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $this->db->select('a.id, b.step_name as name, b.step_measure AS measure, b.genre_id');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $steps = $this->db->get()->result_array();

        $this->db->distinct('b.genre_id');
        $this->db->select('b.genre_id AS id, c.genre_name as name');
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_step b', 'b.id = a.step_id', 'left');
        $this->db->join('assessment_genre c', 'c.id = b.genre_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $genres = $this->db->get()->result_array();

        $results = array('steps' => $steps, 'genres' => $genres);

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function place_report_plan() {
        $this->if_user_login();

        $inputJSON = file_get_contents('php://input');
        $rawData = json_decode($inputJSON, TRUE);
        $monthly_plan = $rawData['monthly_plan'];

        if (empty($rawData['id'])) {
            $assessment_id = $this->db->select("assessment_id")->from("student_plan")->where("id", $monthly_plan["plan_id"])->get()->result_array()[0];
            $monthly_plan["assessment_id"] = $assessment_id['assessment_id'];
            $monthly_plan["user_id"] = $this->session->userdata('login_user_id');
            $monthly_plan["datetime_stamp"] = date('Y-m-d H:i:s');
            $this->db->insert('report_plan', $monthly_plan);
            $monthly_plan_id = $this->db->insert_id();
        } else {
            $monthly_plan_id = $rawData['id'];
            $this->db->delete("report_plan_steps", array(
                'report_plan_id' => $monthly_plan_id
            ));
        }

        $rawSteps = $rawData['steps'];

        $steps = array();
        foreach ($rawSteps as $step) {
            $newStep = array();
            $newStep["report_plan_id"] = $monthly_plan_id;
            $newStep["step_id"] = $step["step_id"];
            $newStep["response"] = $step["response"];
            array_push($steps, $newStep);
        }

        $this->db->insert_batch('report_plan_steps', $steps);

        $rawAnalysis = $rawData['analysis'];

        $iAnalysis = array();
        foreach ($rawAnalysis as $analysis) {
            $newAnalysis = array();
            $newAnalysis["report_plan_id"] = $monthly_plan_id;
            $newAnalysis["step_id"] = $analysis["step_id"];
            $newAnalysis["analysis_id"] = $analysis["analysis_id"];
            $newAnalysis["response"] = $analysis["response"];
            array_push($iAnalysis, $newAnalysis);
        }

        $this->db->insert_batch('report_plan_analysis', $iAnalysis);
        echo json_encode($monthly_plan_id, JSON_UNESCAPED_UNICODE);
    }

    function place_summary_plan() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();
        $plan_id = 1;

        $inputJSON = file_get_contents('php://input');
        $rawData = json_decode($inputJSON, TRUE);
        $monthly_plan = $rawData['monthly_plan'];

        if (empty($rawData['id'])) {
            $assessment_id = $this->db->select("assessment_id")->from("student_plan")->where("id", $monthly_plan["plan_id"])->get()->result_array()[0];
            $monthly_plan["assessment_id"] = $assessment_id['assessment_id'];
            $monthly_plan["user_id"] = $this->session->userdata('login_user_id');
            $monthly_plan["datetime_stamp"] = date('Y-m-d H:i:s');
            $this->db->insert('plan_summary', $monthly_plan);

            $monthly_plan_id = $this->db->insert_id();
        } else {
            $monthly_plan_id = $rawData['id'];
            $this->db->delete("plan_summary_steps", array(
                'plan_summary_id' => $rawData['id']
            ));
        }

        $rawSteps = $rawData['goals'];

        $steps = array();
        foreach ($rawSteps as $step) {
            $newStep = array();
            $newStep["plan_summary_id"] = $monthly_plan_id;
            $newStep["genre_id"] = $step["genreId"];
            $newStep["summary"] = $step["summary"];

            array_push($steps, $newStep);
        }
        $this->db->insert_batch('plan_summary_steps', $steps);

        echo json_encode($monthly_plan_id, JSON_UNESCAPED_UNICODE);
    }

    function sms() {
        $this->if_user_login();
        //include(getcwd () . "/application/models/includeSettings.php");
        //echo APPPATH;
        //require_once(APPPATH.'models/includeSettings.php');

        $mobile = $this->db->get_where('settings', array('type' => 'mobile'))->row()->description;
        $password = $this->db->get_where('settings', array('type' => 'password'))->row()->description;
        $sender = $this->db->get_where('settings', array('type' => 'sender'))->row()->description;

        $numbers = '966534046405';

        $msg = "Hello World! 2";

        $MsgID = rand(1, 99999);

        $timeSend = '';

        $dateSend = '';

        $deleteKey = 152485;

        $resultType = 1;

        //echo $message;
        //$content = sendSMS($mobile, $password, $numbers, $sender, $msg, $MsgID, $timeSend, $dateSend, $deleteKey, $resultType);
        //echo $content;
    }

    function student_sessions() {
        $this->if_user_login();

        $page_data['page_name'] = '../assessment/student_sessions';
        $page_data['page_title'] = $this->lang->line('student_sessions');

        $this->load->view('backend/index', $page_data);
    }

    function fetch_student_classes() {
        $this->if_user_login();

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);

        $employee_id = $data['employee_id'];
        $student_id = $data['student_id'];
        $day_id = $data['day_id'];

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $section_id = $this->db->get_where('enroll', array(
                    'year' => $year,
                    'student_id' => $student_id,
                    'status' => 1
                ))->row()->section_id;

        /*
          $this->db->select('a.*, b.name');
          $this->db->from('class_routine a');
          $this->db->join('subject b', 'a.subject_id = b.subject_id', 'left');
          $this->db->order_by("a.time_start", "asc");
          $this->db->where('a.day', $day_id);
          $this->db->where('a.section_id', $section_id);
          $this->db->where('a.year', $year);
         */

        $this->db->select('a.*, a.id AS class_routine_id, b.name');
        $this->db->from('section_schedule_subject a');
        $this->db->join('subject b', 'a.subject_id = b.subject_id', 'left');
        $this->db->join('section_schedule c', 'c.id = a.schedule_id', 'left');

        $this->db->where('a.day_id', $day_id);
        $this->db->where('c.section_id', $section_id);
        $this->db->where('c.year', $year);
        $this->db->where('a.active', 1);
        $this->db->order_by("a.start_time", "asc");

        $results = $this->db->get()->result_array();

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetch_session_students($user_id = '') {
        $this->if_user_login();

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $students = $data['students'];
        $monthId = $data['monthId'];
        $date = $data['date'];

        $monthId = $this->db->select("id")->
                        from("term")->
                        where("year", $year)->
                        where("class_id", $this->session->userdata('class_id'))->
                        where("start_date <= '" . $date . "'")->
                        where("end_date >= '" . $date . "'")->
                        get()->result_array()[0]['id'];
        //echo 'monht-id ' . $this->db->last_query();
        $out = array();

        if (empty($user_id)) {
            $user_id = $data['employeeId'];
        }

        if (empty($user_id)) {
            $user_id = $this->session->userdata("employee_id");
        }

        foreach ($students as $studentId) {

            $student = $this->db->get_where('student', array(
                        'student_id' => $studentId
                    ))->row();

            $name = $student->name;

            $monthlyPlan = $this->db->get_where('monthly_plan', array(
                        "active" => 1,
                        'student_id' => $studentId,
                        'plan_id' => $this->fetchAssessmentIdForSpecialist($user_id, $studentId),
                        'month_id' => $monthId,
                        'year' => $year
                    ))->row();
            //echo $this->db->last_query();
            //echo '<br/>';
            $monthlyPlanId = $monthlyPlan->id;
            $plan_id = $monthlyPlan->plan_id;

            if ($monthlyPlanId == NULL) {
                $monthlyPlanId = "-1";
            }
            $this->db->select("a.id, a.step_name, a.standard_group_no");
            $this->db->from("assessment_step a");
            //$this->db->join('student_plan_steps b', 'b.step_id = a.id', 'left');
            $this->db->join('monthly_plan_steps c', 'c.step_id = a.id', 'left');
            $this->db->where('c.monthly_plan_id', $monthlyPlanId);
            $this->db->where('c.active', 1);

            $rawSteps = $this->db->get()->result_array();

            $steps = array();

            foreach ($rawSteps as $step) {

                $this->db->select("a.id, a.step_id, a.analysis_name");
                $this->db->from("monthly_plan_analysis b");
                $this->db->join("assessment_analysis a", 'b.analysis_id = a.id', 'left');
                $this->db->where('b.monthly_plan_id', $monthlyPlanId);
                $this->db->where('a.step_id', $step['id']);

                $step['analysis'] = $this->db->get()->result_array();
                array_push($steps, $step);
            }
            array_push($out, array(
                'id' => $studentId,
                'name' => $name,
                'plan_id' => $plan_id,
                'monthlyPlanId' => $monthlyPlanId,
                'steps' => $steps
            ));
        }

        echo json_encode($out, JSON_UNESCAPED_UNICODE);
    }

    function plan_delete($plan_id) {
        $this->if_user_login();

        $data = array(
            'active' => 0
        );

        $this->db->where('id', $plan_id);
        $this->db->update('student_plan', $data);
    }

    function report_delete($report_id) {
        $this->if_user_login();

        $data = array(
            'active' => 0
        );

        $this->db->where('id', $report_id);
        $this->db->update('report_plan', $data);
    }

    function summary_delete($report_id) {
        $this->if_user_login();

        $data = array(
            'active' => 0
        );

        $this->db->where('id', $report_id);
        $this->db->update('plan_summary', $data);
    }

    function api_parent() {
        $this->if_user_login();

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);

        $this->db->select('1');
        $this->db->from('parent');
        $this->db->where('email', $data['email']);

        $exists = $this->db->get()->result_array();

        $result = array();
        if (empty($exists)) {
            $data['last_login'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('parent', $data);
            $id = $this->db->insert_id();
            $result['error'] = 0;
            $result['id'] = $id;
        } else {
            $result['error'] = 1;
            $result['message'] = $this->lang->line('email_exists');
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function api_fetch_employees($class_id = '') {
        $this->if_user_login();

        $this->db->select("employee_id AS id, name, job_title_id");
        $this->db->from("employee");
        $this->db->where("active", 1);
        $this->db->group_start();
        $this->db->where('class_id', $class_id);
        $this->db->or_where('class_id', 0);
        $this->db->group_end();
        $this->db->order_by(2);

        $employees = $this->db->get()->result_array();
        echo json_encode($employees, JSON_UNESCAPED_UNICODE);
    }

    function monthly_plan() {
        $this->if_user_login();
        $page_data['page_name'] = '../assessment/monthly_plan';
        $page_data['page_title'] = $this->lang->line('monthly_plan');
        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    function fetch_students_plans($level, $employee_id, $month_id, $section_id = '') {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $results = array();

        $job_title_id = $this->db->select("job_title_id")->from('employee')->where("employee_id", $employee_id)->get()->result_array()[0]['job_title_id'];

        if (!empty($section_id)) {
            if ($level == 1) {
                $job_title_id = 4;
            }
        }

        if ($job_title_id == 28) {
            $job_title_id = 4;
        }

        if ($level == 2) {
            $students = $this->db->select("a.student_id, b.name")->
                    from('students_to_specialists a')->
                    join("student b", 'a.student_id = b.student_id', 'left')->
                    join("enroll c", 'b.student_id = c.student_id', 'left')->
                    where(array('a.employee_id' => $employee_id, 'a.year' => $year, 'a.active' => 1, 'c.status' => 0, 'c.year' => $year, 'c.class_id' => $this->session->userdata('class_id')))->
                    get()->
                    result_array();
        } else {
            $this->db->select('a.name, a.student_id');
            $this->db->from('student a');
            $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
            $this->db->join('section c', 'b.section_id = c.section_id', 'left');
            $this->db->where('b.class_id', $this->session->userdata('class_id'));
            $this->db->where("b.year", $year);

            if (empty($section_id)) {
                $this->db->group_start();
                $this->db->where('c.teacher_id', $employee_id);
                $this->db->or_where('c.teacher_id_2', $employee_id);
                $this->db->or_where('c.teacher_id_3', $employee_id);
                $this->db->or_where('c.teacher_id_4', $employee_id);
                $this->db->or_where('c.teacher_id_5', $employee_id);
                $this->db->or_where("c.assistant_teacher_id", $employee_id);
                $this->db->group_end();
            } else {
                $this->db->group_start();
                $this->db->where('c.section_id', $section_id);
                $this->db->group_end();
            }
            $this->db->where("b.status", 0);

            $students = $this->db->get()->result_array();
        }

        foreach ($students as $student) {
            $student_id = $student['student_id'];

            $plans_id = $this->db->
                            select("a.id, a.plan_name, a.assessment_id, b.assessment_name, COUNT(*) as count")->
                            from("student_plan a")->
                            join('assessment_step c', "a.assessment_id = c.assessment_id", "left")->
                            join('student_assessment b', "a.assessment_id = b.id", "left")->
                            where(array(
                                //'a.user_id' => $employee_id, 
                                'c.specialty_id' => $job_title_id,
                                'a.student_id' => $student_id,
                                'a.running_year' => $year,
                                'a.active' => '1'
                            ))->
                            group_by("1")->
                            having("count > 0")->
                            get()->result_array();

            if (empty($plans_id)) {
                $plans_id = array();
            } else {
                /*
                  $planEntry = $plan_id[0];
                  $plan_id = $planEntry['id'];
                  $assessment_id = $planEntry['assessment_id'];
                  $assessment_name = $planEntry['assessment_name'];
                 * */
            }
            $plans = array();
            foreach ($plans_id as $planEntry) {
                $plan_id = $planEntry['id'];
                $monthly_plan_id = -1;

                if ($plan_id != -1) {
                    $monthly_plan_id = $this->db->select("id")->from("monthly_plan")->where(array(
                                'plan_id' => $planEntry['id'],
                                'student_id' => $student_id,
                                'month_id' => $month_id,
                                'year' => $year
                            ))->get()->result_array();

                    if (empty($monthly_plan_id)) {
                        $monthly_plan_id = -1;
                    } else {
                        $monthly_plan_id = $monthly_plan_id[0]['id'];
                    }
                }

                $plan_info = array(
                    'plan_id' => $plan_id,
                    'plan_name' => $planEntry['plan_name'],
                    'assessment_id' => $planEntry['assessment_id'],
                    'student_id' => $student_id,
                    'assessment_name' => $planEntry['assessment_name'],
                    'month_plan_id' => $monthly_plan_id
                );

                array_push($plans, $plan_info);
            }


            $info = array(
                'student_id' => $student_id,
                //'entry' => $planEntry,
                'name' => $student['name'],
                'plans' => $plans
            );

            array_push($results, $info);
        }
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetch_students_plans_supervisor($section_id, $month_id, $employee_id = '') {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $results = array();

        if ($section_id == -1) {

            $job_title_id = $this->db->
                            select("job_title_id")->
                            from("employee")->
                            where("employee_id", $employee_id)->
                            get()->result_array()[0]['job_title_id'];

            $this->db->select("a.student_id, b.name")->
                    from('students_to_specialists a')->
                    join("student b", 'a.student_id = b.student_id', 'left')->
                    join("enroll c", 'b.student_id = c.student_id', 'left')->
                    where(array('a.employee_id' => $employee_id, 'a.year' => $year, 'a.active' => 1, 'c.status' => 0, 'c.year' => $year, 'c.class_id' => $this->session->userdata('class_id')));
        } else {
            $this->db->select('a.name, a.student_id, teacher_id');
            $this->db->from('student a');
            $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
            $this->db->join('section c', 'b.section_id = c.section_id', 'left');
            $this->db->where("b.year", $year);

            $this->db->group_start();
            $this->db->where('c.section_id', $section_id);
            $this->db->group_end();
            $this->db->where("b.status", 0);

            $job_title_id = 4;
        }

        $students = $this->db->get()->result_array();
        foreach ($students as $student) {
            $student_id = $student['student_id'];
            $plans_id = $this->db->
                            select("a.id, a.plan_name, a.assessment_id, b.assessment_name, COUNT(*) as count")->
                            from("student_plan a")->
                            join('assessment_step c', "a.assessment_id = c.assessment_id", "left")->
                            join('student_assessment b', "a.assessment_id = b.id", "left")->
                            where(array(
                                //'a.user_id' => $employee_id, 
                                'c.specialty_id' => $job_title_id,
                                'a.student_id' => $student_id,
                                'a.running_year' => $year,
                                'a.active' => '1'
                            ))->
                            group_by("1")->
                            having("count > 0")->
                            get()->result_array();

            if (empty($plans_id)) {
                $plans_id = array();
            } else {
                /*
                  $planEntry = $plan_id[0];
                  $plan_id = $planEntry['id'];
                  $assessment_id = $planEntry['assessment_id'];
                  $assessment_name = $planEntry['assessment_name'];
                 * */
            }
            $plans = array();
            foreach ($plans_id as $planEntry) {
                $plan_id = $planEntry['id'];
                $monthly_plan_id = -1;

                if ($plan_id != -1) {
                    $monthly_plan_id = $this->db->select("id")->from("monthly_plan")->where(array(
                                'plan_id' => $planEntry['id'],
                                'student_id' => $student_id,
                                'month_id' => $month_id,
                                'year' => $year
                            ))->get()->result_array();

                    if (empty($monthly_plan_id)) {
                        $monthly_plan_id = -1;
                    } else {
                        $monthly_plan_id = $monthly_plan_id[0]['id'];
                    }
                }

                $plan_info = array(
                    'plan_id' => $plan_id,
                    'plan_name' => $planEntry['plan_name'],
                    'assessment_id' => $planEntry['assessment_id'],
                    'student_id' => $student_id,
                    'assessment_name' => $planEntry['assessment_name'],
                    'month_plan_id' => $monthly_plan_id
                );

                array_push($plans, $plan_info);
            }


            $info = array(
                'student_id' => $student_id,
                //'entry' => $planEntry,
                'name' => $student['name'],
                'teacher_id' => $student['teacher_id'],
                'plans' => $plans
            );

            array_push($results, $info);
        }
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fixPlans() {
        $this->if_user_login();
        $this->db->select("a.student_id, b.id AS assessment_case_id, a.id AS student_plan_id, TIMESTAMPDIFF(MINUTE, a.datetime_stamp, b.datetime_stamp) AS diff");
        $this->db->from("student_plan a");
        $this->db->join("assessment_case b", "a.student_id = b.student_id AND a.assessment_id = b.assessment_id AND a.running_year = b.year", "left");
        $this->db->where("b.year", "2019-2020");
        $this->db->where("TIMESTAMPDIFF(MINUTE, a.datetime_stamp, b.datetime_stamp) < 1");
        $this->db->where("TIMESTAMPDIFF(MINUTE, a.datetime_stamp, b.datetime_stamp) >= 0");

        $results = $this->db->get()->result_array();

        foreach ($results as $result) {
            $query = "UPDATE student_plan SET assessment_case_id = " . $result['assessment_case_id'] . " WHERE id = " . $result['student_plan_id'] .
                    " AND student_id = " . $result['student_id'] . ";";
            echo $query . "<br/>";
        }
        //echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fix_students() {
        $this->if_user_login();
        $page_data['page_name'] = '../assessment/fix_students';
        $page_data['page_title'] = $this->lang->line('students');
        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    function import_employees() {
        $this->if_user_login();
        $page_data['page_name'] = '../assessment/import_employees';
        $page_data['page_title'] = $this->lang->line('import_employees');
        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    /**
      function import_students() {
      if ($this->session->userdata('user_login') != 1) {
      redirect(base_url(), 'refresh');
      return;
      }
      $page_data['page_name'] = '../assessment/import_students';
      $page_data['page_title'] = $this->lang->line('import_students');
      //$page_data['print_type'] = $type;

      $this->load->view('backend/index', $page_data);
      }
     */
    function invoice_num($input, $pad_len = 3, $prefix = null) {
        //$this->if_user_login();

        $prefix = "1";
        if ($pad_len <= strlen($input)) {
            $aaa = trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
        }
        if (is_string($prefix)) {
            $aaa = sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return $prefix . str_pad($input, $pad_len, "0", STR_PAD_LEFT);

        // Returns input with 7 zeros padded on the left
        //echo invoice_num(1); // Output: 0000001
        // Returns input with 10 zeros padded
        //echo invoice_num(1, 10); // Output: 0000000001
        // Returns input with prefixed F- along with 7 zeros padded
        //echo invoice_num(1, 7, "F-"); // Output: F-0000001
        // Returns input with prefixed F- along with 10 zeros padded
        //echo invoice_num(1, 10, "F-"); // Output: F-0000000001        
    }

    function import_data() {
        $this->if_user_login();
        $inputJSON = file_get_contents('php://input');
        $employees = json_decode($inputJSON, TRUE);

        //هذا الكود كان يحذف محتوى الجدول بالكامل
        $this->db->where("employee_id <> -1")->delete("employee");

        foreach ($employees as $employee) {

            $if_employee_code = $this->db->get_where('employee', array('employee_code' => $employee['code']))->num_rows();

            if ($if_employee_code > 0) {
                
            } else {

                if ($employee['identity_number'] != null || $employee['identity_number'] != "") {
                    $pass = $employee['identity_number'];
                } else {
                    $pass = bin2hex(random_bytes(2));
                }

                if ($employee['identity_type'] == 'identity') {
                    $nationality_id = '37';
                } else {
                    $pass = bin2hex(random_bytes(2));
                }

                $inputDate = $employee['date_of_hiring'];
                $date = strtotime($inputDate);
                $month = date('m', $date);  // الشهر بصيغة 2 رقم
                $day = date('d', $date);    // اليوم بصيغة 2 رقم
                $year = date('Y', $date);   // السنة
                $formattedDate = $month . '-' . $day . '-' . $year;

                $inputDate_birthday = $employee['birthday'];
                $date_birthday = strtotime($inputDate_birthday);
                $month_birthday = date('m', $date_birthday);  // الشهر بصيغة 2 رقم
                $day_birthday = date('d', $date_birthday);    // اليوم بصيغة 2 رقم
                $year_birthday = date('Y', $date_birthday);   // السنة
                $formattedDate_birthday = $year_birthday . '-' . $month_birthday . '-' . $day_birthday;

                $entry = array(
                    'employee_code' => $this->invoice_num($employee['code']),
                    'name' => $employee['name'],
                    'job_title_id' => $employee['job_title_id'],
                    'level' => $employee['level'],
                    'educational_level' => $employee['eduLookup'],
                    'specializing' => $employee['spe'],
                    'gender' => $employee['sex'],
                    'nationality_id' => $employee['0000000'],
                    'email' => $employee['email'],
                    'last_login' => date('Y-m-d H:i:s'),
                    'password' => sha1($pass),
                    'key_pass' => $pass,
                    'class_id' => $employee['class_id'],
                    'phone' => $employee['phone'],
                    'country_code' => '962',
                    'date_added' => date("Y-m-d H:i:s"),
                    'last_login' => date("Y-m-d H:i:s"),
                    'encrypt_thread' => bin2hex(random_bytes(24)),
                    'last_activity' => date("Y-m-d H:i:s"),
                    'date_of_hiring' => $formattedDate,
                    'expiry_date' => $employee['identity_ex'],
                    'no_identity' => $employee['identity_number'],
                    'identity_type' => $employee['identity_type'],
                    'type_birth' => 1,
                    'birthday' => $formattedDate_birthday,
                    'name_en' => $employee['name_en'],
                );

                $this->db->insert("employee", $entry);

                $employee_id = $this->db->insert_id();
                $entry_class = array(
                    'class_id' => '1',
                    'employee_id' => $employee_id,
                    'date' => date("Y-m-d H:i:s"),
                );
                $this->db->insert("employee_classes", $entry_class);
            }
        }
    }

    function user_audit() {
        $this->if_user_login();
        $page_data['page_name'] = '../assessment/user_audit';
        $page_data['page_title'] = $this->lang->line('user_audit');
        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    function post_employee_payroll() {
        $this->if_user_login();

        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);
        $data['datetime_stamp'] = date('Y-m-d H:i:s');
        if (empty($data['id'])) {
            $this->db->insert("payroll_employee", $data);
            $data['id'] = $this->db->insert_id();
        } else {
            $this->db->where("id", $data['id']);
            $this->db->update("payroll_employee", $data);
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function jitsi_meet() {
        $this->if_user_login();
        $page_data['page_name'] = '../assessment/jitsi_meet';
        $page_data['page_title'] = $this->lang->line('jitsi_meet');
        $this->load->view('backend/assessment/jitsi_meet', $page_data);
    }

    function fixStudentPlans() {
        $this->if_user_login();
        $this->db->simple_query('DELETE FROM student_plan_analysis');

        $results = $this->db->query("SELECT plan_id, step_id, step_progress AS analysis_progress, active FROM student_plan_steps WHERE step_id != 0 AND active = 1 GROUP BY 1, 2")->result_array();

        $con = 1;

        foreach ($results as $result) {

            //echo $con.'<br/>';
            echo $con . ' - ';

            $analysisGroup = $this->db->select('id AS analysis_id')->from("assessment_analysis")->where("step_id", $result['step_id'])->get()->result_array();

            $batch = array();
            foreach ($analysisGroup as $analysis) {

                $newAnalysis = array(
                    'analysis_id' => $analysis['analysis_id'],
                    'plan_id' => $result['plan_id'],
                    'step_id' => $result['step_id'],
                    'analysis_progress' => $result['analysis_progress'],
                    'active' => 1//$result['active']
                );
                array_push($batch, $newAnalysis);
            }

            $this->db->insert_batch('student_plan_analysis', $batch);
            $con++;
        }
        echo 'done';
    }

    function fixStudentMonthlyPlans() {
        $this->if_user_login();
        $results = $this->db->query("SELECT plan_id, step_id, step_progress, active FROM student_plan_steps WHERE step_id != 0 AND CONCAT(plan_id, '-', step_id) NOT IN (SELECT CONCAT(plan_id, '-', step_id) AS id FROM student_plan_analysis);")->result_array();

        foreach ($results as $result) {
            print_r($result);
            $analysisGroup = $this->db->select('*')->from("assessment_analysis")->where("step_id", $result['step_id'])->get()->result_array();
            foreach ($analysisGroup as $analysis) {
                echo "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                //print_r($analysis);
                //echo "<br/>";
                $query = "INSERT INTO student_plan_analysis (plan_id, step_id, analysis_id, active, analysis_progress) " .
                        "VALUES (" . $result['plan_id'] . ", " . $result['step_id'] . ", " . $analysis['id'] . ", " . $result['active'] . ", " . $result['step_progress'] . ")";

                echo $query . '<br/>';
                $this->db->query($query);

                $results_month = $this->db->select("a.monthly_plan_id, a.active")->
                                from("monthly_plan_steps a")->
                                join("monthly_plan b", "a.monthly_plan_id = b.id", "left")->
                                where("a.step_id", $result['step_id'])->
                                where("b.plan_id", $result['plan_id'])->
                                get()->result_array();

                if (empty($results_month)) {
                    continue;
                }

                foreach ($results_month as $result_month) {
                    $query_monthy = "INSERT INTO monthly_plan_analysis (monthly_plan_id, step_id, analysis_id, active) " .
                            "VALUES (" . $result_month['monthly_plan_id'] . ", " . $result['step_id'] . ", " . $analysis['id'] . ", " . $result_month['active'] . ")";

                    $this->db->query($query_monthy);
                    //echo $query_monthy . '<br/>';
                }
                //print_r($results_month);
            }
            //echo "<br/>";
        }
    }

    function modify_step_material($entry_id) {
        $this->if_user_login();
        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);

        $this->db->where('id', $entry_id);
        $this->db->update('step_material', $data);

        $material = $this->db
                        ->select('*')
                        ->from('step_material')
                        ->where('id', $entry_id)
                        ->get()->result_array()[0];

        echo json_encode($material, JSON_UNESCAPED_UNICODE);
    }

    function upload_step_material($assessment_id, $step_id) {
        $this->if_user_login();

        try {
            $result = Array();
            $filename = $_FILES['material']['name'];
            $info = new SplFileInfo($filename);
            //$uname = $step_id . '-' . $this->uuid();
            $uname = $step_id . '-' . bin2hex(random_bytes(12));
            //$folder = 'uploads/step_materials/' . $assessment_id . '/';
            $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/step_materials/' . $assessment_id . '/';
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            // Upload file
            $local = $folder . $uname . '.' . $info->getExtension();
            move_uploaded_file($_FILES['material']['tmp_name'], $local);
            $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
            $name = $uname . '.' . $info->getExtension();

            $entry = array(
                'assessment_id' => $assessment_id,
                'step_id' => $step_id,
                'material_name' => $uname . '.' . $info->getExtension(),
                'size' => $_FILES['material']['size'],
                'material_title' => $this->input->post("material_title"),
                'user_id' => $this->session->userdata('login_user_id'),
                'datetime_stamp' => date('Y-m-d H:i:s')
            );

            $this->db->insert('step_material', $entry);

            $id = $this->db->insert_id();
            $entry['active'] = 1;
            $entry['id'] = $id;

            echo json_encode($entry, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            throw new Error(e);
        }
    }

    function delete_step_material($material_id) {
        $this->if_user_login();

        $this->db->update('step_material', array('active' => 0), array('id' => $material_id));
    }

    function cleanUpDailyReport() {
        $this->if_user_login();

        $ids = $this->db
                ->query('SELECT MIN(a.id) AS daily_report_steps_id, MIN(a.daily_report_id) AS daily_report_id,  COUNT(*) AS total FROM daily_report_steps a LEFT JOIN daily_report b ON (a.daily_report_id = b.id) WHERE b.plan_id IS NOT NULL GROUP BY a.step_id, a.student_id, b.plan_id, b.report_day HAVING total > 1')
                ->result_array();

        print_r(array_column($ids, 'daily_report_steps_id'));

        $this->db->where_in("id", array_column($ids, 'daily_report_steps_id'));
        $this->db->delete("daily_report_steps");

        $this->db->where_in("id", array_column($ids, 'daily_report_id'));
        $this->db->delete("daily_report");
    }

    function print_assessment_from_mang($assessment_id) {
        $this->if_user_login();

        //$assessment_id = 77;    

        $this->db->select("d.assessment_name, c.genre_name, b.goal_name, b.level,  a.step_name, a.step_measure");
        $this->db->from('assessment_step a');
        $this->db->join("assessment_goal b", "a.goal_id = b.id", "left");
        $this->db->join("assessment_genre c", "a.genre_id = c.id", "left");
        $this->db->join("student_assessment d", "a.assessment_id = d.id", "left");
        $this->db->where("a.assessment_id", $assessment_id);
        $assessment_data = $this->db->get()->result_array();

        //echo '<pre>';
        //print_r($assessment_data);
        //echo '</pre>';

        $page_data['assessment_id'] = $assessment_id;
        $page_data['page_name'] = 'print_assessment_from_mang';
        $page_data['page_title'] = $this->lang->line('print_assessment');

        $myarray = json_encode($assessment_data, JSON_UNESCAPED_UNICODE);

        $page_data['data'] = $myarray;

        $this->load->view('backend/user/print_assessment_from_mang', $page_data);
    }

    function fetch_job_titles() {
        $this->if_user_login();
        //$ass = $this->db->get('student_assessment')->result_array();

        $levels = array(1, 2);
        $this->db->select('a.job_title_id AS id, a.name');
        $this->db->from('job_title a');
        $this->db->where_in('level', $levels);
        $jobs = $this->db->get()->result_array();
        $all = array('id' => '0', 'name' => $this->lang->line("all_specialties"));
        array_unshift($jobs, $all);
        echo json_encode($jobs, JSON_UNESCAPED_UNICODE);
    }
}

?>