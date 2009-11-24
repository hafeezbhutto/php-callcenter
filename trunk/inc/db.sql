SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `operator` int(10) NOT NULL,
  `type` enum('Incoming','Outgoing','Chat') NOT NULL,
  `web` int(10) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `duration` int(10) NOT NULL,
  `comments` text NOT NULL,
  `customer` int(10) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=26 ;


CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mail` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL,
  `country` int(10) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=14 ;


CREATE TABLE IF NOT EXISTS `options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=11 ;

INSERT INTO `subjects` (`id`, `subject`) VALUES
(1, 'Order Status'),
(2, 'Refill'),
(3, 'Qty Claim'),
(4, 'General Inquiry'),
(5, 'New Customer'),
(6, 'Billing Question'),
(7, 'Declined Follow Up'),
(8, 'Arrival Follow Up'),
(9, 'Chargeback'),
(10, 'Refund');


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `permissions` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `users` (`id`, `user`, `password`, `mail`, `permissions`) VALUES
(0, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@example.com', 5);


CREATE TABLE IF NOT EXISTS `webs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `web` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

INSERT INTO `webs` (`id`, `web`) VALUES
(1, 'Web 1'),
(2, 'Web 2');
