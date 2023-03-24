<?php
session_start();
error_reporting(0);
$pdo = require 'db_connect.php';
//var_dump($_SESSION);
if(!$_SESSION['valid_user']==''){
    header('Location: cabinet.php');
}else{
    $_SESSION['valid_user']=='';
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){// если форма отправлена

//    d($_POST);

    list($errors, $input) = validate_form();
    d($input);

    if($errors){// если есть ошибки
        show_form($errors, $input); // показываем форму
    }else{ // если ош нет
        process_form($input);// регистрируем пользователя
    }

}else{// если стр загружена впервые
    show_form(); // показываем форму
}


/**
 * вспомогательные функции
 */


/**
 * проверка ввода
 */
function validate_form(){

    // массивы для ошибок и данных
    $errors = [];
    $input = [];

    // [login] [email] [password]
    // экранируем
    $input['first_name'] = htmlspecialchars(trim($_POST['first_name']));
    $input['last_name'] = htmlspecialchars(trim($_POST['last_name']));
    $input['login'] = htmlspecialchars(trim($_POST['login']));
    $input['email'] = htmlspecialchars(trim($_POST['email']));
    $input['password'] = htmlspecialchars(trim($_POST['password']));

    /**
     * проверка полей ввода
     */
    // функция проверки имени

    function validate_first_name($first_name){
        $reg_exp ="/^[А-ЯЁ][а-яё]+$/u";
        if(empty($first_name)){
            return 'Введите имя';
        }elseif (mb_strlen($first_name)<=2){
            return 'Имя должно состоять не менее чем из 2 символов!';
        }elseif (!preg_match($reg_exp,$first_name)){

            return 'Имя должно состоять из русских букв и первая заглавная';
        }
    }

    $error_validate_first_name= validate_first_name($input['first_name']);// вызываем
    if ($error_validate_first_name){
        $errors['first_name'] =  $error_validate_first_name;
    }
//функция проверки фамилии
    function validate_last_name($last_name){
        $reg_exp = "/^[А-ЯЁ][а-яё]+$/u";

        if(empty($last_name)){ // проверим на пустоту
            return 'Введите фамилию'; // возвращаем строку, которую потом запишем в массив с ошибками
        }elseif(mb_strlen($last_name) < 2){ // если длина строки менее 2 символов иван
            return 'Фамилия должна состоять не меннее чем из двух символов!';
        }elseif(!preg_match($reg_exp, $last_name)){ // если строка НЕ соответствует рег выражению
            return 'Фамилия должна состоять только из русских букв, первая буква заглавная';
        }
    }
    $error_validate_last_name = validate_last_name($input['last_name']);;
    if ($error_validate_last_name){
        $errors['last_name'] =  $error_validate_last_name;
    }

    // проверка логина
    function validate_login($login){
        $reg_exp = "/^[a-z][a-z0-9]{2,}$/i";

        // базовые проверки
        if(strlen($login) === 0){
            return 'Введите логин';
        } elseif( !preg_match($reg_exp, $login) ){
            return 'Только латинские буквы и цифры не менее 3 шт, должен начинаться с буквы';
        }

        // проверка по бд на уникальность
        $query = "SELECT login FROM users WHERE login = :login";
        //$result = $pdo->prepare($query);// не работает из-за области видимости
        $result = $GLOBALS['pdo']->prepare($query);
//        $result->bindParam(':login', $login);
        $result->execute(['login'=> $login]); // выполняем запрос

//        $rowCount = $result->rowCount();
//        if( $rowCount > 0 ){
//            return 'Такой логин уже существует';
//        }

    }

    $error_validate_login = validate_login($input['login']);
    if( $error_validate_login ){
        $errors['login'] = $error_validate_login;
    }


    // проверка емейла
    function validate_email($email){
        $reg_exp = "/@/";

        if(strlen($email) === 0){
            return 'Введите адрес электронной почты';
        }elseif (!preg_match($reg_exp, $email)){
            return 'Адрес электронной почты введен в неверном формате';
        }

        // проверка по бд
        $query = "SELECT email FROM users WHERE email = :email";
        $result = $GLOBALS['pdo']->prepare($query);
//        $result->bindParam(':email', $email);
        $result->execute(['email'=> $email]); // выполняем запрос
   d($result);
//        $rowCount = $result->rowCount();
//        if( $rowCount > 0 ){
//            return 'Такой адрес уже существует';
//        }

    }

    $error_validate_email = validate_email($input['email']);
    if($error_validate_email){
        $errors['email'] = $error_validate_email;
    }

    // проверка пароля
    function validate_password($password){
        //$reg_exp = "/^.{8,}$/iu";

        if(strlen($password) === 0){
            return 'Введите пароль';
        }elseif (mb_strlen($password) < 8){
            return 'Пароль должен быть 8 и более символов';
        }
    }

    $error_validate_password = validate_password($input['password']);
    if($error_validate_password){
        $errors['password'] = $error_validate_password;
    }


    // возвращаем массивы с ошибками и данными
    return [$errors, $input];
}


