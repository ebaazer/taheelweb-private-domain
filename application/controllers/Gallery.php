<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 02/06/2022
 *      Gallery Controll
 * 
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Gallery extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->output->enable_profiler($this->config->item('profiler'));

        log_message('debug', 'CI : MY_Controller class loaded');

        $this->load->database();
        $this->load->library('session');
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
        //$alphanumeric = md5(time());
        //$alphanumeric = bin2hex(random_bytes(20));
        //$alphanumeric = sha1(time());
        //$alphanumeric = md5(date("Y-m-d H:i:s"));
        $alphanumeric = bin2hex(random_bytes(24));
        return $alphanumeric;
    }

    function get_data_gallery() {
        $this->if_user_login();
        $this->db->select("a.*");
        $this->db->from("frontend_gallery a");
        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where('active', 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function gallery() {
        $this->if_user_login();

        $page_data['page_name'] = 'frontend_gallery';
        $page_data['page_title'] = $this->lang->line('gallery');
        $this->load->view('backend/index', $page_data);
    }

    function gallery_add($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        $page_data['page_name'] = 'gallery_add';
        $page_data['page_title'] = $this->lang->line('gallery_add');
        $this->load->view('backend/index', $page_data);
    }

    function gallery_image($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        $page_data['page_name'] = 'gallery_image';
        $page_data['page_title'] = $this->lang->line('gallery_add');
        $page_data['gallery_id'] = $param1;
        $this->load->view('backend/index', $page_data);
    }

    function gallery_add_new($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $tags_array = array();
        //$tags = explode(",", $this->input->post('tags_blog'));
        $tags = json_decode($this->input->post('tags_gallery'), true);

        if (is_array($tags)) {
            foreach ($tags as $row) {
                if (is_string($row)) {
                    array_push($tags_array, $row);
                } elseif (is_array($row)) {
                    foreach ($row as $sub_row) {
                        if (is_string($sub_row)) {
                            array_push($tags_array, $sub_row);
                        }
                    }
                }
            }
        }

        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('short_description');
        $data['show_on_website'] = $this->input->post('published');

        $data['tags_gallery'] = implode(",", $tags_array);

        $posted_user = $this->session->userdata('login_type');
        $posted_user_id = $this->session->userdata('login_user_id');
        $data['posted_by'] = $posted_user . '-' . $posted_user_id;

        $data['photo'] = $this->input->post('photo');
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['encrypt_thread'] = bin2hex(random_bytes(24));

        $this->db->insert('frontend_gallery', $data);

        $its_number = $this->db->insert_id();

        redirect(site_url('gallery/gallery/'), 'refresh');
    }

    function gallery_edit($param1 = '') {
        $this->if_user_login();

        $page_data['gallery_id'] = $param1;
        $page_data['page_name'] = 'gallery_edit';
        $page_data['page_title'] = $this->lang->line('blog_edit');
        //$page_data['blog'] = $this->frontend_model->get_blog_details_for_edit($param1);

        $this->load->view('backend/index', $page_data);
    }

    function gallery_edit_data($param1 = '') {
        $this->if_user_login();

        $tags_array = array();
        //$tags = explode(",", $this->input->post('tags_blog'));
        $tags = json_decode($this->input->post('tags_gallery'), true);

        if (is_array($tags)) {
            foreach ($tags as $row) {
                if (is_string($row)) {
                    array_push($tags_array, $row);
                } elseif (is_array($row)) {
                    foreach ($row as $sub_row) {
                        if (is_string($sub_row)) {
                            array_push($tags_array, $sub_row);
                        }
                    }
                }
            }
        }

        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');

        $data['tags_gallery'] = implode(",", $tags_array);

        if (!empty($this->input->post('photo'))) {
            $data['photo'] = $this->input->post('photo');
        }

        $this->db->where('frontend_gallery_id', $this->input->post('gallery_id'));
        $this->db->update('frontend_gallery', $data);

        redirect(site_url('gallery/gallery/'), 'refresh');
    }

    function gallery_delete($param1 = '') {
        $this->if_user_login();

        $data['active'] = 0;
        $data['published'] = 0;

        $this->db->where('frontend_gallery_id', $param1);
        $this->db->update('frontend_gallery', $data);

        //redirect(site_url('user/blog/'), 'refresh');
    }

    function add_new_img_gallery() {
        $this->if_user_login();
        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));
        //$folder = 'uploads/gallery_cover/';
        $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/gallery_cover/';

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $uname . '.' . $info->getExtension());
        $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
        $name = $uname . '.' . $info->getExtension();

        $results = array(
            'url' => $relative_path,
            'name' => $uname . '.' . $info->getExtension(),
            'fileName' => $_FILES['file']['name']
        );

        echo json_encode($results, JSON_UNESCAPED_UNICODE);
    }

    function api_gallery_upload($gallery_id = '') {
        $this->if_user_login();
        $countfiles = count($_FILES['userfile']['tmp_name']);

        // Looping all files
        $response = array();
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['userfile']['name'][$i];
            $info = new SplFileInfo($filename);
            $uname = bin2hex(random_bytes(24));
            //$folder = 'uploads/frontend/gallery_images/' . $gallery_id . '/';
            $folder = '/var/www/ft.taheelweb.com/uploads/' . $this->session->userdata('client_id') . '/gallery_images/' . $gallery_id . '/';

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            // Upload file
            move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $folder . $uname . '.' . $info->getExtension());
            $relative_path = base_url() . $folder . $uname . '.' . $info->getExtension();
            $name = $uname . '.' . $info->getExtension();
            array_push($response, array(
                'url' => $relative_path,
                'name' => $name
            ));
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    function api_delete_gallery_upload($gallery_id, $img_id) {
        $this->if_user_login();
        $myFile = 'uploads/frontend/gallery_images/' . $gallery_id . '/' . $img_id;
        unlink($myFile);
    }
}
