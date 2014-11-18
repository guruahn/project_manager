-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 14-11-14 09:58
-- 서버 버전: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `project_idx` int(11) NOT NULL,
  `parent_idx` int(11) DEFAULT '0',
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 테이블의 덤프 데이터 `category`
--

INSERT INTO `category` (`idx`, `name`, `slug`, `project_idx`, `parent_idx`, `insert_date`) VALUES
(1, '인클루드', 'Include', 1, 0, '2014-11-14 04:02:29'),
(2, '메인', 'main', 1, 0, '2014-11-14 04:20:00'),
(3, '지붕시스템', 'roof_system', 1, 0, '2014-11-14 04:23:32'),
(4, '제품 안내', 'product_guide', 1, 3, '2014-11-14 05:22:33'),
(5, '지붕상식', 'roof_basic', 1, 3, '2014-11-14 05:30:14');

-- --------------------------------------------------------

--
-- 테이블 구조 `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  `project_idx` int(11) NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finish_date` timestamp NULL DEFAULT NULL,
  `category_idx` int(11) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 테이블의 덤프 데이터 `page`
--

INSERT INTO `page` (`idx`, `link`, `name`, `state`, `description`, `project_idx`, `insert_date`, `finish_date`, `category_idx`) VALUES
(1, 'http://ow.tendency.kr/new/inc/footer.asp', 'footer.asp하단 공통 페이지 ', 0, '여기는 상세설명', 1, '2014-11-12 15:00:00', NULL, 1),
(2, 'http://ow.tendency.kr/new/inc/header.asp', '헤더', 0, '상단 공통 파일', 1, '2014-11-13 23:34:26', NULL, 1),
(3, 'http://ow.tendency.kr/new/product/roof/product_guide.asp', '제품 안내', 0, '디자인: 탭 이미지 hover 레이어 필요', 1, '2014-11-13 23:39:08', NULL, 4);

-- --------------------------------------------------------

--
-- 테이블 구조 `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 테이블의 덤프 데이터 `project`
--

INSERT INTO `project` (`idx`, `name`, `insert_date`) VALUES
(1, '오웬스코닝', '2014-11-14 02:19:27'),
(3, '고캐쉬백', '2014-11-13 21:32:07');

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `level` int(2) NOT NULL,
  `password` varchar(50) NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`idx`, `id`, `name`, `level`, `password`, `insert_date`) VALUES
(1, 'guruahn', '안정우', 0, '9c4d61ec636053f7c6d32cd5f71f537178571c8a', '2014-11-14 02:30:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
