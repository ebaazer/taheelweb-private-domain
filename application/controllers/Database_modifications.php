<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 
 *      Date created    : 15/07/2021 *        
 *      Database modifications
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Database_modifications extends CI_Controller {

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
        $alphanumeric = bin2hex(random_bytes(24));
        return $alphanumeric;
    }

    function generate_password() {
        $alphanumeric = bin2hex(random_bytes(3));
        return $alphanumeric;
    }

    //
    //تغير كلمات جميع من في المنصة
    function pass_for_all() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("parent a");
        $parent = $this->db->get()->result_array();

        foreach ($parent as $parent_row) {

            $password = $this->generate_password();

            $data_parent['password'] = sha1($password);
            $data_parent['key_pass'] = $password;

            $this->db->where('parent_id', $parent_row['parent_id']);
            $this->db->update('parent', $data_parent);
        }


        $this->db->select("a.*");
        $this->db->from("employee a");
        $employee = $this->db->get()->result_array();

        foreach ($employee as $employee_row) {

            $password = $this->generate_password();

            $data_employee['password'] = sha1($password);
            $data_employee['key_pass'] = $password;

            $this->db->where('employee_id', $employee_row['employee_id']);
            $this->db->update('employee', $data_employee);
        }


        echo 'done';
    }
}
