<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_permissions extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    private function default_permissions() {
        return [
            'student' => [
                "view_all_students" => "0",
                "view_the_student_file" => "0",
                "add_student" => "0",
                "edit_student" => "0",
                "delete_student" => "0",
                "student_card" => "0",
                "student_withdrawal" => "0",
                "archive_students" => "0",
                "student_enrollment_for_the_academic_year" => "0",
                "upload_files_to_student" => "0",
                "behavior_modification" => "0",
                "add_services_to_the_student" => "0",
                "show_parent_phone" => "0",
                'print_export' => "0",
                'excel_export' => "0"
            ],
            'distribution_of_students_to_specialists' => [
                "show" => "0",
                "addition" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
            ],
            'case_study' => [
                "show" => "0",
                "addition" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
            ],
            'individual_plan' => [
                "show" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
                'delete_goal' => "0",
                'edit_plan_date' => '0',
            ],
            'follow_daily_sessions' => [
                "show" => "0",
                "addition" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
            ],
            'model_of_daily_follow_up_targets' => [
                "show" => "0",
                "addition" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
            ],
            'student_assessment_case' => [
                'new_assessment' => "0", // تقييم طالب
                'show' => "0", // عرض التقييم
                "delete" => "0", // حذف التقييم
                'print' => "0", // طباعة التقييم
            ],
            'monthly_plan' => [
                "show" => "0", // عرض الخطط الفترية
                "addition" => "0", // اضافة الخطط الفترية
                "modify" => "0", //تعديل الخطط الفترية
                "delete" => "0",
                "printing" => "0", // طباعة الخطط الفترية
                "plan_evaluation" => "0"
            ],
            //'individual_plan_report' => [ //تقرير الخطة الفردية
            //    "show" => "0",
            //    "addition" => "0",
            //    "modify" => "0",
            //    "delete" => "0",
            //    "printing" => "0",
            //    "assessment" => "0",
            //],
            //'skills_assessment_reports' => [
            //    "show" => "0",
            //    "addition" => "0",
            //    "modify" => "0",
            //    "delete" => "0",
            //    "printing" => "0",
            //],
            'record_assignments' => [
                "show" => "0",
                "addition" => "0",
                "modify" => "0",
                "delete" => "0",
                "printing" => "0",
            ],
            'attendance_and_absence_management' => [
                "show" => "0", // عرض تسجيل حضور الطلاب
                "addition" => "0", // اضافة حضور للطلاب
                "delete" => "0", // خذف حضور الطلاب
                "view_all_students_option" => "0", // عرض جميع الطلاب في حضور الطلاب
            ],
            'attendance_and_absence_report' => [
                "show" => "0", // عرض تقرير حضور الطلاب
                "printing" => "0", // طباعة تقرير حضور الطلاب
            ],
            'parents' => [
                "show" => "0", // عرض اولياء الامور
                "view_parents_profile" => "0", // عرض ملف اولياء الامور
                "add" => "0", // اضافة ولي امر
                "edit" => "0", // تعديل ولي امر
                "delete_the_parent" => "0", // حذف ولي امر
                "prevent_me_from_entering_the_platform" => "0", // منع ولي الامر من الدخول للمنصة
                "change_password_parent" => "0", // تغير كلمة مرور ولي 
                "print" => "0",
                'excel_export' => "0"
            ],
            'summary_parent_satisfaction' => [
                "send_parent_poll" => "0",
                "view_poll_results" => "0",
                "delete_poll" => "0",
            ],
            'employee' => [
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
                'print_export' => "0",
                'excel_export' => "0"
            ],
            'attendance_and_absence_of_staff' => [
                "show" => "0",
                "addition" => "0",
                "delete" => "0",
            ],
            'attendance_and_absence_report_for_the_employee' => [
                "show" => "0",
                "printing" => "0",
            ],
            'evaluation_of_staff' => [
                "evaluation_Officer" => "0",
                "view_evaluation_results" => "0",
            ],
            'personnel_evaluation_department' => [
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
            ],
            'payments' => [
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
            ],
            'discounts' => [
                "show" => "0",
                "add_a_discount" => "0",
                "discount_adjustment" => "0",
                "delete_a_discount" => "0",
            ],
            'vat' => [
                "show" => "0",
                "add" => "0",
                "edit" => "0",
                "delete" => "0",
            ],
            'expenses' => [
                "show" => "0",
                "add_expenses" => "0",
                "adjustment_of_expenses" => "0",
                "delete_expenses" => "0",
            ],
            'expenditure_categories' => [
                "show" => "0",
                "add_item_expenses" => "0",
                "adjustment_of_expenses_item" => "0",
                "delete_item_expenses" => "0",
            ],
            'raising_student' => [
                "the_possibility_of_upgrading_students" => "0",
            ],
            'department_of_departments' => [
                "show" => "0",
                "add_section" => "0",
                "edit_section" => "0",
                "delete_section" => "0",
                "classroom_teachers" => "0",
            ],
            'manage_classes' => [
                "show" => "0",
                "add_a_chapter" => "0",
                "edit_a_chapter" => "0",
                "delete_a_chapter" => "0",
            ],
            'threads' => [
                "show" => "0",
                "add_topic" => "0",
                "edit_topic" => "0",
                "delete_a_topic" => "0",
            ],
            'management_of_student_assessment' => [
                "show" => "0",
                "add_rating" => "0",
                "edit_rating" => "0",
                "delete_rating" => "0",
                "management" => "0",
                "print" => "0",
            ],
            //'class_schedule' => [
            //    "show" => "0",
            //    "add_a_share" => "0",
            //    "modify_quota" => "0",
            //    "delete_share" => "0",
            //    "printing" => "0",
            //],
            'study_schedule_for_specialists' => [
                "show" => "0",
                "add_a_share" => "0",
                "modify_quota" => "0",
                "delete_share" => "0",
                "printing" => "0",
            ],
            'transportation_management' => [
                "show" => "0",
                "add_student_transport" => "0",
                "print_transportation_students" => "0",
                "delete_student_from_transfer" => "0",
                "select_the_vehicle_for_the_area" => "0",
            ],
            'areas_management' => [
                "show" => "0",
                "add_area" => "0",
                "edit_area" => "0",
                "delete_region" => "0",
            ],
            'vehicle_management' => [
                "show" => "0",
                "add_a_vehicle" => "0",
                "modified_vehicle" => "0",
                "delete_a_vehicle" => "0",
            ],
            //'send_sms_messages' => [
            //    "show" => "0",
            //    "send_a_message_to_parents" => "0",
            //    "send_a_message_to_an_employee" => "0",
            //],
            'manage_the_employee_powers' => [
                "ability_to_modify_permissions" => "0",
            ],
            'visitor_messages' => [
                "show" => "0",
                "reply_to_visitor_messages" => "0",
                "delete_message" => "0",
            ],
            'general_settings' => [
                "the_possibility_of_modification" => "0",
            ],
            'website' => [
                "homepage" => "0",
                "mission_and_vision" => "0",
                "about_the_center" => "0",
                "blog" => "0",
                "photo_album" => "0",
                "sections" => "0",
                "services" => "0",
                "site_settings" => "0",
                "contact_email" => "0",
            ],
            //'program_activity' => [
            //    "See_program_activity" => "0",
            //],
            //'search' => [
            //    "allow_search" => "0",
            //],
            //'language_settings' => [
            //    "only_for_support" => "0",
            //],
            'user_permissions' => [
                'user_permissions' => "0",
                'role_permissions' => "0",
            ],
            'services_provided_to_the_student' => [
                'view_the_services_panel' => "0",
                'modify_the_services_provided' => "0",
                'delete_the_services_provided' => "0",
            ],
            'feedback_on_staff' => [
                'add_new_note_type_employees' => "0",
                'display_list_of_note_types' => "0",
                'edit_note_types' => "0",
                'delete_note_types' => "0",
            ],
            'staff_accountability' => [
                'view_type_accountability' => "0",
                'add_type_accountability' => "0",
                'edit_type_accountability' => "0",
                'delete_type_accountability' => "0",
            ],
            'exams_employee' => [
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
            ],
            'schedule_permission' => [
                "show" => "1",
                'schedule_add' => '1',
                'schedule_edit' => '1',
                'schedule_delete' => '1'
            ],
            'chats' => [
                "show" => "0", // المحادثات
                "view_others_chats" => "0", // المحادثات
            ],
            //'group_chats' => [
            //    "show" => "0",
            //    'add_group' => '1',
            //    'edit_group' => '1',
            //    'delete_group' => '1'
            //],
            //'employees_chats' => [
            //    "show" => "0",
            //],
            'm_term_schedule' => [
                "m_term_schedule" => "0",
                "delete_term_schedule" => "0",
                "add_term_schedule" => "0",
                "edit_term_schedule" => "0",
            ],
            'student_record' => [
                "show" => "0",
                'add_group' => '1',
                'edit_group' => '1',
                'delete_group' => '1'
            ],
            'files_manager' => [
                "view_student_files" => "0",
                "upload_student_files" => "0",
                "delete_files_student" => "0",
                "rename_student_files" => "0",
                "view_employee_files" => "0",
                "upload_employee_files" => "0",
                "delete_student_files" => "0",
                "rename_employee_files" => "0",
            ],
            'disability_classificationsr' => [
                "show" => "0",
                'add' => '0',
                'edit' => '0',
                'delete' => '0'
            ],
            'platform_follow_ups' => [
                "show" => "0",
            ],
            'deleted_items' => [
                "show" => "0",
                'data_recovery' => "0"
            ],
            'parents_permission' => [
                "show" => "0",
            ],
            'notifications' => [
                "show" => "0",
                'add' => '0',
                'edit' => '0',
                'delete' => '0',
                'notifications_mobile' => '0',
            ],
            'he_has_supervision_over' => [
                "teachers" => "0",
                'specialist' => '0',
            ],
            'metrics' => [
                "show" => "0",
                'add' => '0',
                'edit' => '0',
                'delete' => '0',
                'print' => '0'
            ],
            'manage_subsections' => [
                "show" => "0",
                "add" => "0",
                "edit" => "0",
                "delete" => "0",
            ],
            'forms_and_reports' => [
                "show" => "0",
                'add' => '0',
                'edit' => '0',
                'delete' => '0',
                'management' => '0'
            ],
            'behavior_modification' => [
                "show" => "0",
                'add' => '0',
                'print' => '0',
                'delete' => '0',
            ],
            'nutrition' => [
                "show" => "0",
                'add' => '0',
                'print' => '0',
                'delete' => '0',
            ],
            'warehouse_management' => [
                "show" => "0",
                'add' => '0',
                'edit' => '0',
                'print' => '0',
                'delete' => '0',
            ],
        ];
    }

    function default_permissions_dis() {
        return [
            'student' => [
                "view_all_students" => $this->lang->line("view_all_students_dis"),
                "view_the_student_file" => $this->lang->line("view_the_student_file_dis"),
                "add_student" => $this->lang->line("add_student_dis"),
                "edit_student" => $this->lang->line("edit_student_dis"),
                "delete_student" => $this->lang->line("delete_student_dis"),
                "student_card" => $this->lang->line("student_card_dis"),
                "student_withdrawal" => $this->lang->line("student_withdrawal_dis"),
                "archive_students" => $this->lang->line("archive_students_dis"),
                "student_enrollment_for_the_academic_year" => $this->lang->line("student_enrollment_for_the_academic_year_dis"),
                "upload_files_to_student" => $this->lang->line("upload_files_to_student_dis"),
                "behavior_modification" => $this->lang->line("behavior_modification_dis"),
                "add_services_to_the_student" => $this->lang->line("add_services_to_the_student_dis"),
                "show_parent_phone" => $this->lang->line("show_parent_phone_dis"),
                'print_export' => $this->lang->line("print_export_dis"),
                'excel_export' => $this->lang->line("excel_export_dis"),
            ],
            'distribution_of_students_to_specialists' => [
                "show" => $this->lang->line("distribution_show_dis"),
                "addition" => $this->lang->line("distribution_addition_dis"),
                "modify" => $this->lang->line("distribution_modify_dis"),
                "delete" => $this->lang->line("distribution_delete_dis"),
                "printing" => $this->lang->line("_no_dis"),
            ],
            'case_study' => [
                "show" => $this->lang->line("case_study_show_dis"),
                "addition" => $this->lang->line("case_study_addition_dis"),
                "modify" => $this->lang->line("case_study_modify_dis"),
                "delete" => $this->lang->line("case_study_delete_dis"),
                "printing" => $this->lang->line("case_study_printing_dis"),
            ],
            'individual_plan' => [
                "show" => $this->lang->line("individual_plan_show_dis"),
                "modify" => $this->lang->line("individual_plan_modify_dis"),
                "delete" => $this->lang->line("individual_plan_delete_dis"),
                "printing" => $this->lang->line("individual_plan_printing_dis"),
                'delete_goal' => $this->lang->line("individual_plan_delete_goal_dis"),
                'edit_plan_date' => $this->lang->line("individual_plan_edit_plan_date_dis"),
            ],
            'follow_daily_sessions' => [
                "show" => $this->lang->line("follow_daily_sessions_show_dis"),
                "addition" => $this->lang->line("follow_daily_sessions_addition_dis"),
                "modify" => $this->lang->line("follow_daily_sessions_modify_dis"),
                "delete" => $this->lang->line("follow_daily_sessions_delete_dis"),
                "printing" => $this->lang->line("follow_daily_sessions_printing_dis"),
            ],
            'model_of_daily_follow_up_targets' => [
                "show" => $this->lang->line("_no_dis"),
                "addition" => $this->lang->line("_no_dis"),
                "modify" => $this->lang->line("_no_dis"),
                "delete" => $this->lang->line("_no_dis"),
                "printing" => $this->lang->line("_no_dis"),
            ],
            'student_assessment_case' => [
                'new_assessment' => $this->lang->line("student_assessment_case_new_assessment_dis"),
                'show' => $this->lang->line("student_assessment_case_show_dis"),
                "delete" => $this->lang->line("student_assessment_case_delete_dis"),
                'print' => $this->lang->line("student_assessment_case_print_dis"),
            ],
            'monthly_plan' => [
                "show" => $this->lang->line("monthly_plan_show_dis"),
                "addition" => $this->lang->line("monthly_plan_addition_dis"),
                "modify" => $this->lang->line("monthly_plan_modify_dis"),
                "delete" => $this->lang->line("monthly_plan_delete_dis"),
                "printing" => $this->lang->line("monthly_plan_printing_dis"),
                "plan_evaluation" => $this->lang->line("monthly_plan_plan_evaluation_dis")
            ],
            //'individual_plan_report' => [ // تقرير الخطة الفردية
            //    "show" => $this->lang->line("_no_dis"),
            //    "addition" => $this->lang->line("_no_dis"),
            //    "modify" => $this->lang->line("_no_dis"),
            //    "delete" => $this->lang->line("_no_dis"),
            //    "printing" => $this->lang->line("_no_dis"),
            //    "assessment" => $this->lang->line("_no_dis"),
            //],
            //'skills_assessment_reports' => [
            //    "show" => $this->lang->line("_no_dis"),
            //    "addition" => $this->lang->line("_no_dis"),
            //    "modify" => $this->lang->line("_no_dis"),
            //    "delete" => $this->lang->line("_no_dis"),
            //    "printing" => $this->lang->line("_no_dis"),
            //],
            'record_assignments' => [
                "show" => $this->lang->line("record_assignments_show_dis"),
                "addition" => $this->lang->line("record_assignments_addition_dis"),
                "modify" => $this->lang->line("record_assignments_modify_dis"),
                "delete" => $this->lang->line("_no_dis"),
                "printing" => $this->lang->line("_no_dis"),
            ],
            'attendance_and_absence_management' => [
                "show" => $this->lang->line("attendance_and_absence_management_show_dis"),
                "addition" => $this->lang->line("attendance_and_absence_management_addition_dis"),
                "delete" => $this->lang->line("attendance_and_absence_management_delete_dis"),
                "view_all_students_option" => $this->lang->line("attendance_and_absence_management_view_all_students_option_dis"),
            ],
            'attendance_and_absence_report' => [
                "show" => $this->lang->line("attendance_and_absence_report_show_dis"),
                "printing" => $this->lang->line("attendance_and_absence_report_printing_dis"),
            ],
            'parents' => [
                "show" => $this->lang->line("parents_show_dis"),
                "view_parents_profile" => $this->lang->line("parents_view_parents_profile_dis"),
                "add" => $this->lang->line("parents_add_dis"),
                "edit" => $this->lang->line("parents_edit_dis"),
                "delete_the_parent" => $this->lang->line("parents_delete_the_parent_dis"),
                "prevent_me_from_entering_the_platform" => $this->lang->line("parents_prevent_me_from_entering_the_platform_dis"),
                "change_password_parent" => $this->lang->line("parents_change_password_parent_dis"),
                "print" => $this->lang->line("parents_print_dis"),
                'excel_export' => $this->lang->line("parents_excel_export_dis")
            ],
            'summary_parent_satisfaction' => [
                "send_parent_poll" => $this->lang->line("summary_parent_satisfaction_send_parent_poll_dis"),
                "view_poll_results" => $this->lang->line("summary_parent_satisfaction_view_poll_results_dis"),
                "delete_poll" => $this->lang->line("summary_parent_satisfaction_delete_poll_dis"),
            ],
            'employee' => [
                "show_all_account" => $this->lang->line("employee_show_all_account_dis"),
                "view_employee_profile" => $this->lang->line("employee_view_employee_profile_dis"),
                "add_employee" => $this->lang->line("employee_add_employee_dis"),
                "adjustment_officer" => $this->lang->line("employee_adjustment_officer_dis"),
                "delete_employee" => $this->lang->line("employee_delete_employee_dis"),
                "the_resignation_of_an_employee" => $this->lang->line("employee_the_resignation_of_an_employee_dis"),
                "return_an_employee_to_work" => $this->lang->line("employee_return_an_employee_to_work_dis"),
                "staff_archive" => $this->lang->line("employee_staff_archive_dis"),
                "prevent_an_employee_from_entering_the_platform" => $this->lang->line("employee_prevent_an_employee_from_entering_the_platform_dis"),
                "change_password_employee" => $this->lang->line("employee_change_password_employee_dis"),
                "upload_files_to_employee" => $this->lang->line("_no_dis"),
                'view_notes_on_employees' => $this->lang->line("_no_dis"),
                'add_new_notes_on_employees' => $this->lang->line("_no_dis"),
                'view_accountability_to_employee' => $this->lang->line("_no_dis"),
                'add_accountability_to_employee' => $this->lang->line("_no_dis"),
                'edit_accountability_to_employee' => $this->lang->line("_no_dis"),
                'delete_accountability_to_employee' => $this->lang->line("_no_dis"),
                'set_test_date_for_employees' => $this->lang->line("employee_set_test_date_for_employees_dis"),
                'possibility_testing_employee' => $this->lang->line("employee_possibility_testing_employee_dis"),
                'test_results_for_employee_himself' => $this->lang->line("employee_test_results_for_employee_himself_dis"),
                'archive_tests_for_employee_himself' => $this->lang->line("_no_dis"),
                'employee_tested_results' => $this->lang->line("_no_dis"),
                'take_the_test' => $this->lang->line("employee_take_the_test_dis"),
                'print_export' => $this->lang->line("employee_print_export_dis"),
                'excel_export' => $this->lang->line("employee_excel_export_dis")
            ],
            'attendance_and_absence_of_staff' => [
                "show" => $this->lang->line("attendance_and_absence_of_staff_show_dis"),
                "addition" => $this->lang->line("attendance_and_absence_of_staff_addition_dis"),
                "delete" => $this->lang->line("attendance_and_absence_of_staff_delete_dis"),
            ],
            'attendance_and_absence_report_for_the_employee' => [
                "show" => $this->lang->line("attendance_and_absence_report_for_the_employee_show_dis"),
                "printing" => $this->lang->line("attendance_and_absence_report_for_the_employee_printing_dis"),
            ],
            'evaluation_of_staff' => [
                "evaluation_Officer" => $this->lang->line("_no_dis"),
                "view_evaluation_results" => $this->lang->line("_no_dis"),
            ],
            'personnel_evaluation_department' => [
                "show" => $this->lang->line("a1001"),
                "add_rating" => $this->lang->line("a1002"),
                "edit_rating" => $this->lang->line("a1003"),
                "delete_rating" => $this->lang->line("a1004"),
                "evaluation_management" => $this->lang->line("a1005"),
                "print_the_evaluation" => $this->lang->line("a1006"),
                "add_an_evaluation_item" => $this->lang->line("a1007"),
                "add_a_standard_for_evaluation" => $this->lang->line("a1008"),
                "amendment_of_evaluation_item" => $this->lang->line("a1009"),
                "delete_the_evaluation_item" => $this->lang->line("a10a10"),
            ],
            'payments' => [
                "create_an_invoice" => $this->lang->line("a1011"),
                "edit_an_invoice" => $this->lang->line(""),
                "delete_an_invoice" => $this->lang->line("a1012"),
                "view_invoices" => $this->lang->line("a1013"),
                "print_invoice" => $this->lang->line("a1014"),
                "view_sendad_capture" => $this->lang->line("a1015"),
                "print_the_document_of_arrest" => $this->lang->line("a1016"),
                "payments_category_show" => $this->lang->line("a1017"),
                "payments_category_add" => $this->lang->line("a1018"),
                "payments_category_edit" => $this->lang->line("a1019"),
                "payments_category_delete" => $this->lang->line("a1020"),
            ],
            'discounts' => [
                "show" => $this->lang->line("a1021"),
                "add_a_discount" => $this->lang->line("a1022"),
                "discount_adjustment" => $this->lang->line("a1023"),
                "delete_a_discount" => $this->lang->line("a10024"),
            ],
            'vat' => [
                "show" => $this->lang->line("a1025"),
                "add" => $this->lang->line("a1026"),
                "edit" => $this->lang->line("a1027"),
                "delete" => $this->lang->line("a1028"),
            ],
            'expenses' => [
                "show" => $this->lang->line("a1029"),
                "add_expenses" => $this->lang->line("a1030"),
                "adjustment_of_expenses" => $this->lang->line("a1031"),
                "delete_expenses" => $this->lang->line("a1032"),
            ],
            'expenditure_categories' => [
                "show" => $this->lang->line("a1000"),
                "add_item_expenses" => $this->lang->line("a1000"),
                "adjustment_of_expenses_item" => $this->lang->line("a1000"),
                "delete_item_expenses" => $this->lang->line("a1000"),
            ],
            'raising_student' => [
                "the_possibility_of_upgrading_students" => $this->lang->line("a1033"),
            ],
            'department_of_departments' => [
                "show" => $this->lang->line("a1034"),
                "add_section" => $this->lang->line("a1035"),
                "edit_section" => $this->lang->line("a1036"),
                "delete_section" => $this->lang->line("a1037"),
                "classroom_teachers" => $this->lang->line("a1038"),
            ],
            'manage_classes' => [
                "show" => $this->lang->line("a1039"),
                "add_a_chapter" => $this->lang->line("a1040"),
                "edit_a_chapter" => $this->lang->line("a1041"),
                "delete_a_chapter" => $this->lang->line("a1042"),
            ],
            'threads' => [
                "show" => $this->lang->line("a1043"),
                "add_topic" => $this->lang->line("a1044"),
                "edit_topic" => $this->lang->line("a1045"),
                "delete_a_topic" => $this->lang->line("a1046"),
            ],
            'management_of_student_assessment' => [
                "show" => $this->lang->line("a1047"),
                "add_rating" => $this->lang->line("a1028"),
                "edit_rating" => $this->lang->line("a1049"),
                "delete_rating" => $this->lang->line("a1050"),
                "management" => $this->lang->line("a1051"),
                "print" => $this->lang->line("a1052"),
            ],
            //'class_schedule' => [
            //    "show" => $this->lang->line("a1053"),
            //    "add_a_share" => $this->lang->line("a1054"),
            //    "modify_quota" => $this->lang->line("a1055"),
            //    "delete_share" => $this->lang->line("a1056"),
            //    "printing" => $this->lang->line("a1057"),
            //],
            'study_schedule_for_specialists' => [
                "show" => $this->lang->line("a1058"),
                "add_a_share" => $this->lang->line("a1059"),
                "modify_quota" => $this->lang->line("a1060"),
                "delete_share" => $this->lang->line("a1061"),
                "printing" => $this->lang->line("a1062"),
            ],
            'transportation_management' => [
                "show" => $this->lang->line("a1063"),
                "add_student_transport" => $this->lang->line("a1064"),
                "print_transportation_students" => $this->lang->line("a1065"),
                "delete_student_from_transfer" => $this->lang->line("a1066"),
                "select_the_vehicle_for_the_area" => $this->lang->line("a1067"),
            ],
            'areas_management' => [
                "show" => $this->lang->line("a1068"),
                "add_area" => $this->lang->line("a1069"),
                "edit_area" => $this->lang->line("a1070"),
                "delete_region" => $this->lang->line("a1071"),
            ],
            'vehicle_management' => [
                "show" => $this->lang->line("a1072"),
                "add_a_vehicle" => $this->lang->line("a1073"),
                "modified_vehicle" => $this->lang->line("a1074"),
                "delete_a_vehicle" => $this->lang->line("a1075"),
            ],
            //'send_sms_messages' => [
            //    "show" => $this->lang->line("a1076"),
            //    "send_a_message_to_parents" => $this->lang->line("a1077"),
            //    "send_a_message_to_an_employee" => $this->lang->line("a1078"),
            //],
            'manage_the_employee_powers' => [
                "ability_to_modify_permissions" => $this->lang->line("a1079"),
            ],
            'visitor_messages' => [
                "show" => $this->lang->line("a1080"),
                "reply_to_visitor_messages" => $this->lang->line("a1081"),
                "delete_message" => $this->lang->line("a1082"),
            ],
            'general_settings' => [
                "the_possibility_of_modification" => $this->lang->line("a1083"),
            ],
            'website' => [
                "homepage" => $this->lang->line("a1084"),
                "mission_and_vision" => $this->lang->line("a1085"),
                "about_the_center" => $this->lang->line("a1086"),
                "blog" => $this->lang->line("a1087"),
                "photo_album" => $this->lang->line("a1088"),
                "sections" => $this->lang->line("a1089"),
                "services" => $this->lang->line("a1090"),
                "site_settings" => $this->lang->line("a1091"),
                "contact_email" => $this->lang->line("a1092"),
            ],
            //'program_activity' => [
            //    "See_program_activity" => $this->lang->line("a1093"),
            //],
            //'search' => [
            //    "allow_search" => $this->lang->line("a1094"),
            //],
            //'language_settings' => [
            //    "only_for_support" => $this->lang->line("a1095"),
            //],
            'user_permissions' => [
                'user_permissions' => $this->lang->line("a1096"),
                'role_permissions' => $this->lang->line("a1097"),
            ],
            'services_provided_to_the_student' => [
                'view_the_services_panel' => $this->lang->line("a1098"),
                'modify_the_services_provided' => $this->lang->line("a1099"),
                'delete_the_services_provided' => $this->lang->line("a1100"),
            ],
            'feedback_on_staff' => [
                'add_new_note_type_employees' => $this->lang->line("a1101"),
                'display_list_of_note_types' => $this->lang->line("a1102"),
                'edit_note_types' => $this->lang->line("a1103"),
                'delete_note_types' => $this->lang->line("a1104"),
            ],
            'staff_accountability' => [
                'view_type_accountability' => $this->lang->line("a1105"),
                'add_type_accountability' => $this->lang->line("a1106"),
                'edit_type_accountability' => $this->lang->line("a1107"),
                'delete_type_accountability' => $this->lang->line("a1108"),
            ],
            'exams_employee' => [
                'management_tests' => $this->lang->line("a1109"),
                'publish_and_cancel_the_test' => $this->lang->line("a1110"),
                'add_test' => $this->lang->line("a1111"),
                'modified_test' => $this->lang->line("a1112"),
                'delete_test' => $this->lang->line("a1113"),
                'add_question' => $this->lang->line("a1114"),
                'edit_question' => $this->lang->line("a1115"),
                'delete_question' => $this->lang->line("a1116"),
                "print_sheet_answers" => $this->lang->line("a1117"),
                "print_the_questions_sheet" => $this->lang->line("a1118"),
            ],
            'schedule_permission' => [
                'show' => $this->lang->line("a1053"),
                'schedule_add' => $this->lang->line("a1054"),
                'schedule_edit' => $this->lang->line("a1049"),
                'schedule_delete' => $this->lang->line("a1056")
            ],
            'chats' => [
                "show" => $this->lang->line("a1122"), // المحادثات
                "view_others_chats" => $this->lang->line("a1178"), // المحادثات
            ],
            //'group_chats' => [
            //    "show" => $this->lang->line("a1123"),
            //    'add_group' => $this->lang->line("a1124"),
            //    'edit_group' => $this->lang->line("a1125"),
            //    'delete_group' => $this->lang->line("a1126")
            //],
            //'employees_chats' => [
            //    "show" => $this->lang->line("a1127"),
            //],
            'm_term_schedule' => [
                "m_term_schedule" => $this->lang->line("a1128"),
                "delete_term_schedule" => $this->lang->line("a1129"),
                "add_term_schedule" => $this->lang->line("a1130"),
                "edit_term_schedule" => $this->lang->line("a1131"),
            ],
            'student_record' => [
                "show" => $this->lang->line("a1132"),
                'add_group' => $this->lang->line("a1133"),
                'edit_group' => $this->lang->line("a1134"),
                'delete_group' => $this->lang->line("a1135")
            ],
            'files_manager' => [
                "view_student_files" => $this->lang->line("a1136"),
                "upload_student_files" => $this->lang->line("a1137"),
                "delete_files_student" => $this->lang->line("a1138"),
                "rename_student_files" => $this->lang->line("a1139"),
                "view_employee_files" => $this->lang->line("a1140"),
                "upload_employee_files" => $this->lang->line("a1141"),
                "delete_student_files" => $this->lang->line("a1142"),
                "rename_employee_files" => $this->lang->line("a1143"),
            ],
            'disability_classificationsr' => [
                "show" => $this->lang->line("a1144"),
                'add' => $this->lang->line("a1145"),
                'edit' => $this->lang->line("a1146"),
                'delete' => $this->lang->line("a1147")
            ],
            'platform_follow_ups' => [
                "show" => $this->lang->line("a1148"),
            ],
            'deleted_items' => [
                "show" => $this->lang->line("a1149"),
                'data_recovery' => $this->lang->line("a1150")
            ],
            'parents_permission' => [
                "show" => $this->lang->line("a1151"),
            ],
            'notifications' => [
                "show" => $this->lang->line("a1152"),
                'add' => $this->lang->line("a1153"),
                'edit' => $this->lang->line("a1154"),
                'delete' => $this->lang->line("a1155"),
                'notifications_mobile' => $this->lang->line("a1179")
            ],
            'he_has_supervision_over' => [
                "teachers" => $this->lang->line("a1156"),
                'specialist' => $this->lang->line("a1157"),
            ],
            'metrics' => [
                "show" => $this->lang->line("a1158"),
                'add' => $this->lang->line("a1159"),
                'edit' => $this->lang->line("a1160"),
                'delete' => $this->lang->line("a1161"),
                'print' => $this->lang->line("a1162")
            ],
            'manage_subsections' => [
                "show" => $this->lang->line("a1163"),
                "add" => $this->lang->line("a1164"),
                "edit" => $this->lang->line("a1165"),
                "delete" => $this->lang->line("a1166"),
            ],
            'forms_and_reports' => [
                "show" => $this->lang->line("a1167"),
                "add" => $this->lang->line("a1168"),
                "edit" => $this->lang->line("a1169"),
                "delete" => $this->lang->line("a1170"),
                "management" => $this->lang->line("a1171"),
            ],
            'behavior_modification' => [
                "show" => $this->lang->line("a1172"),
                'add' => $this->lang->line("a1173"),
                'print' => $this->lang->line("a1174"),
                'delete' => $this->lang->line("a1175"),
            ],
            'nutrition' => [
                "show" => $this->lang->line("a1176"),
                'add' => $this->lang->line("a1177"),
                'print' => $this->lang->line("a1178"),
                'delete' => $this->lang->line("a1179"),
            ],
                //behavior_modification
                //nutrition
        ];
    }

    function description_permissions() {
        $permissions = $this->default_permissions();
        $json_permissions = [];
        foreach ($permissions as $key => $permission) {
            $json_permissions[] = json_encode($permission);
        }
        return $json_permissions;
    }

    function type_permissions() {
        return array_keys($this->default_permissions());
    }

    function set_user_permissions($employee_id = '') {
        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();

        foreach ($type_permissions as $index => $type) {
            $data = [
                'employee_id' => $employee_id,
                'type' => $type,
                'description' => $description_permissions[$index],
            ];

            $checker_employee_permissions = $this->db->get_where('user_permissions', [
                'employee_id' => $employee_id,
                'type' => $type,
            ]);

            if ($checker_employee_permissions->num_rows() == 0) {
                $this->db->insert('user_permissions', $data);
            }
        }
    }

    function get_raw_permissions() {
        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();
        $results = [];
        foreach ($type_permissions as $index => $type) {
            $results[] = [
                'type' => $type,
                'description' => $description_permissions[$index],
            ];
        }
        return $results;
    }

    function get_user_permissions($employee_id) {
        $type_permissions = $this->type_permissions();
        $description_permissions = $this->description_permissions();
        return array_combine($type_permissions, $description_permissions);
    }
}
