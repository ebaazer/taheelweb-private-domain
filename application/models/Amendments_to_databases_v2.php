<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 17/05/2023
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Amendments_to_databases extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function amendments_to_databases() {

        $this->load->dbforge();

        if (!$this->db->table_exists('supervisor_report_step')) {
            $this->db->query("CREATE TABLE `supervisor_report_step` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `supervisor_report_id` int(11) DEFAULT NULL,
                `step_id` int(11) DEFAULT NULL,
                `evaluation` int(11) DEFAULT NULL,
                PRIMARY KEY (`id`)
               ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        }

        if (!$this->db->table_exists('supervisor_report')) {
            $this->db->query("CREATE TABLE `supervisor_report` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_id` int(11) DEFAULT NULL,
            `month_plan_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `term_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `year` varchar(15) DEFAULT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=12520 DEFAULT CHARSET=latin1;");
        }

        if (!$this->db->table_exists('client')) {
            $this->db->query("CREATE TABLE `client` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `account_type_id` tinyint(4) DEFAULT 0,
            `location` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `organization` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `institution_type` int(11) DEFAULT NULL,
            `role_in_institution` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `website` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `verify_email` tinyint(4) NOT NULL DEFAULT 0,
            `verify_phone` tinyint(4) NOT NULL DEFAULT 0,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `Country_key_reg` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('types_subscriptions_id', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `types_subscriptions_id` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('client_id', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `client_id` INT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('creation_timestamp', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `creation_timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('encrypt_thread', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('types_subscriptions_id', 'payment')) {
            $this->db->query("ALTER TABLE `payment` ADD `types_subscriptions_id` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('client_id', 'payment')) {
            $this->db->query("ALTER TABLE `payment` ADD `client_id` INT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('encrypt_thread', 'payment')) {
            $this->db->query("ALTER TABLE `payment` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('Country_key_reg', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `Country_key_reg`  varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('activity_goal', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `activity_goal` LONGTEXT NULL DEFAULT NULL;");
        }

        /*

          if (!$this->db->table_exists('tools_frontend')) {
          $this->db->query("CREATE TABLE `tools_frontend` (
          `tools_frontend_id` int(11) NOT NULL AUTO_INCREMENT,
          `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
          `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
          `tools_frontend_post` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
          `posted_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
          `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
          `published` int(11) NOT NULL DEFAULT 0,
          `active` int(11) NOT NULL DEFAULT 1,
          `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `categories_id` int(11) DEFAULT NULL,
          `tags_tools` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
          `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
          `number_visits` int(11) NOT NULL DEFAULT 0,
          `last_updated` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
          `number_words` int(11) DEFAULT NULL,
          `useful` int(11) DEFAULT NULL,
          `not_useful` int(11) DEFAULT NULL,
          PRIMARY KEY (`tools_frontend_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
          }
         */

        if (!$this->db->table_exists('subsections')) {
            $this->db->query("CREATE TABLE `subsections` (
            `subsections_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`subsections_id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('subsections_id', 'enroll')) {
            $this->db->query("ALTER TABLE `enroll` ADD `subsections_id` INT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('class_id', 'subsections')) {
            $this->db->query("ALTER TABLE `subsections` ADD `class_id` INT NULL DEFAULT NULL AFTER `subsections_id`;");
        }

        if (!$this->db->field_exists('allow_photography', 'student')) {
            $this->db->query("ALTER TABLE `student` ADD `allow_photography` TINYINT NOT NULL DEFAULT '0' AFTER `encrypt_thread`;");
        }

        if (!$this->db->table_exists('features_taheelweb')) {
            $this->db->query("CREATE TABLE `features_taheelweb` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `attendance` tinyint(4) DEFAULT NULL,
            `number_of_days` int(11) DEFAULT NULL,
            `number_of_hours` int(11) DEFAULT NULL,
            `level` int(11) DEFAULT NULL,
            `register` tinyint(4) NOT NULL DEFAULT 1,
            `certificate` tinyint(4) NOT NULL DEFAULT 1,
            `exam` tinyint(4) NOT NULL DEFAULT 0,
            `keywords` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `visits` int(11) DEFAULT 0,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `posted_slide_home` tinyint(4) NOT NULL DEFAULT 0,
            `slide_home` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `slide_detail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `date_courses` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `time_courses` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `price` decimal(8,2) DEFAULT 0.00,
            `early_registration_price` decimal(8,2) DEFAULT 0.00,
            `price_payment_link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            `early_payment_link` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('program')) {
            $this->db->query("CREATE TABLE `program` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `keywords` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `photo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_added` datetime DEFAULT NULL,
            `visits` int(11) NOT NULL DEFAULT 0,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('website_slide_post', 'features_taheelweb')) {
            $this->db->query("ALTER TABLE `features_taheelweb` ADD `website_slide_post` LONGTEXT NULL DEFAULT NULL AFTER `description`;");
        }

        if (!$this->db->table_exists('calendly')) {
            $this->db->query("CREATE TABLE `calendly` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `institution` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `roll` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `​​interest` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `meeting_day_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `meeting_day_num` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `meeting_month` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `meeting_time` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `more` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `meeting_link` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('pick_date', 'calendly')) {
            $this->db->query("ALTER TABLE `calendly` ADD `pick_date` VARCHAR(50) NULL DEFAULT NULL AFTER `phone`;");
        }

        if (!$this->db->table_exists('subscription_types')) {
            $this->db->query("CREATE TABLE `subscription_types` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bouquet_color` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `duration` int(11) DEFAULT NULL,
            `basic_price` decimal(10,3) DEFAULT 0.000,
            `number_students` int(11) DEFAULT NULL,
            `additional_student_price` decimal(7,3) NOT NULL DEFAULT 0.000,
            `basic_storage_space` int(11) DEFAULT NULL COMMENT 'GB',
            `additional_storage_price` decimal(7,3) NOT NULL DEFAULT 0.000 COMMENT 'GB',
            `basic_tools` tinyint(4) NOT NULL DEFAULT 0,
            `standard_tools` tinyint(4) NOT NULL DEFAULT 0,
            `distinctive_tools` tinyint(4) NOT NULL DEFAULT 0,
            `professional_tools` tinyint(4) NOT NULL DEFAULT 0,
            `individual_tools` tinyint(4) NOT NULL DEFAULT 0,
            `for_institutions` tinyint(4) NOT NULL DEFAULT 0,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `show_on_prices_page` tinyint(4) DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('coupon')) {
            $this->db->query("CREATE TABLE `coupon` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
        `discount_percentage` int(11) DEFAULT NULL,
        `date_start` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
        `date_expiry` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
        `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
        `publish` tinyint(4) NOT NULL DEFAULT 1,
        `active` tinyint(4) NOT NULL DEFAULT 1,
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('country', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `country` VARCHAR(50) NULL DEFAULT NULL AFTER `location`;");
        }
        if (!$this->db->field_exists('city', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `city` VARCHAR(50) NULL DEFAULT NULL AFTER `country`;");
        }

        if (!$this->db->field_exists('organization_size', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `organization_size` VARCHAR(50) NULL DEFAULT NULL AFTER `organization`;");
        }

        if (!$this->db->field_exists('verify_email_code', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `verify_email_code` VARCHAR(50) NULL DEFAULT NULL AFTER `verify_email`;");
        }

        if (!$this->db->field_exists('verify_phone_code', 'client')) {
            $this->db->query("ALTER TABLE `client` ADD `verify_phone_code` VARCHAR(50) NULL DEFAULT NULL AFTER `verify_phone`;");
        }

        if (!$this->db->field_exists('color', 'step_standard')) {
            $this->db->query("ALTER TABLE `step_standard` ADD `color` VARCHAR(30) NULL DEFAULT NULL AFTER `step_standard_taheelweb`;");
        }

        if (!$this->db->table_exists('subscriptions')) {
            $this->db->query("CREATE TABLE `subscriptions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `client_id` int(11) DEFAULT NULL,
            `account_type_id` int(11) DEFAULT NULL,
            `types_subscriptions_id` int(11) DEFAULT NULL,
            `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `start` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expiration` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `basic_number_students` int(11) DEFAULT NULL,
            `additional_number_students` int(11) DEFAULT NULL,
            `basic_storage_space` int(11) DEFAULT NULL,
            `additional_storage_space` int(11) DEFAULT NULL,
            `coupon_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `coupon_discount_percentage` tinyint(4) DEFAULT NULL,
            `coupon_discount_value` decimal(10,3) DEFAULT NULL,
            `basic_product_price` decimal(10,3) DEFAULT NULL,
            `additional_student_price` decimal(10,3) DEFAULT NULL,
            `additional_storage_price` decimal(10,3) DEFAULT NULL,
            `total_subscription_price` decimal(10,3) DEFAULT NULL,
            `total_additional_student_price` decimal(10,3) DEFAULT NULL,
            `total_additional_storage_price` decimal(10,3) DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `actions` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('url', 'subscriptions')) {
            $this->db->query("ALTER TABLE `subscriptions` ADD `url` VARCHAR(100) NULL DEFAULT NULL AFTER `types_subscriptions_id`;");
        }

        if (!$this->db->field_exists('basic_number_students', 'subscriptions')) {
            $this->db->query("ALTER TABLE `subscriptions`  ADD `basic_number_students` INT NULL DEFAULT NULL  AFTER `expiration`,  ADD `additional_number_students` INT NULL DEFAULT NULL  AFTER `basic_number_students`,  ADD `basic_storage_space` INT NULL DEFAULT NULL  AFTER `additional_number_students`,  ADD `additional_storage_space` INT NULL DEFAULT NULL  AFTER `basic_storage_space`,  ADD `coupon_code` VARCHAR(50) NULL DEFAULT NULL  AFTER `additional_storage_space`,  ADD `coupon_discount_percentage` TINYINT NULL DEFAULT NULL  AFTER `coupon_code`,  ADD `coupon_discount_value` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `coupon_discount_percentage`,  ADD `basic_product_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `coupon_discount_value`,  ADD `additional_student_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `basic_product_price`,  ADD `additional_storage_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `additional_student_price`,  ADD `total_subscription_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `additional_storage_price`,  ADD `total_additional_student_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `total_subscription_price`,  ADD `total_additional_storage_price` DECIMAL(10,3) NULL DEFAULT NULL  AFTER `total_additional_student_price`;");
        }

        if ($this->db->table_exists('tools_frontend')) {
            //$this->db->query("RENAME TABLE `taheelweb`.`tools_frontend` TO `taheelweb`.`tools_taheelweb`;");
            $this->load->dbforge();
            $this->dbforge->drop_table('tools_frontend');
        }

        if (!$this->db->field_exists('active', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `active` TINYINT NOT NULL DEFAULT '1' AFTER `last_updated`;");
        }

        if (!$this->db->table_exists('tag')) {
            $this->db->query("CREATE TABLE `tag` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `tag_used` int(11) NOT NULL DEFAULT 0,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `description` varchar(1500) COLLATE utf8_unicode_ci DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=962 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('categories_id', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `categories_id` INT NULL DEFAULT NULL AFTER `frontend_blog_id`;");
        }

        if (!$this->db->field_exists('tags_blog', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `tags_blog` VARCHAR(100) NULL DEFAULT NULL AFTER `categories_id`;");
        }

        if (!$this->db->field_exists('encrypt_thread', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `encrypt_thread` VARCHAR(100) NULL DEFAULT NULL AFTER `frontend_blog_id`;");
        }

        if (!$this->db->field_exists('photo', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `photo` VARCHAR(100) NULL DEFAULT NULL AFTER `blog_post`;");
        }

        if (!$this->db->field_exists('number_visits', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `number_visits` INT NOT NULL AFTER `last_updated`;");
        }

        if (!$this->db->field_exists('timestamp', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` CHANGE `timestamp` `timestamp` VARCHAR(50) NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('student_id', 'all_files')) {
            $this->db->query("ALTER TABLE `all_files` ADD `student_id` INT NULL DEFAULT NULL AFTER `date`, ADD `employee_id` INT NULL DEFAULT NULL AFTER `student_id`;");
        }

        if (!$this->db->table_exists('student_record_attachments')) {
            $this->db->query("CREATE TABLE `student_record_attachments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_record_id` int(11) DEFAULT NULL,
            `attachments` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('date_added', 'frontend_gallery')) {
            $this->db->query("ALTER TABLE `frontend_gallery` CHANGE `date_added` `date_added` VARCHAR(50) NULL DEFAULT NULL;");
        }

        if (!$this->db->table_exists('job_application')) {
            $this->db->query("CREATE TABLE `job_application` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `apply_for` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_of_birth` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `degree` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `years_experience` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `nationality` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `english_level` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `computer_level` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `cv_link` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->session->userdata('c_name') != 'taheelweb') {
            if (!$this->db->field_exists('files', 'student_record')) {
                $this->db->query("ALTER TABLE `student_record` ADD `files` TEXT NULL DEFAULT NULL AFTER `notes`;");
            }
        }

        if (!$this->db->table_exists('behavioral_problems')) {
            $this->db->query("CREATE TABLE `behavioral_problems` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `behavioral_problems` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `datetime_stamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('publish', 'disability')) {
            $this->db->query("ALTER TABLE `disability` ADD `publish` TINYINT NOT NULL DEFAULT '1' AFTER `disability_name`;");
        }

        if (!$this->db->field_exists('publish', 'disability')) {
            $this->db->query("ALTER TABLE `disability` CHANGE `active` `active` TINYINT(4) NULL DEFAULT '1';");
        }

        if (!$this->db->table_exists('aid_sub_categories')) {
            $this->db->query("CREATE TABLE `aid_sub_categories` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `level` tinyint(4) NOT NULL DEFAULT 2,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `main_categories_id` int(11) DEFAULT NULL,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('aid_main_categories')) {
            $this->db->query("CREATE TABLE `aid_main_categories` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `level` tinyint(4) NOT NULL DEFAULT 1,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('aid')) {
            $this->db->query("CREATE TABLE `aid` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `main_categories_id` int(11) DEFAULT NULL,
            `sub_categories_id` int(11) DEFAULT NULL,
            `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `aid_post` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `posted_by` int(11) DEFAULT NULL,
            `tags_aid` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `number_visits` int(11) DEFAULT NULL,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `last_updated` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `useful` int(11) DEFAULT NULL,
            `not_useful` int(11) DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('aid_gallery')) {
            $this->db->query("CREATE TABLE `aid_gallery` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('timestamp_read', 'chat')) {
            $this->db->query("ALTER TABLE `chat` ADD `timestamp_read` VARCHAR(50) NULL DEFAULT NULL AFTER `read_status`;");
        }


        if ($this->db->field_exists('disability_category', 'student')) {
            $this->db->query("ALTER TABLE `student` CHANGE `disability_category` `disability_category` VARCHAR(350) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('virtual', 'student')) {
            $this->db->query("ALTER TABLE `student` ADD `virtual` TINYINT NOT NULL DEFAULT '0' AFTER `img_url`;");
        }

        if (!$this->db->table_exists('user_time_analysis')) {
            $this->db->query("CREATE TABLE `user_time_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) DEFAULT NULL,
            `user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active_time` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `idle_time` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `total_session_time` int(11) DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('form_items')) {
            $this->db->query("CREATE TABLE `form_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `form_manage_id` int(11) DEFAULT NULL,
            `form_axes_id` int(11) DEFAULT NULL,
            `item` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `question_title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `number_of_options` int(11) DEFAULT NULL,
            `options` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('form_manage')) {
            $this->db->query("CREATE TABLE `form_manage` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `instruction` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `class_id` int(11) DEFAULT NULL,
            `job_title_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('form_send')) {
            $this->db->query("CREATE TABLE `form_send` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `form_id` int(11) DEFAULT NULL,
            `user_type` varchar(50) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `submitted` tinyint(4) NOT NULL DEFAULT 0,
            `date_submitted` datetime NOT NULL,
            `date_send` datetime NOT NULL,
            `expires_in` varchar(50) DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `answer_script` longtext DEFAULT NULL,
            `class_id` int(11) DEFAULT NULL,
            `form_send_times_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }

        if (!$this->db->table_exists('form_send_times')) {
            $this->db->query("CREATE TABLE `form_send_times` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `form_id` int(11) DEFAULT NULL,
            `date_send` datetime NOT NULL,
            `expires_in` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
           ;");
        }

        if (!$this->db->field_exists('p_student_record', 'parent')) {
            $this->db->query("ALTER TABLE `parent` ADD `p_student_record` TINYINT NOT NULL DEFAULT '1' AFTER `user_img`, ADD `p_attendance` TINYINT NOT NULL DEFAULT '1' AFTER `p_student_record`, ADD `p_assessment` TINYINT NOT NULL DEFAULT '1' AFTER `p_attendance`, ADD `p_plans` TINYINT NOT NULL DEFAULT '1' AFTER `p_assessment`, ADD `p_plan_wizard` TINYINT NOT NULL DEFAULT '1' AFTER `p_plans`, ADD `p_parent_satisfaction` TINYINT NOT NULL DEFAULT '1' AFTER `p_plan_wizard`;");
        }


        if (!$this->db->field_exists('p_chats', 'parent')) {
            $this->db->query("ALTER TABLE `parent` ADD `p_chats` TINYINT NOT NULL DEFAULT '1' AFTER `p_parent_satisfaction`;");
        }

        if (!$this->db->table_exists('booking_plan')) {
            $this->db->query("CREATE TABLE `booking_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `id_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `parent_id` int(11) DEFAULT NULL,
            `section_id` int(11) DEFAULT NULL,
            `section_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_m` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `time_m` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_add` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_draft')) {
            $this->db->query("CREATE TABLE assessment_draft (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            assessment_id int(11) NOT NULL,
            student_id int(11) NOT NULL,
            year varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
            draft longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            active int(11) DEFAULT 1,
            datetime_stamp datetime DEFAULT NULL,
            PRIMARY KEY (id)
          ) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('metrics')) {
            $this->db->query("CREATE TABLE `metrics` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('metrics_items')) {
            $this->db->query("CREATE TABLE `metrics_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `metrics_id` int(11) DEFAULT NULL,
            `metrics_areas_id` int(11) DEFAULT NULL,
            `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('metrics_areas')) {
            $this->db->query("CREATE TABLE `metrics_areas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `metrics_id` int(11) DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('metrics_send')) {
            $this->db->query("CREATE TABLE `metrics_send` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `metrics_id` int(11) DEFAULT NULL,
            `metrics_send_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `submitted` tinyint(4) NOT NULL DEFAULT 0,
            `date_submitted` datetime NOT NULL,
            `date_send` datetime NOT NULL,
            `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('metrics_submitted')) {
            $this->db->query("CREATE TABLE `metrics_submitted` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `metrics_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `metrics_items_id` int(11) DEFAULT NULL,
            `degree` tinyint(4) NOT NULL DEFAULT 0,
            `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `metrics_send_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('observer', 'student_behaviour')) {
            $this->db->query("ALTER TABLE `student_behaviour` ADD `observer` INT NULL DEFAULT NULL AFTER `encrypt_thread`, ADD `post_behavioral_attitude` TEXT NULL DEFAULT NULL AFTER `observer`, ADD `previous_attitude` TEXT NULL DEFAULT NULL AFTER `post_behavioral_attitude`, ADD `date` VARCHAR(50) NULL DEFAULT NULL AFTER `previous_attitude`;");
        }

        if (!$this->db->table_exists('deleted_items')) {
            $this->db->query("CREATE TABLE `deleted_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `id_type` int(11) DEFAULT NULL,
            `type_user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `date_deleted` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `undo_delete` tinyint(4) NOT NULL DEFAULT 0,
            `undo_delete_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `undo_delete_user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `undo_delete_user_id` int(11) DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('item_for', 'deleted_items')) {
            $this->db->query("ALTER TABLE `deleted_items` ADD `item_for` INT NULL DEFAULT NULL AFTER `id_type`;");
        }

        if (!$this->db->field_exists('name_english', 'job_title')) {
            $this->db->query("ALTER TABLE `job_title` ADD `name_english` VARCHAR(100) NULL DEFAULT NULL AFTER `name`;");
        }

        if (!$this->db->table_exists('notifications')) {
            $this->db->query("CREATE TABLE `notifications` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `start_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `end_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('class_id', 'schedule_subject')) {
            $this->db->query("ALTER TABLE `schedule_subject` ADD `class_id` INT NULL DEFAULT NULL AFTER `datetime`;");
        }
        if (!$this->db->field_exists('session_duration', 'class')) {
            $this->db->query("ALTER TABLE `class` ADD `session_duration` INT NOT NULL DEFAULT '35' AFTER `end_working_hours`, ADD `session_interval` INT NOT NULL DEFAULT '0' AFTER `session_duration`;");
        }

        if ($this->db->field_exists('special_speech_services', 'case_study')) {
            $this->db->query("ALTER TABLE `case_study` CHANGE `special_speech_services` `special_speech_services` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }

        $columns = [
            'case_study_id', 'student_id', 'arrange_the_child', 'number_of_individuals', 'mother_name',
            'mother_age', 'mother_age_birth_child', 'mother_educational_level', 'mother_work', 'father_name',
            'father_age', 'father_educational_level', 'father_work', 'father_workplace', 'parents_relatives',
            'relatives_disabilities', 'relatives_disabilities_mor', 'mother_miscarriage', 'mother_miscarriage_mor',
            'mother_health_pregnancy', 'mother_exposed_xrays', 'mother_take_medication', 'mother_take_medication_mor',
            'mother_psychological_stress', 'mother_psychological_stress_mor', 'experienced_any_pregnancy', 'long_pregnancy',
            'How_was_birth', 'child_weight_at_birth', 'length_child_at_birth', 'child_exposed', 'blood_transfusion',
            'blood_transfusion_mor', 'child_cyanosis', 'child_cyanosis_mor', 'child_need_oxygen', 'child_need_oxygen_mor',
            'start_crawling', 'start_walking', 'use_hand_grip', 'child_stumble_walking', 'move_between_stand_and_sit',
            'child_seizures', 'child_seizures_mor', 'child_seizures_now', 'symptoms', 'intensity', 'repetition',
            'medications_and_dosage', 'dislocation_or_fracture', 'dislocation_or_fracture_mor', 'movement_disability',
            'movement_disability_mor', 'taken_physical_therapy', 'taken_physical_therapy_mor', 'summary_physical_therapy',
            'difficulties_eat', 'difficulties_eat_mor', 'difficulties_drink', 'difficulties_drink_mor', 'osteoporosis',
            'child_control_defecation', 'use_bathroom', 'use_bathroom_mor', 'wearing_his_clothes', 'wearing_his_clothes_mor',
            'cleaning_hands', 'cleaning_hands_mor', 'bathing', 'bathing_mor', 'brushing_teeth', 'brushing_teeth_mor',
            'level_self_care', 'babblement', 'first_word', 'first_sentence', 'language_disorders', 'express_himself',
            'language_home', 'predominant_language_child', 'response_orders', 'tradition', 'difficulties_hearing',
            'difficulties_hearing_mor', 'difficulties_organ_speech', 'difficulties_organ_speech_mor', 'checking_hearing',
            'checking_hearing_mor', 'child_stopped_talking', 'old_when_stopped', 'the_reasons', 'help_to_speak',
            'special_speech_services', 'long_training', 'result_training', 'response_care_tenderness', 'relationship_parents',
            'relationship_siblings', 'participate_social_events', 'according_different_situations', 'play_games_natural',
            'play_group_or_solitary', 'friends_likes_play', 'behavioral_problems', 'adjust_behavior', 'important_boosters',
            'responding_directions', 'planning_conducted', 'planning_conducted_mor', 'sensitivity_something',
            'sensitivity_something_mor', 'assistive_devices', 'assistive_devices_mor', 'tests_applied', 'educational_services',
            'additional_reviews', 'student_disease', 'surgery_student', 'surgery_student_mor', 'student_medicine',
            'student_medicine_mor', 'vaccinated_student', 'vaccinated_student_mor', 'student_medical_report',
            'student_medical_report_mor', 'student_disease_mor', 'information_provider', 'user_create', 'date',
            'place_of_birth', 'age_of_joining_the_center', 'file_opening_date', 'diagnosis_degree_of_autism', 'housing_type',
            'did_the_student_join_other_centers', 'mothers_number', 'mothers_health_condition', 'father_name', 'fathers_number',
            'fathers_health_condition', 'parents_marital_status', 'who_does_the_student_live_with', 'in_case_of_divorce_of_the_parents',
            'income_level', 'mothers_attitude_towards_pregnancy', 'are_there_problems_with_the_blood_type_of_the_mother_and_father',
            'were_any_suction_devices', 'has_the_student_taken_medications', 'has_the_student_had_any_falls',
            'difficulty_running_or_jumping', 'difficulty_climbing_stairs', 'consistently_active', 'often_complain_or_bored',
            'sleep_pattern', 'wake_up_frequently', 'sensory_impairment', 'hours_on_tv_and_devices', 'stereotypical_behavior_description',
            'incomprehensible_words', 'difficulty_pronouncing', 'language_content', 'understanding_others_speech', 'language_form',
            'speech_type', 'speech_problems_first_occurrence', 'speech_vocabulary', 'needs_support_to_speak',
            'family_help_for_speech', 'punished_for_speech', 'general_impression_of_speech', 'uses_bathroom_appropriately',
            'dresses_independently', 'eats_independently', 'follows_instructions', 'understands_requests', 'difficulty_remembering',
            'impulsive_behavior', 'concentration_ability', 'plays_with_others', 'loves_to_play_with', 'behavioral_issues',
            'additional_notes_guardian', 'notes_recommendations_social_worker'
        ];

        foreach ($columns as $column) {
            if (!$this->db->field_exists($column, 'case_study')) {
                $this->db->query("ALTER TABLE `case_study` ADD `$column` TEXT NULL DEFAULT NULL;");
            }
        }
        
        if (!$this->db->field_exists('step_name_en', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `step_name_en` VARCHAR(500) NULL DEFAULT NULL AFTER `activity_goal`;");
        }

        /*
          if (!$this->db->field_exists('aaaaaa', 'frontend_blog')) {
          $this->db->query("aaaaa");
          }
         */

        //fixed function git_log 
        //$this->db->truncate('git_log');
        //end
    }
}
