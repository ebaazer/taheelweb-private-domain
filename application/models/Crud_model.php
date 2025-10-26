<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_version() {
        $this->db->select("*");
        $this->db->from("git_log");
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        return $result = $query->row();
    }

    public function git_log() {

        exec('git log', $result);
        $new_result = array();
        $j = -1;
        for ($i = 0; $i < count($result); $i++) {
            if (strpos($result[$i], 'commit') !== false) {
                $new_result[++$j]['commit'] = substr($result[$i], strlen('commit'));
            } else if (strpos($result[$i], 'Author:') !== false) {
                $new_result[$j]['author'] = substr($result[$i], strlen('Author:'));
            } else if (strpos($result[$i], 'Date:') !== false) {
                $new_result[$j]['date'] = substr($result[$i], strlen('Date:'));
            } else if (!empty($result[$i])) {
                $new_result[$j]['message'] = trim($result[$i]);
            }
        }

        $new_git_array = array();

        $count_array_git = count($new_result);

        $final_result = array_reverse($new_result);

        $count_loop = 1;

        foreach ($final_result as $new_result_row) {
            $git_array['number'] = $count_loop;
            $git_array['commit'] = $new_result_row['commit'];
            $git_array['author'] = $new_result_row['author'];
            $git_array['date'] = $new_result_row['date'];
            $git_array['message'] = $new_result_row['message'];

            $git_array['version'] = $this->loooooooop_num($count_loop);

            array_push($new_git_array, $git_array);

            $count_loop++;
        }

        $result = $this->db->get('git_log')->num_rows();
        $array_id = $this->db->select('id')->from('git_log')->get()->result_array();

        $new_result_id_db = array();

        foreach ($array_id as $array_id_row) {
            array_push($new_result_id_db, $array_id_row['id']);
        }

        if ($count_array_git > $result) {

            if ($array_id == null) {
                foreach ($new_git_array as $new_git_array_row) {
                    $data['commit'] = $new_git_array_row['commit'];
                    $data['author'] = $new_git_array_row['author'];
                    $data['date'] = $new_git_array_row['date'];
                    $data['message'] = $new_git_array_row['message'];
                    $data['version'] = $new_git_array_row['version'];
                    $data['timestamp'] = date("Y-m-d H:i:s");
                    $this->db->insert('git_log', $data);
                }
            } else {

                foreach ($new_git_array as $new_git_array_row) {
                    if (in_array($new_git_array_row['number'], $new_result_id_db)) {
                        
                    } else {
                        $data['commit'] = $new_git_array_row['commit'];
                        $data['author'] = $new_git_array_row['author'];
                        $data['date'] = $new_git_array_row['date'];
                        $data['message'] = $new_git_array_row['message'];
                        $data['version'] = $new_git_array_row['version'];
                        $data['timestamp'] = date("Y-m-d H:i:s");
                        $this->db->insert('git_log', $data);
                    }
                }
            }
        }
    }

    public function loooooooop_num($n1 = "") {

        $v_num = "4.";
        $version = "";

        $convert_array_git_to_array = str_split($n1);

        $count_convert_array = count($convert_array_git_to_array);

        $count_loop = 1;

        if ($n1 > 10000) {
            $version = $v_num . $convert_array_git_to_array[0] . $convert_array_git_to_array[1] . '.' . $convert_array_git_to_array[2] . $convert_array_git_to_array[3] . $convert_array_git_to_array[4];
        } elseif ($n1 > 1000) {
            $version = $v_num . $convert_array_git_to_array[0] . $convert_array_git_to_array[1] . '.' . $convert_array_git_to_array[2] . $convert_array_git_to_array[3];
        } else {
            $version = $v_num . $convert_array_git_to_array[0] . '.' . $convert_array_git_to_array[1] . $convert_array_git_to_array[2];
            /* `
              foreach ($convert_array_git_to_array as $row) {

              if ($count_loop == $count_convert_array) {
              $push_num = $row;
              } else {
              $push_num = $row . '.';
              }

              $version .= $push_num;

              $count_loop++;
              }
             */
        }

        return $version;
    }

    function get_type_name_by_id($type = '', $type_id = '', $field = 'name') {
        if ($type_id != null && $type_id != 0) {
            return $this->db->get_where($type, array($type . '_id' => $type_id))->row()->$field;
        }
    }

    function get_settings($type) {
        $des = $this->db->get_where('settings', array('type' => $type))->row()->description;
        return $des;
    }

    function get_students($class_id) {
        $query = $this->db->get_where('student', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_student_info($student_id) {
        $query = $this->db->get_where('student', array('student_id' => $student_id));
        return $query->result_array();
    }

    //student_encrypt_thread
    function get_student_info_by_encrypt_thread($student_id) {
        $query = $this->db->get_where('student', array('encrypt_thread' => $student_id));
        return $query->result_array();
    }

    function get_subjects() {
        $query = $this->db->get('subject');
        return $query->result_array();
    }

    function get_subject_info($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id));
        return $query->result_array();
    }

    function get_subjects_by_class($class_id) {
        $query = $this->db->get_where('subject', array('class_id' => $class_id));
        return $query->result_array();
    }

    function get_subject_name_by_id($subject_id) {
        $query = $this->db->get_where('subject', array('subject_id' => $subject_id))->row();
        return $query->name;
    }

    function get_class_name($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name'];
    }

    function get_class_name_numeric($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['name_numeric'];
    }

    function get_classes() {
        $query = $this->db->get('class');
        return $query->result_array();
    }

    function get_class_info($class_id) {
        $query = $this->db->get_where('class', array('class_id' => $class_id));
        return $query->result_array();
    }

    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    function get_system_settings() {
        $query = $this->db->get('settings');
        return $query->result_array();
    }

    function get_image_url($type = '', $id = '') {
        if (file_exists(APPPATH . '../uploads/' . $type . '_image/' . $id . '.jpg')) {
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        } else {
            if ($type == 'employee') {
                $employee_sex = $this->db->get_where('employee', array('employee_id' => $id))->row()->sex;
                if ($employee_sex == 'male') {
                    $image_url = base_url() . 'uploads/user_male.jpg';
                } elseif ($employee_sex == 'female') {
                    $image_url = base_url() . 'uploads/user_female.jpg';
                } else {
                    $image_url = base_url() . 'uploads/user.jpg';
                }
            }
            if ($type == 'student') {
                $student_sex = $this->db->get_where('student', array('student_id' => $id))->row()->sex;
                if ($student_sex == 'male') {
                    $image_url = base_url() . 'uploads/student.jpg';
                } elseif ($student_sex == 'female') {
                    $image_url = base_url() . 'uploads/student_f.jpg';
                } else {
                    $image_url = base_url() . 'uploads/student.jpg';
                }
            }
        }
        return $image_url;
    }

    function send_new_mail_message() {

        $subject = $this->input->post('title_mail');
        $message = $this->input->post('mail');
        $timestamp = strtotime(date("Y-m-d H:i:s"));

//$reciever   = $this->input->post('to');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

//check if the thread between those 2 users exists, if not create new thread
//        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
//        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();
//check if file is attached or not
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
            $data_message['attached_file_name'] = $_FILES['attached_file_on_messaging']['name'];
        }

        /*
          if ($num1 == 0 && $num2 == 0) {
          $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
          $data_message_thread['message_thread_code'] = $message_thread_code;
          $data_message_thread['sender'] = $sender;
          $data_message_thread['reciever'] = $reciever;
          $this->db->insert('message_thread', $data_message_thread);
          }
          if ($num1 > 0)
          $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
          if ($num2 > 0)
          $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;
         */
        foreach ($this->input->post('to') as $id) {
//$data_message['mailbox_thread_code'] = $message_thread_code;
            $data_message['title_mail'] = $subject;
            $data_message['mail'] = $message;
            $data_message['reciever'] = $id;
            $data_message['sender'] = $sender;
            $data_message['timestamp'] = $timestamp;
            $this->db->insert('mailbox', $data_message);
        }


