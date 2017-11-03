<?php

/**
 * Додаємо зареєстрованих користувачів
 */
function f_igosja_start_insert_user()
{
    $user_array = array(
        array(
            'user_code'         => 'f296a47aebb6b66620d44652a59db37a',
            'user_date_confirm' => 0,
            'user_email'        => 'fanat16rus@yandex.ru',
            'user_login'        => 'Fanat16Rus',
            'user_password'     => '42f807e146b7db018c9560ea179535b6',
        ),
        array(
            'user_code'         => '883a889016dafef5c1c17d4227988ae1',
            'user_date_confirm' => 0,
            'user_email'        => 'pavel87desant38@gmail.com',
            'user_login'        => 'Fanfar',
            'user_password'     => '6cee822c8723d6ff4c6470fbf66ed096',
        ),
        array(
            'user_code'         => 'f622f133ec347c0ab5b5807f0ba8c9ba',
            'user_date_confirm' => time(),
            'user_email'        => 'champion1969@ukr.net',
            'user_login'        => 'champion1969',
            'user_password'     => '240196161e30b6b62d861d102091beed',
        ),
        array(
            'user_code'         => '7e1e9fb1fb5130d6d795ce1fd7efa661',
            'user_date_confirm' => 0,
            'user_email'        => 'denzell87@mail.ru',
            'user_login'        => 'Denis_nk',
            'user_password'     => '84afc62d24cf1d0f58a4451f517ca1a1',
        ),
        array(
            'user_code'         => 'd86e2fe366918eabd0875d7d58bfad99',
            'user_date_confirm' => time(),
            'user_email'        => 'kamaretdinova2@rambler.ru',
            'user_login'        => 'arsenal2',
            'user_password'     => '05063043f1168481304dacf76901af2c',
        ),
        array(
            'user_code'         => 'd0f2887375f98b39cea2f8cee1761840',
            'user_date_confirm' => 0,
            'user_email'        => 'suronovos@mail.ru',
            'user_login'        => 'suronovos',
            'user_password'     => 'c4cebb3cf70d9ac033606682b796c5a9',
        ),
        array(
            'user_code'         => '27415f4d1d6b604a99754d451ec92c26',
            'user_date_confirm' => 0,
            'user_email'        => 'sdhgqnk75@mail.ru',
            'user_login'        => 'Anthonywasse',
            'user_password'     => 'bd414a156a5a5c493bf1ebbee650cccb',
        ),
        array(
            'user_code'         => '6eb62c17f8cd62f32c238f820f44f4c1',
            'user_date_confirm' => 0,
            'user_email'        => 'owen@1milliondollars.xyz',
            'user_login'        => 'IsaacHab',
            'user_password'     => 'cf12350f0de7344e7907740e266f516d',
        ),
        array(
            'user_code'         => 'f16aa98974ba943ec95c57bd747d23cc',
            'user_date_confirm' => 0,
            'user_email'        => 'louiskaddy@mail.ru',
            'user_login'        => 'LouiskiG',
            'user_password'     => 'da829237a71645b601db54894ac4deee',
        ),
        array(
            'user_code'         => 'f3dad4cf0afccaa2dcaf999ad60f4501',
            'user_date_confirm' => 0,
            'user_email'        => 'arturofeste2222@mail.ru',
            'user_login'        => 'Arturolet',
            'user_password'     => 'a28ab8cc0c4feb06cda302108ae80e63',
        ),
        array(
            'user_code'         => 'c04e50612b305c3d2b8d588c17d8e237',
            'user_date_confirm' => 0,
            'user_email'        => 'leqifolo@mail.ru',
            'user_login'        => 'Charlesdrace',
            'user_password'     => '974020b66bf436f000035cb48101592d',
        ),
        array(
            'user_code'         => 'd6419c4d27ca1e68ce3d335718e61695',
            'user_date_confirm' => 0,
            'user_email'        => 'arturofsad8@mail.ru',
            'user_login'        => 'chairomeconf1982',
            'user_password'     => 'ebae749d1ef468bfebaf70474448d31b',
        ),
        array(
            'user_code'         => '69fb202e9a4d590071c07fd87fd47aae',
            'user_date_confirm' => 0,
            'user_email'        => 'erasmonef@mail.ru',
            'user_login'        => 'Erasmomix',
            'user_password'     => '6198e5ef8373e831c147e29526b35f2c',
        ),
        array(
            'user_code'         => '425e6f7f3dbfc2c14f12a388b8ddd81c',
            'user_date_confirm' => 0,
            'user_email'        => 'email@try-rx.com',
            'user_login'        => 'Chrlitwony',
            'user_password'     => '1bc5c4314885eb86f7690c4b4b48467c',
        ),
        array(
            'user_code'         => '7ac4953bd13749f9cf8a6c65e38989f6',
            'user_date_confirm' => time(),
            'user_email'        => 'Vinico@yandex.ru',
            'user_login'        => 'Vini',
            'user_password'     => 'b18a5b2e77a96a591f2548c64f3d1c88',
        ),
        array(
            'user_code'         => '95619089d64db32ed031c7fa722a1341',
            'user_date_confirm' => time(),
            'user_email'        => 'ganskiy@yahoo.com',
            'user_login'        => 'gans79',
            'user_password'     => '50ccace5e26269cf9712cef9bbde03fa',
        ),
        array(
            'user_code'         => '5ece89f94c92e53b23785a86a2dab1ca',
            'user_date_confirm' => 0,
            'user_email'        => 'charlesmaymn555@mail.ru',
            'user_login'        => 'Charlespleah',
            'user_password'     => '9f13e9df7a81d430651885f653cd5a61',
        ),
        array(
            'user_code'         => '32731d9b7b3703b34a27d08f873b94a8',
            'user_date_confirm' => 0,
            'user_email'        => 'arturof75421@mail.ru',
            'user_login'        => 'StevenFug',
            'user_password'     => 'c4c7312ad2caf83626179ead3b3e1687',
        ),
        array(
            'user_code'         => '6254b23a0412533464fdb9a13437e5c8',
            'user_date_confirm' => time(),
            'user_email'        => 'Birchgrove@yandex.ru',
            'user_login'        => 'Witalij',
            'user_password'     => '65b24f51521cb2f34ba8d474c65d33d7',
        ),
        array(
            'user_code'         => 'dc55f972572fdbe3fa09f40a187c1390',
            'user_date_confirm' => 0,
            'user_email'        => '32w7fe@gmail.com',
            'user_login'        => 'kgg25y',
            'user_password'     => '4b32d2d4792e731f23ca182890394640',
        ),
        array(
            'user_code'         => '96d77686c4e8f7c1fcf5aa1ee6871a2b',
            'user_date_confirm' => 0,
            'user_email'        => 'kkezl7@gmail.com',
            'user_login'        => '1i2rud',
            'user_password'     => '4b32d2d4792e731f23ca182890394640',
        ),
        array(
            'user_code'         => '1e212d4699689eacd061b2c0e9fdaafd',
            'user_date_confirm' => 0,
            'user_email'        => 'nil.graponov@mail.ru',
            'user_login'        => 'Wesleydotte',
            'user_password'     => '8afcb13268dd60b7b25ea2da7203bdc1',
        ),
        array(
            'user_code'         => 'affd9c4e181c1638243685a774084af8',
            'user_date_confirm' => 0,
            'user_email'        => 'morshonka@yandex.ru',
            'user_login'        => 'AncicKiC',
            'user_password'     => 'a10ff439f3a51c9213d988b9dfef9e19',
        ),
        array(
            'user_code'         => 'a2c251fec0f7ccef9001b87a5429550f',
            'user_date_confirm' => 0,
            'user_email'        => 'Plasystanny@gmail.com',
            'user_login'        => 'cofswomfora',
            'user_password'     => '86121be767c5e4c973fced1a6d20d9a9',
        ),
        array(
            'user_code'         => '4b9966a91c8fc1218a08e1d30a524d14',
            'user_date_confirm' => 0,
            'user_email'        => 'kipelovanko@yandex.ru',
            'user_login'        => 'NewmcKiC',
            'user_password'     => 'cf439e8964f0ce35dad08df93bf50a24',
        ),
    );

    foreach ($user_array as $item)
    {
        $user_code          = $item['user_code'];
        $user_date_confirm  = $item['user_date_confirm'];
        $user_email         = $item['user_email'];
        $user_login         = $item['user_login'];
        $user_password      = $item['user_password'];

        $sql = "INSERT INTO `user`
                SET `user_code`='$user_code',
                    `user_date_confirm`=$user_date_confirm,
                    `user_date_login`=UNIX_TIMESTAMP(),
                    `user_date_register`=UNIX_TIMESTAMP(),
                    `user_email`='$user_email',
                    `user_login`='$user_login',
                    `user_password`='$user_password'";
        f_igosja_mysqli_query($sql);
    }
}