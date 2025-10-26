<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	    @author 	: taheelweb
 * 
 *      Date created    : 01/03/2021        
 *      MANAGE Multi Language Switcher
 * 	
 * 	    http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class MultiLanguageSwitcher extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

    // create language Switcher method
    public function switcher($language = "") {

        $language = ($language != "") ? $language : "english";

        $data['lang'] = $language;
        $login_type = $this->session->userdata('login_type');
        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', $data);

        $this->session->set_userdata('site_lang', $language);
        $this->session->set_flashdata('flash_message', $this->lang->line('change_language'));
        redirect($_SERVER['HTTP_REFERER']);
    }

}