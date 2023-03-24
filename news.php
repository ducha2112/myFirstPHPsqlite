<?php
//страница для отображения новостей
$pdo = require 'db_connect.php';

// id, category, title, short_text, news_image, add_date, author_id

$query = "SELECT news.id, category, title, short_text, news_image, add_date, last_name
FROM news, authors
WHERE author_id = authors.id
ORDER BY add_date DESC;";
$result =$pdo->query($query);
//d($result);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link rel="stylesheet" href="./Style/style_news.css">

</head>
<body>
<div class="top">
<h1>Новости</h1>
<a href="user.php">На главную страницу</a>
</div>
    <div class="news">
        <?php
        while ($news_item= $result->fetch()){

            echo <<<_HTML_
<div class="news_item">
<h2>$news_item[title]</h2>

<div class="news_preview">
<img class="news_images" src="$news_item[news_image]" alt="$news_item[title]">
<p><span> $news_item[short_text]</span></p>
</div>

<span>Дата: $news_item[add_date]</span>
<span>Автор: $news_item[last_name]</span>
<span>Категория: $news_item[category]</span>



<a href="news_detail.php?id=$news_item[id]">Подробнее...</a>

</div>
_HTML_;

        }
   ?>
        <a href="user.php">На главную</a>
    </div>
</head><

</body>
</html>
