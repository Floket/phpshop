

DROP TABLE IF EXISTS `phpshop_modules_evolpay_system`;
CREATE TABLE IF NOT EXISTS `phpshop_modules_evolpay_system` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(11) NOT NULL,
  `title` text NOT NULL,
  `title_sub` text NOT NULL,
  `link_top_text` text NOT NULL,
  `link_text` text NOT NULL,
  `token` varchar(64) NOT NULL default '',
  `version` FLOAT(2) DEFAULT '1.0' NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


INSERT INTO `phpshop_modules_evolpay_system` VALUES (1,0,'Оплатите пожалуйста свой заказ','Ожидание оплаты','Ваш заказ оплачен','Ваш заказ успешно оплачен','','1.0');

INSERT INTO `phpshop_payment_systems` VALUES (69696, 'Оплата Qr-cod', 'modules', '0', 0, '', '', '', '/UserFiles/Image/Payments/evolpay.png');