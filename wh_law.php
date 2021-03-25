<?php

/*

Передать лида можно POST методом на https://lawtask.ru/wh_law.php
Важно корректно указать ключи передаваемого массива, чтобы на входе разобрать где имя, а где город.

*/

// собираем

$post = [
	'id' =>      '12345',			// ваш IDшник (любая строка, число или может вообще отсутствовать0
	'name' =>     'Иванов Иван Иванович',
	'phone' =>    '+71234567890',		// в любом формате
	'city' =>     'Нижний Новгород',
	'question' => 'Как получить жилье от государства?'
];

// очищаем

foreach ($post as $key => $value) {
	$post[$key] = htmlspecialchars($value);
}

// отправляем

$url = 'https://lawtask.ru/wh_law.php';
	
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close ($ch);

// проверяем

if ($response != true) {
	error_log('Send or save error');
	echo 'Лид не был сохранён получателем';
} else {
	echo 'Лид был успешно передан и сохранен получатаем';
}

/*

На стророне CRM происходит следующее: 
Принимается POST запрос, проверяются и очищаются данные. 
CRM пытается сохранить лида даже если часть информации отсутсвует. 
Если есть хоть что-то и это удалось сохранить - возвращает true. 
В противном случае, возвращает текст ошибки. 

Прочитать ошибку можно так:

echo '<pre>';
var_dump($response);
echo '</pre>';

*/
