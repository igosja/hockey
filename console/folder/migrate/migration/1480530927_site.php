<?php

$q = array();

$q[] = 'CREATE TABLE `site`
        (
            `site_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `site_status` TINYINT(1) DEFAULT 1,
            `site_version_1` SMALLINT(5) DEFAULT 0,
            `site_version_2` SMALLINT(5) DEFAULT 3,
            `site_version_3` SMALLINT(5) DEFAULT 0,
            `site_version_4` SMALLINT(5) DEFAULT 0,
            `site_version_date` INT(11) DEFAULT 0
        );';
$q[] = 'INSERT INTO `site`
        SET `site_id`=NULL,
            `site_version_date`=UNIX_TIMESTAMP()';