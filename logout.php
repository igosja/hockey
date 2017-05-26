<?php

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/');
}

session_destroy();

redirect('/');