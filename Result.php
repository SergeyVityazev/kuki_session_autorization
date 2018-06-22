<?php
session_start();
$i = imagecreate(200, 200);
//Делаем белый фон
$color = imagecolorallocate($i, 255, 255, 255);
//Устанавливаем красный цвет
$text_color = imagecolorallocate($i, 255, 0, 0);
//Рисуем горизонтальный текст
imageString($i, 5, 10, 10, "Hello! ".$_SESSION['UserName'], $text_color);
imageString($i, 5, 10, 80, "Your result:", $color);
$color = imagecolorallocate($i, 0, 0, 255);
imagestring($i, 5, 10, 100, "Right answer:".$_SESSION['RightAnswer'], $text_color);
imagestring($i, 5, 10, 120, "NoRight answer:".$_SESSION['NoRightAnswer'], $text_color);

header("Content-type: image/png");

//Выводим изображение
imagepng($i);
//Уничтожаем идентификатор и освобождаем ресурсы сервера
imageDestroy($i);

