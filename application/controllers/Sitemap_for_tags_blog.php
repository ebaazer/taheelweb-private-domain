<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sitemap_for_tags_blog extends CI_Controller
{

    public function index()
    {
    }

    public function Sitemap_tags_blog()
    {
        $data['all_tags_blog'] = $this->crud_tags_blog->get_data();
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap/sitemap_tags_blog_001", $data);
    }
}