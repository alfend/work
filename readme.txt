Переустановка(замена 1 версии)
1.  Установленный Denwer не удаляем и не изменяем
2.  Скачиваем архив www и распаковываем в папку нашего сайта(по умолчанию C:\WebServers\home - kadastrToKladr.ru), все файлы заменяем новыми
3.  Открыть в браузере http://kadastrtokladr.ru/init.html, ввести код вашего региона нажать enter. Дождаться надписи «Инициализация выполнена» (до 30 минут). Перейти по ссылке на главную.
4.  Ввести и в логин и в пароль код региона.Для Оренбургской обл 56 56.

Запуск и настройка (установка в windows)
1.	Под windows заполнить форму для скачивания Denwer  http://www.denwer.ru/dis/?url=Base/Denwer3_Base_2013-06-02_a2.2.22_p5.3.13_m5.5.25_pma3.5.1_xdebug.exe. В почте по ссылке скачать и установить.
2.	Запустить денвер - Start Denwer. Создать папку в C:\WebServers\home - kadastrToKladr.ru, и распаковать архив www в этот каталог. Перезапустить Denwer - Restart Denwer.
3.	Открыть в браузере http://kadastrtokladr.ru/init.html, ввести код вашего региона нажать enter. Дождаться надписи «Инициализация выполнена». Перейти по ссылке на главную.
4.	Ввести и в логин и в пароль код региона.Для Оренбургской обл 56 56.

Запуск и настройка (установка в unix)
1.	Установить apache, php 5, mysql http://help.ubuntu.ru/wiki/apachemysqlphp. 
2.	добавить сайт в var и настроить, при наличие пароля root в mysql во всех файлах прописать ваш пароль $db=mysql_connect("localhost","root",""); Выдать права для каталогов www и files
3.	Открыть в браузере http://kadastrtokladr.ru/init.html, ввести код вашего региона нажать enter. Дождаться надписи «Инициализация выполнена». Перейти по ссылке на главную.
4.	Ввести и в логин и в пароль код региона.Для Оренбургской обл 56 56.

Внимание:
Рекомендуется открыть в Z:\usr\local\php\php.ini найти строчки upload_max_filesize,memory_limit и post_max_size и поставить 1024M, разкоментировать строчку default_charset = "UTF-8", перезапустить денвер(apache)

Для всех
5  Выполнить запросы с помощью zaprosgkn.txt в ГКН и zaprosegrp.txt в ЕГРП (либо запросить готовый файл ЕГРП соответсвтующий формату выгрузки).
6  Загрузить обе выгрузки с помощью кнопки обзор -> загрузить в меню ГКН и ЕГРП соответсвенно
7  Нажать "Проставить" в ГКН и дождаться проставления кладра, выводится на экран первая 1000 объектов, затем лишь информация об обработке. Процедура длительная 1000 объектов в мин 
   (Пройцент выставленных кодов кладра в среднем = 80-90%, в случае, если у вас процент получился ниже 60% есть вероятность, что произошел сбой в сессии при выполнение скрипта, необходимо снова нажать изменить)
8  Аналогично "Проставить" ЕГРП.
9  Перейти в меню Сопоставления, и сделать выборки 1,1а и 2а, 2б. Остальные для ознокомления.
10 Передать данные в отдел верификации.
