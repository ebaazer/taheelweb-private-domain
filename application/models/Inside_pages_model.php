<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Inside_pages_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    ////////Employee//////////

    function load_question_type($type, $online_exam_id) {
        $page_data['question_type'] = $type;
        $page_data['online_exam_id'] = $online_exam_id;
        $this->load->view('backend/technical_support/online_exam_add_'.$type, $page_data);
    } 
    
    
    

}
