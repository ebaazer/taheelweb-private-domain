<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 09/03/2021        
 *      MANAGE Error Page
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Error_page extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('language');
        date_default_timezone_set('Asia/Riyadh');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");

        /* language control */
        $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
        $site_lang = $this->session->userdata('site_lang');

        include 'inc_language.php';
    }

    //Default function, redirects to logged in user area
    public function index() {
        $this->load->view('backend/error');
    }
}
