<?php

/**
 * @var $argv array
 * @var $mysqli mysqli
 * @var $q array
 */

include(__DIR__ . '/../../../include/database.php');

$igosja_migration_path = (__DIR__ . '/migration');

if (isset($argv[1]))
{
    if ('create' == $argv[1] && isset($argv[2]))
    {
        $file_name = time() . '_' . $argv[2] . '.php';

        if ($file = fopen($igosja_migration_path . '/' . $file_name, 'w'))
        {
            $text = '<?php

$q = array();

$q[] = \'\';';
            fwrite($file, $text);
            fclose($file);

            print 'File ' . $file_name . ' has been created.' . "\r\n";
        }
    }
    else
    {
        print 'Wrong command.' . "\r\n";
    }
}
else
{
    print 'Start migration...' . "\r\n";

    $sql = "CREATE TABLE IF NOT EXISTS `a_migration`
            (
                `migration_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
                `migration_date` INT(11) DEFAULT 0,
                `migration_file` VARCHAR(255) NOT NULL
            );";
    $mysqli->query($sql);

    $a_file = scandir($igosja_migration_path);

    foreach ($a_file as $item)
    {
        $start_time = microtime(true);

        $file_name = explode('.', $item);

        if (isset($file_name[1]) && 'php' == $file_name[1])
        {
            $sql = "SELECT COUNT(`migration_id`) AS `count`
                    FROM `a_migration`
                    WHERE `migration_file`='$item'";
            $check_sql   = $mysqli->query($sql);
            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
            $check       = $check_array[0]['count'];

            if (0 == $check)
            {
                include($igosja_migration_path . '/' . $item);

                foreach ($q as $sql)
                {
                    $mysqli->query($sql);
                }

                $sql = "INSERT INTO `a_migration`
                        SET `migration_file`='$item',
                            `migration_date`=UNIX_TIMESTAMP()";
                $mysqli->query($sql);

                print 'File ' . $item . ' done in ' . round((microtime(true) - $start_time) * 1000, 2) . " ms.\r\n";
            }
        }
    }

    print 'All done.' . "\r\n";
}