// notify email to email reciever
//$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
//return $message_thread_code;
    }

    function mark_thread_messages_read($message_thread_code) {
// mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function mark_mail_messages_read($mailbox_id) {
// mark read only the oponnent messages of this thread, not currently logged in user's sent messages
//$current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
//$this->db->where('sender !=', $current_user);
        $this->db->where('mailbox_id', $mailbox_id);
        $this->db->update('mailbox', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    function outgoing_student($student_id = '') {

        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        // outgoing student from students to specialists
        $students_to_specialists = $this->db->get_where('students_to_specialists', array('student_id' => $student_id, 'year' => $running_year));

        if ($students_to_specialists->num_rows() > 0) {
            $student_to_specialist = $students_to_specialists->result_array();
            foreach ($student_to_specialist as $row) {

                if ($row['student_id'] == $student_id) {
                    $data['active'] = '0';
                    $this->db->where('students_to_specialists_id', $row['students_to_specialists_id']);
                    $this->db->update('students_to_specialists', $data);
                }
            }
        }

        // outgoing student from subscribers on transport
        $subscribers_on_transport = $this->db->get_where('subscribers_on_transport', array('student_id' => $student_id, 'year' => $running_year, 'active' => 1));

        if ($subscribers_on_transport->num_rows() > 0) {
            $subscribers = $subscribers_on_transport->result_array();
            foreach ($subscribers as $row) {

                if ($row['student_id'] == $student_id) {
                    $data['active'] = '0';
                    $this->db->where('subscribers_on_transport_id', $row['subscribers_on_transport_id']);
                    $this->db->update('subscribers_on_transport', $data);
                }
            }

            //اضافة تاريخ الانسحاب الى جدول الانسحاب من النقل
            $data_withdrawal['student_id'] = $student_id;
            $data_withdrawal['type'] = 0;
            $data_withdrawal['date'] = date("d-m-Y");
            $this->db->insert('withdrawal_from_transport', $data_withdrawal);
        }

        $query = "UPDATE schedule_subject_student a LEFT JOIN schedule b ON a.schedule_id = b.id SET a.active = 0 WHERE b.year = '" . $running_year . "' AND a.student_id = " . $student_id;
        $this->db->query($query);

        // outgoing student from enroll
        $enroll_students = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year));

        if ($enroll_students->num_rows() > 0) {
            $enroll = $enroll_students->result_array();
            foreach ($enroll as $row) {

                if ($row['student_id'] == $student_id) {

                    //history_student_withdrawals
                    $data_student_withdrawals['student_id'] = $student_id;
                    $data_student_withdrawals['class_id'] = $row['class_id'];
                    $data_student_withdrawals['date'] = strtotime(date("Y-m-d H:i:s"));
                    $data_student_withdrawals['year'] = $row['year'];
                    $this->db->insert('history_student_withdrawals', $data_student_withdrawals);

                    $data_enroll['status'] = '0';
                    $this->db->where('enroll_id', $row['enroll_id']);
                    $this->db->update('enroll', $data_enroll);
                }
            }
        }
    }

    function delete_employee($employee_id) {
        
    }

    function getWorkdays($date1 = '', $date2 = '', $workSat = FALSE, $patron = NULL) {
        if (!defined('FRIDAY'))
            define('FRIDAY', 5);
        if (!defined('SATURDAY'))
            define('SATURDAY', 6);
        if (!defined('SATURDAY'))
            define('SUNDAY', 0);
// Array of all public festivities
        $publicHolidays = array('01-01');
// The Patron day (if any) is added to public festivities
        if ($patron) {
            $publicHolidays[] = $patron;
        }
        /*
         * Array of all Easter Mondays in the given interval
         */
        $yearStart = date('Y', strtotime($date1));
        $yearEnd = date('Y', strtotime($date2));
        for ($i = $yearStart; $i <= $yearEnd; $i++) {
            $easter = date('Y-m-d', easter_date($i));
            list($y, $m, $g) = explode("-", $easter);
            $monday = mktime(0, 0, 0, date($m), date($g) + 1, date($y));
            $easterMondays[] = $monday;
        }
        $start = strtotime($date1);
        $end = strtotime($date2);
        $workdays = 0;
        for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
            $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
//echo '<br>';
            $mmgg = date('m-d', $i);
//echo '<br>';
            if ($day == FRIDAY)
                $workdays++;
            if ($day == SATURDAY)
                $workdays++;
        }
