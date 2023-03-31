<?php
$pdo = require 'db_connect.php';
error_reporting(0);

if($_SERVER['REQUEST_METHOD'] === 'POST'){// если форма отправлена

    //d($_POST);

    list($errors, $input) = validate_form();

    if($errors){// если есть ошибки
        show_form($errors, $input); // показываем форму
    }else{ // если ош нет
        if($input['login'] == 'admin' & $input['password'] == 'admin2022'){
            header('Location: admin.php');
        }else{
        process_form($input);// регистрируем пользователя
        }
    }

}else{// если стр загружена впервые
    show_form(); // показываем форму
}


/**
 * проверка ввода
 */
function validate_form(){

    // массивы для ошибок и данных
    $errors = [];
    $input = [];

    // [login] [password]
    // экранируем
    $input['login'] = htmlspecialchars(trim($_POST['login']));
    $input['password'] = htmlspecialchars(trim($_POST['password']));


    /**
     * проверка полей ввода
     */
    // проверка логина
    function validate_login($login){

        $reg_exp = "/^[a-z][a-z0-9]{2,}$/i";

        // базовые проверки
        if(strlen($login) === 0){
            return 'Введите логин';
        } elseif( !preg_match($reg_exp, $login) ){
            return 'Только латинские буквы и цифры не менее 3 шт, должен начинаться с буквы';
        }

//         проверка по бд на соответствие логина
        $query = "SELECT login FROM users WHERE login = :login";
        $result = $GLOBALS['pdo']->prepare($query);
//        $result->bindParam(':login', $login);
        $result->execute(['login'=>$login]); // выполняем запрос
//        $sql = "SELECT login FROM users WHERE login = login";
//        $pdo =require 'db_connect.php';
//        $result = $pdo->query($sql);
//        $user = $result->fetch(PDO::FETCH_ASSOC);
      $result=$result->fetch(PDO::FETCH_ASSOC);

        d($result);


//        $rowCount = $result->rowCount();

        if( $result == false ){
            return 'Такой логин не зарегистрирован';
        }
    }
    $error_validate_login = validate_login($input['login']);
    if( $error_validate_login ){
        $errors['login'] = $error_validate_login;
    }


    // проверка пароля
    function validate_password($password, $login){

        if(strlen($password) === 0){
            return 'Введите пароль';
        }elseif (mb_strlen($password) < 8){
            return 'Пароль должен быть 8 и более символов';
        }

        // выборка пароля из бд
        $query = "SELECT password FROM users WHERE login = ?";
        $result = $GLOBALS['pdo']->prepare($query);
        $result->execute([$login]);

        $pass_db = $result->fetch();

        $hash = password_verify($password, $pass_db['password']);

        if(!$hash){
            return 'Пароль неверен';
        }
    }
    $error_validate_password = validate_password($input['password'], $input['login']);
    if($error_validate_password){
        $errors['password'] = $error_validate_password;
    }


    // возвращаем массивы с ошибками и данными
    return [$errors, $input];
}



/**
 *  старт сессии
 */
function process_form($input){
    // начинаем сессию
    session_start();
    $_SESSION['valid_user'] = $input['login'];

    header('Location: cabinet.php');

}




/**
 * отображение формы
 */
function show_form( $errors = [], $input = [] ){

    $fields = ['login', 'password'];

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
            <link rel="stylesheet" href="./Style/style_enter.css">
            
        </head>
        <body>
         
   <div class="wrap">
        <img src="./images/img_11.png">
    
    
      <section class="sec-2">
       <h1>Вход</h1>
      <div>
            <form action="" method="POST">
              <input type="text" name="login" id="logname" placeholder="Логин"
           value="$input[login]">
           <span  id="login-p">$errors[login]</span><br>
         
          <input type="text" name="password" id="pword" placeholder="Пароль"
          value="$input[password]">
          <span  id="pword-p">$errors[password]</span>
                <div class="in">
                <button type="submit">Войти </button>   
                <button><a href="register.php">Регистрация</a></button> 
                </div>
                                         
            </form>
            
          
      </div>
      <a href="index.php">На главную страницу</a>
       </section>
       
   </div>
         
          <script src="script.js"></script>  
        </body>
        </html>
_HTML_;

}
require './components/footer.php';
