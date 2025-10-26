<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright           Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
if (!function_exists('is_allowed')) {

    function is_allowed($type, $permission_name) {


        $CI = & get_instance();
        $CI->load->database();
        //$current_language	=	$CI->db->get_where('settings' , array('type' => 'language'))->row()->description;
        $account_type = $CI->session->userdata('login_type');
        //echo 'login type: ' . $account_type . '<br/>';
        if($account_type == 'technical_support') {
            return true;
        }

        if($account_type == 'admin') {
            return true;
        }        

        $employee_id = $CI->session->userdata('employee_id');
        $job_title_id = $CI->session->userdata('job_title_id');
        //echo 'job_title_id type: ' . $job_title_id . '<br/>';
        //echo 'employee_id : ' . $employee_id . '<br/>';

        if(!$CI->session->userdata('role_permissions')) {
            $CI->db->select("type, description");
            $CI->db->from("role_permissions");
            $CI->db->where('job_title_id', $job_title_id);
            $CI->db->where('type', $type);
            $roles = $CI->db->get()->result_array();
            $role = $roles[0];
            //$type  = $role['type'];
            $permissions = json_decode($role['description'], TRUE);
            if($permissions[$permission_name] == 1) {
                return true;
            } 
       }

        if(!$CI->session->userdata('user_permissions')) {
            $CI->db->select("type, description");
            $CI->db->from("user_permissions");
            $CI->db->where('employee_id', $employee_id);
            $CI->db->where('type', $type);
            $users = $CI->db->get()->result_array();
            //echo sizeof($users) . '<br/>';
            $user = $users[0];
            //$type  = $user['type'];
            $permissions = json_decode($user['description'], TRUE);
            //echo $role['type'] . ' -> ' . $role['description'] . '<br/>';
            //echo $permission_name . ' -> ' . $permissions[$permission_name] . '<br/>';
            if($permissions[$permission_name] == 1) {
                //echo $permission_name . ' allowed<br/>';
                return true;
            } 
        }        

        return false;
    }

}

// ------------------------------------------------------------------------
/* End of file permission_helper.php */
/* Location: ./system/helpers/permission_helper.php */