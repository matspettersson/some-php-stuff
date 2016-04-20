
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Table structure for table `amazon`
--

DROP TABLE IF EXISTS `amazon`;
CREATE TABLE IF NOT EXISTS `amazon` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `comment` varchar(254) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `genus_descriptions`
--

DROP TABLE IF EXISTS `genus_descriptions`;
CREATE TABLE IF NOT EXISTS `genus_descriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `para_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `pictureid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `varietyid` smallint(5) unsigned DEFAULT NULL,
  `filename` text,
  `comment` text,
  `picorder` smallint(5) unsigned DEFAULT NULL,
  `picdate` date DEFAULT NULL,
  `category` text,
  `subcategory` text,
  PRIMARY KEY (`pictureid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `randompicture`
--

DROP TABLE IF EXISTS `randompicture`;
CREATE TABLE IF NOT EXISTS `randompicture` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `link` varchar(254) NOT NULL DEFAULT '',
  `comment` varchar(254) NOT NULL DEFAULT '',
  `ref` varchar(254) NOT NULL DEFAULT '',
  `category` varchar(40) NOT NULL DEFAULT '',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `varieties`
--

DROP TABLE IF EXISTS `varieties`;
CREATE TABLE IF NOT EXISTS `varieties` (
  `varietyid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `genus` text,
  `species` text,
  `subspecies` text,
  `commonname` text,
  `othername1` text,
  `othername2` text,
  `description` varchar(255) DEFAULT NULL,
  `comment` text,
  `correlate` smallint(5) NOT NULL DEFAULT '0',
  `immaturepodcolour` varchar(25) DEFAULT NULL,
  `maturepodcolour` varchar(25) NOT NULL DEFAULT '',
  `heat` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`varietyid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


