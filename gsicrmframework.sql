-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 03:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `earthumrealtyleads`
--

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `configurationsid` int(100) NOT NULL,
  `configurationname` varchar(50) NOT NULL,
  `configurationvalue` varchar(9999) NOT NULL,
  `configurationtype` varchar(30) NOT NULL DEFAULT 'text',
  `configurationsupportivetext` varchar(1000) NOT NULL DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`configurationsid`, `configurationname`, `configurationvalue`, `configurationtype`, `configurationsupportivetext`) VALUES
(1, 'APP_NAME', 'GSI CRM FRAMEWORK 2.0', 'TEXT', 'null'),
(2, 'TAGLINE', 'GSI CRM FRAMEWORK 2.0', 'text', 'null'),
(3, 'OWNER_NAME', 'GSI CRM FRAMEWORK 2.0', 'text', 'null'),
(4, 'PRIMARY_PHONE', '9876543210', 'phone', 'null'),
(5, 'PRIMARY_EMAIL', 'gauravsinghigc@gmail.com', 'email', 'null'),
(6, 'SHORT_DESCRIPTION', 'TksyU3ZZZTU3aElEU1hEU0dKRTRXbExXT0ZhbzRaYXJ1VFZOdlJtaElLTT0=', 'text', 'null'),
(7, 'PRIMARY_ADDRESS', 'TksyU3ZZZTU3aElEU1hEU0dKRTRXbExXT0ZhbzRaYXJ1VFZOdlJtaElLTT0=', 'address', 'null'),
(12, 'SUPPORT_MAIL', 'gauravsinghigc@gmail.com', 'email', 'null'),
(13, 'ENQUIRY_MAIL', 'gauravsinghigc@gmail.com', 'email', 'null'),
(20, 'CONTROL_WORK_ENV', 'PROD', 'boolean', 'dev, prod'),
(21, 'CONTROL_SMS', 'false', 'boolean', 'true, false'),
(23, 'CONTROL_MAILS', 'true', 'boolean', 'true, false'),
(24, 'CONTROL_NOTIFICATION', 'true', 'boolean', 'true, false'),
(25, 'CONTROL_MSG_DISPLAY_TIME', '7000', 'number', '1000, 10000'),
(26, 'CONTROL_APP_LOGS', 'true', 'boolean', 'true, false'),
(27, 'APP_LOGO', 'GUARAV_SINGH__07_May_2025_11_05_38_24385665846_.jpg', 'img', 'null'),
(28, 'SMS_OTP_TEMP_ID', 'null', 'text', 'null'),
(29, 'PASS_RESET_OTP_TEMP', 'null', 'text', 'null'),
(30, 'SMS_SENDER_ID', 'null', 'text', 'null'),
(36, 'CONTROL_NOTIFICATION_SOUND', 'true', 'boolean', 'true, false'),
(48, 'DEFAULT_RECORD_LISTING', '100', 'text', 'null'),
(72, 'LISTING_TYPES', 'Projects', 'text', 'null'),
(73, 'SERVER_DOWN_CONTROL', 'false', 'text', 'null'),
(74, 'INTERNAL_CHAT_APP', 'false', 'text', 'null'),
(75, 'TYPE_OF_CLOSING', 'Bookings', 'text', 'null'),
(76, 'TYPE_OF_RECORDS', 'Leads', 'text', 'null'),
(77, 'TYPES_OF_USERS', 'Users', 'text', 'null'),
(78, 'OFFICE_START_TIME', '09:30', 'text', 'null'),
(79, 'OFFICE_LUNCH_TIME', '13:30', 'text', 'null'),
(80, 'OFFICE_END_TIME', '18:30', 'text', 'null'),
(81, 'WEEKLY_OFF_DAY', '', 'text', 'null'),
(82, 'OFFICE_LUNCH_DURATION_IN_MINS', '', 'text', 'null'),
(83, 'OFFICE_LUNCH_END_TIME', '14:00', 'text', 'null');

-- --------------------------------------------------------

--
-- Table structure for table `config_facebook_accounts`
--

