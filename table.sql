SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Table structure for table `pstats`
--

CREATE TABLE IF NOT EXISTS `pstats` (
  `appid` varchar(48) NOT NULL,
  `appver` varchar(8) NOT NULL,
  `webkitver` varchar(20) NOT NULL,
  `osbld` varchar(8) NOT NULL,
  `model` varchar(30) NOT NULL,
  `modelascii` varchar(30) NOT NULL,
  `osver` varchar(20) NOT NULL,
  `osvermj` varchar(3) NOT NULL,
  `osvermn` varchar(3) NOT NULL,
  `osverdt` varchar(3) NOT NULL,
  `carrier` varchar(20) NOT NULL,
  `width` varchar(4) NOT NULL,
  `height` varchar(4) NOT NULL,
  `locale` varchar(20) NOT NULL,
  `uuid` varchar(40) NOT NULL,
  `hits` int(11) unsigned NOT NULL,
  `lasthit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `firstuse` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
