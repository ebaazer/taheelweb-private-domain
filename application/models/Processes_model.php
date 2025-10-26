<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Processes_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function not_have_permissions() {
        $page_data['page_name'] = 'not_have_permissions';
        $page_data['page_title'] = $this->lang->line('not_have_permissions');
        //$this->processes_model->visit_pages_panel($page_data['page_name']);
        return $page_data;
    }

    /*  ---------------      visit pages panel    ---------------    */

    //function visit_pages_panel($page_data) {
    //    $data['page_name'] = $page_data;
    //    $data['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
    //    $data['date'] = strtotime(date("Y-m-d H:i:s"));
    //    $this->db->insert('visit_pages_panel', $data);
    //}

    /*  ---------------      Visit Pages site    ---------------    */

    function visit_pages_site($page_data) {
        $data['page_name'] = $page_data;
        $data['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('visit_pages_site', $data);

        $number_visitors = $this->db->get_where('frontend_settings', array('type' => 'number_visitors'))->row()->description;
        $visitors['description'] = $number_visitors + 1;

        $this->db->where('type', 'number_visitors');
        $this->db->update('frontend_settings', $visitors);
    }

    /*  ---------------      Student    ---------------    */

    function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    function add_student() {
        
    }

    function replacement_name($param1 = '', $param2 = '', $param3 = '') {
        //$example = $param1;
        //$replace = str_replace(substr($example, 6, 20), str_repeat('*', 10), $example);
        //echo "$replace";
        //return $replace;
        //  $param1 = '08066417364';    

        $new_name = explode(" ", $param1);

        $cc = count($new_name);

        for ($x = 0; $x <= $cc; $x++) {

            if ($new_name[0] == '') {
                $new_n = $new_name[1] . ' ' . $new_name[2] . ' ' . '*****' . ' ' . '*****';
            } else {
                $new_n = $new_name[0] . ' ' . $new_name[1] . ' ' . '*****' . ' ' . '*****';
            }
        }
        //$mask_number =  str_repeat("*", strlen($param1)-4) . substr($param1, -4);
        return $new_n;
    }

    function replacement_phone($param1 = '', $param2 = '', $param3 = '') {
        $number = $param1;
        $mask_number = str_repeat("*", strlen($number) - 3) . substr($number, -3);
        return $mask_number;
    }

    /*
     * لم تعد مستخدمة
      function edit_student($param2) {

      $student_id = $param2;

      $running_year = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;
      $enroll_id = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year))->row()->enroll_id;

      $data['name'] = $this->input->post('name');
      $data['identity_type'] = $this->input->post('identity_type');
      $data['no_identity'] = $this->input->post('no_identity');
      $data['beneficiary_number'] = $this->input->post('beneficiary_number');

      $day_birth = $this->input->post('day_birth');
      $month_birth = $this->input->post('month_birth');
      $year_birth = $this->input->post('year_birth');

      $data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;

      if ($this->input->post('type_birth') == 1) {
      $data['type_birth'] = $this->input->post('type_birth');
      } else {
      $data['type_birth'] = '0';
      }

      $day_admission = $this->input->post('day_admission');
      $month_admission = $this->input->post('month_admission');
      $year_admission = $this->input->post('year_admission');

      $data['admission_year'] = $day_admission . '-' . $month_admission . '-' . $year_admission;
      if ($this->input->post('type_admission') == 1) {
      $data['type_admission'] = $this->input->post('type_admission');
      } else {
      $data['type_admission'] = '0';
      }

      $data['gender'] = $this->input->post('gender');
      $data['nationality_id'] = $this->input->post('nationality_id');
      $data['disability_category'] = $this->input->post('disability_category');
      $data['more_specific_type_disability'] = $this->input->post('more_specific_type_disability');
      $data['more_specific_type_disability_2'] = $this->input->post('more_specific_type_disability_2');

      $data['parent_id'] = $this->input->post('parent_id');
      $data['degree_kinship'] = $this->input->post('degree_kinship');

      $data['city'] = $this->input->post('city');
      $data['region'] = $this->input->post('region');
      $data['street'] = $this->input->post('street');
      $data['building_number'] = $this->input->post('building_number');

      //$data ['student_code'] = '000000';

      $this->db->where('student_id', $student_id);
      $this->db->update('student', $data);

      //$data2['class_id'] = $this->input->post('class_id');
      //$data2['section_id'] = $this->input->post('section_id');

      //$this->db->where('enroll_id', $enroll_id);
      //$this->db->update('enroll', $data2);



      if ($this->input->post('image_delete') == 'Y') {
      $file_name = 'uploads/student_image/' . $student_id . '.jpg';
      $new_file_name = 'uploads/student_image/' . $student_id . '-' . date("Y-m-d-H-i-s") . '.jpg';
      if (file_exists($file_name)) {
      rename($file_name, $new_file_name);
      }
      } else {
      move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');
      }


      $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_student') . ' ' . $data['name'];
      $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
      $data3['date'] = strtotime(date("Y-m-d H:i:s"));
      $this->db->insert('database_history', $data3);
      }

     */

    /*  ---------------      End Student    ---------------    */

    /*  ---------------      Employee    ---------------    */

    function add_employee() {

        /*
        $data['employee_code'] = $this->input->post('employee_code');
        $data['name'] = $this->input->post('name');
        $data['identity_type'] = $this->input->post('identity_type');
        $data['no_identity'] = $this->input->post('no_identity');
        $data['place_of_issue'] = $this->input->post('place_of_issue');

        $day_expiry_identity = $this->input->post('day_expiry_identity');
        $month_expiry_identity = $this->input->post('month_expiry_identity');
        $year_expiry_identity = $this->input->post('year_expiry_identity');

        $data['expiry_date'] = $day_expiry_identity . '-' . $month_expiry_identity . '-' . $year_expiry_identity;

        if ($this->input->post('type_expiry_identity') == 1) {
            $data['type_expiry_identity'] = $this->input->post('type_expiry_identity');
        }
        $data['job_title_id'] = $this->input->post('job_title_id');
        $data['class_id'] = $this->input->post('class_id');

        $day_hiring = $this->input->post('day_hiring');
        $month_hiring = $this->input->post('month_hiring');
        $year_hiring = $this->input->post('year_hiring');

        $data['date_of_hiring'] = $day_hiring . '-' . $month_hiring . '-' . $year_hiring;
        if ($this->input->post('type_hiring') == 1) {
            $data['type_hiring'] = $this->input->post('type_hiring');
        }

        $data['educational_level'] = $this->input->post('educational_level');
        $data['specializing'] = $this->input->post('specializing');

        $day_birth = $this->input->post('day_birth');
        $month_birth = $this->input->post('month_birth');
        $year_birth = $this->input->post('year_birth');

        $data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;

        if ($this->input->post('type_birth') == 1) {
            $data['type_birth'] = $this->input->post('type_birth');
        }

        $data['gender'] = $this->input->post('sex');
        $data['nationality_id'] = $this->input->post('nationality_id');
        $data['social_status'] = $this->input->post('social_status');
        $data['city'] = $this->input->post('city');
        $data['region'] = $this->input->post('region');
        $data['street'] = $this->input->post('street');
        $data['building_number'] = $this->input->post('building_number');

        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));

        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');

        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }

        $data['country_code_emergency_telephone'] = $this->input->post('country_code_emergency_telephone');
        $emergency_telephone = $this->input->post('emergency_telephone');

        $data['account_code'] = $this->input->post('account_code');
        $zero_phone = substr($emergency_telephone, 0, 1);
        if ($zero_phone == 0) {
            $data['emergency_telephone'] = substr($emergency_telephone, 1);
        } else {
            $data['emergency_telephone'] = $emergency_telephone;
        }

        $data['practical_experiences'] = $this->input->post('practical_experiences');

        $data['encrypt_thread'] = $this->uuid();

        $level = $this->db->get_where('job_title', array('job_title_id' => $this->input->post('job_title_id')))->row()->level;
        $data['level'] = $level;
        $data['last_login'] = strtotime(date("Y-m-d H:i:s"));
        $data['virtual'] = empty($this->input->post('virtual')) ? "0" : "1";
        $data['date_added'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('employee', $data);
        $employee_id = $this->db->insert_id();

        //ادخال تاريخ مباشرة العمل
        $data_effective['employee_id'] = $employee_id;
        $data_effective['effective_date'] = $data['date_of_hiring'];
        $this->db->insert('effective_resignations_date', $data_effective);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_employee') . ' ' . $data['name'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);

        //move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/employee_image/' . $employee_id . '.jpg');
        */
    }

    function edit_employee($param2) {
        /*
        $employee_id = $param2;

        $data['employee_code'] = $this->input->post('employee_code');
        $data['name'] = $this->input->post('name');
        $data['identity_type'] = $this->input->post('identity_type');
        $data['no_identity'] = $this->input->post('no_identity');
        $data['place_of_issue'] = $this->input->post('place_of_issue');

        $day_expiry_identity = $this->input->post('day_expiry_identity');
        $month_expiry_identity = $this->input->post('month_expiry_identity');
        $year_expiry_identity = $this->input->post('year_expiry_identity');

        $data['expiry_date'] = $day_expiry_identity . '-' . $month_expiry_identity . '-' . $year_expiry_identity;

        if ($this->input->post('type_expiry_identity') == 1) {
            $data['type_expiry_identity'] = $this->input->post('type_expiry_identity');
        }
        $data['job_title_id'] = $this->input->post('job_title_id');
        $data['class_id'] = $this->input->post('class_id');

        $day_hiring = $this->input->post('day_hiring');
        $month_hiring = $this->input->post('month_hiring');
        $year_hiring = $this->input->post('year_hiring');

        $data['date_of_hiring'] = $day_hiring . '-' . $month_hiring . '-' . $year_hiring;
        if ($this->input->post('type_hiring') == 1) {
            $data['type_hiring'] = $this->input->post('type_hiring');
        }

        $data['educational_level'] = $this->input->post('educational_level');
        $data['specializing'] = $this->input->post('specializing');

        $day_birth = $this->input->post('day_birth');
        $month_birth = $this->input->post('month_birth');
        $year_birth = $this->input->post('year_birth');

        $data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;

        if ($this->input->post('type_birth') == 1) {
            $data['type_birth'] = $this->input->post('type_birth');
        }

        $data['gender'] = $this->input->post('gender');
        $data['nationality_id'] = $this->input->post('nationality_id');
        $data['social_status'] = $this->input->post('social_status');
        $data['city'] = $this->input->post('city');
        $data['region'] = $this->input->post('region');
        $data['street'] = $this->input->post('street');
        $data['building_number'] = $this->input->post('building_number');

        $data['email'] = $this->input->post('email');

        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');

        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }

        $data['country_code_emergency_telephone'] = $this->input->post('country_code_emergency_telephone');
        $emergency_telephone = $this->input->post('emergency_telephone');

        $data['account_code'] = $this->input->post('account_code');
        $zero_phone = substr($emergency_telephone, 0, 1);
        if ($zero_phone == 0) {
            $data['emergency_telephone'] = substr($emergency_telephone, 1);
        } else {
            $data['emergency_telephone'] = $emergency_telephone;
        }

        $data['practical_experiences'] = $this->input->post('practical_experiences');

        $level = $this->db->get_where('job_title', array('job_title_id' => $this->input->post('job_title_id')))->row()->level;
        $data['level'] = $level;
        $data['last_login'] = strtotime(date("Y-m-d H:i:s"));
        $data['virtual'] = empty($this->input->post('virtual')) ? "0" : "1";
        $data['date_added'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->where('employee_id', $employee_id);
        $this->db->update('employee', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_employee') . ' ' . $data['name'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/employee_image/' . $employee_id . '.jpg');
        */
    }

    function edit_employee_profile($param2) {

        $employee_id = $param2;

        $data['identity_type'] = $this->input->post('identity_type');
        $data['no_identity'] = $this->input->post('no_identity');
        $data['place_of_issue'] = $this->input->post('place_of_issue');

        $day_expiry_identity = $this->input->post('day_expiry_identity');
        $month_expiry_identity = $this->input->post('month_expiry_identity');
        $year_expiry_identity = $this->input->post('year_expiry_identity');

        $data['expiry_date'] = $day_expiry_identity . '-' . $month_expiry_identity . '-' . $year_expiry_identity;

        if ($this->input->post('type_expiry_identity') == 1) {
            $data['type_expiry_identity'] = $this->input->post('type_expiry_identity');
        }

        $data['specializing'] = $this->input->post('specializing');

        $day_birth = $this->input->post('day_birth');
        $month_birth = $this->input->post('month_birth');
        $year_birth = $this->input->post('year_birth');

        $data['birthday'] = $day_birth . '-' . $month_birth . '-' . $year_birth;

        if ($this->input->post('type_birth') == 1) {
            $data['type_birth'] = $this->input->post('type_birth');
        }

        $data['sex'] = $this->input->post('sex');
        $data['nationality_id'] = $this->input->post('nationality_id');
        $data['social_status'] = $this->input->post('social_status');
        $data['city'] = $this->input->post('city');
        $data['region'] = $this->input->post('region');
        $data['street'] = $this->input->post('street');
        $data['building_number'] = $this->input->post('building_number');

        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));

        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');

        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }

        $data['country_code_emergency_telephone'] = $this->input->post('country_code_emergency_telephone');
        $emergency_telephone = $this->input->post('emergency_telephone');

        $zero_phone = substr($emergency_telephone, 0, 1);
        if ($zero_phone == 0) {
            $data['emergency_telephone'] = substr($emergency_telephone, 1);
        } else {
            $data['emergency_telephone'] = $emergency_telephone;
        }

        $data['practical_experiences'] = $this->input->post('practical_experiences');

        $this->db->where('employee_id', $employee_id);
        $this->db->update('employee', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_employee') . ' ' . $data['name'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/employee_image/' . $employee_id . '.jpg');
    }

    /*  ---------------     End Employee    ---------------    */

    /*  ---------------      Parent    ---------------    */

    function add_Parent() {
        
    }

    function edit_Parent($param2) {

        $parent_id = $param2;

        $data['name'] = $this->input->post('name');
        $data['nationality_id'] = $this->input->post('nationality_id');
        $data['email'] = $this->input->post('email');

        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');
        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }
        $data['country_code_another_phone'] = $this->input->post('country_code_another_phone');
        $another_phone = $this->input->post('another_phone');
        $zero_phone = substr($another_phone, 0, 1);
        if ($zero_phone == 0) {
            $data['another_phone'] = substr($another_phone, 1);
        } else {
            $data['another_phone'] = $another_phone;
        }
        $data['name_another_phone'] = $this->input->post('name_another_phone');
        $data['address'] = $this->input->post('address');
        $data['profession'] = $this->input->post('profession');

        $this->db->where('parent_id', $parent_id);
        $this->db->update('parent', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_info_parent') . ' ' . $data['name'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);
    }

    /*  ---------------     End Parent    ---------------    */

    function create_evaluation() {
        $data['evaluation_name'] = $this->input->post('evaluation_name');
        $data['class_id'] = $this->input->post('class_id');
        //$data['job_title_id'] = $this->input->post('job_title_id');
        $data['job_title_id'] = implode(",", $this->input->post('job_title_id'));

        $this->db->insert('evaluation_management', $data);
    }

    function create_evaluation_items() {
        $data['evaluation_id'] = $this->input->post('evaluation_id');
        $data['field_evaluation_id'] = $this->input->post('field_evaluation');
        $data['evaluation_items'] = $this->input->post('evaluation_items');
        $data['item_mark'] = $this->input->post('item_mark');
        $data['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data['date'] = strtotime(date("Y-m-d H:i:s"));

        $this->db->insert('evaluation_items', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_evaluation_items') . ' ' . $data['evaluation_items'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);
    }

    function edit_evaluation_items($param2) {
        $data_val = explode("-", $param2);
        $evaluation_id = $data_val[0];
        $evaluation_items_id = $data_val[1];

        $data['evaluation_items_id'] = $evaluation_items_id;
        $data['evaluation_items'] = $this->input->post('evaluation_items');
        $data['item_mark'] = $this->input->post('item_mark');

        $this->db->where('evaluation_items_id', $this->input->post('evaluation_items_id'));
        $this->db->update('evaluation_items', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('edit_evaluation_items') . ' ' . $data['evaluation_items'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);
    }

    function update_evaluation() {
        $data['evaluation_name'] = $this->input->post('evaluation_name');
        $data['class_id'] = $this->input->post('class_id');
        //$data['job_title_id'] = $this->input->post('job_title_id');
        $data['job_title_id'] = implode(",", $this->input->post('job_title_id'));

        $this->db->where('evaluation_management_id', $this->input->post('evaluation_management_id'));
        $this->db->update('evaluation_management', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('update_evaluation');
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);
    }

    function field_evaluation_employee() {
        $data['name'] = $this->input->post('field_evaluation_employee');
        $data['standards_evaluation'] = $this->input->post('standards_evaluation');
        $this->db->insert('field_evaluation_employee', $data);
    }

    /*  ---------------     Sections    ---------------    */

    function add_sctions() {
        
    }

    function edit_sctions($param2) {
        
    }

    /*  ---------------     End Sections    ---------------    */

    function add_admin() {

        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');

        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');
        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }

        $data['password'] = sha1($this->input->post('password'));

        $data['last_login'] = strtotime(date("Y-m-d H:i:s"));

        $data['encrypt_thread'] = $this->uuid();

        $this->db->insert('admin', $data);
    }

    function edit_admin($param2) {

        $admin_id = $param2;

        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['country_code'] = $this->input->post('country_code');
        $phone = $this->input->post('phone');
        $zero_phone = substr($phone, 0, 1);
        if ($zero_phone == 0) {
            $data['phone'] = substr($phone, 1);
        } else {
            $data['phone'] = $phone;
        }


        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin', $data);
    }

    function create_poll() {

        $data['encrypt_thread'] = $this->uuid();
        $data['name'] = $this->input->post('name');
        $data['class_id'] = $this->input->post('class_id');
        $data['job_title_id'] = $this->input->post('job_title_id');

        $data['instruction'] = $this->input->post('instruction');

        $this->db->insert('poll_manage', $data);

        return $data['encrypt_thread'];
    }

    function create_poll_items() {
        $data['poll_manage_id'] = $this->input->post('poll_id');
        $data['poll_axes_id'] = $this->input->post('poll_axes_id');
        $data['item'] = $this->input->post('poll_items');

        $this->db->insert('poll_items', $data);

        $data3['event'] = $this->lang->line('user') . ' ' . $this->session->userdata('name') . ' ' . $this->lang->line('insert_evaluation_items') . ' ' . $data['evaluation_items'];
        $data3['user_id'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $data3['date'] = strtotime(date("Y-m-d H:i:s"));
        $this->db->insert('database_history', $data3);
    }

    function edit_superuser($param2) {

        $admin_id = $param2;

        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $phone = $this->input->post('phone');
        $data['phone'] = $phone;

        $this->db->where('admin_id', $admin_id);
        $this->db->update('admin', $data);
    }
}
