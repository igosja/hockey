<?php

$token = '80d35e133cd628c4751206a159079cef';

$db_host        = 'localhost';
$db_user        = 'igosja_hockey';
$db_password    = 'zuI2QbJJ';
$db_database    = 'igosja_hockey';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database) or die('No MySQL connection');

$sql = "SET NAMES 'utf8'";
$mysqli->query($sql);

include('simple_html_dom.php');

for ($i=1075; $i<6200; $i++) {
$order_id = '';
$status_current = '';
$ip_address = '';
$shop_name = '';
$ip_forwarded = '';
$shop_url = '';
$user_agent = '';
$client = '';
$accept_language = '';
$email = '';
$date_add = '';
$phone = '';
$date_change = '';
$total = '';
$comment = '';
$payment_name = '';
$payment_address = '';
$payment_method = '';
$payment_code = '';
$payment_warehouse = '';
$payment_city = '';
$shipping_name = '';
$shipping_address = '';
$shipping_method = '';
$shipping_code = '';
$shipping_warehouse = '';
$shipping_city = '';
$product_array = '';
$product_sum = '';
$product_new_post = '';
$product_pickup = '';
$product_cupon_name = '';
$product_cupon = '';
$product_total = '';
$status_array = '';

$ch = curl_init();
$timeout = 5;
$params = [
    'route' => 'sale/order/info',
    'token' => $token,
    'order_id' => $i,
];
curl_setopt($ch, CURLOPT_URL, 'http://motulmarket.com.ua/admin/index.php?' . http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=2d00e7020f6b25da0a76065c898a9d4b; currency=UAH; language=ru; _ym_uid=1491896822551950508; _ym_isad=1; _ga=GA1.3.1083050658.1491896822; _ym_visorc_31056766=w');
$result = curl_exec($ch);
curl_close($ch);

$html = str_get_html($result);

if ('Авторизация' == $html->find('title', 0)->innertext) {
    exit('token давай!');
}

$content = $html->find('div[class=content]');
$content = $content[0]->find('table');

$table_main = $content[1];

$table_main_tr = $table_main->find('tr');

foreach ($table_main_tr as $tr) {
    $td = $tr->find('td');

    if ('№ заказа:' == $td[0]->plaintext) {
        $order_id = substr($td[1]->plaintext, 1);
    } elseif ('№ заказа:' == $td[3]->plaintext) {
        $order_id = substr($td[4]->plaintext, 1);
    }

    if ('Статус заказа:' == $td[0]->plaintext) {
        $status_current = $td[1]->plaintext;
    } elseif ('Статус заказа:' == $td[2]->plaintext) {
        $status_current = $td[3]->plaintext;
    }

    if ('IP адрес:' == $td[0]->plaintext) {
        $ip_address = $td[1]->plaintext;
    } elseif ('IP адрес:' == $td[2]->plaintext) {
        $ip_address = $td[3]->plaintext;
    }

    if ('Название магазина:' == $td[0]->plaintext) {
        $shop_name = $td[1]->plaintext;
    } elseif ('Название магазина:' == $td[2]->plaintext) {
        $shop_name = $td[3]->plaintext;
    }

    if ('Forwarded IP:' == $td[0]->plaintext) {
        $ip_forwarded = $td[1]->plaintext;
    } elseif ('Forwarded IP:' == $td[2]->plaintext) {
        $ip_forwarded = $td[3]->plaintext;
    }

    if ('Url магазина:' == $td[0]->plaintext) {
        $shop_url = $td[1]->plaintext;
    } elseif ('Url магазина:' == $td[2]->plaintext) {
        $shop_url = $td[3]->plaintext;
    }

    if ('User Agent:' == $td[0]->plaintext) {
        $user_agent = $td[1]->plaintext;
    } elseif ('User Agent:' == $td[2]->plaintext) {
        $user_agent = $td[3]->plaintext;
    }

    if ('Клиент:' == $td[0]->plaintext) {
        $client = $td[1]->plaintext;
    } elseif ('Клиент:' == $td[2]->plaintext) {
        $client = $td[3]->plaintext;
    }

    if ('Accept Language:' == $td[0]->plaintext) {
        $accept_language = $td[1]->plaintext;
    } elseif ('Accept Language:' == $td[2]->plaintext) {
        $accept_language = $td[3]->plaintext;
    }

    if ('E-Mail:' == $td[0]->plaintext) {
        $email = $td[1]->plaintext;
    } elseif ('E-Mail:' == $td[2]->plaintext) {
        $email = $td[3]->plaintext;
    }

    if ('Дата добавления:' == $td[0]->plaintext) {
        $date_add = date('Y-m-d H:i:s', strtotime($td[1]->plaintext));
    } elseif ('Дата добавления:' == $td[2]->plaintext) {
        $date_add = date('Y-m-d H:i:s', strtotime($td[3]->plaintext));
    }

    if ('Телефон:' == $td[0]->plaintext) {
        $phone = $td[1]->plaintext;
    } elseif ('Телефон:' == $td[2]->plaintext) {
        $phone = $td[3]->plaintext;
    }

    if ('Дата изменения:' == $td[0]->plaintext) {
        $date_change = date('Y-m-d H:i:s', strtotime($td[1]->plaintext));
    } elseif ('Дата изменения:' == $td[2]->plaintext) {
        $date_change = date('Y-m-d H:i:s', strtotime($td[3]->plaintext));
    }

    if ('Итого:' == $td[0]->plaintext) {
        $total = $td[1]->plaintext;
    } elseif ('Итого:' == $td[2]->plaintext) {
        $total = $td[3]->plaintext;
    }

    if ('Комментарий::' == $td[0]->plaintext) {
        $comment = $td[1]->plaintext;
    } elseif ('Комментарий::' == $td[2]->plaintext) {
        $comment = $td[3]->plaintext;
    }
}

$table_payment = $content[2];

$table_payment_tr = $table_payment->find('tr');

$payment_address = '';

foreach ($table_payment_tr as $tr) {
    $td = $tr->find('td');

    if ('Фамилия:' == $td[0]->plaintext) {
        $payment_name = $td[1]->plaintext;
    }

    if ('Адрес:' == $td[0]->plaintext) {
        $payment_address = $payment_address . $td[1]->plaintext;
    }

    if ('Способ оплаты:' == $td[0]->plaintext) {
        $payment_method = $td[1]->plaintext;
    }

    if ('Область:' == $td[0]->plaintext) {
        $payment_address = $payment_address . $td[1]->plaintext;
    }

    if ('Страна:' == $td[0]->plaintext) {
        $payment_address = $payment_address . $td[1]->plaintext;
    }
}

if ('Оплата при получении' == $payment_method) {
    $payment_code = 'cod';
} elseif ('Карточка Приват' == $payment_method) {
    $payment_code = 'free_checkout';
} else {
    $payment_code = 'privatbank';
}

$table_shipping = $content[3];

$table_shipping_tr = $table_shipping->find('tr');

$shipping_address = '';

foreach ($table_shipping_tr as $tr) {
    $td = $tr->find('td');

    if ('Фамилия:' == $td[0]->plaintext) {
        $shipping_name = $td[1]->plaintext;
    }

    if ('Адрес:' == $td[0]->plaintext) {
        $shipping_address = $shipping_address . $td[1]->plaintext;
    }

    if ('Способ доставки:' == $td[0]->plaintext) {
        $shipping_method = $td[1]->plaintext;
    }

    if ('Область:' == $td[0]->plaintext) {
        $shipping_address = $shipping_address .  $td[1]->plaintext;
    }

    if ('Страна:' == $td[0]->plaintext) {
        $shipping_address = $shipping_address .  $td[1]->plaintext;
    }
}

if ('Самовывоз из магазина' == $shipping_method) {
    $shipping_code = 'pickup.pickup';
} elseif ('Доставка Новой почтой' == $shipping_method) {
    $shipping_code = 'flat.flat';
} else {
    $shipping_code = 'citylink.citylink';
}

$table_product = $content[4];

$table_product_tr = $table_product->find('tr');

$product_array = array();

foreach ($table_product_tr as $tr) {
    $td = $tr->find('td');

    if ('Сумма:' == $td[0]->plaintext) {
        $product_sum = $td[1]->plaintext;
    }

    if ('Доставка Новой почтой:' == $td[0]->plaintext) {
        $product_new_post = $td[1]->plaintext;
    }

    if ('Самовывоз из магазина:' == $td[0]->plaintext) {
        $product_pickup = $td[1]->plaintext;
    }

    if ('Купон' == mb_substr($td[0]->plaintext, 0, 5)) {
        $product_cupon_name = mb_substr($td[0]->plaintext, 7);
        $product_cupon_name = mb_substr($product_cupon_name, 0, -3);
        $product_cupon = $td[1]->plaintext;
    }

    if ('Итого:' == $td[0]->plaintext) {
        $product_total = $td[1]->plaintext;
    }

    $product_list = $td[0]->find('a');

    foreach ($product_list as $product) {
        $product_array[] = array(
            'product' => $product->plaintext,
            'model' => $td[1]->plaintext,
            'quantity' => $td[2]->plaintext,
            'price' => $td[3]->plaintext,
            'total' => $td[4]->plaintext,
        );
    }
}

$token = 'e374a89344d30744d71090b3d1253fe0';

$ch = curl_init();
$timeout = 5;
$params = [
    'route' => 'sale/order/history',
    'token' => $token,
    'order_id' => $i,
];
curl_setopt($ch, CURLOPT_URL, 'http://motulmarket.com.ua/admin/index.php?' . http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=2d00e7020f6b25da0a76065c898a9d4b; currency=UAH; language=ru; _ym_uid=1491896822551950508; _ym_isad=1; _ga=GA1.3.1083050658.1491896822; _ym_visorc_31056766=w');
$result = curl_exec($ch);
curl_close($ch);

$html = str_get_html($result);

$table_history = $html->find('table', 0);
$table_history_tr = $table_history->find('tr');

$status_array = array();

foreach ($table_history_tr as $tr) {
    $td = $tr->find('td');

    if ('Дата добавления' != $td[0]->plaintext)
    {
        $status_array[] = array(
            'date' => $td[0]->plaintext,
            'comment' => $td[1]->plaintext,
            'status' => $td[2]->plaintext,
        );
    }
}

$sql = "SELECT `order_status_id`
        FROM `order_status`
        WHERE `name`='$status'
        LIMIT 1";
$status_sql = $mysqli->query($sql);

if ($status_sql->num_rows) {
    $status_array = $status_sql->fetch_all(1);
    $status_id = $status_array[0]['order_status_id'];
} else {
    $status_id = 7;
}

$total = str_replace(' ', '', $total);
$total = (int) $total;

$product_sql_array = array();

foreach ($product_array as $product) {
    $product_name = $product['product'];
    $product_name = explode(',', $product_name);
    $option_name = end($product_name);
    array_splice($product_name, 0, -1);
    $product_name = implode(',', $product_name);

    $sql = "SELECT `product_id`,
                   `name`
            FROM `product_description`
            WHERE `name`='$product_name'
            LIMIT 1";
    $product_sql = $mysqli->query($sql);

    if (0 == $product_sql) {
        exit($i . ' Product - ' . $product_name);
    }

    $product_array = $product_sql->fetch_all(1);

    $product_id = $product_array[0]['product_id'];
    $product_name = $product_array[0]['name'];

    $sql = "SELECT `option_value_id`,
                   `name`
            FROM `option_value_description`
            WHERE `name`='$option_name'
            LIMIT 1";
    $option_sql = $mysqli->query($sql);

    if (0 == $option_sql) {
        exit($i . ' Option - ' . $option_name);
    }

    $option_array = $option_sql->fetch_all(1);

    $option_value_id = $option_array[0]['option_value_id'];
    $option_name = $option_array[0]['name'];
    
    $sql = "SELECT `product_option_id`
            FROM `product_option`
            WHERE `product_id`='$product_id'
            AND `option_id`='1'
            LIMIT 1";
    $option_sql = $mysqli->query($sql);
    
    $option_array = $option_sql->fetch_all(1);
    $product_option_id = $option_array[0]['product_option_id'];
    
    $sql = "SELECT `product_option_value_id`
            FROM `product_option_value`
            WHERE `product_id`='$product_id'
            AND `option_id`='1'
            AND `product_option_id`='$product_option_id'
            AND `option_value_id`='$option_value_id'
            LIMIT 1";
    $option_sql = $mysqli->query($sql);
    
    $option_array = $option_sql->fetch_all(1);
    $product_option_id = $option_array[0]['product_option_id'];
    
    $product_price = str_replace(' ', '', $product['price']);
    $product_price = (int) $product_price;
    
    $product_totals = str_replace(' ', '', $product['total']);
    $product_totals = (int) $product_totals;

    $product_sql_array[] = array(
        'order_id' = > $order_id,
        'product_option_id' = > '',
        'product_option_value_id' = > '',
        'name_option' = > 'Литраж',
        'value' = > $option_name,
        'type' = > 'radio',
        'product_id' = > $product_id,
        'name_product' = > $product_name,
        'model' = > $product['model'],
        'quantity' = > $product['quantity'],
        'price' = > $product['price'],
        'total' = > $product['total'],
        'tax' = > 0,
        'reward' = > 0,
    );
}

$status_sql_array = array();

foreach ($status_array as $status) {
    $status_name = $status['status'];

    $sql = "SELECT `order_status_id`
            FROM `order_status`
            WHERE `name`='$status_name'
            LIMIT 1";
    $status_sql = $mysqli->query($sql);

    if ($status_sql->num_rows) {
        $status_array = $status_sql->fetch_all(1);
        $status_id = $status_array[0]['order_status_id'];
    } else {
        exit($i . ' Status - ' . $status_name);
    }

    $status_sql_array[] = array(
        'order_id' => $order_id,
        'order_status_id' => $status_id,
        'notify' => 0,
        'comment' => $status['comment'],
        'date_added' => date('Y-m-d H:i:s', strtotime($status['date'])),
    );
}

$total_sql_array = array();

if ($product_sum) {
    $product_sum = str_replace(' ', '', $product_sum);
    $product_sum = (int) $product_sum;
    $total_sql_array[] = array(
        'order_id' => $order_id,
        'code' => 'sub_total',
        'title' => 'Предварительная стоимость',
        'value' => $product_sum,
        'sort_order' => 1,
    );
}

if ($product_new_post) {
    $product_new_post = str_replace(' ', '', $product_new_post);
    $product_new_post = (int) $product_new_post;
    $total_sql_array[] = array(
        'order_id' => $order_id,
        'code' => 'shipping',
        'title' => 'Доставка службой Нова пошта',
        'value' => $product_new_post,
        'sort_order' => 3,
    );
}

if ($product_pickup) {
    $product_pickup = str_replace(' ', '', $product_pickup);
    $product_pickup = (int) $product_pickup;
    $total_sql_array[] = array(
        'order_id' => $order_id,
        'code' => 'shipping',
        'title' => 'Я заберу сам в пункте выдачи',
        'value' => $product_pickup,
        'sort_order' => 3,
    );
}

if ($product_cupon) {
    $product_cupon = str_replace(' ', '', $product_cupon);
    $product_cupon = (int) $product_cupon;
    $total_sql_array[] = array(
        'order_id' => $order_id,
        'code' => 'coupon',
        'title' => 'Купон ('.$product_cupon_name.')',
        'value' => $product_cupon,
        'sort_order' => 4,
    );
}

if ($product_total) {
    $product_total = str_replace(' ', '', $product_total);
    $product_total = (int) $product_total;
    $total_sql_array[] = array(
        'order_id' => $order_id,
        'code' => 'total',
        'title' => 'Итого',
        'value' => $product_total,
        'sort_order' => 9,
    );
}

print '<pre>';
print_r(get_defined_vars());
exit;

$sql = "INSERT INTO `order`
        SET `order_id`='$order_id',
            `store_name`='$shop_name',
            `store_url`='$shop_url',
            `customer_group_id`='1',
            `firstname`='$client',
            `email`='$email',
            `telephone`='$phone',
            `custom_field`='[]',
            `payment_firstname`='$client',
            `payment_address_1`='$payment_address',
            `payment_postcode`='00000',
            `payment_country_id`='220',
            `payment_zone_id`='0',
            `payment_custom_field`='[]',
            `payment_method`='$payment_method',
            `payment_code`='$payment_code',
            `shipping_firstname`='$shipping_name',
            `shipping_address_1`='$shipping_address',
            `shipping_postcode`='00000',
            `shipping_country_id`='220',
            `shipping_zone_id`='0',
            `shipping_custom_field`='[]',
            `shipping_method`='$shipping_method',
            `shipping_code`='$shipping_code',
            `comment`='$comment',
            `total`='$total',
            `order_status_id`='$status_id',
            `language_id`='1',
            `currency_id`='1',
            `currency_code`='RUB',
            `currency_value`='1',
            `ip`='$ip_address',
            `user_agent`='$user_agent',
            `accept_language`='$accept_language',
            `date_added`='$date_add',
            `date_modified`='$date_change'";
$mysqli->query($sql);

foreach ($product_sql_array as $item) {
    $sql = "INSERT INTO `order_product`
            SET `order_id`='" .$item['order_id']. "',
                `product_id`='" .$item['product_id']. "',
                `name`='" .$item['name_product']. "',
                `model`='" .$item['model']. "',
                `quantity`='" .$item['quantity']. "',
                `price`='" .$item['price']. "',
                `total`='" .$item['total']. "',
                `tax`='" .$item['tax']. "',
                `reward`='" .$item['reward']. "'"
    $mysqli->query($sql);

    $order_product_id = $mysqli->insert_id;

    $sql = "INSERT INTO `order_option`
            SET `order_id`='" .$item['order_id']. "',
                `order_product_id`='" .$order_product_id. "',
                `product_option_id`='" .$item['product_option_id']. "',
                `product_option_value_id`='" .$item['product_option_value_id']. "',
                `quantity`='" .$item['quantity']. "',
                `name`='" .$item['name']. "',
                `value`='" .$item['value']. "',
                `type`='" .$item['type']. "'"
    $mysqli->query($sql);
}

foreach ($status_sql_array as $item) {
    $sql = "INSERT INTO `order_history`
            SET `order_id`='" .$item['order_id']. "',
                `order_status_id`='" .$item['order_status_id']. "',
                `notify`='" .$item['notify']. "',
                `comment`='" .$item['comment']. "',
                `date_added`='" .$item['date_added']. "'"
    $mysqli->query($sql);
}

foreach ($total_sql_array as $item) {
    $sql = "INSERT INTO `order_total`
            SET `order_id`='" .$item['order_id']. "',
                `code`='" .$item['code']. "',
                `title`='" .$item['title']. "',
                `value`='" .$item['value']. "',
                `sort_order`='" .$item['sort_order']. "'"
    $mysqli->query($sql);
}
}