CREATE TABLE IF NOT EXISTS `ip_simple_product_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `deliveryCost` int(11) NOT NULL COMMENT 'in cents',
  `priority` DOUBLE NOT NULL,
  `isDefault` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `ip_simple_product_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(3) NOT NULL,
  `ratio` DOUBLE NOT NULL,
  `priority` DOUBLE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `ip_simple_product_order` (
`id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `fileOnSale` VARCHAR(255) NULL,
  `fileOnSaleName` VARCHAR(255) NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text,
  `deliveryCost` int(11) NULL COMMENT 'in cents',
  `country` varchar(255) NOT NULL,
  `widgetId` int(11) NOT NULL COMMENT 'ID of widget which started the process. This field is just in case here. All widgets data is stored in this table either way.',
  `isPaid` BOOLEAN NULL DEFAULT FALSE,
  `other` text COMMENT 'This field store any other custom fields added by customizing checkout form. JSON format.',
  `securityCode` VARCHAR(32) NOT NULL,
  `createdAt` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
