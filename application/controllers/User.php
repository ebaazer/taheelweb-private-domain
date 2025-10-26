<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      date		: 19/08/2017  
 *      MANAGE User
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

require_once('Api.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class User extends Api {

    function __construct() {
        parent::__construct();

        $this->output->enable_profiler($this->config->item('profiler'));

        log_message('debug', 'CI : MY_Controller class loaded');

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Barcode_model');
        $this->load->helper('language');
        $this->load->helper('file');

        $this->load->helper('directory');

        date_default_timezone_set('Asia/Riyadh');

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        /* language control */
        $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
        $site_lang = $this->session->userdata('site_lang');

        /* database control */
        $this->db2 = $this->load->database('operating_system', TRUE);
        $this->db3 = $this->load->database('curriculum_scale', TRUE);
        //$this->db4 = $this->load->database('8ayem', TRUE);

        include 'inc_language.php';
    }

    /*     * *default functin, redirects to login page if no user logged in yet** */

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

    /*  ---------------      USER DASHBOARD    ---------------    */

    function dashboard() {
        $this->if_user_login();

        $login_type = $this->session->userdata('login_type');
        $account_job_title = $this->session->userdata('job_title_id');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';

        //if ($superuser) {
        // Amendments to databases      
        $this->amendments_to_databases->amendments_to_databases();
        //End Amendments Database
        $if_download_size_students = $this->db->get_where('settings', array('type' => 'download_size_students'))->row()->description;
        if ($if_download_size_students == null) {
            $data_t['type'] = 'download_size_students';
            $data_t['description'] = '0';
            $this->db->insert('settings', $data_t);
        }

        $if_allowed_file_size = $this->db->get_where('settings', array('type' => 'allowed_file_size'))->row()->description;
        if ($if_allowed_file_size == null) {
            $data_a_s['type'] = 'allowed_file_size';
            $data_a_s['description'] = '0';
            $this->db->insert('settings', $data_a_s);
        }

        $if_country_center = $this->db->get_where('settings', array('type' => 'country_center'))->row()->description;
        if ($if_country_center == null) {
            $data_a_cc['type'] = 'country_center';
            $data_a_cc['description'] = 'jo';
            $this->db->insert('settings', $data_a_cc);
        }

        $if_country_center = $this->db->get_where('settings', array('type' => 'client_id'))->row()->description;
        if ($if_country_center == null) {
            $data_a_ccid['type'] = 'client_id';
            $data_a_ccid['description'] = $this->session->userdata('client_id');
            $this->db->insert('settings', $data_a_ccid);
        }

        $if_topbar_color = $this->db->get_where('frontend_settings', array('type' => 'topbar_color'))->row()->description;
        if ($if_topbar_color == null) {
            $data_topbar_color['type'] = 'topbar_color';
            $data_topbar_color['description'] = '#eb574c';
            $this->db->insert('frontend_settings', $data_topbar_color);
        }

        // التحقق من وجود إعداد "leatr_page_photo"
        $query_leatr_page_photo = $this->db->get_where('settings', array('type' => 'leatr_page_photo'));
        if ($query_leatr_page_photo->num_rows() == 0) {
            $data_leatr_page_photo = array(
                'type' => 'leatr_page_photo',
                'description' => null
            );
            $this->db->insert('settings', $data_leatr_page_photo);
        }

        // التحقق من وجود إعداد "record_follow_ups"
        $query_record_follow_ups = $this->db->get_where('settings', array('type' => 'record_follow_ups'));
        if ($query_record_follow_ups->num_rows() == 0) {
            $data_record_follow_ups = array(
                'type' => 'record_follow_ups',
                'description' => 1
            );
            $this->db->insert('settings', $data_record_follow_ups);
        }

        // قائمة الحقول الجديدة
        $fields = [
            'account',
            'iban',
            'branch',
            'bank_name'
        ];

        foreach ($fields as $field) {
            // التحقق من وجود الإعداد في الجدول
            $query = $this->db->get_where('settings', array('type' => $field));
            if ($query->num_rows() == 0) {
                $data = array(
                    'type' => $field,
                    'description' => null
                );
                $this->db->insert('settings', $data);
            }
        }

        // البيانات المطلوب إدراجها
        $step_standard_data = array(
            array('name' => '4', 'value' => '0.40', 'active' => '1', 'group_no' => '6', 'group_name' => 'ايبلز 4', 'abbr' => '4', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '3', 'value' => '0.30', 'active' => '1', 'group_no' => '6', 'group_name' => 'ايبلز 4', 'abbr' => '3', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '2', 'value' => '0.20', 'active' => '1', 'group_no' => '6', 'group_name' => 'ايبلز 4', 'abbr' => '2', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '1', 'value' => '0.10', 'active' => '1', 'group_no' => '6', 'group_name' => 'ايبلز 4', 'abbr' => '1', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '2', 'value' => '0.20', 'active' => '1', 'group_no' => '7', 'group_name' => 'ايبلز 2', 'abbr' => '2', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '1', 'value' => '0.10', 'active' => '1', 'group_no' => '7', 'group_name' => 'ايبلز 2', 'abbr' => '1', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => '1', 'value' => '0.10', 'active' => '1', 'group_no' => '8', 'group_name' => 'ايبلز 0', 'abbr' => '1', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => 'لا', 'value' => '0.00', 'active' => '1', 'group_no' => '8', 'group_name' => 'ايبلز 0', 'abbr' => 'لا', 'step_standard_taheelweb' => '0', 'color' => NULL),
            array('name' => 'نعم', 'value' => '0.10', 'active' => '1', 'group_no' => '8', 'group_name' => 'ايبلز 0', 'abbr' => 'نعم', 'step_standard_taheelweb' => '0', 'color' => NULL)
        );

        // التحقق من وجود القيم في قاعدة البيانات وإضافتها إذا لم تكن موجودة
        foreach ($step_standard_data as $data) {
            $query = $this->db->get_where('step_standard', array('name' => $data['name'], 'group_no' => $data['group_no']));
            if ($query->num_rows() == 0) {
                $this->db->insert('step_standard', $data);
            }
        }

        // بيانات النماذج والتقارير المطلوب إدراجها
        $forms_data = array(
            array('abbr' => 'plar', 'name' => 'استمارة التقييم المبدئي لمهارات ما قبل اللغة', 'publish' => '1', 'active' => '1'),
            array('abbr' => 'otar', 'name' => 'استمارة التقييم المبدئي للعلاج الوظيفي', 'publish' => '1', 'active' => '1'),
            array('abbr' => 'ptar', 'name' => 'استمارة التقييم المبدئي للعلاج الطبيعي', 'publish' => '1', 'active' => '1')
        );

        // التحقق من وجود كل نموذج قبل إدخاله
        foreach ($forms_data as $form) {
            $query = $this->db->get_where('forms_and_reports', array('abbr' => $form['abbr']));
            if ($query->num_rows() == 0) {
                $this->db->insert('forms_and_reports', $form);
            }
        }

        //}

        $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

        if ($c_name == 'taheelweb') {
            if (!$superuser) {
                $page_data['page_name'] = 'dashboard_user_taheelweb';
                $page_data['page_title'] = $this->lang->line('user_dashboard');
            } else {
                $page_data['page_name'] = 'dashboard';
                $page_data['page_title'] = $this->lang->line('user_dashboard');
            }
        } else {
            if ($login_type == 'parent') {
                $page_data['page_name'] = 'parents_dashboard';
                $page_data['page_title'] = $this->lang->line('user_dashboard');
            } else {
                $page_data['page_name'] = 'dashboard';
                $page_data['page_title'] = $this->lang->line('user_dashboard');
            }
        }

        //لتحديث واضافة القسم لجدول جلسات الاخصائي
        //يجبب حذف الكود بعد فترة لانه لا حاجة له
        $this->set_class_id_for_schedule_subject();
        $this->moved_drafts_to_deleted_panel();
        $this->delete_drafts_auto();

        $this->load->view('backend/index', $page_data);
    }

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

    function alphanumeric() {
        //$alphanumeric = md5(time());
        //$alphanumeric = bin2hex(random_bytes(20));
        //$alphanumeric = sha1(time());
        //$alphanumeric = md5(date("Y-m-d H:i:s"));
        $alphanumeric = bin2hex(random_bytes(24));
        return $alphanumeric;
    }

    function generate_password() {
        $alphanumeric = bin2hex(random_bytes(3));
        return $alphanumeric;
    }

    function uuid() {
        return sprintf(
                '%04x%04x%04x%04x%04x%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
        );
    }

    /*
      public function check_email() {

      $email = $_POST['email'];

      $checkAdmin = $this->db->get_where('admin', array('email' => $email))->num_rows();
      $checkEmployee = $this->db->get_where('employee', array('email' => $email))->num_rows();
      $checkParent = $this->db->get_where('parent', array('email' => $email))->num_rows();
      $checkTechnical = $this->db->get_where('technical_support', array('email' => $email))->num_rows();

      if ($checkAdmin > 0 || $checkEmployee > 0 || $checkParent > 0 || $checkTechnical > 0) {
      $isAvailable = false;
      } else {
      $isAvailable = true;
      }
      echo json_encode(array(
      'valid' => $isAvailable,
      ));
      }
     */

    public function check_email() {
        $this->if_user_login();
        $email = $this->input->post('email');
        $tables = ['admin', 'employee', 'parent', 'technical_support'];
        $isAvailable = true;

        foreach ($tables as $table) {
            if ($this->db->get_where($table, ['email' => $email])->num_rows() > 0) {
                $isAvailable = false;
                break; // التوقف عند العثور على البريد الإلكتروني في أي جدول
            }
        }

        echo json_encode(['valid' => $isAvailable]);
    }

    /*
      function check_phone() {

      $phone = $_POST['phone'];
      $old_phone = $_POST['old_phone'];

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

      echo json_encode(array(
      'valid' => $isAvailable,
      ));
      }
     */

    function check_phone() {
        $this->if_user_login();
        $phone = $this->input->post('phone');
        $old_phone = $this->input->post('old_phone');
        $tables = ['admin', 'employee', 'parent', 'technical_support'];
        $isAvailable = true;

        // تحقق إذا كان الرقم الجديد يطابق الرقم القديم
        if ($phone !== $old_phone) {
            foreach ($tables as $table) {
                if ($this->db->get_where($table, ['phone' => $phone])->num_rows() > 0) {
                    $isAvailable = false;
                    break; // التوقف عند العثور على الرقم في أي جدول
                }
            }
        }

        echo json_encode(['valid' => $isAvailable]);
    }

    function check_no_identity() {
        $this->if_user_login();
        $no_identity = $_POST['no_identity'];

        $checkEmployee = $this->db->get_where('employee', array('no_identity' => $no_identity))->num_rows();
        //$checkParent = $this->db->get_where('parent', array('no_identity' => $no_identity))->num_rows();
        $checkStudent = $this->db->get_where('student', array('no_identity' => $no_identity))->num_rows();

        if ($checkEmployee > 0 || $checkStudent > 0) {
            $isAvailable = false;
        } else {
            $isAvailable = true;
        }
        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

    function check_no_identity_e() {
        $this->if_user_login();
        $no_identity = $_POST['no_identity'];
        $no_identity_old = $_POST['no_identity_old'];

        if ($no_identity != "" || $no_identity != null) {
            $no_identity = $_POST['no_identity'];
            $no_identity_old = $_POST['no_identity_old'];

            $checkEmployee = $this->db->get_where('employee', array('no_identity' => $no_identity))->num_rows();
            //$checkParent = $this->db->get_where('parent', array('no_identity' => $no_identity))->num_rows();
            $checkStudent = $this->db->get_where('student', array('no_identity' => $no_identity))->num_rows();

            if ($checkEmployee > 0 || $checkStudent > 0) {
                if ($no_identity_old == $no_identity) {
                    echo $isAvailable = true;
                } else {
                    echo $isAvailable = false;
                }
            } else {
                echo $isAvailable = true;
            }
            //echo json_encode(array(
            //    'valid' => $isAvailable,
            //));
        } else {
            echo $isAvailable = true;
        }
    }

    function check_phone_edit() {
        $this->if_user_login();
        $phone = $_POST['phone'];

        $checkAdmin = $this->db->get_where('admin', array('phone' => $phone))->num_rows();
        $checkEmployee = $this->db->get_where('employee', array('phone' => $phone))->num_rows();
        $checkParent = $this->db->get_where('parent', array('phone' => $phone))->num_rows();
        $checkTechnical = $this->db->get_where('technical_support', array('phone' => $phone))->num_rows();

        //بحاجة اذا كان نفس الرقم اظهار انه نفس الرقم واعطاء استجابه انه صحيح
        if ($checkAdmin > 0 || $checkEmployee > 0 || $checkParent > 0 || $checkTechnical > 0) {
            echo $isAvailable = false;
        } else {
            echo $isAvailable = true;
        }
    }

    function check_name_parent_modal() {
        $this->if_user_login();
        if (isset($_POST['name'])) {
            $name = $_POST['name'];

            $old_name = $_POST['old_name'];

            $this->db->where('name', $name);
            $checkdata = $this->db->get('parent')->num_rows();

            if ($checkdata > 0) {
                if ($old_name == $name) {
                    $isAvailable = true;
                } else {
                    $isAvailable = false;
                }
            } else {
                $isAvailable = true;
            }
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

    function check_name_parent() {
        $this->if_user_login();
        if (isset($_POST['name_parent'])) {
            $name = $_POST['name_parent'];

            $this->db->where('name', $name);
            $checkdata = $this->db->get('parent')->num_rows();

            if ($checkdata > 0) {
                $isAvailable = false;
            } else {
                $isAvailable = true;
            }
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

    function change_user_picture($problemId = '') {
        $this->if_user_login();

        $user_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata('login_user_id');

        $img_url = 'assets/media/users/' . $_POST['img'];

        $data['user_img'] = $img_url;

        $this->db->where($user_type . '_id', $user_id);
        $this->db->update($user_type, $data);
    }

    /*     * ********************************************************* */

    /*  ---------------      Report problem    ---------------    */

    function myFunction() {
        if ($this->session->userdata('user_login') != 1) {
            redirect(base_url(), 'refresh');
            return;
        }
        echo $_POST['services'];
    }

    function view_report_problem() {
        $this->if_user_login();
        $page_data['page_name'] = 'view_report_problem';
        $page_data['page_title'] = $this->lang->line('view_report_problem');

        $this->load->view('backend/index', $page_data);
    }

    function report_problem() {
        $this->if_user_login();

        $data['where_the_problem_page'] = $_POST['where_the_problem_page'];
        $data['describe_problem'] = $_POST['describe_problem'];

        $data['user_type'] = $this->session->userdata('login_type');
        $data['user_id'] = $this->session->userdata('login_user_id');

        if ($this->session->userdata('login_type') == 'employee') {
            $data['class_id'] = $this->session->userdata('class_id');
        }

        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['date'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('report_problem', $data);
    }

    function delete_problem($problemId = '') {
        $this->if_user_login();
        $this->db->where('report_problem_id', $problemId);
        $this->db->delete('report_problem');
    }

    function status_problem($problemId = '') {
        $this->if_user_login();

        $problemId = $_POST['problemId'];
        $data['status'] = '1';

        $this->db->where('report_problem_id', $problemId);
        $this->db->update('report_problem', $data);
    }

    /*  ---------------      End Report problem    ---------------    */



    /*  ---------------     notes on employee    ---------------    */

    function type_of_notes_on_employee() {
        $this->if_user_login();

        $page_data['page_name'] = 'type_of_notes_on_employee';
        $page_data['page_title'] = $this->lang->line('type_of_notes_on_employee');

        $this->load->view('backend/index', $page_data);
    }

    function add_type_of_notes_on_employee() {
        $this->if_user_login();
        $data['name'] = $this->input->post('name');
        $this->db->insert('type_of_notes_on_employee', $data);

        $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
        redirect(site_url('user/type_of_notes_on_employee/'), 'refresh');
    }

    function edit_type_of_notes_on_employee($param1 = '') {
        $this->if_user_login();
        $data['name'] = $this->input->post('name');

        $this->db->where('type_of_notes_on_employee_id', $param1);
        $this->db->update('type_of_notes_on_employee', $data);

        $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
        redirect(site_url('user/type_of_notes_on_employee/'), 'refresh');
    }

    function delete_type_of_notes_on_employee($note_types_id = '') {
        $this->if_user_login();
        $data['active'] = 0;

        $this->db->where('type_of_notes_on_employee_id', $note_types_id);
        $this->db->update('type_of_notes_on_employee', $data);
    }

    function view_notes_on_employees_selector() {
        $this->if_user_login();
        $login_type = $this->session->userdata('login_type');
        if ($login_type == 'employee') {
            $page_data['inner_page'] = 'view_notes_on_employee';
            //$page_data['class_id'] = $class_id;

            $page_data['page_name'] = 'view_notes_on_employees_selector';
            //$page_data['class_id'] = $class_id;
            $page_data['page_title'] = $this->lang->line('view_notes_on_employees');

            redirect(site_url('user/view_notes_on_employee/' . $this->session->userdata('class_id')), 'refresh');
        } else {
            $page_data['page_name'] = 'view_notes_on_employees_selector';
            $page_data['page_title'] = $this->lang->line('view_notes_on_employees');

            $this->load->view('backend/index', $page_data);
        }
    }

    function view_notes_on_employee($class_id) {
        $this->if_user_login();

        if ($class_id != 0) {
            $page_data['inner_page'] = 'view_notes_on_employee';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'view_notes_on_employees_selector';
        $page_data['page_title'] = $this->lang->line('view_notes_on_employees');

        $this->load->view('backend/index', $page_data);
    }

    /*
      function add_new_notes_on_employees() {
      if ($this->session->userdata('user_login') != 1) {
      redirect(base_url(), 'refresh');
      return;
      }

      $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

      if ($this->input->post('notes_on_employees') != null) {

      //$data['notes_on_employees'] = implode(",", $this->input->post('job_title_id'));
      $notes_on_employees = $this->input->post('notes_on_employees');

      foreach ($notes_on_employees as $notes_on_employees_row) {

      $data['class_id'] = $this->input->post('class_id');
      $data['employee_id'] = $this->input->post('employee_id');
      $data['type_of_notes_on_employee_id'] = $notes_on_employees_row;
      $data['date'] = strtotime(date("Y-m-d H:i:s"));
      $data['year'] = $year;

      $this->db->insert('notes_on_employee', $data);
      }
      } else {
      $this->session->set_flashdata('error_message', $this->lang->line('input_data_error_not_saved'));
      redirect(site_url('user/view_notes_on_employee/' . $data['class_id']), 'refresh');
      }


      $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
      redirect(site_url('user/view_notes_on_employee/' . $data['class_id']), 'refresh');
      }
     */

    function add_new_notes_on_employees() {
        $this->if_user_login();

        $year = $this->db->get_where('settings', ['type' => 'running_year'])->row()->description;
        $notes_on_employees = $this->input->post('notes_on_employees', true); // تفعيل التصفية
        $class_id = $this->input->post('class_id', true); // تفعيل التصفية
        $employee_id = $this->input->post('employee_id', true); // تفعيل التصفية

        if (is_array($notes_on_employees) && $class_id && $employee_id) {
            $date = strtotime(date("Y-m-d H:i:s"));

            foreach ($notes_on_employees as $note) {
                // التحقق من صحة مدخلات الملاحظات قبل إدخالها
                if (!is_numeric($note)) {
                    continue; // تجاوز أي بيانات غير صالحة
                }

                $data = [
                    'class_id' => (int) $class_id,
                    'employee_id' => (int) $employee_id,
                    'type_of_notes_on_employee_id' => (int) $note,
                    'date' => $date,
                    'year' => $year
                ];

                $this->db->insert('notes_on_employee', $data);
            }

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
        } else {
            $this->session->set_flashdata('error_message', $this->lang->line('input_data_error_not_saved'));
        }

        redirect(site_url('user/view_notes_on_employee/' . (int) $class_id), 'refresh');
    }

    /*  ---------------      End notes on employee    ---------------    */

    /*  ---------------     employee accountability    ---------------    */

    function view_employee_accountability_selector() {
        $this->if_user_login();

        $login_type = $this->session->userdata('login_type');
        if ($login_type == 'employee') {
            $page_data['inner_page'] = 'view_employee_accountability';
            //$page_data['class_id'] = $class_id;

            $page_data['page_name'] = 'view_employee_accountability_selector';
            //$page_data['class_id'] = $class_id;
            $page_data['page_title'] = $this->lang->line('employee_accountability');

            redirect(site_url('user/view_notes_on_employee/' . $this->session->userdata('class_id')), 'refresh');
        } else {
            $page_data['page_name'] = 'view_employee_accountability_selector';
            $page_data['page_title'] = $this->lang->line('employee_accountability');

            $this->load->view('backend/index', $page_data);
        }
    }

    function view_employee_accountability($class_id) {
        $this->if_user_login();

        if ($class_id != 0) {
            $page_data['inner_page'] = 'view_employee_accountability';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'view_employee_accountability_selector';
        $page_data['page_title'] = $this->lang->line('employee_accountability');

        $this->load->view('backend/index', $page_data);
    }

    function type_of_employee_accountability() {
        $this->if_user_login();

        $page_data['page_name'] = 'type_of_employee_accountability';
        $page_data['page_title'] = $this->lang->line('manage_list_of_note_types');

        $this->load->view('backend/index', $page_data);
    }

    function delete_type_accountability_employee($accountability_types_id = '') {
        $this->if_user_login();
        $data['active'] = 0;

        $this->db->where('type_accountability_staff_id', $accountability_types_id);
        $this->db->update('type_accountability_staff', $data);
    }

    function add_type_accountability() {
        $this->if_user_login();
        $data['name'] = $this->input->post('name');
        $data['managerial_or_educational'] = $this->input->post('managerial_or_educational');

        $this->db->insert('type_accountability_staff', $data);

        $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
        redirect(site_url('user/type_of_employee_accountability/'), 'refresh');
    }

    function edit_type_accountability($param1 = '') {
        $this->if_user_login();
        $data['name'] = $this->input->post('name');
        $data['managerial_or_educational'] = $this->input->post('managerial_or_educational');

        $this->db->where('type_accountability_staff_id', $param1);
        $this->db->update('type_accountability_staff', $data);

        $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
        redirect(site_url('user/type_of_employee_accountability/'), 'refresh');
    }

    function add_new_accountability_on_employees() {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $class_id = $this->input->post('class_id');

        if ($this->input->post('describe_accountability') != null) {

            $data['date_accountability'] = strtotime(date("Y-m-d H:i:s"));
            $data['class_id'] = $this->input->post('class_id');
            $data['employee_id'] = $this->input->post('employee_id');
            $data['type_accountability_staff'] = $this->input->post('type_accountability_staff');
            $data['describe_accountability'] = $this->input->post('describe_accountability');
            $data['year'] = $year;

            $this->db->insert('accountability_staff', $data);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/view_employee_accountability/' . $data['class_id']), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', $this->lang->line('input_data_error_not_saved'));
            redirect(site_url('user/view_employee_accountability/' . $class_id), 'refresh');
        }

        $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
        redirect(site_url('user/view_employee_accountability/' . $data['class_id']), 'refresh');
    }

    function reply_accountability($accountability_staff_id = '') {
        $this->if_user_login();

        $employee_id = $this->db->get_where('accountability_staff', array('accountability_staff_id' => $accountability_staff_id))->row()->employee_id;

        if ($this->input->post('employee_statement') != null) {

            $data['date_statement'] = strtotime(date("Y-m-d H:i:s"));
            $data['employee_statement'] = $this->input->post('employee_statement');

            $this->db->where('accountability_staff_id', $accountability_staff_id);
            $this->db->update('accountability_staff', $data);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/employee_profile/employee_accountability/' . $employee_id), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', $this->lang->line('input_data_error_not_saved'));
            redirect(site_url('user/employee_profile/employee_accountability/' . $employee_id), 'refresh');
        }
    }

    /*  ---------------      End employee accountability    --------------- */

    function track_time_for_pages() {
        $this->if_user_login();
        $data['time_in_page'] = $_POST['time_in_page_1'];
        $data['page_name'] = $_POST['page_name_1'];
        $data['user_id'] = $this->session->userdata('login_user_id');

        if ($this->session->userdata('login_type') == 'employee') {
            $data['class_id'] = $this->session->userdata('class_id');
        }

        $data['user_type'] = $this->session->userdata('login_type');
        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['date'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('track_time_for_pages', $data);
    }

    function user_satisfaction() {
        $this->if_user_login();
        $data['poll_question'] = $_POST['poll_question_1'];
        $data['data_user_satisfaction'] = $_POST['data_user_satisfaction_1'];
        $data['user_type'] = $this->session->userdata('login_type');
        $data['user_id'] = $this->session->userdata('login_user_id');

        if ($this->session->userdata('login_type') == 'employee') {
            $data['class_id'] = $this->session->userdata('class_id');
        }

        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['date'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('user_satisfaction', $data);
    }

    function user_section_selected() {
        $this->if_user_login();

        $data_user_selected = $_POST['data_user_selected_1'];

        if ($data_user_selected != 0) {
            $this->session->set_userdata('class_id', $data_user_selected);
            $this->session->set_userdata('selected_section', $data_user_selected);

            echo '1';
        }
    }

    function user_selected() {
        $this->if_user_login();

        $website_status = "";

        $data_user_selected = $_POST['data_user_selected_2'];

        if ($data_user_selected != 0) {
            if ($data_user_selected == '-200') {
                $credential = array('technical_support_id' => 1);

                $query = $this->db->get_where('technical_support', $credential);
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $this->session->set_userdata('user_login', '1');
                    $this->session->set_userdata('technical_support_login', '1');
                    $this->session->set_userdata('technical_support_id', $row->technical_support_id);
                    $this->session->set_userdata('login_user_id', $row->technical_support_id);
                    $this->session->set_userdata('name', $row->name);
                    $this->session->set_userdata('job_title_id', 1);
                    $this->session->set_userdata('login_type', 'technical_support');
                    $this->session->set_userdata('language', $row->lang);
                    $this->session->set_userdata('site_lang', $row->lang);
                    $this->session->set_userdata('last_login', $row->last_login);
                    $this->session->set_userdata('job_title_name', 'technical_support');

                    $this->session->set_userdata('level', -1);

                    echo '1';
                }
            } elseif ($data_user_selected == '-100') {
                $credential = array('admin_id' => 1);
                $query = $this->db->get_where('admin', $credential);

                if ($query->num_rows() > 0) {
                    $is_admin = 1;
                } else {
                    $credential = array('admin_id' => 1);
                    $query = $this->db->get_where('admin', $credential);
                    $is_admin = 1;
                }

                if ($is_admin == 1) {
                    $row = $query->row();
                    $this->session->set_userdata('user_login', '1');
                    $this->session->set_userdata('admin_login', '1');
                    $this->session->set_userdata('admin_id', $row->admin_id);
                    $this->session->set_userdata('login_user_id', $row->admin_id);
                    $this->session->set_userdata('name', $row->name);
                    $this->session->set_userdata('login_type', 'admin');
                    $this->session->set_userdata('language', $row->lang);
                    $this->session->set_userdata('last_login', $row->last_login);
                    $this->session->set_userdata('job_title_name', 'public_management');

                    $this->session->set_userdata('level', -1);

                    echo '1';
                }
            } elseif ($data_user_selected == '-300') {

                $credential = array('parent_id' => 2);

                $query = $this->db->get_where('parent', $credential);
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $this->session->set_userdata('user_login', '1');
                    $this->session->set_userdata('parent_login', '1');
                    $this->session->set_userdata('parent_id', $row->parent_id);
                    $this->session->set_userdata('login_user_id', $row->parent_id);
                    $this->session->set_userdata('name', $row->name);
                    $this->session->set_userdata('login_type', 'parent');
                    $this->session->set_userdata('language', $row->lang);
                    $this->session->set_userdata('job_title_name', 'parent');

                    $this->session->set_userdata('level', -1);

                    echo '3';
                }
            } else {

                $credential = array('employee_id' => $data_user_selected);
                $query = $this->db->get_where('employee', $credential);

                if ($query->num_rows() > 0) {
                    $row = $query->row();

                    if ($website_status == 'disabled') {
                        return 'disabled';
                    } elseif ($row->status_login == 0) {
                        return 'suspended';
                    } else {

                        $prefix_status = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;

                        $this->session->set_userdata('user_login', '1');
                        $this->session->set_userdata('employee_login', '1');
                        $this->session->set_userdata('employee_id', $row->employee_id);
                        $this->session->set_userdata('login_user_id', $row->employee_id);
                        $this->session->set_userdata('name', $row->name);
                        if ($row->job_title_id == 28) {
                            $this->session->set_userdata('job_title_id', 4);
                            $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;

                            $this->session->set_userdata('job_title_name', $job_title_name);
                        } else {
                            $this->session->set_userdata('job_title_id', $row->job_title_id);
                            $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;

                            $this->session->set_userdata('job_title_name', $job_title_name);
                        }

                        //if ($prefix_status == '_rc') {
                        //    if ($row->job_title_id == 14 || $row->job_title_id == 15) {
                        //        $this->session->set_userdata('job_title_id', 3);
                        //    }
                        //}

                        /*
                          $num_classes = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->num_rows();
                          if ($num_classes > 1) {
                          $this->session->set_userdata('class_id', 0);
                          } else {
                          $class_id = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->row()->class_id;
                          $this->session->set_userdata('class_id', $class_id);
                          }
                         */


                        $this->session->set_userdata('level', $row->level);
                        //$this->session->set_userdata('class_id', $row->class_id);
                        $this->session->set_userdata('login_type', 'employee');
                        $this->session->set_userdata('language', $row->lang);
                        $this->session->set_userdata('last_login', $row->last_login);
                        $this->session->set_userdata('selected_section', '0');
                        $this->session->set_userdata('encrypt_thread', $row->encrypt_thread);

                        if ($this->session->userdata('login_type') == 'employee') {
                            $data_track['class_id'] = $this->session->userdata('class_id');
                        }

                        echo '1';
                    }
                } else {
                    echo '2';
                }
            }
        }
    }

    function notes_users() {
        $this->if_user_login();
        $data['notes_users_textarea'] = $_POST['notes_users_textarea_1'];
        $data['user_type'] = $this->session->userdata('login_type');
        $data['user_id'] = $this->session->userdata('login_user_id');

        if ($this->session->userdata('login_type') == 'employee') {
            $data['class_id'] = $this->session->userdata('class_id');
        }

        $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $data['date'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('notes_users', $data);
    }

    function current_performance_level($class_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'current_performance_level';
        $page_data['page_title'] = $this->lang->line('current_performance_level') . " - " . $this->lang->line('class') . " : " .
                $this->crud_model->get_class_name($class_id);
        $page_data['class_id'] = $class_id;

        $this->load->view('backend/index', $page_data);
    }

    /*     * **MANAGE TEACHERS**** */

    function assessment_of_employee() {
        $this->if_user_login();
        $page_data['page_name'] = 'assessment_of_employee';
        $page_data['page_title'] = $this->lang->line('assessment_of_employee');

        $this->load->view('backend/index', $page_data);
    }

    /*     * ***MANAGE CLASSES**** */

    function get_subject($class_id) {
        $this->if_user_login();
        $subject = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();
        foreach ($subject as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_subject($class_id) {
        $this->if_user_login();
        $subjects = $this->db->get_where('subject', array('class_id' => $class_id))->result_array();

        foreach ($subjects as $row) {
            echo '<option value="' . $row['subject_id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_class_section_specialist($class_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/user/class_routine_section_specialist_selector', $page_data);
    }

    function get_class_section_subject($class_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/user/class_routine_section_subject_selector', $page_data);
    }

    function get_class_section_subject_employee($subject_id) {
        $this->if_user_login();
        $page_data['job_title_id'] = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->job_title_id;
        $page_data['class_id'] = $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->class_id;
        $this->load->view('backend/user/class_routine_section_specialist_selector', $page_data);
    }

    function get_class_subject_job_title($class_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/user/class_routine_subject_job_title', $page_data);
    }

    function section_subject_edit($class_id, $class_routine_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $page_data['class_routine_id'] = $class_routine_id;
        $this->load->view('backend/user/class_routine_section_subject_edit', $page_data);
    }

    /*     * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

    function transport($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['route_name'] = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            $data['description'] = $this->input->post('description');
            $data['route_fare'] = $this->input->post('route_fare');
            $this->db->insert('transport', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_transport') . ' ' . $data['route_name'] . ' ' . $data['number_of_vehicle'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/transport'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['route_name'] = $this->input->post('route_name');
            $data['number_of_vehicle'] = $this->input->post('number_of_vehicle');
            $data['description'] = $this->input->post('description');
            $data['route_fare'] = $this->input->post('route_fare');

            $this->db->where('transport_id', $param2);
            $this->db->update('transport', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_transport') . ' ' . $data['route_name'] . ' ' . $data['number_of_vehicle'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/transport'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('transport', array(
                        'transport_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {

            $this->db->where('transport_id', $param2);
            $this->db->delete('transport');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/transport'), 'refresh');
        }
        $page_data['transports'] = $this->db->get('vehicle_management')->result_array();
        $page_data['page_name'] = 'transport';
        $page_data['page_title'] = $this->lang->line('manage_transport');

        $this->load->view('backend/index', $page_data);
    }

    function management_transport($param1 = '') {
        $this->if_user_login();

        if ($param1 == 'list_vehicles') {
            $page_data['inner_page'] = 'list_vehicles';
        }

        if ($param1 == 'add_transport') {
            $page_data['inner_page'] = 'add_transport';
        }

        if ($param1 == 'add_student_transport') {
            $page_data['inner_page'] = 'add_student_transport';
        }

        if ($param1 == 'list_area') {
            $page_data['inner_page'] = 'list_area';
        }

        if ($param1 == 'add_area') {
            $page_data['inner_page'] = 'add_area';
        }

        if ($param1 == 'add_vehicle') {
            $page_data['inner_page'] = 'add_vehicle';
        }

        $page_data['page_name'] = 'management_transport';
        $page_data['page_title'] = $this->lang->line('manage_transport');

        $this->load->view('backend/index', $page_data);
    }

    function vehicle_management_view($class_id = '') {
        $this->if_user_login();

        //$page_data['transports'] = $this->db->get('vehicle_management')->result_array();
        $page_data['vehicle_management'] = $this->db->get_where('vehicle_management', array('class_id' => $class_id))->result_array();
        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'vehicle_management_view';
        $page_data['page_title'] = $this->lang->line('vehicle_management');

        $this->load->view('backend/index', $page_data);
    }

    function area_management($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['name'] = $this->input->post('area_name');
            $data['price'] = $this->input->post('price');
            $data['class_id'] = $this->input->post('class_id');

            $this->db->insert('area_management', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_area') . ' ' . $data['name'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/management_transport/list_area/' . $data['class_id']), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('area_name');
            $data['price'] = $this->input->post('route_fare');
            $data['class_id'] = $this->input->post('class_id');

            $this->db->where('area_management_id', $param2);
            $this->db->update('area_management', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_area') . ' ' . $data['name'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/management_transport/list_area/' . $data['class_id']), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('area_management', array(
                        'area_management_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {

            $area_name = $this->db->get_where('area_management', array('area_management_id' => $param2))->row()->name;
            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('delete_area') . ' ' . $area_name;
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $class_id = $this->db->get_where('area_management', array('area_management_id' => $param2))->row()->class_id;

            $this->db->where('area_management_id', $param2);
            $this->db->delete('area_management');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/management_transport/list_area/' . $class_id), 'refresh');
        }
    }

    function vehicle_management($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['type_car'] = $this->input->post('type_car');
            $data['number_plate'] = $this->input->post('number_plate');
            $data['driver_name'] = $this->input->post('driver_name');
            $data['phone_driver'] = $this->input->post('phone_driver');

            $data['driver_assistant'] = $this->input->post('driver_assistant');
            $data['driver_assistant_phone'] = $this->input->post('driver_assistant_phone');

            $data['driver_assistant_2'] = $this->input->post('driver_assistant_2');
            $data['driver_assistant_2_phone'] = $this->input->post('driver_assistant_2_phone');

            $data['absorptive_capacity'] = $this->input->post('absorptive_capacity');
            $data['class_id'] = $this->input->post('class_id');

            $this->db->insert('vehicle_management', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_vehicle') . ' ' . $data['number_plate'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/management_transport/list_vehicles/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['type_car'] = $this->input->post('type_car');
            $data['number_plate'] = $this->input->post('number_plate');
            $data['driver_name'] = $this->input->post('driver_name');
            $data['phone_driver'] = $this->input->post('phone_driver');

            $data['driver_assistant'] = $this->input->post('driver_assistant');
            $data['driver_assistant_phone'] = $this->input->post('driver_assistant_phone');

            $data['driver_assistant_2'] = $this->input->post('driver_assistant_2');
            $data['driver_assistant_2_phone'] = $this->input->post('driver_assistant_2_phone');

            $data['absorptive_capacity'] = $this->input->post('absorptive_capacity');
            $data['class_id'] = $this->input->post('class_id');

            $this->db->where('vehicle_management_id', $param2);
            $this->db->update('vehicle_management', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_vehicle') . ' ' . $data['number_plate'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/management_transport/list_vehicles/'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('vehicle_management', array(
                        'vehicle_management_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {

            $number_plate_name = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $param2))->row()->number_plate;
            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('delete_vehicle') . ' ' . $number_plate_name;
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $class_id = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $param2))->row()->class_id;

            $this->db->where('vehicle_management_id', $param2);
            $this->db->delete('vehicle_management');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/management_transport/list_vehicles/'), 'refresh');
        }
    }

    function vehicle_area($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {

            $data['vehicle_id'] = $this->input->post('vehicle');
            $data['area_id'] = $this->input->post('area_id');
            $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            $data['class_id'] = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $data['vehicle_id']))->row()->class_id;

            $this->db->insert('vehicle_area', $data);

            $vehicle_id = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $data['vehicle_id']))->row()->number_plate;
            $area_id = $this->db->get_where('area_management', array('area_management_id' => $data['area_id']))->row()->name;

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert') . ' ' . $vehicle_id . ' ' . $this->lang->line('to') . ' ' . $area_id;
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/management_transport/add_transport/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['type_car'] = $this->input->post('type_car');
            $data['number_plate'] = $this->input->post('number_plate');
            $data['driver_id'] = $this->input->post('driver_id');
            $data['absorptive_capacity'] = $this->input->post('absorptive_capacity');

            $this->db->where('vehicle_management_id', $param2);
            $this->db->update('vehicle_management', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/management_transport'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('vehicle_management', array(
                        'vehicle_management_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {

            $this->db->where('vehicle_management_id', $param2);
            $this->db->delete('vehicle_management');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/management_transport'), 'refresh');
        }
        $page_data['vehicle_management'] = $this->db->get('vehicle_management')->result_array();
        $page_data['page_name'] = 'vehicle_management';
        $page_data['page_title'] = $this->lang->line('vehicle_management');

        $this->load->view('backend/index', $page_data);
    }

    function subscribers_on_transport($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['class_id'] = $this->input->post('class_id');
            if (
                    $this->input->post('vehicle') == 0 ||
                    $this->input->post('area_id') == 0
            ) {
                $this->session->set_flashdata('flash_message', $this->lang->line('Incorrect_data'));
                redirect(site_url('user/management_transport/add_student_transport'), 'refresh');
            } else {
                foreach ($this->input->post('student_id') as $id) {

                    $data['student_id'] = $id;
                    $data['vehicle_id'] = $this->input->post('vehicle');
                    $data['area_id'] = $this->input->post('area_id');
                    $data['class_id'] = $this->input->post('class_id');
                    $data['section_id'] = $this->input->post('section_id');
                    $data['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

                    $this->db->insert('subscribers_on_transport', $data);

                    $student_name = $this->db->get_where('student', array('student_id' => $data['student_id']))->row()->name;
                    $vehicle_id = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $data['vehicle_id']))->row()->number_plate;
                    $area_id = $this->db->get_where('area_management', array('area_management_id' => $data['area_id']))->row()->name;

                    $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_student') . ' ' . $student_name . ' ' . $this->lang->line('to') . ' ' . $vehicle_id . ' ' . $this->lang->line('and_area') . ' ' . $area_id;
                    $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                    $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                    $this->db->insert('database_history', $data3);
                }
                $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
                redirect(site_url('user/management_transport/' . $data['class_id']), 'refresh');
            }
        }
        if ($param1 == 'do_update') {
            $data['type_car'] = $this->input->post('type_car');
            $data['number_plate'] = $this->input->post('number_plate');
            $data['driver_id'] = $this->input->post('driver_id');
            $data['absorptive_capacity'] = $this->input->post('absorptive_capacity');

            $this->db->where('vehicle_management_id', $param2);
            $this->db->update('vehicle_management', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/transport'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('vehicle_management', array('vehicle_management_id' => $param2))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('vehicle_management_id', $param2);
            $this->db->delete('vehicle_management');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/management_transport'), 'refresh');
        }
        //$page_data['vehicle_management'] = $this->db->get('vehicle_management')->result_array();
        $page_data['page_name'] = 'transport';
        $page_data['page_title'] = $this->lang->line('transport');

        $this->load->view('backend/index', $page_data);
    }

    function transport_student_print($vehicle_management_id) {
        $this->if_user_login();

        $page_data['vehicle_management_id'] = $vehicle_management_id;
        $json_data = array();
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $transport_students = $this->db->get_where('subscribers_on_transport', array('vehicle_id' => $vehicle_management_id, 'year' => $running_year, 'active' => 1))->result_array();
        $count = 1;
        foreach ($transport_students as $row) :

            $json_array['count'] = $count++;
            $json_array['name'] = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name;
            $parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
            $json_array['phone'] = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->phone;
            $json_array['another_phone'] = $this->db->get_where('parent', array('parent_id' => $parent_id))->row()->another_phone;
            $json_array['region'] = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->region;

            array_push($json_data, $json_array);
        endforeach;

        $myarray = json_encode($json_data, JSON_UNESCAPED_UNICODE);

        $page_data['page_name'] = 'transport_student_print';
        $page_data['data'] = $myarray;

        $this->load->view('backend/user/transport_student_print', $page_data);
    }

    /*     * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

    function dormitory($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['name'] = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description'] = $this->input->post('description');
            }

            $this->db->insert('dormitory', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/dormitory'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('name');
            $data['number_of_room'] = $this->input->post('number_of_room');
            if ($this->input->post('description') != null) {
                $data['description'] = $this->input->post('description');
            } else {
                $data['description'] = null;
            }
            $this->db->where('dormitory_id', $param2);
            $this->db->update('dormitory', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/dormitory'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('dormitory', array(
                        'dormitory_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('dormitory_id', $param2);
            $this->db->delete('dormitory');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/dormitory'), 'refresh');
        }
        $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['page_name'] = 'dormitory';
        $page_data['page_title'] = $this->lang->line('manage_dormitory');
        $this->load->view('backend/index', $page_data);
    }

    /*     * *MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD* */

    function noticeboard($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['color'] = $this->input->post('color');
            $data['class_id'] = $this->input->post('class_id');
            $data['notice'] = $this->input->post('notice');
            $data['show_to'] = $this->input->post('show_to');
            $data['show_on_website'] = $this->input->post('show_on_website');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            if ($_FILES['image']['name'] != '') {
                $data['image'] = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/frontend/noticeboard/' . $_FILES['image']['name']);
            }
            $this->db->insert('noticeboard', $data);

            if ($data['show_to'] == 'fa') {
                $show_to = $this->lang->line('for_all');
            } elseif ($data['show_to'] == 'fp') {
                $show_to = $this->lang->line('for_parents');
            } elseif ($data['show_to'] == 'fe') {
                $show_to = $this->lang->line('for_employee');
            } else {
                $show_to = $this->lang->line('personality');
            }

            if ($data['show_to'] == 'fa' || $data['show_to'] == 'fp' || $data['show_to'] == 'fe') {
                $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_noticeboard') . ' ' . $data['notice_title'] . ' ' . $this->lang->line('show_to') . ' ' . $show_to;
                $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('database_history', $data3);
            }

            $check_sms_send = $this->input->post('check_sms');
            if ($check_sms_send == 1) {

                $parents = $this->db->get('parent')->result_array();
                $employee = $this->db->get('employee')->result_array();
                $date = $this->input->post('create_timestamp');
                $message = $data['notice_title'] . ' ';
                $message .= $this->lang->line('on') . ' ' . $date;
                foreach ($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message, $reciever_phone);
                }
                foreach ($employee as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message, $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }
        if ($param1 == 'do_update') {
            $image = $this->db->get_where('noticeboard', array('notice_id' => $param2))->row()->image;
            $data['notice_title'] = $this->input->post('notice_title');
            $data['color'] = $this->input->post('color');
            $data['class_id'] = $this->input->post('class_id');
            $data['notice'] = $this->input->post('notice');
            $data['show_to'] = $this->input->post('show_to');
            $data['show_on_website'] = $this->input->post('show_on_website');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            if ($_FILES['image']['name'] != '') {
                $data['image'] = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/frontend/noticeboard/' . $_FILES['image']['name']);
            } else {
                $data['image'] = $image;
            }

            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_noticeboard') . ' ' . $data['notice_title'];
            $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data3['date'] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert('database_history', $data3);

            $check_sms_send = $this->input->post('check_sms');

            if ($check_sms_send == 1) {

                $parents = $this->db->get('parent')->result_array();
                $employee = $this->db->get('employee')->result_array();
                $date = $this->input->post('create_timestamp');
                $message = $data['notice_title'] . ' ';
                $message .= $this->lang->line('on') . ' ' . $date;
                foreach ($parents as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message, $reciever_phone);
                }
                foreach ($employee as $row) {
                    $reciever_phone = $row['phone'];
                    $this->sms_model->send_sms($message, $reciever_phone);
                }
            }

            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/noticeboard/'), 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                        'notice_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {

            $show_to = $this->db->get_where('noticeboard', array('notice_id' => $param2))->row()->show_to;
            if ($show_to == 'fa' || $show_to == 'fp' || $show_to == 'fe') {
                $notice_name = $this->db->get_where('noticeboard', array('notice_id' => $param2))->row()->notice_title;
                $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('delete_notice') . ' ' . $notice_name;
                $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $this->db->insert('database_history', $data3);
            }

            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }
        if ($param1 == 'mark_as_archive') {
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', array('status' => 0));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }

        if ($param1 == 'remove_from_archived') {
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', array('status' => 1));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = $this->lang->line('manage_noticeboard');

        $this->load->view('backend/index', $page_data);
    }

    function noticeboard_edit($notice_id) {
        $this->if_user_login();

        $page_data['page_name'] = 'noticeboard_edit';
        $page_data['notice_id'] = $notice_id;
        $page_data['page_title'] = $this->lang->line('edit_notice');

        $this->load->view('backend/index', $page_data);
    }

    function reload_noticeboard() {
        $this->if_user_login();
        $this->load->view('backend/user/noticeboard');
    }

    function events($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {
            $data['notice_title'] = $this->input->post('title');
            $data['start'] = $this->input->post('start');
            $data['end'] = $this->input->post('end');
            $data['color'] = $this->input->post('color');

            $this->db->insert('noticeboard', $data);

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/dashboard'), 'refresh');
        }

        if ($param1 == 'do_update') {

            $delete = $this->input->post('delete');
            if ($delete == 1) {
                $data['notice_id'] = $this->input->post('id');

                $this->db->where('notice_id', $data['notice_id']);
                $this->db->delete('noticeboard');

                $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
                redirect(site_url('user/dashboard/'), 'refresh');
            } else {
                $data['notice_id'] = $this->input->post('id');
                $data['notice_title'] = $this->input->post('title');
                $data['color'] = $this->input->post('color');

                $this->db->where('notice_id', $data['notice_id']);
                $this->db->update('noticeboard', $data);

                $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
                redirect(site_url('user/dashboard'), 'refresh');
            }
        }

        if ($param1 == 'do_event_update') {

            $data['notice_id'] = $_POST['Event'][0];
            $data['start'] = $_POST['Event'][1];
            $data['end'] = $_POST['Event'][2];

            $this->db->where('notice_id', $data['notice_id']);
            $this->db->update('noticeboard', $data);
        }

        if ($param1 == 'mark_as_archive') {
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', array('status' => 0));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }

        if ($param1 == 'remove_from_archived') {
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', array('status' => 1));
            redirect(site_url('user/noticeboard/'), 'refresh');
        }
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = $this->lang->line('manage_noticeboard');

        $this->load->view('backend/index', $page_data);
    }

    /*     * ***SITE/SYSTEM SETTINGS******** */

    function system_settings($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'do_update') {

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type', 'system_name');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type', 'system_title');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type', 'address');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type', 'phone');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type', 'currency');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type', 'system_email');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type', 'system_name');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type', 'language');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type', 'text_align');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('running_year');
            $this->db->where('type', 'running_year');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('active_sms_service');
            $this->db->where('type', 'active_sms_service');
            $this->db->update('settings', $data);

            //$data['description'] = $this->input->post('website_status');
            $description = $this->input->post('website_status');

            if ($description == 'active') {
                $data['description'] = $this->input->post('website_status');

                $this->db->where('type', 'website_status');
                $this->db->update('settings', $data);
            } else {

                $nowtime = date("Y-m-d H:i:s");

                $today = time();
                $website_disabled_time['description'] = date('Y-m-d H:i:s', strtotime($nowtime) + $description);  // time() returns a time in seconds already

                $this->db->where('type', 'website_disabled_time');
                $this->db->update('settings', $website_disabled_time);

                $data['description'] = 'disabled';

                $this->db->where('type', 'website_status');
                $this->db->update('settings', $data);
            }

            $this->db->where('type', 'website_status');
            $this->db->update('settings', $data);

            $login_type = $this->session->userdata('login_type');
            if ($login_type == 'technical_support') {

                $data['description'] = $this->input->post('prefix');
                $this->db->where('type', 'prefix');
                $this->db->update('settings', $data);

                $data['description'] = $this->input->post('storage_space');
                $this->db->where('type', 'storage_space');
                $this->db->update('settings', $data);

                $data['description'] = $this->input->post('center_type');
                $this->db->where('type', 'center_type');
                $this->db->update('settings', $data);

                $data['description'] = $this->input->post('c_name');
                $this->db->where('type', 'c_name');
                $this->db->update('settings', $data);
            }

            //للتحق من اضافة الخاصية وازالتها بعد اضافتها بشكل تلقائي لمركز الوليد
            $type = 'retrieve_password_using_sms';
            $check_up = $this->db->get_where('settings', array('type' => $type));
            $data_t['type'] = $type;

            if ($check_up->num_rows() == 0) {
                $this->db->insert('settings', $data_t);
            }

            $data['description'] = $this->input->post('retrieve_password_using_sms');
            $this->db->where('type', 'retrieve_password_using_sms');
            $this->db->update('settings', $data);

            $data['description'] = $this->input->post('printed_footer');
            $this->db->where('type', 'printed_footer');
            $this->db->update('settings', $data);

            //للتحق من اضافة الخاصية وازالتها بعد اضافتها بشكل تلقائي لمركز الوليد
            $type = 'tax_number';
            $check_up = $this->db->get_where('settings', array('type' => $type));
            $data_t['type'] = $type;
            if ($check_up->num_rows() == 0) {
                $this->db->insert('settings', $data_t);
            }

            $data['description'] = $this->input->post('tax_number');
            $this->db->where('type', 'tax_number');
            $this->db->update('settings', $data);

            $data['success'] = true;
            $data['message'] = 'Success!';
            echo json_encode($data, JSON_UNESCAPED_UNICODE);

            //$this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            //redirect(site_url('user/system_settings/'), 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', $this->lang->line('settings_updated'));
            redirect(site_url('user/system_settings/'), 'refresh');
        }


        if ($param1 == 'upload_logo_discharger') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo_discharger.png');
            $this->session->set_flashdata('flash_message', $this->lang->line('settings_updated'));
            redirect(site_url('user/system_settings/'), 'refresh');
        }

        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = $this->lang->line('system_settings');
        $page_data['settings'] = $this->db->get('settings')->result_array();

        $this->load->view('backend/index', $page_data);
    }

    function system_settings_update($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'do_update') {

            $fields_system = [
                'system_name' => 'system_name',
                'system_title' => 'system_title',
                'address' => 'address',
                'phone' => 'phone',
                'currency' => 'currency',
                'system_email' => 'system_email',
                'language' => 'language',
                'tax_number' => 'tax_number',
                'running_year' => 'running_year',
                'download_size_students' => 'download_size_students',
                'allowed_file_size' => 'allowed_file_size',
                'active_sms_service' => 'active_sms_service',
                'printed_footer' => 'printed_footer',
                'privacy_ar' => 'privacy_ar',
                'account' => 'account',
                'iban' => 'iban',
                'branch' => 'branch',
                'bank_name' => 'bank_name',
            ];

            foreach ($fields_system as $post_field => $type) {
                $data['description'] = $this->input->post($post_field);
                if (!is_null($data['description'])) {
                    $this->db->where('type', $type);
                    $this->db->update('settings', $data);
                }
            }

            if ($this->input->post('u_logo') == null || $this->input->post('u_logo') == "") {
                
            } else {
                $data['description'] = $this->input->post('u_logo');
                $this->db->where('type', 'u_logo');
                $this->db->update('settings', $data);
            }

            if ($this->input->post('leatr_page_photo') == null || $this->input->post('leatr_page_photo') == "") {
                
            } else {
                $data['description'] = $this->input->post('leatr_page_photo');
                $this->db->where('type', 'leatr_page_photo');
                $this->db->update('settings', $data);
            }

            $num_workdays = 7;

            for ($i = 1; $i <= $num_workdays; $i++) {
                $workday_data = explode("-", $this->input->post('workday_' . $i));
                if (count($workday_data) < 3) {
                    continue;
                }

                $data_workday['workday'] = $workday_data[2];
                $this->db->where('workdays_id', $workday_data[0]);
                $this->db->update('workdays', $data_workday);
            }

            //$data['description'] = $this->input->post('website_status');
            $description = $this->input->post('website_status');

            if ($description == 'active') {
                $data['description'] = $this->input->post('website_status');

                $this->db->where('type', 'website_status');
                $this->db->update('settings', $data);
            } else {

                $nowtime = date("Y-m-d H:i:s");

                $today = time();
                $website_disabled_time['description'] = date('Y-m-d H:i:s', strtotime($nowtime) + $description);  // time() returns a time in seconds already

                $this->db->where('type', 'website_disabled_time');
                $this->db->update('settings', $website_disabled_time);

                $data['description'] = 'disabled';

                $this->db->where('type', 'website_status');
                $this->db->update('settings', $data);
            }

            $this->db->where('type', 'website_status');
            $this->db->update('settings', $data);

            $login_type = $this->session->userdata('login_type');
            if ($login_type == 'technical_support') {

                $fields = [
                    'prefix' => 'prefix',
                    'storage_space' => 'storage_space',
                    'center_type' => 'center_type',
                    'c_name' => 'c_name',
                    'client_id' => 'client_id',
                    'expiration_date' => 'expiration_date',
                    'country_center' => 'country_center',
                ];

                foreach ($fields as $post_field => $type) {
                    $data['description'] = $this->input->post($post_field);
                    $this->db->where('type', $type);
                    $this->db->update('settings', $data);
                }
            }

            $data['success'] = true;
            $data['message'] = 'Success!';
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function get_session_changer() {
        $this->if_user_login();
        $this->load->view('backend/user/change_session');
    }

    function change_session() {
        $this->if_user_login();
        $data['description'] = $this->input->post('running_year');
        $this->db->where('type', 'running_year');
        $this->db->update('settings', $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('session_changed'));
        redirect(site_url('user/dashboard/'), 'refresh');
    }

    function update_change_language() {
        $this->if_user_login();

        $emp = $_POST["pha"];
        $edit_profile = $_POST['edit_profile'];
        $data[$edit_profile] = $_POST["st"];

        //$this->db->where('phrase_id', $emp);
        //$this->db->update('language', $data);

        echo $_POST["st"];
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function print_id($id) {
        $this->if_user_login();
        $data['id'] = $id;
        $page_data['page_name'] = 'print_id';

        $this->load->view('backend/user/print_id', $data);
    }

    function print_all_id() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_all_id';

        $this->load->view('backend/user/print_all_id');
    }

    function print_all_id_2() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_id_2';
        $this->load->view('backend/user/print_all_id_2');
    }

    function print_all_id_3_3() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_id_3_3';
        $this->load->view('backend/user/print_all_id_3_3');
    }

    function print_all_id_3_3_1() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_id_3_3_1';
        $this->load->view('backend/user/print_all_id_3_3_1');
    }

    function print_all_id_3() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_id_3';
        $this->load->view('backend/user/print_all_id_3');
    }

    function print_all_id_em() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_all_id_em';
        $this->load->view('backend/user/print_all_id_em');
    }

    /*
      function check_name_section() {

      $name = $_POST['name'];
      $class_id = $_POST['class_id'];
      if ($_POST['section_id']) {
      $section_id = $_POST['section_id'];
      }

      $checkdata = $this->db->get_where('section', array('name' => $name, 'class_id' => $class_id))->num_rows();
      if ($checkdata > 0) {
      if ($_POST['section_id']) {
      $old_name = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
      if ($old_name == $name) {
      echo 'this_old_name';
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
     */

    function check_name_section() {
        $this->if_user_login();
        $name = $this->input->post('name');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        // التحقق من عدد السجلات التي تطابق الاسم و معرف الصف
        $checkdata = $this->db->get_where('section', array('name' => $name, 'class_id' => $class_id))->num_rows();

        // إذا كان الاسم موجود مسبقًا
        if ($checkdata > 0) {
            // إذا كان هناك معرف قسم و الاسم القديم يطابق الاسم الحالي
            if ($section_id) {
                $old_name = $this->db->get_where('section', array('section_id' => $section_id))->row()->name;
                echo ($old_name == $name) ? 'this_old_name' : 'false';
            } else {
                echo 'false';
            }
        } else {
            echo 'true';
        }
    }

    function get_dormitory_room($dormitory_id) {
        $this->if_user_login();
        $query_dormitory = $this->db->get_where('dormitory', array(
                    'dormitory_id' => $dormitory_id
                ))->row()->number_of_room;

        for ($i = 1; $i <= $query_dormitory; $i++) {
            echo '<option value="' . $i . '">' . $this->lang->line('room') . ' ' . $i . '</option>';
        }
    }

    /*     * ***************** SMS API ********************* */

    function send_sms($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        // تحديد inner_page باستخدام switch
        switch ($param1) {
            case 'by_class':
                $page_data['inner_page'] = 'by_class';
                break;
            case 'by_group':
                $page_data['inner_page'] = 'by_group';
                break;
            case 'by_employee':
                $page_data['inner_page'] = 'by_employee';
                break;
            default:
                $page_data['inner_page'] = 'by_class'; // قيمة افتراضية إذا لم يكن هناك تطابق
                break;
        }

        $page_data['page_name'] = 'send_sms';
        $page_data['page_title'] = $this->lang->line('sms');

        $this->load->view('backend/index', $page_data);
    }

    function send_sms_by($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'by_class') {

            $data['message'] = $this->input->post('title'); //title
            $data['reciever_phone'] = $this->input->post('student_id[]'); //hersms

            $message = $data['message'];
            $reciever_phone = $data['reciever_phone'];
            $count_msg = $this->input->post('char_Num');
            if ($count_msg <= 67) {
                $num_msg = 1;
            } elseif ($count_msg <= 134) {
                $num_msg = 2;
            } elseif ($count_msg <= 201) {
                $num_msg = 3;
            }

            $balance_SMS = $this->db->get_where('settings', array('type' => 'balance_SMS'))->row()->description;
            $count_sms = count($reciever_phone) * $num_msg;

            $final_balance = $balance_SMS - $count_sms;

            if ($count_sms > $balance_SMS) {
                $this->session->set_flashdata('flash_message', $this->lang->line('not_sending_sms'));
                redirect(site_url('user/send_sms'), 'refresh');
            } else {
                //تحدث رصيد الرسائل بعد الإرسال
                $data_2['description'] = $final_balance;
                $this->db->where('type', 'balance_SMS');
                $this->db->update('settings', $data_2);

                $this->sms_model->send_sms($message, $reciever_phone);

                $this->session->set_flashdata('flash_message', $this->lang->line('send_sms'));
                redirect(site_url('user/send_sms'), 'refresh');
            }
        }

        if ($param1 == 'by_group') {

            $receiver = $this->input->post('receiver');
            $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
            if ($receiver == 'parent') {

                $students = $this->db->get_where('enroll', array('status' => 1, 'year' => $year))->result_array();

                foreach ($students as $row) {
                    $get_parent_id = $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->parent_id;
                    $parent_phone[] = $this->db->get_where('parent', array('parent_id' => $get_parent_id))->row()->country_code . $this->db->get_where('parent', array('parent_id' => $get_parent_id))->row()->phone;
                }

                $count_msg = $this->input->post('char_Num2');
                if ($count_msg <= 67) {
                    $num_msg = 1;
                } elseif ($count_msg <= 134) {
                    $num_msg = 2;
                } elseif ($count_msg <= 201) {
                    $num_msg = 3;
                }

                $balance_SMS = $this->db->get_where('settings', array('type' => 'balance_SMS'))->row()->description;
                $count_sms = count($parent_phone) * $count_msg;
                $final_balance = $balance_SMS - $count_sms;

                if ($count_sms > $balance_SMS) {
                    $this->session->set_flashdata('flash_message', $this->lang->line('not_sending_SMS'));
                    redirect(site_url('user/send_sms'), 'refresh');
                } else {
                    //تحدث رصيد الرسائل بعد الإرسال
                    $data_2['description'] = $final_balance;
                    $this->db->where('type', 'balance_SMS');
                    $this->db->update('settings', $data_2);

                    $message = $this->input->post('title');
                    $reciever_phone = $parent_phone;

                    $this->sms_model->send_sms($message, $reciever_phone);

                    $this->session->set_flashdata('flash_message', $this->lang->line('send_sms'));
                    redirect(site_url('user/send_sms'), 'refresh');
                }
            }

            if ($receiver == 'employee') {
                $teacher = $this->db->get('employee')->result_array(); //getget
                foreach ($teacher as $row) {
                    $teacher_phone[] = $this->db->get_where('employee', array('employee_id' => $row['employee_id']))->row()->account_code . $this->db->get_where('employee', array('employee_id' => $row['employee_id']))->row()->phone;
                }

                $count_msg = $this->input->post('char_Num2');
                if ($count_msg <= 67) {
                    $num_msg = 1;
                } elseif ($count_msg <= 134) {
                    $num_msg = 2;
                } elseif ($count_msg <= 201) {
                    $num_msg = 3;
                }

                $balance_SMS = $this->db->get_where('settings', array('type' => 'balance_SMS'))->row()->description;
                $count_sms = count($teacher) * $count_msg;
                $final_balance = $balance_SMS - $count_sms;
                if ($count_sms > $balance_SMS) {
                    $this->session->set_flashdata('flash_message', $this->lang->line('not_sending_sms'));
                    redirect(site_url('user/send_sms'), 'refresh');
                } else {
                    //تحدث رصيد الرسائل بعد الإرسال
                    $data_2['description'] = $final_balance;
                    $this->db->where('type', 'balance_SMS');
                    $this->db->update('settings', $data_2);

                    $message = $this->input->post('title');
                    $reciever_phone = $teacher_phone;

                    //تحدث رصيد الرسائل بعد الإرسال
                    $data_2['description'] = $final_balance;
                    $this->db->where('type', 'balance_SMS');
                    $this->db->update('settings', $data_2);

                    $this->sms_model->send_sms($message, $reciever_phone);
                    $this->session->set_flashdata('flash_message', $this->lang->line('send_sms'));
                    redirect(site_url('user/send_sms'), 'refresh');
                }
            }
        }

        if ($param1 == 'by_employee') {

            $data['message'] = $this->input->post('title'); //title
            $data['reciever_phone'] = $this->input->post('employee_id[]'); //hersms

            $message = $data['message'];
            $reciever_phone = $data['reciever_phone'];
            $count_msg = $this->input->post('char_Num3');
            if ($count_msg <= 67) {
                $num_msg = 1;
            } elseif ($count_msg <= 134) {
                $num_msg = 2;
            } elseif ($count_msg <= 201) {
                $num_msg = 3;
            }

            $balance_SMS = $this->db->get_where('settings', array('type' => 'balance_SMS'))->row()->description;
            $count_sms = count($reciever_phone) * $num_msg;

            $final_balance = $balance_SMS - $count_sms;

            if ($count_sms > $balance_SMS) {
                $this->session->set_flashdata('flash_message', $this->lang->line('not_sending_sms'));
                redirect(site_url('user/send_sms'), 'refresh');
            } else {
                //تحدث رصيد الرسائل بعد الإرسال

                $data_2['description'] = $final_balance;
                $this->db->where('type', 'balance_SMS');
                $this->db->update('settings', $data_2);

                $this->sms_model->send_sms($message, $reciever_phone);

                $this->session->set_flashdata('flash_message', $this->lang->line('send_sms'));
                redirect(site_url('user/send_sms'), 'refresh');
            }
        }
    }

    /////////// Program activities ///////////////////////

    function program_activities() {
        $this->if_user_login();
        $page_data['page_name'] = 'program_activities';
        $page_data['page_title'] = $this->lang->line('program_activities');

        $this->load->view('backend/index', $page_data);
    }

    function delete_students_transport($student_id = '') {
        $this->if_user_login();

        $student_id = $_POST['studentId'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $type = $_POST['type'];

        $firstCharacter = $year[0];
        if ($firstCharacter == 1) {
            $type = 1;
        } else {
            $type = 0;
        }

        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        $class_id = $this->db->get_where('subscribers_on_transport', array('student_id' => $student_id, 'year' => $running_year))->row()->class_id;
        $student_name = $this->db->get_where('student', array('student_id' => $student_id))->row()->name;
        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('delete_student') . ' ' . $student_name . ' ' . $this->lang->line('from') . ' ' . $this->lang->line('transport');
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);

        $data_withdrawal['student_id'] = $student_id;
        $data_withdrawal['type'] = $type;
        $data_withdrawal['date'] = $day . '-' . $month . '-' . $year;
        $this->db->insert('withdrawal_from_transport', $data_withdrawal);

        $data['active'] = '0';
        $this->db->where('student_id', $student_id);
        $this->db->where('year', $running_year);
        $this->db->update('subscribers_on_transport', $data);

        redirect(site_url('user/management_transport/' . $class_id), 'refresh');
    }

    function get_age() {
        $this->if_user_login();
        $page_data['years'] = $_POST['years'];
        $page_data['months'] = $_POST['months'];
        $page_data['days'] = $_POST['days'];

        if ($_POST['years'] <= 10) {
            $phrase_year = $this->lang->line('years');
            $years = $_POST['years'] . ' ' . $phrase_year;
        } else {
            $phrase_year = $this->lang->line('age_years');
            $years = $_POST['years'] . ' ' . $phrase_year;
        }

        if ($_POST['months'] == 1) {
            $phrase_months = $this->lang->line('one_month');
            $months = $phrase_months;
        } elseif ($_POST['months'] == 2) {
            $phrase_months = $this->lang->line('two_months');
            $months = $phrase_months;
        } elseif ($_POST['months'] <= 10 && $_POST['months'] > 2) {
            $phrase_months = $this->lang->line('months');
            $months = $_POST['months'] . ' ' . $phrase_months;
        } else {
            $phrase_months = $this->lang->line('age_months');
            $months = $_POST['months'] . ' ' . $phrase_months;
        }

        echo $age = $years . ' ' . $this->lang->line('and') . ' ' . $months;
    }

    //احتمال كبير مش مستخدمة اعمل الها بحث وتاكد قبل الحذف
    function get_students_to_specialists($employee_id) {
        $this->if_user_login();
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select("a.student_id");
        $this->db->from("students_to_specialists a");
        $this->db->join("enroll b", "a.student_id = b.student_id", 'left');
        $this->db->where('a.year', $running_year);
        $this->db->where('b.year', $running_year);
        $this->db->where('a.active', 1);
        $this->db->where('a.employee_id', $employee_id);
        $this->db->where('b.status', 0);

        $students = $this->db->get()->result_array();

        echo '<option value=""></option>';
        foreach ($students as $row7) :

            echo '<option value="' . $row7['student_id'] . '">' . $this->db->get_where('student', array(
                'student_id' => $row7['student_id']
            ))->row()->name . '</option>';

        endforeach;
    }

    function get_class_section_selector($class_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/user/get_class_section_selector', $page_data);
    }

    function get_class_subject_selector($class_id) {
        $this->if_user_login();
        $page_data['class_id'] = $class_id;
        $this->load->view('backend/user/get_class_subject_selector', $page_data);
    }

    //////////////  Evaluation Of Employee  ////////////////////

    function evaluation_of_employee() {
        $this->if_user_login();

        $page_data['page_name'] = 'evaluation_of_employee';
        $page_data['page_title'] = $this->lang->line('evaluation_of_employee');

        $this->load->view('backend/index', $page_data);
    }

    function employee_edit($employee_id) {
        $this->if_user_login();

        $employee_en = $this->db->get_where('employee', array('encrypt_thread' => $employee_id))->num_rows();

        if ($employee_en > 0) {
            $page_data['page_name'] = 'employee_edit';
            $page_data['page_title'] = $this->lang->line('employee_edit');
            $page_data['employee_id'] = $this->db->get_where('employee', array('encrypt_thread' => $employee_id))->row()->employee_id;
            $this->load->view('backend/index', $page_data);
        } else {
            redirect(base_url() . 'Error_page', 'refresh');
            return;
        }
    }

    function search($param1 = "") {
        $this->if_user_login();
        $search_input = $this->input->post('search_input');

        $this->db->select('student_id,name');
        $this->db->select("1 AS 'type'");
        $this->db->from('student');
        $this->db->like('name', $search_input);
        $this->db->limit(50);
        $query_search_student = $this->db->get()->result_array();

        $this->db->select('employee_id,name,job_title_id,class_id');
        $this->db->select("2 AS 'type'");
        $this->db->from('employee');
        $this->db->like('name', $search_input);
        $this->db->limit(50);
        $query_search_employee = $this->db->get()->result_array();

        $this->db->select('parent_id,name');
        $this->db->select("3 AS 'type'");
        $this->db->from('parent');
        $this->db->like('name', $search_input);
        $this->db->limit(50);
        $query_search_parent = $this->db->get()->result_array();

        $query_search = array_merge($query_search_student, $query_search_employee, $query_search_parent);

        if (count($query_search) == 0) {
            $this->session->set_flashdata('error_message', $this->lang->line('no_search_result'));
            redirect(site_url('user/dashboard/'), 'refresh');
        } else {
            $page_data['query_search'] = $query_search;
        }

        $page_data['page_name'] = 'search_result';
        $page_data['page_title'] = $this->lang->line('search_result');

        $this->load->view('backend/index', $page_data);
    }

    function help_me($param1 = '') {
        $this->if_user_login();

        if ($param1 == 'stu') {
            $page_data['inner_page'] = 'help_me_part';
        }

        $page_data['page_name'] = 'help_me';
        $page_data['page_title'] = $this->lang->line('help_me');
        $this->load->view('backend/index', $page_data);
    }

    function help_me_writer() {
        $this->if_user_login();

        $page_data['page_name'] = 'help_me_writer';
        $page_data['page_title'] = $this->lang->line('help_me_writer');

        $this->load->view('backend/index', $page_data);
    }

    /*     * *** change language **** */

    function change_language($clicked_id) {
        $this->if_user_login();
        $data['lang'] = $clicked_id;
        $login_type = $this->session->userdata('login_type');
        $this->db->where($login_type . '_id', $this->session->userdata('login_user_id'));
        $this->db->update($login_type, $data);
        $this->session->set_flashdata('flash_message', $this->lang->line('change_language'));
        redirect(site_url('user/dashboard/'), 'refresh');
    }

    function no_access() {
        $this->if_user_login();
        $page_data['page_name'] = 'no_access';
        $this->load->view('backend/index', $page_data);
    }

    function students_to_specialists_print($employee_id) {
        $this->if_user_login();
        $page_data['employee_id'] = $employee_id;
        $this->load->view('backend/user/students_to_specialists_print', $page_data);
    }

    function quick_search() {
        $this->if_user_login();
        $page_data['query'] = $this->input->get("query");
        $this->load->view('backend/user/quick_search', $page_data);
    }

    function api_student_upload($student_id = '') {
        $this->if_user_login();

        $countfiles = count($_FILES['userfile']['tmp_name']);

        // Looping all files
        $response = array();
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['userfile']['name'][$i];
            $info = new SplFileInfo($filename);
            $uname = bin2hex(random_bytes(24));
            //$folder = 'uploads/student_documents/' . $student_id . '/';
            $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/student_documents/' . $student_id . '/';

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            // Upload file
            move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $folder . $uname . '.' . $info->getExtension());
            $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
            $name = $uname . '.' . $info->getExtension();
            array_push($response, array(
                'url' => $relative_path,
                'name' => $name
            ));
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    function re_phone() {
        $this->if_user_login();
        $re_phone = $this->db->get('employee')->result_array();

        $a = '966';
        $b = '';

        foreach ($re_phone as $row) {
            $c = $row['emergency_telephone'];
            echo $row['emergency_telephone'];
            echo '<br/>';
            $after_re = str_replace($a, $b, $c);

            echo $after_re;
            $data['emergency_telephone'] = $after_re;

            $this->db->where('employee_id', $row['employee_id']);
            $this->db->update('employee', $data);

            echo '<br/>';
            echo '<br/>';
        }
    }

    function poll_questions_print_view($poll_id, $answers) {
        $this->if_user_login();

        $page_data['poll_id'] = $poll_id;
        $page_data['page_title'] = $this->lang->line('questions_print');
        $this->load->view('backend/user/poll_questions_print_view', $page_data);
    }

    function load_question_type_poll($type, $poll_id) {
        $this->if_user_login();
        $page_data['question_type'] = $type;
        $page_data['poll_id'] = $poll_id;
        $this->load->view('backend/user/poll_add_' . $type, $page_data);
    }

    function manage_poll_question($poll_id = "", $task = "", $type = "") {
        $this->if_user_login();

        if ($task == 'add') {
            if ($type == 'multiple_choice') {
                $this->crud_model->add_multiple_choice_question_to_poll($poll_id);
            } elseif ($type == 'true_false') {
                $this->crud_model->add_true_false_question_to_poll($poll_id);
            } elseif ($type == 'fill_in_the_blanks') {
                $this->crud_model->add_fill_in_the_blanks_question_to_poll($poll_id);
            }

            $poll_en = $this->db->get_where('poll_manage', array('id' => $poll_id))->row()->encrypt_thread;

            redirect(site_url('user/poll_items/' . $poll_en), 'refresh');
        }
    }

    function manage_multiple_choices_options_poll() {
        $this->if_user_login();
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/user/poll_manage_multiple_choices_options', $page_data);
    }

    function take_online_poll($online_exam_send_id = "") {
        $this->if_user_login();

        $employee_id = $this->session->userdata('login_user_id');
        $employee_id = $this->session->userdata('login_user_id');

        $online_exam_id = $this->db->get_where('online_exam_send', array('online_exam_send_id' => $online_exam_send_id))->row()->online_exam_id;
        $employee_id = $this->session->userdata('login_user_id');

        $check = array('online_exam_send_id' => $online_exam_send_id, 'employee_id' => $employee_id, 'online_exam_id' => $online_exam_id);
        $taken = $this->db->where($check)->get('online_exam_result')->num_rows();

        $this->crud_model->change_online_exam_status_to_attended_for_employee($online_exam_send_id, $online_exam_id);

        $status = $this->crud_model->check_availability_for_employee($online_exam_send_id, $online_exam_id);

        if ($status == 'submitted') {
            $page_data['page_name'] = 'page_not_found';
        } else {
            $page_data['page_name'] = 'online_poll_take';
        }

        $page_data['page_title'] = $this->lang->line('poll');
        $page_data['online_exam_send_id'] = $online_exam_send_id;
        $page_data['online_exam_id'] = $online_exam_id;
        $page_data['exam_info'] = $this->db->get_where('online_exam', array('online_exam_id' => $online_exam_id));
        $page_data['exam_time'] = $this->db->get_where('online_exam_send', array('online_exam_send_id' => $online_exam_send_id));
        $this->load->view('backend/index', $page_data);
    }

    function submit_poll() {
        $this->if_user_login();

        $poll_send_id = $this->input->post('poll_send_id');
        $poll_id = $this->input->post('poll_id');
        $poll_send_times_id = $this->input->post('poll_send_times_id');

        $answer_script = array();
        $question_bank = $this->db->get_where('poll_items', array('poll_manage_id' => $poll_id))->result_array();

        foreach ($question_bank as $question) {

            $container_2 = array();
            if (isset($_POST[$question['id']])) {

                foreach ($this->input->post($question['id']) as $row) {
                    $submitted_answer = "";
                    if ($question['type'] == 'fill_in_the_blanks') {
                        $item_type = 2;
                        $suitable_words = array();
                        $suitable_words_array = explode(',', $row);
                        foreach ($suitable_words_array as $key) {
                            $key;
                            array_push($suitable_words, $key);
                        }
                        $submitted_answer = json_encode(array_map('trim', $suitable_words, JSON_UNESCAPED_UNICODE));
                        $submitted_answer_id = $suitable_words[0];
                    } else {
                        $item_type = 1;
                        array_push($container_2, strtolower($row));
                        $submitted_answer = json_encode($container_2, JSON_UNESCAPED_UNICODE);
                        $submitted_answer_id = $container_2[0];
                    }
                    $container = array(
                        "poll_items_id" => $question['id'],
                        "submitted_answer" => $submitted_answer,
                        "answer_id" => $submitted_answer_id,
                        "item_type" => $item_type
                    );
                }
            } else {
                $container = array(
                    "poll_items_id" => $question['id'],
                    "submitted_answer" => $submitted_answer,
                    "answer_id" => $submitted_answer_id,
                    "item_type" => $item_type
                );
            }

            array_push($answer_script, $container);
        }

        $answer_script_array = $answer_script;

        $this->crud_model->submit_poll_data($poll_send_id, $poll_id, json_encode($answer_script, JSON_UNESCAPED_UNICODE), $answer_script_array, $poll_send_times_id);
        redirect(site_url('user/dashboard'), 'refresh');
    }

    function poll_results($param1) {
        $this->if_user_login();

        $poll_en = $this->db->get_where('poll_manage', array('encrypt_thread' => $param1))->num_rows();

        if ($poll_en > 0) {
            $page_data['id_poll'] = $this->db->get_where('poll_manage', array('encrypt_thread' => $param1))->row()->id;
            $page_data['page_name'] = 'poll_results';
            $page_data['page_title'] = $this->lang->line('Poll Results');

            $this->load->view('backend/index', $page_data);
        } else {
            redirect(base_url() . 'Error_page', 'refresh');
            return;
        }
    }

    function set_poll_date() {
        $this->if_user_login();

        $page_data['page_name'] = 'set_poll_date';
        $page_data['page_title'] = $this->lang->line('set_poll');

        $this->load->view('backend/index', $page_data);
    }

    function set_poll_for_user($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {

            $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

            $poll_send_times_data['poll_id'] = $this->input->post('poll_id');
            $poll_send_times_data['date_send'] = date('Y-m-d H:i:s');
            $poll_send_times_data['expires_in'] = $this->input->post('expires_in');

            $this->db->insert('poll_send_times', $poll_send_times_data);
            $poll_send_times_id = $this->db->insert_id();

            $poll_for = $this->input->post('poll_for');

            if ($poll_for == 100) {

                $all_employee = $this->db->get_where('employee', array('active' => 1))->result_array();

                $this->db->select('a.parent_id AS parent_id, b.student_id');
                $this->db->from('parent a');
                $this->db->join('student b', 'b.parent_id = a.parent_id', 'left');
                $this->db->join('enroll c', 'c.student_id = b.student_id', 'left');
                $this->db->where("c.year", $running_year);
                $this->db->where("c.status", 0);
                $all_parent = $this->db->get()->result_array();

                foreach ($all_employee as $all_employee_row) {
                    $data['poll_id'] = $this->input->post('poll_id');
                    $data['user_id'] = $all_employee_row['employee_id'];
                    $data['user_type'] = 'employee';
                    $data['date_send'] = date('Y-m-d H:i:s');
                    $data['expires_in'] = $this->input->post('expires_in');
                    $data['class_id'] = $all_employee_row['class_id'];
                    $data['poll_send_times_id'] = $poll_send_times_id;

                    $this->db->insert('poll_send', $data);
                }

                foreach ($all_parent as $all_parent_row) {
                    $data['poll_id'] = $this->input->post('poll_id');
                    $data['user_id'] = $all_parent_row['parent_id'];
                    $data['user_type'] = 'parent';
                    $data['date_send'] = date('Y-m-d H:i:s');
                    $data['expires_in'] = $this->input->post('expires_in');
                    $data['class_id'] = '300';
                    $data['poll_send_times_id'] = $poll_send_times_id;

                    $this->db->insert('poll_send', $data);
                }
            } elseif ($poll_for == 300) {

                $this->db->select('a.parent_id AS parent_id, b.student_id');
                $this->db->from('parent a');
                $this->db->join('student b', 'b.parent_id = a.parent_id', 'left');
                $this->db->join('enroll c', 'c.student_id = b.student_id', 'left');
                $this->db->where("c.year", $running_year);
                $this->db->where("c.status", 0);
                $all_parent = $this->db->get()->result_array();

                foreach ($all_parent as $all_parent_row) {
                    $data['poll_id'] = $this->input->post('poll_id');
                    $data['user_id'] = $all_parent_row['parent_id'];
                    $data['user_type'] = 'parent';
                    $data['date_send'] = date('Y-m-d H:i:s');
                    $data['expires_in'] = $this->input->post('expires_in');
                    $data['class_id'] = '300';
                    $data['poll_send_times_id'] = $poll_send_times_id;

                    $this->db->insert('poll_send', $data);
                }
            } elseif ($poll_for == 200) {
                $all_employee = $this->db->get_where('employee', array('active' => 1))->result_array();

                foreach ($all_employee as $all_employee_row) {
                    $data['poll_id'] = $this->input->post('poll_id');
                    $data['user_id'] = $all_employee_row['employee_id'];
                    $data['user_type'] = 'employee';
                    $data['date_send'] = date('Y-m-d H:i:s');
                    $data['expires_in'] = $this->input->post('expires_in');
                    $data['class_id'] = $all_employee_row['class_id'];
                    $data['poll_send_times_id'] = $poll_send_times_id;

                    $this->db->insert('poll_send', $data);
                }
            } else {
                $all_employee = $this->db->get_where('employee', array('class_id' => $poll_for, 'active' => 1))->result_array();

                foreach ($all_employee as $all_employee_row) {
                    $data['poll_id'] = $this->input->post('poll_id');
                    $data['user_id'] = $all_employee_row['employee_id'];
                    $data['user_type'] = 'employee';
                    $data['date_send'] = date('Y-m-d H:i:s');
                    $data['expires_in'] = $this->input->post('expires_in');
                    $data['class_id'] = $all_employee_row['class_id'];
                    $data['poll_send_times_id'] = $poll_send_times_id;

                    $this->db->insert('poll_send', $data);
                }
            }

            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/poll'), 'refresh');
        }
        if ($param1 == 'do_update') {
            
        }

        if ($param1 == 'delete') {
            
        }
    }

    function check_permission_page() {
        $this->if_user_login();
        echo $this->session->userdata("employee_id") . '<br/>';
        if (is_allowed("student", "view_all_students")) {
            echo 'user allowed to access student -> view_all_students<br/>';
        }

        if (is_allowed("student", "view_the_student_file")) {
            echo 'user allowed to access student -> view_the_student_file<br/>';
        }

        echo is_allowed("raising_student", "the_possibility_of_upgrading_students") ? 'allowed' : 'denied';
    }

    function employee_evaluation_results($history_evaluation_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'employee_evaluation_results';
        $page_data['history_evaluation_id'] = $history_evaluation_id;

        $page_data['page_title'] = $this->lang->line('employee_evaluation_results');

        $this->load->view('backend/index', $page_data);
    }

    function employee_evaluation_results_u($history_evaluation_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'employee_evaluation_results_u';
        $page_data['history_evaluation_id'] = $history_evaluation_id;

        $page_data['page_title'] = $this->lang->line('employee_evaluation_results');

        $this->load->view('backend/index', $page_data);
    }

    public function lang($language = "") {
        $this->if_user_login();
        //$language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);

        //$data['lang'] = $language;
        //$login_type = $this->session->userdata('login_type');
        //$this->db->where($login_type . '_id', $this->session->userdata('login_user_id'));
        //$this->db->update($login_type, $data);
        //$this->session->set_userdata('site_lang', $language);
        //redirect(site_url('user/dashboard/'), 'refresh');
    }

    function print_all_id_5() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_all_id_5';
        $this->load->view('backend/user/print_all_id_5');
    }

    function print_all_id_6() {
        $this->if_user_login();
        $page_data['page_name'] = 'print_all_id_6';
        $this->load->view('backend/user/print_all_id_6');
    }

    function general_management($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $account_type = $this->session->userdata('login_type');

        if ($account_type == 'technical_support' || $account_type == 'admin') {

            if ($param1 == 'create') {
                $this->processes_model->add_admin();
                $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
                redirect(site_url('user/general_management/'), 'refresh');
            }

            if ($param1 == 'edit') {
                $this->processes_model->edit_admin($param2);
                $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
                redirect(site_url('user/general_management/'), 'refresh');
            }

            if ($param1 == 'delete') {
                $this->db->where('parent_id', $param2);
                $this->db->delete('admin');
            }

            $page_data['page_title'] = $this->lang->line('general_management');
            $page_data['page_name'] = 'general_management';

            $this->load->view('backend/index', $page_data);
        }
    }

    function admin_add() {
        $this->if_user_login();

        $account_type = $this->session->userdata('login_type');

        if ($account_type == 'technical_support' || $account_type == 'admin') {
            $page_data['page_name'] = 'admin_add';

            $this->load->view('backend/index', $page_data);
        }
    }

    function admin_edit($admin_id) {
        $this->if_user_login();
        $account_type = $this->session->userdata('login_type');

        if ($account_type == 'technical_support' || $account_type == 'admin') {
            $admin_en = $this->db->get_where('admin', array('encrypt_thread' => $admin_id))->num_rows();

            if ($admin_en > 0) {
                $page_data['admin_id'] = $this->db->get_where('admin', array('encrypt_thread' => $admin_id))->row()->admin_id;
                $page_data['page_name'] = 'admin_edit';
                $page_data['page_title'] = $this->lang->line('poll_items');

                $this->load->view('backend/index', $page_data);
            } else {
                redirect(base_url() . 'Error_page', 'refresh');
                return;
            }
        }
    }

    function change_password_admin() {
        $this->if_user_login();
        $admin_id = $_POST['adminId'];
        $password = $_POST['password'];

        $data['password'] = sha1($password);
        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin', $data);

        $this->session->set_flashdata('flash_message', $this->lang->line('password_updated'));
        redirect(site_url('user/employee_information/'), 'refresh');
    }

    function change_password_for_first_use() {
        $this->if_user_login();

        $data['password'] = sha1($_POST['new_password']);

        if ($this->session->userdata('login_type') == 'employee') {
            $this->db->where('employee_id', $this->session->userdata('login_user_id'));
            $this->db->update('employee', $data);
        } elseif ($this->session->userdata('login_type') == 'parent') {
            $this->db->where('parent_id', $this->session->userdata('login_user_id'));
            $this->db->update('parent', $data);
        }
    }

    function home_wizard($student_id = '', $plan_id = '', $month_id = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'home_wizard';

        $page_data['student_id'] = $student_id;
        $page_data['plan_id'] = $plan_id;
        $page_data['month_id'] = $month_id;

        $page_data['page_title'] = $this->lang->line('home_plan');

        $this->load->view('backend/index', $page_data);
    }

    function home_plan() {
        $this->if_user_login();
        $page_data['page_name'] = 'home_plan';
        $page_data['page_title'] = $this->lang->line('home_plan');
        $this->load->view('backend/index', $page_data);
    }

    function fetch_home_plan($home_plan_id) {
        $this->if_user_login();

        $homePlan = $this->db->select("*")->from("home_plan")->where("id", $home_plan_id)->get()->result_array()[0];
        $steps = $this->db->select("*")->from("home_plan_steps")->where("home_plan_id", $home_plan_id)->get()->result_array();
        $analysis = $this->db->select("*")->from("home_plan_analysis")->where("home_plan_id", $home_plan_id)->get()->result_array();

        $data = array(
            'monthPlan' => $homePlan,
            'steps' => $steps,
            "analysis" => $analysis
        );

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function fetch_home_plans($level, $employee_id, $month_id, $section_id = '') {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $results = array();

        $job_title_id = $this->db->select("job_title_id")->from('employee')->where("employee_id", $employee_id)->get()->result_array()[0]['job_title_id'];

        if (!empty($section_id)) {
            if ($level == 1) {
                $job_title_id = 4;
            }
        }

        if ($level == 2) {
            $students = $this->db->select("a.student_id, b.name")->from('students_to_specialists a')->join("student b", 'a.student_id = b.student_id', 'left')->where(array('a.employee_id' => $employee_id, 'a.year' => $year, 'a.active' => 1))->get()->result_array();
        } else {
            $this->db->select('a.name, a.student_id');
            $this->db->from('student a');
            $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
            $this->db->join('section c', 'b.section_id = c.section_id', 'left');
            $this->db->where("b.year", $year);

            if (empty($section_id)) {
                $this->db->group_start();
                $this->db->where('c.teacher_id', $employee_id);
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

            $plans_id = $this->db->select("a.id, a.plan_name, a.assessment_id, b.assessment_name, COUNT(*) as count")->from("student_plan a")->join('assessment_step c', "a.assessment_id = c.assessment_id", "left")->join('student_assessment b', "a.assessment_id = b.id", "left")->where(array(
                        'c.specialty_id' => $job_title_id,
                        'a.student_id' => $student_id,
                        'a.running_year' => $year,
                        'a.active' => '1'
                    ))->group_by("1")->having("count > 0")->get()->result_array();

            if (empty($plans_id)) {
                $plans_id = array();
            } else {
                
            }
            $plans = array();
            foreach ($plans_id as $planEntry) {
                $plan_id = $planEntry['id'];
                $home_plan_id = -1;

                if ($plan_id != -1) {
                    $home_plan_id = $this->db->select("id")->from("home_plan")->where(array(
                                'plan_id' => $planEntry['id'],
                                'student_id' => $student_id,
                                'month_id' => $month_id,
                                'year' => $year
                            ))->get()->result_array();

                    if (empty($home_plan_id)) {
                        $home_plan_id = -1;
                    } else {
                        $home_plan_id = $home_plan_id[0]['id'];
                    }
                }

                $plan_info = array(
                    'plan_id' => $plan_id,
                    'plan_name' => $planEntry['plan_name'],
                    'assessment_id' => $planEntry['assessment_id'],
                    'student_id' => $student_id,
                    'assessment_name' => $planEntry['assessment_name'],
                    'home_plan_id' => $home_plan_id
                );

                array_push($plans, $plan_info);
            }

            $info = array(
                'student_id' => $student_id,
                'name' => $student['name'],
                'plans' => $plans
            );

            array_push($results, $info);
        }
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function place_student_home_plan() {
        $this->if_user_login();

        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $inputJSON = file_get_contents('php://input');
        $rawData = json_decode($inputJSON, TRUE);
        $home_plan = $rawData['home_plan'];

        $home_plan["user_id"] = $this->session->userdata('login_user_id');
        $home_plan["datetime_stamp"] = date('Y-m-d H:i:s');
        $home_plan['year'] = $year;
        $this->db->insert('home_plan', $home_plan);

        $home_plan_id = $this->db->insert_id();
        $rawSteps = $rawData['steps'];

        $rawAnalysis = $rawData['analysis'];

        $steps = array();

        foreach ($rawSteps as $step) {
            $newStep = array();
            $newStep["home_plan_id"] = $home_plan_id;
            $newStep["step_id"] = $step;

            array_push($steps, $newStep);
        }
        $this->db->insert_batch('home_plan_steps', $steps);

        $analysis = array();

        foreach ($rawAnalysis as $analysisEntry) {
            $entry = array(
                'analysis_id' => $analysisEntry['analysis_id'],
                'step_id' => $analysisEntry['step_id'],
                'home_plan_id' => $home_plan_id
            );
            array_push($analysis, $entry);
        }

        $this->db->insert_batch('home_plan_analysis', $analysis);

        echo json_encode($home_plan_id, JSON_UNESCAPED_UNICODE);
    }

    function print_home_plan($type = '', $print_id = '') {
        $this->if_user_login();

        $type = 'home_plan';

        $page_data['page_name'] = 'print_home_plan';
        $page_data['page_title'] = $this->lang->line('print_home_plan');
        $page_data['print_id'] = $print_id;
        $page_data['print_type'] = $type;

        $this->load->view('backend/user/print_home_plan', $page_data);
    }

    function home_list($home_plan_id) {
        $this->if_user_login();

        $page_data['page_name'] = 'home_list';
        $page_data['page_title'] = $this->lang->line('home_list');
        $page_data['home_plan_id'] = $home_plan_id;

        $this->load->view('backend/index', $page_data);
    }

    function post_home_analysis() {
        $this->if_user_login();
        $inputJSON = file_get_contents('php://input');
        $data = json_decode($inputJSON, TRUE);

        $step = $data['step'];
        $analysisGroup = $data['analysis'];

        $this->db->where("step_id", $step['step_id']);
        $this->db->where("home_plan_id", $step['home_plan_id']);
        $this->db->delete('home_plan_steps');

        $this->db->where("step_id", $step['step_id']);
        $this->db->where("home_plan_id", $step['home_plan_id']);
        $this->db->delete('home_plan_analysis');

        $this->db->insert("home_plan_steps", $step);

        foreach ($analysisGroup as $analysis) {

            $training_id = $this->db->select("id")->from("training_analysis")->where(array(
                        'home_plan_id' => $step['home_plan_id'],
                        'analysis_id' => $analysis['analysis_id']
                    ))->get()->result_array();

            echo json_encode($training_id, JSON_UNESCAPED_UNICODE);

            if (!empty($training_id)) {
                $analysis['training_procedures_id'] = $training_id[0]['id'];
            }

            $this->db->insert("home_plan_analysis", $analysis);
        }

        echo json_encode($step, JSON_UNESCAPED_UNICODE);
    }

    function training_procedures() {
        $this->if_user_login();

        if ($_POST['analysis_teaching_procedures'] != null || $_POST['analysis_teaching_procedures'] != 0) {
            $data['training_procedures'] = $_POST['training_procedures'];
            $data['published'] = $_POST['published'];
            $this->db->where('id', $_POST['analysis_teaching_procedures']);
            $this->db->update('training_procedures', $data);
        } else {

            $data['home_plan_id'] = $_POST['home_plan_id'];
            $data['analysis_id'] = $_POST['analysis_id'];
            $data['training_procedures'] = $_POST['training_procedures'];
            $data['published'] = $_POST['published'];
            $data['user_id'] = $this->session->userdata('login_user_id');
            $data['timestamp'] = date("Y-m-d H:i:s");
            $this->db->insert('training_procedures', $data);

            $training_procedures_id = $this->db->insert_id();

            $teaching_procedures_for_edit = $this->db->get_where('training_analysis', array('home_plan_id' => $_POST['home_plan_id'], 'analysis_id' => $_POST['analysis_id']));
            if ($teaching_procedures_for_edit->num_rows() > 0) {
                $data2['training_procedures_id'] = $training_procedures_id;

                $this->db->where('home_plan_id', $_POST['home_plan_id']);
                $this->db->where('analysis_id', $_POST['analysis_id']);
                $this->db->update('training_analysis', $data2);

                $data3['training_procedures_id'] = $teaching_procedures_for_edit->row()->id;
            } else {
                $data2['training_procedures_id'] = $training_procedures_id;

                $data2['home_plan_id'] = $_POST['home_plan_id'];
                $data2['analysis_id'] = $_POST['analysis_id'];
                $data2['timestamp'] = date("Y-m-d H:i:s");
                $this->db->insert('training_analysis', $data2);
                $training_analysis_id = $this->db->insert_id();
                $data3['training_procedures_id'] = $training_analysis_id;
            }

            $this->db->where('home_plan_id', $_POST['home_plan_id']);
            $this->db->where('analysis_id', $_POST['analysis_id']);
            $this->db->update('home_plan_analysis', $data3);
        }
    }

    function training_procedures_found() {
        $this->if_user_login();

        $teaching_procedures_for_edit = $this->db->get_where('training_analysis', array('home_plan_id' => $_POST['home_plan_id'], 'analysis_id' => $_POST['analysis_id']));

        if ($teaching_procedures_for_edit->num_rows() > 0) {
            $teaching_procedures_data = $teaching_procedures_for_edit->row()->id;

            $data2['training_procedures_id'] = $_POST['training_procedures'];

            $this->db->where('id', $teaching_procedures_data);
            $this->db->update('training_analysis', $data2);
        } else {
            $data2['home_plan_id'] = $_POST['home_plan_id'];
            $data2['analysis_id'] = $_POST['analysis_id'];
            $data2['training_procedures_id'] = $_POST['training_procedures'];
            $data2['timestamp'] = date("Y-m-d H:i:s");
            $this->db->insert('training_analysis', $data2);
        }
    }

    function activity_tracking() {
        $this->if_user_login();
        $page_data['page_name'] = 'activity_tracking';
        $page_data['page_title'] = $this->lang->line('activity_tracking');

        $this->load->view('backend/index', $page_data);
    }

    function activity_tracking_information($class_id = '') {
        $this->if_user_login();

        if ($class_id != 0) {
            $page_data['inner_page'] = 'activity_tracking_information';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'activity_tracking';
        $page_data['page_title'] = $this->lang->line('activity_tracking');

        $this->load->view('backend/index', $page_data);
    }

    function activity_tracking_information_by_time() {
        $this->if_user_login();

        $class_id = $this->input->post('class_id');

        $page_data['inner_page'] = 'activity_tracking_information_view';
        $page_data['class_id'] = $class_id;
        $page_data['timestamp'] = strtotime($this->input->post('timestamp'));
        $page_data['page_name'] = 'activity_tracking_time';
        $page_data['page_title'] = $this->lang->line('activity_tracking');

        $this->load->view('backend/index', $page_data);
    }

    function activity_tracking_information_view($class_id = '', $timestamp = '') {
        $this->if_user_login();

        if ($class_id != null) {
            $page_data['inner_page'] = 'academics_activity_view_1';
            $page_data['class_id'] = $this->db->get_where('class', array('encrypt_thread' => $class_id))->row()->class_id;
            $page_data['timestamp'] = $timestamp;
            $page_data['page_name'] = 'activity_tracking_time';
            $page_data['page_title'] = $this->lang->line('activity_tracking');
            $this->load->view('backend/index', $page_data);
        } else {
            $page_data['page_name'] = 'activity_tracking_time';
            $page_data['page_title'] = $this->lang->line('activity_tracking');
            $this->load->view('backend/index', $page_data);
        }
    }

    function status_changed() {
        $this->if_user_login();

        $login_type = $this->session->userdata('login_type');

        if ($login_type == 'employee') {
            $data['online'] = $_POST['online'];

            $this->db->where('employee_id', $this->session->userdata('login_user_id'));
            $this->db->update('employee', $data);
        }

        if ($login_type == 'parent') {
            $data['online'] = $_POST['online'];

            $this->db->where('parent_id', $this->session->userdata('login_user_id'));
            $this->db->update('parent', $data);
        }
    }

    function platform_registrations() {
        $this->if_user_login();

        $page_data['page_name'] = 'platform_registrations';
        $page_data['page_title'] = '';

        $this->load->view('backend/index', $page_data);
    }

    function staff_login_to_platform($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'staff_login_to_platform_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'staff_login_to_platform';
        $page_data['page_title'] = $this->lang->line('platform_logins');

        $this->load->view('backend/index', $page_data);
    }

    function staff_login_to_platform_view($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'staff_login_to_platform_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'staff_login_to_platform';
        $page_data['page_title'] = $this->lang->line('platform_logins');

        $this->load->view('backend/index', $page_data);
    }

    function parents_login_to_platform($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'parents_login_to_platform_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'parents_login_to_platform';
        $page_data['page_title'] = $this->lang->line('platform_logins');

        $this->load->view('backend/index', $page_data);
    }

    function parents_login_to_platform_view($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'parents_login_to_platform_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'parents_login_to_platform';
        $page_data['page_title'] = $this->lang->line('platform_logins');

        $this->load->view('backend/index', $page_data);
    }

    function administration_activity($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'administration_activity_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'administration_activity';
        $page_data['page_title'] = $this->lang->line('administration_activity');

        $this->load->view('backend/index', $page_data);
    }

    function administration_activity_view($class_id = '') {
        $this->if_user_login();

        if ($class_id != null || $class_id > 0) {
            $page_data['inner_page'] = 'administration_activity_view';
            $page_data['class_id'] = $class_id;
        }

        $page_data['page_name'] = 'administration_activity';
        $page_data['page_title'] = $this->lang->line('administration_activity');

        $this->load->view('backend/index', $page_data);
    }

    function academics_activity($class_id = '') {
        $this->if_user_login();

        if ($class_id != null) {

            $class_en = $this->db->get_where('class', array('encrypt_thread' => $class_id))->num_rows();

            if ($class_en > 0) {

                $page_data['inner_page'] = 'academics_activity_view';
                $page_data['class_id'] = $this->db->get_where('class', array('encrypt_thread' => $class_id))->row()->class_id;
                academics_activity_view($page_data['class_id']);
            } else {
                redirect(base_url() . 'Error_page', 'refresh');
                return;
            }
        } else {
            $page_data['page_name'] = 'academics_activity';
            $page_data['page_title'] = $this->lang->line('academics_activity');
            $this->load->view('backend/index', $page_data);
        }
    }

    function academics_activity_view($class_id = '') {
        $this->if_user_login();
        $class_en = $this->db->get_where('class', array('encrypt_thread' => $class_id))->num_rows();

        if ($class_en != null || $class_en > 0) {
            $page_data['inner_page'] = 'academics_activity_view';
            $page_data['class_id'] = $this->db->get_where('class', array('encrypt_thread' => $class_id))->row()->class_id;
        }

        $page_data['page_name'] = 'academics_activity';
        $page_data['page_title'] = $this->lang->line('academics_activity');

        $this->load->view('backend/index', $page_data);
    }

    function activity_tracking_information_view_parent($class_id = '') {
        $this->if_user_login();

        $page_data['inner_page'] = 'activity_tracking_information_view_parent';
        $page_data['class_id'] = $class_id;
        $page_data['page_name'] = 'activity_tracking';
        $page_data['page_title'] = $this->lang->line('activity_tracking');

        $this->load->view('backend/index', $page_data);
    }

    function video() {
        $this->if_user_login();

        $page_data['page_name'] = 'video';
        $page_data['page_title'] = $this->lang->line('video');

        $this->load->view('backend/index', $page_data);
    }

    function conditions_registration_form($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add_conditions_registration_form') {
            $data['conditions'] = $this->input->post('conditions');
            $this->db->insert('conditions_registration_form', $data);
            redirect(site_url('user/conditions_registration_form/'), 'refresh');
        }


        if ($param1 == 'edit_conditions_registration_form') {
            $data['conditions'] = $this->input->post('conditions');
            $this->db->where('id', $this->input->post('conditions_id'));
            $this->db->update('conditions_registration_form', $data);
            redirect(site_url('user/conditions_registration_form/'), 'refresh');
        }

        $page_data['page_name'] = 'conditions_registration_form';
        $page_data['page_title'] = $this->lang->line('conditions_registration_form');
        $this->load->view('backend/index', $page_data);
    }

    function blockUnblock_publish_conditions_registration_form() {
        $this->if_user_login();
        $emp = $_POST["id"];
        $data['publish'] = $_POST["st"];
        $this->db->where('id', $emp);
        $this->db->update('conditions_registration_form', $data);

        echo $_POST["st"];
    }

    function approvals_items_guardian($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add_approvals_items_guardian') {
            $data['guardian'] = $this->input->post('guardian');
            $this->db->insert('approvals_items_guardian', $data);
            redirect(site_url('user/approvals_items_guardian/'), 'refresh');
        }


        if ($param1 == 'edit_approvals_items_guardian') {
            $data['guardian'] = $this->input->post('guardian');
            $this->db->where('id', $this->input->post('guardian_id'));
            $this->db->update('approvals_items_guardian', $data);
            redirect(site_url('user/approvals_items_guardian/'), 'refresh');
        }

        $page_data['page_name'] = 'approvals_items_guardian';
        $page_data['page_title'] = $this->lang->line('approvals_items_guardian');
        $this->load->view('backend/index', $page_data);
    }

    function blockUnblock_publish_approvals_items_guardian() {
        $this->if_user_login();
        $emp = $_POST["id"];
        $data['publish'] = $_POST["st"];
        $this->db->where('id', $emp);
        $this->db->update('approvals_items_guardian', $data);

        echo $_POST["st"];
    }

    function poll($param1 = '', $param2 = '') {
        $this->if_user_login();

        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        if ($param1 == 'create') {
            if ($this->input->post('name') != '') {
                $poll_en = $this->processes_model->create_poll();

                if ($poll_en != '') {
                    $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
                    redirect(site_url('user/poll_items/' . $poll_en), 'refresh');
                } else {
                    redirect(base_url() . 'Error_page', 'refresh');
                    return;
                }
            } else {
                $this->session->set_flashdata('error_message', $this->lang->line('make_sure_to_select_valid_class_') . ',' . $this->lang->line('_section_and_subject'));
                redirect(site_url('user/poll'), 'refresh');
            }
        }
        if ($param1 == 'edit') {
            if ($this->input->post('class_id') != '' || $this->input->post('job_title_id') != '') {
                $this->processes_model->update_evaluation();
                $this->session->set_flashdata('flash_message', $this->lang->line('data_updated_successfully'));
                redirect(site_url('user/poll'), 'refresh');
            }
        }

        if ($param1 == 'delete') {

            $query = $this->db->get_where('history_evaluation_employee', array('evaluation_management_id' => $param2));

            if ($query->num_rows() < 1) {
                $this->db->where('evaluation_id', $param2);
                $this->db->delete('evaluation_items');
                $this->db->where('evaluation_management_id', $param2);
                $this->db->delete('evaluation_management');
                $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
                redirect(site_url('user/evaluation_management'), 'refresh');
            } else {

                $data['status'] = 'disabled';
                $this->db->where('evaluation_management_id', $param2);
                $this->db->update('evaluation_management', $data);
                $this->session->set_flashdata('error_message', $this->lang->line('disabled_assessment'));
                redirect(site_url('user/evaluation_management'), 'refresh');
            }
        }

        $page_data['page_name'] = 'poll';
        $page_data['status'] = 'active';
        $page_data['page_title'] = $this->lang->line('poll');
        $this->load->view('backend/index', $page_data);
    }

    function poll_add() {
        $this->if_user_login();

        $page_data['page_name'] = 'poll_add';
        $page_data['page_title'] = $this->lang->line('poll_add');
        $this->load->view('backend/index', $page_data);
    }

    function poll_items($param1 = '') {
        $this->if_user_login();

        $poll_en = $this->db->get_where('poll_manage', array('encrypt_thread' => $param1))->num_rows();

        if ($poll_en > 0) {
            $page_data['id_poll'] = $this->db->get_where('poll_manage', array('encrypt_thread' => $param1))->row()->id;
            $page_data['page_name'] = 'poll_items';
            $page_data['page_title'] = $this->lang->line('poll_items');

            $this->load->view('backend/index', $page_data);
        } else {
            redirect(base_url() . 'Error_page', 'refresh');
            return;
        }
    }

    function data_poll_items($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();

        if ($param1 == 'add') {
            if ($this->input->post('poll_items') != '') {
                $this->processes_model->create_poll_items();

                $poll_en = $this->db->get_where('poll_manage', array('id' => $this->input->post('poll_id')))->row()->encrypt_thread;

                $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
                redirect(site_url('user/poll_items/' . $poll_en), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', $this->lang->line('please_make_sure') . ' ' . $this->lang->line('evaluation_items') . ' - ' . $this->lang->line('field_evaluation'));
                redirect(site_url('user/evaluation_items/' . $this->input->post('evaluation_id')), 'refresh');
            }
            redirect(site_url('user/evaluation_items/' . $this->input->post('evaluation_id')), 'refresh');
        }

        if ($param1 == 'do_update') {
            if ($this->input->post('evaluation_items') != '' && $this->input->post('item_mark') != '') {

                $data_val = explode("-", $param2);
                $evaluation_id = $data_val[0];
                $evaluation_items_id = $data_val[1];

                $evaluation_items_id = $this->input->post('evaluation_items_id');
                $this->processes_model->edit_evaluation_items($param2);
                $this->session->set_flashdata('flash_message', $this->lang->line('data_updated_successfully'));
                redirect(site_url('user/evaluation_items/' . $evaluation_id), 'refresh');
            }
        }

        if ($param1 == 'delete') {

            $ex_param2 = explode('-', $param2);
            $evaluation_items_id = $ex_param2[0];
            $evaluation_id = $ex_param2[1];

            $this->db->where('evaluation_items_id', $evaluation_items_id);
            $this->db->delete('evaluation_items');

            $page_data['evaluation_id'] = $evaluation_id;
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/evaluation_items/' . $evaluation_id), 'refresh');
        }
    }

    function user_analytics() {
        $this->if_user_login();

        $page_data['page_name'] = 'user_analytics';
        $page_data['page_title'] = $this->lang->line('User Analytics');

        $this->load->view('backend/index', $page_data);
    }

    function group_message($param1 = "group_message_home", $param2 = "") {
        $this->if_user_login();

        $max_size = 2097152;
        if ($param1 == "create_group") {
            $this->crud_model->create_group();
        } elseif ($param1 == "edit_group") {
            $this->crud_model->update_group($param2);
        } elseif ($param1 == 'group_message_read') {
            $page_data['current_message_thread_code'] = $param2;
        } else if ($param1 == 'send_reply') {
            if (!file_exists('uploads/group_messaging_attached_file/')) {
                $oldmask = umask(0);  // helpful when used in linux server
                mkdir('uploads/group_messaging_attached_file/', 0777);
            }
            if ($_FILES['attached_file_on_messaging']['name'] != "") {
                if ($_FILES['attached_file_on_messaging']['size'] > $max_size) {
                    $this->session->set_flashdata('error_message', 'file_size_can_not_be_larger_that_2_Megabyte');
                    redirect(site_url('user/group_message/group_message_read/' . $param2), 'refresh');
                } else {
                    $file_path = 'uploads/group_messaging_attached_file/' . $_FILES['attached_file_on_messaging']['name'];
                    move_uploaded_file($_FILES['attached_file_on_messaging']['tmp_name'], $file_path);
                }
            }

            $this->crud_model->send_reply_group_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', 'message_sent!');
            redirect(site_url('user/group_message/group_message_read/' . $param2), 'refresh');
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'group_message';
        $page_data['page_title'] = $this->lang->line('group_messaging');
        $page_data['message_thread_code'] = $param2;
        $this->load->view('backend/index', $page_data);
    }

    function print_assessment_from_mang($assessment_id) {
        $this->if_user_login();

        $this->db->select("d.assessment_name, c.genre_name, b.goal_name, b.level,  a.step_name, a.step_measure");
        $this->db->from('assessment_step a');
        $this->db->join("assessment_goal b", "a.goal_id = b.id", "left");
        $this->db->join("assessment_genre c", "a.genre_id = c.id", "left");
        $this->db->join("student_assessment d", "a.assessment_id = d.id", "left");
        $this->db->where("a.assessment_id", $assessment_id);
        $assessment_data = $this->db->get()->result_array();

        $page_data['assessment_id'] = $assessment_id;
        $page_data['page_name'] = 'print_assessment_from_mang';
        $page_data['page_title'] = $this->lang->line('print_assessment');

        $myarray = json_encode($assessment_data, JSON_UNESCAPED_UNICODE);

        $page_data['data'] = $myarray;

        $this->load->view('backend/user/print_assessment_from_mang', $page_data);
    }

    function group_message_delete($param1 = '') {
        $this->if_user_login();

        $group_message_thread_id = $_POST['id'];
        $data['active'] = 0;
        $this->db->where('group_message_thread_id', $group_message_thread_id);
        $this->db->update('group_message_thread', $data);

        echo '0';
        return;
    }

    function ebaa_ana() {
        $this->if_user_login();
        set_time_limit(0);
        try {
            $co = 1;

            $this->db->select("id, assessment_id");
            $this->db->from('student_plan');
            $this->db->where("active", 1);
            $student_plan = $this->db->get()->result_array();
            echo 'Number of Plans: ' . count($student_plan) . ' <br/>';
            foreach ($student_plan as $student_plans) {
                echo 'Plan ID (' . $co++ . '): ' . $student_plans['id'] . '<br/>';
                $this->db->select("*");
                $this->db->from('student_plan_steps');
                $this->db->where("plan_id", $student_plans['id']);
                $this->db->where("active", 1);
                $student_plan_step = $this->db->get()->result_array();

                foreach ($student_plan_step as $student_plan_steps) {

                    $this->db->select("id");
                    $this->db->from('assessment_analysis');
                    $this->db->where("step_id", $student_plan_steps['step_id']);
                    $assessment_analysis_step = $this->db->get()->result_array();

                    $group_no = $this->db->select('standard_group_no')
                                    ->from('assessment_step')
                                    ->where('id', $student_plan_steps['step_id'])
                                    ->get()->result_array()[0]['standard_group_no'];

                    $batch = array();
                    foreach ($assessment_analysis_step as $assessment_analysis_steps) {

                        if ($group_no == 3) {
                            $standard_group_no = 11;
                        } elseif ($group_no == 4) {
                            $standard_group_no = 18;
                        } else {
                            $standard_group_no = 0;
                        }

                        $exists = $this->db->select("id, active")
                                        ->from("student_plan_analysis")
                                        ->where('plan_id', $student_plans['id'])
                                        ->where('step_id', $student_plan_steps['step_id'])
                                        ->where('analysis_id', $assessment_analysis_steps['id'])
                                        ->get()->result_array();

                        if (count($exists) == 0) {
                            $data = array();
                            $data['plan_id'] = $student_plans['id'];
                            $data['step_id'] = $student_plan_steps['step_id'];
                            $data['analysis_id'] = $assessment_analysis_steps['id'];
                            $data['active'] = 1; //$student_plan_steps['active'];
                            $data['analysis_progress'] = $standard_group_no;

                            array_push($batch, $data);
                        } else if ($exists[0]['active'] == 0) {
                            $entry['active'] = 1; //$student_plan_steps['active'];
                            $this->db->where('id', $exists[0]['id']);
                            $this->db->update('student_plan_analysis', $entry);
                        }

                        if (!empty($batch)) {
                            $this->db->insert_batch('student_plan_analysis', $batch);
                        }
                        $data_update['step_progress'] = $standard_group_no;
                        $this->db->where('id', $student_plan_steps['id']);
                        $this->db->update('student_plan_steps', $data_update);
                    }
                }
            }

            echo 'student_plan : done';
            echo '<br>';
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo 'Exception e....';
        }
    }

    function courses($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add') {
            $data['name'] = $this->input->post('name');
            $data['short_description'] = $this->input->post('short_description');
            $data['long_description'] = $this->input->post('long_description');
            $data['welcome_description'] = $this->input->post('welcome_description');
            $data['publish'] = $this->input->post('publish');
            $this->db->insert('course', $data);
            redirect(site_url('user/courses/'), 'refresh');
        }

        if ($param1 == 'do_update') {
            $data['name'] = $this->input->post('name');
            $data['short_description'] = $this->input->post('short_description');
            $data['long_description'] = $this->input->post('long_description');
            $data['welcome_description'] = $this->input->post('welcome_description');
            $data['publish'] = $this->input->post('publish');

            $this->db->where('id', $param2);
            $this->db->update('course', $data);

            redirect(site_url('user/courses/'), 'refresh');
        }

        if ($param1 == 'delete') {

            $data['active'] = 0;
            $this->db->where('id', $param2);
            $this->db->update('course', $data);
            echo 'true';
            return;
        }

        $page_data['page_name'] = 'courses';
        $page_data['page_title'] = $this->lang->line('courses');
        $this->load->view('backend/index', $page_data);
    }

    function add_course() {
        $this->if_user_login();

        $page_data['page_name'] = 'add_course';
        $page_data['page_title'] = $this->lang->line('add_course');
        $this->load->view('backend/index', $page_data);
    }

    function edit_course($id) {
        $this->if_user_login();

        $page_data['page_name'] = 'edit_course';
        $page_data['page_title'] = $this->lang->line('edit_course');
        $page_data['course_id'] = $id;
        $this->load->view('backend/index', $page_data);
    }

    function add_module() {
        $this->if_user_login();

        $page_data['page_name'] = 'add_module';
        $page_data['page_title'] = $this->lang->line('add_module');
        $this->load->view('backend/index', $page_data);
    }

    function edit_module($id) {
        $this->if_user_login();

        $page_data['page_name'] = 'edit_module';
        $page_data['page_title'] = $this->lang->line('edit_module');
        $this->load->view('backend/index', $page_data);
    }

    function check_name_course_for_add() {
        $this->if_user_login();
        $name = $_POST['name'];

        $checkdata = $this->db->get_where('course', array('name' => $name))->num_rows();

        if ($checkdata > 0) {
            echo 'false';
            return;
        } else {
            echo 'true';
            return;
        }
    }

    function check_name_course_for_edit() {
        $this->if_user_login();
        $name = $_POST['name'];

        $checkdata = $this->db->get_where('course', array('name' => $name))->num_rows();

        if ($checkdata > 0) {
            $old_name = $this->db->get_where('course', array('name' => $name))->row()->name;
            if ($old_name == $name) {
                echo 'this_old_name';
                return;
            } else {
                echo 'false';
                return;
            }
        } else {
            echo 'true';
            return;
        }
    }

    function check_name_module_for_add() {
        $this->if_user_login();
        $name = $_POST['name'];
        $course_id = $_POST['course_id'];

        $checkdata = $this->db->get_where('module', array('course_id' => $course_id, 'name' => $name))->num_rows();

        if ($checkdata > 0) {
            echo 'false';
            return;
        } else {
            echo 'true';
            return;
        }
    }

    function check_name_module_for_edit() {
        $this->if_user_login();
        $name = $_POST['name'];
        $course_id = $_POST['course_id'];

        $checkdata = $this->db->get_where('module', array('course_id' => $course_id, 'name' => $name))->num_rows();

        if ($checkdata > 0) {
            $old_name = $this->db->get_where('module', array('course_id' => $course_id, 'name' => $name))->row()->name;
            if ($old_name == $name) {
                echo 'this_old_name';
                return;
            } else {
                echo 'true';
                return;
            }
        } else {
            echo 'true';
            return;
        }
    }

    function module($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {
            $data['name'] = $this->input->post('name');
            $data['course_id'] = $this->input->post('course_id');
            $data['arrangement'] = $this->input->post('arrangement');

            $this->db->insert('module', $data);
            redirect(site_url('user/courses/'), 'refresh');
        }

        if ($param1 == 'do_update') {

            $data['name'] = $this->input->post('name');
            $data['arrangement'] = $this->input->post('arrangement');

            $this->db->where('id', $param2);
            $this->db->update('module', $data);

            redirect(site_url('user/courses/'), 'refresh');
        }

        if ($param1 == 'delete') {

            $data['active'] = 0;

            $this->db->where('id', $param2);
            $this->db->update('module', $data);
            echo 'true';
            return;
        }
    }

    function lesson($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add') {

            $data['course_id'] = $this->input->post('course_id');
            $data['module_id'] = $this->input->post('module_id');
            $data['arrangement'] = $this->input->post('arrangement');
            $data['title'] = $this->input->post('title');
            $data['video_link'] = $this->input->post('video_link');
            $data['content'] = $this->input->post('content');
            $data['instructor'] = $this->session->userdata('login_user_id');
            $data['date'] = date("Y-m-d H:i:s"); //ebaazer

            $this->db->insert('lesson', $data);

            $lesson_id = $this->db->insert_id();

            if ($lesson_id != null) {

                $response = array();

                $filename = $_FILES['userfile']['name'];
                $info = new SplFileInfo($filename);
                $uname = bin2hex(random_bytes(12));
                $folder = 'uploads/lesson_documents/' . $lesson_id . '/';

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                move_uploaded_file($_FILES['userfile']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
                $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
                $name = $uname . '.' . $info->getExtension();
                array_push($response, array(
                    'url' => $relative_path,
                    'name' => $name
                ));

                echo json_encode($response, JSON_UNESCAPED_UNICODE);

                $lesson_documents['lesson_id'] = $lesson_id;
                $lesson_documents['file_name'] = $uname . '.' . $info->getExtension();
                $lesson_documents['extension'] = $info->getExtension();

                $this->db->insert('lesson_documents', $lesson_documents);
            }

            redirect(site_url('user/lesson/' . $data['module_id']), 'refresh');
        }

        if ($param1 == 'edit') {

            $module_id = $this->input->post('module_id');
            $lesson_id = $param2;
            $data['course_id'] = $this->input->post('course_id');
            $data['module_id'] = $this->input->post('module_id');
            $data['arrangement'] = $this->input->post('arrangement');
            $data['title'] = $this->input->post('title');
            $data['video_link'] = $this->input->post('video_link');
            $data['content'] = $this->input->post('content');
            $data['date'] = date("Y-m-d H:i:s");

            $this->db->where('id', $param2);
            $this->db->update('lesson', $data);

            $response = array();

            $filename = $_FILES['userfile']['name'];
            $info = new SplFileInfo($filename);
            $uname = bin2hex(random_bytes(12));
            $folder = 'uploads/lesson_documents/' . $lesson_id . '/';
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $uploaded_file = move_uploaded_file($_FILES['userfile']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
            $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
            $name = $uname . '.' . $info->getExtension();
            array_push($response, array(
                'url' => $relative_path,
                'name' => $name
            ));

            json_encode($response, JSON_UNESCAPED_UNICODE);

            if ($uploaded_file) {
                $lesson_documents['lesson_id'] = $lesson_id;
                $lesson_documents['file_name'] = $uname . '.' . $info->getExtension();
                $lesson_documents['extension'] = $info->getExtension();

                $this->db->insert('lesson_documents', $lesson_documents);
            }

            redirect(site_url('user/lesson/' . $module_id), 'refresh');
        }

        if ($param1 == 'delete') {

            $data['active'] = 0;

            $this->db->where('id', $param2);
            $this->db->update('lesson', $data);
            echo 'true';
            return;
        }

        $page_data['page_name'] = 'lesson';
        $page_data['page_title'] = $this->lang->line('lesson');
        $page_data['module_id'] = $param1;
        $this->load->view('backend/index', $page_data);
    }

    function change_lesson_status() {
        $this->if_user_login();
        $emp = $_POST["id"];

        $data['publish'] = $_POST["st"];

        $this->db->where('id', $emp);
        $this->db->update('lesson', $data);

        echo $_POST["st"];
    }

    function add_lesson($id) {
        $this->if_user_login();

        $page_data['page_name'] = 'add_lesson';
        $page_data['page_title'] = $this->lang->line('add_lesson');
        $page_data['module_id'] = $id;
        $this->load->view('backend/index', $page_data);
    }

    function edit_lesson($id) {
        $this->if_user_login();

        $page_data['page_name'] = 'edit_lesson';
        $page_data['page_title'] = $this->lang->line('edit_lesson');
        $page_data['lesson_id'] = $id;
        $this->load->view('backend/index', $page_data);
    }

    function lessons() {
        $this->if_user_login();

        $page_data['page_name'] = 'lessons';
        $page_data['page_title'] = $this->lang->line('lessons');
        $this->load->view('backend/index', $page_data);
    }

    function Kanban() {
        $this->if_user_login();

        $page_data['page_name'] = 'Kanban';
        $this->load->view('backend/index', $page_data);
    }

    function subscribe_course($id = '', $student_id = '') {
        $this->if_user_login();

        $if_take_course = $this->db->get_where('subscribe_course', array('course_id' => $id, 'student_id' => $student_id, 'complete' => 0))->num_rows();

        if ($if_take_course == 0) {
            if ($student_id != 0) {
                $data['course_id'] = $id;
                $data['student_id'] = $student_id;
                $data['subscribe_date'] = date("Y-m-d H:i:s");

                $this->db->insert('subscribe_course', $data);
            }
        }

        $this->course_content($id, $student_id);
    }

    function course_content($param1 = "", $param2 = "", $param3 = "", $student_id = "") {
        $this->if_user_login();

        if ($param1 == 'course_content_lesson') {
            $page_data['inner_page'] = 'course_content_lesson';
            $page_data['lesson_id'] = $param2;
            $course_id = $param3;
            $page_data['module_id'] = $this->db->get_where('lesson', array('id' => $param2))->row()->module_id;
        }

        if ($param1 == 'course_content_lesson_empty') {
            $course_id = $param2;
            $student_id = $param3;
            $page_data['inner_page'] = 'course_content_lesson_empty';
        }

        $page_data['page_name'] = 'course_content';
        $page_data['page_title'] = $this->lang->line('course_content');
        $page_data['course_id'] = $course_id;
        $page_data['student_id'] = $student_id;

        $this->load->view('backend/index', $page_data);
    }

    function api_delete_lesson_documents($lesson_id, $img_id) {
        $this->if_user_login();

        $this->db->where('id', $img_id);
        $this->db->delete('lesson_documents');
        redirect(site_url('user/edit_lesson/' . $lesson_id), 'refresh');
    }

    public function create_user() {
        $this->if_user_login();
        $data['school_id'] = html_escape($this->input->post('school_id'));
        $data['name'] = html_escape($this->input->post('name'));
        $data['email'] = html_escape($this->input->post('email'));
        $data['password'] = sha1($this->input->post('password'));
        $data['phone'] = html_escape($this->input->post('phone'));
        $data['gender'] = html_escape($this->input->post('gender'));
        $data['address'] = html_escape($this->input->post('address'));
        $data['role'] = 'admin';
        $data['watch_history'] = '[]';

        $duplication_status = $this->check_duplication('on_create', $data['email']);
        if ($duplication_status) {
            $this->db->insert('users', $data);

            $response = array(
                'status' => true,
                'notification' => 'admin_added_successfully'
            );
        } else {
            $response = array(
                'status' => false,
                'notification' => 'sorry_this_email_has_been_taken'
            );
        }

        return json_encode($response);
    }

    public function update_user($param1 = '') {
        $this->if_user_login();
        $data['name'] = html_escape($this->input->post('name'));
        $data['email'] = html_escape($this->input->post('email'));
        $data['phone'] = html_escape($this->input->post('phone'));
        $data['gender'] = html_escape($this->input->post('gender'));
        $data['address'] = html_escape($this->input->post('address'));
        $data['school_id'] = html_escape($this->input->post('school_id'));
        $duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
        if ($duplication_status) {
            $this->db->where('id', $param1);
            $this->db->update('users', $data);

            $response = array(
                'status' => true,
                'notification' => 'admin_has_been_updated_successfully'
            );
        } else {
            $response = array(
                'status' => false,
                'notification' => 'sorry_this_email_has_been_taken'
            );
        }

        return json_encode($response);
    }

    public function delete_user($param1 = '') {
        $this->if_user_login();
        $this->db->where('id', $param1);
        $this->db->delete('users');

        $response = array(
            'status' => true,
            'notification' => 'admin_has_been_deleted_successfully'
        );
        return json_encode($response);
    }

    function users() {
        $this->if_user_login();

        $page_data['page_name'] = 'users';
        $page_data['page_title'] = $this->lang->line('add_student');

        $this->load->view('backend/index', $page_data);
    }

    function privacy_policy($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();
        if ($param1 == 'do_update') {

            $data_2['privacy'] = $this->input->post('privacy');
            $data_2['last_update'] = date("Y-m-d H:i:s");
            $this->db->insert('privacy', $data_2);

            redirect(site_url('user/privacy_policy/'), 'refresh');
        }

        $page_data['page_name'] = 'privacy_policy';
        $page_data['page_title'] = $this->lang->line('privacy_policy');

        $this->load->view('backend/index', $page_data);
    }

    function terms($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();
        if ($param1 == 'do_update') {

            $data_2['terms'] = $this->input->post('terms');
            $data_2['last_update'] = date("Y-m-d H:i:s");
            $this->db->insert('terms', $data_2);

            redirect(site_url('user/terms/'), 'refresh');
        }

        $page_data['page_name'] = 'terms';
        $page_data['page_title'] = $this->lang->line('Terms');

        $this->load->view('backend/index', $page_data);
    }

    function test($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();

        $page_data['page_name'] = 'test';
        $page_data['page_title'] = 'test';

        $this->load->view('backend/index', $page_data);
    }

    function qr_code($qr_text = '') {
        $this->if_user_login();

        $data['img_url'] = "";
        if ($qr_text != null) {
            $this->load->library('ciqrcode');
            $qr_image = rand() . '.png';
            $params['data'] = $qr_text;
            $params['level'] = 'H';
            $params['size'] = 4;
            $params['black'] = array(255, 255, 255); // array, default is array(255,255,255)
            $params['white'] = array(246, 78, 96); // array, default is array(0,0,0)
            $params['savename'] = FCPATH . "uploads/qr_image/" . $qr_image;
            if ($this->ciqrcode->generate($params)) {
                $page_data['img_url'] = $qr_image;
            }
        }

        $page_data['page_name'] = 'student_id';
        $this->load->view('backend/index', $page_data);
    }

    function plans() {
        $this->if_user_login();
        $page_data['page_name'] = 'plans';
        $page_data['page_title'] = $this->lang->line('plans');
        $this->load->view('backend/index', $page_data);
    }

    function sum_disk_use() {
        $this->if_user_login();
        $this->db->select_sum('size');
        $step_material = $this->db->get('step_material')->row();
        $step_material_use = $step_material->size;

        $this->db->select_sum('size');
        $group_message = $this->db->get('group_message')->row();
        $group_message_use = $group_message->size;

        $desk_use = $step_material_use + $group_message_use;

        return $desk_use;

        //echo $this->format_folder_size($desk_use);
    }

    function directory() {
        $this->if_user_login();

        /*
         * admin_image
         * avatar
         * chat
         * document
         * employee_image
         * frontend
         * group_chat
         * mailbox
         * ministry_upload_files
         * step_materials
         * student_documents
         * student_image
         */

        $directory = array(
            'admin_image', 'avatar', 'chat', 'document', 'employee_image', 'frontend', 'group_chat', 'mailbox', 'ministry_upload_files', 'step_materials', 'student_documents', 'student_image'
        );

        //$controllers = get_dir_file_info('uploads/');
        //$controllers = directory_map('uploads/');
        //step_material

        $totalSize = 0;
        $cont = 1;

        $this->db->select("a.*");
        $this->db->from("step_material a");
        //$this->db->where("a.active" , 1);
        $step_material = $this->db->get()->result_array();

        $this->db->select("a.*");
        $this->db->from("group_message a");
        //$this->db->where("a.group_message_thread_code", 'bba035b7-de9e-469f-8ab4-bd5447026fc3');
        $group_message = $this->db->get()->result_array();

        foreach ($group_message as $group_message_row) {

            //echo $step_material_row['material_name'];
            if ($group_message_row['attached_file_name'] != null || $group_message_row['attached_file_name'] != "") {
                $file_path = base_url() . 'uploads/group_chat/' . $group_message_row['group_message_thread_code'] . '/' . $group_message_row['attached_file_name'];

                //echo $file_path;

                $controllers = get_file_info('uploads/group_chat/' . $group_message_row['group_message_thread_code'] . '/' . $group_message_row['attached_file_name']);

                if ($group_message_row['attached_file_name'] == $controllers['name']) {
                    echo '<br>';
                    echo $group_message_row['group_message_id'];
                    echo '<br>';
                    echo $controllers['name'];
                    echo '<br>';
                    echo $controllers['size'];
                    echo '<br>';
                    echo '-------------------';
                    echo '<br>';

                    $data['size'] = $controllers['size'];

                    $this->db->where('group_message_id', $group_message_row['group_message_id']);
                    $this->db->update('group_message', $data);
                }

                //echo $cont.' - '. $this->format_folder_size($step_material_row['size']);
                //$totalSize += $step_material_row['size'];
                //echo '<br>';
                //echo '-------------------';
                //echo '<br>';
                //$cont++;
            }
        }

        //echo '<br>';
        //echo '<br>';
        //echo $this->format_folder_size($totalSize);
        //echo $this->format_folder_size($size);
    }

    function format_folder_size($size) {
        $this->if_user_login();
        if ($size >= 1073741824) {
            $size = number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            $size = number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            $size = number_format($size / 1024, 2) . ' KB';
        } elseif ($size > 1) {
            $size = $size . ' bytes';
        } elseif ($size == 1) {
            $size = $size . ' byte';
        } else {
            $size = '0 bytes';
        }
        return $size;
    }

    function show_data($raw = false) {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $this->db->select('a.name, a.employee_id, b.level, b.name job_title_name, a.job_title_id AS job_title_id');
        $this->db->from('employee a');
        $this->db->join('job_title b', 'a.job_title_id = b.job_title_id', 'left');
        $this->db->where_in('b.level', [1, 2]);

        //if ($login_type == 'employee') {
        //    $this->db->where('a.class_id', $this->session->userdata('class_id'));
        //}

        $this->db->where('a.active', 1);
        $this->db->order_by('a.level, a.name');
        $employees = $this->db->get()->result_array();

        $dataset = array();

        foreach ($employees as $employee) {
            $employee_id = $employee['employee_id'];
            $jobTitle = $employee['job_title_id'];
            $userLevel = $employee['level'];
            $month_id = 10;
            $start_date = '2019-10-01';
            $end_date = '2019-10-31';

            if ($userLevel == 1) {
                $this->db->select('a.student_id');
                $this->db->from('student a');
                $this->db->join('enroll b', 'a.student_id = b.student_id', 'left');
                $this->db->join('section c', 'b.section_id = c.section_id', 'left');
                $this->db->where("b.year", $year);
                $this->db->group_start();
                $this->db->where('c.teacher_id', $employee_id);
                $this->db->or_where('c.assistant_teacher_id', $employee_id);
                $this->db->group_end();
                $this->db->where("b.status", 0);
            } else {
                $this->db->select('a.student_id');
                $this->db->from("schedule_subject_student a");
                $this->db->join("student b", "b.student_id = a.student_id", "left");
                $this->db->join("schedule_subject c", "a.schedule_subject_id = c.id", "left");
                $this->db->join("schedule d", "c.schedule_id = d.id", "left");
                $this->db->where("d.employee_id", $employee_id);
                //$this->db->where("c.day_id", $day_id);
                $this->db->where("d.active", 1);
                $this->db->where('a.active', 1);
                $this->db->where("d.year", $year);
            }


            $students = $this->db->get()->result_array();
            $student_ids = array_column($students, 'student_id');
            //echo $this->db->last_query() . '\n';
            if (empty($student_ids)) {
                array_push($dataset, array(
                    'employee' => $employee,
                    'stats' => 'error'
                ));
                continue;
            }
            //echo "\n";
            //print_r($student_ids);

            $this->db->select('a.id AS id, a.plan_name as name, COUNT(DISTINCT c.id) steps');
            $this->db->from('student_plan a');
            $this->db->join("student_plan_steps b", 'a.id = b.plan_id', 'left');
            $this->db->join("assessment_step c", 'c.id = b.step_id', 'left');
            $this->db->where_in('a.student_id', $student_ids);
            $this->db->where('a.running_year', $year);
            $this->db->where('a.active', 1);
            $this->db->group_by("id");
            if ($userLevel == 1 || $userLevel == 2) {
                $this->db->where("c.specialty_id", $jobTitle);
                $this->db->having('steps > 0');
            }

            $plans = $this->db->get()->result_array();
            $plan_ids = array_column($plans, 'id');

            if (empty($plan_ids)) {
                array_push($dataset, array(
                    'employee' => $employee,
                    'stats' => 'error'
                ));
                continue;
            }

            $monthlyPlans = $this->db
                    ->select("a.id")
                    ->from("monthly_plan a")
                    ->where("a.year", $year)
                    ->where_in('plan_id', $plan_ids)
                    ->where("month_id", $month_id)
                    ->get()
                    ->result_array();

            $daily_report = $this->db
                    ->select("b.report_day, GROUP_CONCAT(DISTINCT a.student_id) students")
                    ->from("daily_report_steps a")
                    ->join("daily_report b", "a.daily_report_id = b.id", "LEFT")
                    ->where("user_id", $employee_id)
                    ->group_start()
                    ->where("b.report_day >= ", $start_date)
                    ->where("b.report_day <= ", $end_date)
                    ->group_end()
                    ->group_by("1")
                    ->get()
                    ->result_array();

            $stats = array(
                'studentsCount' => count($student_ids),
                'plansCount' => count($plans),
                'monthlyPlansCount' => count($monthlyPlans),
                //'students' => $students
                //'plans' => $plans,
                //'monthlyPlans' => $monthlyPlans,
                'daily_reports' => $daily_report,
            );
            array_push($dataset, array(
                'employee' => $employee,
                'stats' => $stats
            ));
        }

        if ($raw) {
            return $dataset;
        }
        //header('Content-Type: application/json');
        echo json_encode($dataset, JSON_UNESCAPED_UNICODE);
    }

    function attendance_student_chart() {
        $this->if_user_login();
        $studentAttendanceData = $this->db
                ->select("DATE_FORMAT(FROM_UNIXTIME(timestamp), '%Y-%m-%d') AS date, COUNT(*) AS total, SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS absent")
                ->from("attendance")
                ->where("FROM_UNIXTIME(timestamp) < CURDATE()")
                ->group_by('date')
                ->order_by('date', "DESC")
                ->limit(15)
                ->get()
                ->result_array();

        echo json_encode($studentAttendanceData, JSON_UNESCAPED_UNICODE);
    }

    function fetch_last_activity() {

        $this->if_user_login();

        /*
          $curTime = date('Y-m-d H:i:s');
          $employees = $this->db->select("a.name, b.name AS job_title_name, last_activity, TIMESTAMPDIFF(MINUTE, last_activity, '" . $curTime . "') AS last_activity_minutes")
          ->from('employee a')
          ->join('job_title b', 'a.job_title_id = b.job_title_id', 'left')
          ->where('a.active', 1)
          ->where('a.deleted', 0)
          ->order_by('last_activity DESC')
          ->get()->result_array();

         */

        $time = date("Y-m-d H:i:s", time() - 30);
        $employees = $this->db->select("a.name, b.name AS job_title_name, last_activity")
                        ->from('employee a')
                        ->join('job_title b', 'a.job_title_id = b.job_title_id', 'left')
                        ->where('a.last_activity >', $time)
                        ->where('a.active', 1)
                        ->where('a.deleted', 0)
                        ->order_by('last_activity DESC')
                        ->get()->result_array();

        //echo json_encode($employees, JSON_UNESCAPED_UNICODE);

        foreach ($employees as $row) {
            echo '<span style=" background-color: #00bcd46b; margin: 2px;">' . $row['name'] . '</span>';
        }
    }

    function fetch_last_activity_num() {

        $this->if_user_login();

        $time = date("Y-m-d H:i:s", time() - 30);
        $employees = $this->db->select("a.name, b.name AS job_title_name, last_activity")
                        ->from('employee a')
                        ->join('job_title b', 'a.job_title_id = b.job_title_id', 'left')
                        ->where('a.last_activity >', $time)
                        ->where('a.active', 1)
                        ->where('a.deleted', 0)
                        ->order_by('last_activity DESC')
                        ->get()->num_rows();

        echo $employees;
    }

    function fetch_last_activity_parent() {

        $this->if_user_login();

        $time = date("Y-m-d H:i:s", time() - 30);
        $parents = $this->db->select("a.name, last_activity")
                        ->from('parent a')
                        ->where('a.last_activity >', $time)
                        ->where('a.active', 1)
                        ->where('a.deleted', 0)
                        ->order_by('last_activity DESC')
                        ->get()->result_array();

        //echo json_encode($employees, JSON_UNESCAPED_UNICODE);

        foreach ($parents as $row) {
            echo '<span style=" background-color: #00bcd46b; margin: 2px;">' . $row['name'] . '</span>';
        }
    }

    function fetch_last_activity_parent_num() {

        $this->if_user_login();

        $time = date("Y-m-d H:i:s", time() - 30);
        $parents = $this->db->select("a.name,last_activity")
                        ->from('parent a')
                        ->where('a.last_activity >', $time)
                        ->where('a.active', 1)
                        ->where('a.deleted', 0)
                        ->order_by('last_activity DESC')
                        ->get()->num_rows();

        echo $parents;
    }

    function last_activity($param1 = '', $param2 = '', $param3 = '') {


        $this->if_user_login();

        $user_id = $this->session->userdata('login_user_id');
        $login_type = $this->session->userdata('login_type');

        if ($login_type != 'technical_support') {

            if ($login_type == 'parent') {
                $data1['last_activity'] = date('Y-m-d H:i:s');
                $this->db->where('parent_id', $user_id);
                $this->db->update('parent', $data1);
            }

            if ($login_type == 'employee') {

                $data1['last_activity'] = date('Y-m-d H:i:s');
                $this->db->where('employee_id', $user_id);
                $this->db->update('employee', $data1);

                if ($param1 == "active") {
                    $data['user_id'] = $user_id;
                    $data['user_type'] = $login_type;
                    $data['active_time'] = date("Y-m-d H:i:s");
                    //$data['idle_time'] = '2500';
                    //$data['total_session_time'] = date("Y-m-d H:i:s");

                    $this->db->insert('user_time_analysis', $data);
                }

                if ($param1 == "idle") {

                    $this->db->select("a.*");
                    $this->db->from("user_time_analysis a");
                    $this->db->where("a.user_id", $user_id);
                    $this->db->where("a.idle_time", null);
                    $this->db->order_by('a.id', 'DESC');
                    $this->db->limit(1);
                    $user_time_analysis = $this->db->get()->row();

                    $idle_time = date("Y-m-d H:i:s");

                    $timeFirst = strtotime($user_time_analysis->active_time);
                    $timeSecond = strtotime($idle_time);
                    $differenceInSeconds = $timeSecond - $timeFirst;

                    $data['user_id'] = $user_id;
                    $data['user_type'] = $login_type;
                    //$data['active_time'] = date("Y-m-d H:i:s");
                    $data['idle_time'] = $idle_time;
                    $data['total_session_time'] = $differenceInSeconds;

                    $this->db->where('id', $user_time_analysis->id);
                    $this->db->update('user_time_analysis', $data);
                }
            }
        }

        echo '';
    }

    function db_size() {
        $this->if_user_login();
        $query = $this->db->query('SELECT table_schema "DB Name", Round(Sum(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables GROUP BY table_schema;');

        echo '<pre>';
        print_r($query);
        echo '</pre>';
    }

    function abc123() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("student a");
        $student = $this->db->get()->result_array();

        foreach ($student as $row) {

            $name = explode(" ", $row['name']);

            echo $name[0] . ' ' . $name[1];
            echo '<br>';

            if ($row['gender'] == 'male') {
                $name = explode(" ", $row['name']);
                $data['name'] = $name[1] . ' ' . $name[0];

                $this->db->where('student_id', $row['student_id']);
                $this->db->update('student', $data);
            } else {
                $name = explode(" ", $row['name']);
                $data['name'] = $name[0] . ' ' . $name[1];

                $this->db->where('student_id', $row['student_id']);
                $this->db->update('student', $data);
            }
        }
    }

    function abc1234() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("student a");
        $employee = $this->db->get()->result_array();
        $ccc = 1;
        foreach ($employee as $row) {
            $name = explode(" ", $row['name']);

            echo 'ولي الامر' . '1';
            echo '<br>';

            //$name = explode(" ", $row['name']);
            $data['name'] = 'طالب' . ' ' . $ccc;

            $this->db->where('student_id', $row['student_id']);
            $this->db->update('student', $data);
            $ccc++;
        }
    }

    //payroll_amount
    function aaaaaaa() {
        $this->if_user_login();

        $this->db->select("a.*");
        $this->db->from("employee a");
        $employee = $this->db->get()->result_array();

        foreach ($employee as $row) {

            $data['employee_id'] = $row['employee_id'];
            $data['payroll_category_id'] = '1';
            $data['payroll_amount'] = '2500';
            $data['datetime_stamp'] = strtotime(date("Y-m-d H:i:s"));

            $this->db->insert('payroll_employee', $data);
        }
    }

    function importCSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/vbmapp.xlsx.csv', 'r') or die("can't open file");
        //uploads
        // Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'evaluation_axes_id' => $csv_line[1],
                'main_goal' => $csv_line[2],
                'level_main_goal' => $csv_line[3],
            );

            //$this->db->insert('vbmapp_main_goal', $data_main_goal);
            //$main_goal_id = $this->db->insert_id();

            $array_sub_goal = explode("|", $csv_line[6]);

            foreach ($array_sub_goal as $array_sub_goal_row) {
                $sub_goal = array(
                    'evaluation_axes_id' => $csv_line[1],
                    'main_goal_id' => $csv_line[2],
                    'sub_goal' => $array_sub_goal_row,
                );
                //$this->db->insert('vbmapp_sub_goal', $data_main_goal);
                array_push($vpmapp, $sub_goal);
            }
        }

        echo '<pre>';
        print_r($vpmapp);
        die();
    }

    function importCSV2() {
        $this->if_user_login();
        $fp = fopen('assets/csv/supportive_skills_analysis.csv', 'r') or die("can't open file");
        //uploads
        // Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();
        $final_array = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'evaluation_axes_id' => $csv_line[1],
                'main_goal_id' => $csv_line[2],
                'sub_goal_id' => $csv_line[3],
                'skills_analysis' => $csv_line[4],
                'required' => $csv_line[5],
            );

            array_push($vpmapp, $data_main_goal);

            //$this->db3->insert('vbmapp_skills_analysis', $data_main_goal);
            //$main_goal_id = $this->db->insert_id();
            //$array_sub_goal_r = explode("-", $csv_line[5]);
            //$array_sub_goal = explode("|", $csv_line[6]);

            /*
              foreach ($array_sub_goal as $array_sub_goal_row) {

              $skills_analysis = array(
              'evaluation_axes_id' => $csv_line[1],
              'main_goal_id' => $csv_line[2],
              'sub_goal_id' => $csv_line[0],
              'skills_analysis' => $array_sub_goal_row,
              //'essential_skill' => $array_sub_goal_r,
              );
              //$this->db3->insert('vbmapp_skills_analysis', $skills_analysis);
              array_push($vpmapp, $skills_analysis);
              }

             */
        }

        echo '<pre>';
        print_r($vpmapp);
        echo '</pre>';
        die();
    }

    function print_table() {
        $this->if_user_login();
        //vbmapp_evaluation_axes
        $this->db3->select("a.*");
        $this->db3->from("curriculum_scale a");
        $this->db3->where('a.publish', 1);
        $this->db3->where('a.active', 1);
        $curriculum_scale = $this->db3->get()->result_array();

        echo '<pre>';
        print_r($curriculum_scale);
        echo '</pre>';
    }

    function import_cc_CSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/cc43.csv', 'r') or die("can't open file");
        //uploads  
        // Ignore header line 
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'name' => $csv_line[1],
                'email' => strtolower(trim($csv_line[2])),
                'phone' => $csv_line[3],
                'country' => $csv_line[4],
                'specialty' => $csv_line[5],
                'date' => date("Y-m-d H:i:s"),
                'encrypt_thread' => bin2hex(random_bytes(32)),
                //'course_id' => $csv_line[7],
                'course_id' => 43,
            );

            //course_subscribers
            $checkEmail = $this->db->get_where('course_subscribers', array('email' => $data_main_goal['email'], 'course_id' => $data_main_goal['course_id']))->num_rows();
            if ($checkEmail > 0) {
                
            } else {
                $this->db->insert('course_subscribers', $data_main_goal);
                array_push($vpmapp, $data_main_goal);
            }
            //$main_goal_id = $this->db->insert_id();
        }

        echo '<pre>';
        print_r($vpmapp);
        die();
    }

    function import_mailing_list_CSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/mailing_list_15_09_2023.csv', 'r') or die("can't open file");
        //uploads
        // Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'email' => strtolower(trim($csv_line[0])),
                'subscription_status' => 1,
                'date' => date("Y-m-d H:i:s"),
            );

            //course_subscribers
            $checkEmail = $this->db->get_where('mailing_list', array('email' => $data_main_goal['email']))->num_rows();
            if ($checkEmail > 0) {
                
            } else {
                $this->db->insert('mailing_list', $data_main_goal);
                array_push($vpmapp, $data_main_goal);
            }
            //$main_goal_id = $this->db->insert_id();
        }

        echo '<pre>';
        print_r($vpmapp);
        //die();
    }

    function requests_taheelweb() {
        $this->if_user_login();

        $page_data['page_name'] = 'requests_taheelweb';
        $page_data['page_title'] = $this->lang->line('requests');

        $this->load->view('backend/index', $page_data);
    }

    function get_data_requests() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("client a");
        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where("active", 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function contact() {
        $this->if_user_login();

        $page_data['page_name'] = 'contact';
        $page_data['page_title'] = $this->lang->line('contact');

        $this->load->view('backend/index', $page_data);
    }

    function delete_contact($param1 = "", $param2 = "", $param3 = "") {

        $this->if_user_login();
        $id = $param1;

        $data['active'] = 0;

        $this->db->where('contact_email_id', $id);
        $this->db->update('contact_email', $data);
    }

    function get_data_contact() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("contact_email a");
        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where("active", 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function subscriptions() {
        $this->if_user_login();

        $page_data['page_name'] = 'subscriptions';
        $page_data['page_title'] = $this->lang->line('Subscriptions');

        $this->load->view('backend/index', $page_data);
    }

    function get_data_subscriptions() {
        $this->if_user_login();
        $this->db->select("a.* , b.name , b.last_name, c.name as sub_name, d.name as type_name, d.id as account_type_id");
        $this->db->from("subscriptions a");
        $this->db->join("client b", "a.client_id = b.id", 'left');
        $this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        $this->db->join("account_type d", "a.account_type_id = d.id", 'left');

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function get_data_subscriptions_old() {
        $this->if_user_login();
        $this->db->select("a.* , b.name , b.last_name, c.name as sub_name, d.name as type_name");
        $this->db->from("subscriptions a");
        $this->db->join("client b", "a.client_id = b.id", 'left');
        $this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        $this->db->join("account_type d", "a.account_type_id = d.id", 'left');

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function zero($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'do_update') {

            //$dsn22 = 'mysql://root:@localhost/tw';
            //$this->db22 = $this->load->database($dsn22, TRUE);

            $db_for_con = 'rc_v4';

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
            echo 'ddd';
            //$otherDb = $this->ci->load->database($dsn22, true);
            echo $this->db_con->get_where('settings', array('type' => 'expiration_date'))->row()->description;
            echo 'ddd';

            //$this->db2 = $this->load->database('tw', TRUE);

            $student_id = $param2;

            $day_birth = $_POST['day_birth'];
            $month_birth = $_POST['month_birth'];
            $year_birth = $_POST['year_birth'];

            $data['description'] = $day_birth . '-' . $month_birth . '-' . $year_birth;

            $data['description'] = '2029-01-01';

            $this->db_con->where('type', 'expiration_date');
            $this->db_con->update('settings', $data);
            $this->db_con->close();

            //$this->db2->where('student_id', $student_id);
            //$this->db2->update('student', $data);
            //$this->crud_model->clear_cache();
            //$this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            //redirect(site_url('student/student/student/'), 'refresh');
        }
    }

    function subscription_extension($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'do_update') {

            $db_for_con = 'tw';

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
            $student_id = $param2;

            $day_birth = $_POST['day_birth'];
            $month_birth = $_POST['month_birth'];
            $year_birth = $_POST['year_birth'];

            $data['description'] = $year_birth . '-' . $month_birth . '-' . $day_birth;
            //$data['description'] = '2023-01-01';

            $this->db_con->where('type', 'expiration_date');
            $this->db_con->update('settings', $data);
            $this->db_con->close();
        }
    }

    function careers_cv() {
        $this->if_user_login();

        $page_data['page_name'] = 'careers_cv';
        $page_data['page_title'] = $this->lang->line('cv');

        $this->load->view('backend/index', $page_data);
    }

    function get_data_careers_cv() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("job_application a");
        //$this->db->join("nationality b", "a.nationality = b.nationality_id", 'left');
        $this->db->where("a.active", 1);
        $this->db->order_by('a.date', "DESC");
        $cv = $this->db->get()->result_array();

        $cv_json = json_encode($cv, JSON_UNESCAPED_UNICODE);
        $by_field = "date";

        $this->array_json->array_json($cv_json, $by_field);
    }

    function delete_cv($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();
        if ($param1 == 'delete') {
            $cv_id = $param2;
            $file_name = $this->db->get_where('careers_cv', array('id' => $cv_id))->row()->fileToUpload;

            if (unlink("/var/www/careers.taheelweb.com/uploads/careers_cv/" . $file_name)) {
                $data['fileToUpload'] = null;

                $this->db->where('id', $cv_id);
                $this->db->update('careers_cv', $data);
            } else {
                $data['fileToUpload'] = null;

                $this->db->where('id', $cv_id);
                $this->db->update('careers_cv', $data);
            }
        }
    }

    function delete_employee_cv($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();
        if ($param1 == 'delete') {
            $cv_id = $param2;
            $file_name = $this->db->get_where('careers_cv', array('id' => $cv_id))->row()->fileToUpload;

            if (unlink("/var/www/careers.taheelweb.com/uploads/careers_cv/" . $file_name)) {
                $data['active'] = 0;
                $data['fileToUpload'] = null;

                $this->db->where('id', $cv_id);
                $this->db->update('careers_cv', $data);
            } else {
                $data['active'] = 0;
                $data['fileToUpload'] = null;

                $this->db->where('id', $cv_id);
                $this->db->update('careers_cv', $data);
            }
        }
    }

    function employee_cv_edit($param1 = "", $param2 = "", $param3 = "") {
        $this->if_user_login();

        $cv_id = $param1;
        $cv_id = $param2;

        $page_data['page_name'] = 'employee_cv_edit';
        $page_data['page_title'] = $this->lang->line('edit');
        $page_data['cv_id'] = $cv_id;
        $this->load->view('backend/index', $page_data);
    }

    function cv_account($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            
        }

        if ($param1 == 'do_update') {

            $cv_id = $this->input->post('cd_id');

            $data['name'] = $this->input->post('name');
            $data['specialty'] = $this->input->post('specialty');
            $data['nationality'] = $this->input->post('nationality');
            $data['gender'] = $this->input->post('gender');
            $data['email'] = $this->input->post('email');
            $data['phone'] = $this->input->post('phone');
            $data['bio'] = $this->input->post('bio');

            $this->db->where('id', $cv_id);
            $this->db->update('careers_cv', $data);

            redirect(site_url('user/cv/'), 'refresh');
        }
    }

    /*
      function upload_logo() {
      if ($this->session->userdata('user_login') != 1) {
      redirect(base_url(), 'refresh');
      return;
      }

      $page_data['page_name'] = 'upload_logo';
      $page_data['page_title'] = 'upload_logo';

      $this->load->view('backend/index', $page_data);
      }
     */

    function add_new_logo() {
        $this->if_user_login();

        //$this->add_new_folder_client();

        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));

        $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/logo/';
        //$folder = '/mnt/taheelweb_volume/uploads/' . $this->session->userdata('client_id') . '/logo/';
        symlink('/home/username/public_html/directory1', '/home/username/public_html/directory2');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
        $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
        $name = $uname . '.' . $info->getExtension();

        $results = array(
            'url' => $relative_path,
            'name' => $uname . '.' . $info->getExtension(),
            'fileName' => $_FILES['file']['name']
        );

        //shell_exec('ln -s /mnt/taheelweb_volume/uploads/' . $this->session->userdata('client_id') . '/logo/'.$uname . '.' . $info->getExtension() .'/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/logo/'.$uname . '.' . $info->getExtension());
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function add_leatr_page_photo() {
        $this->if_user_login();

        //$this->add_new_folder_client();

        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));

        $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/leatr_page_photo/';
        //$folder = '/mnt/taheelweb_volume/uploads/' . $this->session->userdata('client_id') . '/logo/';
        symlink('/home/username/public_html/directory1', '/home/username/public_html/directory2');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
        $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
        $name = $uname . '.' . $info->getExtension();

        $results = array(
            'url' => $relative_path,
            'name' => $uname . '.' . $info->getExtension(),
            'fileName' => $_FILES['file']['name']
        );

        //shell_exec('ln -s /mnt/taheelweb_volume/uploads/' . $this->session->userdata('client_id') . '/logo/'.$uname . '.' . $info->getExtension() .'/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/logo/'.$uname . '.' . $info->getExtension());
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function import_hand_CSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/hand.csv', 'r') or die("can't open file");
        //uploads
        // Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'employee_code' => $csv_line[0],
                'name' => $csv_line[1],
                'email' => trim($csv_line[2]),
                'phone' => $csv_line[3],
                'password' => sha1($csv_line[4]),
                'job_title_id' => $csv_line[5],
                'specializing' => $csv_line[6],
                'gender ' => '2',
                'status_login' => $csv_line[8],
                'date_added' => date("Y-m-d H:i:s"),
                'encrypt_thread' => bin2hex(random_bytes(32)),
                'last_activity' => date("Y-m-d H:i:s"),
                'key_pass' => $csv_line[4]
            );

            //course_subscribers
            $checkEmail = $this->db->get_where('employee', array('email' => $data_main_goal['email']))->num_rows();
            if ($checkEmail > 0) {
                
            } else {

                $this->db->insert('employee', $data_main_goal);

                $data_class['employee_id'] = $this->db->insert_id();
                $data_class['class_id'] = 1;
                $data_class['date'] = date("Y-m-d H:i:s");
                $this->db->insert('employee_classes', $data_class);

                array_push($vpmapp, $data_main_goal);
            }

            //$main_goal_id = $this->db->insert_id();
        }

        echo '<pre>';
        print_r($vpmapp);
        die();
    }

    function import_shand_CSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/pd_stu.csv', 'r') or die("can't open file");
        //uploads
        // Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'name' => $csv_line[0],
                'nationality_id' => trim($csv_line[1]),
                'email' => trim('0' . $csv_line[3] . '@gmail.com'),
                'phone' => '0' . $csv_line[3],
                'password' => sha1('test123'),
                'last_login' => date("Y-m-d H:i:s"),
                'status_login' => '0',
                'encrypt_thread' => bin2hex(random_bytes(32)),
                'last_activity' => date("Y-m-d H:i:s"),
                'key_pass' => 'test123',
                'date_added' => date("Y-m-d H:i:s")
            );

            $checkEmail = $this->db->get_where('parent', array('email' => $data_main_goal['email']))->num_rows();
            if ($checkEmail > 0) {
                
            } else {

                $this->db->insert('parent', $data_main_goal);
                $parent_id = $this->db->insert_id();

                $data_student['name'] = $csv_line[7];
                $data_student['nationality_id'] = trim($csv_line[16]);
                $data_student['beneficiary_number'] = null;

                if ($csv_line[11] > 9) {
                    $d = $csv_line[11];
                } else {
                    $d = '0' . $csv_line[11];
                }

                if ($csv_line[12] > 9) {
                    $m = $csv_line[12];
                } else {
                    $m = '0' . $csv_line[12];
                }

                $y = $csv_line[13];

                $data_student['birthday'] = $d . '-' . $m . '-' . $y;
                $data_student['gender'] = $csv_line[15];

                $checkDisabilityCategory = $this->db->get_where('disability', array('disability_name' => $csv_line[17]))->num_rows();

                if ($checkDisabilityCategory > 0) {
                    $data_student['disability_category'] = $this->db->get_where('disability', array('disability_name' => $csv_line[17]))->row()->id;
                } else {

                    $data_disability['disability_name'] = $csv_line[17];
                    $this->db->insert('disability', $data_disability);
                    $data_student['disability_category'] = $this->db->insert_id();
                }

                $data_student['encrypt_thread'] = bin2hex(random_bytes(32));
                $data_student['img_type'] = 1;
                $random_img_student_1 = ["001-boy", "004-boy-1", "007-boy-2", "008-boy-3", "009-boy-4", "011-boy-5", "015-boy-6", "016-boy-7", "021-boy-8", "024-boy-9", "026-boy-10", "029-boy-11", "031-boy-12", "032-boy-13", "034-boy-14", "035-boy-15", "038-boy-16", "040-boy-17", "043-boy-18", "044-boy-19", "045-boy-20", "048-boy-21", "049-boy-22"];
                $random_img_student_2 = ["002-girl", "003-girl-1", "005-girl-2", "006-girl-3", "010-girl-4", "012-girl-5", "013-girl-6", "014-girl-7", "017-girl-8", "018-girl-9", "019-girl-10", "020-girl-11", "022-girl-12", "023-girl-13", "025-girl-14", "027-girl-15", "028-girl-16", "030-girl-17", "033-girl-18", "036-girl-19", "037-girl-20", "039-girl-21", "041-girl-22", "042-girl-23", "046-girl-24", "047-girl-25", "050-girl-26"];

                $data_student['date_added'] = date("Y-m-d H:i:s");
                $this->db->insert('student', $data_student);
                $student_id = $this->db->insert_id();

                $stu_g = $this->db->get_where('student', array('student_id' => $student_id))->row()->gender;
                if ($stu_g == 1) {
                    shuffle($random_img_student_1);
                    $name = $random_img_student_1[0] . '.svg';

                    $folder = '';
                    $data_student_g['img_url'] = $folder . $name;
                    $this->db->where('student_id', $student_id);
                    $this->db->update('student', $data_student_g);
                } else {
                    shuffle($random_img_student_2);
                    $name = $random_img_student_2[0] . '.svg';

                    $folder = '';
                    $data_student_g['img_url'] = $folder . $name;

                    $this->db->where('student_id', $student_id);
                    $this->db->update('student', $data_student_g);
                }

                $data_student_parent['student_id'] = $student_id;
                $data_student_parent['parent_id'] = $parent_id;
                $data_student_parent['date_added'] = date("Y-m-d H:i:s");
                $this->db->insert('student_parent', $data_student_parent);

                $data_enroll['student_id'] = $student_id;
                $data_enroll['class_id'] = 1;
                $data_enroll['section_id'] = $csv_line[23];
                $data_enroll['year'] = '2022-2023';
                $data_enroll['status'] = 1;
                $data_enroll['date_added'] = date("Y-m-d H:i:s");
                $this->db->insert('enroll', $data_enroll);

                array_push($vpmapp, $data_main_goal);
            }
        }

        echo '<pre>';
        print_r($vpmapp);
        die();
    }

    function update_course_subscribers() {
        $this->if_user_login();
        $all_subscribers = $this->db->get('course_subscribers')->result_array();
        foreach ($all_subscribers as $all_subscribers_row) {
            $data_subscribers['course_id'] = 1;
            $data_subscribers['email'] = strtolower(trim($all_subscribers_row['email']));

            $this->db->where('id', $all_subscribers_row['id']);
            $this->db->update('course_subscribers', $data_subscribers);
        }
    }

    function import_sc_2_CSV() {
        $this->if_user_login();
        $fp = fopen('assets/csv/c_s_2.csv', 'r') or die("can't open file");
        //uploads
        //Ignore header line
        $header = fgetcsv($fp);
        $vpmapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'course_id' => 3,
                'name' => $csv_line[1],
                'phone' => $csv_line[3],
                'email' => strtolower(trim($csv_line[2])),
                'specialty' => $csv_line[5],
                'institution' => null,
                'job_title' => $csv_line[4],
                'date' => date("Y-m-d H:i:s"),
                'encrypt_thread' => bin2hex(random_bytes(32)),
            );

            //course_subscribers
            $checkEmail = $this->db->get_where('course_subscribers', array('email' => $data_main_goal['email'], 'active' => 1, 'course_id' => 3))->num_rows();
            if ($checkEmail > 0) {
                
            } else {
                $this->db->insert('course_subscribers', $data_main_goal);
                array_push($vpmapp, $data_main_goal);
            }

            //$main_goal_id = $this->db->insert_id();
        }

        echo '<pre>';
        print_r($vpmapp);
        die();
    }

    function add_autism_screening($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $curriculum_scale = $this->db3->get_where('curriculum_scale', array('id' => 2))->row();
        if ($curriculum_scale == 0) {

            $skills_analysis = array(
                'name' => 'اختبار مسحي للتوحد',
                'preparation' => 'تاهيل وب',
                'description' => 'هذا الاختبار مسحي ولا يتم اعتماد نتائجه بصورة نهاية',
                'link_page' => null,
            );
            $this->db3->insert('curriculum_scale', $skills_analysis);
        }
    }

    function import_autism_screening() {
        $this->if_user_login();
        $check = $this->db3->get('autism_screening_item')->num_rows();

        if ($check > 25) {
            echo 'تم استيراد البيانات مسبقا';
        } else {
            $fp = fopen('assets/csv/autism_screening.csv', 'r') or die("can't open file");
            //uploads
            // Ignore header line
            $header = fgetcsv($fp);
            $vpmapp = array();
            $sub_goal = array();
            $final_array = array();

            while ($csv_line = fgetcsv($fp)) {
                $data_main_goal = array(
                    'encrypt_thread' => bin2hex(random_bytes(32)),
                    'item' => $csv_line[1],
                    'degree' => null,
                );

                $check = $this->db3->get('autism_screening_item')->num_rows();
                if ($check > 25) {
                    
                } else {
                    $this->db3->insert('autism_screening_item', $data_main_goal);
                }

                array_push($vpmapp, $data_main_goal);
            }

            echo '<pre>';
            print_r($vpmapp);
            echo '</pre>';
            die();
        }
    }

    function payroll_category($param1 = '', $param2 = '') {
        $this->if_user_login();
        if ($param1 == 'create') {
            $data['name'] = $this->input->post('name');
            $this->db->insert('payroll_category', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_added_successfully'));
            redirect(site_url('user/payroll_category'));
        }
        if ($param1 == 'edit') {
            $data['name'] = $this->input->post('name');
            $this->db->where('payroll_category_id', $param2);
            $this->db->update('payroll_category', $data);
            $this->session->set_flashdata('flash_message', $this->lang->line('data_updated'));
            redirect(site_url('user/payroll_category'));
        }
        if ($param1 == 'delete') {
            $this->db->where('payroll_category_id', $param2);
            $this->db->delete('payroll_category');
            $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
            redirect(site_url('user/payroll_category'));
        }

        $page_data['page_name'] = 'payroll_category';
        $page_data['page_title'] = $this->lang->line('payroll_category');

        $this->load->view('backend/index', $page_data);
    }

    function fix_level_taheelweb() {
        $this->if_user_login();

        $data['level'] = 2;
        $this->db->update('employee', $data);
    }

    function fix_services_provided_taheelweb() {
        $this->if_user_login();
        $checkServices_provided = $this->db->get('services_provided')->num_rows();

        if ($checkServices_provided > 0) {
            
        } else {
            $services_provided = array(
                array('services_provided_id' => '1', 'services_type' => 'educational_service', 'name' => 'الخدمات التأهيلية الاساسية', 'description' => 'خدمات تدريب ورعاية ذوي الاحتياجات الخاصة والتأهيل النفسي والاجتماعي', 'job_title_id' => '4,8,14,15,28', 'active' => '1', 'available' => '1'),
                array('services_provided_id' => '2', 'services_type' => 'educational_service', 'name' => 'خدمة العلاج الطبيعي', 'description' => '', 'job_title_id' => '6', 'active' => '1', 'available' => '1'),
                array('services_provided_id' => '3', 'services_type' => 'educational_service', 'name' => 'خدمة العلاج الوظيفي', 'description' => '', 'job_title_id' => '5', 'active' => '1', 'available' => '1'),
                array('services_provided_id' => '4', 'services_type' => 'educational_service', 'name' => 'خدمة النطق', 'description' => '', 'job_title_id' => '7', 'active' => '1', 'available' => '1'),
                array('services_provided_id' => '5', 'services_type' => 'educational_service', 'name' => 'خدمة التوحد', 'description' => '', 'job_title_id' => '4,14,15,28', 'active' => '1', 'available' => '1'),
                array('services_provided_id' => '6', 'services_type' => 'logistic_service', 'name' => 'خدمة النقل', 'description' => '', 'job_title_id' => NULL, 'active' => '1', 'available' => '1')
            );

            foreach ($services_provided as $services_provided_row) {
                $data['services_type'] = $services_provided_row['services_type'];
                $data['name'] = $services_provided_row['name'];
                $data['description'] = $services_provided_row['description'];
                $data['job_title_id'] = $services_provided_row['job_title_id'];
                $data['active'] = $services_provided_row['active'];
                $data['available'] = $services_provided_row['available'];

                $this->db->insert('services_provided', $data);
            }
        }
    }

    // Filter the excel data 
    function filterData(&$str) {
        $this->if_user_login();
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"'))
            $str = '"' . str_replace('"', '""', $str) . '"';
    }

    function print_assess($assessment_id) {
        $this->if_user_login();

        $this->db->select("d.assessment_name, c.genre_name, b.goal_name, b.level,  a.step_name, a.step_measure, a.assessment_id, a.id as step_id");
        $this->db->from('assessment_step a');
        $this->db->join("assessment_goal b", "a.goal_id = b.id", "left");
        $this->db->join("assessment_genre c", "a.genre_id = c.id", "left");
        $this->db->join("student_assessment d", "a.assessment_id = d.id", "left");
        $this->db->where("a.assessment_id", $assessment_id);
        $assessment_data = $this->db->get()->result_array();

        $all_data = array();
        //$aggregate_analysis = array();

        foreach ($assessment_data as $assessment_data_row) {

            $this->db->select("a.analysis_name");
            $this->db->from('assessment_analysis a');
            $this->db->where("a.assessment_id", $assessment_data_row['assessment_id']);
            $this->db->where("a.step_id", $assessment_data_row['step_id']);
            $assessment_analysis = $this->db->get()->result_array();

            foreach ($assessment_analysis as $assessment_analysis_row) {
                //array_push($aggregate_analysis, $assessment_analysis_row['analysis_name']);
                $aggregate_analysis .= $assessment_analysis_row['analysis_name'] . '| ';
            }

            array_push($all_data, array(
                'assessment_id' => $assessment_data_row['assessment_id'],
                'assessment_name' => $assessment_data_row['assessment_name'],
                'genre_name' => $assessment_data_row['genre_name'],
                'goal_name' => $assessment_data_row['goal_name'],
                'level' => $assessment_data_row['level'],
                'step_name' => $assessment_data_row['step_name'],
                'step_measure' => $assessment_data_row['step_measure'],
                'step_id' => $assessment_data_row['step_id'],
                'assessment_analysis' => $aggregate_analysis,
            ));
        }

        //echo '<pre>';
        //print_r($all_data);
        //echo '</pre>';

        $file_name = $assessment_data_row['assessment_id'] . '-' . $assessment_data_row['assessment_name'] . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Type: application/csv;");

        // get data 
        //$student_data = $this->export_csv_model->fetch_data();
        // file creation 
        $file = fopen('php://output', 'w');
        fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        $header = array("assessment_name", "genre_name");
        fputcsv($file, $header);
        foreach ($all_data as $key => $value) {
            fputcsv($file, $value);
        }
        fclose($file);
        exit;
    }

    function fix_blog_tag() {
        $this->if_user_login();

        $this->db->where('post_type', 3);
        $this->db->delete('tag_used');

        $this->db->select("a.*");
        $this->db->from("frontend_blog a");
        $this->db->where('active', 1);
        $blog_data = $this->db->get()->result_array();

        $array_blog_ss = array('8', '10', '11', '12', '13', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '29', '30', '31');

        foreach ($blog_data as $blog_data_row) {

            if (!in_array($blog_data_row['frontend_blog_id'], $array_blog_ss)) {
                //echo $blog_data_row['frontend_blog_id'] . ' - ' . $blog_data_row['tags_blog'];
                //echo '<br>';

                $tags = explode(",", $blog_data_row['tags_blog']);

                foreach ($tags as $tags_row) {

                    //echo $tags_row;
                    //echo '<br>';

                    $questions_specialties_taq['post_id'] = $blog_data_row['frontend_blog_id'];
                    $questions_specialties_taq['post_type'] = 3; //يعني مدونة
                    $questions_specialties_taq['tag_id'] = $tags_row;
                    $questions_specialties_taq['user_id'] = $this->session->userdata('userweb_id');
                    $questions_specialties_taq['date'] = date("Y-m-d H:i:s");
                    $this->db->insert('tag_used', $questions_specialties_taq);
                }
            }
        }
    }

    function fix_old_section_taheelweb() {
        $this->if_user_login();

        $this->db->select("a.*");
        $this->db->from("class a");
        $class_data = $this->db->get()->result_array();

        $ccc = 0;

        foreach ($class_data as $class_data_row) {

            $num_rows_class_id = $this->db->get_where('section', array('class_id' => $class_data_row['class_id']))->num_rows();

            if ($num_rows_class_id > 0) {
                
            } else {

                $data_registration_4['class_id'] = $class_data_row['class_id'];
                $data_registration_4['name'] = $class_data_row['name'];
                $data_registration_4['nick_name'] = $class_data_row['name'];
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

                $ccc++;
            }
        }
        echo $ccc;
        echo '<br />';
        echo 'done';
    }

    /*
      function add_wm() {
      if ($this->session->userdata('user_login') != 1) {
      redirect(base_url(), 'refresh');
      return;
      }

      $data['name'] = 'الوعد مطر';
      $data['phone'] = '0790112087';
      $data['email'] = 'waadmatter993@gmail.com';
      $data['password'] = sha1('0790112087');
      $data['date_added'] = date("Y-m-d H:i:s");
      $data['last_login'] = date("Y-m-d H:i:s");
      $data['key_pass'] = '0790112087';

      $this->db->insert('technical_support', $data);
      echo 'done';
      }
     */

    function preparing_data_for_afac() {
        $this->if_user_login();
        /*
          $this->db->select("a.*");
          $this->db->from("student a");
          $this->db->where("a.active", 1);
          $students = $this->db->get()->result_array();

          $c_stu = 1;
          foreach ($students as $students_row) {

          $data_stu['name'] = 'الطالب ' . $c_stu;

          $this->db->where('student_id', $students_row['student_id']);
          $this->db->update('student', $data_stu);

          $c_stu++;
          }

          echo 'done student';
          echo '<br />';
         */

        $this->db->select("a.*");
        $this->db->from("employee a");
        $this->db->where("a.active", 1);
        $employees = $this->db->get()->result_array();

        $c_emp = 1;
        foreach ($employees as $employees_row) {

            //$employees_row['no_identity']

            $data_emp['password'] = sha1($employees_row['no_identity']);
            $data_emp['key_pass'] = $employees_row['no_identity'];

            $this->db->where('employee_id', $employees_row['employee_id']);
            $this->db->update('employee', $data_emp);

            $c_emp++;
        }

        echo 'done employee';
        echo '<br />';

        $this->db->select("a.*");
        $this->db->from("parent a");
        $this->db->where("a.active", 1);
        $parents = $this->db->get()->result_array();

        //$c_par = 1;
        foreach ($parents as $parents_row) {

            $data_per['password'] = sha1($parents_row['phone']);
            $data_per['key_pass'] = $parents_row['phone'];

            $this->db->where('parent_id', $parents_row['parent_id']);
            $this->db->update('parent', $data_per);

            $c_emp++;
        }

        echo 'done parent';
    }

    function website_slide() {
        $this->if_user_login();
        $page_data['page_name'] = 'website_slide';
        $page_data['page_title'] = '';

        $this->load->view('backend/index', $page_data);
    }

    //

    function website_slide_add($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add_new') {

            $data['encrypt_thread'] = bin2hex(random_bytes(32));
            $data['name'] = $this->input->post('title');
            $data['description'] = $this->input->post('short_description');
            $data['posted_slide_home'] = $this->input->post('published');
            $data['website_slide_post'] = $this->input->post('blog_post');
            $data['slide_home'] = $this->input->post('photo');
            $data['date_added'] = date("Y-m-d H:i:s");

            $this->db->insert('features_taheelweb', $data);

            $blog_id_new = $this->db->insert_id();

            $its_number = $this->db->insert_id();

            //redirect(site_url('blog/blog/'), 'refresh');
        }

        $page_data['page_name'] = 'website_slide_add';
        $page_data['page_title'] = '';

        $this->load->view('backend/index', $page_data);
    }

    function add_new_img_website_slide() {
        $this->if_user_login();
        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));

        $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;
        if ($c_name == 'taheelweb') {
            $folder = 'uploads/website_slide/';
        } else {
            $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/blog_images/';
        }

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
        $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
        $name = $uname . '.' . $info->getExtension();

        $results = array(
            'url' => $relative_path,
            'name' => $uname . '.' . $info->getExtension(),
            'fileName' => $_FILES['file']['name']
        );

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function get_data_website_slide() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("features_taheelweb a");
        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where("active", 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function website_slide_edit($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'edit') {

            $data['name'] = $this->input->post('title');
            $data['description'] = $this->input->post('short_description');
            $data['posted_slide_home'] = $this->input->post('published');
            $data['website_slide_post'] = $this->input->post('blog_post');

            if ($this->input->post('photo') != null) {
                $data['slide_home'] = $this->input->post('photo');
            }

            $this->db->where('id', $param2);
            $this->db->update('features_taheelweb', $data);

            //redirect(site_url('blog/blog/'), 'refresh');
        }

        $page_data['page_name'] = 'website_slide_edit';
        $page_data['page_title'] = '';
        $page_data['features_encrypt_thread'] = $param1;

        $this->load->view('backend/index', $page_data);
    }

    function fex_afac_sec() {
        $this->if_user_login();
        $section = $this->db->get_where('section')->result_array();

        foreach ($section as $section_row) {

            echo $if_section_schedule = $this->db->get_where('section_schedule', array('section_id' => $section_row['section_id']))->num_rows();
            echo '<br />';
            echo $section_row['section_id'];
            echo '<br />';
            echo '---------------';
            echo '<br />';

            if ($if_section_schedule == 0) {
                $data['section_id'] = $section_row['section_id'];
                $data['start_date'] = '2024-09-01';
                $data['end_date'] = '2025-06-01';
                $data['year'] = '2024-2025';
                $this->db->insert("section_schedule", $data);
            }
        }
    }

    function empty_data($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        //truncate
        if ($param1 == 5354530) {
            $this->db->where("parent_id <> -1")->truncate("parent");
            $this->db->where("parent_id <> -1")->truncate("student");
            $this->db->where("student_id <> -1")->truncate("enroll");
            $this->db->where("student_id <> -1")->truncate("student_parent");
            $this->db->where("employee_id <> -1")->truncate("employee");
            $this->db->where("id <> -1")->truncate("assessment_case");
            $this->db->where("id <> -1")->truncate("all_files");
            $this->db->where("attendance_id <> -1")->truncate("attendance");
            $this->db->where("attendance_employee_id <> -1")->truncate("attendance_employee");
            $this->db->where("id <> -1")->truncate("behavioral_problems");
            $this->db->where("id <> -1")->truncate("book_visit");
            $this->db->where("case_study_id <> -1")->truncate("case_study");
            $this->db->where("chat_id <> -1")->truncate("chat");
            $this->db->where("id <> -1")->truncate("chat_contacts");
            $this->db->where("chat_thread_id <> -1")->truncate("chat_thread");
            $this->db->where("database_history_id <> -1")->truncate("database_history");
            $this->db->where("file_manager_id <> -1")->truncate("file_manager");
            $this->db->where("file_manager_folder_id <> -1")->truncate("file_manager_folder");
            $this->db->where("history_evaluation_employee_id <> -1")->truncate("history_evaluation_employee");
            $this->db->where("history_student_withdrawals_id <> -1")->truncate("history_student_withdrawals");
            $this->db->where("invoice_id <> -1")->truncate("invoice");
            $this->db->where("id <> -1")->truncate("invoice_items");
            $this->db->where("id <> -1")->truncate("monthly_plan_analysis");
            $this->db->where("id <> -1")->truncate("monthly_plan_steps");
            $this->db->where("id <> -1")->truncate("monthly_plan");
            $this->db->where("id <> -1")->truncate("parents_poll_send");
            $this->db->where("id <> -1")->truncate("parents_send");
            $this->db->where("id <> -1")->truncate("parents_submitted_poll");
            $this->db->where("payment_id <> -1")->truncate("payment");
            $this->db->where("section_employee_id <> -1")->truncate("section_employee");
            $this->db->where("id <> -1")->truncate("employee_classes");
            $this->db->where("id <> -1")->truncate("section_schedule");
            $this->db->where("id <> -1")->truncate("section_schedule_subject");
            $this->db->where("students_to_specialists_id <> -1")->truncate("students_to_specialists");
            $this->db->where("id <> -1")->truncate("student_behaviour");
            $this->db->where("id <> -1")->truncate("student_behaviour_reptitions");
            $this->db->where("id <> -1")->truncate("student_behaviour_strategy");
            $this->db->where("id <> -1")->truncate("student_plan");
            $this->db->where("id <> -1")->truncate("student_plan_analysis");
            $this->db->where("id <> -1")->truncate("student_plan_steps");
            $this->db->where("id <> -1")->truncate("student_record");
            $this->db->where("student_services_id <> -1")->truncate("student_services");
            $this->db->where("id <> -1")->truncate("supervisor_report_step");
            $this->db->where("id <> -1")->truncate("term");
            $this->db->where("id <> -1")->truncate("track_time_for_pages");
            $this->db->where("user_records_id <> -1")->truncate("user_records");
            $this->db->where("id <> -1")->truncate("vbmapp_assessment_case");
            $this->db->where("id <> -1")->truncate("vbmapp_assessment_mastered");
            $this->db->where("id <> -1")->truncate("vbmapp_plane");
            $this->db->where("id <> -1")->truncate("vbmapp_plane_analysis");
            $this->db->where("id <> -1")->truncate("vbmapp_plane_goal");
        }
    }

    function forms($param1 = '', $param2 = '') {
        $this->if_user_login();

        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        if ($param1 == 'create') {
            if ($this->input->post('name') != '') {
                //$poll_en = $this->processes_model->create_poll();

                $data['encrypt_thread'] = bin2hex(random_bytes(24));
                $data['name'] = $this->input->post('name');
                //$data['class_id'] = $this->input->post('class_id');
                //$data['job_title_id'] = $this->input->post('job_title_id');
                $data['instruction'] = $this->input->post('instruction');

                $this->db->insert('form_manage', $data);
            } else {
                $this->session->set_flashdata('error_message', $this->lang->line('make_sure_to_select_valid_class_') . ',' . $this->lang->line('_section_and_subject'));
                redirect(site_url('user/poll'), 'refresh');
            }
        }
        if ($param1 == 'edit') {
            if ($this->input->post('class_id') != '' || $this->input->post('job_title_id') != '') {
                $this->processes_model->update_evaluation();
                $this->session->set_flashdata('flash_message', $this->lang->line('data_updated_successfully'));
                redirect(site_url('user/poll'), 'refresh');
            }
        }

        if ($param1 == 'delete') {

            $query = $this->db->get_where('history_evaluation_employee', array('evaluation_management_id' => $param2));

            if ($query->num_rows() < 1) {
                $this->db->where('evaluation_id', $param2);
                $this->db->delete('evaluation_items');
                $this->db->where('evaluation_management_id', $param2);
                $this->db->delete('evaluation_management');
                $this->session->set_flashdata('flash_message', $this->lang->line('data_deleted'));
                redirect(site_url('user/evaluation_management'), 'refresh');
            } else {

                $data['status'] = 'disabled';
                $this->db->where('evaluation_management_id', $param2);
                $this->db->update('evaluation_management', $data);
                $this->session->set_flashdata('error_message', $this->lang->line('disabled_assessment'));
                redirect(site_url('user/evaluation_management'), 'refresh');
            }
        }

        //$page_data['page_name'] = 'poll';
        //$page_data['status'] = 'active';
        //$page_data['page_title'] = $this->lang->line('poll');
        //$this->load->view('backend/index', $page_data);
    }

    function form_add() {
        $this->if_user_login();

        $page_data['page_name'] = 'form_add';
        $page_data['page_title'] = "اضافة نموذج"; //$this->lang->line('poll_add');
        $this->load->view('backend/index', $page_data);
    }

    function forms_management() {
        $this->if_user_login();

        $page_data['page_name'] = 'forms_management';
        $page_data['page_title'] = "ادارة النماذج"; //$this->lang->line('poll_add');
        $this->load->view('backend/index', $page_data);
    }

    function form_items($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'form_items';
        $page_data['form_encrypt_thread'] = $param1;
        $page_data['page_title'] = "ادارة النموذج"; //$this->lang->line('poll_add');
        $this->load->view('backend/index', $page_data);
    }

    function load_question_type_form($type = "", $form_id = "") {
        $this->if_user_login();
        $page_data['question_type'] = $type;
        $page_data['form_id'] = $form_id;
        $this->load->view('backend/user/form_add_' . $type, $page_data);
    }

    function manage_form_question($form_id = "", $task = "", $type = "") {
        $this->if_user_login();

        if ($task == 'add') {
            if ($type == 'multiple_choice') {

                //$this->crud_model->add_multiple_choice_question_to_poll($poll_id);

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
                $data['form_manage_id'] = $form_id;
                $data['question_title'] = html_escape($this->input->post('question_title'));
                //$data['mark'] = html_escape($this->input->post('mark'));
                $data['number_of_options'] = html_escape($this->input->post('number_of_options'));
                $data['type'] = 'multiple_choice';
                $data['options'] = json_encode($this->input->post('options'), JSON_UNESCAPED_UNICODE);
                //$data['correct_answers'] = json_encode($correct_answers, JSON_UNESCAPED_UNICODE);
                $this->db->insert('form_items', $data);
                $this->session->set_flashdata('flash_message', $this->lang->line('question_added'));
            }
        } elseif ($type == 'true_false') {
            $this->crud_model->add_true_false_question_to_poll($poll_id);
        } elseif ($type == 'fill_in_the_blanks') {
            $this->crud_model->add_fill_in_the_blanks_question_to_poll($poll_id);
        }

        $form_en = $this->db->get_where('form_manage', array('id' => $form_id))->row()->encrypt_thread;

        redirect(site_url('user/form_items/' . $form_en), 'refresh');
    }

    function manage_multiple_choices_options_form() {
        $this->if_user_login();
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/user/poll_manage_multiple_choices_options', $page_data);
    }

    function form_student() {
        $this->if_user_login();
        $page_data['page_name'] = 'form_student';
        $page_data['page_title'] = "نماذج الطلاب";
        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    function form_student_apply($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        $page_data['page_name'] = 'form_student';
        $page_data['page_title'] = "نماذج الطلاب";
        $page_data['form_student_apply'] = $param1;

        //$page_data['print_type'] = $type;

        $this->load->view('backend/index', $page_data);
    }

    function get_data_form_student() {
        $this->if_user_login();

        $login_type = $this->session->userdata('login_type');
        $superuser = $login_type == 'technical_support' || $login_type == 'admin';
        $user_level = $this->session->userdata('level');
        $employee_id = $this->session->userdata('employee_id');
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        $section_ids = array();
        $json_data = array();

        if ($login_type == 'parent') {
            $this->db->select("a.* , b.name as student_name , b.gender,b.img_type,b.img_url as img ,c.class_id, c.name as class_name, d.section_id, d.name as section_name");
            $this->db->from("enroll a");
            $this->db->join("student b", "a.student_id = b.student_id", 'left');
            $this->db->join("class c", "a.class_id = c.class_id", 'left');
            $this->db->join("section d", "a.section_id = d.section_id", 'left');
            $this->db->join("student_parent e", "a.student_id = e.student_id", 'left');
            $this->db->where('e.parent_id', $this->session->userdata('login_user_id'));
            $this->db->where("a.year", $running_year);
            $this->db->where('a.status', 1);
            $students = $this->db->get()->result_array();
        } elseif ($user_level == 1) {
            $this->db->select("a.section_id");
            $this->db->from("section_employee a");
            $this->db->where("a.employee_id", $employee_id);
            $this->db->where('a.active', 1);
            $sections = $this->db->get()->result_array();

            foreach ($sections as $sections_row) {
                array_push($section_ids, $sections_row['section_id']);
            }

            $this->db->select("a.* , b.name as student_name , b.gender as gender,b.img_type as img_type,b.img_url as img ,c.class_id, c.name as class_name, d.section_id, d.name as section_name");
            $this->db->from("behavioral_problems a");
            $this->db->join("student b", "a.student_id = b.student_id", 'left');
            $this->db->join("enroll f", "a.student_id = f.student_id", 'left');
            $this->db->join("class c", "f.class_id = c.class_id", 'left');
            $this->db->join("section d", "f.section_id = d.section_id", 'left');

            $this->db->where("a.year", $running_year);
            $this->db->where_in('f.section_id', $section_ids);
            $this->db->where('f.status', 1);
            $this->db->group_by('a.student_id');
            $students = $this->db->get()->result_array();
        } elseif ($user_level == 2) {

            $this->db->select("a.* , b.name as student_name , b.gender as gender,b.img_type as img_type,b.img_url as img ,c.class_id, c.name as class_name, d.section_id, d.name as section_name");
            $this->db->from("behavioral_problems a");
            $this->db->join("student b", "a.student_id = b.student_id", 'left');
            $this->db->join("enroll f", "a.student_id = f.student_id", 'left');
            $this->db->join("class c", "f.class_id = c.class_id", 'left');
            $this->db->join("section d", "f.section_id = d.section_id", 'left');
            $this->db->join("students_to_specialists e", "a.student_id = e.student_id", 'left');
            $this->db->where("f.year", $running_year);
            $this->db->where('f.status', 1);
            $this->db->where("e.employee_id", $employee_id);
            $this->db->where("e.year", $running_year);
            $this->db->where("e.active", 1);
            $this->db->group_by('a.student_id');
            $students = $this->db->get()->result_array();
        } else {
            $this->db->select("a.* , b.name as student_name , b.gender,b.img_type,b.img_url as img ,c.class_id, c.name as class_name, d.section_id, d.name as section_name");
            $this->db->from("behavioral_problems a");
            $this->db->join("student b", "a.student_id = b.student_id", 'left');
            $this->db->join("enroll f", "a.student_id = f.student_id", 'left');
            $this->db->join("class c", "f.class_id = c.class_id", 'left');
            $this->db->join("section d", "f.section_id = d.section_id", 'left');
            $this->db->where("f.year", $running_year);
            $this->db->where('f.status', 1);
            $this->db->group_by('a.student_id');
            $students = $this->db->get()->result_array();
        }

        foreach ($students as $students_row) {

            $student_behaviour_array = array();

            $this->db->select("a.*");
            $this->db->from("behavioral_problems a");
            $this->db->where("a.student_id", $students_row['student_id']);
            $this->db->where("a.year", $running_year);
            $this->db->where('a.active', 1);
            $student_behaviour = $this->db->get()->result_array();

            foreach ($student_behaviour as $student_behaviour_row) {

                $datetime_stamp = explode(" ", $student_behaviour_row['datetime_stamp']);

                array_push($student_behaviour_array, array(
                    'id' => $student_behaviour_row['id'],
                    'behavioral_problems' => $student_behaviour_row['behavioral_problems'],
                    'student_id' => $student_behaviour_row['student_id'],
                    'note' => $student_behaviour_row['note'],
                    'active' => $student_behaviour_row['active'],
                    'user_id' => $student_behaviour_row['user_id'],
                    'datetime_stamp' => $datetime_stamp[0],
                    'encrypt_thread' => $student_behaviour_row['encrypt_thread'],
                ));
            }


            array_push($json_data, array(
                'student_name' => $students_row['student_name'],
                'gender' => $students_row['gender'],
                'img_type' => $students_row['img_type'],
                'img' => $students_row['img'],
                'class_id' => $students_row['class_id'],
                'class_name' => $students_row['class_name'],
                //'section_id' => $students_row['section_id'],
                //'section_name' => $students_row['section_name'],
                'behavioral_problems' => $student_behaviour_array,
            ));
        }

        $students_json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        $by_field = "name";

        $this->array_json->array_json($students_json, $by_field);
    }

    function post_form_student() {
        $this->if_user_login();
        $year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
        //form_id

        $poll_send_times_data['form_id'] = $_POST['form_id'];
        $poll_send_times_data['date_send'] = date('Y-m-d H:i:s');
        //$poll_send_times_data['expires_in'] = $this->input->post('expires_in');

        $this->db->insert('form_send_times', $poll_send_times_data);
        $form_send_times_id = $this->db->insert_id();

        $data['form_id'] = $_POST['form_id'];
        $data['user_id'] = $_POST['student_id'];
        $data['user_type'] = 'student';
        $data['date_send'] = date('Y-m-d H:i:s');
        //$data['expires_in'] = $this->input->post('expires_in');
        //$data['class_id'] = $all_employee_row['class_id'];
        $data['form_send_times_id'] = $form_send_times_id;

        $this->db->insert('form_send', $data);
        //$behaviour["datetime_stamp"] = date('Y-m-d H:i:s');

        $form_id = $this->db->insert_id();

        echo json_encode($form_id, JSON_UNESCAPED_UNICODE);
    }

    function activity_a($class_id = '') {
        $this->if_user_login();

        $this->db->select("a.*");
        $this->db->from("record_logins a");
        //$this->db->join("enroll b", "a.student_id = b.student_id", 'left');
        //$this->db->where('a.active', 1);
        $this->db->where('a.class_id', 1);
        $this->db->group_by('a.job_title_id');
        $students = $this->db->get()->result_array();

        foreach ($students as $row) {
            $this->db->select("a.*");
            $this->db->from("record_logins a");
            //$this->db->join("enroll b", "a.student_id = b.student_id", 'left');
            //$this->db->where('a.active', 1);
            $this->db->where('a.class_id', 1);
            $this->db->where('a.job_title_id', $row['job_title_id']);
            $this->db->group_by('a.job_title_id');
            echo $students = $this->db->get()->num_rows();
            echo '<br />';
        }
    }

    function attendance_panel_employee() {
        $this->if_user_login();
        $page_data['month'] = date('m');
        $page_data['page_name'] = 'attendance_panel_employee';
        $page_data['page_title'] = "";

        $this->load->view('backend/index', $page_data);
    }

    function attendance_panel_report_employee() {
        $this->if_user_login();

        $data['class_id'] = $_POST['class_id'];
        $data['month'] = $_POST['month'];
        $data['sessional_year'] = $_POST['sessional_year'];

        $data['start_date'] = $_POST['start_date'];
        $data['end_date'] = $_POST['end_date'];

        //$page_data['month'] = date('m');
        //$page_data['page_name'] = 'attendance_panel_report_view_employee';
        //$page_data['page_title'] = "";
        //$this->load->view('backend/index', $page_data);
        redirect(site_url('user/attendance_panel_report_view_employee/' . $data['class_id'] . '/' . $data['start_date'] . '/' . $data['end_date']), 'refresh');
    }

    function attendance_panel_report_view_employee($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['class_id'] = $param1;

        //$page_data['month'] = $param2;
        //$page_data['sessional_year'] = $param3;

        $page_data['start_date'] = $param2;
        $page_data['end_date'] = $param3;

        //$page_data['month'] = date('m');
        $page_data['page_name'] = 'attendance_panel_report_view_employee';
        $page_data['page_title'] = "";

        $this->load->view('backend/index', $page_data);
    }

    //تم استخدامها لحل مشكلة حساب العمر لمركز أفاق لخطأ في اداخال بيانات تاريخ الميلاد
    function fix_d_b_s($param = "") {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("student a");
        $students = $this->db->get()->result_array();

        foreach ($students as $students_row) {


            if ($students_row['type_birth'] == 1) {

                echo $students_row['student_id'] . ' - ' . $students_row['birthday'];
                //die();
                //2020-20-05
                $birthday_ex = explode("-", $students_row['birthday']);

                //echo '<pre>';
                //print_r($birthday_ex);
                //echo '</pre>';
                //10-31-2019
                echo '<br />';
                $day_birth = $birthday_ex[0];
                $month_birth = $birthday_ex[1];
                $year_birth = $birthday_ex[2];

                //$data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;
                $data['birthday'] = $year_birth . '-' . $month_birth . '-' . $day_birth;
                echo '<br />';
                echo '<br />';
                echo '<br />';
                $this->db->where('student_id', $students_row['student_id']);
                $this->db->update('student', $data);
            }
        }
    }

    function empty_data_bn($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        //truncate
        if ($param1 == 5354530) {
            $this->db->where("parent_id <> -1")->truncate("parent");
            $this->db->where("student_id <> -1")->truncate("student");
            $this->db->where("student_id <> -1")->truncate("enroll");
            $this->db->where("student_id <> -1")->truncate("student_parent");
            //$this->db->where("employee_id <> -1")->truncate("employee");
            $this->db->where("id <> -1")->truncate("assessment_case");
            $this->db->where("id <> -1")->truncate("all_files");
            $this->db->where("attendance_id <> -1")->truncate("attendance");
            $this->db->where("attendance_employee_id <> -1")->truncate("attendance_employee");
            $this->db->where("id <> -1")->truncate("behavioral_problems");
            $this->db->where("id <> -1")->truncate("book_visit");
            $this->db->where("case_study_id <> -1")->truncate("case_study");
            $this->db->where("chat_id <> -1")->truncate("chat");
            $this->db->where("id <> -1")->truncate("chat_contacts");
            $this->db->where("chat_thread_id <> -1")->truncate("chat_thread");
            $this->db->where("database_history_id <> -1")->truncate("database_history");
            $this->db->where("file_manager_id <> -1")->truncate("file_manager");
            $this->db->where("file_manager_folder_id <> -1")->truncate("file_manager_folder");
            $this->db->where("history_evaluation_employee_id <> -1")->truncate("history_evaluation_employee");
            $this->db->where("history_student_withdrawals_id <> -1")->truncate("history_student_withdrawals");
            $this->db->where("invoice_id <> -1")->truncate("invoice");
            $this->db->where("id <> -1")->truncate("invoice_items");
            $this->db->where("id <> -1")->truncate("monthly_plan_analysis");
            $this->db->where("id <> -1")->truncate("monthly_plan_steps");
            $this->db->where("id <> -1")->truncate("monthly_plan");
            $this->db->where("id <> -1")->truncate("parents_poll_send");
            $this->db->where("id <> -1")->truncate("parents_send");
            $this->db->where("id <> -1")->truncate("parents_submitted_poll");
            $this->db->where("payment_id <> -1")->truncate("payment");
            //$this->db->where("section_employee_id <> -1")->truncate("section_employee");
            //$this->db->where("id <> -1")->truncate("employee_classes");
            $this->db->where("id <> -1")->truncate("section_schedule");
            $this->db->where("id <> -1")->truncate("section_schedule_subject");
            $this->db->where("students_to_specialists_id <> -1")->truncate("students_to_specialists");
            $this->db->where("id <> -1")->truncate("student_behaviour");
            $this->db->where("id <> -1")->truncate("student_behaviour_reptitions");
            $this->db->where("id <> -1")->truncate("student_behaviour_strategy");
            $this->db->where("id <> -1")->truncate("student_plan");
            $this->db->where("id <> -1")->truncate("student_plan_analysis");
            $this->db->where("id <> -1")->truncate("student_plan_steps");
            $this->db->where("id <> -1")->truncate("student_record");
            $this->db->where("student_services_id <> -1")->truncate("student_services");
            $this->db->where("id <> -1")->truncate("supervisor_report_step");
            $this->db->where("id <> -1")->truncate("term");
            $this->db->where("id <> -1")->truncate("track_time_for_pages");
            $this->db->where("user_records_id <> -1")->truncate("user_records");
            $this->db->where("id <> -1")->truncate("vbmapp_assessment_case");
            $this->db->where("id <> -1")->truncate("vbmapp_assessment_mastered");
            $this->db->where("id <> -1")->truncate("vbmapp_plane");
            $this->db->where("id <> -1")->truncate("vbmapp_plane_analysis");
            $this->db->where("id <> -1")->truncate("vbmapp_plane_goal");
        }
    }

    function update_pass_pernt() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("parent a");
        $this->db->where("a.active", 1);
        $this->db->order_by('a.name', 'ASC');
        $parents = $this->db->get()->result_array();

        foreach ($parents as $parents_row) {

            $this->db->select("a.no_identity");
            $this->db->from("student a");
            $this->db->join("student_parent b", "a.student_id = b.student_id", 'left');
            //$this->db->join('class c', 'a.class_id = c.class_id', 'left');
            $this->db->where("b.parent_id", $parents_row['parent_id']);
            $this->db->where("a.active", 1);
            $this->db->where("b.active", 1);
            $student_array = $this->db->get()->row();

            $entry = array(
                'password' => sha1($student_array->no_identity),
                'key_pass' => $student_array->no_identity,
            );

            $this->db->where('parent_id', $parents_row['parent_id']);
            $this->db->update('parent', $entry);
        }
    }

    function plans_statistics($param1 = '') {
        $this->if_user_login();

        $page_data['class_id'] = $param1;
        $page_data['page_name'] = 'plans_statistics';
        $page_data['page_title'] = "";

        $this->load->view('backend/index', $page_data);
    }

    function ttt() {
        $this->if_user_login();
        $email = "0537860702";
        echo $zero_phone = substr($email, 0, 1);
        if ($zero_phone == 0) {
            echo '<br />';
            echo 'hi1';
            echo '<br />';
            echo $email_2 = $email;
            echo '<br />';
            echo $email = substr($email_2, 1);
            echo '<br />';
        } elseif ($zero_phone != '0') {
            echo '<br />';
            echo 'hi2';
            echo '<br />';
            echo $email = $email;
            echo '<br />';
        }
        if (is_numeric($email)) {
            echo '<br />';
            echo 'nnnn';
            $credential = array('phone' => $email, 'password' => sha1($password));
            echo '<br />';
            print_r($credential);
        } else {
            $credential = array('email' => $email, 'password' => sha1($password));
            print_r($credential);
        }
    }

    function import_metrics_csv() {
        $this->if_user_login();
        $fp = fopen('assets/csv/mv1.csv', 'r') or die("can't open file");
        //uploads  
        // Ignore header line 
        $header = fgetcsv($fp);
        $mapp = array();
        $sub_goal = array();

        while ($csv_line = fgetcsv($fp)) {
            $data_main_goal = array(
                'name' => $csv_line[0],
                'metrics_areas_id' => $csv_line[1],
                'metrics_id' => $csv_line[2],
            );

            //course_subscribers
            $checksub = $this->db->get_where('metrics_items', array('name' => $data_main_goal['name'], 'metrics_areas_id' => $data_main_goal['metrics_areas_id']))->num_rows();
            if ($checksub > 0) {
                
            } else {
                $this->db->insert('metrics_items', $data_main_goal);
                array_push($mapp, $data_main_goal);
            }
            //$main_goal_id = $this->db->insert_id();
        }

        echo '<pre>';
        print_r($mapp);
        die();
    }

    function fix_pd($param = "") {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("student a");
        $students = $this->db->get()->result_array();

        foreach ($students as $students_row) {

            //if ($students_row['type_birth'] == 1) {
            //echo $students_row['student_id'] . ' - ' . $students_row['birthday'];
            //die();
            //2020-20-05
            $birthday_ex = explode("-", $students_row['birthday']);

            //echo '<pre>';
            //print_r($birthday_ex);
            //echo '</pre>';
            //10-31-2019
            //echo '<br />';
            $day_birth = $birthday_ex[0];
            $month_birth = $birthday_ex[1];
            $year_birth = $birthday_ex[2];

            if (strlen($day_birth) != 4) {

                $day_birth = $birthday_ex[0];
                $month_birth = $birthday_ex[1];
                //echo $year_birth = $birthday_ex[2];
                echo '<br />';
                echo $data['birthday'] = $year_birth . '-' . $month_birth . '-' . $day_birth;
                echo '<br />';
                $this->db->where('student_id', $students_row['student_id']);
                $this->db->update('student', $data);
            }


            //$data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;
            //$data['birthday'] = $year_birth . '-' . $month_birth . '-' . $day_birth;
            //echo '<br />';
            //echo '<br />';
            //echo '<br />';
            //}
        }
    }

    function set_class_id_for_schedule_subject($param = "") {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("schedule_subject a");
        $schedule_subject = $this->db->get()->result_array();

        foreach ($schedule_subject as $schedule_subject_row) {
            $this->db->select("a.*");
            $this->db->from("schedule a");
            $this->db->where("a.id", $schedule_subject_row['schedule_id']);
            $class_is_schedule = $this->db->get()->row();

            $data['class_id'] = $class_is_schedule->class_id;

            $this->db->where('id', $schedule_subject_row['id']);
            $this->db->update('schedule_subject', $data);
        }
    }

    function moved_drafts_to_deleted_panel() {
        $this->if_user_login();
        $this->db->select("a.id, a.student_id");
        $this->db->from("assessment_draft a");
        // إضافة شرط للتحقق من أن التاريخ الحالي أكبر من datetime_stamp بـ 21 يومًا
        $this->db->where("NOW() >", "DATE_ADD(a.datetime_stamp, INTERVAL 21 DAY)", false);
        $this->db->where("a.active", 1);
        $assessment_draft = $this->db->get()->result_array();

        foreach ($assessment_draft as $assessment_draft_row) {

            $data['active'] = 0;

            $this->db->where('id', $assessment_draft_row['id']);
            $this->db->update('assessment_draft', $data);

            $deleted_items_records = array(
                'type' => 'assessment_draft',
                'id_type' => $assessment_draft_row["id"],
                'item_for' => $assessment_draft_row["student_id"],
                'type_user' => "system",
                'user_id' => "",
                'date_deleted' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('deleted_items', $deleted_items_records);
        }
    }

    function delete_drafts_auto() {
        //$this->if_user_login();

        $this->db->select("a.*");
        $this->db->from("deleted_items a");
        $this->db->where("NOW() >", "DATE_ADD(a.date_deleted, INTERVAL 14 DAY)", false);
        $this->db->where("a.type", 'assessment_draft');
        //$this->db->where("a.active", 1);
        $assessment_draft = $this->db->get()->result_array();

        foreach ($assessment_draft as $assessment_draft_row) {
            $this->db->where("id", $assessment_draft_row['id_type']);
            $this->db->where("active", 0);
            $this->db->delete('assessment_draft');

            $data['active'] = 0;
            $this->db->where('id', $assessment_draft_row['id']);
            $this->db->update('deleted_items', $data);
        }
    }

    function console_log_records() {
        $this->if_user_login();
        $console_log_records = array(
            'user_type' => $this->session->userdata('login_type'),
            'user_id' => $this->session->userdata('login_user_id'),
            'page_name' => $_POST['page_name'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'timestamp' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('console_log_records', $console_log_records);
    }

    public function list_controllers() {
        $this->if_user_login();
        // تحديد المسار إلى مجلد Controllers
        $controllers_path = APPPATH . 'controllers'; // مسار مجلد Controllers
        $controllers = [];

        // استخدام RecursiveIteratorIterator لاستعراض جميع الملفات داخل المجلد
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($controllers_path));

        // استعراض الملفات
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                // قراءة محتوى الملف للتحقق من فئة Controller
                $content = file_get_contents($file->getPathname());
                // البحث عن فئة Controller باستخدام تعبير منتظم
                if (preg_match('/class\s+(\w+)\s+extends\s+CI_Controller/', $content, $matches)) {
                    // إضافة اسم الفئة إلى المصفوفة
                    $controllers[] = $matches[1];
                }
            }
        }

        // عرض النتيجة
        echo "<pre>";
        print_r($controllers);
        echo "</pre>";
    }

    function student_waad() {

        $this->db->select("a.*,b.*");
        $this->db->from("enroll a");
        $this->db->join("student b", "a.student_id = b.student_id", 'left');
        $this->db->where('a.status', 1);
        $this->db->where('a.class_id', 4);
        $this->db->where('a.year', "2024-2025");
        $this->db->order_by('b.name', 'ASC');
// $this->db->group_by('a.class_id');
        $students = $this->db->get()->result_array();

// بدء التاريخ ونهاية الفترة
        $start_date = strtotime("2024-09-01");
        $end_date = strtotime("2025-08-31");

// حساب عدد الأيام
        $total_days = ($end_date - $start_date) / (60 * 60 * 24) + 1; // عدد الأيام بين التواريخ
// التكرار لكل يوم
        for ($i = 0; $i < $total_days; $i++) {
            // توليد التاريخ
            $current_date = strtotime("+$i day", $start_date . ' H:i:s');
            //$date_att = date("Y-m-d H:i:s", $current_date);

            foreach ($students as $row) {
                $attn_data['class_id'] = $row['class_id'];
                $attn_data['year'] = $row['year'];
                $attn_data['timestamp'] = $current_date;
                $attn_data['section_id'] = $row['section_id'];
                $attn_data['student_id'] = $row['student_id'];
                $attn_data['status'] = rand(1, 2); // حالة عشوائية
                //echo '<br />';
                // Uncomment if you want to insert data into the database
                $this->db->insert('attendance', $attn_data);
            }
        }
    }

    public function export_to_excel() {
        $this->if_user_login();

        $this->db->select("d.* , c.name as job_title_name, c.job_title_id, b.class_id");
        $this->db->from("employee_classes a");
        $this->db->join('employee d', 'a.employee_id = d.employee_id', 'left');
        $this->db->join("job_title c", "d.job_title_id = c.job_title_id", 'left');
        $this->db->join("class b", "b.class_id = a.class_id", 'left');
        $this->db->where("a.active", 1);
        $this->db->where("d.active", 1);
        $this->db->where("d.virtual", 0);
        $this->db->group_by('a.employee_id');
        $this->db->order_by('d.name', 'ASC');
        $employee = $this->db->get()->result_array();

        $users = array();

        //foreach ($this->unique_multidim_array($employee, 'employee_id') as $employee_row) {
        foreach ($employee as $employee_row) {

            $this->db->select("c.name");
            $this->db->from("employee_classes a");
            //$this->db->join("section b", "a.section_id = b.section_id", 'left');
            $this->db->join('class c', 'a.class_id = c.class_id', 'left');
            $this->db->where("a.employee_id", $employee_row['employee_id']);
            $this->db->where("a.active", 1);
            $this->db->where("c.active", 1);
            $this->db->group_by('a.class_id');
            $class_array = $this->db->get()->result_array();

            array_push($users, array(
                'employee_id' => $employee_row['employee_id'],
                'employee_name' => $employee_row['name'],
                'job_title_id' => $employee_row['job_title_id'],
                'gender' => $employee_row['gender'],
                'status_login' => $employee_row['status_login'],
                'job_title_name' => $employee_row['job_title_name'],
                'class_id' => $employee_row['class_id'],
                'class_name' => $class_array,
                'key_pass' => $employee_row['key_pass'],
                'user_img' => $employee_row['user_img'],
            ));
        }

        // إنشاء ملف Excel جديد
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // إعداد الاتجاه للغة العربية
        $spreadsheet->getActiveSheet()->setRightToLeft(true);

        // إضافة العناوين
        $sheet->setCellValue('A1', 'الرقم');
        $sheet->setCellValue('B1', 'الاسم');
        $sheet->setCellValue('C1', 'المسمى الوظيفي');
        $sheet->setCellValue('D1', 'الفرع');

        // تعبئة البيانات
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user['employee_id']);
            $sheet->setCellValue('B' . $row, $user['employee_name']);
            $sheet->setCellValue('C' . $row, $user['job_title_name']);
            $sheet->setCellValue('D' . $row, implode(', ', array_column($user['class_name'], 'name')));
            $row++;
        }


        // تنسيق الخط
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->setName('Arial')->setSize(12);

        // إعداد الرأس لتحميل الملف
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users_data.xlsx"');
        header('Cache-Control: max-age=0');

        // إنشاء الملف
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_to_word() {
        $this->if_user_login();
        // تحميل مكتبة PHPWord
        // استعلام للحصول على البيانات
        $this->db->select("d.*, c.name as job_title_name, c.job_title_id, b.class_id");
        $this->db->from("employee_classes a");
        $this->db->join('employee d', 'a.employee_id = d.employee_id', 'left');
        $this->db->join("job_title c", "d.job_title_id = c.job_title_id", 'left');
        $this->db->join("class b", "b.class_id = a.class_id", 'left');
        $this->db->where("a.active", 1);
        $this->db->where("d.active", 1);
        $this->db->where("d.virtual", 0);
        $this->db->group_by('a.employee_id');
        $this->db->order_by('d.name', 'ASC');
        $employee = $this->db->get()->result_array();

        $users = [];
        foreach ($employee as $employee_row) {
            $this->db->select("c.name");
            $this->db->from("employee_classes a");
            $this->db->join('class c', 'a.class_id = c.class_id', 'left');
            $this->db->where("a.employee_id", $employee_row['employee_id']);
            $this->db->where("a.active", 1);
            $this->db->where("c.active", 1);
            $this->db->group_by('a.class_id');
            $class_array = $this->db->get()->result_array();

            $users[] = [
                'employee_id' => $employee_row['employee_id'],
                'employee_name' => $employee_row['name'],
                'job_title_name' => $employee_row['job_title_name'],
                'class_name' => $class_array,
            ];
        }

        // إنشاء مستند Word جديد
        $phpWord = new PhpWord();

        // إضافة قسم جديد
        $section = $phpWord->addSection();

        // إضافة العنوان
        $section->addText("بيانات الموظفين", array('name' => 'Arial', 'size' => 16, 'bold' => true), array('align' => 'center'));

        // إضافة الجدول
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText("الرقم", array('bold' => true));
        $table->addCell(4000)->addText("الاسم", array('bold' => true));
        $table->addCell(3000)->addText("المسمى الوظيفي", array('bold' => true));
        $table->addCell(4000)->addText("الفروع", array('bold' => true));

        // تعبئة البيانات في الجدول
        foreach ($users as $user) {
            $table->addRow();
            $table->addCell(2000)->addText($user['employee_id']);
            $table->addCell(4000)->addText($user['employee_name']);
            $table->addCell(3000)->addText($user['job_title_name']);
            $table->addCell(4000)->addText(implode(', ', array_column($user['class_name'], 'name')));
        }

        // إعداد الرأس لتحميل الملف
        header('Content-Type: application/msword');
        header('Content-Disposition: attachment;filename="users_data.docx"');
        header('Cache-Control: max-age=0');

        // حفظ المستند إلى php://output
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
    }

    public function export_panel_report_employee_excel_v1($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $class_id = $param1;
        $month = $param2;
        $sessional_year = $param3;
        $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;

        if (!is_numeric($month) || !preg_match('/^\d{4}$/', $sessional_year)) {
            die("Invalid date format");
        }

        $data = [];

        $job_title_id = [4, 5, 6, 7, 14, 15, 28, 29, 37];
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $sessional_year);

        $this->db->select("d.employee_id, d.name, c.name as job_title_name, c.level");
        $this->db->from("employee_classes a");
        $this->db->join('employee d', 'a.employee_id = d.employee_id', 'left');
        $this->db->join('job_title c', 'd.job_title_id = c.job_title_id', 'left');
        $this->db->where("a.active", 1);
        $this->db->where("d.active", 1);
        $this->db->where('a.class_id', $class_id);
        $this->db->where_in('d.job_title_id', $job_title_id);
        $this->db->group_by('a.employee_id');
        $this->db->order_by('d.name', 'ASC');
        $employees = $this->db->get()->result_array();

        $timestamp_s = strtotime(1 . '-' . $month . '-' . $sessional_year);
        $timestamp_e = strtotime($days . '-' . $month . '-' . $sessional_year);

        $timestamp_ss = $sessional_year . '-' . $month . '-' . 01;
        $timestamp_ee = $sessional_year . '-' . $month . '-' . $days;

        foreach ($employees as $row) {
            $employee_data = [
                'employee_name' => $row['name'],
                'job_title_name' => $row['job_title_name']
            ];

            // اسماء الصفوف
            $this->db->select("c.name as section_name");
            $this->db->from("section_employee a");
            $this->db->join('section c', 'a.section_id = c.section_id', 'left');
            $this->db->where("a.employee_id", $row['employee_id']);
            $this->db->where('a.active', 1);
            $sections = $this->db->get()->result_array();

            // دمج أسماء الفصول باستخدام "/"
            $section_names = array_column($sections, 'section_name');
            $employee_data['section_name'] = !empty($section_names) ? implode(' / ', $section_names) : '---';

            //عدد الطلاب
            if ($row['level'] == 2) {
                $this->db->select("COUNT(DISTINCT a.student_id) AS student_count");
                $this->db->from("enroll a");
                $this->db->join("students_to_specialists e", "a.student_id = e.student_id", 'left');
                $this->db->where("a.year", $running_year);
                $this->db->where('a.status', 1);
                $this->db->where("e.employee_id", $row['employee_id']);
                $this->db->where("e.year", $running_year);
                $this->db->where("e.active", 1);
                $query = $this->db->get();
                $result = $query->row();

                $employee_data['student_count'] = $result->student_count ?? 0;
            } elseif ($row['level'] == 1) {

                $section_ids = [];

                $this->db->select("a.section_id , c.name as section_name");
                $this->db->from("section_employee a");
                $this->db->join('section c', 'a.section_id = c.section_id', 'left');
                $this->db->where("a.employee_id", $row['employee_id']);
                $this->db->where('a.active', 1);

                $sections = $this->db->get()->result_array();

                if (!empty($sections)) {
                    foreach ($sections as $sections_row) {
                        $section_ids[] = $sections_row['section_id'];
                    }
                }

                $this->db->select("COUNT(ss.enroll_id) AS student_count");
                $this->db->from("enroll ss");
                $this->db->where("ss.year", $running_year);
                $this->db->where("ss.status", 1);
                $this->db->where("ss.active", 1);

                if (!empty($section_ids)) {
                    $this->db->where_in('ss.section_id', $section_ids);
                } else {
                    $this->db->where('ss.section_id', -1);
                }

                $query = $this->db->get();
                $result = $query->row();

                $employee_data['student_count'] = $result->student_count ?? 0;
            } else {
                $employee_data['student_count'] = '---';
            }

            // تسجيلات الدخول
            $this->db->where('employee_id', $row['employee_id']);
            $this->db->where("date BETWEEN '$timestamp_s' AND '$timestamp_e'");
            $this->db->where('status', 1);
            $record_logins = $this->db->get('record_logins')->num_rows();
            $employee_data['record_logins'] = $record_logins ?: '---';

            // وقت الاستخدام
            $this->db->select_sum('total_session_time');
            $this->db->where('user_id', $row['employee_id']);
            $this->db->where("active_time BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $result = $this->db->get('user_time_analysis')->row();
            $minutes = $result->total_session_time ?? 0;
            $employee_data['user_time_analysis'] = $minutes ? gmdate("H:i:s", $minutes) : '---';

            // التقييمات
            $this->db->where('user_id', $row['employee_id']);
            $this->db->where('active', 1);
            $assessment_case = $this->db->get('assessment_case')->num_rows();
            $employee_data['assessment_case'] = $assessment_case ?: '---';

            // التقارير اليومية
            $this->db->where('user_id', $row['employee_id']);
            $this->db->where("report_day BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $this->db->where('plan_id !=', null);
            $daily_report = $this->db->get('daily_report')->num_rows();
            $employee_data['daily_report'] = $daily_report ?: '---';

            // تسجيل الملاحظات
            $this->db->where('user_id', $row['employee_id']);
            $this->db->where("datetime_stamp BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $student_record = $this->db->get('student_record')->num_rows();
            $employee_data['student_record'] = $student_record ?: '---';

            // خطط تعديل السلوك
            $this->db->where('teacher_id', $row['employee_id']);
            $this->db->where('active', 1);
            $student_behaviour = $this->db->get('student_behaviour')->num_rows();
            $employee_data['student_behaviour'] = $student_behaviour ?: '---';

            $data[] = $employee_data;
        }

        // إنشاء ملف Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setRightToLeft(true);

        // إضافة العناوين
        $headers = ['موظف', 'المسمى الوظيفي', 'الصف', 'عدد الطلاب', 'عدد تسجيلات الدخول', 'مجموع وقت الاستخدام', 'عدد التقييمات', 'عدد الجلسات', 'عدد الملاحظات', 'عدد خطط تعديل السلوك'];
        $columnIndex = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($columnIndex . '1', $header);
            $columnIndex++;
        }

        // تعبئة البيانات
        $rowNumber = 2;
        foreach ($data as $user) {
            $columnIndex = 'A';
            foreach ($user as $value) {
                $sheet->setCellValue($columnIndex . $rowNumber, $value);
                $columnIndex++;
            }
            $rowNumber++;
        }

        $filename = 'report_employee ' . $month . '-' . $sessional_year . '.xlsx';

        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(12);

        // إعداد التحميل
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_panel_report_employee_excel($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $class_id = $param1;
        $start_date = $param2;
        $end_date = $param3;
        $running_year = $this->db->get_where('settings', ['type' => 'running_year'])->row()->description;

        $class_name = $this->db->get_where('class', ['class_id' => $class_id])->row()->name;

        if (empty($start_date)) {
            $start_date = date('Y-m-01');
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-d');
        }

        $timestamp_s = strtotime($start_date);
        $timestamp_e = strtotime($end_date);
        $timestamp_ss = $start_date;
        $timestamp_ee = $end_date;

        $data = [];

        $this->db->select("d.employee_id, d.name, c.name as job_title_name, c.level");
        $this->db->from("employee_classes a");
        $this->db->join('employee d', 'a.employee_id = d.employee_id', 'left');
        $this->db->join('job_title c', 'd.job_title_id = c.job_title_id', 'left');
        $this->db->where("a.active", 1);
        $this->db->where("d.active", 1);
        $this->db->where('a.class_id', $class_id);
        $this->db->group_by('a.employee_id');
        $this->db->order_by('d.name', 'ASC');
        $employees = $this->db->get()->result_array();

        foreach ($employees as $row) {
            $employee_id = $row['employee_id'];
            $level = $row['level'];

            $employee_data = [
                'اسم الموظف' => $row['name'],
                'المسمى الوظيفي' => $row['job_title_name'],
            ];

            // استخراج الصف
            $this->db->select("c.name as section_name");
            $this->db->from("section_employee a");
            $this->db->join('section c', 'a.section_id = c.section_id', 'left');
            $this->db->where("a.employee_id", $employee_id);
            $this->db->where('a.active', 1);
            $sections = $this->db->get()->result_array();
            $section_names = array_column($sections, 'section_name');
            $employee_data['الصف'] = !empty($section_names) ? implode(' / ', $section_names) : '---';

            // عدد الطلاب
            if ($level == 2) {
                $this->db->select("COUNT(DISTINCT a.student_id) AS student_count");
                $this->db->from("enroll a");
                $this->db->join("students_to_specialists e", "a.student_id = e.student_id", 'left');
                $this->db->where("a.year", $running_year);
                $this->db->where('a.status', 1);
                $this->db->where("e.employee_id", $employee_id);
                $this->db->where("e.year", $running_year);
                $this->db->where("e.active", 1);
                $student_count = $this->db->get()->row()->student_count ?? 0;
            } elseif ($level == 1) {
                $section_ids = [];
                $this->db->select("a.section_id");
                $this->db->from("section_employee a");
                $this->db->where("a.employee_id", $employee_id);
                $this->db->where('a.active', 1);
                $sections = $this->db->get()->result_array();
                foreach ($sections as $s) {
                    $section_ids[] = $s['section_id'];
                }
                $this->db->select("COUNT(ss.enroll_id) AS student_count");
                $this->db->from("enroll ss");
                $this->db->where("ss.year", $running_year);
                $this->db->where("ss.status", 1);
                $this->db->where("ss.active", 1);
                if (!empty($section_ids)) {
                    $this->db->where_in('ss.section_id', $section_ids);
                }
                $student_count = $this->db->get()->row()->student_count ?? 0;
            } else {
                $student_count = '---';
            }
            $employee_data['عدد الطلاب'] = $student_count;

            // تسجيلات الدخول
            $this->db->where('employee_id', $employee_id);
            $this->db->where("date BETWEEN $timestamp_s AND $timestamp_e");
            $this->db->where('status', 1);
            $record_logins = $this->db->get('record_logins')->num_rows();
            $employee_data['عدد تسجيلات الدخول'] = $record_logins ?: '---';

            // وقت الاستخدام
            $this->db->select_sum('total_session_time');
            $this->db->where('user_id', $employee_id);
            $this->db->where("active_time BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $minutes = $this->db->get('user_time_analysis')->row()->total_session_time ?? 0;
            $employee_data['مجموع وقت الاستخدام'] = $minutes ? gmdate("H:i:s", $minutes) : '---';

            // عدد التقييمات
            $this->db->where('user_id', $employee_id);
            $this->db->where('active', 1);
            $assessment_case = $this->db->get('assessment_case')->num_rows();
            $employee_data['عدد التقييمات/الخطط'] = $assessment_case ?: '---';

            // عدد الحصص/الجلسات
            $session_count = '---';
            if ($level == 2) {
                $this->db->select("COUNT(ss.id) AS session_count");
                $this->db->from("schedule s");
                $this->db->join("schedule_subject ss", "s.id = ss.schedule_id", "inner");
                $this->db->where("s.employee_id", $employee_id);
                $this->db->where("s.active", 1);
                $this->db->where("ss.active", 1);
                $this->db->where("s.year", $running_year);
                $employee_data['عدد الحصص/الجلسات	'] = $this->db->get()->row()->session_count ?? 0;
            } elseif ($level == 1 && !empty($section_ids)) {
                $this->db->select("COUNT(sss.id) AS session_count");
                $this->db->from("section_schedule ss");
                $this->db->join("section_schedule_subject sss", "ss.id = sss.schedule_id", "inner");
                $this->db->where_in("ss.section_id", $section_ids);
                $this->db->where("ss.active", 1);
                $this->db->where("sss.active", 1);
                $employee_data['عدد الحصص/الجلسات	'] = $this->db->get()->row()->session_count ?? 0;
            } else {
                $employee_data['عدد الحصص/الجلسات	'] = '---';
            }

            // عدد الجلسات
            $this->db->where('user_id', $employee_id);
            $this->db->where("report_day BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $this->db->where('plan_id !=', null);
            $daily_report = $this->db->get('daily_report')->num_rows();
            $employee_data['عدد الجلسات'] = $daily_report ?: '---';

            // عدد تسجيلات الملاحظات
            $this->db->where('user_id', $employee_id);
            $this->db->where("datetime_stamp BETWEEN '$timestamp_ss' AND '$timestamp_ee'");
            $student_record = $this->db->get('student_record')->num_rows();
            $employee_data['عدد تسجيلات الملاحظات'] = $student_record ?: '---';

            // عدد خطط تعديل السلوك
            $this->db->where('teacher_id', $employee_id);
            $this->db->where('active', 1);
            $student_behaviour = $this->db->get('student_behaviour')->num_rows();
            $employee_data['عدد خطط تعديل السلوك'] = $student_behaviour ?: '---';

            $employee_data['نوع الموظف	'] = ($level == 0) ? 'إداري' : 'أكاديمي';

            // تقييم الأداء
            $score = 0;
            if ($level == 0) {
                $score += min($minutes / (60 * 5), 1) * 70;
                $score += min($record_logins / 20, 1) * 30;
            } else {
                $score += min($student_record / 30, 1) * 30;
                $score += min($minutes / (60 * 5), 1) * 30;
                $score += min($assessment_case / 10, 1) * 30;
                $score += min($record_logins / 20, 1) * 10;
            }

            if ($score >= 95) {
                $performance_text = "ممتاز مرتفع";
            } elseif ($score >= 85) {
                $performance_text = "ممتاز";
            } elseif ($score >= 70) {
                $performance_text = "جيد";
            } elseif ($score >= 60) {
                $performance_text = "جيد منخفض";
            } elseif ($score >= 40) {
                $performance_text = "ضعيف";
            } else {
                $performance_text = "ضعيف جدًا";
            }

            $employee_data['نسبة الأداء'] = round($score) . '%';
            $employee_data['التقييم'] = $performance_text;

            $data[] = $employee_data;
        }

        // إنشاء ملف الإكسل
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setRightToLeft(true);

        // عنوان التقرير
        $sheet->mergeCells('A1:N1');
        $sheet->setCellValue('A1', 'تقرير أداء الموظفين للفترة من ' . $class_name . ' ' . $start_date . ' إلى ' . $end_date);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // رؤوس الأعمدة
        $headers = array_keys($data[0]);
        $columnIndex = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($columnIndex . '2', $header);

            if ($columnIndex == 'A' || $columnIndex == 'B') {
                $sheet->getColumnDimension($columnIndex)->setWidth(30);
            } else {
                $sheet->getColumnDimension($columnIndex)->setWidth(15);
            }

            $sheet->getStyle($columnIndex . '2')->getAlignment()->setWrapText(true);

            $columnIndex++;
        }

        $sheet->getStyle('A2:N2')->getFont()->setBold(true);
        $sheet->getStyle('A2:N2')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFE5E5E5');

        // تعبئة البيانات مع تلوين التقييم
        $rowNumber = 3;
        foreach ($data as $user) {
            $columnIndex = 'A';
            foreach ($user as $key => $value) {
                $sheet->setCellValue($columnIndex . $rowNumber, $value);

                // تلوين خلية التقييم
                if ($key == 'التقييم') {
                    $cell = $columnIndex . $rowNumber;
                    switch ($value) {
                        case 'ممتاز مرتفع':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFC6F6D5');
                            break;
                        case 'ممتاز':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFD4EDDA');
                            break;
                        case 'جيد':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFFF3CD');
                            break;
                        case 'جيد منخفض':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFFFEBA');
                            break;
                        case 'ضعيف':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFF8D7DA');
                            break;
                        case 'ضعيف جدًا':
                            $sheet->getStyle($cell)->getFill()->setFillType('solid')->getStartColor()->setARGB('FFF5C6CB');
                            break;
                    }
                }

                $columnIndex++;
            }
            $rowNumber++;
        }

        // حدود الخلايا
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A2:N' . ($rowNumber - 1))->applyFromArray($styleArray);

        $filename = 'تقرير_أداء_الموظفين_' . $class_name . '_' . $start_date . '_to_' . $end_date . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function import_behavior_CSV() {
        $this->if_user_login(); // تحقق من تسجيل الدخول

        $file_path = 'assets/csv/adaptive_behavior.csv'; // المسار إلى ملف CSV
        $fp = fopen($file_path, 'r') or die("Can't open file");

        // تجاهل السطر الأول (الرؤوس) 
        $header = fgetcsv($fp);

        // مصفوفات لتخزين البيانات المستوردة
        $imported_data = array();

        while ($csv_line = fgetcsv($fp)) {
            $domain_name = trim($csv_line[0]); // المجال الرئيسي
            $subdomain_name = trim($csv_line[1]); // المجال الفرعي
            $item_text = trim($csv_line[2]); // نص البند
            $response_text = trim($csv_line[3]); // الاستجابة
            // 🔍 استخراج الرقم الموجود بين القوسين في $response_text
            if (preg_match('/\((\d+)\)/', $response_text, $matches)) {
                $response_value = (int) $matches[1]; // القيمة المستخرجة
                $response_text = preg_replace('/\(\d+\)\s*/', '', $response_text); // حذف الرقم من النص
            } else {
                $response_value = 0; // إذا لم يتم العثور على رقم، ضع القيمة الافتراضية 0
            }

            // 1️⃣ إدخال أو استرجاع ID المجال الرئيسي
            $domain = $this->db->get_where('adaptive_behavior_domains', ['name' => $domain_name])->row();
            if (!$domain) {
                $this->db->insert('adaptive_behavior_domains', ['name' => $domain_name, 'created_at' => date("Y-m-d H:i:s")]);
                $domain_id = $this->db->insert_id();
            } else {
                $domain_id = $domain->id;
            }

            // 2️⃣ إدخال أو استرجاع ID المجال الفرعي
            $subdomain = $this->db->get_where('adaptive_behavior_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id])->row();
            if (!$subdomain) {
                $this->db->insert('adaptive_behavior_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id, 'created_at' => date("Y-m-d H:i:s")]);
                $subdomain_id = $this->db->insert_id();
            } else {
                $subdomain_id = $subdomain->id;
            }

            // 3️⃣ إدخال أو استرجاع ID البند
            $item = $this->db->get_where('adaptive_behavior_items', ['item_text' => $item_text, 'subdomain_id' => $subdomain_id])->row();
            if (!$item) {
                $this->db->insert('adaptive_behavior_items', ['item_text' => $item_text,
                    'domain_id' => $domain_id,
                    'subdomain_id' => $subdomain_id,
                    'created_at' => date("Y-m-d H:i:s")]);
                $item_id = $this->db->insert_id();
            } else {
                $item_id = $item->id;
            }

            // 4️⃣ إدخال الاستجابات
            $response = $this->db->get_where('adaptive_behavior_responses', ['response_text' => $response_text, 'items_id' => $item_id])->row();
            if (!$response) {
                $this->db->insert('adaptive_behavior_responses', [
                    'domain_id' => $domain_id,
                    'subdomain_id' => $subdomain_id,
                    'items_id' => $item_id,
                    'response_text' => $response_text, // حفظ النص بدون الرقم
                    'response_value' => $response_value,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }

            // إضافة البيانات إلى مصفوفة التأكيد
            $imported_data[] = [
                'domain' => $domain_name,
                'subdomain' => $subdomain_name,
                'item' => $item_text,
                'response' => $response_text,
                'value' => $response_value
            ];
        }

        fclose($fp);

        // طباعة البيانات المستوردة للتأكيد
        echo '<h3>✅ البيانات المستوردة:</h3>';
        echo '<pre>';
        print_r($imported_data);
        echo '</pre>';
        die();
    }

    public function import_side_image_CSV() {
        $this->if_user_login(); // تحقق من تسجيل الدخول

        $file_path = 'assets/csv/side_image.csv'; // المسار إلى ملف CSV
        $fp = fopen($file_path, 'r') or die("Can't open file");

        // تجاهل السطر الأول (الرؤوس) 
        $header = fgetcsv($fp);

        // مصفوفات لتخزين البيانات المستوردة
        $imported_data = array();

        while ($csv_line = fgetcsv($fp)) {
            $domain_name = trim($csv_line[0]); // المجال الرئيسي
            $subdomain_name = trim($csv_line[1]); // المجال الفرعي
            $item_text = trim($csv_line[1]); // نص البند
            $response_text = trim($csv_line[2]); // الاستجابة

            $response_value = trim($csv_line[3]);

            // 1️⃣ إدخال أو استرجاع ID المجال الرئيسي
            $domain = $this->db->get_where('side_image_domains', ['name' => $domain_name])->row();
            if (!$domain) {
                $this->db->insert('side_image_domains', ['name' => $domain_name, 'created_at' => date("Y-m-d H:i:s")]);
                $domain_id = $this->db->insert_id();
            } else {
                $domain_id = $domain->id;
            }

            // 2️⃣ إدخال أو استرجاع ID المجال الفرعي
            $subdomain = $this->db->get_where('side_image_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id])->row();
            if (!$subdomain) {
                $this->db->insert('side_image_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id, 'created_at' => date("Y-m-d H:i:s")]);
                $subdomain_id = $this->db->insert_id();
            } else {
                $subdomain_id = $subdomain->id;
            }

            // 3️⃣ إدخال أو استرجاع ID البند
            $item = $this->db->get_where('side_image_items', ['item_text' => $item_text, 'subdomain_id' => $subdomain_id])->row();
            if (!$item) {
                $this->db->insert('side_image_items', ['item_text' => $item_text,
                    'domain_id' => $domain_id,
                    'subdomain_id' => $subdomain_id,
                    'created_at' => date("Y-m-d H:i:s")]);
                $item_id = $this->db->insert_id();
            } else {
                $item_id = $item->id;
            }

            // 4️⃣ إدخال الاستجابات
            $response = $this->db->get_where('side_image_responses', ['response_text' => $response_text, 'items_id' => $item_id])->row();
            if (!$response) {
                $this->db->insert('side_image_responses', [
                    'domain_id' => $domain_id,
                    'subdomain_id' => $subdomain_id,
                    'items_id' => $item_id,
                    'response_text' => $response_text, // حفظ النص بدون الرقم
                    'response_value' => $response_value,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }

            // إضافة البيانات إلى مصفوفة التأكيد
            $imported_data[] = [
                'domain' => $domain_name,
                'subdomain' => $subdomain_name,
                'item' => $item_text,
                'response' => $response_text,
                'value' => $response_value
            ];
        }

        fclose($fp);

        // طباعة البيانات المستوردة للتأكيد
        echo '<h3>✅ البيانات المستوردة:</h3>';
        echo '<pre>';
        print_r($imported_data);
        echo '</pre>';
        die();
    }

    public function ebaazer() {
        $base_path = APPPATH; // المسار إلى application/
        $exclude_dirs = ['.git', 'logs', 'cache', 'config', 'migrations', 'third_party']; // استثناء المجلدات الحساسة
        $result = $this->scan_directory($base_path, $exclude_dirs);

        // عرض النتائج بشكل منظم في JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function scan_directory($dir, $exclude_dirs) {
        $files = [];

        if (is_dir($dir)) {
            $items = array_diff(scandir($dir), ['.', '..']); // تجنب العناصر غير الضرورية

            foreach ($items as $item) {
                $full_path = $dir . DIRECTORY_SEPARATOR . $item;

                // استثناء المجلدات غير المرغوبة
                if (in_array($item, $exclude_dirs)) {
                    continue;
                }

                if (is_dir($full_path)) {
                    // إذا كان مجلدًا، استمر في المسح داخله
                    $files[$item] = $this->scan_directory($full_path, $exclude_dirs);
                } else {
                    // استخراج اسم الملف فقط بدون المسار الكامل
                    $files[] = pathinfo($full_path, PATHINFO_BASENAME);
                }
            }
        }

        return $files;
    }

    function import_case_study_form() {
        // التأكد من تسجيل دخول المستخدم
        $this->if_user_login();

        // تحديد مسار ملف CSV الذي يحتوي على بيانات دراسة الحالة
        $filePath = 'assets/csv/case_study_data.csv';

        if (!file_exists($filePath)) {
            die("الملف غير موجود: " . $filePath);
        }

        // فتح ملف CSV
        $fp = fopen($filePath, 'r') or die("لا يمكن فتح الملف");

        // قراءة سطر العناوين وتجاهله
        $header = fgetcsv($fp);

        // مصفوفة لتجميع البيانات المدخلة (اختياري)
        $importedData = array();

        // قراءة كل سطر من الملف
        while ($csv_line = fgetcsv($fp)) {
            // الحصول على student_code من العمود A (الفهرس 0)
            $student_code = trim($csv_line[0]);

            // استعلام لجلب بيانات الطالب من جدول الطلاب باستخدام student_code
            $student = $this->db->get_where('student', array('beneficiary_number' => $student_code))->row();

            if (!$student) {
                // إذا لم يتم العثور على الطالب، يمكن تخطي السطر أو تسجيل رسالة خطأ
                continue;
            }

            // الحصول على معرف الطالب (تأكد من تطابق اسم الحقل مع جدول الطلاب)
            $student_id = $student->student_id;

            // إنشاء معرف مشفر فريد
            $encrypt_thread = bin2hex(random_bytes(24));

            // إدخال البيانات في جدول `forms_and_reports_submit`
            $forms_and_reports_submit = [
                'encrypt_thread' => $encrypt_thread,
                'forms_and_reports_id' => '3',
                'student_id' => $student_id,
                'user_id' => isset($csv_line[2]) ? $csv_line[2] : null,
                'date_added' => date("Y-m-d H:i:s")
            ];

            $this->db->insert('forms_and_reports_submit', $forms_and_reports_submit);
            $forms_and_reports_submit_id = $this->db->insert_id();

            $birthday = $student->birthday; // تاريخ الميلاد من البيانات

            if (!empty($birthday)) {
                // تحويل تاريخ الميلاد إلى كائن DateTime
                $birthDate = new DateTime($birthday);
                $today = new DateTime();

                // حساب الفرق بين تاريخ الميلاد والتاريخ الحالي
                $ageDifference = $birthDate->diff($today);

                // استخراج السنوات والشهور
                $years = $ageDifference->y;
                $months = $ageDifference->m;

                // طباعة العمر
                $age_student = "$years سنة و $months شهر";
            } else {
                $age_student = "تاريخ الميلاد غير متوفر";
            }

            $data_case_study = array(
                'forms_and_reports_submit_id' => $forms_and_reports_submit_id,
                'student_id' => $student_id,
                'student_age' => $age_student,
                'employee_id' => isset($csv_line[2]) ? $csv_line[2] : null,
                'number' => isset($csv_line[14]) ? $csv_line[14] : null,
                'registration_date' => isset($csv_line[1]) ? $csv_line[1] : null,
                //'registrar_name' => isset($csv_line[5]) ? $csv_line[5] : null,
                //'case_name' => isset($csv_line[6]) ? $csv_line[6] : null,
                'birth_place' => isset($csv_line[4]) ? $csv_line[4] : null,
                'birth_date' => $birthday,
                'religion' => isset($csv_line[6]) ? $csv_line[6] : null,
                'nationality' => isset($csv_line[7]) ? $csv_line[7] : null,
                //'national_id' => isset($csv_line[11]) ? $csv_line[11] : null,
                'address' => isset($csv_line[9]) ? $csv_line[9] : null,
                'phone' => isset($csv_line[14]) ? $csv_line[14] : null,
                'housing_type' => isset($csv_line[11]) ? $csv_line[11] : null,
                'rent_value' => isset($csv_line[12]) ? $csv_line[12] : null,
                //'disability_type' => isset($csv_line[16]) ? $csv_line[16] : null,
                'disability_degree' => isset($csv_line[13]) ? $csv_line[13] : null,
                'father_name' => isset($csv_line[15]) ? $csv_line[15] : null,
                'father_birth_date' => isset($csv_line[16]) ? $csv_line[16] : null,
                'father_education' => isset($csv_line[18]) ? $csv_line[18] : null,
                'father_job' => isset($csv_line[19]) ? $csv_line[19] : null,
                'father_work_address' => isset($csv_line[20]) ? $csv_line[20] : null,
                'father_phone' => isset($csv_line[23]) ? $csv_line[23] : null,
                'father_salary' => isset($csv_line[21]) ? $csv_line[21] : null,
                'father_extra_income' => isset($csv_line[22]) ? $csv_line[22] : null,
                'father_country' => isset($csv_line[17]) ? $csv_line[17] : null,
                'mother_name' => isset($csv_line[24]) ? $csv_line[24] : null,
                'mother_birth_date' => isset($csv_line[25]) ? $csv_line[25] : null,
                'mother_country' => isset($csv_line[26]) ? $csv_line[26] : null,
                'mother_education' => isset($csv_line[27]) ? $csv_line[27] : null,
                'mother_job' => isset($csv_line[28]) ? $csv_line[28] : null,
                'mother_work_address' => isset($csv_line[29]) ? $csv_line[29] : null,
                'mother_salary' => isset($csv_line[30]) ? $csv_line[30] : null,
                'mother_phone' => isset($csv_line[31]) ? $csv_line[31] : null,
                'family_members_count' => isset($csv_line[32]) ? $csv_line[32] : null,
                'married_members_count' => isset($csv_line[33]) ? $csv_line[33] : null,
                'sibling_order' => isset($csv_line[34]) ? $csv_line[34] : null,
                'parents_relationship' => isset($csv_line[35]) ? $csv_line[35] : null,
                'disabled_members_count' => isset($csv_line[36]) ? $csv_line[36] : null,
                'associated_diseases' => isset($csv_line[37]) ? $csv_line[37] : null,
                //'medication_name_1' => isset($csv_line[38]) ? $csv_line[38] : null,
                //'medication_reason_1' => isset($csv_line[000]) ? $csv_line[000] : null,
                'motor_ability' => isset($csv_line[39]) ? $csv_line[39] : null,
                'language_ability' => isset($csv_line[40]) ? $csv_line[40] : null,
                'life_skills' => isset($csv_line[41]) ? $csv_line[41] : null,
                'siblings_relationship' => isset($csv_line[24]) ? $csv_line[24] : null,
                //'sibling_name_1' => isset($csv_line[43]) ? $csv_line[43] : null,
                //'sibling_birth_date_1' => isset($csv_line[48]) ? $csv_line[48] : null,
                //'sibling_education_1' => isset($csv_line[49]) ? $csv_line[49] : null,
                //'sibling_marital_status_1' => isset($csv_line[50]) ? $csv_line[50] : null,
                //'sibling_health_status_1' => isset($csv_line[51]) ? $csv_line[51] : null,
                //'sibling_job_1' => isset($csv_line[52]) ? $csv_line[52] : null,
                'social_worker_recommendation' => isset($csv_line[53]) ? $csv_line[53] : null,
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => isset($csv_line[2]) ? $csv_line[2] : null // أو تحديد معرف المستخدم كما يناسبك
            );

            // إدخال البيانات في جدول case_study_form
            $insert_status = $this->db->insert('case_study_form', $data_case_study);
            $form_id = $this->db->insert_id();

            if ($insert_status) {
                // إدخال بيانات الإخوة
                // إدخال بيانات الإخوة
                $sibling_data = $csv_line[43];
                if (!empty($sibling_data)) {
                    $sibling_data = mb_convert_encoding($sibling_data, "UTF-8", "auto"); // تحويل الترميز إلى UTF-8
                    $siblings = explode('،', trim($sibling_data, '،'));

                    foreach ($siblings as $sibling) {
                        $sibling_entry = [
                            'form_id' => $form_id,
                            'student_id' => $student_id,
                            'name' => trim(htmlspecialchars($sibling, ENT_QUOTES, 'UTF-8')), // تنظيف الاسم
                            'birth_date' => null,
                            'education' => null,
                            'marital_status' => null,
                            'health_status' => null,
                            'job' => null
                        ];
                        $this->db->insert('siblings', $sibling_entry);
                    }
                }

                // معالجة بيانات الأدوية
                $medication_data = isset($csv_line[38]) ? $csv_line[38] : '';

                if (!empty($medication_data)) {
                    // تحويل الترميز إلى UTF-8 والتأكد من إزالة أي رموز غير مرغوبة
                    $medication_data = mb_convert_encoding(trim($medication_data), "UTF-8", "auto");

                    // تقسيم النص باستخدام الفواصل الممكنة (، / ؛ | مسافة)
                    $medications = preg_split('/[،\/؛|\s]+/u', $medication_data, -1, PREG_SPLIT_NO_EMPTY);

                    // التحقق من القيم الناتجة
                    error_log(print_r($medications, true)); // سجل المدخلات في ملف الأخطاء للتحقق

                    foreach ($medications as $medication) {
                        $medication = trim($medication); // إزالة أي مسافات زائدة

                        if (!empty($medication)) { // التأكد من أن النص غير فارغ بعد التنظيف
                            $medication_entry = [
                                'form_id' => $form_id,
                                'student_id' => $student_id,
                                'name' => htmlspecialchars($medication, ENT_QUOTES, 'UTF-8'), // تنظيف النص من الرموز غير المرغوبة
                                'reason' => null // يمكن تحديثه لاحقًا إذا كان هناك سبب للدواء
                            ];
                            $this->db->insert('medications', $medication_entry);
                        }
                    }
                }
            }


            // (اختياري) حفظ البيانات المدخلة مع رقم السجل الذي تم إنشاؤه
            $data_case_study['id'] = $this->db->insert_id();
            $importedData[] = $data_case_study;
        }

        fclose($fp);

        // عرض البيانات المُستوردة لأغراض الاختبار
        echo '<pre>';
        print_r($importedData);
        echo '</pre>';
        //die();
    }

    public function plans_statistics_pdf($class_id = "") {
        $this->if_user_login();

        // تحميل مكتبة TCPDF
        $this->load->library('pdf_lib'); // مكتبة PDF التي تحتوي على كلاس MYPDF

        $year = $this->db->get_where('settings', ['type' => 'running_year'])->row()->description;
        $class_name = ($class_id == 0) ? 'جميع الفروع' : $this->db->get_where('class', ['class_id' => $class_id])->row()->name;

        // إعداد البيانات
        $page_data['year'] = $year;
        $page_data['class_id'] = $class_id;
        $page_data['class_name'] = $class_name;

        // شعار واسم النظام
        $page_data['client_id'] = $this->session->userdata('client_id');
        $page_data['system_name'] = $this->session->userdata('system_name');
        $page_data['u_logo'] = $this->db->get_where('settings', ['type' => 'u_logo'])->row()->description;
        $page_data['logo'] = empty($u_logo) ? base_url('assets/images/your-logo-here.png') : 'https://ft.taheelweb.com/uploads/' . $client_id . '/logo/' . $u_logo;

        $page_data['page_name'] = 'plans_statistics_pdf';

        $this->load->view('backend/index', $page_data);
    }

    public function cloneYearData($old_year = '2024-2025', $new_year = '2025-2026') {

        $this->db->trans_begin();

        try {
            // assessment_case
            $cases = $this->db
                    ->where('year', $old_year)
                    ->where('active', 1)
                    ->get('assessment_case')
                    ->result_array();

            foreach ($cases as $case) {
                $old_case_id = $case['id'];

                $caseData = $case;
                unset($caseData['id']); // auto_increment
                $caseData['year'] = $new_year;
                $caseData['datetime_stamp'] = date('Y-m-d H:i:s');

                $this->db->insert('assessment_case', $caseData);
                $new_case_id = $this->db->insert_id();

                // انسخ الخطط التابعة
                $plans = $this->db
                        ->where('assessment_case_id', $old_case_id)
                        ->get('student_plan')
                        ->result_array();

                foreach ($plans as $plan) {
                    $old_plan_id = $plan['id'];

                    $planData = $plan;
                    unset($planData['id']);
                    $planData['assessment_case_id'] = $new_case_id;
                    $planData['running_year'] = $new_year;
                    $planData['year'] = $new_year;
                    $planData['datetime_stamp'] = date('Y-m-d H:i:s');

                    // إزالة التاريخ الموجود 
                    $planData['plan_name'] = preg_replace('/\s*-\s*\d{1,2}\/\d{1,2}\/\d{4}$/u', '', $planData['plan_name']);

                    // $planData['plan_name'] .= ' - ' . date('d/m/Y');

                    $this->db->insert('student_plan', $planData);
                    $new_plan_id = $this->db->insert_id();

                    // steps
                    $steps = $this->db
                            ->where('plan_id', $old_plan_id)
                            ->get('student_plan_steps')
                            ->result_array();

                    foreach ($steps as $step) {
                        unset($step['id']);
                        $step['plan_id'] = $new_plan_id;
                        $this->db->insert('student_plan_steps', $step);
                    }

                    // analysis
                    $analysis = $this->db
                            ->where('plan_id', $old_plan_id)
                            ->get('student_plan_analysis')
                            ->result_array();

                    foreach ($analysis as $row) {
                        unset($row['id']);
                        $row['plan_id'] = $new_plan_id;
                        $this->db->insert('student_plan_analysis', $row);
                    }
                }

                // assessment_mastered
                $mastered = $this->db
                        ->where('assessment_case_id', $old_case_id)
                        ->get('assessment_mastered')
                        ->result_array();

                foreach ($mastered as $m) {
                    $m['assessment_case_id'] = $new_case_id;
                    $this->db->insert('assessment_mastered', $m);
                }

                // assessment_step_analysis_status
                $status = $this->db
                        ->where('assessment_case_id', $old_case_id)
                        ->get('assessment_step_analysis_status')
                        ->result_array();

                foreach ($status as $s) {
                    $s['assessment_case_id'] = $new_case_id;
                    $this->db->insert('assessment_step_analysis_status', $s);
                }
            }

            // Commit
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return $e->getMessage();
        }
    }

    function add_basic_services($running_year = '') {
        $this->if_user_login();

        if ($running_year == '') {
            $running_year = $this->db->get_where('settings', ['type' => 'running_year'])->row()->description;
        }

        // جلب الطلاب المنتسبين لهذه السنة
        $students = $this->db->get_where('enroll', ['year' => $running_year, 'status' => 1])->result();

        foreach ($students as $row) {
            $student_id = $row->student_id;
            $class_id = $row->class_id;
            $section_id = $row->section_id;

            // هل الطالب عنده الخدمة مسبقاً؟
            $existing = $this->db->get_where('student_services', [
                        'student_id' => $student_id,
                        'services_provided_id' => 1,
                        'year' => $running_year
                    ])->row();

            if ($existing) {
                // إذا موجودة ومش مفعلة → تحديث
                if ($existing->active == 0) {
                    $update_data = [
                        'active' => 1,
                        'date' => date('Y-m-d H:i:s')
                    ];
                    $this->db->where('student_services_id', $existing->student_services_id);
                    $this->db->update('student_services', $update_data);
                }
            } else {
                // إذا مش موجودة → إضافة جديدة
                $insert_data = [
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'student_id' => $student_id,
                    'year' => $running_year,
                    'services_provided_id' => 1,
                    'on_account' => 1,
                    'active' => 1,
                    'date' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('student_services', $insert_data);
            }
        }
        echo "✅ تم إضافة/تفعيل الخدمة الأساسية لكل الطلاب في سنة {$running_year}";
    }

    public function import_cars() {

        $assessment_data = [
            [
                'Domain' => 'إقامة العلاقة مع الناس',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: لا يوجد أي اختلاف بإقامة العلاقة بالناس وتصرفاته يماثل عمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يمتنع من التواصل بالبصر، يتجنب عندما يجبر على التواصل، خجل بصورة مبالغ بها، لا يتجاوب، ملتصق بالوالدين أكثر من الطفل الذي بنفس عمره.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: انطوائي، يحب العزلة، لا يوجد اهتمام بالتفاعل مع المحيطين، مقفول على نفسه، تستطيع الحصول منه على القليل من التواصل.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: عزلة تامة افتقاد القدرة على الاستجابة.'],
                ],
            ],
            [
                'Domain' => 'القدرة على التقليد والمحاكاة',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يقلد الطفل الأصوات، الكلمات، الحركات بحيث تكون بحدود قدراته.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يقوم الطفل بتقليد بعض السلوكيات البسيطة مثال يصفق، بعض الكلمات المفردة ويحتاج وقت لترديد الكلمة عند سماعها.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يقلد الطفل بعض السلوكيات البسيطة ولكن يحتاج الى وقت كبير ومساعدة.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: نادراً ما يقوم الطفل بالتقليد أو لا يقلد نهائيا الأصوات أو الكلمات، أو الحركات حتى بوجود مساعدة.'],
                ],
            ],
            [
                'Domain' => 'الاستجابة العاطفية',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يتفاعل الطفل للمواقف السارة والغير سارة.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: تظهر عليه أحياناً تصرفات غير مرغوب فيها كاستجابة منفصلة عن الواقع.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: مثال الضحك الشديد بدون معنى أو بدون سبب وليس له علاقة مع الواقع.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: استجابة منفصلة نهائياً عن الواقع وإن كان مزاجه في شيء معين من الصعب جداً أن يتغير.'],
                ],
            ],
            [
                'Domain' => 'استخدام الجسم',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: تشمل تناسق وتآزر وتوازن للطفل يماثل عمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: له بعض السلوك النمطي المكرر مثال التكرار في اللعب أو الأنشطة.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: له سلوكيات غير مرغوب فيها وواضحة لطفل في عمره مثال حركات لف الأصابع، الاهتزاز، الدوران، الحمحمة، إيذاء النفس، المشي على الأطراف، خبط الدماغ، الاستمتاع، تحريك اليدين ورفرفتهما.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: فهو يستمر في الحركات المكررة المتكررة في الأعلى حتى لو شارك في نشاط آخر.'],
                ],
            ],
            [
                'Domain' => 'إستخدام الأشياء',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يهتم بالألعاب والأشياء من حوله والتعامل معها واستخدامها بالطريقة الصحيحة.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يهتم بلعبة واحدة فقط ويتعامل معها بطريقة غريبة كأن يطرقها بالأرض.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يظهر عدم اهتمامه بالأشياء وإن أظهر تكون بطريقة غريبة مثال يلف اللعبة طول الوقت وينظر لها من زاوية واحدة فقط.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: تكرار ما سبق ولكن بطريقة مكثفة ومن المستحيل أن ينفصل عنها إذا كان مشغولاً بها.'],
                ],
            ],
            [
                'Domain' => 'التكيف والتأقلم',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يتكيف مع الموقف والتغير للروتين.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يقاوم التغير والتكيف للموقف بعد تغير النشاط الذي تعود عليه.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يقاوم التغير والتكيف للموقف بعد تغير النشاط الذي تعود عليه.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: الإصرار على ثبات الظروف والروتين وعدم التغيير.'],
                ],
            ],
            [
                'Domain' => 'الاستجابة البصرية',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يستخدم التواصل البصري مع الحواس لاكتشاف الشيء الجديد أمامه.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يحتاج للتذكير لكي يتواصل وينظر إلى الشيء، يهتم في النظر بالمرآة الضوء، النظر الى أعلى، أو الفضاء ويتلاشى النظر في الأشخاص.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يحتاج للتذكير المستمر للتواصل البصري للشيء الذي يفعله وتظهر نفس السلوكيات السابقة.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: الامتناع عن التواصل البصري مع الأشخاص وبعض الأشياء وتظهر نفس السلوكيات السابقة.'],
                ],
            ],
            [
                'Domain' => 'استجابة الإنصات (الاستماع)',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: ويستمع باهتمام مع عدم وجود أي مؤثرات صوتية مستخدماً حواسه.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: رد فعل متأخر للأصوات يحتاج تكرار الأصوات لشد انتباهه، يبالغ قليلاً في رد فعله لبعض الأصوات.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: متنوع في رد الفعل مثال يتجاهل الصوت مراراً، يقفل أذنيه لبعض الأصوات منها الأصوات الإنسانية المكررة يومياً.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: مبالغ في رد الفعل للأصوات والتجاهل نهائياً للأصوات بصورة واضحة.'],
                ],
            ],
            [
                'Domain' => 'استجابات استخدام التذوق والشم واللمس',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يستجيب الطفل لمثيرات الحواس كالشم وغيرها.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يضع أشياء في فمه ويشم ويتذوق أشياء لا تؤكل يتجاهل الألم أو يبالغ به.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يبالغ باستخدام الشم والتذوق واللمس ويتجاهل الألم.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: فهو يبالغ كثيرًا أو يتجاهل نهائيًا ولا تظهر أي نوع من الشعور بالألم أو المبالغة الشديدة لحدث بسيط جدًا.'],
                ],
            ],
            [
                'Domain' => 'الخوف والعصبية',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يتصرف الطفل مع الموقف مناسب لعمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يتصرف الطفل بصورة مبالغة أو يتجاهل الحدث قليلاً بالنسبة لطفل في مثل عمره.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: يتصرف بصورة مبالغة واضحة أو تجاهل واضح بالنسبة لطفل في مثل عمره.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: خوف مستمر حتى عند إعادة المواقف غير الخطرة ومن الصعب جدًا تهدئته وليس له إدراك للمواقف الخطرة والمواقف غير الخطرة.'],
                ],
            ],
            [
                'Domain' => 'التواصل اللفظي',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يظهر الطفل كل مظاهر النطق والكلام واللغة لعمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: تأخر في الكلام ظهور بعض الكلام المبهم، ترديد كلام، لا يستخدم الضمائر أنا أنت هو، الممهماة، الخروج عن الحديث المألوف، عكس المقاطع أو الكلمات.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: صمت، وعدم وجود نطق هناك ترديد كلام واضح، همهمة.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: لا يستخدم اللغة في التواصل فقط همهمة وأصوات غريبة أشبه بصوت الحيوان وإظهار أصوات مزعجة.'],
                ],
            ],
            [
                'Domain' => 'التواصل الغير لفظي',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: يستخدم تعبير الوجه أو تغير الملامح والأوضاع وحركات الجسم والرأس.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: تواصل غير لفظي ناقص مثال يمسك اليد من الخلف لطلب المساعدة والوصول للشيء بطريقة تختلف عن الطرق التي يستعملها الطفل في مثل عمره.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: لا يستطيع أن يعبر عن احتياجه بالتواصل غير اللفظي ولا يستطيع فهم لغة التواصل غير اللفظي.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: يستخدم سلوكيات غريبة غير مفهومة للتعبير عن احتياجاته، مع عدم الاهتمام بالإيماءات وتعبير وجوه الآخرين.'],
                ],
            ],
            [
                'Domain' => 'مستوى النشاط',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: نشاطه عادي مناسب لعمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يظهر نشاط زائد أو كسل زائد ويكون خاص بذاته.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: نشاط زائد لا يهدئ يصعب التحكم به هام لا ينام إلا قليلاً فوضوي غير منتظم، أو خامل لا يتحرك من مكانه ويحتاج إلى جهد كبير ليتفاعل مع نشاط معين.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: فوضى خشيب حركة مستمرة لا يجلس ساكناً فوضوي يرمي كل شيء على الأرض، يفتح ويقلب الأشياء.'],
                ],
            ],
            [
                'Domain' => 'مستوى وثبات الاستجابات الذهنية',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'طبيعي: في أداء المهارات في المواقف المختلفة المناسبة لعمره.'],
                    ['Score' => 2, 'Description' => 'غير طبيعي بدرجة طفيفة: يظهر تأخر في أداء المهارات المختلفة.'],
                    ['Score' => 3, 'Description' => 'غير طبيعي بدرجة متوسطة: تأخر في أداء المهارات ولكن من الممكن أن يتفاعل لنفس عمره في إحدى المهارات وتأخر في باقي المهارات.'],
                    ['Score' => 4, 'Description' => 'غير طبيعي بدرجة شديدة: يكون أفضل من الطفل الطبيعي في مهارتين وتكون مبالغ عليها ولكن يتأخر بباقي المهارات.'],
                ],
            ],
            [
                'Domain' => 'الانطباعات العامة',
                'Criteria' => [
                    ['Score' => 1, 'Description' => 'ليس توحد لا تظهر فيه صفات التوحد.'],
                    ['Score' => 2, 'Description' => 'توحد بسيط لديه بعض الصفات.'],
                    ['Score' => 3, 'Description' => 'توحد متوسط لديه صفات واضحة من التوحد.'],
                    ['Score' => 4, 'Description' => 'توحد شديد لديه معظم الصفات التوحدية.'],
                ],
            ]
        ];

        // تهيئة الـ responses التي سيتم إدراجها دفعة واحدة
        $responses_batch = [];
        $inserted_domains_count = 0;
        $inserted_responses_count = 0;

        $if_in = $this->db->get('cars_domains')->num_rows();

        if ($if_in > 0) {
            echo 'تم الاستيراد مسبقا';
        } else {
            foreach ($assessment_data as $domain_data) {

                // ** 2. إدراج المجال الرئيسي (Domain) في جدول cars_domains **
                $domain_name = $domain_data['Domain'];
                $domain_insert_data = [
                    'name' => $domain_name
                ];

                // التأكد من عدم تكرار إدراج المجال إذا كان موجوداً بالفعل (اختياري)
                $this->db->insert('cars_domains', $domain_insert_data);
                $domain_id = $this->db->insert_id(); // الحصول على الـ ID الذي تم إدراجه للتو

                if ($domain_id) {
                    $inserted_domains_count++;

                    // ** 3. تحضير بيانات الاستجابات (Responses) **
                    foreach ($domain_data['Criteria'] as $criteria) {

                        // استخراج القيمة العددية الصحيحة للـ response_value
                        // نستخدم intval() لتحويل الدرجة إلى رقم صحيح، ونفترض أن 'N/A' ستتحول إلى 0 أو نتركها كـ NULL في حالة 'N/A'
                        $response_value = is_numeric($criteria['Score']) ? intval($criteria['Score']) : NULL;

                        $responses_batch[] = [
                            'domain_id' => $domain_id,
                            'response_text' => $criteria['Description'],
                            'response_value' => $response_value
                        ];
                    }
                }
            }

            // ** 4. إدراج كل الـ responses دفعة واحدة (Batch Insert) لتحسين الأداء **
            if (!empty($responses_batch)) {
                $this->db->insert_batch('cars_responses', $responses_batch);
                $inserted_responses_count = $this->db->affected_rows();
            }

            // ** 5. إخراج نتيجة العملية **
            echo "<h1>نتائج استيراد بيانات CARS</h1>";
            echo "<p>تم إدراج <strong>{$inserted_domains_count}</strong> مجالات رئيسية بنجاح في جدول <code>cars_domains</code>.</p>";
            echo "<p>تم إدراج <strong>{$inserted_responses_count}</strong> استجابة بنجاح في جدول <code>cars_responses</code>.</p>";

            if ($inserted_domains_count > 0 && $inserted_responses_count > 0) {
                echo "<p style='color: green; font-weight: bold;'>✅ عملية الاستيراد اكتملت بنجاح!</p>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>❌ فشل في الاستيراد أو لا توجد بيانات جديدة.</p>";
            }
        }
    }

    public function fix_phones() {
        $total_updated = 0;
        
        // إصلاح هواتف أولياء الأمور
        echo "<h2>إصلاح هواتف أولياء الأمور:</h2>";
        $total_updated += $this->fix_table_phones('parent', 'parent_id', 'phone');
        
        // إصلاح هواتف الموظفين
        echo "<h2>إصلاح هواتف الموظفين:</h2>";
        $total_updated += $this->fix_table_phones('employee', 'employee_id', 'phone');
        
        echo "<br><strong>تم تحديث $total_updated رقم في الجدولين</strong>";
    }
    
    /**
     * دالة عامة لتصحيح الهواتف في أي جدول
     */
    private function fix_table_phones($table_name, $id_column, $phone_column) {
        // جلب جميع السجلات من الجدول
        $query = $this->db->get($table_name);
        $records = $query->result();
        
        $updated_count = 0;
        
        foreach ($records as $record) {
            $original_phone = $record->$phone_column;
            $fixed_phone = $this->fix_phone($original_phone);
            
            // إذا تغير الرقم، قم بالتحديث
            if ($fixed_phone !== $original_phone && !empty($fixed_phone)) {
                $this->db->where($id_column, $record->$id_column);
                $this->db->update($table_name, array($phone_column => $fixed_phone));
                $updated_count++;
                
                echo "تم التصحيح في $table_name: $original_phone → $fixed_phone<br>";
            }
        }
        
        echo "تم تحديث $updated_count رقم في جدول $table_name<br>";
        return $updated_count;
    }
    
    /**
     * دالة تصحيح الرقم محسنة
     */
    private function fix_phone($phone) {
        if (empty($phone)) {
            return $phone;
        }
        
        // تحويل الأرقام العربية إلى إنجليزية أولاً
        $phone = $this->convert_arabic_numbers($phone);
        
        // إزالة جميع الرموز غير الرقمية بما في Unicode ومسافات
        $phone = preg_replace('/[^\d]/u', '', $phone);
        
        // إذا كان الرقم فارغاً بعد التنظيف
        if (empty($phone)) {
            return '';
        }
        
        // التعامل مع الرموز الدولية
        if (strlen($phone) > 10) {
            // إذا يبدأ بـ 962 (الأردن) ويتبعه 7
            if (substr($phone, 0, 3) === '962' && substr($phone, 3, 1) === '7') {
                $phone = '0' . substr($phone, 3); // تحويل 9627xxxxxxx إلى 07xxxxxxx
            }
            // إذا يبدأ بـ 966 (السعودية) ويتبعه 5
            elseif (substr($phone, 0, 3) === '966' && substr($phone, 3, 1) === '5') {
                $phone = '0' . substr($phone, 3); // تحويل 9665xxxxxxx إلى 05xxxxxxx
            }
        }
        
        // التعامل مع الأرقام المحلية
        $length = strlen($phone);
        $first_digit = substr($phone, 0, 1);
        
        switch($length) {
            case 9:
                // إذا كان 9 أرقام ويبدأ بـ 7 أو 5
                if ($first_digit === '7' || $first_digit === '5') {
                    return '0' . $phone;
                }
                break;
                
            case 10:
                // إذا كان 10 أرقام ويبدأ بـ 7 أو 5 (بدون صفر)
                if ($first_digit === '7' || $first_digit === '5') {
                    return '0' . $phone;
                }
                // إذا كان يبدأ بـ 07 أو 05 اتركه كما هو
                if (substr($phone, 0, 2) === '07' || substr($phone, 0, 2) === '05') {
                    return $phone;
                }
                break;
                
            case 11:
                // إذا كان 11 رقماً ويبدأ بـ 07 أو 05 اتركه
                if (substr($phone, 0, 2) === '07' || substr($phone, 0, 2) === '05') {
                    return $phone;
                }
                break;
        }
        
        // إذا لم يتطابق مع أي حالة، نعيده بعد التنظيف
        return $phone;
    }
    
    /**
     * تحويل الأرقام العربية إلى إنجليزية
     */
    private function convert_arabic_numbers($string) {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        return str_replace($arabic, $english, $string);
    }
    
    /**
     * دالة لرؤية الإحصائيات قبل التصحيح
     */
    public function check_phones() {
        echo "<h2>فحص الهواتف قبل التصحيح:</h2>";
        
        $this->check_table_phones('parent', 'parent_id', 'phone', 'أولياء الأمور');
        $this->check_table_phones('employee', 'employee_id', 'phone', 'الموظفين');
    }
    
    /**
     * فحص الهواتف في جدول معين
     */
    private function check_table_phones($table_name, $id_column, $phone_column, $table_label) {
        $query = $this->db->get($table_name);
        $records = $query->result();
        
        $correct_count = 0;
        $incorrect_count = 0;
        $incorrect_phones = [];
        
        foreach ($records as $record) {
            $phone = $record->$phone_column;
            $fixed_phone = $this->fix_phone($phone);
            
            if ($phone === $fixed_phone || empty($phone)) {
                $correct_count++;
            } else {
                $incorrect_count++;
                $incorrect_phones[] = [
                    'id' => $record->$id_column,
                    'original' => $phone,
                    'fixed' => $fixed_phone
                ];
            }
        }
        
        echo "<h3>جدول $table_label:</h3>";
        echo "إجمالي السجلات: " . count($records) . "<br>";
        echo "الهواتف الصحيحة: $correct_count<br>";
        echo "الهواتف التي تحتاج تصحيح: $incorrect_count<br>";
        
        if ($incorrect_count > 0) {
            echo "<h4>الهواتف التي تحتاج تصحيح:</h4>";
            foreach ($incorrect_phones as $item) {
                echo "ID: {$item['id']} - {$item['original']} → {$item['fixed']}<br>";
            }
        }
        echo "<hr>";
    }
    
    /**
     * اختبار الدالة على أمثلة محددة
     */
    public function test1() {
        $test_cases = [
            '798256961' => '0798256961',
            '795558317' => '0795558317', 
            '790345508' => '0790345508',
            '⁦7 9751 0854⁩0' => '7975108540',
            '⁦07 7977 9293⁩' => '0779779293',
            '⁦+962 7 8711 5858⁩' => '0787115858',
            '⁦+962 7 7572 6358⁩' => '0775726358',
            '٠٧٩٨٦٥٧٠٨١' => '0798657081',
            '٠٧٧٧٠٣٦٢٥٠' => '0777036250'
        ];
        
        foreach ($test_cases as $input => $expected) {
            $result = $this->fix_phone($input);
            $status = ($result === $expected) ? '✓' : '✗';
            echo "$status المدخل: $input → الناتج: $result (المتوقع: $expected)<br>";
        }
    }
}
