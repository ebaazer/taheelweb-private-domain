<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_for_question extends CI_Controller {

    public function index() {
        
    }

    public function sitemap_question() {
        $data['all_data_question'] = $this->crud_question->get_data();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_question_001", $data);
    }

}
