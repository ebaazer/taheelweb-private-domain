<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Amendments_to_databases extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function amendments_to_databases() {

        $this->load->dbforge();

        $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
        if ($prefix == '_rc') {
            
        } else {
            
        }

        if (!$this->db->field_exists('active', 'enroll')) {
            $this->db->query("ALTER TABLE `enroll` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if ($this->db->field_exists('sex', 'student')) {
            $fields = array(
                'sex' => array(
                    'name' => 'gender',
                    'type' => 'varchar(15)',
                ),
            );
            $this->dbforge->modify_column('student', $fields);
        }

        $storage_space = $this->db->get_where('settings', array('type' => 'storage_space'))->row()->description;
        if ($storage_space == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $data_prefix['type'] = 'storage_space';
                $data_prefix['description'] = '100';
            } else {
                $data_prefix['type'] = 'storage_space';
                $data_prefix['description'] = '10';
            }
            $this->db->insert('settings', $data_prefix);
        }

        $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
        if ($center_type == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $data_center_type['type'] = 'center_type';
                $data_center_type['description'] = 'day_care';
            } elseif ($prefix == '_eliteskills') {
                $data_center_type['type'] = 'center_type';
                $data_center_type['description'] = 'clinic';
            }
            $this->db->insert('settings', $data_center_type);
        }

        //يخص تحويل مركز خطوات للنسخة الجديدة
        $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
        if ($prefix == '_rc') {

            if (!$this->db->field_exists('chat_type', 'chat_thread')) {
                $this->db->query("ALTER TABLE `chat_thread` ADD `chat_type` tinyint(4) NULL DEFAULT null;");
            }

            if (!$this->db->table_exists('chat_contacts')) {
                $this->db->query("CREATE TABLE `chat_contacts` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `chat_thread_id` int(11) DEFAULT NULL,
                    `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `chat_type` tinyint(4) DEFAULT NULL COMMENT '1 = private/ 2 = group',
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

                //توزيع جهات المحادثات في الجدول القديم الى الجدول الجديد
                // 1 = private
                // 2 = group
                $this->db->select("a.*");
                $this->db->from("chat_thread a");
                $chat_thread = $this->db->get()->result_array();

                foreach ($chat_thread as $row) {

                    $data_sender['chat_thread_id'] = $row['chat_thread_id'];
                    $data_sender['user_id'] = $row['sender'];
                    $data_sender['chat_type'] = '1';

                    $this->db->insert('chat_contacts', $data_sender);

                    $data_reciever['chat_thread_id'] = $row['chat_thread_id'];
                    $data_reciever['user_id'] = $row['reciever'];
                    $data_reciever['chat_type'] = '1';

                    $this->db->insert('chat_contacts', $data_reciever);
                }
            }

            if (!$this->db->field_exists('level', 'assessment_goal')) {
                $this->db->query("ALTER TABLE `assessment_goal` ADD `level` varchar(50) DEFAULT '';");
            }

            if ($this->db->table_exists('p_default_permissions')) {
                $this->load->dbforge();
                $this->dbforge->drop_table('p_default_permissions');
            }

            if (!$this->db->table_exists('all_files')) {
                $this->db->query("CREATE TABLE `all_files` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `path` text COLLATE utf8_unicode_ci DEFAULT NULL,
              `file_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
              `size` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
              `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
              `user_id` int(11) DEFAULT NULL,
              `user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
              `publish` tinyint(4) NOT NULL DEFAULT 1,
              `active` tinyint(4) NOT NULL DEFAULT 1,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('bookings')) {
                $this->db->query("CREATE TABLE `bookings` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `date` date DEFAULT NULL,
                    `name` varchar(255) NOT NULL,
                    `email` varchar(255) NOT NULL,
                    `timeslot` varchar(255) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
            }

            if (!$this->db->field_exists('student_id', 'bookings')) {
                $this->db->query("ALTER TABLE `bookings` ADD `student_id` int(11) DEFAULT NULL;");
            }

            if (!$this->db->field_exists('employee_id', 'bookings')) {
                $this->db->query("ALTER TABLE `bookings` ADD `employee_id` int(11) DEFAULT NULL;");
            }

            if (!$this->db->field_exists('job_title_id', 'bookings')) {
                $this->db->query("ALTER TABLE `bookings` ADD `job_title_id` int(11) DEFAULT NULL;");
            }

            if (!$this->db->table_exists('blog_categories')) {
                $this->db->query("CREATE TABLE `blog_categories` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `categories_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
                    `description_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
                    `categories_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
                    `description_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
                    `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `active` int(11) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('frontend_blog')) {
                $this->db->query("CREATE TABLE `frontend_blog` (
                        `frontend_blog_id` int(11) NOT NULL AUTO_INCREMENT,
                        `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
                        `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
                        `blog_post` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                        `posted_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `timestamp` int(11) DEFAULT NULL,
                        `published` int(11) NOT NULL DEFAULT 0,
                        `active` int(11) NOT NULL DEFAULT 1,
                        `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `categories_id` int(11) DEFAULT NULL,
                        `tags_blog` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                        `number_visits` int(11) NOT NULL DEFAULT 0,
                        PRIMARY KEY (`frontend_blog_id`)
                      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('request_employee')) {
                $this->db->query("CREATE TABLE `request_employee` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                `form_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                `user_id` int(11) DEFAULT NULL,
                `submission_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `date_starting` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `reasons` text COLLATE utf8_unicode_ci DEFAULT NULL,
                `attachments_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
                `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `status_request` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
                `status_user` int(11) DEFAULT NULL,
                `status_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `publish` tinyint(4) NOT NULL DEFAULT 1,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->field_exists('number_visits', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `number_visits` int(11) NOT NULL DEFAULT 0;");
            }

            if (!$this->db->field_exists('encrypt_thread', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('active', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('short_description', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('published', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `published` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('tags_gallery', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `tags_gallery` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('posted_by', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `posted_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('photo', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('timestamp', 'frontend_gallery')) {
                $this->db->query("ALTER TABLE `frontend_gallery` ADD `timestamp` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('size', 'group_message')) {
                $this->db->query("ALTER TABLE `group_message` ADD `size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->table_exists('git_log')) {
                $this->db->query("CREATE TABLE `git_log` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `commit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
                    `version` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->field_exists('active', 'parent')) {
                $this->db->query("ALTER TABLE `parent` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('active', 'class')) {
                $this->db->query("ALTER TABLE `class` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            //if (!$this->db->field_exists('gender', 'student')) {
            //    $this->db->query("ALTER TABLE `student` ADD `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL;");
            //}

            if (!$this->db->field_exists('img_type', 'student')) {
                $this->db->query("ALTER TABLE `student` ADD `img_type` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('img_url', 'student')) {
                $this->db->query("ALTER TABLE `student` ADD `img_url` longtext COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('active', 'student')) {
                $this->db->query("ALTER TABLE `student` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('date_added', 'student')) {
                $this->db->query("ALTER TABLE `student` ADD `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            //Change the status of students in the table One time use
            if (!$this->db->table_exists('for_update')) {
                $this->db->query("CREATE TABLE `for_update` (
                    `settings_id` int(11) NOT NULL AUTO_INCREMENT,
                    `type` longtext DEFAULT NULL,
                    `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                    PRIMARY KEY (`settings_id`)
                  ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
            }

            $for_update_status_student = $this->db->get_where('for_update', array('type' => 'status_student'))->row()->description;
            if ($for_update_status_student == null) {
                $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
                if ($prefix == '_rc') {
                    $data_for_update['type'] = 'status_student';
                    $data_for_update['description'] = '0';
                    $this->db->insert('for_update', $data_for_update);
                }
            }

            $for_update_status_student = $this->db->get_where('for_update', array('type' => 'status_student'))->row()->description;
            if ($for_update_status_student == 0) {
                $all_student = $this->db->get('enroll')->result_array();
                foreach ($all_student as $all_student_row) {
                    if ($all_student_row['status'] == 0) {
                        $data_student_row['status'] = 1;
                        $this->db->where('enroll_id', $all_student_row['enroll_id']);
                        $this->db->update('enroll', $data_student_row);
                    } else {
                        $data_student_row['status'] = 0;
                        $this->db->where('enroll_id', $all_student_row['enroll_id']);
                        $this->db->update('enroll', $data_student_row);
                    }
                }

                //$all_student_for_img = $this->db->get('enroll')->result_array();
                $all_student_for_gender = $this->db->get('student')->result_array();

                $random_img_student_1 = ["001-boy", "004-boy-1", "007-boy-2", "008-boy-3", "009-boy-4", "011-boy-5", "015-boy-6", "016-boy-7", "021-boy-8", "024-boy-9", "026-boy-10", "029-boy-11", "031-boy-12", "032-boy-13", "034-boy-14", "035-boy-15", "038-boy-16", "040-boy-17", "043-boy-18", "044-boy-19", "045-boy-20", "048-boy-21", "049-boy-22"];
                $random_img_student_2 = ["002-girl", "003-girl-1", "005-girl-2", "006-girl-3", "010-girl-4", "012-girl-5", "013-girl-6", "014-girl-7", "017-girl-8", "018-girl-9", "019-girl-10", "020-girl-11", "022-girl-12", "023-girl-13", "025-girl-14", "027-girl-15", "028-girl-16", "030-girl-17", "033-girl-18", "036-girl-19", "037-girl-20", "039-girl-21", "041-girl-22", "042-girl-23", "046-girl-24", "047-girl-25", "050-girl-26"];

                foreach ($all_student_for_gender as $all_student_for_img_row) {
                    if ($all_student_for_img_row['gender'] == '1' || $all_student_for_img_row['gender'] == 'male') {
                        shuffle($random_img_student_1);
                        $name = $random_img_student_1[0] . '.svg';
                        $data_for_img['img_url'] = $name;
                        $data_for_img['img_type'] = '1';
                        $this->db->where('student_id', $all_student_for_img_row['student_id']);
                        $this->db->update('student', $data_for_img);
                    } elseif ($all_student_for_img_row['gender'] == '2' || $all_student_for_img_row['gender'] == 'female') {
                        shuffle($random_img_student_2);
                        $name = $random_img_student_2[0] . '.svg';
                        $data_for_img['img_url'] = $name;
                        $data_for_img['img_type'] = '1';
                        $this->db->where('student_id', $all_student_for_img_row['student_id']);
                        $this->db->update('student', $data_for_img);
                    } else {
                        shuffle($random_img_student_1);
                        $name = $random_img_student_1[0] . '.svg';
                        $data_for_img['img_url'] = $name;
                        $data_for_img['img_type'] = '1';
                        $this->db->where('student_id', $all_student_for_img_row['student_id']);
                        $this->db->update('student', $data_for_img);
                    }
                }

                $data_for_update_after['description'] = 1;
                $this->db->where('type', 'status_student');
                $this->db->update('for_update', $data_for_update_after);
            }



            //انشاء جدول الطلاب واولياء الامور
            if (!$this->db->table_exists('student_parent')) {
                $this->db->query("CREATE TABLE `student_parent` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `student_id` int(11) DEFAULT NULL,
                    `parent_id` int(11) DEFAULT NULL,
                    `date_added` datetime DEFAULT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

                //توزيع الطلاب واولياء الامور في الجدول الجديد
                $this->db->select("a.*");
                $this->db->from("student_parent a");
                $student_parent_num = $this->db->get()->num_rows();

                if ($student_parent_num == 0) {
                    $this->db->select("a.*");
                    $this->db->from("student a");
                    $student = $this->db->get()->result_array();

                    foreach ($student as $row) {
                        $data_student_parent['student_id'] = $row['student_id'];
                        $data_student_parent['parent_id'] = $row['parent_id'];
                        $data_student_parent['date_added'] = date("Y-m-d H:i:s");
                        $this->db->insert('student_parent', $data_student_parent);
                    }
                }
            }

            //توزيع العاملين الى جدول جديد
            if (!$this->db->table_exists('employee_classes')) {
                $this->db->query("CREATE TABLE `employee_classes` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `class_id` int(11) NOT NULL,
                    `employee_id` int(11) NOT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    `date` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

                $this->db->select("a.*");
                $this->db->from("employee_classes a");
                $employee_class_num = $this->db->get()->num_rows();
                if ($employee_class_num == 0) {
                    $this->db->select("a.*");
                    $this->db->from("employee a");
                    $employee = $this->db->get()->result_array();

                    foreach ($employee as $row) {

                        if ($row['class_id'] > 0) {

                            $data['class_id'] = $row['class_id'];
                            $data['employee_id'] = $row['employee_id'];
                            $data['date'] = date("Y-m-d H:i:s");

                            $this->db->insert('employee_classes', $data);
                        } else {

                            $this->db->select("a.*");
                            $this->db->from("class a");
                            $class = $this->db->get()->result_array();

                            foreach ($class as $class_row) {

                                $data['class_id'] = $class_row['class_id'];
                                $data['employee_id'] = $row['employee_id'];
                                $data['date'] = date("Y-m-d H:i:s");

                                $this->db->insert('employee_classes', $data);
                            }
                        }
                    }
                }
            }

            //ضع هنا طريقة توزيع المعلمين على الفصول في الجدول الجديد 
            if (!$this->db->table_exists('section_employee')) {
                $this->db->query("CREATE TABLE `section_employee` (
                `section_employee_id` int(11) NOT NULL AUTO_INCREMENT,
                `section_id` int(11) DEFAULT NULL,
                `employee_id` int(11) DEFAULT NULL,
                `job` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `date` datetime DEFAULT NULL,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                PRIMARY KEY (`section_employee_id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

                $this->db->select("a.*");
                $this->db->from("section_employee a");
                $employee_section_num = $this->db->get()->num_rows();

                if ($employee_section_num == 0) {
                    $new_employee_section = array();

                    $this->db->select("a.*");
                    $this->db->from("section a");
                    $employee_section = $this->db->get()->result_array();

                    foreach ($employee_section as $row) {

                        if ($row['teacher_id'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['teacher_id'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['teacher_id_2'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['teacher_id_2'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['teacher_id_3'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['teacher_id_3'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['teacher_id_4'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['teacher_id_4'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['teacher_id_5'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['teacher_id_5'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['assistant_teacher_id'] != 0) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['assistant_teacher_id'],
                                'job' => 'teachers',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }

                        if ($row['supervisor_id'] != 0 || $row['supervisor_id'] != null) {
                            array_push($new_employee_section, array(
                                'section_id' => $row['section_id'],
                                'employee_id' => $row['supervisor_id'],
                                'job' => 'supervisor',
                                'date' => date("Y-m-d H:i:s"),
                            ));
                        }
                    }

                    foreach ($new_employee_section as $new_employee_section_row) {

                        $data_employee_section['section_id'] = $new_employee_section_row['section_id'];
                        $data_employee_section['employee_id'] = $new_employee_section_row['employee_id'];
                        $data_employee_section['job'] = $new_employee_section_row['job'];
                        $data_employee_section['date'] = date("Y-m-d H:i:s");

                        $this->db->insert('section_employee', $data_employee_section);
                    }
                }
            }

            if (!$this->db->field_exists('user_img', 'employee')) {
                $this->db->query("ALTER TABLE `employee` ADD `user_img` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('key_pass', 'employee')) {
                $this->db->query("ALTER TABLE `employee` ADD `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('key_pass', 'parent')) {
                $this->db->query("ALTER TABLE `parent` ADD `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('date_added', 'parent')) {
                $this->db->query("ALTER TABLE `parent` ADD `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('active', 'job_title')) {
                $this->db->query("ALTER TABLE `job_title` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('user_img', 'parent')) {
                $this->db->query("ALTER TABLE `parent` ADD `user_img` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL;");
            }

            if (!$this->db->field_exists('active', 'services_provided')) {
                $this->db->query("ALTER TABLE `services_provided` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('available', 'services_provided')) {
                $this->db->query("ALTER TABLE `services_provided` ADD `available` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'available/0=unavailable';");
            }

            if (!$this->db->field_exists('active', 'student_services')) {
                $this->db->query("ALTER TABLE `student_services` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->field_exists('active', 'term')) {
                $this->db->query("ALTER TABLE `term` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
            }

            if (!$this->db->table_exists('mail_attachments')) {
                $this->db->query("CREATE TABLE `mail_attachments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `mail_auth_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                    `attachments` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                    `account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `user_id` int(11) DEFAULT NULL,
                    `date_added` datetime DEFAULT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('mail_auth_key')) {
                $this->db->query("CREATE TABLE `mail_auth_key` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `mail_auth_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `date_added` datetime DEFAULT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('mail_massege')) {
                $this->db->query("CREATE TABLE `mail_massege` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `mail_auth_key_id` int(11) DEFAULT NULL,
                    `subject` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                    `massege` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                    `date_added` datetime DEFAULT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('mail_read_status')) {
                $this->db->query("CREATE TABLE `mail_read_status` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `mail_massege_id` int(11) DEFAULT NULL,
                    `user_id` int(11) DEFAULT NULL,
                    `account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `read_status` tinyint(4) NOT NULL DEFAULT 0,
                    `date` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if (!$this->db->table_exists('mail_s_r')) {
                $this->db->query("CREATE TABLE `mail_s_r` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `mail_auth_key_id` int(11) DEFAULT NULL,
                    `sender` int(11) DEFAULT NULL,
                    `sender_account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `reciever` int(11) DEFAULT NULL,
                    `reciever_account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                    `reciever_type` tinyint(4) DEFAULT NULL,
                    `active` tinyint(4) NOT NULL DEFAULT 1,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }

            if ($this->db->field_exists('sex', 'employee')) {
                $this->db->query("ALTER TABLE employee CHANGE `sex` `gender` VARCHAR(6);");
            }

            //اضافة صور افتراضية للطلاب
            $random_img_student_1 = array("001-boy", "004-boy-1", "007-boy-2", "008-boy-3", "009-boy-4", "011-boy-5", "015-boy-6", "016-boy-7", "021-boy-8", "024-boy-9", "026-boy-10", "029-boy-11", "031-boy-12", "032-boy-13", "034-boy-14", "035-boy-15", "038-boy-16", "040-boy-17", "043-boy-18", "044-boy-19", "045-boy-20", "048-boy-21", "049-boy-22");
            $random_img_student_2 = array("002-girl", "003-girl-1", "005-girl-2", "006-girl-3", "010-girl-4", "012-girl-5", "013-girl-6", "014-girl-7", "017-girl-8", "018-girl-9", "019-girl-10", "020-girl-11", "022-girl-12", "023-girl-13", "025-girl-14", "027-girl-15", "028-girl-16", "030-girl-17", "033-girl-18", "036-girl-19", "037-girl-20", "039-girl-21", "041-girl-22", "042-girl-23", "046-girl-24", "047-girl-25", "050-girl-26");

            $this->db->select("a.*");
            $this->db->from("student a");
            $student = $this->db->get()->result_array();

            foreach ($student as $row) {

                if ($row['img_url'] == null || $row['img_url'] == '') {
                    if ($row['gender'] == 'male') {
                        shuffle($random_img_student_1);
                        $data['img_type'] = '1';
                        $data['img_url'] = $random_img_student_1[0] . '.svg';

                        $this->db->where('student_id', $row['student_id']);
                        $this->db->update('student', $data);
                    } else {
                        shuffle($random_img_student_2);
                        $data['img_type'] = '1';
                        $data['img_url'] = $random_img_student_2[0] . '.svg';

                        $this->db->where('student_id', $row['student_id']);
                        $this->db->update('student', $data);
                    }
                }
            }


            //
        }

        if (!$this->db->table_exists('for_subscription')) {
            $this->db->query("CREATE TABLE `for_subscription` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `type` longtext DEFAULT NULL,
                `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
        }

        $for_subscription_prefix = $this->db->get_where('for_subscription', array('type' => 'prefix'))->row()->description;
        if ($for_subscription_prefix == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $for_subscription_prefix['type'] = 'prefix';
                $for_subscription_prefix['description'] = '_rc';
            } else {
                $for_subscription_prefix['type'] = 'prefix';
                $for_subscription_prefix['description'] = '_eliteskills';
            }
            $this->db->insert('for_subscription', $for_subscription_prefix);
        }

        $for_subscription_storage_space = $this->db->get_where('for_subscription', array('type' => 'storage_space'))->row()->description;
        if ($for_subscription_storage_space == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $for_subscription_prefix['type'] = 'storage_space';
                $for_subscription_prefix['description'] = '100';
            } else {
                $for_subscription_prefix['type'] = 'storage_space';
                $for_subscription_prefix['description'] = '10';
            }
            $this->db->insert('for_subscription', $for_subscription_prefix);
        }

        $for_subscription_first_subscription = $this->db->get_where('for_subscription', array('type' => 'first_subscription'))->row()->description;
        if ($for_subscription_first_subscription == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $for_subscription_first_subscription['type'] = 'first_subscription';
                $for_subscription_first_subscription['description'] = '2020-08-30 07:00:00';
            } else {
                $for_subscription_first_subscription['type'] = 'first_subscription';
                $for_subscription_first_subscription['description'] = '2022-06-16 11:17:27';
            }
            $this->db->insert('for_subscription', $for_subscription_first_subscription);
        }

        $for_subscription_started_in = $this->db->get_where('for_subscription', array('type' => 'started_in'))->row()->description;
        if ($for_subscription_started_in == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $for_subscription_started_in['type'] = 'started_in';
                $for_subscription_started_in['description'] = '2022-01-01 07:00:00';
            } else {
                $for_subscription_started_in['type'] = 'started_in';
                $for_subscription_started_in['description'] = '2022-06-16 11:17:27';
            }
            $this->db->insert('for_subscription', $for_subscription_started_in);
        }

        $for_subscription_expiry_date = $this->db->get_where('for_subscription', array('type' => 'expiry_date'))->row()->description;
        if ($for_subscription_expiry_date == null) {
            $prefix = $this->db->get_where('settings', array('type' => 'prefix'))->row()->description;
            if ($prefix == '_rc') {
                $for_subscription_expiry_date['type'] = 'expiry_date';
                $for_subscription_expiry_date['description'] = '2023-01-01 00:00:00';
            } else {
                $for_subscription_expiry_date['type'] = 'expiry_date';
                $for_subscription_expiry_date['description'] = '2023-06-17 00:00:00';
            }
            $this->db->insert('for_subscription', $for_subscription_expiry_date);
        }

        if (!$this->db->table_exists('booking_sessions')) {
            $this->db->query("CREATE TABLE `booking_sessions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `datetime` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `employee_id` int(11) DEFAULT NULL,
                `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                `confirmed` tinyint(4) NOT NULL DEFAULT 0,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('timeslot', 'booking_sessions')) {
            $this->db->query("ALTER TABLE `booking_sessions` ADD `timeslot` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('level', 'schedule')) {
            $this->db->query("ALTER TABLE `schedule` ADD `level` tinyint(4) DEFAULT NULL;");
        }

        if (!$this->db->field_exists('active', 'nationality')) {
            $this->db->query("ALTER TABLE `nationality` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        /*
          $center_type = $this->db->get_where('settings', array('type' => 'center_type'))->row()->description;
          if ($center_type == 'clinic') {
          $this->db->select("a.*");
          $this->db->from("employee a");
          $employee_all = $this->db->get()->result_array();

          foreach ($employee_all as $employee_all_row){
          $level_job = $this->db->get_where('job_title', array('job_title_id' => $employee_all_row['job_title_id']))->row()->level;
          if($level_job == 1 || $level_job == 2){

          $employee_schedule['class_id'] = $this->db->get_where('employee_classes', array('employee_id' => $employee_all_row['employee_id']))->row()->class_id;
          $employee_schedule['employee_id'] = $employee_all_row['employee_id'];
          $employee_schedule['level'] = $level_job;

          $employee_schedule['year'] = $this->db->get_where('settings', array('type' => 'running_year'))->row()->description;;
          //$employee_schedule['start_date'] = date("Y-m-d H:i:s");
          //$employee_schedule['end_date'] = date("Y-m-d H:i:s");

          $this->db->insert('schedule', $employee_schedule);
          }
          }
          }
         */

        if (!$this->db->field_exists('purpose_booking', 'booking_sessions')) {
            $this->db->query("ALTER TABLE `booking_sessions` ADD `purpose_booking` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('datetime', 'schedule_subject')) {
            $this->db->query("ALTER TABLE `schedule_subject` ADD `datetime` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->table_exists('user_records')) {
            $this->db->query("CREATE TABLE `user_records` (
            `user_records_id` int(11) NOT NULL AUTO_INCREMENT,
            `account_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `event` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_6` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_6` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value_7` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phrase_7` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_agent` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `ip_address` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` datetime DEFAULT NULL,
            PRIMARY KEY (`user_records_id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('logo_img', 'class')) {
            $this->db->query("ALTER TABLE `class` ADD `logo_img` varchar(100) DEFAULT NULL;");
        }

        if (!$this->db->field_exists('prefix', 'class')) {
            $this->db->query("ALTER TABLE `class` ADD `prefix` varchar(100) DEFAULT 'day_care';");
        }

        if (!$this->db->field_exists('status', 'payments_category')) {
            $this->dbforge->drop_table('payments_category');

            if (!$this->db->table_exists('payments_category')) {
                $this->db->query("CREATE TABLE `payments_category` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(250) DEFAULT NULL,
                `price` decimal(10,2) DEFAULT 0.00,
                `status` tinyint(4) NOT NULL DEFAULT 1,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `date_added` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
            }
        }

        if (!$this->db->field_exists('status', 'discount_category')) {
            $this->db->query("ALTER TABLE `discount_category` ADD `status` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('active', 'discount_category')) {
            $this->db->query("ALTER TABLE `discount_category` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('date_added', 'discount_category')) {
            $this->db->query("ALTER TABLE `discount_category` ADD `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('id', 'vat')) {

            $this->dbforge->drop_table('vat');

            if (!$this->db->table_exists('vat')) {
                $this->db->query("CREATE TABLE `vat` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                `vat` decimal(4,2) DEFAULT NULL,
                `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                `status` tinyint(4) NOT NULL DEFAULT 1,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }
        }

        if (!$this->db->field_exists('thread_code', 'invoice')) {

            $this->dbforge->drop_table('invoice');

            if (!$this->db->table_exists('vat')) {
                $this->db->query("CREATE TABLE `invoice` (
                `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
                `thread_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                `payments_category_id` int(11) DEFAULT NULL,
                `student_id` int(11) DEFAULT NULL,
                `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
                `discount_id_1` decimal(4,2) DEFAULT 0.00,
                `discount_amount_1` decimal(10,2) DEFAULT 0.00,
                `discount_id_2` decimal(4,2) DEFAULT 0.00,
                `discount_amount_2` decimal(10,2) DEFAULT 0.00,
                `discount_id_3` decimal(4,2) DEFAULT 0.00,
                `discount_amount_3` decimal(10,2) DEFAULT 0.00,
                `vat` decimal(4,2) DEFAULT 0.00,
                `amount` decimal(10,2) DEFAULT 0.00,
                `amount_paid` decimal(10,2) DEFAULT 0.00,
                `due` decimal(10,2) DEFAULT 0.00,
                `date_created` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `date_updated` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `payment_timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `payment_method` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `payment_details` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
                `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'paid or unpaid',
                `year` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                `tax_value` decimal(10,2) NOT NULL DEFAULT 0.00,
                `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00,
                `user_created` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `user_updated` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`invoice_id`)
              ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }
        }

        if (!$this->db->field_exists('thread_code', 'payment')) {

            $this->dbforge->drop_table('payment');

            if (!$this->db->table_exists('payment')) {
                $this->db->query("CREATE TABLE `payment` (
                `payment_id` int(11) NOT NULL AUTO_INCREMENT,
                `thread_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
                `expense_category_id` int(11) DEFAULT NULL,
                `payments_category_id` int(11) DEFAULT NULL,
                `title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `payment_type` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `invoice_id` int(11) DEFAULT NULL,
                `student_id` int(11) DEFAULT NULL,
                `method` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `amount` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
                `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`payment_id`)
              ) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }
        }

        if (!$this->db->table_exists('vbmapp_assessment_case')) {
            $this->db->query("CREATE TABLE `vbmapp_assessment_case` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `student_id` int(11) DEFAULT NULL,
                `assessment_id` int(11) DEFAULT NULL,
                `datetime_stamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
                `user_id` int(11) DEFAULT NULL,
                `student_age` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
                `recommendations` text COLLATE utf8_unicode_ci DEFAULT NULL,
                `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
                `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('vbmapp_assessment_mastered')) {
            $this->db->query("CREATE TABLE `vbmapp_assessment_mastered` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
                `student_id` int(11) DEFAULT NULL,
                `evaluation_axes_id` int(11) DEFAULT NULL,
                `main_goal_id` int(11) DEFAULT NULL,
                `level_main_goal` tinyint(4) DEFAULT NULL,
                `sub_goal_id` int(11) DEFAULT NULL,
                `degree` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
                `active` tinyint(4) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('class_id', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `class_id` int(11) NULL;");
        }

        if (!$this->db->table_exists('invoice_items')) {
            $this->db->query("CREATE TABLE `invoice_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `invoice_id` int(11) DEFAULT NULL,
            `payments_category_id` int(11) DEFAULT NULL,
            `payments_category_price` decimal(10,2) NOT NULL,
            `payments_category_quantity` int(11) DEFAULT NULL,
            `payments_category_total` decimal(10,2) NOT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('vbmapp_plane')) {
            $this->db->query("CREATE TABLE `vbmapp_plane` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
            `plan_size` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `date` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('vbmapp_plane_goal')) {
            $this->db->query("CREATE TABLE `vbmapp_plane_goal` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
            `vbmapp_plane_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `evaluation_axes_id` int(11) DEFAULT NULL,
            `main_goal_id` int(11) DEFAULT NULL,
            `sub_goal_id` int(11) DEFAULT NULL,
            `level_main_goal` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `date` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('date_added', 'class')) {
            $this->db->query("ALTER TABLE `class` ADD `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->table_exists('case_study')) {
            $this->db->query("CREATE TABLE `case_study` (
            `case_study_id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `arrange_the_child` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `number_of_individuals` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_age` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_age_birth_child` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_educational_level` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_work` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_age` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_educational_level` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_work` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_workplace` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_relatives` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relatives_disabilities` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relatives_disabilities_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_miscarriage` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_miscarriage_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_health_pregnancy` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_exposed_xrays` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_take_medication` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_take_medication_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_psychological_stress` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_psychological_stress_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `experienced_any_pregnancy` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `long_pregnancy` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `How_was_birth` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_weight_at_birth` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `length_child_at_birth` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_exposed` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `blood_transfusion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `blood_transfusion_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_cyanosis` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_cyanosis_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_need_oxygen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_need_oxygen_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `start_crawling` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `start_walking` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `use_hand_grip` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_stumble_walking` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `move_between_stand_and_sit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_seizures` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_seizures_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_seizures_now` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `symptoms` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `intensity` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `repetition` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medications_and_dosage` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `dislocation_or_fracture` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `dislocation_or_fracture_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `movement_disability` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `movement_disability_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `taken_physical_therapy` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `taken_physical_therapy_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `summary_physical_therapy` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_eat` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_eat_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_drink` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_drink_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `osteoporosis` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_control_defecation` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `use_bathroom` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `use_bathroom_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `wearing_his_clothes` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `wearing_his_clothes_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `cleaning_hands` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `cleaning_hands_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bathing` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bathing_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `brushing_teeth` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `brushing_teeth_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `level_self_care` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `babblement` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_word` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_sentence` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `language_disorders` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `express_himself` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `language_home` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `predominant_language_child` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `response_orders` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tradition` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_hearing` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_hearing_mor` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_organ_speech` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `difficulties_organ_speech_mor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `checking_hearing` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `checking_hearing_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_stopped_talking` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `old_when_stopped` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `the_reasons` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `help_to_speak` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `special_speech_services` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
            `long_training` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `result_training` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `response_care_tenderness` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_parents` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_siblings` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `participate_social_events` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `according_different_situations` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `play_games_natural` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `play_group_or_solitary` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `friends_likes_play` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `behavioral_problems` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `adjust_behavior` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `important_boosters` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `responding_directions` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planning_conducted` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planning_conducted_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sensitivity_something` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sensitivity_something_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `assistive_devices` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `assistive_devices_mor` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tests_applied` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `educational_services` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `additional_reviews` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_disease` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `surgery_student` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `surgery_student_mor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_medicine` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_medicine_mor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `vaccinated_student` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `vaccinated_student_mor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_medical_report` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_medical_report_mor` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_disease_mor` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
            `information_provider` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_create` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`case_study_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        $c_name = $this->db->get_where('settings', array('type' => 'c_name'))->row()->description;
        if ($c_name == null) {
            $data_c_name['type'] = 'c_name';
            $data_c_name['description'] = 'undefined';
            $this->db->insert('settings', $data_c_name);
        }

        if (!$this->db->table_exists('student_assessment')) {
            $this->db->query("CREATE TABLE `student_assessment` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `assessment_name` varchar(100) NOT NULL,
            `disability_id` int(11) DEFAULT NULL,
            `disability_level_id` int(11) DEFAULT 0,
            `datetime_stamp` datetime DEFAULT NULL,
            `active` char(1) DEFAULT '1',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_step_analysis_status')) {
            $this->db->query("CREATE TABLE `assessment_step_analysis_status` (
            `assessment_case_id` int(11) DEFAULT NULL,
            `assessment_id` int(11) DEFAULT NULL,
            `step_id` int(11) DEFAULT NULL,
            `analysis_id` int(11) DEFAULT NULL,
            `status` int(1) DEFAULT NULL,
            `analysis_performance_id` int(11) DEFAULT -1
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_step')) {
            $this->db->query("CREATE TABLE `assessment_step` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `assessment_id` int(11) NOT NULL,
            `genre_id` int(11) NOT NULL,
            `goal_id` int(11) NOT NULL,
            `step_name` varchar(500) DEFAULT NULL,
            `start_age` int(11) DEFAULT 0,
            `end_age` int(11) DEFAULT 0,
            `gender` int(11) DEFAULT 0,
            `specialty_id` int(11) DEFAULT 0,
            `active` char(1) DEFAULT '1',
            `private` int(1) DEFAULT 0,
            `step_measure` varchar(500) DEFAULT '',
            `lesson_prep` text DEFAULT NULL,
            `standard_group_no` int(11) DEFAULT 0,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_print')) {
            $this->db->query("CREATE TABLE `assessment_print` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `assessment_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `genres_id` varchar(200) DEFAULT '',
            `datetime_stamp` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_mastered')) {
            $this->db->query("CREATE TABLE `assessment_mastered` (
            `assessment_case_id` int(11) NOT NULL,
            `assessment_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `group_no` int(11) DEFAULT -1,
            `step_performance_id` int(11) DEFAULT -1
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_genre')) {
            $this->db->query("CREATE TABLE `assessment_genre` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `assessment_id` int(11) NOT NULL,
            `genre_name` varchar(500) NOT NULL,
            `active` char(1) DEFAULT '1',
            `category` varchar(50) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_case')) {
            $this->db->query("CREATE TABLE `assessment_case` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `assessment_id` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `student_age` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            `recommendations` varchar(1000) DEFAULT '',
            `notes` varchar(1000) DEFAULT '',
            `year` varchar(25) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('assessment_analysis')) {
            $this->db->query("CREATE TABLE `assessment_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `assessment_id` int(11) NOT NULL,
            `genre_id` int(11) NOT NULL,
            `goal_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `analysis_name` varchar(500) DEFAULT NULL,
            `active` char(1) DEFAULT '1',
            `student_id` int(11) DEFAULT NULL,
            `year` varchar(20) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `step_id` (`step_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('student_behaviour')) {
            $this->db->query("CREATE TABLE `student_behaviour` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(250) NOT NULL,
            `student_id` int(11) NOT NULL,
            `psychologist_id` int(11) DEFAULT NULL,
            `teacher_id` int(11) DEFAULT NULL,
            `speech_therapy_id` int(11) DEFAULT NULL,
            `section_manager_id` int(11) DEFAULT NULL,
            `specialist_vocational_id` int(11) DEFAULT NULL,
            `supervisor_id` int(11) DEFAULT NULL,
            `notes` text DEFAULT NULL,
            `actual_age` int(11) DEFAULT NULL,
            `mental_age` int(11) DEFAULT NULL,
            `plan_date` date DEFAULT NULL,
            `behaviour_define` text DEFAULT NULL,
            `behaviour_type` text DEFAULT NULL,
            `behaviour_place` text DEFAULT NULL,
            `behaviour_time` text DEFAULT NULL,
            `behaviour_cause` text DEFAULT NULL,
            `behaviour_occur_with_before` text DEFAULT NULL,
            `behaviour_occur_with_after` text DEFAULT NULL,
            `behaviour_occur_with` text DEFAULT NULL,
            `behaviour_student_like` text DEFAULT NULL,
            `behaviour_student_dont_like` text DEFAULT NULL,
            `behaviour_used_tech` text DEFAULT NULL,
            `behaviour_apply_results` text DEFAULT NULL,
            `behaviour_recommendations` text DEFAULT NULL,
            `active` int(11) DEFAULT 1,
            `user_id` int(11) NOT NULL,
            `datetime_stamp` datetime NOT NULL,
            `interpreter_line` varchar(100) DEFAULT '',
            `follow_up_date` date DEFAULT NULL,
            `year` varchar(20) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('student_behaviour_strategy')) {
            $this->db->query("CREATE TABLE `student_behaviour_strategy` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_behvaiour_id` int(11) NOT NULL,
            `note1` varchar(500) NOT NULL,
            `note2` varchar(500) NOT NULL,
            `note3` varchar(500) NOT NULL,
            `user_id` int(11) NOT NULL,
            `active` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('student_plan_steps')) {
            $this->db->query("CREATE TABLE `student_plan_steps` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            `step_progress` int(11) DEFAULT -1,
            PRIMARY KEY (`id`),
            KEY `plan_id` (`plan_id`),
            KEY `step_id` (`step_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('student_plan_analysis')) {
            $this->db->query("CREATE TABLE `student_plan_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `analysis_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            `analysis_progress` int(11) DEFAULT -1,
            PRIMARY KEY (`id`),
            KEY `plan_id` (`plan_id`),
            KEY `step_id` (`step_id`),
            KEY `analysis_id` (`analysis_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('student_plan')) {
            $this->db->query("CREATE TABLE `student_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `student_age` int(11) NOT NULL,
            `assessment_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `active` char(1) DEFAULT '1',
            `plan_name` varchar(200) DEFAULT '',
            `running_year` varchar(25) DEFAULT '',
            `year` varchar(20) DEFAULT '',
            `assessment_case_id` int(11) DEFAULT -1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('report_plan_steps')) {
            $this->db->query("CREATE TABLE `report_plan_steps` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `report_plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `response` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('report_plan_analysis')) {
            $this->db->query("CREATE TABLE `report_plan_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `report_plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `analysis_id` int(11) NOT NULL,
            `response` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('report_plan')) {
            $this->db->query("CREATE TABLE `report_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_id` int(11) NOT NULL,
            `assessment_id` int(11) NOT NULL,
            `student_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `report_type` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `active` int(1) DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('plan_summary_steps')) {
            $this->db->query("CREATE TABLE `plan_summary_steps` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_summary_id` int(11) NOT NULL,
            `genre_id` int(11) NOT NULL,
            `summary` text DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('plan_summary')) {
            $this->db->query("CREATE TABLE `plan_summary` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `plan_id` int(11) NOT NULL,
            `assessment_id` int(11) NOT NULL,
            `student_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `active` varchar(2) DEFAULT '1',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('monthly_plan_steps')) {
            $this->db->query("CREATE TABLE `monthly_plan_steps` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `monthly_plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `step_id` (`step_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('monthly_plan_analysis')) {
            $this->db->query("CREATE TABLE `monthly_plan_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `monthly_plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `analysis_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            PRIMARY KEY (`id`),
            KEY `monthly_plan_id` (`monthly_plan_id`),
            KEY `step_id` (`step_id`),
            KEY `analysis_id` (`analysis_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('monthly_plan')) {
            $this->db->query("CREATE TABLE `monthly_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `plan_id` int(11) NOT NULL,
            `month_id` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            `year` varchar(25) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('home_plan_analysis')) {
            $this->db->query("CREATE TABLE `home_plan_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `home_plan_id` int(11) NOT NULL,
            `step_id` int(11) NOT NULL,
            `analysis_id` int(11) NOT NULL,
            `training_procedures_id` int(11) DEFAULT NULL,
            `active` char(1) DEFAULT '1',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('home_plan')) {
            $this->db->query("CREATE TABLE `home_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `plan_id` int(11) NOT NULL,
            `month_id` int(11) NOT NULL,
            `datetime_stamp` datetime DEFAULT NULL,
            `user_id` int(11) NOT NULL,
            `active` char(1) DEFAULT '1',
            `year` varchar(25) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('course_subscribers')) {
            $this->db->query("CREATE TABLE `course_subscribers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `specialty` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('students_to_specialists')) {
            $this->db->query("CREATE TABLE `students_to_specialists` (
            `students_to_specialists_id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `employee_id` int(11) DEFAULT NULL,
            `class_id` int(11) DEFAULT NULL,
            `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            `date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `job_title_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`students_to_specialists_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('introduction_report', 'vbmapp_assessment_case')) {
            $this->db->query("ALTER TABLE `vbmapp_assessment_case` ADD `introduction_report` longtext COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->table_exists('section_schedule')) {
            $this->db->query("CREATE TABLE `section_schedule` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `section_id` int(11) NOT NULL,
            `start_date` date NOT NULL,
            `end_date` date NOT NULL,
            `year` varchar(10) NOT NULL,
            `active` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        }

        if (!$this->db->table_exists('section_schedule_subject')) {
            $this->db->query("CREATE TABLE `section_schedule_subject` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `schedule_id` int(11) NOT NULL,
            `subject_id` int(11) NOT NULL,
            `day_id` int(11) NOT NULL,
            `start_time` time NOT NULL,
            `end_time` time NOT NULL,
            `active` int(11) DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        }

        if (!$this->db->table_exists('attendance')) {
            $this->db->query("CREATE TABLE `attendance` (
            `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
            `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `class_id` int(11) DEFAULT NULL,
            `section_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `class_routine_id` int(11) DEFAULT NULL,
            `status` int(11) DEFAULT NULL,
            `reason_absence` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`attendance_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('course_id', 'course_subscribers')) {
            $this->db->query("ALTER TABLE `course_subscribers` ADD `course_id` int(11) NULL DEFAULT null;");
        }

        if (!$this->db->field_exists('institution', 'course_subscribers')) {
            $this->db->query("ALTER TABLE `course_subscribers` ADD `institution` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }


        if (!$this->db->field_exists('job_title', 'course_subscribers')) {
            $this->db->query("ALTER TABLE `course_subscribers` ADD `job_title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db3->table_exists('autism_screening_item')) {
            $this->db3->query("CREATE TABLE `autism_screening_item` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `item` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
            `degree` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('autism_screening_form_submit')) {
            $this->db->query("CREATE TABLE `autism_screening_form_submit` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `contact_type` tinyint(4) DEFAULT NULL,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }


        if (!$this->db->table_exists('autism_screening_form_record')) {
            $this->db->query("CREATE TABLE `autism_screening_form_record` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `form_submit_id` int(11) DEFAULT NULL,
            `item_id` int(11) DEFAULT NULL,
            `degree` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }


        if (!$this->db->table_exists('rating')) {
            $this->db->query("CREATE TABLE `rating` (
            `rating_id` int(11) NOT NULL AUTO_INCREMENT,
            `rate_info_id` int(11) NOT NULL,
            `rating` int(11) NOT NULL,
            PRIMARY KEY (`rating_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->db->field_exists('business_id', 'rating')) {

            $this->dbforge->drop_table('rating');

            if (!$this->db->table_exists('rating')) {
                $this->db->query("CREATE TABLE `rating` (
            `rating_id` int(11) NOT NULL AUTO_INCREMENT,
            `rate_info_id` int(11) NOT NULL,
            `rating` int(11) NOT NULL,
            PRIMARY KEY (`rating_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            }
        }

        if (!$this->db->table_exists('rate_info')) {
            $this->db->query("CREATE TABLE `rate_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `rate_name` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `rate_type` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `rate_for` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
            `rate_type_id` int(11) DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('last_updated', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` ADD `last_updated` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }


        if (!$this->db->table_exists('vbmapp_plane_analysis')) {
            $this->db->query("CREATE TABLE `vbmapp_plane_analysis` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
            `vbmapp_plane_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `evaluation_axes_id` int(11) DEFAULT NULL,
            `main_goal_id` int(11) DEFAULT NULL,
            `level_main_goal` int(11) DEFAULT NULL,
            `sub_goal_id` int(11) DEFAULT NULL,
            `skills_analysis_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('courses_taheelweb')) {
            $this->db->query("CREATE TABLE `courses_taheelweb` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'FTW/PTW',
            `lecturer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `article` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `tags` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `photo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish_site` tinyint(4) NOT NULL DEFAULT 1,
            `publish_testimonials` tinyint(4) NOT NULL DEFAULT 1,
            `publish_register_certificates` tinyint(4) NOT NULL DEFAULT 1,
            `number_visits` int(11) NOT NULL DEFAULT 0,
            `useful` int(11) NOT NULL DEFAULT 0,
            `not_useful` int(11) NOT NULL DEFAULT 0,
            `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        //verifycode
        if (!$this->db->field_exists('verifycode', 'employee')) {
            $this->db->query("ALTER TABLE `employee` ADD `verifycode` int(11) NOT NULL DEFAULT 0;");
        }

        if (!$this->db->field_exists('verifycode_status', 'employee')) {
            $this->db->query("ALTER TABLE `employee` ADD `verifycode_status` tinyint(4) NOT NULL DEFAULT 0;");
        }

        if (!$this->db->field_exists('active', 'online_exam_type')) {
            $this->db->query("ALTER TABLE `online_exam_type` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('active', 'online_exam')) {
            $this->db->query("ALTER TABLE `online_exam` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('photo', 'online_exam')) {
            $this->db->query("ALTER TABLE `online_exam` ADD `photo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('encrypt_thread', 'online_exam')) {
            $this->db->query("ALTER TABLE `online_exam` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('photo', 'question_bank')) {
            $this->db->query("ALTER TABLE `question_bank` ADD `photo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }
        if (!$this->db->field_exists('encrypt_thread', 'question_bank')) {
            $this->db->query("ALTER TABLE `question_bank` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('active', 'payment')) {
            $this->db->query("ALTER TABLE `payment` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }


        if (!$this->db->table_exists('file_manager')) {
            $this->db->query("CREATE TABLE `file_manager` (
            `file_manager_id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `file_name` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
            `display_name` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
            `file_size` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `file_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `folder_id` int(11) DEFAULT NULL,
            `createdOn` timestamp NULL DEFAULT current_timestamp(),
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`file_manager_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('file_manager_folder')) {
            $this->db->query("CREATE TABLE `file_manager_folder` (
            `file_manager_folder_id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `folder_parent_id` int(11) DEFAULT NULL,
            `file_name` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
            `display_name` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
            `createdOn` timestamp NOT NULL DEFAULT current_timestamp(),
            `file_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'folder',
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`file_manager_folder_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('subscribers_on_transport')) {
            $this->db->query("CREATE TABLE `subscribers_on_transport` (
            `subscribers_on_transport_id` int(11) NOT NULL AUTO_INCREMENT,
            `vehicle_id` int(11) NOT NULL,
            `area_id` int(11) NOT NULL,
            `class_id` int(11) DEFAULT NULL,
            `section_id` int(11) DEFAULT NULL,
            `student_id` int(11) NOT NULL,
            `year` longtext NOT NULL,
            `active` int(11) NOT NULL DEFAULT 1,
            PRIMARY KEY (`subscribers_on_transport_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }

        if (!$this->db->table_exists('subject')) {
            $this->db->query("CREATE TABLE `subject` (
            `subject_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `class_id` int(11) DEFAULT NULL,
            `job_title_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
            `level` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
            `icon` varchar(64) COLLATE utf8_unicode_ci DEFAULT '',
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`subject_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        //subject

        if (!$this->db->field_exists('active', 'subject')) {
            $this->db->query("ALTER TABLE `subject` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('active', 'payroll_category')) {
            $this->db->query("ALTER TABLE `payroll_category` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('active', 'expense_category')) {
            $this->db->query("ALTER TABLE `expense_category` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('class_id', 'payment')) {
            $this->db->query("ALTER TABLE `payment` ADD `class_id` int(11) NOT NULL;");
        }

        if (!$this->db->field_exists('active', 'admin')) {
            $this->db->query("ALTER TABLE `admin` ADD `active` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->field_exists('key_pass', 'admin')) {
            $this->db->query("ALTER TABLE `admin` ADD `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        //student_behaviour
        if (!$this->db->field_exists('encrypt_thread', 'student_behaviour')) {
            $this->db->query("ALTER TABLE `student_behaviour` ADD `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        if (!$this->db->field_exists('start_time', 'booking_sessions')) {
            $this->db->query("ALTER TABLE `booking_sessions` ADD `start_time` TIME NOT NULL AFTER `timeslot`, ADD `end_time` TIME NOT NULL AFTER `start_time`;");
        }

        if (!$this->db->field_exists('timeslot', 'schedule_subject')) {
            $this->db->query("ALTER TABLE `schedule_subject` ADD `timeslot` VARCHAR(50) NULL DEFAULT NULL AFTER `day_id`;");
        }

        if (!$this->db->field_exists('day_id', 'booking_sessions')) {
            $this->db->query("ALTER TABLE `booking_sessions` ADD `day_id` INT NULL DEFAULT NULL AFTER `datetime`;");
        }

        if (!$this->db->field_exists('country', 'course_subscribers')) {
            $this->db->query("ALTER TABLE `course_subscribers` ADD `country` VARCHAR(100) NULL DEFAULT NULL;");
        }

        //stusent_assessment_code
        if (!$this->db->field_exists('stusent_assessment_code', 'assessment_print')) {
            $this->db->query("ALTER TABLE `assessment_print` ADD `stusent_assessment_code` VARCHAR(100) NULL DEFAULT NULL;");
        }

        if ($this->db->field_exists('lesson_prep', 'assessment_step')) {
            $fields = array(
                'lesson_prep' => array(
                    'name' => 'lesson_prep',
                    'type' => 'MEDIUMTEXT',
                ),
            );
            $this->dbforge->modify_column('assessment_step', $fields);
        }

        if (!$this->db->field_exists('evaluation_mechanism', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `evaluation_mechanism` MEDIUMTEXT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('importance_goal', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `importance_goal` MEDIUMTEXT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('special_considerations', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `special_considerations` MEDIUMTEXT NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('assessment_taheelweb', 'student_assessment')) {
            $this->db->query("ALTER TABLE `student_assessment` ADD `assessment_taheelweb` tinyint(4) NOT NULL DEFAULT 0;");
        }

        if (!$this->db->field_exists('step_standard_taheelweb', 'step_standard')) {
            $this->db->query("ALTER TABLE `step_standard` ADD `step_standard_taheelweb` tinyint(4) NOT NULL DEFAULT 0;");
        }

        if ($this->db->field_exists('value', 'step_standard')) {
            $fields = array(
                'value' => array(
                    'name' => 'value',
                    'type' => 'decimal(4,2)',
                ),
            );
            $this->dbforge->modify_column('step_standard', $fields);
        }

        if (!$this->db->field_exists('allow_use', 'student_assessment')) {
            $this->db->query("ALTER TABLE `student_assessment` ADD `allow_use` tinyint(4) NOT NULL DEFAULT 1;");
        }

        if (!$this->db->table_exists('teacher_guide')) {
            $this->db->query("CREATE TABLE `teacher_guide` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `contact_type` tinyint(4) NOT NULL COMMENT '1-admin/2-teacher/3-parent',
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expiration_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('mailing_list_send')) {
            $this->db->query("CREATE TABLE `mailing_list_send` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email_list_id` int(11) DEFAULT NULL,
            `content_id` int(11) DEFAULT NULL,
            `sending_date` datetime DEFAULT NULL,
            `read_at` datetime DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }



        if (!$this->db->table_exists('mailing_list')) {
            $this->db->query("CREATE TABLE `mailing_list` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
            `subscription_status` tinyint(4) NOT NULL DEFAULT 1,
            `confirm` int(11) NOT NULL DEFAULT 0,
            `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `withdrawal_date` datetime DEFAULT NULL,
            `active` int(11) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=1932 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }




        if (!$this->db->field_exists('subscription_status', 'mailing_list')) {
            $this->db->query("ALTER TABLE `mailing_list` ADD `subscription_status` TINYINT NOT NULL DEFAULT '1' AFTER `email`;");
        }

        if (!$this->db->field_exists('withdrawal_date', 'mailing_list')) {
            $this->db->query("ALTER TABLE `mailing_list` ADD `withdrawal_date` DATETIME NULL DEFAULT NULL AFTER `date`;");
        }

        if (!$this->db->table_exists('mailing_list_content')) {
            $this->db->query("CREATE TABLE `mailing_list_content` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `categories_id` tinyint(4) DEFAULT NULL,
            `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `timestamp` datetime DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('mailing_list_campaign')) {
            $this->db->query("CREATE TABLE `mailing_list_campaign` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `template_id` int(11) DEFAULT NULL,
            `timestamp` datetime DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('has_been_sent', 'mailing_list_send')) {
            $this->db->query("ALTER TABLE `mailing_list_send` ADD `has_been_sent` TINYINT NOT NULL DEFAULT '0' AFTER `content_id`;");
        }

        if (!$this->db->field_exists('has_been_send', 'mailing_list_send')) {
            $this->db->query("ALTER TABLE `mailing_list_send` ADD `has_been_send` TINYINT NOT NULL DEFAULT '0' AFTER `content_id`;");
        }

        if (!$this->db->field_exists('campaign_id', 'mailing_list_send')) {
            $this->db->query("ALTER TABLE `mailing_list_send` ADD `campaign_id` INT NULL DEFAULT NULL AFTER `encrypt_thread`;");
        }

        if (!$this->db->field_exists('status_read', 'mailing_list_send')) {
            $this->db->query("ALTER TABLE `mailing_list_send` ADD `status_read` TINYINT NOT NULL DEFAULT '0' AFTER `sending_date`;");
        }

        if (!$this->db->field_exists('key_pass', 'technical_support')) {
            $this->db->query("ALTER TABLE `technical_support` ADD `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL;");
        }

        
        
        
        //fixed function git_log 
        //$this->db->truncate('git_log');
        //end
    }
}
