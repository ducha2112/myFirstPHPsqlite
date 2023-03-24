<?php
include './components/header.php';
require './components/main.php';

$arr = [1,2];
foreach($arr as $item){
    echo <<<_HTML_
            <div class="tapiau_img">
                  <img src="./images/project/$item.jpg" width="1200">
            </div>
_HTML_;
}
?>
<section class="text">
        <a name="to"></a>
        <h2>Как попасть в проект</h2>
</section>
<?php
$arr = [3,4];
foreach($arr as $item){
    echo <<<_HTML_
            <div class="tapiau_img">
                  <img src="./images/project/$item.jpg" width="1200">
            </div>
_HTML_;
}
require './components/footer.php';