<?php

function f_igosja_hash_password($password)
{
    return md5($password . md5(PASSWORD_SALT));
}