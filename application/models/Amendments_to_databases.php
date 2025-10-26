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

        if (!$this->db->field_exists('publish', 'metrics')) {
            $this->db->query("ALTER TABLE `metrics` ADD `publish` TINYINT NOT NULL DEFAULT '1' AFTER `name`;");
        }

        if ($this->db->field_exists('date_added', 'frontend_gallery')) {
            $this->db->query("ALTER TABLE `frontend_gallery` CHANGE `date_added` `date_added` VARCHAR(50) NULL DEFAULT NULL;");
        }

        if ($this->db->field_exists('timestamp', 'frontend_blog')) {
            $this->db->query("ALTER TABLE `frontend_blog` CHANGE `timestamp` `timestamp` VARCHAR(50) NULL DEFAULT NULL;");
        }

        if (!$this->db->table_exists('student_behavioural_list_boosters')) {
            $this->db->query("CREATE TABLE `student_behavioural_list_boosters` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `behaviour_id` int(11) DEFAULT NULL,
            `food` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `activities` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `games_and_tools` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `social_and_entertainment` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `moral` text COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('student_id', 'student_behavioural_list_boosters')) {
            $this->db->query("ALTER TABLE `student_behavioural_list_boosters` ADD `student_id` INT NULL DEFAULT NULL AFTER `behaviour_id`;");
        }

        if (!$this->db->field_exists('name_en', 'employee')) {
            $this->db->query("ALTER TABLE `employee` ADD `name_en` VARCHAR(100) NULL DEFAULT NULL AFTER `name`;");
        }

        if (!$this->db->table_exists('nutrition_plan')) {
            $this->db->query("CREATE TABLE `nutrition_plan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
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

        if (!$this->db->table_exists('nutrition_assessment')) {
            $this->db->query("CREATE TABLE `nutrition_assessment` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `nutrition_id` int(11) DEFAULT NULL,
            `diet` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_drug_interaction` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `allergy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `chronic_diseases` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `current_medication` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `goals` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `weight` decimal(5,2) DEFAULT NULL,
            `height` decimal(5,2) DEFAULT NULL,
            `bmi` decimal(5,2) DEFAULT NULL,
            `ideal_weight` decimal(5,2) DEFAULT NULL,
            `nutritional_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `nutrition_risk` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `calories_needed` decimal(6,2) DEFAULT NULL,
            `goals_of_nutritional_support` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `cho` decimal(6,2) DEFAULT NULL,
            `kcal` decimal(6,2) DEFAULT NULL,
            `fat` decimal(6,2) DEFAULT NULL,
            `protein` decimal(6,2) DEFAULT NULL,
            `fluid` decimal(6,2) DEFAULT NULL,
            `diet_order` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `duration` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `continue_diet` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `alternative_plan` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `nutritional_assessment_note` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `remarks_recommendations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('student_language', 'student')) {
            $this->db->query("ALTER TABLE `student` ADD `student_language` VARCHAR(100) NULL DEFAULT NULL AFTER `nationality_id`;");
        }

        if (!$this->db->table_exists('health_students_form')) {
            $this->db->query("CREATE TABLE `health_students_form` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `child_age` int(11) DEFAULT NULL,
            `child_birthdate` date DEFAULT NULL,
            `child_blood_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `chronic_diseases` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `epilepsy` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizure_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizure_symptoms` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medicine_allergy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `surgeries` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_scan` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_scan_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_scan_result` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `current_medications` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_allergy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `guardian_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `guardian_signature` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `form_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->db->field_exists('child_age', 'health_students_form')) {
            $this->db->query("ALTER TABLE `health_students_form` CHANGE `child_age` `child_age` VARCHAR(100) NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('last_updated', 'health_students_form')) {
            $this->db->query("ALTER TABLE `health_students_form` ADD `last_updated` VARCHAR(50) NULL DEFAULT NULL AFTER `form_date`;");
        }

        if (!$this->db->field_exists('duration_behavior', 'student_behaviour_reptitions')) {
            $this->db->query("ALTER TABLE `student_behaviour_reptitions` ADD `duration_behavior` VARCHAR(50) NULL DEFAULT NULL AFTER `reptition`;");
        }

        if (!$this->db->table_exists('email_tracking')) {
            $this->db->query("CREATE TABLE `email_tracking` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `campaign_id` int(11) DEFAULT NULL,
            `tracking_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `recipient_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `sent_at` datetime NOT NULL,
            `is_opened` tinyint(1) DEFAULT 0,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->db->field_exists('tracking_id', 'email_tracking')) {
            $this->db->query("ALTER TABLE `email_tracking` CHANGE `tracking_id` `tracking_id` VARCHAR(255) NULL DEFAULT NULL;");
        }

        if ($this->db->field_exists('recipient_email', 'email_tracking')) {
            $this->db->query("ALTER TABLE `email_tracking` CHANGE `recipient_email` `recipient_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }

        if ($this->db->field_exists('subject', 'email_tracking')) {
            $this->db->query("ALTER TABLE `email_tracking` CHANGE `subject` `subject` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
        }

        if (!$this->db->table_exists('case_study_dac')) {
            $this->db->query("CREATE TABLE `case_study_dac` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `mother_language` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_languages` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_education_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_occupation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_education_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_occupation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_members_count` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_order` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `previous_centers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `center_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `center_duration` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosed_before` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_time` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_place` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_symptoms` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `in_school` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `current_grade` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pregnancy_illness` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `illness_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medications_during_pregnancy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medications_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_or_psychological_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `issue_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `vitamins_during_pregnancy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_age_at_birth` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pregnancy_duration_months` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pregnancy_duration_days` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `anemia_during_pregnancy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `xray_exposure` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `fall_or_heavy_objects` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `health_issues_at_birth` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `health_issues_after_birth` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `jaundice` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `jaundice_duration` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `oxygen_issue` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `incubator` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `incubator_duration` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `vaccinations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `anemia` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `illness_or_accidents` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `visual_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `visual_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hearing_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hearing_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `physical_abnormalities` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `physical_abnormalities_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizures` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizures_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `surgeries` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `surgeries_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medications` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medications_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `rubella` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pollutants` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pollutants_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `fall_or_hit` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `fall_or_hit_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `epilepsy_seizures` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizure_duration` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizure_severity` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `epilepsy` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `immunity` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `genetic_disorders` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `genetic_disorders_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `disabled_children_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `parental_relationship` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `chronic_diseases` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `chronic_diseases_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `live_with_parents` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `alternative_family` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_care` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `caregivers_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `babbling` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `eye_contact` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_words_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `simple_sentence_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `crawling_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sitting_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `standing_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `walking_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_observations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `new_behavior_changes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `age_when_speaks` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `language_delay` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `spoken_words` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `repeated_behaviors` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pain_sensitivity` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `risk_awareness` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `favorite_hobbies` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `basic_needs_expression` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `tv_hours` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `ipad_or_mobile_hours` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `favorite_programs` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `gross_motor_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `fine_motor_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `cognitive_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hearing_test` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `vision_test` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_wave_test` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_wave_test_date` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `brain_wave_result` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mri_test` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mri_test_date` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mri_result` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `other_tests` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sleep_disorders` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `other_sleep_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sleep_hours` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `meal_consumption` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `spoon_grip` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `favorite_foods` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_allergies` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `allergic_foods` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `favorite_food` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `preferred_food` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `dietary_tests` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `dietary_test_results` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `independent_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `bathroom` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `wash_hands` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `change_clothes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `still_using_diaper` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_relationship_with_family` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_relationship_with_friends` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `social_adaptation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `reaction_to_other_children` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `activities_and_games` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `visual_communication` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `verbal_communication` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `repeats_sounds_words_sentences_imitation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `repeats_sounds_words_sentences_autonomous` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `understands_and_comprehends` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `responds_to_simple_instructions` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `answers_yes_no_questions` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `answers_wh_questions` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pronunciation_of_letters` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `pronunciation_of_words` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `incorrect_pronunciation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `response_to_reinforcers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `preferred_reinforcers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `current_communication_method` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `responds_to_instructions_from_mom_or_dad` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hyperactivity` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `attention_difficulty` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `aggressive_behavior` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `defiance_and_rejection` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `circling_around_objects` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `crying_without_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `rigid_routine_preference` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `uses_stereotyped_motion` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `side_looking` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_while_looking_at_tv_or_mobile` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `self_injury` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `likes_playing_with_water` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `other_behaviors` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `important_issues_to_be_addressed` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `specialist_notes_and_suggestions` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_create` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->db->field_exists('id', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` CHANGE `id` `case_study_id` INT(11) NOT NULL AUTO_INCREMENT;");
        }

        if (!$this->db->table_exists('case_study_acsncenter')) {
            $this->db->query("CREATE TABLE `case_study_acsncenter` (
            `case_study_id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `evaluator_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `evaluation_date` date DEFAULT NULL,
            `evaluator_job` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_birthdate` date DEFAULT NULL,
            `student_age` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_nationality` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_diagnosis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_problem_summary` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_status` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_age` int(11) DEFAULT NULL,
            `diagnosis_institution` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_result` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diagnosis_team_specializations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `applied_tests` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `psychological_tests` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `intelligence_tests` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `adaptive_behavior_tests` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medical_diagnosis` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medical_tests_results` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_age` int(11) DEFAULT NULL,
            `mother_age` int(11) DEFAULT NULL,
            `father_education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_education` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_job` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_job` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_relationship` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `siblings_count` int(11) DEFAULT NULL,
            `male_siblings_count` int(11) DEFAULT NULL,
            `female_siblings_count` int(11) DEFAULT NULL,
            `father_income` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_income` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_income` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_separated` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `has_disabled_family_member` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `disability_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_age_at_pregnancy` int(11) DEFAULT NULL,
            `pregnancy_duration` int(11) DEFAULT NULL,
            `pregnancy_order` int(11) DEFAULT NULL,
            `pregnancy_complications` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `complications_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `psychological_trauma` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_during_pregnancy` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_smoking` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_nutrition` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `miscarriage` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `miscarriage_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `delivery_difficulty` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `delivery_method` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `delivery_tools` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_injury_at_birth` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `oxygen_deficiency` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `child_cried_at_birth` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_weight` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_length` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `incubator` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `incubator_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `feeding_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `feeding_duration` int(11) DEFAULT NULL,
            `post_birth_issues` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `other_health_issues` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `blood_transfusion` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `blood_transfusion_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_or_swallowing_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_issues_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sleep_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sleep_issues_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `vaccinations_complete` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `allergy` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `allergy_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hearing_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `hearing_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `vision_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `vision_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `speech_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `speech_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `motor_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `motor_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizures` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `seizures_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `current_medications` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_reason` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_duration` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `babbling_age` int(11) DEFAULT NULL,
            `walking_age` int(11) DEFAULT NULL,
            `first_word_age` int(11) DEFAULT NULL,
            `sitting_age` int(11) DEFAULT NULL,
            `smiling_age` int(11) DEFAULT NULL,
            `sentence_age` int(11) DEFAULT NULL,
            `crawling_age` int(11) DEFAULT NULL,
            `loud_sounds_reaction_age` int(11) DEFAULT NULL,
            `imitation_age` int(11) DEFAULT NULL,
            `standing_age` int(11) DEFAULT NULL,
            `eye_contact_age` int(11) DEFAULT NULL,
            `following_commands_age` int(11) DEFAULT NULL,
            `abnormal_development` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `abnormal_development_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `regression` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `regression_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `school_enrollment` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `school_start_age` int(11) DEFAULT NULL,
            `appropriate_level` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `curriculum_match` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `curriculum_difference_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `education_place` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `academic_performance` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `shadow_teacher` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `automatic_promotion` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `anger_triggers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `anger_signs` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `anger_expression` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `unacceptable_behaviors` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_reaction` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `authoritative_person` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `unwanted_behavior_times` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diaper_day` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `diaper_day_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `diaper_night` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `diaper_night_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `toilet_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `toilet_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `bathing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bathing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `dressing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `dressing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `undressing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `undressing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `shoe_wearing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `shoe_wearing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `tooth_brushing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tooth_brushing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `face_washing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `face_washing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hand_washing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `hand_washing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `hair_brushing_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `hair_brushing_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_with_spoon_independence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_with_spoon_assistance` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_selectivity` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_selectivity_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_rejection` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `food_rejection_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_with_parents` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_with_siblings` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_with_relatives` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_with_nanny` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `interaction_with_peers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `behavior_with_strangers` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `behavior_in_public_places` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `behavior_in_social_visits` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `initiates_social_interaction` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `attention_seeking_behavior` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `behavior_when_likes_something` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `plays_games_correctly` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_speaking` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `can_express` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `can_request_with_word` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `can_request_with_sentence` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `answers_simple_questions` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `answers_complex_questions` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `has_speech_language_issues` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `speech_language_issues_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `imitates_vowels` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `imitates_simple_words` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `points_to_needs` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `imitates_delayed_speech` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `echolalia` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `non_verbal_communication` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `produces_stereotypical_sounds` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `reads_correctly` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `reading_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `writes_correctly` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `writing_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `performs_calculations_correctly` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `math_level` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `general_motor_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `fine_motor_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `gross_motor_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `balance_and_posture` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `visual_motor_coordination` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `has_unusual_motor_patterns` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `unusual_motor_patterns_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `feels_pain` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `feels_heat` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `responds_to_auditory_stimuli` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `responds_to_visual_stimuli` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `accepts_touch` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `smell_preference` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `smell_preference_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `covers_ears` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `clothing_preference` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `clothing_preference_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `avoids_certain_flavors` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `avoids_certain_colors` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `covers_eyes` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `texture_preference` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `texture_preference_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `likes_hugs` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `rejects_hugs` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `preferred_food_drinks` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `preferred_games_activities` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `preferred_songs` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `other_reinforcements` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_challenges` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_desired_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_strengths` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_expectations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_issues` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eating_issues_details` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (`case_study_id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('speech_language_assessment')) {
            $this->db->query("CREATE TABLE `speech_language_assessment` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `evaluation_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `referral_source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `report_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `referral_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `developmental_medical_history` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `assessment_tools` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `evaluation_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `speech_organs_assessment` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `prior_acquisitions_assessment` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `language_assessment` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `summary_diagnosis` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `recommendations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `updated_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if ($this->db->field_exists('value', 'step_standard')) {
            $this->db->query("ALTER TABLE `step_standard` CHANGE `value` `value` DECIMAL(5,2) NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('forms_and_reports_id', 'speech_language_assessment')) {
            $this->db->query("ALTER TABLE `speech_language_assessment` ADD `forms_and_reports_id` INT NULL DEFAULT NULL AFTER `id`;");
        }

        if (!$this->db->field_exists('forms_and_reports_submit_id', 'speech_language_assessment')) {
            $this->db->query("ALTER TABLE `speech_language_assessment` ADD `forms_and_reports_submit_id` INT NULL DEFAULT NULL AFTER `id`;");
        }


        if (!$this->db->table_exists('forms_and_reports_submit')) {
            $this->db->query("CREATE TABLE `forms_and_reports_submit` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `forms_and_reports_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('forms_and_reports')) {
            $this->db->query("CREATE TABLE `forms_and_reports` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `abbr` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `publish` tinyint(4) NOT NULL DEFAULT 1,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        $records = [
            [
                'abbr' => 'fsar',
                'name' => 'تقرير التقييم النطقي اللغوي',
                'publish' => 1,
                'active' => 1
            ],
            [
                'abbr' => 'bor',
                'name' => 'تقرير ملاحظة سلوكية',
                'publish' => 1,
                'active' => 1
            ],
            [
                'abbr' => 'pfcs',
                'name' => 'استمارة أولية لدراسة الحالة',
                'publish' => 1,
                'active' => 1
            ],
            [
                'abbr' => 'hfdac',
                'name' => 'الاستمارة الصحية',
                'publish' => 1,
                'active' => 1
            ],
            [
                'abbr' => 'cplr',
                'name' => 'تقرير مستوى الاداء الحالي للطالب',
                'publish' => 1,
                'active' => 1
            ],
        ];

        foreach ($records as $record) {
            // التحقق مما إذا كان السجل موجودًا بالفعل
            $this->db->where('abbr', $record['abbr']);
            $exists = $this->db->get('forms_and_reports')->row();

            // إذا لم يكن موجودًا، نقوم بإدخاله
            if (!$exists) {
                $this->db->insert('forms_and_reports', $record);
            }
        }

        if (!$this->db->table_exists('behavioral_observation_report')) {
            $this->db->query("CREATE TABLE `behavioral_observation_report` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `forms_and_reports_submit_id` int(11) DEFAULT NULL,
            `forms_and_reports_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `student_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `employee_id` int(11) DEFAULT NULL,
            `evaluation_date` date DEFAULT NULL,
            `referral_source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `report_date` date DEFAULT NULL,
            `referral_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `developmental_medical_history` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `evaluation_notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `recommendations` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `updated_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->field_exists('active', 'history_evaluation_employee')) {
            $this->db->query("ALTER TABLE `history_evaluation_employee` ADD `active` TINYINT NOT NULL DEFAULT '1' AFTER `date`;");
        }

        if (!$this->db->field_exists('active', 'evaluation_employee')) {
            $this->db->query("ALTER TABLE `evaluation_employee` ADD `active` TINYINT NOT NULL DEFAULT '1' AFTER `timestamp`;");
        }

        if (!$this->db->table_exists('case_study_form')) {
            $this->db->query("CREATE TABLE `case_study_form` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `student_age` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `employee_id` int(11) DEFAULT NULL,
            `number` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `registration_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `registrar_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `case_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_place` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `religion` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `nationality` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `national_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `housing_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `rent_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `disability_type` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `disability_degree` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_birth_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_education` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_job` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_work_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_phone` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_salary` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_extra_income` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `father_country` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_birth_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_country` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_education` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_job` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_work_address` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_salary` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `mother_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `family_members_count` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `married_members_count` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_order` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parents_relationship` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `disabled_members_count` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `associated_diseases` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_name_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `medication_reason_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `motor_ability` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `language_ability` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `life_skills` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `siblings_relationship` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_name_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_birth_date_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_education_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_marital_status_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_health_status_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `sibling_job_1` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `social_worker_recommendation` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('siblings')) {
            $this->db->query("CREATE TABLE `siblings` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `form_id` int(10) unsigned NOT NULL,
            `student_id` int(10) unsigned NOT NULL,
            `name` text COLLATE utf8_unicode_ci NOT NULL,
            `birth_date` date DEFAULT NULL,
            `education` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `marital_status` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `health_status` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `job` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('medications')) {
            $this->db->query("CREATE TABLE `medications` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `form_id` int(10) unsigned NOT NULL,
            `student_id` int(10) unsigned NOT NULL,
            `name` text COLLATE utf8_unicode_ci NOT NULL,
            `reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->field_exists('notes_and_directions', 'history_evaluation_employee')) {
            $this->db->query("ALTER TABLE `history_evaluation_employee` ADD `notes_and_directions` TEXT NULL DEFAULT NULL AFTER `employee_id`;");
        }

        if (!$this->db->field_exists('weight', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `weight` TEXT NULL DEFAULT NULL AFTER `specialist_notes_and_suggestions`;");
        }

        if (!$this->db->field_exists('height', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `height` TEXT NULL DEFAULT NULL AFTER `weight`;");
        }

        if (!$this->db->field_exists('medical_diagnosis', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `medical_diagnosis` TEXT NULL DEFAULT NULL AFTER `height`;");
        }

        if (!$this->db->field_exists('reason_referral', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `reason_referral` TEXT NULL DEFAULT NULL AFTER `medical_diagnosis`;");
        }

        if (!$this->db->field_exists('live_with_parents', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `live_with_parents` TEXT NULL DEFAULT NULL AFTER `reason_referral`;");
        }

        if (!$this->db->field_exists('alternative_family', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `alternative_family` TEXT NULL DEFAULT NULL AFTER `live_with_parents`;");
        }

        if (!$this->db->field_exists('care_provider', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `care_provider` TEXT NULL DEFAULT NULL AFTER `alternative_family`;");
        }

        if (!$this->db->field_exists('care_provider_others', 'case_study_dac')) {
            $this->db->query("ALTER TABLE `case_study_dac` ADD `care_provider_others` TEXT NULL DEFAULT NULL AFTER `care_provider`;");
        }

        $query = $this->db->get_where('frontend_settings', array('type' => 'social_links'));

        if ($query->num_rows() == 0) {
            $default_social_links = array(
                array(
                    'facebook' => '',
                    'twitter' => '',
                    'google_plus' => '',
                    'youtube' => '',
                    'instagram' => '',
                    'linkedin' => '',
                    'show' => ['facebook', 'twitter', 'youtube', 'instagram', 'linkedin'] // ✅ افتراضيًا كل الروابط ظاهرة
                )
            );

            $data_insert = array(
                'type' => 'social_links',
                'description' => json_encode($default_social_links, JSON_UNESCAPED_UNICODE)
            );

            $this->db->insert('frontend_settings', $data_insert);
        }

        if (!$this->db->table_exists('adaptive_behavior_domains')) {
            $this->db->query("CREATE TABLE `adaptive_behavior_domains` ( 
            `id` int(11) NOT NULL AUTO_INCREMENT, 
            `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
            `description` text COLLATE utf8_unicode_ci DEFAULT NULL, 
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            PRIMARY KEY (`id`) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('adaptive_behavior_subdomains')) {
            $this->db->query("CREATE TABLE `adaptive_behavior_subdomains` ( 
                `id` int(11) NOT NULL AUTO_INCREMENT, 
                `domain_id` int(11) NOT NULL, 
                `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
                `description` text COLLATE utf8_unicode_ci DEFAULT NULL, 
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                PRIMARY KEY (`id`), 
                INDEX `domain_id` (`domain_id`),
                FOREIGN KEY (`domain_id`) REFERENCES `adaptive_behavior_domains`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('adaptive_behavior_items')) {
            $this->db->query("CREATE TABLE `adaptive_behavior_items` ( 
            `id` int(11) NOT NULL AUTO_INCREMENT, 
            `domain_id` int(11) DEFAULT NULL, 
            `subdomain_id` int(11) NOT NULL, 
            `item_text` text COLLATE utf8_unicode_ci NOT NULL, 
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            PRIMARY KEY (`id`), 
            INDEX `subdomain_id` (`subdomain_id`),
            FOREIGN KEY (`subdomain_id`) REFERENCES `adaptive_behavior_subdomains`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('adaptive_behavior_responses')) {
            $this->db->query("CREATE TABLE `adaptive_behavior_responses` ( 
            `id` int(11) NOT NULL AUTO_INCREMENT, 
            `domain_id` int(11) DEFAULT NULL, 
            `subdomain_id` int(11) DEFAULT NULL, 
            `items_id` int(11) DEFAULT NULL, 
            `response_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
            `response_value` int(11) NOT NULL, 
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            PRIMARY KEY (`id`), 
            INDEX `items_id` (`items_id`),
            FOREIGN KEY (`items_id`) REFERENCES `adaptive_behavior_items`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('adaptive_behavior_user_responses')) {
            $this->db->query("CREATE TABLE `adaptive_behavior_user_responses` ( 
            `id` int(11) NOT NULL AUTO_INCREMENT, 
            `metrics_send_id` int(11) DEFAULT NULL, 
            `student_id` int(11) NOT NULL, 
            `question_id` int(11) NOT NULL, 
            `response_value` int(11) NOT NULL, 
            `user_id` int(11) DEFAULT NULL, 
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            PRIMARY KEY (`id`) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('current_performance_level_report')) {
            $this->db->query("CREATE TABLE `current_performance_level_report` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` int(11) DEFAULT NULL,
            `student_id` int(11) NOT NULL,
            `report_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `report_intro` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `field_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `field_content` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `employee_id` int(11) DEFAULT NULL,
            `report_recommendations` text COLLATE utf8_unicode_ci NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('current_performance_level_report_field')) {
            $this->db->query("CREATE TABLE `current_performance_level_report_field` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` int(11) DEFAULT NULL,
            `current_performance_level_report_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `field_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `field_content` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->field_exists('active', 'contact_email')) {
            $this->db->query("ALTER TABLE `contact_email` ADD `active` TINYINT NOT NULL DEFAULT '1' AFTER `user_id_reply`;");
        }

        if (!$this->db->field_exists('visit_subject', 'contact_email')) {
            $this->db->query("ALTER TABLE `contact_email` ADD `visit_subject` VARCHAR(100) NULL DEFAULT NULL AFTER `address`;");
        }

        if ($this->db->field_exists('timestamp', 'contact_email')) {
            $this->db->query("ALTER TABLE `contact_email` CHANGE `timestamp` `timestamp` VARCHAR(50) NULL DEFAULT NULL;");
        }

        if (!$this->db->field_exists('subtotal', 'invoice')) {
            $this->db->query("ALTER TABLE invoice ADD COLUMN subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `discount_amount_3`;");
        }

        if (!$this->db->field_exists('invoice_number', 'invoice')) {
            $this->db->query("ALTER TABLE `invoice` ADD `invoice_number` INT NULL DEFAULT NULL AFTER `invoice_id`;");
        }

        if (!$this->db->field_exists('tools_used', 'assessment_step')) {
            $this->db->query("ALTER TABLE assessment_step ADD COLUMN tools_used VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('educational_training', 'assessment_step')) {
            $this->db->query("ALTER TABLE assessment_step ADD COLUMN educational_training VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('enforcement_method', 'assessment_step')) {
            $this->db->query("ALTER TABLE assessment_step ADD COLUMN enforcement_method VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('assess_method', 'assessment_step')) {
            $this->db->query("ALTER TABLE assessment_step ADD COLUMN assess_method VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('sleep_hours', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN sleep_hours VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('medications', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN medications TEXT;");
        }

        if (!$this->db->field_exists('meals', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN meals TEXT;");
        }

        if (!$this->db->field_exists('unwanted_behaviors', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN unwanted_behaviors TEXT;");
        }

        if (!$this->db->field_exists('home_language', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN home_language VARCHAR(200) DEFAULT '';");
        }

        if (!$this->db->field_exists('child_vocabulary', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN child_vocabulary TEXT;");
        }

        if (!$this->db->field_exists('child_strengths', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN child_strengths TEXT;");
        }

        if (!$this->db->field_exists('family_order', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN family_order VARCHAR(50) DEFAULT '';");
        }

        if (!$this->db->field_exists('previous_surgeries', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN previous_surgeries TEXT;");
        }

        if (!$this->db->field_exists('child_routine', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN child_routine TEXT;");
        }

        if (!$this->db->field_exists('child_outings', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN child_outings TEXT;");
        }

        if (!$this->db->field_exists('child_preferred_activities', 'health_students_form')) {
            $this->db->query("ALTER TABLE health_students_form ADD COLUMN child_preferred_activities TEXT;");
        }

        if (!$this->db->field_exists('step_code', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `step_code` VARCHAR(50) NULL DEFAULT NULL AFTER `goal_id`;");
        }

        if (!$this->db->field_exists('admission_year', 'current_performance_level_report')) {
            $this->db->query("ALTER TABLE `current_performance_level_report` ADD `admission_year` VARCHAR(50) NULL DEFAULT NULL AFTER `report_title`;");
        }

        if (!$this->db->field_exists('printed_footer_class', 'class')) {
            $this->db->query("ALTER TABLE `class` ADD `printed_footer_class` TEXT NULL DEFAULT NULL AFTER `encrypt_thread`;");
        }

        if (!$this->db->table_exists('side_image_domains')) {

            // إنشاء الجداول
            $this->db->query("CREATE TABLE `side_image_domains` ( 
                `id` int(11) NOT NULL AUTO_INCREMENT, 
                `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
                `description` text COLLATE utf8_unicode_ci DEFAULT NULL, 
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                PRIMARY KEY (`id`) 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            $this->db->query("CREATE TABLE `side_image_subdomains` ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `domain_id` int(11) NOT NULL, 
        `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
        `description` text COLLATE utf8_unicode_ci DEFAULT NULL, 
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`id`), 
        INDEX `domain_id` (`domain_id`),
        FOREIGN KEY (`domain_id`) REFERENCES `side_image_domains`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            $this->db->query("CREATE TABLE `side_image_items` ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `domain_id` int(11) DEFAULT NULL, 
        `subdomain_id` int(11) NOT NULL, 
        `item_text` text COLLATE utf8_unicode_ci NOT NULL, 
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`id`), 
        INDEX `subdomain_id` (`subdomain_id`),
        FOREIGN KEY (`subdomain_id`) REFERENCES `side_image_subdomains`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            $this->db->query("CREATE TABLE `side_image_responses` ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `domain_id` int(11) DEFAULT NULL, 
        `subdomain_id` int(11) DEFAULT NULL, 
        `items_id` int(11) DEFAULT NULL, 
        `response_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
        `response_value` int(11) NOT NULL, 
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`id`), 
        INDEX `items_id` (`items_id`),
        FOREIGN KEY (`items_id`) REFERENCES `side_image_items`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            $this->db->query("CREATE TABLE `side_image_user_responses` ( 
        `id` int(11) NOT NULL AUTO_INCREMENT, 
        `metrics_send_id` int(11) DEFAULT NULL, 
        `student_id` int(11) NOT NULL, 
        `question_id` int(11) NOT NULL, 
        `response_value` int(11) NOT NULL, 
        `user_id` int(11) DEFAULT NULL, 
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
        PRIMARY KEY (`id`) 
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");

            $file_path = 'assets/csv/side_image.csv'; // المسار إلى ملف CSV
            $fp = fopen($file_path, 'r') or die("Can't open file");

            // تجاهل السطر الأول (الرؤوس) 
            $header = fgetcsv($fp);

            // مصفوفات لتخزين البيانات المستوردة
            $imported_data = array();

            while ($csv_line = fgetcsv($fp)) {
                $domain_name = trim($csv_line[0]); // المجال الرئيسي
                $subdomain_name = trim($csv_line[1]); // المجال الفرعي
                $item_text = trim($csv_line[1]); // نص البند
                $response_text = trim($csv_line[2]); // الاستجابة

                $response_value = trim($csv_line[3]);

                // 1️⃣ إدخال أو استرجاع ID المجال الرئيسي
                $domain = $this->db->get_where('side_image_domains', ['name' => $domain_name])->row();
                if (!$domain) {
                    $this->db->insert('side_image_domains', ['name' => $domain_name, 'created_at' => date("Y-m-d H:i:s")]);
                    $domain_id = $this->db->insert_id();
                } else {
                    $domain_id = $domain->id;
                }

                // 2️⃣ إدخال أو استرجاع ID المجال الفرعي
                $subdomain = $this->db->get_where('side_image_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id])->row();
                if (!$subdomain) {
                    $this->db->insert('side_image_subdomains', ['name' => $subdomain_name, 'domain_id' => $domain_id, 'created_at' => date("Y-m-d H:i:s")]);
                    $subdomain_id = $this->db->insert_id();
                } else {
                    $subdomain_id = $subdomain->id;
                }

                // 3️⃣ إدخال أو استرجاع ID البند
                $item = $this->db->get_where('side_image_items', ['item_text' => $item_text, 'subdomain_id' => $subdomain_id])->row();
                if (!$item) {
                    $this->db->insert('side_image_items', ['item_text' => $item_text,
                        'domain_id' => $domain_id,
                        'subdomain_id' => $subdomain_id,
                        'created_at' => date("Y-m-d H:i:s")]);
                    $item_id = $this->db->insert_id();
                } else {
                    $item_id = $item->id;
                }

                // 4️⃣ إدخال الاستجابات
                $response = $this->db->get_where('side_image_responses', ['response_text' => $response_text, 'items_id' => $item_id])->row();
                if (!$response) {
                    $this->db->insert('side_image_responses', [
                        'domain_id' => $domain_id,
                        'subdomain_id' => $subdomain_id,
                        'items_id' => $item_id,
                        'response_text' => $response_text, // حفظ النص بدون الرقم
                        'response_value' => $response_value,
                        'created_at' => date("Y-m-d H:i:s")
                    ]);
                }

                // إضافة البيانات إلى مصفوفة التأكيد
                $imported_data[] = [
                    'domain' => $domain_name,
                    'subdomain' => $subdomain_name,
                    'item' => $item_text,
                    'response' => $response_text,
                    'value' => $response_value
                ];
            }

            fclose($fp);
        }



        if (!$this->db->field_exists('special_code', 'assessment_step')) {
            $this->db->query("ALTER TABLE `assessment_step` ADD `special_code` VARCHAR(50) NULL DEFAULT NULL AFTER `assess_method`;");
        }

        if (!$this->db->table_exists('pre_language_assessment')) {
            $this->db->query("CREATE TABLE `pre_language_assessment` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` int(11) DEFAULT NULL,
            `forms_and_reports_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_age` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `attention_focus` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `attention_focus_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eye_contact` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eye_contact_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `motor_imitation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `motor_imitation_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_interaction` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_interaction_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `oral_imitation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `oral_imitation_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `vocal_imitation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `vocal_imitation_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pretend_play` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pretend_play_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_matching` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_matching_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_labels` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `object_labels_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `updated_at` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }


        if (!$this->db->table_exists('occupational_therapy_assessment')) {
            $this->db->query("CREATE TABLE `occupational_therapy_assessment` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` INT(11) DEFAULT NULL,
            `forms_and_reports_id` INT(11) DEFAULT NULL,
            `student_id` INT(11) DEFAULT NULL,
            `student_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `birth_date` DATE DEFAULT NULL,
            `diagnosis` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `evaluation_goals` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
            `student_age` VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,

            `eye_contact` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `eye_contact_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `visual_motor` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `visual_motor_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `ball_control` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `ball_control_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `spatial_temporal` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `spatial_temporal_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `classification_skills` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `classification_skills_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `dressing_skills` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `dressing_skills_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `reach_hanging` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `reach_hanging_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `carry_objects` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `carry_objects_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `bilateral_use` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `bilateral_use_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `spherical_grip` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `spherical_grip_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `two_hand_grip` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `two_hand_grip_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `tripod_grip` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tripod_grip_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `pencil_grip` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pencil_grip_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `puzzle_building` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `puzzle_building_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `scribbling` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `scribbling_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `tracing_model` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tracing_model_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `coloring_inside` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `coloring_inside_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `line_copying` VARCHAR(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `line_copying_note` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,

            `sensory_evaluation` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
            `tension_level` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
            `notes_recommendations` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
            `parent_notes` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,

            `encrypt_thread` VARCHAR(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` INT(11) DEFAULT NULL,
            `created_at` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `updated_at` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` TINYINT(1) DEFAULT 1,

            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        }

        if (!$this->db->table_exists('physical_therapy_assessment')) {
            $this->db->query("CREATE TABLE `physical_therapy_assessment` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `forms_and_reports_submit_id` INT(11) DEFAULT NULL,
            `forms_and_reports_id` INT(11) DEFAULT NULL,
            `student_id` INT(11) DEFAULT NULL,
            `student_age` VARCHAR(20) DEFAULT NULL,
            `user_id` INT(11) DEFAULT NULL,
            `encrypt_thread` VARCHAR(100) DEFAULT NULL,
            `medical_history` TEXT DEFAULT NULL,
            `associated_disabilities` TEXT DEFAULT NULL,
            `medical_interventions` TEXT DEFAULT NULL,
            `deformities` TEXT DEFAULT NULL,
            `trunk` VARCHAR(20) DEFAULT NULL,
            `trunk_spasticity_degree` VARCHAR(50) DEFAULT NULL,
            `upper_limbs` VARCHAR(20) DEFAULT NULL,
            `upper_limbs_spasticity_degree` VARCHAR(50) DEFAULT NULL,
            `lower_limbs` VARCHAR(20) DEFAULT NULL,
            `lower_limbs_spasticity_degree` VARCHAR(50) DEFAULT NULL,
            `muscle_tone_notes` TEXT DEFAULT NULL,
            `rom_shoulder_right` VARCHAR(10) DEFAULT NULL,
            `rom_elbow_right` VARCHAR(10) DEFAULT NULL,
            `rom_wrist_right` VARCHAR(10) DEFAULT NULL,
            `rom_shoulder_left` VARCHAR(10) DEFAULT NULL,
            `rom_elbow_left` VARCHAR(10) DEFAULT NULL,
            `rom_wrist_left` VARCHAR(10) DEFAULT NULL,
            `rom_hip_right` VARCHAR(10) DEFAULT NULL,
            `rom_knee_right` VARCHAR(10) DEFAULT NULL,
            `rom_ankle_right` VARCHAR(10) DEFAULT NULL,
            `rom_hip_left` VARCHAR(10) DEFAULT NULL,
            `rom_knee_left` VARCHAR(10) DEFAULT NULL,
            `rom_ankle_left` VARCHAR(10) DEFAULT NULL,
            `lift_head_back` VARCHAR(1) DEFAULT NULL,
            `lift_head_stomach` VARCHAR(1) DEFAULT NULL,
            `head_balance_sitting` VARCHAR(1) DEFAULT NULL,
            `roll_back_to_side` VARCHAR(1) DEFAULT NULL,
            `roll_back_to_stomach` VARCHAR(1) DEFAULT NULL,
            `sitting_cross` VARCHAR(1) DEFAULT NULL,
            `sitting_chair` VARCHAR(1) DEFAULT NULL,
            `transition_to_sit` VARCHAR(1) DEFAULT NULL,
            `balance_sitting` VARCHAR(1) DEFAULT NULL,
            `crawling` VARCHAR(1) DEFAULT NULL,
            `balance_creeping` VARCHAR(1) DEFAULT NULL,
            `kneel_stand` VARCHAR(1) DEFAULT NULL,
            `standing` VARCHAR(1) DEFAULT NULL,
            `independent_standing` VARCHAR(1) DEFAULT NULL,
            `transition_to_stand` VARCHAR(1) DEFAULT NULL,
            `balance_standing` VARCHAR(1) DEFAULT NULL,
            `assisted_walking` VARCHAR(1) DEFAULT NULL,
            `independent_walking` VARCHAR(1) DEFAULT NULL,
            `balance_walking` VARCHAR(1) DEFAULT NULL,
            `additional_notes` TEXT DEFAULT NULL,
            `created_at` DATETIME DEFAULT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            `active` TINYINT(1) DEFAULT 1,

            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
          ");
        }

        if (!$this->db->field_exists('anxiety_crying_triggers', 'case_study')) {
            $this->db->query("ALTER TABLE `case_study` ADD `anxiety_crying_triggers` TEXT NULL DEFAULT NULL AFTER `notes_recommendations_social_worker`;");
        }

        if (!$this->db->table_exists('warehouses')) {
            $this->db->query("CREATE TABLE `warehouses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `class_id` int(11) DEFAULT NULL,
            `is_main` tinyint(4) DEFAULT 0,
            `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('warehouse_items')) {
            $this->db->query("CREATE TABLE `warehouse_items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `category` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `unit` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'قطعة',
            `size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `min_quantity` int(11) DEFAULT 0,
            `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('warehouse_stock')) {
            $this->db->query("CREATE TABLE `warehouse_stock` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `warehouse_id` int(11) NOT NULL,
            `item_id` int(11) NOT NULL,
            `quantity` int(11) NOT NULL DEFAULT 0,
            `last_update` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `warehouse_item_unique` (`warehouse_id`, `item_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('warehouse_transactions')) {
            $this->db->query("CREATE TABLE `warehouse_transactions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `item_id` int(11) NOT NULL,
            `warehouse_id` int(11) NOT NULL,
            `transaction_type` ENUM('in','out','transfer','return') NOT NULL,
            `quantity` int(11) NOT NULL,
            `date` datetime DEFAULT CURRENT_TIMESTAMP,
            `source_warehouse_id` int(11) DEFAULT NULL, -- فقط للتحويل
            `target_warehouse_id` int(11) DEFAULT NULL, -- فقط للتحويل
            `reference` varchar(255) DEFAULT NULL, -- مثل رقم طلب أو اسم الطالب
            `notes` text,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('warehouse_categories')) {
            $this->db->query("CREATE TABLE `warehouse_categories` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
            `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

            // بيانات أولية
            $this->db->insert_batch('warehouse_categories', [
                ['name' => 'زي موحد – طلاب'],
                ['name' => 'زي موحد – موظفين'],
                ['name' => 'ألعاب تعليمية'],
                ['name' => 'وسائل تعليمية مطبوعة'],
                ['name' => 'بطاقات وصور توعوية'],
                ['name' => 'كتب ومناهج تعليمية'],
                ['name' => 'قرطاسية'],
                ['name' => 'أدوات علاج نطق'],
                ['name' => 'أدوات علاج وظيفي'],
                ['name' => 'أدوات علاج طبيعي'],
                ['name' => 'أدوات تقييم وتشخيص'],
                ['name' => 'أدوات تواصل بديل (AAC)'],
                ['name' => 'وسائل حسية / تنظيم حسّي'],
                ['name' => 'أجهزة ومواد طبية'],
                ['name' => 'مستهلكات طبية'],
                ['name' => 'أجهزة مساندة وتنقل'],
                ['name' => 'مواد تنظيف وتعقيم'],
                ['name' => 'أدوات تنظيف (مكانس، ممسحات...)'],
                ['name' => 'معدات النظافة'],
                ['name' => 'مواد ضيافة (قهوة، شاي...)'],
                ['name' => 'أدوات مطبخ / ضيافة'],
                ['name' => 'أثاث وتجهيزات'],
                ['name' => 'أجهزة كهربائية'],
                ['name' => 'أجهزة إلكترونية'],
                ['name' => 'أدوات صيانة وتشغيل'],
                ['name' => 'ملصقات وأعمال فنية'],
                ['name' => 'أدوات أنشطة مهنية / حياتية'],
            ]);
        }

        if (!$this->db->table_exists('warehouse_units')) {
            $this->db->query("CREATE TABLE `warehouse_units` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `symbol` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

            // بيانات أولية
            $this->db->insert_batch('warehouse_units', [
                ['name' => 'قطعة', 'symbol' => 'قطعة'],
                ['name' => 'علبة', 'symbol' => 'علبة'],
                ['name' => 'كرتونة', 'symbol' => 'كرتونة'],
                ['name' => 'مجموعة', 'symbol' => 'مج'],
                ['name' => 'متر', 'symbol' => 'م'],
                ['name' => 'سنتيمتر', 'symbol' => 'سم'],
                ['name' => 'لتر', 'symbol' => 'ل'],
                ['name' => 'ملليلتر', 'symbol' => 'مل'],
                ['name' => 'كيلوجرام', 'symbol' => 'كغ'],
                ['name' => 'جرام', 'symbol' => 'غم'],
                ['name' => 'مغلف', 'symbol' => 'مغ'],
                ['name' => 'رزمة', 'symbol' => 'رز'],
                ['name' => 'قارورة', 'symbol' => 'قارورة'],
                ['name' => 'أنبوب', 'symbol' => 'أنبوب'],
                ['name' => 'كيس', 'symbol' => 'كيس'],
                ['name' => 'صندوق', 'symbol' => 'صندوق'],
                ['name' => 'لفة', 'symbol' => 'لفة'],
                ['name' => 'لوح', 'symbol' => 'لوح'],
                ['name' => 'شريط', 'symbol' => 'شريط'],
                ['name' => 'بطارية', 'symbol' => 'بطارية'],
                ['name' => 'وحدة', 'symbol' => 'وحدة'],
                ['name' => 'صفحة', 'symbol' => 'ص'],
            ]);
        }

        if (!$this->db->table_exists('warehouse_suppliers')) {
            $this->db->query("CREATE TABLE `warehouse_suppliers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            `active` tinyint(1) DEFAULT 1,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->table_exists('warehouse_requests')) {
            $this->db->query("CREATE TABLE `warehouse_requests` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `requested_by` int(11) DEFAULT NULL,  -- القسم أو الموظف
            `class_id` int(11) DEFAULT NULL,  -- الفرع
            `status` ENUM('new','approved','rejected','completed') DEFAULT 'new',
            `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
            `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
        }

        if (!$this->db->field_exists('active', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `active` TINYINT(1) DEFAULT 1;");
        }

        if (!$this->db->field_exists('user_id', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `user_id` INT DEFAULT NULL;");
        }

        if (!$this->db->field_exists('request_id', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `request_id` INT DEFAULT NULL;");
        }

        if (!$this->db->field_exists('request_id', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD COLUMN `recipient_id` INT NULL AFTER `item_id`;");
        }

        if (!$this->db->field_exists('transaction_number', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `transaction_number` VARCHAR(10) UNIQUE AFTER `id`;");
        }

        if ($this->db->field_exists('transaction_type', 'warehouse_transactions')) {
            $this->db->query("
        ALTER TABLE `warehouse_transactions`
        MODIFY `transaction_type` ENUM('in','out','transfer-in','transfer-out','return','lost') 
        CHARACTER SET utf8 
        COLLATE utf8_unicode_ci 
        NOT NULL;
        ");
        }

        if (!$this->db->field_exists('returned_by', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `returned_by` INT NULL AFTER `user_id`;");
        }

        if (!$this->db->field_exists('reference_transaction_id', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `reference_transaction_id` INT NULL AFTER `transaction_type`;");
        }

        if (!$this->db->field_exists('receiver_id', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `receiver_id` INT NULL AFTER `request_id`;");
        }

        $fields = $this->db->list_fields('warehouse_transactions');
        if (!in_array('recipient_id', $fields)) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `recipient_id` INT NULL AFTER `user_id`;");
        }

        if (!$this->db->field_exists('reported_by', 'warehouse_transactions')) {
            $this->db->query("ALTER TABLE `warehouse_transactions` ADD `reported_by` INT NULL AFTER `user_id`;");
        }

        if (!$this->db->table_exists('external_clients')) {
            $this->db->query("CREATE TABLE `external_clients` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `full_name` VARCHAR(255) NOT NULL,
                `phone` VARCHAR(20),
                `email` VARCHAR(255),
                `national_id` VARCHAR(50),
                `notes` TEXT,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        $fields = $this->db->list_fields('invoice');
        if (!in_array('external_client_id', $fields)) {
            $this->db->query("ALTER TABLE `invoice` ADD `external_client_id` INT NULL DEFAULT NULL AFTER `student_id`;");
        }

        $fields = $this->db->list_fields('payment');
        if (!in_array('external_client_id', $fields)) {
            $this->db->query("ALTER TABLE `payment` ADD `external_client_id` INT NULL DEFAULT NULL AFTER `student_id`;");
        }


        $fields = $this->db->list_fields('invoice_items');

        if (!in_array('discount_percent', $fields)) {
            $this->db->query("ALTER TABLE `invoice_items` ADD `discount_percent` DECIMAL(10,2) NULL DEFAULT 0 AFTER `payments_category_quantity`;");
        }

        if (!in_array('price_after_discount', $fields)) {
            $this->db->query("ALTER TABLE `invoice_items` ADD `price_after_discount` DECIMAL(10,2) NULL DEFAULT 0 AFTER `discount_percent`;");
        }





        if (!$this->db->table_exists('iep_plans')) {

            $this->db->query("CREATE TABLE IF NOT EXISTS iep_plans (
        encrypt_thread VARCHAR(100),
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        plan_id INT NOT NULL,
        section_admission_date VARCHAR(50),
        plan_approval_date VARCHAR(50),
        plan_execution_date VARCHAR(50),
        parent_notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        active TINYINT(1) DEFAULT 1
    )");

            // جدول iep_plan_reviews
            $this->db->query("CREATE TABLE IF NOT EXISTS iep_plan_reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        iep_plans_id INT NOT NULL,
        plan_id INT NOT NULL,
        review_date DATE,
        active TINYINT(1) DEFAULT 1
    )");

            // جدول iep_plan_goals
            $this->db->query("CREATE TABLE IF NOT EXISTS iep_plan_goals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        iep_plans_id INT NOT NULL,
        plan_id INT NOT NULL,
        goal_id INT NOT NULL,
        strengths TEXT,
        weaknesses TEXT,
        active TINYINT(1) DEFAULT 1
    )");

            // جدول plan_steps
            $this->db->query("CREATE TABLE IF NOT EXISTS iep_plan_steps (
        id INT AUTO_INCREMENT PRIMARY KEY,
        iep_plans_id INT NOT NULL,
        plan_id INT NOT NULL,
        iep_plan_goals INT NOT NULL,
        goal_id INT NOT NULL,
        step_id INT NOT NULL,
        active TINYINT(1) DEFAULT 1
    )");

            // جدول plan_team
            $this->db->query("CREATE TABLE IF NOT EXISTS iep_plan_team (
        id INT AUTO_INCREMENT PRIMARY KEY,
        iep_plans_id INT NOT NULL,
        plan_id INT NOT NULL,
        special_education_teacher VARCHAR(255),
        speech_language_specialist VARCHAR(255),
        activity_music VARCHAR(255),
        activity_computer VARCHAR(255),
        activity_sport VARCHAR(255),
        activity_art VARCHAR(255),
        occupational_therapy_specialist VARCHAR(255),
        curriculum_head VARCHAR(255),
        department_head VARCHAR(255),
        active TINYINT(1) DEFAULT 1
    )");
        }

        if (!$this->db->table_exists('fcm_notification')) {
            $this->db->query("CREATE TABLE fcm_notification (
        id INT AUTO_INCREMENT,
        user_id INT(11) NOT NULL,
        user_type VARCHAR(20) DEFAULT 'employee',
        fcm_token VARCHAR(200) NOT NULL,
        active INT DEFAULT 1,
        created_time DATETIME,
        PRIMARY KEY(id)
        );");
        }

        if (!$this->db->table_exists('fcm_notification_queue')) {
            $this->db->query("CREATE TABLE fcm_notification_queue (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            user_type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            url VARCHAR(512),
            created_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;;");
        }

        if (!$this->db->table_exists('fcm_notification_history')) {
            $this->db->query("CREATE TABLE fcm_notification_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            user_type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            url VARCHAR(512),
            created_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            sent_time DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
            status INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists('fcm_notification_campaign')) {
            $this->db->query("CREATE TABLE `fcm_notification_campaign` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) DEFAULT NULL,
            `title` varchar(250) DEFAULT NULL,
            `message` varchar(500) DEFAULT NULL,
            `campaign_for` varchar(50) DEFAULT NULL,
            `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `active` tinyint(4) NOT NULL DEFAULT 1,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;");
        }

        $fields = $this->db->list_fields('fcm_notification_queue');

        if (!in_array('notification_campaign_id', $fields)) {
            $this->db->query("ALTER TABLE `fcm_notification_queue` ADD `notification_campaign_id` INT NULL DEFAULT NULL AFTER `id`;");
        }

        $fieldss = $this->db->list_fields('fcm_notification_history');

        if (!in_array('notification_campaign_id', $fieldss)) {
            $this->db->query("ALTER TABLE `fcm_notification_history` ADD `notification_campaign_id` INT NULL DEFAULT NULL AFTER `id`;");
        }
        
        if (!$this->db->table_exists('cars_domains')) {
            $this->db->query("CREATE TABLE `cars_domains` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(250) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists('cars_responses')) {
            $this->db->query("CREATE TABLE `cars_responses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `domain_id` int(11) DEFAULT NULL,
            `response_text` varchar(500) DEFAULT NULL,
            `response_value` tinyint(4) DEFAULT NULL,
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }        
        
        if (!$this->db->table_exists('cars_user_responses')) {
            $this->db->query("CREATE TABLE `cars_user_responses` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `metrics_send_id` int(11) DEFAULT NULL,
            `student_id` int(11) DEFAULT NULL,
            `question_id` int(11) DEFAULT NULL,
            `response_value` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }               
        
        
        
        
        
        
        
        
        

        /*
          function add_column_if_not_exists($table, $column, $definition) {
          $CI =& get_instance();
          $fields = $CI->db->list_fields($table);
          if (!in_array($column, $fields)) {
          $CI->db->query("ALTER TABLE `$table` ADD `$column` $definition;");
          }
          }
          add_column_if_not_exists('warehouse_transactions', 'recipient_id', 'INT NULL AFTER `user_id`');


          if (!$this->db->table_exists('aaaaaaaaaaaaa')) {
          $this->db->query("aaaaaaaaa");
          }

          if (!$this->db->field_exists('aaaaaa', 'frontend_blog')) {
          $this->db->query("aaaaa");
          }
         */

        //fixed function git_log 
        //$this->db->truncate('git_log');
        //end
    }
}
