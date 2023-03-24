<?php

 require './components/header2.php';

 $arr = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,198,19,20,21,22,23];
 foreach($arr as $item){
     echo <<<_HTML_
            <div class="tapiau_img">
                  <img src="./images/Tapiau/$item.jpg" width="1200">
            </div>
_HTML_;

 }


require './components/footer2.php';