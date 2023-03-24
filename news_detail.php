<?php

// просмотр одной новости детально
$pdo = require 'db_connect.php';

//d($_GET);
$id = (int)$_GET['id'];// забираем из массива get идентификатор новости


// запрос на выбор данных о новости и об авторе детально

$sql= "SELECT news.id, category, title, full_text, news_image, add_date,first_name, last_name, avatar FROM news,authors WHERE news.author_id = authors.id AND news.id =$id";
$result = $pdo->prepare($sql);
$result->execute();
$news_data = $result->fetch(PDO::FETCH_ASSOC);
//d($news_data);

$news_data['full_text'] = str_replace("\r\n", '</p><p>', $news_data['full_text']);

$query = "SELECT * FROM news WHERE category = '$news_data[category]'";
$result = $pdo->query($query);
$category_news =$result->fetchAll();
//d($category_news );
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $news_data['title'] ?>></title>
    <style>
        .news_block{
            max-width: 1200px;
            background: aliceblue;
            margin: 0 auto;
            padding: 20px 50px;
            display: flex;
            gap: 20px;
        }
        .link a{
            font-size: 20px;
            color: #131a13;
            padding: 5px;
        }
        .news{
            width: 70%;
        }
        .news img{
            width: 100%;
        }
        .author{
            width: 30%;
            padding: 15px;
            border: 4px solid burlywood;
        }
        .author img{
            width: 150px
        }
        .category_news{
            max-width: 1200px;
            margin: 30px auto;
            background: #fad2b3;
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        h3{
            display: block;
            margin-left: 500px;
        }

    </style>
</head>
<body>
  <div class="news_block">
      <?php
      echo <<<_HTML_
              <div class="news">
<!-- новость -->
<h2>$news_data[title]</h2>
<img width="200" src="$news_data[news_image]" alt="$news_data[title]">
<p><span>Категория:</span> $news_data[category]</p>
<p>$news_data[full_text]</p>
<p><span>Дата публикации:</span> $news_data[add_date]</p>
<p><span>ID:</span> $news_data[id]</p>
</div>

               <div class="author">
              
             <img width="100" src="$news_data[avatar]" alt="$news_data[last_name]">  
              <p><span>Автор статьи:</span>  $news_data[first_name]  $news_data[last_name]</p>
                                          
               </div>
_HTML_;

      ?>

  </div>
  <div class="link">
    <a href="news.php">Перейти к списку новостей</a>
    <a href="user.php">Перейти на главную</a>
  </div>
  <h3>Новости на ту же тему</h3>
<div class="category_news ">

<!--    список статей этой же категориии, что и основная статья-->
    <?php
    foreach ($category_news as $news_item){
        echo "<div class = 'category_news_item'>";
          echo "<h4>$news_item[title]</h4>";
        echo "$news_item[short_text]";
"</div>";
    }
    ?>
</div>
</body>
</html>
