# vamshop_callback
Обратный звонок для CMS vamshop

Установка:
1. Переписываем файлы в дирректорию магазина
- templates/vamshop/mail/russian/call_back.html
- templates/vamshop/mail/russian/call_back.txt
- templates/vamshop/module/call_back.html
- templates/vamshop/module/call_back_ok.html
- /call_back.php

2. Открываем includes/filenames.php, добавляем внизу до ?>:
define('FILENAME_CALL_BACK', 'call_back.php');

3. Добавляем в lang/russian/template_lang_russian.conf секцию:
[call_back]
title_question = 'Запросить обратный звонок'
heading_title = 'Обратный звонок'
text_firstname = 'Ваше имя:'
text_phone = 'Ваш Телефон:'
text_message = 'Ваш вопрос:'
text_success = 'Сообщение было успешно отправлено.'
text_success_head = 'Спасибо большое!'

4. В lang/russian/russian.php добавляем:
// обратный звонок 
define('NAVBAR_TITLE_CALL_BACK','Обратный звонок');
define('TEXT_EMAIL_SUCCESSFUL_SENT_CALL','Ваш запрос успешно отправлен, мы перезвоним Вам в самое ближайшее время.');
define('TEXT_MESSAGE_ERROR_CALL','Вы не заполнили поле телефон.');

5. В нужном месте шаблона добавляем вызов окна:
```html
<a href="call_back.php" class="iframe">Заказать звонок</a>
```