//return intval($workdays);
        return intval($workdays);
    }

    function getWorkdays_2($date1, $date2, $workSat = FALSE, $patron = NULL) {
        if (!defined('SATURDAY'))
            define('SATURDAY', 6);
        if (!defined('SUNDAY'))
            define('SUNDAY', 0);
// Array of all public festivities
        $publicHolidays = array('01-01', '01-06', '04-25', '05-01', '06-02', '08-15', '11-01', '12-08', '12-25', '12-26');
// The Patron day (if any) is added to public festivities
        if ($patron) {
            $publicHolidays[] = $patron;
        }
        /*
         * Array of all Easter Mondays in the given interval
         */
        $yearStart = date('Y', strtotime($date1));
        $yearEnd = date('Y', strtotime($date2));
        for ($i = $yearStart; $i <= $yearEnd; $i++) {
            $easter = date('Y-m-d', easter_date($i));
            list($y, $m, $g) = explode("-", $easter);
            $monday = mktime(0, 0, 0, date($m), date($g) + 1, date($y));
            $easterMondays[] = $monday;
        }
        $start = strtotime($date1);
        $end = strtotime($date2);
        $workdays = 0;
        for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
            $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
            $mmgg = date('m-d', $i);
            if ($day != SUNDAY &&
                    !in_array($mmgg, $publicHolidays) &&
                    !in_array($i, $easterMondays) &&
                    !($day == SATURDAY && $workSat == FALSE)) {
                $workdays++;
            }
        }
        return intval($workdays);
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    function unset_array_menu($array) {
        foreach ($array as $i => $value) {
            unset($array[$i]['item']);
            unset($array[$i]['p_user_id']);
            unset($array[$i]['user_id']);
            unset($array[$i]['p_list_id']);
            unset($array[$i]['p_page_id']);
            unset($array[$i]['display']);
            unset($array[$i]['addition']);
            unset($array[$i]['edit']);
            unset($array[$i]['delete_p']);
            unset($array[$i]['print']);
        }
        return $array;
    }

    function save_department_info() {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
//$returned_array = null_checking($data);
        $this->db->insert('department', $data);

        $department_id = $this->db->insert_id();
        move_uploaded_file($_FILES['dept_icon']['tmp_name'], 'uploads/frontend/department_images/' . $department_id . '.png');
    }

    function select_department_info() {
        return $this->db->get('department')->result_array();
    }

    function update_department_info($department_id) {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('department_id', $department_id);
        $this->db->update('department', $returned_array);
        move_uploaded_file($_FILES['dept_icon']['tmp_name'], 'uploads/frontend/department_images/' . $department_id . '.png');
    }

    function delete_department_info($department_id) {
        if (file_exists(base_url('uploads/frontend/department_images/' . $department_id . '.png'))) {
            unlink(base_url('uploads/frontend/department_images/' . $department_id . '.png'));
        }
        $this->db->where('department_id', $department_id);
        $this->db->delete('department');
    }

    //****     ONLINE EXAM       ****//

    function create_online_exam() {
        
    }

    function update_online_exam() {

        $data['title'] = html_escape($this->input->post('exam_title'));
        $data['class_id'] = $this->input->post('class_id');
        $data['job_title_id'] = $this->input->post('job_title_id');
        $data['online_exam_type_id'] = $this->input->post('online_exam_type_id');

        $data['depiction'] = $this->input->post('depiction');

        //$data['minimum_percentage'] = html_escape($this->input->post('minimum_percentage'));
        //$data['instruction'] = html_escape($this->input->post('instruction'));
        //$data['duration'] = $this->input->post('duration') * 60;
        //$data['duration'] = strtotime(date('Y-m-d', $data['exam_date']) . ' ' . $data['time_end']) - strtotime(date('Y-m-d', $data['exam_date']) . ' ' . $data['time_start']);

        $this->db->where('online_exam_id', $this->input->post('online_exam_id'));
        $this->db->update('online_exam', $data);
    }

    // multiple_choice_question crud functions
    function add_multiple_choice_question_to_online_exam($online_exam_id) {
        
    }

    function update_multiple_choice_question($question_id) {
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            $this->session->set_flashdata('error_message', $this->lang->line('no_options_can_be_blank'));
            return;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                $this->session->set_flashdata('error_message', $this->lang->line('no_options_can_be_blank'));
                return;
            }
        }

        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = $this->input->post('correct_answers');
        }

        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['mark'] = html_escape($this->input->post('mark'));
        $data['number_of_options'] = html_escape($this->input->post('number_of_options'));
        $data['options'] = json_encode($this->input->post('options'), JSON_UNESCAPED_UNICODE);
        $data['correct_answers'] = json_encode($correct_answers, JSON_UNESCAPED_UNICODE);
        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_updated'));
    }

    // true false questions crud functions
    function add_true_false_question_to_online_exam($online_exam_id) {

        $online_exam_details = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();

        $data['online_exam_id'] = $online_exam_id;

        //$data['section_id'] = $online_exam_details['section_id'];
        //$data['online_exam_type_id'] = $online_exam_details['online_exam_type_id'];
        //$data['exam_category_id'] = $online_exam_details['exam_category_id'];

        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['type'] = 'true_false';
        $data['mark'] = html_escape($this->input->post('mark'));
        $data['correct_answers'] = html_escape($this->input->post('true_false_answer'));
        $this->db->insert('question_bank', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_added'));
    }

    function update_true_false_question($question_id) {
        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['mark'] = html_escape($this->input->post('mark'));
        $data['correct_answers'] = html_escape($this->input->post('true_false_answer'));

        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_updated'));
    }

    // fill in the blanks question portion
    function add_fill_in_the_blanks_question_to_online_exam($online_exam_id) {
        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
        $suitable_words = array();
        foreach ($suitable_words_array as $row) {
            array_push($suitable_words, strtolower($row));
        }
        $data['online_exam_id'] = $online_exam_id;
        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['type'] = 'fill_in_the_blanks';
        $data['mark'] = html_escape($this->input->post('mark'));
        $data['correct_answers'] = json_encode(array_map('trim', $suitable_words));
        $this->db->insert('question_bank', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_added'));
    }

    function update_fill_in_the_blanks_question($question_id) {
        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
        $suitable_words = array();
        foreach ($suitable_words_array as $row) {
            array_push($suitable_words, strtolower($row));
        }
        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['mark'] = html_escape($this->input->post('mark'));
        $data['correct_answers'] = json_encode(array_map('trim', $suitable_words));

        $this->db->where('question_bank_id', $question_id);
        $this->db->update('question_bank', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_updated'));
    }

    function delete_question_from_online_exam($question_id) {
        $this->db->where('question_bank_id', $question_id);
        $this->db->delete('question_bank');
    }

    function manage_online_exam_status($online_exam_id = "", $status = "") {
        $checker = array('online_exam_id' => $online_exam_id);
        $updater = array('status' => $status);

        $this->db->where($checker);
        $this->db->update('online_exam', $updater);
        $this->session->set_flashdata('flash_message', $this->lang->line('exam') . ' ' . $status);
    }

    function available_exams($employee_id) {
        $match = array('employee_id' => $employee_id);
        $this->db->order_by("exam_date", "dsc");
        $exams = $this->db->where($match)->get('online_exam_send')->result_array();
        return $exams;
    }

    function change_online_exam_status_to_attended_for_employee($exam_type, $online_exam_send_id = '', $online_exam_id = "") {

        if ($exam_type == 'free') {

            $inserted_array = array(
                'status' => 'attended',
                'online_exam_send_id' => $online_exam_send_id,
                'online_exam_id' => $online_exam_id,
                'employee_id' => $this->session->userdata('login_user_id'),
                'class_id' => $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id,
                'exam_started_timestamp' => strtotime("now")
            );
            $this->db->insert('online_exam_result', $inserted_array);
            $online_exam_result = $this->db->insert_id();
            return $online_exam_result;
        } else {
            $checker = array(
                'online_exam_send_id' => $online_exam_send_id,
                'online_exam_id' => $online_exam_id,
                'employee_id' => $this->session->userdata('login_user_id')
            );

            if ($this->db->get_where('online_exam_result', $checker)->num_rows() == 0) {
                $inserted_array = array(
                    'status' => 'attended',
                    'online_exam_send_id' => $online_exam_send_id,
                    'online_exam_id' => $online_exam_id,
                    'employee_id' => $this->session->userdata('login_user_id'),
                    'class_id' => $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id,
                    'exam_started_timestamp' => strtotime("now")
                );
                $this->db->insert('online_exam_result', $inserted_array);
            }
        }
    }

    function submit_online_exam_free($online_exam_send_id, $online_exam_id = "", $answer_script = "") {


        $checker = array(
            'online_exam_result_id' => $online_exam_send_id,
        );
        $updated_array = array(
            'status' => 'submitted',
            'answer_script' => $answer_script
        );

        $this->db->where($checker);
        $this->db->update('online_exam_result', $updated_array);

        $this->calculate_exam_mark_free($online_exam_send_id, $online_exam_id);
    }

    function submit_online_exam($online_exam_send_id, $online_exam_id = "", $answer_script = "") {

        $checker = array(
            'online_exam_send_id' => $online_exam_send_id,
            'online_exam_id' => $online_exam_id,
            'employee_id' => $this->session->userdata('login_user_id')
        );
        $updated_array = array(
            'status' => 'submitted',
            'answer_script' => $answer_script
        );

        $this->db->where($checker);
        $this->db->update('online_exam_result', $updated_array);

        $this->calculate_exam_mark($online_exam_send_id, $online_exam_id);
    }

    function calculate_exam_mark_free($online_exam_send_id, $online_exam_id) {


        $checker = array(
            'online_exam_result_id' => $online_exam_send_id,
        );

        $obtained_marks = 0;
        $online_exam_result = $this->db->get_where('online_exam_result', $checker);
        if ($online_exam_result->num_rows() == 0) {

            $data['obtained_mark'] = 0;
            $data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
        } else {
            $results = $online_exam_result->row_array();
            $answer_script = json_decode($results['answer_script'], true);
            foreach ($answer_script as $row) {

                if ($row['submitted_answer'] == $row['correct_answers']) {

                    $obtained_marks = $obtained_marks + $this->get_question_details_by_id($row['question_bank_id'], 'mark');
                }
            }
            $data['obtained_mark'] = $obtained_marks;
            $data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
        }
        $total_mark = $this->get_total_mark($online_exam_id);
        $query = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
        $minimum_percentage = $query['minimum_percentage'];

        $minumum_required_marks = ($total_mark * $minimum_percentage) / 100;
        if ($minumum_required_marks > $obtained_marks) {
            $data['result'] = 'fail';
        } else {
            $data['result'] = 'pass';
        }
        $this->db->where($checker);
        $this->db->update('online_exam_result', $data);
    }

    function calculate_exam_mark($online_exam_send_id, $online_exam_id) {


            $checker = array(
                'online_exam_send_id' => $online_exam_send_id,
                'online_exam_id' => $online_exam_id,
                'employee_id' => $this->session->userdata('login_user_id')
            );

            $obtained_marks = 0;
            $online_exam_result = $this->db->get_where('online_exam_result', $checker);
            if ($online_exam_result->num_rows() == 0) {

                $data['obtained_mark'] = 0;
                $data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
            } else {
                $results = $online_exam_result->row_array();
                $answer_script = json_decode($results['answer_script'], true);
                foreach ($answer_script as $row) {

                    if ($row['submitted_answer'] == $row['correct_answers']) {

                        $obtained_marks = $obtained_marks + $this->get_question_details_by_id($row['question_bank_id'], 'mark');
                    }
                }
                $data['obtained_mark'] = $obtained_marks;
                $data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
            }
            $total_mark = $this->get_total_mark($online_exam_id);
            $query = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
            $minimum_percentage = $query['minimum_percentage'];

            $minumum_required_marks = ($total_mark * $minimum_percentage) / 100;
            if ($minumum_required_marks > $obtained_marks) {
                $data['result'] = 'fail';
            } else {
                $data['result'] = 'pass';
            }
            $this->db->where($checker);
            $this->db->update('online_exam_result', $data);
        
    }

    function get_total_mark($online_exam_id) {
        $added_question_info = $this->db->get_where('question_bank', array('online_exam_id' => $online_exam_id))->result_array();
        $total_mark = 0;
        if (sizeof($added_question_info) > 0) {
            foreach ($added_question_info as $single_question) {
                $total_mark = $total_mark + $single_question['mark'];
            }
        }
        return $total_mark;
    }

    function get_question_details_by_id($question_bank_id, $column_name = "") {

        return $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row()->$column_name;
    }

    function check_availability_for_employee($online_exam_send_id, $online_exam_id) {

        $result = $this->db->get_where('online_exam_result', array('online_exam_send_id' => $online_exam_send_id, 'online_exam_id' => $online_exam_id, 'employee_id' => $this->session->userdata('login_user_id')))->row_array();

        return $result['status'];
    }

    function get_correct_answer($question_bank_id = "") {

        $question_details = $this->db->get_where('question_bank', array('question_bank_id' => $question_bank_id))->row_array();
        return $question_details['correct_answers'];
    }

    function get_online_exam_result($employee_id) {
        $match = array('employee_id' => $employee_id, 'status' => 'submitted');
        $exams = $this->db->where($match)->get('online_exam_result')->result_array();
        return $exams;
    }

    ////////private message//////
    function send_new_private_message() {
        $message = html_escape($this->input->post('message'));
        $timestamp = strtotime(date("Y-m-d H:i:s"));

        $reciever = $this->input->post('reciever');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        //check if file is attached or not
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
            $data_message['attached_file_name'] = $_FILES['attached_file_on_messaging']['name'];
        }

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
//        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message = html_escape($this->input->post('message'));
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        //check if file is attached or not
        if ($_FILES['attached_file_on_messaging']['name'] != "") {
            $data_message['attached_file_name'] = $_FILES['attached_file_on_messaging']['name'];
        }
        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }

    function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // multiple_choice_question crud functions
    function add_multiple_choice_question_to_poll($poll_id) {
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            $this->session->set_flashdata('error_message', $this->lang->line('no_options_can_be_blank'));
            return;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                $this->session->set_flashdata('error_message', $this->lang->line('no_options_can_be_blank'));
                return;
            }
        }
        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = $this->input->post('correct_answers');
        }
        $data['poll_manage_id'] = $poll_id;
        $data['question_title'] = html_escape($this->input->post('question_title'));
        //$data['mark'] = html_escape($this->input->post('mark'));
        $data['number_of_options'] = html_escape($this->input->post('number_of_options'));
        $data['type'] = 'multiple_choice';
        $data['options'] = json_encode($this->input->post('options'), JSON_UNESCAPED_UNICODE);
        //$data['correct_answers'] = json_encode($correct_answers, JSON_UNESCAPED_UNICODE);
        $this->db->insert('poll_items', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_added'));
    }

    function add_fill_in_the_blanks_question_to_poll($poll_id) {
        $suitable_words_array = explode(',', html_escape($this->input->post('suitable_words')));
        $suitable_words = array();
        foreach ($suitable_words_array as $row) {
            array_push($suitable_words, strtolower($row));
        }
        $data['poll_manage_id'] = $poll_id;
        $data['question_title'] = html_escape($this->input->post('question_title'));
        $data['type'] = 'fill_in_the_blanks';
        //$data['mark'] = html_escape($this->input->post('mark'));
        //$data['correct_answers'] = json_encode(array_map('trim', $suitable_words));
        $this->db->insert('poll_items', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('question_added'));
    }

    function submit_poll_data($poll_send_id, $poll_id = "", $answer_script = "", $answer_script_array = "", $poll_send_times_id = "") {

        $checker = array(
            'id' => $poll_send_id,
            'poll_id' => $poll_id,
            'user_id' => $this->session->userdata('login_user_id')
        );
        $updated_array = array(
            'submitted' => '1',
            'date_submitted' => date('Y-m-d H:i:s'),
            'answer_script' => $answer_script
        );

        $this->db->where($checker);
        $this->db->update('poll_send', $updated_array);

        //poll_answer_script

        foreach ($answer_script_array as $answer_script_array_row) {

            $answer_script_data['poll_send_id'] = $poll_send_id;
            $answer_script_data['poll_id'] = $poll_id;
            $answer_script_data['user_id'] = $this->session->userdata('login_user_id');
            $answer_script_data['user_type'] = $this->session->userdata('login_type');

            $answer_script_data['poll_items_id'] = $answer_script_array_row['poll_items_id'];
            $answer_script_data['answer_id'] = $answer_script_array_row['answer_id'];
            $answer_script_data['poll_send_times_id'] = $poll_send_times_id;
            $answer_script_data['item_type'] = $answer_script_array_row['item_type'];
            ;

            $this->db->insert('poll_answer_script', $answer_script_data);
        }

        //$this->calculate_poll_mark($poll_send_id, $poll_id);
    }

    function calculate_poll_mark($online_exam_send_id, $online_exam_id, $student_id = '') {

        $checker = array(
            'online_exam_send_id' => $online_exam_send_id,
            'online_exam_id' => $online_exam_id,
            'student_id' => $student_id
        );

        $obtained_marks = 0;
        $online_exam_result = $this->db->get_where('online_exam_result', $checker);
        if ($online_exam_result->num_rows() == 0) {

            $data['obtained_mark'] = 0;
            //$data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
        } else {
            $results = $online_exam_result->row_array();
            $answer_script = json_decode($results['answer_script'], true);
            foreach ($answer_script as $row) {

                if ($row['submitted_answer'] == $row['correct_answers']) {

                    $obtained_marks = $obtained_marks + $this->get_question_details_by_id($row['question_bank_id'], 'mark');
                }
            }
            $data['obtained_mark'] = $obtained_marks;
            //$data['class_id'] = $this->db->get_where('employee', array('employee_id' => $this->session->userdata('login_user_id')))->row()->class_id;
        }
        $total_mark = $this->get_total_mark($online_exam_id);
        $query = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id))->row_array();
        $minimum_percentage = $query['minimum_percentage'];

        $minumum_required_marks = ($total_mark * $minimum_percentage) / 100;
        if ($minumum_required_marks > $obtained_marks) {
            $data['result'] = 'fail';
        } else {
            $data['result'] = 'pass';
        }
        $this->db->where($checker);
        $this->db->update('online_exam_result', $data);
    }

    // Group messaging portion
    function create_group() {
        $data = array();
        $data['group_message_thread_code'] = $this->uuid(); //substr(md5(rand(100000000, 20000000000)), 0, 15);
        $data['created_timestamp'] = strtotime(date("Y-m-d H:i:s"));
        $data['group_name'] = html_escape($this->input->post('group_name'));

        if (!empty($_POST['user'])) {
            //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            array_push($_POST['user'], 'admin_2');
            $data['members'] = json_encode($_POST['user']);
        } else {
            $_POST['user'] = array();
            //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            array_push($_POST['user'], 'admin_2');
            $data['members'] = json_encode($_POST['user']);
        }
        $this->db->insert('group_message_thread', $data);
        redirect(site_url('user/group_message'), 'refresh');
    }

    // Group messaging portion
    function update_group($thread_code = "") {
        $data = array();
        $data['group_name'] = html_escape($this->input->post('group_name'));
        if (!empty($_POST['user'])) {
            //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            array_push($_POST['user'], 'admin_2');

            $data['members'] = json_encode(array_unique($_POST['user']));
        } else {
            $_POST['user'] = array();
            //array_push($_POST['user'], $this->session->userdata('login_type').'_'.$this->session->userdata('admin_id'));
            array_push($_POST['user'], 'admin_2');
            $data['members'] = json_encode(array_unique($_POST['user']));
        }
        $this->db->where('group_message_thread_code', $thread_code);
        $this->db->update('group_message_thread', $data);
        redirect(site_url('user/group_message'), 'refresh');
    }

    function get_all_data_users() {

        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select("a.name as value, a.email as email, ");
        $this->db->from("employee a");
        //$this->db->join("student b", "a.student_id = b.student_id", 'left');
        //$this->db->join("class c", "a.class_id = c.class_id", 'left');
        //$this->db->join("section d", "a.section_id = d.section_id", 'left');
        //$this->db->where("a.year", $running_year);

        if (!$superuser) {
            $this->db->where('a.class_id', $this->session->userdata('class_id'));
        }

        //$this->db->where('a.status', 0);
        //$this->db->order_by('b.student_id', 'DESC');
        //$this->db->order_by('b.name', 'ASC');

        $employee = $this->db->get()->result_array();

        $employee_json = json_encode($employee, JSON_UNESCAPED_UNICODE);

        //$by_field = "employee_id";
        //$employee = $this->array_json->array_json($employee_json, $by_field);

        echo $employee_json;
    }
}
