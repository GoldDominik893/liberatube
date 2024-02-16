-- Create the users database
CREATE DATABASE IF NOT EXISTS users;

-- Switch to the users database
USE users;

-- Table structure for table `login`
CREATE TABLE `login` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt1` varchar(12) NOT NULL,
  `salt2` varchar(12) NOT NULL,
  `theme` varchar(30) NOT NULL,
  `customtheme_player_url` varchar(125) NOT NULL,
  `customtheme_home_url` varchar(125) NOT NULL,
  `lang` varchar(30) NOT NULL,
  `region` varchar(4) NOT NULL,
  `proxy` varchar(8) NOT NULL,
  `player` varchar(15) NOT NULL,
  `videoshadow` varchar(8) NOT NULL,
  `loadcomments` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
