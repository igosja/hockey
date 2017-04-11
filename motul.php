<?php

include('simple_html_dom.php');

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
$payment_name = '';
$payment_address = '';
$payment_method = '';
$payment_warehouse = '';
$payment_city = '';
$shipping_name = '';
$shipping_address = '';
$shipping_method = '';
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
    'token' => '186b748a9fb4c482edce9085ae927d4b',
    'order_id' => '6124',
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
        $date_add = $td[1]->plaintext;
    } elseif ('Дата добавления:' == $td[2]->plaintext) {
        $date_add = $td[3]->plaintext;
    }

    if ('Телефон:' == $td[0]->plaintext) {
        $phone = $td[1]->plaintext;
    } elseif ('Телефон:' == $td[2]->plaintext) {
        $phone = $td[3]->plaintext;
    }

    if ('Дата изменения:' == $td[0]->plaintext) {
        $date_change = $td[1]->plaintext;
    } elseif ('Дата изменения:' == $td[2]->plaintext) {
        $date_change = $td[3]->plaintext;
    }

    if ('Итого:' == $td[0]->plaintext) {
        $total = $td[1]->plaintext;
    } elseif ('Итого:' == $td[2]->plaintext) {
        $total = $td[3]->plaintext;
    }
}

$table_payment = $content[2];

$table_payment_tr = $table_payment->find('tr');

foreach ($table_payment_tr as $tr) {
    $td = $tr->find('td');

    if ('Фамилия:' == $td[0]->plaintext) {
        $payment_name = $td[1]->plaintext;
    }

    if ('Адрес:' == $td[0]->plaintext) {
        $payment_address = $td[1]->plaintext;
    }

    if ('Способ оплаты:' == $td[0]->plaintext) {
        $payment_method = $td[1]->plaintext;
    }

    if ('Область:' == $td[0]->plaintext) {
        $payment_warehouse = $td[1]->plaintext;
    }

    if ('Страна:' == $td[0]->plaintext) {
        $payment_city = $td[1]->plaintext;
    }
}

$table_shipping = $content[3];

$table_shipping_tr = $table_shipping->find('tr');

foreach ($table_shipping_tr as $tr) {
    $td = $tr->find('td');

    if ('Фамилия:' == $td[0]->plaintext) {
        $shipping_name = $td[1]->plaintext;
    }

    if ('Адрес:' == $td[0]->plaintext) {
        $shipping_address = $td[1]->plaintext;
    }

    if ('Способ доставки:' == $td[0]->plaintext) {
        $shipping_method = $td[1]->plaintext;
    }

    if ('Область:' == $td[0]->plaintext) {
        $shipping_warehouse = $td[1]->plaintext;
    }

    if ('Страна:' == $td[0]->plaintext) {
        $shipping_city = $td[1]->plaintext;
    }
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
            'sum' => $td[4]->plaintext,
        );
    }
}

$token = 'e374a89344d30744d71090b3d1253fe0';

$ch = curl_init();
$timeout = 5;
$params = [
    'route' => 'sale/order/history',
    'token' => '186b748a9fb4c482edce9085ae927d4b',
    'order_id' => '6124',
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
            'alert' => $td[3]->plaintext,
        );
    }
}

print '<pre>';
print_r($order_id);
print '<br>';
print_r($status_current);
print '<br>';
print_r($ip_address);
print '<br>';
print_r($shop_name);
print '<br>';
print_r($ip_forwarded);
print '<br>';
print_r($shop_url);
print '<br>';
print_r($user_agent);
print '<br>';
print_r($client);
print '<br>';
print_r($accept_language);
print '<br>';
print_r($email);
print '<br>';
print_r($date_add);
print '<br>';
print_r($phone);
print '<br>';
print_r($date_change);
print '<br>';
print_r($total);
print '<br>';
print_r($payment_name);
print '<br>';
print_r($payment_address);
print '<br>';
print_r($payment_method);
print '<br>';
print_r($payment_warehouse);
print '<br>';
print_r($payment_city);
print '<br>';
print_r($shipping_name);
print '<br>';
print_r($shipping_address);
print '<br>';
print_r($shipping_method);
print '<br>';
print_r($shipping_warehouse);
print '<br>';
print_r($shipping_city);
print '<br>';
print_r($product_array);
print '<br>';
print_r($product_sum);
print '<br>';
print_r($product_new_post);
print '<br>';
print_r($product_pickup);
print '<br>';
print_r($product_cupon_name);
print '<br>';
print_r($product_cupon);
print '<br>';
print_r($product_total);
print '<br>';
print_r($status_array);
exit;