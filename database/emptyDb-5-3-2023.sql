-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 06:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `absence_employees_counter`
--

CREATE TABLE `absence_employees_counter` (
  `absence_employees_counter_id` int(11) NOT NULL,
  `attendance_employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accountability_staff`
--

CREATE TABLE `accountability_staff` (
  `accountability_staff_id` int(11) NOT NULL,
  `type_accountability_staff` int(11) DEFAULT NULL,
  `date_accountability` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `describe_accountability` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_statement` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_statement` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_manager` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `excuse_case` int(11) DEFAULT 0,
  `opened_employee` int(11) NOT NULL DEFAULT 0,
  `answered` int(11) NOT NULL DEFAULT 0,
  `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_identity` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `educational_level` varchar(25) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `specializing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `city` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_number` longtext CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code_emergency_telephone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_telephone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_login` tinyint(4) NOT NULL DEFAULT 1,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'arabic',
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `identity_type`, `no_identity`, `job_title_id`, `class_id`, `educational_level`, `specializing`, `account_code`, `birthday`, `sex`, `nationality_id`, `city`, `region`, `street`, `building_number`, `country_code`, `phone`, `country_code_emergency_telephone`, `emergency_telephone`, `email`, `password`, `level`, `authentication_key`, `date_added`, `last_login`, `status_login`, `online`, `lang`, `encrypt_thread`) VALUES
(2, 'مديرة المركز', 'identity', '00000000', 1, 0, '4', 'تربية خاصة', '2018-fc9fe4b', '01/01/1990', 'انثى', 37, 'عمان', NULL, NULL, NULL, '', '0500000001', '', '', '0500000001@gmail.com', '4ff25c092c136aada8a7e4d6386a60ab0717c76a', NULL, NULL, '1515514694', '1674974687', 1, 0, 'arabic', '2fd9c81d-09ac-4b04-98bf-092c4ef1acb6');

-- --------------------------------------------------------

--
-- Table structure for table `all_files`
--

CREATE TABLE `all_files` (
  `id` int(11) NOT NULL,
  `path` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approvals_items_guardian`
--

CREATE TABLE `approvals_items_guardian` (
  `id` int(11) NOT NULL,
  `guardian` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area_management`
--

CREATE TABLE `area_management` (
  `area_management_id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `price` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_analysis`
--

CREATE TABLE `assessment_analysis` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `goal_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `analysis_name` varchar(500) DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  `student_id` int(11) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_case`
--

CREATE TABLE `assessment_case` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `student_age` int(11) NOT NULL,
  `active` char(1) DEFAULT '1',
  `recommendations` varchar(1000) DEFAULT '',
  `notes` varchar(1000) DEFAULT '',
  `year` varchar(25) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_genre`
--

CREATE TABLE `assessment_genre` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `genre_name` varchar(500) NOT NULL,
  `active` char(1) DEFAULT '1',
  `category` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_goal`
--

CREATE TABLE `assessment_goal` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `goal_name` varchar(500) NOT NULL,
  `active` char(1) DEFAULT '1',
  `level` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_mastered`
--

CREATE TABLE `assessment_mastered` (
  `assessment_case_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `group_no` int(11) DEFAULT -1,
  `step_performance_id` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_print`
--

CREATE TABLE `assessment_print` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `genres_id` varchar(200) DEFAULT '',
  `datetime_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_step`
--

CREATE TABLE `assessment_step` (
  `id` int(11) NOT NULL,
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
  `standard_group_no` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_step_analysis_status`
--

CREATE TABLE `assessment_step_analysis_status` (
  `assessment_case_id` int(11) DEFAULT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `step_id` int(11) DEFAULT NULL,
  `analysis_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `analysis_performance_id` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_routine_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `reason_absence` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_employee`
--

CREATE TABLE `attendance_employee` (
  `attendance_employee_id` int(11) NOT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `delay_minutes` int(11) DEFAULT 0,
  `excuse` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_excuse` int(11) DEFAULT NULL,
  `send_accountability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `categories_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `categories_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timeslot` varchar(255) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking_sessions`
--

CREATE TABLE `booking_sessions` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `timeslot` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purpose_booking` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_visit`
--

CREATE TABLE `book_visit` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `student_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visit_subject` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_study`
--

CREATE TABLE `case_study` (
  `case_study_id` int(11) NOT NULL,
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
  `date` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `chat_thread_code` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_status` int(11) DEFAULT NULL,
  `attached_file_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_contacts`
--

CREATE TABLE `chat_contacts` (
  `id` int(11) NOT NULL,
  `chat_thread_id` int(11) DEFAULT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_type` tinyint(4) DEFAULT NULL COMMENT '1 = private/ 2 = group',
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_thread`
--

CREATE TABLE `chat_thread` (
  `chat_thread_id` int(11) NOT NULL,
  `chat_thread_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `reciever` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `chat_type` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('50vnkg1os0nrkm9u704he900l1cqt2ur', '::1', 1677994716, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637373939343731363b757365725f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f69647c733a313a2231223b6c6f67696e5f757365725f69647c733a313a2231223b6e616d657c733a32303a22d8a7d8a8d8a7d8a120d8a7d8a8d98820d8b2d8b1223b6a6f625f7469746c655f69647c693a313b6c6f67696e5f747970657c733a31373a22746563686e6963616c5f737570706f7274223b6c616e67756167657c733a363a22617261626963223b736974655f6c616e677c733a363a22617261626963223b6c6173745f6c6f67696e7c733a31303a2231363736323534303039223b70616e656c5f7375706572757365727c733a313a2231223b6a6f625f7469746c655f6e616d657c733a31373a22746563686e6963616c5f737570706f7274223b63656e7465725f747970657c733a383a226461795f63617265223b635f6e616d657c733a393a22756e646566696e6564223b),
('dq28gplvd16t02iqtu86h62dh3oho8md', '::1', 1677994780, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637373939343731363b757365725f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f69647c733a313a2231223b6c6f67696e5f757365725f69647c733a313a2231223b6e616d657c733a32303a22d8a7d8a8d8a7d8a120d8a7d8a8d98820d8b2d8b1223b6a6f625f7469746c655f69647c693a313b6c6f67696e5f747970657c733a31373a22746563686e6963616c5f737570706f7274223b6c616e67756167657c733a363a22617261626963223b736974655f6c616e677c733a363a22617261626963223b6c6173745f6c6f67696e7c733a31303a2231363736323534303039223b70616e656c5f7375706572757365727c733a313a2231223b6a6f625f7469746c655f6e616d657c733a31373a22746563686e6963616c5f737570706f7274223b63656e7465725f747970657c733a383a226461795f63617265223b635f6e616d657c733a393a22756e646566696e6564223b),
('l4jelvntqrmu8ik3cg5udqssas1khq1n', '::1', 1677993214, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637373939333231343b757365725f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f6c6f67696e7c733a313a2231223b746563686e6963616c5f737570706f72745f69647c733a313a2231223b6c6f67696e5f757365725f69647c733a313a2231223b6e616d657c733a32303a22d8a7d8a8d8a7d8a120d8a7d8a8d98820d8b2d8b1223b6a6f625f7469746c655f69647c693a313b6c6f67696e5f747970657c733a31373a22746563686e6963616c5f737570706f7274223b6c616e67756167657c733a363a22617261626963223b736974655f6c616e677c733a363a22617261626963223b6c6173745f6c6f67696e7c733a31303a2231363736323534303039223b70616e656c5f7375706572757365727c733a313a2231223b6a6f625f7469746c655f6e616d657c733a31373a22746563686e6963616c5f737570706f7274223b63656e7465725f747970657c733a383a226461795f63617265223b635f6e616d657c733a393a22756e646566696e6564223b);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_numeric` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT 0,
  `section_manager_id` int(11) DEFAULT NULL,
  `start_working_hours` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_working_hours` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `logo_img` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'day_care',
  `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `name`, `name_numeric`, `capacity`, `section_manager_id`, `start_working_hours`, `end_working_hours`, `encrypt_thread`, `active`, `logo_img`, `prefix`, `date_added`) VALUES
(1, 'الفترة الصباحية', '01', 86, 0, '07:30', '11:55', 'fb0623ae-3784-4f08-a9d0-8be9cf703c2a', 1, NULL, 'day_care', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conditions_registration_form`
--

CREATE TABLE `conditions_registration_form` (
  `id` int(11) NOT NULL,
  `conditions` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_email`
--

CREATE TABLE `contact_email` (
  `contact_email_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `reply` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_timestamp` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id_reply` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_subscribers`
--

CREATE TABLE `course_subscribers` (
  `id` int(11) NOT NULL,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specialty` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_report`
--

CREATE TABLE `daily_report` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_day` date NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `year` varchar(20) DEFAULT '',
  `plan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_report_steps`
--

CREATE TABLE `daily_report_steps` (
  `id` int(11) NOT NULL,
  `daily_report_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance` varchar(30) DEFAULT '',
  `response` varchar(30) DEFAULT '',
  `evaluation` varchar(30) DEFAULT '',
  `educational_means` varchar(250) DEFAULT '',
  `analysis_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `daily_report_urgent`
--

CREATE TABLE `daily_report_urgent` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `report_day` date NOT NULL,
  `start_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `end_time` time NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `database_history`
--

CREATE TABLE `database_history` (
  `database_history_id` int(11) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `event` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `facilities` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disability`
--

CREATE TABLE `disability` (
  `id` int(11) NOT NULL,
  `disability_name` varchar(100) NOT NULL,
  `active` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `disability`
--

INSERT INTO `disability` (`id`, `disability_name`, `active`) VALUES
(1, 'إعاقة عقلية', 0),
(2, 'إعاقة جسمية', 0),
(3, 'إعاقة سمعية', 0),
(4, 'إعاقة بصرية', 0),
(5, 'اضطربات اللغة والكلام', 0),
(6, 'صعوبات التعلم', 0),
(7, 'اضطراب التوحد', 0),
(8, 'اضطراب سلوك', 0),
(9, 'اعاقه ذهنيه متوسطه', 0),
(10, 'تأخر حركي وفكري', 0),
(11, 'تأخر ذهني', 0),
(12, 'تأخر ذهني - تشتت انتباه', 0),
(13, 'تأخر ذهني -تعدد اعاقات', 0),
(14, 'تأخر ذهني – حركي', 0),
(15, 'تأخر ذهني بسبب ضمور في المخ', 0),
(16, 'تأخر ذهني شديد - صرع', 0),
(17, 'تأخر في النمو', 0),
(18, 'تأخر نمائي', 0),
(19, 'تأخر نمائي شامل', 0),
(20, 'تخلف عقلي', 0),
(21, 'تخلف عقلي شديد', 0),
(22, 'تخلف عقلي متوسط', 0),
(23, 'شلل دماغي', 0),
(24, 'متلازمة داون', 0),
(25, 'متلازمة برادرويلي', 0),
(26, 'غير محدد', 0);

-- --------------------------------------------------------

--
-- Table structure for table `disability_level`
--

CREATE TABLE `disability_level` (
  `id` int(11) NOT NULL,
  `disability_id` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discount_category`
--

CREATE TABLE `discount_category` (
  `discount_category_id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `discount_value` float NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_added` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `name` longtext DEFAULT NULL,
  `email` longtext DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `phone` longtext DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `profile` longtext DEFAULT NULL,
  `social_links` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `document_id` int(11) NOT NULL,
  `title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_type` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dormitory`
--

CREATE TABLE `dormitory` (
  `dormitory_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_room` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `effective_resignations_date`
--

CREATE TABLE `effective_resignations_date` (
  `effective_resignations_date_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `effective_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resignations_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `employee_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_identity` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_of_issue` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_expiry_identity` int(11) NOT NULL DEFAULT 0,
  `expiry_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `type_hiring` int(11) NOT NULL DEFAULT 0,
  `date_of_hiring` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `educational_level` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specializing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_birth` int(11) NOT NULL DEFAULT 0,
  `birthday` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `social_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_number` longtext CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `religion` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `blood_group` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code_emergency_telephone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_telephone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_links` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_on_website` int(11) DEFAULT 0,
  `level` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `practical_experiences` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_login` tinyint(4) NOT NULL DEFAULT 1,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `virtual` int(11) DEFAULT 0,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'arabic',
  `deleted` int(11) NOT NULL DEFAULT 0,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_activity` datetime DEFAULT NULL,
  `user_img` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_classes`
--

CREATE TABLE `employee_classes` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `enroll_id` int(11) NOT NULL,
  `enroll_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `roll` int(11) DEFAULT NULL,
  `date_added` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `eligibility_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_employee`
--

CREATE TABLE `evaluation_employee` (
  `evaluation_employee_id` int(11) NOT NULL,
  `history_evaluation_id` int(11) DEFAULT NULL,
  `evaluation_management_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `field_evaluation_id` int(11) DEFAULT NULL,
  `evaluation_items_id` int(11) DEFAULT NULL,
  `items_mark` int(11) DEFAULT NULL,
  `timestamp` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_employee_lookup`
--

CREATE TABLE `evaluation_employee_lookup` (
  `evaluation_employee_lookup_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evaluation_employee_lookup`
--

INSERT INTO `evaluation_employee_lookup` (`evaluation_employee_lookup_id`, `name`, `priority`) VALUES
(1, 'production_standards', 10),
(2, 'behavioral_standards', 20),
(3, 'personal_criteria', 30);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_items`
--

CREATE TABLE `evaluation_items` (
  `evaluation_items_id` int(11) NOT NULL,
  `evaluation_id` int(11) DEFAULT NULL,
  `field_evaluation_id` int(11) DEFAULT NULL,
  `evaluation_items` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_mark` int(11) DEFAULT NULL,
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evaluation_items`
--

INSERT INTO `evaluation_items` (`evaluation_items_id`, `evaluation_id`, `field_evaluation_id`, `evaluation_items`, `item_mark`, `user_id`, `date`) VALUES
(0, 5, 12, 'يركز على اتقان الطلبة للمهارات', 3, 'employee-37', '1549379768'),
(2, 4, 1, 'احترام الطلاب', 5, 'technical_support-1', '1535529553'),
(3, 4, 1, 'احترام الطلاب22222', 5, 'technical_support-1', '1535529566'),
(4, 5, 9, 'يلم بالمادة العلمية ويثريها', 3, 'employee-37', '1549376959'),
(5, 5, 9, 'يحرص على تطوير معارفه ومهاراته والمشاركة في الدورات', 2, 'employee-37', '1549377008'),
(6, 5, 9, 'يتابع كل ما يستجد في حقل تخصصه ', 2, 'employee-37', '1549377046'),
(7, 5, 9, 'يحرص على توظيف المعارف والمهارات في عمله ', 2, 'employee-37', '1549377121'),
(8, 5, 9, 'يستخدم لغة التواصل المناسبة للطالب', 1, 'employee-37', '1549377266'),
(9, 5, 10, 'يراعي استمرارية التحضير ومتابعة النماذج التربوية', 2, 'employee-37', '1549377803'),
(10, 5, 10, 'يختار استراتجيات التدريس المناسبة ', 3, 'employee-37', '1549377849'),
(11, 5, 10, 'ينوع الاهداف حسب مستوياتها', 2, 'employee-37', '1549377893'),
(12, 5, 10, 'يختار الاجراءات والانشطة التدريسيه المناسبة ', 3, 'employee-37', '1549377943'),
(13, 5, 11, 'ينمي مهارات التفكير العليا لدى الطلبة ', 5, 'employee-37', '1549379050'),
(14, 5, 11, 'يعد انشطة تطبيقية تلبي حاجات الطلبة ', 3, 'employee-37', '1549379087'),
(15, 5, 11, 'يراعي الفروق الفردية بانشطة علاجية واثرائية ', 3, 'employee-37', '1549379124'),
(16, 5, 11, 'يشجع المشاركة والتفاعل الايجابي', 3, 'employee-37', '1549379149'),
(17, 5, 11, 'يكشف عن التعلم القبلي', 2, 'employee-37', '1549379176'),
(18, 5, 11, 'ينمي القيم والاتجاهات الايمانية والايجابية ', 2, 'employee-37', '1549379223'),
(19, 5, 11, 'ينوع الاستراتيجيات والاساليب والانشطة ', 4, 'employee-37', '1549379262'),
(20, 5, 11, 'يوظف خبرات الطلبة في الموقف الصفي', 3, 'employee-37', '1549379357'),
(21, 5, 11, 'يغلق الموقف التعليمي بشكل مناسب', 3, 'employee-37', '1549379381'),
(22, 5, 11, 'يربط الخبرات المحسوسة بواقع وبيئة الطلبة الحياتية ', 2, 'employee-37', '1549379469'),
(23, 5, 12, 'يوظف المنحى الترابطي التكاملي بين المباحث الدراسية', 3, 'employee-37', '1549379572'),
(24, 5, 12, 'يوظف الاعمال الكتابية ويتابعها ', 2, 'employee-37', '1549379603'),
(25, 5, 12, 'ينظم السجلات التقويمية ', 2, 'employee-37', '1549379625'),
(26, 5, 12, 'يضع خطط علاجية ', 3, 'employee-37', '1549379680'),
(27, 5, 12, 'يحقق الطلبة مستوى التحصيل المطلوب', 5, 'employee-37', '1549379715'),
(28, 5, 12, 'يزود الطلبة بتغذية راجعة تطويرية ', 2, 'employee-37', '1549379742'),
(30, 5, 13, 'يساهم في النشاطات المدرسية بشكل فعال', 2, 'employee-37', '1549380396'),
(31, 5, 13, 'يقدم انشطة ومشاريع تعليمية وتربوية متكاملة تحسن اداء الطلبة ', 3, 'employee-37', '1549380447'),
(32, 5, 13, 'ينتج وسائل تعليمية نوعية', 2, 'employee-37', '1549380478'),
(33, 5, 14, 'يبادر ويقدم الافكار والاقتراحات لارتقاء بمستوى الطلبة ', 2, 'employee-37', '1549380647'),
(34, 5, 14, 'يظهر الحماس والرغبة في انجاز العمل', 1, 'employee-37', '1549380702'),
(35, 5, 14, 'يودي المهام بدافعية ذاتية دون الحاجة لاشراف المباشر', 2, 'employee-37', '1549380737'),
(36, 5, 15, 'يحسن تعامله مع زملائه ', 2, 'employee-37', '1549380799'),
(37, 5, 15, 'يتلف بالفاظ تربوية', 1, 'employee-37', '1549380820'),
(38, 5, 15, 'يؤثر ايجابيا في الاخرين ', 1, 'employee-37', '1549380846'),
(39, 5, 15, 'يحسن التواصل مع أولياء أمور الطلبة ', 2, 'employee-37', '1549380884'),
(40, 5, 15, 'يحسن التعامل مع الطلبة وحل مشكلاتهم ', 2, 'employee-37', '1549380923'),
(41, 5, 16, 'المحافظة على اوقات الدوام الرسمي والجدول والاشراف اليومي', 2, 'employee-37', '1549381220'),
(42, 5, 16, 'يستثمر الوقت لانجاز عمله داخل المركز', 2, 'employee-37', '1549381257'),
(43, 5, 16, 'ينفذ تعليمات الادارة والاشراف بجدية', 2, 'employee-37', '1549381291'),
(44, 5, 16, 'يتقبل المسؤوليات الاضافية', 1, 'employee-37', '1549381320'),
(45, 5, 16, 'يعمل بروح الفريق ويتعاون مع زملائه', 1, 'employee-37', '1549381340'),
(46, 5, 16, 'يهتم بالزي الرسمي للمركز ويراعي الشرع في لباسه ومظهره', 2, 'employee-37', '1549381378'),
(47, 6, 8, 'متابعة ترتيب الملفات الادارية والتربوية', 7, 'employee-37', '1549552424'),
(48, 6, 8, 'المحافظة على اوقات الدوام الرسمي والجدول والاشراف اليومي', 7, 'employee-37', '1549552450'),
(49, 6, 8, 'متابعة حضور المناوبة المكتبية والالتزام بالوقت', 7, 'employee-37', '1549552480'),
(59, 6, 8, 'متابعة حضور وغياب الحالات (الطلاب)', 7, 'employee-37', '1549553002'),
(60, 6, 8, 'الاهتمام بالمظهر الخارجي والزي الرسمي للعمل', 7, 'employee-37', '1549553019'),
(61, 6, 8, 'متابعة العمل على آلة التصوير', 7, 'employee-37', '1549553060'),
(62, 6, 8, 'متابعة العمل على آلة التغليف الحراري', 7, 'employee-37', '1549553090'),
(63, 6, 8, 'متابعة النظافة وترتيب مكان الورش (التدريب المهني)', 7, 'employee-37', '1549553109'),
(64, 6, 8, 'متابعة سجل احوال المكاتب للموظفين (ت)', 6, 'employee-37', '1549553137'),
(65, 6, 8, 'المسئولية في اغلاق اجهزة الحاسب الآلي و الآت التصوير والاضاة كل نهاية الدوام بشكل يومي', 5, 'employee-37', '1549553154'),
(66, 6, 8, 'القدرة على تطوير اساليب العمل', 5, 'employee-37', '1549553166'),
(67, 6, 17, 'السلوك العام (القدوة)', 4, 'employee-37', '1549553233'),
(68, 6, 17, 'تقدير المسئولية', 4, 'employee-37', '1549553251'),
(69, 6, 17, 'تقبل التوجيهات', 4, 'employee-37', '1549553332'),
(70, 6, 17, 'حسن التصرف', 4, 'employee-37', '1549553377'),
(71, 6, 18, 'الرؤساء', 3, 'employee-37', '1549553515'),
(72, 6, 18, 'الزملاء', 3, 'employee-37', '1549553527'),
(73, 6, 18, 'الطلاب', 3, 'employee-37', '1549553551'),
(74, 6, 18, 'العلاقة مع الاسر والزوار', 3, 'employee-37', '1549553572'),
(75, 7, 8, 'متابعة ترتيب الملفات الادارية والتربوية', 7, 'employee-37', '1549554351'),
(76, 7, 8, 'المحافظة على اوقات الدوام الرسمي والجدول والاشراف اليومي', 7, 'employee-37', '1549554367'),
(77, 7, 8, 'متابعة حضور المناوبة المكتبية والالتزام بالوقت', 7, 'employee-37', '1549554412'),
(78, 7, 8, 'متابعة حضور وغياب الحالات (الطلاب)', 7, 'employee-37', '1549554424'),
(79, 7, 8, 'الاهتمام بالمظهر الخارجي والزي الرسمي للعمل', 7, 'employee-37', '1549554436'),
(80, 7, 8, 'متابعة سير الجدول اليومي', 7, 'employee-37', '1549554459'),
(81, 7, 8, 'متابعة سير المناوبة اليومية', 7, 'employee-37', '1549554480'),
(82, 7, 8, 'متابعة النظافة وترتيب مكان الورش (التدريب المهني)', 7, 'employee-37', '1549554498'),
(83, 7, 8, 'متابعة سجل اعمال النظافة العامة', 6, 'employee-37', '1549554616'),
(84, 7, 8, 'المسئولية في اغلاق اجهزة الحاسب الآلي و الآت التصوير والاضاة كل نهاية الدوام بشكل يومي', 5, 'employee-37', '1549554628'),
(85, 7, 8, 'القدرة على تطوير اساليب العمل', 5, 'employee-37', '1549554636'),
(86, 7, 17, 'السلوك العام (القدوة)', 4, 'employee-37', '1549554658'),
(87, 7, 17, 'تقدير المسئولية', 4, 'employee-37', '1549554668'),
(88, 7, 17, 'تقبل التوجيهات', 4, 'employee-37', '1549554682'),
(89, 7, 17, 'حسن التصرف', 4, 'employee-37', '1549554694'),
(90, 7, 18, 'الرؤساء', 3, 'employee-37', '1549554707'),
(91, 7, 18, 'الزملاء', 3, 'employee-37', '1549554724'),
(92, 7, 18, 'الطلاب', 3, 'employee-37', '1549554744'),
(93, 7, 18, 'العلاقة مع الاسر والزوار', 3, 'employee-37', '1549554765'),
(97, 8, 8, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-37', '1549808607'),
(98, 8, 8, 'المحافظة على اوقات الدوام والجدول والاشراف اليومي', 7, 'employee-37', '1549808619'),
(99, 8, 8, 'متابعة ملفات الطلاب في جانب التقارير الطبية + التطعيمات ', 7, 'employee-37', '1549808681'),
(100, 8, 8, 'القدرة على متابعة النظافة العامة والخاصة للطلاب', 7, 'employee-37', '1549808735'),
(101, 8, 8, 'متابعة عمل الدورات التثقيفية والصحية والتوعوية للاسرة', 7, 'employee-37', '1549808829'),
(102, 8, 8, 'متابعة عمل الانشطة اللاصفية للطلاب', 7, 'employee-37', '1549808854'),
(103, 8, 8, 'متابعة الادوية والادوات الطبية بالعيادة', 7, 'employee-37', '1549808904'),
(104, 8, 8, 'القدرة على تنفيذ العمل الموكل اليه بشكل جيد', 6, 'employee-37', '1549808966'),
(105, 8, 8, 'القدرة على حل المشكلات ذات الصلة بالعمل ', 5, 'employee-37', '1549809071'),
(106, 8, 8, 'القدرة على التعامل مع ذوي الاحتياجات الخاصة', 5, 'employee-37', '1549809137'),
(107, 8, 17, 'السلوك العام ( القدوة )', 4, 'employee-37', '1549809168'),
(108, 8, 17, 'تقدير المسئولية', 4, 'employee-37', '1549809198'),
(109, 8, 17, 'تقبل التوجيهات ', 4, 'employee-37', '1549809213'),
(110, 8, 17, 'حسن التصرف', 4, 'employee-37', '1549809226'),
(111, 8, 18, 'الرؤساء', 3, 'employee-37', '1549809243'),
(112, 8, 18, 'الزملاء', 3, 'employee-37', '1549809252'),
(113, 8, 18, 'الطلاب', 3, 'employee-37', '1549809272'),
(114, 8, 18, 'اولياء الامور', 3, 'employee-37', '1549809292'),
(115, 8, 8, 'متابعة ترتيب ملفات الطبية والتقارير', 7, 'employee-37', '1549809355'),
(116, 9, 8, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-37', '1549809764'),
(117, 9, 8, 'المحافظة على اوقات الدوام والجدول والاشراف اليومي', 7, 'employee-37', '1549809773'),
(118, 9, 8, 'انجاز جميع الاعمال المتعلقة بالحاسب الآلي', 7, 'employee-37', '1549809810'),
(119, 9, 8, 'انجاز جميع الاعمال المتعلقة بالتصوير + التغليف الحراري', 7, 'employee-37', '1549809856'),
(120, 9, 8, 'انجاز جميع الاعمال المتعلقة بالفاكس + الطباعة', 7, 'employee-37', '1549809897'),
(121, 9, 8, 'ترتيب الملفات الادراية والتربوية بشكل منتظم', 7, 'employee-37', '1549809984'),
(122, 9, 8, 'ترتيب وتجديد نماذج ملفات الحالات', 7, 'employee-37', '1549810012'),
(123, 9, 8, 'متابعة الاشراف على اجهزة الحاسب + البروجكتر + الرسيفر + المكيف + النظافة بشكل دوري', 7, 'employee-37', '1549810081'),
(124, 9, 8, 'متابعة حضور الموظفين + الطلاب', 6, 'employee-37', '1549810109'),
(125, 9, 8, 'القدرة على التعامل مع ذوي الاحتياجات الخاصة', 5, 'employee-37', '1549810124'),
(126, 9, 8, 'متابعة السجلات الادارية ( الوقائع اليومية + حضور وغياب وقيد الطلاب )', 5, 'employee-37', '1549810302'),
(127, 9, 8, 'استقبال ضيوف المركز ', 4, 'employee-37', '1549810339'),
(128, 9, 17, 'السلوك العام ( القدوة )', 3, 'employee-37', '1549810353'),
(129, 9, 17, 'تقدير المسئولية', 3, 'employee-37', '1549810364'),
(130, 9, 17, 'تقبل التوجيهات ', 3, 'employee-37', '1549810377'),
(131, 9, 17, 'حسن التصرف', 3, 'employee-37', '1549810385'),
(132, 9, 18, 'الرؤساء', 3, 'employee-37', '1549810407'),
(133, 9, 18, 'الزملاء', 3, 'employee-37', '1549810416'),
(134, 9, 18, 'الطلاب', 3, 'employee-37', '1549810426'),
(135, 9, 18, 'اولياء الامور', 3, 'employee-37', '1549810440'),
(136, 10, 8, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-37', '1549810636'),
(137, 10, 8, 'متابعة الموظفين ( المعلمين + الاخصائيين + العاملين )', 7, 'employee-37', '1549810702'),
(138, 10, 8, 'متابعة ملفات الطلاب ', 7, 'employee-37', '1549810719'),
(139, 10, 8, 'متابعة الخطط الفردية واستمارات تقييم الحالات ', 7, 'employee-37', '1549810748'),
(140, 10, 8, 'متابعة الحالات بشكل مستمر', 7, 'employee-37', '1549810765'),
(141, 10, 8, 'متابعة الوسائل التعليمية ', 7, 'employee-37', '1549810790'),
(142, 10, 8, 'متابعة النظافة العامة ', 7, 'employee-37', '1549810811'),
(143, 10, 8, 'متابعة الاهداف مع اولياء الامور', 7, 'employee-37', '1549810842'),
(144, 10, 8, 'متابعة الجانب المهني ', 6, 'employee-37', '1549810858'),
(145, 10, 8, 'متابعة عهد المركز ', 5, 'employee-37', '1549810875'),
(146, 10, 8, 'متابعة السجلات الادارية ', 5, 'employee-37', '1549810897'),
(147, 10, 8, 'اجراء مقابلات التوظيف الشخصية ', 4, 'employee-37', '1549810920'),
(148, 10, 17, 'السلوك العام ( القدوة )', 3, 'employee-37', '1549810940'),
(149, 10, 17, 'تقدير المسئولية', 3, 'employee-37', '1549810955'),
(150, 10, 17, 'تقبل التوجيهات ', 3, 'employee-37', '1549810969'),
(151, 10, 17, 'حسن التصرف', 3, 'employee-37', '1549810979'),
(152, 10, 18, 'الرؤساء', 3, 'employee-37', '1549810999'),
(153, 10, 18, 'الزملاء', 3, 'employee-37', '1549811007'),
(154, 10, 18, 'الطلاب', 3, 'employee-37', '1549811018'),
(155, 10, 18, 'اولياء الامور', 3, 'employee-37', '1549811030'),
(156, 11, 8, 'استخدام لغة التواصل المناسبة للطلاب', 4, 'employee-37', '1549814734'),
(157, 11, 8, 'المحافظة على اوقات الدوام والجدول والاشراف اليومي', 7, 'employee-37', '1549814747'),
(158, 11, 8, 'مراعاة الفروق الفردية بين الطلاب ', 3, 'employee-37', '1549814771'),
(159, 11, 8, 'الاهتمام بتسليم الطلاب للموظفين عند حضورهم ', 7, 'employee-37', '1549814837'),
(160, 11, 8, 'التاكد بتسليم كل الطلاب لاولياء امورهم وعدم تسليمهم لأي شخص قبل التاكد من هويته ', 7, 'employee-37', '1549814993'),
(161, 11, 8, 'التاكد من غلق البوابه بشكل جيد', 7, 'employee-37', '1549815018'),
(162, 11, 8, 'اتباع طرق تعليم الطلاب الموجهة من قبل الموظف', 6, 'employee-37', '1549815055'),
(163, 11, 8, 'مغادرة المركز بعد خروج اخر طالب ', 7, 'employee-37', '1549815078'),
(164, 11, 8, 'الحضور مبكرا لاستقبال الطلاب ', 7, 'employee-37', '1549815101'),
(165, 11, 8, 'الاشراف على الباصات اثناء الدخول والخروج ', 7, 'employee-37', '1549815145'),
(166, 11, 8, 'الالتزام بالجلوس عند بوابة المركز طيلة وقت الدوام ', 5, 'employee-37', '1549815178'),
(168, 11, 17, 'السلوك العام ( القدوة )', 4, 'employee-37', '1549815226'),
(169, 11, 17, 'تقدير المسئولية', 4, 'employee-37', '1549815238'),
(170, 11, 17, 'تقبل التوجيهات ', 4, 'employee-37', '1549815252'),
(171, 11, 17, 'حسن التصرف', 4, 'employee-37', '1549815261'),
(172, 11, 18, 'الرؤساء', 3, 'employee-37', '1549815300'),
(173, 11, 18, 'الزملاء', 3, 'employee-37', '1549815309'),
(174, 11, 18, 'الطلاب', 3, 'employee-37', '1549815321'),
(175, 11, 18, 'اولياء الامور', 3, 'employee-37', '1549815334'),
(176, 11, 8, 'تنظيم حركة المرور عند المركز ', 5, 'employee-37', '1549815409'),
(177, 12, 8, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-37', '1549895396'),
(178, 12, 8, 'المحافظة على اوقات الدوام والجدول والاشراف اليومي', 7, 'employee-37', '1549895425'),
(179, 12, 8, 'انجاز جميع جميع الاعمال بالفاكس', 7, 'employee-37', '1549895506'),
(180, 12, 8, 'الاشراف على المربيات والنظافة بشكل دوري', 7, 'employee-37', '1549895761'),
(181, 12, 8, 'متابعة السجلات المسئولة عنها', 7, 'employee-37', '1549895815'),
(182, 12, 8, 'زيارة الفصول ومتابعة المعلمات والاخصائيات بشكل دوري ', 7, 'employee-37', '1549895862'),
(183, 12, 8, 'متابعة الصيانه للمركز ', 6, 'employee-37', '1549895888'),
(184, 12, 8, 'ترتيب الملفات الاداريه + التربويه وجميع الملفات بشكل منتظم', 6, 'employee-37', '1549895975'),
(185, 12, 8, 'متابعة الجانب المهني للحالات', 6, 'employee-37', '1549896017'),
(186, 12, 8, 'الاشراف على مهام السكرتاريا ومساعديها والاخصائية الاجتماعية والممرضة بشكل دوري ', 6, 'employee-37', '1549896084'),
(187, 12, 8, 'القدرة على تطوير اساليب العمل وحضور ورش العمل', 6, 'employee-37', '1549896122'),
(188, 12, 17, 'السلوك العام ( القدوة )', 4, 'employee-37', '1549896210'),
(189, 12, 17, 'تقدير المسئولية', 4, 'employee-37', '1549896221'),
(192, 12, 18, 'الرؤساء', 3, 'employee-37', '1549896258'),
(193, 12, 18, 'الزملاء', 3, 'employee-37', '1549896273'),
(194, 12, 18, 'الطلاب', 3, 'employee-37', '1549896286'),
(195, 12, 18, 'اولياء الامور', 3, 'employee-37', '1549896308'),
(196, 13, 8, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-37', '1549896499'),
(197, 13, 8, 'المحافظة على اوقات الدوام والجدول والاشراف اليومي', 7, 'employee-37', '1549896510'),
(198, 13, 8, 'مراعاة الفروق الفردية بين الطلاب ', 6, 'employee-37', '1549896526'),
(199, 13, 8, 'العناية بنظافة المكاتب والفصول والاداره', 7, 'employee-37', '1549896549'),
(200, 13, 8, 'العناية بنظافة دورات المياه ', 7, 'employee-37', '1549896572'),
(201, 13, 8, 'العناية الشخصية بكل طالب يوميا ', 7, 'employee-37', '1549896595'),
(202, 13, 8, 'العناية باتباع اساليب الصحة والسلامة عند تنظيف الطلاب ', 7, 'employee-37', '1549896622'),
(203, 13, 8, 'العناية بتنظيف الاجهزه والوسائل التعليميه ', 7, 'employee-37', '1549896651'),
(204, 13, 8, 'اتباع طرق تعليم الطلاب الموجهة من قبل الموظف', 6, 'employee-37', '1549896665'),
(205, 13, 8, 'الاهتمام باستقبال الطالب عند حضوره وتسليمه عند انصرافه ', 6, 'employee-37', '1549896751'),
(206, 13, 8, 'متابعة الفصول عند انتهاء الدوام من حيث التكييف + الاضاءة + السخان', 5, 'employee-37', '1549896820'),
(207, 13, 17, 'السلوك العام ( القدوة )', 4, 'employee-37', '1549896832'),
(208, 13, 17, 'تقدير المسئولية', 4, 'employee-37', '1549896870'),
(209, 13, 17, 'تقبل التوجيهات ', 4, 'employee-37', '1549896895'),
(210, 13, 17, 'حسن التصرف', 4, 'employee-37', '1549896910'),
(211, 13, 18, 'الرؤساء', 3, 'employee-37', '1549896930'),
(214, 13, 18, 'الزملاء', 3, 'employee-37', '1549897122'),
(216, 13, 18, 'اولياء الامور', 3, 'employee-37', '1549897151'),
(219, 14, 2, 'المحافظة على أوقات الدوام والجداول والإشراف اليومي ', 7, 'employee-3', '1577001468'),
(220, 14, 2, 'تنفيذ المهام المطلوبة في الوقت المحدد', 7, 'employee-3', '1577001541'),
(221, 14, 2, 'القدرة على تطوير اساليب العمل والمبادرة والابداع(حضور ورش العمل وأظهار الحماس والرغبة في انجاز العمل وتأدية المهام بدافعية ذاتية)', 6, 'employee-3', '1577165957'),
(222, 14, 2, 'متابعة الملفات / خطط / تقارير / واجبات / تقاييم الحالات بشكل منتظم ', 7, 'employee-3', '1577166126'),
(223, 14, 2, 'العناية بنظافة وترتيب وتنسيق المكتب', 5, 'employee-3', '1577166179'),
(224, 14, 2, 'مراعاة الفروق الفردية / استخدام لغة التواصل المناسبة للحالات', 7, 'employee-3', '1577166314'),
(225, 14, 2, 'متابعة مستوى تحصيل الطلاب ومدى استفادتهم وتقدمهم ورضى الاسرة في تقدم الحالة', 7, 'employee-3', '1577166583'),
(226, 14, 2, 'إعداد الانشطة الاجتماعية (الخارجية - الداخلية - الرحلات )', 7, 'employee-3', '1577166745'),
(227, 14, 7, 'متابعة الحالات من خلال الاسر (الزيارات المنزلية - مقابلات - اتصالات - دفتر التواصل)', 7, 'employee-3', '1577166913'),
(228, 14, 2, 'تفعيل معرض الاجتماعي للمركز (بروشورات -مجلات - عرض مواهب الطلاب)', 7, 'employee-3', '1577167021'),
(229, 14, 2, 'إعداد برامج ارشادية اجتماعية تثقيفية للاسر', 5, 'employee-3', '1577167122'),
(230, 14, 4, 'اتباع إجراءات وسياسات المركز (السلوك العام)', 4, 'employee-3', '1577264168'),
(231, 14, 4, 'تقدير المسئولية', 4, 'employee-3', '1577264211'),
(232, 14, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577264250'),
(233, 14, 4, 'التعاون مع فريق العمل', 4, 'employee-3', '1577264302'),
(234, 14, 3, 'الرؤساء ', 3, 'employee-3', '1577264343'),
(235, 14, 3, 'الزملاء', 3, 'employee-3', '1577264625'),
(236, 14, 3, 'الطلاب', 3, 'employee-3', '1577264648'),
(237, 14, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577264687'),
(238, 15, 2, 'المحافظة على أوقات الدوام والجداول والإشراف اليومي ', 6, 'employee-3', '1577264936'),
(239, 15, 2, 'تنفيذ المهام المطلوبة في الوقت المحدد', 6, 'employee-3', '1577264963'),
(240, 15, 2, 'القدرة على تطوير اساليب العمل والمبادرة والابداع (حضور ورش العمل وأظهار الحماس والرغبة في انجاز العمل وتأدية المهام بدافعية ذاتية ', 6, 'employee-3', '1577264990'),
(241, 15, 2, 'العناية بنظافة وترتيب وتنسيق المكتب', 6, 'employee-3', '1577265105'),
(242, 15, 2, 'متابعة الملفات / خطط / تقارير / واجبات / تقاييم الحالات بشكل منتظم ', 6, 'employee-3', '1577265136'),
(243, 15, 2, 'مراعاة الفروق الفردية / استخدام لغة التواصل المناسبة للحالات', 6, 'employee-3', '1577265160'),
(244, 15, 2, 'متابعة مستوى تحصيل الطلاب ومدى استفادتهم وتقدمهم ورضى الاسرة في تقدم الحالة', 6, 'employee-3', '1577265219'),
(245, 15, 2, 'المهارة في عرض الهدف وإدارة الجلسة بطريقة تربوية', 6, 'employee-3', '1577265281'),
(246, 15, 2, 'العناية بمذكرة التواصل اليومي الخاص بالحالة', 6, 'employee-3', '1577265330'),
(247, 15, 2, 'تفعيل الوسائل التعليمية التأهيلية المناسبة لقدرات الحالات وتنويع الاساليب والاستراتيجيات ', 6, 'employee-3', '1577265435'),
(248, 15, 2, 'المساهمة في متابعة الحالات خلال الانشطة اللاصفية', 6, 'employee-3', '1577265490'),
(249, 15, 2, 'تقديم التوصيات لتحسين إداء الحالات (عمل ورش لفريق العمل - تقديم توصيات فردية)', 6, 'employee-3', '1577265579'),
(250, 15, 4, 'إتباع إجراءات وسياسات المركز (السلوك العام)', 4, 'employee-3', '1577265682'),
(251, 15, 4, 'تقدير المسئولية', 4, 'employee-3', '1577265706'),
(252, 15, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577265722'),
(253, 15, 4, 'التعاون مع فريق العمل', 4, 'employee-3', '1577265745'),
(254, 15, 3, 'الرؤساء ', 3, 'employee-3', '1577265768'),
(255, 15, 3, 'الزملاء', 3, 'employee-3', '1577265852'),
(256, 15, 3, 'الطلاب', 3, 'employee-3', '1577265899'),
(257, 15, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577265955'),
(258, 13, 3, 'الطلاب', 3, 'employee-3', '1577772491'),
(259, 12, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577943499'),
(260, 12, 4, 'حسن التصرف', 4, 'employee-3', '1577943523'),
(261, 17, 7, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-3', '1577944000'),
(262, 17, 2, 'متابعة الموظفات ', 7, 'employee-3', '1577944089'),
(263, 17, 2, 'متابعة ملفات الطلاب', 7, 'employee-3', '1577944116'),
(264, 17, 2, 'متابعة الخطط الفردية واستمارات تقييم الحالات', 7, 'employee-3', '1577944165'),
(265, 17, 2, 'متابعة الحالات بشكل مستمر', 7, 'employee-3', '1577944199'),
(266, 17, 2, 'متابعة الوسائل التعليمية ', 7, 'employee-3', '1577944233'),
(267, 17, 2, 'متابعة النظافة العامة', 7, 'employee-3', '1577944260'),
(268, 17, 2, 'متابعة الاهداف مع اولياء الامور', 7, 'employee-3', '1577944299'),
(269, 17, 2, 'متابعة الجانب المهني', 6, 'employee-3', '1577944327'),
(270, 17, 2, 'متابعة عهدة المركز ', 5, 'employee-3', '1577944349'),
(271, 17, 2, 'متابعة السجلات الإدارية والتربوية ', 5, 'employee-3', '1577944403'),
(272, 17, 4, 'السلوك العام', 4, 'employee-3', '1577944437'),
(273, 17, 4, 'تقدير المسئولية', 4, 'employee-3', '1577944454'),
(274, 17, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577944468'),
(275, 17, 4, 'حسن التصرف', 4, 'employee-3', '1577944486'),
(276, 17, 3, 'الرؤساء ', 3, 'employee-3', '1577944512'),
(277, 17, 3, 'الزملاء', 3, 'employee-3', '1577944544'),
(279, 17, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577944585'),
(280, 17, 3, 'الطلاب', 3, 'employee-3', '1577945109'),
(281, 18, 2, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-3', '1577945387'),
(282, 18, 2, 'المحافظة على أوقات الدوام والجداول والإشراف اليومي ', 7, 'employee-3', '1577945415'),
(283, 18, 2, 'انجاز المهام المعطاة في الوقت المحدد', 7, 'employee-3', '1577945472'),
(284, 18, 2, 'تدريب الموظفات المستجدات (بعمل نمذجة امامهم للتوجيه عند زيارتهن +حضورهن زيارة لزميلاتهن )', 7, 'employee-3', '1577946316'),
(285, 18, 2, 'متابعة الموظفات بشكل دوري (الملفات -الواجبات - أوراق العمل - دفتر التواصل -الوسائل -العنوانه ....)', 7, 'employee-3', '1577946387'),
(286, 18, 2, 'زيارة 3 فصول على الاقل خلال الأسبوع', 7, 'employee-3', '1577946449'),
(287, 18, 2, 'مقابلة الامهات وشرح البرنامج التأهيلي بطريقة التربوية ', 7, 'employee-3', '1577946510'),
(288, 18, 2, 'القدرة على تعديل السلوكيات داخل الصف بطريقة التربوية', 7, 'employee-3', '1577946589'),
(289, 18, 2, 'متابعة وتقييم المتدربات وكتابة تقييمهن', 6, 'employee-3', '1577946854'),
(290, 18, 2, 'عمل ورش عمل للمعلمات لتطويرهم', 5, 'employee-3', '1577946901'),
(291, 18, 2, 'القدرة على تطوير أساليب التعليم وحضور ورش عمل', 5, 'employee-3', '1577946948'),
(292, 18, 4, 'السلوك العام (القدوة)', 4, 'employee-3', '1577947032'),
(293, 18, 4, 'تقدير المسئولية', 4, 'employee-3', '1577947057'),
(294, 18, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577947082'),
(295, 18, 4, 'حسن التصرف', 4, 'employee-3', '1577947107'),
(296, 18, 3, 'الرؤساء ', 3, 'employee-3', '1577947131'),
(297, 18, 3, 'الزملاء', 3, 'employee-3', '1577947151'),
(298, 18, 3, 'الطلاب', 3, 'employee-3', '1577947172'),
(299, 18, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577947190'),
(302, 19, 2, 'المحافظة على أوقات الدوام والجداول والإشراف اليومي', 6, 'employee-4', '1577952831'),
(303, 19, 2, 'تنفيذ المهام المطلوبة في الوقت المحدد', 6, 'employee-4', '1577952866'),
(304, 19, 2, 'المبادرة والابداع (أظهار الحماس والرغبة في انجاز العمل وتأدية المهام بدافعية ذاتية', 6, 'employee-4', '1577952919'),
(305, 19, 2, 'العناية بنظافة وترتيب وتنسيق البيئة الصفية ', 6, 'employee-4', '1577953009'),
(306, 19, 2, 'متابعة الملفات / خطط / تقارير / واجبات / تقاييم الحالات بشكل منتظم', 6, 'employee-4', '1577953199'),
(307, 19, 2, 'مراعاة الفروق الفردية / استخدام لغة التواصل المناسبة للحالات', 6, 'employee-4', '1577953253'),
(308, 19, 2, 'متابعة مستوى تحصيل الطلاب ومدى استفادتهم وتقدمهم ورضى الاسرة في تقدم الحالة', 6, 'employee-4', '1577953312'),
(309, 19, 2, '	المهارة في عرض الهدف وإدارة الجلسة بطريقة تربوية', 6, 'employee-4', '1577953374'),
(310, 19, 2, 'العناية بمذكرة التواصل اليومي الخاص بالحالة', 6, 'employee-4', '1577953416'),
(311, 19, 2, 'تفعيل الوسائل التعليمية التأهيلية المناسبة لقدرات الحالات وتنويع الاساليب والاستراتيجيات', 6, 'employee-4', '1577953444'),
(312, 19, 2, 'تفعيل وإعداد الانشطة اللاصفية / الوحدات / الأركان ', 6, 'employee-4', '1577953497'),
(313, 19, 2, 'القدرة على تطوير أساليب العمل (حضور ورش عمل / الاطلاع وقراءة المستجدات العلمية)', 6, 'employee-4', '1577953767'),
(315, 19, 18, 'الرؤساء', 3, 'employee-4', '1577954001'),
(316, 19, 18, 'الزملاء', 3, 'employee-4', '1577954066'),
(317, 19, 18, 'الطلاب', 3, 'employee-4', '1577954094'),
(318, 19, 4, 'اتباع إجراءات وسياسات المركز (السلوك العام)', 4, 'employee-4', '1577954166'),
(319, 19, 4, 'تقدير المسئولية', 4, 'employee-4', '1577954192'),
(320, 19, 4, 'تقبل التوجيهات', 4, 'employee-4', '1577954214'),
(322, 19, 18, 'أولياء أمور الطلاب', 3, 'employee-4', '1577955044'),
(323, 19, 4, 'التعاون مع فريق العمل', 4, 'employee-4', '1577955154'),
(324, 20, 2, 'مراعاة الفروق الفردية/ استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-3', '1577957847'),
(325, 20, 2, 'المحافظة على أوقات الدوام والجداول والإشراف اليومي ', 7, 'employee-3', '1577957946'),
(326, 20, 2, 'العناية بمذكرة التواصل اليومي', 7, 'employee-3', '1577957991'),
(327, 20, 2, 'العناية بنظافة وترتيب وتنسيق البيئة الصفية /المحافظة على العهد وأغراض الطلاب الشخصية', 7, 'employee-3', '1577958044'),
(328, 20, 2, 'تفعيل الوسائل التعليمية التأهيلية المناسبة لقدرات الطلاب', 7, 'employee-3', '1577958089'),
(329, 20, 2, 'المهارة في عرض الاهداف والجلسات وإدارة الفصل بطريقة تربوية', 7, 'employee-3', '1577958144'),
(330, 20, 2, 'مستوى تحصيل الطلاب ومدى استفادتهم وتقدمهم سلوكيا/استقلاليا/اكاديميا', 7, 'employee-3', '1577958203'),
(331, 20, 2, 'متابعة الطلاب بشكل منتظم في التدريب على دخول دورة المياه', 6, 'employee-3', '1577958241'),
(332, 20, 2, 'تنفيذ المهام المطلوبة في الوقت المحدد', 7, 'employee-3', '1577958275'),
(333, 20, 2, 'إعداد الانشطة الصفية / الاركان وتفعيلها مع الطلاب', 5, 'employee-3', '1577958321'),
(334, 20, 2, 'القدرة على تطوير اساليب العمل', 5, 'employee-3', '1577958350'),
(335, 20, 4, 'السلوك العام (القدوة)', 4, 'employee-3', '1577958398'),
(336, 20, 4, 'تقدير المسئولية', 4, 'employee-3', '1577958428'),
(339, 20, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577958507'),
(340, 20, 4, 'حسن التصرف', 4, 'employee-3', '1577958528'),
(341, 20, 3, 'الرؤساء ', 3, 'employee-3', '1577958549'),
(342, 20, 3, 'الزملاء', 3, 'employee-3', '1577958570'),
(343, 20, 3, 'الطلاب', 3, 'employee-3', '1577958588'),
(344, 20, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577958610'),
(345, 21, 2, 'استخدام لغة التواصل المناسبة للطلاب', 7, 'employee-3', '1577960848'),
(346, 21, 2, 'الالتزام بالوقت المحدد لبدء رحلة سير الباص الساعة 5:30 ص وبجدول خروج الحالات اليومي', 7, 'employee-3', '1577960930'),
(347, 21, 2, 'الالتزام بخط السير المحدد', 6, 'employee-3', '1577960961'),
(348, 21, 2, 'الالتزام بإنظمة السلامة داخل الباص', 7, 'employee-3', '1577960999'),
(349, 21, 2, 'التقيد بمتابعة وتسجيل جدول حضور استلام وتسليم حالات الباص اليومي', 7, 'employee-3', '1577961072'),
(350, 21, 2, 'الالتزام بالتوقيع اليومي عند الحضور والانصراف', 6, 'employee-3', '1577961123'),
(351, 21, 2, 'القدرة على تعديل السلوكيات داخل الباص', 7, 'employee-3', '1577961163'),
(352, 21, 2, 'احترام أسر الحالات', 6, 'employee-3', '1577961198'),
(353, 21, 2, 'الاحترام المتبادل بين المرافقة وسائق الباص / المرافقة الاخرى', 6, 'employee-3', '1577961266'),
(354, 21, 2, 'الالتزام بالاتصال على الاسرة قبل موعد الوصول للمنزل وإعطائهم الوقت المحدد لاستلام الحالة', 7, 'employee-3', '1577961342'),
(355, 21, 4, 'السلوك العام (القدوة)', 4, 'employee-3', '1577961399'),
(356, 21, 4, 'تقدير المسئولية', 4, 'employee-3', '1577961421'),
(357, 21, 4, 'تقبل التوجيهات', 4, 'employee-3', '1577961453'),
(358, 21, 4, 'حسن التصرف', 4, 'employee-3', '1577961472'),
(359, 21, 3, 'الرؤساء ', 3, 'employee-3', '1577961489'),
(360, 21, 3, 'الزملاء', 3, 'employee-3', '1577961505'),
(361, 21, 3, 'الطلاب', 3, 'employee-3', '1577961517'),
(362, 21, 3, 'أولياء أمور الطلاب', 3, 'employee-3', '1577961530'),
(363, 21, 2, 'تبليغ الإدارة بما يطرأ في الباص من الحالات / أولياء الامور / المرافقات / سائق الباص / الاعطال.', 6, 'employee-3', '1577961873'),
(364, 22, 2, 'إنشاء ومتابعة ملفات الموظفين', 8, 'employee-1', '1579530815'),
(365, 22, 2, 'المشاركة في اجراء مقابلات شخصية للموظفين', 7, 'employee-1', '1579531941'),
(366, 22, 2, 'إنشاء قاعدة بيانات عامة لجميع الموظفين تشمل البيانات الشخصية والوظيفية', 8, 'employee-1', '1579532010'),
(367, 22, 2, 'متابعة الحضور والانصراف للموظفين', 7, 'employee-1', '1579532041'),
(368, 22, 2, 'إعداد تقارير دورية عن الموظفين', 7, 'employee-1', '1579532141'),
(369, 22, 2, 'التأكد بالتزام الموظفين بكافة الاجراءات والسياسات الخاصة بالمركز', 8, 'employee-1', '1579532200'),
(370, 22, 2, 'متابعة الانظمة الإدارية وتطويرها', 7, 'employee-1', '1579532234'),
(371, 22, 2, 'ايضاح وشرح الانظمة الإدارية للموظفين', 7, 'employee-1', '1579532283'),
(372, 22, 2, 'تحديد الأهمية النسبية للموظفين', 6, 'employee-1', '1579532317'),
(373, 22, 2, 'المشاركة في تقييم أداء الموظفين', 7, 'employee-1', '1579532345'),
(374, 22, 17, 'السلوك العام (القدوة الحسنة)', 4, 'employee-1', '1579532554'),
(375, 22, 17, 'تقدير المسؤولية', 4, 'employee-1', '1579532674'),
(376, 22, 17, 'تقبل التوجيهات', 4, 'employee-1', '1579532728'),
(377, 22, 17, 'حسن التصرف', 4, 'employee-1', '1579532748'),
(378, 22, 18, 'الرؤساء', 3, 'employee-1', '1579532778'),
(379, 22, 18, 'الزملاء', 3, 'employee-1', '1579532792'),
(380, 22, 18, 'أولياء الأمور', 3, 'employee-1', '1579532825'),
(381, 23, 2, 'متابعة أمور الطلاب داخل الفصول في الأمور التربوية', 8, 'employee-1', '1579533463'),
(382, 23, 2, 'متابعة سير عمل المدرسين داخل الفصول', 8, 'employee-1', '1579533496'),
(383, 23, 2, 'متابعة المعلمين في التحضير اليومي للدروس', 8, 'employee-1', '1579533648'),
(384, 23, 2, 'همزة وصل بين المدرسين والاخصائيين في أمور الطلاب', 7, 'employee-1', '1579533690'),
(385, 23, 2, 'متابعة ملفات الطلاب داخل الفصول', 7, 'employee-1', '1579533716'),
(386, 23, 2, 'متابعة الجانب المهني للطلاب ومدى تناسبه معهم', 7, 'employee-1', '1579533758'),
(387, 23, 2, 'متابعة الخطط الفردية', 8, 'employee-1', '1579533793'),
(388, 23, 2, 'متابعة الأهداف مع أولياء الأمور في شؤون أبنائهم', 7, 'employee-1', '1579533859'),
(389, 23, 2, 'متابعة سلوك الطلاب ونماذج الإحالة من الإدارة والاخصائيين', 7, 'employee-1', '1579534731'),
(390, 23, 2, 'متابعة سجل التواصل اليومي', 8, 'employee-1', '1579535487'),
(391, 23, 17, 'السلوك العام (القدوة الحسنة)', 4, 'employee-1', '1579539192'),
(392, 23, 17, 'تقدير المسؤولية', 4, 'employee-1', '1579539206'),
(393, 23, 17, 'تقبل التوجيهات', 4, 'employee-1', '1579539223'),
(394, 23, 17, 'حسن التصرف', 4, 'employee-1', '1579539251'),
(395, 23, 18, 'الرؤساء', 3, 'employee-1', '1579539270'),
(396, 23, 18, 'الزملاء', 3, 'employee-1', '1579539281'),
(397, 23, 18, 'أولياء الأمور', 3, 'employee-1', '1579539303'),
(400, 22, 18, 'الطلاب', 3, 'employee-1', '1579540028');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_management`
--

CREATE TABLE `evaluation_management` (
  `evaluation_management_id` int(11) UNSIGNED NOT NULL,
  `evaluation_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `instruction` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `evaluation_management`
--

INSERT INTO `evaluation_management` (`evaluation_management_id`, `evaluation_name`, `class_id`, `job_title_id`, `instruction`, `status`) VALUES
(2, 'الفصل الاول', 1, '11', NULL, 'pending'),
(3, 'تقييم فصلي', 1, '4', NULL, 'pending'),
(4, 'تقييم سارة', 100, '100', NULL, 'disabled'),
(5, 'تقييم المعلم', 100, '4', NULL, 'pending'),
(6, 'تقييم مساعد السكرتير', 100, '20', NULL, 'pending'),
(7, 'تقييم المراقب الاجتماعي', 100, '27', NULL, 'pending'),
(8, 'تقييم الممرض', 100, '10', NULL, 'pending'),
(9, 'تقييم السكرتير', 100, '11', NULL, 'pending'),
(10, 'تقييم المدير', 100, '2', NULL, 'pending'),
(11, 'تقييم الحارس', 100, '25', NULL, 'pending'),
(12, 'تقييم المساعدة الاداريه', 100, '17', NULL, 'pending'),
(13, 'تقييم العامل', 100, '21,22', NULL, 'pending'),
(14, 'الاخصائي الاجتماعي', 100, '14', NULL, 'pending'),
(15, 'الاخصائي', 100, '5,6,7,8,15', NULL, 'pending'),
(17, 'مديرة تنفيذية ', 1, '2', NULL, 'pending'),
(18, 'مختص أول', 1, '3,16,17', NULL, 'pending'),
(19, 'تقييم معلمة', 1, '4', NULL, 'pending'),
(20, 'معلمة حضانة', 1, '4', NULL, 'pending'),
(21, 'مرافقة باص', 1, '24', NULL, 'pending'),
(22, 'تقييم الموارد البشرية', 100, '26', NULL, 'pending'),
(23, 'تقييم المشرف التربوي', 100, '3', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_objective_final`
--

CREATE TABLE `evaluation_objective_final` (
  `evaluation_objective_final_id` int(11) NOT NULL,
  `training_field_id` int(11) DEFAULT NULL,
  `objective_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `employee_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `attendance_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `evaluation` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `training_field_name_to_print` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objective_to_print` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `evaluation_print` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `expense_category_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facility_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fields_training`
--

CREATE TABLE `fields_training` (
  `fields_Training_id` int(11) NOT NULL,
  `fields_Training` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `field_evaluation_employee`
--

CREATE TABLE `field_evaluation_employee` (
  `field_evaluation_employee_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `standards_evaluation` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `field_evaluation_employee`
--

INSERT INTO `field_evaluation_employee` (`field_evaluation_employee_id`, `name`, `standards_evaluation`) VALUES
(1, 'الكفايات العلمية', '1'),
(2, 'الأداء الوظيفي', '1'),
(3, 'العلاقات العامة', '3'),
(4, 'السمات الشخصية', '3'),
(5, 'الكفايات التعليمية', '1'),
(6, 'الكفاية الإدارية', '2'),
(7, 'الأداء الوظيفي', '1'),
(8, 'الأداء الوظيفي', '1'),
(9, 'الكفايات المعرفية', '1'),
(10, 'الكفايات التخطيطية ', '1'),
(11, 'الكفايات المهنية', '1'),
(12, 'الكفايات الانتاجية', '0'),
(13, 'الانشطة والمشاريع ', '1'),
(14, 'المبادرة والابداع ', '1'),
(15, 'الكفايات الشخصية والاجتماعية', '3'),
(16, 'التعاون والالتزام بالانظمة واللوائح ', '3'),
(17, 'الصفات الشخصية', '3'),
(18, 'العلاقات العامة', '3'),
(19, '1', '3');

-- --------------------------------------------------------

--
-- Table structure for table `for_subscription`
--

CREATE TABLE `for_subscription` (
  `id` int(11) NOT NULL,
  `type` longtext DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_subscription`
--

INSERT INTO `for_subscription` (`id`, `type`, `description`) VALUES
(1, 'prefix', '_rc'),
(2, 'storage_space', '100'),
(3, 'first_subscription', '2020-08-30 07:00:00'),
(4, 'started_in', '2022-01-01 07:00:00'),
(5, 'expiry_date', '2023-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `for_update`
--

CREATE TABLE `for_update` (
  `settings_id` int(11) NOT NULL,
  `type` longtext DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `for_update`
--

INSERT INTO `for_update` (`settings_id`, `type`, `description`) VALUES
(1, 'status_student', '1');

-- --------------------------------------------------------

--
-- Table structure for table `frontend_blog`
--

CREATE TABLE `frontend_blog` (
  `frontend_blog_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `blog_post` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `posted_by` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `published` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_events`
--

CREATE TABLE `frontend_events` (
  `frontend_events_id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_gallery`
--

CREATE TABLE `frontend_gallery` (
  `frontend_gallery_id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `date_added` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `show_on_website` int(11) NOT NULL DEFAULT 0,
  `number_visits` int(11) NOT NULL DEFAULT 0,
  `encrypt_thread` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `short_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT 1,
  `tags_gallery` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `posted_by` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_gallery_image`
--

CREATE TABLE `frontend_gallery_image` (
  `frontend_gallery_image_id` int(11) NOT NULL,
  `frontend_gallery_id` int(11) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_general_settings`
--

CREATE TABLE `frontend_general_settings` (
  `frontend_general_settings_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `frontend_general_settings`
--

INSERT INTO `frontend_general_settings` (`frontend_general_settings_id`, `type`, `description`) VALUES
(1, 'about_us', ''),
(2, 'terms_conditions', ''),
(3, 'privacy_policy', ''),
(4, 'social_links', '[{\"facebook\":\"http://facebook.com\",\"twitter\":\"http://twitter.com\",\"linkedin\":\"http://linkedin.com\",\"google\":\"http://google.com\",\"youtube\":\"http://youtube.com\",\"instagram\":\"http://instagram.com\"}]'),
(5, 'school_title', ''),
(6, 'school_logo', ''),
(7, 'school_location', '51.7548164,-1.2565555'),
(8, 'address', ''),
(9, 'phone', ''),
(10, 'email', ''),
(11, 'fax', ''),
(12, 'header_logo', ''),
(13, 'footer_logo', ''),
(14, 'copyright_text', ''),
(15, 'about_us_image', 'about_us_IMG_215439.png'),
(16, 'slider_images', '[{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 1\",\"description\":\"\\u0648\\u0635\\u0641 1\",\"image\":\"kids.jpg\"},{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 2\",\"description\":\"\\u0648\\u0635\\u0641 2\",\"image\":\"special-educational-needs-and-disability-send-course-1.jpg\"},{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 3\",\"description\":\"\\u0648\\u0635\\u0641 3\",\"image\":\"0qGIDa52.jpg\"}]'),
(17, 'theme', 'default'),
(18, 'homepage_note_title', ''),
(19, 'homepage_note_description', ''),
(20, 'recaptcha_site_key', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `frontend_news`
--

CREATE TABLE `frontend_news` (
  `frontend_news_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` int(11) DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontend_settings`
--

CREATE TABLE `frontend_settings` (
  `frontend_settings_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `frontend_settings`
--

INSERT INTO `frontend_settings` (`frontend_settings_id`, `type`, `description`) VALUES
(1, 'theme', 'hasta'),
(2, 'hospital_name', 'مركز'),
(3, 'emergency_contact', '0500000000'),
(4, 'opening_hours', '[{\"class_day_1\":\"الاحد - الخميس\",\"class_hours_1\":\"7:30 - 1:00\",\"class_day_2\":\"الاحد - الخميس\",\"class_hours_2\":\"3:30 - 8:30\"}]'),
(5, 'social_links', '[{\"facebook\":\"http:\\/\\/facebook.com\",\"twitter\":\"https:\\/\\/twitter.com\",\"google_plus\":\"https:\\/\\/google.com\",\"youtube\":\"https:\\/\\/youtube.com\"}]'),
(6, 'email', 'stepsrehabmed@gmail.com'),
(7, 'copyright_text', 'مركز | 2019-2020'),
(8, 'slider', '[{\"title\":\"مرحبا بكم \",\"description\":\"رسالتنا التأهيل الشامل لذوي الاحتياجات الخاصة على افضل مستوى ودمجهم في المجتمع .\",\"image\":\"DSC01646.JPG\"},{\"title\":\"الخدمات التأهيلية\",\"description\":\"يقدم المركز خدمات تأهيليه للقابلين للتعلم والتدريب بهدف الوصول بهم لأقصى إمكاناتهم واعتمادهم على أنفسهم في حياتهم ويتم تقديم الخدمات من خلال البرامج برامج الرعاية الشخصية ، البرامج التربوية ، البرامج الاكاديمية ، البرامج المهنية ، برامج التدخل المبكر ، المهارات الاجتماعية .\",\"image\":\"DSC01646.JPG\"},{\"title\":\" الخدمات الترويحية\",\"description\":\"تساعد المستفيد على استخدام أوقات الترويح والترفيه استخداما يعود عليه بالفائدة من خلال تنمية المهارات الاجتماعية والحركية والشخصية والمعرفية واللغوية والاستماع بأنشطة الترويح .\",\"image\":\"DSC01668.JPG\"}]'),
(9, 'homepage_welcome_section', '[{\"title\":\"أهلا بكم في مركز  \",\"description\":\"    \",\"image\":\"شعار مركز .png\"}]'),
(10, 'service_section', '[{\"title\":\"الخدمات المقدمة في مركز \",\"description\":\" تقدم من قبل مجموعة من المتخصصين المؤهلين وأصحاب الكفاءات العالية في خدمات ذوي الاحتياجات الخاصة \"}]'),
(11, 'about_us', '[{\"about_us_1\":\"<div>&nbsp;111<\\/div>\",\"about_us_2\":null,\"about_us_image\":null}]'),
(12, 'recaptcha', '[{\"site_key\":\"6LePbzgUAAAAAPoKsV10vpTe74Jv67R2ETggFiVC\",\"secret_key\":\"6LePbzgUAAAAADb4gDtj7ui_ha02lubyOwpsXwf_\"}]'),
(13, 'number_visitors', '2'),
(14, 'mission_and_visions', '<h4 style=\"font-family: \" noto=\"\" kufi=\"\" arabic\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);=\"\" text-align:=\"\" center;\"=\"\"><h5 style=\"line-height: normal;\"><div style=\"text-align: center;\"><b style=\"color: inherit; font-family: inherit; font-size: 1.25rem;\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size: 13pt; font-family: Tahoma, sans-serif;\">الرؤية</span></b></div><b><div style=\"text-align: center;\"><b style=\"color: inherit; font-family: inherit; font-size: 1.25rem;\"><span style=\"font-size: 13pt; font-family: Tahoma, sans-serif;\"><span lang=\"AR-SA\" dir=\"RTL\">رفع مستوى القدرات والمهارات لدى ابنائنا الطلاب بأحدث\r\nالبرامج التربوية</span></span></b></div></b><b><div style=\"text-align: center;\"><b style=\"color: inherit; font-family: inherit; font-size: 1.25rem;\"><span style=\"font-size: 13pt; font-family: Tahoma, sans-serif;\"><span lang=\"AR-SA\" dir=\"RTL\">الرسالة</span></span></b></div></b><b><div style=\"text-align: center;\"><b style=\"color: inherit; font-family: inherit; font-size: 1.25rem;\"><span lang=\"AR-SA\" dir=\"RTL\" style=\"font-size: 13pt; font-family: Tahoma, sans-serif;\">التأهيل\r\nالشامل لذوي الاحتياجات الخاصة على أفضل مستوى ودمجهم في المجتمع</span></b></div></b></h5></h4>'),
(15, 'center_name', 'مركز ');

-- --------------------------------------------------------

--
-- Table structure for table `git_log`
--

CREATE TABLE `git_log` (
  `id` int(11) NOT NULL,
  `commit` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `group_chat_id` int(11) NOT NULL,
  `group_chat_thread_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_status` int(11) DEFAULT NULL,
  `attached_file_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat_thread`
--

CREATE TABLE `group_chat_thread` (
  `group_chat_thread_id` int(11) NOT NULL,
  `group_chat_thread_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `members` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_message`
--

CREATE TABLE `group_message` (
  `group_message_id` int(11) NOT NULL,
  `group_message_thread_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_status` int(11) DEFAULT NULL,
  `attached_file_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_message_thread`
--

CREATE TABLE `group_message_thread` (
  `group_message_thread_id` int(11) NOT NULL,
  `group_message_thread_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `members` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_message_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guardian_approvals`
--

CREATE TABLE `guardian_approvals` (
  `id` int(11) NOT NULL,
  `items_guardian_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `guardian_approvals` tinyint(4) NOT NULL DEFAULT 0,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_evaluation_employee`
--

CREATE TABLE `history_evaluation_employee` (
  `history_evaluation_employee_id` int(11) NOT NULL,
  `evaluation_management_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `year` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history_student_withdrawals`
--

CREATE TABLE `history_student_withdrawals` (
  `history_student_withdrawals_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_plan`
--

CREATE TABLE `home_plan` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1',
  `year` varchar(25) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `home_plan_analysis`
--

CREATE TABLE `home_plan_analysis` (
  `id` int(11) NOT NULL,
  `home_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `training_procedures_id` int(11) DEFAULT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `home_plan_steps`
--

CREATE TABLE `home_plan_steps` (
  `id` int(11) NOT NULL,
  `home_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
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
  `class_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `payments_category_id` int(11) DEFAULT NULL,
  `payments_category_price` decimal(10,2) NOT NULL,
  `payments_category_quantity` int(11) DEFAULT NULL,
  `payments_category_total` decimal(10,2) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_title`
--

CREATE TABLE `job_title` (
  `job_title_id` int(11) NOT NULL,
  `name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_title`
--

INSERT INTO `job_title` (`job_title_id`, `name`, `level`, `active`) VALUES
(1, 'الإدارة العامة', '0', 1),
(2, 'مدير قسم', '0', 1),
(3, 'مشرف تربوي', '0', 1),
(4, 'معلم', '1', 1),
(5, 'اخصائي علاج وظيفي', '2', 1),
(6, 'اخصائي علاج طبيعي', '2', 1),
(7, 'اخصائي نطق', '2', 1),
(8, 'اخصائي مهني', '2', 1),
(9, 'اخصائي تربية رياضية', '2', 1),
(10, 'تمريض', '3', 1),
(11, 'سكرتير', '0', 1),
(12, 'محاسب', '0', 1),
(13, 'امين مكتبة', '0', 1),
(14, 'اخصائي اجتماعي', '2', 1),
(15, 'أخصائي نفسي', '2', 1),
(16, 'مختص أول', '0', 1),
(17, 'مساعد إداري', '0', 1),
(18, 'علاقات عامة', '0', 1),
(19, 'مسؤول الصيانة', '0', 1),
(20, 'مساعد سكرتير', '0', 1),
(21, 'مربيات', '0', 1),
(22, 'عامل', '0', 1),
(23, 'سائق الباص', '0', 1),
(24, 'مرافق الباص', '0', 1),
(25, 'حارس', '0', 1),
(26, 'الموارد البشرية', '0', 1),
(27, 'مراقب اجتماعي', '0', 1),
(28, 'مساعد معلم', '1', 1),
(29, 'مساعد علاج طبيعي', '0', 1),
(30, 'حساب خاص بمشرفي الوزارة', '0', 1),
(31, 'معلم جلسات فردية', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mailbox`
--

CREATE TABLE `mailbox` (
  `mailbox_id` int(11) NOT NULL,
  `mailbox_thread_code` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_mail` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sender` varchar(75) DEFAULT NULL,
  `reciever` varchar(75) DEFAULT NULL,
  `timestamp` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_status` int(11) DEFAULT 0,
  `attached_file_name` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mail_attachments`
--

CREATE TABLE `mail_attachments` (
  `id` int(11) NOT NULL,
  `mail_auth_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachments` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_auth_key`
--

CREATE TABLE `mail_auth_key` (
  `id` int(11) NOT NULL,
  `mail_auth_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_massege`
--

CREATE TABLE `mail_massege` (
  `id` int(11) NOT NULL,
  `mail_auth_key_id` int(11) DEFAULT NULL,
  `subject` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `massege` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_read_status`
--

CREATE TABLE `mail_read_status` (
  `id` int(11) NOT NULL,
  `mail_massege_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `read_status` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_s_r`
--

CREATE TABLE `mail_s_r` (
  `id` int(11) NOT NULL,
  `mail_auth_key_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `sender_account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reciever` int(11) DEFAULT NULL,
  `reciever_account_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reciever_type` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ministry_supervision`
--

CREATE TABLE `ministry_supervision` (
  `ministry_supervision_id` int(11) NOT NULL,
  `ministry_supervision_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_identity` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_of_issue` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_expiry_identity` int(11) NOT NULL DEFAULT 0,
  `expiry_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `type_hiring` int(11) NOT NULL DEFAULT 0,
  `date_of_hiring` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `educational_level` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specializing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_birth` int(11) NOT NULL DEFAULT 0,
  `birthday` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `social_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_number` longtext CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `religion` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `blood_group` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code_emergency_telephone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_telephone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_links` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_on_website` int(11) DEFAULT 0,
  `level` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `practical_experiences` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_login` tinyint(4) NOT NULL DEFAULT 1,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `virtual` int(11) DEFAULT 0,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'arabic',
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_plan`
--

CREATE TABLE `monthly_plan` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1',
  `year` varchar(25) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_plan_analysis`
--

CREATE TABLE `monthly_plan_analysis` (
  `id` int(11) NOT NULL,
  `monthly_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_plan_steps`
--

CREATE TABLE `monthly_plan_steps` (
  `id` int(11) NOT NULL,
  `monthly_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `nationality_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`nationality_id`, `name`, `active`) VALUES
(1, 'إثيوبيا', 1),
(2, 'أذربيجان', 1),
(3, 'أرمينيا', 1),
(4, 'أروبا', 1),
(5, 'إريتريا', 1),
(6, 'أسبانيا', 1),
(7, 'أستراليا', 1),
(8, 'إستونيا', 1),
(9, 'الفلسطينية', 1),
(10, 'أفغانستان', 1),
(11, 'إكوادور', 1),
(12, 'الأرجنتين', 1),
(13, 'الاردنية', 1),
(14, 'الإماراتية', 1),
(15, 'ألبانيا', 1),
(16, 'البرازيل', 1),
(17, 'البرتغال', 1),
(18, 'البوسنة والهرسك', 1),
(19, 'الجزائر', 1),
(20, 'الدنمارك', 1),
(21, 'الرأس الأخضر', 1),
(22, 'السلفادور', 1),
(23, 'السنغال', 1),
(24, 'السودان', 1),
(25, 'السويد', 1),
(26, 'الصومال', 1),
(27, 'الصين', 1),
(28, 'العراق', 1),
(29, 'الغابون', 1),
(30, 'الفلبين', 1),
(31, 'الكاميرون', 1),
(32, 'الكونغو', 1),
(33, 'الكويت', 1),
(34, 'ألمانيا', 1),
(35, 'المغرب', 1),
(36, 'المكسيك', 1),
(37, 'السعودية', 1),
(38, 'المملكة المتحدة', 1),
(39, 'النرويج', 1),
(40, 'النمسا', 1),
(41, 'النيجر', 1),
(42, 'الهند', 1),
(43, 'الولايات المتحدة', 1),
(44, 'اليابان', 1),
(45, 'اليمن', 1),
(46, 'اليونان', 1),
(47, 'أنتاركتيكا', 1),
(48, 'أنتيغوا وبربودا', 1),
(49, 'أندورا', 1),
(50, 'إندونيسيا', 1),
(51, 'أنغولا', 1),
(52, 'أنغويلا', 1),
(53, 'أوروجواي', 1),
(54, 'أوزبكستان', 1),
(55, 'أوغندا', 1),
(56, 'أوكرانيا', 1),
(57, 'إيران', 1),
(58, 'إيرلندا', 1),
(59, 'أيسلندا', 1),
(60, 'إيطاليا', 1),
(61, 'بابوا غينيا الجديدة', 1),
(62, 'باراجواي', 1),
(63, 'باربادوس', 1),
(64, 'باكستان', 1),
(65, 'بالاو', 1),
(66, 'برمودا', 1),
(67, 'بروناي', 1),
(68, 'بلجيكا', 1),
(69, 'بلغاريا', 1),
(70, 'بنجلاديش', 1),
(71, 'بنما', 1),
(72, 'بنن', 1),
(73, 'بوتان', 1),
(74, 'بوتسوانا', 1),
(75, 'بورتو ريكو', 1),
(76, 'بوركينافاسو', 1),
(77, 'بوروندي', 1),
(78, 'بولندا', 1),
(79, 'بوليفيا', 1),
(80, 'بولينيزيا الفرنسية', 1),
(81, 'بونيه', 1),
(82, 'بيرو', 1),
(83, 'بيلاروس', 1),
(84, 'بيليز', 1),
(85, 'تايلاند', 1),
(86, 'تايوان', 1),
(87, 'تركمانستان', 1),
(88, 'تركيا', 1),
(89, 'ترينيداد وتوباجو', 1),
(90, 'تشاد', 1),
(91, 'تشيلي', 1),
(92, 'تنزانيا', 1),
(93, 'توجو', 1),
(94, 'توفالو', 1),
(95, 'توكيلاو', 1),
(96, 'تونجا', 1),
(97, 'تونس', 1),
(98, 'تيمور الشرقية', 1),
(99, 'جامايكا', 1),
(100, 'جامبيا', 1),
(101, 'جان ماين', 1),
(102, 'جبل طارق', 1),
(103, 'جرانادا', 1),
(104, 'جزر ألاند', 1),
(105, 'جزر البهاما', 1),
(106, 'جزر العذراء البريطانية', 1),
(107, 'جزر العذراء، الولايات المتحدة', 1),
(108, 'جزر القمر', 1),
(109, 'جزر المارتينيك', 1),
(110, 'جزر المالديف', 1),
(111, 'جزر بيتكيرن', 1),
(112, 'جزر تركس وكايكوس', 1),
(113, 'جزر ساموا الأمريكية', 1),
(114, 'جزر سولومون', 1),
(115, 'جزر فايرو', 1),
(116, 'جزر فرعية تابعة للولايات المتحدة', 1),
(117, 'جزر فوكلاند (أيزلاس مالفيناس)', 1),
(118, 'جزر فيجي', 1),
(119, 'جزر كايمان', 1),
(120, 'جزر كوك', 1),
(121, 'جزر كوكوس كيلنج', 1),
(122, 'جزر مارشال', 1),
(123, 'جزر ماريانا الشمالية', 1),
(124, 'جزر هيرد وجزر مكدونالد', 1),
(125, 'جزيرة الكريسماس', 1),
(126, 'جزيرة بوفيه', 1),
(127, 'جزيرة مان', 1),
(128, 'جزيرة نورفوك', 1),
(129, 'جمهورية أفريقيا الوسطى', 1),
(130, 'جمهورية التشيك', 1),
(131, 'جمهورية الدومينيكان', 1),
(132, 'جمهورية كوت ديفوار', 1),
(133, 'جنوب أفريقيا', 1),
(134, 'جنوب فرنسا وأراضي الأنترتيك', 1),
(135, 'جواتيمالا', 1),
(136, 'جوام', 1),
(137, 'جورجيا', 1),
(138, 'جورجيا الجنوبية وجزر ساندويتش الجنوبية', 1),
(139, 'جيانا الفرنسية', 1),
(140, 'جيبوتي', 1),
(141, 'جيرسي', 1),
(142, 'دولة الفاتيكان', 1),
(143, 'دومينيكا', 1),
(144, 'رواندا', 1),
(145, 'روسيا', 1),
(146, 'رومانيا', 1),
(147, 'ريونيون', 1),
(148, 'زامبيا', 1),
(149, 'زيمبابوي', 1),
(150, 'سابا', 1),
(151, 'ساموا', 1),
(152, 'سان بارتيليمي', 1),
(153, 'سان مارينو', 1),
(154, 'سانت أوستاتيوس', 1),
(155, 'سانت بيير وميكولون', 1),
(156, 'سانت فينسنت وجرينادينز', 1),
(157, 'سانت كيتس ونيفيس', 1),
(158, 'سانت لوشيا', 1),
(159, 'سانت مارتن', 1),
(160, 'سانت مارتن', 1),
(161, 'سانت هيلينا', 1),
(162, 'ساوتوماي وبرينسيبا', 1),
(163, 'سلوفاكيا', 1),
(164, 'سلوفينيا', 1),
(165, 'سنغافورة', 1),
(166, 'سوازيلاند', 1),
(167, 'سوريا', 1),
(168, 'سورينام', 1),
(169, 'سويسرا', 1),
(170, 'سيراليون', 1),
(171, 'سيريلانكا', 1),
(172, 'سيشل', 1),
(173, 'صربيا', 1),
(174, 'طاجيكستان', 1),
(175, 'عمان', 1),
(176, 'غانا', 1),
(177, 'غرينلاند', 1),
(178, 'غوادلوب', 1),
(179, 'غويانا', 1),
(180, 'غويرنسي', 1),
(181, 'غينيا', 1),
(182, 'غينيا الاستوائية', 1),
(183, 'غينيا بيساو', 1),
(184, 'فانواتو', 1),
(185, 'فرنسا', 1),
(186, 'فنزويلا', 1),
(187, 'فنلندا', 1),
(188, 'فيتنام', 1),
(189, 'قبرص', 1),
(190, 'قطر', 1),
(191, 'قيرقيزتان', 1),
(192, 'كازاخستان', 1),
(193, 'كالدونيا الجديدة', 1),
(194, 'كرواتيا', 1),
(195, 'كمبوديا', 1),
(196, 'كندا', 1),
(197, 'كوبا', 1),
(198, 'كوراساو', 1),
(199, 'كوريا', 1),
(200, 'كوريا الشمالية', 1),
(201, 'كولومبيا', 1),
(202, 'كيريباتي', 1),
(203, 'كينيا', 1),
(204, 'لاتفيا', 1),
(205, 'لاوس', 1),
(206, 'لبنان', 1),
(207, 'لكسمبورج', 1),
(208, 'ليبيا', 1),
(209, 'ليبيريا', 1),
(210, 'ليتوانيا', 1),
(211, 'ليسوتو', 1),
(212, 'ليشتنشتاين', 1),
(213, 'ماكاو', 1),
(214, 'مالاوي', 1),
(215, 'مالطا', 1),
(216, 'مالي', 1),
(217, 'ماليزيا', 1),
(218, 'مايوت', 1),
(219, 'مدغشقر', 1),
(220, 'مصر', 1),
(221, 'مقاطعة المحيط الهندي البريطاني', 1),
(222, 'مقدونيا، جمهورية يوغوسلافيا السابقة', 1),
(223, 'مملكة البحرين', 1),
(224, 'منغوليا', 1),
(225, 'موريتانيا', 1),
(226, 'موريشيوس', 1),
(227, 'موزنبيق', 1),
(228, 'مولدافا', 1),
(229, 'موناكو', 1),
(230, 'مونتسيرات', 1),
(231, 'مونتينيغرو', 1),
(232, 'ميانمار', 1),
(233, 'ميكرونيزيا', 1),
(234, 'ناميبيا', 1),
(235, 'ناورو', 1),
(236, 'نيبال', 1),
(237, 'نيجيريا', 1),
(238, 'نيكاراجوا', 1),
(239, 'نيوزيلندا', 1),
(240, 'نيوي', 1),
(241, 'هايتي', 1),
(242, 'هندوراس', 1),
(243, 'هنغاريا', 1),
(244, 'هولندا', 1),
(245, 'هونغ كونغ', 1),
(246, 'واليس وفوتونا', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notes_on_employee`
--

CREATE TABLE `notes_on_employee` (
  `notes_on_employee_id` int(11) NOT NULL,
  `type_of_notes_on_employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `year` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notes_users`
--

CREATE TABLE `notes_users` (
  `id` int(11) NOT NULL,
  `notes_users_textarea` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE `noticeboard` (
  `notice_id` int(11) NOT NULL,
  `notice_title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notice` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `create_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `show_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_on_website` int(11) DEFAULT 0,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam`
--

CREATE TABLE `online_exam` (
  `online_exam_id` int(11) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `online_exam_type_id` int(11) DEFAULT NULL,
  `exam_date` int(11) DEFAULT NULL,
  `time_start` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_end` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'duration in second',
  `minimum_percentage` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `instruction` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'unpublished',
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `online_exam`
--

INSERT INTO `online_exam` (`online_exam_id`, `code`, `title`, `class_id`, `job_title_id`, `online_exam_type_id`, `exam_date`, `time_start`, `time_end`, `duration`, `minimum_percentage`, `instruction`, `status`, `deleted`) VALUES
(1, '0b8ebd0', 'اختبار كفايات المعلمين (تجريبي)', 100, 100, 4, NULL, NULL, NULL, '0', '70', 'اختبار عام في تخصص التربية الخاصة، مكون من 10 اسئلة اختيار من متعدد', 'unpublished', 1),
(2, '83d1825', 'اختبار البرنامج التدريبي الـ ABA', 100, 100, 1, NULL, NULL, NULL, '0', '60', 'مدة الاختبار 30 دقيقه ', 'unpublished', 0),
(3, 'e9bb45c', 'اختبار تجريبي', 100, 100, 1, NULL, NULL, NULL, '0', '50', 'يرجى الاجابة على جميع الاسئلة\r\n / لن يتم حفظ الاجابات ما لم تضغط على زر ارسال', 'unpublished', 0);

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_result`
--

CREATE TABLE `online_exam_result` (
  `online_exam_result_id` int(11) UNSIGNED NOT NULL,
  `online_exam_send_id` int(11) DEFAULT NULL,
  `online_exam_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `answer_script` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `obtained_mark` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `exam_started_timestamp` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `result` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_send`
--

CREATE TABLE `online_exam_send` (
  `online_exam_send_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `online_exam_id` int(11) DEFAULT NULL,
  `exam_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_start` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_end` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_type`
--

CREATE TABLE `online_exam_type` (
  `online_exam_type_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `online_exam_type`
--

INSERT INTO `online_exam_type` (`online_exam_type_id`, `name`) VALUES
(1, 'general_test'),
(2, 'psychological_tests'),
(3, 'test_of_mental_abilities'),
(4, 'performance_tests'),
(5, 'speed_response_tests'),
(6, 'tests_of_values_and_trends');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `email` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code_another_phone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `another_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_another_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `profession` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_login` tinyint(4) NOT NULL DEFAULT 1,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'arabic',
  `deleted` int(11) NOT NULL DEFAULT 0,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_activity` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `key_pass` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_img` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents_areas_satisfaction`
--

CREATE TABLE `parents_areas_satisfaction` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parents_areas_satisfaction`
--

INSERT INTO `parents_areas_satisfaction` (`id`, `name`, `active`) VALUES
(1, 'الخدمات والمركز', 1),
(2, 'المواصلات', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents_poll`
--

CREATE TABLE `parents_poll` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parents_poll`
--

INSERT INTO `parents_poll` (`id`, `name`, `active`) VALUES
(1, 'قياس رضا أولياء أمور المستفيدين', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents_poll_send`
--

CREATE TABLE `parents_poll_send` (
  `id` int(11) NOT NULL,
  `parents_poll_id` int(11) DEFAULT NULL,
  `parents_id` int(11) DEFAULT NULL,
  `submitted` tinyint(4) NOT NULL DEFAULT 0,
  `date_submitted` datetime NOT NULL,
  `date_send` datetime NOT NULL,
  `expires_in` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `parents_send_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents_satisfaction_items`
--

CREATE TABLE `parents_satisfaction_items` (
  `id` int(11) NOT NULL,
  `parents_poll_id` int(11) DEFAULT NULL,
  `parents_areas_satisfaction_id` int(11) DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `parents_satisfaction_items`
--

INSERT INTO `parents_satisfaction_items` (`id`, `parents_poll_id`, `parents_areas_satisfaction_id`, `name`, `active`) VALUES
(1, 1, 1, 'تواصل المركز مع أولياء الأمور في ما يخص الطالب / ـة .', 1),
(2, 1, 1, 'تعامل إدارة المركز ومنسوباتها يتسم بالتعاون والاحترام مع سهولة مقابلة الكادر  .', 1),
(3, 1, 1, 'يوفر المركز لأولياء الأمور أرقام للتواصل ( ثابت – جوال )   . ', 1),
(4, 1, 1, 'يحرص المركز على مناقشة البرامج والخدمات المقدمة للطالب / ـة  مع أولياء الأمور  . ', 1),
(5, 1, 1, 'يهتم المركز بتوفير بيئة نظيفة – صحيه - آمنه للطالب / ـة  .', 1),
(6, 1, 1, 'يوفر المركز أماكن إنتظار مريحه .', 1),
(7, 1, 1, 'توفير ساحات ترفيهيه مناسبه  للطالب / ـة     . ', 1),
(8, 1, 1, 'الخدمات المقدمه متنوعة ومتكامله وتناسب قدرات الطالب / ة . ', 1),
(9, 1, 1, 'التزام المركز بتدريب الطالب / ـة  عن بعد  . ', 1),
(10, 1, 1, 'جودة الماده العلميه المقدمة من المعلمات عن بعد .', 1),
(11, 1, 1, 'التزام المركز بالإجراءات الإحترازيه . ', 1),
(12, 1, 2, 'التزام الحافله بالمواعيد المحدده   .', 1),
(13, 1, 2, 'تعاون سائق الحافلة مع الاسرة .', 1),
(14, 1, 2, 'تعاون مرافقة الباص مع الاسرة   . ', 1),
(15, 1, 2, 'مدى تعامل إدارة المركز مع المشاكل التي يواجهها أولياء الأمور في المواصلات    . ', 1),
(16, 1, 2, 'رضاك عن الحافلة المدرسيه بشكل عام   . ', 1),
(17, 1, 2, 'قياس درجة حرارة الطالب /ـة .', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents_send`
--

CREATE TABLE `parents_send` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `date_send` datetime NOT NULL,
  `expires_in` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `year` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents_submitted_poll`
--

CREATE TABLE `parents_submitted_poll` (
  `id` int(11) NOT NULL,
  `parents_poll_id` int(11) DEFAULT NULL,
  `parents_id` int(11) DEFAULT NULL,
  `parents_satisfaction_items_id` int(11) DEFAULT NULL,
  `degree` tinyint(4) NOT NULL DEFAULT 0,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `parents_send_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
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
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments_category`
--

CREATE TABLE `payments_category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_added` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_category`
--

CREATE TABLE `payroll_category` (
  `payroll_category_id` int(11) NOT NULL,
  `name` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_employee`
--

CREATE TABLE `payroll_employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `payroll_category_id` int(11) NOT NULL,
  `payroll_amount` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plan_summary`
--

CREATE TABLE `plan_summary` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `active` varchar(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plan_summary_steps`
--

CREATE TABLE `plan_summary_steps` (
  `id` int(11) NOT NULL,
  `plan_summary_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `summary` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `id` int(11) NOT NULL,
  `poll_manage_id` int(11) DEFAULT NULL,
  `poll_axes_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `degree` tinyint(4) NOT NULL DEFAULT 0,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `login_type` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_answer_script`
--

CREATE TABLE `poll_answer_script` (
  `id` int(11) NOT NULL,
  `poll_send_id` int(11) DEFAULT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `poll_items_id` int(11) DEFAULT NULL,
  `answer_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `poll_send_times_id` int(11) DEFAULT NULL,
  `item_type` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_axes`
--

CREATE TABLE `poll_axes` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poll_items`
--

CREATE TABLE `poll_items` (
  `id` int(11) NOT NULL,
  `poll_manage_id` int(11) DEFAULT NULL,
  `poll_axes_id` int(11) DEFAULT NULL,
  `item` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `question_title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_options` int(11) DEFAULT NULL,
  `options` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poll_items`
--

INSERT INTO `poll_items` (`id`, `poll_manage_id`, `poll_axes_id`, `item`, `publish`, `active`, `question_title`, `type`, `number_of_options`, `options`) VALUES
(1, 1, NULL, NULL, 1, 1, 'طبيعة العمل', 'multiple_choice', 6, '[\"مدير\",\"اداري\",\"مشرف\",\"معلم\",\"اخصائي\",\"اخرى\"]'),
(2, 1, NULL, NULL, 1, 1, 'سرعة استجابة فريق الدعم الفني لحل المشكلات', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير رااضي جدا\"]'),
(3, 1, NULL, NULL, 1, 1, 'قدرة فريق الدعم الفني على حل المشكلات', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(4, 1, NULL, NULL, 1, 1, 'التوعية أو التدريب على استخدام النظام', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(5, 1, NULL, NULL, 1, 1, 'تزويد العميل بفيديو او صورة خلال تقديم الدعم', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(6, 1, NULL, NULL, 1, 1, 'الترحيب والحفاوة خلال المحادثة مع الدعم', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(7, 1, NULL, NULL, 1, 1, 'إبداء التعاون من قبل الدعم لحل المشكلة', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(8, 1, NULL, NULL, 1, 1, 'الاستئذان من العميل قبل الاتصال به', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(9, 1, NULL, NULL, 1, 1, 'هل واجهت مشكلة لم يستطع الدعم الفني حلها', 'multiple_choice', 2, '[\"نعم\",\"لا\"]'),
(10, 1, NULL, NULL, 1, 1, 'ماهي الطريقة التي تفضلها لتلقي الدعم الفني وخدمه العملاء', 'multiple_choice', 2, '[\"واتس اب\",\"الاتصال الهاتفي\"]'),
(11, 1, NULL, NULL, 1, 1, 'مدى الرضا العام عن خدمة الدعم الفني', 'multiple_choice', 5, '[\"راضي جدا\",\"راضي\",\"محايد\",\"غير راضي\",\"غير راضي جدا\"]'),
(12, 1, NULL, NULL, 1, 1, 'اقتراحات أو ملاحظات أخرى', 'fill_in_the_blanks', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poll_manage`
--

CREATE TABLE `poll_manage` (
  `id` int(11) NOT NULL,
  `encrypt_thread` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `instruction` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `poll_manage`
--

INSERT INTO `poll_manage` (`id`, `encrypt_thread`, `name`, `instruction`, `publish`, `active`, `class_id`, `job_title_id`) VALUES
(1, 'a9369d97-c27f-4ceb-83d3-c3ebd0d8a84a', 'تقييم مستوى جودة الدعم الفني', 'مرحبا بكم\r\nاستبيان تقييم مستوى جودة الدعم الفني\r\n\r\nنشكركم على المشاركة في هذا الاستبيان الذي من خلال نتائجه سنقدم خدمة أفضل لكم في المستقبل\r\n\r\nيستغرق هذا الاستبيان بضع دقائق فقط من وقتكم\r\n\r\nوتأكدوا من أن جميع الإجابات التي تقدمها سوف تبقى في سرية تامة وتستخدم لتحسين خدماتنا', 1, 1, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `poll_send`
--

CREATE TABLE `poll_send` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `submitted` tinyint(4) NOT NULL DEFAULT 0,
  `date_submitted` datetime NOT NULL,
  `date_send` datetime NOT NULL,
  `expires_in` varchar(50) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `answer_script` longtext DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `poll_send_times_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poll_send_times`
--

CREATE TABLE `poll_send_times` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `date_send` datetime NOT NULL,
  `expires_in` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `question_bank_id` int(11) UNSIGNED NOT NULL,
  `online_exam_id` int(11) DEFAULT NULL,
  `question_title` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_options` int(11) DEFAULT NULL,
  `options` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `correct_answers` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`question_bank_id`, `online_exam_id`, `question_title`, `type`, `number_of_options`, `options`, `correct_answers`, `mark`) VALUES
(1, 1, 'محمد معلم تربية خاصة في مدرسة عادية، يأتوه طلاب ذوي احتياجات خاصة في مكتبه ليتلقوا خدمات تربوية خاصة. ما نوع الخدمة التي يقدمها محمد؟', 'multiple_choice', 4, '[\"تعليم مكثف\",\"غرفة مصادر \",\"صف خاص\",\"تعليم تعاوني\"]', '[\"2\"]', '1'),
(2, 1, 'ما هو تصنيف الإعاقة الفكرية الذي يعتمد على اختبارات الذكاء كمحك للتصنيف؟', 'multiple_choice', 4, '[\"التصنيف الطبي\",\"التصنيف التربوي\",\"التصنيف النفسي\",\"التصنيف الطبيعي\"]', '[\"3\"]', '1'),
(3, 1, 'عبدالعزيز طالب في مدرسة عادية، لديه عسر قراءة وليس لديه أي مشاكل سلوكية. ما هو الاحتياج الخاص لدى عبدالعزيز؟', 'multiple_choice', 4, '[\"صعوبات تعلم\",\"إعاقة فكرية\",\"إعاقة بصرية\",\"فرط حركة\"]', '[\"1\"]', '1'),
(4, 1, 'ما الذي يعرف بأنه &quot;تغير مفاجئ في وظائف الدماغ ينجم عن نشاط كهربائي غير منتظم في الخلايا العصبية في الدماغ&quot;؟', 'multiple_choice', 4, '[\"الشلل الدماغي\",\"الاستسقاء الدماغي\",\"العمود الفقري المفتوح\",\"الصرع\"]', '[\"4\"]', '1'),
(5, 1, 'صالح طالب لديه إعاقة بصرية، ما أفضل طريقة لتدريب صالح على القراءة؟', 'multiple_choice', 4, '[\"بطاقات بيكس\",\"قراءة الشفاه\",\"الورقة والقلم\",\"لغة برايل\"]', '[\"4\"]', '1'),
(6, 1, 'ما الذي يعرف بأنه &quot;خدمات توفر للطبة ذوي الاحتياجات الخاصة إلى جانب خدمة التربية الخاصة&quot;؟', 'multiple_choice', 4, '[\"الخدمات المساندة\",\"غرفة المصادر\",\"المعلم المساعد\",\"البرنامج التربوي الفردي\"]', '[\"1\"]', '1'),
(7, 1, 'إذا كنت معلم في صف تربية خاصة، وأردت تنمية التآزر البصري الحركي لدى الطلاب، ما هو النشاط الذي ستقوم به؟', 'multiple_choice', 4, '[\"مشاهدة التلفاز\",\"تناول الوجبة\",\"الرسم والتلوين\",\"تفريش الأسنان\"]', '[\"3\"]', '1'),
(8, 1, 'أي المقاييس التالية يستخدم لحساب نسبة الذكاء في القدرات العقلية؟', 'multiple_choice', 4, '[\"مقياس السلوك التكيفي\",\"مقياس ستانفورد بينيه\",\"مقياس رسم الرجل\",\"مقياس الإكتئاب\"]', '[\"2\"]', '1'),
(9, 1, 'وفقاً لتعريف الإعاقة الفكرية، أي من التالي يعتبر من محكات تشخيص وجود إعاقة فكرية؟', 'multiple_choice', 4, '[\"تدني في اللغة المنطوقة\",\"صعوبة في القراءة\",\"صعوبة في الحركة\",\"تدني السلوك التكيفي\"]', '[\"4\"]', '1'),
(10, 1, 'تم تسجيل طالب جديد في أحد المراكز، واراد فريق العمل إعداد خطة تربوية خاصة به. بعد تقييم قدرات الطالب ما الخطوة التي يجب أن يتخذونها؟', 'multiple_choice', 4, '[\"تحديد جوانب القصور لدى الطالب\",\"تحديد جوانب القصور والقوة لدى الطالب\",\"وضع حدود لأداء الطالب\",\"تحديد جوانب القوة لدى الطالب\"]', '[\"2\"]', '1'),
(11, 2, 'ظهرت الحاجه لتحليل السلوك التطبيقي بسبب وجود فئات جديده مثل', 'multiple_choice', 4, '[\"صعوبات تعلم\",\"بطيء التعلم\",\"الموهوبون\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(12, 2, 'أي العبارات التاليه صحيحه', 'multiple_choice', 4, '[\"السلوك الإستجابي هو سلوك محكوم بما بعده\",\"السلوك الإجرائي هو سلوك محكوم بما قبله\",\"السلوك الإستجابي هو سلوك محكوم بما قبله\",\"جميع ماسبق\"]', '[\"3\"]', '2'),
(13, 2, 'نظرا لأن السلوك الإنساني معقد نحتاج في تفسيره الى', 'multiple_choice', 4, '[\"وضع وقت محدد\",\"قابلية التحقق والتنبؤ\",\"وجود الأداء والمعيار\",\"أن يكون التفسير قابل للقياس\"]', '[\"2\"]', '2'),
(14, 2, 'الأهداف السلوكيه لها مجموعة شروط منها', 'multiple_choice', 4, '[\"أن يكون الهدف محدد\",\"أن يكون الهدف قابل للقياس\",\"أن يكون ذو علاقه\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(15, 2, 'يجب أن ترتكز الأهداف السلوكيه على عناصر منها', 'multiple_choice', 4, '[\"الظروف\",\"الاستمراريه\",\"الإستجابه\",\"الإيجاز\"]', '[\"1\"]', '2'),
(16, 2, 'أي الأهداف السلوكيه  التاليه هي أهداف طويلة المدى', 'multiple_choice', 4, '[\"اختيار الملابس المناسبه للطقس\",\"ارتداء الملابس وخلعها بدون مساعده\",\"تناول الطعام والشراب بدون مساعده\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(17, 2, 'لكي نصمم وننفذ برنامج تحليل السلوك التطبيقي نكون بحاجه الى', 'multiple_choice', 4, '[\"7 خطوات\",\"6 خطوات\",\"9 خطوات\",\"5 خطوات\"]', '[\"3\"]', '2'),
(18, 2, 'من خطوات تصميم برنامج تحليل السلوك التطبيقي', 'multiple_choice', 4, '[\"قياس السلوك\",\"نعرف السلوك تعريف اجرائي\",\"تحديد الأهداف السلوكيه البديله\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(19, 2, 'سميت استرتيجية ال aba بطريقة التعليم الميسر وذلك بسبب أنها', 'multiple_choice', 4, '[\"طريقه سهله وبسيطه\",\"تعمل على إزالة المعيقات\",\"قائمه على نظرية الإقتران\",\"جميع ماسبق\"]', '[\"2\"]', '2'),
(20, 2, 'فترة ملاحظة السلوك تستمر ل', 'multiple_choice', 4, '[\"6 ساعات لمدة أسبوع\",\"6 ساعات لمدة أسبوعين\",\"6ساعات لمدة 3 أسابيع\",\"6 ساعات لمدة 4 أسابيع\"]', '[\"3\"]', '2'),
(21, 2, 'أي هذه العبارات  خاطئه  (من خصائص السلوك المشكل)', 'multiple_choice', 4, '[\"يتسبب في حدوث ضرر\",\"يتوافق مع المرحله العمريه للحاله\",\"أن يكون غير مقبول اجتماعيا\",\"قابل للقياس والملاحظه\"]', '[\"2\"]', '2'),
(22, 2, 'من وظائف السلوك', 'multiple_choice', 4, '[\"الهروب من العمل\",\"الحصول على شيء\",\"استثارة الذات\",\"كل ماسبق\"]', '[\"4\"]', '2'),
(23, 2, 'من النظريات التي تقوم عليها استراتيجية تحليل السلوك التطبيقي', 'multiple_choice', 4, '[\"الإقتران\",\"تدريس الأقران\",\"التعلم بالمحاوله والخطأ\",\"السمات\"]', '[\"1\"]', '2'),
(24, 2, 'من أنواع السلوك', 'multiple_choice', 4, '[\"اتكالي\",\"انعكاسي\",\"انتكاسي\",\"اجرائي\"]', '[\"4\"]', '2'),
(25, 2, 'في جدول ادارة السلوك نقوم بكتابة ماحدث بعد السلوك في', 'multiple_choice', 4, '[\"السوابق\",\"اللواحق\",\"وصف السلوك\",\"كل ماسبق\"]', '[\"2\"]', '2'),
(26, 2, 'في جدول ادارة السلوك نقوم بكتابة محددات السلوك في خانة', 'multiple_choice', 4, '[\"لواحق السلوك\",\"وصف السلوك\",\"سوابق السلوك\",\"كل ماسبق\"]', '[\"2\"]', '2'),
(27, 2, 'في جدول ادارة السلوك نقوم برصد....في خانة سوابق السلوك', 'multiple_choice', 4, '[\"ماحدث بعد السلوك مباشرة\",\"ماحدث أثناء السلوك\",\"ماحدث قبل السلوك مباشرة\",\"ماحدث أثناء الملاحظه \"]', '[\"3\"]', '2'),
(28, 2, 'من عقبات وموانع التعلم', 'multiple_choice', 4, '[\"ضعف الدافعيه\",\"الهروب من العمل\",\"استثارة الذات\",\"جذب الإنتباه\"]', '[\"1\"]', '2'),
(29, 2, 'من خطوات التقييم الوظيفي للسلوك', 'multiple_choice', 4, '[\"تعريف السلوك المستهدف والبديل\",\"الملاحظه\",\"المقابله\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(30, 2, 'في التقييم الوظيفي للسلوك تكون الملاحظه بين', 'multiple_choice', 4, '[\"الأخصائي والأم\",\"الأم والطفل\",\"الأخصائي والطفل\",\"كل ماسبق\"]', '[\"3\"]', '2'),
(31, 2, 'في طريقة التعلم بالمحاولات المنفصله تكون التعليمات', 'multiple_choice', 4, '[\"بدون الف ولام\",\"بدون ظرف زمان أو مكان \",\"متعدده وبها حروف جر\",\"كل ماسبق \"]', '[\"3\"]', '2'),
(32, 2, 'من أنواع المساعدات من حيث الشده وهي أقوى أنواع المساعدات', 'multiple_choice', 4, '[\"كليه\",\"جزئيه\",\"جسميه\",\"ربع جزئيه\"]', '[\"3\"]', '2'),
(33, 2, 'في طريقة التعلم بالمحاولات المنفصله يكون عدد المحاولات.....وهو ثابت', 'multiple_choice', 4, '[\"سبعه\",\"ثمانيه\",\"سته\",\"تسعه\"]', '[\"4\"]', '2'),
(34, 2, 'من خطوات التعزيز الإيجابي.....والتي تفيد بإعطاء المعزز بكميات قليله ومتنوعه', 'multiple_choice', 4, '[\"عمل نماذج للمكافأه\",\"المكافئه التميزيه\",\"تجنب الإشباع\",\"المكافأه السلبيه\"]', '[\"3\"]', '2'),
(35, 2, 'طريقه من طرق التعلم الهدف منها تعميم استجابة الطفل من خلال المواقف والأشخاص والأدوات', 'multiple_choice', 4, '[\"التعلم بدون مساعدات\",\"التعلم بالمحاولات المنفصله\",\"التعلم في البيئه الطبيعيه\",\"التعلم بلا أخطاء\"]', '[\"3\"]', '2'),
(36, 2, 'هي طريقه من طرق التعلم الهدف منها تحقيق التعلم بدون ترك مجال للخطأ', 'multiple_choice', 4, '[\"التعلم بالمحاولات المنفصله\",\"التعلم بدون مساعدات\",\"التعلم العارضي\",\"التعلم بلا أخطاء\"]', '[\"4\"]', '2'),
(37, 2, 'من أنواع المعززات والمكافآت..', 'multiple_choice', 4, '[\"النشاطيه\",\"الإجتماعيه\",\"الماديه\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(38, 2, 'من أنواع المساعدات من حيث النوع', 'multiple_choice', 4, '[\"كليه\",\"جزئيه\",\"ربع جزئيه\",\"جميع ماسبق\"]', '[\"4\"]', '2'),
(39, 2, 'يظهر المثير المميز في طرق التعلم في التعلم', 'multiple_choice', 4, '[\"التعلم بلا أخطاء\",\"التعلم بدون مساعده\",\"بالمحاولات المنفصله\",\"في البيئة الطبيعيه\"]', '[\"3\"]', '2'),
(40, 2, 'في الاستجابات اذا كانت استجابات الطفل خاطئه يقوم المعلم ب', 'multiple_choice', 4, '[\"عقاب الطفل\",\"جذب انتباه الطفل\",\"اعادة المحاوله مره أخرى\",\"توبيخ الطفل\"]', '[\"3\"]', '2'),
(41, 2, 'اذا ظهرت عقبات وموانع التعلم بدرجه شديده نبدأ بطرق التعلم وتقديم المساعدات', 'true_false', NULL, NULL, 'false', '2'),
(42, 2, 'من وظائف السلوك ضعف التواصل البصري', 'true_false', NULL, NULL, 'false', '2'),
(43, 2, 'من خلال نظرية التعلم الشرطي لبافلوف تتكون لدى الطفل علاقات اقترانيه سلبيه فقط', 'true_false', NULL, NULL, 'false', '2'),
(44, 2, 'اتعتمداستراتيجية الABA على نظريتي الثواب والعقاب والتعلم بالمحاوله والخط', 'true_false', NULL, NULL, 'false', '2'),
(45, 2, 'المثير المحايد هو الدافع وراء السلوك', 'true_false', NULL, NULL, 'false', '2'),
(46, 2, 'في التعلم بالثواب والعقاب يتم التأكيد على العقاب لإدارة السلوك بشكل جيد', 'true_false', NULL, NULL, 'false', '2'),
(47, 2, 'في جدول ادارة السلوك نقوم برصد ماحدث قبل السلوك وبعده فقط', 'true_false', NULL, NULL, 'false', '2'),
(48, 2, 'في جدول ادارة السلوك نجيب على خمس أسئله محددات السلوك في الخانه', 'true_false', NULL, NULL, 'true', '2'),
(49, 2, 'من خلال رصد ماحدث بعد السلوك مباشرة نحصل على مآل السلوك', 'true_false', NULL, NULL, 'true', '2'),
(50, 2, 'من خلال رصد ماحدث قبل السلوك نحصل على وظيفة السلوك', 'true_false', NULL, NULL, 'true', '2'),
(51, 3, 'محمد معلم تربية خاصة في مدرسة عادية، يأتوه طلاب ذوي احتياجات خاصة في مكتبه ليتلقوا خدمات تربوية خاصة. ما نوع الخدمة التي يقدمها محمد؟', 'multiple_choice', 4, '[\"تعليم مكثف\",\"غرفة مصادر \",\"صف خاص\",\"تعليم تعاوني\"]', '[\"2\"]', '1'),
(52, 3, 'ما هو تصنيف الإعاقة الفكرية الذي يعتمد على اختبارات الذكاء كمحك للتصنيف؟', 'multiple_choice', 4, '[\"التصنيف الطبي\",\"التصنيف التربوي\",\"التصنيف النفسي\",\"التصنيف الطبيعي\"]', '[\"3\"]', '1'),
(53, 3, 'أي المقاييس التالية يستخدم لحساب نسبة الذكاء في القدرات العقلية؟', 'multiple_choice', 4, '[\"مقياس السلوك التكيفي\",\"مقياس ستانفورد بينيه\",\"مقياس رسم الرجل\",\"مقياس الإكتئاب\"]', '[\"2\"]', '1'),
(54, 3, 'وفقاً لتعريف الإعاقة الفكرية، أي من التالي يعتبر من محكات تشخيص وجود إعاقة فكرية؟	', 'multiple_choice', 4, '[\"تدني في اللغة المنطوقة\",\"صعوبة في القراءة\",\"صعوبة في الحركة\",\"تدني السلوك التكيفي\"]', '[\"4\"]', '1'),
(55, 3, 'تم تسجيل طالب جديد في أحد المراكز، واراد فريق العمل إعداد خطة تربوية خاصة به. بعد تقييم قدرات الطالب ما الخطوة التي يجب أن يتخذونها؟', 'multiple_choice', 4, '[\"تحديد جوانب القصور لدى الطالب\",\"تحديد جوانب القصور والقوة لدى الطالب\",\"وضع حدود لأداء الطالب\",\"تحديد جوانب القوة لدى الطالب\"]', '[\"2\"]', '1');

-- --------------------------------------------------------

--
-- Table structure for table `record_logins`
--

CREATE TABLE `record_logins` (
  `record_logins_id` int(11) NOT NULL,
  `user_used` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_addr` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `record_logins`
--

INSERT INTO `record_logins` (`record_logins_id`, `user_used`, `employee_id`, `class_id`, `job_title_id`, `date`, `status`, `user_agent`, `remote_addr`) VALUES
(1, 'ebaa_z@hotmail.com', 1, 0, 0, '1676254009', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', '::1'),
(2, 'ebaa_z@hotmail.com', 1, 0, 0, '1677992211', '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `report_plan`
--

CREATE TABLE `report_plan` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_type` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `active` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_plan_analysis`
--

CREATE TABLE `report_plan_analysis` (
  `id` int(11) NOT NULL,
  `report_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `response` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_plan_steps`
--

CREATE TABLE `report_plan_steps` (
  `id` int(11) NOT NULL,
  `report_plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `response` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_problem`
--

CREATE TABLE `report_problem` (
  `report_problem_id` int(11) NOT NULL,
  `where_the_problem_page` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `describe_problem` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_employee`
--

CREATE TABLE `request_employee` (
  `id` int(11) NOT NULL,
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
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_permissions_id` int(11) NOT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_permissions_id`, `job_title_id`, `type`, `description`) VALUES
(129, 2, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"1\",\"edit_student\":\"1\",\"delete_student\":\"1\",\"student_card\":\"1\",\"student_withdrawal\":\"1\",\"archive_students\":\"1\",\"student_enrollment_for_the_academic_year\":\"1\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"1\"}'),
(134, 2, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"Printing\":\"1\"}'),
(139, 2, 'case_study', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(143, 2, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(148, 2, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(153, 2, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(158, 2, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(163, 2, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(168, 2, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(171, 2, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(173, 2, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(191, 2, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete_the_parent\":\"1\",\"prevent_me_from_entering_the_platform\":\"1\",\"change_password_parent\":\"1\"}'),
(193, 2, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"1\",\"printing\":\"1\"}'),
(196, 2, 'attendance_and_absence_of_staff', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(198, 2, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(208, 2, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\",\"print_the_evaluation\":\"1\",\"add_an_evaluation_item\":\"1\",\"add_a_standard_for_evaluation\":\"1\",\"amendment_of_evaluation_item\":\"1\",\"delete_the_evaluation_item\":\"1\"}'),
(221, 2, 'manage_employee_tests', '{\"add_a_test\":\"1\",\"view_test_results\":\"1\",\"publish_and_cancel_the_test\":\"1\",\"modify_the_test\":\"1\",\"delete_test\":\"1\",\"test_management\":\"1\",\"add_test_questions\":\"1\",\"print_sheet_answers\":\"1\",\"print_the_questions_sheet\":\"1\",\"edit_a_question\":\"1\",\"delete_a_question\":\"1\"}'),
(224, 2, 'specify_a_test_for_employees', '{\"show\":\"1\",\"Specify_a_test_for_employees\":\"1\",\"view_test_results_for_employees\":\"1\"}'),
(228, 2, 'available_tests', '{\"show\":\"1\",\"available_tests\":\"1\",\"view_the_test_results_for_the_same_employee\":\"1\",\"archive_tests\":\"1\"}'),
(239, 2, 'payments', '{\"create_an_invoice\":\"1\",\"edit_an_invoice\":\"1\",\"delete_an_invoice\":\"1\",\"view_invoices\":\"1\",\"print_invoice\":\"1\",\"view_sendad_capture\":\"1\",\"print_the_document_of_arrest\":\"1\",\"payments_category_show\":\"1\",\"payments_category_add\":\"1\",\"payments_category_edit\":\"1\",\"payments_category_delete\":\"1\"}'),
(243, 2, 'discounts', '{\"show\":\"1\",\"add_a_discount\":\"1\",\"discount_adjustment\":\"1\",\"delete_a_discount\":\"1\"}'),
(247, 2, 'expenses', '{\"show\":\"1\",\"add_expenses\":\"1\",\"adjustment_of_expenses\":\"1\",\"delete_expenses\":\"1\"}'),
(251, 2, 'expenditure_categories', '{\"show\":\"1\",\"add_item_expenses\":\"1\",\"adjustment_of_expenses_item\":\"1\",\"delete_item_expenses\":\"1\"}'),
(252, 2, 'raising_student', '{\"the_possibility_of_upgrading_students\":\"1\"}'),
(260, 2, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"1\",\"edit_section\":\"1\",\"delete_section\":\"1\"}'),
(264, 2, 'threads', '{\"show\":\"1\",\"add_topic\":\"1\",\"edit_topic\":\"1\",\"delete_a_topic\":\"1\"}'),
(269, 2, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\"}'),
(274, 2, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(279, 2, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(284, 2, 'transportation_management', '{\"show\":\"1\",\"add_student_transport\":\"1\",\"print_transportation_students\":\"1\",\"delete_student_from_transfer\":\"1\",\"select_the_vehicle_for_the_area\":\"1\"}'),
(288, 2, 'areas_management', '{\"show\":\"1\",\"add_area\":\"1\",\"edit_area\":\"1\",\"delete_region\":\"1\"}'),
(289, 2, 'manage_the_employee_powers', '{\"ability_to_modify_permissions\":\"1\"}'),
(292, 2, 'send_sms_messages', '{\"show\":\"1\",\"send_a_message_to_parents\":\"1\",\"send_a_message_to_an_employee\":\"1\"}'),
(296, 2, 'vehicle_management', '{\"show\":\"1\",\"add_a_vehicle\":\"1\",\"modified_vehicle\":\"1\",\"delete_a_vehicle\":\"1\"}'),
(299, 2, 'visitor_messages', '{\"show\":\"1\",\"reply_to_visitor_messages\":\"1\",\"delete_message\":\"1\"}'),
(300, 2, 'general_settings', '{\"the_possibility_of_modification\":\"1\"}'),
(308, 2, 'website', '{\"homepage\":\"1\",\"mission_and_vision\":\"1\",\"about_the_center\":\"1\",\"blog\":\"1\",\"photo_album\":\"1\",\"sections\":\"1\",\"services\":\"1\",\"site_settings\":\"1\"}'),
(309, 2, 'search', '{\"allow_search\":\"1\"}'),
(310, 2, 'program_activity', '{\"See_program_activity\":\"1\"}'),
(312, 2, 'user_permissions', '{\"user_permissions\":\"1\",\"role_permissions\":\"1\"}'),
(331, 3, 'search', '{\"allow_search\":\"1\"}'),
(340, 3, 'website', '{\"homepage\":\"1\",\"mission_and_vision\":\"1\",\"about_the_center\":\"1\",\"blog\":\"1\",\"photo_album\":\"1\",\"sections\":\"1\",\"services\":\"1\",\"site_settings\":\"0\"}'),
(367, 3, 'available_tests', '{\"show\":\"1\",\"available_tests\":\"1\",\"view_the_test_results_for_the_same_employee\":\"1\",\"archive_tests\":\"1\"}'),
(370, 3, 'specify_a_test_for_employees', '{\"show\":\"1\",\"Specify_a_test_for_employees\":\"1\",\"view_test_results_for_employees\":\"1\"}'),
(382, 3, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\",\"print_the_evaluation\":\"1\",\"add_an_evaluation_item\":\"1\",\"add_a_standard_for_evaluation\":\"1\",\"amendment_of_evaluation_item\":\"1\",\"delete_the_evaluation_item\":\"1\"}'),
(384, 3, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(395, 3, 'manage_employee_tests', '{\"add_a_test\":\"1\",\"view_test_results\":\"1\",\"publish_and_cancel_the_test\":\"1\",\"modify_the_test\":\"1\",\"delete_test\":\"1\",\"test_management\":\"1\",\"add_test_questions\":\"1\",\"print_sheet_answers\":\"1\",\"print_the_questions_sheet\":\"1\",\"edit_a_question\":\"1\",\"delete_a_question\":\"1\"}'),
(473, 4, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(474, 4, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(476, 4, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(481, 5, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(489, 5, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(501, 5, 'attendance_and_absence_management', '{\"show\":\"0\",\"addition\":\"0\",\"delete\":\"0\"}'),
(543, 5, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(544, 4, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(554, 7, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(558, 7, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(566, 7, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(570, 7, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(576, 7, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(578, 7, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(580, 7, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(584, 8, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"Printing\":\"1\"}'),
(586, 8, 'case_study', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(590, 8, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(594, 8, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(597, 8, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(601, 8, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(605, 8, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(609, 8, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(611, 8, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(613, 8, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(615, 8, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(617, 9, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\"}'),
(619, 9, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"Printing\":\"1\"}'),
(621, 9, 'case_study', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(625, 9, 'individual_plan', '{\"show\":\"1\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(629, 9, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(633, 9, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(637, 9, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(641, 9, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(645, 9, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(647, 9, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(649, 9, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(651, 9, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(653, 10, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\"}'),
(659, 10, 'case_study', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(665, 10, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(667, 10, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(669, 10, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(671, 10, 'search', '{\"allow_search\":\"0\"}'),
(736, 11, 'transportation_management', '{\"show\":\"1\",\"add_student_transport\":\"1\",\"print_transportation_students\":\"1\",\"delete_student_from_transfer\":\"1\",\"select_the_vehicle_for_the_area\":\"1\"}'),
(740, 11, 'areas_management', '{\"show\":\"1\",\"add_area\":\"1\",\"edit_area\":\"1\",\"delete_region\":\"1\"}'),
(744, 11, 'vehicle_management', '{\"show\":\"1\",\"add_a_vehicle\":\"1\",\"modified_vehicle\":\"1\",\"delete_a_vehicle\":\"1\"}'),
(759, 11, 'search', '{\"allow_search\":\"1\"}'),
(778, 14, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(782, 14, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(786, 14, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(790, 14, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(794, 14, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(796, 14, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(798, 14, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"0\",\"edit\":\"0\",\"delete_the_parent\":\"0\",\"prevent_me_from_entering_the_platform\":\"0\",\"change_password_parent\":\"0\"}'),
(808, 15, 'case_study', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(812, 15, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(816, 15, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(824, 15, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(828, 15, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(830, 15, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(832, 15, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(834, 15, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(845, 17, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"1\",\"edit_student\":\"1\",\"delete_student\":\"1\",\"student_card\":\"1\",\"student_withdrawal\":\"1\",\"archive_students\":\"1\",\"student_enrollment_for_the_academic_year\":\"1\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"1\"}'),
(850, 17, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"Printing\":\"1\"}'),
(855, 17, 'case_study', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(860, 17, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(865, 17, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(869, 17, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(874, 17, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(879, 17, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(884, 17, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(897, 17, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(900, 17, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(909, 17, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete_the_parent\":\"1\",\"prevent_me_from_entering_the_platform\":\"1\",\"change_password_parent\":\"1\"}'),
(912, 17, 'attendance_and_absence_of_staff', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(914, 17, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"1\",\"printing\":\"1\"}'),
(925, 17, 'manage_employee_tests', '{\"add_a_test\":\"1\",\"view_test_results\":\"1\",\"publish_and_cancel_the_test\":\"1\",\"modify_the_test\":\"1\",\"delete_test\":\"1\",\"test_management\":\"1\",\"add_test_questions\":\"1\",\"print_sheet_answers\":\"1\",\"print_the_questions_sheet\":\"1\",\"edit_a_question\":\"1\",\"delete_a_question\":\"1\"}'),
(935, 17, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\",\"print_the_evaluation\":\"1\",\"add_an_evaluation_item\":\"1\",\"add_a_standard_for_evaluation\":\"1\",\"amendment_of_evaluation_item\":\"1\",\"delete_the_evaluation_item\":\"1\"}'),
(937, 17, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(940, 17, 'specify_a_test_for_employees', '{\"show\":\"1\",\"Specify_a_test_for_employees\":\"1\",\"view_test_results_for_employees\":\"1\"}'),
(944, 17, 'available_tests', '{\"show\":\"1\",\"available_tests\":\"1\",\"view_the_test_results_for_the_same_employee\":\"1\",\"archive_tests\":\"1\"}'),
(955, 17, 'payments', '{\"create_an_invoice\":\"1\",\"edit_an_invoice\":\"1\",\"delete_an_invoice\":\"1\",\"view_invoices\":\"1\",\"print_invoice\":\"1\",\"view_sendad_capture\":\"1\",\"print_the_document_of_arrest\":\"1\",\"payments_category_show\":\"1\",\"payments_category_add\":\"1\",\"payments_category_edit\":\"1\",\"payments_category_delete\":\"1\"}'),
(959, 17, 'discounts', '{\"show\":\"1\",\"add_a_discount\":\"1\",\"discount_adjustment\":\"1\",\"delete_a_discount\":\"1\"}'),
(963, 17, 'expenses', '{\"show\":\"1\",\"add_expenses\":\"1\",\"adjustment_of_expenses\":\"1\",\"delete_expenses\":\"1\"}'),
(967, 17, 'expenditure_categories', '{\"show\":\"1\",\"add_item_expenses\":\"1\",\"adjustment_of_expenses_item\":\"1\",\"delete_item_expenses\":\"1\"}'),
(971, 17, 'manage_classes', '{\"show\":\"1\",\"add_a_chapter\":\"1\",\"edit_a_chapter\":\"1\",\"delete_a_chapter\":\"1\"}'),
(975, 17, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"1\",\"edit_section\":\"1\",\"delete_section\":\"1\"}'),
(976, 17, 'raising_student', '{\"the_possibility_of_upgrading_students\":\"1\"}'),
(980, 17, 'threads', '{\"show\":\"1\",\"add_topic\":\"1\",\"edit_topic\":\"1\",\"delete_a_topic\":\"1\"}'),
(985, 17, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\"}'),
(990, 17, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(994, 17, 'areas_management', '{\"show\":\"1\",\"add_area\":\"1\",\"edit_area\":\"1\",\"delete_region\":\"1\"}'),
(999, 17, 'transportation_management', '{\"show\":\"1\",\"add_student_transport\":\"1\",\"print_transportation_students\":\"1\",\"delete_student_from_transfer\":\"1\",\"select_the_vehicle_for_the_area\":\"1\"}'),
(1004, 17, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(1008, 17, 'vehicle_management', '{\"show\":\"1\",\"add_a_vehicle\":\"1\",\"modified_vehicle\":\"1\",\"delete_a_vehicle\":\"1\"}'),
(1011, 17, 'visitor_messages', '{\"show\":\"1\",\"reply_to_visitor_messages\":\"0\",\"delete_message\":\"0\"}'),
(1012, 17, 'general_settings', '{\"the_possibility_of_modification\":\"1\"}'),
(1020, 17, 'website', '{\"homepage\":\"1\",\"mission_and_vision\":\"1\",\"about_the_center\":\"1\",\"blog\":\"1\",\"photo_album\":\"1\",\"sections\":\"1\",\"services\":\"1\",\"site_settings\":\"1\"}'),
(1021, 17, 'search', '{\"allow_search\":\"1\"}'),
(1022, 17, 'program_activity', '{\"See_program_activity\":\"1\"}'),
(1024, 17, 'user_permissions', '{\"user_permissions\":\"1\",\"role_permissions\":\"1\"}'),
(1025, 17, 'manage_the_employee_powers', '{\"ability_to_modify_permissions\":\"1\"}'),
(1032, 28, 'case_study', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1038, 28, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1042, 28, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1046, 28, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1050, 28, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1054, 28, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1058, 28, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1060, 28, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1062, 28, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1094, 27, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"0\",\"delete_section\":\"0\"}'),
(1095, 27, 'threads', '{\"show\":\"1\",\"add_topic\":\"0\",\"edit_topic\":\"0\",\"delete_a_topic\":\"0\"}'),
(1097, 27, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1114, 20, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"Printing\":\"1\"}'),
(1116, 20, 'case_study', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1117, 20, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"0\"}'),
(1119, 20, 'individual_plan', '{\"show\":\"1\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1121, 20, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1123, 20, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1125, 20, 'record_assignments', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1127, 20, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1129, 20, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1131, 20, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1134, 20, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(1137, 20, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"0\",\"edit\":\"0\",\"delete_the_parent\":\"0\",\"prevent_me_from_entering_the_platform\":\"0\",\"change_password_parent\":\"1\"}'),
(1139, 20, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1141, 20, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1143, 20, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1144, 20, 'threads', '{\"show\":\"1\",\"add_topic\":\"0\",\"edit_topic\":\"0\",\"delete_a_topic\":\"0\"}'),
(1154, 5, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1164, 5, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1168, 4, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1177, 28, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"0\"}'),
(1187, 11, 'follow_daily_sessions', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1190, 11, 'model_of_daily_follow_up_targets', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1194, 11, 'skills_assessment_reports', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1196, 11, 'individual_plan_report', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1198, 11, 'record_assignments', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1204, 11, 'raising_student', '{\"the_possibility_of_upgrading_students\":\"1\"}'),
(1212, 11, 'send_sms_messages', '{\"show\":\"0\",\"send_a_message_to_parents\":\"0\",\"send_a_message_to_an_employee\":\"0\"}'),
(1215, 11, 'visitor_messages', '{\"show\":\"0\",\"reply_to_visitor_messages\":\"0\",\"delete_message\":\"0\"}'),
(1223, 11, 'website', '{\"homepage\":\"0\",\"mission_and_vision\":\"0\",\"about_the_center\":\"0\",\"blog\":\"0\",\"photo_album\":\"0\",\"sections\":\"0\",\"services\":\"0\",\"site_settings\":\"0\"}'),
(1237, 15, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"1\",\"add_services_to_the_student\":\"0\"}'),
(1241, 26, 'student', '{\"view_all_students\":\"0\",\"view_the_student_file\":\"0\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1266, 26, 'attendance_and_absence_of_staff', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"1\"}'),
(1268, 26, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1270, 26, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(1280, 26, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"evaluation_management\":\"1\",\"print_the_evaluation\":\"1\",\"add_an_evaluation_item\":\"1\",\"add_a_standard_for_evaluation\":\"1\",\"amendment_of_evaluation_item\":\"1\",\"delete_the_evaluation_item\":\"1\"}'),
(1296, 26, 'manage_the_employee_powers', '{\"ability_to_modify_permissions\":\"0\"}'),
(1310, 11, 'services_provided_to_the_student', '{\"view_the_services_panel\":\"1\",\"modify_the_services_provided\":\"1\",\"delete_the_services_provided\":\"1\"}'),
(1315, 27, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1319, 27, 'individual_plan', '{\"show\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1321, 27, 'follow_daily_sessions', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1323, 27, 'model_of_daily_follow_up_targets', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1325, 27, 'individual_plan_report', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1327, 27, 'skills_assessment_reports', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1333, 27, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1348, 27, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"0\",\"printing\":\"0\"}'),
(1355, 27, 'website', '{\"homepage\":\"0\",\"mission_and_vision\":\"0\",\"about_the_center\":\"0\",\"blog\":\"0\",\"photo_album\":\"0\",\"sections\":\"0\",\"services\":\"0\",\"site_settings\":\"0\"}'),
(1390, 3, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"0\"}'),
(1392, 3, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"0\"}'),
(1400, 3, 'attendance_and_absence_report_for_the_employee', '{\"show\":\"0\",\"printing\":\"0\"}'),
(1401, 3, 'raising_student', '{\"the_possibility_of_upgrading_students\":\"1\"}'),
(1410, 3, 'send_sms_messages', '{\"show\":\"0\",\"send_a_message_to_parents\":\"0\",\"send_a_message_to_an_employee\":\"0\"}'),
(1411, 3, 'program_activity', '{\"See_program_activity\":\"0\"}'),
(1415, 3, 'visitor_messages', '{\"show\":\"0\",\"reply_to_visitor_messages\":\"0\",\"delete_message\":\"0\"}'),
(1416, 3, 'distribution_of_students_to_specialists', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1417, 3, 'case_study', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1419, 3, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1420, 3, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1421, 3, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1422, 3, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1434, 3, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"1\",\"delete_section\":\"0\"}'),
(1436, 3, 'threads', '{\"show\":\"1\",\"add_topic\":\"1\",\"edit_topic\":\"1\",\"delete_a_topic\":\"0\"}'),
(1439, 3, 'feedback_on_staff', '{\"add_new_note_type_employees\":\"1\",\"display_list_of_note_types\":\"1\",\"edit_note_types\":\"1\",\"delete_note_types\":\"0\"}'),
(1442, 3, 'staff_accountability', '{\"view_type_accountability\":\"1\",\"add_type_accountability\":\"1\",\"edit_type_accountability\":\"1\",\"delete_type_accountability\":\"0\"}'),
(1452, 3, 'exams_employee', '{\"management_tests\":\"1\",\"publish_and_cancel_the_test\":\"1\",\"add_test\":\"1\",\"modified_test\":\"1\",\"delete_test\":\"1\",\"add_question\":\"1\",\"edit_question\":\"1\",\"delete_question\":\"1\",\"print_sheet_answers\":\"1\",\"print_the_questions_sheet\":\"1\"}'),
(1456, 3, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1458, 4, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1462, 4, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1463, 3, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(1464, 3, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"1\",\"printing\":\"1\"}'),
(1465, 5, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1467, 5, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1468, 5, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"0\"}'),
(1471, 5, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"0\"}'),
(1473, 6, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1477, 6, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1480, 6, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1486, 6, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1488, 6, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1490, 6, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1494, 6, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1497, 6, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1498, 6, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1501, 7, 'case_study', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1504, 7, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\"}'),
(1507, 10, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1521, 11, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1527, 11, 'case_study', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1528, 11, 'individual_plan', '{\"show\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1542, 11, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"1\",\"edit_student\":\"1\",\"delete_student\":\"0\",\"student_card\":\"1\",\"student_withdrawal\":\"0\",\"archive_students\":\"1\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"1\"}'),
(1547, 11, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"0\",\"delete\":\"0\"}'),
(1549, 11, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1551, 11, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete_the_parent\":\"0\",\"prevent_me_from_entering_the_platform\":\"0\",\"change_password_parent\":\"0\"}'),
(1555, 11, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"0\",\"delete_section\":\"0\"}'),
(1559, 11, 'threads', '{\"show\":\"1\",\"add_topic\":\"0\",\"edit_topic\":\"0\",\"delete_a_topic\":\"0\"}'),
(1560, 11, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"0\"}'),
(1564, 11, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"0\"}'),
(1565, 14, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1566, 14, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1570, 14, 'case_study', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1573, 14, 'attendance_and_absence_management', '{\"show\":\"0\",\"addition\":\"0\",\"delete\":\"0\"}'),
(1577, 14, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(1587, 14, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"0\",\"evaluation_management\":\"0\",\"print_the_evaluation\":\"1\",\"add_an_evaluation_item\":\"0\",\"add_a_standard_for_evaluation\":\"0\",\"amendment_of_evaluation_item\":\"0\",\"delete_the_evaluation_item\":\"0\"}'),
(1588, 14, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"0\",\"delete_section\":\"0\"}'),
(1589, 14, 'threads', '{\"show\":\"1\",\"add_topic\":\"0\",\"edit_topic\":\"0\",\"delete_a_topic\":\"0\"}'),
(1593, 14, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1596, 14, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1598, 14, 'visitor_messages', '{\"show\":\"1\",\"reply_to_visitor_messages\":\"1\",\"delete_message\":\"0\"}'),
(1599, 14, 'feedback_on_staff', '{\"add_new_note_type_employees\":\"1\",\"display_list_of_note_types\":\"1\",\"edit_note_types\":\"0\",\"delete_note_types\":\"0\"}'),
(1600, 14, 'staff_accountability', '{\"view_type_accountability\":\"0\",\"add_type_accountability\":\"0\",\"edit_type_accountability\":\"0\",\"delete_type_accountability\":\"1\"}'),
(1601, 15, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1609, 15, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1611, 15, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"0\",\"edit\":\"0\",\"delete_the_parent\":\"0\",\"prevent_me_from_entering_the_platform\":\"0\",\"change_password_parent\":\"0\"}'),
(1617, 15, 'attendance_and_absence_management', '{\"show\":\"0\",\"addition\":\"0\",\"delete\":\"0\"}'),
(1625, 15, 'evaluation_of_staff', '{\"evaluation_Officer\":\"1\",\"view_evaluation_results\":\"1\"}'),
(1628, 15, 'personnel_evaluation_department', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"0\",\"evaluation_management\":\"0\",\"print_the_evaluation\":\"0\",\"add_an_evaluation_item\":\"0\",\"add_a_standard_for_evaluation\":\"0\",\"amendment_of_evaluation_item\":\"0\",\"delete_the_evaluation_item\":\"0\"}'),
(1629, 15, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"0\",\"delete_section\":\"0\"}'),
(1630, 15, 'threads', '{\"show\":\"1\",\"add_topic\":\"0\",\"edit_topic\":\"0\",\"delete_a_topic\":\"0\"}'),
(1632, 15, 'manage_the_employee_powers', '{\"ability_to_modify_permissions\":\"1\"}'),
(1633, 15, 'visitor_messages', '{\"show\":\"1\",\"reply_to_visitor_messages\":\"0\",\"delete_message\":\"0\"}'),
(1635, 15, 'feedback_on_staff', '{\"add_new_note_type_employees\":\"1\",\"display_list_of_note_types\":\"1\",\"edit_note_types\":\"0\",\"delete_note_types\":\"0\"}'),
(1636, 26, 'department_of_departments', '{\"show\":\"1\",\"add_section\":\"0\",\"edit_section\":\"0\",\"delete_section\":\"0\"}'),
(1639, 26, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1642, 26, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1646, 26, 'areas_management', '{\"show\":\"0\",\"add_area\":\"0\",\"edit_area\":\"0\",\"delete_region\":\"0\"}'),
(1647, 26, 'vehicle_management', '{\"show\":\"0\",\"add_a_vehicle\":\"0\",\"modified_vehicle\":\"0\",\"delete_a_vehicle\":\"1\"}'),
(1655, 26, 'website', '{\"homepage\":\"0\",\"mission_and_vision\":\"0\",\"about_the_center\":\"0\",\"blog\":\"0\",\"photo_album\":\"0\",\"sections\":\"0\",\"services\":\"0\",\"site_settings\":\"0\"}'),
(1658, 26, 'services_provided_to_the_student', '{\"view_the_services_panel\":\"0\",\"modify_the_services_provided\":\"0\",\"delete_the_services_provided\":\"0\"}'),
(1665, 26, 'staff_accountability', '{\"view_type_accountability\":\"1\",\"add_type_accountability\":\"1\",\"edit_type_accountability\":\"1\",\"delete_type_accountability\":\"1\"}'),
(1666, 26, 'feedback_on_staff', '{\"add_new_note_type_employees\":\"1\",\"display_list_of_note_types\":\"1\",\"edit_note_types\":\"1\",\"delete_note_types\":\"1\"}'),
(1676, 26, 'exams_employee', '{\"management_tests\":\"1\",\"publish_and_cancel_the_test\":\"1\",\"add_test\":\"1\",\"modified_test\":\"1\",\"delete_test\":\"1\",\"add_question\":\"1\",\"edit_question\":\"1\",\"delete_question\":\"1\",\"print_sheet_answers\":\"1\",\"print_the_questions_sheet\":\"1\"}'),
(1677, 28, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1685, 28, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1687, 27, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1690, 27, 'case_study', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1691, 27, 'record_assignments', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1693, 27, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"1\",\"delete\":\"0\"}'),
(1697, 27, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"0\",\"edit\":\"0\",\"delete_the_parent\":\"0\",\"prevent_me_from_entering_the_platform\":\"0\",\"change_password_parent\":\"0\"}'),
(1702, 27, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"evaluation_management\":\"0\"}'),
(1712, 27, 'areas_management', '{\"show\":\"1\",\"add_area\":\"1\",\"edit_area\":\"0\",\"delete_region\":\"0\"}'),
(1714, 27, 'vehicle_management', '{\"show\":\"1\",\"add_a_vehicle\":\"1\",\"modified_vehicle\":\"0\",\"delete_a_vehicle\":\"0\"}'),
(1716, 27, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1717, 27, 'transportation_management', '{\"show\":\"1\",\"add_student_transport\":\"1\",\"print_transportation_students\":\"0\",\"delete_student_from_transfer\":\"0\",\"select_the_vehicle_for_the_area\":\"1\"}'),
(1718, 27, 'manage_the_employee_powers', '{\"ability_to_modify_permissions\":\"0\"}'),
(1720, 27, 'feedback_on_staff', '{\"add_new_note_type_employees\":\"1\",\"display_list_of_note_types\":\"1\",\"edit_note_types\":\"0\",\"delete_note_types\":\"0\"}'),
(1730, 4, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1732, 5, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1733, 6, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1734, 7, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1739, 31, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1743, 31, 'follow_daily_sessions', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1747, 31, 'model_of_daily_follow_up_targets', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1752, 31, 'individual_plan_report', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1756, 31, 'skills_assessment_reports', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1758, 31, 'attendance_and_absence_management', '{\"show\":\"0\",\"addition\":\"0\",\"delete\":\"0\"}'),
(1759, 31, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"0\"}'),
(1763, 31, 'record_assignments', '{\"show\":\"1\",\"addition\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\"}'),
(1770, 31, 'class_schedule', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1774, 31, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"1\",\"modify_quota\":\"1\",\"delete_share\":\"0\",\"printing\":\"1\"}'),
(1776, 31, 'schedule_permission', '{\"schedule_add\":\"1\",\"schedule_edit\":\"1\",\"schedule_delete\":\"0\"}'),
(1780, 6, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"evaluation_management\":\"0\"}'),
(1792, 8, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1798, 4, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"1\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1800, 5, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1802, 6, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1804, 7, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1806, 16, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1808, 28, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"1\",\"add_services_to_the_student\":\"0\"}'),
(1810, 31, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"0\",\"edit_student\":\"0\",\"delete_student\":\"0\",\"student_card\":\"0\",\"student_withdrawal\":\"0\",\"archive_students\":\"0\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"0\",\"behavior_modification\":\"0\",\"add_services_to_the_student\":\"0\"}'),
(1817, 7, 'distribution_of_students_to_specialists', '{\"show\":\"0\",\"addition\":\"0\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"0\"}'),
(1818, 3, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"1\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1819, 3, 'student_assessment_case', '{\"delete\":\"1\",\"show\":\"1\",\"print\":\"1\"}'),
(1820, 3, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"1\"}'),
(1822, 3, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"1\",\"edit_rating\":\"1\",\"delete_rating\":\"1\",\"management\":\"1\",\"print\":\"1\"}'),
(1823, 3, 'chats', '{\"show\":\"1\"}'),
(1824, 3, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1826, 4, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1828, 5, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}');
INSERT INTO `role_permissions` (`role_permissions_id`, `job_title_id`, `type`, `description`) VALUES
(1830, 6, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1832, 7, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1833, 14, 'chats', '{\"show\":\"1\"}'),
(1834, 14, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1835, 15, 'chats', '{\"show\":\"1\"}'),
(1836, 15, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1837, 26, 'chats', '{\"show\":\"1\"}'),
(1838, 26, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1840, 28, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1842, 31, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1843, 15, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1844, 14, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1845, 4, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1846, 5, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1847, 7, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1848, 28, 'management_of_student_assessment', '{\"show\":\"1\",\"add_rating\":\"0\",\"edit_rating\":\"0\",\"delete_rating\":\"0\",\"management\":\"1\",\"print\":\"0\"}'),
(1849, 27, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1851, 11, 'chats', '{\"show\":\"0\"}'),
(1852, 11, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1854, 7, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1856, 5, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1857, 5, 'chats', '{\"show\":\"0\"}'),
(1859, 6, 'chats', '{\"show\":\"0\"}'),
(1860, 7, 'chats', '{\"show\":\"0\"}'),
(1861, 31, 'chats', '{\"show\":\"0\"}'),
(1862, 28, 'chats', '{\"show\":\"0\"}'),
(1863, 4, 'attendance_and_absence_report', '{\"show\":\"1\",\"printing\":\"0\"}'),
(1864, 4, 'attendance_and_absence_management', '{\"show\":\"1\",\"addition\":\"0\",\"delete\":\"0\"}'),
(1867, 4, 'study_schedule_for_specialists', '{\"show\":\"1\",\"add_a_share\":\"0\",\"modify_quota\":\"0\",\"delete_share\":\"0\",\"printing\":\"0\"}'),
(1868, 10, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1869, 29, 'group_chats', '{\"show\":\"1\",\"add_group\":\"0\",\"edit_group\":\"0\",\"delete_group\":\"0\"}'),
(1871, 10, 'chats', '{\"show\":\"0\"}'),
(1872, 2, 'employees_chats', '{\"show\":\"1\"}'),
(1874, 2, 'chats', '{\"show\":\"0\"}'),
(1878, 2, 'group_chats', '{\"show\":\"1\",\"add_group\":\"1\",\"edit_group\":\"1\",\"delete_group\":\"1\"}'),
(1879, 3, 'employees_chats', '{\"show\":\"1\"}'),
(1880, 4, 'employees_chats', '{\"show\":\"1\"}'),
(1881, 5, 'employees_chats', '{\"show\":\"1\"}'),
(1882, 6, 'employees_chats', '{\"show\":\"1\"}'),
(1883, 7, 'employees_chats', '{\"show\":\"1\"}'),
(1884, 8, 'employees_chats', '{\"show\":\"1\"}'),
(1885, 9, 'employees_chats', '{\"show\":\"1\"}'),
(1886, 10, 'employees_chats', '{\"show\":\"1\"}'),
(1887, 11, 'employees_chats', '{\"show\":\"1\"}'),
(1888, 12, 'employees_chats', '{\"show\":\"1\"}'),
(1889, 13, 'employees_chats', '{\"show\":\"1\"}'),
(1890, 14, 'employees_chats', '{\"show\":\"1\"}'),
(1891, 15, 'employees_chats', '{\"show\":\"1\"}'),
(1892, 16, 'employees_chats', '{\"show\":\"1\"}'),
(1893, 17, 'employees_chats', '{\"show\":\"1\"}'),
(1894, 18, 'employees_chats', '{\"show\":\"1\"}'),
(1895, 19, 'employees_chats', '{\"show\":\"1\"}'),
(1896, 20, 'employees_chats', '{\"show\":\"1\"}'),
(1897, 21, 'employees_chats', '{\"show\":\"1\"}'),
(1898, 22, 'employees_chats', '{\"show\":\"1\"}'),
(1899, 23, 'employees_chats', '{\"show\":\"1\"}'),
(1900, 24, 'employees_chats', '{\"show\":\"1\"}'),
(1901, 25, 'employees_chats', '{\"show\":\"1\"}'),
(1902, 26, 'employees_chats', '{\"show\":\"1\"}'),
(1903, 27, 'employees_chats', '{\"show\":\"1\"}'),
(1904, 27, 'chats', '{\"show\":\"1\"}'),
(1905, 28, 'employees_chats', '{\"show\":\"1\"}'),
(1906, 29, 'employees_chats', '{\"show\":\"1\"}'),
(1907, 31, 'employees_chats', '{\"show\":\"1\"}'),
(1911, 4, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1913, 5, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1914, 6, 'individual_plan', '{\"show\":\"1\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1915, 7, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1916, 14, 'individual_plan', '{\"show\":\"1\",\"modify\":\"0\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1917, 15, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1918, 28, 'individual_plan', '{\"show\":\"1\",\"modify\":\"1\",\"delete\":\"0\",\"printing\":\"1\",\"delete_goal\":\"1\"}'),
(1919, 31, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1920, 4, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1921, 6, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1924, 28, 'student_assessment_case', '{\"delete\":\"0\",\"show\":\"1\",\"print\":\"1\"}'),
(1926, 4, 'chats', '{\"show\":\"0\"}'),
(1949, 4, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1950, 5, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1951, 6, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1952, 7, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1956, 31, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1971, 2, 'employee', '{\"show_all_account\":\"1\",\"view_employee_profile\":\"1\",\"add_employee\":\"1\",\"adjustment_officer\":\"1\",\"delete_employee\":\"1\",\"the_resignation_of_an_employee\":\"1\",\"return_an_employee_to_work\":\"1\",\"staff_archive\":\"1\",\"prevent_an_employee_from_entering_the_platform\":\"1\",\"change_password_employee\":\"1\",\"upload_files_to_employee\":\"1\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1972, 3, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"1\",\"add_new_notes_on_employees\":\"1\",\"view_accountability_to_employee\":\"1\",\"add_accountability_to_employee\":\"1\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"1\",\"possibility_testing_employee\":\"1\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1976, 8, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1980, 9, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1984, 10, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1986, 11, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1990, 12, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(1994, 13, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2005, 14, 'employee', '{\"show_all_account\":\"1\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"1\",\"add_new_notes_on_employees\":\"1\",\"view_accountability_to_employee\":\"1\",\"add_accountability_to_employee\":\"1\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2015, 15, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"1\",\"add_new_notes_on_employees\":\"1\",\"view_accountability_to_employee\":\"1\",\"add_accountability_to_employee\":\"1\",\"edit_accountability_to_employee\":\"1\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2021, 16, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2025, 17, 'employee', '{\"show_all_account\":\"1\",\"view_employee_profile\":\"1\",\"add_employee\":\"1\",\"adjustment_officer\":\"1\",\"delete_employee\":\"1\",\"the_resignation_of_an_employee\":\"1\",\"return_an_employee_to_work\":\"1\",\"staff_archive\":\"1\",\"prevent_an_employee_from_entering_the_platform\":\"1\",\"change_password_employee\":\"1\",\"upload_files_to_employee\":\"1\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2033, 18, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2037, 19, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2041, 20, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2045, 21, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2049, 22, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2053, 23, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2057, 24, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2061, 25, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2062, 26, 'employee', '{\"show_all_account\":\"1\",\"view_employee_profile\":\"1\",\"add_employee\":\"1\",\"adjustment_officer\":\"1\",\"delete_employee\":\"1\",\"the_resignation_of_an_employee\":\"1\",\"return_an_employee_to_work\":\"1\",\"staff_archive\":\"1\",\"prevent_an_employee_from_entering_the_platform\":\"1\",\"change_password_employee\":\"1\",\"upload_files_to_employee\":\"1\",\"view_notes_on_employees\":\"1\",\"add_new_notes_on_employees\":\"1\",\"view_accountability_to_employee\":\"1\",\"add_accountability_to_employee\":\"1\",\"edit_accountability_to_employee\":\"1\",\"delete_accountability_to_employee\":\"1\",\"set_test_date_for_employees\":\"1\",\"possibility_testing_employee\":\"1\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2064, 27, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"1\",\"add_new_notes_on_employees\":\"1\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2072, 28, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2073, 29, 'employee', '{\"show_all_account\":\"0\",\"view_employee_profile\":\"0\",\"add_employee\":\"0\",\"adjustment_officer\":\"0\",\"delete_employee\":\"0\",\"the_resignation_of_an_employee\":\"0\",\"return_an_employee_to_work\":\"0\",\"staff_archive\":\"0\",\"prevent_an_employee_from_entering_the_platform\":\"0\",\"change_password_employee\":\"0\",\"upload_files_to_employee\":\"0\",\"view_notes_on_employees\":\"0\",\"add_new_notes_on_employees\":\"0\",\"view_accountability_to_employee\":\"0\",\"add_accountability_to_employee\":\"0\",\"edit_accountability_to_employee\":\"0\",\"delete_accountability_to_employee\":\"0\",\"set_test_date_for_employees\":\"0\",\"possibility_testing_employee\":\"0\",\"test_results_for_employee_himself\":\"1\",\"archive_tests_for_employee_himself\":\"1\",\"employee_tested_results\":\"1\",\"take_the_test\":\"1\"}'),
(2074, 14, 'student_assessment_case', '{\"delete\":\"1\",\"show\":\"1\",\"print\":\"1\"}'),
(2075, 15, 'student_assessment_case', '{\"delete\":\"1\",\"show\":\"1\",\"print\":\"1\"}'),
(2080, 3, 'parents', '{\"show\":\"1\",\"view_parents_profile\":\"1\",\"add\":\"1\",\"edit\":\"1\",\"delete_the_parent\":\"1\",\"prevent_me_from_entering_the_platform\":\"1\",\"change_password_parent\":\"1\"}'),
(2081, 3, 'student', '{\"view_all_students\":\"1\",\"view_the_student_file\":\"1\",\"add_student\":\"1\",\"edit_student\":\"1\",\"delete_student\":\"0\",\"student_card\":\"1\",\"student_withdrawal\":\"0\",\"archive_students\":\"1\",\"student_enrollment_for_the_academic_year\":\"0\",\"upload_files_to_student\":\"1\",\"behavior_modification\":\"1\",\"add_services_to_the_student\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `routine_specialist_withdrawal`
--

CREATE TABLE `routine_specialist_withdrawal` (
  `routine_specialist_withdrawal_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `time_start` int(11) DEFAULT NULL,
  `time_end` int(11) DEFAULT NULL,
  `time_start_min` int(11) DEFAULT NULL,
  `time_end_min` int(11) DEFAULT NULL,
  `day` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `cod_time_start` int(11) DEFAULT NULL,
  `cod_time_end` int(11) DEFAULT NULL,
  `year` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `year` varchar(10) NOT NULL,
  `active` int(11) DEFAULT 1,
  `class_id` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_subject`
--

CREATE TABLE `schedule_subject` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `active` int(11) DEFAULT 1,
  `datetime` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_subject_student`
--

CREATE TABLE `schedule_subject_student` (
  `schedule_id` int(11) DEFAULT NULL,
  `schedule_subject_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `nick_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 0,
  `teacher_id` int(11) DEFAULT NULL,
  `teacher_id_2` int(11) DEFAULT NULL,
  `teacher_id_3` int(11) DEFAULT NULL,
  `teacher_id_4` int(11) DEFAULT NULL,
  `teacher_id_5` int(11) DEFAULT NULL,
  `assistant_teacher_id` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `date_created` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_delete` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_employee`
--

CREATE TABLE `section_employee` (
  `section_employee_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `job` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_schedule`
--

CREATE TABLE `section_schedule` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `year` varchar(10) NOT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section_schedule_subject`
--

CREATE TABLE `section_schedule_subject` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services_provided`
--

CREATE TABLE `services_provided` (
  `services_provided_id` int(11) NOT NULL,
  `services_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `available` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'available/0=unavailable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `services_provided`
--

INSERT INTO `services_provided` (`services_provided_id`, `services_type`, `name`, `description`, `job_title_id`, `active`, `available`) VALUES
(1, 'educational_service', 'الخدمات التأهيلية الاساسية', 'خدمات تدريب ورعاية ذوي الاحتياجات الخاصة والتأهيل النفسي والاجتماعي', '4,8,14,15,28', 1, 1),
(2, 'educational_service', 'خدمة العلاج الطبيعي', '', '6', 1, 1),
(3, 'educational_service', 'خدمة العلاج الوظيفي', '', '5', 1, 1),
(4, 'educational_service', 'خدمة النطق', '', '7', 1, 1),
(5, 'educational_service', 'خدمة التوحد', '', '4,14,15,28', 1, 1),
(6, 'logistic_service', 'خدمة النقل', '', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `type` longtext DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `type`, `description`) VALUES
(1, 'system_name', 'مركز '),
(2, 'system_title', 'مركز '),
(3, 'address', NULL),
(43, 'storage_space', '5'),
(4, 'phone', '0500000000'),
(6, 'currency', 'SR'),
(7, 'system_email', 'center_email@gmail.com'),
(20, 'active_sms_service', NULL),
(11, 'language', NULL),
(37, 'tax_number', '000000000000000'),
(21, 'running_year', '2022-2023'),
(29, 'expiration_date', '2023-03-13'),
(30, 'balance_SMS', '0'),
(31, 'max_file', '5000'),
(32, 'max_size', '2048'),
(33, 'sender', 'taheelweb'),
(34, 'mobile', '966534046405'),
(35, 'password', 'ryanebaa5354530'),
(36, 'printed_footer', 'تحت إشراف وزارة العمل والتنمية الإجتماعية - ترخيص رقم 000'),
(39, 'retrieve_password_using_sms', NULL),
(40, 'website_status', 'active'),
(41, 'website_disabled_time', '2022-06-06 16:08:08'),
(42, 'prefix', '_rc'),
(44, 'center_type', 'day_care'),
(45, 'c_name', 'undefined');

-- --------------------------------------------------------

--
-- Table structure for table `step_material`
--

CREATE TABLE `step_material` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `material_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `material_title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `step_standard`
--

CREATE TABLE `step_standard` (
  `step_standard_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `group_no` int(11) DEFAULT 0,
  `group_name` varchar(50) NOT NULL DEFAULT '',
  `abbr` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `step_standard`
--

INSERT INTO `step_standard` (`step_standard_id`, `name`, `value`, `active`, `group_no`, `group_name`, `abbr`) VALUES
(1, 'مساعدة جسدية', 1, 1, 1, 'معيار أدائي', 'م.ج'),
(2, 'مساعدة لفظية', 2, 1, 1, 'معيار أدائي', 'م.ل'),
(3, 'باشراف', 3, 1, 1, 'معيار أدائي', 'ش'),
(4, 'استقلالية', 4, 1, 1, 'معيار أدائي', 'س'),
(5, 'متقن', 2, 1, 2, 'معيار معرفي', '&check;'),
(6, 'غير متقن', 1, 1, 2, 'معيار معرفي', '&cross;'),
(7, 'غير متقن', 10, 1, 3, 'معيار نوع المساعدة', '&cross;'),
(8, 'مساعدة جسدية', 11, 1, 3, 'معيار نوع المساعدة', 'ج'),
(9, 'مساعدة لفظية', 12, 1, 3, 'معيار نوع المساعدة', 'ل'),
(10, 'بالتقليد', 13, 1, 3, 'معيار نوع المساعدة', 'ت'),
(11, 'متقن', 14, 1, 3, 'معيار نوع المساعدة', '&check;'),
(12, 'غير متقن', 21, 1, 4, 'معيار درجة المساعدة', '&cross;'),
(13, 'مساعدة جسدية كاملة', 22, 1, 4, 'معيار درجة المساعدة', 'م ج ك'),
(14, 'مساعدة جسدية خفيفة', 23, 1, 4, 'معيار درجة المساعدة', 'م ج خ'),
(15, 'مساعدة لفظية', 24, 1, 4, 'معيار درجة المساعدة', 'م ل'),
(16, 'بالتقليد', 25, 1, 4, 'معيار درجة المساعدة', 'ت'),
(17, 'بدون مساعدة', 26, 1, 4, 'معيار درجة المساعدة', 'ب د'),
(18, 'متقن', 27, 1, 4, 'معيار درجة المساعدة', '&check;'),
(19, 'دائما', 30, 1, 5, 'معيار نفسي', 'د'),
(20, 'أحياناً', 31, 1, 5, 'معيار نفسي', 'أ'),
(21, 'نادراً', 32, 1, 5, 'معيار نفسي', 'ن'),
(22, 'ابداً', 33, 1, 5, 'معيار نفسي', 'ب');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_identity` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `beneficiary_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_birth` int(11) DEFAULT 0,
  `birthday` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disability_category` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `more_specific_type_disability` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` mediumint(9) DEFAULT NULL,
  `address` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `degree_kinship` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_admission` int(11) NOT NULL DEFAULT 0,
  `admission_year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `more_specific_type_disability_2` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `deleted` int(11) NOT NULL DEFAULT 0,
  `encrypt_thread` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `img_type` tinyint(4) NOT NULL DEFAULT 1,
  `img_url` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_to_specialists`
--

CREATE TABLE `students_to_specialists` (
  `students_to_specialists_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_assessment`
--

CREATE TABLE `student_assessment` (
  `id` int(11) NOT NULL,
  `assessment_name` varchar(100) NOT NULL,
  `disability_id` int(11) DEFAULT NULL,
  `disability_level_id` int(11) DEFAULT 0,
  `datetime_stamp` datetime DEFAULT NULL,
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_behaviour`
--

CREATE TABLE `student_behaviour` (
  `id` int(11) NOT NULL,
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
  `year` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_behaviour_reptitions`
--

CREATE TABLE `student_behaviour_reptitions` (
  `id` int(11) NOT NULL,
  `behaviour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `reptition` int(5) NOT NULL,
  `notes` varchar(1000) DEFAULT '',
  `active` int(11) DEFAULT 1,
  `datetime_stamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_behaviour_strategy`
--

CREATE TABLE `student_behaviour_strategy` (
  `id` int(11) NOT NULL,
  `student_behvaiour_id` int(11) NOT NULL,
  `note1` varchar(500) NOT NULL,
  `note2` varchar(500) NOT NULL,
  `note3` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_parent`
--

CREATE TABLE `student_parent` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_plan`
--

CREATE TABLE `student_plan` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_age` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `active` char(1) DEFAULT '1',
  `plan_name` varchar(200) DEFAULT '',
  `running_year` varchar(25) DEFAULT '',
  `year` varchar(20) DEFAULT '',
  `assessment_case_id` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_plan_analysis`
--

CREATE TABLE `student_plan_analysis` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1',
  `analysis_progress` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_plan_steps`
--

CREATE TABLE `student_plan_steps` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `active` char(1) DEFAULT '1',
  `step_progress` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_record`
--

CREATE TABLE `student_record` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key_id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `parent_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_services`
--

CREATE TABLE `student_services` (
  `student_services_id` int(11) NOT NULL,
  `services_provided_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_account` int(11) DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `job_title_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(64) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `name`, `class_id`, `job_title_id`, `level`, `icon`) VALUES
(1, 'قراءة', 1, '4', '1', '1e2dd69c-8f2a-4821-9fb4-4333a7f4bf52.jpg'),
(2, 'رياضيات', 1, '4', '1', ''),
(3, 'كتابة', 1, '4', '1', ''),
(4, 'علوم', 1, '4', '1', '3615db53-8baf-44e6-a777-65c842f4ced5.jpg'),
(5, 'هدايتي', 1, '4', '1', ''),
(6, 'انجليزي', 1, '4', '1', ''),
(7, 'خياطة', 1, '4', '1', ''),
(8, 'طهي', 1, '4', '1', 'ab655980-c57b-4841-bd28-c8bf1fc317cd.jpg'),
(9, 'تهيئة كتابية', 1, '4', '1', ''),
(10, 'الوحدة', 1, '4', '1', ''),
(11, 'اتصالي', 1, '4', '1', ''),
(12, 'اجتماعي', 1, '4', '1', ''),
(13, 'ادراكي', 1, '4', '1', ''),
(14, 'حركي كبير', 1, '4', '1', ''),
(15, 'حركي دقيق', 1, '4', '1', ''),
(16, 'انتباه وتركيز', 1, '4', '1', ''),
(17, 'التكامل الحسي', 1, '4', '1', ''),
(18, 'قراءة', 2, '4', '1', ''),
(19, 'رياضيات', 2, '4', '1', ''),
(20, 'كتابة', 2, '4', '1', ''),
(21, 'علوم', 2, '4', '1', ''),
(22, 'هدايتي', 2, '4', '1', ''),
(23, 'انجليزي', 2, '4', '1', ''),
(24, 'خياطة', 2, '4', '1', ''),
(25, 'تهيئة كتابية', 2, '4', '1', ''),
(26, 'طهي', 2, '4', '1', ''),
(27, 'الوحدة', 2, '4', '1', ''),
(28, 'اجتماعي', 2, '4', '1', ''),
(29, 'اتصالي', 2, '4', '1', ''),
(30, 'ادراكي', 2, '4', '1', ''),
(31, 'حركي كبير', 2, '4', '1', ''),
(32, 'حركي دقيق', 2, '4', '1', ''),
(33, 'انتباه وتركيز', 2, '4', '1', ''),
(34, 'التكامل الحسي', 2, '4', '1', ''),
(35, 'المساعدة الذاتية', 1, '4', '1', ''),
(36, 'المساعدة الذاتية', 2, '4', '1', ''),
(37, 'الحلقة', 1, '4', '1', 'd3a161a9-2376-4d6f-971a-f6717d289e49.jpg'),
(38, 'الوجبة', 1, '4', '1', ''),
(39, 'الحلقة', 2, '4', '1', ''),
(40, 'الوجبة', 2, '4', '1', ''),
(41, 'خياطة نظري', 1, '4', '1', ''),
(42, 'جلسة فردي', 1, '4', '1', ''),
(43, 'جلسة فردية', 2, '4', '1', ''),
(44, 'مهني', 1, '4,8,28,31', '1,2', ''),
(45, 'نشاط', 1, '4,28', '1', ''),
(46, 'مهني', 2, '4,8', '1,2', ''),
(47, 'نشاط', 2, '4', '1', ''),
(48, 'ايبيلز', 1, '4', '1', ''),
(49, 'ايبلز', 2, '4', '1', ''),
(50, 'حركي', 2, '4', '1', ''),
(51, 'اداب وسلوكيات', 2, '4', '1', ''),
(52, 'نشاط حر - ايقاع', 2, '4', '1', ''),
(53, 'تقييم - تصوير', 2, '4', '1', ''),
(54, 'علاج بالعمل', 2, '4', '1', ''),
(55, 'تنمية مهارات', 1, '4', '1', ''),
(56, 'نشاط حركي', 1, '4', '1', ''),
(57, 'علاج بالعمل', 1, '4', '1', ''),
(58, 'تقييم - تصوير', 1, '4', '1', ''),
(59, 'نشاط حر - ايقاع', 1, '4', '1', ''),
(60, 'نشاط حر', 2, '4', '1', ''),
(61, 'تقييم', 2, '4', '1', ''),
(62, 'نشاط حركي', 2, '4', '1', ''),
(63, 'تقوية العضلات', 1, '4', '1', ''),
(64, 'تقوية العضلات', 2, '4', '1', ''),
(65, 'تنمية مهارات', 2, '4', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers_on_transport`
--

CREATE TABLE `subscribers_on_transport` (
  `subscribers_on_transport_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `year` longtext NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_report`
--

CREATE TABLE `supervisor_report` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `month_plan_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `term_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `year` varchar(15) DEFAULT NULL,
  `datetime_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_report_step`
--

CREATE TABLE `supervisor_report_step` (
  `id` int(11) NOT NULL,
  `supervisor_report_id` int(11) DEFAULT NULL,
  `step_id` int(11) DEFAULT NULL,
  `evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `technical_support`
--

CREATE TABLE `technical_support` (
  `technical_support_id` int(11) NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_identity` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `educational_level` varchar(25) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `specializing` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_code` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` int(11) DEFAULT NULL,
  `city` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_number` longtext CHARACTER SET utf16 COLLATE utf16_unicode_ci DEFAULT NULL,
  `country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code_emergency_telephone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_telephone` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `authentication_key` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_login` tinyint(4) NOT NULL DEFAULT 1,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  `lang` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'arabic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `technical_support`
--

INSERT INTO `technical_support` (`technical_support_id`, `name`, `identity_type`, `no_identity`, `job_title_id`, `class_id`, `educational_level`, `specializing`, `account_code`, `birthday`, `sex`, `nationality_id`, `city`, `region`, `street`, `building_number`, `country_code`, `phone`, `country_code_emergency_telephone`, `emergency_telephone`, `email`, `password`, `level`, `authentication_key`, `date_added`, `last_login`, `status_login`, `online`, `lang`) VALUES
(1, 'اباء ابو زر', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '962', '788254746', NULL, NULL, 'ebaa_z@hotmail.com', '8c0b4555ed10b3230753ca3394118dfed679aa6e', NULL, NULL, NULL, '1677992211', 1, 1, 'arabic');

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `id` int(11) NOT NULL,
  `term_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `term_period` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_stamp` datetime DEFAULT NULL,
  `year` varchar(20) NOT NULL,
  `semster_id` int(11) DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tests_and_metrics`
--

CREATE TABLE `tests_and_metrics` (
  `tests_and_metrics_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `tests_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_application` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `results` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `track_time_for_pages`
--

CREATE TABLE `track_time_for_pages` (
  `id` int(11) NOT NULL,
  `time_in_page` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `user_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_analysis`
--

CREATE TABLE `training_analysis` (
  `id` int(11) NOT NULL,
  `home_plan_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `training_procedures_id` int(11) NOT NULL,
  `timestamp` varchar(50) DEFAULT '',
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `training_procedures`
--

CREATE TABLE `training_procedures` (
  `id` int(11) NOT NULL,
  `home_plan_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `training_procedures` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` int(11) NOT NULL,
  `timestamp` varchar(50) DEFAULT '',
  `active` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `transport_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `route_name` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_of_vehicle` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `route_fare` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_accountability_staff`
--

CREATE TABLE `type_accountability_staff` (
  `type_accountability_staff_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `managerial_or_educational` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_of_notes_on_employee`
--

CREATE TABLE `type_of_notes_on_employee` (
  `type_of_notes_on_employee_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_help`
--

CREATE TABLE `user_help` (
  `id` int(11) NOT NULL,
  `question_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `question_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_ar` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer_en` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `visits` int(11) NOT NULL DEFAULT 0,
  `useful` int(11) NOT NULL DEFAULT 0,
  `not_useful` int(11) NOT NULL DEFAULT 0,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `user_permissions_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_records`
--

CREATE TABLE `user_records` (
  `user_records_id` int(11) NOT NULL,
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
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_satisfaction`
--

CREATE TABLE `user_satisfaction` (
  `id` int(11) NOT NULL,
  `poll_question` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_user_satisfaction` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_user` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `year` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vat`
--

CREATE TABLE `vat` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat` decimal(4,2) DEFAULT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `date_added` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vbmapp_assessment_case`
--

CREATE TABLE `vbmapp_assessment_case` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `datetime_stamp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `student_age` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recommendations` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `introduction_report` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vbmapp_assessment_mastered`
--

CREATE TABLE `vbmapp_assessment_mastered` (
  `id` int(11) NOT NULL,
  `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `evaluation_axes_id` int(11) DEFAULT NULL,
  `main_goal_id` int(11) DEFAULT NULL,
  `level_main_goal` tinyint(4) DEFAULT NULL,
  `sub_goal_id` int(11) DEFAULT NULL,
  `degree` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vbmapp_plane`
--

CREATE TABLE `vbmapp_plane` (
  `id` int(11) NOT NULL,
  `vbmapp_assessment_case_id` int(11) DEFAULT NULL,
  `plan_size` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `publish` tinyint(4) NOT NULL DEFAULT 1,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vbmapp_plane_goal`
--

CREATE TABLE `vbmapp_plane_goal` (
  `id` int(11) NOT NULL,
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
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_area`
--

CREATE TABLE `vehicle_area` (
  `vehicle_area_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `year` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_management`
--

CREATE TABLE `vehicle_management` (
  `vehicle_management_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `type_car` varchar(50) NOT NULL,
  `number_plate` varchar(50) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `phone_driver` varchar(50) DEFAULT NULL,
  `driver_assistant` varchar(50) DEFAULT NULL,
  `driver_assistant_phone` varchar(50) DEFAULT NULL,
  `driver_assistant_2` varchar(100) DEFAULT NULL,
  `driver_assistant_2_phone` varchar(30) DEFAULT NULL,
  `absorptive_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_pages_site`
--

CREATE TABLE `visit_pages_site` (
  `visit_pages_site_id` int(11) NOT NULL,
  `page_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `visit_pages_site`
--

INSERT INTO `visit_pages_site` (`visit_pages_site_id`, `page_name`, `date`) VALUES
(1, 'home', '1676254005');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_from_transport`
--

CREATE TABLE `withdrawal_from_transport` (
  `withdrawal_from_transport_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT 0,
  `date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workdays`
--

CREATE TABLE `workdays` (
  `workdays_id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workday` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `workdays`
--

INSERT INTO `workdays` (`workdays_id`, `name`, `workday`) VALUES
(1, 'saturday', 0),
(2, 'sunday', 1),
(3, 'monday', 1),
(4, 'tuesday', 1),
(5, 'wednesday', 1),
(6, 'thursday', 1),
(7, 'friday', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence_employees_counter`
--
ALTER TABLE `absence_employees_counter`
  ADD PRIMARY KEY (`absence_employees_counter_id`);

--
-- Indexes for table `accountability_staff`
--
ALTER TABLE `accountability_staff`
  ADD PRIMARY KEY (`accountability_staff_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `all_files`
--
ALTER TABLE `all_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approvals_items_guardian`
--
ALTER TABLE `approvals_items_guardian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_management`
--
ALTER TABLE `area_management`
  ADD PRIMARY KEY (`area_management_id`);

--
-- Indexes for table `assessment_analysis`
--
ALTER TABLE `assessment_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`);

--
-- Indexes for table `assessment_case`
--
ALTER TABLE `assessment_case`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_genre`
--
ALTER TABLE `assessment_genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_goal`
--
ALTER TABLE `assessment_goal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_print`
--
ALTER TABLE `assessment_print`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_step`
--
ALTER TABLE `assessment_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `attendance_employee`
--
ALTER TABLE `attendance_employee`
  ADD PRIMARY KEY (`attendance_employee_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_sessions`
--
ALTER TABLE `booking_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_visit`
--
ALTER TABLE `book_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_study`
--
ALTER TABLE `case_study`
  ADD PRIMARY KEY (`case_study_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `chat_contacts`
--
ALTER TABLE `chat_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_thread`
--
ALTER TABLE `chat_thread`
  ADD PRIMARY KEY (`chat_thread_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `conditions_registration_form`
--
ALTER TABLE `conditions_registration_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_email`
--
ALTER TABLE `contact_email`
  ADD PRIMARY KEY (`contact_email_id`);

--
-- Indexes for table `course_subscribers`
--
ALTER TABLE `course_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_report`
--
ALTER TABLE `daily_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_report_steps`
--
ALTER TABLE `daily_report_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_report_urgent`
--
ALTER TABLE `daily_report_urgent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_history`
--
ALTER TABLE `database_history`
  ADD PRIMARY KEY (`database_history_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `disability`
--
ALTER TABLE `disability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disability_level`
--
ALTER TABLE `disability_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_category`
--
ALTER TABLE `discount_category`
  ADD PRIMARY KEY (`discount_category_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `dormitory`
--
ALTER TABLE `dormitory`
  ADD PRIMARY KEY (`dormitory_id`);

--
-- Indexes for table `effective_resignations_date`
--
ALTER TABLE `effective_resignations_date`
  ADD PRIMARY KEY (`effective_resignations_date_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_classes`
--
ALTER TABLE `employee_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`enroll_id`);

--
-- Indexes for table `evaluation_employee`
--
ALTER TABLE `evaluation_employee`
  ADD PRIMARY KEY (`evaluation_employee_id`);

--
-- Indexes for table `evaluation_employee_lookup`
--
ALTER TABLE `evaluation_employee_lookup`
  ADD PRIMARY KEY (`evaluation_employee_lookup_id`);

--
-- Indexes for table `evaluation_items`
--
ALTER TABLE `evaluation_items`
  ADD PRIMARY KEY (`evaluation_items_id`);

--
-- Indexes for table `evaluation_management`
--
ALTER TABLE `evaluation_management`
  ADD PRIMARY KEY (`evaluation_management_id`);

--
-- Indexes for table `evaluation_objective_final`
--
ALTER TABLE `evaluation_objective_final`
  ADD PRIMARY KEY (`evaluation_objective_final_id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`expense_category_id`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `fields_training`
--
ALTER TABLE `fields_training`
  ADD PRIMARY KEY (`fields_Training_id`);

--
-- Indexes for table `field_evaluation_employee`
--
ALTER TABLE `field_evaluation_employee`
  ADD PRIMARY KEY (`field_evaluation_employee_id`);

--
-- Indexes for table `for_subscription`
--
ALTER TABLE `for_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `for_update`
--
ALTER TABLE `for_update`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `frontend_blog`
--
ALTER TABLE `frontend_blog`
  ADD PRIMARY KEY (`frontend_blog_id`);

--
-- Indexes for table `frontend_events`
--
ALTER TABLE `frontend_events`
  ADD PRIMARY KEY (`frontend_events_id`);

--
-- Indexes for table `frontend_gallery`
--
ALTER TABLE `frontend_gallery`
  ADD PRIMARY KEY (`frontend_gallery_id`);

--
-- Indexes for table `frontend_gallery_image`
--
ALTER TABLE `frontend_gallery_image`
  ADD PRIMARY KEY (`frontend_gallery_image_id`);

--
-- Indexes for table `frontend_general_settings`
--
ALTER TABLE `frontend_general_settings`
  ADD PRIMARY KEY (`frontend_general_settings_id`);

--
-- Indexes for table `frontend_news`
--
ALTER TABLE `frontend_news`
  ADD PRIMARY KEY (`frontend_news_id`);

--
-- Indexes for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  ADD PRIMARY KEY (`frontend_settings_id`);

--
-- Indexes for table `git_log`
--
ALTER TABLE `git_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`group_chat_id`);

--
-- Indexes for table `group_chat_thread`
--
ALTER TABLE `group_chat_thread`
  ADD PRIMARY KEY (`group_chat_thread_id`);

--
-- Indexes for table `group_message`
--
ALTER TABLE `group_message`
  ADD PRIMARY KEY (`group_message_id`);

--
-- Indexes for table `group_message_thread`
--
ALTER TABLE `group_message_thread`
  ADD PRIMARY KEY (`group_message_thread_id`);

--
-- Indexes for table `guardian_approvals`
--
ALTER TABLE `guardian_approvals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_evaluation_employee`
--
ALTER TABLE `history_evaluation_employee`
  ADD PRIMARY KEY (`history_evaluation_employee_id`);

--
-- Indexes for table `history_student_withdrawals`
--
ALTER TABLE `history_student_withdrawals`
  ADD PRIMARY KEY (`history_student_withdrawals_id`);

--
-- Indexes for table `home_plan`
--
ALTER TABLE `home_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_plan_analysis`
--
ALTER TABLE `home_plan_analysis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_plan_steps`
--
ALTER TABLE `home_plan_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_title`
--
ALTER TABLE `job_title`
  ADD PRIMARY KEY (`job_title_id`);

--
-- Indexes for table `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`mailbox_id`);

--
-- Indexes for table `mail_attachments`
--
ALTER TABLE `mail_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_auth_key`
--
ALTER TABLE `mail_auth_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_massege`
--
ALTER TABLE `mail_massege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_read_status`
--
ALTER TABLE `mail_read_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_s_r`
--
ALTER TABLE `mail_s_r`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ministry_supervision`
--
ALTER TABLE `ministry_supervision`
  ADD PRIMARY KEY (`ministry_supervision_id`);

--
-- Indexes for table `monthly_plan`
--
ALTER TABLE `monthly_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_plan_analysis`
--
ALTER TABLE `monthly_plan_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monthly_plan_id` (`monthly_plan_id`),
  ADD KEY `step_id` (`step_id`),
  ADD KEY `analysis_id` (`analysis_id`);

--
-- Indexes for table `monthly_plan_steps`
--
ALTER TABLE `monthly_plan_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_id` (`step_id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`nationality_id`);

--
-- Indexes for table `notes_on_employee`
--
ALTER TABLE `notes_on_employee`
  ADD PRIMARY KEY (`notes_on_employee_id`);

--
-- Indexes for table `notes_users`
--
ALTER TABLE `notes_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `noticeboard`
--
ALTER TABLE `noticeboard`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `online_exam`
--
ALTER TABLE `online_exam`
  ADD PRIMARY KEY (`online_exam_id`);

--
-- Indexes for table `online_exam_result`
--
ALTER TABLE `online_exam_result`
  ADD PRIMARY KEY (`online_exam_result_id`);

--
-- Indexes for table `online_exam_send`
--
ALTER TABLE `online_exam_send`
  ADD PRIMARY KEY (`online_exam_send_id`);

--
-- Indexes for table `online_exam_type`
--
ALTER TABLE `online_exam_type`
  ADD PRIMARY KEY (`online_exam_type_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `parents_areas_satisfaction`
--
ALTER TABLE `parents_areas_satisfaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_poll`
--
ALTER TABLE `parents_poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_poll_send`
--
ALTER TABLE `parents_poll_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_satisfaction_items`
--
ALTER TABLE `parents_satisfaction_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_send`
--
ALTER TABLE `parents_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents_submitted_poll`
--
ALTER TABLE `parents_submitted_poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `payments_category`
--
ALTER TABLE `payments_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_category`
--
ALTER TABLE `payroll_category`
  ADD PRIMARY KEY (`payroll_category_id`);

--
-- Indexes for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_summary`
--
ALTER TABLE `plan_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_summary_steps`
--
ALTER TABLE `plan_summary_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_answer_script`
--
ALTER TABLE `poll_answer_script`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_axes`
--
ALTER TABLE `poll_axes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_items`
--
ALTER TABLE `poll_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_manage`
--
ALTER TABLE `poll_manage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_send`
--
ALTER TABLE `poll_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_send_times`
--
ALTER TABLE `poll_send_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`question_bank_id`);

--
-- Indexes for table `record_logins`
--
ALTER TABLE `record_logins`
  ADD PRIMARY KEY (`record_logins_id`);

--
-- Indexes for table `report_plan`
--
ALTER TABLE `report_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_plan_analysis`
--
ALTER TABLE `report_plan_analysis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_plan_steps`
--
ALTER TABLE `report_plan_steps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_problem`
--
ALTER TABLE `report_problem`
  ADD PRIMARY KEY (`report_problem_id`);

--
-- Indexes for table `request_employee`
--
ALTER TABLE `request_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_permissions_id`);

--
-- Indexes for table `routine_specialist_withdrawal`
--
ALTER TABLE `routine_specialist_withdrawal`
  ADD PRIMARY KEY (`routine_specialist_withdrawal_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_subject`
--
ALTER TABLE `schedule_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `section_employee`
--
ALTER TABLE `section_employee`
  ADD PRIMARY KEY (`section_employee_id`);

--
-- Indexes for table `section_schedule`
--
ALTER TABLE `section_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_schedule_subject`
--
ALTER TABLE `section_schedule_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `services_provided`
--
ALTER TABLE `services_provided`
  ADD PRIMARY KEY (`services_provided_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `step_material`
--
ALTER TABLE `step_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `step_standard`
--
ALTER TABLE `step_standard`
  ADD PRIMARY KEY (`step_standard_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `students_to_specialists`
--
ALTER TABLE `students_to_specialists`
  ADD PRIMARY KEY (`students_to_specialists_id`);

--
-- Indexes for table `student_assessment`
--
ALTER TABLE `student_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_behaviour`
--
ALTER TABLE `student_behaviour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_behaviour_reptitions`
--
ALTER TABLE `student_behaviour_reptitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_behaviour_strategy`
--
ALTER TABLE `student_behaviour_strategy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_parent`
--
ALTER TABLE `student_parent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_plan`
--
ALTER TABLE `student_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_plan_analysis`
--
ALTER TABLE `student_plan_analysis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `step_id` (`step_id`),
  ADD KEY `analysis_id` (`analysis_id`);

--
-- Indexes for table `student_plan_steps`
--
ALTER TABLE `student_plan_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `step_id` (`step_id`);

--
-- Indexes for table `student_record`
--
ALTER TABLE `student_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_services`
--
ALTER TABLE `student_services`
  ADD PRIMARY KEY (`student_services_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subscribers_on_transport`
--
ALTER TABLE `subscribers_on_transport`
  ADD PRIMARY KEY (`subscribers_on_transport_id`);

--
-- Indexes for table `supervisor_report`
--
ALTER TABLE `supervisor_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisor_report_step`
--
ALTER TABLE `supervisor_report_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technical_support`
--
ALTER TABLE `technical_support`
  ADD PRIMARY KEY (`technical_support_id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests_and_metrics`
--
ALTER TABLE `tests_and_metrics`
  ADD PRIMARY KEY (`tests_and_metrics_id`);

--
-- Indexes for table `track_time_for_pages`
--
ALTER TABLE `track_time_for_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_analysis`
--
ALTER TABLE `training_analysis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_procedures`
--
ALTER TABLE `training_procedures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`transport_id`);

--
-- Indexes for table `type_accountability_staff`
--
ALTER TABLE `type_accountability_staff`
  ADD PRIMARY KEY (`type_accountability_staff_id`);

--
-- Indexes for table `type_of_notes_on_employee`
--
ALTER TABLE `type_of_notes_on_employee`
  ADD PRIMARY KEY (`type_of_notes_on_employee_id`);

--
-- Indexes for table `user_help`
--
ALTER TABLE `user_help`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`user_permissions_id`);

--
-- Indexes for table `user_records`
--
ALTER TABLE `user_records`
  ADD PRIMARY KEY (`user_records_id`);

--
-- Indexes for table `user_satisfaction`
--
ALTER TABLE `user_satisfaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vat`
--
ALTER TABLE `vat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vbmapp_assessment_case`
--
ALTER TABLE `vbmapp_assessment_case`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vbmapp_assessment_mastered`
--
ALTER TABLE `vbmapp_assessment_mastered`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vbmapp_plane`
--
ALTER TABLE `vbmapp_plane`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vbmapp_plane_goal`
--
ALTER TABLE `vbmapp_plane_goal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_area`
--
ALTER TABLE `vehicle_area`
  ADD PRIMARY KEY (`vehicle_area_id`);

--
-- Indexes for table `vehicle_management`
--
ALTER TABLE `vehicle_management`
  ADD PRIMARY KEY (`vehicle_management_id`);

--
-- Indexes for table `visit_pages_site`
--
ALTER TABLE `visit_pages_site`
  ADD PRIMARY KEY (`visit_pages_site_id`);

--
-- Indexes for table `withdrawal_from_transport`
--
ALTER TABLE `withdrawal_from_transport`
  ADD PRIMARY KEY (`withdrawal_from_transport_id`);

--
-- Indexes for table `workdays`
--
ALTER TABLE `workdays`
  ADD PRIMARY KEY (`workdays_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence_employees_counter`
--
ALTER TABLE `absence_employees_counter`
  MODIFY `absence_employees_counter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accountability_staff`
--
ALTER TABLE `accountability_staff`
  MODIFY `accountability_staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `all_files`
--
ALTER TABLE `all_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approvals_items_guardian`
--
ALTER TABLE `approvals_items_guardian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area_management`
--
ALTER TABLE `area_management`
  MODIFY `area_management_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_analysis`
--
ALTER TABLE `assessment_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_case`
--
ALTER TABLE `assessment_case`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_genre`
--
ALTER TABLE `assessment_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_goal`
--
ALTER TABLE `assessment_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_print`
--
ALTER TABLE `assessment_print`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_step`
--
ALTER TABLE `assessment_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_employee`
--
ALTER TABLE `attendance_employee`
  MODIFY `attendance_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_sessions`
--
ALTER TABLE `booking_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_visit`
--
ALTER TABLE `book_visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_study`
--
ALTER TABLE `case_study`
  MODIFY `case_study_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_contacts`
--
ALTER TABLE `chat_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_thread`
--
ALTER TABLE `chat_thread`
  MODIFY `chat_thread_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `conditions_registration_form`
--
ALTER TABLE `conditions_registration_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_email`
--
ALTER TABLE `contact_email`
  MODIFY `contact_email_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_subscribers`
--
ALTER TABLE `course_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `daily_report`
--
ALTER TABLE `daily_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_report_steps`
--
ALTER TABLE `daily_report_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_report_urgent`
--
ALTER TABLE `daily_report_urgent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_history`
--
ALTER TABLE `database_history`
  MODIFY `database_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disability`
--
ALTER TABLE `disability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `disability_level`
--
ALTER TABLE `disability_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_category`
--
ALTER TABLE `discount_category`
  MODIFY `discount_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dormitory`
--
ALTER TABLE `dormitory`
  MODIFY `dormitory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `effective_resignations_date`
--
ALTER TABLE `effective_resignations_date`
  MODIFY `effective_resignations_date_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_classes`
--
ALTER TABLE `employee_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enroll`
--
ALTER TABLE `enroll`
  MODIFY `enroll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluation_employee`
--
ALTER TABLE `evaluation_employee`
  MODIFY `evaluation_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluation_employee_lookup`
--
ALTER TABLE `evaluation_employee_lookup`
  MODIFY `evaluation_employee_lookup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `evaluation_items`
--
ALTER TABLE `evaluation_items`
  MODIFY `evaluation_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `evaluation_management`
--
ALTER TABLE `evaluation_management`
  MODIFY `evaluation_management_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `evaluation_objective_final`
--
ALTER TABLE `evaluation_objective_final`
  MODIFY `evaluation_objective_final_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `expense_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fields_training`
--
ALTER TABLE `fields_training`
  MODIFY `fields_Training_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_evaluation_employee`
--
ALTER TABLE `field_evaluation_employee`
  MODIFY `field_evaluation_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `for_subscription`
--
ALTER TABLE `for_subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `for_update`
--
ALTER TABLE `for_update`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `frontend_blog`
--
ALTER TABLE `frontend_blog`
  MODIFY `frontend_blog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_events`
--
ALTER TABLE `frontend_events`
  MODIFY `frontend_events_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_gallery`
--
ALTER TABLE `frontend_gallery`
  MODIFY `frontend_gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_gallery_image`
--
ALTER TABLE `frontend_gallery_image`
  MODIFY `frontend_gallery_image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_general_settings`
--
ALTER TABLE `frontend_general_settings`
  MODIFY `frontend_general_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `frontend_news`
--
ALTER TABLE `frontend_news`
  MODIFY `frontend_news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontend_settings`
--
ALTER TABLE `frontend_settings`
  MODIFY `frontend_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `git_log`
--
ALTER TABLE `git_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `group_chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chat_thread`
--
ALTER TABLE `group_chat_thread`
  MODIFY `group_chat_thread_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message`
--
ALTER TABLE `group_message`
  MODIFY `group_message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message_thread`
--
ALTER TABLE `group_message_thread`
  MODIFY `group_message_thread_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guardian_approvals`
--
ALTER TABLE `guardian_approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_evaluation_employee`
--
ALTER TABLE `history_evaluation_employee`
  MODIFY `history_evaluation_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_student_withdrawals`
--
ALTER TABLE `history_student_withdrawals`
  MODIFY `history_student_withdrawals_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_plan`
--
ALTER TABLE `home_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_plan_analysis`
--
ALTER TABLE `home_plan_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_plan_steps`
--
ALTER TABLE `home_plan_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_title`
--
ALTER TABLE `job_title`
  MODIFY `job_title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `mailbox_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_attachments`
--
ALTER TABLE `mail_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_auth_key`
--
ALTER TABLE `mail_auth_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_massege`
--
ALTER TABLE `mail_massege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_read_status`
--
ALTER TABLE `mail_read_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_s_r`
--
ALTER TABLE `mail_s_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_plan`
--
ALTER TABLE `monthly_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_plan_analysis`
--
ALTER TABLE `monthly_plan_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_plan_steps`
--
ALTER TABLE `monthly_plan_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `nationality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `notes_on_employee`
--
ALTER TABLE `notes_on_employee`
  MODIFY `notes_on_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes_users`
--
ALTER TABLE `notes_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noticeboard`
--
ALTER TABLE `noticeboard`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam`
--
ALTER TABLE `online_exam`
  MODIFY `online_exam_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `online_exam_result`
--
ALTER TABLE `online_exam_result`
  MODIFY `online_exam_result_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_exam_send`
--
ALTER TABLE `online_exam_send`
  MODIFY `online_exam_send_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents_areas_satisfaction`
--
ALTER TABLE `parents_areas_satisfaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parents_poll`
--
ALTER TABLE `parents_poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parents_poll_send`
--
ALTER TABLE `parents_poll_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents_satisfaction_items`
--
ALTER TABLE `parents_satisfaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `parents_send`
--
ALTER TABLE `parents_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents_submitted_poll`
--
ALTER TABLE `parents_submitted_poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments_category`
--
ALTER TABLE `payments_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_category`
--
ALTER TABLE `payroll_category`
  MODIFY `payroll_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_employee`
--
ALTER TABLE `payroll_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_summary`
--
ALTER TABLE `plan_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_summary_steps`
--
ALTER TABLE `plan_summary_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_answer_script`
--
ALTER TABLE `poll_answer_script`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_axes`
--
ALTER TABLE `poll_axes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_items`
--
ALTER TABLE `poll_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `poll_manage`
--
ALTER TABLE `poll_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poll_send`
--
ALTER TABLE `poll_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_send_times`
--
ALTER TABLE `poll_send_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `question_bank_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `record_logins`
--
ALTER TABLE `record_logins`
  MODIFY `record_logins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_plan`
--
ALTER TABLE `report_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_plan_analysis`
--
ALTER TABLE `report_plan_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_plan_steps`
--
ALTER TABLE `report_plan_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_problem`
--
ALTER TABLE `report_problem`
  MODIFY `report_problem_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_employee`
--
ALTER TABLE `request_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `role_permissions_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2082;

--
-- AUTO_INCREMENT for table `routine_specialist_withdrawal`
--
ALTER TABLE `routine_specialist_withdrawal`
  MODIFY `routine_specialist_withdrawal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_subject`
--
ALTER TABLE `schedule_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_employee`
--
ALTER TABLE `section_employee`
  MODIFY `section_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `section_schedule`
--
ALTER TABLE `section_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_schedule_subject`
--
ALTER TABLE `section_schedule_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services_provided`
--
ALTER TABLE `services_provided`
  MODIFY `services_provided_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `step_material`
--
ALTER TABLE `step_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `step_standard`
--
ALTER TABLE `step_standard`
  MODIFY `step_standard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_to_specialists`
--
ALTER TABLE `students_to_specialists`
  MODIFY `students_to_specialists_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_assessment`
--
ALTER TABLE `student_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_behaviour`
--
ALTER TABLE `student_behaviour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_behaviour_reptitions`
--
ALTER TABLE `student_behaviour_reptitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_behaviour_strategy`
--
ALTER TABLE `student_behaviour_strategy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_parent`
--
ALTER TABLE `student_parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_plan`
--
ALTER TABLE `student_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_plan_analysis`
--
ALTER TABLE `student_plan_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_plan_steps`
--
ALTER TABLE `student_plan_steps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_record`
--
ALTER TABLE `student_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_services`
--
ALTER TABLE `student_services`
  MODIFY `student_services_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `subscribers_on_transport`
--
ALTER TABLE `subscribers_on_transport`
  MODIFY `subscribers_on_transport_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supervisor_report`
--
ALTER TABLE `supervisor_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supervisor_report_step`
--
ALTER TABLE `supervisor_report_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technical_support`
--
ALTER TABLE `technical_support`
  MODIFY `technical_support_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests_and_metrics`
--
ALTER TABLE `tests_and_metrics`
  MODIFY `tests_and_metrics_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `track_time_for_pages`
--
ALTER TABLE `track_time_for_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_analysis`
--
ALTER TABLE `training_analysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_procedures`
--
ALTER TABLE `training_procedures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_accountability_staff`
--
ALTER TABLE `type_accountability_staff`
  MODIFY `type_accountability_staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_of_notes_on_employee`
--
ALTER TABLE `type_of_notes_on_employee`
  MODIFY `type_of_notes_on_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_help`
--
ALTER TABLE `user_help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `user_permissions_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_records`
--
ALTER TABLE `user_records`
  MODIFY `user_records_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_satisfaction`
--
ALTER TABLE `user_satisfaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vat`
--
ALTER TABLE `vat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vbmapp_assessment_case`
--
ALTER TABLE `vbmapp_assessment_case`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vbmapp_assessment_mastered`
--
ALTER TABLE `vbmapp_assessment_mastered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vbmapp_plane`
--
ALTER TABLE `vbmapp_plane`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vbmapp_plane_goal`
--
ALTER TABLE `vbmapp_plane_goal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_area`
--
ALTER TABLE `vehicle_area`
  MODIFY `vehicle_area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_management`
--
ALTER TABLE `vehicle_management`
  MODIFY `vehicle_management_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visit_pages_site`
--
ALTER TABLE `visit_pages_site`
  MODIFY `visit_pages_site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawal_from_transport`
--
ALTER TABLE `withdrawal_from_transport`
  MODIFY `withdrawal_from_transport_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workdays`
--
ALTER TABLE `workdays`
  MODIFY `workdays_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
