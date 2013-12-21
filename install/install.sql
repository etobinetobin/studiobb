DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `youtube` text,
  `google` text,
  `adsense` text,
  `youtube2` text,
  `desc` text,
  `author` text,
  `keywords` text,
  `peuser` varchar(100) DEFAULT NULL,
  `pepass` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `admin` (`id`, `youtube`, `google`, `adsense`, `youtube2`, `desc`, `author`, `keywords`, `peuser`, `pepass`) VALUES
(1, '', NULL, NULL, NULL, 'Airbnb Clone', NULL, NULL, NULL, NULL);

DROP TABLE IF EXISTS `amnities`;
CREATE TABLE IF NOT EXISTS `amnities` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(111) NOT NULL,
  `description` varchar(333) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

INSERT INTO `amnities` (`id`, `name`, `description`) VALUES
(1, 'Smoking Allowed ', 'Smoking is allowed '),
(2, 'Pets Allowed', 'Pets is allowed'),
(4, 'Cable TV ', 'Cable TV  is available'),
(6, 'Wireless Internet', 'A wireless router that guests can access 24/7.'),
(7, 'Air Conditioning', 'Air Conditioning is available'),
(8, 'Heating', 'Heating is available'),
(9, 'Elevator in Building ', 'Elevator is available in the building '),
(10, 'Handicap Accessible', 'The property is easily accessible.  Guests should communicate about individual needs.'),
(11, 'Pool', 'A private swimming pool'),
(12, 'Kitchen', 'Kitchen is available for guest use'),
(13, 'Parking Included', 'Parking Included'),
(14, 'Washer / Dryer', 'Washer / Dryer'),
(15, 'Doorman', 'Doorman'),
(16, 'Gym', 'Gym'),
(17, 'Hot Tub', 'Hot Tub'),
(18, 'Indoor Fireplace', 'Indoor Fireplace'),
(19, 'Buzzer/Wireless Intercom ', 'Buzzer/Wireless Intercom '),
(20, 'Breakfast', 'Breakfast is provided.'),
(21, 'Family/Kid Friendly', 'The property is suitable for hosting families with children.'),
(22, 'Suitable for Events', 'The property can accommodate a gathering of 25 or more attendees.'),
(24, 'Swimming', 'Swimming pool');

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE IF NOT EXISTS `calendar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `list_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `availability` varchar(31) NOT NULL,
  `value` varchar(30) NOT NULL,
  `currency` varchar(7) NOT NULL,
  `notes` text NOT NULL,
  `style` varchar(11) NOT NULL,
  `booked_using` varchar(30) NOT NULL,
  `booked_days` int(31) NOT NULL,
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `cancellation_policy`;
CREATE TABLE IF NOT EXISTS `cancellation_policy` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(155) NOT NULL,
  `cancellation_title` varchar(155) NOT NULL,
  `cancellation_content` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `cancellation_policy` (`id`, `site_name`, `cancellation_title`, `cancellation_content`, `status`) VALUES
