<div class="row">
    <div class="col-lg-11 col-md-10 col-sm-10 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Онлайн менеджер для истинных любителей хоккея!</h1>
                <p class="text-justify">
                    Наверняка каждый из нас мечтал почувствовать себя тренером или менеджером настоящего хоккейного клуба.
                    Увлекательный поиск талантливых игроков, постепенное развитие инфраструктуры,
                    выбор подходящей тактики на игру, регулярные матчи и, конечно же, победы, титулы и новые достижения!
                    Именно это ждёт Вас в нашем мире виртуального хоккея. Окунитесь в него и создайте клуб своей мечты!
                </p>
                <h4>Играть в наш хокейный онлайн менеджер может каждый!</h4>
                <p class="text-justify">
                    Наш проект открыт для всех!
                    Чтобы начать играть, Вам достаточно просто пройти элементарную процедуру регистрации
                    либо зайти под своим профилем в социальных сетях.
                    <strong>“Виртуальная Хоккейная Лига”</strong> – это функциональный хоккейный онлайн менеджер,
                    в котором Вы получите возможность пройти увлекательный путь развития своей команды
                    от низших дивизионов до побед в национальных чемпионатах и мировых кубках!
                </p>
                <p class="text-center">
                    <a href="/signup.php">
                        <button class="btn">
                            Зарегистрироваться
                        </button>
                    </a>
                </p>
                <h4>Скачивать ничего не надо!</h4>
                <p class="text-justify">
                    Обращаем внимание, что наш хоккейный онлайн менеджер является браузерной игрой.
                    Поэтому Вам не надо будет скачивать какие-либо клиентские программы,
                    тратить время на их утомительную установку и последующую настройку.
                    Для игры Вам необходим только доступ к интернету и несколько минут свободного времени.
                    При этом участие в турнирах является <strong>абсолютно бесплатным</strong>.
                </p>
                <h4 class="center header">Вы обязательно станете чемпионом!</h4>
                <p class="text-justify">
                    Хотим подчеркнуть, что для достижения успеха Вам не надо целыми сутками сидеть за компьютером.
                    Чтобы поступательно развивать свой клуб, участвовать в трансферах и играть календарные матчи,
                    Вам Вам достаточно иметь возможность хотя бы несколько раз в неделю посещать наш сайт.
                </p>
                <h4 class="center header">Увлекательные хоккейные матчи и первые победы уже ждут Вас!</h4>
                <p class="text-justify">
                    Хоккейный онлайн менеджер <strong>“Виртуальная Хоккейная Лига”</strong> – это больше, чем обычная игра.
                    Это сообщество людей, которые объединены страстью и любовью к хоккею.
                    Здесь Вы обязательно сможете найти интересных людей, заведете новые знакомства
                    и просто отлично проведетё время в непринужденной и максимально комфортной атмосфере.
                    Вперёд, пришло время занять тренерское кресло и кабинет менеджера!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Последние игровые новости</h2>
            </div>
        </div>
        <?php if (isset($news_array[0])) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <span class="strong"><?= $news_array[0]['news_title']; ?></span>
                    </p>
                    <p class="text-justify">
                        <?= $news_array[0]['news_text']; ?>
                    </p>
                    <a href="/user_view.php?num=<?= $news_array[0]['user_id']; ?>">
                        <?= $news_array[0]['user_login']; ?>
                    </a>
                    <p class="text-justify text-size-3">
                        [<a href="/news.php">Подробнее</a>]
                    </p>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Как стать менеджером хоккейной команды?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify">Для того, чтобы стать участником игры, вам нужно:</p>
                <ul>
                    <li>
                        <a class="strong" href="/signup.php">зарегистрироваться в игре</a>,
                        получить письмо с кодом подтверждения регистрации;
                    </li>
                    <li>
                        активировать свою регистрацию с помощью кода, полученного в письме,
                        на <a href="activation.php">этой странице</a>;
                    </li>
                    <li>
                        зайти на сайт под своим логином / паролем (ввести их вверху страницы, в шапке сайта);
                    </li>
                    <li>
                        подать заявку на новую или свободную команду;
                    </li>
                    <li>
                        дождаться, пока модератор рассмотрит вашу заявку и отдаст клуб в ваше распоряжение;
                    </li>
                    <li>
                        ознакомиться с самыми простыми разделами правил (по желанию);
                    </li>
                    <li>
                        и всё - приступить к игре! - постепенно вникая в тонкости и детали игрового процесса.
                    </li>
                </ul>
                <p class="text-justify">
                    Свои вопросы вы можете задать опытным игрокам на форуме.
                    Обо всех проблемах и вопросах вы можете написать в наиболее подходящий раздел
                    <a href="/support.php">тех.поддержки сайта</a>.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Хоккейная аналитика</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify">
                    Журналисты Виртуальной Хоккейной Лиги регулярно публикуют обзоры состоявшихся туров:
                </p>
                <ul>
                    <?php foreach ($review_array as $item) { ?>
                        <li>
                            <?= $item['country_name']; ?>
                            (<?= $item['division_name']; ?>),
                            <?= $item['stage_name']; ?>:
                            <a href="/review_view.php?num=<?= $item['review_id']; ?>">
                                <?= $item['review_title']; ?>
                            </a>
                            (<a href="/user_view.php?num=<?= $item['user_id']; ?>"><?= $item['user_login']; ?></a>)
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Новости федераций</h2>
            </div>
        </div>
        <?php if (isset($newscountry_array[0])) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <span class="strong"><?= $newscountry_array[0]['country_name']; ?>: <?= $newscountry_array[0]['news_title']; ?></span>
                    </p>
                    <p class="text-justify">
                        <?= $newscountry_array[0]['news_text']; ?>
                    </p>
                    <a href="/user_view.php?num=<?= $newscountry_array[0]['user_id']; ?>">
                        <?= $newscountry_array[0]['user_login']; ?>
                    </a>
                    <p class="text-justify text-size-3">
                        [<a href="/country_news.php?num=<?= $newscountry_array[0]['country_id']; ?>">Подробнее</a>]
                    </p>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Дни рождения</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify"><span class="strong">Сегодня день рождения</span> празднуют менеджеры:</p>
                <ul>
                    <?php foreach ($birth_array as $item) { ?>
                        <li>
                            <?= $item['user_name']; ?> <?= $item['user_surname']; ?>
                            (<a href="/user_view.php?num=<?= $item['user_id']; ?>"><?= $item['user_login']; ?></a>)!
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-2 col-sm-2 hidden-xs">
        <div class="row margin">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <a href="//www.liveinternet.ru/click" target="_blank">
                    <img
                        alt="LiveInternet counter"
                        border="0"
                        height="120"
                        src="//counter.yadro.ru/logo?27.1"
                        title="LiveInternet: показано количество просмотров и посетителей"
                        width="88"
                    />
                </a>
            </div>
        </div>
    </div>
</div>