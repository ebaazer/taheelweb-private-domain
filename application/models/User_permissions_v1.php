<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class User_permissions extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function description_permissions() {

        //$student
        //$student_assessment_case
        //$monthly_plan
        //$attendance_and_absence_management
        //$attendance_and_absence_report
        //$parents
        //$employee
        //$chats

        $student = array(// صلاحيات الطلاب
            "view_all_students" => "0", // عرض الطلاب
            "view_the_student_file" => "0", // ملفات الطلاب
            "add_student" => "0", // اضافة طالب
            "edit_student" => "0", // تعديل طالب
            "delete_student" => "0", // حذف طالب
            "student_card" => "0",
            "student_withdrawal" => "0", // انسحاب طالب
            "archive_students" => "0", // ارشيف الطلاب
            "student_enrollment_for_the_academic_year" => "0", // اضافة طالب من الارشيف
            "upload_files_to_student" => "0", // تحميل ملفات للطالب
            "behavior_modification" => "0", // تعديل السلوك
            "add_services_to_the_student" => "0", // اضافة خدمات للطالب
            "show_parent_phone" => "0", // عرض رقم هاتف ولي الأمر
        );

        $distribution_of_students_to_specialists = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $case_study = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $individual_plan = array(
            "show" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
            'delete_goal' => "0",
            'edit_plan_date' => '0',
        );

        $follow_daily_sessions = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $model_of_daily_follow_up_targets = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $student_assessment_case = array(
            'new_assessment' => "0", // تقييم طالب
            'show' => "0", // عرض التقييم
            "delete" => "0", // حذف التقييم
            'print' => "0", // طباعة التقييم
        );

        $monthly_plan = array(
            "show" => "0", // عرض الخطط الفترية
            "addition" => "0", // اضافة الخطط الفترية
            "modify" => "0", //تعديل الخطط الفترية
            "delete" => "0",
            "printing" => "0", // طباعة الخطط الفترية
            "plan_evaluation" => "0"
        );

        $individual_plan_report = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
            "assessment" => "0",
        );

        $skills_assessment_reports = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $record_assignments = array(
            "show" => "0",
            "addition" => "0",
            "modify" => "0",
            "delete" => "0",
            "printing" => "0",
        );

        $attendance_and_absence_management = array(
            "show" => "0", // عرض تسجيل حضور الطلاب
            "addition" => "0", // اضافة حضور للطلاب
            "delete" => "0", // خذف حضور الطلاب
            "view_all_students_option" => "0", // عرض جميع الطلاب في حضور الطلاب
        );

        $attendance_and_absence_report = array(
            "show" => "0", // عرض تقرير حضور الطلاب
            "printing" => "0", // طباعة تقرير حضور الطلاب
        );

        $parents = array(
            "show" => "0", // عرض اولياء الامور
            "view_parents_profile" => "0", // عرض ملف اولياء الامور
            "add" => "0", // اضافة ولي امر
            "edit" => "0", // تعديل ولي امر
            "delete_the_parent" => "0", // حذف ولي امر
            "prevent_me_from_entering_the_platform" => "0", // منع ولي الامر من الدخول للمنصة
            "change_password_parent" => "0", // تغير كلمة مرور ولي الامر
        );

        $summary_parent_satisfaction = array(
            "send_parent_poll" => "0",
            "view_poll_results" => "0",
            "delete_poll" => "0",
        );

        $employee = array(
            "show_all_account" => "0", // عرض الموظفيين
            "view_employee_profile" => "0", // عرض ملف الموظف
            "add_employee" => "0", // اضافة موظف
            "adjustment_officer" => "0", // تعديل موظف
            "delete_employee" => "0", // حذف موظف
            "the_resignation_of_an_employee" => "0",
            "return_an_employee_to_work" => "0",
            "staff_archive" => "0",
            "prevent_an_employee_from_entering_the_platform" => "0", // منع موظف من الدخول للمنصة
            "change_password_employee" => "0", // تغير كلمة مرور الموظف
            "upload_files_to_employee" => "0",
            'view_notes_on_employees' => "0",
            'add_new_notes_on_employees' => "0",
            'view_accountability_to_employee' => "0",
            'add_accountability_to_employee' => "0",
            'edit_accountability_to_employee' => "0",
            'delete_accountability_to_employee' => "0",
            'set_test_date_for_employees' => "0",
            'possibility_testing_employee' => "0",
            'test_results_for_employee_himself' => "0",
            'archive_tests_for_employee_himself' => "0",
            'employee_tested_results' => "0",
            'take_the_test' => "0",
        );

        $attendance_and_absence_of_staff = array(
            "show" => "0",
            "addition" => "0",
            "delete" => "0",
        );

        $attendance_and_absence_report_for_the_employee = array(
            "show" => "0",
            "printing" => "0",
        );

        $evaluation_of_staff = array(
            "evaluation_Officer" => "0",
            "view_evaluation_results" => "0",
        );

        $personnel_evaluation_department = array(
            "show" => "0",
            "add_rating" => "0",
            "edit_rating" => "0",
            "delete_rating" => "0",
            "evaluation_management" => "0",
            "print_the_evaluation" => "0",
            "add_an_evaluation_item" => "0",
            "add_a_standard_for_evaluation" => "0",
            "amendment_of_evaluation_item" => "0",
            "delete_the_evaluation_item" => "0",
        );

        $payments = array(
            "create_an_invoice" => "0",
            "edit_an_invoice" => "0",
            "delete_an_invoice" => "0",
            "view_invoices" => "0",
            "print_invoice" => "0",
            "view_sendad_capture" => "0",
            "print_the_document_of_arrest" => "0",
            "payments_category_show" => "0",
            "payments_category_add" => "0",
            "payments_category_edit" => "0",
            "payments_category_delete" => "0",
        );

        $discounts = array(
            "show" => "0",
            "add_a_discount" => "0",
            "discount_adjustment" => "0",
            "delete_a_discount" => "0",
        );

        $vat = array(
            "show" => "0",
            "add" => "0",
            "edit" => "0",
            "delete" => "0",
        );

        $expenses = array(
            "show" => "0",
            "add_expenses" => "0",
            "adjustment_of_expenses" => "0",
            "delete_expenses" => "0",
        );

        $expenditure_categories = array(
            "show" => "0",
            "add_item_expenses" => "0",
            "adjustment_of_expenses_item" => "0",
            "delete_item_expenses" => "0",
        );

        $raising_student = array(
            "the_possibility_of_upgrading_students" => "0",
        );

        $department_of_departments = array(
            "show" => "0",
            "add_section" => "0",
            "edit_section" => "0",
            "delete_section" => "0",
            "classroom_teachers" => "0",
        );

        $manage_classes = array(
            "show" => "0",
            "add_a_chapter" => "0",
            "edit_a_chapter" => "0",
            "delete_a_chapter" => "0",
        );

        $threads = array(
            "show" => "0",
            "add_topic" => "0",
            "edit_topic" => "0",
            "delete_a_topic" => "0",
        );

        $management_of_student_assessment = array(
            "show" => "0",
            "add_rating" => "0",
            "edit_rating" => "0",
            "delete_rating" => "0",
            "management" => "0",
            "print" => "0",
        );

        $class_schedule = array(
            "show" => "0",
            "add_a_share" => "0",
            "modify_quota" => "0",
            "delete_share" => "0",
            "printing" => "0",
        );

        $study_schedule_for_specialists = array(
            "show" => "0",
            "add_a_share" => "0",
            "modify_quota" => "0",
            "delete_share" => "0",
            "printing" => "0",
        );

        $transportation_management = array(
            "show" => "0",
            "add_student_transport" => "0",
            "print_transportation_students" => "0",
            "delete_student_from_transfer" => "0",
            "select_the_vehicle_for_the_area" => "0",
        );

        $areas_management = array(
            "show" => "0",
            "add_area" => "0",
            "edit_area" => "0",
            "delete_region" => "0",
        );

        $vehicle_management = array(
            "show" => "0",
            "add_a_vehicle" => "0",
            "modified_vehicle" => "0",
            "delete_a_vehicle" => "0",
        );

        $send_sms_messages = array(
            "show" => "0",
            "send_a_message_to_parents" => "0",
            "send_a_message_to_an_employee" => "0",
        );

        $manage_the_employee_powers = array(
            "ability_to_modify_permissions" => "0",
        );

        $visitor_messages = array(
            "show" => "0",
            "reply_to_visitor_messages" => "0",
            "delete_message" => "0",
        );

        $general_settings = array(
            "the_possibility_of_modification" => "0",
        );

        $website = array(
            "homepage" => "0",
            "mission_and_vision" => "0",
            "about_the_center" => "0",
            "blog" => "0",
            "photo_album" => "0",
            "sections" => "0",
            "services" => "0",
            "site_settings" => "0",
            "contact_email" => "0",
        );

        $program_activity = array(
            "See_program_activity" => "0",
        );

        $search = array(
            "allow_search" => "0",
        );

        $language_settings = array(
            "only_for_support" => "0",
        );

        $user_permissions = array(
            'user_permissions' => "0",
            'role_permissions' => "0",
        );

        $services_provided_to_the_student = array(
            'view_the_services_panel' => "0",
            'modify_the_services_provided' => "0",
            'delete_the_services_provided' => "0",
        );

        $feedback_on_staff = array(
            'add_new_note_type_employees' => "0",
            'display_list_of_note_types' => "0",
            'edit_note_types' => "0",
            'delete_note_types' => "0",
        );

        $staff_accountability = array(
            'view_type_accountability' => "0",
            'add_type_accountability' => "0",
            'edit_type_accountability' => "0",
            'delete_type_accountability' => "0",
        );

        $exams_employee = array(
            'management_tests' => "0",
            'publish_and_cancel_the_test' => "0",
            'add_test' => "0",
            'modified_test' => "0",
            'delete_test' => "0",
            'add_question' => "0",
            'edit_question' => "0",
            'delete_question' => "0",
            "print_sheet_answers" => "0",
            "print_the_questions_sheet" => "0",
        );

        $schedule_permission = array(
            'schedule_add' => '1',
            'schedule_edit' => '1',
            'schedule_delete' => '1'
        );

        $chats = array(
            "show" => "0", // المحادثات
        );

        $group_chats = array(
            "show" => "0",
            'add_group' => '1',
            'edit_group' => '1',
            'delete_group' => '1'
        );

        $employees_chats = array(
            "show" => "0",
        );

        $m_term_schedule = array(
            "m_term_schedule" => "0",
            "delete_term_schedule" => "0",
            "add_term_schedule" => "0",
            "edit_term_schedule" => "0",
        );

        $student_record = array(
            "show" => "0",
            'add_group' => '1',
            'edit_group' => '1',
            'delete_group' => '1'
        );

        $files_manager = array(
            "view_student_files" => "0",
            "upload_student_files" => "0",
            "delete_files_student" => "0",
            "rename_student_files" => "0",
            "view_employee_files" => "0",
            "upload_employee_files" => "0",
            "delete_student_files" => "0",
            "rename_employee_files" => "0",
        );

        $disability_classificationsr = array(
            "show" => "0",
            'add' => '0',
            'edit' => '0',
            'delete' => '0'
        );

        $platform_follow_ups = array(
            "show" => "0",
        );

        $deleted_items = array(
            "show" => "0",
            'data_recovery' => "0"
        );

        $parents_permission = array(
            "show" => "0",
        );

        $notifications = array(
            "show" => "0",
            'add' => '0',
            'edit' => '0',
            'delete' => '0'
        );

        $he_has_supervision_over = array(
            "teachers" => "0",
            'specialist' => '0',
        );

        $student_JSON = json_encode($student);
        $distribution_of_students_to_specialists_JSON = json_encode($distribution_of_students_to_specialists);
        $case_study_JSON = json_encode($case_study);
        $individual_plan_JSON = json_encode($individual_plan);
        $follow_daily_sessions_JSON = json_encode($follow_daily_sessions);
        $model_of_daily_follow_up_targets_JSON = json_encode($model_of_daily_follow_up_targets);
        $student_assessment_case_JSON = json_encode($student_assessment_case);
        $individual_plan_report_JSON = json_encode($individual_plan_report);
        $skills_assessment_reports_JSON = json_encode($skills_assessment_reports);
        $record_assignments_JSON = json_encode($record_assignments);
        $attendance_and_absence_management_JSON = json_encode($attendance_and_absence_management);
        $attendance_and_absence_report_JSON = json_encode($attendance_and_absence_report);
        $employee_JSON = json_encode($employee);
        $parents_JSON = json_encode($parents);
        $summary_parent_satisfaction_JSON = json_encode($summary_parent_satisfaction);
        $attendance_and_absence_of_staff_JSON = json_encode($attendance_and_absence_of_staff);
        $attendance_and_absence_report_for_the_employee_JSON = json_encode($attendance_and_absence_report_for_the_employee);
        $evaluation_of_staff_JSON = json_encode($evaluation_of_staff);
        $personnel_evaluation_department_JSON = json_encode($personnel_evaluation_department);
        $payments_JSON = json_encode($payments);
        $discounts_JSON = json_encode($discounts);
        $vat_JSON = json_encode($vat);
        $expenses_JSON = json_encode($expenses);
        $expenditure_categories_JSON = json_encode($expenditure_categories);
        $raising_student_JSON = json_encode($raising_student);
        $department_of_departments_JSON = json_encode($department_of_departments);
        $manage_classes_JSON = json_encode($manage_classes);
        $threads_JSON = json_encode($threads);
        $management_of_student_assessment_JSON = json_encode($management_of_student_assessment);
        $class_schedule_JSON = json_encode($class_schedule);
        $study_schedule_for_specialists_JSON = json_encode($study_schedule_for_specialists);
        $transportation_management_JSON = json_encode($transportation_management);
        $areas_management_JSON = json_encode($areas_management);
        $vehicle_management_JSON = json_encode($vehicle_management);
        $send_sms_messages_JSON = json_encode($send_sms_messages);
        $manage_the_employee_powers_JSON = json_encode($manage_the_employee_powers);
        $visitor_messages_JSON = json_encode($visitor_messages);
        $general_settings_JSON = json_encode($general_settings);
        $website_JSON = json_encode($website);
        $program_activity_JSON = json_encode($program_activity);
        $search_JSON = json_encode($search);
        $language_settings_JSON = json_encode($language_settings);
        $user_permissions_JSON = json_encode($user_permissions);
        $services_provided_to_the_student_JSON = json_encode($services_provided_to_the_student);
        $feedback_on_staff_JSON = json_encode($feedback_on_staff);
        $staff_accountability_JSON = json_encode($staff_accountability);
        $exams_employee_JSON = json_encode($exams_employee);
        $schedule_permission_JSON = json_encode($schedule_permission);
        $chats_JSON = json_encode($chats);
        $group_chats_JSON = json_encode($group_chats);
        $employees_chats_JSON = json_encode($employees_chats);
        $m_term_schedule_JSON = json_encode($m_term_schedule);
        $monthly_plan_JSON = json_encode($monthly_plan);
        $student_record_JSON = json_encode($student_record);
        $files_manager_JSON = json_encode($files_manager);
        $disability_classificationsr_JSON = json_encode($disability_classificationsr);
        $platform_follow_ups_JSON = json_encode($platform_follow_ups);
        $deleted_items_JSON = json_encode($deleted_items);
        $parents_permission_JSON = json_encode($parents_permission);
        $notifications_JSON = json_encode($notifications);
        $he_has_supervision_over_JSON = json_encode($he_has_supervision_over);

        $description_permissions = array(
            $student_JSON,
            $distribution_of_students_to_specialists_JSON,
            $case_study_JSON,
            $individual_plan_JSON,
            $follow_daily_sessions_JSON,
            $model_of_daily_follow_up_targets_JSON,
            $student_assessment_case_JSON,
            $individual_plan_report_JSON,
            $skills_assessment_reports_JSON,
            //$record_assignments_JSON,
            $attendance_and_absence_management_JSON,
            $attendance_and_absence_report_JSON,
            $employee_JSON,
            $parents_JSON,
            $summary_parent_satisfaction_JSON,
            $attendance_and_absence_of_staff_JSON,
            $attendance_and_absence_report_for_the_employee_JSON,
            $evaluation_of_staff_JSON,
            $personnel_evaluation_department_JSON,
            $payments_JSON,
            $discounts_JSON,
            $vat_JSON,
            $expenses_JSON,
            $expenditure_categories_JSON,
            $raising_student_JSON,
            $department_of_departments_JSON,
            $manage_classes_JSON,
            $threads_JSON,
            $management_of_student_assessment_JSON,
            $class_schedule_JSON,
            $study_schedule_for_specialists_JSON,
            $transportation_management_JSON,
            $areas_management_JSON,
            $vehicle_management_JSON,
            $send_sms_messages_JSON,
            $manage_the_employee_powers_JSON,
            $visitor_messages_JSON,
            $general_settings_JSON,
            $website_JSON,
            $program_activity_JSON,
            $search_JSON,
            $language_settings_JSON,
            $user_permissions_JSON,
            $services_provided_to_the_student_JSON,
            $feedback_on_staff_JSON,
            $staff_accountability_JSON,
            $exams_employee_JSON,
            $schedule_permission_JSON,
            $chats_JSON,
            $group_chats_JSON,
            $employees_chats_JSON,
            $m_term_schedule_JSON,
            $monthly_plan_JSON,
            $student_record_JSON,
            $files_manager_JSON,
            $disability_classificationsr_JSON,
            $platform_follow_ups_JSON,
            $deleted_items_JSON,
            $parents_permission_JSON,
            $notifications_JSON,
            $he_has_supervision_over_JSON
        );

        return $description_permissions;
    }