(1, 'Dropin', 'Flexible: Full refund 1 day prior to arrival, except fees', '<p>Cleaning fees are always refunded if the guest did not check in. The Drop Inn an Airbnb Clone service fee is non-refundable. If there is a complaint from either party, notice must be given to Drop Inn an Airbnb Clone within 24 hours of check-in. Drop Inn an Airbnb Clone will mediate when necessary, and has the final say in all disputes. A reservation is not officially canceled until the guest receives a cancellation confirmation e-mail from Drop Inn an Airbnb Clone. To get your cancellation e-mail, go to Travel Plans. If the cancellation e-mail is not received, contact Drop Inn an Airbnb Clone here.</p>', '0'),
(2, 'Dropin', 'Moderate: Full refund 5 days prior to arrival, except fees', '<p>Cleaning fees are always refunded if the guest did not check in. The Drop Inn an Airbnb Clone service fee is \r\n\r\nnon-refundable. If there is a complaint from either party, notice must be given to Drop Inn an Airbnb Clone within 24 hours of check-in. Drop Inn an Airbnb Clone will mediate \r\n\r\nwhen necessary, and has the final say in all disputes. A reservation is not officially canceled until the guest receives a cancellation confirmation e-mail from Drop Inn an \r\n\r\nAirbnb Clone. To get your cancellation e-mail, go to Travel Plans. If the cancellation e-mail is not received, contact Drop Inn an Airbnb Clone here.</p>', '0'),
(3, 'Dropin', 'Strict: 50% refund up until 1 week prior to arrival, except fees', '<p>Cleaning fees are always refunded if the guest did not check in. The Drop Inn an Airbnb Clone service fee \r\n\r\nis non-refundable. If there is a complaint from either party, notice must be given to Drop Inn an Airbnb Clone within 24 hours of check-in. Drop Inn an Airbnb Clone will mediate \r\n\r\nwhen necessary, and has the final say in all disputes. A reservation is not officially canceled until the guest receives a cancellation confirmation e-mail from Drop Inn an \r\n\r\nAirbnb Clone. To get your cancellation e-mail, go to Travel Plans. If the cancellation e-mail is not received, contact Drop Inn an Airbnb Clone here.</p>', '0'),
(4, 'Dropin', 'Super Strict: 50% refund up until 30 days prior to arrival, except fees', '<p>Note: The Super Strict cancellation policy applies to special circumstances and is by invitation \r\n\r\nonly. Cleaning fees are always refunded if the guest did not check in. The Drop Inn an Airbnb Clone service fee is non-refundable. If there is a complaint from either party, \r\n\r\nnotice must be given to Drop Inn an Airbnb Clone within 24 hours of check-in. Drop Inn an Airbnb Clone will mediate when necessary, and has the final say in all disputes. A \r\n\r\nreservation is not officially canceled until the guest receives a cancellation confirmation e-mail from Drop Inn an Airbnb Clone. To get your cancellation e-mail, go to Travel \r\n\r\nPlans. If the cancellation e-mail is not received, contact Drop Inn an Airbnb Clone here.</p>', '0'),
(5, 'Dropin', 'Long Term: First month down payment, 30 day notice for lease \r\n\r\ntermination', '<p>Note: The Long Term cancellation policy applies to all reservations of 28 nights or more. Cleaning fees are always refunded if the guest did not check in. The \r\n\r\nDrop Inn an Airbnb Clone service fee is non-refundable. If there is a complaint from either party, notice must be given to Drop Inn an Airbnb Clone within 24 hours of check-in. \r\n\r\nDrop Inn an Airbnb Clone will mediate when necessary, and has the final say in all disputes. A reservation is not officially canceled until the guest receives a cancellation \r\n\r\nconfirmation e-mail from Drop Inn an Airbnb Clone. To get your cancellation e-mail, go to Travel Plans. If the cancellation e-mail is not received, contact Drop Inn an Airbnb \r\n\r\nClone here.</p>', '0');

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('7513aadacc2258b7b87216906e356eb0', '0.0.0.0', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv', 1307957325, 'a:12:{s:10:"DX_user_id";s:2:"17";s:11:"DX_username";s:6:"magesh";s:10:"DX_role_id";s:1:"1";s:12:"DX_role_name";s:4:"User";s:18:"DX_parent_roles_id";a:0:{}s:20:"DX_parent_roles_name";a:0:{}s:13:"DX_permission";a:0:{}s:21:"DX_parent_permissions";a:0:{}s:12:"DX_logged_in";b:1;s:4:"user";s:2:"17";s:8:"username";s:6:"magesh";s:9:"logged_in";b:1;}'),
('d9fb989e2b792a7964d3caea86bcead0', '0.0.0.0', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv', 1307978034, 'a:12:{s:10:"DX_user_id";s:1:"1";s:11:"DX_username";s:5:"admin";s:10:"DX_role_id";s:1:"2";s:12:"DX_role_name";s:5:"Admin";s:18:"DX_parent_roles_id";a:0:{}s:20:"DX_parent_roles_name";a:0:{}s:13:"DX_permission";a:0:{}s:21:"DX_parent_permissions";a:0:{}s:12:"DX_logged_in";b:1;s:4:"user";s:1:"1";s:8:"username";s:5:"admin";s:9:"logged_in";b:1;}');

DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE IF NOT EXISTS `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `pincode` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `contact_info` (`id`, `phone`, `email`, `name`, `street`, `city`, `state`, `country`, `pincode`) VALUES
(1, '04524282000', 'support@cogzidel.com', 'Cogzidel Technologies', 'Simakkal', 'Madurai', 'TamilNadu', 'India', 625001);

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_symbol` varchar(3) CHARACTER SET utf8 NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

INSERT INTO `country` (`id`, `country_symbol`, `country_name`) VALUES
(1, 'US', 'United States'),
(2, 'AF', 'Afghanistan'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, 'AI', 'Anguilla'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'VG', 'British Virgin Islands'),
(33, 'BN', 'Brunei'),
(34, 'BG', 'Bulgaria'),
(35, 'BF', 'Burkina Faso'),
(36, 'BI', 'Burundi'),
(37, 'KH', 'Cambodia'),
(38, 'CM', 'Cameroon'),
(39, 'CA', 'Canada'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CD', 'Congo - Democratic Republic of'),
(52, 'CK', 'Cook Islands'),
(53, 'CR', 'Costa Rica'),
(54, 'HR', 'Croatia'),
(55, 'CU', 'Cuba'),
(56, 'CY', 'Cyprus'),
(57, 'CZ', 'Czech Republic'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecuador'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equitorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'FK', 'Falkland Islands (Islas Malvinas)'),
(71, 'FO', 'Faroe Islands'),
(72, 'FJ', 'Fiji'),
(73, 'FI', 'Finland'),
(74, 'FR', 'France'),
(75, 'GF', 'French Guyana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern and Antarctic Lands'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GZ', 'Gaza Strip'),
(81, 'GE', 'Georgia'),
(82, 'DE', 'Germany'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'GN', 'Guinea'),
(92, 'GW', 'Guinea-Bissau'),
(93, 'GY', 'Guyana'),
(94, 'HT', 'Haiti'),
(95, 'HM', 'Heard Island and McDonald Islands'),
(96, 'VA', 'Holy See (Vatican City)'),
(97, 'HN', 'Honduras'),
(98, 'HK', 'Hong Kong'),
(99, 'HU', 'Hungary'),
(100, 'IS', 'Iceland'),
(101, 'IN', 'India'),
(102, 'ID', 'Indonesia'),
(103, 'IR', 'Iran'),
(104, 'IQ', 'Iraq'),
(105, 'IE', 'Ireland'),
(106, 'IL', 'Israel'),
(107, 'IT', 'Italy'),
(108, 'JM', 'Jamaica'),
(109, 'JP', 'Japan'),
(110, 'JO', 'Jordan'),
(111, 'KZ', 'Kazakhstan'),
(112, 'KE', 'Kenya'),
(113, 'KI', 'Kiribati'),
(114, 'KW', 'Kuwait'),
(115, 'KG', 'Kyrgyzstan'),
(116, 'LA', 'Laos'),
(117, 'LV', 'Latvia'),
(118, 'LB', 'Lebanon'),
(119, 'LS', 'Lesotho'),
(120, 'LR', 'Liberia'),
(121, 'LY', 'Libya'),
(122, 'LI', 'Liechtenstein'),
(123, 'LT', 'Lithuania'),
(124, 'LU', 'Luxembourg'),
(125, 'MO', 'Macau'),
(126, 'MK', 'Macedonia - The Former Yugoslav Republic of'),
(127, 'MG', 'Madagascar'),
(128, 'MW', 'Malawi'),
(129, 'MY', 'Malaysia'),
(130, 'MV', 'Maldives'),
(131, 'ML', 'Mali'),
(132, 'MT', 'Malta'),
(133, 'MH', 'Marshall Islands'),
(134, 'MQ', 'Martinique'),
(135, 'MR', 'Mauritania'),
(136, 'MU', 'Mauritius'),
(137, 'YT', 'Mayotte'),
(138, 'MX', 'Mexico'),
(139, 'FM', 'Micronesia - Federated States of'),
(140, 'MD', 'Moldova'),
(141, 'MC', 'Monaco'),
(142, 'MN', 'Mongolia'),
(143, 'MS', 'Montserrat'),
(144, 'MA', 'Morocco'),
(145, 'MZ', 'Mozambique'),
(146, 'MM', 'Myanmar'),
(147, 'NA', 'Namibia'),
(148, 'NR', 'Naura'),
(149, 'NP', 'Nepal'),
(150, 'NL', 'Netherlands'),
(151, 'AN', 'Netherlands Antilles'),
(152, 'NC', 'New Caledonia'),
(153, 'NZ', 'New Zealand'),
(154, 'NI', 'Nicaragua'),
(155, 'NE', 'Niger'),
(156, 'NG', 'Nigeria'),
(157, 'NU', 'Niue'),
(158, 'NF', 'Norfolk Island'),
(159, 'KP', 'North Korea'),
(160, 'MP', 'Northern Mariana Islands'),
(161, 'NO', 'Norway'),
(162, 'OM', 'Oman'),
(163, 'PK', 'Pakistan'),
(164, 'PW', 'Palau'),
(165, 'PA', 'Panama'),
(166, 'PG', 'Papua New Guinea'),
(167, 'PY', 'Paraguay'),
(168, 'PE', 'Peru'),
(169, 'PH', 'Philippines'),
(170, 'PN', 'Pitcairn Islands'),
(171, 'PL', 'Poland'),
(172, 'PT', 'Portugal'),
(173, 'PR', 'Puerto Rico'),
(174, 'QA', 'Qatar'),
(175, 'RE', 'Reunion'),
(176, 'RO', 'Romania'),
(177, 'RU', 'Russia'),
(178, 'RW', 'wanda'),
(179, 'KN', 'Saint Kitts and Nevis'),
(180, 'LC', 'Saint Lucia'),
(181, 'VC', 'Saint Vincent and the Grenadines'),
(182, 'WS', 'Samoa'),
(183, 'SM', 'San Marino'),
(184, 'ST', 'Sao Tome and Principe'),
(185, 'SA', 'Saudi Arabia'),
(186, 'SN', 'Senegal'),
(187, 'CS', 'Serbia and Montenegro'),
(188, 'SC', 'Seychelles'),
(189, 'SL', 'Sierra Leone'),
(190, 'SG', 'Singapore'),
(191, 'SK', 'Slovakia'),
(192, 'SI', 'Slovenia'),
(193, 'SB', 'Solomon Islands'),
(194, 'SO', 'Somalia'),
(195, 'ZA', 'South Africa'),
(196, 'GS', 'South Georgia and the South Sandwich Islands'),
(197, 'KR', 'South Korea'),
(198, 'ES', 'Spain'),
(199, 'LK', 'Sri Lanka'),
(200, 'SH', 'St. Helena'),
(201, 'PM', 'St. Pierre and Miquelon'),
(202, 'SD', 'Sudan'),
(203, 'SR', 'Suriname'),
(204, 'SJ', 'Svalbard'),
(205, 'SZ', 'Swaziland'),
(206, 'SE', 'Sweden'),
(207, 'CH', 'Switzerland'),
(208, 'SY', 'Syria'),
(209, 'TW', 'Taiwan'),
(210, 'TJ', 'Tajikistan'),
(211, 'TZ', 'Tanzania'),
(212, 'TH', 'Thailand'),
(213, 'TG', 'Togo'),
(214, 'TK', 'Tokelau'),
(215, 'TO', 'Tonga'),
(216, 'TT', 'Trinidad and Tobago'),
(217, 'TN', 'Tunisia'),
(218, 'TR', 'Turkey'),
(219, 'TM', 'Turkmenistan'),
(220, 'TC', 'Turks and Caicos Islands'),
(221, 'TV', 'Tuvalu'),
(222, 'UG', 'Uganda'),
(223, 'UA', 'Ukraine'),
(224, 'AE', 'United Arab Emirates'),
(225, 'GB', 'United Kingdom'),
(226, 'VI', 'United States Virgin Islands'),
(227, 'UY', 'Uruguay'),
(228, 'UZ', 'Uzbekistan'),
(229, 'VU', 'Vanuatu'),
(230, 'VE', 'Venezuela'),
(231, 'VN', 'Vietnam'),
(232, 'WF', 'Wallis and Futuna'),
(233, 'PS', 'West Bank'),
(234, 'EH', 'Western Sahara'),
(235, 'YE', 'Yemen'),
(236, 'ZM', 'Zambia'),
(237, 'ZW', 'Zimbabwe');

DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(150) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `default` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

INSERT INTO `currency` (`id`, `currency_name`, `currency_code`, `currency_symbol`, `status`, `default`) VALUES
(1, 'US Dollar', 'USD', '&#36;', 1, 1),
(2, 'Pound Sterling', 'GBP', '&pound;', 1, 0),
(3, 'Europe', 'EUR', '&euro;', 1, 0),
(4, 'Australian Dollar', 'AUD', '&#36;', 1, 0),
(5, 'Singapore', 'SGD', '&#36;', 1, 0),
(6, 'Swedish Krona', 'SEK', 'kr', 1, 0),
(7, 'Danish Krone', 'DKK', 'kr', 1, 0),
(8, 'Mexican Peso', 'MXN', '$', 1, 0),
(9, 'Brazilian Real', 'BRL', 'R$', 1, 0),
(10, 'Malaysian Ringgit', 'MYR', 'RM', 1, 0),
(11, 'Philippine Peso', 'PHP', 'P', 1, 0),
(12, 'Swiss Franc', 'CHF', '&euro;', 1, 0);

DROP TABLE IF EXISTS `email_settings`;
CREATE TABLE IF NOT EXISTS `email_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(111) NOT NULL,
  `name` varchar(111) NOT NULL,
  `value` varchar(111) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


INSERT INTO `email_settings` (`id`, `code`, `name`, `value`, `created`) VALUES
(1, 'MAILER_TYPE', 'Mailer Type', '1', 2011),
(2, 'SMTP_PORT', 'SMTP Port', '', 2011),
(3, 'SMTP_USER', 'SMTP Username', '', 2011),
(4, 'SMTP_PASS', 'SMTP Password', '', 2011),
(5, 'MAILER_MODE', 'Mailer Mode', 'html', 2011);

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(64) CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `mail_subject` text CHARACTER SET utf8 NOT NULL,
  `email_body_text` text CHARACTER SET utf8 NOT NULL,
  `email_body_html` text CHARACTER SET ucs2 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;


INSERT INTO `email_templates` (`id`, `type`, `title`, `mail_subject`, `email_body_text`, `email_body_html`) VALUES
(40, 'refferal_invite', 'Refferal Invitation', '{username} has invited you to {site_name}', 'Hi user,\n\n{username} wants you to save money with {site_name}\n\n{dynamic_content}\n\n{click_here}\n\n--\nThanks and Regards,\nAdmin\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\n<tbody>\n<tr>\n<td>Hi User,</td>\n</tr>\n<tr>\n<td>\n<p>{username} wants you to save money with {site_name}</p>\n<p>{dynamic_content}</p>\n<p>{click_here} To Started Now!</p>\n</td>\n</tr>\n<tr>\n<td>\n<p style="margin: 0 10px 0 0;">--</p>\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\n<p style="margin: 0 10px 0 0;">Admin</p>\n<p style="margin: 0px;">{site_name}</p>\n</td>\n</tr>\n</tbody>\n</table>'),
(44, 'tc_book_to_admin', 'Admin notification for  Travel cretid booking', ' {traveler_name} sent the reservation request by using his Travel Cretids', 'Hello Admin,\r\n\r\n{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time} by using his Travel Credits.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nMarket Price : {market_price}\r\nPayed Amount : {payed_amount}\r\nTravel Credits : {travel_credits} \r\nHost Name : {host_name}\r\nHost Email Id : {host_email_id} \r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time} by using his Travel Credits.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Market Price : {market_price}</p>\r\n<p>Payed Amount : {payed_amount}</p>\r\n<p>Travel Credits : {travel_credits}</p>\r\n<p>Host Name : {host_name}</p>\r\n<p>Host Email Id : {host_email_id}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(45, 'tc_book_to_host', 'Host notification for  Travel cretid booking', ' {traveler_name} sent the reservation request by using his Travel Cretids', 'Hello {username},\r\n\r\n{traveler_name}sent the reservation request to book your {list_title} place on {book_date} at {book_time} by using his Travel Credits.\r\n\r\nWe will contact you with the appropriate payment.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nPrice : {market_price}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {username} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book your {list_title} place on {book_date} at {book_time} by using his Travel Credits.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Price : {market_price}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(46, 'admin_mass_email', 'Admin mass email', '{subject}', 'Hi User,\r\n\r\n{dynamic_content}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi User,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{dynamic_content}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(47, 'user_vouch', 'Vouch', 'Please vouch for {username}', 'Hello User,\r\n\r\n{username} is planning to start traveling like a human--its more affordable and fun than a hotel. Can you tell us why your friend is worth traveling with? Your recommendation will appear on your friends {site_name} profile and will help him/her be trusted by other travelers and hosts on the site.\r\n\r\nClick the below link to have a Recommendation for {username}\r\n{click_here}\r\n\r\nBy the way, will you be traveling soon? We have great people all over the world that you can stay with for less than the cost of a hotel. You can save $10 when you book using the coupon RECOMMENDATION on the payment screen.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi User,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{username} is planning to start traveling like a human--its more affordable and fun than a hotel. Can you tell us why your friend is worth traveling with? Your recommendation will appear on your friends {site_name} profile and will help him/her be trusted by other travelers and hosts on the site.</p>\r\n<p>{click_here} to have a Recommendation for {username}</p>\r\n<p>By the way, will you be traveling soon? We have great people all over the world that you can stay with for less than the cost of a hotel. You can save $10 when you book using the coupon RECOMMENDATION on the payment screen.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(48, 'host_reservation_notification', 'Reservation notification for host', 'The Reservation was requested by  {traveler_name}', 'Hello {username},\r\n\r\n{traveler_name} booked the {list_title} place on {book_date} at {book_time}.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nPrice : {market_price}\r\n\r\nPlease give the confirmation by clicking the below action.\r\n{action_url}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>Hi {username} ,</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name} booked the {list_title} place on {book_date} at {book_time}.</p>\r\n<br />\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Price : {market_price}</p>\r\n<br />\r\n<p>Please give the confirmation by clicking the below action.</p>\r\n<p>{action_url}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(49, 'traveller_reservation_notification', 'Reservation notification for  traveller', 'Your Reservation Request Is Succesfully Sent', 'Hello {traveler_name},\r\n\r\nYour reservation request is successfully sent to the appropriate host.\r\n\r\nPlease wait for his confirmation.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Your reservation request is successfully sent to the appropriate host.</p>\r\n<p>Please wait for his confirmation.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(50, 'admin_reservation_notification', 'Reservation notification for  administrator', '{traveler_name} sent the reservation request to {host_name}', 'Hello Admin,\r\n\r\n{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time}.\r\n\r\nDetails as follows,\r\n\r\nTraveler Name : {traveler_name}\r\nContact Email Id : {traveler_email_id}\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nMarket Price : {market_price}\r\nHost Name : {host_name}\r\nHost Email Id : {host_email_id} \r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name}sent the reservation request to book the {list_title} place on {book_date} at {book_time}.</p>\r\n<p>Details as follows,</p>\r\n<p>Traveler Name : {traveler_name}</p>\r\n<p>Contact Email Id : {traveler_email_id}</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Market Price : {market_price}</p>\r\n<p>Host Name : {host_name}</p>\r\n<p>Host Email Id : {host_email_id}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(51, 'traveler_reservation_granted', 'Traveler : After Reservation granted', 'Congrats! Your reservation request is granted', 'Hi {traveler_name},\r\n\r\nCongratulation, Your reservation request is granted by {host_name} for {list_name}.\r\n\r\nBelow we mentioned his contact details,\r\n\r\nFirst Name : {Fname}\r\nLast Name : {Lname}\r\nLive In : {livein}\r\nPhone No : {phnum}\r\n\r\nHost Message : {comment} \r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Congratulation, Your reservation request is granted by {host_name} for {list_name}.</p>\r\n<p>Below we mentioned his contact details,</p>\r\n<p>First Name : {Fname}</p>\r\n<p>Last Name : {Lname}</p>\r\n<p>Live In : {livein}</p>\r\n<p>Phone No : {phnum}</p>\r\n<p>Host Message : {comment}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(52, 'traveler_reservation_declined', 'Traveler : After reservation declined', 'Sorry! Your reservation request is denied', 'Hi {traveler_name},\r\n\r\nSorry, Your reservation request is dined by {host_name} for {list_title}.\r\n\r\nHost Message : {comment} \r\n\r\nSoon, We will contact you with the appropriate payment.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your reservation request is dined by {host_name} for {list_title}.</p>\r\n<p>Host Message : {comment}</p>\r\n<p>Soon, We will contact you with the appropriate payment.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(60, 'traveler_reservation_cancel', 'Traveler : After reservation canceled', '{traveler_name} canceled your confirmed reservation', 'Hi {host_name},\r\n\r\nSorry, Your confirmed reservation is dined by {traveler_name} for {list_title}.\r\n\r\nHost Message : {comment} \r\n\r\nIf you have any other queries, please feel free to contact us.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your confirmed reservation is dined by {traveler_name} for {list_title}.</p>\r\n<p>Host Message : {comment}</p>\r\n<p>If you have any other queries, please feel free to contact us.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(53, 'traveler_reservation_expire', 'Traveler : Reservation Expire', 'Sorry! Your reservation request is expire', 'Hi {traveler_name},\r\n\r\nSorry, Your reservation request is expire by {host_name} for {list_title}.\r\n\r\nSoon, We will contact you with the appropriate payment.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Sorry, Your reservation request is expire by {host_name} for {list_title}.</p>\r\n<p>Soon, We will contact you with the appropriate payment.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(54, 'host_reservation_expire', 'Host : Reservation Expire', 'Reservation request expire for your host', 'Hi {host_name},\r\n\r\nReservation request expire for {list_title} that booked by {traveler_name}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Reservation request expire for {list_title} that booked by {traveler_name}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(55, 'admin_reservation_expire', 'Admin : Reservation Expire', 'Reservation request expired by  {host_name}', 'Hi Admin,\r\n\r\n{traveler_name} reservation request is expired by {host_name} for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}\r\n', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name} reservation request is expired by {host_name} for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(56, 'host_reservation_granted', 'Host : After Reservation Granted', 'You have accepted the {traveler_name} reservation request', 'Hi {host_name},\r\n\r\nYou have accepted the {traveler_name} reservation request for {list_title}.\r\n\r\nBelow we mentioned his contact details,\r\n\r\nFirst Name : {Fname}\r\nLast Name : {Lname}\r\nLive In : {livein}\r\nPhone No : {phnum}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have accepted the {traveler_name} reservation request for {list_title}.</p>\r\n<p>Below we mentioned his contact details,</p>\r\n<p>First Name : {Fname}</p>\r\n<p>Last Name : {Lname}</p>\r\n<p>Live In : {livein}</p>\r\n<p>Phone No : {phnum}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(57, 'admin_reservation_granted', 'Admin : After Reservation granted', '{host_name} accepted the {traveler_name} reservation request', 'Hi Admin,\r\n\r\n{host_name} accepted the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{host_name} accepted the {traveler_name} reservation request for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(58, 'host_reservation_declined', 'Host : After Reservation Declined', 'You have declined the {traveler_name} reservation request', 'Hi {host_name},\r\n\r\nYou have declined the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {host_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have declined the {traveler_name} reservation request} for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(59, 'admin_reservation_declined', 'Admin : After Reservation Declined', '{host_name} declined the {traveler_name} reservation request', 'Hi Admin,\r\n\r\n{host_name} declined the {traveler_name} reservation request for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{host_name} declined the {traveler_name} reservation request for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(61, 'admin_reservation_cancel', 'Admin : After reservation canceled', '{traveler_name} canceled the {host_name} confirmed reservation', 'Hi Admin,\r\n\r\n{traveler_name} canceled the {host_name} confirmed reservation for {list_title}.\r\n\r\n--\r\nThanks and Regards,\r\n\r\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Admin,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{traveler_name} canceled the {host_name} confirmed reservation for {list_title}.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(62, 'host_reservation_cancel', 'Host : After reservation canceled', 'You have canceled the {host_name} confirmed reservation', 'Hi {traveler_name},\r\n\r\nYou have canceled the {traveler_name} confirmed reservation for {host_name}.\r\n\r\nSure we will contact you soon, if there is any payment balance.\r\n\r\nAnd also, if you have any other queries, please feel free to contact us. \r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {traveler_name} ,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>You have canceled the {traveler_name} confirmed reservation for {host_name}.</p>\r\n<p>Sure we will contact you soon, if there is any payment balance.</p>\r\n<p>And also, if you have any other queries, please feel free to contact us.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 0 10px 0;">Admin,</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(63, 'forgot_password', 'Forgot Password', 'Forgot Password', 'Dear Member,\r\n\r\nBelow we have mentioned your account details.\r\n\r\nHere we go,\r\n\r\nEmail_id : {email}\r\n\r\nPassword : {password}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Dear Member,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Below we have mentioned your account details.</p>\r\n<p>Here we go,</p>\r\n<p>Email_id : {email}</p>\r\n<p>Password : {password}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(64, 'users_signin', 'Users Signin', 'Wecome to  {site_name}', 'Dear Member,\r\n\r\nPleasure to meet you and welcome to the {site_name}.\r\n\r\nBelow we have mentioned your account details.\r\n\r\nHere we go,\r\n\r\nEmail_id : {email}\r\n\r\nPassword : {password}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Dear Member,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Pleasure to meet you and welcome to the {site_name}.</p>\r\n<p>Below we have mentioned your account details.</p>\r\n<p>Here we go,</p>\r\n<p>Email_id : {email}</p>\r\n<p>Password : {password}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(65, 'reset_password', 'Reset Password', 'Reset Password', 'Dear Member,\r\n\r\nBelow we have mentioned your new account details.\r\n\r\nHere we go,\r\n\r\nPassword : {password}\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Dear Member,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Below we have mentioned your new account details.</p>\r\n<p>Here we go,</p>\r\n<p>Password : {password}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0 10px 0 0;">Admin</p>\r\n<p style="margin: 0px;">{site_name}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(66, 'admin_payment', 'Admin payment to Host', 'Admin payed your fees for {list_title}', 'Hello {username},\r\n\r\nWe have payed your fees for {list_title}.\r\n\r\nDetails as follows,\r\n\r\nPlace Name : {list_title}\r\nCheck in : {checkin}\r\nCheck out : {checkout}\r\nPrice : {payed_price}\r\nPayment Through : {payment_type}\r\nPay Id: {pay_id}\r\nPayed Date : {payed_date}\r\n\r\n\r\n--\r\nThanks and Regards,\r\n\r\nAdmin\r\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>Hi {username} ,</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>We have payed your fees for {list_title}.</p>\r\n<br />\r\n<p>Details as follows,</p>\r\n<p>Place Name : {list_title}</p>\r\n<p>Check in : {checkin}</p>\r\n<p>Check out : {checkout}</p>\r\n<p>Price : {market_price}</p>\r\n<p>Payment Through : {payment_type}</p>\r\n<p>Pay Id : {pay_id}</p>\r\n<p>Payed Date : {payed_date}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\r\n<p style="margin: 0px;">{site_name} Team</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(67, 'contact_form', 'Contact Form', 'Message received from contact form', 'Hi Admin,\n\nA message received from contact us page on {date} at {time}.\n\nDetails as follows,\n\nName : {name}\n\nEmail : {email}\n\nMessage : {message}\n\n--\nThanks and Regards,\n\n{site_name} Team', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\n<tbody>\n<tr>\n<td>Hi Admin,</td>\n</tr>\n<tr>\n<td>\n<p>A message received from contact us page on {date} at {time}.</p>\n<p>Details as follows,</p>\n<p>Name : {name}</p>\n<p>Email : {email}</p>\n<p>Message : {message}</p>\n</td>\n</tr>\n<tr>\n<td>\n<p style="margin: 0 10px 0 0;">--</p>\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\n<p style="margin: 0px;">{site_name} Team</p>\n</td>\n</tr>\n</tbody>\n</table>'),
(68, 'invite_friend', 'Invite My Friends', '{username} invite You.', 'Hi Friend''s,\n\n{username} wants you to invite {site_name}\n\n\n{click_here}\n\n--\nRegards,\n{username}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi Friends,</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>{username} wants you to invite</p>\r\n<p>{site_name}</p>\r\n<p>{dynamic_content}</p>\r\n<p>&nbsp;{click_here}</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p style="margin: 0 10px 0 0;">--</p>\r\n<p style="margin: 0 0 10px 0;">Regards,</p>\r\n<p style="margin: 0px;">{username}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>');

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(128) CHARACTER SET utf8 NOT NULL,
  `faq_content` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `ical_import`;
CREATE TABLE IF NOT EXISTS `ical_import` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `list_id` int(50) NOT NULL,
  `url` varchar(500) NOT NULL,
  `last_sync` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `joinus`;
CREATE TABLE IF NOT EXISTS `joinus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `joinus` (`id`, `name`, `url`) VALUES
(1, 'Twitter', 'http://twitter.com/cogzidel'),
(2, 'Facebook', 'https://www.facebook.com/cogzidel'),
(3, 'Google', 'https://plus.google.com/'),
(4, 'Youtube', 'http://www.youtube.com/results?search_query=cogzidel');

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(7) NOT NULL,
  `name` varchar(30) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `language` (`id`, `code`, `name`) VALUES
(1, 'en', 'English'),
(2, 'fr', 'French'),
(3, 'it', 'Italian'),
(4, 'gr', 'German'),
(5, 'po', 'Portuguese'),
(6, 'sp', 'Spanish');

DROP TABLE IF EXISTS `list`;
CREATE TABLE IF NOT EXISTS `list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8,
  `country` varchar(50) NOT NULL,
  `exact` int(11) NOT NULL,
  `directions` text CHARACTER SET utf8,
  `lat` decimal(18,14) NOT NULL,
  `long` decimal(18,14) NOT NULL,
  `property_id` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `beds` int(11) NOT NULL,
  `bed_type` varchar(50) NOT NULL,
  `bathrooms` float NOT NULL,
  `amenities` varchar(111) NOT NULL,
  `title` text CHARACTER SET utf8,
  `desc` text CHARACTER SET utf8,
  `capacity` int(11) NOT NULL,
  `cancellation_policy` varchar(50) NOT NULL,
  `street_view` smallint(6) NOT NULL,
  `price` int(11) NOT NULL,
  `sublet_price` int(50) NOT NULL,
  `sublet_status` enum('0','1') NOT NULL,
  `sublet_startdate` varchar(150) NOT NULL,
  `sublet_enddate` varchar(150) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `manual` text CHARACTER SET utf8 NOT NULL,
  `is_enable` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `page_viewed` bigint(20) NOT NULL,
  `review` int(11) NOT NULL DEFAULT '0',
  `created` int(31) NOT NULL,
  `neighbor` varchar(60) NOT NULL,
  `is_featured` int(11) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

INSERT INTO `list` (`id`, `user_id`, `address`,`country`, `exact`, `directions`, `lat`, `long`, `property_id`, `room_type`, `bedrooms`, `beds`, `bed_type`, `bathrooms`, `amenities`, `title`, `desc`, `capacity`, `street_view`, `price`, `sublet_price`, `sublet_status`, `sublet_startdate`, `sublet_enddate`, `currency`, `email`, `phone`, `manual`, `is_enable`, `status`, `page_viewed`, `review`, `created`, `neighbor`,`is_featured`) VALUES
(1, 1, 'Dunas Altas, El Cipras (Guarnician Militar), Zona 4, 22785 Ensenada Municipality, Baja California, Mexico','Mexico', 0, '', 31.78962130000000, -116.60434580000003, 6, 'Private room', 1, 1, 'Airbed', 1, '4,7,10,11', 'Modern Rustic Beach House with Pool', 'This unique house is a 3 bedrooms beach house with pool designed by architect Jorge Gracia recently featured in in the architectural books ''21st Century - 150 of the World''s Best'' and ''Architecture Now - Houses'', published by TASCHEN.<br />\n<br />\nThe architecture mixes pure modernism and Mexican rustic style in a unique combination, allowing guests to experience simple but sophisticated comfort in a tasteful minimalist environment.<br />\n<br />\nABOUT THE ARCHITECTURE<br />\n<br />\nThe concept behind the design was to recreate the spirit of the vacation house of the fifties and sixties where family and friends would gather in a modern minded place without pretense or luxury to enjoy each other''s company.<br />\n<br />\nThe house is a clean space composed of three simple bedrooms disposed around a central living space which includes a kitchen with bar and a living room area wide open to a terrace which ends at the edge of the pool. You will enjoy your daily dining, swimming, conversation or card games in close intimacy with your friends or family.<br />\nMost furnishing are custom designed and hand crafted by local artisans. Locally available materials such as concrete, tiles, cement, steel and wood were used raw to minimize the impact on the land. The house is cooled by natural ventilation.<br />\n<br />\nLOCATION<br />\n<br />\nLocated a few miles north of the ''Pueblo Magico'' of Todos Santos in the Las Tunas area, the house faces the beach and is less than a minute walk to the ocean, with views on La Cachora surf break, in a peaceful and contemplative landscape planted with palm trees, blue agaves and bougainvilleas among other plants.<br />\n<br />\nTodos Santos is magical destination year round. From the foothills of the Sierra de la Laguna Mountains, the pueblo looks towards the Pacific Ocean amongst farm crops, palm groves, mango and avocado-trees.<br />\nBesides beaches, surfing and eco tourism, Todos Santos offers fine dining, a lively art scene and interesting crafts. You will love strolling past colonial buildings, the mission of Nuestra Seaora del Pilar, art galleries and artisans shops or hidden gardens.<br />\nPainters, writers, sculptors, artisans, American and European expatriates and regular locals live together in harmony and make Todos Santos a very interesting place to experience.<br />\n<br />\nNearest airports: San jose Del Cabo (1.5 hour) / La Paz (1 hour)<br />\n<br />\nTHINGS TO DO<br />\n<br />\nSunbath on the terrace and swim in your private pool while looking at the ocean.<br />\nTake mile long walks on the vast empty beach located in front of the house just beyond the sand dunes, as you watch whales jump in and out of the sea (January to March).<br />\nSurf one of the many great surf beaches in the area or swim at the local beaches (Note: swimming in front of the house is not recommended due to strong currents).<br />\n<br />\nCatch your own fish from the beach or explore the wilderness of the Baja desert.<br />\nVisits art galleries and artisan shops.<br />\nDine in town at one the first class restaurants or at one of the many delicious local taco stands.<br />\nGo horseback riding on the beach.<br />\nGaze at the stars in the perfectly clear nights gently cooled by the ocean breeze.<br />\nThe possibility are endless...<br />\n<br />\nA SPECIAL PLACE TO RELAX AND ENJOY WITH FRIENDS AND FAMILY<br />\n<br />\nOur wish is to foster interaction between guests in a relaxing environment away from modern life disturbances so we have no TV or video games. We have a music player with a CD library of world music, jazz and other relaxing music (you can connect your ipod) and a small library with interesting books in English and French as well as cards and board games.<br />\n<br />\nIf you wish to watch movies, just bring your laptop and a bunch of DVDs.<br />\nWe have no internet access in the house but it is easily available in town for free at several cafes so you can check your email in front of a latte.', 1, 0, 250, 0, '0', '', '', 'USD', '', '', '', 1, 1, 1, 0, 1366501441, 'nothing select',1),
(2, 1, 'Carrera 1C # 162A-2 a 162A-100, Bogota, Cundinamarca, Colombia','Colombia', 0, '', 4.73524780000000, -74.01826100000000, 5, 'Private room', 1, 1, 'None', 0, '2,8,14,18,20', 'New beautiful apartment in Spb', 'New beautiful apartment in the centre of the city in a new house with a balcony overlooking the old area of Sankt Petersburg. There''re all the amenities including TV, DVD, Wi-FI. In the apartment ( 44 sq.m. ) are 2 rooms - an equipped kitchen-livingroom (16 sq.m.) with utensils electric stove, oven, microwave, refrigerator, big sofa for 2 person and sittingroom (19 sq.m.) with TV, DVD, microwave, small refrigerator, table, big sofa for 2 person and lifting bed for 1 person. Protected courtyard, around the house is light, the camcorder. Behind the house is a large courtyard, where you will always find a place to park. The house is locate on a quiet one-way street in a few min. On foot is the main street of the area with public transport and lots of chafes, restaurants, shops (24 hours shop is with 5 min. walk). In our house is supermarket "Miratorg" (9 a.m.- 23 p.m.- open). The nearest metro station is Frunzenskaya (5-7 min.walk) not so far from the metro station is the Institute of Technologu (15 min). In 10 min. Walk is the big shopping complex "Warshavskiy express" with lots of cafes, shops, cinema and sports. In 10 min. by the metro (Sennay metro station) are large shopping complexes with internal parking. In 10 min. drive are Baltic and Vitebsk train station and a bit further, in about 15-20 min. driving is Moscov train terminal. Airport about 20 min. driving to straight main street. Sorry, but Smokking is not allowed!', 1, 0, 221, 0, '0', '', '', 'PHP', '', '', '', 1, 1, 1, 0, 1366502043, 'nothing select',1),
(3, 1, '184, 64606 Palva County, Estonia','Estonia', 0, NULL, 58.21135870000001, 27.16648880000003, 7, 'Shared room', 1, 0, '', 0, '', 'Sunny Room in Brooklyn', '10 minutes to Williamsburg, 20 minutes to manhattan!<br />\n<br />\nA sunny private room with a Queen size futon and big closet in a new renovated apartment (this March), with a SHARED bathroom , <br />\nhas Wi-Fi, it''s on the first floor, so no need to drag your heavy suitcase up down stairs. <br />\nthe street is quite and safe, the building has it''s own washer and dryer, (though we still need to pay, but we don''t have to walk far to do the laundry),. <br />\n3 minutes walk to M train Seneca Stop, 6 minutes walk to L & M train Myrtle-Wyckoff stop. <br />\nthe L & M both takes you to Manhattan in about 15 minutes ride, <br />\n(than depends on where you are going to)<br />\n<br />\non the M train you can totally enjoy the sky ride, seeing Brooklyn views, takes you directly to the Central Park, MOMA, China Town, Queens, 5 Pointz (the amazing graffiti scene/blocks/gallery) etc.<br />\n<br />\nthe L train connects the most subway lines, hop on the L than very easy to switch to other places that you possibly wanna go to, also directly take you to Williamsburg, east village, Chelsea area, famous sky park - The High Line. and Bushwick (new area for underground scene/artists/musicians),<br />\n<br />\nthis is a super functional neighborhood, 3 minutes walk to Myrtle Ave that has all kinds of stores, you can get everything you possibly need, and many restaurants around.<br />\n<br />\nI have blanket ,fresh sheets , pillow, ,towel for you, and will try to provide things you need while your staying.:)<br />\n<br />\nand you will have the apt key so you can in and out as you please, 24 hours!<br />\n<br />\nBTW I am in my early 30 , I am a teacher also make some indie music, my music project related to electro-ethnic-noise-post punk. (but don''t worry- I won''t practice at home!) <br />\nmy husband makes small fun puppet shows, is an artist love to use recycling materials make puppets. we have a 5 years old, but he is shy when he is around strangers, so he won''t bother you basically.:)', 1, 0, 125, 0, '0', '', '', 'EUR', '', '', '', 1, 1, 1, 0, 1366502307, 'nothing select',1);


DROP TABLE IF EXISTS `list_photo`;
CREATE TABLE IF NOT EXISTS `list_photo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `list_id` bigint(20) NOT NULL,
  `name` varchar(333) NOT NULL,
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
INSERT INTO `list_photo` (`id`, `list_id`, `name`, `is_featured`, `created`) VALUES
(1, 1, 'ef3e4692d7704ec4a205976290f7ceaf', 1, 1366501589),
(2, 1, '00f71a669e5117773846d24468f6d893', 0, 1366501598),
(3, 1, '9535a4f7affb7493e78521ade4bc3fe6', 0, 1366501606),
(4, 1, 'f92676daed07e0a969a30fae9908c91f', 0, 1366501615),
(5, 2, '2b24a7e41aa366465ce276654428468c', 1, 1366502093),
(6, 2, '7723fc9da2f5525bec31b1dfd77e82a5', 0, 1366502101),
(7, 3, 'b6f435cecd6579ecefda0cf80de1e533', 1, 1366502345),
(8, 3, 'e5cd5a8bce69ee0529fd799c61b51cc9', 0, 1366502375),
(9, 3, '1cc3fad8c398bd3cb5236bc6af22963c', 0, 1366502391);


DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` bigint(20) unsigned NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `contact_id` INT(11) NOT NULL,
  `conversation_id` int(11) NOT NULL DEFAULT '0',
  `userby` int(11) NOT NULL,
  `userto` int(11) NOT NULL,
  `subject` varchar(70) NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `created` int(31) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `is_starred` tinyint(4) NOT NULL,
  `message_type` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `message_type`;
CREATE TABLE IF NOT EXISTS `message_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `message_type` (`id`, `name`, `url`) VALUES
(1, 'Reservation Request', 'trips/request'),
(2, 'Conversation', 'trips/conversation'),
(3, 'Message', 'trips/conversation'),
(4, 'Review Request', 'trips/review_by_host'),
(5, 'Review Request', 'trips/review_by_traveller'),
(6, 'Inquiry', 'trips/conversation'),
(7, 'Contacts Request', 'contacts/request'),
(8, 'Contacts Response', 'contacts/response'),
(9, 'Referrals', 'trips/conversation');

DROP TABLE IF EXISTS `metas`;
CREATE TABLE IF NOT EXISTS `metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(111) NOT NULL,
  `name` varchar(300) NOT NULL,
  `title` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

INSERT INTO `metas` (`id`, `url`, `name`, `title`, `meta_description`, `meta_keyword`) VALUES
(1, 'account/index', 'Edit_account_details', 'Edit account details', '', ''),
(2, 'account/payout', 'Your_Payment_Method_details', 'Your Payment Method details', '', ''),
(3, 'account/setDefault', 'Set_Default_Payout_Preferences', 'Set Default Payout Preferences', '', ''),
(4, 'account/transaction', 'Your_Transaction_Details', 'Your Transaction Details', '', ''),
(5, 'calendar/single', 'Calendar', 'Calendar', '', ''),
(6, 'home/dashboard', 'Dashboard', 'Dashboard', '', ''),
(7, 'hosting/index', 'Your_Hosting_data', 'Your Hosting data', '', ''),
(8, 'hosting/change_status', 'Manage_Listings', 'Manage Listings', '', ''),
(9, 'hosting/sort_by_status', 'Manage Listings', 'Manage Listings', '', ''),
(10, 'hosting/my_reservation', 'My_Reservations', 'My Reservations', '', ''),
(11, 'hosting/policies', 'Stand_Bys', 'Policies', '', ''),
(12, 'info/index', 'Access_Deny', 'Access Deny', '', ''),
(13, 'info/deny', 'Access_Deny', 'Access Deny', '', ''),
(14, 'info/how_it_works', '', '', '', ''),
(15, 'listpay/index', 'Payment_Option', 'Payment Option', '', ''),
(16, 'message/inbox', 'Inbox', 'Inbox', '', ''),
(17, 'pages/contact', 'Contact_Us', 'Contact Us', '', ''),
(18, 'pages/faq', 'FAQs', 'FAQs', '', ''),
(19, 'payments/form', 'Confirm_your_booking', 'Confirm your booking', '', ''),
(20, 'referrals/index', 'Invite_Your_Friends', 'Invite Your Friends', '', ''),
(21, 'referrals/email', 'Invite_Your_Friends -Email', 'Invite Your Friends - Email', '', ''),
(22, 'referrals/tell_a_friend', 'Tell_A_Friend', 'Tell A Friend', '', ''),
(23, 'rooms/index', '', '', '', ''),
(24, 'rooms/newlist', 'List_Your_property', 'List your property', '', ''),
(25, 'rooms/edit', 'Edit_your_Listing', 'Edit your Listing', '', ''),
(26, 'rooms/edit_photo', 'Add_photo_for_this_listing', 'Add photo for this listingx', '', ''),
(27, 'rooms/edit_price', 'Edit_the_price_information_for_your_site', 'Edit the price information for your site', '', ''),
(28, 'rooms/change_status', 'Manage_Listings', 'Manage Listings', '', ''),
(29, 'search/index', 'Search_Elements', 'Search Elements', '', ''),
(30, 'travelling/current_trip', 'Your_Current_Trips', 'Your Current Trips', '', ''),
(31, 'travelling/upcomming_trips', 'Your_upcomming_trips', 'Your upcomming trips', '', ''),
(32, 'travelling/previous_trips', 'Your_Previous_Trips_Trips', 'Your Previous Trips ', '', ''),
(33, 'travelling/starred_items', 'List_your_stared_Item', 'List your starred Items', '', ''),
(34, 'travelling/host_details', 'Host_Details', 'Host Details', '', ''),
(35, 'travelling/billing', 'Reservation_Request', 'Reservation Request', '', ''),
(36, 'trips/request', 'Reservation_Request', 'Reservation Request', '', ''),
(37, 'trips/conversation', 'Conversations', 'Conversations', '', ''),
(38, 'trips/review_by_host', 'Review', 'Review', '', ''),
(39, 'trips/review_by_traveller', 'Review', 'Review', '', ''),
(40, 'host_review', 'View_Your_Review', 'View Your Review', '', ''),
(41, 'trips/traveler_review', 'View_your_review', 'View your review', '', ''),
(42, 'users/edit', 'Edit_your_Profile', 'Edit your Profile', '', ''),
(43, 'users/recommendation', 'Your_recommendation_details', 'Recommendation details', '', ''),
(44, 'users/reviews', 'Your_Reviews_and_Recommendation', 'Your Reviews and Recommendation', '', ''),
(45, 'users/vouch', 'Recommend_your_friends', 'Recommend your friends', '', ''),
(46, 'users/signup', 'Sign_Up_for_the_site', 'Sign Up for the site', '', ''),
(47, 'users/signin', 'Sign_In / Sign_Up', 'Sign In / Sign Up', '', ''),
(48, 'uers/login', 'Sign_In / Sign_up', 'Sign In / Sign up', '', ''),
(49, 'users/logout', 'Logout_Shortly', 'Logout Shortly', '', ''),
(50, 'users/change_password', 'Change_Password', 'Change Password', '', ''),
(51, 'pages/cancellation_policy', 'cancellation_policy', 'Cancellation Policy', '', ''),
(52, 'account/mywishlist', 'My Wishlist', 'My Wishlist', 'My Wishlist', 'My Wishlist'),
(53, 'home/popular', 'Popular', 'Popular', '', ''),
(54, 'home/friends', 'Friends', 'Friends', '', ''),
(55, 'home/neighborhoods', 'Neighborhoods', 'Neighborhoods', '', ''),
(56, 'home/help', 'Help', 'Help', '', ''),
(57, 'users/verify', 'Verification', 'Verification', '', ''),
(58, 'home/verify', 'Verify', 'Verify', '', ''),
(59, 'neighbourhoods/detail_place', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods'),
(60, 'neighbourhoods/city_places', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods'),
(61, 'neighbourhoods/city', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods', 'Neighbourhoods'),
(62, 'users/view_fb_popup', 'Facebook Signup', 'Facebook Signup', 'Facebook Signup', 'Facebook Signup');

DROP TABLE IF EXISTS `neighbor_area`;
CREATE TABLE IF NOT EXISTS `neighbor_area` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `city_id` int(50) NOT NULL,
  `area` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `neighbor_city`;
CREATE TABLE IF NOT EXISTS `neighbor_city` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `Country` varchar(80) NOT NULL,
  `State` varchar(80) NOT NULL,
  `City` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(111) NOT NULL,
  `page_title` varchar(111) NOT NULL,
  `page_url` varchar(111) NOT NULL,
  `is_footer` tinyint(4) NOT NULL,
  `is_under` varchar(25) NOT NULL,
  `page_content` text NOT NULL,
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

INSERT INTO `page` (`id`, `page_name`, `page_title`, `page_url`, `is_footer`, `page_content`, `created`) VALUES
(1, 'Really Cool Destinations', 'Really Cool Destinations', 'really_cool_destinations', 0, '<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique. Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>', 1323792509),
(2, 'Fun Company News', 'Fun Company News', 'fun_company_news', 0, '<h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>', 1323793001),
(3, '', 'Photo Tips', 'photo_tips', 0, '<div class="inner_header"><h2>Photo Tips</h2></div>\r\n\r\n<h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>', 1323793059),
(4, '', 'Recommendation Help', 'recommendation_help', 0, '<div class="inner_header"><h2>Recommendation Help</h2></div>\r\n\r\n<h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>', 1323793186),
(5, 'Why Host?', 'Why Host?', 'why_host', 0, '<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique. Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>', 1323793245),
(6, '', 'About Us', 'about', 0, '<div class="inner_header"><h2>About Us</h2></div><p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique. Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>', 0),
(7, '', 'Press', 'press', 0, '<div class="inner_header"><h2>Press</h2></div><h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>', 0),
(8, '', 'Policies', 'policies', 0, '<div class="inner_header"><h2>Policies</h2></div><h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n  <li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n', 0),
(9, 'Terms & Privacy', 'Terms & Privacy', 'terms', 0, '<h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n\r\n', 0);
INSERT INTO `page` (`id`, `page_name`, `page_title`, `page_url`, `is_footer`, `page_content`, `created`) VALUES
(10, 'Responsible Hosting', 'Responsible Hosting', 'responsible_hosting', 0, '<h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h4>Integer velit nunc faucibus idmollir</h4>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li>Ut rhoncus imperdiet augue sit amet egestas</li>\r\n<li>Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n\r\n<h4>Aliquam gravida nisl non libero ullamcorper placerat</h4>\r\n\r\n<div class="inner_terms">\r\n<ul>\r\n  <li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n</ul>\r\n</div>\r\n\r\n\r\n<h4>Nam eget nisl feugiat augue egestas</h4>\r\n<div class="inner_terms">\r\n<ul>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</li>\r\n<li>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n<li>Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</li>\r\n<li>Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</li>\r\n<li>Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</li>\r\n\r\n</div>', 0),
(11, '', 'Social Connections', 'social', 0, '<div class="inner_header"><h2>Social Connections</h2></div><h3>Nam aliquam dolor?</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n\r\n<h3>Phasellus sem?</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis?</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n<h3>Donec gravida nulla non ante semper fringilla in ante justo?</h3>\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<h3>Aliquam gravida nisl non libero ullamcorper placerat sed nisl lacus?</h3>\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n<h3>Nunc porttitor sagittis?</h3>\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis?</h3>\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>', 0),
(12, '', 'Travel', 'travel', 0, '<div class="inner_header"><h2>Travel</h2></div><h4>Aliquam vitae congue tortor</h4>\r\n<p>Praesent in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent dui nibh, placerat id placerat nec, facilisis vitae lorem.Ut at ante non quam posuere sollicitudin. Sed vel libero tellus. Nam aliquam dolor vitae risus lacinia tristique.</p>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n<h3>Phasellus sem</h3>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n<h3>Nunc porttitor sagittis</h3>\r\n\r\n<p>Aliquam vitae congue tortor. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio. Ut elementum ante quis urna auctor sagittis. Nunc porttitor sagittis condimentum. Nullam laoreet elit quis quam lobortis aliquet. Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros.</p>\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n\r\n<p>Duis suscipit interdum sapien, nec vulputate tortor dignissim et. Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius.</p>\r\n\r\n<p>Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel turpis et lacus fermentum congue. Integer fringilla euismod dui, id vehicula ut. Pellentesque placerat dictum diam sit amet porta.</p>\r\n\r\n\r\n<p>Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper pretium varius. Donec gravida nulla non ante semper fringilla. In ante justo, sodales id condimentum sit amet, lobortis ut odio.</p>\r\n<div class="inner_terms">\r\n<ul>\r\n   <li><a href="#">Ut rhoncus imperdiet augue sit amet egestas</a></li>\r\n<li><a href="#">Aliquam gravida nisl non libero ullamcorper placerat. Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio. Integer ullamcorper</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit. Quisque vel</a></li>\r\n<li><a href="#">Phasellus sem tellus, imperdiet eu feugiat vel, laoreet non ligula. Pellentesque eleifend consequat augue eu hendrerit.</a></li>\r\n<li><a href="#">Sed nisl lacus, auctor in posuere vitae, aliquam ut elit. Integer velit nunc, faucibus id mollis pharetra, eleifend at odio.</a></li>\r\n<li><a href="#">Maecenas consequat rhoncus eros. Ut rhoncus imperdiet augue, sit amet egestas odio fermentum sed. Aliquam gravida nisl non libero ullamcorper placerat.</a></li>\r\n<li><a href="#">Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n<li><a href="#">Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</a></li>\r\n</ul>\r\n</div>\r\n\r\n<h3>Nam aliquam dolor</h3>\r\n<p> Sed vitae nibh et felis ornare accum. tiam tristique ornare erat et facilisis. Etiam pretium, massa ut commodo viverra, nunc magna vestibulum risus, a imperdiet quam leo ac mi.</p>\r\n\r\n<p>Nam eget nisl feugiat augue egestas tempus at fermentum tellus. Vestibulum vel orci ante, sed auctor mauris. Nulla a odio id nunc lobortis venenatis. Sed vestibulum elit at urna tincidunt pellentesque. Aenean tristique, massa ac faucibus adipiscing, nunc nulla aliquet orci, vitae pharetra enim erat sit amet magna. Ut pulvinar consequat purus in egestas. Phasellus imperdiet bibendum libero sit amet adipiscing.</p>\r\n\r\n<p>Nulla mauris tellus, aliquam rutrum consectetur eu, pulvinar sit amet est. Integer sodales vulputate arcu eget dictum. Suspendisse nibh dolor, vestibulum a euismod nec, tristique ac quam. Aliquam vitae dolor justo, non aliquet nisl. Maecenas accumsan convallis mattis.</p>', 0),
(13, 'Help', 'Help', 'help', 0, '<div id="View_help" class="inner_pad_top">\r\n<ul>\r\n  		<li><a href="#"> Need help on this page? </a></li>\r\n  		<li><a href="#">Getting Started Guide</a></li>\r\n  		<li><a href="#">How do I sign up?</a></li>\r\n  		<li><a href="#">How do I host on Dropinn?</a></li>\r\n  		<li><a href="#">How do I travel on Dropinn?</a></li>\r\n  		<li><a href="#">Visit our Trust & Safety Center </a></li>\r\n  		<li><a href="#">See all FAQs</a></li>\r\n  		\r\n  	</ul>\r\n</div>', 0);

DROP TABLE IF EXISTS `paykey`;
CREATE TABLE IF NOT EXISTS `paykey` (
  `paykey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `paykey` (`paykey`) VALUES
('AP-9LF47559NN033983K');

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(30) NOT NULL,
  `is_enabled` smallint(6) NOT NULL DEFAULT '0',
  `is_live` smallint(6) NOT NULL DEFAULT '0',
  `is_payout` smallint(6) NOT NULL DEFAULT '0',
  `arrives_on` varchar(111) NOT NULL,
  `fees` varchar(30) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `payments` (`id`, `payment_name`, `is_enabled`, `is_live`, `is_payout`, `arrives_on`, `fees`, `currency`, `note`) VALUES
(2, 'Paypal', 1, 0, 1, 'Instant', 'None', 'USD', 'You can withdraw money from PayPal...\r\n<ul style="list-style-type: disc;list-style-position: inside;">\r\n<li>to your local bank account.</li>\r\n<li>via paper check.</li>\r\n</ul>'),
(3, '2Checkout', 1, 0, 0, 'Instant', 'None', 'USD', ''),
(1, 'creditcard', 0, 0, 0, '', '', '', '');


DROP TABLE IF EXISTS `payment_details`;
CREATE TABLE IF NOT EXISTS `payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` smallint(6) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
INSERT INTO `payment_details` (`id`, `payment_id`, `code`, `name`, `value`) VALUES
(1, 1, 'CC_USER', 'CC Username', 'deepak_1322655871_biz_api1.cogzidel.com'),
(2, 1, 'CC_PASSWORD', 'CC Password', '1322655895'),
(3, 1, 'CC_SIGNATURE', 'CC Signature', 'AIo-7AHt2qiq0pEE3tJz7fN0Av7SAQLEkoN0U2IxKFoFFDs18EmzYOBd'),
(4, 2, 'PAYPAL_ID', 'Paypal Business Id', 'deepak_1322655871_biz@cogzidel.com'),
(5, 3, '2C_VENTOR_ID', '2C Ventor Id', ''),
(6, 3, '2C_SECURITY', '2C Security Code', '');

DROP TABLE IF EXISTS `paymode`;
CREATE TABLE IF NOT EXISTS `paymode` (
  `id` tinyint(4) NOT NULL,
  `mod_name` varchar(111) NOT NULL,
  `is_premium` tinyint(4) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '0',
  `fixed_amount` float NOT NULL,
  `percentage_amount` float NOT NULL,
  `modified_date` varchar(111) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `paymode` (`id`, `mod_name`, `is_premium`, `is_fixed`, `fixed_amount`, `percentage_amount`, `modified_date`) VALUES
(1, 'Host Listing', 0, 1, 0, 0, ''),
(2, 'Guest Booking', 1, 1, 50, 50, ''),
(3, 'Host Accept The Reservation Request', 1, 0, 0, 10, '');

DROP TABLE IF EXISTS `payout_preferences`;
CREATE TABLE IF NOT EXISTS `payout_preferences` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `user_id` int(111) NOT NULL,
  `country` varchar(7) NOT NULL,
  `payout_type` smallint(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `currency` varchar(7) NOT NULL,
  `is_default` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `paywhom`;
CREATE TABLE IF NOT EXISTS `paywhom` (
  `id` int(11) NOT NULL,
  `whom` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `paywhom` (`id`, `whom`) VALUES
(1, 0);

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `price`;
CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL,
  `night` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `guests` smallint(6) NOT NULL,
  `addguests` int(11) NOT NULL,
  `cleaning` int(11) NOT NULL,
  `security` int(11) NOT NULL,
  `currency` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `price` (`id`, `night`, `week`, `month`, `guests`, `addguests`, `cleaning`, `security`, `currency`) VALUES
(1, 250, 1445, 3888, 2, 5, 5, 0, 'USD'),
(2, 221, 155, 258, 1, 5, 5, 0, 'PHP'),
(3, 125, 693, 1890, 1, 5, 0, 0, 'EUR');


DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint(20) NOT NULL,
  `Fname` varchar(255) DEFAULT NULL,
  `Lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `live` text,
  `work` text,
  `phnum` varchar(255) DEFAULT NULL,
  `describe` text,
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `profile_picture`;
CREATE TABLE IF NOT EXISTS `profile_picture` (
  `email` text NOT NULL,
  `src` text,
  `ext` varchar(10)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `property_type`;
CREATE TABLE IF NOT EXISTS `property_type` (
  `id` int(63) NOT NULL AUTO_INCREMENT,
  `type` varchar(63) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

INSERT INTO `property_type` (`id`, `type`) VALUES
(6, 'House'),
(5, 'Apartment'),
(7, 'Bed & Breakfast'),
(8, 'Cabin'),
(9, 'Villa'),
(10, 'Castle'),
(11, 'Dorm'),
(12, 'Treehouse'),
(13, 'Boat');

DROP TABLE IF EXISTS `recommends`;
CREATE TABLE IF NOT EXISTS `recommends` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userby` bigint(20) NOT NULL,
  `userto` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint(20) NOT NULL,
  `list_id` int(111) NOT NULL,
  `userby` int(11) NOT NULL,
  `userto` int(111) NOT NULL,
  `checkin` varchar(50) NOT NULL,
  `checkout` varchar(50) NOT NULL,
  `no_quest` tinyint(4) NOT NULL,
  `currency` varchar(11) NOT NULL,
  `price` float NOT NULL,
  `topay` float NOT NULL,
  `admin_commission` float NOT NULL,
  `credit_type` tinyint(4) NOT NULL,
  `ref_amount` int(111) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `is_payed` tinyint(4) NOT NULL DEFAULT '0',
  `payment_id` tinyint(4) NOT NULL,
  `payed_date` varchar(111) NOT NULL,
  `book_date` int(31) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `hostemailpaypal` varchar(255) NOT NULL,
  `adminemailpaypal` varchar(255) NOT NULL,
  `hostamountpaypal` varchar(255) NOT NULL,
  `adminamountpaypal` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `reservation_status`;
CREATE TABLE IF NOT EXISTS `reservation_status` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `reservation_status` (`id`, `name`) VALUES
(0, 'Payment Pending'),
(1, 'Pending'),
(2, 'Expired'),
(3, 'Accepted'),
(4, 'Declined'),
(5, 'Canceled by Host'),
(6, 'Canceled by Traveler'),
(7, 'Checkin'),
(8, 'Awaiting Host Review'),
(9, 'Awaiting Travel Review'),
(10, 'Completed');

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userby` bigint(20) NOT NULL,
  `userto` bigint(20) NOT NULL,
  `reservation_id` bigint(20) NOT NULL,
  `list_id` bigint(20) NOT NULL,
  `review` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `feedback` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cleanliness` smallint(6) NOT NULL,
  `communication` smallint(6) NOT NULL,
  `house_rules` smallint(6) NOT NULL,
  `accuracy` tinyint(4) NOT NULL,
  `checkin` tinyint(4) NOT NULL,
  `location` tinyint(4) NOT NULL,
  `value` tinyint(4) NOT NULL,
  `created` int(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `roles` (`id`, `parent_id`, `name`) VALUES
(1, 0, 'User'),
(2, 0, 'Admin');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_type` char(1) CHARACTER SET utf8 NOT NULL,
  `value_type` char(1) CHARACTER SET utf8 NOT NULL,
  `int_value` int(12) DEFAULT NULL,
  `string_value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `text_value` text CHARACTER SET utf8,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20;

INSERT INTO `settings` (`id`, `code`, `name`, `setting_type`, `value_type`, `int_value`, `string_value`, `text_value`, `created`) VALUES
(1, 'SITE_TITLE', 'Site Title', 'S', 'S', 0, 'DropInn-v1.9.1', NULL, 1364013607),
(2, 'SITE_SLOGAN', 'Site Slogan', 'S', 'S', 0, 'Rent nightly from real people in 15,543 cities in 185 countries.', NULL, 2013),
(3, 'SITE_STATUS', 'Site status', 'S', 'I', 0, '', NULL, 2013),
(4, 'OFFLINE_MESSAGE', 'Offline Message', 'S', 'T', 0, '', 'Updation is going on...we will run this system very soon', 2013),
(5, 'SITE_ADMIN_MAIL', 'Site Admin Mail', 'S', 'S', NULL, '', NULL, 1364013607),
(6, 'SITE_FB_API_ID', 'Site Facebook API ID', 'S', 'S', NULL, '', NULL, 1364013607),
(7, 'SITE_FB_API_SECRET', 'Site Facebook Secret Key', 'S', 'S', NULL, '', NULL, 1364013607),
(8, 'SITE_GMAP_API_KEY', 'Site Google Map Key', 'S', 'S', NULL, '', NULL, 1364013607),
(9, 'FRONTEND_LANGUAGE', 'Frontend Language', 'S', 'S', 1, 'en', 'en', 2013),
(10, 'SITE_LOGO', 'Site Logo', 'S', 'S', NULL, 'logo.png', NULL, 2013),
(11, 'META_KEYWORD', 'Meta Keyword', 'S', 'S', NULL, 'Dropinn', NULL, 2013),
(12, 'META_DESCRIPTION', 'Meta Description', 'S', 'S', NULL, 'Dropinn - Airbnb Clone', NULL, 2013),
(13, 'HOW_IT_WORKS', 'How It Works', 'S', 'S', 0, 'video.mp4', '', 2013),
(14, 'GOOGLE_ANALYTICS_CODE', 'Google Analytics Code', 'S', 'S', NULL, NULL, '', 2013),
(15, 'BACKEND_LANGUAGE', 'Backend Language', 'S', 'S', 1, 'en', 'en', 0),
(16, 'SITE_TWITTER_API_ID', 'Site Twitter API ID', 'S', 'S', NULL, '', NULL, 1364013607),
(17, 'SITE_TWITTER_API_SECRET', 'Site Twitter Secret Key', 'S', 'S', NULL, '', NULL, 1364013607),
(18, 'DI_LICENSE_KEY', 'License Key', 'S', 'S', NULL, 'Dropinn-2629229f1b9e', NULL, 1364016667),
(19, 'DI_LICENSE_LOCAL_KEY', 'License Local Key', 'S', 'T', NULL, NULL, 'YToxMDp7czo4OiJjdXN0b21lciI7YTo2OntzOjI6ImlkIjtzOjE6IjIiO3M6MTU6%0AInByaW1hcnlfdXNlcl9pZCI7czoxOiIxIjtzOjQ6Im5hbWUiO3M6MjoiQ1QiO3M6%0AMTA6InZhdF9udW1iZXIiO3M6MDoiIjtzOjY6InN0YXR1cyI7czo3OiJlbmFibGVk%0AIjtzOjc6ImNyZWF0ZWQiO3M6MTA6IjEzMTEzMzY4NDciO31zOjQ6InVzZXIiO2E6%0AMTp7aTowO2E6MTQ6e3M6MjoiaWQiO3M6MToiMSI7czoxMDoic2Vzc2lvbl9pZCI7%0AczozMjoiY2U4N2MzMGRkYTg5YTY5MTU2Mzk1ZjU3YTA0YzNkMjciO3M6MTE6Imxh%0Ac3RfbG9nZ2VkIjtzOjEwOiIxMzEzNTEwNDQyIjtzOjEwOiJmaXJzdF9uYW1lIjtz%0AOjU6ImtyaXNoIjtzOjk6Imxhc3RfbmFtZSI7czoxMjoiQ2hlbGxha2thbm51Ijtz%0AOjg6InBhc3N3b3JkIjtzOjMyOiJlMTBhZGMzOTQ5YmE1OWFiYmU1NmUwNTdmMjBm%0AODgzZSI7czo4OiJ1c2VybmFtZSI7czo0OiJiYWxhIjtzOjU6ImVtYWlsIjtzOjI1%0AOiJiYWxha3Jpc2huYW50bmpAZ21haWwuY29tIjtzOjE3OiJzZWN1cml0eV9xdWVz%0AdGlvbiI7czoyNDoiV2hhdCB3YXMgeW91ciBmaXJzdCBqb2I%2FIjtzOjI0OiJzZWN1%0Acml0eV9xdWVzdGlvbl9hbnN3ZXIiO3M6NjoiYWdyaXlhIjtzOjg6Im1heF9yb3dz%0AIjtzOjE6IjUiO3M6MjU6ImhlbHBkZXNrX2Zsb29kX3Byb3RlY3Rpb24iO3M6ODoi%0ARGlzYWJsZWQiO3M6NzoiY3JlYXRlZCI7czoxMDoiMTMxMTMzNjg0NyI7czo2OiJz%0AdGF0dXMiO3M6NzoiZW5hYmxlZCI7fX1zOjE4OiJsaWNlbnNlX2tleV9zdHJpbmci%0AO3M6MjA6IkRyb3BJbm4tMjYyOTIyOWYxYjllIjtzOjg6Imluc3RhbmNlIjthOjU6%0Ae3M6OToiZGlyZWN0b3J5IjthOjE6e2k6MTg3ODtzOjU0OiIvaG9tZS9jb2d6aWRl%0AbHRlbXAvcHVibGljX2h0bWwvZGVtby9jbGllbnQvZHJvcGlubi0xNjYiO31zOjY6%0AImRvbWFpbiI7YToyOntpOjE4NzU7czoyNjoiZGVtby5jb2d6aWRlbHRlbXBsYXRl%0Acy5jb20iO2k6MTg3NjtzOjMwOiJ3d3cuZGVtby5jb2d6aWRlbHRlbXBsYXRlcy5j%0Ab20iO31zOjI6ImlwIjthOjE6e2k6MTg3NztzOjEzOiIyMDguMTA5Ljg3LjU3Ijt9%0AczoxNToic2VydmVyX2hvc3RuYW1lIjthOjE6e2k6MTg3OTtzOjM2OiJpcC0yMDgt%0AMTA5LTg3LTQyLmlwLnNlY3VyZXNlcnZlci5uZXQiO31zOjk6InNlcnZlcl9pcCI7%0AYToxOntpOjE4ODA7czo5OiIxMjcuMC4wLjEiO319czo3OiJlbmZvcmNlIjthOjU6%0Ae2k6MDtzOjY6ImRvbWFpbiI7aToxO3M6MjoiaXAiO2k6MjtzOjk6ImRpcmVjdG9y%0AeSI7aTozO3M6MTU6InNlcnZlcl9ob3N0bmFtZSI7aTo0O3M6OToic2VydmVyX2lw%0AIjt9czoxMzoiY3VzdG9tX2ZpZWxkcyI7YToxOntzOjA6IiI7Tjt9czoyMzoiZG93%0AbmxvYWRfYWNjZXNzX2V4cGlyZXMiO3M6MTA6IjEzNTUxNDgyMTYiO3M6MTU6Imxp%0AY2Vuc2VfZXhwaXJlcyI7czo1OiJuZXZlciI7czoxNzoibG9jYWxfa2V5X2V4cGly%0AZXMiO3M6MTA6IjEzNzU4NTUxOTkiO3M6Njoic3RhdHVzIjtzOjY6ImFjdGl2ZSI7%0AfXtzcGJhc31hM2YwM2QyNTNiNmFmMmExZjQxYTJhNGQxMmI1NDE4NntzcGJhc304%0AZTQ1ZTcxYWU0NjIyY2YwZWNlMjJkM2U2OTAzMjY4Ng%3D%3D', 1364016667);


DROP TABLE IF EXISTS `settings_extra`;
CREATE TABLE IF NOT EXISTS `settings_extra` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `setting_type` char(1) CHARACTER SET utf8 NOT NULL,
  `value_type` char(1) CHARACTER SET utf8 NOT NULL,
  `int_value` int(12) DEFAULT NULL,
  `string_value` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `text_value` text CHARACTER SET utf8,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `statistics`;
CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `list_id` int(25) NOT NULL,
  `page_view` int(25) NOT NULL,
  `date` int(25) NOT NULL,
  `month` varchar(100) NOT NULL,
  `year` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `toplocations`;
CREATE TABLE IF NOT EXISTS `toplocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) NOT NULL,
  `name` varchar(111) NOT NULL,
  `search_code` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

INSERT INTO `toplocations` (`id`, `category_id`, `name`, `search_code`) VALUES
(1, 1, 'Delhi', 'Delhi'),
(2, 1, 'Mumbai', 'Mumbai'),
(3, 1, 'Bangalore', 'Bangalore'),
(4, 1, 'Hyderabad', 'Hyderabad'),
(5, 1, 'Ahmedabad', 'Ahmedabad'),
(6, 1, 'Chennai', 'Chennai'),
(7, 1, 'Kolkata', 'Kolkata'),
(8, 1, 'Pune', 'Pune'),
(9, 2, 'New York', 'New York'),
(10, 2, 'San Francisco', 'San Francisco'),
(11, 2, 'London', 'London'),
(12, 2, 'Paris', 'Paris'),
(13, 2, 'Barcelona', 'Barcelona'),
(14, 2, 'Rome', 'Rome'),
(15, 2, 'Berlin', 'Berlin'),
(16, 2, 'Amsterdam', 'Amsterdam');

DROP TABLE IF EXISTS `toplocation_categories`;
CREATE TABLE IF NOT EXISTS `toplocation_categories` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `toplocation_categories` (`id`, `name`) VALUES
(1, 'India'),
(2, 'World');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `ref_id` varchar(50) NOT NULL,
  `fb_id` bigint(20) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `facebook_verify` varchar(10) DEFAULT '0',
  `google_verify` varchar(10) DEFAULT '0',
  `email_verify` varchar(10) DEFAULT '0',
  `email_verification_code` varchar(50) DEFAULT '0',
  `referral_code` varchar(15) NOT NULL,
  `trips_referral_code` varchar(15) NOT NULL,
  `list_referral_code` varchar(15) NOT NULL,
  `referral_amount` int(10) NOT NULL,
  `timezone` varchar(11) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` int(31) NOT NULL,
  `created` int(31) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `photo_status` int(11) NOT NULL,
  `shortlist` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `user_autologin`;
CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user_notification`;
CREATE TABLE IF NOT EXISTS `user_notification` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `periodic_offers` smallint(5) NOT NULL,
  `company_news` smallint(5) NOT NULL,
  `upcoming_reservation` smallint(5) NOT NULL,
  `new_review` smallint(5) NOT NULL,
  `leave_review` smallint(5) NOT NULL,
  `standby_guests` smallint(5) NOT NULL,
  `rank_search` smallint(5) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user_temp`;
CREATE TABLE IF NOT EXISTS `user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activation_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint(20) NOT NULL auto_increment,
  `list_id` int(111) NOT NULL,
  `contact_key` varchar(100) NOT NULL,
  `userby` int(11) NOT NULL,
  `userto` int(111) NOT NULL,
  `checkin` varchar(50) NOT NULL,
  `checkout` varchar(50) NOT NULL,
  `no_quest` tinyint(4) NOT NULL,
  `currency` varchar(11) NOT NULL,
  `price` float NOT NULL,
  `topay` float NOT NULL,
  `admin_commission` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  `send_date` int(31) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `seasonalprice`;
CREATE TABLE IF NOT EXISTS `seasonalprice` (
  `id` int(11) NOT NULL auto_increment,
  `list_id` int(11) NOT NULL,
  `price` bigint(11) NOT NULL,
  `start_date` int(31) NOT NULL,
  `end_date` int(31) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(12) NOT NULL auto_increment,
  `couponcode` varchar(40) character set utf8 collate utf8_bin NOT NULL,
  `coupon_price` float NOT NULL,
  `expirein` varchar(12) NOT NULL,
  `status` int(20) NOT NULL,
  `currency` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `coupon_users`;
CREATE TABLE IF NOT EXISTS `coupon_users` (
  `id` int(11) NOT NULL auto_increment,
  `list_id` bigint(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `used_coupon_code` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `referrals`;
CREATE TABLE IF NOT EXISTS `referrals` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `invite_from` int(111) NOT NULL,
  `invite_to` int(111) NOT NULL,
  `join_date` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `referrals_amount`;
CREATE TABLE IF NOT EXISTS `referrals_amount` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `user_id` int(111) NOT NULL,
  `count_trip` int(111) NOT NULL,
  `count_book` int(111) NOT NULL,
  `amount` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `referrals_booking`;
CREATE TABLE IF NOT EXISTS `referrals_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payer_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `ref_amount` int(11) NOT NULL,
  `is_full` int(1) NOT NULL,
  `date` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `admin_key`;
CREATE TABLE IF NOT EXISTS `admin_key` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_refer` varchar(150) NOT NULL,
  `page_key` varchar(150) NOT NULL,
  `created` varchar(150) NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `admin_key` (`id`, `page_refer`, `page_key`, `created`, `status`) VALUES
(1, '0', 'Book Your Accommodation', '1375281419', 0);

DROP TABLE IF EXISTS `help`;
CREATE TABLE IF NOT EXISTS `help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(125) NOT NULL,
  `description` text NOT NULL,
  `page_refer` varchar(150) NOT NULL,
  `created` varchar(150) NOT NULL,
  `modified_date` varchar(150) NOT NULL,
  `status` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

INSERT INTO `help` (`id`, `question`, `description`, `page_refer`, `created`, `modified_date`, `status`) VALUES
(1, 'Need help on this page?', '<p>Every one must be know how to work on this product. It is helpful to shows how to work in this product dropinn.</p>', 'home', '', '1375233569', 0),
(2, 'How do i sign up?', ' It is helpful to shows how to sign up to access this product.', 'home', '', '', 0),
(3, 'How can i create an account?', ' It is helpful to shows how to create an account to access this product.', 'dashboard', '1375203327', '', 0),
(5, 'How can i view my reserved rooms?', ' It is helpful to shows how to view my reserved rooms.', 'dashboard', '1375204538', '', 0),
(6, 'How can i edit my reserved rooms? 	', 'It is helpful to shows how to edit my reserved rooms.', 'hosting', '1375204557', '', 0),
(7, 'How to set my payout method to pay?', 'To click a payout method in dashboard and then select a payout method to pay.', 'account', '1375204597', '', 0),
(8, 'How to view my transaction history?', '&lt;p&gt;How to view my transaction history?&lt;/p&gt;', 'payout', '1375205019', '1375211187', 0),
(9, 'How can i add new rooms?', '&lt;p&gt;Fill the form correctly and then add new rooms&lt;/p&gt;', 'new', '1375211799', '', 0),
(10, 'How can i view my inbox?', '<p>Go to dashboard and then select a link inbox to view your messages</p>', 'inbox', '1375215395', '1375215585', 0),
(11, 'How can i cancel my reserved rooms?', '<p>Go to dashboard and then select a link reservations to view your reserved rooms. In this link has a cancellation button to cancel the reservations.', 'travelling', '1375215747', '', 1),
(12, 'How can i edit my profile?', 'Login to dashboard and then click a link edit profile to edit.', 'edit', '', '', 1),
(13, 'How can i view my reviews?', '<p>view your reviews to click a link in profile.</p>', 'reviews', '1375233515', '', 1),
(14, 'How can i view my current trip?', 'Select a travellin link and then click a current trip tab to view your current trips.', 'current_trip', '', '', 1),
(15, 'Need help on this page?', '<p>Every one must be know how to work on this product. It is helpful to shows how to work in this product dropinn.</p>', 'guide', '', '1377699914', 0),
(16, 'How do i sign up?', '<p>It is helpful to shows how to sign up to access this product.</p>', 'guide', '', '1376922078', 0);

INSERT INTO `email_templates` (`id`, `type`, `title`, `mail_subject`, `email_body_text`, `email_body_html`) VALUES 
(69, 'email_verification', 'Email Verification Link', '{site_name} Email Verification Link', 'Hi {user_name},\r\n\r\nPlease Click the below link for your {site_name} email verification.\r\n\r\n{click_here}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td>Hi {user_name},</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<p>Please Click the below link for your {site_name} email verification.</p>\r\n<p>&nbsp;{click_here}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(70, 'referral_credit', 'Referral Credit', 'You are earn {amount} from Referrals', 'Hi {username},\n\nYou are earn the {amount} by {friend_name}\n\n--\nThanks and Regards,\nAdmin\n{site_name}', '<table style="width: 100%;" cellspacing="10" cellpadding="0">\n<tbody>\n<tr>\n<td>Hi {user_name},</td>\n</tr>\n<tr>\n<td><p>\nYou are earn the {amount} by {friend_name}</p>\n</td>\n</tr><tr>\n<td>\n<p style="margin: 0 10px 0 0;">--</p>\n<p style="margin: 0 0 10px 0;">Thanks and Regards,</p>\n<p style="margin: 0 10px 0 0;">Admin</p>\n<p style="margin: 0px;">{site_name}</p>\n</td>\n</tr>\n</tbody>\n</table>');
DROP TABLE IF EXISTS `neigh_category`;
CREATE TABLE IF NOT EXISTS `neigh_category` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `neigh_category` (`id`, `category`, `created`) VALUES
(1, 'Great Transit', '1381458120'),
(2, 'Touristy', '1381458133'),
(3, 'Shopping', '1381458148'),
(4, 'Loved by Londoners', '1381458168');

DROP TABLE IF EXISTS `neigh_city`;
CREATE TABLE IF NOT EXISTS `neigh_city` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(100) NOT NULL,
  `city_desc` text NOT NULL,
  `around` text NOT NULL,
  `known` text NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `is_home` int(1) NOT NULL DEFAULT '0',
  `created` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `neigh_city` (`id`, `city_name`, `city_desc`, `around`, `known`, `image_name`, `is_home`, `created`) VALUES
(1, 'London', 'Relentlessly enterprising and culturally diverse, all eyes are on London when this influential city takes the stage.', 'Public Transit', 'Pub culture, tea culture, the royal family, Big Ben, Shakespeare, wry humor, theatre, fashion and finance, fish and chips, Tate Modern, the Tube', '0_5250_174_2904_hero__DSC0819.jpg', 1, '1381457976');

DROP TABLE IF EXISTS `neigh_city_place`;
CREATE TABLE IF NOT EXISTS `neigh_city_place` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `city_id` int(4) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `quote` text NOT NULL,
  `short_desc` text NOT NULL,
  `long_desc` text NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `lat` varchar(25) NOT NULL,
  `lng` varchar(25) NOT NULL,
  `is_featured` int(1) NOT NULL,
  `created` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `neigh_city_place` (`id`, `city_id`, `city_name`, `place_name`, `quote`, `short_desc`, `long_desc`, `image_name`, `lat`, `lng`, `is_featured`, `created`) VALUES
(1, 1, 'London', 'Westminster', 'Prove you''re in London with pictures in Westminster.', 'History is etched into the stones that compose this neighborhood''s famous clock tower, abbey, and parliament buildings.', 'Boasting more than a few London landmarks, Westminster is a distinct political and cultural epicenter. Westminster Abbey, Buckingham Palace (God Save the Queen), and the United Kingdom’s House of Parliament all share the cobblestoned lanes under Big Ben’s timely shadow. Perched along the north bank', '0_5616_651_3093_hero_UK_London_King_s_Cross_RD__2.jpg', '51.5096446', '-0.1585863', 1, '1381458492');

DROP TABLE IF EXISTS `neigh_photographer`;
CREATE TABLE IF NOT EXISTS `neigh_photographer` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `photographer_name` text NOT NULL,
  `photographer_desc` text NOT NULL,
  `photographer_image` varchar(100) NOT NULL,
  `photographer_web` varchar(50) NOT NULL,
  `city_id` varchar(3) NOT NULL,
  `is_featured` varchar(1) NOT NULL,
  `created` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `neigh_photographer` (`id`, `city`, `place`, `photographer_name`, `photographer_desc`, `photographer_image`, `photographer_web`, `city_id`, `is_featured`, `created`) VALUES
(1, 'London', 'Westminster', 'Duke', 'Rebecca Duke has been working as a photographer for the last decade, after attending Central St Martin’s in London. Her work focuses on people, interiors and travel and has been published in The Sunday Times, Elle Decor and Conde Nast Traveller. Rebecca travels frequently for her work but loved work', 'no_avatar-xlarge.jpg', 'No Website', '1', '1', '1381460489');

DROP TABLE IF EXISTS `neigh_place_category`;
CREATE TABLE IF NOT EXISTS `neigh_place_category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `category_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO `neigh_place_category` (`id`, `city`, `place`, `category_id`) VALUES
(5, 'London', 'Westminster', 1),
(6, 'London', 'Westminster', 2),
(7, 'London', 'Westminster', 3),
(8, 'London', 'Westminster', 4);

DROP TABLE IF EXISTS `neigh_post`;
CREATE TABLE IF NOT EXISTS `neigh_post` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `image_title` text NOT NULL,
  `image_desc` text NOT NULL,
  `big_image1` varchar(100) NOT NULL,
  `small_image1` varchar(100) NOT NULL,
  `small_image2` varchar(100) NOT NULL,
  `small_image3` varchar(100) NOT NULL,
  `small_image4` varchar(100) NOT NULL,
  `small_image5` varchar(100) NOT NULL,
  `big_image2` varchar(100) NOT NULL,
  `big_image3` varchar(100) NOT NULL,
  `is_featured` int(1) NOT NULL,
  `created` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `neigh_post` (`id`, `city`, `place`, `image_title`, `image_desc`, `big_image1`, `small_image1`, `small_image2`, `small_image3`, `small_image4`, `small_image5`, `big_image2`, `big_image3`, `is_featured`, `created`) VALUES
(1, 'London', 'Westminster', 'Britain''s VIPs: Very Important People and Places', 'Westminster''s regal appeal stems from more than old stones and gold-gilded gates.', '0_5760_0_3840_one_UK_London_King_s_Cross_RD__6.jpg', '0_5760_115_3725_two_UK_London_King_s_Cross_RD__7.jpg', '0_5760_115_3725_two_UK_London_King_s_Cross_RD__18.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__11.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__13.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__9.jpg', '0_5760_115_3725_two_UK_London_King_s_Cross_RD__22.jpg', '0_5760_115_3725_two_UK_London_King_s_Cross_RD__25.jpg', 1, '1381458967'),
(2, 'London', 'Westminster', 'King''s Cross: A Transit Core', 'King''s Cross'' trains and tubes whisk passengers away in a timely manner. Catch the Eurostar train to Paris and arrive at The City of Light in nearly two hours'' time.', '0_5309_0_3540_one_UK_London_King_s_Cross_RD__4.jpg', '0_4200_230_2862_two_007121-R1-004.jpg', '0_4200_230_2862_two_007122-R1-009.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__5.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__57.jpg', '765_4995_0_3840_three_UK_London_King_s_Cross_RD__14.jpg', '0_2880_57_1863_two_UK_London_City_of_London_RD__1.jpg', '0_2880_57_1863_two_UK_London_City_of_London_RD__53.jpg', 1, '1381459534');

DROP TABLE IF EXISTS `saved_neigh`;
CREATE TABLE IF NOT EXISTS `saved_neigh` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `city_id` int(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `place_id` int(5) NOT NULL,
  `place` varchar(100) NOT NULL,
  `user_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `neigh_tag`;
CREATE TABLE IF NOT EXISTS `neigh_tag` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `city_id` int(5) NOT NULL,
  `city` varchar(25) NOT NULL,
  `place_id` int(5) NOT NULL,
  `place` varchar(25) NOT NULL,
  `user_id` int(5) NOT NULL,
  `tag` varchar(25) NOT NULL,
  `shown` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `neigh_knowledge`;
CREATE TABLE IF NOT EXISTS `neigh_knowledge` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `city_id` int(5) NOT NULL,
  `city` varchar(25) NOT NULL,
  `place_id` int(5) NOT NULL,
  `place` varchar(25) NOT NULL,
  `user_id` int(5) NOT NULL,
  `knowledge` text NOT NULL,
  `shown` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `neigh_knowledge` (`id`, `city_id`, `city`, `place_id`, `place`, `user_id`, `knowledge`, `shown`) VALUES
(1, 1, 'London', 1, 'Westminster', 1, 'We would definitely recommend this [neighbourhood] to anyone who wants to be centrally located and use the flat as a base to enjoy this vibrant city and all it has to offer', 1),
(2, 1, 'London', 1, 'Westminster', 1, 'There are lots of shops in St Pancras Station and the best grocery store nearby is Waitrose in the Brunswick Centre. There is more public transport within 100m than almost anywhere else on the planet (buses, metro, rail).', 1);
