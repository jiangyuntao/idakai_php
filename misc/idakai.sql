-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 11 月 15 日 14:21
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `idakai`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `user_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--


-- --------------------------------------------------------

--
-- 表的结构 `badword`
--

CREATE TABLE IF NOT EXISTS `badword` (
  `word` varchar(255) NOT NULL,
  `replace` varchar(255) NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `badword`
--


-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `category`
--


-- --------------------------------------------------------

--
-- 表的结构 `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(60) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `topics` int(10) unsigned NOT NULL,
  `posts` int(10) unsigned NOT NULL,
  `last_topic_id` int(10) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `closed` enum('0','1') NOT NULL DEFAULT '0',
  `closed_reason` varchar(255) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `group`
--


-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0代表系统消息',
  `to_user_id` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `draft` enum('0','1') NOT NULL DEFAULT '0',
  `new` enum('0','1') NOT NULL DEFAULT '1',
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `message`
--


-- --------------------------------------------------------

--
-- 表的结构 `moderator`
--

CREATE TABLE IF NOT EXISTS `moderator` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `moderator`
--


-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_ip` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `post`
--


-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `variable` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `setting`
--


-- --------------------------------------------------------

--
-- 表的结构 `subscription`
--

CREATE TABLE IF NOT EXISTS `subscription` (
  `topic_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `subscription`
--


-- --------------------------------------------------------

--
-- 表的结构 `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `viewed` int(10) unsigned NOT NULL,
  `replied` int(10) unsigned NOT NULL,
  `sticky` enum('0','1') NOT NULL DEFAULT '0' COMMENT '置顶',
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `topic`
--


-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `show_email` enum('0','1') NOT NULL DEFAULT '0',
  `avatar` varchar(255) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `login_time` int(10) unsigned NOT NULL,
  `login_ip` varchar(15) NOT NULL,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `banned_time` int(10) unsigned NOT NULL,
  `banned_reason` varchar(255) NOT NULL,
  `posts` int(10) unsigned NOT NULL DEFAULT '0',
  `created` int(10) unsigned NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `show_email`, `avatar`, `reg_ip`, `login_time`, `login_ip`, `banned`, `banned_time`, `banned_reason`, `posts`, `created`, `modified`) VALUES
(1, 'admin', '9b15d22deb8b650ee73934ccb938f2a0', '', '0', '', '127.0.0.1', 1332333587, '127.0.0.1', '0', 0, '', 0, 0, 0);
