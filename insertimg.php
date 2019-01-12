<?php
    $base=$_POST['image'];
     $binary=base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
    $file = fopen($_POST['AUId'].'.jpg', 'wb');
    fwrite($file, $binary);
    fclose($file);
    echo 'Image upload complete!!, Please check your php file directory……';
?>