CREATE TABLE `retweets` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `retweeted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `text` varchar(200) DEFAULT NULL,
  `screen_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;