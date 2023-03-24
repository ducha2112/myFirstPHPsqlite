<?php


//переменные для подключения
//логин - root
//паролдь - ''  //tckb gfhjkz ytn
// имя хоста -'localhost'
// название БД - 'shop_0753';

return new PDO('sqlite:shop_0753','','admin');

function d($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
//$login = 'root';
//$password ='';
//$host ='localhost';
//$db_name ='shop_0753';
//
//// создаем субъект подключения
//
////$pdo = new PDO("mysql:host=$host; dbname=$db_name",$login,$password);
//return new PDO("mysql:host=$host; dbname=$db_name",$login,$password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
//echo 'Подключение установлено!';
// переменные для подключения на хостинге
//$login = 'f0716665_ducha2112';
//$password = 'marina555';
//$host = 'localhost';
//$db_name = 'f0716665_test';
//
//// создаем объект подключения
//$pdo = new PDO("mysql:host=$host; dbname=$db_name", $login, $password);
//
//echo ' подключено';
//[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
// это подключаем в PDO 4м параметром и можно удалить PDO::FETCH_ASSOC в fetch


