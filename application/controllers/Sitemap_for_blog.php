<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_for_blog extends CI_Controller {

    public function index() {
        
    }

    public function sitemap_blog() {
        $data['all_data_blog'] = $this->crud_blog->get_data();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_blog_001", $data);
    }

}
