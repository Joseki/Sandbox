<?php

class Migration_1443705749_init extends \Joseki\Migration\DefaultMigration
{

    public function migrate()
    {
        $this->query(
            [
                "SET NAMES utf8",
                "SET foreign_key_checks = 0",
                "SET time_zone = 'SYSTEM'",
                "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'",
                "CREATE TABLE IF NOT EXISTS `user` ( `id` int(11) NOT NULL AUTO_INCREMENT, `login` varchar(50) COLLATE utf8_czech_ci NOT NULL, `password` varchar(100) COLLATE utf8_czech_ci NOT NULL, `name` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL, `surname` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL, `email` varchar(100) COLLATE utf8_czech_ci DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `login` (`login`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `role` ( `id` varchar(50) COLLATE utf8_czech_ci NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `user_role` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user` int(11) NOT NULL, `role` varchar(50) COLLATE utf8_czech_ci NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `user_role` (`user`,`role`), KEY `role` (`role`), CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, CONSTRAINT `user_role_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `section` ( `id` int(11) NOT NULL AUTO_INCREMENT, `order` int(11) NOT NULL DEFAULT '0', `name` varchar(100) COLLATE utf8_czech_ci NOT NULL, `link` varchar(255) COLLATE utf8_czech_ci NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `section_closure` ( `ancestor` int(11) NOT NULL, `descendant` int(11) NOT NULL, `depth` int(11) NOT NULL DEFAULT '0', KEY `descendant` (`descendant`), KEY `ancestor` (`ancestor`), CONSTRAINT `section_closure_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `section` (`id`) ON DELETE CASCADE, CONSTRAINT `section_closure_ibfk_3` FOREIGN KEY (`ancestor`) REFERENCES `section` (`id`) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `restriction` ( `id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(100) COLLATE utf8_czech_ci NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci",
                "CREATE TABLE IF NOT EXISTS `section_restriction` ( `section` int(11) NOT NULL, `restriction` int(11) NOT NULL, KEY `section` (`section`), KEY `restriction` (`restriction`), CONSTRAINT `section_restriction_ibfk_1` FOREIGN KEY (`section`) REFERENCES `section` (`id`) ON DELETE CASCADE, CONSTRAINT `section_restriction_ibfk_2` FOREIGN KEY (`restriction`) REFERENCES `restriction` (`id`) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci"
            ]
        );
    }
}
