<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 *      Date created    : 02/06/2022
 *      MANAGE Frontend
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

class Frontend extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->output->enable_profiler($this->config->item('profiler'));

        log_message('debug', 'CI : MY_Controller class loaded');

        $this->load->database();
        $this->load->library('session');
        $this->load->model('Barcode_model');
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

    function alphanumeric_3() {
        $alphanumeric = bin2hex(random_bytes(3));
        return $alphanumeric;
    }

    function generate_password() {
        $alphanumeric = bin2hex(random_bytes(3));
        return $alphanumeric;
    }

    function about_us($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'frontend_about_us';
        $page_data['page_title'] = $this->lang->line('about_us');
        $page_data['about_us_content'] = $this->frontend_model->get_frontend_settings('about_us');
        $this->load->view('backend/index', $page_data);
    }

    function frontend_settings_page($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'frontend_settings';
        $page_data['page_title'] = $this->lang->line('settings');
        $this->load->view('backend/index', $page_data);
    }

    function frontend_mission_and_visions_page($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'frontend_mission_and_visions';
        $page_data['page_title'] = $this->lang->line('mission_and_visions');
        $this->load->view('backend/index', $page_data);
    }

    /*
      function frontend($param1 = '', $param2 = '', $param3 = '') {
      if ($this->session->userdata('user_login') != 1) {
      redirect(base_url(), 'refresh');
      return;
      }

      if ($param1 == 'home_page') {
      $page_data['inner_page'] = 'frontend_home_page';
      $page_data['sliders'] = $this->frontend_model->get_frontend_settings('slider');
      $page_data['welcome_content'] = $this->frontend_model->get_frontend_settings('homepage_welcome_section');
      }


      if ($param1 == 'mission_and_visions') {
      $page_data['inner_page'] = 'frontend_mission_and_visions';
      $page_data['mission_and_visions'] = $this->frontend_model->get_frontend_settings('mission_and_visions');
      }

      if ($param1 == 'department') {
      $page_data['inner_page'] = 'manage_department';
      }

      if ($param1 == 'blog') {
      $page_data['inner_page'] = 'frontend_blog';
      $page_data['blogs'] = $this->frontend_model->get_blogs();
      }

      if ($param1 == 'blog_new') {
      $page_data['inner_page'] = 'frontend_blog_new';
      }

      if ($param1 == 'blog_edit') {
      $page_data['blog'] = $this->frontend_model->get_blog_details($param2);
      $page_data['inner_page'] = 'frontend_blog_edit';
      }

      if ($param1 == 'department') {
      $page_data['inner_page'] = 'manage_department';
      $page_data['department_info'] = $this->crud_model->select_department_info();
      }

      if ($param1 == 'service') {
      $page_data['inner_page'] = 'frontend_service';
      $page_data['service'] = $this->frontend_model->get_frontend_settings('service_section');
      $page_data['services'] = $this->frontend_model->get_services();
      }

      if ($param1 == 'settings') {
      $page_data['inner_page'] = 'frontend_settings';
      }

      if ($param1 == 'gallery') {
      $page_data['inner_page'] = 'frontend_gallery';
      }

      if ($param1 == 'gallery_image') {
      $page_data['inner_page'] = 'frontend_gallery_image';
      $page_data['gallery_id'] = $param2;
      }

      $page_data['page_name'] = 'frontend';
      $page_data['page_title'] = $this->lang->line('manage_website');

      $this->load->view('backend/index', $page_data);
      }
     */

    function frontend_seo($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'do_update') {

            if ($param2 == 'home') {
                $data['description'] = $this->input->post('site_name');
                $data['last_updated'] = date("Y-m-d H:i:s");
                $this->db->where('type', 'site_name');
                $this->db->update('seo', $data);

                $data['description'] = $this->input->post('twitter_card');
                $data['last_updated'] = date("Y-m-d H:i:s");
                $this->db->where('type', 'twitter_card');
                $this->db->update('seo', $data);

                $data['description'] = $this->input->post('twitter_site');
                $data['last_updated'] = date("Y-m-d H:i:s");
                $this->db->where('type', 'twitter_site');
                $this->db->update('seo', $data);

                $data['description'] = $this->input->post('twitter_creator');
                $data['last_updated'] = date("Y-m-d H:i:s");
                $this->db->where('type', 'twitter_creator');
                $this->db->update('seo', $data);

                $data['description'] = $this->input->post('phone_home_page');
                $data['last_updated'] = date("Y-m-d H:i:s");
                $this->db->where('type', 'phone_home_page');
                $this->db->update('seo', $data);
            }

            $data['description'] = $this->input->post('title');
            $data['last_updated'] = date("Y-m-d H:i:s");
            $this->db->where('type', 'title');
            $this->db->where('page_name', $param2);
            $this->db->update('seo', $data);

            $data['description'] = $this->input->post('description');
            $data['last_updated'] = date("Y-m-d H:i:s");
            $this->db->where('type', 'description');
            $this->db->where('page_name', $param2);
            $this->db->update('seo', $data);

            $data['description'] = $this->input->post('keywords');
            $data['last_updated'] = date("Y-m-d H:i:s");
            $this->db->where('page_name', $param2);
            $this->db->where('type', 'keywords');
            $this->db->update('seo', $data);

            redirect(site_url('Frontend/frontend_seo/' . $param2), 'refresh');
        }

        if ($param1 == 'frontend_seo_home') {
            $page_data['inner_page'] = 'frontend_seo_home';
        }

        if ($param1 == 'frontend_seo_contact') {
            $page_data['inner_page'] = 'frontend_seo_contact';
        }

        if ($param1 == 'frontend_seo_register_demo') {
            $page_data['inner_page'] = 'frontend_seo_register_demo';
        }

        if ($param1 == 'frontend_seo_terms') {
            $page_data['inner_page'] = 'frontend_seo_terms';
        }

        if ($param1 == 'frontend_seo_privacy') {
            $page_data['inner_page'] = 'frontend_seo_privacy';
        }

        $page_data['page_name'] = 'frontend_seo';
        $page_data['page_title'] = $this->lang->line('seo');

        $this->load->view('backend/index', $page_data);
    }

    function frontend_settings($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'slider') {
            $this->frontend_model->update_slider();
            $this->session->set_flashdata('message', $this->lang->line('changes_saved_successfully'));
            redirect(site_url('Frontend/frontend/home_page'), 'refresh');
        }

        if ($param1 == 'welcome_section') {
            $this->frontend_model->update_welcome_section_content();
            $this->session->set_flashdata('message', $this->lang->line('changes_saved_successfully'));
            redirect(site_url('Frontend/frontend/home_page'), 'refresh');
        }

        if ($param1 == 'service_section') {
            $this->frontend_model->update_service_section();
            $this->session->set_flashdata('message', $this->lang->line('changes_saved_successfully'));
            redirect(site_url('Frontend/frontend/service'), 'refresh');
        }

        if ($param1 == 'service_new') {
            $this->frontend_model->add_new_service();
            $this->session->set_flashdata('message', $this->lang->line('service_saved_successfully'));
            redirect(site_url('Frontend/frontend/service'), 'refresh');
        }

        if ($param1 == 'service_edit') {
            $this->frontend_model->update_service($param2);
            $this->session->set_flashdata('message', $this->lang->line('service_updated_successfully'));
            redirect(site_url('Frontend/frontend/service'), 'refresh');
        }

        if ($param1 == 'service_delete') {
            $this->frontend_model->delete_service($param2);
            $this->session->set_flashdata('message', $this->lang->line('service_deleted_successfully'));
            redirect(site_url('Frontend/frontend/service'), 'refresh');
        }

        if ($param1 == 'blog_new') {
            $this->frontend_model->add_new_blog();
            $this->session->set_flashdata('message', $this->lang->line('blogpost_saved_successfully'));
            redirect(site_url('Frontend/frontend/blog'), 'refresh');
        }

        if ($param1 == 'blog_edit') {
            $this->frontend_model->update_blog($param2);
            $this->session->set_flashdata('message', $this->lang->line('changes_saved_successfully'));
            redirect(site_url('Frontend/frontend/blog'), 'refresh');
        }

        if ($param1 == 'blog_delete') {
            $this->frontend_model->delete_blog($param2);
            $this->session->set_flashdata('message', $this->lang->line('blog_deleted'));
            redirect(site_url('Frontend/frontend/blog'), 'refresh');
        }

        if ($param1 == 'about_us') {

            $about_us_section_data['description'] = $this->input->post('about_us_1');
            $this->db->where('type', 'about_us');
            $this->db->update('frontend_settings', $about_us_section_data);

            $data['success'] = true;
            $data['message'] = 'Success!';
            echo json_encode($data, JSON_UNESCAPED_UNICODE);

            //$this->session->set_flashdata('message', $this->lang->line('data_updated'));
            //redirect(site_url('index.php/Frontend/about_us'), 'refresh');
        }

        if ($param1 == 'mission_and_visions') {
            $this->frontend_model->update_mission_and_visions();
            $this->session->set_flashdata('message', $this->lang->line('data_updated'));

            $data['success'] = true;
            $data['message'] = 'Success!';
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        if ($param1 == 'settings') {
            $this->frontend_model->update_frontend_settings();
            //$this->session->set_flashdata('message', $this->lang->line('changes_saved_successfully'));
            //redirect(site_url('index.php/frontend/frontend_settings_page'), 'refresh');

            $data['success'] = true;
            $data['message'] = 'Success!';
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    function frontend_gallery($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();
        if ($param1 == 'add_gallery') {
            $this->frontend_model->add_gallery();
            $this->session->set_flashdata('flash_message', $this->lang->line('gallery_added_successfully'));
            redirect(site_url('Frontend/frontend/gallery'), 'refresh');
        }
        if ($param1 == 'edit_gallery') {
            $this->frontend_model->edit_gallery($param2);
            $this->session->set_flashdata('flash_message', $this->lang->line('gallery_updated_successfully'));
            redirect(site_url('Frontend/frontend/gallery'), 'refresh');
        }
        if ($param1 == 'upload_images') {
            $this->frontend_model->add_gallery_images($param2);
            $this->session->set_flashdata('flash_message', $this->lang->line('images_uploaded'));
            redirect(site_url('Frontend/frontend/gallery_image/' . $param2), 'refresh');
        }
        if ($param1 == 'delete_image') {
            $this->frontend_model->delete_gallery_image($param2);
            $this->session->set_flashdata('flash_message', $this->lang->line('images_deleted'));
            redirect(site_url('Frontend/frontend/gallery_image/' . $param3), 'refresh');
        }
    }

    function contact_email($param1 = '', $param2 = '') {
        $this->if_user_login();

        if ($param1 == 'reply') {

            $contact_email_id = $this->input->post('contact_email_id');
            $data['reply'] = $this->input->post('reply');
            $data['user_id_reply'] = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
            $data['reply_timestamp'] = strtotime(date("Y-m-d H:i:s"));

            $this->db->where('contact_email_id', $contact_email_id);
            $this->db->update('contact_email', $data);
            redirect(site_url('Frontend/contact_email'), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->db->where('contact_email_id', $param2);
            $this->db->delete('contact_email');
            $this->session->set_flashdata('message', $this->lang->line('email_deleted'));
            redirect(site_url('Frontend/contact_email'), 'refresh');
        }

        $page_data['page_name'] = 'contact_email';

        $page_data['page_title'] = $this->lang->line('contact_emails');
        $page_data['contact_emails'] = $this->frontend_model->get_contact_emails();
        $this->load->view('backend/index', $page_data);
    }

    function department_facilities($param1 = '', $param2 = '', $param3 = '') {
        $this->if_user_login();

        if ($param1 == 'add') {
            $this->frontend_model->add_department_facility($param2);
            $this->session->set_flashdata('message', $this->lang->line('facility_saved_successfully'));
            redirect(site_url('Frontend/department_facilities' . $param2), 'refresh');
        }

        if ($param1 == 'edit') {
            $this->frontend_model->edit_department_facility($param2);
            $this->session->set_flashdata('message', $this->lang->line('facility_updated_successfully'));
            redirect(site_url('Frontend/department_facilities' . $param3), 'refresh');
        }

        if ($param1 == 'delete') {
            $this->frontend_model->delete_department_facility($param2);
            $this->session->set_flashdata('message', $this->lang->line('facility_deleted_successfully'));
            redirect(site_url('Frontend/department_facilities' . $param3), 'refresh');
        }

        $data['department_info'] = $this->frontend_model->get_department_info($param1);
        $data['facilities'] = $this->frontend_model->get_department_facilities($param1);
        $data['page_name'] = 'department_facilities';
        $data['page_title'] = $this->lang->line('department_facilities') . ' | ' . $data['department_info']->name . ' ' . $this->lang->line('department');
        $this->load->view('backend/index', $data);
    }

    function department($task = "", $department_id = "") {
        $this->if_user_login();
        if ($task == "create") {
            $this->crud_model->save_department_info();
            $this->session->set_flashdata('message', $this->lang->line('department_info_saved_successfuly'));
            redirect(site_url('Frontend/frontend/department'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_department_info($department_id);
            $this->session->set_flashdata('message', $this->lang->line('department_info_updated_successfuly'));
            redirect(site_url('Frontend/frontend/department'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_department_info($department_id);
            redirect(site_url('Frontend/frontend/department'), 'refresh');
        }
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

    function get_data_contact_email() {
        $this->if_user_login();
        $this->db->select("a.*");

        //$this->db->from("book_visit a");
        $this->db->from("contact_email a");

        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where("active", 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }

    function get_data_appointments() {
        $this->if_user_login();
        $this->db->select("a.*");

        $this->db->from("book_visit a");

        //$this->db->join("client b", "a.client_id = b.id", 'left');
        //$this->db->join("types_subscriptions c", "a.types_subscriptions_id = c.id", 'left');
        //$this->db->join("account_type d", "a.account_type_id = d.id", 'left');
        $this->db->where("active", 1);

        $subscriptions = $this->db->get()->result_array();

        $subscriptions_json = json_encode($subscriptions, JSON_UNESCAPED_UNICODE);
        $by_field = "id";

        $this->array_json->array_json($subscriptions_json, $by_field);
    }
    
        function appointments($param1 = '', $param2 = '') {
        $this->if_user_login();

        $page_data['page_name'] = 'appointments';
        $page_data['page_title'] = $this->lang->line('appointments');
        $page_data['contact_emails'] = $this->frontend_model->get_contact_emails();
        $this->load->view('backend/index', $page_data);
    }
}