CREATE TABLE `config_facebook_accounts` (
  `config_facebook_accounts_id` int(10) NOT NULL,
  `config_facebook_accounts_name` varchar(70) NOT NULL,
  `config_facebook_accounts_access_token` varchar(255) NOT NULL,
  `config_facebook_accounts_ad_account_id` varchar(100) NOT NULL,
  `config_facebook_accounts_campaigns_id` varchar(100) NOT NULL,
  `config_facebook_accounts_adsets_id` varchar(100) NOT NULL,
  `config_facebook_accounts_ads_id` varchar(100) NOT NULL,
  `config_facebook_accounts_projects_id` int(10) NOT NULL,
  `config_facebook_accounts__status` int(2) NOT NULL,
  `config_facebook_accounts_added_by` int(10) NOT NULL,
  `config_facebook_accounts_added_at` varchar(45) NOT NULL,
  `config_facebook_accounts_updated_at` varchar(45) NOT NULL,
  `config_facebook_accounts_updated_by` int(10) NOT NULL,
  `config_facebook_accounts_auto_distributions` int(10) NOT NULL,
  `config_facebook_accounts_last_fetched_at` varchar(45) NOT NULL,
  `config_facebook_accounts_vendor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_leads_resources`
--

CREATE TABLE `config_leads_resources` (
  `config_leads_resources_id` int(10) NOT NULL,
  `config_leads_resources_name` varchar(100) NOT NULL,
  `config_leads_resources_status` int(10) NOT NULL,
  `config_leads_resources_created_by` int(10) NOT NULL,
  `config_leads_resources_created_at` varchar(45) NOT NULL,
  `config_leads_resources_updated_at` varchar(45) NOT NULL,
  `config_leads_resources_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_leads_resources`
--

INSERT INTO `config_leads_resources` (`config_leads_resources_id`, `config_leads_resources_name`, `config_leads_resources_status`, `config_leads_resources_created_by`, `config_leads_resources_created_at`, `config_leads_resources_updated_at`, `config_leads_resources_updated_by`) VALUES
(1, 'Shaleen Ads', 1, 1, '2025-03-26 07:23:13 PM', '2025-03-27 02:52:30 PM', 6),
(11, 'Others', 1, 1, '2025-05-25 02:39:00 PM', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `config_leads_sources`
--

CREATE TABLE `config_leads_sources` (
  `config_leads_source_id` int(10) NOT NULL,
  `config_leads_source_name` varchar(100) NOT NULL,
  `config_leads_source_image` varchar(255) NOT NULL,
  `config_leads_source_color` varchar(10) NOT NULL,
  `config_leads_source_remarks` varchar(525) NOT NULL,
  `config_leads_source_created_at` varchar(45) NOT NULL,
  `config_leads_source_updated_at` varchar(45) NOT NULL,
  `config_leads_source_created_by` int(10) NOT NULL,
  `config_leads_source_updated_by` int(10) NOT NULL,
  `config_leads_source_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_leads_sources`
--

INSERT INTO `config_leads_sources` (`config_leads_source_id`, `config_leads_source_name`, `config_leads_source_image`, `config_leads_source_color`, `config_leads_source_remarks`, `config_leads_source_created_at`, `config_leads_source_updated_at`, `config_leads_source_created_by`, `config_leads_source_updated_by`, `config_leads_source_status`) VALUES
(1, 'Facebook', 'Facebook__19_Mar_2025_06_03_01_3034687157_.jpg', '#0259e3', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:24:25 PM', '2025-03-19 06:41:01 PM', 10, 10, 1),
(2, 'Instagram', 'Instagram__19_Mar_2025_06_03_10_69486841034_.png', '#c0027a', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:50:10 PM', '2025-03-19 06:50:10 PM', 10, 10, 1),
(3, 'Google Ads', 'Google_Ads__19_Mar_2025_06_03_00_66095907347_.png', '#00ccff', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:53:00 PM', '2025-03-19 06:53:13 PM', 10, 10, 1),
(4, '99 Acres', '99_Acress__19_Mar_2025_06_03_00_71341306965_.jpg', '#0079d6', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:54:00 PM', '2025-03-27 02:53:36 PM', 10, 6, 1),
(5, 'Housing', 'Housing__19_Mar_2025_06_03_38_85468305962_.jpg', '#ffdd00', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:54:38 PM', '2025-03-19 06:54:38 PM', 10, 10, 1),
(6, 'MAGIC BRICKS', 'MAGIC_BRICKS__19_Mar_2025_06_03_04_61530079092_.png', '#ff0000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:55:04 PM', '2025-03-19 06:55:04 PM', 10, 10, 1),
(7, 'Self', 'Self__19_Mar_2025_06_03_36_86624422543_.png', '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-19 06:55:36 PM', '2025-03-19 06:55:36 PM', 10, 10, 1),
(20, 'Website', '', '', '', '2025-05-25 02:09:49 PM', '', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_leads_stages`
--

CREATE TABLE `config_leads_stages` (
  `config_leads_stages_id` int(10) NOT NULL,
  `config_leads_stage_name` varchar(100) NOT NULL,
  `config_leads_stage_color_code` varchar(30) NOT NULL,
  `config_leads_stage_sort_by_order` int(10) NOT NULL,
  `config_leads_stage_status` int(1) NOT NULL DEFAULT 1,
  `config_leads_stage_created_by` int(10) NOT NULL,
  `config_leads_stage_created_at` varchar(45) NOT NULL,
  `config_leads_stage_updated_at` varchar(45) NOT NULL,
  `config_leads_stage_updated_by` int(10) NOT NULL,
  `config_leads_stage_remarks` varchar(255) NOT NULL,
  `config_leads_stage_short_name` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_leads_stages`
--

INSERT INTO `config_leads_stages` (`config_leads_stages_id`, `config_leads_stage_name`, `config_leads_stage_color_code`, `config_leads_stage_sort_by_order`, `config_leads_stage_status`, `config_leads_stage_created_by`, `config_leads_stage_created_at`, `config_leads_stage_updated_at`, `config_leads_stage_updated_by`, `config_leads_stage_remarks`, `config_leads_stage_short_name`) VALUES
(1, 'FRESH', '#d6e8ff', 1, 1, 10, '2025-03-17 09:59:24 PM', '2025-05-25 05:23:18 PM', 1, 'b09yRGhLcGF6TWR4WFZEQ2Z0RVcxSXdscUFkYXoxK2ZramtHRUsyYkowTT0=', ''),
(2, 'FOLLOW-UPS', '#eddbff', 2, 1, 10, '2025-03-17 10:14:52 PM', '2025-05-25 05:23:31 PM', 1, 'OFlsdG1NSm9FcHR4WGUvcGVlYzhmdz09', ''),
(3, 'INFORMATION SHARED', '#ffdbfe', 4, 1, 10, '2025-03-17 10:17:08 PM', '2025-04-23 09:19:22 AM', 1, 'TGNBT2VIMWQzVUxwWWYvU1c0c2pNckYxN2h6MFB2OHpHY2pLRlR1YmQ5ND0=', ''),
(6, 'NOT INTERESTED', '#dedede', 5, 1, 10, '2025-03-17 10:19:14 PM', '2025-04-23 09:19:31 AM', 1, 'NnpGMGxEUmhGOUtOMkVHelM2a09DQT09', ''),
(7, 'WON', '#c7ffc8', 7, 1, 10, '2025-03-17 10:19:37 PM', '2025-04-23 09:19:38 AM', 1, 'SnJUczQwYkNLRDd2RzlGdThyKzBUUT09', ''),
(11, 'CALL BACK', '#dbfffb', 3, 1, 1, '2025-03-27 03:38:04 PM', '2025-05-25 05:23:46 PM', 1, '', ''),
(12, 'JUNK', '#ffcccc', 8, 1, 8, '2025-03-28 04:34:19 PM', '2025-04-23 09:19:56 AM', 1, '', ''),
(13, 'IS BROKER', '#ffebf9', 9, 1, 1, '2025-04-23 09:33:53 AM', '2025-04-23 09:33:53 AM', 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `config_leads_sub_stages`
--

CREATE TABLE `config_leads_sub_stages` (
  `config_call_sub_status_id` int(10) NOT NULL,
  `config_call_sub_status_main_id` int(10) NOT NULL,
  `config_call_sub_status_name` varchar(100) NOT NULL,
  `config_call_sub_status_status` int(1) NOT NULL DEFAULT 1,
  `config_call_sub_status_remarks` varchar(252) NOT NULL,
  `config_call_sub_status_created_at` varchar(45) NOT NULL,
  `config_call_sub_status_updated_at` varchar(45) NOT NULL,
  `config_call_sub_status_created_by` int(10) NOT NULL,
  `config_call_sub_status_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_leads_sub_stages`
--

INSERT INTO `config_leads_sub_stages` (`config_call_sub_status_id`, `config_call_sub_status_main_id`, `config_call_sub_status_name`, `config_call_sub_status_status`, `config_call_sub_status_remarks`, `config_call_sub_status_created_at`, `config_call_sub_status_updated_at`, `config_call_sub_status_created_by`, `config_call_sub_status_updated_by`) VALUES
(10, 1, 'FRESH', 1, '', '2025-04-23 09:20:43 AM', '2025-04-23 09:51:12 AM', 1, 1),
(11, 2, 'FOLLOW-UP', 1, '', '2025-04-23 09:22:08 AM', '2025-04-23 09:22:08 AM', 1, 1),
(12, 2, 'NOT PICKED ', 1, '', '2025-04-23 09:22:33 AM', '2025-04-23 09:22:33 AM', 1, 1),
(13, 2, 'BUSY', 1, '', '2025-04-23 09:22:43 AM', '2025-04-23 09:22:43 AM', 1, 1),
(14, 11, 'BUSY', 1, '', '2025-04-23 09:22:56 AM', '2025-04-23 09:22:56 AM', 1, 1),
(15, 11, 'SWITCH OFF', 1, '', '2025-04-23 09:23:18 AM', '2025-04-23 09:23:18 AM', 1, 1),
(16, 11, 'OUT OF NETWORK AREA', 1, '', '2025-04-23 09:23:34 AM', '2025-04-23 09:23:34 AM', 1, 1),
(17, 11, 'ON REQUEST', 1, '', '2025-04-23 09:23:46 AM', '2025-04-23 09:23:46 AM', 1, 1),
(18, 11, 'NOT PICKED', 1, '', '2025-04-23 09:23:57 AM', '2025-04-23 09:23:57 AM', 1, 1),
(19, 3, 'INFORMATION SHARED', 1, '', '2025-04-23 09:24:31 AM', '2025-04-23 09:24:31 AM', 1, 1),
(20, 3, 'INFORMATION VIEWED', 1, '', '2025-04-23 09:24:47 AM', '2025-04-23 09:51:21 AM', 1, 1),
(21, 3, 'IN DISCUSSION', 1, '', '2025-04-23 09:24:59 AM', '2025-04-23 09:24:59 AM', 1, 1),
(22, 6, 'OUT OF BUDGET', 1, '', '2025-04-23 09:26:36 AM', '2025-04-23 09:26:36 AM', 1, 1),
(23, 6, 'LOCATION ISSUE', 1, '', '2025-04-23 09:26:47 AM', '2025-04-23 09:26:47 AM', 1, 1),
(24, 6, 'WRONG ENQUIRY', 1, '', '2025-04-23 09:27:07 AM', '2025-04-23 09:29:35 AM', 1, 1),
(25, 6, 'NOT REQUIRED', 1, '', '2025-04-23 09:27:19 AM', '2025-04-23 09:27:19 AM', 1, 1),
(26, 6, 'ALREADY PURCHASED', 1, '', '2025-04-23 09:27:37 AM', '2025-04-23 09:27:37 AM', 1, 1),
(29, 7, 'BOOKING DONE', 1, '', '2025-04-23 09:30:33 AM', '2025-04-23 09:30:33 AM', 1, 1),
(30, 12, 'INVALID NUMBER', 1, '', '2025-04-23 09:31:40 AM', '2025-04-23 09:31:40 AM', 1, 1),
(31, 12, 'WRONG NUMBER', 1, '', '2025-04-23 09:31:54 AM', '2025-04-23 09:31:54 AM', 1, 1),
(32, 12, 'NO INCOMING', 1, '', '2025-04-23 09:32:13 AM', '2025-04-23 09:32:13 AM', 1, 1),
(33, 12, 'SWITCH OFF', 1, '', '2025-04-23 09:33:14 AM', '2025-04-23 09:33:14 AM', 1, 1),
(34, 13, 'BROKER', 1, '', '2025-04-23 09:34:09 AM', '2025-04-23 09:34:09 AM', 1, 1),
(35, 13, 'DEVELOPER', 1, '', '2025-04-23 09:34:26 AM', '2025-04-23 09:34:26 AM', 1, 1),
(36, 13, 'BUILDER', 1, '', '2025-04-23 09:34:56 AM', '2025-04-23 09:34:56 AM', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_mail_sender`
--

CREATE TABLE `config_mail_sender` (
  `config_mail_sender_id` int(10) NOT NULL,
  `config_mail_sender_host` varchar(255) NOT NULL,
  `config_mail_sender_username` varchar(100) NOT NULL,
  `config_mail_sender_password` varchar(50) NOT NULL,
  `config_mail_sender_port` varchar(10) NOT NULL,
  `config_mail_sent_from` varchar(100) NOT NULL,
  `config_mail_send_limit` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_mail_sender`
--

INSERT INTO `config_mail_sender` (`config_mail_sender_id`, `config_mail_sender_host`, `config_mail_sender_username`, `config_mail_sender_password`, `config_mail_sender_port`, `config_mail_sent_from`, `config_mail_send_limit`) VALUES
(1, 'smtp.hostinger.com', 'smtp.hostinger.com', 'smtp.hostinger.com', '465', 'smtp.hostinger.com', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `config_priority_levels`
--

CREATE TABLE `config_priority_levels` (
  `config_priority_level_id` int(10) NOT NULL,
  `config_priority_level_name` varchar(100) NOT NULL,
  `config_priority_level_remarks` varchar(525) NOT NULL,
  `config_priority_level_status` int(1) NOT NULL DEFAULT 1,
  `config_priority_level_created_at` varchar(45) NOT NULL,
  `config_priority_level_created_by` int(10) NOT NULL,
  `config_priority_level_updated_at` varchar(45) NOT NULL,
  `config_priority_level_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_priority_levels`
--

INSERT INTO `config_priority_levels` (`config_priority_level_id`, `config_priority_level_name`, `config_priority_level_remarks`, `config_priority_level_status`, `config_priority_level_created_at`, `config_priority_level_created_by`, `config_priority_level_updated_at`, `config_priority_level_updated_by`) VALUES
(1, 'High', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-19 08:31:36 PM', 10, '2025-03-19 08:32:20 PM', 10),
(2, 'Medium', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-19 08:31:49 PM', 10, '2025-03-19 08:31:49 PM', 10),
(3, 'Low', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-19 08:31:56 PM', 10, '2025-03-19 08:31:56 PM', 10),
(4, 'Urgent', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-19 08:32:02 PM', 10, '2025-03-19 08:32:02 PM', 10);

-- --------------------------------------------------------

--
-- Table structure for table `config_projects_locations`
--

CREATE TABLE `config_projects_locations` (
  `config_projects_locations_id` int(10) NOT NULL,
  `config_projects_locations_name` varchar(100) NOT NULL,
  `config_projects_locations_status` int(1) NOT NULL DEFAULT 1,
  `config_projects_locations_color_code` varchar(10) NOT NULL,
  `config_projects_locations_remarks` varchar(725) NOT NULL,
  `config_projects_locations_created_by` int(10) NOT NULL,
  `config_projects_locations_created_at` varchar(45) NOT NULL,
  `config_projects_locations_updated_at` varchar(45) NOT NULL,
  `config_projects_locations_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_projects_locations`
--

INSERT INTO `config_projects_locations` (`config_projects_locations_id`, `config_projects_locations_name`, `config_projects_locations_status`, `config_projects_locations_color_code`, `config_projects_locations_remarks`, `config_projects_locations_created_by`, `config_projects_locations_created_at`, `config_projects_locations_updated_at`, `config_projects_locations_updated_by`) VALUES
(1, 'NOIDA', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 10, '2025-03-20 11:08:53 AM', '2025-03-27 02:49:47 PM', 6),
(2, 'Noida Expressway', 1, '#13b007', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 10, '2025-03-20 11:09:00 AM', '2025-03-27 02:50:00 PM', 6),
(5, 'JEWAR', 1, '#FFFFFF', 'SWFRam1lYXEyY0RZc09WM2FXb1k5Zz09', 1, '2025-03-21 10:13:54 AM', '2025-03-21 10:13:54 AM', 1),
(6, 'Rishikesh', 1, '#ffffff', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-21 10:14:42 AM', '2025-03-27 02:50:14 PM', 6),
(7, 'Noida Extension', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 02:50:28 PM', '2025-03-27 02:50:28 PM', 6),
(8, 'NH24', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 02:50:41 PM', '2025-03-27 02:50:41 PM', 6),
(9, 'Delhi', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 02:50:56 PM', '2025-03-27 02:50:56 PM', 6),
(10, 'Goa', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 02:51:04 PM', '2025-03-27 02:51:04 PM', 6),
(11, 'Solra', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 02:58:04 PM', '2025-03-27 02:58:04 PM', 6),
(12, 'Greater Noida', 1, '#000000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 6, '2025-03-27 03:11:18 PM', '2025-03-27 03:11:18 PM', 6);

-- --------------------------------------------------------

--
-- Table structure for table `config_projects_stages`
--

CREATE TABLE `config_projects_stages` (
  `config_projects_stages_id` int(10) NOT NULL,
  `config_projects_stages_name` varchar(100) NOT NULL,
  `config_projects_stages_color_code` varchar(10) NOT NULL,
  `config_projects_stages_status` int(1) NOT NULL DEFAULT 1,
  `config_projects_stages_remarks` varchar(725) NOT NULL,
  `config_projects_stages_sort_by_order` int(10) NOT NULL,
  `config_projects_stages_created_at` varchar(45) NOT NULL,
  `config_projects_stages_created_by` int(10) NOT NULL,
  `config_projects_stages_updated_at` varchar(45) NOT NULL,
  `config_projects_stages_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_projects_stages`
--

INSERT INTO `config_projects_stages` (`config_projects_stages_id`, `config_projects_stages_name`, `config_projects_stages_color_code`, `config_projects_stages_status`, `config_projects_stages_remarks`, `config_projects_stages_sort_by_order`, `config_projects_stages_created_at`, `config_projects_stages_created_by`, `config_projects_stages_updated_at`, `config_projects_stages_updated_by`) VALUES
(1, 'Under construction', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, '2025-03-20 09:40:01 AM', 10, '2025-03-27 02:57:12 PM', 6),
(2, 'ready to move in', '#c61010', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 2, '2025-03-20 09:40:13 AM', 10, '2025-03-27 02:46:04 PM', 6),
(3, 'pre launch', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 4, '2025-03-20 09:40:34 AM', 10, '2025-03-27 02:46:33 PM', 6),
(4, 'STAGE 3', '#714b4b', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 3, '2025-03-20 09:40:48 AM', 10, '2025-03-20 09:40:48 AM', 10);

-- --------------------------------------------------------

--
-- Table structure for table `config_projects_status`
--

CREATE TABLE `config_projects_status` (
  `config_projects_status_id` int(10) NOT NULL,
  `config_projects_status_name` varchar(100) NOT NULL,
  `config_projects_status_color_code` varchar(10) NOT NULL,
  `config_projects_status_status` int(1) NOT NULL DEFAULT 1,
  `config_projects_status_remarks` varchar(725) NOT NULL,
  `config_projects_status_created_at` varchar(45) NOT NULL,
  `config_projects_status_updated_at` varchar(45) NOT NULL,
  `config_projects_status_created_by` int(10) NOT NULL,
  `config_projects_status_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_projects_status`
--

INSERT INTO `config_projects_status` (`config_projects_status_id`, `config_projects_status_name`, `config_projects_status_color_code`, `config_projects_status_status`, `config_projects_status_remarks`, `config_projects_status_created_at`, `config_projects_status_updated_at`, `config_projects_status_created_by`, `config_projects_status_updated_by`) VALUES
(1, 'Launched', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-20 06:06:40 PM', '2025-03-27 02:48:43 PM', 10, 6),
(2, 'Not Launched', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-20 06:06:45 PM', '2025-03-27 02:48:57 PM', 10, 6),
(4, 'Intermediate', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-20 06:06:59 PM', '2025-03-27 02:49:08 PM', 10, 6),
(5, 'STATUS 4', '#000000', 1, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2025-03-20 06:07:05 PM', '2025-03-20 06:07:35 PM', 10, 10),
(6, 'CONSTRUCTION INITIATED', '#FFFFFF', 1, 'eXZDYVFXMllRVXl1UnNlTm0rSWQ2WGZjNnpEVkZuTnBPOHhidjRqaDVXND0=', '2025-03-21 10:14:42 AM', '2025-03-21 10:14:42 AM', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_project_types`
--

CREATE TABLE `config_project_types` (
  `config_project_types_id` int(10) NOT NULL,
  `config_project_types_name` varchar(100) NOT NULL,
  `config_project_types_color_code` varchar(30) NOT NULL,
  `config_project_types_remarks` varchar(725) NOT NULL,
  `config_project_types_status` int(1) NOT NULL,
  `config_project_types_created_by` int(10) NOT NULL,
  `config_project_types_updated_by` int(10) NOT NULL,
  `config_project_types_created_at` varchar(45) NOT NULL,
  `config_project_types_updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_project_types`
--

INSERT INTO `config_project_types` (`config_project_types_id`, `config_project_types_name`, `config_project_types_color_code`, `config_project_types_remarks`, `config_project_types_status`, `config_project_types_created_by`, `config_project_types_updated_by`, `config_project_types_created_at`, `config_project_types_updated_at`) VALUES
(1, 'Residential Plots', '#057a07', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:12:16 AM', '2025-03-20 09:15:27 AM'),
(4, 'Residential Flats', '#00f068', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:15:48 AM', '2025-03-20 09:15:48 AM'),
(5, 'Commercial', '#bd0000', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 6, '2025-03-20 09:17:27 AM', '2025-03-27 02:51:34 PM'),
(6, 'Office Spaces', '#ff0a0a', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:17:53 AM', '2025-03-20 09:17:53 AM'),
(7, 'SCO', '#5b0101', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:18:12 AM', '2025-03-20 09:18:12 AM'),
(8, 'SHOPS', '#5e3131', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:18:26 AM', '2025-03-20 09:18:26 AM'),
(9, 'Residential Villas', '#ab00ad', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', 1, 10, 10, '2025-03-20 09:19:02 AM', '2025-03-20 09:19:02 AM');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `leads_id` int(10) NOT NULL,
  `leads_full_name` varchar(60) NOT NULL,
  `leads_phone_number` varchar(15) NOT NULL,
  `leads_alternate_phone` varchar(15) NOT NULL,
  `leads_email_id` varchar(255) NOT NULL,
  `leads_date_of_birth` varchar(45) NOT NULL,
  `leads_anniversary_date` varchar(45) NOT NULL,
  `leads_gender` varchar(10) NOT NULL,
  `leads_marital_status` varchar(100) NOT NULL,
  `leads_created_by` int(10) NOT NULL,
  `leads_updated_by` int(10) NOT NULL,
  `leads_created_at` varchar(45) NOT NULL,
  `leads_updated_at` varchar(45) NOT NULL,
  `leads_type` varchar(30) NOT NULL,
  `leads_source` varchar(100) NOT NULL,
  `leads_re_source` int(10) NOT NULL,
  `leads_is_created_by_admin` varchar(10) NOT NULL,
  `leads_entry_type` varchar(30) NOT NULL,
  `leads_stages` int(10) NOT NULL,
  `leads_sub_stages` int(10) NOT NULL,
  `leads_status` int(100) NOT NULL,
  `leads_uploaded_by` int(10) NOT NULL,
  `leads_assign_status` varchar(30) NOT NULL,
  `leads_managed_by` int(10) NOT NULL,
  `leads_priority_level` int(10) NOT NULL,
  `leads_assigned_by` varchar(100) NOT NULL,
  `leads_assigned_date` varchar(45) NOT NULL,
  `leads_call_status` int(10) NOT NULL,
  `leads_call_sub_status` int(10) NOT NULL,
  `leads_projects_id` int(10) NOT NULL,
  `leads_remarks` varchar(1000) NOT NULL,
  `leads_other_sources_ads_id` varchar(10) NOT NULL,
  `leads_fetched_status` varchar(50) NOT NULL,
  `leads_other_sources_name` varchar(50) NOT NULL,
  `leads_is_removed` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_activities`
--

CREATE TABLE `leads_activities` (
  `leads_acitivity_id` int(10) NOT NULL,
  `leads_activity_main_leads_id` int(10) NOT NULL,
  `leads_activity_type` varchar(100) NOT NULL,
  `leads_acitivity_call_status` int(10) NOT NULL,
  `leads_acitivity_call_sub_status` int(10) NOT NULL,
  `leads_activity_feedbacks` varchar(5000) NOT NULL,
  `leads_activity_added_by` int(10) NOT NULL,
  `leads_activity_added_on` varchar(45) NOT NULL,
  `leads_activity_created_at` varchar(45) NOT NULL,
  `leads_activity_created_by` int(10) NOT NULL,
  `leads_activity_have_voice_notes` varchar(500) NOT NULL,
  `leads_activity_voice_notes_file` varchar(500) NOT NULL,
  `leads_activity_call_source` varchar(25) NOT NULL,
  `leads_activity_call_method` varchar(25) NOT NULL,
  `leads_activity_date_time` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_address`
--

CREATE TABLE `leads_address` (
  `leads_address_id` int(10) NOT NULL,
  `leads_main_id` int(10) NOT NULL,
  `leads_address_line1` varchar(725) NOT NULL,
  `leads_address_area` varchar(200) NOT NULL,
  `leads_address_city` varchar(150) NOT NULL,
  `leads_address_state` varchar(100) NOT NULL,
  `leads_address_country` varchar(75) NOT NULL,
  `leads_address_pincode` int(10) NOT NULL,
  `leads_address_added_by` int(10) NOT NULL,
  `leads_address_modified_by` int(10) NOT NULL,
  `leads_address_added_at` varchar(45) NOT NULL,
  `leads_address_modified_at` varchar(45) NOT NULL,
  `leads_address_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_assignees`
--

CREATE TABLE `leads_assignees` (
  `leads_assign_id` int(10) NOT NULL,
  `leads_main_id` int(10) NOT NULL,
  `leads_assigned_to` int(10) NOT NULL,
  `leads_assigned_by` int(10) NOT NULL,
  `leads_assigned_previously_to` int(10) NOT NULL,
  `leads_assigned_previously_by` int(10) NOT NULL,
  `leads_assigned_on` varchar(50) NOT NULL,
  `leads_assigned_previously_on` varchar(50) NOT NULL,
  `leads_assigned_stages` int(10) NOT NULL,
  `leads_assigned_previous_stages` int(10) NOT NULL,
  `leads_assigned_priority_level` int(10) NOT NULL,
  `leads_assigned_previous_priority_level` int(10) NOT NULL,
  `leads_assigned_udpated_by` varchar(10) NOT NULL,
  `leads_assigned_udpated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_attributes`
--

CREATE TABLE `leads_attributes` (
  `leads_attributes_id` int(10) NOT NULL,
  `leads_main_id` int(10) NOT NULL,
  `leads_attribute_name` varchar(100) NOT NULL,
  `leads_attribute_value` varchar(500) NOT NULL,
  `leads_attribute_type` varchar(100) NOT NULL,
  `leads_attribute_added_by` int(10) NOT NULL,
  `leads_attribute_added_at` varchar(45) NOT NULL,
  `leads_attribute_modified_at` varchar(45) NOT NULL,
  `leads_attribute_modified_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_reminders`
--

CREATE TABLE `leads_reminders` (
  `leads_reminder_id` int(10) NOT NULL,
  `leads_reminder_name` varchar(100) NOT NULL,
  `leads_reminder_main_leads_id` int(10) NOT NULL,
  `leads_reminder_date` varchar(45) NOT NULL,
  `leads_reminder_time` varchar(45) NOT NULL,
  `leads_reminder_notes` varchar(1000) NOT NULL,
  `leads_reminder_status` int(1) NOT NULL DEFAULT 1,
  `leads_reminder_user_id` int(10) NOT NULL,
  `leads_reminder_created_at` varchar(45) NOT NULL,
  `leads_reminder_rescheduled_by` int(10) NOT NULL,
  `leads_reminder_created_by` int(10) NOT NULL,
  `leads_reminder_rescheduled_at` varchar(45) NOT NULL,
  `leads_reminder_re_remind_time` varchar(100) NOT NULL,
  `leads_reminder_re_remind_count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads_reminders`
--

INSERT INTO `leads_reminders` (`leads_reminder_id`, `leads_reminder_name`, `leads_reminder_main_leads_id`, `leads_reminder_date`, `leads_reminder_time`, `leads_reminder_notes`, `leads_reminder_status`, `leads_reminder_user_id`, `leads_reminder_created_at`, `leads_reminder_rescheduled_by`, `leads_reminder_created_by`, `leads_reminder_rescheduled_at`, `leads_reminder_re_remind_time`, `leads_reminder_re_remind_count`) VALUES
(1, 'Call Reminder', 1076, '2025-05-25', '07:36:00 PM', 'eFRRRDJRM2VaelRTNUdNMUVObzhudz09', 2, 2, '2025-05-25 07:37:05 PM', 0, 2, '', '10', 0),
(2, 'Call Reminder', 1024, '2025-05-25', '07:38:00 PM', 'WThrTE1VWkNPVm81RnVpbkxEWXBnUT09', 2, 2, '2025-05-25 07:38:30 PM', 0, 2, '', '10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `leads_requirements`
--

CREATE TABLE `leads_requirements` (
  `leads_requirement_id` int(10) NOT NULL,
  `leads_main_id` int(10) NOT NULL,
  `leads_project_id` int(10) NOT NULL,
  `leads_requirement_tags` varchar(100) NOT NULL,
  `leads_requirement_type` varchar(100) NOT NULL,
  `leads_requirement_budgets` varchar(255) NOT NULL,
  `leads_requirement_preffered_location` varchar(100) NOT NULL,
  `leads_requirement_unit_no` varchar(100) NOT NULL,
  `leads_requirement_duration` varchar(255) NOT NULL,
  `leads_requirement_unit_type` varchar(100) NOT NULL,
  `leads_requirement_added_by` int(10) NOT NULL,
  `leads_requirement_added_at` varchar(50) NOT NULL,
  `leads_requirement_modified_at` varchar(50) NOT NULL,
  `leads_requirement_modified_by` int(10) NOT NULL,
  `leads_requirement_added_by_admin` int(10) NOT NULL,
  `leads_requirement_added_by_admin_at` varchar(45) NOT NULL,
  `leads_requirement_remarks` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_site_visits`
--

CREATE TABLE `leads_site_visits` (
  `leads_site_visit_id` int(10) NOT NULL,
  `leads_site_visits_projects_id` varchar(10) NOT NULL,
  `leads_main_leads_id` int(10) NOT NULL,
  `leads_site_visit_status` int(1) NOT NULL DEFAULT 1,
  `leads_site_visit_schedule_date` varchar(45) NOT NULL,
  `leads_site_visit_added_by` int(10) NOT NULL,
  `leads_site_visit_added_on` varchar(45) NOT NULL,
  `leads_site_visit_notes` varchar(1000) NOT NULL,
  `leads_site_visit_rescheduled_at` varchar(45) NOT NULL,
  `leads_site_visit_rescheduled_by` int(10) NOT NULL,
  `leads_site_visit_reminder_times` varchar(100) NOT NULL,
  `leads_site_visit_reminder_count` varchar(10) NOT NULL,
  `leads_site_visit_response` varchar(1000) NOT NULL,
  `leads_site_visit_handled_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads_site_visits`
--

INSERT INTO `leads_site_visits` (`leads_site_visit_id`, `leads_site_visits_projects_id`, `leads_main_leads_id`, `leads_site_visit_status`, `leads_site_visit_schedule_date`, `leads_site_visit_added_by`, `leads_site_visit_added_on`, `leads_site_visit_notes`, `leads_site_visit_rescheduled_at`, `leads_site_visit_rescheduled_by`, `leads_site_visit_reminder_times`, `leads_site_visit_reminder_count`, `leads_site_visit_response`, `leads_site_visit_handled_by`) VALUES
(1, '1', 1076, 4, '2025-05-25T19:36', 2, '2025-05-25 07:37:05 PM', 'eFRRRDJRM2VaelRTNUdNMUVObzhudz09', '', 0, '', '', '', 2),
(2, '1', 1024, 4, '2025-05-25T19:38', 2, '2025-05-25 07:38:30 PM', 'WThrTE1VWkNPVm81RnVpbkxEWXBnUT09', '', 0, '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `leads_site_visits_attachements`
--

CREATE TABLE `leads_site_visits_attachements` (
  `leads_activity_attachement_id` int(10) NOT NULL,
  `leads_activity_main_id` int(10) NOT NULL,
  `leads_activity_attached_file` varchar(255) NOT NULL,
  `leads_activity_attachment_upload_by` int(10) NOT NULL,
  `leads_activity_attached_at` varchar(45) NOT NULL,
  `leads_activity_attachement_type` varchar(10) NOT NULL,
  `leads_activity_signature` varchar(1000) NOT NULL,
  `leads_activity_latitude` varchar(100) NOT NULL,
  `leads_activity_longitude` varchar(100) NOT NULL,
  `leads_activity_location_name` varchar(725) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads_uploaded_things`
--

CREATE TABLE `leads_uploaded_things` (
  `leads_uploaded_id` int(10) NOT NULL,
  `leads_upload_main_id` int(10) NOT NULL,
  `leads_upload_header_name` varchar(100) NOT NULL,
  `leads_uploaded_value` varchar(500) NOT NULL,
  `leads_uploaded_by` int(10) NOT NULL,
  `leads_uploded_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `projects_id` int(10) NOT NULL,
  `projects_name` varchar(75) NOT NULL,
  `projects_area` varchar(50) NOT NULL,
  `projects_area_measurement_unit` varchar(50) NOT NULL,
  `projects_locations_id` int(5) NOT NULL,
  `projects_stages_id` int(5) NOT NULL,
  `projects_status_id` int(5) NOT NULL,
  `projects_type_id` int(5) NOT NULL,
  `projects_introductions` varchar(1000) NOT NULL,
  `projects_listing_status` int(1) NOT NULL DEFAULT 1,
  `projects_age` varchar(100) NOT NULL,
  `projects_created_at` varchar(45) NOT NULL,
  `projects_updated_at` varchar(45) NOT NULL,
  `projects_created_by` int(10) NOT NULL,
  `projects_updated_by` int(10) NOT NULL,
  `projects_developed_by` int(10) NOT NULL,
  `project_closed_at` varchar(45) NOT NULL,
  `project_closed_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`projects_id`, `projects_name`, `projects_area`, `projects_area_measurement_unit`, `projects_locations_id`, `projects_stages_id`, `projects_status_id`, `projects_type_id`, `projects_introductions`, `projects_listing_status`, `projects_age`, `projects_created_at`, `projects_updated_at`, `projects_created_by`, `projects_updated_by`, `projects_developed_by`, `project_closed_at`, `project_closed_by`) VALUES
(1, 'ACTIVE PROJECT', '987654567', 'Square Feet (SQ FEET)', 12, 3, 6, 6, 'UGE0R0lkdWRDT0JoaVEvc1hWSW1idz09', 1, '2024-12-01', '2025-04-22 03:57:25 PM', '2025-05-21 02:17:15 PM', 1, 1, 0, '', 0),
(2, '', '', '', 0, 0, 0, 0, '', 1, '', '2025-05-25 02:10:03 PM', '2025-05-25 02:10:03 PM', 1, 1, 0, '', 0),
(3, '', '', '', 0, 0, 0, 0, '', 1, '', '2025-05-25 02:10:39 PM', '2025-05-25 02:10:39 PM', 1, 1, 0, '', 0),
(4, 'ProjectX', '', '', 0, 0, 0, 0, '', 1, '', '2025-05-25 02:21:41 PM', '2025-05-25 02:21:41 PM', 1, 1, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects_developers`
--

CREATE TABLE `projects_developers` (
  `projects_developers_id` int(10) NOT NULL,
  `projects_developers_name` varchar(75) NOT NULL,
  `projects_developers_logo` varchar(255) NOT NULL,
  `projects_developers_address` varchar(525) NOT NULL,
  `projects_developer_phone_number` varchar(12) NOT NULL,
  `projects_developer_primary_email_id` varchar(75) NOT NULL,
  `project_developer_created_at` varchar(45) NOT NULL,
  `project_developer_updated_at` varchar(45) NOT NULL,
  `project_developer_created_by` int(10) NOT NULL,
  `project_developer_updated_by` int(10) NOT NULL,
  `project_developer_status` int(1) NOT NULL DEFAULT 1,
  `projects_landing_page_url` varchar(725) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_media_files`
--

CREATE TABLE `projects_media_files` (
  `projects_media_files_id` int(10) NOT NULL,
  `projects_media_files_main_project_id` int(10) NOT NULL,
  `projects_media_files_types` varchar(75) NOT NULL,
  `projects_media_files_value` varchar(255) NOT NULL,
  `project_media_files_created_at` varchar(45) NOT NULL,
  `project_media_files_updated_at` varchar(45) NOT NULL,
  `project_media_files_created_by` int(10) NOT NULL,
  `projects_media_files_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_amenities`
--

CREATE TABLE `project_amenities` (
  `project_amenities_id` int(10) NOT NULL,
  `project_amenities_project_main_id` int(10) NOT NULL,
  `project_amenities_name` varchar(75) NOT NULL,
  `project_amenities_short_desc` varchar(525) NOT NULL,
  `project_amenities_created_at` varchar(45) NOT NULL,
  `project_amenities_updated_at` varchar(45) NOT NULL,
  `project_amenities_created_by` int(10) NOT NULL,
  `project_amenities_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemlogs`
--

CREATE TABLE `systemlogs` (
  `LogsId` int(100) NOT NULL,
  `logbyUserId` varchar(10) NOT NULL,
  `logTitle` varchar(200) NOT NULL,
  `logdesc` varchar(1000) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `systeminfo` varchar(1000) NOT NULL,
  `logtype` varchar(100) NOT NULL,
  `logenv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systemlogs`
--

INSERT INTO `systemlogs` (`LogsId`, `logbyUserId`, `logTitle`, `logdesc`, `created_at`, `systeminfo`, `logtype`, `logenv`) VALUES
(1, '1', 'C_PROFILE_UPDATED', 'emJ5emVlc2JieUpCZm9Uc0ZDR0tXQktGTGdEZnNtOENMT3piTURCRStFQT0=', '2025-05-28 07:17:09 PM', 'YWpRVE95SXN0VXZUMHkvb1pISXNqcWYrdExzYTN2cFVlK1hhcFpvUU1WaTBBbVQ2VEVOMlFpbGYzS3daVVU5L0tHS2dzeXdVQTlDRkljQnU4enR0Nm9Db2g5dmJ6Qm5mQk44Ry9UVCtheUIwZnNkYjFnSjRjdkV2LzB0ci9QcEVVbU1QcUZlYllTSUNsbzlSYWFKMUN4YXFpSW5vb0hodDZQa1NQUDJvMGs4aGFsNTQ2MHhGWGtseTVwSHFucVFCQnN2emZLQUlXdjlEdDhxWUU3cnlRZDNhdTVlU29RVGVnYWlya1NSOGxrZnZ0OElvN2tOV2NkOTE3bDRNT1lMZTR5V3JnRlo5ZFpEazVsakdZam16aEVZR0lzdm1jMFpObUgxTHZwaVJhci9LbWoxOER2Yk92Vjdmd0FqNzRLcGtGSlIrcVp4bFNuaU80SExlM04xSXQwbFZLUnQ0MjU0Ykk5cFBmLzBNeUd3YzltS0ttRmRlclhnWklRb21xSGFHcFN5NEViMWlMZXlhLzNLL3kxdjY1UT09', 'UPDATE', 'PROD'),
(2, '1', 'C_PROFILE_UPDATED', 'emJ5emVlc2JieUpCZm9Uc0ZDR0tXQktGTGdEZnNtOENMT3piTURCRStFQT0=', '2025-05-28 07:17:47 PM', 'YWpRVE95SXN0VXZUMHkvb1pISXNqcWYrdExzYTN2cFVlK1hhcFpvUU1WaGFVRWQyVDNzT2hHYTBJWTg0RHBNT2prTVVkMzBQM1hhR1ZjZW1sSjV2aEJRVmo5L1Nwcnl1TEtIQ04xOTYwTnNSRzhwMUxzZVpMekd5Ly9pSkNyWG92cWlSdElVdm1yWWJ4QUJ5alluK0tXcFg1ek5OWUdIM09aVXh2dVV3QmlnS282RzlYLzl0bXZtSUczRGs2aVRHWFNJVTZEYktDdTFUZzZTWGxjS2dsL2dUQzZLVTdyYzM4QVc4bFgyUXJVdUtDOXowTUZwMW9vU2NVekpIQng1V05CcFlqUDhzRTAwdmpkZTJZQ3c4QXhoMFBLYkFiRkgza3hLTVBBeWk1OTdkM3pqVTlMUlhWWVF2WFJZbFRJRHYvS3JwdnBSZDQzbGtwMEphS2YxdzN5Rm92WnA1UnZRREpLdC9yMVNWN2VtVkU0RXRMUGYraFR2SFNNSHlMK0dIenNJWTFZQlB5R2tqS0pJQ2hHOHhXZz09', 'UPDATE', 'PROD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(100) NOT NULL,
  `UserSalutation` varchar(1000) NOT NULL,
  `UserFullName` varchar(500) NOT NULL,
  `UserPhoneNumber` varchar(100) NOT NULL,
  `UserEmailId` varchar(1000) NOT NULL,
  `UserPassword` varchar(500) NOT NULL,
  `UserCreatedAt` varchar(25) NOT NULL DEFAULT 'current_timestamp(6)',
  `UserUpdatedAt` varchar(25) NOT NULL DEFAULT 'current_timestamp(6)',
  `UserStatus` tinyint(1) NOT NULL DEFAULT 1,
  `UserNotes` longtext NOT NULL,
  `UserCompanyName` varchar(1000) NOT NULL,
  `UserDepartment` varchar(1000) NOT NULL,
  `UserDesignation` varchar(1000) NOT NULL,
  `UserWorkFeilds` varchar(1000) NOT NULL,
  `UserProfileImage` varchar(1000) NOT NULL DEFAULT 'default.png',
  `UserType` varchar(1000) NOT NULL,
  `UserDateOfBirth` varchar(100) NOT NULL,
  `Deleted_At` datetime DEFAULT NULL,
  `Deleted_By` int(11) DEFAULT NULL,
  `UserReportingManager` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserSalutation`, `UserFullName`, `UserPhoneNumber`, `UserEmailId`, `UserPassword`, `UserCreatedAt`, `UserUpdatedAt`, `UserStatus`, `UserNotes`, `UserCompanyName`, `UserDepartment`, `UserDesignation`, `UserWorkFeilds`, `UserProfileImage`, `UserType`, `UserDateOfBirth`, `Deleted_At`, `Deleted_By`, `UserReportingManager`) VALUES
(1, 'MR', 'GAURAV SINGH', '', 'gauravsinghigc@gmail.com', 'Gsi@9810', '2025-04-24 01:05:27 PM', '2025-05-28 07:19:19 PM', 1, 'Y0x3dlRPSjJ4RTVsVHhxdWo1QzBldz09', 'BMR REALTY', 'Others', 'Administrator', '', 'Profile_Photo__UID_1__07_May_2025_11_05_24_21547965623_.jpg', 'ADMIN', '2001-12-02', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users_urls`
--

CREATE TABLE `users_urls` (
  `user_url_id` int(10) NOT NULL,
  `user_url_main_user_id` int(10) NOT NULL,
  `user_url_name` varchar(100) NOT NULL,
  `user_url_icon` varchar(50) NOT NULL,
  `user_url_link` varchar(725) NOT NULL,
  `user_url_created_at` varchar(45) NOT NULL,
  `user_url_updated_at` varchar(45) NOT NULL,
  `user_url_created_by` int(10) NOT NULL,
  `user_url_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `UserAddressId` int(100) NOT NULL,
  `UserAddressUserId` int(100) NOT NULL,
  `UserStreetAddress` varchar(10000) NOT NULL,
  `UserLocality` varchar(200) NOT NULL,
  `UserCity` varchar(200) NOT NULL,
  `UserState` varchar(200) NOT NULL,
  `UserCountry` varchar(200) NOT NULL,
  `UserPincode` varchar(200) NOT NULL,
  `UserAddressType` varchar(100) NOT NULL,
  `UserAddressContactPerson` varchar(1000) NOT NULL,
  `UserAddressNotes` varchar(1000) NOT NULL,
  `UserAddressMapUrl` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`UserAddressId`, `UserAddressUserId`, `UserStreetAddress`, `UserLocality`, `UserCity`, `UserState`, `UserCountry`, `UserPincode`, `UserAddressType`, `UserAddressContactPerson`, `UserAddressNotes`, `UserAddressMapUrl`) VALUES
(1, 1, 'NA', 'NA', 'NA', 'NA', 'NA', 'NA', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_password_change_requests`
--

CREATE TABLE `user_password_change_requests` (
  `PasswordChangeReqId` int(100) NOT NULL,
  `UserIdForPasswordChange` varchar(1000) NOT NULL,
  `PasswordChangeToken` varchar(1000) NOT NULL,
  `PasswordChangeTokenExpireTime` varchar(1000) NOT NULL,
  `PasswordChangeDeviceDetails` varchar(10000) NOT NULL,
  `PasswordChangeRequestStatus` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_verification_status`
--

CREATE TABLE `user_verification_status` (
  `user_verification_id` int(10) NOT NULL,
  `user_main_id` int(10) NOT NULL,
  `UserVerificationCode` int(10) NOT NULL,
  `UserVerificationStatus` int(2) NOT NULL,
  `UserVerificationCodeValidity` varchar(45) NOT NULL,
  `UserVerificationCodeCreatedAt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`configurationsid`);

--
-- Indexes for table `config_facebook_accounts`
--
ALTER TABLE `config_facebook_accounts`
  ADD PRIMARY KEY (`config_facebook_accounts_id`);

--
-- Indexes for table `config_leads_resources`
--
ALTER TABLE `config_leads_resources`
  ADD PRIMARY KEY (`config_leads_resources_id`);

--
-- Indexes for table `config_leads_sources`
--
ALTER TABLE `config_leads_sources`
  ADD PRIMARY KEY (`config_leads_source_id`);

--
-- Indexes for table `config_leads_stages`
--
ALTER TABLE `config_leads_stages`
  ADD PRIMARY KEY (`config_leads_stages_id`);

--
-- Indexes for table `config_leads_sub_stages`
--
ALTER TABLE `config_leads_sub_stages`
  ADD PRIMARY KEY (`config_call_sub_status_id`);

--
-- Indexes for table `config_mail_sender`
--
ALTER TABLE `config_mail_sender`
  ADD PRIMARY KEY (`config_mail_sender_id`);

--
-- Indexes for table `config_priority_levels`
--
ALTER TABLE `config_priority_levels`
  ADD PRIMARY KEY (`config_priority_level_id`);

--
-- Indexes for table `config_projects_locations`
--
ALTER TABLE `config_projects_locations`
  ADD PRIMARY KEY (`config_projects_locations_id`);

--
-- Indexes for table `config_projects_stages`
--
ALTER TABLE `config_projects_stages`
  ADD PRIMARY KEY (`config_projects_stages_id`);

--
-- Indexes for table `config_projects_status`
--
ALTER TABLE `config_projects_status`
  ADD PRIMARY KEY (`config_projects_status_id`);

--
-- Indexes for table `config_project_types`
--
ALTER TABLE `config_project_types`
  ADD PRIMARY KEY (`config_project_types_id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`leads_id`);

--
-- Indexes for table `leads_activities`
--
ALTER TABLE `leads_activities`
  ADD PRIMARY KEY (`leads_acitivity_id`);

--
-- Indexes for table `leads_address`
--
ALTER TABLE `leads_address`
  ADD PRIMARY KEY (`leads_address_id`);

--
-- Indexes for table `leads_assignees`
--
ALTER TABLE `leads_assignees`
  ADD PRIMARY KEY (`leads_assign_id`);

--
-- Indexes for table `leads_attributes`
--
ALTER TABLE `leads_attributes`
  ADD PRIMARY KEY (`leads_attributes_id`);

--
-- Indexes for table `leads_reminders`
--
ALTER TABLE `leads_reminders`
  ADD PRIMARY KEY (`leads_reminder_id`);

--
-- Indexes for table `leads_requirements`
--
ALTER TABLE `leads_requirements`
  ADD PRIMARY KEY (`leads_requirement_id`);

--
-- Indexes for table `leads_site_visits`
--
ALTER TABLE `leads_site_visits`
  ADD PRIMARY KEY (`leads_site_visit_id`);

--
-- Indexes for table `leads_site_visits_attachements`
--
ALTER TABLE `leads_site_visits_attachements`
  ADD PRIMARY KEY (`leads_activity_attachement_id`);

--
-- Indexes for table `leads_uploaded_things`
--
ALTER TABLE `leads_uploaded_things`
  ADD PRIMARY KEY (`leads_uploaded_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projects_id`);

--
-- Indexes for table `projects_developers`
--
ALTER TABLE `projects_developers`
  ADD PRIMARY KEY (`projects_developers_id`);

--
-- Indexes for table `projects_media_files`
--
ALTER TABLE `projects_media_files`
  ADD PRIMARY KEY (`projects_media_files_id`);

--
-- Indexes for table `project_amenities`
--
ALTER TABLE `project_amenities`
  ADD PRIMARY KEY (`project_amenities_id`);

--
-- Indexes for table `systemlogs`
--
ALTER TABLE `systemlogs`
  ADD PRIMARY KEY (`LogsId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `users_urls`
--
ALTER TABLE `users_urls`
  ADD PRIMARY KEY (`user_url_id`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`UserAddressId`);

--
-- Indexes for table `user_password_change_requests`
--
ALTER TABLE `user_password_change_requests`
  ADD PRIMARY KEY (`PasswordChangeReqId`);

--
-- Indexes for table `user_verification_status`
--
ALTER TABLE `user_verification_status`
  ADD PRIMARY KEY (`user_verification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `configurationsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `config_facebook_accounts`
--
ALTER TABLE `config_facebook_accounts`
  MODIFY `config_facebook_accounts_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `config_leads_resources`
--
ALTER TABLE `config_leads_resources`
  MODIFY `config_leads_resources_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `config_leads_sources`
--
ALTER TABLE `config_leads_sources`
  MODIFY `config_leads_source_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `config_leads_stages`
--
ALTER TABLE `config_leads_stages`
  MODIFY `config_leads_stages_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `config_leads_sub_stages`
--
ALTER TABLE `config_leads_sub_stages`
  MODIFY `config_call_sub_status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `config_mail_sender`
--
ALTER TABLE `config_mail_sender`
  MODIFY `config_mail_sender_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `config_priority_levels`
--
ALTER TABLE `config_priority_levels`
  MODIFY `config_priority_level_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `config_projects_locations`
--
ALTER TABLE `config_projects_locations`
  MODIFY `config_projects_locations_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `config_projects_stages`
--
ALTER TABLE `config_projects_stages`
  MODIFY `config_projects_stages_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `config_projects_status`
--
ALTER TABLE `config_projects_status`
  MODIFY `config_projects_status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `config_project_types`
--
ALTER TABLE `config_project_types`
  MODIFY `config_project_types_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `leads_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_activities`
--
ALTER TABLE `leads_activities`
  MODIFY `leads_acitivity_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_address`
--
ALTER TABLE `leads_address`
  MODIFY `leads_address_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_assignees`
--
ALTER TABLE `leads_assignees`
  MODIFY `leads_assign_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_attributes`
--
ALTER TABLE `leads_attributes`
  MODIFY `leads_attributes_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_reminders`
--
ALTER TABLE `leads_reminders`
  MODIFY `leads_reminder_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leads_requirements`
--
ALTER TABLE `leads_requirements`
  MODIFY `leads_requirement_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_site_visits`
--
ALTER TABLE `leads_site_visits`
  MODIFY `leads_site_visit_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leads_site_visits_attachements`
--
ALTER TABLE `leads_site_visits_attachements`
  MODIFY `leads_activity_attachement_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads_uploaded_things`
--
ALTER TABLE `leads_uploaded_things`
  MODIFY `leads_uploaded_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `projects_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects_developers`
--
ALTER TABLE `projects_developers`
  MODIFY `projects_developers_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_media_files`
--
ALTER TABLE `projects_media_files`
  MODIFY `projects_media_files_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_amenities`
--
ALTER TABLE `project_amenities`
  MODIFY `project_amenities_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `systemlogs`
--
ALTER TABLE `systemlogs`
  MODIFY `LogsId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users_urls`
--
ALTER TABLE `users_urls`
  MODIFY `user_url_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `UserAddressId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_password_change_requests`
--
ALTER TABLE `user_password_change_requests`
  MODIFY `PasswordChangeReqId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_verification_status`
--
ALTER TABLE `user_verification_status`
  MODIFY `user_verification_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
