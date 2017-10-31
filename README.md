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
```php
define('FILENAME_CALL_BACK', 'call_back.php');
```

3. Добавляем в lang/russian/template_lang_russian.conf секцию:
```php
[call_back]
title_question = 'Запросить обратный звонок'
heading_title = 'Обратный звонок'
text_firstname = 'Ваше имя:'
text_phone = 'Ваш Телефон:'
text_message = 'Ваш вопрос:'
text_success = 'Сообщение было успешно отправлено.'
text_success_head = 'Спасибо большое!'
```

4. В lang/russian/russian.php добавляем:
```php
// обратный звонок 
define('NAVBAR_TITLE_CALL_BACK','Обратный звонок');
define('TEXT_EMAIL_SUCCESSFUL_SENT_CALL','Ваш запрос успешно отправлен, мы перезвоним Вам в самое ближайшее время.');
define('TEXT_MESSAGE_ERROR_CALL','Вы не заполнили поле телефон.');
```

5. В нужном месте шаблона добавляем вызов окна:
```html
<a href="call_back.php" class="iframe">Заказать звонок</a>
```
6. Добавляем стили:
```css
/* попапы */
h1.popup-title {padding: 20px;font-size: 20px;text-align: center;color: #333;font-weight: normal !important;background: #fff;background: -moz-linear-gradient(top,#fff 0%,#e9e9e9 100%);
background: -webkit-linear-gradient(top,#fff 0%,#e9e9e9 100%);background: linear-gradient(to bottom,#fff 0%,#e9e9e9 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#e9e9e9',GradientType=0);margin: 0;border:none;position: relative;} 
.popup-close {display: block;position: absolute;width: 24px;height: 24px;border: 1px solid #333;border-radius: 50%;color: #333;font-size: 14px;line-height: 22px;top: 15px;right: 15px;text-align: center;z-index: 2;}
.popup-content {background: #fff;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;min-height:350px;}
.callback-content {min-height:250px;}
.popup-text {border-bottom: 1px solid #EEE;padding:10px;}
.popup-input-wrap {border-bottom: 1px solid #EEE;padding: 10px;clear: both;}
.popup-input-wrap label {float: left;display: inline-block;margin: 0 10px 0 0;line-height: 30px;width: 40%;}
.popup-input-wrap input[type="text"], .popup-input-wrap textarea  {background: #F7F7F7!important;outline: none!important;border-top: 1px solid #CCC!important;border-left: 1px solid #CCC!important;border-right: 1px solid #E7E6E6!important;border-bottom: 1px solid #E7E6E6!important;padding: 4px 6px!important;display: inline-block!important;font-size: 14px!important;  width: 50%!important; position: relative!important;-webkit-border-radius: 4px!important;-moz-border-radius: 4px!important;border-radius: 4px!important;margin: 0!important;}
.popup-input-wrap .inputRequirement {float: right;}
.popup-footer {padding: 10px 10px 0;font-size: 16px;overflow: hidden;text-align: center;}
.popup-success {text-align: center;padding-top: 30px;}
```
