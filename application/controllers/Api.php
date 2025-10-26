<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2019
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

require_once('Assessment.php');

class Api extends Assessment {

    function __construct() {
        parent::__construct();
    }

    function ping() {
        $userId = $this->session->userdata('login_user_id');

        if (empty($userId)) {
            return;
        }

        $technical_support = $this->session->userdata('technical_support_login');

        if (empty($technical_support)) {
            $this->db->select('a.name AS fullName, a.email AS username, a.employee_id AS userId, a.sex AS gender, a.specializing AS specialty, b.name AS job_name, b.name AS `role`');
            $this->db->from('employee a');
            $this->db->join('job_title b', 'a.job_title_id = b.job_title_id', 'left');
            $this->db->where('employee_id', $userId);
        } else {
            $this->db->select("name AS fullName, email AS username, technical_support_id AS userId, IFNULL(sex, 'male') AS gender, 'Software Engineer' AS specialty, 'Technical Support' AS job_name, 'technical_support' AS `role`");
            $this->db->from('technical_support');
            $this->db->where('technical_support_id', $userId);
        }


        $result = $this->db->get()->result_array()[0];

        $this->db->select('type, description');
        $this->db->from('user_permissions');
        $this->db->where('employee_id', $employee_id);
        $employee_permissions = $this->db->get()->result_array();

        $data = array(
            'profile' => $result,
            'permissions' => array(
                'role' => $employee_permissions
            )
        );
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function api_dashboard() {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select("COUNT(*) as count");
        $this->db->from("employee");
        $this->db->where("active", 1);
        $employeeCount = $this->db->get()->row()->count;

        $this->db->select("COUNT(*) as count");
        $this->db->from("enroll");
        $this->db->where("year", '2018-2019');
        $studentCount = $this->db->get()->row()->count;

        $limit = 4;
        $user_id_notic = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $show_to = array('fe', 'fa', 'fp', $user_id_notic);
        $this->db->select("notice_id, notice, DATE_FORMAT(FROM_UNIXTIME(create_timestamp), '%Y/%m/%d') AS date");
        $this->db->order_by("create_timestamp", "asc");
        $this->db->where('status', 1);
        $this->db->where_in('show_to', $show_to);
        $this->db->limit(4);
        $notices = $this->db->get('noticeboard')->result_array();

        $results = array(
            'ads' => $notices,
            'studentCount' => $studentCount,
            'employeeCount' => $employeeCount,
            'smsCount' => '2202',
            'dateOfSub' => '2019-08-01',
            'paymentSum' => '0'
        );

        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function students() {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select('a.student_id id, a.name studentName, a.sex gender, c.name className, e.name sectionName, a.birthday, d.disability_name, a.more_specific_type_disability');
        $this->db->from('student a');
        $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
        $this->db->join('section c', 'b.section_id = c.section_id', 'left');
        $this->db->join('class e', 'e.class_id = b.class_id', 'left');
        $this->db->join('disability d', 'd.id = a.disability_category', 'left');
        $this->db->where('b.year', '2018-2019');
        $this->db->order_by('2');

        $results = $this->db->get()->result_array();
        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function user_students() {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select('a.student_id id, a.name studentName, a.sex gender, c.name className, e.name sectionName, a.birthday, d.disability_name, a.more_specific_type_disability');
        $this->db->from('student a');
        $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
        $this->db->join('section c', 'b.section_id = c.section_id', 'left');
        $this->db->join('class e', 'e.class_id = b.class_id', 'left');
        $this->db->join('disability d', 'd.id = a.disability_category', 'left');
        $this->db->where('b.year', '2018-2019');
        $this->db->order_by('2');

        $results = $this->db->get()->result_array();
        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function employees() {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select('a.employee_id as id, a.name, a.sex AS gender, a.job_title_id, b.name job_name, e.name sectionName, a.educational_level, a.specializing');
        $this->db->from('employee a');
        $this->db->join('job_title b', 'a.job_title_id = b.job_title_id', 'left');
        $this->db->join('class e', 'e.class_id = a.class_id', 'left');
        $this->db->where('a.active', 1);
        $this->db->order_by('2');

        $results = $this->db->get()->result_array();
        $employees = array();
        foreach ($results as $employee) {
            $employee['education'] = $this->lang->line($employee['educational_level']);
            array_push($employees, $employee);
        }


        header('Content-Type: application/json');
        echo json_encode($employees, JSON_UNESCAPED_UNICODE);
    }

    function api_parents() {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->distinct("a.parent_id");
        $this->db->select('a.parent_id, a.name, b.name AS student_name, a.email, a.address, a.phone, a.another_phone, a.profession, f.name nationality');
        $this->db->from('parent a');
        $this->db->join('student b', 'b.parent_id = a.parent_id', 'left');
        $this->db->join('nationality f', 'f.nationality_id = a.nationality_id', 'left');
        $this->db->group_by("a.parent_id");
        $this->db->order_by('a.name');
        $parents = $this->db->get()->result_array();

        header('Content-Type: application/json');
        echo json_encode($parents, JSON_UNESCAPED_UNICODE);
    }

    function employee($employee_id) {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select('a.employee_id as id, a.name as employeeName, a.sex AS gender, a.job_title_id, b.name job_name, e.name sectionName, a.educational_level, a.specializing');
        $this->db->select('a.city, a.street, a.region, a.building_number, a.phone, a.email, a.date_of_hiring, a.birthday,  f.name nationality, a.emergency_telephone AS altPhone');
        $this->db->select('a.social_status, a.identity_type, a.no_identity ');
        $this->db->from('employee a');
        $this->db->join('job_title b', 'a.job_title_id = b.job_title_id', 'left');
        $this->db->join('nationality f', 'f.nationality_id = a.nationality_id', 'left');
        $this->db->join('class e', 'e.class_id = a.class_id', 'left');
        $this->db->where('a.active', 1);
        $this->db->where('a.employee_id', $employee_id);
        $this->db->order_by('2');

        $employee = $this->db->get()->result_array()[0];
        $employee['education'] = $this->lang->line($employee['educational_level']);
        $employee['genderText'] = $this->lang->line($employee['gender']);
        $employee['martialText'] = $this->lang->line($employee['social_status']);
        $employee['identity_typeText'] = $this->lang->line($employee['identity_type']);

        $this->db->select("class_id, status, delay_minutes, excuse, excuse, status_excuse, DATE_FORMAT(FROM_UNIXTIME(timestamp), '%Y-%m-%d') AS `date`");
        $this->db->from("attendance_employee");
        $this->db->where("employee_id", $employee_id);
        $this->db->where('year', '2018-2019');
        $this->db->where_in("status", array(2, 3));
        $this->db->order_by("timestamp DESC");

        $attendance = $this->db->get()->result_array();

        $data = array();

        $data['employee'] = $employee;
        $data['attendance'] = $attendance;

        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function student_info($student_id = '') {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select('a.student_id id, a.name studentName, a.sex gender, c.name className, a.birthday, d.disability_name, a.more_specific_type_disability');
        $this->db->select('b.class_id, b.section_id, a.identity_type, a.no_identity, a.student_code, a.city, a.street, a.region, a.address, a.building_number');
        $this->db->select("e.name sectionName, a.nationality_id, f.name nationality, a.parent_id");
        $this->db->from('student a');
        $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
        $this->db->join('section c', 'b.section_id = c.section_id', 'left');
        $this->db->join('class e', 'e.class_id = b.class_id', 'left');
        $this->db->join('disability d', 'd.id = a.disability_category', 'left');
        $this->db->join('nationality f', 'f.nationality_id = a.nationality_id', 'left');
        $this->db->where('b.year', $year);
        $this->db->where('b.student_id', $student_id);

        $student = $this->db->get()->result_array()[0];

        $transport = $this->db->get_where('subscribers_on_transport', array('student_id' => $student_id, 'year' => $year))->num_rows();
        if ($transport > 0) {
            $transport_status = $this->lang->line('joint');
        } else {
            $transport_status = $this->lang->line('it_is_not_a_member');
        }

        $student['genderText'] = $this->lang->line($student['gender']);
        $student['transportText'] = $transport_status;
        $student['identity_typeText'] = $this->lang->line($student['identity_type']);

        $this->db->select('a.parent_id, a.name, a.email, a.address, a.phone, a.another_phone, a.profession, f.name nationality');
        $this->db->from('parent a');
        $this->db->join('nationality f', 'f.nationality_id = a.nationality_id', 'left');
        $this->db->where('parent_id', $student['parent_id']);

        $parent = $this->db->get()->result_array()[0];

        $this->db->select("a.id, b.assessment_name, a.datetime_stamp, c.name");
        $this->db->from("assessment_case a");
        $this->db->join("student_assessment b", "a.assessment_id = b.id", 'left');
        $this->db->join("employee c", "a.user_id = c.employee_id", 'left');
        $this->db->where('a.student_id', $student_id);
        $this->db->where('a.active', 1);

        $assessments = $this->db->get()->result_array();

        $this->db->select("a.id, a.plan_name, a.datetime_stamp, c.name");
        $this->db->from("student_plan a");
        $this->db->join("employee c", "a.user_id = c.employee_id", 'left');
        $this->db->where('a.student_id', $student_id);
        $this->db->where('a.active', 1);

        $plans = $this->db->get()->result_array();

        $this->db->select("a.*, c.name");
        $this->db->from("student_behaviour a");
        $this->db->join("employee c", "a.user_id = c.employee_id", 'left');
        $this->db->where('a.student_id', $student_id);
        $behaviours = $this->db->get()->result_array();

        $data['student'] = $student;
        $data['parent'] = $parent;
        $data['assessments'] = $assessments;
        $data['plans'] = $plans;
        $data['behaviours'] = $behaviours;

        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function employee_info($employee_id = '') {
        if (empty($this->session->userdata('login_user_id')))
            return;
        $employee_id = 1;
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $data = array();

        $this->db->select('a.employee_id, a.name employee_name, a.');

        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function behaviour($behaviour_id) {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select("a.*, c.name");
        $this->db->from("student_behaviour a");
        $this->db->join("employee c", "a.user_id = c.employee_id", 'left');
        $this->db->where('a.id', $behaviour_id);
        $behaviour = $this->db->get()->result_array()[0];

        $this->db->select('*');
        $this->db->from('student_behaviour_reptitions');
        $this->db->where('behaviour_id', $behaviour_id);
        $this->db->where('active', 1);
        $this->db->order_by('date');

        $reptitions = $this->db->get()->result_array();

        $behaviour['reptitions'] = $reptitions;

        $student_id = $behaviour['student_id'];

        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $section_id = $this->db->get_where('enroll', array(
                    'student_id' => $student_id,
                    'year' => $running_year
                ))->row()->section_id;

        $class_id = $this->db->get_where('enroll', array(
                    'student_id' => $student_id,
                    'year' => $running_year
                ))->row()->class_id;

        $teacher_id = $this->db->get_where('section', array(
                    'section_id' => $section_id,
                        //'year' => $running_year
                ))->row()->teacher_id;

        $this->db->select('a.employee_id AS id, a.name');
        $this->db->from('employee a');
        $this->db->where("job_title_id", 15);
        $this->db->where('class_id', $class_id);
        $this->db->where("active", 1);
        $sych = $this->db->get()->result_array();

        $this->db->select('a.employee_id AS id, a.name');
        $this->db->from('employee a');
        $this->db->where('class_id', $class_id);
        $this->db->where("job_title_id", 2);
        $this->db->where("active", 1);
        $section = $this->db->get()->result_array();

        $this->db->select('a.employee_id AS id, a.name');
        $this->db->from('employee a');
        //$this->db->where("job_title_id", 4);
        $this->db->where('employee_id', $teacher_id);
        $this->db->where("active", 1);
        $teacher = $this->db->get()->result_array();

        $this->db->select('a.employee_id AS id, a.name');
        $this->db->from('employee a');
        $this->db->where('class_id', $class_id);
        $this->db->where("job_title_id", 3);
        $this->db->where("active", 1);
        $supervisor = $this->db->get()->result_array();

        $team = array();
        $team['manager'] = $section[0];
        $team['sych'] = $sych[0];
        $team['teacher'] = $teacher[0];
        $team['supervisor'] = $supervisor[0];

        $behaviour['team'] = $team;
        echo json_encode($behaviour, JSON_UNESCAPED_UNICODE);
    }

    function api_student_plan($plan_id) {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->select('*');
        $this->db->from('student_plan');
        $this->db->where('id', $plan_id);

        //$plan = $this->db->get()->result_array();
        $plan = $this->db->get()->result_array()[0];

        $assessment_id = $plan['assessment_id'];

        $this->db->select("e.analysis_name, b.step_name, c.genre_name, d.goal_name, e.id as analysis_id, b.id step_id , c.id goal_id, d.id genre_id");
        $this->db->from('student_plan_steps a');
        $this->db->join('assessment_analysis e', 'e.step_id = a.step_id', 'left');
        $this->db->join('assessment_step b', 'a.step_id = b.id', 'left');
        $this->db->join('assessment_genre c', 'b.genre_id = c.id', 'left');
        $this->db->join('assessment_goal d', 'd.id = b.goal_id', 'left');
        $this->db->where('a.plan_id', $plan_id);
        $this->db->where('a.active', 1);
        $this->db->order_by('8, 7');
        $steps = $this->db->get()->result_array();

        $data = array(
            'steps' => $steps,
            'plan' => $plan
        );
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function api_student_assessment($assessment_case_id) {

        if (empty($this->session->userdata('login_user_id')))
            return;

        $this->db->distinct('a.id');
        $this->db->select("a.step_measure AS step_name, a.id AS step_id, a.genre_id, c.genre_name, a.goal_id, d.goal_name");
        $this->db->from('assessment_mastered b');
        $this->db->join('assessment_step a', 'a.id = b.step_id', 'left');
        $this->db->join('assessment_goal d', 'd.id = a.goal_id', 'left');
        $this->db->join('assessment_genre c', 'c.id = a.genre_id', 'left');
        $this->db->where("a.active", 1);
        $this->db->where("b.assessment_case_id", $assessment_case_id);
        $this->db->order_by('2, a.id');
        $steps = $this->db->get()->result_array();

        $data = array(
            'steps' => $steps,
                //'genres' => $genres
        );

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function assessment($assessment_id) {

        if (empty($this->session->userdata('login_user_id')))
            return;

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
        $this->db->where("a.assessment_id", $assessment_id);
        $this->db->where("a.active", 1);
        $this->db->order_by("a.id");

        $assessment_analysis = $this->db->get()->result_array();
        $results = array();
        $results["genres"] = $assessment_genres;
        $results["goals"] = $assessment_goals;
        $results["data"] = $assessment_steps;
        //$results["analysis"] = $assessment_analysis;

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function fetch_student_attendance_summary() {

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        // 2019-2020 

        $inputJSON = file_get_contents('php://input');
        $filter = json_decode($inputJSON, TRUE); //convert JSON into array

        $this->db->select("c.name, a.student_id, COUNT(*) AS absence, b.status");

        $this->db->from("attendance a");
        $this->db->join("enroll b", "b.student_id = a.student_id", 'left');
        $this->db->join("student c", "c.student_id = a.student_id", 'left');

        $this->db->where("MONTH(FROM_UNIXTIME(a.timestamp))", $filter['monthId']);
        $this->db->where("YEAR(FROM_UNIXTIME(a.timestamp))", $filter['yearId']);
        $this->db->where('a.class_id', $filter['classId']);
        $this->db->where("a.status", 2);
        $this->db->where("b.status", 0);
        $this->db->where("a.year", $year);
        $this->db->where("b.year", $year);
        $this->db->group_by("a.student_id");
        $this->db->order_by("c.name");
        $this->db->having("absence > 0");

        $results = $this->db->get()->result_array();

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function makeRecoverySQL() {
        // get the record          
        $this->db->select("class_id, section_id, subject_id, employee_id, time_start, time_end, time_start_min, time_end_min, day, cod_time_start, cod_time_end, active");
        $this->db->from("class_routine");
        $this->db->where('year', '2017-2018');
        $this->db->where('class_id', 2);

        $results = $this->db->get()->result_array();

        $table = 'class_routine';
        foreach ($results as $row) {
            $insertSQL = "INSERT INTO `" . $table . "` SET ";
            foreach ($row as $field => $value) {
                $insertSQL .= " `" . $field . "` = '" . $value . "', ";
            }
            $insertSQL .= " `year` = '2018-2019'";
            echo $insertSQL . ';<br/>';
        }
    }

}
