<?php


require './components/header2.php';
require './components/main.php';

$arr = [1,2];
foreach($arr as $item){
    echo <<<_HTML_
            <div class="tapiau_img">
                  <img src="./images/project/$item.jpg" width="1200">
            </div>
_HTML_;
}
require './components/footer2.php';