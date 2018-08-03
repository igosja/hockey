<?php

/**
 * Додаємо команди, міста і стадіони
 */
function f_igosja_start_insert_team()
{
    global $mysqli;

    $team_array = array(
         array(
             'country' => 'Канада',
             'list' => array(
                 array('team' => 'Абботсфорд Хит', 'stadium' => 'Абботсфорд', 'city' => 'Абботсфорд'),
                 array('team' => 'Брамптон Бист', 'stadium' => 'Паверад', 'city' => 'Брамптон'),
                 array('team' => 'Ванкувер Кэнакс', 'stadium' => 'Роджерс', 'city' => 'Ванкувер'),
                 array('team' => 'Виннипег Джетс', 'stadium' => 'МТС', 'city' => 'Виннипег'),
                 array('team' => 'Галифакс Мусхэдз', 'stadium' => 'Галифакс Метро', 'city' => 'Галифакс'),
                 array('team' => 'Гамильтон Булдогс', 'stadium' => 'Коппс', 'city' => 'Гамильтон'),
                 array('team' => 'Драммондвилл Вольтижурс', 'stadium' => 'Марсель Дионе', 'city' => 'Драммондвилл'),
                 array('team' => 'Калгари Флэймз', 'stadium' => 'Скоушабэнк-Сэдлдоум', 'city' => 'Калгари'),
                 array('team' => 'Калгари Хитмен', 'stadium' => 'Скоушабэнк-Сэдлдоум', 'city' => 'Калгари'),
                 array('team' => 'Манитоба Мус', 'stadium' => 'МТС', 'city' => 'Виннипег'),
                 array('team' => 'Монреаль Канадиенс', 'stadium' => 'Белл', 'city' => 'Монреаль'),
                 array('team' => 'Оттава Сенаторз', 'stadium' => 'Канадиен Тайер', 'city' => 'Оттава'),
                 array('team' => 'Сент-Джонс АйсКэпс', 'stadium' => 'Майл Уан', 'city' => 'Сент-Джонс'),
                 array('team' => 'Торонто Марлис', 'stadium' => 'Торонто', 'city' => 'Торонто'),
                 array('team' => 'Торонто Мейпл Лифс', 'stadium' => 'Эйр Канада', 'city' => 'Торонто'),
                 array('team' => 'Эдмонтон Ойлерз', 'stadium' => 'Роджерс', 'city' => 'Эдмонтон'),
                 array('team' => 'Гранби Иноук', 'stadium' => 'Леонадр Грондин', 'city' => 'Гранби'),
                 array('team' => 'Драмхеллер Драгонз', 'stadium' => 'Драмхеллер', 'city' => 'Драмхеллер'),
                 array('team' => 'Камлупс Блэйзерс', 'stadium' => 'Интериор Сейвингс', 'city' => 'Камлупс'),
                 array('team' => 'Квебек Ремпартс', 'stadium' => 'Видеотрон', 'city' => 'Квебек'),
                 array('team' => 'Келоуна Рокетс', 'stadium' => 'Проспера', 'city' => 'Келоуна'),
                 array('team' => 'Кутеней Айс', 'stadium' => 'Крэнбрук', 'city' => 'Крэнбрук'),
                 array('team' => 'Летбридж Харрикейнз', 'stadium' => 'ЭНМАКС', 'city' => 'Летбридж'),
                 array('team' => 'Медисин-Хат Тайгерс', 'stadium' => 'Медисин-Хат', 'city' => 'Медисин-Хат'),
                 array('team' => 'Принс-Джордж Кугэрз', 'stadium' => 'СН', 'city' => 'Принс-Джордж'),
                 array('team' => 'Садбери Вулвз', 'stadium' => 'Садбери', 'city' => 'Садбери'),
                 array('team' => 'Саскатун Блейдз', 'stadium' => 'СаскТел', 'city' => 'Саскатун'),
                 array('team' => 'Су-Сент-Мари Грейхаундз', 'stadium' => 'Эссар', 'city' => 'Су-Сент-Мари'),
                 array('team' => 'Фэрвью Флайерз', 'stadium' => 'Фэрвью', 'city' => 'Фэрвью'),
                 array('team' => 'Шелберн Шаркс', 'stadium' => 'Дюферинг', 'city' => 'Шелберн'),
                 array('team' => 'Шербрук Финикс', 'stadium' => 'Пале де Спорт', 'city' => 'Шербрук'),
                 array('team' => 'Эдмонтон Ойл Кингз', 'stadium' => 'Рексал', 'city' => 'Эдмонтон'),
                 array('team' => 'Лаваль Сеинтс', 'stadium' => 'Лаваль', 'city' => 'Лаваль'),
                 array('team' => 'Тербон Кобраз', 'stadium' => 'Тербон', 'city' => 'Тербон'),
             ),
         ),
         array(
             'country' => 'США',
             'list' => array(
                 array('team' => 'Анахайм Дакс', 'stadium' => 'Хонда', 'city' => 'Анахайм'),
                 array('team' => 'Бостон Брюинз', 'stadium' => 'ТД', 'city' => 'Бостон'),
                 array('team' => 'Вашингтон Кэпиталз', 'stadium' => 'Верайзон', 'city' => 'Вашингтон'),
                 array('team' => 'Даллас Старз', 'stadium' => 'Американ Эйрлайнс', 'city' => 'Даллас'),
                 array('team' => 'Детройт Ред Уингз', 'stadium' => 'Джо Луис', 'city' => 'Детройт'),
                 array('team' => 'Лос-Анджелес Кингз', 'stadium' => 'Стэйплс', 'city' => 'Лос-Анджелес'),
                 array('team' => 'Нью-Йорк Айлендерс', 'stadium' => 'Барклайс', 'city' => 'Нью-Йорк'),
                 array('team' => 'Нью-Йорк Рейнджерс', 'stadium' => 'Мэдисон Сквер', 'city' => 'Нью-Йорк'),
                 array('team' => 'Нэшвилл Предаторз', 'stadium' => 'Бриджстоун', 'city' => 'Нэшвилл'),
                 array('team' => 'Питтсбург Пингвинз', 'stadium' => 'Консол Энерджи', 'city' => 'Питтсбург'),
                 array('team' => 'Сан-Хосе Шаркс', 'stadium' => 'SAP', 'city' => 'Сан-Хосе'),
                 array('team' => 'Сент-Луис Блюз', 'stadium' => 'Скоттрэйд', 'city' => 'Сент-Луис'),
                 array('team' => 'Тампа-Бэй Лайтнинг', 'stadium' => 'Амали', 'city' => 'Тампа'),
                 array('team' => 'Филадельфия Флайерз', 'stadium' => 'Веллс-Фарго', 'city' => 'Филадельфия'),
                 array('team' => 'Флорида Пантерз', 'stadium' => 'BB&T', 'city' => 'Санрайз'),
                 array('team' => 'Чикаго Блэкхокс', 'stadium' => 'Юнайтед', 'city' => 'Чикаго'),
                 array('team' => 'Айова Уайлд', 'stadium' => 'Велс Фарго', 'city' => 'Де-Мойн'),
                 array('team' => 'Аризона Койотс', 'stadium' => 'Хила Ривер', 'city' => 'Глендейл'),
                 array('team' => 'Баффало Сейбрз', 'stadium' => 'КиБэнк', 'city' => 'Буффало'),
                 array('team' => 'Бейкерсфилд Кондорс', 'stadium' => 'Робобанк', 'city' => 'Бейкерсфилд'),
                 array('team' => 'Гранд-Рапидс Гриффинс', 'stadium' => 'Ван Андел', 'city' => 'Гранд-Рапидс'),
                 array('team' => 'Каролина Харрикейнз', 'stadium' => 'PNC', 'city' => 'Роли'),
                 array('team' => 'Коламбус Блу Джекетс', 'stadium' => 'Нэшнуайд', 'city' => 'Колумбус'),
                 array('team' => 'Колорадо Эвеланш', 'stadium' => 'Пепси', 'city' => 'Денвер'),
                 array('team' => 'Лейк Эри Монстерз', 'stadium' => 'Куикен Лоанс', 'city' => 'Кливленд'),
                 array('team' => 'Милуоки Эдмиралс', 'stadium' => 'Гарис Бредли', 'city' => 'Милуоки'),
                 array('team' => 'Миннесота Уайлд', 'stadium' => 'Эксел Энерджи', 'city' => 'Сент-Пол'),
                 array('team' => 'Нью-Джерси Девилз', 'stadium' => 'Пруденшал', 'city' => 'Ньюарк'),
                 array('team' => 'Рокфорд Айсхогс', 'stadium' => 'Гарис Банк', 'city' => 'Рокфорд'),
                 array('team' => 'Стоктон Хит', 'stadium' => 'Стоктон', 'city' => 'Стоктон'),
                 array('team' => 'Техас Старз', 'stadium' => 'Седар Парк', 'city' => 'Седар Парк'),
                 array('team' => 'Чикаго Вулвз', 'stadium' => 'Олстейт', 'city' => 'Чикаго'),
                 array('team' => 'Сиракьюз Кранч', 'stadium' => 'Уор Мемориал', 'city' => 'Сиракьюс'),
                 array('team' => 'Ютика Кометс', 'stadium' => 'Ютика Мемориал', 'city' => 'Ютика'),
             ),
         ),
         array(
             'country' => 'Россия',
             'list' => array(
                 array('team' => 'Авангард', 'city' => 'Омск', 'stadium' => 'Омск'),
                 array('team' => 'Автомобилист', 'city' => 'Екатеринбург', 'stadium' => 'Уралец'),
                 array('team' => 'Адмирал', 'city' => 'Владивосток', 'stadium' => 'Фетисов'),
                 array('team' => 'Ак Барс', 'city' => 'Казань', 'stadium' => 'Татнефть'),
                 array('team' => 'Динамо', 'city' => 'Москва', 'stadium' => 'Москва'),
                 array('team' => 'Локомотив', 'city' => 'Ярославль', 'stadium' => '2000'),
                 array('team' => 'Металлург', 'city' => 'Магнитогорск', 'stadium' => 'Металлург'),
                 array('team' => 'Нефтехимик', 'city' => 'Нижнекамск', 'stadium' => 'Нефтехимик'),
                 array('team' => 'Салават Юлаев', 'city' => 'Уфа', 'stadium' => 'Уфа'),
                 array('team' => 'Сибирь', 'city' => 'Новосибирск', 'stadium' => 'Сибирь'),
                 array('team' => 'СКА', 'city' => 'Санкт-Петербург', 'stadium' => 'Санкт-Петербург'),
                 array('team' => 'Сочи', 'city' => 'Сочи', 'stadium' => 'Большой'),
                 array('team' => 'Спартак', 'city' => 'Москва', 'stadium' => 'Лужники'),
                 array('team' => 'Торпедо', 'city' => 'Нижний Новгород', 'stadium' => 'Нагорный'),
                 array('team' => 'Трактор', 'city' => 'Челябинск', 'stadium' => 'Трактор'),
                 array('team' => 'ЦСКА', 'city' => 'Москва', 'stadium' => 'ЦСКА'),
                 array('team' => 'Амур', 'city' => 'Хабаровск', 'stadium' => 'Платинум'),
                 array('team' => 'Атлант', 'city' => 'Мытищи', 'stadium' => 'Мытищи'),
                 array('team' => 'Витязь', 'city' => 'Подольск', 'stadium' => 'Витязь'),
                 array('team' => 'Дизель', 'city' => 'Пенза', 'stadium' => 'Дизель'),
                 array('team' => 'Кристалл', 'city' => 'Саратов', 'stadium' => 'Кристалл'),
                 array('team' => 'Кристалл', 'city' => 'Электросталь', 'stadium' => 'Кристалл'),
                 array('team' => 'Крылья Советов', 'city' => 'Москва', 'stadium' => 'Крылья Советов'),
                 array('team' => 'Лада', 'city' => 'Тольятти', 'stadium' => 'Лада'),
                 array('team' => 'МВД', 'city' => 'Балашиха', 'stadium' => 'Балашиха'),
                 array('team' => 'Металлург', 'city' => 'Новокузнецк', 'stadium' => 'Кузнецких металлургов'),
                 array('team' => 'Нефтяник', 'city' => 'Альметьевск', 'stadium' => 'Юбилейный'),
                 array('team' => 'Рубин', 'city' => 'Тюмень', 'stadium' => 'Тюмень'),
                 array('team' => 'Северсталь', 'city' => 'Череповец', 'stadium' => 'Череповец'),
                 array('team' => 'Торос', 'city' => 'Нефтекамск', 'stadium' => 'Нефтекамск'),
                 array('team' => 'Челмет', 'city' => 'Челябинск', 'stadium' => 'Юность'),
                 array('team' => 'Югра', 'city' => 'Ханты-Мансийск', 'stadium' => 'Югра'),
                 array('team' => 'Буран', 'city' => 'Воронеж', 'stadium' => 'Юбилейный'),
                 array('team' => 'Рязань', 'city' => 'Рязань', 'stadium' => 'Олимпийский'),
             ),
         ),
         array(
             'country' => 'Финляндия',
             'list' => array(
                 array('team' => 'Ильвес', 'city' => 'Тампере', 'stadium' => 'Тампере'),
                 array('team' => 'Йокерит', 'city' => 'Хельсинки', 'stadium' => 'Хартвалл'),
                 array('team' => 'КалПа', 'city' => 'Куопио', 'stadium' => 'Куопио'),
                 array('team' => 'КооКоо', 'city' => 'Коувола', 'stadium' => 'Лумон'),
                 array('team' => 'Кярпят', 'city' => 'Оулу', 'stadium' => 'Оулу'),
                 array('team' => 'Лукко', 'city' => 'Раума', 'stadium' => 'Аянсуо'),
                 array('team' => 'Пеликанз', 'city' => 'Лахти', 'stadium' => 'Иску'),
                 array('team' => 'СайПа', 'city' => 'Лаппеэнранта', 'stadium' => 'Кисапуисто'),
                 array('team' => 'Таппара', 'city' => 'Тампере', 'stadium' => 'Тампере'),
                 array('team' => 'ТПС', 'city' => 'Турку', 'stadium' => 'Турку'),
                 array('team' => 'ХИФК', 'city' => 'Хельсинки', 'stadium' => 'Хельсинки'),
                 array('team' => 'ХПК', 'city' => 'Хямеэнлинна', 'stadium' => 'Ритари'),
                 array('team' => 'Эспоо Блюз', 'city' => 'Эспоо', 'stadium' => 'Барона'),
                 array('team' => 'Эссят', 'city' => 'Пори', 'stadium' => 'Пори'),
                 array('team' => 'ЮИП', 'city' => 'Ювяскюля', 'stadium' => 'Синергия'),
                 array('team' => 'Юкурит', 'city' => 'Миккели', 'stadium' => 'Калвенкаа'),
                 array('team' => 'Ваасан Спорт', 'city' => 'Вааса', 'stadium' => 'Вааса'),
                 array('team' => 'Д-тим', 'city' => 'Йювяскюля', 'stadium' => 'Хиппос'),
                 array('team' => 'Ийсалмен', 'city' => 'Ийсалми', 'stadium' => 'Канкаан'),
                 array('team' => 'Йокипоят', 'city' => 'Йоэнсуу', 'stadium' => 'Метимаки'),
                 array('team' => 'КеуПа', 'city' => 'Кеуруу', 'stadium' => 'Кеурукун'),
                 array('team' => 'Киекко-Вантаа', 'city' => 'Вантаа', 'stadium' => 'Трио'),
                 array('team' => 'ЛеКи', 'city' => 'Лемпяаля', 'stadium' => 'Маску'),
                 array('team' => 'ОКК', 'city' => 'Хельсинки', 'stadium' => 'Мальмин'),
                 array('team' => 'Пелиитат', 'city' => 'Хейнола', 'stadium' => 'Версовуд'),
                 array('team' => 'РоКи', 'city' => 'Рованиеми', 'stadium' => 'Лаппи'),
                 array('team' => 'СаПКо', 'city' => 'Савонлинна', 'stadium' => 'Гигантти'),
                 array('team' => 'ТуТо', 'city' => 'Турку', 'stadium' => 'Капиттаан'),
                 array('team' => 'Хермес', 'city' => 'Коккола', 'stadium' => 'Кокколан'),
                 array('team' => 'Хокки', 'city' => 'Каяани', 'stadium' => 'Каяаанин'),
                 array('team' => 'Эспоо Юнайтед', 'city' => 'Эспоо', 'stadium' => 'Эспоо'),
                 array('team' => 'ЮИП-Академия', 'city' => 'Ювяскюля', 'stadium' => 'Синергия'),
                 array('team' => 'Кеттера', 'city' => 'Иматра', 'stadium' => 'Вуоксеннискан'),
                 array('team' => 'Хуртат', 'city' => 'Лиекса', 'stadium' => 'Лиекса'),
             ),
         ),
         array(
             'country' => 'Швеция',
             'list' => array(
                 array('team' => 'АИК', 'city' => 'Стокгольм', 'stadium' => 'Ховет'),
                 array('team' => 'Брюнес', 'city' => 'Евле', 'stadium' => 'Лэкерол'),
                 array('team' => 'Векшё Лейкерс', 'city' => 'Векшё', 'stadium' => 'Вида'),
                 array('team' => 'Вестерос', 'city' => 'Вестерос', 'stadium' => 'АББ'),
                 array('team' => 'Линчёпинг', 'city' => 'Линчёпинг', 'stadium' => 'Клоетта'),
                 array('team' => 'Лулео', 'city' => 'Лулео', 'stadium' => 'Куп'),
                 array('team' => 'Мальмё Редхоукс', 'city' => 'Мальмё', 'stadium' => 'Мальмё'),
                 array('team' => 'МОДО', 'city' => 'Эрншёльдсвик', 'stadium' => 'Фьелльрэвен'),
                 array('team' => 'Рёгле', 'city' => 'Энгельхольм', 'stadium' => 'Линдап'),
                 array('team' => 'Сёдертелье', 'city' => 'Сёдертелье', 'stadium' => 'AXA Спортс'),
                 array('team' => 'Тимро', 'city' => 'Тимро', 'stadium' => 'Е ОН'),
                 array('team' => 'Ферьестад', 'city' => 'Карлстад', 'stadium' => 'Лёфбергс Лила'),
                 array('team' => 'Фрёлунда', 'city' => 'Гётеборг', 'stadium' => 'Скандинавиум'),
                 array('team' => 'ХВ71', 'city' => 'Йёнчёпинг', 'stadium' => 'Киннарпс'),
                 array('team' => 'Шеллефтео', 'city' => 'Шеллефтео', 'stadium' => 'Шеллефтео Крафт'),
                 array('team' => 'Юргорден', 'city' => 'Стокгольм', 'stadium' => 'Эрикссон-Глоб'),
                 array('team' => 'Альмтуна', 'city' => 'Уппсала', 'stadium' => 'Гранби'),
                 array('team' => 'Бофорс', 'city' => 'Карлскуга', 'stadium' => 'Нобель'),
                 array('team' => 'Бурос', 'city' => 'Бурос', 'stadium' => 'Бурос'),
                 array('team' => 'Каликс', 'city' => 'Каликс', 'stadium' => 'Фуруринкен'),
                 array('team' => 'Карлскруна', 'city' => 'Карлскруна', 'stadium' => 'Карлскруна'),
                 array('team' => 'Кируна', 'city' => 'Кируна', 'stadium' => 'Ломбиа'),
                 array('team' => 'Ковланд', 'city' => 'Ковланд', 'stadium' => 'Ковланд'),
                 array('team' => 'Лександ', 'city' => 'Лександ', 'stadium' => 'Тегера'),
                 array('team' => 'Мура', 'city' => 'Мура', 'stadium' => 'Матссон'),
                 array('team' => 'Оскарсхамн', 'city' => 'Оскарсхамн', 'stadium' => 'Оскарсхамн'),
                 array('team' => 'Сундсвалль', 'city' => 'Сундсвалль', 'stadium' => 'Гердехоф'),
                 array('team' => 'Тингсрюд', 'city' => 'Тингсрюд', 'stadium' => 'Нельсон Гарден'),
                 array('team' => 'Эребру', 'city' => 'Эребру', 'stadium' => 'Берн'),
                 array('team' => 'Эрншёльдсвик', 'city' => 'Эрншёльдсвик', 'stadium' => 'Скиттис'),
                 array('team' => 'Эстерсунд', 'city' => 'Эстерсунд', 'stadium' => 'З'),
                 array('team' => 'Юнгбю', 'city' => 'Юнгбю', 'stadium' => 'Зуннербоховс'),
                 array('team' => 'Веннес', 'city' => 'Веннес', 'stadium' => 'Норра'),
                 array('team' => 'Соллефтео', 'city' => 'Соллефтео', 'stadium' => 'Норра'),
             ),
         ),
         array(
             'country' => 'Чехия',
             'list' => array(
                 array('team' => 'Бенатки-над-Йизероу', 'city' => 'Бенатки-над-Йизероу', 'stadium' => 'Бенатки-над-Йизероу'),
                 array('team' => 'Били Тигржи', 'city' => 'Либерец', 'stadium' => 'Типспорт'),
                 array('team' => 'Верва Литвинов', 'city' => 'Литвинов', 'stadium' => 'Иван Глинка'),
                 array('team' => 'Витковице Стил', 'city' => 'Острава', 'stadium' => 'Острава'),
                 array('team' => 'Злин', 'city' => 'Злин', 'stadium' => 'Лудка Кайку'),
                 array('team' => 'Итон Пардубице', 'city' => 'Пардубице', 'stadium' => 'Пардубице'),
                 array('team' => 'Кладно', 'city' => 'Кладно', 'stadium' => 'Зимний стадион'),
                 array('team' => 'Комета', 'city' => 'Брно', 'stadium' => 'Кайот'),
                 array('team' => 'Маунтфилд', 'city' => 'Градец-Кралове', 'stadium' => 'Градец-Кралове'),
                 array('team' => 'Млада Болеслав', 'city' => 'Млада-Болеслав', 'stadium' => 'СКА-Энерго'),
                 array('team' => 'Оломоуц', 'city' => 'Оломоуц', 'stadium' => 'Оломоуц'),
                 array('team' => 'Оцеларжи', 'city' => 'Тршинец', 'stadium' => 'Верк'),
                 array('team' => 'Пльзень', 'city' => 'Пльзень', 'stadium' => 'Пльзень'),
                 array('team' => 'Славия', 'city' => 'Прага', 'stadium' => 'O2'),
                 array('team' => 'Спарта', 'city' => 'Прага', 'stadium' => 'Типспорт'),
                 array('team' => 'Энергия', 'city' => 'Карловы Вары', 'stadium' => 'КВ'),
                 array('team' => 'Бероунски Медведи', 'city' => 'Бероун', 'stadium' => 'Бероун'),
                 array('team' => 'Врхлаби', 'city' => 'Врхлаби', 'stadium' => 'Врхлаби'),
                 array('team' => 'ВСЕС', 'city' => 'Градец-Кралове', 'stadium' => 'Градец'),
                 array('team' => 'Гавиржов Пантрез', 'city' => 'Гавиржов', 'stadium' => 'Гавиржов'),
                 array('team' => 'Гавличкув-Брод', 'city' => 'Гавличкув-Брод', 'stadium' => 'Гавличкув-Брод'),
                 array('team' => 'Дукла', 'city' => 'Йиглава', 'stadium' => 'Йиглава'),
                 array('team' => 'Зноймы Орлы', 'city' => 'Зноймо', 'stadium' => 'Хостан'),
                 array('team' => 'Кадань', 'city' => 'Кадань', 'stadium' => 'Кадань'),
                 array('team' => 'Яромерж', 'city' => 'Яромерж', 'stadium' => 'Яромерж'),
                 array('team' => 'Салис Шумперк', 'city' => 'Шумперк', 'stadium' => 'Шумперк'),
                 array('team' => 'Слезань Опава', 'city' => 'Опава', 'stadium' => 'Опава'),
                 array('team' => 'Табор', 'city' => 'Табор', 'stadium' => 'Табор'),
                 array('team' => 'Устсти Львы', 'city' => 'Усти-над-Лабем', 'stadium' => 'Злотобрамен'),
                 array('team' => 'Хомутов', 'city' => 'Хомутов', 'stadium' => 'Хомутов'),
                 array('team' => 'Хорака Славия', 'city' => 'Тршебич', 'stadium' => 'Тршебич'),
                 array('team' => 'Хрудим', 'city' => 'Хрудим', 'stadium' => 'Хрудим'),
                 array('team' => 'Зубр Пршеров', 'city' => 'Пршеров', 'stadium' => 'Пршеров'),
                 array('team' => 'Техника Брно', 'city' => 'Брно', 'stadium' => 'Брно'),
             ),
         ),
         array(
             'country' => 'Швейцария',
             'list' => array(
                 array('team' => 'Ажуа', 'city' => 'Поррантрюи', 'stadium' => 'Поррантрюи'),
                 array('team' => 'Амбри-Пиотта', 'city' => 'Амбри', 'stadium' => 'Писта ла Валаскиа'),
                 array('team' => 'Базель', 'city' => 'Базель', 'stadium' => 'Базель'),
                 array('team' => 'Берн', 'city' => 'Берн', 'stadium' => 'Пост Финанс'),
                 array('team' => 'Биль', 'city' => 'Биль', 'stadium' => 'Биль'),
                 array('team' => 'Давос', 'city' => 'Давос', 'stadium' => 'Вайллант'),
                 array('team' => 'Женева Серветт', 'city' => 'Женева', 'stadium' => 'Вернет'),
                 array('team' => 'Клотен Флайерз', 'city' => 'Клотен', 'stadium' => 'Колпинг'),
                 array('team' => 'Ла-Шо-де-Фон', 'city' => 'Ла-Шо-де-Фон', 'stadium' => 'Мелесез'),
                 array('team' => 'Лангнау Тайгерс', 'city' => 'Лангнау', 'stadium' => 'Ильфис'),
                 array('team' => 'Лозанна', 'city' => 'Лозанна', 'stadium' => 'Маллей'),
                 array('team' => 'Лугано', 'city' => 'Лугано', 'stadium' => 'Песера'),
                 array('team' => 'Рапперсвиль-Йона Лейкерз', 'city' => 'Рапперсвиль-Йона', 'stadium' => 'Динерс Клаб'),
                 array('team' => 'Фрибур Готтерон', 'city' => 'Фрибур', 'stadium' => 'Сен-Леонард'),
                 array('team' => 'Цуг', 'city' => 'Цуг', 'stadium' => 'Боссард'),
                 array('team' => 'Цюрих Лайонс', 'city' => 'Цюрих', 'stadium' => 'Халлен'),
                 array('team' => 'Ароза', 'city' => 'Ароза', 'stadium' => 'Ароза'),
                 array('team' => 'Вилар', 'city' => 'Вилар-Сюр-Оллон', 'stadium' => 'Вилар'),
                 array('team' => 'Вулвз', 'city' => 'Лозанна', 'stadium' => 'Понтейз'),
                 array('team' => 'Кур', 'city' => 'Кур', 'stadium' => 'Кур'),
                 array('team' => 'Лангенталь', 'city' => 'Лангенталь', 'stadium' => 'Шорен'),
                 array('team' => 'Лис', 'city' => 'Лис', 'stadium' => 'Лис'),
                 array('team' => 'Ольтен', 'city' => 'Ольтен', 'stadium' => 'Ольтен'),
                 array('team' => 'Рэд Айс', 'city' => 'Мартиньи', 'stadium' => 'Фором'),
                 array('team' => 'Санкт-Мориц', 'city' => 'Санкт-Мориц', 'stadium' => 'Санкт-Мориц'),
                 array('team' => 'Сиерре Аннивирз', 'city' => 'Сиерре', 'stadium' => 'Сиерре'),
                 array('team' => 'Тайгерз', 'city' => 'Лангнау-им-Эмменталь', 'stadium' => 'Ильфис'),
                 array('team' => 'Тургау', 'city' => 'Вайнфельден', 'stadium' => 'Вайнфельден'),
                 array('team' => 'Фисп', 'city' => 'Фисп', 'stadium' => 'Фисп'),
                 array('team' => 'Форвард Морж', 'city' => 'Морж', 'stadium' => 'Морж'),
                 array('team' => 'Херизау', 'city' => 'Херизау', 'stadium' => 'Херизау'),
                 array('team' => 'Янг Спринтерс', 'city' => 'Невшатель', 'stadium' => 'Жанес Рив'),
                 array('team' => 'Зеевен', 'city' => 'Зеевен', 'stadium' => 'Зеевен'),
                 array('team' => 'Люцерн', 'city' => 'Люцерн', 'stadium' => 'Люцерн'),
             ),
         ),
         array(
             'country' => 'Словакия',
             'list' => array(
                 array('team' => '37 Пьештяны', 'city' => 'Истон', 'stadium' => 'Пьештяны'),
                 array('team' => '46 Бардеёв', 'city' => 'Бардеёв', 'stadium' => 'Бардеёв'),
                 array('team' => 'Банска-Бистрица', 'city' => 'Банска-Бистрица', 'stadium' => 'Банска-Бистрица'),
                 array('team' => 'Дукла', 'city' => 'Тренчин', 'stadium' => 'Тренчин'),
                 array('team' => 'Дукла', 'city' => 'Сеница', 'stadium' => 'Сеница'),
                 array('team' => 'Жилина', 'city' => 'Жилина', 'stadium' => 'Жилина'),
                 array('team' => 'Зволен', 'city' => 'Зволен', 'stadium' => 'Зволен'),
                 array('team' => 'Кошице', 'city' => 'Кошице', 'stadium' => 'Стил'),
                 array('team' => 'Липтовски Микулаш', 'city' => 'Липтовски Микулаш', 'stadium' => 'Липтовски Микулаш'),
                 array('team' => 'Мартин', 'city' => 'Мартин', 'stadium' => 'Мартин'),
                 array('team' => 'Нитра', 'city' => 'Нитра', 'stadium' => 'Нитра'),
                 array('team' => 'Оранж 20', 'city' => 'Братислава', 'stadium' => 'Словнафт'),
                 array('team' => 'Попрад', 'city' => 'Попрад', 'stadium' => 'Татравагонка'),
                 array('team' => 'Слован', 'city' => 'Братислава', 'stadium' => 'Словнафт'),
                 array('team' => 'Татранские Волки', 'city' => 'Спишска-Нова-Вес', 'stadium' => 'Спиш'),
                 array('team' => 'ХК-36', 'city' => 'Скалица', 'stadium' => 'Макс'),
                 array('team' => '07 Детва', 'city' => 'Детва', 'stadium' => 'Детва'),
                 array('team' => '07 Прешов', 'city' => 'Прешов', 'stadium' => 'Прешов'),
                 array('team' => '91 Сеница', 'city' => 'Сеница', 'stadium' => 'Сеница'),
                 array('team' => '95 Поважска-Бистрица', 'city' => 'Поважска-Бистрица', 'stadium' => 'Поважска-Бистрица'),
                 array('team' => 'Брезно', 'city' => 'Брезно', 'stadium' => 'Брезно'),
                 array('team' => 'Гуменне', 'city' => 'Гуменне', 'stadium' => 'Гуменне'),
                 array('team' => 'Дольни-Кубин', 'city' => 'Дольни-Кубин', 'stadium' => 'Дольни-Кубин'),
                 array('team' => 'Дукла', 'city' => 'Михаловце', 'stadium' => 'Михаловце'),
                 array('team' => 'Кежмарок', 'city' => 'Кежмарок', 'stadium' => 'Кежмарок'),
                 array('team' => 'Прешов Пингвинз', 'city' => 'Прешов', 'stadium' => 'Прешов'),
                 array('team' => 'Прьевидза', 'city' => 'Прьевидза', 'stadium' => 'Прьевидза'),
                 array('team' => 'Ружинов', 'city' => 'Братислава', 'stadium' => 'Владимир Дзурилла'),
                 array('team' => 'Слован', 'city' => 'Гелница', 'stadium' => 'Гелница'),
                 array('team' => 'Топольчани', 'city' => 'Топольчани', 'stadium' => 'Топольчани'),
                 array('team' => 'Требишов', 'city' => 'Требишов', 'stadium' => 'Требишов'),
                 array('team' => 'Трнава', 'city' => 'Трнава', 'stadium' => 'Трнава'),
                 array('team' => 'Злате-Моравце', 'city' => 'Злате-Моравце', 'stadium' => 'Злате-Моравце'),
                 array('team' => 'Пухов', 'city' => 'Пухов', 'stadium' => 'Пухов'),
             ),
         ),
         array(
             'country' => 'Белоруссия',
             'list' => array(
                 array('team' => 'Брест', 'city' => 'Брест', 'stadium' => 'Брест'),
                 array('team' => 'Витебск', 'city' => 'Витебск', 'stadium' => 'Витебск'),
                 array('team' => 'Газпромнефть', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Гомель', 'city' => 'Гомель', 'stadium' => 'Гомель'),
                 array('team' => 'Динамо', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Динамо', 'city' => 'Молодечно', 'stadium' => 'Молодечно'),
                 array('team' => 'Динамо-Шинник', 'city' => 'Бобруйск', 'stadium' => 'Бобруйск'),
                 array('team' => 'Лида', 'city' => 'Лида', 'stadium' => 'Лида'),
                 array('team' => 'Металлург', 'city' => 'Жлобин', 'stadium' => 'Металлург'),
                 array('team' => 'Могилёв', 'city' => 'Могилёв', 'stadium' => 'Могилёв'),
                 array('team' => 'Неман', 'city' => 'Гродно', 'stadium' => 'Гродно'),
                 array('team' => 'Тивали', 'city' => 'Минск', 'stadium' => 'Юность'),
                 array('team' => 'Химик-СКА', 'city' => 'Новополоцк', 'stadium' => 'Полимир'),
                 array('team' => 'Шахтер', 'city' => 'Солигорск', 'stadium' => 'Солигорск'),
                 array('team' => 'Юниор', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Юность', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Авангард', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Аматар', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Атлант', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Драконы', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Ледовые львы', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Микст', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Миф', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Молнии', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Регион', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Рубеж', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Рубон', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Сокол', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Столица', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Строитель', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Феникс', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Характер', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Беркут', 'city' => 'Минск', 'stadium' => 'Минск'),
                 array('team' => 'Бизоны', 'city' => 'Минск', 'stadium' => 'Минск'),
             ),
         ),
         array(
             'country' => 'Германия',
             'list' => array(
                 array('team' => 'Адлер Мангейм', 'city' => 'Мангейм', 'stadium' => 'САП'),
                 array('team' => 'Айсберен Берлин', 'city' => 'Берлин', 'stadium' => 'Мерседес-Бенц'),
                 array('team' => 'Аугсбургер Пантер', 'city' => 'Аугсбург', 'stadium' => 'Курт-Френцель'),
                 array('team' => 'Бад-Наухайм', 'city' => 'Бад-Наухайм', 'stadium' => 'Бад-Наухайм'),
                 array('team' => 'Гамбург Фризерс', 'city' => 'Гамбург', 'stadium' => 'Барклейкард'),
                 array('team' => 'Ганновер Скорпионс', 'city' => 'Ганновер', 'stadium' => 'Туй'),
                 array('team' => 'Гриззлис Вольфсбург', 'city' => 'Вольфсбург', 'stadium' => 'Вольфсбург'),
                 array('team' => 'Дюссельдорф', 'city' => 'Дюссельдорф', 'stadium' => 'ИСС дом'),
                 array('team' => 'Изерлон Рустерс', 'city' => 'Изерлон', 'stadium' => 'Изерлон'),
                 array('team' => 'Ингольштадт', 'city' => 'Ингольштадт', 'stadium' => 'Сатурн'),
                 array('team' => 'Кассель Хаскис', 'city' => 'Кассель', 'stadium' => 'Кассель'),
                 array('team' => 'Кёльнер Хайе', 'city' => 'Кёльн', 'stadium' => 'Ланксесс'),
                 array('team' => 'Крефельд Пингвин', 'city' => 'Крефельд', 'stadium' => 'Кёнигспаласт'),
                 array('team' => 'Нюрнберг Айс Тайгерс', 'city' => 'Нюрнберг', 'stadium' => 'Нюрнберг'),
                 array('team' => 'Ред Булл', 'city' => 'Мюнхен', 'stadium' => 'Олимпия'),
                 array('team' => 'Фиштаун Пингвинз', 'city' => 'Бремерхафен', 'stadium' => 'Ледовая арена'),
                 array('team' => 'Байройт', 'city' => 'Байройт', 'stadium' => 'Байройт'),
                 array('team' => 'Битигхайм Стилерз', 'city' => 'Битигхайм-Биссинген', 'stadium' => 'Эгтранс'),
                 array('team' => 'Дрезден Айслёвен', 'city' => 'Дрезден', 'stadium' => 'Эненрджи Вербунд'),
                 array('team' => 'Дуйсбург Фухсе', 'city' => 'Дуйсбург', 'stadium' => 'Сканиа'),
                 array('team' => 'Кауфбойрен', 'city' => 'Кауфбойрен', 'stadium' => 'Спаркассен'),
                 array('team' => 'Криммичау', 'city' => 'Криммичау', 'stadium' => 'Санпарк'),
                 array('team' => 'Лауситзер Фухсе', 'city' => 'Вайсвассер', 'stadium' => 'Вайсвассер'),
                 array('team' => 'Равенсбург Тауэрстарз', 'city' => 'Равенсбург', 'stadium' => 'Равенсбург'),
                 array('team' => 'Ризерси', 'city' => 'Гармиш-Партенкирхен', 'stadium' => 'Олимпия'),
                 array('team' => 'Роте Тойфель', 'city' => 'Бад-Наухайм', 'stadium' => 'Колонел'),
                 array('team' => 'Старбулз Розенхайм', 'city' => 'Розенхайм', 'stadium' => 'Катрейн'),
                 array('team' => 'Фрайбург', 'city' => 'Фрайбург-им-Брайсгау', 'stadium' => 'Франц-Сигель'),
                 array('team' => 'Франкфурт Лайонс', 'city' => 'Франкфурт-на-Майне', 'stadium' => 'Франкфурт'),
                 array('team' => 'Хайльбронн Фалькен', 'city' => 'Хайльбронн', 'stadium' => 'Кольбеншмидт'),
                 array('team' => 'Швеннингер Уайлд Уингз', 'city' => 'Филлинген-Швеннинген', 'stadium' => 'Гелиос'),
                 array('team' => 'Штраубинг Тайгерс', 'city' => 'Штраубинг', 'stadium' => 'Пульвертурм'),
                 array('team' => 'Ганновер Индианз', 'city' => 'Ганновер', 'stadium' => 'Фердетурм'),
                 array('team' => 'Эссен Москитс', 'city' => 'Эссен', 'stadium' => 'Эссен'),
             ),
         ),
         array(
             'country' => 'Норвегия',
             'list' => array(
                 array('team' => 'Берген', 'city' => 'Берген', 'stadium' => 'Берген'),
                 array('team' => 'Волеренга', 'city' => 'Осло', 'stadium' => 'Юрдаль Амфи'),
                 array('team' => 'Йёвик', 'city' => 'Йёвик', 'stadium' => 'Йёвик'),
                 array('team' => 'Комет', 'city' => 'Халден', 'stadium' => 'Халден'),
                 array('team' => 'Конгсвингер Кнайтс', 'city' => 'Конгсвингер', 'stadium' => 'Конгсвингер'),
                 array('team' => 'Лёренскуг', 'city' => 'Лёренскуг', 'stadium' => 'Лёренскуг'),
                 array('team' => 'Лиллехаммер', 'city' => 'Лиллехаммер', 'stadium' => 'Кристинс'),
                 array('team' => 'Манглеруд Стар', 'city' => 'Осло', 'stadium' => 'Манглеруд'),
                 array('team' => 'Русенборг', 'city' => 'Тронхейм', 'stadium' => 'Лиген'),
                 array('team' => 'Спарта Уорриорз', 'city' => 'Сарпсборг', 'stadium' => 'Спарта'),
                 array('team' => 'Ставангер Ойлерз', 'city' => 'Ставангер', 'stadium' => 'ДНБ'),
                 array('team' => 'Сторхамар', 'city' => 'Хамар', 'stadium' => 'Хамар'),
                 array('team' => 'Стьернен', 'city' => 'Фредрикстад', 'stadium' => 'Стьернен'),
                 array('team' => 'Тёнсберг Викингс', 'city' => 'Тёнсберг', 'stadium' => 'Тёнсберг'),
                 array('team' => 'Фриск Аскер', 'city' => 'Аскер', 'stadium' => 'Аскер'),
                 array('team' => 'Фурусет', 'city' => 'Осло', 'stadium' => 'Фурусет'),
                 array('team' => 'Грюнер', 'city' => 'Осло', 'stadium' => 'Грюнер'),
                 array('team' => 'Кристиансанн', 'city' => 'Кристиансанн', 'stadium' => 'Кристиансанн'),
                 array('team' => 'Лидерхорн Гладиаторз', 'city' => 'Берген', 'stadium' => 'Берген'),
                 array('team' => 'Локомотив Фана', 'city' => 'Берген', 'stadium' => 'Берген'),
                 array('team' => 'Мосс', 'city' => 'Мосс', 'stadium' => 'Мосс'),
                 array('team' => 'Нарвик', 'city' => 'Нарвик', 'stadium' => 'Нордкрафт'),
                 array('team' => 'Нидарос', 'city' => 'Тронхейм', 'stadium' => 'Лиген'),
                 array('team' => 'Принсдален Вилз', 'city' => 'Осло', 'stadium' => 'Грюнер'),
                 array('team' => 'Рингерике Пантерз', 'city' => 'Хёнефосс', 'stadium' => 'Шёнг'),
                 array('team' => 'Тёнсберг', 'city' => 'Тёнсберг', 'stadium' => 'Тёнсберг'),
                 array('team' => 'Тромсё', 'city' => 'Тромсё', 'stadium' => 'Тромсё'),
                 array('team' => 'Хасле-Лёрен', 'city' => 'Осло', 'stadium' => 'Лёрен'),
                 array('team' => 'Хёугесунн Сигалс', 'city' => 'Хёугесунн', 'stadium' => 'Хёугесунн'),
                 array('team' => 'Шедсму', 'city' => 'Шедсму', 'stadium' => 'Шедсму'),
                 array('team' => 'Ши Айсхоукс', 'city' => 'Ши', 'stadium' => 'Ши'),
                 array('team' => 'Ютул', 'city' => 'Берум', 'stadium' => 'Берум'),
                 array('team' => 'Драммен Ривер Ретс', 'city' => 'Драммен', 'stadium' => 'Драммен'),
                 array('team' => 'Яар', 'city' => 'Берум', 'stadium' => 'Берум'),
             ),
         ),
        array(
            'country' => 'Украина',
            'list' => array(
                array('team' => 'Белый Барс', 'city' => 'Белая Церковь', 'stadium' => 'Белая Церковь'),
                array('team' => 'Будивельник', 'city' => 'Киев', 'stadium' => 'Киев'),
                 array('team' => 'Винницкие Гайдамаки', 'city' => 'Винница', 'stadium' => 'Ледовый Клуб'),
                 array('team' => 'Витязь', 'city' => 'Харьков', 'stadium' => 'Салтовский лёд'),
                 array('team' => 'Дженералз', 'city' => 'Киев', 'stadium' => 'Киев'),
                 array('team' => 'Динамо', 'city' => 'Харьков', 'stadium' => 'Салтовский лёд'),
                 array('team' => 'Донбасс', 'city' => 'Донецк', 'stadium' => 'Дружба'),
                 array('team' => 'Дружба-78', 'city' => 'Харьков', 'stadium' => 'Харьков'),
                 array('team' => 'Компаньон', 'city' => 'Киев', 'stadium' => 'АТЕК'),
                 array('team' => 'Кременчуг', 'city' => 'Кременчуг', 'stadium' => 'Айсберг'),
                 array('team' => 'Кривбасс', 'city' => 'Кривой Рог', 'stadium' => 'Кривой Рог'),
                 array('team' => 'Львы', 'city' => 'Львов', 'stadium' => 'Новояворовск'),
                 array('team' => 'Молодая гвардия', 'city' => 'Донецк', 'stadium' => 'Дружба'),
                 array('team' => 'Партиот', 'city' => 'Винница', 'stadium' => 'Винница'),
                 array('team' => 'Подол', 'city' => 'Киев', 'stadium' => 'АТЕК'),
                 array('team' => 'Сокол', 'city' => 'Киев', 'stadium' => 'Терминал'),
                 array('team' => 'АТЕК', 'city' => 'Киев', 'stadium' => 'АТЕК'),
                 array('team' => 'Вороны', 'city' => 'Сумы', 'stadium' => 'Сумы'),
                 array('team' => 'Гладиатор', 'city' => 'Львов', 'stadium' => 'Медик'),
                 array('team' => 'Днепр', 'city' => 'Херсон', 'stadium' => 'Фаворит'),
                 array('team' => 'Луцк', 'city' => 'Луцк', 'stadium' => 'Луцк'),
                 array('team' => 'Льдинка', 'city' => 'Киев', 'stadium' => 'Льдинка'),
                 array('team' => 'Одесса', 'city' => 'Одесса', 'stadium' => 'Умка'),
                 array('team' => 'Олимпия', 'city' => 'Калуш', 'stadium' => 'Калуш'),
                 array('team' => 'Политехник', 'city' => 'Киев', 'stadium' => 'Авангард'),
                 array('team' => 'Рапид', 'city' => 'Киев', 'stadium' => 'Киев'),
                 array('team' => 'Фаворит', 'city' => 'Ровно', 'stadium' => 'Ровно'),
                 array('team' => 'Цунами', 'city' => 'Ивано-Франковск', 'stadium' => 'Ивано-Франковск'),
                 array('team' => 'Экспресс', 'city' => 'Львов', 'stadium' => 'Медик'),
                 array('team' => 'Эней', 'city' => 'Дрогобич', 'stadium' => 'Дрогобич'),
                 array('team' => 'Юность', 'city' => 'Харьков', 'stadium' => 'Салтовский лёд'),
                 array('team' => 'Явор', 'city' => 'Явоворов', 'stadium' => 'Явоворов'),
                 array('team' => 'Ведмеди', 'city' => 'Ужгород', 'stadium' => 'Ужгород'),
                 array('team' => 'Подоляны', 'city' => 'Тернополь', 'stadium' => 'Тернополь'),
            ),
        ),
    );

    foreach ($team_array as $country)
    {
        $country_name = $country['country'];

        $sql = "SELECT `country_id`
                FROM `country`
                WHERE `country_name`='$country_name'
                LIMIT 1";
        $country_sql = f_igosja_mysqli_query($sql);

        $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

        $country_id = $country_array[0]['country_id'];

        foreach ($country['list'] as $item)
        {
            $city_name = $item['city'];

            $sql = "SELECT `city_id`
                    FROM `city`
                    WHERE `city_country_id`=$country_id
                    AND `city_name`='$city_name'
                    LIMIT 1";
            $city_sql = f_igosja_mysqli_query($sql);

            if ($city_sql->num_rows)
            {
                $city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

                $city_id = $city_array[0]['city_id'];
            }
            else
            {
                $sql = "INSERT INTO `city`
                        SET `city_country_id`=$country_id,
                            `city_name`='$city_name'";
                f_igosja_mysqli_query($sql);

                $city_id = $mysqli->insert_id;
            }

            $stadium_name = $item['stadium'];

            $sql = "INSERT INTO `stadium`
                    SET `stadium_city_id`=$city_id,
                        `stadium_name`='$stadium_name'";
            f_igosja_mysqli_query($sql);

            $stadium_id = $mysqli->insert_id;

            $team_name = $item['team'];

            $sql = "INSERT INTO `team`
                    SET `team_stadium_id`=$stadium_id,
                        `team_name`='$team_name'";
            f_igosja_mysqli_query($sql);

            $team_id = $mysqli->insert_id;

            $log = array(
                'history_historytext_id' => HISTORYTEXT_TEAM_REGISTER,
                'history_team_id' => $team_id,
            );
            f_igosja_history($log);
            f_igosja_create_team_players($team_id);
            f_igosja_create_league_players($team_id);

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 15
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 1
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_c_16 = $power + $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 20
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 1
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_c_21 = $power + $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 25
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 2
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_c_27 = $power + $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 15
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 1
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_s_16 = $power + $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 20
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 1
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_s_21 = $power + $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`!=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 25
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power = $power_array[0]['power'];

            $sql = "SELECT SUM(`player_power_nominal_s`) AS `power`
                    FROM
                    (
                        SELECT `player_power_nominal_s`
                        FROM `player`
                        WHERE `player_team_id`=$team_id
                        AND `player_position_id`=" . POSITION_GK . "
                        ORDER BY `player_power_nominal` DESC, `player_id` ASC
                        LIMIT 2
                    ) AS `t1`";
            $power_sql = f_igosja_mysqli_query($sql);

            $power_array = $power_sql->fetch_all(MYSQLI_ASSOC);

            $power_s_27 = $power + $power_array[0]['power'];

            $power_v    = round(($power_c_16 + $power_c_21 + $power_c_27) / 64 * 16);
            $power_vs   = round(($power_s_16 + $power_s_21 + $power_s_27) / 64 * 16);

            $sql = "UPDATE `team`
                    SET `team_power_c_16`=$power_c_16,
                        `team_power_c_21`=$power_c_21,
                        `team_power_c_27`=$power_c_27,
                        `team_power_s_16`=$power_s_16,
                        `team_power_s_21`=$power_s_21,
                        `team_power_s_27`=$power_s_27,
                        `team_power_v`=$power_v,
                        `team_power_vs`=$power_vs
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}