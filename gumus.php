<?php

require './components/header2.php';

$arr = [1,2,3,4];
foreach($arr as $item){
    echo <<<_HTML_
            <div class="gumus_img">
                  <img src="./images/gumus/$item.jpg" width="1200">
            </div>
_HTML_;

}
require './components/footer2.php';