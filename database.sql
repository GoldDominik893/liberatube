-- Create the users database if it doesn't exist
CREATE DATABASE IF NOT EXISTS users;

-- Switch to the users database
USE users;

-- Table structure for table `login`
CREATE TABLE `login` (
  `username` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt1` varchar(12) NOT NULL,
  `salt2` varchar(12) NOT NULL,
  `theme` varchar(30) DEFAULT NULL,
  `customtheme_player_url` varchar(125) DEFAULT NULL,
  `customtheme_home_url` varchar(125) DEFAULT NULL,
  `lang` varchar(30) DEFAULT NULL,
  `region` varchar(4) DEFAULT NULL,
  `librebook_url` varchar(128) DEFAULT NULL,
  `librebook_key` varchar(64) DEFAULT NULL,
  `proxy` varchar(8) DEFAULT NULL,
  `videoshadow` varchar(8) DEFAULT NULL,
  `loadcomments` varchar(12) DEFAULT NULL,
  `watch_history` json DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `playlist`
CREATE TABLE `playlist` (
  `playlist_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `playlist_name` varchar(255) NOT NULL,
  `public` varchar(6) DEFAULT NULL,
  `video_ids` json NOT NULL,
  PRIMARY KEY (`playlist_id`),
  FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `cache`
CREATE TABLE `cache_video` (
  `video_id` VARCHAR(30),
  `lang` VARCHAR(10) NOT NULL,
  `data` JSON NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`video_id`, `lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `cache`
CREATE TABLE `cache_dislike` (
  `video_id` VARCHAR(30),
  `data` JSON NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `cache`
CREATE TABLE `cache_trending` (
  `region` VARCHAR(30),
  `lang` VARCHAR(10) NOT NULL,
  `type` VARCHAR(10),
  `data` JSON NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`region`, `lang`, `type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;