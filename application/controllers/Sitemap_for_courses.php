<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_for_courses extends CI_Controller {

    public function index() {
        
    }

    public function sitemap_courses() {
        $data['all_data_courses'] = $this->crud_courses->get_data();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_courses_001", $data);
    }

}
