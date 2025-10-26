<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_for_tags_question extends CI_Controller {

    public function index() {
        
    }

    public function Sitemap_tags_question() {
        $data['all_data_tags_question'] = $this->crud_tags_question->get_data();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_tags_question_001", $data);
    }

}
