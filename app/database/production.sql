DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uid` integer NOT NULL,
  `tid` integer NOT NULL,
  `cid` integer NOT NULL,
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE INDEX actions_cid_index ON `actions` (cid);
CREATE INDEX actions_tid_index ON `actions` (tid);
CREATE INDEX actions_uid_index ON `actions` (uid);

DROP TABLE IF EXISTS `busteds`;
CREATE TABLE `busteds` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uid` integer NOT NULL,
  `name` varchar(256) NOT NULL,
  `mask` varchar(256) NOT NULL,
  `freq` integer NOT NULL,
  `sinner` tinyint NOT NULL,
  `baptized` tinyint NOT NULL,
  `meeter` varchar(256) NOT NULL,
  `email` varchar(256),
  `nick` varchar(256),
  `church` varchar(256),
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE INDEX busteds_uid_index ON `busteds` (uid);

DROP TABLE IF EXISTS `churches`;
CREATE TABLE `churches` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(256) NOT NULL,
  `qlink` varchar(256) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `cid` integer,
  `status` tinyint NOT NULL,
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX churches_qlink_unique ON `churches` (qlink);
CREATE UNIQUE INDEX churches_name_unique ON `churches` (name);

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `uid` integer NOT NULL,
  `uuidx` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `type` varchar(256) NOT NULL,
  `data` text NOT NULL,
  `info` varchar(256) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(256) NOT NULL,
  `batch` integer NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_045435_create_users_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_051440_create_churches_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_053306_create_settings_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_063143_create_targets_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_064114_create_actions_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_20_064853_create_busteds_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_01_29_190741_create_user_churches_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_02_08_052216_create_statistics_table',1);
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2015_02_11_103950_create_logs_table',1);
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(256) NOT NULL,
  `subscription` varchar(256) NOT NULL,
  `phone` varchar(256),
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX settings_email_unique ON `settings` (email);

DROP TABLE IF EXISTS `statistics`;
CREATE TABLE `statistics` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `targets`;
CREATE TABLE `targets` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uid` integer NOT NULL,
  `name` varchar(256) NOT NULL,
  `mask` varchar(256) NOT NULL,
  `freq` integer NOT NULL,
  `sinner` tinyint NOT NULL,
  `baptized` tinyint NOT NULL,
  `meeter` varchar(256) NOT NULL,
  `email` varchar(256),
  `nick` varchar(256),
  `church` varchar(256),
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE INDEX targets_uid_index ON `targets` (uid);

DROP TABLE IF EXISTS `user_churches`;
CREATE TABLE `user_churches` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uid` integer NOT NULL,
  `cid` integer NOT NULL,
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE INDEX user_churches_cid_index ON `user_churches` (cid);
CREATE INDEX user_churches_uid_index ON `user_churches` (uid);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uuidx` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `seed` integer NOT NULL,
  `status` tinyint NOT NULL,
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

