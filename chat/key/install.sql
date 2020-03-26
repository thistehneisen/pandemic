-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2020 at 01:55 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grupo`
--

-- --------------------------------------------------------

--
-- Table structure for table `gr_alerts`
--

CREATE TABLE `gr_alerts` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT '10',
  `v1` varchar(255) DEFAULT NULL,
  `v2` bigint(20) DEFAULT NULL,
  `v3` bigint(20) DEFAULT NULL,
  `tms` datetime DEFAULT NULL,
  `seen` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gr_complaints`
--

CREATE TABLE `gr_complaints` (
  `id` bigint(20) NOT NULL,
  `gid` bigint(20) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `msid` bigint(20) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(5) DEFAULT 1,
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gr_customize`
--

CREATE TABLE `gr_customize` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `element` text DEFAULT NULL,
  `device` varchar(20) DEFAULT 'all',
  `type` varchar(255) DEFAULT NULL,
  `v1` varchar(255) DEFAULT NULL,
  `v2` varchar(255) DEFAULT NULL,
  `xtra` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_customize`
--

INSERT INTO `gr_customize` (`id`, `name`, `element`, `device`, `type`, `v1`, `v2`, `xtra`) VALUES
(1, 'custom_css', '', 'all', 'custom', '', '', '0'),
(2, 'aside_left_header_bg', '.swr-grupo .lside > .head', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(3, 'aside_left_header_icon_color', '.swr-grupo .aside > .head i', 'all', 'color', '#A9A9A9', '', '0'),
(4, 'aside_left_header_icon_size', '.swr-grupo .lside > .head i', 'all', 'font-size', '25', '', '0'),
(5, 'aside_left_search_bg', '.swr-grupo .lside > .search', 'all', 'background', '#F7F9FB', '#F7F9FB', '0'),
(6, 'aside_left_search_input_bg', '.swr-grupo .lside > .search > input', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(7, 'aside_left_search_input_text_color', '.swr-grupo .lside > .search > input,.swr-grupo .lside > .search > i', 'all', 'color', '#676767', '', '0'),
(8, 'aside_left_search_input_font_size', '.swr-grupo .lside > .search > input', 'all', 'font-size', '14', '', '0'),
(9, 'aside_left_search_input_icon_size', '.swr-grupo .lside > .search > i', 'all', 'font-size', '16', '', '0'),
(10, 'aside_left_tabs_bg', '.swr-grupo .lside > .tabs', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(11, 'aside_left_tabs_text_color', '.swr-grupo .lside > .tabs > ul > li', 'all', 'color', '#808080', '', '0'),
(12, 'aside_left_active_tab_text_color', '.swr-grupo .lside > .tabs > ul > li.active', 'all', 'color', '#000000', '', '0'),
(13, 'aside_left_active_tab_border_color', '.swr-grupo .lside > .tabs > ul > li.active', 'all', 'border-color', '#E91E63', '', 'easyedit'),
(14, 'aside_left_contents_bg', '.swr-grupo .lside', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(15, 'aside_left_list_title_text_color', '.swr-grupo .lside > .content > .list > li > div > .center > b > span', 'all', 'color', '#696767', '', '0'),
(16, 'aside_left_list_sub_text_color', '.swr-grupo .lside > .content > .list > li > div > .center > span', 'all', 'color', '#828588', '', '0'),
(17, 'aside_left_list_title_font-size', '.swr-grupo .lside > .content > .list > li > div > .center > b > span', 'all', 'font-size', '13', '', '0'),
(18, 'aside_left_list_sub_font-size', '.swr-grupo .lside > .content > .list > li > div > .center > span', 'all', 'font-size', '12', '', '0'),
(19, 'aside_left_list_options_text_color', '.swr-grupo .lside > .content > .list > li > div > .right', 'all', 'color', '#A4A5A7', '', '0'),
(20, 'aside_left_list_options_font_size', '.swr-grupo .lside > .content > .list > li > div > .right', 'all', 'font-size', '11', '', '0'),
(21, 'aside_left_list_options_hover_bg', '.swr-grupo .lside .opt > ul > li:hover', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(22, 'aside_left_list_options_hover_text_color', '.swr-grupo .lside .opt > ul > li:hover', 'all', 'color', '#FFFFFF', '', '0'),
(23, 'aside_left_list_add_icon_bg', '.swr-grupo .lside > .content > .addmore > span', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(24, 'aside_left_list_add_icon_color', '.swr-grupo .lside > .content > .addmore > span', 'all', 'color', '#FFFFFF', '', '0'),
(25, 'aside_left_list_add_icon_size', '.swr-grupo .lside > .content > .addmore > span > i', 'all', 'font-size', '16', '', '0'),
(26, 'aside_right_header_bg', '.swr-grupo .rside > .head', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(27, 'aside_right_profile_name_text_color', '.swr-grupo .rside > .top > .left > span > span', 'all', 'color', '#5A5A5A', '', '0'),
(28, 'aside_right_username_text_color', '.swr-grupo .rside > .top > .left > span > span > span', 'all', 'color', '#8B8E90', '', '0'),
(29, 'aside_right_search_bg', '.swr-grupo .rside > .search', 'all', 'background', '#F7F9FB', '#F7F9FB', '0'),
(30, 'aside_right_search_input_bg', '.swr-grupo .rside > .search > input', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(31, 'aside_right_search_input_text_color', '.swr-grupo .rside > .search > input,.swr-grupo .rside > .search > i', 'all', 'color', '#676767', '', '0'),
(32, 'aside_right_search_input_font_size', '.swr-grupo .rside > .search > input', 'all', 'font-size', '14', '', '0'),
(33, 'aside_right_search_input_icon_size', '.swr-grupo .rside > .search > i', 'all', 'font-size', '16', '', '0'),
(34, 'aside_right_tabs_bg', '.swr-grupo .rside > .tabs', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(35, 'aside_right_tabs_text_color', '.swr-grupo .rside > .tabs > ul > li', 'all', 'color', '#808080', '', '0'),
(36, 'aside_right_active_tab_text_color', '.swr-grupo .rside > .tabs > ul > li.active', 'all', 'color', '#000000', '', '0'),
(37, 'aside_right_active_tab_border_color', '.swr-grupo .rside > .tabs > ul > li.active', 'all', 'border-color', '#E91E63', '', 'easyedit'),
(38, 'aside_right_contents_bg', '.swr-grupo .rside', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(39, 'aside_right_list_title_text_color', '.swr-grupo .rside > .content > .list > li > div > .center > b > span', 'all', 'color', '#696767', '', '0'),
(40, 'aside_right_list_sub_text_color', '.swr-grupo .rside > .content > .list > li > div > .center > span', 'all', 'color', '#828588', '', '0'),
(41, 'aside_right_list_title_font-size', '.swr-grupo .rside > .content > .list > li > div > .center > b > span', 'all', 'font-size', '13', '', '0'),
(42, 'aside_right_list_sub_font-size', '.swr-grupo .rside > .content > .list > li > div > .center > span', 'all', 'font-size', '12', '', '0'),
(43, 'aside_right_list_options_text_color', '.swr-grupo .rside > .content > .list > li > div > .right', 'all', 'color', '#A4A5A7', '', '0'),
(44, 'aside_right_list_options_font_size', '.swr-grupo .rside > .content > .list > li > div > .right', 'all', 'font-size', '11', '', '0'),
(45, 'aside_right_list_options_hover_bg', '.swr-grupo .rside .opt > ul > li:hover', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(46, 'aside_right_list_options_hover_text_color', '.swr-grupo .rside .opt > ul > li:hover', 'all', 'color', '#FFFFFF', '', '0'),
(47, 'aside_right_list_add_icon_bg', '.swr-grupo .rside > .content > .addmore > span', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(48, 'aside_right_list_add_icon_color', '.swr-grupo .rside > .content > .addmore > span', 'all', 'color', '#FFFFFF', '', '0'),
(49, 'aside_right_list_add_icon_size', '.swr-grupo .rside > .content > .addmore > span > i', 'all', 'font-size', '16', '', '0'),
(50, 'menu_background', '.swr-menu', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(51, 'menu_text_color', '.swr-menu', 'all', 'color', '#FFFFFF', '', '0'),
(52, 'menu_active_bg', '.swr-menu > ul > li:hover, .swr-menu > ul > li.active', 'all', 'background', '#101010', '#101010', '0'),
(53, 'menu_active_text_color', '.swr-menu > ul > li:hover, .swr-menu > ul > li.active', 'all', 'color', '#FFFFFF', '', '0'),
(54, 'chatbox_bg', '.swr-grupo .panel', 'all', 'background', '#F7F9FB', '#F7F9FB', '0'),
(55, 'chatbox_welcome_text_color', '.swr-grupo .zeroelem > .welcome > span > i', 'all', 'color', '#6B6B6B', '', '0'),
(56, 'chatbox_welcome_heading_font_size', '.swr-grupo .zeroelem > .welcome > span > i.title', 'all', 'font-size', '21', '', '0'),
(57, 'chatbox_welcome_desc_font_size', '.swr-grupo .zeroelem > .welcome > span > i.desc', 'all', 'font-size', '15', '', '0'),
(58, 'chatbox_welcome_footer_font_size', '.swr-grupo .zeroelem > .welcome > span> i.foot', 'all', 'font-size', '13', '', '0'),
(59, 'chatbox_header_bg', '.swr-grupo .panel > .head', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(60, 'chatbox_header_title_text_color', '.swr-grupo .panel > .head > .left > span > span', 'all', 'color', '#E91E63', '', 'easyedit'),
(61, 'chatbox_header_title_font_size', '.swr-grupo .panel > .head > .left > span > span', 'all', 'font-size', '13', '', '0'),
(62, 'chatbox_header_sub_text_color', '.swr-grupo .panel > .head > .left > span > span > span,.swr-grupo .panel > .head > .left > span > span > .typing', 'all', 'color', '#8B8E90', '', '0'),
(63, 'chatbox_header_sub_font_size', '.swr-grupo .panel > .head > .left > span > span > span,.swr-grupo .panel > .head > .left > span > span > .typing', 'all', 'font-size', '12', '', '0'),
(64, 'chatbox_header_icon_color', '.swr-grupo .panel > .head > .right > i', 'all', 'color', '#8B8E90', '', '0'),
(65, 'chatbox_header_icon_size', '.swr-grupo .panel > .head > .right > i', 'all', 'font-size', '19', '', '0'),
(66, 'chatbox_searchbox_bg', '.swr-grupo .panel > .searchbar > span > input', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(67, 'chatbox_searchbox_text_color', '.swr-grupo .panel > .searchbar > span,.swr-grupo .panel > .searchbar > span > input', 'all', 'color', '#6B6B6B', '', '0'),
(68, 'chatbox_searchbox_font_size', '.swr-grupo .panel > .searchbar > span > input', 'all', 'font-size', '14', '', '0'),
(69, 'chatbox_searchbox_icon_size', '.swr-grupo .panel > .searchbar > span > i', 'all', 'font-size', '16', '', '0'),
(70, 'received_message_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(71, 'received_message_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'all', 'color', '#333333', '', '0'),
(72, 'received_message_mention_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i i.mentnd', 'all', 'color', '#FF9800', '', '0'),
(73, 'received_message_font_size', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'all', 'font-size', '13', '', '0'),
(74, 'received_message_time_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > .info', 'all', 'color', '#333333', '', '0'),
(75, 'received_message_time_font_size', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > .info', 'all', 'font-size', '10', '', '0'),
(76, 'sent_message_bg', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(77, 'sent_message_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'all', 'color', '#FFFFFF', '', '0'),
(78, 'sent_message_mention_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i i.mentnd', 'all', 'color', '#FFEB3B', '', '0'),
(79, 'sent_message_font_size', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'all', 'font-size', '13', '', '0'),
(80, 'sent_message_time_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i > .info', 'all', 'color', '#FFFFFF', '', '0'),
(81, 'sent_message_time_font_size', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i > .info', 'all', 'font-size', '10', '', '0'),
(82, 'audio_player_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay', 'all', 'background', '#607D8B', '#607D8B', '0'),
(83, 'audio_player_controls_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play', 'all', 'color', '#FFFFFF', '', '0'),
(84, 'audio_player_seek_bar_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar', 'all', 'background', '#616161', '#616161', '0'),
(85, 'audio_player_slider_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar > i', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(86, 'audio_player_icon_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.icon', 'all', 'background', '#3F535D', '#3F535D', '0'),
(87, 'audio_player_icon_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.icon', 'all', 'color', '#FFFFFF', '', '0'),
(88, 'chatbox_textarea_bg', '.swr-grupo .panel > .textbox > .box', 'all', 'background', '#F7F9FB', '#F7F9FB', '0'),
(89, 'chatbox_textarea_input_bg', '.emojionearea.focused, .emojionearea > .emojionearea-editor, .emojionearea', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(90, 'chatbox_textarea_input_text_color', '.emojionearea.focused, .emojionearea > .emojionearea-editor, .emojionearea', 'all', 'color', '#676767', '', '0'),
(91, 'mobile_aside_left_header_bg', '.swr-grupo .lside > .head', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(92, 'mobile_aside_left_header_icon_color', '.swr-grupo .aside > .head i', 'mobile', 'color', '#FFFFFF', '', '0'),
(93, 'mobile_aside_left_header_icon_size', '.swr-grupo .lside > .head i', 'mobile', 'font-size', '25', '', '0'),
(94, 'mobile_aside_left_search_bg', '.swr-grupo .lside > .search', 'mobile', 'background', '#000000', '#000000', '0'),
(95, 'mobile_aside_left_search_input_bg', '.swr-grupo .lside > .search > input', 'mobile', 'background', '#000000', '#000000', '0'),
(96, 'mobile_aside_left_search_input_text_color', '.swr-grupo .lside > .search > input,.swr-grupo .lside > .search > i', 'mobile', 'color', '#FFFFFF', '', '0'),
(97, 'mobile_aside_left_search_input_font_size', '.swr-grupo .lside > .search > input', 'mobile', 'font-size', '14', '', '0'),
(98, 'mobile_aside_left_search_input_icon_size', '.swr-grupo .lside > .search > i', 'mobile', 'font-size', '16', '', '0'),
(99, 'mobile_aside_left_tabs_bg', '.swr-grupo .lside > .tabs', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(100, 'mobile_aside_left_tabs_text_color', '.swr-grupo .lside > .tabs > ul > li', 'mobile', 'color', '#808080', '', '0'),
(101, 'mobile_aside_left_active_tab_text_color', '.swr-grupo .lside > .tabs > ul > li.active', 'mobile', 'color', '#000000', '', '0'),
(102, 'mobile_aside_left_active_tab_border_color', '.swr-grupo .lside > .tabs > ul > li.active', 'mobile', 'custom', '#E91E63', '#E91E63', 'easyedit'),
(103, 'mobile_aside_left_contents_bg', '.swr-grupo .lside', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(104, 'mobile_aside_left_list_title_text_color', '.swr-grupo .lside > .content > .list > li > div > .center > b > span', 'mobile', 'color', '#696767', '', '0'),
(105, 'mobile_aside_left_list_sub_text_color', '.swr-grupo .lside > .content > .list > li > div > .center > span', 'mobile', 'color', '#828588', '', '0'),
(106, 'mobile_aside_left_list_title_font-size', '.swr-grupo .lside > .content > .list > li > div > .center > b > span', 'mobile', 'font-size', '13', '', '0'),
(107, 'mobile_aside_left_list_sub_font-size', '.swr-grupo .lside > .content > .list > li > div > .center > span', 'mobile', 'font-size', '12', '', '0'),
(108, 'mobile_aside_left_list_options_text_color', '.swr-grupo .lside > .content > .list > li > div > .right', 'mobile', 'color', '#A4A5A7', '', '0'),
(109, 'mobile_aside_left_list_options_font_size', '.swr-grupo .lside > .content > .list > li > div > .right', 'mobile', 'font-size', '11', '', '0'),
(110, 'mobile_aside_left_list_options_hover_bg', '.swr-grupo .lside .opt > ul > li:hover', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(111, 'mobile_aside_left_list_options_hover_text_color', '.swr-grupo .lside .opt > ul > li:hover', 'mobile', 'color', '#FFFFFF', '', '0'),
(112, 'mobile_aside_left_list_add_icon_bg', '.swr-grupo .lside > .content > .addmore > span', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(113, 'mobile_aside_left_list_add_icon_color', '.swr-grupo .lside > .content > .addmore > span', 'mobile', 'color', '#FFFFFF', '', '0'),
(114, 'mobile_aside_left_list_add_icon_size', '.swr-grupo .lside > .content > .addmore > span > i', 'mobile', 'font-size', '16', '', '0'),
(115, 'mobile_aside_right_header_bg', '.swr-grupo .aside > .head, .swr-grupo .panel > .head, .swr-grupo .rside > .top', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(116, 'mobile_aside_right_profile_name_text_color', '.swr-grupo .rside > .top > .left > span > span', 'mobile', 'color', '#FFFFFF', '', '0'),
(117, 'mobile_aside_right_username_text_color', '.swr-grupo .rside > .top > .left > span > span > span', 'mobile', 'color', '#FFFFFF', '', '0'),
(118, 'mobile_aside_right_search_bg', '.swr-grupo .rside > .search', 'mobile', 'background', '#000000', '#000000', '0'),
(119, 'mobile_aside_right_search_input_bg', '.swr-grupo .rside > .search > input', 'mobile', 'background', '#000000', '#000000', '0'),
(120, 'mobile_aside_right_search_input_text_color', '.swr-grupo .rside > .search > input,.swr-grupo .rside > .search > i', 'mobile', 'color', '#FFFFFF', '', '0'),
(121, 'mobile_aside_right_search_input_font_size', '.swr-grupo .rside > .search > input', 'mobile', 'font-size', '14', '', '0'),
(122, 'mobile_aside_right_search_input_icon_size', '.swr-grupo .rside > .search > i', 'mobile', 'font-size', '16', '', '0'),
(123, 'mobile_aside_right_tabs_bg', '.swr-grupo .rside > .tabs', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(124, 'mobile_aside_right_tabs_text_color', '.swr-grupo .rside > .tabs > ul > li', 'mobile', 'color', '#808080', '', '0'),
(125, 'mobile_aside_right_active_tab_text_color', '.swr-grupo .rside > .tabs > ul > li.active', 'mobile', 'color', '#000000', '', '0'),
(126, 'mobile_aside_right_active_tab_border_color', '.swr-grupo .rside > .tabs > ul > li.active', 'mobile', 'border-color', '#E91E63', '', 'easyedit'),
(127, 'mobile_aside_right_contents_bg', '.swr-grupo .rside', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(128, 'mobile_aside_right_list_title_text_color', '.swr-grupo .rside > .content > .list > li > div > .center > b > span', 'mobile', 'color', '#696767', '', '0'),
(129, 'mobile_aside_right_list_sub_text_color', '.swr-grupo .rside > .content > .list > li > div > .center > span', 'mobile', 'color', '#828588', '', '0'),
(130, 'mobile_aside_right_list_title_font-size', '.swr-grupo .rside > .content > .list > li > div > .center > b > span', 'mobile', 'font-size', '13', '', '0'),
(131, 'mobile_aside_right_list_sub_font-size', '.swr-grupo .rside > .content > .list > li > div > .center > span', 'mobile', 'font-size', '12', '', '0'),
(132, 'mobile_aside_right_list_options_text_color', '.swr-grupo .rside > .content > .list > li > div > .right', 'mobile', 'color', '#A4A5A7', '', '0'),
(133, 'mobile_aside_right_list_options_font_size', '.swr-grupo .rside > .content > .list > li > div > .right', 'mobile', 'font-size', '11', '', '0'),
(134, 'mobile_aside_right_list_options_hover_bg', '.swr-grupo .rside .opt > ul > li:hover', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(135, 'mobile_aside_right_list_options_hover_text_color', '.swr-grupo .rside .opt > ul > li:hover', 'mobile', 'color', '#FFFFFF', '', '0'),
(136, 'mobile_aside_right_list_add_icon_bg', '.swr-grupo .rside > .content > .addmore > span', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(137, 'mobile_aside_right_list_add_icon_color', '.swr-grupo .rside > .content > .addmore > span', 'mobile', 'color', '#FFFFFF', '', '0'),
(138, 'mobile_aside_right_list_add_icon_size', '.swr-grupo .rside > .content > .addmore > span > i', 'mobile', 'font-size', '16', '', '0'),
(139, 'mobile_menu_background', '.swr-menu', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(140, 'mobile_menu_text_color', '.swr-menu', 'mobile', 'color', '#FFFFFF', '', '0'),
(141, 'mobile_menu_active_bg', '.swr-menu > ul > li:hover, .swr-menu > ul > li.active', 'mobile', 'background', '#101010', '#101010', '0'),
(142, 'mobile_menu_active_text_color', '.swr-menu > ul > li:hover, .swr-menu > ul > li.active', 'mobile', 'color', '#FFFFFF', '', '0'),
(143, 'mobile_chatbox_bg', '.swr-grupo .panel', 'mobile', 'background', '#F7F9FB', '#F7F9FB', '0'),
(144, 'mobile_chatbox_welcome_text_color', '.swr-grupo .zeroelem > .welcome > span > i', 'mobile', 'color', '#6B6B6B', '', '0'),
(145, 'mobile_chatbox_welcome_heading_font_size', '.swr-grupo .zeroelem > .welcome > span > i.title', 'mobile', 'font-size', '21', '', '0'),
(146, 'mobile_chatbox_welcome_desc_font_size', '.swr-grupo .zeroelem > .welcome > span > i.desc', 'mobile', 'font-size', '15', '', '0'),
(147, 'mobile_chatbox_welcome_footer_font_size', '.swr-grupo .zeroelem > .welcome > span> i.foot', 'mobile', 'font-size', '13', '', '0'),
(148, 'mobile_chatbox_header_bg', '.swr-grupo .panel > .head', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(149, 'mobile_chatbox_header_title_text_color', '.swr-grupo .panel > .head > .left > span > span', 'mobile', 'color', '#FFFFFF', '', '0'),
(150, 'mobile_chatbox_header_title_font_size', '.swr-grupo .panel > .head > .left > span > span', 'mobile', 'font-size', '13', '', '0'),
(151, 'mobile_chatbox_header_sub_text_color', '.swr-grupo .panel > .head > .left > span > span > span,.swr-grupo .panel > .head > .left > span > span > .typing', 'mobile', 'color', '#FFFFFF', '', '0'),
(152, 'mobile_chatbox_header_sub_font_size', '.swr-grupo .panel > .head > .left > span > span > span,.swr-grupo .panel > .head > .left > span > span > .typing', 'mobile', 'font-size', '12', '', '0'),
(153, 'mobile_chatbox_header_icon_color', '.swr-grupo .panel > .head > .right > i', 'mobile', 'color', '#FFFFFF', '', '0'),
(154, 'mobile_chatbox_header_icon_size', '.swr-grupo .panel > .head > .right > i', 'mobile', 'font-size', '22', '', '0'),
(155, 'mobile_chatbox_searchbox_bg', '.swr-grupo .panel > .searchbar > span > input', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(156, 'mobile_chatbox_searchbox_text_color', '.swr-grupo .panel > .searchbar > span,.swr-grupo .panel > .searchbar > span > input', 'mobile', 'color', '#6B6B6B', '', '0'),
(157, 'mobile_chatbox_searchbox_font_size', '.swr-grupo .panel > .searchbar > span > input', 'mobile', 'font-size', '14', '', '0'),
(158, 'mobile_chatbox_searchbox_icon_size', '.swr-grupo .panel > .searchbar > span > i', 'mobile', 'font-size', '16', '', '0'),
(159, 'mobile_received_message_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(160, 'mobile_received_message_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'mobile', 'color', '#333333', '', '0'),
(161, 'mobile_received_message_mention_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > i.mentnd', 'mobile', 'color', '#FF9800', '', '0'),
(162, 'mobile_received_message_font_size', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i', 'mobile', 'font-size', '13', '', '0'),
(163, 'mobile_received_message_time_text_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > .info', 'mobile', 'color', '#333333', '', '0'),
(164, 'mobile_received_message_time_font_size', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > .info', 'mobile', 'font-size', '10', '', '0'),
(165, 'mobile_sent_message_bg', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'mobile', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(166, 'mobile_sent_message_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'mobile', 'color', '#FFFFFF', '', '0'),
(167, 'mobile_sent_message_mention_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i > i.mentnd', 'mobile', 'color', '#FFEB3B', '', '0'),
(168, 'mobile_sent_message_font_size', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i', 'mobile', 'font-size', '13', '', '0'),
(169, 'mobile_sent_message_time_text_color', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i > .info', 'mobile', 'color', '#FFFFFF', '', '0'),
(170, 'mobile_sent_message_time_font_size', '.swr-grupo .panel > .room > .msgs > li.you > div > .msg > i > .info', 'mobile', 'font-size', '10', '', '0'),
(171, 'mobile_audio_player_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay', 'mobile', 'background', '#607D8B', '#607D8B', '0'),
(172, 'mobile_audio_player_controls_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.play', 'mobile', 'color', '#FFFFFF', '', '0'),
(173, 'mobile_audio_player_seek_bar_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar', 'mobile', 'background', '#616161', '#616161', '0'),
(174, 'mobile_audio_player_slider_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.seek > i.bar > i', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(175, 'mobile_audio_player_icon_bg', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.icon', 'mobile', 'background', '#3F535D', '#3F535D', '0'),
(176, 'mobile_audio_player_icon_color', '.swr-grupo .panel > .room > .msgs > li > div > .msg > i > span.audioplay > span.icon', 'mobile', 'color', '#FFFFFF', '', '0'),
(177, 'mobile_chatbox_textarea_bg', '.swr-grupo .panel > .textbox > .box', 'mobile', 'background', '#F7F9FB', '#F7F9FB', '0'),
(178, 'mobile_chatbox_textarea_input_bg', '.emojionearea.focused, .emojionearea > .emojionearea-editor, .emojionearea', 'mobile', 'background', '#FFFFFF', '#FFFFFF', '0'),
(179, 'mobile_chatbox_textarea_input_text_color', '.emojionearea.focused, .emojionearea > .emojionearea-editor, .emojionearea', 'mobile', 'color', '#676767', '', '0'),
(180, 'form_popup_header_bg', '.grupo-pop > div > form > .head', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(181, 'form_popup_header_textcolor', '.grupo-pop > div > form > .head', 'all', 'color', '#FFFFFF', '', '0'),
(182, 'form_popup_header_font_size', '.grupo-pop > div > form > .head', 'all', 'font-size', '14', '', '0'),
(183, 'form_popup_search_bg', '.grupo-pop > div > form > .search', 'all', 'background', '#181A21', '#181A21', '0'),
(184, 'form_popup_search_text_color', '.grupo-pop > div > form > .search > i, .grupo-pop > div > form > .search > input', 'all', 'color', '#E2E2E2', '', '0'),
(185, 'form_popup_bg', '.grupo-pop > div > form', 'all', 'background', '#232630', '#252D40', '0'),
(186, 'form_popup_field_text_color', '.grupo-pop > div > form > div > div > label', 'all', 'color', '#FFFFFF', '', '0'),
(187, 'form_popup_field_font_size', '.grupo-pop > div > form > div > div > label', 'all', 'font-size', '14', '', '0'),
(188, 'form_popup_input_text_color', '.grupo-pop > div > form > .fields > div > span, .grupo-pop > div > form > div > div > input, .grupo-pop > div > form > div > div > select, .grupo-pop > div > form > div > div > textarea', 'all', 'color', '#9FABB1', '', '0'),
(189, 'form_popup_input_font_size', '.grupo-pop > div > form > .fields > div > span, .grupo-pop > div > form > div > div > input, .grupo-pop > div > form > div > div > select, .grupo-pop > div > form > div > div > textarea', 'all', 'font-size', '15', '', '0'),
(190, 'form_popup_submit_btn_bg', '.grupo-pop > div > form > input[type=\"submit\"]', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(191, 'form_popup_submit_btn_text_color', '.grupo-pop > div > form > input[type=\"submit\"]', 'all', 'color', '#FFFFFF', '', '0'),
(192, 'form_popup_submit_btn_font_size', '.grupo-pop > div > form > input[type=\"submit\"]', 'all', 'font-size', '14', '', '0'),
(193, 'form_popup_cancel_btn_font_size', '.grupo-pop > div > form > span.cancel', 'all', 'font-size', '13', '', '0'),
(194, 'form_popup_cancel_btn_text_color', '.grupo-pop > div > form > span.cancel', 'all', 'color', '#C7C7C7', '', '0'),
(195, 'profile_name_text_color', '.swr-grupo .aside > .content .profile > .top > span.name', 'all', 'color', '#FFFFFF', '', '0'),
(196, 'profile_username_text_color', '.swr-grupo .aside > .content .profile > .top > span.role', 'all', 'color', '#FFFFFF', '', '0'),
(197, 'profile_username_font_size', '.swr-grupo .aside > .content .profile > .top > span.role', 'all', 'font-size', '14', '', '0'),
(198, 'profile_name_font_size', '.swr-grupo .aside > .content .profile > .top > span.name', 'all', 'font-size', '15', '', '0'),
(199, 'profile_btn_bg', '.swr-grupo .aside > .content .profile > .middle > span.pm', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(200, 'profile_btn_text_color', '.swr-grupo .aside > .content .profile > .middle > span.pm', 'all', 'color', '#E91E63', '', 'easyedit'),
(201, 'profile_btn_font_size', '.swr-grupo .aside > .content .profile > .middle > span.pm', 'all', 'font-size', '14', '', '0'),
(202, 'profile_editbtn_font_size', '.swr-grupo .aside > .content .profile > .top > span.edit > i', 'all', 'font-size', '13', '', '0'),
(203, 'profile_editbtn_text_color', '.swr-grupo .aside > .content .profile > .top > span.edit > i', 'all', 'color', '#FFC107', '', '0'),
(204, 'profile_statistics_bg', '.swr-grupo .aside > .content .profile > .middle', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(205, 'profile_statistics_result_text_color', '.swr-grupo .aside > .content .profile > .middle > span.stats > span', 'all', 'color', '#727273', '', '0'),
(206, 'profile_statistics_result_font_size', '.swr-grupo .aside > .content .profile > .middle > span.stats > span', 'all', 'font-size', '19', '', '0'),
(207, 'profile_statistics_title_text_color', '.swr-grupo .aside > .content .profile > .middle > span.stats > span > i', 'all', 'color', '#9A9A9A', '', '0'),
(208, 'profile_statistics_title_font_size', '.swr-grupo .aside > .content .profile > .middle > span.stats > span > i', 'all', 'font-size', '12', '', '0'),
(209, 'profile_fields_bg', '.swr-grupo .aside > .content .profile > .bottom', 'all', 'background', '#F7F9FB', '#F7F9FB', '0'),
(210, 'profile_field_name_text_color', '.swr-grupo .aside > .content .profile > .bottom > div > ul > li > b', 'all', 'color', '#212529', '', '0'),
(211, 'profile_field_name_font_size', '.swr-grupo .aside > .content .profile > .bottom > div > ul > li > b', 'all', 'font-size', '14', '', '0'),
(212, 'profile_field_value_text_color', '.swr-grupo .aside > .content .profile > .bottom > div > ul > li > span', 'all', 'color', '#212529', '', '0'),
(213, 'profile_field_value_font_size', '.swr-grupo .aside > .content .profile > .bottom > div > ul > li > span', 'all', 'font-size', '14', '', '0'),
(214, 'loader_color', '.ajx-ripple div', 'all', 'border-color', '#FFFFFF', '', '0'),
(215, 'loader_title_text_color', '.ajxprocess > div >  span', 'all', 'color', '#FFFFFF', '', '0'),
(216, 'loader_sub_text_color', '.ajxprocess > div > span > span', 'all', 'color', '#FFFFFF', '', '0'),
(217, 'loader_bg', '.ajxprocess > div', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(218, 'login_box_bg', '.two > section > div > div > .box', 'all', 'background', '#FFFFFF', '#FFFFFF', '0'),
(219, 'login_box_logo_bg', '.two > section > div > div .logo', 'all', 'background', '#000000', '#000000', '0'),
(220, 'login_box_text_color', '.two > section', 'all', 'color', '#636363', '', '0'),
(221, 'login_box_tab_active', '.two > section > div > div > .box .swithlogin > ul > li.active', 'all', 'color', '#E91E63', '', 'easyedit'),
(222, 'login_box_font_size', '.two > section', 'all', 'font-size', '14', '', '0'),
(223, 'login_box_field_bg', '.two > section > div > div form label', 'all', 'background', '#EEF2F5', '#EEF2F5', '0'),
(224, 'login_box_field_text_color', '.two > section > div > div form label > input,.two > section > div > div form label > i', 'all', 'color', '#636363', '', '0'),
(225, 'login_box_field_font_size', '.two > section > div > div form label > input', 'all', 'font-size', '13', '', '0'),
(226, 'login_box_field_icon_size', '.two > section > div > div form label > i', 'all', 'font-size', '14', '', '0'),
(227, 'login_box_submit_btn_bg', '.two > section > div > div form .submit', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(228, 'login_box_submit_btn_text_color', '.two > section > div > div form .submit', 'all', 'color', '#FFFFFF', '', '0'),
(229, 'login_box_submit_btn_font_size', '.two > section > div > div form .submit', 'all', 'font-size', '14', '', '0'),
(230, 'login_box_footer_bg', '.sign > section > div > div form > .switch', 'all', 'background', '#EEF2F5', '#EEF2F5', '0'),
(231, 'login_box_footer_text_color', '.sign > section > div > div form > .switch > i', 'all', 'color', '#636363', '', '0'),
(232, 'login_box_footer_font_size', '.sign > section > div > div form > .switch > i', 'all', 'font-size', '12', '', '0'),
(233, 'login_box_secondary_btn_bg', '.two > section > div > div form > .switch > span', 'all', 'background', '#000000', '#000000', '0'),
(234, 'login_box_secondary_btn_hover_bg', '.two > section > div > div form > .switch > span:hover', 'all', 'background', '#000000', '#000000', '0'),
(235, 'login_box_secondary_btn_hover_text_color', '.two > section > div > div form > .switch > span:hover', 'all', 'color', '#FFFFFF', '', '0'),
(236, 'login_box_secondary_btn_text_color', '.two > section > div > div form > .switch > span', 'all', 'color', '#FFFFFF', '', '0'),
(237, 'login_box_secondary_btn_font_size', '.two > section > div > div form > .switch > span', 'all', 'font-size', '12', '', '0'),
(238, 'cookie_constent_bg', '.gr-consent', 'all', 'background', '#1C2123', '#1C2123', '0'),
(239, 'cookie_constent_text_color', '.gr-consent', 'all', 'color', '#FFFFFF', '', '0'),
(240, 'site_tos_btn_text_color', '.gr-consent > span > span >i', 'all', 'color', '#FFC107', '', '0'),
(241, 'site_tos_heading_text_color', '.sign > section > div > div .tos > h4 > span', 'all', 'color', '#FFC107', '', '0'),
(242, 'site_tos_close_btn_color', '.sign > section > div > div .tos > h4 > i', 'all', 'color', '#636363', '', '0'),
(243, 'cookie_constent_btn_bg', '.gr-consent > span > i', 'all', 'background', '#F44336', '#E91E63', '0'),
(244, 'cookie_constent_btn_text_color', '.gr-consent > span > i', 'all', 'color', '#FFFFFF', '', '0'),
(245, 'coverpic_bg', '.swr-grupo .aside > .content .profile > .top', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(246, 'reload_button_bg', '.swr-grupo .panel > .room > .groupreload > i', 'all', 'background', '#000', '#000', '0'),
(247, 'reload_button_font_size', '.swr-grupo .panel > .room > .groupreload > i', 'all', 'font-size', '13', '', '0'),
(248, 'reload_button_text_color', '.swr-grupo .panel > .room > .groupreload > i', 'all', 'color', '#fff', '', '0'),
(249, 'uploading_icon_bg', '.gruploader', 'all', 'background', '#E91E63', '#9C27B0', 'easyedit'),
(250, 'uploading_icon_color', '.gruploader', 'all', 'color', '#fff', '', '0'),
(251, 'uploading_icon_size', '.gruploader', 'all', 'font-size', '11', '', '0'),
(252, 'message_unread_icon_color', '.swr-grupo .panel > .room > .msgs > li.right > div > .msg > i > .info > i.tick', 'all', 'color', '#fff', '', '0'),
(253, 'message_read_icon_color', '.swr-grupo .panel > .room > .msgs > li.right > div > .msg > i > .info > i.tick.read > i', 'all', 'color', '#FFEB3B', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gr_defaults`
--

CREATE TABLE `gr_defaults` (
  `id` bigint(20) NOT NULL,
  `type` varchar(15) DEFAULT NULL,
  `v1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `v2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `v4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_defaults`
--

INSERT INTO `gr_defaults` (`id`, `type`, `v1`, `v2`, `v3`, `v4`, `v5`, `v6`, `v7`, `tms`) VALUES
(1, 'default', 'sitename', 'Site Name', '0', '0', '0', '', '', NULL),
(2, 'default', 'sitedesc', 'Easily create your own chat room without any knowledge of coding. Grupo is a use-friendly &amp;amp; easy to install-able AJAX &amp;amp; JSON based PHP chatroom script with more than 50 Features. ', '0', '0', '0', '', '', NULL),
(3, 'default', 'siteslogan', 'PHP Chatting script - Grupo Powered', '0', '0', '0', '', '', NULL),
(4, 'default', 'sysemail', 'grupo@baevox.com', '0', '0', '0', '', '', NULL),
(5, 'default', 'sendername', 'Site Name', '0', '0', '0', '', '', NULL),
(6, 'default', 'userreg', 'enable', '0', '0', '0', '', '', NULL),
(7, 'default', 'timezone', 'Auto', '0', '0', '0', '', '', '2019-04-06 18:10:19'),
(8, 'default', 'recaptcha', 'disable', '0', '0', '0', '', '', NULL),
(9, 'default', 'rsecretkey', '', '0', '0', '0', '', '', NULL),
(10, 'default', 'rsitekey', '', '0', '0', '0', '', '', NULL),
(11, 'default', 'language', '1', '0', '0', '0', '', '', NULL),
(12, 'default', 'delmsgexpiry', 'Off', '0', '0', '0', '', '', NULL),
(13, 'default', 'autogroupjoin', '', '0', '0', '0', '', '', NULL),
(14, 'default', 'fileexpiry', 'Off', '0', '0', '0', '', '', NULL),
(15, 'default', 'boxed', 'enable', '0', '0', '0', '', '', NULL),
(16, 'blacklist', 'ip', '51.89.23.57\r\n183.80.183.88\r\n223.241.166.96\r\n51.79.62.116\r\n35.172.136.41\r\n137.169.63.241\r\n18.207.142.233\r\n3.227.233.55\r\n36.69.93.218\r\n125.118.73.41\r\n185.102.139.15\r\n216.244.66.250\r\n196.196.193.196\r\n195.154.123.46\r\n196.240.54.38\r\n35.171.146.16\r\n116.7.162.205\r\n54.36.148.250\r\n195.154.122.95\r\n61.154.64.45\r\n54.227.117.173\r\n39.88.21.134\r\n61.154.197.55\r\n2.176.205.209\r\n46.183.221.15\r\n82.102.21.52\r\n113.123.0.47\r\n27.31.102.142\r\n171.80.187.37\r\n58.54.221.49\r\n117.78.58.30\r\n185.106.94.133\r\n27.31.102.152\r\n117.78.58.25\r\n3.93.169.195\r\n117.78.58.24\r\n117.78.58.18\r\n114.95.205.13\r\n117.78.58.16\r\n119.62.208.204\r\n192.69.90.178\r\n117.78.58.17\r\n2.191.43.217\r\n103.115.41.90\r\n117.78.58.22\r\n117.78.58.28\r\n195.154.123.18\r\n117.78.58.27\r\n117.78.58.19\r\n117.78.58.14\r\n185.112.81.55\r\n100.25.38.220\r\n216.170.126.176\r\n195.154.104.5\r\n163.172.71.139\r\n195.154.104.4\r\n185.102.137.85\r\n111.202.100.123\r\n216.186.243.70\r\n212.115.122.89\r\n52.23.204.195\r\n84.75.207.109\r\n68.139.206.214\r\n163.172.71.6\r\n185.112.100.33\r\n52.90.162.255\r\n213.202.253.46\r\n163.172.71.84\r\n13.59.168.16\r\n195.154.104.170\r\n85.208.96.65\r\n144.168.163.119\r\n218.69.225.124\r\n34.76.178.121\r\n35.189.255.190\r\n54.209.162.70\r\n111.177.117.36\r\n185.112.81.140\r\n27.157.90.195\r\n34.234.54.252\r\n221.193.124.122\r\n46.183.222.15\r\n83.110.248.130\r\n2.61.214.145\r\n54.166.130.16\r\n185.106.94.128\r\n91.242.162.7\r\n36.90.89.64\r\n200.159.250.2\r\n61.132.225.40\r\n18.205.109.82\r\n34.226.234.20\r\n207.180.226.173\r\n91.242.162.10\r\n149.202.211.239\r\n54.36.150.108\r\n41.87.207.142\r\n123.14.219.83\r\n213.74.79.34\r\n166.62.84.121\r\n89.163.242.239\r\n77.168.164.74\r\n83.178.235.206\r\n35.172.100.232\r\n51.77.70.4\r\n129.56.117.163\r\n81.92.203.62\r\n3.93.75.30\r\n104.248.247.150\r\n195.154.123.57\r\n104.248.243.235\r\n185.167.160.83\r\n34.80.141.133\r\n162.216.115.103\r\n85.208.96.66\r\n123.14.63.250\r\n134.19.176.22\r\n185.248.12.162\r\n109.245.36.65\r\n91.79.52.84\r\n100.26.182.28\r\n216.244.66.195\r\n67.220.186.137\r\n91.242.162.57\r\n46.217.82.6\r\n3.86.206.185\r\n165.16.181.172\r\n5.62.34.46\r\n18.204.2.53\r\n192.3.136.27\r\n37.49.231.118\r\n3.226.243.130\r\n3.227.254.12\r\n193.124.191.215\r\n92.99.144.189\r\n54.36.148.217\r\n45.61.48.64\r\n34.204.176.189\r\n185.117.118.252\r\n182.110.22.115\r\n102.68.77.254\r\n218.70.200.139\r\n141.8.189.76\r\n62.210.80.82\r\n92.53.33.154\r\n91.242.162.22\r\n27.187.58.159\r\n34.237.76.91\r\n163.172.30.236\r\n79.143.28.100\r\n192.243.53.51\r\n106.38.241.116\r\n36.90.89.53\r\n190.152.180.58\r\n18.206.48.142\r\n103.45.100.168\r\n61.230.210.31\r\n117.78.58.23\r\n66.160.140.184\r\n182.253.245.114\r\n37.148.46.175\r\n185.24.233.187\r\n131.203.43.48\r\n23.18.139.79\r\n36.222.72.101\r\n112.25.188.171\r\n2.61.231.144\r\n85.208.96.68\r\n117.78.58.20\r\n160.120.4.171\r\n117.78.58.15\r\n111.206.221.86\r\n109.102.111.58\r\n111.226.236.217\r\n46.240.189.44\r\n37.140.159.2\r\n46.4.105.251\r\n69.167.38.186\r\n85.208.96.67\r\n207.241.226.107\r\n47.92.84.119\r\n111.172.66.52\r\n217.170.202.237\r\n122.11.135.159\r\n123.136.135.98\r\n218.77.57.10\r\n18.206.16.123\r\n173.63.217.134\r\n92.255.195.226\r\n3.87.134.248\r\n45.123.43.30\r\n89.163.146.110\r\n185.36.81.39\r\n196.50.5.97\r\n3.91.51.153\r\n60.184.109.226\r\n103.219.207.39\r\n104.131.75.86\r\n195.91.155.132\r\n69.30.226.234\r\n169.159.119.98\r\n45.137.17.167\r\n196.70.251.73\r\n199.96.83.9\r\n80.77.42.209\r\n145.239.2.240\r\n54.165.90.203\r\n197.210.44.208\r\n89.163.146.71\r\n194.110.84.100\r\n84.38.129.31\r\n129.56.78.30\r\n5.9.6.51\r\n17.122.128.175\r\n2.61.193.59\r\n125.121.51.147\r\n52.9.20.166\r\n125.121.49.168\r\n103.137.12.206\r\n203.186.170.66\r\n5.188.84.184\r\n36.27.111.3\r\n41.217.86.96\r\n218.70.201.123\r\n121.239.108.165\r\n183.25.179.204\r\n39.53.130.136\r\n103.195.238.158\r\n51.255.134.131\r\n185.248.13.186\r\n59.55.202.68\r\n73.171.83.254\r\n105.208.57.92\r\n109.252.20.243\r\n36.90.88.149\r\n78.46.174.55\r\n34.227.91.38\r\n95.168.191.169\r\n109.93.249.91\r\n60.176.78.81\r\n195.154.122.66\r\n178.149.88.114\r\n93.158.166.139\r\n167.86.73.202\r\n119.62.205.177\r\n66.160.140.183\r\n86.52.207.82\r\n106.120.173.156\r\n54.191.53.48\r\n39.188.104.180\r\n172.245.13.162\r\n69.77.176.154\r\n46.229.168.142\r\n195.154.123.127\r\n195.154.123.87\r\n94.130.10.89\r\n17.58.101.49\r\n223.80.227.88\r\n123.21.196.161\r\n59.55.241.38\r\n2.61.170.40\r\n37.140.159.0\r\n54.36.149.82\r\n199.168.140.151\r\n54.36.150.16\r\n54.36.150.93\r\n85.208.96.69\r\n188.68.226.106\r\n54.36.150.175\r\n185.5.251.207\r\n54.36.150.56\r\n54.36.150.2\r\n54.90.161.92\r\n54.36.150.65\r\n54.36.150.12\r\n54.36.148.68\r\n54.36.148.56\r\n54.36.150.183\r\n54.36.148.166\r\n188.68.226.102\r\n54.36.150.81\r\n54.36.149.29\r\n54.36.148.191\r\n54.36.150.22\r\n5.2.183.39\r\n54.36.150.50\r\n117.239.48.242\r\n116.206.137.146\r\n23.228.90.13\r\n54.36.150.97\r\n54.36.150.1\r\n81.166.130.184\r\n54.36.150.86\r\n54.36.150.156\r\n54.36.148.245\r\n106.9.137.118\r\n54.36.150.83\r\n54.36.148.33\r\n54.36.148.10\r\n35.239.58.193\r\n54.36.150.141\r\n54.36.150.188\r\n54.36.148.49\r\n54.36.148.147\r\n188.68.226.103\r\n54.36.149.30\r\n54.36.148.237\r\n185.38.251.59\r\n54.36.150.88\r\n182.253.14.20\r\n54.36.150.167\r\n54.36.150.101\r\n54.36.149.90\r\n54.36.148.96\r\n113.102.166.15\r\n5.188.84.138\r\n54.36.150.116\r\n54.36.149.65\r\n54.36.148.118\r\n123.126.113.125\r\n198.204.229.90\r\n45.76.20.179\r\n54.36.149.70\r\n54.36.150.47\r\n54.36.149.80\r\n54.36.148.111\r\n41.82.92.83\r\n54.36.150.51\r\n54.36.148.132\r\n46.4.100.132\r\n195.88.253.235\r\n54.36.149.5\r\n54.36.150.132\r\n129.18.156.246\r\n109.238.247.83\r\n54.36.150.62\r\n54.36.148.34\r\n54.36.150.29\r\n54.36.150.128\r\n54.36.150.136\r\n54.36.148.198\r\n218.70.200.192\r\n46.229.168.154\r\n23.226.130.76\r\n54.36.148.194\r\n183.156.22.199\r\n54.36.150.55\r\n85.208.96.4\r\n54.36.148.221\r\n54.36.149.63\r\n59.41.24.26\r\n111.224.13.119\r\n54.36.148.173\r\n54.36.150.130\r\n195.154.61.130\r\n205.134.171.79\r\n54.36.150.184\r\n188.68.226.105\r\n54.36.149.1\r\n54.36.148.226\r\n54.36.150.171\r\n170.130.205.87\r\n82.57.55.118\r\n54.36.149.42\r\n54.36.150.11\r\n188.68.226.108\r\n103.88.233.5\r\n54.36.150.76\r\n188.68.226.107\r\n121.40.224.143\r\n54.36.148.18\r\n114.103.64.50\r\n47.111.102.108\r\n112.73.24.219\r\n121.40.130.229\r\n103.133.104.170\r\n54.36.148.70\r\n121.40.225.125\r\n54.36.148.180\r\n54.36.150.75\r\n194.99.105.243\r\n47.111.65.9\r\n121.40.210.30\r\n54.36.150.160\r\n207.148.102.16\r\n188.68.226.101\r\n54.36.149.72\r\n54.36.150.15\r\n54.36.148.121\r\n23.254.202.98\r\n54.36.148.137\r\n54.36.150.102\r\n107.6.156.2\r\n47.111.136.117\r\n94.25.168.181\r\n54.36.148.46\r\n176.9.4.111\r\n62.210.111.58\r\n121.40.207.234\r\n3.230.119.16\r\n54.36.150.71\r\n121.40.244.177\r\n54.38.19.73\r\n190.156.243.166\r\n37.140.159.1\r\n157.55.201.215\r\n75.162.79.99\r\n54.36.150.161\r\n195.154.122.234\r\n124.41.228.15\r\n105.159.249.101\r\n46.229.168.132\r\n188.68.226.100\r\n54.36.150.91\r\n192.243.56.76\r\n103.212.33.223\r\n54.36.149.57\r\n121.40.103.29\r\n121.40.76.239\r\n54.36.150.143\r\n17.58.97.31\r\n103.7.79.79\r\n54.36.148.107\r\n54.36.150.23\r\n54.36.148.254\r\n118.71.107.73\r\n141.8.188.178\r\n47.111.111.174\r\n54.36.150.98\r\n105.112.32.58\r\n54.36.148.64\r\n192.3.8.36\r\n54.36.150.121\r\n93.180.64.137\r\n198.50.183.1\r\n54.36.148.105\r\n47.92.222.191\r\n203.133.169.184\r\n184.75.211.107\r\n47.111.156.198\r\n159.69.189.218\r\n46.229.168.139\r\n52.4.105.228\r\n46.229.168.161\r\n121.40.249.129\r\n46.229.168.137\r\n182.74.103.193\r\n81.106.8.37\r\n216.244.66.203\r\n46.229.161.131\r\n54.36.148.190\r\n95.216.172.180\r\n46.229.168.162\r\n178.159.37.125\r\n54.36.148.43\r\n46.229.168.129\r\n173.44.40.49\r\n54.36.150.35\r\n202.49.183.168\r\n121.40.129.130\r\n46.229.168.141\r\n121.40.142.193\r\n46.229.168.153\r\n116.31.102.8\r\n54.36.150.39\r\n39.100.157.106\r\n159.65.137.115\r\n164.68.96.84\r\n210.2.157.130\r\n88.248.23.216\r\n27.189.34.35\r\n46.229.168.140\r\n203.133.169.241\r\n141.8.188.201\r\n141.8.188.145\r\n54.36.149.37\r\n178.159.37.55\r\n141.8.143.170\r\n54.36.150.43\r\n141.8.188.196\r\n46.229.168.147\r\n54.36.148.171\r\n141.8.188.143\r\n121.40.101.160\r\n54.36.148.126\r\n85.208.96.7\r\n121.40.246.140\r\n54.36.150.61\r\n121.40.238.244\r\n46.4.60.249\r\n195.154.123.53\r\n93.158.166.10\r\n121.40.219.58\r\n42.113.50.23\r\n13.57.217.89\r\n46.229.168.136\r\n54.36.150.145\r\n54.36.150.90\r\n14.226.203.62\r\n121.40.113.77\r\n47.111.125.140\r\n212.7.208.140\r\n54.36.148.51\r\n46.229.168.149\r\n103.63.158.254\r\n121.40.228.36\r\n64.44.131.61\r\n93.158.166.146\r\n121.40.164.34\r\n46.229.168.163\r\n95.236.18.183\r\n112.34.110.149\r\n142.252.249.91\r\n121.40.225.4\r\n83.221.88.181\r\n213.174.147.83\r\n45.89.197.195\r\n23.100.232.233\r\n121.40.153.27\r\n223.241.79.240\r\n188.165.200.217\r\n41.103.204.206\r\n102.165.33.20\r\n46.229.168.143\r\n52.162.161.148\r\n107.173.222.196\r\n18.208.178.230\r\n46.140.101.194\r\n3.212.81.28\r\n62.210.80.58\r\n122.224.204.36\r\n216.244.66.228\r\n46.229.168.131\r\n46.229.168.146\r\n46.229.168.135\r\n111.206.198.44\r\n39.100.158.151\r\n46.229.168.130\r\n2.61.172.111\r\n110.86.19.26\r\n39.98.128.208\r\n39.98.129.207\r\n46.229.168.145\r\n39.100.147.54\r\n47.92.214.153\r\n46.229.168.152\r\n218.70.204.84\r\n85.208.96.1\r\n206.189.56.14\r\n46.229.168.138\r\n46.229.168.133\r\n13.66.139.0\r\n18.222.24.144\r\n84.25.85.171\r\n112.34.110.156\r\n46.229.168.151\r\n62.210.80.98\r\n113.66.252.206\r\n192.69.95.250\r\n121.40.144.114\r\n66.206.0.173\r\n173.249.18.133\r\n90.188.236.43\r\n62.210.80.25\r\n188.68.226.104\r\n60.169.115.55\r\n46.229.168.150\r\n121.40.111.18\r\n121.40.189.110\r\n121.40.118.135\r\n45.123.41.94\r\n195.206.104.237\r\n121.40.219.187\r\n206.81.31.194\r\n121.40.110.89\r\n47.111.133.130\r\n47.111.127.121\r\n111.206.221.29\r\n162.221.200.177\r\n93.182.109.32\r\n185.160.100.26\r\n112.34.110.29\r\n121.40.114.207\r\n112.34.110.28\r\n47.111.64.179\r\n188.2.211.28\r\n121.40.150.14\r\n46.229.168.144\r\n164.68.123.23\r\n157.55.199.147\r\n121.40.192.236\r\n46.229.168.134\r\n46.229.168.148\r\n47.111.89.120\r\n121.40.175.46\r\n47.99.196.186\r\n151.80.200.152\r\n193.56.28.150\r\n45.141.71.22\r\n2.61.224.130\r\n121.40.248.200\r\n121.40.106.86\r\n210.56.127.217\r\n190.90.140.55\r\n85.208.96.71\r\n1.179.180.98\r\n75.159.84.200\r\n94.21.118.140\r\n27.255.193.172\r\n2001:1c06:8c2:e300:6c36:11af:25e:a81f\r\n2001:1c06:8c2:e300:e5f2:b2b5:1c17:7afd\r\n2001:1c06:8c2:e300:f55f:559f:2f34:f2d0\r\n2401:4900:16bc:6f12:e4c5:b2dc:39eb:f244\r\n2001:e68:5422:28a1:a433:b10:645d:b9a1\r\n2607:fea8:91c0:40a:548:ae6b:ff7f:18f3\r\n2001:1c06:8c2:e300:e912:206b:b0d7:e7b4\r\n2001:e68:5422:28a1:2936:b9e4:7ca0:89e\r\n2001:e68:5420:2a0c:e08a:d855:1cef:92a5', '0', '0', '0', '', '', NULL),
(17, 'filterwords', 'words', 'ahole\r\nanus\r\nfuckoff\r\nash0le\r\nash0les\r\nasholes\r\nass\r\nAss Monkey\r\nAssface\r\nassface\r\nassh0le\r\nassh0lez\r\nasshole\r\nassholes\r\nassholz\r\nasswipe\r\nazzhole\r\nbassterds\r\nbastard\r\nbastards\r\nbastardz\r\nbasterds\r\nbasterdz\r\nBiatch\r\nbitch\r\nbitches\r\nBlow Job\r\nboffing\r\nbutthole\r\nbuttwipe\r\nc0ck\r\nc0cks\r\nc0k\r\nCarpet Muncher\r\ncawk\r\ncawks\r\nClit\r\ncnts\r\ncntz\r\ncock\r\ncockhead\r\ncock-head\r\ncocks\r\nCockSucker\r\ncock-sucker\r\ncrap\r\ncum\r\ncunt\r\ncunts\r\ncuntz\r\ndick\r\ndild0\r\ndild0s\r\ndildo\r\ndildos\r\ndilld0\r\ndilld0s\r\ndominatricks\r\ndominatrics\r\ndominatrix\r\ndyke\r\nenema\r\nf u c k\r\nf u c k e r\r\nfag\r\nfag1t\r\nfaget\r\nfagg1t\r\nfaggit\r\nfaggot\r\nfagg0t\r\nfagit\r\nfags\r\nfagz\r\nfaig\r\nfaigs\r\nfart\r\nflipping the bird\r\nfuck\r\nfucker\r\nfuckin\r\nfucking\r\nfucks\r\nFudge Packer\r\nfuk\r\nFukah\r\nFuken\r\nfuker\r\nFukin\r\nFukk\r\nFukkah\r\nFukken\r\nFukker\r\nFukkin\r\ng00k\r\nGod-damned\r\nh00r\r\nh0ar\r\nh0re\r\nhells\r\nhoar\r\nhoor\r\nhoore\r\njackoff\r\njap\r\njaps\r\njerk-off\r\njisim\r\njiss\r\njizm\r\njizz\r\nknob\r\nknobs\r\nknobz\r\nkunt\r\nkunts\r\nkuntz\r\nLezzian\r\nLipshits\r\nLipshitz\r\nmasochist\r\nmasokist\r\nmassterbait\r\nmasstrbait\r\nmasstrbate\r\nmasterbaiter\r\nmasterbate\r\nmasterbates\r\nMotha Fucker\r\nMotha Fuker\r\nMotha Fukkah\r\nMotha Fukker\r\nMother Fucker\r\nMother Fukah\r\nMother Fuker\r\nMother Fukkah\r\nMother Fukker\r\nmother-fucker\r\nMutha Fucker\r\nMutha Fukah\r\nMutha Fuker\r\nMutha Fukkah\r\nMutha Fukker\r\nn1gr\r\nnastt\r\nnigger;\r\nnigur;\r\nniiger;\r\nniigr;\r\norafis\r\norgasim;\r\norgasm\r\norgasum\r\noriface\r\norifice\r\norifiss\r\npacki\r\npackie\r\npacky\r\npaki\r\npakie\r\npaky\r\npecker\r\npeeenus\r\npeeenusss\r\npeenus\r\npeinus\r\npen1s\r\npenas\r\npenis\r\npenis-breath\r\npenus\r\npenuus\r\nPhuc\r\nPhuck\r\nPhuk\r\nPhuker\r\nPhukker\r\npolac\r\npolack\r\npolak\r\nPoonani\r\npr1c\r\npr1ck\r\npr1k\r\npusse\r\npussee\r\npussy\r\npuuke\r\npuuker\r\nqueer\r\nqueers\r\nqueerz\r\nqweers\r\nqweerz\r\nqweir\r\nrecktum\r\nrectum\r\nretard\r\nsadist\r\nscank\r\nschlong\r\nscrewing\r\nsemen\r\nsex\r\nsexy\r\nSh!t\r\nsh1t\r\nsh1ter\r\nsh1ts\r\nsh1tter\r\nsh1tz\r\nshit\r\nshits\r\nshitter\r\nShitty\r\nShity\r\nshitz\r\nShyt\r\nShyte\r\nShytty\r\nShyty\r\nskanck\r\nskank\r\nskankee\r\nskankey\r\nskanks\r\nSkanky\r\nslag\r\nslut\r\nsluts\r\nSlutty\r\nslutz\r\nson-of-a-bitch\r\ntit\r\nturd\r\nva1jina\r\nvag1na\r\nvagiina\r\nvagina\r\nvaj1na\r\nvajina\r\nvullva\r\nvulva\r\nw0p\r\nwh00r\r\nwh0re\r\nwhore\r\nxrated\r\nxxx\r\nb!+ch\r\nbitch\r\nblowjob\r\nclit\r\narschloch\r\nfuck\r\nshit\r\nass\r\nasshole\r\nb!tch\r\nb17ch\r\nb1tch\r\nbastard\r\nbi+ch\r\nboiolas\r\nbuceta\r\nc0ck\r\ncawk\r\nchink\r\ncipa\r\nclits\r\ncock\r\ncum\r\ncunt\r\ndildo\r\ndirsa\r\nejakulate\r\nfatass\r\nfcuk\r\nfuk\r\nfux0r\r\nhoer\r\nhore\r\njism\r\nkawk\r\nl3itch\r\nl3i+ch\r\nlesbian\r\nmasturbate\r\nmasterbat*\r\nmasterbat3\r\nmotherfucker\r\ns.o.b.\r\nmofo\r\nnazi\r\nnigga\r\nnigger\r\nnutsack\r\nphuck\r\npimpis\r\npusse\r\npussy\r\nscrotum\r\nsh!t\r\nshemale\r\nshi+\r\nsh!+\r\nslut\r\nsmut\r\nteets\r\ntits\r\nboobs\r\nb00bs\r\nteez\r\ntestical\r\ntesticle\r\ntitt\r\nw00se\r\njackoff\r\nwank\r\nwhoar\r\nwhore\r\n*damn\r\n*dyke\r\n*fuck*\r\n*shit*\r\n@$$\r\namcik\r\nandskota\r\narse*\r\nassrammer\r\nayir\r\nbi7ch\r\nbitch*\r\nbollock*\r\nbreasts\r\nbutt-pirate\r\ncabron\r\ncazzo\r\nchraa\r\nchuj\r\nCock*\r\ncunt*\r\nd4mn\r\ndaygo\r\ndego\r\ndick*\r\ndike*\r\ndupa\r\ndziwka\r\nejackulate\r\nEkrem*\r\nEkto\r\nenculer\r\nfaen\r\nfag*\r\nfanculo\r\nfanny\r\nfeces\r\nfeg\r\nFelcher\r\nficken\r\nfitt*\r\nFlikker\r\nforeskin\r\nFotze\r\nFu(*\r\nfuk*\r\nfutkretzn\r\ngook\r\nguiena\r\nh0r\r\nh4x0r\r\nhell\r\nhelvete\r\nhoer*\r\nhonkey\r\nHuevon\r\nhui\r\ninjun\r\njizz\r\nkanker*\r\nkike\r\nklootzak\r\nkraut\r\nknulle\r\nkuk\r\nkuksuger\r\nKurac\r\nkurwa\r\nkusi*\r\nkyrpa*\r\nlesbo\r\nmamhoon\r\nmasturbat*\r\nmerd*\r\nmibun\r\nmonkleigh\r\nmouliewop\r\nmuie\r\nmulkku\r\nmuschi\r\nnazis\r\nnepesaurio\r\nnigger*\r\norospu\r\npaska*\r\nperse\r\npicka\r\npierdol*\r\npillu*\r\npimmel\r\npiss*\r\npizda\r\npoontsee\r\npoop\r\nporn\r\np0rn\r\npr0n\r\npreteen\r\npula\r\npule\r\nputa\r\nputo\r\nqahbeh\r\nqueef*\r\nrautenberg\r\nschaffer\r\nscheiss*\r\nschlampe\r\nschmuck\r\nscrew\r\nsh!t*\r\nsharmuta\r\nsharmute\r\nshipal\r\nshiz\r\nskribz\r\nskurwysyn\r\nsphencter\r\nspic\r\nspierdalaj\r\nsplooge\r\nsuka\r\nb00b*\r\ntesticle*\r\ntitt*\r\ntwat\r\nvittu\r\nwank*\r\nwetback*\r\nwichser\r\nwop*\r\nyed\r\nzabourah', '0', '0', '0', '', '', NULL),
(18, 'default', 'guest_login', 'enable', '0', '0', '0', '', '', NULL),
(19, 'default', 'autodeletemsg', 'Off', '0', '0', '0', '', '', NULL),
(20, 'default', 'email_verification', 'disable', '0', '0', '0', '', '', NULL),
(21, 'default', 'smtp_authentication', 'disable', '0', '0', '0', '', '', NULL),
(22, 'default', 'smtp_host', '', '0', '0', '0', '', '', NULL),
(23, 'default', 'smtp_user', NULL, '0', '0', '0', '', '', NULL),
(24, 'default', 'smtp_pass', NULL, '0', '0', '0', '', '', NULL),
(25, 'default', 'smtp_protocol', NULL, '0', '0', '0', '', '', NULL),
(26, 'default', 'smtp_port', NULL, '0', '0', '0', '', '', NULL),
(27, 'default', 'alert', 'gem/ore/grupo/alerts/alert003.mp3', '0', '0', '0', '', '', NULL),
(28, 'default', 'maxmsgsperload', '20', '0', '0', '0', '', '', NULL),
(29, 'default', 'refreshrate', '3000', '0', '0', '0', '', '', NULL),
(30, 'default', 'max_login_attempts', '6', '0', '0', '0', '', '', NULL),
(31, 'default', 'google_analytics_id', '', '0', '0', '0', '', '', NULL),
(32, 'default', 'time_format', '24', '0', '0', '0', '0', '0', NULL),
(33, 'default', 'default_font', 'montserrat', '0', '0', '0', '0', '0', NULL),
(34, 'default', 'tenor_enable', 'enable', '0', '0', '0', '0', '0', NULL),
(35, 'default', 'tenor_api', '', '0', '0', '0', '0', '0', NULL),
(36, 'default', 'tenor_limit', '12', '0', '0', '0', '0', '0', NULL),
(37, 'default', 'aside_results_perload', '12', '0', '0', '0', '0', '0', NULL),
(38, 'default', 'min_msg_length', '1', '0', '0', '0', '0', '0', NULL),
(39, 'default', 'max_msg_length', 'Off', '0', '0', '0', '0', '0', NULL),
(40, 'default', 'add_readmore_after', '300', '0', '0', '0', '0', '0', NULL),
(41, 'default', 'sent_msg_align', 'right', '0', '0', '0', '0', '0', NULL),
(42, 'default', 'received_msg_align', 'left', '0', '0', '0', '0', '0', NULL),
(43, 'default', 'pagespeed_api', '', '0', '0', '0', '0', '0', NULL),
(44, 'default', 'unsplash_enable', 'disable', '0', '0', '0', '0', '0', NULL),
(45, 'default', 'unsplash_load', '', '0', '0', '0', '0', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gr_logs`
--

CREATE TABLE `gr_logs` (
  `id` bigint(20) NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v1` bigint(20) DEFAULT NULL,
  `v2` bigint(20) DEFAULT NULL,
  `v3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xtra` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_logs`
--

INSERT INTO `gr_logs` (`id`, `type`, `v1`, `v2`, `v3`, `xtra`, `tms`) VALUES
(1, 'cache', 1584060847, 0, NULL, 'reset', '2020-03-13 00:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `gr_mails`
--

CREATE TABLE `gr_mails` (
  `id` bigint(20) NOT NULL,
  `uid` text DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `valz` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `sent` int(10) NOT NULL DEFAULT 0,
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gr_msgs`
--

CREATE TABLE `gr_msgs` (
  `id` bigint(20) NOT NULL,
  `gid` varchar(255) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'msg',
  `rtxt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rid` bigint(20) DEFAULT NULL,
  `rmid` bigint(20) DEFAULT NULL,
  `rtype` varchar(10) NOT NULL DEFAULT 'msg',
  `cat` varchar(10) NOT NULL DEFAULT 'group',
  `xtra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gr_options`
--

CREATE TABLE `gr_options` (
  `id` bigint(20) NOT NULL,
  `type` varchar(15) DEFAULT NULL,
  `v1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `v2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `v4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `v7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_options`
--

INSERT INTO `gr_options` (`id`, `type`, `v1`, `v2`, `v3`, `v4`, `v5`, `v6`, `v7`, `tms`) VALUES
(1, 'profile', 'name', 'Site Admin', '1', 'admin', '#FF0055', '', '', '0000-00-00 00:00:00'),
(2, 'profile', 'name', 'BaeVox', '2', 'baevox', '#1EB557', '0', '0', '2020-03-03 16:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `gr_permissions`
--

CREATE TABLE `gr_permissions` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groups` varchar(50) DEFAULT NULL,
  `features` varchar(100) DEFAULT NULL,
  `files` varchar(50) DEFAULT NULL,
  `users` varchar(50) DEFAULT NULL,
  `languages` varchar(50) DEFAULT NULL,
  `sys` varchar(50) DEFAULT NULL,
  `roles` varchar(50) DEFAULT NULL,
  `fields` varchar(50) DEFAULT NULL,
  `privatemsg` varchar(50) DEFAULT NULL,
  `autodel` varchar(100) NOT NULL DEFAULT 'off',
  `autounjoin` varchar(100) NOT NULL DEFAULT 'off'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_permissions`
--

INSERT INTO `gr_permissions` (`id`, `name`, `groups`, `features`, `files`, `users`, `languages`, `sys`, `roles`, `fields`, `privatemsg`, `autodel`, `autounjoin`) VALUES
(1, 'Unverified', '', '', '', '', '', '', '', '', '', 'Off', 'Off'),
(2, 'Adminstrator', '1,2,3,4,5,12,6,11,8,9,10,7', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5', '1,2,3,4,7,5,6,8', '1,2,3,4', '1,2,3,4,5', '1,2,3', '1,2,3,4', '1,2,3', 'Off', 'Off'),
(3, 'Verified', '1,2,3,4,5,6,8,9,10', '1,2,3,4,5,6,7,8,9', '1,2,3,4,5', '7,5', '', '', '', '', '1,2,3', 'Off', 'Off'),
(4, 'Banned', '', '', '', '', '', '', '', '', '', 'Off', 'Off'),
(5, 'Guest', '4,6,9', '1,3,5', '2', '5', '', '', '', '', '1,2', 'Off', 'Off');

-- --------------------------------------------------------

--
-- Table structure for table `gr_phrases`
--

CREATE TABLE `gr_phrases` (
  `id` bigint(20) NOT NULL,
  `type` varchar(10) DEFAULT 'phrase',
  `short` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_phrases`
--

INSERT INTO `gr_phrases` (`id`, `type`, `short`, `full`, `lid`) VALUES
(1, 'lang', 'English', 'ltr', 0),
(2, 'phrase', 'edit_profile', 'Edit Profile', 1),
(3, 'phrase', 'users', 'Users', 1),
(4, 'phrase', 'roles', 'Roles', 1),
(5, 'phrase', 'languages', 'Languages', 1),
(6, 'phrase', 'appearance', 'Appearance', 1),
(7, 'phrase', 'header_footer', 'Header/Footer', 1),
(8, 'phrase', 'settings', 'Settings', 1),
(9, 'phrase', 'shortcodes', 'Shortcodes', 1),
(10, 'phrase', 'zero_users', 'Users Found', 1),
(11, 'phrase', 'zero_roles', 'Roles Found', 1),
(12, 'phrase', 'zero_languages', 'Languages Found', 1),
(13, 'phrase', 'zero_shortcodes', 'Shortcodes Found', 1),
(14, 'phrase', 'upload_file', 'Upload File', 1),
(15, 'phrase', 'create_group', 'Create Group', 1),
(16, 'phrase', 'create_user', 'Create User', 1),
(17, 'phrase', 'create_role', 'Create Role', 1),
(18, 'phrase', 'add_language', 'Add Language', 1),
(19, 'phrase', 'create', 'Create', 1),
(20, 'phrase', 'edit', 'Edit', 1),
(21, 'phrase', 'update', 'Update', 1),
(22, 'phrase', 'add', 'Add', 1),
(23, 'phrase', 'delete', 'Delete', 1),
(24, 'phrase', 'report', 'Report', 1),
(25, 'phrase', 'reply', 'Reply', 1),
(26, 'phrase', 'login', 'Login', 1),
(27, 'phrase', 'share', 'Share', 1),
(28, 'phrase', 'zip', 'Save', 1),
(29, 'phrase', 'download', 'Download', 1),
(30, 'phrase', 'view', 'View', 1),
(31, 'phrase', 'search_here', 'Search here', 1),
(32, 'phrase', 'zero_groups', 'Groups Found', 1),
(33, 'phrase', 'zero_online', 'No one is online', 1),
(34, 'phrase', 'zero_files', 'Empty File manager', 1),
(35, 'phrase', 'edit_group', 'Edit Group', 1),
(36, 'phrase', 'export_chat', 'Export Chat', 1),
(37, 'phrase', 'leave_group', 'Leave Group', 1),
(38, 'phrase', 'invite', 'Invite', 1),
(39, 'phrase', 'delete_group', 'Delete Group', 1),
(40, 'phrase', 'no_group_selected', 'Empty Inbox', 1),
(41, 'phrase', 'logout', 'Logout', 1),
(42, 'phrase', 'go_offline', 'Go Offline', 1),
(43, 'phrase', 'go_online', 'Go Online', 1),
(44, 'phrase', 'online', 'Online', 1),
(45, 'phrase', 'offline', 'Offline', 1),
(46, 'phrase', 'idle', 'Idle', 1),
(47, 'phrase', 'search_messages', 'Search messages', 1),
(48, 'phrase', 'alerts', 'Alerts', 1),
(49, 'phrase', 'crew', 'Crew', 1),
(50, 'phrase', 'zero_crew', 'Members', 1),
(51, 'phrase', 'cancel', 'Cancel', 1),
(52, 'phrase', 'files', 'Files', 1),
(53, 'phrase', 'zero_alerts', 'Alerts', 1),
(54, 'phrase', 'groups', 'Groups', 1),
(55, 'phrase', 'deny_default_role', 'Permission Denied : Default Roles', 1),
(56, 'phrase', 'deleted', 'Deleted', 1),
(57, 'phrase', 'deny_system_msg', 'Permission Denied : System Message', 1),
(58, 'phrase', 'deny_file_deletion', 'Permission Denied : Allotted time Expired', 1),
(59, 'phrase', 'invalid_group_password', 'Invalid Group Password', 1),
(60, 'phrase', 'already_exists', 'Already Exists', 1),
(61, 'phrase', 'invalid_value', 'Invalid Input', 1),
(62, 'phrase', 'created', 'Created', 1),
(63, 'phrase', 'updated', 'Updated', 1),
(64, 'phrase', 'username_exists', 'Username Already Taken', 1),
(65, 'phrase', 'email_exists', 'Email Already Exists', 1),
(66, 'phrase', 'files_uploaded', 'Files Uploaded', 1),
(67, 'phrase', 'error_uploading', 'Error Uploading Files', 1),
(68, 'phrase', 'file_expired', 'File Expired', 1),
(69, 'phrase', 'select_group', 'Select a Group or Chat', 1),
(70, 'phrase', 'group_name', 'Group Name', 1),
(71, 'phrase', 'username', 'Username', 1),
(72, 'phrase', 'password', 'Password', 1),
(73, 'phrase', 'email_address', 'Email Address', 1),
(74, 'phrase', 'icon', 'Icon', 1),
(75, 'phrase', 'language', 'Language', 1),
(76, 'phrase', 'role_name', 'Role Name', 1),
(77, 'phrase', 'system_variables', 'System Variables', 1),
(78, 'phrase', 'confirm_delete', 'Are you sure you Want to Delete?', 1),
(79, 'phrase', 'full_name', 'Full Name', 1),
(80, 'phrase', 'mail_login_info', 'Mail Login Info', 1),
(81, 'phrase', 'confirm_join', 'Do You Want to Join?', 1),
(82, 'phrase', 'confirm_leave', 'Do You Want to Leave?', 1),
(83, 'phrase', 'role', 'Role', 1),
(84, 'phrase', 'confirm_export', 'Do You Want to Export?', 1),
(85, 'phrase', 'email_username', 'Email/Username', 1),
(86, 'phrase', 'separate_commas', 'Separate with commas', 1),
(87, 'phrase', 'timezone', 'TimeZone', 1),
(88, 'phrase', 'custom_avatar', 'Custom Avatar', 1),
(89, 'phrase', 'custom_bg', 'Custom Bg', 1),
(90, 'phrase', 'options', 'options', 1),
(91, 'phrase', 'switch', 'Switch', 1),
(92, 'phrase', 'ban', 'Ban', 1),
(93, 'phrase', 'msgs', 'Msgs', 1),
(94, 'phrase', 'new', 'New', 1),
(95, 'phrase', 'members', 'Members', 1),
(96, 'phrase', 'join_group', 'Join Group', 1),
(97, 'phrase', 'join', 'Join', 1),
(98, 'phrase', 'member', 'Member', 1),
(99, 'phrase', 'admin', 'Admin', 1),
(100, 'phrase', 'moderator', 'Moderator', 1),
(101, 'phrase', 'blocked', 'Blocked', 1),
(102, 'phrase', 'confirm', 'Confirm', 1),
(103, 'phrase', 'edit_role', 'Edit Role', 1),
(104, 'phrase', 'device_blocked', 'Device Blocked. Reset Password to Unblock this device.', 1),
(105, 'phrase', 'invalid_login', 'Invalid Login Credentials', 1),
(106, 'phrase', 'denied', 'Permission Denied', 1),
(107, 'phrase', 'unknown', 'Unknown', 1),
(108, 'phrase', 'shared_file', 'Shared a File', 1),
(109, 'phrase', 'banned', 'Banned', 1),
(110, 'phrase', 'unban', 'Unban', 1),
(111, 'phrase', 'created_group', 'Created Group', 1),
(112, 'phrase', 'zero_complaints', 'Petitions', 1),
(113, 'phrase', 'complaints', 'Petitions', 1),
(114, 'phrase', 'report_message', 'Report Message', 1),
(115, 'phrase', 'reported', 'Reported', 1),
(116, 'phrase', 'spam', 'Spam', 1),
(117, 'phrase', 'abuse', 'Abuse', 1),
(118, 'phrase', 'inappropriate', 'Inappropriate', 1),
(119, 'phrase', 'other', 'Other', 1),
(120, 'phrase', 'under_investigation', 'Under Investigation', 1),
(121, 'phrase', 'rejected', 'Rejected', 1),
(122, 'phrase', 'action_taken', 'Action Taken', 1),
(123, 'phrase', 'view_complaint', 'View Grief', 1),
(124, 'phrase', 'proof', 'Proof', 1),
(125, 'phrase', 'timestamp', 'Timestamp', 1),
(126, 'phrase', 'report_group', 'Report Group', 1),
(127, 'phrase', 'invited', 'Invited', 1),
(128, 'phrase', 'alert_invitation', 'Invited you to Join', 1),
(129, 'phrase', 'alert_mentioned', 'Mentioned you', 1),
(130, 'phrase', 'open', 'Open', 1),
(131, 'phrase', 'view_message', 'View Message', 1),
(132, 'phrase', 'message', 'Message', 1),
(133, 'phrase', 'change_avatar', 'Change Avatar', 1),
(134, 'phrase', 'choose_avatar', 'Choose an Avatar', 1),
(135, 'phrase', 'left_group', 'Left the Group Chat', 1),
(136, 'phrase', 'joined_group', 'Joined the Group Chat', 1),
(137, 'phrase', 'alert_replied', 'Sent you a response', 1),
(138, 'phrase', 'date-time', 'Date &amp; Time', 1),
(139, 'phrase', 'sender', 'Sender', 1),
(140, 'phrase', 'you', 'You', 1),
(141, 'phrase', 'exporting', 'Exporting', 1),
(142, 'phrase', 'invalid_captcha', 'Invalid Captcha', 1),
(143, 'phrase', 'remember_me', 'Remember Me', 1),
(144, 'phrase', 'forgot_password', 'Forgot Password', 1),
(145, 'phrase', 'register', 'Register', 1),
(146, 'phrase', 'reset', 'Reset', 1),
(147, 'phrase', 'already_have_account', 'Already have an account?', 1),
(148, 'phrase', 'dont_have_account', 'Donot have an account?', 1),
(149, 'phrase', 'tos', 'Terms of Service', 1),
(150, 'phrase', 'cookie_constent', 'This website uses cookies to ensure you get the best experience on our website.', 1),
(151, 'phrase', 'got_it', 'Got It', 1),
(152, 'phrase', 'user_does_not_exist', 'User Does not Exist', 1),
(153, 'phrase', 'check_inbox', 'We have sent an email to your email address. Please check your Inbox.', 1),
(154, 'phrase', 'email_reset_title', 'Trouble signing in?', 1),
(155, 'phrase', 'email_reset_desc', 'Resetting your password is easy. Just press the button below and once logged in, you can change your password from edit profile tab.', 1),
(156, 'phrase', 'email_reset_btn', 'Auto Login', 1),
(157, 'phrase', 'email_replied_title', 'Awaiting your reply', 1),
(158, 'phrase', 'email_replied_desc', 'You received this email because someone has replied to your message', 1),
(159, 'phrase', 'email_replied_btn', 'View Reply', 1),
(160, 'phrase', 'email_invitation_title', 'You got an Invitation', 1),
(161, 'phrase', 'email_invitation_desc', 'You received this email because someone has invited you to join a group', 1),
(162, 'phrase', 'email_invitation_btn', 'View Message', 1),
(163, 'phrase', 'email_mentioned_title', 'Someone Mentioned You', 1),
(164, 'phrase', 'email_mentioned_desc', 'You received this email because someone has mentioned you in a group chat', 1),
(165, 'phrase', 'email_mentioned_btn', 'View Message', 1),
(166, 'phrase', 'email_signup_title', 'Profile Registered', 1),
(167, 'phrase', 'email_signup_desc', 'Congratulations! Your account has been created. Just press the button below and once logged in, you can change your password from edit profile tab.', 1),
(168, 'phrase', 'email_signup_btn', 'Auto Login', 1),
(169, 'phrase', 'email_reset_sub', 'Forgot Your Password', 1),
(170, 'phrase', 'email_replied_sub', 'You got a Reply', 1),
(171, 'phrase', 'email_invitation_sub', 'Group Invitation', 1),
(172, 'phrase', 'email_mentioned_sub', 'Mentioned you', 1),
(173, 'phrase', 'email_signup_sub', 'Account Created', 1),
(174, 'phrase', 'email_verify_title', 'You&#039;re almost there', 1),
(175, 'phrase', 'email_verify_desc', 'We have finished setting up your account. It is time to confirm your email address. Just click on the button below to get started', 1),
(176, 'phrase', 'email_verify_btn', 'Confirm Email', 1),
(177, 'phrase', 'email_footer', 'If you dont know why you got this email, please tell us straight away so we can fix this for you.', 1),
(178, 'phrase', 'email_complimentary_close', 'Best regards,', 1),
(179, 'phrase', 'email_verify_sub', 'Verify your email address', 1),
(180, 'phrase', 'email_copy_link', 'Or copy this link and paste in your web browser', 1),
(181, 'phrase', 'sitename', 'Site Name', 1),
(182, 'phrase', 'sitedesc', 'Description', 1),
(183, 'phrase', 'sysemail', 'Email Address', 1),
(184, 'phrase', 'sendername', 'Sender Name', 1),
(185, 'phrase', 'userreg', 'User Registration', 1),
(186, 'phrase', 'fileexpiry', 'Download Expires (Minutes)', 1),
(187, 'phrase', 'delmsgexpiry', 'Users can delete Messages Within (Minutes)', 1),
(188, 'phrase', 'recaptcha', 'Recaptcha', 1),
(189, 'phrase', 'rsecretkey', 'Recaptcha Secret Key', 1),
(190, 'phrase', 'rsitekey', 'Recaptcha Site Key', 1),
(191, 'phrase', 'autogroupjoin', 'Auto Group Join', 1),
(192, 'phrase', 'enable', 'Enable', 1),
(193, 'phrase', 'disable', 'Disable', 1),
(194, 'phrase', 'logo', 'Logo', 1),
(195, 'phrase', 'favicon', 'Favicon', 1),
(196, 'phrase', 'emaillogo', 'Logo (Email)', 1),
(197, 'phrase', 'defaultbg', 'Default Bg', 1),
(198, 'phrase', 'loginbg', 'Login Bg', 1),
(199, 'phrase', 'terms', '1. Terms\r\nBy accessing this website, you are agreeing to be bound by the Terms and Conditions of Use, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this website. The content contained here are protected by applicable copyright and trade mark laws. Please take the time to review our privacy policy.\r\n\r\n2. Use License\r\nPermission is granted for the temporary use of the group chat, filemanager on web site for personal, non-commercial use only. This is the grant of the services, not a transfer of title, and under this license you may not: modify or copy the materials; use the materials for any commercial purpose, or for any public display (commercial or non-commercial); attempt to decompile or reverse engineer any software contained on the website; remove any copyright or other proprietary notations from the materials; or transfer the materials to another person or &quot;mirror&quot; the materials on any other website or server. This license shall automatically terminate if you violate any of these restrictions and may be terminated by the website at any time.\r\n\r\n3. Disclaimer\r\nThe content on the website are provided &quot;as is&quot;. We makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Furthermore, We does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the content on its website or otherwise relating to such content or on any sites linked to this site.\r\n\r\n4. Limitations\r\nIn no event shall we be liable for any damages (including, without limitation, damages for loss of data or profit, due to business interruption, or criminal charges filed against you) arising out of the use or inability to use the content on the website, even if we or a authorized representative has been notified orally or in writing of the possibility of such damage. This applies to the use of our chat rooms and filemanager. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.\r\n\r\n5. Revisions and Errata\r\nThe materials appearing on the website could include technical, typos, or image errors. We does not warrant that any of the content on its website are accurate, complete, or current. We may make changes to the content on its website at any time without any noticeWe does not, however, make any commitment to update the content.\r\n\r\n6. Links\r\nWe has not reviewed all of the sites linked from its website and is not responsible for the contents contained within. The inclusion of any link does not imply endorsement by us. Use of any such linked web site is at the user&#039;s own risk.\r\n\r\n7. Age Limitations\r\nIn general, the age minimum for this webs site is 13. This website will not be held responsible for users who do not comply with the given age range as this information is not verifiable.\r\n\r\n8. Hateful Content\r\nWe does not tolerate any form of hateful or violent content in our chat rooms or on our forums. This includes threats, promotion of violence or direct attacks towards other users based upon ethnicity, race, religion, sexual orientation, religion affiliation, age, disability, serious diseases and gender. Users also are prohibited from using hateful images for their profile pictures/avatars. This includes usernames. All such comment will be removed when noticed or reported to our staff.\r\n\r\n9. Illegal Content\r\nWe does not tolerate any form of illegal content in our chat rooms or on our forums. Users also are prohibited from using or uploading illegal images including child pornography or other illegal content. This includes, but not limited to, profile pictures/avatars and any image transfers or uploads. This includes usernames. If you do so, you will be subject to being kicked, banned and, in some cases, reported to law enforcement. We will, to its highest ability, remove all illegal content when it is discovered or reported to us. We will not be held responsible for such content unless it is noticed and reported to our staff.\r\n\r\n10. Terms of Use Changes\r\nWe may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use. If you cannot agree to this, please do not use this website.', 1),
(200, 'phrase', '404_page_title', '404 - Page not found', 1),
(201, 'phrase', '404_page_oops', 'Oops!', 1),
(202, 'phrase', '404_page_heading', '404 - Page not found', 1),
(203, 'phrase', '404_page_desc', 'The page you are looking for might have been removed had its name changed or is temporarily unavailable.', 1),
(204, 'phrase', '404_page_go_to_btn', 'Go To Homepage', 1),
(205, 'phrase', 'reload', 'Reload', 1),
(206, 'phrase', 'reason', 'Reason', 1),
(207, 'phrase', 'comments', 'Comments', 1),
(208, 'phrase', 'category', 'Category', 1),
(209, 'phrase', 'group', 'Group', 1),
(210, 'phrase', 'view_visible', 'View all Visible Groups', 1),
(211, 'phrase', 'admin_controls', 'Full Control of all Groups', 1),
(212, 'phrase', 'upload', 'Upload', 1),
(213, 'phrase', 'attach', 'Share Files', 1),
(214, 'phrase', 'login_as_user', 'Login as User', 1),
(215, 'phrase', 'yes', 'Yes', 1),
(216, 'phrase', 'no', 'No', 1),
(217, 'phrase', 'remove_password', 'Remove Password', 1),
(218, 'phrase', 'edit_language', 'Edit Language', 1),
(219, 'phrase', 'siteslogan', 'Site Slogan', 1),
(220, 'phrase', 'boxed', 'Boxed Layout', 1),
(221, 'phrase', 'ip_blocked', 'Your IP has been blocked', 1),
(222, 'phrase', 'act', 'Act', 1),
(223, 'phrase', 'take_action', 'Take Action', 1),
(224, 'phrase', 'select_option', 'Select Option from Dropdown', 1),
(225, 'phrase', 'banip', 'Ban IP', 1),
(226, 'phrase', 'unbanip', 'Unban IP', 1),
(227, 'phrase', 'choosefiletxt', 'Choose a file', 1),
(228, 'phrase', 'private_chat', 'Private Chat', 1),
(229, 'phrase', 'pm', 'Chat', 1),
(230, 'phrase', 'zero_pm', 'Empty Inbox', 1),
(231, 'phrase', 'cf_about_me', 'About Me', 1),
(232, 'phrase', 'cf_birth_date', 'Birth Date', 1),
(233, 'phrase', 'cf_gender', 'Gender', 1),
(234, 'phrase', 'cf_phone', 'Phone', 1),
(235, 'phrase', 'cf_location', 'Location', 1),
(236, 'phrase', 'alert_newmsg', 'Sent you a new msg', 1),
(237, 'phrase', 'refresh', 'Refresh', 1),
(238, 'phrase', 'hearts', 'Hearts', 1),
(239, 'phrase', 'shares', 'Shares', 1),
(240, 'phrase', 'last_login', 'Last Login', 1),
(241, 'phrase', 'empty_profile', 'Empty Profile', 1),
(242, 'phrase', 'delete_account', 'Delete Account', 1),
(243, 'phrase', 'remove_user', 'Remove User', 1),
(244, 'phrase', 'login_as_guest', 'Login as Guest', 1),
(245, 'phrase', 'guest_login', 'Guest Login', 1),
(246, 'phrase', 'filterwords', 'Filtering', 1),
(247, 'phrase', 'fields', 'Fields', 1),
(248, 'phrase', 'stand_by', 'Stand By', 1),
(249, 'phrase', 'add_custom_field', 'Add Field', 1),
(250, 'phrase', 'banned_page_title', 'You Are Banned', 1),
(251, 'phrase', 'banned_page_ouch', 'ouch', 1),
(252, 'phrase', 'banned_page_heading', 'You are banned', 1),
(253, 'phrase', 'banned_page_desc', 'Access denied. Your IP address or Account is blacklisted. If you feel this is in error please contact website&#039;s administrator.', 1),
(254, 'phrase', 'banned_page_go_to_btn', 'Reach Us', 1),
(255, 'phrase', 'conversation_with', 'Conversation With', 1),
(256, 'phrase', 'email_newmsg_title', 'New Message', 1),
(257, 'phrase', 'email_newmsg_btn', 'View Message', 1),
(258, 'phrase', 'email_newmsg_desc', 'You have a new message. Your have received a message from Someone.', 1),
(259, 'phrase', 'account_reactivated', 'Account Reactivated. Welcome Back', 1),
(260, 'phrase', 'renamed_group', 'Changed the Group Name', 1),
(261, 'phrase', 'changed_group_pass', 'Changed the Group Password', 1),
(262, 'phrase', 'removed_group_pass', 'Removed the Group Password', 1),
(263, 'phrase', 'changed_group_icon', 'Changed the Group Icon', 1),
(264, 'phrase', 'blocked_group_user', 'Got Blocked', 1),
(265, 'phrase', 'unblocked_group_user', 'Got Unblocked', 1),
(266, 'phrase', 'removed_from_group', 'Got removed from Group', 1),
(267, 'phrase', 'deactivate_account', 'Deactivate Account', 1),
(268, 'phrase', 'longtext', 'Long Text', 1),
(269, 'phrase', 'datefield', 'Date Field', 1),
(270, 'phrase', 'shorttext', 'Short Text', 1),
(271, 'phrase', 'numfield', 'Numbers', 1),
(272, 'phrase', 'deactivated', 'Deactivated', 1),
(273, 'phrase', 'converse', 'Converse', 1),
(274, 'phrase', 'blacklist', 'Blacklisted', 1),
(275, 'phrase', 'block_user', 'Block User', 1),
(276, 'phrase', 'zero_fields', 'Fields', 1),
(277, 'phrase', 'fieldname', 'Field Name', 1),
(278, 'phrase', 'fieldtype', 'Field Type', 1),
(279, 'phrase', 'ban_user', 'Ban Users', 1),
(280, 'phrase', 'view_likes', 'View Likes', 1),
(281, 'phrase', 'like_msgs', 'Like Messages', 1),
(282, 'phrase', 'view_profile', 'View Profile', 1),
(283, 'phrase', 'privatemsg', 'Private Message', 1),
(284, 'phrase', 'autodeletemsg', 'Auto Delete Group Msgs (Minutes)', 1),
(285, 'phrase', 'chat', 'Chat', 1),
(286, 'phrase', 'sending', 'Sending', 1),
(287, 'phrase', 'uploading', 'Uploading', 1),
(288, 'phrase', 'read_more', 'Read More', 1),
(289, 'phrase', 'edit_custom_field', 'Edit Custom Field', 1),
(290, 'phrase', 'email_verification', 'Email Verification', 1),
(291, 'phrase', 'today', 'Today', 1),
(292, 'phrase', 'yesterday', 'Yesterday', 1),
(293, 'phrase', 'failed', 'Failed. Try again', 1),
(294, 'phrase', 'smtp_authentication', 'SMTP Authentication', 1),
(295, 'phrase', 'smtp_host', 'SMTP Host', 1),
(296, 'phrase', 'smtp_user', 'SMTP User', 1),
(297, 'phrase', 'smtp_pass', 'SMTP Password', 1),
(298, 'phrase', 'smtp_protocol', 'SMTP Protocol', 1),
(299, 'phrase', 'smtp_port', 'SMTP Port', 1),
(300, 'phrase', 'view_hidden', 'View all Hidden Groups', 1),
(301, 'phrase', 'visible', 'Visible', 1),
(302, 'phrase', 'hidden', 'Hidden', 1),
(303, 'phrase', 'visibility', 'Visibility', 1),
(304, 'phrase', 'protected_group', 'Protected Group', 1),
(305, 'phrase', 'secret_group', 'Secret Group', 1),
(306, 'phrase', 'changed_group_visibility', 'Changed the Group Visibility ', 1),
(307, 'phrase', 'cover_pic', 'Cover Pic', 1),
(308, 'phrase', 'email_newmsg_sub', 'You have a new message.', 1),
(309, 'phrase', 'notification_tone', 'Notification Tone', 1),
(310, 'phrase', 'default_notification_tone', 'Default Notification Tone', 1),
(311, 'phrase', 'autodelusrs', 'Auto Delete Users (Minutes)', 1),
(312, 'phrase', 'maxmsgsperload', 'Messages Per Load', 1),
(313, 'phrase', 'confirm_unblock', 'Are you sure you want to unblock this user?', 1),
(314, 'phrase', 'confirm_block', 'Are you sure you want to block this user?', 1),
(315, 'phrase', 'unblock_user', 'Unblock User', 1),
(316, 'phrase', 'unblock', 'Unblock', 1),
(317, 'phrase', 'refreshrate', 'Chat Refresh Rate (milliseconds)', 1),
(318, 'phrase', 'dropdownfield', 'Dropdown', 1),
(319, 'phrase', 'requiredfield', 'Required', 1),
(320, 'phrase', 'fieldoptions', 'Options', 1),
(321, 'phrase', 'newmsgalert', 'You have a new message!', 1),
(322, 'phrase', 'username_condition', 'Your username must contain at least one letter', 1),
(323, 'phrase', 'max_login_attempts', 'Max Login Attempts', 1),
(324, 'phrase', 'google_analytics_id', 'Google Analytics ID', 1),
(325, 'phrase', 'alert_liked', 'Liked your message', 1),
(326, 'phrase', 'invite_link', 'Invite Link', 1),
(327, 'phrase', 'email_invitenonmember_title', 'You got an Invitation', 1),
(328, 'phrase', 'email_invitenonmember_sub', 'Group Invitation', 1),
(329, 'phrase', 'email_invitenonmember_desc', 'You received this email because someone has invited you to join a group', 1),
(330, 'phrase', 'email_invitenonmember_btn', 'Accept', 1),
(331, 'phrase', 'time_format', 'Time Format', 1),
(332, 'phrase', 'default_font', 'Default Font', 1),
(333, 'phrase', 'profile_noexists', 'Profile doesn&#039;t exist', 1),
(334, 'phrase', 'joined_group_invitelink', 'Joined via the Invite Link', 1),
(335, 'phrase', 'already_deactivated', 'Already Deactivated', 1),
(336, 'phrase', 'name_color', 'Name Color', 1),
(337, 'phrase', 'search', 'Search', 1),
(338, 'phrase', 'zero_search', 'Search Results', 1),
(339, 'phrase', 'search_min', 'Type at least 3 characters', 1),
(340, 'phrase', 'search_gifs_tenor', 'Search GIFs via Tenor', 1),
(341, 'phrase', 'type_message', 'Type a Message', 1),
(342, 'phrase', 'shared_gif', 'Shared a GIF', 1),
(343, 'phrase', 'auto_deleted_after', 'Auto Deleted After', 1),
(344, 'phrase', 'download_file', 'Download File', 1),
(345, 'phrase', 'tenor_enable', 'Tenor GIFs', 1),
(346, 'phrase', 'tenor_api', 'Tenor API', 1),
(347, 'phrase', 'tenor_limit', 'Tenor Limit', 1),
(348, 'phrase', 'aside_results_perload', 'Results per load (Aside)', 1),
(349, 'phrase', 'max_msg_length', 'Maximum send msg length', 1),
(350, 'phrase', 'exceeded_max_msg_length', 'Exceeded Maximum Message Length', 1),
(351, 'phrase', 'min_msg_length', 'Minimum send msg length', 1),
(352, 'phrase', 'req_min_msg_length', 'Required Minimum number of characters', 1),
(353, 'phrase', 'add_readmore_after', 'Add Read More After', 1),
(354, 'phrase', 'set_default_language', 'Set as Default Language', 1),
(355, 'phrase', 'default', 'Default', 1),
(356, 'phrase', 'sent_msg_align', 'Sent Msg Align', 1),
(357, 'phrase', 'received_msg_align', 'Received Msg Align', 1),
(358, 'phrase', 'left', 'Left', 1),
(359, 'phrase', 'right', 'Right', 1),
(360, 'phrase', 'please_wait', 'Please Wait', 1),
(361, 'phrase', 'loading', 'Loading', 1),
(362, 'phrase', 'shared_qrcode', 'Shared a QR Code', 1),
(363, 'phrase', 'emojis', 'Emojis', 1),
(364, 'phrase', 'gifs', 'GIFs', 1),
(365, 'phrase', 'qrcode', 'QR Code', 1),
(366, 'phrase', 'voice_message', 'Voice Message', 1),
(367, 'phrase', 'confirm_msgdelete', 'Are you sure you Want to Delete this message? You have :', 1),
(368, 'phrase', 'confirm_download', 'Are you sure you want to continue downloading?', 1),
(369, 'phrase', 'welcome_user', 'Hello! A warm welcome to you', 1),
(370, 'phrase', 'welcome_msg', 'Share what&amp;#039;s on your mind with other people from all around the world to find new friends.', 1),
(371, 'phrase', 'welcome_footer', 'By accessing this website, you are agreeing to be bound by the Terms and Conditions of Use.', 1),
(372, 'phrase', 'welcomeimg', 'Welcome Image', 1),
(373, 'phrase', 'hide', 'Hide', 1),
(374, 'phrase', 'hide_language', 'Hide Language', 1),
(375, 'phrase', 'confirm_hide', 'Are you sure you want to make this hidden?', 1),
(376, 'phrase', 'done', 'Done', 1),
(377, 'phrase', 'show', 'Show', 1),
(378, 'phrase', 'show_language', 'Show Language', 1),
(379, 'phrase', 'confirm_show', 'Are you sure you want to make this visible?', 1),
(380, 'phrase', 'public_group', 'Public Group', 1),
(381, 'phrase', 'addgroupuser', 'Add Users', 1),
(382, 'phrase', 'adduser_noinvite', 'Add Users without Invite', 1),
(383, 'phrase', 'send_audiomsg', 'Send an Audio Msg', 1),
(384, 'phrase', 'send_messages', 'Send Messages', 1),
(385, 'phrase', 'group_members', 'Group Members', 1),
(386, 'phrase', 'admins_moderators', 'Admins &amp; Moderators', 1),
(387, 'phrase', 'changed_message_settings', 'Changed Message Settings', 1),
(388, 'phrase', 'seen_by', 'Seen By', 1),
(389, 'phrase', 'zero_seen', 'Users Seen', 1),
(390, 'phrase', 'play', 'Play', 1),
(391, 'phrase', 'visit', 'Visit', 1),
(392, 'phrase', 'pagespeed_api', 'PageSpeed Insights API', 1),
(393, 'phrase', 'autounjoin', 'Auto Leave Groups (Minutes)', 1),
(394, 'phrase', 'group_link', 'Group Link', 1),
(395, 'phrase', 'unblocked', 'Unblocked', 1),
(396, 'phrase', 'email_invitenonm_sub', 'You got an Invitation', 1),
(397, 'phrase', 'email_invitenonm_title', 'You got an Invitation', 1),
(398, 'phrase', 'email_invitenonm_desc', 'You received this email because someone has invited you to join a group', 1),
(399, 'phrase', 'email_invitenonm_btn', 'Accept', 1),
(400, 'phrase', 'cronjob', 'Cron Jobs', 1),
(401, 'phrase', 'sendgifs', 'Send GIFs', 1),
(402, 'phrase', 'sendaudiomsgs', 'Send Audio Message', 1),
(403, 'phrase', 'createqrcode', 'Create QR Code', 1),
(404, 'phrase', 'previewmsgs', 'Preview Attachments', 1),
(405, 'phrase', 'sharescreenshot', 'Share Screenshot', 1),
(406, 'phrase', 'sharelinks', 'Share Links', 1),
(407, 'phrase', 'whoistyping', 'Who&amp;#039;s Typing', 1),
(408, 'phrase', 'features', 'Features', 1),
(409, 'phrase', 'sendtxtmsgs', 'Send Text Messages', 1),
(410, 'phrase', 'emailnotifications', 'Email Notifications', 1),
(411, 'phrase', 'notxtmsg', 'Sending disabled. You wont be able to send messages.', 1),
(412, 'phrase', 'nickname', 'Nickname', 1),
(413, 'phrase', 'unsplash_enable', 'UnSplash Slideshow', 1),
(414, 'phrase', 'unsplash_load', 'UnSplash Parameters', 1),
(415, 'phrase', 'signin_logo', 'Logo (Login)', 1),
(416, 'phrase', 'mobile_logo', 'Logo (Mobile)', 1),
(417, 'phrase', 'header', 'Header', 1),
(418, 'phrase', 'footer', 'Footer', 1),
(419, 'phrase', 'easycustomizer', 'Easy Customizer', 1),
(420, 'phrase', 'startcolor', 'Start Color', 1),
(421, 'phrase', 'endcolor', 'End Color', 1),
(422, 'phrase', 'ltr', 'Left to Right', 1),
(423, 'phrase', 'rtl', 'Right to Left', 1),
(424, 'phrase', 'txt_direction', 'Text direction', 1),
(425, 'phrase', 'cf_country', 'Country', 1),
(426, 'phrase', 'embed_code', 'Embed Code', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gr_profiles`
--

CREATE TABLE `gr_profiles` (
  `id` bigint(20) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `uid` bigint(20) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat` varchar(15) DEFAULT NULL,
  `v1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `v2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `req` int(10) NOT NULL DEFAULT 0,
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_profiles`
--

INSERT INTO `gr_profiles` (`id`, `type`, `uid`, `name`, `cat`, `v1`, `v2`, `req`, `tms`) VALUES
(3, 'field', 0, 'cf_about_me', 'longtext', NULL, NULL, 0, '0000-00-00 00:00:00'),
(4, 'field', 0, 'cf_birth_date', 'datefield', NULL, NULL, 0, '0000-00-00 00:00:00'),
(5, 'field', 0, 'cf_gender', 'dropdownfield', 'Male,Female,Non-binary', NULL, 0, '0000-00-00 00:00:00'),
(6, 'field', 0, 'cf_phone', 'numfield', NULL, NULL, 0, '0000-00-00 00:00:00'),
(8, 'field', 0, 'cf_location', 'shorttext', NULL, NULL, 0, '0000-00-00 00:00:00'),
(19, 'field', 0, 'cf_country', 'dropdownfield', 'Afghanistan,Albania,Algeria,Andorra,Angola,Antigua &amp;amp; Deps,Argentina,Armenia,Australia,Austria,Azerbaijan,Bahamas,Bahrain,Bangladesh,Barbados,Belarus,Belgium,Belize,Benin,Bhutan,Bolivia,Bosnia Herzegovina,Botswana,Brazil,Brunei,Bulgaria,Burkina,Burma,Burundi,Cambodia,Cameroon,Canada,Cape Verde,Central African Rep,Chad,Chile,People&amp;#039;s Republic of China,Republic of China,Colombia,Comoros,Democratic Republic of the Congo,Republic of the Congo,Costa Rica,Croatia,Cuba,Cyprus,Czech Republic,Danzig,Denmark,Djibouti,Dominica,Dominican Republic,East Timor,Ecuador,Egypt,El Salvador,Equatorial Guinea,Eritrea,Estonia,Ethiopia,Fiji,Finland,France,Gabon,Gaza Strip,The Gambia,Georgia,Germany,Ghana,Greece,Grenada,Guatemala,Guinea,Guinea-Bissau,Guyana,Haiti,Holy Roman Empire,Honduras,Hungary,Iceland,India,Indonesia,Iran,Iraq,Republic of Ireland,Israel,Italy,Ivory Coast,Jamaica,Japan,Jonathanland,Jordan,Kazakhstan,Kenya,Kiribati,North Korea,South Korea,Kosovo,Kuwait,Kyrgyzstan,Laos,Latvia,Lebanon,Lesotho,Liberia,Libya,Liechtenstein,Lithuania,Luxembourg,Macedonia,Madagascar,Malawi,Malaysia,Maldives,Mali,Malta,Marshall Islands,Mauritania,Mauritius,Mexico,Micronesia,Moldova,Monaco,Mongolia,Montenegro,Morocco,Mount Athos,Mozambique,Namibia,Nauru,Nepal,Newfoundland,Netherlands,New Zealand,Nicaragua,Niger,Nigeria,Norway,Oman,Ottoman Empire,Pakistan,Palau,Panama,Papua New Guinea,Paraguay,Peru,Philippines,Poland,Portugal,Prussia,Qatar,Romania,Rome,Russian Federation,Rwanda,St Kitts &amp;amp; Nevis,St Lucia,Saint Vincent &amp;amp; the,Grenadines,Samoa,San Marino,Sao Tome &amp;amp; Principe,Saudi Arabia,Senegal,Serbia,Seychelles,Sierra Leone,Singapore,Slovakia,Slovenia,Solomon Islands,Somalia,South Africa,Spain,Sri Lanka,Sudan,Suriname,Swaziland,Sweden,Switzerland,Syria,Tajikistan,Tanzania,Thailand,Togo,Tonga,Trinidad &amp;amp; Tobago,Tunisia,Turkey,Turkmenistan,Tuvalu,Uganda,Ukraine,United Arab Emirates,United Kingdom,United States of America,Uruguay,Uzbekistan,Vanuatu,Vatican City,Venezuela,Vietnam,Yemen,Zambia,Zimbabwe', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gr_session`
--

CREATE TABLE `gr_session` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `tms` datetime DEFAULT NULL,
  `try` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gr_users`
--

CREATE TABLE `gr_users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mask` varchar(255) NOT NULL,
  `depict` int(5) NOT NULL DEFAULT 1,
  `role` bigint(20) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `altered` datetime NOT NULL,
  `extra` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gr_users`
--

INSERT INTO `gr_users` (`id`, `name`, `email`, `pass`, `mask`, `depict`, `role`, `created`, `altered`, `extra`) VALUES
(1, 'admin', 'grupo@baevox.com', '97a526d3f708f91b341019fd3e0150a4bb18745a64035b5c79eb88f396c8adf0', 'HO74443yQ', 3, 2, '2019-04-11 16:54:11', '2020-03-04 20:54:33', '0'),
(2, 'baevox', 'hello@baevox.com', '5e3c2f7dab96392ff7bb0beb75a6ee90', 'plUHzz8mpj8yT', 4, 2, '2020-03-03 16:28:40', '2020-03-03 16:28:40', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gr_utrack`
--

CREATE TABLE `gr_utrack` (
  `id` bigint(20) NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `dev` varchar(255) DEFAULT NULL,
  `uid` bigint(20) DEFAULT NULL,
  `status` int(10) DEFAULT 0,
  `tms` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gr_alerts`
--
ALTER TABLE `gr_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_complaints`
--
ALTER TABLE `gr_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_customize`
--
ALTER TABLE `gr_customize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_defaults`
--
ALTER TABLE `gr_defaults`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_logs`
--
ALTER TABLE `gr_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_mails`
--
ALTER TABLE `gr_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_msgs`
--
ALTER TABLE `gr_msgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_options`
--
ALTER TABLE `gr_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_permissions`
--
ALTER TABLE `gr_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_phrases`
--
ALTER TABLE `gr_phrases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_profiles`
--
ALTER TABLE `gr_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_session`
--
ALTER TABLE `gr_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gr_users`
--
ALTER TABLE `gr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `gr_utrack`
--
ALTER TABLE `gr_utrack`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gr_alerts`
--
ALTER TABLE `gr_alerts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gr_complaints`
--
ALTER TABLE `gr_complaints`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gr_customize`
--
ALTER TABLE `gr_customize`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `gr_defaults`
--
ALTER TABLE `gr_defaults`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `gr_logs`
--
ALTER TABLE `gr_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gr_mails`
--
ALTER TABLE `gr_mails`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gr_msgs`
--
ALTER TABLE `gr_msgs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gr_options`
--
ALTER TABLE `gr_options`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gr_permissions`
--
ALTER TABLE `gr_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `gr_phrases`
--
ALTER TABLE `gr_phrases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `gr_profiles`
--
ALTER TABLE `gr_profiles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `gr_session`
--
ALTER TABLE `gr_session`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `gr_users`
--
ALTER TABLE `gr_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gr_utrack`
--
ALTER TABLE `gr_utrack`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