/**
 * шифрование пароля, добавление данных в бд, старт сессии
 */
function process_form($input){

    // шифрование пароля
    $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);

    // добавление данных в бд
    $query = 'INSERT INTO "users" ("first_name","last_name","login", "email", "password") VALUES (:first_name,:last_name,:login,:email,:password);';
    $result = $GLOBALS['pdo']->prepare($query);
    $result->execute( ['first_name' =>$input['first_name'],'last_name'=>$input['last_name'],'login'=>$input['login'], 'email'=>$input['email'], 'password'=>$input['password'] ] );

    // старт сессии и запись данных в сессию
    session_start();// начинаем сессию
    $_SESSION['valid_user'] = $input['login'];// записываем в сессию логин пользователя
    header('Location: cabinet.php');
}


/**
 * отображение формы
 */
function show_form( $errors = [], $input = [] ){

    $fields = ['first_name','last_name','login', 'email', 'password'];

    foreach ($fields as $field){
        if( !isset($errors[$field]) ) $errors[$field] = '';
        if( !isset($input[$field]) ) $input[$field] = '';
    }

    echo <<<_HTML_
        <!doctype html>
        <html>
        <head>
            <meta charset="UTF-8">
            <link rel="icon" type="image/png" sizes="32x32" href="./images/лого.png">
            <title>Регистрация</title>
            <link rel="stylesheet" href="./Style/style_register.css">
            
        </head>
        <body>
          
   <div class="wrap">
        <img src="./images/img_11.png">
  
      <section class="sec-2">
      <h1>Регистрация</h1>
      <div>
        <form action="" method="POST">
          <input type="text" name="first_name" id="fname" placeholder="Имя" class="k"
          value="$input[first_name]"> 
          <span  id="fname-p">$errors[first_name]</span> <br>
          
          <input type="text" name="last_name" id="lname" placeholder="Фамилия "
          value="$input[last_name]"> 
          <span  id="lname-p">$errors[last_name]</span><br>
          
        
           <input type="text" name="login" id="logname" placeholder="Логин"
           value="$input[login]">
           <span  id="login-p">$errors[login]</span><br>
          
          <input type="email" name="email" id="emailname" placeholder="Email" 
          value="$input[email]"> 
          <span  id="email-p">$errors[email]</span><br>
          
          <input type="text" name="password" id="pword" placeholder="Пароль"
          value="$input[password]">
          <span  id="pword-p">$errors[password]</span>
         <div class="in">
          <button type="submit">Зарегистрироваться </button>
             <button><a href="enter.php">Вход</a></button>
          </div>
        </form>
        
      </div>
       </section>
   </div>
         
          <script src="script.js"></script>  
        </body>
        </html>

_HTML_;

}