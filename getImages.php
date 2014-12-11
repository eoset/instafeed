<?php
require('instaLoop.php');

$instaLoop = new instaLoop;
$images = $instaLoop->run();
echo $images;

?>