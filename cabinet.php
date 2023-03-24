<?php

session_start();


$pdo = require 'db_connect.php';
$login = $_SESSION['valid_user'];

// запрос на выборку данных о пользователе
$query = "SELECT id,first_name,last_name, login, email, password FROM users WHERE login = ?;";
$result = $pdo->prepare($query);
$result->execute([$login]);

$user = $result->fetch();
 require './components/header2.php';
?>
    <link rel="stylesheet" href="./Style/style_cabinet.css">
    <main>
    <h1>Личный кабинет</h1>
    <div class="cab">
        <h2>Добро пожаловать,  <?php echo $user['first_name'].'  '. $user['last_name'];?> </h2>
        <p>Ваш id: <?php echo $user['id'];?></p>
        <p>Ваш логин: <?php echo $user['login'];?></p>
        <p>Электронная почта: <?php echo $user['email'];?></p>


    </div>
    </main>
</body>
</html>

<?php
require './components/footer2.php';
?>