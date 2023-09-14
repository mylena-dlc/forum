<?php

// $categories = $result["data"]['categories'];
$topics = $result["data"]['topics'];
    
?>

<h1>liste des topics</h1>




<?php
foreach($topics as $topic){

    ?>
    <p><?=$topic->getTitle()?></p>
    <?php
}


  