//user_permissions    

    function type_permissions() {

        $type_permissions = array(
            'student',
            'distribution_of_students_to_specialists',
            'case_study',
            'individual_plan',
            'follow_daily_sessions',
            'model_of_daily_follow_up_targets',
            'student_assessment_case',
            'individual_plan_report',
            'skills_assessment_reports',
            //'record_assignments',
            'attendance_and_absence_management',
            'attendance_and_absence_report',
            'employee',
            'parents',
            'summary_parent_satisfaction',
            'attendance_and_absence_of_staff',
            'attendance_and_absence_report_for_the_employee',
            'evaluation_of_staff',
            'personnel_evaluation_department',
            'payments',
            'discounts',
            'vat',
            'expenses',
            'expenditure_categories',
            'raising_student',
            'department_of_departments',
            'manage_classes',
            'threads',
            'management_of_student_assessment',
            'class_schedule',
            'study_schedule_for_specialists',
            'transportation_management',
            'areas_management',
            'vehicle_management',
            'send_sms_messages',
            'manage_the_employee_powers',
            'visitor_messages',
            'general_settings',
            'website',
            'program_activity',
            'search',
            'language_settings',
            'user_permissions',
            'services_provided_to_the_student',
            'feedback_on_staff',
            'staff_accountability',
            'exams_employee',
            'schedule_permission',
            'chats',
            'group_chats',
            'employees_chats',
            'm_term_schedule',
            'monthly_plan',
            'student_record',
            'files_manager',
            'disability_classificationsr',
            'platform_follow_ups',
            'deleted_items',
            'parents_permission',
            'notifications',
            'he_has_supervision_over'
        );

        return $type_permissions;
    }

    function set_user_permissions($employee_id = '') {

        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();

        foreach ($type_permissions as $index => $type) {
            $data['employee_id'] = $employee_id;
            $data['type'] = $type;
            $data['description'] = $description_permissions[$index];

            $checker_employee_permissions = $this->db->get_where('user_permissions', array('employee_id' => $employee_id, 'type' => $type));
            if ($checker_employee_permissions->num_rows() == 0) {
                $this->db->insert('user_permissions', $data);
            }
        }
    }

    function get_raw_permissions() {
        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();
        $results = array();
        foreach ($type_permissions as $index => $type) {
            $data['employee_id'] = $employee_id;
            $data['type'] = $type;
            $data['description'] = $description_permissions[$index];

            array_push($results, array(
                'type' => $type,
                'description' => $description_permissions[$index]
            ));
        }
        return $results;
    }

    function get_user_permissions($employee_id) {
        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();
        foreach ($type_permissions as $index => $type) {
            $data['employee_id'] = $employee_id;
            $data['type'] = $type;
            $data['description'] = $description_permissions[$index];
        }
        return $description_permissions;
    }
}
