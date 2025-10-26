<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 14/08/2024
 *      Aid Controll
 * 	 
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Aid extends CI_Controller {

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

    function get_data_aid() {
        $this->if_user_login();

        $json_data = array();

        $this->db->select("a.*, b.name as main_categories_name, c.name as sub_categories_name");
        $this->db->from("aid a");
        $this->db->join("aid_main_categories b", "b.id = a.main_categories_id", 'left');
        $this->db->join("aid_sub_categories c", "c.id = a.sub_categories_id", 'left');
        $this->db->where('a.active', 1);
        $aid = $this->db->get()->result_array();

        foreach ($aid as $row) {

            if ($row['publish'] == 0) {
                $published = 2;
            } else {
                $published = 1;
            }

            array_push($json_data, array(
                'id' => $row['id'],
                'main_categories_name' => $row['main_categories_name'],
                'sub_categories_name' => $row['sub_categories_name'],
                'title' => $row['title'],
                'aid_post' => $row['aid_post'],
                'posted_by' => $row['posted_by'],
                'date_added' => $row['timestamp'],
                'publish' => $published,
                'active' => $row['active'],
                'encrypt_thread' => $row['encrypt_thread'],
                'number_visits' => $row['number_visits'],
                'useful' => $row['useful'],
                'not_useful' => $row['not_useful'],
            ));
        }

        $aid_json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($aid_json, $by_field);
    }

    function get_data_aid_main_categories() {
        $this->if_user_login();

        $json_data = array();

        $this->db->select("a.*");
        $this->db->from("aid_main_categories a");
        $this->db->where('active', 1);
        $aid_main_categories = $this->db->get()->result_array();

        foreach ($aid_main_categories as $row) {

            if ($row['publish'] == 0) {
                $published = 2;
            } else {
                $published = 1;
            }

            array_push($json_data, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'publish' => $published,
                'active' => $row['active'],
            ));
        }

        $aid_main_categories_json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($aid_main_categories_json, $by_field);
    }

    function get_data_aid_sub_categories() {
        $this->if_user_login();

        $json_data = array();

        $this->db->select("a.*, b.name as main_categories_name");
        $this->db->from("aid_sub_categories a");
        $this->db->join("aid_main_categories b", "b.id = a.main_categories_id", 'left');
        $this->db->where('a.active', 1);
        $aid_sub_categories = $this->db->get()->result_array();

        foreach ($aid_sub_categories as $row) {

            if ($row['publish'] == 0) {
                $published = 2;
            } else {
                $published = 1;
            }

            array_push($json_data, array(
                'id' => $row['id'],
                'name' => $row['name'],
                'main_categories_name' => $row['main_categories_name'],
                'publish' => $published,
                'active' => $row['active']
            ));
        }

        $aid_sub_categories_json = json_encode($json_data, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($aid_sub_categories_json, $by_field);
    }

    function aid_add() {
        $this->if_user_login();

        $page_data['page_name'] = 'aid_add';
        $page_data['page_title'] = 'اضافة المساعدات';
        $this->load->view('backend/index', $page_data);
    }

    function aid() {
        $this->if_user_login();

        $page_data['page_name'] = 'aid';
        $page_data['page_title'] = 'المساعدات';
        $this->load->view('backend/index', $page_data);
    }

    function aid_edit($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['aid_encrypt_thread'] = $param1;
        $page_data['page_name'] = 'aid_edit';
        $page_data['page_title'] = 'تعديل المساعدة';
        $this->load->view('backend/index', $page_data);
    }

    function aid_main_categories() {
        if ($this->session->userdata('user_login') != 1) {
            redirect(site_url('login'), 'refresh');
            return;
        }

        $page_data['page_name'] = 'aid_main_categories';
        $page_data['page_title'] = 'الفئات الرئيسية للمساعدات';
        $this->load->view('backend/index', $page_data);
    }

    function aid_sub_categories() {
        $this->if_user_login();

        $page_data['page_name'] = 'aid_sub_categories';
        $page_data['page_title'] = 'الفئات الفرعية للمساعدات';
        $this->load->view('backend/index', $page_data);
    }

    function add_new_aid_main_categories($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_main_categories_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_main_categories_name');
                $aid_data['encrypt_thread'] = bin2hex(random_bytes(32));
                $this->db->insert('aid_main_categories', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function add_new_aid_sub_categories($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_sub_categories_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_sub_categories_name');
                $aid_data['short_description'] = $this->input->post('aid_sub_categories_short_description');
                $aid_data['main_categories_id'] = $this->input->post('main_categories_id');
                $aid_data['encrypt_thread'] = bin2hex(random_bytes(32));
                $this->db->insert('aid_sub_categories', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function aid_add_new($param1 = "") {
        $this->if_user_login();

        if ($param1 == 'create') {

            $errors = [];
            $data = [];

            if (empty($_POST['title'])) {
                //$errors['title'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['main_categories_id'] = $this->input->post('aid_main_categories_id');
                $aid_data['sub_categories_id'] = $this->input->post('aid_sub_categories_id');
                $aid_data['title'] = $this->input->post('title');
                $aid_data['aid_post'] = $this->input->post('aid_post');
                $aid_data['publish'] = $this->input->post('publish');
                $aid_data['posted_by'] = $this->session->userdata('login_user_id');
                $aid_data['date_added'] = date("Y-m-d H:i:s");
                $aid_data['encrypt_thread'] = bin2hex(random_bytes(32));

                $this->db->insert('aid', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function aid_edit_ajax($param1 = "") {
        $this->if_user_login();

        if ($param1 == 'edit') {

            $errors = [];
            $data = [];

            if (empty($_POST['title'])) {
                //$errors['title'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['main_categories_id'] = $this->input->post('aid_main_categories_id');
                $aid_data['sub_categories_id'] = $this->input->post('aid_sub_categories_id');
                $aid_data['title'] = $this->input->post('title');
                $aid_data['aid_post'] = $this->input->post('aid_post');
                $aid_data['publish'] = $this->input->post('publish');
                $aid_data['last_updated'] = date("Y-m-d H:i:s");

                $this->db->where('id', $this->input->post('aid_id'));
                $this->db->update('aid', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function get_sub_categories_data() {
        $this->if_user_login();

        $main_categories_id = $_POST['main_categories_id'];

        $this->db->select("a.*");
        $this->db->from("aid_sub_categories a");
        $this->db->where('a.main_categories_id', $main_categories_id);
        $this->db->where('a.active', 1);
        $aid_sub_categories = $this->db->get()->result_array();

        foreach ($aid_sub_categories as $row) {
            //echo $class_id;
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }

    function get_data_aid_gallery() {
        $this->if_user_login();

        $this->db->select("a.*");
        $this->db->from("aid_gallery a");
        $this->db->where('active', 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function aid_gallery() {
        $this->if_user_login();

        $page_data['page_name'] = 'aid_gallery';
        $page_data['page_title'] = $this->lang->line('gallery');
        $this->load->view('backend/index', $page_data);
    }

    function aid_gallery_image($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('user_login') != 1) {
            redirect(site_url('login'), 'refresh');
            return;
        }
        $page_data['page_name'] = 'aid_gallery_image';
        $page_data['page_title'] = $this->lang->line('gallery_add');
        $page_data['gallery_id'] = $param1;
        $this->load->view('backend/index', $page_data);
    }

    function aid_gallery_new($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'create') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_gallery_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_gallery_name');
                $aid_data['encrypt_thread'] = bin2hex(random_bytes(32));
                $this->db->insert('aid_gallery', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function delete_aid($param1 = '') {
        $this->if_user_login();

        $data['active'] = 0;

        $this->db->where('id', $param1);
        $this->db->update('aid', $data);

        //redirect(site_url('user/blog/'), 'refresh');
    }

    function delete_aid_main($param1 = '') {
        if ($this->session->userdata('user_login') != 1) {
            redirect(site_url('login'), 'refresh');
            return;
        }

        $data['active'] = 0;

        $this->db->where('id', $param1);
        $this->db->update('aid_main_categories', $data);

        //redirect(site_url('user/blog/'), 'refresh');
    }

    function delete_aid_sub($param1 = '') {
        $this->if_user_login();

        $data['active'] = 0;

        $this->db->where('id', $param1);
        $this->db->update('aid_sub_categories', $data);

        //redirect(site_url('user/blog/'), 'refresh');
    }

    function edit_aid_main_categories($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'edit') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_main_categories_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_main_categories_name');

                $this->db->where('id', $this->input->post('aid_main_categories_id'));
                $this->db->update('aid_main_categories', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function edit_aid_sub_categories($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'edit') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_sub_categories_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_sub_categories_name');
                $aid_data['short_description'] = $this->input->post('aid_sub_categories_short_description');
                $aid_data['main_categories_id'] = $this->input->post('main_categories_id');

                $this->db->where('id', $this->input->post('aid_sub_categories_id'));
                $this->db->update('aid_sub_categories', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function delete_aid_gallery($param1 = '') {
        $this->if_user_login();

        $data['active'] = 0;

        $this->db->where('id', $param1);
        $this->db->update('aid_gallery', $data);

        //redirect(site_url('user/blog/'), 'refresh');
    }

    function aid_gallery_edit($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'edit') {

            $errors = [];
            $data = [];

            if (empty($_POST['aid_gallery_name'])) {
                $errors['name'] = $this->lang->line('is_required');
            }

            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $aid_data['name'] = $this->input->post('aid_gallery_name');

                $this->db->where('id', $this->input->post('aid_gallery_id'));
                $this->db->update('aid_gallery', $aid_data);

                $data['success'] = true;
                $data['message'] = 'Success!';
            }

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function add_new_img_aid_gallery() {
        $this->if_user_login();

        $filename = $_FILES['file']['name'];
        $info = new SplFileInfo($filename);
        $uname = bin2hex(random_bytes(24));
        $folder = 'uploads/gallery_cover/';

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

    function api_aid_gallery_upload($gallery_id = '') {
        $this->if_user_login();
        $countfiles = count($_FILES['userfile']['tmp_name']);

        // Looping all files
        $response = array();
        for ($i = 0; $i < $countfiles; $i++) {
            $filename = $_FILES['userfile']['name'][$i];
            $info = new SplFileInfo($filename);
            $uname = bin2hex(random_bytes(24));
            $folder = 'uploads/taheelweb_doc/' . $gallery_id . '/';

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

    function api_delete_aid_gallery_upload($gallery_id, $img_id) {
        $this->if_user_login();

        $myFile = 'uploads/taheelweb_doc/' . $gallery_id . '/' . $img_id;
        unlink($myFile);
    }
}
