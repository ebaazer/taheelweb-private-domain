<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 15/06/2021
 *        
 *      MANAGE AuthApi
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Auth extends CI_Controller {

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

    function filterRequest($requestname = "") {
        return htmlspecialchars(strip_tags($_POST[$requestname]));
    }

    function send_mail($to = "", $title = "", $body = "") {
        //$to = "ebaa.zer@gmail.com";
        //$title = "مرحبا في تاهيل ويب";
        //$body = "تم انشاء حسابك في تاهيل ويب";

        $headers = "From: info@taheelweb.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to, $title, $body, $headers);
    }

    function api_submit_registration() {

        $errors = [];
        $data = [];

        // $this->filterRequest("user_name");

        $data_registration_1['name'] = $this->filterRequest("username");
        $data_registration_1['capacity'] = 3;
        $data_registration_1['start_working_hours'] = '09:00';
        $data_registration_1['end_working_hours'] = '20:00';
        $data_registration_1['encrypt_thread'] = bin2hex(random_bytes(32));
        $data_registration_1['date_added'] = date("Y-m-d H:i:s");

        $this->db->insert('class', $data_registration_1);
        $class_id = $this->db->insert_id();

        $data_registration_2['name'] = $this->filterRequest("username");
        $data_registration_2['employee_code'] = bin2hex(random_bytes(25));
        $data_registration_2['job_title_id'] = 31;
        $data_registration_2['phone'] = $this->filterRequest("phone");
        $data_registration_2['email'] = $this->filterRequest("email");
        $data_registration_2['password'] = sha1($_POST['password']);
        $data_registration_2['date_added'] = date("Y-m-d H:i:s");
        $data_registration_2['encrypt_thread'] = bin2hex(random_bytes(32));
        $data_registration_2['key_pass'] = $_POST['password'];
        $data_registration_2['verifycode'] = rand(10000, 99999);

        $this->db->insert('employee', $data_registration_2);
        $employee_id = $this->db->insert_id();

        $data_registration_3['class_id'] = $class_id;
        $data_registration_3['employee_id'] = $employee_id;
        $data_registration_3['date'] = date("Y-m-d H:i:s");

        $this->db->insert('employee_classes', $data_registration_3);

        $to = $data_registration_2['email'];
        $title = "كود التحقق من تاهيل تاهيل ويب";
        $title_in_email = "لاكمال عملية التسجيل يرجى ادخال الكود الخاص بك";
        $body = $this->temp_mail_verifycode($data_registration_2['verifycode'], $title_in_email);

        $this->send_mail($to, $title, $body);

        header('Content-Type: application/json');
        echo json_encode(array("status" => "success", "data" => $data));
    }

    function temp_mail_verifycode($verifycode = "", $title_in_email = "") {

        $htmlContent = "MIME-Version: 1.0\r\n";
        $htmlContent .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $htmlContent .= '
        <!DOCTYPE html><html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
        <head><title></title><meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <style>* {box-sizing: border-box;}body {margin: 0;padding: 0;}a[x-apple-data-detectors] {color: inherit !important;text-decoration: inherit !important;}
        #MessageViewBody a {color: inherit;text-decoration: none;}p {line-height: inherit}.desktop_hide,.desktop_hide table {mso-hide: all;display: none;max-height: 0px;overflow: hidden;}
        .image_block img+div {display: none;}@media (max-width:520px) {.desktop_hide table.icons-inner,.social_block.desktop_hide .social-table {display: inline-block !important;}
        .icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}.row-content {width: 100% !important;}.mobile_hide {display: none;}.stack .column {width: 100%;display: block;}.mobile_hide {min-height: 0;max-height: 0;max-width: 0;overflow: hidden;font-size: 0px;}
        .desktop_hide,.desktop_hide table {display: table !important;max-height: none !important;}}</style></head><body style="background-color: #ffffff; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
        <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
        <tbody><tr><td><table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f5f5f5;" width="100%"><tbody>
        <tr><td><table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;"
        width="500"><tbody><tr><td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
        width="100%"><table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"logo
        width="100%"><tr><td class="pad" style="padding-bottom:10px;width:100%;padding-right:0px;padding-left:0px;"><div align="center" class="alignment" style="line-height:10px"><img alt="your-" src="' . base_url() . 'assets/verifycode_temp/images/____.png" style="display: block; height: auto; border: 0; width: 125px; max-width: 100%;"
        title="your-logo" width="125" /></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f5f5f5;" width="100%"><tbody><tr><td><table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 500px;" width="500"><tbody><tr><td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 20px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr><td class="pad" style="text-align:center;width:100%;"><h1 style="margin: 0; color: #393d47; direction: ltr; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;">
        <strong><span class="tinyMce-placeholder">كود التحقق الخاص بك</span></strong></h1></td></tr></table><table border="0" cellpadding="10" cellspacing="0" class="text_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
        <tr><td class="pad"><div style="font-family: Tahoma, Verdana, sans-serif"><div class="" style="font-size: 12px; font-family: Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 18px; color: #393d47; line-height: 1.5;">
        <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 21px;">' . $title_in_email . '</p></div></div></td></tr></table>
        <table border="0" cellpadding="15" cellspacing="0" class="button_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr><td class="pad"><div align="center" class="alignment"><span style="text-decoration:none;display:inline-block;color:#393d47;background-color:#ffc727;border-radius:20px;width:auto;border-top:1px solid #FFC727;font-weight:undefined;border-right:1px solid #FFC727;border-bottom:1px solid #FFC727;border-left:1px solid #FFC727;padding-top:10px;padding-bottom:10px;font-family:Tahoma, Verdana, Segoe, sans-serif;font-size:18px;text-align:center;mso-border-alt:none;word-break:keep-all;"
        target="_blank"><span style="padding-left:50px;padding-right:50px;font-size:18px;display:inline-block;letter-spacing:normal;"><span dir="ltr" style="word-break: break-word; line-height: 36px;">' . $verifycode . '</span></span></span>
        </div></td></tr></table><table border="0" cellpadding="0" cellspacing="0" class="text_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
        <tr><td class="pad" style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:10px;"><div style="font-family: Tahoma, Verdana, sans-serif">
        <div class="" style="font-size: 12px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-line-height-alt: 18px; color: #393d47; line-height: 1.5;">
        <p style="margin: 0; mso-line-height-alt: 19.5px;"><span style="font-size:13px;">شكرا لك</span></p></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f5f5f5;" width="100%"><tbody><tr><td><table align="center" border="0" cellpadding="0" cellspacing="0"
        class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
        <tbody><tr><td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
        <table border="0" cellpadding="15" cellspacing="0" class="text_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"width="100%"><tr><td class="pad">
        <div style="font-family: Tahoma, Verdana, sans-serif"><div class="" style="font-size: 12px; font-family: Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 14.399999999999999px; color: #393d47; line-height: 1.2;">
        <p style="margin: 0; font-size: 14px; text-align: center; mso-line-height-alt: 16.8px;"><span style="font-size:10px;">This link will expire in 24 hours. If you continue to have problems</span><br /><span style="font-size:10px;">please feel free to contact us at <a
        href="mailto:support@taheelweb.com" rel="noopener" style="text-decoration: underline; color: #393d47;" target="_blank" title="support@youremail.com">support@youremail.com</a>.
        <a href="Example.com" rel="noopener" style="text-decoration: underline; color: #393d47;" target="_blank">UNSUBSCRIBE</a></span></p></div></div></td></tr></table></td></tr>
        </tbody></table></td></tr></tbody></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #fff;" width="100%"><tbody><tr><td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;"
        width="500"><tbody><tr><td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
        width="100%"><table border="0" cellpadding="0" cellspacing="0" class="html_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr><td class="pad"><div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;"><div style="height:30px;"></div>
        </div></td></tr></table><table border="0" cellpadding="0" cellspacing="0" class="social_block block-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
        <tr><td class="pad" style="text-align:center;padding-right:0px;padding-left:0px;"><div align="center" class="alignment"><table border="0" cellpadding="0" cellspacing="0"
        class="social-table" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block;" width="252px"><tr>
        <td style="padding:0 5px 0 5px;"><a href="https://www.facebook.com/taheelweb2011" target="_blank"><img alt="Facebook" height="32" src="' . base_url() . 'assets/verifycode_temp/images/facebook2x.png" style="display: block; height: auto; border: 0;"title="Facebook"width="32" /></a></td>
        <td style="padding:0 5px 0 5px;"><a href="https://twitter.com/taheelweb" target="_blank"><img alt="Twitter" height="32" src="' . base_url() . 'assets/verifycode_temp/images/twitter2x.png" style="display: block; height: auto; border: 0;" title="Twitter" width="32" /></a></td>
        <td style="padding:0 5px 0 5px;"><a href="https://instagram.com/taheelweb" target="_blank"><img alt="Instagram" height="32" src="' . base_url() . 'assets/verifycode_temp/images/instagram2x.png" style="display: block; height: auto; border: 0;" title="Instagram" width="32" /></a></td>
        <td style="padding:0 5px 0 5px;"><a href="https://www.linkedin.com/taheelweb" target="_blank"><img alt="LinkedIn" height="32" src="' . base_url() . 'assets/verifycode_temp/images/linkedin2x.png" style="display: block; height: auto; border: 0;" title="LinkedIn" width="32" /></a></td>
        <td style="padding:0 5px 0 5px;"><a href="https://www.youtube.com/taheelweb"target="_blank"><img alt="YouTube" height="32" src="' . base_url() . 'assets/verifycode_temp/images/youtube2x.png" style="display: block; height: auto; border: 0;" title="YouTube" width="32" /></a></td>
        <td style="padding:0 5px 0 5px;"><a href="https://www.taheelweb.com/" target="_blank"><img alt="Web Site" height="32" src="' . base_url() . 'assets/verifycode_temp/images/website2x.png" style="display: block; height: auto; border: 0;" title="Web Site" width="32" /></a></td></tr></table></div></td></tr></table>
        <table border="0" cellpadding="0" cellspacing="0" class="html_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%"><tr>
        <td class="pad"><div align="center" style="font-family:Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;"><div style="margin-top: 25px;border-top:1px dashed #D6D6D6;margin-bottom: 20px;"></div></div></td></tr></table><table border="0" cellpadding="10" cellspacing="0"
        class="text_block block-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%"><tr><td class="pad"><div style="font-family: Tahoma, Verdana, sans-serif"><div class="" style="font-size: 12px; font-family: Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-line-height-alt: 14.399999999999999px; color: #C0C0C0; line-height: 1.2;">
        <p style="margin: 0; text-align: center; mso-line-height-alt: 14.399999999999999px;">لقد تلقيت هذا البريد الإلكتروني لأننا تلقينا
        طلبًا بشأن تفعيل حسابك في تاهيل ويب. إذا لم
        تطلب التسجيل في تاهيل ويب يمكنك حذف هذا
        البريد الإلكتروني بأمان.</p><p style="margin: 0; text-align: center; mso-line-height-alt: 14.399999999999999px;">
         </p>Amman – Shmesani – Queen Noor street, Amman,Jordan<br /><p style="margin: 0; font-size: 12px; text-align: center; mso-line-height-alt: 14.399999999999999px;">
        <span style="color:#c0c0c0;"> </span></p></div></div></td></tr></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></body></html>';

        return $htmlContent;
    }

    function api_check_verfiycode_signup() {
        $data_f = array();
        $email = $this->filterRequest("email");
        $verfiy = $this->filterRequest("verifycode");

        $this->db->where('email', $email);
        $this->db->where('verifycode', $verfiy);
        $count = $this->db->get('employee')->num_rows();

        if ($count > 0) {

            $data['verifycode_status'] = '1';

            $this->db->where('email', $email);
            $this->db->where('verifycode', $verfiy);
            $this->db->update('employee', $data);

            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data_f));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("status" => "failure", "data" => $data_f));
        }
    }

    function api_validate_login() {

        $website_status = $this->db->get_where('settings', array('type' => 'website_status'))->row()->description;

        $email = $this->filterRequest("email");
        $password = $_POST['password'];
        $is_employee_code = false;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $credential = array('email' => $email, 'password' => sha1($password));
        } else {
            if (strlen($email) == 4) {
                $is_employee_code = true;
                $credential = array('employee_code' => $email, 'password' => sha1($password));
            } else {
                $zero_phone = substr($email, 0, 1);
                if ($zero_phone == 0) {
                    $email_2 = $email;
                    $email = substr($email_2, 1);
                } elseif ($zero_phone != 0) {
                    $email = $email;
                }
                $credential = array('phone' => $email, 'password' => sha1($password));
            }
        }

        if ($is_employee_code) {

            $is_employee = $this->db->get_where('employee', $credential);
            // Checking login credential for employee
            if ($is_employee->num_rows() > 0) {

                $row = $is_employee->row();

                //دخول الموظفين
                //if ($row->job_title_id == 2) {

                $prefix_status = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;

                if ($row->job_title_id == 28) {
                    $job_title_id = 4;
                    $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;
                } else {
                    $job_title_id = $row->job_title_id;
                    $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;
                }

                if ($prefix_status == '_rc') {
                    if ($row->job_title_id == 14 || $row->job_title_id == 15) {
                        $job_title_id = 3;
                    }
                }

                if ($row->job_title_id == 31) {
                    $teacher_alone = 1;
                } else {
                    $teacher_alone = 0;
                }

                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

                if ($c_name == 'taheelweb') {
                    $c_name_s = 'taheelweb';
                } else {
                    $c_name_s = 'undefined';
                }

                $num_classes = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->num_rows();
                if ($num_classes > 1) {
                    $this->session->set_userdata('class_id', 0);
                } else {
                    $class_id = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->row()->class_id;
                    $this->session->set_userdata('class_id', $class_id);
                }

                $data1['last_login'] = date("Y-m-d H:i:s");
                $data1['online'] = 1;
                $this->db->where('employee_id', $row->employee_id);
                $this->db->update('employee', $data1);

                $results = array(
                    'status' => 'success',
                    'user_login' => '1',
                    'employee_login' => '1',
                    'parent_login' => '0',
                    'admin_login' => '0',
                    'technical_support_login' => '0',
                    'employee_id' => $row->employee_id,
                    'login_user_id' => $row->employee_id,
                    'name' => $row->name,
                    'user_img' => $row->user_img,
                    'gender' => $row->gender,
                    'job_title_id' => $job_title_id,
                    'login_type' => 'employee',
                    'language' => $row->lang,
                    'site_lang' => $row->lang,
                    'last_login' => $row->last_login,
                    'job_title_name' => $job_title_name,
                    'center_type' => $this->db->get_where('settings', array('type' => 'center_type'))->row()->description,
                    'c_name' => $c_name_s,
                    'online' => '1',
                    'teacher_alone' => $teacher_alone,
                    'level' => $row->level,
                    'encrypt_thread' => $row->encrypt_thread,
                    'status_login' => $row->status_login,
                    'website_status' => $website_status,
                );

                $data3['user_used'] = $email;
                $data3['employee_id'] = $row->employee_id;
                $data3['class_id'] = null;
                $data3['job_title_id'] = $job_title_id;
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $data3['status'] = 1;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "success", "data" => $results));
            }
        } elseif (!$is_employee_code) {

            $is_employee = $this->db->get_where('employee', $credential);
            $is_technical_support = $this->db->get_where('technical_support', $credential);
            $is_admin = $this->db->get_where('admin', $credential);
            $is_parent = $this->db->get_where('parent', $credential);

            if ($is_employee->num_rows() > 0) {

                // Checking login credential for employee


                $row = $is_employee->row();

                //دخول الموظفين
                //if ($row->job_title_id == 2) {

                $prefix_status = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;

                if ($row->job_title_id == 28) {
                    $job_title_id = 4;
                    $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;
                } else {
                    $job_title_id = $row->job_title_id;
                    $job_title_name = $this->db->get_where('job_title', array('job_title_id' => $this->session->userdata('job_title_id')))->row()->name;
                }

                if ($prefix_status == '_rc') {
                    if ($row->job_title_id == 14 || $row->job_title_id == 15) {
                        $job_title_id = 3;
                    }
                }

                if ($row->job_title_id == 31) {
                    $teacher_alone = 1;
                } else {
                    $teacher_alone = 0;
                }

                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

                if ($c_name == 'taheelweb') {
                    $c_name_s = 'taheelweb';
                } else {
                    $c_name_s = 'undefined';
                }

                $num_classes = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->num_rows();
                if ($num_classes > 1) {
                    $this->session->set_userdata('class_id', 0);
                } else {
                    $class_id = $this->db->get_where('employee_classes', array('employee_id' => $row->employee_id, 'active' => 1))->row()->class_id;
                    $this->session->set_userdata('class_id', $class_id);
                }

                $data1['last_login'] = date("Y-m-d H:i:s");
                $data1['online'] = 1;
                $this->db->where('employee_id', $row->employee_id);
                $this->db->update('employee', $data1);

                $results = array(
                    'status' => 'success',
                    'user_login' => '1',
                    'employee_login' => '1',
                    'parent_login' => '0',
                    'admin_login' => '0',
                    'technical_support_login' => '0',
                    'employee_id' => $row->employee_id,
                    'login_user_id' => $row->employee_id,
                    'name' => $row->name,
                    'user_img' => $row->user_img,
                    'gender' => $row->gender,
                    'job_title_id' => $job_title_id,
                    'login_type' => 'employee',
                    'language' => $row->lang,
                    'site_lang' => $row->lang,
                    'last_login' => $row->last_login,
                    'job_title_name' => $job_title_name,
                    'center_type' => $this->db->get_where('settings', array('type' => 'center_type'))->row()->description,
                    'c_name' => $c_name_s,
                    'online' => '1',
                    'teacher_alone' => $teacher_alone,
                    'level' => $row->level,
                    'encrypt_thread' => $row->encrypt_thread,
                    'status_login' => $row->status_login,
                    'website_status' => $website_status,
                    'email' => $row->email,
                    'phone' => $row->phone,
                );

                $data3['user_used'] = $email;
                $data3['employee_id'] = $row->employee_id;
                $data3['class_id'] = null;
                $data3['job_title_id'] = $job_title_id;
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $data3['status'] = 1;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "success", "data" => $results));
            }


            // Checking login credential for technical_support
            elseif ($is_technical_support->num_rows() > 0) {


                $row = $is_technical_support->row();

                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

                if ($c_name == 'taheelweb') {
                    $c_name_s = 'taheelweb';
                } else {
                    $c_name_s = 'undefined';
                }

                $data1['last_login'] = strtotime(date("Y-m-d H:i:s"));
                $data1['online'] = 1;
                $this->db->where('technical_support_id', $row->technical_support_id);
                $this->db->update('technical_support', $data1);

                $data3['user_used'] = $email;
                $data3['employee_id'] = $row->technical_support_id;
                $data3['class_id'] = 0;
                $data3['job_title_id'] = 0;
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $data3['status'] = 1;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                $results = array(
                    'status' => 'success',
                    'user_login' => '1',
                    'parent_login' => '0',
                    'admin_login' => '0',
                    'technical_support_login' => '1',
                    'employee_login' => '0',
                    'technical_support_id' => $row->technical_support_id,
                    'login_user_id' => $row->technical_support_id,
                    'name' => $row->name,
                    'job_title_id' => '1',
                    'login_type' => 'technical_support',
                    'language' => $row->lang,
                    'site_lang' => $row->lang,
                    'last_login' => $row->last_login,
                    'panel_superuser' => '1',
                    'job_title_name' => 'technical_support',
                    'center_type' => $this->db->get_where('settings', array('type' => 'center_type'))->row()->description,
                    'c_name' => $c_name_s,
                    'online' => '1'
                );

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "success", "data" => $results));
            }

            // Checking login credential for admin
            elseif ($is_admin->num_rows() > 0) {

                $row = $is_admin->row();

                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

                if ($c_name == 'taheelweb') {
                    $c_name_s = 'taheelweb';
                } else {
                    $c_name_s = 'undefined';
                }

                $data1['last_login'] = strtotime(date("Y-m-d H:i:s"));
                $data1['online'] = 1;

                $this->db->where('admin_id', $row->admin_id);
                $this->db->update('admin', $data1);

                $data3['user_used'] = $email;
                $data3['employee_id'] = $row->admin_id;
                $data3['class_id'] = 0;
                $data3['job_title_id'] = 1;
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $data3['status'] = 1;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                $results = array(
                    'status' => 'success',
                    'user_login' => '1',
                    'parent_login' => '0',
                    'admin_login' => '1',
                    'technical_support_login' => '0',
                    'employee_login' => '0',
                    'admin_id' => $row->admin_id,
                    'login_user_id' => $row->admin_id,
                    'name' => $row->name,
                    'job_title_id' => '1',
                    'login_type' => 'admin',
                    'language' => $row->lang,
                    'site_lang' => $row->lang,
                    'last_login' => $row->last_login,
                    'job_title_name' => 'public_management',
                    'center_type' => $this->db->get_where('settings', array('type' => 'center_type'))->row()->description,
                    'c_name' => $c_name_s,
                    'online' => '1'
                );

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "success", "data" => $results));
            }

            // دخول أولياءالأمور
            elseif ($is_parent->num_rows() > 0) {

                $row = $is_parent->row();

                $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;

                if ($c_name == 'taheelweb') {
                    $c_name_s = 'taheelweb';
                } else {
                    $c_name_s = 'undefined';
                }

                $data1['last_login'] = strtotime(date("Y-m-d H:i:s"));
                $data1['online'] = 1;
                $this->db->where('parent_id', $row->parent_id);
                $this->db->update('parent', $data1);

                $data3['user_used'] = $email;
                $data3['employee_id'] = $row->parent_id;
                $data3['class_id'] = 100;
                $data3['job_title_id'] = 100;
                $data3['date'] = date("Y-m-d H:i:s");
                $data3['status'] = 1;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                $results = array(
                    'status' => 'success',
                    'user_login' => '1',
                    'parent_login' => '1',
                    'admin_login' => '0',
                    'technical_support_login' => '0',
                    'employee_login' => '0',
                    'parent_id' => $row->parent_id,
                    'login_user_id' => $row->parent_id,
                    'name' => $row->name,
                    'job_title_id' => '100',
                    'login_type' => 'parent',
                    'language' => $row->lang,
                    'site_lang' => $row->lang,
                    'last_login' => $row->last_login,
                    'job_title_name' => 'parent',
                    'center_type' => $this->db->get_where('settings', array('type' => 'center_type'))->row()->description,
                    'c_name' => $c_name_s,
                    'online' => '1',
                    'encrypt_thread' => $row->encrypt_thread,
                    'status_login' => $row->status_login,
                    'website_status' => $website_status,
                );

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "success", "data" => $results));
            } else {
                $data3['user_used'] = $email;
                $data3['employee_id'] = -1;
                $data3['class_id'] = -1;
                $data3['job_title_id'] = -1;
                $data3['date'] = strtotime(date("Y-m-d H:i:s"));
                $data3['status'] = 2;
                $data3['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $data3['remote_addr'] = $this->input->ip_address();
                $this->db->insert('record_logins', $data3);

                $results = array(
                    'status' => 'failure',
                );

                header('Content-Type: application/json');
                //echo json_encode($results, JSON_UNESCAPED_UNICODE);
                echo json_encode(array("status" => "failure"));
            }
        }
    }

    function api_checkemail() {

        $email = $this->filterRequest("email");

        if (!empty($email)) {

            $title_in_email = "لاكمال عملية تغير كلمة المرور يرجى ادخال كود التحقق";

            $credential = array('email' => $email);

            $is_technical_support = $this->db->get_where('technical_support', $credential);
            $is_admin = $this->db->get_where('admin', $credential);
            $is_parent = $this->db->get_where('parent', $credential);
            $is_employee = $this->db->get_where('employee', $credential);

            if ($is_technical_support->num_rows() > 0) {
                $row = $is_technical_support->row();

                $data['verifycode'] = rand(10000, 99999);
                $this->db->where('technical_support_id', $row->technical_support_id);
                $this->db->update('technical_support', $data);

                $to = $email;
                $title = "كود التحقق من تاهيل تاهيل ويب";
                $body = $this->temp_mail_verifycode($data['verifycode'], $title_in_email);

                $this->send_mail($to, $title, $body);

                $results = array(
                    'status' => 'success',
                );
            } elseif ($is_admin->num_rows() > 0) {
                $row = $is_admin->row();

                $data['verifycode'] = rand(10000, 99999);
                $this->db->where('admin_id', $row->admin_id);
                $this->db->update('admin', $data);

                $to = $email;
                $title = "كود التحقق من تاهيل تاهيل ويب";
                $body = $this->temp_mail_verifycode($data['verifycode'], $title_in_email);

                $this->send_mail($to, $title, $body);

                $results = array(
                    'status' => 'success',
                );
            } elseif ($is_parent->num_rows() > 0) {
                $row = $is_parent->row();

                $data['verifycode'] = rand(10000, 99999);
                $this->db->where('parent_id', $row->parent_id);
                $this->db->update('parent', $data);

                $to = $email;
                $title = "كود التحقق من تاهيل تاهيل ويب";
                $body = $this->temp_mail_verifycode($data['verifycode'], $title_in_email);

                $this->send_mail($to, $title, $body);

                $results = array(
                    'status' => 'success',
                );
            } elseif ($is_employee->num_rows() > 0) {
                $row = $is_employee->row();

                $data['verifycode'] = rand(10000, 99999);
                $this->db->where('employee_id', $row->employee_id);
                $this->db->update('employee', $data);

                $to = $email;
                $title = "كود التحقق من تاهيل تاهيل ويب";
                $body = $this->temp_mail_verifycode($data['verifycode'], $title_in_email);

                $this->send_mail($to, $title, $body);

                $results = array(
                    'status' => 'success',
                );
            } else {
                $results = array(
                    'status' => 'failure',
                );
            }
        } else {
            $results = array(
                'status' => 'failure mail empty ' . $email,
            );
        }

        header('Content-Type: application/json');
        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function api_check_verfiycode_forgetpassword() {
        $data = array();
        $email = $this->filterRequest("email");
        $verfiy = $this->filterRequest("verifycode");

        $this->db->where('email', $email);
        $this->db->where('verifycode', $verfiy);
        $count = $this->db->get('employee')->num_rows();

        if ($count > 0) {
            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("status" => "failure", "data" => $data));
        }
    }

    function api_resetpassword() {
        $data = array();
        $email = $this->filterRequest("email");

        $credential = array('email' => $email);

        $is_technical_support = $this->db->get_where('technical_support', $credential);
        $is_admin = $this->db->get_where('admin', $credential);
        $is_parent = $this->db->get_where('parent', $credential);
        $is_employee = $this->db->get_where('employee', $credential);

        if ($is_technical_support->num_rows() > 0) {
            $row = $is_technical_support->row();

            $data['password'] = sha1($_POST['password']);
            $data['key_pass'] = $_POST['password'];
            $this->db->where('technical_support_id', $row->technical_support_id);
            $this->db->update('technical_support', $data);

            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data));
        } elseif ($is_admin->num_rows() > 0) {
            $row = $is_admin->row();

            $data['password'] = sha1($_POST['password']);
            $data['key_pass'] = $_POST['password'];
            $this->db->where('admin_id', $row->admin_id);
            $this->db->update('admin', $data);

            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data));
        } elseif ($is_parent->num_rows() > 0) {
            $row = $is_parent->row();

            $data['password'] = sha1($_POST['password']);
            $data['key_pass'] = $_POST['password'];
            $this->db->where('parent_id', $row->parent_id);
            $this->db->update('parent', $data);

            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data));
        } elseif ($is_employee->num_rows() > 0) {
            $row = $is_employee->row();

            $data['password'] = sha1($_POST['password']);
            $data['key_pass'] = $_POST['password'];
            $this->db->where('employee_id', $row->employee_id);
            $this->db->update('employee', $data);

            header('Content-Type: application/json');
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("status" => "failure", "data" => $data));
        }
    }
}
