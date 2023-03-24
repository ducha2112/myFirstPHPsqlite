<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация пользователей</title>
    <link rel="stylesheet" href="./Style/style_admin_news.css">


</head>
<body>
<h1>Редакция новостей</h1>
<button><a href="admin_news.php?add">Добавить новую новость</a></button>
<div class="link"><a href="admin.php">Редакция списка пользователей</a></div>
<div class="link_2"><a href="exit.php">Выход</a></div>

<?php
    $pdo = require 'db_connect.php';// подключение к бд


if($_SERVER['REQUEST_METHOD']=== 'POST') {

    if (empty($_FILES['file']['name'])) {
        $_FILES['file']['name'] = '';

    } else {
        $file = $_FILES['file']['name'];// имя файла 1

//    получаем временный путь

        $tmp_name = $_FILES['file']['tmp_name']; // временное имя 1 файла
        //перемещаем файл в папку с картинками
        move_uploaded_file($tmp_name, 'images/news/' . $_FILES['file']['size'] . '_' . $file);
        $news_image = 'images/news/' . $_FILES['file']['size'] . '_' . $file; //путь к файлу 1
    }
}

if( isset($_POST['action']) && $_POST['action'] === "Добавить" ){

    // проверим на пустые поля
    if( !empty($_POST['category']) &&
        !empty($_POST['title']) &&
        !empty($_POST['short_text']) &&
        !empty($_POST['textarea']) &&
        !empty($_POST['add_date'])&&
        !empty($_POST['author_id'])
    ){ // если НЕ пусто

        // экранирование

        $category = htmlspecialchars(trim($_POST['category']));
        $title = htmlspecialchars(trim($_POST['title']));
        $short_text = htmlspecialchars(trim($_POST['short_text']));
        $full_text = htmlspecialchars(trim($_POST['textarea']));
//        $news_image = htmlspecialchars(trim($_POST['news_image']));
        $add_date = htmlspecialchars(trim($_POST['add_date']));
        $author_id = htmlspecialchars(trim($_POST['author_id']));
//
        // запись в бд
        $query = "INSERT INTO news VALUES (null,'$category', '$title', '$short_text', '$full_text','$news_image','$add_date' , '$author_id')";
        $result = $pdo->query($query);
        header('Location: admin_news.php');

    }else{ // если не заполнено хотя бы одно поле
        echo '<h3 class="error">Заполните все поля!</h3>';
    }
}
?>
<div class="wrapper">

 <?php
    if( isset($_GET['add']) ){
        echo <<<_HTML_
                <div class="form">
                <h2>Добавление новости</h2>
                
                <form action="" method="POST"  enctype="multipart/form-data">
                
                        <label for="category">Категория темы</label>
                    <input type="text" name="category" value=""><br>
                              
                       <label for="title">Заголовок</label>
                    <input type="text" name="title" value=""><br>
                   
                     <label for="short_text">Короткий текст</label>
                    <input type="text" name="short_text" value=""><br>
                   
                    
                     <h4>Текст новости</h4>
                    <textarea  rows="10" cols="50" name="textarea" value=""></textarea><br>  
    
             
                     <label for="file">Добавить файл изображения</label>
                     <input type="file" name="file"><br>
                     
                      <label for="add_date">Дата  время добавления</label>
                    <input type="text" name="add_date" value=""><br>
                 
                       <label for="author_id">Идетификатор автора</label>
                    <input type="text" name="author_id" value=""><br> 
                   
                    
                    <input type="submit" name="action" value="Добавить">                                                           
                </form>
              </div>
_HTML_;
    }




    /**
     * удаление
     *
     */
    if( isset($_POST['action']) && $_POST['action'] === 'Удалить' ){
        //d($_POST);

        $id = (int)$_POST['id'];// идентификатор удаляемого пользователя
        // подготовленные запросы
        $query = "DELETE FROM news WHERE news.id = ?";
        $result = $pdo->prepare($query);// подготавливаем запрос
        $result->execute([$id]);// выполняем подготовленный запрос
        header('Location: admin_news.php');// перезагружаем страницу
    }


    /**
     * изменение данных пользователя
     *
     */
    if( isset($_POST['action']) && $_POST['action'] === 'Изменить' ){
        //d($_POST);
        $id = (int)$_POST['id'];

        // получаем данные о новостях для подстановки в форму
        $query = "SELECT news.id, category, title, short_text, full_text, news_image,add_date,author_id 
                        FROM news
                        WHERE id = ?";
        $result = $pdo->prepare($query); // PDOStatement
        $result->execute([$id]); // выполняет подготавлиемый запрос
        $news = $result->fetch();// $user - строка из бд с нужным пользователем


        echo <<<_HTML_
                
                <div class="form"> 
                <h2>Редактирование новости</h2>
                
                <form action="" method="POST">
                
                       <label for="title">Заголовок</label>
                    <input type="text" name="title" value="$news[title]"><br>
                
                    <label for="category">Категория темы</label>
                    <input type="text" name="category" value="$news[category]"><br>
                
                     <label for="short_text">Короткий текст</label>
                    <input type="text"  name="short_text" value="$news[short_text]"><br> 
                    
                     <h4>Текст новости</h4>
                    <textarea  rows="10" cols="50" name="textarea">$news[full_text]</textarea><br>  
                             
                   <label for="news_image">Путь к картинке</label>
                    <input type="text" name="news_image" value="$news[news_image]"><br>
                    
                     <img src="$news[news_image]" width="150"><br>
                    
                    <label for="add_date">Дата  время добавления</label>
                    <input type="text" name="add_date" value="$news[add_date]"><br>
                    
                    <label for="author_id">Идетификатор автора</label>
                    <input type="text" name="author_id" value="$news[author_id]"><br> 
                    
                    <label for="id">Идентификатор $news[id]</label><br>
                    
                    <input type="submit" name="action" value="Обновить">                                                           
                </form>
              </div>
_HTML_;

    }


    /**
     * запись измененных данных в бд
     * если нажата кнопка Обновить
     */
    if( isset($_POST['action']) && $_POST['action'] === 'Обновить' ){
        d($_POST);
        // проверим на пустые поля
        if( !empty($_POST['category']) &&
            !empty($_POST['title']) &&
            !empty($_POST['short_text']) &&
            !empty($_POST['textarea']) &&
            !empty($_POST['news_image'])&&
            !empty($_POST['add_date'])&&
            !empty($_POST['author_id'])
        ){ // если НЕ пусто

            // экранирование
            $category = htmlspecialchars(trim($_POST['category']));
            $title = htmlspecialchars(trim($_POST['title']));
            $short_text = htmlspecialchars(trim($_POST['short_text']));
            $full_text = htmlspecialchars(trim($_POST['textarea']));
            $news_image = htmlspecialchars(trim($_POST['news_image']));
            $add_date = htmlspecialchars(trim($_POST['add_date']));
            $author_id = htmlspecialchars(trim($_POST['author_id']));
            $id = (int)$_POST['id'];


//            // обновление в бд
            $query = "UPDATE news
                          SET category=?, title=?, short_text=?, full_text=?, news_image=?,add_date=?,author_id=?
                          WHERE news.id=?";
            $result = $pdo->prepare($query);
            $result->execute([$category, $title, $short_text, $full_text, $news_image, $add_date,$author_id,$id]);

            header('Location: admin_news.php');


        }else{ // если не заполнено хотя бы одно поле
            echo '<h3 class="error">Заполните все поля!</h3>';
        }

    }


    /**
     * вывод списка пользователей
     *
     */
    $query = "SELECT news.id, category, title, short_text, full_text, news_image,add_date,author_id,last_name
                    FROM authors, news
                    WHERE authors.id = author_id
                    ORDER BY add_date;";// текст запроса
    $result = $pdo->query($query);// выполняем запрос к бд
    //d($result);

    // выводим инфо о пользователях на страницу
    echo '<div class="wrap_news">';
    echo '<h2>Список всех новостей</h2>';

    //d($_GET);
    echo '<div class="container">';
    while( $news = $result->fetch() ){
        echo <<<_HTML_
                <div class="box">
                    <p>ID новости: <span>$news[id]</span></p>
                    <p>Тема: <span>$news[category]</span></p>
                    <p>Заголовок: <span>$news[title]</span></p>
                    <img src="$news[news_image]" width="100">
                    <p>Короткий текст: $news[short_text]</p>
                    <p>Путь к картинке: <span>$news[news_image]</span></p>
                    <p>Дата добаления: <span>$news[add_date]</span></p>
                    <p>Автор: <span>$news[last_name]</span></p>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="$news[id]">
<!--                        <input type="submit" name="action" value="Изменить">-->
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
