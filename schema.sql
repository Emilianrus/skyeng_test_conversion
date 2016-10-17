CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL DEFAULT '',
  `phone` varchar(32) DEFAULT NULL,
  `status` enum('new','registered','refuse','not_available') NOT NULL DEFAULT 'new',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `creation_date` (`creation_date`)
) ENGINE=InnoDB AUTO_INCREMENT=1501 DEFAULT CHARSET=utf8;
