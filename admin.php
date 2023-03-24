<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация пользователей</title>
    <link rel="stylesheet" href="./Style/style_admin.css">

</head>
<body>
<h1>Регистрация пользователей</h1>
<a href="phpliteadmin.php">Администрирование сайта</a>
<div class="link"><a href="admin_news.php">Редакция новостей</a></div>
<div class="link"><a href="exit.php">Выход</a></div>
<div class="wrapper">


    <?php
        $pdo = require 'db_connect.php';// подключение к бд

        /**
         * создание таблицы для юзеров
         * id, first_name, last_name, login, email, password
         */
//        $query = "CREATE TABLE IF NOT EXISTS users(
//            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//            first_name VARCHAR(255) NOT NULL,
//            last_name VARCHAR(255) NOT NULL,
//            login VARCHAR(255) NOT NULL,
//            email VARCHAR(255) NOT NULL,
//            password VARCHAR(255) NOT NULL
//        );";// текст запроса на создание табл
//        $pdo->exec($query);// создаем таблицу


        if( isset($_POST['action']) && $_POST['action'] === "Создать" ){

            // проверим на пустые поля
            if( !empty($_POST['first_name']) &&
                !empty($_POST['last_name']) &&
                !empty($_POST['login']) &&
                !empty($_POST['email']) &&
                !empty($_POST['password'])
            ){ // если НЕ пусто

                // экранирование
                $first_name = htmlspecialchars(trim($_POST['first_name']));
                $last_name = htmlspecialchars(trim($_POST['last_name']));
                $login = htmlspecialchars(trim($_POST['login']));
                $email = htmlspecialchars(trim($_POST['email']));
                $password = htmlspecialchars(trim($_POST['password']));
                $password= password_hash($password, PASSWORD_DEFAULT);
                // запись в бд
                $query = "INSERT INTO users VALUES (?,?,?,?,?,?)";
                $result = $pdo->prepare($query);// подготавливаем запрос
                $result->execute([null, $first_name, $last_name, $login, $email, $password]);
                header('Location: admin.php');

            }else{ // если не заполнено хотя бы одно поле
                echo '<h3 class="error">Заполните все поля!</h3>';
            }
        }
?>
    <div class="container">
<?php
    /**
     * добавление нового пользователя в таблицу
     * если нажата ссылка add - Добавить нового пользователя
     */
        if( isset($_GET['add']) ){
            //d($_GET);
            echo <<<_HTML_
               <div class="form">
                <h2>Добавить нового пользователя</h2>
                <form action="" method="POST">
                
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name"><br>
                
                    <label for="last_name">Фамилия</label>
                    <input type="text" name="last_name"><br>                

                    <label for="login">Логин</label>
                    <input type="text" name="login"><br>
                    
                    <label for="email">Емейл</label>
                    <input type="email" name="email"><br>
                    
                    <label for="password">Пароль</label>
                    <input type="password" name="password"><br> 
                    
                    <input type="submit" name="action" value="Создать">                                                           
                </form>
                </div>
_HTML_;

        }
        /**
         * если нажата кнопка Создать
         *




        /**
         * удаление пользователя
         *
         */
        if( isset($_POST['action']) && $_POST['action'] === 'Удалить' ){
            //d($_POST);

            $id = (int)$_POST['id'];// идентификатор удаляемого пользователя
            // подготовленные запросы
            $query = "DELETE FROM users WHERE id = ?";
            $result = $pdo->prepare($query);// подготавливаем запрос
            $result->execute([$id]);// выполняем подготовленный запрос
            header('Location: admin.php');// перезагружаем страницу
        }


        /**
         * изменение данных пользователя
         * если нажата кнопка Изменить
         */
        if( isset($_POST['action']) && $_POST['action'] === 'Изменить' ){
            //d($_POST);
            $id = (int)$_POST['id'];

            // получаем данные о пользователе для подстановки в форму
            $query = "SELECT id, first_name, last_name, login, email, password
                        FROM users
                        WHERE id = ?";
            $result = $pdo->prepare($query); // PDOStatement
            $result->execute([$id]); // выполняет подготавлиемый запрос
            $user = $result->fetch();// $user - строка из бд с нужным пользователем



            echo <<<_HTML_
                
                <div class="form"> 
                <h2>Редактирование данных пользователя</h2>
                <h2>Пользователь $user[first_name] $user[last_name]</h2>
                <form action="" method="POST">
                
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" value="$user[first_name]"><br>
                
                    <label for="last_name">Фамилия</label>
                    <input type="text" name="last_name" value="$user[last_name]"><br>                
                    <label for="login">Логин</label>
                    <input type="text" name="login" value="$user[login]"><br>
                    
                    <label for="email">Емейл</label>
                    <input type="email" name="email" value="$user[email]"><br>
                    
                    <label for="password">Пароль</label>
                    <input type="password" name="password" value="$user[password]"><br> 
                    
                    <label for="id">Идентификатор $user[id]</label>
                    <input type="hidden" name="id" value="$user[id]">
                    <input type="submit" name="action" value="Обновить">                                                           
                </form>
              </div>
_HTML_;

        }
?>
    </div>
<?php
/**
         * запись измененных данных в бд
         * если нажата кнопка Обновить
         */
        if( isset($_POST['action']) && $_POST['action'] === 'Обновить' ){

            // проверим на пустые поля
            if( !empty($_POST['first_name']) &&
                !empty($_POST['last_name']) &&
                !empty($_POST['login']) &&
                !empty($_POST['email']) &&
                !empty($_POST['password'])
            ){ // если НЕ пусто

                // экранирование
                $first_name = htmlspecialchars(trim($_POST['first_name']));
                $last_name = htmlspecialchars(trim($_POST['last_name']));
                $login = htmlspecialchars(trim($_POST['login']));
                $email = htmlspecialchars(trim($_POST['email']));
                $password = htmlspecialchars(trim($_POST['password']));
                $id = (int)$_POST['id'];

                // обновление в бд
                $query = "UPDATE users
                          SET first_name=?, last_name=?, login=?, email=?, password=?
                          WHERE id=?";
                $result = $pdo->prepare($query);
                $result->execute([$first_name, $last_name, $login, $email, $password, $id]);
                header('Location: admin.php');


            }else{ // если не заполнено хотя бы одно поле
                echo '<h3 class="error">Заполните все поля!</h3>';
            }

        }


        /**
         * вывод списка пользователей
         *
         */
        $query = "SELECT id, first_name, last_name, login, email
                    FROM users
                    ORDER BY first_name;";// текст запроса
        $result = $pdo->query($query);// выполняем запрос к бд
        //d($result);

        // выводим инфо о пользователях на страницу
    echo '<div class="wrap_user">';
        echo '<h2>Список всех пользователей</h2>';
        echo '<button><a href="admin.php?add">Добавить нового пользователя</a></button>';
        //d($_GET);
        echo '<div class="contain">';
        while( $user = $result->fetch() ){
            echo <<<_HTML_
                <div class="box">
                    <p>ID сотрудника: <span>$user[id]</span></p>
                    <p>Имя: <span>$user[first_name]</span></p>
                    <p>Фамилия: <span>$user[last_name]</span></p>
                    <p>Логин: <span>$user[login]</span></p>
                    <p>Email: <span>$user[email]</span></p>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="$user[id]">
                        <input type="submit" name="action" value="Изменить">
                        <input type="submit" name="action" value="Удалить">
                    </form>
                </div>
_HTML_;
        }
        echo '</div>';
    echo '</div>';
    ?>



</div>
</body>
</html>